<?php

namespace alvin\phpmvc;

class Request {
	public $route;
	public $params;
	public $inputs;
	public $body;
	public $method;

	public function __construct() {
		$this->setParams();
		$this->setBody();
		$this->setRoute();
		$this->method = $_SERVER['REQUEST_METHOD'];
	}
	public function setParams() {
		$params = [];
		array_key_exists('QUERY_STRING', $_SERVER, ) && parse_str($_SERVER['QUERY_STRING'], $params);

		foreach ($params as $key => $value) {
			$params[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
		}
		$this->params = $params;
	}
	public function setBody() {
		$data = [];
		if ($this->isGet()) {
			foreach ($_GET as $key => $value) {
				$data[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
			}
		}
		if ($this->isPost()) {
			foreach ($_POST as $key => $value) {
				$data[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
			}
		}
		foreach ($_FILES as $key => $value) {
			$data[$key] = $value;
			$fileName = $_FILES[$key]['name'];
			$fileNameArray = explode(".", $fileName);
			$fileExt = strtolower(end($fileNameArray));
			$data[$key]['ext'] = $fileExt;
		}
		unset($data['submit']);
		$this->inputs = $data;
		unset($data['_csrf']);
		$this->body = $data;
	}
	public function setRoute() {
		$route = $_SERVER['REQUEST_URI'];
		$queryPos = strpos($route, '?');

		if ($queryPos !== false) {
			$route = substr($route, 0, $queryPos);
		}
		$this->route = $route;
	}
	public function isGet() {
		return $this->getMethod() === 'get';
	}
	public function isPost() {
		return $this->getMethod() === 'post';
	}
	public function getMethod() {
		return strtolower($_SERVER['REQUEST_METHOD']);
	}
	public function getBody() {
		return $this->body;
	}
	public function getRoute() {
		return $this->route;
	}
	public function input($key) {
		return $this->inputs[$key] ?? false;
	}
	public function query(string $key) {
		return $this->params[$key] ?? false;
	}
	public function getCookie(string $key) {
		return $_COOKIE[$key] ?? null;
	}
	public function body($associative = true, int $flags = 0, int $depth = 512) {
		$body = file_get_contents("php://input");
		$object = json_decode($body, $associative, $depth, $flags);
		return $object;
	}
}
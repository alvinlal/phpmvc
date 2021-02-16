<?php

namespace app\core;

class Request {
	public $params;
	public $body;
	public $method;
	public $cookie;
	public $POST;

	public function __construct() {
		$this->setParams();
		$this->POST = $_POST;
		$this->method = $_SERVER['REQUEST_METHOD'];
		$this->cookie = $_COOKIE;
	}
	public function setParams() {
		$params = [];
		array_key_exists('QUERY_STRING', $_SERVER, ) && parse_str($_SERVER['QUERY_STRING'], $params);

		foreach ($params as $key => $value) {
			$params[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
		}
		$this->params = $params;
	}
	public function getMethod() {
		return strtolower($_SERVER['REQUEST_METHOD']);
	}
	public function isGet() {
		return $this->getMethod() === 'get';
	}
	public function isPost() {
		return $this->getMethod() === 'post';
	}
	public function getRoute() {
		$route = $_SERVER['REQUEST_URI'];
		$queryPos = strpos($route, '?');

		if ($queryPos !== false) {
			$route = substr($route, 0, $queryPos);
		}
		return $route;
	}
	public function getBody() {
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
		unset($data['submit']);
		return $data;
	}
	public function getCookie(string $key) {
		return $this->cookie[$key] ?? null;
	}
	public function body($associative = true, int $flags = 0, int $depth = 512) {
		$body = file_get_contents("php://input");
		$object = json_decode($body, $associative, $depth, $flags);
		return $object;
	}
}
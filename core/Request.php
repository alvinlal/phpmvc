<?php

namespace app\core;

class Request {
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

		return $data;
	}
}
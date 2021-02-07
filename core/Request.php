<?php

namespace app\core;

class Request {
	public function getMethod() {
		return strtolower($_SERVER['REQUEST_METHOD']);
	}
	public function getRoute() {
		$route = $_SERVER['REQUEST_URI'];
		$queryPos = strpos($route, '?');

		if ($queryPos !== false) {
			$route = substr($route, 0, $queryPos);
		}
		return $route;
	}
}
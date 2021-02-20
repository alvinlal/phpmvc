<?php

namespace app\core;

class Middleware {
	public $start;
	public array $middlewares;
	public function __construct() {
		$this->start = function () {
			// dump("last middleware");
		};
	}
	public function add($middleware) {
		$this->middlewares[] = $middleware;
	}
	public function setStart() {

		for ($i = sizeof($this->middlewares) - 1; $i >= 0; $i--) {
			$next = $this->start;
			$this->start = function () use ($i, $next) {
				return $this->middlewares[$i](Application::$app->request, Application::$app->response, $next);
			};
		}
	}
	public function resolve() {
		$this->setStart();
		return call_user_func($this->start);
	}
}
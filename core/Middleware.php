<?php

namespace app\core;
use app\core\Application;

class Middleware {
	public $start;

	public function __construct() {
		$this->start = function () {
			dump('start middleware');
		};
	}
	public function add($middleware) {
		$next = $this->start;

		$this->start = function () use ($middleware, $next) {
			return $middleware(Application::$app->request, Application::$app->response, $next);
		};
	}
	public function resolve() {
		return call_user_func($this->start);
	}
}
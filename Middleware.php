<?php

namespace alvin\phpmvc;

/**
 * Class for registering middlewares
 */
class Middleware {
	/**
	 * The first middleware to execute
	 * @var callable
	 */
	public $start;

	/**
	 * Array of middlewares for constructing the start function
	 */
	public array $middlewares;

	/**
	 * Creates middleware instance and sets initial value of start.
	 */
	public function __construct() {
		$this->middlewares = [];
		$this->start = function () {};
	}

	/**
	 * Add a middleware
	 *
	 * Pushes a middleware to the middleware array
	 * @param \alvin\phpmvc\Middleware $middleware Middleware instance to add
	 * @return void
	 */
	public function add($middleware) {
		$this->middlewares[] = $middleware;
	}

	/**
	 * Sets reference to first middleware to execute.
	 *
	 * Loops over the middleware array and sets each middlewares arguments including next()
	 *
	 * @return void
	 */
	public function setStart() {
		for ($i = sizeof($this->middlewares) - 1; $i >= 0; $i--) {
			$next = $this->start;
			$this->start = function () use ($i, $next) {
				return $this->middlewares[$i](Application::$app->request, Application::$app->response, $next);
			};
		}
	}

	/**
	 * Calls the first middleware.
	 *
	 * @return void
	 */
	public function resolve() {
		$this->setStart();
		return call_user_func($this->start);
	}
}
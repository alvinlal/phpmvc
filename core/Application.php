<?php

namespace app\core;
use app\core\Request;

/**
 *  Class Application
 *
 *  Used to instantiate main application object which will hold all the
 *  necessary resources
 *
 */
class Application {

	/**
	 * Used to hold all routes with corresponding http verbs and callbacks
	 * @var array
	 */
	private static array $routesAndCallbacks = [];

	public Request $request;

	public function __construct() {
		$this->request = new Request();

	}

	public static function get(string $route, $callback) {
		self::$routesAndCallbacks['get'][$route] = $callback;
	}

	public static function post(string $route, $callback) {
		self::$routesAndCallbacks['post'][$route] = $callback;
	}

	/**
	 * run
	 * gets the http verb (method) and url of the request and executes
	 * the corresponding callback
	 */

	public function run() {
		$httpMethod = $this->request->getMethod();
		$route = $this->request->getRoute();

		self::$routesAndCallbacks[$httpMethod][$route]();
	}

}
<?php

namespace app\core;
use app\core\Request;
use app\core\View;

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
	private array $routesAndCallbacks = [];

	public static Application $app;
	public Request $request;
	public View $view;

	public function __construct() {
		$this->request = new Request();
		$this->view = new View();
		self::$app = $this;
	}

	public function get(string $route, $callback) {
		$this->routesAndCallbacks['get'][$route] = $callback;
	}

	public function post(string $route, $callback) {
		$this->routesAndCallbacks['post'][$route] = $callback;
	}

	/**
	 * run
	 * gets the http verb (method) and url of the request and executes
	 * the corresponding callback
	 */

	public function run() {
		$httpMethod = $this->request->getMethod();
		$route = $this->request->getRoute();
		$callback = $this->routesAndCallbacks[$httpMethod][$route];

		if (is_array($callback)) {
			$controller = new $callback[0];
			// call_user_func(array($controller, $callback[1]));
			echo $controller->{$callback[1]}();

		} else if (is_string($callback)) {
			return $this->view->renderView($callback);
		}

	}

}
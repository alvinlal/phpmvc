<?php

namespace app\core;
use app\core\Request;
use app\core\Response;
use app\core\View;

class Application {

	private array $routesAndCallbacks = [];

	public static Application $app;
	public Request $request;
	public Response $response;
	public View $view;

	public function __construct() {
		$this->request = new Request();
		$this->response = new Response();
		$this->view = new View();
		self::$app = $this;
	}

	public function get(string $route, $callback) {
		$this->routesAndCallbacks['get'][$route] = $callback;
	}

	public function post(string $route, $callback) {
		$this->routesAndCallbacks['post'][$route] = $callback;
	}

	public function run() {
		$httpMethod = $this->request->getMethod();
		$route = $this->request->getRoute();
		$callback = $this->routesAndCallbacks[$httpMethod][$route];

		if (is_array($callback)) {
			$controller = new $callback[0];
			// call_user_func(array($controller, $callback[1]));
			echo $controller->{$callback[1]}($this->request, $this->response);

		} else if (is_string($callback)) {
			echo $this->view->renderViewOnly($callback);
		}

	}

}
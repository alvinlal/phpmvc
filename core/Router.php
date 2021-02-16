<?php

namespace app\core;
use app\core\Application;
use app\core\exception\RouteNotFoundException;

class Router {
	private array $routesAndCallbacks = [];

	public function get(string $route, $callback) {
		$this->routesAndCallbacks['get'][$route] = $callback;
	}

	public function post(string $route, $callback) {
		$this->routesAndCallbacks['post'][$route] = $callback;
	}
	public function resolve() {
		try {
			$httpMethod = Application::$app->request->getMethod();
			$route = Application::$app->request->getRoute();
			$callback = $this->routesAndCallbacks[$httpMethod][$route] ?? false;
			if (!$callback) {
				throw new RouteNotFoundException();
			}

			if (is_array($callback)) {
				$controller = new $callback[0];
				echo $controller->{$callback[1]}(Application::$app->request, Application::$app->response);

			} else if (is_string($callback)) {
				echo Application::$app->view->renderViewOnly($callback);
			}
		} catch (RouteNotFoundException $e) {
			Application::$app->response->statusCode(404);
			echo $e->getMessage();
		}
	}
}
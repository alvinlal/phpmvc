<?php

namespace app\core;
use app\core\Application;
use app\core\exception\RouteNotFoundException;

class Router {
	private array $routeMap = [];
	public string $currentRoute;
	public string $currentMethod;

	public function get(string $route, $callback) {
		$regexRoute = $this->convertToRegex($route);
		$this->currentRoute = $regexRoute;
		$this->currentMethod = 'get';
		$this->routeMap['get'][$regexRoute]['callbackArray'] = $callback;
		$this->routeMap['get'][$regexRoute]['middlewares'] = new Middleware();

	}

	public function post(string $route, $callback) {
		$regexRoute = $this->convertToRegex($route);
		$this->currentRoute = $regexRoute;
		$this->currentMethod = 'post';
		$this->routeMap['post'][$regexRoute]['callbackArray'] = $callback;
		$this->routeMap['post'][$regexRoute]['middlewares'] = new Middleware();

	}

	public function setRouteMiddleware($middleware) {
		$this->routeMap[$this->currentMethod][$this->currentRoute]['middlewares']->add($middleware);
	}

	public function convertToRegex(string $route) {
		$route = str_replace('/', '\/', $route);
		$route = preg_replace('/{[a-zA-Z0-9]+}/', '([a-zA-Z0-9]+)', $route);
		return $route;
	}

	public function getResults(string $httpMethod, string $route) {
		$middlewareContent = '';
		$callbackArray = [];
		$args = [Application::$app->request, Application::$app->response];
		$params = [];
		foreach ($this->routeMap[$httpMethod] as $regexRoute => $valueArray) {
			if (preg_match("/^$regexRoute$/", $route)) {
				$middlewareContent = $valueArray['middlewares']->resolve();
				$callbackArray = $valueArray['callbackArray'];
				preg_match_all("/^$regexRoute$/", $route, $params, PREG_SET_ORDER);
				break;
			}
		}
		if (sizeof($params) == 1) {
			array_shift($params[0]);
			return [$middlewareContent, $callbackArray, [...$args, ...$params[0]]];
		}
		return [$middlewareContent, $callbackArray, [...$args]];
	}

	public function resolve() {
		try {
			$callbackArray = [];
			$args = [];
			$middlewareContent = '';
			$httpMethod = Application::$app->request->getMethod();
			$route = Application::$app->request->getRoute();
			list($middlewareContent, $callbackArray, $args) = $this->getResults($httpMethod, $route);
			echo $middlewareContent;
			if (!$callbackArray) {
				throw new RouteNotFoundException();
			}

			if (is_array($callbackArray)) {
				$controller = new $callbackArray[0];
				echo call_user_func_array(array($controller, $callbackArray[1]), $args);
			} else if (is_string($callbackArray)) {
				echo Application::$app->view->renderViewOnly($callbackArray);
			}
		} catch (RouteNotFoundException $e) {
			Application::$app->response->statusCode(404);
			echo $e->getMessage();
		}
	}

}
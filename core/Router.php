<?php

namespace app\core;
use app\core\Application;
use app\core\exception\RouteNotFoundException;

class Router {
	private array $routeMap = [];
	public string $currentRoute;
	public string $currentMethod;

	public function get(string $route, $resolvable) {
		$regexRoute = $this->convertToRegex($route);
		$this->currentRoute = $regexRoute;
		$this->currentMethod = 'get';
		$this->routeMap['get'][$regexRoute]['resolvable'] = $resolvable;
		$this->routeMap['get'][$regexRoute]['middlewares'] = new Middleware();

	}

	public function post(string $route, $resolvable) {
		$regexRoute = $this->convertToRegex($route);
		$this->currentRoute = $regexRoute;
		$this->currentMethod = 'post';
		$this->routeMap['post'][$regexRoute]['resolvable'] = $resolvable;
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
		$resolvable = [];
		$args = [Application::$app->request, Application::$app->response];
		$params = [];
		foreach ($this->routeMap[$httpMethod] as $regexRoute => $valueArray) {
			if (preg_match("/^$regexRoute$/", $route)) {
				$middlewareContent = $valueArray['middlewares']->resolve();
				$resolvable = $valueArray['resolvable'];
				preg_match_all("/^$regexRoute$/", $route, $params, PREG_SET_ORDER);
				break;
			}
		}
		if (sizeof($params) == 1) {
			array_shift($params[0]);
			return [$middlewareContent, $resolvable, [...$args, ...$params[0]]];
		}
		return [$middlewareContent, $resolvable, [...$args]];
	}

	public function resolve() {
		try {
			$resolvable = [];
			$args = [];
			$middlewareContent = '';
			$httpMethod = Application::$app->request->getMethod();
			$route = Application::$app->request->getRoute();
			list($middlewareContent, $resolvable, $args) = $this->getResults($httpMethod, $route);
			echo $middlewareContent;
			if (!$resolvable) {
				throw new RouteNotFoundException();
			}

			if (is_array($resolvable)) {
				$controller = new $resolvable[0];
				echo call_user_func_array(array($controller, $resolvable[1]), $args);
			} else if (is_string($resolvable)) {
				echo Application::$app->view->renderViewOnly($resolvable);
			}
		} catch (RouteNotFoundException $e) {
			Application::$app->response->statusCode(404);
			echo $e->getMessage();
		}
	}

}
<?php

namespace app\core;
use app\core\Application;
use app\core\exception\RouteNotFoundException;

class Router {
	private array $routesAndCallbacks = [];

	public function get(string $route, $callback) {
		if (preg_match('/{[a-zA-Z0-9_]+}/', $route)) {
			$regexRoute = $this->convertToRegex($route);
			$this->routesAndCallbacks['get'][$regexRoute] = $callback;
		} else {
			$route = str_replace('/', '\/', $route);
			$this->routesAndCallbacks['get'][$route] = $callback;
		}
	}

	public function post(string $route, $callback) {
		if (preg_match('/{[a-zA-Z0-9_]+}/', $route)) {
			$regexRoute = $this->convertToRegex($route);
			$this->routesAndCallbacks['post'][$regexRoute] = $callback;
		} else {
			$route = str_replace('/', '\/', $route);
			$this->routesAndCallbacks['post'][$route] = $callback;
		}
	}

	public function getArgs(array $params) {
		return [Application::$app->request, Application::$app->response, ...$params];
	}

	public function resolveCallback(string $httpMethod, string $route) {
		$callbackArray = [];
		$params = [];
		foreach ($this->routesAndCallbacks[$httpMethod] as $regexRoute => $value) {
			if (preg_match("/^$regexRoute$/", $route)) {
				$callbackArray = $value;
				preg_match_all("/^$regexRoute$/", $route, $params, PREG_SET_ORDER);
				break;
			}
		}
		if (sizeof($params) == 1) {
			array_shift($params[0]);
			return [$callbackArray, $params[0]];
		}
		return [$callbackArray, $params];
	}

	public function convertToRegex(string $route) {
		$convertedRoute = str_replace('/', '\/', $route);
		$convertedRoute = preg_replace('/{[a-zA-Z0-9]+}/', '([a-zA-Z0-9]+)', $convertedRoute);
		return $convertedRoute;
	}

	public function resolve() {
		try {
			$callbackArray = [];
			$params = [];
			$httpMethod = Application::$app->request->getMethod();
			$route = Application::$app->request->getRoute();
			list($callbackArray, $params) = $this->resolveCallback($httpMethod, $route);
			// echo '<pre>';
			// var_dump($params);
			// echo '</pre>';
			if (!$callbackArray) {
				throw new RouteNotFoundException();
			}

			if (is_array($callbackArray)) {
				$controller = new $callbackArray[0];
				$args = $this->getArgs($params);
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
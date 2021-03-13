<?php

namespace alvin\phpmvc;

use alvin\phpmvc\exception\RouteNotFoundException;
/**
 * Router class
 */
class Router {

	/**
	 * Object for holding routes and corresponding callback and middlewares
	 * @var object
	 */
	private array $routeMap = [];

	/**
	 * Current route
	 * @var string
	 */
	public string $currentRoute;

	/**
	 * Current method
	 * @var string
	 */
	public string $currentMethod;

	/**
	 * Set callback and middlewares for get method.
	 *
	 * @param string $route The route to set
	 * @param string[]|string $resolvable callback or view to handle
	 * @return void
	 */
	public function get(string $route, $resolvable) {
		$regexRoute = $this->convertToRegex($route);
		$this->currentRoute = $regexRoute;
		$this->currentMethod = 'get';
		$this->routeMap['get'][$regexRoute]['resolvable'] = $resolvable;
		$this->routeMap['get'][$regexRoute]['middlewares'] = new Middleware();
	}

	/**
	 * Set callback and middlewares for post method.
	 *
	 * @param string $route The route to set
	 * @param string[]|string $resolvable callback or view to handle
	 * @return void
	 */
	public function post(string $route, $resolvable) {
		$regexRoute = $this->convertToRegex($route);
		$this->currentRoute = $regexRoute;
		$this->currentMethod = 'post';
		$this->routeMap['post'][$regexRoute]['resolvable'] = $resolvable;
		$this->routeMap['post'][$regexRoute]['middlewares'] = new Middleware();
	}

	/**
	 * Set middleware for a route.
	 *
	 * @param object $middleware instance of alvin\phpmvc\Middleware
	 * @return void
	 */
	public function setRouteMiddleware($middleware) {
		$this->routeMap[$this->currentMethod][$this->currentRoute]['middlewares']->add($middleware);
	}

	/**
	 * Convert a route to regex for storing in routemap.
	 *
	 * @param string $route The route to convert
	 * @return string regex
	 */
	public function convertToRegex(string $route) {
		$route = str_replace('/', '\/', $route);
		$route = preg_replace('/{[a-zA-Z0-9]+}/', '([a-zA-Z0-9]+)', $route);
		return $route;
	}

	/**
	 * Returns middlewares, callback and its argument.
	 *
	 * @param string $httpMethod Current http method
	 * @param string $route Current route
	 * @return array array containing middlewarecontent, if any, callback function and its arguments
	 */
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

	/**
	 * Runs middlewares,callback corresponding to current route.
	 * @return void
	 */
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
				exit();
			}
			if (is_array($resolvable)) {
				$controller = new $resolvable[0];
				echo call_user_func_array(array($controller, $resolvable[1]), $args);
				exit();
			} else if (is_string($resolvable)) {
				echo Application::$app->view->renderViewOnly($resolvable);
				exit();
			}
		} catch (RouteNotFoundException $e) {
			Application::$app->response->statusCode(404);
			echo $e->getMessage();
			exit();
		}
	}
}
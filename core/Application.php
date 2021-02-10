<?php
namespace app\core;
use app\core\exception\RouteNotFoundException;
use app\core\Request;
use app\core\Response;
use app\core\View;
use InvalidArgumentException;

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
		$this->checkInput($route, $callback);
		$this->routesAndCallbacks['get'][$route] = $callback;
	}

	public function post(string $route, $callback) {
		$this->checkInput($route, $callback);
		$this->routesAndCallbacks['post'][$route] = $callback;
	}

	public function run() {
		try {
			$httpMethod = $this->request->getMethod();
			$route = $this->request->getRoute();
			$callback = $this->routesAndCallbacks[$httpMethod][$route] ?? false;
			if (!$callback) {
				throw new RouteNotFoundException();
			}

			if (is_array($callback)) {
				$controller = new $callback[0];
				if (!method_exists($controller, $callback[1])) {
					throw new InvalidArgumentException("method $callback[1] doesn't exists on class " . get_class($controller));
				}
				echo $controller->{$callback[1]}($this->request, $this->response);

			} else if (is_string($callback)) {
				echo $this->view->renderViewOnly($callback);
			}
		} catch (RouteNotFoundException $e) {
			$this->response->statusCode(404);
			echo $e->getMessage();
		}

	}

	private function checkInput($route, $callback) {
		if (strpos($route, '/') !== 0) {
			throw new InvalidArgumentException("The route should begin with a '/', $route given");
		} else if (is_string($callback)) {
			return;
		} else if (is_array($callback)) {
			if (sizeof($callback) !== 2) {
				throw new InvalidArgumentException("The array should contain exactly 2 elements");
			}
			if (!class_exists($callback[0])) {
				throw new InvalidArgumentException("class $callback[0] doesn't exist");
			}
			if (!is_string($callback[1])) {
				throw new InvalidArgumentException("second element in the array should be a string, " . gettype($callback[1]) . " give");
			}
			return;
		} else {
			throw new InvalidArgumentException("second argument should be an array containing a classname and method name or a string");
		}
	}

}
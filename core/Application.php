<?php
namespace app\core;
use app\core\Middleware;
use app\core\Request;
use app\core\Response;
use app\core\Router;
use app\core\Session;
use app\core\View;
use InvalidArgumentException;

class Application {
	public static Application $app;
	public Router $router;
	public Session $session;
	public Request $request;
	public Response $response;
	public View $view;
	public Middleware $middleware;

	public function __construct() {
		$this->router = new Router();
		$this->request = new Request();
		$this->response = new Response();
		$this->session = new Session();
		$this->view = new View();
		$this->middleware = new Middleware();
		self::$app = $this;
	}
	public function use ($middleware) {
		$this->middleware->add($middleware);
	}
	public function middleware($middleware) {
		$this->router->setRouteMiddleware($middleware);
	}

	public function get(string $route, $callback) {
		$this->checkInput($route, $callback);
		$this->router->get($route, $callback);
		return self::$app;
	}

	public function post(string $route, $callback) {
		$this->checkInput($route, $callback);
		$this->router->post($route, $callback);
		return self::$app;
	}

	public function run() {
		$this->middleware->resolve();
		$this->router->resolve();
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
			if (!is_string($callback[1])) {
				throw new InvalidArgumentException("second element in the array should be a string, " . gettype($callback[1]) . " give");
			}
			return;
		} else {
			throw new InvalidArgumentException("second argument should be an array containing a classname and method name or a string");
		}
	}

}
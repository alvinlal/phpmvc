<?php
namespace app\core;
use app\core\View;
use app\core\Router;
use app\core\Request;
use app\core\Session;
use app\core\Response;
use app\core\Middleware;
use app\core\FileStorage;
use app\core\ErrorHandler;
use app\core\ExceptionHandler;
use InvalidArgumentException;

class Application {
	public static Application $app;
	public static string $rootDir;
	public Router $router;
	public Session $session;
	public Request $request;
	public Response $response;
	public View $view;
	public FileStorage $fileStorage;
	public Middleware $middleware;

	public function __construct(string $rootDir) {
		$this->setErrorHandlers();
		self::$rootDir = $rootDir;
		$this->router = new Router();
		$this->request = new Request();
		$this->response = new Response();
		$this->session = new Session();
		$this->view = new View();
		$this->middleware = new Middleware();
		$this->fileStorage = new FileStorage();
		self::$app = $this;
	}
	public function setErrorHandlers() {
		if (getenv("ENV") == "development" || !getenv("ENV")) {
			set_exception_handler([ExceptionHandler::class, 'handle']);
			set_error_handler([ErrorHandler::class, 'handle']);
		}
	}
	public function use ($middleware) {
		$this->middleware->add($middleware);
	}
	public function middleware($middleware) {
		$this->router->setRouteMiddleware($middleware);
	}

	public function get(string $route, $resolvable) {
		$this->checkInput($route, $resolvable);
		$this->router->get($route, $resolvable);
		return self::$app;
	}

	public function post(string $route, $resolvable) {
		$this->checkInput($route, $resolvable);
		$this->router->post($route, $resolvable);
		return self::$app;
	}

	public function run() {
		$this->middleware->resolve();
		$this->router->resolve();
	}

	private function checkInput($route, $resolvable) {
		if (strpos($route, '/') !== 0) {
			throw new InvalidArgumentException("The route should begin with a '/', $route given");
		} else if (is_string($resolvable)) {
			return;
		} else if (is_array($resolvable)) {
			if (sizeof($resolvable) !== 2) {
				throw new InvalidArgumentException("The array should contain exactly 2 elements");
			}
			if (!is_string($resolvable[1])) {
				throw new InvalidArgumentException("second element in the array should be a string, " . gettype($resolvable[1]) . " given");
			}
			return;
		} else {
			throw new InvalidArgumentException("second argument should be an array containing a classname and method name or a name of view");
		}
	}

}
<?php

namespace alvin\phpmvc;

/**
 * Core Application class.
 */
class Application {

	/**
	 *  Application instance.
	 * @var alvin\phpmvc\Application
	 */
	public static Application $app;

	/**
	 * Root directory of application.
	 * @var string
	 */
	public  ? string $rootDir = null;

	/**
	 * Router instance.
	 * @var alvin\phpmvc\Router
	 */
	public Router $router;

	/**
	 * Session instance.
	 * @var alvin\phpmvc\Session
	 */
	public Session $session;

	/**
	 * Request instance.
	 * @var alvin\phpmvc\Request
	 */
	public Request $request;

	/**
	 * Response instance.
	 * @var alvin\phpmvc\Response
	 */
	public Response $response;

	/**
	 * View instance
	 * @var alvin\phpmvc\View
	 */
	public View $view;

	/**
	 * FileStorage instance.
	 * @var alvin\phpmvc\FileStorage
	 */
	public FileStorage $fileStorage;

	/**
	 * Middleware instance.
	 * @var alvin\phpmvc\Middleware
	 */
	public Middleware $middleware;

	/**
	 * Creates a new Application instance.
	 *
	 * @param string $rootDir Root directory of the application
	 */
	public function __construct(string $rootDir) {
		$this->setErrorHandlers();
		$this->rootDir = $rootDir;
		$this->router = new Router();
		$this->request = new Request();
		$this->response = new Response();
		$this->session = new Session();
		$this->view = new View();
		$this->middleware = new Middleware();
		$this->fileStorage = new FileStorage();
		self::$app = $this;
	}

	/**
	 * Set global error handler and exception handler.
	 *
	 * Used for displaying the error on browser while in development mode
	 *
	 * @return void
	 */
	public function setErrorHandlers() {
		if (getenv("ENV") == "development" || !getenv("ENV")) {
			set_exception_handler([ExceptionHandler::class, 'handle']);
			set_error_handler([ErrorHandler::class, 'handle']);
		}
	}

	/**
	 * Set global middlewares.
	 *
	 * Used for registering middlewares that runs on every request
	 *
	 * @param object $middleware
	 * @return void
	 */
	public function use ($middleware) {
		$this->middleware->add($middleware);
	}

	/**
	 * Set route level middlewares.
	 *
	 * Used for registering middlewares that runs only on specified routes
	 *
	 * @param object $middleware
	 * @return void
	 */
	public function middleware($middleware) {
		$this->router->setRouteMiddleware($middleware);
	}

	/**
	 * Set controllers for get request.
	 *
	 * Used for specifying controllers for get requests on a particular route
	 *
	 * @param string $route The route to be handled
	 * @param string[]|string $resolvable An array with first element as class name and second element as the method to invoke or string as name of html view to render
	 * @return alvin\phpmvc\Application
	 */
	public function get(string $route, $resolvable) {
		$this->checkInput($route, $resolvable);
		$this->router->get($route, $resolvable);
		return self::$app;
	}

	/**
	 * Set controllers for post request.
	 *
	 * Used for specifying controllers for post requests on a particular route
	 *
	 * @param string $route The route to be handled
	 * @param string[]|string $resolvable An array with first element as class name and second element as the method to invoke or string as name of html view to render
	 * @return alvin\phpmvc\Application
	 */
	public function post(string $route, $resolvable) {
		$this->checkInput($route, $resolvable);
		$this->router->post($route, $resolvable);
		return self::$app;
	}

	/**
	 * Run application.
	 *
	 * Invokes all registered middlewares and then runs controller specified for current route
	 * @return void
	 */
	public function run() {
		$this->middleware->resolve();
		$this->router->resolve();
	}

	/**
	 * Checks input.
	 *
	 * check for any errors in args for get and post
	 *
	 * @param string $route
	 * @param string[]|string $resolvable
	 * @return void
	 */
	private function checkInput($route, $resolvable) {
		if (strpos($route, '/') !== 0) {
			throw new \InvalidArgumentException("The route should begin with a '/', $route given");
		} else if (is_string($resolvable)) {
			return;
		} else if (is_array($resolvable)) {
			if (sizeof($resolvable) !== 2) {
				throw new \InvalidArgumentException("The array should contain exactly 2 elements");
			}
			if (!is_string($resolvable[1])) {
				throw new \InvalidArgumentException("second element in the array should be a string, " . gettype($resolvable[1]) . " given");
			}
			return;
		} else {
			throw new \InvalidArgumentException("second argument should be an array containing a classname and method name,name of a view or a anonymous function");
		}
	}

}
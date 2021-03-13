<?php

namespace alvin\phpmvc;

/**
 * Middleware for csrf protection
 */
class Csrf {

	/**
	 * Configuration array
	 * @var array
	 */
	private array $config = [
		"lookInCookie" => false,
	];

	/**
	 * Creates a csrf middleware object and sets configs.
	 *
	 * @param array $config
	 */
	public function __construct(array $config) {
		foreach ($config as $key => $value) {
			$this->config[$key] = $value;
		}
	}

	/**
	 * Verify incoming csrf tokens
	 *
	 * @param string $token
	 * @return boolean
	 */
	public static function verify($token = "") {
		return hash_equals($_SESSION['csrfToken'], $token);
	}

	/**
	 * The function to run when this middleware is invoked.
	 *
	 * @param Request $request alvin\phpmvc\Request object
	 * @param Response $response alvin\phpmvc\Response object
	 * @param callabe $next next middleware to execute
	 * @return any
	 */
	public function __invoke(Request $request, Response $response, $next) {
		$route = $request->getRoute();
		$httpMethod = $request->getMethod();
		if ($httpMethod == "get") {
			return $next();
		}
		if (in_array($route, $this->config['ignore'])) {
			return $next();
		}
		if (!isset($_COOKIE['XSRF_TOKEN']) || !$request->input('_csrf')) {
			return $response->send("invalid csrf token");
		}
		$lookInCookie = $this->config['lookInCookie'];
		$incomingToken = $lookInCookie ? $_COOKIE['XSRF_TOKEN'] : $request->input('_csrf');
		if (!$incomingToken) {
			return $response->send("invalid csrf token");
		}
		$isValid = $this->verify($incomingToken);
		if (!$isValid) {
			return $response->send("invalid csrf token");
		}
		return $next();
	}
}
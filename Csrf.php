<?php

namespace alvin\phpmvc;

class Csrf {
	private array $config = [
		"lookInCookie" => false,
	];

	public function __construct(array $config) {
		foreach ($config as $key => $value) {
			$this->config[$key] = $value;
		}
	}

	public static function verify($token = "") {
		return hash_equals($_SESSION['csrfToken'], $token);
	}

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
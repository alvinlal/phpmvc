<?php

namespace app\core;
use app\core\Request;
use app\core\Response;

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
		$lookInCookie = $this->config['lookInCookie'];
		if ($lookInCookie) {

			if (!isset($_COOKIE['XSRF_TOKEN'])) {
				return $response->send("invalid csrf token");
			}

			$isValid = $this->verify($_COOKIE['XSRF_TOKEN']);
			if (!$isValid) {
				$response->send('invalid csrf token');
			} else {
				return $next();
			}
		} else {
			$token = $request->input('_csrf');
			if (!$token) {
				return $response->send("invalid csrf token");
			}
			$isValid = $this->verify($token);
			if (!$isValid) {
				$response->send('invalid csrf token');
			} else {
				return $next();
			}
		}
	}
}
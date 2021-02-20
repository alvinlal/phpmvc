<?php

namespace app\middlewares;
use app\core\Request;
use app\core\Response;

class FirstMiddleware {
	public function __invoke(Request $request, Response $response, callable $next) {
		dump('first middleware');

		return $next();
	}
}
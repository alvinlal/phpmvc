<?php

namespace app\middlewares;
use app\core\Request;
use app\core\Response;

class SecondMiddleware {
	public function __invoke(Request $request, Response $response, callable $next) {
		dump('second middleware');
		$request->status = 'sfs';
		return $next();
	}
}
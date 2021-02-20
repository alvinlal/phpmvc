<?php
namespace app\middlewares;

use app\core\Request;
use app\core\Response;

class ThirdMiddleware {
	public function __invoke(Request $request, Response $response, callable $next) {
		dump("third middleware");
		return $next();
	}
}
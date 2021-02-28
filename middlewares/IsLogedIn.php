<?php

namespace app\middlewares;

use app\core\Controller;
use app\core\Request;
use app\core\Response;

class IsLogedIn extends Controller {
	public function __invoke(Request $request, Response $response, $next) {
		if ($this->getSession('userId')) {
			return $response->redirect('/');
		}
		return $next();
	}
}
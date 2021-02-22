<?php

namespace app\middlewares;

use app\core\Controller;
use app\core\Request;
use app\core\Response;

class IsLogedIn extends Controller {
	public function __invoke(Request $request, Response $response, $next) {
		if (!$this->getSession('userId')) {
			$this->flash('notLogedIn', 'Please Login to add pizza');
			return $response->redirect('/auth/login');
		}
		return $next();
	}
}
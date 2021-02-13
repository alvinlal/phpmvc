<?php

namespace app\controllers;
use app\core\Controller;
use app\core\Request;
use app\core\Response;
use app\models\User;

class AuthController extends Controller {
	public function signup(Request $request, Response $response) {
		if ($request->method == "GET") {
			return $this->render('auth/signup');
		} else if ($request->method == "POST") {
			$user = new User();
			$data = $request->getBody();
			$errors = $user->validateInput($data);
			if (array_filter($errors)) {
				return $this->render('auth/signup', ['errors' => $errors, 'data' => $data]);
			} else {
				if ($user->signup($data)) {
					header("refresh:4;url=/login");
					return $this->render('auth/signup', ['success' => true, 'data' => $data]);
				} else {
					return "something went wrong on our side!";
				}

			}
		}
	}

	// public function login(Request $request, Response $response) {
	// 	if ($request->method == "GET") {
	// 		return $this->render('auth/login');
	// 	} else if ($request->method == "POST") {
	// 		$user = new User();
	// 		$data = $request->getBody();

	// 	}
	// }

}
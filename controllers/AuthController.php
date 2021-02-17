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
			$errors = $user->validateSignupInput($data);
			if (array_filter($errors)) {
				return $this->render('auth/signup', ['errors' => $errors, 'data' => $data]);
			}
			if ($user->signup($data)) {
				header("refresh:3;url=/auth/login");
				$this->flash('signupSuccess', 'Signup Successfull');
				return $this->render('auth/signup', ['data' => $data]);
			} else {
				return "something went wrong on our side!";
			}

		}
	}

	public function login(Request $request, Response $response) {
		if ($request->method == "GET") {
			return $this->render('auth/login');
		} else if ($request->method == "POST") {
			$user = new User();
			$data = $request->getBody();
			$errors = $user->validateLoginInput($data);
			if (array_filter($errors)) {
				return $this->render('auth/login', ['errors' => $errors, 'data' => $data]);
			}
			$this->setSession("userId", $user->id);
			$this->setSession("name", $user->name);
			$this->setSession("loggInTime", time());
			$this->regenerateSession(true);
			$response->redirect('/');
		}
	}
	public function logout(Request $request, Response $response) {
		$this->removeSession();
		$response->redirect('/');
	}
}
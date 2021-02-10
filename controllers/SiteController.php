<?php

namespace app\controllers;
use app\core\Controller;
use app\core\Request;
use app\core\Response;
use app\Models\User;

class SiteController extends Controller {

	public function index() {
		$this->setLayout('index');
		return $this->render('index', ['name' => 'alvin']);
	}
	public function login(Request $request, Response $response) {
		if ($request->isGet()) {
			$response->redirect('/');
		} else if ($request->isPost()) {
			echo '<pre>';
			var_dump($request->getBody());
			echo '</pre>';
		}
	}
	public function dataTest() {
		$user = new User();
		$pizzas = $user->getPizzas();
		return $pizzas[0]['title'] . '</br>' . $pizzas[0]['email'] . '</br>' . $pizzas[0]['ingredients'] . '</br>';
	}
	public function queryTest(Request $request) {
		return $request->params['name'];
	}
}
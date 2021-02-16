<?php

namespace app\controllers;
use app\core\Controller;
use app\core\Request;
use app\core\Response;
use app\models\Pizza;

class PizzaController extends Controller {
	public function details(Request $request) {
		$pizza = new Pizza();
		$id = $request->params['id'];
		return $this->render('pizza/details', ['pizza' => $pizza->getPizza($id)]);
	}
	public function delete(Request $request, Response $response) {
		$pizza = new Pizza();
		$id_to_delete = $request->POST['id_to_delete'];
		if ($pizza->deletePizza($id_to_delete)) {

			$response->redirect('/');
		} else {
			return "something went wrong on our side";
		}

	}
	public function add(Request $request, Response $response) {
		if ($request->method == 'GET') {
			return $this->render('pizza/add');
		} else if ($request->method == 'POST') {
			$data = $request->getBody();
			$errors = Pizza::validateInput($data);
			if (array_filter($errors)) {
				return $this->render('pizza/add', ['errors' => $errors, 'data' => $data]);
			} else {
				$pizza = new Pizza();
				if ($pizza->addPizza($data)) {
					$response->redirect('/');
				} else {
					return "something went wrong on our side!";
				}

			}
		}
	}
	public function getJson(Request $request, Response $response) {
		$obj = [
			'name' => 'alvin',
			'age' => 3,
			'hobbies' => ['movies', 'games', 'tvshows'],
			'photos' => [
				'small' => 'https://localhost',
				'medium' => 'https://localhost',
			],
		];
		return $response->json($obj);
	}
	public function postJson(Request $request, Response $response) {
		$jsonObj = $request->body();
		print_r($jsonObj);
		echo $jsonObj['name'];
	}
}
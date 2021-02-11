<?php

namespace app\controllers;
use app\core\Controller;
use app\models\Pizza;

class SiteController extends Controller {

	public function index() {
		$pizza = new Pizza();
		$pizzas = $pizza->getPizzas();
		return $this->render('index', ['pizzas' => $pizzas]);
	}

}
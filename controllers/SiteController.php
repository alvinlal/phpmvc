<?php

namespace app\controllers;
use app\core\Controller;
use app\models\Pizza;

class SiteController extends Controller {

	public function index() {
		$pizza = new Pizza();
		$pizzas = $pizza->getPizzas();
		$this->setLayout('index');
		return $this->render('index', ['pizzas' => $pizzas]);
	}

}
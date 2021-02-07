<?php

namespace app\controllers;
use app\core\Controller;

class SiteController extends Controller {

	public function index() {
		$this->setLayout('index');
		return $this->render('index', ['name' => 'alvin']);
	}
}
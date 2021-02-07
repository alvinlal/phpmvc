<?php

namespace app\controllers;
use app\core\Controller;
use app\core\Request;

class SiteController extends Controller {

	public function index() {
		$this->setLayout('index');
		return $this->render('index', ['name' => 'alvin']);
	}
	public function login(Request $request) {
		if ($request->isGet()) {
			return $this->render('login');
		} else if ($request->isPost()) {
			echo '<pre>';
			var_dump($request->getBody());
			echo '</pre>';
		}
	}
}
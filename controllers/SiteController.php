<?php

namespace app\controllers;
use app\core\Controller;

/**
 * SiteController
 */

class SiteController extends Controller {
	public function index() {
		return $this->render('index', ['name' => 'alvin']);
	}
}
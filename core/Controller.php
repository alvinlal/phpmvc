<?php

namespace app\core;
use app\core\Application;

class Controller {
	public function setLayout(string $layout) {
		Application::$app->view->setLayout($layout);
	}
	public function render(string $view, array $params = []) {
		return Application::$app->view->renderView($view, $params);
	}
}
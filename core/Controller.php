<?php

namespace app\core;
use app\core\Application;

/**
 * Controller
 *
 * base controller class for other controllers to extend
 */

class Controller {

	public function render(string $view, array $params = []) {

		return Application::$app->view->renderView($view, $params);
	}

}
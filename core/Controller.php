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
	public function setSession(string $key, $value) {
		Application::$app->session->setSession($key, $value);
	}
	public function getSession(string $key) {
		return Application::$app->session->getSession($key);
	}
	public function removeSession() {
		Application::$app->session->removeSession();
	}
	public function regenerateSession(bool $deleteOld) {
		Application::$app->session->regenerateSession($deleteOld);
	}
	public function flash(string $key, string $value) {
		Application::$app->session->flash($key, $value);
	}
}
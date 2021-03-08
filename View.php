<?php

namespace alvin\phpmvc;

class View {
	public string $layout = 'index';

	public function setLayout(string $layout) {
		$this->layout = $layout;
	}

	public function renderView(string $view, array $params) {
		ob_start();
		include Application::$app->rootDir . "views/layouts/$this->layout.php";
		$layoutContent = ob_get_clean();
		$viewContent = $this->renderViewOnly($view, $params);
		return str_replace('{{content}}', $viewContent, $layoutContent);
	}

	public function renderViewOnly(string $view, array $params = []) {
		foreach ($params as $key => $value) {
			$$key = $value;
		}
		$_FLASH = [];
		foreach ($_SESSION['flash'] as $key => $value) {
			$_FLASH[$key] = $value['value'];
		}
		$_csrfToken = $_SESSION['csrfToken'];
		ob_start();
		include_once Application::$app->rootDir . "views/$view.php";
		return ob_get_clean();

	}
}
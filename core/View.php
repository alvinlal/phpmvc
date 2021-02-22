<?php

namespace app\core;

class View {
	public string $layout = 'index';

	public function setLayout(string $layout) {
		$this->layout = $layout;
	}

	public function renderView(string $view, array $params) {
		if (!$this->layout) {
			return $this->renderViewOnly($view, $params);
		}
		ob_start();
		include __DIR__ . "/../views/layouts/$this->layout.php";
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
		ob_start();
		include_once __DIR__ . "/../views/$view.php";
		return ob_get_clean();
	}
}
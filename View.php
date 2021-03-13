<?php

namespace alvin\phpmvc;

/**
 * Class for rendering html content
 */
class View {
	/**
	 * Name of the layout file to use
	 * @var string
	 */
	public string $layout = 'index';

	/**
	 * Sets a layout.
	 *
	 * @param string $layout
	 * @return void
	 */
	public function setLayout(string $layout) {
		$this->layout = $layout;
	}

	/**
	 * Renders a view with a layout.
	 *
	 * @param string $view Name of the view file
	 * @param array $params parameters to pass into the view
	 * @return string
	 */
	public function renderView(string $view, array $params) {
		ob_start();
		include Application::$app->rootDir . "views/layouts/$this->layout.php";
		$layoutContent = ob_get_clean();
		$viewContent = $this->renderViewOnly($view, $params);
		return str_replace('{{content}}', $viewContent, $layoutContent);
	}

	/**
	 * Renders a view without a layout.
	 *
	 * @param string $view Name of the view file
	 * @param array $params parameters to pass into the view
	 * @return string
	 */
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
<?php

namespace app\core;

class View {
	public function renderView(string $view, array $params = []) {
		foreach ($params as $key => $value) {
			$$key = $value;
		}
		ob_start();
		include_once __DIR__ . "/../views/$view.php";
		return ob_get_clean();
	}
}
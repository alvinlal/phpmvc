<?php

namespace alvin\phpmvc;

/**
 * Base class for exposing controller helper methods
 */
class Controller {

	/**
	 * Set layout view.
	 *
	 * Uses setLayout method on alvin\phpmvc\View
	 *
	 * @param string $layout name of the layout file
	 * @return void
	 */
	public function setLayout(string $layout) {
		Application::$app->view->setLayout($layout);
	}

	/**
	 * Renders the specified php page with specified params.
	 *
	 * Uses renderView method on alvin\phpmvc\View
	 *
	 * @param string $view name of the script
	 * @param array $params additional parameters to be passed to the script
	 * @return void
	 */
	public function render(string $view, array $params = []) {
		return Application::$app->view->renderView($view, $params);
	}

	/**
	 * Set session key and value
	 *
	 * Uses setSession method on alvin\phpmvc\Session
	 *
	 * @param string $key
	 * @param any $value
	 * @return void
	 */
	public function setSession(string $key, $value) {
		Application::$app->session->setSession($key, $value);
	}

	/**
	 * Get session value for a given key
	 *
	 * Uses getSession method on alvin\phpmvc\Session
	 *
	 * @param string $key
	 * @return void
	 */
	public function getSession(string $key) {
		return Application::$app->session->getSession($key);
	}

	/**
	 * Remove current session
	 *
	 * Uses removeSession method on alvin\phpmvc\Session
	 *
	 * @param string $key
	 * @return void
	 */
	public function removeSession() {
		Application::$app->session->removeSession();
	}

	/**
	 * Set flash with a key and value
	 *
	 * Uses flash method on alvin\phpmvc\Session
	 *
	 * @param string $key
	 * @param string $value
	 * @return void
	 */
	public function flash(string $key, string $value) {
		Application::$app->session->flash($key, $value);
	}
}
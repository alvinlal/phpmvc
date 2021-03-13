<?php

namespace alvin\phpmvc;

/**
 * Class for handling php sessions
 */
class Session {
	/**
	 * Name of the object inside $_SESSION to store the flash messages in
	 * @var string
	 */
	private const FLASH_KEY = 'flash';

	/**
	 * Creates a Session object.
	 *
	 * Sets session lifetime,cookie lifetime and csrf token
	 *
	 * @param integer $lifetime session and cookie lifetime
	 * @param integer $httpOnly httpOnly cookies or not
	 */
	public function __construct(int $lifetime = 172800, int $httpOnly = 1) {
		ini_set('session.gc_maxlifetime', $lifetime);
		session_set_cookie_params($lifetime);
		ini_set('session.cookie_httponly', $httpOnly);
		session_start();

		$flashMessages = $_SESSION[self::FLASH_KEY] ?? [];
		foreach ($flashMessages as $key => &$flashMessage) {
			$flashMessage['remove'] = true;
		}
		$_SESSION[self::FLASH_KEY] = $flashMessages;

		$csrfToken = bin2hex(random_bytes(24));
		if (!isset($_SESSION['csrfToken']) || !isset($_COOKIE['XSRF_TOKEN'])) {
			$_SESSION['csrfToken'] = $csrfToken;
			setcookie('XSRF_TOKEN', $csrfToken, ["samesite" => "strict", "expires" => time() + 172800, "path" => "/"]);
		}

	}

	/**
	 * Sets a session
	 *
	 * @param string $key Session key
	 * @param mixed $value Session value
	 * @return void
	 */
	public function setSession($key, $value) {
		$_SESSION[$key] = $value;
	}

	/**
	 * Returns a session value
	 *
	 * @param string $key session key
	 * @return mixed|false
	 */
	public function getSession($key) {
		return $_SESSION[$key] ?? false;
	}

	/**
	 * Regenerates and removes a session
	 * @return void
	 */
	public function removeSession() {
		session_regenerate_id(true);
		session_unset();
		session_destroy();
	}

	/**
	 * Set a flash message
	 *
	 * @param string $key flash message key
	 * @param string $value flash message value
	 * @return void
	 */
	public function flash(string $key, string $value) {
		$_SESSION[self::FLASH_KEY][$key] = [
			'remove' => false,
			'value' => $value,
		];
	}

	/**
	 * Removes a flash message
	 * @return void
	 */
	public function removeFlashMessages() {
		$flashMessages = $_SESSION[self::FLASH_KEY] ?? [];
		foreach ($flashMessages as $key => $flashMessage) {
			if ($flashMessage['remove']) {
				unset($flashMessages[$key]);
			}
		}
		$_SESSION[self::FLASH_KEY] = $flashMessages;
	}

	/**
	 * Destroys a session object.
	 *
	 * Uses removeFlashMessages to remove a flash message on object destruction
	 */
	public function __destruct() {
		$this->removeFlashMessages();
	}
}
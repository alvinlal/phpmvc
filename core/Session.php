<?php

namespace app\core;

class Session {
	private const FLASH_KEY = 'flash';
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

	}
	public function setSession($key, $value) {
		$_SESSION[$key] = $value;
	}
	public function getSession($key) {
		return $_SESSION[$key] ?? false;
	}
	public function removeSession() {
		session_unset();
		session_destroy();
	}
	public function regenerateSession(bool $deleteOld) {
		session_regenerate_id($deleteOld);
	}
	public function flash(string $key, string $value) {
		$_SESSION[self::FLASH_KEY][$key] = [
			'remove' => false,
			'value' => $value,
		];
	}
	public function removeFlashMessages() {
		$flashMessages = $_SESSION[self::FLASH_KEY] ?? [];
		foreach ($flashMessages as $key => $flashMessage) {
			if ($flashMessage['remove']) {
				unset($flashMessages[$key]);
			}
		}
		$_SESSION[self::FLASH_KEY] = $flashMessages;
	}
	public function __destruct() {
		$this->removeFlashMessages();
	}
}
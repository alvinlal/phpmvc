<?php

namespace app\core;

class Session {

	public function __construct(int $lifetime = 172800, int $httpOnly = 1) {
		ini_set('session.gc_maxlifetime', $lifetime);
		session_set_cookie_params($lifetime);
		ini_set('session.cookie_httponly', $httpOnly);
		session_start();

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
}
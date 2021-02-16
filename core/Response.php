<?php

namespace app\core;

class Response {
	public function statusCode(int $code) {
		http_response_code($code);
	}
	public function redirect($url) {
		header("Location:$url");
	}
	public function json(array $obj, int $flags = 0, int $depth = 512) {
		return json_encode($obj, $flags, $depth);
	}
	public function setCookie(string $key, string $value, array $options) {
		return setCookie($key, $value, $options);
	}
	public function deleteCookie(string $cookie) {
		return setCookie($cookie, NULL, 0 - 3600);
	}
}
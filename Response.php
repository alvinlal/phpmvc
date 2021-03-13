<?php

namespace alvin\phpmvc;

/**
 * http Response class
 */
class Response {

	/**
	 * Sets a http status code.
	 *
	 * @param integer $code The status code to set
	 * @return void
	 */
	public function statusCode(int $code) {
		http_response_code($code);
	}

	/**
	 * Set http redirect headers.
	 *
	 * @param string $url The url to redirect to
	 * @return void
	 */
	public function redirect($url) {
		header("Location:$url");
		exit();
	}

	/**
	 * Return a json response.
	 *
	 * @param array $obj obj to return
	 * @param integer $flags
	 * @param integer $depth
	 * @return object
	 */
	public function json(array $obj, int $flags = 0, int $depth = 512) {
		header('Content-Type:application/json');
		return json_encode($obj, $flags, $depth);
	}

	/**
	 * Set a cookie.
	 *
	 * @param string $key Cookie key
	 * @param string $value Cookie value
	 * @param array $options Cookie options
	 * @return boolean
	 */
	public function setCookie(string $key, string $value, array $options) {
		return setCookie($key, $value, $options);
	}

	/**
	 * Remove a cookie.
	 * @param string $cookie key of cookie to remove
	 * @return boolean
	 */
	public function deleteCookie(string $cookie) {
		return setCookie($cookie, NULL, 0 - 3600);
	}

	/**
	 * Send string.
	 * @param string $content string to send
	 * @return void
	 */
	public function send(string $content) {
		echo $content;
		exit();
	}
}
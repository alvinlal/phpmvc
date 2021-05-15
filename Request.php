<?php

namespace alvin\phpmvc;

/**
 * http Request class
 */
class Request {

	/**
	 * Current http route.
	 * @var string
	 */
	public $route;

	/**
	 * Query parameters.
	 * @var string
	 */
	public $params;

	/**
	 * All html form inputs.
	 * @var object
	 */
	public $inputs;

	/**
	 * html form body.
	 * @var object
	 */
	public $body;

	/**
	 * current http verb.
	 * @var string
	 */
	public $method;

	/**
	 * Create a new Request object.
	 * @return void
	 */
	public function __construct() {
		$this->setParams();
		$this->setBody();
		$this->setRoute();
		$this->method = $_SERVER['REQUEST_METHOD'];
	}

	/**
	 * Loops over QUERY_STRING global and sets params array.
	 * @return void
	 */
	public function setParams() {
		$params = [];
		array_key_exists('QUERY_STRING', $_SERVER, ) && parse_str($_SERVER['QUERY_STRING'], $params);

		foreach ($params as $key => $value) {
			$params[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
		}
		$this->params = $params;
	}

	/**
	 * Loops over $_GET,$_POST,$_FILES and sets body and inputs array.
	 * @return void
	 */
	public function setBody() {
		$data = [];
		if ($this->isGet()) {
			foreach ($_GET as $key => $value) {
				$data[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
			}
		}
		if ($this->isPost()) {
			foreach ($_POST as $key => $value) {
				$data[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
			}
		}
		foreach ($_FILES as $key => $value) {
			$data[$key] = $value;
			$fileName = $_FILES[$key]['name'];
			$fileNameArray = explode(".", $fileName);
			$fileExt = strtolower(end($fileNameArray));
			$data[$key]['ext'] = $fileExt;
		}
		unset($data['submit']);
		$this->inputs = $data;
		unset($data['_csrf']);
		$this->body = $data;
	}

	/**
	 * Sets current route using $_SERVER['REQUEST_URI'].
	 * @return void
	 */
	public function setRoute() {
		$route = $_SERVER['REQUEST_URI'];
		$queryPos = strpos($route, '?');

		if ($queryPos !== false) {
			$route = substr($route, 0, $queryPos);
		}
		$this->route = $route;
	}

	/**
	 * Returns true if current http method is get.
	 * @return boolean
	 */
	public function isGet() {
		return $this->getMethod() === 'get';
	}

	/**
	 * Returns true if current http method is post.
	 * @return boolean
	 */
	public function isPost() {
		return $this->getMethod() === 'post';
	}

	/**
	 * Returns current http method.
	 * @return string
	 */
	public function getMethod() {
		return strtolower($_SERVER['REQUEST_METHOD']);
	}

	/**
	 * Returns html form body.
	 * @return object
	 */
	public function getBody() {
		return $this->body;
	}

	/**
	 * Returns route.
	 * @return string
	 */
	public function getRoute() {
		return $this->route;
	}

	/**
	 * Returns an input value for a key.
	 * @param string $key
	 * @return mixed
	 */
	public function input($key) {
		return $this->inputs[$key] ?? false;
	}

	/**
	 * Returns a query parameter.
	 *
	 * @param string $key
	 * @return mixed
	 */
	public function query(string $key) {
		return $this->params[$key] ?? null;
	}

	/**
	 * Returns a cookie value from $_COOKIE.
	 *
	 * @param string $key
	 * @return string
	 */
	public function getCookie(string $key) {
		return $_COOKIE[$key] ?? null;
	}

	/**
	 * Return json body
	 *
	 * @param boolean $associative
	 * @param integer $flags
	 * @param integer $depth
	 * @return object
	 */
	public function body($associative = true, int $flags = 0, int $depth = 512) {
		$body = file_get_contents("php://input");
		$object = json_decode($body, $associative, $depth, $flags);
		return $object;
	}
}
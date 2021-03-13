<?php

namespace alvin\phpmvc;

/**
 * Class for reading env file and setting env variables
 */
class Env {
	/**
	 * Path of env file
	 * @var string
	 */
	public string $path;

	/**
	 * Creates a new Env instance.
	 *
	 * Checks if the provided file exists and sets path
	 *
	 * @param string $path The path of env file
	 */
	public function __construct(string $path) {
		if (!file_exists($path)) {
			throw new \RuntimeException(sprintf('%s does not exist', $this->path));
		}
		$this->path = $path;

	}
	/**
	 * Loads environment variable.
	 *
	 * check if provided env file is readable and sets environment variables using \putenv
	 *
	 * @return void
	 */
	public function load() {
		if (!is_readable($this->path)) {
			throw new \RuntimeException(sprintf('%s file is not readable', $this->path));
		}
		$lines = file($this->path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

		foreach ($lines as $line) {
			if (strpos(trim($line), '#') === 0) {
				continue;
			}
			list($key, $value) = explode("=", $line, 2);
			$key = trim($key);
			$value = trim($value);

			if (!array_key_exists($key, $_SERVER) && !array_key_exists($key, $_ENV)) {
				putenv("$key=$value");
			}
		}
	}
}
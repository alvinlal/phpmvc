<?php

namespace app\core;

class Env {
	private string $path;

	public function __construct(string $path) {
		if (!file_exists($path)) {
			throw new \RuntimeException(sprintf('%s does not exist', $this->path));
		}
		$this->path = $path;

	}

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
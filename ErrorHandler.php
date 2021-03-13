<?php

namespace alvin\phpmvc;

/**
 * Custom error handler
 */
class ErrorHandler {

	/**
	 * Error handler function
	 *
	 * @param int $errno
	 * @param string $errstr
	 * @param string $errfile
	 * @param string $errline
	 * @return void
	 */
	public function handle($errno, $errstr, $errfile, $errline) {
		ob_clean();
		echo $errstr . "</br>";
		echo "on line $errline </br>";
		echo "at file $errfile";
		exit();
	}
}
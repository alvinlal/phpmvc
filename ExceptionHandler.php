<?php

namespace alvin\phpmvc;

/**
 * Custom Exception handler
 */
class ExceptionHandler {

	/**
	 * Exception handler function
	 *
	 * @param obj $exception The exception thrown
	 * @return void
	 */
	public static function handle($exception) {
		ob_clean();
		echo $exception->getMessage() . "</br>";
		echo "on line " . $exception->getLine() . "</br>";
		echo "at file " . $exception->getFile();
		echo "</br></br> stack trace </br>";
		echo "<pre>" . $exception->getTraceAsString() . "</pre>";
		exit();
	}
}
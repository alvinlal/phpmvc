<?php

namespace alvin\phpmvc;

class ExceptionHandler {

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
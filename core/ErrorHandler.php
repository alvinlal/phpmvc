<?php

namespace app\core;

class ErrorHandler {

	public function handle($errno, $errstr, $errfile, $errline) {
		ob_clean();
		echo $errstr . "</br>";
		echo "on line $errline </br>";
		echo "at file $errfile";
		exit();
	}
}
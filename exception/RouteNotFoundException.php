<?php

namespace alvin\phpmvc\exception;

class RouteNotFoundException extends \Exception {
	protected $message = 'Page not found';
	public $code = 404;

}
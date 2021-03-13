<?php

namespace alvin\phpmvc\exception;
/**
 * Class for throwing 404 not found error
 */
class RouteNotFoundException extends \Exception {
	protected $message = 'Page not found';
	public $code = 404;

}
<?php

include_once './vendor/autoload.php';
use app\core\Application;

$app = new Application();

$app->get('/', function () {
	echo 'hello';
});

$app->run();
<?php

include_once './vendor/autoload.php';
use app\controllers\SiteController;
use app\core\Application;

$app = new Application();

$app->get('/', [SiteController::class, 'index']);

$app->run();
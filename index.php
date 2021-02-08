<?php

include_once './vendor/autoload.php';
use app\controllers\SiteController;
use app\core\Application;
use app\core\Env;

(new Env(__DIR__ . '/.env'))->load();

$app = new Application();

$app->get('/', [SiteController::class, 'index']);
$app->get('/login', [SiteController::class, 'login']);
$app->post('/login', [SiteController::class, 'login']);
$app->get('/test', [SiteController::class, 'dataTest']);

$app->run();
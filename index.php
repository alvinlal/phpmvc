<?php

include_once './vendor/autoload.php';
use app\controllers\AuthController;
use app\controllers\PizzaController;
use app\controllers\SiteController;
use app\core\Application;
use app\core\Env;

(new Env(__DIR__ . '/.env'))->load();

$app = new Application();

$app->get('/', [SiteController::class, 'index']);
$app->get('/details', [PizzaController::class, 'details']);
$app->post('/delete', [PizzaController::class, 'delete']);
$app->get('/add', [PizzaController::class, 'add']);
$app->post('/add', [PizzaController::class, 'add']);
$app->get('/signup', [AuthController::class, 'signup']);
$app->post('/signup', [AuthController::class, 'signup']);
$app->get('/login', [AuthController::class, 'login']);
$app->post('/login', [AuthController::class, 'login']);

$app->run();
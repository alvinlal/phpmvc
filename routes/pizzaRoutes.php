<?php
use app\controllers\PizzaController;
use app\controllers\SiteController;
use app\middlewares\IsLogedIn;

$app->get('/', [SiteController::class, 'index']);

$app->get('/details/{id}', [PizzaController::class, 'details']);

$app->post('/delete', [PizzaController::class, 'delete']);

$app->get('/add', [PizzaController::class, 'add'])
	->middleware(new IsLogedIn());

$app->post('/add', [PizzaController::class, 'add'])
	->middleware(new IsLogedIn());

$app->get('/json', [PizzaController::class, 'getJson']);

$app->post('/json', [PizzaController::class, 'postJson']);
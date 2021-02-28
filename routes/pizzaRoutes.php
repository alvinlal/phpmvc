<?php
use app\controllers\PizzaController;
use app\controllers\SiteController;
use app\middlewares\IsAuthenticated;

$app->get('/', [SiteController::class, 'index']);

$app->get('/details/{id}', [PizzaController::class, 'details']);

$app->post('/delete', [PizzaController::class, 'delete']);

$app->get('/add', [PizzaController::class, 'add'])
	->middleware(new IsAuthenticated());

$app->post('/add', [PizzaController::class, 'add'])
	->middleware(new IsAuthenticated());

$app->get('/json', [PizzaController::class, 'getJson']);

$app->post('/json', [PizzaController::class, 'postJson']);

$app->get('/image/{id}', [PizzaController::class, 'image']);
<?php
use app\controllers\PizzaController;
use app\controllers\SiteController;

$app->get('/', [SiteController::class, 'index']);
$app->get('/details/{id}', [PizzaController::class, 'details']);
$app->post('/delete', [PizzaController::class, 'delete']);
$app->get('/add', [PizzaController::class, 'add']);
$app->post('/add', [PizzaController::class, 'add']);
$app->get('/json', [PizzaController::class, 'getJson']);
$app->post('/json', [PizzaController::class, 'postJson']);
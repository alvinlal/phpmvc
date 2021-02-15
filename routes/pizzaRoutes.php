<?php
use app\controllers\PizzaController;
use app\controllers\SiteController;

$app->get('/', [SiteController::class, 'index']);
$app->get('/details', [PizzaController::class, 'details']);
$app->post('/delete', [PizzaController::class, 'delete']);
$app->get('/add', [PizzaController::class, 'add']);
$app->post('/add', [PizzaController::class, 'add']);
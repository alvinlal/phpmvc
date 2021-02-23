<?php
use app\controllers\AuthController;
use app\middlewares\IsLogedIn;

$app->get('/auth/signup', [AuthController::class, 'signup']);

$app->post('/auth/signup', [AuthController::class, 'signup']);

$app->get('/auth/login', [AuthController::class, 'login'])
	->middleware(new IsLogedIn());

$app->post('/auth/login', [AuthController::class, 'login'])
	->middleware(new IsLogedIn());

$app->get('/auth/logout', [AuthController::class, 'logout']);
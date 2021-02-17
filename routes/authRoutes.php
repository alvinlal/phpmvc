<?php
use app\controllers\AuthController;

$app->get('/auth/signup', [AuthController::class, 'signup']);
$app->post('/auth/signup', [AuthController::class, 'signup']);
$app->get('/auth/login', [AuthController::class, 'login']);
$app->post('/auth/login', [AuthController::class, 'login']);
$app->get('/auth/logout', [AuthController::class, 'logout']);
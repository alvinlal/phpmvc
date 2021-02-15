<?php
use app\controllers\AuthController;

$app->get('/signup', [AuthController::class, 'signup']);
$app->post('/signup', [AuthController::class, 'signup']);
$app->get('/login', [AuthController::class, 'login']);
$app->post('/login', [AuthController::class, 'login']);
$app->get('/logout', [AuthController::class, 'logout']);
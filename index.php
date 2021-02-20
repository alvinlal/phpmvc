<?php

include_once './vendor/autoload.php';

use app\core\Application;
use app\core\Env;
use app\middlewares\FirstMiddleware;
use app\middlewares\SecondMiddleware;

(new Env(__DIR__ . '/.env'))->load();

$app = new Application();

$app->middleware(new FirstMiddleware());
$app->middleware(new SecondMiddleware());

include_once './routes/pizzaRoutes.php';
include_once './routes/authRoutes.php';

$app->run();
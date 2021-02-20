<?php

include_once './vendor/autoload.php';

use app\core\Application;
use app\core\Env;
use app\middlewares\FirstMiddleware;
use app\middlewares\SecondMiddleware;
use app\middlewares\ThirdMiddleware;

(new Env(__DIR__ . '/.env'))->load();

$app = new Application();

$app->use(new FirstMiddleware());
$app->use(new SecondMiddleware());
$app->use(new ThirdMiddleware());
$app->use(new ThirdMiddleware());

include_once './routes/pizzaRoutes.php';
include_once './routes/authRoutes.php';

$app->run();
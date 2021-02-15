<?php

include_once './vendor/autoload.php';

use app\core\Application;
use app\core\Env;

(new Env(__DIR__ . '/.env'))->load();

$app = new Application();

include_once './routes/pizzaRoutes.php';
include_once './routes/authRoutes.php';

$app->run();
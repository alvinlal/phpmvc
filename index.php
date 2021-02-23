<?php

include_once './vendor/autoload.php';

use app\core\Application;
use app\core\Csrf;
use app\core\Env;

(new Env(__DIR__ . '/.env'))->load();

$app = new Application();

$app->use(new Csrf(["ignore" => ['/path']]));

include_once './routes/pizzaRoutes.php';
include_once './routes/authRoutes.php';

$app->run();
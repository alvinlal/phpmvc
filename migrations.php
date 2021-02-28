<?php

include_once './vendor/autoload.php';
use app\core\Env;
use app\core\Migrator;

(new Env(__DIR__ . '/.env'))->load();

$Migrator = new Migrator(__DIR__ . '/migrations');

$Migrator->applyMigrations();
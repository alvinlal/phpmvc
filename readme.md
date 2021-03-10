![logo](https://drive.google.com/uc?export=view&id=10L8qgFSXUqLcp5omlS2KV-4VSITVeQCr)

A lightweight mvc framework for php

```php
<?php

include_once './vendor/autoload.php';

use alvin\phpmvc\Application;
use app\controllers\SiteController

$app = new Application(__DIR__);

$app->get('/', [SiteController::class, 'index']);

$app->run();

```

[![Latest Stable Version](https://poser.pugx.org/alvin/phpmvc/v)](//packagist.org/packages/alvin/phpmvc) [![Total Downloads](https://poser.pugx.org/alvin/phpmvc/downloads)](//packagist.org/packages/alvin/phpmvc) [![License](https://poser.pugx.org/alvin/phpmvc/license)](//packagist.org/packages/alvin/phpmvc)

## Installation

```bash
composer require alvin/phpmvc
```

## Features

* Middleware support
* session support
* database support
* csrf protection
* filestorage
* zero dependency

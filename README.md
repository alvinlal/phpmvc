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
* Session support
* Database support
* Database migrations support
* Csrf protection
* Filestorage
* Zero dependency package

## Documentation

### Hello world example

This is the simplest app you can make using this mvc framework.


```php
<?php

include_once './vendor/autoload.php';

use alvin\phpmvc\Application; // Main application class
use app\controllers\SiteController // Controller class

$app = new Application(__DIR__); // Root directory path must be provided to the application class

$app->get('/', [SiteController::class, 'index']); // Sets index method on SiteController class as controller for 
                                                 //the route '/' on method get

$app->run(); //Resolves current route and returns output of the controller
```

``index.php``

```php
<?php

use alvin\phpmvc\Controller; //Base class for controllers

class SiteController extends Controler{
     public function index(){    //Controller method
         return "hello world";
     }
}

```

``controllers/SiteController.php``

The above example will display ``hello world`` in the browser.

<!-- ### Routing

Routing refers to how an application’s endpoints (URIs) respond to client requests.You define
routing using methods of the ```alvin\phpmvc\Application``` object that correspond to HTTP methods

The following code is an example of a very basic route.

```php

``` -->

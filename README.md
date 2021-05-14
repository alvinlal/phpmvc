![logo](https://drive.google.com/uc?export=view&id=10L8qgFSXUqLcp5omlS2KV-4VSITVeQCr)

A lightweight mvc framework for php

#### ! This framework is not production ready

```php
<?php

include_once './vendor/autoload.php';

use alvin\phpmvc\Application;

$app = new Application(__DIR__);

$app->get('/',function (){
    return "hello world";
});

$app->run();

```

[![Latest Unstable Version](https://poser.pugx.org/alvin/phpmvc/v/unstable)](//packagist.org/packages/alvin/phpmvc) [![Total Downloads](https://poser.pugx.org/alvin/phpmvc/downloads)](//packagist.org/packages/alvin/phpmvc) [![License](https://poser.pugx.org/alvin/phpmvc/license)](//packagist.org/packages/alvin/phpmvc)

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

You can view the documentation [here](https://github.com/alvinlal/phpmvc/wiki/Documentation).

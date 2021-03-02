#!/bin/bash

composer update && composer install && php migrations.php && apache2ctl -D FOREGROUND
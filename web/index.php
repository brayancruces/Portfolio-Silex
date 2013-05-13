<?php

require_once __DIR__.'/../vendor/autoload.php';
 
$app = require __DIR__.'/../src/app.php';
require __DIR__.'/../src/controllers.php';

//$app['monolog']->addDebug('Probando el logger de Monolog.');
$app['debug'] = true;
//$app->run();

// activada la cache HTTP
$app['http_cache']->run();
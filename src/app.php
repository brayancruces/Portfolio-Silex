<?php

use Silex\Application;
use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\FormServiceProvider;
use Silex\Provider\HttpCacheServiceProvider;
use Silex\Provider\MonologServiceProvider;
use Silex\Provider\SecurityServiceProvider;
use Silex\Provider\SwiftmailerServiceProvider;
use Silex\Provider\TranslationServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;


$app = new Application();

/* *** Doctrine *** 
$app->register(new DoctrineServiceProvider(), array(
    'db.options' => array(
        'driver'    => 'pdo_mysql',
        'host'      => 'localhost',
        'dbname'    => 'madridintimo',
        'user'      => 'root',
        'password'  => null,
        'charset'   => 'utf8',
    ),
));*/

/* *** Forms *** */
$app->register(new FormServiceProvider());

/* *** Http Cache *** */
$app->register(new HttpCacheServiceProvider(), array(
   'http_cache.cache_dir' => __DIR__.'/../cache/http',
   'http_cache.esi'       => null,
));

/* *** Monolog *** */
$app->register(new MonologServiceProvider(), array(
    'monolog.logfile' => __DIR__.'/development.log',
));

/* *** Security Service *** */
$app->register(new SecurityServiceProvider());

/* *** Swift Mailer *** */
$app->register(new Silex\Provider\SwiftmailerServiceProvider());

// configuración de la seguridad
$app['security.encoder.digest'] = $app->share(function ($app) {
    // algoritmo SHA-1, con 1 iteración y sin codificar en base64
    return new MessageDigestPasswordEncoder('sha1', false, 1);
});

$app['security.firewalls'] = array(
    'admin' => array(
        'pattern' => '^/admin',
        'http'    => true,
        'users'   => array(
            'admin' => array('ROLE_ADMIN', 'acd5f46a1574a86e0f22ba58039973d4c0e1b811'),
        ),
    ),
);

/* *** URLGenerator *** */
$app->register(new UrlGeneratorServiceProvider());

/* *** Translation *** */
$app->register(new TranslationServiceProvider(), array(
    'locale_fallback' => 'es',
));

/* *** TWIG *** */
$app->register(new TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../web/views',
    //'twig.options' => array('cache' => __DIR__.'/../cache/twig'),
));

/* *** Validator *** */
$app->register(new ValidatorServiceProvider());


// Plantillas Globales
$app->before(function () use ($app) {
    $app['twig']->addGlobal('layout', $app['twig']->loadTemplate('layout.twig'));
});


// Datos Globales
$app['twig'] = $app->share($app->extend('twig', function($twig, $app) {
    // add custom globals, filters, tags, ...
 
    return $twig;
}));

return $app;
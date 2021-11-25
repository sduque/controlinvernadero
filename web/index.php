<?php
use Symfony\Component\Httpfoundation\Request;
use Symfony\Component\Httpfoundation\Response;

date_default_timezone_set('America/Bogota');

require('../vendor/autoload.php');

$app = new Silex\Application();
$app['debug'] = true;

// Register the monolog logging service
$app->register(new Silex\Provider\MonologServiceProvider(), array(
  'monolog.logfile' => 'php://stderr',
));

// Register view rendering
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/views',
));

// Our web handlers

$app->get('/', function() use($app) {
  $app['monolog']->addDebug('logging output.');
  return $app['twig']->render('index.twig');
});
$app->get('/VerificarValores', function() use($app) {
  $app['monolog']->addDebug('logging output.');
  return $app['twig']->render('verificarvalores.twig');
});
$app->get('/pruebaGet/{nombre}', function() use($app) {
  $app['monolog']->addDebug('logging output.');
  return $nombre;
});
$app->run();

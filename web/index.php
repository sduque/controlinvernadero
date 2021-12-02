<?php
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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
/*
$app->get('/VerificarValores', function() use($app) {
  $app['monolog']->addDebug('logging output.');
  return $app['twig']->render('verificarvalores.twig');
});
$app->get('/pruebaGet/{nombre}', function($nombre) use($app) {
  $app['monolog']->addDebug('logging output.');
  return $nombre;
});
*/

$app->post('/guardarAmbiente', function (Request $request) use ($app) {	
  $temperatura = $request->get('temperatura');
  $humedad = $request->get('humedad');
  $luz = $request->get('luz');
  $tabla = "invernadero";

		$data = array(
			"fecha"=>date('Y-m-d H:i:s'),
			"temperatura" => $temperatura,
			"humedad" => $humedad,
			"luz" => $luz);
	
	$dbconn = pg_pconnect("host=ec2-44-198-236-169.compute-1.amazonaws.com port=5432 dbname=dduoiujimkorgl user=qtxzkhxiiwythp password=85d35b4c909dc5ee7f2ae30c73fa03018aea6b400f011ecf75696e84404c0ef9");
	$respuesta = pg_insert($dbconn, $tabla, $data);

	echo $respuesta; 

   	return "OK";
});
$app->run();

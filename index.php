<?php

use Simplecode\App;
use Simplecode\Protocole\Http\Request;
use Simplecode\Protocole\Routing\Router;

/**
 * Autoload
 */
require __DIR__ .'/src/autoload.php';
require __DIR__ .'/vendor/autoload.php';


/**
 * On capture la requete
 */
$request = Request::capture();

/**
 * @var \Simplecode\Protocole\Http\Response
 */

$response =App::run($request, new Router);

$response -> send();
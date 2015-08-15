<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
require './vendor/autoload.php';

$routes = (new \f\Routes)->load(
	[
	['path'=>'/test','go'=>['ns'=>'f\Userland','method'=>'hello']],
	['path'=>'/test/@hello','go'=>['ns'=>'f\Userland','method'=>'hello']]
	]
	);
(new \f\Router)->run($routes);

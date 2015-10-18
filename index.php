<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require './vendor/autoload.php';
$routes = (new routes)->create([
	[
		'/router/test', function () {
			return 'hello world';
		},
	],
]);
$callback = (new router)->run($routes);
echo $callback();

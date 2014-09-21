<?php
	require 'vendor/autoload.php';
	\Slim\Slim::registerAutoloader();

	$app = new \Slim\Slim();
	$app->config(array(
	    'templates.path' => '/var/www/hackthenorth'
	));

	require 'routes.php';

	$app->run();
?>
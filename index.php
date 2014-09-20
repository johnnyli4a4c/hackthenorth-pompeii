<?php
	require 'vendor/autoload.php';
	\Slim\Slim::registerAutoloader();

	$app = new \Slim\Slim();
	$app->config(array(
	    'templates.path' => '/var/www/html/hackthenorth'
	));

	function getSentenceList($text) {
	    return explode(".", $text);
	}

	require 'routes.php';

	$app->run();
?>
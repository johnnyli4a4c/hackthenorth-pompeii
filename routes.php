<?php
	$app->get('/', function () use ($app) {
	    $app->render('main.html');
	});

	$app->get('/text-to-wit/:name', function ($rawText) use ($app) {
		$app->render('getIntent.php', array('rawText'=>$rawText));
	});
?>
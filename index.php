<?php
require 'vendor/autoload.php';

$app = new \Slim\Slim();

function getSentenceList($text) {
	return explode(".", $text);
}

$app->get('/text-to-wit/:name', function ($rawText) {
	echo "Original Text: <br/>$rawText <br/><br/>";
	echo "Parsed Text: <br/>";
    $sentences = getSentenceList($rawText);
    foreach ($sentences as $key => $sentence) {
    	echo "$sentence<br/>";
    }
});

$app->run();

?>

<?php
	$app->get('/', function () use ($app) {
	    $app->render('main.html');
	});

	$app->get('/text-to-wit/:name', function ($rawText) use ($app) {
		$app->render('getIntent.php', array(
			'rawText' => $rawText
		));
	});

	$app->get('/recordings', function () use ($app) {
		function getSentenceList($text) {
		    return multiExplode(array(".","?","!"), $text);
		}

		function multiExplode ($delimiters, $string) {
		    
		    $ready = str_replace($delimiters, $delimiters[0], $string);
		    $launch = explode($delimiters[0], $ready);
		    return  $launch;
		}

		function witAI($text) {
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL,"https://api.wit.ai/message?v=20140920&q=" . urlencode($text));
			curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Authorization: Bearer F53N25NB7NWQJWZKM3M2PTBUAQYITNEZ"));

			// in real life you should use something like:
			// curl_setopt($ch, CURLOPT_POSTFIELDS, 
			//          http_build_query(array('postvar1' => 'value1')));

			// receive server response ...
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			$server_output = curl_exec ($ch);
			curl_close ($ch);
			return json_decode($server_output);
		}

		$filename = "test.txt";
		$handle = fopen($filename, "r");
		$rawText = fread($handle, filesize($filename));
		fclose($handle);

	    $sentences = getSentenceList($rawText);
	    $parseText = [];
	    $parseText['recap'] = array();
	    $parseText['planning'] = array();
	    $parseText['definitions'] = array();
	    foreach ($sentences as $key => $sentence) {
	    	$result = witAI($sentence);
	    	if(!isset($result->outcomes[0]->intent)) break;
	    	switch($result->outcomes[0]->intent) {
				case "recap":
					array_push($parseText['recap'], $sentence);
					break;
				case "planning":
					array_push($parseText['planning'], $sentence);
					break;
				case "definitions":
					array_push($parseText['definitions'], $sentence);
					break;
			}
		}

		$app->render('recordings.html', array(
			'rawText' => nl2br($rawText),
			'recapText' => $parseText['recap'],
			'planningText' => $parseText['planning'],
			'definitionsText' => $parseText['definitions']
		));
	});
?>
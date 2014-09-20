<?php
	function getSentenceList($text) {
	    return explode(".", $text);
	}

	function witAI($text) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,"https://api.wit.ai/message?v=20140920&q=" . urlencode($text));
		curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Authorization: Bearer RRMYHEQXUC4CE6654GCJOPC6TGIISCPV"));

		// in real life you should use something like:
		// curl_setopt($ch, CURLOPT_POSTFIELDS, 
		//          http_build_query(array('postvar1' => 'value1')));

		// receive server response ...
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$server_output = curl_exec ($ch);
		curl_close ($ch);
		return $server_output;
	}

	echo "Original Text: <br/>$rawText <br/>";
    echo "Parsed Text: <br/>";
    $sentences = getSentenceList($rawText);
    foreach ($sentences as $key => $sentence) {
    	echo "$sentence<br/>";
    	echo witAI($sentence) . "<br/>";
	}
?>
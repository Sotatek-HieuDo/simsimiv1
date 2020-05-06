<?php
	$text=$_GET['text']; 
	$url = 'https://rebot.me/ask';
		$data = array('username' => 'simsimi', 'question' => $text);

		// use key 'http' even if you send the request to https://...
		$options = array(
		    'http' => array(
		        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
		        'method'  => 'POST',
		        'content' => http_build_query($data)
		    )
		);
		$context  = stream_context_create($options);
		$result = file_get_contents($url, false, $context);

		$data1 = array('key' => 'trnsl.1.1.20180820T165039Z.01c1fe48adab948b.b4c0a82af4b26b88b5c1654e036b6681761ab7c3', 'lang' => 'vi','text'=>$result);
		$options1 = array(
		    'http' => array(
		        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
		        'method'  => 'POST',
		        'content' => http_build_query($data1)
		    )
		);
		$context1  = stream_context_create($options1);
		$result1 = file_get_contents("https://translate.yandex.net/api/v1.5/tr/translate", false, $context1);
		echo $result1;
 ?>
<?php

function printData($obj){
	echo "<pre>";
	print_r($obj);
	echo "</pre>";
}

$url = 'http://192.168.1.159:9875/v2/search';

$data = json_encode(array(
	"storeId" => 2,
	"keyword" => "babe"
));

$ch = curl_init(); 
curl_setopt($ch, CURLOPT_URL, $url);								
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);		
curl_setopt($ch, CURLOPT_POST, count($data));
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);	

curl_setopt($ch, CURLOPT_HTTPHEADER, array(
	'Content-Type: application/json'
));

$content = curl_exec ($ch);  
curl_close ($ch);

$objects = json_decode($content, true);

foreach($objects as $object){
	foreach($object as $key => $value){
		printData($key);
	}
}



?>
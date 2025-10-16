<?php
//This function is more or less a copy from https://dns.hetzner.com/api-docs rebuilt as a function for GET and POST
function hetzner_api_query($hurl, $hauth, $hrw  = "GET", $hjson = "") {
	
// get cURL resource
$ch = curl_init();

// set url
curl_setopt($ch, CURLOPT_URL, $hurl);

// return the transfer as a string
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// set method
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $hrw);

// set headers
// changing curl_setopt depending on GET or POST query
if($hrw!="POST"){
	curl_setopt($ch, CURLOPT_HTTPHEADER, [
	'Authorization: Bearer ' . $hauth ,
	]);
}else{
	curl_setopt($ch, CURLOPT_HTTPHEADER, [
		'Authorization: Bearer ' . $hauth ,
		'Content-Type: application/json' ,
	]);
	// set body
	//curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $hjson);
}
// send the request and save response to $response
$response = curl_exec($ch);

// stop if fails
if (!$response) {
	die('Error: "' . curl_error($ch) . '" - Code: ' . curl_errno($ch));
}

// close curl resource to free up system resources 
curl_close($ch);

return $response;
}
?>
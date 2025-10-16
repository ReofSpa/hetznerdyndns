<?php
// include required functions and variables
include("includes/helper_func.php");
include("includes/curl_query.php");
include("hetzner_vars.php");

// if API token or Zone ID is surprisingly missing or no IP provided, stop immediately
if($param["authid"]=="" || $param["zoneid"]=="" || ($param["recordAid"]=="" && $param["recordAAAAid"]=="")){
	http_response_code(400);
	die();
}

$sAFB = "Good";
$sAAAAFB = "Good";

// Check whether a IPv4 address was provided and the A type was defined. Update the DNS entry
if(isset($_GET["ipv4"]) && !$param["recordAid"]==""){
	$json = '{"records":[{"value":"'.$_GET["ipv4"].'","comment":"Last updated: '.date('Y-m-d H:i:s', time()).'"}]}';
	$reply = hetzner_api_query("https://api.hetzner.cloud/v1/zones/".$param["zoneid"]."/rrsets/".$param["recordAid"]."/".$param["recordA"]."/actions/set_records", $param["authid"],"POST",$json);
	// if there is an error json instead, something went wrong, set to Bad
	if(isset($reply["error"])){
		$sAFB = "Bad";
	}
}

// Check whether a IPv6 address was provided and the AAAA type was defined. Update the DNS entry
if(isset($_GET["ipv6"]) && !$param["recordAAAAid"]==""){
	$json = '{"records":[{"value":"'.$_GET["ipv6"].'","comment":"Last updated: '.date('Y-m-d H:i:s', time()).'"}]}';
	$reply = hetzner_api_query("https://api.hetzner.cloud/v1/zones/".$param["zoneid"]."/rrsets/".$param["recordAAAAid"]."/".$param["recordAAAA"]."/actions/set_records", $param["authid"],"POST",$json);
	// if there is an error json instead, something went wrong, set to Bad
	if(isset($reply["error"])){
		$sAAAAFB = "Bad";
	}
}

// Give Feedback to requesting server about update
if ($sAFB == "Good" && $sAAAAFB = "Good") {
	echo "Good";
}
?>
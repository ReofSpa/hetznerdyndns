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

// Check whether a IPv4 address was provided and the A type was defined. Update the DNS entry
if(!$_GET["ipv4"]=="" && !$param["recordAid"]==""){
	$json_array = [
		'value' => $_GET["ipv4"],
		'ttl' => intval($_GET["ttl"]),
		'type' => 'A',
		'name' => $param["recordA"],
		'zone_id' => $param["zoneid"]
	]; 
	$json = json_encode($json_array);
	$reply = hetzner_api_query("https://dns.hetzner.com/api/v1/records/".$param["recordAid"], $param["authid"],"PUT",$json);

	echo "IPv4: ". $_GET["ipv4"]."<br>\n";
}

// Check whether a IPv6 address was provided and the AAAA type was defined. Update the DNS entry
if(!$_GET["ipv6"]=="" && !$param["recordAAAAid"]==""){
	$json_array = [
	'value' => $_GET["ipv6"],
	'ttl' => intval($_GET["ttl"]),
	'type' => 'AAAA',
	'name' => $param["recordAAAA"],
	'zone_id' => $param["zoneid"]
	]; 
	$json = json_encode($json_array);
	$reply = hetzner_api_query("https://dns.hetzner.com/api/v1/records/".$param["recordAAAAid"], $param["authid"],"PUT",$json);
	
	echo "IPv6: ". $_GET["ipv6"]."<br>\n";
}

?>
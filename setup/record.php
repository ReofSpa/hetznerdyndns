<?php
// include required functions and initialize variables
include("../includes/helper_func.php");
include("../includes/curl_query.php");
include("../includes/init_vars.php");

// if API token is surprisingly missing, go back to first step
if($param["authid"]==""){
	header('Location: start.php', true, 303);
	die();
}

// if no zone id available either from file or POST, go one step back
if($param["zoneid"]=="" && $_POST["zoneid"]==""){
	header('Location: zone.php', true, 303);
	die();
}

// if zone id provided via POST, overwrite existing zone id
if($_POST["zoneid"]!=""){
	$param["zoneid"]=$_POST["zoneid"];
}

// write new parameter file
WriteArray($hfile, $param);

// query the existing records in zone, output as array
$records = json_decode(hetzner_api_query("https://dns.hetzner.com/api/v1/records?zone_id=".$param["zoneid"], $param["authid"]), true);

// if there is a message instead, something went wrong, going back to start
if($records["message"]!=""){
	header('Location: start.php', true, 401);
	die();
}

?>
<html>
<head>
	<title>Choose the IPv4/6 Records of Domain</title>
</head>
<body>

<form action="ready.php" method="post">
	<fieldset>
		<legend>Choose your IPv4 record (A)</legend>
		<input type="radio" id="recordAid000" name="recordAid" value="" checked>
		<label for="recordAid000">No entry</label><br>
<?php
// list all A (IPv4) records in zone
foreach($records["records"] as $record){
	if($record["type"]=="A" ){
		$i++;
?>
		<input type="radio" id="recordAid<?php printf("%03s", $i) ?>" name="recordAid" value="<?php echo $record["id"]."/".$record["name"] ?>">
		<label for="recordAid<?php printf("%03s", $i) ?>"><?php echo $record["name"] ?></label><br>
<?php
	}
}
unset($record);
$i = 0;
?>
	</fieldset>
	<fieldset>
		<legend>Choose your IPv6 record (AAAA)</legend>
		<input type="radio" id="recordAAAAid000" name="recordAAAAid" value="" checked>
		<label for="recordAAAAid000">No entry</label><br>
<?php
// list all AAAA (IPv6) records in zone
foreach($records["records"] as $record){
	if($record["type"]=="AAAA" ){
		$i++;
?>
		<input type="radio" id="recordAAAAid<?php printf("%03s", $i) ?>" name="recordAAAAid" value="<?php echo $record["id"]."/".$record["name"] ?>">
		<label for="recordAAAAid<?php printf("%03s", $i) ?>"><?php echo $record["name"] ?></label><br>
<?php
	}
}
unset($record);
$i = 0;
?>
	</fieldset>
	<input type="submit" value="Send">
</form>
</body>
</html>
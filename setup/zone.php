<?php
// include required functions and initialize variables
include("../includes/helper_func.php");
include("../includes/curl_query.php");
include("../includes/init_vars.php");

// check whether a token is defined either in file or from POST, otherwise going step back
if($param["authid"]=="" && $_POST["APIToken"]==""){
	header('Location: start.php', true, 303);
	die();
}

// if token is retrieved via POST overwrite token from file
if($_POST["APIToken"]!=""){
	$param["authid"]=$_POST["APIToken"];
}

// write new parameter file
WriteArray($hfile, $param);

// query the existing zones, output as array
$zones = json_decode(hetzner_api_query("https://dns.hetzner.com/api/v1/zones", $param["authid"]), true);

// if there is a message instead, something went wrong, going step back
if($zones["message"]!=""){
	header('Location: start.php', true, 401);
	die();
}
?>
<html>
<head>
	<title>Choose Domain</title>
</head>
<body>

<form action="record.php" method="post">
	<fieldset>
		<legend>Choose your domain</legend>
<?php
// list all zones (domains)
foreach($zones["zones"] as $zone){
	$i++;
?>
		<input type="radio" id="zone<?php printf("%03s", $i) ?>" name="zoneid" value="<?php echo $zone["id"] ?>">
		<label for="zone<?php printf("%03s", $i) ?>"><?php echo $zone["name"] ?></label><br>
<?php
}
unset($zone);
?>
	</fieldset>
	<input type="submit" value="Send" />
</form>
</body>
</html>
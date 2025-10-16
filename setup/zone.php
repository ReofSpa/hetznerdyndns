<?php
// include required functions and initialize variables
include("../includes/helper_func.php");
include("../includes/curl_query.php");
include("../includes/init_vars.php");

// check whether a token is defined either in file or from POST, otherwise going step back
if($param["authid"]=="" && !isset($_POST["APIToken"])){
	header('Location: start.php', true, 303);
	die();
}

// if token is retrieved via POST overwrite token from file
if($_POST["APIToken"]!=""){
	$param["authid"]=$_POST["APIToken"];
}

// write new parameter file
WriteArray($hfile, $param);

// query the existing zones, output as array (API uses pagination, so need to loop through pages)
$zones = array();
$results = array();
$page = 1;
do {
	$results = json_decode(hetzner_api_query("https://api.hetzner.cloud/v1/zones?page=".$page, $param["authid"]), true);
	// if there is an error json instead, something went wrong, going step back
	if(isset($results["error"])){
		header('Location: start.php', true, 401);
		die();
	}
	$zones = array_merge($zones, $results["zones"]);
	$page++;
} while ($results["meta"]["pagination"]["last_page"] > $results["meta"]["pagination"]["page"]);

$i = 0;

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
foreach($zones as $zone){
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
<?php
// include required functions and initialize variables
include("../includes/helper_func.php");
include("../includes/init_vars.php");

// if API token is surprisingly missing, go back to first step
if($param["authid"]==""){
	header('Location: start.php', true, 303);
	die();
}

// if API token is surprisingly missing, go back to second step
if($param["zoneid"]==""){
	header('Location: zone.php', true, 303);
	die();
}

// if A record defined in POST, overwrite the existing one
if($_POST["recordAid"]!=""){
	$splitvalue = explode("/",$_POST["recordAid"]);
	$param["recordAid"]=$splitvalue[0];
	$param["recordA"]=$splitvalue[1];
}

// if AAAA record defined in POST, overwrite the existing one
if($_POST["recordAAAAid"]!=""){
	$splitvalue = explode("/",$_POST["recordAAAAid"]);
	$param["recordAAAAid"]=$splitvalue[0];
	$param["recordAAAA"]=$splitvalue[1];
}

// if still no record defined, go back one step
if($param["recordAid"]=="" && $param["recordAAAAid"]==""){
	header('Location: record.php', true, 303);
	die();
}

// write final parameter file
WriteArray($hfile, $param);

?>
<html>
<head>
	<title>Ready to Go</title>
</head>
<body>
	<p>Variables defined successfully!</p>
	<p>Example URL for Fritzbox</p>
	<p><code><?php echo $_SERVER["REQUEST_SCHEME"]; ?>://&lt;username&gt;:&lt;pass&gt;@<?php echo $_SERVER["HTTP_HOST"].str_replace("setup/ready","update",$_SERVER["PHP_SELF"]); ?>?ipv4=&lt;ipaddr&gt;&amp;ipv6=&lt;ip6addr&gt;&amp;ttl=60</code></p>
</body>
</html>
<?php
// reset all important variables (will be overwritten by include("../hetzner-vars.php") later in the code
$param["authid"] = "";
$param["zoneid"] = "";
$param["recordAid"] = "";
$param["recordA"] = "";
$param["recordAAAAid"] = "";
$param["recordAAAA"] = "";
$hfile ="../hetzner_vars.php";

// if hetzner_vars.php does not exist, make new file
if(!file_exists($hfile)){
	WriteArray($hfile, $param);
}
// include the parameter file
include($hfile);

?>
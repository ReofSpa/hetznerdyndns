<html>
<head>
	<title>Insert API Auth Token</title>
</head>
<body>
<?php
// include required functions and initialize variables
include("../includes/helper_func.php");
include("../includes/init_vars.php");
// insert API token in form
?>
<form action="zone.php" method="POST">
	<label for="apitoken">API Token:
		<input id="apitoken" name="APIToken">
	</label>
	<input type="submit" value="Send">
</form>
</body>
</html>
<?php
//just a simplification for writing the array of parameter required for DNS update 
function WriteArray($sFile, $aArray){
	$result=file_put_contents($sFile,"<?php\n \$param=".var_export($aArray, true).";\n ?>");
	return $result;
}
?>
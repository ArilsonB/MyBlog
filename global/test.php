<?php
$textToMatch = "<%load table='posts' limit='10' where='all=1%>";
$match = "<%load table='(.*)' limit='(.*)' where='(.*)'%>";
preg_match_all($match,$textToMatch,$out) or die("Erro");
for ($i = 1; $i < count($out); $i++) {
	echo $out[$i][0].", ";
}
?>

	-webkit-box-sizing: border-box;
	-moz-box-sizing: border-box;
	box-sizing: border-box;k
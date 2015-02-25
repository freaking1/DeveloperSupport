<?php
function escape_data($data) {
	global $dbc;
	if (ini_get('magic_quotes_gpc')){
		$data = stripslashes($data);
	}
return mysql_escape_string($data);
}
?>
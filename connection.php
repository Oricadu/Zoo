<?php
	$db_host = 'localhost';
	$db_username = 'root';
	$db_password = '';
	$db_name = 'zoo';
	//$db_charset = 'utf8';
	$is_connected = @mysqli_connect($db_host, $db_username, $db_password, $db_name);
	if ($is_connected) {
		/*echo "string1";*/
	}else{
		echo "error";
	}
	
?>
<?php
require_once 'dbcreds.php';
$db_server = mysql_connect ($db_hostname, $db_username, $db_password);

if (!$db_server) die("Unable to connect to database: " . mysql_error());


mysql_select_db("omsb")
	or die("Unable to select database: " . mysql_error());

?>

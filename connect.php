<?php
require_once 'dbcreds.php';
$db_server = mysqli_connect ($db_hostname, $db_username, $db_password, 'omsb_dev');

if (!$db_server) die("Unable to connect to database: " . mysqli_error());

?>

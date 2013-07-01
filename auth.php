<?php
require_once('ulogin/config/all.inc.php');
require_once('ulogin/uLogin.inc.php');
require_once('ulogin/main.inc.php');
if (!sses_running())
   sses_start();


function isAppLoggedIn(){
   return isset($_SESSION['uid']) && isset($_SESSION['username']) && isset($_SESSION['loggedIn']) && ($_SESSION['loggedIn']===true);
}

#echo $isloggedin;
?>

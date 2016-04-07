<!--
	Author: Christian Yarros
	Purpose: Destroy the session and send to the login portal
	Date: 2/1/2016
-->

<?php
    session_start();
    unset($_SESSION);
    session_destroy();
    header("Location:http://cs-linuxlab-14.stlawu.local/index.php");
    exit();
?>

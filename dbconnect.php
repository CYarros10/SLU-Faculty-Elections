<!--
    Author: Christian Yarros
    Purpose: Connect to a mysql database
    Date: 2/1/2016
-->

<?php
$servername = "cs-linuxlab-14.stlawu.local:3306";
$username = "cdyarr12";
$password = "@udiodax10";
$port = "port=3306";
$dbname = "testDB";

mysql_connect($servername, $username, $password) or die('Could not connect the database : Servername, Username or Password incorrect');
mysql_select_db($dbname) or die ('No database found');
?>
<!--
	Author: Christian Yarros
	Purpose: Determine whether the login was administrative or a user and send them to the correct page
	Date: 2/1/2016
-->

<?php

include_once 'dbconnect.php';
session_start();

function SignIn()
{
    if(!empty($_POST['email']))
    {
        $query = mysql_query("SELECT * FROM faculty where email = '$_POST[email]' AND pass = md5('$_POST[pass]')") or die(mysql_error());
        $row = mysql_fetch_array($query);
            
        if(!empty($row['email']) AND !empty($row['pass'])) {
            $_SESSION['email'] = $row['email'];
            if ($row['email'] == "admin") {
                header("Location: http://cs-linuxlab-14.stlawu.local/admin.php/");
                exit();
            }
            else
                header("Location: http://cs-linuxlab-14.stlawu.local/user.php/");
                exit();
            }
            else {
                echo "Invalid credentials. Please retry.";
            }
        }
        else {
            echo "Invalid credentials. Please retry.";
        }
    }      

if(isset($_POST['submit'])) {
        SignIn();
}

?>
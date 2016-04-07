<!--
	Author: Christian Yarros
	Purpose: Portal for admin and users to SLU Faculty Elections
	Date: 2/1/2016
-->

<!DOCTYPE HTML>
<html>
    <head>
        <title>Sign-In</title>
        <link rel="stylesheet" type="text/css" href="style.css">
	<link href='https://fonts.googleapis.com/css?family=PT+Sans|PT+Serif' rel='stylesheet' type='text/css'>
</head>
    <body>
        <div id="welcome">
            <div id="welcome1"> Welcome to </div>
            <div id="welcome2">SLU Faculty Elections</div>
        </div>
                <div id="login_panel">
            <form method="POST" action="login_script.php">
                    <div class="txt">
                        <input name="email" type="text" placeholder="SLU Email Address">
                    </div>
                    <div class="txt">
                        <input name="pass" type="password" placeholder="Password">
                    </div>
                    <div class="buttons">
                        <input id="button" type="submit" name="submit" value="Log-In">
                </div>
            </form>
    </body>
</html> 

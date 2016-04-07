<!--
	Author: Christian Yarros
	Purpose: Update the database based on a faculty member's willing decision
	Date: 2/1/2016
-->

<?php 
include_once 'dbconnect.php';
include_once 'load_ballots.php';
session_start();
$ballots = unserialize($_SESSION['ballots']);

$cb_id = $_GET['bid'];
$b = new Ballot();
foreach ($ballots as $cb) {
	if ($cb->BID === $cb_id) {
		$b = $cb;	
	}
}
	
if(isset($_POST['willing'])) {

	$status = $_POST['willing'];
	$candidate = $_SESSION['email'];

	if ($status === 'willing') {
		$query1 = mysql_query("UPDATE voting_results SET willing_to_stand = 1 where email = '$candidate' and ballots_BID = '$cb_id'") or die (mysql_error());
	}
	else {
		$query1 = mysql_query("UPDATE voting_results SET willing_to_stand = 0 where email = '$candidate' and ballots_BID = '$cb_id'") or die (mysql_error());
	}
}	
?>

<!DOCTYPE HTML>
<html>
    <head>
        <title>Thank You!</title>
        <link rel="stylesheet" type="text/css" href="\style.css">
	<link href='https://fonts.googleapis.com/css?family=PT+Sans|PT+Serif' rel='stylesheet' type='text/css'>
	<meta http-equiv="refresh" content="3;url=http://cs-linuxlab-14.stlawu.local/user.php/" />
    </head>
    <body>
		<div id="header">
			<h1>SLU Faculty Elections</h1>
			<form method="post" action="http://cs-linuxlab-14.stlawu.local/signout.php">
				<input type="submit" name ="signout" value="SIGN OUT"/>
			</form>
		</div>
		<div id="thank_you">
			<?php 
					echo "<h2> Thank you for declaring! Redirecting now... </h2>";
			?>
		</div>
    </body>
</html>
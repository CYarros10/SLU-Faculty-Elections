<!--
	Author: Christian Yarros
	Purpose: script and thank you page that updates the database based on a faculty members vote
	Date: 2/1/2016
-->

<?php 
include_once 'dbconnect.php';
include_once 'load_ballots.php';
session_start();
$ballots = unserialize($_SESSION['ballots']);

$vote = false;
$submitted_votes = $_POST['vote_list'];

$cb_id = $_GET['bid'];
$b = new Ballot();
foreach ($ballots as $cb) {
	if ($cb->BID === $cb_id) {
		$b = $cb;	
	}
}

if (isset($_POST['submit'])) { 
	$votes_cast = sizeof($submitted_votes);
	$votes_needed = $b->votes_per_person;
	if($votes_cast == $votes_needed){ 
		$vote = true;	
	} 
} 

// Vote has been cast
if ($vote === true) {
	$voter = $_SESSION['email'];
	$query1 = mysql_query("UPDATE votes SET voted = 1 where email = '$voter' and ballots_BID = '$cb_id'") or die (mysql_error());
	for ($i = 0; $i < count($submitted_votes); $i ++) { 
		$query2 = mysql_query("UPDATE voting_results SET num_votes = num_votes + 1 where email = '$submitted_votes[$i]'")
			  or die(mysql_error());	
	}
}


?>

<!DOCTYPE HTML>
<html>
    <head>
        <title>Home Page: <?php echo $email;?></title>
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
		
		
		<div id="vote_thank_you">
			<?php 
				if ($vote === true) {
					echo "<h2> Thank you for voting! Redirecting to home page...</h2>";
				}
				else {
					$message = "This ballot needs " . $b->votes_per_person . " vote(s). Redirecting to home page...";
					echo "<h2> $message </h2>";
			
				}
			?>
		</div>
    </body>
</html>
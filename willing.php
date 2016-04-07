<!--
	Author: Christian Yarros
	Purpose: Allow faculty members to declare candidacy status
	Date: 2/1/2016
-->

<?php 
include_once 'dbconnect.php';
include_once 'load_faculty.php';
include_once 'load_ballots.php';
session_start();
$faculty = unserialize($_SESSION['faculty']);
$ballots = unserialize($_SESSION['ballots']);

$currentBallots = unserialize($_SESSION["ballots"]);
$ballot = new Ballot();

$BID = $_GET['bid'];
$EID = $_GET['eid'];

foreach ($currentBallots as $cb) {
	if ($BID === $cb->BID) {
		$ballot = $cb;
	}
}

if ($_SESSION["email"] != "admin") {

$_SESSION['ballot'] = $BID;
$email = $_SESSION['email'];

$b = new Ballot();

foreach ($ballots as $cb) {
	if ($cb->BID === $BID) {
		$b = $cb;	
	}
}

$query = mysql_query("SELECT willing_to_stand from voting_results where email = '$email' and ballots_BID = '$BID'") or die(mysql_error());
$row = mysql_fetch_row($query);
$willing = $row[0];
?>

<!DOCTYPE HTML>
<html>
    <head>
        <title>Willing Status</title>
        <link rel="stylesheet" type="text/css" href="\style.css">
	<link href='https://fonts.googleapis.com/css?family=PT+Sans|PT+Serif' rel='stylesheet' type='text/css'></head>
    <body>
		<div id="header">
			<h1>SLU Faculty Elections</h1>
			<form method="post" action="http://cs-linuxlab-14.stlawu.local/signout.php">
				<input type="submit" name ="signout" value="SIGN OUT"/>
			</form>
		</div> <!-- header -->
		<nav class= "user_nav" id="breadcrumbs">
  			<a href="http://cs-linuxlab-14.stlawu.local/user.php">Home</a> / 
			<a>Willing Status</a>
		</nav>
		<div id="willing">
			<div id="willing_header">
			<h2>Willing To Stand?</h2>
			<h3> Ballot Info </h3>
	
			<p> <span class="label">Election:</span>
				<?php
					$query = mysql_query("SELECT election_type from elections where EID = '$EID'") or die(mysql_error());
					$row = mysql_fetch_row($query);
					$election = $row[0];	
					 echo $election; 
				?>
			</p>
			<p> <span class="label">Selection:</span> <?php echo $ballot->ballot_type; ?></p>
			<p> <span class="label">Date: </span> <?php 
						$time = strtotime($ballot->start_date);
						$newFormat = date('m-d-Y',$time);
						echo $newFormat; ?>
			</p>
	
			<?php
				// Notify faculty that they have already declared their status for this ballot before
				if (!is_null($willing)) {
					echo "<p> *Note: You have previously declared your candidate status for this ballot </p>";
				}
}
?>
			</div>
	
			<div id="vote_list">			
				<form method="post" action="http://cs-linuxlab-14.stlawu.local/willing_script.php?bid=<?php echo $BID;?>">
					<input required type="radio" name="willing" value="willing"> Yes, I am willing to stand for election. <br>
					<input type="radio" name="willing" value="not_willing"> No, I would not like to be considered for this ballot.<br>
					<input class="button" id="vote_submit" type="submit" name="submit" value="Submit">
				</form>
			</div> <!-- vote_list -->
		</div> <!-- ballot_voting -->
	</body>
</html>

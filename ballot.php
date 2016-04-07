<!--
	Author: Christian Yarros
	Purpose: User page for voting on ballots
	Date: 2/1/2016
-->

<?php 
include_once 'dbconnect.php';
include_once 'load_faculty.php';
include_once 'load_ballots.php';
include_once 'load_elections.php';
include_once 'load_voter_lists.php';
include_once 'load_candidate_lists.php';
session_start();

LoadFacultyList();
$faculty = unserialize($_SESSION['faculty']);
$currentBallots = unserialize($_SESSION["ballots"]);
$currentElections = unserialize($_SESSION["elections"]);
$ballot = new Ballot();
$election = new Election();
$email =$_SESSION['email'];
$BID = $_GET['bid'];
$EID = $_GET['eid'];

//Retrieve election object
foreach ($currentElections as $ce) {
	if ($EID === $ce->id) {
		$election = $ce;
	}
}

// Retrieve ballot object
foreach ($currentBallots as $cb) {
	if ($BID === $cb->BID) {
		$ballot = $cb;
	}
}



if ($_SESSION["email"] != "admin") {
	
	// Check to see if user voted on this ballot
	$query = mysql_query("SELECT voted from votes where email = '$email' and ballots_BID = '$BID'") or die(mysql_error());
	$row = mysql_fetch_row($query);
	$voted = $row[0];
?>


<!DOCTYPE HTML>
<html>
    <head>
        <title>Home</title>
        <link rel="stylesheet" type="text/css" href="\style.css">
	<link href='https://fonts.googleapis.com/css?family=PT+Sans|PT+Serif' rel='stylesheet' type='text/css'>
    </head>
    <body>
		<div id="header">
			<h1>SLU Faculty Elections</h1>
			<form method="post" action="http://cs-linuxlab-14.stlawu.local/signout.php">
		        <input type="submit" name ="signout" value="SIGN OUT"/>
		    </form>
		</div> <!-- header -->

		<nav class="user_nav" id="breadcrumbs">
  			<a href="http://cs-linuxlab-14.stlawu.local/user.php">Home</a> / 
			<a> Cast Vote </a>
		</nav>
	
		<div id="ballot_voting">
			<div id="vote_header">
			<h2>Cast Your Vote</h2>
			<p> <span class="label"> Selection: </span> <?php echo $election->election_semester . ' ' . $election->election_year .' - ' . $election->type . ' - ' . $cb->ballot_type . ' Ballot'; ?></p>
			<p> <span class="label"> Date: </span> <?php 
					$time = strtotime($ballot->start_date);
					$newFormat = date('m-d-Y',$time);
					echo $newFormat; ?></p>
			<p> <span class="label"> Ballot ID: </span> <?php echo $ballot->BID; ?></p>

			<!--
			<p> Candidate List(s): 
				<?php
					$candidate_list = LoadCandidateLists($cb->BID);
					foreach($candidate_list as $c) {
						echo $c;
					}		
				?>

			</p>

			<p> Voter List(s): 
				<?php
					$voter_list = LoadVoterLists($cb->BID);
					foreach ($voter_list as $v) {
						echo $v;
					}		
				?>
			</p> -->
			</div> <!-- vote_header -->



<?php
	// Check to see if there are any candidates
	$anyone_willing = mysql_query("SELECT count(willing_to_stand) FROM voting_results where ballots_bid = '$ballot->BID' and willing_to_stand = 1") or die(mysql_error());
	$results = mysql_fetch_row($anyone_willing);
	$any = $results[0];
	if ($any != 0) {
?>
		

<?php
			// Prevent a user from voting more than one occasion
			if ($voted != 1) {
?>
			
			
			<div id="vote_list">
				<h3> Candidate List </h3>
				<?php echo "<p> Please cast " . $ballot->votes_per_person . " vote(s). </p>" ; ?>			
	
			<?php echo "<form method='POST' action='http://cs-linuxlab-14.stlawu.local/vote.php?bid=$ballot->BID'>"; ?>

<?php
		
	
				$result = mysql_query("SELECT email,willing_to_stand FROM voting_results where ballots_BID = '$ballot->BID' and willing_to_stand IS NOT NULL") or die(mysql_error());
			
				while ($row = mysql_fetch_assoc($result, MYSQL_NUM)) {
					$email = $row[0];
					$willing = $row[1];
					if ($willing === '1') {
						foreach($faculty as $fac) {
							if ($email == $fac->email) {
								echo "<p class='label'><input type='checkbox' class='squaredTwo' name='vote_list[]' value='$email'>$fac->first_name $fac->last_name </p>";
							}
						}
					}	
				}	
			
?>
					<input class="button" id="vote_submit" type="submit" name="submit" value="Cast Vote">
				</form>
			</div> <!-- ballot_voting -->

<?php
			}
			else {
				echo "You have already voted on this ballot";
			}
		}
		else {
			echo "There are currently no candidates willing to stand for election, check back later.";
		}
}
?>
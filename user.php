<!--
	Author: Christian Yarros
	Purpose: Main page for faculty members to allow them to vote or declare candidacy
	Date: 2/1/2016
-->

<?php
include_once 'dbconnect.php';
include_once 'load_ballots.php';
include_once 'load_faculty.php';
include_once 'load_elections.php';
session_start();
LoadBallots();
LoadFacultyList();
LoadElections();
$currentBallots = unserialize($_SESSION["ballots"]);
$currentFaculty = unserialize($_SESSION["faculty"]);
$currentElections = unserialize($_SESSION["elections"]);


if (isset($_SESSION["email"])) {
    $email = $_SESSION['email'];
    LoadBallots();
    LoadFacultyList();
	
	$facultyList = unserialize($_SESSION["faculty"]);
	$user = new FacultyMember();
	foreach ($facultyList as $fac) {
		if ($fac->email === $email) {
			$user = $fac;
	}
}

//passing ID for next ballot creation
$_SESSION['current_user'] = serialize($user);
$email = $_SESSION['email'];

?>

<!DOCTYPE HTML>
<html>
    <head>
        <title>Home Page: <?php echo $email;?></title>
        <link rel="stylesheet" type="text/css" href="\style.css">
	<link href='https://fonts.googleapis.com/css?family=PT+Sans|PT+Serif' rel='stylesheet' type='text/css'>
</head>
    <body>
		<div id="header">
			<h1>SLU Faculty Elections</h1>
			<form method="post" action="http://cs-linuxlab-14.stlawu.local/signout.php">
				<input type="submit" name ="signout" value="SIGN OUT"/>
			</form>
		</div>
		<nav class="user_nav" id="breadcrumbs">
  			<a>Home</a> 
		</nav>
		<div id="user">
			<div id='user_info'>
			<h2> Welcome, <?php echo $user->first_name . ' ' . $user->last_name ; ?></h2>
				
				<p> <span class="label">Start Date:</span>
					<?php  
						$time = strtotime($user->start_date);
						$newFormat = date('m-d-Y',$time);
						echo $newFormat;
						?>
				</p>
				<p> <span class="label"> Rank:</span> <?php echo $user->rank_type; ?> </p>
				<p> <span class="label"> Rank Achieved On: </span> <?php 
					$time = strtotime($user->rank_date);
					$newFormat = date('m-d-Y',$time);
					echo $newFormat; 
					?>
				 </p>
			</div>
	
			<div id="voting_and_willing">
				<div id="willing_ballots">
				<h3> Declare Or Update Your Willingness To Stand For Election: </h3>
	
				<!-- Willing to Stand -->
				<ul style="list-style-type:none; padding: 0px;">
	
				<?php	
					$noWillingFound = true;
					$query = mysql_query("SELECT ballots_BID from voting_results where email = '$email';") or die(mysql_error());
					while ($row = mysql_fetch_array($query)) {
						foreach ($currentBallots as $cb) {
							$query2 = mysql_query("SELECT status from ballots where BID = '$cb->BID';") or die(mysql_error());
							$status = mysql_fetch_array($query2);


							if ($cb->BID === $row[0] And $status[0] === 'disabled') {
								$noWillingFound = false; 
								foreach ($currentElections as $ce) {
									if ($cb->election_ID == $ce->id) {
										
										// START ELECTION DETAILING HERE //
										echo "<li>
											<a href=http://cs-linuxlab-14.stlawu.local/willing.php?bid=$cb->BID&eid=$ce->id>
												 $ce->election_semester $ce->election_year: $ce->type - $cb->ballot_type Ballot 
											</a>
										      </li>";
									}
								}
							}
						}
					} if ($noWillingFound) {
						echo "<h2 style='text-align:center; border: 0px;'> Nothing to Declare! </h2>";
					}
				?>
				</ul>
				</div>
	
				<!-- Voting -->
				<div id="voting_ballots">
				<h3> Cast Your Vote: </h3>
				
				<?php	
					$noneFound = true;
					$query = mysql_query("SELECT ballots_BID from votes where email = '$email' and voted = 0;") or die(mysql_error());
					while ($row = mysql_fetch_array($query)) {
	
						foreach ($currentBallots as $cb) {
							$query2 = mysql_query("SELECT status from ballots where BID = '$cb->BID';") or die(mysql_error());
							$status = mysql_fetch_array($query2);
	
							if ($cb->BID === $row[0] And $status[0] === 'enabled') {
								echo "<ul style='list-style-type:none; padding:0px;'>";
								$noneFound = false; 
								foreach ($currentElections as $ce) {
									if ($cb->election_ID == $ce->id) {		
										echo "<li><a href=http://cs-linuxlab-14.stlawu.local/ballot.php?bid=$cb->BID&eid=$ce->id> $ce->election_semester $ce->election_year: $ce->type - $cb->ballot_type Ballot </a></li>";
									}
								}
								echo "</ul>";
							}
						}
					} 
					if ($noneFound) {
						echo "<h2 style='text-align:center'> You have finished voting for today! </h2>";
					}
				?>
				</div>
			</div>
		</div>
    </body>
</html>

<?php
}
else {
	echo "You are unauthorized to access this page";
}

?>
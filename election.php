<!--
	Author: Christian Yarros
	Purpose: Show an admin a specific election and all the ballots/info associated with it
	Date: 2/1/2016
-->

<?php 
include_once 'dbconnect.php';
include_once 'load_elections.php';
include_once 'load_ballots.php';
include_once 'load_voter_lists.php';
include_once 'load_candidate_lists.php';
session_start();

$currentElections = unserialize($_SESSION["elections"]);
$currentBallots = unserialize($_SESSION["ballots"]);
LoadElections();
LoadBallots();

$election = new Election();
$ballot = new Ballot();

$EID = $_GET['id'];

foreach ($currentElections as $ce) {
	if ($EID === $ce->id) {
		$election = $ce;
	}
}
?>

<!DOCTYPE HTML>
<html>
    <head>
        <title>Admin</title>
        <link rel="stylesheet" type="text/css" href="\style.css">
	<link href='https://fonts.googleapis.com/css?family=PT+Sans|PT+Serif' rel='stylesheet' type='text/css'> </head>
    <body>
	<div id="header">
		<h1>SLU Faculty Elections - ADMIN </h1>
		<form method="post" action="http://cs-linuxlab-14.stlawu.local/signout.php">
            <input type="submit" name ="signout" value="SIGN OUT"/>
        </form>
	</div> <!-- header -->
	
	<div id="content">
		<nav id="breadcrumbs">
  			<a href="http://cs-linuxlab-14.stlawu.local/admin.php">Home</a> / 
			<a> View Ballots </a>
		</nav>		

		<div id="tool_bar">
			<h2>Tool Bar</h2>
			<ul>
				<li><a href= <?php echo "http://cs-linuxlab-14.stlawu.local/create_ballot.php?eid=$election->id" ?>>Add a New Ballot</a></li>
			</ul>
		</div> <!-- tool_bar -->
		
		<div id="individual_election">
			<div id="election_header">
			<h2> <?php echo "Election " . $election->id . ': '. $election->type;?> </h2>
			<p> <span class="label"> Semester/Year:</span> <?php 
						echo $ce->election_semester . " " . $ce->election_year;
					?></p>
			<p> <span class="label">Description: </span> <?php echo $election->description;?></p>
			</div>
			
			<div id="ballot_feed">

				<?php
					foreach ($currentBallots as $cb) {
						if ($cb->election_ID === $election->id){
				?>
	
				<div class="ballots_from_feed">
					
						<h3> Ballot <?php echo $cb->BID . ': ' . $cb->ballot_type; ?></h3>
						<p> <span class="label">Start Date: </span>
							<?php 
								$time = strtotime($cb->start_date);
								$newFormat = date('m-d-Y',$time);
								echo $newFormat;
							?>
						</p>
						<p> <span class="label"> End Date: </span>
							<?php 
								$time = strtotime($cb->end_date);
								$newFormat = date('m-d-Y',$time);
								echo $newFormat;	
							?>
						</p>
	
						<p> <span class="label"> Candidate List(s): </span>
								<?php
									$candidate_list = LoadCandidateLists($cb->BID);
									echo implode(", ", $candidate_list);
								?>
						</p>
							<p> <span class="label">Voter List(s): </span> 
								<?php
									$voter_list = LoadVoterLists($cb->BID);
									echo implode(", ", $voter_list);	
								?>					
							</p>
					
					
						<div id="ballot_actions">
					<?php
							echo "<a href='http://cs-linuxlab-14.stlawu.local/email.php?bid=$cb->BID' class='button'>Email Faculty</a>";
							echo "<a href='http://cs-linuxlab-14.stlawu.local/statistics.php?bid=$cb->BID' class='button'>Statistics and Results</a>";
				
							$query = mysql_query("SELECT status from ballots where BID = '$cb->BID'") or die(mysql_error());
							$row = mysql_fetch_row($query);
							$status = $row[0];	
	
							if ($status === 'enabled') {
								echo "<a href='http://cs-linuxlab-14.stlawu.local/enable_disable_script.php?id=$EID&bid=$cb->BID&status=$status' class='button'>Disable Voting</a>";
							}
							else if ($status === 'disabled') {
								echo "<a href='http://cs-linuxlab-14.stlawu.local/enable_disable_script.php?id=$EID&bid=$cb->BID&status=$status' class='button'>Enable Voting</a>";
							}
		
							echo "<a href='http://cs-linuxlab-14.stlawu.local/delete_ballot.php?bid=$cb->BID' class='button'>Delete This Ballot</a>";
	
					?>
							</div> <!-- actions -->
						</div> <!-- ballots_from_feed -->
					<?php	
						}
					}
					//passing ID for next ballot creation
					$_SESSION['current_election_id'] = serialize($election->id);
					?>
				</div> <!-- ballot_feed -->
			</div> <!-- individual_election -->
		</div> <!-- content -->
    </body>
</html>
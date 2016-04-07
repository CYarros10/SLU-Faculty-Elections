<!--
	Author: Christian Yarros
	Purpose: Display the results and statistics of a given ballot
	Date: 2/1/2016
-->

<?php 
include_once 'dbconnect.php';
include_once 'load_ballots.php';
session_start();
LoadBallots();

$currentBallots = unserialize($_SESSION["ballots"]);
$ballot = new Ballot();
$BID = $_GET['bid'];

foreach ($currentBallots as $cb) {
	if ($BID === $cb->BID) {
		$ballot = $cb;
	}
}

?>


<!DOCTYPE HTML>
<html>
    <head>
        <title>Statistics</title>
        <link rel="stylesheet" type="text/css" href="\style.css">
	<link href='https://fonts.googleapis.com/css?family=PT+Sans|PT+Serif' rel='stylesheet' type='text/css'>
 </head>
    <body>
		<div id="header">
			<h1>SLU Faculty Elections </h1>
			<form method="post" action="http://cs-linuxlab-14.stlawu.local/signout.php">
						<input type="submit" name ="signout" value="SIGN OUT"/>
					</form>
		</div> <!-- header -->
		<div id="content">
			<nav id="breadcrumbs">
				<a href="http://cs-linuxlab-14.stlawu.local/admin.php">Home</a> / 
				<?php
					echo "<a href=http://cs-linuxlab-14.stlawu.local/election.php?id=$ballot->election_ID>View Ballots</a>";
				?> /
				<a>Statistics & Results</a>
			</nav>	
			<div id="statistics">
				
	<?php
				echo "<div id='stat_info'>";	
				echo "<h2> Ballot $BID:  $ballot->ballot_type </h2>";
				echo "<p> <span class='label'> Start Date: </span>"; 

							$time = strtotime($ballot->start_date);
							$newFormat = date('m-d-Y',$time);
							echo $newFormat . "</p>";


				echo "<p> <span class='label'>End Date: </span>";
							$time = strtotime($ballot->end_date);
							$newFormat = date('m-d-Y',$time);
							echo $newFormat . "</p>";	
		
				echo "<p> <span class='label'> Election ID:</span> $ballot->election_ID </p>";
				echo "</div>";			
	?>
				<div id="results">
				
				<table>
					<caption> Voting Results </caption>
					<tbody>
					<tr id="table_header">
						<th scope="col"> Candidate </th>
						<th scope="col"> Number of Votes </th>
						<th scope="col"> Willing to Stand? </th>
					</tr>
		
				<?php
				$result = mysql_query("SELECT first_name,last_name, num_votes,email FROM voting_results natural join faculty where ballots_BID='$BID' ORDER BY num_votes DESC;") or die(mysql_error());
				
				while ($row = mysql_fetch_array($result)) {
					$willing = mysql_query("SELECT willing_to_stand FROM voting_results WHERE ballots_BID='$BID' AND email = '$row[3]';") or die(mysql_error());
					$willingArray = mysql_fetch_array($willing);
					$status = '';
	
					if ($willingArray[0] == 1) {
						$status = "Yes";
					}
					else if ($willingArray[0] === 0) {
						$status = "No";
					}
					else if (is_null($willingArray[0])){
						$status = "No Response";
					}
					?>
						<tr> 
							<td><span class='candidate'> <?php echo $row[0] . ' '. $row[1]; ?> </span></td>
							<td><span class='num_votes'> <?php echo $row[2]; ?> </span></td>
							<td><span class='status'> <?php echo $status; ?></span></td>
						</tr>
					<?php 
				}
					?>
				</table>
			</div> <!-- statistics -->
			<?php echo implode(" ", $willingArray); ?>
		</div> <!-- content -->
    </body>
</html>
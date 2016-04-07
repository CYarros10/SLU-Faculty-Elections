<!--
	Author: Christian Yarros
	Purpose: Script to create ballot and add it to the database (admin)
	Date: 2/1/2016
-->

<?php 
function CreateBallot() {
	session_start();
	include_once 'dbconnect.php';
	include_once 'load_ballots.php';
	include_once 'load_faculty.php';
	include_once 'load_voter_lists.php';
	include_once 'load_candidate_lists.php';
	LoadFacultyList();
	$facultylist = 	unserialize($_SESSION["faculty"]);

	if(isset($_POST['create_ballot']))
	{
 		$ballot_type = mysql_real_escape_string($_POST['ballot_type']);
 		$start_date = $_POST['start_date'];
	 	$end_date = $_POST['end_date'];
		$election_ID = $_POST['election_id'];
		$votes_per_person = $_POST['votes_per_person'];
		$defaultStatus = 'disabled';

		// Add the ballot to the database
	 	$query1 = mysql_query(
				"INSERT INTO ballots(ballot_type, start_date, end_date, election_id, votes_per_person, status) 
				VALUES('$ballot_type','$start_date','$end_date', '$election_ID', '$votes_per_person', '$defaultStatus');
				")
		  or die(mysql_error());
		$BID = mysql_insert_id();

		
		// Add candidate and voter lists to the database
		$query2 = mysql_query("INSERT INTO candidate_list(BID) values ('$BID');") or die(mysql_error());	
		$query3 = mysql_query("INSERT INTO voter_list(BID) values ('$BID');") or die(mysql_error());
		
		foreach ($_POST['candidate_list'] as $selectedOption) {
			$query4 = mysql_query("UPDATE candidate_list SET $selectedOption = 1 where BID = $BID;") or die (mysql_error());
		}

		foreach ($_POST['voter_list'] as $selectedOption) {
			$query5 = mysql_query("UPDATE voter_list SET $selectedOption = 1 where BID = $BID;") or die (mysql_error());	
		}

		
		foreach($facultylist as $fac) {
			// Create an instance of candidate results for this ballot and insert into database
			$candidate_list = LoadCandidateLists($BID);
			foreach($candidate_list as $c) {
				if ($fac->rank_type == $c) {
					$query6 = mysql_query("
					INSERT INTO voting_results(email, ballots_BID, num_votes) 
					VALUES('$fac->email', '$BID', 0);")
		  			or die(mysql_error());
				}
			}
			
			// record instance of votes for this ballot and insert into database
			$voter_list = LoadVoterLists($BID);
			foreach($voter_list as $v) {
				if ($v == "Tenured And Tenured Track") {
					if ($fac->rank_type == 'Full Professor'
						Or $fac->rank_type == 'Assistant Professor'
						Or $fac->rank_type == 'Associate Professor') {
							$query7 = mysql_query("
									INSERT INTO votes(email, ballots_BID, voted) 
									VALUES('$fac->email', '$BID', 0);")
									or die(mysql_error());
					}
				}
				if ($v == "Other Faculty") {
					if ($fac->rank_type == 'Adjunct Faculty'
						Or $fac->rank_type == 'Visiting Faculty') {
					
						$query8 = mysql_query("
									INSERT INTO votes(email, ballots_BID, voted) 
									VALUES('$fac->email', '$BID', 0);")
									or die(mysql_error());
					}
					
				}
				if ($v == "Staff") {
					if ($fac->rank_type == 'Senior Staff'
						Or $fac->rank_type == 'Junior Staff'
						Or $fac->rank_type == 'Senior Librarian'
						Or $fac->rank_type == 'Junior Librarian'
						Or $fac->rank_type == 'Art Gallery Director') {
					
						$query9 = mysql_query("
									INSERT INTO votes(email, ballots_BID, voted) 
									VALUES('$fac->email', '$BID', 0);")
									or die(mysql_error());
					}
				}
	
			}
		}
		LoadBallots();
		header("Location: http://cs-linuxlab-14.stlawu.local/election.php?id=$election_ID");
		exit();
	}		
}

if (isset($_POST['create_ballot'])) {
        CreateBallot();
}
?>

<!--
	Author: Christian Yarros
	Purpose: Create a Ballot object and a function that allows the loading of all current ballots into an array
	Date: 2/1/2016
-->

<?php
class Ballot {
	public $BID;
	public $start_date;
	public $end_date;
	public $ballot_type;
	public $election_ID;
	public $candidate_list;
	public $voter_list;
	public $votes_per_person;
	public $status;
}


function LoadBallots() {
    $query = "SELECT * FROM ballots;";
	$result = mysql_query($query);
	$currentBallots = array();

	while($row = mysql_fetch_array($result)){
		$ballot = new Ballot();
		$ballot->ballot_type = $row['ballot_type'];
		$ballot->start_date = $row['start_date'];
		$ballot->end_date = $row['end_date']; 
		$ballot->BID = $row['BID'];
		$ballot->election_ID = $row['election_ID'];
		$ballot->votes_per_person = $row['votes_per_person'];	
		$ballot->status = $row['status'];	
		$currentBallots[] = $ballot;	
	}
	$_SESSION["ballots"] = serialize($currentBallots);
}

?>
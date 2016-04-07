<!--
	Author: Christian Yarros
	Purpose: Create an election object and an array of all current objects in use
	Date: 2/1/2016
-->


<?php
class Election {
	public $type;
	public $election_semester;
	public $election_year;
	public $id;
	public $description;
}

function LoadElections() {
        $query = "SELECT * FROM elections ORDER BY election_year DESC;";
	$result = mysql_query($query);

	$currentElections = array();

	while($row = mysql_fetch_array($result)){		
		$election = new Election();
		$election->type = $row['election_type'];
		$election->election_semester = $row['election_semester'];
		$election->election_year = $row['election_year'];
		$election->id = $row['EID'];
		$election->description = $row['description']; 	
		$currentElections[] = $election;	
	}

	$_SESSION["elections"] = serialize($currentElections);
}
?>
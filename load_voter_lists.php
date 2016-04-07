<!--
	Author: Christian Yarros
	Purpose: Load the voter lists associated with a specific ballot
	Date: 2/1/2016
-->

<?php

// $BID = a ballot ID int
// Returns an array of associated voter lists as strings
function LoadVoterLists($BID) {
	$voters = array();
	$query = mysql_query("SELECT * FROM voter_list where BID = '$BID';") or die(mysql_error());
	$row = mysql_fetch_array($query);
	
	if ($row['tenured_and_tenured_track'] == 1) {
		array_push($voters, "Tenured And Tenured Track");
	}

	if ($row['other_faculty'] == 1) {
		array_push($voters, "Other Faculty");

	}
					
	if ($row['staff'] == 1) {
		array_push($voters, "Staff");
	}
	
	return $voters;
}

?>
<!--
	Author: Christian Yarros
	Purpose: Load the candidate lists associated with a specific ballot
	Date: 2/1/2016
-->

<?php

// Returns an array of candidate ranks
function LoadCandidateLists($BID)
{
	$candidates = array();
	$query = mysql_query("SELECT * FROM candidate_list where BID = '$BID';") or die(mysql_error());
	$row = mysql_fetch_array($query);		

	if ($row['full_professor'] == 1) {
		array_push($candidates, "Full Professor");
	}

	if ($row['assistant_professor'] == 1) {
		array_push($candidates, "Assistant Professor");
	}

	if ($row['associate_professor'] == 1) {
		array_push($candidates, "Associate Professor");
	}

	if ($row['adjunct_faculty'] == 1) {
		array_push($candidates, "Adjunct Faculty");
	}

	if ($row['visiting_faculty'] == 1) {
		array_push($candidates, "Visiting Faculty");
	}

	if ($row['senior_staff'] == 1) {
		array_push($candidates, "Senior Staff");
	}

	if ($row['junior_staff'] == 1) {
		array_push($candidates, "Junior Staff");
	}


	if ($row['senior_librarian'] == 1) {
		array_push($candidates, "Senior Librarian");
	}

	if ($row['junior_librarian'] == 1) {
		array_push($candidates, "Junior Librarian");
	}

	if ($row['art_gallery_director'] == 1) {
		array_push($candidates, "Art Gallery Director");
	}
	return $candidates;
}

?>
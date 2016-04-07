<!--
	Author: Christian Yarros
	Purpose: Create a FacultyMember object and a function that returns an array full of all faculty information
	Date: 2/1/2016
-->

<?php
class FacultyMember {

	public $email;
	public $first_name;
	public $last_name;
	public $start_date;
	public $rank_type;
	public $rank_date;
}

function LoadFacultyList()
{
	$query = "SELECT * FROM faculty ORDER BY last_name"; 
	$result = mysql_query($query);

	$facultyList = array();
	while($row = mysql_fetch_array($result)){

		$fac = new FacultyMember();
		$fac->email = $row['email'];
		$fac->first_name = $row['first_name'];
		$fac->last_name = $row['last_name'];
		$fac->start_date = $row['start_date'];
		$fac->rank_type = $row['rank_type'];
		$fac->rank_date = $row['rank_date']; 	
		$facultyList[] = $fac;	
	}
	$_SESSION["faculty"] = serialize($facultyList);
}
?>
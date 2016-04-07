<!--
	Author: Christian Yarros
	Purpose: script to add elections to the database
	Date: 2/1/2016
-->

<?php include_once 'dbconnect.php';
include 'load_elections.php';

function CreateElection() {
	session_start();
 	$type = mysql_real_escape_string($_POST['election_type']);
 	$election_semester = $_POST['election_semester'];
	$election_year = $_POST['election_year'];
	$description = "Default Description";
	
	if(isset($_POST['description'])){
		$description = nl2br(htmlentities($_POST['description']));
	}

	$query = mysql_query("INSERT INTO elections(election_type, election_semester, election_year, description) VALUES('$type', '$election_semester','$election_year','$description');")
		  or die(mysql_error());

	LoadElections();	
	header("Location: http://cs-linuxlab-14.stlawu.local/admin.php");
	exit();

}

if (isset($_POST['create_election'])) {
        CreateElection();
}

?>

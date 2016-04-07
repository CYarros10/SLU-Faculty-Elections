<!--
	Author: Christian Yarros
	Purpose: Delete an election and all of its ballots and information
	Date: 2/1/2016
-->

<?php 
	session_start();
	include_once 'dbconnect.php';
	include_once 'load_elections.php';
	
	$EID = $_GET['eid'];

	$query1 = mysql_query("SELECT BID FROM ballots WHERE election_ID = '$EID'") or die (mysql_error()); 	

	while ($row = mysql_fetch_array($query1)) {
		$query2 = mysql_query("DELETE FROM votes WHERE ballots_BID = '$row[0]';") or die(mysql_error());
		$query3 = mysql_query("DELETE FROM voting_results WHERE ballots_BID = '$row[0]';") or die(mysql_error());
		$query4 = mysql_query("DELETE FROM candidate_list WHERE BID = '$row[0]';") or die(mysql_error());
		$query5 = mysql_query("DELETE FROM voter_list WHERE BID = '$row[0]';") or die(mysql_error());
		$query6 = mysql_query("DELETE FROM ballots WHERE BID = '$row[0]';") or die(mysql_error());
	}



	$query7 = mysql_query("DELETE FROM elections WHERE EID = '$EID'") or die (mysql_error()); 
	
	LoadElections();	
	header("Location: http://cs-linuxlab-14.stlawu.local/admin.php");
	exit();
?>

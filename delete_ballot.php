<!--
	Author: Christian Yarros
	Purpose: Delete a ballot and all its connected information from the database
	Date: 2/1/2016
-->

<?php 
	session_start();
	include_once 'dbconnect.php';
	include_once 'load_ballots.php';
	
	$BID = $_GET['bid'];
	
	$query1 = mysql_query("DELETE FROM candidate_list WHERE BID = '$BID';") or die(mysql_error());
	$query2 = mysql_query("DELETE FROM voter_list WHERE BID = '$BID';") or die(mysql_error());
	$query3 = mysql_query("DELETE FROM votes WHERE ballots_BID = '$BID';") or die(mysql_error());
	$query4 = mysql_query("DELETE FROM voting_results WHERE ballots_BID = '$BID';") or die(mysql_error());
	$query5 = mysql_query("DELETE FROM ballots WHERE BID = '$BID';") or die(mysql_error());

	LoadBallots();
	
	$EID = unserialize($_SESSION['current_election_id']);

	header("Location: http://cs-linuxlab-14.stlawu.local/election.php?id=$EID");
	exit();
?>

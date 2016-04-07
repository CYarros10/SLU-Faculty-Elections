<!--
	Author: Christian Yarros
	Purpose: Allow admin to enable or disable voting on a ballot
	Date: 2/1/2016
-->

<?php
include_once 'dbconnect.php';
include_once 'load_elections.php';
include_once 'load_ballots.php';
session_start();

$currentElections = unserialize($_SESSION["elections"]);
$currentBallots = unserialize($_SESSION["ballots"]);
$election = new Election();
$ballot = new Ballot();

$EID = $_GET['id'];
$BID = $_GET['bid'];
$status = $_GET['status'];

if ($status == 'enabled') {
	$query1 = mysql_query("UPDATE ballots SET status = 'disabled' where BID = '$BID';")
		  or die(mysql_error());
} 
else if ($status == 'disabled') {
	$query2 = mysql_query("UPDATE ballots SET status = 'enabled' where BID = '$BID';")
		or die(mysql_error());
}

header("Location: http://cs-linuxlab-14.stlawu.local/election.php?id=$EID");
exit();
?>
<?php
session_start();
include_once 'dbconnect.php';
include_once 'load_ballots.php';
include_once 'load_faculty.php';
LoadFacultyList();
$facultylist = unserialize($_SESSION["faculty"]);

LoadBallots();

$currentBallots = unserialize($_SESSION["ballots"]);
$ballot = new Ballot();
$BID = $_GET['bid'];

foreach ($currentBallots as $cb) {
	if ($BID === $cb->BID) {
		$ballot = $cb;
	}
}



$send_list = $_POST['send_list'];
$email = $_POST['sender'];
$subject = $_POST['subject'];
$message = $_POST['message'];

foreach($facultylist as $fac) {

	if ($send_list == 'Candidates' And $fac->rank_type == $ballot->candidate_list) {
		$to = $fac->email;
	}

	else {


			if ($ballot->voter_list == 'Tenure' And (
				($fac->rank_type === 'Full Professor') Or
				($fac->rank_type === 'Assistant Professor') Or
				($fac->rank_type === 'Associate Professor'))) {
				
				$to = $fac->email;
			
			}

			if ($ballot->voter_list == 'Other' And (
				($fac->rank_type === 'Adjunct Faculty') Or
				($fac->rank_type === 'Visiting Faculty'))) {

				$to = $fac->email;


			}
			if ($ballot->voter_list == 'Staff' And (
				($fac->rank_type === 'Senior Staff') Or
				($fac->rank_type === 'Junior Staff') Or
				($fac->rank_type === 'Senior Librarians') Or
				($fac->rank_type === 'Junior Librarians') Or
				($fac->rank_type === 'Art Gallery Director'))) {

				$to = $fac->email;

			}
	}

	$headers = 'test';

	mail($to, $subject, $message, $headers);
	?> Sent email to <?php echo $to;
	
}
?>
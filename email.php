<!--
	Author: Christian Yarros
	Purpose: Page for admin to create email to send to faculty
	Date: 2/1/2016
-->

<?php 
include_once 'dbconnect.php';
include_once 'load_ballots.php';
session_start();
LoadBallots();

$currentBallots = unserialize($_SESSION["ballots"]);
$ballot = new Ballot();
$BID = $_GET['bid'];

foreach ($currentBallots as $cb) {
	if ($BID === $cb->BID) {
		$ballot = $cb;
	}
}
?>

<!DOCTYPE HTML>
<html>
    <head>
        <title>Email</title>
        <link rel="stylesheet" type="text/css" href="\style.css">
	<link href='https://fonts.googleapis.com/css?family=PT+Sans|PT+Serif' rel='stylesheet' type='text/css'> </head>
    <body>
		<div id="header">
			<h1>SLU Faculty Elections - <?php echo "Ballot ". $BID; ?></h1>
			<form method="post" action="http://cs-linuxlab-14.stlawu.local/signout.php">
						<input type="submit" name ="signout" value="SIGN OUT"/>
					</form>
		</div> <!-- header -->
		
		<div id="content">
			<nav id="breadcrumbs">
				<a href="http://cs-linuxlab-14.stlawu.local/admin.php">Home</a> / 
				<?php
					echo "<a href=http://cs-linuxlab-14.stlawu.local/election.php?id=$ballot->election_ID>View Ballots</a>";
				?> /
				<a>Email Faculty</a>
			</nav>
			
			<div id="email_options">
				<h2>Email Options </h2>
				<form method="POST" enctype="application/x-www-form-urlencoded" action="email_script.php?bid=<?php echo $BID;?>">
					<input type="hidden" name="subject" value="Message to St. Lawrence University Faculty">
					<input type="hidden" name="recipient" value="">
					<input type="hidden" name="followup-page" value="">
					<fieldset class="textInputs">
						<ul>
							<li>
								<label for"send_list"> Send List: </label>
								<select id="send_list" name="send_list">
									<option value="Candidates">Candidates</option>
									<option value="Voters">Voters</option>
								</select>
							</li>
							<li>
								<label for="email">Your Email Address (required)</label>
								<input type="email" id="email" name="sender" title="Your primary email address" required>
							</li>
							<li>
								<label for="subject"> Subject </label>
								<input type="text" id="subject" name="subject" title="Subject of message" required >
							</li>
						</ul>
						<label for="message">Your Message</label>
						<textarea cols="40" rows="4" name="message" id="message"></textarea>
						<input type="submit" value="Send Email">
					</fieldset>
				</form>
			</div> <!-- email_options -->
		</div><!-- content -->
    </body>
</html>

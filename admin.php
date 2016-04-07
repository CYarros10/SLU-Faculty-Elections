<?php
include_once 'dbconnect.php';
include 'load_elections.php';
include 'load_faculty.php';
include 'load_ballots.php';
session_start();

if (isset($_SESSION["email"]) and $_SESSION["email"] = "admin") {
    $email = $_SESSION['email'];
    LoadElections();
    LoadFacultyList();
    LoadBallots();
?>

<!DOCTYPE HTML>
<html>
    <head>
        <title>Admin</title>
        <link rel="stylesheet" type="text/css" href="\style.css">
	<link href='https://fonts.googleapis.com/css?family=PT+Sans|PT+Serif' rel='stylesheet' type='text/css'>
    </head>
    <body>
	
	<div id="header">
		<h1>SLU Faculty Elections - ADMIN</h1>
		<form method="post" action="http://cs-linuxlab-14.stlawu.local/signout.php">
            <input type="submit" name ="signout" value="SIGN OUT"/>
        </form>
	</div> <!-- header -->

	<div id="content">
		<nav id="breadcrumbs">
  			<a>Home</a>
		</nav>

		<div id="tool_bar">
			<h2>Tools</h2>
			<ul>
				<li><a href="http://cs-linuxlab-14.stlawu.local/display_faculty_list.php">View Faculty Lists</a></li>
				<li><a href="http://cs-linuxlab-14.stlawu.local/create_election.php">Create Election</a></li>
			</ul>
		</div> <!-- tool_bar -->

		<div id="election_feed">
			<div id="election_header" style="padding:10px;">
				<h2>Election Timeline</h2>
			</div>
			
			<!-- Display Each Election and its information -->
			
			<?php 
				$currentElections = unserialize($_SESSION["elections"]);
				foreach ($currentElections as $ce) {
	 		?>
			
				<div id="election">
					<h3>Election <?php echo $ce->id . ': ' . $ce->type ?></h3>
					<p> <span class="label">Semester/Year:</span>
					
					<?php
						echo $ce->election_semester . ' ' . $ce->election_year;
					?>
					
					</p>

					<?php 	
						$currentBallots = unserialize($_SESSION["ballots"]);
						$ballot_count = 0;
						foreach ($currentBallots as $cb) {
							if ($cb->election_ID === $ce->id) {
								$ballot_count ++;
							}
						}
					?>

					<p> <span class="label">Number of Ballots:</span> <?php echo $ballot_count; ?></p>

					<p> <span class="label">Description:</span> <?php echo $ce->description; ?></p>
					<div id="actions">
			<?php
				echo "<a href='http://cs-linuxlab-14.stlawu.local/election.php?id=$ce->id' class='button'>View Ballots</a>";
				echo "<a href='http://cs-linuxlab-14.stlawu.local/delete_election.php?eid=$ce->id' class='button' >Delete This Election</a>";
			?>
					</div> <!-- actions -->
				</div> <!-- election -->
			<?php	
				}
			?>
		</div> <!-- election_feed -->
	</div> <!-- content -->
    </body>
</html>

<?php
}
else {
	echo "You are unauthorized to access this page";
}
?>
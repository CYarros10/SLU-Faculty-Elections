<!--
	Author: Christian Yarros
	Purpose: Admin page to create ballots
	Date: 2/1/2016
-->


<?php
include_once 'dbconnect.php';
session_start();
$EID = $_GET['eid'];
echo "Election: " . $EID;
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
			<h1>SLU Faculty Elections - <?php echo $_SESSION['email']; ?></h1>
			<form method="post" action="http://cs-linuxlab-14.stlawu.local/signout.php">
                <input type="submit" name ="signout" value="SIGN OUT"/>
            </form>
		</div> <!-- header -->
	
	<div id="content">
		
		<nav id="breadcrumbs">
  			<a href="http://cs-linuxlab-14.stlawu.local/admin.php">Home</a> / 
			<?php
				echo "<a href=http://cs-linuxlab-14.stlawu.local/election.php?id=$EID>View Ballots</a>";
			?> /
			<a>Create Ballot</a>
		</nav>
		
        	<div id="ballot_creator">
				<h2> Create A Ballot For Election <?php echo $EID; ?></h2>
                		<form method="POST" action="create_ballot_script.php">
					<div class="ballot_input">
                  			 <label for="ballot_type">Select Ballot Type:</label> 
						<select name="ballot_type">
							<option value="Preliminary">Preliminary</option>
							<option value="Final">Final</option>
							<option value="Other">Other</option>
						</select> 
					</div> <!-- ballot_input -->
					
					<div class="ballot_input">
		    			<label for="candidate_list">Select Candidate List(s):</label>
						<select id="candidate_list" name="candidate_list[]" required multiple>
							<option value="full_professor">Full Professor</option>
							<option value="assistant_professor">Assistant Professor</option>
							<option value="associate_professor">Associate Professor</option>
							<option value="adjunct_faculty">Adjunct Faculty</option>
							<option value="visiting_faculty">Visiting Faculty</option>
							<option value="senior_staff">Senior Staff</option>
							<option value="junior_staff">Junior Staff</option>
							<option value="senior_librarian">Senior Librarians</option>
							<option value="junior_librarian">Junior Librarians</option>
							<option value="art_gallery_director">Art Gallery Director</option>
						</select>
					</div> <!-- ballot_input -->

					<div class="ballot_input">
                    	<label for="voter_list">Select Voter List(s):</label>
		    			<select id="voter_list" name="voter_list[]" required multiple>
							<option value="tenured_and_tenured_track">Tenured and Tenure Track Faculty</option>
							<option value="other_faculty">Other Faculty</option>
							<option value="staff">Staff</option>
		    			</select>
					</div> <!-- ballot_input -->

					<div class="ballot_input">
		    			<label for="start_date">Start Date:</label> <input type="date" name="start_date" required>
		    		</div> <!-- ballot_input -->
						
					<div class="ballot_input">
						<label for="end_date">End Date:</label> <input type="date" name="end_date" required>
					</div> <!-- ballot_input -->
					
					<div class="ballot_input">
						<label for="votes_per_person">Votes Per Person:</label> <input type="number" name="votes_per_person" required>
		    		</div> <!-- ballot_input -->
					
					<input type="hidden" name="election_id" value="<?php echo $EID; ?>">
					<input id="ballot_submit" class="button" type="submit" name="create_ballot" value="Create Ballot">
                </form>
        	</div>
		</div>
    </body>
</html>


<!--
	Author: Christian Yarros
	Purpose: Allows admin to create an election
	Date: 2/1/2016
-->


<?php
include_once 'dbconnect.php';
session_start();
?>

<!DOCTYPE HTML>
<html>
    <head>
        <title>Election Creation</title>
        <link rel="stylesheet" type="text/css" href="\style.css">
	<link href='https://fonts.googleapis.com/css?family=PT+Sans|PT+Serif' rel='stylesheet' type='text/css'> </head>
    <body>
		<div id="header">
			<h1>SLU Faculty Elections</h1>
			<form method="post" action="http://cs-linuxlab-14.stlawu.local/signout.php">
				<input type="submit" name ="signout" value="SIGN OUT"/>
			</form>
		</div> <!-- header -->  	

		<div id="content">
		
			<nav id="breadcrumbs">
				<a href="http://cs-linuxlab-14.stlawu.local/admin.php">Home</a> / 
				<a>Create Election</a>
			</nav>
			<div id="election_creator">
				<h2> Create an Election </h2>
                	<form method="POST" action="create_election_script.php">
						
						<div class="election_input">		
							<label for="election_type">Select Election Type:</label>  
							<select name="election_type">
								<option value="Faculty Delegate to the Board of Trustees">Faculty Delegate to the Board of Trustees</option>
								<option value="Professional Standards Committee">Professional Standards Committee</option>
								<option value="Faculty Council">Faculty Council</option>
								<option value="General">General</option>
							</select>
						</div> <!-- election_input -->  	
				
						<div class="election_input">
							<label for="election_semester"> Election Semester:</label>
							<select name="election_semester">
								<option value="Fall">Fall</option>
								<option value="Spring">Spring</option>
							</select>
						</div> <!-- election_input -->  	
				
						<div class="election_input">
							<label for="election_year"> Election Year:</label>
							<input type="number" name="election_year" min="2016">
						</div> <!-- election_input -->  	

						<div class="election_input">
							<label id="election_description" for="description"> Description: </label> 
							<textarea id="election_textarea" name="description">Enter election description here.</textarea>
						</div> <!-- election_input -->
						
					<input id="election_submit" class="button" type="submit" name="create_election" value="Create Election">
				</form>
       		</div> <!-- election_creator -->  	
		</div> <!-- content -->  	
    </body>
</html>

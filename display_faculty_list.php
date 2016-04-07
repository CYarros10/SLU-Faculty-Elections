<!--
	Author: Christian Yarros
	Purpose: Display the faculty lists for the admin
	Date: 2/1/2016
-->

<?php 
include_once 'dbconnect.php';
include_once 'load_faculty.php';
session_start();
LoadFacultyList();
$facultyList = unserialize($_SESSION["faculty"]);
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
 	 		<h1>SLU Faculty Elections</h1>
			<form method="post" action="http://cs-linuxlab-14.stlawu.local/signout.php">
                <input type="submit" name ="signout" value="SIGN OUT"/>
            </form>
		</div> <!-- header -->
	
		<div id="content">
			<nav id="breadcrumbs">
				<a href="http://cs-linuxlab-14.stlawu.local/admin.php">Home</a> / 
				<a>Faculty List</a>
			</nav>	

			<div id="faculty_list">
				
				<div id="faculty_list_header">
				<h2>Faculty List</h2>
                		<form method="post" action="http://cs-linuxlab-14.stlawu.local/file_upload.php" enctype="multipart/form-data">
							 *To add/edit faculty, please upload a CSV file: <input class="upload" type="file" name="csvfile" accept=".csv"/>
							<input type="submit" name="upload"  value="Submit" />
               			</form>
				</div> <!-- file_upload -->

			<?php
				// Display all emails except admin
				foreach ($facultyList as $fac) {	
		 			if ($fac->email != 'admin') {	
			?>
				<div class="faculty">
					
					<table>
						<?php echo "<caption> $fac->first_name $fac->last_name </caption>"; ?>
						<tr>
							<td> <span class="label"> Email: </span> <?php echo $fac->email; ?> </td>
							<td> <span class="label"> Start Date: </span> <?php echo $fac->start_date; ?></td>
						</tr>
						<tr>
							<td> <span class="label"> Rank Type: </span> <?php echo $fac->rank_type; ?></td>
							<td> <span class="label"> Rank Date: </span> <?php echo $fac->rank_date; ?></td>
						</tr>
					</table>
				</div> <!-- faculty -->
			<?php
					}
				}
			?>
			</div> <!-- faculty_list -->
		</div> <!-- content -->
	</body>
</html>

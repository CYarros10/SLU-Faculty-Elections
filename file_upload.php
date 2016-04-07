<!--
	Author: Christian Yarros
	Purpose: Allow admin to upload csv file to update faculty in database
	Date: 2/1/2016
-->

<?php include_once 'dbconnect.php';
include_once 'load_faculty.php';

function FileUpload()
{
	session_start();
	if (is_uploaded_file($_FILES["csvfile"]["tmp_name"])) {
		$file = $_FILES["csvfile"]["tmp_name"];

		$query1 = mysql_query("DELETE FROM temp;") or die(mysql_error());
		$query2 = mysql_query("LOAD DATA LOCAL INFILE '$file' INTO TABLE temp 
					FIELDS TERMINATED BY ',' LINES TERMINATED BY '\r\n' IGNORE 1 LINES 
					(email,@start_date,rank_type,@rank_date, first_name, last_name) 
					set start_date = str_to_date(@start_date, '%m/%d/%Y'), rank_date = str_to_date(@rank_date, '%m/%d/%Y');") 
					or die(mysql_error());
		$query3 = mysql_query("REPLACE INTO faculty(email) SELECT email FROM temp;") or die(mysql_error()); 		
		$query4 = mysql_query("UPDATE faculty t1, temp t2 SET 	t1.start_date = t2.start_date, 
								  	t1.rank_date = t2.rank_date, 
								  	t1.rank_type = t2.rank_type,
									t1.first_name = t2.first_name,
									t1.last_name = t2.last_name		 
									WHERE t1.email = t2.email;") or die(mysql_error());
	}
	else {
		$file = null;
		echo "no file supplied";
	}
	LoadFacultyList();
	header("Location: http://cs-linuxlab-14.stlawu.local/display_faculty_list.php");
	exit();
}

if (isset($_POST['upload'])) {
	FileUpload();
}
?>
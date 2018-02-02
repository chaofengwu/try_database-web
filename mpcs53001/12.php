<?php

// Connection parameters 
$host = 'mpcs53001.cs.uchicago.edu';
$username = 'chaofeng';
$password = 'Eo7ohkoo';
$database = 'chaofengDB';

// Attempting to connect 
$dbcon = mysqli_connect($host, $username, $password, $database)
   or die('Could not connect: ' . mysqli_connect_error());
print 'Connected successfully!<br>';

// Getting the input parameter:
$ID = $_REQUEST['StudentID'];
$numbering = $_REQUEST['coursenumbering'];
if(!is_numeric($ID)){
	print "ID should be numeric.<br>";
	echo "<a href=\"javascript:history.go(-1)\">GO BACK</a>";
	die();
}
#print "$username, $password, $validation";
// Find whether the username is used
#print "SELECT * from user where username = '$username'";
$query = "SELECT * from Take where Take.StudentID = $ID and Take.CourseNumbering = '$numbering'";
$result = mysqli_query($dbcon, $query);

//check result and show result
$num = mysqli_num_rows($result);
#print "$num";
if($num != 0){
	print("This student($ID) has been in course $numbering. Go back to Admin Page automatically after 5 sec.");
	header('Refresh: 5;http://mpcs53001.cs.uchicago.edu/~chaofeng/administrator_page2.html');
}
else{
	$query = "SELECT * from Student where Student.ID = $ID";
	$result = mysqli_query($dbcon, $query);
	$num = mysqli_num_rows($result);
	#print "$num";
	if($num == 0){
		print("Student not exists. Go back to Admin Page automatically after 5 sec.");
		header('Refresh: 5;http://mpcs53001.cs.uchicago.edu/~chaofeng/administrator_page2.html');
	}
	else{
		$query = "SELECT * from Course where Course.numbering = '$numbering'";
		$result = mysqli_query($dbcon, $query);
		$num = mysqli_num_rows($result);
		#print "$num";
		if($num == 0){
			print("Course not exists. Go back to Admin Page automatically after 5 sec.");
			header('Refresh: 5;http://mpcs53001.cs.uchicago.edu/~chaofeng/administrator_page2.html');
		}
		else{
			$tuple = mysqli_fetch_array($result, MYSQLI_ASSOC);
			$coursetitle = $tuple[title];
			$query = "INSERT into Take (StudentID, CourseNumbering, Grade) values ($ID, '$numbering', null)";
			$result = mysqli_query($dbcon, $query)
				or die('Operation failed: ' . mysqli_error());
			print 'Update Successfully! Go to Admin Page automatically after 5 sec.';
				header('Refresh: 5;http://mpcs53001.cs.uchicago.edu/~chaofeng/administrator_page2.html');
		}
	}
	
}

// Free result
mysqli_free_result($result);

// Closing connection
mysqli_close($dbcon);
?>

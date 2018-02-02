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
$student = $_REQUEST['StudentID'];
$advisor = $_REQUEST['AdvisorID'];
if(!is_numeric($student) or !is_numeric($advisor)){
	print "ID should be numeric.<br>";
	echo "<a href=\"javascript:history.go(-1)\">GO BACK</a>";
	die();
}
#print "$username, $password, $validation";
// Find whether the username is used
#print "SELECT * from user where username = '$username'";
$query = "SELECT * from Advisor where StudentID = $student";
$result = mysqli_query($dbcon, $query);

//check result and show result
$num = mysqli_num_rows($result);
#print "$num";
if($num == 0){
	print("This student($student) is not advised by advisor. If want to add an advisor, using function 15. Go back to Admin Page automatically after 5 sec.");
	header('Refresh: 5;http://mpcs53001.cs.uchicago.edu/~chaofeng/administrator_page2.html');
}
else{
	$query = "SELECT * from Faculty where ID = $advisor";
	$result = mysqli_query($dbcon, $query);
	$num = mysqli_num_rows($result);
	#print "$num";
	if($num == 0){
		print("Advisor not exists. Go back to Admin Page automatically after 5 sec.");
		header('Refresh: 5;http://mpcs53001.cs.uchicago.edu/~chaofeng/administrator_page2.html');
	}
	else{
		$query = "UPDATE Advisor set AdvisorID = $advisor where StudentID = $student";
		$result = mysqli_query($dbcon, $query)
			or die('Operation failed: ' . mysqli_error());
		print 'Update Successfully! Go to Admin Page automatically after 5 sec.';
		header('Refresh: 5;http://mpcs53001.cs.uchicago.edu/~chaofeng/administrator_page2.html');
	}
}

// Free result
mysqli_free_result($result);

// Closing connection
mysqli_close($dbcon);
?>

<?php

// Connection parameters 
$host = 'mpcs53001.cs.uchicago.edu';
$username = 'chaofeng';
$password = 'Eo7ohkoo';
$database = $username.'DB';

// Attempting to connect
$dbcon = mysqli_connect($host, $username, $password, $database)
   or die('Could not connect: ' . mysqli_connect_error());
print 'Connected successfully!<br>';

// Getting the input parameter:
$ID = $_REQUEST['IDnum'];

if(!is_numeric($ID)){
	print "ID should be numeric.<br>";
	echo "<a href=\"javascript:history.go(-1)\">GO BACK</a>";
	die();
}
//query
$query = "SELECT * FROM Student WHERE ID = $ID";
$result = mysqli_query($dbcon, $query)
		or die('Query failed: ' . mysqli_error($dbcon));

//check result and show result
$num = mysqli_num_rows($result);
if($num != 0){
	while($tuple = mysqli_fetch_array($result, MYSQLI_ASSOC)){
		print "<b>$ID</b> is a <b>Student</b>, and has the following attributes:";
		print '<ul>';  
		print '<li> ID: '.$tuple['ID'];
		print '<li> Name: '.$tuple['name'];
		print '<li> Department: '.$tuple['departmentin'];
		print '</ul>';
	}
}
else{
	$query = $query = "SELECT * FROM Faculty WHERE ID = $ID";
	$result = mysqli_query($dbcon, $query)
			or die('Query failed: ' . mysqli_error($dbcon));
	$num = mysqli_num_rows($result);
	if($num != 0){
		while($tuple = mysqli_fetch_array($result, MYSQLI_ASSOC)){
			print "<b>$ID</b> is a <b>Faculty</b>, and has the following attributes:";
			print '<ul>';  
			print '<li> ID: '.$tuple['ID'];
			print '<li> Name: '.$tuple['name'];
			print '<li> Title: '.$tuple['title'];
			print '<li> Department: '.$tuple['departmentin'];
			print '<li> Field: '.$tuple['field'];
			print '</ul>';
		}
	}
	else{
		print "there is no student or Faculty with ID $ID.";
		echo "<a href=\"javascript:history.go(-1)\">GO BACK</a>";
		die();
	}
}
echo "<a href=\"javascript:history.go(-1)\">GO BACK</a>";
// Free result
mysqli_free_result($result);

// Closing connection
mysqli_close($dbcon);
?> 
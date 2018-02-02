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
$user = $_REQUEST['name'];
$type = $_REQUEST['type'];

// Query
$query = "SELECT * FROM $type WHERE name LIKE '%$user%'";
$result = mysqli_query($dbcon, $query)
  or die('Query failed.' . "<a href=\"javascript:history.go(-1)\">GO BACK</a>");

// check result and show result
$num = mysqli_num_rows($result);
if($num == 0){
	print "$type $user not found!";
	echo "<a href=\"javascript:history.go(-1)\">GO BACK</a>";
	die();
}
else{
	print "There are $num $type(s) whose name contains <b>$user</b>.<br>";
	if($type == 'Student'){
		while($tuple = mysqli_fetch_array($result, MYSQLI_ASSOC)){
			print "$type <b>$user</b> has the following attributes:";
			print '<ul>';  
			print '<li> ID: '.$tuple['ID'];
			print '<li> Name: '.$tuple['name'];
			print '<li> Department: '.$tuple['departmentin'];
			print '</ul>';
		}
	}
	else{
		while($tuple = mysqli_fetch_array($result, MYSQLI_ASSOC)){
			print "$type <b>$user</b> has the following attributes:";
			print '<ul>';  
			print '<li> ID: '.$tuple['ID'];
			print '<li> Name: '.$tuple['name'];
			print '<li> Title: '.$tuple['title'];
			print '<li> Department: '.$tuple['departmentin'];
			print '<li> Field: '.$tuple['field'];
			print '</ul>';
		}
	}
};
echo "<a href=\"javascript:history.go(-1)\">GO BACK</a>";
// Free result
mysqli_free_result($result);

// Closing connection
mysqli_close($dbcon);
?> 
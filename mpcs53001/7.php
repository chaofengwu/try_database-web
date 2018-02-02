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
$num = $_REQUEST['num'];
if(!is_numeric($num)){
	print "ID should be numeric.<br>";
	echo "<a href=\"javascript:history.go(-1)\">GO BACK</a>";
	die();
}
// Query
$query = "SELECT ID, name, departmentin from Faculty where ID in (select AdvisorID from Advisor group by AdvisorID having count(*) >= $num)";
$result = mysqli_query($dbcon, $query)
  or die('Query failed: ' . mysqli_error($dbcon));

// check result and show result
$count = mysqli_num_rows($result);
print "There are $count faculty advise at least $num students.";
while($tuple = mysqli_fetch_array($result, MYSQLI_ASSOC)){
	print '<ul>';  
	print '<li> ID: '.$tuple['ID'];
	print '<li> name: '.$tuple['name'];
	print '<li> department in: '.$tuple['departmentin'];
	print '</ul>';
}

echo "<a href=\"javascript:history.go(-1)\">GO BACK</a>";
// Free result
mysqli_free_result($result);

// Closing connection
mysqli_close($dbcon);
?> 
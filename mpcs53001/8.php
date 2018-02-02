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
$grade = $_REQUEST['grade'];
if(!is_numeric($num) or !is_numeric($grade)){
	print "number of course  or grade should be numeric.<br>";
	echo "<a href=\"javascript:history.go(-1)\">GO BACK</a>";
	die();
}
// Query
$query = "SELECT * from Student where ID in (select StudentID from Take left outer join Course on Take.CourseNumbering = Course.numbering where Take.Grade >= $grade group by StudentID having count(*) >= $num)";
$result = mysqli_query($dbcon, $query)
  or die('Query failed: ' . mysqli_error($dbcon));
$count = mysqli_num_rows($result);
print "There are $count students take at least $num courses and in each getting grade no lower than $grade.";
while($tuple = mysqli_fetch_array($result, MYSQLI_ASSOC)){
			print '<ul>';  
			print '<li> ID: '.$tuple['ID'];
			print '<li> Name: '.$tuple['name'];
			print '<li> Department: '.$tuple['departmentin'];
			print '</ul>';
}

echo "<a href=\"javascript:history.go(-1)\">GO BACK</a>";
// Free result
mysqli_free_result($result);

// Closing connection
mysqli_close($dbcon);
?> 
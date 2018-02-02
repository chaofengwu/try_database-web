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
$grade = $_REQUEST['grade'];
if(!is_numeric($grade)){
	print "Grade should be numeric.<br>";
	echo "<a href=\"javascript:history.go(-1)\">GO BACK</a>";
	die();
}
// query
$query = "SELECT numbering, coursetitle, instructor FROM Course WHERE numbering in (select CourseNumbering from Take group by CourseNumbering having avg(Grade) >= $grade)";
$result = mysqli_query($dbcon, $query)
  or die('Query failed: ' . mysqli_error($dbcon));

//check result and show result
$count = mysqli_num_rows($result);
print "There are $count courses that have average grade at least $grade.";
while($tuple = mysqli_fetch_array($result, MYSQLI_ASSOC)){
	print '<ul>';  
	print '<li> numbering: '.$tuple['numbering'];
	print '<li> coursetitle: '.$tuple['coursetitle'];
	print '<li> instructor: '.$tuple['instructor'];
	print '</ul>';
}

echo "<a href=\"javascript:history.go(-1)\">GO BACK</a>";
// Free result
mysqli_free_result($result);

// Closing connection
mysqli_close($dbcon);
?> 
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
// query
$query = "SELECT Course.numbering, Course.coursetitle, Course.instructor, Take.Grade 
			from Take left outer join Course on Take.CourseNumbering = Course.numbering
			where Take.StudentID = $ID";
$result = mysqli_query($dbcon, $query)
  or die('Query failed: ' . mysqli_error($dbcon));

// check result and show result
$count = mysqli_num_rows($result);
print "There are $count courses that the student take.";
while($tuple = mysqli_fetch_array($result, MYSQLI_ASSOC)){
	print '<ul>';  
	print '<li> numbering: '.$tuple['numbering'];
	print '<li> coursetitle: '.$tuple['coursetitle'];
	print '<li> instructor: '.$tuple['instructor'];
	print '<li> Grade: '.$tuple['Grade'];
	print '</ul>';
}

echo "<a href=\"javascript:history.go(-1)\">GO BACK</a>";
// Free result
mysqli_free_result($result);

// Closing connection
mysqli_close($dbcon);
?> 
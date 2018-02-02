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

// get tables in your database
$query = 'SHOW TABLES';
$result = mysqli_query($dbcon, $query)
  or die('Show tables failed: ' . mysqli_error());

print "The tables and attributes in $database database are:<br>";

// Printing table names and all attributes of each table in HTML
print '<ul>';
while ($tuple = mysqli_fetch_row($result)) {
	$query = "SELECT COLUMN_NAME from information_schema.COLUMNS where table_name = '$tuple[0]'";
	$table_result = mysqli_query($dbcon, $query)
  		or die('Show tables failed: ' . mysqli_error());
  	print '<hr>';
   	print "$tuple[0]";
   	print '';
   	while ($temp = mysqli_fetch_row($table_result)) {
   		print '<li>'."&nbsp;&nbsp;&nbsp;$temp[0]".'</li>';
   	}
}
print '</ul>';
echo "<a href=\"javascript:history.go(-1)\">GO BACK</a>";
// Free result
mysqli_free_result($result);

// Closing connection
mysqli_close($dbcon);
?>
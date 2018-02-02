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
$type = $_REQUEST['type'];

#print "$username, $password, $validation";
// Find whether the username is used
#print "SELECT * from user where username = '$username'";
$query = "SELECT COLUMN_NAME from INFORMATION_SCHEMA.COLUMNS where TABLE_SCHEMA = '$database' and TABLE_NAME = '$type'";
//$query = "SELECT column_name from '$type'";
//print($query);
$column = mysqli_query($dbcon, $query)
	or die('Get column failed: ' . mysqli_error());
$col = array();
while($tuple = mysqli_fetch_row($column)){
	array_push($col, $tuple[0]);
}
print($col[1]);
$query = "SELECT * from $type";
$result = mysqli_query($dbcon, $query)
	or die('Operation failed: ' . mysqli_error());
print 'Get history Successfully!<br>';
print '<ul>';
while ($tuple = mysqli_fetch_row($result)) {
	//print(sizeof($tuple));
	print '<br>';
	$len = round(sizeof($tuple)/2)+1;
	for($i = 0; $i < sizeof($tuple); $i++){
		/*if($i == 0){
			print "<b> time and modification:</b><br>";
		}
		if($i == 2){
			print "<b> old data:</b><br>";
		}
		if($i == $len){
			print "<b>new data:</b><br>";
		}*/
		print "$col[$i]: \t";
		if($tuple[$i] == ''){
			print "<b>null</b><br>";
		}
		else{
			print"<b>$tuple[$i]</b><br>";
		}
	}
	print '<br><hr>';
}
print '</ul>';
echo "<center><a href='http://mpcs53001.cs.uchicago.edu/~chaofeng/administrator_page2.html'>Go back to admin page2.</a></center><br>'";

// Free result
mysqli_free_result($result);

// Closing connection
mysqli_close($dbcon);
?>

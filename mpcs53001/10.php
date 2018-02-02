<?php

// Connection parameters 
$host = 'mpcs53001.cs.uchicago.edu';
$username = 'chaofeng';
$password = 'Eo7ohkoo';
$database = 'chaofengDB';
$validation_code = '12345678';
// Attempting to connect 
$dbcon = mysqli_connect($host, $username, $password, $database)
   or die('Could not connect: ' . mysqli_connect_error());
print 'Connected successfully!<br>';

// Getting the input parameter:
$username = $_REQUEST['nam'];
$password = $_REQUEST['pw'];
$validation = $_REQUEST['validation'];
#print "$username, $password, $validation";
// Find whether the username is used
#print "SELECT * from user where username = '$username'";
$query = "SELECT * from user where user.username = '$username'";
$result = mysqli_query($dbcon, $query);

//check result and show result
$num = mysqli_num_rows($result);
#print "$num";
if($num == 0){
	print("Invalid username. Please go back and check your username. Go back to Admin Page automatically after 5 sec.");
	header('Refresh: 5;http://mpcs53001.cs.uchicago.edu/~chaofeng/administrator_page2.html');
}
else{
	$tuple = mysqli_fetch_array($result, MYSQLI_ASSOC);
	if($password != $tuple[password]){
		print("Invalid password. Please go back and check your password. Go back to Admin Page automatically after 5 sec.");
		header('Refresh: 5;http://mpcs53001.cs.uchicago.edu/~chaofeng/administrator_page2.html');
	}
	else{
		if($tuple[position] == 1){
			if($validation_code == $validation){
				$query = "UPDATE user set position = 0 where username = '$username'";
				$result = mysqli_query($dbcon, $query)
				  or die('Add new user failed: ' . mysqli_error());
				print 'Update Successfully! Go to Admin Page automatically after 5 sec.';
				header('Refresh: 5;http://mpcs53001.cs.uchicago.edu/~chaofeng/administrator_page2.html');
			}
			else{
				print ('Wrong validation code. Go back to Admin Page automatically after 5 sec.');
				header('Refresh: 5;http://mpcs53001.cs.uchicago.edu/~chaofeng/administrator_page2.html');
			}
		}
		else{
			print ('Update fault: this user is admin. Go back to Admin Page automatically after 5 sec.');
			header('Refresh: 5;http://mpcs53001.cs.uchicago.edu/~chaofeng/administrator_page2.html');
		}
	}
}

// Free result
mysqli_free_result($result);

// Closing connection
mysqli_close($dbcon);
?>



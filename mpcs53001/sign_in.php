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
$username = $_REQUEST['nam'];
$password = $_REQUEST['pw'];

// check user
#print "SELECT * from user where username = '$username'";
$query = "SELECT * from user where user.username = '$username'";
$result = mysqli_query($dbcon, $query);

//check result and show result
$num = mysqli_num_rows($result);
#print "$num";
if($num == 0){
	print("Invalid username. Please go back and check your username. Go back to Sign In page automatically after 5 sec.");
	header('Refresh: 5;http://mpcs53001.cs.uchicago.edu/~chaofeng/final.html');
}
else{
	$tuple = mysqli_fetch_array($result, MYSQLI_ASSOC);
	if($password != $tuple[password]){
		print("Invalid password. Please go back and check your password. Go back to Sign In page automatically after 5 sec.");
		header('Refresh: 5;http://mpcs53001.cs.uchicago.edu/~chaofeng/final.html');
	}
	else{
		if($tuple[position] == 0){
			header('Location: http://mpcs53001.cs.uchicago.edu/~chaofeng/administrator_page.html');
		}
		elseif($tuple[position] == 1){
			header('Location: http://mpcs53001.cs.uchicago.edu/~chaofeng/user_page.html');
		}
		else{}
	}
}


// Free result
mysqli_free_result($result);

// Closing connection
mysqli_close($dbcon);
?>



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

//create user table if not exist
$create_table = 'Create table if not exists user (
					username varchar(255),
					password varchar(255),
					position int,
					primary key (username)
				)';
$result = mysqli_query($dbcon, $create_table)
  or die('Create tables failed: ' . mysqli_error());

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
if($num != 0){
	print("Username <b>$username</b> is used by other user, please go back and change a username. Go back to Sign Up page automatically after 5 sec.");
	//sleep(5);
	header('Refresh: 5;http://mpcs53001.cs.uchicago.edu/~chaofeng/registration.html');
}

else{
	if($validation == $validation_code){
		$query = "INSERT into user (username, password, position) values ('$username', '$password', 0)";	
		$result = mysqli_query($dbcon, $query)
	  or die('Add new user failed: ' . mysqli_error());
	  print 'You can sign in now as administrator! Go back to Sign Up page automatically after 5 sec.';
	  header('Refresh: 5;http://mpcs53001.cs.uchicago.edu/~chaofeng/final.html');
	}
	elseif($validation == ''){
		$query = "INSERT into user (username, password, position) values ('$username', '$password', 1)";
		$result = mysqli_query($dbcon, $query)
	  or die('Add new user failed: ' . mysqli_error());
	  print 'You can sign in now as user! Go back to Sign Up page automatically after 5 sec.';
	  header('Refresh: 5;http://mpcs53001.cs.uchicago.edu/~chaofeng/final.html');
	}
	else{
		print('invalid validation for administrator. If you want to be user, leave Validation blank. Go back to Sign Up page automatically after 5 sec.');
		header('Refresh: 5;http://mpcs53001.cs.uchicago.edu/~chaofeng/registration.html');
	}
}








// Free result
mysqli_free_result($result);

// Closing connection
mysqli_close($dbcon);
?>



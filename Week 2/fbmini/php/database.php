<?php
require 'facebook/facebook.php';

class MySqlDatabase
{
    public $connection;
    function MySqlDatabase()
    {

    	$host = 'ec2-50-112-164-92.us-west-2.compute.amazonaws.com';
    	$user = 'local_user';
    	$pass = 'm3PLYLupd8uMjFXv';
    	$schema = 'fbmini';

$this->connection= new mysqli('ec2-50-112-164-92.us-west-2.compute.amazonaws.com','local_user','m3PLYLupd8uMjFXv','fbmini',3306);
        if ($this->connection->connect_errno) {
	    	echo "Failed to connect to MySQL: (" . $this->connection->connect_errno . ") " . $this->connection->connect_error;
		}

		//echo $this->connection->host_info . "\n";
	}
}
$database = new MySqlDatabase();

// Create our Application instance (replace this with your appId and secret).
$facebook = new Facebook(array(
  'appId'  => '528190557239926',
  'secret' => '026a167d39b684337548d5092f7bcdeb',
));

// Get User ID
$user = $facebook->getUser();
// We may or may not have this data based on whether the user is logged in.
//
// If we have a $user id here, it means we know the user is logged into
// Facebook, but we don't know if the access token is valid. An access
// token is invalid if the user logged out of Facebook.

if ($user) {
  try {
    // Proceed knowing you have a logged in user who's authenticated.
    $user_profile = $facebook->api('/me');
  } catch (FacebookApiException $e) {
    error_log($e);
    $user = null;
  }
}

// Login or logout url will be needed depending on current user state.
if ($user) { 

	$mysqli = $database->connection;

	/* Prepared statement, stage 1: prepare */
	if (!($stmt = $mysqli->prepare("SELECT * FROM `users` WHERE facebookID = ?"))) {
		echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}

	/* Prepared statement, stage 2: bind and execute */
	if (!$stmt->bind_param("s", $user_profile['id'])) {
		echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
	}

	if (!$stmt->execute()) {
		echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
	}

	$stmt->store_result();

	if($stmt->num_rows == 0){
		/* Prepared statement, stage 1: prepare */
		if (!($stmt = $mysqli->prepare("INSERT INTO `fbmini`.`users` (`name`,`facebookID`) VALUES(?,?)"))) {
			echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
		}

		/* Prepared statement, stage 2: bind and execute */
		if (!$stmt->bind_param("ss", $user_profile['id'],$user_profile['name'])) {
			echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
		}

		if (!$stmt->execute()) {
			echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
		}

	}

	/* explicit close recommended */
	$stmt->close();

/*
	$sql = "SELECT * 
		FROM  `user` 
		WHERE user_id =  '".$user_profile['id'];

	$result = mysql_query($sql,$database->connection);	
	if(!$result){
		$sql = "INSERT INTO  `movienet`.`user` (
			`user_id` ,
			`name`
				)
				VALUES (
						'".$user_profile['id']."',  '".$user_profile['name']."'
				       )";

		$result = mysql_query($sql,$database->connection);
	}
*/
}
?>

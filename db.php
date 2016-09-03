<?php
$url = parse_url(getenv("CLEARDB_DATABASE_URL"));

$server = $url["host"];
$username = $url["user"];
$password = $url["pass"];
$db = substr($url["path"], 1);

$conn = new mysqli($server, $username, $password, $db);


// does basic database queries and returns the result
function  db_query($conn, $sql)
{
	if ($result = $conn->query($sql)) {
		$rows = $result->fetch_assoc();
	}
	return $rows;
}


// selects a cpmpletely random message from the database
function select_random_msg($conn) 
{
	$sql = "SELECT response FROM kraken_msg ORDER BY RAND() LIMIT 1";
	$row = db_query($conn, $sql);
	return $row['response'];
}


// gets a random response given a telegram username
function select_user_msg($conn, $username)
{
	$sql = "SELECT response FROM kraken_msg WHERE user_attrib = '" . $username . "' ORDER BY RAND() LIMIT 1";
	$row = db_query($conn, $sql);
	return $row['response'];
}


// Finds the id of the given message. If there are duplicates, the id of the most recent entry is given.
function find_id($conn, $msg) {
	
	$sql = "SELECT id FROM kraken_msg WHERE response = '$msg' ORDER BY time DESC LIMIT 1";
	if ($result = $conn->query($sql)) {
		$rows = $result->fetch_assoc();
	}
	return $rows['id'];
}


// Gets the username of the submitter of a particular message
function find_user_submit($conn, $id) {
	
	$sql = "SELECT user_submit FROM kraken_msg WHERE id = $id LIMIT 1";
	if ($result = $conn->query($sql)) {
		$row = $result->fetch_assoc();
	}
	return $row['user_submit'];
}


// Adds a new message (and submitting username) to the database, returning the id of the row if succesful.
function add_msg($conn, $msg, $user_submit) {
	
	$sql = "INSERT INTO kraken_msg (response, user_submit) VALUES ('$msg', '$user_submit')";
	if ($conn->query($sql) === TRUE) 
	{
		return find_id($conn, $msg);
	} 
	else 
	{
		return false;
	}
}



// us-cdbr-iron-east-04.cleardb.net/

?>




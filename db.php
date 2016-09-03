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

// us-cdbr-iron-east-04.cleardb.net/

?>




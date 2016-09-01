<?php
 $url = parse_url(getenv("CLEARDB_DATABASE_URL"));

$server = $url["host"];
$username = $url["user"];
$password = $url["pass"];
$db = substr($url["path"], 1);

$conn = new mysqli($server, $username, $password, $db);

function db_query($conn, $sql) 
{
	if ($result = $conn->query($sql)) {
		$rows = $result->fetch_assoc();
	}
	return $rows;
}

function select_random_msg($conn) 
{
	$sql = "SELECT response FROM kraken_msg ORDER BY RAND() LIMIT 1";
	$row = db_query($conn, $sql);
	return $row['response'];
}

function select_user_msg($conn, $username)
{
	$sql = "SELECT response FROM kraken_msg WHERE user_attrib = '" . $username . "' ORDER BY RAND() LIMIT 1";
	$row = db_query($conn, $sql);
	return $row['response'];
}

function add_msg($conn, $msg, $user_submit, $user_attrib='', $phrase='') {
	
	$sql = "INSERT INTO kraken_msg (response, phrase, user_submit, user_attrib) 
		VALUES ('" . $msg . "', '" . $phrase . "', '" . $user_submit . "', '" . $user_attrib . "')";
	return db_query($conn, $sql);
}

print_r add_msg($conn, 'hihi says mysql', 'huayyi');

// 
// function select_random_msg($conn) 
// {
// 	$sql = "SELECT response FROM kraken_msg ORDER BY RAND() LIMIT 1";
// 	if ($result = $conn->query($sql)) {
// 		$row = $result->fetch_assoc();
// 	}
// 	return $row['response'];
// }
// 
// echo select_random_msg();

?>




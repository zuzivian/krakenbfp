<?php
 $url = parse_url(getenv("CLEARDB_DATABASE_URL"));

$server = $url["host"];
$username = $url["user"];
$password = $url["pass"];
$db = substr($url["path"], 1);

$conn = new mysqli($server, $username, $password, $db);

function db_query($conn) 
{
	if ($result = $conn->query($sql)) {
		$rows = $result->fetch_assoc();
	}
	return $rows;
}

function select_random_msg($conn) 
{
	$sql = "SELECT response FROM kraken_msg ORDER BY RAND() LIMIT 1";
	$row = db_query($conn);
	return $row['response'];
}

echo select_random_msg();

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




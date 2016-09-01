<?php
 $url = parse_url(getenv("CLEARDB_DATABASE_URL"));

$server = $url["host"];
$username = $url["user"];
$password = $url["pass"];
$db = substr($url["path"], 1);


$conn = new mysqli($server, $username, $password, $db);


function select_random_msg() {
	$sql = "SELECT response FROM kraken_msg ORDER BY RAND() LIMIT 1";
	if ($result = $conn->query($sql)) {
		$row = $result->fetch_assoc();
		return $row['response'];
	}
	else return null;
}

echo select_random_msg();

?>
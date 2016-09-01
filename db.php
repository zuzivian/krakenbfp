<?php
 $url = parse_url(getenv("CLEARDB_DATABASE_URL"));

$server = $url["host"];
$username = $url["user"];
$password = $url["pass"];
$db = substr($url["path"], 1);

echo "hi4";

$conn = new mysqli($server, $username, $password, $db);

$sql = "SELECT response FROM kraken_msg LIMIT 1";
if ($result = $conn->query($sql)) {
	$msg = $result->fetch_assoc();
}

// print_r $msg;

?>




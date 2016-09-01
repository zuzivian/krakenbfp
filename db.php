<?php
 $url = parse_url(getenv("CLEARDB_DATABASE_URL"));

$server = $url["host"];
$username = $url["user"];
$password = $url["pass"];
$db = substr($url["path"], 1);

$conn = new mysqli($server, $username, $password, $db);

//function select_random_msg() 
//{
	$sql = "SELECT response FROM kraken_msg LIMIT 1";
	if ($result = $conn->query($sql)) {
		$row = $result->fetch_assoc();
	}
	echo $row['response'];
//}

//select_random_msg();

// function select_random_msg() {
// 	$query = "SELECT response FROM kraken_msg ORDER BY RAND() LIMIT 1";
// 	if($database->num_rows( $query ) > 0)
// 	{
//     	list($msg) = $database->get_row($query);
//     	return $msg[];
// 	}	
// 	else 
// 	{
// 		return null;
// 	}
// 	
// }

?>




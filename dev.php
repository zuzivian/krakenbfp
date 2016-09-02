<?php

include 'db.php';


function add_msg($conn, $msg, $user_submit, $user_attrib, $phrase) {
	
	// $sql = "INSERT INTO kraken_msg (response, phrase, user_submit, user_attrib) 
	//	VALUES ('" . $msg . "', '" . $phrase . "', '" . $user_submit . "', '" . $user_attrib . "')";
	$sql = "INSERT INTO kraken_msg (response, phrase, user_submit, user_attrib) VALUES ('$msg', '$phrase', '$user_submit', '$user_attrib')";
	if ($conn->query($sql) === TRUE) 
	{
		return true;
	} else 
	{
		return false;
	}
}

if (add_msg($conn, 'cray', 'tool_kit', '', '')) {
	echo "done!";
} 
else
{
	echo "error!";
} 



?>
<html>
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


if (isset($_POST['user_submit']) && isset($_POST['msg'])) {
	
	if (isset($_POST['user_attrib'])) 
	{
		$user_attrib = $_POST['user_submit'];
	}
	else
	{
		$user_attrib = '';
	}
	
	if (isset($_POST['phrase'])) 
	{
		$phrase = $_POST['phrase'];
	}
	else
	{
		$phrase = '';
	}
	
	if (add_msg($conn, $_POST['msg'], $_POST['user_submit'], $user_attrib, $phrase)) {
		echo "Congratulations. Your message has been submitted: <br>" . $_POST['msg'];
	} 
	else
	{
	echo "Error, your submission failed. Please try again.";
	
}


?>


<h3>Add to KRAKEN's dictionary</h3>
<form action="dev.php" method="post">
Your Telegram username: <input type="text" name="user_submit"><br>
Enter a new KRAKEN response: <input type="text" name="msg"><br>
Response should be used in reply to this word (optional): <input type="text" name="phrase"><br>
Kraken should use this response on this Telegram username (optional): <input type="text" name="user_attrib"><br>
<input type="submit">
</form>
</html>
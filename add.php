<html>
<?php

include 'db.php';


function add_msg2($conn, $msg, $user_submit, $user_attrib, $phrase) {

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
	
	$user_submit = mysqli_real_escape_string($conn, $_POST['user_submit']);
	$msg = mysqli_real_escape_string($conn, $_POST['msg']);
	
	if (isset($_POST['user_attrib'])) 
	{
		$user_attrib = mysqli_real_escape_string($conn, $_POST['user_submit']);
	}
	else
	{
		$user_attrib = '';
	}
	
	if (isset($_POST['phrase'])) 
	{
		$phrase = mysqli_real_escape_string($conn, $_POST['phrase']);
	}
	else
	{
		$phrase = '';
	}
	
	if (add_msg2($conn, $_POST['msg'], $_POST['user_submit'], $user_attrib, $phrase)) 
	{
		echo "Congratulations. Your message has been submitted: <br>" . $_POST['msg'];
	} 
	else
	{
		echo "Error, your submission failed. Please try again.";
	}
	
}


?>


<h3>Add to KRAKEN's dictionary</h3>
<form action="add.php" method="post">
Your Telegram username: <input type="text" name="user_submit"><br>
Enter a new KRAKEN response: <input type="text" name="msg"><br>
Response should be used in reply to this word (optional): <input type="text" name="phrase"><br>
Kraken should use this response on this Telegram username (optional): <input type="text" name="user_attrib"><br>
<input type="submit">
</form>
</html>
<?php

include 'db.php';

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

// Updates a user's message, given the id
function update_user_msg($conn, $user_submit, $id, $new_msg) {
	
	// check if the editor is the wrightful owner of the message.
	if (find_user_submit($conn, $id) == $user_submit) {
		// if so update the message
		$sql = "UPDATE kraken_msg SET response = '$new_msg' WHERE id = $id";
		return $conn->query($sql);
	}
	else return false; //fail
}


// updates the user attributed to a message
function update_user_attrib($conn, $user_submit, $id, $user_attrib) {
	
	// check if the editor is the wrightful owner of the message.
	if (find_user_submit($conn, $id) == $user_submit) {
		// if so update the message
		$sql = "UPDATE kraken_msg SET user_attrib = '$user_attrib' WHERE id = $id";
		return $conn->query($sql);
	}
	else return false; //fail
}


// updates a phrase associated with a message
function update_phrase($conn, $user_submit, $id, $phrase) {
	
	// check if the editor is the wrightful owner of the message.
	if (find_user_submit($conn, $id) == $user_submit) {
		// if so update the message
		$sql = "UPDATE kraken_msg SET phrase = '$phrase' WHERE id = $id";
		return $conn->query($sql);
	}
	else return false; //fail
}


// deletes an entire message.
function delete_msg($conn, $user_submit, $id) {
	
	// check if the editor is the wrightful owner of the message.
	if (find_user_submit($conn, $id) == $user_submit) {
		// if so update the message
		$sql = "DELETE FROM kraken_msg WHERE id = $id";
		return $conn->query($sql);
	}
	else return false; //fail
}


?>
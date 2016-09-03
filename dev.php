<?php

include 'db.php';


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





?>
<?php

require_once 'message.php';

class AdminUtils
{
	
	public $db = null;
	
	public function __construct() {
		$db = new Database;
	}
	
	// Adds a new message (and submitting username) to the database, 
	// returns the id of the row if succesful.
	public function add_msg($msg, $submit, $phrase = '', $attrib = '') 
	{
		$msg = $db->real_escape_string($msg);
		$attrib = $db->real_escape_string($atrib);
		$submit = $db->real_escape_string($submit);
		$phrase = $db->real_escape_string($phrase);
		$phrase = strtolower($phrase);						
		$sql = "INSERT INTO kraken_msg VALUES ('', '', '$phrase','$msg', '$submit', 'attrib')";
		
		if ($db->query($sql) === TRUE) 
		{
			$msgproc = new MessageProc;
			$msgproc->select_from_msg($msg);
			return $msgproc->msg->id;
		} 
		return false;
	
	}
	
	
	// Deletes an entire message.
	public function delete_msg($user_submit, $id) {
		$id = $db->real_escape_string($conn, $id);
		$msgproc = new MessageProc;
		$msgproc->select_from_id($id);
		// check if the editor is the wrightful owner of the message.
		if ($msgproc->msg->user_submit == $user_submit) {
			// if so delete the row
			$sql = "DELETE FROM kraken_msg WHERE id = $id";
			return $db->query($sql);
		}
		else return false; //fail
	}
	
	
	// Updates a user's message, given the id. Returns 1 if successful.
	public function update_msg($user_submit, $id, $new_msg) {
		$id = $db->real_escape_string($id);
		$new_msg = $db->real_escape_string($new_msg);
		// check if the editor is the rightful owner of the message.
		$msgproc = new MessageProc;
		$msgproc->select_from_id($id);
		if ($msgproc->msg->user_submit == $user_submit) {
			// if so update the message
			$sql = "UPDATE kraken_msg SET response = '$new_msg' WHERE id = $id";
			return $db->query($sql);
		}
		else return false; //fail
	}
	
	
	// updates the user attributed to a message. Returns 1 if successful.
	public function update_user_attrib($user_submit, $id, $user_attrib) {

		$user_attrib = $db->real_escape_string($user_attrib);
		$id = $db->real_escape_string($id);
		// check if the editor is the wrightful owner of the message.
		$msgproc = new MessageProc;
		$msgproc->select_from_id($id);
		if ($msgproc->msg->user_submit == $user_submit) {
			// if so update the message
			$sql = "UPDATE kraken_msg SET user_attrib = '$user_attrib' WHERE id = $id";
			return $db->query($sql);
		}
		else return false; //fail
	}


	// updates a phrase associated with a message. Returns 1 if successful.
	public function update_phrase($user_submit, $id, $phrase) {
		$phrase = $db->real_escape_string($phrase);
		$id = $db->real_escape_string($id);	
		// check if the editor is the rightful owner of the message.
		$msgproc = new MessageProc;
		$msgproc->select_from_id($id);
		if ($msgproc->msg->user_submit == $user_submit) {
			$phrase = strtolower($phrase);
			// if so update the message
			$sql = "UPDATE kraken_msg SET phrase = '$phrase' WHERE id = $id";
			return $db->query($sql);
		}
		else return false; //fail
	}
	
	// Displays the details of a message, given its id.
	public function display_msg($id) {
		$proc = new MessageProc;
		$proc->select_from_id($id);
		if ($res = $proc->msg) {
			$msg = "Message ID: " . $id;
			$msg .= "\nSubmitted by: " . $res['user_submit'];
			$msg .= "\nTrigger word: " . $res['phrase'];
			$msg .= "\nAttributed to: " . $res['user_attrib'];
			$msg .= "\nMessage: " . $res['response'];
		}
		else
		{
			$msg = "No such message found.";
		}
		return $msg;
	}
	
	// find the message ids attributed to the user
	public function select_from_submitter($user) {	
		$username = $user->username;
		$sql = "SELECT * FROM kraken_msg WHERE user_submit = '$username' ORDER BY id";
		return $db->query($sql);
	}
	
	// provides a list of messages belonging to user_submit
	public function display_user_msgs($user_submit, $id='') {
		$proc = new MessageProc;
		if($rows = $this->select_from_submitter($user_submit)) {
			$msg .= "\n\nHere are the messages that you have already added:\nID / trigger / attrib";
			foreach ($rows as $row) {
				$msg .=  "\n" . $row['id'] . " / " . $row['phrase'] . " / " . $row['user_attrib'];
			}
			return $msg;
		}
		else return $this->display_msg($id);
	}
	
	// Processes a forwarded message and returns the appropriate message.
	public function forwarded_msg($text) {

		if ($proc->select_from_msg($text)) 
		{
			return $utils->display_msg($id);
		}
		else return error_msg('notfound');
	}

}
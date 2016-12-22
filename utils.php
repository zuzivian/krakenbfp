<?php

require_once 'database.php';
require_once 'message.php';

class AdminUtils
{
	
	public $db = null;
	
	public function __construct() {
		$this->db = new Database;
	}
	
	// Adds a new message (and submitting username) to the database, 
	// returns the id of the row if succesful.
	public function add_msg($msg, $submit, $phrase = '', $attrib = '') 
	{
 		$msg = $this->db->real_escape_string($msg);
 		$attrib = $this->db->real_escape_string($attrib);
 		$submit = $this->db->real_escape_string($submit);
 		$phrase = $this->db->real_escape_string($phrase);
		$phrase = strtolower($phrase);						
		$sql = "INSERT INTO kraken_msg (phrase, response, user_submit, user_attrib) VALUES ('$phrase','$msg', '$submit', '$attrib')";
		
		if ($this->db->query($sql) === TRUE) 
		{
			$msgproc = new MessageProc;
			return $msgproc->select_from_msg($msg)->id;
		} 
		return false;
	
	}
	
	
	// Deletes an entire message.
	public function delete_msg($user_submit, $id) {
		$id = $this->db->real_escape_string($conn, $id);
		$msgproc = new MessageProc;
		$msgproc->select_from_id($id);
		// check if the editor is the wrightful owner of the message.
		if ($msgproc->msg->user_submit == $user_submit) {
			// if so delete the row
			$sql = "DELETE FROM kraken_msg WHERE id = $id";
			return $this->db->query($sql)[0];
		}
		else return false; //fail
	}
	
	
	// Updates a user's message, given the id. Returns 1 if successful.
	public function update_msg($user_submit, $id, $new_msg) {
		$id = $this->db->real_escape_string($id);
		$new_msg = $this->db->real_escape_string($new_msg);
		// check if the editor is the rightful owner of the message.
		$msgproc = new MessageProc;
		$msgproc->select_from_id($id);
		if ($msgproc->msg->user_submit == $user_submit) {
			// if so update the message
			$sql = "UPDATE kraken_msg SET response = '$new_msg' WHERE id = $id";
			return $this->db->query($sql)[0];
		}
		else return false; //fail
	}
	
	
	// updates the user attributed to a message. Returns 1 if successful.
	public function update_user_attrib($user_submit, $id, $user_attrib) {

		$user_attrib = $this->db->real_escape_string($user_attrib);
		$firstchar = substr($user_attrib, 0,1);
		if ($firstchar == '@') {
			$user_attrib = substr($user_attrib, 1);
		}
		$id = $this->db->real_escape_string($id);
		// check if the editor is the rightful owner of the message.
		$msgproc = new MessageProc;
		$msgproc->select_from_id($id);
		if ($msgproc->msg->user_submit == $user_submit) {
			// if so update the message
			$sql = "UPDATE kraken_msg SET user_attrib = '$user_attrib' WHERE id = $id";
			return $this->db->query($sql)[0];
		}
		else return false; //fail
	}


	// updates a phrase associated with a message. Returns 1 if successful.
	public function update_phrase($user_submit, $id, $phrase) {
		$phrase = $this->db->real_escape_string($phrase);
		$id = $this->db->real_escape_string($id);	
		// check if the editor is the rightful owner of the message.
		$msgproc = new MessageProc;
		$msgproc->select_from_id($id);
		if ($msgproc->msg->user_submit == $user_submit) {
			$phrase = strtolower($phrase);
			// if so update the message
			$sql = "UPDATE kraken_msg SET phrase = '$phrase' WHERE id = $id";
			return $this->db->query($sql)[0];
		}
		else return false; //fail
	}
	
	// Displays the details of a message, given its id.
	public function display_msg($id) {
		$proc = new MessageProc;
		if ($res = $proc->select_from_id($id)) {
			$msg = "Message ID: " . $id;
			$msg .= "\nSubmitted by: " . $res->user_submit;
			$msg .= "\nTrigger word: " . $res->phrase;
			$msg .= "\nAttributed to: " . $res->user_attrib;
			$msg .= "\nMessage: " . $res->response;
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
		return $this->db->query($sql);
	}
	
	// provides a list of messages belonging to user_submit
	public function display_user_msgs($user_submit) {
		$proc = new MessageProc;
		if($rows = $this->select_from_submitter($user_submit)) {
			$msg .= "\n\nHere are the messages that you have already added:\nID / trigger / attrib";
			foreach ($rows as $row) {
				$msg .=  "\n" . $row->id . " / " . $row->phrase . " / " . $row->user_attrib;
			}
			return $msg;
		}
		else return $this->display_msg($id);
	}
	
	// Processes a forwarded message and returns the appropriate message.
	public function forwarded_msg($text) {

		if ($proc->select_from_msg($text) == TRUE)
		{
			return $this->display_msg($proc->msg->id);
		}
		else return error_msg('notfound');
	}

}
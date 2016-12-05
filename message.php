<?php

require_once 'database.php';

class MessageProc
{
	
	public $msg = null;
	public $db = null;
	
	public function __construct() {
		$this->db = new Database;
	}
	
	
	// selects a completely random message from the database
	public function select_random()
	{
		$sql = "SELECT * FROM kraken_msg ORDER BY RAND() LIMIT 1";
		$res = $this->db->query($sql);
		$this->msg = $res[0];
		if ($res) {
			$this->msg = $res[0];
			return $res[0];
		}
		return false;
	}
	
	// gets a messages given a telegram username
	public function select_from_attrib($user) {
		$db = new Database;	
		$username = $user->id;
		$sql = "SELECT * FROM kraken_msg WHERE user_attrib = '$username' ORDER BY RAND() LIMIT 1";
		$res = $this->db->query($sql);
		$this->msg = $res[0];
		if ($res) {
			$this->msg = $res[0];
			return $res[0];
		}
		return false;
	}
	
	// Finds  id of the given message. 
	// If there are duplicates, the id of the most recent entry is given.
	public function select_from_id($id) {
		$id = $this->db->real_escape_string($id);
		$sql = "SELECT * FROM kraken_msg WHERE id = '$id' LIMIT 1";		
		$res = $this->db->query($sql);
		$this->msg = $res[0];
		if ($res) {
			$this->msg = $res[0];
			return $res[0];
		}
		return false;
	}

	
	// Returns the DatabaseResult object that corresponds to text
	public function select_from_msg($text) {
		
		$text = $db->real_escape_string($text);
		$sql = "SELECT * FROM kraken_msg WHERE response = '$text' ORDER BY id LIMIT 1";
		$res = $this->db->query($sql);
		$this->msg = $res[0];
		if ($res) {
			$this->msg = $res[0];
			return $res[0];
		}
		return false;
	}
	
	// Returns the DatabaseResult object that corresponds to text
	public function search_msg($text) {
		
		$text = $db->real_escape_string($text);
		$sql = "SELECT * FROM kraken_msg WHERE response LIKE '%$text%' ORDER BY id LIMIT 1";
		$res = $this->db->query($sql);
		$this->msg = $res[0];
		if ($res) {
			$this->msg = $res[0];
			return $res[0];
		}
		return false;
	}	
	
	
		// Return the database message object from the text of the message
	public function select_from_phrase($phrase) {
		
		$phrase = $this->db->real_escape_string($phrase);
		$sql = "SELECT * FROM kraken_msg WHERE phrase = '$phrase' ORDER BY RAND() id LIMIT 1";
		$res = $this->db->query($sql);
		$this->msg = $res[0];
		if ($res) {
			$this->msg = $res[0];
			return $res[0];
		}
		return false;
	}
	
	public function select_from_user_phrase($user, $phrase) {
		
		$username = $user->username;
		$phrase = $this->db->real_escape_string($phrase);
		$sql = "SELECT * FROM kraken_msg WHERE user = '$username' AND phrase = '$phrase' ORDER BY RAND() LIMIT 1";
		$res = $this->db->query($sql);
		$this->msg = $res[0];
		if ($res) {
			$this->msg = $res[0];
			return $res[0];
		}
		return false;
	}
	
}
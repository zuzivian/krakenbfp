<?php

require_once 'database.php';

class User
{
	static public $id = null;
	static public $first_name = null;
	static public $last_name = null;
	static public $username = null;
	
	public function __construct($user) {
		$user->id = $this->id;
		$user->first_name = $this->first_name;	
		$user->last_name = $this->last_name;
		$user->username = $this->username;
	}
}
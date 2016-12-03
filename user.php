<?php

require_once 'database.php';

class User
{
	public $id = null;
	public $first_name = null;
	public $last_name = null;
	public $username = null;
	
	public function __construct($id, $first_name, $last_name, $username) {
		$this->id = $id;
		$this->first_name = $first_name;	
		$this->last_name = $last_name;
		$this->username = $username;
	}
}
<?php

// database.php
// Contains classes for basic databsae operations

require_once 'config.php';

class DatabaseResult {

  	private $_results = array();
 
  	public function __construct(){}

	public function __set($var,$val){	
		$this->results[$var] = $val;
	}
 
	public function __get($var){  
    	if (isset($this->_results[$var])){
      		return $this->_results[$var];
    	}
    	else { return null; }
  	} 
}


class Database {
	
	// Holds db stuff 
	static private $host = null;
	static private $user = null;
	static private $pass = null;
	static private $db = null;
	
	private $conn = null;
	
	public function __construct() {
		$this->host = $dbhost;
		$this->user = $dbuser;
		$this->pass = $dbpass;
		$this->$db = $db_db;
	}
	
	public function connect() {
		$conn = new mysqli($host, $username, $password, $db);
	}
	
	private function query($sql) {
		
		$this->connect();
		$res = $conn->query($sql);
		
		if ($res) {
			if (strpos($sql, 'SELECT') === FALSE) {
				return true; // Query successful
			}
		}
		else {
			if (strpos($sql, 'SELECT') === FALSE) {
				return false; // Query unsuccessful
			}
			else {
				return null; // SELECT query found nothing
			}
		}	
		
		// Else, process results from SELECT
		
		$results = array();
		
		while($row = $res->fetch_array()) {
			$result = new DatabaseResult;
			foreach ($row as $k=>$v){
     			$result->$k = $v;
    		}
    		$results[] = $result;
		}
		
		return $results;
	}
	
}
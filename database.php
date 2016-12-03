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
	private $conn = null;
	
	public function __construct() {
		$cleardb_info = parse_url(getenv("CLEARDB_DATABASE_URL"));
		$host = $cleardb_info["host"];
		$user = $cleardb_info["user"];
		$pass = $cleardb_info["pass"];
		$db = substr($cleardb_info["path"], 1);
		$this->conn = new mysqli($host, $user, $pass, $db);
	}
	
	
	public function real_escape_string($str) {
		return $this->conn->real_escape_string($str);
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
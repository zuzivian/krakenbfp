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
	private $host = null;
	private $user = null;
	private $pass = null;
	private $db = null;
	
	private $conn = null;
	
	public function __construct() {
		$url = parse_url(getenv("CLEARDB_DATABASE_URL"));
		$this->host = $url["host"];
		$this->user = $url["user"];
		$this->pass = $url["pass"];
		$this->db = substr($url["path"], 1);
	}
	
	public function connect() {
		$this->conn = new mysqli($this->host, $this->user, $this->pass, $this->db)
			or die ("<br/>Could not connect to MySQL server");;
	}
	
	
	public function real_escape_string($str) {
		$this->connect();
		return $this->conn->real_escape_string($str);
	}	
	
	public function query($sql) {
		
		$this->connect();
		$res = $this->conn->query($sql);
		
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
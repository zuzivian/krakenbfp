<?php

$dburl = parse_url(getenv("CLEARDB_DATABASE_URL"));

define( 'DB_HOST', $dburl["host"] ); // set database host
define( 'DB_USER', $dburl["user"] ); // set database user
define( 'DB_PASS', $dburl["pass"] ); // set database password
define( 'DB_NAME', 'heroku_0b78291926dec44' ); // set database name
define( 'SEND_ERRORS_TO', 'error@kraken.com' ); //set email notification email address
define( 'DISPLAY_DEBUG', false ); // display db errors?

require 'simple-mysqli/sqldb.php';

//Initiate the class
$database = new DB();


/*
USAGE

// Retrieve results of a standard query
$query = "SELECT group_name FROM example_phpmvc";
$results = $database->get_results( $query );

// Retrieving a single row of data
$query = "SELECT group_id, group_name, group_parent FROM example_phpmvc WHERE group_name LIKE '%Awesome%'";
if( $database->num_rows( $query ) > 0 )
{
    list( $id, $name, $parent ) = $database->get_row( $query );
    echo "<p>With an ID of $id, $name has a parent of $parent</p>";
}

*/


// Gets one random message from the entire table
function select_random_msg() {
	$query = "SELECT response FROM kraken_msg LIMIT 1";
	if($database->num_rows( $query ) > 0)
	{
    	list($msg) = $database->get_row($query);
    	return $msg;
	}	
	else 
	{
		return null;
	}
	
}

print_r ($database->get_row("SELECT response FROM kraken_msg LIMIT 1"));


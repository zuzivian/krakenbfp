<?php

require_once 'vendor/simple-mysqli/class.db.php';

define( 'DB_HOST', 'sql3.freemysqlhosting.net' ); // set database host
define( 'DB_USER', 'sql3133872' ); // set database user
define( 'DB_PASS', 'bfnqrRuN6h' ); // set database password
define( 'DB_NAME', 'sql3133872' ); // set database name
define( 'SEND_ERRORS_TO', 'error@kraken.com' ); //set email notification email address
define( 'DISPLAY_DEBUG', true ); //display db errors?


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
	$query = "SELECT response FROM kraken_msg ORDER BY RAND() LIMIT 1";
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

echo select_random_msg;

?>
<?php

require_once 'database.php';
require_once 'utils.php';
require_once 'commands.php';
require_once 'config.php';
require_once 'user.php';


$db = new Database;


$db->query("SELECT * FROM kraken_msg ORDER BY RAND() LIMIT 1");

foreach ($msgs as $msg) {

	echo $msg
	
}


?>


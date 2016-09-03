<?php

/*
--------------------------------------
KRAKEN: A BFP BOT
--------------------------------------
*/

// DO NOT EDIT
$time_pre = microtime(true);
require 'vendor/autoload.php';
require 'db.php';

$client = new Zelenin\Telegram\Bot\Api('252926927:AAE7Fa8RTYW2D-RVYJ1B6_A77QZg5vWLJNg'); // Set your access token
$update = json_decode(file_get_contents('php://input'));

// DO NOT EDIT THE ABOVE


// --------------------------------------
/* FUNCTIONS */
// Beware when editing please.


// coming soon

// added so far:
// $conn is a given instance of the SQL connection
// gets the message's username $update->message->from->username
// db_query($conn, $sql);
// select_user_msg($conn, $update->message->from->username)
// select_random_msg($conn);

/* END FUNCTIONS */
// -------------------------------------



//   -------------------
//   MESSAGE PROCESSING
//   -------------------
// This is where the bot's logic resides.


// Takes incoming message and breaks it down into an array of strings, one word per string
// Usage: '$words[0]' means the first word in the message
$words = explode(" ", $update->message->text);
$cmd = $words[0];
$user_submit = $update->message->from->username;

// The Bot now decides, based on the ruleset, on an appropriate response, or to keep quiet.

// LIST OF EXISTING COMMANDS
// add - adds to Kraken's existing repertoire (broken)
// help - shows list of available commands
// nonsense - encourages the Kraken to spew some nonsense 

if ($update->message->chat->type == “private”) {
	if (strpos($cmd, '/addmsg') == 0)
	{
		$msg = "Feature unavailable. Sorry folks.";
	}

	else if (strpos($cmd, '/updatemsg') == 0) 
	{
		$msg = "Feature unavailable. Sorry folks.";	
	}

	else if (strpos($cmd, '/deletemsg') == 0) 
	{
		$msg = "Feature unavailable. Sorry folks.";
	}

	else if (strpos($cmd, '/updatetrigger') == 0) 
	{
		$msg = "Feature unavailable. Sorry folks.";
	}

	else if (strpos($cmd, '/updateattrib') == 0) 
	{
		$msg = "Feature unavailable. Sorry folks.";
	}

}

else if ( (strpos($cmd, '/addmsg') == 0) || (strpos($cmd, '/updatemsg') == 0) || (strpos($cmd, '/deletemsg') == 0) || (strpos($cmd, '/updatetrigger') == 0) || (strpos($cmd, '/updateattrib') == 0) )
{
	$msg = "Hey @$user_submit, you'll want to use that command in a private chat with me.";
}


else if (strpos($cmd, '/help') == 0) 
{
	$msg = "List of commands (incomplete) :\n /addmsg - adds a message to Kraken's existing repertoire  \n /help - Shows list of available commands \n /nonsense - encourages Kraken to spew nonsense ";
}

else if (strpos($cmd, '/nonsense') == 0) 
{
	// Spew nonsense.
	$msg = select_random_msg($conn);
}

else    
{
	// See if anything is worth a reply
	for ($i = 0; $words[$i]; $i++) 
	{
	   $sql = "SELECT response FROM kraken_msg WHERE phrase = '" . $words[$i] . "' ORDER BY RAND() LIMIT 1";
      if (list($dbmsg) = db_query($conn, $sql)) 
		{
          $dbmsg = db_query($conn, $sql);
          $msg = $dbmsg['response'];
			break;
		}
	}

	if (!$msg && rand(1,15) == 1) 
	{
		$msg = "@" . $update->message->from->username . " " . select_user_msg($conn, $user_submit);
	}
	
	// If all else fails, rolls a dice to see if bot should keep quiet or spew nonsense.
	if (!$msg && rand(1,50) == 1) 
	{
		$msg = select_random_msg($conn);
	}
	
	// Gives Kraken some chill.
	if (rand(1,2) == 1) 
	{
		$msg = null;
	}
}



// ----------------
// SENDING MESSAGE
// ----------------

// If an appropriate message response exists, send it via the Telegram API to the chat. 
// Do not edit!   
if ($msg) {
	// Sends the "Typing..." action to Telegram
	$response = $client->sendChatAction(['chat_id' => $update->message->chat->id, 'action' => 'typing']);
	
	// Now sends the approriate message
	$response = $client->sendMessage([
     	'chat_id' => $update->message->chat->id,
		'text' => $msg
 	]);
 }
    
    

// Display something on the webpage

$time_post = microtime(true);
$exec_time = $time_post - $time_pre; 
echo $exec_time*1000 . " ms";
echo "<br><br>Random Message:<br>";
echo select_random_msg($conn);

// -------------------------    
// END OF SCRIPT. WOOHOO!
// -------------------------


?>
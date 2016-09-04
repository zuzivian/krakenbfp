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
$text = $update->message->text;
$words = explode(" ", $text);
$cmd = $words[0];
$user_submit = $update->message->from->username;
$chat_type = $update->message->chat->type;

// The Bot now decides, based on the ruleset, on an appropriate response, or to keep quiet.

// LIST OF EXISTING COMMANDS
// add - adds to Kraken's existing repertoire (broken)
// help - shows list of available commands
// nonsense - encourages the Kraken to spew some nonsense 

if ($chat_type == "private") 
{
	if ($cmd == '/addmsg')
	{
		if (count($words) == 1) {
			$msg = "The format for /addmsg is: \n\n/addmsg This is the message that I want to add!";
		}
		else  
		{
			$response = substr(strstr($text," "), 1);
			$id = add_msg($conn, $response, $user_submit);
			$msg = "Your message has been added to Kraken's database! (ID: $id, Message: $response)";
		}
	}

	else if ($cmd == '/updatemsg') 
	{
		if (count($words) < 3) 
		{
			$msg = "Assuming the ID of the message you are updating is 999, the format for /updatemsg is: \n\n/addmsg 999 This is the message that I want to update!";
		}
		else  
		{
			$id = intval($words[1]);
          $response1 = str_replace("/updatemsg", "", $text);
          $response2 = str_replace($id, "", $response1);
          $response = str_replace("  ", "", $response2);
			if (update_user_msg($conn, $user_submit, $id, $response)) 
			{			
				$msg = "Your message has been updated in Kraken's database! (ID: $id, Messsage: $response)";
			}
			else 
			{
				$msg = "Sorry, the update failed. Did you use the right ID?";
			}
		}
	}

	else if ($cmd == '/deletemsg') 
	{
		if (count($words) == 1) 
		{
			$msg = "Assuming the ID of the message you are updating is 999, the format for /deletemsg is: \n\n/deletemsg 999";
		}
		else  
		{
			$id = intval($words[1]);
			if (delete_msg($conn, $user_submit, $id)) 
			{
				$msg = "Your message has been removed from Kraken's database - if it is yours. (ID: $id)";
			}
			else
			{
				$msg = "Can't delete a message that isn't yours!";
			}
		}
	}

	else if ($cmd == '/updatetrigger') 
	{
		if (count($words) != 3) 
		{
			$msg = "Kraken uses triggers to decide if he should respond to messages, based on the contents of each message. Assuming the ID of the message you are updating is 999, the format for /deletemsg is: \n\n/updatetrigger 999 myfavoritetriggerword";
		}
		else
		{
			$id = intval($words[1]);
			$phrase = $words[2];
			if (update_phrase($conn, $user_submit, $id, $phrase)) 
			{
				$msg = "Your message trigger has been updated. (ID: $id, trigger: $phrase)";
			}
			else
			{
				$msg = "Can't trigger a message that isn't yours!";
			}
		}
	}

	else if ($cmd == '/updateattrib') 
	{
		if (count($words) != 3) 
		{
			$msg = "Kraken uses attribs to decide if he should respond to someone. Usernames are caSe Sensitive! Assuming the ID of the message you are updating is 999, the format for /deletemsg is: \n\n/updateattrib 999 teleusername";
		}
		else
		{
			$id = intval($words[1]);
			$attrib = $words[2];
			if (update_user_attrib($conn, $user_submit, $id, $attrib)) 
			{
				$msg = "Your user attrib has been updated. (ID: $id, attrib: $attrib)";
			}
			else
			{
				$msg = "Can't attrib a message that isn't yours!";
			}
		}
	}

}

else if ( $cmd == '/addmsg' || $cmd == '/updatemsg' || $cmd == '/deletemsg' || $cmd == '/updatetrigger' || $cmd == '/updateattrib' )
{
	$msg = "Hey @$user_submit, you'll want to use $cmd in a private chat with me.";
}

else if ( $cmd == '/addmsg@bfpbot' || $cmd == '/updatemsg@bfpbot' || $cmd == '/deletemsg@bfpbot' || $cmd == '/updatetrigger@bfpbot' || $cmd == '/updateattrib@bfpbot' )
{
	$msg = "Hey @$user_submit, you'll want to use $cmd in a private chat with me.";
}


if (!$msg && ($cmd == "/help" || $cmd == "/help@bfpbot")) 
{
	$msg = "List of commands: \naddmsg - Adds to Kraken's repertoire \ndeletemsg - Deletes a message of your own \nhelp - shows list of available commands
\nnonsense - encourages kraken to spew nonsense
\nupdateattrib - Updates the person attributed to a msg
\nupdatemsg - Updates a message
\nupdatetrigger - Updates the word associated with a msg ";
}

else if ($cmd == "/nonsense" || $cmd == "/nonsense@bfpbot") 
{
	// Spew nonsense.
	$msg = select_random_msg($conn);
}

else if (!$msg)   
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
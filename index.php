<?php

/*
--------------------------------------
KRAKEN: A BFP BOT
--------------------------------------
*/

// DO NOT EDIT
require 'vendor/autoload.php';
// Database functions can be found in db.php
require 'db.php';

$client = new Zelenin\Telegram\Bot\Api('252926927:AAE7Fa8RTYW2D-RVYJ1B6_A77QZg5vWLJNg'); // Set Telegram access token
$update = json_decode(file_get_contents('php://input'));


// FUNCTIONS

function display_id($conn, $id) 
{

	if ($row = get_row($conn, $id)) {
		$msg = "Message ID: " . $id;
		$msg .= "\nSubmitted by: " . $row['user_submit'];
		$msg .= "\nTrigger word: " . $row['phrase'];
		$msg .= "\nAttributed person: " . $row['user_attrib'];
		$msg .= "\nMessage: " . $row['response'];
	}
	else
	{
		$msg = "No such message found.";
	}
	return $msg;
}

//   -------------------
//   MESSAGE PROCESSING
//   -------------------
// This is where the bot's message logic resides.


// Takes incoming message and breaks it down into an array of strings, $words

$text = $update->message->text;
$words = explode(" ", $text);
$cmd = $words[0];
$user_submit = $update->message->from->username;
$chat_type = $update->message->chat->type;
$reply_to_user = "@" . $user_submit . " ";

// The Bot now decides, based on the ruleset, on an appropriate response, or keeps quiet.


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
			if (find_id($conn, $response)) {
				$msg = "Sorry, you can't add that. Someone else has already submitted that message!";
			}
			else {
				$id = add_msg($conn, $response, $user_submit);
				$msg = "Your message has been added to Kraken's database! (ID: $id, Message: $response)";
			}
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
				$msg = "Your message has been removed from Kraken's database. (ID: $id)";
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
			$msg = "Kraken uses triggers to decide if he should respond to messages, based on the contents of each message. \n\nAssuming the ID of the message you are updating is 999, the format for /updatetrigger is: \n\n/updatetrigger 999 myfavoritetriggerword";
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
			$msg = "Kraken uses attribs to decide if he should respond to someone. Usernames are caSe Sensitive! \n\nAssuming the ID of the message you are updating is 999, the format for /updateattrib is: \n\n/updateattrib 999 teleusername";
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
	
	else if ($cmd == '/id')
	{
		if (count($words) != 2) 
		{
			$msg = "Assuming the ID of the message you are checking is 999, the format for /id is: \n\n/id 1";
			if ($rows = find_user_ids($conn, $user_submit)) {
				$msg .= "\n\nHere are the messages that you have already added:\nID / trigger / attrib";
				for ($i=0; $rows[$i]; $i++) {
					$msg .=  "\n" . $rows[$i]['id'] . " / " . $rows[$i]['phrase'] . " / " . $rows[$i]['user_attrib'];
				}
			}
		}
		else
		{
			$id = $words[1];
          $msg = display_id($conn, $id);
		}
	}
	
	else if ($cmd == '/find')
	{
		if (count($words) > 1) {
			$search = substr($text, 6);
			if ($id = find_id($conn, $search))
			{
				$msg = display_id($conn, $id);
			}
			else
			{
				$msg = "No such message found.";
			}
		}
		else
		{
			$msg = "Usage: /find The message that I need an ID for.";
		}
	}
	
	else if ($update->message->forward_from->username == 'bfpbot') 
	{
		$search = $update->message->text;
		if ($id = find_id($conn, $search))
		{
			$msg = display_id($conn, $id);
		}
		else
		{
			$msg = "No such message found.";
		}
	}

}

else if ( $cmd == '/find' || $cmd == '/id' || $cmd == '/addmsg' || $cmd == '/updatemsg' || $cmd == '/deletemsg' || $cmd == '/updatetrigger' || $cmd == '/updateattrib' )
{
	$msg = "@$user_submit, you'll want to use $cmd in a private chat with me.";
}

else if ( $cmd == '/find@bfpbot' || $cmd == '/id@bfpbot' || $cmd == '/addmsg@bfpbot' || $cmd == '/updatemsg@bfpbot' || $cmd == '/deletemsg@bfpbot' || $cmd == '/updatetrigger@bfpbot' || $cmd == '/updateattrib@bfpbot' )
{
	$msg = "Hey @$user_submit, please use $cmd in a private chat with me.";
}


// This section deals generally with general chat messages and group chat-enabled commands

if (!$msg && ($cmd == "/help" || $cmd == "/help@bfpbot")) 
{
	$msg = "List of commands: 
/addmsg - Adds to Kraken's repertoire
/deletemsg - Deletes a message of your own
/find - conducts a message ID search
/forward - retrieves message IDs 
/id - lists details of any message
/help - shows list of available commands
/nonsense - encourages kraken to spew nonsense
/updateattrib - Updates the person attributed to a msg
/updatemsg - Updates a message
/updatetrigger - Updates the word associated with a msg";

}

else if ($cmd == "/forward" || $cmd == "/forward@bfpbot")
{
	$msg = "Forward me any of my own messages and I will try to find its details for you.";
}

else if ($cmd == "/nonsense" || $cmd == "/nonsense@bfpbot") 
{
	// Spew nonsense.
	$msg = select_random_msg($conn);
}

else if (!$msg)   
{
	// Check for any keywords listed in the text.
	if (rand(1,5) <= 2 || $chat_type == "private")
	{

		for ($i = 0; $words[$i]; $i++) 
		{
			$word = strtolower($words[$i]);
			$sql = "SELECT response FROM kraken_msg WHERE phrase = '$word' AND user_attrib = '$user_submit' ORDER BY RAND() LIMIT 1";
			if (list($dbmsg) = db_query($conn, $sql)) 
			{
				$dbmsg = db_query($conn, $sql);
				if ($chat_type != "private") 
             {
					$msg = $reply_to_user;
				}
				$msg .= $dbmsg['response'];
				break;
			}
			else
			{
				$msg = 'tset';
			}
		}		
	}
	
	if (!$msg && (rand(1,4) == 1 || $chat_type == "private"))
	{
		for ($i = 0; $words[$i]; $i++) 
		{
			$word = strtolower($words[$i]);
			$sql = "SELECT response FROM kraken_msg WHERE phrase = '$word' ORDER BY RAND() LIMIT 1";
			if (list($dbmsg) = db_query($conn, $sql))
			{
				$dbmsg = db_query($conn, $sql);
				$msg = $dbmsg['response'];
				break;
			}
		}	
	}

	if (!$msg && rand(1,70) == 1) 
	{
		if ($chat_type != "private") {
			$msg = $reply_to_user;
		}
		$msg .= select_user_msg($conn, $user_submit);
	}
	
	// If all else fails, rolls a dice to see if bot should keep quiet or spew nonsense.
	if (!$msg && (rand(1,300) == 1 || $chat_type == "private") )
	{
		$msg = select_random_msg($conn);
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


// -------------------------    
// END OF SCRIPT. WOOHOO!
// -------------------------


?>
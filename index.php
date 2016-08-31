<?php

/*
--------------------------------------
KRAKEN: A BFP BOT
--------------------------------------
*/

// DO NOT EDIT
require 'vendor/autoload.php';

$client = new Zelenin\Telegram\Bot\Api('252926927:AAE7Fa8RTYW2D-RVYJ1B6_A77QZg5vWLJNg'); // Set your access token
$update = json_decode(file_get_contents('php://input'));

// DO NOT EDIT THE ABOVE


// --------------------------------------
/* FUNCTIONS */
// Beware when editing please.


// Spews any one of the available random messages.
function spew_nonsense()
{
	$r = rand(1,9);
    switch($r) 
    {
		case 1: {
        	return "Grandpa nyat is watching";
            break;
            }
        case 2: {
			return "bukkake over the whole school population";
			break; }
		case 3: {
			return "ALANJIAO!!!";
			break; }
		case 4: {
			return "Y'all are damn r99d";
			break; }
		case 5: {
			return "Jin pls";
			break; }
		case 6: {
			return "MAMA SAVE MEEEEEEE";
			break; }		
		case 7: {
			return "u are one of my 30 boiss";
			break; }
		case 8: {
			return "Guys I hate gedong :((";
			break; }
		case 9: {
			return "*rubs head in anticlockwise motion with right hand*";
			break; }
		default: {
			return "";	
			break;
			}										
	}
}

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

// The Bot now decides, based on the ruleset, on an appropriate response, or to keep quiet.

// LIST OF EXISTING COMMANDS
// add - adds to Kraken's existing repertoire (broken)
// help - shows list of available commands
// nonsense - encourages the Kraken to spew some nonsense 

if ($cmd == '/add' || $cmd == '/add@bfpbot')
{
	// The add message function is still under construction.
	$msg = "Feature unavailable. Sorry folks.";
}

else if ($cmd == '/help' || $cmd == '/help@bfpbot') 
{
	// Sends a help message
	$msg = "List of commands :\n /add - adds to Kraken's existing repertoire  \n /help - Shows list of available commands \n /nonsense - encourages the Kraken to spew some nonsense ";
}

else if ($cmd == '/nonsense' || $cmd == '/nonsense@bfpbot') 
{
	// Spew nonsense.
	$msg = spew_nonsense();
}

else    
{
	// If all else fails, rolls a dice to see if bot should keep quiet or spew nonsense.
	$randnum = rand(1,50);
	if ($randnum == 1) 
	{
		$msg = spew_nonsense();
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

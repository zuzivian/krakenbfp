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

	$r = rand(1,19);

    switch($r) 
    {
		case 1:
			return "Grandpa nyat is watching";
		case 2:
			return "holy bukkake over the whole school population";
		case 3:
			return "ALANJIAO!!!";
		case 4:
			return "Y'all are so damn r99d";
		case 5:
			return "Jin pls";
		case 6:
			return "MAMA SAVE MEEEEEEE";		
		case 7:
			return "u are one of my 30 boiz ;)";
		case 8:
			return "Guys I hate gedong :((";
		case 9:
			return "*rubs head in anticlockwise motion with right hand*";
        case 10:
            return "Ken you not?";
        case 11:
            return "NATHANIEL FRICKIN WONG";
        case 12:
            return "JONATHAN FUCKING ONG";
        case 13:
            return "What's the problem now?";
        case 14:
            return "BEE varee aTAI";
        case 15:
            return "JONATHAN FREAKING ONG";
        case 16:
            return "大男人主意";
        case 17:
            return "overcompensation for small dick";
        case 18:
            return "3 rights make a left";
        case 19:
        	return "Send help plz";									
	}
}

function spew_reply($keyword)
{
	$small_word = strtolower($keyword);
	switch ($small_word) {
		case "fak":
			return "FAK NI BACK";
		case "bij":
			return "Yes that's you. Bij.";
		case "shit":
			return "I smell some of that shit coming from over yonder.";
		case "celibate":
			return "Did you know that 'jin' and 'celibate' are antonyms?";
		case "dick":
			return "oooh dickiesssss";
		case "fuken":
			return "fucken kraken fucken kraken";
		case "dumbshit":
			return "My shit has an IQ of 160. That's better than Einstein pls.";
		case "kraken":
			return "You kraken me up, dipshit.";
		case "sigh":
			return "Sigh I'm jaded too..";
		case "jesus":
			return "What kind of car does Jesus drive? \n\nA Christler.";
		case "whee":
			return "did you just go down a slide or what";
		case "ass":
			return "I love donkeys too.";
		case "jin":
			return "Jin wants meat and balls";
		case "bts":
			return "You smell that? It's trash!\nYou trash too.";
		case "guys":
			return "Wat";
		case "crap":
			return "What do you call having nowhere else to shit? \n\nCraptivity.";
		case "butt":
			return "Luv that buttkrak(en)";
		default:
			return null;
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
	$msg = "List of commands :\n /add - adds to Kraken's existing repertoire  \n /help - Shows list of available commands \n /nonsense - encourages Kraken to spew nonsense ";
}

else if ($cmd == '/nonsense' || $cmd == '/nonsense@bfpbot') 
{
	// Spew nonsense.
	$msg = spew_nonsense();
}

else    
{
	// See if anything is worth a reply
	for ($i = 0; $words[$i]; $i++) 
	{
		if ($msg = spew_reply($words[$i])) 
		{
			break;
		}
	}
	
	// If all else fails, rolls a dice to see if bot should keep quiet or spew nonsense.
	if (!$msg && rand(1,20) == 1) 
	{
		$msg = spew_nonsense();
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
    

// -------------------------    
// END OF SCRIPT. WOOHOO!
// -------------------------

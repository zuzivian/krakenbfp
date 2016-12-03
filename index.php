<?php

/*
--------------------------------------
KRAKEN: A BFP BOT
By: zuzivian
Version: 2.0-alpha
--------------------------------------
*/

// DO NOT EDIT

error_reporting(E_ALL);
ini_set("display_errors", 1);

require 'vendor/autoload.php';
require_once 'utils.php';
require_once 'commands.php';
require_once 'config.php';

$client = new Zelenin\Telegram\Bot\Api('252926927:AAE7Fa8RTYW2D-RVYJ1B6_A77QZg5vWLJNg');
$update = json_decode(file_get_contents('php://input'));


// Takes incoming message and breaks it down into an array of strings, $words

$text = $update->message->text;
$words = explode(" ", $text);
$cmd = $words[0];
$user_submit = $update->message->from;
$chat_type = $update->message->chat->type;
$reply_to_user = "@" . $user_submit . " ";

$proc = new MessageProc;
$utils = new AdminUtils;

// Processes commands, if any
$msg = commandproc($text, $user_submit, $chat_type);

//processes private messages
if (!$msg && $chat_type == "private") {

	if ($update->message->forward_from->username == 'bfpbot') 
	{
		$msg = $utils->forwarded_msg($text);
	}
	
}

if (!$msg && mode == 0)
{
	$dice = rand(0,10000)/100;
	
	if ($dice <= $chance_user_phrase || $chat_type == "private") {
		foreach ($words as $word) {
			if($proc->select_from_user_phrase($user_submit,$word)) {
				$msg = $proc->msg->response;
				break;
			}
		}
	}	
	else if ($dice <= $chance_phrase || $chat_type == "private") {
		foreach ($words as $word) {
			if($proc->select_from_phrase($word)) {
				$msg = $proc->msg->response;
				break;
			}
		}
	}	
	else if ($dice <= $chance_user || $chat_type == "private") {
		if($proc->select_from_user($user_submit)) {
			$msg = $proc->msg->response;
		}	
	}
	else if ($dice <= $chance_random || $chat_type == "private") {
		if($proc->select_random()) {
			$msg = $proc->msg->response;
		}
	}
}


// Sends a message, if one has been identified
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



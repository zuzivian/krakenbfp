<?php

/*
--------------------------------------
KRAKEN: A BFP BOT
By: zuzivian
Version: 0.3-alpha
--------------------------------------
*/

// DO NOT EDIT

require 'vendor/autoload.php';

if (!$mode) {
	$client = new Zelenin\Telegram\Bot\Api('252926927:AAE7Fa8RTYW2D-RVYJ1B6_A77QZg5vWLJNg');
	$update = json_decode(file_get_contents('php://input'));
	$text = $update->message->text;
	$user_submit = $update->message->from;
	$chat_type = $update->message->chat->type;
}
else {
	error_reporting(E_ALL);
	ini_set("display_errors", 1);
	$text = "Y'all are so damn rude";
	$user_submit = new User(1234,'Shen Ying','Gan','shenying');
	$chat_type = 'private';
}

require_once 'utils.php';
require_once 'commands.php';
require_once 'config.php';
require_once 'user.php';



// Takes incoming message and breaks it down into an array of strings, $words



$words = explode(" ", $text);
$cmd = $words[0];

$proc = new MessageProc;
$utils = new AdminUtils;

// Processes commands, if any
$msg = commandproc($text, $user_submit, $chat_type);

//processes private messages
if (!$mode && !$msg && $chat_type == "private") {

	if ($update->message->forward_from->username == 'bfpbot') 
	{
		$msg = $utils->forwarded_msg($text);
	}
	
}

$dice = rand(0,10000)/100;

if (!$msg && ($dice <= $chance_user_phrase || $chat_type == "private")) {
	foreach ($words as $word) {
		if($proc->select_from_user_phrase($user_submit,$word)) {
			$msg = $proc->msg->response;
			break;
		}
	}
}	
if (!$msg && ($dice <= $chance_phrase || $chat_type == "private")) {
	foreach ($words as $word) {
		if($proc->select_from_phrase($word)) {
			$msg = $proc->msg->response;
			break;
		}
	}
}	
if (!$msg && ($dice <= $chance_user || $chat_type == "private")) {
	if($proc->select_from_user($user_submit)) {
		$msg = $proc->msg->response;
	}	
}
if (!$msg && ($dice <= $chance_random || $chat_type == "private")) {
	if($proc->select_random()) {
		$msg = $proc->msg->response;
	}
}

if ($mode && !$msg) $msg = 'success!'; // for debugging purposes


// Sends a message, if one has been identified
if ($msg && !$mode) {
	// Sends the "Typing..." action to Telegram
	$response = $client->sendChatAction(['chat_id' => $update->message->chat->id, 'action' => 'typing']);
	
	// Now sends the approriate message
	$response = $client->sendMessage([
     	'chat_id' => $update->message->chat->id,
		'text' => $msg
 	]);	
}
else {
	echo "// Kraken 0.3-alpha // ";
	echo $msg;
	
	$db = new Database;
	$msgs = $db->query("SELECT * FROM 'kraken_msg' ORDER BY RAND() LIMIT 1");
	
	foreach ($msgs as $msg) {
	
		echo $msg;
		
	}
}

// -------------------------    
// END OF SCRIPT. WOOHOO!
// -------------------------



<?php

/*
* This file is part of GeeksWeb Bot (GWB).
*
* GeeksWeb Bot (GWB) is free software; you can redistribute it and/or modify
* it under the terms of the GNU General Public License version 3
* as published by the Free Software Foundation.
* 
* GeeksWeb Bot (GWB) is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.  <http://www.gnu.org/licenses/>
*
* Author(s):
*
* © 2015 Kasra Madadipouya <kasra@madadipouya.com>
*
*/
require 'vendor/autoload.php';

$client = new Zelenin\Telegram\Bot\Api('252926927:AAE7Fa8RTYW2D-RVYJ1B6_A77QZg5vWLJNg'); // Set your access token
$update = json_decode(file_get_contents('php://input'));

//your app
try {

	// message processing
	$text = $update->message->text;
	$words = explode(" ", $text);
	
    if ($words[0] == '/add' || $words[0] == '/add@bfpbot')
    {
		$msg = "Feature unavailable. Sorry folks.";
    }
    else if ($words[0] == '/help' || $words[0] == '/add@bfpbot')
    {
		$msg = "List of commands :\n /add -> adds to Kraken's existing repertoire  \n /help -> Shows list of available commands";
    }
    else if (rand(1,100) <= 20) 
    {
		$msg = "Grandpa nyat is watching.";
    }
    else
    {
    //do nothing
    }
    
	if ($msg) {
		$response = $client->sendChatAction(['chat_id' => $update->message->chat->id, 'action' => 'typing']);
		$response = $client->sendMessage([
      		'chat_id' => $update->message->chat->id,
			'text' => $msg
 		]);
 	}
    

} catch (\Zelenin\Telegram\Bot\NotOkException $e) {

    //echo error message ot log it
    //echo $e->getMessage();

}

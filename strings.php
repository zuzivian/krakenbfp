<?php


//help texts
function help_msg($cmd) {
	switch($cmd) {

	case 'addmsg'; 
		return "The format for /addmsg is: \n\n/addmsg This is the message that I want to add!";
	case 'updatemsg':
		return "Assuming the ID of the message you are updating is 999, the format for /updatemsg is: \n\n/addmsg 999 This is the message that I want to update!";
	case 'deletemsg':
		return "Assuming the ID of the message you are updating is 999, the format for /deletemsg is: \n\n/deletemsg 999";
	case 'updatetrigger':
		return "Kraken uses triggers to decide if he should respond to messages, based on the contents of each message. \n\nAssuming the ID of the message you are updating is 999, the format for /updatetrigger is: \n\n/updatetrigger 999 myfavoritetriggerword";	
	case 'updateattrib':
		return "Kraken uses attribs to decide if he should respond to someone. Usernames are caSe Sensitive! \n\nAssuming the ID of the message you are updating is 999, the format for /updateattrib is: \n\n/updateattrib 999 teleusername";
	case 'id':
		return "Assuming the ID of the message you are checking is 999, the format for /id is: \n\n/id 1";
	case 'find':
		return "Usage: /find The message that I need an ID for.";
	case 'help':
		return "List of commands: 
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
	case 'forward':
		return "Forward me any of my own messages and I will try to find its details for you.";
	default:
		return;
	}
}

//success messages
function success_msg($cmd, $id='', $r='') {
	
	switch ($cmd) {
	
		case 'addmsg':
			return "Your message has been added to Kraken's database! (ID: $id, Message: $r)";
		case 'updatemsg':	
			return "Your message has been updated in Kraken's database! (ID: $id, Messsage: $r)";
		case 'deletemsg':
			return "Your message has been removed from Kraken's database. (ID: $id)";
		case 'updatetrigger':
			return "Your message trigger has been updated. (ID: $id, trigger: $r)";
		case 'updateattrib':
			return "Your user attrib has been updated. (ID: $id, attrib: $r)";
		default:
			return;
					
	}
}


//error messages
function error_msg($cmd) {
	switch ($cmd) {
		
		case 'addmsg':
			return "Sorry, you can't add that. Someone else has already submitted that message!";
		case 'updatemsg':
			return "Sorry, the update failed. Did you use the right ID?";
		case 'deletemsg':
			return "Can't delete a message that isn't yours!";
		case 'updatetrigger':
			return "Can't trigger a message that isn't yours!";
		case 'updateattrib':
			return "Can't attrib a message that isn't yours!";
		case 'notfound':
			return "No such message found.";
		case 'private':
			return "You'll want to use $cmd in a private chat with me.";
		default:
			return;

}

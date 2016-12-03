<?php

require_once 'strings.php';
require_once 'utils.php';

function commandproc($text, $user_submit, $chat_type) {

	$words = explode(" ", $text);
	$cmd = $words[0];
	$utils = new AdminUtils;
	$proc = new MessageProc;
	
	switch ($cmd) {
	
		case '/help@bfpbot':
		{
			return help_msg('help');			
		}
		case '/nonsense@bfpbot':
		{
			$proc->select_random();
			return $proc->msg->response;
		}
	}
	
	if ($chat_type == private) {
	
		switch ($cmd) {
		
			case '/addmsg': 
			{
				if (count($words) == 1) return help_msg('addmsg');
				$r1 = substr(strstr($text," "), 1);
				if ($proc->select_from_msg($r1)) return error_msg('addmsg');
				$id = $utils->add_msg($r, $user_submit);
				return success_msg('addmsg', $id, $r);
			}
	
			case '/updatemsg':
			{
				if (count($words) < 3) return help_msg('updatemsg');
				$id = intval($words[1]);
				$r1 = str_replace("/updatemsg", "", $text);
				$r2 = str_replace($id, "", $r1);
				$r3 = str_replace("  ", "", $r2);
				if ($utils->update_msg($user_submit, $id, $r)) {
					return success_msg('updatemsg', $id, $r);
				}
				else return error_msg('updatemsg');
				}
			}
			
			case '/deletemsg':
			{
				if (count($words) == 1) return help_msg('deletemsg');
				$id = intval($words[1]);
				if ($utils->delete_msg($user_submit, $id)) { return success_msg('deletemsg', $id); }
				else return error_msg('deletemsg');
			}
			
			case '/updatetrigger':
			{
				if (count($words) != 3) return help_msg('updatetrigger');
				$id = intval($words[1]);
				$phrase = $words[2];
				if ($utils->update_phrase($conn, $user_submit, $id, $phrase)) { 
					return success_msg('updatetrigger',$id,$phrase);
				}
				else return error_msg('updatetrigger');
			}
			case '/updateattrib':
			{
				if (count($words) != 3) return help_msg('updateattrib');
				$id = intval($words[1]);
				$attrib = $words[2];		
				if ($utils->update_user_attrib($conn, $user_submit, $id, $attrib))  {
					return success_msg('updateattrib',$id,$attrib);
				} else {
					return error_msg('updateattrib');
				}
				
			case '/id':
			{
				if (count($words) != 2) return help_msg('id');
				$id = intval($words[1]);
				return $utils->display_user_msgs($user_submit, $id);			
			}	
			case '/find':
			{
				if (count($words) < 2) return help_msg('find');
				$search = substr($text, 6);
				$proc = new MessageProc;
				if ($id = $proc->select_from_id($search))
				{
					return $utils->display_msg($id);
				}
				else return error_msg('notfound');
			}
			case '/forward':
			{
				return help_msg('forward');
			}
			case '/help':
			{
				return help_msg('help');
			}
		
		}	
	
	}

	if (chat_type != 'private') {
	
		$arr1 = ['/find', '/id', '/addmsg', '/updatemsg', '/deletemsg', '/updatetrigger', '/updateattrib'];
		$arr2 = ['/find@bfpbot', '/id@bfpbot', '/addmsg@bfpbot', '/updatemsg@bfpbot', '/deletemsg@bfpbot', '/updatetrigger@bfpbot', '/updateattrib@bfpbot'];
		
		if (in_array($cmd, $arr1) || in_array($cmd, $arr2)) return error_msg('private');
		return null;	
	}
		


	
}
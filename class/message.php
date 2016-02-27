<?php
//eastweb information structures
class TgMessage{
	
	
	public function send_message($bot_token,$chat_id,$text,$disable_link_preview=0,$reply_to_msg=0,$reply_markup="0",$hide_keyboard=false)
	{
		$url="https://api.telegram.org/bot".$bot_token."/sendmessage?chat_id=".$chat_id."&text=".urlencode($text)."&disable_web_page_preview=".$disable_link_preview.($reply_to_msg!=0?'&reply_to_message_id='.$reply_to_msg:'').($reply_markup!="0"?'&reply_markup='.$reply_markup:'').($hide_keyboard!=false?'&hide_keyboard='.$hide_keyboard:'');
		$json = download_url($url);
		$result=json_decode($json);
		if($result)
			if($result->ok)
				return true;
		
		return false;	
	}//end of send message function
	
	public function forward_message($bot_token,$chat_id,$from_chat_id,$message_id)
	{
		$url="https://api.telegram.org/bot".$bot_token."/forwardmessage?chat_id=".$chat_id."&from_chat_id=".$from_chat_id."&message_id=".$message_id;
		$json = download_url($url);
		$result=json_decode($json);
		if($result)
			if($result->ok)
				return true;
		
		return false;	
	}//end of forward message function
	
	public function send_photo($bot_token,$chat_id,$photo_id,$reply_markup="0")
	{
		$url="https://api.telegram.org/bot".$bot_token."/sendphoto?chat_id=".$chat_id."&photo=".urlencode(trim($photo_id)).($reply_markup!="0"?'&reply_markup='.$reply_markup:'');
		$json = download_url($url);
		$result=json_decode($json);
		if($result)
			if($result->ok)
				if($result->ok==true)
					return true;
		
		return false;	
	}//end of send_img function
	
	public function send_document($bot_token,$chat_id,$doc_id,$reply_markup="0")
	{
		$url="https://api.telegram.org/bot".$bot_token."/senddocument?chat_id=".$chat_id."&document=".urlencode(trim($doc_id)).($reply_markup!="0"?'&reply_markup='.$reply_markup:'');
		$json = download_url($url);
		$result=json_decode($json);
		if($result)
			if($result->ok)
				if($result->ok==true)
					return true;
		
		return false;	
	}
	
	public function chat_action($bot_token,$chat_id,$chat_action)
	{
		$url="https://api.telegram.org/bot".$bot_token."/sendchataction?chat_id=".$chat_id."&chat_action=".$chat_action;
		$json = download_url($url);
		$result=json_decode($json);
		if($result)
			if($result->ok)
				return true;
		
		return false;	
	}//end of chat action function
	
	public function replymarkup_hide($bot_token,$chat_id,$chat_action)
	{
		$url="https://api.telegram.org/bot".$bot_token."/sendchataction?chat_id=".$chat_id."&chat_action=".$chat_action;
		$json = download_url($url);
		$result=json_decode($json);
		if($result)
			if($result->ok)
				return true;
		
		return false;	
	}//end of chat action function
}


?>
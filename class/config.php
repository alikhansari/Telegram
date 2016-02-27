<?php
	$bot_token="5822988914:AAHzZasdfsdf6dzzmM0A-Pd4CIxwDGTUposJg";
	
	$contact_us_user_id=array(2323222);
	$admin_user_id=array(23424524);
	
	
class Botconfig{
	
	public function setwebhook($bot_token,$url)
	{
		$url="https://api.telegram.org/bot".$bot_token."/setwebhook?url=".$url;
		$json = download_url($url);
		$update=json_decode($json);
		if($result)
			if($result->ok)
				return true;
		
		return false;	
	}//end of forward message function	
	
	
	
}


?>
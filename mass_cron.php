<?php

set_time_limit(0);
include("class/download.php");
include("class/message.php");
require_once("class/config.php");
include("class/db_operation.php");
$message_op=new TgMessage;
$db_op=new Bot_db;

$last_mass=$db_op->get_last_active_mass_mess();
if($last_mass)
{
	
	$users=$db_op->get_users_mass_queued();
	$groups=$db_op->get_groups_mass_queued();
	
	if((!($users)) && (!($groups)))
	{
		$db_op->mark_mass_mess($last_mass->id,1);
		
		$reply_msg="عملیات ارسال پیام انبوه به پایان رسید. شماره عملیات: ".$last_mass->id;
		foreach($admin_user_id as $contactus)
			$result= $message_op->send_message($bot_token,$contactus,$reply_msg);
		
		
		//send a message for completion and then
		exit;
	}
	
	$counter=0;
	if($users)
	{
		$counter=0;
		while($row=$users->fetch_object())	
		{
			$usrinfo=$db_op->get_user_info($row->id);
			if($usrinfo)
			{
				if($usrinfo->mass_q==0)
					continue;
			}
			$result2=$db_op->mark_users_mass_mess($row->id,0);
			
			$counter++;
			$img_array=explode(';',$last_mass->img_array);
			if($img_array)
				foreach($img_array as $img)
					$message_op->send_photo($bot_token,$row->user_id,$img);
			$result= $message_op->send_message($bot_token,$row->user_id,$last_mass->message);
			
			
			if($counter>=100)
				exit;
		}
		goto cnt;
	}//end of users
	elseif($groups)
	{
		$counter=0;
		
		cnt:
		
		if(!$groups)
			exit;
			
		while($row=$groups->fetch_object())	
		{
			$grpinfo=$db_op->get_group_list($row->id);
			if($grpinfo)
			{
				if($grpinfo->mass_q==0)
					continue;
			}
			$result2=$db_op->mark_groups_mass_mess($row->id,0);
			
			$counter++;
			$img_array=explode(';',$last_mass->img_array);
			if($img_array)
				foreach($img_array as $img)
					$message_op->send_photo($bot_token,$row->group_id,$img);
			$result= $message_op->send_message($bot_token,$row->group_id,$last_mass->message);
			
			
			if($counter>=100)
				exit;
		}
		
	}//end of groups
}//end of mass operation unfinished
?>
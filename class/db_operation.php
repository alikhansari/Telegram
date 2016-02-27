<?php

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "telegram";
$mysqli = new MySQLi($dbhost,$dbuser,$dbpass,$dbname);//OOP syntax
if ($mysqli)
	$mysqli->query("SET NAMES 'utf8'");
else	die('Error Connecting to mysql');

class Bot_db
{
	var $mysqli;//links the global mysqli object for use in functions;
	
	function __construct()
	{
		global $mysqli;
		global $path;
		$this->mysqli=$mysqli;
		
	}//end of constructor
	
	public function add_update($update_id,$msg_id,$user_id,$msg_body,$regdate,$user_name,$chat_id)
	{
		$mysqli=$this->mysqli;
		
		$query="INSERT INTO `message_log`(`update_id`,`msg_id`,`user_id`,`msg_body`,`regdate`,`username`,`chat_id`)
							VALUES ('$update_id','$msg_id','$user_id','$msg_body','$regdate','$user_name','$chat_id')";
		
		$result=$mysqli->query($query);
		
		if($result)
			return $mysqli->insert_id;
		return false;
		
	}//end of register user
	
	public function get_last_update_id()
	{
		$mysqli=$this->mysqli;
		
		$query="SELECT * FROM `message_log` ORDER BY `update_id` DESC LIMIT 1";
		
		$result=$mysqli->query($query);
		
		if($result)
			if($obj=$result->fetch_object())
				if($obj)
					return $obj->update_id;
		return false;
	}
	
	public function get_update_msg_id($update_id)
	{
		$mysqli=$this->mysqli;
		
		$query="SELECT * FROM `message_log` WHERE `update_id`='$update_id'";
		
		$result=$mysqli->query($query);
		
		if($result)
			if($obj=$result->fetch_object())
				if($obj)
					return $obj;
		return false;
	}
	public function subscrible($user_id,$status)
	{
		$mysqli=$this->mysqli;
		
		$query="UPDATE `users` SET `sub`='$status' WHERE `user_id`='$user_id'";
		
		$result=$mysqli->query($query);
		
		if($result)
			return $mysqli->insert_id;
		return false;
	}
	
	public function add_user($user_id,$regdate,$username="")
	{
		$mysqli=$this->mysqli;
		
		$query="INSERT INTO `users`(`user_id`,`regdate`,`username`)
							VALUES ('$user_id','$regdate','$username')";
		
		$result=$mysqli->query($query);
		
		if($result)
			return $mysqli->insert_id;
		return false;
		
	}//end of register user
	
	public function get_user_info($sysuser_id)
	{
		$mysqli=$this->mysqli;
		
		$query="SELECT * FROM `users` WHERE `id`='$sysuser_id'";
		
		$result=$mysqli->query($query);
		
		if($result)
			if($result->num_rows>0)
				if($row=$result->fetch_object())
					if($row)
						return $row;
		return false;
	}
	
	public function check_user_exist($user_id)
	{
		$mysqli=$this->mysqli;
		
		$query="SELECT * FROM `users` WHERE `user_id`='$user_id'";
		
		$result=$mysqli->query($query);
		
		if($result)
			if($obj=$result->fetch_object())
				if($obj)
					return true;//exist
		return false;
	}
	
	public function get_sub_list()
	{
		$mysqli=$this->mysqli;
		
		$query="SELECT * FROM `users` WHERE `sub`='1'";
		
		$result=$mysqli->query($query);
		
		if($result)
			if($result->num_rows>0)
				return $result;
		return false;
	}
	public function get_allusers_list()
	{
		$mysqli=$this->mysqli;
		
		$query="SELECT * FROM `users`";
		
		$result=$mysqli->query($query);
		
		if($result)
			if($result->num_rows>0)
				return $result;
		return false;
	}
	public function get_sub_count()
	{
		$mysqli=$this->mysqli;
		
		$query="SELECT count(*) as `cnt` FROM `users` WHERE `sub`='1'";
		
		$result=$mysqli->query($query);
		
		if($result)
			if($result->num_rows>0)
				if($row=$result->fetch_object())
					if($row)
						return $row->cnt;
		return 0;
	}
	public function get_allusers_count()
	{
		$mysqli=$this->mysqli;
		
		$query="SELECT count(*) as `cnt` FROM `users`";
		
		$result=$mysqli->query($query);
		
		if($result)
			if($result->num_rows>0)
				if($row=$result->fetch_object())
					if($row)
						return $row->cnt;
		return 0;
	}
	
	public function add_info($key_array,$msg,$regdate,$img_array="",$doc_array="")
	{
		$mysqli=$this->mysqli;
		
		$key_string=$key_array;
		$img_string=$img_array;
		$doc_string=$doc_array;
		$query="INSERT INTO `infos`(`key_array`,`msg`,`img_array`,`regdate`,`doc_array`)
							VALUES ('$key_string','$msg','$img_string','$regdate','$doc_string')";
		
		$result=$mysqli->query($query);
		
		if($result)
			return $mysqli->insert_id;
		return false;
		
	}
	
	public function edit_info($id,$key_array,$msg,$img_array,$regdate)
	{
		$mysqli=$this->mysqli;
		
		$key_string=implode(';',$key_array);
		$img_string=implode(';',$img_array);
		
		$query="UPDATE `infos` SET `key_array`='$key_string',
									`msg`='$msg',
									`img_array`='$img_string',
									
									`regdate`='$regdate'
							WHERE `id`='$id'";
		
		$result=$mysqli->query($query);
		
		if($result)
			return true;
		return false;
		
	}
	public function edit_info_body($id,$msg)
	{
		$mysqli=$this->mysqli;
		
		
		$query="UPDATE `infos` SET 
									`msg`='$msg'
							WHERE `id`='$id'";
		
		$result=$mysqli->query($query);
		
		if($result)
			return true;
		return false;
		
	}
	public function edit_info_keys($id,$keys_string)
	{
		$mysqli=$this->mysqli;
		
		
		$query="UPDATE `infos` SET 
									`key_array`='$keys_string'
							WHERE `id`='$id'";
		
		$result=$mysqli->query($query);
		
		if($result)
			return true;
		return false;
		
	}
	public function edit_info_images($id,$imgs_string)
	{
		$mysqli=$this->mysqli;
		
		
		$query="UPDATE `infos` SET 
									`img_array`='$imgs_string'
							WHERE `id`='$id'";
		
		$result=$mysqli->query($query);
		
		if($result)
			return true;
		return false;
		
	}
	public function edit_info_docs($id,$docs_string)
	{
		$mysqli=$this->mysqli;
		
		
		$query="UPDATE `infos` SET 
									`doc_array`='$docs_string'
							WHERE `id`='$id'";
		
		$result=$mysqli->query($query);
		
		if($result)
			return true;
		return false;
		
	}
	public function edit_info_feed($id,$feed_id)
	{
		$mysqli=$this->mysqli;
		
		
		$query="UPDATE `infos` SET 
									`feed_id`='$feed_id'
							WHERE `id`='$id'";
		
		$result=$mysqli->query($query);
		
		if($result)
			return true;
		return false;
		
	}
	public function delete_info($id)
	{
		$mysqli=$this->mysqli;
		
		
		
		$query="DELETE FROM `infos` WHERE `id`='$id'";
		
		$result=$mysqli->query($query);
		
		if($result)
			return true;
		return false;
		
	}
	
	public function get_cmd_list()
	{
		$mysqli=$this->mysqli;
		
		$query="SELECT * FROM `infos`";
		
		$result=$mysqli->query($query);
		
		if($result)
			if($result->num_rows>0)
				return $result;
		return false;
	}
	/*******************************/
	
	public function add_group($group_id,$group_title,$regdate)
	{
		$mysqli=$this->mysqli;
		
		$query="INSERT INTO `groups`(`group_id`,`group_title`,`regdate`)
							VALUES ('$group_id','$group_title','$regdate')";
		
		$result=$mysqli->query($query);
		
		if($result)
			return $mysqli->insert_id;
		return false;
		
	}//end of register group
	
	public function update_group($group_id,$group_title)
	{
		$mysqli=$this->mysqli;
		
		$query="UPDATE `groups` SET `group_title`='$group_title' WHERE `group_id`='$group_id'";
		
		$result=$mysqli->query($query);
		
		if($result)
			return true;
		return false;
		
	}//end of update group
	
	public function remove_group($group_id)
	{
		$mysqli=$this->mysqli;
		
		$query="DELETE FROM `groups` WHERE `group_id`='$group_id'";
		
		$result=$mysqli->query($query);
		
		if($result)
			return true;
		return false;
		
	}//end of update group
	
	public function check_group_exist($group_id)
	{
		$mysqli=$this->mysqli;
		
		$query="SELECT * FROM `groups` WHERE `group_id`='$group_id'";
		
		$result=$mysqli->query($query);
		
		if($result)
			if($result->num_rows>0)
				if($obj=$result->fetch_object())
					if($obj)
						return true;//exist
		return false;
	}
	
	public function get_group_list($group_id=0)
	{
		$mysqli=$this->mysqli;
		
		if($group_id)
		{
			$query="SELECT * FROM `groups` WHERE `id`='$group_id'";
			$result=$mysqli->query($query);
			if($result)
				if($result->num_rows>0)
					if($obj=$result->fetch_object())
						if($obj)
							return $obj;
		}
		else
		{	
		$query="SELECT * FROM `groups`";
			$result=$mysqli->query($query);
			if($result)
				if($result->num_rows>0)
					return $result;
		
		}
		return false;
	}
	
	public function get_groups_count()
	{
		$mysqli=$this->mysqli;
		
		$query="SELECT count(*) as `cnt` FROM `groups`";
		
		$result=$mysqli->query($query);
		
		if($result)
			if($obj=$result->fetch_object())
				if($obj)
					return $obj->cnt;
		return 0;
	}
	
	/****************************************************/
	public function get_static_info($id)
	{
		$mysqli=$this->mysqli;
		
		$query="SELECT * FROM `static_info` WHERE `id`='$id'";
		
		$result=$mysqli->query($query);
		
		if($result)
			if($result->num_rows>0)
				if($obj=$result->fetch_object())
					if($obj)
						return $obj->body;
		return false;
	}
	
	public function update_static_info($id,$body)
	{
		$mysqli=$this->mysqli;
		
		$query="UPDATE `static_info` SET `body`='$body' WHERE `id`='$id'";
		
		$result=$mysqli->query($query);
		
		if($result)
			return true;
		return false;
	}
	/**********************************************************/
	
	public function add_mass_mess($message,$users_count,$groups_count,$img_array="")
	{
		$mysqli=$this->mysqli;
		
		$query="INSERT INTO `mass_mess`(`message`,`users_count`,`groups_count`,`img_array`)
							VALUES ('$message','$users_count','$groups_count','$img_array')";
		
		$result=$mysqli->query($query);
		
		if($result)
			return $mysqli->insert_id;
		return false;
		
	}
	
	public function get_last_active_mass_mess()
	{
		$mysqli=$this->mysqli;
		
		$query="SELECT * FROM `mass_mess` ORDER BY `id` DESC LIMIT 1";
		
		$result=$mysqli->query($query);
		
		if($result)
			if($result->num_rows>0)
				if($obj=$result->fetch_object())
					if($obj)
						if($obj->finished==0)
							return $obj;
		return false;
	}
	
	public function mark_mass_mess($id,$finished=1)
	{
		$mysqli=$this->mysqli;
		
		$query="UPDATE `mass_mess` SET `finished`='$finished' WHERE `id`='$id'";
		
		$result=$mysqli->query($query);
		
		if($result)
			return true;
		return false;
	}
	
	public function mark_users_mass_mess($id=0,$mass_q=1)
	{
		$mysqli=$this->mysqli;
		if($id)
			$query="UPDATE `users` SET `mass_q`='$mass_q' WHERE `id`='$id' AND `sub`='1'";
		else
			$query="UPDATE `users` SET `mass_q`='$mass_q' WHERE `sub`='1'";
		$result=$mysqli->query($query);
		
		if($result)
			return true;
		return false;
	}
	public function mark_groups_mass_mess($id=0,$mass_q=1)
	{
		$mysqli=$this->mysqli;
		if($id)
			$query="UPDATE `groups` SET `mass_q`='$mass_q' WHERE `id`='$id'";
		else
			$query="UPDATE `groups` SET `mass_q`='$mass_q'";
		$result=$mysqli->query($query);
		
		if($result)
			return true;
		return false;
	}
	
	public function get_users_mass_queued()
	{
		$mysqli=$this->mysqli;
		
		$query="SELECT * FROM `users` WHERE `mass_q`='1' AND `sub`='1' ORDER BY `id` ASC";
		
		$result=$mysqli->query($query);
		
		if($result)
			if($result->num_rows>0)
				return $result;
		return false;
	}
	
	public function get_groups_mass_queued()
	{
		$mysqli=$this->mysqli;
		
		$query="SELECT * FROM `groups` WHERE `mass_q`='1' ORDER BY `id` ASC";
		
		$result=$mysqli->query($query);
		
		if($result)
			if($result->num_rows>0)
				return $result;
		return false;
	}
	
	
	/***********************************************************/
	public function get_user_last_action($user_id)
	{
		$mysqli=$this->mysqli;
		
		$query="SELECT * FROM `message_log` WHERE `user_id`='$user_id' ORDER BY `id` DESC LIMIT 1";
		
		$result=$mysqli->query($query);
		
		if($result)
			if($result->num_rows>0)
				if($obj=$result->fetch_object())
					if($obj)
						return $obj;
		return false;
	}
	/***********************************************************/
	public function add_feed($feed_url,$count=5)
	{
		$mysqli=$this->mysqli;
		
		$query="INSERT INTO `feeds`(`url`,`cnt`)
							VALUES ('$feed_url','$count')";
		
		$result=$mysqli->query($query);
		
		if($result)
			return $mysqli->insert_id;
		return false;
		
	}
	public function get_feed_list()
	{
		$mysqli=$this->mysqli;
		
		$query="SELECT * FROM `feeds`";
		
		$result=$mysqli->query($query);
		
		if($result)
			if($result->num_rows>0)
				return $result;
		return false;
	}
	public function get_feed($feed_id)
	{
		$mysqli=$this->mysqli;
		
		$query="SELECT * FROM `feeds` WHERE `id`='$feed_id'";
		
		$result=$mysqli->query($query);
		
		if($result)
			if($result->num_rows>0)
				if($obj=$result->fetch_object())
					if($obj)
						return $obj;
		return false;
	}
	public function remove_feed($feed_id)
	{
		$mysqli=$this->mysqli;
		
		$query="DELETE FROM `feeds` WHERE `id`='$feed_id'";
		
		$result=$mysqli->query($query);
		
		if($result)
			return true;
		return false;
		
	}
	public function update_feed($id,$url=0,$count=0)
	{
		$mysqli=$this->mysqli;
		
		if($count)
		{
			if($url)
				$query="UPDATE `feeds` SET `url`='$url',
										`cnt`='$count'
						WHERE `id`='$id'";
			else $query="UPDATE `feeds` SET `cnt`='$count'
						WHERE `id`='$id'";
		}
		else
			$query="UPDATE `feeds` SET `url`='$url'
					WHERE `id`='$id'";
		$result=$mysqli->query($query);
		
		if($result)
			return true;
		return false;
	}
	/***********************************************************/
	public function add_button($caption,$text,$main=0,$parent=0,$img_string="",$doc_string="",$feed_id=0,$status=1)
	{
		$mysqli=$this->mysqli;
		
		$query="INSERT INTO `buttons`(`caption`,`text`,`main`,`parent_id`,`img_array`,`doc_array`,`feed_id`,`status`)
							VALUES ('$caption','$text','$main','$parent','$img_string','$doc_string','$feed_id','$status')";
		
		$result=$mysqli->query($query);
		
		if($result)
			return $mysqli->insert_id;
		return false;
		
	}
	public function get_button_list_all($status=1)
	{
		$mysqli=$this->mysqli;
		
		$query="SELECT * FROM `buttons` WHERE `status`='$status'";
		
		$result=$mysqli->query($query);
		
		if($result)
			if($result->num_rows>0)
				return $result;
		return false;
	}
	public function get_button_list_by_type($main=0,$status=1)
	{
		$mysqli=$this->mysqli;
		
		$query="SELECT * FROM `buttons` WHERE `main`='$main' AND `status`='$status'";
		
		$result=$mysqli->query($query);
		
		if($result)
			if($result->num_rows>0)
				return $result;
		return false;
	}
	public function get_button_list_by_parent($parent_id=0,$status=1)
	{
		$mysqli=$this->mysqli;
		
		$query="SELECT * FROM `buttons` WHERE `parent_id`='$parent_id' AND `status`='$status'";
		
		$result=$mysqli->query($query);
		
		if($result)
			if($result->num_rows>0)
				return $result;
		return false;
	}
	public function get_button($button_id)
	{
		$mysqli=$this->mysqli;
		
		$query="SELECT * FROM `buttons` WHERE `id`='$button_id'";
		
		$result=$mysqli->query($query);
		
		if($result)
			if($result->num_rows>0)
				if($obj=$result->fetch_object())
					if($obj)
						return $obj;
		return false;
	}
	public function remove_button($button_id)
	{
		$mysqli=$this->mysqli;
		
		$query="DELETE FROM `buttons` WHERE `id`='$button_id'";
		
		$result=$mysqli->query($query);
		
		if($result)
			return true;
		return false;
		
	}
	public function update_button_caption($button_id,$new_caption)
	{
		$mysqli=$this->mysqli;
		
		$query="UPDATE `buttons` SET `caption`='$new_caption'
					WHERE `id`='$button_id'";
		$result=$mysqli->query($query);
		
		if($result)
			return true;
		return false;
	}
	public function update_button_text($button_id,$new_text)
	{
		$mysqli=$this->mysqli;
		
		$query="UPDATE `buttons` SET `text`='$new_text'
					WHERE `id`='$button_id'";
		$result=$mysqli->query($query);
		
		if($result)
			return true;
		return false;
	}
	public function update_button_docs($button_id,$new_docs)
	{
		$mysqli=$this->mysqli;
		
		$query="UPDATE `buttons` SET `doc_array`='$new_docs'
					WHERE `id`='$button_id'";
		$result=$mysqli->query($query);
		
		if($result)
			return true;
		return false;
	}
	public function update_button_imgs($button_id,$new_imgs)
	{
		$mysqli=$this->mysqli;
		
		$query="UPDATE `buttons` SET `img_array`='$new_imgs'
					WHERE `id`='$button_id'";
		$result=$mysqli->query($query);
		
		if($result)
			return true;
		return false;
	}
	public function update_button_feed($button_id,$new_feed_id)
	{
		$mysqli=$this->mysqli;
		
		$query="UPDATE `buttons` SET `feed_id`='$new_feed_id'
					WHERE `id`='$button_id'";
		$result=$mysqli->query($query);
		
		if($result)
			return true;
		return false;
	}
	public function update_button_parent($button_id,$new_parent_id)
	{
		$mysqli=$this->mysqli;
		
		$query="UPDATE `buttons` SET `parent_id`='$new_parent_id'
					WHERE `id`='$button_id'";
		$result=$mysqli->query($query);
		
		if($result)
			return true;
		return false;
	}
	public function update_button_status($button_id,$new_status=1)
	{
		$mysqli=$this->mysqli;
		
		$query="UPDATE `buttons` SET `status`='$new_status'
					WHERE `id`='$button_id'";
		$result=$mysqli->query($query);
		
		if($result)
			return true;
		return false;
	}
	public function update_button_main($button_id,$main=1)
	{
		$mysqli=$this->mysqli;
		
		$query="UPDATE `buttons` SET `main`='$main'
					WHERE `id`='$button_id'";
		$result=$mysqli->query($query);
		
		if($result)
			return true;
		return false;
	}
	/***********************************************************/
	public function update_general_options($key,$info)
	{
		$mysqli=$this->mysqli;
		
		$query="UPDATE `general_options` SET `info`='$info'
					WHERE `key`='$key'";
		$result=$mysqli->query($query);
		
		if($result)
			return true;
		return false;
	}
	public function get_general_options($key)
	{
		$mysqli=$this->mysqli;
		
		$query="SELECT * FROM `general_options`
					WHERE `key`='$key'";
		$result=$mysqli->query($query);
		
		if($result)
			if($result->num_rows>0)
				if($obj=$result->fetch_object())
					if($obj)
						return $obj;
		return false;
	}
}//end of bot db class
?>
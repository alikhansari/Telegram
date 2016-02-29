<?php

			if(substr($message_body,0,8)=="/addinfo")
			{
				if(!(in_array($chat_user_id,$admin_user_id)))
					continue;
				
				$keys_pos=strpos($message_body,'#');
				$keys=substr($message_body,9,$keys_pos-9);
				$clean_string=substr($message_body,$keys_pos+2);
				
				$key_array=$keys;
				
				$msg=$clean_string;
				
				$info_id=$db_op->add_info($key_array,$msg,time());
				if($info_id)
					$reply_msg="Your order has been added: ".$info_id."
					To add picture or document, please use these:
					/setinfopic ".$info_id."# pic_id
					/setinfodoc ".$info_id."# doc_id";
				else $reply_msg="Error!!";
			}
			elseif(substr($message_body,0,12)=="/setinfotext")
			{
				if(!(in_array($chat_user_id,$admin_user_id)))
					continue;
				
				$keys_pos=strpos($message_body,'#');
				$keys=substr($message_body,13,$keys_pos-13);
				$clean_string=substr($message_body,$keys_pos+2);
				
				$info_id=$keys;
				
				$msg=$clean_string;
				
				$info_edit=$db_op->edit_info_body($info_id,$msg);
				if($info_edit)
					$reply_msg="Text has been saved successfully!";
					
				else $reply_msg="Error!";
			}
			elseif(substr($message_body,0,11)=="/setinfopic")
			{
				if(!(in_array($chat_user_id,$admin_user_id)))
					continue;
				
				$keys_pos=strpos($message_body,'#');
				$keys=substr($message_body,12,$keys_pos-12);
				$clean_string=substr($message_body,$keys_pos+2);
				
				$info_id=$keys;
				
				$img=$clean_string;
				
				$info_edit=$db_op->edit_info_images($info_id,$img);
				if($info_edit)
					$reply_msg="Image has been saved successfully!";
					
				else $reply_msg="Error!";
			}
			elseif(substr($message_body,0,11)=="/setinfodoc")
			{
				if(!(in_array($chat_user_id,$admin_user_id)))
					continue;
				
				$keys_pos=strpos($message_body,'#');
				$keys=substr($message_body,12,$keys_pos-12);
				$clean_string=substr($message_body,$keys_pos+2);
				
				$info_id=$keys;
				
				$doc=$clean_string;
				
				$info_edit=$db_op->edit_info_docs($info_id,$doc);
				if($info_edit)
					$reply_msg="Document has been added successfully!";
					
				else $reply_msg="Error!";
			}
			elseif(substr($message_body,0,11)=="/setinfokey")
			{
				if(!(in_array($chat_user_id,$admin_user_id)))
					continue;
				
				$keys_pos=strpos($message_body,'#');
				$keys=substr($message_body,12,$keys_pos-12);
				$clean_string=substr($message_body,$keys_pos+2);
				
				$info_id=$keys;
				
				$key=$clean_string;
				
				$info_edit=$db_op->edit_info_keys($info_id,$key);
				if($info_edit)
					$reply_msg="Keyboard has been edited successfully!;
					
				else $reply_msg="Error!";
			}
			elseif(substr($message_body,0,12)=="/setinfofeed")
			{
				if(!(in_array($chat_user_id,$admin_user_id)))
					continue;
				
				$keys_pos=strpos($message_body,'#');
				$keys=substr($message_body,13,$keys_pos-13);
				$clean_string=substr($message_body,$keys_pos+2);
				
				$info_id=$keys;
				
				$feed_id=$clean_string;
				
				$info_edit=$db_op->edit_info_feed($info_id,$feed_id);
				if($info_edit)
					$reply_msg="Feed RSS has been edited successfully!";
					
				else $reply_msg="Error!";
			}
			if(substr($message_body,0,8)=="/addfeed")
			{
				if(!(in_array($chat_user_id,$admin_user_id)))
					continue;
				
				$keys_pos=strpos($message_body,'#');
				$keys=substr($message_body,9,$keys_pos-9);
				$clean_string=substr($message_body,$keys_pos+2);
				
				$feed_url=$keys;
				
				$count=$clean_string;
				if($count=="")
					$count=5;
				$feed_id=$db_op->add_feed($feed_url,$count);
				if($feed_id)
					$reply_msg="RSS feed has been added, ID is: ".$feed_id."
					To link your RSS to an order, you should use this:
					/setinfofeed info_id#".$feed_id;
				else $reply_msg="Error";
			}
			elseif(substr($message_body,0,11)=="/setfeedurl")
			{
				if(!(in_array($chat_user_id,$admin_user_id)))
					continue;
				
				$keys_pos=strpos($message_body,'#');
				$keys=substr($message_body,12,$keys_pos-12);
				$clean_string=substr($message_body,$keys_pos+2);
				
				$feed_id=$keys;
				
				$feed_url=$clean_string;
				
				$feed_edit=$db_op->update_feed($feed_id,$feed_url);
				if($feed_edit)
					$reply_msg="RSS feed has been edited.";
					
				else $reply_msg="Error!";
			}
			elseif(substr($message_body,0,13)=="/setfeedcount")
			{
				if(!(in_array($chat_user_id,$admin_user_id)))
					continue;
				
				$keys_pos=strpos($message_body,'#');
				$keys=substr($message_body,14,$keys_pos-14);
				$clean_string=substr($message_body,$keys_pos+2);
				
				$feed_id=$keys;
				
				$feed_count=$clean_string;
				
				$feed_edit=$db_op->update_feed($feed_id,0,$feed_count);
				if($feed_edit)
					$reply_msg="Counts has been changed.";
					
				else $reply_msg="Error!!";
			}
			elseif($message_body=="/showfeedall" || $message_body=="showfeedall")
			{
				if(!(in_array($chat_user_id,$admin_user_id)))
					continue;
				
				$all_cmd=$db_op->get_feed_list();
				$reply_msg="";
				if($all_cmd)
				{
					
					while($cmd=$all_cmd->fetch_object())
					{
$reply_msg=$cmd->id."# ".$cmd->url."# \n".$cmd->cnt."\n";
$result= $message_op->send_message($bot_token,$chat_user_id,$reply_msg);

					}
					$reply_msg="";	
				}
				else
					$reply_msg="RSS feed doesn't find!";
				
				
				
			}
			elseif(substr($message_body,0,8)=="/delfeed")
			{
				if(!(in_array($chat_user_id,$admin_user_id)))
					continue;
				
				$id_pos=strpos($message_body,'#');
				$id=substr($message_body,9,$id_pos-9);
				$clean_string=substr($message_body,$id_pos+1);
				if($db_op->remove_feed($id))
					$reply_msg="RSS has been deleted successfully.";
				else $reply_msg="Error!";
					
				
				
			}
			elseif($message_body=="/showinfoall" || $message_body=="showinfoall")
			{
				if(!(in_array($chat_user_id,$admin_user_id)))
					continue;
				
				$all_cmd=$db_op->get_cmd_list();
				$reply_msg="";
				if($all_cmd)
				{
					
					while($cmd=$all_cmd->fetch_object())
					{
$reply_msg=$cmd->id."# ".$cmd->key_array."# \n".$cmd->msg."\n";
$result= $message_op->send_message($bot_token,$chat_user_id,$reply_msg);

					}
					$reply_msg="";	
				}
				else
					$reply_msg="Not found!";
				
				
				
			}
			elseif(substr($message_body,0,8)=="/delinfo")
			{
				if(!(in_array($chat_user_id,$admin_user_id)))
					continue;
				
				$id_pos=strpos($message_body,'#');
				$id=substr($message_body,9,$id_pos-9);
				$clean_string=substr($message_body,$id_pos+1);
				if($db_op->delete_info($id))
					$reply_msg="Has been deleted!";
				else $reply_msg="Error!";
					
				
				
			}
			
			elseif( $message_body=="/getgroups" || $message_body=="getgroups")
			{
				
				if(!(in_array($chat_user_id,$admin_user_id)))
					exit;
				
				$groups=$db_op->get_group_list();
				$reply_msg="";
				$divider=0;
				if($groups)
				while($group=$groups->fetch_object())
				{
					if($divider%10==0)
					{
$result= $message_op->send_message($bot_token,$chat_user_id,$reply_msg);
$reply_msg="";
					}
					$reply_msg.=$group->id."# ".$group->group_title." | ";
					
					$divider++;
				}
				
			}
			elseif( $message_body=="/getgroupscount" || $message_body=="getgroupscount")
			{
				if(!(in_array($chat_user_id,$admin_user_id)))
					exit;
					
				
				$groups_all_cnt=$db_op->get_groups_count();
				$reply_msg="Number of groups, bot has already joined is $groups_all_cnt.". \n";
				$reply_msg.="Tap for see group names: \n /getgroups";
				
				
			}
			elseif(substr($message_body,0,8)=="/stallgp" || substr($message_body,0,8)=="/Stallgp")
			{
				if(!(in_array($chat_user_id,$admin_user_id)))
					exit;
					
				$gp_message=trim(substr($message_body,9));
				
				$count=0;
				$gpl_msg="";
			  $gplist=$db_op->get_group_list();
			  if($gplist)
			  {
				if($gp_message!="" && $gp_message)
				{
					while($gpl=$gplist->fetch_object())
					{
				
	

	$result= $message_op->send_message($bot_token,$gpl->group_id,$gp_message);

$count++;
$gpl_msg.=$gpl->id."# ".$gpl->group_title." | ";
					}
				}
				else $result= $message_op->send_message($bot_token,$chat_user_id,"Sorry, but you didn't enter anything!");
				
				$reply_msg="your message to ".$count." groups has been sent!";
				$result= $message_op->send_message($bot_token,$chat_user_id,$reply_msg);
			  }
			  $reply_msg="";
			  
			  
				
			}
			elseif(substr($message_body,0,7)=="stallgp" || substr($message_body,0,7)=="Stallgp")
			{
				if(!(in_array($chat_user_id,$admin_user_id)))
					exit;
					
				$gp_message=trim(substr($message_body,8));
				
				$count=0;
				$gpl_msg="";
			  $gplist=$db_op->get_group_list();
			  if($gplist)
			  {
				if($gp_message!="" && $gp_message)
				{
					while($gpl=$gplist->fetch_object())
					{
				
	

	$result= $message_op->send_message($bot_token,$gpl->group_id,$gp_message);

$count++;
$gpl_msg.=$gpl->id."# ".$gpl->group_title." | ";
					}
				}
				else $result= $message_op->send_message($bot_token,$chat_user_id,"متاسفانه شما پیامی وارد نکردید");
				
				$reply_msg="پیام شما به ".$count."گروه ارسال شد";
				$result= $message_op->send_message($bot_token,$chat_user_id,$reply_msg);
			  }
			  $reply_msg="";
			  
			  
				
			}
			elseif(substr($message_body,0,5)=="/stgp" || substr($message_body,0,5)=="/Stgp")
			{
				if(!(in_array($chat_user_id,$admin_user_id)))
					exit;
					
				//$gp_message=trim(substr($message_body,6));
				
				$id_pos=strpos($message_body,'#');
				$id=substr($message_body,6,$id_pos-6);
				$gp_message=substr($message_body,$id_pos+2);
				
				$count=0;
				$gpl_msg="";
			  $gpl=$db_op->get_group_list($id);
			  if($gpl)
			  {
				if($gp_message!="" && $gp_message)
				{
					
				
	

	$result= $message_op->send_message($bot_token,$gpl->group_id,$gp_message);

$count++;
$gpl_msg.=$gpl->id."# ".$gpl->group_title." | ";
					
				}
				else $result= $message_op->send_message($bot_token,$chat_user_id,"متاسفانه شما پیامی وارد نکردید");
				
				$reply_msg="پیام شما به ".$count."گروه ارسال شد";
				$result= $message_op->send_message($bot_token,$chat_user_id,$reply_msg);
			  }
			  $reply_msg="";
			  
			  
				
			}
			
			elseif( $message_body=="/getusers" || $message_body=="getusers")
			{
				if(!(in_array($chat_user_id,$admin_user_id)))
					continue;
				
				$users=$db_op->get_sub_list();
				$reply_msg="";
				$divider=0;
				while($user=$users->fetch_object())
				{
					if($divider%10==0)
					{
$result= $message_op->send_message($bot_token,$chat_user_id,$reply_msg);
$reply_msg="";
					}
					$reply_msg.="@".$user->username." | ";
					
					$divider++;
				}
				
			}
			elseif( $message_body=="/getuserscount" || $message_body=="getuserscount")
			{
				if(!(in_array($chat_user_id,$admin_user_id)))
					continue;
					
				$users_sub_cnt=$db_op->get_sub_count();
				$users_all_cnt=$db_op->get_allusers_count();
				$reply_msg="تعداد کاربران کل ".$users_all_cnt." عدد است که از این ";
				$reply_msg.="تعداد ".$users_sub_cnt." کاربر در خبرنامه فعال هستند.\n جهت مشاهده لیست کاربران دستور زیر را وارد کنید: \n /getusers";
				
				
			}
			elseif(substr($message_body,0,6)=="/stall" || substr($message_body,0,6)=="/Stall")
			{
				if(!(in_array($chat_user_id,$admin_user_id)))
					continue;
					
				$user_message=trim(substr($message_body,7));
				
				$count=0;
			  $sublist=$db_op->get_sub_list();
			  if($sublist)
			  {
				if($user_message!="" && $user_message)
				{
					while($sbl=$sublist->fetch_object())
					{
				
	

	$result= $message_op->send_message($bot_token,$sbl->user_id,$user_message);

$count++;
					}
				}
				else $result= $message_op->send_message($bot_token,$chat_user_id,"متاسفانه شما پیامی وارد نکردید");
				
				$reply_msg="پیام شما به ".$count."نفر ارسال شد";
				$result= $message_op->send_message($bot_token,$chat_user_id,$reply_msg);
			  }
			  $reply_msg="";
			  
			  
				
			}
			elseif(substr($message_body,0,5)=="stall" || substr($message_body,0,5)=="Stall")
			{
				if(!(in_array($chat_user_id,$admin_user_id)))
					continue;
				
				$user_message=trim(substr($message_body,6));
				
				$count=0;
			  $sublist=$db_op->get_sub_list();
			  if($sublist)
			  {
				if($user_message!="" && $user_message)
				{
					while($sbl=$sublist->fetch_object())
					{
				
	

	$result= $message_op->send_message($bot_token,$sbl->user_id,$user_message);

$count++;
					}
				}
				else $result= $message_op->send_message($bot_token,$chat_user_id,"متاسفانه شما پیامی وارد نکردید");
				
				$reply_msg="پیام شما به ".$count."نفر ارسال شد";
				$result= $message_op->send_message($bot_token,$chat_user_id,$reply_msg);
			  }
			  $reply_msg="";
			  
			  
				
			}
			elseif(in_array(substr($message_body,0,8),array("/rplymsg")))
			{
				if(!(in_array($chat_user_id,$contact_us_user_id)))
					continue;
				$clean_msg1=substr($message_body,9);
					$msg_pos=strpos($clean_msg1,"#");
					$upd_id=substr($clean_msg1,0,$msg_pos);
				$clean_msg2=substr($clean_msg1,$msg_pos+1);
				$reply_msg2="";
				if($upd_id)
				{
					$upd_info=$db_op->get_update_msg_id($upd_id);
					if($upd_info)
					{
				
$result= $message_op->send_message($bot_token,$upd_info->chat_id 	
,$clean_msg2,0,$upd_info->msg_id);
$reply_msg2="متشکرم. پاسخ شما کارشناس محترم به خوبی دریافت شد.";
				
					}else $reply_msg2="کارشناس محترم شماره پیام اشتباه وارد شده است.لطفا مجددا سعی نمایید.";
				$reply_msg="";
				}else $reply_msg2="کارشناس محترم. شماره پیام به خوبی برای من قابل روئیت نیست. شاید در قالب ارسال اشتباه کرده اید.";
				if(!$reply_msg2=="")
					$result2= $message_op->send_message($bot_token,$chat_user_id,$reply_msg2,0,$message_id);
			}
			
			elseif(substr($message_body,0,6)=="/asdfg")
			{
				if(!(in_array($chat_user_id,$admin_user_id)))
					continue;
				
				$info=$db_op->get_static_info(2);
				if($info)
					$feed_url=$info;
				if((!$feed_url) || $feed_url=="")
					continue;
				if(is_numeric(substr($message_body,7,2)))
					$count=substr($message_body,7,2);
				else $count=1;
				$sublist=$db_op->get_sub_list();
			  if($sublist)
			  {
				$rss=getfeed($feed_url,$count);
				while($sbl=$sublist->fetch_object())
				{
				
					if($rss)
foreach($rss as $item)
{
	$reply_msg.="
	".$item->link;

	$result= $message_op->send_message($bot_token,$sbl->user_id,$reply_msg);

}
				}
			  }
			  
			 
			  
			  $reply_msg="";
				
			}
			
			elseif(substr($message_body,0,12)=="/updatestart")
			{
				if(!(in_array($chat_user_id,$admin_user_id)))
					continue;
					
				$new_body=substr($message_body,13);
				if(trim($new_body)!="")
					if($db_op->update_static_info(1,$new_body))
$reply_msg="متن شروع با موفقیت تغییر یافت";
			}
			/*
			elseif(substr($message_body,0,11)=="/updatefeed")
			{
				if(!(in_array($chat_user_id,$admin_user_id)))
					continue;
					
				$new_body=substr($message_body,12);
				if(trim($new_body)!="")
					if($db_op->update_static_info(2,$new_body))
$reply_msg="آدرس خوراک با موفقیت تغییر یافت";
			}
			*/
			elseif(substr($message_body,0,5)=="/mass" || substr($message_body,0,5)=="/Mass")
			{
				if(!(in_array($chat_user_id,$admin_user_id)))
					continue;
					
				$img_pos=strpos($message_body,'#');
				$imgs=substr($message_body,6,$img_pos-6);
				$user_message=substr($message_body,$img_pos+2);	
				//$user_message=trim(substr($message_body,6));
				
				$count=0;
			  $last_mass=$db_op->get_last_active_mass_mess();
			  if(!$last_mass)
			  {
				if($user_message!="" && $user_message)
				{
					
					$users_count=$db_op->get_sub_count();	
					$groups_count=$db_op->get_groups_count();
					
					$mass_id=$db_op->add_mass_mess($user_message,$users_count,$groups_count,$imgs);
					if($mass_id)
					{
$db_op->mark_users_mass_mess();
$db_op->mark_groups_mass_mess();
$estimated_time=($users_count/100)*2;
$estimated_time+=($groups_count/100)*2;
$estimated_time+=4;

$reply_msg="پیام شما جهت ارسال انبوه برنامه ریزی گردید. پیام شما به ".$users_count." کاربر و ".$groups_count." گروه ارسال خواهد شد. همچنین این ارسال با نرخ 100 پیام در هر 2 دقیقه و 2 دقیقه زمان مورد نیاز برای اعلام نتیجه، حداقل ".$estimated_time." دقیقه به طول خواهد انجامید. شماره عملیات: ".$mass_id."
توجه داشته باشید که در حین اجرای عملیات نبایست عملیات پیام انبوه جدیدی را ست کنید در این صورت عملیات فعلی متوقف و از ابتدا روی عملیات جدید آغاز خواهد شد.
برای توقف ارسال آخرین عملیات تنظیم شده از دستور زیر استفاده کنید:
/stopmass";
$result= $message_op->send_message($bot_token,$chat_user_id,$reply_msg);
$reply_msg="";
					}
					
				}
				else $result= $message_op->send_message($bot_token,$chat_user_id,"متاسفانه شما پیامی وارد نکردید");
				
				
			  }else $result= $message_op->send_message($bot_token,$chat_user_id,"متاسفانه عملیات پیام انبوه دیگری بر روی سیستم ست شده است. لطفا آن را با دستور /stopmass متوقف نمایید.");
			  $reply_msg="";
			  	
			}
			
			elseif(in_array($message_body,array("/stopmass")))
			{
				$db_op->mark_users_mass_mess(0,0);
				$db_op->mark_groups_mass_mess(0,0);
				
				$last_mass=$db_op->get_last_active_mass_mess();
				if($last_mass)
				{
					if($db_op->mark_mass_mess($last_mass->id))
$reply_msg="عملیات پیام انبوه با موفقیت متوقف شد. شماره عملیات: ".$last_mass->id;
				}
				else $reply_msg="عملیاتی جهت توقف وجود ندارد.";
				
			}
			
			elseif(substr($message_body,0,7)=="/addbtn")
			{
				if(!(in_array($chat_user_id,$admin_user_id)))
					continue;
				
				/*
				$keys_pos=strpos($message_body,'#');
				$keys=substr($message_body,8,$keys_pos-8);
				$clean_string=substr($message_body,$keys_pos+2);
				*/
				
				
				
				$cap=substr($message_body,8);
				
				$button_id=$db_op->add_button($cap,$cap);
				if($button_id)
					$reply_msg="دکمه با موفقیت اضافه شد.شماره: ".$button_id."
					برای افزودن متن، عکس، داکیومنت و فید از فرمت دستوری زیر می توانید استفاده کنید:
					/setbtntext ".$button_id."# yourtext
					/setbtnpic ".$button_id."# pic_id
					/setbtndoc ".$button_id."# doc_id
					/setbtnfeed ".$button_id."# feed_id
					برای پیوند زدن این دکمه به زیر منوی دکمه ی دیگر از فرمت دستوری زیر می توانید استفاده کنید:
					/setbtnparent ".$button_id."# parent_id
					برای قرار دادن این دکمه در منوی اصلی از فرمت دستوری زیر می توانید استفاده کنید:
					/setbtnmain ".$button_id."#";
				else $reply_msg="خطا در افزودن اطلاعات";
			}
			elseif(substr($message_body,0,11)=="/setbtntext")
			{
				if(!(in_array($chat_user_id,$admin_user_id)))
					continue;
				
				$keys_pos=strpos($message_body,'#');
				$keys=substr($message_body,12,$keys_pos-12);
				$clean_string=substr($message_body,$keys_pos+2);
				
				$button_id=$keys;
				
				$new_text=$clean_string;
				
				$button_edit=$db_op->update_button_text($button_id,$new_text);
				if($button_edit)
					$reply_msg="متن دکمه با موفقیت ویرایش شد";
					
				else $reply_msg="خطا در تنظیم متن دکمه";
			}
			elseif(substr($message_body,0,10)=="/setbtnpic")
			{
				if(!(in_array($chat_user_id,$admin_user_id)))
					continue;
				
				$keys_pos=strpos($message_body,'#');
				$keys=substr($message_body,11,$keys_pos-11);
				$clean_string=substr($message_body,$keys_pos+2);
				
				$button_id=$keys;
				
				$new_imgs=$clean_string;
				
				$button_edit=$db_op->update_button_imgs($button_id,$new_imgs);
				if($button_edit)
					$reply_msg="تصویر دکمه با موفقیت ویرایش شد";
					
				else $reply_msg="خطا در تنظیم تصویر دکمه";
			}
			elseif(substr($message_body,0,10)=="/setbtndoc")
			{
				if(!(in_array($chat_user_id,$admin_user_id)))
					continue;
				
				$keys_pos=strpos($message_body,'#');
				$keys=substr($message_body,11,$keys_pos-11);
				$clean_string=substr($message_body,$keys_pos+2);
				
				$button_id=$keys;
				
				$new_docs=$clean_string;
				
				$button_edit=$db_op->update_button_docs($button_id,$new_docs);
				if($button_edit)
					$reply_msg="داکیومنت دکمه با موفقیت ویرایش شد";
					
				else $reply_msg="خطا در تنظیم داکیومنت دکمه";
			}
			elseif(substr($message_body,0,10)=="/setbtncap")
			{
				if(!(in_array($chat_user_id,$admin_user_id)))
					continue;
				
				$keys_pos=strpos($message_body,'#');
				$keys=substr($message_body,11,$keys_pos-11);
				$clean_string=substr($message_body,$keys_pos+2);
				
				$button_id=$keys;
				
				$new_caption=$clean_string;
				
				$button_edit=$db_op->update_button_caption($button_id,$new_caption);
				if($button_edit)
					$reply_msg="متن دکمه با موفقیت ویرایش شد";
					
				else $reply_msg="خطا در تنظیم متن دکمه";
			}
			elseif(substr($message_body,0,11)=="/setbtnfeed")
			{
				if(!(in_array($chat_user_id,$admin_user_id)))
					continue;
				
				$keys_pos=strpos($message_body,'#');
				$keys=substr($message_body,12,$keys_pos-12);
				$clean_string=substr($message_body,$keys_pos+2);
				
				$button_id=$keys;
				
				$new_feed_id=$clean_string;
				
				$button_edit=$db_op->update_button_feed($button_id,$new_feed_id);
				if($button_edit)
					$reply_msg="شناساگر خبرخوان دکمه با موفقیت ویرایش شد";
					
				else $reply_msg="خطا در تنظیم شناساگر خبرخوان دکمه";
			}
			elseif(substr($message_body,0,11)=="/setbtnmain")
			{
				if(!(in_array($chat_user_id,$admin_user_id)))
					continue;
				
				$keys_pos=strpos($message_body,'#');
				$keys=substr($message_body,12,$keys_pos-12);
				$clean_string=substr($message_body,$keys_pos+2);
				
				$button_id=$keys;
				
				$new_feed_id=$clean_string;
				
				$button_edit=$db_op->update_button_main($button_id);
				if($button_edit)
					$reply_msg="دکمه با موفقیت به منوی اصلی افزوده شد";
					
				else $reply_msg="خطا در افزودن دکمه به منوی اصلی";
			}
			elseif(substr($message_body,0,11)=="/rembtnmain")
			{
				if(!(in_array($chat_user_id,$admin_user_id)))
					continue;
				
				$keys_pos=strpos($message_body,'#');
				$keys=substr($message_body,12,$keys_pos-12);
				$clean_string=substr($message_body,$keys_pos+2);
				
				$button_id=$keys;
				
				$new_feed_id=$clean_string;
				
				$button_edit=$db_op->update_button_main($button_id,0);
				if($button_edit)
					$reply_msg="دکمه با موفقیت از منوی اصلی حذف شد";
					
				else $reply_msg="خطا در حذف دکمه از منوی اصلی";
			}
			elseif(substr($message_body,0,8)=="/showbtn")
			{
				if(!(in_array($chat_user_id,$admin_user_id)))
					continue;
				
				$keys_pos=strpos($message_body,'#');
				$keys=substr($message_body,9,$keys_pos-9);
				$clean_string=substr($message_body,$keys_pos+2);
				
				$button_id=$keys;
				
				$new_feed_id=$clean_string;
				
				$button_edit=$db_op->update_button_status($button_id);
				if($button_edit)
					$reply_msg="نمایش دکمه با موفقیت فعال شد";
					
				else $reply_msg="خطا در فعالسازی نمایش دکمه";
			}
			elseif(substr($message_body,0,8)=="/hidebtn")
			{
				if(!(in_array($chat_user_id,$admin_user_id)))
					continue;
				
				$keys_pos=strpos($message_body,'#');
				$keys=substr($message_body,9,$keys_pos-9);
				$clean_string=substr($message_body,$keys_pos+2);
				
				$button_id=$keys;
				
				$new_feed_id=$clean_string;
				
				$button_edit=$db_op->update_button_status($button_id,0);
				if($button_edit)
					$reply_msg="نمایش دکمه با موفقیت غیرفعال شد";
					
				else $reply_msg="خطا در غیرفعالسازی نمایش دکمه";
			}
			elseif(substr($message_body,0,13)=="/setbtnparent")
			{
				if(!(in_array($chat_user_id,$admin_user_id)))
					continue;
				
				$keys_pos=strpos($message_body,'#');
				$keys=substr($message_body,14,$keys_pos-14);
				$clean_string=substr($message_body,$keys_pos+2);
				
				$button_id=$keys;
				
				$new_parent_id=$clean_string;
				
				$button_edit=$db_op->update_button_parent($button_id,$new_parent_id);
				if($button_edit)
					$reply_msg="دکمه با موفقیت در زیر منوی مربوطه جای گرفت";
					
				else $reply_msg="خطا در جایگیری دکمه در زیرمنوی مربوطه";
			}
			elseif(substr($message_body,0,7)=="/delbtn")
			{
				if(!(in_array($chat_user_id,$admin_user_id)))
					continue;
				
				$id_pos=strpos($message_body,'#');
				$button_id=substr($message_body,8,$id_pos-8);
				$clean_string=substr($message_body,$id_pos+1);
				if($db_op->remove_button($button_id))
					$reply_msg="دکمه با موفقیت حذف شد.";
				else $reply_msg="خطا در حذف دکمه";
					
				
				
			}
			elseif($message_body=="/showmainbtn")
			{
				if(!(in_array($chat_user_id,$admin_user_id)))
					continue;
				
				
				$button_main=$db_op->get_button_list_by_type(1,1);
				if($button_main)
				{
					$divider=0;
					while($main=$button_main->fetch_object())
					{
$reply_msg.="-شناسه دکمه: ".$main->id."
عنوان دکمه: ".$main->caption."
----------
";
$main_childs=$db_op->get_button_list_by_parent($main->id);
if($main_childs)
{
	while($child=$main_childs->fetch_object())
		$reply_msg.="+شناسه سرشاخه: ".$main->id."
		شماره دکمه: ".$child->id."
		عنوان دکمه: ".$child->caption."
		---------------------
		
";
}
$divider++;
if($divider%10==0)
{
	$result= $message_op->send_message($bot_token,$chat_user_id,$reply_msg);
	$reply_msg="";
	$divider=0;
}
					}
					
				}
				else $reply_msg="متاسفانه دکمه ای پیدا نشد";
			}
			elseif($message_body=="/showallbtn")
			{
				if(!(in_array($chat_user_id,$admin_user_id)))
					continue;
				
				
				$button_all=$db_op->get_button_list_all(1);
				if($button_all)
				{
					$divider=0;
					while($main=$button_all->fetch_object())
					{
$divider++;

$reply_msg.="شناسه سرشاخه: ".$main->parent_id."
شماره دکمه: ".$main->id."
عنوان دکمه: ".$main->caption."
---------------------
";
if($divider%10==0)
{
	$result= $message_op->send_message($bot_token,$chat_user_id,$reply_msg);
	$reply_msg="";
	$divider=0;
}
	
					}
					
				}
				else $reply_msg="متاسفانه دکمه ای پیدا نشد";
			}
			
			elseif(substr($message_body,0,12)=="/setmaincols")
			{
				if(!(in_array($chat_user_id,$admin_user_id)))
					continue;
				
				$id_pos=strpos($message_body,'#');
				$main_cols=substr($message_body,13,$id_pos-13);
				$clean_string=substr($message_body,$id_pos+2);
				if($main_cols && $main_cols!="")
				{
					if(is_numeric($main_cols))
					{
if($db_op->update_general_options("main_cols",$main_cols))
	$reply_msg="تعداد ستون های منوی اصلی با موفقیت ویرایش شد.";
else $reply_msg="خطا در به روز رسانی ستون های منوی اصلی";
					}
					else $reply_msg="خطا: لطفا تعداد ستون ها را به صورت عددی وارد نمایید";
				}else $reply_msg="خطا: لطفا تعداد ستون ها را در فرمت دستوری مشخص شده وارد نمایید";
				
			}
			elseif(substr($message_body,0,11)=="/setsubcols")
			{
				if(!(in_array($chat_user_id,$admin_user_id)))
					continue;
				
				$id_pos=strpos($message_body,'#');
				$sub_cols=substr($message_body,12,$id_pos-12);
				$clean_string=substr($message_body,$id_pos+2);
				if($sub_cols && $sub_cols!="")
				{
					if(is_numeric($sub_cols))
					{
if($db_op->update_general_options("sub_cols",$sub_cols))
	$reply_msg="تعداد ستون های منوی فرعی با موفقیت ویرایش شد.";
else $reply_msg="خطا در به روز رسانی ستون های منوی فرعی";
					}
					else $reply_msg="خطا: لطفا تعداد ستون ها را به صورت عددی وارد نمایید";
				}else $reply_msg="خطا: لطفا تعداد ستون ها را در فرمت دستوری مشخص شده وارد نمایید";
				
			}

?>

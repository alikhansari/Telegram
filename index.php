<?php 
/*in the name of god
* eastweb.ir information structures
* all rights reserved
* 
*/
set_time_limit(0);
require_once("class/download.php");
require_once("class/download2.php");
require_once("class/message.php");
require_once("class/rss.php");
require_once("class/config.php");
require_once("class/db_operation.php");
require_once("class/crawler.php");
$message_op=new TgMessage;
$db_op=new Bot_db;
	
	
	
	
	/*bot_introduction*/
	$url="https://api.telegram.org/bot".$bot_token."/getme";
	
	$json = download_url($url);
	
	$bot_info=json_decode($json);
	if(!$bot_info)
		{exit;}
	if(!$bot_info->ok)
		{exit;}
	
	$last_update_id=$db_op->get_last_update_id();
	if($last_update_id)
		$offset="&offset=".($last_update_id+1);
	else $offset="";echo $offset;
	$limit="?limit=100";
	$url="https://api.telegram.org/bot".$bot_token."/getupdates".$limit.$offset;
	$json = download_url($url);
	$update=json_decode($json);
	if($update)
	{	
		if($update->ok)
			if($update->result)
				if(is_array($update->result))
				{
					foreach($update->result as $upd)
					{
						$update_id=$upd->update_id;
						$last_update_id=$db_op->get_last_update_id();
						if($last_update_id)
							if($last_update_id==$update_id)
								continue;
							if($upd->message)
							{
								
								
								$message_id=$upd->message->message_id;
								$message_body="";
								if(@$upd->message->text)
									$message_body=$upd->message->text;
								
								if($upd->message->from)
								{
									$user_id=$upd->message->from->id;
									$first_name=$upd->message->from->first_name;
									$last_name=$upd->message->from->last_name;
									$username=$upd->message->from->username;
									
									$chat_user_id=$upd->message->chat->id;
									@$chat_title=$upd->message->chat->title;
									$chat_first_name=$upd->message->chat->first_name;
									$chat_last_name=$upd->message->chat->last_name;
									$chat_username=$upd->message->chat->username;
									
									
									if($db_op->get_update_msg_id($update_id))
										continue;
									else
										$add_db_res=$db_op->add_update($update_id,$message_id,$chat_user_id,$message_body,time(),$chat_username,$chat_user_id);
									
									if(@$upd->message->photo)
									{
										if(!(in_array($chat_user_id,$admin_user_id)))
											continue;
										elseif(@$upd->message->chat->title)
											continue;
										else $result= $message_op->send_message($bot_token,$chat_user_id,$upd->message->photo[0]->file_id);
										continue;
									}
									if(@$upd->message->document)
									{
										if(!(in_array($chat_user_id,$admin_user_id)))
											continue;
										elseif(@$upd->message->chat->title)
											continue;
										else $result= $message_op->send_message($bot_token,$chat_user_id,$upd->message->document->file_id);
										continue;
									}
									//added to new group
									if(@$upd->message->new_chat_participant)
										if($upd->message->new_chat_participant->id==$bot_info->result->id)
											if(@$upd->message->chat->title)
												if(!($db_op->check_group_exist($chat_user_id)))
													$add_grp_res=$db_op->add_group($chat_user_id,$chat_title,time());
									//left group
									if(@$upd->message->left_chat_participant)
										if($upd->message->left_chat_participant->id==$bot_info->result->id)
											if(@$upd->message->chat->title)
												if(($db_op->check_group_exist($chat_user_id)))
													$rm_grp_res=$db_op->remove_group($chat_user_id);
													
													
									//update title
									if(@$upd->message->new_chat_title)
											if(!($db_op->check_group_exist($chat_user_id)))
													$add_grp_res=$db_op->add_group($chat_user_id,$chat_title,time());
											else
													$update_grp_res=$db_op->update_group($chat_user_id,$chat_title);
									
									
									if(!($db_op->check_user_exist($user_id)))
											$add_usr_res=$db_op->add_user($user_id,time(),$chat_username);
									
									$disable_link_preview=0;
									$reply_to_msg=0;
									$reply_markup=0;
									$reply_msg="";
									if(trim($message_body==""))
										continue;
									$all_cmd=$db_op->get_cmd_list();
									
									if($all_cmd)
										while($cmd=$all_cmd->fetch_object())
										{
											if($cmd->key_array)
											{
												$key_array=explode(';',$cmd->key_array);
												$img_array=explode(';',$cmd->img_array);
												$doc_array=explode(';',$cmd->doc_array);
												if($key_array)
												{
													if(in_array(substr($message_body,1),$key_array) || in_array(substr($message_body,0),$key_array))
													{
														if($cmd->msg)
															if($cmd->msg!="")
																$result= $message_op->send_message($bot_token,$chat_user_id,$cmd->msg);
														
																		
														if($img_array)
															foreach($img_array as $img)
																$message_op->send_photo($bot_token,$chat_user_id,$img);
														if($doc_array)
															foreach($doc_array as $doc)
																$message_op->send_document($bot_token,$chat_user_id,$doc);
														if($cmd->feed_id)
														{
															$feed_info=$db_op->get_feed($cmd->feed_id);
															if($feed_info)
															{
																$feed_url=$feed_info->url;
																$feed_count=$feed_info->cnt;
																if($feed_url)
																{
																	$rss=getfeed($feed_url,$feed_count);
																	if($rss)
																		foreach($rss as $item)
																		{
																			$reply_msg=$item->link;
												
																			$result= $message_op->send_message($bot_token,$chat_user_id,$reply_msg);
																			$reply_msg="";
																		}//foreach
																}//feed_url
																
															}//feed_info
														}//feed_id
													}//in_array
												}//key_array
												}//fristkeyarray
												
											}//while
											
										
										
									
									$all_btn=$db_op->get_button_list_all();
									
									if($all_btn)
										while($btn=$all_btn->fetch_object())
										{
											if($btn->caption)
											{
												$btn_caption=$btn->caption;
												
												
												if($btn_caption!="")
												{
													if($message_body==$btn_caption)
													{
														$img_array=explode(';',$btn->img_array);
														$doc_array=explode(';',$btn->doc_array);
														$child_buttons=$db_op->get_button_list_by_parent($btn->id,1);
														$child_cols_res=$db_op->get_general_options("sub_cols");
														$child_cols=2;
														if($child_cols_res)
															if($child_cols_res->info)
																if(intval($child_cols_res->info)>0)
																	$child_cols=intval($child_cols_res->info);var_dump($child_buttons);
														$keyboard=array();
														if($child_buttons)
														{
															$temp_array=array();
															$col_counter=0;
															while($chbt=$child_buttons->fetch_object())
															{
																if($chbt->caption)
																{
																	$chbt_caption=$chbt->caption;
													
												
																	if($chbt_caption!="")
																	{
																		$col_counter++;
																		array_push($temp_array,$chbt->caption);
													
																	}//child_cap
																	if($col_counter==$child_cols && count($temp_array))
																	{
																		array_push($keyboard,$temp_array);
																		$temp_array=array();
																		$col_counter=0;
																	}//col_counter
																}//caption check
															}//childs while
															if(count($temp_array))
															{
																array_push($keyboard,$temp_array);
																$temp_array=array();
																
															}//temp array count
															if(count($keyboard))
															{
																array_push($keyboard,array("/منوی اصلی"));
																$reply_markup = array(
    																'keyboard' => $keyboard
   										 			
																	,'resize_keyboard'=> true
																);
																$reply_markup = json_encode($reply_markup);	
															}//keyboar count
															
														}//child existance
														
														
													
														if($btn->text)
															if($btn->text!="")
																$result= $message_op->send_message($bot_token,$chat_user_id,$btn->text,0,0,$reply_markup);
														
																		
														if($img_array)
															foreach($img_array as $img)
																$message_op->send_photo($bot_token,$chat_user_id,$img,$reply_markup);
														if($doc_array)
															foreach($doc_array as $doc)
																$message_op->send_document($bot_token,$chat_user_id,$doc,$reply_markup);
														if($btn->feed_id)
														{
															$feed_info=$db_op->get_feed($btn->feed_id);
															if($feed_info)
															{
																$feed_url=$feed_info->url;
																$feed_count=$feed_info->cnt;
																if($feed_url)
																{
																	$rss=getfeed($feed_url,$feed_count);
																	if($rss)
																		foreach($rss as $item)
																		{
																			$reply_msg=$item->link;
												
																			$result= $message_op->send_message($bot_token,$chat_user_id,$reply_msg);
																			$reply_msg="";
																		}//foreach
																}//feedurl
																
															}//feedinfo
														}//feedid
													 }//button_caption_equal
													}//button_notempty
												}//button caption exist
												
											}//while
											
										
							/************Administrative area************/
							if((in_array($chat_user_id,$admin_user_id)))
							{		
									include("administrative.php");
							}//end of administrative commands
									/**********End of Administrative area************/
									
									/**********user area************/
									if(in_array($message_body,array("/منوی اصلی","/start","/start".$bot_info->result->username)))
									{
										$info=$db_op->get_static_info(1);
										if($info)
											$reply_msg=$info;
											
										$all_main_btn=$db_op->get_button_list_by_type(1,1);
										$main_cols_res=$db_op->get_general_options("main_cols");
										$main_cols=2;
										if($main_cols_res)
											if($main_cols_res->info)
												if(intval($main_cols_res->info)>0)
													$main_cols=intval($main_cols_res->info);
										
										$keyboard=array();
										if($all_main_btn)
										{
											$temp_array=array();
											$col_counter=0;
										  while($btn=$all_main_btn->fetch_object())
										  {
											if($btn->caption)
											{
												$btn_caption=$btn->caption;
												
												
												if($btn_caption!="")
												{
													$col_counter++;
													array_push($temp_array,$btn->caption);
													
												}//caption not empty
												if($col_counter==$main_cols && count($temp_array))
												{
													array_push($keyboard,$temp_array);
													$temp_array=array();
													$col_counter=0;
												}//cal counter
											}//caption existance
										  }//while
											if(count($temp_array))
											{
													array_push($keyboard,$temp_array);
													$temp_array=array();
											}//temp array
											if(count($keyboard))
											{
													$reply_markup = array(
    												'keyboard' => $keyboard
   										 			
													,'resize_keyboard'=> true
												);
												
												$reply_markup = json_encode($reply_markup);	var_dump($reply_markup);
											}//keyboard
											
										}//all main btn
									}
									elseif(in_array($message_body,array("/programmer","/Programmer","programmer","Programmer")))
									{
										$reply_msg="جهت آمرزش گناهان و یاری گمراهان صلوات";
										
									}
									
									/*
									elseif(substr($message_body,0,5)=="/news" || substr($message_body,0,5)=="/News" || $message_body=="/news".$bot_info->result->username)
									{
										$info=$db_op->get_static_info(2);
										if($info)
											$feed_url=$info;
										if((!$feed_url) || $feed_url=="")
											continue;
										if(is_numeric(trim(substr($message_body,6,2))))
											$count=substr($message_body,6,2);
										else $count=3;
										$rss=getfeed($feed_url,$count);
										if($rss)
											foreach($rss as $item)
											{
												$reply_msg.="
												".$item->link;
												
												$result= $message_op->send_message($bot_token,$chat_user_id,$reply_msg);
												$reply_msg="";
											}
										
									}
									elseif(substr($message_body,0,4)=="news" || substr($message_body,0,4)=="News")
									{
										$info=$db_op->get_static_info(2);
										if($info)
											$feed_url=$info;
										if((!$feed_url) || $feed_url=="")
											continue;
										if(is_numeric(trim(substr($message_body,5,2))))
											$count=substr($message_body,5,2);
										else $count=3;
										$rss=getfeed($feed_url,$count);
										if($rss)
											foreach($rss as $item)
											{
												$reply_msg.="
												".$item->link;
												
												$result= $message_op->send_message($bot_token,$chat_user_id,$reply_msg);
												$reply_msg="";
											}
										
									}
									*/
									elseif(in_array($message_body,array("/contactus","/contactus@".$bot_info->result->username,"/Contactus","/Contactus@".$bot_info->result->username)))
									{
										$reply_msg="پیام خود را برای مدیر ربات بنویسید.";
										$force_reply=array("force_reply" => true);
										
										$reply_markup=json_encode($force_reply);
										$result= $message_op->send_message($bot_token,$chat_user_id,$reply_msg,$disable_link_preview,0,$reply_markup);
										
										$reply_msg="";
									}
									
									
									/*
									elseif(substr($message_body,0,10)=="/contactus" || substr($message_body,0,10)=="/Contactus")
									{
										if(substr($message_body,0,27)=="/contactus@".$bot_info->result->username || substr($message_body,0,27)=="/Contactus@".$bot_info->result->username || substr($message_body,0,27)=="/Contactus@".$bot_info->result->username || substr($message_body,0,27)=="/contactus@".$bot_info->result->username)
										{
											$clean_msg=substr($message_body,28);
										}
										else
										$clean_msg=substr($message_body,11);
											if(trim($clean_msg==""))
												{
													$reply_msgX=" متاسفانه شما سوالی نپرسیدید. لطفا به قالب پیام دقت بفرمایید. پس از دستور یک فاصله بزنید و سوال خود را بنویسید! ";
												$resultX= $message_op->send_message($bot_token,$chat_user_id,$reply_msgX,0,$message_id);
												continue;
												}
										
										$reply_msg=$update_id." ***  @".$username."\n".$clean_msg;
										foreach($contact_us_user_id as $contactus)
											$result= $message_op->send_message($bot_token,$contactus,$reply_msg);
										$reply_msg2=" متشکرم. پیام شما دریافت شد. پس از بررسی کارشناس پاسخ را در همین مکان به شما باز می گردانم. ";
										$result2= $message_op->send_message($bot_token,$chat_user_id,$reply_msg2,0,$message_id);
										
										$reply_msg="";
									}
									elseif(substr($message_body,0,9)=="contactus" || substr($message_body,0,9)=="Contactus")
									{
										
										if(substr($message_body,0,26)=="contactus@".$bot_info->result->username || substr($message_body,0,26)=="Contactus@".$bot_info->result->username || substr($message_body,0,26)=="Contactus@".$bot_info->result->username || substr($message_body,0,26)=="contactus@".$bot_info->result->username)
										{
											$clean_msg=substr($message_body,27);
										}
										else
										$clean_msg=substr($message_body,10);
											if(trim($clean_msg==""))
												{
													$reply_msgX=" متاسفانه شما سوالی نپرسیدید. لطفا به قالب پیام دقت بفرمایید. پس از دستور یک فاصله بزنید و سوال خود را بنویسید! ";
												$resultX= $message_op->send_message($bot_token,$chat_user_id,$reply_msgX,0,$message_id);
												continue;
												}
										
										$reply_msg=$update_id." ***  @".$username."\n".$clean_msg;
										
										foreach($contact_us_user_id as $contactus)
											$result= $message_op->send_message($bot_token,$contactus,$reply_msg);
										$reply_msg2=" متشکرم. پیام شما دریافت شد. پس از بررسی کارشناس پاسخ را در همین مکان به شما باز می گردانم. ";
										$result2= $message_op->send_message($bot_token,$chat_user_id,$reply_msg2,0,$message_id);
										
										$reply_msg="";
									}*/
									
									
									
									
									elseif( $message_body=="/sub" || $message_body=="/Sub" || $message_body=="/sub@".$bot_info->result->username || $message_body=="sub" || $message_body=="Sub" || $message_body=="sub@".$bot_info->result->username)
									{
										if(!($db_op->check_user_exist($user_id)))
											$add_usr_res=$db_op->add_user($user_id,time(),$chat_user_id,$chat_username);
										$add_sub_res=$db_op->subscrible($user_id,1);
										$reply_msg="از عضویت شما سپاسگزاریم :) لطفاً  چنانچه تمایل به لغو عضویت دارید، دکمه زیر را کلیک یا تایپ کنید:
										/unsub";
										
									}
									elseif( $message_body=="/unsub" || $message_body=="/Unsub" || $message_body=="/unsub@".$bot_info->result->username || $message_body=="unsub" || $message_body=="Unsub" || $message_body=="unsub@".$bot_info->result->username )
									{
										
										$add_db_res=$db_op->subscrible($user_id,0);
										$reply_msg="به امید دیدن شما در دیگر فضاهای مجازی؛
										برای عضویت  مجدد می توانید از دستور زیر استفاده کنید
										/sub";
										
									}
									
									elseif(in_array($message_body,array("/bazar","/rates","/bazar@".$bot_info->result->username,"/rates@".$bot_info->result->username)))
									{
										$reply_msg="به منوی قیمت روز خوش اومدید، برای اطلاع از قیمت روز و لحظه ای طلا،سکه،ارز و بورس می تونید از من استفاده کنید. من دقیق ترین قیمت ها رو به شما میدم.
										/arz
										/seke
										/tala
										/bours";
										
									}
									elseif(in_array($message_body,array("/arz","/seke","/bours","/tala","/arz@".$bot_info->result->username,"/seke@".$bot_info->result->username,"/bours@".$bot_info->result->username,"/tala@".$bot_info->result->username)))
									{
										if($message_body=="/arz" || $message_body=="/arz@".$bot_info->result->username)
										{
											$url="http://www.tgju.org/";
											$content=download_urlx($url);
											$parser=new News_parser;
											$all=$parser->parse_all($content);
											if($all)
											{
												$reply_msg="قیمت ارز در این لحظه: 
												 ";
												$reply_msg.='دلار: '.$all['dollar'].'
												';
												$reply_msg.='یورو: '.$all['euro'].'
												';
												$reply_msg.='پوند: '.$all['pond'].'
												';
												$reply_msg.='درهم امارات: '.$all['derham'].'
												';
												$reply_msg.='لیر ترکیه: '.$all['lirtork'].'
												';
												
												
											}
										}
										elseif($message_body=="/seke" || $message_body=="/seke@".$bot_info->result->username)
										{
											$url="http://www.tgju.org/";
											$content=download_urlx($url);
											$parser=new News_parser;
											$all=$parser->parse_all($content);
											if($all)
											{
												$reply_msg="قیمت سکه در این لحظه: 
												";
												$reply_msg.='تمام بهار: '.$all['seke_bahar'].'
												';
												$reply_msg.='قدیم: '.$all['seke_emam'].'
												';
												$reply_msg.='نیم بهار: '.$all['seke_nim'].'
												';
												$reply_msg.='ربع بهار: '.$all['seke_rob'].'
												';
												$reply_msg.='گرمی: '.$all['seke_gerami'].'
												';
												
											}
										}
										elseif($message_body=="/tala" || $message_body=="/tala@".$bot_info->result->username)
										{
											$url="http://www.tgju.org/";
											$content=download_urlx($url);
											$parser=new News_parser;
											$all=$parser->parse_all($content);
											if($all)
											{
												$reply_msg="قیمت طلا در این لحظه: \n";
												$reply_msg.='انس: '.$all['tala_ons'].'
												';
												$reply_msg.='مثقال: '.$all['tala_mesghal'].'
												';
												$reply_msg.='هرگرم 18عیار: '.$all['tala_geram18'].'
												';
												$reply_msg.='هرگرم 24عیار: '.$all['tala_geram24'].'
												';
												
												
											}
										}
										elseif($message_body=="/bours"  || $message_body=="/bours@".$bot_info->result->username)
										{
											$url="http://www.tgju.org/bourse-iran";
											$content=download_urlx($url);
											$parser=new News_parser;
											$all=$parser->parse_bourse($content);
											if($all)
											{
												$reply_msg="اطلاعات بورس: 
												";
												$reply_msg.='شاخص کل: '.$all['shakhes_kol'].'
												';
												$reply_msg.='شاخص بازار اول: '.$all['shakhes_bazar1'].'
												';
												$reply_msg.='شاخص بازار دوم: '.$all['shakhes_bazar2'].'
												';
												$reply_msg.='شاخص ۳۰ شركت بزرگ: '.$all['shakhes_30sherkat'].'
												';
												$reply_msg.='شاخص قيمت ۵۰ شركت: '.$all['shakhes_50sherkat'].'
												';
												$reply_msg.='شاخص 50 شركت فعالتر: '.$all['shakhes_50sherkatfaal'].'
												';
												$reply_msg.='شاخص بازده نقدي قيمت: '.$all['shakhes_bazdehnaghdi'].'
												';
												$reply_msg.='شاخص صنعت: '.$all['shakhes_sanaat'].'
												';
												
												
											}
										}
										
										
									}
									elseif(@$upd->message->reply_to_message)
									{
										if($upd->message->reply_to_message->from->id==$bot_info->result->id)
										{
											if(in_array($upd->message->reply_to_message->text,array("پیام خود را برای مدیر ربات بنویسید.")))
											{
												if(trim($message_body)=="")
													exit;
												$reply_msg=$update_id." ***  @".$username."\n".$message_body;
										
												foreach($contact_us_user_id as $contactus)
													$result= $message_op->send_message($bot_token,$contactus,$reply_msg);
												$reply_msg2=" متشکرم. پیام شما دریافت شد. پس از بررسی  پیام شما ؛پاسخ را در همین مکان به شما باز می گردانم. ";
												$result2= $message_op->send_message($bot_token,$chat_user_id,$reply_msg2,0,$message_id);
										
												$reply_msg="";
											}//end of contactus
										}//end of reply username check
									}
									
									if($reply_msg!="")
										$result= $message_op->send_message($bot_token,$chat_user_id,$reply_msg,$disable_link_preview,$reply_to_msg,$reply_markup);
									elseif($reply_markup!=0)
										$result= $message_op->send_message($bot_token,$chat_user_id,$reply_msg,$disable_link_preview,$reply_to_msg,$reply_markup);
								}
								
							}
					}
				}
					
	}
?>
<?php
/*
+--------------------------------------------------------------------------
|
|	WARNING: REMOVING THIS COPYRIGHT HEADER IS EXPRESSLY FORBIDDEN
|
|   ECardMax Version 10.5
|   ========================================
|   (c) 1999 - 2016 ECARDMAX.COM - All right reserved 
|	Software For Website, Inc.
|   http://www.ecardmax.com 
|   ========================================
|   Email: webmaster@ecardmax.com
|   Purchase Info: http://www.ecardmax.com/purchase/
|   Request Installation: http://ecardmax.com/ehelpmax/
|	
|	WARNING //--------------------------
|
|	Selling the code for this program without prior written consent is expressly forbidden. 
|	This computer program is protected by copyright law. 
|	Unauthorized reproduction or distribution of this program, or any portion of if,
|	may result in severe civil and criminal penalties and will be prosecuted to 
|	the maximum extent possible under the law.
+--------------------------------------------------------------------------
*/
//print_r($_POST);//die;
	
	if(ECARDMAX_USER!=1)exit;
	
	if ($cf_enable_twitter) {
		include 'oAuth/EpiCurl.php';
		include 'oAuth/EpiOAuth.php';
		include 'oAuth/EpiTwitter.php';
	}

	//Check sender email to see if it's inside ban list
	$ban_row=get_row("max_ban_user","*","ban_what='$cs_from_email'");
	if ($ban_row[ban_id]!=""){
		if($ban_row[ban_time_end]>0 && $ban_row[ban_time_end] > $begin_today_timestamp){
			$array_global_var[print_object]="<br /><br /><div style=\"text-align:center\">$txt_ban_error_message<br /><br />$ban_row[ban_reason]</div>";
			print_header_and_footer();
			exit;
		}
	}

	//Check requirement
	if($cs_from_name!="" && valid_email($cs_from_email) && $list_email!="" && $cs_message!=""){
		//This cookie is used to check cards user has been sent (prevent spammer)
		setcookie("cookie_cs_from_email",$cs_from_email,time()+(86400*30));
		setcookie("cookie_cs_from_name",$cs_from_name,time()+(86400*30));

		$array=split("\n",$list_email);

		if($cf_show_date_option =="0"){ //MM DD YYYY
			list($cs_send_month,$cs_send_mday,$cs_send_year)=split("\/",$time_end_textbox);
		}
		elseif($cf_show_date_option =="1"){ //DD MM YYYY
			list($cs_send_mday,$cs_send_month,$cs_send_year)=split("\/",$time_end_textbox);
		}
		elseif($cf_show_date_option =="2"){ //YYYY DD MM
			list($cs_send_year,$cs_send_mday,$cs_send_month)=split("\/",$time_end_textbox);
		}
		elseif($cf_show_date_option =="3"){ //YYYY MM DD
			list($cs_send_year,$cs_send_month,$cs_send_mday)=split("\/",$time_end_textbox);
		}
		
		$cs_date_send = time();
		if($cs_send_month==$today_mon && $cs_send_mday==$today_mday && $cs_send_year==$today_year){
			$cs_sent=1;
		}
		else{
			$cs_sent=0;
			$cs_date_send=gmmktime(0,0,0,$cs_send_month,$cs_send_mday,$cs_send_year);
		}
		
		$cs_date_delete=$cs_date_send+(86400*$cf_card_expire_day);
		$cs_lang=$_SESSION[ecardmax_lang];
		$gmt_timestamp_server=adjust_timestamp($cf_timezone);
		
		if($cs_notify=="")$cs_notify=0; 
		$field_name ="(cs_id,cs_ec_id,cs_message,cs_sent,cs_send_month,cs_send_mday,cs_send_year,cs_notify,cs_fmail,cs_fname,cs_from_email,cs_from_name,cs_date_create,cs_date_create_server_time,cs_date_send,cs_date_delete,cs_lang,cs_user_name_id,cs_music_id,cs_music_filename,cs_poem,cs_skin_name,cs_stamp_filename,cs_java,cs_poem_align,cs_sender_ip,cs_pkdate,cs_type,cs_content)";
		$field_value="";
		$chk_num_card=0;
		$show_list_email="";
		// THIS LINE TO FIX THE BUG OCCURR WHEN INSERTING CLIPART, IMAGE IN FIREFOX AND IE BROWSER
		$cs_message=str_replace("../../../","$ecard_url/",$cs_message);
		// THIS LINE TO FIX THE BUG OCCURR WHEN INSERTING CLIPART, IMAGE IN FIREFOX AND IE BROWSER
		
		$mail_data = array();
		foreach($array as $line){
			$line=trim($line);
			if($line!=""){
				$line = htmlspecialchars_decode($line);
				list($re_name,$re_email)=split(";",$line);
				$re_name = htmlspecialchars($re_name);
				//
				if($ec_id==""){
					if($embed_text!=""){
						$cs_type="videocard";
						$cs_content=$_POST[embed_text];
					}
					//more type comming ...
				}
				
				if ($cf_enable_twitter) {
					if((strpos($re_email,"@")!==false && strpos($re_email,"@")==0) || (strpos($re_email,"d ")!== false && strpos($re_email,"d ")==0)) {
						//Count how many cards sent
						$chk_num_card++;							
						//Insert card to database
						$cs_id = substr(md5(uniqid(rand(),1)), 0, 15);
						$field_value .="('$cs_id','$ec_id','$cs_message',$cs_sent,$cs_send_month,$cs_send_mday,$cs_send_year,$cs_notify,'$re_email','$re_name','$cs_from_email','$cs_from_name',$gmt_timestamp_now,$gmt_timestamp_server,$cs_date_send,$cs_date_delete,'$cs_lang','$_SESSION[user_name_id]','$cs_music_id','$cs_music_filename','$cs_poem','$cs_skin_name','$cs_stamp_filename','$cs_java','$cs_poem_align','$remote_addr',0,'$cs_type','$cs_content'),";	
						if($cs_sent=="1"){
						//	$tw_acct=
							if((strpos($re_email,"d ")!== false && strpos($re_email,"d ")==0)){
							//sendDM($username,$password,$message,$recipient)
								if($_SESSION['ec_oauth_token']!="" && $_SESSION['ec_oauth_secret']!=""){
									$twitterObj = new EpiTwitter($cf_consumer_key, $cf_consumer_secret);
									$twitterObj->setToken($_SESSION[ec_oauth_token], $_SESSION[ec_oauth_secret]);	
									$twitter_message_tmp=str_replace("%show_id%",$cs_id,$twitter_message);
									$tw_rcp=str_replace("d ","",$re_email);
									$params[text]="$twitter_message_tmp";
									$params[user]="$tw_rcp";
									$rs=$twitterObj->post_direct_messagesNew($params);//$twitterObj->updateStatus("My test status");
									$rsp=$rs->response;	
								}else{
									$twitter_message_tmp=str_replace("%tw_user%",$tw_user,$twitter_message);
									$twitter_message_tmp=str_replace("%show_id%",$cs_id,$twitter_message_tmp);
									$tw_rcp=str_replace("@","",$re_email);
									sendDM($tw_user,$tw_psw,$twitter_message_tmp,$tw_rcp);
								}
								
							}else{
	//							print_r($_SESSION);								
								if($_SESSION['ec_oauth_token']!="" && $_SESSION['ec_oauth_secret']!=""){
									$twitterObj = new EpiTwitter($cf_consumer_key, $cf_consumer_secret);
									$twitterObj->setToken($_SESSION[ec_oauth_token], $_SESSION[ec_oauth_secret]);	
									$tw_rcp=str_replace("@","",$re_email);
									$twitter_message_tmp=str_replace("%recipient%",$tw_rcp,$twitter_private_message);
									$twitter_message_tmp=str_replace("%show_id%",$cs_id,$twitter_message_tmp);
									$params[status]="$twitter_message_tmp";
									$rs=$twitterObj->post_statusesUpdate($params);
									$rsp=$rs->response;										
								}else{
									$tw_rcp=str_replace("@","",$re_email);
									$twitter_message_tmp=str_replace("%recipient%",$tw_rcp,$twitter_private_message);
									$twitter_message_tmp=str_replace("%show_id%",$cs_id,$twitter_message_tmp);								

									postTwitterUpdate($tw_user,$tw_psw,$twitter_message_tmp);
								}								
							}
							$show_list_email.="<div class=\"OK_Message\" style=\"padding:5px;text-align:left;font-size:10pt;\">$re_name [$re_email] - Card ID# <a href=\"$ecard_url/index.php?step=pickup&action=viewcopy&cs_id=$cs_id\" target=\"_blank\">$cs_id</a></div>";
							//Auto insert Recipient Name + Email to address book 
							if($_SESSION[ecardmax_user] !="" && $save_email== 1){
								//Check if email already there
								if((strpos($re_email,"@")!==false && strpos($re_email,"@")==0) || (strpos($re_email,"d ")!== false && strpos($re_email,"d ")==0)){
									if((strpos($re_email,"d ")!== false && strpos($re_email,"d ")==0)){
										$rp_email=substr($re_email,2);
									}else{
										$rp_email=substr($re_email,1);
									}
									$rp_email="@$rp_email";
									$chk_femail =get_dbvalue("max_addressbook","book_email","book_email='$rp_email' and book_user_name_id='$_SESSION[user_name_id]'");
								}else{
									$chk_femail =get_dbvalue("max_addressbook","book_email","book_email='$re_email' and book_user_name_id='$_SESSION[user_name_id]'");
								}
								if($chk_femail == ""){
									$arr_name=split(" ",$re_name);
									$book_lname=trim($arr_name[count($arr_name)-1]);
									$book_fname=trim(str_replace(" $book_lname","",$re_name));
									if(!isset($rp_email)){
										$rp_email=$re_email;
									}
									insert_data_to_db("max_addressbook","(book_fname,book_lname,book_email,book_user_name_id)","('$book_fname','$book_lname','$rp_email','$_SESSION[user_name_id]')");
							//		echo "insert addressbook";
								}
							}
						}
					}
				}
				
				//
				if(valid_email($re_email)){
					//Send email to each $re_email
					$chk_blacklist_email=get_dbvalue("max_black_list","black_email","black_email='$re_email' and black_active='1'");
					if($chk_blacklist_email==""){//email not on the black list -> send 
						//Count how many cards sent
						$chk_num_card++;							

						//Insert card to database
						$cs_id = substr(md5(uniqid(rand(),1)), 0, 15);
						$field_value .="('$cs_id','$ec_id','$cs_message',$cs_sent,$cs_send_month,$cs_send_mday,$cs_send_year,$cs_notify,'$re_email','$re_name','$cs_from_email','$cs_from_name',$gmt_timestamp_now,$gmt_timestamp_now,$cs_date_send,$cs_date_delete,'$cs_lang','$_SESSION[user_name_id]','$cs_music_id','$cs_music_filename','$cs_poem','$cs_skin_name','$cs_stamp_filename','$cs_java','$cs_poem_align','$remote_addr',0,'$cs_type','$cs_content'),";	
						if($cs_sent=="1"){
							$send_notify_pickup_email_subject=$email_subject_from_name;
							if($send_notify_pickup_email_subject=="")
								$send_notify_pickup_email_subject=$send_notify_pickup_email_subject;
							$send_notify_pickup_email_message_tmp=str_replace("%show_friend_name%",$re_name,$send_notify_pickup_email_message);
							$send_notify_pickup_email_message_tmp=str_replace("%show_id%",$cs_id,$send_notify_pickup_email_message_tmp);
							
							$mail_data[] = array(
								'cs_from_name' => $cs_from_name,
								'cs_from_email' => $cs_from_email,
								're_email' => $re_email,
								'send_notify_pickup_email_subject' => $send_notify_pickup_email_subject,
								'send_notify_pickup_email_message_tmp' => $send_notify_pickup_email_message_tmp,
								'cs_from_email' => $cs_from_email
							);
						}

						//Show list of recipient
						$show_list_email.="<div class=\"OK_Message\" style=\"padding:5px;text-align:left;font-size:10pt;\">$re_name [$re_email] - Card ID# <a href=\"$ecard_url/index.php?step=pickup&action=viewcopy&cs_id=$cs_id\" target=\"_blank\">$cs_id</a></div>";

						//Auto insert Recipient Name + Email to address book 
						if($_SESSION[ecardmax_user] !="" && $save_email== 1){
							//Check if email already there
							$chk_femail =get_dbvalue("max_addressbook","book_email","book_email='$re_email' and book_user_name_id='$_SESSION[user_name_id]'");
							if($chk_femail == ""){
								$arr_name=split(" ",$re_name);
								$book_lname=trim($arr_name[count($arr_name)-1]);
								$book_fname=trim(str_replace(" $book_lname","",$re_name));
								insert_data_to_db("max_addressbook","(book_fname,book_lname,book_email,book_user_name_id)","('$book_fname','$book_lname','$re_email','$_SESSION[user_name_id]')");
							}
						}
					}
					else{
						$show_list_email.="<div class=\"Error_Message\" style=\"padding:5px;text-align:left;font-size:10pt;\">$re_name [$re_email] ($sendcard_didnot_send_because_email_blacklist)</div>";
					}
				}
			}
		}
		if($field_value!=""){
			if($field_value{strlen($field_value)-1} ==",") $field_value = substr($field_value, 0, strlen($field_value)-1);
			insert_data_to_db("max_ecardsent",$field_name,$field_value);
			
			//send mail
			foreach ($mail_data as $item) {
				if($cf_show_from_email=="0"){
					send_email($item['cs_from_name'],$item['cs_from_email'],$item['re_email'],$item['send_notify_pickup_email_subject'],$item['send_notify_pickup_email_message_tmp'],$cf_email_plain_text,$item['cs_from_email']);
				}
				else{
					send_email($item['cs_from_name'],$cf_site_from_email,$item['re_email'],$item['send_notify_pickup_email_subject'],$item['send_notify_pickup_email_message_tmp'],$cf_email_plain_text,$item['cs_from_email']);
				}
			}
		}

		//Save card personal info to $_SESSION incase sender want to resend this card to someone else
		$_SESSION[resend_cs_message]=stripslashes($cs_message);
		$_SESSION[resend_cs_from_email]=$cs_from_email;
		$_SESSION[resend_cs_from_name]=stripslashes($cs_from_name);
		$_SESSION[resend_cs_music_filename]=$cs_music_filename;
		$_SESSION[resend_cs_music_id]=$cs_music_id;
		$_SESSION[resend_cs_poem]=$cs_poem;
		$_SESSION[resend_cs_skin_name]=$cs_skin_name;
		$_SESSION[resend_cs_stamp_filename]=$cs_stamp_filename;
		$_SESSION[resend_cs_java]=$cs_java;
		$_SESSION[resend_cs_poem_align]=$cs_poem_align;

		//Save sender email to max_mail_list (Non member only)
		$field_name ="(list_mgroup_id,list_email,list_name,list_ip,list_time)";
		$field_value="";
		if($user_receive_newsletter == "1" ){
			$chk_email =get_dbvalue("max_mail_list","list_id","list_email='$cs_from_email' and list_mgroup_id ='-1'");
			if($chk_email =="")$field_value.="('-1','$cs_from_email','$cs_from_name','$remote_addr','$gmt_timestamp_now'),";
		}

		if($user_receive_offer == "1" ){
			$chk_email =get_dbvalue("max_mail_list","list_id","list_email='$cs_from_email' and list_mgroup_id ='-2'");
			if($chk_email =="")$field_value.="('-2','$cs_from_email','$cs_from_name','$remote_addr','$gmt_timestamp_now')";
		}
		if($field_value!=""){
			if($field_value{strlen($field_value)-1} ==",") $field_value = substr($field_value, 0, strlen($field_value)-1);
			insert_data_to_db("max_mail_list",$field_name,$field_value);
		}

		//Update max_ecard - ec_time_used
		$ec_time_used=$ec_row[ec_time_used]+1;
		update_field_in_db("max_ecard","ec_time_used",$ec_time_used,"ec_id='$ec_id' LIMIT 1");

		//Update Grabber ec_time so cron job can auto delete
		if($ec_row[ec_user_name_id] =="?")update_field_in_db("max_ecard","ec_time",$cs_date_delete,"ec_id='$ec_id' LIMIT 1");
		
		//Update table max_ecuser - user_total_card_sent
		if($_SESSION[ecardmax_user] != "" && $chk_num_card>0){
			update_field_in_db("max_ecuser","user_total_cardsent",$_SESSION[user_total_cardsent]+$chk_num_card,"user_id='$_SESSION[user_id]' LIMIT 1");
		}
		$_SESSION[ec_allow]="";
		//Update total cards have been created
		$get_oldvalue =get_dbvalue("max_config","config_value","config_name='cf_total_cardsent'")+ $chk_num_card;
		update_field_in_db("max_config","config_value",$get_oldvalue,"config_name='cf_total_cardsent' LIMIT 1");

		//Go to thank you page
		//Display category menu
		require_once ("show_category.php");
		$category_menu=category_menu($cat_id,$cat_id);
		//Display random banner HR & VT
		print_banner("0");
		print_banner("1");
		if($cs_sent==1){
			$sendcard_thankyou_msg="".$sendcard_thankyou_card_has_been_sent." ".$cs_send_month."/".$cs_send_mday."/".$cs_send_year."";
		}
		else{
			$sendcard_thankyou_msg="".$sendcard_thankyou_card_will_be_sent." ".$cs_send_month."/".$cs_send_mday."/".$cs_send_year.".";
		}
		
		// Send video card
		if ($ec_row[ec_cat_dir] == "") {
			$show_card_title="Send Video Card";
			$show_card_thumbnail="<img border=\"0\" alt=\"\" src=\"$ecard_url/templates/$cf_set_template/your_photo.gif\" class=\"thumbnail_image\" /> ";
			$display_thumbnail=get_html_from_layout("templates/$cf_set_template/show_card_has_been_sent.html");
		}
		else if($ec_row[ec_thumbnail]==""){
		
			$my_lang_name="ec_caption_".str_replace(".php","",$_SESSION[ecardmax_lang]);
					if($ec_row[$my_lang_name]==""){
						$show_card_title="$ec_row[ec_caption]";
					}
					else{
						$show_card_title="$ec_row[$my_lang_name]";
					}
					
			$youtube_link=$ec_row[ec_filename];
					if(strpos($youtube_link,'&')!=0)
					{
						
						$show_card_title="Send Video Card";
						$vitri=strlen($youtube_link)-strpos($youtube_link,'&');
						$youtube_link_strim=substr($youtube_link,strpos($youtube_link,'v=')+2,-$vitri);
						$show_card_thumbnail="<img class=\"thumbnail_image\" border=\"0\" alt=\"\" src=\"http://img.youtube.com/vi/$youtube_link_strim/0.jpg\" style=\"max-width: {$cf_thumb_width_member_card}px; max-height: {$cf_thumb_height_member_card}px;\" />";
					}
					else
					{
					
						$youtube_link_strim=substr($youtube_link,strpos($youtube_link,'v=')+2);
						$show_card_thumbnail="<img class=\"thumbnail_image\" border=\"0\" alt=\"\" src=\"http://img.youtube.com/vi/$youtube_link_strim/0.jpg\" style=\"max-width: {$cf_thumb_width_member_card}px; max-height: {$cf_thumb_height_member_card}px;\" />";
					}
					
			$display_thumbnail=get_html_from_layout("templates/$cf_set_template/show_card_has_been_sent.html");
		}else {
			if(file_exists("$ecard_root/resource/picture/$ec_row[ec_cat_dir]/$ec_row[ec_thumbnail]")){
				if($_SESSION[ec_user_name_id]!="?"){
					$my_lang_name="ec_caption_".str_replace(".php","",$_SESSION[ecardmax_lang]);
					if($ec_row[$my_lang_name]==""){
						$show_card_title="$ec_row[ec_caption]";
					}
					else{
						$show_card_title="$ec_row[$my_lang_name]";
					}
					$show_card_thumbnail="<img border=\"0\" alt=\"\" src=\"$ecard_url/resource/picture/$ec_row[ec_cat_dir]/$ec_row[ec_thumbnail]\" class=\"thumbnail_image\" />";
				}
				else{ 
					$show_card_title="Media Grabber";
					$show_card_thumbnail="<img border=\"0\" alt=\"\" src=\"$ecard_url/templates/$cf_set_template/your_photo.gif\" class=\"thumbnail_image\" /> ";
				}
				$display_thumbnail=get_html_from_layout("templates/$cf_set_template/show_card_has_been_sent.html");
			}
			else{
				$display_thumbnail="$sendcard_txt_card_has_been_send_to $show_list_email";
			}

			//Update new account balance (pay per card)
			if($_SESSION[new_account_balance]!=""){
				update_field_in_db("max_ecuser","user_balance",$_SESSION[new_account_balance],"user_id='$_SESSION[user_id]' LIMIT 1");
				$_SESSION[new_account_balance]="";
			}
		}
		
		$array_global_var[print_object]=get_html_from_layout("templates/$cf_set_template/show_thumbnail.html");
		print_header_and_footer();
		exit;
	}
?>
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
	require_once ("config.php");
	require_once("getvars.php");
	require_once("function.php");
	//Get System Configuration 
	$list_cf=set_array_from_query("max_config","*");
	foreach($list_cf as $array_cf){
		$$array_cf[config_name]=$array_cf[config_value];
	}
	
	//SMTP Mail
	if($cf_sendmail_using_SMTP=="1")require_once("pear/Mail.php");
	
	$time_stamp_now_admin=adjust_timestamp($cf_timezone);
	$today_mon = date("n", $time_stamp_now_admin); //ex: 9 - according to webmaster timezone
	$today_mday = date("j", $time_stamp_now_admin); //ex: 31 - according to webmaster timezone
	$today_year = date("Y", $time_stamp_now_admin); //ex: 2006 - according to webmaster timezone
	$wday=date("w", $time_stamp); //ex: 0 (for Sunday) through 6 (for Saturday) - according to webmaster timezone
	$status_check="$today_mon$today_mday$today_year";
	
	$time_stamp_now_server = time();
	$today_mon_server = date("n", $time_stamp_now_server); //ex: 9 - according to server timezone
	$today_mday_server = date("j", $time_stamp_now_server); //ex: 31 - according to server timezone
	$today_year_server = date("Y", $time_stamp_now_server); //ex: 2006 - according to server timezone
	
	$begin_today_timestamp=mktime(0,0,0,$today_mon_server,$today_mday_server,$today_year_server); // accoring to server timezone
	$end_today_timestamp=$begin_today_timestamp + 86400 - 1; // according to server timezone
	
	$print_log ="eCardMAX 10.5 - Cron Job report for Today: " . DateFormat($time_stamp_now_admin) ."\n";
	$print_log .="----------------------------------------------------\n\n";

	//Send birthday cards to group
	$print_log .="\n----------------------------------------------------\n";
	$print_log .="// SEND BIRTHDAY CARDS TO GROUP \n\n";
	
	$list = set_array_from_query("max_birthday_card,max_addressbook,max_ecuser","max_birthday_card.*,max_addressbook.*,max_ecuser.*","max_addressbook.book_ag_relate_id like CONCAT('%',max_birthday_card.cs_group_id,'%') AND max_birthday_card.cs_user_name_id = max_addressbook.book_user_name_id AND 
	max_birthday_card.cs_user_name_id=max_ecuser.user_name_id AND max_addressbook.book_birth_mday=$today_mday AND max_addressbook.book_birth_mon =$today_mon");

	$fields_name ="(cs_id,cs_ec_id,cs_message,cs_sent,cs_send_month,cs_send_mday,cs_send_year,cs_notify,cs_fmail,cs_fname,cs_from_email,cs_from_name,cs_date_create,cs_date_create_server_time,cs_date_send,cs_date_delete,cs_lang,cs_user_name_id,cs_music_filename,cs_poem,cs_skin_name,cs_stamp_filename,cs_java,cs_poem_align,cs_sender_ip)";
	$cs_date_delete=$end_today_timestamp+86400*$cf_card_expire_day;
	
	
	foreach($list as $item){
		$cs_id = substr(md5(uniqid(rand(),1)), 0, 15);
		$item[cs_message]=mysql_real_escape_string($item[cs_message]);
		$item[book_fname]=mysql_real_escape_string($item[book_fname]);
		$cs_fname=mysql_real_escape_string($item[user_name] . " " . $item[user_last_name]);
		$cs_date_create=adjust_timestamp($item[user_timezone]);
		
		
		$fields_values="('$cs_id','$item[cs_ec_id]','$item[cs_message]',0,$today_mon,$today_mday,$today_year,0,'$item[book_email]','$item[book_fname]','$item[user_email]','$cs_fname',$cs_date_create,$time_stamp_now_server,$time_stamp_now_server,$cs_date_delete,'$item[user_lang]','$item[cs_user_name_id]','$item[cs_music_filename]','$item[cs_poem]','$item[cs_skin_name]','$item[cs_stamp_filename]','$item[cs_java]','$item[cs_poem_align]','$item[cs_sender_ip]')";

		insert_data_to_db("max_ecardsent",$fields_name,$fields_values);
	
		$print_log .= "\t Send Card ID $cs_id to email $item[book_email]\n";	
	}
	
	//--------------------------------------------------------------------------------------------
	//Send later cards
	$print_log .="----------------------------------------------------\n";
	$print_log .="// SEND LATER CARDS\n\n";

	//List all cards have cs_sent = 0 (haven't send emai)
	$list=set_array_from_query("max_ecardsent","*","cs_sent='0'");
	foreach($list as $row){
		$val=$row[cs_id];
		$cs_from_name=$row[cs_from_name];

		if($row[cs_lang] !=""){
			if(file_exists("$ecard_root/languages/$row[cs_lang]")){
				require("languages/$row[cs_lang]");
			}
			else{
				if(file_exists("$ecard_root/languages/$cf_language")){
					require("languages/$cf_language");
				}
				else{
					require("languages/english_lang.php");
				}
			}		
		}
		else{
			if(file_exists("$ecard_root/languages/$cf_language")){
				require("languages/$cf_language");
			}
			else{
				require("languages/english_lang.php");
			}
		}
		$card_date_sent = adjust_timestamp_user($row[cs_date_send],$row[cs_timezone]);
		$end_today_timestamp_sender = adjust_timestamp_user($end_today_timestamp,$row[cs_timezone]);
		if($card_date_sent <= $end_today_timestamp_sender){
			//Send email
			$email_mess = "";
			$email_mess = $send_notify_pickup_email_message;
			$email_mess =str_replace("%show_friend_name%",$row[cs_fname],$email_mess);
			$email_mess =str_replace("%show_from_name%",$row[cs_from_name],$email_mess);
			$email_mess =str_replace("%show_id%",$val,$email_mess);

			$email_subject ="";
			$email_subject =$send_notify_pickup_email_subject;
			if($cf_show_from_email =="0"){//Show sender's name and Sender's email in eMail From field
				send_email(stripslashes($row[cs_from_name]),$row[cs_from_email],$row[cs_fmail],$email_subject,$email_mess,$cf_email_plain_text,$row[cs_from_email]);
			}
			else{
				send_email($cf_site_title,$cf_site_from_email,$row[cs_fmail],$email_subject,$email_mess,1,$row[cs_from_email]);
			}

			//Update cs_sent='1'
			update_field_in_db("max_ecardsent","cs_sent","1","cs_id='$val' LIMIT 1");

			$print_log .= "\t Send Card ID $val to email $row[cs_fmail]\n";
		}
	}	

	//--------------------------------------------------------------------------------------------
	//Send later invitation cards
	if(mysql_num_rows(mysql_query("SHOW TABLES LIKE 'max_ecardsent_invite'"))==1) {
		$print_log .="----------------------------------------------------\n";
		$print_log .="// SEND LATER INVITATION CARDS\n\n";

		//List all cards have cs_sent = 0 (haven't send emai)
		$list=set_array_from_query("max_ecardsent_invite","*","cs_sent='0'");
		foreach($list as $row){
			$val=$row[cs_id];
			$row_user=get_row("max_ecuser","user_name,user_last_name,user_email","user_name_id='$row[cs_user_name_id]'");
			$_SESSION[user_name]=$row_user[user_name];
			$_SESSION[user_last_name]=$row_user[user_last_name];
			require("languages/$cf_language");
			
			$card_date_sent = adjust_timestamp_user($row[cs_date_send],$row_user[user_timezone]);
			$end_today_timestamp_sender = adjust_timestamp_user($end_today_timestamp,$row_user[user_timezone]);
			
			if($card_date_sent <= $end_today_timestamp_sender){
				//Send email
				$email_mess = "";
				$email_mess = $invite_send_pickup_email_message;
				$email_mess =str_replace("%show_friend_name%",$row[cs_fname],$email_mess);
				$email_mess =str_replace("%show_from_name%","$row_user[user_name] $row_user[user_last_name]",$email_mess);
				$email_mess =str_replace("%show_id%",$val,$email_mess);

				$email_subject ="";
				$email_subject =$invite_send_pickup_email_subject;
				if($cf_show_from_email =="0"){//Show sender's name and Sender's email in eMail From field
					send_email(stripslashes("$row_user[user_name] $row_user[user_last_name]"),$row_user[user_email],$row[cs_fmail],$email_subject,$email_mess,$cf_email_plain_text,$row_user[user_email]);
				}
				else{
					send_email($cf_site_title,$cf_site_from_email,$row[cs_fmail],$email_subject,$email_mess,$cf_email_plain_text,$row_user[user_email]);
				}

				//Update cs_sent='1'
				update_field_in_db("max_ecardsent_invite","cs_sent","1","cs_id='$val' LIMIT 1");

				$print_log .= "\t Send Invitaion Card ID $val to email $row[cs_fmail]\n";
			}
		}
	}

	//--------------------------------------------------------------------------------------------
	//Send Invitation Reminder to Guest
	if(mysql_num_rows(mysql_query("SHOW TABLES LIKE 'max_user_invite'"))==1) {
		$print_log .="\n----------------------------------------------------\n";
		$print_log .="// SEND INVITATION REMINDER \n\n";

		$list=set_array_from_query("max_user_invite","*","invite_rm_year > '0' and invite_status <> '$status_check' or invite_rm_year > '0' and invite_status is Null");
		foreach($list as $row){		
			$time_check2=gmmktime(0,0,0,$row[invite_rm_month],$row[invite_rm_day],$row[invite_rm_year]);
			$time_check=$time_check2 - 86400 * $row[invite_rm_datebefore];
			
			//Send email base on time_check
			if($time_check >= $begin_today_timestamp && $time_check <= $end_today_timestamp || $time_check2 >= $begin_today_timestamp && $time_check2 <= $end_today_timestamp){
				//Guest who will not attend - WILL NOT receive reminder
				$list2=set_array_from_query("max_ecardsent_invite","*","cs_invite_id = '$row[invite_id]' and cs_friend_decide <> '1'");
				foreach($list2 as $row2){
					$val=$row2[cs_id];				
					$_SESSION[user_name]=$row[invite_from_name];
					$_SESSION[user_last_name]="";
					require("languages/$cf_language");

					//Send email
					$email_mess = "";
					$email_mess = $invite_reminder_note_subject."$row[invite_rm_month]/$row[invite_rm_day]/$row[invite_rm_year] (MM/DD/YYYY)\n\n".$invite_send_pickup_email_subject;
					$email_mess =str_replace("%show_friend_name%",$row2[cs_fname],$email_mess);
					$email_mess =str_replace("%show_from_name%",$row[invite_from_name],$email_mess);
					$email_mess =str_replace("%show_id%",$val,$email_mess);

					$email_subject ="";
					$email_subject =$invite_reminder_note_subject."$row[invite_rm_month]/$row[invite_rm_day]/$row[invite_rm_year] (MM/DD/YYYY)";
					if($cf_show_from_email =="0"){//Show sender's name and Sender's email in eMail From field
						send_email(stripslashes($row[invite_from_name]),$row[invite_from_email],$row2[cs_fmail],$email_subject,$email_mess,$cf_email_plain_text,$row[invite_from_email]);
					}
					else{
						send_email($cf_site_title,$cf_site_from_email,$row2[cs_fmail],$email_subject,$email_mess,$cf_email_plain_text,$row[invite_from_email]);
					}
					$print_log .= "\t Send Invitation Reminder to email $row2[cs_fmail]\n";
				}
			}
			//Update invite_status
			update_field_in_db("max_user_invite","invite_status",$status_check,"invite_id='$row[invite_id]' LIMIT 1");
		}
	}

	//--------------------------------------------------------------------------------------------
	//Send reminder max_reminder
	$print_log .="\n----------------------------------------------------\n";
	$print_log .="// SEND REMINDER \n\n";

	$list=set_array_from_query("max_reminder","*","rm_status <> '$status_check' or rm_status is Null");
	foreach($list as $row){
		$val=$row[rm_id];
		$row_user =get_row("max_ecuser","*","user_name_id='$row[rm_user_name_id]'");
		$send_to_email = $row_user[user_email];
		if($row_user[user_cellphone_active]=="1" && $row_user[user_cellphone_number]!="" && $row_user[user_cellphone_ca_id]>0){
			$gateway_domain=get_dbvalue("max_cell_carrier","ca_domain","ca_id='$row_user[user_cellphone_ca_id]'");
			$send_to_cell="$row_user[user_cellphone_number]@$gateway_domain";
		}
		else{
			$send_to_cell="";
		}

		if($row_user[user_lang] !=""){
			if(file_exists("$ecard_root/languages/$row_user[user_lang]")){
				require("languages/$row_user[user_lang]");
			}
			else{
				if(file_exists("$ecard_root/languages/$cf_language")){
					require("languages/$cf_language");
				}
				else{
					require("languages/english_lang.php");
				}
			}		
		}
		else{
			if(file_exists("$ecard_root/languages/$cf_language")){
				require("languages/$cf_language");
			}
			else{
				require("languages/english_lang.php");
			}
		}
		
		$time_check = $row[rm_time] - 86400 * $row[rm_datebefore];
		
		$email_msg ="";
		$row[rm_content]=nl2br($row[rm_content]);//str_replace("<br>","\n",$row[rm_content]);
		$email_msg = $reminder_email_message;
		$email_msg =str_replace("%show_reminder_title%","$row[rm_title]",$email_msg);
		$email_msg =str_replace("%show_event_date%","(MM/DD/YYYY) $row[rm_month]/$row[rm_day]/$row[rm_year]",$email_msg);
		$email_msg =str_replace("%show_reminder_content%",$row[rm_content],$email_msg);

		$email_subject ="";
		$email_subject =$reminder_email_subject;
		$email_subject =str_replace("%show_reminder_title%","$row[rm_title]",$email_subject);

		//Send email base on time_check
		if($time_check >= $begin_today_timestamp && $time_check <= $end_today_timestamp){
			send_email($cf_site_title,$cf_site_from_email,$send_to_email,$email_subject,$email_msg,$cf_email_plain_text,$cf_site_from_email);
			if($send_to_cell!="")send_sms($cf_site_title,$cf_site_from_email,$send_to_cell,$email_subject,"(MM/DD/YYYY) $row[rm_month]/$row[rm_day]/$row[rm_year] - $row[rm_content]",$cf_email_plain_text,$cf_site_from_email);
			$print_log .= "\t Send Reminder Title ($row[rm_title]) to email $send_to_email\n";
		}
			
		//Auto Send email on event date
		if($row[rm_datebefore] > 0){
			if($row[rm_time] >= $begin_today_timestamp && $row[rm_time] <= $end_today_timestamp){
				send_email($cf_site_title,$cf_site_from_email,$send_to_email,$email_subject,$email_msg,$cf_email_plain_text,$cf_site_from_email);
				if($send_to_cell!="")send_sms($cf_site_title,$cf_site_from_email,$send_to_cell,$email_subject,"(MM/DD/YYYY) $row[rm_month]/$row[rm_day]/$row[rm_year] - $row[rm_content]",$cf_email_plain_text,$cf_site_from_email);
				$print_log .= "\t Send Reminder Title ($row[rm_title]) to email $send_to_email\n";
			}
		}

		//Send email base on rm_repeat 
		//1 Repeat every week
		if($row[rm_repeat] == "1"){
			//Find wday
			$find_wday =gmdate("w", $row[rm_time]);
			if($find_wday == $wday){
				send_email($cf_site_title,$cf_site_from_email,$send_to_email,$email_subject,$email_msg,$cf_email_plain_text,$cf_site_from_email);
				if($send_to_cell!="")send_sms($cf_site_title,$cf_site_from_email,$send_to_cell,$email_subject,"(MM/DD/YYYY) $row[rm_month]/$row[rm_day]/$row[rm_year] - $row[rm_content]",$cf_email_plain_text,$cf_site_from_email);
				$print_log .= "\t Send Reminder Title ($row[rm_title]) to email $send_to_email\n";
			}
		}

		//2 Repeat every month
		if($row[rm_repeat] == "2" ){
			if($row[rm_day] == $today_mday ){
				send_email($cf_site_title,$cf_site_from_email,$send_to_email,$email_subject,$email_msg,$cf_email_plain_text,$cf_site_from_email);
				if($send_to_cell!="")send_sms($cf_site_title,$cf_site_from_email,$send_to_cell,$email_subject,"(MM/DD/YYYY) $row[rm_month]/$row[rm_day]/$row[rm_year] - $row[rm_content]",$cf_email_plain_text,$cf_site_from_email);
				$print_log .= "\t Send Reminder Title ($row[rm_title]) to email $send_to_email\n";
			}
		}

		//3 Repeat every year 
		if($row[rm_repeat] == "3" && $row[rm_year] != $today_year){
			$time_reminder_set = gmmktime(0,0,0,$row[rm_month],$row[rm_day],$today_year);
			$time_check = $time_reminder_set - 86400 * $row[rm_datebefore];

			//Send email base on time_check
			if($time_check >= $begin_today_timestamp && $time_check <= $end_today_timestamp){
				send_email($cf_site_title,$cf_site_from_email,$send_to_email,$email_subject,$email_msg,$cf_email_plain_text,$cf_site_from_email);
				if($send_to_cell!="")send_sms($cf_site_title,$cf_site_from_email,$send_to_cell,$email_subject,"(MM/DD/YYYY) $row[rm_month]/$row[rm_day]/$row[rm_year] - $row[rm_content]",$cf_email_plain_text,$cf_site_from_email);
				$print_log .= "\t Send Reminder Title ($row[rm_title]) to email $send_to_email\n";
			}
		}
		
		//Update rm_status
		update_field_in_db("max_reminder","rm_status",$status_check,"rm_id='$val' LIMIT 1");
	}

	//--------------------------------------------------------------------------------------------
	$print_log .="\n----------------------------------------------------\n";
	$print_log .="// SEND BIRTHDAY REMINDER \n\n";

	//Send reminder max_addressbook
	$list=set_array_from_query("max_addressbook","*","book_birth_mon > '0' and book_status <> '$status_check' or book_birth_mon > '0' and book_status is Null or book_special_mon > '0' and book_status <> '$status_check' or book_special_mon > '0' and book_status is Null ");
	foreach($list as $row){
		$val=$row[book_id];
		$row_user =get_row("max_ecuser","*","user_name_id='$row[book_user_name_id]'");
		$send_to_email = $row_user[user_email];
		if($row_user[user_cellphone_active]=="1" && $row_user[user_cellphone_number]!="" && $row_user[user_cellphone_ca_id]>0){
			$gateway_domain=get_dbvalue("max_cell_carrier","ca_domain","ca_id='$row_user[user_cellphone_ca_id]'");
			$send_to_cell="$row_user[user_cellphone_number]@$gateway_domain";
		}
		else{
			$send_to_cell="";
		}

		if($row_user[user_lang] !=""){
			if(file_exists("$ecard_root/languages/$row_user[user_lang]")){
				require("languages/$row_user[user_lang]");
			}
			else{
				if(file_exists("$ecard_root/languages/$cf_language")){
					require("languages/$cf_language");
				}
				else{
					require("languages/english_lang.php");
				}
			}		
		}
		else{
			if(file_exists("$ecard_root/languages/$cf_language")){
				require("languages/$cf_language");
			}
			else{
				require("languages/english_lang.php");
			}
		}
		
		//Send BIRTHDAY reminder
		$time_set = gmmktime(0,0,0,$row[book_birth_mon],$row[book_birth_mday],$today_year);
		$time_reminder_set_txt =DateFormat($time_set,"1");
		$time_check = $time_set - 86400 * $row[book_datebefore];

		$email_msg ="";
		$email_msg = $reminder_email_message;
		$email_msg =str_replace("%show_reminder_title%","$row[book_fname] $row[book_lname] $addressbook_txt_reminder_birthday",$email_msg);
		$email_msg =str_replace("%show_event_date%",$time_reminder_set_txt,$email_msg);
		$email_msg =str_replace("%show_reminder_content%","",$email_msg);
		
		$email_subject ="";
		$email_subject =$reminder_email_subject;
		$email_subject =str_replace("%show_reminder_title%","$time_reminder_set_txt - $row[book_fname] $row[book_lname] $addressbook_txt_reminder_birthday",$email_subject);

		//Send email base on time_check
		if($time_check >= $begin_today_timestamp && $time_check <= $end_today_timestamp){
			send_email($cf_site_title,$cf_site_from_email,$send_to_email,$email_subject,$email_msg,$cf_email_plain_text,$cf_site_from_email);
			if($send_to_cell!="")send_sms($cf_site_title,$cf_site_from_email,$send_to_cell,$email_subject,"",$cf_email_plain_text,$cf_site_from_email);
			$print_log .= "\t Send Reminder Birthday Title ($row[book_birthday_title]) to email $send_to_email\n";
		}

		//Auto Send email on event date
		if($row[book_datebefore] > 0){
			if($time_set >= $begin_today_timestamp && $time_set <= $end_today_timestamp){
				send_email($cf_site_title,$cf_site_from_email,$send_to_email,$email_subject,$email_msg);
				if($send_to_cell!="")send_sms($cf_site_title,$cf_site_from_email,$send_to_cell,$email_subject,"",$cf_email_plain_text,$cf_site_from_email);
				$print_log .= "\t Send Reminder Birthday Title ($row[book_birthday_title]) to email $send_to_email\n";
			}
		}

		//Send SPECIAL DAY reminder
		$time_set = gmmktime(0,0,0,$row[book_special_mon],$row[book_special_mday],$today_year);
		$time_reminder_set_txt =DateFormat($time_set,"1");
		$time_check = $time_set - 86400 * $row[book_datebefore];

		$email_msg ="";
		$email_msg = $reminder_email_message;
		$email_msg =str_replace("%show_reminder_title%","$row[book_fname] $row[book_lname] $addressbook_txt_reminder_anni",$email_msg);
		$email_msg =str_replace("%show_event_date%",$time_reminder_set_txt,$email_msg);
		$email_msg =str_replace("%show_reminder_content%","",$email_msg);
		
		$email_subject ="";
		$email_subject =$reminder_email_subject;
		$email_subject =str_replace("%show_reminder_title%","$time_reminder_set_txt - $row[book_fname] $row[book_lname] $addressbook_txt_reminder_anni",$email_subject);

		//Send email base on time_check
		if($time_check >= $begin_today_timestamp && $time_check <= $end_today_timestamp){
			send_email($cf_site_title,$cf_site_from_email,$send_to_email,$email_subject,$email_msg);
			if($send_to_cell!="")send_sms($cf_site_title,$cf_site_from_email,$send_to_cell,$email_subject,"",$cf_email_plain_text,$cf_site_from_email);
			$print_log .= "\t Send Reminder Special Day Title ($row[book_special_day_title]) to email $send_to_email\n";
		}

		//Auto Send email on event date
		if($row[book_datebefore] > 0){
			if($time_set >= $begin_today_timestamp && $time_set <= $end_today_timestamp){
				send_email($cf_site_title,$cf_site_from_email,$send_to_email,$email_subject,$email_msg);
				if($send_to_cell!="")send_sms($cf_site_title,$cf_site_from_email,$send_to_cell,$email_subject,"",$cf_email_plain_text,$cf_site_from_email);
				$print_log .= "\t Send Reminder Special Day Title ($row[book_special_day_title]) to email $send_to_email\n";
			}
		}
		//Update book_status
		update_field_in_db("max_addressbook","book_status",$status_check,"book_id='$val' LIMIT 1");
	}	

	//--------------------------------------------------------------------------------------------
	$print_log .="\n----------------------------------------------------\n";
	$print_log .="// AUTO SEND BIRTHDAY CARD TO MEMBERS \n\n";

	//Send auto birthday card to member
	//This feature will be skipped if Admin don't set Birthday Category
	$birthday_cat_id = get_dbvalue("max_config","config_value","config_name='cf_birthday_cat_id'") ;
	if($birthday_cat_id !=""){
		$list=set_array_from_query("max_ecuser","*","user_birth_mon > '0' and user_birth_mday > '0' and user_status<>'$status_check' or user_birth_mon > '0' and user_birth_mday > '0' and user_status is Null");
		$row="";
		foreach($list as $row){
			$val=$row[user_id];
			$send_to_email = $row[user_email];
			$cs_from_name = $cf_site_title;

			if($row[user_lang] !=""){
				if(file_exists("$ecard_root/languages/$row[user_lang]")){
					require("languages/$row[user_lang]");
				}
				else{
					if(file_exists("$ecard_root/languages/$cf_language")){
						require("languages/$cf_language");
					}
					else{
						require("languages/english_lang.php");
					}
				}		
			}
			else{
				if(file_exists("$ecard_root/languages/$cf_language")){
					require("languages/$cf_language");
				}
				else{
					require("languages/english_lang.php");
				}
			}			

			$time_reminder_set = gmmktime(0,0,0,$row[user_birth_mon],$row[user_birth_mday],$today_year);

			//Send email on event date
			if($time_reminder_set >= $begin_today_timestamp && $time_reminder_set <= $end_today_timestamp){				
				//Random get a card
				$cat_dir_id =get_dbvalue("max_category","cat_dir_id","cat_id='$birthday_cat_id'");
				$cs_ec_id=get_dbvalue("max_ecard","ec_id","ec_cat_relate_id like '%$cat_dir_id%' Order by RAND() LIMIT 1");
				$cs_id = substr(md5(uniqid(rand(),1)), 0, 15);
				$cs_message = $text_auto_send_birthday_mess_to_member;
				$cs_sent = 1;
				$cs_send_month =$today_mon ;
				$cs_send_mday =$today_mday ;
				$cs_send_year =$today_year ;
				$cs_fmail =$row[user_email];
				$cs_fname ="$row[user_name] $row[user_last_name]";
				$cs_from_email = $cf_site_from_email;				
				$cs_date_create = $time_reminder_set;
				$cs_date_create_server_time= $time_reminder_set;
				$cs_date_send =$time_reminder_set;
				$cs_date_delete = $time_reminder_set + 86400 * $cf_card_expire_day;
				$cs_lang = $row[user_lang];
				$cs_timezone = $row[user_timezone];

				//Insert cs_id to database
				$field_name ="(cs_id,cs_ec_id,cs_message,cs_sent,cs_send_month,cs_send_mday,cs_send_year,cs_fmail,cs_fname,cs_from_email,cs_from_name,cs_date_create,cs_date_create_server_time,cs_date_send,cs_date_delete,cs_lang,cs_timezone)";
				$field_value ="('$cs_id','$cs_ec_id','$cs_message','$cs_sent','$cs_send_month','$cs_send_mday','$cs_send_year','$cs_fmail','$cs_fname','$cs_from_email','$cs_from_name','$cs_date_create','$cs_date_create_server_time','$cs_date_send','$cs_date_delete','$cs_lang','$cs_timezone')";
				insert_data_to_db("max_ecardsent",$field_name,$field_value);					
				
				$email_subject ="";
				$email_subject =$send_notify_pickup_email_subject;
				$email_subject =str_replace("%show_name%",$cf_site_title,$email_subject);

				$email_mess = "";
				$email_mess = $send_notify_pickup_email_message;
				$email_mess =str_replace("%show_friend_name%","$row[user_name] $row[user_last_name]",$email_mess);
				$email_mess =str_replace("%show_from_name%",$cf_site_title,$email_mess);
				$email_mess =str_replace("%show_id%",$cs_id,$email_mess);
				send_email($cf_site_title,$cf_site_from_email,$send_to_email,$email_subject,$email_mess,$cf_email_plain_text,$cf_site_from_email);	
				$print_log .= "\t AUTO Send Birthday Card (Card ID $cs_id) to Member Username $row[user_name_id] ($send_to_email)\n";
			}

			//Update user_status
			update_field_in_db("max_ecuser","user_status",$status_check,"user_id='$val' LIMIT 1");
		}
	}
	//Downgrade to free account when expire
/*	$print_log .="\n----------------------------------------------------\n";
	$print_log .="// DOWNGRADE TO FREE ACCOUNT WHEN ACCOUNT EXPIRE \n\n";
	
	$list=set_array_from_query("max_ecuser","*","user_dateclose<$end_today_timestamp and user_mg_id>2");
	foreach($list as $row){
		$print_log .= " $row[user_name_id] - $row[user_email] \n";
		
		$free1 = trim($row[user_member1]);
		$free2 = trim($row[user_member2]);
		
		if($free1 !=""){
			update_field_in_db("max_ecuser","user_mg_id",2,"user_name_id='$free1'");
		}
		
		if($free1 !=""){
			update_field_in_db("max_ecuser","user_mg_id",2,"user_name_id='$free2'");
		}
		
	}

	
	//Delete Sub Account first (base on user_member1 & user_member2
		
		

	update_field_in_db("max_ecuser","user_mg_id",2,"user_dateclose<$end_today_timestamp and user_mg_id>2");
	
		
	$print_log .="\n----------------------------------------------------\n";
	
	*/
	//--------------------------------------------------------------------------------------------
	
	$print_log .="\n----------------------------------------------------\n";
	$print_log .="// AUTO DELETE OLD CARDS \n\n";

	//Delete old card max_ecardsent
	$list=set_array_from_query("max_ecardsent","*","cs_sent='1' and cs_date_delete <= '$end_today_timestamp'");
	foreach($list as $row){
		delete_row("max_ecardsent","cs_id='$row[cs_id]' LIMIT 1");
		$print_log .= "\t Delete expiration Card (Card ID $row[cs_id]) \n";
	}


	//--------------------------------------------------------------------------------------------
	$print_log .="\n----------------------------------------------------\n";
	$print_log .="// AUTO DELETE ACCOUNT \n\n";

	//Delete user (user_beclosed=2)
	$list=set_array_from_query("max_ecuser","*","user_beclosed = '2' and user_dateclose <= '$end_today_timestamp'");
	foreach($list as $row){
		detele_account($row);
		$print_log .= "\t Delete expiration Account (Account ID $row[user_id] - $row[user_name_id]) \n";
	}

	//--------------------------------------------------------------------------------------------
	$print_log .="\n----------------------------------------------------\n";
	$print_log .="// AUTO DELETE GRABBER CARDS \n\n";

	//Delete grabber card max_ecard
	$list=set_array_from_query("max_ecard","*","ec_user_name_id='?' and ec_time <= '$end_today_timestamp'");
	foreach($list as $row){
		$val=$row[ec_id];
		if(file_exists("$ecard_root/resource/picture/user_picture/$row[ec_thumbnail]") && $row[ec_thumbnail] !="")
			@unlink("$ecard_root/resource/picture/user_picture/$row[ec_thumbnail]");

		if((strpos($row[ec_filename],"GRABBER")===false) && file_exists("$ecard_root/resource/picture/user_picture/$row[ec_filename]") && $row[ec_filename] !="")
			@unlink("$ecard_root/resource/picture/user_picture/$row[ec_filename]");

		delete_row("max_ecard","ec_id='$val' LIMIT 1");
		$print_log .= "\t Delete expiration Grabber card (Card ID $val) \n";
	}	

	//Send report to webmaster
	$time_cron_today = DateFormat($time_stamp_now_admin) ."\n";	
	print "<pre>$print_log</pre>";

	$print_log = nl2br($print_log);
	send_email($cf_site_title,$cf_webmaster_email,$cf_webmaster_email,"Cron Job on date $time_cron_today",$print_log,$cf_email_plain_text,$cf_webmaster_email);
	
	//------------------------------------------------------------------
	function detele_account($row) {
		$user_id=trim($row[user_id]);
		$user=trim($row[user_name_id]);

		//Delete Sub Account first (base on user_member1 & user_member2
		$free1 = trim($row[user_member1]);
		$free2 = trim($row[user_member2]);

		//Remove user from table max_mail_list 
		if($free1 !=""){
			$free1_email=get_dbvalue("max_ecuser","user_email","user_name_id='$free1'");
			$list = get_dblistvalue("max_mail_list","list_id","list_email='$free1_email' and list_mgroup_id='-1' or list_email='$free1_email' and list_mgroup_id='-2' ");
			foreach($list as $val){
				delete_row("max_mail_list","list_id='$val' LIMIT 1");
			}
		}

		//Remove user from table max_mail_list 
		if($free2 !=""){
			$free1_email=get_dbvalue("max_ecuser","user_email","user_name_id='$free2'");
			$list = get_dblistvalue("max_mail_list","list_id","list_email='$free1_email' and list_mgroup_id='-1' or list_email='$free1_email' and list_mgroup_id='-2' ");
			foreach($list as $val){
				delete_row("max_mail_list","list_id='$val' LIMIT 1");
			}
		}

		//Remove user from table max_addressbook
		if($free1 !=""){
			$list = get_dblistvalue("max_addressbook","book_id","book_user_name_id='$free1'");
			foreach($list as $val){
				delete_row("max_addressbook","book_id='$val' LIMIT 1");
			}
		}
		//Remove user from table max_addressbook
		if($free2 !=""){
			$list = get_dblistvalue("max_addressbook","book_id","book_user_name_id='$free2'");
			foreach($list as $val){
				delete_row("max_addressbook","book_id='$val' LIMIT 1");
			}
		}
		//Remove user from table max_addressbook
		$list = get_dblistvalue("max_addressbook","book_id","book_user_name_id='$user' ");
		foreach($list as $val){
			delete_row("max_addressbook","book_id='$val' LIMIT 1");
		}

		//Remove user from table max_ecard
		if($free1 !=""){
			$list = get_dblistvalue("max_ecard","ec_id","ec_user_name_id='$free1' ");
			foreach($list as $val){
				delete_row("max_ecard","ec_id='$val' LIMIT 1");
			}
		}
		//Remove user from table max_ecard
		if($free2 !=""){
			$list = get_dblistvalue("max_ecard","ec_id","ec_user_name_id='$free2' ");
			foreach($list as $val){
				delete_row("max_ecard","ec_id='$val' LIMIT 1");
			}
		}
		//Remove user from table max_ecard
		$list = get_dblistvalue("max_ecard","ec_id","ec_user_name_id='$user' ");
		foreach($list as $val){
			delete_row("max_ecard","ec_id='$val' LIMIT 1");
		}

		//Remove user from table max_ecardsent
		if($free1 !=""){
			$list = get_dblistvalue("max_ecardsent","cs_id","cs_user_name_id='$free1'");
			foreach($list as $val){
				delete_row("max_ecardsent","cs_id='$val' LIMIT 1");
			}
		}
		//Remove user from table max_ecardsent
		if($free2 !=""){
			$list = get_dblistvalue("max_ecardsent","cs_id","cs_user_name_id='$free2'");
			foreach($list as $val){
				delete_row("max_ecardsent","cs_id='$val' LIMIT 1");
			}
		}
		//Remove user from table max_ecardsent
		$list = get_dblistvalue("max_ecardsent","cs_id","cs_user_name_id='$user' ");
		foreach($list as $val){
			delete_row("max_ecardsent","cs_id='$val' LIMIT 1");
		}

		//max_ecuser
		//Main acct + 2 Sub acct
		delete_row("max_ecuser","user_id='$user_id' LIMIT 1");
		if($free1 !="")
			delete_row("max_ecuser","user_name_id='$free1' LIMIT 1");
		if($free2 !="")
			delete_row("max_ecuser","user_name_id='$free2' LIMIT 1");

		//Remove user from table max_favorite
		if($free1 !=""){
			$list = get_dblistvalue("max_favorite","fv_id","fv_user_name_id='$free1'");
			foreach($list as $val){
				delete_row("max_favorite","fv_id='$val' LIMIT 1");
			}
		}
		if($free2 !=""){
			$list = get_dblistvalue("max_favorite","fv_id","fv_user_name_id='$free2'");
			foreach($list as $val){
				delete_row("max_favorite","fv_id='$val' LIMIT 1");
			}
		}
		$list = get_dblistvalue("max_favorite","fv_id","fv_user_name_id='$user'");
		foreach($list as $val){
			delete_row("max_favorite","fv_id='$val' LIMIT 1");
		}

		//Remove user from table max_music 
		if($free1 !=""){
			$list = get_dblistvalue("max_music","music_id","music_user_name_id='$free1'");
			foreach($list as $val){
				delete_row("max_music","music_id='$val' LIMIT 1");
			}
		}
		//Remove user from table max_music 
		if($free2 !=""){
			$list = get_dblistvalue("max_music","music_id","music_user_name_id='$free2'");
			foreach($list as $val){
				delete_row("max_music","music_id='$val' LIMIT 1");
			}
		}
		//Remove user from table max_music 
		$list = get_dblistvalue("max_music","music_id","music_user_name_id='$user' ");
		foreach($list as $val){
			delete_row("max_music","music_id='$val' LIMIT 1");
		}

		//Remove user from table max_poem
		if($free1 !=""){
			$list = get_dblistvalue("max_poem","poem_id","poem_user_name_id='$free1'");
			foreach($list as $val){
				delete_row("max_poem","poem_id='$val' LIMIT 1");
			}
		}
		//Remove user from table max_poem
		if($free2 !=""){
			$list = get_dblistvalue("max_poem","poem_id","poem_user_name_id='$free2'");
			foreach($list as $val){
				delete_row("max_poem","poem_id='$val' LIMIT 1");
			}
		}
		//Remove user from table max_poem
		$list = get_dblistvalue("max_poem","poem_id","poem_user_name_id='$user' ");
		foreach($list as $val){
			delete_row("max_poem","poem_id='$val' LIMIT 1");
		}
					
		//Remove user from table max_reminder
		if($free1 !=""){
			$list = get_dblistvalue("max_reminder","rm_id","rm_user_name_id='$free1'");
			foreach($list as $val){
				delete_row("max_reminder","rm_id='$val' LIMIT 1");
			}
		}
		//Remove user from table max_reminder
		if($free2 !=""){
			$list = get_dblistvalue("max_reminder","rm_id","rm_user_name_id='$free2'");
			foreach($list as $val){
				delete_row("max_reminder","rm_id='$val' LIMIT 1");
			}
		}
		//Remove user from table max_reminder
		$list = get_dblistvalue("max_reminder","rm_id","rm_user_name_id='$user' ");
		foreach($list as $val){
			delete_row("max_reminder","rm_id='$val' LIMIT 1");
		}
		//Remove user from table max_mail_list
		$list = get_dblistvalue("max_mail_list","list_id","list_email='$row[user_email]' and list_mgroup_id='-1' or list_email='$row[user_email]' and list_mgroup_id='-2' ");
		foreach($list as $val){
			delete_row("max_mail_list","list_id='$val' LIMIT 1");
		}				
	}
?>
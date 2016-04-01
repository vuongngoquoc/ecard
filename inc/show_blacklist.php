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
	if(ECARDMAX_USER!=1)exit;
	
	if($what=="add"){
		$row_blacklist =get_row("max_black_list","*","black_email='$add_black_email'");			
		if($row_blacklist[black_active] == "1"){
			$show_info1="<div class=\"Error_Message\">$blacklist_error_message_email_exist</div>";
		}
		else{
			$black_key = substr(md5(uniqid(rand(),1)), 0, 20);
			if($row_blacklist[black_active] == ""){//new email ==> insert to database
				insert_data_to_db("max_black_list","(black_email,black_key,black_active,black_date)","('$add_black_email','$black_key',0,$gmt_timestamp_now)");
			}
			else{//already added but never click action link ==> update key
				update_field_in_db("max_black_list","black_key",$black_key,"black_email='$add_black_email' LIMIT 1");
			}

			//Send action link to $add_black_email - User must click the link to active his email on the black list
			$show_link ="$ecard_url/index.php?step=blacklist&what=add2&email=$add_black_email&code=$black_key&";
			$email_msg=str_replace("%show_link%",$show_link,$blacklist_email_message);
			send_email($cf_site_title,$cf_webmaster_email,$add_black_email,$blacklist_email_subject,$email_msg,$cf_email_plain_text,$cf_webmaster_email);
			$show_info1="<div class=\"OK_Message\">$blacklist_error_message_gocheck_email</div>"; 
		}
	}
	elseif($what=="add2"){
		$chk=get_dbvalue("max_black_list","black_email","black_email='$email' and black_key='$code' ");
		if($chk!=""){
			update_field_in_db("max_black_list","black_active","1","black_email='$email' and black_key='$code' LIMIT 1");
			$show_info1="<div class=\"OK_Message\">$blacklist_message_add_ok</div>"; 
		}
		else{
			$show_info1="<div class=\"Error_Message\">$blacklist_error_message_remove_email_notonList</div>";
		}
	}
	elseif($what=="remove"){
		$row_blacklist =get_row("max_black_list","*","black_email='$remove_black_email'");
		//User did not click action link ==> then go ahead remove their email without their confirm
		if($row_blacklist[black_active] == 0){
			delete_row("max_black_list","black_email='$remove_black_email' LIMIT 1");
			$show_info2="<div class=\"OK_Message\">$blacklist_message_remove_ok</div>";
		}
		else{
			//Send email to user, user must click the action link to remove their email			
			//Create unique id - 
			$black_key = substr(md5(uniqid(rand(),1)), 0, 20);
			$show_link ="$ecard_url/index.php?step=blacklist&what=remove2&email=$remove_black_email&code=$row_blacklist[black_key]&";
			$email_msg=str_replace("%show_link%",$show_link,$blacklist_email_remove_fromlist_message);	send_email($cf_site_title,$cf_webmaster_email,$remove_black_email,$blacklist_email_remove_fromlist_subject,$email_msg,$cf_email_plain_text,$cf_webmaster_email);
			$show_info2="<div class=\"OK_Message\">$blacklist_error_message_remove_gocheck_email</div>";
		}
	}
	elseif($what=="remove2"){
		$chk=get_dbvalue("max_black_list","black_email","black_email='$email' and black_key='$code' ");
		if($chk!=""){
			delete_row("max_black_list","black_email='$email' and black_key='$code' LIMIT 1");
			$show_info2="<div class=\"OK_Message\">$blacklist_message_remove_ok</div>"; 
		}
		else{
			$show_info2="<div class=\"Error_Message\">$blacklist_error_message_remove_email_notonList</div>";
		}
	}
	$display_thumbnail=get_html_from_layout("templates/$cf_set_template/show_blacklist.html");
	
?>
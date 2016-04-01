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
	if(ECARDMAX!=1)exit;
	if ($admin_login != $crypt_pass){
		//Show login page
		print get_html_from_layout("admin/html/show_login.html");
		exit;
	}

	if($what=="sending2"){
		$row=get_row("max_mail_message","*","mmess_id='$mmess_id'");
		$row[mmess_subject]=str_replace("&quot;","\"",$row[mmess_subject]);
		$row[mmess_body] =str_replace("&quot;","\"",$row[mmess_body]);

		if($mgroup_id =="-1"){
			set_global_var("mgroup_name","<font class=Error_Message>$email_tool_sending_message_newsletter_list</font>");
		}
		elseif($mgroup_id =="-2"){
			set_global_var("mgroup_name","<font class=Error_Message>$email_tool_sending_message_special_offers_list</font>");
		}
		else{			
			set_global_var("mgroup_name","<span style=\"color:green;font-weight:bold\">" .get_dbvalue("max_mail_group","mgroup_name","mgroup_id='$mgroup_id'") ."</span>");
		}

		set_global_var("mmess_subject","<span style=\"color:green;font-weight:bold\">$row[mmess_subject]</span>");
		set_global_var("body","<iframe style=\"border:1px solid silver;\" frameborder=0 width=100% height=300 src=index.php?step=$step&what=display_email_body&mmess_id=$mmess_id scrolling=auto></iframe>");
		set_global_var("webmaster_email","<strong>" . $cf_webmaster_email . "</strong>");
		$email_tool_sending_txt_view_email=str_replace("%step%","$step",$email_tool_sending_txt_view_email);
		$email_tool_sending_txt_view_email=str_replace("%mmess_id%","$mmess_id",$email_tool_sending_txt_view_email);
		set_global_var("print_object",get_html_from_layout("admin/html/show_preview_before_send.html"));	
		print_admin_header_footer_page();
		exit;
	}
	elseif($what=="send_now"){
		if($send_test =="1"){//Send test email
			if($mgroup_id =="-1" || $mgroup_id =="-2"){
				$from_name = $cf_site_title;
				$from_email = $cf_webmaster_email;
			}
			else{
				$row=get_row("max_mail_group","*","mgroup_id='$mgroup_id'");
				$from_name = $row[mgroup_from_name];
				$from_email = $row[mgroup_from_email];
			}
			$row_mess =get_row("max_mail_message","*","mmess_id='$mmess_id'");
			$row_mess[mmess_subject]=str_replace("&quot;","\"",$row_mess[mmess_subject]);
			$row[mmess_body]=str_replace("&quot;","\"",$row[mmess_body]);
			$email_tool_sending_email_body=str_replace("%message_body_text%",$row_mess[mmess_body_text],$email_tool_sending_email_body);
			$email_tool_sending_email_body=str_replace("%remove_email_link%","$ecard_url/index.php?step=newsletter&list_email_un=$cf_webmaster_email",$email_tool_sending_email_body);
			$email_tool_sending_email_body=str_replace("%message_body%",$row_mess[mmess_body],$email_tool_sending_email_body);		
			send_email($from_name,$from_email,$cf_webmaster_email,$row_mess[mmess_subject],$email_tool_sending_email_body,$cf_email_plain_text,$from_email);//$cf_email_plain_text
			$email_tool_sending_print_note=str_replace("%message_subject%",$row_mess[mmess_subject],$email_tool_sending_print_note);
			$email_tool_sending_print_note=str_replace("%cf_webmaster_email%",$cf_webmaster_email,$email_tool_sending_print_note);
			$print_note =$email_tool_sending_print_note;
		}

		//Create list_status
		$list_status= substr(md5(uniqid(rand(),1)), 0, 7);

		set_global_var("print_object","$print_note<br /><br /><form method=\"post\" action=\"\"><strong>$email_tool_sending_txt_note:</strong> $email_tool_sending_txt_turn_off_pop_notify<br /><br /><input class=\"button\" type=\"button\" value=\"$email_tool_sending_button_send_mass_mail\" onclick=\"window.open('index.php?step=$step&what=send_now2&mgroup_id=$mgroup_id&mmess_id=$mmess_id&list_status=$list_status&email_per_batch=$email_per_batch', 'popup', 'height=300,width=300,status=no,toolbar=no,menubar=no,location=no,scrollbars=yes');location.href='index.php?step=$step';\" /> </form>");
		print_admin_header_footer_page();
		exit;
	}
	elseif($what=="send_now2"){
		$total_email=get_dbvalue("max_mail_list","count(list_id)","list_mgroup_id ='$mgroup_id' and list_email<>'' ");	
print<<<HTML_CODE
<html>
<head>
<meta http-equiv="Content-Language" content="en-us" />
<meta http-equiv="pragma" content="no-cache" />
<meta http-equiv="EXPIRES" content="-1" />
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252" />
<meta http-equiv="imagetoolbar" content="no" />
<title>$email_tool_sending_txt_send_mass_mail_page_title</title>
<style type="text/css">
<!--
@import url(html/07_style.css);
-->
</style>
<script type="text/javascript"> 
	var sending_url="index.php?step=$step&what=ajax_sending&list_status=$list_status&mgroup_id=$mgroup_id&mmess_id=$mmess_id&email_per_batch=$email_per_batch";
</script>
<script type="text/javascript" src="ecardmax_admin.js"> </script>
</head>
<body onload="SendingEmail(sending_url);setTimeout('count_time()',1000);">
<p id="sending_email"><strong>$email_tool_sending_txt_sending_mail</strong></p>
<p><strong>$email_tool_sending_txt_time_elapsed</strong> <span id="HR" class="OK_Message"></span>:<span id="MIN" class="OK_Message"></span>:<span id="SEC"></span></p>
<p><strong>$email_tool_sending_txt_total_email: <font color="green">$total_email</font></strong></p>
<p><strong>$email_tool_sending_txt_remaining: <span id="remain"><font color="red">$email_remain</font></span></strong></p>
<p><strong>$email_tool_sending_txt_status: <span id="status"><font color="red">$email_tool_sending_txt_status_do_not_close_windows</font></span></strong></p><hr class="HR_Color" />
<span id="list_email"></span>
</body>
</html>
HTML_CODE;
						
			exit;
	}
	elseif($what=="ajax_sending"){
		if($mgroup_id =="-1" || $mgroup_id =="-2"){
			$from_name = $cf_site_title;
			$from_email = $cf_webmaster_email;
		}
		else{
			$row=get_row("max_mail_group","*","mgroup_id='$mgroup_id'");
			$from_name = $row[mgroup_from_name];
			$from_email = $row[mgroup_from_email];
		}
		$row_mess =get_row("max_mail_message","*","mmess_id='$mmess_id'");
		$row_mess[mmess_subject]=str_replace("&quot;","\"",$row_mess[mmess_subject]);
		$row[mmess_body]=str_replace("&quot;","\"",$row[mmess_body]);
		$print_remove_email_link_text ="\n\n-----------------------------------------------------------\nClick the link below to remove your email from our email list\n$ecard_url/index.php?step=newsletter&list_email_un=%USER_EMAIL%";
		$print_remove_email_link_html ="<br /><br /><hr />Click the link below to remove your email from our email list<br /><a href=$ecard_url/index.php?step=newsletter&list_email_un=%USER_EMAIL%>$ecard_url/index.php?step=newsletter&list_email_un=%USER_EMAIL%</a>";					

		//Send default 50 emails at a time
		if($email_per_batch=="" || $email_per_batch<=0)$email_per_batch=50;
		$list=get_dblistvalue("max_mail_list","list_email","list_mgroup_id ='$mgroup_id' and (list_status<>'$list_status' or list_status is Null) LIMIT 0,$email_per_batch ");

		$sent_item="";
		if(count($list) > 0){
			foreach($list as $val){
				$chk_black_list=get_dbvalue("max_black_list","black_active","black_email='$val'");
				if($chk_black_list=="" || $chk_black_list=="0"){
					$link_remove_text = $print_remove_email_link_text;
					$link_remove_text =str_replace("%USER_EMAIL%",$val,$link_remove_text);
					$link_remove_html = $print_remove_email_link_html;
					$link_remove_html =str_replace("%USER_EMAIL%",$val,$link_remove_html);
					send_email($from_name,$from_email,$val,$row_mess[mmess_subject],"<!-- $row_mess[mmess_body_text]$link_remove_text -->".$row_mess[mmess_body] . $link_remove_html,$cf_email_plain_text,$from_email);
					update_field_in_db("max_mail_list","list_status",$list_status,"list_mgroup_id ='$mgroup_id' and list_email='$val' LIMIT 1");
				}
			}
			$remain=get_dbvalue("max_mail_list","count(list_id)","list_mgroup_id ='$mgroup_id' and list_status<>'$list_status' ");
			print "$remain,$sent_item";
			exit;
		}
		else{
			print "0,$sent_item";
			exit;
		}
	}
	elseif($what=="delete_selected"){
		foreach($http_vars as $key=>$val){
			if(!(strpos($key,"mylist_id")===false)){ //if true
				$selected_id =str_replace("mylist_id","",$key);
				//Delete row in database
				delete_row("max_mail_message","mmess_id='$selected_id' LIMIT 1");
			}
		}
	}
	elseif($what=="display_email_body"){
		$row=get_row("max_mail_message","*","mmess_id='$mmess_id'");
		$row[mmess_body_text] =strip_tags($row[mmess_body]);		
		$row[mmess_body]=str_replace("&quot;","\"",$row[mmess_body]);
		print "<html><head><meta http-equiv=Content-Type content=text/html; charset=$charset></head><body style=\"background-color:white\">$row[mmess_body]</body></html>";
		exit;
	}
	
	$list_data =set_array_from_query("max_mail_group","*","mgroup_id<>'' Order by mgroup_name,mgroup_from_name,mgroup_from_email");
	$show_mgroup_name_newsletter ="$email_tool_sending_txt_group_title: <span class=\"OK_Message\">$email_tool_sending_message_newsletter_list</span><br />$email_tool_sending_txt_from_name: <strong>$cf_site_title</strong><br />$email_tool_sending_txt_from_email: <strong>$cf_webmaster_email</strong>";
	$show_mgroup_name_special_offer ="$email_tool_sending_txt_group_title: <span class=\"OK_Message\">$email_tool_sending_message_special_offers_list</span><br />$email_tool_sending_txt_from_name: <strong>$cf_site_title</strong><br />$email_tool_sending_txt_from_email: <strong>$cf_webmaster_email</strong>";
	
	//Count total email in this group
	$total_email_this_group_newsletter =get_dbvalue("max_mail_list","count(list_id)","list_mgroup_id='-1'");
	$total_email_this_group_special_offer =get_dbvalue("max_mail_list","count(list_id)","list_mgroup_id='-2'");

	$show_list_table_recipient_group ="<tr style=\"background-color: white;line-height:20px\">\n";
	$show_list_table_recipient_group .="<td width=\"1%\" align=\"center\" style=\"padding:7px;\"><img border=\"0\" src=\"html/07_icon_mailgroup_unchange.gif\" alt=\"\" /></td>\n";
	$show_list_table_recipient_group .="<td width=\"*\" style=\"padding:4px;white-space:nowrap\">$show_mgroup_name_newsletter</td>\n";
	$show_list_table_recipient_group .="<td width=\"1%\" align=\"center\">$total_email_this_group_newsletter</td>\n";
	$show_list_table_recipient_group .="<td width=\"1%\" align=\"center\" style=\"padding:7px;\"><input onclick=\"get_mgroup_id='-1';\" type=\"radio\" name=\"mgroup_id\" value=\"-1\"/></td>\n";
	$show_list_table_recipient_group .="</tr>\n";

	$show_list_table_recipient_group .="<tr style=\"background-color: white;line-height:20px\">\n";
	$show_list_table_recipient_group .="<td width=\"1%\" align=\"center\" style=\"padding:7px;\"><img border=\"0\" src=\"html/07_icon_mailgroup_unchange.gif\" alt=\"\" /></td>\n";
	$show_list_table_recipient_group .="<td width=\"*\" style=\"padding:4px;white-space:nowrap\">$show_mgroup_name_special_offer</td>\n";
	$show_list_table_recipient_group .="<td width=\"1%\" align=\"center\">$total_email_this_group_special_offer</td>\n";
	$show_list_table_recipient_group .="<td width=\"1%\" align=\"center\" style=\"padding:7px;\"><input onclick=\"get_mgroup_id='-2';\" type=\"radio\" name=\"mgroup_id\" value=\"-2\"/></td>\n";
	$show_list_table_recipient_group .="</tr>\n";

	foreach($list_data as $array){
		//Show group name
		$show_mgroup_name="Group Title: <span class=\"OK_Message\">$array[mgroup_name]</span><br />$email_tool_sending_txt_from_name: <strong>$array[mgroup_from_name]</strong><br />$email_tool_sending_txt_from_email: <strong>$array[mgroup_from_email]</strong>";
		
		//Count total email
		$total_email=get_dbvalue("max_mail_list","count(list_id)","list_mgroup_id='$array[mgroup_id]'");

		$show_list_table_recipient_group .="<tr style=\"background-color: #EAEAEA;line-height:20px\">\n";
		$show_list_table_recipient_group .="<td width=\"1%\" align=\"center\" style=\"padding:7px;\"><img border=\"0\" src=\"html/07_icon_mailgroup.gif\" alt=\"\" /></td>\n";
		$show_list_table_recipient_group .="<td width=\"*\" style=\"padding:4px;white-space:nowrap\">$show_mgroup_name</td>\n";
		$show_list_table_recipient_group .="<td width=\"1%\" align=\"center\">$total_email</td>\n";
		$show_list_table_recipient_group .="<td width=\"1%\" align=\"center\" style=\"padding:7px;\"><input onclick=\"get_mgroup_id='$array[mgroup_id]';\" type=\"radio\" name=\"mgroup_id\" value=\"$array[mgroup_id]\"/></td>\n";
		$show_list_table_recipient_group .="</tr>\n";
	}
	set_global_var("show_list_table_recipient_group",$show_list_table_recipient_group);

	$list_data =set_array_from_query("max_mail_message","*","mmess_id<>'' Order by mmess_id DESC,mmess_subject");
	foreach($list_data as $array){	
		//Show preview email icon
		$show_preview_icon ="<a href=\"index.php?step=admin_emailtool_create_message&what=display_email_body&mmess_id=$array[mmess_id]\" target=_blank><img border=\"0\" src=\"html/07_icon_view_email16.gif\" alt=\"$email_tool_sending_tooltip_preview_message\" title=\"$email_tool_sending_tooltip_preview_message\" /></a>";	

		$show_list_table_message .="<tr style=\"background-color: #EAEAEA;line-height:20px\">\n";
		$show_list_table_message .="<td width=\"1%\" align=\"center\" style=\"padding:7px;\"><img border=\"0\" src=\"html/07_icon_new_message.gif\" alt=\"\" /></td>\n";
		$show_list_table_message .="<td width=\"*\" style=\"padding:4px;white-space:nowrap\">$email_tool_sending_txt_email_subject: <strong>$array[mmess_subject]</strong></td>\n";
		$show_list_table_message .="<td width=\"1%\" align=\"center\">$show_preview_icon</td>\n";
		$show_list_table_message .="<td width=\"1%\" align=\"center\" style=\"padding:7px;\"><input onclick=\"get_mmess_id='$array[mmess_id]';\" type=\"radio\" name=\"mmess_id\" value=\"$array[mmess_id]\"/></td>\n";
		$show_list_table_message .="</tr>\n";
	}
	set_global_var("show_list_table_message",$show_list_table_message);	

	set_global_var("count_total",$count_list);		
	set_global_var("print_object",get_html_from_layout("admin/html/admin_emailtool_sending.html"));	
	print_admin_header_footer_page();		

?>
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
	
	if($what=="send_feedback"){
		//Check sender email to see if it's inside ban list
		$ban_row=get_row("max_ban_user","*","ban_what='$fm_user_email'");
		if ($ban_row[ban_id]!=""){
			if($ban_row[ban_time_end]>0 && $ban_row[ban_time_end] > $begin_today_timestamp){
				$array_global_var[print_object]="<br /><br /><div style=\"text-align:center\">$txt_ban_error_message<br /><br />$ban_row[ban_reason]</div>";
				print_header_and_footer();
				exit;
			}
		}

		//Save user feedback to database
		$field_name ="(fm_feedback_id,fm_subject,fm_message,fm_user_name,fm_user_email,fm_time_sent,fm_ip)";
		$field_value ="($fm_feedback_id,'$fm_subject','$fm_message','$fm_user_name','$fm_user_email',$gmt_timestamp_now,'$remote_addr')";
		insert_data_to_db("max_feedback_message",$field_name,$field_value);

		//Send email here
		$to_email=get_dbvalue("max_feedback","feedback_email","feedback_id='$fm_feedback_id'");
		send_email($fm_user_name,$fm_user_email,$to_email,$fm_subject,$fm_message,$cf_email_plain_text,$fm_user_email);

		$show_info="<span class=\"OK_Message\">$feedback_show_info_message_has_been_sent</span>";
	}
	$list_department=set_array_from_query("max_feedback","*");
	if($isResponsive)
	{
		$show_department="<select class='form-control input-sm' onkeypress=\"return noEnterKey(event)\" name=\"fm_feedback_id\" id=\"fm_feedback_id\" >";
	}
	else
	$show_department="<select onkeypress=\"return noEnterKey(event)\" name=\"fm_feedback_id\" id=\"fm_feedback_id\" style=\"width:50%\">";
	foreach($list_department as $array_data){
		$show_department.="<option value=\"$array_data[feedback_id]\">$array_data[feedback_topic]</option>\n";
	}
	$show_department.="</select>";
	$display_thumbnail= get_html_from_layout("templates/$cf_set_template/show_feedback.html");
?>
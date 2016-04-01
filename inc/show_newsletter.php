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
	
	if($what=="subscribe" || $what=="subscribe2"){
		$chk_email=get_dbvalue("max_mail_list","list_id","list_email='$list_email' and list_mgroup_id='-1'");
		if($chk_email==""){
			//Add email to list.
			$field_name ="(list_mgroup_id,list_email,list_name,list_ip,list_time)";
			$field_value ="(-1,'$list_email','$list_name','$remote_addr',$gmt_timestamp_now)";
			insert_data_to_db("max_mail_list",$field_name,$field_value);				
		}
		$show_info1="<span class=\"OK_Message\">$newsletter_show_info_email_has_been_added</span>";
	}
	elseif($what=="unsubscribe" || $what=="unsubscribe2"){
		//UnSubscribe
		$array_email=set_array_from_query("max_mail_list","list_id","list_email='$list_email_un'");
		if($array_email[0][list_id]!=""){
			foreach($array_email as $arr){
				delete_row("max_mail_list","list_id='$arr[list_id]' LIMIT 1");
			}
			$show_info2="<span class=\"OK_Message\">$newsletter_show_info_email_has_been_deleted</span>";
		}
		else{
			$show_info2="<span class=\"Error_Message\">$newsletter_show_info_email_not_found</span>";
		}
	}
	$display_thumbnail=get_html_from_layout("templates/$cf_set_template/show_newsletter.html");
?>
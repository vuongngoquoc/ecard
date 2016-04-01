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
	
	//Check requirement
	if($cs_from_name!="" && valid_email($cs_from_email) && $cs_message!=""){
		//This cookie is used to check cards user has been sent (prevent spammer)
		setcookie("cookie_cs_from_email",$cs_from_email,time()+(86400*30));
		setcookie("cookie_cs_from_name",$cs_from_name,time()+(86400*30));

		$cs_send_month=$today_mon;
		$cs_send_mday=$today_mday;
		$cs_send_year=$today_year;
		$cs_date_send=time();
		$cs_date_delete=$cs_date_send+(86400*$cf_card_expire_day);
		$cs_lang=$_SESSION[ecardmax_lang];
		$gmt_timestamp_server=adjust_timestamp($cf_timezone);
		$cs_sent=1;
		if($cs_notify=="")$cs_notify=0; 
		$field_name ="(cs_id,cs_ec_id,cs_message,cs_sent,cs_send_month,cs_send_mday,cs_send_year,cs_notify,cs_fmail,cs_fname,cs_from_email,cs_from_name,cs_date_create,cs_date_create_server_time,cs_date_send,cs_date_delete,cs_lang,cs_user_name_id,cs_music_id,cs_music_filename,cs_poem,cs_skin_name,cs_stamp_filename,cs_java,cs_poem_align,cs_sender_ip,cs_pkdate,cs_type,cs_content)";
		$cs_id = substr(md5(uniqid(rand(),1)), 0, 15);
		$chk_num_card=1;
		// THIS LINE TO FIX THE BUG OCCURR WHEN INSERTING CLIPART, IMAGE IN FIREFOX AND IE BROWSER
		$cs_message=str_replace("../../../","$ecard_url/",$cs_message);
		// THIS LINE TO FIX THE BUG OCCURR WHEN INSERTING CLIPART, IMAGE IN FIREFOX AND IE BROWSER
		$field_value ="('$cs_id','$ec_id','$cs_message',$cs_sent,$cs_send_month,$cs_send_mday,$cs_send_year,$cs_notify,'','','$cs_from_email','$cs_from_name',$gmt_timestamp_now,$gmt_timestamp_now,$cs_date_send,$cs_date_delete,'$cs_lang','$_SESSION[user_name_id]','$cs_music_id','$cs_music_filename','$cs_poem','$cs_skin_name','$cs_stamp_filename','$cs_java','$cs_poem_align','$remote_addr',0,'$cs_type','$cs_content'),";
		
		if($field_value{strlen($field_value)-1} ==",") $field_value = substr($field_value, 0, strlen($field_value)-1);
		insert_data_to_db("max_ecardsent",$field_name,$field_value);
		
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

		echo("$ecard_url/index.php?step=pickup&cs_id=$cs_id");
		exit;
	}
?>
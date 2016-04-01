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
	
	if($what=="add_new"){
				$upload_dir ="$ecard_root/resource/invitation_fonts/user_font";
		$number_file = 0;

			$file_key="file_name_test";
			$rand_id = "user".$_SESSION[user_id].substr(md5(uniqid(rand(),1)), 0, 8);
			
			$file_name = $POST_FILES[$file_key]['name'];
			$font_filename=str_replace(".ttf","",$POST_FILES[$file_key]['name']);
			$file_upload_size = $POST_FILES[$file_key]['size'];
			if($file_upload_size > 0){
				$count_user_font++;
				$ext="";
				$show_info="";
				$file_name =strtolower($file_name);
				if(substr($file_name, strlen($file_name)-4, strlen($file_name))==".ttf")$ext =".ttf";
				$file_upload_name = "$ecard_root/resource/invitation_fonts/user_font/$rand_id$file_name";
				
				if($ext!=".ttf")
					$show_info .="<div class=\"Error_Message\">$myalbum_font_error_msg_font_Type</div><br />\n";

				$count_user_font=get_dbvalue("max_user_font","count(font_id)","font_user_name_id='$_SESSION[user_name_id]'");

				if($cf_user_max_font_upload > 0 && $count_user_font>= $cf_user_max_font_upload)
					$show_info .="<div class=\"Error_Message\">$myalbum_font_error_msg_overlimit_upload_font</div><br />\n";

				if($show_info==""){					
					//Upload and Add files to database
					if(move_uploaded_file($POST_FILES[$file_key]['tmp_name'],$file_upload_name)){
						$number_file++;
						chmod($file_upload_name,0777);						

						$field_name ="(font_name,font_filename,font_user_name_id)";
						$field_value ="('$font_filename','$rand_id$file_name','$_SESSION[user_name_id]')";
						insert_data_to_db("max_user_font",$field_name,$field_value);		
					}
				}
			}

		//Validate new account
		if($user_first_name=="")$show_info="<div class=\"Error_Message\" style=\"padding:4px\">$show_join_now_alert_must_enter_first_name</div><br />";
		if($user_last_name=="")$show_info.="<div class=\"Error_Message\">$show_join_now_alert_must_enter_last_name</div><br />";
		if(!valid_email($user_email))$show_info.="<div class=\"Error_Message\">$show_join_now_alert_must_enter_valid_email</div><br />";
		if(get_dbvalue("max_ecuser","user_id","user_email='$user_email'") !=""){
			$show_info.="<div class=\"Error_Message\">$myaccount_show_info_user_email_taken $user_email</div><br />";
		}
		if($user_name_id=="")$show_info.="<div class=\"Error_Message\">$show_join_now_alert_must_enter_user_name_id</div><br />";
		if(strlen($user_name_id) < 6){
			$show_info.="<div class=\"Error_Message\">$myaccount_show_info_user_name_id_too_short</div><br />";
		}
		if(is_numeric($user_name_id{0})){
			$show_info.="<div class=\"Error_Message\">$myaccount_show_info_user_name_id_no_number_first_letter</div><br />";
		}
		if(preg_match("/\W/si",$user_name_id)){
			$show_info.="<div class=\"Error_Message\">$myaccount_show_info_user_name_id_no_special_character</div><br />";
		}
		if(get_dbvalue("max_ecuser","user_name_id","user_name_id='$user_name_id'") !=""){
			$show_info.="<div class=\"Error_Message\">$myaccount_show_info_user_name_id_taken</div><br />";
		}
		elseif (get_dbvalue("max_ban_user","ban_what","ban_what='$user_email'") !="") {
			$show_info.="<div class=\"Error_Message\">$myaccount_show_info_user_has_been_banned</div><br />";
		}
		if($user_password=="")$show_info.="<div class=\"Error_Message\">$show_join_now_alert_must_enter_password</div><br />";
		if($user_password!=$user_password2) $show_info.="<div class=\"Error_Message\">$show_join_now_alert_must_re_enter_password</div><br />";
		
		if($cf_show_image_verify_code=="1"){
			if($verify_image_code!=$_SESSION[random_code]){
				$show_info.="<div class=\"Error_Message\">$show_join_now_alert_must_enter_correct_image_code</div><br />";
				set_global_var("verify_image_code","");
			}
			else{
				$random_image_code=1;
			}
		}

		if($show_info==""){
			//Add new user to database
			if($user_receive_newsletter!=1)$user_receive_newsletter=0;
			if($user_receive_offer!=1)$user_receive_offer=0;

			//Add user email to mailing list
			if($user_receive_newsletter=="1"){
				$chk_email =get_dbvalue("max_mail_list","list_id","list_email='$user_email' and list_mgroup_id ='-1'");
				if($chk_email =="")insert_data_to_db("max_mail_list","(list_mgroup_id,list_email,list_name,list_ip,list_country,list_time)","(-1,'$user_email','$user_first_name $user_last_name','$remote_addr','$user_country',$gmt_timestamp_now)");
			}
			if($user_receive_offer=="1"){
				$chk_email =get_dbvalue("max_mail_list","list_id","list_email='$user_email' and list_mgroup_id ='-2'");
				if($chk_email =="")insert_data_to_db("max_mail_list","(list_mgroup_id,list_email,list_name,list_ip,list_country,list_time)","(-2,'$user_email','$user_first_name $user_last_name','$remote_addr','$user_country',$gmt_timestamp_now)");
			}
			
			//User birthday
			if($cf_show_date_option =="0"){ //MM DD YYYY
				list($user_birth_mon,$user_birth_mday,$user_birth_year)=split("\/",$time_end_textbox);
			}
			elseif($cf_show_date_option =="1"){ //DD MM YYYY
				list($user_birth_mday,$user_birth_mon,$user_birth_year)=split("\/",$time_end_textbox);
			}
			elseif($cf_show_date_option =="2"){ //YYYY DD MM
				list($user_birth_year,$user_birth_mday,$user_birth_mon)=split("\/",$time_end_textbox);
			}
			elseif($cf_show_date_option =="3"){ //YYYY MM DD
				list($user_birth_year,$user_birth_mon,$user_birth_mday)=split("\/",$time_end_textbox);
			}			
			if($user_birth_mon=="")$user_birth_mon=0;
			if($user_birth_mday=="")$user_birth_mday=0;
			if($user_birth_year=="")$user_birth_year=0;
			if($user_cellphone_active=="")$user_cellphone_active=0;
			if($user_cellphone_ca_id=="")$user_cellphone_ca_id=0;
			
			if ($cf_new_account_email_verification) { // Generate active code here
				$user_active = "0";
				$active_code = substr(md5(uniqid(rand(),1)), 0, 5);
				$active_code=strtoupper($active_code);
				//Remove zero(0) and letter O so ppl won't confuse
				$active_code=str_replace("0","1",$active_code);
				$active_code=str_replace("O","A",$active_code);
			}
			else {
				$user_active = "1";
				$active_code = "";
			}
$user_password_md5=md5($user_password);
			$field_name ="(user_cellphone_active,user_cellphone_ca_id,user_cellphone_number,user_member1,user_member2,user_timeused,user_mg_id,user_name_id,user_password,user_lang,user_name,user_last_name,user_phone,user_address,user_state,user_zip,user_city,user_country,user_email,user_timezone,user_beclosed,user_dateclose,user_birth_mon,user_birth_mday,user_birth_year,user_date_signup,user_active,user_active_code,user_gender,user_marital,user_receive_newsletter,user_receive_offer,user_lastlogin,user_lastlogin2,user_agent,user_ip,user_dst)";
			$field_value ="($user_cellphone_active,$user_cellphone_ca_id,'$user_cellphone_number','','',1,'2','$user_name_id','$user_password_md5','$user_lang','$user_first_name','$user_last_name','$user_phone','$user_address','$user_state','$user_zip','$user_city','$user_country','$user_email',$user_timezone,0,0,$user_birth_mon,$user_birth_mday,$user_birth_year,$gmt_timestamp_now,'$user_active','$active_code',$user_gender,$user_marital,$user_receive_newsletter,$user_receive_offer,$gmt_timestamp_now,$gmt_timestamp_now,'$user_agent','$remote_addr',$user_dst)";
			insert_data_to_db("max_ecuser",$field_name,$field_value);

			if ($cf_new_account_email_verification) {
				// do send activation link here
				$account_verification_email=$myaccount_account_verification_email;
				$account_verification_email=str_replace("%SITE_TITLE%",$cf_site_title,$account_verification_email);
				$account_verification_email=str_replace("%USER_EMAIL%",$user_email,$account_verification_email);
				$account_verification_email=str_replace("%USER_IP%",$remote_addr,$account_verification_email);
				$account_verification_email=str_replace("%ACCOUNT_VERIFICATION_URL%","$ecard_url/index.php?step=verify_account&code=$active_code&user_name_id=$user_name_id",$account_verification_email);				
				send_email($cf_from_name,$cf_site_from_email,$user_email,$myaccount_account_verification_email_subject,$account_verification_email,$cf_email_plain_text,$cf_site_from_email);
				
				$account_verification_email_message=str_replace("%USER_EMAIL%",$user_email,$myaccount_account_verification_email_message);
			}
			else { // Set auto login here
				//Auto login
				$row_data=get_row("max_ecuser","*","user_name_id='$user_name_id'");
				$_SESSION[ecardmax_user]=$row_data[user_name_id];
				foreach($row_data as $key=>$val){
					$_SESSION[$key]=$val;
				}

				//Set member group
				$mg_row=get_row("max_member_group","*","mg_id='$row_data[user_mg_id]'");
				foreach($mg_row as $key=>$val){
					$_SESSION[$key]=$val;
				}

				//Set language
				$_SESSION[ecardmax_lang]=$row_data[user_lang];

				//Say hello user
				$_SESSION[hello_user]="$txt_welcome_back_user $row_data[user_name] $row_data[user_last_name]";

				//Send email welcome
				send_email($cf_site_title,$cf_webmaster_email,$user_email,$sign_up_email_subject_welcome,$sign_up_email_message_welcome,$cf_email_plain_text,$cf_webmaster_email);

				//Go to homepage or my account
				
				if ($user_membership=="") $user_membership='2';
				
				
				if($_SESSION[iv_id]!=""){
					print"<script language='javascript'>location.href='$ecard_url/index.php?step=sendcard_invite&iv_id=$_SESSION[iv_id]&rand='+ new Date().getTime();</script>";
				}
				elseif($_SESSION[ec_id]!=""){
					print"<script language='javascript'>location.href='$ecard_url/index.php?step=sendcard&ec_id=$_SESSION[ec_id]&rand='+ new Date().getTime();</script>";
				}
				else{
					
					print"<script language='javascript'>location.href='https://www.paypal.com/cgi-bin/webscr?cmd=_xclick-subscriptions&business=webmaster@ecardmax.com&item_name=Upgrade+Account+To+Membership+$0.01&no_shipping=1&return=http://namasteegreetings.com/paypal_thankyou.php&no_note=1¤cy_code=USD&lc=US&bn=PP-SubscriptionsBF&charset=UTF-8&a1=0.00&p1=7&t1=D&a3=0.01&p3=1&t3=Y&src=1&sra=1&item_number=UpgradeAccount&invoice=$_SESSION[ecqid]&custom=$user_name_id,4';</script>"; 
					//print"<script language='javascript'>location.href='$ecard_url/index.php?step=sign_in&next_step=show_myaccount';</script>";						
				}
				exit;
			}
		}
	}

	if ($cf_new_account_email_verification && $what=="add_new" && $account_verification_email_message) {
		$display_thumbnail="<div class=\"table_border\"><b><font color=\"red\">$account_verification_email_message</font></b><meta http-equiv=\"refresh\" content=\"5;URL=$ecard_url\"></div>";
	}
	else {
		//Show primary language box
		$list_lang_file=get_list_file("$ecard_root/languages","_lang.php$");
		if($isResponsive)
		$show_lang_select="<select size=\"1\" name=\"user_lang\" id=\"user_lang\" class='form-control input-sm'>";
		else
		$show_lang_select="<select size=\"1\" name=\"user_lang\" id=\"user_lang\" style=\"width:200px\">";
		foreach($list_lang_file as $val){
			$lang_name=ucwords(str_replace("_lang.php","",$val));
			if($val==$cf_language){
				$show_lang_select .="<option selected=\"selected\" value=\"$val\">$lang_name</option>";
			}
			else{
				$show_lang_select .="<option value=\"$val\">$lang_name</option>";
			}
		}
		$show_lang_select.="</select>";

		//Show state box
		$listme=get_file_content("$ecard_root/templates/state_data.txt");
		$array=split("\n",$listme);
		if($isResponsive)
		$show_state_box="<select size=\"1\" name=\"user_state\" id=\"user_state\" class='form-control input-sm' >\n<option value=\"$user_state\">$txt_dropdown_select</option>\n";
		
		else
		$show_state_box="<select size=\"1\" name=\"user_state\" id=\"user_state\" style=\"width:200px\">\n<option value=\"$user_state\">$txt_dropdown_select</option>\n";
		foreach($array as $val){
			$val=trim($val);
			if($val!=""){
				$info=split("\|",$val);
				if($info[0]==$user_state){
					$show_state_box.="<option selected=\"selected\" value=\"$info[0]\">$info[1]</option>";
				}
				else{
					$show_state_box.="<option value=\"$info[0]\">$info[1]</option>";
				}
			}
		}
		$show_state_box.="</select>";

		//Show country
		$listme=get_file_content("$ecard_root/templates/country_data.txt");
		$array=split("\n",$listme);
		$show_country_box="<select class='form-control input-sm' size=\"1\" name=\"user_country\" id=\"user_country\">\n";
		foreach($array as $val){
			$val=trim($val);
			if($val!=""){
				$val_title=str_replace("_"," ",$val);
				if($val==$user_country){
					$show_country_box.="<option selected=\"selected\" value=\"$val\">$val_title</option>";
				}
				else{
					$show_country_box.="<option value=\"$val\">$val_title</option>";
				}
			}
		}
		$show_country_box.="</select>";

		//Verify image code
		if($cf_show_image_verify_code=="1"){
			if($random_image_code != 1){
				$rand_code = substr(md5(uniqid(rand(),1)), 0, 5);
				$rand_code=strtoupper($rand_code);
				//Remove zero(0) and letter O so ppl won't confuse
				$rand_code=str_replace("0","1",$rand_code);
				$rand_code=str_replace("O","A",$rand_code);
				$_SESSION['random_code']=$rand_code;
			}
			$show_image_code="<img border=\"0\" alt=\"\" src=\"$ecard_url/index.php?step=verify_image_code\" class=\"thumbnail_image\"/>";
		}
		else{
			$hide_image_code="style=\"display:none\"";
		}
		

		//User timezone
		if($user_timezone=="")$user_timezone="0";

		//Check checkbox newsletter & offer
		set_global_var("checked_user_receive_newsletter_".$user_receive_newsletter,"checked=\"checked\"");
		set_global_var("checked_user_receive_offer_".$user_receive_offer,"checked=\"checked\"");

		//set selected a drop down
		set_global_var("selected_user_dst_".$user_dst,"selected=\"selected\"");
		set_global_var("selected_user_gender_".$user_gender,"selected=\"selected\"");
		set_global_var("selected_user_marital_".$user_marital,"selected=\"selected\"");

		//Show cell phone carrier 
		$show_cell_phone_carrier="<select class='form-control input-sm' size=\"1\" name=\"user_cellphone_ca_id\" id=\"user_cellphone_ca_id\">";
		$list_carrier=set_array_from_query("max_cell_carrier","*","ca_active='1' Order by ca_name");
		foreach($list_carrier as $row_ca){
			if($user_cellphone_ca_id==$row_ca[ca_id]){
				$show_cell_phone_carrier.="<option selected=\"selected\" value=\"$row_ca[ca_id]\">$row_ca[ca_name]</option>";
			}
			else{
				$show_cell_phone_carrier.="<option value=\"$row_ca[ca_id]\">$row_ca[ca_name]</option>";
			}
		}
		$show_cell_phone_carrier.="</select>";

		//Show date
		if($cf_show_date_option =="0"){ //MM DD YYYY
			$ins_date_caption="(MM/DD/YYYY)";
		}
		elseif($cf_show_date_option =="1"){ //DD MM YYYY
			$ins_date_caption="(DD/MM/YYYY)";
		}
		elseif($cf_show_date_option =="2"){ //YYYY DD MM
			$ins_date_caption="(YYYY/DD/MM)";
		}
		elseif($cf_show_date_option =="3"){ //YYYY MM DD
			$ins_date_caption="(YYYY/MM/DD)";
		}

		$display_thumbnail=get_html_from_layout("templates/$cf_set_template/show_join_now.html");
	}
?>
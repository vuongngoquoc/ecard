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

	if($action=="change_pass"){
		if($_SESSION[user_password]!=md5($current_password)){
			$show_info="<div class=\"Error_Message\">$myaccount_user_new_pass_error1</div><br />";
		}
		elseif($new_password==""){
			$show_info="<div class=\"Error_Message\">$myaccount_user_new_pass_error2</div><br />";
		}
		elseif($new_password!=$new_password2){
			$show_info="<div class=\"Error_Message\">$myaccount_user_new_pass_error3</div><br />";
		}
		else{
			$show_info="<div class=\"OK_Message\">$myaccount_user_new_pass_updated</div><br />";
			update_field_in_db("max_ecuser","user_password",md5($new_password),"user_id='$_SESSION[user_id]' LIMIT 1");
			$_SESSION[user_password]=md5($new_password);
			if($_COOKIE[set_remember_me]!=""){
				setcookie("set_remember_me_crypt_pass",crypt(md5($new_password),"ec"), $gmt_timestamp_now+31104000); //setcookie for 1 year
			}
		}		
	}
	elseif($action=="delete_account"){
		//Delete account
		if($_SESSION[mg_id]=="2"){
			//Registered group -> go ahead delete acct			
			//Find Free Family account 
									
			detele_account($_SESSION[user_id]);
			
			//Logout
			header("Location: $ecard_url/index.php?step=sign_out\n");
			exit;
		}
		elseif($_SESSION[mg_id]!="1" && $_SESSION[mg_id]!="2" ){
			//Special group -> Send request cancel acct to admin
			update_field_in_db("max_ecuser","user_request_cancel","1","user_id='$_SESSION[user_id]' LIMIT 1");
			$_SESSION[user_request_cancel]=1;
		}
	}
	if($action=="update_birthday"){
		if($cf_show_date_option =="0"){ //MM DD YYYY
			list($get_mon,$get_day,$get_year)=split("\/",$time_end_textbox);
		}
		elseif($cf_show_date_option =="1"){ //DD MM YYYY
			list($get_day,$get_mon,$get_year)=split("\/",$time_end_textbox);
		}
		elseif($cf_show_date_option =="2"){ //YYYY DD MM
			list($get_year,$get_day,$get_mon)=split("\/",$time_end_textbox);
		}
		elseif($cf_show_date_option =="3"){ //YYYY MM DD
			list($get_year,$get_mon,$get_day)=split("\/",$time_end_textbox);
		}
		
		update_field_in_db2("max_ecuser","user_birth_mon='$get_mon',user_birth_mday='$get_day',user_birth_year='$get_year'", "user_id='$_SESSION[user_id]'");
		//Update $_SESSION
		$_SESSION[user_birth_mon]=$get_mon;
		$_SESSION[user_birth_mday]=$get_day;
		$_SESSION[user_birth_year]=$get_year;
		exit;
	}
	if($action=="update_table"){
		update_field_in_db("max_ecuser","$update_key","$value","user_id='$_SESSION[user_id]' LIMIT 1");
		$_SESSION[$update_key]=$value;
		if($update_key=="user_lang"){
			$_SESSION[ecardmax_lang]=$value;
		}
		elseif($update_key=="user_receive_newsletter"){
			if($value=="1"){
				$chk_email =get_dbvalue("max_mail_list","list_id","list_email='$_SESSION[user_email]' and list_mgroup_id ='-1'");
				if($chk_email =="")insert_data_to_db("max_mail_list","(list_mgroup_id,list_email,list_name,list_ip,list_country,list_time)","(-1,'$_SESSION[user_email]','$_SESSION[user_name] $_SESSION[user_last_name]','$remote_addr','$_SESSION[user_country]',$gmt_timestamp_now)");
			}
			else{
				delete_row("max_mail_list","list_email='$_SESSION[user_email]' and list_mgroup_id ='-1' LIMIT 1");
			}
		}
		elseif($update_key=="user_receive_offer"){
			if($value=="1"){
				$chk_email =get_dbvalue("max_mail_list","list_id","list_email='$_SESSION[user_email]' and list_mgroup_id ='-2'");
				if($chk_email =="")insert_data_to_db("max_mail_list","(list_mgroup_id,list_email,list_name,list_ip,list_country,list_time)","(-2,'$_SESSION[user_email]','$_SESSION[user_name] $_SESSION[user_last_name]','$remote_addr','$_SESSION[user_country]',$gmt_timestamp_now)");
			}
			else{
				delete_row("max_mail_list","list_email='$_SESSION[user_email]' and list_mgroup_id ='-2' LIMIT 1");
			}
		}
		elseif($update_key=="user_name" || $update_key=="user_last_name"){
			$_SESSION[hello_user]="$txt_welcome_back_user $_SESSION[user_name] $_SESSION[user_last_name]";
		}
		elseif($update_key=="ec_oauth_token") {
			if ($value=="") {
				unset($_SESSION['ec_oauth_token']);
				unset($_SESSION['twitter_screen_name']);
			}
		}
		elseif($update_key=="ec_oauth_secret") {
			if ($value=="") {
				unset($_SESSION['ec_oauth_secret']);
				unset($_SESSION['twitter_screen_name']);
			}
		}
		exit;
	}
	elseif($action=="validate_user_email"){
		//Check valid email address
		if(!valid_email($value)){
			print "<br />$myaccount_user_edit_email_error_msg_invalid $value";
			exit;
		}
		//Check if email has been used
		$chk_email=get_dbvalue("max_ecuser","user_id","user_email='$value'");
		if($chk_email!=""){
			print "<br />$myaccount_user_edit_email_error_msg_taken $value";
			exit;
		}
		
		//Update new email 
		update_field_in_db("max_ecuser","user_email",$value,"user_id='$_SESSION[user_id]' LIMIT 1");

		//Update database max_reminder - column rm_email
		$list = get_dblistvalue("max_reminder","rm_id","rm_user_name_id='$_SESSION[user_id]'");
		foreach($list as $rm_id){
			update_field_in_db("max_reminder","rm_email",$value,"rm_id='$rm_id' LIMIT 1");
		}

		//Update database max_mail_list - column list_email
		update_field_in_db("max_mail_list","list_email",$value,"list_email='$_SESSION[user_email]' and list_mgroup_id='-1' LIMIT 1");
		update_field_in_db("max_mail_list","list_email",$value,"list_email='$_SESSION[user_email]' and list_mgroup_id='-2' LIMIT 1");

		//Update $_SESSION[user_email]
		$_SESSION[user_email]=$value;
		exit;
	}	
	elseif($action=="add_new_subaccount"){
		if($_SESSION[user_member1]!="0" && $_SESSION[user_member2]!="0"){
			//Create sub acct here
			//Validate new account
			if(!valid_email($sub_user_email)){
				$show_info.="<div class=\"Error_Message\">$myaccount_show_info_user_email_invalid $sub_user_email</div><br />";
			}
			if(get_dbvalue("max_ecuser","user_id","user_email='$sub_user_email'") !=""){
				$show_info.="<div class=\"Error_Message\">$myaccount_show_info_user_email_taken $sub_user_email</div><br />";
			}
			if(strlen($sub_user_name_id) < 6){
				$show_info.="<div class=\"Error_Message\">$myaccount_show_info_user_name_id_too_short $sub_user_name_id</div><br />";
			}
			if(is_numeric($sub_user_name_id{0})){
				$show_info.="<div class=\"Error_Message\">$myaccount_show_info_user_name_id_no_number_first_letter $sub_user_name_id</div><br />";
			}
			if(preg_match("/\W/si",$sub_user_name_id)){
				$show_info.="<div class=\"Error_Message\">$myaccount_show_info_user_name_id_no_special_character $sub_user_name_id</div><br />";
			}
			if(get_dbvalue("max_ecuser","user_name_id","user_name_id='$sub_user_name_id'") !=""){
				$show_info.="<div class=\"Error_Message\">$myaccount_show_info_user_name_id_taken $sub_user_name_id</div><br />";
			}
			
			if($show_info==""){
				//Create new account
				
				//Random password
				$sub_user_password=substr(md5(uniqid(rand(),1)), 0, 8);

				//Update main account
				if($_SESSION[user_member1]==""){				
					$field_name ="(user_request_cancel,user_receive_newsletter,user_receive_offer,user_dst,user_dateclose,user_beclosed,user_member2,user_member1,user_lang,user_mg_id,user_name_id,user_password,user_name,user_last_name,user_email,user_timezone,user_date_signup)";
					$field_value ="($_SESSION[user_request_cancel],0,0,$_SESSION[user_dst],$_SESSION[user_dateclose],$_SESSION[user_beclosed],'0','0','$_SESSION[user_lang]',$_SESSION[user_mg_id],'$sub_user_name_id','$sub_user_password','$sub_user_name','$sub_user_last_name','$sub_user_email',$_SESSION[user_timezone],$gmt_timestamp_now)";
					insert_data_to_db("max_ecuser",$field_name,$field_value);

					update_field_in_db("max_ecuser","user_member1",$sub_user_name_id,"user_name_id='$_SESSION[user_name_id]' LIMIT 1");
					$_SESSION[user_member1]=$sub_user_name_id;
				}
				elseif($_SESSION[user_member2]==""){
					$field_name ="(user_request_cancel,user_receive_newsletter,user_receive_offer,user_dst,user_dateclose,user_beclosed,user_member2,user_member1,user_lang,user_mg_id,user_name_id,user_password,user_name,user_last_name,user_email,user_timezone,user_date_signup)";
					$field_value ="($_SESSION[user_request_cancel],0,0,$_SESSION[user_dst],$_SESSION[user_dateclose],$_SESSION[user_beclosed],'0','0','$_SESSION[user_lang]',$_SESSION[user_mg_id],'$sub_user_name_id','$sub_user_password','$sub_user_name','$sub_user_last_name','$sub_user_email',$_SESSION[user_timezone],$gmt_timestamp_now)";
					insert_data_to_db("max_ecuser",$field_name,$field_value);

					update_field_in_db("max_ecuser","user_member2",$sub_user_name_id,"user_name_id='$_SESSION[user_name_id]' LIMIT 1");
					$_SESSION[user_member2]=$sub_user_name_id;
				}		

				//Send acct info to user
				$myaccount_freesub_email_subject=str_replace("%sender_name%","$_SESSION[user_name] $_SESSION[user_last_name]",$myaccount_freesub_email_subject);
				$myaccount_freesub_email_message=str_replace("%sender_name%","$_SESSION[user_name] $_SESSION[user_last_name]",$myaccount_freesub_email_message);
				$myaccount_freesub_email_message=str_replace("%show_user_name_id%",$sub_user_name_id,$myaccount_freesub_email_message);
				$myaccount_freesub_email_message=str_replace("%show_password%",$sub_user_password,$myaccount_freesub_email_message);
				send_email("$_SESSION[user_name] $_SESSION[user_last_name]",$_SESSION[user_email],$sub_user_email,$myaccount_freesub_email_subject,$myaccount_freesub_email_message,$cf_email_plain_text,$_SESSION[user_email]);
			}
		}
	}
	elseif($action=="delete_subaccount"){
		if($sub_number=="1"){
			$free_id =get_dbvalue("max_ecuser","user_id","user_name_id='$_SESSION[user_member1]'");
			detele_account($free_id);
			update_field_in_db("max_ecuser","user_member1","","user_name_id='$_SESSION[user_name_id]' LIMIT 1");
			$_SESSION[user_member1]="";
		}
		if($sub_number=="2"){
			$free_id =get_dbvalue("max_ecuser","user_id","user_name_id='$_SESSION[user_member2]'");
			detele_account($free_id);
			update_field_in_db("max_ecuser","user_member2","","user_name_id='$_SESSION[user_name_id]' LIMIT 1");
			$_SESSION[user_member2]="";
		}
	}
	elseif($action=="upgrade_account"){
		//Check order number
		$row_order_number=get_row("max_payment","*","pay_status='0' and pay_order_number='$order_number'");
		if($row_order_number[pay_id]!=""){//-->update acct
			$mg_row=get_row("max_member_group","*","mg_payment_amount='$row_order_number[pay_amount]' and mg_id='$row_order_number[pay_mg_id]'");			
			if($mg_row[mg_id]!=""){
				if($mg_row[mg_dateclose]=="1"){
					$time_input = $gmt_timestamp_now + (86400*30);//1 mon
					$set_user_beclosed=3;
				}
				elseif($mg_row[mg_dateclose]=="2"){
					$time_input = $gmt_timestamp_now + (86400*30*3);//3 mon
					$set_user_beclosed=3;
				}
				elseif($mg_row[mg_dateclose]=="3"){
					$time_input = $gmt_timestamp_now + (86400*30*6);//6 mon
					$set_user_beclosed=3;
				}
				elseif($mg_row[mg_dateclose]=="4"){
					$time_input = $gmt_timestamp_now + (86400*365);//1 year
					$set_user_beclosed=3;
				}
				elseif($mg_row[mg_dateclose]=="5"){
					$time_input = $gmt_timestamp_now + (86400*365*2);//2 years
					$set_user_beclosed=3;
				}
				else{
					$time_input=0;
					$set_user_beclosed=0;
				}
				update_field_in_db2("max_ecuser","user_mg_id='$mg_row[mg_id]',user_beclosed='$set_user_beclosed',user_dateclose='$time_input'", "user_name_id='$_SESSION[user_name_id]'");
				update_field_in_db("max_payment","pay_status","1","pay_id='$row_order_number[pay_id]' LIMIT 1");
				foreach($mg_row as $key=>$val){
					$_SESSION[$key]=$val;
				}
			}
		}
		else{
			$show_info.="<div class=\"Error_Message\">$myaccount_show_info_order_number_invalid $order_number</div><br />";
		}
	}	

	//Set account info to array $row_data
	$row_data = get_row("max_ecuser","*","user_id='$_SESSION[user_id]'");
	
	// Get Twitter connection detail
	$ec_oauth_token=$row_data[ec_oauth_token];
	$ec_oauth_secret=$row_data[ec_oauth_secret];
	if ($ec_oauth_token!="" && $ec_oauth_secret!="") {
		if ($_SESSION[twitter_screen_name]) {
			$twitter_screen_name = $_SESSION[twitter_screen_name];
			$twitter_screen_name_to_send=str_replace("%twitter_screen_name%",$_SESSION[twitter_screen_name],$myaccount_twitter_screen_name_to_send);
		}
		else {
			require_once('oAuth/EpiCurl.php');
			require_once('oAuth/EpiOAuth.php');
			require_once('oAuth/EpiTwitter.php');
			
			$twitterObj = new EpiTwitter($cf_consumer_key, $cf_consumer_secret);
			$twitterObj->setToken($ec_oauth_token,$ec_oauth_secret);
			$user = $twitterObj->get_accountVerify_credentials();
			$_SESSION[twitter_screen_name] = "@".$user->screen_name;
			$twitter_screen_name_to_send=str_replace("%twitter_screen_name%",$_SESSION[twitter_screen_name],$myaccount_twitter_screen_name_to_send);
		}
	}
	else {
		$twitter_screen_name_to_send="";
	}

	if($action=="send_test_message"){
		$cell_number=$row_data[user_cellphone_number];
		$row_carrier=get_row("max_cell_carrier","ca_domain,ca_name","ca_id='$row_data[user_cellphone_ca_id]'");
		$to_email=$cell_number."@".$row_carrier[ca_domain];
		$myaccount_sms_send_test_message_body=str_replace("%show_carrier_name%",$row_carrier[ca_name],$myaccount_sms_send_test_message_body);
		send_email("$row_data[user_name] $row_data[user_last_name]",$row_data[user_email],$to_email,$myaccount_sms_send_test_message_subject,$myaccount_sms_send_test_message_body,$cf_email_plain_text,$cf_webmaster_email);
		exit;
	}
	
	//Check if acct has been closed -> logout
	if($row_data[user_beclosed]!="0" && $row_data["user_dateclose"] <= $gmt_timestamp_now || $row_data[user_active]!="1"){//account suspended
		header("Location: $ecard_url/index.php?step=sign_out\n");
		exit;
	}

	foreach($row_data as $key=>$val){
		if(!(strpos($key,"user_")===false)){//if true
			$array_global_var_myaccount[$key]=$val;
			$_SESSION[$key]=$val;
		}
	}

	if($action=="undo_delete"){
		//Stop sending request cancel account
		if($_SESSION[user_beclosed] =="0" && $_SESSION[user_dateclose] =="0"){
			//Allow to cancel
			update_field_in_db("max_ecuser","user_request_cancel","0","user_id='$_SESSION[user_id]' LIMIT 1");
			$_SESSION[user_request_cancel]="0";
		}
	}

	//Show show_user_date_signup
	$show_user_date_signup=DateFormat($_SESSION[user_date_signup]);

	//Show show_user_last_login
	$show_user_last_login=DateFormat($_SESSION[user_lastlogin2]);
	
	//Show show_user_birthday
	if($cf_show_date_option =="0"){ //MM DD YYYY
		$ins_date_caption="(MM/DD/YYYY)";
		if($row_data[user_birth_mon]=="0" || $row_data[user_birth_mday]=="0"){
			$show_user_birthday="MM/DD/YYYY";
		}
		elseif($row_data[user_birth_mon]!="0" && $row_data[user_birth_mday]!="0" && $row_data[user_birth_year]=="0"){
			$show_user_birthday="$row_data[user_birth_mon]/$row_data[user_birth_mday]/YYYY";
		}
		elseif($row_data[user_birth_mon]!="0" && $row_data[user_birth_mday]!="0" && $row_data[user_birth_year]!="0"){
			$show_user_birthday="$row_data[user_birth_mon]/$row_data[user_birth_mday]/$row_data[user_birth_year]";
		}
	}
	elseif($cf_show_date_option =="1"){ //DD MM YYYY
		$ins_date_caption="(DD/MM/YYYY)";
		if($row_data[user_birth_mon]=="0" || $row_data[user_birth_mday]=="0"){
			$show_user_birthday="DD/MM/YYYY";
		}
		elseif($row_data[user_birth_mon]!="0" && $row_data[user_birth_mday]!="0" && $row_data[user_birth_year]=="0"){
			$show_user_birthday="$row_data[user_birth_mday]/$row_data[user_birth_mon]/YYYY";
		}
		elseif($row_data[user_birth_mon]!="0" && $row_data[user_birth_mday]!="0" && $row_data[user_birth_year]!="0"){
			$show_user_birthday="$row_data[user_birth_mday]/$row_data[user_birth_mon]/$row_data[user_birth_year]";
		}
	}
	elseif($cf_show_date_option =="2"){ //YYYY DD MM
		$ins_date_caption="(YYYY/DD/MM)";
		if($row_data[user_birth_mon]=="0" || $row_data[user_birth_mday]=="0"){
			$show_user_birthday="YYYY/DD/MM";
		}
		elseif($row_data[user_birth_mon]!="0" && $row_data[user_birth_mday]!="0" && $row_data[user_birth_year]=="0"){
			$show_user_birthday="YYYY/$row_data[user_birth_mday]/$row_data[user_birth_mon]";
		}
		elseif($row_data[user_birth_mon]!="0" && $row_data[user_birth_mday]!="0" && $row_data[user_birth_year]!="0"){
			$show_user_birthday="$row_data[user_birth_year]/$row_data[user_birth_mday]/$row_data[user_birth_mon]";
		}
	}
	elseif($cf_show_date_option =="3"){ //YYYY MM DD
		$ins_date_caption="(YYYY/MM/DD)";
		if($row_data[user_birth_mon]=="0" || $row_data[user_birth_mday]=="0"){
			$show_user_birthday="YYYY/MM/DD";
		}
		elseif($row_data[user_birth_mon]!="0" && $row_data[user_birth_mday]!="0" && $row_data[user_birth_year]=="0"){
			$show_user_birthday="YYYY/$row_data[user_birth_mon]/$row_data[user_birth_mday]";
		}
		elseif($row_data[user_birth_mon]!="0" && $row_data[user_birth_mday]!="0" && $row_data[user_birth_year]!="0"){
			$show_user_birthday="$row_data[user_birth_year]/$row_data[user_birth_mon]/$row_data[user_birth_mday]";
		}
	}	

	//Show primary language box
	$list_lang_file=get_list_file("$ecard_root/languages","_lang.php$");
	if($isResponsive)
	$show_lang_select="<select class='form-control input-sm' size=\"1\" name=\"user_lang\" id=\"user_lang\" onchange=\"Editme('$ecard_url/index.php?step=$step&next_step=$next_step&action=update_table&update_key=user_lang&value=',this.value,1,1,this.id);\">";
	else
	$show_lang_select="<select size=\"1\" name=\"user_lang\" id=\"user_lang\" style=\"width:200px\" onchange=\"Editme('$ecard_url/index.php?step=$step&next_step=$next_step&action=update_table&update_key=user_lang&value=',this.value,1,1,this.id);\">";
	foreach($list_lang_file as $val){
		$lang_name=ucwords(str_replace("_lang.php","",$val));
		if($val==$_SESSION[ecardmax_lang]){
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
	$show_state_box="<select class='form-control input-sm' size=\"1\" name=\"user_state\" id=\"user_state\" onchange=\"Editme('$ecard_url/index.php?step=$step&next_step=$next_step&action=update_table&update_key=user_state&value=',this.value,0,1,this.id);\">\n<option value=\"$row_data[user_state]\">$txt_dropdown_select</option>\n";
	else
	$show_state_box="<select size=\"1\" name=\"user_state\" id=\"user_state\" style=\"width:200px\" onchange=\"Editme('$ecard_url/index.php?step=$step&next_step=$next_step&action=update_table&update_key=user_state&value=',this.value,0,1,this.id);\">\n<option value=\"$row_data[user_state]\">$txt_dropdown_select</option>\n";
	foreach($array as $val){
		$val=trim($val);
		if($val!=""){
			$info=split("\|",$val);
			if($info[0]==$row_data[user_state]){
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
	if($isResponsive)
	$show_country_box="<select size=\"1\" name=\"user_country\" id=\"user_country\" class='form-control input-sm' onchange=\"Editme('$ecard_url/index.php?step=$step&next_step=$next_step&action=update_table&update_key=user_country&value=',this.value,0,1,this.id);\">\n<option value=\"$row_data[user_country]\">$txt_dropdown_select</option>\n";
	else
	$show_country_box="<select size=\"1\" name=\"user_country\" id=\"user_country\" style=\"width:200px\" onchange=\"Editme('$ecard_url/index.php?step=$step&next_step=$next_step&action=update_table&update_key=user_country&value=',this.value,0,1,this.id);\">\n<option value=\"$row_data[user_country]\">$txt_dropdown_select</option>\n";
	foreach($array as $val){
		$val=trim($val);
		if($val!=""){
			$val_title=str_replace("_"," ",$val);
			if($val==$row_data[user_country]){
				$show_country_box.="<option selected=\"selected\" value=\"$val\">$val_title</option>";
			}
			else{
				$show_country_box.="<option value=\"$val\">$val_title</option>";
			}
		}
	}
	$show_country_box.="</select>";

	//Correct dropdown user_dst (summer time)
	$array_global_var_myaccount["selected_user_dst_".$row_data[user_dst]]="selected=\"selected\"";
	$array_global_var_myaccount["selected_user_dst_".$row_data[user_dst]]="selected=\"selected\"";

	//Correct dropdown user_gender & user_marital
	$array_global_var_myaccount["selected_user_gender_".$row_data[user_gender]]="selected=\"selected\"";
	$array_global_var_myaccount["selected_user_marital_".$row_data[user_marital]]="selected=\"selected\"";

	//Show group member name
	$show_member_group=$_SESSION[mg_title];

	//Email newsletter & offers checkbox
	$array_global_var_myaccount["checked_user_receive_newsletter_".$row_data[user_receive_newsletter]]="checked=\"checked\"";
	$array_global_var_myaccount["checked_user_receive_offer_".$row_data[user_receive_offer]]="checked=\"checked\"";		

	//Show message request cancel acct has been sent to admin
	if($_SESSION[user_request_cancel] =="1" && $_SESSION[user_beclosed] !="0" && $_SESSION[user_dateclose] !="0"){
		if($_SESSION[user_beclosed]=="1" || $_SESSION[user_beclosed]=="2" ){
			//Admin already scheduled to close acct
			$myaccount_alert_will_be_closed=str_replace("%show_date%",DateFormat($_SESSION[user_dateclose]),$myaccount_alert_will_be_closed);
			$show_info .="<div class=\"Error_Message\">$myaccount_alert_will_be_closed</div><br />";
		}
		elseif($_SESSION[user_beclosed]=="3"){
			$myaccount_alert_will_be_downgrade=str_replace("%show_date%",DateFormat($_SESSION[user_dateclose]),$myaccount_alert_will_be_downgrade);
			$show_info .="<div class=\"Error_Message\">$myaccount_alert_will_be_downgrade</div><br />";
		}
		$hide_if_already_request="style=\"display:none\"";
	}
	elseif($_SESSION[user_request_cancel] =="1" && $_SESSION[user_beclosed] =="0"){
		//Request has been sent but Admin has not scheduled to close it
		$show_info .="<div class=\"Error_Message\">$myaccount_alert_request_cancel_sent</div><br />";		
		$hide_if_already_request="style=\"display:none\"";
	}

	$show_onload_javascript="onkeypress=\"return noGlobalEnterKey(event)\"";
	set_global_var2($array_global_var_myaccount);

	//Display random banner HR & VT
	print_banner("0");
	print_banner("1");
	
	//Allow main acct to create 2 free sub accts
	//Show button create free subaccount
	if($_SESSION[mg_allow_2subaccount]=="1"){
		if($_SESSION[user_member1]!="0" && $_SESSION[user_member2]!="0"){
			$button_free_subaccount1="<a href=\"javascript:void(0);\" onclick=\"var subaccount_number_js=1;ShowDivCenterPage('div_create_subacct','1');\" class=\"button_link_style1\">$myaccount_button_create_free_sub 1</a>";
			$button_free_subaccount2="<a href=\"javascript:void(0);\" onclick=\"var subaccount_number_js=2;ShowDivCenterPage('div_create_subacct','1');\" class=\"button_link_style1\">$myaccount_button_create_free_sub 2</a>";

			//Show sub account table
			if($_SESSION[user_member1]!=""){
				$row_user_member1=get_row("max_ecuser","*","user_name_id='$_SESSION[user_member1]'");
				$show_sub_number="1";
				$show_sub_user_first_name=$row_user_member1[user_name];
				$show_sub_user_last_name=$row_user_member1[user_last_name];
				$show_sub_user_email=$row_user_member1[user_email];
				$show_sub_user_name_id=$row_user_member1[user_name_id];
				$show_free_subaccount1=get_html_from_layout("templates/$cf_set_template/show_myaccount_subinfo.html");
				$button_free_subaccount1="<a href=\"javascript:void(0);\" class=\"button_link_style1\" style=\"filter: Alpha(Opacity=40);-moz-opacity:0.4;opacity:0.4;\">$myaccount_button_create_free_sub 1</a>";
			}

			if($_SESSION[user_member2]!=""){
				$row_user_member2=get_row("max_ecuser","*","user_name_id='$_SESSION[user_member2]'");
				$show_sub_number="2";
				$show_sub_user_first_name=$row_user_member2[user_name];
				$show_sub_user_last_name=$row_user_member2[user_last_name];
				$show_sub_user_email=$row_user_member2[user_email];
				$show_sub_user_name_id=$row_user_member2[user_name_id];
				$show_free_subaccount2=get_html_from_layout("templates/$cf_set_template/show_myaccount_subinfo.html");
				$button_free_subaccount2="<a href=\"javascript:void(0);\" class=\"button_link_style1\" style=\"filter: Alpha(Opacity=40);-moz-opacity:0.4;opacity:0.4;\">$myaccount_button_create_free_sub 2</a>";
			}
		}
	}

	//Hide Delete account button if sub acct
	if($_SESSION[user_member1]=="0" || $_SESSION[user_member2]=="0"){
		$hide_if_already_request="style=\"display:none\"";
	}

	//Account Permission
	$show_max_recipient=$_SESSION[mg_number_recipient];
	if($_SESSION[mg_number_recipient_per_hour]!="0"){
		$show_max_recipient_per_hour=$_SESSION[mg_number_recipient_per_hour];
	}
	else{
		$show_max_recipient_per_hour=$myaccount_txt_unlimited;
	}
	if($_SESSION[mg_number_recipient_per_day]!="0"){
		$show_max_recipient_per_day=$_SESSION[mg_number_recipient_per_day];
	}
	else{
		$show_max_recipient_per_day=$myaccount_txt_unlimited;
	}
	if($_SESSION[mg_show_watermark]=="1"){
		$show_watermark=$myaccount_txt_yes;
	}
	else{
		$show_watermark=$myaccount_txt_no;
	}
	if($_SESSION[mg_show_banner]=="1"){
		$show_banner=$myaccount_txt_yes;
	}
	else{
		$show_banner=$myaccount_txt_no;
	}
	if($_SESSION[mg_allow_game]=="1"){
		$allow_game=$myaccount_txt_yes;
	}
	else{
		$allow_game=$myaccount_txt_no;
	}
	if($_SESSION[mg_allow_grabber]=="1"){
		$allow_grabber=$myaccount_txt_yes;
	}
	else{
		$allow_grabber=$myaccount_txt_no;
	}
	if($_SESSION[mg_allow_search]=="1"){
		$allow_search=$myaccount_txt_yes;
	}
	else{
		$allow_search=$myaccount_txt_no;
	}
	if($_SESSION[mg_allow_futuredate]=="1"){
		$allow_futuredate=$myaccount_txt_yes;
	}
	else{
		$allow_futuredate=$myaccount_txt_no;
	}
	if($_SESSION[mg_allow_rate]=="1"){
		$allow_rate=$myaccount_txt_yes;
	}
	else{
		$allow_rate=$myaccount_txt_no;
	}
	if($_SESSION[mg_allow_viewfullsize]=="1"){
		$allow_viewfullsize=$myaccount_txt_yes;
	}
	else{
		$allow_viewfullsize=$myaccount_txt_no;
	}
	if($_SESSION[mg_allow_myaccount]=="1"){
		$allow_myaccount=$myaccount_txt_yes;
	}
	else{
		$allow_myaccount=$myaccount_txt_no;
	}
	if($_SESSION[mg_allow_addressbook]=="1"){
		$allow_addressbook=$myaccount_txt_yes;
	}
	else{
		$allow_addressbook=$myaccount_txt_no;
	}
	if($_SESSION[mg_allow_reminder]=="1"){
		$allow_reminder=$myaccount_txt_yes;
	}
	else{
		$allow_reminder=$myaccount_txt_no;
	}
	if($_SESSION[mg_allow_calendar]=="1"){
		$allow_calendar=$myaccount_txt_yes;
	}
	else{
		$allow_calendar=$myaccount_txt_no;
	}
	if($_SESSION[mg_allow_myalbum]=="1"){
		$allow_myalbum=$myaccount_txt_yes;
	}
	else{
		$allow_myalbum=$myaccount_txt_no;
	}
	if($_SESSION[mg_allow_favorite]=="1"){
		$allow_favorite=$myaccount_txt_yes;
	}
	else{
		$allow_favorite=$myaccount_txt_no;
	}
	if($_SESSION[mg_allow_history]=="1"){
		$allow_history=$myaccount_txt_yes;
	}
	else{
		$allow_history=$myaccount_txt_no;
	}
	if($_SESSION[mg_allow_birthdayalert]=="1"){
		$allow_birthdayalert=$myaccount_txt_yes;
	}
	else{
		$allow_birthdayalert=$myaccount_txt_no;
	}
	if($_SESSION[mg_allow_2subaccount]=="1"){
		$allow_2subaccount=$myaccount_txt_yes;
	}
	else{
		$allow_2subaccount=$myaccount_txt_no;
	}
	if($_SESSION[mg_payment_amount]>0){
		$payment_amount=price_format($_SESSION[mg_payment_amount]);
	}
	else{
		$payment_amount=price_format("0.00");
	}

	//Show button upgrade your account
	$_CLS = 'button_link_style2';
	$_I_TEXT = $_CLS_NULL = '';
	if($isResponsive)
	{
		$_CLS = 'btn btn-sm btn-default';
		$_CLS_NULL = $_CLS;
		$_I_TEXT = '<i class="fa fa-level-up padding5"></i>';
	}
	if($_SESSION[mg_id]=="2" && get_dbvalue("max_member_group","count(mg_id)")>2){
		$button_upgrade_account="<a href=\"$ecard_url/index.php?step=update_your_account\" class=\"$_CLS\">$_I_TEXT $myaccount_button_upgrade_account</a>";
	}

	//Show cell phone carrier
	if($isResponsive)
	$show_cell_phone_carrier="<select class='form-control input-sm' size=\"1\" name=\"user_cellphone_ca_id\" id=\"user_cellphone_ca_id\" onchange=\"Editme('$ecard_url/index.php?step=$step&next_step=$next_step&action=update_table&update_key=user_cellphone_ca_id&value=',this.value,1,1,this.id);\">";
	else
	$show_cell_phone_carrier="<select size=\"1\" name=\"user_cellphone_ca_id\" id=\"user_cellphone_ca_id\" onchange=\"Editme('$ecard_url/index.php?step=$step&next_step=$next_step&action=update_table&update_key=user_cellphone_ca_id&value=',this.value,1,1,this.id);\">";
	$list_carrier=set_array_from_query("max_cell_carrier","*","ca_active='1' Order By ca_name");
	foreach($list_carrier as $row_ca){
		if($_SESSION[user_cellphone_ca_id]==$row_ca[ca_id]){
			$show_cell_phone_carrier.="<option selected=\"selected\" value=\"$row_ca[ca_id]\">$row_ca[ca_name]</option>";
		}
		else{
			$show_cell_phone_carrier.="<option value=\"$row_ca[ca_id]\">$row_ca[ca_name]</option>";
		}
	}
	$show_cell_phone_carrier.="</select>";

	set_global_var("checked_user_cellphone_active_".$_SESSION[user_cellphone_active],"checked=\"checked\"");
	
	//Show account balane
	if($_SESSION[user_balance]==""){
		$show_account_balance=price_format("0.00");
	}
	else{
		$show_account_balance=price_format($_SESSION[user_balance]);
	}
	$list_payment=set_array_from_query("max_payment","*","pay_user_name_id='$_SESSION[user_name_id]' Order By pay_date DESC");
	$show_list_table="";
	foreach($list_payment as $row_data){
		$show_date_purchase=DateFormat($row_data[pay_date],"1");
		if($row_data[pay_what]=="0"){
			$show_type=$myaccount_purchase_history_order_type_ppc;
		}
		else{
			$show_type=$myaccount_purchase_history_order_type_upgrade_acct;
		}

		$show_list_table .="<tr class=\"table_td_background\">\n";
		$show_list_table .="<td width=\"*%\" style=\"text-align:center;padding:7px;\">$show_date_purchase</td>\n";
		$show_list_table .="<td width=\"*\" style=\"text-align:center;padding:7px;\">$row_data[pay_order_number]</td>\n";
		$show_list_table .="<td width=\"*\" style=\"text-align:center;padding:7px;\">".price_format($row_data[pay_amount])."</td>\n";
		$show_list_table .="<td width=\"1%\" style=\"text-align:center;padding:7px;white-space:nowrap\">$show_type</td>\n";		
		$show_list_table .="<td width=\"1%\" style=\"text-align:center;padding:7px;\">$row_data[pay_via]</td>\n";
		$show_list_table .="</tr>\n";
	}

	//Show button delete account or cancel membership
	if($_SESSION[mg_id]>2){
		set_global_var("myaccount_delete_account",$myaccount_cancel_membership);
	}
	if($_SESSION['user_name_id']!=$_SESSION['facebook_id'])
		$array_global_var[print_object]=get_html_from_layout("templates/$cf_set_template/show_myaccount.html");
	else
		$array_global_var[print_object]=get_html_from_layout("templates/$cf_set_template/show_myaccount_fb.html");
	print_header_and_footer();

	//------------------------------------------------------------------
	function detele_account($user_id) {
		
		$user_row=get_row("max_ecuser","*","user_id='$user_id'");
		$user=$user_row[user_name_id];

		//Delete Sub Account first (base on user_member1 & user_member2
		$free1 = $user_row[user_member1];
		$free2 = $user_row[user_member2];
		if($free1=="0")$free1="";
		if($free2=="0")$free2="";

		//Remove user from table max_mail_list 
		if($free1 !=""){
			$free1_email=get_dbvalue("max_ecuser","user_email","user_name_id='$free1'");
			delete_row("max_mail_list","list_email='$free1_email' and list_mgroup_id='-1' or list_email='$free1_email' and list_mgroup_id='-2' ");
		}

		//Remove user from table max_mail_list 
		if($free2 !=""){
			$free1_email=get_dbvalue("max_ecuser","user_email","user_name_id='$free2'");
			delete_row("max_mail_list","list_email='$free1_email' and list_mgroup_id='-1' or list_email='$free1_email' and list_mgroup_id='-2' ");
		}

		//Remove user from table max_addressbook
		if($free1 !=""){
			delete_row("max_addressbook","book_user_name_id='$free1'");
		}
		//Remove user from table max_addressbook
		if($free2 !=""){
			delete_row("max_addressbook","book_user_name_id='$free2'");
		}
		//Remove user from table max_addressbook
		delete_row("max_addressbook","book_user_name_id='$user'");

		//Remove user from table max_ecard
		if($free1 !=""){
			delete_row("max_ecard","ec_user_name_id='$free1'");
		}
		//Remove user from table max_ecard
		if($free2 !=""){
			delete_row("max_ecard","ec_user_name_id='$free2'");
		}
		//Remove user from table max_ecard
		delete_row("max_ecard","ec_user_name_id='$user'");

		//Remove user from table max_ecardsent
		if($free1 !=""){
			delete_row("max_ecardsent","cs_user_name_id='$free1'");
		}
		//Remove user from table max_ecardsent
		if($free2 !=""){
			delete_row("max_ecardsent","cs_user_name_id='$free2'");
		}
		//Remove user from table max_ecardsent
		delete_row("max_ecardsent","cs_user_name_id='$user'");

		//max_ecuser
		//Main acct + 2 Sub acct
		delete_row("max_ecuser","user_id='$user_id' LIMIT 1");
		if($free1 !="")
			delete_row("max_ecuser","user_name_id='$free1' LIMIT 1");
		if($free2 !="")
			delete_row("max_ecuser","user_name_id='$free2' LIMIT 1");

		//Remove user from table max_favorite
		if($free1 !=""){
			delete_row("max_favorite","fv_user_name_id='$free1'");
		}
		if($free2 !=""){
			delete_row("max_favorite","fv_user_name_id='$free2'");
		}
		delete_row("max_favorite","fv_user_name_id='$user'");

		//Remove user from table max_music 
		if($free1 !=""){
			delete_row("max_music","music_user_name_id='$free1'");
		}
		//Remove user from table max_music 
		if($free2 !=""){
			delete_row("max_music","music_user_name_id='$free2'");
		}
		//Remove user from table max_music 
		delete_row("max_music","music_user_name_id='$user'");

		//Remove user from table max_poem
		if($free1 !=""){
			delete_row("max_poem","poem_user_name_id='$free1'");
		}
		//Remove user from table max_poem
		if($free2 !=""){
			delete_row("max_poem","poem_user_name_id='$free2'");
		}
		//Remove user from table max_poem
		delete_row("max_poem","poem_user_name_id='$user'");
					
		//Remove user from table max_reminder
		if($free1 !=""){
			delete_row("max_reminder","rm_user_name_id='$free1'");
		}
		//Remove user from table max_reminder
		if($free2 !=""){
			delete_row("max_reminder","rm_user_name_id='$free2'");
		}
		//Remove user from table max_reminder
		delete_row("max_reminder","rm_user_name_id='$user'");
		
		//Remove user from table max_mail_list
		delete_row("max_mail_list","list_email='$user_row[user_email]' and list_mgroup_id='-1' or list_email='$user_row[user_email]' and list_mgroup_id='-2'");
	}

?>
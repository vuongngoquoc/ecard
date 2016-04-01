<?php
/*
+--------------------------------------------------------------------------
|
|	WARNING: REMOVING THIS COPYRIGHT HEADER IS EXPRESSLY FORBIDDEN
|
|   ECARDMAX 2010 Full Version
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
	//Show personalize table 
		//Show preview thumbnail card
	if($ec_row[ec_thumbnail]!=""){
		$show_card_thumbnail="<img border=\"0\" alt=\"\" src=\"$ecard_url/resource/picture/$ec_row[ec_cat_dir]/$ec_row[ec_thumbnail]\" class=\"thumbnail_image\" style=\"vertical-align:middle;\" />";
	}
	else{
		$show_card_thumbnail="<img border=\"0\" alt=\"\" src=\"$ecard_url/templates/$cf_set_template/your_photo.gif\" class=\"thumbnail_image\" style=\"vertical-align:middle;\" />";
	}
	$my_lang_name="ec_caption_".str_replace(".php","",$_SESSION[ecardmax_lang]);
	if($ec_row[$my_lang_name]==""){
		$show_card_title=$ec_row[ec_caption];
	}
	else{
		$show_card_title=$ec_row[$my_lang_name];
	}

		//Show sender name + email (if user alredy logged in)
	if($_SESSION[ecardmax_user]!=""){
		$cs_from_name="$_SESSION[user_name] $_SESSION[user_last_name]";
		$cs_from_email="$_SESSION[user_email]";
		$cs_from_name_read_only_if_login="readonly=\"readonly\"";
		if($_SESSION[ecardmax_reply]=="1"){
			$show_list_friend_name_1=$_SESSION[remember_sender_name];
			$show_list_friend_email_1=$_SESSION[remember_sender_email];
		}
	}
	else{		
		if($_SESSION[ecardmax_reply]=="1" || $reply=="1"){
			$cs_from_name=$_SESSION[remember_recipient_name];
			$cs_from_email=$_SESSION[remember_recipient_email];
			$show_list_friend_name_1=$_SESSION[remember_sender_name];
			$show_list_friend_email_1=$_SESSION[remember_sender_email];
		}
	}

	//Reset
	$_SESSION[ecardmax_reply]=="";
	$_SESSION[remember_sender_name]="";
	$_SESSION[remember_sender_email]="";
	$_SESSION[remember_recipient_name]="";
	$_SESSION[remember_recipient_email]="";	

		//Show show_max_number_recipients prevent spammer here
	if($_SESSION[mg_number_recipient_per_hour]=="0" && $_SESSION[mg_number_recipient_per_day]=="0" ){
		$show_max_number_recipients=$_SESSION[mg_number_recipient];
	} 
	else{
		$time_onehour_ago = $gmt_timestamp_now - 3600 ;
		$time_oneday_ago = $gmt_timestamp_now - 86400 ;
		if($_SESSION[ecardmax_user]==""){
			$get_number_cardsent_perhour=get_dbvalue("max_ecardsent","count(cs_id)","cs_from_email='$_COOKIE[cookie_cs_from_email]' and cs_sender_ip='$remote_addr' and cs_date_create > $time_onehour_ago ");
			$get_number_cardsent_perday=get_dbvalue("max_ecardsent","count(cs_id)","cs_from_email='$_COOKIE[cookie_cs_from_email]' and cs_sender_ip='$remote_addr' and cs_date_create > $time_oneday_ago ");	
		}
		else{
			$get_number_cardsent_perhour=get_dbvalue("max_ecardsent","count(cs_id)","cs_user_name_id='$_SESSION[user_name_id]' and cs_date_create > $time_onehour_ago ");
			$get_number_cardsent_perday=get_dbvalue("max_ecardsent","count(cs_id)","cs_user_name_id='$_SESSION[user_name_id]' and cs_date_create > $time_oneday_ago ");	
		}
		if($get_number_cardsent_perday < $_SESSION[mg_number_recipient_per_day]){
			$show_max_number_recipients=$_SESSION[mg_number_recipient]-$get_number_cardsent_perhour;
		}
		else{
			$show_max_number_recipients=0;
		}
	}
	
	$show_number_recipient_default=$_SESSION[mg_number_recipient_default];

	if($show_max_number_recipients<="0"){
		header("Location:$ecard_url/index.php?step=send_card_over_limit\n");
		exit;
	}

		//Show checkbox auto save recipient to addressbook
	if($_SESSION[ecardmax_user]!=""){
		$checkbox_save_recipient_to_addressbook="<div><input checked=\"checked\" name=\"save_email\" type=\"checkbox\" value=\"1\" /> $sendcard_php_txt_save_recipient_to_addressbook</div>";
	}

		//Show checkbox sign up newsletter & special offers
	if($_SESSION[ecardmax_user]==""){
		$checkbox_signup_newsletter="<div><input checked=\"checked\" name=\"user_receive_newsletter\" type=\"checkbox\" value=\"1\" /> $sendcard_php_txt_yes_join_newsletter</div>";
		$checkbox_signup_special_offer="<div><input checked=\"checked\" name=\"user_receive_offer\" type=\"checkbox\" value=\"1\" /> $sendcard_php_txt_yes_join_offers</div>";
	}

		//Show show_delivery_date	
	if($cf_show_date_option =="0"){ //MM DD YYYY
		$ins_date_caption="(MM/DD/YYYY)";
		$ins_date_data="$today_mon/$today_mday/$today_year" ;
	}
	elseif($cf_show_date_option =="1"){ //DD MM YYYY
		$ins_date_caption="(DD/MM/YYYY)";
		$ins_date_data="$today_mday/$today_mon/$today_year" ;
	}
	elseif($cf_show_date_option =="2"){ //YYYY DD MM
		$ins_date_caption="(YYYY/DD/MM)";
		$ins_date_data="$today_year/$today_mday/$today_mon" ;
	}
	elseif($cf_show_date_option =="3"){ //YYYY MM DD
		$ins_date_caption="(YYYY/MM/DD)";
		$ins_date_data="$today_year/$today_mon/$today_mday" ;
	}

	if($_SESSION[mg_allow_futuredate]=="1"){
		$show_delivery_date="<div id=\"show_popup_calendar\" style=\"cursor:pointer;\" title=\"$txt_calendar\" onclick=\"ShowDiv(this.id,'popup_calendar',0,0);info=document.getElementById('time_end_textbox').value.split('\/');cf_show_date_option='$cf_show_date_option';if(cf_show_date_option=='0'){selected_month=info[0];selected_day=info[1];selected_year=info[2];}else if(cf_show_date_option=='1'){selected_day=info[0];selected_month=info[1];selected_year=info[2];}else if(cf_show_date_option=='2'){selected_year=info[0];selected_day=info[1];selected_month=info[2];}else if(cf_show_date_option=='3'){selected_year=info[0];selected_month=info[1];selected_day=info[2];};frames['calendar_frame'].location.href='$ecard_url/index.php?step=calendar&year_from=$today_year&year_to=$next_10year&mode=0&month='+selected_month+'&year='+selected_year+'&selected_day='+selected_day+'&selected_month='+selected_month+'&selected_year='+selected_year\">$show_personalize_table_txt_pick_a_date <input readonly=\"readonly\" type=\"text\" name=\"time_end_textbox\" id=\"time_end_textbox\" value=\"$ins_date_data\" style=\"width:100px\" /> <img border=\"0\" alt=\"\" style=\"vertical-align:middle\" src=\"$ecard_url/templates/$cf_set_template/icon_calendar.gif\" /> $ins_date_caption</div>";
	}
	else{
		$show_delivery_date="<div id=\"show_popup_calendar\">$show_personalize_table_txt_send_card_today<input type=\"hidden\" name=\"time_end_textbox\" id=\"time_end_textbox\" value=\"$ins_date_data\" /> <strong>$ins_date_data</strong> $ins_date_caption</div>";
	}

		//Show show_address_book
	if($_SESSION[ecardmax_user]==""){
		$show_address_book=$sendcard_php_txt_login_to_use_addressbook;
	}
	else{
		if($_SESSION[mg_allow_addressbook]=="1"){
			//button view address book
			$show_button="<div style=\"text-align:center;padding:5px\"><a href=\"javascript:void(0);\" onclick=\"showid2('table_addressbook','block');showid2('table_addressbook_group','none');\" class=\"button_link_style1\">$txt_mtool_addressbook</a><a href=\"javascript:void(0);\" onclick=\"showid2('table_addressbook','none');showid2('table_addressbook_group','block');\" class=\"button_link_style2\">$addressbook_contact_group_title</a></div>";

			//list all contact
			$list_contact=set_array_from_query("max_addressbook","book_id,book_fname,book_lname,book_email","book_user_name_id='$_SESSION[user_name_id]' Order by book_lname,book_fname,book_email");
			$show_contact="<div id=\"table_addressbook\" style=\"display:bvlock\"><hr class=\"HR_Color\" />";
			foreach($list_contact as $arr_contact){
				$show_contact.="<div class=\"book_list_div\" onmouseover=\"this.className='book_list_div_hover';\" onmouseout=\"this.className='book_list_div';\" onclick=\"AddContactToList('$arr_contact[book_id]');\"><strong>$arr_contact[book_fname] $arr_contact[book_lname]</strong><br />$arr_contact[book_email]</div><div style=\"display:none\" id=\"contactname$arr_contact[book_id]\">$arr_contact[book_fname] $arr_contact[book_lname]</div><div style=\"display:none\" id=\"contactemail$arr_contact[book_id]\">$arr_contact[book_email]</div>";
			}
			$show_contact.="</div>";

			//List contact group
			$list_contact_group=set_array_from_query("max_addressbook_group","ag_id,ag_title","ag_user_id='$_SESSION[user_id]' Order by ag_title");			
			$show_contact_group="<div id=\"table_addressbook_group\" style=\"display:none\"><hr class=\"HR_Color\" />";
			$show_contact_group_options="";
			foreach($list_contact_group as $arr_contact){
				$list_contact_each_group=set_array_from_query("max_addressbook","book_id,book_fname,book_lname,book_email","book_user_name_id='$_SESSION[user_name_id]' and book_ag_relate_id like '%,$arr_contact[ag_id],%' Order by book_lname,book_fname,book_email");
				$count_group_email=count($list_contact_each_group);
				$mycontactdetail="<textarea id=\"groupdetail$arr_contact[ag_id]\" style=\"display:none\">";
				foreach($list_contact_each_group as $arr_book){
					$c_name="$arr_book[book_fname] $arr_book[book_lname]";
					$c_name=str_replace(";",",",$c_name);
					$mycontactdetail.="$c_name;$arr_book[book_email]\n";
				}
				$mycontactdetail.="</textarea>";				

				$show_contact_group.="<div class=\"book_list_div\" onmouseover=\"this.className='book_list_div_hover';\" onmouseout=\"this.className='book_list_div';\" onclick=\"AddContactGroupToList($arr_contact[ag_id])\"><strong>$arr_contact[ag_title]</strong><br />$sendcard_php_txt_number_of_email $count_group_email</div>$mycontactdetail";
				$show_contact_group_options.="<option value=\"$arr_contact[ag_id]\">$arr_contact[ag_title]</option>";
			}
			$show_contact_group.="</div>";

			$show_address_book="$show_button<div id=\"div_addressbook_and_group\">$show_contact$show_contact_group</div>";
		}
		else{
			$show_address_book=$sendcard_php_txt_update_account_to_use_addressbook;
		}
	}	

	//Show new account balance if paypercard
	if($show_new_acct_balance=="1"){
		$new_balance=number_format($get_user_balance-$get_ppc_amount,2);
		$show_account_balance_if_ppc.="<fieldset><legend>$fieldset_acct_balance_after_send_ppc_card</legend>";
		$show_account_balance_if_ppc.="<div style=\"width:300px;float:left;padding:4px\">$txt_current_acct_balance</div><div style=\"float:left;padding:4px\"><strong>\$$get_user_balance</strong></div>";
		$show_account_balance_if_ppc.="<div style=\"width:300px;float:left;padding:4px\">$txt_ppc_amount</div><div style=\"float:left;padding:4px\"><strong>\$$get_ppc_amount</strong></div>";
		$show_account_balance_if_ppc.="<div style=\"width:300px;float:left;padding:4px\"></div><div style=\"float:left;padding:4px\">--------</div>";
		$show_account_balance_if_ppc.="<div style=\"width:300px;float:left;padding:4px\">$txt_new_acct_balance</div><div style=\"float:left;padding:4px\" class=\"OK_Message\">\$$new_balance</div>";
		$show_account_balance_if_ppc.="</fieldset>";
		$_SESSION[new_account_balance]=$new_balance;
	}
	if($_SESSION[mg_allow_send_birthday_to_group]=="1"){
		$show_send_on_birthday="<div><input name=\"send_birthday_to_group\" type=\"checkbox\" value=\"1\" onclick=\"sendOnBirthday(this)\"/>$send_on_recipient_birthday</div>";
		set_global_var("show_send_on_birthday",$show_send_on_birthday);
	}
	$data=set_array_from_query("max_addressbook_group","*","ag_user_id=$_SESSION[user_id]");
	if($group_id==-1){
		$select_group_list="<option value=\"0\" selected>$default_group</option>";
	}else{
		$select_group_list="<option value=\"0\">$default_group</option>";
	}
	
	$select_group_list.=buildOptions($data,"ag_id","ag_title","$group_id");	
	set_global_var("show_contact_group_options",$show_contact_group_options);
	set_global_var("select_group_list",$select_group_list);
	$show_personalize_table=get_html_from_layout("templates/$cf_set_template/show_personalize_table_setting.html");

/**
 *
 * @param <type> $data
 * @param <type> $key
 * @param <type> $value
 * @param <type> $default
 * @return $optionsList
 */
?>

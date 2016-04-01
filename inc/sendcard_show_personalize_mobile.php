<?php
/*
+--------------------------------------------------------------------------
|
|	WARNING: REMOVING THIS COPYRIGHT HEADER IS EXPRESSLY FORBIDDEN
|
|   ECardMax Version 10.5
|   ========================================
|   (c) 1999 - 2014 ECARDMAX.COM - All right reserved 
|	Software For Website, Inc.
|   http://www.ecardmax.com 
|   ========================================
|   Email: webmaster@ecardmax.com
|   Purchase Info: http://www.ecardmax.com/home/Purchase.html
|   Request Installation: http://www.ecardmax.com/home/Support.html
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
	if($isResponsive)
	{
		$myloop= get_html_from_layout("templates/$cf_set_template/myloop.html");
		set_global_var('myloop',$myloop);
	}
	if ($cf_enable_twitter) {
		if ($_SESSION[twitter_screen_name]) {
			$twitter_account_to_send_1 = str_replace("%twitter_account%",$_SESSION[twitter_screen_name],$twitter_account_to_send);
			$twitter_message = str_replace("%twitter_to_send_message%","$twitter_account_to_send_1",$twitter_message_help);
		}
		elseif ($_SESSION['ec_oauth_token'] && $_SESSION['ec_oauth_secret']) {
			require_once('oAuth/EpiCurl.php');
			require_once('oAuth/EpiOAuth.php');
			require_once('oAuth/EpiTwitter.php');
			
			$twitterObj = new EpiTwitter($cf_consumer_key, $cf_consumer_secret);
			$twitterObj->setToken($_SESSION['ec_oauth_token'],$_SESSION['ec_oauth_secret']);
			$user = $twitterObj->get_accountVerify_credentials();
			$_SESSION[twitter_screen_name] = "@".$user->screen_name;
			
			$twitter_account_to_send_1 = str_replace("%twitter_account%",$_SESSION[twitter_screen_name],$twitter_account_to_send);
			$twitter_message = str_replace("%twitter_to_send_message%","$twitter_account_to_send_1",$twitter_message_help);
		}
		else {
			$twitter_message = str_replace("%twitter_to_send_message%","",$twitter_message_help);
		}
	}
	else {
		$twitter_message = $twitter_message_help_disabled;
	}

	//Show personalize table 
		//Show preview thumbnail card
	if($ec_row[ec_thumbnail]!=""){
		$card_thumbnail_url="$ecard_url/resource/picture/$ec_row[ec_cat_dir]/$ec_row[ec_thumbnail]";
	}
	else{
		$card_thumbnail_url="$ecard_url/templates/$cf_set_template/your_photo.gif";
	}
	$show_card_thumbnail=get_html_from_layout("templates/$cf_set_template/show_personalize_table_show_card_thumbnail.html");
	
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
		$checkbox_save_recipient_to_addressbook=get_html_from_layout("templates/$cf_set_template/show_personalize_table_checkbox_save_recipient_to_addressbook.html");
	}

	//Show checkbox sign up newsletter & special offers
	if($_SESSION[ecardmax_user]==""){
		$checkbox_signup_newsletter=get_html_from_layout("templates/$cf_set_template/show_personalize_table_checkbox_signup_newsletter.html");
		$checkbox_signup_special_offer=get_html_from_layout("templates/$cf_set_template/show_personalize_table_checkbox_signup_special_offer.html");
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
		$show_delivery_date=get_html_from_layout("templates/$cf_set_template/show_personalize_table_show_delivery_date_allow_future_date.html");
	}
	else{
		$show_delivery_date=get_html_from_layout("templates/$cf_set_template/show_personalize_table_show_delivery_date_no_future_date.html");
	}

		//Show show_address_book
	if($_SESSION[ecardmax_user]==""){
		$show_address_book=$sendcard_php_txt_login_to_use_addressbook;
	}
	else{
		if($_SESSION[mg_allow_addressbook]=="1"){
			//list all contact
			$list_contact=set_array_from_query("max_addressbook","book_id,book_fname,book_lname,book_email","book_user_name_id='$_SESSION[user_name_id]' Order by book_lname,book_fname,book_email");
			$show_list_of_contacts="";
			foreach($list_contact as $arr_contact){
				$book_id=$arr_contact[book_id];
				$book_fname=$arr_contact[book_fname];
				$book_lname=$arr_contact[book_lname];
				$book_email=$arr_contact[book_email];
				$show_list_of_contacts.=get_html_from_layout("templates/$cf_set_template/show_personalize_table_show_address_book_show_contact_item.html");
			}
			$show_contact=get_html_from_layout("templates/$cf_set_template/show_personalize_table_show_address_book_show_contact.html");

			//List contact group
			$list_contact_group=set_array_from_query("max_addressbook_group","ag_id,ag_title","ag_user_id='$_SESSION[user_id]' Order by ag_title");			
			$show_list_of_contact_group="";
			$show_contact_group_options="";
			foreach($list_contact_group as $arr_contact){
				$list_contact_each_group=set_array_from_query("max_addressbook","book_id,book_fname,book_lname,book_email","book_user_name_id='$_SESSION[user_name_id]' and book_ag_relate_id like '%,$arr_contact[ag_id],%' Order by book_lname,book_fname,book_email");
				$count_group_email=count($list_contact_each_group);
				$mycontactdetail_list="";
				foreach($list_contact_each_group as $arr_book){
					$c_name="$arr_book[book_fname] $arr_book[book_lname]";
					$c_name=str_replace(";",",",$c_name);
					$mycontactdetail_list.="$c_name;$arr_book[book_email]\n";
				}
				$ag_id=$arr_contact[ag_id];
				$mycontactdetail=get_html_from_layout("templates/$cf_set_template/show_personalize_table_show_address_book_show_contact_group_mycontactdetail.html");

				$ag_title=$arr_contact[ag_title];
				$show_list_of_contact_group.=get_html_from_layout("templates/$cf_set_template/show_personalize_table_show_address_book_show_contact_group_item.html");
				$show_contact_group_options.="<option value=\"$arr_contact[ag_id]\">$arr_contact[ag_title]</option>";
			}
			$show_contact_group=get_html_from_layout("templates/$cf_set_template/show_personalize_table_show_address_book_show_contact_group.html");

			$show_address_book=get_html_from_layout("templates/$cf_set_template/show_personalize_table_show_address_book.html");
		}
		else{
			$show_address_book=$sendcard_php_txt_update_account_to_use_addressbook;
		}
	}	

	//Show new account balance if paypercard
	if($show_new_acct_balance=="1"){
		$new_balance=number_format($get_user_balance-$get_ppc_amount,2);
		set_global_var('get_user_balance', number_format($get_user_balance, 2));
		set_global_var('get_ppc_amount', number_format($get_ppc_amount, 2));
		$get_user_balance=$$get_user_balance;
		$get_ppc_amount=$$get_ppc_amount;
		$_SESSION[new_account_balance]=$new_balance;
		if($new_balance!='0.00')
		{
			$show_account_balance_if_ppc=get_html_from_layout("templates/$cf_set_template/show_personalize_table_show_account_balance_if_ppc.html");
		}
	}
	set_global_var("show_contact_group_options",$show_contact_group_options);
	$show_personalize_table=get_html_from_layout("templates/$cf_set_template/show_personalize_table.html");
?>
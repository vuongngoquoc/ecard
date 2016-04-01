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

	if($what=="add_new_group"){
		//Create new Group
		if($mg_allow_send_card=="")$mg_allow_send_card=0;
		if($mg_show_watermark=="")$mg_show_watermark=0;
		if($mg_show_banner=="")$mg_show_banner=0;
		if($mg_allow_game=="")$mg_allow_game=0;
		if($mg_allow_grabber=="")$mg_allow_grabber=0;
		if($mg_allow_search=="")$mg_allow_search=0;
		if($mg_allow_manyemails=="")$mg_allow_manyemails=0;
		if($mg_allow_futuredate=="")$mg_allow_futuredate=0;
		if($mg_allow_rate=="")$mg_allow_rate=0;
		if($mg_allow_viewfullsize=="")$mg_allow_viewfullsize=0;
		if($mg_allow_myaccount=="")$mg_allow_myaccount=0;
		if($mg_allow_invitation=="")$mg_allow_invitation=0;
		if($mg_allow_addressbook=="")$mg_allow_addressbook=0;
		if($mg_allow_reminder=="")$mg_allow_reminder=0;
		if($mg_allow_calendar=="")$mg_allow_calendar=0;
		if($mg_allow_myalbum=="")$mg_allow_myalbum=0;
		if($mg_allow_favorite=="")$mg_allow_favorite=0;
		if($mg_allow_history=="")$mg_allow_history=0;
		if($mg_allow_birthdayalert=="")$mg_allow_birthdayalert=0;
		if($mg_allow_to_share_card_with_twitter=="")$mg_allow_to_share_card_with_twitter=0;
		if($mg_allow_to_share_card_with_facebook=="")$mg_allow_to_share_card_with_facebook=0;
		if($mg_allow_to_share_card_with_googleplus=="")$mg_allow_to_share_card_with_googleplus=0;
		if($mg_allow_to_share_card_with_linkedin=="")$mg_allow_to_share_card_with_linkedin=0;
		if($mg_allow_2subaccount=="")$mg_allow_2subaccount=0;
		if($mg_allow_send_birthday_to_group=="")$mg_allow_send_birthday_to_group=0;
		if(!is_numeric($mg_number_recipient_invite))$mg_number_recipient_invite=30;
		if(!is_numeric($mg_number_recipient_default_invite))$mg_number_recipient_default_invite=1;
		if(!is_numeric($mg_number_recipient_per_hour_invite))$mg_number_recipient_per_hour_invite=60;
		if(!is_numeric($mg_number_recipient_per_day_invite))$mg_number_recipient_per_day_invite=100;
		$field_name ="(mg_allow_send_card,mg_number_recipient_invite,mg_number_recipient_default_invite,mg_number_recipient_per_hour_invite,mg_number_recipient_per_day_invite,mg_dateclose,mg_buynow_title1,mg_buynow_title2,mg_payment_method2,mg_payment_method1,mg_payment_amount,mg_number_recipient_per_day,mg_number_recipient_per_hour,mg_number_recipient_default,mg_number_recipient,mg_show_banner,mg_title,mg_show_watermark,mg_allow_game,mg_allow_grabber,mg_allow_search,mg_allow_manyemails,mg_allow_futuredate,mg_allow_rate,mg_allow_viewfullsize,mg_allow_myaccount,mg_allow_invitation,mg_allow_addressbook,mg_allow_reminder,mg_allow_calendar,mg_allow_myalbum,mg_allow_favorite,mg_allow_history,mg_allow_birthdayalert,mg_allow_2subaccount,mg_allow_send_birthday_to_group,mg_allow_to_share_card_with_twitter,mg_allow_to_share_card_with_facebook,mg_allow_to_share_card_with_googleplus,mg_allow_to_share_card_with_linkedin)";
		$field_value ="('$mg_allow_send_card','$mg_number_recipient_invite','$mg_number_recipient_default_invite','$mg_number_recipient_per_hour_invite','$mg_number_recipient_per_day_invite',$mg_dateclose,'$mg_buynow_title1','$mg_buynow_title2','$mg_payment_method2','$mg_payment_method1','$mg_payment_amount','$mg_number_recipient_per_day','$mg_number_recipient_per_hour','$mg_number_recipient_default','$mg_number_recipient',$mg_show_banner,'$mg_title',$mg_show_watermark,$mg_allow_game,$mg_allow_grabber,$mg_allow_search,$mg_allow_manyemails,$mg_allow_futuredate,$mg_allow_rate,$mg_allow_viewfullsize,$mg_allow_myaccount,$mg_allow_invitation,$mg_allow_addressbook,$mg_allow_reminder,$mg_allow_calendar,$mg_allow_myalbum,$mg_allow_favorite,$mg_allow_history,$mg_allow_birthdayalert,$mg_allow_2subaccount,'$mg_allow_send_birthday_to_group','$mg_allow_to_share_card_with_twitter','$mg_allow_to_share_card_with_facebook','$mg_allow_to_share_card_with_googleplus','$mg_allow_to_share_card_with_linkedin')";
		insert_data_to_db("max_member_group",$field_name,$field_value);
	}
	elseif($what=="delete_group"){
		
		//Delete Group
		delete_row("max_member_group","mg_id='$mg_id' LIMIT 1"); 

		//Move all member in this group to Registered group (mg_id = 2)
		$mylist=set_array_from_query("max_ecuser","user_id","user_mg_id='$mg_id'");
		foreach($mylist as $array){
			update_field_in_db("max_ecuser","user_mg_id",2,"user_id='$array[user_id]' LIMIT 1");
		}

		//Remove mg_id inside each ec_group_relate_id
		$mylist=set_array_from_query("max_ecard","ec_id,ec_group_relate_id","ec_group_relate_id like '%,$mg_id,%'");
		foreach($mylist as $array){
			$new_ec_group_relate_id=str_replace(",$mg_id,",",",$array[ec_group_relate_id]);
			update_field_in_db("max_ecard","ec_group_relate_id",$new_ec_group_relate_id,"ec_id='$array[ec_id]' LIMIT 1");
		}

	}

	$list_data =set_array_from_query("max_member_group","*","mg_title<>'' Order by mg_id");
	$show_list_table="";
	$array_allow=array();
	foreach($list_data as $array){
		$val = $array[mg_id] ;
		$permission="<div style=\"padding:4px\">$member_group_txt_maximum_recipient <input onkeypress=\"return isNumberKey(event)\" onfocus=\"original_value=this.value;\" onchange=\"Editme('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_number_recipient&edit_value=',this.value,'2',original_value,this.id);\" type=\"text\" name=\"mg_number_recipient$val\" id=\"mg_number_recipient$val\" value=\"$array[mg_number_recipient]\" size=\"5\" /></div>";
		$permission.="<div style=\"padding:4px\">$member_group_txt_show_number_recipient_default <input onkeypress=\"return isNumberKey(event)\" onfocus=\"original_value=this.value;\" onchange=\"Editme('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_number_recipient_default&edit_value=',this.value,'2',original_value,this.id);\" type=\"text\" name=\"mg_number_recipient_default$val\" id=\"mg_number_recipient_default$val\" value=\"$array[mg_number_recipient_default]\" size=\"5\" /></div>";
		$permission.="<div style=\"padding:4px\">$member_group_txt_maximum_recipient_per_hour <input onkeypress=\"return isNumberKey(event)\" onfocus=\"original_value=this.value;\" onchange=\"Editme('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_number_recipient_per_hour&edit_value=',this.value,'20',original_value,this.id);\" type=\"text\" name=\"mg_number_recipient_per_hour$val\" id=\"mg_number_recipient_per_hour$val\" value=\"$array[mg_number_recipient_per_hour]\" size=\"5\" /> $member_group_txt_zero_is_unlimited</div>";
		$permission.="<div style=\"padding:4px\">$member_group_txt_maximum_recipient_per_day <input onkeypress=\"return isNumberKey(event)\" onfocus=\"original_value=this.value;\" onchange=\"Editme('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_number_recipient_per_day&edit_value=',this.value,'20',original_value,this.id);\" type=\"text\" name=\"mg_number_recipient_per_day$val\" id=\"mg_number_recipient_per_day$val\" value=\"$array[mg_number_recipient_per_day]\" size=\"5\" /> $member_group_txt_zero_is_unlimited</div>";
		
		if($val!=1){
			$permission.="<div style=\"padding:4px\">$member_group_txt_maximum_recipient_when_user_send_invitation_card <input onkeypress=\"return isNumberKey(event)\" onfocus=\"original_value=this.value;\" onchange=\"Editme('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_number_recipient_invite&edit_value=',this.value,'2',original_value,this.id);\" type=\"text\" name=\"mg_number_recipient_invite$val\" id=\"mg_number_recipient_invite$val\" value=\"$array[mg_number_recipient_invite]\" size=\"5\" /></div>";
			$permission.="<div style=\"padding:4px\">$member_group_txt_show_number_recipient_default_when_user_send_invitation <input onkeypress=\"return isNumberKey(event)\" onfocus=\"original_value=this.value;\" onchange=\"Editme('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_number_recipient_default_invite&edit_value=',this.value,'2',original_value,this.id);\" type=\"text\" name=\"mg_number_recipient_default_invite$val\" id=\"mg_number_recipient_default_invite$val\" value=\"$array[mg_number_recipient_default_invite]\" size=\"5\" /></div>";
			$permission.="<div style=\"padding:4px\">$member_group_txt_maximum_recipient_per_hour_invitation <input onkeypress=\"return isNumberKey(event)\" onfocus=\"original_value=this.value;\" onchange=\"Editme('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_number_recipient_per_hour_invite&edit_value=',this.value,'20',original_value,this.id);\" type=\"text\" name=\"mg_number_recipient_per_hour_invite$val\" id=\"mg_number_recipient_per_hour_invite$val\" value=\"$array[mg_number_recipient_per_hour_invite]\" size=\"5\" /> $member_group_txt_zero_is_unlimited</div>";
			$permission.="<div style=\"padding:4px\">$member_group_txt_maximum_recipient_per_day_invitation <input onkeypress=\"return isNumberKey(event)\" onfocus=\"original_value=this.value;\" onchange=\"Editme('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_number_recipient_per_day_invite&edit_value=',this.value,'20',original_value,this.id);\" type=\"text\" name=\"mg_number_recipient_per_day_invite$val\" id=\"mg_number_recipient_per_day_invite$val\" value=\"$array[mg_number_recipient_per_day_invite]\" size=\"5\" /> $member_group_txt_zero_is_unlimited</div>";
		}
		
		if($array[mg_allow_send_card]=="1"){
			$permission .="<input checked=\"checked\" type=\"checkbox\" onclick=\"ShowLoaderImage('$member_group_message_updating');if(this.checked){document.getElementById('mg_allow_send_card$val').style.color='black';UpdateDataTable('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_allow_send_card&edit_value=1');}else{document.getElementById('mg_allow_send_card$val').style.color='silver';UpdateDataTable('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_allow_send_card&edit_value=0');}\" /> <span id=\"mg_allow_send_card$val\" style=\"color:black\">$member_group_txt_allow_users_in_this_group_to_send_ecards</span><br />";
		}
		elseif ($array[mg_allow_send_card]!="1") {
			$permission .="<input type=\"checkbox\" onclick=\"ShowLoaderImage('$member_group_message_updating');if(this.checked){document.getElementById('mg_allow_send_card$val').style.color='black';UpdateDataTable('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_allow_send_card&edit_value=1');}else{document.getElementById('mg_allow_send_card$val').style.color='silver';UpdateDataTable('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_allow_send_card&edit_value=0');}\" /> <span id=\"mg_allow_send_card$val\" style=\"color:silver\">$member_group_txt_allow_users_in_this_group_to_send_ecards</span><br />";
		}

		if($array[mg_show_watermark]=="1"){
			$permission .="<input checked=\"checked\" type=\"checkbox\" onclick=\"ShowLoaderImage('$member_group_message_updating');if(this.checked){document.getElementById('mg_show_watermark$val').style.color='black';UpdateDataTable('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_show_watermark&edit_value=1');}else{document.getElementById('mg_show_watermark$val').style.color='silver';UpdateDataTable('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_show_watermark&edit_value=0');}\" /> <span id=\"mg_show_watermark$val\" style=\"color:black\">$member_group_txt_check_this_box_to_show_watermark_image_this_group</span><br />";
		}
		elseif($array[mg_show_watermark]!="1"){
			$permission .="<input type=\"checkbox\" onclick=\"ShowLoaderImage('$member_group_message_updating');if(this.checked){document.getElementById('mg_show_watermark$val').style.color='black';UpdateDataTable('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_show_watermark&edit_value=1');}else{document.getElementById('mg_show_watermark$val').style.color='silver';UpdateDataTable('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_show_watermark&edit_value=0');}\" /> <span id=\"mg_show_watermark$val\" style=\"color:silver\">$member_group_txt_check_this_box_to_show_watermark_image_this_group</span><br />";
		}

		if($array[mg_show_banner]=="1"){
			$permission .="<input checked=\"checked\" type=\"checkbox\" onclick=\"ShowLoaderImage('$member_group_message_updating');if(this.checked){document.getElementById('mg_show_banner$val').style.color='black';UpdateDataTable('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_show_banner&edit_value=1');}else{document.getElementById('mg_show_banner$val').style.color='silver';UpdateDataTable('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_show_banner&edit_value=0');}\" /> <span id=\"mg_show_banner$val\" style=\"color:black\">$member_group_txt_show_banner_ads_this_group</span><br />";
		}
		elseif($array[mg_show_banner]!="1"){
			$permission .="<input type=\"checkbox\" onclick=\"ShowLoaderImage('$member_group_message_updating');if(this.checked){document.getElementById('mg_show_banner$val').style.color='black';UpdateDataTable('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_show_banner&edit_value=1');}else{document.getElementById('mg_show_banner$val').style.color='silver';UpdateDataTable('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_show_banner&edit_value=0');}\" /> <span id=\"mg_show_banner$val\" style=\"color:silver\">$member_group_txt_show_banner_ads_this_group</span><br />";
		}

		if($array[mg_allow_game]=="1"){
			$permission .="<input checked=\"checked\" type=\"checkbox\" onclick=\"ShowLoaderImage('$member_group_message_updating');if(this.checked){document.getElementById('mg_allow_game$val').style.color='black';UpdateDataTable('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_allow_game&edit_value=1');}else{document.getElementById('mg_allow_game$val').style.color='silver';UpdateDataTable('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_allow_game&edit_value=0');}\" /> <span id=\"mg_allow_game$val\" style=\"color:black\">$member_group_txt_allow_to_play_games</span><br />";
		}
		elseif($array[mg_allow_game]!="1"){
			$permission .="<input type=\"checkbox\" onclick=\"ShowLoaderImage('$member_group_message_updating');if(this.checked){document.getElementById('mg_allow_game$val').style.color='black';UpdateDataTable('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_allow_game&edit_value=1');}else{document.getElementById('mg_allow_game$val').style.color='silver';UpdateDataTable('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_allow_game&edit_value=0');}\" /> <span id=\"mg_allow_game$val\" style=\"color:silver\">$member_group_txt_allow_to_play_games</span><br />";
		}

		if($array[mg_allow_grabber]=="1"){
			$permission .="<input checked=\"checked\" type=\"checkbox\" onclick=\"ShowLoaderImage('$member_group_message_updating');if(this.checked){document.getElementById('mg_allow_grabber$val').style.color='black';UpdateDataTable('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_allow_grabber&edit_value=1');}else{document.getElementById('mg_allow_grabber$val').style.color='silver';UpdateDataTable('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_allow_grabber&edit_value=0');}\" /> <span id=\"mg_allow_grabber$val\" style=\"color:black\">$member_group_txt_allow_to_use_media_grabber</span><br />";
		}
		elseif($array[mg_allow_grabber]!="1"){
			$permission .="<input type=\"checkbox\" onclick=\"ShowLoaderImage('$member_group_message_updating');if(this.checked){document.getElementById('mg_allow_grabber$val').style.color='black';UpdateDataTable('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_allow_grabber&edit_value=1');}else{document.getElementById('mg_allow_grabber$val').style.color='silver';UpdateDataTable('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_allow_grabber&edit_value=0');}\" /> <span id=\"mg_allow_grabber$val\" style=\"color:silver\">$member_group_txt_allow_to_use_media_grabber</span><br />";
		}

		if($array[mg_allow_search]=="1"){
			$permission .="<input checked=\"checked\" type=\"checkbox\" onclick=\"ShowLoaderImage('$member_group_message_updating');if(this.checked){document.getElementById('mg_allow_search$val').style.color='black';UpdateDataTable('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_allow_search&edit_value=1');}else{document.getElementById('mg_allow_search$val').style.color='silver';UpdateDataTable('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_allow_search&edit_value=0');}\" /> <span id=\"mg_allow_search$val\" style=\"color:black\">$member_group_txt_allow_to_search_ecard_invitation</span><br />";
		}
		elseif($array[mg_allow_search]!="1"){
			$permission .="<input type=\"checkbox\" onclick=\"ShowLoaderImage('$member_group_message_updating');if(this.checked){document.getElementById('mg_allow_search$val').style.color='black';UpdateDataTable('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_allow_search&edit_value=1');}else{document.getElementById('mg_allow_search$val').style.color='silver';UpdateDataTable('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_allow_search&edit_value=0');}\" /> <span id=\"mg_allow_search$val\" style=\"color:silver\">$member_group_txt_allow_to_search_ecard_invitation</span><br />";
		}		

		if($array[mg_allow_futuredate]=="1"){
			$permission .="<input checked=\"checked\" type=\"checkbox\" onclick=\"ShowLoaderImage('$member_group_message_updating');if(this.checked){document.getElementById('mg_allow_futuredate$val').style.color='black';UpdateDataTable('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_allow_futuredate&edit_value=1');}else{document.getElementById('mg_allow_futuredate$val').style.color='silver';UpdateDataTable('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_allow_futuredate&edit_value=0');}\" /> <span id=\"mg_allow_futuredate$val\" style=\"color:black\">$member_group_txt_allow_to_send_future_date</span><br />";
		}
		elseif($array[mg_allow_futuredate]!="1"){
			$permission .="<input type=\"checkbox\" onclick=\"ShowLoaderImage('$member_group_message_updating');if(this.checked){document.getElementById('mg_allow_futuredate$val').style.color='black';UpdateDataTable('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_allow_futuredate&edit_value=1');}else{document.getElementById('mg_allow_futuredate$val').style.color='silver';UpdateDataTable('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_allow_futuredate&edit_value=0');}\" /> <span id=\"mg_allow_futuredate$val\" style=\"color:silver\">$member_group_txt_allow_to_send_future_date</span><br />";
		}

		if($array[mg_allow_rate]=="1"){
			$permission .="<input checked=\"checked\" type=\"checkbox\" onclick=\"ShowLoaderImage('$member_group_message_updating');if(this.checked){document.getElementById('mg_allow_rate$val').style.color='black';UpdateDataTable('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_allow_rate&edit_value=1');}else{document.getElementById('mg_allow_rate$val').style.color='silver';UpdateDataTable('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_allow_rate&edit_value=0');}\" /> <span id=\"mg_allow_rate$val\" style=\"color:black\">$member_group_txt_allow_to_rate_card</span><br />";
		}
		elseif($array[mg_allow_rate]!="1"){
			$permission .="<input type=\"checkbox\" onclick=\"ShowLoaderImage('$member_group_message_updating');if(this.checked){document.getElementById('mg_allow_rate$val').style.color='black';UpdateDataTable('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_allow_rate&edit_value=1');}else{document.getElementById('mg_allow_rate$val').style.color='silver';UpdateDataTable('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_allow_rate&edit_value=0');}\" /> <span id=\"mg_allow_rate$val\" style=\"color:silver\">$member_group_txt_allow_to_rate_card</span><br />";
		}

		if($array[mg_allow_viewfullsize]=="1"){
			$permission .="<input checked=\"checked\" type=\"checkbox\" onclick=\"ShowLoaderImage('$member_group_message_updating');if(this.checked){document.getElementById('mg_allow_viewfullsize$val').style.color='black';UpdateDataTable('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_allow_viewfullsize&edit_value=1');}else{document.getElementById('mg_allow_viewfullsize$val').style.color='silver';UpdateDataTable('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_allow_viewfullsize&edit_value=0');}\" /> <span id=\"mg_allow_viewfullsize$val\" style=\"color:black\">$member_group_txt_allow_to_use_preview_fullsize</span><br />";
		}
		elseif($array[mg_allow_viewfullsize]!="1"){
			$permission .="<input type=\"checkbox\" onclick=\"ShowLoaderImage('$member_group_message_updating');if(this.checked){document.getElementById('mg_allow_viewfullsize$val').style.color='black';UpdateDataTable('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_allow_viewfullsize&edit_value=1');}else{document.getElementById('mg_allow_viewfullsize$val').style.color='silver';UpdateDataTable('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_allow_viewfullsize&edit_value=0');}\" /> <span id=\"mg_allow_viewfullsize$val\" style=\"color:silver\">$member_group_txt_allow_to_use_preview_fullsize</span><br />";
		}
		
		if($val=="1"){
			$guest_disable="disabled=\"disabled\"";
			$style_disable=";text-decoration:line-through;";
		}
		else{
			$guest_disable="";
			$style_disable="";
		}
		if($array[mg_allow_myaccount]=="1"){
			$permission .="<input $guest_disable checked=\"checked\" type=\"checkbox\" onclick=\"ShowLoaderImage('$member_group_message_updating');if(this.checked){document.getElementById('mg_allow_myaccount$val').style.color='black';UpdateDataTable('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_allow_myaccount&edit_value=1');}else{document.getElementById('mg_allow_myaccount$val').style.color='silver';UpdateDataTable('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_allow_myaccount&edit_value=0');}\" /> <span id=\"mg_allow_myaccount$val\" style=\"color:black$style_disable\">$member_group_txt_allow_to_use_my_account</span><br />";
		}
		elseif($array[mg_allow_myaccount]!="1"){
			$permission .="<input $guest_disable type=\"checkbox\" onclick=\"ShowLoaderImage('$member_group_message_updating');if(this.checked){document.getElementById('mg_allow_myaccount$val').style.color='black';UpdateDataTable('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_allow_myaccount&edit_value=1');}else{document.getElementById('mg_allow_myaccount$val').style.color='silver';UpdateDataTable('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_allow_myaccount&edit_value=0');}\" /> <span id=\"mg_allow_myaccount$val\" style=\"color:silver$style_disable\">$member_group_txt_allow_to_use_my_account</span><br />";
		}		

		if($array[mg_allow_addressbook]=="1"){
			$permission .="<input $guest_disable checked=\"checked\" type=\"checkbox\" onclick=\"ShowLoaderImage('$member_group_message_updating');if(this.checked){document.getElementById('mg_allow_addressbook$val').style.color='black';UpdateDataTable('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_allow_addressbook&edit_value=1');}else{document.getElementById('mg_allow_addressbook$val').style.color='silver';UpdateDataTable('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_allow_addressbook&edit_value=0');}\" /> <span id=\"mg_allow_addressbook$val\" style=\"color:black$style_disable\">$member_group_txt_allow_to_use_address_book</span><br />";
		}
		elseif($array[mg_allow_addressbook]!="1"){
			$permission .="<input $guest_disable type=\"checkbox\" onclick=\"ShowLoaderImage('$member_group_message_updating');if(this.checked){document.getElementById('mg_allow_addressbook$val').style.color='black';UpdateDataTable('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_allow_addressbook&edit_value=1');}else{document.getElementById('mg_allow_addressbook$val').style.color='silver';UpdateDataTable('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_allow_addressbook&edit_value=0');}\" /> <span id=\"mg_allow_addressbook$val\" style=\"color:silver$style_disable\">$member_group_txt_allow_to_use_address_book</span><br />";
		}

		if($array[mg_allow_reminder]=="1"){
			$permission .="<input $guest_disable checked=\"checked\" type=\"checkbox\" onclick=\"ShowLoaderImage('$member_group_message_updating');if(this.checked){document.getElementById('mg_allow_reminder$val').style.color='black';UpdateDataTable('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_allow_reminder&edit_value=1');}else{document.getElementById('mg_allow_reminder$val').style.color='silver';UpdateDataTable('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_allow_reminder&edit_value=0');}\" /> <span id=\"mg_allow_reminder$val\" style=\"color:black$style_disable\">$member_group_txt_allow_to_use_reminder</span><br />";
		}
		elseif($array[mg_allow_reminder]!="1"){
			$permission .="<input $guest_disable type=\"checkbox\" onclick=\"ShowLoaderImage('$member_group_message_updating');if(this.checked){document.getElementById('mg_allow_reminder$val').style.color='black';UpdateDataTable('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_allow_reminder&edit_value=1');}else{document.getElementById('mg_allow_reminder$val').style.color='silver';UpdateDataTable('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_allow_reminder&edit_value=0');}\" /> <span id=\"mg_allow_reminder$val\" style=\"color:silver$style_disable\">$member_group_txt_allow_to_use_reminder</span><br />";
		}

		if($array[mg_allow_calendar]=="1"){
			$permission .="<input $guest_disable checked=\"checked\" type=\"checkbox\" onclick=\"ShowLoaderImage('$member_group_message_updating');if(this.checked){document.getElementById('mg_allow_calendar$val').style.color='black';UpdateDataTable('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_allow_calendar&edit_value=1');}else{document.getElementById('mg_allow_calendar$val').style.color='silver';UpdateDataTable('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_allow_calendar&edit_value=0');}\" /> <span id=\"mg_allow_calendar$val\" style=\"color:black$style_disable\">$member_group_txt_allow_to_use_calendar</span><br />";
		}
		elseif($array[mg_allow_calendar]!="1"){
			$permission .="<input $guest_disable type=\"checkbox\" onclick=\"ShowLoaderImage('$member_group_message_updating');if(this.checked){document.getElementById('mg_allow_calendar$val').style.color='black';UpdateDataTable('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_allow_calendar&edit_value=1');}else{document.getElementById('mg_allow_calendar$val').style.color='silver';UpdateDataTable('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_allow_calendar&edit_value=0');}\" /> <span id=\"mg_allow_calendar$val\" style=\"color:silver$style_disable\">$member_group_txt_allow_to_use_calendar</span><br />";
		}

		if($array[mg_allow_myalbum]=="1"){
			$permission .="<input $guest_disable checked=\"checked\" type=\"checkbox\" onclick=\"ShowLoaderImage('$member_group_message_updating');if(this.checked){document.getElementById('mg_allow_myalbum$val').style.color='black';UpdateDataTable('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_allow_myalbum&edit_value=1');}else{document.getElementById('mg_allow_myalbum$val').style.color='silver';UpdateDataTable('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_allow_myalbum&edit_value=0');}\" /> <span id=\"mg_allow_myalbum$val\" style=\"color:black$style_disable\">$member_group_txt_allow_to_use_my_album</span><br />";
		}
		elseif($array[mg_allow_myalbum]!="1"){
			$permission .="<input $guest_disable type=\"checkbox\" onclick=\"ShowLoaderImage('$member_group_message_updating');if(this.checked){document.getElementById('mg_allow_myalbum$val').style.color='black';UpdateDataTable('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_allow_myalbum&edit_value=1');}else{document.getElementById('mg_allow_myalbum$val').style.color='silver';UpdateDataTable('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_allow_myalbum&edit_value=0');}\" /> <span id=\"mg_allow_myalbum$val\" style=\"color:silver$style_disable\">$member_group_txt_allow_to_use_my_album</span><br />";
		}

		if($array[mg_allow_favorite]=="1"){
			$permission .="<input $guest_disable checked=\"checked\" type=\"checkbox\" onclick=\"ShowLoaderImage('$member_group_message_updating');if(this.checked){document.getElementById('mg_allow_favorite$val').style.color='black';UpdateDataTable('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_allow_favorite&edit_value=1');}else{document.getElementById('mg_allow_favorite$val').style.color='silver';UpdateDataTable('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_allow_favorite&edit_value=0');}\" /> <span id=\"mg_allow_favorite$val\" style=\"color:black$style_disable\">$member_group_txt_allow_to_use_favorite</span><br />";
		}
		elseif($array[mg_allow_favorite]!="1"){
			$permission .="<input $guest_disable type=\"checkbox\" onclick=\"ShowLoaderImage('$member_group_message_updating');if(this.checked){document.getElementById('mg_allow_favorite$val').style.color='black';UpdateDataTable('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_allow_favorite&edit_value=1');}else{document.getElementById('mg_allow_favorite$val').style.color='silver';UpdateDataTable('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_allow_favorite&edit_value=0');}\" /> <span id=\"mg_allow_favorite$val\" style=\"color:silver$style_disable\">$member_group_txt_allow_to_use_favorite</span><br />";
		}

		if($array[mg_allow_history]=="1"){
			$permission .="<input $guest_disable checked=\"checked\" type=\"checkbox\" onclick=\"ShowLoaderImage('$member_group_message_updating');if(this.checked){document.getElementById('mg_allow_history$val').style.color='black';UpdateDataTable('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_allow_history&edit_value=1');}else{document.getElementById('mg_allow_history$val').style.color='silver';UpdateDataTable('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_allow_history&edit_value=0');}\" /> <span id=\"mg_allow_history$val\" style=\"color:black$style_disable\">$member_group_txt_allow_to_use_history</span><br />";
		}
		elseif($array[mg_allow_history]!="1"){
			$permission .="<input $guest_disable type=\"checkbox\" onclick=\"ShowLoaderImage('$member_group_message_updating');if(this.checked){document.getElementById('mg_allow_history$val').style.color='black';UpdateDataTable('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_allow_history&edit_value=1');}else{document.getElementById('mg_allow_history$val').style.color='silver';UpdateDataTable('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_allow_history&edit_value=0');}\" /> <span id=\"mg_allow_history$val\" style=\"color:silver$style_disable\">$member_group_txt_allow_to_use_history</span><br />";
		}

		if($array[mg_allow_birthdayalert]=="1"){
			$permission .="<input $guest_disable checked=\"checked\" type=\"checkbox\" onclick=\"ShowLoaderImage('$member_group_message_updating');if(this.checked){document.getElementById('mg_allow_birthdayalert$val').style.color='black';UpdateDataTable('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_allow_birthdayalert&edit_value=1');}else{document.getElementById('mg_allow_birthdayalert$val').style.color='silver';UpdateDataTable('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_allow_birthdayalert&edit_value=0');}\" /> <span id=\"mg_allow_birthdayalert$val\" style=\"color:black$style_disable\">$member_group_txt_allow_to_use_birthday_alert</span><br />";
		}
		elseif($array[mg_allow_birthdayalert]!="1"){
			$permission .="<input $guest_disable type=\"checkbox\" onclick=\"ShowLoaderImage('$member_group_message_updating');if(this.checked){document.getElementById('mg_allow_birthdayalert$val').style.color='black';UpdateDataTable('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_allow_birthdayalert&edit_value=1');}else{document.getElementById('mg_allow_birthdayalert$val').style.color='silver';UpdateDataTable('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_allow_birthdayalert&edit_value=0');}\" /> <span id=\"mg_allow_birthdayalert$val\" style=\"color:silver$style_disable\">$member_group_txt_allow_to_use_birthday_alert</span><br />";
		}

		if($array[mg_allow_2subaccount]=="1" && $val!="2"){
			$permission .="<input $guest_disable checked=\"checked\" type=\"checkbox\" onclick=\"ShowLoaderImage('$member_group_message_updating');if(this.checked){document.getElementById('mg_allow_2subaccount$val').style.color='black';UpdateDataTable('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_allow_2subaccount&edit_value=1');}else{document.getElementById('mg_allow_2subaccount$val').style.color='silver';UpdateDataTable('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_allow_2subaccount&edit_value=0');}\" /> <span id=\"mg_allow_2subaccount$val\" style=\"color:black$style_disable\">$member_group_txt_allow_to_create_2_sub_accounts</span><br />";
		}
		elseif($array[mg_allow_2subaccount]!="1"){
			if($val=="2" || $val=="1"){
				$permission .="<input disabled=\"disabled\" type=\"checkbox\" onclick=\"ShowLoaderImage('$member_group_message_updating');if(this.checked){document.getElementById('mg_allow_2subaccount$val').style.color='black';UpdateDataTable('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_allow_2subaccount&edit_value=1');}else{document.getElementById('mg_allow_2subaccount$val').style.color='silver';UpdateDataTable('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_allow_2subaccount&edit_value=0');}\" /> <span id=\"mg_allow_2subaccount$val\" style=\"color:silver;text-decoration:line-through;\">$member_group_txt_allow_to_create_2_sub_accounts</span><br />";
			}
			else{
				$permission .="<input $guest_disable type=\"checkbox\" onclick=\"ShowLoaderImage('$member_group_message_updating');if(this.checked){document.getElementById('mg_allow_2subaccount$val').style.color='black';UpdateDataTable('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_allow_2subaccount&edit_value=1');}else{document.getElementById('mg_allow_2subaccount$val').style.color='silver';UpdateDataTable('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_allow_2subaccount&edit_value=0');}\" /> <span id=\"mg_allow_2subaccount$val\" style=\"color:silver$style_disable\">$member_group_txt_allow_to_create_2_sub_accounts</span><br />";
			}
		}
		if($array[mg_allow_send_birthday_to_group]=="1"){
			$permission .="<input $guest_disable checked=\"checked\" type=\"checkbox\" onclick=\"ShowLoaderImage('$member_group_message_updating');if(this.checked){document.getElementById('mg_allow_send_birthday_to_group$val').style.color='black';UpdateDataTable('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_allow_send_birthday_to_group&edit_value=1');}else{document.getElementById('mg_allow_send_birthday_to_group$val').style.color='silver';UpdateDataTable('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_allow_send_birthday_to_group&edit_value=0');}\" /> <span id=\"mg_allow_send_birthday_to_group$val\" style=\"color:black$style_disable\">$member_group_txt_allow_to_send_birthday_card_to_group</span><br />";
		}else if($array[mg_allow_send_birthday_to_group]!="1"){
			$permission .="<input $guest_disable type=\"checkbox\" onclick=\"ShowLoaderImage('$member_group_message_updating');if(this.checked){document.getElementById('mg_allow_send_birthday_to_group$val').style.color='black';UpdateDataTable('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_allow_send_birthday_to_group&edit_value=1');}else{document.getElementById('mg_allow_send_birthday_to_group$val').style.color='silver';UpdateDataTable('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_allow_send_birthday_to_group&edit_value=0');}\" /> <span id=\"mg_allow_send_birthday_to_group$val\" style=\"color:silver$style_disable\">$member_group_txt_allow_to_send_birthday_card_to_group</span><br />";			
		}
		
		//twitter
		if($array[mg_allow_to_share_card_with_twitter]=="1"){
			$permission .="<input checked=\"checked\" type=\"checkbox\" onclick=\"ShowLoaderImage('$member_group_message_updating');if(this.checked){document.getElementById('mg_allow_to_share_card_with_twitter$val').style.color='black';UpdateDataTable('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_allow_to_share_card_with_twitter&edit_value=1');}else{document.getElementById('mg_allow_to_share_card_with_twitter$val').style.color='silver';UpdateDataTable('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_allow_to_share_card_with_twitter&edit_value=0');}\" /> <span id=\"mg_allow_to_share_card_with_twitter$val\" style=\"color:black\">$member_group_txt_allow_to_share_card_with_twitter</span><br />";
		}
		elseif($array[mg_allow_to_share_card_with_twitter]!="1"){
			$permission .="<input type=\"checkbox\" onclick=\"ShowLoaderImage('$member_group_message_updating');if(this.checked){document.getElementById('mg_allow_to_share_card_with_twitter$val').style.color='black';UpdateDataTable('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_allow_to_share_card_with_twitter&edit_value=1');}else{document.getElementById('mg_allow_to_share_card_with_twitter$val').style.color='silver';UpdateDataTable('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_allow_to_share_card_with_twitter&edit_value=0');}\" /> <span id=\"mg_allow_to_share_card_with_twitter$val\" style=\"color:silver\">$member_group_txt_allow_to_share_card_with_twitter</span><br />";
		}
		
		//facebook
		if($array[mg_allow_to_share_card_with_facebook]=="1"){
			$permission .="<input checked=\"checked\" type=\"checkbox\" onclick=\"ShowLoaderImage('$member_group_message_updating');if(this.checked){document.getElementById('mg_allow_to_share_card_with_facebook$val').style.color='black';UpdateDataTable('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_allow_to_share_card_with_facebook&edit_value=1');}else{document.getElementById('mg_allow_to_share_card_with_facebook$val').style.color='silver';UpdateDataTable('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_allow_to_share_card_with_facebook&edit_value=0');}\" /> <span id=\"mg_allow_to_share_card_with_facebook$val\" style=\"color:black\">$member_group_txt_allow_to_share_card_with_facebook</span><br />";
		}
		elseif($array[mg_allow_to_share_card_with_facebook]!="1"){
			$permission .="<input type=\"checkbox\" onclick=\"ShowLoaderImage('$member_group_message_updating');if(this.checked){document.getElementById('mg_allow_to_share_card_with_facebook$val').style.color='black';UpdateDataTable('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_allow_to_share_card_with_facebook&edit_value=1');}else{document.getElementById('mg_allow_to_share_card_with_facebook$val').style.color='silver';UpdateDataTable('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_allow_to_share_card_with_facebook&edit_value=0');}\" /> <span id=\"mg_allow_to_share_card_with_facebook$val\" style=\"color:silver\">$member_group_txt_allow_to_share_card_with_facebook</span><br />";
		}
		
		//googleplus
		if($array[mg_allow_to_share_card_with_googleplus]=="1"){
			$permission .="<input checked=\"checked\" type=\"checkbox\" onclick=\"ShowLoaderImage('$member_group_message_updating');if(this.checked){document.getElementById('mg_allow_to_share_card_with_googleplus$val').style.color='black';UpdateDataTable('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_allow_to_share_card_with_googleplus&edit_value=1');}else{document.getElementById('mg_allow_to_share_card_with_googleplus$val').style.color='silver';UpdateDataTable('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_allow_to_share_card_with_googleplus&edit_value=0');}\" /> <span id=\"mg_allow_to_share_card_with_googleplus$val\" style=\"color:black\">$member_group_txt_allow_to_share_card_with_googleplus</span><br />";
		}
		elseif($array[mg_allow_to_share_card_with_googleplus]!="1"){
			$permission .="<input type=\"checkbox\" onclick=\"ShowLoaderImage('$member_group_message_updating');if(this.checked){document.getElementById('mg_allow_to_share_card_with_googleplus$val').style.color='black';UpdateDataTable('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_allow_to_share_card_with_googleplus&edit_value=1');}else{document.getElementById('mg_allow_to_share_card_with_googleplus$val').style.color='silver';UpdateDataTable('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_allow_to_share_card_with_googleplus&edit_value=0');}\" /> <span id=\"mg_allow_to_share_card_with_googleplus$val\" style=\"color:silver\">$member_group_txt_allow_to_share_card_with_googleplus</span><br />";
		}
		
		//linkedin
		if($array[mg_allow_to_share_card_with_linkedin]=="1"){
			$permission .="<input checked=\"checked\" type=\"checkbox\" onclick=\"ShowLoaderImage('$member_group_message_updating');if(this.checked){document.getElementById('mg_allow_to_share_card_with_linkedin$val').style.color='black';UpdateDataTable('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_allow_to_share_card_with_linkedin&edit_value=1');}else{document.getElementById('mg_allow_to_share_card_with_linkedin$val').style.color='silver';UpdateDataTable('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_allow_to_share_card_with_linkedin&edit_value=0');}\" /> <span id=\"mg_allow_to_share_card_with_linkedin$val\" style=\"color:black\">$member_group_txt_allow_to_share_card_with_linkedin</span><br />";
		}
		elseif($array[mg_allow_to_share_card_with_linkedin]!="1"){
			$permission .="<input type=\"checkbox\" onclick=\"ShowLoaderImage('$member_group_message_updating');if(this.checked){document.getElementById('mg_allow_to_share_card_with_linkedin$val').style.color='black';UpdateDataTable('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_allow_to_share_card_with_linkedin&edit_value=1');}else{document.getElementById('mg_allow_to_share_card_with_linkedin$val').style.color='silver';UpdateDataTable('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_allow_to_share_card_with_linkedin&edit_value=0');}\" /> <span id=\"mg_allow_to_share_card_with_linkedin$val\" style=\"color:silver\">$member_group_txt_allow_to_share_card_with_linkedin</span><br />";
		}
		
		
		if($val!="1" && $val!="2"){
			$permission.="<div style=\"padding:4px\">$member_group_txt_membership_payment_amount $cf_currecy<input onkeypress=\"return isMoney(event)\" onfocus=\"original_value=this.value;\" onchange=\"CheckPaymentAmount(this.value,'$val');\" type=\"text\" name=\"mg_payment_amount$val\" id=\"mg_payment_amount$val\" value=\"$array[mg_payment_amount]\" size=\"5\" /></div>";
			$permission.="<div style=\"padding:4px\">$member_group_txt_buy_now_title_1 <input onfocus=\"original_value=this.value;\" onchange=\"Editme('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_buynow_title1&edit_value=',this.value,'1',original_value,this.id);\" type=\"text\" name=\"mg_buynow_title1$val\" id=\"mg_buynow_title1$val\" value=\"$array[mg_buynow_title1]\" size=\"50\" /></div>";
			$permission.="<div style=\"padding:4px\">$member_group_txt_buy_now_link_1<br /><textarea onkeypress=\"return noEnterKey(event)\" onfocus=\"original_value=this.value;\" onchange=\"Editme('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_payment_method1&edit_value=',this.value,'1',original_value,this.id);\" name=\"mg_payment_method1$val\" id=\"mg_payment_method1$val\" style=\"width:400px;height:100px;\">$array[mg_payment_method1]</textarea></div>";
			$permission.="<div style=\"padding:4px\">$member_group_txt_buy_now_title_2 <input onfocus=\"original_value=this.value;\" onchange=\"Editme('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_buynow_title2&edit_value=',this.value,'0',original_value,this.id);\" type=\"text\" name=\"mg_buynow_title2$val\" id=\"mg_buynow_title2$val\" value=\"$array[mg_buynow_title2]\" size=\"50\" /></div>";
			$permission.="<div style=\"padding:4px\">$member_group_txt_buy_now_link_2<br /><textarea onkeypress=\"return noEnterKey(event)\" onfocus=\"original_value=this.value;\" onchange=\"Editme('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_payment_method2&edit_value=',this.value,'0',original_value,this.id);\" name=\"mg_payment_method2$val\" id=\"mg_payment_method2$val\" style=\"width:400px;height:100px;\">$array[mg_payment_method2]</textarea></div>";
			$dropdown_dataclose="<select size=\"1\" name=\"mg_dateclose$val\" id=\"mg_dateclose$val\" onchange=\"Editme('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_dateclose&edit_value=',this.value,'0',1,this.id);\" >";
			if($array[mg_dateclose]=="0"){
				$dropdown_dataclose.="<option selected=\"selected\" value=\"0\">$member_group_txt_forever</option>";
			}
			else{
				$dropdown_dataclose.="<option value=\"0\">$member_group_txt_forever</option>";
			}
			if($array[mg_dateclose]=="1"){
				$dropdown_dataclose.="<option selected=\"selected\" value=\"1\">1 $member_group_txt_month</option>";
			}
			else{
				$dropdown_dataclose.="<option value=\"1\">1 $member_group_txt_month</option>";
			}
			if($array[mg_dateclose]=="2"){
				$dropdown_dataclose.="<option selected=\"selected\" value=\"2\">3 $member_group_txt_months</option>";
			}
			else{
				$dropdown_dataclose.="<option value=\"2\">3 $member_group_txt_months</option>";
			}
			if($array[mg_dateclose]=="3"){
				$dropdown_dataclose.="<option selected=\"selected\" value=\"3\">6 $member_group_txt_months</option>";
			}
			else{
				$dropdown_dataclose.="<option value=\"3\">6 $member_group_txt_months</option>";
			}
			if($array[mg_dateclose]=="4"){
				$dropdown_dataclose.="<option selected=\"selected\" value=\"4\">1 $member_group_txt_year</option>";
			}
			else{
				$dropdown_dataclose.="<option value=\"4\">1 $member_group_txt_year</option>";
			}
			if($array[mg_dateclose]=="5"){
				$dropdown_dataclose.="<option selected=\"selected\" value=\"5\">2 $member_group_txt_years</option>";
			}
			else{
				$dropdown_dataclose.="<option value=\"5\">2 $member_group_txt_years</option>";
			}
			$dropdown_dataclose.="</select>";
			$permission.="<div style=\"padding:4px\">$member_group_txt_set_time_auto_expired $dropdown_dataclose</div>";

		}
		
		if($val=="1" || $val=="2"){
			/*$delete="<select size=\"1\" name=\"mg_dateclose\" id=\"mg_dateclose\">
				<option value=\"1\">Enable</option>
				<option value=\"0\">Disable</option>
				</select>";*/
			$delete = "-";
		}
		else{
			$delete="<input $disable_delete class=\"button\" type=\"button\" value=\"$member_group_button_delete\" onclick=\"document.getElementById('tr$val').style.backgroundColor='#E8E8DA';if (window.confirm('$member_group_message_confirm_to_delete_group')){location.href='index.php?step=$step&what=delete_group&mg_id=$val';}else{document.getElementById('tr$val').style.backgroundColor='#EAEAEA';}\" />";			
			$bk_id .="$val,";
		}
		
		//Show member group title
		$show_title="<input id=\"mg_title$val\" title=\"$member_group_tooltip_click_to_edit_group_title\" type=\"text\" value=\"$array[mg_title]\" style=\"border:0px;background-color:#EAEAEA;cursor:pointer;width:300px;text-decoration:underline;\" onfocus=\"original_value=this.value;this.style.border='1px solid silver';this.style.textDecoration='none';this.style.cursor='text';\" onblur=\"this.style.border='0px';this.style.textDecoration='underline';this.style.cursor='pointer';\" onchange=\"Editme('index.php?step=edit_me&table=max_member_group&edit_id=mg_id&edit_id_value=$val&edit_key=mg_title&edit_value=',this.value,'1',original_value,this.id);\" />";

		$show_list_table .="<tr id=\"tr$val\" style=\"background-color: #EAEAEA;line-height:20px\">\n";	
		$show_list_table .="<td valign=\"top\" width=\"260\">$show_title</td>\n";
		$show_list_table .="<td  width=\"*\" style=\"font-size:8pt\">$permission</td>\n";
		$show_list_table .="<td valign=\"top\" align=\"center\">$delete</td>\n";
		$show_list_table .="</tr>\n";
	}
	if($bk_id{strlen($bk_id)-1} ==",") $bk_id = substr($bk_id, 0, strlen($bk_id)-1);

	set_global_var("show_onload_javascript","onkeypress=\"return noGlobalEnterKey(event)\"");
	set_global_var("print_object",get_html_from_layout("admin/html/admin_member_group.html"));
	print_admin_header_footer_page();

?>
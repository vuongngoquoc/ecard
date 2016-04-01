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
	$user_row=get_row("max_ecuser","*","user_id='$user_id'");
	if($action=="edit_me"){
		update_field_in_db("max_addressbook","$edit_key",$edit_key_value,"$edit_id='$edit_id_value' and book_user_name_id='$user_row[user_name_id]' LIMIT 1");
		exit;
	}
	elseif($action=="update_book_birthday"){
		list($get_mon,$get_day,$get_year)=split("\/",$time_end_textbox);
		update_field_in_db2("max_addressbook","book_birth_mon='$get_mon',book_birth_mday='$get_day',book_birth_year='$get_year'", "book_id='$book_id' and book_user_name_id='$user_row[user_name_id]'");
		exit;
	}
	elseif($action=="update_book_anni"){
		list($get_mon,$get_day,$get_year)=split("\/",$time_end_textbox);
		update_field_in_db2("max_addressbook","book_special_mon='$get_mon',book_special_mday='$get_day',book_special_year='$get_year'", "book_id='$book_id' and book_user_name_id='$user_row[user_name_id]'");
		exit;
	}

	$book_row=get_row("max_addressbook","*","book_email='$book_email' and book_user_name_id='$user_row[user_name_id]'");
	if($book_row[book_id]!=""){
		foreach($book_row as $key=>$val){
			set_global_var($key,$val);
		}
		$show_birthday_alert_dob_message=str_replace("%sender_name%","<strong>$user_row[user_name] $user_row[user_last_name]</strong>",$birthday_alert_dob_message);
		if($book_row[book_birth_mon]>0 && $book_row[book_birth_mday]>0){
			if($book_row[book_birth_year]>0){
				$show_user_birthday="$book_row[book_birth_mon]/$book_row[book_birth_mday]/$book_row[book_birth_year]";
			}
			else{
				$show_user_birthday="$book_row[book_birth_mon]/$book_row[book_birth_mday]/$today_year";
			}
		}
		else{
			$show_user_birthday="MM/DD/YYYY";
		}

		if($book_row[book_special_mon]>0 && $book_row[book_special_mday]>0){
			if($book_row[book_special_year]>0){
				$show_user_anni="$book_row[book_special_mon]/$book_row[book_special_mday]/$book_row[book_special_year]";
			}
			else{
				$show_user_anni="$book_row[book_special_mon]/$book_row[book_special_mday]/$today_year";
			}
		}
		else{
			$show_user_anni="MM/DD/YYYY";
		}

		$display_thumbnail=get_html_from_layout("templates/$cf_set_template/show_dob.html");
	}
	else{
		$display_thumbnail="<div class=\"Error_Message\">Error! There is no email $book_email found in this user addressbook $user_row[user_name] $user_row[user_last_name]</div>";
	}
?>
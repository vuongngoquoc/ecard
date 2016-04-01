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
	
	//Display category menu
	require_once ("show_category.php");
	if($isResponsive) 
	{
		get_category_2_level($cat_id,$cat_id_hilight);
	}
	function genRandomString() {
		$length = 8;
		$characters = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ~!@#$%^&*";
		$string = "";    

		for ($p = 0; $p < $length; $p++) {
			$string .= $characters[mt_rand(0, strlen($characters))];
		}

		return $string;
}
	if($step=="popular"){
		// DO NOT REMOVE THIS VALUE
		$item_width=round(100 / $cf_pic_per_row) . "%";
		$show_list_of_thumbnails=print_thumbnail("show_popular");
		$display_thumbnail=get_html_from_layout("templates/$cf_set_template/show_thumbnail_sub_category.html");
	}
	elseif($step=="top_rate"){
		// DO NOT REMOVE THIS VALUE
		$item_width=round(100 / $cf_pic_per_row) . "%";
		$show_list_of_thumbnails=print_thumbnail("show_top_rate");
		$display_thumbnail=get_html_from_layout("templates/$cf_set_template/show_thumbnail_sub_category.html");
	}
	elseif($step=="new_ecards"){
		// DO NOT REMOVE THIS VALUE
		$item_width=round(100 / $cf_pic_per_row) . "%";
		$show_list_of_thumbnails=print_thumbnail("show_new_ecards");
		$display_thumbnail=get_html_from_layout("templates/$cf_set_template/show_thumbnail_sub_category.html");
	}
	elseif($step=="random_card"){
		// DO NOT REMOVE THIS VALUE
		$item_width=round(100 / $cf_pic_per_row) . "%";
		$show_list_of_thumbnails=print_thumbnail("random_card2");
		$display_thumbnail=get_html_from_layout("templates/$cf_set_template/show_thumbnail_sub_category.html");
	}
	elseif($step=="search_ecard"){
		if($_SESSION[mg_allow_search]=="1"){
			$keyword =stripslashes($keyword);
			set_global_var("keyword",$keyword);
			// DO NOT REMOVE THIS VALUE
			$item_width=round(100 / $cf_pic_per_row) . "%";
			$display_title_thumbnail = "<h1 class='table_title_bar' id='title-1'>$txt_search_results</h1>";
			set_global_var('display_title_thumbnail',$display_title_thumbnail);
			$display_thumbnail=print_thumbnail("show_search_ecard");
		}
		else{
			//Go to page update your account
			header("Location:".get_global_var(url_update_your_account)."\n");
			exit;
		}
	}
	elseif($step=="send_card_over_limit"){
		$display_thumbnail=$txt_send_card_over_limit_message;
	}
	elseif($step=="blacklist"){
		require_once ("show_blacklist.php");
	}
	elseif($step=="verify_account"){
		require_once ("show_verify_account.php");
	}
	elseif($step=="pickup"){
		$url_send="http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
	set_global_var("navigator_link","<a href=\"".get_global_var(url_home)."\">$txt_home</a> <img border=\"0\" alt=\"\" src=\"$ecard_url/templates/$cf_set_template/arrow_nav.gif\" style=\"vertical-align:middle\" /> <a href=\"".$url_send."\">Pickup</a>");
		require_once ("show_pickup.php");
	}
	elseif($step=="tell_friends"){
		require_once ("show_tell_friends.php");
	}
	elseif($step=="newsletter"){
		require_once ("show_newsletter.php");
	}
	elseif($step=="feedback"){
		require_once ("show_feedback.php");
	}
	elseif($step=="dob"){
		require_once ("show_dob.php");
	}
	elseif($step=="join_now"){
		require_once ("show_join_now.php");
	}
	elseif($step=="quotes"){
		require_once ("show_quotes.php");
	}
	elseif($step=="update_your_account"){
		if($_SESSION[ecardmax_user]!=""){			
			$isResponsive ? require_once ("show_update_your_account_mobile.php") : require_once ("show_update_your_account.php");
		}
		else{
			header("Location:$url_sign_in\n");
			exit;
		}
	}
	elseif($step=="play_games"){
		if($_SESSION[mg_allow_game]=="1"){
			require_once ("show_play_games.php");
		}
		else{
			//Go to page update your account
			header("Location:".get_global_var(url_update_your_account)."\n");
			exit;
		}
	}
	elseif($step=="grabber"){
		if($_SESSION[mg_allow_grabber]=="1"){
			if($what=="grabnow"){
				require_once ("show_grabber.php");
				exit;
			}
			else{
				if($grab_url=="")$grab_url="http://";
				$display_thumbnail=get_html_from_layout("templates/$cf_set_template/show_media_grabber.html");
			}
		}
		else{
			//Go to page update your account
			header("Location:".get_global_var(url_update_your_account)."\n");
			exit;
		}
	}
	elseif($step=="sign_in"){
	if($what=="check_login"){
		$user_password_md5=md5($user_password);
			$row_data = get_row("max_ecuser","*","user_email='$user_name_id' and user_password='$user_password_md5' or user_name_id='$user_name_id' and user_password='$user_password_md5'");

			if ($row_data[user_active]=="0") {// Account is not active
				$sign_in_error=$sign_in_error_msg_account_not_active;
				$show_info_1=get_html_from_layout("templates/$cf_set_template/show_sign_in_error_message.html");
			}
			elseif($row_data[user_id]==""){//incorrect ID or Password
				$sign_in_error=$sign_in_error_msg_wrong_user_pass;
				$show_info_1=get_html_from_layout("templates/$cf_set_template/show_sign_in_error_message.html");
			}
			elseif($row_data[user_id]!="" && $row_data[user_beclosed]=="2" && $row_data["user_dateclose"] <= $gmt_timestamp_now || $row_data[user_active]!="1"){//account suspended
				$sign_in_error=$sign_in_error_msg_account_suspend;
				$show_info_1=get_html_from_layout("templates/$cf_set_template/show_sign_in_error_message.html");
			}
			else{//everything fine -> login
				if($remember_me=="1"){
					setcookie("set_remember_me","$row_data[user_name_id]", $gmt_timestamp_now+31104000); //setcookie for 1 year
					setcookie("set_remember_me_crypt_pass",crypt($row_data[user_password],"ec"), $gmt_timestamp_now+31104000); //setcookie for 1 year
				}

				$_SESSION[ecardmax_user]=$row_data[user_name_id];
				foreach($row_data as $key=>$val){
					$_SESSION[$key]=$val;
				}

				//Down grade acct to Free membership acct
				if($row_data[user_beclosed]=="3" && $row_data[user_dateclose] <= $gmt_timestamp_now){
					//Find 2 sub acct and down grade them
					if($row_data[user_member1]!="")update_field_in_db2("max_ecuser","user_mg_id='2',user_beclosed='0',user_dateclose='0',user_request_cancel='0'","user_name_id='$row_data[user_member1]'");
					if($row_data[user_member2]!="")update_field_in_db2("max_ecuser","user_mg_id='2',user_beclosed='0',user_dateclose='0',user_request_cancel='0'","user_name_id='$row_data[user_member2]'");

					//Update main acct user_mg_id = 2
					update_field_in_db2("max_ecuser","user_mg_id='2',user_beclosed='0',user_dateclose='0',user_request_cancel='0'","user_id='$row_data[user_id]'");
					$_SESSION[user_mg_id]="2";
					$_SESSION[user_beclosed]="0";
					$_SESSION[user_dateclose]="0";
					$_SESSION[user_request_cancel]="0";
				}

				//Set member group
				$mg_row=get_row("max_member_group","*","mg_id='$_SESSION[user_mg_id]'");
				foreach($mg_row as $key=>$val){
					$_SESSION[$key]=$val;
				}
				
				//Set language
				$_SESSION[ecardmax_lang]=$row_data[user_lang];

				//Say hello user
				$_SESSION[hello_user]="$txt_welcome_back_user $row_data[user_name] $row_data[user_last_name]";

				//Update user_lastlogin & user_timeused
				$row_data[user_timeused]++;
				update_field_in_db2("max_ecuser","user_lastlogin2='$row_data[user_lastlogin]',user_lastlogin='$gmt_timestamp_now',user_timeused='$row_data[user_timeused]'","user_id='$row_data[user_id]' LIMIT 1");
			}
		}
		elseif($what=="lost_pass"){
			$row_data = get_row("max_ecuser","user_id,user_name_id,user_password,user_name,user_last_name,user_email","user_email='$user_name_id' and user_active='1' or user_name_id='$user_name_id' and user_active='1'");
			if($row_data[user_id]==""){//Account not found
				$show_info_2="<div class='text-danger'>".$sign_in_lost_pass_error_msg."</div>";
			}
			else{ //Send password
				$newpassword=genRandomString();
				$md5password=md5($newpassword);
				update_field_in_db2("max_ecuser","user_password='$md5password'","user_id='$row_data[user_id]'");
			
				$lost_password_email_message=str_replace("%show_user_name_id%",$row_data[user_email],$lost_password_email_message);
				$lost_password_email_message=str_replace("%show_password%",$newpassword,$lost_password_email_message);
				
				send_email($cf_site_title,$cf_webmaster_email,$row_data[user_email],$lost_password_email_subject,$lost_password_email_message,$cf_email_plain_text,$cf_webmaster_email);
				
				//Display mail has been sent
				$sign_in_lost_pass_ok_msg=str_replace("%show_email%",$row_data[user_email],$sign_in_lost_pass_ok_msg);
				$show_info_2=get_html_from_layout("templates/$cf_set_template/show_sign_in_lost_pass_ok_msg.html");
					
			}
				

		}
		
		if($_SESSION[ecardmax_user]!=""){
			switch($next_step){
				case "show_birthday_card":
					if($_SESSION[mg_allow_send_birthday_to_group]=="1"){
						$isResponsive ? require_once("show_birthday_card_mobile.php") : require_once("show_birthday_card.php");
					}
					else{
						//Go to page update your account
						header("Location:$ecard_url/index.php?step=update_your_account\n");
					}
					exit;
					break;
				case "show_myaccount":
				
				set_global_var("navigator_link","<a href=\"".get_global_var(url_home)."\">$txt_home</a> <img border=\"0\" alt=\"\" src=\"$ecard_url/templates/$cf_set_template/arrow_nav.gif\" style=\"vertical-align:middle\" /> <a href=\"".$url_myaccount_home."\">$txt_mtool_myaccount</a>");
					if($_SESSION[mg_allow_myaccount]=="1"){
						$array_global_var[my_site_title]="$cf_site_title - $txt_mtool_myaccount";
						require_once ("show_myaccount.php");
					}
					else{
						//Go to page update your account
						header("Location:".get_global_var(url_update_your_account)."\n");
					}
					exit;
					break;
				case "show_addressbook":
					if($_SESSION[mg_allow_addressbook]=="1"){
						$array_global_var[my_site_title]="$cf_site_title - $txt_mtool_addressbook";
						$isResponsive ? require_once ("show_addressbook_mobile.php") : require_once ("show_addressbook.php");
					}
					else{
						//Go to page update your account
						header("Location:".get_global_var(url_update_your_account)."\n");
					}
					exit;
					break;
				case "show_addressbook_group":
					if($_SESSION[mg_allow_addressbook]=="1"){
						$array_global_var[my_site_title]="$cf_site_title - $txt_mtool_addressbook";
						require_once ("show_addressbook_group.php");
					}
					else{
						//Go to page update your account
						header("Location:".get_global_var(url_update_your_account)."\n");
					}
					exit;
					break;
				case "show_reminder":
					set_global_var("navigator_link","<a href=\"".get_global_var(url_home)."\">$txt_home</a> <img border=\"0\" alt=\"\" src=\"$ecard_url/templates/$cf_set_template/arrow_nav.gif\" style=\"vertical-align:middle\" /> <a href=\"".$url_reminder_home."\">$txt_mtool_reminder</a>");
					if($_SESSION[mg_allow_reminder]=="1"){
						$array_global_var[my_site_title]="$cf_site_title - $txt_mtool_reminder";
						require_once ("show_reminder.php");
					}
					else{
						//Go to page update your account
						header("Location:".get_global_var(url_update_your_account)."\n");
					}
					exit;
					break;
				case "show_mycalendar":
					set_global_var("navigator_link","<a href=\"".get_global_var(url_home)."\">$txt_home</a> <img border=\"0\" alt=\"\" src=\"$ecard_url/templates/$cf_set_template/arrow_nav.gif\" style=\"vertical-align:middle\" /> <a href=\"".$url_calendar_home."\">$txt_mtool_calendar</a>");
					if($_SESSION[mg_allow_calendar]=="1"){
						$array_global_var[my_site_title]="$cf_site_title - $txt_mtool_calendar";
						if($isResponsive)
						require_once ("show_mycalendar_mobile.php");
						require_once ("show_mycalendar.php");
					}
					else{
						//Go to page update your account
						header("Location:".get_global_var(url_update_your_account)."\n");
					}
					exit;
					break;
				case "show_history":
				set_global_var("navigator_link","<a href=\"".get_global_var(url_home)."\">$txt_home</a> <img border=\"0\" alt=\"\" src=\"$ecard_url/templates/$cf_set_template/arrow_nav.gif\" style=\"vertical-align:middle\" /> <a href=\"".$url_history_home."\">$txt_mtool_history</a>");
					$array_global_var[my_site_title]="$cf_site_title - $txt_mtool_history";
					if($_SESSION[mg_allow_history]=="1"){
						require_once ("show_history.php");
					}
					else{
						//Go to page update your account
						header("Location:".get_global_var(url_update_your_account)."\n");
					}
					exit;
					break;
				case "show_myalbum":
					set_global_var("navigator_link","<a href=\"".get_global_var(url_home)."\">$txt_home</a> <img border=\"0\" alt=\"\" src=\"$ecard_url/templates/$cf_set_template/arrow_nav.gif\" style=\"vertical-align:middle\" /> <a href=\"".$url_myalbum_home."\">$txt_mtool_myalbum</a>");
					if($_SESSION[mg_allow_myalbum]=="1"){
						$array_global_var[my_site_title]="$cf_site_title - $txt_mtool_myalbum";
						require_once ("show_myalbum.php");
					}
					else{
						//Go to page update your account
						header("Location:".get_global_var(url_update_your_account)."\n");
					}
					exit;
					break;
				case "show_favorite":
					if($_SESSION[mg_allow_favorite]=="1"){
						if($action=="delete_favorite"){
							delete_row("max_favorite","fv_ec_id='$ec_id' and fv_user_name_id='$_SESSION[user_name_id]' LIMIT 1");
						}
						$item_width=round(100 / $cf_pic_per_row) . "%";
						$display_title_thumbnail = "<h1 class='table_title_bar' id='title-1'>$txt_mtool_myfavorite</h1>";
						set_global_var('display_title_thumbnail',$display_title_thumbnail);
						$display_thumbnail=print_thumbnail("show_favorite");
					}
					else{
						//Go to page update your account
						header("Location:".get_global_var(url_update_your_account)."\n");
						exit;
					}
					break;
				case "show_birthdayalert":
					if($isResponsive)
					{
						$myloop= get_html_from_layout("templates/$cf_set_template/myloop.html");
						set_global_var('myloop',$myloop);
					}
					set_global_var("navigator_link","<a href=\"".get_global_var(url_home)."\">$txt_home</a> <img border=\"0\" alt=\"\" src=\"$ecard_url/templates/$cf_set_template/arrow_nav.gif\" style=\"vertical-align:middle\" /> <a href=\"".$url_birthday_alert_home."\">$txt_mtool_birthdayalert</a>");
					if($_SESSION[mg_allow_birthdayalert]=="1"){
						if($action=="send_to_friends"){
							$array=split("\n",$list_email);
							foreach($array as $line){//insert to database
								$line=trim($line);
								if($line!=""){
									list($re_name,$re_email)=split(";",$line);
									$chk_book_email=get_dbvalue("max_addressbook","book_id","book_email='$re_email' and book_user_name_id='$_SESSION[user_name_id]'");
									$chk_blacklist_email=get_dbvalue("max_black_list","black_email","black_email='$re_email' and black_active='1'");
									if($chk_blacklist_email==""){//email not on the black list -> send 
										if($chk_book_email==""){//Contact is not on addressbook -> add contact to database (Group Default)
											$arr_name=split(" ",$re_name);
											$book_lname=trim($arr_name[count($arr_name)-1]);
											$book_fname=trim(str_replace(" $book_lname","",$re_name));
											$field_name ="(book_fname,book_lname,book_email,book_ag_relate_id,book_user_name_id)";
											$field_value ="('$book_fname','$book_lname','$re_email',',0,','$_SESSION[user_name_id]')";
											insert_data_to_db("max_addressbook",$field_name,$field_value);
										}
										//Send email
										$message_tmp=str_replace("%SHOW_LINK%","$ecard_url/index.php?step=dob&user_id=$_SESSION[user_id]&book_email=$re_email", nl2br($message));
										send_email($sender_name,$sender_email,$re_email,$txt_birthday_alert_email_subject,$message_tmp,$cf_email_plain_text,$sender_email);
									}
								}
							}
							$show_info="<div class=\"OK_Message\" style=\"padding:10px\" >$txt_birthday_alert_show_info_thankyou_message</div>";
						}
						//Auto display sender name & email 
						$sender_name="$_SESSION[user_name] $_SESSION[user_last_name]";
						$sender_email="$_SESSION[user_email]";
						

						//Show Addressbook
						if($_SESSION[mg_allow_addressbook]=="1"){
							//button view address book
							$show_button="<div style=\"text-align:center;padding:5px;white-space:none\"><a href=\"javascript:void(0);\" onclick=\"showid2('table_addressbook','block');showid2('table_addressbook_group','none');\" class=\"button_link_style1\">$txt_mtool_addressbook</a><a href=\"javascript:void(0);\" onclick=\"showid2('table_addressbook','none');showid2('table_addressbook_group','block');\" class=\"button_link_style2\">$addressbook_contact_group_title</a></div>";

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
								$show_contact_group_options.="<option value='$arr_contact[ag_id]'>$arr_contact[ag_title]</option>";
							}
							//var_dump($show_contact_group_options);
							//set_global_var("show_contact_group_options",$show_contact_group_options);
							$show_contact_group=get_html_from_layout("templates/$cf_set_template/show_personalize_table_show_address_book_show_contact_group.html");
			
							$show_address_book=get_html_from_layout("templates/$cf_set_template/show_personalize_table_show_address_book.html");
							//$print_banner_vt="<div class=\"table_border\" style'\"width:160\"><div class=\"table_title_bar\">$txt_mtool_addressbook</div><div style=\"padding:5px\">$show_address_book</div></div><div style=\"line-height:8px\"></div><div style=\"text-align:right\"><a href=\"javascript:ResizeIframe('2');\" class=\"page_other\" title=\"$show_personalize_table_tooltip_default_size\"><img border=\"0\" alt=\"\" style=\"vertical-align:middle\" src=\"$ecard_url/templates/$cf_set_template/icon_normal_size.gif\" /></a> <a href=\"javascript:ResizeIframe('1');\" class=\"page_other\" title=\"$show_personalize_table_tooltip_increase_size\"><img border=\"0\" alt=\"\" style=\"vertical-align:middle\" src=\"$ecard_url/templates/$cf_set_template/icon_plus.gif\" /></a> <a href=\"javascript:ResizeIframe('0');\" class=\"page_other\" title=\"$show_personalize_table_tooltip_decrease_size\"><img border=\"0\" alt=\"\" style=\"vertical-align:middle\" src=\"$ecard_url/templates/$cf_set_template/icon_minus.gif\" /></a><br /><br /></div>";
							$category_menu=category_menu($cat_id,$cat_id);
							//Display random banner HR
							print_banner("0");
							$txt_birthday_alert_email_message = strip_tags($txt_birthday_alert_email_message);
							$display_thumbnail=get_html_from_layout("templates/$cf_set_template/show_birthdayalert.html");
							$array_global_var[print_object]=get_html_from_layout("templates/$cf_set_template/show_birthdayalert_table.html");
							print_header_and_footer();
							exit;
						}
					}
					else{
						//Go to page update your account
						header("Location:".get_global_var(url_update_your_account)."\n");
						exit;
					}
					break;
				case "show_sendvideocard":
					set_global_var("navigator_link","<a href=\"".get_global_var(url_home)."\">$txt_home</a> <img border=\"0\" alt=\"\" src=\"$ecard_url/templates/$cf_set_template/arrow_nav.gif\" style=\"vertical-align:middle\" /> <a href=\"".$url_send_video_card_home."\">$txt_mtool_sendvideocard</a>");
					//if($_SESSION[mg_allow_sendvideocard]=="1"){
					if(true){
						$array_global_var[my_site_title]="$cf_site_title - $txt_mtool_sendvideocard";
						require_once ("show_sendvideocard.php");
					}
					else{
						//Go to page update your account
						header("Location:".get_global_var(url_update_your_account)."\n");
					}
					exit;
					break;
				default:
					if($_SESSION[iv_id]!=""){
						print"<script language='javascript'>location.href='".print_url_invitation_sendcard($_SESSION[iv_id],"")."';</script>";
					}
					elseif($_SESSION[ec_id]!=""){
						print"<script language='javascript'>location.href='".print_url_card_sendcard($_SESSION[ec_id],"")."';</script>";
					}
					else{
						print"<script language='javascript'>location.href='".get_global_var(url_home)."';</script>";
					}
					exit;
			}
		}
		else{
			//Show basic member Benefits
			$get_basic_row=get_row("max_member_group","*","mg_id='2'");
			if($get_basic_row[mg_allow_game]=="1")$sign_in_show_become_member_benefits .="<div style=\"padding:3px\"><img border=\"0\" alt=\"\" src=\"$ecard_url/templates/$cf_set_template/icon_check_mark.gif\" /> $myaccount_allow_game</div>";
			if($get_basic_row[mg_allow_grabber]=="1")$sign_in_show_become_member_benefits .="<div style=\"padding:3px\"><img border=\"0\" alt=\"\" src=\"$ecard_url/templates/$cf_set_template/icon_check_mark.gif\" /> $myaccount_allow_grabber</div>";
			if($get_basic_row[mg_allow_search]=="1")$sign_in_show_become_member_benefits .="<div style=\"padding:3px\"><img border=\"0\" alt=\"\" src=\"$ecard_url/templates/$cf_set_template/icon_check_mark.gif\" /> $myaccount_allow_search</div>";
			if($get_basic_row[mg_allow_futuredate]=="1")$sign_in_show_become_member_benefits .="<div style=\"padding:3px\"><img border=\"0\" alt=\"\" src=\"$ecard_url/templates/$cf_set_template/icon_check_mark.gif\" /> $myaccount_allow_futuredate</div>";
			if($get_basic_row[mg_allow_rate]=="1")$sign_in_show_become_member_benefits .="<div style=\"padding:3px\"><img border=\"0\" alt=\"\" src=\"$ecard_url/templates/$cf_set_template/icon_check_mark.gif\" /> $myaccount_allow_rate</div>";
			if($get_basic_row[mg_allow_viewfullsize]=="1")$sign_in_show_become_member_benefits .="<div style=\"padding:3px\"><img border=\"0\" alt=\"\" src=\"$ecard_url/templates/$cf_set_template/icon_check_mark.gif\" /> $myaccount_allow_viewfullsize</div>";
			if($get_basic_row[mg_allow_myaccount]=="1")$sign_in_show_become_member_benefits .="<div style=\"padding:3px\"><img border=\"0\" alt=\"\" src=\"$ecard_url/templates/$cf_set_template/icon_check_mark.gif\" /> $myaccount_allow_myaccount</div>";
			if($get_basic_row[mg_allow_addressbook]=="1")$sign_in_show_become_member_benefits .="<div style=\"padding:3px\"><img border=\"0\" alt=\"\" src=\"$ecard_url/templates/$cf_set_template/icon_check_mark.gif\" /> $myaccount_allow_addressbook</div>";
			if($get_basic_row[mg_allow_reminder]=="1")$sign_in_show_become_member_benefits .="<div style=\"padding:3px\"><img border=\"0\" alt=\"\" src=\"$ecard_url/templates/$cf_set_template/icon_check_mark.gif\" /> $myaccount_allow_reminder</div>";
			if($get_basic_row[mg_allow_calendar]=="1")$sign_in_show_become_member_benefits .="<div style=\"padding:3px\"><img border=\"0\" alt=\"\" src=\"$ecard_url/templates/$cf_set_template/icon_check_mark.gif\" /> $myaccount_allow_calendar</div>";
			if($get_basic_row[mg_allow_myalbum]=="1")$sign_in_show_become_member_benefits .="<div style=\"padding:3px\"><img border=\"0\" alt=\"\" src=\"$ecard_url/templates/$cf_set_template/icon_check_mark.gif\" /> $myaccount_allow_myalbum</div>";
			if($get_basic_row[mg_allow_favorite]=="1")$sign_in_show_become_member_benefits .="<div style=\"padding:3px\"><img border=\"0\" alt=\"\" src=\"$ecard_url/templates/$cf_set_template/icon_check_mark.gif\" /> $myaccount_allow_favorite</div>";
			if($get_basic_row[mg_allow_history]=="1")$sign_in_show_become_member_benefits .="<div style=\"padding:3px\"><img border=\"0\" alt=\"\" src=\"$ecard_url/templates/$cf_set_template/icon_check_mark.gif\" /> $myaccount_allow_history</div>";
			if($get_basic_row[mg_allow_birthdayalert]=="1")$sign_in_show_become_member_benefits .="<div style=\"padding:3px\"><img border=\"0\" alt=\"\" src=\"$ecard_url/templates/$cf_set_template/icon_check_mark.gif\" /> $myaccount_allow_birthdayalert</div>";
			$sign_in_show_become_member_benefits .="<div style=\"padding:3px\"><img border=\"0\" alt=\"\" src=\"$ecard_url/templates/$cf_set_template/icon_check_mark.gif\" /> $myaccount_max_recipient: <span class=\"OK_Message\">$get_basic_row[mg_number_recipient]</span></div>";
			$sign_in_show_become_member_benefits .="<div style=\"padding:3px\"><img border=\"0\" alt=\"\" src=\"$ecard_url/templates/$cf_set_template/icon_check_mark.gif\" /> $sign_in_become_member_send_free_ecard:</div>";
			$sign_in_show_become_member_benefits .= "<div style=\"padding:3px\"><hr class=\"HR_Color\"/></div><div style=\"width: 100%;float:left;\" align=\"center\">".print_thumbnail("basic_sample_card")."</div>";

			$show_free_basic_membership_benefits=get_html_from_layout("templates/$cf_set_template/show_sign_in_show_free_basic_membership_benefits.html");
			$display_thumbnail=get_html_from_layout("templates/$cf_set_template/show_sign_in.html");
		}
	}

	$category_menu=category_menu($cat_id,$cat_id);
	
	// Display navigator link
	$navigator_link_category=get_global_var(navigator_link);
	$navigator_link=get_html_from_layout("templates/$cf_set_template/show_thumbnail_category_navigator_link_no_sort.html");
	set_global_var("navigator_link",$navigator_link);

	//Display random banner HR & VT
	print_banner("0");
	print_banner("1");

	set_global_var("checked_find_exact_".$find_exact,"checked=\"checked\"");
	$array_global_var[print_object]=get_html_from_layout("templates/$cf_set_template/show_thumbnail.html");
	print_header_and_footer();

?>
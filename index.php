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
Note: This product includes GeoLite data created by MaxMind, available from  http://www.maxmind.com 
*/
	session_start();
	define("ECARDMAX_USER", 1);
	require_once ("config.php");
	//require_once ("config2.php");
	require_once("getvars.php");
	require_once ("function.php");
	require_once ("inc/const.php");
	
	set_global_var('isMobile',$isMobile);
	//Get System Configuration 
	$list_cf=set_array_from_query("max_config","*");//print_r($list_cf);die;
	foreach($list_cf as $array_cf){
		$$array_cf['config_name']=$array_cf['config_value'];
	}
	
	//CHECK MOBILE AND RESPONSIVE
	$isResponsive = isset($cf_template_responsive) ? $cf_template_responsive : false ;
	require_once('inc/mobileDetect.php');
	$isMobile = $isResponsive ? mobile_device_detect() : false;
	$col_main_content = 9 ;
	if($isMobile)
	{
		$col_main_content = 12;
	}
	set_global_var('col_main_content',$col_main_content);
	//END
	if (!$cf_twitter_authorize_url) { // Twitter authorize URL
		$cf_twitter_authorize_url = "$ecard_url/oAuth/authorize.php";
	}
	//Facebook Login
	require 'facebook/facebook.php';
	require 'facebook/fbconfig.php';
	//End facebook login
	require_once ("inc/url_setting.php");
	//SMTP Mail
	if($cf_sendmail_using_SMTP=="1")require_once("pear/Mail.php");

	if(file_exists("install.php") || file_exists("install_welcome.html") || file_exists("install_step1.html")  || file_exists("install.sql") || file_exists("install1.sql") || file_exists("upgrade.php") || file_exists("upgrade.files") || file_exists("upgrade.sql")){
		print"<b>For security reason you should remove these file</b>: <p><span class='OK_Message'><li> For new installation: install.php + install_step1.html + install_welcome.html + install.sql + install1.sql</li><li> For upgrade from 10 to 10.5: upgrade.php + upgrade.files + upgrade.sql</li></span></p><hr class=HR_Color />";
		exit;
	}
	
	if ($step=="check_seo") {
		// supported returned mean the website can use SEO links
		echo ".htaccess is supported. You can use SEO URL now";
		exit;
	}

	$current_url = curPageURL(); // get current page URL.
	
	//Calculate time
	if($_SESSION[ecardmax_user]==""){//User not login (Guest)
		$gmt_timestamp_now=adjust_timestamp($cf_timezone);
	}
	else{
		$gmt_timestamp_now=adjust_timestamp($_SESSION[user_timezone]);
	}
	
	//Auto login if remember_me was set
	if($_COOKIE[set_remember_me]!="" && $_SESSION[set_remember_me_ok]!="1"){
		$row_data = get_row("max_ecuser","*","user_email='$set_remember_me' and user_active='1' and user_beclosed='0' or user_name_id='$set_remember_me' and user_active='1' and user_beclosed='0' ");
		if($row_data[user_id]!="" && $_COOKIE[set_remember_me_crypt_pass]==crypt($row_data[user_password],"ec")){
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
			
			//Update user_lastlogin & user_timeused
			$change_user_timeused=$row_data[user_timeused]+1;
			update_field_in_db2("max_ecuser","user_lastlogin2='$row_data[user_lastlogin]',user_lastlogin='$gmt_timestamp_now',user_timeused='$change_user_timeused'","user_id='$row_data[user_id]' LIMIT 1");

			$set_remember_me_ok="1";
			$_SESSION[set_remember_me_ok]=1;

			$gmt_timestamp_now=timestamp_gmt_output($_SESSION[user_timezone]);
		}
	}

	$lang =str_replace("/","",$lang);
	$lang =str_replace("..","",$lang);
	if((strpos($lang,"_lang.php")===false)){ //if false
		$lang="";
	}
	if($lang=="" && $_SESSION[ecardmax_lang]==""){
		$lang=$cf_language;
	}
	elseif($lang=="" && $_SESSION[ecardmax_lang]!=""){
		$lang=$_SESSION[ecardmax_lang];
	}
	elseif($lang!=""){
		$_SESSION[ecardmax_lang]=$lang;
	}
	if(file_exists("$ecard_root/languages/$lang")){
		$_SESSION[ecardmax_lang]=$lang;
	}
	else{
		$_SESSION[ecardmax_lang]=$cf_language;
	}

	if($step=="change_lang"){
		$_SESSION[ecardmax_lang]=$lang;
		exit;
	}	

	//Include language files
	include("$ecard_root/languages/$_SESSION[ecardmax_lang]");
	if($ajaxstyle == "1") header("Content-Type:text/plain ; charset=$charset");
	//Facebook login
	if($_SESSION['facebook_id']==""){
		Connection_facebook();
	}
	else{
		$_SESSION[ecardmax_user]=$_SESSION['facebook_id'];
	}
	//End facebook login
	//Say hello user
	if($_COOKIE[set_remember_me]!="" && $set_remember_me_ok=="1"){
		//Say hello user
		$_SESSION[hello_user]="$txt_welcome_back_user $_SESSION[user_name] $_SESSION[user_last_name]";
	}

	//Get member group data
	if($_SESSION[ecardmax_user]==""){//User not login (Guest)
		$mg_row=get_row("max_member_group","*","mg_id='1'");
	}
	else{//User already logged in
		// get group trong database theo username
		$user_mg_id = get_dbvalue("max_ecuser","user_mg_id","user_name_id = '$_SESSION[ecardmax_user]'");
		$mg_row=get_row("max_member_group","*","mg_id='$user_mg_id'");
	}
	foreach($mg_row as $key=>$val){
		$_SESSION[$key]=$val;
	}

	
	//Time
	$today_mon = date("n", $gmt_timestamp_now); //ex: 9
	$today_mday = date("j", $gmt_timestamp_now); //ex: 31
	$today_year = date("Y", $gmt_timestamp_now); //ex: 2006
	$next_10year=$today_year+10;
	$week_daynumber=date("w", $gmt_timestamp_now); //ex: 0 (for Sunday) through 6 (for Saturday)

	if($today_mon == 1 || $today_mon == 3 || $today_mon == 5 || $today_mon == 7 || $today_mon == 8 || $today_mon == 10 || $today_mon == 12){
		$day31 = 31;
	}
	elseif($today_mon == 2){
		$day31 = 28;
	}
	else{
		$day31 = 30;
	}
	$begin_this_month_timestamp=mktime(0,0,0,$today_mon,1,$today_year);
	$begin_this_month_timestamp=adjust_timestamp_user($begin_this_month_timestamp,$_SESSION[user_timezone]);
	$end_this_month_timestamp=($begin_this_month_timestamp+(86400*$day31))-1;

	$begin_today_timestamp=mktime(0,0,0,$today_mon,$today_mday,$today_year);
	$begin_today_timestamp=adjust_timestamp_user($begin_today_timestamp,$_SESSION[user_timezone]);
	$end_today_timestamp=$begin_today_timestamp + 86400 - 1;

	$begin_yesterday_timestamp=$begin_today_timestamp - 86400 ;
	$end_yesterday_timestamp=$begin_today_timestamp - 1 ;

	$begin_this_week_timestamp = $begin_today_timestamp - (86400 * ($wday+1));
	$end_this_week_timestamp = ($begin_this_week_timestamp + (86400 * 7))-1;

	//Show ban message
	$ip_info=split(".",$remote_addr);
	$get_ip1=$remote_addr;
	$get_ip2="$ip_info[0].$ip_info[1].$ip_info[2].*";
	$get_ip3="$ip_info[0].$ip_info[1].*.*";
	$get_ip4="$ip_info[0].*.*.*";
	$ban_row=get_row("max_ban_user","*","ban_what='$get_ip1' or ban_what='$get_ip2' or ban_what='$get_ip3' or ban_what='$get_ip4' ");
	if ($ban_row[ban_id]!=""){
		if($ban_row[ban_time_end]>0 && $ban_row[ban_time_end] > $begin_today_timestamp){
			$array_global_var[print_object]="<br /><br /><div style=\"text-align:center\">$txt_ban_error_message<br /><br />$ban_row[ban_reason]</div>";
			print_header_and_footer();
			exit;
		}
	}
	
	if($reply=="1")$_SESSION[ecardmax_reply]=1;
	$search_what="ecard";
	//Display Holiday event table
	if($cf_show_holiday_events_box=="1"){
		$this_month=$today_mon;
		if($this_month==12){
			$next_month=1;
		}
		else{
			$next_month=$this_month+1;
		}

		if($this_month==1){
			$display_month=$Jan;
			$display_next_month=$Feb;
		}
		elseif($this_month==2){
			$display_month=$Feb;
			$display_next_month=$Mar;
		}
		elseif($this_month==3){
			$display_month=$Mar;
			$display_next_month=$Apr;
		}
		elseif($this_month==4){
			$display_month=$Apr;
			$display_next_month=$May;
		}
		elseif($this_month==5){
			$display_month=$May;
			$display_next_month=$Jun;
		}
		elseif($this_month==6){
			$display_month=$Jun;
			$display_next_month=$Jul;
		}
		elseif($this_month==7){
			$display_month=$Jul;
			$display_next_month=$Aug;
		}
		elseif($this_month==8){
			$display_month=$Aug;
			$display_next_month=$Sep;
		}
		elseif($this_month==9){
			$display_month=$Sep;
			$display_next_month=$Oct;
		}
		elseif($this_month==10){
			$display_month=$Oct;
			$display_next_month=$Nov;
		}
		elseif($this_month==11){
			$display_month=$Nov;
			$display_next_month=$Dec;
		}
		elseif($this_month==12){
			$display_month=$Dec;
			$display_next_month=$Jan;
		}

		$list_data=set_array_from_query("max_event","*","event_month='$this_month' or event_month='$next_month' Order by event_day");
		foreach($list_data as $row_data){
			if($row_data[event_day]<10)$row_data[event_day]="0".$row_data[event_day];
			if($row_data[event_month]==$this_month){
				$event_url=$row_data[event_url];
				$event_day=$row_data[event_day];
				$event_name=$row_data[event_name];
				$SHOW_THIS_MONTH.=get_html_from_layout("templates/$cf_set_template/show_homepage_print_holiday_events_show_this_month.html",$the_template_show_this_month);
			}
			else{
				$event_url=$row_data[event_url];
				$event_day=$row_data[event_day];
				$event_name=$row_data[event_name];
				$SHOW_NEXT_MONTH.=get_html_from_layout("templates/$cf_set_template/show_homepage_print_holiday_events_show_next_month.html",$the_template_show_next_month);
			}
		}
		$print_holiday_events=get_html_from_layout("templates/$cf_set_template/show_homepage_print_holiday_events.html");
		$print_holiday_events_left=get_html_from_layout("templates/$cf_set_template/show_homepage_print_holiday_events_left.html");
	}
	
	switch($step){
		case "add_new_comment":
			 require_once ("inc/jsonwrapper.php");
			 if($comment!=""){
			 	$com_year = date("Y",time());
			 	$com_day = date("d",time());
			 	$com_month = date("m",time());
			 	$field_name = "(com_author_name,com_message,com_year,com_day,com_month,com_ec_id)";
			 	$field_value = "('$_SESSION[ecardmax_user]','$comment','$com_year','$com_day','$com_month','$ec_id')";
			 	insert_data_to_db("max_ecard_comment",$field_name,$field_value);
			 }
			 if($page==""){
			 	$page=1;
			 }
			 //json_encode
			 $from=($page-1)*5;
			 $list_data =set_array_from_query("max_ecard_comment","*","com_ec_id='$ec_id' ORDER BY com_id DESC LIMIT $from,5");
			 $c=get_dbvalue("max_ecard_comment","COUNT(com_id)","com_ec_id='$ec_id'");
			 $tmp[0]=$c;
			 $tmp[1]=$list_data;
			 $tmp[2]=$page;
			 echo json_encode($tmp);
			 exit;
			 break;	
		case "user_design_ecard":
			if($_SESSION[ecardmax_user]==""){//User not login
				$_SESSION[user_design_ecard]="1";
				$_SESSION[ud_ec_id]=$_SESSION[ec_id];
				$_SESSION[ud_cs_java]=$ud_cs_java;
				$_SESSION[ud_cs_skin_name]=$ud_cs_skin_name;
				$_SESSION[ud_cs_stamp_filename]=$ud_cs_stamp_filename;
				$_SESSION[ud_cs_music_filename]=$ud_cs_music_filename;
				$_SESSION[ud_cs_music_id]=$ud_cs_music_id;
				$_SESSION[ud_cs_poem_id]=$ud_cs_poem_id;
				$_SESSION[ud_cs_poem_align]=$ud_cs_poem_align;
			}
			else{
				$_SESSION[user_design_ecard]="0";
				$_SESSION[ud_ec_id]="";
				$_SESSION[ud_cs_java]="";
				$_SESSION[ud_cs_skin_name]="";
				$_SESSION[ud_cs_stamp_filename]="";
				$_SESSION[ud_cs_music_filename]="";
				$_SESSION[ud_cs_music_id]="";
				$_SESSION[ud_cs_poem_id]="";
				$_SESSION[ud_cs_poem_align]="";
			}
			exit;
			break;
		case "show_invitation":
			$search_what="invite";
			$show_pop_top_new_cards=get_html_from_layout("templates/$cf_set_template/show_pop_top_new_cards_invite.html");
			if($cat_id==""){
				require_once("inc/show_homepage_invite.php");
			}
			else{
				require_once("inc/browse_category_invite.php");
			}
			exit;
			break;
		case "invitation_detail":
			if($_SESSION[ecardmax_user]!=""){
				$search_what="invite";
				/*$show_pop_top_new_cards.="<a href=\"$url_popular_invitation\" class=\"main_category_text_link_selected\"><div class=\"main_category_background_hover\" >$txt_popular</div></a>";
				$show_pop_top_new_cards.="<a href=\"$url_top_rated_invitation\" class=\"main_category_text_link_selected\"><div class=\"main_category_background_hover\" >$txt_top_rate</div></a>";
				$show_pop_top_new_cards.="<a href=\"$url_new_cards_invitation\" class=\"main_category_text_link_selected\"><div class=\"main_category_background_hover\" >$txt_newecards</div></a>";
				$show_pop_top_new_cards.="<a href=\"$url_random_cards_invitation\" class=\"main_category_text_link_selected\"><div class=\"main_category_background_hover\" >$txt_random_card</div></a>";
				$show_pop_top_new_cards.="<a href=\"$url_favorite_invitation\" class=\"main_category_text_link_selected\"><div class=\"main_category_background_hover\" >$txt_mtool_myfavorite</div></a>";*/
				$show_pop_top_new_cards.="<a href=\"$url_popular_invitation\" class=\"main_category_text_link_selected\"><div class=\"main_category_background\" >$txt_popular</div></a>";
				$show_pop_top_new_cards.="<a href=\"$url_top_rated_invitation\" class=\"main_category_text_link_selected\"><div class=\"main_category_background\" >$txt_top_rate</div></a>";
				$show_pop_top_new_cards.="<a href=\"$url_new_cards_invitation\" class=\"main_category_text_link_selected\"><div class=\"main_category_background\" >$txt_newecards</div></a>";
				$show_pop_top_new_cards.="<a href=\"$url_random_cards_invitation\" class=\"main_category_text_link_selected\"><div class=\"main_category_background\" >$txt_random_card</div></a>";
				$show_pop_top_new_cards.="<a href=\"$url_favorite_invitation\" class=\"main_category_text_link_selected\"><div class=\"main_category_background\" >$txt_mtool_myfavorite</div></a>";
				require_once("inc/show_invitation_detail.php");
			}
			else{
				header("Location:$ecard_url/index.php?step=sign_in\n");
			}
			exit;
			break;
		case "sendcard_invite":
			$search_what="invite";
			$isResponsive ? require_once("inc/sendcard_invite_mobile.php") : require_once("inc/sendcard_invite.php");
			exit;
			break;
		case "resend_invite":
			$search_what="invite";
			$isResponsive ? require_once("inc/sendcard_invite_resend_mobile.php") : require_once("inc/sendcard_invite_resend.php");
			exit;
			break;
		case "invitation_addguest":
			$search_what="invite";
			if($_SESSION[ecardmax_user]!=""){
				require_once("inc/invitation_addguest.php");
			}
			else{
				header("Location:$ecard_url/index.php?step=sign_in\n");
			}
			exit;
			break;
		case "rate_card_invite":
			if($_SESSION[iv_id]!=""){
				$iv_field_name = "iv_rate$iv_rate";
				$getold_val =get_dbvalue("max_ecard_invite","$iv_field_name","iv_id='$_SESSION[iv_id]'")+1;
				update_field_in_db("max_ecard_invite","$iv_field_name",$getold_val,"iv_id='$_SESSION[iv_id]' LIMIT 1");
				$tmp=get_row("max_ecard_invite","*","iv_id='$_SESSION[iv_id]'");
				$max =0;
				$rate =5;
				for ($i=5;$i<=50; $i=$i+5){
					$field_name = "iv_rate$i";
					if ($max < $tmp[$field_name]){
						$max = $tmp[$field_name];
						$rate = $i;
					} 
				}
				update_field_in_db("max_ecard_invite","iv_rate",$rate,"iv_id='$_SESSION[iv_id]' LIMIT 1");
			}
			exit;
			break;
		case "show_invitation_popular":
		case "show_invitation_top_rated":
		case "show_invitation_new_ecards":
		case "show_invitation_random_cards":
		case "show_invitation_favorite":
		case "pickup_invite":
			$search_what="invite";
			require_once("inc/show_action_invite.php");
			exit;
			break;
		case "paypal_thankyou":
			$pay_ecqid=$_GET['pay_ecqid'];
			
			$cnt = 0;
			$row_payment=get_row("max_payment","*","pay_ecqid='$pay_ecqid'");
			while (!$row_payment && $cnt < 5) {
				sleep(5);
				$row_payment=get_row("max_payment","*","pay_ecqid='$pay_ecqid'");
				$cnt++;
			}
			$_SESSION[ecardmax_user]=$row_payment[pay_user_name_id];
			
			
			if($row_payment[pay_ec_id]==0){
			
				$row_user=get_row("max_ecuser","*","user_name_id='$row_payment[pay_user_name_id]'");
				
				
				foreach($row_user as $ukey=>$uval){
					$_SESSION[$ukey]=$uval;

										
				}
				
				$mg_row=get_row("max_member_group","*","mg_id='$row_user[user_mg_id]'");
				
				foreach($mg_row as $mkey=>$mval){
					$_SESSION[$mkey]=$mval;
				}
			//	echo $_SESSION[mg_allow_myaccount];
		//		$_SESSION[mg_allow_myaccount]="1";
		
		
				header("Location:$ecard_url/index.php?step=sign_in&next_step=show_myaccount\n");
			}
			else{
				if($_SESSION[iv_id]!=""){
					header("Location:$ecard_url/index.php?step=sendcard_invite&iv_id={$_SESSION[iv_id]}\n");
				}
				elseif($_SESSION[ec_id]!=""){
					header("Location:$ecard_url/index.php?step=sendcard&ec_id={$_SESSION[ec_id]}\n");
				}
			}
			exit;
			break;
		case "calendar":
			require_once("inc/show_calendar.php");
			break;
		case "banner":
			require_once("inc/show_banner.php");
			break;
		case "verify_image_code":
			require_once("inc/show_verify_image_code.php");
			exit;
			break;
		case "load_select_java":
			require_once("inc/load_select_java.php");
			exit;
			break;
		case "load_select_skin":
			$isResponsive ? require_once("inc/responsive/load_select_skin.php") : require_once("inc/load_select_skin.php");
			exit;
			break;
		case "load_select_stamp":
			$isResponsive ? require_once("inc/responsive/load_select_stamp.php") : require_once("inc/load_select_stamp.php");
			exit;
			break;
		case "load_select_music":
			$isResponsive ? require_once("inc/responsive/load_select_music.php") : require_once("inc/load_select_music.php");
			exit;
			break;	
		case "load_user_font":
			$isResponsive ? require_once("inc/responsive/load_user_font.php") : require_once("inc/load_user_font.php");
			exit;
			break;
		case "watermark":
			require_once("inc/show_watermark.php");
			break;
		case "add_to_fav":
			if($ec_id!="" && $_SESSION[user_name_id]!=""){
				$fav_id=get_dbvalue("max_favorite","fv_id","fv_ec_id='$ec_id' and fv_user_name_id='$_SESSION[user_name_id]'");
				if($fav_id==""){
					$field_name ="(fv_user_name_id,fv_ec_id)";
					$field_value ="('$_SESSION[user_name_id]',$ec_id)";
					insert_data_to_db("max_favorite",$field_name,$field_value);                                        
				}
			}
			exit;
			break;
        case "remove_from_fav":
			if($ec_id!="" && $_SESSION[user_name_id]!=""){
				$fav_id=get_dbvalue("max_favorite","fv_id","fv_ec_id='$ec_id' and fv_user_name_id='$_SESSION[user_name_id]'");
				if($fav_id!=""){					
					delete_row("max_favorite","fv_id=".$fav_id);                                        
				}
			}
			exit;
			break;
		case "add_to_fav_invite":
			if($iv_id!="" && $_SESSION[user_name_id]!=""){
				$fav_id=get_dbvalue("max_favorite_invite","fv_id","fv_iv_id='$iv_id' and fv_user_name_id='$_SESSION[user_name_id]'");
				if($fav_id==""){
					$field_name ="(fv_user_name_id,fv_iv_id)";
					$field_value ="('$_SESSION[user_name_id]',$iv_id)";
					insert_data_to_db("max_favorite_invite",$field_name,$field_value);
				}
			}
			exit;
			break;
		case "remove_from_fav_invite":
			$ec_id = $iv_id;
			if($ec_id!="" && $_SESSION[user_name_id]!=""){
				$fav_id=get_dbvalue("max_favorite_invite","fv_id","fv_iv_id='$ec_id' and fv_user_name_id='$_SESSION[user_name_id]'");
				if($fav_id!=""){					
					delete_row("max_favorite_invite","fv_id=".$fav_id);                                        
				}
			}
			exit;
			break;
		case "rate_card":
			if($_SESSION[ec_id]!=""){
				$ec_field_name = "ec_rate$ec_rate";
				$getold_val =get_dbvalue("max_ecard","$ec_field_name","ec_id='$_SESSION[ec_id]'")+1;
				update_field_in_db("max_ecard","$ec_field_name",$getold_val,"ec_id='$_SESSION[ec_id]' LIMIT 1");
				$tmp=get_row("max_ecard","*","ec_id='$_SESSION[ec_id]'");
				$max =0;
				$rate =5;
				for ($i=5;$i<=50; $i=$i+5){
					$field_name = "ec_rate$i";
					if ($max < $tmp[$field_name]){
						$max = $tmp[$field_name];
						$rate = $i;
					} 
				}
				update_field_in_db("max_ecard","ec_rate",$rate,"ec_id='$_SESSION[ec_id]' LIMIT 1");
			}
			exit;
			break;
		case "load_audio":
			if($src!=""){
					require_once ("inc/iframe_music.php");
			}
			else{
				print "";
			}
			exit;
			break;
		case "sign_out":
			session_destroy();
			setcookie("set_remember_me","", $gmt_timestamp_now-31104000); //delete cookie
			setcookie("set_remember_me_crypt_pass","", $gmt_timestamp_now-31104000); //delete cookie
			print"<script language='javascript'>location.href='$ecard_url/index.php?'+ new Date().getTime();</script>";
			break;
		case "sendcard":
			$isResponsive ? require_once("inc/sendcard_mobile.php") : require_once("inc/sendcard.php");
			break;
		case "search_ecard":
			$search_what = isset($swhat) ? $swhat : $_SESSION['search_what_s'];
			$_SESSION['search_what_s'] = $search_what;
			if($search_what=="ecard"){
				require_once("inc/show_action.php");
			}
			else{
				require_once("inc/show_action_invite.php");
			}
			break;
		case "gotourl":
				$row_banner=get_row("max_banner","banner_url,banner_time_is_click","banner_id='$banner_id'");

				//Update banner_time_is_click
				update_field_in_db("max_banner","banner_time_is_click",$row_banner[banner_time_is_click]+1,"banner_id='$banner_id' LIMIT 1");
				print"<script>location.href='$row_banner[banner_url]';</script>";
				exit;
			break;

		case "popular":
		case "top_rate":
		case "new_ecards":
		case "random_card":
		case "pickup":
		case "tell_friends":
		case "newsletter":
		case "feedback":
		case "blacklist":
		case "play_games":
		case "send_card_over_limit":
		case "grabber":
		case "dob":
		case "join_now":
		case "quotes": 
		case "update_your_account":
		case "sign_in":
		case "load_addressbook":
		case "load_addressbook1":
		case "verify_account":
			require_once("inc/show_action.php");
			break;		
		
		case "help":
		case "tos":
		case "policy":
		case "about_us":
		
		case "grabber_install_ok":
			//You must create html language file example: english_lang_help.html / vietnamese_lang_tos.html / english_lang_grabber_install_ok.html
			$my_lang_file=str_replace(".php","_".$step.".html",$_SESSION[ecardmax_lang]);
			$array_global_var[print_object]=get_html_from_layout("templates/$cf_set_template/$my_lang_file");
			print_header_and_footer();
			break;
		case "print_ecard":
			require_once("inc/show_print_card.php");
			break;
        case "test":
            require_once("inc/test.php");
            break;
		case "category":
		default:
			if($cat_id==""){
				$isResponsive ?	require_once("inc/show_homepage_mobile.php") : require_once("inc/show_homepage.php");
			}
			else{
				require_once("inc/browse_category.php");
			}
	}
	//--------------------------------------------------------------------------------------
	function print_header_and_footer($social = false){
		global $isResponsive,$ecard_url,$cf_site_title,$cf_main_description,$cf_main_keyword,$array_global_var,$ecard_root,$cf_set_template,$lang,$button_select_languages,$_SESSION,$txt_welcome_guest,$button_join_now,$button_sign_in,$button_logout,$txt_mtool_myaccount,$txt_mtool_invitation,$txt_mtool_addressbook,$txt_mtool_calendar,$txt_mtool_myalbum,$txt_mtool_reminder,$txt_mtool_myfavorite,$txt_mtool_history,$txt_mtool_birthdayalert,$txt_mtool_sendvideocard,$url_invitation_home,$url_myaccount_home,$url_addressbook_home,$url_calendar_home,$url_reminder_home,$url_myalbum_home,$url_favorite_home,$url_history_home,$url_birthday_alert_home,$url_send_video_card_home,$thumb_card_url,$cf_logo_url,$cf_fb_link,$cf_pi_link,$cf_tw_link,$cf_gs_link,$url_grabber,$url_blacklist,$txt_media_grabber,$txt_black_list;
	
		//box share
		if($cf_fb_link==''&&$cf_pi_link==''&&$cf_tw_link==''&&$cf_gs_link=='')
		{
			echo "";
		}
		else
		{
			$links=array('fb','tw','pi','gs');
			$items="";
			if($isResponsive)
			{
				foreach($links as $value)
				{
					if($value == 'fb')
					{
						$faValue = 'facebook';
					}
					else if($value == 'tw')
					{
						$faValue = 'twitter';
					}
					else if($value == 'pi')
					{
						$faValue = 'pinterest';
					}
					else if($value == 'gs')
					{
						$faValue = 'google-plus';
					}
					$link="cf_".$value."_link";
					$item=$$link;
					if($item!='')
					{
						$items.="<li><a href='$item' target='_blank'><i class='fa fa-$faValue-square'></i></a><li>";
					}
				}
			}
			else
			{
				foreach($links as $value)
				{
					$link="cf_".$value."_link";
					$item=$$link;
					if($item!='')
					{
						$items.="<a href='$item' target='_blank'><img src='$ecard_url/templates/$cf_set_template/images/icon_".$value."_share.png' alt='Item share' /></a>";
					}
				}
			}
			set_global_var("items",$items);
			set_global_var("box_follow",get_html_from_layout("templates/$cf_set_template/box_follow.html"));
		}
		//
		
		if($thumb_card_url=='')
		{
			$thumb_card_url=$ecard_url."/logo/".$cf_logo_url;
			set_global_var("thumb_card_url",$thumb_card_url);
		}
		
		$url_join_now=get_global_var("url_join_now");
		$url_sign_in=get_global_var("url_sign_in");
		$url_sign_out=get_global_var("url_sign_out");
		//Print select language table
		$list_lang_file=get_list_file("$ecard_root/languages","_lang.php$");
		if(count($list_lang_file)>1){
			$show_list_language="";
			foreach($list_lang_file as $val){
				$lang_name_display=ucwords(str_replace("_lang.php","",$val));
				$lang_flag=str_replace(".php","_flag.gif",$val);
				if($isResponsive)
				$show_list_language .="<li><a href='javascript:;' onclick=\"Editme('$ecard_url/index.php?step=change_lang&lang=','$val','1',1,'id');info=document.URL.split('#');setTimeout('location.href=info[0];',800);\"><img src=\"$ecard_url/languages/$lang_flag\" alt=\"$val\" class='lang-flag'/> $lang_name_display</a><li>";
				else
				$show_list_language .="<div class=\"div_dropdown\" onmouseover=\"this.className='div_dropdown_hover';\" onmouseout=\"this.className='div_dropdown';\" onclick=\"Editme('$ecard_url/index.php?step=change_lang&lang=','$val','1',1,'id');info=document.URL.split('#');setTimeout('location.href=info[0];',800);\"><img border=\"0\" src=\"$ecard_url/languages/$lang_flag\" alt=\"\" style=\"vertical-align:middle\"/> $lang_name_display</div>";
			}
			//var_dump($show_list_language);
			set_global_var("show_list_language",$show_list_language);

			//Set language icon
			$lang_flag_src=str_replace(".php","_flag.gif",$_SESSION[ecardmax_lang]);
			$lang_flag="<img border=\"0\" alt=\"\" src=\"$ecard_url/languages/$lang_flag_src\" style=\"vertical-align:text-bottom\" />";
			set_global_var("include_div_select_lang",get_html_from_layout("templates/$cf_set_template/div_select_lang.html"));
			if($isResponsive)
			$array_global_var[show_select_language_button]="<a href=\"javascript:HideItAll();ShowDiv('button_select_lang','div_select_lang',0,0);\" id=\"button_select_lang\" >$lang_flag <span class='only-desktop'>$button_select_languages</span></a> ";
			else
			$array_global_var[show_select_language_button]="<a href=\"javascript:HideItAll();ShowDiv('button_select_lang','div_select_lang',0,0);\" id=\"button_select_lang\" >$button_select_languages $lang_flag</a> ";
		}
		$iconJoin = $iconLogin = $iconLogout = '';
	/*	if($isResponsive)
		{
			$iconJoin = '<i class="fa fa-user"></i> ';
			$iconLogin = '<i class="glyphicon glyphicon-log-in"></i> ';
			$iconLogout = '<i class="glyphicon glyphicon-log-out"></i> ';
		}
		*/
		//Set hello_user, login, logout, sign in button & member toolbar
		if($_SESSION[ecardmax_user]==""){//User not login
			//$array_global_var[hello_user]="$txt_welcome_guest";
			$array_global_var[joinnow_button]="<li id=\"joinnow\"><a href=\"$url_join_now\">$iconJoin$button_join_now</a></li>";
			$array_global_var[login_button]="<li id=\"loging\"><a href=\"$url_sign_in\">$iconLogin$button_sign_in</a></li>";
			//$array_global_var[login_fb]="<li id=\"loginfb\"><a href=\"#\">Login with facebook</a></li>";
		}
		else{//User already logged in
			$_SESSION[hello_user]=strip_tags($_SESSION[hello_user]);
			if($isResponsive)
			$array_global_var[hello_user]="<li><a href=\"$url_myaccount_home\">$iconJoin$_SESSION[hello_user]</a></li>";
			else
			$array_global_var[hello_user]="$_SESSION[hello_user]";
			$array_global_var[logout_button]="<li id=\"loging\"><a href=\"$ecard_url/index.php?step=sign_out\">$iconLogout$button_logout</a></li>";
		}

		$array_global_var[include_hidden_div]=get_html_from_layout("templates/$cf_set_template/header_and_footer_include_hidden_div.html");

		//Member toolbar
		$array_global_var[show_myaccount]="<a href=\"$url_myaccount_home\" class=\"membertool_link\">$txt_mtool_myaccount</a>";
		$array_global_var[show_invitation]="<a href=\"$url_invitation_home\" class=\"membertool_link\">$txt_mtool_invitation</a>";
		$array_global_var[show_addressbook]="<a href=\"$url_addressbook_home\" class=\"membertool_link\">$txt_mtool_addressbook</a>";
		$array_global_var[show_mycalendar]="<a href=\"$url_calendar_home\" class=\"membertool_link\">$txt_mtool_calendar</a>";
		$array_global_var[show_reminder]="<a href=\"$url_reminder_home\" class=\"membertool_link\">$txt_mtool_reminder</a>";
		$array_global_var[show_myalbum]="<a href=\"$url_myalbum_home\" class=\"membertool_link\">$txt_mtool_myalbum</a>";
		$array_global_var[show_favorite]="<a href=\"$url_favorite_home\" class=\"membertool_link\">$txt_mtool_myfavorite</a>";
		$array_global_var[show_history]="<a href=\"$url_history_home\" class=\"membertool_link\">$txt_mtool_history</a>";
		$array_global_var[show_grabber]="<a href=\"$url_grabber\" class=\"membertool_link\">$txt_media_grabber</a>&nbsp;&nbsp;&nbsp;";
		$array_global_var[show_blacklist]="<a href=\"$url_blacklist\" class=\"membertool_link\">$txt_black_list</a>&nbsp;&nbsp;&nbsp;";
		$array_global_var[show_birthdayalert]="<a href=\"$url_birthday_alert_home\" class=\"membertool_link\">$txt_mtool_birthdayalert</a>";
		$array_global_var[show_sendvideocard]="<a href=\"$url_send_video_card_home\" class=\"membertool_link\">$txt_mtool_sendvideocard</a>";

		
		//Meta tag keyword, description, & title
		if($array_global_var[meta_keyword]=="")$array_global_var[meta_keyword]=$cf_main_keyword;
		if($array_global_var[meta_description]=="")$array_global_var[meta_description]=$cf_main_description;
		if($array_global_var[my_site_title]=="")$array_global_var[my_site_title]=$cf_site_title;
		
		set_global_var2($array_global_var);
		if($isResponsive)
		{
			set_global_var('show_category_main_menu',get_html_from_layout("templates/$cf_set_template/show_category_main_menu.html"));
			set_global_var('show_category_main_menu_mobile',get_html_from_layout("templates/$cf_set_template/show_category_main_menu_mobile.html"));
			if($_SESSION[ecardmax_user]!="")
			set_global_var('show_account_tool',get_html_from_layout("templates/$cf_set_template/show_account_tool_main_menu.html"));
		}
		if($isMobile)
		{
			
		}
		$ecard_url_www = str_replace('http://','http://www.',$ecard_url);
		set_global_var('ecard_url_www',$ecard_url_www);
		if($social)
		print get_html_from_layout("templates/$cf_set_template/header_and_footer_social.html");
		else
		print get_html_from_layout("templates/$cf_set_template/header_and_footer.html");
	}

	//------------------------------------------------------------------
	function print_banner($banner_type="0"){
		global $ecard_url,$array_global_var,$cf_turn_hr_banner,$_SESSION;

		//Display random banner HR
		if($_SESSION[mg_show_banner] == "1"){
			$random_banner_row=get_row("max_banner","banner_id,banner_code,banner_time_is_show","banner_active='1' and banner_type ='$banner_type' Order by RAND() LIMIT 1");
			$banner_time_is_show = $random_banner_row[banner_time_is_show] + 1;
			update_field_in_db("max_banner","banner_time_is_show",$banner_time_is_show,"banner_id='$random_banner_row[banner_id]' LIMIT 1");	
			if($banner_type=="0"){
				$show_what="print_banner_hr";
			}
			elseif($banner_type=="1"){
				$show_what="print_banner_vt";
			}
			elseif($banner_type=="2"){
				$show_what="print_banner_center";
			}
			if($random_banner_row[banner_code] =="0"){
				set_global_var("$show_what","<script language=JavaScript src=\"$ecard_url/index.php?step=banner&banner_id=$random_banner_row[banner_id]\"></script>");
			}
			else{
				$random_banner_row[banner_code] = str_replace("&quot;","\"",$random_banner_row[banner_code]);
				set_global_var("$show_what",$random_banner_row[banner_code]);
			}
		}
	}

?>
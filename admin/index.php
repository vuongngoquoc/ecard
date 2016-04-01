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
	session_start();
	define("ECARDMAX", 1);
	$ecard_version="10.5";
	require_once ("../config.php");
	//require_once ("../config2.php");
	require_once("getvars.php");
	require_once ("function.php");
	//Get System Configuration 
	$list_cf=set_array_from_query("max_config","*");
	foreach($list_cf as $array_cf){
		$$array_cf[config_name]=$array_cf[config_value];
	}

	//SMTP Mail
	if($cf_sendmail_using_SMTP=="1")require_once("../pear/Mail.php");
	
	$lang =str_replace("/","",$lang);
	$lang =str_replace("..","",$lang);
	if((strpos($lang,"_lang.php")===false)){ //if false
		$lang="";
	}
	if($lang=="" && $_SESSION[admin_ecardmax_lang]==""){
		$lang=$cf_language;
	}
	elseif($lang=="" && $_SESSION[admin_ecardmax_lang]!=""){
		$lang=$_SESSION[admin_ecardmax_lang];
	}
	elseif($lang!=""){
		$_SESSION[admin_ecardmax_lang]=$lang;
	}
	if(file_exists("$ecard_root/languages/$lang")){
		$_SESSION[admin_ecardmax_lang]=$lang;
	}
	else{
		$_SESSION[admin_ecardmax_lang]=$cf_language;
	}
	
	if (!file_exists("$ecard_root/admin/languages/$_SESSION[admin_ecardmax_lang]")) {
		$_SESSION[admin_ecardmax_lang]="english_lang.php";
	}

	if($step=="change_lang"){
		$_SESSION[admin_ecardmax_lang]=$lang;
		exit;
	}
	
	//Include language files
	include("$ecard_root/admin/languages/$_SESSION[admin_ecardmax_lang]");
	if($ajaxstyle == "1") header("Content-Type:text/plain ; charset=$charset");

	$gmt_timestamp_now=adjust_timestamp($cf_timezone);
	$today_mon = date("n", $gmt_timestamp_now); //ex: 9
	$today_mday = date("j", $gmt_timestamp_now); //ex: 31
	$today_year = date("Y", $gmt_timestamp_now); //ex: 2006
	$week_daynumber=date("w", $gmt_timestamp_now); //ex: 0 (for Sunday) through 6 (for Saturday)

	$begin_today_timestamp=mktime(0,0,0,$today_mon,$today_mday,$today_year);
	$begin_today_timestamp=adjust_timestamp_user($begin_today_timestamp,$cf_timezone);
	$end_today_timestamp=$begin_today_timestamp + 86400 - 1;

	$begin_yesterday_timestamp=$begin_today_timestamp - 86400 ;
	$end_yesterday_timestamp=$begin_today_timestamp - 1 ;

	$begin_this_week_timestamp = $begin_today_timestamp - (86400 * ($wday+1));
	$end_this_week_timestamp = ($begin_this_week_timestamp + (86400 * 7))-1;

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
	$begin_this_month_timestamp=adjust_timestamp_user($begin_this_month_timestamp,$cf_timezone);
	$end_this_month_timestamp=($begin_this_month_timestamp+(86400*$day31))-1;

	$lang =str_replace("/","",$lang);
	$lang =str_replace("..","",$lang);
	if($lang=="")$lang=$cf_language;
	include("../geoipcity.inc");
	include ("../languages/$lang");

	$salt = $db_password;

	if($step=="log_in2"){
		if(isset($_POST[username]) && $_POST[username]==$admin_user && isset($_POST[password]) && $_POST[password]==$admin_password){						
			if ($salt == "") $salt ="38784035648867976";
			$crypt_pass = crypt($admin_password,$salt);
			$_SESSION[admin_login]=$crypt_pass;			
		}
		else{
			//Show login page
			set_global_var("error_msg","$login_page_error_id_pass_not_matching");
			print get_html_from_layout("admin/html/show_login.html");
			exit;
		}
	}
	elseif($step=="signout"){
		session_destroy();
		print get_html_from_layout("admin/html/show_login.html");
		exit;
	}	

	if ($salt == "") $salt ="38784035648867976";
	$crypt_pass = crypt($admin_password,$salt);

	if ($_SESSION[admin_login] != $crypt_pass){
		//Show login page
		print get_html_from_layout("admin/html/show_login.html");
		exit;
	}	
	
	$admin_login=$_SESSION[admin_login];
	if($ajaxstyle == "1") header("Content-Type:text/plain ; charset=$charset");

	switch($step){
		case "gd_info":
			/* Displays details of GD support on your server */
			echo '<div style="margin: 10px;">';
			echo '<p style="color: #444444; font-size: 130%;">GD is ';
			if (function_exists("gd_info")) {
				echo '<span style="color: #00AA00; font-weight: bold;">supported</span> by your server!</p>';
				$gd = gd_info();
				foreach ($gd as $k => $v) {
					echo '<div style="width: 340px; border-bottom: 1px solid #DDDDDD; padding: 2px;">';
					echo '<span style="float: left;width: 300px;">' . $k . '</span> ';
					if ($v)
						echo '<span style="color: #00AA00; font-weight: bold;">Yes</span>';
					else
						echo '<span style="color: #EE0000; font-weight: bold;">No</span>';
					
					echo '<div style="clear:both;"><!-- --></div></div>';
				}
			}
			else {
				echo '<span style="color: #EE0000; font-weight: bold;">not supported</span> by your server!</p>';
			}
			echo '</div>';
			exit;
			break;
		case "edit_me":
			update_field_in_db("$table","$edit_key",$edit_value,"$edit_id='$edit_id_value' LIMIT 1");
			if($table=="max_ecuser" && $edit_key=="user_mg_id"){
				//Get 2 free acct user_id
				$user_id_free1=get_dbvalue("max_ecuser","user_member1","user_id='$edit_id_value'");
				$user_id_free2=get_dbvalue("max_ecuser","user_member2","user_id='$edit_id_value'");
				if($user_id_free1!=""){
					update_field_in_db2("max_ecuser","user_mg_id='$edit_value'","user_name_id='$user_id_free1'");
				}
				if($user_id_free2!=""){
					update_field_in_db2("max_ecuser","user_mg_id='$edit_value'","user_name_id='$user_id_free2'");
				}
			}
			break;
		case "admin_calendar":
			require_once("admin_calendar.php");
			break;
		case "load_local_time":
			print DateFormat($gmt_timestamp_now);
			exit;
			break;

		case "admin_system_config":			
			require_once("admin_system_config.php");
			break;
		case "admin_show_main":
			require_once("admin_show_main.php");
			break;
		case "admin_show_keyword":
			require_once("admin_show_keyword.php");
			break;
		case "admin_view_black_list":
			require_once("admin_view_black_list.php");
			break;
		case "admin_ban_user":
			require_once("admin_ban_user.php");
			break;
		case "admin_cellphone_carrier":
			require_once("admin_cellphone_carrier.php");
			break;
		case "admin_database":
			require_once("admin_database.php");
			break;
		case "admin_member_group":
			require_once("admin_member_group.php");
			break;
		case "admin_member_display":
			require_once("admin_member_display.php");
			break;
		case "admin_member_display_inactive_account":
			require_once("admin_member_display_inactive_account.php");
			break;
		case "admin_member_view_album":
			require_once("admin_member_view_album.php");
			break;

		case "admin_set_price_ppc":
			require_once("admin_set_price_ppc.php");
			break;
		case "admin_manage_ecard":
			require_once("admin_manage_ecard.php");
			break;
		case "admin_manage_ecard_add_remove":
			require_once("admin_manage_ecard_add_remove.php");
			break;
		case "admin_manage_ecard_log":
			require_once("admin_manage_ecard_log.php");
			break;
		case "admin_manage_ecard_statistics":
			require_once("admin_manage_ecard_statistics.php");
			break;
		case "admin_manage_invite":
			require_once("admin_manage_invite.php");
			break;
		case "admin_manage_invite_add_remove":
			require_once("admin_manage_invite_add_remove.php");
			break;
		case "admin_manage_invite_log":
			require_once("admin_manage_invite_log.php");
			break;
		case "admin_manage_game":
			require_once("admin_manage_game.php");
			break;
		case "admin_option_java":
			require_once("admin_option_java.php");
			break;
		case "admin_option_skin":
			require_once("admin_option_skin.php");
			break;
		case "admin_option_stamp":
			require_once("admin_option_stamp.php");
			break;
		case "admin_manage_music_cat":
			require_once("admin_manage_music_cat.php");
			break;
		case "admin_option_music":
			require_once("admin_option_music.php");
			break;
		case "admin_option_poem":
			require_once("admin_option_poem.php");
			break;
		case "admin_option_quote":
			require_once("admin_option_quote.php");
			break;		
		case "admin_option_banner":
			require_once("admin_option_banner.php");
			break;

		case "admin_emailtool_recipient_group":
			require_once("admin_emailtool_recipient_group.php");
			break;
		case "admin_emailtool_create_message":
			require_once("admin_emailtool_create_message.php");
			break;
		case "admin_emailtool_sending":
			require_once("admin_emailtool_sending.php");
			break;

		case "admin_feedback_department":
			require_once("admin_feedback_department.php");
			break;
		case "admin_holiday_event":
			require_once("admin_holiday_event.php");
			break;	
		case "admin_option_logo":
			require_once("admin_option_logo.php");
			break;			
		case "admin_option_artist":
			require_once("admin_option_artist.php");
			break;
		default:
			require_once("admin_show_main.php");
	}	

	function print_admin_header_footer_page(){
		set_global_var("button_admin",get_html_from_layout("admin/html/button_admin.html"));
		set_global_var("button_member",get_html_from_layout("admin/html/button_member.html"));
		set_global_var("button_ecard",get_html_from_layout("admin/html/button_ecard.html"));
		//set_global_var("button_invitation",get_html_from_layout("admin/html/button_invitation.html"));
		//set_global_var("button_grabber",get_html_from_layout("admin/html/button_grabber.html"));
		set_global_var("button_option",get_html_from_layout("admin/html/button_option.html"));
		set_global_var("button_email",get_html_from_layout("admin/html/button_email.html"));
		// Show select language button
		print_select_language_button();
		
		$current_lang=str_replace("_lang.php","",$_SESSION[admin_ecardmax_lang]);
		set_global_var("current_lang",$current_lang);
		
		print get_html_from_layout("admin/html/header_and_footer.html");
	}
	
	function print_select_language_button() {
		global $ecard_root,$cf_set_template,$button_select_languages,$_SESSION,$ecard_url;
		
		$list_lang_file=get_list_file("$ecard_root/admin/languages","_lang.php$");
		if(count($list_lang_file)>1){
			$show_list_language="";
			foreach($list_lang_file as $val){
				$lang_name_display=ucwords(str_replace("_lang.php","",$val));
				$lang_flag=str_replace(".php","_flag.gif",$val);
				$show_list_language .="<div class=\"div_dropdown\" onmouseover=\"this.className='div_dropdown_hover';\" onmouseout=\"this.className='div_dropdown';\" onclick=\"Editme('index.php?step=change_lang&lang=','$val','1',1,'id');info=document.URL.split('#');setTimeout('location.href=info[0];',800);\"><img border=\"0\" src=\"languages/$lang_flag\" alt=\"\" style=\"vertical-align:middle;\"/> $lang_name_display</div>";
			}
			set_global_var("show_list_language",$show_list_language);
			
			//Set language icon
			$lang_flag_src=str_replace(".php","_flag.gif",$_SESSION[admin_ecardmax_lang]);
			$lang_flag="<img border=\"0\" alt=\"\" src=\"languages/$lang_flag_src\" style=\"vertical-align:text-bottom\" />";
			set_global_var("include_div_select_lang",get_html_from_layout("admin/html/div_select_lang.html"));
			set_global_var("show_select_language_button","<a href=\"javascript:HideItAll();ShowDiv('button_select_lang','div_select_lang',0,0);\" id=\"button_select_lang\" class=\"button_link\">$lang_flag $button_select_languages</a>");
		}
	}
?>
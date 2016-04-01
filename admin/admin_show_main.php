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
	
	// include patch information
	require_once("patch_info.php");

	//Check version
	//$ecardmax_offical_version=URLopen("http://ecardmax.com/ecardmax_version.txt");
	set_global_var("ecardmax_your_version","<span class=\"OK_Message\">$version</span>");
	//set_global_var("ecardmax_offical_version","<span class=\"Error_Message\">$ecardmax_offical_version</span>");

	//Count total member
	$members_total=get_dbvalue("max_ecuser","count(user_id)");
	set_global_var("members_total",$members_total);
	
	//Set timer
	//$begin_today_timestamp=gmmktime(0,0,0,$today_mon,$today_mday,$today_year);
	//$begin_yesterday_timestamp=$begin_today_timestamp - 86400 ;

	//Get member sign up today
	$members_today=get_dbvalue("max_ecuser","count(user_id)","user_member1<>'0' and user_date_signup >= $begin_today_timestamp and user_date_signup <= $end_today_timestamp");
	set_global_var("members_today",$members_today);

	//Member request cancel acct
	$members_cancel=get_dbvalue("max_ecuser","count(user_id)","user_request_cancel ='1'");
	set_global_var("members_cancel",$members_cancel);

	//Number of free acct
	$members_free=get_dbvalue("max_ecuser","count(user_id)","user_type = '0'");
	set_global_var("members_free",$members_free);

	//Number of paid acct
	$members_paid=get_dbvalue("max_ecuser","count(user_id)","user_mg_id<>'1' and user_mg_id<>'2'");
	set_global_var("members_paid",$members_paid);

	//Total eCards have been sent
	$ecard_create_total=get_dbvalue("max_config","config_value","config_name='cf_total_cardsent'");
	set_global_var("ecard_create_total",$ecard_create_total);

	//eCards create today
	$ecard_create_today=get_dbvalue("max_ecardsent","count(cs_id)","cs_date_create >= $begin_today_timestamp and cs_date_create <= $end_today_timestamp");
	set_global_var("ecard_create_today",$ecard_create_today);

	//eCards created yesterday
	$ecard_create_yesterday=get_dbvalue("max_ecardsent","count(cs_id)","cs_date_create >= $begin_yesterday_timestamp and cs_date_create < $begin_today_timestamp");
	set_global_var("ecard_create_yesterday",$ecard_create_yesterday);

	//Number of eCards in database
	$ecard_in_database=get_dbvalue("max_ecardsent","count(cs_id)");
	set_global_var("ecard_in_database",$ecard_in_database);

	//Number of eCards were not picked up.
	$ecard_not_pickup=get_dbvalue("max_ecardsent","count(cs_id)","cs_pkdate=0");
	set_global_var("ecard_not_pickup",$ecard_not_pickup);
	
	//PHP Version
	set_global_var("php_version",phpversion());
	
	//MySQL Version
	make_db_connect();
	set_global_var("mysql_version",mysql_get_server_info());

	//Number of language files
	set_global_var("number_language_file",count(get_list_file("$ecard_root/languages","_lang.php$")));

	//Image files were uploaded by members
	$number_member_image=get_dbvalue("max_ecard","count(ec_id)","ec_user_name_id<>''");
	set_global_var("number_member_image",$number_member_image);

	//Music files were uploaded by members
	$number_member_music=get_dbvalue("max_music","count(music_id)","music_user_name_id<>''");
	set_global_var("number_member_music",$number_member_music);

	//Poems were created by members
	$number_member_poem=get_dbvalue("max_poem","count(poem_id)","poem_user_name_id<>''");
	set_global_var("number_member_poem",$number_member_poem);

	//Server software
	set_global_var("server_software",$_SERVER["SERVER_SOFTWARE"]);
	
	//Database size
	$result = mysql_query("SHOW TABLE STATUS",make_db_connect());
	$database_size=0;
	while($array = mysql_fetch_array($result)) {
		$total = $array[Data_length]+$array[Index_length];
		$database_size=$database_size+$total;
	}
	set_global_var("database_size",number_format($database_size) . " bytes");

	set_global_var("print_object",get_html_from_layout("admin/html/admin_show_main.html"));
	print_admin_header_footer_page();
	exit;
	
?>
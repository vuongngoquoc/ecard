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

//	error_reporting('E_ALL ^ E_NOTICE'); 

	# MySQL Database information

	if($cf_friendly_url=="1"){
		set_global_var("url_home","$ecard_url/home.html");
		set_global_var("url_popular","$ecard_url/popular-cards.html");
		set_global_var("url_popular_change_page","$ecard_url/popular-cards/page/%page_no%");
		set_global_var("url_top_rate","$ecard_url/top-rate-cards.html");
		set_global_var("url_top_rate_change_page","$ecard_url/top-rate-cards/page/%page_no%");
		set_global_var("url_new_ecards","$ecard_url/new-ecards.html");
		set_global_var("url_new_ecards_change_page","$ecard_url/new-ecards/page/%page_no%");
		set_global_var("url_pickup","$ecard_url/pickup-cards.html");
		set_global_var("url_play_games","$ecard_url/play-games.html");
		set_global_var("url_tell_friends","$ecard_url/tell-friends.html");
		set_global_var("url_join_now","$ecard_url/join-now.html");
		set_global_var("url_about_us","$ecard_url/about-us.html");
		set_global_var("url_quotes","$ecard_url/quotes.html");
		$url_sign_in="$ecard_url/sign-in.html";
		$url_sign_out="$ecard_url/sign-out.html";
		//bottom links
		set_global_var("url_grabber","$ecard_url/media-grabber.html");
		set_global_var("url_blacklist","$ecard_url/black-list.html");
		set_global_var("url_random_card","$ecard_url/random-cards.html");
		set_global_var("url_newsletter","$ecard_url/newsletter.html");
		set_global_var("url_feedback","$ecard_url/feedback.html");
		set_global_var("url_policy","$ecard_url/private-policy.html");
		set_global_var("url_tos","$ecard_url/term-of-service.html");
		set_global_var("url_hello","$ecard_url/help.html");
		set_global_var("url_update_your_account","$ecard_url/update-your-account.html");
	}else{
		set_global_var("url_home","$ecard_url/index.php");
		set_global_var("url_popular","$ecard_url/index.php?step=popular");
		set_global_var("url_popular_change_page","$ecard_url/index.php?step=popular&page=%page_no%");
		set_global_var("url_top_rate","$ecard_url/index.php?step=top_rate");
		set_global_var("url_top_rate_change_page","$ecard_url/index.php?step=top_rate&page=%page_no%");
		set_global_var("url_new_ecards","$ecard_url/index.php?step=new_ecards");
		set_global_var("url_new_ecards_change_page","$ecard_url/index.php?step=new_ecards&page=%page_no%");
		set_global_var("url_pickup","$ecard_url/index.php?step=pickup");
		set_global_var("url_play_games","$ecard_url/index.php?step=play_games");
		set_global_var("url_tell_friends","$ecard_url/index.php?step=tell_friends");
		set_global_var("url_join_now","$ecard_url/index.php?step=join_now");
		set_global_var("url_about_us","$ecard_url/index.php?step=about_us");
		set_global_var("url_quotes","$ecard_url/index.php?step=quotes");
		$url_sign_in="$ecard_url/index.php?step=sign_in";
		$url_sign_out="$ecard_url/index.php?step=sign_out";
		//bottom links
		set_global_var("url_grabber","$ecard_url/index.php?step=grabber");
		set_global_var("url_blacklist","$ecard_url/index.php?step=blacklist");
		set_global_var("url_random_card","$ecard_url/index.php?step=random_card");
		set_global_var("url_newsletter","$ecard_url/index.php?step=newsletter");
		set_global_var("url_feedback","$ecard_url/index.php?step=feedback");
		set_global_var("url_policy","$ecard_url/index.php?step=policy");
		set_global_var("url_tos","$ecard_url/index.php?step=tos");
		
		set_global_var("url_update_your_account","$ecard_url/index.php?step=update_your_account");
	}
	
	$url_sign_in_next_step=($cf_friendly_url=="1") ? ("$ecard_url/sign-in/next-step/%next_step%") : ("$ecard_url/index.php?step=sign_in&next_step=%next_step%");
	$url_cards_browse_cate=($cf_friendly_url=="1") ? ("$ecard_url/category/%cat_id%/%cat_name%") : ("$ecard_url/index.php?step=category&cat_id=%cat_id%&title=%cat_name%");
	$url_cards_browse_cate_change_page=($cf_friendly_url=="1") ? ("$ecard_url/category/%cat_id%/%cat_name%/page/%page_no%") : ("$ecard_url/index.php?step=category&cat_id=%cat_id%&title=%cat_name%&page=%page_no%");
	$url_cards_browse_cate_sortby=($cf_friendly_url=="1") ? ("$ecard_url/category/%cat_id%/%cat_name%/sort-by/%sortby%") : ("$ecard_url/index.php?step=category&cat_id=%cat_id%&title=%cat_name%&sortby=%sortby%");
	$url_card_sendcard=($cf_friendly_url=="1") ? ("$ecard_url/cards/sendcard/%ec_id%/%ec_caption%") : ("$ecard_url/index.php?step=sendcard&ec_id=%ec_id%&ec_caption=%ec_caption%");
	
	function print_url_card_sendcard($ec_id,$ec_caption) {
		$ec_caption=str_replace(" ", "-",$ec_caption);
		global $url_card_sendcard;
		$url = str_replace("%ec_id%","$ec_id",$url_card_sendcard);
		$url = str_replace("%ec_caption%","$ec_caption",$url);
		return $url;
	}
	
	$url_card_resendcard=($cf_friendly_url=="1") ? ("$ecard_url/cards/resend-reply/%ec_id%/%ec_caption%") : ("$ecard_url/index.php?step=sendcard&ec_id=%ec_id%&ec_caption=%ec_caption%&resend=1&reply=1");
	
	function print_url_card_resendcard($ec_id,$ec_caption) {
		global $url_card_resendcard;
		$url = str_replace("%ec_id%","$ec_id",$url_card_resendcard);
		$url = str_replace("%ec_caption%","$ec_caption",$url);
		return $url;
	}
	
	$url_invitation_home=($cf_friendly_url=="1") ? ("$ecard_url/invitation.html") : ("$ecard_url/index.php?step=show_invitation");
	$url_myaccount_home=($cf_friendly_url=="1") ? ("$ecard_url/my-account.html") : ("$ecard_url/index.php?step=sign_in&next_step=show_myaccount");
	$url_addressbook_home=($cf_friendly_url=="1") ? ("$ecard_url/address-book.html") : ("$ecard_url/index.php?step=sign_in&next_step=show_addressbook");
	$url_calendar_home=($cf_friendly_url=="1") ? ("$ecard_url/calendar.html") : ("$ecard_url/index.php?step=sign_in&next_step=show_mycalendar");
	$url_reminder_home=($cf_friendly_url=="1") ? ("$ecard_url/reminder.html") : ("$ecard_url/index.php?step=sign_in&next_step=show_reminder");
	$url_myalbum_home=($cf_friendly_url=="1") ? ("$ecard_url/my-album.html") : ("$ecard_url/index.php?step=sign_in&next_step=show_myalbum");
	$url_favorite_home=($cf_friendly_url=="1") ? ("$ecard_url/favorite.html") : ("$ecard_url/index.php?step=sign_in&next_step=show_favorite");
	$url_history_home=($cf_friendly_url=="1") ? ("$ecard_url/history.html") : ("$ecard_url/index.php?step=sign_in&next_step=show_history");
	$url_birthday_alert_home=($cf_friendly_url=="1") ? ("$ecard_url/birthday-alert.html") : ("$ecard_url/index.php?step=sign_in&next_step=show_birthdayalert");
	$url_send_video_card_home=($cf_friendly_url=="1") ? ("$ecard_url/send-video-card.html") : ("$ecard_url/index.php?step=sign_in&next_step=show_sendvideocard");
	
	$url_invitation_browse_cate=($cf_friendly_url=="1") ? ("$ecard_url/invitation/%cat_id%/%cat_name%") : ("$ecard_url/index.php?step=show_invitation&cat_id=%cat_id%");
	$url_invitation_browse_cate_change_page=($cf_friendly_url=="1") ? ("$ecard_url/invitation/%cat_id%/%cat_name%/page/%page_no%") : ("$ecard_url/index.php?step=show_invitation&cat_id=%cat_id%&cat_name=%cat_name%&page=%page_no%");
	$url_invitation_all_card_page=($cf_friendly_url=="1") ? ("$ecard_url/invitation/page/%page_no%") : ("$ecard_url/index.php?step=show_invitation&page=%page_no%");
	$url_invitation_browse_cate_sortby=($cf_friendly_url=="1") ? ("$ecard_url/invitation/%cat_id%/%cat_name%/sort-by/%sortby%") : ("$ecard_url/index.php?step=show_invitation&cat_id=%cat_id%&cat_name=%cat_name%&sortby=%sortby%");
	$url_invitation_sendcard=($cf_friendly_url=="1") ? ("$ecard_url/send_invite/%iv_id%/%iv_name%") : ("$ecard_url/index.php?step=sendcard_invite&iv_id=%iv_id%");
	$url_print_ecard=($cf_friendly_url=="1") ? ("$ecard_url/print-card/%sent_card_id%") : ("$ecard_url/index.php?step=pickup&action=viewcopy&cs_id=%sent_card_id%&what=print");
	
	function print_url_print_ecard($sent_card_id) {
		global $url_print_ecard;
		$url = str_replace("%sent_card_id%","$sent_card_id",$url_print_ecard);
		return $url;
	}
	
	# Popular, Top-Rated, New Cards, Random Cards, Favorite Inviation cards
	$url_popular_invitation=($cf_friendly_url=="1") ? ("$ecard_url/invitation/popular-invitation") : ("$ecard_url/index.php?step=show_invitation_popular");
	$url_popular_invitation_change_page=($cf_friendly_url=="1") ? ("$ecard_url/popular-invitation/page/%page_no%") : ("$ecard_url/index.php?step=show_invitation_popular&page=%page_no%");
	$url_top_rated_invitation=($cf_friendly_url=="1") ? ("$ecard_url/invitation/toprated-invitation") : ("$ecard_url/index.php?step=show_invitation_top_rated");
	$url_top_rated_invitation_change_page=($cf_friendly_url=="1") ? ("$ecard_url/toprated-invitation/page/%page_no%") : ("$ecard_url/index.php?step=show_invitation_top_rated&page=%page_no%");
	$url_new_cards_invitation=($cf_friendly_url=="1") ? ("$ecard_url/invitation/new-invitation-cards") : ("$ecard_url/index.php?step=show_invitation_new_ecards");
	$url_new_cards_invitation_change_page=($cf_friendly_url=="1") ? ("$ecard_url/new-invitation-cards/page/%page_no%") : ("$ecard_url/index.php?step=show_invitation_new_ecards&page=%page_no%");
	$url_random_cards_invitation=($cf_friendly_url=="1") ? ("$ecard_url/invitation/random-invitation-cards") : ("$ecard_url/index.php?step=show_invitation_random_cards");
	$url_random_cards_invitation_change_page=($cf_friendly_url=="1") ? ("$ecard_url/random-invitation-cards/page/%page_no%") : ("$ecard_url/index.php?step=show_invitation_random_cards&page=%page_no%");
	$url_favorite_invitation=($cf_friendly_url=="1") ? ("$ecard_url/invitation/favorite-invitation-cards") : ("$ecard_url/index.php?step=show_invitation_favorite");
	$url_favorite_invitation_change_page=($cf_friendly_url=="1") ? ("$ecard_url/favorite-invitation-cards/page/%page_no%") : ("$ecard_url/index.php?step=show_invitation_favorite&page=%page_no%");
	$url_search_ecard_keyword=($cf_friendly_url=="1") ? ("$ecard_url/search-ecard/keyword/%keyword%") : ("$ecard_url/index.php?step=search_ecard&keyword=%keyword%");
	$url_search_ecard_keyword_change_page=($cf_friendly_url=="1") ? ("$ecard_url/search-ecard/keyword/%keyword%/page/%page_no%") : ("$ecard_url/index.php?step=search_ecard&keyword=%keyword%&page=%page_no%");
	$url_date_of_birth_user=($cf_friendly_url=="1") ? ("$ecard_url/date-of-birthday/user/%user_id%/email/%book_email%") : ("$ecard_url/index.php?step=dob&user_id=%user_id%&book_email=%book_email%");
	
	function print_sign_in_next_step($next_step) {
		global $url_sign_in_next_step;
		$url = str_replace("%next_step%","$next_step",$url_sign_in_next_step);
		return $url;
	}
	
	function print_url_date_of_birth_user($user_id,$book_email) {
		global $url_date_of_birth_user;
		$url = str_replace("%user_id%","$user_id",$url_date_of_birth_user);
		$url = str_replace("%book_email%","$book_email",$url);
		return $url;
	}
	
	function print_url_search_ecard_keyword($keyword) {
		global $url_search_ecard_keyword;
		$url = str_replace("%keyword%","$keyword",$url_search_ecard_keyword);
		return $url;
	}
	
	function print_url_cards_browse_cate($cat_id,$cat_name) {
		$cat_name=str_replace(" ", "-",$cat_name);
		global $url_cards_browse_cate;
		$url = str_replace("%cat_id%","$cat_id",$url_cards_browse_cate);
		$url = str_replace("%cat_name%","$cat_name",$url);
		return $url;
	}
	
	function print_url_popular_invitation_change_page($page) {
		global $url_popular_invitation_change_page;
		$url = str_replace("%page_no%","$page",$url_popular_invitation_change_page);
		return $url;
	}
	
	function print_url_invitation_browse_cate($cat_id,$cat_name) {
		$cat_name=str_replace(" ", "-",$cat_name);
		global $url_invitation_browse_cate;
		$url = str_replace("%cat_id%","$cat_id",$url_invitation_browse_cate);
		$url = str_replace("%cat_name%","$cat_name",$url);
		return $url;
	}
	
	function print_url_invitation_sendcard($iv_id,$iv_name) {
		global $url_invitation_sendcard;
		$url = str_replace("%iv_id%","$iv_id",$url_invitation_sendcard);
		$url = str_replace("%iv_name%","$iv_name",$url);
		$url = str_replace(" ","-",$url);
		$url = str_replace("","-",$url);
		return $url;
	}
?>
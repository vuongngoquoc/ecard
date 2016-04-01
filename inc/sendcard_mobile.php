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
|   Purchase Info: http://www.ecardmax.com/purchase
|   Request Installation: http://www.ecardmax.com/ehelpmax
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
	if(ECARDMAX_USER!=1)exit;
	
	//GET MENU 2 LEVEL
	require_once ("show_category.php");
	get_category_2_level($cat_id,$cat_id_hilight);
	//END
	//Sender name default
	if($_SESSION[user_name]!="" && $_SESSION[user_last_name]!="" && $_SESSION[user_email]!="")$from_sender_name="$_SESSION[user_name] $_SESSION[user_last_name] ($_SESSION[user_email])";
	if($resend=="1" && $reply!="1"){
		if($_SESSION[ecardmax_user]==""){
			$from_sender_name="$_COOKIE[cookie_cs_from_name] ($_COOKIE[cookie_cs_from_email])";
		}
		else{
			$from_sender_name="$_SESSION[user_name] $_SESSION[user_last_name] ($_SESSION[user_email])";
		}
	}
	elseif($resend=="1" && $reply=="1" ){
		if($_SESSION[ecardmax_user]==""){
			$from_sender_name="$_SESSION[remember_recipient_name] ($_SESSION[remember_recipient_email])";
		}
		else{
		$from_sender_name="$_SESSION[user_name] $_SESSION[user_last_name] ($_SESSION[user_email])";
		}
	}
	
	

	//Get ec_id detail
	// save for later use
	$_SESSION[my_cardid]="$ec_id";
	$ec_row=get_row("max_ecard","*","ec_id='$ec_id'");

	$ec_caption=$ec_row[ec_caption];
	$ec_keyword=$ec_row[ec_keyword];
	$ec_detail=$ec_row[ec_detail];
	$email_subject_from_name=str_replace("%FROM_NAME%","$_SESSION[user_name] $_SESSION[user_last_name]",$send_an_ecard);
	
	if($what=="sendvideocard" || $what=="send_to_friends"){
		$embed_text=$_POST[embed_text];
		$pattern='/width=\\\"[0-9]+\\\"/i';
		$replacement='width=\"700\"';
		$embed_text=preg_replace($pattern, $replacement, $embed_text);
		
		$pattern='/height=\\\"[0-9]+\\\"/i';
		$replacement='height=\"500\"';
		$embed_text=preg_replace($pattern, $replacement, $embed_text);
		
		set_global_var("embed_text",urldecode($embed_text));
		set_global_var("embed_text1",urlencode($embed_text));
		
	}else if($ec_row[ec_id]==""){//eCard ID not found -> go to homepage
		header("Location:$ecard_url/index.php\n");
		exit;
	}

	//Save card to database & send email to Recipient
	if($what=="send_to_friends"){
		require_once("sendcard_send_to_friend.php");
		exit;
	}

	if($what=="share_to_friends"){
		require_once("sendcard_share_to_friend.php");
		exit;
	}
	
	foreach($ec_row as $key=>$val){
		$_SESSION[$key]=$val;
	}
	$_SESSION[iv_id]="";
	
	if($ec_row[ec_embed]){
		set_global_var("cardtype","embed");
	}else{
		set_global_var("cardtype","");
	}
	if($_SESSION['ec_oauth_token']!="" && $_SESSION['ec_oauth_secret']!=""){
		set_global_var("oAuth","true");
	}else{
		set_global_var("oAuth","");
	}
	
	//Get imagesize W&H of fullsize image
		if(file_exists("$ecard_root/resource/picture/$ec_row[ec_cat_dir]/$ec_row[ec_filename]") && $ec_row[ec_cat_dir] != '') {
		list($fullW,$fullH)=getimagesize("$ecard_root/resource/picture/$ec_row[ec_cat_dir]/$ec_row[ec_filename]");
	}
	else {
		$fullW = $fullH = null ;
	}
	
	$sendcard_txt_download_java=str_replace('"','\\"',$sendcard_txt_download_java);	
	$sendcard_txt_download_flash=str_replace('"','\\"',$sendcard_txt_download_flash);

	//Poem
	if($resend=="1" && $_SESSION[resend_cs_poem]!=""){
		$poem_id=$_SESSION[resend_cs_poem];
		$poem_id_align=$_SESSION[resend_cs_poem_align];
	}
	elseif($resend!="1" && $_SESSION[user_design_ecard]=="1" && $_SESSION[ud_cs_poem_id]!="" && $_SESSION[ud_ec_id]==$ec_row[ec_id]){
		$poem_id=$_SESSION[ud_cs_poem_id];
		$poem_id_align=$_SESSION[ud_cs_poem_align];
	}
	else {
		$poem_id=$ec_row[ec_poem_id];
		$poem_id_align="";
	}
	$cs_poem=$poem_id;
	
	//Advance option buttons (button image effect, skin backgroun, stamp, music ...)
	if($cf_show_advance_option_button=="1"){
		require_once("responsive/sendcard_advance_option.php");		
	}

	//Show card body
	if($ec_row[ec_skin]=="")$ec_row[ec_skin]=$cf_default_skin;
	if($resend=="1" && $_SESSION[resend_cs_skin_name]!=""){
		$ec_row[ec_skin]=$_SESSION[resend_cs_skin_name];
	}
	elseif($resend!="1" && $_SESSION[user_design_ecard]=="1" && $_SESSION[ud_cs_skin_name]!="" && $_SESSION[ud_ec_id]==$ec_row[ec_id]){
		$ec_row[ec_skin]=$_SESSION[ud_cs_skin_name];
	}
	$cs_skin_name=$ec_row[ec_skin];
 
	if(file_exists("$ecard_root/resource/skin/$ec_row[ec_skin]/bar.gif")){
		$bar="bar.gif";
	}
	elseif(file_exists("$ecard_root/resource/skin/$ec_row[ec_skin]/bar.jpg")){
		$bar="bar.jpg";
	}
	elseif(file_exists("$ecard_root/resource/skin/$ec_row[ec_skin]/bar.png")){
		$bar="bar.png";
	}
	elseif(file_exists("$ecard_root/resource/skin/$ec_row[ec_skin]/bar.swf")){
		$bar="bar.swf";
	}
	list($barW,$barH)=getimagesize("$ecard_root/resource/skin/$ec_row[ec_skin]/$bar");
	$img_bar="$ecard_url/resource/skin/$ec_row[ec_skin]/$bar,$barW,$barH"; 

	if(file_exists("$ecard_root/resource/skin/$ec_row[ec_skin]/bkg.gif")){
		$bkg="bkg.gif";
	}
	elseif(file_exists("$ecard_root/resource/skin/$ec_row[ec_skin]/bkg.jpg")){
		$bkg="bkg.jpg";
	}
	elseif(file_exists("$ecard_root/resource/skin/$ec_row[ec_skin]/bkg.png")){
		$bkg="bkg.png";
	}
	$img_bkg="$ecard_url/resource/skin/$ec_row[ec_skin]/$bkg"; 

	if(file_exists("$ecard_root/resource/skin/$ec_row[ec_skin]/bottom.gif")){
		$bottom="bottom.gif";
	}
	elseif(file_exists("$ecard_root/resource/skin/$ec_row[ec_skin]/bottom.jpg")){
		$bottom="bottom.jpg";
	}
	elseif(file_exists("$ecard_root/resource/skin/$ec_row[ec_skin]/bottom.png")){
		$bottom="bottom.png";
	}
	elseif(file_exists("$ecard_root/resource/skin/$ec_row[ec_skin]/bottom.swf")){
		$bottom="bottom.swf";
	}
	list($bottomW,$bottomH)=getimagesize("$ecard_root/resource/skin/$ec_row[ec_skin]/$bottom");
	$img_bottom="$ecard_url/resource/skin/$ec_row[ec_skin]/$bottom,$bottomW,$bottomH";  

	if(file_exists("$ecard_root/resource/skin/$ec_row[ec_skin]/icon.gif")){
		$icon="icon.gif";
	}
	elseif(file_exists("$ecard_root/resource/skin/$ec_row[ec_skin]/icon.jpg")){
		$icon="icon.jpg";
	}
	elseif(file_exists("$ecard_root/resource/skin/$ec_row[ec_skin]/icon.png")){
		$icon="icon.png";
	}
	elseif(file_exists("$ecard_root/resource/skin/$ec_row[ec_skin]/icon.swf")){
		$icon="icon.swf";
	}
	list($iconW,$iconH)=getimagesize("$ecard_root/resource/skin/$ec_row[ec_skin]/$icon");
	$img_icon="$ecard_url/resource/skin/$ec_row[ec_skin]/$icon,$iconW,$iconH"; 

	if(file_exists("$ecard_root/resource/skin/$ec_row[ec_skin]/top.gif")){
		$top="top.gif";
	}
	elseif(file_exists("$ecard_root/resource/skin/$ec_row[ec_skin]/top.jpg")){
		$top="top.jpg";
	}
	elseif(file_exists("$ecard_root/resource/skin/$ec_row[ec_skin]/top.png")){
		$top="top.png";
	}
	elseif(file_exists("$ecard_root/resource/skin/$ec_row[ec_skin]/top.swf")){
		$top="top.swf";
	}
	list($topW,$topH)=getimagesize("$ecard_root/resource/skin/$ec_row[ec_skin]/$top");
	$img_top="$ecard_url/resource/skin/$ec_row[ec_skin]/$top,$topW,$topH";
	
	if(file_exists("$ecard_root/resource/skin/$ec_row[ec_skin]/poem.gif")){
		$poem="poem.gif";
	}
	elseif(file_exists("$ecard_root/resource/skin/$ec_row[ec_skin]/poem.jpg")){
		$poem="poem.jpg";
	}
	elseif(file_exists("$ecard_root/resource/skin/$ec_row[ec_skin]/poem.png")){
		$poem="poem.png";
	}
	elseif(file_exists("$ecard_root/resource/skin/$ec_row[ec_skin]/poem.swf")){
		$poem="poem.swf";
	}
	list($poemW,$poemH)=getimagesize("$ecard_root/resource/skin/$ec_row[ec_skin]/$poem");
	$img_poem="$ecard_url/resource/skin/$ec_row[ec_skin]/$poem,$poemW,$poemH";  

	//Stamp
	if($ec_row[ec_stamp_filename]=="")$ec_row[ec_stamp_filename]=$cf_default_stamp;
	if($resend=="1" && $_SESSION[resend_cs_stamp_filename]!=""){
		$ec_row[ec_stamp_filename]=$_SESSION[resend_cs_stamp_filename];
	}
	elseif($resend!="1" && $_SESSION[user_design_ecard]=="1" && $_SESSION[ud_cs_stamp_filename]!="" && $_SESSION[ud_ec_id]==$ec_row[ec_id]){
		$ec_row[ec_stamp_filename]=$_SESSION[ud_cs_stamp_filename];
	}
	$cs_stamp_filename=$ec_row[ec_stamp_filename]; 
	$stamp_url="$ecard_url/resource/stamp/$ec_row[ec_stamp_filename]"; 

	//Fullsize card url
	//Don't forget watermark	
	
	//Java applet & fullsize url
	if (isset($embed_text) && preg_match("/((http\:\/\/){0,}(www\.){0,}(youtube\.com){1} || (youtu\.be){1}(\/watch\?v\=[^\s]){1})/", $embed_text) == 1)
	{
	    $fullsize_card_url="youtube_link";
		$fullsize_card_url_1=$youtube_link;
	}
	else if (preg_match('/^.*\.(mp4|mov)$/i', $ec_row[ec_filename]) == 1)
	{
	    $fullsize_card_url="videofile";
	    $fullsize_card_url_1="resource/picture/$ec_row[ec_cat_dir]/$ec_row[ec_filename]";
	}
	else if((strpos($ec_row[ec_filename],".swf")===false)){
		if($ec_row[ec_thumbnail]=="")
		{
			$youtube_link=$ec_row[ec_filename];
			if(strpos($youtube_link,'&')!=0)
			{
				$vitri=strlen($youtube_link)-strpos($youtube_link,'&');
				$youtube_link_strim=substr($youtube_link,strpos($youtube_link,'v=')+2,-$vitri);
			}
			else
			{
				$youtube_link_strim=substr($youtube_link,strpos($youtube_link,'v=')+2);
			}
			$fullsize_card_url="youtube_link";
			$fullsize_card_url_1=$youtube_link;
		}
		else if(!(strpos($ec_row[ec_filename],".html")===false))
		{
			$fullsize_card_url="html_card";
			$card_html_code=get_html_from_layout("resource/picture/$ec_row[ec_cat_dir]/$ec_row[ec_filename]");		
			$card_html_code=str_replace("\t","",$card_html_code);
			$card_html_code=str_replace("\n","",$card_html_code);
			$card_html_code=str_replace("\r","",$card_html_code);
			$js_match = 'html';
			if (preg_match("#</*(script)[^>]*>#i",$card_html_code)) {
				$js_match = 'js_html';
			}
					
			$icon = print_image($img_icon);
			if($js_match == 'js_html'){
				$user_message=str_replace("&quot;","",$user_message);
				$card_html_code_js=get_html_from_layout("templates/$cf_set_template/card_html_code_js.html");
				unset($card_html_code);
			}
			
			//$card_html_code=str_replace("\"","&quot;",$card_html_code);
		}
		else
		{
			if($resend=="1" && $_SESSION[resend_cs_java]!="" && $_SESSION[resend_cs_java]!="-1"){
				$ec_row[ec_applet]=$_SESSION[resend_cs_java];
			}
			elseif($resend!="1" && $_SESSION[user_design_ecard]=="1" && $_SESSION[ud_cs_java]!="-1" && $_SESSION[ud_ec_id]==$ec_row[ec_id]){
				$ec_row[ec_applet]=$_SESSION[ud_cs_java];
			}
			if($ec_row[ec_applet]!=""){			
				$cs_java=$ec_row[ec_applet];
	
				$get_pixel="width=$fullW height=$fullH";
				$centerX=round(500/2);
				$centerY=round(375/2);
				$applet_code=get_file_content("$ecard_root/resource/applet/$ec_row[ec_applet]/code.txt");
				$applet_code=str_replace("\r\n",' ',$applet_code);
				$applet_code=str_replace("\"","'",$applet_code);
				$applet_code = str_replace("anfy_key", $cf_anfy_java_keycode, $applet_code) ;
				$applet_code = str_replace("ds_key", $cf_ds_java_keycode, $applet_code) ;
				$applet_code = str_replace("cgi2k_key", $cf_cgi2k_java_keycode, $applet_code) ;
				$applet_code = str_replace("codebase", "codebase=$ecard_url/resource/applet/$ec_row[ec_applet]", $applet_code) ;
				$applet_code = str_replace("change_pixel", $get_pixel, $applet_code) ;
				$applet_code = str_replace("centerX", $centerX, $applet_code) ;
				$applet_code = str_replace("centerY", $centerY, $applet_code) ;
				$applet_code = str_replace("change_path", "$ecard_url/resource/applet/$ec_row[ec_applet]", $applet_code) ;
				$applet_code.="<br /><br />$sendcard_txt_download_java";
				$java_applet=$applet_code; 
			}
			if ($cf_enable_watermark=="1") {
				if($_SESSION[mg_show_watermark]=="1"){
					$show_watermark=true;
				}
				else {
					$show_watermark=false;
				}
			}
			else {
				$show_watermark=false;
			}
			if ($show_watermark&&(strpos($ec_row[ec_filename],".gif")===false)) {
				$fullsize_card_url="$ecard_url/index.php?step=watermark&ec_id=$ec_id,$fullW,$fullH";
			}
			else {
				$fullsize_card_url="$ecard_url/resource/picture/$ec_row[ec_cat_dir]/$ec_row[ec_filename],$fullW,$fullH";
			}
		}
	}
	else{
			$fullsize_card_url="$ecard_url/resource/picture/$ec_row[ec_cat_dir]/$ec_row[ec_filename],$fullW,$fullH";
			$fullsize_card_url_1="$ecard_url/resource/picture/$ec_row[ec_cat_dir]/$ec_row[ec_filename]";
			set_global_var("preview_flash","embed");
	 }

	//Text color
	$text_color=get_dbvalue("max_skin","skin_text_color","skin_dirname='$ec_row[ec_skin]'");

	//Audio default
	if($resend=="1" && $_SESSION[resend_cs_music_filename]!=""){
		$ec_row[ec_music_filename]=$_SESSION[resend_cs_music_filename];
		$ec_row[ec_music_id]=$_SESSION[resend_cs_music_id];
	}
	elseif($resend!="1" && $_SESSION[user_design_ecard]=="1" && $_SESSION[ud_cs_music_filename]!="" && $_SESSION[ud_ec_id]==$ec_row[ec_id]){
		$ec_row[ec_music_filename]=$_SESSION[ud_cs_music_filename];
		$ec_row[ec_music_id]=$_SESSION[ud_cs_music_id];
	}
	if($ec_row[ec_music_filename]!=""){
		$cs_music_filename=$ec_row[ec_music_filename]; 
		$cs_music_id=$ec_row[ec_music_id];
		$music_cat_id=get_dbvalue("max_music","ec_cat_id","music_id='$cs_music_id'");
		$music_cat_dir=get_dbvalue("max_music_cat","cat_dir","cat_id='$music_cat_id'");
		$audio_file="resource/music/$music_cat_dir/$ec_row[ec_music_filename]";
	}
	$audio_title=get_dbvalue("max_music","music_name_display","music_filename='$ec_row[ec_music_filename]'");
	

	//Date created card default
	$date_created=DateFormat($gmt_timestamp_now);
	$cat_id=$ec_row[ec_cat_id];	
	
	//Default message
	if($resend=="1"){
		$user_message=$_SESSION[resend_cs_message];
	}
	else{
		$user_message=$sendcard_demo_mess;
	}
	$user_message=str_replace("\r\n"," ",$user_message);
	$user_message=str_replace("\n"," ",$user_message);
	$user_message=str_replace("\"","&quot;",$user_message);
	$cs_message=str_replace("&quot;","\"",$user_message);
	if($ec_row[ec_embed]==1 && $resend=="1"){
		set_global_var("resend_message","&sender=$_SESSION[user_last_name]&yourmessage=$user_message");
		$user_message="";
	}
		
	//Display go to category name (more card button)
	if($cf_show_ecard_info_box=="1"){
		$get_cat_name=$display_cat_name;
	}
	else{
		$ec_cat_row=get_row("max_category","*","cat_id='$ec_row[ec_cat_id]'");
		$my_lang_name="cat_".str_replace(".php","",$_SESSION[ecardmax_lang]);
		if($ec_cat_row[$my_lang_name]==""){
			$get_cat_name=$ec_cat_row[cat_name_display];
		}
		else{
			$get_cat_name=$ec_cat_row[$my_lang_name];
		}
	}
	$url_go_to_category=print_url_cards_browse_cate($cat_id,$ec_cat_row[cat_name_display]);
	$goto_category_name="$show_card_body_goto_category_name <strong>$get_cat_name</strong>";
	
	//Print button Next step or Join now to send card (if not login) & also button Add to Favorite 
	if($_SESSION[ecardmax_user]==""){//Guest - Not login
		if(!(strpos($ec_row[ec_group_relate_id],",1,")===false)){//Match -> guest can send this card
			if ($can_send_ecard = get_dbvalue("max_member_group","mg_allow_send_card","mg_id='1'")) { // if guest member group is allowed to send cards
				$show_login = false;
			}
			else { // if guest member group is not allowed to free send cards => Show join now button
				$show_login = true;
			}			
		}
		else{//not match need to login
			$show_login = true;
		}
		
		if ($show_login) {
			$button_add_to_fav="<a class=\"btn btn-default btn-sm\" id=\"button_add_to_fav\" href=\"$url_sign_in\">$sendcard_php_button_add_to_fav</a>";
			$button_next_step="<a class=\"btn btn-default btn-sm btn-my-site\" id=\"button_show_personalize_table\" href=\"$url_sign_in\">$sendcard_php_button_join_now_to_send</a>";
			$display_personalize_table=0;
		}
		else {
			
			$button_add_to_fav="<a class=\"btn btn-default btn-sm\" id=\"button_add_to_fav\" href=\"$url_sign_in\">$sendcard_php_button_add_to_fav</a>";
			$button_next_step="<a class=\"btn btn-default btn-sm btn-my-site\" id=\"button_show_personalize_table\" href=\"javascript:void(0);\" onclick=\"ShowPersonalizeTable();\">$sendcard_php_button_continue_next_step</a>";
			$display_personalize_table=1;
		}
	} //login
	else{
		
		
		if(!(strpos($ec_row[ec_group_relate_id],",$_SESSION[user_mg_id],")===false) || !(strpos($ec_row[ec_group_relate_id],",1,")===false)){//Match -> member ground can send this card
			if ($can_send_ecard = get_dbvalue("max_member_group","mg_allow_send_card","mg_id='$_SESSION[user_mg_id]'")) { // if free member group is allowed to send cards
				$show_balance_payment = false;
		
			}
			else { // if member groups is not allow to send ecards. => show upgrade account button

				$show_balance_payment = true;
				
			}
		}
		else{
			$show_balance_payment = true;	
		}
		
		if ($show_balance_payment) {
			//Check acct balance to see if enough money to pay per card
			$ppc_row=get_row("max_paypercard","*","ppc_id='$ec_row[ec_ppc_id]'");
			$get_ppc_amount = $ppc_row[ppc_amount];
			$get_ppc_amount += 0.00;
			$get_user_balance=get_dbvalue("max_ecuser","user_balance","user_id='$_SESSION[user_id]'");
			$get_user_balance += 0.00;
			if(($get_user_balance >= $get_ppc_amount) && $get_user_balance >= 0){
				$can_send_ecard = true;
				if ($can_send_ecard || $ec_id=="") {
					if ($cf_ppc=="") {
						$cf_ppc=1;
					}
					if ($cf_ppc==1){
					$button_add_to_fav="<a class=\"btn btn-default btn-sm\" id=\"button_add_to_fav\" href=\"javascript:void(0);\" onclick=\"Editme('$ecard_url/index.php?step=add_to_fav&ec_id=','$ec_id','1',1,'button_add_to_fav');\">$sendcard_php_button_add_to_fav</a>";
					$button_next_step="<a class=\"btn btn-default btn-sm btn-my-site\" id=\"button_show_personalize_table\" href=\"javascript:void(0);\" onclick=\"ShowPersonalizeTable();\">$sendcard_php_button_continue_next_step</a>";
					$display_personalize_table=1;
					//$myaccount_ppc_message_enough_money=str_replace("%show_user_balance%",price_format($get_user_balance),$myaccount_ppc_message_enough_money);
					//$myaccount_ppc_message_enough_money=str_replace("%show_card_amount%",price_format($get_ppc_amount),$myaccount_ppc_message_enough_money);
					//$show_ppc_message="<div style=\"text-align:center\" class=\"OK_Message\">$myaccount_ppc_message_enough_money</div><br />";
					$show_new_acct_balance=1;
					}else{
						$button_add_to_fav="<a class=\"btn btn-default btn-sm\" id=\"button_add_to_fav\" href=\"".get_global_var(url_update_your_account)."\">$myaccount_button_upgrade_account</a>";
						$display_personalize_table=0;
						$show_ppc_message="<div style=\"text-align:center\" class=\"OK_Message\">$myaccount_ppc_message_upgrade_account</div><br />";
					}
				}
				else {
					$button_add_to_fav="<a class=\"btn btn-default btn-sm\" id=\"button_add_to_fav\" href=\"".get_global_var(url_update_your_account)."\">$myaccount_button_upgrade_account</a>";
					$display_personalize_table=0;
					
					$show_ppc_message="<div style=\"text-align:center\" class=\"OK_Message\">$myaccount_ppc_message_upgrade_account</div><br />";
				}				
			}
			else{
				$button_add_to_fav="<a class=\"btn btn-default btn-sm\" id=\"button_add_to_fav\" href=\"javascript:void(0);\" onclick=\"Editme('$ecard_url/index.php?step=add_to_fav&ec_id=','$ec_id','1',1,'button_add_to_fav');\">$sendcard_php_button_add_to_fav</a>";
				$button_next_step="<a class=\"btn btn-default btn-sm btn-my-site\" id=\"button_show_personalize_table\" href=\"".get_global_var(url_update_your_account)."\" >$sendcard_php_button_update_account_to_send</a>";
				$display_personalize_table=0;
				
				$_SESSION[ecqid]= substr(md5(uniqid(rand(),1)), 0, 8);
				if(!(strpos($ppc_row[ppc_payment_method1],"2checkout.com")===false)){ //if 2CO sell link
					$ppc_row[ppc_payment_method1].="&fixed=Y&ec_id=$ec_id&ecqid=$_SESSION[ecqid]&user_name_id=$_SESSION[user_name_id]";
					if($cf_enable_2co_test_mode=="1")$ppc_row[ppc_payment_method1].="&demo=Y";
				}
				elseif(!(strpos($ppc_row[ppc_payment_method1],"paypal.com")===false)){ //if Paypal sell link
					// rewrite payment URL according to mode
					if ($cf_enable_paypal_test_mode==1) { 
						$ppc_row[ppc_payment_method1] = str_replace("www.paypal.com","www.sandbox.paypal.com",$ppc_row[ppc_payment_method1]);
						$ppc_row[ppc_payment_method1] = str_replace($cf_paypal_primary_email,$cf_paypal_test_email,$ppc_row[ppc_payment_method1]);
					}
					else {
						$ppc_row[ppc_payment_method1] = str_replace("www.sandbox.paypal.com","www.paypal.com",$ppc_row[ppc_payment_method1]);
						$ppc_row[ppc_payment_method1] = str_replace($cf_paypal_test_email,$cf_paypal_primary_email,$ppc_row[ppc_payment_method1]);
					}
					$ppc_row[ppc_payment_method1].="&item_number=PayPerCard&invoice=$_SESSION[ecqid]&custom=$_SESSION[user_name_id],$ec_id";
				}

				if($ppc_row[ppc_buynow_title1]!="" && $ppc_row[ppc_payment_method1]!=""){
					$ppc_payment_method1=$ppc_row[ppc_payment_method1];
					$ppc_buynow_title1=$ppc_row[ppc_buynow_title1];
					$get_ppc_amount=price_format($get_ppc_amount);
					$button_buynow1="<a href=\"$ppc_payment_method1\" class=\"btn btn-default btn-sm\">$ppc_buynow_title1 <strong>$get_ppc_amount</strong></a>";
				}
				else{
					$button_buynow1="";
				}

				if(!(strpos($ppc_row[ppc_payment_method2],"2checkout.com")===false)){ //if 2CO sell link
					$ppc_row[ppc_payment_method2].="&fixed=Y&ec_id=$ec_id&ecqid=$_SESSION[ecqid]&user_name_id=$_SESSION[user_name_id]";
					if($cf_enable_2co_test_mode=="1")$ppc_row[ppc_payment_method2].="&demo=Y";
				}
				elseif(!(strpos($ppc_row[ppc_payment_method2],"paypal.com")===false)){ //if Paypal sell link
					// rewrite payment URL according to mode
					if ($cf_enable_paypal_test_mode==1) { 
						$ppc_row[ppc_payment_method2] = str_replace("www.paypal.com","www.sandbox.paypal.com",$ppc_row[ppc_payment_method2]);
						$ppc_row[ppc_payment_method2] = str_replace($cf_paypal_primary_email,$cf_paypal_test_email,$ppc_row[ppc_payment_method2]);
					}
					else {
						$ppc_row[ppc_payment_method2] = str_replace("www.sandbox.paypal.com","www.paypal.com",$ppc_row[ppc_payment_method2]);
						$ppc_row[ppc_payment_method2] = str_replace($cf_paypal_test_email,$cf_paypal_primary_email,$ppc_row[ppc_payment_method2]);
					}
					$ppc_row[ppc_payment_method2].="&item_number=PayPerCard&invoice=$_SESSION[ecqid]&custom=$_SESSION[user_name_id],$ec_id";
				}

				if($ppc_row[ppc_buynow_title2]!="" && $ppc_row[ppc_payment_method2]!=""){
					$ppc_payment_method2=$ppc_row[ppc_payment_method2];
					$ppc_buynow_title2=$ppc_row[ppc_buynow_title2];
					$get_ppc_amount=price_format($get_ppc_amount);
					$button_buynow2="<a href=\"$ppc_payment_method2\" class=\"btn btn-default btn-sm btn-my-site\">$ppc_buynow_title2 <strong>$get_ppc_amount</strong></a>";
				}
				else{
					$button_buynow2="";
				}							
				if ($cf_ppc==1){
				$myaccount_ppc_message_not_enough_money=str_replace("%show_user_balance%",price_format($get_user_balance),$myaccount_ppc_message_not_enough_money);
				$myaccount_ppc_message_not_enough_money=str_replace("%show_card_amount%",$get_ppc_amount,$myaccount_ppc_message_not_enough_money);
				$show_ppc_message=get_html_from_layout("templates/$cf_set_template/sendcard_show_change_next_step_fav_toolbar_ppc_message_not_enough_money.html");}
			}
		}
		else {
                        $fav_id=get_dbvalue("max_favorite","fv_id","fv_ec_id='$ec_id' and fv_user_name_id='$_SESSION[user_name_id]'");
                        if(!empty($fav_id)) $button_add_to_fav="<a class=\"btn btn-default btn-sm\" id=\"button_remove_from_fav\" href=\"javascript:void(0);\" onclick=\"Editme('$ecard_url/index.php?step=remove_from_fav&ec_id=','$ec_id','1',1,'button_remove_from_fav');setTimeout(function(){location.reload();}, 2000);\">$sendcard_php_button_remove_from_fav</a>";
			else $button_add_to_fav="<a class=\"btn btn-default btn-sm\" id=\"button_add_to_fav\" href=\"javascript:void(0);\" onclick=\"Editme('$ecard_url/index.php?step=add_to_fav&ec_id=','$ec_id','1',1,'button_add_to_fav');setTimeout(function(){location.reload();}, 2000);\">$sendcard_php_button_add_to_fav</a>";
			$button_next_step="<a class=\"btn btn-default btn-sm btn-my-site\" id=\"button_show_personalize_table\" href=\"javascript:void(0);\" onclick=\"ShowPersonalizeTable();\">$sendcard_php_button_continue_next_step</a>";
			$display_personalize_table=1;
		}
	}
	$url_send="http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
	if($ec_row[ec_caption])
	set_global_var("navigator_link","<a href=\"".get_global_var(url_home)."\">$txt_home</a> <img border=\"0\" alt=\"\" src=\"$ecard_url/templates/$cf_set_template/arrow_nav.gif\" style=\"vertical-align:middle\" />  <a href='$url_go_to_category'>$get_cat_name</a> <img border=\"0\" alt=\"\" src=\"$ecard_url/templates/$cf_set_template/arrow_nav.gif\" style=\"vertical-align:middle\" /> <a href=\"".$url_send."\">$ec_row[ec_caption]</a>");
	else
	set_global_var("navigator_link","<a href=\"".get_global_var(url_home)."\">$txt_home</a> <img border=\"0\" alt=\"\" src=\"$ecard_url/templates/$cf_set_template/arrow_nav.gif\" style=\"vertical-align:middle\" /> <a href='$url_go_to_category'>$get_cat_name</a> <img border=\"0\" alt=\"\" src=\"$ecard_url/templates/$cf_set_template/arrow_nav.gif\" style=\"vertical-align:middle\" /> <a href=\"".$url_send."\">$send_card</a>");
	//show_change_next_step_fav_toolbar
	$show_change_next_step_fav_toolbar=get_html_from_layout("templates/$cf_set_template/sendcard_show_change_next_step_fav_toolbar.html");
	if($cf_show_advance_option_button!="1"){
		$show_option_toolbar=get_html_from_layout("templates/$cf_set_template/sendcard_show_option_toolbar_no_advanced.html");
	}
	
	
	//If media grabber
	if($_SESSION[ec_user_name_id]=="?"){
		$hide_if_media_grabber=" style=\"display:none\" ";
		if(!(strpos($_SESSION[ec_filename],"GRABBER.swf")===false)){//Match
			$is_Grabber_Flash="1";
			$Grabber_Flash_Code=$_SESSION[ec_grabber_html];
		}
	}
	//$thumb_card_url="$ecard_url/resource/picture/$ec_row[ec_cat_dir]/$ec_row[ec_thumbnail]";
	if((!(strpos($ec_row[ec_filename],".jpg")===false))||(!(strpos($ec_row[ec_filename],".png")===false))||(!(strpos($ec_row[ec_filename],".gif")===false))){
		$thumb_card_url="$ecard_url/resource/picture/$ec_row[ec_cat_dir]/$ec_row[ec_filename]";
	}
	else
		$thumb_card_url="$ecard_url/resource/picture/$ec_row[ec_cat_dir]/$ec_row[ec_thumbnail]";
	if($thumb_card_url=='')
		$thumb_card_url=$ecard_url."/logo/".$cf_logo_url;
	//prev and next card
	if ($ec_id!=""){
	$prev_row=get_row("max_ecard","ec_id, ec_caption","ec_id < $ec_id ORDER BY ec_id DESC LIMIT 1");
	if(!empty($prev_row)) {
		$url_prev_card = print_url_card_sendcard($prev_row['ec_id'], $prev_row['ec_caption']);
	}
	else {
		$url_prev_card = $url_send; 
	}
	
	$next_row=get_row("max_ecard","ec_id, ec_caption","ec_id > $ec_id LIMIT 1");
	if(!empty($next_row)) {
		$url_next_card = print_url_card_sendcard($next_row['ec_id'], $next_row['ec_caption']);
	}
	else {
		$url_next_card = $url_send; 
	}
	set_global_var('url_prev_card', $url_prev_card);
	set_global_var('url_next_card', $url_next_card);
        }
	$box_share="";
	if($_SESSION[ecardmax_user]!="")
	{
		if($_SESSION[mg_allow_to_share_card_with_twitter]=="1" || $_SESSION[mg_allow_to_share_card_with_facebook]=="1" || $_SESSION[mg_allow_to_share_card_with_googleplus]=="1" || $_SESSION[mg_allow_to_share_card_with_linkedin]=="1"){
			$box_share.="<div class=\"box_share\" >";

			$box_share.="<span>Send to</span> <i class='fa fa-share-alt'></i>";
			
			if($_SESSION[mg_allow_to_share_card_with_twitter]=="1") {
				$box_share.="<a class='' id=\"atwitter\" href=\"javascript:;\" onclick=\"share_to_social('twitter');\" ><i class='fa fa-twitter-square padding5'></i></a>";
			}
			if($_SESSION[mg_allow_to_share_card_with_facebook]=="1") {
				$box_share.="<a id=\"afacebook\" href=\"javascript:;\" onclick=\"share_to_social('facebook');\"><i class='fa fa-facebook-square  padding5'></i></a>";
			}
			if($_SESSION[mg_allow_to_share_card_with_googleplus]=="1") {
				$box_share.="<a id=\"agoogleplus\" href=\"javascript:;\" onclick=\"share_to_social('googleplus');\"><i class='fa fa-google-plus-square  padding5'></i></a>";
			}
			if($_SESSION[mg_allow_to_share_card_with_linkedin]=="1") {
				$box_share.="<a id=\"alinkedin\" href=\"javascript:;\" onclick=\"share_to_social('linkedin');\"><i class='fa fa-linkedin-square  padding5'></i></a>";
			}

			$box_share.="</div>";
			
		}
	}
	//$box_share=get_html_from_layout("templates/$cf_set_template/box_share.html");
	//Load show_card_body.html
	$show_card_body=get_html_from_layout("templates/$cf_set_template/show_card_body.html");
	
	//Load personalize table
	if($display_personalize_table=="1"){
		require_once("sendcard_show_personalize_mobile.php");		
	}
	
	//Load user comment
	if ($cf_show_user_comment=="1") {
		
		if ($what!="sendvideocard") {
			require_once("sendcard_show_user_comment.php");
		}
	}
	require_once("sendcard_show_user_comment.php");
	//Set site title & meta tag keyword + description
	$my_site_title=$cf_site_title;
	$meta_keyword=$cf_main_keyword;
	$meta_description=$cf_main_description;

	//Enter key is not allowed here 
	$show_onload_javascript="onkeypress=\"return noGlobalEnterKey(event)\""; 

	//Display random banner HR & VT
	print_banner("0");
	//print_banner("1");
	
	$array_global_var[my_site_title]="$cf_site_title - $get_cat_name - $ec_caption";
	$array_global_var[meta_keyword]=($ec_keyword!="") ? ("$cf_main_keyword,$ec_keyword") : ($cf_main_keyword);
	$array_global_var[meta_description]=($ec_detail!="") ? ($ec_detail) : ($cf_main_description);

	$array_global_var[print_object]=get_html_from_layout("templates/$cf_set_template/sendcard.html");
	print_header_and_footer();

?>
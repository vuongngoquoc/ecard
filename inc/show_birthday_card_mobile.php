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
	if($isResponsive)
	{
		$myloop= get_html_from_layout("templates/$cf_set_template/myloop.html");
		set_global_var('myloop',$myloop);
	}
	//print_r($_POST);exit;
	//Get ec_id detail
	$ec_row=get_row("max_ecard","*","ec_id='$ec_id'");
	
	if($ec_row[ec_id]==""){//eCard ID not found -> go to homepage
		header("Location:$ecard_url/index.php\n");
		exit;
	}

	//Save card to database 
	if($action=="save_setting"){
		$field_name ="(cs_id,cs_ec_id,cs_message,cs_lang,cs_user_name_id,cs_music_filename,cs_poem,cs_skin_name,cs_stamp_filename,cs_java,cs_poem_align,cs_sender_ip,cs_group_id)";
		$cs_id = substr(md5(uniqid(rand(),1)), 0, 15);
		$field_value ="('$cs_id','$ec_id','$cs_message','$cs_lang','$_SESSION[user_name_id]','$cs_music_filename','$cs_poem','$cs_skin_name','$cs_stamp_filename','$cs_java','$cs_poem_align','$remote_addr','$group_id')";
		delete_row("max_birthday_card","cs_group_id='$group_id' AND cs_user_name_id='$_SESSION[user_name_id]'");
		insert_data_to_db("max_birthday_card",$field_name ,$field_value);
		//require_once("sendcard_send_to_friend.php");
		if(file_exists("$ecard_root/resource/picture/$ec_row[ec_cat_dir]/$ec_row[ec_thumbnail]")){
			if($_SESSION[ec_user_name_id]!="?"){
				$my_lang_name="ec_caption_".str_replace(".php","",$_SESSION[ecardmax_lang]);
				if($ec_row[$my_lang_name]==""){
					$show_card_title="$ec_row[ec_caption]";
				}
				else{
					$show_card_title="$ec_row[$my_lang_name]";
				}
				$show_card_thumbnail="<img border=\"0\" alt=\"\" src=\"$ecard_url/resource/picture/$ec_row[ec_cat_dir]/$ec_row[ec_thumbnail]\" class=\"thumbnail_image\" />";
			}
			else{
				$show_card_title="Media Grabber";
				$show_card_thumbnail="<img border=\"0\" alt=\"\" src=\"$ecard_url/templates/$cf_set_template/your_photo.gif\" class=\"thumbnail_image\" /> ";
			}
			$display_thumbnail=get_html_from_layout("templates/$cf_set_template/show_card_has_been_setting.html");
		}else{
			$display_thumbnail="$sendcard_txt_card_has_been_saved";
		}
		
		//Go to thank you page
		//Display category menu
		require_once ("show_category.php");
		$category_menu=category_menu($cat_id,$cat_id);
		//Display random banner HR & VT
		print_banner("0");
		print_banner("1");
		if($cs_sent==1){
			$navigator_link="$sendcard_thankyou_card_has_been_sent";
		}
		else{
			//$navigator_link="$sendcard_thankyou_card_will_be_sent $cs_send_month/$cs_send_mday/$cs_send_year";
			$navigator_link="$sendcard_auto_birthday_settings_saved";
		}
		
		$array_global_var[print_object]=get_html_from_layout("templates/$cf_set_template/show_thumbnail.html");
		print_header_and_footer();
		exit;
	}

	foreach($ec_row as $key=>$val){
		$_SESSION[$key]=$val;
	}
	$_SESSION[iv_id]="";
	
	//Get imagesize W&H of fullsize image
	list($fullW,$fullH)=getimagesize("$ecard_root/resource/picture/$ec_row[ec_cat_dir]/$ec_row[ec_filename]");
	$sendcard_txt_download_java=str_replace('"','\\"',$sendcard_txt_download_java);	
	$sendcard_txt_download_flash=str_replace('"','\\"',$sendcard_txt_download_flash);	
	
	//Advance option buttons (button image effect, skin backgroun, stamp, music ...)
	if($cf_show_advance_option_button=="1"){
		require_once("responsive/sendcard_advance_option.php");		
	}

	//Print send now & edit button toolbar
	$show_edit_sendnow_toolbar_top="<div id=\"show_edit_sendnow_toolbar_top\" style=\"text-align:center;display:none\"><br /><span onclick=\"EditCard();\" class=\"button2\">$sendcard_php_button_edit</span><span onclick=\"SendToFriends();\" class=\"button\">$sendcard_php_button_send_now</span></div>";
	$show_edit_sendnow_toolbar_bottom="<div id=\"show_edit_sendnow_toolbar_bottom\" style=\"text-align:center;display:none\"><span onclick=\"EditCard();\" class=\"button2\">$sendcard_php_button_edit</span><span onclick=\"SendToFriends();\" class=\"button\">$sendcard_php_button_send_now</span><br /><br /></div>";

	//Show card body
	if($cs_id!=""){
		$brow=get_row("max_birthday_card","*","cs_id='$cs_id'");	 
		//print_r($brow);
		$ec_row[ec_skin]=$brow[cs_skin_name];
		$ec_row[ec_stamp_filename]=$brow[cs_stamp_filename];
		$ec_row[ec_stamp_filename]=$brow[cs_stamp_filename];
		$ec_row[ec_applet]=$brow[cs_java];
		$ec_row[ec_music_filename]=$brow[cs_music_filename];
		$poem_id=$brow[cs_poem];
		$poem_id_align=$brow[cs_poem_align];
		$poem_id_align=$brow[cs_poem_align];
		$sendcard_demo_mess=$brow[cs_message];
	}
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

	//Poem
	if($resend=="1" && $_SESSION[resend_cs_poem]!=""){
		$poem_id=$_SESSION[resend_cs_poem];
		$poem_id_align=$_SESSION[resend_cs_poem_align];
	}
	elseif($resend!="1" && $_SESSION[user_design_ecard]=="1" && $_SESSION[ud_cs_poem_id]!="" && $_SESSION[ud_ec_id]==$ec_row[ec_id]){
		$poem_id=$_SESSION[ud_cs_poem_id];
		$poem_id_align=$_SESSION[ud_cs_poem_align];
	}

	//Fullsize card url
	//Don't forget watermark	
	
	//Java applet & fullsize url
	if((strpos($ec_row[ec_filename],".swf")===false)){ //if not flash card
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
		if ($show_watermark) {
			$fullsize_card_url="$ecard_url/index.php?step=watermark&ec_id=$ec_id,$fullW,$fullH";
		}
		else {
			$fullsize_card_url="$ecard_url/resource/picture/$ec_row[ec_cat_dir]/$ec_row[ec_filename],$fullW,$fullH";
		} 
	}
	else{
		$fullsize_card_url="$ecard_url/resource/picture/$ec_row[ec_cat_dir]/$ec_row[ec_filename],$fullW,$fullH";
	}

	//Text color
	$text_color=get_dbvalue("max_skin","skin_text_color","skin_dirname='$ec_row[ec_skin]'");

	//Audio default
	if($resend=="1" && $_SESSION[resend_cs_music_filename]!=""){
		$ec_row[ec_music_filename]=$_SESSION[resend_cs_music_filename];
	}
	elseif($resend!="1" && $_SESSION[user_design_ecard]=="1" && $_SESSION[ud_cs_music_filename]!="" && $_SESSION[ud_ec_id]==$ec_row[ec_id]){
		$ec_row[ec_music_filename]=$_SESSION[ud_cs_music_filename];
	}
	if($ec_row[ec_music_filename]!=""){
		$audio_file="$ecard_url/resource/music/$ec_row[ec_music_filename]";
		$cs_music_filename=$ec_row[ec_music_filename]; 
	}
	$audio_title=get_dbvalue("max_music","music_name_display","music_filename='$ec_row[ec_music_filename]'");

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
	$goto_category_name="$show_card_body_goto_category_name <strong>$get_cat_name</strong>";
	
	//Print button change/more ecards
	$button_more_cards_up="<a class=\"btn btn-sm btn-default\" id=\"button_more_cards_up\" href=\"javascript:void(0);\" onclick=\"HideItAll();ShowDiv(this.id,'div_show_more_ecard',0,0,0)\">$show_card_body_more_card</a>";
	$button_more_cards="<a class=\"btn btn-sm btn-default\" id=\"button_more_cards\" href=\"javascript:void(0);\" onclick=\"HideItAll();ShowDiv(this.id,'div_show_more_ecard',0,0,0)\">$show_card_body_more_card</a>";
	
	//Print button Next step or Join now to send card (if not login) & also button Add to Favorite 

	if($_SESSION[ecardmax_user]==""){//Guest - Not login
		if(!(strpos($ec_row[ec_group_relate_id],",1,")===false)){//Match -> guest can send this card
			$button_add_to_fav="<a class=\"btn btn-sm btn-default\" id=\"button_add_to_fav\" href=\"$ecard_url/index.php?step=sign_in\">$sendcard_php_button_add_to_fav</a>";
			$button_next_step="<a class=\"btn btn-sm btn-default btn-my-site\" id=\"button_show_personalize_table\" href=\"javascript:void(0);\" onclick=\"ShowPersonalizeTable();\">$sendcard_php_button_continue_next_step</a>";
			$display_personalize_table=1;
		}
		else{//not match need to login
			$button_add_to_fav="<a class=\"btn btn-sm btn-default\" id=\"button_add_to_fav\" href=\"$ecard_url/index.php?step=sign_in\">$sendcard_php_button_add_to_fav</a>";
			$button_next_step="<a class=\"btn btn-sm btn-default btn-my-site\" id=\"button_show_personalize_table\" href=\"$ecard_url/index.php?step=sign_in\">$sendcard_php_button_join_now_to_send</a>";
			$display_personalize_table=0;
		}
	}
	else{
		if(!(strpos($ec_row[ec_group_relate_id],",$_SESSION[user_mg_id],")===false) || !(strpos($ec_row[ec_group_relate_id],",1,")===false)){//Match -> member can send this card
			$button_add_to_fav="<a class=\"btn btn-sm btn-default\" id=\"button_add_to_fav\" href=\"javascript:void(0);\" onclick=\"Editme('$ecard_url/index.php?step=add_to_fav&ec_id=','$ec_id','1',1,'button_add_to_fav');\">$sendcard_php_button_add_to_fav</a>";
			$button_next_step="<a class=\"btn btn-sm btn-default btn-my-site\" id=\"button_show_personalize_table\" href=\"javascript:void(0);\" onclick=\"ShowPersonalizeTable();\">$sendcard_php_button_continue_next_step</a>";
			$display_personalize_table=1;
		}
		else{
			//Check acct balance to see if enough money to pay per card
			$ppc_row=get_row("max_paypercard","*","ppc_id='$ec_row[ec_ppc_id]'");
			$get_ppc_amount=$ppc_row[ppc_amount];
			$get_user_balance=get_dbvalue("max_ecuser","user_balance","user_id='$_SESSION[user_id]'");
			if($get_user_balance>=$get_ppc_amount && $get_ppc_amount>0){
				$button_add_to_fav="<a class=\"btn btn-sm btn-default\" id=\"button_add_to_fav\" href=\"javascript:void(0);\" onclick=\"Editme('$ecard_url/index.php?step=add_to_fav&ec_id=','$ec_id','1',1,'button_add_to_fav');\">$sendcard_php_button_add_to_fav</a>";
				$button_next_step="<a class=\"btn btn-sm btn-default btn-my-site\" id=\"button_show_personalize_table\" href=\"javascript:void(0);\" onclick=\"ShowPersonalizeTable();\">$sendcard_php_button_continue_next_step</a>";
				$display_personalize_table=1;
				$myaccount_ppc_message_enough_money=str_replace("%show_user_balance%","\$$get_user_balance",$myaccount_ppc_message_enough_money);
				$myaccount_ppc_message_enough_money=str_replace("%show_card_amount%","\$$get_ppc_amount",$myaccount_ppc_message_enough_money);
				$show_ppc_message="<div style=\"text-align:center\" class=\"OK_Message\">$myaccount_ppc_message_enough_money</div><br />";
				$show_new_acct_balance=1;
			}
			else{
				$button_add_to_fav="<a class=\"btn btn-sm btn-default\" id=\"button_add_to_fav\" href=\"javascript:void(0);\" onclick=\"Editme('$ecard_url/index.php?step=add_to_fav&ec_id=','$ec_id','1',1,'button_add_to_fav');\">$sendcard_php_button_add_to_fav</a>";
				$button_next_step="<a class=\"btn btn-sm btn-default btn-my-site\" id=\"button_show_personalize_table\" href=\"$ecard_url/index.php?step=update_your_account\" >$sendcard_php_button_update_account_to_send</a>";
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
					$button_buynow1="<a href=\"$ppc_row[ppc_payment_method1]\" class=\"btn btn-sm btn-default\">$ppc_row[ppc_buynow_title1] <strong>\$$get_ppc_amount</strong></a>";
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
					$button_buynow2="<a href=\"$ppc_row[ppc_payment_method2]\" class=\"btn btn-sm btn-default btn-my-site\">$ppc_row[ppc_buynow_title2] <strong>\$$get_ppc_amount</strong></a>";
				}
				else{
					$button_buynow2="";
				}							

				$myaccount_ppc_message_not_enough_money=str_replace("%show_user_balance%","\$$get_user_balance",$myaccount_ppc_message_not_enough_money);
				$myaccount_ppc_message_not_enough_money=str_replace("%show_card_amount%","\$$get_ppc_amount",$myaccount_ppc_message_not_enough_money);
				if($get_ppc_amount>0)$show_ppc_message="<div style=\"text-align:center\" class=\"Error_Message\">$myaccount_ppc_message_not_enough_money<br /><br />$button_buynow1  $button_buynow2</div><br />";
			}			
		}
	}
	
	//show_change_next_step_fav_toolbar	
	//$show_change_next_step_fav_toolbar="<div id=\"show_change_next_step_fav_toolbar\"><table border=\"0\" width=\"100%\" align=\"center\" cellspacing=\"1\" cellpadding=\"5\"><tr><td width=\"30%\" align=\"right\">$button_more_cards</td><td width=\"*\" align=\"center\">$button_next_step</td><td width=\"30%\" align=\"left\">$button_add_to_fav</td></tr></table><br /></div>$show_ppc_message";
	$show_change_next_step_fav_toolbar=get_html_from_layout("templates/$cf_set_template/sendcard_show_change_next_step_fav_toolbar.html");
	if($cf_show_advance_option_button!="1"){
		//$show_option_toolbar="<div id=\"show_option_toolbar\"><br /><table border=\"0\" width=\"100%\" align=\"center\" cellspacing=\"1\" cellpadding=\"5\"><tr><td width=\"30%\" align=\"right\">$button_more_cards_up</td><td width=\"*\" align=\"center\">$button_next_step</td><td width=\"30%\" align=\"left\">$button_add_to_fav</td></tr></table></div>";
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
	//prev and next card
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
	set_global_var('show_notify_auto_birthday_card',$sendcard_notify_auto_birthday_card);
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
	//Load show_card_body.html
	$show_card_body=get_html_from_layout("templates/$cf_set_template/show_card_body.html");
	
	//Load personalize table
	if($display_personalize_table=="1"){
		require_once("setting_show_personalize.php");		
	}

	//Set site title & meta tag keyword + description
	$my_site_title=$cf_site_title;
	$meta_keyword=$cf_main_keyword;
	$meta_description=$cf_main_description;

	//Enter key is not allowed here 
	$show_onload_javascript="onkeypress=\"return noGlobalEnterKey(event)\""; 

	//Display random banner HR & VT
	print_banner("0");
	//print_banner("1");

	$array_global_var[print_object]=get_html_from_layout("templates/$cf_set_template/sendcard.html");
	print_header_and_footer();

?>

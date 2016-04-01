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
	
	//Get ec_id detail
	$cs_row =get_row("max_ecardsent","*","cs_id='$cs_id'");
	if($cs_row[cs_type]=="videocard"){
		set_global_var("embed_text",urldecode($cs_row[cs_content]));
	}
	if($cs_row[cs_id]==""){
		if($cs_id!="")$show_info=get_html_from_layout("templates/$cf_set_template/show_pickup_error_cardid_not_found.html");
	}
	else{
		set_global_var("cs_user_name_id",$cs_row[cs_user_name_id]);
		if($action =="reply"){
			$msg = trim(base64_decode($msg));
			if ($msg == '') {
				echo json_encode(array('status' => false, 'message' => "Please type your thank you message"));
				exit();
			}
			$email_subject =$send_thank_you_message_email_subject;
			$msg = nl2br(htmlspecialchars($msg));
			$email_msg = $msg."<br/><br/>------------------<br/>{$cs_row[cs_from_name]} sent you an eCard at <a href=\"$ecard_url/index.php?step=pickup&action=viewcopy&cs_id=$cs_id\">$ecard_url/index.php?step=pickup&action=viewcopy&cs_id=$cs_id</a>";
			send_email($cs_row[cs_fname],$cs_row[cs_fmail],$cs_row[cs_from_email],$email_subject,$email_msg,1,$cs_row[cs_fmail]);					
			echo json_encode(array('status' => true, 'message' => "Your thank you message has been sent to {$cs_row[cs_from_name]} - {$cs_row[cs_from_email]}."));
			exit();
		}
		if($action !="viewcopy"){
			//Send email notify user has viewed card - by cheking cs_notify = 1
			if($cs_row[cs_notify] == 1){
				$email_subject =str_replace("%show_name%",$cs_row[cs_fname],$send_notify_user_has_viewed_card_email_subject);
				$email_msg =str_replace("%show_name%",$cs_row[cs_from_name],$send_notify_user_has_viewed_card);
				$email_msg =str_replace("%show_fname%",$cs_row[cs_fname],$email_msg);
				$email_msg =str_replace("%show_id%",$cs_row[cs_id],$email_msg);
				send_email($cf_site_title,$cf_webmaster_email,$cs_row[cs_from_email],$email_subject,$email_msg,$cf_email_plain_text,$cf_webmaster_email);					
			}
			//Then Update cs_notify = 0 cs_sent = 1 cs_pkdate = time now
			$cs_pkdate=time();
			update_field_in_db2("max_ecardsent","cs_notify='0',cs_sent='1',cs_pkdate='$cs_pkdate'","cs_id='$cs_id' LIMIT 1");
		}

		//Load card info
		$ec_row=get_row("max_ecard","*","ec_id='$cs_row[cs_ec_id]'");

		//Show card body
		if($cs_row[cs_skin_name]=="")$cs_row[cs_skin_name]=$cf_default_skin;
		$cs_skin_name=$cs_row[cs_skin_name];
	 
		if(file_exists("$ecard_root/resource/skin/$cs_skin_name/bar.gif")){
			$bar="bar.gif";
		}
		elseif(file_exists("$ecard_root/resource/skin/$cs_skin_name/bar.jpg")){
			$bar="bar.jpg";
		}
		elseif(file_exists("$ecard_root/resource/skin/$cs_skin_name/bar.png")){
			$bar="bar.png";
		}
		elseif(file_exists("$ecard_root/resource/skin/$cs_skin_name/bar.swf")){
			$bar="bar.swf";
		}
		list($barW,$barH)=getimagesize("$ecard_root/resource/skin/$cs_skin_name/$bar");
		$img_bar="$ecard_url/resource/skin/$cs_skin_name/$bar,$barW,$barH"; 

		if(file_exists("$ecard_root/resource/skin/$cs_skin_name/bkg.gif")){
			$bkg="bkg.gif";
		}
		elseif(file_exists("$ecard_root/resource/skin/$cs_skin_name/bkg.jpg")){
			$bkg="bkg.jpg";
		}
		elseif(file_exists("$ecard_root/resource/skin/$cs_skin_name/bkg.png")){
			$bkg="bkg.png";
		}
		$img_bkg="$ecard_url/resource/skin/$cs_skin_name/$bkg"; 

		if(file_exists("$ecard_root/resource/skin/$cs_skin_name/bottom.gif")){
			$bottom="bottom.gif";
		}
		elseif(file_exists("$ecard_root/resource/skin/$cs_skin_name/bottom.jpg")){
			$bottom="bottom.jpg";
		}
		elseif(file_exists("$ecard_root/resource/skin/$cs_skin_name/bottom.png")){
			$bottom="bottom.png";
		}
		elseif(file_exists("$ecard_root/resource/skin/$cs_skin_name/bottom.swf")){
			$bottom="bottom.swf";
		}
		list($bottomW,$bottomH)=getimagesize("$ecard_root/resource/skin/$cs_skin_name/$bottom");
		$img_bottom="$ecard_url/resource/skin/$cs_skin_name/$bottom,$bottomW,$bottomH";  

		if(file_exists("$ecard_root/resource/skin/$cs_skin_name/icon.gif")){
			$icon="icon.gif";
		}
		elseif(file_exists("$ecard_root/resource/skin/$cs_skin_name/icon.jpg")){
			$icon="icon.jpg";
		}
		elseif(file_exists("$ecard_root/resource/skin/$cs_skin_name/icon.png")){
			$icon="icon.png";
		}
		elseif(file_exists("$ecard_root/resource/skin/$cs_skin_name/icon.swf")){
			$icon="icon.swf";
		}
		list($iconW,$iconH)=getimagesize("$ecard_root/resource/skin/$cs_skin_name/$icon");
		$img_icon="$ecard_url/resource/skin/$cs_skin_name/$icon,$iconW,$iconH"; 

		if(file_exists("$ecard_root/resource/skin/$cs_skin_name/top.gif")){
			$top="top.gif";
		}
		elseif(file_exists("$ecard_root/resource/skin/$cs_skin_name/top.jpg")){
			$top="top.jpg";
		}
		elseif(file_exists("$ecard_root/resource/skin/$cs_skin_name/top.png")){
			$top="top.png";
		}
		elseif(file_exists("$ecard_root/resource/skin/$cs_skin_name/top.swf")){
			$top="top.swf";
		}
		list($topW,$topH)=getimagesize("$ecard_root/resource/skin/$cs_skin_name/$top");
		$img_top="$ecard_url/resource/skin/$cs_skin_name/$top,$topW,$topH";
		
		if(file_exists("$ecard_root/resource/skin/$cs_skin_name/poem.gif")){
			$poem="poem.gif";
		}
		elseif(file_exists("$ecard_root/resource/skin/$cs_skin_name/poem.jpg")){
			$poem="poem.jpg";
		}
		elseif(file_exists("$ecard_root/resource/skin/$cs_skin_name/poem.png")){
			$poem="poem.png";
		}
		elseif(file_exists("$ecard_root/resource/skin/$cs_skin_name/poem.swf")){
			$poem="poem.swf";
		}
		list($poemW,$poemH)=getimagesize("$ecard_root/resource/skin/$cs_skin_name/$poem");
		$img_poem="$ecard_url/resource/skin/$cs_skin_name/$poem,$poemW,$poemH";

		//Stamp
		if($cs_row[cs_stamp_filename]=="")$cs_row[cs_stamp_filename]=$cf_default_stamp;
		$cs_stamp_filename=$cs_row[cs_stamp_filename];
		$stamp_url="$ecard_url/resource/stamp/$cs_row[cs_stamp_filename]";

		//Load poem to <div> to let user select/view them
		$poem_id=$cs_row[cs_poem];
		$poem_id_align=$cs_row[cs_poem_align];
		$poem_row=get_row("max_poem","*","poem_id='$cs_row[cs_poem]'");
		$poem_row[poem_body]=str_replace("<br>","<br />",$poem_row[poem_body]);
		$poem_row[poem_body]=str_replace("\r\n","<br />",$poem_row[poem_body]);
		$poem_row[poem_body]=str_replace("\n","<br />",$poem_row[poem_body]);
		$poem_div=get_html_from_layout("templates/$cf_set_template/show_pickup_poem_div.html");
		$poem_title=$poem_row[poem_title];
		$poem_author=$poem_row[poem_author];
		$poem_body=$poem_row[poem_body];
		$poem_div=get_html_from_layout("templates/$cf_set_template/show_pickup_poem_div.html");
		//Fullsize card url
		//list($fullW,$fullH)=getimagesize("$ecard_root/resource/picture/$ec_row[ec_cat_dir]/$ec_row[ec_filename]");

		//Get imagesize W&H of fullsize image
	if(file_exists("$ecard_root/resource/picture/$ec_row[ec_cat_dir]/$ec_row[ec_filename]")) {
		list($fullW,$fullH)=getimagesize("$ecard_root/resource/picture/$ec_row[ec_cat_dir]/$ec_row[ec_filename]");
	}
	else {
		$fullW = $fullH = null ;
	}
		$sendcard_txt_download_java=str_replace('"','\\"',$sendcard_txt_download_java);	
		$sendcard_txt_download_flash=str_replace('"','\\"',$sendcard_txt_download_flash);

		//Don't forget watermark	
		
		//Java applet & fullsize url
		
		if(!(strpos($ec_row[ec_filename],".mp4")===false)) { 
				$fullsize_card_url="videofile";
				$fullsize_card_url_1="resource/picture/$ec_row[ec_cat_dir]/$ec_row[ec_filename]"; 
			}
			
		else if((strpos($ec_row[ec_filename],".swf")===false)){ //if not flash card
			if($cs_row[cs_java]!="" && $cs_row[cs_java]!="-1" ){
				$cs_java=$cs_row[cs_java];

				$get_pixel="width=$fullW height=$fullH";
				$centerX=round(500/2);
				$centerY=round(375/2);
				$applet_code=get_file_content("$ecard_root/resource/applet/$cs_row[cs_java]/code.txt");
				$applet_code=str_replace("\r\n",' ',$applet_code);
				$applet_code=str_replace("\"","'",$applet_code);
				$applet_code = str_replace("anfy_key", $cf_anfy_java_keycode, $applet_code) ;
				$applet_code = str_replace("ds_key", $cf_ds_java_keycode, $applet_code) ;
				$applet_code = str_replace("cgi2k_key", $cf_cgi2k_java_keycode, $applet_code) ;
				$applet_code = str_replace("codebase", "codebase=$ecard_url/resource/applet/$cs_row[cs_java]", $applet_code) ;
				$applet_code = str_replace("change_pixel", $get_pixel, $applet_code) ;
				$applet_code = str_replace("centerX", $centerX, $applet_code) ;
				$applet_code = str_replace("centerY", $centerY, $applet_code) ;
				$applet_code = str_replace("change_path", "$ecard_url/resource/applet/$cs_row[cs_java]", $applet_code) ;
				$applet_code.="<br /><br />$sendcard_txt_download_java";
				$java_applet=$applet_code; 
			}
			$show_watermark=false;
			$user_mg_id = get_dbvalue("max_ecuser","user_mg_id","user_name_id='$cs_row[cs_user_name_id]'");
			$mg_show_watermark = get_dbvalue("max_member_group","mg_show_watermark","mg_id='$user_mg_id'");
			if ($cf_enable_watermark=="1" && $mg_show_watermark=="1") {
				$show_watermark=true;
			}
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
				if ($show_watermark) {
					$fullsize_card_url="$ecard_url/index.php?step=watermark&ec_id=$cs_row[cs_ec_id],$fullW,$fullH";
				}
				else {
					$fullsize_card_url="$ecard_url/resource/picture/$ec_row[ec_cat_dir]/$ec_row[ec_filename],$fullW,$fullH";
				}
			}
		}
		else{
			$fullsize_card_url="$ecard_url/resource/picture/$ec_row[ec_cat_dir]/$ec_row[ec_filename],$fullW,$fullH";
			$fullsize_card_url_1="$ecard_url/resource/picture/$ec_row[ec_cat_dir]/$ec_row[ec_filename]";
		}

		//Text color
		$text_color=get_dbvalue("max_skin","skin_text_color","skin_dirname='$cs_row[cs_skin_name]'");

		//Audio default
		if($cs_row[cs_music_filename]!=""){			
			$cs_music_filename=$cs_row[cs_music_filename]; 			
			$audio_title=get_dbvalue("max_music","music_name_display","music_filename='$cs_music_filename'");
			$cs_music_id=$cs_row[cs_music_id];
			$music_cat_id=get_dbvalue("max_music","ec_cat_id","music_id='$cs_music_id'");
			$music_cat_dir=get_dbvalue("max_music_cat","cat_dir","cat_id='$music_cat_id'");
			$audio_file="resource/music/$music_cat_dir/$cs_row[cs_music_filename]";
		}

		//Sender name
		$from_sender_name="$cs_row[cs_from_name] ($cs_row[cs_from_email])";

		//Recipient name
		$to_name="$cs_row[cs_fname] ($cs_row[cs_fmail])";

		//Date created card default
		$date_created=DateFormat($cs_row[cs_date_create]);

		//Personal message
		$cs_row[cs_message]=str_replace("[name]",$cs_row[cs_fname],$cs_row[cs_message]);
		$cs_row[cs_message]=str_replace("[email]",$cs_row[cs_fmail],$cs_row[cs_message]);

		//Youtube Google Yahoo video 
		$patterns[] = "#\[FLASH=(.*?),(.*?)\](.*?)\[\/FLASH\]#si";
		$replacements[] = '<object width=&quot;$1&quot; height=&quot;$2&quot;><param name=&quot;movie&quot; value=&quot;$3&quot;></param><param name=&quot;wmode&quot; value=&quot;transparent&quot;></param><embed src=&quot;$3&quot; type=&quot;application/x-shockwave-flash&quot; wmode=&quot;transparent&quot; width=&quot;$1&quot; height=&quot;$2&quot;></embed></object>';
		$cs_row[cs_message] = preg_replace($patterns, $replacements, $cs_row[cs_message]);

		$user_message=addslashes(str_replace("\r","",$cs_row[cs_message]));

		//Remember sender name & email
		$_SESSION[remember_sender_name]=$cs_row[cs_from_name];
		$_SESSION[remember_sender_email]=$cs_row[cs_from_email];
		$_SESSION[remember_recipient_name]=$cs_row[cs_fname];
		$_SESSION[remember_recipient_email]=$cs_row[cs_fmail];

		//Save card personal info to $_SESSION incase sender want to resend this card to someone else
		$_SESSION[resend_cs_message]=stripslashes($cs_row[cs_message]);
		$_SESSION[resend_cs_music_filename]=$cs_row[cs_music_filename];
		$_SESSION[resend_cs_poem]=$cs_row[cs_poem];
		$_SESSION[resend_cs_skin_name]=$cs_row[cs_skin_name];
		$_SESSION[resend_cs_stamp_filename]=$cs_row[cs_stamp_filename];
		$_SESSION[resend_cs_java]=$cs_row[cs_java];
		$_SESSION[resend_cs_poem_align]=$cs_row[cs_poem_align];

		//Button print this card
		if($action !="viewcopy"){
			$url_print_ecard=print_url_print_ecard($cs_id);
			$cs_ec_id=$cs_row[cs_ec_id];
			$url_card_resendcard=print_url_card_resendcard($cs_ec_id,$cs_row[cs_ec_id]);
			$top_buttons=get_html_from_layout("templates/$cf_set_template/show_pickup_top_buttons.html");
		}
		
		//If media grabber
		if($ec_row[ec_user_name_id]=="?"){
			if(!(strpos($ec_row[ec_filename],"GRABBER.swf")===false)){//Match
				$is_Grabber_Flash="1";
				$Grabber_Flash_Code=$ec_row[ec_grabber_html];
			}
		}
		
		$from_sender_name_name = $cs_row['cs_from_name'];
		$from_sender_name_email = $cs_row['cs_from_email'];
		set_global_var('from_sender_name_name',$from_sender_name_name);
		set_global_var('from_sender_name_email',$from_sender_name_email);
		$to_name_name = $cs_row['cs_fname'];
		$to_name_email = $cs_row['cs_fmail'];
		set_global_var('to_name_name',$to_name_name);
		set_global_var('to_name_email',$to_name_email);
				
		if($what!="print"){
			//Load show_card_body.html
			$top_buttons=""; 
			$show_card_body=$poem_div.$top_buttons.get_html_from_layout("templates/$cf_set_template/show_card_body.html");
			$show_card_body_step_one=get_html_from_layout("templates/$cf_set_template/show_card_body_step_one.html");
			//Display random banner HR & VT
			//print_banner("0");
			//print_banner("1");

			//$array_global_var[print_object]=get_html_from_layout("templates/$cf_set_template/sendcard.html");
			//print_header_and_footer();
			//get_cat_name
			$ec_cat_row=get_row("max_category","*","cat_id='$ec_row[ec_cat_id]'");
			$my_lang_name="cat_".str_replace(".php","",$_SESSION[ecardmax_lang]);
			if($ec_cat_row[$my_lang_name]==""){
				$get_cat_name=$ec_cat_row[cat_name_display];
			}
			else{
				$get_cat_name=$ec_cat_row[$my_lang_name];
			}
			$ec_caption=$ec_row[ec_caption];
			$ec_keyword=$ec_row[ec_keyword];
			$ec_detail=$ec_row[ec_detail];
			
			
			/*share content*/
			$array_global_var[my_site_title]="$ec_caption";
			$array_global_var[meta_keyword]=($ec_keyword!="") ? ("$cf_main_keyword,$ec_keyword") : ($cf_main_keyword);
			$array_global_var[meta_description]=($ec_detail!="") ? ($ec_detail) : ($cf_main_description);
			
			
			
			/*share content*/
			
			//get thumb_card_url
			$thumb_card_url="";
			if((!(strpos($ec_row[ec_filename],".jpg")===false))||(!(strpos($ec_row[ec_filename],".png")===false))||(!(strpos($ec_row[ec_filename],".gif")===false))){
				$thumb_card_url="$ecard_url/resource/picture/$ec_row[ec_cat_dir]/$ec_row[ec_filename]";
			}
			else {
				$thumb_card_url="$ecard_url/resource/picture/$ec_row[ec_cat_dir]/$ec_row[ec_thumbnail]";
			}
			if($thumb_card_url=='') {
				$thumb_card_url=$ecard_url."/logo/".$cf_logo_url;
			}
			$current_url = "$ecard_url/index.php?step=pickup&cs_id=$cs_id";
			$my_site_title="$cf_site_title - $get_cat_name - $ec_caption";
			$meta_keyword=($ec_keyword!="") ? ("$cf_main_keyword,$ec_keyword") : ($cf_main_keyword);
			$meta_description=($ec_detail!="") ? ($ec_detail) : ($cf_main_description);
			if ($cs_row['cs_fmail'] != '') {
				if($isResponsive)
				{
					print_banner("0");
					$array_global_var[print_object]=$show_card_body_step_one.$show_card_body;
					print_header_and_footer(true);
				}
				else
				print get_html_from_layout("templates/$cf_set_template/show_pickup_page.html");
			} else {
				if($isResponsive)
				{
					print_banner("0");
					$array_global_var[print_object]=$show_card_body_step_one.$show_card_body;
					print_header_and_footer(true);
				}
				else
				print get_html_from_layout("templates/$cf_set_template/show_pickup_page_social.html");
			}
			
		}
		else{
			$show_card_body=$poem_div.get_html_from_layout("templates/$cf_set_template/show_card_body.html");
			print get_html_from_layout("templates/$cf_set_template/show_pickup_print_card.html");			
		}
		exit;
	}
	
	$display_thumbnail=get_html_from_layout("templates/$cf_set_template/show_pickup.html");
?>
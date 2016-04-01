<?php
	if(ECARDMAX_USER!=1)exit;
	
	//Get ec_id detail
	$ec_row=get_row("max_ecard","*","ec_id='$ec_id'");
	
	//Get imagesize W&H of fullsize image
	list($fullW,$fullH)=getimagesize("$ecard_root/resource/picture/$ec_row[ec_cat_dir]/$ec_row[ec_filename]");
	$sendcard_txt_download_java=str_replace('"','\\"',$sendcard_txt_download_java);	
	$sendcard_txt_download_flash=str_replace('"','\\"',$sendcard_txt_download_flash);
	
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
	
	$show_card_body=get_html_from_layout("templates/$cf_set_template/show_card_body.html");
	
	//Load show_print_card.html
	echo $show_print_card=get_html_from_layout("templates/$cf_set_template/show_pickup_print_card.html");
?>
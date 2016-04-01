<?php
	/*
+--------------------------------------------------------------------------
|
|	WARNING: REMOVING THIS COPYRIGHT HEADER IS EXPRESSLY FORBIDDEN
|
|   ePHOTOHUNT GAME 2005 Full Version
|   ========================================
|   by Khoi Hong webmaster@cgi2k.com
|   (c) 1999 - 2004 CGI2K.COM - All right reserved 
|   http://www.cgi2k.com 
|   ========================================
|   Web: http://www.ephotohunt.com
|   Time: Wendnesday, 22 Steptember 2004 05:08 PM - Pacific Time
|   Email: webmaster@ephotohunt.com
|   Purchase Info: http://www.ephotohunt.com/buy
|   Request Installation: http://www.ephotohunt.com/efeedback/efeedbackV4.php?install
|
|   > Script file name: ephotohunt.php
|   > Script written by Khoi Hong
|   > Date started: July 07 2004
|	
|	WARNING //--------------------------
|
|	Selling the code for this program without prior written consent is expressly forbidden. 
|	This computer program is protected by copyright law. 
|	Unauthorized reproduction or distribution of this program, or any portion of if,
|	may result in severe civil and criminal penalties and will be prosecuted to 
|	the maximum extent possible under the lzaw.
+--------------------------------------------------------------------------
*/	

	require_once "getvars.php";
	require_once "config.php";

	$step = get_global_var("step");
	switch($step){
		//Play Sound here
		case "play_sound":
			play_sound();
			break;

		//Print Category Page
		case "show_cat":
			show_cat();
			break;

		//Print Instruction
		case "show_ins":
			show_ins();
			break;

		//Print Frame
		case "play":
			play();
			break;

		//Print main dialog 
		case "dialog":
			dialog();
			break;

		//Print Music Level
		case "show_music_bkg":
			show_music_bkg();
			break;

		//Print HiScore Board
		case "show_hiboard":
			show_hiboard();
			break;

		//Tell A Friend
		case "tell_a_friend":
			tell_a_friend();
			break;

		//Tell A Friend 2
		case "tell_a_friend_2":
			tell_a_friend_2();
			break;

		//Print GameOver
		case "game_over":
			game_over();
			break;

		//Add name to hiBoard
		case "add_name":
			add_name();
			break;

		default:
			//Show Main page
			show_main();
	}

//Play Flash sound here -------------------------------------------------------------------------------------------
function play_sound(){
	$snd_file = get_global_var(snd_file);
print<<<HTML_CODE
<OBJECT classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
codebase="http://active.macromedia.com/flash2/cabs/swflash.cab#version=4,0,0,0"
ID=postcard WIDTH=1 HEIGHT=1>
<PARAM NAME=movie VALUE="$snd_file">
<PARAM NAME=quality VALUE=high>
<embed src="$snd_file" quality="high" WIDTH="1" HEIGHT="1" TYPE="application/x-shockwave-flash" PLUGINSPAGE="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash">
</OBJECT>
HTML_CODE;
exit;
}
//-------------------------------------------------------------------------------------------
function tell_a_friend_2(){
	$home_root= get_global_var(home_root);
	$your_name= get_global_var(your_name);
	$your_email= get_global_var(your_email);
	$friend_name= get_global_var(friend_name);
	$friend_email= get_global_var(friend_email);
	$message= get_global_var(message);
	$display_error=get_global_var(display_error);
	$email_subject=get_global_var(email_subject);
	$home_url=get_global_var(home_url);

	//Check Your name is left blank
	$your_name = stripslashes($your_name);
	$your_name2 = $your_name;
	$your_name2 =str_replace (" ","",$your_name2);
	if ($your_name2 ==""){
		$display_error = "<br>Your name can't be left blank.";
		set_global_var("display_error", $display_error);
		tell_a_friend();
		exit;
	}
	//Check Your email invalid
	$get_mail_info = preg_split ("/@/", $your_email) ;
	if (!ereg ("^.+@.+\\..+$", $your_email) || eregi("[/!|/#|/ |/$|/%|/^|/&|/*|/?|/,|/<|/>|/;|/:|/`|/~|/(|/)|/{|/}|/\[]", $your_email) || preg_match("/]/",$your_email) || count($get_mail_info)>=3) {
		$display_error = "<br>Your email $your_email invalid";
		set_global_var("display_error", $display_error);
		tell_a_friend();
		exit;
	}

	//Check Friend name is left blank
	$friend_name = stripslashes($friend_name);
	$friend_name2 = $friend_name;
	$friend_name2 =str_replace (" ","",$friend_name2);
	if ($friend_name2 ==""){
		$display_error = "<br>Your Friend name can't be left blank.";
		set_global_var("display_error", $display_error);
		tell_a_friend();
		exit;
	}
	//Check Friend email invalid
	$get_mail_info = preg_split ("/@/", $friend_email) ;
	if (!ereg ("^.+@.+\\..+$", $friend_email) || eregi("[/!|/#|/ |/$|/%|/^|/&|/*|/?|/,|/<|/>|/;|/:|/`|/~|/(|/)|/{|/}|/\[]", $friend_email) || preg_match("/]/",$friend_email) || count($get_mail_info)>=3) {
		$display_error = "<br>Friend email $friend_email invalid";
		set_global_var("display_error", $display_error);
		tell_a_friend();
		exit;
	}
	
	$message = stripslashes($message);
	$email_subject = stripslashes($email_subject);

	//Send email
	set_global_var("your_name", $your_name);
	set_global_var("your_email", $your_email);
	set_global_var("friend_email", $friend_email);
	set_global_var("friend_name", $friend_name);
	set_global_var("message", $message);	
	set_global_var("home_url", $home_url);	
	$email_message = get_html_from_layout("email_tell_a_friend.txt");
	mail($friend_email, $email_subject, $email_message, "From: $your_email\r\nContent-Type: text/plain\r\nX-mailer: PHP/") ;

	print get_html_from_layout("thankyou_tell_friend.html");
	exit;

}

//-------------------------------------------------------------------------------------------
function tell_a_friend(){
	$home_root= get_global_var(home_root);
	$your_name= get_global_var(your_name);
	$your_email= get_global_var(your_email);
	$friend_name= get_global_var(friend_name);
	$friend_email= get_global_var(friend_email);
	$message= get_global_var(message);
	$display_error=get_global_var(display_error);
	$email_subject=get_global_var(email_subject);

	if ($email_subject ==""){
		$email_subject ="Hey guys! Check out this PhotoHunt game. It's cool";
	}

	$your_name = stripslashes($your_name);
	$friend_name = stripslashes($friend_name);
	$message = stripslashes($message);
	$email_subject = stripslashes($email_subject);

	set_global_var("your_name", $your_name);
	set_global_var("your_email", $your_email);
	set_global_var("friend_email", $friend_email);
	set_global_var("friend_name", $friend_name);
	set_global_var("message", $message);	
	set_global_var("email_subject", $email_subject);

	print get_html_from_layout("tell_a_friend.html");
	exit;
}

//-------------------------------------------------------------------------------------------
function show_hiboard(){
	$home_root= get_global_var(home_root);

	//Read file hiscore
	$get_files = get_file_content("$home_root/hiscore.txt");
	$array_list = explode ("\n",$get_files);
	$count_top = count($array_list);
	natsort($array_list);

	foreach ($array_list as $val){
		$data .= "$val\n";
	}
	$array_list = explode ("\n",$data);

	$top1 = $array_list[$count_top-1];
	$get_info = preg_split ("/\|/", $top1) ;
	$get_hiscore_1 = number_format($get_info [0]) ;
	$get_level_1 = $get_info [1] ;
	$get_playername_1 = $get_info [2] ;
	$get_date_1 = $get_info [3] ;
	$get_imgpass_1 = $get_info [5] ;
	$get_wronghit_1 = $get_info [6] ;


	$top2 = $array_list[$count_top-2];
	$get_info = preg_split ("/\|/", $top2) ;
	$get_hiscore_2 = number_format($get_info [0]) ;
	$get_level_2 = $get_info [1] ;
	$get_playername_2 = $get_info [2] ;
	$get_date_2 = $get_info [3] ;
	$get_imgpass_2 = $get_info [5] ;
	$get_wronghit_2 = $get_info [6] ;

	$top3 = $array_list[$count_top-3];
	$get_info = preg_split ("/\|/", $top3) ;
	$get_hiscore_3 = number_format($get_info [0]) ;
	$get_level_3 = $get_info [1] ;
	$get_playername_3 = $get_info [2] ;
	$get_date_3 = $get_info [3] ;
	$get_imgpass_3 = $get_info [5] ;
	$get_wronghit_3 = $get_info [6] ;

	$top4 = $array_list[$count_top-4];
	$get_info = preg_split ("/\|/", $top4) ;
	$get_hiscore_4 = number_format($get_info [0]) ;
	$get_level_4 = $get_info [1] ;
	$get_playername_4 = $get_info [2] ;
	$get_date_4 = $get_info [3] ;
	$get_imgpass_4 = $get_info [5] ;
	$get_wronghit_4 = $get_info [6] ;

	$top5 = $array_list[$count_top-5];
	$get_info = preg_split ("/\|/", $top5) ;
	$get_hiscore_5 = number_format($get_info [0]) ;
	$get_level_5 = $get_info [1] ;
	$get_playername_5 = $get_info [2] ;
	$get_date_5 = $get_info [3] ;
	$get_imgpass_5 = $get_info [5] ;
	$get_wronghit_5 = $get_info [6] ;

	$top6 = $array_list[$count_top-6];
	$get_info = preg_split ("/\|/", $top6) ;
	$get_hiscore_6 = number_format($get_info [0]) ;
	$get_level_6 = $get_info [1] ;
	$get_playername_6 = $get_info [2] ;
	$get_date_6 = $get_info [3] ;
	$get_imgpass_6 = $get_info [5] ;
	$get_wronghit_6 = $get_info [6] ;


	$top7 = $array_list[$count_top-7];
	$get_info = preg_split ("/\|/", $top7) ;
	$get_hiscore_7 = number_format($get_info [0]) ;
	$get_level_7 = $get_info [1] ;
	$get_playername_7 = $get_info [2] ;
	$get_date_7 = $get_info [3] ;
	$get_imgpass_7 = $get_info [5] ;
	$get_wronghit_7 = $get_info [6] ;

	$top8 = $array_list[$count_top-8];
	$get_info = preg_split ("/\|/", $top8) ;
	$get_hiscore_8 = number_format($get_info [0]) ;
	$get_level_8 = $get_info [1] ;
	$get_playername_8 = $get_info [2] ;
	$get_date_8 = $get_info [3] ;
	$get_imgpass_8 = $get_info [5] ;
	$get_wronghit_8 = $get_info [6] ;

	$top9 = $array_list[$count_top-9];
	$get_info = preg_split ("/\|/", $top9) ;
	$get_hiscore_9 = number_format($get_info [0]) ;
	$get_level_9 = $get_info [1] ;
	$get_playername_9 = $get_info [2] ;
	$get_date_9 = $get_info [3] ;
	$get_imgpass_9 = $get_info [5] ;
	$get_wronghit_9 = $get_info [6] ;

	$top10 = $array_list[$count_top-10];
	$get_info = preg_split ("/\|/", $top10) ;
	$get_hiscore_10 = number_format($get_info [0]) ;
	$get_level_10 = $get_info [1] ;
	$get_playername_10 = $get_info [2] ;
	$get_date_10 = $get_info [3] ;
	$get_imgpass_10 = $get_info [5] ;
	$get_wronghit_10 = $get_info [6] ;

	set_global_var("get_playername_1", $get_playername_1);
	set_global_var("get_playername_2", $get_playername_2);
	set_global_var("get_playername_3", $get_playername_3);
	set_global_var("get_playername_4", $get_playername_4);
	set_global_var("get_playername_5", $get_playername_5);
	set_global_var("get_playername_6", $get_playername_6);
	set_global_var("get_playername_7", $get_playername_7);
	set_global_var("get_playername_8", $get_playername_8);
	set_global_var("get_playername_9", $get_playername_9);
	set_global_var("get_playername_10", $get_playername_10);

	set_global_var("get_level_1", $get_level_1);
	set_global_var("get_level_2", $get_level_2);
	set_global_var("get_level_3", $get_level_3);
	set_global_var("get_level_4", $get_level_4);
	set_global_var("get_level_5", $get_level_5);
	set_global_var("get_level_6", $get_level_6);
	set_global_var("get_level_7", $get_level_7);
	set_global_var("get_level_8", $get_level_8);
	set_global_var("get_level_9", $get_level_9);
	set_global_var("get_level_10", $get_level_10);

	set_global_var("get_hiscore_1", $get_hiscore_1);
	set_global_var("get_hiscore_2", $get_hiscore_2);
	set_global_var("get_hiscore_3", $get_hiscore_3);
	set_global_var("get_hiscore_4", $get_hiscore_4);
	set_global_var("get_hiscore_5", $get_hiscore_5);
	set_global_var("get_hiscore_6", $get_hiscore_6);
	set_global_var("get_hiscore_7", $get_hiscore_7);
	set_global_var("get_hiscore_8", $get_hiscore_8);
	set_global_var("get_hiscore_9", $get_hiscore_9);
	set_global_var("get_hiscore_10", $get_hiscore_10);

	set_global_var("get_date_1", $get_date_1);
	set_global_var("get_date_2", $get_date_2);
	set_global_var("get_date_3", $get_date_3);
	set_global_var("get_date_4", $get_date_4);
	set_global_var("get_date_5", $get_date_5);
	set_global_var("get_date_6", $get_date_6);
	set_global_var("get_date_7", $get_date_7);
	set_global_var("get_date_8", $get_date_8);
	set_global_var("get_date_9", $get_date_9);
	set_global_var("get_date_10", $get_date_10);

	set_global_var("get_wronghit_1", $get_wronghit_1);
	set_global_var("get_wronghit_2", $get_wronghit_2);
	set_global_var("get_wronghit_3", $get_wronghit_3);
	set_global_var("get_wronghit_4", $get_wronghit_4);
	set_global_var("get_wronghit_5", $get_wronghit_5);
	set_global_var("get_wronghit_6", $get_wronghit_6);
	set_global_var("get_wronghit_7", $get_wronghit_7);
	set_global_var("get_wronghit_8", $get_wronghit_8);
	set_global_var("get_wronghit_9", $get_wronghit_9);
	set_global_var("get_wronghit_10", $get_wronghit_10);

	print get_html_from_layout("hiboard.html");
	exit;

}

//-------------------------------------------------------------------------------------------
function add_name(){
	global $HTTP_COOKIE_VARS;
	$home_root= get_global_var(home_root);
	$form_score= $HTTP_COOKIE_VARS["get_score"];
	$form_level= $HTTP_COOKIE_VARS["get_level"];
	$name= get_global_var(name);
	$email= get_global_var(email);
	$today= get_global_var(today);
	$webmaster_email= get_global_var(webmaster_email);
	$mysite= get_global_var(mysite);
	$subject= get_global_var(subject);
	$wrong_hits= $HTTP_COOKIE_VARS["get_wrong_hits"];
	$img_pass= get_global_var(img_pass);
	
	if($form_score =="" || $form_level ==""){
		print "<script language=javascript>\n";
		print"location.href='ephotohunt.php';\n";
		print"</script>";
		exit;
	}
	// Check Name blank
	$name = strip_tags($name);
	$name2 = $name;
	$name2 =str_replace(" ","",$name2);
	if ($name2 ==""){
		$display_error .= "<br><br>Please enter your name";	
		set_global_var("name", $name);
		set_global_var("form_score", $form_score);
		set_global_var("form_level", $form_level);
		set_global_var("email", $email);
		set_global_var("display_error", $display_error);
		game_over();
		exit;
	}

	// Check email invalid
	if ($email !=""){
		$get_mail_info = preg_split ("/@/", $email) ;
		if (!ereg ("^.+@.+\\..+$", $email) || eregi("[/!|/#|/ |/$|/%|/^|/&|/*|/?|/,|/<|/>|/;|/:|/`|/~|/(|/)|/{|/}|/\[]", $email) || preg_match("/]/",$email) || count($get_mail_info)>=3) {
			$display_error .= "<br><br>Invalid email address $email";
			set_global_var("name", $name);
			set_global_var("form_score", $form_score);
			set_global_var("form_level", $form_level);
			set_global_var("email", $email);
			set_global_var("display_error", $display_error);
			game_over();
			exit;
		}
	}

	// Show date

	//Read file hiscore
	$get_files ="$form_score|$form_level|$name|$today|$email|$img_pass|$wrong_hits\n";
	$get_files .= get_file_content("$home_root/hiscore.txt");
	
	$array_list = explode ("\n",$get_files);
	$count_top = count($array_list);
	natsort($array_list);

	foreach ($array_list as $val){
		$data .= "$val\n";
	}
	$array_list = explode ("\n",$data);

	$top1 = $array_list[$count_top-1];
	$top2 = $array_list[$count_top-2];
	$top3 = $array_list[$count_top-3];
	$top4 = $array_list[$count_top-4];
	$top5 = $array_list[$count_top-5];
	$top6 = $array_list[$count_top-6];	
	$top7 = $array_list[$count_top-7];
	$top8 = $array_list[$count_top-8];
	$top9 = $array_list[$count_top-9];
	$top10 = $array_list[$count_top-10];
	$top11 = $array_list[$count_top-11];

	$fh = fopen("$home_root/hiscore.txt","w");
		if ($fh){
			flock( $fh, LOCK_EX);
			fwrite($fh,"$top1\n");
			fwrite($fh,"$top2\n");
			fwrite($fh,"$top3\n");
			fwrite($fh,"$top4\n");
			fwrite($fh,"$top5\n");
			fwrite($fh,"$top6\n");
			fwrite($fh,"$top7\n");
			fwrite($fh,"$top8\n");
			fwrite($fh,"$top9\n");
			fwrite($fh,"$top10\n");
			flock( $fh, LOCK_UN);
		}
	fclose($fh);

	// Send email to the player 11th  - tell him that he was not on the high board any more.
	set_global_var("mysite", $mysite);
	$get_info = preg_split ("/\|/", $top11) ;
	$get_email = $get_info [4] ;
	if ($get_email != ""){	
		$message = get_html_from_layout("email_notify.txt");
		mail($get_email, $subject, $message, "From: $webmaster_email\r\nContent-Type: text/plain\r\nX-mailer: PHP/") ;
	}

	print "<script language=javascript>\n";	
	print "alert('Congratulations! Your name is now on our High Score Board.');\n";
	print "top.location.href='ephotohunt.php?step=show_hiboard'\n";	
	print "</script>\n";	
	exit;
}

//-------------------------------------------------------------------------------------------
function game_over(){
	$home_root= get_global_var(home_root);
	$form_level= get_global_var(form_level);
	$form_score= get_global_var(form_score);
	$display_error= get_global_var(display_error);
	$name= get_global_var(name);
	$email= get_global_var(email);
	$wrong_hits= get_global_var(wrong_hits);
	$img_pass= get_global_var(img_pass);
	$is_congra= get_global_var(is_congra);
	$cat= get_global_var(cat);
	$cat_finish= get_global_var(cat_finish);
	$form_Lhint1= get_global_var(form_Lhint1);
	$form_Lhint2= get_global_var(form_Lhint2);
	$form_Lhint3= get_global_var(form_Lhint3);
	$soundbkg= get_global_var(soundbkg);
	setcookie("get_score",$form_score);
	setcookie("get_level",$form_level);
	setcookie("get_wrong_hits",$wrong_hits);
	setcookie("get_form_Lhint1",$form_Lhint1);
	setcookie("get_form_Lhint2",$form_Lhint2);
	setcookie("get_form_Lhint3",$form_Lhint3);
	setcookie("get_soundbkg",$soundbkg);

	if ($is_congra=="yes"){
		if ($cat_finish ==""){
			setcookie("cat_finish",$cat);
		}
		else{
			$cat_finish .="|$cat";
			setcookie("cat_finish",$cat_finish);
		}
	$form_level2 = $form_level + 1;

$display_img=<<<HTML_CODE
	<img border=0 src=congratulations.gif><br><br><font face=Verdana size=3 color=#FF6600>
	You've finished all images we have on this category : <b>$cat</b>.<br> <br>
	<b><a href="ephotohunt.php?step=show_cat" target=_top><font color="#FFFF00">
	Click here to continue with another category to get more points.</font></a></b></font><br>
    <b><font face="Verdana" size="2" color="#FF6600">(start with score: $form_score - 
    Level: $form_level2)</font></b><br>
HTML_CODE;
	}
	else{
		$display_img="<img border=0 src=game_over.gif>";
	}
 
	//Read file hiscore	
	$get_files = get_file_content("$home_root/hiscore.txt");
	$my_score ="$form_score|$form_level|YOUR NAME HERE|$today|$email|$img_pass|$wrong_hits\n" . $get_files;
	$array_list = explode ("\n",$get_files);
	$count_top = count($array_list);
	natsort($array_list);
	foreach ($array_list as $val){
		$data .= "$val\n";
	}
	$array_list = explode ("\n",$data);

	$top10 = $array_list[$count_top-10];
	$get_info = preg_split ("/\|/", $top10) ;
	$get_hiscore = $get_info [0] ;
	$get_hiscore=intval($get_hiscore);
//	$get_hiscore=number_format($get_hiscore);
	$form_score=intval($form_score);
//	$form_score=number_format($form_score);

	//Display Player current rank.
	$array_list = explode ("\n",$my_score);
	natsort($array_list);
	$x = 12;
	foreach ($array_list as $val){
		if ($val != ""){
			$x--;
			if(preg_match("/YOUR NAME HERE/",$val)){
				$current_rank = $x;
			}
		}
	}

	// Date
	$today = date("F j Y h:i:s A");

	if ($get_hiscore >= $form_score ){
		setcookie("get_score","");
		setcookie("get_level","");
$display_info =<<<HTML_CODE
		<p align="center"><b><font face="Verdana" color="#C0C1D1"><br>
        Your score: </font><font face="Verdana" color="#FFFF00">$form_score</font></b></p>
        <p align="center"><b><font face="Verdana" color="#C0C1D1">Your score 
        must be higher than </font><font face="Verdana" color="#FFFF00">$get_hiscore</font><font face="Verdana" color="#C0C1D1"> 
        so that you can add your name to the High Score Board.</font></b></p>
        <p align="center"><a href="ephotohunt.php?step=show_cat" target=_top>
        <img border="0" src="new_game.gif" width="316" height="74"></a><br>
        <a href="ephotohunt.php?step=show_hiboard" target=_top>
        <img border="0" src="hiscore_board.gif" width="339" height="74"></a><br>
		<a href="ephotohunt.php?step=tell_a_friend" target=_top>
		<img border="0" src="tell_a_friend.gif"></a>
		</p>
HTML_CODE;
	}
	else{
$display_info =<<<HTML_CODE
        <p align="center"><b><font face="Verdana" color="#C0C1D1">
        </font><font size="5" color="#5B91F2" face="Verdana">Congratulations!</font></b></p>
        <p align="center"><b><font face="Verdana" color="#C0C1D1">Your score :
        </font><font face="Verdana" color="#FFFF00">$form_score</font></b></p>
        <p align="center"><b><font face="Verdana" color="#C0C1D1">You are in our TOP 10 PLAYER. Rank #$current_rank  </font></b></p>
        <p align="center"><b><font face="Verdana" color="#C0C1D1">Please add your name to the High Score Board.</font><font face="Verdana" color="yellow">$display_error</font></b></p>
<form name=form1 onSubmit="checkform()" method="POST" action="ephotohunt.php">
<input type=hidden name=step value=add_name>
<input type=hidden name=chk_one value="">
<input type=hidden name=is_congra value="$is_congra">
<input type=hidden name=today value="$today">
<input type=hidden name=form_score value="$form_score">
<input type=hidden name=form_level value="$form_level">
<input type=hidden name=wrong_hits value="$wrong_hits">
<input type=hidden name=img_pass value="$img_pass">
<div align="center">
  <center>
  <table border="0" cellpadding="5" cellspacing="5" style="border-collapse: collapse" bordercolor="#111111" width="75%">
    <tr>
      <td width="43%">
      <p align="right">
<b><font face="Verdana" color="#C0C1D1" size="2">Your name</font></b></td>
      <td width="57%">
<input type="text" name="name" size="30" maxlength="15" value=$name></td>
    </tr>
    <tr>
      <td width="43%" valign="top">
      <p align="right">
<b><font face="Verdana" color="#C0C1D1" size="2">Your Email</font></b></td>
      <td width="57%">
<input type="text" name="email" size="30" value=$email><br>
      <font face="Verdana" size="1" color="#FFFF00">Our system will notify you 
      when someone beat your score</font></td>
    </tr>
    <tr>
      <td width="43%" valign="top">
      </td>
      <td width="57%">
<input type="submit" value="Submit" name="B1"></td>
    </tr>
  </table>
  </center>
</div>
</form>
<p align="center">
<a href="ephotohunt.php?step=show_hiboard" target=_top>
<img border="0" src="hiscore_board.gif"></a><br>
<script language=javascript>
	if(document.form1.chk_one.value !=""){
		top.location.href='ephotohunt.php?step=show_hiboard';
	}
function checkform(){
	document.form1.chk_one.value ="1";
	document.form1.submit();
}
</script>
HTML_CODE;
	}

	set_global_var("display_info", $display_info);
	set_global_var("display_img", $display_img);
	print get_html_from_layout("game_over.html");
	exit;
}

//-------------------------------------------------------------------------------------------
function show_main(){
	$home_root= get_global_var(home_root);
	$counter_IP= get_global_var(counter_IP);
	$IP_address =get_global_var(REMOTE_ADDR);

	//Set up counter here
	if ($counter_IP == ""){
		setcookie("counter_IP","$IP_address",time()+60*60*24*30);
	}

	if ($counter_IP ==""){
		//Check IP log file
		$get_files_IP = get_file_content("$home_root/IP.log");
		$array_list = explode ("\n",$get_files_IP);
		foreach ($array_list as $val){
			if($val !=""){
				if($val == "$IP_address"){
					$match = 1;
				}
			}
		}

		if ($match != 1){
			$get_files_count = get_file_content("$home_root/count.txt");
			$get_files_count++;
			$fh = fopen("$home_root/count.txt","w");
			if ($fh){
				flock( $fh, LOCK_EX);
				fwrite($fh,"$get_files_count");
				flock( $fh, LOCK_UN);
			}
			fclose($fh);

			$fh = fopen("$home_root/IP.log","w");
			if ($fh){
				flock( $fh, LOCK_EX);
				fwrite($fh,"$IP_address\n$get_files_IP");
				flock( $fh, LOCK_UN);
			}
			fclose($fh);
		}
	}


	setcookie("mycookie","");
	setcookie("cat_finish","");
	setcookie("get_score","");
	setcookie("get_level","");
	print get_html_from_layout("main.html");
	exit;
}

//-------------------------------------------------------------------------------------------
function show_cat(){
	global $HTTP_COOKIE_VARS;
	$home_root= get_global_var(home_root);
	$cat_finish= get_global_var(cat_finish);
	setcookie("mycookie","");
	print get_html_from_layout("cat.html");
	exit;
}

//-------------------------------------------------------------------------------------------
function show_ins(){
	global $HTTP_COOKIE_VARS;
	$home_root= get_global_var(home_root);
	$cat_finish= get_global_var(cat_finish);
	$cat= get_global_var(cat);

	//Check cat_finish here
	$cat_finish_array = preg_split ("/\|/", $cat_finish) ;
	foreach ($cat_finish_array as $val){
		if ($val != ""){				
			if ($cat == $val){
				$display_message = "You've already finished all images in this category $cat.<br>Please choose another category. Or <a href=ephotohunt.php target=_top>click here</a> to start over.<br>Or <a href=ephotohunt.php?form_score=$form_score&form_level=$form_level&cat_finish=$cat_finish&is_congra=yes&step=add_name&cat=$cat target=_top>Click here</a> to add your name to our High Score Board";
				set_global_var("display_message", $display_message);
				setcookie("mycookie","");
				print get_html_from_layout("cat.html");
				exit;
			}
		}
	}

	print get_html_from_layout("ins.html");
	exit;
}

//-------------------------------------------------------------------------------------------
function show_music_bkg(){
	$home_url= get_global_var(home_url);
	$level= get_global_var(level);
	$turn_music_level= get_global_var(turn_music_level);
print<<<HTML_CODE
<img src='' name=scrn_chk width=100% height=1>
<script language=javascript>
var w = document.images['scrn_chk'].width
if (w > 772) top.location.href="$home_url";
</script>

HTML_CODE;

if ($turn_music_level == "ON") {
if ($level != "game_over"){
print<<<HTML_CODE
<html>
<body>
<EMBED src="music_bkg.mid" autostart=true loop=true volume=100 
hidden=true><NOEMBED><BGSOUND src="music_bkg.mid"></NOEMBED>
</body>
</html>
HTML_CODE;
}
elseif($level == "game_over"){
print<<<HTML_CODE
<html>
<body>
<EMBED src="gameover.mid" autostart=true loop=true volume=60 
hidden=true><NOEMBED><BGSOUND src="gameover.mid"></NOEMBED>
</body>
</html>
HTML_CODE;
}
else{
	print "";
}
}
else{
	print "";
}
	exit;
}


//-------------------------------------------------------------------------------------------
function play(){
	global $HTTP_COOKIE_VARS;
	$home_root= get_global_var(home_root);
	$mysite= get_global_var(mysite);
	$home_url= get_global_var(home_url);
	$cat= get_global_var(cat);
	#$form_score= get_global_var(form_score);
	#$form_level= get_global_var(form_level);

	$form_score= $HTTP_COOKIE_VARS["get_score"];
	$form_level= $HTTP_COOKIE_VARS["get_level"];

//Print output Frame.
print<<<HTML_CODE
<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>ePhotoHunt.com</title>
</head>

<frameset framespacing="0" border="0" frameborder="0" rows="*,0,0">
  <frame name="main" src="ephotohunt.php?step=dialog&cat=$cat" scrolling="no" noresize>
  <frame name="header" scrolling="no" noresize target="main" src="ephotohunt.php?step=show_music_bkg&level=1">
  <frame name="flash" scrolling="no" noresize target="main" src="ephotohunt.php?step=play_sound&snd_file=are_you_ready.swf">
  <noframes>
  <body>
  <p>This page uses frames, but your browser doesn't support them.</p>
  </body>
  </noframes>
</frameset>

</html>

HTML_CODE;
	exit;
}

//-------------------------------------------------------------------------------------------
function dialog(){
	global $HTTP_COOKIE_VARS;
	$get_score_chk= $HTTP_COOKIE_VARS["get_score"];
	$get_level_chk= $HTTP_COOKIE_VARS["get_level"];

	if ($get_score_chk != "" && $get_level_chk != ""){
		$form_level= $get_level_chk;
		$form_score= $get_score_chk;
		$wrong_hits= $HTTP_COOKIE_VARS["get_wrong_hits"];
		$soundbkg= $HTTP_COOKIE_VARS["get_soundbkg"];

		$form_Lhint1= $HTTP_COOKIE_VARS["get_form_Lhint1"];
		$form_Lhint2= $HTTP_COOKIE_VARS["get_form_Lhint2"];
		$form_Lhint3= $HTTP_COOKIE_VARS["get_form_Lhint3"];

		setcookie("get_score","");
		setcookie("get_level","");
		setcookie("get_wrong_hits","");
		setcookie("get_soundbkg","");
		setcookie("get_form_Lhint1","");
		setcookie("get_form_Lhint2","");
		setcookie("get_form_Lhint3","");

		if ($soundbkg == "1"){
			print "<script language=javascript>parent.header.location.href ='ephotohunt.php?step=show_music_bkg&level=1';</script>";
		}
		else{
			print "<script language=javascript>parent.header.location.href ='ephotohunt.php?step=show_music_bkg&turn_music_level=OFF';</script>";
		}
	}
	else{
		$form_level= get_global_var(form_level);
		$form_score= get_global_var(form_score);
		$wrong_hits= get_global_var(wrong_hits);
		$soundbkg= get_global_var(soundbkg);
		$form_Lhint1= get_global_var(form_Lhint1);
		$form_Lhint2= get_global_var(form_Lhint2);
		$form_Lhint3= get_global_var(form_Lhint3);
	}
	$ecard_root= get_global_var(ecard_root);

	$home_root= get_global_var(home_root);
	$home_url= get_global_var(home_url);	
	$cat= get_global_var(cat);
	$img_left= get_global_var(img_left);	
	$turn_banner= get_global_var(turn_banner);	
	$img_pass= get_global_var(img_pass);	
	$GAME_OVER= get_global_var(GAME_OVER);
	$CHECK_HINT_THEN_HIT_OK= get_global_var(CHECK_HINT_THEN_HIT_OK);
	$Red_X= get_global_var(Red_X);
	$Red_Y= get_global_var(Red_Y);
	$score_add_unused_hint= get_global_var(score_add_unused_hint);
	$date_install_ephotohunt= get_global_var(date_install_ephotohunt);
	$Keycode= get_global_var(Keycode);
	$Credit= get_global_var(Credit);
	$timer_limit_1= get_global_var(timer_limit_1);
	$timer_limit_2= get_global_var(timer_limit_2);
	$timer_limit_3= get_global_var(timer_limit_3);
	$timer_limit_4= get_global_var(timer_limit_4);
	$timer_limit_5= get_global_var(timer_limit_5);
	$timer_limit_6= get_global_var(timer_limit_6);
	$timer_limit_7= get_global_var(timer_limit_7);
	$timer_limit_8= get_global_var(timer_limit_8);
	$timer_limit_9= get_global_var(timer_limit_9);
	$timer_limit_10= get_global_var(timer_limit_10);
	$timer_limit_11= get_global_var(timer_limit_11);
	$timer_limit_12= get_global_var(timer_limit_12);
	$timer_wrong_hit= get_global_var(timer_wrong_hit);

	$score_add= get_global_var(score_add);
	$score_deduct= get_global_var(score_deduct);
	$score_deduct_hint= get_global_var(score_deduct_hint);
	$score_limit_1= get_global_var(score_limit_1);
	$score_limit_2= get_global_var(score_limit_2);
	$score_limit_3= get_global_var(score_limit_3);
	$score_limit_4= get_global_var(score_limit_4);
	$score_limit_5= get_global_var(score_limit_5);
	$score_limit_6= get_global_var(score_limit_6);
	$score_limit_7= get_global_var(score_limit_7);
	$score_limit_8= get_global_var(score_limit_8);
	$score_limit_9= get_global_var(score_limit_9);
	$score_limit_10= get_global_var(score_limit_10);
	$score_limit_11= get_global_var(score_limit_11);
	$score_limit_12= get_global_var(score_limit_12);
	$scare_player= get_global_var(scare_player);
	$music_bkg= get_global_var(music_bkg);
	$voice_yes= get_global_var(voice_yes);
	$voice_error= get_global_var(voice_error);
	$voice_gameover= get_global_var(voice_gameover);
	$voice_hurryup= get_global_var(voice_hurryup);
	$scare_again= get_global_var(scare_again);
	$mystring =get_global_var(user_agent);
	$mystring = strtolower($mystring);
	$findme  = 'windows';
	$pos = strpos($mystring, $findme);
	$extra_point_time_bonus=get_global_var(extra_point_time_bonus);

	if ($img_left == 0 && $img_left != ""){
		set_global_var("is_congra", "yes");
		game_over();
//		print "Congratulations! You've played all images on our server.";
		exit;
	}

	if ($form_level ==""){
		$form_level = 1;
	}
	else{
		$form_level++;
	}
	if($form_Lhint1 ==""){$form_Lhint1 ="on";}
	if($form_Lhint2 ==""){$form_Lhint2 ="on";}
	if($form_Lhint3 ==""){$form_Lhint3 ="on";}

	if ($form_score == "") {
		$form_score = 0 ; 
	}
	//Read cat dir - find random pic & spot
	// Check cookie
	$mycookie = get_global_var(mycookie);
	if ($mycookie == ""){
		$list_files = get_list_file("$home_root/$cat","pl");	
		shuffle($list_files);
		$val2 = $list_files[0];
		if ($val2 =="") {$val2 = $list_files[1];}
		$num = str_replace(".pl","",$val2);
		if ($num =="") {
			dialog();
		}
		$play_image = 0;
		foreach ($list_files as $val){
			$val = str_replace("\n","",$val);
			if ($val != ""){				
				if ($val != $val2){
					$play_image++;
					$get_val_data .= "$val|";
				}
			}
		}
		$mycookie = $get_val_data;
	}
	else{
		$list_files = explode ("|",$mycookie);
		shuffle($list_files);
		$val2 = $list_files[0];
		if ($val2 =="") {$val2 = $list_files[1];}
		$num = str_replace(".pl","",$val2);
		if ($num =="") {
			dialog();
		}
		$play_image = 0;
		foreach ($list_files as $val){
			$val = str_replace("\n","",$val);
			if ($val != ""){				
				if ($val != $val2){
					$play_image++;
					$get_val_data .= "$val|";
				}
			}
		}
		$mycookie = $get_val_data;
	}

	$get_files = get_file_content("$home_root/$cat/$num.pl");
	$get_files = str_replace (" ","",$get_files);
	$array_list = explode ("\n",$get_files);

	$form_map1 = $array_list [0] ;
	$form_map2 = $array_list [1] ;
	$form_map3 = $array_list [2] ;
	$form_map4 = $array_list [3] ;
	$form_map5 = $array_list [4] ;
	
	if (file_exists("$home_root/$cat/$num" . "_ori.jpg")) {
		$my_ori = $num . "_ori.jpg";
	}
	elseif(file_exists("$home_root/$cat/$num" . "_ori.gif")) {
		$my_ori = $num . "_ori.gif";
	}
	elseif(file_exists("$home_root/$cat/$num" . "_ori.png")) {
		$my_ori = $num . "_ori.png";
	}

	if (file_exists("$home_root/$cat/$num" . "_ori.JPG")) {
		$my_ori = $num . "_ori.JPG";
	}
	elseif(file_exists("$home_root/$cat/$num" . "_ori.GIF")) {
		$my_ori = $num . "_ori.GIF";
	}
	elseif(file_exists("$home_root/$cat/$num" . "_ori.PNG")) {
		$my_ori = $num . "_ori.PNG";
	}

	if (file_exists("$home_root/$cat/$num" . "_ori.Jpg")) {
		$my_ori = $num . "_ori.Jpg";
	}
	elseif(file_exists("$home_root/$cat/$num" . "_ori.Gif")) {
		$my_ori = $num . "_ori.Gif";
	}
	elseif(file_exists("$home_root/$cat/$num" . "_ori.Png")) {
		$my_ori = $num . "_ori.Png";
	}



	if (file_exists("$home_root/$cat/$num" . "_mod.jpg")) {
		$my_mod = $num . "_mod.jpg";
	}
	elseif(file_exists("$home_root/$cat/$num" . "_mod.gif")) {
		$my_mod = $num . "_mod.gif";
	}
	elseif(file_exists("$home_root/$cat/$num" . "_mod.png")) {
		$my_mod = $num . "_mod.png";
	}

	if (file_exists("$home_root/$cat/$num" . "_mod.JPG")) {
		$my_mod = $num . "_mod.JPG";
	}
	elseif(file_exists("$home_root/$cat/$num" . "_mod.GIF")) {
		$my_mod = $num . "_mod.GIF";
	}
	elseif(file_exists("$home_root/$cat/$num" . "_mod.PNG")) {
		$my_mod = $num . "_mod.PNG";
	}

	if (file_exists("$home_root/$cat/$num" . "_mod.Jpg")) {
		$my_mod = $num . "_mod.Jpg";
	}
	elseif(file_exists("$home_root/$cat/$num" . "_mod.Gif")) {
		$my_mod = $num . "_mod.Gif";
	}
	elseif(file_exists("$home_root/$cat/$num" . "_mod.Png")) {
		$my_mod = $num . "_mod.Png";
	}

	//Read file hiscore
	$get_files = get_file_content("$home_root/hiscore.txt");
	$array_list = explode ("\n",$get_files);
	$count_top = count($array_list);
	natsort($array_list);

	foreach ($array_list as $val){
		$data .= "$val\n";
	}
	$array_list = explode ("\n",$data);

	$top1 = $array_list[$count_top-1];
	$get_info = preg_split ("/\|/", $top1) ;
	$get_hiscore = $get_info [0] ;
	#$get_level = $get_info [1] ;
	#$get_playername = $get_info [2] ;
	#$top2 = $array_list[$count_top-2];
	#$top3 = $array_list[$count_top-3];
	#$top4 = $array_list[$count_top-4];
	#$top5 = $array_list[$count_top-5];

	# Random Banner Ad here
	$get_files = get_file_content("$ecard_root/banner/banner.txt");
	$array_list = explode ("\n",$get_files);
	shuffle($array_list);
	$num = $array_list[0];
	if ($num =="") {$num = $array_list[1];}

	if ($turn_banner =="ON"){
		$print_banner = "$num";
	}
	else{
		$print_banner = "";
	}

	$print_banner = str_replace('"','',$print_banner);

	$number_of_sound_file--;
	$spot_big_img_size = @getimagesize ("$home_root/spot_big.gif"); 
	$width = $spot_big_img_size[0];

	$img_hunt_size = @getimagesize ("$home_root/$cat/$my_ori"); 
	$img_hunt_width = $img_hunt_size[0];
	$img_hunt_height = $img_hunt_size[1];

	$img_left = $play_image;
	
	//Get photo credit message (webmaster edit file $cat/credit.html)
	$display_credit = get_file_content("$home_root/$cat/credit.html");

	//Get pause.html file 

	set_global_var("play_image", "$play_image");
	set_global_var("cat", "$cat");
	set_global_var("display_credit", "$display_credit");
	set_global_var("score_deduct", "$score_deduct");
	set_global_var("score_add_unused_hint", "$score_add_unused_hint");
	$display_pause = get_html_from_layout("pause.html");

	if($soundbkg =="" || $soundbkg =="1"){
		$music_bkg_on_checked ="checked";
		set_global_var("music_bkg_on_checked", "$music_bkg_on_checked");
	}
	else{
		$music_bkg_off_checked ="checked";
		set_global_var("music_bkg_off_checked", "$music_bkg_off_checked");
	}
	if($voice_yes =="" || $voice_yes =="on"){
		$voice_yes_on_checked ="checked";
		set_global_var("voice_yes_on_checked", "$voice_yes_on_checked");
	}
	else{
		$voice_yes_off_checked ="checked";
		set_global_var("voice_yes_off_checked", "$voice_yes_off_checked");
	}
	if($voice_error =="" || $voice_error =="on"){
		$voice_error_on_checked ="checked";
		set_global_var("voice_error_on_checked", "$voice_error_on_checked");
	}
	else{
		$voice_error_off_checked ="checked";
		set_global_var("voice_error_off_checked", "$voice_error_off_checked");
	}
	if($voice_gameover =="" || $voice_gameover =="on"){
		$voice_gameover_on_checked ="checked";
		set_global_var("voice_gameover_on_checked", "$voice_gameover_on_checked");
	}	
	else{
		$voice_gameover_off_checked ="checked";
		set_global_var("voice_gameover_off_checked", "$voice_gameover_off_checked");
	}
	if($voice_hurryup =="" || $voice_hurryup =="on"){
		$voice_hurryup_on_checked ="checked";
		set_global_var("voice_hurryup_on_checked", "$voice_hurryup_on_checked");
	}	
	else{
		$voice_hurryup_off_checked ="checked";
		set_global_var("voice_hurryup_off_checked", "$voice_hurryup_off_checked");
	}

	$display_options= get_html_from_layout("options.html");

	//Get counter data
	$get_files_count = get_file_content("$home_root/count.txt");
	$counter_message="<font face='Verdana' size='1' color='#FFFF00'>We have had </font><font face='Verdana' size='2' color='#FFFF00'><span style='background-color: #000000'><b>$get_files_count</b></span></font><font face='Verdana' size='1' color='#FFFF00'> players since <b>$date_install_ephotohunt</b></font>";

	//Play scary movie here
	$rand_number_now =rand(1,10);
	if ($scare_player =="yes"){		
		if ($form_level > 4 && $rand_number_now == 5 && $scare_again !="no"){
			$display_scare = get_html_from_layout("scare.html");
			$display_scare_option = get_html_from_layout("scare_option.html");
		}
	}
	else{
		$rand_number_now ="1";
		$scare_again = "";
	}

print<<<HTML_CODE
<html>

<head>
<meta http-equiv="Content-Language" content="en-us">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>ePhotoHunt Game</title>
<STYLE type="text/css">
	.myScore { font-size : 16px; font-family : Verdana; color:#FF8914; } 
	.myLevel { font-size : 26px; font-family : Verdana; color:#008000; } 
</STYLE>
</head>

<BODY onLoad="clock_timer = setInterval('runclock();', set_time); history.go(+1)" TOPMARGIN=0 LEFTMARGIN=0 MARGINHEIGHT=0 MARGINWIDTH=0 bgcolor="#494B63"> 
<script language=javascript>

if (self == top) location.href="$home_url";

var rand_number = "$rand_number_now";
var scare_again = "$scare_again";
var counter_message="$counter_message";
var music_bkg="$music_bkg";
var voice_yes="$voice_yes";
var voice_error="$voice_error";
var voice_gameover="$voice_gameover";
var voice_hurryup="$voice_hurryup";

var extra_point_time_bonus = $extra_point_time_bonus;
var is_windows = "$pos";
var img_hunt_width = $img_hunt_width;
var img_hunt_heigh = $img_hunt_height;
var timer_limit_1 = $timer_limit_1;
var timer_limit_2 = $timer_limit_2;
var timer_limit_3 = $timer_limit_3;
var timer_limit_4 = $timer_limit_4;
var timer_limit_5 = $timer_limit_5;
var timer_limit_6 = $timer_limit_6;
var timer_limit_7 = $timer_limit_7;
var timer_limit_8 = $timer_limit_8;
var timer_limit_9 = $timer_limit_9;
var timer_limit_10 = $timer_limit_10;
var timer_limit_11 = $timer_limit_11;
var timer_limit_12 = $timer_limit_12;
var timer_wrong_hit = $timer_wrong_hit;
var define_spot_width = $width;
var Keycode = "$Keycode";
var Credit = "$Credit";
var score_add = $score_add;
var score_deduct = $score_deduct;
var score_deduct_hint = $score_deduct_hint;
var score_limit_1 = $score_limit_1;
var score_limit_2 = $score_limit_2;
var score_limit_3 = $score_limit_3;
var score_limit_4 = $score_limit_4;
var score_limit_5 = $score_limit_5;
var score_limit_6 = $score_limit_6;
var score_limit_7 = $score_limit_7;
var score_limit_8 = $score_limit_8;
var score_limit_9 = $score_limit_9;
var score_limit_10 = $score_limit_10;
var score_limit_11 = $score_limit_11;
var score_limit_12 = $score_limit_12;
var cat = "$cat";
var GAME_OVER = "$GAME_OVER";
var CHECK_HINT_THEN_HIT_OK ="$CHECK_HINT_THEN_HIT_OK";
var Red_X = $Red_X;
var Red_Y = $Red_Y;
var score_add_unused_hint = $score_add_unused_hint;
</script>
<script language="JavaScript" type="text/javascript" src="display.js"></script>
<form name=ephotohunt_dot_com method=post action=ephotohunt.php>
<input type=hidden name=step value="dialog">
<input type=hidden name=cat value="$cat">
<input type=hidden name=soundbkg value="$soundbkg">
<input type=hidden name=img_left value="$img_left">
<input type=hidden name=wrong_hits value="$wrong_hits">
<input type=hidden name=img_pass value="$img_pass">
<input type=hidden name=form_level value="$form_level">
<input type=hidden name=form_level2 value="">
<input type=hidden name=form_banner value="$print_banner">
<input type=hidden name=form_img_ori value="$cat/$my_ori">
<input type=hidden name=form_img_mod value="$cat/$my_mod">
<input type=hidden name=form_hiscore value="$get_hiscore">
<input type=hidden name=form_score value="$form_score">
<input type=hidden name=form_Lhint1 value="$form_Lhint1">
<input type=hidden name=form_Lhint2 value="$form_Lhint2">
<input type=hidden name=form_Lhint3 value="$form_Lhint3">
<input type=hidden name=form_map1 value="$form_map1">
<input type=hidden name=form_map2 value="$form_map2">
<input type=hidden name=form_map3 value="$form_map3">
<input type=hidden name=form_map4 value="$form_map4">
<input type=hidden name=form_map5 value="$form_map5">
<input type=hidden name=scare_again value="$scare_again">

<input type=hidden name=mycookie value="$mycookie">
$display_options
$display_scare_option
</form>
$display_pause
$display_scare
<script language="JavaScript" type="text/javascript" src="ephotohunt.js"></script>
</body>
</html>

<script> 
function NoError() { 
alert('Please wait for loading image files.')
return(true); 
} 
onerror=NoError; 
</script>
HTML_CODE;
	exit;
}
?>
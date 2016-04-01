<?php
	/*
+--------------------------------------------------------------------------
|
|	WARNING: REMOVING THIS COPYRIGHT HEADER IS EXPRESSLY FORBIDDEN
|
|   Memory Game 2005 Full Version
|   ========================================
|   by Khoi Hong webmaster@cgi2k.com
|   (c) 1999 - 2004 CGI2K.COM - All right reserved 
|   http://www.cgi2k.com 
|   ========================================
|   Web: http://www.ephotohunt.com
|   Time: Monday, 28 Feb 2005 05:08 PM - Pacific Time
|   Email: webmaster@ephotohunt.com
|   Purchase Info: http://www.ephotohunt.com/buy
|   Request Installation: http://www.ephotohunt.com/efeedback/efeedbackV4.php?install
|
|   > Script file name: ephotohunt.php
|   > Script written by Khoi Hong
|   Time: Monday, 28 Feb 2005 05:08 PM - Pacific Time
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

		//Quit game
		case "quit":
			print "<script language=javascript>\nalert('Good Bye!');\nwindow.close();\n</script>";
			exit;
			break;

		default:
			//Show Main page
			show_cat();
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

	//Get hiscore
	$get_hiscore = number_format (get_hiscore());
	set_global_var("get_hiscore", $get_hiscore);

	//Get counter data
	$player_counter = number_format (get_file_content("$home_root/count.txt"));
	set_global_var("player_counter", $player_counter);

	//Print styles css
	$print_css = get_file_content("$home_root/styles.css");
	set_global_var("print_css", $print_css);

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
		$email_subject ="Hey guys! Check out this Memory game. It's cool";
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

	//Get hiscore
	$get_hiscore = number_format (get_hiscore());
	set_global_var("get_hiscore", $get_hiscore);

	//Get counter data
	$player_counter = number_format (get_file_content("$home_root/count.txt"));
	set_global_var("player_counter", $player_counter);

	//Print styles css
	$print_css = get_file_content("$home_root/styles.css");
	set_global_var("print_css", $print_css);

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

	//Get hiscore
	$get_hiscore = number_format (get_hiscore());
	set_global_var("get_hiscore", $get_hiscore);

	//Get counter data
	$player_counter = number_format (get_file_content("$home_root/count.txt"));
	set_global_var("player_counter", $player_counter);

	//Print styles css
	$print_css = get_file_content("$home_root/styles.css");
	set_global_var("print_css", $print_css);

	print get_html_from_layout("hiboard.html");
	exit;

}

//-------------------------------------------------------------------------------------------
function add_name(){
	global $HTTP_COOKIE_VARS; 
	session_start();	
	$home_root= get_global_var(home_root);
	$form_score= $HTTP_COOKIE_VARS["get_score"];
	$form_level= $HTTP_COOKIE_VARS["get_level"];
	$encryptcode= $HTTP_COOKIE_VARS["encryptcode"];
	$name= get_global_var(name);
	$email= get_global_var(email);
	$webmaster_email= get_global_var(webmaster_email);
	$mysite= get_global_var(mysite);
	$subject= get_global_var(subject);
	$img_pass= get_global_var(img_pass);
	$security_code= get_global_var(security_code);

	$today = date("F j Y h:i:s A");

	$encryptcode_chk = crypt($form_score,$security_code);

	if($form_score =="" || $form_level =="" || $encryptcode_chk != $encryptcode){
		print "<script language=javascript>\n";
		print"location.href='memory.php';\n";
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

	// Send email to the player 11th  - tell him that he was not on the high score board any more.
	set_global_var("mysite", $mysite);
	$get_info = preg_split ("/\|/", $top11) ;
	$get_email = $get_info [4] ;
	if ($get_email != ""){	
		$message = get_html_from_layout("email_notify.txt");
		mail($get_email, $subject, $message, "From: $webmaster_email\r\nContent-Type: text/plain\r\nX-mailer: PHP/") ;
	}
	
	setcookie("saved","yes");

	print "<script language=javascript>\n";	
	print "alert('Congratulations! Your name is now on our High Score Board.');\n";
	print "top.location.href='memory.php?step=show_hiboard'\n";	
	print "</script>\n";	
	exit;
}

//-------------------------------------------------------------------------------------------
function game_over(){
	session_start();
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
	$security_code = get_global_var(security_code);
	$saved = get_global_var(saved);

	if($saved != ""){
		setcookie("saved","");
		show_cat();
		exit;
	}

	$encryptcode = crypt($form_score,$security_code);
	
	setcookie("get_score",$form_score);
	setcookie("get_level",$form_level);
	setcookie("encryptcode",$encryptcode);

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
		$display_info ="<p align=center><font class=Main_Text>Your score: <b>$form_score</b></p><p align=center>Your score must be higher than <b>$get_hiscore</b> so that you can add your name to the High Score Board.</font></p>";
	}
	else{
		$display_info =<<<HTML_CODE
<font class=Main_Text>
<p align="center"><font class=repeat_me>Congratulations!</font></p>
<p align="center">Your score : <b>$form_score</b></p>
<p align="center">You are on our TOP 10 PLAYERS. Rank <b>#$current_rank</b> </p>
<p align="center">Please add your name to the High Score Board</p>
</font>

<form name=form1 method="POST" action="memory.php">
<input type=hidden name=step value=add_name>
<div align="center">
  <center>
  <table border="0" cellpadding="5" cellspacing="5" width="75%">
    <tr>
      <td width="43%" align="right" class=Main_Text><b>Your name</b></td>
      <td width="57%"><input class=TextBox_Style type="text" name="name" size="30" maxlength="15" value=$name></td>
    </tr>
    <tr>
      <td width="43%" valign="top" align="right" class=Main_Text>Your Email (option)</td>
      <td width="57%" class=Main_Text><input class=TextBox_Style type="text" name="email" size="30" value=$email><br><font face=verdana size=1>Our system will notify you when someone beat your score</font></td>
    </tr>
    <tr>
      <td width="43%" valign="top"></td>
      <td width="57%"><input class=Button_Style type="submit" value="Submit" name="B1"></td>
    </tr>
  </table>
  </center>
</div>
</form>
HTML_CODE;
	}

	//Get hiscore
	$get_hiscore = number_format (get_hiscore());
	set_global_var("get_hiscore", $get_hiscore);
	set_global_var("form_score", number_format ($form_score));

	//Get counter data
	$player_counter = number_format (get_file_content("$home_root/count.txt"));
	set_global_var("player_counter", $player_counter);

	//Print styles css
	$print_css = get_file_content("$home_root/styles.css");
	set_global_var("print_css", $print_css);

	set_global_var("display_info", $display_info);
	print get_html_from_layout("game_over.html");
	exit;
}

//-------------------------------------------------------------------------------------------
function show_cat(){
	session_start();
	$home_root= get_global_var(home_root);
	$form_score= get_global_var(form_score);
	$form_level= get_global_var(form_level);

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
	
	//Get hiscore
	$get_hiscore = number_format (get_hiscore());
	set_global_var("get_hiscore", $get_hiscore);

	//Get counter data
	$player_counter = number_format (get_file_content("$home_root/count.txt"));
	set_global_var("player_counter", $player_counter);

	//Print styles css
	$print_css = get_file_content("$home_root/styles.css");
	set_global_var("print_css", $print_css);

	print get_html_from_layout("cat.html");
	exit;
}

//-------------------------------------------------------------------------------------------
function show_ins(){
	$home_root= get_global_var(home_root);
	$form_score= get_global_var(form_score);
	$cat= get_global_var(cat);
	$form_level= get_global_var(form_level);

	//Get hiscore
	$get_hiscore = number_format (get_hiscore());
	set_global_var("get_hiscore", $get_hiscore);

	//Get counter data
	$player_counter = number_format (get_file_content("$home_root/count.txt"));
	set_global_var("player_counter", $player_counter);

	//Print styles css
	$print_css = get_file_content("$home_root/styles.css");
	set_global_var("print_css", $print_css);

	print get_html_from_layout("ins.html");
	exit;
}


//-------------------------------------------------------------------------------------------
function play(){
	$home_root= get_global_var(home_root);
	$cat= get_global_var(cat);
	$form_score= get_global_var(form_score);
	$form_level= get_global_var(form_level);
	
	if ($cat ==""){
		show_cat();
		exit;
	}

	setcookie("saved","");

	//Get hiscore
	$get_hiscore = get_hiscore();
	set_global_var("get_hiscore", $get_hiscore);

	//Get counter data
	$player_counter = get_file_content("$home_root/count.txt");
	set_global_var("player_counter", $player_counter);
	
	//Print styles css
	$print_css = get_file_content("$home_root/styles.css");
	set_global_var("print_css", $print_css);

	if($form_score == "") {$form_score = "0";}

	set_global_var("form_score", $form_score);
	
	// Count total _dn.gif file in cat
	$get_total_picID = get_list_file("$home_root/$cat","_dn.gif");
	$total_picID = round(count ($get_total_picID) / 5) ;
	set_global_var("total_picID", $total_picID);

	if ($total_picID < 1){
		print "<script language=javascript>alert('Sorry! There is no image in this category.');location.href='memory.php?step=show_cat'</script>";
		exit;
	}
	print get_html_from_layout("play.html");
	exit;
}

//-------------------------------------------------------------------------------------------
function get_hiscore(){

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
	$get_hiscore = $get_info [0] ;
	
	return $get_hiscore;
}

?>
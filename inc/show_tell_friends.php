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
	if(ECARDMAX_USER!=1)exit;

	if($what=="send_to_friends"){
		//Check sender email to see if it's inside ban list
		$ban_row=get_row("max_ban_user","*","ban_what='$sender_email'");
		if ($ban_row[ban_id]!=""){
			if($ban_row[ban_time_end]>0 && $ban_row[ban_time_end] > $begin_today_timestamp){
				$ban_reason=$ban_row[ban_reason];
				$array_global_var[print_object]=get_html_from_layout("templates/$cf_set_template/show_tell_friends_ban_message.html");
				print_header_and_footer();
				exit;
			}
		}

		
				
		if($cf_show_image_verify_code=="1"){
			if($verify_image_code!=$_SESSION[random_code]){
				$show_info.="<div class=\"Error_Message\">$show_join_now_alert_must_enter_correct_image_code</div><br />";
				set_global_var("verify_image_code","");
		
			}
			else{
				$random_image_code=1;
				$show_info=get_html_from_layout("templates/$cf_set_template/show_tell_friends_show_info.html");
				$sender_name=stripslashes($sender_name);
				set_global_var("sender_name",$sender_name);
				
				$array=split("\n",$list_email);
				$message=strip_tags($message);
				$tellfriend_email_message=str_replace("%show_message%",$message,$tellfriend_email_message);
				foreach($array as $line){
					$line=trim($line);
					if($line!=""){
						list($re_name,$re_email)=split(";",$line);
						//Send email to each $re_email
						$chk_blacklist_email=get_dbvalue("max_black_list","black_email","black_email='$re_email' and black_active='1'");
						if($chk_blacklist_email==""){//email not on the black list -> send 
							send_email($sender_name,$sender_email,$re_email,$tellfriend_email_subject,$tellfriend_email_message,$cf_email_plain_text,$sender_email);
						}
					}

				}
			}
		}
	}
	
	//Verify image code in textbox
	if($cf_show_image_verify_code=="1"){
		if($random_image_code != 1){
			$rand_code = substr(md5(uniqid(rand(),1)), 0, 5);
			$rand_code=strtoupper($rand_code);
			//Remove zero(0) and letter O so ppl won't confuse
			$rand_code=str_replace("0","1",$rand_code);
			$rand_code=str_replace("O","A",$rand_code);
			$_SESSION['random_code']=$rand_code;
		}
		$show_image_code="<img border=\"0\" alt=\"\" src=\"$ecard_url/index.php?step=verify_image_code\" class=\"thumbnail_image\"/>";
	}
	else{
		$hide_image_code="style=\"display:none\"";
	}

	
	//If user already logged in -> auto display sender name & email 
	if($_SESSION[ecardmax_user]!=""){
		$sender_name="$_SESSION[user_name] $_SESSION[user_last_name]";
		$sender_email="$_SESSION[user_email]";
	}

	

	if($isResponsive)
	{
		$myloop= get_html_from_layout("templates/$cf_set_template/myloop.html");
		set_global_var('myloop',$myloop);
	}

	$display_thumbnail=get_html_from_layout("templates/$cf_set_template/show_tell_friends.html");
?>
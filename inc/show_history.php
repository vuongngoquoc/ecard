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
date_default_timezone_set("America/Chicago");
	if(ECARDMAX_USER!=1)exit;	
	
	if($what=="delete"){
		delete_row("max_ecardsent","cs_id='$cs_id' and cs_user_name_id='$_SESSION[user_name_id]' LIMIT 1");
	}
	elseif($what=="resent_card"){
		$row_data=get_row("max_ecardsent","*","cs_id='$cs_id' and cs_user_name_id ='$_SESSION[user_name_id]'");
		$send_notify_pickup_email_message_tmp=str_replace("%show_friend_name%",$row_data[cs_fname],$send_notify_pickup_email_message);
		$send_notify_pickup_email_message_tmp=str_replace("%show_id%",$cs_id,$send_notify_pickup_email_message_tmp);
		if($cf_show_from_email=="0"){
			send_email($cs_from_name,$cs_from_email,$row_data[cs_fmail],$send_notify_pickup_email_subject,$send_notify_pickup_email_message_tmp,$cf_email_plain_text,$cs_from_email);
		}
		else{
			send_email($cf_site_title,$cf_site_from_email,$row_data[cs_fmail],$send_notify_pickup_email_subject,$send_notify_pickup_email_message_tmp,$cf_email_plain_text,$cs_from_email);
		}
		exit;
	}
	
	if($row_number =="" || $row_number =="0" || !is_numeric($row_number)) $row_number = 15;
	$array_global_var_reminder[row_number]=$row_number;
	$row_per_page = $row_number;

	//Find scheduled card	
	if ($pagesch < 1 || $pagesch=="") $pagesch =1;
	$start = ($pagesch-1)* 1 * $row_per_page;
	$end = $start + 1 * $row_per_page;
	
	$list_data =set_array_from_query("max_ecardsent","*","cs_sent='0' and cs_user_name_id ='$_SESSION[user_name_id]' Order by cs_date_send DESC LIMIT $start,$row_per_page");
	$count_list=get_dbvalue("max_ecardsent","count(cs_id)","cs_sent='0' and cs_user_name_id ='$_SESSION[user_name_id]'");

	if ($end > $count_list) $end = $count_list;
	$xrow=0;
	$my_lang_name="ec_caption_". str_replace(".php","",$_SESSION[ecardmax_lang]);
	$print_scheduled_card="";
	for ($z=$start; $z<$end; $z++) {
		$val = $list_data[$xrow][cs_id] ;
		$row_data=$list_data[$xrow];

		//Get card info
		$ec_row =get_row("max_ecard","*","ec_id='$row_data[cs_ec_id]'");

		//Show card thumbnail
		if($ec_row[ec_thumbnail]!=""){
			$show_card_thumbnail ="<a href=\"$ecard_url/index.php?step=pickup&action=viewcopy&cs_id=$val\" target=\"_blank\"><img border=\"0\" src=\"$ecard_url/resource/picture/$ec_row[ec_cat_dir]/$ec_row[ec_thumbnail]\" alt=\"$history_txt_tooltip_view_card\" title=\"$history_txt_tooltip_view_card\" /></a>";
		}
		else{
			$show_card_thumbnail ="<a href=\"$ecard_url/index.php?step=pickup&action=viewcopy&cs_id=$val\" target=\"_blank\"><img border=\"0\" src=\"$ecard_url/templates/$cf_set_template/your_photo.gif\" alt=\"$history_txt_tooltip_view_card\" title=\"$history_txt_tooltip_view_card\" /></a>";
		}

		//Show card title (caption)
		if($ec_row[$my_lang_name]==""){
			$show_card_caption=$ec_row[ec_caption];
		}
		else{
			$show_card_caption=$ec_row[$my_lang_name];
		}

		//Show send to
		$show_send_to="<strong>$row_data[cs_fname]</strong><br />($row_data[cs_fmail])";

		//Show scheduled date
		$sender = get_dbvalue("max_ecardsent", "cs_user_name_id", "cs_id='$val'");
        $his_timezone = get_dbvalue("max_ecuser", "user_timezone", "user_name_id='$sender'");
        $show_scheduled_date=adjust_timestamp_user($row_data[cs_date_send],$his_timezone);
		$show_scheduled_date=DateFormat($show_scheduled_date,"2");

		//Show delete button
		if($isResponsive)
		$show_delete_button="<span class='btn btn-sm btn-default' onclick=\"if(window.confirm('$history_js_alert_sure_to_delete_card')){location.href='$ecard_url/index.php?step=$step&next_step=$next_step&what=delete&cs_id=$val&pagesch=$pagesch';}\" border=\"0\" src=\"$ecard_url/templates/$cf_set_template/icon_delete.gif\" style=\"cursor:pointer\" alt=\"$history_txt_tooltip_delete_card\" title=\"$history_txt_tooltip_delete_card\" ><i class='fa fa-remove'></i></span>";
		else
		$show_delete_button="<img onclick=\"if(window.confirm('$history_js_alert_sure_to_delete_card')){location.href='$ecard_url/index.php?step=$step&next_step=$next_step&what=delete&cs_id=$val&pagesch=$pagesch';}\" border=\"0\" src=\"$ecard_url/templates/$cf_set_template/icon_delete.gif\" style=\"cursor:pointer\" alt=\"$history_txt_tooltip_delete_card\" title=\"$history_txt_tooltip_delete_card\" />";

		//Show view button
		if($isResponsive)
		$show_view_button="<a class='btn btn-sm btn-default' href=\"$ecard_url/cards/sendcard/{$row_data[cs_ec_id]}/{$ec_row['ec_caption']}\" target=\"_blank\"><i class='fa fa-mail-forward'></i></a>";
		else
		$show_view_button="<a href=\"$ecard_url/cards/sendcard/{$row_data[cs_ec_id]}/{$ec_row['ec_caption']}\" target=\"_blank\"><img border=\"0\" src=\"$ecard_url/templates/$cf_set_template/icon_arrow.gif\" alt=\"Send this card to someone else\" title=\"Send this card to someone else\" /></a>";
		//$show_view_button="<a href=\"$ecard_url/index.php?step=pickup&action=viewcopy&cs_id=$val\" target=\"_blank\"><img border=\"0\" src=\"$ecard_url/templates/$cf_set_template/icon_arrow.gif\" style=\"cursor:pointer\" alt=\"$history_txt_tooltip_view_card\" title=\"$history_txt_tooltip_view_card\" /></a>";

		$print_scheduled_card .="<tr id=\"tr$val\" class=\"table_td_background\">\n";
		$print_scheduled_card .="<td width=\"150\" style=\"padding:7px;vertical-align:top;text-align:left;font-size:8pt\">$show_card_thumbnail<br />$show_card_caption</td>\n";
		$print_scheduled_card .="<td width=\"*\" style=\"padding:7px;vertical-align:top;font-size:8pt\">$show_send_to</td>\n";
		$print_scheduled_card .="<td width=\"*\" style=\"padding:7px;vertical-align:top;white-space:nowrap;font-size:8pt\">$show_scheduled_date</td>\n";
		$print_scheduled_card .="<td width=\"1%\" align=\"center\" style=\"padding:7px;vertical-align:top\">$show_view_button</td>\n";
		$print_scheduled_card .="<td width=\"1%\" align=\"center\" style=\"padding:7px;vertical-align:top\">$show_delete_button</td>\n";
		$print_scheduled_card .="</tr>\n";
		$xrow++;
	}

	//---------------------------------------------------------------------------------------
	//Print page here
	//Output sample: << 1 | 2 | 3 >>
	if ($pagesch < 1 || $pagesch=="") 
		$pagesch = 1;
	if ($list_data ==""){
		$print_page_number_scheduled_card = "";
	}
	else{
		$print_page_number_scheduled_card ="";

		if ($count_list > ($row_per_page)){	
			$c = $count_list / $row_per_page;
			if (gettype($c) =="integer"){
				$b = $c;
			}
			else{
				$b = intval(($count_list / $row_per_page) + 1);
			}				
			
			$print_page_number_scheduled_card .="<br clear=\"all\" /><ul id=paging class='pagination'>";
			$print_page_number_scheduled_card .="      <li>{A}</li>";
			$print_page_number_scheduled_card .="      <li>{NUMBER}</li>";
			$print_page_number_scheduled_card .="      <li>{B}</li>";
			$print_page_number_scheduled_card .="</ul>";
			
			$count_number =get_page_count_number2($pagesch,$b,"pagesch");
			$print_page_number_scheduled_card = str_replace("{NUMBER}", $count_number, $print_page_number_scheduled_card);
			
			if ($pagesch > 1) {
				$page_pr = $pagesch - 1 ;				
				$dpn ="<a href=\"$ecard_url/index.php?step=$step&next_step=$next_step&row_number=$row_number&pagesch=$page_pr\">&laquo;</a>";
				$print_page_number_scheduled_card = str_replace("{A}", $dpn, $print_page_number_scheduled_card);
			}
			else{
				$print_page_number_scheduled_card = str_replace("{A}", "&laquo;", $print_page_number_scheduled_card);
			}
			$y=get_global_var("d_num");
			if ($pagesch < $y) {
				$page_ne = $pagesch + 1 ;				
				$print_page_number_scheduled_card = str_replace("{B}", "<a href=\"$ecard_url/index.php?step=$step&next_step=$next_step&row_number=$row_number&pagesch=$page_ne\">&raquo;</a>", $print_page_number_scheduled_card);
			}	
			else{
				$print_page_number_scheduled_card = str_replace("{B}", "&raquo;", $print_page_number_scheduled_card);
			}
		}
	}

	//Find sent card
	if ($pagesent < 1 || $pagesent=="") $pagesent =1;
	$start = ($pagesent-1)* 1 * $row_per_page;
	$end = $start + 1 * $row_per_page;
	
	$list_data =set_array_from_query("max_ecardsent","*","cs_sent='1' and cs_user_name_id ='$_SESSION[user_name_id]' Order by cs_date_send DESC LIMIT $start,$row_per_page");
	$count_list=get_dbvalue("max_ecardsent","count(cs_id)","cs_sent='1' and cs_user_name_id ='$_SESSION[user_name_id]'");

	if ($end > $count_list) $end = $count_list;
	$xrow=0;
	$my_lang_name="ec_caption_". str_replace(".php","",$_SESSION[ecardmax_lang]);
	$print_card_sent="";
	for ($z=$start; $z<$end; $z++) {
		$val = $list_data[$xrow][cs_id] ;
		$row_data=$list_data[$xrow];

		//Get card info
		$ec_row =get_row("max_ecard","*","ec_id='$row_data[cs_ec_id]'");

		//Show card thumbnail
		if($ec_row[ec_thumbnail]!=""){
			$show_card_thumbnail ="<a href=\"$ecard_url/index.php?step=pickup&action=viewcopy&cs_id=$val\" target=\"_blank\"><img border=\"0\" src=\"$ecard_url/resource/picture/$ec_row[ec_cat_dir]/$ec_row[ec_thumbnail]\" alt=\"$history_txt_tooltip_view_card\" title=\"$history_txt_tooltip_view_card\" /></a>";
		}
		else{
			$show_card_thumbnail ="<a href=\"$ecard_url/index.php?step=pickup&action=viewcopy&cs_id=$val\" target=\"_blank\"><img border=\"0\" src=\"$ecard_url/templates/$cf_set_template/your_photo.gif\" alt=\"$history_txt_tooltip_view_card\" title=\"$history_txt_tooltip_view_card\" /></a>";
		}

		//Show card title (caption)
		if($ec_row[$my_lang_name]==""){
			$show_card_caption=$ec_row[ec_caption];
		}
		else{
			$show_card_caption=$ec_row[$my_lang_name];
		}

		//Show send to
		$show_send_to="<strong>$row_data[cs_fname]</strong><br />($row_data[cs_fmail])";
		if(!$row_data[cs_fmail]){
			$show_send_to = "<strong>$share_with_social_network</strong>";
		}

		//Show date sent
		// First - who has sent this card ? then get his timezone.
		$sender = get_dbvalue("max_ecardsent", "cs_user_name_id", "cs_id='$val'");
		$his_timezone = get_dbvalue("max_ecuser", "user_timezone", "user_name_id='$sender'");
		$date_sent=adjust_timestamp_user($row_data[cs_date_send],$his_timezone);
		$show_date_sent=DateFormat($date_sent,"2");
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

		//Show date pickup
		if($row_data[cs_pkdate]>0){
			$show_date_pickup=DateFormat(adjust_timestamp_user($row_data[cs_pkdate],$his_timezone),"2");
			
			//Show resent card button
			$show_resent_button="-";
		}
		else{
			$show_date_pickup="-";
	
			//Show resent card button
			if($isResponsive)
			$show_resent_button="<span class='btn btn-sm btn-default' onclick=\"Editme('$ecard_url/index.php?step=$step&next_step=$next_step&what=resent_card&cs_from_name=$row_data[cs_from_name]&cs_id=$val&cs_id_tmp=','$val','0',1,this.id);ShowLoaderImage('$ajax_text_sending_email');setTimeout('showid2(\\'show_loading\\',\\'none\\');showid2(\\'hidden_iframe\\',\\'none\\');',500);\" title=\"$history_txt_tooltip_resend_card\" id=\"resent$val\" ><i class='fa fa-mail-reply-all'></i></span>";
			else
			$show_resent_button="<img onclick=\"Editme('$ecard_url/index.php?step=$step&next_step=$next_step&what=resent_card&cs_from_name=$row_data[cs_from_name]&cs_id=$val&cs_id_tmp=','$val','0',1,this.id);ShowLoaderImage('$ajax_text_sending_email');setTimeout('showid2(\\'show_loading\\',\\'none\\');showid2(\\'hidden_iframe\\',\\'none\\');',500);\" border=\"0\" src=\"$ecard_url/templates/$cf_set_template/icon_resent_card.gif\" style=\"cursor:pointer\" alt=\"$history_txt_tooltip_resend_card\" title=\"$history_txt_tooltip_resend_card\" id=\"resent$val\" />";
		}		

		//Show view button
		if($isResponsive)
		$show_view_button="<a title=\"Send this card to someone else\" class='btn btn-sm btn-default' href=\"$ecard_url/cards/sendcard/{$row_data[cs_ec_id]}/{$ec_row['ec_caption']}\" target=\"_blank\"><i class='fa fa-mail-forward'></i></a>";
		else
		$show_view_button="<a href=\"$ecard_url/cards/sendcard/{$row_data[cs_ec_id]}/{$ec_row['ec_caption']}\" target=\"_blank\"><img border=\"0\" src=\"$ecard_url/templates/$cf_set_template/icon_arrow.gif\" alt=\"Send this card to someone else\" title=\"Send this card to someone else\" /></a>";

		//Show delete button
		if($isResponsive)
			$show_delete_button="<span class='btn btn-sm btn-default' onclick=\"if(window.confirm('$history_js_alert_sure_to_delete_card')){location.href='$ecard_url/index.php?step=$step&next_step=$next_step&what=delete&cs_id=$val&pagesent=$pagesent';}\" border=\"0\" src=\"$ecard_url/templates/$cf_set_template/icon_delete.gif\" style=\"cursor:pointer\" alt=\"$history_txt_tooltip_delete_card\" title=\"$history_txt_tooltip_delete_card\" ><i class='fa fa-remove'></i></span>";
		else
			$show_delete_button="<img onclick=\"if(window.confirm('$history_js_alert_sure_to_delete_card')){location.href='$ecard_url/index.php?step=$step&next_step=$next_step&what=delete&cs_id=$val&pagesent=$pagesent';}\" border=\"0\" src=\"$ecard_url/templates/$cf_set_template/icon_delete.gif\" style=\"cursor:pointer\" alt=\"$addressbook_txt_group_delete_contact\" title=\"$addressbook_txt_group_delete_contact\" />";

		$print_card_sent .="<tr id=\"tr$val\" class=\"table_td_background\">\n";
		$print_card_sent .="<td width=\"150\" style=\"padding:7px;vertical-align:top;text-align:left;font-size:8pt\">$show_card_thumbnail<br />$show_card_caption</td>\n";
		$print_card_sent .="<td width=\"*\" style=\"padding:7px;vertical-align:top;font-size:8pt\">$show_send_to</td>\n";
		$print_card_sent .="<td width=\"*\" style=\"padding:7px;vertical-align:top;white-space:nowrap;font-size:8pt\">$show_date_sent</td>\n";
		$print_card_sent .="<td width=\"*\" style=\"padding:7px;vertical-align:top;white-space:nowrap;font-size:8pt\">$show_date_pickup</td>\n";
		$print_card_sent .="<td width=\"1%\" align=\"center\" style=\"padding:7px;vertical-align:top\">$show_resent_button</td>\n";
		$print_card_sent .="<td width=\"1%\" align=\"center\" style=\"padding:7px;vertical-align:top\">$show_view_button</td>\n";
		$print_card_sent .="<td width=\"1%\" align=\"center\" style=\"padding:7px;vertical-align:top\">$show_delete_button</td>\n";
		$print_card_sent .="</tr>\n";
		$xrow++;
	}

	//---------------------------------------------------------------------------------------
	//Print page here
	//Output sample: << 1 | 2 | 3 >>
	if ($pagesent < 1 || $pagesent=="") 
		$pagesent = 1;
	if ($list_data ==""){
		$print_page_number_card_sent = "";
	}
	else{
		$print_page_number_card_sent ="";

		if ($count_list > ($row_per_page)){	
			$c = $count_list / $row_per_page;
			if (gettype($c) =="integer"){
				$b = $c;
			}
			else{
				$b = intval(($count_list / $row_per_page) + 1);
			}				
			
			$print_page_number_card_sent .="<br clear=\"all\" /><ul id=paging class='pagination'>";
			$print_page_number_card_sent .="      <li>{A}</li>";
			$print_page_number_card_sent .="      <li>{NUMBER}</li>";
			$print_page_number_card_sent .="      <li>{B}</li>";
			$print_page_number_card_sent .="</ul>";
			
			$count_number =get_page_count_number2($pagesent,$b,"pagesent");
			$print_page_number_card_sent = str_replace("{NUMBER}", $count_number, $print_page_number_card_sent);
			
			if ($pagesent > 1) {
				$page_pr = $pagesent - 1 ;				
				$dpn ="<a href=\"$ecard_url/index.php?step=$step&next_step=$next_step&row_number=$row_number&pagesent=$page_pr\">&laquo;</a>";
				$print_page_number_card_sent = str_replace("{A}", $dpn, $print_page_number_card_sent);
			}
			else{
				$print_page_number_card_sent = str_replace("{A}", "<a href=\"$url_prev\">&laquo;</a>", $print_page_number_card_sent);
			}
			$y=get_global_var("d_num");
			if ($pagesent < $y) {
				$page_ne = $pagesent + 1 ;				
				$print_page_number_card_sent = str_replace("{B}", "<a href=\"$ecard_url/index.php?step=$step&next_step=$next_step&row_number=$row_number&pagesent=$page_ne\">&raquo;</a>", $print_page_number_card_sent);
			}	
			else{
				$print_page_number_card_sent = str_replace("{B}", "<span>&raquo;</span>", $print_page_number_card_sent);
			}
		}
	}

	//Display random banner HR & VT
	print_banner("0");
	//print_banner("1");	

	$array_global_var[print_object]=get_html_from_layout("templates/$cf_set_template/show_history.html");
	print_header_and_footer();
	
	//--------------------------------------------------------------------------------------
	function get_page_count_number2($page,$b,$pagewhat){
		global $step,$next_step,$row_number,$ecard_url;
			
		$url="$ecard_url/index.php?step=$step&next_step=$next_step&row_number=$row_number";
		$count_number ="";
		
		$y=0;
		if ($b <10){
			for($a_num=1; $a_num<=$b; $a_num++) {
				$y++;
				if ($a_num == $page) {
					$count_number .="<span style=\"cursor: default;\" class='page_active'>$a_num</span>";					
				}
				else {
					$count_number .="<a class=\"page_other\" href=\"$url&$pagewhat=$a_num\">$a_num</a>";
				}
			}
		}
		elseif(($page > 3) && ($page < ($b-3))){
			for($a_num=1; $a_num<=3; $a_num++) {
				$y++;
				$count_number .="<a class=\"page_other\" href=\"$url&$pagewhat=$a_num\">$a_num</a>";
			}
			$count_number .="...";
			for($a_num = $page-1; $a_num<=$page+1; $a_num++) {
				$y++;
				if ($a_num == $page) {
					$count_number .="<span style=\"cursor: default;\" class='page_active'>$a_num</span>";
				}
				else {		
					$count_number .="<a class=\"page_other\" href=\"$url&$pagewhat=$a_num\">$a_num</a>";
				}
			}
			$count_number .="...";
			for($a_num = $b-2; $a_num<=$b; $a_num++) {
				$y++;
				$count_number .="<a class=\"page_other\" href=\"$url&$pagewhat=$a_num\">$a_num</a>";
			}
		}
		else{
			for($a_num=1; $a_num<=4; $a_num++) {
				$y++;
				if ($a_num == $page) {
					$count_number .="<span style=\"cursor: default;\" class='page_active'>$a_num</span>";
				}
				else {
					$count_number .="<a class=\"page_other\" href=\"$url&$pagewhat=$a_num\">$a_num</a>";
				}
			}
			$count_number .="...";			
			for($a_num=$b-3; $a_num<=$b; $a_num++) {
				$y++;
				if ($a_num == $page) {
					$count_number .="<span style=\"cursor: default;\" class='page_active'>$a_num</span>";
				}
				else {	
					$count_number .="<a class=\"page_other\" href=\"$url&$pagewhat=$a_num\">$a_num</a>";
				}
			}
		}
		set_global_var("d_num",$b);
		return $count_number;
	} 
?>
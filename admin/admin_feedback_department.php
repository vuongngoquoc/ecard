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

	if($what=="add_new"){
		$field_name ="(feedback_topic,feedback_email)";
		$field_value ="('$feedback_topic','$feedback_email')";
		insert_data_to_db("max_feedback",$field_name,$field_value);
		$show_info .="<span class=OK_Message>$feedback_message_new_department_added_ok</span><br />\n";	
	}
	elseif($what=="delete_selected"){
		foreach($http_vars as $key=>$val){
			if(!(strpos($key,"mylist_id")===false)){ //if true
				$selected_id =str_replace("mylist_id","",$key);					
				//Delete row in database
				delete_row("max_feedback","feedback_id='$selected_id' LIMIT 1");
			}
		}
	}
	elseif($what=="print_feedback"){
		$row=get_row("max_feedback_message","*","fm_id='$fm_id'");
		$show_time_sent=DateFormat($row[fm_time_sent]);
		$row[fm_message]=nl2br($row[fm_message]);
		$message_body="$feedback_txt_send: $show_time_sent<br /><strong>$row[fm_user_name] [$row[fm_user_email]]</strong><br /><span style=\"color:#5D5D5D\">$row[fm_subject]</span><hr class=\"HR_Color\" />$row[fm_message]";
		print "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\"><html xmlns=\"http://www.w3.org/1999/xhtml\"><head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=$charset\" /><title>$row[fm_subject]</title><style type=\"text/css\"><!-- @import url(html/07_style.css); --> </style><body style=\"background-color:white;\">$message_body</body></html><script>window.print();</script>";
		exit;
	}
	elseif($what=="admin_feedback_department_preview"){
		if($what2=="delete_selected"){
			foreach($http_vars as $key=>$val){
				if(!(strpos($key,"mylist_id")===false)){ //if true
					$selected_id =str_replace("mylist_id","",$key);					
					//Delete row in database
					delete_row("max_feedback_message","fm_id='$selected_id' LIMIT 1");
				}
			}
		}
		if($row_number =="" || $row_number =="0" || !is_numeric($row_number)) $row_number = 15;
		set_global_var("row_number",$row_number);
		$row_per_page = $row_number;
					
		if ($page < 1 || $page=="") $page =1;
		$start = ($page-1)* 1 * $row_per_page;
		$end = $start + 1 * $row_per_page;
		
		if($cmd_button=="Search" && $keyword!=""){									
			   $keyword = mysql_escape_string($keyword);
			   $list_data =set_array_from_query("max_feedback_message","*,MATCH(fm_subject, fm_message, fm_user_name,fm_user_email) AGAINST ('$keyword' IN BOOLEAN MODE) AS score","MATCH(fm_subject, fm_message, fm_user_name,fm_user_email) AGAINST ('$keyword' IN BOOLEAN MODE) and fm_feedback_id='$feedback_id' Order by fm_time_sent DESC,fm_subject LIMIT $start,$row_per_page");
			   $count_list=get_dbvalue("max_feedback_message","count(fm_id)","MATCH(fm_subject, fm_message, fm_user_name,fm_user_email) AGAINST ('$keyword' IN BOOLEAN MODE) and fm_feedback_id='$feedback_id'");
		}
		else{
			$list_data =set_array_from_query("max_feedback_message","*","fm_feedback_id='$feedback_id' Order by fm_time_sent DESC,fm_subject LIMIT $start,$row_per_page");
			$count_list=get_dbvalue("max_feedback_message","count(fm_id)","fm_feedback_id='$feedback_id'");
		}
		$keyword=urlencode($keyword);
		if ($end > $count_list) $end = $count_list;
		$show_list_table="";
		$xrow=0;
		for ($z=$start; $z<$end; $z++) {
			$val = $list_data[$xrow][fm_id] ;
			$row_data=$list_data[$xrow];

			//Show icon
			$show_icon ="<img border=\"0\" src=\"html/07_icon_feedback_email.gif\" alt=\"\" />";

			//IP 2 Location
			$array_country_info=ip2location($row_data[fm_ip]);
			if($array_country_info[ip_country2]){
				$ip2country="<div style=\"font-size:7pt\">$feedback_txt_ip2country: <img border=\"0\" src=\"$ecard_url/resource/flags/$array_country_info[ip_country2].gif\" alt=\"$feedback_txt_user_ip2country: $row_data[fm_ip] $array_country_info[ip_country] - $array_country_info[ip_country_name]\" title=\"$feedback_txt_user_ip2country: $row_data[fm_ip]  $array_country_info[ip_country] - $array_country_info[ip_country_name]\" /> <strong>$array_country_info[ip_country_name]</strong></div>";
			}
			else{
				$ip2country="";
			}

			//Show sender name & email subject
			$show_name_subject="<div style=\"float:left\"><strong>$row_data[fm_user_name] [$row_data[fm_user_email]]</strong><br /><span style=\"color:#5D5D5D\">$row_data[fm_subject]</span></div>";

			//Show time sent
			$show_time_sent=DateFormat($row_data[fm_time_sent]);

			//Show hidden div
			$row_data[fm_message]=htmlspecialchars($row_data[fm_message]);
			$url_fm_message=str_replace("&amp;","%26",$row_data[fm_message]);
			$url_fm_message=str_replace("\r\n","%0A",$url_fm_message);
			$url_fm_message=str_replace("\n","%0A",$url_fm_message);
			$url_fm_message=str_replace("?","%3F",$url_fm_message);

			$url_reply="mailto:$row_data[fm_user_email]?subject=RE: $row_data[fm_subject]&body=%0A%0A-----Original Message-----%0AFrom: $row_data[fm_user_name]%0ASent: $show_time_sent%0ASubject: $row_data[fm_subject]%0A%0A$url_fm_message";
			$row_data[fm_message]=str_replace("\n","<br />",$row_data[fm_message]);
			$row_data[fm_message] = preg_replace( '/(http|ftp)+(s)?:(\/\/)((\w|\.)+)(\/)?(\S+)?/i', '<a href="\0" target=\"_blank\">\4</a>', $row_data[fm_message] );

			$show_hidden_div="<div id=\"hidden$val\" style=\"display:none\">Sent: $show_time_sent<br /><strong>$row_data[fm_user_name] [$row_data[fm_user_email]]</strong><br /><span style=\"color:#5D5D5D\">$row_data[fm_subject]</span><hr class=\"HR_Color\" /><div style=\"text-align:right\"><a href=\"index.php?step=$step&what=print_feedback&fm_id=$val\" target=\"_blank\" class=\"button_link\"><img border=\"0\" src=\"html/07_icon_print16.gif\" alt=\"\" style=\"vertical-align:middle\" />Print</a> <a href=\"$url_reply\" class=\"button_link\"><img border=\"0\" src=\"html/07_icon_email_reply.gif\" alt=\"\" style=\"vertical-align:middle\" />Reply</a></div><br />$row_data[fm_message]</div>";

			//Show view mail icon
			$show_view_icon ="<img border=\"0\" src=\"html/07_icon_arrow.gif\" alt=\"\" />";

			//Show delete button
			$show_delete_button="<img onclick=\"document.getElementById('tr$val').style.backgroundColor='#E4E4D3';document.getElementById('bk$val').checked='true';CheckSelected();\" border=\"0\" src=\"html/07_icon_delete.gif\" style=\"cursor:pointer\" alt=\"$feedback_tooltip_delete_account\" title=\"$feedback_tooltip_delete_account\" />";				

			$show_list_table .="<tr id=\"tr$val\" style=\"background-color: #EAEAEA;line-height:20px\">\n";
			$show_list_table .="<td width=\"1%\" align=\"center\" valign=\"top\" style=\"padding:7px;\">$show_icon</td>\n";
			$show_list_table .="<td width=\"*\" style=\"padding:4px;\">$show_name_subject$show_hidden_div</td>\n";
			$show_list_table .="<td width=\"*\" style=\"padding:4px;\">$show_time_sent$ip2country</td>\n";		
			$show_list_table .="<td width=\"1%\" align=\"center\" style=\"padding:7px;cursor:pointer;\" title=\"$feedback_tooltip_click_to_view\" id=\"cell$val\" onclick=\"HideItAll();this.style.backgroundColor='#FAEDC8';this.style.border='thick solid #FCAA03';ReadMessage('hidden$val')\">$show_view_icon</td>\n";
			$show_list_table .="<td width=\"1%\" align=\"center\">$show_delete_button</td>\n";
			$show_list_table .="<td width=\"1%\" align=\"center\"><input onclick=\"if(this.checked){document.getElementById('tr$val').style.backgroundColor='#E4E4D3';}else{document.getElementById('tr$val').style.backgroundColor='#EAEAEA';}\" type=\"checkbox\" id=\"bk$val\" name=\"mylist_id$val\" value=\"$val\" /></td>\n";
			$show_list_table .="</tr>\n";
			$bk_id .="$val,";
			$xrow++;
		}
		if($bk_id{strlen($bk_id)-1} ==",") $bk_id = substr($bk_id, 0, strlen($bk_id)-1);
		set_global_var("bk_id",$bk_id);
		set_global_var("show_list_table",$show_list_table);

		//---------------------------------------------------------------------------------------
		//Print page here
		//Output sample: << 1 | 2 | 3 >>	

		if ($page < 1 || $page=="") 
			$page = 1;
		if ($list_data ==""){
			$display_page_number = "";
		}
		else{
			$display_page_number ="";

			if ($count_list > ($row_per_page)){	
				$c = $count_list / $row_per_page;
				if (gettype($c) =="integer"){
					$b = $c;
				}
				else{
					$b = intval(($count_list / $row_per_page) + 1);
				}				
				
				$display_page_number .="<br /><table class=page_number_table>\n";
				$display_page_number .="    <tr>\n";
				$display_page_number .="      <td width='10%' align=left>{A}</td>\n";
				$display_page_number .="      <td width='33%' align=center>{NUMBER}</td>\n";
				$display_page_number .="      <td width='10%' align=right>{B}</td>\n";
				$display_page_number .="    </tr>\n";
				$display_page_number .="</table>\n";
				
				$count_number =get_page_count_number($page,$b);
				$display_page_number = str_replace("{NUMBER}", $count_number, $display_page_number);				
				if ($page > 1) {
					$page_pr = $page - 1 ;				
					$dpn ="<a href=\"index.php?step=$step&row_number=$row_number&page=$page_pr&feedback_id=$feedback_id&what=$what&keyword=$keyword&cmd_button=$cmd_button\"><img border=0 src=html/prv.gif style='vertical-align:middle' title='Page # $page_pr' alt='Page # $page_pr' /></a>";
					$display_page_number = str_replace("{A}", $dpn, $display_page_number);
				}
				else{
					$display_page_number = str_replace("{A}", "<img src=html/prv_disable.gif alt='' style='vertical-align:middle' />", $display_page_number);
				}
				$y=get_global_var("d_num");
				if ($page < $y) {
					$page_ne = $page + 1 ;				
					$display_page_number = str_replace("{B}", "<a href=\"index.php?step=$step&row_number=$row_number&page=$page_ne&feedback_id=$feedback_id&what=$what&keyword=$keyword&cmd_button=$cmd_button\"><img border=0 src=html/next.gif style='vertical-align:middle' title='Page # $page_ne' alt='Page # $page_ne' /></a>", $display_page_number);
				}	
				else{
					$display_page_number = str_replace("{B}", "<img src=html/next_disable.gif alt='' style='vertical-align:middle' />", $display_page_number);
				}
			}
		}
		set_global_var("display_page_number",$display_page_number);	 
		set_global_var("count_total",$count_list);
		set_global_var("feedback_topic",get_dbvalue("max_feedback","feedback_topic","feedback_id='$feedback_id'"));	 
		print get_html_from_layout("admin/html/admin_feedback_department_preview.html");
		exit;
	}

	$list_department =set_array_from_query("max_feedback","*","feedback_id<>'' Order by feedback_topic");
	foreach($list_department as $row_data){
		$val = $row_data[feedback_id] ;
		
		//Show icon
		$show_icon ="<img border=\"0\" src=\"html/07_icon_fbdepartment.gif\" alt=\"\" />";

		//Show department name
		$show_department_name ="<input id=\"feedback_topic$val\" title=\"$feedback_tooltip_click_to_edit\" type=\"text\" value=\"$row_data[feedback_topic]\" style=\"border:0px;background-color:#EAEAEA;cursor:pointer;width:300px;text-decoration:underline;\" onfocus=\"original_value=this.value;this.style.border='1px solid silver';this.style.textDecoration='none';this.style.cursor='text';\" onblur=\"this.style.border='0px';this.style.textDecoration='underline';this.style.cursor='pointer';\" onchange=\"Editme('index.php?step=edit_me&table=max_feedback&edit_id=feedback_id&edit_id_value=$val&edit_key=feedback_topic&edit_value=',this.value,'1',original_value,this.id);\" />";

		//Show department email
		$show_department_email ="<input id=\"feedback_email$val\" title=\"$feedback_tooltip_click_to_edit\" type=\"text\" value=\"$row_data[feedback_email]\" style=\"border:0px;background-color:#EAEAEA;cursor:pointer;width:300px;text-decoration:underline;\" onfocus=\"original_value=this.value;this.style.border='1px solid silver';this.style.textDecoration='none';this.style.cursor='text';\" onblur=\"this.style.border='0px';this.style.textDecoration='underline';this.style.cursor='pointer';\" onchange=\"Editme('index.php?step=edit_me&table=max_feedback&edit_id=feedback_id&edit_id_value=$val&edit_key=feedback_email&edit_value=',this.value,'3',original_value,this.id);\" />";

		//Count number of feedback in each department
		$count_fb=get_dbvalue("max_feedback_message","count(fm_id)","fm_feedback_id='$val'");

		//Show view feedback icon
		$show_view_icon ="<img border=\"0\" src=\"html/07_icon_search_keyword.gif\" alt=\"\" />";

		//Show delete button
		$show_delete_button="<img onclick=\"document.getElementById('tr$val').style.backgroundColor='#E4E4D3';document.getElementById('bk$val').checked='true';CheckSelected();\" border=\"0\" src=\"html/07_icon_delete.gif\" style=\"cursor:pointer\" alt=\"$feedback_tooltip_delete_account\" title=\"$feedback_tooltip_delete_account\" />";

		$show_list_table .="<tr id=\"tr$val\" style=\"background-color: #EAEAEA;line-height:20px\">\n";
		$show_list_table .="<td width=\"1%\" align=\"center\" valign=\"top\" style=\"padding:7px;\">$show_icon</td>\n";
		$show_list_table .="<td width=\"*\" style=\"padding:4px;\">$show_department_name</td>\n";
		$show_list_table .="<td width=\"*\" style=\"padding:4px;\">$show_department_email</td>\n";
		$show_list_table .="<td width=\"1%\" align=\"center\">$count_fb</td>\n";
		$show_list_table .="<td width=\"1%\" align=\"center\" style=\"padding:7px;cursor:pointer;\" title=\"$feedback_tooltip_click_to_view_message\" id=\"cell$val\" onclick=\"HideItAll();this.style.backgroundColor='#FAEDC8';this.style.border='thick solid #FCAA03';location.hash='#show_hidden_iframe';showid2('div_iframe','block');frames['preview_frame'].location.href = 'index.php?step=$step&what=admin_feedback_department_preview&feedback_id=$val';\">$show_view_icon</td>\n";
		$show_list_table .="<td width=\"1%\" align=\"center\">$show_delete_button</td>\n";
		$show_list_table .="<td width=\"1%\" align=\"center\"><input onclick=\"if(this.checked){document.getElementById('tr$val').style.backgroundColor='#E4E4D3';}else{document.getElementById('tr$val').style.backgroundColor='#EAEAEA';}\" type=\"checkbox\" id=\"bk$val\" name=\"mylist_id$val\" value=\"$val\" /></td>\n";
		$show_list_table .="</tr>\n";
		$bk_id .="$val,";
	}
	if($bk_id{strlen($bk_id)-1} ==",") $bk_id = substr($bk_id, 0, strlen($bk_id)-1);
	set_global_var("bk_id",$bk_id);
	set_global_var("show_list_table",$show_list_table);

	if($db_change =="1"){
		set_global_var("show_info","<span class=\"OK_Message\">$feedback_txt_mysql_table_banner_updated<br /><br /></span>");	
	}
	else{
		set_global_var("show_info","<span class=\"Error_Message\">$show_info<br /></span>");	
	}

	set_global_var("count_total",$count_list);		
	set_global_var("print_object",get_html_from_layout("admin/html/admin_feedback_department.html"));	
	print_admin_header_footer_page();	

	//--------------------------------------------------------------------------------------
	function get_page_count_number($page,$b){
		global $step,$what,$row_number,$feedback_id,$keyword,$cmd_button;
			
		$url="index.php?step=$step&row_number=$row_number&feedback_id=$feedback_id&what=$what&keyword=$keyword&cmd_button=$cmd_button";
		$count_number ="";
		
		$y=0;
		if ($b <10){
			for($a_num=1; $a_num<=$b; $a_num++) {
				$y++;
				if ($a_num == $page) {
					$count_number .="<span style=\"cursor: default;\" class='page_active'>$a_num</span>";					
				}
				else {
					$count_number .="<a class=\"page_other\" href=\"$url&page=$a_num\">$a_num</a>";
				}
			}
		}
		elseif(($page > 3) && ($page < ($b-3))){
			for($a_num=1; $a_num<=3; $a_num++) {
				$y++;
				$count_number .="<a class=\"page_other\" href=\"$url&page=$a_num\">$a_num</a>";
			}
			$count_number .="...";
			for($a_num = $page-1; $a_num<=$page+1; $a_num++) {
				$y++;
				if ($a_num == $page) {
					$count_number .="<span style=\"cursor: default;\" class='page_active'>$a_num</span>";
				}
				else {		
					$count_number .="<a class=\"page_other\" href=\"$url&page=$a_num\">$a_num</a>";
				}
			}
			$count_number .="...";
			for($a_num = $b-2; $a_num<=$b; $a_num++) {
				$y++;
				$count_number .="<a class=\"page_other\" href=\"$url&page=$a_num\">$a_num</a>";
			}
		}
		else{
			for($a_num=1; $a_num<=4; $a_num++) {
				$y++;
				if ($a_num == $page) {
					$count_number .="<span style=\"cursor: default;\" class='page_active'>$a_num</span>";
				}
				else {
					$count_number .="<a class=\"page_other\" href=\"$url&page=$a_num\">$a_num</a>";
				}
			}
			$count_number .="...";			
			for($a_num=$b-3; $a_num<=$b; $a_num++) {
				$y++;
				if ($a_num == $page) {
					$count_number .="<span style=\"cursor: default;\" class='page_active'>$a_num</span>";
				}
				else {	
					$count_number .="<a class=\"page_other\" href=\"$url&page=$a_num\">$a_num</a>";
				}
			}
		}
		set_global_var("d_num",$b);
		return $count_number;
	}

?>
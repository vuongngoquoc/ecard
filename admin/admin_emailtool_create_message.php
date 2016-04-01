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
	//Ban type: 0:email - 1:IP
	if($what=="add_new"){
		
		$field_name ="(mmess_subject,mmess_body,mmess_body_text)";
		$field_value ="('$mmess_subject','$mmess_body','$mmess_body_text')";
		insert_data_to_db("max_mail_message",$field_name,$field_value);		
		$show_info .="<span class=OK_Message>$email_tool_create_message_msg_new_msg_added</span><br />\n";
	}
	elseif($what=="delete_selected"){
		foreach($http_vars as $key=>$val){
			if(!(strpos($key,"mylist_id")===false)){ //if true
				$selected_id =str_replace("mylist_id","",$key);
				//Delete row in database
				delete_row("max_mail_message","mmess_id='$selected_id' LIMIT 1");
			}
		}
	}
	elseif($what=="display_email_body"){
		$row=get_row("max_mail_message","*","mmess_id='$mmess_id'");
		$row[mmess_body_text] =strip_tags($row[mmess_body]);		
		$row[mmess_body]=str_replace("&quot;","\"",$row[mmess_body]);
		print "<html><head><meta http-equiv=Content-Type content=text/html; charset=$charset></head><body>$row[mmess_body]</body></html>";
		exit;
	}

	if($row_number =="" || $row_number =="0" || !is_numeric($row_number)) $row_number = 15;
	set_global_var("row_number",$row_number);
	$row_per_page = $row_number;
				
	if ($page < 1 || $page=="") $page =1;
	$start = ($page-1)* 1 * $row_per_page;
	$end = $start + 1 * $row_per_page;
	
	if($cmd_button=="Search" && $keyword!=""){									
		   $keyword = mysql_escape_string($keyword);
		   $list_data =set_array_from_query("max_mail_message","*,MATCH(mmess_subject, mmess_body, mmess_body_text) AGAINST ('$keyword' IN BOOLEAN MODE) AS score","MATCH(mmess_subject, mmess_body, mmess_body_text) AGAINST ('$keyword' IN BOOLEAN MODE) Order by mmess_id DESC,mmess_subject LIMIT $start,$row_per_page");
		   $count_list=get_dbvalue("max_mail_message","count(mmess_id)","MATCH(mmess_subject, mmess_body, mmess_body_text) AGAINST ('$keyword' IN BOOLEAN MODE)");
	}
	else{
		$list_data =set_array_from_query("max_mail_message","*","mmess_id<>'' Order by mmess_id DESC,mmess_subject LIMIT $start,$row_per_page");
		$count_list=get_dbvalue("max_mail_message","count(mmess_id)");		
	}
	$keyword=urlencode($keyword);

	if ($end > $count_list) $end = $count_list;
	$xrow=0;
	for ($z=$start; $z<$end; $z++) {
		$val = $list_data[$xrow][mmess_id] ;
		$row_data=$list_data[$xrow];

		//Show icon
		$show_icon ="<img border=\"0\" src=\"html/07_icon_new_message.gif\" alt=\"\" />";

		//Show Newsletter Detail
		$row_data[mmess_body]=str_replace("&quot;","\"",$row_data[mmess_body]);
		$row_data[mmess_body]=str_replace("&","&amp;",$row_data[mmess_body]);
		$row_data[mmess_body] = preg_replace ("/<textarea/i","<xtextarea", $row_data[mmess_body]);
		$row_data[mmess_body] = preg_replace ("/<\/textarea\>/i","</xtextarea>", $row_data[mmess_body]);
		$row_data[mmess_body_text]=str_replace("&","&amp;",$row_data[mmess_body_text]);
		$row_data[mmess_body_text] = preg_replace ("/<textarea/i","<xtextarea", $row_data[mmess_body_text]);
		$row_data[mmess_body_text] = preg_replace ("/<\/textarea\>/i","</xtextarea>", $row_data[mmess_body_text]);
		$emai_body="<div style=\"display:none;\" align=\"center\" id=\"email_body$val\"><br /><div style=\"width:95%;border:1px solid silver;background-image:url(html/07_title_background.gif);font-weight:bold;line-height:22px;cursor:pointer;\" onclick=\"showid('email_body$val');\">$email_tool_create_message_txt_html_version_click_to_close</div><textarea onfocus=\"original_value=this.value;\" onchange=\"Editme('index.php?step=edit_me&table=max_mail_message&edit_id=mmess_id&edit_id_value=$val&edit_key=mmess_body&edit_value=',this.value,'1',original_value,this.id);\" id=\"mmess_body$val\" style=\"border:1px solid silver;width:95%;height:300px\">$row_data[mmess_body]</textarea><br /><br /><div style=\"width:95%;border:1px solid silver;background-image:url(html/07_title_background2.gif);font-weight:bold;line-height:22px;cursor:pointer;\" onclick=\"showid('email_body$val');\">$email_tool_create_message_txt_text_version_click_to_close</div><textarea onfocus=\"original_value=this.value;\" onchange=\"Editme('index.php?step=edit_me&table=max_mail_message&edit_id=mmess_id&edit_id_value=$val&edit_key=mmess_body_text&edit_value=',this.value,'1',original_value,this.id);\" id=\"mmess_body_text$val\" style=\"border:1px solid silver;width:95%;height:300px\">$row_data[mmess_body_text]</textarea></div>";
		
		$show_mmess_detail ="$email_tool_create_message_txt_email_subject: <input id=\"mmess_subject$val\" title=\"$email_tool_create_tooltip_click_here_to_edit\" type=\"text\" value=\"$row_data[mmess_subject]\" style=\"border:0px;background-color:#EAEAEA;cursor:pointer;width:500px;text-decoration:underline;\" onfocus=\"original_value=this.value;this.style.border='1px solid silver';this.style.textDecoration='none';this.style.cursor='text';\" onblur=\"this.style.border='0px';this.style.textDecoration='underline';this.style.cursor='pointer';\" onchange=\"Editme('index.php?step=edit_me&table=max_mail_message&edit_id=mmess_id&edit_id_value=$val&edit_key=mmess_subject&edit_value=',this.value,'1',original_value,this.id);\" /><br /><a href=\"javascript:showid('email_body$val');\">Click here</a> to edit Email body$emai_body";

		//Show preview email icon
		$show_preview_icon ="<a href=index.php?step=$step&what=display_email_body&mmess_id=$val target=_blank><img border=\"0\" src=\"html/07_icon_view_email16.gif\" alt=\"$email_tool_create_tooltip_preview_message\" title=\"$email_tool_create_tooltip_preview_message\" /></a>";		

		//Show delete button
		$show_delete_button="<img onclick=\"document.getElementById('tr$val').style.backgroundColor='#E4E4D3';document.getElementById('bk$val').checked='true';CheckSelected();\" border=\"0\" src=\"html/07_icon_delete.gif\" style=\"cursor:pointer\" alt=\"$email_tool_create_tooltip_delete\" title=\"$email_tool_create_tooltip_delete\" />";
			
		$show_list_table .="<tr id=\"tr$val\" style=\"background-color: #EAEAEA;line-height:20px\">\n";
		$show_list_table .="<td width=\"1%\" align=\"center\" style=\"padding:7px;\" valign=\"top\">$show_icon</td>\n";
		$show_list_table .="<td width=\"*\" style=\"padding:4px;white-space:nowrap\">$show_mmess_detail</td>\n";
		$show_list_table .="<td width=\"1%\" align=\"center\" style=\"padding:7px;cursor:pointer;\">$show_preview_icon</td>\n";
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
				$dpn ="<a href=\"index.php?step=$step&row_number=$row_number&page=$page_pr\"><img border=0 src=html/prv.gif style='vertical-align:middle' title='Page # $page_pr' alt='Page # $page_pr' /></a>";
				$display_page_number = str_replace("{A}", $dpn, $display_page_number);
			}
			else{
				$display_page_number = str_replace("{A}", "<img src=html/prv_disable.gif alt='' style='vertical-align:middle' />", $display_page_number);
			}
			$y=get_global_var("d_num");
			if ($page < $y) {
				$page_ne = $page + 1 ;				
				$display_page_number = str_replace("{B}", "<a href=\"index.php?step=$step&row_number=$row_number&page=$page_ne\"><img border=0 src=html/next.gif style='vertical-align:middle' title='Page # $page_ne' alt='Page # $page_ne' /></a>", $display_page_number);
			}	
			else{
				$display_page_number = str_replace("{B}", "<img src=html/next_disable.gif alt='' style='vertical-align:middle' />", $display_page_number);
			}
		}
	}
	set_global_var("display_page_number",$display_page_number);	 
	
	if($db_change =="1"){
		set_global_var("show_info","<span class=\"OK_Message\">$email_tool_create_message_db_updated<br /><br /></span>");	
	}
	else{
		set_global_var("show_info","<span class=\"Error_Message\">$show_info<br /></span>");	
	}
	
	set_global_var("count_total",$count_list);		
	set_global_var("print_object",get_html_from_layout("admin/html/admin_emailtool_create_message.html"));	
	print_admin_header_footer_page();	

	//--------------------------------------------------------------------------------------
	function get_page_count_number($page,$b){
		global $step,$what,$row_number,$mmess_id,$keyword,$cmd_button;
			
		$url="index.php?step=$step&row_number=$row_number&keyword=$keyword&cmd_button=$cmd_button";
		if($what=="admin_emailtool_preview_email" || $what=="admin_emailtool_extract_email")$url.="&what=$what&mmess_id=$mmess_id";
		$count_number ="";
		
		$y=0;
		if ($b <10){
			for($a_num=1; $a_num<=$b; $a_num++) {
				$y++;
				if ($a_num == $page) {
					$count_number .="<span style=\"cursor: default;\" class='page_active'>&nbsp;$a_num&nbsp;</span>&nbsp;";					
				}
				else {
					$count_number .="<a class=\"page_other\" href=\"$url&page=$a_num\">&nbsp;$a_num&nbsp;</a>&nbsp;";
				}
			}
		}
		elseif(($page > 3) && ($page < ($b-3))){
			for($a_num=1; $a_num<=3; $a_num++) {
				$y++;
				$count_number .="<a class=\"page_other\" href=\"$url&page=$a_num\">&nbsp;$a_num&nbsp;</a>&nbsp;";
			}
			$count_number .="...";
			for($a_num = $page-1; $a_num<=$page+1; $a_num++) {
				$y++;
				if ($a_num == $page) {
					$count_number .="&nbsp;<span style=\"cursor: default;\" class='page_active'>&nbsp;$a_num&nbsp;</span>&nbsp;";
				}
				else {		
					$count_number .="<a class=\"page_other\" href=\"$url&page=$a_num\">&nbsp;$a_num&nbsp;</a>&nbsp;";
				}
			}
			$count_number .="...";
			for($a_num = $b-2; $a_num<=$b; $a_num++) {
				$y++;
				$count_number .="<a class=\"page_other\" href=\"$url&page=$a_num\">&nbsp;$a_num&nbsp;</a>&nbsp;";
			}
		}
		else{
			for($a_num=1; $a_num<=4; $a_num++) {
				$y++;
				if ($a_num == $page) {
					$count_number .="&nbsp;<span style=\"cursor: default;\" class='page_active'>&nbsp;$a_num&nbsp;</span>&nbsp;";
				}
				else {
					$count_number .="<a class=\"page_other\" href=\"$url&page=$a_num\">&nbsp;$a_num&nbsp;</a>&nbsp;";
				}
			}
			$count_number .="...";			
			for($a_num=$b-3; $a_num<=$b; $a_num++) {
				$y++;
				if ($a_num == $page) {
					$count_number .="&nbsp;<span style=\"cursor: default;\" class='page_active'>&nbsp;$a_num&nbsp;</span>&nbsp;";
				}
				else {	
					$count_number .="<a class=\"page_other\" href=\"$url&page=$a_num\">&nbsp;$a_num&nbsp;</a>&nbsp;";
				}
			}
		}
		set_global_var("d_num",$b);
		return $count_number;
	}

?>
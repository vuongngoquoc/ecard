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
		$field_name ="(mgroup_name,mgroup_from_name,mgroup_from_email)";
		$field_value ="('$mgroup_name','$mgroup_from_name','$mgroup_from_email')";
		insert_data_to_db("max_mail_group",$field_name,$field_value);

		//Insert email to database
		if($email !=""){
			$array_email=split("\n",$email);
			$array_email=array_unique($array_email);
			$list_mgroup_id=get_dbvalue("max_mail_group","max(mgroup_id)");
			$list_time=$gmt_timestamp_now;
			$field_name ="(list_email,list_mgroup_id,list_time)";
			$field_value="";
			foreach($array_email as $email){
				$email=trim($email);
				if(valid_email($email)){
					$field_value .="('$email',$list_mgroup_id,$list_time),";
				}
			}
			if($field_value!=""){
				if($field_value{strlen($field_value)-1} ==",") $field_value = substr($field_value, 0, strlen($field_value)-1);
				insert_data_to_db("max_mail_list",$field_name,$field_value);
			}
		}
		
		$email_tool_recipient_group_message_new_group_add=str_replace("%group_name%",$mgroup_name,$email_tool_recipient_group_message_new_group_add);

		$show_info .="<span class=OK_Message>$email_tool_recipient_group_message_new_group_add</span><br />\n";
	}
	elseif($what=="delete_selected"){
		foreach($http_vars as $key=>$val){
			if(!(strpos($key,"mylist_id")===false)){ //if true
				$selected_id =str_replace("mylist_id","",$key);
				//Delete row in database
				delete_row("max_mail_group","mgroup_id='$selected_id' LIMIT 1");
			}
		}
	}
	elseif($what=="admin_emailtool_preview_email"){
		if($what2=="delete_selected"){
			foreach($http_vars as $key=>$val){
				if(!(strpos($key,"mylist_id")===false)){ //if true
					$selected_id =str_replace("mylist_id","",$key);					
					//Delete row in database
					delete_row("max_mail_list","list_id='$selected_id' LIMIT 1");
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
			   $list_data =set_array_from_query("max_mail_list","*","list_email like '%$keyword%' and list_mgroup_id='$mgroup_id' Order by list_email,list_name LIMIT $start,$row_per_page");
			   $count_list=get_dbvalue("max_mail_list","count(list_id)","list_email like '%$keyword%' and list_mgroup_id='$mgroup_id' ");
			   $show_info ="<span class=\"OK_Message\">$email_tool_recipient_group_message_search_email_keyword: <span style=\"color:blue\">$keyword</span><br /><br /></span>";
		}
		else{
			$list_data =set_array_from_query("max_mail_list","*","list_mgroup_id='$mgroup_id' Order by list_email,list_name LIMIT $start,$row_per_page");
			$count_list=get_dbvalue("max_mail_list","count(list_id)","list_mgroup_id='$mgroup_id'");
		}

		if ($end > $count_list) $end = $count_list;
		$xrow=0;
		for ($z=$start; $z<$end; $z++) {
			$val = $list_data[$xrow][list_id] ;
			$row_data=$list_data[$xrow];

			//Show icon
			$show_icon ="<img border=\"0\" src=\"html/07_icon_yes_email.gif\" alt=\"\" />";

			//Show email
			if ($cf_hide_email_confidential) { $row_data[list_email]="[$ecard_log_txt_confidential]"; }
			$show_email = $row_data[list_email];

			//IP 2 Location
			$array_country_info=ip2location($row_data[list_ip]);
			if($array_country_info[ip_country2]){
				$ip2country="<div style=\"font-size:8pt\">$email_tool_recipient_group_txt_ip2country: <img border=\"0\" src=\"$ecard_url/resource/flags/$array_country_info[ip_country2].gif\" alt=\"$email_tool_recipient_group_tooltip_user_ip2country: $row_data[fm_ip] $array_country_info[ip_country] - $array_country_info[ip_country_name]\" title=\"$email_tool_recipient_group_tooltip_user_ip2country: $row_data[list_ip]  $array_country_info[ip_country] - $array_country_info[ip_country_name]\" /> <strong>$array_country_info[ip_country_name]</strong> ($row_data[list_ip])</div>";
			}
			else{
				$ip2country="";
			}

			//Show more info
			$show_more_info="$email_tool_recipient_group_txt_user_name: $row_data[list_email]<br />$ip2country";

			//Show time added
			if($row_data[list_time]>0){
				$show_time_add=DateFormat($row_data[list_time],"2");
			}
			else{
				$show_time_add="-";
			}

			//Show delete button
			$show_delete_button="<img onclick=\"document.getElementById('tr$val').style.backgroundColor='#E4E4D3';document.getElementById('bk$val').checked='true';CheckSelected();\" border=\"0\" src=\"html/07_icon_delete.gif\" style=\"cursor:pointer\" alt=\"$email_tool_recipient_group_txt_delete\" title=\"$email_tool_recipient_group_txt_delete\" />";
				
			$show_list_table .="<tr id=\"tr$val\" style=\"background-color: #EAEAEA;line-height:20px\">\n";
			$show_list_table .="<td width=\"1%\" align=\"center\" style=\"padding:7px;\">$show_icon</td>\n";
			$show_list_table .="<td width=\"*\" style=\"padding:4px;white-space:nowrap\">$show_email</td>\n";
			$show_list_table .="<td width=\"*\" >$show_more_info</td>\n";
			$show_list_table .="<td width=\"1%\" align=\"center\" style=\"padding:7px;white-space:nowrap\">$show_time_add</td>\n";
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
					$dpn ="<a href=\"index.php?step=$step&row_number=$row_number&page=$page_pr&what=$what&mgroup_id=$mgroup_id&keyword=$keyword&cmd_button=$cmd_button\"><img border=0 src=html/prv.gif style='vertical-align:middle' title='Page # $page_pr' alt='Page # $page_pr' /></a>";
					$display_page_number = str_replace("{A}", $dpn, $display_page_number);
				}
				else{
					$display_page_number = str_replace("{A}", "<img src=html/prv_disable.gif alt='' style='vertical-align:middle' />", $display_page_number);
				}
				$y=get_global_var("d_num");
				if ($page < $y) {
					$page_ne = $page + 1 ;				
					$display_page_number = str_replace("{B}", "<a href=\"index.php?step=$step&row_number=$row_number&page=$page_ne&what=$what&mgroup_id=$mgroup_id&keyword=$keyword&cmd_button=$cmd_button\"><img border=0 src=html/next.gif style='vertical-align:middle' title='Page # $page_ne' alt='Page # $page_ne' /></a>", $display_page_number);
				}	
				else{
					$display_page_number = str_replace("{B}", "<img src=html/next_disable.gif alt='' style='vertical-align:middle' />", $display_page_number);
				}
			}
		}
		set_global_var("display_page_number",$display_page_number);	 
		set_global_var("count_total",$count_list);
		set_global_var("count_total_email",get_dbvalue("max_mail_list","count(list_id)","list_mgroup_id='$mgroup_id'"));
		
		if($mgroup_id=="-1"){
			set_global_var("group_name","<span style=\"color:green\">$email_tool_recipient_group_txt_newsletter_list</span>");
		}
		elseif($mgroup_id=="-2"){
			set_global_var("group_name","<span style=\"color:green\">$email_tool_recipient_group_txt_special_offers_list</span>");
		}
		else{
			$group_name=get_dbvalue("max_mail_group","mgroup_name","mgroup_id='$mgroup_id'");
			set_global_var("group_name","<span style=\"color:green\">$group_name</span>");
		}
		set_global_var("show_info",$show_info);	
		print get_html_from_layout("admin/html/admin_emailtool_preview_email.html");	
		exit;
	}
	elseif($what=="admin_emailtool_add_email"){
		if($what2=="add_new"){			
			//Insert email to database
			if($email_bulk !=""){
				$array_email=split("\n",$email_bulk);
				$array_email=array_unique($array_email);
				$list_mgroup_id=$mgroup_id;
				$list_time=$gmt_timestamp_now;
				$field_name ="(list_email,list_mgroup_id,list_time)";
				$field_value="";
				$count_email=0;
				foreach($array_email as $email){
					$email=trim($email);
					if(valid_email($email)){
						$field_value .="('$email',$list_mgroup_id,$list_time),";
						$count_email++;
					}
				}
				if($field_value!=""){
					if($field_value{strlen($field_value)-1} ==",") $field_value = substr($field_value, 0, strlen($field_value)-1);
					insert_data_to_db("max_mail_list",$field_name,$field_value);
					$email_tool_recipient_group_message_email_address_added=str_replace("%count_email%",$count_email,$email_tool_recipient_group_message_email_address_added);
					$show_info .="<span class=OK_Message>$email_tool_recipient_group_message_email_address_added</span><br /><br />\n";
				}
			}			
		}
		if($mgroup_id=="-1"){
			set_global_var("group_name","<span style=\"color:green\">$email_tool_recipient_group_txt_newsletter_list</span>");
		}
		elseif($mgroup_id=="-2"){
			set_global_var("group_name","<span style=\"color:green\">$email_tool_recipient_group_txt_special_offers_list</span>");
		}
		else{
			$group_name=get_dbvalue("max_mail_group","mgroup_name","mgroup_id='$mgroup_id'");
			set_global_var("group_name","<span style=\"color:green\">$group_name</span>");
		}

		set_global_var("show_info",$show_info);
		set_global_var("count_total_email",get_dbvalue("max_mail_list","count(list_id)","list_mgroup_id='$mgroup_id'"));
		print get_html_from_layout("admin/html/admin_emailtool_add_email.html");	
		exit;
	}
	elseif($what=="admin_emailtool_extract_email"){
		if($row_number =="" || $row_number =="0" || !is_numeric($row_number)) $row_number = 1000;
		set_global_var("row_number",$row_number);
		$row_per_page = $row_number;
					
		if ($page < 1 || $page=="") $page =1;
		$start = ($page-1)* 1 * $row_per_page;
		$end = $start + 1 * $row_per_page;
		
		$list_data =set_array_from_query("max_mail_list","*","list_mgroup_id='$mgroup_id' Order by list_email LIMIT $start,$row_per_page");
		$count_list=get_dbvalue("max_mail_list","count(list_id)","list_mgroup_id='$mgroup_id'");

		if ($end > $count_list) $end = $count_list;
		$xrow=0;
		for ($z=$start; $z<$end; $z++) {
			$row_data=$list_data[$xrow];
			//Show email
			$show_email_list .= "$row_data[list_email]\n";			
			$xrow++;
		}
		if ($cf_hide_email_confidential) { $show_email_list="[$ecard_log_txt_confidential]"; }
		set_global_var("show_email_list",$show_email_list);

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
					$dpn ="<a href=\"index.php?step=$step&row_number=$row_number&page=$page_pr&what=$what&mgroup_id=$mgroup_id&keyword=$keyword&cmd_button=$cmd_button\"><img border=0 src=html/prv.gif style='vertical-align:middle' title='Page # $page_pr' alt='Page # $page_pr' /></a>";
					$display_page_number = str_replace("{A}", $dpn, $display_page_number);
				}
				else{
					$display_page_number = str_replace("{A}", "<img src=html/prv_disable.gif alt='' style='vertical-align:middle' />", $display_page_number);
				}
				$y=get_global_var("d_num");
				if ($page < $y) {
					$page_ne = $page + 1 ;				
					$display_page_number = str_replace("{B}", "<a href=\"index.php?step=$step&row_number=$row_number&page=$page_ne&what=$what&mgroup_id=$mgroup_id&keyword=$keyword&cmd_button=$cmd_button\"><img border=0 src=html/next.gif style='vertical-align:middle' title='Page # $page_ne' alt='Page # $page_ne' /></a>", $display_page_number);
				}	
				else{
					$display_page_number = str_replace("{B}", "<img src=html/next_disable.gif alt='' style='vertical-align:middle' />", $display_page_number);
				}
			}
		}
		set_global_var("display_page_number",$display_page_number);

		if($mgroup_id=="-1"){
			set_global_var("group_name","<span style=\"color:green\">$email_tool_recipient_group_txt_newsletter_list</span>");
		}
		elseif($mgroup_id=="-2"){
			set_global_var("group_name","<span style=\"color:green\">$email_tool_recipient_group_txt_special_offers_list</span>");
		}
		else{
			$group_name=get_dbvalue("max_mail_group","mgroup_name","mgroup_id='$mgroup_id'");
			set_global_var("group_name","<span style=\"color:green\">$group_name</span>");
		}

		set_global_var("count_total_email",$count_list);
		print get_html_from_layout("admin/html/admin_emailtool_extract_email.html");	
		exit;
	}

	if($row_number =="" || $row_number =="0" || !is_numeric($row_number)) $row_number = 15;
	set_global_var("row_number",$row_number);
	$row_per_page = $row_number;
				
	if ($page < 1 || $page=="") $page =1;
	$start = ($page-1)* 1 * $row_per_page;
	$end = $start + 1 * $row_per_page;
	
	$list_data =set_array_from_query("max_mail_group","*","mgroup_id<>'' Order by mgroup_name,mgroup_from_name,mgroup_from_email LIMIT $start,$row_per_page");
	$count_list=get_dbvalue("max_mail_group","count(mgroup_id)");	
	
	//Show newsletter & special offers group on top
	$show_mgroup_name_newsletter ="$email_tool_recipient_group_txt_group_title: <span class=\"OK_Message\">$email_tool_recipient_group_txt_newsletter_list</span><br />$email_tool_recipient_group_txt_from_name: <strong>$cf_site_title</strong><br />$email_tool_recipient_group_txt_from_email: <strong>$cf_webmaster_email</strong>";
	$show_mgroup_name_special_offer ="$email_tool_recipient_group_txt_group_title: <span class=\"OK_Message\">$email_tool_recipient_group_txt_special_offers_list</span><br />$email_tool_recipient_group_txt_from_name: <strong>$cf_site_title</strong><br />$email_tool_recipient_group_txt_from_email: <strong>$cf_webmaster_email</strong>";

	//Count total email in this group
	$total_email_this_group_newsletter =get_dbvalue("max_mail_list","count(list_id)","list_mgroup_id='-1'");
	$total_email_this_group_special_offer =get_dbvalue("max_mail_list","count(list_id)","list_mgroup_id='-2'");

	//Show view email icon
	$show_view_icon ="<img id=\"view_email\" border=\"0\" src=\"html/07_icon_view_email16.gif\" alt=\"View emails in this group\" title=\"View emails in this group\" />";

	//Show add email icon
	$show_add_icon ="<img id=\"add_email\" border=\"0\" src=\"html/icon_plus16.gif\" alt=\"$email_tool_recipient_group_tooltip_add_new_email_this_group\" title=\"$email_tool_recipient_group_tooltip_add_new_email_this_group\" />";

	//Show extract email icon
	$show_extract_icon ="<img id=\"extract_email\" border=\"0\" src=\"html/07_icon_extract_email.gif\" alt=\"$email_tool_recipient_group_tooltip_extract_email\" title=\"$email_tool_recipient_group_tooltip_extract_email\" />";

	$show_list_table ="<tr style=\"background-color: white;line-height:20px\">\n";
	$show_list_table .="<td width=\"1%\" align=\"center\" style=\"padding:7px;\" id=\"cell$val\"><img border=\"0\" src=\"html/07_icon_mailgroup_unchange.gif\" alt=\"\" /></td>\n";
	$show_list_table .="<td width=\"*\" style=\"padding:4px;white-space:nowrap\">$show_mgroup_name_newsletter</td>\n";
	$show_list_table .="<td width=\"1%\" align=\"center\"><span id=\"update_number_newsletter\">$total_email_this_group_newsletter</span></td>\n";
	$show_list_table .="<td width=\"1%\" align=\"center\" style=\"padding:7px;cursor:pointer;\" title=\"$email_tool_recipient_group_tooltip_click_to_view_email\" id=\"cell_newsletter\" onclick=\"HideItAll();this.style.backgroundColor='#FAEDC8';this.style.border='thick solid #FCAA03';showid2('div_iframe','block');location.hash='#show_hidden_iframe';frames['preview_frame'].location.href = 'index.php?step=$step&what=admin_emailtool_preview_email&mgroup_id=-1';\">$show_view_icon</td>\n";
	$show_list_table .="<td width=\"1%\" align=\"center\" style=\"padding:7px;cursor:pointer;\" title=\"$email_tool_recipient_group_tooltip_click_to_add_new_email_to_list\" id=\"cell_add_newsletter\" onclick=\"HideItAll();this.style.backgroundColor='#FAEDC8';this.style.border='thick solid #FCAA03';showid2('div_iframe','block');location.hash='#show_hidden_iframe';frames['preview_frame'].location.href = 'index.php?step=$step&what=admin_emailtool_add_email&mgroup_id=-1';\">$show_add_icon</td>\n";
	$show_list_table .="<td width=\"1%\" align=\"center\" style=\"padding:7px;cursor:pointer;\" title=\"$email_tool_recipient_group_tooltip_click_to_extract_email\" id=\"cell_extract_newsletter\" onclick=\"HideItAll();this.style.backgroundColor='#FAEDC8';this.style.border='thick solid #FCAA03';showid2('div_iframe','block');location.hash='#show_hidden_iframe';frames['preview_frame'].location.href = 'index.php?step=$step&what=admin_emailtool_extract_email&mgroup_id=-1';\">$show_extract_icon</td>\n";
	$show_list_table .="<td width=\"1%\" align=\"center\">-</td>\n";
	$show_list_table .="<td width=\"1%\" align=\"center\">-</td>\n";
	$show_list_table .="</tr>\n";

	$show_list_table .="<tr style=\"background-color: white;line-height:20px\">\n";
	$show_list_table .="<td width=\"1%\" align=\"center\" style=\"padding:7px;\" id=\"cell$val\"><img border=\"0\" src=\"html/07_icon_mailgroup_unchange.gif\" alt=\"\" /></td>\n";
	$show_list_table .="<td width=\"*\" style=\"padding:4px;white-space:nowrap\">$show_mgroup_name_special_offer</td>\n";
	$show_list_table .="<td width=\"1%\" align=\"center\"><span id=\"update_number_special_offer\">$total_email_this_group_special_offer</span></td>\n";
	$show_list_table .="<td width=\"1%\" align=\"center\" style=\"padding:7px;cursor:pointer;\" title=\"$email_tool_recipient_group_tooltip_click_to_view_email\" id=\"cell_special_offer\" onclick=\"HideItAll();this.style.backgroundColor='#FAEDC8';this.style.border='thick solid #FCAA03';showid2('div_iframe','block');location.hash='#show_hidden_iframe';frames['preview_frame'].location.href = 'index.php?step=$step&what=admin_emailtool_preview_email&mgroup_id=-2';\">$show_view_icon</td>\n";
	$show_list_table .="<td width=\"1%\" align=\"center\" style=\"padding:7px;cursor:pointer;\" title=\"$email_tool_recipient_group_tooltip_click_to_add_new_email_to_list\" id=\"cell_add_special_offer\" onclick=\"HideItAll();this.style.backgroundColor='#FAEDC8';this.style.border='thick solid #FCAA03';showid2('div_iframe','block');location.hash='#show_hidden_iframe';frames['preview_frame'].location.href = 'index.php?step=$step&what=admin_emailtool_add_email&mgroup_id=-2';\">$show_add_icon</td>\n";
	$show_list_table .="<td width=\"1%\" align=\"center\" style=\"padding:7px;cursor:pointer;\" title=\"$email_tool_recipient_group_tooltip_click_to_extract_email\" id=\"cell_extract_special_offer\" onclick=\"HideItAll();this.style.backgroundColor='#FAEDC8';this.style.border='thick solid #FCAA03';showid2('div_iframe','block');location.hash='#show_hidden_iframe';frames['preview_frame'].location.href = 'index.php?step=$step&what=admin_emailtool_extract_email&mgroup_id=-2';\">$show_extract_icon</td>\n";
	$show_list_table .="<td width=\"1%\" align=\"center\">-</td>\n";
	$show_list_table .="<td width=\"1%\" align=\"center\">-</td>\n";
	$show_list_table .="</tr>\n";

	if ($end > $count_list) $end = $count_list;
	$xrow=0;
	for ($z=$start; $z<$end; $z++) {
		$val = $list_data[$xrow][mgroup_id] ;
		$row_data=$list_data[$xrow];

		//Show icon
		$show_icon ="<img border=\"0\" src=\"html/07_icon_mailgroup.gif\" alt=\"\" />";

		//Show group title, from name, from email
		$show_mgroup_name ="Group Title: <input id=\"mgroup_name$val\" title=\"$email_tool_recipient_group_tooltip_click_to_edit\" type=\"text\" value=\"$row_data[mgroup_name]\" style=\"border:0px;background-color:#EAEAEA;cursor:pointer;width:450px;text-decoration:underline;\" onfocus=\"original_value=this.value;this.style.border='1px solid silver';this.style.textDecoration='none';this.style.cursor='text';\" onblur=\"this.style.border='0px';this.style.textDecoration='underline';this.style.cursor='pointer';\" onchange=\"Editme('index.php?step=edit_me&table=max_mail_group&edit_id=mgroup_id&edit_id_value=$val&edit_key=mgroup_name&edit_value=',this.value,'1',original_value,this.id);\" /><br />$email_tool_recipient_group_txt_from_name: <input id=\"mgroup_from_name$val\" title=\"$email_tool_recipient_group_tooltip_click_to_edit\" type=\"text\" value=\"$row_data[mgroup_from_name]\" style=\"border:0px;background-color:#EAEAEA;cursor:pointer;width:450px;text-decoration:underline;\" onfocus=\"original_value=this.value;this.style.border='1px solid silver';this.style.textDecoration='none';this.style.cursor='text';\" onblur=\"this.style.border='0px';this.style.textDecoration='underline';this.style.cursor='pointer';\" onchange=\"Editme('index.php?step=edit_me&table=max_mail_group&edit_id=mgroup_id&edit_id_value=$val&edit_key=mgroup_from_name&edit_value=',this.value,'1',original_value,this.id);\" /><br />$email_tool_recipient_group_txt_from_email: <input id=\"mgroup_from_email$val\" title=\"$email_tool_recipient_group_tooltip_click_to_edit\" type=\"text\" value=\"$row_data[mgroup_from_email]\" style=\"border:0px;background-color:#EAEAEA;cursor:pointer;width:450px;text-decoration:underline;\" onfocus=\"original_value=this.value;this.style.border='1px solid silver';this.style.textDecoration='none';this.style.cursor='text';\" onblur=\"this.style.border='0px';this.style.textDecoration='underline';this.style.cursor='pointer';\" onchange=\"Editme('index.php?step=edit_me&table=max_mail_group&edit_id=mgroup_id&edit_id_value=$val&edit_key=mgroup_from_email&edit_value=',this.value,'1',original_value,this.id);\" />";

		//Count total email in this group
		$total_email_this_group =get_dbvalue("max_mail_list","count(list_id)","list_mgroup_id='$val'");

		//Show view email icon
		$show_view_icon ="<img border=\"0\" src=\"html/07_icon_view_email16.gif\" alt=\"$email_tool_recipient_group_tooltip_view_email_in_this_group\" title=\"$email_tool_recipient_group_tooltip_view_email_in_this_group\" />";

		//Show add email icon
		$show_add_icon ="<img border=\"0\" src=\"html/icon_plus16.gif\" alt=\"$email_tool_recipient_group_tooltip_add_new_email_this_group\" title=\"$email_tool_recipient_group_tooltip_add_new_email_this_group\" />";

		//Show extract email icon
		$show_extract_icon ="<img border=\"0\" src=\"html/07_icon_extract_email.gif\" alt=\"$email_tool_recipient_group_tooltip_extract_email\" title=\"$email_tool_recipient_group_tooltip_extract_email\" />";

		//Show delete button
		$show_delete_button="<img onclick=\"document.getElementById('tr$val').style.backgroundColor='#E4E4D3';document.getElementById('bk$val').checked='true';CheckSelected();\" border=\"0\" src=\"html/07_icon_delete.gif\" style=\"cursor:pointer\" alt=\"$email_tool_recipient_group_txt_delete\" title=\"$email_tool_recipient_group_txt_delete\" />";
			
		$show_list_table .="<tr id=\"tr$val\" style=\"background-color: #EAEAEA;line-height:20px\">\n";
		$show_list_table .="<td width=\"1%\" align=\"center\" style=\"padding:7px;\">$show_icon</td>\n";
		$show_list_table .="<td width=\"*\" style=\"padding:4px;white-space:nowrap\">$show_mgroup_name</td>\n";
		$show_list_table .="<td width=\"1%\" align=\"center\"><span id=\"update_number$val\">$total_email_this_group</span></td>\n";
		$show_list_table .="<td width=\"1%\" align=\"center\" style=\"padding:7px;cursor:pointer;\" title=\"$email_tool_recipient_group_tooltip_click_to_view_email\" id=\"cell$val\" onclick=\"HideItAll();this.style.backgroundColor='#FAEDC8';this.style.border='thick solid #FCAA03';showid2('div_iframe','block');location.hash='#show_hidden_iframe';frames['preview_frame'].location.href = 'index.php?step=$step&what=admin_emailtool_preview_email&mgroup_id=$val';\">$show_view_icon</td>\n";
		$show_list_table .="<td width=\"1%\" align=\"center\" style=\"padding:7px;cursor:pointer;\" title=\"$email_tool_recipient_group_tooltip_click_to_add_new_email_to_list\" id=\"cell_add$val\" onclick=\"HideItAll();this.style.backgroundColor='#FAEDC8';this.style.border='thick solid #FCAA03';showid2('div_iframe','block');location.hash='#show_hidden_iframe';frames['preview_frame'].location.href = 'index.php?step=$step&what=admin_emailtool_add_email&mgroup_id=$val';\">$show_add_icon</td>\n";
		$show_list_table .="<td width=\"1%\" align=\"center\" style=\"padding:7px;cursor:pointer;\" title=\"$email_tool_recipient_group_tooltip_click_to_extract_email\" id=\"cell_extract$val\" onclick=\"HideItAll();this.style.backgroundColor='#FAEDC8';this.style.border='thick solid #FCAA03';showid2('div_iframe','block');location.hash='#show_hidden_iframe';frames['preview_frame'].location.href = 'index.php?step=$step&what=admin_emailtool_extract_email&mgroup_id=$val';\">$show_extract_icon</td>\n";
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
		set_global_var("show_info","<span class=\"OK_Message\">$email_tool_recipient_group_message_db_updated<br /><br /></span>");	
	}
	else{
		set_global_var("show_info","<span class=\"Error_Message\">$show_info<br /></span>");	
	}	

	set_global_var("count_total",$count_list);		
	set_global_var("print_object",get_html_from_layout("admin/html/admin_emailtool_recipient_group.html"));	
	print_admin_header_footer_page();	

	//--------------------------------------------------------------------------------------
	function get_page_count_number($page,$b){
		global $step,$what,$row_number,$mgroup_id,$keyword,$cmd_button;
			
		$url="index.php?step=$step&row_number=$row_number&keyword=$keyword&cmd_button=$cmd_button";
		if($what=="admin_emailtool_preview_email" || $what=="admin_emailtool_extract_email")$url.="&what=$what&mgroup_id=$mgroup_id";
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
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
	if($what=="add_new_bulk"){		
		if($time_end==1){//Forever= 20 years
			$ban_time_end = $gmt_timestamp_now + (86400*365*20);
		}
		elseif($time_end==2){//1 day
			$ban_time_end = $gmt_timestamp_now + 86400;
		}
		elseif($time_end==3){//1 week
			$ban_time_end = $gmt_timestamp_now + (86400*7);
		}
		elseif($time_end==4){//1 month
			$ban_time_end = $gmt_timestamp_now + (86400*30);
		}
		elseif($time_end==5){//1 year
			$ban_time_end = $gmt_timestamp_now + (86400*365);
		}
		elseif($time_end==6){//Until to
			list($get_mon,$get_day,$get_year)=split("\/",$time_end_textbox);
			$ban_time_end=gmmktime(0,0,0,$get_mon,$get_day,$get_year);
		}
		$array_it=split("\n",$email_bulk);
		$array_it=array_unique($array_it);
		$array_it_database=get_dblistvalue("max_ban_user","ban_id");
		foreach($array_it as $email){
			$email=trim($email);
			if(valid_email($email) && !in_array($email,$array_it_database)){
				$field_name ="(ban_what,ban_time_end,ban_type,ban_reason)";
				$field_value ="('$email',$ban_time_end,0,'$ban_reason')";
				insert_data_to_db("max_ban_user",$field_name,$field_value);
				$message_new_email_added_to_banned_list=str_replace("%email%","$email",$ban_user_message_new_email_has_been_added_to_ban_list);
				$show_info .="<span class=OK_Message>$message_new_email_added_to_banned_list</span><br />\n";
			}
			elseif(!valid_email($email) && !in_array($email,$array_it_database) && is_numeric($email{0})){
				$field_name ="(ban_what,ban_time_end,ban_type,ban_reason)";
				$field_value ="('$email',$ban_time_end,1,'$ban_reason')";
				insert_data_to_db("max_ban_user",$field_name,$field_value);
				$mesage_new_ip_added_to_banned_list=str_replace("%email%","$email",$ban_user_message_new_ip_has_been_added_to_ban_list);
				$show_info .="<span class=OK_Message>$mesage_new_ip_added_to_banned_list</span><br />\n";
			}
		}		
	}
	elseif($what=="delete_selected"){
		foreach($http_vars as $key=>$val){
			if(!(strpos($key,"mylist_id")===false)){ //if true
				$selected_id =str_replace("mylist_id","",$key);
				//Delete row in database
				delete_row("max_ban_user","ban_id='$selected_id' LIMIT 1");
			}
		}
	}
	elseif($what=="update_time_end"){
		list($get_mon,$get_day,$get_year)=split("\/",$time_end_textbox);
		$ban_time_end=gmmktime(0,0,0,$get_mon,$get_day,$get_year);
		update_field_in_db("max_ban_user","ban_time_end",$ban_time_end,"ban_id='$ban_id' LIMIT 1");
		exit;
	}

	if($row_number =="" || $row_number =="0" || !is_numeric($row_number)) $row_number = 15;
	set_global_var("row_number",$row_number);
	$row_per_page = $row_number;
				
	if ($page < 1 || $page=="") $page =1;
	$start = ($page-1)* 1 * $row_per_page;
	$end = $start + 1 * $row_per_page;
	
	if($cmd_button=="Search"){									
		   $keyword = mysql_escape_string($keyword);
		   $list_data =set_array_from_query("max_ban_user","*","ban_what like '%$keyword%' Order by ban_type,ban_what LIMIT $start,$row_per_page");
		   $count_list=get_dbvalue("max_ban_user","count(ban_id)","ban_what like '%$keyword%'");
	}
	else{
		$list_data =set_array_from_query("max_ban_user","*","ban_id<>'' Order by ban_type,ban_what LIMIT $start,$row_per_page");
		$count_list=get_dbvalue("max_ban_user","count(ban_id)");
	}
	
	$keyword=urlencode($keyword);
	if ($end > $count_list) $end = $count_list;
	$show_list_table="";
	$xrow=0;
	for ($z=$start; $z<$end; $z++) {
		$val = $list_data[$xrow][ban_id] ;
		$row_data=$list_data[$xrow];

		//Show icon
		if(valid_email($row_data[ban_what])){
			$show_icon ="<img id=\"icon$xrow\" border=\"0\" src=\"html/07_icon_no_email.gif\" alt=\"\" />";
			$ip2country="";
		}
		else{
			$show_icon ="<img id=\"icon$xrow\" border=\"0\" src=\"html/07_icon_ban_ip.gif\" alt=\"\" />";
			//IP 2 Location
			$test_ip=str_replace("*","1",$row_data[ban_what]);
			$array_country_info=ip2location($test_ip);
			if($array_country_info[ip_country2]){
				$ip2country=" - $ban_user_txt_ip2country: <img border=\"0\" src=\"$ecard_url/resource/flags/$array_country_info[ip_country2].gif\" alt=\"$array_country_info[ip_country]\" title=\"$array_country_info[ip_country]\" /> <strong>$array_country_info[ip_country_name]</strong>";
			}
			else{
				$ip2country="";
			}
		}		

		//Show email or IP
		$show_what="$row_data[ban_what]$ip2country<br /><strong>$ban_user_txt_reason:</strong> <input id=\"ban_reason$val\" title=\"$ban_user_tooltip_click_here_to_edit\" type=\"text\" value=\"$row_data[ban_reason]\" style=\"border:0px;background-color:#EAEAEA;cursor:pointer;width:500px;text-decoration:underline;\" onfocus=\"original_value=this.value;this.style.border='1px solid silver';this.style.textDecoration='none';this.style.cursor='text';\" onblur=\"this.style.border='0px';this.style.textDecoration='underline';this.style.cursor='pointer';\" onchange=\"Editme('index.php?step=edit_me&table=max_ban_user&edit_id=ban_id&edit_id_value=$val&edit_key=ban_reason&edit_value=',this.value,'1',original_value,this.id);\" />";

		//Show Length of ban
		$get_time_value=gmdate("n/j/Y",$row_data[ban_time_end]);
		list($get_month,$get_day,$get_year)=split("\/",$get_time_value);
		$show_length_ban ="<div id=\"show_until$val\" style=\"cursor:pointer;\" onclick=\"get_cid=$val;ShowDiv(this.id,'view_fullsize_table',0,0);info=document.getElementById('time_end_textbox$val').value.split('\/');frames['calendar_frame'].location.href='index.php?step=admin_calendar&month='+info[0]+'&year='+info[2]+'&selected_day='+info[1]+'&selected_month='+info[0]+'&selected_year='+info[2]\"><input readonly=\"readonly\" type=\"text\" name=\"time_end_textbox$val\" id=\"time_end_textbox$val\" value=\"$get_time_value\" style=\"width:100px\" /> <img border=\"0\" alt=\"\" style=\"vertical-align:middle\" src=\"html/07_icon_calendar.gif\" /></div>";

		//Show unban button
		$show_delete_button="<img onclick=\"document.getElementById('tr$val').style.backgroundColor='#E4E4D3';document.getElementById('bk$val').checked='true';CheckSelected();\" border=\"0\" src=\"html/07_icon_undo_delete.gif\" style=\"cursor:pointer\" alt=\"$ban_user_tooltip_unban\" title=\"$ban_user_tooltip_unban\" />";
			
		$show_list_table .="<tr id=\"tr$val\" style=\"background-color: #EAEAEA;line-height:20px\">\n";
		$show_list_table .="<td width=\"1%\" align=\"center\" style=\"padding:7px;\" id=\"cell$val\">$show_icon</td>\n";
		$show_list_table .="<td width=\"*\" style=\"padding:4px;\">$show_what</td>\n";
		$show_list_table .="<td width=\"20%\" align=\"center\">$show_length_ban</td>\n";
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
		set_global_var("show_info","<span class=\"OK_Message\">$ban_user_message_mysql_table_quote_updated<br /><br /></span>");	
	}
	else{
		set_global_var("show_info","<span class=\"Error_Message\">$show_info<br /></span>");	
	}

	set_global_var("count_total",$count_list);		
	set_global_var("print_object",get_html_from_layout("admin/html/admin_ban_user.html"));	
	print_admin_header_footer_page();	

	//--------------------------------------------------------------------------------------
	function get_page_count_number($page,$b){
		global $step,$what,$row_number;
			
		$url="index.php?step=$step&row_number=$row_number";
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
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

	if($what=="add_new_bulk"){
		$array_email=split("\n",$email_bulk);
		$array_email=array_unique($array_email);
		$array_email_database=get_dblistvalue("max_black_list","black_email");
		foreach($array_email as $email){
			$email=trim($email);
			if(valid_email($email) && !in_array($email,$array_email_database)){
				$black_key = substr(md5(uniqid(rand(),1)), 0, 20);
				$field_name ="(black_email,black_key,black_active,black_date)";
				$field_value ="('$email','$black_key','1',$gmt_timestamp_now)";
				insert_data_to_db("max_black_list",$field_name,$field_value);
				$view_black_list_message_new_email_added=str_replace("%email%","$email",$view_black_list_message_new_email_added);
				$show_info .="<span class=OK_Message>$view_black_list_message_new_email_added</span><br />\n";
			}
			else{
				$view_black_list_message_email_not_added=str_replace("%email%","$email",$view_black_list_message_email_not_added);
				$show_info .="<span class=Error_Message>$view_black_list_message_email_not_added</span><br />\n";
			}
		}		
	}
	elseif($what=="delete_selected"){
		foreach($http_vars as $key=>$val){
			if(!(strpos($key,"mylist_id")===false)){ //if true
				$selected_id =str_replace("mylist_id","",$key);
				$selected_id =str_replace("_EMAIL_AT_","@",$selected_id);
				$selected_id =str_replace("_EMAIL_DOT_",".",$selected_id);
				//Delete row in database
				delete_row("max_black_list","black_email='$selected_id' LIMIT 1");
			}
		}
	}

	if($row_number =="" || $row_number =="0" || !is_numeric($row_number)) $row_number = 15;
	set_global_var("row_number",$row_number);
	$row_per_page = $row_number;
				
	if ($page < 1 || $page=="") $page =1;
	$start = ($page-1)* 1 * $row_per_page;
	$end = $start + 1 * $row_per_page;

	$list_data =set_array_from_query("max_black_list","*","black_email<>'' Order by black_active DESC,black_email LIMIT $start,$row_per_page");
	$count_list=get_dbvalue("max_black_list","count(black_email)");

	if ($end > $count_list) $end = $count_list;
	$show_list_table="";
	$xrow=0;
	for ($z=$start; $z<$end; $z++) {
		$val = $list_data[$xrow][black_email] ;
		$val=str_replace("@","_EMAIL_AT_",$val);
		$val=str_replace(".","_EMAIL_DOT_",$val);
		$row_data=$list_data[$xrow];

		//Show drop down status
		$show_status ="<select size=\"1\" id=\"black_active$xrow\" onchange=\"ChangeStatus('$row_data[black_email]','$xrow',this.value);\">";

		if($row_data[black_active]=="1"){
			$show_status .="<option value=\"1\" selected=\"selected\">$view_black_list_txt_active</option>";
			$show_status .="<option value=\"0\">$view_black_list_txt_pending</option>";

			//Show icon
			$show_icon ="<img id=\"icon$xrow\" border=\"0\" src=\"html/07_icon_no_email.gif\" alt=\"\" />";

			//Show info
			$show_more_info="<span id=\"moreinfo$xrow\">$view_black_list_txt_active_server_will_not_send_anything</span>";
		}
		else{
			$show_status .="<option value=\"1\">$view_black_list_txt_active</option>";
			$show_status .="<option value=\"0\" selected=\"selected\">$view_black_list_txt_pending</option>";

			//Show icon
			$show_icon ="<img id=\"icon$xrow\" border=\"0\" src=\"html/07_icon_yes_email.gif\" alt=\"\" />";

			//Show info
			$show_more_info="<span id=\"moreinfo$xrow\">$view_black_list_txt_pending_user_still_receive_ecard_and_email</span>";
		}
		$show_status .="</select>";

		//Show email
		$show_email=$row_data[black_email];				

		//Show delete button
		$show_delete_button="<img onclick=\"document.getElementById('tr$val').style.backgroundColor='#E4E4D3';document.getElementById('bk$val').checked='true';CheckSelected();\" border=\"0\" src=\"html/07_icon_delete.gif\" style=\"cursor:pointer\" alt=\"$view_black_list_tooltip_delete\" title=\"$view_black_list_tooltip_delete\" />";
			
		$show_list_table .="<tr id=\"tr$val\" style=\"background-color: #EAEAEA;line-height:20px\">\n";
		$show_list_table .="<td width=\"1%\" align=\"center\" style=\"padding:7px;\" id=\"cell$val\">$show_icon</td>\n";
		$show_list_table .="<td width=\"*\" style=\"padding:4px;\">$show_email</td>\n";
		$show_list_table .="<td width=\"20%\" align=\"center\">$show_more_info</td>\n";
		$show_list_table .="<td width=\"20%\" align=\"center\">$show_status</td>\n";
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
		set_global_var("show_info","<span class=\"OK_Message\">$view_black_list_message_table_black_list_updated<br /><br /></span>");	
	}
	else{
		set_global_var("show_info","<span class=\"Error_Message\">$show_info<br /></span>");	
	}

	set_global_var("count_total",$count_list);		
	set_global_var("print_object",get_html_from_layout("admin/html/admin_view_black_list.html"));	
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
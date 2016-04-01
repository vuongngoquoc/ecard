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
	
	if($action=="add_new"){	
		$field_name ="(poem_title,poem_author,poem_body,poem_active,poem_user_name_id)";
		$field_value ="('$poem_title','$poem_author','$poem_body','1','$_SESSION[user_name_id]')";
		insert_data_to_db("max_poem",$field_name,$field_value);
		$show_info .="<div class=\"OK_Message\">$myalbum_poem_msg_New_poem_Added</div><br />\n";
		$action="";
		set_global_var("action","");
	}	
	elseif($action=="delete_selected"){
		foreach($http_vars as $key=>$val){
			if(!(strpos($key,"mylist_id")===false)){ //if true
				$selected_id =str_replace("mylist_id","",$key);
				
				//Delete row in database
				delete_row("max_poem","poem_id='$selected_id' LIMIT 1");				
			}
		}
		$show_info .="<div class=\"OK_Message\">$myalbum_msg_poem_updated</div><br />\n";
		$action="";
		set_global_var("action","");
	}
	elseif($action=="edit_me"){
		update_field_in_db("max_poem","$edit_key",$edit_key_value,"$edit_id='$edit_id_value' and poem_user_name_id='$_SESSION[user_name_id]' LIMIT 1");		
		exit;
	}

	if($row_number =="" || $row_number =="0" || !is_numeric($row_number)) $row_number = 15;
	$array_global_var_album[row_number]=$row_number;
	$row_per_page = $row_number;

	if ($page < 1 || $page=="") $page =1;
	$start = ($page-1)* 1 * $row_per_page;
	$end = $start + 1 * $row_per_page;
	
	$list_data =set_array_from_query("max_poem","*","poem_user_name_id='$_SESSION[user_name_id]' Order by poem_id LIMIT $start,$row_per_page");
	$count_list=get_dbvalue("max_poem","count(poem_id)","poem_user_name_id='$_SESSION[user_name_id]'");	

	if ($end > $count_list) $end = $count_list;
	$xrow=0;
	if($isResponsive)
	{
			for ($z=$start; $z<$end; $z++) {
			$val = $list_data[$xrow][poem_id] ;
			$row_data=$list_data[$xrow];

			//Show Poem title
			$show_poem_title="<input type=\"text\" value=\"$row_data[poem_title]\" id=\"poem_title$val\" name=\"change_bkg\" title=\"$txt_tooltip_click_to_edit\" class=\"input_ajax_editable h-space-b-10\" onfocus=\"original_value=this.value;\" onchange=\"Editme('$ecard_url/index.php?step=$step&next_step=$next_step&what=$what&action=edit_me&edit_id=poem_id&edit_id_value=$val&edit_key=poem_title&edit_key_value=',this.value,'1',original_value,this.id);\" />";
			
			//Poem author
			$show_poem_title.="<input type=\"text\" value=\"$row_data[poem_author]\" id=\"poem_author$val\" name=\"change_bkg\" title=\"$txt_tooltip_click_to_edit\" class=\"input_ajax_editable h-space-b-10\" onfocus=\"original_value=this.value;\" onchange=\"Editme('$ecard_url/index.php?step=$step&next_step=$next_step&what=$what&action=edit_me&edit_id=poem_id&edit_id_value=$val&edit_key=poem_author&edit_key_value=',this.value,'1',original_value,this.id);\" />";

			//Poem body
			$row_data[poem_body]=str_replace("<br>","\n",$row_data[poem_body]);
			$row_data[poem_body]=str_replace("<br />","\n",$row_data[poem_body]);
			$show_poem_title.="<textarea  id=\"poem_body$val\" name=\"change_bkg\" title=\"$txt_tooltip_click_to_edit\" class=\"input_ajax_editable\" onfocus=\"original_value=this.value;this.style.height='300px';\" onblur=\"this.style.height='70px';\" onchange=\"Editme('$ecard_url/index.php?step=$step&next_step=$next_step&what=$what&action=edit_me&edit_id=poem_id&edit_id_value=$val&edit_key=poem_body&edit_key_value=',this.value,'1',original_value,this.id);\" >$row_data[poem_body]</textarea>";
			

			//Show delete button
			$show_delete_button="<span class='btn btn-xs btn-default' title='$reminder_txt_event_delete' onclick=\"document.getElementById('bk$val').checked='true';single_check_uncheck('tr$val','bk$val');CheckSelected();\" ><i class='fa fa-remove'></i></span>";
			
			$show_list_table .="<tr id=\"tr$val\" class=\"table_td_background\">\n";
			$show_list_table .="<td width=\"50%\" style=\"padding:4px;vertical-align:top\">$show_poem_title</td>\n";
			$show_list_table .="<td width=\"1%\" align=\"center\" style=\"padding:4px;vertical-align:top\">$show_delete_button</td>\n";
			$show_list_table .="<td width=\"1%\" align=\"center\" style=\"padding:4px;vertical-align:top\"><input class=\"input_ajax_editable\" onclick=\"single_check_uncheck('tr$val','bk$val');\" type=\"checkbox\" id=\"bk$val\" name=\"mylist_id$val\" value=\"$val\" /></td>\n";
			$show_list_table .="</tr>\n";
			$bk_id .="$val,";
			$xrow++;
		}
	}
	else
	{
		for ($z=$start; $z<$end; $z++) {
			$val = $list_data[$xrow][poem_id] ;
			$row_data=$list_data[$xrow];

			//Show Poem title
			$show_poem_title="<input style=\"width:500px;font-weight:bold;font-size:11pt\" type=\"text\" value=\"$row_data[poem_title]\" id=\"poem_title$val\" name=\"change_bkg\" title=\"$txt_tooltip_click_to_edit\" class=\"input_ajax_editable\" onfocus=\"original_value=this.value;if(document.getElementById('tr$val').className=='table_td_background'){this.className='input_ajax_editable_focus';}else{this.className='input_when_select_all_checkbox_checked';this.style.cursor='text';}\" onblur=\"if(document.getElementById('tr$val').className=='table_td_background'){this.className='input_ajax_editable';}else{this.className='input_when_select_all_checkbox_checked';this.style.cursor='pointer';}\" onchange=\"Editme('$ecard_url/index.php?step=$step&next_step=$next_step&what=$what&action=edit_me&edit_id=poem_id&edit_id_value=$val&edit_key=poem_title&edit_key_value=',this.value,'1',original_value,this.id);\" />";
			
			//Poem author
			$show_poem_title.="<br /><input style=\"width:500px;font-size:8pt\" type=\"text\" value=\"$row_data[poem_author]\" id=\"poem_author$val\" name=\"change_bkg\" title=\"$txt_tooltip_click_to_edit\" class=\"input_ajax_editable\" onfocus=\"original_value=this.value;if(document.getElementById('tr$val').className=='table_td_background'){this.className='input_ajax_editable_focus';}else{this.className='input_when_select_all_checkbox_checked';this.style.cursor='text';}\" onblur=\"if(document.getElementById('tr$val').className=='table_td_background'){this.className='input_ajax_editable';}else{this.className='input_when_select_all_checkbox_checked';this.style.cursor='pointer';}\" onchange=\"Editme('$ecard_url/index.php?step=$step&next_step=$next_step&what=$what&action=edit_me&edit_id=poem_id&edit_id_value=$val&edit_key=poem_author&edit_key_value=',this.value,'1',original_value,this.id);\" />";

			//Poem body
			$row_data[poem_body]=str_replace("<br>","\n",$row_data[poem_body]);
			$row_data[poem_body]=str_replace("<br />","\n",$row_data[poem_body]);
			$show_poem_title.="<br /><textarea style=\"width:500px;height:70px\" id=\"poem_body$val\" name=\"change_bkg\" title=\"$txt_tooltip_click_to_edit\" class=\"input_ajax_editable\" onfocus=\"original_value=this.value;this.style.height='300px';if(document.getElementById('tr$val').className=='table_td_background'){this.className='input_ajax_editable_focus';}else{this.className='input_when_select_all_checkbox_checked';this.style.cursor='text';}\" onblur=\"this.style.height='70px';if(document.getElementById('tr$val').className=='table_td_background'){this.className='input_ajax_editable';}else{this.className='input_when_select_all_checkbox_checked';this.style.cursor='pointer';}\" onchange=\"Editme('$ecard_url/index.php?step=$step&next_step=$next_step&what=$what&action=edit_me&edit_id=poem_id&edit_id_value=$val&edit_key=poem_body&edit_key_value=',this.value,'1',original_value,this.id);\" >$row_data[poem_body]</textarea>";
			

			//Show delete button
			$show_delete_button="<img onclick=\"document.getElementById('bk$val').checked='true';single_check_uncheck('tr$val','bk$val');CheckSelected();\" border=\"0\" src=\"$ecard_url/templates/$cf_set_template/icon_delete.gif\" style=\"cursor:pointer\" alt=\"$reminder_txt_event_delete\" title=\"$reminder_txt_event_delete\" />";

			$show_list_table .="<tr id=\"tr$val\" class=\"table_td_background\">\n";
			$show_list_table .="<td width=\"50%\" style=\"padding:4px;vertical-align:top\">$show_poem_title</td>\n";
			$show_list_table .="<td width=\"1%\" align=\"center\" style=\"padding:4px;vertical-align:top\">$show_delete_button</td>\n";
			$show_list_table .="<td width=\"1%\" align=\"center\" style=\"padding:4px;vertical-align:top\"><input class=\"input_ajax_editable\" onclick=\"single_check_uncheck('tr$val','bk$val');\" type=\"checkbox\" id=\"bk$val\" name=\"mylist_id$val\" value=\"$val\" /></td>\n";
			$show_list_table .="</tr>\n";
			$bk_id .="$val,";
			$xrow++;
		}
	}
	if($bk_id{strlen($bk_id)-1} ==",") $bk_id = substr($bk_id, 0, strlen($bk_id)-1);

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
			
			$display_page_number .="<br clear=\"all\" /><ul id=paging class='pagination'>";
			$display_page_number .="      <li>{A}</li>";
			$display_page_number .="      <li>{NUMBER}</li>";
			$display_page_number .="      <li>{B}</li>";
			$display_page_number .="</ul>";
			
			$count_number =get_page_count_number2($page,$b);
			$display_page_number = str_replace("{NUMBER}", $count_number, $display_page_number);
			
			if ($page > 1) {
				$page_pr = $page - 1 ;				
				$dpn ="<a href=\"$ecard_url/index.php?step=$step&next_step=$next_step&what=poem&row_number=$row_number&page=$page_pr\">&laquo;</a>";
				$display_page_number = str_replace("{A}", $dpn, $display_page_number);
			}
			else{
				$display_page_number = str_replace("{A}", "&laquo;", $display_page_number);
			}
			$y=get_global_var("d_num");
			if ($page < $y) {
				$page_ne = $page + 1 ;				
				$display_page_number = str_replace("{B}", "<a href=\"$ecard_url/index.php?step=$step&next_step=$next_step&what=poem&row_number=$row_number&page=$page_ne\">&raquo;</a>", $display_page_number);
			}	
			else{
				$display_page_number = str_replace("{B}", "&raquo;", $display_page_number);
			}
		}
	}

	//Display random banner HR & VT
	print_banner("0");
	print_banner("1");	
	
	//Count total photo
	$total_count=get_dbvalue("max_poem","count(poem_id)","poem_user_name_id='$_SESSION[user_name_id]'");

	//Display buttons 
	if($cf_member_can_upload_image=="1"){
		$button_myalbum_photo="<a href=\"$ecard_url/index.php?step=$step&next_step=$next_step&what=photo\" class=\"button_link_style1\"><img border=\"0\" alt=\"\" src=\"$ecard_url/templates/$cf_set_template/icon_member_upload_photo.gif\" style=\"vertical-align:middle\" /> $myalbum_button_goto_photo</a>";
	}
	if($cf_member_can_upload_music=="1"){
		$button_myalbum_music="<a href=\"$ecard_url/index.php?step=$step&next_step=$next_step&what=music\" class=\"button_link_style1\"><img border=\"0\" alt=\"\" src=\"$ecard_url/templates/$cf_set_template/icon_member_upload_audio.gif\" style=\"vertical-align:middle\" /> $myalbum_button_goto_music</a>";
	}
	if($cf_option_select_poem=="1"){
		$button_myalbum_poem="<a href=\"$ecard_url/index.php?step=$step&next_step=$next_step&what=poem\" class=\"button_link_style1\"><img border=\"0\" alt=\"\" src=\"$ecard_url/templates/$cf_set_template/icon_member_upload_poem.gif\" style=\"vertical-align:middle\" /> $myalbum_button_goto_poem</a>";
	}
	if($cf_member_can_upload_stamp=="1"){
		$button_myalbum_stamp="<a href=\"$ecard_url/index.php?step=$step&next_step=$next_step&what=stamp\" class=\"button_link_style1\"><img border=\"0\" alt=\"\" src=\"$ecard_url/templates/$cf_set_template/icon_member_upload_stamp.gif\" style=\"vertical-align:middle\" /> $myalbum_button_goto_stamp</a>";
	}
	if($cf_member_can_upload_font=="1"){
		$button_myalbum_font="<a href=\"$ecard_url/index.php?step=$step&next_step=$next_step&what=font\" class=\"button_link_style1\"><img border=\"0\" alt=\"\" src=\"$ecard_url/templates/$cf_set_template/icon_member_upload_font.gif\" style=\"vertical-align:middle\" /> $myalbum_button_goto_font</a>";
	}

	$array_global_var[print_object]=get_html_from_layout("templates/$cf_set_template/show_myalbum_poem.html");
	print_header_and_footer();
	
	//--------------------------------------------------------------------------------------
	function get_page_count_number2($page,$b){
		global $step,$next_step,$row_number,$ecard_url;
			
		$url="$ecard_url/index.php?step=$step&next_step=$next_step&what=poem&row_number=$row_number";
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
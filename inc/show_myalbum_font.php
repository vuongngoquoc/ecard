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
		//Upload file
		$upload_dir ="$ecard_root/resource/invitation_fonts/user_font";
		$number_file = 0;
		for($i=1;$i<=7;$i++){
			$file_key="file$i";
			$rand_id = "user".$_SESSION[user_id].substr(md5(uniqid(rand(),1)), 0, 8);
			
			$file_name = $POST_FILES[$file_key]['name'];
			$font_filename=str_replace(".ttf","",$POST_FILES[$file_key]['name']);
			$file_upload_size = $POST_FILES[$file_key]['size'];
			if($file_upload_size > 0){
				$count_user_font++;
				$ext="";
				$show_info="";
				$file_name =strtolower($file_name);
				if(substr($file_name, strlen($file_name)-4, strlen($file_name))==".ttf")$ext =".ttf";
				$file_upload_name = "$ecard_root/resource/invitation_fonts/user_font/$rand_id$file_name";
				
				if($ext!=".ttf")
					$show_info .="<div class=\"Error_Message\">$myalbum_font_error_msg_font_Type</div><br />\n";

				$count_user_font=get_dbvalue("max_user_font","count(font_id)","font_user_name_id='$_SESSION[user_name_id]'");

				if($cf_user_max_font_upload > 0 && $count_user_font>= $cf_user_max_font_upload)
					$show_info .="<div class=\"Error_Message\">$myalbum_font_error_msg_overlimit_upload_font</div><br />\n";

				if($show_info==""){					
					//Upload and Add files to database
					if(move_uploaded_file($POST_FILES[$file_key]['tmp_name'],$file_upload_name)){
						$number_file++;
						chmod($file_upload_name,0777);						

						$field_name ="(font_name,font_filename,font_user_name_id)";
						$field_value ="('$font_filename','$rand_id$file_name','$_SESSION[user_name_id]')";
						insert_data_to_db("max_user_font",$field_name,$field_value);		
					}
				}
			}
		}
		if($number_file>0)$show_info .="<div class=\"OK_Message\">$myalbum_font_msg_New_font_Added ($number_file)</div><br />\n";

		$action="";
		set_global_var("action","");
	}	
	elseif($action=="delete_selected"){
		foreach($http_vars as $key=>$val){
			if(!(strpos($key,"mylist_id")===false)){ //if true
				$selected_id =str_replace("mylist_id","",$key);
				
				//Delete font file
				$row=get_row("max_user_font","*","font_id='$selected_id'");
				if(is_writable("$ecard_root/resource/invitation_fonts/user_font/$row[font_filename]")){
					@unlink("$ecard_root/resource/invitation_fonts/user_font/$row[font_filename]");

					//Delete row in database
					delete_row("max_user_font","font_id='$selected_id' LIMIT 1");
				}
			}
		}
		$show_info .="<div class=\"OK_Message\">$myalbum_msg_font_updated</div><br />\n";
		$action="";
		set_global_var("action","");
	}
	elseif($action=="edit_me"){
		update_field_in_db("max_user_font","$edit_key",$edit_key_value,"$edit_id='$edit_id_value' and font_user_name_id='$_SESSION[user_name_id]' LIMIT 1");		
		exit;
	}
	elseif($action=="show_user_font"){
		if(file_exists("$ecard_root/inc/pngmaker.php")){
			require_once ("$ecard_root/inc/pngmaker.php");
			$IMAGE_WIDTH = 250;
			$TEXT_ALIGN ="center";
			$LINE_HEIGHT = 20;
			$FONT_SIZE = 20;
			$TEXT ="\n$font_name\n";
			$FONT_NAME = "$ecard_root/resource/invitation_fonts/user_font/$font_filename";			
			$BACKGORUND_COLOR="255,255,255"; //White
			$TEXT_COLOR="0,0,0"; //Black
			make_png($IMAGE_WIDTH,$TEXT_ALIGN,$TEXT,$LINE_HEIGHT,$FONT_SIZE,$FONT_NAME,$BACKGORUND_COLOR,$TEXT_COLOR);
		}
		exit;
	}

	if($row_number =="" || $row_number =="0" || !is_numeric($row_number)) $row_number = 15;
	$array_global_var_reminder[row_number]=$row_number;
	$row_per_page = $row_number;

	if ($page < 1 || $page=="") $page =1;
	$start = ($page-1)* 1 * $row_per_page;
	$end = $start + 1 * $row_per_page;
	
	$list_data =set_array_from_query("max_user_font","*","font_user_name_id='$_SESSION[user_name_id]' Order by font_id LIMIT $start,$row_per_page");
	$count_list=get_dbvalue("max_user_font","count(font_id)","font_user_name_id='$_SESSION[user_name_id]'");	

	if ($end > $count_list) $end = $count_list;
	$xrow=0;	
	if($isResponsive)
	{
		for ($z=$start; $z<$end; $z++) {
			$val = $list_data[$xrow][font_id] ;
			$row_data=$list_data[$xrow];

			//Show font name
			$show_font_title="<input type=\"text\" value=\"$row_data[font_name]\" id=\"font_name$val\" name=\"change_bkg\" title=\"$txt_tooltip_click_to_edit\" class=\"input_ajax_editable\" onfocus=\"original_value=this.value;\" onchange=\"Editme('$ecard_url/index.php?step=$step&next_step=$next_step&what=$what&action=edit_me&edit_id=font_id&edit_id_value=$val&edit_key=font_name&edit_key_value=',this.value,'1',original_value,this.id);\" />";

			//Show font image sample
			$show_font_sample="<img border=\"1\" alt=\"\" src=\"$ecard_url/index.php?step=$step&next_step=$next_step&what=$what&action=show_user_font&font_filename=$row_data[font_filename]&font_name=$row_data[font_name]\" />";

			//Show delete button
			$show_delete_button="<span class='btn btn-xs btn-default' title='$reminder_txt_event_delete' onclick=\"document.getElementById('bk$val').checked='true';single_check_uncheck('tr$val','bk$val');CheckSelected();\" ><i class='fa fa-remove'></i></span>";

			$show_list_table .="<tr id=\"tr$val\" class=\"table_td_background\">\n";
			$show_list_table .="<td width=\"*\" style=\"padding:4px;\">$show_font_title</td>\n";
			$show_list_table .="<td width=\"*\" style=\"padding:4px;white-space:nowrap\">$show_font_sample</td>\n";
			$show_list_table .="<td width=\"1%\" align=\"center\" style=\"padding:4px;\">$show_delete_button</td>\n";
			$show_list_table .="<td width=\"1%\" align=\"center\" style=\"padding:4px;\"><input class=\"input_ajax_editable\" onclick=\"single_check_uncheck('tr$val','bk$val');\" type=\"checkbox\" id=\"bk$val\" name=\"mylist_id$val\" value=\"$val\" /></td>\n";
			$show_list_table .="</tr>\n";
			$bk_id .="$val,";
			$xrow++;
		}
	}
	else
	{
		for ($z=$start; $z<$end; $z++) {
			$val = $list_data[$xrow][font_id] ;
			$row_data=$list_data[$xrow];

			//Show font name
			$show_font_title="<input style=\"width:200px\" type=\"text\" value=\"$row_data[font_name]\" id=\"font_name$val\" name=\"change_bkg\" title=\"$txt_tooltip_click_to_edit\" class=\"input_ajax_editable\" onfocus=\"original_value=this.value;if(document.getElementById('tr$val').className=='table_td_background'){this.className='input_ajax_editable_focus';}else{this.className='input_when_select_all_checkbox_checked';this.style.cursor='text';}\" onblur=\"if(document.getElementById('tr$val').className=='table_td_background'){this.className='input_ajax_editable';}else{this.className='input_when_select_all_checkbox_checked';this.style.cursor='pointer';}\" onchange=\"Editme('$ecard_url/index.php?step=$step&next_step=$next_step&what=$what&action=edit_me&edit_id=font_id&edit_id_value=$val&edit_key=font_name&edit_key_value=',this.value,'1',original_value,this.id);\" />";

			//Show font image sample
			$show_font_sample="<img border=\"1\" alt=\"\" src=\"$ecard_url/index.php?step=$step&next_step=$next_step&what=$what&action=show_user_font&font_filename=$row_data[font_filename]&font_name=$row_data[font_name]\" />";

			//Show delete button
			$show_delete_button="<img onclick=\"document.getElementById('bk$val').checked='true';single_check_uncheck('tr$val','bk$val');CheckSelected();\" border=\"0\" src=\"$ecard_url/templates/$cf_set_template/icon_delete.gif\" style=\"cursor:pointer\" alt=\"$reminder_txt_event_delete\" title=\"$reminder_txt_event_delete\" />";

			$show_list_table .="<tr id=\"tr$val\" class=\"table_td_background\">\n";
			$show_list_table .="<td width=\"*\" style=\"padding:4px;\">$show_font_title</td>\n";
			$show_list_table .="<td width=\"*\" style=\"padding:4px;white-space:nowrap\">$show_font_sample</td>\n";
			$show_list_table .="<td width=\"1%\" align=\"center\" style=\"padding:4px;\">$show_delete_button</td>\n";
			$show_list_table .="<td width=\"1%\" align=\"center\" style=\"padding:4px;\"><input class=\"input_ajax_editable\" onclick=\"single_check_uncheck('tr$val','bk$val');\" type=\"checkbox\" id=\"bk$val\" name=\"mylist_id$val\" value=\"$val\" /></td>\n";
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
				$dpn ="<a href=\"$ecard_url/index.php?step=$step&next_step=$next_step&what=font&row_number=$row_number&page=$page_pr\">&laquo;</a>";
				$display_page_number = str_replace("{A}", $dpn, $display_page_number);
			}
			else{
				$display_page_number = str_replace("{A}", "&laquo;", $display_page_number);
			}
			$y=get_global_var("d_num");
			if ($page < $y) {
				$page_ne = $page + 1 ;				
				$display_page_number = str_replace("{B}", "<a href=\"$ecard_url/index.php?step=$step&next_step=$next_step&what=font&row_number=$row_number&page=$page_ne\">&raquo;</a>", $display_page_number);
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
	$total_count=get_dbvalue("max_user_font","count(font_id)","font_user_name_id='$_SESSION[user_name_id]'");

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
	
	$show_onload_javascript="onkeypress=\"return noGlobalEnterKey(event)\"";
	$array_global_var[print_object]=get_html_from_layout("templates/$cf_set_template/show_myalbum_font.html");
	print_header_and_footer();
	
	//--------------------------------------------------------------------------------------
	function get_page_count_number2($page,$b){
		global $step,$next_step,$row_number,$ecard_url;
			
		$url="$ecard_url/index.php?step=$step&next_step=$next_step&what=font&row_number=$row_number";
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
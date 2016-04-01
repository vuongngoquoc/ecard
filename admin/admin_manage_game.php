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

	//Update new language database
	$list_lang_file=get_list_file("$ecard_root/languages","_lang.php$");
	make_db_connect();
	foreach($list_lang_file as $val){
		$val = str_replace(".php","",$val);
		$game_title_val = "game_title_" . $val;
		$game_intro_message_val = "game_intro_message_" . $val;		

		$query = mysql_query("SHOW COLUMNS FROM max_game LIKE '$game_title_val'") or die(mysql_error()); 
		if (mysql_num_rows($query) == 0) {     
			$sql = "ALTER TABLE `max_game` ADD `$game_title_val` VARCHAR( 255 ) NOT NULL" ;
			mysql_query($sql);
		}

		$query = mysql_query("SHOW COLUMNS FROM max_game LIKE '$game_intro_message_val'") or die(mysql_error()); 
		if (mysql_num_rows($query) == 0) {     
			$sql = "ALTER TABLE `max_game` ADD `$game_intro_message_val` VARCHAR( 255 ) NOT NULL" ;
			mysql_query($sql);
		}		
	}

	if($what=="add_new"){
		$game_order=get_dbvalue("max_game","count(game_id)")+1;
		$field_name ="(game_title,game_intro_message,game_open_popup,game_popup_width,game_popup_height,game_url,game_thumb_url,game_active,game_add_time,game_order)";
		$field_value ="('$game_title','$game_intro_message',$game_open_popup,'$game_popup_width','$game_popup_height','$game_url','$game_thumb_url',$game_active,$gmt_timestamp_now,$game_order)";		
		insert_data_to_db("max_game",$field_name,$field_value);		
		$show_info="<span class=\"OK_Message\">$games_message_new_game_has_been_added</span><br />";
	}
	elseif($what=="delete_selected"){
		foreach($http_vars as $key=>$val){
			if(!(strpos($key,"mylist_id")===false)){ //if true
				$selected_id =str_replace("mylist_id","",$key);

				//Delete row in database
				delete_row("max_game","game_id='$selected_id' LIMIT 1");
			}
		}
		RefreshSortOrder();
	}
	elseif($what=="set_sort_order"){
		$list_sort=set_array_from_query("max_game","game_id,game_order","game_id<>'' Order by game_order,game_title");		
		foreach($list_sort as $array_sort){
			if($current_sort > $sort_number){
				if($array_sort[game_order]>=$sort_number){			
					update_field_in_db("max_game","game_order",$array_sort[game_order]+1,"game_id='$array_sort[game_id]' LIMIT 1");
				}
			}
			else{
				if($array_sort[game_order]<=$sort_number){			
					update_field_in_db("max_game","game_order",$array_sort[game_order]-1,"game_id='$array_sort[game_id]' LIMIT 1");
				}
			}
		}		
		update_field_in_db("max_game","game_order",$sort_number,"game_id='$game_id' LIMIT 1");
		
		RefreshSortOrder();
		$what="";
		set_global_var("what","");
	}

	if($row_number =="" || $row_number =="0" || !is_numeric($row_number)) $row_number = 15;
	set_global_var("row_number",$row_number);
	$row_per_page = $row_number;
				
	if ($page < 1 || $page=="") $page =1;
	$start = ($page-1)* 1 * $row_per_page;
	$end = $start + 1 * $row_per_page;

	$list_data =set_array_from_query("max_game","*","game_id<>'' Order by game_order,game_title LIMIT $start,$row_per_page");
	$count_list=get_dbvalue("max_game","count(game_id)");

	if ($end > $count_list) $end = $count_list;
	$show_list_table="";
	$xrow=0;
	for ($z=$start; $z<$end; $z++) {
		$val = $list_data[$xrow][game_id] ;
		$row_data=$list_data[$xrow];

		//Show sort order dropdown menu
		$show_sort="<select size=\"1\" name=\"game_order$val\" id=\"game_order$val\" onchange=\"location.href='index.php?step=$step&what=set_sort_order&game_id=$val&current_sort=$row_data[game_order]&sort_number='+this.value;\">";
		for($i=1;$i<=$count_list;$i++){
			if($row_data[game_order]==$i){
				$show_sort.="<option value=\"$i\" selected=\"selected\">$i</option>\n";
			}
			else{
				$show_sort.="<option value=\"$i\" >$i</option>\n";
			}
		}
		$show_sort.="</select>";

		//Show thumbnail
		$show_thumbnail ="<img border=\"1\" id=game_thumb_url$val src=\"$row_data[game_thumb_url]\" alt=\"\" /><br /><br /><span class=\"button\" style=\"padding:3px;cursor:pointer;\" onclick=\"HideItAll();HighLightCell('$val');ShowDivCenterPage('popup_title$val');\" >$games_txt_translate_game_title</span><br /><br /><span class=\"button\" style=\"padding:3px;cursor:pointer;\" onclick=\"HideItAll();HighLightCell('$val');ShowDivCenterPage('popup_info$val');\" >$games_txt_translate_game_info</span>";

		//Show title
		$show_title="<input onkeypress=\"return noEnterKey(event);\" id=\"game_title$val\" title=\"$games_tooltip_click_here_to_edit\" type=\"text\" value=\"$row_data[game_title]\" style=\"border:0px;background-color:#EAEAEA;cursor:pointer;width:320px;text-decoration:underline;font-weight:bold;font-size:14px;\" onfocus=\"original_value=this.value;this.style.border='1px solid silver';this.style.textDecoration='none';this.style.cursor='text';\" onblur=\"this.style.border='0px';this.style.textDecoration='underline';this.style.cursor='pointer';\" onchange=\"Editme('index.php?step=edit_me&table=max_game&edit_id=game_id&edit_id_value=$val&edit_key=game_title&edit_value=',this.value,'1',original_value,this.id);\" /><br /><br /><textarea id=\"game_intro_message$val\" title=\"$games_tooltip_click_here_to_edit\" style=\"border:0px;background-color:#EAEAEA;cursor:pointer;width:320px;height:70px;\" onfocus=\"original_value=this.value;this.style.border='1px solid silver';this.style.cursor='text';this.style.height='150px';\" onblur=\"this.style.border='0px';this.style.cursor='pointer';this.style.height='70px';\" onchange=\"Editme('index.php?step=edit_me&table=max_game&edit_id=game_id&edit_id_value=$val&edit_key=game_intro_message&edit_value=',this.value,'1',original_value,this.id);\" >$row_data[game_intro_message]</textarea><br /><br />";

		//Show Game URL
		$show_game_url="$games_txt_edit_game_url:<br /><input onkeypress=\"return noEnterKey(event);\" id=\"game_url$val\" title=\"$games_tooltip_click_here_to_edit\" type=\"text\" value=\"$row_data[game_url]\" style=\"border:0px;background-color:#EAEAEA;cursor:pointer;width:320px;text-decoration:underline;font-size:8pt;color:green\" onfocus=\"original_value=this.value;this.style.border='1px solid silver';this.style.textDecoration='none';this.style.cursor='text';\" onblur=\"this.style.border='0px';this.style.textDecoration='underline';this.style.cursor='pointer';\" onchange=\"Editme('index.php?step=edit_me&table=max_game&edit_id=game_id&edit_id_value=$val&edit_key=game_url&edit_value=',this.value,'1',original_value,this.id);\" /><br /><br />";

		//Show Game thumbnail URL
		$show_game_thumb_url="$games_txt_edit_thumbnail_url:<br /><input onkeypress=\"return noEnterKey(event);\" id=\"game_thumb_url$val\" title=\"$games_tooltip_click_here_to_edit\" type=\"text\" value=\"$row_data[game_thumb_url]\" style=\"border:0px;background-color:#EAEAEA;cursor:pointer;width:320px;text-decoration:underline;font-size:8pt;color:green\" onfocus=\"original_value=this.value;this.style.border='1px solid silver';this.style.textDecoration='none';this.style.cursor='text';\" onblur=\"this.style.border='0px';this.style.textDecoration='underline';this.style.cursor='pointer';\" onchange=\"document.getElementById('game_thumb_url$val').src=this.value;Editme('index.php?step=edit_me&table=max_game&edit_id=game_id&edit_id_value=$val&edit_key=game_thumb_url&edit_value=',this.value,'1',original_value,this.id);\" /><br /><br />";

		//Show open game in window type
		if($row_data[game_open_popup]=="1"){
			$winchecked_it ="selected=\"selected\"";
			$show_hide_it="style=\"display:block\"";
		}
		else{
			$show_hide_it="style=\"display:none\"";
			$winchecked_it ="";
		}
		$show_open_window_type="<select name=\"game_open_popup$val\" id=\"game_open_popup$val\" size=\"1\" onchange=\"showid('setwindowtable$val');Editme('index.php?step=edit_me&table=max_game&edit_id=game_id&edit_id_value=$val&edit_key=game_open_popup&edit_value=',this.value,'1',1,this.id);\" ><option value=\"0\">$games_txt_same_window</option><option $winchecked_it value=\"1\">$games_txt_popup_window</option></select><div id=\"setwindowtable$val\" $show_hide_it><br />$games_txt_window_width (px): <input type=\"text\" name=\"game_popup_width$val\" id=\"game_popup_width$val\" value=\"$row_data[game_popup_width]\" onkeypress=\"return isNumberKey(event)\" onfocus=\"original_value=this.value;\" onchange=\"Editme('index.php?step=edit_me&table=max_game&edit_id=game_id&edit_id_value=$val&edit_key=game_popup_width&edit_value=',this.value,'2',original_value,this.id);\" maxlength=\"4\" size=\"15\" /><br /><br />$games_txt_window_height (px): <input type=\"text\" name=\"game_popup_height$val\" id=\"game_popup_height$val\" value=\"$row_data[game_popup_height]\" onkeypress=\"return isNumberKey(event)\" onfocus=\"original_value=this.value;\" onchange=\"Editme('index.php?step=edit_me&table=max_game&edit_id=game_id&edit_id_value=$val&edit_key=game_popup_height&edit_value=',this.value,'2',original_value,this.id);\" maxlength=\"4\" size=\"15\" /></div>";
						
		//Show on/off checkbox
		if($row_data[game_active]=="1"){
			$checked_it ="checked=\"checked\"";
		}
		else{
			$checked_it ="";
		}

		//Translate game title
		$div_game_title="<div id=\"popup_title$val\" style=\"display:none;position:absolute;top:0;left:0;z-index:9;width:600px;\"><div style=\"border:thick solid #FCAA03;\"><table border=\"0\" width=\"100%\" cellspacing=\"1\" cellpadding=\"4\" style=\"background-color:silver\"><tr style=\"background-color: #B1D3FF;background-image: url(html/07_title_background.gif);line-height:17px;font-weight:bold\"><td colspan=\"2\" style=\"cursor:pointer;\" onclick=\"HideItAll();\"><div style=\"float:left\">$games_txt_translate_game_title_into_other_language</div><img border=\"0\" src=\"html/07_icon_button_close.gif\" title=\"$games_tooltip_close_hide\" alt=\"$games_tooltip_close_hide\" style=\"vertical-align:middile;float:right;\" /></td></tr>";
		$div_game_info="<div id=\"popup_info$val\" style=\"display:none;position:absolute;top:0;left:0;z-index:9;width:600px;\"><div style=\"border:thick solid #FCAA03;\"><table border=\"0\" width=\"100%\" cellspacing=\"1\" cellpadding=\"4\" style=\"background-color:silver\"><tr style=\"background-color: #B1D3FF;background-image: url(html/07_title_background.gif);line-height:17px;font-weight:bold\"><td colspan=\"2\" style=\"cursor:pointer;\" onclick=\"HideItAll();\"><div style=\"float:left\">$games_txt_translate_game_into_other_languages</div><img border=\"0\" src=\"html/07_icon_button_close.gif\" title=\"$games_tooltip_close_hide\" alt=\"$games_tooltip_close_hide\" style=\"vertical-align:middile;float:right;\" /></td></tr>";
			$show_list_language_table="";
			$show_list_language_table2="";
			foreach($list_lang_file as $mylang){
				$title_lang_name="game_title_".str_replace(".php","",$mylang);
				$title_lang_name_value=$row_data[$title_lang_name];
				if($cf_language==$mylang && $title_lang_name_value==""){
					$title_lang_name_value=$row_data[game_title];
				}

				$games_txt_translate_into_current_languages=str_replace("%current_language%",ucwords(str_replace("_lang.php","",$mylang)),$games_txt_translate_into_current_languages);
				$mylang_name=$games_txt_translate_into_current_languages;
				$show_list_language_table.="<tr style=\"background-color: #EAEAEA;line-height:17px\">\n";
				$show_list_language_table.="<td style=\"white-space:nowrap\">$mylang_name</td>\n";
				$show_list_language_table.="<td ><input type=\"text\" name=\"$title_lang_name$val\" id=\"$title_lang_name$val\" value=\"$title_lang_name_value\" style=\"width:400px\" onfocus=\"original_value=this.value;\" onchange=\"Editme('index.php?step=edit_me&lang=$mylang&table=max_game&edit_id=game_id&edit_id_value=$val&edit_key=$title_lang_name&edit_value=',this.value,'0',original_value,this.id);\" /></td>\n";
				$show_list_language_table.="</tr>\n";

				$info_lang_name="game_intro_message_".str_replace(".php","",$mylang);
				$info_lang_name_value=$row_data[$info_lang_name];
				if($cf_language==$mylang && $info_lang_name_value==""){
					$info_lang_name_value=$row_data[game_intro_message];
				}

				$show_list_language_table2.="<tr style=\"background-color: #EAEAEA;line-height:17px\">\n";
				$show_list_language_table2.="<td style=\"white-space:nowrap\">$mylang_name</td>\n";
				$show_list_language_table2.="<td ><textarea style=\"width:400px;height:50px;\" name=\"$info_lang_name$val\" id=\"$info_lang_name$val\" onfocus=\"original_value=this.value;\" onchange=\"Editme('index.php?step=edit_me&lang=$mylang&table=max_game&edit_id=game_id&edit_id_value=$val&edit_key=$info_lang_name&edit_value=',this.value,'0',original_value,this.id);\" />$info_lang_name_value</textarea></td>\n";
				$show_list_language_table2.="</tr>\n";
			}

		$div_game_title.="$show_list_language_table</table></div></div>";
		$div_game_info.="$show_list_language_table2</table></div></div>";

		//Show delete button
		$show_delete_button="<img onclick=\"document.getElementById('tr$val').style.backgroundColor='#E4E4D3';document.getElementById('bk$val').checked='true';CheckSelected();\" border=\"0\" src=\"html/07_icon_delete.gif\" style=\"cursor:pointer\" alt=\"$games_tooltip_delete\" title=\"$games_tooltip_delete\" />";
			
		$show_list_table .="<tr id=\"tr$val\" style=\"background-color: #EAEAEA;line-height:20px\">\n";
		$show_list_table .="<td width=\"1%\" align=\"center\" valign=\"top\" id=\"cell$val\" style=\"padding:7px\">$show_thumbnail$div_game_title$div_game_info</td>\n";
		$show_list_table .="<td width=\"*\" valign=\"top\"  style=\"padding:7px\">$show_title$show_game_url$show_game_thumb_url</td>\n";
		$show_list_table .="<td width=\"*\" valign=\"top\" align=\"center\" style=\"padding:4px;\">$show_open_window_type</td>\n";
		$show_list_table .="<td width=\"12%\" valign=\"top\" align=\"center\"><input $checked_it type=\"checkbox\" value=\"1\" onclick=\"ShowLoaderImage('$games_message_updating');if(this.checked){UpdateDataTable('index.php?step=edit_me&table=max_game&edit_id=game_id&edit_id_value=$val&edit_key=game_active&edit_value=1');}else{UpdateDataTable('index.php?step=edit_me&table=max_game&edit_id=game_id&edit_id_value=$val&edit_key=game_active&edit_value=0');}\" /></td>\n";		
		$show_list_table .="<td width=\"1%\" valign=\"top\" align=\"center\" style=\"padding:4px;\">$show_sort</td>\n";
		$show_list_table .="<td width=\"1%\" valign=\"top\" align=\"center\">$show_delete_button</td>\n";
		$show_list_table .="<td width=\"1%\" valign=\"top\" align=\"center\"><input onclick=\"if(this.checked){document.getElementById('tr$val').style.backgroundColor='#E4E4D3';}else{document.getElementById('tr$val').style.backgroundColor='#EAEAEA';}\" type=\"checkbox\" id=\"bk$val\" name=\"mylist_id$val\" value=\"$val\" /></td>\n";
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
		set_global_var("show_info","<span class=\"OK_Message\">Mysql table Stamp has been updated<br /><br /></span>");	
	}
	else{
		set_global_var("show_info","<span class=\"Error_Message\">$show_info<br /></span>");	
	}
	set_global_var("count_total",$count_list);	
	set_global_var("show_onload_javascript","onkeypress=\"return noGlobalEnterKey(event)\"");
	set_global_var("print_object",get_html_from_layout("admin/html/admin_manage_game.html"));	
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

	//--------------------------------------------------------------------------------------
	function RefreshSortOrder(){
		$list_sort=set_array_from_query("max_game","game_id,game_order","game_id<>'' Order by game_order,game_title");
		$xorder=0;
		foreach($list_sort as $array_sort){
			$xorder++;
			update_field_in_db("max_game","game_order",$xorder,"game_id='$array_sort[game_id]' LIMIT 1");
		}
	}

?>
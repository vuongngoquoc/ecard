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
	
	if($row_number =="" || $row_number =="0" || !is_numeric($row_number)) $row_number = 15;
	set_global_var("row_number",$row_number);
	$row_per_page = $row_number;
				
	if ($page < 1 || $page=="") $page =1;
	$start = ($page-1)* 1 * $row_per_page;
	$end = $start + 1 * $row_per_page;
	if($what2=="delete_selected_photo"){
		foreach($http_vars as $key=>$val){
			if(!(strpos($key,"mylist_id")===false)){ //if true
				$selected_id =str_replace("mylist_id","",$key);	

				//Delete fullsize/thumbnail image
				$get_row=get_row("max_ecard","ec_filename,ec_thumbnail","ec_id='$selected_id'");
				if(is_writeable("$ecard_root/resource/picture/user_picture/$get_row[ec_thumbnail]")){
					@unlink("$ecard_root/resource/picture/user_picture/$get_row[ec_thumbnail]");
				}
				if(is_writeable("$ecard_root/resource/picture/user_picture/$get_row[ec_filename]")){
					@unlink("$ecard_root/resource/picture/user_picture/$get_row[ec_filename]");
				}

				//Delete row in database
				delete_row("max_ecard","ec_id='$selected_id' LIMIT 1");
			}
		}
	}
	elseif($what2=="delete_selected_audio"){
		foreach($http_vars as $key=>$val){
			if(!(strpos($key,"mylist_id")===false)){ //if true
				$selected_id =str_replace("mylist_id","",$key);	

				//Delete filename
				$get_row=get_row("max_music","music_filename","music_id='$selected_id'");
				if(is_writeable("$ecard_root/resource/music/$row_data[music_filename]")){
					@unlink("$ecard_root/resource/music/$row_data[music_filename]");
				}				

				//Delete row in database
				delete_row("max_music","music_id='$selected_id' LIMIT 1");
			}
		}
	}
	elseif($what2=="delete_selected_poem"){
		foreach($http_vars as $key=>$val){
			if(!(strpos($key,"mylist_id")===false)){ //if true
				$selected_id =str_replace("mylist_id","",$key);	

				//Delete row in database
				delete_row("max_poem","poem_id='$selected_id' LIMIT 1");
			}
		}
	}

	if($what=="load_audio"){
		print "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'><html xmlns='http://www.w3.org/1999/xhtml'><head><meta http-equiv='Content-Type' content='text/html; charset=$charset' /></head><body style='margin-top:0px;margin-left:0px'><embed src=$src autostart=true width=400 height=120 loop=0 hidden=false></embed></body></html>";
		exit;
	}
	elseif($what=="close_player"){
		print "";
		exit;
	}
	elseif($what=="album_photo" || $what==""){
		$list_data =set_array_from_query("max_ecard","ec_id,ec_filename,ec_thumbnail,ec_user_name_id","ec_user_name_id<>'' and ec_user_name_id<>'?' Order by ec_user_name_id LIMIT $start,$row_per_page");
		$count_list=get_dbvalue("max_ecard","count(ec_id)","ec_user_name_id<>'' and ec_user_name_id<>'?' ");

		if ($end > $count_list) $end = $count_list;
		$show_list_table="";
		$xrow=0;
		for ($z=$start; $z<$end; $z++) {
			$val = $list_data[$xrow][ec_id] ;
			$row_data=$list_data[$xrow];

			//Display thumbnail image
			if($row_data[ec_thumbnail]!=""){
				$display_thumbnail="<img border=\"0\" src=\"$ecard_url/resource/picture/user_picture/$row_data[ec_thumbnail]\" alt=\"\" />";
			}
			else{
				$display_thumbnail="<div style=\"height:60px;width:100px;text-align:center;background-color:lightgreen;border: thick solid green;padding:5px\">$member_view_album_txt_no_thumbnail</div>";
			}

			//Photo detail
			list($fullsize_width, $fullsize_height, $fullsize_type, $fullsize_attr) = getimagesize("$ecard_root/resource/picture/user_picture/$row_data[ec_filename]");
			$fullsize_filesize=number_format(filesize("$ecard_root/resource/picture/user_picture/$row_data[ec_filename]"));
			$fullsize_attr=str_replace("\"","&quot;",$fullsize_attr);
			$member_view_album_txt_photo_infos=str_replace("%id%","$val",$member_view_album_txt_photo_infos);
			$member_view_album_txt_photo_infos=str_replace("%ec_filename%","$row_data[ec_filename]",$member_view_album_txt_photo_infos);
			$member_view_album_txt_photo_infos=str_replace("%fullsize_attr%","$fullsize_attr",$member_view_album_txt_photo_infos);
			$member_view_album_txt_photo_infos=str_replace("%fullsize_filesize%","$fullsize_filesize",$member_view_album_txt_photo_infos);
			$show_file_detail="$member_view_album_txt_photo_infos";		

			//Show delete button
			$show_delete_button="<img onclick=\"HideItAll();document.getElementById('tr$val').style.backgroundColor='#E4E4D3';document.getElementById('cell$val').style.backgroundColor='#FAEDC8';document.getElementById('cell$val').style.border='thick solid #FCAA03';document.getElementById('bk$val').checked=true;CheckSelected();\" border=\"0\" src=\"html/07_icon_delete.gif\" style=\"cursor:pointer\" alt=\"$member_view_album_tooltip_delete_member_photo\" title=\"$member_view_album_tooltip_delete_member_photo\" />";

			$show_list_table .="<tr id=\"tr$val\" style=\"background-color: #EAEAEA;line-height:20px\">\n";
			$show_list_table .="<td width=\"40%\" style=\"padding:4px;cursor:pointer;\" title=\"$member_view_album_tooltip_click_to_view_fullsize\" id=\"cell$val\" onclick=\"HideItAll();this.style.backgroundColor='#FAEDC8';this.style.border='thick solid #FCAA03';ShowFullsize('$ecard_url/resource/picture/user_picture/$row_data[ec_filename]','$fullsize_width','$fullsize_height');\">$display_thumbnail</td>\n";
			$show_list_table .="<td width=\"30%\" align=\"center\"><a href=\"index.php?step=admin_member_display&search_field=user_name_id&cmd_button=Search+User&keyword=$row_data[ec_user_name_id]\">$row_data[ec_user_name_id]</a></td>\n";
			$show_list_table .="<td width=\"28%\" align=\"center\">$show_file_detail</td>\n";
			$show_list_table .="<td width=\"1%\" align=\"center\">$show_delete_button</td>\n";
			$show_list_table .="<td width=\"1%\" align=\"center\"><input onclick=\"if(this.checked){document.getElementById('tr$val').style.backgroundColor='#E4E4D3';}else{document.getElementById('tr$val').style.backgroundColor='#EAEAEA';}\" type=\"checkbox\" id=\"bk$val\" name=\"mylist_id$val\" value=\"$val\" /></td>\n";
			$show_list_table .="</tr>\n";
			$bk_id .="$val,";
			$xrow++;
		}
		set_global_var("show_list_table",$show_list_table);	
		if($bk_id{strlen($bk_id)-1} ==",") $bk_id = substr($bk_id, 0, strlen($bk_id)-1);
		set_global_var("bk_id",$bk_id);		
	}
	elseif($what=="album_audio"){
		$list_data =set_array_from_query("max_music","music_id,music_name_display,music_filename,music_user_name_id","music_user_name_id<>'' Order by music_user_name_id LIMIT $start,$row_per_page");
		$count_list=get_dbvalue("max_music","count(music_id)","music_user_name_id<>''");

		if ($end > $count_list) $end = $count_list;
		$show_list_table="";
		$xrow=0;
		for ($z=$start; $z<$end; $z++) {
			$val = $list_data[$xrow][music_id] ;
			$row_data=$list_data[$xrow];

			//Display thumbnail audio
			$display_thumbnail="$member_view_album_txt_title: <strong>$row_data[music_name_display]</strong><br /><img border=\"0\" src=\"html/07_icon_play_audio_file.gif\" alt=\"\" style=\"vertical-align:middle\" /> <span style=\"text-decoration:underline;\">$member_view_album_txt_click_here_to_play</span>";

			//Audio detail
			$fullsize_filesize=number_format(filesize("$ecard_root/resource/music/$row_data[music_filename]"));
			$member_view_album_txt_audio_infos=str_replace("%id%","$val",$member_view_album_txt_audio_infos);
			$member_view_album_txt_audio_infos=str_replace("%music_filename%","$row_data[music_filename]",$member_view_album_txt_audio_infos);
			$member_view_album_txt_audio_infos=str_replace("%fullsize_filesize%","$fullsize_filesize",$member_view_album_txt_audio_infos);
			$show_file_detail="$member_view_album_txt_audio_infos";		

			//Show delete button
			$show_delete_button="<img onclick=\"HideItAll();document.getElementById('tr$val').style.backgroundColor='#E4E4D3';document.getElementById('cell$val').style.backgroundColor='#FAEDC8';document.getElementById('cell$val').style.border='thick solid #FCAA03';document.getElementById('bk$val').checked=true;CheckSelected();\" border=\"0\" src=\"html/07_icon_delete.gif\" style=\"cursor:pointer\" alt=\"$member_view_album_tooltip_delete_member_audio_file\" title=\"$member_view_album_tooltip_delete_member_audio_file\" />";
			
			//Audio title
			$audio_title=str_replace("'","\\'",$row_data[music_name_display]);
			$show_list_table .="<tr id=\"tr$val\" style=\"background-color: #EAEAEA;line-height:20px\">\n";
			$show_list_table .="<td width=\"40%\" style=\"padding:4px;cursor:pointer;\" title=\"$member_view_album_txt_click_here_to_listen\" id=\"cell$val\" onclick=\"HideItAll();this.style.backgroundColor='#FAEDC8';this.style.border='thick solid #FCAA03';ShowPlayer('$ecard_url/resource/music/$row_data[music_filename]','$audio_title');\">$display_thumbnail</td>\n";
			$show_list_table .="<td width=\"30%\" align=\"center\"><a href=\"index.php?step=admin_member_display&search_field=user_name_id&cmd_button=Search+User&keyword=$row_data[music_user_name_id]\">$row_data[music_user_name_id]</a></td>\n";
			$show_list_table .="<td width=\"28%\" align=\"center\">$show_file_detail</td>\n";
			$show_list_table .="<td width=\"1%\" align=\"center\">$show_delete_button</td>\n";
			$show_list_table .="<td width=\"1%\" align=\"center\"><input onclick=\"if(this.checked){document.getElementById('tr$val').style.backgroundColor='#E4E4D3';}else{document.getElementById('tr$val').style.backgroundColor='#EAEAEA';}\" type=\"checkbox\" id=\"bk$val\" name=\"mylist_id$val\" value=\"$val\" /></td>\n";
			$show_list_table .="</tr>\n";
			$bk_id .="$val,";
			$xrow++;
		}
		set_global_var("show_list_table",$show_list_table);	
		if($bk_id{strlen($bk_id)-1} ==",") $bk_id = substr($bk_id, 0, strlen($bk_id)-1);
		set_global_var("bk_id",$bk_id);	
	}
	elseif($what=="album_poem"){
		$list_data =set_array_from_query("max_poem","poem_id,poem_title,poem_author,poem_body,poem_user_name_id","poem_user_name_id<>'' Order by poem_user_name_id LIMIT $start,$row_per_page");
		$count_list=get_dbvalue("max_poem","count(poem_id)","poem_user_name_id<>''");

		if ($end > $count_list) $end = $count_list;
		$show_list_table="";
		$xrow=0;
		for ($z=$start; $z<$end; $z++) {
			$val = $list_data[$xrow][poem_id] ;
			$row_data=$list_data[$xrow];

			//Display thumbnail poem title
			$display_thumbnail="Title: <strong>$row_data[poem_title]</strong><br /><img border=\"0\" src=\"html/07_icon_view_poem.gif\" alt=\"\" style=\"vertical-align:middle\" /> <span style=\"text-decoration:underline;\">$member_view_album_txt_click_here_to_view</span>";

			//Poem detail
			$poemsize=strlen($row_data[poem_title]) + strlen($row_data[poem_author]) + strlen($row_data[poem_body]);
			$member_view_album_txt_poem_infos=str_replace("%id%","$val",$member_view_album_txt_poem_infos);
			$member_view_album_txt_poem_infos=str_replace("%poem_author%","$row_data[poem_author]",$member_view_album_txt_poem_infos);
			$member_view_album_txt_poem_infos=str_replace("%poemsize%","$poemsize",$member_view_album_txt_poem_infos);
			$show_file_detail="$member_view_album_txt_poem_infos";

			//Show delete button
			$show_delete_button="<img onclick=\"HideItAll();document.getElementById('tr$val').style.backgroundColor='#E4E4D3';document.getElementById('cell$val').style.backgroundColor='#FAEDC8';document.getElementById('cell$val').style.border='thick solid #FCAA03';document.getElementById('bk$val').checked=true;CheckSelected();\" border=\"0\" src=\"html/07_icon_delete.gif\" style=\"cursor:pointer\" alt=\"$member_view_album_tooltip_delete_member_poem\" title=\"$member_view_album_tooltip_delete_member_poem\" />";
			
			//Poem text
			$row_data[poem_body]=str_replace("<br>","<br />",$row_data[poem_body]);			
			$poem_text="<div style=\"display:none;\" id=\"divpoem$val\"><br /><strong>".strtoupper($row_data[poem_title])."</strong><br />$member_view_album_txt_author: $row_data[poem_author]<br /><br />$row_data[poem_body]<br /><br /></div>";

			//Audio title
			$audio_title=str_replace("'","\\'",$row_data[music_name_display]);
			$show_list_table .="<tr id=\"tr$val\" style=\"background-color: #EAEAEA;line-height:20px\">\n";
			$show_list_table .="<td width=\"40%\" style=\"padding:4px;cursor:pointer;\" title=\"$member_view_album_txt_click_here_to_view\" id=\"cell$val\" onclick=\"HideItAll();this.style.backgroundColor='#FAEDC8';this.style.border='thick solid #FCAA03';ShowPoem('divpoem$val');\">$display_thumbnail$poem_text</td>\n";
			$show_list_table .="<td width=\"30%\" align=\"center\"><a href=\"index.php?step=admin_member_display&search_field=user_name_id&cmd_button=Search+User&keyword=$row_data[poem_user_name_id]\">$row_data[poem_user_name_id]</a></td>\n";
			$show_list_table .="<td width=\"28%\" align=\"center\">$show_file_detail</td>\n";
			$show_list_table .="<td width=\"1%\" align=\"center\">$show_delete_button</td>\n";
			$show_list_table .="<td width=\"1%\" align=\"center\"><input onclick=\"if(this.checked){document.getElementById('tr$val').style.backgroundColor='#E4E4D3';}else{document.getElementById('tr$val').style.backgroundColor='#EAEAEA';}\" type=\"checkbox\" id=\"bk$val\" name=\"mylist_id$val\" value=\"$val\" /></td>\n";
			$show_list_table .="</tr>\n";
			$bk_id .="$val,";
			$xrow++;
		}
		set_global_var("show_list_table",$show_list_table);	
		if($bk_id{strlen($bk_id)-1} ==",") $bk_id = substr($bk_id, 0, strlen($bk_id)-1);
		set_global_var("bk_id",$bk_id);	
	}	
		
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
				$dpn ="<a href=\"index.php?step=$step&what=$what&row_number=$row_number&page=$page_pr\"><img border=0 src=html/prv.gif style='vertical-align:middle' title='Page # $page_pr' alt='Page # $page_pr' /></a>";
				$display_page_number = str_replace("{A}", $dpn, $display_page_number);
			}
			else{
				$display_page_number = str_replace("{A}", "<img src=html/prv_disable.gif alt='' style='vertical-align:middle' />", $display_page_number);
			}
			$y=get_global_var("d_num");
			if ($page < $y) {
				$page_ne = $page + 1 ;				
				$display_page_number = str_replace("{B}", "<a href=\"index.php?step=$step&what=$what&row_number=$row_number&page=$page_ne\"><img border=0 src=html/next.gif style='vertical-align:middle' title='Page # $page_ne' alt='Page # $page_ne' /></a>", $display_page_number);
			}	
			else{
				$display_page_number = str_replace("{B}", "<img src=html/next_disable.gif alt='' style='vertical-align:middle' />", $display_page_number);
			}
		}
	}
	set_global_var("display_page_number",$display_page_number);	 
	set_global_var("count_total",$count_list);
	
	if($what=="album_photo" || $what==""){
		set_global_var("print_object",get_html_from_layout("admin/html/admin_member_view_album_photo.html"));
	}
	elseif($what=="album_audio"){
		set_global_var("print_object",get_html_from_layout("admin/html/admin_member_view_album_audio.html"));
	}
	elseif($what=="album_poem"){
		set_global_var("print_object",get_html_from_layout("admin/html/admin_member_view_album_poem.html"));
	}
	
	set_global_var("show_onload_javascript","onkeypress=\"return noGlobalEnterKey(event)\"");
	print_admin_header_footer_page();	

	//--------------------------------------------------------------------------------------
	function get_page_count_number($page,$b){
		global $step,$what,$row_number;
			
		$url="index.php?step=$step&what=$what&row_number=$row_number";
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
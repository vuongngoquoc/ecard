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
	
	//Auto add new applet to database if found
	$list_dir_database=get_dblistvalue("max_java_applet","java_dirname");
	$list_dir=get_list_dir("$ecard_root/resource/applet");
	$db_change ="";
	foreach($list_dir as $dir){
		if (!in_array($dir, $list_dir_database)){
			//Insert new applet to database
			$java_name_display=str_replace("_"," ",$dir);
			$field_name ="(java_name_display,java_dirname,java_active,java_order)";
			$field_value ="('$java_name_display','$dir',1,1)";
			insert_data_to_db("max_java_applet",$field_name,$field_value);
			$db_change ="1";
		}
	}

	//Auto remove apple from mysql if it's not found on server
	foreach($list_dir_database as $dir_mysql){
		if (!in_array($dir_mysql, $list_dir)){
			//Remove from database
			delete_row("max_java_applet","java_dirname='$dir_mysql'");
			$db_change ="1";
		}
	}

	if($what=="set_sort_order"){
		$list_sort=set_array_from_query("max_java_applet","java_id,java_order","java_id<>'' Order by java_order,java_name_display");		
		foreach($list_sort as $array_sort){
			if($current_sort > $sort_number){
				if($array_sort[java_order]>=$sort_number){			
					update_field_in_db("max_java_applet","java_order",$array_sort[java_order]+1,"java_id='$array_sort[java_id]' LIMIT 1");
				}
			}
			else{
				if($array_sort[java_order]<=$sort_number){			
					update_field_in_db("max_java_applet","java_order",$array_sort[java_order]-1,"java_id='$array_sort[java_id]' LIMIT 1");
				}
			}
		}		
		update_field_in_db("max_java_applet","java_order",$sort_number,"java_id='$java_id' LIMIT 1");
		$what="";
		set_global_var("what","");
	}

	$list_data =set_array_from_query("max_java_applet","*","java_id<>'' Order by java_order,java_name_display");
	$count_list=count($list_data);

	$show_list_table="";
	$xorder=0;
	foreach ($list_data as $row_data) {
		$val = $row_data[java_id] ;

		//Update java_order
		$xorder++;
		if($xorder!=$row_data[java_order]){
			update_field_in_db("max_java_applet","java_order",$xorder,"java_id='$val' LIMIT 1");
		}

		//Show sort order dropdown menu
		$show_sort="<select size=\"1\" name=\"java_order$val\" id=\"java_order$val\" onchange=\"location.href='index.php?step=$step&what=set_sort_order&java_id=$val&current_sort=$xorder&sort_number='+this.value;\">";
		for($i=1;$i<=$count_list;$i++){
			if($xorder==$i){
				$show_sort.="<option value=\"$i\" selected=\"selected\">$i</option>\n";
			}
			else{
				$show_sort.="<option value=\"$i\" >$i</option>\n";
			}
		}
		$show_sort.="</select>";

		//Show icon
		if(file_exists("$ecard_root/resource/applet/$row_data[java_dirname]/thumb_icon.gif")){
			$show_icon ="<img border=\"0\" src=\"$ecard_url/resource/applet/$row_data[java_dirname]/thumb_icon.gif\" alt=\"\" />";
		}
		else{
			$show_icon ="<img border=\"0\" src=\"html/07_icon_no_icon_java.gif\" alt=\"$java_tooltip_icon_not_found\" title=\"$java_tooltip_icon_not_found\" />";
		}

		//Show title
		$show_title="<input id=\"java_name_display$val\" title=\"$java_tooltip_click_here_to_rename\" type=\"text\" value=\"$row_data[java_name_display]\" style=\"border:0px;background-color:#EAEAEA;cursor:pointer;width:430px;text-decoration:underline;\" onfocus=\"original_value=this.value;this.style.border='1px solid silver';this.style.textDecoration='none';this.style.cursor='text';\" onblur=\"this.style.border='0px';this.style.textDecoration='underline';this.style.cursor='pointer';\" onchange=\"Editme('index.php?step=edit_me&table=max_java_applet&edit_id=java_id&edit_id_value=$val&edit_key=java_name_display&edit_value=',this.value,'1',original_value,this.id);\" />";		
		
		//Show preview icon
		$get_pixel="width=500px height=375px";
		$centerX=round(500/2);
		$centerY=round(375/2);
		$applet_code=get_file_content("$ecard_root/resource/applet/$row_data[java_dirname]/code.txt");
		$applet_code=str_replace("\r\n",' ',$applet_code);
		$applet_code=str_replace("'","\\'",$applet_code);
		$applet_code=str_replace("\"","\\'",$applet_code);
		$applet_code = str_replace("anfy_key", $cf_anfy_java_keycode, $applet_code) ;
		$applet_code = str_replace("ds_key", $cf_ds_java_keycode, $applet_code) ;
		$applet_code = str_replace("cgi2k_key", $cf_cgi2k_java_keycode, $applet_code) ;
		$applet_code = str_replace("codebase", "codebase=$ecard_url/resource/applet/$row_data[java_dirname]", $applet_code) ;
		$applet_code = str_replace("change_pixel", $get_pixel, $applet_code) ;
		$applet_code = str_replace("centerX", $centerX, $applet_code) ;
		$applet_code = str_replace("centerY", $centerY, $applet_code) ;
		$applet_code = str_replace("change_pic", "html/sample_card.jpg", $applet_code) ;
		$applet_code = str_replace("change_path", "$ecard_url/resource/applet/$row_data[java_dirname]", $applet_code) ;
		$applet_code.="<br /><br />Don\\'t see anything? <a href=http://java.com/en/download/index.jsp target=_blank>Click here</a> to download Java software!";

		$applet_name=str_replace("'","\\'",$row_data[java_name_display]);
		$show_preview_icon="<img border=\"0\" src=\"html/07_icon_search_keyword.gif\" alt=\"\" style=\"cursor:pointer\" onclick=\"HideItAll();document.getElementById('print_my_title').innerHTML=document.getElementById('java_name_display$val').value;document.getElementById('cell$val').style.backgroundColor='#FAEDC8';document.getElementById('cell$val').style.border='thick solid #FCAA03';document.getElementById('preview_cell$val').style.backgroundColor='#FAEDC8';document.getElementById('preview_cell$val').style.border='thick solid #FCAA03';PreviewApplet('$applet_code');\" />";

		//Show on/off checkbox
		if($row_data[java_active]=="1"){
			$checked_it ="checked=\"checked\"";
		}
		else{
			$checked_it ="";
		}
			
		$show_list_table .="<tr id=\"tr$val\" style=\"background-color: #EAEAEA;line-height:20px\">\n";
		$show_list_table .="<td width=\"1%\" align=\"center\" id=\"cell$val\">$show_icon</td>\n";
		$show_list_table .="<td width=\"50%\" style=\"padding:4px;cursor:pointer;\">$show_title</td>\n";
		$show_list_table .="<td width=\"30%\">$row_data[java_dirname]</td>\n";
		$show_list_table .="<td width=\"7%\" align=\"center\" id=\"preview_cell$val\">$show_preview_icon</td>\n";
		$show_list_table .="<td width=\"12%\" align=\"center\"><input $checked_it type=\"checkbox\" value=\"1\" onclick=\"ShowLoaderImage('$java_message_updating');if(this.checked){UpdateDataTable('index.php?step=edit_me&table=max_java_applet&edit_id=java_id&edit_id_value=$val&edit_key=java_active&edit_value=1');}else{UpdateDataTable('index.php?step=edit_me&table=max_java_applet&edit_id=java_id&edit_id_value=$val&edit_key=java_active&edit_value=0');}\" /></td>\n";
		$show_list_table .="<td width=\"1%\" align=\"center\" style=\"padding:4px;\">$show_sort</td>\n";
		$show_list_table .="</tr>\n";
		$bk_id .="$val,";
		$xrow++;
	}
	if($bk_id{strlen($bk_id)-1} ==",") $bk_id = substr($bk_id, 0, strlen($bk_id)-1);
	set_global_var("bk_id",$bk_id);
	set_global_var("show_list_table",$show_list_table);			
	
	if($db_change =="1")set_global_var("show_info","<span class=\"OK_Message\">$java_message_mysql_table_java_applet_updated<br /><br /></span>");	
	set_global_var("count_total",$count_list);	
	set_global_var("show_onload_javascript","onkeypress=\"return noGlobalEnterKey(event)\"");
	$java_txt_how_to_add_new_java_applet_by_ftp_guide=str_replace("%java_applet_folder%","$ecard_root/resource/applet",$java_txt_how_to_add_new_java_applet_by_ftp_guide);
	$java_txt_how_to_add_new_java_applet_by_ftp_guide=str_replace("%url%","index.php?step=$step&what=add_new",$java_txt_how_to_add_new_java_applet_by_ftp_guide);
	set_global_var("java_txt_how_to_add_new_java_applet_by_ftp_guide",$java_txt_how_to_add_new_java_applet_by_ftp_guide);
	set_global_var("print_object",get_html_from_layout("admin/html/admin_option_java.html"));	
	print_admin_header_footer_page();	

?>
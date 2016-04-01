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

	if($what=="add_new_basic"){
		$field_name ="(banner_type,banner_width,banner_height,banner_url,banner_img_url,banner_code)";
		$field_value ="($banner_type,$banner_width,$banner_height,'$banner_url','$banner_img_url','0')";
		insert_data_to_db("max_banner",$field_name,$field_value);
		$show_info .="<span class=OK_Message>$banner_ad_message_new_banner_added</span><br />\n";	
	}
	elseif($what=="add_new_advance"){
		$field_name ="(banner_type,banner_width,banner_height,banner_url,banner_img_url,banner_code)";
		$field_value ="($banner_type2,0,0,'0','0','$banner_code')";
		insert_data_to_db("max_banner",$field_name,$field_value);
		$show_info .="<span class=OK_Message>$banner_ad_message_new_banner_added</span><br />\n";	
	}
	elseif($what=="delete_selected"){
		foreach($http_vars as $key=>$val){
			if(!(strpos($key,"mylist_id")===false)){ //if true
				$selected_id =str_replace("mylist_id","",$key);					
				//Delete row in database
				delete_row("max_banner","banner_id='$selected_id' LIMIT 1");
			}
		}
	}
	elseif($what=="showbanner"){
		$row = get_row("max_banner","*","banner_id='$banner_id'");
		if($row[banner_code] =="0"){
			print "<script language=JavaScript src=\"$ecard_url/index.php?step=banner&banner_id=$banner_id\"></script>";
		}
		else{
			$row[banner_code] = str_replace("&quot;","\"",$row[banner_code]);
			print $row[banner_code];
		}
		exit;
	}

	if($row_number =="" || $row_number =="0" || !is_numeric($row_number)) $row_number = 15;
	set_global_var("row_number",$row_number);
	$row_per_page = $row_number;
				
	if ($page < 1 || $page=="") $page =1;
	$start = ($page-1)* 1 * $row_per_page;
	$end = $start + 1 * $row_per_page;

	$list_data =set_array_from_query("max_banner","*","banner_id<>'' Order by banner_active DESC,banner_code DESC,banner_type ASC LIMIT $start,$row_per_page");
	$count_list=get_dbvalue("max_banner","count(banner_id)","banner_id<>''");

	if ($end > $count_list) $end = $count_list;
	$show_list_table="";
	$xrow=0;
	for ($z=$start; $z<$end; $z++) {
		$val = $list_data[$xrow][banner_id] ;
		$row_data=$list_data[$xrow];

		//Show icon
		$show_icon ="<img border=\"0\" src=\"html/07_icon_banner3.gif\" alt=\"\" />";		

		//Show banner basic or advance
		$row_data[banner_code] = str_replace("&quot;","\"",$row_data[banner_code]);
		if($row_data[banner_code]=="0"){//Basic
			$banner_way="$banner_ad_txt_banner_URL_click_to_edit<br /><input onkeypress=\"return noEnterKey(event);\" type=\"text\" name=\"banner_img_url$val\" id=\"banner_img_url$val\" title=\"$banner_ad_tooltip_click_to_edit\" style=\"border:0px;background-color:#EAEAEA;cursor:pointer;text-decoration:underline;font-size:11px;color:green;width:480px;\" onchange=\"Editme('index.php?step=edit_me&table=max_banner&edit_id=banner_id&edit_id_value=$val&edit_key=banner_img_url&edit_value=',this.value,'1',original_value,this.id);\" onfocus=\"original_value=this.value;this.style.border='1px solid silver';this.style.textDecoration='none';this.style.cursor='text';\" onblur=\"this.style.border='0px';this.style.textDecoration='underline';this.style.cursor='pointer';\" value=\"$row_data[banner_img_url]\" /><br /><br />$banner_ad_txt_destination_url<br /><input onkeypress=\"return noEnterKey(event);\" type=\"text\" name=\"banner_url$val\" id=\"banner_url$val\" title=\"$banner_ad_tooltip_click_to_edit\" style=\"border:0px;background-color:#EAEAEA;cursor:pointer;text-decoration:underline;font-size:11px;color:green;width:480px;\" onchange=\"Editme('index.php?step=edit_me&table=max_banner&edit_id=banner_id&edit_id_value=$val&edit_key=banner_url&edit_value=',this.value,'1',original_value,this.id);\" onfocus=\"original_value=this.value;this.style.border='1px solid silver';this.style.textDecoration='none';this.style.cursor='text';\" onblur=\"this.style.border='0px';this.style.textDecoration='underline';this.style.cursor='pointer';\" value=\"$row_data[banner_url]\" /><br /><br />$banner_ad_txt_banner_width ($banner_ad_txt_px): <input onkeypress=\"return isNumberKey(event);\" type=\"text\" name=\"banner_width$val\" id=\"banner_width$val\" title=\"$banner_ad_tooltip_click_to_edit\" style=\"border:0px;background-color:#EAEAEA;cursor:pointer;text-decoration:underline;font-size:11px;color:green;width:30px;\" onchange=\"Editme('index.php?step=edit_me&table=max_banner&edit_id=banner_id&edit_id_value=$val&edit_key=banner_width&edit_value=',this.value,'1',original_value,this.id);\" onfocus=\"original_value=this.value;this.style.border='1px solid silver';this.style.textDecoration='none';this.style.cursor='text';\" onblur=\"this.style.border='0px';this.style.textDecoration='underline';this.style.cursor='pointer';\" value=\"$row_data[banner_width]\" /> - $banner_ad_txt_banner_height ($banner_ad_txt_px): <input onkeypress=\"return isNumberKey(event);\" type=\"text\" name=\"banner_height$val\" id=\"banner_height$val\" style=\"border:0px;background-color:#EAEAEA;cursor:pointer;text-decoration:underline;font-size:11px;color:green;width:30px;\" onchange=\"Editme('index.php?step=edit_me&table=max_banner&edit_id=banner_id&edit_id_value=$val&edit_key=banner_height&edit_value=',this.value,'1',original_value,this.id);\" onfocus=\"original_value=this.value;this.style.border='1px solid silver';this.style.textDecoration='none';this.style.cursor='text';\" onblur=\"this.style.border='0px';this.style.textDecoration='underline';this.style.cursor='pointer';\" value=\"$row_data[banner_height]\" />";
		}
		else{//Advance
			$banner_way="<textarea onchange=\"Editme('index.php?step=edit_me&table=max_banner&edit_id=banner_id&edit_id_value=$val&edit_key=banner_code&edit_value=',this.value,'1',original_value,this.id);\" onfocus=\"original_value=this.value;\" wrap=\"off\" name=\"banner_code$val\" id=\"banner_code$val\" style=\"width:480px;height:150px\" >$row_data[banner_code]</textarea>";
		}		
		
		//Show on/off checkbox
		if($row_data[banner_active]=="1"){
			$checked_it ="checked=\"checked\"";
		}
		else{
			$checked_it ="";
		}

		//Banner type
		$banner_type="<select onchange=\"Editme('index.php?step=edit_me&table=max_banner&edit_id=banner_id&edit_id_value=$val&edit_key=banner_type&edit_value=',this.value,'1',this.value,this.id);\" size=\"1\" name=\"banner_type$val\" id=\"banner_type$val\">";
		if($row_data[banner_type]=="0"){//Horizontal
			$banner_type.="<option value=\"0\" selected=\"selected\">$banner_ad_txt_horizontal</option>";
			$banner_type.="<option value=\"1\">$banner_ad_txt_vertical</option>";
			$banner_type.="<option value=\"2\">$banner_ad_txt_center</option>";
		}
		elseif($row_data[banner_type]=="1"){//Vertical
			$banner_type.="<option value=\"0\">$banner_ad_txt_horizontal</option>";
			$banner_type.="<option value=\"1\" selected=\"selected\">$banner_ad_txt_vertical</option>";
			$banner_type.="<option value=\"2\">$banner_ad_txt_center</option>";
		}
		elseif($row_data[banner_type]=="2"){//Center
			$banner_type.="<option value=\"0\">$banner_ad_txt_horizontal</option>";
			$banner_type.="<option value=\"1\">$banner_ad_txt_vertical</option>";
			$banner_type.="<option value=\"2\" selected=\"selected\">$banner_ad_txt_center</option>";
		}
		$banner_type.="</select>";

		//Show delete button
		$show_delete_button="<img onclick=\"document.getElementById('tr$val').style.backgroundColor='#E4E4D3';document.getElementById('bk$val').checked='true';CheckSelected();\" border=\"0\" src=\"html/07_icon_delete.gif\" style=\"cursor:pointer\" alt=\"$banner_ad_tooltip_delete\" title=\"$banner_ad_tooltip_delete\" />";				

		$show_list_table .="<tr id=\"tr$val\" style=\"background-color: #EAEAEA;line-height:20px\">\n";
		$show_list_table .="<td width=\"1%\" align=\"center\" valign=\"top\" style=\"padding:7px;cursor:pointer;\" title=\"$banner_ad_tooltip_click_to_preview_banner\" id=\"cell$val\" onclick=\"HideItAll();this.style.backgroundColor='#FAEDC8';this.style.border='thick solid #FCAA03';Showbanner('$val');\">$show_icon</td>\n";
		$show_list_table .="<td width=\"*\" style=\"padding:4px;\">$banner_way</td>\n";
		$show_list_table .="<td width=\"*\" style=\"padding:4px;\" align=\"center\">$banner_type</td>\n";
		$show_list_table .="<td width=\"1%\" align=\"center\">$row_data[banner_time_is_show]</td>\n";
		$show_list_table .="<td width=\"1%\" align=\"center\">$row_data[banner_time_is_click]</td>\n";
		$show_list_table .="<td width=\"1%\" align=\"center\"><input $checked_it type=\"checkbox\" value=\"1\" onclick=\"ShowLoaderImage('$banner_ad_message_updating');if(this.checked){UpdateDataTable('index.php?step=edit_me&table=max_banner&edit_id=banner_id&edit_id_value=$val&edit_key=banner_active&edit_value=1');}else{UpdateDataTable('index.php?step=edit_me&table=max_banner&edit_id=banner_id&edit_id_value=$val&edit_key=banner_active&edit_value=0');}\" /></td>\n";		
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
		set_global_var("show_info","<span class=\"OK_Message\">Mysql table banner has been updated<br /><br /></span>");	
	}
	else{
		set_global_var("show_info","<span class=\"Error_Message\">$show_info<br /></span>");	
	}

	set_global_var("count_total",$count_list);		
	set_global_var("print_object",get_html_from_layout("admin/html/admin_option_banner.html"));	
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
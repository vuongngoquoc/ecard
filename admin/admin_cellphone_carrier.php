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

	if($what=="add_new"){
		if($ca_active=="")$ca_active=0;
		$ca_domain=strtolower($ca_domain);
		$field_name ="(ca_name,ca_domain,ca_active)";
		$field_value ="('$ca_name','$ca_domain',$ca_active)";
		insert_data_to_db("max_cell_carrier",$field_name,$field_value);		
		$show_info="<span class=\"OK_Message\">$cellphone_carier_message_new_carier_has_been_added</span><br />";
	}
	elseif($what=="add_new_bulk"){
		if($ca_active_bulk=="")$ca_active_bulk=0;
		$array=split("\n",$list_carrier);
		$field_name ="(ca_name,ca_domain,ca_active)";
		$field_value="";
		$count_ca=0;
		foreach($array as $val){
			$val=trim($val);
			if($val!=""){
				list($ca_name,$ca_domain)=split("\|",$val);
				$ca_domain=strtolower($ca_domain);
				$count_ca++;
				$field_value .="('$ca_name','$ca_domain',$ca_active_bulk),";				
			}
		}
		if($field_value{strlen($field_value)-1} ==",") $field_value = substr($field_value, 0, strlen($field_value)-1);
		if($field_value!=""){
			insert_data_to_db("max_cell_carrier",$field_name,$field_value);
			$cellphone_carier_message_new_carier_has_been_added_1=str_replace("%count_ca%","$count_ca",$cellphone_carier_message_new_carier_has_been_added_1);
			$show_info="<span class=\"OK_Message\">$cellphone_carier_message_new_carier_has_been_added_1</span><br />";
		}
	}
	elseif($what=="delete_selected"){
		foreach($http_vars as $key=>$val){
			if(!(strpos($key,"mylist_id")===false)){ //if true
				$selected_id =str_replace("mylist_id","",$key);

				//Delete row in database
				delete_row("max_cell_carrier","ca_id='$selected_id' LIMIT 1");
			}
		}
	}	

	if($row_number =="" || $row_number =="0" || !is_numeric($row_number)) $row_number = 15;
	set_global_var("row_number",$row_number);
	$row_per_page = $row_number;
				
	if ($page < 1 || $page=="") $page =1;
	$start = ($page-1)* 1 * $row_per_page;
	$end = $start + 1 * $row_per_page;

	$list_data =set_array_from_query("max_cell_carrier","*","ca_id<>'' Order by ca_name LIMIT $start,$row_per_page");
	$count_list=get_dbvalue("max_cell_carrier","count(ca_id)");

	if ($end > $count_list) $end = $count_list;
	$show_list_table="";
	$xrow=0;
	for ($z=$start; $z<$end; $z++) {
		$val = $list_data[$xrow][ca_id] ;
		$row_data=$list_data[$xrow];

		//Show carrier name
		$show_carrier_name="<input onkeypress=\"return noEnterKey(event);\" id=\"ca_name$val\" title=\"$cellphone_carier_tooltip_click_here_to_edit\" type=\"text\" value=\"$row_data[ca_name]\" style=\"border:0px;background-color:#EAEAEA;cursor:pointer;width:320px;text-decoration:underline;font-weight:bold;font-size:14px;\" onfocus=\"original_value=this.value;this.style.border='1px solid silver';this.style.textDecoration='none';this.style.cursor='text';\" onblur=\"this.style.border='0px';this.style.textDecoration='underline';this.style.cursor='pointer';\" onchange=\"Editme('index.php?step=edit_me&table=max_cell_carrier&edit_id=ca_id&edit_id_value=$val&edit_key=ca_name&edit_value=',this.value,'1',original_value,this.id);\" />";

		//Show carrier domain
		$show_carrier_domain="<input onkeypress=\"return noEnterKey(event);\" id=\"ca_domain$val\" title=\"$cellphone_carier_tooltip_click_here_to_edit\" type=\"text\" value=\"$row_data[ca_domain]\" style=\"border:0px;background-color:#EAEAEA;cursor:pointer;width:320px;text-decoration:underline;font-size:8pt;color:green\" onfocus=\"original_value=this.value;this.style.border='1px solid silver';this.style.textDecoration='none';this.style.cursor='text';\" onblur=\"this.style.border='0px';this.style.textDecoration='underline';this.style.cursor='pointer';\" onchange=\"Editme('index.php?step=edit_me&table=max_cell_carrier&edit_id=ca_id&edit_id_value=$val&edit_key=ca_domain&edit_value=',this.value,'1',original_value,this.id);\" />";
	
		//Show on/off checkbox
		if($row_data[ca_active]=="1"){
			$checked_it ="checked=\"checked\"";
		}
		else{
			$checked_it ="";
		}

		//Show delete button
		$show_delete_button="<img onclick=\"document.getElementById('tr$val').style.backgroundColor='#E4E4D3';document.getElementById('bk$val').checked='true';CheckSelected();\" border=\"0\" src=\"html/07_icon_delete.gif\" style=\"cursor:pointer\" alt=\"$cellphone_carier_tooltip_delete\" title=\"$cellphone_carier_tooltip_delete\" />";
			
		$show_list_table .="<tr id=\"tr$val\" style=\"background-color: #EAEAEA;line-height:20px\">\n";
		$show_list_table .="<td width=\"1%\" align=\"center\" valign=\"top\" id=\"cell$val\" style=\"padding:7px\">$show_carrier_name</td>\n";
		$show_list_table .="<td width=\"*\" valign=\"top\"  style=\"padding:7px\">$show_carrier_domain</td>\n";
		$show_list_table .="<td width=\"12%\" valign=\"top\" align=\"center\" ><input $checked_it type=\"checkbox\" value=\"1\" onclick=\"ShowLoaderImage('$cellphone_carier_message_updating');if(this.checked){UpdateDataTable('index.php?step=edit_me&table=max_cell_carrier&edit_id=ca_id&edit_id_value=$val&edit_key=ca_active&edit_value=1');}else{UpdateDataTable('index.php?step=edit_me&table=max_cell_carrier&edit_id=ca_id&edit_id_value=$val&edit_key=ca_active&edit_value=0');}\" /></td>\n";		
		$show_list_table .="<td width=\"1%\" valign=\"top\" align=\"center\" style=\"padding:7px\">$show_delete_button</td>\n";
		$show_list_table .="<td width=\"1%\" valign=\"top\" align=\"center\" ><input onclick=\"if(this.checked){document.getElementById('tr$val').style.backgroundColor='#E4E4D3';}else{document.getElementById('tr$val').style.backgroundColor='#EAEAEA';}\" type=\"checkbox\" id=\"bk$val\" name=\"mylist_id$val\" value=\"$val\" /></td>\n";
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
		set_global_var("show_info","<span class=\"OK_Message\">$cellphone_carier_message_mysql_table_stamp_has_been_updated<br /><br /></span>");	
	}
	else{
		set_global_var("show_info","<span class=\"Error_Message\">$show_info<br /></span>");	
	}
	set_global_var("count_total",$count_list);	
	set_global_var("show_onload_javascript","onkeypress=\"return noGlobalEnterKey(event)\"");
	set_global_var("print_object",get_html_from_layout("admin/html/admin_cellphone_carrier.html"));	
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
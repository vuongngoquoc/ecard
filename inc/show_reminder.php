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
	
	//acti tab
	$tab_data = "active in";
	$tab_add = ""; 
	if($show_add_table == 1)
	{
		$tab_add = "active in";
		$tab_data = "";
	}
	set_global_var('tab_add',$tab_add);
	set_global_var('tab_data',$tab_data);
	if($action=="add_new"){	
		if($cf_show_date_option =="0"){ //MM DD YYYY
			list($rm_month,$rm_day,$rm_year)=split("\/",$time_end_textbox);
		}
		elseif($cf_show_date_option =="1"){ //DD MM YYYY
			list($rm_day,$rm_month,$rm_year)=split("\/",$time_end_textbox);
		}
		elseif($cf_show_date_option =="2"){ //YYYY DD MM
			list($rm_year,$rm_day,$rm_month)=split("\/",$time_end_textbox);
		}
		elseif($cf_show_date_option =="3"){ //YYYY MM DD
			list($rm_year,$rm_month,$rm_day)=split("\/",$time_end_textbox);
		}
		
		$rm_time=mktime(0,0,0,$rm_month,$rm_day,$rm_year);
		$rm_time=adjust_timestamp_server($rm_time,$_SESSION[user_timezone]);
		$field_name ="(rm_title,rm_content,rm_user_name_id,rm_email,rm_datebefore,rm_repeat,rm_day,rm_month,rm_year,rm_time,rm_issend)";
		$field_value ="('$rm_title','$rm_content','$_SESSION[user_name_id]','$_SESSION[user_email]',$rm_datebefore,$rm_repeat,$rm_day,$rm_month,$rm_year,$rm_time,0)";
		insert_data_to_db("max_reminder",$field_name,$field_value);

		$show_info .="<div class=\"OK_Message\">$reminder_show_info_new_event_has_been_added</div><br />\n";
		$action="";
		$array_global_var_reminder[action]="";
	}	
	elseif($action=="delete_selected"){
		foreach($http_vars as $key=>$val){
			if(!(strpos($key,"mylist_id")===false)){ //if true
				$selected_id =str_replace("mylist_id","",$key);

				//Delete row in database
				delete_row("max_reminder","rm_id='$selected_id' LIMIT 1");
			}
		}
		$show_info .="<div class=\"OK_Message\">$reminder_show_info_your_event_updated</div><br />\n";
		$action="";
		$array_global_var_reminder[action]="";
	}
	elseif($action=="edit_me"){
		update_field_in_db("max_reminder","$edit_key",$edit_key_value,"$edit_id='$edit_id_value' and rm_user_name_id='$_SESSION[user_name_id]' LIMIT 1");		
		exit;
	}
	elseif($action=="update_event_date"){
		if($cf_show_date_option =="0"){ //MM DD YYYY
			list($rm_month,$rm_day,$rm_year)=split("\/",$time_end_textbox);
		}
		elseif($cf_show_date_option =="1"){ //DD MM YYYY
			list($rm_day,$rm_month,$rm_year)=split("\/",$time_end_textbox);
		}
		elseif($cf_show_date_option =="2"){ //YYYY DD MM
			list($rm_year,$rm_day,$rm_month)=split("\/",$time_end_textbox);
		}
		elseif($cf_show_date_option =="3"){ //YYYY MM DD
			list($rm_year,$rm_month,$rm_day)=split("\/",$time_end_textbox);
		}
		if (is_numeric($rm_month) && $rm_month >0 && $rm_month <= 12 && is_numeric($rm_day) && $rm_day >0 && $rm_day <= 31 && $rm_year >= $today_year){
			$rm_time=mktime(0,0,0,$rm_month,$rm_day,$rm_year);
			$rm_time=adjust_timestamp_server($rm_time,$_SESSION[user_timezone]);
			
			update_field_in_db2("max_reminder","rm_month='$rm_month',rm_day='$rm_day',rm_year='$rm_year',rm_time='$rm_time'","rm_id='$rm_id' and rm_user_name_id='$_SESSION[user_name_id]'");
		}
		exit;
	}

	if($row_number =="" || $row_number =="0" || !is_numeric($row_number)) $row_number = 15;
	$array_global_var_reminder[row_number]=$row_number;
	$row_per_page = $row_number;

	if ($page < 1 || $page=="") $page =1;
	$start = ($page-1)* 1 * $row_per_page;
	$end = $start + 1 * $row_per_page;
	
	if($show_user_id==""){
		$list_data =set_array_from_query("max_reminder","*","rm_user_name_id='$_SESSION[user_name_id]' Order by rm_time,rm_title LIMIT $start,$row_per_page");
		$count_list=get_dbvalue("max_reminder","count(rm_id)","rm_user_name_id='$_SESSION[user_name_id]'");
	}
	else{
		$list_data =set_array_from_query("max_reminder","*","rm_user_name_id='$_SESSION[user_name_id]' and rm_id='$show_user_id' Order by rm_time,rm_title LIMIT $start,$row_per_page");
		$count_list=get_dbvalue("max_reminder","count(rm_id)","rm_user_name_id='$_SESSION[user_name_id]' and rm_id='$show_user_id' ");
	}

	if ($end > $count_list) $end = $count_list;
	$xrow=0;
	$array_datebefore[0]="$addressbook_txt_reminder_me_on_date";
	$array_datebefore[1]="$addressbook_txt_reminder_me_1day_b4";
	$array_datebefore[2]="$addressbook_txt_reminder_me_2day_b4";
	$array_datebefore[3]="$addressbook_txt_reminder_me_3day_b4";
	$array_datebefore[7]="$addressbook_txt_reminder_me_7day_b4";
	$array_datebefore[14]="$addressbook_txt_reminder_me_14day_b4";
	$array_datebefore[30]="$addressbook_txt_reminder_me_30day_b4";

	$array_repeat[0]="$reminder_txt_no_repeat";
	$array_repeat[1]="$reminder_txt_repeat_week";
	$array_repeat[2]="$reminder_txt_repeat_month";
	$array_repeat[3]="$reminder_txt_repeat_year";

	for ($z=$start; $z<$end; $z++) {
		$val = $list_data[$xrow][rm_id] ;
		$row_data=$list_data[$xrow];

		//Show event name
		$show_event_name ="<textarea id=\"rm_title$val\" name=\"change_bkg\" title=\"$txt_tooltip_click_to_edit\" style=\"width:95%;height:100px;overflow:auto\" class=\"input_ajax_editable\" onfocus=\"original_value=this.value;if(document.getElementById('tr$val').className=='table_td_background'){this.className='input_ajax_editable_focus';}else{this.className='input_when_select_all_checkbox_checked';this.style.cursor='text';}\" onblur=\"if(document.getElementById('tr$val').className=='table_td_background'){this.className='input_ajax_editable';}else{this.className='input_when_select_all_checkbox_checked';this.style.cursor='pointer';}\" onchange=\"Editme('$ecard_url/index.php?step=$step&next_step=$next_step&action=edit_me&edit_id=rm_id&edit_id_value=$val&edit_key=rm_title&edit_key_value=',this.value,'1',original_value,this.id);\" />$row_data[rm_title]</textarea>";

		//Show event detail
		$show_event_detail ="<textarea id=\"rm_content$val\" name=\"change_bkg\" title=\"$txt_tooltip_click_to_edit\" style=\"width:95%;height:100px;overflow:auto\" class=\"input_ajax_editable\" onfocus=\"original_value=this.value;if(document.getElementById('tr$val').className=='table_td_background'){this.className='input_ajax_editable_focus';}else{this.className='input_when_select_all_checkbox_checked';this.style.cursor='text';}\" onblur=\"if(document.getElementById('tr$val').className=='table_td_background'){this.className='input_ajax_editable';}else{this.className='input_when_select_all_checkbox_checked';this.style.cursor='pointer';}\" onchange=\"Editme('$ecard_url/index.php?step=$step&next_step=$next_step&action=edit_me&edit_id=rm_id&edit_id_value=$val&edit_key=rm_content&edit_key_value=',this.value,'0',original_value,this.id);\" />$row_data[rm_content]</textarea>";

		//Show event date
		$rm_time=$row_data[rm_time];
		$rm_time=adjust_timestamp_user($rm_time,$_SESSION[user_timezone]);
		if($cf_show_date_option =="0"){ //MM DD YYYY
			$ins_date_caption="(MM/DD/YYYY)";
			$ins_date_data=date("n/j/Y",$rm_time);            
		}
		elseif($cf_show_date_option =="1"){ //DD MM YYYY
			$ins_date_caption="(DD/MM/YYYY)";
			$ins_date_data=date("j/n/Y",$rm_time);
		}
		elseif($cf_show_date_option =="2"){ //YYYY DD MM
			$ins_date_caption="(YYYY/DD/MM)";
			$ins_date_data=date("Y/j/n",$rm_time);
		}
		elseif($cf_show_date_option =="3"){ //YYYY MM DD
			$ins_date_caption="(YYYY/MM/DD)";
			$ins_date_data=date("Y/n/j",$rm_time);
		}
		if($isResponsive)
		{
		$strBr = '';
		$_onchange = "original_value=this.value;get_cid=$val;InsertDate($val,this.value);";
		$show_event_date="<input onchange=\"$_onchange\" class=\"datepicker input_ajax_editable\" readonly=\"readonly\" name=\"change_bkg\" id=\"time_end_textbox$val\" value=\"$ins_date_data\" style=\"width:75%\" title=\"$ins_date_caption\"/> <i class='fa fa-calendar'></i></div> ";
		}
		else
		{
		$show_event_date="<div id=\"show_popup_calendar$val\" style=\"cursor:pointer;\" title=\"$reminder_tooltip_click_to_edit_event_date\" onclick=\"original_value=document.getElementById('time_end_textbox$val').value;get_cid=$val;ShowDiv(this.id,'popup_calendar',0,0);info=document.getElementById('time_end_textbox$val').value.split('\/');cf_show_date_option='$cf_show_date_option';if(cf_show_date_option=='0'){selected_month=info[0];selected_day=info[1];selected_year=info[2];}else if(cf_show_date_option=='1'){selected_day=info[0];selected_month=info[1];selected_year=info[2];}else if(cf_show_date_option=='2'){selected_year=info[0];selected_day=info[1];selected_month=info[2];}else if(cf_show_date_option=='3'){selected_year=info[0];selected_month=info[1];selected_day=info[2];};frames['calendar_frame'].location.href='$ecard_url/index.php?step=calendar&year_from=$today_year&year_to=$next_10year&mode=0&month='+selected_month+'&year='+selected_year+'&selected_day='+selected_day+'&selected_month='+selected_month+'&selected_year='+selected_year\"><input class=\"input_ajax_editable\" readonly=\"readonly\" name=\"change_bkg\" id=\"time_end_textbox$val\" value=\"$ins_date_data\" style=\"width:75px\" title=\"$ins_date_caption\"/> <img border=\"0\" alt=\"\" style=\"vertical-align:middle\" src=\"$ecard_url/templates/$cf_set_template/icon_calendar.gif\" /></div> ";
		$strBr = '<br />';
		}
		
		//Show date before
		$show_event_date.="$strBr<select title=\"$addressbook_txt_reminder_me\" onchange=\"Editme('$ecard_url/index.php?step=$step&next_step=$next_step&action=edit_me&edit_id=rm_id&edit_id_value=$val&edit_key=rm_datebefore&edit_key_value=',this.value,'1',original_value,this.id);\" size=\"1\" style=\"width:100%\" name=\"rm_datebefore$val\" id=\"rm_datebefore$val\">";
		foreach($array_datebefore as $datebefore_key=>$datebefore_val){
			if($datebefore_key==$row_data[rm_datebefore]){
				$show_event_date.="<option selected=\"selected\" value=\"$datebefore_key\">$datebefore_val</option>";
			}
			else{
				$show_event_date.="<option value=\"$datebefore_key\">$datebefore_val</option>";
			}
		}
		$show_event_date.="</select>";

		//Show repeat
		$show_event_date.="$strBr<br /><select title=\"$reminder_txt_repeat\" onchange=\"Editme('$ecard_url/index.php?step=$step&next_step=$next_step&action=edit_me&edit_id=rm_id&edit_id_value=$val&edit_key=rm_repeat&edit_key_value=',this.value,'1',original_value,this.id);\" size=\"1\" name=\"rm_repeat$val\" id=\"rm_repeat$val\">";
		foreach($array_repeat as $repeat_key=>$repeat_val){
			if($repeat_key==$row_data[rm_repeat]){
				$show_event_date.="<option selected=\"selected\" value=\"$repeat_key\">$repeat_val</option>";
			}
			else{
				$show_event_date.="<option value=\"$repeat_key\">$repeat_val</option>";
			}
		}
		$show_event_date.="</select>";	

		//Show Frequency

		//Show delete button
		if($isResponsive)
		{
			$percent_1 = 40;
			$percent_2 = 40;
			$percent_3 = '*';
			$show_delete_button="<button onclick=\"document.getElementById('bk$val').checked='true';single_check_uncheck('tr$val','bk$val');CheckSelected();\" border=\"0\" src=\"$ecard_url/templates/$cf_set_template/icon_delete.gif\" title=\"$reminder_txt_event_delete\" class='btn btn-xs btn-default'><i class='fa fa-remove'></i></button>";
		}
		else
		{
			$percent_1 = 50;
			$percent_2 = 47;
			$percent_3 = '1%';
			$show_delete_button="<img onclick=\"document.getElementById('bk$val').checked='true';single_check_uncheck('tr$val','bk$val');CheckSelected();\" border=\"0\" src=\"$ecard_url/templates/$cf_set_template/icon_delete.gif\" style=\"cursor:pointer\" alt=\"$reminder_txt_event_delete\" title=\"$reminder_txt_event_delete\" />";
		}
		
		
		$show_list_table .="<tr id=\"tr$val\" class=\"table_td_background\">\n";
		$show_list_table .="<td width=\"$percent_1%\" class=\"rowdata\">$show_event_name</td>\n";
		$show_list_table .="<td width=\"$percent_2%\" class=\"rowdata\">$show_event_detail</td>\n";
		$show_list_table .="<td width=\"$percent_3\" class=\"rowdata event-date\">$show_event_date</td>\n";
		$show_list_table .="<td width=\"1%\" align=\"center\" class=\"rowdata\">$show_delete_button</td>\n";
		$show_list_table .="<td width=\"1%\" align=\"center\" class=\"rowdata\"><input class=\"input_ajax_editable\" onclick=\"single_check_uncheck('tr$val','bk$val');\" type=\"checkbox\" id=\"bk$val\" name=\"mylist_id$val\" value=\"$val\" /></td>\n";
		$show_list_table .="</tr>\n";
		$bk_id .="$val,";
		$xrow++;
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
				$dpn ="<a href=\"$ecard_url/index.php?step=$step&next_step=$next_step&row_number=$row_number&page=$page_pr\">&laquo;</a>";
				$display_page_number = str_replace("{A}", $dpn, $display_page_number);
			}
			else{
				$display_page_number = str_replace("{A}", "&laquo;", $display_page_number);
			}
			$y=get_global_var("d_num");
			if ($page < $y) {
				$page_ne = $page + 1 ;				
				$display_page_number = str_replace("{B}", "<a href=\"$ecard_url/index.php?step=$step&next_step=$next_step&row_number=$row_number&page=$page_ne\">&raquo;</a>", $display_page_number);
			}	
			else{
				$display_page_number = str_replace("{B}", "&raquo;", $display_page_number);
			}
		}
	}
	$show_onload_javascript="onkeypress=\"return noGlobalEnterKey(event)\"";
	$show_my_email=$_SESSION[user_email];
	if($_SESSION[user_cellphone_active]=="1")$show_my_email.=" + <img border=\"0\" alt=\"\" src=\"$ecard_url/templates/$cf_set_template/icon_cellphone.gif\" style=\"vertical-align:middle\"/> $_SESSION[user_cellphone_number]";
	$show_today_date="$today_mon/$today_mday/$today_year";
	
	//Show/Hide Add reminder form
	if($show_add_table=="1"){
		$display_none_block="display:block";
	}
	else{
		$display_none_block="display:none";
	}

	//Pass date from calendar to add form
	if($show_time!=""){
		$rm_time_value=$show_time;
	}
	else{
		if($cf_show_date_option =="0"){ //MM DD YYYY
			$rm_time_value="(MM/DD/YYYY)";
		}
		elseif($cf_show_date_option =="1"){ //DD MM YYYY
			$rm_time_value="(DD/MM/YYYY)";
		}
		elseif($cf_show_date_option =="2"){ //YYYY DD MM
			$rm_time_value="(YYYY/DD/MM)";
		}
		elseif($cf_show_date_option =="3"){ //YYYY MM DD
			$rm_time_value="(YYYY/MM/DD)";
		}
	}

	set_global_var2($array_global_var_reminder);

	//Display random banner HR & VT
	print_banner("0");
	print_banner("1");	

	//Show event date
	if($cf_show_date_option =="0"){ //MM DD YYYY
		$ins_date_caption="(MM/DD/YYYY)";
	}
	elseif($cf_show_date_option =="1"){ //DD MM YYYY
		$ins_date_caption="(DD/MM/YYYY)";
	}
	elseif($cf_show_date_option =="2"){ //YYYY DD MM
		$ins_date_caption="(YYYY/DD/MM)";
	}
	elseif($cf_show_date_option =="3"){ //YYYY MM DD
		$ins_date_caption="(YYYY/MM/DD)";
	}

	$array_global_var[print_object]=get_html_from_layout("templates/$cf_set_template/show_reminder.html");
	print_header_and_footer();
	
	//--------------------------------------------------------------------------------------
	function get_page_count_number2($page,$b){
		global $ecard_url,$step,$next_step,$row_number;
			
		$url="$ecard_url/index.php?step=$step&next_step=$next_step&row_number=$row_number";
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
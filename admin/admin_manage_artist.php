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
	

	if($what=="delete_selected"){
		foreach($http_vars as $key=>$val){
			if(!(strpos($key,"mylist_id")===false)){ //if true
				$selected_id =str_replace("mylist_id","",$key);				

				//Delete row in database
				delete_row("max_ecardsent","cs_id='$selected_id' LIMIT 1");
			}
		}
	}

	$keyword=stripslashes(trim($keyword));
	$keyword=str_replace("'","",$keyword);
	$keyword=str_replace("\"","",$keyword);
	$keyword2=urlencode($keyword);

	if($row_number =="" || $row_number =="0" || !is_numeric($row_number)) $row_number = 15;
	set_global_var("row_number",$row_number);
	$row_per_page = $row_number;
				
	if ($page < 1 || $page=="") $page =1;
	$start = ($page-1)* 1 * $row_per_page;
	$end = $start + 1 * $row_per_page;

	set_global_var("selected_list_item_" . $list_item,"selected=\"selected\"");
	set_global_var("selected_search_field_" . $search_field,"selected=\"selected\"");
	set_global_var("selected_num_day_" . $num_day,"selected=\"selected\"");
	set_global_var("selected_num_what_" . $num_what,"selected=\"selected\"");
	
	$total_cards=get_dbvalue("max_ecardsent","count(cs_id)");
	set_global_var("total_cards",$total_cards);

	$query_what="cs_id,cs_ec_id,cs_fmail,cs_fname,cs_from_email,cs_from_name,cs_date_create,cs_pkdate,cs_sender_ip";
	if($cmd_button =="List"){
		if($list_item == "all"){
			$list_data =set_array_from_query("max_ecardsent","$query_what","cs_ec_id<>'' Order by cs_date_create DESC LIMIT $start,$row_per_page");
			$count_list=get_dbvalue("max_ecardsent","count(cs_id)","cs_ec_id<>''");
			$ecard_log_txt_list_all_cards=str_replace("%total_cards%",$total_cards,$ecard_log_txt_list_all_cards);
			$show_info =$ecard_log_txt_list_all_cards;
		}
		elseif($list_item == "new_today"){
			$list_data =set_array_from_query("max_ecardsent","$query_what","cs_date_create >= $begin_today_timestamp and cs_date_create <= $end_today_timestamp Order by cs_date_create LIMIT $start,$row_per_page");
			$count_list=get_dbvalue("max_ecardsent","count(cs_id)","cs_date_create >= $begin_today_timestamp and cs_date_create <= $end_today_timestamp");
			$ecard_log_txt_show_cards_created_today=str_replace("%count_list%",$count_list,$ecard_log_txt_show_cards_created_today);
			$ecard_log_txt_show_cards_created_today=str_replace("%begin_today_timestamp%",DateFormat($begin_today_timestamp),$ecard_log_txt_show_cards_created_today);
			$ecard_log_txt_show_cards_created_today=str_replace("%end_today_timestamp%",DateFormat($begin_today_timestamp),$ecard_log_txt_show_cards_created_today);
			$show_info =$ecard_log_txt_show_cards_created_today;
		}
		elseif($list_item == "new_yesterday"){
			$list_data =set_array_from_query("max_ecardsent","$query_what","cs_date_create >= $begin_yesterday_timestamp and cs_date_create <= $end_yesterday_timestamp Order by cs_date_create LIMIT $start,$row_per_page");
			$count_list=get_dbvalue("max_ecardsent","count(cs_id)","cs_date_create >= $begin_yesterday_timestamp and cs_date_create <= $end_yesterday_timestamp");
			$ecard_log_txt_show_cards_created_yesterday=str_replace("%count_list%",$count_list,$ecard_log_txt_show_cards_created_yesterday);
			$ecard_log_txt_show_cards_created_yesterday=str_replace("%begin_yesterday_timestamp%",DateFormat($begin_yesterday_timestamp),$ecard_log_txt_show_cards_created_yesterday);
			$ecard_log_txt_show_cards_created_yesterday=str_replace("%end_yesterday_timestamp%",DateFormat($end_yesterday_timestamp),$ecard_log_txt_show_cards_created_yesterday);
			$show_info =$ecard_log_txt_show_cards_created_yesterday;
		}
		elseif($list_item == "new_week"){
			$list_data =set_array_from_query("max_ecardsent","$query_what","cs_date_create >= $begin_this_week_timestamp and cs_date_create <= $end_this_week_timestamp Order by cs_date_create LIMIT $start,$row_per_page");
			$count_list=get_dbvalue("max_ecardsent","count(cs_id)","cs_date_create >= $begin_this_week_timestamp and cs_date_create <= $end_this_week_timestamp");
			$ecard_log_txt_show_cards_created_this_week=str_replace("%count_list%",$count_list,$ecard_log_txt_show_cards_created_this_week);
			$ecard_log_txt_show_cards_created_this_week=str_replace("%begin_this_week_timestamp%",DateFormat($begin_this_week_timestamp),$ecard_log_txt_show_cards_created_this_week);
			$ecard_log_txt_show_cards_created_this_week=str_replace("%end_this_week_timestamp%",DateFormat($end_this_week_timestamp),$ecard_log_txt_show_cards_created_this_week);
			$show_info =$ecard_log_txt_show_cards_created_this_week;
		}
		elseif($list_item == "new_month"){
			$list_data =set_array_from_query("max_ecardsent","$query_what","cs_date_create >= $begin_this_month_timestamp and cs_date_create <= $end_this_month_timestamp Order by cs_date_create LIMIT $start,$row_per_page");
			$count_list=get_dbvalue("max_ecardsent","count(cs_id)","cs_date_create >= $begin_this_month_timestamp and cs_date_create <= $end_this_month_timestamp");
			$ecard_log_txt_show_cards_created_this_month=str_replace("%count_list%",$count_list,$ecard_log_txt_show_cards_created_this_month);
			$ecard_log_txt_show_cards_created_this_month=str_replace("%begin_this_month_timestamp%",DateFormat($begin_this_month_timestamp),$ecard_log_txt_show_cards_created_this_month);
			$ecard_log_txt_show_cards_created_this_month=str_replace("%end_this_month_timestamp%",DateFormat($end_this_month_timestamp),$ecard_log_txt_show_cards_created_this_month);
			$show_info =$ecard_log_txt_show_cards_created_this_month;
		}
		elseif($list_item == "not_pickup"){
			$list_data =set_array_from_query("max_ecardsent","$query_what","cs_pkdate='0' Order by cs_date_create LIMIT $start,$row_per_page");
			$count_list=get_dbvalue("max_ecardsent","count(cs_id)","cs_pkdate='0' ");
			$ecard_log_txt_show_cards_were_not_picked_up=str_replace("%count_list%",$count_list,$ecard_log_txt_show_cards_were_not_picked_up);
			$show_info =$ecard_log_txt_show_cards_were_not_picked_up;
		}
	}
	elseif($cmd_button =="Search"){
		if($search_field == "all"){
			$cond= " cs_message like '%$keyword%' or cs_from_name like '%$keyword%' or cs_from_email like '%$keyword%' or cs_fname like '%$keyword%' or cs_fmail like '%$keyword%' ";
			$info=split(" ",$keyword);
			foreach($info as $key){
				$cond .= " or cs_message like '%$key%' or cs_from_name like '%$key%' or cs_from_email like '%$key%' or cs_fname like '%$key%' or cs_fmail like '%$key%' ";
			}			
		}
		elseif($search_field == "cs_from_name"){
			$cond= " cs_from_name like '%$keyword%' ";
			$info=split(" ",$keyword);
			foreach($info as $key){
				$cond .= " or cs_from_name like '%$key%' ";
			}
		}
		elseif($search_field == "cs_from_email"){
			$cond= " cs_from_email like '%$keyword%' ";
			$info=split(" ",$keyword);
			foreach($info as $key){
				$cond .= " or cs_from_email like '%$key%' ";
			}
		}
		elseif($search_field == "cs_fname"){
			$cond= " cs_fname like '%$keyword%' ";
			$info=split(" ",$keyword);
			foreach($info as $key){
				$cond .= " or cs_fname like '%$key%' ";
			}
		}
		elseif($search_field == "cs_fmail"){
			$cond= " cs_fmail like '%$keyword%' ";
			$info=split(" ",$keyword);
			foreach($info as $key){
				$cond .= " or cs_fmail like '%$key%' ";
			}
		}
		elseif($search_field == "cs_message"){
			$cond= " cs_message like '%$keyword%' ";
			$info=split(" ",$keyword);
			foreach($info as $key){
				$cond .= " or cs_message like '%$key%' ";
			}
		}
		
		$list_data =set_array_from_query("max_ecardsent","$query_what"," $cond Order by cs_date_create LIMIT $start,$row_per_page");
		$count_list=get_dbvalue("max_ecardsent","count(cs_id)"," $cond ");
		$ecard_log_txt_search_card_log=str_replace("%keyword2%",urldecode($keyword2),$ecard_log_txt_search_card_log);
		$ecard_log_txt_search_card_log=str_replace("%count_list%",$count_list,$ecard_log_txt_search_card_log);
		$show_info =$ecard_log_txt_search_card_log;
	}
	elseif($cmd_button =="View"){
		if($num_what =="day"){
			$get_day_before = $num_day;
		}
		elseif($num_what =="week"){
			$get_day_before = $num_day * 7;
		}
		elseif($num_what =="month"){
			$get_day_before = $num_day * $day31;
		}
		elseif($num_what =="year"){
			$get_day_before = $num_day * 365;
		}
		
		$begin_time_before = $begin_today_timestamp - (86400 * $get_day_before);
		$list_data =set_array_from_query("max_ecardsent","$query_what","cs_ec_id<>'' and cs_date_create >= $begin_time_before and cs_date_create <= $end_today_timestamp Order by cs_date_create LIMIT $start,$row_per_page");
		$count_list=get_dbvalue("max_ecardsent","count(cs_id)","cs_ec_id<>'' and cs_date_create >= $begin_time_before and cs_date_create <= $end_today_timestamp");
		$ecard_log_txt_show_cards_created_before_today=str_replace("%num_day%",$num_day,$ecard_log_txt_show_cards_created_before_today);
		$ecard_log_txt_show_cards_created_before_today=str_replace("%num_what%",$num_what,$ecard_log_txt_show_cards_created_before_today);
		$ecard_log_txt_show_cards_created_before_today=str_replace("%count_list%",$count_list,$ecard_log_txt_show_cards_created_before_today);
		$ecard_log_txt_show_cards_created_before_today=str_replace("%begin_time_before%",DateFormat($begin_time_before),$ecard_log_txt_show_cards_created_before_today);
		$ecard_log_txt_show_cards_created_before_today=str_replace("%end_today_timestamp%",DateFormat($end_today_timestamp),$ecard_log_txt_show_cards_created_before_today);
		$show_info =$ecard_log_txt_show_cards_created_before_today;
	}
	elseif($cmd_button =="Go"){
		$from_timestamp_temp=gmmktime(0,0,0,$from_month,$from_day,$from_year);
		$to_timestamp_temp=gmmktime(23,59,59,$to_month,$to_day,$to_year);
		if($to_timestamp_temp < $from_timestamp_temp){
			$from_timestamp=$to_timestamp_temp;
			$to_timestamp=$from_timestamp_temp;		
		}
		else{
			$from_timestamp=$from_timestamp_temp;
			$to_timestamp=$to_timestamp_temp;
		}
		$list_data =set_array_from_query("max_ecardsent","$query_what","cs_ec_id<>'' and cs_date_create >= $from_timestamp and cs_date_create <= $to_timestamp Order by cs_date_create LIMIT $start,$row_per_page");
		$count_list=get_dbvalue("max_ecardsent","count(cs_id)","cs_ec_id<>'' and cs_date_create >= $from_timestamp and cs_date_create <= $to_timestamp");
		$ecard_log_txt_show_card_created_from_to=str_replace("%count_list%",$count_list,$ecard_log_txt_show_card_created_from_to);
		$ecard_log_txt_show_card_created_from_to=str_replace("%from_timestamp%",DateFormat($from_timestamp),$ecard_log_txt_show_card_created_from_to);
		$ecard_log_txt_show_card_created_from_to=str_replace("%to_timestamp%",DateFormat($to_timestamp),$ecard_log_txt_show_card_created_from_to);
		$show_info =$ecard_log_txt_show_card_created_from_to;
	}
	else{
		$list_data =set_array_from_query("max_ecardsent","$query_what","cs_ec_id<>'' Order by cs_date_create LIMIT $start,$row_per_page");
		$count_list=get_dbvalue("max_ecardsent","count(cs_id)","cs_ec_id<>'' ");
		$ecard_log_txt_total_cards_log=str_replace("%total_cards%",$total_cards,$ecard_log_txt_total_cards_log);
		$show_info=$ecard_log_txt_total_cards_log;
	}

	set_global_var("show_info","<strong>$show_info</strong><br />");
	
	$keyword=$keyword2;
	set_global_var("keyword",urldecode($keyword));

	if ($end > $count_list) $end = $count_list;
	$show_list_table="";
	$xrow=0;	
	for ($z=$start; $z<$end; $z++) {
		$val = $list_data[$xrow][cs_id] ;
		$row_data=$list_data[$xrow];		
		
		//IP 2 Location
		$array_country_info=ip2location($row_data[cs_sender_ip]);
		if($array_country_info[ip_country2]){
			$ecard_log_txt_ip2country=str_replace("%country_flag%","$ecard_url/resource/flags/$array_country_info[ip_country2].gif",$ecard_log_txt_ip2country);
			$ecard_log_txt_ip2country=str_replace("%ip_country%","$array_country_info[ip_country]",$ecard_log_txt_ip2country);
			$ecard_log_txt_ip2country=str_replace("%ip_country_name%","$array_country_info[ip_country_name]",$ecard_log_txt_ip2country);
			$ip2country=$ecard_log_txt_ip2country;
		}
		else{
			$ip2country="";
		}

		//Show thumbnail
		$ec_row=get_row("max_ecard","ec_thumbnail,ec_cat_dir","ec_id='$row_data[cs_ec_id]'");
		if(file_exists("$ecard_root/resource/picture/$ec_row[ec_cat_dir]/$ec_row[ec_thumbnail]") && $ec_row[ec_thumbnail]!=""){
			$show_thumbnail="<a href=\"$ecard_url/index.php?step=pickup&cs_id=$val&action=viewcopy\" target=\"_blank\" title=\"$ecard_log_tooltip_click_here_to_preview_this_card\"><img border=\"0\" alt=\"\" src=\"$ecard_url/resource/picture/$ec_row[ec_cat_dir]/$ec_row[ec_thumbnail]\" style=\"border:1px solid silver;\" /></a>";
		}
		else{
			$show_thumbnail="<a href=\"$ecard_url/index.php?step=pickup&cs_id=$val&action=viewcopy\" target=\"_blank\" title=\"$ecard_log_tooltip_click_here_to_preview_this_card\"><div style=\"cursor:pointer;border:2px solid black;width:$cf_thumb_width_member_card px;line-height:$cf_thumb_height_member_card px;background-color:lightyellow\">$ecard_log_txt_no_thumbnail</div></a>";
		}
		
		//Show sender name + email
		if ($cf_hide_email_confidential) { $row_data[cs_from_email]="[$ecard_log_txt_confidential]"; }		
		$show_from="<strong>$row_data[cs_from_name]</strong><br />$row_data[cs_from_email]";

		//Show receiver name + email
		if ($cf_hide_email_confidential) { $row_data[cs_fmail]="[$ecard_log_txt_confidential]"; }
		$show_to="<strong>$row_data[cs_fname]</strong><br />$row_data[cs_fmail]";

		//Show card date created
		$show_time_created=DateFormat(adjust_timestamp_user($row_data[cs_date_create],$cf_timezone),2);

		//Show date pickup
		if($row_data[cs_pkdate]=="0"){
			$show_pkdate="<span class=\"Error_Message\">$ecard_log_message_not_pick_up_yet</span>";
		}
		else{
			$show_pkdate=DateFormat(adjust_timestamp_user($row_data[cs_pkdate],$cf_timezone),2);
		}

		//Show delete button
		$show_delete_button="<img onclick=\"document.getElementById('tr$val').style.backgroundColor='#E4E4D3';document.getElementById('bk$val').checked='true';CheckSelected();\" border=\"0\" src=\"html/07_icon_delete.gif\" style=\"cursor:pointer\" alt=\"$ecard_log_tooltip_delete\" title=\"$ecard_log_tooltip_delete\" />";

		$show_list_table .="<tr id=\"tr$val\" style=\"background-color: #EAEAEA;line-height:20px\">\n";
		$show_list_table .="<td width=\"1%\" align=\"center\" style=\"padding:4px;\">$show_thumbnail<br /><span style=\"font-size:8pt;color:green\">$val</span></td>\n";
		$show_list_table .="<td width=\"*\" style=\"padding:4px;\">$show_from</td>\n";
		$show_list_table .="<td width=\"*\" style=\"padding:4px;\">$show_to</td>\n";
		$show_list_table .="<td width=\"1%\" align=\"center\" style=\"padding:4px;white-space:nowrap\">$show_time_created</td>\n";
		$show_list_table .="<td width=\"1%\" align=\"center\" style=\"padding:4px;white-space:nowrap\">$show_pkdate</td>\n";
		$show_list_table .="<td width=\"1%\" align=\"center\">$show_delete_button</td>\n";
		$show_list_table .="<td width=\"1%\" align=\"center\"><input onclick=\"if(this.checked){document.getElementById('tr$val').style.backgroundColor='#E4E4D3';}else{document.getElementById('tr$val').style.backgroundColor='#EAEAEA';}\" type=\"checkbox\" id=\"bk$val\" name=\"mylist_id$val\" value=\"$val\" /></td>\n";
		$show_list_table .="</tr>\n";
		$bk_id .="$val,";
		$xrow++;
	}
	set_global_var("show_list_table",$show_list_table);
	
	if($bk_id{strlen($bk_id)-1} ==",") $bk_id = substr($bk_id, 0, strlen($bk_id)-1);
	set_global_var("bk_id",$bk_id);
	
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
				$dpn ="<a href=\"index.php?step=$step&what=$what&row_number=$row_number&page=$page_pr&what2=$what2&cmd_button=$cmd_button&list_item=$list_item&search_field=$search_field&keyword=$keyword&num_day=$num_day&num_what=$num_what&from_month=$from_month&from_day=$from_day&from_year=$from_year&to_day=$to_day&to_month=$to_month&to_year=$to_year\"><img border=0 src=html/prv.gif style='vertical-align:middle' title='Page # $page_pr' alt='Page # $page_pr' /></a>";
				$display_page_number = str_replace("{A}", $dpn, $display_page_number);
			}
			else{
				$display_page_number = str_replace("{A}", "<img src=html/prv_disable.gif alt='' style='vertical-align:middle' />", $display_page_number);
			}
			$y=get_global_var("d_num");
			if ($page < $y) {
				$page_ne = $page + 1 ;				
				$display_page_number = str_replace("{B}", "<a href=\"index.php?step=$step&what=$what&row_number=$row_number&page=$page_ne&what2=$what2&cmd_button=$cmd_button&list_item=$list_item&search_field=$search_field&keyword=$keyword&num_day=$num_day&num_what=$num_what&from_month=$from_month&from_day=$from_day&from_year=$from_year&to_day=$to_day&to_month=$to_month&to_year=$to_year\"><img border=0 src=html/next.gif style='vertical-align:middle' title='Page # $page_ne' alt='Page # $page_ne' /></a>", $display_page_number);
			}	
			else{
				$display_page_number = str_replace("{B}", "<img src=html/next_disable.gif alt='' style='vertical-align:middle' />", $display_page_number);
			}
		}
	}
	set_global_var("display_page_number",$display_page_number);	 
		
	print_mondayyear_dropdown("from_month","from_day","from_year","print_mon_day_year_dropdown_from");
	print_mondayyear_dropdown("to_month","to_day","to_year","print_mon_day_year_dropdown_to");
	print_mondayyear_dropdown("cl_month","cl_day","cl_year","print_mon_day_year_dropdown");
	
	$ecard_log_txt_page_title=str_replace("%total_cards%",$total_cards,$ecard_log_txt_page_title);
	set_global_var("ecard_log_txt_page_title",$ecard_log_txt_page_title);
	
	$ecard_log_view_all_cards_from_to=str_replace("%print_mon_day_year_dropdown_from%",$print_mon_day_year_dropdown_from,$ecard_log_view_all_cards_from_to);
	$ecard_log_view_all_cards_from_to=str_replace("%print_mon_day_year_dropdown_to%",$print_mon_day_year_dropdown_to,$ecard_log_view_all_cards_from_to);
	set_global_var("ecard_log_view_all_cards_from_to",$ecard_log_view_all_cards_from_to);
	
	set_global_var("show_onload_javascript","onkeypress=\"return noGlobalEnterKey(event)\"");
	set_global_var("print_object",get_html_from_layout("admin/html/admin_manage_ecard_log.html"));
	print_admin_header_footer_page();

	//---------------------------------------------------------------------------------------------------------	
	function print_mondayyear_dropdown($mon_fieldname,$mday_fieldname,$year_fieldname,$set_what){
		global $today_mon,$today_mday,$today_year,$cf_show_date_option;

		$mon_fieldname_val = get_global_var($mon_fieldname);
		$mday_fieldname_val = get_global_var($mday_fieldname);
		$year_fieldname_val =get_global_var($year_fieldname);
		
		if($mon_fieldname_val =="")
			$mon_fieldname_val = $today_mon;

		if($mday_fieldname_val =="")
			$mday_fieldname_val = $today_mday;

		if($year_fieldname_val =="")
			$year_fieldname_val = $today_year;

		$dropdown_month="<select name=\"$mon_fieldname\" id=\"$mon_fieldname\" size=\"1\">\n";
		for($i=1;$i<=12;$i++){
			$val = $i;
			$val =str_replace("10","October",$val);
			$val =str_replace("11","November",$val);
			$val =str_replace("12","December",$val);
			$val =str_replace("1","January",$val);
			$val =str_replace("2","Febuary",$val);
			$val =str_replace("3","March",$val);
			$val =str_replace("4","April",$val);
			$val =str_replace("5","May",$val);
			$val =str_replace("6","June",$val);
			$val =str_replace("7","July",$val);
			$val =str_replace("8","August",$val);
			$val =str_replace("9","September",$val);

			if($mon_fieldname_val == $i){
				$dropdown_month.="<option selected=\"selected\" value=\"$i\">$i - $val</option>\n";
			}
			else{
				$dropdown_month.="<option value=\"$i\">$i - $val</option>\n";
			}
		}
		$dropdown_month.="</select>";
		
		$dropdown_mday="<select name=\"$mday_fieldname\" id=\"$mday_fieldname\" size=\"1\">\n";
		for($i=1;$i<=31;$i++){
			if($mday_fieldname_val == $i){
				$dropdown_mday.="<option selected=\"selected\" value=\"$i\">$i</option>\n";
			}
			else{
				$dropdown_mday.="<option value=\"$i\">$i</option>\n";
			}
		}
		$dropdown_mday.="</select>";

		$dropdown_year="<select name=\"$year_fieldname\" id=\"$year_fieldname\" size=\"1\">\n";		

		if ($set_what == "print_mon_day_year_dropdown"){
			$start_yr = $today_year ;
			$end_yr = $today_year + 5;
		}
		else{
			$start_yr = 2003 ;
			$end_yr = $today_year;
		}	
		
		for($i=$start_yr;$i<=$end_yr;$i++){
			if($year_fieldname_val == $i){
				$dropdown_year.="<option selected=\"selected\" value=\"$i\">$i</option>\n";
			}
			else{
				$dropdown_year.="<option value=\"$i\">$i</option>\n";
			}
		}
		$dropdown_year.="</select>";

		if($cf_show_date_option == "0"){
			set_global_var("$set_what","$dropdown_month $dropdown_mday $dropdown_year");
		}
		elseif($cf_show_date_option == "1"){
			set_global_var("$set_what","$dropdown_mday $dropdown_month $dropdown_year");
		}
		elseif($cf_show_date_option == "2"){
			set_global_var("$set_what","$dropdown_year $dropdown_mday $dropdown_month");
		}
		elseif($cf_show_date_option == "3"){
			set_global_var("$set_what","$dropdown_year $dropdown_month $dropdown_mday");
		}
	}

	//--------------------------------------------------------------------------------------
	function get_page_count_number($page,$b){
		global $step,$what,$row_number,$what2,$cmd_button,$list_item,$search_field,$keyword,$num_day,$num_what,$from_month,$from_day,$from_year,$to_day,$to_month,$to_year;
			
		$url="index.php?step=$step&what=$what&row_number=$row_number&what2=$what2&cmd_button=$cmd_button&list_item=$list_item&search_field=$search_field&keyword=$keyword&num_day=$num_day&num_what=$num_what&from_month=$from_month&from_day=$from_day&from_year=$from_year&to_day=$to_day&to_month=$to_month&to_year=$to_year";
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
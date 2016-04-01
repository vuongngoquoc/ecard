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
		
	if ($row_number ==""){
		$row_number = 50;
		set_global_var("row_number","50");
	}	
	
	$row_per_page = $row_number;
	if($search_year =="") $search_year = $today_year;

	if ($page < 1 || $page=="") $page =1;
	$start = ($page-1)* 1 * $row_per_page;
	$end = $start + 1 * $row_per_page;
	$list_data =set_array_from_query("max_search_keyword","*","search_year ='$search_year' Order by search_keyword ASC LIMIT $start,$row_per_page");
	$count_list=get_dbvalue("max_search_keyword","count(search_id)","search_year ='$search_year'");
	set_global_var("total_keyword",$count_list);

	$show_list_table="";
	if ($end > $count_list) $end = $count_list;
	$xrow=0;
	for ($z=$start; $z<$end; $z++) {
		$val = $list_data[$xrow][search_id] ;
		$row_data=$list_data[$xrow];
		$count_key_ecard = $row_data[search_count_ecard];
		$count_key_invite = $row_data[search_count_invite];
		$show_list_table .="<tr id=\"tr$val\" style=\"background-color: #EAEAEA;line-height:20px\">\n";	
		$show_list_table .="<td align=left>$row_data[search_keyword]</td>\n";
		$show_list_table .="<td align=center>$count_key_ecard</td>\n";
		$show_list_table .="<td align=center>$count_key_invite</td>\n";
		$show_list_table .="</tr>\n";		
		$xrow++;
	}
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
				$dpn ="<a href=\"index.php?step=$step&what=$what&row_number=$row_number&search_year=$search_year&page=$page_pr\"><img border=0 src=html/prv.gif align='absmiddle' title='Page # $page_pr' /></a>";
				$display_page_number = str_replace("{A}", $dpn, $display_page_number);
			}
			else{
				$display_page_number = str_replace("{A}", "<img src=html/prv_disable.gif />", $display_page_number);
			}
			$y=get_global_var("d_num");
			if ($page < $y) {
				$page_ne = $page + 1 ;				
				$display_page_number = str_replace("{B}", "<a href=\"index.php?step=$step&what=$what&row_number=$row_number&search_year=$search_year&page=$page_ne\"><img border=0 src=html/next.gif align='absmiddle' title='Page # $page_ne' /></a>", $display_page_number);
			}	
			else{
				$display_page_number = str_replace("{B}", "<img src=html/next_disable.gif />", $display_page_number);
			}
		}
	}
	set_global_var("display_page_number",$display_page_number);	

	//Print Sort by year drop down menu
	$list_year=get_dblistvalue("max_search_keyword","search_year","search_year > '0' Order by search_year DESC");
	$list_year = array_unique($list_year);
	$sort_by_year ="<select size=1 name=search_year id=\"search_year\" onchange=\"document.form1.submit();\">\n";
	foreach($list_year as $val){
		if($search_year == $val){
			$sort_by_year .="<option selected value='$val'>$val</option>\n";
		}
		else{
			$sort_by_year .="<option value='$val'>$val</option>\n";
		}
	}
	$sort_by_year .="</select>";
	
	set_global_var("sort_by_year",$sort_by_year);
	set_global_var("selected_sort_" . $sort,"selected");
	
	set_global_var("show_onload_javascript","onkeypress=\"return noGlobalEnterKey(event)\"");
	set_global_var("print_object",get_html_from_layout("admin/html/show_keywordlog.html"));
	print_admin_header_footer_page();
	exit;

	//--------------------------------------------------------------------------------------
	function get_page_count_number($page,$b){
		global $step,$what,$row_number,$what2,$search_year;
			
		$url="index.php?step=$step&what=$what&row_number=$row_number&search_year=$search_year";
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
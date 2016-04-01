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
	
	$list_data =set_array_from_query("max_ecard","*","ec_time_used != '0' Order by ec_time_used DESC LIMIT $start,$row_per_page");
	$count_list=get_dbvalue("max_ecard","count(ec_id)","ec_time_used != '0' Order by ec_time_used DESC ");
	
	if ($end > $count_list) $end = $count_list;
	$show_list_table="";
	$xrow=0;
	
	for ($z=$start; $z<$end; $z++) {
		$val = $list_data[$xrow][ec_id];
		$row_data=$list_data[$xrow];
		
		//Show thumbnail
		$ec_row=get_row("max_ecard","ec_thumbnail,ec_cat_dir,ec_cat_id,ec_time_used","ec_id='$row_data[ec_id]'");
		if(file_exists("$ecard_root/resource/picture/$ec_row[ec_cat_dir]/$ec_row[ec_thumbnail]") && $ec_row[ec_thumbnail]!=""){
			$show_thumbnail="<img border=\"0\" alt=\"\" src=\"$ecard_url/resource/picture/$ec_row[ec_cat_dir]/$ec_row[ec_thumbnail]\" style=\"border:1px solid silver;\" />";
		}
		else{
			$show_thumbnail="<div style=\"cursor:pointer;border:2px solid black;width:$cf_thumb_width_member_card px;line-height:$cf_thumb_height_member_card px;background-color:lightyellow\">$card_statistics_no_thumbnail</div>";
		}
		
		//Show category
		$cat_row = get_row("max_category","cat_id,cat_name_display","cat_id='$ec_row[ec_cat_id]'");
		
		$show_list_table .="<tr id=\"tr$val\" style=\"background-color: #EAEAEA;line-height:20px\">\n";
		$show_list_table .="<td align=\"center\" style=\"padding:4px;\">$show_thumbnail</td>\n";
		$show_list_table .="<td align=\"center\" style=\"padding:4px;white-space:nowrap\"><a href=\"index.php?step=admin_manage_ecard&cat_id=$cat_row[cat_id]\">$cat_row[cat_name_display]</a></td>\n";
		$show_list_table .="<td align=\"center\" style=\"padding:4px;white-space:nowrap\">$ec_row[ec_time_used]</td>\n";
		$show_list_table .="</tr>\n";
		$bk_id .="$val,";
		$xrow++;
		//$show_list_table.="1";
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
	
	set_global_var("show_onload_javascript","onkeypress=\"return noGlobalEnterKey(event)\"");
	
	$card_statistics_txt_page_title=str_replace("%total_cards%",$total_cards,$card_statistics_txt_page_title);
	set_global_var("card_statistics_txt_page_title",$card_statistics_txt_page_title);
	
	set_global_var("print_object",get_html_from_layout("admin/html/admin_manage_ecard_statistics.html"));
	print_admin_header_footer_page();
	
	//--------------------------------------------------------------------------------------
	function get_page_count_number($page,$b){
		global $step,$what,$row_number,$what2,$cmd_button,$list_item,$search_field,$keyword,$num_day,$num_what,$from_month,$from_day,$from_year,$to_day,$to_month,$to_year;
			
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
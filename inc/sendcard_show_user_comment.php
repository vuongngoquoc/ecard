<?php 
	if($what=="add_new_comment"){
		$com_year = date("Y",time());
		$com_day = date("d",time());
		$com_month = date("m",time());
		$field_name = "(com_author_name,com_message,com_year,com_day,com_month,com_ec_id)";
		$field_value = "('$com_author_name','$com_message','$com_year','$com_day','$com_month','$ec_id')";
		insert_data_to_db("max_ecard_comment",$field_name,$field_value);
		
		$addcomment_new_comment_has_been_added = "Comment added";
	}
	
	if($row_number =="" || $row_number =="0" || !is_numeric($row_number)) $row_number = 5;
	set_global_var("row_number",$row_number);
	$row_per_page = $row_number;
	
	if ($page < 1 || $page=="") $page =1;
	$start = ($page-1)* 1 * $row_per_page;
	$end = $start + 1 * $row_per_page;
	
	$list_data =set_array_from_query("max_ecard_comment","*","com_ec_id='$ec_id' ORDER BY com_id DESC LIMIT $start,$row_per_page");
	$count_list=get_dbvalue("max_ecard_comment","count(com_id)","com_ec_id='$ec_id' ");
	$pnum=ceil($count_list/5);
	$show_list_of_comments = "";
	if ($end > $count_list) $end = $count_list;
	$show_list_table="";
	$xrow=0;
	for ($z=$start; $z<$end; $z++) {
		$val = $list_data[$xrow][com_id];
		$row_data=$list_data[$xrow];
	
		$comment_author_name = $row_data[com_author_name];
		if ($cf_show_date_option==0) {// MM/DD/YYYY
			$comment_sent_date = $row_data[com_month]."/".$row_data[com_day]."/".$row_data[com_year];
		}
		elseif ($cf_show_date_option==1) {// DD/MM/YYYY
			$comment_sent_date = $row_data[com_day]."/".$row_data[com_month]."/".$row_data[com_year];
		}
		elseif ($cf_show_date_option==2) {// YYYY/DD/MM
			$comment_sent_date = $row_data[com_year]."/".$row_data[com_day]."/".$row_data[com_month];
		}
		else {// YYYY/MM/DD
			$comment_sent_date = $row_data[com_year]."/".$row_data[com_month]."/".$row_data[com_day];
		}
		$comment_message = $row_data[com_message];
		
		$show_list_of_comments .= get_html_from_layout("templates/$cf_set_template/show_user_comment_item.html",$the_template_show_list_of_comments);
		$xrow++;
	}
	if($_SESSION[ecardmax_user]!=""){
			set_global_var("comment_display","display:block");
		}else{
			set_global_var("comment_display","display:none");
	}
	set_global_var("show_comment_page",get_page_links(0,$pnum));
	
	$show_user_comment = get_html_from_layout("templates/$cf_set_template/show_user_comment.html");
	
	function get_page_links($page,$b){
		$count_number='<ul id="paging" class="pagination">';
		$y=0;
		if ($b <10){
			for($a_num=1; $a_num<=$b; $a_num++) {
				$y++;
				if ($a_num == $page) {
					$count_number .="<li><span style=\"cursor: default;\" class='page_active'>".$a_num."</span></li>";
				}
				else {
					$count_number .="<li><a class=\"page_other\" href=\"javascript:goToPage(".$a_num.")\">".$a_num."</a></li>";
				}
			}
		}else if(($page > 3) && ($page < ($b-3))){
			for($a_num=1; $a_num<=3; $a_num++) {
				$y++;
				$count_number .="<li><a class=\"page_other\" href=\"javascript:goToPage(".$a_num.")\">".$a_num."</a></li>";
			}
			$count_number .="...";
			for($a_num = $page-1; $a_num<=$page+1; $a_num++) {
				$y++;
				if ($a_num == $page) {
					$count_number .="<li><span style=\"cursor: default;\" class='page_active'>".$a_num."</span></li>";
				}
				else {
					$count_number .="<li><a class=\"page_other\" href=\"javascript:goToPage(".$a_num.")\">".$a_num."</a></li>";
				}
			}
			$count_number .="...";
			for($a_num = $b-2; $a_num<=$b; $a_num++) {
				$y++;
				$count_number .="<li><a class=\"page_other\" href=\"javascript:goToPage(".$a_num.")\">".$a_num."</a></li>";
			}
		}
		else{
			for($a_num=1; $a_num<=4; $a_num++) {
				$y++;
				if ($a_num == $page) {
					$count_number .="<li><span style=\"cursor: default;\" class='page_active'>".$a_num."</span></li>";
				}
				else {
					$count_number .="<li><a class=\"page_other\" href=\"javascript:goToPage(".$a_num.")\">".$a_num."</a></li>";
				}
			}
			$count_number .="...";
			for($a_num=b-3; $a_num<=b; $a_num++) {
				$y++;
				if ($a_num == $page) {
					$count_number .="<li><span style=\"cursor: default;\" class='page_active'>".$a_num."</span></li>";
				}
				else {
					$count_number .="<li><a class=\"page_other\" href=\"javascript:goToPage(".$a_num.")\">".$a_num."</a></li>";
				}
			}
		}
		return $count_number.="</ul>";
	}
?>
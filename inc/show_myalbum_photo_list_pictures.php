﻿<?php
	// get list of album
	$list_data =set_array_from_query("max_album","*","album_user_id='$_SESSION[user_id]' Order by album_id");
	$albums_list = "";
	foreach ($list_data as $row_data) {
		if ($album_id) {
			if ($album_id==$row_data[album_id]) {
				$albums_list .= "<option value=\"$row_data[album_id]\" selected>$row_data[album_name]</option>";
			}
			else {
				$albums_list .= "<option value=\"$row_data[album_id]\">$row_data[album_name]</option>";
			}
		}
		else {
			$albums_list .= "<option value=\"$row_data[album_id]\">$row_data[album_name]</option>";
		}
	}
	set_global_var("albums_list",$albums_list);
	set_global_var("album_id",$album_id);

if($row_number =="" || $row_number =="0" || !is_numeric($row_number)) $row_number = 15;
	$array_global_var_reminder[row_number]=$row_number;
	$row_per_page = $row_number;

	if ($page < 1 || $page=="") $page =1;
	$start = ($page-1)* 1 * $row_per_page;
	$end = $start + 1 * $row_per_page;
	
	$list_data =set_array_from_query("max_ecard INNER JOIN max_album_picture ON max_ecard.ec_id = max_album_picture.ec_id","*","ec_user_name_id='$_SESSION[user_name_id]' AND album_id = '$album_id' Order by ec_time LIMIT $start,$row_per_page");
	$count_list=get_dbvalue("max_ecard INNER JOIN max_album_picture ON max_ecard.ec_id = max_album_picture.ec_id","count(max_ecard.ec_id)","ec_user_name_id='$_SESSION[user_name_id]' AND album_id = '$album_id'");	

	if ($end > $count_list) $end = $count_list;
	$xrow=0;
	$show_list_table = "";
	for ($z=$start; $z<$end; $z++) {
		$val = $list_data[$xrow][ec_id] ;
		$row_data=$list_data[$xrow];

		//Show card thumbnail
		if(file_exists("$ecard_root/resource/picture/$row_data[ec_cat_dir]/$row_data[ec_thumbnail]") && $row_data[ec_thumbnail]!=""){
			list($fullsize_width, $fullsize_height) = getimagesize("$ecard_root/resource/picture/$row_data[ec_cat_dir]/$row_data[ec_filename]");
			list($fullsize_width, $fullsize_height) = resizeCalculatingImage($fullsize_width, $fullsize_height, 500,500);
			if ($cf_enable_watermark=="1") {
				if($_SESSION[mg_show_watermark]=="1" && (strpos($row_data[ec_filename],".swf")===false)){
					$show_watermark=true;
				}
				else {
					$show_watermark=false;
				}
			}
			else {
				$show_watermark=false;
			}
			if ($show_watermark) {
				$ec_full_zise_url = "'$ecard_url/index.php?step=watermark&ec_id=$row_data[ec_id]&'+new Date().getTime()";
				$ec_thumbnail = "$ecard_url/resource/picture/$row_data[ec_cat_dir]/$row_data[ec_thumbnail]";
				$show_card_thumbnail = get_html_from_layout("templates/$cf_set_template/show_myalbum_photo_list_pictures_item_normal_card.html");
			}
			else {
				$ec_full_zise_url = "'$ecard_url/resource/picture/$row_data[ec_cat_dir]/$row_data[ec_filename]?'+new Date().getTime()";
				$ec_thumbnail = "$ecard_url/resource/picture/$row_data[ec_cat_dir]/$row_data[ec_thumbnail]";
				$show_card_thumbnail = get_html_from_layout("templates/$cf_set_template/show_myalbum_photo_list_pictures_item_normal_card.html");
			}
		}
		else{			
			$ec_full_zise_url = "'$ecard_url/resource/picture/$row_data[ec_cat_dir]/$row_data[ec_filename]?'+new Date().getTime()";
			$show_card_thumbnail = get_html_from_layout("templates/$cf_set_template/show_myalbum_photo_list_pictures_item_flash_card.html");
		}
		
		$ec_id = $row_data[ec_id];
		
		$show_list_table .= get_html_from_layout("templates/$cf_set_template/show_myalbum_photo_list_pictures_item.html");
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
			
			$count_number =get_page_count_number3($page,$b);
			$display_page_number = str_replace("{NUMBER}", $count_number, $display_page_number);
			
			if ($page > 1) {
				$page_pr = $page - 1 ;				
				$dpn ="<a href=\"$ecard_url/index.php?step=$step&next_step=$next_step&what=photo&album_id=$album_id&row_number=$row_number&page=$page_pr\">&laquo;</a>";
				$display_page_number = str_replace("{A}", $dpn, $display_page_number);
			}
			else{
				$display_page_number = str_replace("{A}", "&laquo;", $display_page_number);
			}
			$y=get_global_var("d_num");
			if ($page < $y) {
				$page_ne = $page + 1 ;				
				$display_page_number = str_replace("{B}", "<a href=\"$ecard_url/index.php?step=$step&next_step=$next_step&what=photo&album_id=$album_id&row_number=$row_number&page=$page_ne\">&raquo;</a>", $display_page_number);
			}	
			else{
				$display_page_number = str_replace("{B}", "&raquo;", $display_page_number);
			}
		}
	}

	//Display random banner HR & VT
	print_banner("0");
	print_banner("1");	
	
	//Count total photo
	$total_count=get_dbvalue("max_ecard","count(ec_id)","ec_user_name_id='$_SESSION[user_name_id]'");
	
	// get Album name
	$row=get_row("max_album","*","album_id='$album_id' AND album_user_id='$_SESSION[user_id]'");
	$album_name=$row[album_name];
	$album_desc=$row[album_desc];
	
	$display_albums_pictures_list = get_html_from_layout("templates/$cf_set_template/show_myalbum_photo_list_pictures.html");
?>
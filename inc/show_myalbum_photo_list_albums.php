<?php
if($row_number =="" || $row_number =="0" || !is_numeric($row_number)) $row_number = 15;
	$array_global_var_reminder[row_number]=$row_number;
	$row_per_page = $row_number;

	if ($page < 1 || $page=="") $page =1;
	$start = ($page-1)* 1 * $row_per_page;
	$end = $start + 1 * $row_per_page;
	
	$list_data =set_array_from_query("max_album","*","album_user_id='$_SESSION[user_id]' Order by album_id LIMIT $start,$row_per_page");
	$count_list=get_dbvalue("max_album","count(album_id)","album_user_id='$_SESSION[user_id]'");
	
	if ($end > $count_list) $end = $count_list;
	$xrow=0;
	$show_list_of_albums = "";
	for ($z=$start; $z<$end; $z++) {
		$val = $list_data[$xrow][album_id];
		$row_data=$list_data[$xrow];
		
		$album_id = $row_data[album_id];
		$album_name = $row_data[album_name];
		$album_desc = $row_data[album_desc];
		$album_private = $row_data[album_private];
		
		// How many pictures in the album?
		$album_count_pictures=get_dbvalue("max_album_picture","count(album_id)","album_id='$album_id'");
		
		if ($album_count_pictures==0) {
			$album_cover_picture = "$ecard_url/templates/$cf_set_template/default_album_picture.jpg";
		}
		else {
			// get a random picture
			$ec_id_rand = get_dbvalue("max_album_picture","ec_id","album_id='$album_id' order by rand() limit 1");
			$album_cover_picture = get_dbvalue("max_ecard","ec_thumbnail","ec_id='$ec_id_rand'");
			$album_cover_picture = "$ecard_url/resource/picture/user_picture/$album_cover_picture";
		}
		
		$width=round(100 / 4) . "%";
		
		$show_list_of_albums .= get_html_from_layout("templates/$cf_set_template/show_myalbum_photo_list_albums_item.html");
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
			
			$count_number =get_page_count_number4($page,$b);
			$display_page_number = str_replace("{NUMBER}", $count_number, $display_page_number);
			
			if ($page > 1) {
				$page_pr = $page - 1 ;				
				$dpn ="<a href=\"$ecard_url/index.php?step=$step&next_step=$next_step&what=photo&row_number=$row_number&page=$page_pr\">&laquo;</a>";
				$display_page_number = str_replace("{A}", $dpn, $display_page_number);
			}
			else{
				$display_page_number = str_replace("{A}", "&laquo;", $display_page_number);
			}
			$y=get_global_var("d_num");
			if ($page < $y) {
				$page_ne = $page + 1 ;				
				$display_page_number = str_replace("{B}", "<a href=\"$ecard_url/index.php?step=$step&next_step=$next_step&what=photo&row_number=$row_number&page=$page_ne\">&raquo;</a>", $display_page_number);
			}	
			else{
				$display_page_number = str_replace("{B}", "&raquo;", $display_page_number);
			}
		}
	}
	set_global_var("display_page_number",$display_page_number);
	
	$display_albums_pictures_list = get_html_from_layout("templates/$cf_set_template/show_myalbum_photo_list_albums.html");
?>
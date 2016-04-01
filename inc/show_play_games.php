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
	
	if($row_number =="" || $row_number =="0" || !is_numeric($row_number)) $row_number = 5;//Show 5 games in a row by default
	$row_per_page = $row_number;

	if ($page < 1 || $page=="") $page =1;
	$start = ($page-1)* 1 * $row_per_page;
	$end = $start + 1 * $row_per_page;
	$list_data=set_array_from_query("max_game","*","game_active='1' Order by game_order,game_title LIMIT $start,$row_per_page");
	$count_list=get_dbvalue("max_game","count(game_id)","game_active='1'");			
	if ($end > $count_list) $end = $count_list;
	$show_list_table="";
	$xrow=0;
	$my_lang_title="game_title_" . str_replace(".php","",$_SESSION[ecardmax_lang]);
	$my_lang_intro="game_intro_message_" . str_replace(".php","",$_SESSION[ecardmax_lang]);
	for ($z=$start; $z<$end; $z++) {
		$val = $list_data[$xrow][game_id] ;
		$row_data=$list_data[$xrow];

		//Show thumbnail
		$game_thumb_url=$row_data[game_thumb_url];
		$show_thumbnail =get_html_from_layout("templates/$cf_set_template/show_play_games_item_show_thumbnail.html");

		//Show title
		if($row_data[$my_lang_title]==""){
			$show_title=$row_data[game_title];
		}
		else{
			$show_title=$row_data[$my_lang_title];
		}
		
		//Show game intro
		if($row_data[$my_lang_intro]==""){
			$show_intro=$row_data[game_intro_message];
		}
		else{
			$show_intro=$row_data[$my_lang_intro];
		}				
		
		//Show open game in window type
		if($row_data[game_open_popup]=="1"){
			$game_url=$row_data[game_url];
			$game_id=$val;
			$game_popup_height=$row_data[game_popup_height];
			$game_popup_width=$row_data[game_popup_width];
			$gamelink=get_html_from_layout("templates/$cf_set_template/show_play_games_item_game_link_pop_up.html");
	
			//Show play button
			$show_button_play=get_html_from_layout("templates/$cf_set_template/show_play_games_item_show_button_play_pop_up.html");
		}
		else{
			$game_url=$row_data[game_url];
			$gamelink=get_html_from_layout("templates/$cf_set_template/show_play_games_item_game_link_no_pop_up.html");

			//Show play button
			$show_button_play=get_html_from_layout("templates/$cf_set_template/show_play_games_item_show_button_play_no_pop_up.html");
		}
						
		$show_list_table .=get_html_from_layout("templates/$cf_set_template/show_play_games_item.html");
		if($z<$end-1)$show_list_table .=get_html_from_layout("templates/$cf_set_template/show_play_games_item_seperate.html");
		$xrow++;
	}
	//$display_thumbnail=$show_list_table;
	$display_thumbnail=get_html_from_layout("templates/$cf_set_template/show_play_games.html");

	//Display page number
	print_page_number($count_list,$row_per_page);
?>
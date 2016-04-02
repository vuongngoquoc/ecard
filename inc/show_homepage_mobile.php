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
	
	//Display category menu
	require_once ("show_category.php");
	$category_menu=category_menu($cat_id,$cat_id);
	$count_total_card=get_dbvalue("max_ecard","count(ec_id)","ec_user_name_id=''");
	//$category_menu.="<div class=\"select_category\" >$txt_total_card: $count_total_card</div>";
    
	

	//Display random quotes
	if($isMobile) $cf_show_quote_of_the_day_at_homepage = 0;
	if($cf_show_quote_of_the_day_at_homepage =="1"){
		$list_data=set_array_from_query("max_quote","*","quote_active='1' ORDER BY RAND() LIMIT $cf_homepage_display_quote_limit");
		$show_list="";
		foreach($list_data as $row_data){
			$quote_body=$row_data[quote_body];
			$quote_author=$row_data[quote_author];
			$show_list.=get_html_from_layout("templates/$cf_set_template/show_quote_of_the_day_table_item.html",$the_templates_show_quote_of_the_day_table_item);
		}
		$show_quote_of_the_day_table=get_html_from_layout("templates/$cf_set_template/show_quote_of_the_day_table.html");
	}
	
	// DO NOT REMOVE THIS VALUE
	$item_width=round(100 / 4) . "%";
	
	
	//Display feature cards
	$show_list=print_thumbnail("feature_card");
		if($show_list!=""){			
			$show_feature_cards_table=get_html_from_layout("templates/$cf_set_template/show_general_home_cards_table.html");
			
		}
	
	$show_newest_cards_table=get_html_from_layout("templates/$cf_set_template/show_general_home_cards_table.html");
	
	
	//Display feature cards
	// DO NOT REMOVE THIS VALUE
	$item_width=round(100 / 4) . "%";
	
	//Display yago cards
	
	$show_list=print_thumbnail("yoga"); 
	if($show_list!=""){			
		$show_yoga_cards_table=get_html_from_layout("templates/$cf_set_template/show_yoga_cards_table.html");
	}
	
	//Display spiritual cards
	$show_list=print_thumbnail("spiritual"); 
	if($show_list!=""){			
		$show_spiritual_cards_table=get_html_from_layout("templates/$cf_set_template/show_spiritual_cards_table.html");
	}
	
	//Display native american cards
	$show_list=print_thumbnail("native"); 
	if($show_list!=""){			
		$show_native_cards_table=get_html_from_layout("templates/$cf_set_template/show_native_cards_table.html");
	}
	
	

	

	//Display random banner HR
	print_banner("0");
	$imgslider_list=set_array_from_query("max_banner","*","banner_active='1' and banner_type ='2'");
	$banner_img="";
	foreach($imgslider_list as $img_list)
	{
		$banner_img.="<a href='$ecard_url/index.php?step=gotourl&banner_id=".$img_list['banner_id']."'> <img class=\"slider\" style=\"margin:auto\" src=\"".$img_list['banner_img_url']."\" alt=\"".$img_list['banner_img_url']."\"  /></a>";
	}
	set_global_var('TAB',$TAB);
	set_global_var('banner_img',$banner_img);
	$slider=get_html_from_layout("templates/$cf_set_template/slider.html");
	set_global_var("navigator_link","<a href=\"".get_global_var(url_home)."\">$txt_home</a>");
	$array_global_var[print_object]=get_html_from_layout("templates/$cf_set_template/show_homepage.html");
	print_header_and_footer();

?>
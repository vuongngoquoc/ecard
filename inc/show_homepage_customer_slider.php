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
	$item_width=round(100 / $cf_pic_per_row) . "%";
	
	//Display feature cards
	$TAB = '';
	$_active = false;
	
	$TEMPLATE = get_html_from_layout("templates/$cf_set_template/show_general_home_cards_table.html");
	
	if($cf_show_feature_cards_table_at_homepage =="1"){
		$show_list=print_thumbnail("feature_card");
		
		if($show_list!=""){	
			$tab_id = "feature_card";
			$_ACTIVE = '';
			$acti_cat = '';
			if($_active == '')
			{	
				$_active = true ;
				$_ACTIVE = 'active';
				$acti_cat = 'active in';
			}
			set_global_var('acti_cat',$acti_cat);
			set_global_var('tab_id',$tab_id);
			$feature_ecard_title = str_replace('Show ','',$feature_ecard_title);	
			$_icon = "<i title='$feature_ecard_title' class='display-mobile fa fa-flash'></i>";
			$feature_ecard_title_txt = $_icon."<span >$feature_ecard_title</span>";
			$TAB .= "<li rel='$feature_ecard_title' class='$_ACTIVE'><a href='#$tab_id' data-toggle='tab'>$feature_ecard_title_txt</a></li>";
			$show_feature_cards_table=get_html_from_layout("templates/$cf_set_template/show_general_home_cards_table.html");
		}
	}

	//Display Popular eCards
	if($cf_show_popular_cards_table_at_homepage =="1"){
		$show_list=print_thumbnail("most_popular");
		if($show_list!=""){
			$tab_id = "most_popular";
			$_ACTIVE = '';
			$acti_cat = '';
			if($_active == '')
			{	
				$_active = true ;
				$_ACTIVE = 'active';
				$acti_cat = 'active in';
			}
			set_global_var('acti_cat',$acti_cat);
			set_global_var('tab_id',$tab_id);	
			$popular_ecard_title = str_replace('Show ','',$popular_ecard_title);
			$_icon = "<i title='$popular_ecard_title' class='display-mobile fa fa-globe'></i>";
			$popular_ecard_title_txt = $_icon."<span class='display-desktop'>$popular_ecard_title</span>";
			$TAB .= "<li rel='$popular_ecard_title' class='$_ACTIVE'><a href='#$tab_id' data-toggle='tab'>$popular_ecard_title_txt</a></li>";
			$show_most_popular_cards_table=get_html_from_layout("templates/$cf_set_template/show_general_home_cards_table.html");
		}
	}
			
	//Display Top Rated eCards
	if($cf_show_top_rated_cars_table_at_homepage =="1"){
		$show_list=print_thumbnail("top_rated");
		if($show_list!=""){
			$tab_id = "top_rated";
			$_ACTIVE = '';
			$acti_cat = '';
			if($_active == '')
			{	
				$_active = true ;
				$_ACTIVE = 'active';
				$acti_cat = 'active in';
			}
			set_global_var('acti_cat',$acti_cat);	
			set_global_var('tab_id',$tab_id);	
			$toprated_ecard_title = str_replace('Show ','',$toprated_ecard_title);
			$toprated_ecard_title_icon = "<i title='$toprated_ecard_title' class='display-mobile fa fa-star'></i>";
			$toprated_ecard_title_txt = $toprated_ecard_title_icon."<span class='display-desktop'>$toprated_ecard_title</span>";
			$TAB .= "<li rel='$toprated_ecard_title' class='$_ACTIVE'><a href='#$tab_id' data-toggle='tab'>$toprated_ecard_title_txt</a></li>";
			$show_top_rated_cards_table=get_html_from_layout("templates/$cf_set_template/show_general_home_cards_table.html");
		}
	}

	//Display Newest eCards
	if($cf_show_newest_cards_table_at_homepage =="1"){
		$show_list=print_thumbnail("newest_card");
		if($show_list!=""){
			$tab_id = "newest_card";
			$_ACTIVE = '';
			$acti_cat = '';
			if($_active == '')
			{	
				$_active = true ;
				$_ACTIVE = 'active';
				$acti_cat = 'active in';
			}
			set_global_var('acti_cat',$acti_cat);
			set_global_var('tab_id',$tab_id);
			$newest_ecard_title_icon = "<i title='$newest_ecard_title' class='display-mobile fa fa-flag'></i>";
			$newest_ecard_title_txt = $newest_ecard_title_icon."<span class='display-desktop'>$newest_ecard_title</span>";
			$TAB .= "<li rel='$newest_ecard_title' class='$_ACTIVE'><a href='#$tab_id' data-toggle='tab'>$newest_ecard_title_txt</a></li>";
			$show_newest_cards_table=get_html_from_layout("templates/$cf_set_template/show_general_home_cards_table.html");
		}
	}

	//Display Random eCcards
	if($cf_show_random_cards_table_at_homepage =="1"){
		$show_list=print_thumbnail("random_card");
		if($show_list!=""){
			$tab_id = "random_card";
			$_ACTIVE = '';
			$acti_cat = '';
			if($_active == '')
			{	
				$_active = true ;
				$_ACTIVE = 'active';
				$acti_cat = 'active in';
			}
			set_global_var('acti_cat',$acti_cat);
			set_global_var('tab_id',$tab_id);
			$random_ecard_title = str_replace('Show ','',$random_ecard_title);
			$_icon = "<i title='$random_ecard_title' class='display-mobile fa fa-random'></i>";
			$random_ecard_title_txt = $_icon."<span class='display-desktop'>$random_ecard_title</span>";
			$TAB .= "<li rel='$random_ecard_title' class='$_ACTIVE'><a href='#$tab_id' data-toggle='tab'>$random_ecard_title_txt</a></li>";
			$show_random_cards_table=get_html_from_layout("templates/$cf_set_template/show_general_home_cards_table.html");
		}
	}

	//Display random banner HR
	print_banner("0");
	$imgslider_list=set_array_from_query("max_banner","*","banner_active='1' and banner_type ='2'");
	$banner_img="";
	$banner_text=array();
	$i = 0;
	$slider_1=get_html_from_layout("templates/$cf_set_template/slider_text_1.html");
	$slider_2=get_html_from_layout("templates/$cf_set_template/slider_text_2.html");
	$slider_content = '';
	$slider_control = '';
	foreach($imgslider_list as $img_list)
	{
		$slider_active = '';
		if($i == 0)
		$slider_active = 'active';
		set_global_var('slider_active','active');
		$slider_control .= "<li data-target='#slider-carousel' data-slide-to='$i' class='$slider_active'></li>";
		$i++;
		$banner_img="<a href='$ecard_url/index.php?step=gotourl&banner_id=".$img_list['banner_id']."'> <img class=\"slider girl img-responsive \" src=\"".$img_list['banner_img_url']."\" alt=\"".$img_list['banner_img_url']."\"  /></a>";
		set_global_var('banner_img',$banner_img);
		
		if($i%2==0) {
			$slider_content .= get_html_from_layout("templates/$cf_set_template/slider_text_2.html");
		}
		else {
			$slider_content .= get_html_from_layout("templates/$cf_set_template/slider_text_1.html");
		}
	}
	set_global_var('TAB',$TAB);
	set_global_var('slider_content',$slider_content);
	set_global_var('slider_control',$slider_control);
	$slider=get_html_from_layout("templates/$cf_set_template/slider.html");
	set_global_var("navigator_link","<a href=\"".get_global_var(url_home)."\">$txt_home</a>");
	$array_global_var[print_object]=get_html_from_layout("templates/$cf_set_template/show_homepage.html");
	print_header_and_footer();

?>
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
	$category_menu=str_replace("ECARDMAX_SUBCAT_GO_HERE","",$category_menu);

	//Display random banner HR & VT
	print_banner("0");
	print_banner("1");
	
	//First: Check $cat_id to see if it has ecards id (if so -> display thumbnail), 
	//otherwise check if cat_id has sub cat (if so, display list of category with random ecard id)

	$cat_id = $_GET[cat_id];
	$count_card=get_dbvalue("max_ecard","count(ec_id)","ec_user_name_id='' and ec_cat_id = '$cat_id' ");

	
	// Vy Tien 08-06-2010
	$my_lang_name = "cat_" . str_replace(".php","",$_SESSION[ecardmax_lang]);
	$cat_hilight_row = get_global_var(cat_hilight_row);
	$list_sub = set_array_from_query("max_category","*","cat_parent='$cat_hilight_row[cat_dir]' and cat_active='1' Order by cat_order,cat_name_display");
	// Vy Tien 08-06-2010
	
	if($count_card > 0 && !$list_sub){//Found ecard in this cat -> display thumb & page number		
		if($sortby=="" && $_SESSION[sortby]==""){
			$sortby="default";
		}
		elseif($sortby=="" && $_SESSION[sortby]!=""){
			$sortby=$_SESSION[sortby];
		}
		$_SESSION[sortby]=$sortby;	
		
		// DO NOT REMOVE THIS VALUE
		$item_width=round(100 / $cf_pic_per_row) . "%";
		$show_list_of_thumbnails=print_thumbnail($cat_id);
		
		if($_SESSION[sortby]=="date_desc"){
			$cap_sortby=$cap_sortby_date_desc;
			$sort_icon_url="$ecard_url/templates/$cf_set_template/icon_new_card.gif";
			$opacity_optional="";
		}
		elseif($_SESSION[sortby]=="date_asc"){
			$cap_sortby=$cap_sortby_date_asc;
			$sort_icon_url="$ecard_url/templates/$cf_set_template/icon_new_card.gif";
			$opacity_optional="filter: Alpha(Opacity=40);-moz-opacity:0.4;opacity:0.4;";
		}
		elseif($_SESSION[sortby]=="popular_desc"){
			$cap_sortby=$cap_sortby_popular_desc;
			$sort_icon_url="$ecard_url/templates/$cf_set_template/icon_popular.gif";
			$opacity_optional="";
		}
		elseif($_SESSION[sortby]=="popular_asc"){
			$cap_sortby=$cap_sortby_popular_asc;
			$sort_icon_url="$ecard_url/templates/$cf_set_template/icon_popular.gif";
			$opacity_optional="filter: Alpha(Opacity=40);-moz-opacity:0.4;opacity:0.4;";
		}
		elseif($_SESSION[sortby]=="rate_desc"){
			$cap_sortby=$cap_sortby_rate_desc;
			$sort_icon_url="$ecard_url/templates/$cf_set_template/icon_toprated.gif";
			$opacity_optional="";
		}
		elseif($_SESSION[sortby]=="rate_asc"){
			$cap_sortby=$cap_sortby_rate_asc;
			$sort_icon_url="$ecard_url/templates/$cf_set_template/icon_toprated.gif";
			$opacity_optional="filter: Alpha(Opacity=40);-moz-opacity:0.4;opacity:0.4;";
		}
		elseif($_SESSION[sortby]=="default"){
			$cap_sortby=$cap_sortby_default;
			$sort_icon_url="$ecard_url/templates/$cf_set_template/icon_sortby_default.gif";
			$opacity_optional="";
		}
		elseif($_SESSION[sortby]=="list_card_I_can_send"){
			$cap_sortby=$cap_sortby_card_i_can_send;
			$sort_icon_url="$ecard_url/templates/$cf_set_template/icon_free_card.gif";
			$opacity_optional="";			
		}
		$navigator_link_category=get_global_var(navigator_link);
		$navigator_link=get_html_from_layout("templates/$cf_set_template/show_thumbnail_category_navigator_link.html");
		set_global_var("navigator_link",$navigator_link);
		$display_thumbnail=get_html_from_layout("templates/$cf_set_template/show_thumbnail_sub_category.html");
	}
	else{//eCard not found -> search for sub cat
		$my_lang_name="cat_" . str_replace(".php","",$_SESSION[ecardmax_lang]);
		$cat_hilight_row=get_global_var(cat_hilight_row);
		$list_sub=set_array_from_query("max_category","*","cat_parent='$cat_hilight_row[cat_dir]' and cat_active='1' Order by cat_order,cat_name_display");

		$show_each_cat="";
		$i = 0 ;
		foreach($list_sub as $row_data){
			$i++;
			set_global_var("id_title",$i);
			if($row_data[$my_lang_name]==""){
				$cat_name_display=$row_data[cat_name_display];
			}
			else{
				$cat_name_display=$row_data[$my_lang_name];
			}
			
			// DO NOT REMOVE THIS VALUE
			$item_width=round(100 / $cf_pic_per_row) . "%";
			$show_list_of_thumbnails=print_thumbnail($row_data[cat_id],"NO_PAGE_NUMBER");
			
			if($show_list_of_thumbnails!=""){
				$category_id=$row_data[cat_id];
				$total_ecard_this_cat=get_global_var(total_ecard_this_cat);
				$cat_url=print_url_cards_browse_cate($category_id,$cat_name_display);
				$show_cat_name=str_replace("%show_cat_name%",$cat_name_display,$thumb_tool_visit_category);
				$show_seperate="<br>";
				$show_each_cat.=get_html_from_layout("templates/$cf_set_template/show_thumbnail_category.html",$the_template_show_each_cat);
			}						
		}
		$display_thumbnail=$show_each_cat;
		$navigator_link_category=get_global_var(navigator_link);
		$navigator_link=get_html_from_layout("templates/$cf_set_template/show_thumbnail_category_navigator_link_no_sort.html");
		set_global_var("navigator_link",$navigator_link);
	}
	
	$url_sort=str_replace("%cat_id%","$cat_id",$url_cards_browse_cate_sortby);
	$url_sort=str_replace("%cat_name%","$title",$url_sort);
	
	$url_sortby_default=str_replace("%sortby%","default",$url_sort);
	$url_sortby_list_card_I_can_send=str_replace("%sortby%","list_card_I_can_send",$url_sort);
	$url_sortby_date_desc=str_replace("%sortby%","date_desc",$url_sort);
	$url_sortby_date_asc=str_replace("%sortby%","date_asc",$url_sort);
	$url_sortby_popular_desc=str_replace("%sortby%","popular_desc",$url_sort);
	$url_sortby_popular_asc=str_replace("%sortby%","popular_asc",$url_sort);
	$url_sortby_rate_desc=str_replace("%sortby%","rate_desc",$url_sort);
	$url_sortby_rate_asc=str_replace("%sortby%","rate_asc",$url_sort);
	
	$array_global_var[print_object]=get_html_from_layout("templates/$cf_set_template/show_thumbnail.html");
	print_header_and_footer();

?>
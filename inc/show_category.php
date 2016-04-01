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
|   Purchase Info: http://www.ecardmax.com/purchase
|   Request Installation: http://www.ecardmax.com/ehelpmax
|	
|	WARNING //--------------------------
|
|	Selling the code for this program without prior written consent is expressly forbidden. 
|	This computer program is protected by copyright law. 
|	Unauthorized reproduction or distribution of this program, or any portion of if,
|	may result in severe civil and criminal penalties and will be prosecuted to 
|	the maximum extent possible under the law.
+--------------------------------------------------------------------------
Note: This product includes GeoLite data created by MaxMind, available from  http://www.maxmind.com 
*/
	if(ECARDMAX_USER!=1)exit;

	//------------------------------------------------------------------
	//Show Category menu
	function category_menu($cat_id="",$cat_id_hilight=""){
		global $isResponsive,$update_your_account_title,$button_join_now,$book_email,$user_id,$txt_mtool_birthdayalert,$txt_media_grabber,$txt_black_list,$txt_send_card_over_limit,$txt_mtool_birthdayalert,$txt_tell_friends,$txt_Sortby,$cap_sortby_rate_asc,$cap_sortby_rate_desc,$cap_sortby_popular_asc,$cap_sortby_popular_desc,$cap_sortby_date_asc,$cap_sortby_date_desc,$next_step,$txt_mtool_myfavorite,$txt_play_games,$txt_feedback,$button_sign_in,$txt_random_card,$txt_newsletter,$txt_pickup,$txt_search_in_category,$text_search_all_categories,$txt_keyword,$button_search_ecard,$keyword,$txt_home,$txt_popular,$txt_top_rate,$txt_newecards,$step,$cf_set_template,$cf_main_keyword,$cf_main_description,$array_global_var,$cf_site_title,$cat_select_category,$_SESSION,$ecard_url,$txt_account_verification;		
		if($isResponsive) 
		{
			get_category_2_level($cat_id,$cat_id_hilight);
		}
		$my_lang_name="cat_" . str_replace(".php","",$_SESSION[ecardmax_lang]);
		$list_main_cat=set_array_from_query("max_category","*","cat_parent='' and cat_active='1' Order by cat_order,cat_name_display");
		if($cat_id==""){//Main category
			$list_data=$list_main_cat;
            

			$className="main_category_background";
			$classNameHover="main_category_background_hover";
			$array_global_var[meta_keyword]=$cf_main_keyword;
			$array_global_var[meta_description]=$cf_main_description;
			$array_global_var[my_site_title]=$cf_site_title;
			if($step=="popular"){
				$array_global_var[my_site_title]="$cf_site_title - $txt_popular";
				set_global_var("navigator_link","<a href=\"".get_global_var(url_home)."\">$txt_home</a> <img border=\"0\" alt=\"\" src=\"$ecard_url/templates/$cf_set_template/arrow_nav.gif\" style=\"vertical-align:middle\" /> <a href=\"".get_global_var(url_popular)."\">$txt_popular</a>");
			}
			elseif($step=="top_rate"){
				$array_global_var[my_site_title]="$cf_site_title - $txt_top_rate";
				set_global_var("navigator_link","<a href=\"".get_global_var(url_home)."\">$txt_home</a> <img border=\"0\" alt=\"\" src=\"$ecard_url/templates/$cf_set_template/arrow_nav.gif\" style=\"vertical-align:middle\" /> <a href=\"".get_global_var(url_top_rate)."\">$txt_top_rate</a>");
			}
			elseif($step=="new_ecards"){
				$array_global_var[my_site_title]="$cf_site_title - $txt_newecards";
				set_global_var("navigator_link","<a href=\"".get_global_var(url_home)."\">$txt_home</a> <img border=\"0\" alt=\"\" src=\"$ecard_url/templates/$cf_set_template/arrow_nav.gif\" style=\"vertical-align:middle\" /> <a href=\"".get_global_var(url_new_ecards)."\">$txt_newecards</a>");
			}
			elseif($step=="random_card"){
				$array_global_var[my_site_title]="$cf_site_title - $txt_random_card";
				set_global_var("navigator_link","<a href=\"".get_global_var(url_home)."\">$txt_home</a> <img border=\"0\" alt=\"\" src=\"$ecard_url/templates/$cf_set_template/arrow_nav.gif\" style=\"vertical-align:middle\" /> <a href=\"".get_global_var(url_random_card)."\">$txt_random_card</a>");
			}			
			elseif($step=="search_ecard"){
				$array_global_var[my_site_title]="$cf_site_title - $button_search_ecard $txt_keyword $keyword";
				$keyword =stripslashes($keyword);
				set_global_var("navigator_link","<a href=\"".get_global_var(url_home)."\">$txt_home</a> <img border=\"0\" alt=\"\" src=\"$ecard_url/templates/$cf_set_template/arrow_nav.gif\" style=\"vertical-align:middle\" /> $button_search_ecard $txt_keyword <span class=\"OK_Message\">&quot;$keyword&quot;</span>");
			}
			elseif($step=="pickup"){
				$array_global_var[my_site_title]="$cf_site_title - $txt_pickup";
				set_global_var("navigator_link","<a href=\"".get_global_var(url_home)."\">$txt_home</a> <img border=\"0\" alt=\"\" src=\"$ecard_url/templates/$cf_set_template/arrow_nav.gif\" style=\"vertical-align:middle\" /> <a href=\"".get_global_var(url_pickup)."\">$txt_pickup</a>");
			}
			elseif($step=="send_card_over_limit"){
				$array_global_var[my_site_title]="$cf_site_title - $txt_send_card_over_limit";
				set_global_var("navigator_link","<a href=\"".get_global_var(url_home)."\">$txt_home</a> <img border=\"0\" alt=\"\" src=\"$ecard_url/templates/$cf_set_template/arrow_nav.gif\" style=\"vertical-align:middle\" /> <a href=\"$ecard_url/index.php?step=send_card_over_limit\">$txt_send_card_over_limit</a>");
			}
			elseif($step=="newsletter"){
				$array_global_var[my_site_title]="$cf_site_title - $txt_newsletter";
				set_global_var("navigator_link","<a href=\"".get_global_var(url_home)."\">$txt_home</a> <img border=\"0\" alt=\"\" src=\"$ecard_url/templates/$cf_set_template/arrow_nav.gif\" style=\"vertical-align:middle\" /> <a href=\"".get_global_var(url_newsletter)."\">$txt_newsletter</a>");
			}
			elseif($step=="feedback"){
				$array_global_var[my_site_title]="$cf_site_title - $txt_feedback";
				set_global_var("navigator_link","<a href=\"".get_global_var(url_home)."\">$txt_home</a> <img border=\"0\" alt=\"\" src=\"$ecard_url/templates/$cf_set_template/arrow_nav.gif\" style=\"vertical-align:middle\" /> <a href=\"".get_global_var(url_feedback)."\">$txt_feedback</a>");
			}
			elseif($step=="tell_friends"){
				$array_global_var[my_site_title]="$cf_site_title - $txt_tell_friends";
				set_global_var("navigator_link","<a href=\"".get_global_var(url_home)."\">$txt_home</a> <img border=\"0\" alt=\"\" src=\"$ecard_url/templates/$cf_set_template/arrow_nav.gif\" style=\"vertical-align:middle\" /> <a href=\"".get_global_var(url_tell_friends)."\">$txt_tell_friends</a>");
			}
			elseif($step=="play_games"){
				$array_global_var[my_site_title]="$cf_site_title - $txt_play_games";
				set_global_var("navigator_link","<a href=\"".get_global_var(url_home)."\">$txt_home</a> <img border=\"0\" alt=\"\" src=\"$ecard_url/templates/$cf_set_template/arrow_nav.gif\" style=\"vertical-align:middle\" /> <a href=\"".get_global_var(url_play_games)."\">$txt_play_games</a>");
			}
			elseif($step=="blacklist"){
				$array_global_var[my_site_title]="$cf_site_title - $txt_black_list";
				set_global_var("navigator_link","<a href=\"".get_global_var(url_home)."\">$txt_home</a> <img border=\"0\" alt=\"\" src=\"$ecard_url/templates/$cf_set_template/arrow_nav.gif\" style=\"vertical-align:middle\" /> <a href=\"".get_global_var(url_blacklist)."\">$txt_black_list</a>");
			}
			elseif($step=="grabber"){
				$array_global_var[my_site_title]="$cf_site_title - $txt_media_grabber";
				set_global_var("navigator_link","<a href=\"".get_global_var(url_home)."\">$txt_home</a> <img border=\"0\" alt=\"\" src=\"$ecard_url/templates/$cf_set_template/arrow_nav.gif\" style=\"vertical-align:middle\" /> <a href=\"".get_global_var(url_grabber)."\">$txt_media_grabber</a>");
			}
			elseif($step=="dob"){
				$array_global_var[my_site_title]="$cf_site_title - $txt_mtool_birthdayalert";
				set_global_var("navigator_link","<a href=\"".get_global_var(url_home)."\">$txt_home</a> <img border=\"0\" alt=\"\" src=\"$ecard_url/templates/$cf_set_template/arrow_nav.gif\" style=\"vertical-align:middle\" /> <a href=\"".print_url_date_of_birth_user($user_id,$book_email)."\">$txt_mtool_birthdayalert</a>");
			}
			elseif($step=="join_now"){
				$array_global_var[my_site_title]="$cf_site_title - $button_join_now";
				set_global_var("navigator_link","<a href=\"".get_global_var(url_home)."\">$txt_home</a> <img border=\"0\" alt=\"\" src=\"$ecard_url/templates/$cf_set_template/arrow_nav.gif\" style=\"vertical-align:middle\" /> <a href=\"".get_global_var(url_join_now)."\">$button_join_now</a>");
			}
			elseif($step=="verify_account"){
				$array_global_var[my_site_title]="$cf_site_title - $txt_account_verification";
				set_global_var("navigator_link","<a href=\"".get_global_var(url_home)."\">$txt_home</a> <img border=\"0\" alt=\"\" src=\"$ecard_url/templates/$cf_set_template/arrow_nav.gif\" style=\"vertical-align:middle\" /> $txt_account_verification");
			}
			elseif($step=="update_your_account"){
				$array_global_var[my_site_title]="$cf_site_title - $update_your_account_title";
				set_global_var("navigator_link","<a href=\"".get_global_var(url_home)."\">$txt_home</a> <img border=\"0\" alt=\"\" src=\"$ecard_url/templates/$cf_set_template/arrow_nav.gif\" style=\"vertical-align:middle\" /> <a href=\"".get_global_var(url_update_your_account)."\">$update_your_account_title</a>");
			}
			elseif($step=="sign_in"){				
				if($_SESSION[ecardmax_user]==""){
					$array_global_var[my_site_title]="$cf_site_title - $button_sign_in";
					set_global_var("navigator_link","<a href=\"".get_global_var(url_home)."\">$txt_home</a> <img border=\"0\" alt=\"\" src=\"$ecard_url/templates/$cf_set_template/arrow_nav.gif\" style=\"vertical-align:middle\" /> <a href=\"$url_sign_in\">$button_sign_in</a>");
				}
				elseif($_SESSION[ecardmax_user]!="" && $next_step=="show_favorite"){
					$array_global_var[my_site_title]="$cf_site_title - $txt_mtool_myfavorite";
					if($_SESSION[sortby]=="date_desc"){
						$image_sortby="<img border=\"0\" alt=\"$txt_Sortby: $cap_sortby_date_desc\" title=\"$txt_Sortby: $cap_sortby_date_desc\" src=\"$ecard_url/templates/$cf_set_template/icon_new_card.gif\" style=\"vertical-align:middle\" />";
					}
					elseif($_SESSION[sortby]=="date_asc"){
						$image_sortby="<img border=\"0\" alt=\"$txt_Sortby: $cap_sortby_date_asc\" title=\"$txt_Sortby: $cap_sortby_date_asc\" src=\"$ecard_url/templates/$cf_set_template/icon_new_card.gif\" style=\"vertical-align:middle;filter: Alpha(Opacity=40);-moz-opacity:0.4;opacity:0.4;\" />";
					}
					elseif($_SESSION[sortby]=="popular_desc"){
						$image_sortby="<img border=\"0\" alt=\"$txt_Sortby: $cap_sortby_popular_desc\" title=\"$txt_Sortby: $cap_sortby_popular_desc\" src=\"$ecard_url/templates/$cf_set_template/icon_popular.gif\" style=\"vertical-align:middle\" />";
					}
					elseif($_SESSION[sortby]=="popular_asc"){
						$image_sortby="<img border=\"0\" alt=\"$txt_Sortby: $cap_sortby_popular_asc\" title=\"$txt_Sortby: $cap_sortby_popular_asc\" src=\"$ecard_url/templates/$cf_set_template/icon_popular.gif\" style=\"vertical-align:middle;filter: Alpha(Opacity=40);-moz-opacity:0.4;opacity:0.4;\" />";
					}
					elseif($_SESSION[sortby]=="rate_desc"){
						$image_sortby="<img border=\"0\" alt=\"$txt_Sortby: $cap_sortby_rate_desc\" title=\"$txt_Sortby: $cap_sortby_rate_desc\" src=\"$ecard_url/templates/$cf_set_template/icon_toprated.gif\" style=\"vertical-align:middle\" />";
					}
					elseif($_SESSION[sortby]=="rate_asc"){
						$image_sortby="<img border=\"0\" alt=\"$txt_Sortby: $cap_sortby_rate_asc\" title=\"$txt_Sortby: $cap_sortby_rate_asc\" src=\"$ecard_url/templates/$cf_set_template/icon_toprated.gif\" style=\"vertical-align:middle;filter: Alpha(Opacity=40);-moz-opacity:0.4;opacity:0.4;\" />";
					}
					set_global_var("navigator_link","<a href=\"".get_global_var(url_home)."\">$txt_home</a> <img border=\"0\" alt=\"\" src=\"$ecard_url/templates/$cf_set_template/arrow_nav.gif\" style=\"vertical-align:middle\" /> <a href=\"$url_favorite_home\">$txt_mtool_myfavorite</a><img border=\"0\" src=\"$ecard_url/templates/$cf_set_template/icon_sort.gif\" style=\"vertical-align:middle;cursor:pointer\" onclick=\"ShowDiv('button_sort_ecard','div_sort_ecard',0,0);\" alt=\"$txt_Sortby\" title=\"$txt_Sortby\" id=\"button_sort_ecard\" /> $image_sortby");
				}
				elseif($_SESSION[ecardmax_user]!="" && $next_step=="show_birthdayalert"){
					$array_global_var[my_site_title]="$cf_site_title - $txt_mtool_birthdayalert";
					set_global_var("navigator_link","<a href=\"".get_global_var(url_home)."\">$txt_home</a> <img border=\"0\" alt=\"\" src=\"$ecard_url/templates/$cf_set_template/arrow_nav.gif\" style=\"vertical-align:middle\" /> <a href=\"".print_sign_in_next_step("show_birthdayalert")."\">$txt_mtool_birthdayalert</a>");
				}
			}
		}
		else{
			$list_row=set_array_from_query("max_category","*","cat_id='$cat_id' and cat_active='1' or cat_id='$cat_id_hilight' and cat_active='1' ");
			$cat_row=$list_row[0];
			$cat_hilight_row=$list_row[1];
			if($cat_hilight_row=="")$cat_hilight_row=$cat_row;
			set_global_var("cat_hilight_row",$cat_hilight_row);
			set_global_var('cat_name_display_title',$cat_hilight_row[cat_name_display]);
			$array_global_var[meta_keyword]=$cat_hilight_row[cat_keyword];
			$array_global_var[meta_description]=$cat_hilight_row[cat_description];
			if($cat_hilight_row[cat_title]=="")$cat_hilight_row[cat_title]=$cat_hilight_row[$my_lang_name];
			if($cat_hilight_row[cat_title]=="")$cat_hilight_row[cat_title]=$cat_hilight_row[cat_name_display];
			$array_global_var[my_site_title]=$cat_hilight_row[cat_title];
			
			
			list($main_cat_dir_id)=split(",",$cat_row[cat_relate_id]);
			$main_cat_id=get_dbvalue("max_category","cat_id","cat_dir_id='$main_cat_dir_id'");
			$show_more_category_menu.="<ul class='menu_cat'>";
			foreach($list_main_cat as $row_data){
				$val = $row_data[cat_id] ;
				
				//Language				
				if($row_data[$my_lang_name]==""){
					$cat_name_display=$row_data[cat_name_display];
				}
				else{
					$cat_name_display=$row_data[$my_lang_name];
				}

				if($main_cat_id==$val){
					$show_more_category_menu.="<li class=\"active_menu\"><a href=\"".print_url_cards_browse_cate($val,$row_data[cat_name_display])."\" >$cat_name_display</a><ul>ECARDMAX_SUBCAT_GO_HERE</ul></li>";
				}
				else{
					$show_more_category_menu.="<li><a href=\"".print_url_cards_browse_cate($val,$row_data[cat_name_display])."\" >$cat_name_display</a></li>";					
				}
			}
			$show_more_category_menu.="<br clear=\"all\" /></ul>";
			
			$list_data=set_array_from_query("max_category","*","cat_parent='$cat_row[cat_dir]' and cat_active='1' Order by cat_order,cat_name_display");
			
			//Language
			if($cat_row[$my_lang_name]==""){
				$cat_name_display=$cat_row[cat_name_display];
			}
			else{
				$cat_name_display=$cat_row[$my_lang_name];
			}
			
			if($cat_row[cat_parent]!=""){
				$category_menu="<div class=\"sub_category_title_background\" style=\"text-align:center;font-weight:bold\">=: $cat_name_display :=</div>";
			}
			else{
				$category_menu="";
			}
			
			$className="sub_category_background";
			$classNameHover="sub_category_background_hover";

			//Show cat navigator
			$array=split(",",$cat_hilight_row[cat_relate_id]);
			$where="";
			foreach($array as $cat_dir_id){
				$where .="cat_dir_id='$cat_dir_id' and cat_active='1' ,";
			}
			if($where{strlen($where)-1} ==",") $where = substr($where, 0, strlen($where)-1);
			$where=str_replace(","," or ",$where);
			$list_array=set_array_from_query("max_category","*","$where");
			$navigator_link="";		
			foreach($array as $cat_dir_id){
				$navigator_link_tmp="";
				foreach($list_array as $array_nav){
					if($cat_dir_id==$array_nav[cat_dir_id]){
						if($array_nav[$my_lang_name]==""){
							$show_nav_cat_name=$array_nav[cat_name_display];
						}
						else{
							$show_nav_cat_name=$array_nav[$my_lang_name];
						}
						$navigator_link_tmp .= " <a href=\"".print_url_cards_browse_cate($array_nav[cat_id],$array_nav[cat_name_display])."\">$show_nav_cat_name</a>,";
					}
				}
				$navigator_link .= $navigator_link_tmp;
			}
			if($navigator_link{strlen($navigator_link)-1} ==",") $navigator_link = substr($navigator_link, 0, strlen($navigator_link)-1);		
			$navigator_link=str_replace(","," <img border=\"0\" alt=\"\" src=\"$ecard_url/templates/$cf_set_template/arrow_nav.gif\" style=\"vertical-align:middle\" />",$navigator_link);
			set_global_var("navigator_link","<a href=\"".get_global_var(url_home)."\">$txt_home</a> <img border=\"0\" alt=\"\" src=\"$ecard_url/templates/$cf_set_template/arrow_nav.gif\" style=\"vertical-align:middle\" /> $navigator_link");		

			//Show search in category dropdown
			if($step!="search_ecard"){
				//Language
				if($cat_hilight_row[$my_lang_name]==""){
					$cat_search_name_display=$cat_hilight_row[cat_name_display];
				}
				else{
					$cat_search_name_display=$cat_hilight_row[$my_lang_name];
				}
				$search_in_cat="<div style=\"padding:3px;\"><strong>$txt_search_in_category</strong><select size=\"1\" name=\"search_in_cat\" style=\"width:98%\"><option value=\"all\">$text_search_all_categories</option><option value=\"$cat_hilight_row[cat_id]\">$cat_search_name_display</option></select></div>";
				set_global_var("search_in_category",$search_in_cat);
			}			
		}
		$category_menu.="<ul class='menu_cat'>";
		foreach($list_data as $row_data){
			$val = $row_data[cat_id] ;

			//Language
			if($row_data[$my_lang_name]==""){
				$cat_name_display=$row_data[cat_name_display];
			}
			else{
				$cat_name_display=$row_data[$my_lang_name];
			}

			//Hilight selected cat
			if($cat_id!=""){
				if($cat_id_hilight==$val){
					$category_menu.="<li><a class=\"active_smenu\" href=\"".print_url_cards_browse_cate($val,$row_data[cat_name_display])."\" >$cat_name_display</a></li>";
				}
				else{
				$category_menu.="<li><a href=\"".print_url_cards_browse_cate($val,$row_data[cat_name_display])."\">$cat_name_display</a></li>";
				}
			}
			else{
				$category_menu.="<li><a href=\"".print_url_cards_browse_cate($val,$row_data[cat_name_display])."\" class=\"main_category_text_link\">$cat_name_display</a></li>";
			}
		}
		$category_menu.="</ul>";
		
		//Check if current cat has subcat. If not -> display cat parent
		$chk_sub=get_dbvalue("max_category","count(cat_id)","cat_relate_id like '%$cat_row[cat_dir_id]%' and cat_active='1' ") - 1;
		if($chk_sub=="0"){
			if($cat_row[cat_parent]!=""){
				$get_id=get_dbvalue("max_category","cat_id","cat_dir='$cat_row[cat_parent]'");			
				return category_menu($get_id,$cat_id);
			}
			else{
				set_global_var("show_more_category_menu","");
				return $show_more_category_menu;
			}
		}
		else{
			$show_more_category_menu=str_replace("ECARDMAX_SUBCAT_GO_HERE",$category_menu,$show_more_category_menu);
			set_global_var("show_more_category_menu",$show_more_category_menu);
			if($cat_id=="")return $category_menu;
		}
	}
    function get_category_2_level($cat_id="",$cat_id_hilight="")
	{
		global $update_your_account_title,$button_join_now,$book_email,$user_id,$txt_mtool_birthdayalert,$txt_media_grabber,$txt_black_list,$txt_send_card_over_limit,$txt_mtool_birthdayalert,$txt_tell_friends,$txt_Sortby,$cap_sortby_rate_asc,$cap_sortby_rate_desc,$cap_sortby_popular_asc,$cap_sortby_popular_desc,$cap_sortby_date_asc,$cap_sortby_date_desc,$next_step,$txt_mtool_myfavorite,$txt_play_games,$txt_feedback,$button_sign_in,$txt_random_card,$txt_newsletter,$txt_pickup,$txt_search_in_category,$text_search_all_categories,$txt_keyword,$button_search_ecard,$keyword,$txt_home,$txt_popular,$txt_top_rate,$txt_newecards,$step,$cf_set_template,$cf_main_keyword,$cf_main_description,$array_global_var,$cf_site_title,$cat_select_category,$_SESSION,$ecard_url,$txt_account_verification;		
		$CATEGORY_MAIN_MENU = '';
		$my_lang_name="cat_" . str_replace(".php","",$_SESSION[ecardmax_lang]);
		$list_row=set_array_from_query("max_category","*","cat_parent='' and cat_active='1' Order by cat_order,cat_name_display");

			
			//$dropDownTmp = '<span class="badge pull-right"><i data-toggle="collapse" data-parent="#accordian" href="#%idDiv%" class="fa fa-plus"></i></span>';
			$dropDownTmp="";
			$idDiv = '';
			$show_more_category_menu.='<div class="panel-group category-products" id="accordian">';
			$show_more_category_menu_mobile="<ul class='nav navbar-nav collapse navbar-collapse-2'>";
			foreach($list_row as $row_data){
				
				$show_more_category_menu.='<div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title">';
				$val = $row_data[cat_id] ;
				
				//Language				
				if($row_data[$my_lang_name]==""){
					$cat_name_display=$row_data[cat_name_display];
				}
				else{
					$cat_name_display=$row_data[$my_lang_name];
				}
				
				$idDiv = 'parent-'.$val;
				
				
				$_cls = '';
				$_collapse = 'collapse';
				if($cat_id==$val)
				{
					$_cls = 'acti' ;
					$_collapse = 'in';
				}
				list($SUB_CATEGORY,$SUB_CATEGORY_MOBILE) = get_sub_category($row_data['cat_dir'],$idDiv,$_collapse,$cat_id_hilight);
				$collapse_btn = str_replace('%idDiv%',$idDiv,$dropDownTmp);
				
				$show_more_category_menu_mobile .= "<li class='dropdown clearfix'><a class=\"pull-left $_cls\" href=\"".print_url_cards_browse_cate($val,$row_data[cat_name_display])."\" >";
				$show_more_category_menu_mobile .= "$cat_name_display</a><i class='pull-right control-sub fa fa-caret-down'></i>$SUB_CATEGORY_MOBILE</li>";
				$SUB_CATEGORY_MOBILE = str_replace('sub-menu','sub-sub-menu',$SUB_CATEGORY_MOBILE);
				$CATEGORY_MAIN_MENU .= "<li><a class=\"$_cls\" href=\"".print_url_cards_browse_cate($val,$row_data[cat_name_display])."\" >";
				$CATEGORY_MAIN_MENU .= "$cat_name_display</a><i class='fa fa-caret-right pull-right'></i>$SUB_CATEGORY_MOBILE</li>";
				$cat_name_display = $collapse_btn.$cat_name_display;
				$show_more_category_menu.="<a class=\"$_cls\" href=\"".print_url_cards_browse_cate($val,$row_data[cat_name_display])."\" >$cat_name_display</a>";
				$show_more_category_menu.="</h4></div>$SUB_CATEGORY</div>";
			}
			
			
		
				
				
			$show_more_category_menu_mobile .= "<li class='dropdown clearfix'><a class=\"pull-left $_cls\" href='#'>Search by Artist</a></li>";
			$show_more_category_menu_mobile .= "<li class='dropdown clearfix'><a class=\"pull-left $_cls\" href='#'>Design my own</a></li>";
			
			$show_more_category_menu.='<div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title">' . "<li class='dropdown clearfix'><a class=\"pull-left $_cls\" href=\"#\" >Search by Artist</a></li></h4></div></div>";
			$show_more_category_menu.='<div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title">' . "<li class='dropdown clearfix'><a class=\"pull-left $_cls\" href=\"#\" >Design my own</a></li></h4></div></div>";
				 
			
			
				
				
			$show_more_category_menu_mobile .= "</ul>";
			$show_more_category_menu.="</div>";
			set_global_var('CATEGORY_MAIN_MENU',$CATEGORY_MAIN_MENU);
			set_global_var('CATEGORY_2_LEVEL',$show_more_category_menu);
			set_global_var('CATEGORY_2_LEVEL_MOBILE',$show_more_category_menu_mobile);
	}
	function get_sub_category($cat_parent="",$idDiv,$_collapse,$cat_id_hilight="")
	{
		global $update_your_account_title,$button_join_now,$book_email,$user_id,$txt_mtool_birthdayalert,$txt_media_grabber,$txt_black_list,$txt_send_card_over_limit,$txt_mtool_birthdayalert,$txt_tell_friends,$txt_Sortby,$cap_sortby_rate_asc,$cap_sortby_rate_desc,$cap_sortby_popular_asc,$cap_sortby_popular_desc,$cap_sortby_date_asc,$cap_sortby_date_desc,$next_step,$txt_mtool_myfavorite,$txt_play_games,$txt_feedback,$button_sign_in,$txt_random_card,$txt_newsletter,$txt_pickup,$txt_search_in_category,$text_search_all_categories,$txt_keyword,$button_search_ecard,$keyword,$txt_home,$txt_popular,$txt_top_rate,$txt_newecards,$step,$cf_set_template,$cf_main_keyword,$cf_main_description,$array_global_var,$cf_site_title,$cat_select_category,$_SESSION,$ecard_url,$txt_account_verification;		

		$my_lang_name="cat_" . str_replace(".php","",$_SESSION[ecardmax_lang]);
		$list_data=set_array_from_query("max_category","*","cat_parent='$cat_parent' and cat_active='1' Order by cat_order,cat_name_display");
		$category_menu_mobile = "<ul role='menu' class='sub-menu clearfix'>";
		//var_dump($cat_id);
		$category_menu.='<div id="'.$idDiv.'" class="panel-collapse '.$_collapse.'"><div class="panel-body"><ul>';
		foreach($list_data as $row_data){
			
			$val = $row_data[cat_id] ;

			//Language
			if($row_data[$my_lang_name]==""){
				$cat_name_display=$row_data[cat_name_display];
			}
			else{
				$cat_name_display=$row_data[$my_lang_name];
			}

			//Hilight selected cat
			$category_menu_tmp='<li>';
			if($cat_id_hilight==$val){
				$category_menu_tmp.="<a class=\"acti\" href=\"".print_url_cards_browse_cate($val,$row_data[cat_name_display])."\" >$cat_name_display</a>";
			}
			else{
			$category_menu_tmp.="<a href=\"".print_url_cards_browse_cate($val,$row_data[cat_name_display])."\">$cat_name_display</a>";
			}
			$category_menu_tmp.='</li>';
			$category_menu .= $category_menu_tmp;
			$category_menu_mobile .= $category_menu_tmp;
		}
		$category_menu.='</ul></div></div>';
		$category_menu_mobile .= "</ul>";
		return array($category_menu,$category_menu_mobile);
	}
	//------------------------------------------------------------------
	function print_thumbnail($cat_id="",$no_page=""){
		global $step,$isResponsive,$txt_caption_paypercard,$cf_show_ppc_amount,$button_use_sortby_default,$cf_show_card_caption,$cf_show_goto_category_icon,$cf_show_thumb_toolbar,$sortby,$txt_js_alert_sure_to_delete_card_favorite,$txt_card_lable_remove_favorite,$txt_card_lable_FLASH,$txt_card_lable_POSTCARD,$today_year,$action,$find_exact,$search_in_cat,$keyword,$end_today_timestamp,$cf_row_per_page,$page,$cf_homepage_display_random_limit,$cf_homepage_display_newestcard_limit,$cf_homepage_display_toprate_limit,$cf_homepage_display_most_popular_limit,$cf_homepage_display_feature_card_limit,$ecard_root,$thumb_tool_date_add_card,$thumb_tool_new_card,$thumb_tool_free_card,$thumb_tool_member_card,$thumb_tool_member_card_ok_to_send,$thumb_tool_preview_fullsize,$thumb_tool_visit_category,$cf_show_card_type_icon,$cf_show_new_icon,$cf_show_free_icon,$_SESSION,$ecard_url,$cf_pic_per_row,$cf_row_per_page,$cf_set_template,$cf_show_rate_star_image,$gmt_timestamp_now,$cf_show_new_icon_before_day,$item_width,$cf_thumb_width_member_card,$cf_thumb_height_member_card;
		
		//get title page
		if(!is_numeric($cat_id))
		{
			$cat_name_display_title = 'txt_'.$step ;
			global $$cat_name_display_title;
			set_global_var('cat_name_display_title', $$cat_name_display_title);
		}
		//end
		
		$my_lang_name = "ec_caption_" . str_replace(".php","",$_SESSION[ecardmax_lang]);
		$cat_lang_name= "cat_" . str_replace(".php","",$_SESSION[ecardmax_lang]);
		$time_3dayb4_start = $gmt_timestamp_now-86400 * $cf_show_new_icon_before_day;
		
		$row_per_page = $cf_row_per_page*$cf_pic_per_row;
		if ($page < 1 || $page=="") $page =1;
		$start = ($page-1)* 1 * $row_per_page;
		$end = $start + 1 * $row_per_page;

		if($cat_id=="feature_card"){
			if($cf_homepage_display_feature_card_limit=="")$cf_homepage_display_feature_card_limit=3;
			$list_data=set_array_from_query("max_ecard","*","ec_active='1' and ec_user_name_id='' and ec_feature_card='1' Order by RAND() LIMIT $cf_homepage_display_feature_card_limit");
		}
		elseif($cat_id=="yoga"){
			if($cf_homepage_display_most_popular_limit=="")$cf_homepage_display_most_popular_limit=3;
			$list_data=set_array_from_query("max_ecard","*","ec_active='1' and ec_cat_relate_id='e6c7acdf' ORDER BY ec_time DESC LIMIT 4");
		}
		elseif($cat_id=="spiritual"){
			if($cf_homepage_display_most_popular_limit=="")$cf_homepage_display_most_popular_limit=3;
			$list_data=set_array_from_query("max_ecard","*","ec_active='1' and ec_cat_relate_id='afb35baf' ORDER BY ec_time DESC LIMIT 4");
		}
		elseif($cat_id=="native"){
			if($cf_homepage_display_most_popular_limit=="")$cf_homepage_display_most_popular_limit=3;
			$list_data=set_array_from_query("max_ecard","*","ec_active='1' and ec_cat_relate_id='c58be8c5' ORDER BY ec_time DESC LIMIT 4");
		}
		elseif($cat_id=="most_popular"){
			if($cf_homepage_display_most_popular_limit=="")$cf_homepage_display_most_popular_limit=3;
			$list_data=set_array_from_query("max_ecard","*","ec_active='1' and ec_user_name_id='' ORDER BY ec_time_used DESC,ec_rate DESC,ec_time DESC LIMIT $cf_homepage_display_most_popular_limit");
		}
		elseif($cat_id=="top_rated"){
			if($cf_homepage_display_toprate_limit=="")$cf_homepage_display_toprate_limit=3;
			$list_data=set_array_from_query("max_ecard","*","ec_active='1' and ec_user_name_id='' ORDER BY ec_rate DESC,ec_time_used DESC,ec_time DESC LIMIT $cf_homepage_display_toprate_limit");
		}
		elseif($cat_id=="newest_card"){
			if($cf_homepage_display_newestcard_limit=="")$cf_homepage_display_newestcard_limit=3;
			$list_data=set_array_from_query("max_ecard","*","ec_active='1' and ec_user_name_id='' ORDER BY ec_time DESC, ec_rate DESC,ec_time_used DESC LIMIT $cf_homepage_display_newestcard_limit");
		}
		elseif($cat_id=="random_card"){
			if($cf_homepage_display_random_limit=="")$cf_homepage_display_random_limit=3;
			$list_data=set_array_from_query("max_ecard","*","ec_active='1' and ec_user_name_id='' Order by RAND() LIMIT $cf_homepage_display_random_limit");
		}
		elseif($cat_id=="random_card2"){
			$limit=$row_per_page*2;
			$list_data=set_array_from_query("max_ecard","*","ec_active='1' and ec_user_name_id='' Order by RAND() LIMIT $limit");
		}
		elseif($cat_id=="show_popular"){
			$list_data=set_array_from_query("max_ecard","*","ec_active='1' and ec_user_name_id='' Order by ec_time_used DESC LIMIT $start,$row_per_page");
			print_page_number(get_dbvalue("max_ecard","count(ec_id)","ec_active='1' and ec_user_name_id=''"));
		}
		elseif($cat_id=="show_top_rate"){
			$list_data=set_array_from_query("max_ecard","*","ec_active='1' and ec_user_name_id='' Order by ec_rate DESC LIMIT $start,$row_per_page");
			print_page_number(get_dbvalue("max_ecard","count(ec_id)","ec_active='1' and ec_user_name_id=''"));
		}
		elseif($cat_id=="show_new_ecards"){
			$list_data=set_array_from_query("max_ecard","*","ec_active='1' and ec_user_name_id='' Order by ec_time DESC LIMIT $start,$row_per_page");
			print_page_number(get_dbvalue("max_ecard","count(ec_id)","ec_active='1' and ec_user_name_id=''"));
		}
		elseif($cat_id=="basic_sample_card"){
			$item_width=round(100 / $cf_pic_per_row) . "%";
			$list_data=set_array_from_query("max_ecard","*","ec_active='1' and ec_user_name_id='' and ec_group_relate_id like '%,2,%' Order by RAND() LIMIT 3");
		}
		elseif(!(strpos($cat_id,"mg_card")===false)){
			$mg_id=str_replace("mg_card","",$cat_id);
			$list_data=set_array_from_query("max_ecard","*","ec_active='1' and ec_user_name_id='' and ec_group_relate_id like '%,$mg_id,%' Order by RAND() LIMIT 3");
		}
		elseif($cat_id=="show_favorite"){
			if($sortby=="" && $_SESSION[sortby]==""){
				$sortby="date_desc";
			}
			elseif($sortby=="" && $_SESSION[sortby]!=""){
				$sortby=$_SESSION[sortby];
			}
			$_SESSION[sortby]=$sortby;

			if($_SESSION[sortby]=="date_desc"){
				$order_by="Order by ec_time DESC";
			}
			elseif($_SESSION[sortby]=="date_asc"){
				$order_by="Order by ec_time";
			}
			elseif($_SESSION[sortby]=="popular_desc"){
				$order_by="Order by ec_time_used DESC";
			}
			elseif($_SESSION[sortby]=="popular_asc"){
				$order_by="Order by ec_time_used";
			}
			elseif($_SESSION[sortby]=="rate_desc"){
				$order_by="Order by ec_rate DESC";
			}
			elseif($_SESSION[sortby]=="rate_asc"){
				$order_by="Order by ec_rate";
			}
			elseif($_SESSION[sortby]=="default" || $_SESSION[sortby]==""){
				$order_by="Order by ec_time DESC";
			}
			$list_fav=get_dblistvalue("max_favorite","fv_ec_id","fv_user_name_id='$_SESSION[user_name_id]'");
			if(count($list_fav)>0){
				$cond="";
				foreach($list_fav as $val_ec_id){
					$cond.="ec_active='1' and ec_id='$val_ec_id',";
				}
				if($cond{strlen($cond)-1} ==",") $cond = substr($cond, 0, strlen($cond)-1);
				$cond=str_replace(","," or ",$cond);
				$list_data=set_array_from_query("max_ecard","*","$cond $order_by LIMIT $start,$row_per_page");
				print_page_number(get_dbvalue("max_ecard","count(ec_id)","$cond"));
			}
			set_global_var("hide_sort_default_if_fav","style=\"display:none\"");
		}
		elseif($cat_id=="show_search_ecard"){
			$keyword = mysql_escape_string($keyword);
			//Save Keyword to database
			if($action=="1"){
				$search_count =get_dbvalue("max_search_keyword","search_count_ecard","search_keyword='$keyword' and search_year='$today_year'");
				if($search_count =="" || $search_count =="0"){
					//Insert Keyword to database
					$field_name ="(search_keyword,search_count_ecard,search_year)";
					$field_value ="('$keyword',1,$today_year)";
					insert_data_to_db("max_search_keyword",$field_name,$field_value);
				}
				else{
					//Update search count
					$search_count ++ ;
					update_field_in_db("max_search_keyword","search_count_ecard",$search_count,"search_keyword='$keyword' and search_year='$today_year' LIMIT 1");
				}			
			}

			$list_lang_file =get_list_file("$ecard_root/languages","_lang.php$");
			if($search_in_cat=="all" || $search_in_cat==""){
				if($find_exact=="1"){
					$cond= " ec_caption like '$keyword' or ec_keyword like '$keyword' or ec_detail like '$keyword' ";					
					foreach($list_lang_file as $val){
						if($val !=""){
							$val = str_replace(".php","",$val);
							$val_caption = "ec_caption_" . $val;
							$val_detail = "ec_detail_" . $val;
							$cond .=" or $val_caption like '$keyword' or $val_detail like '$keyword' ";
						}
					}
					$list_data =set_array_from_query("max_ecard","*","ec_active='1' and ec_user_name_id='' and $cond Order by ec_time DESC LIMIT $start,$row_per_page");
					$count_it=get_dbvalue("max_ecard","count(ec_id)","ec_active='1' and ec_user_name_id='' and $cond");
					print_page_number($count_it);
				}
				else{
					$cond= " ec_caption like '%$keyword%' or ec_keyword like '%$keyword%' or ec_detail like '%$keyword%' ";					
					foreach($list_lang_file as $val){
						if($val !=""){
							$val = str_replace(".php","",$val);
							$val_caption = "ec_caption_" . $val;
							$val_detail = "ec_detail_" . $val;
							$cond .=" or $val_caption like '%$keyword%' or $val_detail like '%$keyword%' ";
						}
					}
					$list_data =set_array_from_query("max_ecard","*","ec_active='1' and ec_user_name_id='' and $cond Order by ec_time DESC LIMIT $start,$row_per_page");
					$count_it=get_dbvalue("max_ecard","count(ec_id)","ec_active='1' and ec_user_name_id='' and $cond");
					print_page_number($count_it);
				}
			}
			else{
				$cat_dir_id=get_dbvalue("max_category","cat_dir_id","cat_id='$search_in_cat'");
				if($find_exact=="1"){
					$cond= " ec_cat_relate_id like '%$cat_dir_id%' and ec_caption like '$keyword' or ec_cat_relate_id like '%$cat_dir_id%' and ec_keyword like '$keyword' or ec_cat_relate_id like '%$cat_dir_id%' and ec_detail like '$keyword' ";
					foreach($list_lang_file as $val){
						if($val !=""){
							$val = str_replace(".php","",$val);
							$val_caption = "ec_caption_" . $val;
							$val_detail = "ec_detail_" . $val;
							$cond .=" or ec_cat_relate_id like '%$cat_dir_id%' and $val_caption like '$keyword' or ec_cat_relate_id like '%$cat_dir_id%' and $val_detail like '$keyword' ";
						}
					}
					$list_data =set_array_from_query("max_ecard","*","ec_active='1' and ec_user_name_id='' and $cond Order by ec_time DESC LIMIT $start,$row_per_page");
					$count_it=get_dbvalue("max_ecard","count(ec_id)","ec_active='1' and ec_user_name_id='' and $cond");
					print_page_number($count_it);
				}
				else{
					$cond= " ec_cat_relate_id like '%$cat_dir_id%' and ec_caption like '%$keyword%' or ec_cat_relate_id like '%$cat_dir_id%' and ec_keyword like '%$keyword%' or ec_cat_relate_id like '%$cat_dir_id%' and ec_detail like '%$keyword%' ";
					foreach($list_lang_file as $val){
						if($val !=""){
							$val = str_replace(".php","",$val);
							$val_caption = "ec_caption_" . $val;
							$val_detail = "ec_detail_" . $val;
							$cond .=" or ec_cat_relate_id like '%$cat_dir_id%' and $val_caption like '%$keyword%' or ec_cat_relate_id like '%$cat_dir_id%' and $val_detail like '%$keyword%' ";
						}
					}
					$list_data =set_array_from_query("max_ecard","*","ec_active='1' and ec_user_name_id='' and $cond Order by ec_time DESC LIMIT $start,$row_per_page");
					$count_it=get_dbvalue("max_ecard","count(ec_id)","ec_active='1' and ec_user_name_id='' and $cond");
					print_page_number($count_it);
				}
			}
		}
		else{
			if($no_page==""){
				if($_SESSION[sortby]=="date_desc"){
					$order_by="Order by ec_time DESC";
				}
				elseif($_SESSION[sortby]=="date_asc"){
					$order_by="Order by ec_time";
				}
				elseif($_SESSION[sortby]=="popular_desc"){
					$order_by="Order by ec_time_used DESC";
				}
				elseif($_SESSION[sortby]=="popular_asc"){
					$order_by="Order by ec_time_used";
				}
				elseif($_SESSION[sortby]=="rate_desc"){
					$order_by="Order by ec_rate DESC";
				}
				elseif($_SESSION[sortby]=="rate_asc"){
					$order_by="Order by ec_rate";
				}
				elseif($_SESSION[sortby]=="default" || $_SESSION[sortby]==""){
					$order_by="Order by ec_order,ec_id";
				}

				if($_SESSION[sortby]=="list_card_I_can_send"){
					$list_data=set_array_from_query("max_ecard","*","ec_active='1' and ec_user_name_id='' and ec_cat_id = '$cat_id' and ec_group_relate_id like '%,1,%' or ec_active='1' and ec_user_name_id='' and ec_cat_id = '$cat_id' and ec_group_relate_id like '%,$_SESSION[mg_id],%' Order by ec_rate DESC,ec_time_used DESC LIMIT $start,$row_per_page");
					print_page_number(get_dbvalue("max_ecard","count(ec_id)","ec_active='1' and ec_user_name_id='' and ec_cat_id = '$cat_id' and ec_group_relate_id like '%,1,%' or ec_active='1' and ec_user_name_id='' and ec_cat_id = '$cat_id' and ec_group_relate_id like '%,$_SESSION[mg_id],%' "));
				}
				else{
					$list_data=set_array_from_query("max_ecard","*","ec_active='1' and ec_user_name_id='' and ec_cat_id = '$cat_id' $order_by LIMIT $start,$row_per_page");
					print_page_number(get_dbvalue("max_ecard","count(ec_id)","ec_active='1' and ec_user_name_id='' and ec_cat_id = '$cat_id'"));
				}
			}
			else{
				$list_data=set_array_from_query("max_ecard","*","ec_active='1' and ec_user_name_id='' and ec_cat_id = '$cat_id' ORDER BY ec_order LIMIT $cf_pic_per_row");
				if($no_page=="NO_PAGE_NUMBER")set_global_var("total_ecard_this_cat",get_dbvalue("max_ecard","count(ec_id)","ec_active='1' and ec_user_name_id='' and ec_cat_id = '$cat_id'"));
			}
		}
		
		// Define global template variables
		global $notify_search_empty,$set_birthday_card,$the_template_display_thumbnail,$the_template_show_favorite,$the_template_show_thumb_toolbar,$the_template_show_cat_name_next_step_favorite;

		$count_list=count($list_data);
		$display_thumbnail = $step == 'search_ecard' ? $notify_search_empty : "";
		if ($end > $count_list) $end = $count_list;
		if($count_list>0){
			$display_thumbnail="";
			$xrow=0;
			for ($z=0; $z<$count_list; $z++) {
				$row_data=$list_data[$xrow];
				set_global_var("ecard_id",$row_data[ec_id]);
				//show birthday card setting
				if($_SESSION[mg_allow_send_birthday_to_group]=="1"){
					if($isResponsive)
					$show_birthday_icon="<a class='btn btn-default btn-ecard btn-sm' href=\"$ecard_url/index.php?step=sign_in&next_step=show_birthday_card&action=birtday_card&ec_id=$row_data[ec_id]\"><i title=\"$set_birthday_card\" class='fa fa-birthday-cake' ></i></a>";
					else
					$show_birthday_icon="<a href=\"$ecard_url/index.php?step=sign_in&next_step=show_birthday_card&action=birtday_card&ec_id=$row_data[ec_id]\"><img style=\"cursor:pointer;vertical-align:middle\" border=\"0\" alt=\"$set_birthday_card\" title=\"$set_birthday_card\" src=\"$ecard_url/templates/$cf_set_template/icon_birthday_alert_icon.gif\" /></a>";
				}else{
					$show_birthday_icon="";
				}
				//Show icon preview fullsize
				if($_SESSION[mg_allow_viewfullsize]=="1"){
					if(file_exists("$ecard_root/resource/picture/$row_data[ec_cat_dir]/$row_data[ec_filename]")) {
						list($fullsize_width, $fullsize_height) = getimagesize("$ecard_root/resource/picture/$row_data[ec_cat_dir]/$row_data[ec_filename]");
					}
					else {
						$fullsize_width = $fullsize_height = null ;
					}
					list($fullsize_width, $fullsize_height) = resizeCalculatingImage($fullsize_width, $fullsize_height, 500,500);
					global $cf_enable_watermark;
					if ($cf_enable_watermark) {
						if ($_SESSION[mg_show_watermark]=="1" && (strpos($row_data[ec_filename],".swf")===false)) {
							$show_watermark=true;
						} else {
							$show_watermark=false;
						}
					} else {
						$show_watermark=false;
					}					
					if ($show_watermark) $fullsize_card_url="$ecard_url/index.php?step=watermark&ec_id=$row_data[ec_id]&";
					else $fullsize_card_url="$ecard_url/resource/picture/$row_data[ec_cat_dir]/$row_data[ec_filename]?";
					
					$template_dir="$ecard_url/templates/$cf_set_template";
					//Show ecard caption
					if ($row_data[$my_lang_name] ==""){
						$ECARD_CAPTION = $row_data[ec_caption];
					}
					else{
						$ECARD_CAPTION = $row_data[$my_lang_name];
					}
					$ECARD_CAPTION = str_replace("'","&rsquo;",$ECARD_CAPTION);
					//check youtube link
					if($isResponsive)
					{
						if($row_data[ec_thumbnail]=="")
						{
							$show_preview_fullsize_icon="onclick=\"HideItAll();setCaption('$ECARD_CAPTION');ShowFullsize('$row_data[ec_filename]','0','0');\" title=\"$thumb_tool_preview_fullsize\"";
						}
						else
						{
							if(!(strpos($row_data[ec_filename],".html")===false))
							{
								$show_preview_fullsize_icon="onclick=\"HideItAll();setCaption('$ECARD_CAPTION');ShowFullsize('$fullsize_card_url'+new Date().getTime(),'1','1');\" title=\"$thumb_tool_preview_fullsize\"";
							}
							else
							{
								$show_preview_fullsize_icon="onclick=\"HideItAll();setCaption('$ECARD_CAPTION');ShowFullsize('$fullsize_card_url'+new Date().getTime(),'$fullsize_width','$fullsize_height');\" title=\"$thumb_tool_preview_fullsize\"";
							}
						}
						$show_preview_fullsize_icon = '<button '.$show_preview_fullsize_icon.' class="btn btn-default btn-sm btn-ecard"><i class="fa fa-play-circle"></i></button>';
					}
					else
					{
						if($row_data[ec_thumbnail]=="")
						{
							$show_preview_fullsize_icon="<img onclick=\"HideItAll();ShowFullsize('$row_data[ec_filename]','0','0');\" style=\"cursor:pointer;vertical-align:middle\" border=\"0\" title=\"$thumb_tool_preview_fullsize\" alt=\"$thumb_tool_preview_fullsize\" src=\"$template_dir/images/icon_view.png\" />";
						}
						else
						{
							if(!(strpos($row_data[ec_filename],".html")===false))
							{
								$show_preview_fullsize_icon="<img onclick=\"HideItAll();ShowFullsize('$fullsize_card_url'+new Date().getTime(),'1','1');\" style=\"cursor:pointer;vertical-align:middle\" border=\"0\" title=\"$thumb_tool_preview_fullsize\" alt=\"$thumb_tool_preview_fullsize\" src=\"$template_dir/images/icon_view.png\" />";
							}
							else
							{
								$show_preview_fullsize_icon="<img onclick=\"HideItAll();ShowFullsize('$fullsize_card_url'+new Date().getTime(),'$fullsize_width','$fullsize_height');\" style=\"cursor:pointer;vertical-align:middle\" border=\"0\" title=\"$thumb_tool_preview_fullsize\" alt=\"$thumb_tool_preview_fullsize\" src=\"$template_dir/images/icon_view.png\" />";
							}
						}
					}
				}
				else{
					$show_preview_fullsize_icon="";
				}

				//Show go to category icon
				if($cf_show_goto_category_icon=="1"){
					$cat_row=get_row("max_category","*","cat_id='$row_data[ec_cat_id]'");
					if($cat_row[$cat_lang_name]==""){
						$show_cat_name=str_replace("%show_cat_name%",$cat_row[cat_name_display],$thumb_tool_visit_category);
						$show_cat_name_1 = $cat_row[cat_name_display];
					}
					else{
						$show_cat_name=str_replace("%show_cat_name%",$cat_row[$cat_lang_name],$thumb_tool_visit_category);
						$show_cat_name_1 = $cat_row[cat_name_display];
					}
					set_global_var("show_cat_name_1",$show_cat_name_1);
					$template_dir="$ecard_url/templates/$cf_set_template";
					$category_url=print_url_cards_browse_cate($row_data[ec_cat_id],$cat_row[cat_name_display]);
				}

				//Show icon card is free or for member only
				if($cf_show_free_icon=="1"){
					if($isResponsive)
					{
						if(!(strpos($row_data[ec_group_relate_id],",1,")===false)){
							$thumb_tool=$thumb_tool_free_card;
							$free_or_member_card_icon_url="fa fa-check";
						}
						elseif(!(strpos($row_data[ec_group_relate_id],",$_SESSION[mg_id],")===false)){
							$thumb_tool=$thumb_tool_member_card_ok_to_send;
							$free_or_member_card_icon_url="fa fa-unlock-alt";
						}
						else{
							$thumb_tool=$thumb_tool_member_card;
							$free_or_member_card_icon_url="fa fa-lock";
						}
						$show_free_or_member_card_icon="<span class='btn btn-default btn-ecard btn-sm' title=\"$thumb_tool\" ><i class=\"$free_or_member_card_icon_url\"></i></span>";
					}
					else
					{
						if(!(strpos($row_data[ec_group_relate_id],",1,")===false)){
							$thumb_tool=$thumb_tool_free_card;
							$free_or_member_card_icon_url="$ecard_url/templates/$cf_set_template/icon_free_card.gif";
						}
						elseif(!(strpos($row_data[ec_group_relate_id],",$_SESSION[mg_id],")===false)){
							$thumb_tool=$thumb_tool_member_card_ok_to_send;
							$free_or_member_card_icon_url="$ecard_url/templates/$cf_set_template/icon_member_card_send_ok.gif";
						}
						else{
							$thumb_tool=$thumb_tool_member_card;
							$free_or_member_card_icon_url="$ecard_url/templates/$cf_set_template/icon_member_card_lock.gif";
						}
						$show_free_or_member_card_icon="<img style=\"vertical-align:middle\" border=\"0\" alt=\"$thumb_tool\" title=\"$thumb_tool\" src=\"$free_or_member_card_icon_url\" />";
					}
				}

				//Show icon new card
				if($cf_show_new_icon=="1"){
					if($isResponsive)
					{
						if($row_data[ec_time] >= $time_3dayb4_start && $row_data[ec_time] <= $end_today_timestamp){
							$show_date=str_replace("%show_date%",DateFormat($row_data[ec_time]),$thumb_tool_new_card);
							$template_dir="$ecard_url/templates/$cf_set_template";
							$show_new_icon="<img class='new' alt=\"$show_date\" title=\"$show_date\" src=\"$template_dir/images/new.png\" />";
						}
					}
					else
					{
						if($row_data[ec_time] >= $time_3dayb4_start && $row_data[ec_time] <= $end_today_timestamp){
							$show_date=str_replace("%show_date%",DateFormat($row_data[ec_time]),$thumb_tool_new_card);
							$template_dir="$ecard_url/templates/$cf_set_template";
							$show_new_icon="<img style=\"vertical-align:middle\" border=\"0\" alt=\"$show_date\" title=\"$show_date\" src=\"$template_dir/icon_new_card.gif\" />";
						}
						else{
							$show_date=str_replace("%show_date%",DateFormat($row_data[ec_time]),$thumb_tool_date_add_card);
							$template_dir="$ecard_url/templates/$cf_set_template";
							$show_new_icon="<img border=\"0\" alt=\"$show_date\" title=\"$show_date\" src=\"$template_dir/icon_new_card.gif\" style=\"vertical-align:middle;filter: Alpha(Opacity=40);-moz-opacity:0.4;opacity:0.4;\"/>";
						}
					}
				}

				//Show card thumbnail
				$view_card_url=print_url_card_sendcard($row_data[ec_id],$row_data[ec_caption]);
				$card_thumbnail_url="$ecard_url/resource/picture/$row_data[ec_cat_dir]/$row_data[ec_thumbnail]";
				//if youtube link
				if($row_data[ec_thumbnail]=="")
				{
					$youtube_link=$row_data[ec_filename];
					if(strpos($youtube_link,'&')!=0)
					{
						$vitri=strlen($youtube_link)-strpos($youtube_link,'&');
						$youtube_link_strim=substr($youtube_link,strpos($youtube_link,'v=')+2,-$vitri);
						$show_thumbnail="<a href=\"$view_card_url\"><img class=\"thumbnail_image\" border=\"0\" alt=\"\" src=\"http://img.youtube.com/vi/$youtube_link_strim/0.jpg\" style=\"max-width: {$cf_thumb_width_member_card}px; max-height: {$cf_thumb_height_member_card}px;\" /></a>";
					}
					else
					{
						$youtube_link_strim=substr($youtube_link,strpos($youtube_link,'v=')+2);
						$show_thumbnail="<a href=\"$view_card_url\"><img class=\"thumbnail_image\" border=\"0\" alt=\"\" src=\"http://img.youtube.com/vi/$youtube_link_strim/0.jpg\" style=\"max-width: {$cf_thumb_width_member_card}px; max-height: {$cf_thumb_height_member_card}px;\" /></a>";
					}
				}
				else
				{
						if ($cf_thumb_width_member_card!="" && $cf_thumb_height_member_card!="") {
							$show_thumbnail="<a href=\"$view_card_url\"><img class=\"thumbnail_image\" border=\"0\" alt=\"\" src=\"$card_thumbnail_url\" style=\"max-width: {$cf_thumb_width_member_card}px; max-height: {$cf_thumb_height_member_card}px;\" /></a>";
						} else {
							$show_thumbnail="<a href=\"$view_card_url\"><img class=\"thumbnail_image\" border=\"0\" alt=\"\" src=\"$card_thumbnail_url\" /></a>";
						}
				}
				//Show card type
				if($cf_show_card_type_icon=="1"){
					$swf_chk = strtolower($row_data[ec_filename]);
					if(!(strpos($swf_chk,".swf")===false)){
						$show_img_type = $txt_card_lable_FLASH;
						$show_className=" class=\"bottom_box_card_type flash\" ";
						$show_img_icon ="fa fa-flash";
					}
					else if(!(strpos($swf_chk,".html")===false)){
						$show_img_type = 'html card';
						$show_className=" class=\"bottom_box_card_type html\" ";
						$show_img_icon ="fa fa-file-code-o";
					}
					else if(!(strpos($swf_chk,"youtube.com")===false)){
						$show_img_type = 'youtube card';
						$show_className=" class=\"bottom_box_card_type youtube\" ";
						$show_img_icon ="fa fa-youtube";
					}
					else if(!(strpos($swf_chk,".mp4")===false)||!(strpos($swf_chk,".m4v")===false)||!(strpos($swf_chk,".mov")===false)){
						$show_img_type = "video card";
						$show_className=" class=\"bottom_box_card_type video\" ";
						$show_img_icon ="fa fa-file-video-o";
					}
					else{
						$show_img_type = $txt_card_lable_POSTCARD;
						$show_className=" class=\"bottom_box_card_type postcard\" ";
						$show_img_icon ="fa fa-file-image-o";
					}
					set_global_var("show_className",$show_className);
					set_global_var("show_img_type",$show_img_type);
					set_global_var("show_img_icon",$show_img_icon);
				}

				//Show ecard caption
				if ($row_data[$my_lang_name] ==""){
					set_global_var("ec_caption",$row_data[ec_caption]);
				}
				else{
					set_global_var("ec_caption",$row_data[$my_lang_name]);
				}

				//Show rate card image			
				if($cf_show_rate_star_image =="1"){
					$star_rate_url="$ecard_url/templates/$cf_set_template/rate" .$row_data[ec_rate]. ".gif";
					$show_rate_card="<img style=\"vertical-align:text-bottom\" class=\"card_rate\" alt='Card Rate' src=\"$star_rate_url\" />";
				}
				else{
					$show_rate_card ="";
				}			
				
				$link_to ="$ecard_url/index.php?step=makecard_step1&ec_id=$row_data[ec_id]&lang=$lang";
				
				global $next_step;
				if ($next_step=="show_favorite") {
					set_global_var("show_cat_name_1",$show_cat_name_1);
					set_global_var("view_category_url","$ecard_url/CATEGORY/$row_data[ec_cat_id]");
					set_global_var("show_cat_name_next_step_favorite",get_html_from_layout("templates/$cf_set_template/show_thumbnail_category_item_show_cat_name_next_step_favorite.html",$the_template_show_cat_name_next_step_favorite));
				}
				if($cat_id=="show_favorite" && count($list_fav)>0){
					set_global_var("txt_card_lable_remove_favorite",$txt_card_lable_remove_favorite);
					set_global_var("show_favorite",get_html_from_layout("templates/$cf_set_template/show_thumbnail_category_item_show_favorite.html",$the_template_show_favorite));
				}
				if($cf_show_thumb_toolbar=="1"){
					set_global_var("show_goto_category_icon",$show_goto_category_icon);
					set_global_var("show_preview_fullsize_icon",$show_preview_fullsize_icon);
					set_global_var("show_free_or_member_card_icon",$show_free_or_member_card_icon);
					set_global_var("show_new_icon",$show_new_icon);
					set_global_var("show_birthday_icon",$show_birthday_icon);
					set_global_var("show_thumb_toolbar",get_html_from_layout("templates/$cf_set_template/show_thumbnail_category_item_show_thumb_toolbar.html",$the_template_show_thumb_toolbar));
				}

				//Show price pay per card here				
				if($cf_show_ppc_amount=="1"){
					if(!(strpos($row_data[ec_group_relate_id],",1,")===false)){
						$show_price=price_format("0.00");
					}
					elseif(!(strpos($row_data[ec_group_relate_id],",$_SESSION[mg_id],")===false)){
						$show_price=price_format("0.00");
					}
					else{
						$show_price=get_dbvalue("max_paypercard","ppc_amount","ppc_id='$row_data[ec_ppc_id]'");
						if($show_price=="" || $show_price==0){
							$show_price=price_format("0.00");
						}
						else{
							$show_price=price_format($show_price);					
						}
					}					
					$txt_caption_paypercard2=str_replace("%show_money%",$show_price,$txt_caption_paypercard);
					set_global_var("txt_caption_paypercard2",$txt_caption_paypercard2);
					if($isResponsive)
					{
						$show_price = $show_price == '' ? $show_price : "<h2>$show_price</h2>";
					}
					set_global_var("show_price",$show_price);
				}
				$clearfix = '';
				if($isResponsive)
				{
					$item_width = 12 / $cf_pic_per_row ;
					if($xrow % $cf_pic_per_row == 0) $clearfix = 'clearfix' ;
				}
				set_global_var("clearfix",$clearfix);
				set_global_var("show_rate_card",$show_rate_card);
				set_global_var("show_thumbnail",$show_thumbnail);
				set_global_var("show_caption",$show_caption);
				$display_thumbnail .=get_html_from_layout("templates/$cf_set_template/show_thumbnail_category_item.html",$the_template_display_thumbnail);

				$xrow++;
			}
		}
		if($_SESSION[sortby]=="list_card_I_can_send"){
			$display_thumbnail ="<div style=\"text-align:center\"><a href=\"$ecard_url/index.php?step=$step&next_step=$next_step&cat_id=$cat_id&sortby=default\" class=\"button_link\">$button_use_sortby_default <img border=\"0\" src=\"$ecard_url/templates/$cf_set_template/icon_sortby_default.gif\" alt=\"\" style=\"vertical-align:middle\" /></a></div><br />" . $display_thumbnail;
		}

		return $display_thumbnail;
	}

	//------------------------------------------------------------------
	function print_page_number($count_list,$row_per_page_other=""){
		global $find_exact,$search_in_cat,$keyword,$step,$next_step,$cf_row_per_page,$cf_pic_per_row,$page,$cat_id,$ecard_url,$cf_set_template,$title,$keyword;
		if($row_per_page_other==""){
			$row_per_page = $cf_row_per_page*$cf_pic_per_row;
		}
		else{
			$row_per_page =$row_per_page_other;
		}

		if ($page < 1 || $page=="") 
			$page = 1;
		if ($count_list =="0"){
			$display_page_number = "";
		}
		else{
			$display_page_number ="";

			if ($count_list > $row_per_page){	
				$c = $count_list / $row_per_page;
				if (gettype($c) =="integer"){
					$b = $c;
				}
				else{
					$b = intval(($count_list / $row_per_page) + 1);
				}				
				
				$display_page_number .="<br clear=\"all\" /><ul id=paging class='pagination'>";
				$display_page_number .="      <li>{A}</li>";
				$display_page_number .="      <li>{NUMBER}</td>";
				$display_page_number .="      <li>{B}</li>";
				$display_page_number .="    <br clear=\"all\" />";
				$display_page_number .="</ul>";
				
				$count_number =get_page_count_number($page,$b);
				$display_page_number = str_replace("{NUMBER}", $count_number, $display_page_number);
				
				if ($step=="popular") {
					$url=get_global_var("url_popular_change_page");
				}
				elseif ($step=="top_rate") {
					$url=get_global_var("url_top_rate_change_page");
				}
				elseif ($step=="new_ecards") {
					$url=get_global_var("url_new_ecards_change_page");
				}
				elseif ($step=="category") {
					global $url_cards_browse_cate_change_page;
					$url=$url_cards_browse_cate_change_page;
				}
				elseif ($step=="search_ecard") {
					global $url_search_ecard_keyword_change_page;
					$url=$url_search_ecard_keyword_change_page;
				}
				
				if ($page > 1) {
					$page_pr = $page - 1 ;	
					$url_prev=str_replace("%page_no%","$page_pr",$url);
					$url_prev=str_replace("%cat_id%","$cat_id",$url_prev);
					$url_prev=str_replace("%cat_name%","$title",$url_prev);
					$url_prev=str_replace("%keyword%","$keyword",$url_prev);
					$dpn ="<a href=\"$url_prev\">&laquo;</a>";
					$display_page_number = str_replace("{A}", $dpn, $display_page_number);
				}
				else{
					$display_page_number = str_replace("{A}", "<span>&laquo;</span>", $display_page_number);
				}
				$y=get_global_var("d_num");
				if ($page < $y) {
					$page_ne = $page + 1 ;
					$url_ne=str_replace("%page_no%","$page_ne",$url);
					$url_ne=str_replace("%cat_id%","$cat_id",$url_ne);
					$url_ne=str_replace("%cat_name%","$title",$url_ne);
					$url_ne=str_replace("%keyword%","$keyword",$url_ne);
					$display_page_number = str_replace("{B}", "<a href=\"$url_ne\">&raquo;</a>", $display_page_number);
				}	
				else{
					$display_page_number = str_replace("{B}", "<span>&raquo;</span>", $display_page_number);
				}
			}
		}
		set_global_var("display_page_number",$display_page_number);
		//return $display_page_number;
	}

	//--------------------------------------------------------------------------------------
	function get_page_count_number($page,$b){
		global $find_exact,$search_in_cat,$keyword,$cat_id,$step,$next_step,$title;
		
		if ($step=="popular") {
			$url=get_global_var("url_popular_change_page");
		}
		elseif($step=="top_rate") {
			$url=get_global_var("url_top_rate_change_page");
		}
		elseif ($step=="new_ecards") {
			$url=get_global_var("url_new_ecards_change_page");
		}
		elseif ($step=="category") {
			global $url_cards_browse_cate_change_page;
			$url=$url_cards_browse_cate_change_page;
		}
		elseif ($step=="search_ecard") {
			global $url_search_ecard_keyword_change_page;
			$url=$url_search_ecard_keyword_change_page;
		}
			
		$count_number ="";
		
		$y=0;
		if ($b <10){
			for($a_num=1; $a_num<=$b; $a_num++) {
				$y++;
				if ($a_num == $page) {
					$count_number .="<li class='active'><span >$a_num</span></li>";					
				}
				else {
					$url_page=str_replace("%page_no%","$a_num",$url);
					$url_page=str_replace("%cat_id%","$cat_id",$url_page);
					$url_page=str_replace("%cat_name%","$title",$url_page);
					$url_page=str_replace("%keyword%","$keyword",$url_page);
					$count_number .="<li><a  href=\"$url_page\">$a_num</a></li>";
				}
			}
		}
		elseif(($page > 3) && ($page < ($b-3))){
			for($a_num=1; $a_num<=3; $a_num++) {
				$y++;
				$url_page=str_replace("%page_no%","$a_num",$url);
				$url_page=str_replace("%cat_id%","$cat_id",$url_page);
				$url_page=str_replace("%cat_name%","$title",$url_page);
				$url_page=str_replace("%keyword%","$keyword",$url_page);
				$count_number .="<li><a  href=\"$url_page\">$a_num</a></li>";
			}
			$count_number .="<li><span>...</span></li>";
			for($a_num = $page-1; $a_num<=$page+1; $a_num++) {
				$y++;
				if ($a_num == $page) {
					$count_number .="<li class='active'><span >$a_num</span></li>";
				}
				else {
					$url_page=str_replace("%page_no%","$a_num",$url);
					$url_page=str_replace("%cat_id%","$cat_id",$url_page);
					$url_page=str_replace("%cat_name%","$title",$url_page);
					$url_page=str_replace("%keyword%","$keyword",$url_page);
					$count_number .="<li><a  href=\"$url_page\">$a_num</a></li>";
				}
			}
			$count_number .="<li><span>...</span></li>";
			for($a_num = $b-2; $a_num<=$b; $a_num++) {
				$y++;
				$url_page=str_replace("%page_no%","$a_num",$url);
				$url_page=str_replace("%cat_id%","$cat_id",$url_page);
				$url_page=str_replace("%cat_name%","$title",$url_page);
				$url_page=str_replace("%keyword%","$keyword",$url_page);
				$count_number .="<li><a  href=\"$url_page\">$a_num</a></li>";
			}
		}
		else{
			for($a_num=1; $a_num<=4; $a_num++) {
				$y++;
				if ($a_num == $page) {
					$count_number .="<li class='active'><span >$a_num</span></li>";
				}
				else {
					$url_page=str_replace("%page_no%","$a_num",$url);
					$url_page=str_replace("%cat_id%","$cat_id",$url_page);
					$url_page=str_replace("%cat_name%","$title",$url_page);
					$url_page=str_replace("%keyword%","$keyword",$url_page);
					$count_number .="<li><a  href=\"$url_page\">$a_num</a></li>";
				}
			}
			$count_number .="<li><span>...</span></li>";			
			for($a_num=$b-3; $a_num<=$b; $a_num++) {
				$y++;
				if ($a_num == $page) {
					$count_number .="<li class='active'><span >$a_num</span></li>";
				}
				else {
					$url_page=str_replace("%page_no%","$a_num",$url);
					$url_page=str_replace("%cat_id%","$cat_id",$url_page);
					$url_page=str_replace("%cat_name%","$title",$url_page);
					$url_page=str_replace("%keyword%","$keyword",$url_page);
					$count_number .="<li><a  href=\"$url_page\">$a_num</a></li>";
				}
			}
		}
		set_global_var("d_num",$b);
		return $count_number;
	}
		
?>
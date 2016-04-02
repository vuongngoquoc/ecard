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
	
	if($isResponsive)
	{
		$_ACTI = 'active_'.$what ;
		$$_ACTI = 'active';
		set_global_var($_ACTI,$$_ACTI);
		if($cf_member_can_upload_image=="1"){
			$_ICON = "<i class='fa fa-photo padding5'></i>";
			$button_myalbum_photo="<a href=\"$ecard_url/index.php?step=$step&next_step=$next_step&what=photo\" class=\"button_link_style1 $_CLS\">$_ICON $myalbum_button_goto_photo</a>";
		}
		if($cf_member_can_upload_music=="1"){
			$_ICON = "<i class='fa fa-music padding5'></i>";
			$button_myalbum_music="<a href=\"$ecard_url/index.php?step=$step&next_step=$next_step&what=music\" class=\"button_link_style1 $_CLS\">$_ICON $myalbum_button_goto_music</a>";
		}
		if($cf_option_select_poem=="1" && $cf_member_can_upload_poem=="1"){
			$_ICON = "<i class='fa fa-edit padding5'></i>";
			$button_myalbum_poem="<a href=\"$ecard_url/index.php?step=$step&next_step=$next_step&what=poem\" class=\"button_link_style1 $_CLS\">$_ICON $myalbum_button_goto_poem</a>";
		}
		if($cf_member_can_upload_stamp=="1"){
			$_ICON = "<i class='fa fa-barcode padding5'></i>";
			$button_myalbum_stamp="<a href=\"$ecard_url/index.php?step=$step&next_step=$next_step&what=stamp\" class=\"button_link_style1 $_CLS\">$_ICON $myalbum_button_goto_stamp</a>";
		}
		if($cf_member_can_upload_font=="1"){
			$_ICON = "<i class='fa fa-fonticons padding5'></i>";
			$button_myalbum_font="<a href=\"$ecard_url/index.php?step=$step&next_step=$next_step&what=font\" class=\"button_link_style1 $_CLS\">$_ICON $myalbum_button_goto_font</a>";
		}
		$myalbum_toolbar = get_html_from_layout("templates/$cf_set_template/show_myalbum_toolbar.html");
	}
	
	if($what=="photo" && $cf_member_can_upload_image=="1"){
		require_once ("show_myalbum_photo.php");
	}
	elseif($what=="music" && $cf_member_can_upload_music=="1"){
		require_once ("show_myalbum_music.php");
	}
	elseif($what=="poem" && $cf_option_select_poem=="1"){
		require_once ("show_myalbum_poem.php");
	}
	elseif($what=="stamp" && $cf_member_can_upload_stamp=="1"){
		require_once ("show_myalbum_stamp.php");
	}
	elseif($what=="font" && $cf_member_can_upload_font=="1"){
		require_once ("show_myalbum_font.php");
	}
	else{
		if($isResponsive)
		{
			if($cf_member_can_upload_image=="1"){
				$show_myalbum_photo="<div class=\"myalbum_items_style\"><table border=\"0\" width=\"100%\"><tr><td width=\"70\" valign=\"top\"><i class='fa fa-photo title-icon padding5'></i></td><td valign=\"top\">$myalbum_info_photo<br /><br />$button_myalbum_photo</td></tr></table><hr class=\"HR_Color\" /></div>";
			}

			if($cf_member_can_upload_music=="1"){
				$show_myalbum_music="<div class=\"myalbum_items_style\"><table border=\"0\" width=\"100%\"><tr><td width=\"70\" valign=\"top\"><i class='fa fa-music title-icon padding5'></i></td><td valign=\"top\">$myalbum_info_music<br /><br />$button_myalbum_music</td></tr></table><hr class=\"HR_Color\" /></div>";
			}
			
			if($cf_option_select_poem=="1" && $cf_member_can_upload_poem=="1"){
				$show_myalbum_poem="<div class=\"myalbum_items_style\"><table border=\"0\" width=\"100%\"><tr><td width=\"70\" valign=\"top\"><i class='fa fa-edit title-icon padding5'></i></td><td valign=\"top\">$myalbum_info_poem<br /><br />$button_myalbum_poem</td></tr></table><hr class=\"HR_Color\" /></div>";
			}

			if($cf_member_can_upload_stamp=="1"){
				$show_myalbum_stamp="<div class=\"myalbum_items_style\"><table border=\"0\" width=\"100%\"><tr><td width=\"70\" valign=\"top\"><i class='fa fa-barcode title-icon padding5'></i></td><td valign=\"top\">$myalbum_info_stamp<br /><br />$button_myalbum_stamp</td></tr></table><hr class=\"HR_Color\" /></div>";
			}

			if($cf_member_can_upload_font=="1"){
				$show_myalbum_font="<div class=\"myalbum_items_style\"><table border=\"0\" width=\"100%\"><tr><td width=\"70\" valign=\"top\"><i class='fa fa-fonticons title-icon padding5'></i></td><td valign=\"top\">$myalbum_info_font<br /><br />$button_myalbum_font</td></tr></table></div>";
			}
		}
		else
		{
			if($cf_member_can_upload_image=="1"){
				$show_myalbum_photo="<div class=\"myalbum_items_style\"><table border=\"0\" width=\"100%\"><tr><td width=\"70\" valign=\"top\"><img border=\"0\" alt=\"\" src=\"$ecard_url/templates/$cf_set_template/icon_myalbum_photo.gif\" /></td><td valign=\"top\">$myalbum_info_photo<br /><br /><a href=\"$ecard_url/index.php?step=$step&next_step=$next_step&what=photo\" class=\"button_link_style1\"><img border=\"0\" alt=\"\" src=\"$ecard_url/templates/$cf_set_template/icon_member_upload_photo.gif\" style=\"vertical-align:middle\" /> $myalbum_button_goto_photo</a><br /><br /></td></tr></table><hr class=\"HR_Color\" /></div>";
			}

			if($cf_member_can_upload_music=="1"){
				$show_myalbum_music="<div class=\"myalbum_items_style\"><table border=\"0\" width=\"100%\"><tr><td width=\"70\" valign=\"top\"><img border=\"0\" alt=\"\" src=\"$ecard_url/templates/$cf_set_template/icon_myalbum_music.gif\" /></td><td valign=\"top\">$myalbum_info_music<br /><br /><a href=\"$ecard_url/index.php?step=$step&next_step=$next_step&what=music\" class=\"button_link_style1\"><img border=\"0\" alt=\"\" src=\"$ecard_url/templates/$cf_set_template/icon_member_upload_audio.gif\" style=\"vertical-align:middle\" /> $myalbum_button_goto_music</a><br /><br /></td></tr></table><hr class=\"HR_Color\" /></div>";
			}
			
			if($cf_option_select_poem=="1" && $cf_member_can_upload_poem=="1" ){
				$show_myalbum_poem="<div class=\"myalbum_items_style\"><table border=\"0\" width=\"100%\"><tr><td width=\"70\" valign=\"top\"><img border=\"0\" alt=\"\" src=\"$ecard_url/templates/$cf_set_template/icon_myalbum_poem.gif\" /></td><td valign=\"top\">$myalbum_info_poem<br /><br /><a href=\"$ecard_url/index.php?step=$step&next_step=$next_step&what=poem\" class=\"button_link_style1\"><img border=\"0\" alt=\"\" src=\"$ecard_url/templates/$cf_set_template/icon_member_upload_poem.gif\" style=\"vertical-align:middle\" /> $myalbum_button_goto_poem</a><br /><br /></td></tr></table><hr class=\"HR_Color\" /></div>";
			}

			if($cf_member_can_upload_stamp=="1"){
				$show_myalbum_stamp="<div class=\"myalbum_items_style\"><table border=\"0\" width=\"100%\"><tr><td width=\"70\" valign=\"top\"><img border=\"0\" alt=\"\" src=\"$ecard_url/templates/$cf_set_template/icon_myalbum_stamp.gif\" /></td><td valign=\"top\">$myalbum_info_stamp<br /><br /><a href=\"$ecard_url/index.php?step=$step&next_step=$next_step&what=stamp\" class=\"button_link_style1\"><img border=\"0\" alt=\"\" src=\"$ecard_url/templates/$cf_set_template/icon_member_upload_stamp.gif\" style=\"vertical-align:middle\" /> $myalbum_button_goto_stamp</a><br /><br /></td></tr></table><hr class=\"HR_Color\" /></div>";
			}

			if($cf_member_can_upload_font=="1"){
				$show_myalbum_font="<div class=\"myalbum_items_style\"><table border=\"0\" width=\"100%\"><tr><td width=\"70\" valign=\"top\"><img border=\"0\" alt=\"\" src=\"$ecard_url/templates/$cf_set_template/icon_myalbum_font.gif\" /></td><td valign=\"top\">$myalbum_info_font<br /><br /><a href=\"$ecard_url/index.php?step=$step&next_step=$next_step&what=font\" class=\"button_link_style1\"><img border=\"0\" alt=\"\" src=\"$ecard_url/templates/$cf_set_template/icon_member_upload_font.gif\" style=\"vertical-align:middle\" /> $myalbum_button_goto_font</a><br /><br /></td></tr></table></div>";
			}
		}

		//Display random banner HR & VT
		print_banner("0");
		print_banner("1");	

		$array_global_var[print_object]=get_html_from_layout("templates/$cf_set_template/show_myalbum.html");
		print_header_and_footer();
	}	
?>
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

	//Print button Select Java applet (Image effect) cf_option_select_java
	if((strpos($ec_row[ec_filename],".swf")===false) && $cf_option_select_java=="1"){ //if not flash card & cf_option_select_java=1
		$count_list_of_applet=get_dbvalue("max_java_applet","count(java_id)","java_active='1'");
		$button_select_image_effect=<<<EOF
<span class="button" id="button_select_image_effect" onclick="HideItAll();HideImageApplet();ShowDiv(this.id,'div_select_java_applet',0,0,1);CallJavaFrameSrc();">$sendcard_php_button_select_image_effect</span>
<div id="div_select_java_applet" class="div_menu_layer" style="width:200px;text-align:left">
	<table width="100%" cellspacing="0" cellpadding="0">
		<tr onclick="HideItAll();ShowImageApplet();">
			<td class="div_menu_layer_title_bar" title="$icon_title_close_hide">$sendcard_php_button_select_image_effect ($count_list_of_applet)</td>
			<td class="div_menu_layer_title_bar" align="right" style="padding:0px"><img border="0" src="$ecard_url/templates/$cf_set_template/icon_button_close.gif" title="$icon_title_close_hide" alt="$icon_title_close_hide" style="vertical-align:middle" /></td>
		</tr>
	</table>
	<iframe frameborder="0" height="200px" width="200px" scrolling="auto" id="java_frame" name="java_frame" src="" ></iframe>
</div>
EOF;
	}

	//Print button Select Skin background
	if($cf_option_select_skin=="1"){ 		
		$count_list_of_skin=get_dbvalue("max_skin","count(skin_id)","skin_active='1'");
		$button_select_skin=<<<EOF
<li class="dropdown">
<a onclick="CallSkinFrameSrc();" data-toggle="dropdown" href="#">
  $sendcard_php_button_select_skin_background <span class="caret"></span>
</a>
<ul class="dropdown-menu popup-sendcard" id="load_skin"></ul>
</li>
EOF;
	}

	//Print button Select Stamp
	if($cf_option_select_stamp=="1"){
		$count_list_of_stamp=get_dbvalue("max_stamp","count(stamp_id)","stamp_active='1' and stamp_user_name_id='' or stamp_user_name_id='$_SESSION[user_name_id]'");
		$button_select_stamp=<<<EOF
<li class="dropdown">
<a onclick="CallStampFrameSrc();" data-toggle="dropdown" href="#">
  $sendcard_php_button_select_stamp <span class="caret"></span>
</a>
<ul class="dropdown-menu popup-sendcard" id="load_stamp"></ul>
</li> 		
EOF;
	}

	//Print button Select music
	if($cf_option_user_select_music=="1"){
		$count_list_of_music=get_dbvalue("max_music","count(music_id)","music_active='1' and music_user_name_id='' or music_user_name_id='$_SESSION[user_name_id]'");
		$button_select_music=<<<EOF
<li class="dropdown">
<a onclick="CallMusicFrameSrc();" data-toggle="dropdown" href="#">
  $sendcard_php_button_select_music <span class="caret"></span>
</a>
<ul class="dropdown-menu popup-sendcard" id="load_music"></ul>
</li> 		
EOF;
	}

	//Print button Select Poem
	if($cf_option_select_poem=="1"){
		$list_data =set_array_from_query("max_poem","*","poem_active='1' and poem_user_name_id='' or poem_active='1' and poem_user_name_id='$_SESSION[user_name_id]' Order by poem_user_name_id DESC,poem_order,poem_title");
        $categories = set_array_from_query("max_poem_category","*","0=0 ORDER BY name");
		$count_list_of_poem=count($list_data);
		$show_list_poem = $show_list_poem_hidden_div = "";
		$poem_div="";
        foreach($categories as $cat) {
            $category_id = $cat["id"];
            $numItems = 0;
            $temp = "";
            foreach($list_data as $row_data){
                if(empty($row_data['poem_cat'])) {
                    $row_data['poem_cat'] = $categories[0]['id'];
                }
                if($row_data['poem_cat'] == $cat['id']) {
                    if($row_data[poem_user_name_id]==""){
                        $poem_icon="<i class='fa fa-edit padding5 icon-poem'></i>";
                    }
                    else{
                        $poem_icon="<i class='fa fa-edit padding5 icon-poem'></i>";
                    }
                    $item_poem_id=$row_data[poem_id];
                    $poem_title=$row_data[poem_title];
                    $poem_author=$row_data[poem_author];

                    //Load poem to <div> to let user select/view them
                    $row_data[poem_body]=str_replace("<br>","<br />",$row_data[poem_body]);
                    $row_data[poem_body]=str_replace("\r\n","<br />",$row_data[poem_body]);
                    $row_data[poem_body]=str_replace("\n","<br />",$row_data[poem_body]);
                    $poem_body=$row_data[poem_body];
                    $poem_title=strtoupper($row_data[poem_title]);

                    $temp .=get_html_from_layout("templates/$cf_set_template/sendcard_show_option_toolbar_button_select_poem_item.html",$the_template_show_list_poem);
                    $show_list_poem_hidden_div.=get_html_from_layout("templates/$cf_set_template/sendcard_show_option_toolbar_button_select_poem_item_hidden_div.html",$the_template_show_list_poem_hidden_div);
                    $numItems++;
                }
            }

            $show_list_poem .= "<li class='dropdown-submenu' onclick='toggleMe('poem{$category_id}')'><a href='#' tabindex='-1' data-toggle='dropdown'>".$cat['name']."(".$numItems.")</a></li>".$temp;

        }
		echo $show_list_poem_hidden_div; //div nam trong ul hidden khong duoc tinh la elm, nen tach ra cho no hien thi rieng
		$button_select_poem=<<<EOF
<li class="dropdown">
<a data-toggle="dropdown" href="#">
  $sendcard_php_button_select_poem <span class="caret"></span>
</a>
<ul class="dropdown-menu popup-sendcard" id="load_poem">
<li>
<a href='#'>$sendcard_php_txt_align
	<input onclick="if(document.ecardmax_personalize)document.ecardmax_personalize.cs_poem_align.value='left';poem_id_align='left';Previewskin();HideItAll();" type="radio" name="poem_align" value="left" /> $sendcard_php_txt_align_left	
	<input onclick="if(document.ecardmax_personalize)document.ecardmax_personalize.cs_poem_align.value='center';poem_id_align='center';Previewskin();HideItAll();" type="radio" name="poem_align" value="center" checked="checked" /> $sendcard_php_txt_align_center
	<input onclick="if(document.ecardmax_personalize)document.ecardmax_personalize.cs_poem_align.value='right';poem_id_align='right';Previewskin();HideItAll();" type="radio" name="poem_align" value="right" /> $sendcard_php_txt_align_right
</a>
</li>
<li><a href='javascript:;' onclick="if(document.ecardmax_personalize)document.ecardmax_personalize.cs_poem.value='';poem_id='';Previewskin();HideItAll();"><i class='fa fa-remove padding5'></i>$sendcard_php_no_poem</a></li>
$show_list_poem
</ul>
</li> 

EOF;
	}
	else {
		$poem_row=get_row("max_poem","*","poem_id='$poem_id'");
		$poem_row[poem_body]=str_replace("<br>","<br />",$poem_row[poem_body]);
		$poem_row[poem_body]=str_replace("\r\n","<br />",$poem_row[poem_body]);
		$poem_row[poem_body]=str_replace("\n","<br />",$poem_row[poem_body]);
		$button_select_poem=<<<EOF
<div style="display:none;" id="card_poem$poem_id"><br /><strong>$poem_row[poem_title]</strong><br />Author: $poem_row[poem_author]<br /><br />$poem_row[poem_body]<br /></div>
EOF;
	}

	//Print button Rate card
	if($_SESSION[mg_allow_rate]=="1" && $_SESSION[ec_user_name_id]=="" && $cf_show_rate_star_image=="1"){		
		$button_rate_card=<<<EOF
<span class="button" id="button_rate_card">
		<img title='½' onclick="gorate('5');" onmouseout='rateme_out();' onMouseover="rateme_over('5');" id="img5" border="0" src="$ecard_url/templates/$cf_set_template/rateme0_l.gif"><img onclick="gorate('10');" onMouseover="rateme_over('10');" title='1' onmouseout='rateme_out()' id="img10" src="$ecard_url/templates/$cf_set_template/rateme0_r.gif"><img title='1½' onclick="gorate('15');" onMouseover="rateme_over('15');" onmouseout='rateme_out()' id="img15" border="0" src="$ecard_url/templates/$cf_set_template/rateme0_l.gif"><img onclick="gorate('20');" onMouseover="rateme_over('20');" title='2' onmouseout='rateme_out()' id="img20" src="$ecard_url/templates/$cf_set_template/rateme0_r.gif"><img title='2½' onclick="gorate('25');" onMouseover="rateme_over('25');" onmouseout='rateme_out()' id="img25" border="0" src="$ecard_url/templates/$cf_set_template/rateme0_l.gif"><img onclick="gorate('30');" onMouseover="rateme_over('30');" title='3' onmouseout='rateme_out()' id="img30" src="$ecard_url/templates/$cf_set_template/rateme0_r.gif"><img title='3½' onclick="gorate('35');" onMouseover="rateme_over('35');" onmouseout='rateme_out()' id="img35" border="0" src="$ecard_url/templates/$cf_set_template/rateme0_l.gif"><img onclick="gorate('40');" onMouseover="rateme_over('40');" title='4' onmouseout='rateme_out()' id="img40" src="$ecard_url/templates/$cf_set_template/rateme0_r.gif"><img title='4½' onclick="gorate('45');" onMouseover="rateme_over('45');" onmouseout='rateme_out()' id="img45" border="0" src="$ecard_url/templates/$cf_set_template/rateme0_l.gif"><img onclick="gorate('50');" onMouseover="rateme_over('50');" title='5' onmouseout='rateme_out()' id="img50" src="$ecard_url/templates/$cf_set_template/rateme0_r.gif">
<span />
EOF;
	}

	//Print button card info
	if($cf_show_ecard_info_box=="1" && $_SESSION[ec_user_name_id]==""){
		//Show date added card to database
		$show_date_added=DateFormat($ec_row[ec_time]);

		//Show card category name
		$ec_cat_row=get_row("max_category","*","cat_id='$ec_row[ec_cat_id]'");
		$my_lang_name="cat_".str_replace(".php","",$_SESSION[ecardmax_lang]);
		if($ec_cat_row[$my_lang_name]==""){
			$display_cat_name=$ec_cat_row[cat_name_display];
			$thumb_tool_visit_category=str_replace("%show_cat_name%","$ec_cat_row[cat_name_display]",$thumb_tool_visit_category);
			$category_id=$ec_cat_row[cat_id];
			$category_name_display=$ec_cat_row[cat_name_display];
		}
		else{
			$display_cat_name=$ec_cat_row[$my_lang_name];
			$thumb_tool_visit_category=str_replace("%show_cat_name%","$ec_cat_row[$my_lang_name]",$thumb_tool_visit_category);
			$category_id=$ec_cat_row[cat_id];
			$category_name_display=$ec_cat_row[$my_lang_name];
		}

		//Show card caption
		$my_lang_name="ec_caption_".str_replace(".php","",$_SESSION[ecardmax_lang]);
		if($ec_row[$my_lang_name]==""){
			$show_card_caption="$ec_row[ec_caption]";
		}
		else{
			$show_card_caption="$ec_row[$my_lang_name]";
		}

		//Show card detail
		$my_lang_name="ec_detail_".str_replace(".php","",$_SESSION[ecardmax_lang]);
		if($ec_row[$my_lang_name]==""){
			$show_card_detail="$ec_row[ec_detail]";
		}
		else{
			$show_card_detail="$ec_row[$my_lang_name]";
		}

		//Show card keyword
		$array_keyword=split(",",$ec_row[ec_keyword]);
		$show_card_keyword="";
		foreach($array_keyword as $key){
			$show_card_keyword.="<a href=\"".print_url_search_ecard_keyword($key)."\">$key</a>";
		}

		//Show member group permission
		$array_group=split(",",$ec_row[ec_group_relate_id]);
		foreach($array_group as $ec_mg_id){
			if(trim($ec_mg_id)!=""){
				$show_member_group.=get_dbvalue("max_member_group","mg_title","mg_id='$ec_mg_id'")."<br />";
			}
		}

		//Show card rate
		$ec_rate=$ec_row[ec_rate];		

		//Show card time sent
		$show_card_time_sent=$ec_row[ec_time_used];

		$cat_url=print_url_cards_browse_cate($category_id,$ec_cat_row[cat_name_display]);
				$div_card_info=<<<EOF
	<table class="table table-striped" width="100%" >
		<tr class="table_td_background">
			<td width="30%">$cardinfo_date_added</td>
			<td>$show_date_added</td>
		</tr>
		<tr class="table_td_background">
			<td width="30%">$cardinfo_category_name</td>
			<td><a href="$cat_url">$category_name_display &nbsp; &nbsp; <i class='fa fa-step-forward' title='$thumb_tool_visit_category'></i></a></td>
		</tr>
		<tr class="table_td_background">
			<td width="30%">$cardinfo_caption</td>
			<td>$show_card_caption</td>
		</tr>
		<tr class="table_td_background">
			<td width="30%">$cardinfo_detail</td>
			<td>$show_card_detail</td>
		</tr>
		<tr class="table_td_background">
			<td width="30%">$cardinfo_keyword</td>
			<td>$show_card_keyword</td>
		</tr>
		<tr class="table_td_background">
			<td width="30%">$cardinfo_group_permission</td>
			<td>$show_member_group</td>
		</tr>
		<tr class="table_td_background">
			<td width="30%">$cardinfo_rated</td>
			<td><img border="0" alt="" src="$ecard_url/templates/$cf_set_template/rate$ec_rate.gif" /></td>
		</tr>
		<tr class="table_td_background">
			<td width="30%">$cardinfo_time_sent</td>
			<td>$show_card_time_sent</td>
		</tr>
	</table> 	
EOF;
		$button_card_info=<<<EOF
<a class="btn btn-default btn-sm" href="javascript:;" onclick="showModalCardInfo();" ><i class="fa fa-list-alt padding5"></i>$sendcard_php_button_card_info</a>
EOF;
	}


	// Print button print ecard
	if ($cf_show_ecard_print=="1"){
		$button_card_printer=<<<EOF
<span class="button"  id="button_card_print" onclick="javascript:window.open('$ecard_url/index.php?step=print_ecard&ec_id=$ec_id','','scrollbars=yes,menubar=yes,height=660,width=1000,resizable=yes,toolbar=yes,location=yes,status=yes');">$sendcard_php_button_print_this_card</span>		
EOF;
	}
	
	//Print option toolbar
	$show_option_toolbar=get_html_from_layout("templates/$cf_set_template/sendcard_show_option_toolbar.html");
?>
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
	//$array_global_var[print_object]=get_html_from_layout("templates/$cf_set_template/show_calendar_js.html");
	//print_header_and_footer();
	//exit;
	define ("ADAY", (60*60*24));
	if (!checkdate($month,1,$year)){
		$month = $today_mon;
		$year = $today_year;
	}
	$start = gmmktime (0, 0, 0, $month, 1, $year);	
	$firstDayArrayp[month] = gmdate("n",$start);
	$firstDayArrayp[mday] = gmdate("j",$start);
	$firstDayArrayp[year] = gmdate("Y",$start);
	$firstDayArray[wday] =gmdate("w",$start);
	
	if($month==1){
		$last_year=$year - 1;
		if($last_year < $today_year) {
			$last_year=$today_year;
		}
		$text_next_month=$Feb;
		$text_prv_month=$Dec;
		$url_next_month="$ecard_url/index.php?step=$step&next_step=$next_step&month=2&year=$year&mode=$mode&selected_day=$selected_day&selected_month=$selected_month&selected_year=$selected_year&year_from=$year_from&year_to=$year_to";
		$url_prv_month="$ecard_url/index.php?step=$step&next_step=$next_step&month=12&year=$last_year&mode=$mode&selected_day=$selected_day&selected_month=$selected_month&selected_year=$selected_year&year_from=$year_from&year_to=$year_to";
	}
	elseif($month==12){
		$next_year=$year+1;
		$text_next_month=$Jan;
		$text_prv_month=$Nov;
		$url_next_month="$ecard_url/index.php?step=$step&next_step=$next_step&month=1&year=$next_year&mode=$mode&selected_day=$selected_day&selected_month=$selected_month&selected_year=$selected_year&year_from=$year_from&year_to=$year_to";
		$url_prv_month="$ecard_url/index.php?step=$step&next_step=$next_step&month=11&year=$year&mode=$mode&selected_day=$selected_day&selected_month=$selected_month&selected_year=$selected_year&year_from=$year_from&year_to=$year_to";
	}
	else{
		$next_month=$month + 1;
		$prv_month=$month - 1;
		if($month==2){
			$text_next_month=$Mar;
			$text_prv_month=$Jan;
		}
		elseif($month==3){
			$text_next_month=$Apr;
			$text_prv_month=$Feb;
		}
		elseif($month==4){
			$text_next_month=$May;
			$text_prv_month=$Mar;
		}
		elseif($month==5){
			$text_next_month=$Jun;
			$text_prv_month=$Apr;
		}
		elseif($month==6){
			$text_next_month=$Jul;
			$text_prv_month=$May;
		}
		elseif($month==7){
			$text_next_month=$Aug;
			$text_prv_month=$Jun;
		}
		elseif($month==8){
			$text_next_month=$Sep;
			$text_prv_month=$Jul;
		}
		elseif($month==9){
			$text_next_month=$Oct;
			$text_prv_month=$Aug;
		}
		elseif($month==10){
			$text_next_month=$Nov;
			$text_prv_month=$Sep;
		}
		elseif($month==11){
			$text_next_month=$Dec;
			$text_prv_month=$Oct;
		}
		$url_next_month="$ecard_url/index.php?step=$step&next_step=$next_step&month=$next_month&year=$year&mode=$mode&selected_day=$selected_day&selected_month=$selected_month&selected_year=$selected_year&year_from=$year_from&year_to=$year_to";
		$url_prv_month="$ecard_url/index.php?step=$step&next_step=$next_step&month=$prv_month&year=$year&mode=$mode&selected_day=$selected_day&selected_month=$selected_month&selected_year=$selected_year&year_from=$year_from&year_to=$year_to";
	}

	//Build dropdown Month & Year
	$print_drop_down_month="<select name=\"month\" onchange=\"document.calendar_form.submit();\">\n";
	$months = Array("$Jan","$Feb","$Mar","$Apr","$May","$Jun","$Jul","$Aug","$Sep","$Oct","$Nov","$Dec");
	for ($x=1; $x<=count($months); $x++){
		$print_drop_down_month.="\t<option value='$x'";
		$print_drop_down_month.=($x == $month)? " selected='selected'":"";
		$print_drop_down_month.=">" . $months[$x-1]."</option>\n";
	}
	$print_drop_down_month.="</select>";

	$print_drop_down_year="<select name=\"year\" onchange=\"document.calendar_form.submit();\">\n";
	if($year_from=="" && $year_to==""){
		$year_from=$today_year;
		$year_to=$today_year+20;
	}
	for ($x=$year_from; $x<=$year_to; $x++){
		$print_drop_down_year.="\t<option";
		$print_drop_down_year.=($x == $year)? " selected='selected'":"";
		$print_drop_down_year.=">$x</option>\n" ;
	}
	$print_drop_down_year.="</select>";

	$html_mon_year_table=<<<EOF
<table align="center" width="100%" class="calendar_border_background" cellspacing="0" cellpadding="4">
	<tr class="calendar_nav_title">
		<td width="5%" align="left" style="white-space:nowrap"><a href="$url_prv_month" style="text-decoration:none;"><img border="0" alt="" src="$ecard_url/templates/$cf_set_template/prv.gif" style="vertical-align:middle" /> $text_prv_month</a></td>
		<td width="*%" align="center" style="white-space:nowrap">
			<form name="calendar_form" action="index.php" method="post" >
				<input type="hidden" name="step" value="$step" />
				<input type="hidden" name="next_step" value="$next_step" />
				<input type="hidden" name="mode" value="$mode" />
				<input type="hidden" name="selected_day" value="$selected_day" />
				<input type="hidden" name="selected_month" value="$selected_month" />
				<input type="hidden" name="selected_year" value="$selected_year" />
				<input type="hidden" name="year_from" value="$year_from" />
				<input type="hidden" name="year_to" value="$year_to" />
				$print_drop_down_month $print_drop_down_year
			</form>
		</td>
		<td width="5%" align="right" style="white-space:nowrap"><a href="$url_next_month" style="text-decoration:none;">$text_next_month <img border="0" alt="" src="$ecard_url/templates/$cf_set_template/next.gif" style="vertical-align:middle" /></a></td>
	</tr>
</table><div style="line-height:4px"></div>
EOF;

	//Build calendar table
	$days = Array("$Sunday", "$Monday", "$Tuesday", "$Wednesday", "$Thursday", "$Friday", "$Saturday");
	$html_calendar_table="<table align=\"center\" width=\"100%\" class=\"calendar_border_background\" cellspacing=\"1\" cellpadding=\"4\"><tr class=\"calendar_week_title\">\n";
	foreach ($days as $day) {
		$html_calendar_table.="\t<td align=\"center\" width=\"40\">$day</td>\n";
	}
	
	//Get list holiday event
	$list_event=set_array_from_query("max_event","*");

	//Get list user birthday
	$list_birthday=set_array_from_query("max_addressbook","*","book_birth_mon<>'0' and book_birth_mday<>'0' and book_user_name_id='$_SESSION[user_name_id]'");

	//Get list user anniversary
	$list_anni=set_array_from_query("max_addressbook","*","book_special_mon<>'0' and book_special_mday<>'0' and book_user_name_id='$_SESSION[user_name_id]'");

	//Get list reminder
	$list_reminder=set_array_from_query("max_reminder","*","rm_month<>'0' and rm_day<>'0' and rm_user_name_id='$_SESSION[user_name_id]'");


	for ($count=0; $count < (6*7); $count++){
		$firstDayArray2[month] = gmdate("n",$start);
		$firstDayArray2[mday] = gmdate("j",$start);
		$firstDayArray2[year] = gmdate("Y",$start);
		$firstDayArray2[wday] =gmdate("w",$start);

		if ((($count) % 7) == 0){
			if ($firstDayArray2[month] != $month)
				break;
				$html_calendar_table.="</tr>\n<tr style=\"line-height:17px\">\n";
		}
		
		if ($count < $firstDayArray[wday] || $firstDayArray2[month] != $month) {
			$html_calendar_table.="\t<td></td>\n";
		}
		else {
			//Get holiday event 
			$event_holiday=get_event($firstDayArray2[month],$firstDayArray2[mday]);

			//Get birthday
			$event_birthday=get_event_birthday($firstDayArray2[month],$firstDayArray2[mday]);

			//Get anniversary
			$event_anni=get_event_anni($firstDayArray2[month],$firstDayArray2[mday]);

			//Get reminder
			$event_reminder=get_event_reminder($firstDayArray2[month],$firstDayArray2[mday]);			
			
			if ($start==$begin_today_timestamp){



				$html_calendar_table.="\t<td style=\"height:100px;text-align:left;vertical-align:top\" class=\"cell_today\" $cell_style title=\"$firstDayArray2[month]/$firstDayArray2[mday]/$firstDayArray2[year]\" onMouseover=\"this.className='cell_mouseover';\" onMouseout=\"this.className='cell_today';\" width='14%'><strong>$firstDayArray2[mday]</strong><span class=\"cell_text_today\">$txt_calendar_today</span><div style=\"line-height:8px;\"></div>$event_holiday$event_birthday$event_anni$event_reminder</td>\n";
			}
			elseif($start < $begin_today_timestamp && $mode!="1"){
				$html_calendar_table.="\t<td style=\"height:100px;text-align:left;vertical-align:top\" class=cell_pastday $cell_style width='14%'>$firstDayArray2[mday]<div style=\"line-height:8px;\"></div>$event_holiday$event_birthday$event_anni$event_reminder</td>\n";
			}
			else{
				$html_calendar_table.="\t<td style=\"height:100px;text-align:left;vertical-align:top;\" class=\"cell_futureday\" $cell_style title=\"$firstDayArray2[month]/$firstDayArray2[mday]/$firstDayArray2[year]\" onMouseover=\"this.className='cell_mouseover';\" onMouseout=\"this.className='cell_futureday';\" width='14%'><a href=\"index.php?step=sign_in&next_step=show_reminder&show_add_table=1&show_time=$firstDayArray2[month]/$firstDayArray2[mday]/$firstDayArray2[year]\" class=\"day_link\">$firstDayArray2[mday]</a><div style=\"line-height:8px;\"></div>$event_holiday$event_birthday$event_anni$event_reminder</td>\n";
			}
			$start += ADAY;

		}
	}
	$html_calendar_table .="</tr></table>";

	$html_local_time="<span style=\"font-size:8pt\">GMT: <strong>$_SESSION[user_timezone]</strong> - $calendar_txt_local_time_is: <strong>". DateFormat($gmt_timestamp_now) ."</strong></span>";
	
	$html_table ="<div style=\"padding:7px\">$html_mon_year_table $html_calendar_table$html_local_time</div>";

	//Display random banner HR & VT
	print_banner("0");
	//print_banner("1"); --> no vertical banner here

	$array_global_var[print_object]=$html_table;
	/*
	print_header_and_footer();
	
	//--------------------------------------------------------------------
	function get_event($emon,$eday){
		global $list_event,$cf_set_template,$ecard_url;

		$ev_names="";
		foreach ($list_event as $ev_row){
			if($ev_row[event_month]==$emon && $ev_row[event_day]==$eday){
				$ev_names .= "<div id=\"ev$ev_row[event_id]\"><img border=\"0\" alt=\"\" src=\"$ecard_url/templates/$cf_set_template/cal_holiday.gif\" /> <a href=\"$ev_row[event_url]\" class=\"event_text_link\">$ev_row[event_name]</a></div>";
			}
		}

		return $ev_names;
	}

	//--------------------------------------------------------------------
	function get_event_birthday($emon,$eday){
		global $list_birthday,$addressbook_txt_reminder_birthday,$cf_set_template,$ecard_url;

		$ev_names="";
		foreach ($list_birthday as $ev_row){
			if($ev_row[book_birth_mon]==$emon && $ev_row[book_birth_mday]==$eday){
				$ev_names .= "<div id=\"birthday$ev_row[book_id]\"><img border=\"0\" alt=\"\" src=\"$ecard_url/templates/$cf_set_template/cal_birthday.gif\" /> <a href=\"$ecard_url/index.php?step=sign_in&next_step=show_addressbook&show_user_id=$ev_row[book_id]\" class=\"event_text_link\">$ev_row[book_fname] $addressbook_txt_reminder_birthday</a></div>";
			}
		}

		return $ev_names;
	}

	//--------------------------------------------------------------------
	function get_event_anni($emon,$eday){
		global $list_anni,$addressbook_txt_reminder_anni,$cf_set_template,$ecard_url;

		$ev_names="";
		foreach ($list_anni as $ev_row){
			if($ev_row[book_special_mon]==$emon && $ev_row[book_special_mday]==$eday){
				$ev_names .= "<div id=\"anni$ev_row[book_id]\"><img border=\"0\" alt=\"\" src=\"$ecard_url/templates/$cf_set_template/cal_anniversary.gif\" /> <a href=\"$ecard_url/index.php?step=sign_in&next_step=show_addressbook&show_user_id=$ev_row[book_id]\" class=\"event_text_link\">$ev_row[book_fname] $addressbook_txt_reminder_anni</a></div>";
			}
		}

		return $ev_names;
	}

	//--------------------------------------------------------------------
	function get_event_reminder($emon,$eday){
		global $list_reminder,$cf_set_template,$ecard_url;

		$ev_names="";
		foreach ($list_reminder as $ev_row){
			if($ev_row[rm_month]==$emon && $ev_row[rm_day]==$eday){
				$ev_names .= "<div id=\"anni$ev_row[rm_id]\"><img border=\"0\" alt=\"\" src=\"$ecard_url/templates/$cf_set_template/cal_reminder.gif\" /> <a href=\"$ecard_url/index.php?step=sign_in&next_step=show_reminder&show_user_id=$ev_row[rm_id]\" class=\"event_text_link\">$ev_row[rm_title]</a></div>";
			}
		}

		return $ev_names;
	}*/
?>
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
	
	define ("ADAY", (60*60*24));
	$navigator_link="<a href=\"".get_global_var(url_home)."\">$txt_home</a> <img border=\"0\" alt=\"\" src=\"$ecard_url/templates/$cf_set_template/arrow_nav.gif\" style=\"vertical-align:middle\" /> <a href=\"".$url_calendar_home."\">$txt_mtool_calendar</a>";
	if ($month=="MM" || $month=="" || $month=="undefined") { $month=$today_mon; }	
	if ($year=="YYYY" || $year=="" || $year=="undefined" || $year=="YYYY)") { $year=$today_year; }
	
	if (!checkdate($month,1,$year)){
		$month = $today_mon;
		$year = $today_year;
	}
	$start = gmmktime (0, 0, 0, $month, 1, $year);	
	$firstDayArrayp[month] = gmdate("n",$start);
	$firstDayArrayp[mday] = gmdate("j",$start);
	$firstDayArrayp[year] = gmdate("Y",$start);
	$firstDayArray[wday] =gmdate("w",$start);

	if($cf_show_date_option =="1"){ //DD MM YYYY
		$ins_date_caption="$firstDayArray2[mday]/$firstDayArray2[month]/$firstDayArray2[year] (DD/MM/YYYY)" ;
		$ins_date_data="$firstDayArray2[mday]/$firstDayArray2[month]/$firstDayArray2[year]" ;
	}
	elseif($cf_show_date_option =="2"){ //YYYY DD MM
		$ins_date_caption="$firstDayArray2[year]/$firstDayArray2[mday]/$firstDayArray2[month] (YYYY/DD/MM)" ;
		$ins_date_data="$firstDayArray2[year]/$firstDayArray2[mday]/$firstDayArray2[month]" ;
	}
	elseif($cf_show_date_option =="3"){ //YYYY MM DD
		$ins_date_caption="$firstDayArray2[year]/$firstDayArray2[month]/$firstDayArray2[mday] (YYYY/MM/DD)" ;
		$ins_date_data="$firstDayArray2[year]/$firstDayArray2[month]/$firstDayArray2[mday]" ;
	}
	
	if($month==1){
		$last_year=$year - 1;
		if($last_year < $today_year) {
			$last_year=$today_year;
		}

		$url_next_month="$ecard_url/index.php?step=$step&month=2&year=$year&mode=$mode&selected_day=$selected_day&selected_month=$selected_month&selected_year=$selected_year&year_from=$year_from&year_to=$year_to";
		$url_prv_month="$ecard_url/index.php?step=$step&month=12&year=$last_year&mode=$mode&selected_day=$selected_day&selected_month=$selected_month&selected_year=$selected_year&year_from=$year_from&year_to=$year_to";
	}
	elseif($month==12){
		$next_year=$year+1;
		$url_next_month="$ecard_url/index.php?step=$step&month=1&year=$next_year&mode=$mode&selected_day=$selected_day&selected_month=$selected_month&selected_year=$selected_year&year_from=$year_from&year_to=$year_to";
		$url_prv_month="$ecard_url/index.php?step=$step&month=11&year=$year&mode=$mode&selected_day=$selected_day&selected_month=$selected_month&selected_year=$selected_year&year_from=$year_from&year_to=$year_to";
	}
	else{
		$next_month=$month + 1;
		$prv_month=$month - 1;
		$url_next_month="$ecard_url/index.php?step=$step&month=$next_month&year=$year&mode=$mode&selected_day=$selected_day&selected_month=$selected_month&selected_year=$selected_year&year_from=$year_from&year_to=$year_to";
		$url_prv_month="$ecard_url/index.php?step=$step&month=$prv_month&year=$year&mode=$mode&selected_day=$selected_day&selected_month=$selected_month&selected_year=$selected_year&year_from=$year_from&year_to=$year_to";
	}

$ca_html=<<<EOF
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<title>Calendar</title>
<meta http-equiv="Content-Type" content="text/html; charset=$charset" />
<meta http-equiv="pragma" content="no-cache">
<meta http-equiv="EXPIRES" content="-1">
<style type="text/css">
<!--
@import url($ecard_url/templates/$cf_set_template/css/calendar.css);
-->
</style>

<script language="JavaScript" type="text/javascript">	
	function SetFormat(data) {
		var get_cid=self.parent.get_cid;
		self.parent.HideItAll();
		self.parent.InsertDate(get_cid,data);				 
	}
</script>

</head>

<body style="padding:2px;margin-top:0px;margin-left:0px;background-color:#FCF4DC;">
<table align="center" width="245px" class="calendar_border_background" cellspacing="0" cellpadding="4">
<tr class="calendar_nav_title">
<td width="5%" align="left"><a href="$url_prv_month"><img border="0" alt="" src="$ecard_url/templates/$cf_set_template/prv.gif" style="vertical-align:middle" /></a></td>
<td width="*%" align="center" style="white-space:nowrap">

<form name="calendar_form" action="index.php" method="post" >
<input type="hidden" name="step" value="calendar" />
<input type="hidden" name="mode" value="$mode" />
<input type="hidden" name="selected_day" value="$selected_day" />
<input type="hidden" name="selected_month" value="$selected_month" />
<input type="hidden" name="selected_year" value="$selected_year" />
<input type="hidden" name="year_from" value="$year_from" />
<input type="hidden" name="year_to" value="$year_to" />

<select name="month" style="width:115px;font-size:8pt;height:17px" onchange='document.calendar_form.submit();'>
EOF;

	$months = Array("$Jan","$Feb","$Mar","$Apr","$May","$Jun","$Jul","$Aug","$Sep","$Oct","$Nov","$Dec");
	
	for ($x=1; $x<=count($months); $x++){
		$ca_html.= "\t<option value='$x'";
		$ca_html.= ($x == $month)? " selected='selected'":"";
		$ca_html.= ">" . $months[$x-1]."</option>\n";
	}
	$ca_html.="</select>";
	$ca_html.="<select name=\"year\" style=\"font-size:8pt;height:17px\" onchange='document.calendar_form.submit();'>";

	if($year_from=="" && $year_to==""){
		$year_from=$today_year;
		$year_to=$today_year+20;
	}

	for ($x=$year_from; $x<=$year_to; $x++){
		$ca_html.= "\t<option";
		$ca_html.= ($x == $year)? " selected='selected'":"";
		$ca_html.= ">$x</option>\n" ;
	}
$ca_html.=<<<EOF
</select>
</form>
</td>
<td width="5%" align="right"><a href="$url_next_month"><img border="0" alt="" src="$ecard_url/templates/$cf_set_template/next.gif" style="vertical-align:middle" /></a></td>
</tr>
</table><div style="line-height:4px"></div>
EOF;

	if($year<1970){
		$start = gmmktime (0, 0, 0, $month, 1, 1970);
	}
	$days = Array("$Sun", "$Mon", "$Tue", "$Wed", "$Thu", "$Fri", "$Sat");
	$ca_html.= "<table align=\"center\" width=\"245px\" class=\"calendar_border_background\" cellspacing=\"1\" cellpadding=\"4\"><tr class=\"calendar_week_title\">\n";

	foreach ($days as $day) {
		$ca_html.= "\t<td align=\"center\" width=\"40\" style=\"font-size:8pt\">$day</td>\n";
	}

	for ($count=0; $count < (6*7); $count++){
		$firstDayArray2[month] = gmdate("n",$start);
		$firstDayArray2[mday] = gmdate("j",$start);
		if($year<1970){
			$firstDayArray2[year] = $year;		
		}
		else{
			$firstDayArray2[year] = gmdate("Y",$start);
		}
		$firstDayArray2[wday] =gmdate("w",$start);

		if ((($count) % 7) == 0){
			if ($firstDayArray2[month] != $month)
				break;
				$ca_html.= "</tr>\n<tr style=\"line-height:17px\">\n";
		}
		
		if ($count < $firstDayArray[wday] || $firstDayArray2[month] != $month) {
			$ca_html.= "\t<td></td>\n";
		}
		else {	
			if($cf_show_date_option =="0"){ //MM DD YYYY
				$ins_date_caption="$firstDayArray2[month]/$firstDayArray2[mday]/$firstDayArray2[year] (MM/DD/YYYY)" ;
				$ins_date_data="$firstDayArray2[month]/$firstDayArray2[mday]/$firstDayArray2[year]" ;
			}
			elseif($cf_show_date_option =="1"){ //DD MM YYYY
				$ins_date_caption="$firstDayArray2[mday]/$firstDayArray2[month]/$firstDayArray2[year] (DD/MM/YYYY)" ;
				$ins_date_data="$firstDayArray2[mday]/$firstDayArray2[month]/$firstDayArray2[year]" ;
			}
			elseif($cf_show_date_option =="2"){ //YYYY DD MM
				$ins_date_caption="$firstDayArray2[year]/$firstDayArray2[mday]/$firstDayArray2[month] (YYYY/DD/MM)" ;
				$ins_date_data="$firstDayArray2[year]/$firstDayArray2[mday]/$firstDayArray2[month]" ;
			}
			elseif($cf_show_date_option =="3"){ //YYYY MM DD
				$ins_date_caption="$firstDayArray2[year]/$firstDayArray2[month]/$firstDayArray2[mday] (YYYY/MM/DD)" ;
				$ins_date_data="$firstDayArray2[year]/$firstDayArray2[month]/$firstDayArray2[mday]" ;
			}
			
			if ($start==$begin_today_timestamp){



				if($selected_day==$firstDayArray2[mday] && $selected_month==$firstDayArray2[month] && $selected_year==$firstDayArray2[year]){
					$class_name="cell_today_hilight";
				}
				else{
					$class_name="cell_today";
				}
				$ca_html.= "\t<td style=\"cursor:pointer;\" class=\"$class_name\" title=\"$ins_date_caption\" onclick=\"SetFormat('$ins_date_data')\" onmouseover=\"this.className='cell_mouseover';\" onmouseout=\"this.className='$class_name';\" width='14%'><strong>$firstDayArray2[mday]</strong></td>\n";
			}
			elseif($start < $begin_today_timestamp && $mode!="1"){
				if($selected_day==$firstDayArray2[mday] && $selected_month==$firstDayArray2[month] && $selected_year==$firstDayArray2[year]){
					$class_name="cell_pastday_hilight";
				}
				else{
					$class_name="cell_pastday";
				}
				$ca_html.= "\t<td class=\"$class_name\" width='14%'>$firstDayArray2[mday]</td>\n";
			}
			else{
				if($selected_day==$firstDayArray2[mday] && $selected_month==$firstDayArray2[month] && $selected_year==$firstDayArray2[year]){
					$class_name="cell_futureday_hilight";
				}
				else{
					$class_name="cell_futureday";
				}
				$ca_html.= "\t<td style=\"cursor:pointer;\" class=\"$class_name\" title=\"$ins_date_caption\" onclick=\"SetFormat('$ins_date_data')\" onmouseover=\"this.className='cell_mouseover';\" onmouseout=\"this.className='$class_name';\" width='14%'>$firstDayArray2[mday]</td>\n";
			}
			$start += ADAY;
		}
	}


	$ca_html.= "</tr></table>";
	$ca_html.="</body></html>";
	print $ca_html;
	
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
	*/
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
	}
	
?>
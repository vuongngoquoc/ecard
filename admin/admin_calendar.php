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
	if(ECARDMAX!=1)exit;
	if ($admin_login != $crypt_pass){
		//Show login page
		print get_html_from_layout("admin/html/show_login.html");
		exit;
	}	
	
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

		$url_next_month="index.php?step=$step&month=2&year=$year&mode=$mode&selected_day=$selected_day&selected_month=$selected_month&selected_year=$selected_year";
		$url_prv_month="index.php?step=$step&month=12&year=$last_year&mode=$mode&selected_day=$selected_day&selected_month=$selected_month&selected_year=$selected_year";
	}
	elseif($month==12){
		$next_year=$year+1;
		$url_next_month="index.php?step=$step&month=1&year=$next_year&mode=$mode&selected_day=$selected_day&selected_month=$selected_month&selected_year=$selected_year";
		$url_prv_month="index.php?step=$step&month=11&year=$year&mode=$mode&selected_day=$selected_day&selected_month=$selected_month&selected_year=$selected_year";
	}
	else{
		$next_month=$month + 1;
		$prv_month=$month - 1;
		$url_next_month="index.php?step=$step&month=$next_month&year=$year&mode=$mode&selected_day=$selected_day&selected_month=$selected_month&selected_year=$selected_year";
		$url_prv_month="index.php?step=$step&month=$prv_month&year=$year&mode=$mode&selected_day=$selected_day&selected_month=$selected_month&selected_year=$selected_year";
	}


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<title><?=$calendar_txt_calendar?></title>
<style type="text/css">
form {margin-bottom : 0; }

body, td{	
	font-family: Tahoma,Verdana, Arial;
	font-size: 9pt;
	color: black;
}

a {
	font-family: Verdana, Tahoma, Arial;
	font-size: 11px;
	font-weight: bold;
}
a:link {
	color: #800000;
}
a:visited {
	color: #6C6C6C;
}
a:hover {
	color: #8A6B0D; 
}

a:active {
	color: #ff0000;
}

.cell_today{
	background-image: url(html/07_title_background.gif);
	line-height:17px;
	cursor:pointer;
	text-align:center;
}

.cell_pastday{
	background-color: #EAEAEA;
	line-height:17px;
	font-size:8pt;
	text-align:center;
	font-weight:normal;
	color:gray;
	cursor:default;
}

.cell_futureday{
	background-color: #FCF4DC;
	line-height:17px;
	text-align:center;
	font-weight:normal;
	color:black;
	cursor:default;
}

.cell_mouseover{
	background-image: url(html/07_title_background3.gif);
	line-height:17px;
	cursor:pointer;
	text-align:center;
}

</style>

<script language="JavaScript" type="text/javascript">	
	function SetFormat(data) {
		var get_cid=self.parent.get_cid;
		self.parent.InsertDate(get_cid,data);		
		self.parent.HideItAll(); 
	}
</script>

</head>

<body style="margin-top:4px;margin-left:0px;background-color:#FCF4DC;">
<table align="center" width="250px" style="background-color:silver" cellspacing="1" cellpadding="4">
<tr style="background-image: url(html/07_title_background2.gif);line-height:17px;">
<td width="5%" align="left"><a href="<?php print $url_prv_month;?>"><img border="0" alt="" src="html/prv.gif" style="vertical-align:middle" /></a></td>
<td width="*%" align="center" style="white-space:nowrap">

<form name=calendar_form action="index.php" method="post" >
<input type="hidden" name="step" value="admin_calendar" />
<input type="hidden" name="mode" value="<?php print $mode;?>" />
<input type="hidden" name="selected_day" value="<?php print $selected_day;?>" />
<input type="hidden" name="selected_month" value="<?php print $selected_month;?>" />
<input type="hidden" name="selected_year" value="<?php print $selected_year;?>" />

<select name="month" onChange='document.calendar_form.submit();'>
<?php

	$months = Array("$calendar_txt_january","$calendar_txt_february","$calendar_txt_march","$calendar_txt_april","$calendar_txt_may","$calendar_txt_june","$calendar_txt_july","$calendar_txt_august","$calendar_txt_september","$calendar_txt_october","$calendar_txt_november","$calendar_txt_december");
	
	for ($x=1; $x<=count($months); $x++){
		print "\t<option value='$x'";
		print ($x == $month)? " selected='selected'":"";
		print ">" . $months[$x-1]."</option>\n";
	}

?>

</select>

<select name=year onChange='document.calendar_form.submit();'>
<?php

	for ($x=$today_year; $x<=$today_year+20; $x++){
		print "\t<option";
		print ($x == $year)? " selected='selected'":"";
		print ">$x</option>\n" ;
	}

?>
</select>
</form>
</td>
<td width="5%" align="right"><a href="<?php print $url_next_month;?>"><img border="0" alt="" src="html/next.gif" style="vertical-align:middle" /></a></td>
</tr>
</table><div style="line-height:4px"></div>

<?php
$days = Array("$calendar_txt_sun", "$calendar_txt_mon", "$calendar_txt_tue", "$calendar_txt_wed", "$calendar_txt_thu", "$calendar_txt_fri", "$calendar_txt_sat");
print "<table align=\"center\" width=\"250px\" style=\"background-color:silver\" cellspacing=\"1\" cellpadding=\"4\"><tr style=\"background-image: url(html/07_title_background.gif);line-height:17px;font-weight:bold\">\n";

foreach ($days as $day) {
	print "\t<td align=\"center\" width=\"40\">$day</td>\n";
}

for ($count=0; $count < (6*7); $count++){
	$firstDayArray2[month] = gmdate("n",$start);
	$firstDayArray2[mday] = gmdate("j",$start);
	$firstDayArray2[year] = gmdate("Y",$start);
	$firstDayArray2[wday] =gmdate("w",$start);

	if ((($count) % 7) == 0){
		if ($firstDayArray2[month] != $month)
			break;
			print "</tr>\n<tr style=\"line-height:17px\">\n";
	}
	
	if ($count < $firstDayArray[wday] || $firstDayArray2[month] != $month) {
		print "\t<td></td>\n";
	}
	else {
		if($selected_day==$firstDayArray2[mday] && $selected_month==$firstDayArray2[month] && $selected_year==$firstDayArray2[year]){
			$cell_style="style=\"border:1px solid red;\" ";
		}
		else{
			$cell_style="";
		}

		if ($start==$begin_today_timestamp){
			print "\t<td class=\"cell_today\" $cell_style title=\"Insert Date $firstDayArray2[month]/$firstDayArray2[mday]/$firstDayArray2[year]\" onClick=\"SetFormat('$firstDayArray2[month]/$firstDayArray2[mday]/$firstDayArray2[year]')\" onMouseover=\"this.className='cell_mouseover';\" onMouseout=\"this.className='cell_today';\" width='14%'><strong>$firstDayArray2[mday]</strong></td>\n";
		}
		elseif($start < $begin_today_timestamp && $mode!="1"){
			print "\t<td class=cell_pastday $cell_style width='14%'>$firstDayArray2[mday]</td>\n";
		}
		else{
			print "\t<td class=cell_futureday $cell_style title=\"Insert Date $firstDayArray2[month]/$firstDayArray2[mday]/$firstDayArray2[year]\" onClick=\"SetFormat('$firstDayArray2[month]/$firstDayArray2[mday]/$firstDayArray2[year]')\" onMouseover=\"this.className='cell_mouseover';\" onMouseout=\"this.className='cell_futureday';\" width='14%'>$firstDayArray2[mday]</td>\n";
		}
		$start += ADAY;
	}
}

print "</tr></table>";
?>

</body>
</html>

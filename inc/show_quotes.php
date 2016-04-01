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
	require_once ("show_category.php");
	$list_data=set_array_from_query("max_poem","*","poem_active=1 order by poem_author");
	$show_list="";
	foreach($list_data as $row_data){
		$quote_body=$row_data[poem_body];
		$quote_author=$row_data[poem_author];
		$quote_title=$row_data[poem_title];
		$show_list.=get_html_from_layout("templates/$cf_set_template/show_quote_of_the_day_table_item.html",$the_templates_show_quote_of_the_day_table_item);
	}
	$display_thumbnail=get_html_from_layout("templates/$cf_set_template/show_quote_of_the_day_table.html");
	#$display_thumbnail=get_html_from_layout("templates/$cf_set_template/show_join_now.html");
?>
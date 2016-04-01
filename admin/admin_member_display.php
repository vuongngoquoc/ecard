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
	

	if($what=="delete_account"){
		foreach($http_vars as $key=>$val){
			if(!(strpos($key,"mylist_id")===false)){ //if true
				$selected_id =str_replace("mylist_id","",$key);												

				//Find Free Family account 
				$free1 =get_dbvalue("max_ecuser","user_member1","user_id='$selected_id'");
				$free2 =get_dbvalue("max_ecuser","user_member2","user_id='$selected_id'");
				
				//NOW
				if($cl_month == $today_mon && $cl_day == $today_mday && $cl_year==$today_year){
					if($action == 0){ //Suspend acct

						//Update user_beclosed = 1 + user_dateclose = time stamp today + user_request_cancel=1
						update_field_in_db2("max_ecuser","user_beclosed='1',user_dateclose='$begin_today_timestamp',user_request_cancel='1'","user_id='$selected_id'");	
						
						if($free1 != ""){
							update_field_in_db2("max_ecuser","user_beclosed='1',user_dateclose='$begin_today_timestamp',user_request_cancel='1'","user_name_id='$free1'");	
						}
						if($free2 != ""){
							update_field_in_db2("max_ecuser","user_beclosed='1',user_dateclose='$begin_today_timestamp',user_request_cancel='1'","user_name_id='$free2'");	
						}

					}
					elseif($action == 1){//Delete
						detele_account($selected_id);
						if($free1 != "") {
							$free1_id =get_dbvalue("max_ecuser","user_id","user_name_id='$free1'");
							detele_account($free1_id);
						}
						if($free2 != "") {
							$free2_id =get_dbvalue("max_ecuser","user_id","user_name_id='$free2'");
							detele_account($free2_id);
						}
					}
					elseif($action == 2){//Down grade to free account
						//Find 2 sub acct and down grade them
						if($free1 != "") {
							//Update sub acct to user_mg_id = 2
							update_field_in_db2("max_ecuser","user_mg_id='2'","user_name_id='$free1'");
						}
						if($free2 != "") {
							//Update sub acct to user_mg_id = 2
							update_field_in_db2("max_ecuser","user_mg_id='2'","user_name_id='$free2'");
						}

						//Update main acct user_mg_id = 2
						update_field_in_db2("max_ecuser","user_mg_id='2'","user_id='$selected_id'");
					}
				}
				else{
					$time_input = gmmktime(0,0,0,$cl_month,$cl_day,$cl_year);
					if($action == 0){ //Suspend acct
						//Update user_beclosed = 1 + user_dateclose = time stamp today + user_request_cancel=1
						update_field_in_db2("max_ecuser","user_beclosed='1',user_dateclose='$time_input',user_request_cancel='1'","user_id='$selected_id'");							

						if($free1 != ""){
							update_field_in_db2("max_ecuser","user_beclosed='1',user_dateclose='$time_input',user_request_cancel='1'","user_name_id='$free1'");	
						}

						if($free2 != ""){
							update_field_in_db2("max_ecuser","user_beclosed='1',user_dateclose='$time_input',user_request_cancel='1'","user_name_id='$free2'");	
						}						
					}
					elseif($action == 1){//Delete
						//Update user_beclosed = 2 (use cron to delete) + user_dateclose = time stamp today + user_request_cancel=1
						update_field_in_db2("max_ecuser","user_beclosed='2',user_dateclose='$time_input',user_request_cancel='1'","user_id='$selected_id'");

						if($free1 != ""){
							update_field_in_db2("max_ecuser","user_beclosed='2',user_dateclose='$time_input',user_request_cancel='1'","user_name_id='$free1'");	
						}

						if($free2 != ""){
							update_field_in_db2("max_ecuser","user_beclosed='2',user_dateclose='$time_input',user_request_cancel='1'","user_name_id='$free2'");	
						}												
					}
					elseif($action == 2){//Down grade to free account 
						//Update user_beclosed = 3 (use cron to do it) + user_dateclose = time stamp today + user_request_cancel=1
						update_field_in_db2("max_ecuser","user_beclosed='3',user_dateclose='$time_input',user_request_cancel='1'","user_id='$selected_id'");

						if($free1 != ""){
							update_field_in_db2("max_ecuser","user_beclosed='3',user_dateclose='$time_input',user_request_cancel='1'","user_name_id='$free1'");	
						}

						if($free2 != ""){
							update_field_in_db2("max_ecuser","user_beclosed='3',user_dateclose='$time_input',user_request_cancel='1'","user_name_id='$free2'");	
						}						
					}
				}
			}
		}		
		$show_info ="$member_display_message_member_account_updated";
		$what="";
		set_global_var("what","");
	}
	elseif($what=="undo_delete"){
		//Update user_dateclose + user_beclosed 
		update_field_in_db2("max_ecuser","user_beclosed='0',user_dateclose='0',user_request_cancel='0'","user_id='$user_id'");

		//Update Sub Free Family account if found
		$free1 =get_dbvalue("max_ecuser","user_member1","user_id='$user_id'");
		$free2 =get_dbvalue("max_ecuser","user_member2","user_id='$user_id'");

		if($free1 != ""){
			update_field_in_db2("max_ecuser","user_beclosed='0',user_dateclose='0',user_request_cancel='0'","user_name_id='$free1'");
		}

		if($free2 != ""){
			update_field_in_db2("max_ecuser","user_beclosed='0',user_dateclose='0',user_request_cancel='0'","user_name_id='$free2'");
		}
		$what="";
		set_global_var("what","");
	}
	elseif($what=="set_member_group_all"){
		if($mg_id!="" && $mg_id > 1){
			$list_user_id=get_dblistvalue("max_ecuser","user_id");
			foreach($list_user_id as $user_id){
				update_field_in_db("max_ecuser","user_mg_id",$mg_id,"user_id='$user_id' LIMIT 1");
			}
		}
		$what="";
		set_global_var("what","");
	}

	$keyword=stripslashes(trim($keyword));
	$keyword=str_replace("'","",$keyword);
	$keyword=str_replace("\"","",$keyword);
	$keyword2=urlencode($keyword);

	if($row_number =="" || $row_number =="0" || !is_numeric($row_number)) $row_number = 15;
	set_global_var("row_number",$row_number);
	$row_per_page = $row_number;
				
	if ($page < 1 || $page=="") $page =1;
	$start = ($page-1)* 1 * $row_per_page;
	$end = $start + 1 * $row_per_page;

	set_global_var("selected_list_item_" . $list_item,"selected=\"selected\"");
	set_global_var("selected_search_field_" . $search_field,"selected=\"selected\"");
	set_global_var("selected_num_day_" . $num_day,"selected=\"selected\"");
	set_global_var("selected_num_what_" . $num_what,"selected=\"selected\"");
	
	$total_member=get_dbvalue("max_ecuser","count(user_id)");
	set_global_var("total_member",$total_member);

	
	if($cmd_button =="List"){
		if($list_item == "all"){
			$list_data =set_array_from_query("max_ecuser","*","user_member1<>'0' Order by user_name_id LIMIT $start,$row_per_page");
			$count_list=get_dbvalue("max_ecuser","count(user_id)","user_member1<>'0'");
			$member_display_txt_list_all_members=str_replace("%total_member%","$total_member",$member_display_txt_list_all_members);
			$show_info ="$member_display_txt_list_all_members";
		}
		elseif($list_item == "all_DESC"){
			$list_data =set_array_from_query("max_ecuser","*","user_member1<>'0' Order by user_name_id DESC LIMIT $start,$row_per_page");
			$count_list=get_dbvalue("max_ecuser","count(user_id)","user_member1<>'0'");
			$member_display_txt_list_all_members=str_replace("%total_member%","$total_member",$member_display_txt_list_all_members);
			$show_info ="$member_display_txt_list_all_members";
		}
		elseif($list_item == "all2"){
			$list_data =set_array_from_query("max_ecuser","*","user_member1<>'0' Order by user_mg_id LIMIT $start,$row_per_page");
			$count_list=get_dbvalue("max_ecuser","count(user_id)","user_member1<>'0'");
			$member_display_txt_list_all_members=str_replace("%total_member%","$total_member",$member_display_txt_list_all_members);
			$show_info ="$member_display_txt_list_all_members";
		}
		elseif($list_item == "all2_DESC"){
			$list_data =set_array_from_query("max_ecuser","*","user_member1<>'0' Order by user_mg_id DESC LIMIT $start,$row_per_page");
			$count_list=get_dbvalue("max_ecuser","count(user_id)","user_member1<>'0'");
			$member_display_txt_list_all_members=str_replace("%total_member%","$total_member",$member_display_txt_list_all_members);
			$show_info ="$member_display_txt_list_all_members";
		}
		elseif($list_item == "new_today"){
			$list_data =set_array_from_query("max_ecuser","*","user_member1<>'0' and user_date_signup >= $begin_today_timestamp and user_date_signup <= $end_today_timestamp Order by user_name_id LIMIT $start,$row_per_page");
			$count_list=get_dbvalue("max_ecuser","count(user_id)","user_member1<>'0' and user_date_signup >= $begin_today_timestamp and user_date_signup <= $end_today_timestamp");
			$member_display_txt_show_member_sign_up_today_time_frame_from_before_today_to_today=str_replace("%count_list%","$count_list",$member_display_txt_show_member_sign_up_today_time_frame_from_before_today_to_today);
			$member_display_txt_show_member_sign_up_today_time_frame_from_before_today_to_today=str_replace("%begin_today_timestamp%",DateFormat($begin_today_timestamp),$member_display_txt_show_member_sign_up_today_time_frame_from_before_today_to_today);
			$member_display_txt_show_member_sign_up_today_time_frame_from_before_today_to_today=str_replace("%end_today_timestamp%",DateFormat($end_today_timestamp),$member_display_txt_show_member_sign_up_today_time_frame_from_before_today_to_today);
			$show_info ="$member_display_txt_show_member_sign_up_today_time_frame_from_before_today_to_today";
		}
		elseif($list_item == "new_yesterday"){
			$list_data =set_array_from_query("max_ecuser","*","user_member1<>'0' and user_date_signup >= $begin_yesterday_timestamp and user_date_signup <= $end_yesterday_timestamp Order by user_name_id LIMIT $start,$row_per_page");
			$count_list=get_dbvalue("max_ecuser","count(user_id)","user_member1<>'0' and user_date_signup >= $begin_yesterday_timestamp and user_date_signup <= $end_yesterday_timestamp");
			$member_display_txt_show_member_sign_up_yesterday_time_frame_from_before_yesterday_to_yesterday=str_replace("%count_list%","$count_list",$member_display_txt_show_member_sign_up_yesterday_time_frame_from_before_yesterday_to_yesterday);
			$member_display_txt_show_member_sign_up_yesterday_time_frame_from_before_yesterday_to_yesterday=str_replace("%begin_yesterday_timestamp%",DateFormat($begin_yesterday_timestamp),$member_display_txt_show_member_sign_up_yesterday_time_frame_from_before_yesterday_to_yesterday);
			$member_display_txt_show_member_sign_up_yesterday_time_frame_from_before_yesterday_to_yesterday=str_replace("%end_yesterday_timestamp%",DateFormat($end_yesterday_timestamp),$member_display_txt_show_member_sign_up_yesterday_time_frame_from_before_yesterday_to_yesterday);
			$show_info ="$member_display_txt_show_member_sign_up_yesterday_time_frame_from_before_yesterday_to_yesterday";
		}
		elseif($list_item == "new_week"){
			$list_data =set_array_from_query("max_ecuser","*","user_member1<>'0' and user_date_signup >= $begin_this_week_timestamp and user_date_signup <= $end_this_week_timestamp Order by user_name_id LIMIT $start,$row_per_page");
			$count_list=get_dbvalue("max_ecuser","count(user_id)","user_member1<>'0' and user_date_signup >= $begin_this_week_timestamp and user_date_signup <= $end_this_week_timestamp");
			$member_display_txt_show_member_sign_up_this_week_time_frame_from_before_this_week=str_replace("%count_list%","$count_list",$member_display_txt_show_member_sign_up_this_week_time_frame_from_before_this_week);
			$member_display_txt_show_member_sign_up_this_week_time_frame_from_before_this_week=str_replace("%begin_this_week_timestamp%",DateFormat($begin_this_week_timestamp),$member_display_txt_show_member_sign_up_this_week_time_frame_from_before_this_week);
			$member_display_txt_show_member_sign_up_this_week_time_frame_from_before_this_week=str_replace("%end_this_week_timestamp%",DateFormat($end_this_week_timestamp),$member_display_txt_show_member_sign_up_this_week_time_frame_from_before_this_week);
			$show_info ="$member_display_txt_show_member_sign_up_this_week_time_frame_from_before_this_week";
		}
		elseif($list_item == "new_month"){
			$list_data =set_array_from_query("max_ecuser","*","user_member1<>'0' and user_date_signup >= $begin_this_month_timestamp and user_date_signup <= $end_this_month_timestamp Order by user_name_id LIMIT $start,$row_per_page");
			$count_list=get_dbvalue("max_ecuser","count(user_id)","user_member1<>'0' and user_date_signup >= $begin_this_month_timestamp and user_date_signup <= $end_this_month_timestamp");
			$member_display_txt_show_member_sign_up_this_week_time_frame_from_before_this_month=str_replace("%count_list%","$count_list",$member_display_txt_show_member_sign_up_this_week_time_frame_from_before_this_month);
			$member_display_txt_show_member_sign_up_this_week_time_frame_from_before_this_month=str_replace("%begin_this_month_timestamp%",DateFormat($begin_this_month_timestamp),$member_display_txt_show_member_sign_up_this_week_time_frame_from_before_this_month);
			$member_display_txt_show_member_sign_up_this_week_time_frame_from_before_this_month=str_replace("%end_this_month_timestamp%",DateFormat($end_this_month_timestamp),$member_display_txt_show_member_sign_up_this_week_time_frame_from_before_this_month);
			$show_info ="$member_display_txt_show_member_sign_up_this_week_time_frame_from_before_this_month";
		}
		elseif($list_item == "sub_acct"){
			$list_data =set_array_from_query("max_ecuser","*","user_member1<>'0' and user_member1<>'' Order by user_name_id LIMIT $start,$row_per_page");
			$count_list=get_dbvalue("max_ecuser","count(user_id)","user_member1<>'0' and user_member1<>''");
			$member_display_txt_show_member_have_sub_account=str_replace("%count_list%","$count_list",$member_display_txt_show_member_have_sub_account);
			$show_info ="$member_display_txt_show_member_have_sub_account";
		}
		elseif($list_item == "req_cancel"){
			$list_data =set_array_from_query("max_ecuser","*","user_request_cancel='1' Order by user_name_id LIMIT $start,$row_per_page");
			$count_list=get_dbvalue("max_ecuser","count(user_id)","user_request_cancel='1'");
			$member_display_txt_show_member_requested_cancel_account=str_replace("%count_list%","$count_list",$member_display_txt_show_member_requested_cancel_account);
			$show_info ="$member_display_txt_show_member_requested_cancel_account";
		}
		elseif($list_item == "male_only"){
			$list_data =set_array_from_query("max_ecuser","*","user_gender='0' Order by user_name_id LIMIT $start,$row_per_page");
			$count_list=get_dbvalue("max_ecuser","count(user_id)","user_gender='0'");
			$member_display_txt_show_member_male_only=str_replace("%count_list%","$count_list",$member_display_txt_show_member_male_only);
			$show_info ="$member_display_txt_show_member_male_only";
		}
		elseif($list_item == "female_only"){
			$list_data =set_array_from_query("max_ecuser","*","user_gender='1' Order by user_name_id LIMIT $start,$row_per_page");
			$count_list=get_dbvalue("max_ecuser","count(user_id)","user_gender='1'");
			$member_display_txt_show_member_female_only=str_replace("%count_list%","$count_list",$member_display_txt_show_member_female_only);
			$show_info ="$member_display_txt_show_member_female_only";
		}
	}
	elseif($cmd_button =="Search User"){
		if($search_field == "all"){
			$cond= " user_id like '%$keyword%' or user_name_id like '%$keyword%' or user_password like '%$keyword%' or user_email like '%$keyword%' or user_last_name like '%$keyword%' or user_payment_order_number like '%$keyword%' or user_city like '%$keyword%' or user_zip like '%$keyword%' or user_country like '%$keyword%' ";
			$info=split(" ",$keyword);
			foreach($info as $keyword){
				$cond .= " or user_id like '%$keyword%' or user_name_id like '%$keyword%' or user_password like '%$keyword%' or user_email like '%$keyword%' or user_last_name like '%$keyword%' or user_payment_order_number like '%$keyword%' or user_city like '%$keyword%' or user_zip like '%$keyword%' or user_country like '%$keyword%' ";
			}			
		}
		elseif($search_field == "user_id"){
			$cond= " user_id like '%$keyword%' ";
		}
		elseif($search_field == "user_name_id"){
			$cond= " user_name_id like '%$keyword%' ";	
			$info=split(" ",$keyword);
			foreach($info as $keyword){
				$cond .= " or user_name_id like '%$keyword%' ";
			}
		}
		elseif($search_field == "user_password"){
			$cond= " user_password like '%$keyword%' ";	
			$info=split(" ",$keyword);
			foreach($info as $keyword){
				$cond .= " or user_password like '%$keyword%' ";
			}
		}
		elseif($search_field == "user_email"){
			$cond= " user_email like '%$keyword%' ";	
			$info=split(" ",$keyword);
			foreach($info as $keyword){
				$cond .= " or user_email like '%$keyword%' ";
			}
		}
		elseif($search_field == "user_last_name"){
			$cond= " user_last_name like '%$keyword%' or user_name like '%$keyword%'";	
			$info=split(" ",$keyword);
			foreach($info as $keyword){
				$cond .= " or user_last_name like '%$keyword%' or user_name like '%$keyword%' ";
			}
		}		
		elseif($search_field == "user_city"){
			$cond= " user_city like '%$keyword%' ";	
			$info=split(" ",$keyword);
			foreach($info as $keyword){
				$cond .= " or user_city like '%$keyword%' ";
			}
		}
		elseif($search_field == "user_zip"){
			$cond= " user_zip like '%$keyword%'";	
			$info=split(" ",$keyword);
			foreach($info as $keyword){
				$cond .= " or user_zip like '%$keyword%' ";
			}
		}
		elseif($search_field == "user_country"){
			$cond= " user_country like '%$keyword%' ";	
			$info=split(" ",$keyword);
			foreach($info as $keyword){
				$cond .= " or user_country like '%$keyword%' ";
			}
		}
		$list_data =set_array_from_query("max_ecuser","*"," $cond Order by user_name_id LIMIT $start,$row_per_page");
		$count_list=get_dbvalue("max_ecuser","count(user_id)"," $cond ");
		$member_display_txt_search_member_account_with_keyword=str_replace("%keyword2%",urldecode($keyword2),$member_display_txt_search_member_account_with_keyword);
		$member_display_txt_search_member_account_with_keyword=str_replace("%count_list%","$count_list",$member_display_txt_search_member_account_with_keyword);
		$show_info ="$member_display_txt_search_member_account_with_keyword";
	}
	elseif($cmd_button =="View"){
		if($num_what =="day"){
			$get_day_before = $num_day;
		}
		elseif($num_what =="week"){
			$get_day_before = $num_day * 7;
		}
		elseif($num_what =="month"){
			$get_day_before = $num_day * $day31;
		}
		elseif($num_what =="year"){
			$get_day_before = $num_day * 365;
		}
		
		$begin_time_before = $begin_today_timestamp - (86400 * $get_day_before);
		$list_data =set_array_from_query("max_ecuser","*","user_member1<>'0' and user_date_signup >= $begin_time_before and user_date_signup <= $end_today_timestamp Order by user_name_id LIMIT $start,$row_per_page");
		$count_list=get_dbvalue("max_ecuser","count(user_id)","user_member1<>'0' and user_date_signup >= $begin_time_before and user_date_signup <= $end_today_timestamp");
		$member_display_txt_show_member=str_replace("%num_day%","$num_day",$member_display_txt_show_member);
		$member_display_txt_show_member=str_replace("%num_what%","$num_what",$member_display_txt_show_member);
		$member_display_txt_show_member=str_replace("%count_list%","$count_list",$member_display_txt_show_member);
		$member_display_txt_show_member=str_replace("%begin_time_before%",DateFormat($begin_time_before),$member_display_txt_show_member);
		$member_display_txt_show_member=str_replace("%end_today_timestamp%",DateFormat($end_today_timestamp),$member_display_txt_show_member);
		$show_info ="$member_display_txt_show_member";
	}
	elseif($cmd_button =="Go"){
		$from_timestamp_temp=gmmktime(0,0,0,$from_month,$from_day,$from_year);
		$to_timestamp_temp=gmmktime(23,59,59,$to_month,$to_day,$to_year);
		if($to_timestamp_temp < $from_timestamp_temp){
			$from_timestamp=$to_timestamp_temp;
			$to_timestamp=$from_timestamp_temp;		
		}
		else{
			$from_timestamp=$from_timestamp_temp;
			$to_timestamp=$to_timestamp_temp;
		}
		$list_data =set_array_from_query("max_ecuser","*","user_member1<>'0' and user_date_signup >= $from_timestamp and user_date_signup <= $to_timestamp Order by user_name_id LIMIT $start,$row_per_page");
		$count_list=get_dbvalue("max_ecuser","count(user_id)","user_member1<>'0' and user_date_signup >= $from_timestamp and user_date_signup <= $to_timestamp");
		$member_display_txt_show_member_sign_up=str_replace("%count_list%","$count_list",$member_display_txt_show_member_sign_up);
		$member_display_txt_show_member_sign_up=str_replace("%from_timestamp%",DateFormat($from_timestamp),$member_display_txt_show_member_sign_up);
		$member_display_txt_show_member_sign_up=str_replace("%to_timestamp%",DateFormat($to_timestamp),$member_display_txt_show_member_sign_up);
		$show_info ="$member_display_txt_show_member_sign_up";
	}
	else{
		$list_data =set_array_from_query("max_ecuser","*","user_member1<>'0' Order by user_name_id LIMIT $start,$row_per_page");
		$count_list=get_dbvalue("max_ecuser","count(user_id)","user_member1<>'0' ");
		$member_display_txt_total_member=str_replace("%total_member%","$total_member",$member_display_txt_total_member);
		$show_info="$member_display_txt_total_member";
	}

	set_global_var("show_info","<strong>$show_info</strong><br />");	
	
	$keyword=$keyword2;
	set_global_var("keyword",urldecode($keyword));

	if ($end > $count_list) $end = $count_list;
	$show_list_table="";
	$xrow=0;
	$list_mg=set_array_from_query("max_member_group","mg_id,mg_title","mg_id<>'1'");
	for ($z=$start; $z<$end; $z++) {
		$val = $list_data[$xrow][user_id] ;
		$row_data=$list_data[$xrow];		
		
		//IP 2 Location
		$array_country_info=ip2location($row_data[user_ip]);
		if($array_country_info[ip_country2]){
			$ip2country="<br />$member_display_txt_ip2country: <img border=\"0\" src=\"$ecard_url/resource/flags/$array_country_info[ip_country2].gif\" alt=\"$array_country_info[ip_country]\" title=\"$array_country_info[ip_country]\" /> <strong>$array_country_info[ip_country_name]</strong>";
		}
		else{
			$ip2country="";
		}

		//Member group
		$show_box_membergroup="<select id=\"next_id$val\" size=\"1\" style=\"width:98%\" onchange=\"UpdateDataTable('index.php?step=edit_me&table=max_ecuser&edit_id=user_id&edit_id_value=$val&edit_key=user_mg_id&edit_value='+this.value);\">";
		foreach($list_mg as $array_mg){
			if($array_mg[mg_id]==$row_data[user_mg_id]){
				$show_box_membergroup.="<option selected=\"selected\" value=\"$array_mg[mg_id]\">$array_mg[mg_title]</option>\n";
			}
			else{
				$show_box_membergroup.="<option value=\"$array_mg[mg_id]\">$array_mg[mg_title]</option>\n";
			}
		}
		$show_box_membergroup.="</select>";

		//Show account status
		$date_end_acct=DateFormat($row_data[user_dateclose]);
		if($row_data[user_beclosed] == 1){
			$show_account_status = str_replace("%date_end_acct%","$date_end_acct",$member_display_txt_account_will_suspended);
			//Show Undo button
			$show_delete_button="<img onclick=\"HideItAll();document.getElementById('cell$val').style.backgroundColor='#FAEDC8';document.getElementById('cell$val').style.border='thick solid #FCAA03';if(window.confirm('$member_display_message_confirm_to_suspend_delete_account')){location.href='index.php?step=$step&what=undo_delete&user_id=$val&page=$page&row_number=$row_number&cmd_button=$cmd_button&list_item=$list_item&search_field=$search_field&keyword=$keyword&num_day=$num_day&num_what=$num_what&from_month=$from_month&from_day=$from_day&from_year=$from_year&to_day=$to_day&to_month=$to_month&to_year=$to_year';}else{HideItAll();}\" border=\"0\" src=\"html/07_icon_undo_delete.gif\" style=\"cursor:pointer\" alt=\"$member_display_tooltip_undo_suspend_delete_account\" title=\"$member_display_tooltip_undo_suspend_delete_account\" />";
		}
		elseif($row_data[user_beclosed] == 2){
			$show_account_status =str_replace("%date_end_acct%","$date_end_acct",$member_display_txt_account_will_deleted);
			//Show Undo button
			$show_delete_button="<img onclick=\"HideItAll();document.getElementById('cell$val').style.backgroundColor='#FAEDC8';document.getElementById('cell$val').style.border='thick solid #FCAA03';if(window.confirm('$member_display_message_confirm_to_suspend_delete_account')){location.href='index.php?step=$step&what=undo_delete&user_id=$val&page=$page&row_number=$row_number&cmd_button=$cmd_button&list_item=$list_item&search_field=$search_field&keyword=$keyword&num_day=$num_day&num_what=$num_what&from_month=$from_month&from_day=$from_day&from_year=$from_year&to_day=$to_day&to_month=$to_month&to_year=$to_year';}else{HideItAll();}\" border=\"0\" src=\"html/07_icon_undo_delete.gif\" style=\"cursor:pointer\" alt=\"$member_display_tooltip_undo_suspend_delete_account\" title=\"$member_display_tooltip_undo_suspend_delete_account\" />";
		}
		elseif($row_data[user_beclosed] == 3){
			$show_account_status =str_replace("%date_end_acct%","$date_end_acct",$member_display_txt_account_will_downgraded);
			//Show Undo button
			$show_delete_button="<img onclick=\"HideItAll();document.getElementById('cell$val').style.backgroundColor='#FAEDC8';document.getElementById('cell$val').style.border='thick solid #FCAA03';if(window.confirm('$member_display_message_confirm_to_suspend_delete_account')){location.href='index.php?step=$step&what=undo_delete&user_id=$val&page=$page&row_number=$row_number&cmd_button=$cmd_button&list_item=$list_item&search_field=$search_field&keyword=$keyword&num_day=$num_day&num_what=$num_what&from_month=$from_month&from_day=$from_day&from_year=$from_year&to_day=$to_day&to_month=$to_month&to_year=$to_year';}else{HideItAll();}\" border=\"0\" src=\"html/07_icon_undo_delete.gif\" style=\"cursor:pointer\" alt=\"$member_display_tooltip_undo_suspend_delete_account\" title=\"$member_display_tooltip_undo_suspend_delete_account\" />";
		}
		else{
			$show_account_status ="Active";
			//Show delete - suspend button
			$show_delete_button="<img onclick=\"HideItAll();document.getElementById('tr$val').style.backgroundColor='#E4E4D3';document.getElementById('bk$val').checked='true';ShowDivCenterPage('suspend_delete_table','1');\" border=\"0\" src=\"html/07_icon_delete.gif\" style=\"cursor:pointer\" alt=\"$member_display_tooltip_delete_account\" title=\"$member_display_tooltip_delete_account\" />";
		}
		
		//Show Account detail table
		foreach($row_data as $key=>$value){
			if($key=="user_country")$value=str_replace("_"," ",$value);
			set_global_var($key,$value);
			set_global_var("get_id",$row_data[user_id]);
			set_global_var("show_user_date_signup",DateFormat($row_data[user_date_signup]));
			set_global_var("show_user_lastlogin",DateFormat($row_data[user_lastlogin]));

			$row_data[user_birth_mon] =str_replace("10","Oct",$row_data[user_birth_mon]);
			$row_data[user_birth_mon] =str_replace("11","Nov",$row_data[user_birth_mon]);
			$row_data[user_birth_mon] =str_replace("12","Dec",$row_data[user_birth_mon]);
			$row_data[user_birth_mon] =str_replace("1","Jan",$row_data[user_birth_mon]);
			$row_data[user_birth_mon] =str_replace("2","Feb",$row_data[user_birth_mon]);
			$row_data[user_birth_mon] =str_replace("3","Mar",$row_data[user_birth_mon]);
			$row_data[user_birth_mon] =str_replace("4","Apr",$row_data[user_birth_mon]);
			$row_data[user_birth_mon] =str_replace("5","May",$row_data[user_birth_mon]);
			$row_data[user_birth_mon] =str_replace("6","Jun",$row_data[user_birth_mon]);
			$row_data[user_birth_mon] =str_replace("7","Jul",$row_data[user_birth_mon]);
			$row_data[user_birth_mon] =str_replace("8","Aug",$row_data[user_birth_mon]);
			$row_data[user_birth_mon] =str_replace("9","Sep",$row_data[user_birth_mon]);
			set_global_var("show_birthday","$row_data[user_birth_mon] $row_data[user_birth_mday]");

			if($row_data[user_gender] == 0){
				$show_user_gender ="$member_display_txt_male";
			}
			else{
				$show_user_gender ="$member_display_txt_female";
			}
			set_global_var("show_user_gender",$show_user_gender);

			if($row_data[user_marital] == 0){
				$show_user_marital ="$member_display_txt_single";
			}
			elseif($row_data[user_marital] == 1){
				$show_user_marital ="$member_display_txt_married";
			}
			elseif($row_data[user_marital] == 2){
				$show_user_marital ="$member_display_txt_divorced";
			}
			elseif($row_data[user_marital] == 3){
				$show_user_marital ="$member_display_txt_wivorced";
			}
			set_global_var("show_user_marital",$show_user_marital);

			//Show order history
			$list_payment=set_array_from_query("max_payment","*","pay_user_name_id='$row_data[user_name_id]' Order By pay_date DESC");
			if(count($list_payment)>0){
				$show_list_order_table="";
				foreach($list_payment as $row_data_order){
					$show_date_purchase=DateFormat($row_data_order[pay_date],"1");
					if($row_data_order[pay_what]=="0"){
						$show_type="$member_display_txt_paypercard";
					}
					else{
						$show_type="$member_display_txt_upgrade_acct";
					}

					$show_list_order_table .="<tr style=\"background-color: white;line-height:17px\">\n";
					$show_list_order_table .="<td width=\"*%\" style=\"text-align:center;padding:7px;\">$show_date_purchase</td>\n";
					$show_list_order_table .="<td width=\"*\" style=\"text-align:center;padding:7px;\">$row_data_order[pay_order_number]</td>\n";
					$show_list_order_table .="<td width=\"*\" style=\"text-align:center;padding:7px;\">\$$row_data_order[pay_amount]</td>\n";
					$show_list_order_table .="<td width=\"1%\" style=\"text-align:center;padding:7px;white-space:nowrap\">$show_type</td>\n";		
					$show_list_order_table .="<td width=\"1%\" style=\"text-align:center;padding:7px;\">$row_data_order[pay_via]</td>\n";
					$show_list_order_table .="</tr>\n";
				}
			}
			else{
				set_global_var("hide_order_history","display:none");
			}

			$show_account_detail_table_temp =get_html_from_layout("admin/html/admin_member_display_account_detail.html");
		}
		$show_account_detail_table .=$show_account_detail_table_temp;

		$show_list_table .="<tr id=\"tr$val\" style=\"background-color: #EAEAEA;line-height:20px\">\n";
		$show_list_table .="<td width=\"40%\" style=\"padding:4px;cursor:pointer;\" title=\"$member_display_tooltip_click_to_view_detail\" id=\"cell$val\" onclick=\"HideItAll();this.style.backgroundColor='#FAEDC8';this.style.border='thick solid #FCAA03';ShowDivCenterPage('popup_detail$val')\">$member_display_txt_username_id: <span style=\"color:green\">$row_data[user_name_id]</span>$ip2country</td>\n";
		$show_list_table .="<td width=\"30%\" align=\"center\">$show_box_membergroup</td>\n";
		$show_list_table .="<td width=\"28%\" align=\"center\">$show_account_status</td>\n";
		$show_list_table .="<td width=\"1%\" align=\"center\">$show_delete_button</td>\n";
		$show_list_table .="<td width=\"1%\" align=\"center\"><input onclick=\"if(this.checked){document.getElementById('tr$val').style.backgroundColor='#E4E4D3';}else{document.getElementById('tr$val').style.backgroundColor='#EAEAEA';}\" type=\"checkbox\" id=\"bk$val\" name=\"mylist_id$val\" value=\"$val\" /></td>\n";
		$show_list_table .="</tr>\n";
		
		//List sub account 1
		if($row_data[user_member1]!="0" && $row_data[user_member1]!=""){
			$list_acct_sub=get_row("max_ecuser","*","user_name_id='$row_data[user_member1]'");
			if($list_acct_sub[user_id]!=""){
				$array_country_infosub=ip2location($list_acct_sub[user_ip]);
				if($array_country_infosub[ip_country2]){
					$ip2countrysub="<br /><img src=\"html/07_icon_upper.gif\" alt=\"$member_display_tooltip_sub_account\"/> $member_display_txt_ip2country: <img border=\"0\" src=\"$ecard_url/resource/flags/$array_country_infosub[ip_country2].gif\" alt=\"$array_country_infosub[ip_country]\" title=\"$array_country_infosub[ip_country]\" /> <strong>$array_country_infosub[ip_country_name]</strong>";
				}
				else{
					$ip2countrysub="";
				}
				//Member group
				$show_box_membergroup_sub="<select id=\"next_id$list_acct_sub[user_id]\" size=\"1\" style=\"width:98%\" onchange=\"UpdateDataTable('index.php?step=edit_me&table=max_ecuser&edit_id=user_id&edit_id_value=$list_acct_sub[user_id]&edit_key=user_mg_id&edit_value='+this.value);\">";
				foreach($list_mg as $array_mg_sub){
					if($array_mg_sub[mg_id]==$list_acct_sub[user_mg_id]){
						$show_box_membergroup_sub.="<option selected=\"selected\" value=\"$array_mg_sub[mg_id]\">$array_mg_sub[mg_title]</option>\n";
					}
					else{
						$show_box_membergroup_sub.="<option value=\"$array_mg_sub[mg_id]\">$array_mg_sub[mg_title]</option>\n";
					}
				}
				$show_box_membergroup_sub.="</select>";

				//Show account status
				$date_end_acct_sub=DateFormat($list_acct_sub[user_dateclose]);
				if($list_acct_sub[user_beclosed] == 1){
					$member_display_txt_account_will_suspended=str_replace("%date_end_acct%","$date_end_acct_sub",$member_display_txt_account_will_suspended);
					$show_account_status_sub = "$member_display_txt_account_will_suspended";
					//Show Undo button
					$show_delete_button_sub="<img onclick=\"HideItAll();document.getElementById('cell$list_acct_sub[user_id]').style.backgroundColor='#FAEDC8';document.getElementById('cell$list_acct_sub[user_id]').style.border='thick solid #FCAA03';if(window.confirm('$member_display_message_confirm_to_suspend_delete_account')){location.href='index.php?step=$step&what=undo_delete&user_id=$list_acct_sub[user_id]&page=$page&row_number=$row_number&cmd_button=$cmd_button&list_item=$list_item&search_field=$search_field&keyword=$keyword&num_day=$num_day&num_what=$num_what&from_month=$from_month&from_day=$from_day&from_year=$from_year&to_day=$to_day&to_month=$to_month&to_year=$to_year';}else{HideItAll();}\" border=\"0\" src=\"html/07_icon_undo_delete.gif\" style=\"cursor:pointer\" alt=\"$member_display_tooltip_undo_suspend_delete_account\" title=\"$member_display_tooltip_undo_suspend_delete_account\" />";
				}
				elseif($list_acct_sub[user_beclosed] == 2){
					$member_display_txt_account_will_deleted=str_replace("%date_end_acct%","$date_end_acct_sub",$member_display_txt_account_will_deleted);
					$show_account_status_sub ="$member_display_txt_account_will_deleted";
					//Show Undo button
					$show_delete_button_sub="<img onclick=\"HideItAll();document.getElementById('cell$list_acct_sub[user_id]').style.backgroundColor='#FAEDC8';document.getElementById('cell$list_acct_sub[user_id]').style.border='thick solid #FCAA03';if(window.confirm('$member_display_message_confirm_to_suspend_delete_account')){location.href='index.php?step=$step&what=undo_delete&user_id=$list_acct_sub[user_id]&page=$page&row_number=$row_number&cmd_button=$cmd_button&list_item=$list_item&search_field=$search_field&keyword=$keyword&num_day=$num_day&num_what=$num_what&from_month=$from_month&from_day=$from_day&from_year=$from_year&to_day=$to_day&to_month=$to_month&to_year=$to_year';}else{HideItAll();}\" border=\"0\" src=\"html/07_icon_undo_delete.gif\" style=\"cursor:pointer\" alt=\"$member_display_tooltip_undo_suspend_delete_account\" title=\"$member_display_tooltip_undo_suspend_delete_account\" />";
				}
				elseif($list_acct_sub[user_beclosed] == 3){
					$member_display_txt_account_will_downgraded=str_replace("%date_end_acct%","$date_end_acct_sub",$member_display_txt_account_will_downgraded);
					$show_account_status_sub ="$member_display_txt_account_will_downgraded";
					//Show Undo button
					$show_delete_button_sub="<img onclick=\"HideItAll();document.getElementById('cell$list_acct_sub[user_id]').style.backgroundColor='#FAEDC8';document.getElementById('cell$list_acct_sub[user_id]').style.border='thick solid #FCAA03';if(window.confirm('$member_display_message_confirm_to_suspend_delete_account')){location.href='index.php?step=$step&what=undo_delete&user_id=$list_acct_sub[user_id]&page=$page&row_number=$row_number&cmd_button=$cmd_button&list_item=$list_item&search_field=$search_field&keyword=$keyword&num_day=$num_day&num_what=$num_what&from_month=$from_month&from_day=$from_day&from_year=$from_year&to_day=$to_day&to_month=$to_month&to_year=$to_year';}else{HideItAll();}\" border=\"0\" src=\"html/07_icon_undo_delete.gif\" style=\"cursor:pointer\" alt=\"$member_display_tooltip_undo_suspend_delete_account\" title=\"$member_display_tooltip_undo_suspend_delete_account\" />";
				}
				else{
					$show_account_status_sub ="Active";
					//Show delete - suspend button
					$show_delete_button_sub="<img onclick=\"HideItAll();document.getElementById('tr$list_acct_sub[user_id]').style.backgroundColor='#E4E4D3';document.getElementById('bk$list_acct_sub[user_id]').checked='true';ShowDivCenterPage('suspend_delete_table','1');\" border=\"0\" src=\"html/07_icon_delete.gif\" style=\"cursor:pointer\" alt=\"$member_display_tooltip_delete_account\" title=\"$member_display_tooltip_delete_account\" />";
				}
				
				//Show Account detail table
				foreach($list_acct_sub as $key=>$value){
					if($key=="user_country")$value=str_replace("_"," ",$value);
					set_global_var($key,$value);
					set_global_var("get_id",$list_acct_sub[user_id]);
					set_global_var("show_user_date_signup",DateFormat($list_acct_sub[user_date_signup]));
					set_global_var("show_user_lastlogin",DateFormat($list_acct_sub[user_lastlogin]));

					$list_acct_sub[user_birth_mon] =str_replace("10","Oct",$list_acct_sub[user_birth_mon]);
					$list_acct_sub[user_birth_mon] =str_replace("11","Nov",$list_acct_sub[user_birth_mon]);
					$list_acct_sub[user_birth_mon] =str_replace("12","Dec",$list_acct_sub[user_birth_mon]);
					$list_acct_sub[user_birth_mon] =str_replace("1","Jan",$list_acct_sub[user_birth_mon]);
					$list_acct_sub[user_birth_mon] =str_replace("2","Feb",$list_acct_sub[user_birth_mon]);
					$list_acct_sub[user_birth_mon] =str_replace("3","Mar",$list_acct_sub[user_birth_mon]);
					$list_acct_sub[user_birth_mon] =str_replace("4","Apr",$list_acct_sub[user_birth_mon]);
					$list_acct_sub[user_birth_mon] =str_replace("5","May",$list_acct_sub[user_birth_mon]);
					$list_acct_sub[user_birth_mon] =str_replace("6","Jun",$list_acct_sub[user_birth_mon]);
					$list_acct_sub[user_birth_mon] =str_replace("7","Jul",$list_acct_sub[user_birth_mon]);
					$list_acct_sub[user_birth_mon] =str_replace("8","Aug",$list_acct_sub[user_birth_mon]);
					$list_acct_sub[user_birth_mon] =str_replace("9","Sep",$list_acct_sub[user_birth_mon]);
					set_global_var("show_birthday","$list_acct_sub[user_birth_mon] $list_acct_sub[user_birth_mday]");

					if($list_acct_sub[user_gender] == 0){
						$show_user_gender ="$member_display_txt_male";
					}
					else{
						$show_user_gender ="$member_display_txt_female";
					}
					set_global_var("show_user_gender",$show_user_gender);

					if($list_acct_sub[user_marital] == 0){
						$show_user_marital ="$member_display_txt_single";
					}
					elseif($list_acct_sub[user_marital] == 1){
						$show_user_marital ="$member_display_txt_married";
					}
					elseif($list_acct_sub[user_marital] == 2){
						$show_user_marital ="$member_display_txt_divorced";
					}
					elseif($list_acct_sub[user_marital] == 3){
						$show_user_marital ="$member_display_txt_wivorced";
					}
					set_global_var("show_user_marital",$show_user_marital);

					$show_account_detail_table_temp =get_html_from_layout("admin/html/admin_member_display_account_detail.html");
				}
				$show_account_detail_table .=$show_account_detail_table_temp;

				$show_list_table .="<tr id=\"tr$list_acct_sub[user_id]\" style=\"background-color: lightyellow;line-height:20px\">\n";
				$show_list_table .="<td width=\"40%\" style=\"padding:4px;cursor:pointer;\" title=\"$member_display_tooltip_click_to_view_detail\" id=\"cell$list_acct_sub[user_id]\" onclick=\"HideItAll();this.style.backgroundColor='#FAEDC8';this.style.border='thick solid #FCAA03';ShowDivCenterPage('popup_detail$list_acct_sub[user_id]')\"><img src=\"html/07_icon_upper.gif\" alt=\"$member_display_tooltip_sub_account\"/> $member_display_txt_username_id: <span style=\"color:green\">$row_data[user_member1]</span>$ip2countrysub</td>\n";
				$show_list_table .="<td width=\"30%\" align=\"center\">$show_box_membergroup_sub</td>\n";
				$show_list_table .="<td width=\"28%\" align=\"center\">$show_account_status_sub</td>\n";
				$show_list_table .="<td width=\"1%\" align=\"center\">$show_delete_button_sub</td>\n";
				$show_list_table .="<td width=\"1%\" align=\"center\"><input onclick=\"if(this.checked){document.getElementById('tr$list_acct_sub[user_id]').style.backgroundColor='#E4E4D3';}else{document.getElementById('tr$list_acct_sub[user_id]').style.backgroundColor='#EAEAEA';}\" type=\"checkbox\" id=\"bk$list_acct_sub[user_id]\" name=\"mylist_id$list_acct_sub[user_id]\" value=\"$list_acct_sub[user_id]\" /></td>\n";
				$show_list_table .="</tr>\n";
				$bk_id .="$list_acct_sub[user_id],";
			}
		}

		//List sub account 2
		if($row_data[user_member2]!="0" && $row_data[user_member2]!=""){
			$list_acct_sub=get_row("max_ecuser","*","user_name_id='$row_data[user_member2]'");
			if($list_acct_sub[user_id]!=""){
				$array_country_infosub=ip2location($list_acct_sub[user_ip]);
				if($array_country_infosub[ip_country2]){
					$ip2countrysub="<br /><img src=\"html/07_icon_upper.gif\" alt=\"$member_display_tooltip_sub_account\"/> $member_display_txt_ip2country: <img border=\"0\" src=\"$ecard_url/resource/flags/$array_country_infosub[ip_country2].gif\" alt=\"$array_country_infosub[ip_country]\" title=\"$array_country_infosub[ip_country]\" /> <strong>$array_country_infosub[ip_country_name]</strong>";
				}
				else{
					$ip2countrysub="";
				}
				//Member group
				$show_box_membergroup_sub="<select id=\"next_id$list_acct_sub[user_id]\" size=\"1\" style=\"width:98%\" onchange=\"UpdateDataTable('index.php?step=edit_me&table=max_ecuser&edit_id=user_id&edit_id_value=$list_acct_sub[user_id]&edit_key=user_mg_id&edit_value='+this.value);\">";
				foreach($list_mg as $array_mg_sub){
					if($array_mg_sub[mg_id]==$list_acct_sub[user_mg_id]){
						$show_box_membergroup_sub.="<option selected=\"selected\" value=\"$array_mg_sub[mg_id]\">$array_mg_sub[mg_title]</option>\n";
					}
					else{
						$show_box_membergroup_sub.="<option value=\"$array_mg_sub[mg_id]\">$array_mg_sub[mg_title]</option>\n";
					}
				}
				$show_box_membergroup_sub.="</select>";

				//Show account status
				$date_end_acct_sub=DateFormat($list_acct_sub[user_dateclose]);
				if($list_acct_sub[user_beclosed] == 1){
					$member_display_txt_account_will_suspended=str_replace("%date_end_acct%","$date_end_acct_sub",$member_display_txt_account_will_suspended);
					$show_account_status_sub = "$member_display_txt_account_will_suspended";
					//Show Undo button
					$show_delete_button_sub="<img onclick=\"HideItAll();document.getElementById('cell$list_acct_sub[user_id]').style.backgroundColor='#FAEDC8';document.getElementById('cell$list_acct_sub[user_id]').style.border='thick solid #FCAA03';if(window.confirm('$member_display_message_confirm_to_suspend_delete_account')){location.href='index.php?step=$step&what=undo_delete&user_id=$list_acct_sub[user_id]&page=$page&row_number=$row_number&cmd_button=$cmd_button&list_item=$list_item&search_field=$search_field&keyword=$keyword&num_day=$num_day&num_what=$num_what&from_month=$from_month&from_day=$from_day&from_year=$from_year&to_day=$to_day&to_month=$to_month&to_year=$to_year';}else{HideItAll();}\" border=\"0\" src=\"html/07_icon_undo_delete.gif\" style=\"cursor:pointer\" alt=\"$member_display_tooltip_undo_suspend_delete_account\" title=\"$member_display_tooltip_undo_suspend_delete_account\" />";
				}
				elseif($list_acct_sub[user_beclosed] == 2){
					$member_display_txt_account_will_deleted=str_replace("%date_end_acct%","$date_end_acct_sub",$member_display_txt_account_will_deleted);
					$show_account_status_sub ="$member_display_txt_account_will_deleted";
					//Show Undo button
					$show_delete_button_sub="<img onclick=\"HideItAll();document.getElementById('cell$list_acct_sub[user_id]').style.backgroundColor='#FAEDC8';document.getElementById('cell$list_acct_sub[user_id]').style.border='thick solid #FCAA03';if(window.confirm('$member_display_message_confirm_to_suspend_delete_account')){location.href='index.php?step=$step&what=undo_delete&user_id=$list_acct_sub[user_id]&page=$page&row_number=$row_number&cmd_button=$cmd_button&list_item=$list_item&search_field=$search_field&keyword=$keyword&num_day=$num_day&num_what=$num_what&from_month=$from_month&from_day=$from_day&from_year=$from_year&to_day=$to_day&to_month=$to_month&to_year=$to_year';}else{HideItAll();}\" border=\"0\" src=\"html/07_icon_undo_delete.gif\" style=\"cursor:pointer\" alt=\"$member_display_tooltip_undo_suspend_delete_account\" title=\"$member_display_tooltip_undo_suspend_delete_account\" />";
				}
				elseif($list_acct_sub[user_beclosed] == 3){
					$member_display_txt_account_will_downgraded=str_replace("%date_end_acct%","$date_end_acct_sub",$member_display_txt_account_will_downgraded);
					$show_account_status_sub ="$member_display_txt_account_will_downgraded";
					//Show Undo button
					$show_delete_button_sub="<img onclick=\"HideItAll();document.getElementById('cell$list_acct_sub[user_id]').style.backgroundColor='#FAEDC8';document.getElementById('cell$list_acct_sub[user_id]').style.border='thick solid #FCAA03';if(window.confirm('$member_display_message_confirm_to_suspend_delete_account')){location.href='index.php?step=$step&what=undo_delete&user_id=$list_acct_sub[user_id]&page=$page&row_number=$row_number&cmd_button=$cmd_button&list_item=$list_item&search_field=$search_field&keyword=$keyword&num_day=$num_day&num_what=$num_what&from_month=$from_month&from_day=$from_day&from_year=$from_year&to_day=$to_day&to_month=$to_month&to_year=$to_year';}else{HideItAll();}\" border=\"0\" src=\"html/07_icon_undo_delete.gif\" style=\"cursor:pointer\" alt=\"$member_display_tooltip_undo_suspend_delete_account\" title=\"$member_display_tooltip_undo_suspend_delete_account\" />";
				}
				else{
					$show_account_status_sub ="Active";
					//Show delete - suspend button
					$show_delete_button_sub="<img onclick=\"HideItAll();document.getElementById('tr$list_acct_sub[user_id]').style.backgroundColor='#E4E4D3';document.getElementById('bk$list_acct_sub[user_id]').checked='true';ShowDivCenterPage('suspend_delete_table','1');\" border=\"0\" src=\"html/07_icon_delete.gif\" style=\"cursor:pointer\" alt=\"$member_display_tooltip_delete_account\" title=\"$member_display_tooltip_delete_account\" />";
				}
				
				//Show Account detail table
				foreach($list_acct_sub as $key=>$value){
					if($key=="user_country")$value=str_replace("_"," ",$value);
					set_global_var($key,$value);
					set_global_var("get_id",$list_acct_sub[user_id]);
					set_global_var("show_user_date_signup",DateFormat($list_acct_sub[user_date_signup]));
					set_global_var("show_user_lastlogin",DateFormat($list_acct_sub[user_lastlogin]));

					$list_acct_sub[user_birth_mon] =str_replace("10","Oct",$list_acct_sub[user_birth_mon]);
					$list_acct_sub[user_birth_mon] =str_replace("11","Nov",$list_acct_sub[user_birth_mon]);
					$list_acct_sub[user_birth_mon] =str_replace("12","Dec",$list_acct_sub[user_birth_mon]);
					$list_acct_sub[user_birth_mon] =str_replace("1","Jan",$list_acct_sub[user_birth_mon]);
					$list_acct_sub[user_birth_mon] =str_replace("2","Feb",$list_acct_sub[user_birth_mon]);
					$list_acct_sub[user_birth_mon] =str_replace("3","Mar",$list_acct_sub[user_birth_mon]);
					$list_acct_sub[user_birth_mon] =str_replace("4","Apr",$list_acct_sub[user_birth_mon]);
					$list_acct_sub[user_birth_mon] =str_replace("5","May",$list_acct_sub[user_birth_mon]);
					$list_acct_sub[user_birth_mon] =str_replace("6","Jun",$list_acct_sub[user_birth_mon]);
					$list_acct_sub[user_birth_mon] =str_replace("7","Jul",$list_acct_sub[user_birth_mon]);
					$list_acct_sub[user_birth_mon] =str_replace("8","Aug",$list_acct_sub[user_birth_mon]);
					$list_acct_sub[user_birth_mon] =str_replace("9","Sep",$list_acct_sub[user_birth_mon]);
					set_global_var("show_birthday","$list_acct_sub[user_birth_mon] $list_acct_sub[user_birth_mday]");

					if($list_acct_sub[user_gender] == 0){
						$show_user_gender ="$member_display_txt_male";
					}
					else{
						$show_user_gender ="$member_display_txt_female";
					}
					set_global_var("show_user_gender",$show_user_gender);

					if($list_acct_sub[user_marital] == 0){
						$show_user_marital ="$member_display_txt_single";
					}
					elseif($list_acct_sub[user_marital] == 1){
						$show_user_marital ="$member_display_txt_married";
					}
					elseif($list_acct_sub[user_marital] == 2){
						$show_user_marital ="$member_display_txt_divorced";
					}
					elseif($list_acct_sub[user_marital] == 3){
						$show_user_marital ="$member_display_txt_wivorced";
					}
					set_global_var("show_user_marital",$show_user_marital);

					$show_account_detail_table_temp =get_html_from_layout("admin/html/admin_member_display_account_detail.html");
				}
				$show_account_detail_table .=$show_account_detail_table_temp;

				$show_list_table .="<tr id=\"tr$list_acct_sub[user_id]\" style=\"background-color: lightyellow;line-height:20px\">\n";
				$show_list_table .="<td width=\"40%\" style=\"padding:4px;cursor:pointer;\" title=\"$member_display_tooltip_click_to_view_detail\" id=\"cell$list_acct_sub[user_id]\" onclick=\"HideItAll();this.style.backgroundColor='#FAEDC8';this.style.border='thick solid #FCAA03';ShowDivCenterPage('popup_detail$list_acct_sub[user_id]')\"><img src=\"html/07_icon_upper.gif\" alt=\"$member_display_tooltip_sub_account\"/> $member_display_txt_username_id: <span style=\"color:green\">$row_data[user_member2]</span>$ip2countrysub</td>\n";
				$show_list_table .="<td width=\"30%\" align=\"center\">$show_box_membergroup_sub</td>\n";
				$show_list_table .="<td width=\"28%\" align=\"center\">$show_account_status_sub</td>\n";
				$show_list_table .="<td width=\"1%\" align=\"center\">$show_delete_button_sub</td>\n";
				$show_list_table .="<td width=\"1%\" align=\"center\"><input onclick=\"if(this.checked){document.getElementById('tr$list_acct_sub[user_id]').style.backgroundColor='#E4E4D3';}else{document.getElementById('tr$list_acct_sub[user_id]').style.backgroundColor='#EAEAEA';}\" type=\"checkbox\" id=\"bk$list_acct_sub[user_id]\" name=\"mylist_id$list_acct_sub[user_id]\" value=\"$list_acct_sub[user_id]\" /></td>\n";
				$show_list_table .="</tr>\n";
				$bk_id .="$list_acct_sub[user_id],";
			}
		}
		$bk_id .="$val,";
		$xrow++;
	}
	set_global_var("show_list_table",$show_list_table);
	
	if($bk_id{strlen($bk_id)-1} ==",") $bk_id = substr($bk_id, 0, strlen($bk_id)-1);
	set_global_var("bk_id",$bk_id);
	
	//---------------------------------------------------------------------------------------
	//Print page here
	//Output sample: << 1 | 2 | 3 >>	

	if ($page < 1 || $page=="") 
		$page = 1;
	if ($list_data ==""){
		$display_page_number = "";
	}
	else{
		$display_page_number ="";

		if ($count_list > ($row_per_page)){	
			$c = $count_list / $row_per_page;
			if (gettype($c) =="integer"){
				$b = $c;
			}
			else{
				$b = intval(($count_list / $row_per_page) + 1);
			}
			
			
			$display_page_number .="<br /><table class=page_number_table>\n";
			$display_page_number .="    <tr>\n";
			$display_page_number .="      <td width='10%' align=left>{A}</td>\n";
			$display_page_number .="      <td width='33%' align=center>{NUMBER}</td>\n";
			$display_page_number .="      <td width='10%' align=right>{B}</td>\n";
			$display_page_number .="    </tr>\n";
			$display_page_number .="</table>\n";
			
			$count_number =get_page_count_number($page,$b);
			$display_page_number = str_replace("{NUMBER}", $count_number, $display_page_number);
			
			if ($page > 1) {
				$page_pr = $page - 1 ;				
				$dpn ="<a href=\"index.php?step=$step&what=$what&row_number=$row_number&page=$page_pr&what2=$what2&cmd_button=$cmd_button&list_item=$list_item&search_field=$search_field&keyword=$keyword&num_day=$num_day&num_what=$num_what&from_month=$from_month&from_day=$from_day&from_year=$from_year&to_day=$to_day&to_month=$to_month&to_year=$to_year\"><img border=0 src=html/prv.gif style='vertical-align:middle' title='Page # $page_pr' alt='Page # $page_pr' /></a>";
				$display_page_number = str_replace("{A}", $dpn, $display_page_number);
			}
			else{
				$display_page_number = str_replace("{A}", "<img src=html/prv_disable.gif alt='' style='vertical-align:middle' />", $display_page_number);
			}
			$y=get_global_var("d_num");
			if ($page < $y) {
				$page_ne = $page + 1 ;				
				$display_page_number = str_replace("{B}", "<a href=\"index.php?step=$step&what=$what&row_number=$row_number&page=$page_ne&what2=$what2&cmd_button=$cmd_button&list_item=$list_item&search_field=$search_field&keyword=$keyword&num_day=$num_day&num_what=$num_what&from_month=$from_month&from_day=$from_day&from_year=$from_year&to_day=$to_day&to_month=$to_month&to_year=$to_year\"><img border=0 src=html/next.gif style='vertical-align:middle' title='Page # $page_ne' alt='Page # $page_ne' /></a>", $display_page_number);
			}	
			else{
				$display_page_number = str_replace("{B}", "<img src=html/next_disable.gif alt='' style='vertical-align:middle' />", $display_page_number);
			}
		}
	}
	set_global_var("display_page_number",$display_page_number);	 
		
	print_mondayyear_dropdown("from_month","from_day","from_year","print_mon_day_year_dropdown_from");
	print_mondayyear_dropdown("to_month","to_day","to_year","print_mon_day_year_dropdown_to");
	print_mondayyear_dropdown("cl_month","cl_day","cl_year","print_mon_day_year_dropdown");

	//Show drop down select member group for all user
	$show_member_group_all_user="<select id=\"mg_id_all\" name=\"mg_id_all\" size=\"1\" style=\"width:80%\"><option value=\"\">$member_display_txt_click_here_to_select_member_group</option>\n";
	foreach($list_mg as $array_mg){
		$show_member_group_all_user.="<option value=\"$array_mg[mg_id]\">$array_mg[mg_title]</option>\n";
	}
	$show_member_group_all_user.="</select>";
	
	set_global_var("show_onload_javascript","onkeypress=\"return noGlobalEnterKey(event)\"");
	
	$member_display_txt_page_title=str_replace("%total_member%","$total_member",$member_display_txt_page_title);
	set_global_var("member_display_txt_page_title","$member_display_txt_page_title");
	
	$member_display_txt_view_all_accounts_created_from_to=str_replace("%print_mon_day_year_dropdown_from%","$print_mon_day_year_dropdown_from",$member_display_txt_view_all_accounts_created_from_to);
	$member_display_txt_view_all_accounts_created_from_to=str_replace("%print_mon_day_year_dropdown_to%","$print_mon_day_year_dropdown_to",$member_display_txt_view_all_accounts_created_from_to);
	set_global_var("member_display_txt_view_all_accounts_created_from_to","$member_display_txt_view_all_accounts_created_from_to");
	
	$member_display_txt_check_to_suspend_delete=str_replace("%print_mon_day_year_dropdown%","$print_mon_day_year_dropdown",$member_display_txt_check_to_suspend_delete);
	set_global_var("member_display_txt_check_to_suspend_delete","$member_display_txt_check_to_suspend_delete");
	
	$member_display_txt_this_action_will_move_all_members_to_one_member_group=str_replace("%show_member_group_all_user%","$show_member_group_all_user",$member_display_txt_this_action_will_move_all_members_to_one_member_group);
	set_global_var("member_display_txt_this_action_will_move_all_members_to_one_member_group","$member_display_txt_this_action_will_move_all_members_to_one_member_group");
	
	set_global_var("print_object",get_html_from_layout("admin/html/admin_member_display.html") . $show_account_detail_table);
	print_admin_header_footer_page();

	//---------------------------------------------------------------------------------------------------------	
	function print_mondayyear_dropdown($mon_fieldname,$mday_fieldname,$year_fieldname,$set_what){
		global $today_mon,$today_mday,$today_year,$cf_show_date_option;

		$mon_fieldname_val = get_global_var($mon_fieldname);
		$mday_fieldname_val = get_global_var($mday_fieldname);
		$year_fieldname_val =get_global_var($year_fieldname);
		
		if($mon_fieldname_val =="")
			$mon_fieldname_val = $today_mon;

		if($mday_fieldname_val =="")
			$mday_fieldname_val = $today_mday;

		if($year_fieldname_val =="")
			$year_fieldname_val = $today_year;

		$dropdown_month="<select name=\"$mon_fieldname\" id=\"$mon_fieldname\" size=\"1\">\n";
		for($i=1;$i<=12;$i++){
			$val = $i;
			$val =str_replace("10","October",$val);
			$val =str_replace("11","November",$val);
			$val =str_replace("12","December",$val);
			$val =str_replace("1","January",$val);
			$val =str_replace("2","Febuary",$val);
			$val =str_replace("3","March",$val);
			$val =str_replace("4","April",$val);
			$val =str_replace("5","May",$val);
			$val =str_replace("6","June",$val);
			$val =str_replace("7","July",$val);
			$val =str_replace("8","August",$val);
			$val =str_replace("9","September",$val);

			if($mon_fieldname_val == $i){
				$dropdown_month.="<option selected=\"selected\" value=\"$i\">$i - $val</option>\n";
			}
			else{
				$dropdown_month.="<option value=\"$i\">$i - $val</option>\n";
			}
		}
		$dropdown_month.="</select>";
		
		$dropdown_mday="<select name=\"$mday_fieldname\" id=\"$mday_fieldname\" size=\"1\">\n";
		for($i=1;$i<=31;$i++){
			if($mday_fieldname_val == $i){
				$dropdown_mday.="<option selected=\"selected\" value=\"$i\">$i</option>\n";
			}
			else{
				$dropdown_mday.="<option value=\"$i\">$i</option>\n";
			}
		}
		$dropdown_mday.="</select>";

		$dropdown_year="<select name=\"$year_fieldname\" id=\"$year_fieldname\" size=\"1\">\n";		

		if ($set_what == "print_mon_day_year_dropdown"){
			$start_yr = $today_year ;
			$end_yr = $today_year + 5;
		}
		else{
			$start_yr = 2003 ;
			$end_yr = $today_year;
		}	
		
		for($i=$start_yr;$i<=$end_yr;$i++){
			if($year_fieldname_val == $i){
				$dropdown_year.="<option selected=\"selected\" value=\"$i\">$i</option>\n";
			}
			else{
				$dropdown_year.="<option value=\"$i\">$i</option>\n";
			}
		}
		$dropdown_year.="</select>";

		if($cf_show_date_option == "0"){
			set_global_var("$set_what","$dropdown_month $dropdown_mday $dropdown_year");
		}
		elseif($cf_show_date_option == "1"){
			set_global_var("$set_what","$dropdown_mday $dropdown_month $dropdown_year");
		}
		elseif($cf_show_date_option == "2"){
			set_global_var("$set_what","$dropdown_year $dropdown_mday $dropdown_month");
		}
		elseif($cf_show_date_option == "3"){
			set_global_var("$set_what","$dropdown_year $dropdown_month $dropdown_mday");
		}
	}

	//--------------------------------------------------------------------------------------
	function get_page_count_number($page,$b){
		global $step,$what,$row_number,$what2,$cmd_button,$list_item,$search_field,$keyword,$num_day,$num_what,$from_month,$from_day,$from_year,$to_day,$to_month,$to_year;
			
		$url="index.php?step=$step&what=$what&row_number=$row_number&what2=$what2&cmd_button=$cmd_button&list_item=$list_item&search_field=$search_field&keyword=$keyword&num_day=$num_day&num_what=$num_what&from_month=$from_month&from_day=$from_day&from_year=$from_year&to_day=$to_day&to_month=$to_month&to_year=$to_year";
		$count_number ="";
		
		$y=0;
		if ($b <10){
			for($a_num=1; $a_num<=$b; $a_num++) {
				$y++;
				if ($a_num == $page) {
					$count_number .="<span style=\"cursor: default;\" class='page_active'>$a_num</span>";					
				}
				else {
					$count_number .="<a class=\"page_other\" href=\"$url&page=$a_num\">$a_num</a>";
				}
			}
		}
		elseif(($page > 3) && ($page < ($b-3))){
			for($a_num=1; $a_num<=3; $a_num++) {
				$y++;
				$count_number .="<a class=\"page_other\" href=\"$url&page=$a_num\">$a_num</a>";
			}
			$count_number .="...";
			for($a_num = $page-1; $a_num<=$page+1; $a_num++) {
				$y++;
				if ($a_num == $page) {
					$count_number .="<span style=\"cursor: default;\" class='page_active'>$a_num</span>";
				}
				else {		
					$count_number .="<a class=\"page_other\" href=\"$url&page=$a_num\">$a_num</a>";
				}
			}
			$count_number .="...";
			for($a_num = $b-2; $a_num<=$b; $a_num++) {
				$y++;
				$count_number .="<a class=\"page_other\" href=\"$url&page=$a_num\">$a_num</a>";
			}
		}
		else{
			for($a_num=1; $a_num<=4; $a_num++) {
				$y++;
				if ($a_num == $page) {
					$count_number .="<span style=\"cursor: default;\" class='page_active'>$a_num</span>";
				}
				else {
					$count_number .="<a class=\"page_other\" href=\"$url&page=$a_num\">$a_num</a>";
				}
			}
			$count_number .="...";			
			for($a_num=$b-3; $a_num<=$b; $a_num++) {
				$y++;
				if ($a_num == $page) {
					$count_number .="<span style=\"cursor: default;\" class='page_active'>$a_num</span>";
				}
				else {	
					$count_number .="<a class=\"page_other\" href=\"$url&page=$a_num\">$a_num</a>";
				}
			}
		}
		set_global_var("d_num",$b);
		return $count_number;
	}

	//------------------------------------------------------------------
	function detele_account($user_id) {
		global $step;
		if($user_id ==""){
			//print "User ID $user_id not found";
			header("Location:index.php?step=$step\n");
			exit;
		}

		$row=get_row("max_ecuser","*","user_id='$user_id'");
		$user=trim($row[user_name_id]);

		//Delete Sub Account first (base on user_member1 & user_member2
		$free1 = trim($row[user_member1]);
		$free2 = trim($row[user_member2]);

		//Remove user from table max_mail_list 
		if($free1 !=""){
			$free1_email=get_dbvalue("max_ecuser","user_email","user_name_id='$free1'");
			$list = get_dblistvalue("max_mail_list","list_id","list_email='$free1_email' and list_mgroup_id='-1' or list_email='$free1_email' and list_mgroup_id='-2' ");
			foreach($list as $val){
				delete_row("max_mail_list","list_id='$val' LIMIT 1");
			}
		}

		//Remove user from table max_mail_list 
		if($free2 !=""){
			$free1_email=get_dbvalue("max_ecuser","user_email","user_name_id='$free2'");
			$list = get_dblistvalue("max_mail_list","list_id","list_email='$free1_email' and list_mgroup_id='-1' or list_email='$free1_email' and list_mgroup_id='-2' ");
			foreach($list as $val){
				delete_row("max_mail_list","list_id='$val' LIMIT 1");
			}
		}

		//Remove user from table max_addressbook
		if($free1 !=""){
			$list = get_dblistvalue("max_addressbook","book_id","book_user_name_id='$free1'");
			foreach($list as $val){
				delete_row("max_addressbook","book_id='$val' LIMIT 1");
			}
		}
		//Remove user from table max_addressbook
		if($free2 !=""){
			$list = get_dblistvalue("max_addressbook","book_id","book_user_name_id='$free2'");
			foreach($list as $val){
				delete_row("max_addressbook","book_id='$val' LIMIT 1");
			}
		}
		//Remove user from table max_addressbook
		$list = get_dblistvalue("max_addressbook","book_id","book_user_name_id='$user' ");
		foreach($list as $val){
			delete_row("max_addressbook","book_id='$val' LIMIT 1");
		}

		//Remove user from table max_ecard
		if($free1 !=""){
			$list = get_dblistvalue("max_ecard","ec_id","ec_user_name_id='$free1' ");
			foreach($list as $val){
				delete_row("max_ecard","ec_id='$val' LIMIT 1");
			}
		}
		//Remove user from table max_ecard
		if($free2 !=""){
			$list = get_dblistvalue("max_ecard","ec_id","ec_user_name_id='$free2' ");
			foreach($list as $val){
				delete_row("max_ecard","ec_id='$val' LIMIT 1");
			}
		}
		//Remove user from table max_ecard
		if($user!=""){
			$list = get_dblistvalue("max_ecard","ec_id","ec_user_name_id='$user' ");
			foreach($list as $val){
				delete_row("max_ecard","ec_id='$val' LIMIT 1");
			}
		}

		//Remove user from table max_ecardsent
		if($free1 !=""){
			$list = get_dblistvalue("max_ecardsent","cs_id","cs_user_name_id='$free1'");
			foreach($list as $val){
				delete_row("max_ecardsent","cs_id='$val' LIMIT 1");
			}
		}
		//Remove user from table max_ecardsent
		if($free2 !=""){
			$list = get_dblistvalue("max_ecardsent","cs_id","cs_user_name_id='$free2'");
			foreach($list as $val){
				delete_row("max_ecardsent","cs_id='$val' LIMIT 1");
			}
		}
		//Remove user from table max_ecardsent
		if($user!=""){
			$list = get_dblistvalue("max_ecardsent","cs_id","cs_user_name_id='$user' ");
			foreach($list as $val){
				delete_row("max_ecardsent","cs_id='$val' LIMIT 1");
			}
		}		

		//max_ecuser
		//Main acct + 2 Sub acct
		delete_row("max_ecuser","user_id='$user_id' LIMIT 1");
		if($free1 !="")
			delete_row("max_ecuser","user_name_id='$free1' LIMIT 1");
		if($free2 !="")
			delete_row("max_ecuser","user_name_id='$free2' LIMIT 1");

		//Remove user from table max_favorite
		if($free1 !=""){
			$list = get_dblistvalue("max_favorite","fv_id","fv_user_name_id='$free1'");
			foreach($list as $val){
				delete_row("max_favorite","fv_id='$val' LIMIT 1");
			}
		}
		if($free2 !=""){
			$list = get_dblistvalue("max_favorite","fv_id","fv_user_name_id='$free2'");
			foreach($list as $val){
				delete_row("max_favorite","fv_id='$val' LIMIT 1");
			}
		}
		if($user!=""){
			$list = get_dblistvalue("max_favorite","fv_id","fv_user_name_id='$user'");
			foreach($list as $val){
				delete_row("max_favorite","fv_id='$val' LIMIT 1");
			}
		}		

		//Remove user from table max_music 
		if($free1 !=""){
			$list = get_dblistvalue("max_music","music_id","music_user_name_id='$free1'");
			foreach($list as $val){
				delete_row("max_music","music_id='$val' LIMIT 1");
			}
		}
		//Remove user from table max_music 
		if($free2 !=""){
			$list = get_dblistvalue("max_music","music_id","music_user_name_id='$free2'");
			foreach($list as $val){
				delete_row("max_music","music_id='$val' LIMIT 1");
			}
		}
		//Remove user from table max_music 
		if($user!=""){
			$list = get_dblistvalue("max_music","music_id","music_user_name_id='$user' ");
			foreach($list as $val){
				delete_row("max_music","music_id='$val' LIMIT 1");
			}
		}		

		//Remove user from table max_poem
		if($free1 !=""){
			$list = get_dblistvalue("max_poem","poem_id","poem_user_name_id='$free1'");
			foreach($list as $val){
				delete_row("max_poem","poem_id='$val' LIMIT 1");
			}
		}
		//Remove user from table max_poem
		if($free2 !=""){
			$list = get_dblistvalue("max_poem","poem_id","poem_user_name_id='$free2'");
			foreach($list as $val){
				delete_row("max_poem","poem_id='$val' LIMIT 1");
			}
		}
		//Remove user from table max_poem
		if($user!=""){
			$list = get_dblistvalue("max_poem","poem_id","poem_user_name_id='$user' ");
			foreach($list as $val){
				delete_row("max_poem","poem_id='$val' LIMIT 1");
			}
		}		
					
		//Remove user from table max_reminder
		if($free1 !=""){
			$list = get_dblistvalue("max_reminder","rm_id","rm_user_name_id='$free1'");
			foreach($list as $val){
				delete_row("max_reminder","rm_id='$val' LIMIT 1");
			}
		}
		//Remove user from table max_reminder
		if($free2 !=""){
			$list = get_dblistvalue("max_reminder","rm_id","rm_user_name_id='$free2'");
			foreach($list as $val){
				delete_row("max_reminder","rm_id='$val' LIMIT 1");
			}
		}
		//Remove user from table max_reminder
		if($user!=""){
			$list = get_dblistvalue("max_reminder","rm_id","rm_user_name_id='$user' ");
			foreach($list as $val){
				delete_row("max_reminder","rm_id='$val' LIMIT 1");
			}
		}
		
		//Remove user from table max_mail_list
		$list = get_dblistvalue("max_mail_list","list_id","list_email='$row[user_email]' and list_mgroup_id='-1' or list_email='$row[user_email]' and list_mgroup_id='-2' ");
		foreach($list as $val){
			delete_row("max_mail_list","list_id='$val' LIMIT 1");
		}
		
	}

?>
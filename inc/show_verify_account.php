<?php
	$ecuser_row=get_row("max_ecuser","*","user_name_id='$user_name_id' AND user_active_code='$code'");
	if ($ecuser_row) {
		// do activate
		update_field_in_db2("max_ecuser","user_active='1'","user_name_id='$user_name_id' AND user_active_code='$code'");
		$activate_msg=$txt_verify_account_successfully;
	} else {
		$activate_msg=$txt_verify_account_fail;
	}
	$display_thumbnail= get_html_from_layout("templates/$cf_set_template/show_verify_account.html");
?>
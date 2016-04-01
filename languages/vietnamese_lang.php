<?php
/*
	You also need to translate those html files below to your language:

	+ english_lang_grabber_install_ok.html ----> COUNTRY_lang_grabber_install_ok.html
	+ english_lang_help.html  ----> COUNTRY_lang_help.html
	+ english_lang_policy.html  ----> COUNTRY_lang_policy.html
	+ english_lang_tos.html  ----> COUNTRY_lang_tos.html
*/

$charset="UTF-8";

//Language for Homepage
$button_select_languages="Chọn ngôn ngữ";
$button_search_ecard="Tìm kiếm";
$button_search="Tìm";
$button_go="Gửi đi";
$button_join_now="Đăng ký";
$button_sign_in="Đăng nhập";
$button_logout="Thoát";
$button_submit="Gửi đi";
$button_submit_join="Gửi đi";
$button_view_card="Xem thiệp";
$button_delete_selected="Xóa";
$button_game_click_to_play="Nhấp chuột vào đây để chơi trò chơi";
$icon_title_close_hide="Đóng/Ẩn";
$txt_total_card="Tổng sô thiệp";
$txt_link_facebook="FaceBook";
$txt_caption_paypercard="Phí cho mỗi thiệp. Trả phí %show_money% để gửi thiệp";
$txt_card_lable_POSTCARD="BƯU THIẾP";
$txt_card_lable_FLASH="FLASH";
$txt_card_lable_INVITATION="THIỆP MỜI";
$txt_card_lable_remove_favorite="Bỏ thích";
$txt_js_alert_sure_to_delete_card_favorite="Bạn có muốn xoa thiệp này khỏi danh sách yêu thích của mình?";//<-- Do not use single quote ' here
$txt_js_alert_print_card="Để in tất cả nội dung của thiệp này, bạn phải cấu hình bật tính năng in hình nền trong trình duyệt web.";
$txt_row_per_page="Số hàng mỗi trang";
$txt_tooltip_select_all="Tất cả";
$txt_tooltip_click_to_edit="Nhấp chuột vào đây để chỉnh sửa";
$txt_keyword="Từ khóa";
$txt_search_in_category="Tìm trong Danh mục";
$txt_search_exact_word="Tìm chính xác";
$text_search_all_categories="Tất cả Danh mục";
$txt_cards="thiệp";
$txt_home ="Trang chủ";
$txt_popular ="Phổ biến";
$txt_top_rate ="Đánh giá cao";
$txt_newecards ="Thiệp mới";
$txt_new_ecards ="Thiệp mới";
$txt_play_games ="Trò chơi";
$txt_pickup ="Nhận thiệp";
$txt_tell_friends ="Giới thiệu";
$txt_help ="Hướng dẫn";
$txt_media_grabber ="Media Grabber";
$txt_black_list ="Không nhận thiệp";
$txt_random_card ="Thiệp ngẫu nhiên";
$txt_newsletter="Bản tin";
$txt_feedback ="Góp ý";
$txt_policy ="An toàn cá nhân";
$txt_tos ="Nội quy";
$txt_welcome_guest="Xin chào bạn";
$txt_mtool_myaccount ="Tài khoản";
$txt_mtool_invitation="Thiệp mời";
$txt_mtool_addressbook ="Danh bạ";
$txt_mtool_calendar ="Lịch";
$txt_mtool_myalbum ="Bộ sưu tập";
$txt_mtool_reminder ="Nhắc nhở";
$txt_mtool_myfavorite ="Thích nhất";
$txt_mtool_history ="Lịch sử";
$txt_mtool_birthdayalert ="Nhắc ngày sinh nhật";
$txt_mtool_sendvideocard ="Gửi thiệp vide0";
$txt_welcome_back_user="Chào mừng trở lại";
$txt_calendar="Lịch";
$txt_calendar_today="Hôm nay";
$txt_dropdown_select="Chọn-";
$cat_select_category="DANH MỤC";
$txt_ban_error_message="Xin lỗi bạn không thể gửi thiệp được. Lý do:";
$txt_account_verification="Xác nhận tài khoản";

//Language for Verify Account page
$txt_verify_account_successfully="Tài khoản của bạn đã được xác nhận. Bạn có thể đăng nhập vào tài khoản của mình.";
$txt_verify_account_fail="Mã xác nhận không đúng. Tài khoản của bạn chưa được xác nhận.";

$txt_black_list_add="Điền địa chỉ email của bạn vào danh sách này nếu bạn muốn từ đây về sau không nhận bất cứ điện thư hay nhắc nhở (Sinh Nhật, Nhắc nhở…) nào từ trang web của chúng tôi.";
$button_add_to_black_list="Thêm";
$txt_black_list_remove="Lấy địa chỉ email ra khỏi danh sách này để $cf_site_title, bè bạn và người thân của bạn có thể gởi Thiệp điện tử hay những nhắc nhở (Sinh Nhật, Nhắc nhở…) từ trang web của chúng tôi.";
$button_remove_from_black_list="Bỏ ra";
$blacklist_error_message_email_exist ="Chúng tôi đã có địa chỉ email $add_black_email trong Danh Sách Không Nhận Thiệp. Bạn không cần phải làm gì hết.";
$blacklist_error_message_whenremove_email_not_onlist ="Địa chỉ email $remove_black_email không có trong Danh Sách Danh Sách Không Nhận Thiệp. Bạn không cần phải làm gì hết";
$blacklist_email_subject ="$cf_site_title - Xác nhận Danh sách không nhận thiệp";
$blacklist_error_message_gocheck_email ="Vui lòng kiểm tra trong email <strong>$add_black_email</strong>. Một thư đã gửi với Chủ đề <strong>$blacklist_email_subject</strong>.<br /><br />Để yêu cầu <strong>THÊM</strong> email của bạn vào Danh sách không nhậ thiệp, vui lòng nhấp chuột vào liên kết ở trong nội dung email.";
$blacklist_message_remove_ok="Email: <strong>$remove_black_email$email</strong> đã xóa khỏi Danh sách không nhận thiệp.<br /><br /> Từ nay, bạn các tính năng thiệp, nhắc nhở ngày sinh nhật, nhắc nhở... sẽ có thể gửi vào email của bạn.";
$blacklist_error_message_remove_email_notonList ="Email <strong>$email</strong> không tìm thấy trong Danh sách không nhận thiệp.<br /><br />Điều đó có nghĩa là bạn có thể nhận được thiệp, nhắc nhở ngày sinh nhật, nhắc nhở, giới thiệu... đến hộp thư này.";
$blacklist_message_add_ok="Email: <strong>$email</strong> đã được đưa vào trong Danh sách không nhận thiệp.<br /><br />Trong tương lai bạn sẽ không nhận được bất kỳ một lời nhắn tin hoặc Thiệp được gửi đi từ trang web của chúng tôi";

$blacklist_email_message=<<<EOF
Xin chào!
<br /><br />
Xin vui lòng nhấp chuột vào liên kết bên dưới để đưa email $add_black_email vào Danh sách không nhận thiệp.
<br /><br />
<a href="%show_link%">%show_link%</a>
<br /><br />
Xin cám ơn!
EOF;
$blacklist_email_remove_fromlist_subject="Hướng dẫn xóa bỏ email của bạn trên Danh sách không nhận thiệp"; 
$blacklist_error_message_remove_gocheck_email="Vui lòng kiểm tra hộp thư email <strong>$remove_blak_list</strong>. Một email đã được gửi đến bạn với Chủ đề <strong>$blacklist_email_remove_fromlist_subject</strong>.<br /><br />Để yêu cầu<strong>XÓA/strong> email của bạn ra khỏi Danh sách không nhận thiệp vui lòng nhấp chuột vào liên kết trong nội dung email.";
$blacklist_email_remove_fromlist_message=<<<EOF
Xin chài!
<br /><br />
Địa chỉ email của bạn hiện có trên Danh sách không nhận thiệp của tranh web $cf_site_title.
<br /><br />
Có nghĩa là hệ thống web $cf_site_title, hoặc người thân sẽ không thể gửi Thiệp, giới thiệu, nhắc nhở... đến cho bạn.
<br /><br />
Nếu bạn muốn xóa bỏ địa chỉ email của mình trên Danh sách này, vui lòng bấm vào liên kết bên dưới:
<br /><br />
<a href="%show_link%">%show_link%</a>
<br /><br />
Xin cám ơn!

EOF;
 
$Sun ="CN";
$Mon = "Hai";
$Tue = "Ba";
$Wed = "Tư";
$Thu = "Năm";
$Fri = "Sáu";
$Sat = "Bảy";
$Sunday ="Chủ nhật";
$Monday = "Thứ hai";
$Tuesday = "Thứ ba";
$Wednesday = "Thứ tư";
$Thursday = "Thứ năm";
$Friday = "Thứ sáu";
$Saturday = "Thứ bảy";
$Jan ="Tháng Giêng";
$Feb ="Tháng Hai";
$Mar ="Tháng Ba";
$Apr ="Tháng Tư";
$May ="Tháng Năm";
$Jun ="Tháng Sáu";
$Jul ="Tháng Bảy";
$Aug ="Tháng Tám";
$Sep ="Tháng Chín";
$Oct ="Tháng Mười";
$Nov ="Tháng Mười Một";
$Dec ="Tháng Mười Hai";
$Month ="Tháng";
$Day ="Ngày";
$Year ="Năm";
$My_age_is_secret ="Không cho biết tuổi.";
$Table_Title_Upcoming_Holidays_Events = "Ngày lễ sắp đến";
$pickup_your_ecard="Nhận thiệp";
$pickup_your_ecard_invite="Nhận thiệp mời";
$enter_card_id_number="Nhập vào ID thiệp";
$quotes_of_the_day="Lời hay ý đẹp";
$random_ecard_title="Thiệp ngẫu nhiên";
$feature_ecard_title="Thiệp nổi bật";
$popular_ecard_title="Thiệp phổ biến";
$toprated_ecard_title="Thiệp đánh giá cao";
$newest_ecard_title="Thiệp mới nhất";
$thumb_tool_preview_fullsize="Xem hình lớn";
$thumb_tool_visit_category="Xem danh mục %show_cat_name%";
$thumb_tool_free_card="Thiệp này miễn phí, bạn có thể gửi đi";
$thumb_tool_member_card="Vui lòng nâng cấp để gửi thiệp này";
$thumb_tool_member_card_ok_to_send="Bạn có thể gửi thiệp này";
$thumb_tool_date_add_card="Thiệp được thêm vào %show_date%";
$thumb_tool_new_card="Mới - được thêm vào %show_date%";
$thumb_tooltip_click_to_close="Nhấp chuột để đóng";

$cardinfo_date_added="Thiệp được thêm vào";
$cardinfo_category_name="Danh mục";
$cardinfo_caption="Tiêu đề";
$cardinfo_detail="Chi tiết";
$cardinfo_keyword="Tìm thiệp với từ khóa";
$cardinfo_group_permission="Nhóm thành viên được gửi thiệp này";
$cardinfo_rated="Đánh giá";
$cardinfo_time_sent="Ngày gửi";

$txt_Sortby ="Sắp theo";
$cap_sortby_date_desc ="Mới nhất ở đầu.";
$cap_sortby_date_asc ="Cũ nhất ở đầu.";
$cap_sortby_popular_desc ="Phổ biến nhất.";
$cap_sortby_popular_asc ="Ít phổ biến nhất.";
$cap_sortby_rate_desc ="Đánh giá cao nhất.";
$cap_sortby_rate_asc ="Đánh giá thấp nhất.";
$cap_sortby_default="Mặc định";
$cap_sortby_card_i_can_send="Chỉ những thiệp do mình gửi";
$button_use_sortby_default="Để xem thêm thiệp sắp theo mặc định";

$side_nav_account_tools="Tài khoản của tôi";
$side_nav_title_newsletter="Bản tin";
$side_nav_newsletter_subscribe ="Nhận bản tin";
$side_nav_newsletter_unsubscribe ="Ngừng nhận bản tin";
$label_yourname="Họ tên";
$label_youremail="mail";
$button_subscribe="Nhận";
$button_unsubscribe="Ngưng nhận";
$side_nav_title_voice_recorder="Thu tiếng nói";
$side_nav_voice_recorder_message="<a href=\"Ecard.exe\">Tải về chương trình</a><br /><a href=\"Ecard.exe\">Thu tiếng nói</a> để gửi thiệp kèm theo.";
$side_nav_title_download_player="Tải về chương trình";
$side_nav_download_flash_message="<a href=\"http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash&promoid=BIOW\" target=\"_blank\">Tải về chương trình chạy Flash</a> để xem thiệp Flash";
$side_nav_download_java_message="<a href=\"http://java.com/en/download/index.jsp\" target=\"_blank\">Tải Java</a> để xem hiệu ứng Java applet";
$side_nav_download_winmedia_message="<a href=\"http://www.microsoft.com/windows/windowsmedia/download/AllDownloads.aspx\" target=\"_blank\">Tải Window Media player</a> để nghe nhạc .wma";
$side_nav_download_real_message="<a href=\"http://www.real.com\" target=\"_blank\">Tải Real player</a> để nghe nhạc dạng .rm";
$side_nav_title_legend="Ghi chú";

$show_join_now_title="Đăng ký thành viên";
$show_join_now_txt_re_enter_password="Nhập lại mật mã";
$show_join_now_txt_image_verify="Xác nhận mã";
$show_join_now_alert_must_enter_first_name="Vui lòng nhập Tên";
$show_join_now_alert_must_enter_last_name="Vui lòng nhập Họ";
$show_join_now_alert_must_enter_valid_email="Vui lòng nhập địa chỉ email hợp lệ";
$show_join_now_alert_must_enter_user_name_id="Vui lòng nhập Tên đăng nhập";
$show_join_now_alert_must_enter_password="Vui lòng nhập mật khẩu";
$show_join_now_alert_must_re_enter_password="Vui lòng nhập lại mật khẩu";
$show_join_now_alert_must_enter_image_code="Vui lòng nhập mã xác nhận";
$show_join_now_alert_must_enter_correct_image_code="Mã xác nhận sai, vui lòng nhập lại";
$update_your_account_title="Nâng cấp tài khoản";
$update_your_account_join_group_name="Đăng ký làm thành viên nhóm:";

$sign_in_existing_members ="Tài khoản này đã đăng ký, vui lòng đăng nhập.";
$sign_in_enter_user_name_password="Tên đăng nhập hoặc Email";
$sign_in_enter_password="Mật khẩu";
$sign_in_resend_password="Nhập lại mật khẩu";
$sign_in_button_send_password="Gửi mật khẩu";
$sign_in_become_member_you_can="Quyền của thành viên miễn phí:";
$sign_in_become_member_send_free_ecard="Được quyền gửi các thiệp dành riêng cho nhóm.";
$sign_in_error_msg_wrong_user_pass ="Tên đăng nhập hoặc mật khẩu không đúng";
$sign_in_error_msg_account_not_active="Tài khoản của bạn chưa xác nhận. Vui lòng kiểm tra email và xác nhận với liên kết trong nội dung email.";
$sign_in_error_msg_account_suspend ="Tài khoản của bạn đã bị khóa";
$sign_in_lost_pass_error_msg ="Xin lỗi, không có tài khoản nào trong hệ thống như thông tin bạn đã nhập, vui lòng kiểm tra lại.";
$sign_in_lost_pass_ok_msg="Mật khẩm đã được gửi đến emailYour password has been sent. Please check %show_email%";
$sign_in_error_msg_lost_pass_no_user_found ="Không có tên tài khoản  $user_name_id hay email nào như bạn vừa nhập vào";
$sign_in_remember_me_learn_more ="Nhớ trạng thái đăng nhập. <span style=\"cursor:pointer;text-decoration:underline;font-weight:bold;\">Tìm hiểu thêm</span>";
$remember_me_learn_more_html_msg=<<<EOF
Vì lý do bảo mật, sau một thời gian không hoạt động hoặc bạn đã đóng browser, phiên làm việc của bạn ở <strong>$cf_site_title</strong> sẽ bị mất và bạn phải đăng nhập lại.
<br /><br /><strong>Để giữ tình trạng đăng nhập ở $cf_site_title</strong>
<br /><br />Để việc vào thăm web chúng tôi tiện lợi hơn cho bạn, bạn có thể chọn “Nhớ trạng thái đăng nhập” trên thiết bị này. Mật mã của bạn sẽ được máy thiết bị này nhớ hoài, cho dù bạn đã đóng browser, không vào mạng, ngay cả khi bạn tắt máy. 
<br /><br /><strong>CHÚ Ý:</strong>Vì sự an toàn, nếu bạn đang sử dụng chung máy tính, thiết bị với người khác hoặc thiết bị công cộng, bạn nên nhấp vào nút "Thoát" để rời khỏi <strong>$cf_site_title</strong>.
EOF;

$lost_password_email_subject="$cf_site_title - Thông tin tài khoản và mật khẩu";
$lost_password_email_message=<<<EOF
Xin chào!
<br /><br />
Cám ơn bạn đã sử dụng dịch vụ gửi thiệp của chúng tôi. Bên dưới là thông tin tài khoản của bạn.
<br /><br />
Tên đăng nhập: %show_user_name_id%
<br />
Mật khẩu: %show_password%
<br /><br />
Liên kết để đăng nhập vào tài khoản
<br /><br />
<a href="$ecard_url/index.php?step=sign_in">$ecard_url/index.php?step=sign_in</a>

EOF;

$sign_up_email_subject_welcome ="$cf_site_title - Tài khoản đã được kích hoạt";
$sign_up_email_message_welcome=<<<EOF
Xin chào $user_first_name $user_last_name,
<br /><br />
Cám ơn bạn đã trở thành thành viên của chúng tôi.
<br /><br />
Tài khoản của bạn đã được kích hoạt, kể từ bây giờ bạn có thể sử dụng các dịch vụ của chúng tôi.
<br /><br />
Hãy đăng nhập vào tài khoản của bạn.
<br /><br />
Địa chỉ: <a href="$ecard_url">$ecard_url</a>
<br /><br />
Tên đăng nhập: $user_name_id
<br />
Email: $user_email
<br />
Mật khẩu: $user_password
<br /><br />
Chúng tôi sẽ cố gắng hỗ trợ bạn để gửi đến niềm vui, sự bất ngờ cho người thân, gia đình và những người bạn yêu thương bằng những tắm thiệp đầy màu sắc và có ý nghĩa.
<br /><br />
Ban quản trị $cf_site_title

EOF;

$js_alert_edit_field_not_blank="Phần này không được bỏ trống\\n\\nNhững thay đổi của bạn sẽ không cập nhật.";
$js_alert_edit_field_not_a_number="Bạn phải nhập số.\\n\\nNhững thay đổi của bạn sẽ không cập nhật.";
$js_alert_edit_field_invalid_email="Email không hợp lệ\\n\\nNhững thay đổi của bạn sẽ không cập nhật.";
$js_alert_must_select_checkbox="Bạn phải nhấp vô checkbox trước. Vui lòng thử lại.";
$ajax_text_loading="Đang tải...";
$ajax_text_updating="Đang cập nhật...";
$ajax_text_verify="Đang xác nhận...vui lòng chờ";
$ajax_text_sending_email="Đang gửi mail...";

//Member tool My Account 
$myaccount_account_verification_email_subject="Xác nhận đăng ký tài khoản";
$myaccount_account_verification_email=<<<EOF
Bạn vừa đăng ký một tài khoản tại %SITE_TITLE% với email (%USER_EMAIL%).
<br /><br />
Nếu bạn không có đăng ký, xin hãy bỏ qua email này. Người đã đăng ký tài khoản này có địa chỉ IP %USER_IP%. Bạn không cần trả lời lại email này.
<br /><br />
Nếu bạn là người đã đăng ký tài khoản ở tại %SITE_TITLE%, vui lòng xác nhận bằng cách nhấp chuột vào liên kết dưới đây:
<br /><br />
%ACCOUNT_VERIFICATION_URL%
<br /><br />
Sau khi xác nhận, bạn có thể sử dụng tài khoản mới của mình. Nếu bạn không xác nhận, tài khoản của bạn sẽ bị xóa trong vòng vài ngày.
EOF;
$myaccount_account_verification_email_message="Xin cám ơn bạn đã đăng ký! Xin vui lòng kiểm tra email %USER_EMAIL% để xác nhận tài khoản mới";
$myaccount_sms_cellphone_reminder="SMS - Gửi nhắc nhở đến điện thoại";
$myaccount_sms_cellphone_number="Số điện thoại";
$myaccount_sms_cellphone_carrier="Chọn nhà mạng";
$myaccount_sms_send_test_message_button="Gửi tin nhắn";
$myaccount_sms_reminder_active="Đồng ý nhận sms";
$myaccount_financial_information="Thông tin tài chính";
$myaccount_account_balance="Số dư (dùng để trả phí mỗi thiệp)";
$myaccount_purchase_history="Xem quá trình đặt mua";
$myaccount_purchase_history_date="Ngày";
$myaccount_purchase_history_order_number="Số đơn hàng";
$myaccount_purchase_history_amount="Số tiền";
$myaccount_purchase_history_order_type="Loại";
$myaccount_purchase_history_pay_method="Phương thức";
$myaccount_purchase_history_order_type_ppc="Phí mỗi thiệp";
$myaccount_purchase_history_order_type_upgrade_acct="Nâng cấp tài khoản";
$myaccount_ppc_message_enough_money="Số tiền  trong tài khoản của bạn %show_user_balance% không đủ trả cho thiệp này (%show_card_amount%)<br />Bấm Tiếp tục để qua bước tiếp the";
$myaccount_ppc_message_upgrade_account="Tài khoản của bạn không thể gửi thiệp này. Vui lòng nâng cấp tài khoản.";
$myaccount_ppc_message_not_enough_money="Số tiền trong tài khoản của bạn %show_user_balance% không đủ trả cho thiệp này (%show_card_amount%)";
$myaccount_sms_send_test_message_subject="Gửi thử tin nhắn";
$myaccount_sms_send_test_message_body="Đây là tin nhắn thử. Bạn đang sử dụng mạng %show_carrier_name%";
$myaccount_permission="Bạn có thể";
$myaccount_max_recipient="Gửi tối đa";
$myaccount_max_recipient_per_hour="Gửi tối đa mỗi giờ";
$myaccount_max_recipient_per_day="Gửi tối đa mỗi ngày";
$myaccount_show_watermark="Show image watermark";
$myaccount_show_banner="Hiện quảng cáo";
$myaccount_allow_game="Chơi trò chơi";
$myaccount_allow_grabber="Sử dụng Media Grabber";
$myaccount_allow_search="Tìm thiệp/thiệp mời";
$myaccount_allow_futuredate="Chọn ngày để gửi";
$myaccount_allow_rate="Đánh giá thiệp";
$myaccount_allow_viewfullsize="Xem trước hình lớn";
$myaccount_allow_myaccount="Tài khoản";
$myaccount_allow_addressbook="Danh bạ";
$myaccount_allow_reminder="Nhắc nhở";
$myaccount_allow_calendar="Lịch";
$myaccount_allow_myalbum="Bộ sưu tập";
$myaccount_allow_favorite="Yêu thích";
$myaccount_allow_history="Lịch sử gửi thiệp";
$myaccount_allow_birthdayalert="Nhắc ngày sinh nhật";
$myaccount_allow_2subaccount="Tạo 2 tài khoản phụ";
$myaccount_payment_amount="Phí hàng năm";
$myaccount_button_upgrade_account="Nâng cấp tài khoản";
$myaccount_enter_payment_order_number="Nhập vào số đơn hàng";
$myaccount_txt_link_to_payment="Nếu bạn chưa có số đơn hàng, <a href=\"$ecard_url/index.php?step=update_your_account\">nhấp chuột vào đây</a> để mua.";
$myaccount_txt_unlimited="Không giới hạn";
$myaccount_txt_yes="<span class=\"OK_Message\">ĐỒNG Ý</span>";
$myaccount_txt_no="<span class=\"Error_Message\">KHÔNG</span>";
$myaccount_sub_alert_must_enter_first_name="Bạn phải nhập tên";
$myaccount_sub_alert_must_enter_last_name="Bạn phải nhập họ";
$myaccount_sub_alert_must_enter_email="Bạn phải nhập email";
$myaccount_sub_alert_must_enter_user_name_id="Bạn phải nhập Tên đăng nhập";
$myaccount_sub_alert_must_enter_order_number="Bạn phải nhập số đơn hàng";
$myaccount_show_info_order_number_invalid="Bạn không thể nâng cấp tài khoản. Số đơn hàng bạn nhập không đúng hoặc đã có người dùng rồi.";

$myaccount_h1="Tài khoản của tôi";
$myaccount_information_title="Thông tin tài khoản";
$myaccount_user_first_name="Tên";
$myaccount_user_last_name="Họ";
$myaccount_user_email="Email";
$myaccount_user_name_id="Tên đăng nhập";
$myaccount_user_password="Mật khẩu";
$myaccount_change_password="Đổi mật khẩu";
$myaccount_account_statistics_title="Thống kê";
$myaccount_user_signup_date="Ngày đăng ký";
$myaccount_user_last_login="Lần đăng nhập trước";
$myaccount_user_time_used="Giờ đăng nhập";
$myaccount_user_card_sent="Tổng số thiệp đã gửi";
$myaccount_optional_title="Tùy chọn thêm";
$myaccount_user_birthday="Ngày sinh";
$myaccount_user_language="Ngôn ngữ";
$myaccount_user_dst="Đổi giờ tự động";
$myaccount_user_dst_no="Không";
$myaccount_user_dst_yes="Đồng ý";
$myaccount_user_select_timezone="Chọn múi giờ";
$myaccount_user_address="Địa chỉ";
$myaccount_user_city="Thành phố";
$myaccount_user_state="Tiểu bang";
$myaccount_user_zipcode="Zip Code";
$myaccount_user_country="Quốc gia";
$myaccount_user_phone_number="Điện thoại";
$myaccount_user_gender="Giới tính";
$myaccount_user_gender_male="Nam";
$myaccount_user_gender_female="Nữ";
$myaccount_user_marital_status="Trình trạng hôn nhân";
$myaccount_user_marital_status_single="Độc thân";
$myaccount_user_marital_status_married="Đã kết hôn";
$myaccount_user_marital_status_divorced="Ly dị";
$myaccount_user_marital_status_widowed="Ở góa";
$myaccount_cancel_account_title="Bỏ tài khoản";
$myaccount_user_account_group_name="Tài khoản thuộc nhóm";
$myaccount_user_payment_order_number="Số đơn hàng";
$myaccount_user_payment_amount="Số tiền";
$myaccount_user_paid_by="Trả bằng (2Checkout hoặc Paypal)";
$myaccount_delete_account="Xóa tài khoản";
$myaccount_cancel_membership="Bỏ thành viên nhóm";
$myaccount_email_newsletter_title="Bản tin";
$myaccount_user_receive_newsletter="Nhận tin";
$myaccount_user_receive_offer="Nhận tin khuyến mãi";
$myaccount_user_edit_email_error_msg_invalid="Địa chỉ email không hợp lệ.";
$myaccount_user_edit_email_error_msg_taken="Địa chỉ email này đã có người dùng.";
$myaccount_user_current_password="Mật khẩu hiện tại";
$myaccount_user_new_password="Mật khẩu mới";
$myaccount_user_new_password2="Nhập lại mật khẩu mới";
$myaccount_user_button_change_password="Thay đổi";
$myaccount_user_new_pass_error1="Mật khẩu hiện tại không đúng";
$myaccount_user_new_pass_error2="Bạn phải nhập mật khẩu mới";
$myaccount_user_new_pass_error3="Mật khẩu mới phải giống nhau";
$myaccount_user_new_pass_updated="Mật khẩu đã được thay đổi";
$myaccount_alert_delete_account="Bạn có chắc muốn xóa tài khoản này?";
$myaccount_alert_request_cancel_sent="Yêu cầu bỏ tài khoản khỏi nhóm hiện nay đã được gửi đến ban quản trị website. Nếu bạn muốn thay đổi quyết định, vui lòng <a href=\"$ecard_url/index.php?step=sign_in&next_step=show_myaccount&action=undo_delete\">nhấp chuột vào đây</a>.";
$myaccount_alert_will_be_closed ="Ban quản trị sẽ chuẩn bị xóa tài khoản này vào: %show_date%. Sau ngày %show_date% tài khoản của bạn sẽ được xóa vĩnh viễn kèm với các thông tin & dữ liệu đi kèm như chi tiết cá nhận, lịch, danh bạ, nhắc nhở...";  
$myaccount_alert_will_be_downgrade ="Ban quản trị website sẽ chuyển tài khoản của bạn thành nhóm miễn phí vào ngày: %show_date%.";  
$myaccount_show_info_user_email_invalid="Email không hợp lệ";
$myaccount_show_info_user_email_taken="Email này đã được đăng ký.";
$myaccount_show_info_user_name_id_too_short="Tên đăng nhập phải có ít nhất 6 ký tự";
$myaccount_show_info_user_name_id_no_number_first_letter="Tên đăng nhập phải có ký tự chữ đầu tiên";
$myaccount_show_info_user_name_id_no_special_character="Tên đăng nhập không được có khoảng trắng hay ký tự đặc biệt";
$myaccount_show_info_user_name_id_taken="Tên đăng nhập đã có";
$myaccount_show_info_user_has_been_banned="Email của bạn đã bị khóa vì lý do bảo mật.";
$myaccount_free_sub_information="Thông tin tài khoản phụ";
$myaccount_button_create_free_sub="Tạo tài khoản phụ";
$myaccount_alert_sure_to_delete_sub_account="Bạn có chắc muốn xóa tài khoản phụ?";
$myaccount_button_delete_free_sub="Xóa tài khoản phụ";
$myaccount_freesub_email_subject="%sender_name% gửi tặng bạn tài khoản miễn phí để gửi thiệp";
$myaccount_freesub_email_message=<<<EOF
Xin chào!
<br /><br />
%sender_name% đã tạo cho bạn một tài khoản miễn phí. Xem thông tin bên dưới
<br /><br />
Tên đăng nhập: %show_user_name_id%
<br />
Mật khẩu: %show_password%
<br /><br />
Theo đường dẫn này để đăng nhập vào hệ thống gửi Thiệp và bạn có thể thay đổi mật khẩu của riêng mình
<br /><br />
<a href="$ecard_url/index.php?step=sign_in&next_step=show_myaccount">$ecard_url/index.php?step=sign_in&next_step=show_myaccount</a>
<br /><br />
Cám ơn bạn sử dụng hệ thống gửi Thiệp điện tử $cf_site_name

EOF;
$myaccount_twitter_screen_name_to_send="Bạn đang dùng twitter <b>%twitter_screen_name%</b> để gửi thiệp. Bỏ oAuth token và oAuth secret để đổi tài khoản twitter.";
$myaccount_twitter_connection_title="Twitter connection";
$myaccount_oAuth_token_title="oAuth token";
$myaccount_oAuth_secret_title="oAuth secret";

$addressbook_group_default_name="NHÓM MẶC ĐỊNH";
$addressbook_contact_group_title="Nhóm";
$addressbook_button_view_contact="Xem chi iết";
$addressbook_button_add_new_group="Nhấp vào đây để tạo nhóm mới";
$addressbook_button_add_contact="Thêm liên lạc";
$addressbook_txt_create_new_group_title="Tạo nhóm mới";
$addressbook_txt_group_title="Tên";
$addressbook_txt_group_number_email="Email";
$addressbook_txt_group_number_autobirthday="Auto Birthday";
$addressbook_txt_group_view_contact="Xem";
$addressbook_txt_group_add_contact="Thêm";
$addressbook_txt_group_delete_contact="Xóa";
$addressbook_txt_quick_add="Thêm nhanh vào nhóm này<br />Mỗi liên lạc sẽ trên 1 dòng<br />(Dùng định dạng CSV - xem ví dụ)";
$addressbook_txt_add_contact_to_group="Thêm liên lạc vào nhóm:";
$addressbook_quick_sample="<strong>Email,Tên,Họ</strong>,Tên người dùng(nickname),Số điện thoại<br />(Email,Tên,Họ không được trống)";
$addressbook_button_submit_add_group="Tạo nhóm mới";
$addressbook_js_alert_must_enter_group_title="Nhập tên nhóm";
$addressbook_js_alert_must_enter_contact_list="Bạn phải nhập tên";
$addressbook_js_alert_sure_to_delete_group="Bạn có chắc muốn xóa những nhóm đã được chọn?\\n\\nTất cả liên lạc trong nhóm sẽ được chuyển đến $addressbook_group_default_name";
$addressbook_tooltip_view_contact_detail="Xem chi tiết";
$addressbook_tooltip_add_contact_to_group="Thêm liên lạc vào nhóm";
$addressbook_show_info_new_group_has_been_added="Nhóm mới đã được tạo";

$addressbook_big_title="Danh bạ";
$addressbook_button_search_filter="Tìm kiếm &amp; Chọn lọc";
$addressbook_button_display_all_contact="Hiện tất cả";
$addressbook_button_create_edit_contact_group="Tạo/sửa nhóm";
$addressbook_button_submit_add_new="Thêm liên lạc";
$addressbook_txt_filter_by="Lọc bởi";
$addressbook_txt_click_add_new_contact="Nhấp vào đây để thêm liên lạc mới";
$addressbook_txt_fill_out_form="Hãy nhập thông tin cho liên lạc mới";
$addressbook_txt_first_name="Tên";
$addressbook_txt_last_name="Họ";
$addressbook_txt_email="Email";
$addressbook_txt_add_contact_to_group_name="Nhóm";
$addressbook_txt_optional="Tùy chọn";
$addressbook_txt_nick_name="Biệt danh(nickname)";
$addressbook_txt_phone_number="Điện thoại";
$addressbook_txt_address1="Địa chỉ 1";
$addressbook_txt_address2="Địa chỉ 2";
$addressbook_txt_city="Thành phố";
$addressbook_txt_state="Tiểu bang";
$addressbook_txt_zipcode="Zip code";
$addressbook_txt_country="Quốc gia";
$addressbook_txt_reminder_dates="Ngày cần nhắc nhở";
$addressbook_txt_reminder_birthday="Sinh nhật";
$addressbook_txt_reminder_anni="Kỷ niệm";
$addressbook_txt_reminder_birthday_tooltip="Nhắc ngày sinh nhật của người này";
$addressbook_txt_reminder_anni_tooltip="Nhắc ngày kỷ niệm của người này";
$addressbook_txt_reminder_me="Nhắc nhở tôi";
$addressbook_txt_reminder_me_on_date="Đúng ngày";
$addressbook_txt_reminder_me_1day_b4="1 ngày trước đó";
$addressbook_txt_reminder_me_2day_b4="2 ngày trước đó";
$addressbook_txt_reminder_me_3day_b4="3 ngày trước đó";
$addressbook_txt_reminder_me_7day_b4="7 ngày trước đó";
$addressbook_txt_reminder_me_14day_b4="14 ngày trước đó";
$addressbook_txt_reminder_me_30day_b4="30 ngày trước đó";
$addressbook_table_contact_detail="Chi tiết liên lạc";
$addressbook_table_contact_group="Nhóm";
$addressbook_table_icon_tooltip_view_edit_contact="Xem/sửa liên lạc";
$addressbook_table_icon_tooltip_delete="Xóa";
$addressbook_search_filter_search_in="Tìm trong";
$addressbook_search_filter_search_in_all_fields="Mọi chi tiết";
$addressbook_js_alert_must_enter_first_name="Bạn phải nhập tên";
$addressbook_js_alert_must_enter_last_name="Bạn phải nhập họ";
$addressbook_js_alert_must_enter_valid_email="Bạn phải nhập email hợp lệ";
$addressbook_js_alert_must_select_group="Liên lạc phải thuộc ít nhất 1 nhóm";
$addressbook_js_alert_sure_to_delete_contact="Bạn có chắc muốn xóa liên lạc này?";
$addressbook_show_info_new_contact_has_been_added="Liên lạc mới đã được tạo";
$addressbook_show_info_your_book_updated="Danh bạ đã được cập nhật";
$addressbook_show_info_view_all_in_group_default="Xem tất cả liên lạc trong nhóm $addressbook_group_default_name";
$addressbook_show_info_view_all_in_group="Xem tất cả liên lạc trong nhóm";
$addressbook_show_info_filter_by="Lọc bởi %show_name% bắt đầu với %show_key%";
$addressbook_show_info_email_already_added="Lỗi. email này có rồi";
$addressbook_show_info_search_with_keyword="Tìm trong danh bạ với từ khóa";
$addressbook_icon_tooltip_list_all_contact_this_group="Xem tất cả liên lạc trong nhóm này";

$reminder_big_title="Nhắc nhở";
$reminder_button_view_all_reminder="Xem tất cả nhắc nhở";
$reminder_button_view_my_calendar="Xem lịch";
$reminder_button_create_new_event="Tạo sự kiện";
$reminder_txt_click_add_new_reminder="Nhấp vào đây để tạo nhắc nhở mới";
$reminder_txt_enter_event_detail="Nhập chi tiết của sự kiện mà bạn muốn thêm vào lịch";
$reminder_txt_will_sent_to="Nhắc nhở đã được gửi đến";
$reminder_txt_event_date="Ngày";
$reminder_txt_event_name="Tên sự kiện";
$reminder_txt_event_detail="Chi tiết";
$reminder_txt_event_delete="Xóa";
$reminder_txt_repeat="Lặp lại";
$reminder_txt_no_repeat="Không lặp";
$reminder_txt_repeat_week="Lặp lại mỗi tuần";
$reminder_txt_repeat_month="Lặp lại mỗi tháng";
$reminder_txt_repeat_year="Lặp lại mỗi năm";
$reminder_js_alert_must_select_event_date="Bạn phải chọn ngày của sự kiện";
$reminder_js_alert_event_not_today="Bạn không thể chọn hôm nay";
$reminder_js_alert_event_not_today_no_save="Sự kiện không thể hôm nay.\\n\\nNhững thay đổi của bạn không được cập nhật.";
$reminder_js_alert_must_enter_event_name="Bạn phải nhập tên sự kiện";
$reminder_js_alert_sure_to_delete_reminder="Bạn chắc có muốn xóa sự kiện đã chọn?";
$reminder_show_info_new_event_has_been_added="Sự kiện mới đã được tạo";
$reminder_show_info_your_event_updated="Sự kiện của bạn đã được cập nhật";
$reminder_tooltip_click_to_edit_event_date="Nhấp chuột để chỉnh sửa sự kiện";

$calendar_txt_local_time_is ="Dùng <a href=\"$ecard_url/index.php?step=sign_in&next_step=show_myaccount\">Thông tin tài khoản</a> để thay đổi múi giờ(GMT). Giờ của bạn đang là";

$feedback_select_department ="Chọn nơi nhận";
$feedback_subject="Tiêu đề";
$feedback_message="Nội dung";
$feedback_js_alert_must_enter_name="Bạn phải nhập tên";
$feedback_js_alert_must_enter_subject="Bạn phải nhập tiêu đề";
$feedback_js_alert_must_enter_message="Bạn phải nhập nội dung";
$feedback_show_info_message_has_been_sent="Đã chuyển góp ý/yêu cầu của bạn! Chân thành cám ơn";
$feedback_button_send="Gửi";

$newsletter_js_alert_sure_to_remove_email="Bạn có chắc muốn không nhận email từ chúng tôi?";
$newsletter_show_info_email_has_been_added="Email của bạn đã được thêm vào Danh sách nhận bản tin của chúng tôi.";
$newsletter_show_info_email_has_been_deleted="Email của bạn đã được xóa khỏi Danh sách nhận bản tin của chúng tôi.";
$newsletter_show_info_email_not_found="Email của bạn không có trong Danh sách nhận bản tin của chúng tôi.";

$sendcard_txt_from="Người gửi";
$sendcard_txt_to="Người nhận"; 
$sendcard_txt_date_created="Ngày tạo";
$sendcard_txt_download_java="Không thấy được? <a href=\"http://java.com/en/download/index.jsp\" target=\"_blank\">Nhấp chuột vào đây</a> để tải Java!";
$sendcard_txt_download_flash="Không thấy được? <a href=\"http://www.adobe.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash\" target=\"_blank\">Nhấp chuột vào đây</a> để tải Flash!";
$sendcard_demo_mess="Lời nhắn, lời chúc ở đây.";

//For tell-a-friend & birthday alert & personalize ecards
$fieldset_title_sender_information="Thông tin Người gửi";
$fieldset_sender_name="Tên";
$fieldset_sender_email="Email";
$fieldset_title_recipient_information="Thông tin người nhận";
$fieldset_recipient_name="Tên";
$fieldset_recipient_email="Email";
$fieldset_number_recipient="Số người nhận";
$fieldset_maximum_number_10="(Tối đa <strong>10</strong>)";
$fieldset_maximum_is="Tối đa là ";
$fieldset_title_your_personal_message="Lời nhắn, chúc";
$button_send_to_friends="Gửi";
$txt_js_alert_must_enter_number="Bạn phải nhập số";
$txt_js_alert_maximum_number_is10="Số người nhận thiệp tối đa là 10";
$txt_js_alert_must_enter_sender_name="Bạn cần phải nhập tên người gửi";
$txt_js_alert_must_enter_sender_email="Bạn phải nhập email hợp lệ";
$txt_js_alert_missing_recipient="Bạn nhập thiếu tên hoặc email người nhận";
$txt_js_alert_must_enter_recipient_info="Bạn cần phải nhập thông tin người nhận";
$txt_js_alert_must_enter_valid_email="Bạn phải nhập email hợp lệ";
$txt_show_info_thankyou_message="Đã gửi! Cám ơn bạn đã giới thiệu trang web của chúng tôi đến bạn bè, người thân.";
$tellfriend_email_subject ="$sender_name đã gửi một tin nhắn";
$tellfriend_email_message=<<<EOF
Xin chào!
<br /><br />
Có người tên là $sender_name - $sender_email đã ghé thăm trang web của chúng tôi và anh/chị ấy muốn giới thiệu trang web này đến với bạn.
<br /><br />
Khi nào có thời gian rảnh rỗi bạn hãy bỏ chút thì giờ đến thăm chúng tôi tại địa chỉ website
<br /><br />
<a href="$ecard_url">$ecard_url</a>
<br /><br />
$sender_name wrote có vài dòng gửi đến bạn:

<br /><br />
-----------------------------------------------------------------------
<br /><br />
%show_message%
<br /><br />
-----------------------------------------------------------------------
<br /><br />
Thanks for reading this message. We hope that you will visit us soon and, Cám ơn bạn đã đọc thư này. Chúng tôi hy vọng bạn sẽ ghé thăm trang mạng của chúng tôi trong một ngày gần đây, và nếu có thể hãy giúp truyền bá trang web này đến với những người bạn khác.<a href="$ecard_url">$ecard_url</a>
<br /><br />
Ban quản trị $cf_site_title
EOF;

$birthday_alert_dob_title="Thông tin về ngày sinh nhật của bạn";
$birthday_alert_dob_message="%sender_name% muốn cập nhật ngày sunh của bạn để bạn ấy có thể gửi lời chúc mừng hàng năm cho bạn. Xin bạn hãy vui lòng nhập Tên, ngày sinh của mình vào bên dưới(chú ý: thông tin mà bạn nhập vào sẽ được lưu trữ ngay lập tức):";
$txt_birthday_alert_info="<strong>Tạo tin báo ngày sinh</strong> bằng cách hỏi bạn bè nhập ngày sinh của họ. Thông tin ngày sinh nhật của bạn bè sẽ được lưu vào trong Danh bạ(Address Book) và bạn sẽ nhận được tin nhắn qua email khi ngày sinh của bạn mình gần kề";
$txt_birthday_alert_show_info_thankyou_message="Cám ơn. Nội dung lời nhắn của bạn đã được gửi đi";
$txt_birthday_alert_email_subject ="$_SESSION[user_name] $_SESSION[user_last_name] cần bạn giúp.";
$txt_birthday_alert_email_message=<<<EOF
Chào bạn,
<br /><br />
Tôi là $_SESSION[user_name] $_SESSION[user_last_name]
<br /><br />
Hiện tại tôi đang sưu tập ngày sinh của bạn bè để xếp lên lịch và phần mềm của trang web này sẽ nhắc nhở tôi ngày sinh của bạn mình khi ngày ấy gần kề.
<br /><br />
Tôi hy vọng bạn sẽ cho tôi biết ngày sinh của mình. Vui lòng hãy theo đường link dưới đây để nhập vào ngày sinh nhật của bạn.
<br /><br />
<a href="%SHOW_LINK%">%SHOW_LINK%</a>
<br /><br />
Xin cám ơn, 
<br />
$_SESSION[user_name] $_SESSION[user_last_name] (<a href="mailto:{$_SESSION[user_email]}">{$_SESSION[user_email]}</a>)

EOF;

$fieldset_acct_balance_after_send_ppc_card="Số tiền của bạn còn lại sau khi gửi thiệp này";
$txt_current_acct_balance="Số tiền trong tài khoản:";
$txt_ppc_amount="Trả theo thiệp:";
$txt_new_acct_balance="Số tiền còn lại:";
$txt_title_personalize_your_card="Cá nhân hóa thiệp.";
$fieldset_preview_thumb_card="Xem trước khi gửi";
$fieldset_delivery_date="Ngày gửi:";
$txt_send_me_copy_this_card="Gửi cho tôi bản sao.";
$txt_notify_me_when_recipient_view_card="Báo cho tôi biết khi người nhận mở thiệp.";
$send_notify_pickup_email_subject ="$cs_from_name đã gửi thiệp từ trang web $cf_site_title";
$send_thank_you_message_email_subject ="Gửi lời cám ơn";
$send_notify_pickup_email_message=<<<EOF
Xin chào %show_friend_name%!
<br /><br />
$cs_from_name đã gửi cho bạn một tấm Thiệp
<br /><br />
Nhấp vào liên kết bên dưới để xem Thiệp:
<br /><br />
<a href="$ecard_url/index.php?step=pickup&cs_id=%show_id%">$ecard_url/index.php?step=pickup&cs_id=%show_id%</a>
<br /><br />
hoặc bạn có thể ghé thăm trang web:
<br /><br />
<a href="$ecard_url/index.php?step=pickup">$ecard_url/index.php?step=pickup</a>
<br /><br />
và nhập vào số Thiệp ID:  %show_id%
<br /><br />
Thiệp của bạn sẽ được lưu trữ trên trang web của chúng tôi $cf_card_expire_day ngày.
<br /><br />
$cf_site_title còn có rất nhiều loại thiệp nữa, mời bạn ghé thăm:
<br /><br />
<a href="$ecard_url">$ecard_url</a>
<br /><br />
Ban quản trị $cf_site_title

EOF;

$reminder_email_subject ="$cf_site_title nhắc nhở: %show_reminder_title%";
$reminder_email_message=<<<EOF
Bạn có nhắc nhở sau:
<br /><br />
%show_reminder_title%
<br /><br />
%show_reminder_content%
<br /><br />
Ngày:
<br /><br />
%show_event_date%
<br /><br />
Để thêm nhắc nhở, hay gửi thông tin về ngày sinh đến bạn bè để họ biết bạn đã không quên sinh nhật của họ, hay bạn muốn gửi một bức thiệp xinh xắn và ý nghĩa đến bạn bè, hay gửi một thiệp mời về một buổi tiệc bạn sắp tổ chức, hãy ghé thăm:
<br /><br />
<a href="$ecard_url">$ecard_url</a>
<br /><br />
Xin cám ơn đã sử dụng trang web của chúng tôi.
<br />
$cf_site_title (<a href="mailto:$cf_site_from_email">$cf_site_from_email</a>)

EOF;
$text_auto_send_birthday_mess_to_member="Chúc mừng sinh nhật. Chúc bạn có một ngày tuyệt vời.";

$show_card_body_more_card="Thiệp khác";
$show_card_body_goto_category_name="Đến danh mục";
$show_card_body_goto_popular="Thiệp phổ biến";
$show_card_body_goto_toprated="Đánh giá cao";
$show_card_body_goto_newest="Mới nhất";
$show_card_body_goto_homepage="Trang chủ";
$sendcard_didnot_send_because_email_blacklist="không thể gửi vì email này trong danh sách Không nhận thiệp";
$sendcard_thankyou_page_title="Xác nhận";
$sendcard_thankyou_card_has_been_sent="Thiệp đã được gửi, xin cám ơn bạn.";
$sendcard_auto_birthday_settings_saved="Đã lưu thông tin,  xin cám ơn bạn.";
$sendcard_thankyou_card_will_be_sent="Xin cám ơn bạn, Thiệp đã được gửi vào";
$sendcard_txt_card_has_been_send_to="Thiệp đã được gửi đến:";
$sendcard_php_no_java_applet="Không java applet";
$sendcard_php_button_select_image_effect="Chọn";
$sendcard_php_button_select_skin_background="Chọn nền";
$sendcard_php_button_select_stamp="Chọn tem";
$sendcard_php_button_select_music="Chọn nhạc";
$sendcard_php_no_music="Không nhạc";
$sendcard_php_my_upload="Của tôi";
$sendcard_php_button_select_poem="Chọn thơ/lời hay";
$sendcard_php_no_poem="Không thơ";
$sendcard_php_txt_align="Canh lề:";
$sendcard_php_txt_align_left="Trái";
$sendcard_php_txt_align_center="Giữa";
$sendcard_php_txt_align_right="Phải";
$sendcard_php_txt_author="Tác giả";
$sendcard_php_button_rate_this_card="Đánh giá";
$sendcard_php_button_print_this_card="In";
$sendcard_php_txt_rate_this_card_info="Đánh giá Thiệp bằng cách bấm vào hình ngôi sao. Đánh giá của bạn sẽ có hình ngôi sao màu vàng.";
$sendcard_php_button_card_info="Thông tin thiệp";
$sendcard_php_button_edit="Sửa";
$sendcard_php_button_send_now="Gửi";
$sendcard_php_button_add_to_fav="Thêm vào yêu thích";
$sendcard_php_button_remove_from_fav="Xóa khỏi yêu thích";
$sendcard_php_button_continue_next_step="Tiếp tục";
$sendcard_php_button_join_now_to_send="Đăng ký để gửi";
$sendcard_php_button_update_account_to_send="Nâng cấp tài khoản để gửi";
$sendcard_php_txt_save_recipient_to_addressbook="Tự động lưu tên & email của người nhận vào Danh bạ.";
$sendcard_php_txt_yes_join_newsletter="Tôi muốn nhận thông tin từ trang web.";
$sendcard_php_txt_yes_join_offers="Tôi muốn nhận tin tức về các quảng cáo đặc biệt của trang web.";
$sendcard_php_txt_login_to_use_addressbook="<a href=\"$ecard_url/index.php?step=sign_in\">Đăng nhập</a> để sử dụng Danh bạ";
$sendcard_php_txt_update_account_to_use_addressbook="<a href=\"$ecard_url/index.php?step=update_your_account\">Cập nhật</a> tài khoản để dùng Danh bạ";
$sendcard_php_txt_number_of_email="Số lượng email:";
$show_personalize_table_tooltip_default_size="Cỡ mặc định";
$show_personalize_table_tooltip_increase_size="Tăng kích thước";
$show_personalize_table_tooltip_decrease_size="Giảm kích thước";
$show_personalize_table_button_preview_card="Xem trước";
$show_personalize_table_txt_pick_a_date="Chọn ngày";
$show_personalize_table_txt_send_card_today="Gửi hôm nay";
$show_card_has_been_sent_button_send_to_someone_else="Gửi thiệp này đến người khác nữa";
$show_card_has_been_sent_button_send_another_ecard="Gửi thiệp khác";

$pickup_button_print_this_card="In thiệp";
$pickup_button_send_ecard="Gửi thiệp";
$pickup_button_reply_to_this_card="Trả lời";
$pickup_card_error_cardid_not_found="Hệ thống không thể cho bạn xem Thiệp đã yêu cầu.<br /><br />Hoặc là bạn điền số Thiệp sai, điền địa chỉ URL sai hoặc Thiệp đã quá hạn cho phép nhận.<br /><br /> Xin vui lòng xem lại.";
$send_notify_user_has_viewed_card_email_subject ="%show_name% đã nhận thiệp"; 
$send_notify_user_has_viewed_card=<<<EOF
Xin chào %show_name%,
<br /><br />
%show_fname% đã xem Thiệp của bạn gửi.
<br /><br />
Nhấp vào liên kêt bên dưới để xem lại tấm thiệp này
<br /><br />
<a href="$ecard_url/index.php?step=pickup&cs_id=%show_id%&action=viewcopy">$ecard_url/index.php?step=pickup&cs_id=%show_id%&action=viewcopy</a>
<br /><br />
Hoặc có thể vào liên kết bên dưới:
<br /><br />
<a href="$ecard_url/index.php?step=pickup&action=viewcopy">$ecard_url/index.php?step=pickup&action=viewcopy</a>
<br /><br />
rồi nhập Thiệp ID:  %show_id%
<br /><br />
Cám ơn bạn đã sử dụng trang web của chúng tôi để gửi thiệp.
<br /><br />
Muốn xem thêm thiệp ở $cf_site_title vui lòng nhấp chuột vào liên kết:
<br /><br />
<a href="$ecard_url">$ecard_url</a>
EOF;

$txt_send_card_over_limit="Quá giới hạn";
$txt_send_card_over_limit_message="Hệ thống chống SPAM đang hoạt động.<br /><br />Bạn đang nhìn thấy những dòng chữ này là do hệ thống của chúng tôi chỉ cho phép những thành viên trong nhóm của bạn được phép gửi tối đa <span class=\"Error_Message\">$_SESSION[mg_number_recipient_per_hour]</span> email trong một giờ và tối đa <span class=\"Error_Message\">$_SESSION[mg_number_recipient_per_day]</span> email trong một ngày. Vui lòng quay lại gửi thiệp trong một giờ tới";

$history_txt_tooltip_view_card="Xem thiệp";
$history_txt_tooltip_delete_card="Xóa thiệp";
$history_txt_tooltip_resend_card="Gửi lại thiệp";
$history_js_alert_sure_to_delete_card="Bạn muốn xóa bỏ Thiệp này?";
$history_txt_title_scheduled_cards="LỊCH TRÌNH GỬI THIỆP";
$history_txt_header_card="THIỆP";
$history_txt_card_sent="ĐÃ GỬI";
$history_txt_header_send_to="GỬI ĐẾN";
$history_txt_header_scheduled_date="NGẢY SẼ GỬI";
$history_txt_header_date_sent="NGÀY GỬI";
$history_txt_header_date_pickup="NGÀY NHẬN";

$myalbum_info_photo="Bạn có thể tải hình ảnh của mình lên & dùng nó như là 1 thiệp.";
$myalbum_button_goto_photo="Ảnh của tôi";
$myalbum_info_music="Bạn có thể thêm giọng nói hoặc bài hát(vui lòng xem bản quyền bài hát đó) đính kèm vào thiệp. Bạn có thể thu âm tiếng của mình hoặc tải nhạc lên. Sau đó trong phần Cá nhân hóa thiệp, bạn có thể chọn nhạc/tiếng của mình đính kèm trong thiệp đó.";
$myalbum_button_goto_music="Nhạc của tôi";
$myalbum_info_poem="Bạn có thể dùng thơ, lời hay ý đẹp hay từ mình đặt ra nội dung để gửi kèm thiệp! Sau khi thêm vô thì trong phần Cá nhân hóa thiệp, bạn có thể chọn <strong>Chọn thơ/lời hay</strong> của mình đính kèm trong thiệp đó.";
$myalbum_button_goto_poem="Thơ của tôi";
$myalbum_info_stamp="Nếu bạn muốn dùng Tem riêng, xin vui lòng chuyển Tem riêng về đây, sau đó chọn một Thiệp; ở phần &quot;<b>Cá nhân hóa</b>&quot; bấm nút &quot;<strong>Chọn Tem</strong>&quot; để dùng Tem riêng của bạn.";
$myalbum_button_goto_stamp="Tem của tôi"; 
$myalbum_info_font="Bạn có muốn dùng font chữ của mình cho thiệp không? Hãy chuyển font của bạn lên, và chọn một thiệp/thiệp mời, kế tiếp là  &quot;<b>Cá nhân hoá thiệp mời</b>&quot; bâm chọn &quot;<strong>Chọn font</strong>&quot; để chọn font chữ của mình.";
$myalbum_button_goto_font="Font của tôi"; 

$myalbum_photo_title="Ảnh của tôi";
$myalbum_txt_photo_thumbnail="Hình nhỏ";
$myalbum_txt_send_this_card="Gửi hình này";
$myalbum_txt_send_this_card_tooltip="Dùng hình này làm thiệp gửi đi";
$myalbum_txt_delete_this_card="Xóa";
$myalbum_Image_click_to_upload ="Nhấp vào đây để tải ảnh";
$myalbum_Album_click_to_create ="Nhấp vào đây để tạo album";
$myalbum_Image_Title ="Tải ảnh từ máy";
$myalbum_Album_Title ="Tạo album";
$myalbum_txt_Image_File_Browse="Nhấp nút Browse(Chọn file để chọn ảnh của bạn (Loại tập tin: .gif .jpg .png .swf)";
$myalbum_txt_Album_Create_New="Tạo album ảnh để lưu trữ các bức ảnh để sau này có thể gửi tới bạn bè, người thân như thiệp";
$myalbum_txt_album_name = "Tên album";
$myalbum_txt_album_description = "Mô tả";
$myalbum_txt_album_private = "Riêng tư?";
$myalbum_txt_album_no_pictures = "ảnh";
$myalbum_txt_Album_Create_New_Javascript_Error_Name_Required = "Bạn phải nhập tên album";
$myalbum_txt_Album_Create_New_Javascript_Error_Desc_Required = "Bạn phải nhập mô tả";
$myalbum_image_error_msg_image_Type ="Định dạng tập tin ảnh phải là: .gif hoặc .jpg hoặc .png hoặc .swf.";
$myalbum_image_error_msg_image_FileSize_Big ="Kích thước ảnh to quá. Bạn phải chọn ảnh có kích thước nhỏ hơn hoặc bằng $cf_image_upload_max_size bytes";
$myalbum_image_error_msg_image_Over_Limit ="Xin lỗi, Bạn chỉ có thể tải lên tổng số ảnh là $cf_album_max_image.<br />Vui lòng xóa bớt ảnh để tải lên tiếp.";
$myalbum_image_msg_New_Image_Added ="Ảnh của bạn đã được thêm.";
$myalbum_image_msg_New_Album_Added ="Album ảnh đã được tạo.";
$myalbum_member_delete_image_confirm ="Bạn có chắc muốn xóa những ảnh đã chọn?";
$myalbum_msg_Image_updated ="Album ảnh đã được cập nhật";
$myalbum_button_upload_now="Tải ảnh lên";
$myalbum_button_create_now = "Create Now";
$myalbum_js_alert_must_input_file="Bạn phải chọn ảnh.";
$myalbum_txt_checkbox_select_all="Chọn tất cả";
$myalbum_txt_checkbox_check_all="Chọn/Không chọn tất cả";


$myalbum_stamp_title="Tem của tôi";
$myalbum_txt_stamp_thumbnail="Ảnh nhỏ";
$myalbum_txt_Stamp_File_Browse="Nhấp nút Browse(Chọn file để chọn ảnh của bạn (Loại tập tin: .gif .jpg .png). Kích thước tem nên: $cf_album_max_stamp_width px x $cf_album_max_stamp_height px";
$myalbum_Stamp_click_to_upload ="Nhấp vào đây để tải tem";
$myalbum_member_delete_stamp_confirm ="Bạn có chắc muốn xóa những tem đã chọn?";
$myalbum_image_error_msg_stamp_Type ="Định dạng tập tin tem phải là: .gif hoặc .jpg hoặc .png";
$myalbum_image_error_msg_stamp_FileSize_Big ="Kích thước tem to quá. Bạn phải chọn tem có kích thước nhỏ hơn hoặc bằng $cf_stamp_upload_max_size bytes";
$myalbum_image_error_msg_stamp_Over_Limit ="Xin lỗi, Bạn chỉ có thể tải lên tổng số tem là  $cf_album_max_stamp.<br />Vui lòng xóa bớt tem để tải lên tiếp.";
$myalbum_image_msg_New_Stamp_Added ="Tem của bạn đã được thêm.";
$myalbum_msg_Stamp_updated="Album tem đã được cập nhật";

$myalbum_music_title="Nhạc của tôi";
$myalbum_music_click_to_upload="Nhấp vào đây để tải nhạc/tiếng";
$myalbum_music_upload_my_voice="Tải nhạc lên";
$myalbum_upload_music_title="Tải nhạc lên";
$myalbum_txt_Music_File_Browse="Nhấp nút Browse(Chọn file để chọn nhạc của bạn (Loại tập tin: .mp3 .wma)";
$myalbum_txt_music_title="Tên bài hát";
$myalbum_txt_song_file_name="Tên tập tin";
$myalbum_txt_song_play="Nghe";
$myalbum_txt_delete_this_song="Xóa";
$myalbum_member_delete_music_confirm="Bạn có chắc muốn xóa những nhạc/tiếng đã chọn?";
$myalbum_txt_tooltip_play_song="Nghe bài này";
$myalbum_msg_Music_updated="Album nhạc của bạn đã cập nhật";
$myalbum_music_error_msg_music_Type="Định dạng tập tin nhạc phải là: .wma hoặc .mp3";
$myalbum_music_error_msg_music_FileSize_Big="Kích thước nhạc to quá. Bạn phải chọn nhạc có kích thước nhỏ hơn hoặc bằng  $cf_music_upload_max_size bytes";
$myalbum_music_error_msg_music_Over_Limit="Xin lỗi, Bạn chỉ có thể tải lên tổng số nhạc là $cf_album_max_music.<br />Vui lòng xóa bớt nhạc để tải lên tiếp.";
$myalbum_music_msg_New_Music_Added="Nhạc đã được thêm.";

$myalbum_poem_title="Thơ của tôi";
$myalbum_Poem_click_to_upload="Tạo thơ/lời hay mới";
$myalbum_upload_poem_title="Tạo thơ/lời hay mới";
$myalbum_txt_poem_title="Tiêu đề";
$myalbum_txt_poem_author="Tác giả";
$myalbum_txt_poem_body="Nội dung";
$myalbum_button_add_poem="Thêm";
$myalbum_txt_poem_title_author_body="Tiêu đề / Tác giả / Nội dung";
$myalbum_txt_delete_this_poem="Xóa";
$myalbum_msg_poem_updated="Album thơ đã được cập nhật";
$myalbum_poem_msg_New_poem_Added="Thơ mới đã được thêm";
$myalbum_poem_js_alert_must_enter_poem_title="Bạn phải nhập tiêu đề";
$myalbum_poem_js_alert_must_enter_poem_author="Bạn phải nhập tác giả";
$myalbum_poem_js_alert_must_enter_poem_body="Bạn phải nhập nội dung";
$myalbum_member_delete_poem_confirm="Bạn có chắc muốn xóa những thơ/lời hay đã chọn?";

$myalbum_font_title="Font của tối";
$myalbum_upload_font_title="Tải font mới";
$myalbum_txt_font_name="Tên font";
$myalbum_txt_sample="Hình mẫu";
$myalbum_txt_delete_this_font="Xóa";
$myalbum_txt_Font_File_Browse="Nhấp nút Browse(Chọn file để chọn nhạc của bạn (Loại tập tin: .ttf).";
$myalbum_Font_click_to_upload ="Nhấp vào đây để tải font mới";
$myalbum_member_delete_font_confirm ="Bạn có chắc muốn xóa những font đã chọn?";
$myalbum_font_error_msg_font_Type="Bạn phải chọn định dạng (.ttf)";
$myalbum_font_error_msg_overlimit_upload_font="Xin lỗi, Bạn chỉ có thể tải lên tổng số font là $cf_user_max_font_upload.<br />Vui lòng xóa bớt font để tải lên tiếp.";
$myalbum_font_msg_New_font_Added="Font đã được thêm";
$myalbum_msg_font_updated="Album font đã được cập nhật";

//GRABBER ------------------------------------------------------
$show_media_grabber_html_Enter_Domain="Nhập đường dẫn mà bạn muốn lấy hình";
$show_media_grabber_html_note=<<<EOF
Với dịch vụ đặc biệt này của chúng tôi, bạn có thể sử dụng bất cứ hình ảnh/phim ảnh nào (Photo, Flash, Shockwave, QuickTime movie, Windows Media, Real Video/Audio, Midi, MP3) từ bất cứ trang web nào. Bạn có biến đổi những hình ảnh/phim ảnh đó thành Thiệp điện tử, rất dễ dàng. Chỉ việc theo phần hướng dẫn sau:
  <ul>
    <li>Vào trang web mà bạn muốn lấy hình</li>
    <li>Chép đường dẫn đó</li>
    <li>Chép địa chỉ đường dẫn đó vào phần textbox bên dưới rồi nhấn nút Submit</li>
  </ul>

EOF;

$Grabber_Found_Files = "<p class=\"OK_Message\">Tìm thấy %y% hình ảnh hoặc file nhạc trên trang web:<br />%grab_url%<br />(Chú ý: những hình ảnh hoặc file nhạc này có thể có bản quyền tác giả.)</p>";
$Grabber_Step_Title_2 ="ATTENTION!!!";
$Grabber_Sorry_You_cannot_send_this_image_as_an_ecard ="Xin lỗi, bạn không thể gửi hình này như một tấm Thiệp";
$Grabber_Terms_and_Condition=<<<EOF
<p class='Error_Message'>NỘI QUY SỬ DỤNG<br /><br />
Để gửi tấm hình này như là một Thiệp điện tử (ecard) cho người thân, BẠN - người dùng, sẽ phải chịu trách nhiệm về mọi hậu quả có liên quan đến bản quyền tác giả (Copyright)<br /><br />BẠN CÓ ĐỒNG Ý ĐIỀU KHOẢN NÀY?
<br /><br />
<a href="javascript:answer('yes')" class='button_link_style1'>ĐỒNG Ý</a>
<a href="javascript:answer('no')" class='button_link_style2'>KHÔNG</a><br /><br />	
</p>
EOF;
$Grabber_button_send_flash_as_ecard="Gởi phim như Thiệp";
$Grabber_button_send_photo_as_ecard="Gởi hình Thiệp";
$Grabber_button_download_this_file="Tải tập tin này";

$thumb_tool_preview_invite_message="Xem trước lời nhắn";

$invite_color_table_select_color="Chọn màu";
$invite_color_table_standard_color="Màu chuẩn";
$invite_color_table_default_color="Màu mặc định";
$invite_format_font_each_line="Định dạng font cho mỗi dòng";
$invite_button_select_fontcolor="Chọn màu";
$invite_button_select_other_line="Chọn dòng khác";
$invite_button_apply_changes="Lưu thay đổi";
$invite_button_apply_changes_and_close_window="Lưu và Đóng";
$invite_button_create_message="Tạo tin nhắn";
$invite_button_click_change_message="Nhấp vào đây để thay đổi lời nhắn";
$invite_button_fontface="Chọn font";
$invite_select_fontface_title="Chọn font";
$invite_button_fontsize="Kích thước";
$invite_button_fontcolor="Màu sắc";
$invite_button_line_height="Chiều rộng";
$invite_button_open_fontformat_window="Định dạng font";
$invite_button_use_basic_invite_info="Định dạng tin nhắn đơn giản";
$invite_button_view_map="Xem bản đồ";
$invite_basic_message_select_text_line="Chọn dòng bạn muốn chỉnh sửa định dạng font chữ";
$invite_basic_message_title="Lời nhắn cơ bản";
$invite_basic_message_event_name="Tên sự kiện";
$invite_basic_message_hosted_by="Người mời";
$invite_basic_message_when="Khi";
$invite_basic_message_where="Nơi";
$invite_basic_message_date="Ngày";
$invite_basic_message_select_event_date="Chọn ngày";
$invite_basic_message_time="Thời gian";
$invite_basic_message_location_name="Địa điểm";
$invite_basic_message_street_address="Đường";
$invite_basic_message_city="Thành phố";
$invite_basic_message_state="Tỉnh";
$invite_basic_message_zipcode="Zip code";
$invite_basic_message_zipcode_country="Zip code, Quốc gia";
$invite_basic_message_phone="Số điện thoại";
$invite_basic_message_youre_invited="BẠN ĐƯỢC MỜI";
$invite_js_alert_must_enter_event_name="Bạn phải nhập Tên sự kiện";
$invite_js_alert_must_enter_hosted_by="Bạn phải nhập người mời";
$invite_js_alert_must_enter_date_time="Bạn phải nhập ngày & giờ";
$invite_js_alert_must_enter_location_name="Bạn phải nhập địa điểm tổ chức";
$invite_js_alert_must_enter_address="Bạn phải nhập tên đường";
$invite_js_alert_must_enter_location_city="Bạn phải nhập thành phố";
$invite_js_alert_must_enter_location_state="Bạn phải nhập bang/tỉnh";
$invite_js_alert_must_enter_location_zip="Bạn phải nhập zip code";
$invite_js_alert_must_enter_phone_number="Bạn phải nhập số điện thoại";
$invite_js_alert_must_enter_card_message="Bạn phải nhập nội dung lời nhắn";
$invite_js_alert_must_insert_your_photo="Bạn phải thêm hình vào thiệp mời";
$invite_personal_message_if_announcement_card="Hay xem lại nếu đây là<strong>Thiệp có thông báo</strong>. Khi người nhận nhận thiệp này, người đó sẽ không thấy câu hỏi: <strong>Bạn có dự tiệc hay không?</strong>";
$invite_personal_message_show_map_reminder="Hiện bản đồ và email nhắc nhở";
$invite_personal_message_would_you_like_show_map="Bạn có muốn hiện bản đồ cho khách mời không?";
$invite_personal_message_would_you_like_reminder="Bạn có muốn gửi email nhắc nhở cho khách mời không?";
$invite_personal_message_say_yes="CÓ";
$invite_personal_message_say_no="KHÔNG";
$invite_personal_message_reminder_guest="Nhắc nhở khách mời";
$invite_photo_goes_here_not_login="<strong>Hình của bạn</strong><br /><br /><br />Vui lòng đăng nhập để tải hình của bạn vào thiệp này.";
$invite_button_insert_your_photo="Bấm vào đây để chèn hình";
$invite_button_upload_your_photo="Bấm vào đây để tải hình";
$invite_select_your_photo_title="Chọn hình";
$invite_show_error_message_event_name="Bạn phải nhập tên sự kiện";
$invite_homepage_message=<<<EOF
<h1><img border="0" src="$ecard_url/templates/$cf_set_template/icon_invitation.gif" alt="" style="vertical-align:middle" /> Thiệp Mời</h1>
<p>Với dịch vụ Thiệp mời của $cf_site_title, bạn có thể tạo và gửi thiệp mời trực tuyến, và theo dõi việc khách có đến tham dự buổi tiệc của bạn không.</p>
<p>Việc này rất nhanh và dễ dàng. Hãy bấm chọn loại thiệp mời ở Danh mục bên trái.</p>
<p>Đây là danh sách khách mời (Vui lòng đăng nhập để thấy được thông tin)</p>
EOF;
$invite_homepage_message_txt_guest_name_email="Tên khách mời và email";
$invite_homepage_message_txt_invitation_title="Tiêu đề Thiệp mời";
$invite_homepage_message_txt_total_guest="Số lượng khách";
$invite_homepage_message_txt_accepted="Dự tiệc";
$invite_homepage_message_txt_declined="Không";
$invite_homepage_message_txt_not_sure="Chưa chắc";
$invite_homepage_message_txt_no_response="Chưa hồi âm";
$invite_homepage_message_txt_guest_message="Lời nhắn của khách";
$invite_homepage_message_txt_delete="Xóa";
$invite_homepage_message_txt_add_guest="Thêm khách mời";
$invite_guests_have_been_added="%show_number% khách mời đã được thêm vào danh sách.";
$invite_add_guests_didnot_send_because_email_blacklist_or_dubplicate="chưa gửi được vì email này nằm trong Danh sách không nhận thiệp hoặc khách này đã có trong danh sách rồi.";
$invite_txt_view_card_detail="Xem chi tiết";
$invite_detail_created_date="Thiệp mời được tạo vào:";
$invite_detail_button_preview_card="Xem trước";
$invite_detail_card_has_been_sent_to_number_guest="Thiệp này đã được gửi đến <span class=\"OK_Message\">%show_number%</span> khách.";
$invite_detail_number_guest_will_attend="Số khách sẽ đến dự tiệc: <span class=\"OK_Message\">%show_number%</span>";
$invite_detail_number_guest_unsure_attend="Số khách không chắc sẽ có mặt: <span class=\"OK_Message\">%show_number%</span>";

$invite_pickup_card_info="Thiệp mời này được <strong>%show_sender_name%</strong> tạo vào  <strong>%show_date%</strong><br />gửi đến <strong>%receiver_name_email%</strong>";
$invite_pickup_reply_add_comment="<strong>Thêm ghi chú. (tuỳ chọn)</strong>";
$invite_pickup_reply_will_you_attend="<strong>Bạn sẽ tham dự?</strong> <span class=\"Error_Message\">*</span>";
$invite_pickup_reply_yes="<strong>CÓ</strong>";
$invite_pickup_reply_no="<strong>KHÔNG</strong>";
$invite_pickup_reply_notsure="<strong>Chưa chắc</strong>";
$invite_pickup_reply_number_guest_come_with_you="<strong>Số lượng khách sẽ tham dự: <span class=\"Error_Message\">*</span> </strong>";
$invite_pickup_button_send_reply="GỬI TRẢ LỜI";
$invite_reply_thankyou="Chân thành cám ơn! lời nhắn của bạn sẽ gừi đến chủ nhân buổi tiệc";
$invite_reminder_note_subject="Nhắc nhở Thiệp mời, vào: ";
$invite_send_pickup_email_subject ="$_SESSION[user_name] $_SESSION[user_last_name] đã gửi cho bạn một thiệp mời từ $cf_site_title";
$invite_send_pickup_email_message=<<<EOF
Xin chào %show_friend_name%!
<br /><br />
$_SESSION[user_name] $_SESSION[user_last_name] đã gửi cho bạn một thiệp mời.
<br /><br />
Nhấp chuột vào liên kết bên dưới để xem chi tiếp:
<br /><br />
<a href="$ecard_url/index.php?step=pickup_invite&cs_id=%show_id%">$ecard_url/index.php?step=pickup_invite&cs_id=%show_id%</a>
<br /><br />
Thiệp mời này sẽ tồn tại $cf_card_expire_day_invite ngày.
<br /><br />
Để thêm nhắc nhở, hay gửi thông tin về ngày sinh đến bạn bè để họ biết bạn đã không quên sinh nhật của họ, hay bạn muốn gửi một bức thiệp xinh xắn và ý nghĩa đến bạn bè, hay gửi một thiệp mời về một buổi tiệc bạn sắp tổ chức, hãy ghé thăm:
<br /><br />
<a href="$ecard_url">$ecard_url</a>
<br /><br />
Ban quản trị $cf_site_title

EOF;

$invite_send_notify_user_has_replied_card_email_subject ="%show_name%  đã trả lời thiệp mời của bạn";
$invite_send_notify_user_has_replied_card_email_message=<<<EOF
Xin chào %show_name%,
<br /><br />
%content%
Tham dự: %attend%
<br /><br />
Số lượng khách: %number%
<br /><br />
Thiệp mời này sẽ tồn tại $cf_card_expire_day_invite ngày.
<br /><br />
Để theo dõi tình trạng khách mời của thiệp, bạn vui lòng đăng nhập để xem
<br /><br />
<a href="$ecard_url/index.php?step=show_invitation">$ecard_url/index.php?step=show_invitation</a>
<br /><br />
Xin cám ơn đã sử dụng $cf_site_title!
<br /><br />
Để thêm nhắc nhở, hay gửi thông tin về ngày sinh đến bạn bè để họ biết bạn đã không quên sinh nhật của họ, hay bạn muốn gửi một bức thiệp xinh xắn và ý nghĩa đến bạn bè, hay gửi một thiệp mời về một buổi tiệc bạn sắp tổ chức, hãy ghé thăm:
<br /><br />
<a href="$ecard_url">$ecard_url</a>

EOF;

/*
	You also need to translate those html files below to your language:

	+ english_lang_grabber_install_ok.html ----> COUNTRY_lang_grabber_install_ok.html
	+ english_lang_help.html  ----> COUNTRY_lang_help.html
	+ english_lang_policy.html  ----> COUNTRY_lang_policy.html
	+ english_lang_tos.html  ----> COUNTRY_lang_tos.html
*/


$addressbook_button_import="Nhập Danh bạ";
$addressbook_txt_click_load_contact="Nhập danh bạ từ tập tin";
$addressbook_file="File";$addressbook_upload="Tải lên";
$addressbook_load_error="Vui lòng chọn loại tập tin!";
$load_address_book_from_file="Tải tập tin csv,vcard để nhập vô danh bạ";
$was_imported_into_your_address_book_sucessfully="đã tải lên danh bạ của bạn thành công!";
$items_was_added_into_your_address_book="Liên lạc đã được thêm:";
$invalid_items="Liên lạc không hợp lệ:";
$already_exist_items_in_your_address_book="đã tồn tại trong danh bạ";
$twitter_message="đã tạo thiệp đặc biệt cho bạn <a href=\"$ecard_url/index.php?step=pickup&cs_id=%show_id%\">$ecard_url/index.php?step=pickup&cs_id=%show_id%</a> [nhấp chuột vào liên kết để xem]";
$twitter_private_message="Đã tạo một thiệp đặc biệt cho @%recipient% <a href=\"$ecard_url/index.php?step=pickup&cs_id=%show_id%\">$ecard_url/index.php?step=pickup&cs_id=%show_id%</a>";
$twitter_account_to_send="- Sử dụng twitter %twitter_account% để gửi thiệp. <a href=\"$ecard_url/index.php?step=sign_in&next_step=show_myaccount#twitter_connection\">Nhấp vào đây</a> để thay đổi tài khoản twitter.<br>";
$twitter_message_help="<b>Ghi chú:</b><br><i>%twitter_to_send_message%- nhập<b>@twitter_recipient</b> như một email để gửi thiệp đến tài khoản twitter người nhận như tin nhắn công khai. Ví dụ: <b>@someone</b>.<br>- Nhập  <b>d twitter_recipient</b>  như một email để gửi thiệp đến tài khoản twitter người nhận như tin nhắn riêng. Ví dụ: <b>d someone</b>.<br>- Người nhận phải theo dõi bạn để nhận tin nhắn. Vui lòng xem thêm thông tin này ở: <b>http://twitter.com/recipients_twitter/following</b></i><br />";
$twitter_message_help_disabled="";

$invite_homepage_message_txt_no_resend = "Gửi lại";
$add_your_comment="Thêm nhận xét";
$message_is_required="Bạn phải nhận nội dung";
$message_post_by="Gửi bởi";
$message_on="vào";
// Language for Send Video Card
$send_video_card_title="Gửi thiệp video";
$send_video_card_embed_code="Video embed code";
$send_video_card_example="Nhập Video embed code - ví dụ:";
$send_video_card_show_info=" Gửi video như là thiệp";

$send_on_recipient_birthday="Gửi trong ngày sinh nhật của bạn bè";
$birthday_this_group="Hiện gửi thiệp tự đông trong ngày sinh nhật";
$set_birthday_card="Hiện gửi thiệp tự đông trong ngày sinh nhật";
$recipient_group="Nhóm nhận";
$select_a_group="Chọn nhóm";
$default_group="Nhóm mặc định";
$save_setting="Lưu cấu hình";
$please_select_a_group="Chọn nhóm!";
$sendcard_txt_card_has_been_saved="Cấu hình thiệp đã được lưu!";
$select_button_send_another_ecard="Chọn thiệp khác";
$would_you_like_to_setting_card="Bạn chưa chọn thiệp nào cả. Vui lòng chọn thiệp trước khi chọn icon của tạo thiệp cho ngày sinh nhật.";

$add_new_recipient="Người nhận";
$add_from_address_book="Nhóm nhận";
$select_group="Chọn nhóm";
$default_group="Danh bạ";
$select_or_choise="hoặc chọn người nhận từ Danh bạ";
$email_template="Định dạng Email";
$email_subject="Tiêu đề";
$more="Thêm";
$customize_card="cá nhân thiệp";
$add_recipient_message="thêm người nhận & tin nhắn";
$send_card="Gửi thiệp";
$do_not_change_password="Đăng nhập bằng Facebook nên không cần thay đổi mật khẩu.";
$send_an_ecard="%FROM_NAME% đã gửi thiệp cho bạn từ $cf_site_title";
$you_are_here="Đang ở: ";
$newest_invitation_ecards="Thiệp mời mới nhất";
$txt_card_lable_HTML="HTML";
$txt_card_lable_YOUTUBE="YOUTUBE";
$txt_card_lable_VIDEO="VIDEO";
$txt_free="miễn phí";
$twitter_recipient="Người nhận bằng Twitter";
$share_with_social_network="Chia sẽ với mạng xã hội";
$member_group_txt_allow_to_share_card_with_twitter="Cho phép chia sẽ với Twitter";
$member_group_txt_allow_to_share_card_with_facebook="Cho phép chia sẽ với  Facebook";
$member_group_txt_allow_to_share_card_with_googleplus="Cho phép chia sẽ với  Google Plus";
$member_group_txt_allow_to_share_card_with_linkedin="Cho phép chia sẽ với  Linkedin";
$txt_show_list_data = "List data";
$txt_ecard_category = "Danh mục";
$invite_homepage_message_responsive=<<<EOF
<h1 class='table_title_bar' id='title-1'><i class='fa fa-birthday-cake padding5'></i> Invitation</h1>
<div class='invitation-message'>
<p>Với dịch vụ Thiệp mời của $cf_site_title, bạn có thể tạo và gửi thiệp mời trực tuyến, và theo dõi việc khách có đến tham dự buổi tiệc của bạn không.</p>
<p>Việc này rất nhanh và dễ dàng. Hãy bấm chọn loại thiệp mời ở Danh mục bên trái.</p>
<p>Đây là danh sách khách mời (Vui lòng đăng nhập để thấy được thông tin)</p>
</div>
EOF;
$send_thank_you_message = "Gửi tin nhắc cảm ơn";
$device_no_support_record = "Not support in your device";
$click_here_to_record = "Click here to record";
$notify_search_empty = <<<EOF
Sorry, but nothing matched your search terms. <br />
Please try again with different keywords.
EOF;
$txt_search_results = "Search results";
$newsletter_subscribe_description = "Get the most recent updates from 
our site and be updated your self...";
$sendcard_php_no_stamp="No Stamp";
$sendcard_notify_auto_birthday_card="Set this ecard to send for your's friend birthday.";
$sendcard_prev_card="Previous Card";
$sendcard_next_card="Next Card";
?>
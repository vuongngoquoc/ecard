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
$button_select_languages="Select languages";
$button_search_ecard="Search ecards";
$button_search="Search";
$button_go="Go";
$button_join_now="Join now";
$button_sign_in="Login";
$button_logout="Logout";
$button_submit="Submit";
$button_submit_join="";
$button_view_card="View Card";
$button_delete_selected="Delete Selected";
$button_game_click_to_play="Click here to play";
$icon_title_close_hide="Close/Hide";
$txt_total_card="Total cards";
$txt_link_facebook="FaceBook";
$txt_caption_paypercard="Pay Per Card. Pay %show_money% to send this card";
$txt_card_lable_POSTCARD="POSTCARD";
$txt_card_lable_FLASH="FLASH CARD";
$txt_card_lable_INVITATION="INVITATION";
$txt_card_lable_remove_favorite="Delete Fav";
$txt_js_alert_sure_to_delete_card_favorite="Are you sure you want to remove this card from favorite?";//<-- Do not use single quote ' here
$txt_js_alert_print_card="In order to print all content of this card you must set your browser Print Background (Color and images) enable.";
$txt_row_per_page="Display row per page";
$txt_tooltip_select_all="Select All";
$txt_tooltip_click_to_edit="Click here to edit";
$txt_keyword="Keyword";
$txt_search_in_category="Search in categories";
$txt_search_exact_word="Search exact word";
$text_search_all_categories="All categories";
$txt_cards="cards";
$txt_home ="Home";
$txt_popular ="Popular";
$txt_top_rate ="Top-Rated";
$txt_newecards ="New";
$txt_new_ecards ="New eCards";
$txt_play_games ="Games";
$txt_pickup ="Pick Up";
$txt_tell_friends ="Tell Friends";
$txt_help ="Help";
$txt_media_grabber ="Media Grabber";
$txt_black_list ="Black List";
$txt_random_card ="Random";
$txt_newsletter="Newsletter";
$txt_feedback ="Feedback";
$txt_policy ="Privacy Policy";
$txt_tos ="Terms of Service";
$txt_welcome_guest="Welcome Guest";
$txt_mtool_myaccount ="My Account";
$txt_mtool_invitation="Invitations";
$txt_mtool_addressbook ="Address Book";
$txt_mtool_calendar ="Calendar";
$txt_mtool_myalbum ="My Albums";
$txt_mtool_reminder ="Event Reminder";
$txt_mtool_myfavorite ="Favorites";
$txt_mtool_history ="History";
$txt_mtool_birthdayalert ="Birthday Alert";
$txt_mtool_sendvideocard ="Send Video Card";
$txt_welcome_back_user="Welcome back";
$txt_calendar="Calendar";
$txt_calendar_today="Today";
$txt_dropdown_select="Select-";
$cat_select_category="SELECT CATEGORY";
$txt_ban_error_message="You are banned from using our service. See reason below:";
$txt_account_verification="Verify your account";

//Language for Verify Account page
$txt_verify_account_successfully="Your account is activated now. Please log in to use the website.";
$txt_verify_account_fail="The activate code is incorrect. Your account is still inactive.";

$txt_black_list_add="Add your email to this list and you won't receive eCards, Birthday Alerts, Tell-a-Friends, and welcome emails from our web site.";
$button_add_to_black_list="Add your email to black list";
$txt_black_list_remove="Remove your email from this list so that $cf_site_title, your friends, and family can send you eCards and other emails from our web site.";
$button_remove_from_black_list="Remove your email from black list";
$blacklist_error_message_email_exist ="We found your email $add_black_email on the Black List. No action required.";
$blacklist_error_message_whenremove_email_not_onlist ="Your email $remove_black_email is not on our Black List. You don't have to remove it.";
$blacklist_email_subject ="$cf_site_title - Black List activation link";
$blacklist_error_message_gocheck_email ="Please check your email <strong>$add_black_email</strong>. An email with subject <strong>$blacklist_email_subject</strong> has been sent to you.<br /><br />In order to <strong>ADD</strong> your email to our Black List you must click the activation link which comes with email.";
$blacklist_message_remove_ok="Email: <strong>$remove_black_email$email</strong> has been removed from the Black List.<br /><br />In the future someone can send eCards, Birthday Alerts, Tell- a- Friends, and welcome emails to this email address.";
$blacklist_error_message_remove_email_notonList ="Your Email <strong>$email</strong> is not on our Black List or the activation code is incorrect.<br /><br />This means someone can now send eCards, Birthday Alerts, Tell-a-Friends, and welcome emails to this email address.";
$blacklist_message_add_ok="Your email: <strong>$email</strong> has been added to our Black List.<br /><br />In the future you won't receive any eCards, Birthday Alerts, Tell-a-Friends, or welcome emails that are sent from our Web site.";

$blacklist_email_message=<<<EOF
Hello!
<br /><br />
Please click the link below in order to add your email $add_black_email to our Black List
<br /><br />
<a href="%show_link%">%show_link%</a>
<br /><br />
Thank you
EOF;
$blacklist_email_remove_fromlist_subject="Instructions on how to remove your email from the Black List"; 
$blacklist_error_message_remove_gocheck_email="Please check your email <strong>$remove_blak_list</strong>. An email with subject <strong>$blacklist_email_remove_fromlist_subject</strong> has been sent to you.<br /><br />In order to <strong>REMOVE</strong> your email from our Black List you must click the action link which comes with email.";
$blacklist_email_remove_fromlist_message=<<<EOF
Hello!
<br /><br />
Your email address is currently on $cf_site_title's Black List.
<br /><br />
This means that $cf_site_title, your friends, and your family members may not send eCards, Birthday Reminders, Tell-a-Friends, or welcome emails to you from our web site.
<br /><br />
If you wish to be removed from the Black List so that you can start receiving eCards and other emails again, then click on the link below:
<br /><br />
<a href="%show_link%">%show_link%</a>
<br /><br />
Thank you.

EOF;
 
$Sun ="Sun";
$Mon = "Mon";
$Tue = "Tue";
$Wed = "Wed";
$Thu = "Thu";
$Fri = "Fri";
$Sat = "Sat";
$Sunday ="Sunday";
$Monday = "Monday";
$Tuesday = "Tuesday";
$Wednesday = "Wednesday";
$Thursday = "Thursday";
$Friday = "Friday";
$Saturday = "Saturday";
$Jan ="January";
$Feb ="February";
$Mar ="March";
$Apr ="April";
$May ="May";
$Jun ="June";
$Jul ="July";
$Aug ="August";
$Sep ="September";
$Oct ="October";
$Nov ="November";
$Dec ="December";
$Month ="Month";
$Day ="Day";
$Year ="Year";
$My_age_is_secret ="My age is secret.";
$Table_Title_Upcoming_Holidays_Events = "Upcoming Holidays/Events";
$pickup_your_ecard="Pick up your eCard";
$pickup_your_ecard_invite="Pick up your invitation card";
$enter_card_id_number="Enter your card ID number";
$quotes_of_the_day="Quotes of the day";
$random_ecard_title="Random eCards";
$feature_ecard_title="Featured eCards";
$popular_ecard_title="Popular eCards";
$toprated_ecard_title="Top Rated eCards";
$newest_ecard_title="Newest eCards";
$thumb_tool_preview_fullsize="Preview fullsize card";
$thumb_tool_visit_category="Go to category name %show_cat_name%";
$thumb_tool_free_card="Card is Free, Guests are welcome to send it";
$thumb_tool_member_card="Card is for higher member group only";
$thumb_tool_member_card_ok_to_send="You can send this card";
$thumb_tool_date_add_card="Not a new card. Card added on date %show_date%";
$thumb_tool_new_card="New card - Card added on date %show_date%";
$thumb_tooltip_click_to_close="Click here to close";

$cardinfo_date_added="Card added on date";
$cardinfo_category_name="Category name";
$cardinfo_caption="Card Caption (Title)";
$cardinfo_detail="Card Detail";
$cardinfo_keyword="Search this card with keyword";
$cardinfo_group_permission="Member Group Permission";
$cardinfo_rated="Rated";
$cardinfo_time_sent="Time sent";

$txt_Sortby ="Sort by";
$cap_sortby_date_desc ="Newest on top.";
$cap_sortby_date_asc ="Oldest on top.";
$cap_sortby_popular_desc ="Most popular on top.";
$cap_sortby_popular_asc ="Least popular on top.";
$cap_sortby_rate_desc ="Top-rated on top.";
$cap_sortby_rate_asc ="Lowest-rated on top.";
$cap_sortby_default="Sort by Default";
$cap_sortby_card_i_can_send="List cards I can send now only";
$button_use_sortby_default="To see more cards use sort by Default";

$side_nav_account_tools="Account Tools";
$side_nav_title_newsletter="Newsletter";
$side_nav_newsletter_subscribe ="Subscribe to our newsletter";
$side_nav_newsletter_unsubscribe ="Unsubscribe from newsletter";
$label_yourname="Your Name";
$label_youremail="Your Email";
$button_subscribe="Subscribe";
$button_unsubscribe="Unsubscribe";
$side_nav_title_voice_recorder="Voice Recorder";
$side_nav_voice_recorder_message="<a href=\"Ecard.exe\">Download </a><br /><a href=\"Ecard.exe\">Voice Recorder</a> to send ecard with your voice in it";
$side_nav_title_download_player="Download Players";
$side_nav_download_flash_message="<a href=\"http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash&promoid=BIOW\" target=\"_blank\">Download Flash player</a> to view our Flash cards";
$side_nav_download_java_message="<a href=\"http://java.com/en/download/index.jsp\" target=\"_blank\">Download Java</a> to view Java ecards";
$side_nav_download_winmedia_message="<a href=\"http://www.microsoft.com/windows/windowsmedia/download/AllDownloads.aspx\" target=\"_blank\">Download Window Media player</a> to listen .wma audio files";
$side_nav_download_real_message="<a href=\"http://www.real.com\" target=\"_blank\">Download Real player</a> to listen real audio .rm files";
$side_nav_title_legend="Legend";

$show_join_now_title="Become a Member";
$show_join_now_txt_re_enter_password="Re-enter password";
$show_join_now_txt_image_verify="Verify image code";
$show_join_now_alert_must_enter_first_name="You must enter your first name";
$show_join_now_alert_must_enter_last_name="You must enter your last name";
$show_join_now_alert_must_enter_valid_email="You must enter a valid email address";
$show_join_now_alert_must_enter_user_name_id="You must enter Username";
$show_join_now_alert_must_enter_password="You must enter your password";
$show_join_now_alert_must_re_enter_password="Please re-enter your password";
$show_join_now_alert_must_enter_image_code="You must enter image code";
$show_join_now_alert_must_enter_correct_image_code="You must enter correct image code";
$update_your_account_title="Update your account";
$update_your_account_join_group_name="Join Member Group Name:";

$sign_in_existing_members ="Existing members please sign in.";
$sign_in_enter_user_name_password="Username or Email address";
$sign_in_enter_password="Password";
$sign_in_resend_password="Re-send lost password";
$sign_in_button_send_password="Send password";
$sign_in_become_member_you_can="Free Basic membership benefits:";
$sign_in_become_member_send_free_ecard="Send exclusive ecards in this group. See sample below";
$sign_in_error_msg_wrong_user_pass ="Username and password do not match";
$sign_in_error_msg_account_not_active="Your account is inactive. Please check your email to see the active URL.";
$sign_in_error_msg_account_suspend ="Your account has been suspended";
$sign_in_lost_pass_error_msg ="We apologize, but no user was found matching the information your provided";
$sign_in_lost_pass_ok_msg="Your password has been sent. Please check email %show_email% for your password";
$sign_in_error_msg_lost_pass_no_user_found ="There are no accounts in our system with the E-mail address (or Username) $user_name_id which you entered";
$sign_in_remember_me_learn_more ="Remember me on this computer. <span style=\"cursor:pointer;text-decoration:underline;font-weight:bold;\">Learn more</span>";
$remember_me_learn_more_html_msg=<<<EOF
For security purposes, after a period of inactivity or if you close your browser, your session with <strong>$cf_site_title</strong> will expire and you'll need to sign in again.
<br /><br /><strong>Have $cf_site_title keep you signed in</strong>
<br /><br />For your convenience, you can choose to save your password on this computer. Your password will be saved until you sign out, even if you disconnect from the Internet, close your browser, or turn off your computer.
<br /><br /><strong>NOTE:</strong> As a safety measure, if you're using a public or shared computer, always click SIGN OUT in the upper right corner of the screen when you're finished using <strong>$cf_site_title</strong>.
EOF;

$lost_password_email_subject="$cf_site_title - Your Username and Password information";
$lost_password_email_message=<<<EOF
Hello!
<br /><br />
Thank you for using our service. Here is your Username and password:
<br /><br />
Username: %show_user_name_id%
<br />
Password: %show_password%
<br /><br />
Use the link below to login
<br /><br />
<a href="$ecard_url/index.php?step=sign_in">$ecard_url/index.php?step=sign_in</a>

EOF;

$sign_up_email_subject_welcome ="$cf_site_title - Your account is now active";
$sign_up_email_message_welcome=<<<EOF
Hello $user_first_name $user_last_name,
<br /><br />
Thank you for becoming a member.
<br /><br />
Your account is now active, and you have immediate access to all of the exclusive features available only to our members, such as Birthday Alert, Address Book, Calendar, Reminders, Member Album, and Card History.
<br /><br />
Please sign in with your account information below.
<br /><br />
Visit our Web site at: <a href="$ecard_url">$ecard_url</a>
<br /><br />
User ID: $user_name_id
<br />
User Email: $user_email
<br />
Password: $user_password
<br /><br />
We look forward to helping you send more smiles to your family, friends, and loved ones via great eCards in the months and years ahead.
<br /><br />
$cf_site_title Staff

EOF;

$js_alert_edit_field_not_blank="This field cannot be left blank\\n\\nYour changes have not been saved.";
$js_alert_edit_field_not_a_number="You must enter a number.\\n\\nYour changes have not been saved.";
$js_alert_edit_field_invalid_email="Invalid email address\\n\\nYour changes have not been saved.";
$js_alert_must_select_checkbox="You must select checkbox first. Please try again.";
$ajax_text_loading="Loading...";
$ajax_text_updating="Updating...";
$ajax_text_verify="Verifying...please wait";
$ajax_text_sending_email="Sending email...";

//Member tool My Account 
$myaccount_account_verification_email_subject="eCardMax User Registration Confirmation";
$myaccount_account_verification_email=<<<EOF
You have requested a new user account on %SITE_TITLE% and you have specified this address (%USER_EMAIL%) as user contact.
<br /><br />
If you did not do this, please ignore this email. The person who entered your email address had the IP address %USER_IP%. Please do not reply.
<br /><br />
To confirm your user registration, you have to follow this link:
<br /><br />
%ACCOUNT_VERIFICATION_URL%
<br /><br />
After you do this, you will be able to use your new account. If you fail to do this, you account will be deleted within a few days.
EOF;
$myaccount_account_verification_email_message="Thank you for joining with us! Please check your email %USER_EMAIL% to verify your account";
$myaccount_sms_cellphone_reminder="SMS - Send Reminder to Cell phone";
$myaccount_sms_cellphone_number="Mobile number";
$myaccount_sms_cellphone_carrier="Select carrier";
$myaccount_sms_send_test_message_button="Send Test Message";
$myaccount_sms_reminder_active="Agree to receive SMS";
$myaccount_financial_information="Financial Information";
$myaccount_account_balance="Account Balance (use for pay per card)";
$myaccount_purchase_history="View purchase history";
$myaccount_purchase_history_date="Date";
$myaccount_purchase_history_order_number="Order number";
$myaccount_purchase_history_amount="Amount";
$myaccount_purchase_history_order_type="Type";
$myaccount_purchase_history_pay_method="Method";
$myaccount_purchase_history_order_type_ppc="PayPerCard";
$myaccount_purchase_history_order_type_upgrade_acct="Upgrade Acct";
$myaccount_ppc_message_enough_money="Your account balance %show_user_balance% has enough money to pay for this card (%show_card_amount%)<br />Click Continue next step button to continue";
$myaccount_ppc_message_upgrade_account="Your account cannot send ecards. Please upgrade your account to send.";
$myaccount_ppc_message_not_enough_money="Your account balance %show_user_balance% doesn't have enough money to pay for this card (%show_card_amount%)";
$myaccount_sms_send_test_message_subject="SMS Test Message";
$myaccount_sms_send_test_message_body="This is a SMS Test Message. Your carrier name is %show_carrier_name%";
$myaccount_permission="Account Permission";
$myaccount_max_recipient="Maximum Recipient (when send ecard)";
$myaccount_max_recipient_per_hour="Maximum Recipient per hour";
$myaccount_max_recipient_per_day="Maximum Recipient per day";
$myaccount_show_watermark="Show image watermark";
$myaccount_show_banner="Show banner ads";
$myaccount_allow_game="Play Games";
$myaccount_allow_grabber="Use Media Grabber";
$myaccount_allow_search="Search Ecard/Invitation card";
$myaccount_allow_futuredate="Allow user send card chosen date";
$myaccount_allow_rate="Allow user to rate ecard";
$myaccount_allow_viewfullsize="Allow feature Preview Fullsize eCard";
$myaccount_allow_myaccount="My Account";
$myaccount_allow_addressbook="Addressbook";
$myaccount_allow_reminder="Reminder";
$myaccount_allow_calendar="Calendar";
$myaccount_allow_myalbum="My Album";
$myaccount_allow_favorite="Favorite";
$myaccount_allow_history="Card History";
$myaccount_allow_birthdayalert="Birthday Alert";
$myaccount_allow_2subaccount="Create free 2 sub accounts";
$myaccount_payment_amount="Membership payment amount";
$myaccount_button_upgrade_account="Upgrade Your Account";
$myaccount_enter_payment_order_number="Enter your payment order number";
$myaccount_txt_link_to_payment="If you don't have your order number, <a href=\"$ecard_url/index.php?step=update_your_account\">click here</a> to buy now.";
$myaccount_txt_unlimited="Unlimited";
$myaccount_txt_yes="<span class=\"OK_Message\">YES</span>";
$myaccount_txt_no="<span class=\"Error_Message\">NO</span>";
$myaccount_sub_alert_must_enter_first_name="You must enter subaccount user first name";
$myaccount_sub_alert_must_enter_last_name="You must enter subaccount user last name";
$myaccount_sub_alert_must_enter_email="You must enter subaccount user email";
$myaccount_sub_alert_must_enter_user_name_id="You must enter subaccount Username";
$myaccount_sub_alert_must_enter_order_number="You must enter your payment order number";
$myaccount_show_info_order_number_invalid="Can't upgrade your account. The order number you entered is incorrect or it has been used.";

$myaccount_h1="My Account";
$myaccount_information_title="My Account Information";
$myaccount_user_first_name="First name";
$myaccount_user_last_name="Last name";
$myaccount_user_email="Email address";
$myaccount_user_name_id="Username";
$myaccount_user_password="Password";
$myaccount_change_password="Change password";
$myaccount_account_statistics_title="Account Statistics";
$myaccount_user_signup_date="Signup Date";
$myaccount_user_last_login="Last Login";
$myaccount_user_time_used="Account time login";
$myaccount_user_card_sent="Total Cards Sent";
$myaccount_optional_title="Optional";
$myaccount_user_birthday="Birthday";
$myaccount_user_language="Primary Language";
$myaccount_user_dst="Summer Time/DST is in effect";
$myaccount_user_dst_no="No";
$myaccount_user_dst_yes="Yes";
$myaccount_user_select_timezone="Select time zone";
$myaccount_user_address="Address";
$myaccount_user_city="City";
$myaccount_user_state="State";
$myaccount_user_zipcode="Zip Code";
$myaccount_user_country="Country";
$myaccount_user_phone_number="Phone number";
$myaccount_user_gender="Gender";
$myaccount_user_gender_male="Male";
$myaccount_user_gender_female="Female";
$myaccount_user_marital_status="Marital Status";
$myaccount_user_marital_status_single="Single";
$myaccount_user_marital_status_married="Married";
$myaccount_user_marital_status_divorced="Divorced";
$myaccount_user_marital_status_widowed="Widowed";
$myaccount_cancel_account_title="Cancel Account";
$myaccount_user_account_group_name="Account member group name";
$myaccount_user_payment_order_number="Payment order number";
$myaccount_user_payment_amount="Payment amount";
$myaccount_user_paid_by="Paid by (2Checkout or Paypal)";
$myaccount_delete_account="Delete Account";
$myaccount_cancel_membership="Cancel Membership";
$myaccount_email_newsletter_title="Email Newsletter";
$myaccount_user_receive_newsletter="I'd like to receive email newsletters";
$myaccount_user_receive_offer="I'd like to receive email special offers";
$myaccount_user_edit_email_error_msg_invalid="Your changes have not been saved. The new email address is invalid format";
$myaccount_user_edit_email_error_msg_taken="Your changes have not been saved. The new email address has been used with other account";
$myaccount_user_current_password="Enter current password";
$myaccount_user_new_password="Enter new password";
$myaccount_user_new_password2="Re-Enter password";
$myaccount_user_button_change_password="Change now";
$myaccount_user_new_pass_error1="Current password doesn't match";
$myaccount_user_new_pass_error2="You must enter new password";
$myaccount_user_new_pass_error3="New password do not match";
$myaccount_user_new_pass_updated="New password has been updated";
$myaccount_alert_delete_account="Are you sure you want to delete your account?";
$myaccount_alert_request_cancel_sent="Your request to cancel your membership has been sent to Admin. Your account will be down grade to Free Basic Account after the expiration date. <a href=\"$ecard_url/index.php?step=sign_in&next_step=show_myaccount&action=undo_delete\">Click here</a> if you change your mind and decide continue using this account.";
$myaccount_alert_will_be_closed ="Admin has scheduled to end this account on date: %show_date%. After %show_date% your account will be deleted, including your address book, reminder, album and birthday alert";  
$myaccount_alert_will_be_downgrade ="Admin has scheduled to down grade this account to Free basic account on date: %show_date%.";  
$myaccount_show_info_user_email_invalid="Your user email is invalid";
$myaccount_show_info_user_email_taken="Your User email is already used with another account";
$myaccount_show_info_user_name_id_too_short="Your Username is invalid. It's too short (must be at least 6 characters)";
$myaccount_show_info_user_name_id_no_number_first_letter="Your Username is invalid. Do not use number for the first letter";
$myaccount_show_info_user_name_id_no_special_character="Your Username is invalid. Do not include white space or special character";
$myaccount_show_info_user_name_id_taken="Your Username was taken";
$myaccount_show_info_user_has_been_banned="User email has been banned due to some security problem.";
$myaccount_free_sub_information="Your Free Sub Account Information";
$myaccount_button_create_free_sub="Create Free Sub Account";
$myaccount_alert_sure_to_delete_sub_account="Are you sure you want to delete this sub account?";
$myaccount_button_delete_free_sub="Delete Sub Account";
$myaccount_freesub_email_subject="%sender_name% gave you a free ecard membership";
$myaccount_freesub_email_message=<<<EOF
Hello!
<br /><br />
Your friend %sender_name% gave you a free ecard membership. Below is your account information
<br /><br />
Username: %show_user_name_id%
<br />
Password: %show_password%
<br /><br />
Follow this link to login and feel free to change your password
<br /><br />
<a href="$ecard_url/index.php?step=sign_in&next_step=show_myaccount">$ecard_url/index.php?step=sign_in&next_step=show_myaccount</a>
<br /><br />
Thank you for using $cf_site_name ecard service.

EOF;
$myaccount_twitter_screen_name_to_send="You are using twitter <b>%twitter_screen_name%</b> to send ecards. Remove oAuth token and oAuth secret to switch to another twitter.";
$myaccount_twitter_connection_title="Twitter connection";
$myaccount_oAuth_token_title="oAuth token";
$myaccount_oAuth_secret_title="oAuth secret";

$addressbook_group_default_name="GROUP DEFAULT";
$addressbook_contact_group_title="Contact Groups";
$addressbook_button_view_contact="View Contact Detail";
$addressbook_button_add_new_group="Click here to add new group";
$addressbook_button_add_contact="Add contact";
$addressbook_txt_create_new_group_title="Create new contact group";
$addressbook_txt_group_title="Group title";
$addressbook_txt_group_number_email="Email";
$addressbook_txt_group_number_autobirthday="Auto Birthday";
$addressbook_txt_group_view_contact="View";
$addressbook_txt_group_add_contact="Add";
$addressbook_txt_group_delete_contact="Delete";
$addressbook_txt_quick_add="Quick add contact to this group<br />Enter contact line by line<br />(Use CSV format - see sample)";
$addressbook_txt_add_contact_to_group="Add contacts to group title:";
$addressbook_quick_sample="<strong>Email,FirstName,LastName</strong>,NickName,PhoneNumber<br />(Email,FirstName,LastName are required)";
$addressbook_button_submit_add_group="Create new group";
$addressbook_js_alert_must_enter_group_title="You must enter Group title";
$addressbook_js_alert_must_enter_contact_list="You must enter contact list";
$addressbook_js_alert_sure_to_delete_group="Are you sure you want to delete your selected contact group?\\n\\nAll contacts in this group will be moved to $addressbook_group_default_name";
$addressbook_tooltip_view_contact_detail="View contact detail in this group";
$addressbook_tooltip_add_contact_to_group="Add contacts to this group";
$addressbook_show_info_new_group_has_been_added="New Contact Group has been added";

$addressbook_big_title="Address Book";
$addressbook_button_search_filter="Search &amp; Filter";
$addressbook_button_display_all_contact="Display All Contacts";
$addressbook_button_create_edit_contact_group="Create/Edit Contact Group";
$addressbook_button_submit_add_new="Add new contact";
$addressbook_txt_filter_by="Filter by";
$addressbook_txt_click_add_new_contact="Click here to add new contact";
$addressbook_txt_fill_out_form="Fill out the form below to add new contact to your address book";
$addressbook_txt_first_name="First name";
$addressbook_txt_last_name="Last name";
$addressbook_txt_email="Email address";
$addressbook_txt_add_contact_to_group_name="Add contact to group name";
$addressbook_txt_optional="Optional";
$addressbook_txt_nick_name="Nick name";
$addressbook_txt_phone_number="Phone number";
$addressbook_txt_address1="Address 1";
$addressbook_txt_address2="Address 2";
$addressbook_txt_city="City";
$addressbook_txt_state="State";
$addressbook_txt_zipcode="Zipcode";
$addressbook_txt_country="Country";
$addressbook_txt_reminder_dates="Dates Reminder";
$addressbook_txt_reminder_birthday="Birthday";
$addressbook_txt_reminder_anni="Anniversary";
$addressbook_txt_reminder_birthday_tooltip="Set birthday reminder for this contact";
$addressbook_txt_reminder_anni_tooltip="Set anniversary reminder for this contact";
$addressbook_txt_reminder_me="Reminder me";
$addressbook_txt_reminder_me_on_date="On event date";
$addressbook_txt_reminder_me_1day_b4="1 day before";
$addressbook_txt_reminder_me_2day_b4="2 days before";
$addressbook_txt_reminder_me_3day_b4="3 days before";
$addressbook_txt_reminder_me_7day_b4="7 days before";
$addressbook_txt_reminder_me_14day_b4="14 days before";
$addressbook_txt_reminder_me_30day_b4="30 days before";
$addressbook_table_contact_detail="Contact Detail";
$addressbook_table_contact_group="Contact Group";
$addressbook_table_icon_tooltip_view_edit_contact="View/Edit contact";
$addressbook_table_icon_tooltip_delete="Delete this contact";
$addressbook_search_filter_search_in="Search in";
$addressbook_search_filter_search_in_all_fields="All fields";
$addressbook_js_alert_must_enter_first_name="You must enter contact first name";
$addressbook_js_alert_must_enter_last_name="You must enter contact last name";
$addressbook_js_alert_must_enter_valid_email="You must enter a valid email address";
$addressbook_js_alert_must_select_group="You must select at least one contact group";
$addressbook_js_alert_sure_to_delete_contact="Are you sure you want to delete this contact?";
$addressbook_show_info_new_contact_has_been_added="New Contact has been added";
$addressbook_show_info_your_book_updated="Your Address Book has been updated";
$addressbook_show_info_view_all_in_group_default="View all contacts in group name $addressbook_group_default_name";
$addressbook_show_info_view_all_in_group="View all contacts in group";
$addressbook_show_info_filter_by="Filter by %show_name% start with key %show_key%";
$addressbook_show_info_email_already_added="Error. Email already added to your addressbook";
$addressbook_show_info_search_with_keyword="Search address book with keyword";
$addressbook_icon_tooltip_list_all_contact_this_group="List all contacts in this group";

$reminder_big_title="Event Reminder";
$reminder_button_view_all_reminder="View all reminders";
$reminder_button_view_my_calendar="View My Calendar";
$reminder_button_create_new_event="Create new event";
$reminder_txt_click_add_new_reminder="Click here to add new event reminder";
$reminder_txt_enter_event_detail="Enter details of an event you would like to add to the Calendar";
$reminder_txt_will_sent_to="Reminder will be sent to";
$reminder_txt_event_date="Event Date";
$reminder_txt_event_name="Event Name";
$reminder_txt_event_detail="Event Detail";
$reminder_txt_event_delete="Delete";
$reminder_txt_repeat="Repeat";
$reminder_txt_no_repeat="No repeat";
$reminder_txt_repeat_week="Repeat every week";
$reminder_txt_repeat_month="Repeat every month";
$reminder_txt_repeat_year="Repeat every year";
$reminder_js_alert_must_select_event_date="You must select event date";
$reminder_js_alert_event_not_today="Event date can't be today";
$reminder_js_alert_event_not_today_no_save="Event date can't be today.\\n\\nYour changes have not been saved.";
$reminder_js_alert_must_enter_event_name="You must enter event name";
$reminder_js_alert_sure_to_delete_reminder="Are you sure you want to delete selected reminder(s)?";
$reminder_show_info_new_event_has_been_added="New event has been added";
$reminder_show_info_your_event_updated="Your event list has been updated";
$reminder_tooltip_click_to_edit_event_date="Click to edit event date";

$calendar_txt_local_time_is ="Use <a href=\"$ecard_url/index.php?step=sign_in&next_step=show_myaccount\">My Account</a> to change your GMT timezone. Your local time is now";

$feedback_select_department ="Select Department";
$feedback_subject="Subject";
$feedback_message="Message";
$feedback_js_alert_must_enter_name="You must enter your name";
$feedback_js_alert_must_enter_subject="You must enter your subject";
$feedback_js_alert_must_enter_message="You must enter your message";
$feedback_show_info_message_has_been_sent="Thank you for your feedback. Your message has been sent";
$feedback_button_send="Send";

$newsletter_js_alert_sure_to_remove_email="Are you sure you want to remove your email from our list?";
$newsletter_show_info_email_has_been_added="Your email has been added to our newsletter list.";
$newsletter_show_info_email_has_been_deleted="Your email has been removed from our newsletter list.";
$newsletter_show_info_email_not_found="Sorry Your email not found on our list.";

$sendcard_txt_from="From";
$sendcard_txt_to="To"; 
$sendcard_txt_date_created="Date Card Created";
$sendcard_txt_download_java="Don't see anything? <a href=\"http://java.com/en/download/index.jsp\" target=\"_blank\">Click here</a> to download Java software!";
$sendcard_txt_download_flash="Don't see anything? <a href=\"http://www.adobe.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash\" target=\"_blank\">Click here</a> to download Flash!";
$sendcard_demo_mess="Your message goes here.";

//For tell-a-friend & birthday alert & personalize ecards
$fieldset_title_sender_information="Sender Information";
$fieldset_sender_name="Sender Name";
$fieldset_sender_email="Sender Email";
$fieldset_title_recipient_information="Recipient Information";
$fieldset_recipient_name="Recipient Name";
$fieldset_recipient_email="Recipient Email";
$fieldset_number_recipient="Number of Recipients";
$fieldset_maximum_number_10="(Maximum is <strong>10</strong>)";
$fieldset_maximum_is="Maximum is ";
$fieldset_title_your_personal_message="Your Personal Message";
$button_send_to_friends="Send";
$txt_js_alert_must_enter_number="You must enter a number";
$txt_js_alert_maximum_number_is10="Maximun number of recipient is 10";
$txt_js_alert_must_enter_sender_name="You must enter sender name";
$txt_js_alert_must_enter_sender_email="You must enter a valid sender email address";
$txt_js_alert_missing_recipient="Missing recipient name or recipient email. Please check your input";
$txt_js_alert_must_enter_recipient_info="You must enter recipient information";
$txt_js_alert_must_enter_valid_email="You must enter a valid email address";
$txt_show_info_thankyou_message="Thank you for telling your friends about this website. Your message has been sent.";
$tellfriend_email_subject ="$sender_name sent you a message";
$tellfriend_email_message=<<<EOF
Your friend wants to share this with you
<br /><br />
Hello !
<br /><br />
Your friend $sender_name, whose email address is $sender_email stopped by our site and wants to share it with you. You may click this link <a href="$ecard_url">$ecard_url</a> to visit us when you have some free time.
<br /><br />
$sender_name wrote the following message for you:
<br /><br />
-----------------------------------------------------------------------
<br /><br />
%show_message%
<br /><br />
-----------------------------------------------------------------------
<br /><br />
Thanks for reading this message. We hope that you will visit us soon and, perhaps, tell one of your friends about our site <a href="$ecard_url">$ecard_url</a>
<br /><br />
$cf_site_title Staff
EOF;

$birthday_alert_dob_title="Birthday Alert Information";
$birthday_alert_dob_message="%sender_name% wants to be reminded of your birthday each year by email. Please enter your name and date of birth below (note: your changes will be saved right away):";
$txt_birthday_alert_info="<strong>Set birthday alerts</strong> by asking each of your friends to enter their birthday. Their birthday information will be saved to your Address Book and you will receive an email reminder when your friend's birthday is near.";
$txt_birthday_alert_show_info_thankyou_message="Thank you. Your message has been sent.";
$txt_birthday_alert_email_subject ="$_SESSION[user_name] $_SESSION[user_last_name] needs your help.";
$txt_birthday_alert_email_message=<<<EOF
Dear Friend,
<br /><br />
This is $_SESSION[user_name] $_SESSION[user_last_name]
<br /><br />
I am currently creating a list of everyone's birthday so I can be reminded when it comes. I would like to add your birthday to my list, so please click on the link below and enter your birthday for me. 
<br /><br />
<a href="%SHOW_LINK%">%SHOW_LINK%</a>
<br /><br />
Thanks, 
<br />
$_SESSION[user_name] $_SESSION[user_last_name] (<a href="mailto:{$_SESSION[user_email]}">{$_SESSION[user_email]}</a>)

EOF;

$fieldset_acct_balance_after_send_ppc_card="Your new account balance after you sent this card";
$txt_current_acct_balance="Current account balance:";
$txt_ppc_amount="Pay per card amount:";
$txt_new_acct_balance="New account balance:";
$txt_title_personalize_your_card="Personalize Your Card.";
$fieldset_preview_thumb_card="Preview card thumbnail";
$fieldset_delivery_date="Delivery Date:";
$txt_send_me_copy_this_card="Please send me a copy of this card.";
$txt_notify_me_when_recipient_view_card="Please notify me when the recipient views card.";
$send_notify_pickup_email_subject ="$cs_from_name sent you an ecard from $cf_site_title";
$send_thank_you_message_email_subject ="Thank You Message";
$send_notify_pickup_email_message=<<<EOF
Hi %show_friend_name%!
<br /><br />
$cs_from_name sent you an eCard
<br /><br />
Click the link below to view:
<br /><br />
<a href="$ecard_url/index.php?step=pickup&cs_id=%show_id%">$ecard_url/index.php?step=pickup&cs_id=%show_id%</a>
<br /><br />
or go pick up the card at this Web site url address:
<br /><br />
<a href="$ecard_url/index.php?step=pickup">$ecard_url/index.php?step=pickup</a>
<br /><br />
and enter this Card ID number:  %show_id%
<br /><br />
Your card will be available for pick-up during the next $cf_card_expire_day days.
<br /><br />
Send your own $cf_site_title greeting cards by visiting:
<br /><br />
<a href="$ecard_url">$ecard_url</a>
<br /><br />
$cf_site_title staff

EOF;

$reminder_email_subject ="$cf_site_title Reminder: %show_reminder_title%";
$reminder_email_message=<<<EOF
You entered the following notes for this reminder:
<br /><br />
%show_reminder_title%
<br /><br />
%show_reminder_content%
<br /><br />
Event Date:
<br /><br />
%show_event_date%
<br /><br />
To set additional reminders, to send birthday alerts to your friends so you don't forget their birthdays, or to send eCards, please visit:
<br /><br />
<a href="$ecard_url">$ecard_url</a>
<br /><br />
Thanks for using our service.
<br />
$cf_site_title (<a href="mailto:$cf_site_from_email">$cf_site_from_email</a>)

EOF;
$text_auto_send_birthday_mess_to_member="Happy Birthday to You. Wishes you have a wonderful day.";

$show_card_body_more_card="More cards";
$show_card_body_goto_category_name="Go to category name";
$show_card_body_goto_popular="Go to category Popular cards";
$show_card_body_goto_toprated="Go to category Top-Rated cards";
$show_card_body_goto_newest="Go to category Newest cards";
$show_card_body_goto_homepage="Go to Home page";
$sendcard_didnot_send_because_email_blacklist="did not send because email is on black list";
$sendcard_thankyou_page_title="Confirmation";
$sendcard_thankyou_card_has_been_sent="Thank you for using our service. Your card has been sent.";
$sendcard_auto_birthday_settings_saved="Thank you for using our service. Your settings has been saved.";
$sendcard_thankyou_card_will_be_sent="Thank you for using our service. Your card will be sent on";
$sendcard_txt_card_has_been_send_to="Your card sent to:";
$sendcard_php_no_java_applet="No java applet";
$sendcard_php_button_select_image_effect="Effect";
$sendcard_php_button_select_skin_background="Select Skin";
$sendcard_php_button_select_stamp="Stamp";
$sendcard_php_button_select_music="Music";
$sendcard_php_no_music="No Music";
$sendcard_php_my_upload="My Upload";
$sendcard_php_button_select_poem="Poem";
$sendcard_php_no_poem="No Poem";
$sendcard_php_txt_align="Align:";
$sendcard_php_txt_align_left="Left";
$sendcard_php_txt_align_center="Center";
$sendcard_php_txt_align_right="Right";
$sendcard_php_txt_author="Author";
$sendcard_php_button_rate_this_card="Rate";
$sendcard_php_button_print_this_card="Print";
$sendcard_php_txt_rate_this_card_info="Click the stars to give your rating for this eCard. Your personal ratings will be yellow.";
$sendcard_php_button_card_info="Card info";
$sendcard_php_button_edit="Edit";
$sendcard_php_button_send_now="Send Now";
$sendcard_php_button_add_to_fav="Add to favorites";
$sendcard_php_button_remove_from_fav="Remove from favorites";
$sendcard_php_button_continue_next_step="Personalize and Send";
$sendcard_php_button_join_now_to_send="Join Now To Send Card";
$sendcard_php_button_update_account_to_send="Update Your Account To Send This Card";
$sendcard_php_txt_save_recipient_to_addressbook="Auto save recipient name and email to my address book.";
$sendcard_php_txt_yes_join_newsletter="Yes! I'd like to receive email newsletters from your site.";
$sendcard_php_txt_yes_join_offers="Yes! I'd like to receive emails about special offers from your site and your partner's sites.";
$sendcard_php_txt_login_to_use_addressbook="<a href=\"$ecard_url/index.php?step=sign_in\">Please login</a> to use your addressbook";
$sendcard_php_txt_update_account_to_use_addressbook="<a href=\"$ecard_url/index.php?step=update_your_account\">Please update</a> your account to use addressbook";
$sendcard_php_txt_number_of_email="Number of email:";
$show_personalize_table_tooltip_default_size="Default size";
$show_personalize_table_tooltip_increase_size="Increase size";
$show_personalize_table_tooltip_decrease_size="Decrease size";
$show_personalize_table_button_preview_card="Preview Card";
$show_personalize_table_txt_pick_a_date="Pick a date";
$show_personalize_table_txt_send_card_today="Send card today";
$show_card_has_been_sent_button_send_to_someone_else="Send this card to someone else";
$show_card_has_been_sent_button_send_another_ecard="Send another card";

$pickup_button_print_this_card="Print this card";
$pickup_button_send_ecard="Send eCard";
$pickup_button_reply_to_this_card="Reply to this card";
$pickup_card_error_cardid_not_found="There was an error in retrieving your card.<br /><br />Either the card has expired or you have entered a wrong Card ID Number OR Url.<br /><br />Please check your Pick Up Notification email for the correct URL and try again.";
$send_notify_user_has_viewed_card_email_subject ="%show_name% has picked up your card"; 
$send_notify_user_has_viewed_card=<<<EOF
Hi %show_name%,
<br /><br />
The card you sent to %show_fname% has just been picked up.
<br /><br />
Click the link below to view a copy of the card you sent
<br /><br />
<a href="$ecard_url/index.php?step=pickup&cs_id=%show_id%&action=viewcopy">$ecard_url/index.php?step=pickup&cs_id=%show_id%&action=viewcopy</a>
<br /><br />
or go pick up the card at this Web site url address:
<br /><br />
<a href="$ecard_url/index.php?step=pickup&action=viewcopy">$ecard_url/index.php?step=pickup&action=viewcopy</a>
<br /><br />
and enter in this Card ID number:  %show_id%
<br /><br />
Thank you for using $cf_site_title greetings!
<br /><br />
Send more $cf_site_title cards by visiting:
<br /><br />
<a href="$ecard_url">$ecard_url</a>
EOF;

$txt_send_card_over_limit="Over limit";
$txt_send_card_over_limit_message="Anti Spam is activated.<br /><br />You're seeing this message because our system allows all users in this group can send maximum <span class=\"Error_Message\">$_SESSION[mg_number_recipient_per_hour]</span> email per hour and maximum <span class=\"Error_Message\">$_SESSION[mg_number_recipient_per_day]</span> email per day. Please try to send card again in the next hour.";

$history_txt_tooltip_view_card="View Card";
$history_txt_tooltip_delete_card="Delete Card";
$history_txt_tooltip_resend_card="Re-Send Card";
$history_js_alert_sure_to_delete_card="Are you sure you want to delete this card?";
$history_txt_title_scheduled_cards="CARDS SCHEDULED";
$history_txt_header_card="CARD";
$history_txt_card_sent="CARDS SENT";
$history_txt_header_send_to="SEND TO";
$history_txt_header_scheduled_date="SCHEDULED DATE";
$history_txt_header_date_sent="DATE SENT";
$history_txt_header_date_pickup="DATE PICKUP";

$myalbum_info_photo="Use your photos and images to create ECards to share with your family and friends! Upload your photos/images and create your ECards here";
$myalbum_button_goto_photo="My Photos";
$myalbum_info_music="Add your own voice message or favorite song (with permission) to your ECards! Record a voice greeting or upload your music/voice files here. Then when you select and customize your ECards, just click on &quot;<b>Select Music</b>&quot; and choose the music file that you would like to send with your card.";
$myalbum_button_goto_music="My Music";
$myalbum_info_poem="Compose your own poems to send with your ECards! Enter them here. Then when you select and customize your ECards, just click on &quot;<b>Select Poem</b>&quot; and choose the poem that you would like to send with your card.";
$myalbum_button_goto_poem="My Poems";
$myalbum_info_stamp="Create your own unique, personalized stamps! Upload your stamp files here. Then when you select and customize your ECards, just click on &quot;<b>Select Stamp</b>&quot; and choose the stamp that you would like to send with your card.";
$myalbum_button_goto_stamp="My Stamps"; 
$myalbum_info_font="Add your own fonts to the font selection. Great for invitations! Upload your font files here. Then when you select and customize your ECards and Invitations, just click on &quot;<b>Select Font</b>&quot; and choose the font that you would like to use with your card.";
$myalbum_button_goto_font="My Fonts"; 

$myalbum_photo_title="My Photos";
$myalbum_txt_photo_thumbnail="Photo Thumbnail";
$myalbum_txt_send_this_card="Send this photo";
$myalbum_txt_send_this_card_tooltip="Send this photo as an ecard";
$myalbum_txt_delete_this_card="Delete";
$myalbum_Image_click_to_upload ="Click here to upload new photos";
$myalbum_Album_click_to_create ="Click here to create new albums";
$myalbum_Image_Title ="Upload your own Pictures";
$myalbum_Album_Title ="Create your own Albums";
$myalbum_txt_Image_File_Browse="Click Browse button to select your image file (File type: .gif .jpg .png .swf)";
$myalbum_txt_Album_Create_New="Create your own album to store pictures then send them as ecards later";
$myalbum_txt_album_name = "Album name";
$myalbum_txt_album_description = "Album description";
$myalbum_txt_album_private = "Private or not?";
$myalbum_txt_album_no_pictures = "pics";
$myalbum_txt_Album_Create_New_Javascript_Error_Name_Required = "You must enter your album name";
$myalbum_txt_Album_Create_New_Javascript_Error_Desc_Required = "You must enter your album description";
$myalbum_image_error_msg_image_Type ="You must select image file type: .gif or .jpg or .png or .swf.";
$myalbum_image_error_msg_image_FileSize_Big ="File size too big. Your file size must be less than or equal $cf_image_upload_max_size bytes";
$myalbum_image_error_msg_image_Over_Limit ="Sorry, Over Limit. Maximum Image files you can upload are $cf_album_max_image.<br />Delete your old photo files so you can upload new one.";
$myalbum_image_msg_New_Image_Added ="Your new Photos have been added.";
$myalbum_image_msg_New_Album_Added ="Your new Album have been added.";
$myalbum_member_delete_image_confirm ="Are you sure you want to delete selected Photos?";
$myalbum_msg_Image_updated ="Your Photo Album has been updated";
$myalbum_button_upload_now="Upload Now";
$myalbum_button_create_now = "Create Now";
$myalbum_js_alert_must_input_file="You must input your files.";
$myalbum_txt_checkbox_select_all="Select All";
$myalbum_txt_checkbox_check_all="Check/Uncheck all";


$myalbum_stamp_title="My Stamps";
$myalbum_txt_stamp_thumbnail="Stamp Thumbnail";
$myalbum_txt_Stamp_File_Browse="Click Browse button to select your stamp file (File type: .gif .jpg .png). Recommended stamp image size: $cf_album_max_stamp_width px x $cf_album_max_stamp_height px";
$myalbum_Stamp_click_to_upload ="Click here to upload new stamps";
$myalbum_member_delete_stamp_confirm ="Are you sure you want to delete selected Stamps?";
$myalbum_image_error_msg_stamp_Type ="You must select image file type: .gif or .jpg or .png";
$myalbum_image_error_msg_stamp_FileSize_Big ="File size too big. Your file size must be less than or equal $cf_stamp_upload_max_size bytes";
$myalbum_image_error_msg_stamp_Over_Limit ="Sorry, Over Limit. Maximum Image files you can upload are $cf_album_max_stamp.<br />Delete your old stamp files so you can upload new one.";
$myalbum_image_msg_New_Stamp_Added ="Your new Stamps have been added.";
$myalbum_msg_Stamp_updated="Your Stamp Album has been updated";

$myalbum_music_title="My Music";
$myalbum_music_click_to_upload="Click here to upload music files";
$myalbum_music_upload_my_voice="Upload my voice";
$myalbum_upload_music_title="Upload your music files";
$myalbum_txt_Music_File_Browse="Click Browse button to select your music file (File type: .mp3 .mid .wma .rm)";
$myalbum_txt_music_title="Song Title";
$myalbum_txt_song_file_name="Song File name";
$myalbum_txt_song_play="Play";
$myalbum_txt_delete_this_song="Delete";
$myalbum_member_delete_music_confirm="Are you sure you want to delete selected music files?";
$myalbum_txt_tooltip_play_song="Play this song";
$myalbum_msg_Music_updated="Your Music Album has been updated.";
$myalbum_music_error_msg_music_Type="You must select audio file type: .mid or .wma or .mp3 or .rm";
$myalbum_music_error_msg_music_FileSize_Big="File size too big. Your file size must be less than or equal $cf_music_upload_max_size bytes";
$myalbum_music_error_msg_music_Over_Limit="Sorry, Over Limit. Maximum music files you can upload are $cf_album_max_music.<br />Delete your old audio files so you can upload new one.";
$myalbum_music_msg_New_Music_Added="Your new Music files have been added.";

$myalbum_poem_title="My Poems";
$myalbum_Poem_click_to_upload="Click here to compose your poem";
$myalbum_upload_poem_title="Compose your poem";
$myalbum_txt_poem_title="Poem Title";
$myalbum_txt_poem_author="Author";
$myalbum_txt_poem_body="Poem Body";
$myalbum_button_add_poem="Add Poem";
$myalbum_txt_poem_title_author_body="Poem Title / Author / Poem Body";
$myalbum_txt_delete_this_poem="Delete";
$myalbum_msg_poem_updated="Your Poem Album has been updated";
$myalbum_poem_msg_New_poem_Added="New Poem has been added";
$myalbum_poem_js_alert_must_enter_poem_title="You must enter Poem Title";
$myalbum_poem_js_alert_must_enter_poem_author="You must enter Poem Author";
$myalbum_poem_js_alert_must_enter_poem_body="You must enter Poem Body";
$myalbum_member_delete_poem_confirm="Are you sure you want to delete selected poems?";

$myalbum_font_title="My Fonts";
$myalbum_upload_font_title="Upload your own fonts";
$myalbum_txt_font_name="Font name";
$myalbum_txt_sample="Image Sample";
$myalbum_txt_delete_this_font="Delete";
$myalbum_txt_Font_File_Browse="Click Browse button to select your font file (File type: .ttf).";
$myalbum_Font_click_to_upload ="Click here to upload new fonts";
$myalbum_member_delete_font_confirm ="Are you sure you want to delete selected Fonts?";
$myalbum_font_error_msg_font_Type="You must upload font file (.ttf)";
$myalbum_font_error_msg_overlimit_upload_font="Sorry! You're not allowed to upload more than $cf_user_max_font_upload font files.";
$myalbum_font_msg_New_font_Added="Your new fonts have been added";
$myalbum_msg_font_updated="Your Font Album has been updated";

$myalbum_image_error_msg_stamp_Type ="You must select image file type: .gif or .jpg or .png";
$myalbum_image_error_msg_stamp_FileSize_Big ="File size too big. Your file size must be less than or equal $cf_stamp_upload_max_size bytes";
$myalbum_image_error_msg_stamp_Over_Limit ="Sorry, Over Limit. Maximum Image files you can upload are $cf_album_max_stamp.<br />Delete your old stamp files so you can upload new one.";
$myalbum_image_msg_New_Stamp_Added ="Your new Stamps have been added.";
$myalbum_msg_Stamp_updated="Your Stamp Album has been updated";


//GRABBER ------------------------------------------------------
$show_media_grabber_html_Enter_Domain="Enter website URL where you want to grab images";
$show_media_grabber_html_note=<<<EOF
With this service, you can download any media files (Photo, Flash, Shockwave, QuickTime movie, Windows Media, Real Video/Audio, Midi, MP3) from any website. And you can send those image photos or flash movie as an eCard. Just follow the instruction below:
  <ul>
    <li>Visit the website with the image you want to copy</li>
    <li>Copy the website address (URL)</li>
    <li>Paste the URL to the TextBox above and click Submit button</li>
  </ul>

EOF;

$Grabber_Found_Files = "<p class=\"OK_Message\">Found %y% multimedia files on this website address:<br />%grab_url%<br />(These files may be subject to copyright)</p>";
$Grabber_Step_Title_2 ="ATTENTION!!!";
$Grabber_Sorry_You_cannot_send_this_image_as_an_ecard ="Sorry! You're unable to send this image as an eCard.";
$Grabber_Terms_and_Condition=<<<EOF
<p class='Error_Message'>TERMS AND CONDITION<br /><br />
In order to send this image as an eCard to your friend,<br /> YOU, the user, will be responsible for any consequences <br />concerning copyright issues of this image shown above. <br /><br />DO YOU ACCEPT?</p>	
<p>
<a href="javascript:answer('yes')" class='button_link_style1'>YES</a>
<a href="javascript:answer('no')" class='button_link_style2'>NO</a><br /><br />	
</p>
EOF;
$Grabber_button_send_flash_as_ecard="Send this movie as an eCard";
$Grabber_button_send_photo_as_ecard="Send this image as an eCard";
$Grabber_button_download_this_file="Download this file";

$thumb_tool_preview_invite_message="Preview Message Default";

$invite_color_table_select_color="Select Color";
$invite_color_table_standard_color="Standard Color";
$invite_color_table_default_color="Default Color";
$invite_format_font_each_line="Format font for each text line";
$invite_button_select_fontcolor="Select Font Color";
$invite_button_select_other_line="Select Other Line";
$invite_button_apply_changes="Apply Changes";
$invite_button_apply_changes_and_close_window="Apply Changes And Close Window";
$invite_button_create_message="Create Message";
$invite_button_click_change_message="Click here to change the message above";
$invite_button_fontface="Select Font";
$invite_select_fontface_title="Select Font";
$invite_button_fontsize="Font Size";
$invite_button_fontcolor="Font Color";
$invite_button_line_height="Line Height";
$invite_button_open_fontformat_window="Open Font Format Window";
$invite_button_use_basic_invite_info="Use Basic Invitation Message";
$invite_button_view_map="View Map";
$invite_basic_message_select_text_line="Select text line you want to edit font format";
$invite_basic_message_title="Invitation Basic Message";
$invite_basic_message_event_name="Event name";
$invite_basic_message_hosted_by="Hosted by";
$invite_basic_message_when="When";
$invite_basic_message_where="Where";
$invite_basic_message_date="Date";
$invite_basic_message_select_event_date="Select Event Date";
$invite_basic_message_time="Time";
$invite_basic_message_location_name="Location name";
$invite_basic_message_street_address="Street Address";
$invite_basic_message_city="City";
$invite_basic_message_state="State";
$invite_basic_message_zipcode="Zip code";
$invite_basic_message_zipcode_country="Zip code, Country";
$invite_basic_message_phone="Phone number";
$invite_basic_message_youre_invited="YOU ARE INVITED";
$invite_js_alert_must_enter_event_name="You must enter Event name";
$invite_js_alert_must_enter_hosted_by="You must enter Hosted by";
$invite_js_alert_must_enter_date_time="You must enter Event Date and Time";
$invite_js_alert_must_enter_location_name="You must enter Location name";
$invite_js_alert_must_enter_address="You must enter Street Address";
$invite_js_alert_must_enter_location_city="You must enter Location City";
$invite_js_alert_must_enter_location_state="You must enter Location State";
$invite_js_alert_must_enter_location_zip="You must enter Location Zipcode";
$invite_js_alert_must_enter_phone_number="You must enter Phone number";
$invite_js_alert_must_enter_card_message="You must enter card message";
$invite_js_alert_must_insert_your_photo="You must insert your photo to this card";
$invite_personal_message_if_announcement_card="Check here if this is an <strong>Announcement Card</strong>. When recipient picks up the card, he/she will not see question: <strong>Will You Attend?</strong>";
$invite_personal_message_show_map_reminder="Show Map and Email Reminder Service";
$invite_personal_message_would_you_like_show_map="Would you like to show Map to guest?";
$invite_personal_message_would_you_like_reminder="Would you like to send Email Reminder to guest?";
$invite_personal_message_say_yes="YES";
$invite_personal_message_say_no="NO";
$invite_personal_message_reminder_guest="Remind Guest";
$invite_photo_goes_here_not_login="<strong>Your Photo Goes Here</strong><br /><br /><br />Please sign in to add your own photo to this card.";
$invite_button_insert_your_photo="Click here to insert your photo";
$invite_button_upload_your_photo="Click here to upload your photo";
$invite_select_your_photo_title="Select your photo";
$invite_show_error_message_event_name="You must enter Event name";
$invite_homepage_message=<<<EOF
<h1><img border="0" src="$ecard_url/templates/$cf_set_template/icon_invitation.gif" alt="" style="vertical-align:middle" /> Invitation</h1>
<p>With the $cf_site_title Invitation Service, you can create and send invitations online, and track your guest's attendance status 24 hours a day.</p>
<p>It's fast and easy. Click the invitation category on your left to start.</p>
<p>Below is the list of your invites (You must login to access this information)</p>
EOF;
$invite_homepage_message_txt_guest_name_email="Guest name and email";
$invite_homepage_message_txt_invitation_title="Invitation Title";
$invite_homepage_message_txt_total_guest="Number Guests";
$invite_homepage_message_txt_accepted="Accepted";
$invite_homepage_message_txt_declined="Declined";
$invite_homepage_message_txt_not_sure="Not Sure";
$invite_homepage_message_txt_no_response="No Response";
$invite_homepage_message_txt_guest_message="Guest Message";
$invite_homepage_message_txt_delete="Delete";
$invite_homepage_message_txt_add_guest="Add Guests";
$invite_guests_have_been_added="%show_number% guests have been added to your list.";
$invite_add_guests_didnot_send_because_email_blacklist_or_dubplicate="did not send because email is on black list or duplicate guest";
$invite_txt_view_card_detail="View Card Detail";
$invite_detail_created_date="This Invitation Card was created on:";
$invite_detail_button_preview_card="Preview This Card";
$invite_detail_card_has_been_sent_to_number_guest="This card has been sent to <span class=\"OK_Message\">%show_number%</span> guests.";
$invite_detail_number_guest_will_attend="Number of guests who will attend event: <span class=\"OK_Message\">%show_number%</span>";
$invite_detail_number_guest_unsure_attend="Number of guests who are unsure of attendance: <span class=\"OK_Message\">%show_number%</span>";

$invite_pickup_card_info="This invitation card was created on <strong>%show_date%</strong><br />by <strong>%show_sender_name%</strong> to <strong>%receiver_name_email%</strong>";
$invite_pickup_reply_add_comment="<strong>Add a comment. (optional)</strong>";
$invite_pickup_reply_will_you_attend="<strong>Will you attend?</strong> <span class=\"Error_Message\">*</span>";
$invite_pickup_reply_yes="<strong>Yes</strong>";
$invite_pickup_reply_no="<strong>No</strong>";
$invite_pickup_reply_notsure="<strong>Not sure</strong>";
$invite_pickup_reply_number_guest_come_with_you="<strong>Number of guests who will come with you:  <span class=\"Error_Message\">*</span> </strong>";
$invite_pickup_button_send_reply="SEND REPLY";
$invite_reply_thankyou="Thank you! Your reply has been sent to host";
$invite_reminder_note_subject="Invitation card reminder, event date: ";
$invite_send_pickup_email_subject ="$_SESSION[user_name] $_SESSION[user_last_name] has sent you an Invitation Card from $cf_site_title";
$invite_send_pickup_email_message=<<<EOF
Hi %show_friend_name%!
<br /><br />
$_SESSION[user_name] $_SESSION[user_last_name] has sent you an Invitation Card.
<br /><br />
Click the link below to view your invitation:
<br /><br />
<a href="$ecard_url/index.php?step=pickup_invite&cs_id=%show_id%">$ecard_url/index.php?step=pickup_invite&cs_id=%show_id%</a>
<br /><br />
Your Invitation Card will be available for pick-up during the next $cf_card_expire_day_invite days.
<br /><br />
Send your own $cf_site_title greeting cards by visiting:
<br /><br />
<a href="$ecard_url">$ecard_url</a>
<br /><br />
$cf_site_title staff

EOF;

$invite_send_notify_user_has_replied_card_email_subject ="%show_name% has replied your invitation card";
$invite_send_notify_user_has_replied_card_email_message=<<<EOF
Hi %show_name%,
<br /><br />
%content%
Attend: %attend%
<br /><br />
Number of guests: %number%
<br /><br />
Your Invitation Card will be available for pick-up during the next $cf_card_expire_day_invite days.
<br /><br />
To keep track of your invitations, click the link below, then login to your account
<br /><br />
<a href="$ecard_url/index.php?step=show_invitation">$ecard_url/index.php?step=show_invitation</a>
<br /><br />
Thank you for using $cf_site_title greetings!
<br /><br />
Send more $cf_site_title cards by visiting:
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
/* Client request us to insert new line */
$invite_send_notify_user_has_replied_card_email_subject="%show_name% has replied to the Invitation from $cf_site_title for %invite_title%";
$invite_send_notify_user_has_replied_card_email_message=<<<EOF
Hi %show_f_name%,
<br /><br />
%show_name% has replied to the Invitation from $cf_site_title for %invite_title%
<br /><br />
Attend: %attend%<br /><br />
Number of guests: %number%

<br /><br />
Message: %content%
<br /><br />
<a href="$ecard_url">$ecard_url</a>
<br /><br />
$cf_site_title staff

<br /><br />
EOF;
/* End insert new line */

$addressbook_button_import="Import";
$addressbook_txt_click_load_contact="Import contacts from file";
$addressbook_file="File";$addressbook_upload="Load";
$addressbook_load_error="Please select correct file type !";
$load_address_book_from_file="Upload csv,vcard to import your contacts";
$was_imported_into_your_address_book_sucessfully="has been loaded into your addressbook successfully !";
$items_was_added_into_your_address_book="Items have been added:";
$invalid_items="Invalide items:";
$already_exist_items_in_your_address_book="exist in your addressbook";
$twitter_message="created a special card for you <a href=\"$ecard_url/index.php?step=pickup&cs_id=%show_id%\">$ecard_url/index.php?step=pickup&cs_id=%show_id%</a> [click link to see ecard]";
$twitter_private_message="created a special card for @%recipient% <a href=\"$ecard_url/index.php?step=pickup&cs_id=%show_id%\">$ecard_url/index.php?step=pickup&cs_id=%show_id%</a>";
$twitter_account_to_send="- You are using twitter %twitter_account% to send ecards. <a href=\"$ecard_url/index.php?step=sign_in&next_step=show_myaccount#twitter_connection\">Click here</a> to change twitter account.<br>";
$twitter_message_help="<b>Notes:</b><br><i>%twitter_to_send_message%- enter <b>@twitter_recipient</b> as an email to send card notification as public message. For example: <b>@someone</b>.<br>- enter  <b>d twitter_recipient</b>  as an email to send card notification as direct message. For example: <b>d someone</b>.<br>- The recipients must follow your twitter to be able to receive card. Please check this URL format to see if recipients have follow you: <b>http://twitter.com/recipients_twitter/following</b></i><br />";
$twitter_message_help_disabled="";

$invite_homepage_message_txt_no_resend = "Resend";
$add_your_comment="Add your comment";
$message_is_required="Message is required";
$message_post_by="Posted by";
$message_on="on";
// Language for Send Video Card
$send_video_card_title="Send video card";
$send_video_card_embed_code="Video embed code";
$send_video_card_example="Enter Video embed code - example:";
$send_video_card_show_info=" Send video as ecard";

$send_on_recipient_birthday="Send on recipient birthday";
$birthday_this_group="View auto birthday card";
$set_birthday_card="View auto birthday card";
$recipient_group="Recipient Group";
$select_a_group="Select group";
$default_group="Default Group";
$save_setting="Save Setting";
$please_select_a_group="Please select a group !";
$sendcard_txt_card_has_been_saved="Card setting has been saved !";
$select_button_send_another_ecard="Select another card";
$would_you_like_to_setting_card="You have not select a card yet.  Please select one by clicking on the Set Birthday Card icon?";

$add_new_recipient="Recipient";
$add_from_address_book="Recipient Group";
$select_group="Select Group";
$default_group="Address Book";
$select_or_choise="or select  recipent(s) from address book";
$email_template="Email Template";
$email_subject="Subject";
$more="More";
$customize_card="customize card";
$add_recipient_message="add recipients &amp; message";
$send_card="Send card";
$do_not_change_password="Logged in with Facebook, cannot change password.";
$send_an_ecard="%FROM_NAME% has sent you an ECard from $cf_site_title";
$you_are_here="You are here: ";
$newest_invitation_ecards="Newest invitation eCards";
$txt_card_lable_HTML="HTML CARD";
$txt_card_lable_YOUTUBE="YOUTUBE CARD";
$txt_card_lable_VIDEO="VIDEO CARD";
$txt_free="Free";
$twitter_recipient="Twitter recipient";
$share_with_social_network="Share with social network";
$member_group_txt_allow_to_share_card_with_twitter="Allow feature sharing with Twitter";
$member_group_txt_allow_to_share_card_with_facebook="Allow feature sharing with Facebook";
$member_group_txt_allow_to_share_card_with_googleplus="Allow feature sharing with Google Plus";
$member_group_txt_allow_to_share_card_with_linkedin="Allow feature sharing with Linkedin";
$allow_to_share_card_with_twitter_yes="yes";
$allow_to_share_card_with_twitter_no="no";
$txt_show_list_data = "List";
$txt_ecard_category = "Categories";
$invite_homepage_message_responsive=<<<EOF
<h1 class='table_title_bar' id='title-1'><i class='fa fa-birthday-cake padding5'></i> Invitation</h1>
<div class='invitation-message'>
<p>With the $cf_site_title Invitation Service, you can create and send invitations online, and track your guest's attendance status 24 hours a day.</p>
<p>It's fast and easy. Click the invitation category on your left to start.</p>
<p>Below is the list of your invites (You must login to access this information)</p>
</div>
EOF;
$send_thank_you_message = "Send thank you message";
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
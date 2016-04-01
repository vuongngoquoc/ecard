<?php
$charset="UTF-8";

//Language for general
$ecard_txt_admin_title="eCardMAX 10.5 Admin Control Panel";
$ecard_txt_copyright="Powered by eCardMAX 10.5";
$ecard_txt_copyright_2010="Copyright &copy; 1999-2016 <a target=\"_blank\" href=\"http://www.ecardmax.com\">eCardMAX.com</a>";
$ecard_message_updating="updating...";
$ecard_txt_display_row_per_page="Display row per page";

//Language for Email Tool - Sending page
$email_tool_sending_message_newsletter_list="Newsletter List";
$email_tool_sending_message_special_offers_list="Special Offers List";
$email_tool_sending_txt_preview_page_title="PREVIEW BEFORE SENT";
$email_tool_sending_txt_group_email_id="Group Email ID";
$email_tool_sending_txt_email_subject="Email Subject";
$email_tool_sending_txt_view_email=<<<EOF
Email Body (see below) - If you do not see the preview message - <a href="$ecard_url/admin/index.php?step=%step%&what=display_email_body&mmess_id=%mmess_id%" target="_blank">Click here</a>
EOF;
$email_tool_sending_txt_send_a_test_email="Send a test email to";
$email_tool_sending_txt_send_email_to_all_users="Send email to all users on the list now";
$email_tool_sending_txt_number_email_per_batch="Number of Email per Batch";
$email_tool_sending_email_body=<<<EOF
"<!-- %message_body_text%\n\n-----------------------------------------------------------\nClick the link below to remove your email from our email list\n %remove_email_link% -->"
%message_body% <br /><br /><hr />Click the link below to remove your email from our email list<br /><a href="%remove_email_link%">%remove_email_link%</a>
EOF;
$email_tool_sending_print_note=<<<EOF
An email with subject <strong>%message_subject%</strong> has been sent to <strong>%cf_webmaster_email%</strong><br /><br />If everything OK, click button 'Send Mass Email' below to start sending email on the list.<br /><br />
EOF;
$email_tool_sending_txt_note="Note";
$email_tool_sending_txt_turn_off_pop_notify="A pop up window will be openned, please turn off Block Popup Control software then click button below";
$email_tool_sending_button_send_mass_mail="Send Mass Email";
$email_tool_sending_txt_send_mass_mail_page_title="Send Mass Email";
$email_tool_sending_txt_sending_mail="SENDING EMAIL.....";
$email_tool_sending_txt_time_elapsed="Time elapsed";
$email_tool_sending_txt_total_email="Total email on the list";
$email_tool_sending_txt_remaining="Remaining";
$email_tool_sending_txt_status="Status";
$email_tool_sending_txt_status_do_not_close_windows="Sending...Do not close this window";
//$email_tool_sending_txt_status_do_not_close_windows="This is demo version so it has not send email to prevent spam";
$email_tool_sending_txt_group_title="Group Title";
$email_tool_sending_txt_from_name="From name";
$email_tool_sending_txt_from_email="From email";
$email_tool_sending_tooltip_preview_message="Preview message";
$email_tool_sending_txt_email_subject="Email subject";
$email_tool_sending_txt_page_title="Send Email";
$email_tool_sending_txt_step1="Step1: Select Recipient Group";
$email_tool_sending_txt_column_name_icon="Icon";
$email_tool_sending_txt_column_name_recipient_group="Recipient Group";
$email_tool_sending_txt_column_name_email="#Email";
$email_tool_sending_txt_column_name_select="Select";
$email_tool_sending_txt_step2="Step2: Select Newsletter Message";
$email_tool_sending_txt_column_name_newsletter_detail="Newsletter Detail";
$email_tool_sending_txt_column_name_preview_email="Preview";
$email_tool_sending_txt_button_next_step="Continue next step";
$email_tool_sending_message_must_select_recipt_group="You must select Recipient Group";
$email_tool_sending_message_must_select_email_message="You must select Email Message";

//Language for Email Tool - Create Message page
$email_tool_create_message_msg_new_msg_added="New message has been added";
$email_tool_create_message_txt_html_version_click_to_close="Newsletter Body HTML Version - click here to close";
$email_tool_create_message_txt_text_version_click_to_close="Newsletter Body TEXT Version - click here to close";
$email_tool_create_message_txt_email_subject="Email Subject";
$email_tool_create_tooltip_click_here_to_edit="Click here to edit";
$email_tool_create_tooltip_preview_message="Preview message";
$email_tool_create_tooltip_delete="Delete";
$email_tool_create_tooltip_close_hide="Close/Hide";
$email_tool_create_message_db_updated="Mysql table quote has been updated";
$email_tool_create_txt_page_title="Create New/Edit/Delete Newsletter";
$email_tool_edit_txt_page_title="Edit Newsletter";
$email_tool_create_txt_click_to_create_newsletter="Click here to create newsletter";
$email_tool_create_txt_create_newsletter="Create newsletter";
$email_tool_edit_txt_create_newsletter="Edit newsletter";
$email_tool_create_txt_email_subject="Email Subject";
$email_tool_create_txt_newsletter_html_version="Newsletter Body (HTML version - required)";
$email_tool_create_txt_newsletter_text_version="Newsletter Body (Text version - optional)";
$email_tool_create_txt_button_add_new_letter="Submit";
$email_tool_create_txt_tips="Tips";
$email_tool_create_txt_tips_content=<<<EOF
<ul>
	<li>eCardMAX will send email newsletter with both HTML & Text format. If user's mail reader can't read HTML email, then they will see Text version.</li>
	<li>When you create new newsletter message, please include both HTML & Text format.</li>
	<li>When you add new message, you can use Frontpage, Dreamweaver to create HTML email, then copy HTML source code and paste to textarea box.</li>
</ul>
EOF;
$email_tool_create_txt_column_name_icon="Icon";
$email_tool_create_txt_column_name_newsletter_detail="Newsletter Detail";
$email_tool_create_txt_column_name_preview="Preview";
$email_tool_create_txt_column_name_delete="Delete";
$email_tool_create_tooltip_select_all="Select All";
$email_tool_create_txt_row_per_page="Display row per page";
$email_tool_create_txt_search_message="Search message";
$email_tool_create_button_search_message="Search";
$email_tool_create_button_delete_selected="Delete Selected";
$email_tool_create_message_email_subject_required="You must enter Email subject";
$email_tool_create_message_email_body_required="You must enter Newsletter message body";
$email_tool_create_message_checkbox_check_first="You must select checkbox first. Please try again.";
$email_tool_create_message_confirm_to_delete="Are you sure you want to delete your selected?";

//Language for Email Tool - Recipient Group
$email_tool_recipient_group_message_new_group_add="New Recipient Group %group_name% has been added";
$email_tool_recipient_group_message_search_email_keyword="Search email with keyword";
$email_tool_recipient_group_txt_ip2country="IP2Country";
$email_tool_recipient_group_tooltip_user_ip2country="User IP2Country";
$email_tool_recipient_group_txt_user_name="User Name";
$email_tool_recipient_group_txt_delete="Delete";
$email_tool_recipient_group_txt_newsletter_list="Newsletter List";
$email_tool_recipient_group_txt_special_offers_list="Special Offers List";
$email_tool_recipient_group_txt_page_title="Email List - Group Title";
$email_tool_recipient_group_txt_total="Total";
$email_tool_recipient_group_txt_column_name_icon="Icon";
$email_tool_recipient_group_txt_column_name_email="Email";
$email_tool_recipient_group_txt_column_name_more_info="More info";
$email_tool_recipient_group_txt_column_name_time_added="Time Added";
$email_tool_recipient_group_txt_column_name_delete="Delete";
$email_tool_recipient_group_tooltip_select_all="Select All";
$email_tool_recipient_group_txt_row_per_page="Display row per page";
$email_tool_recipient_group_txt_search_email="Search email";
$email_tool_recipient_group_button_search_email="Search";
$email_tool_recipient_group_button_delete_selected="Delete Selected";
$email_tool_recipient_group_message_checkbox_first="You must select checkbox first. Please try again.";
$email_tool_recipient_group_message_confirm_to_delete="Are you sure you want to delete your selected?";
$email_tool_recipient_group_message_email_address_added="%count_email% email addresses have been added";
$email_tool_recipient_group_txt_add_email_page_title="Add Email - Group Title";
$email_tool_recipient_group_txt_add_email_to_group="Add new email to group title";
$email_tool_recipient_group_txt_enter_email_list="Enter list of email address<br />(Line by line)";
$email_tool_recipient_group_button_add_email="Submit";
$email_tool_recipient_group_message_email_list_required="You must enter email list";
$email_tool_recipient_group_txt_extract_email_page_title="Extract Email - Group Title";
$email_tool_recipient_group_txt_extract_email="Extract email";
$email_tool_recipient_group_txt_number_of_email_a_page="Show number of email a page";
$email_tool_recipient_group_txt_email_list="Emails list";
$email_tool_recipient_group_button_extract_email="Submit";
$email_tool_recipient_group_button_select_all="Select All";
$email_tool_recipient_group_txt_select_tips="(Select all and use Ctrl-C to copy list of email above to clipboard)";
$email_tool_recipient_group_txt_group_title="Group Title";
$email_tool_recipient_group_txt_from_name="From name";
$email_tool_recipient_group_txt_from_email="From email";
$email_tool_recipient_group_txt_add_bulk_mail="Add bulk emails";
$email_tool_recipient_group_button_add_new_recipient="Submit";
$email_tool_recipient_group_tooltip_add_new_email_this_group="Add new emails to this group";
$email_tool_recipient_group_tooltip_extract_email="Extract email";
$email_tool_recipient_group_tooltip_click_to_view_email="click here to view email";
$email_tool_recipient_group_tooltip_click_to_add_new_email_to_list="click here to add new emails to this list";
$email_tool_recipient_group_tooltip_click_to_extract_email="click here to extract email";
$email_tool_recipient_group_tooltip_click_to_edit="Click here to edit";
$email_tool_recipient_group_tooltip_view_email_in_this_group="View emails in this group";
$email_tool_recipient_group_message_db_updated="Mysql table quote has been updated";
$email_tool_recipient_group_txt_recipient_group_page_title="Recipient Group";
$email_tool_recipient_group_txt_click_to_add_new_group="Click here to add new group";
$email_tool_recipient_group_txt_add_new_recipient_group="Add New Recipient Group";
$email_tool_recipient_group_txt_close_hide="Close/Hide";
$email_tool_recipient_group_txt_tips="Tips";
$email_tool_recipient_group_txt_tips_content=<<<EOF
<ul>
	<li>Click on group title, from name, from email to edit them.</li>
	<li>But you can't edit or delete group Newsletters & Special Offers List</li>
</ul>
EOF;
$email_tool_recipient_group_txt_column_name_group_title="Group Title";
$email_tool_recipient_group_txt_column_name_email="#Email";
$email_tool_recipient_group_txt_column_name_view="View";
$email_tool_recipient_group_txt_column_name_add="Add";
$email_tool_recipient_group_txt_column_name_extract="Extract";
$email_tool_recipient_group_message_group_title_reqired="You must enter Group title";
$email_tool_recipient_group_message_group_from_name_required="You must enter Group from name";
$email_tool_recipient_group_message_group_from_email_required="You must enter Group from email";

//Language for Manage Banner Ad page
$banner_ad_message_new_banner_added="New banner has been added";
$banner_ad_txt_banner_URL_click_to_edit="Banner Image URL (Click to edit)";
$banner_ad_tooltip_click_to_edit="Click here to edit";
$banner_ad_txt_destination_url="Destination URL (Click to edit)";
$banner_ad_txt_banner_width="Banner width";
$banner_ad_txt_banner_height="Banner height";
$banner_ad_txt_horizontal="Horizontal";
$banner_ad_txt_vertical="Vertical";
//$banner_ad_txt_center="Center";
$banner_ad_txt_center="Slide";
$banner_ad_message_updating="updating...";
$banner_ad_tooltip_delete="Delete";
$banner_ad_tooltip_click_to_preview_banner="click here to preview banner";
$banner_ad_txt_page_title="Add/Enable/Disable/Delete Banner Ads";
$banner_ad_txt_total="Total";
$banner_ad_txt_click_here_add_new_banner="Click here to add new Banner";
$banner_ad_txt_add_new_banner_basic="Add new Banner (Basic)";
$banner_ad_txt_close_hide="Close/Hide";
$banner_ad_txt_banner_image_url="Banner Image URL";
$banner_ad_txt_example="Example: http://www.ecardmax.com/banner/banner_1.gif (Image type: .gif .jpg .png .swf)";
$banner_ad_txt_destination_url="Destination URL";
$banner_ad_txt_destination_example="Example: http://www.ecardmax.com/index.php";
$banner_ad_txt_banner_type="Banner Type";
$banner_ad_txt_px="px";
$banner_ad_button_add_new_banner="Submit";
$banner_ad_txt_add_new_banner_advance="Add new Banner (Advance)";
$banner_ad_txt_banner_code="Enter Banner Code (HTML or Javascript)";
$banner_ad_button_add_new_banner_advance="Submit";
$banner_ad_txt_tips="Tips";
$banner_ad_txt_tips_content=<<<EOF
<ul>
	<li>Check the checkbox to turn ON/OFF Banner</li>
	<li>Click Icon <img border="0" src="html/07_icon_banner3.gif" alt="" style="vertical-align:middle" /> to preview banner</li>
</ul>
EOF;
$banner_ad_txt_column_name_icon="Icon";
$banner_ad_txt_column_name_banner_detail="Banner Detail";
$banner_ad_txt_column_name_banner_type="Banner Type";
$banner_ad_txt_column_name_showed="Showed";
$banner_ad_txt_column_name_clicked="Clicked";
$banner_ad_txt_column_name_on_off="On/Off";
$banner_ad_txt_column_name_delete="Delete";
$banner_ad_tooltip_select_all="Select All";
$banner_ad_txt_row_per_page="Display row per page";
$banner_ad_button_delete_selected="Delete Selected";
$banner_ad_tooltip_click_to_close="Click here to close";
$banner_ad_txt_preview_poem="Preview Poem";
$banner_ad_message_banner_image_url_required="You must enter Banner Image URL";
$banner_ad_message_destination_required="You must enter Destination URL";
$banner_ad_message_banner_width_required="You must enter Banner width";
$banner_ad_message_banner_height_required="You must enter Banner height";
$banner_ad_message_banner_code_required="You must enter Enter Banner Code";
$banner_ad_message_checkbox_required="You must select checkbox first. Please try again.";
$banner_ad_message_confirm_to_delete="Are you sure you want to delete your selected?";

//Language for Manage Quote page
$quote_message_new_quote_added="New quote has been added";
$quote_message_click_to_edit="Click here to edit";
$quote_message_delete="Delete";
$quote_message_updating="updating...";
$quote_txt_page_title="Add/Enable/Disable/Delete Quotes";
$quote_txt_total="Total";
$quote_txt_click_to_add_new_quote="Click here to add new Quote";
$quote_txt_add_new_quote="Add new Quote (Basic)";
$quote_tooltip_close_hide="Close/Hide";
$quote_txt_quote_author="Quote Author";
$quote_txt_quote_body="Quote Body";
$quote_txt_button_add_new_quote="Submit";
$quote_txt_add_new_quote_advance="Add new Quote (Advance)";
$quote_txt_input_data_example="Input data example";
$quote_txt_quote_data_example="Jimmy Durante|I hate music, especially when it's played";
$quote_txt_quote_author_body="Quote Author|Quote Body<br />(Enter line by line)";
$quote_txt_button_add_new_quote_bulk="Submit";
$quote_txt_tips="Tips";
$quote_txt_tips_content=<<<EOF
<ul>
	<li>Check the checkbox to enable Quote. Uncheck the checkbox will disable that Quote.</li>
	<li>Click Quote Body or Quote Author to edit them</li>
</ul>
EOF;
$quote_txt_column_name_icon="Icon";
$quote_txt_column_name_quote_body="Quote Body";
$quote_txt_column_name_quote_author="Author";
$quote_txt_column_name_quote_enable_disable="Enable/Disable";
$quote_txt_column_name_quote_delete="Delete";
$quote_tooltip_select_all="Select All";
$quote_txt_row_per_page="Display row per page";
$quote_txt_button_delete_selected="Delete Selected";
$quote_message_quote_author_required="You must enter Quote Author";
$quote_message_quote_body_required="You must enter Quote Body";
$quote_message_quote_input_data_required="You must input your data";
$quote_message_quote_checkbox_first="You must select checkbox first. Please try again.";
$quote_message_quote_confirm_to_delete="Are you sure you want to delete your selected?";

//Language for Manage Poem page
$poem_message_new_poem_added="New Poem has been added";
$poem_tooltip_click_here_to_edit="Click here to edit";
$poem_tooltip_delete="Delete";
$poem_tooltip_click_here_to_view_poem="click here to preview message";
$poem_message_updating="updating...";
$poem_txt_page_title="Add/Enable/Disable/Delete Messages";
$poem_txt_total="Total";
$poem_txt_click_here_new_poem="Click here to add new Message";
$poem_txt_add_new_poem="Add new Message";
$poem_tooltip_close_hide="Close/Hide";
$poem_txt_poem_title="Message Title";
$poem_txt_poem_author="Message Author";
$poem_txt_poem_body="Message Body";
$poem_txt_button_add_new_poem="Submit";
$poem_txt_tips="Tips";
$poem_txt_click_here_new_poem_cat="Click here to add new Suggest Message category";
$poem_txt_add_new_poem_cat="Add new Suggest Message category";
$poem_txt_poem_cat_title="Category name";
$poem_txt_poem_cat_cat="Category parent";
$poem_txt_tips_content=<<<EOF
<ul>
	<li>Check the checkbox to enable Suggest Message. Uncheck the checkbox will disable that Suggest Message.</li>
	<li>Click Suggest Message Author, Suggest Message Title, Suggest Message Body to edit them</li>
	<li>Click Suggest Message Icon <img border="0" src="html/07_icon_upload_poem2.gif" alt="" style="vertical-align:middle" /> to preview poem on new window</li>
</ul>
EOF;
$poem_txt_column_name_icon="Icon";
$poem_txt_column_name_poem_title_author_body="Message Title - Author - Body";
$poem_txt_column_name_enable_disable="Enable/Disable";
$poem_txt_column_name_sort_order="Sort Order";
$poem_txt_column_name_delete="Delete";
$poem_txt_tooltip_select_all="Select All";
$poem_txt_row_per_page="Display row per page";
$poem_txt_button_delete_selected="Delete Selected";
$poem_tooltip_click_here_to_close="Click here to close";
$poem_txt_preview_poem="Preview Message";
$poem_message_poem_title_required="You must enter Message Title";
$poem_message_poem_author_required="You must enter Message Author";
$poem_message_poem_body_required="You must enter Message Body";
$poem_message_checkbox_first="You must select checkbox first. Please try again.";
$poem_message_confirm_to_delete="Are you sure you want to delete your selected?";

//Language for Manage Music page
$music_message_you_must_chmod_music_folder="You must chmod 777 for this folder $ecard_root/resource/music first.";
$music_message_music_filename_added="music file name %file_name% has been added";
$music_message_can_not_upload_file="CAN'T uploaded %file_name% - Please chmod 777 folder ../resource/music";
$music_message_can_not_upload_file_exist="CAN'T uploaded %file_name% - File name exists";
$music_message_music_filename_removed="Music %music_filename% has been removed";
$music_message_music_filename_cannt_deleted="Can't delete music file %music_filename% - permission denied. Use FTP to delete it";
$music_tooltip_current_category="Current category";
$music_tooltip_click_to_open_category="Click to open category %cat_name_display%";
$music_txt_please_select_a_category_to_move="Please select a category to move selected musics ID %list_id%";
$music_txt_click_here_to_move="Click here to MOVE selected musics to category name <span style=\"color:green\">%cat_name_display%</span>";
$music_txt_click_here_to_copy="Click here to COPY selected musics to category name <span style=\"color:green\">%cat_name_display%</span>";
$music_txt_move_selected_music="Move selected musics to category name...(select category below)";
$music_txt_copy_selected_music="Copy selected musics to category name...(select category below)";
$music_txt_category_navigation="Category Navigation";
$music_txt_main_root="Main Root";
$music_txt_category_name="Category Name";
$music_txt_cancel_and_go_back="Cancel - go back to Add/Remove Music";
$music_message_your_selected_music_has_been_moved="Your selected music have been moved to category name %cat_name_display%";
$music_message_permission_denied_cannt_move_selected="Permission denied. We can't move your selected music to new category. Please chmod 777 folder name %cat_dir%";
$music_message_your_selected_music_has_been_copied="Your selected music have been copied to category name %cat_name_display%";
$music_message_permission_denied_cannt_copy_selected="Permission denied. We can't move your selected music to new category. Please chmod 777 folder name %cat_dir%";
$music_tooltip_click_here_to_rename="Click here to rename";
$music_tooltip_click_here_to_set_as_birthday_category="Click here to set %cat_name_display% as Birthday category";
$music_tooltip_delete="Delete";
$music_tooltip_click_to_listen="Click to listen";
$music_message_updating="updating...";
$music_txt_page_title="Add/Enable/Disable/Delete Music";
$music_txt_total="Total";
$music_txt_click_here_to_add_new_music="Click here to add new Music";
$music_txt_how_to_add_new_music_by_using_ftp="How to add new Music by using FTP program?";
$music_tooltip_close_hide="Close/Hide";
$music_txt_how_to_add_new_music_by_using_ftp_content=<<<EOF
				<ol>
					<li>Use FTP login to your server, go inside folder <br /><strong>%cat_dir%</strong><br /><br /></li>
					<li>Let's say you want to add new Music name <strong>MyXMusic</strong>. Use FTP to upload file MyXMusic.mp3 to folder <br /><strong>%cat_dir%/MyXMusic.mp3</strong><br /><br /></li>
					<li>After you're done uploading your files, <a href="%insert_music_url%">CLICK HERE</a> to insert your new Music to database.<br /><br /></li>
				</ol>
EOF;
$music_txt_add_new_music_using_web_browser="Add new Music using web browser";
$music_txt_file_1="File 1";
$music_txt_tips_file=" (should .mp3)";
$music_txt_file_2="File 2";
$music_txt_file_3="File 3";
$music_txt_file_4="File 4";
$music_txt_file_5="File 5";
$music_txt_file_6="File 6";
$music_txt_file_7="File 7";
$music_txt_button_add_new_music="Submit";
$music_txt_tip="Tips";
$music_txt_tip_content=<<<EOF
<ul>
	<li>Check the checkbox to enable Music. Uncheck the checkbox will disable that Music.</li>
	<li>Click Music name to rename it</li>
	<li>Please use Enable/Disable instead of delete that Music file.</li>
	<li>Click Music icon <img border="0" src="html/07_icon_play_audio_file.gif" width="26" height="26" alt="" style="vertical-align:middle" /> to play audio file</li>
</ul>
EOF;
$music_txt_column_name_play="Play";
$music_txt_column_name_music_name="Music name";
$music_txt_column_name_file_name="File name";
$music_txt_column_name_enable_disable="Enable/Disable";
$music_txt_column_name_sort_order="Sort Order";
$music_txt_column_name_delete="Delete";
$music_tooltip_select_all="Select All";
$music_txt_row_per_page="Display row per page";
$music_txt_bulk_action="Bulk Action";
$music_txt_delete_selected_musics="Delete selected musics";
$music_txt_move_selected_musics="Move selected musics to other category";
$music_txt_copy_selected_musics="Copy selected musics to other category";
$music_txt_click_here_to_move_category_to_this_position="Click here to move category name <span style=\"color:green\">%cat_name_display%</span> (and all %cat_name_display%'s sub categories) to this position";
$music_txt_move_category_and_sub_cats_to_this_position="Move category name <span style=\"color:green\">%cat_name_display%</span> (and all %cat_name_display%'s sub categories) to...";
$music_tooltip_click_here_to_close="Click here to close";
$music_message_checkbox_first="You must select checkbox first. Please try again.";
$music_message_confirm_to_delete="Are you sure you want to delete your selected?";
$music_message_confirm_to_move="Are you sure you want to move your selected musics to other category?";
$music_message_confirm_to_copy="Are you sure you want to copy your selected musics to other category?";
$music_message_confirm_to_change="Are you sure you want to change your selected ecards thumbnail/fullsize image?";
$music_message_loading="loading...";
$music_message_your_file_required="You must input your file.";
$music_message_new_category_has_been_added="New category has been added";
$music_message_cannt_delete_files="eCardMAX can't delete files %music_filename%. This card is still in database and has been set inactive (Use FTP to delete them)";
$music_message_category_has_been_deleted="Category name %cat_name_display% has been deleted";
$music_message_category_cannt_be_deleted="Can't delete category folder name %ec_cat_dir%. This category is still in database and has been set inactive (Use FTP to delete it)";
$music_message_category_has_been_moved="Category name %cat_name_display% and all %cat_name_display%'s sub categories have been moved";
$music_tooltip_up_one_level="Up One Level";
$music_tooltip_click_here_to_edit="Click here to edit";
$music_message_confirm_to_delete_this_category="Are you sure you want to delete this category?\\n\\nAll ecard in this category and subcategories will be deleted as well.";
$music_tooltip_delete_category="Delete category";
$music_message_you_must_chmod_folder="<br /><span class=\"Error_Message\">You must chmod 777 (or set permission read+write) for folder [picture]<br />(Path: %path%).</span><br /><a href=\"%url%\">Click here</a> to try again.";
$music_txt_manage_music="Manage Music";
$music_txt_show_help_for_this_page="Show help for this page";
$music_txt_visit_this_category="Visit this category (User interface)";
$music_txt_show_help_content=<<<EOF
<ul id="help_div" style="display:none;margin-top:16px;margin-bottom:0px;line-height:18px">
	<li>Check/Uncheck checkbox to activate/deactivate category</li>
	<li>Click birthday cake <img border="0" alt="Set Birthday category" title="Set Birthday category" src="html/07_icon_set_birthday_cat_ac.gif" /> to set Birthday category (the program will pick ecard in this category and auto send it to registered users when their birthday is near).</li>
	<li>Icon <img border="0" src="html/07_icon_open_folder.gif" alt="" /> will tell you that category has subcategory</li>
	<li>Icon <img border="0" src="html/07_icon_open_folder_empty.gif" alt="" /> will tell you there is no subcategory</li>
	<li>Click icon <img border="0" src="html/07_icon_open_folder.gif" alt="" /> or <img border="0" src="html/07_icon_open_folder_empty.gif" alt="" /> to open that category</li>
	<li>Click category name (<span style="text-decoration:underline;">underline words</span>) to rename category.</li>
	<li>See more commands at bottom page.</li>
</ul>
EOF;
$music_txt_column_name_category_name="Category Name";
$music_txt_column_name_music="#music";
$music_txt_column_name_delete="Delete";
$music_txt_column_name_sort_order="Sort Order";
$music_txt_select_command_below="Select command below";
$music_txt_create_new_sub_category="Create new %show_sub_or_main% category:";
$music_txt_add_new_sub_category="Add new %show_sub_or_main% category:";
$music_txt_folder_name="Folder name (to store music files)<br />No special characters please.";
$music_txt_path="Path";
$music_txt_set_html_meta_tag_keyword="Set HTML meta tag Keyword (max=255 characters)";
$music_txt_set_html_meta_tag_description="Set HTML meta tag Description (max=255 characters)";
$music_txt_your_text_here="Your text here";
$music_txt_set_html_tag_title="Set HTML tag Title (max=255 characters)";
$music_txt_active_this_category_now="Active this category now";
$music_txt_click_here_to_add_remove_music_in_this_category="Click here to add/remove music in this category";
$music_tooltip_default_size="Default size";
$music_button_add_new_category="Submit";
$music_tooltip_increase_size="Increase size";
$music_tooltip_decrease_size="Decrease size";
$music_tooltip_click_here_to_close="Click here to close";
$music_txt_click_here_to_close="Click here to close";
$music_message_category_name_required="You must enter Category name";
$music_message_category_folder_name_required="You must enter Category folder name";
$music_message_loading="loading...";

//Language for Manage Stamp page
$stamp_message_you_mush_chdmod_stamp_folder="You must chmod 777 for this folder %stamp_folder% first.";
$stamp_message_stamp_filename_has_been_added="Stamp file name %file_name% has been added";
$stamp_message_cannt_upload_filename_please_chmod_folder="CAN'T uploaded %file_name% - Please chmod 777 folder ../resource/stamp";
$stamp_message_cannt_upload_filename_file_exists="CAN'T uploaded %file_name% - File name exists";
$stamp_message_stamp_has_been_removed="Stamp %stamp_filename% has been removed";
$stamp_message_cannt_delete_stamp_file_permission_denied="Can't delete stamp file %stamp_filename% - permission denied. Use FTP to delete it";
$stamp_tooltip_click_here_to_rename="Click here to rename";
$stamp_tooltip_delete="Delete";
$stamp_message_updating="updating...";
$stamp_txt_page_title="Add/Enable/Disable/Delete Stamp";
$stamp_txt_total="Total";
$stamp_txt_click_here_to_add_new_stamp="Click here to add new Stamp";
$stamp_txt_how_to_add_new_stamp_by_ftp="How to add new Stamp by using FTP program?";
$stamp_txt_how_to_add_new_stamp_by_ftp_tip=<<<EOF
				<ol>
					<li>Use FTP login to your server, go inside folder <br /><strong>%stamp_folder%</strong><br /><br /></li>
					<li>Let's say you want to add new Stamp name <strong>MyXStamp</strong>. Use FTP to upload file MyXStamp.gif to folder <br /><strong>%stamp_folder%/MyXStamp.gif</strong><br /><br /></li>
					<li>After you're done uploading your files, <a href="%url%">CLICK HERE</a> to insert your new stamp to database.<br /><br /></li>
				</ol>
EOF;
$stamp_tooltip_close_hide="Close/Hide";
$stamp_txt_add_new_stamp_using_web_browser="Add new Stamp using web browser";
$stamp_txt_file="File";
$stamp_button_add_new_stamp="Submit";
$stamp_txt_tips="Tips";
$stamp_txt_tips_content=<<<EOF
<ul>
	<li>Check the checkbox to enable Stamp. Uncheck the checkbox will disable that Stamp.</li>
	<li>Click Stamp name to rename it</li>
	<li>If you want to change Stamp thumbnail icon, edit image <strong>/resource/stamp/[File_Name].gif</strong></li>
	<li>Delete Stamp is not recommended, use Enable/Disable instead.</li>
</ul>
EOF;
$stamp_txt_column_name_icon="Icon";
$stamp_txt_column_name_default="Default";
$stamp_txt_column_name_stamp_name="Stamp name";
$stamp_txt_column_name_file_name="File name";
$stamp_txt_column_name_enable_disable="Enable/Disable";
$stamp_txt_column_name_sort_order="Sort Order";
$stamp_txt_column_name_delete="Delete";
$stamp_tooltip_select_all="Select All";
$stamp_txt_row_per_page="Display row per page";
$stamp_button_delete_selected="Delete Selected";
$stamp_message_file_required="You must input your file.";
$stamp_message_checkbox_first="You must select checkbox first. Please try again.";
$stamp_message_confirm_to_delete="Are you sure you want to delete your selected?";

//Language for Manage Skin page
$skin_message_you_must_chmod_this_folder="You must chmod 777 for this folder %skin_folder% first.";
$skin_message_skin_has_been_added="Skin name %skin_name_display% has been added";
$skin_message_cannt_delete_file_permission_denied="Can't delete file %file% - permission denied. Use FTP to delete it";
$skin_message_skin_has_been_removed="Skin %skin_dirname% has been removed";
$skin_message_cannt_delete_folder_skin_permission_denied="Can't delete folder %skin_dirname% - permission denied. Use FTP to delete it";
$skin_txt_no_icon="<br />No<br />Icon";
$skin_tooltip_click_here_to_rename="Click here to rename";
$skin_tooltip_click_to_open_color_picker="click to open color picker";
$skin_tooltip_delete="Delete";
$skin_message_updating="updating...";
$skin_message_mysql_table_skin_updated="Mysql table Skin has been updated";
$skin_txt_page_title="Add/Enable/Disable/Delete Skin Background";
$skin_txt_total="Total";
$skin_txt_click_here_to_add_new_skin="Click here to add new Skin";
$skin_txt_how_to_add_new_skin_by_ftp="How to add new Skin by using FTP program?";
$skin_tooltip_close_hide="Close/Hide";
$skin_txt_upload_by_ftp_guide=<<<EOF
				<ol>
					<li>Use FTP login to your server, go inside folder <br /><strong>%skin_folder%</strong><br /><br /></li>
					<li>Lets say you want to add new Skin name <strong>MyXSkin</strong>. Use FTP to create subfolder<br /><strong>%skin_folder%/MyXSkin</strong><br /><br /></li>
					<li>Start uploading skins files to folder [MyXSkin]. (Note: You must include file color.txt)<br /><br /></li>
					<li>After you are done uploading your files, <a href="%url%">CLICK HERE</a> to insert your new skin to database.<br /><br /></li>
				</ol>
EOF;
$skin_txt_add_new_skin_using_web_browser="Add new Skin using web browser";
$skin_txt_skin_name="Skin name";
$skin_txt_text_color="Text color";
$skin_txt_bar="bar";
$skin_txt_bkg="bkg";
$skin_txt_bottom="bottom";
$skin_txt_icon="icon";
$skin_txt_poem="poem";
$skin_txt_skin="skin";
$skin_txt_top="top";
$skin_button_add_new_skin="Submit";
$skin_txt_tips="Tips";
$skin_txt_tips_detail=<<<EOF
<ul>
	<li>Check the checkbox to enable Skin. Uncheck the checkbox will disable that Skin.</li>
	<li>Click Skin name to rename it</li>
	<li>If you want to change Skin thumbnail icon, edit image <strong>/resource/skin/[Skin_Folder_Name]/skin.gif</strong></li>
	<li>Delete Skin is not recommended, use Enable/Disable instead.</li>
	<li>Click icon <img border="0" src="html/07_icon_search_keyword.gif" alt="" style="vertical-align:middle" /> to preview skin</li>
</ul>
EOF;
$skin_txt_column_name_icon="Icon";
$skin_txt_column_name_default="Default";
$skin_txt_column_name_skin_name="Skin name";
$skin_txt_column_name_text_color="Text color";
$skin_txt_column_name_folder_name="Folder name";
$skin_txt_column_name_enable="Enable";
$skin_txt_column_name_preview="Preview";
$skin_txt_column_name_sort_order="Sort Order";
$skin_txt_column_name_sort_delete="Delete";
$skin_tooltip_select_all="Select All";
$skin_txt_row_per_page="Display row per page";
$skin_button_delete_selected="Delete Selected";
$skin_tooltip_click_here_to_close="Click here to close";
$skin_txt_select_color="Select color";
$skin_txt_standard_color="Standard Color";
$skin_txt_from="From";
$skin_txt_to="To";
$skin_txt_date_created="Date created";
$skin_txt_sample_message="Your message goes here. And you can write as much as you want because our cards expand to fit your text. You can add a happy face icon to make your eCard more beautiful. Thank you for choosing our service";
$skin_message_loading="loading...";
$skin_message_skin_name_required="You must enter Skin name";
$skin_message_text_color_required="You must enter text color";
$skin_message_upload_file_missing="One of file upload is missing. Please check again.";
$skin_message_checkbox_first="You must select checkbox first. Please try again.";
$skin_message_confirm_to_delete="Are you sure you want to delete your selected?";

//Language for Manage Java page
$java_tooltip_icon_not_found="Icon not found";
$java_tooltip_click_here_to_rename="Click here to rename";
$java_message_updating="updating...";
$java_message_mysql_table_java_applet_updated="Mysql table Java applet has been updated";
$java_txt_page_title="Add/Enable/Disable Java Applet";
$java_txt_total="Total";
$java_txt_click_here_to_add_new_java_applet="Click here to add new Java applet";
$java_txt_how_to_add_new_java_applet_by_ftp="How to add new java applet by using FTP program?";
$java_tooltip_close_hide="Close/Hide";
$java_txt_how_to_add_new_java_applet_by_ftp_guide=<<<EOF
				<ol>
					<li>Use FTP login to your server, go inside folder <br /><strong>%java_applet_folder%</strong><br /><br /></li>
					<li>Let's say you want to add new Java Applet name <strong>Snow</strong>. Use FTP to create subfolder<br /><strong>%java_applet_folder%/Snow</strong><br /><br /></li>
					<li>Start uploading java applet files to folder [Snow]. (Note: You must include file code.txt. If you want to learn how to create code.txt, please review our sample code.txt)<br /><br /></li>
					<li>After you're done uploading your files, <a href="%url%">CLICK HERE</a> to insert your new java applet to database.<br /><br /></li>
					<li>If you find a new java applet effect and you don't know how to make it works with eCardMAX, please give us the link to that applet, we will help you..<br /></li>
				</ol>
EOF;
$java_txt_tips="Tips";
$java_txt_tips_detail=<<<EOF
 Check the checkbox to enable Java applet. Uncheck the checkbox will disable that applet.<br /> Click Java applet name to rename it<br /> If you want to change java applet icon, edit image <strong>/resource/applet/[Applet_Folder_Name]/thumb_icon.gif</strong><br /><br />
EOF;
$java_txt_column_name_icon="Icon";
$java_txt_column_name_applet_name="Applet name";
$java_txt_column_name_folder_name="Folder name";
$java_txt_column_name_preview="Preview";
$java_txt_column_name_enable_disable="Enable/Disable";
$java_txt_column_name_sort_order="Sort Order";
$java_tooltip_click_here_to_close="Click here to close";
$java_message_loading="loading...";

//Language for Manage Game page
$games_message_new_game_has_been_added="New game has been added.";
$games_txt_translate_game_title="Translate Game Title";
$games_txt_translate_game_info="Translate Game Info";
$games_tooltip_click_here_to_edit="Click here to edit";
$games_txt_edit_game_url="Edit Game URL";
$games_txt_edit_thumbnail_url="Edit Thumbnail URL";
$games_txt_same_window="Same window";
$games_txt_popup_window="Popup window";
$games_txt_window_width="Window's width";
$games_txt_window_height="Window's height";
$games_txt_translate_game_title_into_other_language="Translate Game Title into other languages";
$games_tooltip_close_hide="Close/Hide";
$games_tooltip_delete="Delete";
$games_message_updating="updating...";
$games_txt_translate_game_into_other_languages="Translate Game Info into other languages";
$games_txt_translate_into_current_languages="Translate into <span class=\"OK_Message\">%current_language%</span>";
$games_txt_page_title="Add/Enable/Disable/Delete Game";
$games_txt_total="Total";
$games_txt_click_here_to_add_new_game="Click here to add new Game";
$games_txt_add_new_game="Add new Game";
$games_txt_game_title="Game Title";
$games_txt_game_info_message_html_ok="Game Info Message (HTML OK)";
$games_txt_game_image_thumbnail_url="Game Image thumbnail URL";
$games_txt_example="Example";
$games_txt_game_main_url="Game main URL";
$games_txt_open_this_game_in="Open this game in";
$games_txt_active_this_game_now="Active this game now";
$games_button_add_new_game="Submit";
$games_txt_tips="Tips";
$games_txt_tips_detail=<<<EOF
<ul>
	<li>Check the checkbox to enable game. Uncheck the checkbox will disable that game.</li>
	<li>Click Game title, game info, game URL, game thumbnail URL to edit it</li>
</ul>
EOF;
$games_txt_column_name_thumbnail="Thumbnail";
$games_txt_column_name_game_title_message="Game Title / Message";
$games_txt_column_name_open_game_type="Open Game Type";
$games_txt_column_name_enable_disable="Enable/Disable";
$games_txt_column_name_sort_order="Sort Order";
$games_txt_column_name_delete="Delete";
$games_tooltip_select_all="Select All";
$games_tooltip_row_per_page="Display row per page";
$games_button_delete_selected="Delete Selected";
$games_message_game_title_required="You must enter Game Title";
$games_message_game_message_required="You must enter Game Message";
$games_message_game_image_thumbnail_url_required="You must enter Game Image thumbnail URL";
$games_message_game_main_url_required="You must enter Game main URL";
$games_message_pop_up_width_and_height_required="You must enter Popup window's width and height";
$games_message_checkbox_first="You must select checkbox first. Please try again.";
$games_message_confirm_to_delete="Are you sure you want to delete your selected?";

//Language for Manage Invite Log page
$invite_log_txt_list_all_cards="List all cards (Total: %total_cards%)";
$invite_log_txt_show_cards_created_tody="Show cards created today (Total: %count_list%). Time frame from <span style=\"color:green\">%begin_today_timestamp%</span> to <span style=\"color:green\">%end_today_timestamp%</span>";
$invite_log_txt_show_cards_created_yesterday="Show cards created yesterday (Total: %count_list%). Time frame from <span style=\"color:green\">%begin_yesterday_timestamp%</span> to <span style=\"color:green\">%end_yesterday_timestamp%</span>";
$invite_log_txt_show_cards_created_this_week="Show cards created this week (Total: %count_list%). Time frame from <span style=\"color:green\">%begin_this_week_timestamp%</span> to <span style=\"color:green\">%end_this_week_timestamp%</span>";
$invite_log_txt_show_cards_created_this_month="Show cards created this month (Total: %count_list%). Time frame from <span style=\"color:green\">%begin_this_month_timestamp%</span> to <span style=\"color:green\">%end_this_month_timestamp%</span>";
$invite_log_txt_search_card_log_with_keyword="Search card log with keyword: <strong style=\"color:green\">%keyword2%</strong> (Found: %count_list%)<br />";
$invite_log_txt_show_card_created_before_today="Show cards created %num_day% %num_what% before today (Total: %count_list%). Time frame from <span style=\"color:green\">%begin_time_before%</span> to <span style=\"color:green\">%end_today_timestamp%</span><br />";
$invite_log_txt_found_total_card_created_from_day_to_day="Found (Total: %count_list%) cards created from <span style=\"color:green\">%from_timestamp%</span> to <span style=\"color:green\">%to_timestamp%</span><br />";
$invite_log_txt_total_card_log="Total cards log: %total_cards%<br />";
$invite_log_tooltip_click_here_to_preview_this_card="Click here to preview this card";
$invite_log_tooltip_delete="Delete";
$invite_log_txt_page_title="View Invitation Card Log";
$invite_log_txt_total="Total";
$invite_log_txt_select_filter="Select filter";
$invite_log_txt_search_ecard_sent="Search ecard sent";
$invite_log_tooltip_close_hide="Close/Hide";
$invite_log_txt_list="List";
$invite_log_txt_list_all_cards_on_one_page="List all cards on 1 page";
$invite_log_txt_list_cards_created_today="List Cards Created Today";
$invite_log_txt_list_cards_created_yesterday="List Cards Created Yesterday";
$invite_log_txt_list_cards_created_this_week="List Cards Created This Week";
$invite_log_txt_list_cards_created_this_month="List Cards Created This Month";
$invite_log_button_list="List";
$invite_log_txt_search="Search";
$invite_log_txt_all_fields="All Fields";
$invite_log_txt_card_message="Card Message";
$invite_log_txt_invite_title="Invite Title";
$invite_log_txt_time_before_today="Time before today";
$invite_log_txt_view_all_cards_created="View all cards created";
$invite_log_txt_day="Day";
$invite_log_txt_week="Week";
$invite_log_txt_month="Month";
$invite_log_txt_year="Year";
$invite_log_txt_before_today="before today";
$invite_log_button_view="View";
$invite_log_txt_time_from_to="Time From - To";
$invite_log_txt_view_all_cards_created_from_to="View all cards created From: %print_mon_day_year_dropdown_from% To: %print_mon_day_year_dropdown_to%";
$invite_log_txt_tip="<strong>Tip:</strong> Click card thumbnail to view it on new window.<br /><br />";
$invite_log_txt_column_name_thumbnail="Thumbnail";
$invite_log_txt_column_name_sender_info="From";
$invite_log_txt_column_name_number_of_guests="Number of Guests";
$invite_log_txt_column_name_time_created="Time created";
$invite_log_txt_column_name_delete="Delete";
$invite_log_tooltip_select_all="Select All";
$invite_log_txt_row_per_page="Display row per page";
$invite_log_button_delete_selected="Delete Selected";
$invite_log_message_checkbox_first="You must select checkbox first. Please try again.";
$invite_log_message_confirm_to_delete="Are you sure you want to delete your selected?";

//Language for Manage Invite Add Remove page
$invite_add_remove_message_card_deleted="Card ID number %iv_id% has been deleted";
$invite_add_remove_message_cannt_delete_inactive_card="<span class=\"Error_Message\">Server can't delete Card ID number %iv_id% (%iv_thumbnail%). This card has been set inactive</span><br />";
$invite_add_remove_tooltip_card_id="Card ID#";
$invite_add_remove_txt_add_on_date="Added on date";
$invite_add_remove_txt_pay_per_card="Pay Per Card";
$invite_add_remove_tooltip_set_price_for_this_card="Set price for this card";
$invite_add_remove_tooltip_set_price_for_all_card="Set price for all cards in this category";
$invite_add_remove_txt_uncheck_membership_groups_above="(Please uncheck membership groups above)";
$invite_add_remove_txt_edit_card_message_detail="Edit card Message Detail";
$invite_add_remove_tooltip_close_hide="Close/Hide";
$invite_add_remove_txt_card_message_detail="Card Message Detail";
$invite_add_remove_tooltip_click_here_to_edit="Click here to edit";
$invite_add_remove_txt_edit_ecard_caption="Edit ecard Caption (Title)";
$invite_add_remove_txt_ecard_caption="eCard Caption (Title)";
$invite_add_remove_txt_translate_into_current_language="Translate into <span class=\"OK_Message\">%current_lang%</span>";
$invite_add_remove_txt_edit_card_keyword="Edit ecard Keyword";
$invite_add_remove_txt_enter_card_keyword="Enter Keyword (Separate keyword with comma)";
$invite_add_remove_tooltip_click_here_to_edit_card_caption="click here to edit card's Caption (Title)";
$invite_add_remove_tooltip_click_here_to_edit_card_keyword="click here to edit card Keyword";
$invite_add_remove_tooltip_click_here_to_edit_card_message_detail="click here to edit card message detail";
$invite_add_remove_tooltip_click_here_to_set_default_music="%iv_music_filename% - Click here to set music default for this card";
$invite_add_remove_tooltip_click_here_to_set_default_music_1="No Music - Click here to set music default for this card";
$invite_add_remove_tooltip_delete="Delete";
$invite_add_remove_message_updating="updating...";
$invite_add_remove_message_disable_submit_button="<br /><span class=\"Error_Message\">You must chmod 777 (or set permission read+write) for folder %cat_dir%<br />(Path: %cat_dir_path%).</span><br /><a href=\"%url%\">Click here</a> to try again.";
$invite_add_remove_txt_no_default_music="No Music";
$invite_add_remove_txt_click_here_to_select_member_group_name="Click here to select member group name";
$invite_add_remove_txt_page_title="Add/Remove Cards (Total %count_total%) - Category name";
$invite_add_remove_button_select_who_can_send_all_cards="Select who can send ALL cards in this category";
$invite_add_remove_button_set_price_for_all_cards="Set price for all cards in this category";
$invite_add_remove_txt_click_here_to_add_new_cards="Click here to add new eCards";
$invite_add_remove_txt_how_to_add_new_invitation_by_ftp="How to add new invitation cards by using FTP program?";
$invite_add_remove_txt_how_to_add_new_invitation_by_ftp_guide=<<<EOF
				<ol>
					<li>Use FTP login to your server, go inside folder <br /><strong>%cat_dir_path%</strong><br /><br /></li>
					<li>Use FTP to create new SubFolder (<strong>%cat_dir%/SubFolder</strong>) then start uploading card files to this Subfolder. View folder tree below<br /><br />
					<strong>
					[resource]<br />
					...[invitation]<br />
					......[%cat_dir%]<br />
					.........[SubFolder]<br />
					............index.html<br />
					............thumb.gif<br />
					............RGB_background_color.txt<br />
					............RGB_text_color.txt<br />
					............RGB_text_color.txt<br />
					............*.*</strong><br /><br />
					</li>
					<li>After you're done uploading your files, <a href="%url%">CLICK HERE</a> to insert your new invitation card to database.<br /><br /></li>
				</ol>
EOF;
$invite_add_remove_txt_add_new_invitation_card_by_browser="Add new Invitation Card using web browser";
$invite_add_remove_tooltip_close_hide="Close/Hide";
$invite_add_remove_txt_card_caption="Card Caption (Title)";
$invite_add_remove_txt_folder_name="Folder name";
$invite_add_remove_txt_fontname_default="Fontname Default <i>(system will create file <strong>default_fontface.txt</strong>)</i>";
$invite_add_remove_txt_fontsize_default="Fontsize Default";
$invite_add_remove_txt_system_will_create_file_fontsize_default="<i>(system will create file <strong>default_fontsize.txt</strong>)</i>";
$invite_add_remove_txt_lineheight_default="Line Height Default";
$invite_add_remove_txt_system_will_create_file_lineheight_default="<i>(system will create file <strong>default_line_height.txt</strong>)</i>";
$invite_add_remove_txt_allow_user_upload_their_photo="Allow user upload their photo ?";
$invite_add_remove_txt_no="No";
$invite_add_remove_txt_yes="Yes";
$invite_add_remove_txt_system_will_create_file_default_upload="<i>(system will create file <strong>default_upload.txt</strong>)</i>";
$invite_add_remove_txt_message_default="Message Default";
$invite_add_remove_txt_message_default_more_info="<i>(system will create file <strong>default_message.txt</strong>)</i>";
$invite_add_remove_txt_rgb_background_color="RGB Background color";
$invite_add_remove_txt_rgb_background_color_more_info="<i>(system will create file <strong>RGB_background_color.txt</strong>)</i>";
$invite_add_remove_txt_rgb_text_color="RGB text color";
$invite_add_remove_txt_rgb_text_color_more_info="<i>(system will create file <strong>RGB_text_color.txt</strong>)</i>";
$invite_add_remove_txt_upload_file_index_html="Upload file index.html";
$invite_add_remove_txt_upload_file_thumb_gif="Upload file thumb.gif";
$invite_add_remove_txt_extra_file="Extra file";
$invite_add_remove_button_add_new_invitation="Submit";
$invite_add_remove_column_name_sort="Sort";
$invite_add_remove_column_name_thumbnail="Thumbnail";
$invite_add_remove_tooltip_check_checkbox_to_enable_disable_card="Check the checkbox to Enable/Disable Card";
$invite_add_remove_column_name_set_who_can_send="Set who can send ecard";
$invite_add_remove_tooltips_edit_card_thumbnail_caption="Edit ecard thumbnail's Caption (title)";
$invite_add_remove_tooltips_edit_card_keyword="Edit ecard Keyword";
$invite_add_remove_tooltips_edit_card_message_detail="Edit ecard Message Detail";
$invite_add_remove_tooltips_set_fontname_default="Set Fontname Default";
$invite_add_remove_column_name_font_default="Font Default";
$invite_add_remove_tooltips_set_fontsize_default="Set FontSize Default";
$invite_add_remove_tooltips_set_lineheight_default="Set Line Height Default";
$invite_add_remove_tooltips_allow_user_upload_photo="Allow user upload their photo";
$invite_add_remove_tooltips_set_music_default_for_each_card="Set Music default for each card";
$invite_add_remove_tooltips_preview_card="Preview Card";
$invite_add_remove_txt_delete="Delete";
$invite_add_remove_tooltips_select_all="Select All";
$invite_add_remove_txt_row_per_page="Display row per page";
$invite_add_remove_button_delete_selected_cards="Delete selected Cards";
$invite_add_remove_txt_select_music_default="Select Music default for this card";
$invite_add_remove_tooltip_click_here_to_close="Click here to close";
$invite_add_remove_txt_select_who_can_send_cards_in_this_cate="Select who can send ALL ecards in this category";
$invite_add_remove_txt_decide_which_member_group_can_send="Please decide which member group can send all ecards in this category";
$invite_add_remove_button_set_member_group_can_send_card="Submit";
$invite_add_remove_txt_set_price_for_all_cards="Set price for all cards in this catergoy";
$invite_add_remove_button_set_price_for_ecards="Submit";
$invite_add_remove_message_card_caption_required="You must enter your card caption";
$invite_add_remove_message_card_folder_name_required="You must enter your card folder name";
$invite_add_remove_message_fontsize_default_required="You must enter Fontsize default";
$invite_add_remove_message_lineheight_default_required="You must enter Line Height default";
$invite_add_remove_message_msg_default_required="You must enter Message default";
$invite_add_remove_message_rgb_background_required="You must enter RGB Background color";
$invite_add_remove_message_rgb_text_color_required="You must enter RGB text color";
$invite_add_remove_message_upload_index_html_required="You must upload file index.html";
$invite_add_remove_message_upload_thumb_gif_required="You must upload file thumb.gif";
$invite_add_remove_message_checkbox_first="You must select checkbox first. Please try again.";
$invite_add_remove_message_confirm_to_delete="Are you sure you want to delete your selected?";
$invite_add_remove_message_at_least_one_member_group_required="You must select at least one checkbox member group";
$invite_add_remove_message_confirm_to_do="Are you sure you want to do this?";
$invite_add_remove_message_no_card_in_this_category="There is no ecard in this category";

//Language for Manage Invite page
$invite_message_new_cat_added="New category has been added";
$invite_message_cat_and_subcat_moved="Category name %cat_name_display% and all %cat_name_display%'s sub categories have been moved";
$invite_tooltip_up_one_level="Up One Level";
$invite_tooltip_click_to_open_category="Click to open category %cat_name_display%";
$invite_txt_click_to_move_category="Click here to move category name <span style=\"color:green\">%cat_name_display%</span> (and all %cat_name_display%'s sub categories) to this position";
$invite_txt_show_cat_nav_link="Main Root <img border=\"0\" alt=\"\" src=\"html/2rightarrow12.gif\" /> %show_cat_nav_no_link%";
$invite_tooltip_click_here_to_edit="Click here to edit";
$invite_message_confirm_to_delete="Are you sure you want to delete this category?\\n\\nAll ecard in this category and subcategories will be deleted as well.";
$invite_tooltip_delete_account="Delete account";
$invite_message_updating="updating...";
$invite_message_disable_submit_button="<br /><span class=\"Error_Message\">You must chmod 777 (or set permission read+write) for folder [picture]<br />(Path: %invitation_path%).</span><br /><a href=\"%cat_id%\">Click here</a> to try again.";
$invite_txt_manage_invitation_card="Manage Invitation Card";
$invite_txt_category_navigation="Category Navigation";
$invite_txt_main_root="Main Root";
$invite_txt_show_help_for_this_page="Show help for this page";
$invite_txt_visit_this_cate_usr_interface="Visit this category (User interface)";
$invite_txt_guide_to_use=<<<EOF
<ul id="help_div" style="display:none;margin-top:16px;margin-bottom:0px;line-height:18px">
	<li>Check/Uncheck checkbox to activate/deactivate category</li>
	<li>Icon <img border="0" src="html/07_icon_open_folder.gif" alt="" /> will tell you that category has subcategory</li>
	<li>Icon <img border="0" src="html/07_icon_open_folder_empty.gif" alt="" /> will tell you there is no subcategory</li>
	<li>Click icon <img border="0" src="html/07_icon_open_folder.gif" alt="" /> or <img border="0" src="html/07_icon_open_folder_empty.gif" alt="" /> to open that category</li>
	<li>Click category name (<span style="text-decoration:underline;">underline words</span>) to rename category.</li>
	<li>See more commands at bottom page.</li>
</ul>
EOF;
$invite_txt_column_name_category_name="Category Name";
$invite_txt_column_name_sub_category="#Sub category";
$invite_txt_column_name_ecards="#eCards";
$invite_txt_column_name_active_inactive="Active/Inactive";
$invite_txt_column_name_delete="Delete";
$invite_txt_column_name_sort_order="Sort Order";
$invite_txt_select_command_below="Select command below";
$invite_txt_create_new_sub_category="Create new %show_sub_or_main% category";
$invite_txt_add_new_sub_category="Add new %show_sub_or_main% category";
$invite_tooltip_close_hide="Close/Hide";
$invite_txt_category_name="Category name";
$invite_txt_folder_name="Folder name (to store ecard image files)<br />No special characters please.";
$invite_txt_path="Path";
$invite_txt_set_HTML_meta_tag_keyword="Set HTML meta tag Keyword (max=255 characters)";
$invite_txt_set_HTML_meta_tag_keyword_1="&lt;meta name=&quot;keywords&quot; content=&quot;key1,key2,key3&quot; /&gt;";
$invite_txt_set_HTML_meta_tag_description="Set HTML meta tag Description (max=255 characters)";
$invite_txt_set_HTML_meta_tag_description_1="&lt;meta name=&quot;description&quot; content=&quot;your text here&quot; /&gt;";
$invite_txt_set_HTML_meta_tag_title="Set HTML tag Title (max=255 characters)";
$invite_txt_set_HTML_meta_tag_title_1="&lt;title&gt;Your text here&lt;/title&gt;";
$invite_txt_active_this_category_now="Active this category now";
$invite_button_add_new_invite="Submit";
$invite_txt_click_here_to_edit_html_meta_tag_keyword_description_title="Click here to edit HTML Meta tag Keyword, Description and Title for this category";
$invite_txt_edit_html_meta_tag_keyword_description_title="Edit meta tag Keyword, Description, Title";
$invite_txt_edit_html_meta_tag_keyword="Edit meta tag Keyword (max=255 characters)";
$invite_txt_edit_html_meta_tag_description="Edit meta tag Description (max=255 characters)";
$invite_txt_edit_html_meta_tag_title="Edit tag Title (max=255 characters)";
$invite_txt_click_here_to_translate_into_other_languages="Click here to translate this category name <span class=\"OK_Message\">[%show_cat_name_display%]</span> into other languages";
$invite_txt_click_here_to_translate_category_name_into_other_languages="Translate category name <span class=\"OK_Message\">%show_cat_name_display%</span> into other languages";
$invite_txt_click_here_to_move_category="Click here to move category <span class=\"OK_Message\">[%show_cat_name_display%]</span>";
$invite_txt_click_here_to_add_remove_invitation_cards_in_this_category="Click here to add/remove invitation cards in this category <span class=\"OK_Message\">[%show_cat_name_display%]</span>";
$invite_tooltip_default_size="Default size";
$invite_tooltip_increase_size="Increase size";
$invite_tooltip_decrease_size="Decrease size";
$invite_tooltip_click_here_to_close="Click here to close";
$invite_txt_click_here_to_close="Click here to close";
$invite_txt_your_text_here="Your text here";
$invite_message_category_name_required="You must enter Category name";
$invite_message_category_folder_name_required="You must enter Category folder name";
$invite_message_loading="loading...";

//Language for Ecard Statistics page
$card_statistics_no_thumbnail="NO<br />THUMBNAIL";
$card_statistics_txt_page_title="View Card Sent Statistics (Total %total_cards%)";
$card_statistics_txt_tip="Tip";
$card_statistics_txt_click_card_thumbnail_to_view_on_new_windows="Click card thumbnail to view it on new window.";
$card_statistics_txt_column_name_thumbnail="Thumbnail";
$card_statistics_txt_column_name_category="Category";
$card_statistics_txt_column_name_time_to_send="Total Sent";
$card_statistics_tooltip_select_all="Select All";
$card_statistics_txt_row_per_page="Display row per page";
$card_statistics_button_delete_selected="Delete Selected";
$card_statistics_message_checkbox_first="You must select checkbox first. Please try again.";
$card_statistics_message_confirm_to_delete="Are you sure you want to delete your selected?";

//Language for eCard Log page
$ecard_log_txt_search_card_log="Search card log with keyword: <strong style=\"color:green\">%keyword2%</strong> (Found: %count_list%)<br />";
$ecard_log_txt_list_all_cards="List all cards (Total: %total_cards%)<br />";
$ecard_log_txt_show_cards_created_today="Show cards created today (Total: %count_list%). Time frame from <span style=\"color:green\">%begin_today_timestamp%</span> to <span style=\"color:green\">%end_today_timestamp%</span><br />";
$ecard_log_txt_show_cards_created_yesterday="Show cards created yesterday (Total: %count_list%). Time frame from <span style=\"color:green\">%begin_yesterday_timestamp%</span> to <span style=\"color:green\">%end_yesterday_timestamp%</span><br />";
$ecard_log_txt_show_cards_created_this_week="Show cards created this week (Total: %count_list%). Time frame from <span style=\"color:green\">%begin_this_week_timestamp%</span> to <span style=\"color:green\">%end_this_week_timestamp%</span><br />";
$ecard_log_txt_show_cards_created_this_month="Show cards created this month (Total: %count_list%). Time frame from <span style=\"color:green\">%begin_this_month_timestamp%</span> to <span style=\"color:green\">%end_this_month_timestamp%</span><br />";
$ecard_log_txt_show_cards_were_not_picked_up="Show cards that were not picked up (Total: %count_list%). <br />";
$ecard_log_txt_show_cards_created_before_today="Show cards created %num_day% %num_what% before today (Total: %count_list%). Time frame from <span style=\"color:green\">%begin_time_before%</span> to <span style=\"color:green\">%end_today_timestamp%</span><br />";
$ecard_log_txt_show_card_created_from_to="Found (Total: %count_list%) cards created from <span style=\"color:green\">%from_timestamp%</span> to <span style=\"color:green\">%to_timestamp%</span><br />";
$ecard_log_txt_total_cards_log="Total cards log: %total_cards%<br />";
$ecard_log_txt_ip2country="<br />IP2Country: <img border=\"0\" src=\"%country_flag%\" alt=\"%ip_country%\" title=\"%ip_country%\" /> <strong>%ip_country_name%</strong>";
$ecard_log_tooltip_click_here_to_preview_this_card="Click here to preview this card";
$ecard_log_txt_no_thumbnail="NO<br />THUMBNAIL";
$ecard_log_message_not_pick_up_yet="Not Picked Up Yet";
$ecard_log_tooltip_delete="Delete";
$ecard_log_txt_page_title="View Card Sent Log (Total %total_cards%)";
$ecard_log_txt_search_card_sent="Search ecard sent";
$ecard_log_txt_select_filter="Select filter";
$ecard_log_tooltip_close_hide="Close/Hide";
$ecard_log_txt_list="List";
$ecard_log_txt_list_cards_created_today="List Cards Created Today";
$ecard_log_txt_list_cards_created_yesterday="List Cards Created Yesterday";
$ecard_log_txt_list_cards_created_this_week="List Cards Created This Week";
$ecard_log_txt_list_cards_created_this_month="List Cards Created This Month";
$ecard_log_txt_list_cards_not_pick_up="List Cards Not Pickup";
$ecard_log_txt_list_all_card_one_page="List all cards on 1 page";
$ecard_log_button_list_cards="List";
$ecard_log_txt_search="Search";
$ecard_log_txt_all_fields="All Fields";
$ecard_log_txt_card_message="Card Message";
$ecard_log_txt_sender_name="Sender Name";
$ecard_log_txt_sender_email="Sender Email";
$ecard_log_txt_receiver_name="Receiver Name";
$ecard_log_txt_receiver_email="Receiver Email";
$ecard_log_txt_time_before_today="Time before today";
$ecard_log_txt_view_all_cards_created="View all cards created";
$ecard_log_txt_day="Day";
$ecard_log_txt_week="Week";
$ecard_log_txt_month="Month";
$ecard_log_txt_year="Year";
$ecard_log_txt_before_today="before today";
$ecard_log_button_view="View";
$ecard_log_txt_time_from_to="Time From - To";
$ecard_log_view_all_cards_from_to=<<<EOF
				View all cards created From: %print_mon_day_year_dropdown_from% 
				To: %print_mon_day_year_dropdown_to%
EOF;
$ecard_log_button_go="Go";
$ecard_log_txt_tip="Tip";
$ecard_log_txt_click_card_thumbnail_to_view_on_new_windows="Click card thumbnail to view it on new window.";
$ecard_log_txt_column_name_thumbnail="Thumbnail";
$ecard_log_txt_column_name_from="From";
$ecard_log_txt_column_name_to="To";
$ecard_log_txt_column_name_time_created="Time created";
$ecard_log_txt_column_name_time_pickup="Time pickup";
$ecard_log_txt_column_name_delete="Delete";
$ecard_log_tooltip_select_all="Select All";
$ecard_log_txt_display_row_per_page="Display row per page";
$ecard_log_button_delete_selected="Delete Selected";
$ecard_log_message_checkbox_first="You must select checkbox first. Please try again.";
$ecard_log_message_confirm_to_delete="Are you sure you want to delete your selected?";
$ecard_log_txt_confidential="Confidential";

//Language for Manage Ecard Add Remove page
$ecard_add_remove_message_card_has_been_deleted="Card ID number %ec_id% has been deleted";
$ecard_add_remove_message_server_cant_delete_card="Server can't delete Card ID number %ec_id% (%ec_filename%). This card has been set inactive";
$ecard_add_remove_tooltip_current_category="Current category";
$ecard_add_remove_tooltip_click_here_to_open_category="Click to open category %cat_name_display%";
$ecard_add_remove_txt_please_select_a_category_to_move="Please select a category to move selected cards ID %list_id%";
$ecard_add_remove_txt_click_here_to_move_selected_cards="Click here to MOVE selected ecards to category name <span style=\"color:green\">%cat_name_display%</span>";
$ecard_add_remove_txt_move_selected_cards_to_category="Move selected ecards to category name...(select category below)";
$ecard_add_remove_txt_category_navigation="Category Navigation";
$ecard_add_remove_txt_main_root="Main Root";
$ecard_add_remove_txt_category_name="Category Name";
$ecard_add_remove_txt_cancel_go_back="Cancel - go back to Add/Remove eCard";
$ecard_add_remove_mesage_images_have_been_moved="Your selected images have been moved to category name %cat_name_display%<br />";
$ecard_add_remove_mesage_permission_denied_cant_move_selected_cards="Permission denied. We can't move your selected ecards to new category. Please chmod 777 folder name %cat_dir%<br />";
$ecard_add_remove_txt_please_select_a_category_to_copy="Please select a category to copy selected cards ID %list_id%";
$ecard_add_remove_txt_click_here_to_copy_selected_cards="Click here to COPY selected ecards to category name <span style=\"color:green\">%cat_name_display%</span>";
$ecard_add_remove_txt_copy_selected_cards_to_category="Copy selected ecards to category name...(select category below)";
$ecard_add_remove_message_selected_images_have_been_copied="Your selected images have been copied to category name %cat_name_display%<br />";
$ecard_add_remove_txt_new_thumbnail="<strong>New Thumbnail</strong><br />(Image type must be the same with old file <strong>%ec_thumbnail%</strong>)";
$ecard_add_remove_txt_new_fullsize="<strong>New Full size</strong><br />(Image type must be the same with old file <strong>%ec_filename%</strong>)";
$ecard_add_remove_txt_edit_thumbnail_fullsize_ecards="Edit Thumbnail and Fullsize ecards";
$ecard_add_remove_button_submit_change="Submit Change";
$ecard_add_remove_message_error_card_id_will_be_skip="Error: Card ID # %i% will be skipped (New file type doesn't match with old file<br />";
$ecard_add_remove_message_you_must_select_a_category="You must select a category.";
$ecard_add_remove_tooltip_card_id_click_to_preview_fullsize="Card ID#: %ec_id% - Click to preview fullsize";
$ecard_add_remove_txt_added_on_date="Added on date";
$ecard_add_remove_txt_edit_card_detail="Edit ecard Detail";
$ecard_add_remove_tooltip_close_hide="Close/Hide";
$ecard_add_remove_txt_card_detail="eCard Detail";
$ecard_add_remove_tooltip_click_here_to_edit="Click here to edit";
$ecard_add_remove_txt_edit_card_caption="Edit ecard Caption (Title)";
$ecard_add_remove_txt_card_caption="eCard Caption (Title)";
$ecard_add_remove_txt_translate_into_language="Translate into <span class=\"OK_Message\">%language_to_translate%</span>";
$ecard_add_remove_txt_edit_card_keyword="Edit ecard Keyword";
$ecard_add_remove_txt_enter_keyword="Enter Keyword (Separate keyword with comma)";
$ecard_add_remove_tooltip_click_here_to_edit_card_caption="click here to edit card's Caption (Title)";
$ecard_add_remove_tooltip_click_here_to_edit_card_keyword="click here to edit card Keyword";
$ecard_add_remove_tooltip_click_here_to_edit_card_detail="click here to edit card Detail";
$ecard_add_remove_tooltip_click_here_to_set_default_poem="click here to set default Message";
$ecard_add_remove_tooltip_click_here_to_set_default_applet="%ec_applet% - Click here to set java applet default for this card";
$ecard_add_remove_tooltip_click_here_to_set_default_applet_icon_not_found="%ec_applet% - Icon not found - Click here to set java applet default for this card";
$ecard_add_remove_tooltip_click_here_to_set_default_applet_no_java="No Java - Click here to set java applet default for this card";
$ecard_add_remove_message_cannt_apply_applet_to_flash_card="You cannot apply java applet to FLASH card";
$ecard_add_remove_tooltip_click_here_to_set_skin_background_default="%ec_skin% - Click here to set skin background default for this card";
$ecard_add_remove_tooltip_click_here_to_set_skin_background_default_1="%cf_default_skin% - Click here to set skin background default for this card";
$ecard_add_remove_tooltip_click_here_to_set_stamp_default="%ec_stamp_filename% - Click here to set stamp default for this card";
$ecard_add_remove_tooltip_click_here_to_set_music_default="%ec_music_filename% - Click here to set music default for this card";
$ecard_add_remove_tooltip_click_here_to_set_music_default_no_default_music="No Music - Click here to set music default for this card";
$ecard_add_remove_tooltip_delete="Delete";
$ecard_add_remove_mesage_updating="updating...";
$ecard_add_remove_mesage_disable_submit_button_message="<br /><span class=\"Error_Message\">You must chmod 777 (or set permission read+write) for folder [%cat_dir%]<br />(Path: %physical_cat_dir%).</span><br /><a href=\"%url%\">Click here</a> to try again.";
$ecard_add_remove_txt_no_java_applet="No Java applet";
$ecard_add_remove_txt_no_poem="No Message";
$ecard_add_remove_tooltip_icon_not_found="Icon not found";
$ecard_add_remove_txt_default="[Default]";
$ecard_add_remove_txt_no_default_music="No Music";
$ecard_add_remove_message_load_thumbnail_full_size="Load thumbnail %aThumb% and full size image %file2% dir name %cat_name_display% to database";
$ecard_add_remove_message_remove_card_id_from_database="Remove eCard ID # %val% from database (%ec_thumbnail% or %ec_filename% not found inside folder %cat_dir%)";
$ecard_add_remove_txt_add_remove_ecards_total="Add/Remove eCards (Total %count_total%) - Category name";
$ecard_add_remove_txt_select_who_can_send_all_cards="Select who can/can't send ALL ecards in this category";
$ecard_add_remove_txt_set_price_for_all_card_in_this_category="Set price for all cards in this category";
$ecard_add_remove_txt_click_here_to_add_new_ecards="Click here to add new eCards";
$ecard_add_remove_txt_how_to_add_new_ecards_by_ftp="How to add new eCards by using FTP program?";
$ecard_add_remove_txt_how_to_add_new_ecards_by_ftp_guide=<<<EOF
				<ol>
					<li>Use FTP login to your server, go inside folder <br /><strong>%cat_dir_physical_path%</strong><br /><br /></li>
					<li>Start uploading thumbnail + full size image files to folder <strong>%cat_dir%</strong>. You must name your thumbnail and full size image files like this:<br /><br />thumbnail : <strong>xxx_thumb.gif</strong> (or .jpg, .png) - example: <strong>1_thumb.gif</strong><br />full size: <strong>xxx.gif</strong> (or .jpg, .png, .sfw, .mp4) - example: <strong>1.sfw</strong> (flash ecard)<br /><br /><strong>Please Note:</strong> If you don't have your thumbnail images ready then just upload full size images (example: 123.jpg), eCardMAX will auto create Thumbnails for you (it will create 123_thumb.jpg). (eCardMAX <span class="Error_Message">will not</span> create thumbnail if full size card is a flash movie .swf). To set thumbnail width and height, use <strong>System Configuration</strong><br /><br /></li>
					<li>After you're done uploading your files, <a href="%url%">CLICK HERE</a> to insert your new ecards to database.<br /><br /></li>
				</ol>
EOF;
$ecard_add_remove_txt_add_new_ecards_by_youtube="Add new eCards using youtube";
$ecard_add_remove_txt_note_ecardmax_youtube="Note: Copy and paste YouTube links to one or more fields below(e.g: http://www.youtube.com/watch?v=58cFOPjsGj8).";
$ecard_add_remove_txt_youtube_link="Youtube Link";

$ecard_add_remove_txt_add_new_ecards_by_browser="Add new eCards using web browser";
$ecard_add_remove_txt_note_ecardmax_will_auto_create_thumbnail="Note: eCardMAX will auto create thumbnails for you if you don't input thumbnail files.";
$ecard_add_remove_txt_thumbnail="Thumbnail";
$ecard_add_remove_txt_thumbnail_allow="(allow <strong>xxx_thumb.gif</strong> or <strong>.jpg</strong> or <strong>.png</strong>)";
$ecard_add_remove_txt_fullsize="Fullsize";
$ecard_add_remove_txt_fullsize_allow="(allow <strong>xxx.gif</strong> or <strong>.jpg</strong> or <strong>.png</strong> or <strong style=\"color:green\">.swf</strong> or <strong style=\"color:green\">.mp4</strong> or <strong style=\"color:red\">.html</strong>)";
$ecard_add_remove_button_add_new_card="Submit";
$ecard_add_remove_column_name_sort="Sort";
$ecard_add_remove_column_name_thumbnail="Thumbnail";
$ecard_add_remove_tooltip_checkbox_to_enable_disable_card="Check the checkbox to Enable/Disable Card";
$ecard_add_remove_column_name_embed_msg="Embed Msg";
$ecard_add_remove_tooltip_checkbox_to_set_feature_card="Check the checkbox to set Feature card";
$ecard_add_remove_column_name_select_who_can_send_ecard="Select who can send ecard";
$ecard_add_remove_tooltip_edit_card_thumbnail_caption="Edit ecard thumbnail's Caption (title)";
$ecard_add_remove_tooltip_edit_card_keyword="Edit ecard Keyword";
$ecard_add_remove_tooltip_edit_card_detail="Edit ecard Detail";
$ecard_add_remove_tooltip_edit_default_poem="Set default Message";
$ecard_add_remove_tooltip_set_java_applet_default_for_each_card="Set Java applet default for each card";
$ecard_add_remove_tooltip_set_skin_background_default_for_each_card="Set Skin background default for each card";
$ecard_add_remove_tooltip_set_stamp_default_for_each_card="Set Stamp default for each card";
$ecard_add_remove_tooltip_set_music_default_for_each_card="Set Music default for each card";
$ecard_add_remove_tooltip_preview_card="Preview Card";
$ecard_add_remove_column_name_delete="Delete";
$ecard_add_remove_tooltip_select_all="Select All";
$ecard_add_remove_txt_row_per_page="Display row per page";
$ecard_add_remove_txt_bulk_action="Bulk Action";
$ecard_add_remove_txt_delete_selected="Delete selected ecards";
$ecard_add_remove_txt_move_selected="Move selected ecards to other category";
$ecard_add_remove_txt_copy_selected="Copy selected ecards to other category";
$ecard_add_remove_txt_change_selected="Change selected ecards thumbnail";
$ecard_add_remove_tooltip_click_here_to_close="Click here to close";
$ecard_add_remove_txt_select_java_applet_default_for_this_card="Select Java applet default for this card";
$ecard_add_remove_txt_select_skin_default_for_this_card="Select Skin default for this card";
$ecard_add_remove_txt_select_stamp_default_for_this_card="Select Stamp default for this card";
$ecard_add_remove_txt_select_poem_default_for_this_card="Select Message default for this card";
$ecard_add_remove_txt_select_music_default_for_this_card="Select Music default for this card";
$ecard_add_remove_txt_select_who_can_send_all_ecards_in_this_category="Select who can/can't send ALL ecards in this category";
$ecard_add_remove_message_please_decide_which_member_group_can_send_all_ecards="Please decide which member group can/can't send all ecards in this category";
$ecard_add_remove_button_set_membergroup_all_ecard="They can send";
$ecard_add_remove_button_unset_membergroup_all_ecard="They can't send";
$ecard_add_remove_txt_set_price_for_all_card_in_this_category="Set price for all cards in this catergoy";
$ecard_add_remove_button_set_price_all_ecard="Submit";
$ecard_add_remove_message_at_least_one_fullsize_required="You must input at least 1 fullsize ecard file.";
$ecard_add_remove_message_at_least_one_youtube_link_required="You must input at least 1 youtube link.";
$ecard_add_remove_message_checkbox_first="You must select checkbox first. Please try again.";
$ecard_add_remove_message_confirm_to_delete_selected="Are you sure you want to delete your selected?";
$ecard_add_remove_message_confirm_to_move_selected="Are you sure you want to move your selected ecards to other category?";
$ecard_add_remove_message_confirm_to_copy_selected="Are you sure you want to copy your selected ecards to other category?";
$ecard_add_remove_message_confirm_to_change_selected="Are you sure you want to change your selected ecards thumbnail/fullsize image?";
$ecard_add_remove_message_must_select_at_least_one_checkbox="You must select at least one checkbox member group";
$ecard_add_remove_message_confirm_to_do_this="Are you sure you want to do this?";
$ecard_add_remove_message_there_is_no_ecard="There is no ecard in this category";

// Language for Manage Ecard Page
$ecard_manage_message_new_category_added="New category has been added";
$ecard_manage_message_server_cant_delete_files="Server can't delete files %ec_thumbnail% + %ec_filename%. This card is still in database and has been set inactive (Use FTP to delete them)";
$ecard_manage_message_category_name_deleted="Category name %cat_name_display% has been deleted";
$ecard_manage_message_cant_delete_category_folder_name="can't delete category folder name %ec_cat_dir%. This category is still in database and has been set inactive (Use FTP to delete it)";
$ecard_manage_message_category_and_subcate_removed="Category name %cat_name_display% and all %cat_name_display%'s sub categories have been moved";
$ecard_manage_tooltip_up_one_level="Up One Level";
$ecard_manage_tooltip_click_to_open_category="Click to open category %cat_name_display%";
$ecard_manage_txt_click_to_move_category_and_subcat_to_position="Click here to move category name <span style=\"color:green\">%cat_name_display%</span> (and all %cat_name_display%'s sub categories) to this position";
$ecard_manage_txt_main_root="Main Root";
$ecard_manage_tooltip_click_to_set_category_as_birthday="Click here to set %cat_name_display% as Birthday category";
$ecard_manage_tooltip_click_to_edit="Click here to edit";
$ecard_manage_message_confirm_to_delete="Are you sure you want to delete this category?\\n\\nAll ecard in this category and subcategories will be deleted as well.";
$ecard_manage_tooltip_delete_account="Delete account";
$ecard_manage_message_updating="updating...";
$ecard_manage_message_disable_submit_button="<br /><span class=\"Error_Message\">You must chmod 777 (or set permission read+write) for folder [picture]<br />(Path: %picture_path%).</span><br /><a href=\"%url%\">Click here</a> to try again.";
$ecard_manage_page_title="Manage eCard";
$ecard_manage_category_navigation="Category Navigation";
$ecard_manage_main_root="Main Root";
$ecard_manage_show_help_for_this_page="Show help for this page";
$ecard_manage_visit_this_category_usr_interface="Visit this category (User interface)";
$ecard_manage_guide=<<<EOF
<ul id="help_div" style="display:none;margin-top:16px;margin-bottom:0px;line-height:18px">
	<li>Check/Uncheck checkbox to activate/deactivate category</li>
	<li>Click birthday cake <img border="0" alt="Set Birthday category" title="Set Birthday category" src="html/07_icon_set_birthday_cat_ac.gif" /> to set Birthday category (eCardMAX will pick ecard in this category and auto send it to registered users when their birthday is near).</li>
	<li>Icon <img border="0" src="html/07_icon_open_folder.gif" alt="" /> will tell you that category has subcategory</li>
	<li>Icon <img border="0" src="html/07_icon_open_folder_empty.gif" alt="" /> will tell you there is no subcategory</li>
	<li>Click icon <img border="0" src="html/07_icon_open_folder.gif" alt="" /> or <img border="0" src="html/07_icon_open_folder_empty.gif" alt="" /> to open that category</li>
	<li>Click category name (<span style="text-decoration:underline;">underline words</span>) to rename category.</li>
	<li>See more commands at bottom page.</li>
</ul>
EOF;
$ecard_manage_column_name_category_name="Category Name";
$ecard_manage_column_name_sub_category="#Sub category";
$ecard_manage_column_name_ecard="#eCards";
$ecard_manage_column_name_set_birthday_category="Set Birthday category";
$ecard_manage_column_name_active_inactive="Active/Inactive";
$ecard_manage_column_name_delete="Delete";
$ecard_manage_column_name_sort_order="Sort Order";
$ecard_manage_txt_select_command_below="Select command below";
$ecard_manage_txt_create_new_category="Create new %show_sub_or_main% category";
$ecard_manage_txt_add_new_category="Add new %show_sub_or_main% category";
$ecard_manage_tool_close_hide="Close/Hide";
$ecard_manage_txt_category_name="Category name";
$ecard_manage_txt_folder_name_to_store_ecard="Folder name (to store ecard image files)<br />No special characters please.";
$ecard_manage_txt_path="Path";
$ecard_manage_txt_set_HTML_meta_tag_keyword="Set HTML meta tag Keyword (max=255 characters)";
$ecard_manage_txt_set_HTML_meta_tag_description="Set HTML meta tag Description (max=255 characters)";
$ecard_manage_txt_set_HTML_meta_tag_title="Set HTML tag Title (max=255 characters)";
$ecard_manage_txt_your_text_here="Your text here";
$ecard_manage_txt_active_this_category_now="Active this category now";
$ecard_manage_txt_category_image="Category Image";
$ecard_manage_txt_click_here_to_edit_html_meta_tag_keyword="Click here to edit HTML Meta tag Keyword, Description and Title for this category";
$ecard_manage_txt_edit_html_meta_tag_keyword_description_title="Edit meta tag Keyword, Description, Title";
$ecard_manage_txt_edit_html_meta_tag_keyword="Edit meta tag Keyword (max=255 characters)";
$ecard_manage_txt_edit_html_meta_tag_description="Edit meta tag Description (max=255 characters)";
$ecard_manage_txt_edit_html_meta_tag_title="Edit tag Title (max=255 characters)";
$ecard_manage_txt_click_here_to_translate_to_other_language="Click here to translate this category name <span class=\"OK_Message\">[%show_cat_name_display%]</span> into other languages";
$ecard_manage_txt_translate_to_other_language="Translate category name <span class=\"OK_Message\">%show_cat_name_display%</span> into other languages";
$ecard_manage_txt_click_to_move_category="Click here to move category <span class=\"OK_Message\">[%show_cat_name_display%]</span>";
$ecard_manage_txt_click_to_add_remove_ecard_in_this_category="Click here to add/remove ecard in this category <span class=\"OK_Message\">[%show_cat_name_display%]</span>";
$ecard_manage_tooltip_default_size="Default size";
$ecard_manage_tooltip_increase_size="Increase size";
$ecard_manage_tooltip_descrease_size="Decrease size";
$ecard_manage_tooltip_click_here_to_close="Click here to close";
$ecard_manage_message_category_name_required="You must enter Category name";
$ecard_manage_message_category_folder_name_required="You must enter Category folder name";
$ecard_manage_message_loading="loading...";

//Language for Price Per Card page
$ecard_ppc_message_new_price_added="New price has been added.";
$ecard_ppc_message_amount_entered_invalid="The amount number that you enter is invalid. Note: You can't add the same price";
$ecard_ppc_tooltip_click_to_edit="Click to edit";
$ecard_ppc_txt_buy_now_link="Buy now link";
$ecard_ppc_txt_buy_now_title="Buy now title";
$ecard_ppc_message_confirm_to_delete_amount="Are you sure you want to delete this amount?\\n\\nAll cards were set to this amount will be reset to $0.00.";
$ecard_ppc_txt_page_title="Set Price Pay Per Card";
$ecard_ppc_txt_click_here_to_add_new_price="Click here to add new price";
$ecard_ppc_txt_fill_out_the_form_below_to_add_new_price="Fill out the form below to add new price";
$ecard_ppc_tooltip_close_hide="Close/Hide";
$ecard_ppc_txt_new_price="New Price";
$ecard_ppc_txt_buy_now_from_2checkout="(example: Buy now from 2Checkout)";
$ecard_ppc_txt_enter_2checkout_buy_now_link="(example: enter 2CheckOut buy now link here)";
$ecard_ppc_txt_to_use_another_currency_on_payment="(To use another currency on payment,<br>please change the value <a href=\"http://www.xe.com/iso4217.php\" target=\"_blank\">currency_code=EUR</a><br>in the URL)";
$ecard_ppc_txt_click_here_to_auto_create_Paypal_buy_now_link="<a href=\"javascript:void(0)\" onclick=\"CreatePayPalLink('1')\">Click here</a> to auto create PayPal buy now link (base on the new price above and your paypal primary email address)";
$ecard_ppc_txt_buy_now_from_paypal="(example: Buy now from Paypal)";
$ecard_ppc_txt_enter_paypal_buy_now_link="(example: enter Paypal buy now link here)";
$ecard_ppc_txt_click_here_to_auto_create_Paypal_buy_now_link_1="<a href=\"javascript:void(0)\" onclick=\"CreatePayPalLink('2')\">Click here</a> to auto create PayPal buy now link (base on the new price above and your paypal primary email address)";
$ecard_ppc_txt_button_add_new_price="Submit";
$ecard_ppc_txt_column_name_edit_price="Edit Price";
$ecard_ppc_txt_column_name_buy_title_link_1="Buy Title 1 + Link 1";
$ecard_ppc_txt_column_name_buy_title_link_2="Buy Title 2 + Link 2";
$ecard_ppc_txt_column_name_delete="Delete";
$ecard_ppc_message_new_price_required="You must enter new price";
$ecard_ppc_message_paypal_primary_email_required="You must enter your PayPal primary email. Click OK button to go to page System Configuration - click tab Gold Version Settings to enter your PayPal email";
$ecard_ppc_message_buy_now_title_required="You must enter Buy now title";
$ecard_ppc_message_buy_now_link_required="You must enter Buy now link";

//Language for Member View Album page
$member_view_album_txt_no_thumbnail="No Thumbnail<br />click here<br />to view full size";
$member_view_album_txt_photo_infos="Photo ID number: %id%<br />File name: %ec_filename%<br />Attr: %fullsize_attr%<br />File size: %fullsize_filesize% bytes";
$member_view_album_tooltip_delete_member_photo="Delete member photo";
$member_view_album_tooltip_click_to_view_fullsize="Click to view fullsize";
$member_view_album_txt_title="Title";
$member_view_album_txt_click_here_to_play="Click here to play";
$member_view_album_txt_audio_infos="Audio ID number: %id%<br />File name: %music_filename%<br />File size: %fullsize_filesize% bytes";
$member_view_album_tooltip_delete_member_audio_file="Delete member audio file";
$member_view_album_txt_click_here_to_listen="Click to listen";
$member_view_album_txt_click_here_to_view="Click here to view";
$member_view_album_txt_poem_infos="Poem ID number: %id%<br />Author: <strong>%poem_author%</strong><br />Count: %poemsize% characters";
$member_view_album_tooltip_delete_member_poem="Delete member Message";
$member_view_album_txt_author="Author";
$member_view_album_txt_show_member_photos_title="Show Member Photos";
$member_view_album_txt_show_member_photos="Show member photos";
$member_view_album_txt_show_member_audio_files="Show member audio files";
$member_view_album_txt_show_member_poems="Show member Message";
$member_view_album_txt_total="total";
$member_view_album_txt_column_name_photo_thumbnail="Photo thumbnail";
$member_view_album_txt_column_name_username_id="Username";
$member_view_album_txt_column_name_file_detail="File Detail";
$member_view_album_txt_column_name_delete="Delete";
$member_view_album_txt_tooltip_select_all="Select All";
$member_view_album_txt_row_per_page="Display row per page";
$member_view_album_txt_button_delete_selected="Delete Selected";
$member_view_album_txt_tooltip_click_to_close="Click here to close";
$member_view_album_txt_tooltip_close_hide="Close/Hide";
$member_view_album_txt_click_to_close="Click here to close";
$member_view_album_message_loading="loading...";
$member_view_album_message_checkbox_first="You must select checkbox first. Please try again.";
$member_view_album_message_confirm_to_delete="Are you sure you want to delete your selected?";
$member_view_album_txt_show_member_audio_files_title="Show Member Audio Files";
$member_view_album_txt_column_name_audio_title="Audio Title";
$member_view_album_txt_column_name_user_name_id="Username";
$member_view_album_txt_show_member_poems_title="Show Member Messages";
$member_view_album_txt_column_name_poem_title="Message Title";
$member_view_album_txt_column_name_poem_detail="Detail";
$member_view_album_txt_view_member_poem="View Member Message";

//Language for Member Display Inactive Account page
$member_display_inactive_acc_message_member_account_updated="Member account has been updated";
$member_display_inactive_acc_txt_all_members_not_login_6_months="List all members not login in 6 month (Total: %total_member%)<br />";
$member_display_inactive_acc_txt_all_members_not_login_before_today="List all members not login in %num_day% %num_what% before today (Total: %count_list%).<br />";
$member_display_inactive_acc_txt_ip2country="IP2Country";
$member_display_inactive_acc_txt_account_will_be_suspended="%date_end_acct%<br />(will be suspended)";
$member_display_inactive_acc_message_confirm_to_suspend_delete_account="Are you sure you want to Undo suspend/delete this account?";
$member_display_inactive_acc_tooltip_undo_suspend_delete_account="Undo Suspend/Delete account";
$member_display_inactive_acc_txt_account_will_be_deleted="%date_end_acct%<br />(will be deleted)";
$member_display_inactive_acc_txt_account_will_be_downgraded="%date_end_acct%<br />(will be down grade to free basic acct)";
$member_display_inactive_acc_tooltip_delete_account="Delete account";
$member_display_inactive_acc_txt_male="Male";
$member_display_inactive_acc_txt_female="Female";
$member_display_inactive_acc_txt_single="Single";
$member_display_inactive_acc_txt_marriage="Married";
$member_display_inactive_acc_txt_divorced="Divorced";
$member_display_inactive_acc_txt_widowed="Widowed";
$member_display_inactive_acc_txt_paypercard="PayPerCard";
$member_display_inactive_acc_txt_upgrade_acc="Upgrade Acct";
$member_display_inactive_acc_txt_account_information_detail="Account Information Detail";
$member_display_inactive_acc_tooltip_close_hide="Close/Hide";
$member_display_inactive_acc_txt_account_id_number="Account id number";
$member_display_inactive_acc_txt_user_name_id="Username";
$member_display_inactive_acc_txt_user_password="User password";
$member_display_inactive_acc_txt_email="Email";
$member_display_inactive_acc_txt_total_cards_sent="Total cards sent";
$member_display_inactive_acc_txt_number_of_time_login="Number of time login";
$member_display_inactive_acc_txt_date_sign_up="Date sign up";
$member_display_inactive_acc_txt_last_login="Last login";
$member_display_inactive_acc_txt_first_last_name="First last name";
$member_display_inactive_acc_txt_phone_number="Phone number";
$member_display_inactive_acc_txt_address="Address";
$member_display_inactive_acc_txt_city="City";
$member_display_inactive_acc_txt_state="State";
$member_display_inactive_acc_txt_zipcode="Zipcode";
$member_display_inactive_acc_txt_country="Country";
$member_display_inactive_acc_txt_birthday="Birthday (MM/DD)";
$member_display_inactive_acc_txt_gender="Gender";
$member_display_inactive_acc_txt_marital_status="Marital Status";
$member_display_inactive_acc_txt_member_order_history="Member Order History";
$member_display_inactive_acc_txt_column_name_date="Date";
$member_display_inactive_acc_txt_column_name_order="Order #";
$member_display_inactive_acc_txt_column_name_amount="Amount";
$member_display_inactive_acc_txt_column_name_type="Type";
$member_display_inactive_acc_txt_column_name_method="Method";
$member_display_inactive_acc_tooltip_click_to_view_detail="Click to view detail";
$member_display_inactive_acc_txt_username_id="Username";
$member_display_inactive_acc_tooltip_sub_account="sub account";
$member_display_inactive_acc_txt_ip2country="IP2Country";
$member_display_inactive_acc_txt_page_title="Show Inactive Accounts (not login in 6 months) (total %total_member%)";
$member_display_inactive_acc_txt_button_set_member_group_for_all_users="Set Member Group for all users";
$member_display_inactive_acc_txt_search_member_account="Search member account";
$member_display_inactive_acc_txt_select_filter="Select filter";
$member_display_inactive_acc_tooltip_close_hide="Close/Hide";
$member_display_inactive_acc_txt_list="List";
$member_display_inactive_acc_txt_list_account_not_login_6_months_ASC="List accounts not login in 6 months on 1 page (sort by Username ASC)";
$member_display_inactive_acc_txt_list_account_not_login_6_months_DESC="List accounts not login in 6 months on 1 page (sort by Username DESC)";
$member_display_inactive_acc_txt_list_account_not_login_6_months_by_member_group_ASC="List accounts not login in 6 months on 1 page (sort by member group id ASC)";
$member_display_inactive_acc_txt_list_account_not_login_6_months_by_member_group_DESC="List accounts not login in 6 months on 1 page (sort by member group id DESC)";
$member_display_inactive_acc_txt_button_list="List";
$member_display_inactive_acc_txt_time_before_today="Time before today";
$member_display_inactive_acc_txt_view_all_accounts_not_login="View all Accounts not login in";
$member_display_inactive_acc_txt_day="Day";
$member_display_inactive_acc_txt_week="Week";
$member_display_inactive_acc_txt_month="Month";
$member_display_inactive_acc_txt_year="Year";
$member_display_inactive_acc_txt_button_view="View";
$member_display_inactive_acc_txt_tip="Tip";
$member_display_inactive_acc_txt_click_account_username_to_view_detail="Click account Username to view account detail.";
$member_display_inactive_acc_txt_column_name_account_information="Account Information";
$member_display_inactive_acc_txt_column_name_edit_member_group="Edit Member Group";
$member_display_inactive_acc_txt_column_name_account_status="Account Status";
$member_display_inactive_acc_txt_column_name_delete="Delete";
$member_display_inactive_acc_tooltip_select_all="Select All";
$member_display_inactive_acc_txt_row_per_page="Display row per page";
$member_display_inactive_acc_txt_button_suspend_delete_selected="Suspend/Delete Selected";
$member_display_inactive_acc_txt_suspend_delete_selected="Suspend / Delete Account";
$member_display_inactive_acc_txt_account_tobe_suspended_deleted_downgraded=<<<EOF
<br />Account will be<br /><br />
<input type="radio" name="action" id="action_suspend" value="0" checked="checked" onclick="myaction='0';" /> suspended <br /><br />
<input type="radio" name="action" id="action_delete" value="1" onclick="myaction='1';" /> deleted <br /><br />
<input type="radio" name="action" id="action_down_grade" value="2" onclick="myaction='2';" /> down grade to free basic acct <br /><br />on date %print_mon_day_year_dropdown%<br /><br />
<input type="button" value="Submit" class="button" onclick="DeleteAccount();" /><br /><br />
EOF;
$member_display_inactive_acc_txt_set_member_group_for_all_users="Set member group for all users";
$member_display_inactive_acc_txt_select_member_group_to_move_members=<<<EOF
<br />This action will move all members to one Member Group.<br /><br />Select member group below then click Submit button <br /><br />
					%show_member_group_all_user%
					<br /><br /><input type="button" value="Submit" class="button" onclick="SetMemberGroupAllUser();" /><br /><br />
EOF;
$member_display_inactive_acc_message_member_group_name_required="You must select member group name";
$member_display_inactive_acc_message_confirm_to_do_it="Are you sure you want to do it?";
$member_display_inactive_acc_message_checkbox_first="You must select checkbox first. Please try again.";
$member_display_inactive_acc_message_confirm_to_delete_suspend_selected="Are you sure you want to suspend/delete selected account?";

//Language for Member Display page
$member_display_message_member_account_updated="Member account has been updated<br />";
$member_display_txt_list_all_members="List all members (Total: %total_member%)<br />";
$member_display_txt_show_member_sign_up_today_time_frame_from_before_today_to_today="Show members sign up today (Total: %count_list%). Time frame from <span style=\"color:green\">%begin_today_timestamp%</span> to <span style=\"color:green\">%end_today_timestamp%</span><br />";
$member_display_txt_show_member_sign_up_yesterday_time_frame_from_before_yesterday_to_yesterday="Show members sign up yesterday (Total: %count_list%). Time frame from <span style=\"color:green\">%begin_yesterday_timestamp%</span> to <span style=\"color:green\">%end_yesterday_timestamp%</span><br />";
$member_display_txt_show_member_sign_up_this_week_time_frame_from_before_this_week="Show members sign up this week (Total: %count_list%). Time frame from <span style=\"color:green\">%begin_this_week_timestamp%</span> to <span style=\"color:green\">%end_this_week_timestamp%</span><br />";
$member_display_txt_show_member_sign_up_this_week_time_frame_from_before_this_month="Show members sign up this month (Total: %count_list%). Time frame from <span style=\"color:green\">%begin_this_month_timestamp%</span> to <span style=\"color:green\">%end_this_month_timestamp%</span><br />";
$member_display_txt_show_member_have_sub_account="Show members have sub accounts (Total: %count_list%) <br />";
$member_display_txt_show_member_requested_cancel_account="Show members requested cancel their account (Total: %count_list%)<br />";
$member_display_txt_show_member_male_only="Show Male members only (Total: %count_list%)<br />";
$member_display_txt_show_member_female_only="Show Female members only (Total: %count_list%)<br />";
$member_display_txt_search_member_account_with_keyword="Search member account with keyword: <strong style=\"color:green\">%keyword2%</strong> (Found: %count_list%)<br />";
$member_display_txt_show_member="Show members sign up %num_day% %num_what% before today (Total: %count_list%). Time frame from <span style=\"color:green\">%begin_time_before%</span> to <span style=\"color:green\">%end_today_timestamp%</span><br />";
$member_display_txt_show_member_sign_up="Found (Total: %count_list%) members sign up from <span style=\"color:green\">%from_timestamp%</span> to <span style=\"color:green\">%to_timestamp%</span><br />";
$member_display_txt_total_member="Total members: %total_member%<br />";
$member_display_txt_ip2country="IP2Country";
$member_display_txt_account_will_suspended="%date_end_acct%<br />(will be suspended)";
$member_display_message_confirm_to_suspend_delete_account="Are you sure you want to Undo suspend/delete this account?";
$member_display_tooltip_undo_suspend_delete_account="Undo Suspend/Delete account";
$member_display_txt_account_will_deleted="%date_end_acct%<br />(will be deleted)";
$member_display_txt_account_will_downgraded="%date_end_acct%<br />(will be down grade to free basic acct)";
$member_display_tooltip_delete_account="Delete account";
$member_display_txt_male="Male";
$member_display_txt_female="Female";
$member_display_txt_single="Single";
$member_display_txt_married="Married";
$member_display_txt_divorced="Divorced";
$member_display_txt_wivorced="Widowed";
$member_display_txt_paypercard="PayPerCard";
$member_display_txt_upgrade_acct="Upgrade Acct";
$member_display_tooltip_click_to_view_detail="Click to view detail";
$member_display_txt_username_id="Username";
$member_display_tooltip_sub_account="sub account";
$member_display_txt_click_here_to_select_member_group="Click here to select member group name";
$member_display_txt_page_title="Show Member Accounts (total %total_member%)";
$member_display_txt_button_set_member_group_for_all_users="Set Member Group for all users";
$member_display_txt_search_member_account="Search member account";
$member_display_txt_select_filter="Select filter";
$member_display_tooltip_close_hide="Close/Hide";
$member_display_txt_list="List";
$member_display_txt_list_all_accounts_one_page_ASC="List all accounts on 1 page (sort by Username ASC)";
$member_display_txt_list_all_accounts_one_page_DESC="List all accounts on 1 page (sort by Username DESC)";
$member_display_txt_list_all_accounts_by_member_group_one_page_ASC="List all accounts on 1 page (sort by member group id ASC)";
$member_display_txt_list_all_accounts_by_member_group_one_page_DESC="List all accounts on 1 page (sort by member group id DESC)";
$member_display_txt_list_new_account_today="List New Account Sign Up Today";
$member_display_txt_list_new_account_yesterday="List New Account Sign Up Yesterday";
$member_display_txt_list_new_account_this_week="List New Account Sign Up This Week";
$member_display_txt_list_new_account_this_month="List New Account Sign Up This Month";
$member_display_txt_list_users_have_sub_account="List Users have Sub Account";
$member_display_txt_list_users_request_cancel_account="List User requested cancel account";
$member_display_txt_list_users_male_only="List User Male Only";
$member_display_txt_list_users_female_only="List User Female Only";
$member_display_txt_button_list="List";
$member_display_txt_search="Search";
$member_display_txt_all_fields="All Fields";
$member_display_txt_user_id_number="User ID Number";
$member_display_txt_user_name_id="Username";
$member_display_txt_user_password="User Password";
$member_display_txt_user_email="User Email";
$member_display_txt_user_last_first_name="User Last First Name";
$member_display_txt_user_city="User City";
$member_display_txt_user_zip_code="User Zip code";
$member_display_txt_user_country="User Country";
$member_display_txt_button_search_user="Search User";
$member_display_txt_time_before_today="Time before today";
$member_display_txt_view_all_accounts_created="View all Accounts created";
$member_display_txt_day="Day";
$member_display_txt_week="Week";
$member_display_txt_month="Month";
$member_display_txt_year="Year";
$member_display_txt_before_today="before today";
$member_display_txt_button_view="View";
$member_display_txt_time_from_to="Time From - To";
$member_display_txt_view_all_accounts_created_from_to="View all Accounts created From:";
$member_display_txt_view_all_accounts_created_from_to_1="To:";
$member_display_txt_button_go="Go";
$member_display_txt_tip="Tip";
$member_display_txt_click_account_to_view_detail="Click account Username to view account detail.";
$member_display_txt_column_name_account_information="Account Information";
$member_display_txt_column_name_edit_member_group="Edit Member Group";
$member_display_txt_column_name_account_status="Account Status";
$member_display_txt_column_name_delete="Delete";
$member_display_txt_tooltip_select_all="Select All";
$member_display_txt_row_per_page="Display row per page";
$member_display_txt_button_suspend_delete_selected="Suspend/Delete Selected";
$member_display_txt_suspend_delete_selected="Suspend / Delete Account";
$member_display_txt_upgrade_package="Upgrade package";
$member_display_txt_check_to_suspend_delete=<<<EOF
<br />Account will be<br /><br />
<input type="radio" name="action" id="action_suspend" value="0" checked="checked" onclick="myaction='0';" /> suspended <br /><br />
<input type="radio" name="action" id="action_delete" value="1" onclick="myaction='1';" /> deleted <br /><br />
<input type="radio" name="action" id="action_down_grade" value="2" onclick="myaction='2';" /> down grade to free basic acct <br /><br />on date %print_mon_day_year_dropdown%<br /><br />
<input type="button" value="Submit" class="button" onclick="DeleteAccount();" /><br /><br />
EOF;
$member_display_txt_set_member_group_for_all_users="Set member group for all users";
$member_display_txt_this_action_will_move_all_members_to_one_member_group=<<<EOF
<<br />This action will move all members to one Member Group.<br /><br />Select member group below then click Submit button <br /><br />
%show_member_group_all_user%
EOF;
$member_display_message_member_group_name_required="You must select member group name";
$member_display_message_confirm_to_do_it="Are you sure you want to do it?";
$member_display_message_checkbox_first="You must select checkbox first. Please try again.";
$member_display_message_confirm_to_suspend_delete_account="Are you sure you want to suspend/delete selected account?";
$member_display_message_confirm_to_delete_account="Are you sure you want to delete selected account?";

//Language for Member Group page
$member_group_txt_maximum_recipient="Maximum Recipient (when user send <strong>ecard</strong>)";
$member_group_txt_show_number_recipient_default="Show number recipient default(when user send <strong>ecard</strong>)";
$member_group_txt_maximum_recipient_per_hour="Maximum Recipient per hour (prevent spam - <strong>ecard</strong>)";
$member_group_txt_zero_is_unlimited="(0 is unlimited)";
$member_group_txt_maximum_recipient_per_day="Maximum Recipient per day (prevent spam - <strong>ecard</strong>)";
$member_group_txt_maximum_recipient_when_user_send_invitation_card="Maximum Recipient (when user send <strong>invitation card</strong>)";
$member_group_txt_group_permission="Group permission";
$member_group_txt_show_number_recipient_default_when_user_send_invitation="Show number recipient default (when user send <strong>invitation card</strong>)";
$member_group_txt_maximum_recipient_per_hour_invitation="Maximum Recipient per hour (prevent spam - <strong>invitation </strong>)";
$member_group_txt_maximum_recipient_per_day_invitation="Maximum Recipient per day (prevent spam - <strong>invitation </strong>)";
$member_group_message_updating="updating...";
$member_group_txt_allow_users_in_this_group_to_send_ecards="Allow users in this group to send ecards";
$member_group_txt_check_this_box_to_show_watermark_image_this_group="Check this box will show watermark image to user in this group";
$member_group_txt_show_banner_ads_this_group="Show banner ads to all users in this group";
$member_group_txt_allow_to_play_games="Play Games";
$member_group_txt_allow_to_use_media_grabber="Use Media Grabber";
$member_group_txt_allow_to_search_ecard_invitation="Search Ecard/Invitation card";
$member_group_txt_allow_to_send_future_date="Send Ecard/Invitation Card future date";
$member_group_txt_allow_to_rate_card="Rate Ecard";
$member_group_txt_allow_to_use_preview_fullsize="Use feature &quot;Preview full size image&quot;";
$member_group_txt_allow_to_use_my_account="Use member tool My Account";
$member_group_txt_allow_to_use_address_book="Use member tool Address Book";
$member_group_txt_allow_to_use_reminder="Use member tool Reminder";
$member_group_txt_allow_to_use_calendar="Use member tool Calendar";
$member_group_txt_allow_to_use_my_album="Use member tool My Album";
$member_group_txt_allow_to_use_favorite="Use member tool Favorite";
$member_group_txt_allow_to_use_history="Use member tool History";
$member_group_txt_allow_to_use_birthday_alert="Use member tool Birthday Alert";
$member_group_txt_allow_to_create_2_sub_accounts="Allow main account to create free 2 sub accounts";
$member_group_txt_allow_to_send_birthday_card_to_group="Send birthday card to group";
$member_group_txt_membership_payment_amount="Membership payment amount";
$member_group_txt_buy_now_title_1="Buy now title 1";
$member_group_txt_buy_now_link_1="Buy now link 1 (example: enter 2CheckOut buy now link here)";
$member_group_txt_buy_now_title_2="Buy now title 2";
$member_group_txt_buy_now_link_2="Buy now link 2 (example: enter Paypal buy now link here)";
$member_group_txt_forever="Forever";
$member_group_txt_month="month";
$member_group_txt_months="months";
$member_group_txt_year="year";
$member_group_txt_years="years";
$member_group_txt_set_time_auto_expired="Set time auto expired";
$member_group_button_delete="Delete";
$member_group_message_confirm_to_delete_group="Are you sure you want to delete this group?\\n\\nAll members in this group will be moved to group Free Basic Membership Account.";
$member_group_tooltip_click_to_edit_group_title="Click to edit Group title";
$member_group_page_title="View/Edit member groups";
$member_group_txt_click_here_to_create_new_group="Click here to create new Group";
$member_group_txt_fill_out_the_form_to_create_group="Fill out the form below to create new member group";
$member_group_tooltip_close_hide="Close/Hide";
$member_group_txt_group_title="Group Title";
$member_group_txt_check_all="check all";
$member_group_txt_uncheck_all="uncheck all";
$member_group_txt_user_have_to_pay_this_amount_to_become_member="Users have to pay this amount to become a member of this group";
$member_group_txt_example_buy_from_2checkout_paypal="example: <strong>Buy now from 2Checkout</strong> or <strong>Buy now from PayPal</strong>";
$member_group_txt_buy_now_link_1_1="Buy now link 1";
$member_group_txt_buy_now_link_instruction="Enter <strong>2CheckOut</strong> or <strong>PayPal</strong> buy now link here<br><br>(To use another currency on payment,<br>please change the value <a href=\"http://www.xe.com/iso4217.php\" target=\"_blank\">currency_code=EUR</a><br>in the URL)";
$member_group_txt_click_here_to_auto_create_paypal_link="<a href=\"javascript:void(0)\" onclick=\"CreatePayPalLink('1')\">Click here</a> to auto create PayPal buy now link (base on membership payment amount above and your paypal primary email address. <b>Please check again if the business email in the generated link is the one for paypal payment.</b>)";
$member_group_txt_buy_now_title_2_1="Buy now title 2 (Optional)";
$member_group_txt_buy_now_link_2_1="Buy now link 2 (Optional)";
$member_group_txt_click_here_to_auto_create_paypal_link_1="<a href=\"javascript:void(0)\" onclick=\"CreatePayPalLink('2')\">Click here</a> to auto create PayPal buy now link (base on membership payment amount above and your paypal primary email address. <b>Please check again if the business email in the generated link is the one for paypal payment.</b>)";
$member_group_txt_set_time_auto_expired_after_user_sign_up="Set time auto expired after user sign up";
$member_group_button_submit="Submit";
$member_group_txt_group_title="Group title";
$member_group_txt_column_name_group_title="Set permission";
$member_group_txt_column_name_set_permission="Set permission";
$member_group_txt_column_name_delete_group="Delete Group";
$member_group_tooltip_click_here_to_close="Click here to close";
$member_group_txt_calendar="Calendar";
$member_group_tooltip_close_hide="Close/Hide";
$member_group_txt_enter_length_of_each_billing_cycle="Enter Length of each billing cycle";
$member_group_txt_days="Day(s)";
$member_group_txt_weeks="Week(s)";
$member_group_txt_months="Month(s)";
$member_group_txt_years="Year(s)";
$member_group_button_create_paypal_links="Create PayPal Link";
$member_group_message_membership_payment_amount_required="You must enter Membership payment amount";
$member_group_message_paypal_primary_email_required="You must enter your PayPal primary email.Click OK button to go to page System Configuration - click tab Gold Version Settings to enter your PayPal email";
$member_group_message_group_title_required="You must enter Group Title";
$member_group_maximum_recipient_required="You must enter Maximum Recipient";
$member_group_maximum_recipient_per_hour_required="You must enter Maximum Recipient per hour";
$member_group_maximum_recipient_per_day_required="You must enter Maximum Recipient per day";
$member_group_buy_now_title_1_required="You must enter Buy now title 1";
$member_group_buy_now_link_1_required="You must enter Buy now link 1";

//Language for Database page
$database_txt_export_database="Export Database";
$database_txt_export_database_to_text_files=" Export Database to text files";
$database_txt_this_tool_export_your_database_to_txt_files="This tool will export (back up) your database to .txt files<br /><br /><a href=index.php?step=admin_database&what=export_now>Click here</a> to BACK UP now";
$database_txt_import_database="Import Database";
$database_txt_import_text_files_to_database=" Import text files to Database";
$database_txt_this_tool_will_import_txt_files_to_database="This tool will import (upload) your .txt text files to database<br /><br /><a href=index.php?step=admin_database&what=import_now>Click here</a> to IMPORT now";
$database_message_export_table_successfully="Export table <b>%tb%</b> <font color=green>OK!</font><br>";
$database_message_export_warning="For security reason please copy all of text file inside folder 'admin/sql_backup' to your local computer and remove the back up files on the server";
$database_message_no_table_in_your_database="ERROR: There is no table in your database!";
$database_message_query_execute_failure="%insert_query%executed failure! <br>";
$database_message_import_file_ok="import file <strong>%tb_list%.txt</strong> <span class=OK_Message>OK!</span> <br />";
$database_message_import_file_fail="import file <strong>%tb_list%.txt</strong> <span class=Error_Message>fail!</span> <br />";
$database_txt_pease_chmod_files_folders="Please use FTP to chmod 777 folder <b>admin/sql_backup</b> and try again.<br><a href=http://ecardmax.com/index.php?step=chmod>Click here</a> to get instruction how to chmod file and folder";
$database_txt_please_create_folder="Please use FTP to create new folder name <b>admin/sql_backup</b>.<br>This is a path to <b>admin/sql_backup</b>: %ecard_root%/admin/sql_backup<br>Then use FTP to chmod 777 folder <b>sql_backup</b>.<br><a href=http://ecardmax.com/index.php?step=chmod>Click here</a> to get instruction how to chmod file and folder";

//Language for Cellphone Carier page
$cellphone_carier_message_new_carier_has_been_added="New carrier has been added.";
$cellphone_carier_message_new_carier_has_been_added_1="New carriers %count_ca% have been added.";
$cellphone_carier_tooltip_click_here_to_edit="Click here to edit";
$cellphone_carier_tooltip_delete="Delete";
$cellphone_carier_message_updating="updating...";
$cellphone_carier_message_mysql_table_stamp_has_been_updated="Mysql table Stamp has been updated";
$cellphone_carier_txt_page_title="Manage Cell Phone Carrier";
$cellphone_carier_txt_total="Total";
$cellphone_carier_txt_click_here_to_add_new_carrier="Click here to add new carrier";
$cellphone_carier_txt_add_new_carrier="Add new Carrier";
$cellphone_carier_tooltip_close_hide="Close/Hide";
$cellphone_carier_txt_carier_name="Carrier Name";
$cellphone_carier_txt_carier_domain_name="Carrier Domain name";
$cellphone_carier_txt_10_digit_phone_number="[10-digit phone number]";
$cellphone_carier_txt_active_this_carrier="Active this carrier";
$cellphone_carier_txt_add_new_carriers_bulk="Add new Carriers (Bulk)";
$cellphone_carier_txt_how_to_input_list_of_carriers="Enter the list of Carrier Name and Carrier Domain by using CVS format (see sample below)<br /><br /><span class=\"OK_Message\">Carrier Name|Carrier Domain</span><br />Verizon|vtext.com<br />T-Mobile|tmomail.net";
$cellphone_carier_txt_active_those_carrier="Active those carriers";
$cellphone_carier_txt_tips="Tips:";
$cellphone_carier_txt_tips_detail=<<<EOF
<ul>
	<li>Check the checkbox to enable carrier. Uncheck the checkbox will disable that carrier.</li>
	<li>Click carrier name, carrier domain to edit it</li>
</ul>
EOF;
$cellphone_carier_txt_column_name_carrier_name="Carrier Name";
$cellphone_carier_txt_column_name_carrier_domain="Carrier Domain";
$cellphone_carier_txt_column_name_enable_disable="Enable/Disable";
$cellphone_carier_txt_column_name_delete="Delete";
$cellphone_carier_tooltip_select_all="Select All";
$cellphone_carier_txt_display_row_per_page="Display row per page";
$cellphone_carier_button_delete_selected="Delete Selected";
$cellphone_carier_message_carrier_name_required="You must enter carrier name";
$cellphone_carier_message_carrier_domain_name_required="You must enter carrier domain name";
$cellphone_carier_message_list_of_carriers_required="You must enter the list of carriers";
$cellphone_carier_message_checkbox_first_required="You must select checkbox first. Please try again.";
$cellphone_carier_message_confirm_to_delete="Are you sure you want to delete your selected?";

//Language for Ban user page
$ban_user_message_new_email_has_been_added_to_ban_list="New email %email% has been added to ban list";
$ban_user_message_new_ip_has_been_added_to_ban_list="New IP %email% has been added to ban list";
$ban_user_txt_ip2country="IP2Country";
$ban_user_txt_reason="Reason";
$ban_user_tooltip_click_here_to_edit="Click here to edit";
$ban_user_txt_ban_ip_email="Ban IP/Email";
$ban_user_txt_total="Total";
$ban_user_txt_click_here_to_add_new_ip_email_to_ban_list="Click here to add new IP/Email to ban list";
$ban_user_txt_add_new_ip_email_ban_list="Add new IP/Email to ban list";
$ban_user_tooltip_close_hide="Close/Hide";
$ban_user_txt_input_ip_email_instruction="Enter an IP or Email address<br />(Line by line)<br /><br />Example:<br />111.222.*.*<br />myname@email.com<br />";
$ban_user_txt_length_of_ban="Length of ban";
$ban_user_txt_forever="Forever";
$ban_user_txt_day="day";
$ban_user_txt_week="week";
$ban_user_txt_month="month";
$ban_user_txt_year="year";
$ban_user_tooltip_unban="UnBan";
$ban_user_message_mysql_table_quote_updated="Mysql table quote has been updated";
$ban_user_txt_until_to="Until to...";
$ban_user_txt_reason_to_ban="Reason for ban:";
$ban_user_button_submit="Submit";
$ban_user_txt_tips="Tips";
$ban_user_txt_tips_instruction=<<<EOF
<ul>
	<li><strong>Ban IP Address:</strong> will prevent a user reaching any part of your ecard site.</li>
	<li><strong>Ban Email Address:</strong> will prevent a user sign up new account or send ecard by using that email.</li>
</ul>
EOF;
$ban_user_txt_column_name_icon="Icon";
$ban_user_txt_column_name_ip_email="IP/Email";
$ban_user_txt_column_name_length_of_ban="Length of ban (MM/DD/YYYY)";
$ban_user_txt_column_name_unban="UnBan";
$ban_user_tooltip_select_all="Select All";
$ban_user_txt_display_row_per_page="Display row per page";
$ban_user_txt_search_ip_email="Search IP/Email";
$ban_user_button_search="Search";
$ban_user_button_unban_selected="Unban Selected";
$ban_user_tooltip_click_here_to_close="Click here to close";
$ban_user_txt_calendar="Calendar";
$ban_user_tooltip_close_hide="Close/Hide";
$ban_user_message_list_of_ip_email_required="You must enter the list of IP or Email address";
$ban_user_message_length_of_ban_required="You must enter length of ban";
$ban_user_message_reason_to_ban_required="You must enter reason for ban";
$ban_user_message_checkbox_first_required="You must select checkbox first. Please try again.";
$ban_user_message_confirm_to_unban="Are you sure you want to unban your selected IP/Email?";
$ban_user_message_active_server_will_not_send_anything="<strong style=\"color:red\">Active</strong><br />Server will not send anything<br />to this email";
$ban_user_message_pending_user_still_receive_ecard_and_email="<strong style=\"color:green\">Pending</strong><br />User still receive ecard<br />and other email</span>";

//Language for View Black List page
$view_black_list_message_new_email_added="New email %email% has been added";
$view_black_list_message_email_not_added="Email %email% has not been added";
$view_black_list_txt_active="Active";
$view_black_list_txt_pending="Pending";
$view_black_list_txt_active_server_will_not_send_anything="<strong style=\"color:red\">Active</strong><br />Server will not send anything<br />to this email";
$view_black_list_txt_pending_user_still_receive_ecard_and_email="<strong style=\"color:green\">Pending</strong><br />User still receive ecard<br />and other email";
$view_black_list_tooltip_delete="Delete";
$view_black_list_message_table_black_list_updated="Mysql table quote has been updated";
$view_black_list_txt_page_title="View Black List Email";
$view_black_list_txt_total="Total";
$view_black_list_txt_click_here_to_add_new_email_to_black_list="Click here to add new email to black list";
$view_black_list_txt_add_new_email_to_black_list="Add new email to black list";
$view_black_list_tooltip_close_hide="Close/Hide";
$view_black_list_txt_enter_email_address_by_line="Enter email address line by line";
$view_black_list_button_submit="Submit";
$view_black_list_txt_notes="Notes:";
$view_black_list_txt_notes_detail=<<<EOF
<ul>
	<li>All emails found in this list which were marked <strong style="color:red">Active</strong> will be blocked. System will not send any email message or ecard to them.</li>
	<li>Emails which were marked <strong style="color:green">Pending</strong> will not be blocked.</li>
	<li>If users don't want to receive any email from your site, they can add their email to this list (via user interface). Admin can add/remove their email here.</li>
</ul>
EOF;
$view_black_list_txt_column_name_icon="Icon";
$view_black_list_txt_column_name_email="Email";
$view_black_list_txt_column_name_more_info="More Info";
$view_black_list_txt_column_name_more_status="Status";
$view_black_list_txt_column_name_more_remove="Remove";
$view_black_list_tooltip_select_all="Select All";
$view_black_list_txt_display_row_per_page="Display row per page";
$view_black_list_button_delete_selected="Delete Selected";
$view_black_list_message_email_required="You must enter your email";
$view_black_list_message_checkbox_first_required="You must select checkbox first. Please try again.";
$view_black_list_message_confirm_to_delete="Are you sure you want to delete your selected?";
$view_black_list_message_active_server_will_not_send_anything="<strong style=\"color:red\">Active</strong><br />Server will not send anything<br />to this email";
$view_black_list_message_pending_user_still_receive_ecard_and_email="<strong style=\"color:green\">Pending</strong><br />User still receive ecard<br />and other email</span>";

//Language for Admin System Configuration page
$system_config_page_title="System Configuration";
$system_config_txt_general="General";
$system_config_txt_tell_friend_birthday_alert="Tell Friend & Birthday Alert";
$system_config_txt_ecard_setting="eCard Settings";
$system_config_txt_invitation_ecard_setting="Invitation Card Settings";
$system_config_txt_styles="Styles";
$system_config_txt_watermark_settings="Watermark Settings";
$system_config_txt_member_album="Member Album";
$system_config_txt_gold_version_settings="Gold Version Settings";
$system_config_txt_webmaster_email="Webmaster email";
$system_config_txt_your_site_title="Your site title";
$system_config_txt_currency_symbol="Currency symbol";
$system_config_txt_currency_symbol_note="Please use UTF-8 encoding";
$system_config_txt_search_engine_friendly_url="Search Engine Friendly URL";
$system_config_txt_search_engine_friendly_url_note=<<<EOF
<i><font size="1" color="red">.htaccess must be supported to use this feature. <a href="../check-seo.html" target="_blank">Click here</a> to check. If you get the 404 error code (Page Not Found), that mean .htaccess is not supported. Then turn off this feature.<br>If you move the site to somewhere, then change the value of RewriteBase in .htaccess file by <b>RewriteBase %RewriteBase%</b></font></i>
EOF;
$system_config_txt_enable_twitter="Enable <strong>Twitter?</strong>";
$system_config_txt_enable_twitter_note=<<<EOF
<i><font size="1" color="red">Twitter works only on PHP version 5.x. Please disable twitter if using PHP version 4.x. <b>Your version of PHP is: %php_version%</b></font></i>
EOF;
$system_config_txt_twitter_consumer_key="<strong>Twitter</strong> consumer key";
$system_config_txt_twitter_consumer_secret="<strong>Twitter</strong> consumer secret";
$system_config_txt_twitter_authorize_url="<strong>Twitter</strong> authorize URL";
$system_config_txt_facebook_api_key="<strong>Facebook</strong> API key";
$system_config_txt_facebook_secret="<strong>Facebook</strong> secret";
$system_config_txt_facebook_card_category="<strong>Facebook</strong> card category";
$system_config_txt_facebook_card_specified_category="<strong>Facebook</strong> card specified category";
$system_config_txt_facebook_card_category_popular_cards="Popular cards";
$system_config_txt_facebook_card_category_top_rated_cards="Top rated cards";
$system_config_txt_facebook_card_category_new_cards="New cards";
$system_config_txt_facebook_card_category_specified_category="Specified category";
$system_config_txt_type_of_header_email_to_show="When the receiver receives email notify to pickup ecard, what do you like to show in From Name and From Email field?";
$system_config_txt_sender_name_email="Sender's name + Sender's email";
$system_config_txt_site_title_email="Site's title + Site's email";
$system_config_txt_site_title_email_instruction=<<<EOF
If you select &quot;Site's title and Site's email&quot; then enter your site email address.<strong>Please note</strong>: For example if your domain is <strong>www.ecardmax.com</strong>, then Site Email Address should be something like this: <strong>info@ecardmax.com</strong>, <strong>service@ecardmax.com (end with your domain)</strong>
EOF;
$system_config_txt_send_email_using_SMTP_server="Send email using SMTP server?";
$system_config_txt_use_smtp_server="Yes - Use SMTP Server";
$system_config_txt_use_sendmail="Use Sendmail";
$system_config_txt_email_content_type="Email content type";
$system_config_txt_content_type_html="HTML";
$system_config_txt_content_type_plain_text="Plain text";
$system_config_txt_if_using_smtp_enter_smtp_account="If using SMTP to send mail then enter SMTP account below";
$system_config_txt_smtp_host="SMTP Host";
$system_config_txt_smtp_port="SMTP Port";
$system_config_txt_smtp_authentication="SMTP using Authentication ?";
$system_config_txt_smtp_authentication_yes="Yes";
$system_config_txt_smtp_authentication_no="No";
$system_config_txt_hide_email_for_confidential="Hide email for confidential";
$system_config_txt_hide_email_confidential_yes="Yes";
$system_config_txt_hide_email_confidential_no="No";
$system_config_txt_smtp_authentication_username="SMTP Username";
$system_config_txt_smtp_authentication_password="SMTP Password";
$system_config_txt_set_meta_tag_description_homepage="Set meta tag <strong>Description</strong> for home page";
$system_config_txt_set_meta_tag_keyword_homepage="Set meta tag <strong>Keyword</strong> for home page (separate keyword with comma <strong>,</strong> )";
$system_config_txt_turn_horizontal_banner="Turn Horizontal banner";
$system_config_txt_turn_horizontal_banner_on="On";
$system_config_txt_turn_horizontal_banner_off="Off";
$system_config_txt_turn_vertical_banner="Turn Vertical banner";
$system_config_txt_turn_vertical_banner_on="On";
$system_config_txt_turn_vertical_banner_off="Off";
$system_config_txt_allow_users_to_give_comment_for_ecard="Allow users to give comment for ecard?";
$system_config_txt_allow_users_to_give_comment_for_ecard_yes="Yes";
$system_config_txt_allow_users_to_give_comment_for_ecard_no="No";
$system_config_txt_disable_right_click="Disable right click (use JavaScript) to prevent user copy your images?";
$system_config_txt_disable_right_click_yes="Yes";
$system_config_txt_disable_right_click_no="No";
$system_config_txt_enable_black_list_feature="Enable Black list feature. User can subscribe their email to this list and never receive any email from your site again.";
$system_config_txt_enable_black_list_feature_yes="Yes";
$system_config_txt_enable_black_list_feature_no="No";
$system_config_txt_show_verify_image_code_when_sign_up_account="Show Verify Image Code when user sign up new account?";
$system_config_txt_show_verify_image_code_when_sign_up_account_note=<<<EOF
<i><font size="1" color="red">This function only works when GD library is supported by your server. Please turn off if GD is not supported.</font></i>
EOF;
$system_config_txt_show_verify_image_code_when_sign_up_account_yes="Yes";
$system_config_txt_show_verify_image_code_when_sign_up_account_no="No";
$system_config_txt_new_account_email_verification="New account verification by email?";
$system_config_txt_new_account_email_verification_yes="Yes";
$system_config_txt_new_account_email_verification_no="No";
$system_config_txt_use_easy_edit_template_feature=<<<EOF
Use <strong>easy edit template feature</strong>. Select Yes, program will print on the screen this image
		<img border="0" src="%ecard_url%/templates/page_info.gif" alt="" style="vertical-align: middle;" /> 
		. Click on this image will tell you which html file name you need to 
		edit (helpful while you design your site), select No to turn this 
		feature off or when you go live your site
EOF;
$system_config_txt_use_easy_edit_template_feature_yes="Yes";
$system_config_txt_use_easy_edit_template_feature_no="No";
$system_config_txt_date_format="Date format";
$system_config_txt_date_format_mmddyyyy="MM DD YYYY";
$system_config_txt_date_format_ddmmyyyy="DD MM YYYY";
$system_config_txt_date_format_yyyyddmm="YYYY DD MM";
$system_config_txt_date_format_yyyymmdd="YYYY MM DD";
$system_config_txt_summer_time_dst_effect="Summer Time/DST is in effect:";
$system_config_txt_summer_time_dst_effect_yes="Yes";
$system_config_txt_summer_time_dst_effect_no="No";
$system_config_txt_set_server_time_zone="Set server Time Zone";
$system_config_txt_number_of_thumbnail_images_per_row="Number of thumbnail images per row";
$system_config_txt_number_of_row_per_page="Number of row per page";
$system_config_txt_hoteditor_keycode="HotEditor Key code";
$system_config_txt_ecardmax_keycode="eCardMAX Key code";
$system_config_txt_ephotohunt_game_keycode="ePhotoHunt Game Key code";
$system_config_txt_ecardmax_java_applet_keycode="eCardMAX Java Applet Key code";
$system_config_txt_dseffect_keycode="<a target=\"_blank\" href=\"http://www.dseffects.com\" class=Menu_Link>DSEffect</a> Key code (visit their website to buy Key code)";
$system_config_txt_anfy_keycode="<a target=\"_blank\" href=\"http://www.anfyteam.com\" class=Menu_Link>Anfy</a> Key code (visit their website to buy Key code)";
$system_config_txt_please_do_not_remove_ecardmax_copyright="Please do not remove eCardMAX copyright footer unless you buy Gold version.";
$system_config_txt_total_number_of_recipients="Total Number of Recipients";
$system_config_txt_set_default_number_of_recipient_name_email="Set default number of Recipient Name and Recipient Email fields will display";
$system_config_txt_set_ecard_max_width_automatically_resize="Set eCard (photo) max width <br /> eCardMAX will auto resize ecard if original image width &gt; max width";
$system_config_txt_set_thumbnail_width_height_for_resize="<strong>eCardMAX will auto create thumbnail image</strong> when webmaster upload full size ecards to system, or when members upload their photos to their album. Please set thumbnail image size width &amp; height below";
$system_config_txt_thumbnail_image_width="Thumbnail image width";
$system_config_txt_thumbnail_image_height="Thumbnail image height";
$system_config_txt_show_random_quote_at_homepage="Show Random Quote at homepage?";
$system_config_txt_show_random_quote_at_homepage_yes="Yes";
$system_config_txt_show_random_quote_at_homepage_no="No";
$system_config_txt_set_number_quote_to_show="If <strong>Yes</strong>, then set number of Quote you want to show";
$system_config_txt_show_feature_cards_at_homepage="Show Feature cards at homepage?";
$system_config_txt_show_feature_cards_at_homepage_yes="Yes";
$system_config_txt_show_feature_cards_at_homepage_No="No";
$system_config_txt_set_number_feature_cards_to_show="If <strong>Yes</strong>, then set number of Feature cards you want to show";
$system_config_txt_show_most_popular_cards_at_homepage="Show Most Popular cards table at homepage?";
$system_config_txt_show_most_popular_cards_at_homepage_yes="Yes";
$system_config_txt_show_most_popular_cards_at_homepage_no="No";
$system_config_txt_set_number_most_popular_cards_to_show="If <strong>Yes</strong>, then set number of Most Popular cards you want to show";
$system_config_txt_show_top_rated_cards_at_homepage="Show Top Rated cards table at homepage?";
$system_config_txt_show_top_rated_cards_at_homepage_yes="Yes";
$system_config_txt_show_top_rated_cards_at_homepage_no="No";
$system_config_txt_set_number_top_rated_cards_to_show="If <strong>Yes</strong>, then set number of Top Rated cards you want to show";
$system_config_txt_show_newest_cards_at_homepage="Show Newest cards table at homepage";
$system_config_txt_show_newest_cards_at_homepage_yes="Yes";
$system_config_txt_show_newest_cards_at_homepage_no="No";
$system_config_txt_set_number_newest_cards_to_show="If <strong>Yes</strong>, then set number of Newest cards you want to show";
$system_config_txt_show_random_cards_at_homepage="Show Random cards table at homepage?";
$system_config_txt_show_random_cards_at_homepage_yes="Yes";
$system_config_txt_show_random_cards_at_homepage_no="No";
$system_config_txt_set_number_random_cards_to_show="If <strong>Yes</strong>, then set number of Random cards you want to show";
$system_config_txt_card_expire_after="Card expired after";
$system_config_txt_days="days";
$system_config_txt_set_all_cards_for_member_only_when_uploading_new_cards="Set all cards for members only when you upload new cards?";
$system_config_txt_set_all_cards_for_member_only_when_uploading_new_cards_yes="Yes";
$system_config_txt_set_all_cards_for_member_only_when_uploading_new_cards_no="No";
$system_config_txt_maximum_font_file_member_can_upload="Maximum Font file member can upload. Set 0 for unlimited";
$system_config_txt_invitation_card_expired_after="Invitation Card expired after";
$system_config_txt_set_default_template="Set default Template. You can create new template, store them inside folder [templates]";
$system_config_txt_set_default_language="Set default Language (Languages files are stored inside folder [languages])";
$system_config_txt_show_holiday_event_homepage="Show Holiday/Events box at homepage?";
$system_config_txt_show_holiday_event_homepage_yes="Yes";
$system_config_txt_show_holiday_event_homepage_no="No";
$system_config_txt_show_toolbar_button_select_image_effect="Show toolbar button select image effect, select skin background, select stamp,.. when user send card?";
$system_config_txt_show_toolbar_button_select_image_effect_yes="Yes";
$system_config_txt_show_toolbar_button_select_image_effect_no="No";
$system_config_txt_show_button_select_java="Show button <strong>Select Java</strong>";
$system_config_txt_show_button_select_java_yes="Yes";
$system_config_txt_show_button_select_java_no="No";
$system_config_txt_show_button_select_stamp="Show button <strong>Select Stamp</strong>";
$system_config_txt_show_button_select_stamp_yes="Yes";
$system_config_txt_show_button_select_stamp_no="No";
$system_config_txt_show_button_select_skin_background="Show button <strong>Select Skin Background</strong>";
$system_config_txt_show_button_select_skin_background_yes="Yes";
$system_config_txt_show_button_select_skin_background_no="No";
$system_config_txt_show_button_select_poem="Show button <strong>Select Message</strong>";
$system_config_txt_show_button_select_poem_yes="Yes";
$system_config_txt_show_button_select_poem_no="No";
$system_config_txt_show_button_select_music="Show button <strong>Select Music</strong>";
$system_config_txt_show_button_select_music_yes="Yes";
$system_config_txt_show_button_select_music_no="No";
$system_config_txt_show_button_card_info="Show button <strong>Card info</strong>";
$system_config_txt_show_button_card_info_yes="Yes";
$system_config_txt_show_button_card_info_no="No";
$system_config_txt_show_button_card_printer="Show button <strong>Card printer</strong>";
$system_config_txt_show_button_card_printer_yes="Yes";
$system_config_txt_show_button_card_printer_no="No";
$system_config_txt_show_rate_star_icon="Show rate star icon";
$system_config_txt_show_rate_star_icon_yes="Yes";
$system_config_txt_show_rate_star_icon_no="No";
$system_config_txt_show_thumbnail_toolbar="Show thumbnail toolbar";
$system_config_txt_show_thumbnail_toolbar_yes="Yes";
$system_config_txt_show_thumbnail_toolbar_no="No";
$system_config_txt_show_preview_card_icon="Show preview card icon <img border=\"0\" src=\"html/icon_view_fullsize.gif\" alt=\"\" style=\"vertical-align: middle;\" /> on the thumbnail toolbar? Use TAB Members/Set member group to ON/OFF this icon";
$system_config_txt_show_goto_category_icon="Show goto category icon <img border=\"0\" src=\"html/icon_goto_category.gif\" alt=\"\" style=\"vertical-align: middle;\" /> on the thumbnail toolbar?";
$system_config_txt_show_goto_category_icon_yes="Yes";
$system_config_txt_show_goto_category_icon_no="No";
$system_config_txt_show_free_card_icon="Show free card icon <img border=\"0\" src=\"html/icon_free_card.gif\" alt=\"\" style=\"vertical-align: middle;\" /> on the thumbnail toolbar?";
$system_config_txt_show_free_card_icon_yes="Yes";
$system_config_txt_show_free_card_icon_no="No";
$system_config_txt_show_new_icon="Show new icon <img border=\"0\" src=\"html/icon_new_card.gif\" alt=\"\" style=\"vertical-align: middle;\" /> on the thumbnail toolbar?";
$system_config_txt_show_new_icon_yes="Yes";
$system_config_txt_show_new_icon_no="No";
$system_config_txt_show_new_icon_change_number_day="If <strong>Yes</strong>, by default, eCardMAX will show new icon next to each cards which were added 3 days before today. You can change the number here";
$system_config_txt_days_before_today="days before today";
$system_config_txt_show_card_type="Show card type";
$system_config_txt_show_card_type_or="or";
$system_config_txt_show_card_type_yes="Yes";
$system_config_txt_show_card_type_no="No";
$system_config_txt_show_thubmail_card_caption="Show thumbnail card caption (title)?";
$system_config_txt_show_thubmail_card_caption_yes="Yes";
$system_config_txt_show_thubmail_card_caption_no="No";
$system_config_txt_show_pay_per_card_amount="Show pay per card amount?";
$system_config_txt_show_pay_per_card_amount_yes="Yes";
$system_config_txt_show_pay_per_card_amount_no="No";
$system_config_txt_enable_watermark="Enable watermark?";
$system_config_txt_enable_watermark_yes="Yes";
$system_config_txt_enable_watermark_no="No";
$system_config_txt_enable_watermark_note=<<<EOF
<i><font size="1" color="red">This function only works when GD library is supported by your server. Please turn off if GD is not supported. You can go to <b>tab General</b> to check GD info.</font></i>
EOF;
$system_config_txt_watermark_position="Watermark position";
$system_config_txt_watermark_position_top_left="Top Left";
$system_config_txt_watermark_position_top_center="Top Center";
$system_config_txt_watermark_position_top_right="Top Right";
$system_config_txt_watermark_position_middle_left="Middle Left";
$system_config_txt_watermark_position_middle_center="Middle Center";
$system_config_txt_watermark_position_middle_right="Middle Right";
$system_config_txt_watermark_position_bottom_left="Bottom Left";
$system_config_txt_watermark_position_bottom_center="Bottom Center";
$system_config_txt_watermark_position_bottom_right="Bottom Right";
$system_config_txt_title_over_the_ecard="Tile over the ecard";
$system_config_txt_watermark_opacity="Watermark Opacity (number from 1 to 100) - Default = 30";
$system_config_txt_path_to_your_watermark_image=<<<EOF
Path to your watermark image: <strong>%ecard_url%/templates/watermark_logo.png</strong><br /><br /><img border="0" alt="" src="%ecard_url%/templates/watermark_logo.png" /><br /><br />To use your own watermark logo, you must create file <strong>watermark_logo.png</strong> (image type must be PNG) - with <strong>white background color</strong> and save it to folder <strong>/tempalates/watermark_logo.png</strong>
EOF;
$system_config_txt_allow_members_to_upload_their_own_images="Allow members to upload their own images?";
$system_config_txt_allow_members_to_upload_their_own_images_yes="Yes";
$system_config_txt_allow_members_to_upload_their_own_images_no="No";
$system_config_txt_allow_members_to_upload_their_own_images_set_total_images="If <strong>yes,</strong> then set total Images member can upload - Set zero for no limit";
$system_config_txt_maximum_image_file_size_for_user_to_upload="Maximum Image file size for user to upload";
$system_config_txt_bytes="bytes";
$system_config_txt_allow_members_to_upload_their_own_music_files="Allow members to upload their own music files?";
$system_config_txt_allow_members_to_upload_their_own_music_files_yes="Yes";
$system_config_txt_allow_members_to_upload_their_own_music_files_no="No";
$system_config_txt_allow_members_to_upload_their_own_music_files_set_total_music="If <strong>yes</strong>, then set total Music files member can upload - Set zero for no limit";
$system_config_txt_maximum_music_file_size_to_upload="Maximum Music file size for user to upload";
$system_config_txt_allow_members_to_upload_their_own_stamp_files="Allow members to upload their own stamp files?";
$system_config_txt_allow_members_to_upload_their_own_stamp_files_yes="Yes";
$system_config_txt_allow_members_to_upload_their_own_stamp_files_no="No";
$system_config_txt_allow_members_to_upload_their_own_stamp_files_set_total_stamp="If <strong>yes</strong>, then set total Stamp files member can upload - Set zero for no limit";
$system_config_txt_maximum_stamp_file_size_to_upload="Maximum Stamp file size for user to upload";
$system_config_txt_set_stamp_image_width="Set Stamp image width";
$system_config_txt_set_stamp_image_height="Set Stamp image height";
$system_config_txt_allow_members_to_upload_their_own_poem="Allow members to upload their own Message?";
$system_config_txt_allow_members_to_upload_their_own_poem_yes="Yes";
$system_config_txt_allow_members_to_upload_their_own_poem_no="No";
$system_config_txt_allow_members_to_upload_their_own_poem_set_total_poems="If <strong>yes</strong>, then set total Messages member can upload - Set zero for no limit";
$system_config_txt_allow_members_to_upload_their_own_fonts="Allow members to upload their own fonts? Select NO if you don't have Invitation package.";
$system_config_txt_allow_members_to_upload_their_own_fonts_yes="Yes";
$system_config_txt_allow_members_to_upload_their_own_fonts_no="No";
$system_config_txt_enable_2checkout_test_mode="Enable 2CheckOut test mode ? (Select YES to test 2CO Payment - use credit card number <strong>123456789112345</strong>)";
$system_config_txt_enable_2checkout_test_mode_yes="Yes";
$system_config_txt_enable_2checkout_test_mode_no="No";
$system_config_txt_enter_2checkout_secret_word="Enter your 2CheckOut secret word";
$system_config_txt_enter_2checkout_sid_number="Enter your 2CheckOut <strong>Sid</strong> number (seller ID number)";
$system_config_txt_your_primary_paypal_email_address="Your primary PayPal email address";
$system_config_txt_turn_on_paypal_testing_mode="Turn on Paypal testing mode";
$system_config_txt_enable_paypal_test_mode_yes="Yes";
$system_config_txt_enable_paypal_test_mode_no="No";
$system_config_txt_your_testing_paypal_email_address="Your testing PayPal email address";

//Language for Calendar page
$calendar_txt_calendar="Calendar";
$calendar_txt_january="January";
$calendar_txt_february="February";
$calendar_txt_march="March";
$calendar_txt_april="April";
$calendar_txt_may="May";
$calendar_txt_june="June";
$calendar_txt_july="July";
$calendar_txt_august="August";
$calendar_txt_september="September";
$calendar_txt_october="October";
$calendar_txt_november="November";
$calendar_txt_december="December";
$calendar_txt_sun="Sun";
$calendar_txt_mon="Mon";
$calendar_txt_tue="Tue";
$calendar_txt_wed="Wed";
$calendar_txt_thu="Thu";
$calendar_txt_fri="Fri";
$calendar_txt_sat="Sat";

//Language for Feedback page
$feedback_message_new_department_added_ok="New department has been added";
$feedback_message_checkbox_checked_required="You must select checkbox first. Please try again.";
$feedback_message_confirm_to_delete="Are you sure you want to delete your selected?";
$feedback_txt_send="Send";
$feedback_txt_ip2country="IP2Country";
$feedback_txt_user_ip2country="User IP2Country";
$feedback_tooltip_delete_account="Delete account";
$feedback_tooltip_click_to_view="click here to view";
$feedback_tooltip_click_to_view_message="click here to view message";
$feedback_tooltip_select_all="Select All";
$feedback_tooltip_click_to_edit="Click here to edit";
$feedback_tooltip_click_to_close="Close/Hide";
$feedback_tooltip_default_size="Default size";
$feedback_tooltip_increase_size="Increase size";
$feedback_tooltip_decrease_size="Decrease size";
$feedback_tooltip_click_to_close_hide="Click here to close";
$feedback_txt_feedback_msg="Feedback message - Department name";
$feedback_txt_total="Total";
$feedback_txt_mysql_table_banner_updated="Mysql table banner has been updated";
$feedback_txt_column_name_icon="Icon";
$feedback_txt_column_name_sender_name_feedback_subject="Sender Name and Feedback subject";
$feedback_txt_column_name_time_sent_ip2country="Time sent and IP2Country";
$feedback_txt_column_name_view="View";
$feedback_txt_column_name_delete="Delete";
$feedback_txt_search_message="Search message";
$feedback_txt_button_search_message_submit="Search";
$feedback_txt_button_delete_selected="Delete Selected";
$feedback_txt_page_title="Feedback Deparment";
$feedback_txt_click_to_add_deparment="Click here to add new department";
$feedback_txt_add_deparment="Add new department";
$feedback_txt_deparment_name="Department Name";
$feedback_txt_deparment_email="Department Email (user feedback will be sent to this address)";
$feedback_txt_button_add_new_department_submit="Submit";
$feedback_txt_tips="Tips";
$feedback_txt_tips_content=<<<EOF
<ul>
	<li>Check the department name, department email to edit them.</li>
	<li>#Feedback: show number of feedback messages in each department</li>
	<li>Click Icon <img border="0" src="html/07_icon_search_keyword.gif" alt="" style="vertical-align:middle" /> to view user feedback</li>
</ul>
EOF;
$feedback_txt_column_name_department_name="Department Name";
$feedback_txt_column_name_department_email="Department Email";
$feedback_txt_column_name_feedback="#Feedback";
$feedback_txt_view_feedback_message="View Feedback Message";
$feedback_message_loading="loading...";
$feedback_message_department_name_required="You must enter Department name";
$feedback_message_department_email_required="You must enter Department email";

//Language for Admin Index page
$admin_index_page_txt_page_title="Site statistics";
$admin_index_page_txt_statistics_column_name="Statistic";
$admin_index_page_txt_value_column_name="Value";
$admin_index_page_txt_total_members="Total members";
$admin_index_page_txt_ecardmax_version="Your eCardMAX version";
$admin_index_page_txt_new_member_today="New members today";
$admin_index_page_txt_member_cancel="Members requested to cancel account";
$admin_index_page_txt_php_version="PHP version";
$admin_index_page_txt_number_free_acc="Number of Free member accounts";
$admin_index_page_txt_mysql_version="MySQL Version";
$admin_index_page_txt_number_paid_acc="Number of Paid member accounts";
$admin_index_page_txt_database_size="Database size";
$admin_index_page_txt_total_ecards_sent="Total eCards have been sent";
$admin_index_page_txt_images_uploaded="Image files were uploaded by members";
$admin_index_page_txt_ecard_created_yesterday="eCards created yesterday";
$admin_index_page_txt_poems_created="Messages were created by members";
$admin_index_page_txt_number_ecards_not_pickup="Number of eCards were not picked up.";
$admin_index_page_txt_server_software="Server software";
$admin_index_page_txt_quick_user_finder="Quick User Finder";
$admin_index_page_txt_find_user="Find a user account";
$admin_index_page_txt_button_search_user_submit="Search User";
$admin_index_page_txt_button_list_acc="List All Account";
$admin_index_page_txt_ecardmax_latest_version="eCardMAX latest version";
$admin_index_page_txt_ecardmax_create_today="eCards create today";
$admin_index_page_txt_music_files_uploaded_by_members="Music files were uploaded by members";
$admin_index_page_txt_number_ecards_sent_in_database="Number of eCards sent in database";
$admin_index_page_txt_number_of_language_files="Number of language files";
$admin_index_page_txt_last_patch_applied="Last patch applied";
$admin_index_page_txt_eCardMax_latest_patch="eCardMax latest patch";

//Language for button admin menu
$button_admin_menu_system_configuration="System Configuration";
$button_admin_menu_show_search_keyword="Show Search Keyword";
$button_admin_menu_view_black_list_email="View Black List Email";
$button_admin_menu_ban_user_ip_email="Ban User IP/Email";
$button_admin_menu_cellphone_carrier_info="Cell Phone Carrier Info";
$button_admin_menu_export_database="Export Database";
$button_admin_menu_import_database="Import Database";
$button_admin_menu_sign_out="Sign Out";

//Language for button ecard menu
$button_ecard_menu_set_price_pay_per_card="Set Price Pay Per Card";
$button_ecard_menu_manage_ecard="Manage eCard";
$button_ecard_menu_view_card_log="View eCard Log";
$button_ecard_menu_view_card_statistics="View eCard Statistics";
$button_ecard_menu_manage_invitation_card="Manage Invitation Card";
$button_ecard_menu_view_invitation_log="View Invitation Log";
$button_ecard_menu_manage_media_grabber="Manage Media Grabber";

//Language for button email menu
$button_email_menu_recipient_group="Recipient Group";
$button_email_menu_create_message="Create Message";
$button_email_menu_sending="Sending";

//Language for button grabber menu
$button_grabber_menu_download_media_grabber="Download Media Grabber";
$button_grabber_menu_configuration="Configuration";

//Language for button invitation menu
$button_invitation_menu_configuration="Configuration";
$button_invitation_menu_manage_category="Manage Category";
$button_invitation_menu_manage_invitation_card="Manage Invitation Card";

//Language for button member menu
$button_member_menu_set_member_groups="Set Member Groups";
$button_member_menu_show_member_accounts="Show Member Accounts";
$button_member_menu_list_inactive_accounts="List Inactive Accounts";
$button_member_menu_view_member_album="View Member Album";

//Language for button option menu
$button_option_menu_manage_java_applet="Manage Java Applet";
$button_option_menu_manage_ecard_skin="Manage eCard Skin";
$button_option_menu_manage_stamp="Manage Stamp";
$button_option_menu_manage_music="Manage Music";
$button_option_menu_manage_poem="Manage Suggest Message(Spiritual Quotes)";
$button_option_menu_manage_quote="Manage Quote";
$button_option_menu_manage_banner_ad="Manage Banner Ad";
$button_option_menu_manage_game="Manage Game";

//Language for Login page
$login_page_txt_admin_id="Admin ID";
$login_page_txt_password="Password";
$login_page_txt_button_login_submit="Submit";
$login_page_error_id_pass_not_matching="Admin ID and Password do not match";

//Language for Holiday Event page
$holiday_event_txt_page_title="Holiday/Events";
$holiday_event_txt_total="Total";
$holiday_event_txt_click_to_add_new_event="Click here to add new Holiday/Events";
$holiday_event_txt_add_new_event="Add new Holiday/Event";
$holiday_event_txt_event_title="Event Title";
$holiday_event_txt_event_date="Event Date";
$holiday_event_txt_event_type="Event Type";
$holiday_event_txt_event_type_fixed="Fixed";
$holiday_event_txt_event_type_floating="Floating";
$holiday_event_txt_link_to_url="Link to URL";
$holiday_event_txt_link_to_url_desc="For example if you add new event title New Year, then input the URL to category New Year.";
$holiday_event_txt_button_add_event_submit="Submit";
$holiday_event_txt_tip="Tips";
$holiday_event_txt_tip_content=<<<EOF
<ul>
	<li>Holidays can be thought of as being either <strong>Fixed</strong> or <strong>Floating</strong>. Fixed holidays are those that occur on the same day each year, such as <strong>Christmas</strong>. Floating holidays are those which occur on different days in different years. For example, <strong>Thanksgiving</strong> (in the US) occurs on the fourth Thursday of November.</li>
	<li>Click on event name or event url link to edit them. Click calendar icon to change event date.</li>
	<li>Click icon <img border="0" alt="" src="html/07_icon_event_calendar.gif" style="vertical-align:middle" /> to visit event link url (open in new window).</li>
</ul>
EOF;
$holiday_event_txt_column_name_icon="Icon";
$holiday_event_txt_column_name_holiday_event="Holiday/Event Name";
$holiday_event_txt_column_name_event_date="Event Date (MM/DD/YYYY)";
$holiday_event_txt_column_name_floating="Floating";
$holiday_event_txt_column_name_delete="Delete";
$holiday_event_txt_button_delete_selected="Delete Selected";
$holiday_event_txt_calendar="Calendar";
$holiday_event_message_new_event_added_ok="New Holiday/Event has been added";
$holiday_event_message_mysql_table_updated_ok="Mysql table quote has been updated";
$holiday_event_message_event_name_required="You must enter event name";
$holiday_event_message_event_date_required="You must enter event date";
$holiday_event_message_event_url_required="You must enter event URL";
$holiday_event_message_checkbox_required="You must select checkbox first. Please try again.";
$holiday_event_message_confirm_to_delete="Are you sure you want to delete your selected?";
$holiday_event_tooltip_click_to_edit="Click here to edit";
$holiday_event_tooltip_close_hide="Close/Hide";
$holiday_event_tooltip_delete="Delete";
$holiday_event_tooltip_click_to_close="Click here to close";
$holiday_event_txt_click_below_to_edit="<strong>Link to URL</strong> (Click link below to edit)";
$ecard_add_remove_txt_add_new_ecards_by_youtube="Add youtube video as ecard";
$txt_youtube_link="Youtube link";
$txt_youtube_link_allow="Only Youtube link as http://www.youtube.com/watch?v=G_crTZ5aVKc";
$system_config_txt_tw_link="Twitter link";
$system_config_txt_gs_link="Google+ link";
$system_config_txt_pi_link="Pinterest link";
$system_config_txt_fb_link="Facebook link";
$system_config_txt_enable_fb_login="Support login with Facebook";
$system_config_txt_turn_on_ppc="Enable Pay Per Card";
$system_config_txt_ppc_yes="Yes";
$system_config_txt_ppc_no="No";
$system_config_newest_invitation_ecards="Set number of Newest invitation cards you want to show";
$system_config_slider_height="Set height of Slider";
$system_config_slider_width="Set width of Slider";
$button_option_menu_manage_logo="Manage Logo";
$allow_type_logo_image="(Image type: .gif .jpg .png)";
$admin_logo_image="Add/Update Logo";
$admin_update_logo="Select new logo";
$admin_txt_logo="Logo";
$system_config_txt_date_default_timezone_set="Set date default timezone";
$system_config_txt_set_template_responsive = "Template Responsive";
?>
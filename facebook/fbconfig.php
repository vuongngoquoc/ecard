<?php
global $cf_fb_api_key,$cf_fb_secret;
//echo $cf_fb_api_key;
//Facebook Application Configuration.
$facebook_appid=$cf_fb_api_key;
$facebook_app_secret=$cf_fb_secret;
$facebook = new Facebook(array(
'appId'  => $facebook_appid,
'secret' => $facebook_app_secret,
));


?>
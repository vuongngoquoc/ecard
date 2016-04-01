<script>(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=395795963837236";
    fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>
<?php
    function link_facebook(){
        $link_facebook = "<div id='fb-root'></div>";     
        //$link_facebook .="<a href='{xen:link register/facebook, '', 'reg=1'}' class='fbLogin'><span>login with facebook</span></a></li>";
        return $link_facebook;
    }
?>
<div class="fb-login-button" data-show-faces="true" data-width="200" data-max-rows="1"></div>
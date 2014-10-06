<?php
use Nvl\Cms\App;
?>
<head>
    <title>Nham VL</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="keywords" content="Nham VL" />
    <meta name="description" content="Nham VL, vui lam, nham vui lam" />
    <meta name="robots" content="noodp" />
 	<meta name="google-site-verification" content="_reH-wYeRCPPrwQkNAV4Xc9YIBL1Z64xkSsN_vumMNo" />
    <meta property="og:title" content="Just For Fun" />
    <meta property="og:site_name" content="NhamVL" />
    <meta property="og:url" content="http://nhamvl.vn" />
    <meta property="og:description" content="Nham VL, vui lam, nham vui lam" />
    <meta property="og:type" content="blog" />
    <link href="<?php echo STATIC_PATH ?>/css/styleAll.css" media="screen,projection" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="<?php echo STATIC_PATH ?>/js/lib.js"></script>
</head>
<script type="text/javascript">
    (function(i, s, o, g, r, a, m) {
        i['GoogleAnalyticsObject'] = r;
        i[r] = i[r] || function() {
            (i[r].q = i[r].q || []).push(arguments)
        }, i[r].l = 1 * new Date();
        a = s.createElement(o),
                m = s.getElementsByTagName(o)[0];
        a.async = 1;
        a.src = g;
        m.parentNode.insertBefore(a, m)
    })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

    ga('create', 'UA-55377994-1', 'auto');
	ga('send', 'pageview');

</script>
<script type='text/javascript'>
    var googletag = googletag || {};
    googletag.cmd = googletag.cmd || [];
    (function() {
        var gads = document.createElement('script');
        gads.async = true;
        gads.type = 'text/javascript';
        var useSSL = 'https:' == document.location.protocol;
        gads.src = (useSSL ? 'https:' : 'http:') + '//www.googletagservices.com/tag/js/gpt.js';
        var node = document.getElementsByTagName('script')[0];
        node.parentNode.insertBefore(gads, node);
    })();
</script>
<script type='text/javascript'>
    googletag.cmd.push(function() {
        googletag.pubads().set("page_url", "http://nhamvl.com/");

        googletag.pubads().enableSingleRequest();
        googletag.enableServices();
    });
</script>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&appId=645425958908296&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<script src="https://apis.google.com/js/platform.js" async defer></script>

<body class="background-white">
    <div class="badge-sticky-subnav-static">
        <header id="top-nav" class="badge-sticky-nav">
            <div class="nav-wrap">
                <h1><a href="/">NhamVL</a></h1>
                <div class="headbar-items">
                    <ul>
                        <li><a href="javascript:void(0);" class="selected" ><span class="label">Đang Hot</span></a></li>
                        <li><a href="javascript:void(0);"><span class="label">Hot trong tuần</span></a></li>
                        <li><a href="javascript:void(0);"><span class="label">Mới nhất</span></a></li>
                        <li><a id="jsid-header-funny-menu" href="javascript:void(0);"><span class="label">Theo thể loại <span class="drop-arrow"></span></span></a></li>
                    </ul>
                </div>
                <div id="jsid-header-funny-menu-items" class="popup-menu funny hide badge-popup-menu" style="margin-left: 469px; left: 0px;"> <span class="arrow-wrap"> <span class="arrow"></span> </span>
                    <ul>
                        <li><a class="" href="http://nhamvl.com/gif">Clip hài hước</a></li>
                        <li><a class="" href="http://nhamvl.com/gif">Ảnh động</a></li>
                        <li><a class="" href="http://nhamvl.com/girl">Hot Girls</a></li>
                        <li><a class="" href="http://nhamvl.com/meme">Ảnh Chế</a></li>
                        <li><a class="" href="http://nhamvl.com/cute">Ảnh Cute</a></li>
                        <li><a class="" href="http://nhamvl.com/cosplay">Ảnh hóa thân nhân vật</a></li>
                        <li><a class="" href="http://nhamvl.com/timely">Ảnh sự kiện</a></li>
                        <li><a class="" href="http://nhamvl.com/comic">Ảnh Hài Hước</a></li>
                    </ul>
                </div>
                <?php if (!App::userApplicationService()->isLoggedIn())  { ?>
                <div id="jsid-visitor-function" class="visitor-function">
                	<a class="badge-login-button link" href="javascript:void(0);">Log in</a>
                	<a class="badge-signup-button link" href="javascript:void(0);">Sign up</a>
                    <div class="upload"> <a class="badge-signup-button upload" href="https://nhamvl.com/signup">Upload</a> </div>
                </div>
                <?php } else { $user = App::userApplicationService()->user(); ?>
                <div id="jsid-user-function" class="user-function">
                    <div id="jsid-header-notification-menu" class="notification badge-evt" data-evt="Notification-Badge,Clicked-Badge,https://9gag.com/notifications">
                        <a class="bell" href="javascript:void(0);">
                            <span id="jsid-notification-unread-count" class="badge hide" href="http://9gag.com/notifications">0</span>
                        </a>
                    </div>

                    <div id="jsid-header-user-menu" class="avatar">
                        <a class="avatar-container" href="javascript:void(0);">
                            <img id="jsid-avatar" src="//accounts-cdn.9gag.com/media/avatar/20791934_100_1.jpg" alt="Avatar">
                            <span class="name">Me</span>
                            <div class="drop-arrow"></div>
                        </a>
                    </div>

                            <div class="upload">
                        <a id="jsid-upload-menu" class="upload" href="javascript:void(0);">Upload</a>
                    </div>


                    <div id="jsid-header-notification-items" class="notification-menu hide">
                        <div class="title">
                            <h3>Notifications</h3>
                        </div>
                        <div class="scrollbar" style="height: 0px;"><div class="track" style="height: 0px;"><div class="thumb"></div></div></div>
                        <div class="notification-list viewport">
                            <ul id="jsid-header-notification-items-container" class="overview" style="top: 0px;"><li class="empty"><div class="empty-message"><p>You don't have any notification yet.</p></div></li></ul>
                        </div>
                        <div class="bumper">
                            <a id="jsid-header-notification-see-all" class="see-all badge-evt" href="http://9gag.com/notifications" data-evt="Notification-Menu,Clicked-All,http://9gag.com/notifications">See all</a>
                        </div>
                    </div>
                </div>
                <div class="badge-user-function-placeholder hide">
                    <div class="upload"> <a class="badge-signup-button upload" href="javascript:void(0)">Upload</a> </div>
                </div>
                <div id="jsid-header-user-menu-items" class="popup-menu user hide"> <span class="arrow-wrap"> <span class="arrow"></span> </span>
                    <ul>
                        <li><a id="jsid-my-profile" href="/u/<?php echo $user['username']; ?>">My Profile</a></li>
                        <li><a href="/settings">Settings</a></li>
                        <li><a class="badge-logout-btn" href="/logout">Logout</a></li>
                    </ul>
                </div>
                <?php } ?>
                <div class="popup-menu upload hide badge-upload-items"> <span class="arrow-wrap"> <span class="arrow"></span> </span>
                    <ul>
                        <li><a class="badge-upload-selector badge-upload-url" href="javascript:void(0)">Add from URL</a></li>
                        <li><a class="badge-upload-selector badge-upload-image" href="javascript:void(0)">Upload image</a></li>
                        <li><a href="http://memeful.com/generator?ref=9gag" target="_blank">Make a meme</a></li>
                    </ul>
                </div>
                <form id="headbar-search" class="badge-header-search" action="http://nhamvl.com/search">
                    <input type="text" name="query" id="jsid-search-input" class="ui-autocomplete-input search search_input" data-placeholder="Search…" tabindex="1" autocomplete="off">
                    <span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span>
                    <div class="ui-widget"></div>
                    <ul class="ui-autocomplete ui-front ui-menu ui-widget ui-widget-content ui-corner-all" id="ui-id-1" tabindex="0" style="display: none;">
                    </ul>
                </form>
                <div class="clearfix"></div>
            </div>
        </header>
    </div>
    <div class="section-nav">
        <div class="width-limit">
            <div class="slogan">
                <p>NhamVL Vui lam.</p>
            </div>
            <div class="social-love" style="float:right">
                <div class="fb-like" style="top:0px;" data-href="http://nhamvl.com/" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true"></div>
            </div>
           <!-- <a class="customize badge-personalise-btn" href="#">Personalise <span class="drop-arrow"></span></a>-->
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="toast badge-toast-container" style="display:none">
        <p class="close"> <span class="badge-toast-message"></span> <a class="btn-close badge-toast-close" href="#">&#10006;</a> </p>
    </div>
</body>

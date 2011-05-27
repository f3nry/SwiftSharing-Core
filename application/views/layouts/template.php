<!DOCTYPE html>
<html>
    <head>
        <title>SwiftSharing <?php echo (isset($title)) ? " - " . $title : "" ?></title>
        <link rel="stylesheet" type="text/css" href="/content/css/new.css"/>
        <link rel="stylesheet" type="text/css" href="/content/css/screen.css" />
        <?php if(is_array(@$styles)): ?>
        <?php foreach($styles as $style): ?>
            <link rel="stylesheet" type="text/css" href="/content/css/<?php echo $style ?>.css" />
        <?php endforeach; ?>
        <?php endif; ?>
        <link rel="stylesheet" href="/content/js/fancybox/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />
        <script type="text/javascript" src="/content/js/js/jquery-1.4.4.min.js"></script>
        <script type="text/javascript" src="/content/js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
        <script type="text/javascript" src="/content/js/feed.js"></script>
    </head>
    <body>
        <div id="wrapper">
            <div id="header">
                <div style="margin-left:0px;">
                    <div class="logo">
                        <a href="/">
                            <img alt="" src="/content/images/menu_left.png"/>
                        </a>
                    </div>
                    <div id="header_content">
                        <ul id="menu">
                            <?php if(!$session->get('username')): ?>
                            <li><a href="/">Home</a></li>
                            <li><a href="/about">About</a></li>
                            <li><a href="/register">Register</a></li>
                            <li><a href="/login">Login</a></li>
                            <?php else: ?>
                            <li><a href="/">Home</a></li>
                            <li style="margin-top:0px;">
                                <a href="/inbox">
                                    <?php $count = $member->getUnreadMessageCount() ?>
                                    Messages (<?php if($count > 0) { echo '<span style="color:#7dfd6c">' . $count . '</span>'; } else { echo $count; }?>)
                                </a>
                            </li>
                            <li id="profile">
                                <a href="/<?php echo $session->get('username') ?>">Profile</a>
                            </li>
                            <li>
                                <a href="/profile/edit">Edit Profile</a>
                            </li>
                            <li><a href="/friends">Friends</a></li>
                            <li><a href="/logout">Logout</a></li>
                            <?php endif; ?>
                        </ul>
                        <div class="searchContainer">
                            <div style="margin-top:8px;">
                                <form action="/members/search" method="post" id="searchForm">
                                    <input type="text" id="searchField" name="searchField" />
                                    <img src="/content/images/magnifier.png" alt="Search" onclick="$('#searchForm').trigger('submit')"/>
                                </form>
                            </div>
                            <img style="float:right;margin-right:-18px;" alt="" src="/content/images/menu_right.png"/>
                        </div>
                    </div>
                </div>
            </div>
            <div id="container">
                <?php if(!@$hideContentPane): ?>
                <div <?php if(@$fullWidthLayout): ?>id="content" style="width:860px;"<?php else: ?>id="content"<?php endif; ?>>
                <?php endif; ?>
                    <?php echo $body ?>
                <?php if(!@$hideContentPane): ?>
                </div>
                <?php endif; ?>
                    <div id="footer">
                    <div style="float:left;">
                        <span>SwiftSharing</span> | <a href="/help">Help</a> | <a href="/about">About</a> | <a href="/privacy">Privacy</a> | <a href="/refer">Refer</a>
                    </div>
                    <div style="float:right;">
                        <div style="width:250px;float:left;height:62px;">
                            <iframe src="http://www.facebook.com/plugins/likebox.php?href=http%3A%2F%2Fwww.facebook.com%2Flosangeleslakers%3Fv%3Dinfo%23%21%2Fpages%2FSwiftSharing%2F151280171581392&amp;width=292&amp;colorscheme=light&amp;show_faces=false&amp;stream=false&amp;header=true&amp;height=62" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:292px; height:62px;" allowTransparency="true"></iframe>
                        </div>
                        <!--
                        <div style="height:62px;float:right;padding-top:20px;">
                            <a href="http://twitter.com/share" class="twitter-share-button" data-url="http://swiftsharing.net/" data-text="Check this out!" data-count="horizontal" data-via="swiftsharing" style="top:0;margin-top:auto;">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
                        </div>-->
                    </div>
                </div>
            </div>
        </div>
        <!--
        <?php if(Session::instance()->get('user_id') && Kohana::$environment != Kohana::PRODUCTION): ?>
            <div id="bottom-bar">
                <h3><a href="/<?php echo $member->username ?>"><?php echo $member->getFullName(); ?></a></h3>
                <div class="left">
                    <a href="#" id="notifications">
                        <img width="20" height="20" src="/content/images/information.png"/>
                        <span id="notification-text">Notifications</span>
                        <div id="notifications-popout">
                            <div class="top-row">
                            	My Notifications
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        <script type="text/javascript">
            $("#notifications").click(function() {
                if($("#notifications-popout").css('display') == 'none') {
                    $("#notifications-popout").show();
                    $("#notifications").addClass('open');
                } else {
                    $("#notifications-popout").hide();
                    $("#notifications").removeClass('open');
                }
            });
        </script>
        <?php endif; ?>
        -->
    </body>
</html>

<!DOCTYPE html>
<html>
  <head>
    <title>SwiftSharing <?php echo (isset($title)) ? " - " . $title : "" ?></title>

    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Metrophobic" />

    <!--<link type="text/css" href="/content/css/blueprint/screen.css?1" media="screen" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="/content/css/new.css?1"/>
    <link rel="stylesheet" type="text/css" href="/content/css/screen.css?1" />-->
    <?php if (is_array(@$styles)): ?>
      <?php foreach ($styles as $style): ?>
        <link rel="stylesheet" type="text/css" href="/content/css/<?php echo $style ?>.css?1" />
      <?php endforeach; ?>
    <?php endif; ?>
    <!--<link rel="stylesheet" href="/content/js/fancybox/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="/content/css/jquery.jgrowl.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="/content/css/flick/jquery-ui-1.8.14.custom.css" type="text/css" media="screen" />-->

    <link rel="stylesheet" href="/min?g=css" type="text/css"/>
    <link rel="stylesheet" href="/content/css/fileuploader.css" type="text/css" />
    
    <script type="text/javascript" src="/min?g=js"></script>
    <script type="text/javascript" src="/content/js/libs/jquery.leanModal.js"></script>
    <script type="text/javascript" src="/content/js/app/app.js"></script>
    <script type="text/javascript" src="/content/js/app/photos.js"></script>
    <script type="text/javascript" src="/content/js/libs/jquery.leanModal.js"></script>
    <script type="text/javascript" src="/content/js/libs/fileuploader.js"></script>
    <!--<script type="text/javascript" src="/content/js/js/jquery-1.4.4.min.js"></script>
    <script type="text/javascript" src="/content/js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
    <script type="text/javascript" src="/content/js/feed.js"></script>
    <script type="text/javascript" src="/content/js/app/notifications.js"></script>
    <script type="text/javascript" src="/content/js/app/profile.js"></script>
    <script type="text/javascript" src="/content/js/jquery.jgrowl.dev.js"></script>
    <script type="text/javascript" src="/content/js/jquery-ui-1.8.14.custom.min.js"></script>
    -->
    <script type="text/javascript">
      $(function() {
	$("input:submit, .button").button();
      });
    </script>
  </head>
  <body>
    <div id="wrapper">
      <div id="header" class="<?php if (!$session->get('username')): ?>tall<?php endif; ?>">
	<div style="margin-left:0px;">
	  <div class="logo">
	    <a href="/">
	      <?php if (!$session->get('username')): ?>
  	      <img alt="" src="/content/images/swiftsharing_beta_logo.png"/>
	      <?php else: ?>
  	      <img alt="" src="/content/images/menu_left.png"/>
	      <?php endif; ?>
	    </a>
	  </div>
	  <div id="header_content" class="<?php if (!$session->get('username')): ?>tall<?php endif; ?>">
	    <?php if (!$session->get('username')): ?>
  	    <span id="everything">The Social Network<br/>That Changes Everything</span>
	    <?php else: ?>     
  	    <ul id="menu">
  	      <li><a href="/">Home</a></li>
  	      <li style="margin-top:0px;">
  		<a href="/inbox">
		    <?php $count = $member->getUnreadMessageCount() ?>
  		  Messages (<?php if ($count > 0) {
		    echo '<span style="color:#7dfd6c">' . $count . '</span>';
		  } else {
		    echo $count;
		  } ?>)
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
  	    </ul>
	    <?php endif; ?>
	    <?php if (!$session->get('username')): ?>
	    <?php else: ?>
  	    <div class="searchContainer">
  	      <div style="margin-top:1px;">
  		<form action="/members/search" method="post" id="searchForm">
  		  <input type="text" id="searchField" name="searchField" />
  		  <img src="/content/images/magnifier.png" alt="Search" onclick="$('#searchForm').trigger('submit')"/>
  		</form>
  	      </div>
  	      <img style="float:right;margin-right:-18px;" alt="" src="/content/images/menu_right.png"/>
  	    </div>
	<?php endif; ?>
	  </div>
	</div>
      </div>
      <div id="container">
	  <?php if (!@$hideContentPane): ?>
  	<div <?php if (@$fullWidthLayout): ?>id="content" style="width:860px;"<?php else: ?>id="content"<?php endif; ?>>
	<?php endif; ?>
	<?php echo $body ?>
	<?php if (!@$hideContentPane): ?>
		</div>
	<?php endif; ?>
	<div id="footer">
	  <div style="float:left;">
	    <span>SwiftSharing</span> | <a href="/help">Help</a> | <a href="/about">About</a> | <a href="/privacy">Privacy</a> | <a href="/refer">Refer</a>
	  </div>
	  <div style="float:right;">
	    <div style="width:250px;float:left;height:62px;">
	      <iframe src="http://www.facebook.com/plugins/likebox.php?href=http%3A%2F%2Fwww.facebook.com%2Fpages%2FSwiftSharing%2F229419637078420&amp;width=292&amp;colorscheme=light&amp;show_faces=false&amp;border_color&amp;stream=false&amp;header=false&amp;height=62" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:292px; height:62px;" allowTransparency="true"></iframe>
	    </div>
	    <!--
	    <div style="height:62px;float:right;padding-top:20px;">
		<a href="http://twitter.com/share" class="twitter-share-button" data-url="http://swiftsharing.net/" data-text="Check this out!" data-count="horizontal" data-via="swiftsharing" style="top:0;margin-top:auto;">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
	    </div>-->
	  </div>
	</div>
      </div>
    </div>
<?php if (Session::instance()->get('user_id')): ?>
      <div style="display:none;">
        <div id="comment-dialog" style="width:500px;">
  	<div id="comment-dialog-blab"></div>
  	<form id="new_comment" action="sportsfeed.php?ajax=false" method="post">
  	  <textarea name="blab_field" rows="3" style="width:480px" id="comment-text"></textarea>
  	  <input name="feed_id" type="hidden" id="new-comment-feed-id" />
  	  <input name="type" type="hidden" value="COMMENT" />
  	  <input name="submit" type="submit" value="Comment!" class="button"/>
  	</form>
  	<div id="comment-dialog-comments" style="padding-top:8px;">

  	</div>
        </div>
        <div class="comment">
  	<a href="#comment-dialog" style="display:none;" class="comments"></a>
        </div>
        <div class="friend_request_link">
  	<a hre="/profile/request" style="display:none" class="friend_request" id="friend_request_link"></a>
        </div>
      </div>
<?php endif; ?>
<?php if (Model_Feature::checkFeature('chat', Session::instance()->get('user_id'))): ?>
      <link type="text/css" href="/cometchat/cometchatcss.php" rel="stylesheet" charset="utf-8">
      <script type="text/javascript" src="/cometchat/cometchatjs.php" charset="utf-8"></script>
<?php endif; ?>
  </body>
</html>

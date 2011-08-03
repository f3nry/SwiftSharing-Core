<!DOCTYPE html>
<html>
<head>
	<title>SwiftSharing <?php echo (isset($title)) ? " - " . $title : "" ?></title>

	<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Metrophobic"/>

	<!--<link type="text/css" href="/content/css/blueprint/screen.css?1" media="screen" rel="stylesheet" />
			<link rel="stylesheet" type="text/css" href="/content/css/new.css?1"/>
			<link rel="stylesheet" type="text/css" href="/content/css/screen.css?1" />-->
	<?php if (is_array(@$styles)): ?>
	<?php foreach ($styles as $style): ?>
		<link rel="stylesheet" type="text/css" href="/content/css/<?php echo $style ?>.css?1"/>
		<?php endforeach; ?>
	<?php endif; ?>
	<!--<link rel="stylesheet" href="/content/js/fancybox/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />
			<link rel="stylesheet" href="/content/css/jquery.jgrowl.css" type="text/css" media="screen" />
			<link rel="stylesheet" href="/content/css/flick/jquery-ui-1.8.14.custom.css" type="text/css" media="screen" />-->

	<link rel="stylesheet" href="/min?g=css&<?php echo App::c() ?>" type="text/css"/>

	<script type="text/javascript" src="/min?g=js&<?php echo App::c() ?>"></script>
	
	<!--<script type="text/javascript" src="/content/js/libs/jquery.leanModal.js"></script>
	<script type="text/javascript" src="/content/js/app/app.js"></script>
	<script type="text/javascript" src="/content/js/app/photos.js"></script>
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
	<div id="header" class="<?php if(!Session::instance()->get('username')): ?>tall<?php else: ?>normal<?php endif; ?>">
		<div style="margin-left:0px;">
			<?php if(!Session::instance()->get('username')): ?>
			<div class="logo">
				<a href="/">
					<img alt="" src="/content/images/swiftsharing_beta_logo.png" height="<?php if(Session::instance()->get('username')): ?>55<?php endif; ?>"/>
				</a>
			</div>
			<?php else: ?>
			<div id="first_menu" class="menu-wrapper">
				<ul id="logo-menu" class="sf-menu sf-js-enabled sf-shadow">
					<li>
						<a href="/" class="sf-with-ul">
							<img alt="" src="/content/images/swiftsharing_beta_logo.png" height="55"/>
						</a>
						<ul class="sf-menu-sub1">
							<li>
								<a href="/profile/edit">
									Edit Profile
									<img alt="" src="/content/images/notifications/edit-profile.png" width="32"/>
								</a>
							</li>
							<li>
								<a href="/profile/edit">
									Account Settings
									<img alt="" src="/content/images/notifications/Settings.png" width="32"/>
								</a>
							</li>
							<li>
								<a href="/help">
									Help
									<img alt="" src="/content/images/notifications/help.png" />
								</a>
							</li>
							<li>
								<a href="/logout">
									Logout
									<img alt="" src="/content/images/notifications/logout.png" />
								</a>
							</li>
						</ul>
					</li>
				</ul>
			</div>
			<?php endif; ?>
			<div id="header_content" class="<?php if (!$session->get('username')): ?>tall<?php endif; ?>">
				<?php if (!$session->get('username')): ?>
				<span id="everything">The Social Network<br/>That Changes Everything</span>
				<?php else: ?>
				<ul id="feed_menu" class="sf-menu sf-js-enabled sf-shadow sf-menu-floated">
					<li>
						<a href="/">Feeds</a>
						<ul class="sf-menu-sub1">
						<?php foreach(Model_Feed::getAll() as $feed): ?>
							<li>
								<a href="/feed/<?php echo $feed['id'] ?>">
									<?php echo $feed['title'] ?>
									<img src="/content/images/feeds/<?php echo $feed['id'] ?>.png" width="32"/>
								</a>
							</li>
						<?php endforeach; ?>
						<li><a href="/friends">Friends</a></li>
						</ul>
					</li>
				</ul>
				<ul id="messages_menu" class="sf-menu sf-js-enabled sf-shadow sf-menu-floated">
					<li>
						<a href="/inbox">Messages</a>
						<ul class="sf-menu-sub1 messages">
							<?php foreach(Model_PrivateMessage::getRecentMessagesQuickly() as $message): ?>
								<li>
									<a href="/inbox/view/<?php echo $message->id ?>">
										<span class="subject"><?php echo Text::limit_words($message->subject, 5) ?>..</span>
										<span class="from">From <?php echo $message->member_from_firstname ?></span>
										<span class="preview"><?php echo Text::limit_words($message->message, 10) ?>..</span>
									</a>
								</li>
							<?php endforeach; ?>
							<li class="no_messages"><a href="/inbox">(Inbox)</a></li>
						</ul>
					</li>
				</ul>
				<div id="quick_share">
					<a href="#">
						<span>SwiftShare</span>
						<img src="/content/images/notifications/quick_share.png" width="40"/>
					</a>
					<span id="quick_share_dropdown">
						<div id="quick_share_wrapper">
							<textarea placeholder="Select a feed, type your post, and press enter.." id="quick_share_text"></textarea>
							<div id="quick_share_feeds">
								<?php foreach(Model_Feed::getAll() as $feed): ?>
									<?php if($feed['title'] != "Photos"): ?>
									<div class="quick_share_feed" data-id="<?php echo $feed['id'] ?>"><?php echo $feed['title'] ?></div>
									<?php endif; ?>
								<?php endforeach; ?>
							</div>
						</div>
					</span>
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
			<div id="footer_desc">
				The Social Network That Changes Everything
			</div>
			<div id="footer-links">
				<ul>
					<li><a href="/masthead">MastHead</a></li>
					<li><a href="/about">About</a></li>
					<li><a href="">TOS</a></li>
					<li><a href="">Rules</a></li>
					<li><a href="">Search</a></li>
				</ul>
			</div>
			<div id="search_container">
				<form action="/members/search" method="post">
					<input type="text" name="searchField" value="" class="search"/>
					<input type="submit" value="" class="submit"/>
				</form>
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
			<input name="feed_id" type="hidden" id="new-comment-feed-id"/>
			<input name="type" type="hidden" value="COMMENT"/>
			<input name="submit" type="submit" value="Comment!" class="button"/>
		</form>
		<div id="comment-dialog-comments" style="padding-top:8px;">

		</div>
	</div>
	<div class="comment">
		<a href="#comment-dialog" style="display:none;" class="comments"></a>
	</div>
	<div class="friend_request_link">
		<a href="/profile/request" style="display:none" class="friend_request" id="friend_request_link"></a>
	</div>
</div>
	<?php endif; ?>
<?php if (Model_Feature::checkFeature('chat', Session::instance()->get('user_id'))): ?>
<link type="text/css" href="/cometchat/cometchatcss.php" rel="stylesheet" charset="utf-8">
<script type="text/javascript" src="/cometchat/cometchatjs.php" charset="utf-8"></script>
	<?php endif; ?>
</body>
</html>

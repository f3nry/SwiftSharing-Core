<!DOCTYPE html>
<html>
    <head>
        <title>SwiftSharing</title>
        <link rel="stylesheet" type="text/css" href="/content/css/new.css"/>
        <link rel="stylesheet" type="text/css" href="/content/css/screen.css" />
        <link rel="stylesheet" type="text/css" href="/content/css/admin.css" />
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
		<?php if($logged_in): ?>
			<div id="admin_container">
				<div id="admin_menu">
					<ol class="tabs">
						<li><a href="/admin">Dashboard</a></li>
						<li><a href="/admin/chat">Chat</a></li>
					</ol>
				</div>
				<div style="clear:both;"></div>
				<div id="admin_content">
					<?php echo $body ?>
					<div style="clear:both;"></div>
				</div>
			</div>
		<?php else: ?>
        	<?php echo $body ?>
		<?php endif;?>
    </body>
</html>
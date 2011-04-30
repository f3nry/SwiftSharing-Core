       <div id="content">
           <h2><?php echo $feed->full_title; ?></h2>
           <?php if(!@$hideShareForm): ?>
           <div class="posts">
                <div style="display:none;" id="current_feed_id"><?php echo $feed->id ?></div>
                <div id="profile_flag" style="display:none;">0</div>
                <form action="/ajax/feed/new" id="<?php if($feed->allowed_post_types == "PHOTO"): ?>share<?php else: ?>share<?php endif; ?>" method="post" enctype="multipart/form-data">
                    <?php if(@$onlyFriends): ?>
                    <div style="display:none;" id="friends_flag">1</div>
                    <?php endif; ?>
                    <textarea name="text" cols="50" rows="2" style="width: 480px" id="sharetext"></textarea><br/>
                    <input name="submit" type="submit" value="Share!"/>&nbsp;
                    <?php if($feed->allowed_post_types == 'PHOTO'): ?>
                    <input type="file" name="photo" style="display:inline;color:white;" />&nbsp;
                    <input type="hidden" name="type" value="PHOTO" />
                    <input type="hidden" name="feed_id" value="<?php echo $feed->id ?>" />
                    <?php endif; ?><br/>
                    <input type="checkbox" checked="checked" id="auto-update">Auto-update feed
                </form>
            </div>
           <?php endif; ?>
           <div id="feed">
            <?php echo $feed_content ?>
           </div>
            <div style="clear:both"></div>
            <a href="javascript:void()" onclick="loadMore()">more</a>
       </div>

        <div id="side-b">
            <div class="photo">
                <?php print @$blabber_pic; ?>
            </div>
            <div class="options">
                <li><a href="/profile/edit">Edit Profile</a></li>
                <li><a href="#">Friend Request</a></li>
                <li><a href="/<?php echo $session->get('username') ?>">View Profile</a></li>
            </div>
            <div class="feed">
                <h3>Your Feeds</h3>
                <?php if($feed_list): ?>
                    <?php echo $feed_list; ?>
                <?php endif; ?>
            </div>
        </div>
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
</div>
<?php if ($feed->allowed_post_types == 'PHOTO'): ?>
<link href="/content/js/uploadify/uploadify.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="/content/js/uploadify/swfobject.js"></script>
<script type="text/javascript" src="/content/js/uploadify/jquery.uploadify.v2.1.4.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
  $('#file_upload').uploadify({
    'uploader'  : '/uploadify/uploadify.swf',
    'script'    : '',
    'cancelImg' : '/uploadify/cancel.png',
    'folder'    : '/uploads',
    'auto'      : false,
    'method'    : 'post',
    'multi'     : false,
    
  });
});
</script>
<?php endif; ?>
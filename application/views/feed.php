       <div id="content">
           <h2 style="margin-bottom: 0"><?php echo $feed->full_title; ?></h2>
           <?php if(!@$hideShareForm): ?>
           <div class="posts">
                <div style="display:none;" id="current_feed_id"><?php echo $feed->id ?></div>
                <div id="profile_flag" style="display:none;">0</div>
                <form action="/ajax/feed/new" id="<?php if($feed->allowed_post_types == "PHOTO"): ?>photo_share<?php else: ?>share<?php endif; ?>" method="post" enctype="multipart/form-data">
                    <?php if(@$onlyFriends): ?>
                    <div style="display:none;" id="friends_flag">1</div>
                    <?php endif; ?>
                    <textarea name="text" cols="50" rows="2" style="width: 480px" id="sharetext"></textarea><br/>
                    <input name="submit" type="submit" value="Share!"/>&nbsp;
                    <?php if($feed->allowed_post_types == 'PHOTO'): ?>
		    <button name="photo_album" onclick="App.PhotoAlbum.create();return false;">Create Photo Album</button>
                    <input type="file" name="photo" style="display:inline;color:white;" />&nbsp;
                    <input type="hidden" name="type" value="PHOTO" />
                    <input type="hidden" name="feed_id" value="<?php echo $feed->id ?>" />
                    <?php endif; ?><br/>
                </form>
            </div>
           <?php endif; ?>
           <div id="feed">
            <?php echo $feed_content ?>
           </div>
            <div style="clear:both"></div>
            <a href="javascript:void()" onclick="loadMore()">more</a>
       </div>
<?php if ($feed->allowed_post_types == 'PHOTO'): ?>
<link href="/content/js/uploadify/uploadify.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="/content/js/uploadify/swfobject.js"></script>
<script type="text/javascript" src="/content/js/uploadify/jquery.uploadify.v2.1.4.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $("input:submit, button").button();
});
</script>
<?php endif; ?>
<?php if($feed->allowed_post_types == 'PHOTO'): ?>
<div id="create_photo_album" class="modal">
  <div class="modal_header">
    <a href="#" class="modal_close" role="" onclick="App.Modal.close()"><span class="close">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br/></span></a>
    <h2>SwiftSharing</h2>
  </div>
  <div class="modal_body">
    <div class="photo_drop">
      <div id="form">
	<h1>Create a Photo Album</h1>
	<input type="text" class="album_name" id="album_name" placeholder="Enter a name for your Photo Album.." />
      </div>
      <div id="file-uploader" class="photo_drop_area">       
	  <noscript>          
	      <p>Please enable JavaScript to use file uploader.</p>
	      <!-- or put a simple form for upload here -->
	  </noscript>         
      </div>
      <button class="share_album" id="share_album" name="share_album">Share</button>
    </div>
    <div class="photos">
    </div>
  </div>
</div>
<?php endif; ?>

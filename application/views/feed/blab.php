<div id="blab_<?php echo $blab['id'] ?>" class="postbody">
    <div class="img">
        <?php if($blab['has_profile_image']): ?>
        <?php echo Images::getImage($blab['mem_id'], 'image01.jpg', 50, 0, true, true) ?>
        <?php else: ?>
        <img src="/content/images/image01.jpg" height="50" />
        <?php endif; ?>
    </div>
    <div class="text" style="<?php if($blab['type'] == 'ALBUM'): ?>width:400px;<?php else: ?>width:300px;<?php endif; ?>">
	<?php if($blab['type'] != 'ALBUM'): ?>
        <?php echo Text::auto_link(htmlentities($blab['text'])) ?>
	<?php endif; ?>  
        <?php if($blab['type'] == 'PHOTO'): ?>
        <br/>
        <a class="post_photo" href="https://s3.amazonaws.com/swiftsharing-cdn/members/<?php echo $blab['mem_id'] ?>/<?php echo $blab['id'] ?>.jpg" title="<?php echo $blab['text'] ?>">
            <?php echo Images::getImage($blab['mem_id'], $blab['id'] . '.jpg', 120, 0, true, true); ?>
        </a>
        <?php endif; ?>
	<?php if($blab['type'] == 'ALBUM'): ?>
	<?php $collection = new Model_Collection($blab['ref_id']); $photos = $collection->getPhotos(); ?>
	<div class="album_preview" style="float: left; padding-right: 6px;">
	  <b style=""><?php echo Text::auto_link(htmlentities($blab['text'])) ?></b><br/>
	  <?php $i = 0; ?>
	  <?php foreach($photos as $photo): ?>
	  <img src="<?php echo $photos[$i]->getUrl() ?>" width="80" height="80" onclick="App.Photo.gotoPhoto(<?php echo $photos[$i]->id ?>);return false;"/>
	  <?php $i++; if($i >= 3) { break; } ?>
	  <?php endforeach; ?>
	</div>
	<?php endif; ?>
        <div class="time <?php if($blab['type'] == 'ALBUM') { echo "album_time"; } ?>">
	    <?php if($blab['type'] == 'ALBUM'): ?>
	    <b>Photo Album Created</b><br/>
	    <?php endif; ?>
            <?php echo Date::fuzzy_span(strtotime($blab['date'])); ?>
            <?php if($config['show_from']): ?>
                <?php if($blab['type'] == 'PROFILE' && $blab['feed_id'] == $config['member']): ?>
                <a href="/<?php echo $blab['username'] ?>"><?php echo ($blab['firstname']) ? $blab['firstname'] : $blab["username"] ?></a> wrote
                <?php elseif($blab['type'] == 'PROFILE' && $blab['mem_id'] == $config['member']): ?>
                <?php $otherMember = Model_Member::quickLoad($blab['feed_id']); ?>
                , by <a href="/<?php echo $blab['username'] ?>"><?php echo ($blab['firstname']) ? $blab['firstname'] : $blab["username"] ?></a> wrote on <a href="/<?php echo @$otherMember->username ?>"><?php echo @$otherMember->firstname ?>'s</a> profile
                <?php else: ?>
                , by <a href="/<?php echo $blab['username'] ?>"><?php echo ($blab['firstname']) ? $blab['firstname'] : $blab["username"] ?></a> in <a href="/feed/<?php echo $blab['feed_id'] ?>"><?php echo $blab['feed_title'] ?></a>
                <?php endif; ?>
            <?php else: ?>
                by <a href="/<?php echo $blab["username"] ?>"><?php echo ($blab['firstname']) ? $blab['firstname'] : $blab["username"] ?></a>
            <?php endif; ?>
        </div>
        <?php if($blab['type'] != 'COMMENT' && $blab['type'] != 'ALBUM'): ?>
        <?php $n_comments = Model_Blab::getNumberComments($blab['id']);
                if($n_comments == 0) {
                    $comments = "0 Comments";
                } else if($n_comments == 1) {
                    $comments = "1 Comment";
                } else {
                    $comments = "$n_comments Comments";
                }
        ?>
        <div class="comment">
            <a href="javascript:void()" onclick="openBlabComments(<?php echo $blab['id'] ?>)"><?php echo $comments ?></a>
            <a href="#comment-dialog" style="display:none;" class="comments"></a>
        </div>
        <?php endif; ?>
    </div>
    <div class="likes">
    <?php echo Model_Like::generateLikeBox($blab['id'], $blab['likes'],
        (Session::instance()->get('user_id') == $blab['mem_id'] || ($blab['type'] == 'PROFILE' && $blab['feed_id'] == Session::instance()->get('user_id')))) ?>
      
    <?php if($blab['type'] == 'ALBUM'): ?>
      <?php $n_comments = Model_Blab::getNumberComments($blab['id']);
                if($n_comments == 0) {
                    $comments = "0 Comments";
                } else if($n_comments == 1) {
                    $comments = "1 Comment";
                } else {
                    $comments = "$n_comments Comments";
                }
        ?>
      <div class="comment">
	  <a href="javascript:void()" onclick="openBlabComments(<?php echo $blab['id'] ?>)"><?php echo $comments ?></a>
	  <a href="#comment-dialog" style="display:none;" class="comments"></a>
      </div>
    <?php endif; ?>
    </div>
    <div style="clear:both;height:4px;"></div>
    <div style="display:none;" id="blab_<?php echo $blab['id'] ?>_timestamp"><?php echo strtotime($blab['date']) ?></div>
</div>
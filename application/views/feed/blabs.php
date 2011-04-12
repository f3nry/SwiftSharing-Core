<?php if(count($blabs) > 0): ?>
<?php foreach($blabs as $blab): ?>
<div id="blab_<?php echo $blab['id'] ?>" class="postbody">
    <div class="img">
        <?php if($blab['has_profile_image']): ?>
        <?php echo Images::getImage($blab['mem_id'], 'image01.jpg', 50, 0, true, true) ?>
        <?php else: ?>
        <img src="/content/images/image01.jpg" height="50" />
        <?php endif; ?>
    </div>
    <div class="text">
        <?php echo Text::auto_link(htmlentities($blab['text'])) ?>
        <?php if($blab['type'] == 'PHOTO'): ?>
        <br/>
        <a class="post_photo" href="https://s3.amazonaws.com/swiftsharing-cdn/members/<?php echo $blab['mem_id'] ?>/<?php echo $blab['id'] ?>.jpg" title="<?php echo $blab['text'] ?>">
            <?php echo Images::getImage($blab['mem_id'], $blab['id'] . '.jpg', 120, 0, true, true); ?>
        </a>
        <?php endif; ?>
        <div class="time">
            <?php echo Date::fuzzy_span(strtotime($blab['date'])); ?>
            <?php if($config['show_from']): ?>
                <?php if($blab['type'] == 'PROFILE' && $row['feed_id'] == $config['member']): ?>
                <a href="/<?php echo $blab['username'] ?>"><?php echo $blab['username'] ?></a> wrote
                <?php elseif($blab['type'] == 'PROFILE' && $blab['mem_id'] == $config['member']): ?>
                <?php $otherMember = Model_Member::quickLoad($blab['feed_id']); ?>
                , by <a href="/<?php echo $blab['username'] ?>"><?php echo $blab['username'] ?></a> wrote on <a href="/<?php echo $otherMember->username ?>"><?php echo $otherMember->firstname ?>'s profile</a>
                <?php else: ?>
                , by <a href="/<?php echo $blab['username'] ?>"><?php echo $blab['username'] ?></a> in <a href="/feed/<?php echo $blab['feed_id'] ?>"><?php echo $row['feed_title'] ?></a>
                <?php endif; ?>
            <?php else: ?>
                by <a href="/<?php echo $blab["username"] ?>"><?php echo ($blab['firstname']) ? $blab['firstname'] : $blab["username"] ?></a>
            <?php endif; ?>
        </div>
        <?php if($blab['type'] != 'COMMENT'): ?>
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
    </div>
    <div style="clear:both;height:4px;"></div>
    <div style="display:none;" id="blab_<?php echo $blab['id'] ?>_timestamp"><?php echo strtotime($blab['date']) ?></div>
</div>
<?php endforeach; ?>
<?php else: ?>

<?php endif; ?>
<?php
    $is_friend = (boolean)Model_Relationship::findRelationship($member->id, Session::instance()->get('user_id'))->is_loaded();

    $hideContent = !($is_friend || $member->privacy_option == '' || $member->privacy_option == 'public' || Session::instance()->get('user_id') == $member->id);
?>
<style type="text/css">
    #header {
        margin-bottom:0px;
    }

    #block_featured {
        padding-top:8px;
    }

    .postbody .text {
        max-width:60%;
    }
</style>
<div id="is_profile" style="display:none;" >1</div>
<div id="block_featured">
    <div class="block_inside">
        <div class="image_block">
            <div id="edit_profile">
                <a href="/profile/edit">Edit Profile</a>
            </div>
            <?php if($member->has_profile_image): ?>
            <?php echo Images::getImage($member->id, 'image01.jpg', 218, 0, true, true) ?>
            <?php else: ?>
            <img src="/content/images/image01.jpg" width="218"/>
            <?php endif; ?>
        </div>
        <?php if($member->id != Session::instance()->get('user_id') && !$is_friend): ?>
        <div class="interactionLinksDiv">
            <a class="modal_link" href="#add_friend" title="Add <?php echo $member->getName() ?> as a Friend">Add as Friend</a>
        </div>
        <?php endif; ?>
        <?php if($member->id != Session::instance()->get('user_id') && $is_friend && Session::instance()->get('user_id') != false): ?>
       <div class="interactionLinksDiv">
            <a class="modal_link" href="#remove_friend" title="Remove <?php echo $member->getName() ?> as a Friend">Remove Friend</a>
        </div>
        <?php endif; ?>
        <?php if($member->id == Session::instance()->get('user_id')): ?>
        <div class="interactionLinksDiv">
            <a class="modal_link" href="#friend_requests"><?php echo Model_FriendRequest::getCountRequestsTo($member->id, true) ?></a>
        </div>
        <?php endif; ?>
        <?php if($member->id != Session::instance()->get('user_id') && Session::instance()->get('user_id')): ?>
        <div class="interactionLinksDiv">
            <a class="modal_link" href="#private_message">Private Message</a>
        </div>
        <?php endif; ?>
        <div style="clear:both"></div>
        <div style="display:none">
            <div id="add_friend">
                Add <?php echo $member->getName(); ?> as a friend? &nbsp;
                <a href="#" onclick="return false"
                   onmousedown="javascript:addAsFriend(<?php echo $member->id ?>);">Yes</a>
                <span id="add_friend_loader"><img src="/content/images/loading.gif" width="28" height="10" alt="Loading"/></span>
            </div>
            <div id="remove_friend">
                Remove <?php echo $member->getName(); ?> from your friend list? &nbsp;
                <a href="#" onclick="return false" onmousedown="javascript:removeAsFriend(<?php echo $member->id; ?>);">Yes</a>
                <span id="remove_friend_loader"><img src="images/loading.gif" width="28" height="10" alt="Loading" /></span>
            </div>
            <div id="friend_requests">
                <?php echo Model_FriendRequest::getRequestHTML($member->id) ?>
            </div>
            <div id="private_message">
                <form action="javascript:sendPM();" name="pmForm" id="pmForm" method="post">
                    <font size="+1">Sending Private Message to
                        <strong><em><?php echo @$member->getName(); ?></em></strong></font><br/><br/>
                    <div id="interactionResults"></div>
                    Subject:
                    <input name="pmSubject" id="pmSubject" type="text" maxlength="64" style="width:98%;"/>
                    Message:
                    <textarea name="pmTextArea" id="pmTextArea" class="pmTextArea" rows="8" style="width:98%;"></textarea>
                    <input name="pm_rec_id" id="pm_rec_id" type="hidden" value="<?php echo @$member->id; ?>"/>
                    <span id="PMStatus" style="color:#F00;"></span>
                    <br/><input name="pmSubmit" type="submit" value="Send"/> or <a href="#" onclick="return false"
                                                                                     onmousedown="javascript:closeModal()">Close</a>
                    <span id="pmFormProcessGif" style="display:none;"><img src="/content/images/loading.gif" width="28"
                                                                           height="10" alt="Loading"/></span>
                </form>
            </div>
        </div>
        <?php if(!$hideContent): ?>
        <div style="width:218px;">
            <?php echo @$interactionBox ?>
            <?php if($member->music || $member->tv || $member->books || $member->movies): ?>
            <div class="interests">
                <?php if($member->country): ?>
                <div class="interest">
                    <p id="heading">Country:&nbsp;</p>

                    <p><?php echo @$member->country ?></p>
                </div>
                <?php endif; ?>
                <?php if (@$member->music): ?>
                <div class="interest">
                    <p id="heading">Music:&nbsp;</p>
                    <p><?php echo @$member->music ?></p>
                </div>
                <?php endif; ?>
                <?php if (@$member->tv): ?>
                <div class="interest">
                    <p id="heading">TV:&nbsp;</p>

                    <p><?php echo @$member->tv ?></p>
                </div>
                <?php endif; ?>
                <?php if (@$member->books): ?>
                <div class="interest">
                    <p id="heading">Books:&nbsp;</p>

                    <p><?php echo @$member->books ?></p>
                </div>
                <?php endif; ?>
                <?php if (@$member->movies): ?>
                <div class="interest">
                    <p id="heading">Movies:&nbsp;</p>

                    <p><?php echo @$member->movies ?></p>
                </div>
                <?php endif; ?>
            </div>
            <?php endif; ?>
            <?php echo @$member->website; ?>
            <?php echo @$member->youtube; ?>
            <?php echo @$member->facebook; ?>
        </div>
        <div id="short_friend_list">
            <?php echo @$member->generateShortFriendsList(); ?>
        </div>
        <div id="view_all_friends">
            <div style="padding:6px; background-color:#FFF; border-bottom:#666 1px solid;">
                <div style="display:inline; font-size:14px; font-weight:bold;">All Friends</div>
                <a href="#" onclick="return false" onmousedown="javascript:toggleViewAllFriends('view_all_friends');">close </a>
            </div>
            <div style="background-color:#FFF; height:400px; overflow:auto;">
                <?php echo @$friendPopBoxList; ?>
            </div>
        </div>
        <?php if($member->twitter): ?>
        <script src="http://widgets.twimg.com/j/2/widget.js" type="text/javascript"></script>
        <script type="text/javascript">
            new TWTR.Widget({
              version: 2,
              type: 'profile',
              rpp: 5,
              interval: 6000,
              width: 218,
              height: 160,
              theme: {
                    shell: {
                      background: '#BDF',
                      color: '#000000'
                    },
                    tweets: {
                      background: '#ffffff',
                      color: '#000000',
                      links: '#0066FF'
                    }
              },
              features: {
                    scrollbar: true,
                    loop: false,
                    live: false,
                    hashtags: true,
                    timestamp: true,
                    avatars: false,
                    behavior: 'all'
              }
            }).render().setUser('<?php echo $member->twitter ?>').start();
        </script>
        <?php endif; ?>
        <?php endif; ?>
    </div>
    <div class="text_block">
        <div class="text_block_content">
        <h1 style="padding-bottom:0px;margin:0;"><?php echo $member->firstname . " " . $member->lastname; ?></h1>
        <p><?php echo @$member->bio_body; ?></p>
        <?php if(!$hideContent): ?>
        <div style="background-color:#BDF; border:#999 1px solid; padding:2px;max-width:506px;">
            <div style="display:none;" id="current_feed_id"><?php echo $member->id; ?></div>
            <form action="/ajax/feed/new" id="share" method="post" enctype="multipart/form-data">
                <textarea name="text" cols="50" rows="3" style="width: 480px" id="sharetext"></textarea><br/>
              <?php if($member->id == Session::instance()->get('user_id')): ?>
              <strong>Say something <?php echo $member->firstname ?>...</strong> (220 char max)
              <?php else: ?>
              <strong>Write on <?php echo $member->firstname ?>'s profile</strong> (220 char max)
              <?php endif; ?>
                <input name="submit" type="submit" value="Share!"/>&nbsp;
                <input type="checkbox" checked="checked" id="auto-update">Auto-update Profile
                <input type="hidden" name="profile_flag" id="profile_flag" value="1" />
            </form>
        </div>
        <div style="width:516px; overflow-x:hidden;padding-top:8px;">
            <div id="feed">
            <?php echo @$blabs; ?>
            </div>
            <table style="background-color:#FFF;" cellpadding="5" width="94%">
                <tr style="padding:4px;">
                    <td>
                        <a href="javascript:void()" onclick="loadMore()">more</a>
                    </td>
                </tr>
            </table>
        </div>
        <?php else: ?>
        <p>
        <b><?php echo $member->getName() ?> has chosen to only show <?php echo $member->getNiceGender('his') ?> profile to friends.</b>
        You will need to add <?php echo $member->getNiceGender('him') ?> as a friend in order to view <?php echo $member->getNiceGender('his') ?> posts and content.
        </p>
        <?php endif; ?>
        </div>
        <br/>
    </div>
    <div style="clear:both;"></div>
</div>
<script type="text/javascript" src="/content/js/profile.js" ></script>
<style type="text/css">
    <?php if($member->has_background_image): ?>
    body {
        background-image: url(<?php echo Images::getImage($member->id, 'image02.jpg', false, false) ?>);
        background-repeat: repeat;
        background-position: center top;
    }
    <?php endif; ?>
</style>
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
<script type="text/javascript">
    bindThumbsUp();
</script>

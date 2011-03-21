       <div id="content">
            <div class="posts">
                <b>Music (Share What You're Listening To)</b>
                </div>
                <div class="text" style="display:none;" id="current_feed_id">1</div>
                <form action="#" id="share">
                    <textarea name="blab_field" cols=50 rows=3 id="sharetext"></textarea>
                    <input name="submit" type="submit" value="Share!"/>&nbsp;<input type="checkbox" checked="checked"
                                                                                    id="auto-update">Auto-update feed
                </form>
            </div>
           <div id="feed">
            <?php echo $feed_content ?>
           </div>
       </div>

        <div id="side-b">
            <div class="photo">
                <?php print @$blabber_pic; ?>
            </div>
            <div class="options">
                <li><a href="#">Edit Profile</a></li>
                <li><a href="#">Change Photo</a></li>
                <li><a href="#">Friend Request</a></li>
                <li><a href="#">View Profile</a></li>
            </div>
            <div class="feed">
                <h3>Your Feeds</h3>
                <?php //echo generate_feed_list(); ?>
                <?php if($feed_list): ?>
                    <?php echo $feed_list; ?>
                <?php endif; ?>
            </div>
        </div>
<?php
$is_friend = (boolean) Model_Relationship::findRelationship($member->id, Session::instance()->get('user_id'))->is_loaded();

$hideContent = !($is_friend || $member->privacy_option == '' || $member->privacy_option == 'public' || Session::instance()->get('user_id') == $member->id);
?>
<style type="text/css">
  .clear{
    clear: both;
    height: 0;
    visibility: hidden;
    display: block;
  }
  a{
    text-decoration: none;
  }
  #logo{
    margin-top: 1em;
    display: block;
  }
  #page{
    background-color:white;
    min-height:825px;
    width:765px;
    margin-top:-20px;
    margin-right:auto;
    margin-left:auto;
  }
  #container2{
    margin-top:10px;
    width: 500px;
    float:right;
    margin-right:20px;
  }
  .name{
    font-size:30px;
    padding-top:25px;
    margin-left:250px;
  }
  .location{
    margin-top:10px;
    margin-left:250px;
    color:gray;
    font-size: 15px;
  }
  #container ul{
    list-style: none;
    list-style-position: outside;
  }
  #container ul.menu li{
    float: left;
    margin-right: 5px;
    margin-bottom: -1px;
  }
  #container ul.menu li{
    font-weight: 700;
    display: block;
    padding: 5px 10px 5px 10px;
    background: #efefef;
    margin-bottom: -1px;
    border: 1px solid #d0ccc9;
    border-width: 1px 1px 1px 1px;
    position: relative;
    color: #898989;
    cursor: pointer;
  }
  #container ul.menu li.active{
    background: #fff;
    top: 1px;
    border-bottom: 0;
    color: #5f95ef;
  }
  .content{
    margin: 0pt auto;
    background: #efefef;
    background: #fff;
    border: 1px solid #d0ccc9;
    text-align: left;
    padding: 10px;
    padding-bottom: 20px;
    font-size: 11px;
  }
  .content h1{
    line-height: 1em;
    vertical-align: middle;
    height: 48px;
    padding: 10px 10px 10px 52px;
    font-size: 32px;
  }
  .content.news h1{
    background: transparent url(images/news.jpg) no-repeat scroll left top;
  }
  .content.news{
    display: block;
  }
  .content.info h1{
    background: transparent url(images/tuts.jpg) no-repeat scroll left top;
  }
  .content.info{
    display: none;
  }
  .content.links h1{
    background: transparent url(images/links.jpg) no-repeat scroll left top;
  }
  .content.links{
    display: none;
  }
  .content.interests h1{
    background: transparent url(images/tuts.jpg) no-repeat scroll left top;
  }
  .content.interests{
    display: none;
  }
  h2{
    font-size:30px;
    padding-bottom:15px;
  }
  p{
    font-size:15px;
  }
  #left{
    float:left;
  }
  .photo{
    margin-left:15px;
    margin-top:-60px;
  }
  .form{
    width:455px;
    background-color:#eee;
    margin-bottom:10px;
    padding: 6px;
  }
  p.header{
    border-bottom: 1px solid #eeeeee;
    font-size:17px;
    color:#8B8989;
  }
  .infotxt{
    font-size:14px;
  }
  .networktxt{
    border-bottom: 1px solid #eeeeee;
    font-size:17px;
    color:#8B8989;
    width:218px;
  }
  .relationships{
    padding-top:10px;
  }
  .interactionLinksDiv{
    padding-top:30px;
  }
  
  .album_photo_previous {
    float: left;
    width: 37px;
    height: 100%;
    vertical-align: middle;
    margin-top: 163px;
  }
  
  .album_photo_previous a {
    margin-top: 163px;
  }
  
  .album_photo {

  }
  
  .album_photo_next {
    float: right;
    height: 100%;
    vertical-align: middle;
    margin-top: 163px;
  }
</style>
<div id="is_profile" style="display:none;" >1</div>
<div id="page">
  <div class="name"><?php echo $member->getFullName() ?></div>
  <div class="location">
    <?php echo @$member->country ?>
  </div>
  <div class="interactionLinksDiv">
    <?php if ($member->id != Session::instance()->get('user_id') && $is_friend && Session::instance()->get('user_id') != false): ?>
      <a class="modal_link" href="#remove_friend" title="Remove <?php echo $member->getName() ?> as a Friend">Remove Friend</a>
    <?php endif; ?>
    <?php if ($member->id == Session::instance()->get('user_id')): ?>
      <a class="modal_link" href="#friend_requests"><?php echo Model_FriendRequest::getCountRequestsTo($member->id, true) ?></a>
    <?php endif; ?>
    <?php if ($member->id != Session::instance()->get('user_id') && !$is_friend): ?>
      <a class="modal_link" href="#add_friend" title="Add <?php echo $member->getName() ?> as a Friend">Add as Friend</a>
    <?php endif; ?>
    <?php if ($member->id != Session::instance()->get('user_id') && Session::instance()->get('user_id')): ?>
      <a class="modal_link" href="#private_message">Private Message</a>
    <?php endif; ?>
  </div>
  <div style="clear:both"></div>
  <div style="display:none">
    <div id="add_friend">
      Add <?php echo $member->getName(); ?> as a friend? &nbsp;
      <a href="#" onClick="return false"
	 onmousedown="javascript:addAsFriend(<?php echo $member->id ?>);">Yes</a>
      <span id="add_friend_loader"><img src="/content/images/loading.gif" width="28" height="10" alt="Loading"/></span>
    </div>
    <div id="remove_friend">
      Remove <?php echo $member->getName(); ?> from your friend list? &nbsp;
      <a href="#" onClick="return false" onMouseDown="javascript:removeAsFriend(<?php echo $member->id; ?>);">Yes</a>
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
	<br/><input name="pmSubmit" type="submit" value="Send"/> or <a href="#" onClick="return false"
								       onmousedown="javascript:closeModal()">Close</a>
	<span id="pmFormProcessGif" style="display:none;"><img src="/content/images/loading.gif" width="28"
							       height="10" alt="Loading"/></span>
      </form>
    </div>
  </div>
  <div id="left">
    <div class="photo">
      <div id="edit_profile">
	<a href="/profile/edit">Edit Profile</a>
      </div>
      <?php if ($member->has_profile_image): ?>
	<?php echo Images::getImage($member->id, 'image01.jpg', 218, 0, true, true) ?>
      <?php else: ?>
        <img src="/content/images/image01.jpg" width="218"/>
      <?php endif; ?>
      <div class="relationships">
	<?php echo @$member->generateShortFriendsList(); ?>
      </div>
      <div class="network">
	<?php if ($member->twitter): ?>
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
      </div>
    </div>
  </div>
  <div id="container2">
    <ul class="menu">
      <li id="wall" class="active">Profile Feed</li>
      <li id="links">About Me</li>
      <li id="info">Info</li>
      <li id="interests">Interests</li>
      <li id="photos">Photos</li>
    </ul>
    <span class="clear"></span>
    <div class="content wall">

      <div class="form">
	<div style="display:none;" id="current_feed_id"><?php echo $member->id; ?></div>
	<form action="/ajax/feed/new" id="share" method="post" enctype="multipart/form-data">
	  <textarea name="text" cols="30" rows="3" style="width: 445px" id="sharetext" placeholder="<?php if ($member->id == Session::instance()->get('user_id')): ?>Say something <?php echo $member->firstname ?>...<?php else: ?>Write on <?php echo $member->firstname ?>'s profile<?php endif; ?>"></textarea><br/>
	  <input name="submit" type="submit" value="Share!"/>&nbsp;
	  <input type="hidden" name="profile_flag" id="profile_flag" value="1" />
	</form>
      </div>
      <div style="width:485px; overflow:hidden;padding-top:8px;">
	<div id="feed">
	  <?php echo @$blabs; ?>
	</div>
	<table style="background-color:#FFF;" cellpadding="5" width="94%">
	  <tr style="padding:4px;">
	    <td>
	      <a href="javascript:void()" onClick="loadMore()">more</a>
	    </td>
	  </tr>
	</table>
      </div>
    </div>
    <div class="content links">
      <p class="header">About Me</p>
      <p class="infotxt"><?php echo @$member->bio_body; ?></p>
    </div>
    <div class="content info">
      <div class="parts">
	<p class="header">Gender</p>
	<p class="infotxt">
	  <?php if (@$member->gender == 'm'): ?>
  	  Male
	  <?php else: ?>
  	  Female
	  <?php endif; ?>
	</p>
	<?php if (@$member->facebook): ?>
  	<p class="header">Facebook</p>
  	<p class="smalltxt"><a href="http://facebook.com/<?php echo strip_tags(@$member->facebook); ?>"><?php echo strip_tags(@$member->facebook); ?></a></p>
	<?php endif; ?>

	<?php if (@$member->youtube): ?>
  	<p class="header">YouTube</p>
  	<p class="smalltxt"><a href="http://youtube.com/<?php echo strip_tags(@$member->youtube) ?>"><?php echo strip_tags(@$member->youtube); ?></a></p>
	<?php endif; ?>

	<?php if (@$member->website): ?>
  	<p class="header">Website</p>
  	<p class="infotxt"><a href="http://<?php echo strip_tags(@$member->website); ?>"><?php echo strip_tags(@$member->website) ?></a></p>
	<?php endif; ?>
      </div>
    </div>
    <div class="content interests">
      <?php if (@$member->music): ?>
        <p class="header">Music</p>
        <p class="infotxt"><?php echo strip_tags(@$member->music) ?></p>
      <?php endif; ?>
      <?php if (@$member->tv): ?>
        <p class="header">TV</p>
        <p class="infotxt"><?php echo strip_tags(@$member->tv) ?></p>
      <?php endif; ?>
      <?php if (@$member->movies): ?>
        <p class="header">Movies</p>
        <p class="infotxt"><?php echo strip_tags(@$member->movies) ?></p>
      <?php endif; ?>
      <?php if (@$member->books): ?>
        <p class="header">Books</p>
        <p class="infotxt"><?php echo strip_tags(@$member->books) ?></p>
      <?php endif; ?>
    </div>
    <div class="content photos" style="width:478px;">
      <p class="header"><?php echo @$photo->collection->name ?: "Photos" ?></p>
      <?php if(@$photo): ?>
      <div class="album_photo">
	<div class="album_photo_previous">
	  <?php $previous = $photo->previous() ?>
	  <?php if($previous): ?>
	  <a href="/photos/<?php echo $photo->previous() ?>"><img src="/content/images/notifications/left_arrow.jpg" style="padding:0" /></a>
	  <?php endif; ?>
	</div>
	<img src="<?php echo $photo->getUrl() ?>" width="385"/>
	<div class="album_photo_next">
	  <?php $next = $photo->next(); ?>
	  <?php if($next): ?>
	  <a href="/photos/<?php echo $photo->next() ?>"><img src="/content/images/notifications/right_arrow.jpg" style="padding:0" /></a>
	  <?php endif; ?>
	</div>
      </div>
      <?php endif; ?>
    </div>
  </div>
  <div class="clear"></div>
</div>
<style type="text/css">
<?php if ($member->has_background_image): ?>
    body {
      background-image: url(<?php echo Images::getImage($member->id, 'image02.jpg', false, false) ?>);
      background-repeat: repeat;
      background-position: center top;
    }
<?php endif; ?>
</style>
<script type="text/javascript">
  bindThumbsUp();
  
  <?php if(@$photo): ?>
    //change status & style menu
  $("#wall").removeClass("active");
  $("#info").removeClass("active");
  $("#links").removeClass("active");
  $("#interests").removeClass("active");
  $("#photos").addClass("active");
  //display selected division, hide others
  $("div.info").css("display", "none");
  $("div.wall").css("display", "none");
  $("div.links").css("display", "none");
  $("div.interests").css("display", "none");
  $("div.photos").fadeIn();
  <?php endif; ?>
</script>
<script type="text/javascript" src="/content/js/tabs.js"></script>
</body>
</html>

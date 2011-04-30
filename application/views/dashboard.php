<script type="text/javascript" charset="utf-8" src='/content/css/js/jquery.js'></script>
	<script type="text/javascript" charset="utf-8">
		$(window).load(function(){
			
			//set and get some variables
			var thumbnail = {
				imgIncrease : 100, /* the image increase in pixels (for zoom) */
				effectDuration : 400, /* the duration of the effect (zoom and caption) */
				/* 
				get the width and height of the images. Going to use those
				for 2 things:
					make the list items same size
					get the images back to normal after the zoom 
				*/
				imgWidth : $('.thumbnailWrapper ul li').find('img').width(), 
				imgHeight : $('.thumbnailWrapper ul li').find('img').height() 
				
			};
			
			//make the list items same size as the images
			$('.thumbnailWrapper ul li').css({ 
				
				'width' : thumbnail.imgWidth, 
				'height' : thumbnail.imgHeight 
				
			});
			
			//when mouse over the list item...
			$('.thumbnailWrapper ul li').hover(function(){
				
				$(this).find('img').stop().animate({
					
					/* increase the image width for the zoom effect*/
					width: parseInt(thumbnail.imgWidth) + thumbnail.imgIncrease,
					/* we need to change the left and top position in order to 
					have the zoom effect, so we are moving them to a negative
					position of the half of the imgIncrease */
					left: thumbnail.imgIncrease/2*(-1),
					top: thumbnail.imgIncrease/2*(-1)
					
				},{ 
					
					"duration": thumbnail.effectDuration,
					"queue": false
					
				});
				
				//show the caption using slideDown event
				$(this).find('.caption:not(:animated)').slideDown(thumbnail.effectDuration);
				
			//when mouse leave...
			}, function(){
				
				//find the image and animate it...
				$(this).find('img').animate({
					
					/* get it back to original size (zoom out) */
					width: thumbnail.imgWidth,
					/* get left and top positions back to normal */
					left: 0,
					top: 0
					
				}, thumbnail.effectDuration);
				
				//hide the caption using slideUp event
				$(this).find('.caption').slideUp(thumbnail.effectDuration);
				
			});
			
		});
	</script>
	<style type="text/css">
#right{
        float:right;
        background-color:white;
        width:255px;
        height:660px;
        -moz-border-radius: 20px;
        -webkit-border-radius: 20px;
        -khtml-border-radius: 20px;
        margin-right:25px;
}
h5{
		color:white;
		text-align:center;
		font-size:1em;
}
.options{
		width:255px;
}
.notifications{
		text-align:center;
		height:300px;
		width:250px;
		
}
h2{
	text-align:center;
}
p{
	text-align:center;
	font-family:'Myriad Pro',Arial, Helvetica, sans-serif;
	font-size:17px;
}
.top{
	padding-top:20px;
	padding-left:10px;
}
.blab_photo{
	width:75px;
	height:75px;
	background-color:black;
	float:left;
	margin-top:15px;
	margin-left:10px;
}
.links{
	float:right;
	padding-right:30px;
}
.recent_status{
	padding-top:100px;
	width:240px;
	margin-right:auto;
	margin-left:auto;
}
.suggestions{
	padding-top:0px;
	font-family:'Myriad Pro',Arial, Helvetica, sans-serif;
	font-size:17px;
}
.stbody{
	min-height:70px;
}
.stbody{
	min-height:70px;
	margin-bottom:10px;
	border-bottom: 1px solid #eeeeee;
}
.stimg{
	float:left;
	height:50px;
	width:50px;
	border:solid 1px #dedede;
	padding:5px;
	margin-left:5px;
}
.sttext{
	margin-left:70px;
	min-height:50px;
	word-wrap:break-word;
	overflow:hidden;
	padding:5px;
	display:block;
	font-family:'Georgia', Times New Roman, Times, serif
}
.sttime{
	font-size:10px;
	color:#999;
	font-family:Arial, Helvetica, sans-serif;
	margin-top:5px;
	width:250px;
}
.more{
	margin-left:5px;
}
	</style>
	<div id="right">
            <div class="top">
			<div class="blab_photo">
				</div>
			<div class="links">
				<ul>
				<li><a href="/<?php echo Session::instance()->get('username') ?>">My Profile</a>
				<li><a href="/<?php echo Session::instance()->get('username') ?>">Friend Request</a>
				<li><a href="<a href="/profile/edit">Edit Profile</a>
				<li><a href="/stats">My Stats</a>
				</div>
			</div>
		<div class="recent_status">
			<p>My Most Recent Update</p>
			<p class="status">"Some random status goes here!" in <a href="#">thoughts</a></p>
		</div>
		<div class="suggestions">
			<p>Friend Suggestions</p>
			<div class="stbody"> 
			<div class="stimg"> 
			</div> 
			<div class="sttext"> 
			<a href="#">Random User</a> 
			<div class="sttime"><a href="#">Add as Friend</a> | <a href="#">Remove</a></div> 
			</div> 
			</div>
			<div class="stbody"> 
			<div class="stimg"> 
			</div> 
			<div class="sttext"> 
			<a href="#">Random User</a> 
			<div class="sttime"><a href="#">Add as Friend</a> | <a href="#">Remove</a></div> 
			</div> 
			</div>
			<div class="stbody"> 
			<div class="stimg"> 
			</div> 
			<div class="sttext"> 
			<a href="#">Random User</a> 
			<div class="sttime"><a href="#">Add as Friend</a> | <a href="#">Remove</a></div> 
			</div> 
			</div>
			<div class="stbody"> 
			<div class="stimg"> 
			</div> 
			<div class="sttext"> 
			<a href="#">Random User</a> 
			<div class="sttime"><a href="#">Add as Friend</a> | <a href="#">Remove</a></div> 
			</div> 
			</div>
			<div class="more">
			<a href="#">See more..</a>
			</div>
		</div>
	</div>
<div id="content">
<div class='thumbnailWrapper'>
	
		<ul>
			<li>
				<a href='/feed/1'><img src='/content/images/1.jpg' /></a>
				<div class='caption'>
					<p class='captionInside'>Music</p>
				</div>
			</li>
			<li>
				<a href='/feed/2'><img src='/content/images/2.jpg' /></a>
				<div class='caption'>
					<p class='captionInside'>TV</p>
				</div>
			</li>
			<li>
				<a href='/feed/4'><img src='/content/images/3.jpg' /></a>
				<div class='caption'>
					<p class='captionInside'>Location</p>
				</div>
			</li>
			<li>
				<a href='/feed/3'><img src='/content/images/4.jpg' /></a>
				<div class='caption'>
					<p class='captionInside'>Movies</p>
				</div>
			</li>
			<li>
				<a href='/feed/5'><img src='/content/images/6.jpg' /></a>
				<div class='caption'>
					<p class='captionInside'>Reading</p>
				</div>
			</li>
			<li>
				<a href='/feed/6'><img src='/content/images/7.jpg' /></a>
				<div class='caption'>
					<p class='captionInside'>Games</p>
				</div>
			</li>
			<li>
				<a href='/feed/7'><img src='/content/images/8.jpg' /></a>
				<div class='caption'>
					<p class='captionInside'>Photos</p>
				</div>
			</li>
			<li>
				<a href='/feed/8'><img src='/content/images/9.jpg' /></a>
				<div class='caption'>
					<p class='captionInside'>Videos</p>
				</div>
			</li>
			<li>
				<a href='/feed/9'><img src='/content/images/10.jpg' /></a>
				<div class='caption'>
					<p class='captionInside'>Thoughts</p>
				</div>
			</li>
			<li>
				<a href='/friends'><img src='/content/images/11.jpg' /></a>
				<div class='caption'>
					<p class='captionInside'>My Friends</p>
				</div>
			</li>
			<div class='clear'></div>
			
		</ul>
	</div>
	</div>
<?php if(Session::instance()->get('flash_facebook')): ?>
<?php Session::instance()->delete('flash_facebook'); ?>
<div id="fb-root"></div>
      <script src="http://connect.facebook.net/en_US/all.js">
      </script>
      <script>
         FB.init({
            appId:'204162316278860', cookie:true,
            status:true, xfbml:true
         });

         FB.ui({
             method: 'feed',
             link: 'http://swiftsharing.net',
             description: 'SwiftSharing is a new way to share what you\'re doing with friends, fast. We\'re busy improving the beta version we released on January 11, 2011',
             message: 'I just signed up for SwiftSharing with my Facebook account! Check it out - http://swiftsharing.net/',
             caption: 'A New, Fresh Social Network'
        });
      </script>
<?php endif; ?>

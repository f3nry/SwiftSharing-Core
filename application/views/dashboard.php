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
.suggestions{
		text-align:center;
		height:200px; 
		width:250px;
		border-bottom:1px dashed;
}
.notifications{
		text-align:center;
		height:300px;
		width:250px;
		
}
h2{
	text-align:center;
}
	</style>
	<div id="right">
	<div class="photo">
                <?php print @$blabber_pic; ?>
            </div>
            <div class="options">
                <li><a href="/profile/edit">Edit Profile</a></li>
                <li><a href="/<?php echo Session::instance()->get('username') ?>">Friend Request</a></li>
                <li><a href="/<?php echo Session::instance()->get('username') ?>">View Profile</a></li>
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

<style type="text/css">
#stuff{
	background-color:white;
	height:350px;
	width:600px;
	margin-left:auto;
	margin-right:auto;
	margin-top:50px;
	-moz-border-radius: 20px;
    -webkit-border-radius: 20px;
    -khtml-border-radius: 20px;
    border-radius: 20px;
}
small{
	font-size: 15px;
	font-family: "Helvetica", Arial, sans-serif;
}
#page{
	height:250px;
	width:590px;
}
.text{
	margin-left:10px;
	font-family:"Helvetica", Arial, sans-serif;
	font-size: 30px;
	margin-bottom:5px;
	border-bottom: 1 px solid;
}

.bottom{
	margin-top:100px;
	font-family:"Helvetica", Arial, sans-serif;
	font-size: 15px;
	text-align:center;
	margin-bottom:15px;
}
.img{
	text-align:center;
}
#page{
	text-align:center;
}
.social { 
	list-style:none; 
	margin:30px auto; 
	width:464px; 
}
.social li { 
	display:inline; 
	float:left; 
	background-repeat:no-repeat; 
}
.social li a { 
	display:block; 
	width:48px; 
	height:48px; 
	padding-right:10px; 
	position:relative; 
	text-decoration:none; 
}
.social li a strong{ 
	font-weight:normal; 
	position:absolute; 
	left:20px; 
	top:-1px; 
	color:#fff; 
	padding:3px; 
	z-index:9999;
	text-shadow:1px 1px 0 rgba(0, 0, 0, 0.75); 
	background-color:rgba(0, 0, 0, 0.7);
 	-moz-border-radius:3px; 
 	-moz-box-shadow: 0 0 5px rgba(0, 0, 0, 0.5); 
 	-webkit-border-radius:3px; 
 	-webkit-box-shadow: 0 0 5px rgba(0, 0, 0, 0.5); 
 	border-radius:3px; 
 	box-shadow: 0 0 5px rgba(0, 0, 0, 0.5);
}
li.delicious { 
	background-image:url("/content/images/delicious.png"); 
}
li.reddit { 
	background-image:url("/content/images/reddit.png"); 
}
#css3:hover li { 
opacity:0.2; }
#css3 li { 
	-webkit-transition-property: opacity; 
	-webkit-transition-duration: 500ms;
	-moz-transition-property: opacity; 
 	-moz-transition-duration: 500ms; 
 }
#css3 li a strong { 
	opacity:0;
 -webkit-transition-property: opacity, top; 
 -webkit-transition-duration: 300ms;
 -moz-transition-property: opacity, top; 
 -moz-transition-duration: 300ms; 
}
#css3 li:hover { 
	opacity:1; 
}
#css3 li:hover a strong { 
	opacity:1; top:-10px; 
}
.skip{
	float:right;
	margin-right:10px;
	font-size:25px;
	margin-top:10px;
}
</style>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script type="text/javascript" src="/content/js/script.js"></script>
<div id="stuff">
	<div id="page">
	<div class="text">
		One last thing! <small>Share <a href="http://swiftsharing.net">SwiftSharing</a> with your friends with a link below!</small>
		</div>
	<ul class="social" id="css3">
			<li class="delicious">
				<a href="http://www.delicious.com/save" onclick="window.open('http://www.delicious.com/save?v=5&noui&jump=close&url='+encodeURIComponent(location.href)+'&title='+encodeURIComponent(document.title), 'delicious','toolbar=no,width=550,height=550'); return false;"></a>
			</li>
			<li class="facebook">
<iframe src="http://www.facebook.com/plugins/like.php?href=http%3A%2F%2Fswiftsharing.net&amp;layout=box_count&amp;show_faces=false&amp;width=200&amp;action=like&amp;font&amp;colorscheme=light&amp;height=65" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:60px; height:65px;" allowTransparency="true"></iframe>			</li>
			<li class="reddit">
				<a href="http://www.reddit.com/submit" onclick="window.location = 'http://www.reddit.com/submit?url=' + encodeURIComponent(window.location); return false"></a>
			</li>
			<li class="twitter">
				<a href="http://twitter.com/share" class="twitter-share-button" data-count="none" data-via="SwiftSharing"></a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
			</li>
			<li class="myspace">
				<a href="javascript:void(window.open('http://www.myspace.com/Modules/PostTo/Pages/?u='+encodeURIComponent(document.location.toString()),'ptm','height=450,width=550').focus())">
    		<img src="http://cms.myspacecdn.com/cms//ShareOnMySpace/Myspace_36.png" border="0" alt="Share on Myspace" />
				</a>
			<li class="buzz">
				<a title="Post to Google Buzz" class="google-buzz-button" href="http://www.google.com/buzz/post" data-button-style="normal-count"></a>
				<script type="text/javascript" src="http://www.google.com/buzz/api/button.js"></script>
			</li>
			<li class="stumbleupon">
				<script src="http://www.stumbleupon.com/hostedbadge.php?s=5"></script>
			</li>
			</li>
		</ul>
	<div class="bottom">
		Spread the word about <a href="http://swiftsharing.net">SwiftSharing</a> to everyone you know on multiple networks!
	</div>
	<div class="img">
		<img src="/content/images/icon.jpg"></img>
	</div>
	<div class="skip">
		Or, <a href="/">skip</a> this step....
	</div>
</div>
</div>

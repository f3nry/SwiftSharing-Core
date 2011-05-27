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
	<h2>My Statistics</h2>
	<div class="music-posts">
		</div>
	<div class="tv-posts">
		</div>
	<div class="movie-posts">
		</div>
	<div class="reading-posts">
		</div>
	<div class="game-posts">
		</div>
	<div class="photo-posts">
		</div>
	<div class="video-posts">
		</div>
	<div class="thought-posts">
		</div>
	</div>
	</div>


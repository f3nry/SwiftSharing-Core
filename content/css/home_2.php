<?php
include 'likes/thumbsup/core/thumbsup.php';
// Start_session, check if user is logged in or not, and connect to the database all in one included file
include_once("scripts/checkuserlog.php");
require_once "libs/photo_functions.php";
require_once "libs/feed_functions.php";

if (!$_SESSION['idx']) {
    $msgToUser = '<br /><br /><font color="#FF0000">You must be a member to access this page.</font><p><a href="register.php">Join Here</a></p>';
    include_once 'msgToUser.php';
    exit();
} else if ($logOptions_id != $_SESSION['id']) {
    $msgToUser = '<br /><br /><font color="#FF0000">You must be a member to access this page.</font><p><a href="register.php">Join Here</a></p>';
    include_once 'msgToUser.php';
    exit();
}

// Include the class files for auto making links out of full URLs and for Time Ago date formatting
include_once("wi_class_files/autoMakeLinks.php");
include_once ("wi_class_files/agoTimeFormat.php");

// Include this script for random member display on home page
include_once "scripts/homePage_randomMembers.php";

if (@$_POST['blab_field']) {
    $blab_field = $_POST['blab_field'];
    $blab_field = stripslashes($blab_field);
    $blab_field = strip_tags($blab_field);
    $blab_field = mysql_real_escape_string($blab_field);
    $blab_field = str_replace("'", "&#39;", $blab_field);
    if ($_POST['feed_id']) {
        $feed_id = mysql_real_escape_string($_POST['feed_id']);
    } else {
        $feed_id = 1;
    }

    $sql = mysql_query("INSERT INTO blabs (mem_id, text, date, feed_id) VALUES('{$_SESSION['id']}','$blab_field', now(), $feed_id)") or die(mysql_error());
    $blab_outout_msg = "";

    if (@$_GET['ajax']) {
        $blab_id = mysql_insert_id();

        $query = "SELECT b.id, mem_id, text as the_blab, date as blab_date, m.username as username, m.firstname as firstname, m.lastname as lastname
							FROM blabs b
							LEFT JOIN myMembers m ON mem_id = m.id
							WHERE b.id = $blab_id";

        $result = mysql_query($query) or die('Failed to execute query.');

        $row = mysql_fetch_array($result);

        echo get_blab($row, $thumbsup);

        die;
    } else {
        Header("Location: /home.php");
        exit();
    }
}

if (isset($_GET['ajax']) && $_GET['ajax'] == true) {
    if ($_POST['action'] == 'get_comments') {
        $result = mysql_query("SELECT b.id, mem_id, text as the_blab, date as blab_date, m.username as username, m.firstname as firstname, m.lastname as lastname
								FROM blabs b
								LEFT JOIN myMembers m ON mem_id = m.id
								WHERE b.id = " . $_POST['blab_id']) or die(mysql_error());

        $blab = mysql_fetch_array($result);

        echo json_encode(array(
            "blab" => get_blab($blab, $thumbsup, false),
        ));

        exit;
    }
}

$outputList = '';

if (!is_numeric($feed_id = mysql_real_escape_string($_GET['id']))) {
    $feed_id = 1;
}

$feed = get_feed_data($feed_id);

$sql_blabs = get_feed_blabs($feed_id);

$blabberDisplayList = "";

while ($row = mysql_fetch_array($sql_blabs)) {
    $blabberDisplayList .= get_blab($row, $thumbsup);
}

if (@$_GET['action']) {
    if ($_GET['ajax'] == true) {
        echo $blabberDisplayList;
        die;
    }
}
?>
<?php
// Include this script for random member display on home page
include_once "scripts/homePage_randomMembers.php";
?>
<?php
///////  Mechanism to Display Pic. See if they have uploaded a pic or not  //////////////////////////
	$ucheck_pic = "members/$uid/image01.jpg";
	$udefault_pic = "members/0/image01.jpg";
	if (file_exists($ucheck_pic)) {
		$blabber_pic = '<div style="overflow:hidden; width:40px; height:40px;">' . get_image($ucheck_pic, 40, 0, true, true) . '</div>'; // forces picture to be 100px wide and no more
	} else {
		$blabber_pic = "<img src=\"$udefault_pic\" width=\"100px\" height=\"100px\" border=\"0\" />"; // forces default picture to be 100px wide and no more
	}
?>
<html>
<head>
<title>SwiftSharing</title>
<link rel="stylesheet" type="text/css" href="screen.css">
		
        <link rel="stylesheet" type="text/css" href="/css/new.css" />
        <link rel="stylesheet" type="text/css" href="/css/screen.css" />
        <link rel="stylesheet" href="/js/css/cupertino/jquery-ui-1.8.9.custom.css" type="text/css" />
        <script type="text/javascript" src="http://swiftsharing.net/js/js/jquery-1.4.4.min.js"></script>
        <script type="text/javascript" src="http://swiftsharing.net/js/js/jquery-ui-1.8.9.custom.min.js"></script>
        <script type="text/javascript" src="<?php echo THUMBSUP_WEBROOT ?>thumbsup/core/thumbsup.js.php"></script>
        <script type="text/javascript" src="/js/feed.js"></script>
</head>
<body>
<div id="wrapper">
	<div id="header">
		    <div style="margin-left:50px;">
        <ul id="menu">
            <li class="logo">
                <img style="float:left;" alt="" src="images/menu_left.png"/>
                
                
            </li>
            <li><a href="#">Messages</a>
            </li>
            <li><a href="#">Profile</a></li>
            <li><a href="#">Friends</a></li>
            <li><a href="#">Logout</a></li>
                
            
            <li class="searchContainer">
                <div>
                <input type="text" id="searchField" />
                <img src="images/magnifier.png" alt="Search" onclick="alert('You clicked on search button')" /></div>
                
            </li>
        </ul>
        <img style="float:left;" alt="" src="images/menu_right.png"/>
    </div>
	</div>
	<div id="container">
		<div id="side-a">
			
		</div>
		
		<div id="content">
		<div class="posts">
		Music (Share What You're Listening To)
			<form action="#">
			<textarea name="blab_field" cols=50 rows=3 id="sharetext"></textarea>
                            <input name="submit" type="submit" value="Share!"/>&nbsp;<input type="checkbox" checked="checked" id="auto-update">Auto-update feed
                        </form>
									</div>
									<div class="postbody"> 
									<div class="img"> 
										<img src="photo.jpg" style='width:50px;height:50px'/> 
												</div> 
										<div class="text"> 
										Test Post 
										<div class="time">25 seconds ago</div> 
										<div class="comment">
										<a href="#">0 Comments</a>
										</div>
											</div> 
</div>
		</div>
		
		<div id="side-b">
		<div class="photo">
		<?php print "$blabber_pic"; ?>
				</div>
			<div class="options">
				<li><a href="#">Edit Profile</a></li>
				<li><a href="#">Change Photo</a></li>
				<li><a href="#">Friend Request</a></li>
				<li><a href="#">View Profile</a></li>
				</div>
			<div class="feed">
			<h3>Your Feeds</h3>
			<?php echo generate_feed_list(); ?>
		</div>
	</div>
	<div id="footer">
		<p>SwiftSharing</p>
	</div>
</div>
</body>
</html>

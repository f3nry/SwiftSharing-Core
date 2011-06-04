<?php

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/* ADVANCED */

define('SET_SESSION_NAME','PHPSESSID');			// Session name
define('DO_NOT_START_SESSION','1');		// Set to 1 if you have already started the session
define('DO_NOT_DESTROY_SESSION','0');	// Set to 1 if you do not want to destroy session on logout
define('SWITCH_ENABLED','0');		
define('INCLUDE_JQUERY','0');	
define('FORCE_MAGIC_QUOTES','0');

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/* DATABASE */

if(strpos('swiftsharing.net', $_SERVER['SERVER_NAME']) !== false) {
	define('DB_SERVER',					'mysql.mphwebsystems.com'								);
	define('DB_PORT',					'3306'									);
	define('DB_USERNAME',				'swshare_remote'									);
	define('DB_PASSWORD',				'jDcZ9hRaC76mvQX8'								);
	define('DB_NAME',					'swshare_swift'								);
	define('TABLE_PREFIX',				''										);
	define('DB_USERTABLE',				'myMembers'									);
	define('DB_USERTABLE_NAME',			'username'								);
	define('DB_USERTABLE_USERID',		'id'								);
	define('DB_USERTABLE_LASTACTIVITY',	'last_active'							);	
} else {
	define('DB_SERVER',					'localhost'								);
	define('DB_PORT',					'3306'									);
	define('DB_USERNAME',				'root'									);
	define('DB_PASSWORD',				''								);
	define('DB_NAME',					'swiftsharing'								);
	define('TABLE_PREFIX',				''										);
	define('DB_USERTABLE',				'myMembers'									);
	define('DB_USERTABLE_NAME',			'username'								);
	define('DB_USERTABLE_USERID',		'id'								);
	define('DB_USERTABLE_LASTACTIVITY',	'last_active'							);
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/* FUNCTIONS */

global $mongo;
global $_update_id;

$mongo = new Mongo();

date_default_timezone_set('America/Chicago');

function session_open($save_path, $session_name) {
	global $mongo;
	
	return true;
}

function session_close() {
	return true;
}

function session_read($id) {
	global $mongo, $_update_id;
	
	if($id = get_cookie(SET_SESSION_NAME, NULL)) {
		
        $doc = $mongo->swiftsharing->sessions->findOne(
            array('session_id' => $id)
        );

        if($doc != null) {
	
            return base64_decode($doc['contents']);
        }
    }

    return null;
}

function session_write($id, $data) {
	global $mongo, $_update_id;
	
	$data = base64_encode(serialize($_SESSION));
	
	if($mongo == null) {
		$mongo = new Mongo();
	}
	
	$id = get_cookie(SET_SESSION_NAME, NULL);
	
	$mongo->swiftsharing->sessions->update(
        array(
            'session_id' => $id,
        ),
        array(
            '$set' => array(
                'last_active' => time(),
                'contents' => $data,
            )
        ),
        array(
            'multiple' => false
        )
    );

	return true;
}

function sess_destroy($id) {
	global $mongo;
	
	try {
        $mongo->swiftsharing->sessions->remove(
            array(
                'session_id' => $id
            ),
            array(
                'justOne' => true,
                'fsync' => true
            )
        );
    } catch (Exception $e) {
        return false;
    }

	return true;
}

function session_gc($maxlifetime) {
	return true;
}

function get_cookie($key, $default) {
	if ( ! isset($_COOKIE[$key]))
	{
		// The cookie does not exist
		return $default;
	}

	// Get the cookie value
	$cookie = $_COOKIE[$key];

	// Find the position of the split between salt and contents
	$split = strlen(cookie_salt($key, NULL));

	if (isset($cookie[$split]) AND $cookie[$split] === '~')
	{
		// Separate the salt and the value
		list ($hash, $value) = explode('~', $cookie, 2);

		if (cookie_salt($key, $value) === $hash)
		{
			// Cookie signature is valid
			return $value;
		}

		// The cookie signature is invalid, delete it
		// Remove the cookie
		unset($_COOKIE[$key]);

		// Nullify the cookie and make it expire
		return setcookie($key, NULL, -86400);
	}

	return $default;
}

function cookie_salt($name, $value) {
	$agent = isset($_SERVER['HTTP_USER_AGENT']) ? strtolower($_SERVER['HTTP_USER_AGENT']) : 'unknown';

	return sha1($agent.$name.$value.'1df4a');
}

session_set_save_handler('session_open', 'session_close', 'session_read', 'session_write', 'sess_destroy', 'session_gc');

session_start();

$_SESSION = unserialize(session_read(null));

function getUserID() {
	$userid = 0;
	
	if (!empty($_SESSION['user_id'])) {
		$userid = $_SESSION['user_id'];
	}

	return $userid;
}


function getFriendsList($userid,$time) {
	$sql = (
		"select DISTINCT myMembers.id as userid, myMembers.username as username, myMembers.last_active as lastactivity, myMembers.id as avatar, myMembers.username as link, 
		cometchat_status.message, cometchat_status.status 
		from friend_relationships 
		join myMembers on friend_relationships.`to` = myMembers.id 
		left join cometchat_status on myMembers.id = cometchat_status.userid 
		where friend_relationships.`from` = '".mysql_real_escape_string($userid)."' order by username asc");
	
	return $sql;
}

function getUserDetails($userid) {
	$sql = ("select ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." userid, ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_NAME." username, ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_LASTACTIVITY." lastactivity,  ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." link,  ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." avatar, cometchat_status.message, cometchat_status.status from ".TABLE_PREFIX.DB_USERTABLE." left join cometchat_status on ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." = cometchat_status.userid where ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." = '".mysql_real_escape_string($userid)."'");
	
	return $sql;
}

function updateLastActivity($userid) {
	$sql = ("update `".TABLE_PREFIX.DB_USERTABLE."` set last_active = NOW() where ".DB_USERTABLE_USERID." = '".mysql_real_escape_string($userid)."'");
	return $sql;
}

function getUserStatus($userid) {
	 $sql = ("select cometchat_status.message, cometchat_status.status from cometchat_status where userid = '".mysql_real_escape_string($userid)."'");
	 return $sql;
}

function getLink($link) {
    return "/$link";
}

function getTimeStamp() {
  return time();
}

function getAvatar($image) {
    $mongo = new Mongo();

	$doc = $mongo->swiftsharing->images->find(array(
		'member' => intval($image),
		'bucket' => 'swiftsharing-cdn',
		'filename' => 'image01',
		'width' => 50,
		'height' => 0
	));
	
	if($doc) {
		return "http://s3.amazonaws.com/swiftsharing-cdn/members/$image/image01x50x0xed.jpg";
	} else {
		return "/content/images/image01.jpg";
	}
}

function processTime($time) {
    return strtotime($time);
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/* HOOKS */

function hooks_statusupdate($userid,$statusmessage) {
	
}

function hooks_forcefriends() {
	
}

function hooks_activityupdate($userid,$status) {

}

function hooks_message($userid,$unsanitizedmessage) {
	
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/* LICENSE */

include_once(dirname(__FILE__).'/license.php');
$x="\x62a\x73\x656\x34\x5fd\x65c\157\144\x65";
eval($x('JHI9ZXhwbG9kZSgnLScsJGxpY2Vuc2VrZXkpOyRwXz0wO2lmKCFlbXB0eSgkclsyXSkpJHBfPWludHZhbChwcmVnX3JlcGxhY2UoIi9bXjAtOV0vIiwnJywkclsyXSkpOw'));

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
<?php defined('SYSPATH') or die('No direct script access.'); ?>

2011-03-30 01:17:30 --- ERROR: Http_Exception_404 [ 404 ]: Unable to find a route to match the URI: content/css/js/jquery.js ~ SYSPATH/classes/kohana/request.php [ 733 ]
2011-03-30 01:18:09 --- ERROR: Http_Exception_404 [ 404 ]: Unable to find a route to match the URI: content/css/js/jquery.js ~ SYSPATH/classes/kohana/request.php [ 733 ]
2011-03-30 01:19:43 --- ERROR: Http_Exception_404 [ 404 ]: Unable to find a route to match the URI: content/css/js/jquery.js ~ SYSPATH/classes/kohana/request.php [ 733 ]
2011-03-30 01:20:23 --- ERROR: Http_Exception_404 [ 404 ]: Unable to find a route to match the URI: content/css/js/jquery.js ~ SYSPATH/classes/kohana/request.php [ 733 ]
2011-03-30 01:21:53 --- ERROR: Http_Exception_404 [ 404 ]: Unable to find a route to match the URI: content/css/js/jquery.js ~ SYSPATH/classes/kohana/request.php [ 733 ]
2011-03-30 01:25:15 --- ERROR: Http_Exception_404 [ 404 ]: Unable to find a route to match the URI: notification.png ~ SYSPATH/classes/kohana/request.php [ 733 ]
2011-03-30 01:25:15 --- ERROR: Http_Exception_404 [ 404 ]: Unable to find a route to match the URI: content/css/js/jquery.js ~ SYSPATH/classes/kohana/request.php [ 733 ]
2011-03-30 01:25:16 --- ERROR: Http_Exception_404 [ 404 ]: Unable to find a route to match the URI: notification.png ~ SYSPATH/classes/kohana/request.php [ 733 ]
2011-03-30 01:25:55 --- ERROR: Http_Exception_404 [ 404 ]: Unable to find a route to match the URI: content/css/js/jquery.js ~ SYSPATH/classes/kohana/request.php [ 733 ]
2011-03-30 01:25:55 --- ERROR: Http_Exception_404 [ 404 ]: Unable to find a route to match the URI: notification.png ~ SYSPATH/classes/kohana/request.php [ 733 ]
2011-03-30 01:26:19 --- ERROR: Http_Exception_404 [ 404 ]: Unable to find a route to match the URI: content/css/js/jquery.js ~ SYSPATH/classes/kohana/request.php [ 733 ]
2011-03-30 01:26:19 --- ERROR: Http_Exception_404 [ 404 ]: Unable to find a route to match the URI: notification.png ~ SYSPATH/classes/kohana/request.php [ 733 ]
2011-03-30 01:27:34 --- ERROR: Http_Exception_404 [ 404 ]: Unable to find a route to match the URI: notification.png ~ SYSPATH/classes/kohana/request.php [ 733 ]
2011-03-30 01:27:36 --- ERROR: Database_Exception [ 0 ]: [1064] You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'AND (b.type = 'STATUS' OR type = 'PHOTO')  AND ((m.privacy_option != 'locked' AN' at line 6 ( SELECT b.id, b.mem_id, b.type, b.feed_id, b.text, b.`date`, b.likes as likes,
                         f.title as feed_title,
                         m.username as username, m.firstname as firstname, m.lastname as lastname, m.friend_array as friends, m.privacy_option as privacy_option, m.has_profile_image
                    FROM blabs b
                    LEFT JOIN myMembers m ON b.mem_id = m.id
                    LEFT JOIN feeds f ON f.id = b.feed_id LEFT JOIN friend_relationships fr ON fr.to = b.mem_id WHERE feed_id =  AND (b.type = 'STATUS' OR type = 'PHOTO')  AND ((m.privacy_option != 'locked' AND m.privacy_option != 'limited') OR  (b.mem_id = 4792 OR fr.from = b.mem_id))  GROUP BY b.id ORDER BY date DESC LIMIT 15 ) ~ MODPATH/database/classes/kohana/database/mysql.php [ 181 ]
2011-03-30 01:27:38 --- ERROR: Http_Exception_404 [ 404 ]: Unable to find a route to match the URI: content/css/js/jquery.js ~ SYSPATH/classes/kohana/request.php [ 733 ]
2011-03-30 01:27:38 --- ERROR: Http_Exception_404 [ 404 ]: Unable to find a route to match the URI: notification.png ~ SYSPATH/classes/kohana/request.php [ 733 ]
2011-03-30 01:28:14 --- ERROR: Http_Exception_404 [ 404 ]: Unable to find a route to match the URI: content/css/js/jquery.js ~ SYSPATH/classes/kohana/request.php [ 733 ]
2011-03-30 01:28:14 --- ERROR: Http_Exception_404 [ 404 ]: Unable to find a route to match the URI: notification.png ~ SYSPATH/classes/kohana/request.php [ 733 ]
2011-03-30 01:29:53 --- ERROR: Http_Exception_404 [ 404 ]: Unable to find a route to match the URI: content/css/js/jquery.js ~ SYSPATH/classes/kohana/request.php [ 733 ]
2011-03-30 01:29:53 --- ERROR: Http_Exception_404 [ 404 ]: Unable to find a route to match the URI: notification.png ~ SYSPATH/classes/kohana/request.php [ 733 ]
2011-03-30 01:30:13 --- ERROR: Http_Exception_404 [ 404 ]: Unable to find a route to match the URI: content/css/js/jquery.js ~ SYSPATH/classes/kohana/request.php [ 733 ]
2011-03-30 01:30:35 --- ERROR: Database_Exception [ 0 ]: [1064] You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'AND (b.type = 'STATUS' OR type = 'PHOTO')  AND ((m.privacy_option != 'locked' AN' at line 6 ( SELECT b.id, b.mem_id, b.type, b.feed_id, b.text, b.`date`, b.likes as likes,
                         f.title as feed_title,
                         m.username as username, m.firstname as firstname, m.lastname as lastname, m.friend_array as friends, m.privacy_option as privacy_option, m.has_profile_image
                    FROM blabs b
                    LEFT JOIN myMembers m ON b.mem_id = m.id
                    LEFT JOIN feeds f ON f.id = b.feed_id LEFT JOIN friend_relationships fr ON fr.to = b.mem_id WHERE feed_id =  AND (b.type = 'STATUS' OR type = 'PHOTO')  AND ((m.privacy_option != 'locked' AND m.privacy_option != 'limited') OR  (b.mem_id = 4792 OR fr.from = b.mem_id))  GROUP BY b.id ORDER BY date DESC LIMIT 15 ) ~ MODPATH/database/classes/kohana/database/mysql.php [ 181 ]
2011-03-30 01:57:39 --- ERROR: Http_Exception_404 [ 404 ]: Unable to find a route to match the URI: content/css/js/jquery.js ~ SYSPATH/classes/kohana/request.php [ 733 ]
2011-03-30 01:58:39 --- ERROR: Http_Exception_404 [ 404 ]: Unable to find a route to match the URI: content/css/js/jquery.js ~ SYSPATH/classes/kohana/request.php [ 733 ]
2011-03-30 02:00:05 --- ERROR: Http_Exception_404 [ 404 ]: Unable to find a route to match the URI: content/css/js/jquery.js ~ SYSPATH/classes/kohana/request.php [ 733 ]
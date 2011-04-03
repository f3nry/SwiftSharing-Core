<?php defined('SYSPATH') or die('No direct script access.'); ?>

2011-04-03 00:04:28 --- ERROR: Http_Exception_404 [ 404 ]: Unable to find a route to match the URI: content/css/js/jquery.js ~ SYSPATH/classes/kohana/request.php [ 733 ]
2011-04-03 00:57:07 --- ERROR: Http_Exception_404 [ 404 ]: Unable to find a route to match the URI: youtube-icon.jpg ~ SYSPATH/classes/kohana/request.php [ 733 ]
2011-04-03 00:57:07 --- ERROR: Http_Exception_404 [ 404 ]: Unable to find a route to match the URI: icon.jpg ~ SYSPATH/classes/kohana/request.php [ 733 ]
2011-04-03 00:57:23 --- ERROR: Http_Exception_404 [ 404 ]: Unable to find a route to match the URI: icon.jpg ~ SYSPATH/classes/kohana/request.php [ 733 ]
2011-04-03 00:57:23 --- ERROR: Http_Exception_404 [ 404 ]: Unable to find a route to match the URI: icon.jpg ~ SYSPATH/classes/kohana/request.php [ 733 ]
2011-04-03 00:57:24 --- ERROR: Http_Exception_404 [ 404 ]: Unable to find a route to match the URI: youtube-icon.jpg ~ SYSPATH/classes/kohana/request.php [ 733 ]
2011-04-03 00:57:43 --- ERROR: Http_Exception_404 [ 404 ]: Unable to find a route to match the URI: youtube-icon.jpg ~ SYSPATH/classes/kohana/request.php [ 733 ]
2011-04-03 00:57:43 --- ERROR: Http_Exception_404 [ 404 ]: Unable to find a route to match the URI: youtube-icon.jpg ~ SYSPATH/classes/kohana/request.php [ 733 ]
2011-04-03 00:57:54 --- ERROR: Http_Exception_404 [ 404 ]: Unable to find a route to match the URI: youtube-icon.jpg ~ SYSPATH/classes/kohana/request.php [ 733 ]
2011-04-03 00:57:54 --- ERROR: Http_Exception_404 [ 404 ]: Unable to find a route to match the URI: youtube-icon.jpg ~ SYSPATH/classes/kohana/request.php [ 733 ]
2011-04-03 00:58:03 --- ERROR: Http_Exception_404 [ 404 ]: Unable to find a route to match the URI: youtube-icon.jpg ~ SYSPATH/classes/kohana/request.php [ 733 ]
2011-04-03 00:58:04 --- ERROR: Http_Exception_404 [ 404 ]: Unable to find a route to match the URI: youtube-icon.jpg ~ SYSPATH/classes/kohana/request.php [ 733 ]
2011-04-03 02:55:30 --- ERROR: Http_Exception_404 [ 404 ]: Unable to find a route to match the URI: images/loading.gif ~ SYSPATH/classes/kohana/request.php [ 733 ]
2011-04-03 02:55:30 --- ERROR: Http_Exception_404 [ 404 ]: Unable to find a route to match the URI: content/css/style/headerBtnsBG.jpg ~ SYSPATH/classes/kohana/request.php [ 733 ]
2011-04-03 02:55:30 --- ERROR: Http_Exception_404 [ 404 ]: Unable to find a route to match the URI: content/css/style/opaqueDark.png ~ SYSPATH/classes/kohana/request.php [ 733 ]
2011-04-03 02:55:34 --- ERROR: Database_Exception [ 0 ]: [1064] You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'AND (b.type = 'STATUS' OR b.type = 'PHOTO')  AND ((m.privacy_option != 'locked' ' at line 6 ( SELECT b.id, b.mem_id, b.type, b.feed_id, b.text, b.`date`, b.likes as likes,
                         f.title as feed_title,
                         m.username as username, m.firstname as firstname, m.lastname as lastname, m.friend_array as friends, m.privacy_option as privacy_option, m.has_profile_image
                    FROM blabs b
                    LEFT JOIN myMembers m ON b.mem_id = m.id
                    LEFT JOIN feeds f ON f.id = b.feed_id LEFT JOIN friend_relationships fr ON fr.to = b.mem_id WHERE feed_id =  AND (b.type = 'STATUS' OR b.type = 'PHOTO')  AND ((m.privacy_option != 'locked' AND m.privacy_option != 'limited') OR  (b.mem_id = 4792 OR fr.from = 4792))  GROUP BY b.id ORDER BY date DESC LIMIT 15 ) ~ MODPATH/database/classes/kohana/database/mysql.php [ 181 ]
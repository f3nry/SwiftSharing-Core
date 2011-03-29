<?php defined('SYSPATH') or die('No direct script access.'); ?>

2011-03-27 00:00:44 --- ERROR: Http_Exception_404 [ 404 ]: Unable to find a route to match the URI: content/css/js/jquery.js ~ SYSPATH/classes/kohana/request.php [ 733 ]
2011-03-27 00:05:47 --- ERROR: Kohana_View_Exception [ 0 ]: The requested view 404.php could not be found ~ SYSPATH/classes/kohana/view.php [ 268 ]
2011-03-27 00:10:15 --- ERROR: Kohana_View_Exception [ 0 ]: The requested view 404.php could not be found ~ SYSPATH/classes/kohana/view.php [ 268 ]
2011-03-27 00:38:59 --- ERROR: Kohana_View_Exception [ 0 ]: The requested view 404.php could not be found ~ SYSPATH/classes/kohana/view.php [ 268 ]
2011-03-27 00:42:00 --- ERROR: Kohana_View_Exception [ 0 ]: The requested view 404.php could not be found ~ SYSPATH/classes/kohana/view.php [ 268 ]
2011-03-27 00:43:32 --- ERROR: Kohana_View_Exception [ 0 ]: The requested view 404.php could not be found ~ SYSPATH/classes/kohana/view.php [ 268 ]
2011-03-27 01:09:38 --- ERROR: Kohana_View_Exception [ 0 ]: The requested view 404.php could not be found ~ SYSPATH/classes/kohana/view.php [ 268 ]
2011-03-27 01:17:18 --- ERROR: Http_Exception_404 [ 404 ]: Unable to find a route to match the URI: content/css/js/jquery.js ~ SYSPATH/classes/kohana/request.php [ 733 ]
2011-03-27 01:17:22 --- ERROR: Database_Exception [ 0 ]: [1064] You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'AND (type = 'STATUS' OR type = 'PHOTO')  ORDER BY date DESC LIMIT 15' at line 6 ( SELECT b.id, b.mem_id, b.type, b.feed_id, b.text, b.`date`, b.likes as likes,
                         f.title as feed_title,
                         m.username as username, m.firstname as firstname, m.lastname as lastname, m.friend_array as friends, m.privacy_option as privacy_option, m.has_profile_image
                    FROM blabs b
                    LEFT JOIN myMembers m ON b.mem_id = m.id
                    LEFT JOIN feeds f ON f.id = b.feed_id WHERE feed_id =  AND (type = 'STATUS' OR type = 'PHOTO')  ORDER BY date DESC LIMIT 15 ) ~ MODPATH/database/classes/kohana/database/mysql.php [ 181 ]
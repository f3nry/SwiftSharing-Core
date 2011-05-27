<?php defined('SYSPATH') or die('No direct script access.'); ?>

2011-05-07 01:33:47 --- ERROR: Kohana_Cache_Exception [ 0 ]: Memcache PHP extention not loaded ~ MODPATH/cache/classes/kohana/cache/memcache.php [ 120 ]
2011-05-07 01:33:57 --- ERROR: Kohana_Cache_Exception [ 0 ]: Memcache PHP extention not loaded ~ MODPATH/cache/classes/kohana/cache/memcache.php [ 120 ]
2011-05-07 02:02:31 --- ERROR: ErrorException [ 8 ]: Undefined variable: member ~ APPPATH/classes/util/feed/generator.php [ 128 ]
2011-05-07 02:21:14 --- ERROR: Database_Exception [ 0 ]: [1064] You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'WHERE true AND ( b.type = 'STATUS' OR b.type = 'PHOTO' OR false ) AND ((m.privac' at line 6 ( SELECT b.id, b.mem_id, b.type, b.feed_id, b.text, b.`date`, b.likes as likes,
                             f.title as feed_title,
                             m.username as username, m.firstname as firstname, m.lastname as lastname, m.friend_array as friends, m.privacy_option as privacy_option, m.has_profile_image
                        FROM blabs b
                        INNER JOIN myMembers m ON b.mem_id = m.id
                        LEFT JOIN feeds f ON f.id = b.feed_id( WHERE true AND ( b.type = 'STATUS' OR b.type = 'PHOTO' OR false ) AND ((m.privacy_option != 'locked' AND m.privacy_option != 'limited') OR (EXISTS (SELECT 1 FROM friend_relationships fr WHERE fr.to = 4 AND fr.from = b.mem_id) OR b.mem_id = 4)) AND (b.mem_id = 4 OR b.type = 'PROFILE') OR (b.type = 'PROFILE' AND (b.feed_id = 4 OR b.mem_id = 4))) ORDER BY b.date DESC LIMIT 10 ) ~ MODPATH/database/classes/kohana/database/mysql.php [ 181 ]
2011-05-07 02:22:31 --- ERROR: ErrorException [ 8 ]: Trying to get property of non-object ~ APPPATH/views/feed/blab.php [ 24 ]
2011-05-07 02:22:39 --- ERROR: ErrorException [ 8 ]: Trying to get property of non-object ~ APPPATH/views/feed/blab.php [ 24 ]
2011-05-07 02:24:27 --- ERROR: ErrorException [ 8 ]: Trying to get property of non-object ~ APPPATH/views/feed/blab.php [ 24 ]
2011-05-07 02:28:39 --- ERROR: ErrorException [ 8 ]: Trying to get property of non-object ~ APPPATH/views/feed/blab.php [ 24 ]
2011-05-07 02:30:27 --- ERROR: ErrorException [ 8 ]: Trying to get property of non-object ~ APPPATH/views/feed/blab.php [ 24 ]
2011-05-07 02:30:31 --- ERROR: ErrorException [ 8 ]: Trying to get property of non-object ~ APPPATH/views/feed/blab.php [ 24 ]
2011-05-07 02:30:37 --- ERROR: ErrorException [ 8 ]: Trying to get property of non-object ~ APPPATH/views/feed/blab.php [ 24 ]
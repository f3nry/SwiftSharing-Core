<?php defined('SYSPATH') or die('No direct script access.'); ?>

2011-05-26 22:03:45 --- ERROR: Database_Exception [ 0 ]: [1054] Unknown column 'pc.deleted' in 'where clause' ( SELECT pc.id, pc.date_updated, pc.subject,
                       pcm.message,
                       m.id as member_from_id, m.username as member_from_username, m.firstname as member_from_firstname, m.lastname as member_from_lastname, m.has_profile_image as has_profile_image
                  FROM private_conversations pc
                  JOIN (
                       SELECT * FROM private_conversation_messages ORDER BY date_sent DESC
                  ) as pcm ON pcm.conversation_id = pc.id
                  JOIN myMembers m ON m.id = pcm.message_from
                  WHERE pc.to = 4 OR pc.from = 4 AND pc.deleted = 0
                  GROUP BY pc.id
                  ORDER BY pc.date_updated DESC
                  LIMIT 8 ) ~ MODPATH/database/classes/kohana/database/mysql.php [ 181 ]
2011-05-26 22:04:35 --- ERROR: Swift_RfcComplianceException [ 0 ]: Address in mailbox given [SwiftSharing  ~ MODPATH/email/vendor/swift/classes/Swift/Mime/Headers/MailboxHeader.php [ 319 ]
2011-05-26 22:07:50 --- ERROR: Swift_RfcComplianceException [ 0 ]: Address in mailbox given [SwiftSharing ] does not comply with RFC 2822, 3.6.2. ~ MODPATH/email/vendor/swift/classes/Swift/Mime/Headers/MailboxHeader.php [ 319 ]
2011-05-26 22:10:48 --- ERROR: Swift_RfcComplianceException [ 0 ]: Address in mailbox given ["SwiftSharing" ] does not comply with RFC 2822, 3.6.2. ~ MODPATH/email/vendor/swift/classes/Swift/Mime/Headers/MailboxHeader.php [ 319 ]
2011-05-26 22:16:19 --- ERROR: Swift_RfcComplianceException [ 0 ]: Address in mailbox given [SwiftSharing noreply@swiftsharing.net] does not comply with RFC 2822, 3.6.2. ~ MODPATH/email/vendor/swift/classes/Swift/Mime/Headers/MailboxHeader.php [ 319 ]
2011-05-26 22:39:49 --- ERROR: ErrorException [ 1 ]: Class 'Imagick' not found ~ APPPATH/classes/images.php [ 17 ]
2011-05-26 22:40:35 --- ERROR: ErrorException [ 1 ]: Class 'Imagick' not found ~ APPPATH/classes/images.php [ 17 ]
2011-05-26 22:46:31 --- ERROR: ErrorException [ 1 ]: Class 'Imagick' not found ~ APPPATH/classes/images.php [ 17 ]
2011-05-26 23:15:29 --- ERROR: ErrorException [ 1 ]: Class 'Mongo' not found ~ MODPATH/mango/classes/mangodb.php [ 123 ]
2011-05-26 23:15:38 --- ERROR: ErrorException [ 1 ]: Class 'Mongo' not found ~ MODPATH/mango/classes/mangodb.php [ 123 ]
2011-05-26 23:18:17 --- ERROR: Database_Exception [ 0 ]: [1049] Unknown database 'swiftsharing' ~ MODPATH/database/classes/kohana/database/mysql.php [ 96 ]
2011-05-26 23:23:32 --- ERROR: Database_Exception [ 0 ]: [1146] Table 'swiftsharing.feeds' doesn't exist ( SELECT `id`, `title` FROM `feeds` WHERE `mem_id` = '-1' ORDER BY `index` ASC ) ~ MODPATH/database/classes/kohana/database/mysql.php [ 181 ]
CREATE TABLE `friend_relationships` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from` int(11) NOT NULL,
  `to` int(11) NOT NULL,
  `type` enum('FRIEND') NOT NULL,
  `pending` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `from` (`from`),
  KEY `to` (`to`),
  KEY `type` (`type`),
  KEY `from_2` (`from`,`to`),
  KEY `to_2` (`to`,`from`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
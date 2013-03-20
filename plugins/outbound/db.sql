CREATE TABLE IF NOT EXISTS `outbound_queue` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tenant` bigint(20) NOT NULL,
  `number` varchar(15) NOT NULL,
  `type` varchar(4) NOT NULL,
  `time` int(11) NOT NULL,
  `callerId` varchar(15) NOT NULL,
  `data` text,
  PRIMARY KEY (`id`),
  KEY `tenant` (`tenant`,`type`,`time`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

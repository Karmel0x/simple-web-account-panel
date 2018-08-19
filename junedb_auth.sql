CREATE TABLE `a_donatelog_pmw` (
  `a_index` int(11) NOT NULL AUTO_INCREMENT,
  `a_user_code` int(11) DEFAULT NULL,
  `a_date` datetime DEFAULT NULL,
  `a_ip` varchar(15) DEFAULT NULL,
  `a_str` varchar(2550) DEFAULT NULL,
  PRIMARY KEY (`a_index`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `a_donatelog_sr` (
  `a_index` int(11) NOT NULL AUTO_INCREMENT,
  `a_user_code` int(11) DEFAULT NULL,
  `a_date` datetime DEFAULT NULL,
  `a_ip` varchar(15) DEFAULT NULL,
  `a_str` varchar(2550) DEFAULT NULL,
  PRIMARY KEY (`a_index`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `bg_action` (
  `a_index` int(11) NOT NULL AUTO_INCREMENT,
  `user_code` int(11) DEFAULT NULL,
  `a_type` int(4) DEFAULT NULL,
  `a_val` varchar(255) DEFAULT NULL,
  `a_date` datetime DEFAULT NULL,
  `a_ip` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`a_index`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `bg_user` (
  `user_code` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` varchar(30) NOT NULL DEFAULT '0',
  `passwd` varchar(50) NOT NULL DEFAULT '0',
  `chk_tester` char(1) NOT NULL DEFAULT 'N',
  `jumin` varchar(20) DEFAULT '0',
  `chk_service` char(1) DEFAULT 'Y',
  `partner_id` char(2) NOT NULL DEFAULT 'LC',
  `active_passwd` varchar(15) NOT NULL DEFAULT '0',
  `active_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `create_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `update_time` datetime DEFAULT NULL,
  `passwd_plain` varchar(15) NOT NULL DEFAULT '',
  `cash` int(11) DEFAULT '0',
  `a_closed_beta` int(11) NOT NULL DEFAULT '0',
  `block_date` datetime DEFAULT '0000-00-00 00:00:00',
  `email` varchar(100) DEFAULT NULL,
  `ip` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`user_code`),
  UNIQUE KEY `user_id` (`user_id`),
  KEY `passwd` (`passwd`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
SET FOREIGN_KEY_CHECKS=1;

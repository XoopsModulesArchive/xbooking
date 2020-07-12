CREATE TABLE `k_jacana_date` (
  `date_sn` smallint(6) unsigned NOT NULL auto_increment,
  `date_mark` date default NULL,
  PRIMARY KEY  (`date_sn`),
  UNIQUE KEY `date_mark` (`date_mark`)
);

CREATE TABLE `k_jacana_default` (
  `d_period_sn` int(6) unsigned NOT NULL auto_increment,
  `d_period_start` varchar(255) NOT NULL,
  `d_period_end` varchar(255) NOT NULL,
  `d_total_num` smallint(6) unsigned NOT NULL,
  `d_switch` enum('0','1') NOT NULL default '1',
  PRIMARY KEY  (`d_period_sn`)
);

CREATE TABLE `k_jacana_order` (
  `order_sn` int(6) unsigned NOT NULL auto_increment,
  `o_date` datetime default NULL,
  `o_booking_date` date default NULL,
  `o_period` int(6) unsigned NOT NULL,
  `o_booking_num` int(6) unsigned NOT NULL,
  `o_organization` varchar(255) default NULL,
  `o_contact` varchar(255) NOT NULL,
  `o_tel` varchar(255) default NULL,
  `o_fax` varchar(255) default NULL,
  `o_cellphone` varchar(255) default NULL,
  `o_email` varchar(255) default NULL,
  `o_mark` text,
  `o_ok` enum('0','1') NOT NULL default '0',
  PRIMARY KEY  (`order_sn`)
);
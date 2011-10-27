CREATE TABLE  `locations_slug` (
  `location_id` int(10) unsigned NOT NULL,
  `slug` varchar(100) NOT NULL,
  PRIMARY KEY (`location_id`),
  UNIQUE KEY `slug_UNIQUE` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1
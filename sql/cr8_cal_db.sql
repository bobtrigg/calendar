-- phpMyAdmin SQL Dump
-- version 3.4.11.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 18, 2013 at 08:36 AM
-- Server version: 5.5.33
-- PHP Version: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `calendar`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `cat_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(20) NOT NULL,
  PRIMARY KEY (`cat_id`),
  UNIQUE KEY `cat_name` (`cat_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=44 ;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`cat_id`, `cat_name`) VALUES
(31, 'Bike Parking'),
(13, 'Class'),
(14, 'Event'),
(15, 'Meeting'),
(17, 'Party'),
(43, 'Race'),
(12, 'Ride'),
(32, 'Tabling');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
CREATE TABLE IF NOT EXISTS `events` (
  `event_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `cat_id` smallint(6) NOT NULL,
  `event_name` varchar(40) NOT NULL,
  `description` varchar(400) DEFAULT NULL,
  `event_date` date NOT NULL,
  `location` varchar(60) NOT NULL,
  `address` varchar(60) DEFAULT NULL,
  `city` varchar(25) DEFAULT NULL,
  `state` char(2) DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  PRIMARY KEY (`event_id`),
  KEY `event_date` (`event_date`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=48 ;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`event_id`, `cat_id`, `event_name`, `description`, `event_date`, `location`, `address`, `city`, `state`, `start_time`, `end_time`) VALUES
(4, 12, 'Tour de Marin', 'Road ride', '2012-05-20', 'Vallecito School', '50 Nova Albion Way', 'San Rafael', 'CA', '04:30:00', '22:30:00'),
(35, 14, 'Earth Day Marin', '', '2012-05-11', 'Marin Civic Center', '10 Avenue of the Flags', 'San Rafael', 'CA', '11:00:00', '18:00:00'),
(37, 14, 'Bike to Work Day', '', '2012-05-10', 'All over Marin', '', '', '', '06:00:00', '18:00:00'),
(38, 13, 'Bike repair class', '', '2012-05-10', 'The Bicycle Works', '1117 San Anselmo Avenue', 'San Anselmo', 'CA', '18:30:00', '19:30:00'),
(39, 12, 'Off-Road Ride', 'Sunday afternoon ride with Fairfax Cyclery', '2012-04-29', 'Fairfax Cyclery', '2020 Sir Francis Drake Blvd.', 'Fairfax', 'CA', '16:00:00', '22:30:00'),
(40, 12, 'Off-Road Ride', 'Sunday afternoon ride with Fairfax Cyclery', '2012-05-06', 'Fairfax Cyclery', '2020 Sir Francis Drake Blvd.', 'Fairfax', 'CA', '19:30:00', '22:30:00'),
(41, 12, 'Off-Road Ride', 'Sunday afternoon ride with Fairfax Cyclery', '2012-05-13', 'Fairfax Cyclery', '2020 Sir Francis Drake Blvd.', 'Fairfax', 'CA', '16:00:00', '22:30:00'),
(42, 12, 'Off-Road Ride', 'Sunday afternoon ride with Fairfax Cyclery', '2012-05-27', 'Fairfax Cyclery', '2020 Sir Francis Drake Blvd.', 'Fairfax', 'CA', '16:00:00', '22:30:00'),
(43, 12, 'Off-Road Ride', 'Sunday afternoon ride with Fairfax Cyclery', '2012-05-20', 'Fairfax Cyclery', '2020 Sir Francis Drake Blvd.', 'Fairfax', 'CA', '16:00:00', '22:30:00'),
(44, 12, 'Off-Road Ride', 'Sunday afternoon ride with Fairfax Cyclery', '2012-06-03', 'Fairfax Cyclery', '2020 Sir Francis Drake Blvd.', 'Fairfax', 'CA', '16:00:00', '22:30:00'),
(45, 12, 'Trips for Kids 25th Anniversary Gala', '', '2012-05-06', 'Mill Valley Community Center', '180 Camino Alto', 'Mill Valley', 'CA', '17:00:00', '20:00:00'),
(46, 43, 'NorCal race', 'High School Mountain Bike qualifying finals', '2012-05-06', 'Stafford Lake Park', 'Sir Francis Drake Blvd.', 'Novato', 'CA', '16:00:00', '22:30:00'),
(47, 13, 'Basic Bike Maintenance', 'Beginner''s class: tire repair, seat and headset adjustment, basic brakes and cables', '2012-06-01', 'Sports Basement', 'All locations', 'San Francisco', 'CA', '18:30:00', '19:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(40) NOT NULL,
  `email` varchar(60) NOT NULL,
  `passwd` char(40) NOT NULL,
  `access_level` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=35 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `first_name`, `last_name`, `email`, `passwd`, `access_level`) VALUES
(1, 'bob', 'Bob', 'Trigg', 'bobtrigg@bobtrigg.com', '$1$sS3.Fa/.$G8am8fTSkKBRXwrA/f3E./', 1)
;

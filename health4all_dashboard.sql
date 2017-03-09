-- phpMyAdmin SQL Dump
-- version 4.0.10.14
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Nov 17, 2016 at 11:27 AM
-- Server version: 5.5.52-cll
-- PHP Version: 5.6.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `adminh4a_bb_dashboard`
--

-- --------------------------------------------------------

--
-- Table structure for table `hospitals`
--

CREATE TABLE IF NOT EXISTS `hospitals` (
  `hospital_id` int(11) NOT NULL AUTO_INCREMENT,
  `hospital_name` varchar(100) NOT NULL,
  `district` varchar(30) NOT NULL,
  `lattitude` varchar(10) NOT NULL,
  `longitude` varchar(10) NOT NULL,
  `username` varchar(100) NOT NULL,
  `database_name` varchar(100) NOT NULL,
  `database_password` varchar(100) NOT NULL,
  `host_name` varchar(100) NOT NULL,
  `hospital_url` varchar(100) NOT NULL,
  `hospital_type` tinyint(4) NOT NULL COMMENT '0 - Govt, 1 - IRCS, 2 - Pvt.',
  `hospital_subtype` int(30) NOT NULL DEFAULT '6' COMMENT '0-TH,1-DH,2-AH,3-GMH,4-Aut,5-IRCS,6-Oth',
  `new_hospital` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`hospital_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=62 ;

-- --------------------------------------------------------

--
-- Table structure for table `hospitals_lastupdatedtime`
--

CREATE TABLE IF NOT EXISTS `hospitals_lastupdatedtime` (
  `hospital_id` int(11) NOT NULL,
  `lastdonations_status` int(11) NOT NULL,
  `lastupdated_datetime` datetime NOT NULL,
  PRIMARY KEY (`hospital_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `hospital_information`
--

CREATE TABLE IF NOT EXISTS `hospital_information` (
  `hospital_info_id` int(11) NOT NULL AUTO_INCREMENT,
  `hospital_id` int(11) NOT NULL,
  `hospital_name` varchar(150) NOT NULL,
  `hospital_short_name` varchar(150) NOT NULL,
  `latitude_n` varchar(10) NOT NULL,
  `longitude_e` varchar(10) NOT NULL,
  `last_update` datetime NOT NULL,
  `hospital_type` int(11) NOT NULL,
  `hospital_subtype` int(11) NOT NULL,
  `application_url` varchar(150) NOT NULL,
  `address` varchar(250) NOT NULL,
  `city` varchar(15) NOT NULL,
  `district` varchar(15) NOT NULL,
  `state` varchar(30) NOT NULL,
  `pincode` varchar(10) NOT NULL,
  `land_line` varchar(15) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `hospital_email` varchar(30) NOT NULL,
  `website` varchar(150) NOT NULL,
  `medical_officer_name` varchar(60) NOT NULL,
  `medical_officer_phone` varchar(15) NOT NULL,
  `medical_officer_email` varchar(40) NOT NULL,
  PRIMARY KEY (`hospital_info_id`),
  KEY `hospital_id` (`hospital_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=60 ;

-- --------------------------------------------------------

--
-- Table structure for table `hospital_subtypes`
--

CREATE TABLE IF NOT EXISTS `hospital_subtypes` (
  `hospital_subtype` int(30) NOT NULL AUTO_INCREMENT,
  `hospital_subtype_desc` varchar(200) NOT NULL,
  PRIMARY KEY (`hospital_subtype`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Table structure for table `hospital_type`
--

CREATE TABLE IF NOT EXISTS `hospital_type` (
  `hospital_type_id` int(11) NOT NULL,
  `hospital_type` varchar(50) NOT NULL,
  `insert_datetime` datetime NOT NULL,
  `update_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`hospital_type_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `hospitals`
--

CREATE TABLE IF NOT EXISTS `hospitals` (
  `hospital_id` int(11) NOT NULL AUTO_INCREMENT,
  `hospital_name` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `database_name` varchar(100) NOT NULL,
  `database_password` varchar(100) NOT NULL,
  `host_name` varchar(100) NOT NULL,
  `hosptial_url` varchar(100) NOT NULL,
  PRIMARY KEY (`hospital_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `test_areas`
--

CREATE TABLE IF NOT EXISTS `test_areas` (
  `test_area_id` int(11) NOT NULL AUTO_INCREMENT,
  `test_area` varchar(100) NOT NULL,
  `department_id` int(2) NOT NULL,
  PRIMARY KEY (`test_area_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

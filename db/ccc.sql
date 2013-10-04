-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 04, 2013 at 10:13 AM
-- Server version: 5.5.24-log
-- PHP Version: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ccc`
--

-- --------------------------------------------------------

--
-- Table structure for table `callers`
--

CREATE TABLE IF NOT EXISTS `callers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `log_date` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `caller_district` varchar(30) NOT NULL,
  `date_of_call` varchar(20) NOT NULL,
  `start_of_call` time NOT NULL,
  `end_of_call` time NOT NULL,
  `caller_gender` varchar(10) NOT NULL,
  `caller_age` enum('<15','15-25','26-35','36-50','51-64','>65') NOT NULL,
  `language_spoken` varchar(50) NOT NULL,
  `major_issues` varchar(200) NOT NULL,
  `outcome` varchar(200) NOT NULL,
  `caller_feelings` mediumblob NOT NULL,
  `caller_story` mediumblob NOT NULL,
  `counsellors_response` varchar(100) NOT NULL,
  `discussion_1` mediumblob NOT NULL,
  `discussion_2` mediumblob NOT NULL,
  `discussion_3` mediumblob NOT NULL,
  `further_training` varchar(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- Dumping data for table `callers`
--

INSERT INTO `callers` (`id`, `log_date`, `user_id`, `caller_district`, `date_of_call`, `start_of_call`, `end_of_call`, `caller_gender`, `caller_age`, `language_spoken`, `major_issues`, `outcome`, `caller_feelings`, `caller_story`, `counsellors_response`, `discussion_1`, `discussion_2`, `discussion_3`, `further_training`) VALUES
(4, '2013-07-13 22:24:33', 3, 'Badulla', '09-07-2013', '10:24:00', '11:24:00', 'Female', '<15', 'sinhala', '4', '7', 0x617764617764, 0x617766617766776166, 'reflective_skills', 0x77776567666577666577, 0x617764617764617764, 0x6177646164617765, 'yes'),
(5, '2013-07-13 22:24:33', 3, 'Hambantota', '10-07-2013', '11:24:00', '11:28:00', 'Female', '<15', 'english', '4,7', '7', 0x617764617764, 0x617766617766776166, 'reflective_skills', 0x77776567666577666577, 0x617764617764617764, 0x6177646164617765, 'yes'),
(6, '2013-07-13 22:24:33', 3, 'Hambantota', '10-07-2013', '11:24:00', '11:28:00', 'Female', '<15', 'english', '3,4,7', '4,7', 0x617764617764, 0x617766617766776166, 'reflective_skills,active_listening', 0x77776567666577666577, 0x617764617764617764, 0x6177646164617765, 'yes'),
(23, '2013-10-04 15:57:37', 3, 'Ampara', '16-10-2013', '11:27:00', '11:27:00', 'Male', '<15', 'english', '1', '1,2', 0x64736661, 0x6661646661, 'reflective_skills', 0x616466616661, 0x616661736466, 0x6166616466, 'no');

-- --------------------------------------------------------

--
-- Table structure for table `caller_referreral_link`
--

CREATE TABLE IF NOT EXISTS `caller_referreral_link` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `referreral_id` int(11) NOT NULL,
  `caller_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `caller_referreral_link`
--

INSERT INTO `caller_referreral_link` (`id`, `referreral_id`, `caller_id`) VALUES
(1, 1, 23),
(2, 2, 23);

-- --------------------------------------------------------

--
-- Table structure for table `issue_codes`
--

CREATE TABLE IF NOT EXISTS `issue_codes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `issue_name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `issue_codes`
--

INSERT INTO `issue_codes` (`id`, `issue_name`) VALUES
(1, 'Alcoholism '),
(2, 'Child abuse'),
(3, 'Family issues'),
(4, 'Financial worries'),
(5, 'Gambling'),
(6, 'Homosexuality'),
(7, 'Physical illness/Disability'),
(8, 'Information seeking'),
(9, 'Loneliness'),
(10, 'Migration or relocation'),
(11, 'Mental illness - Self'),
(12, 'Mental illness - Carer'),
(13, 'School/Education'),
(14, 'Work issues'),
(15, 'Nuisance/prank/hoax'),
(16, 'Pregnancy'),
(17, 'Role changes'),
(18, 'Role changes'),
(19, 'Relationship issues'),
(20, 'Separation or divorce'),
(21, 'Sexual abuse/assault'),
(22, 'Sexual problems'),
(23, 'Suicide'),
(24, 'Self Harming'),
(25, 'Homicide');

-- --------------------------------------------------------

--
-- Table structure for table `outcome_codes`
--

CREATE TABLE IF NOT EXISTS `outcome_codes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `outcome_name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `outcome_codes`
--

INSERT INTO `outcome_codes` (`id`, `outcome_name`) VALUES
(1, 'Agreed on an action'),
(2, 'Called emergency services'),
(3, 'Conducted suicide risk assessment'),
(4, 'Agreed on safety plan'),
(5, 'Referred Client to other services'),
(6, 'Provided general support'),
(7, 'Positive response'),
(8, 'Negative response'),
(9, 'Client to call back');

-- --------------------------------------------------------

--
-- Table structure for table `referral_category_links`
--

CREATE TABLE IF NOT EXISTS `referral_category_links` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `referrer_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `referreral_categories`
--

CREATE TABLE IF NOT EXISTS `referreral_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `referreral_categories`
--

INSERT INTO `referreral_categories` (`id`, `category_name`) VALUES
(1, 'One to One Counseling Services'),
(2, 'Drugs / Substance Abuse Rehabilitation'),
(3, 'Private Institutes for Psychiatric Problems'),
(4, 'Government Institutes for Psychiatric Problems '),
(5, 'Institutions for Sexual Health'),
(6, 'Financial Counseling and Information'),
(7, 'Legal Aid Providers'),
(8, 'Human Rights'),
(9, 'Rehabilitation for Mentally Challenged Children'),
(10, 'Rehabilitation for the Disabled'),
(11, 'Institutions For Blind, Deaf and Dumb Children'),
(12, 'Care for Handicapped, Orphaned and Deprived Children'),
(13, 'Child Development Centre'),
(14, 'Supporting Services For Women'),
(15, 'Educational Supports'),
(16, 'Assistance for Elderly'),
(17, 'Institutions for Children'),
(18, 'Social Services work with Community');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE IF NOT EXISTS `services` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `service_name` varchar(100) NOT NULL,
  `service_type` int(11) NOT NULL,
  `service_contact` varchar(70) NOT NULL,
  `service_contact_telephone` varchar(20) NOT NULL,
  `services_offered` varchar(1000) NOT NULL,
  `service_address` varchar(300) NOT NULL,
  `service_fax` varchar(20) NOT NULL,
  `service_website` varchar(50) NOT NULL,
  `service_comments` mediumblob NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=37 ;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `service_name`, `service_type`, `service_contact`, `service_contact_telephone`, `services_offered`, `service_address`, `service_fax`, `service_website`, `service_comments`) VALUES
(1, 'AAA', 0, 'Muttiah Muralitharan', '031445322', '', '', '', '', ''),
(3, 'BBB', 3, 'Muttiah Muralitharan', '031445322', '', '', '', '', ''),
(4, 'Burgher Alliance', 2, 'Jeuel Blackett', '0322129332', '', '', '', '', ''),
(5, 'BBB', 3, 'Muttiah Muralitharan', '031445322', '', '', '', '', ''),
(6, 'Burgher Alliance', 2, 'Jeuel Blackett', '0322129332', '', '', '', '', ''),
(7, 'BBB', 3, 'Muttiah Muralitharan', '031445322', '', '', '', '', ''),
(8, 'Burgher Alliance', 2, 'Jeuel Blackett', '0322129332', '', '', '', '', ''),
(9, 'BBB', 3, 'Muttiah Muralitharan', '031445322', '', '', '', '', ''),
(10, 'Burgher Alliance', 2, 'Jeuel Blackett', '0322129332', '', '', '', '', ''),
(11, 'BBB', 3, 'Muttiah Muralitharan', '031445322', '', '', '', '', ''),
(12, 'Burgher Alliance', 2, 'Jeuel Blackett', '0322129332', '', '', '', '', ''),
(13, 'BBB', 3, 'Muttiah Muralitharan', '031445322', '', '', '', '', ''),
(14, 'Burgher Alliance', 2, 'Jeuel Blackett', '0322129332', '', '', '', '', ''),
(15, 'BBB', 3, 'Muttiah Muralitharan', '031445322', '', '', '', '', ''),
(16, 'Burgher Alliance', 2, 'Jeuel Blackett', '0322129332', '', '', '', '', ''),
(17, 'BBB', 3, 'Muttiah Muralitharan', '031445322', '', '', '', '', ''),
(18, 'Burgher Alliance', 2, 'Jeuel Blackett', '0322129332', '', '', '', '', ''),
(19, 'BBB', 3, 'Muttiah Muralitharan', '031445322', '', '', '', '', ''),
(20, 'Burgher Alliance', 2, 'Jeuel Blackett', '0322129332', '', '', '', '', ''),
(21, 'BBB', 3, 'Muttiah Muralitharan', '031445322', '', '', '', '', ''),
(22, 'Burgher Alliance', 2, 'Jeuel Blackett', '0322129332', '', '', '', '', ''),
(23, 'BBB', 3, 'Muttiah Muralitharan', '031445322', '', '', '', '', ''),
(24, 'Burgher Alliance', 2, 'Jeuel Blackett', '0322129332', '', '', '', '', ''),
(25, 'BBB', 3, 'Muttiah Muralitharan', '031445322', '', '', '', '', ''),
(26, 'Burgher Alliance', 2, 'Jeuel Blackett', '0322129332', '', '', '', '', ''),
(27, 'BBB', 3, 'Muttiah Muralitharan', '031445322', '', '', '', '', ''),
(28, 'Burgher Alliance', 2, 'Jeuel Blackett', '0322129332', '', '', '', '', ''),
(29, 'BBB', 3, 'Muttiah Muralitharan', '031445322', '', '', '', '', ''),
(30, 'Burgher Alliance', 2, 'Jeuel Blackett', '0322129332', '', '', '', '', ''),
(31, 'BBB', 3, 'Muttiah Muralitharan', '031445322', '', '', '', '', ''),
(32, 'Burgher Alliance', 2, 'Jeuel Blackett', '0322129332', '', '', '', '', ''),
(33, 'BBB', 3, 'Muttiah Muralitharan', '031445322', '', '', '', '', ''),
(34, 'Burgher Alliance', 2, 'Jeuel Blackett', '0322129332', '', '', '', '', ''),
(35, 'awd', 0, '235adawd', '235325', '', '0', '', '', ''),
(36, 'awd', 0, 'awdawd', 'awd', '', '0', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `service_referreral_links`
--

CREATE TABLE IF NOT EXISTS `service_referreral_links` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `referrer_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=53 ;

--
-- Dumping data for table `service_referreral_links`
--

INSERT INTO `service_referreral_links` (`id`, `referrer_id`, `service_id`) VALUES
(52, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `username` varchar(15) NOT NULL,
  `password` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(3, 'gkodikara', '1db6407fd193b39f9d3296c4186ee654');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 25, 2017 at 10:27 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `questionaries`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_qus_master`
--

CREATE TABLE IF NOT EXISTS `tbl_qus_master` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question` text NOT NULL,
  `answer` text NOT NULL,
  `parent_qus_id` int(11) NOT NULL COMMENT 'If question is sub question need to store parent question id',
  `question_type` int(5) NOT NULL,
  `created_at` timestamp NOT NULL,
  `modified_at` timestamp NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `question` (`question`),
  FULLTEXT KEY `answer` (`answer`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_qus_type_master`
--

CREATE TABLE IF NOT EXISTS `tbl_qus_type_master` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `type` varchar(55) NOT NULL,
  `type_value` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `tbl_qus_type_master`
--

INSERT INTO `tbl_qus_type_master` (`id`, `type`, `type_value`) VALUES
(1, 'single_choice', 'Single Choice'),
(2, 'multiple_choice', 'Multi Choice'),
(3, 'multi_line_text', 'Multi-line Choice');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

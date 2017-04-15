-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 15, 2017 at 11:58 AM
-- Server version: 5.6.20
-- PHP Version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `project`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `username` varchar(60) NOT NULL,
  `p_word` text,
  `admin_level` int(11) DEFAULT NULL,
  `name` text,
  `email` varchar(254) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `image` varchar(254) DEFAULT NULL,
  `area_of_study` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`username`, `p_word`, `admin_level`, `name`, `email`, `dob`, `image`, `area_of_study`) VALUES
('A0001', 'test', 2, 'Mr. Darren Armstrong', 'test@gmail.com', '1990-06-27', 'A0001.png', 1);

-- --------------------------------------------------------

--
-- Table structure for table `areaofstudy`
--

CREATE TABLE IF NOT EXISTS `areaofstudy` (
`id` int(11) NOT NULL,
  `area` text
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `areaofstudy`
--

INSERT INTO `areaofstudy` (`id`, `area`) VALUES
(1, 'Computing'),
(2, 'Mathematics'),
(3, 'History'),
(4, 'English'),
(5, 'Biology'),
(6, 'Chemistry'),
(7, 'Physics'),
(8, 'Art & Design'),
(9, 'Design & Technology');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE IF NOT EXISTS `student` (
  `username` varchar(60) NOT NULL,
  `p_word` text,
  `fname` text,
  `sname` text,
  `email` varchar(254) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `image` varchar(254) DEFAULT NULL,
  `securityOne` text,
  `securityTwo` text,
  `dateJoined` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`username`, `p_word`, `fname`, `sname`, `email`, `dob`, `image`, `securityOne`, `securityTwo`, `dateJoined`) VALUES
('NULL', '012345678909876543210ThisIsADefualtUsername012345678909876543210ShouldNotBeloggedInByAUserSecurityPurposesONLY2014', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2014-11-12 17:00:52');

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE IF NOT EXISTS `subject` (
`id` int(11) NOT NULL,
  `name` text,
  `Area_of_study` int(11) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`id`, `name`, `Area_of_study`) VALUES
(1, 'Android Development', 1),
(2, 'HTML5', 1),
(3, 'CSS3', 1),
(4, 'PHP Programming Language', 1),
(5, 'Java Programming Language', 1),
(6, 'XML', 1),
(7, 'C#', 1),
(8, 'algebra', 2),
(9, 'division', 2),
(10, 'test', 1),
(11, 'literature', 4);

-- --------------------------------------------------------

--
-- Table structure for table `tutorial`
--

CREATE TABLE IF NOT EXISTS `tutorial` (
`Tutorial_id` int(11) NOT NULL,
  `Subject` int(11) DEFAULT NULL,
  `Url` varchar(2083) DEFAULT NULL,
  `Title` varchar(100) DEFAULT NULL,
  `AdminCreator` varchar(60) DEFAULT NULL,
  `StudentCreator` varchar(60) DEFAULT NULL,
  `Description` longtext,
  `Date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Likes` bigint(20) DEFAULT NULL,
  `TutViews` bigint(20) DEFAULT NULL,
  `VerifyStatus` int(1) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=37 ;

--
-- Dumping data for table `tutorial`
--

INSERT INTO `tutorial` (`Tutorial_id`, `Subject`, `Url`, `Title`, `AdminCreator`, `StudentCreator`, `Description`, `Date_created`, `Likes`, `TutViews`, `VerifyStatus`) VALUES
(2, 2, '<iframe width="420" height="315" src="//www.youtube.com/embed/dXRi9UXuPFk" frameborder="0" allowfullscreen></iframe>', 'Introduction to HTML5', 'A0001', NULL, 'This is a short tutorial on what is HTML5 and what are the key apsects of the language.', '2014-10-08 17:37:44', 11, 119, 1),
(12, 1, '<iframe width="560" height="315" src="//www.youtube.com/embed/CbuoFxjAlgo" frameborder="0" allowfullscreen></iframe>', 'Develop Android Apps with IntelliJ IDEA', 'A0001', NULL, 'This is a tutorial created by JetBrainsTV.  The Tutorial is 38 minute long and guides the user on creating an Android chat application using IntelliJ IDEA Ultimate 12.', '2014-12-08 17:34:17', 5, 14, 1),
(14, 1, '<iframe width="560" height="315" src="//www.youtube.com/embed/SUOWNXGRc6g" frameborder="0" allowfullscreen></iframe>', 'Android Tutorial 1 - Download and Install the Java JDK', 'A0001', NULL, 'Android Application Development Tutorial - 1 - Download and Install the Java JDK: This is a tutorial created by the new boston, it will guide the users through downloading and installing the Java JDK.', '2014-12-17 12:27:52', 1, 4, 1),
(15, 1, '<iframe width="560" height="315" src="//www.youtube.com/embed/857zrsYZKGo" frameborder="0" allowfullscreen></iframe>', 'Android Tutorial 2 - Installing Eclipse and Setting up ADT', 'A0001', NULL, 'Android Application Development Tutorial - 2 - Installing Eclipse and Setting up the ADT: This is a tutorial created by the new boston, it will guide the users through installing eclipse and setting up the ADT', '2014-12-17 12:40:17', NULL, NULL, 1),
(16, 1, '<iframe width="560" height="315" src="//www.youtube.com/embed/Da1jlmwuW_w" frameborder="0" allowfullscreen></iframe>', 'Android Tutorial 3 - Install Android SDK and Set up Emulator', 'A0001', NULL, 'Android Application Development Tutorial - 3 - Installing Android SDK and Set up Emulator created by thenewboston.  This tutorial will guide the user on how to install the android SDK and how to set up the emulator.  The emulator will enable the user to test their apps.', '2014-12-17 12:49:59', NULL, NULL, 1),
(17, 1, '<iframe width="560" height="315" src="//www.youtube.com/embed/MIKl8PX838E" frameborder="0" allowfullscreen></iframe>', 'Android Tutorial 4 - Setting up an Android Project', 'A0001', NULL, 'Android Application Development Tutorial - 4 - Setting up an Android Project, created by thenewboston.  This tutorial will gude the user on how to set up an android project using eclipse.', '2014-12-17 12:53:45', NULL, NULL, 1),
(18, 1, '<iframe width="560" height="315" src="//www.youtube.com/embed/sPFUTJgvVpQ" frameborder="0" allowfullscreen></iframe>', 'Android Tutorial 5 - Overview of Project and Adding Folders', 'A0001', NULL, 'Android Application Development Tutorial - 5 - Overview of Project and Adding Folders, created by thenewboston.  This tutorial will guide the user with an overview of an android project and how to add folders to a project.', '2014-12-17 13:03:39', NULL, NULL, 1),
(19, 1, '<iframe width="560" height="315" src="//www.youtube.com/embed/maYFI5O6P-8" frameborder="0" allowfullscreen></iframe>', 'Android Tutorial 6 - Introduction to Layouts in XML', 'A0001', NULL, 'Android Application Development Tutorial - 6 - Introduction to Layouts in XML, created by thenewboston.  This tutorial will explain and show the user on how to use layouts in XML effectively for an android project.', '2014-12-17 13:05:59', NULL, NULL, 1),
(20, 1, '<iframe width="560" height="315" src="//www.youtube.com/embed/6moe-rLZKCk" frameborder="0" allowfullscreen></iframe>', 'Android Tutorial 7 - Creating A Button in XML and Adding an ID', 'A0001', NULL, 'Android Application Development Tutorial - 7 - Creating A Button in XML and Adding an ID, created by thenewboston.  This tutorial will teach the user how to create a button and how to assign an ID to a created.  It also explains the purpose of assigning an ID to a button.', '2014-12-17 13:09:29', NULL, NULL, 1),
(21, 1, '<iframe width="560" height="315" src="//www.youtube.com/embed/eKXnQ83RU3I" frameborder="0" allowfullscreen></iframe>', 'Android Tutorial 8 - Setting up Variables and Referencing XML ids', 'A0001', NULL, 'Android Application Development Tutorial - 8 - Setting up Variables and Referencing XML ids, created by thenewboston.  This tutorial will teach the user on how to set up variables and how to reference IDs for the user to use on their app. ', '2014-12-17 13:12:28', NULL, NULL, 1),
(22, 1, '<iframe width="560" height="315" src="//www.youtube.com/embed/WjE-pWYElsE" frameborder="0" allowfullscreen></iframe>', 'Android Tutorial 9 - Set up a Button with OnClickListener', 'A0001', NULL, 'Android Application Development Tutorial - 9 - Set up a Button with OnClickListener, created by thenewboston.  This tutorial will teach the user how to set up a button with an onclick listener for their application project.', '2014-12-17 14:35:25', NULL, NULL, 1),
(23, 1, '<iframe width="560" height="315" src="//www.youtube.com/embed/SUOWNXGRc6g?list=PL2F07DBCDCC01493A" frameborder="0" allowfullscreen></iframe>', 'Android Tutorial 1 - 200 Complete Set', 'A0001', NULL, 'Android Application Development Tutorial - 1 - 200,created by thenewboston.  This is the complete set of tutorials for Android Application Development.', '2014-12-17 14:49:41', NULL, NULL, 1),
(24, 1, '<iframe width="560" height="315" src="//www.youtube.com/embed/hUA_isgpTHI" frameborder="0" allowfullscreen></iframe>', 'Android Tutorial 10 - Using setText method for our button', 'A0001', NULL, 'Android Application Development Tutorial - 10 - Using setText method for our button, created by thenewboston.  This tutorial will teach the user how to use the setText method on a button for their android applications', '2014-12-17 15:07:49', NULL, NULL, 1),
(25, 1, '<iframe width="560" height="315" src="//www.youtube.com/embed/IHg_0HJ5iQo" frameborder="0" allowfullscreen></iframe>', 'Android Tutorial 11 - Adding Resources and Setting Background', 'A0001', NULL, 'Android Application Development Tutorial - 11 - Adding Resources and Setting Background, created by thenewboston. The tutorial will teach the user how to add resources to their application project and how to set the background for their app.', '2014-12-17 15:28:35', NULL, NULL, 1),
(26, 1, '<iframe width="560" height="315" src="//www.youtube.com/embed/H92G3CpSQf4" frameborder="0" allowfullscreen></iframe>', 'Android Tutorial 12 - Setting up an Activity and Using SetContentView', 'A0001', NULL, 'Android Application Development Tutorial - 12 - Setting up an Activity and Using SetContentView, created by thenewboston.  This tutorial will teach the user on how to set up an Activity for their project and on how to use the SetContentView.', '2014-12-17 15:36:11', NULL, NULL, 1),
(27, 1, '<iframe width="560" height="315" src="//www.youtube.com/embed/B5uJeno3xg8" frameborder="0" allowfullscreen></iframe>', 'Android Tutorial 13 - Introduction to the Android Manifest', 'A0001', NULL, 'Android Application Development Tutorial - 13 - Introduction to the Android Manifest, created by thenewboston.  This tutorial will give the user an insight and explanation of the importance of the Android Manifest for an application project', '2014-12-17 15:48:41', NULL, NULL, 1),
(28, 1, '<iframe width="560" height="315" src="//www.youtube.com/embed/hy0mRoT1ZlM" frameborder="0" allowfullscreen></iframe>', 'Android Tutorial 14 - The Framework of a Thread', 'A0001', NULL, 'Android Application Development Tutorial - 14 - The Framework of a Thread, created by thenewboston.  This tutorial dicusses the framework of a thread and why it is useful when creating an android project.', '2014-12-17 16:46:36', NULL, NULL, 1),
(29, 1, '<iframe width="560" height="315" src="//www.youtube.com/embed/Xpkbu2GrJpE" frameborder="0" allowfullscreen></iframe>', 'Android Tutorial 15 - How to Start a New Activity via Intent', 'A0001', NULL, 'Android Application Development Tutorial - 15 - How to Start a New Activity via Intent, created by thenewboston.  This tutorial shows the user how to start a new activity by using the intent tool made available.  ', '2014-12-17 16:48:47', NULL, NULL, 1),
(30, 1, '<iframe width="560" height="315" src="//www.youtube.com/embed/-G91Hp3t6sg" frameborder="0" allowfullscreen></iframe>', 'Android Tutorial 16 - Activity Life Cycle ', 'A0001', NULL, 'Android Application Development Tutorial - 16 - Activity Life Cycle, created by thenewboston.  This tutorial discusses the Activity Life Cycle of a application.', '2014-12-17 16:50:49', NULL, NULL, 1),
(31, 1, '<iframe width="560" height="315" src="//www.youtube.com/embed/-zGS_zrL0rY" frameborder="0" allowfullscreen></iframe>', 'Android Tutorial 17 - Adding Music with MediaPlayer ', 'A0001', NULL, 'Android Application Development Tutorial - 17 - Adding Music with MediaPlayer, created by thenewboston.  THis tutorial teaches the user how to add music using the MediaPlayer tool.', '2014-12-17 16:56:14', NULL, NULL, 1),
(32, 1, '<iframe width="560" height="315" src="//www.youtube.com/embed/4LHIESO0NGk" frameborder="0" allowfullscreen></iframe>', 'Android Tutorial 18 - Create a List Menu from the ListActivity class', 'A0001', NULL, 'Android Application Development Tutorial - 18 - Create a List Menu from the ListActivity class, created by thenewboston.  The tutorial teaches the viewer on how to create a list menu for their app from using the ListActivity class.', '2014-12-17 16:58:22', NULL, NULL, 1),
(33, 1, '<iframe width="560" height="315" src="//www.youtube.com/embed/8kybpxIixRk" frameborder="0" allowfullscreen></iframe>', 'Android Tutorial 19 - Setting up an ArrayAdapter', 'A0001', NULL, 'Android Application Development Tutorial - 19 -Setting up an ArrayAdapter, created by thenewboston. This tutorial teaches the viewer on how to set up an ArrayAdapter for their Android Application.', '2014-12-17 17:00:51', NULL, NULL, 1),
(34, 1, '<iframe width="560" height="315" src="//www.youtube.com/embed/eHh2Yib7u-A?list=PL2F07DBCDCC01493A" frameborder="0" allowfullscreen></iframe>', 'Android Tutorial 20 - Starting an Activity with a Class Object', 'A0001', NULL, 'Android Application Development Tutorial - 20 - Starting an Activity with a Class Object, created by thenewboston. This tutorial teaches the viewer on how to start an Activity with a Class Object for an Android Application Project.', '2014-12-17 17:02:56', 1, 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `viewed`
--

CREATE TABLE IF NOT EXISTS `viewed` (
  `Tutorial_id` int(11) NOT NULL,
  `username` varchar(60) NOT NULL,
  `dateViewed` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
 ADD PRIMARY KEY (`username`), ADD KEY `c8` (`area_of_study`);

--
-- Indexes for table `areaofstudy`
--
ALTER TABLE `areaofstudy`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
 ADD PRIMARY KEY (`username`);

--
-- Indexes for table `subject`
--
ALTER TABLE `subject`
 ADD PRIMARY KEY (`id`), ADD KEY `c5` (`Area_of_study`);

--
-- Indexes for table `tutorial`
--
ALTER TABLE `tutorial`
 ADD PRIMARY KEY (`Tutorial_id`), ADD KEY `c2` (`Subject`), ADD KEY `c3` (`AdminCreator`), ADD KEY `c13` (`StudentCreator`);

--
-- Indexes for table `viewed`
--
ALTER TABLE `viewed`
 ADD PRIMARY KEY (`Tutorial_id`,`username`,`dateViewed`), ADD KEY `c12` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `areaofstudy`
--
ALTER TABLE `areaofstudy`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `subject`
--
ALTER TABLE `subject`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `tutorial`
--
ALTER TABLE `tutorial`
MODIFY `Tutorial_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=37;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin`
--
ALTER TABLE `admin`
ADD CONSTRAINT `c8` FOREIGN KEY (`area_of_study`) REFERENCES `areaofstudy` (`id`);

--
-- Constraints for table `subject`
--
ALTER TABLE `subject`
ADD CONSTRAINT `c5` FOREIGN KEY (`Area_of_study`) REFERENCES `areaofstudy` (`id`);

--
-- Constraints for table `tutorial`
--
ALTER TABLE `tutorial`
ADD CONSTRAINT `c13` FOREIGN KEY (`StudentCreator`) REFERENCES `student` (`username`),
ADD CONSTRAINT `c2` FOREIGN KEY (`Subject`) REFERENCES `subject` (`id`),
ADD CONSTRAINT `c3` FOREIGN KEY (`AdminCreator`) REFERENCES `admin` (`username`);

--
-- Constraints for table `viewed`
--
ALTER TABLE `viewed`
ADD CONSTRAINT `c11` FOREIGN KEY (`Tutorial_id`) REFERENCES `tutorial` (`Tutorial_id`),
ADD CONSTRAINT `c12` FOREIGN KEY (`username`) REFERENCES `student` (`username`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

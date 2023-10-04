-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 04, 2023 at 09:22 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `myresume`
--

-- --------------------------------------------------------

--
-- Table structure for table `education`
--

CREATE TABLE `education` (
  `eduid` int(11) NOT NULL,
  `fromyear` varchar(20) NOT NULL,
  `toyear` varchar(20) NOT NULL,
  `college` varchar(30) NOT NULL,
  `course` varchar(30) NOT NULL,
  `description` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `education`
--

INSERT INTO `education` (`eduid`, `fromyear`, `toyear`, `college`, `course`, `description`) VALUES
(1, '2002', '2005', 'Everest Innovative College', 'WEB DESIGN', 'Web Designing course '),
(2, '2007', '2009', 'TU', 'GRAPHIC DESIGN', 'Graphic Design course');

-- --------------------------------------------------------

--
-- Table structure for table `employment`
--

CREATE TABLE `employment` (
  `empid` int(11) NOT NULL,
  `fromyear` varchar(20) NOT NULL,
  `toyear` varchar(20) NOT NULL,
  `company` varchar(30) NOT NULL,
  `designation` varchar(30) NOT NULL,
  `description` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employment`
--

INSERT INTO `employment` (`empid`, `fromyear`, `toyear`, `company`, `designation`, `description`) VALUES
(1, '2005', '2007', 'Ebee Company ', 'WEB DESIGNER', 'I worked as a web designer.'),
(2, '2009', '2012', 'Astute Company', 'SENIOR DESIGNER', 'Worked as a senior graphic designer handling all the members.'),
(3, '2012', 'present', 'Moru Company', 'ART DIRECTOR', 'Worked as a art director and designed arts.');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `jid` int(20) NOT NULL,
  `jtitle` varchar(100) NOT NULL,
  `jdes` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`jid`, `jtitle`, `jdes`) VALUES
(1, 'Graphic Designer', 'Designed Prospectus, Banner and Logo.'),
(2, 'gsagggs', 'gsagggs'),
(3, 'asas', 'asas'),
(4, 'as', 'as');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `pid` int(11) NOT NULL,
  `page` varchar(20) NOT NULL,
  `data` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`pid`, `page`, `data`) VALUES
(1, 'home', '<p>I am enthusisastic and love working with new people.</p>');

-- --------------------------------------------------------

--
-- Table structure for table `personal`
--

CREATE TABLE `personal` (
  `uid` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `fname` varchar(30) NOT NULL,
  `lname` varchar(30) NOT NULL,
  `designation` varchar(30) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `email` varchar(20) NOT NULL,
  `website` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `personal`
--

INSERT INTO `personal` (`uid`, `image`, `fname`, `lname`, `designation`, `phone`, `email`, `website`) VALUES
(1, 'images/6437.jpg', 'Apeksha ', 'Kafle', 'Graphic & Web Designer', '9861314175', 'appukafle@gmail.com', 'http://www.appu.com'),
(2, 'images/4918050.jpg', 'Sabin', 'ssasjjha', 'Sajsksa', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `pid` int(11) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `title` varchar(30) NOT NULL,
  `subtitle` varchar(30) NOT NULL,
  `filter` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`pid`, `photo`, `title`, `subtitle`, `filter`) VALUES
(1, 'images/portfolio1.jpg', 'Photo Manipulation', 'Worked on adobe ', 'web'),
(2, 'images/portfolio4.jpg', 'Photo Edit', 'Photo editor using Editor', 'graphic'),
(3, 'images/portfolio6.jpg', 'Branding', 'For icecream brand', 'photo'),
(4, 'images/portfolio10.jpg', 'Photo Edit', 'Using Lightroom', 'photo');

-- --------------------------------------------------------

--
-- Table structure for table `resume`
--

CREATE TABLE `resume` (
  `rid` int(20) NOT NULL,
  `filename` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobile` int(20) NOT NULL,
  `place` varchar(100) NOT NULL,
  `DOB` date NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `resume`
--

INSERT INTO `resume` (`rid`, `filename`, `name`, `email`, `mobile`, `place`, `DOB`, `date`) VALUES
(1, 'Apekshacv.pdf', 'Apeksha Kafle', 'appukafle@gmail.com', 217368213, 'Tinthana, Kathmandu', '2001-12-20', '2023-08-01');

-- --------------------------------------------------------

--
-- Table structure for table `skills`
--

CREATE TABLE `skills` (
  `skillid` int(11) NOT NULL,
  `skilltype` varchar(20) NOT NULL,
  `skill` varchar(50) NOT NULL,
  `skillvalue` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `skills`
--

INSERT INTO `skills` (`skillid`, `skilltype`, `skill`, `skillvalue`) VALUES
(1, 'progskill', 'Wordpress', 90),
(2, 'progskill', 'PHP', 80),
(3, 'progskill', 'HTML', 99),
(4, 'progskill', 'CSS', 90),
(5, 'progskill', 'MySQL', 70),
(6, 'progskill', 'JavaScript', 99),
(7, 'graphskill', 'AdobePhotoshop', 99),
(8, 'graphskill', 'AdobeIllustrator', 80),
(9, 'graphskill', 'AdobeIndesign', 70),
(10, 'graphskill', 'CorelDraw', 60),
(11, 'graphskill', '3DMax', 50);

-- --------------------------------------------------------

--
-- Table structure for table `social`
--

CREATE TABLE `social` (
  `uid` int(11) NOT NULL,
  `facebook` varchar(255) NOT NULL,
  `twitter` varchar(255) NOT NULL,
  `googleplus` varchar(255) NOT NULL,
  `instagram` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `social`
--

INSERT INTO `social` (`uid`, `facebook`, `twitter`, `googleplus`, `instagram`) VALUES
(1, '#fb', '#tw', '#gp', '#inst');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `uid` int(11) NOT NULL,
  `uname` varchar(50) NOT NULL,
  `lname` varchar(200) NOT NULL,
  `upass` varchar(255) NOT NULL,
  `email` varchar(200) NOT NULL,
  `user_type` int(10) NOT NULL DEFAULT 0,
  `photo` varchar(20) NOT NULL,
  `status` int(1) NOT NULL,
  `activate_code` varchar(20) NOT NULL,
  `created_on` date NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`uid`, `uname`, `lname`, `upass`, `email`, `user_type`, `photo`, `status`, `activate_code`, `created_on`) VALUES
(1, 'admin', '', '$2y$10$JEMq0AXzJh4rEYMO7TpuouTAKWwTtxoBC8CJxmotlJkF6krHtoGve', 'admin@gmail.com', 0, '', 0, '', '2023-08-08'),
(2, 'sabin', '', '4f8de24d6093ac5d25c7cfafc474d49f', 'appukafle@gmail.com', 0, '', 0, '', '2023-08-08'),
(3, 'Sami', '', '4f8de24d6093ac5d25c7cfafc474d49f', 'sami33@gmail.com', 1, '', 0, '', '2023-08-08'),
(4, 'Prabha', '', 'a803b68599c7e5fecd909fd9dbff44b1', 'prabha@gmail.com', 0, '', 0, '', '2023-08-13'),
(5, 'Hari', '', 'a9bcf1e4d7b95a22e2975c812d938889', 'hari@gmail.com', 0, '', 0, '', '2023-09-30');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `education`
--
ALTER TABLE `education`
  ADD PRIMARY KEY (`eduid`);

--
-- Indexes for table `employment`
--
ALTER TABLE `employment`
  ADD PRIMARY KEY (`empid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`jid`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`pid`);

--
-- Indexes for table `personal`
--
ALTER TABLE `personal`
  ADD PRIMARY KEY (`uid`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`pid`);

--
-- Indexes for table `skills`
--
ALTER TABLE `skills`
  ADD PRIMARY KEY (`skillid`);

--
-- Indexes for table `social`
--
ALTER TABLE `social`
  ADD PRIMARY KEY (`uid`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`uid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `education`
--
ALTER TABLE `education`
  MODIFY `eduid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `employment`
--
ALTER TABLE `employment`
  MODIFY `empid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `jid` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `skills`
--
ALTER TABLE `skills`
  MODIFY `skillid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 22, 2017 at 08:46 AM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 7.1.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sportsbook`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_address`
--

CREATE TABLE `activity_address` (
  `userEmail` varchar(60) NOT NULL,
  `address1` varchar(25) NOT NULL,
  `address2` varchar(25) DEFAULT NULL,
  `city` varchar(20) NOT NULL,
  `state` varchar(20) NOT NULL,
  `country` varchar(20) NOT NULL,
  `zipcode` int(10) NOT NULL,
  `landmark` varchar(20) NOT NULL,
  `latitude` double NOT NULL,
  `longitude` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `event_address`
--

CREATE TABLE `event_address` (
  `userEmail` varchar(60) NOT NULL,
  `address1` varchar(25) NOT NULL,
  `address2` varchar(25) DEFAULT NULL,
  `city` varchar(20) NOT NULL,
  `state` varchar(20) NOT NULL,
  `country` varchar(20) NOT NULL,
  `zipcode` int(10) NOT NULL,
  `landmark` varchar(20) NOT NULL,
  `latitude` double NOT NULL,
  `longitude` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userName` varchar(30) NOT NULL,
  `userLastName` varchar(30) DEFAULT NULL,
  `userEmail` varchar(60) NOT NULL,
  `userPass` varchar(255) NOT NULL,
  `userGender` varchar(1) NOT NULL,
  `userDoB` date NOT NULL,
  `userBio` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userName`, `userLastName`, `userEmail`, `userPass`, `userGender`, `userDoB`, `userBio`) VALUES
('Sumit', 'Jawale', 'jawalesumit@gmail.com', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 'M', '2017-11-15', 'Hi all!'),
('Sumit', 'Jawale', 'sachin2@gmail.com', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', 'M', '2017-11-08', ''),
('Sumit', 'Jawale', 'sachin@gmail.com', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 'M', '2017-11-08', ''),
('Sumit', 'Jawale', 'sam1@gmail.com', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 'M', '2017-11-08', ''),
('Sumit', 'Jawale', 'sam@gmail.com', 'e3e9fc033c2647b79bac54f75d0965c0715c6856e662fd02da8742100e5cda22', 'M', '2017-11-07', ''),
('Sumit', 'Jawale', 'sumitpurushottam.jawale@my.csun.edu', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 'M', '2017-11-02', '');

-- --------------------------------------------------------

--
-- Table structure for table `user_activity`
--

CREATE TABLE `user_activity` (
  `userEmail` varchar(60) NOT NULL,
  `activityDesc` text NOT NULL,
  `activitySport` varchar(30) NOT NULL,
  `activityDate` date NOT NULL,
  `activityInTime` time NOT NULL,
  `activityOutTime` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user_address`
--

CREATE TABLE `user_address` (
  `userEmail` varchar(60) NOT NULL,
  `address1` varchar(25) NOT NULL,
  `address2` varchar(25) DEFAULT NULL,
  `city` varchar(20) NOT NULL,
  `state` varchar(20) NOT NULL,
  `country` varchar(20) NOT NULL,
  `zipcode` int(10) NOT NULL,
  `latitude` double NOT NULL,
  `longitude` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_address`
--

INSERT INTO `user_address` (`userEmail`, `address1`, `address2`, `city`, `state`, `country`, `zipcode`, `latitude`, `longitude`) VALUES
('jawalesumit@gmail.com', '18452 HALSTED STREET', 'UNIT 108', 'NORTHRIDGE', 'California', '', 91325, 34.2443551, -118.5355161),
('sachin2@gmail.com', '18452 HALSTED STREET', 'UNIT 108', 'NORTHRIDGE', 'California', '', 91325, 34.2443551, -118.5355161),
('sumitpurushottam.jawale@my.csun.edu', '18452 HALSTED STREET', 'UNIT 108', 'NORTHRIDGE', 'California', '', 91325, 34.2443551, -118.5355161),
('sam@gmail.com', '18452 HALSTED STREET', 'UNIT 108', 'NORTHRIDGE', 'California', '', 91325, 34.2443551, -118.5355161),
('sachin@gmail.com', '18452 HALSTED STREET', 'UNIT 108', 'NORTHRIDGE', 'California', '', 91325, 34.2443551, -118.5355161),
('sam1@gmail.com', '18452 HALSTED STREET', 'UNIT 108', 'NORTHRIDGE', 'California', '', 91325, 34.2443551, -118.5355161);

-- --------------------------------------------------------

--
-- Table structure for table `user_event`
--

CREATE TABLE `user_event` (
  `userEmail` varchar(60) NOT NULL,
  `eventTitle` varchar(30) NOT NULL,
  `eventDesc` text,
  `eventSport` varchar(30) NOT NULL,
  `eventOccupancy` int(11) NOT NULL,
  `eventDate` date NOT NULL,
  `eventInTime` date NOT NULL,
  `eventOutTime` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user_sports`
--

CREATE TABLE `user_sports` (
  `userEmail` varchar(60) NOT NULL,
  `sports_activity` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_sports`
--

INSERT INTO `user_sports` (`userEmail`, `sports_activity`) VALUES
('jawalesumit@gmail.com', 'football'),
('jawalesumit@gmail.com', 'tennis'),
('sachin2@gmail.com', 'football'),
('sachin2@gmail.com', 'tennis'),
('sumitpurushottam.jawale@my.csun.edu', 'football'),
('sumitpurushottam.jawale@my.csun.edu', 'tennis'),
('sam@gmail.com', 'football'),
('sachin@gmail.com', 'football'),
('sam1@gmail.com', 'football');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_address`
--
ALTER TABLE `activity_address`
  ADD KEY `Key_userEmail` (`userEmail`);

--
-- Indexes for table `event_address`
--
ALTER TABLE `event_address`
  ADD KEY `Key_userEmail` (`userEmail`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userEmail`);

--
-- Indexes for table `user_activity`
--
ALTER TABLE `user_activity`
  ADD KEY `Key_userEmail` (`userEmail`);

--
-- Indexes for table `user_address`
--
ALTER TABLE `user_address`
  ADD KEY `Key_userEmail` (`userEmail`);

--
-- Indexes for table `user_event`
--
ALTER TABLE `user_event`
  ADD KEY `Key_userEmail` (`userEmail`);

--
-- Indexes for table `user_sports`
--
ALTER TABLE `user_sports`
  ADD KEY `Key_userEmail` (`userEmail`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_address`
--
ALTER TABLE `activity_address`
  ADD CONSTRAINT `FK_userEmail2` FOREIGN KEY (`userEmail`) REFERENCES `users` (`userEmail`);

--
-- Constraints for table `event_address`
--
ALTER TABLE `event_address`
  ADD CONSTRAINT `FK_userEmail3` FOREIGN KEY (`userEmail`) REFERENCES `users` (`userEmail`);

--
-- Constraints for table `user_activity`
--
ALTER TABLE `user_activity`
  ADD CONSTRAINT `FK_userEmail4` FOREIGN KEY (`userEmail`) REFERENCES `users` (`userEmail`);

--
-- Constraints for table `user_address`
--
ALTER TABLE `user_address`
  ADD CONSTRAINT `FK_userEmail` FOREIGN KEY (`userEmail`) REFERENCES `users` (`userEmail`);

--
-- Constraints for table `user_event`
--
ALTER TABLE `user_event`
  ADD CONSTRAINT `FK_userEmail5` FOREIGN KEY (`userEmail`) REFERENCES `users` (`userEmail`);

--
-- Constraints for table `user_sports`
--
ALTER TABLE `user_sports`
  ADD CONSTRAINT `FK_userEmail1` FOREIGN KEY (`userEmail`) REFERENCES `users` (`userEmail`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

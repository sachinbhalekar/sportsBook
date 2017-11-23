-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 23, 2017 at 07:59 PM
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
  `activityId` int(11) NOT NULL,
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

--
-- Dumping data for table `activity_address`
--

INSERT INTO `activity_address` (`userEmail`, `activityId`, `address1`, `address2`, `city`, `state`, `country`, `zipcode`, `landmark`, `latitude`, `longitude`) VALUES
('sam@gmail.com', 1, '18452 Halsted Street', 'Legacy Apt 108', 'Northridge', 'CA', '', 91325, 'near USPS office', 34.2445624, -118.53568310000003),
('sam2@gmail.com', 2, '18452 Halsted st', 'Legacy Apt', 'Northridge', 'CA', 'USA', 91325, 'Near USPS office', 34.2445624, -118.53568310000003);

-- --------------------------------------------------------

--
-- Table structure for table `event_address`
--

CREATE TABLE `event_address` (
  `userEmail` varchar(60) NOT NULL,
  `eventId` int(11) NOT NULL,
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

--
-- Dumping data for table `event_address`
--

INSERT INTO `event_address` (`userEmail`, `eventId`, `address1`, `address2`, `city`, `state`, `country`, `zipcode`, `landmark`, `latitude`, `longitude`) VALUES
('sam@gmail.com', 1, '18111 Nordhoff St', 'Matador Bookstore Complex', 'Northridge', 'CA', 'USA', 91330, 'Near CSUN SRC', 34.237378, -118.528171);

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
('Sam', 'J', 'sam2@gmail.com', 'e3e9fc033c2647b79bac54f75d0965c0715c6856e662fd02da8742100e5cda22', 'M', '1992-02-08', 'I love playing footbal'),
('Sumit', 'Jawale', 'sam@gmail.com', 'e3e9fc033c2647b79bac54f75d0965c0715c6856e662fd02da8742100e5cda22', 'M', '2017-11-07', ''),
('Sumit', 'Jawale', 'sumitpurushottam.jawale@my.csun.edu', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 'M', '2017-11-02', '');

-- --------------------------------------------------------

--
-- Table structure for table `user_activity`
--

CREATE TABLE `user_activity` (
  `userEmail` varchar(60) NOT NULL,
  `activityId` int(11) NOT NULL,
  `activityDesc` text NOT NULL,
  `activitySport` varchar(30) NOT NULL,
  `activityDate` date NOT NULL,
  `activityInTime` time NOT NULL,
  `activityOutTime` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_activity`
--

INSERT INTO `user_activity` (`userEmail`, `activityId`, `activityDesc`, `activitySport`, `activityDate`, `activityInTime`, `activityOutTime`) VALUES
('sam@gmail.com', 1, 'I am going to play the whole day.', 'football', '2017-01-01', '10:00:00', '10:00:00'),
('sam2@gmail.com', 2, 'Playing for a hour', 'football', '2017-01-01', '10:00:00', '11:00:00');

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
('sam1@gmail.com', '18452 HALSTED STREET', 'UNIT 108', 'NORTHRIDGE', 'California', '', 91325, 34.2443551, -118.5355161),
('sam2@gmail.com', '18452 Halsted St', '108', 'Northridge', 'CA', 'country', 91325, 34.2443551, -118.5355161);

-- --------------------------------------------------------

--
-- Table structure for table `user_event`
--

CREATE TABLE `user_event` (
  `userEmail` varchar(60) NOT NULL,
  `eventId` int(11) NOT NULL,
  `eventTitle` varchar(30) NOT NULL,
  `eventDesc` text,
  `eventSport` varchar(30) NOT NULL,
  `eventOccupancy` int(11) NOT NULL,
  `eventDate` date NOT NULL,
  `eventInTime` time NOT NULL,
  `eventOutTime` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_event`
--

INSERT INTO `user_event` (`userEmail`, `eventId`, `eventTitle`, `eventDesc`, `eventSport`, `eventOccupancy`, `eventDate`, `eventInTime`, `eventOutTime`) VALUES
('sam@gmail.com', 1, 'CSUN vs CSULB', 'A match between two uni teams...', 'football', 50, '2017-01-01', '10:00:00', '11:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `user_interested_activity`
--

CREATE TABLE `user_interested_activity` (
  `userEmail` varchar(30) NOT NULL,
  `activityId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user_interested_event`
--

CREATE TABLE `user_interested_event` (
  `userEmail` varchar(30) NOT NULL,
  `eventId` int(11) NOT NULL
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
('sam1@gmail.com', 'football'),
('sam2@gmail.com', 'football');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_address`
--
ALTER TABLE `activity_address`
  ADD KEY `Key_userEmail` (`userEmail`),
  ADD KEY `FK_userEmail7` (`activityId`);

--
-- Indexes for table `event_address`
--
ALTER TABLE `event_address`
  ADD KEY `Key_userEmail` (`userEmail`),
  ADD KEY `FK_userEmail8` (`eventId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userEmail`);

--
-- Indexes for table `user_activity`
--
ALTER TABLE `user_activity`
  ADD PRIMARY KEY (`activityId`),
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
  ADD PRIMARY KEY (`eventId`),
  ADD KEY `Key_userEmail` (`userEmail`);

--
-- Indexes for table `user_interested_activity`
--
ALTER TABLE `user_interested_activity`
  ADD KEY `FK_userEmail11` (`userEmail`),
  ADD KEY `FK_userActivityId` (`activityId`);

--
-- Indexes for table `user_interested_event`
--
ALTER TABLE `user_interested_event`
  ADD KEY `FK_userEmail10` (`userEmail`),
  ADD KEY `FK_userEventId` (`eventId`);

--
-- Indexes for table `user_sports`
--
ALTER TABLE `user_sports`
  ADD KEY `Key_userEmail` (`userEmail`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user_activity`
--
ALTER TABLE `user_activity`
  MODIFY `activityId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_event`
--
ALTER TABLE `user_event`
  MODIFY `eventId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_address`
--
ALTER TABLE `activity_address`
  ADD CONSTRAINT `FK_userEmail2` FOREIGN KEY (`userEmail`) REFERENCES `users` (`userEmail`),
  ADD CONSTRAINT `FK_userEmail7` FOREIGN KEY (`activityId`) REFERENCES `user_activity` (`activityId`);

--
-- Constraints for table `event_address`
--
ALTER TABLE `event_address`
  ADD CONSTRAINT `FK_userEmail3` FOREIGN KEY (`userEmail`) REFERENCES `users` (`userEmail`),
  ADD CONSTRAINT `FK_userEmail8` FOREIGN KEY (`eventId`) REFERENCES `user_event` (`eventId`);

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
-- Constraints for table `user_interested_activity`
--
ALTER TABLE `user_interested_activity`
  ADD CONSTRAINT `FK_userActivityId` FOREIGN KEY (`activityId`) REFERENCES `user_activity` (`activityId`),
  ADD CONSTRAINT `FK_userEmail11` FOREIGN KEY (`userEmail`) REFERENCES `users` (`userEmail`);

--
-- Constraints for table `user_interested_event`
--
ALTER TABLE `user_interested_event`
  ADD CONSTRAINT `FK_userEmail10` FOREIGN KEY (`userEmail`) REFERENCES `users` (`userEmail`),
  ADD CONSTRAINT `FK_userEventId` FOREIGN KEY (`eventId`) REFERENCES `user_event` (`eventId`);

--
-- Constraints for table `user_sports`
--
ALTER TABLE `user_sports`
  ADD CONSTRAINT `FK_userEmail1` FOREIGN KEY (`userEmail`) REFERENCES `users` (`userEmail`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

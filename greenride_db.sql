-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 02, 2026 at 08:18 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `greenride_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `booking_ID` int(5) NOT NULL,
  `seats_requested` int(2) NOT NULL,
  `pickup_point` varchar(100) NOT NULL,
  `dropoff_point` varchar(100) NOT NULL,
  `status` varchar(20) NOT NULL,
  `request_time` datetime NOT NULL,
  `response_time` datetime DEFAULT NULL,
  `cancelled_by` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sos_requests`
--

CREATE TABLE `sos_requests` (
  `sos_ID` int(5) NOT NULL,
  `timestamp` datetime NOT NULL,
  `status` varchar(20) NOT NULL,
  `trip_ID` int(5) NOT NULL,
  `user_ID` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `trip`
--

CREATE TABLE `trip` (
  `trip_ID` int(5) NOT NULL,
  `origin` varchar(100) NOT NULL,
  `destination` varchar(100) NOT NULL,
  `departure` datetime NOT NULL,
  `seats_available` int(2) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `status` varchar(20) NOT NULL,
  `gender_preference` varchar(20) DEFAULT NULL,
  `vehicle_ID` int(5) NOT NULL,
  `user_ID` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `triphistory`
--

CREATE TABLE `triphistory` (
  `history_ID` int(5) NOT NULL,
  `role` varchar(100) NOT NULL,
  `action` varchar(100) NOT NULL,
  `complete_at` datetime NOT NULL,
  `trip_ID` int(5) NOT NULL,
  `user_ID` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `triprequest`
--

CREATE TABLE `triprequest` (
  `request_ID` int(5) NOT NULL,
  `seats_requested` int(2) NOT NULL,
  `pickup_point` varchar(100) NOT NULL,
  `dropoff_point` varchar(100) NOT NULL,
  `status` varchar(20) NOT NULL,
  `request_time` datetime NOT NULL,
  `response_time` datetime DEFAULT NULL,
  `passenger_note` varchar(255) DEFAULT NULL,
  `trip_ID` int(5) NOT NULL,
  `user_ID` int(5) NOT NULL,
  `booking_ID` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_ID` int(5) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `role` varchar(20) NOT NULL,
  `matric_number` varchar(10) NOT NULL,
  `gender` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vehicle`
--

CREATE TABLE `vehicle` (
  `vehicle_ID` int(5) NOT NULL,
  `plate_number` varchar(20) NOT NULL,
  `model` varchar(100) NOT NULL,
  `color` varchar(30) NOT NULL,
  `capacity` int(2) NOT NULL,
  `user_ID` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`booking_ID`);

--
-- Indexes for table `sos_requests`
--
ALTER TABLE `sos_requests`
  ADD PRIMARY KEY (`sos_ID`),
  ADD KEY `trip_ID` (`trip_ID`),
  ADD KEY `user_ID` (`user_ID`);

--
-- Indexes for table `trip`
--
ALTER TABLE `trip`
  ADD PRIMARY KEY (`trip_ID`),
  ADD KEY `vehicle_ID` (`vehicle_ID`),
  ADD KEY `user_ID` (`user_ID`);

--
-- Indexes for table `triphistory`
--
ALTER TABLE `triphistory`
  ADD PRIMARY KEY (`history_ID`),
  ADD KEY `trip_ID` (`trip_ID`),
  ADD KEY `user_ID` (`user_ID`);

--
-- Indexes for table `triprequest`
--
ALTER TABLE `triprequest`
  ADD PRIMARY KEY (`request_ID`),
  ADD KEY `trip_ID` (`trip_ID`),
  ADD KEY `user_ID` (`user_ID`),
  ADD KEY `booking_ID` (`booking_ID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_ID`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `vehicle`
--
ALTER TABLE `vehicle`
  ADD PRIMARY KEY (`vehicle_ID`),
  ADD UNIQUE KEY `plate_number` (`plate_number`),
  ADD KEY `user_ID` (`user_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `booking_ID` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sos_requests`
--
ALTER TABLE `sos_requests`
  MODIFY `sos_ID` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `trip`
--
ALTER TABLE `trip`
  MODIFY `trip_ID` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `triphistory`
--
ALTER TABLE `triphistory`
  MODIFY `history_ID` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `triprequest`
--
ALTER TABLE `triprequest`
  MODIFY `request_ID` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_ID` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vehicle`
--
ALTER TABLE `vehicle`
  MODIFY `vehicle_ID` int(5) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `sos_requests`
--
ALTER TABLE `sos_requests`
  ADD CONSTRAINT `sos_requests_ibfk_1` FOREIGN KEY (`trip_ID`) REFERENCES `trip` (`trip_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sos_requests_ibfk_2` FOREIGN KEY (`user_ID`) REFERENCES `user` (`user_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `trip`
--
ALTER TABLE `trip`
  ADD CONSTRAINT `trip_ibfk_1` FOREIGN KEY (`vehicle_ID`) REFERENCES `vehicle` (`vehicle_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `trip_ibfk_2` FOREIGN KEY (`user_ID`) REFERENCES `user` (`user_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `triphistory`
--
ALTER TABLE `triphistory`
  ADD CONSTRAINT `triphistory_ibfk_1` FOREIGN KEY (`trip_ID`) REFERENCES `trip` (`trip_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `triphistory_ibfk_2` FOREIGN KEY (`user_ID`) REFERENCES `user` (`user_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `triprequest`
--
ALTER TABLE `triprequest`
  ADD CONSTRAINT `triprequest_ibfk_1` FOREIGN KEY (`trip_ID`) REFERENCES `trip` (`trip_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `triprequest_ibfk_2` FOREIGN KEY (`user_ID`) REFERENCES `user` (`user_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `triprequest_ibfk_3` FOREIGN KEY (`booking_ID`) REFERENCES `booking` (`booking_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `vehicle`
--
ALTER TABLE `vehicle`
  ADD CONSTRAINT `vehicle_ibfk_1` FOREIGN KEY (`user_ID`) REFERENCES `user` (`user_ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

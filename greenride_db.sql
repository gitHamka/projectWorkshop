-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 21, 2026 at 07:00 PM
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
  `trip_ID` int(5) NOT NULL,
  `user_ID` int(5) NOT NULL,
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
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `feedback_ID` int(5) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `submitted_at` datetime NOT NULL DEFAULT current_timestamp()
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

--
-- Dumping data for table `trip`
--

INSERT INTO `trip` (`trip_ID`, `origin`, `destination`, `departure`, `seats_available`, `price`, `status`, `gender_preference`, `vehicle_ID`, `user_ID`) VALUES
(6, 'FTMK', 'Kolej AJ', '2026-06-22 08:50:00', 0, 1.50, 'Completed', 'Female', 8, 17),
(7, 'FTMK', 'Mydin', '2026-06-22 10:53:00', 4, 1.50, 'Completed', 'Male', 9, 18),
(8, 'FTMK', 'AJ', '2026-06-21 21:22:00', 1, 1.50, 'Active', 'Mixed', 9, 18),
(9, 'FTMK', 'AJ', '2026-06-21 23:00:00', 2, 1.50, 'Active', 'Female', 8, 17);

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
  `booking_ID` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `triprequest`
--

INSERT INTO `triprequest` (`request_ID`, `seats_requested`, `pickup_point`, `dropoff_point`, `status`, `request_time`, `response_time`, `passenger_note`, `trip_ID`, `user_ID`, `booking_ID`) VALUES
(5, 4, 'FTMK', 'Kolej AJ', 'Confirmed', '2026-06-21 19:52:02', '2026-06-21 20:47:02', 'otw', 6, 18, NULL),
(6, 1, 'FTMK', 'Mydin', 'Confirmed', '2026-06-21 19:52:29', '2026-06-21 20:08:24', 'ok', 7, 19, NULL),
(7, 3, 'FTMK', 'Mydin', 'Cancelled', '2026-06-21 21:20:21', '2026-06-21 21:33:14', '', 7, 17, NULL),
(8, 1, 'FTMK', 'AJ', 'Cancelled', '2026-06-21 21:22:56', '2026-06-21 21:31:46', 'ok', 8, 17, NULL),
(9, 1, 'FTMK', 'AJ', 'Cancelled', '2026-06-21 21:32:32', '2026-06-21 21:32:41', '1', 8, 17, NULL),
(10, 1, 'FTMK', 'AJ', 'Cancelled', '2026-06-21 21:32:52', '2026-06-21 21:33:23', 'otw', 8, 17, NULL),
(11, 1, 'FTMK', 'AJ', 'Cancelled', '2026-06-21 22:16:29', '2026-06-21 22:16:34', '', 8, 17, NULL),
(12, 2, 'FTMK', 'AJ', 'Pending', '2026-06-21 23:02:25', NULL, 'otw', 9, 18, NULL);

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

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_ID`, `name`, `email`, `password`, `phone_number`, `role`, `matric_number`, `gender`) VALUES
(17, 'NUR HASYA HUMAIRA BT HASSAN', 'd032410250@student.utem.edu.my', '$2y$10$uQGLpid0uRSVAPhvMwL0jeBoQoWlCWaDCVKdUweEZtFxm22dU.NSC', '0169815504', 'Driver', 'D032410250', 'Female'),
(18, 'MUHAMMAD NAEEM BIN MOHD RAZALI', 'd032410412@student.utem.edu.my', '$2y$10$4m21XraRzWxSqPTl2uZ5veoJxk.CxOV4CaCikp63ljatzOFjmprKy', '0123456789', 'Driver', 'D032410412', 'Male'),
(19, 'FARAH QISTINA BINTI MOHD HISHAM', 'd032410106@student.utem.edu.my', '$2y$10$BHYUS4W7vYQbbBAjbIBy5.WZz7uM9zR9zVxFgyqmQgoifIiQ5KQYa', '01233333333', 'Passenger', 'D032410106', '');

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
-- Dumping data for table `vehicle`
--

INSERT INTO `vehicle` (`vehicle_ID`, `plate_number`, `model`, `color`, `capacity`, `user_ID`) VALUES
(8, 'MAV9303', 'Kembara', 'RED', 0, 17),
(9, 'MBT5944', 'Kancil', 'BLUE', 0, 18);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`booking_ID`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`feedback_ID`);

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
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `feedback_ID` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sos_requests`
--
ALTER TABLE `sos_requests`
  MODIFY `sos_ID` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `trip`
--
ALTER TABLE `trip`
  MODIFY `trip_ID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `triphistory`
--
ALTER TABLE `triphistory`
  MODIFY `history_ID` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `triprequest`
--
ALTER TABLE `triprequest`
  MODIFY `request_ID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_ID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `vehicle`
--
ALTER TABLE `vehicle`
  MODIFY `vehicle_ID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

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

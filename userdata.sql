-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 22, 2026 at 12:13 AM
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
(4, 'naeem', 'd123456789@student.utem.edu.my', '$2y$10$mEm4SYXr9oQQIzbW2UVszulR0fWsvXpD4cQsvhya7ta.kqUU4P2Za', '012345678', 'Passenger', 'd123456789', ''),
(5, 'hasya', 'd123456788@student.utem.edu.my', '$2y$10$oM8IEprVPMi5BeVYZ2Q3U.P1LlwiDmraMARRNnxUgDe2e.rIE2yKO', '012345677', 'Passenger', 'd123456788', ''),
(6, 'nurin', 'd123456787@student.utem.edu.my', '$2y$10$Au3VxkDB7fA.G2FDOLNtjuNj8F7wjxn4uH2n9sfomQhjFdJ2qwz7O', '012345676', 'Passenger', 'd123456787', ''),
(7, 'farah', 'd123456786@student.utem.edu.my', '$2y$10$XAL73WJwExruRuHKRCaCxu8WaWQIR/2VH8y78qcmNVx26fSlAVwo2', '0123452132', 'Passenger', 'd123456786', ''),
(9, 'syirah', 'd123456785@student.utem.edu.my', '$2y$10$/jFoUBe/b27HrFyU/S5s6er7nVi/qeYpzPvgTLXUo8IjtahYdQLNG', '0123452132', 'Passenger', 'd123456785', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_ID`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_ID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

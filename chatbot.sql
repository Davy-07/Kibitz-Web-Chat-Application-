-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 08, 2022 at 05:45 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `chatbot`
--

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `msg_id` int(10) NOT NULL,
  `reciever` varchar(255) NOT NULL,
  `sender` varchar(255) NOT NULL,
  `msg` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`msg_id`, `reciever`, `sender`, `msg`) VALUES
(50, 'sample6', 'abc', 'hi'),
(51, 'abc', 'sample6', 'hello'),
(52, 'sample6', 'abc', 'how a'),
(53, 'abc', 'sample6', 'i am fine'),
(54, 'abc', 'sample6', 'what about you??'),
(55, 'sample6', 'abc', 'i am fine too'),
(56, 'sample6', 'abc', 'hi sample 6'),
(57, 'abc', 'sample6', 'hi abc'),
(58, 'abc', 'sample7', 'hi abc'),
(59, 'abc', 'sample7', 'how are you'),
(60, 'abc', 'sample7', 'hello'),
(61, 'abc', 'sample7', 'namaste abc'),
(62, 'sample7', 'abc', 'hello sample7'),
(63, 'abc', 'sample6', 'hello abc'),
(64, 'sample6', 'abc', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'),
(65, 'sample6', 'abc', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'),
(66, 'sample6', 'abc', 'hi');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `usersID` int(3) NOT NULL,
  `unique_id` int(11) NOT NULL,
  `usersName` varchar(255) NOT NULL,
  `usersEmail` varchar(255) NOT NULL,
  `usersPwd` varchar(255) NOT NULL,
  `userStatus` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`usersID`, `unique_id`, `usersName`, `usersEmail`, `usersPwd`, `userStatus`) VALUES
(20, 171302031, 'sample6', 'sample6@gmail.com', '$2y$10$IKcVT/vnjvx6DccDJZrACOFDGyjD1jUYWZXS.lMzTb2zTIwKtrCwK', 'Active Now'),
(21, 1207574016, 'sample7', 'sample7@gmail.com', '$2y$10$GDMKIuj7359i7uD9JozTUONsPY19aMg4zM3S13iF6bZNaQVO5AfrG', 'Offline'),
(22, 849806241, 'abc', 'abc@gmail.com', '$2y$10$2tyn6TzUTCpFH31U7hov3.t9wptWvrCeheqBSmRDgI2SzyC8EIctu', 'Active Now'),
(23, 703141468, 'mihir', 'mihir@gmail.com', '$2y$10$izNof2aQq/lnXlkfpqqloOHATrRkO9IaW.tfheo.IskfnMoraFPAC', 'Offline');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`msg_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`usersID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `msg_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `usersID` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

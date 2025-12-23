-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 10, 2025 at 03:16 PM
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
-- Database: `tk-db`
--

-- --------------------------------------------------------

--
-- Table structure for table `tk_form`
--

CREATE TABLE `tk_form` (
  `id` int(50) NOT NULL,
  `ticket_number` int(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `Phone` int(11) NOT NULL,
  `Account` varchar(11) NOT NULL,
  `tl_name` varchar(11) NOT NULL,
  `Port_Number` int(11) NOT NULL,
  `Issue` varchar(11) NOT NULL,
  `Description` varchar(11) NOT NULL,
  `status` varchar(50) NOT NULL,
  `created_date` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tk_form`
--

INSERT INTO `tk_form` (`id`, `ticket_number`, `name`, `Phone`, `Account`, `tl_name`, `Port_Number`, `Issue`, `Description`, `status`, `created_date`) VALUES
(2023, 48, 'mohamed ', 225781845, 'Cnr', 'karim', 100, 'Keyboard', 'any', 'Open', '2025-02-05 15:04:22'),
(2023, 49, 'mohamed ', 225781845, 'Cnr', 'karim', 100, 'CPU', 'any', 'Open', '2025-02-05 15:04:31'),
(2023, 50, 'mohamed ', 225781845, 'Cnr', 'karim', 100, 'Power Cable', 'any', 'Open', '2025-02-05 15:04:41'),
(1, 51, 'ahmed mohamed', 1006883626, 'Cnr', 'KhALED', 100, 'Keyboard', 'broken', 'Open', '2025-02-05 15:04:55'),
(3, 52, 'mohamed ', 2147483647, 'SMB', 'Ayman', 108, 'Power Cable', 'محرووق', 'Open', '2025-04-10 14:36:19'),
(3, 53, 'mohamed ', 2147483647, 'SMB', 'Ayman', 108, 'Power Cable', 'محرووق', 'Open', '2025-04-10 15:10:35');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_name`, `password`, `name`) VALUES
(1, 'Tech', 'P@ssw0rd50', 'Tech'),
(2, 'EGS', 'Egs@123', 'EGS');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tk_form`
--
ALTER TABLE `tk_form`
  ADD PRIMARY KEY (`ticket_number`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tk_form`
--
ALTER TABLE `tk_form`
  MODIFY `ticket_number` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

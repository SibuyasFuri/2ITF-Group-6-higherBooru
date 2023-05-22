-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 22, 2023 at 11:30 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `imageboard_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image_url` text NOT NULL,
  `tags` varchar(255) NOT NULL,
  `dateUploaded` date NOT NULL DEFAULT current_timestamp(),
  `user_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`id`, `name`, `image_url`, `tags`, `dateUploaded`, `user_id`) VALUES
(61, 'swag', 'IMG-646b083f7a60a7.13053271.png', 'swag,', '2023-05-22', 132),
(62, '3', 'IMG-646b0878c512a1.00342183.png', '3,', '2023-05-22', 999),
(63, '4', 'IMG-646b096edbfde1.26123076.png', ',', '2023-05-22', 635),
(64, '5', 'IMG-646b098ac8a243.55387716.png', ',', '2023-05-22', 252),
(65, '123', 'IMG-646b0f3bd14503.97459502.png', ',', '2023-05-22', 224),
(66, '123', 'IMG-646b125eb002e3.12665629.png', '1231,', '2023-05-22', 645),
(67, '123', 'IMG-646b154b1c90f0.77625495.png', '123,', '2023-05-22', 997),
(68, '1112312', 'IMG-646b15770a9637.10608633.png', ',', '2023-05-22', 970),
(69, '123', 'IMG-646b17ebc99271.71083140.png', '1,', '2023-05-22', 915);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_id`, `user_name`, `password`, `date`) VALUES
(63, 132, '1', '1', '2023-05-22 06:14:14'),
(64, 999, '3', '3', '2023-05-22 06:15:10'),
(65, 635, '4', '4', '2023-05-22 06:19:19'),
(66, 252, '5', '5', '2023-05-22 06:19:46'),
(67, 224, '123', '123', '2023-05-22 06:44:03'),
(68, 645, 'test123', 'test123', '2023-05-22 06:57:24'),
(69, 997, '67', '67', '2023-05-22 07:09:33'),
(70, 970, 'abcv', 'ab', '2023-05-22 07:10:37'),
(71, 915, 'zzzz', '12', '2023-05-22 07:21:02');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

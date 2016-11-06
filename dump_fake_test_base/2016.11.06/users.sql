-- phpMyAdmin SQL Dump
-- version 4.6.4deb1+deb.cihar.com~xenial.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 06, 2016 at 04:22 PM
-- Server version: 5.7.16-0ubuntu0.16.04.1
-- PHP Version: 7.0.8-0ubuntu0.16.04.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `las`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `hashed_password` varchar(60) COLLATE utf8_polish_ci NOT NULL,
  `user_email` varchar(255) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `hashed_password`, `user_email`) VALUES
(1, 'tygrysek', '$2y$10$imvXQUVUY47AKpx7XGya1.xoKco25rXMr9k33Q81ZK.Gedu69v1Ra', 'tygrysek@gmail.elo'),
(2, 'prosiaczek', '$2y$10$maG52v9d4ZNLm/q.mUiwH.T7DG/72V65THjnnAfXvSpaad.ndVtQG', 'prosiaczek@gmail.elo'),
(3, 'sowa', '$2y$10$WN5sDJyLNCnJqBbX5zpyYOdhXMsF068qA5oLJ/80cExmJDWBjYqga', 'sowa@gmail.elo'),
(4, 'mamakrzysia', '$2y$10$TOEUKix7C42IAymIM.xqj.5He14fwfeOrnZjAEe83XLUCmz8oq7fe', 'mamakrzysia@gmail.elo');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_email` (`user_email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

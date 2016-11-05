-- phpMyAdmin SQL Dump
-- version 4.6.4deb1+deb.cihar.com~xenial.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 05, 2016 at 05:31 PM
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
-- Table structure for table `tweet`
--

CREATE TABLE `tweet` (
  `tweet_id` int(11) NOT NULL,
  `tweet_user_id` int(11) NOT NULL,
  `tweet_text` varchar(250) COLLATE utf8_polish_ci NOT NULL,
  `tweet_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Dumping data for table `tweet`
--

INSERT INTO `tweet` (`tweet_id`, `tweet_user_id`, `tweet_text`, `tweet_date`) VALUES
(1, 2, 'ktoś obcy przybył do stumilowego lasu', '2016-11-05'),
(2, 2, 'las był pusty i ciemny. Nawet drzew nie było', '2016-11-05'),
(3, 2, 'mimo, ze drzew nie było to szumiały wierzby', '2016-11-05'),
(4, 3, 'id3 tygrysek pomachał ogonem kłapouchego', '2016-11-05'),
(5, 3, 'id3 a nastepnie przypiął go z powrotem', '2016-11-05');

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
-- Indexes for table `tweet`
--
ALTER TABLE `tweet`
  ADD PRIMARY KEY (`tweet_id`),
  ADD KEY `tweet_user_id` (`tweet_user_id`);

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
-- AUTO_INCREMENT for table `tweet`
--
ALTER TABLE `tweet`
  MODIFY `tweet_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `tweet`
--
ALTER TABLE `tweet`
  ADD CONSTRAINT `tweet_ibfk_1` FOREIGN KEY (`tweet_user_id`) REFERENCES `users` (`user_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

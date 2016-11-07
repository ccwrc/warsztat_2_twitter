-- phpMyAdmin SQL Dump
-- version 4.6.4deb1+deb.cihar.com~xenial.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 07, 2016 at 04:01 PM
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
  `tweet_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Dumping data for table `tweet`
--

INSERT INTO `tweet` (`tweet_id`, `tweet_user_id`, `tweet_text`, `tweet_date`) VALUES
(1, 2, 'ktoś obcy przybył do stumilowego lasu', '2016-11-05 01:00:00'),
(2, 2, 'las był pusty i ciemny. Nawet drzew nie było', '2016-11-05 02:00:00'),
(3, 2, 'mimo, ze drzew nie było to szumiały wierzby', '2016-11-05 03:00:00'),
(4, 3, 'id3 tygrysek pomachał ogonem kłapouchego', '2016-11-05 06:00:00'),
(5, 3, 'id3 a nastepnie przypiął go z powrotem', '2016-11-05 08:00:00'),
(6, 1, 'id1 test nowy format daty', '2015-11-05 00:00:00'),
(7, 4, 'mama krzysia wyszła z cienia. Miała na sobie buty z Kory. Kora była poirytowana.', '2016-11-06 16:15:34'),
(8, 4, 'Kora, krzycząc, rzuciła sie w pogoń za butami.', '2016-11-06 16:20:40'),
(9, 4, 'W tym czasie Puchatek zajmował się w swojej norze miodkiem.', '2016-11-06 16:57:22'),
(10, 4, 'Warzenie miodu było jego hobby od lat. Od lat był także skrytym alkoholikiem.', '2016-11-06 16:58:20'),
(11, 1, 'Na urodziny osiołka kubuś przygotowuje edycję syconą, przyprawianą magicznymi ziołami z lasu.', '2016-11-06 17:06:55'),
(12, 5, 'Jaś i Małgosia przybyli do lasu. Niby zabójcy, ale Małgosia wyrosła na niezłą szprychę', '2016-11-07 13:06:49'),
(13, 3, 'Jaś wpadł w bagno a Małgosia zgubiła zagrychę w krzakach. Miastowe pokraki :(', '2016-11-07 13:49:21');

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
(4, 'mamakrzysia', '$2y$10$TOEUKix7C42IAymIM.xqj.5He14fwfeOrnZjAEe83XLUCmz8oq7fe', 'mamakrzysia@gmail.elo'),
(5, 'Krzyś', '$2y$10$GS0XjU.wz6gMPpT2JAlMTe8j/IRw.WHYwbINCEQYF8OMYe.N5urIO', 'Krzyś@gmail.elo'),
(6, 'testhasla1', '$2y$10$.sNo7sAJlz2zQw3..qgOlOIQnSqqO2QUk1.92HIvgdGjzXsLdRcMK', 'testhasla1@gmail.elo'),
(7, 'testhasla2', '$2y$10$DWc5//8.r44fqEDRb9LHEea10Ghx9JBVISfXdAylGm3L3OUZ/5s1u', 'testhasla2@gmail.elo'),
(8, 'jsw', '$2y$10$t7NsZDRIejNXkO7GcoXaDecSmDPiUIrUPa3m42B1c.NfefDM/2cOW', 'jsw@gmail.elo'),
(9, 'inhot', '$2y$10$gJf90HW2sVpE57ya1gHhQOEqsjKIbVfodtnmZWHviOPGuy0jSsnJm', 'inhot@gmail.elo'),
(10, 'login', '$2y$10$c3mlRDL8Za12iWxFOJQUz.8nL3vA040.B/XzYc28.o.5NWQ5lGojO', 'login@gmail.elo'),
(11, 'borsuk', '$2y$10$fs0nZ0YMIuOVk0yOHLYMO.0oSoGegylowhpBXv6nSV48tDJ4AsEDC', 'borsuk@borsuk.elo'),
(12, 'testd', '$2y$10$EPrYSmgOhN6CkCRy/9XcTOgq2NkBZLd4icip.C6bQmAfXiFHf4wl2', 'testd@gmail.elo'),
(13, 'test4', '$2y$10$AdXUQ06KpC0AAYWkrmE2Guhul5o21dp.kRkZnLkK1RlhViZsINHpy', 'ttttttt@o2.tt');

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
  MODIFY `tweet_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
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

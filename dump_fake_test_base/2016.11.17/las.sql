-- phpMyAdmin SQL Dump
-- version 4.6.4deb1+deb.cihar.com~xenial.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 17, 2016 at 05:43 PM
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
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `comment_id` int(11) NOT NULL,
  `comment_user_id` int(11) NOT NULL,
  `comment_tweet_id` int(11) NOT NULL,
  `comment_creation_date` datetime DEFAULT NULL,
  `comment_text` varchar(80) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`comment_id`, `comment_user_id`, `comment_tweet_id`, `comment_creation_date`, `comment_text`) VALUES
(1, 1, 1, '2000-01-23 00:00:00', 'drugi koment'),
(2, 1, 1, '2016-11-15 12:57:34', '1 test koment'),
(3, 1, 1, '2016-11-15 12:58:10', 'czeci test koment'),
(4, 3, 29, '2016-11-15 17:20:12', 'asecwqr'),
(5, 3, 29, '2016-11-15 17:20:50', 'htfhdfhdh'),
(6, 3, 29, '2016-11-15 17:22:14', 'yhfdszasx'),
(7, 3, 23, '2016-11-15 17:25:17', 'uwajfdygwqq'),
(8, 3, 28, '2016-11-15 17:25:45', 'qcxzuqtcxuqfw'),
(9, 3, 23, '2016-11-15 17:26:11', 'jyrsrrkjsdkj'),
(10, 3, 6, '2016-11-15 17:27:00', 'wefrwfwf'),
(11, 3, 6, '2016-11-15 17:27:12', 'wefweffefefff'),
(12, 3, 29, '2016-11-15 17:33:41', 'iuujyfcdxz'),
(13, 3, 29, '2016-11-15 17:37:32', 'wawawsss'),
(14, 3, 29, '2016-11-15 17:37:55', ''),
(15, 3, 29, '2016-11-15 17:45:30', ''),
(16, 3, 29, '2016-11-15 17:45:42', ''),
(17, 3, 29, '2016-11-15 17:48:06', '111'),
(18, 3, 29, '2016-11-15 17:49:06', 'sdfsf'),
(19, 3, 29, '2016-11-16 10:04:51', '111111111112222222222333333333344444444445555555555666666666'),
(20, 3, 4, '2016-11-16 11:00:26', 'werwerr'),
(21, 3, 4, '2016-11-16 11:00:35', 'werwrwr'),
(22, 14, 29, '2016-11-16 11:22:09', 'komentuje bo moge'),
(23, 14, 15, '2016-11-16 11:23:27', 'tu tez dodamźźźźźź'),
(25, 14, 23, '2016-11-16 22:39:55', 'nowy koment'),
(26, 3, 33, '2016-11-17 16:53:23', 'botom m&oacute;wimy nie');

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `message_id` int(11) NOT NULL,
  `message_read` int(11) NOT NULL,
  `message_sender_id` int(11) NOT NULL,
  `message_receiver_id` int(11) NOT NULL,
  `message_content` text COLLATE utf8_polish_ci,
  `message_creation_date` datetime NOT NULL,
  `message_sender_visible` int(11) NOT NULL,
  `message_receiver_visible` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

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
(13, 3, 'Jaś wpadł w bagno a Małgosia zgubiła zagrychę w krzakach. Miastowe pokraki :(', '2016-11-07 13:49:21'),
(14, 3, 'Orły lecą z Gondoru, szykuje się niezła biba. Będziemy opiekać resztę palców Froda.', '2016-11-07 20:50:01'),
(15, 14, 'Ciało Pinokia leżało na ziemi, a nad nim w złowieszczym kluczu krążyły dzięcioły. ccwrc wita.', '2016-11-07 20:52:42'),
(16, 15, 'Tony Halik. Tu byłem. Na MOJEJ planecie...', '2016-11-07 20:57:09'),
(21, 3, 'Basiu, kup mi lody po drodze do domu, dobrze? Pistacjowe poproszę, dzięki.', '2016-11-09 21:56:58'),
(23, 19, 'dzięcioł ocknął sie obok pieca. Po ostrym tankowaniu zostały tylko porozrzucane garnczki waniające syconym miodkiem', '2016-11-14 11:40:57'),
(24, 19, 'mętny wzrok dzięcioła powoli szacował otoczenie. Nora nie miała okien a jedyne z niej wyjście coś blokowało.', '2016-11-14 11:42:18'),
(25, 19, 'ostry jak igła dziób dzięcioła powoli, acz zdecydowanie kierował się ku puchatej przeszkodzie blokującej jedyne wyjście z nory...', '2016-11-14 11:43:14'),
(26, 19, 'Prosiaczek przy bajorku razem z orłami sączył leniwie sok z kapusty. Od lat nie był na takim kacu, Puchatek naprawdę dał czadu.', '2016-11-14 11:48:07'),
(27, 19, 'Nagle ! sielankową, leśną, poranną ciszę przeszył rozdzierający uszy wrzask ', '2016-11-14 11:51:42'),
(28, 19, 'Kubek wymsknął się prosiaczkowi, sok z kiszonej kapusty powoli wsiąkał w mech... Orły popatrzyły na prosiaczka z naganą', '2016-11-14 11:53:18'),
(29, 14, 'mod/admin test - Lepszy wróbel w krzakach niż sęp w przestworzach.', '2016-11-15 11:25:14'),
(33, 22, 'I oto jestem. Ja. Bezpieczna i budząca zaufanie.', '2016-11-17 15:42:49');

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
(2, 'prosiaczek', '$2y$10$t.RB1LVKfCRIx6310e9bU.JQaSAIiphZ6nBOAjPy0c7Ud2CIrsXNC', 'prosiaczek@gmail.elo'),
(3, 'sowa', '$2y$10$Y9IpvBxAdfmvZ5yyusyIw.VwjnnZle7c8iJIU2WotQZS7XQQbUVfS', 'sowa@gmail.elo'),
(4, 'mamakrzysia', '$2y$10$TOEUKix7C42IAymIM.xqj.5He14fwfeOrnZjAEe83XLUCmz8oq7fe', 'mamakrzysia@gmail.elo'),
(5, 'Krzyś', '$2y$10$GS0XjU.wz6gMPpT2JAlMTe8j/IRw.WHYwbINCEQYF8OMYe.N5urIO', 'Krzyś@gmail.elo'),
(6, 'testhasla1', '$2y$10$.sNo7sAJlz2zQw3..qgOlOIQnSqqO2QUk1.92HIvgdGjzXsLdRcMK', 'testhasla1@gmail.elo'),
(7, 'testhasla2', '$2y$10$DWc5//8.r44fqEDRb9LHEea10Ghx9JBVISfXdAylGm3L3OUZ/5s1u', 'testhasla2@gmail.elo'),
(8, 'jsw', '$2y$10$t7NsZDRIejNXkO7GcoXaDecSmDPiUIrUPa3m42B1c.NfefDM/2cOW', 'jsw@gmail.elo'),
(9, 'inhot', '$2y$10$gJf90HW2sVpE57ya1gHhQOEqsjKIbVfodtnmZWHviOPGuy0jSsnJm', 'inhot@gmail.elo'),
(10, 'login', '$2y$10$c3mlRDL8Za12iWxFOJQUz.8nL3vA040.B/XzYc28.o.5NWQ5lGojO', 'login@gmail.elo'),
(11, 'borsuk', '$2y$10$fs0nZ0YMIuOVk0yOHLYMO.0oSoGegylowhpBXv6nSV48tDJ4AsEDC', 'borsuk@borsuk.elo'),
(12, 'testd', '$2y$10$EPrYSmgOhN6CkCRy/9XcTOgq2NkBZLd4icip.C6bQmAfXiFHf4wl2', 'testd@gmail.elo'),
(13, 'test4', '$2y$10$AdXUQ06KpC0AAYWkrmE2Guhul5o21dp.kRkZnLkK1RlhViZsINHpy', 'ttttttt@o2.tt'),
(14, '<b>ccwrc</b>', '$2y$10$uB/jiFgtGp/rBYYxC6p8JOVcth3mCJUMgL/5REzglPPi79hZPv0lC', 'ccwrc@gmail.elo'),
(15, 'Predator', '$2y$10$QXRnm4fPf1mNghWDRdPeyOeVMpcoNCeMvE9agBP/SysP2xlk3lBH.', 'predator@gmail.elo'),
(16, 'Admin', '$2y$10$DktSlejYPJhNJfT5LP8FNOsKc3dDn6Kwpq.ibBDjC.5rDg.h8ZjNG', 'admin@dziecioly.pl'),
(17, 'bardzo ługi nick 11111111111111111111111111111111 2222222222222 333333333333333333333333333333333 444444444444444444444444444444444 5        555555555555555555555555', '$2y$10$O/f3J38WnlqFfkqNhNdW.O2T7PkKS13PgeiCtmAm2y7a9WgLgGAMi', 'nick@nick.elo'),
(18, '<b>bigbird</b>', '$2y$10$FW7z0hs9LZUq9TtSwq53t.T7rXVJL/x2JqycVlIu4RDaBnbYB0sUO', 'big@big.elo'),
(19, 'CzerwonyIrokez', '$2y$10$Ux/EOiQoYE/Gl6WaqlabIeIYK/Y4ARvdlhRuQ/CHEdnOFrAMjZfYi', 'czerwonyirokez@gmail.elo'),
(20, '&lt;b&gt;grubybold&lt;/b&gt;', '$2y$10$QOZuOfOURu7i1yLOXEAzkuJdUeyAtT0nd9eYMOQUNLetVeXemypgi', 'gruby@gmail.elo'),
(21, 'wwwwwwwww', '$2y$10$Tzj83GOO/Yy4G/mlR07AHef1KVCCcv6gCVRXPn8GNHARy.yt2A.M2', 'ee@rrrr.pl'),
(22, 'kapcza', '$2y$10$kHOh6Lm7hJU/rxBgXAk1se1axS2vuMe68R3ZdXpyXJSekcWMdG9Ha', 'kapcza@gmail.elo');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `comment_user_id` (`comment_user_id`),
  ADD KEY `comment_tweet_id` (`comment_tweet_id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`message_id`),
  ADD KEY `message_sender_id` (`message_sender_id`),
  ADD KEY `message_receiver_id` (`message_receiver_id`);

--
-- Indexes for table `tweet`
--
ALTER TABLE `tweet`
  ADD PRIMARY KEY (`tweet_id`),
  ADD KEY `tweet_ibfk_1` (`tweet_user_id`);

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
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tweet`
--
ALTER TABLE `tweet`
  MODIFY `tweet_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`comment_user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`comment_tweet_id`) REFERENCES `tweet` (`tweet_id`) ON DELETE CASCADE;

--
-- Constraints for table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `message_ibfk_1` FOREIGN KEY (`message_sender_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `message_ibfk_2` FOREIGN KEY (`message_receiver_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `tweet`
--
ALTER TABLE `tweet`
  ADD CONSTRAINT `tweet_ibfk_1` FOREIGN KEY (`tweet_user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

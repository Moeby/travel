-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 29, 2017 at 10:46 AM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `travel`
--

-- --------------------------------------------------------

--
-- Table structure for table `user_has_location`
--

DROP TABLE IF EXISTS `user_has_location`;
CREATE TABLE `user_has_location` (
  `user_id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `home` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_has_location`
--

INSERT INTO `user_has_location` (`user_id`, `location_id`, `post_id`, `home`) VALUES
(1, 4, 1, 0),
(1, 10, 4, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user_has_location`
--
ALTER TABLE `user_has_location`
  ADD PRIMARY KEY (`user_id`,`location_id`),
  ADD KEY `fk_user_has_location_location1_idx` (`location_id`),
  ADD KEY `fk_user_has_location_user1_idx` (`user_id`),
  ADD KEY `fk_user_has_location_post1_idx` (`post_id`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `user_has_location`
--
ALTER TABLE `user_has_location`
  ADD CONSTRAINT `fk_user_has_location_location1` FOREIGN KEY (`location_id`) REFERENCES `location` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_user_has_location_post1` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_user_has_location_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

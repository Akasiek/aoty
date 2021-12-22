-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 22, 2021 at 09:06 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aoty`
--

-- --------------------------------------------------------

--
-- Table structure for table `albums`
--

CREATE TABLE `albums` (
  `id` int(11) NOT NULL,
  `title` varchar(30) DEFAULT NULL,
  `release_year` int(2) DEFAULT NULL,
  `artist_id` int(11) DEFAULT NULL,
  `coverart_url` varchar(2083) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `albums`
--

INSERT INTO `albums` (`id`, `title`, `release_year`, `artist_id`, `coverart_url`) VALUES
(1, 'For the first time', 2021, 1, 'https://upload.wikimedia.org/wikipedia/en/9/9b/Black_Country_New_Road-_For_the_First_Time_%28Album_Cover%29.jpg'),
(2, 'Cavalcade', 2021, 7, 'https://upload.wikimedia.org/wikipedia/en/d/da/Black_Midi_-_Cavalcade_cover_art.png'),
(3, 'G_d\'s Pee AT STATE\'S END!', 2021, 9, 'https://upload.wikimedia.org/wikipedia/en/8/8d/G_dsPeeAtStatesEnd.jpeg'),
(4, 'Fortitude', 2021, 8, 'https://upload.wikimedia.org/wikipedia/en/0/0b/Gojira_Fortitude_artwork.png'),
(5, 'Scaled And Icy', 2021, 10, 'https://upload.wikimedia.org/wikipedia/en/5/52/Twenty_One_Pilots_-_Scaled_and_Icy.png'),
(6, 'GLOW ON', 2021, 4, 'https://upload.wikimedia.org/wikipedia/en/b/b5/Glow_On_%28Turnstile%29.png'),
(7, 'Aphelion', 2021, 3, 'https://upload.wikimedia.org/wikipedia/en/0/05/Leprous_aphelion.jpg'),
(8, 'In the Court of the Dragon', 2021, 5, 'https://upload.wikimedia.org/wikipedia/en/f/ff/TriviumIntheCourtoftheDragon.jpg'),
(9, '9', 2021, 6, 'https://upload.wikimedia.org/wikipedia/en/a/ac/Album_9_by_Pond.png'),
(10, 'CARNAGE', 2021, 2, 'https://upload.wikimedia.org/wikipedia/en/7/72/Carnage_%28Nick_Cave_and_Warren_Ellis%29.png');

-- --------------------------------------------------------

--
-- Table structure for table `artists`
--

CREATE TABLE `artists` (
  `id` int(11) NOT NULL,
  `name` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `artists`
--

INSERT INTO `artists` (`id`, `name`) VALUES
(1, 'Black Country, New Road'),
(2, 'Nick Cave & Warren Ellis'),
(3, 'Leprous'),
(4, 'Turnstile'),
(5, 'Trivium'),
(6, 'Pond'),
(7, 'black midi'),
(8, 'Gojira'),
(9, 'Godspeed You! Black Emperor'),
(10, 'Twenty One Pilots');

-- --------------------------------------------------------

--
-- Table structure for table `lists`
--

CREATE TABLE `lists` (
  `id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `lists`
--

INSERT INTO `lists` (`id`, `owner_id`) VALUES
(1, 6),
(3, 7),
(2, 8);

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE `ratings` (
  `id` int(11) NOT NULL,
  `albums_position` int(11) NOT NULL,
  `album_id` int(11) NOT NULL,
  `list_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`) VALUES
(6, 'akasiek'),
(8, 'krzysiek'),
(7, 'marek'),
(9, 'stefan');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `albums`
--
ALTER TABLE `albums`
  ADD PRIMARY KEY (`id`),
  ADD KEY `artist_id` (`artist_id`);

--
-- Indexes for table `artists`
--
ALTER TABLE `artists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lists`
--
ALTER TABLE `lists`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lists_owner_id` (`owner_id`);

--
-- Indexes for table `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ratings_list_id` (`list_id`),
  ADD KEY `ratings_album_id` (`album_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `albums`
--
ALTER TABLE `albums`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `artists`
--
ALTER TABLE `artists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `lists`
--
ALTER TABLE `lists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `albums`
--
ALTER TABLE `albums`
  ADD CONSTRAINT `albums_ibfk_1` FOREIGN KEY (`artist_id`) REFERENCES `artists` (`id`);

--
-- Constraints for table `lists`
--
ALTER TABLE `lists`
  ADD CONSTRAINT `lists_owner_id` FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `ratings`
--
ALTER TABLE `ratings`
  ADD CONSTRAINT `ratings_album_id` FOREIGN KEY (`album_id`) REFERENCES `albums` (`id`),
  ADD CONSTRAINT `ratings_list_id` FOREIGN KEY (`list_id`) REFERENCES `lists` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

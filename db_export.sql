-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 26, 2021 at 06:51 PM
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
(10, 'CARNAGE', 2021, 2, 'https://upload.wikimedia.org/wikipedia/en/7/72/Carnage_%28Nick_Cave_and_Warren_Ellis%29.png'),
(21, 'Promises', 2021, 13, 'https://upload.wikimedia.org/wikipedia/en/a/ae/Promises_%28Floating_Points%2C_Pharoah_Sanders_and_the_London_Symphony_Orchestra%29.png'),
(22, 'SOUR', 2021, 12, 'https://upload.wikimedia.org/wikipedia/en/b/b2/Olivia_Rodrigo_-_SOUR.png'),
(23, 'Hey What', 2021, 11, 'https://upload.wikimedia.org/wikipedia/en/b/b5/Low_-_Hey_What.png'),
(24, 'THE FUTURE BITES', 2021, 15, 'https://upload.wikimedia.org/wikipedia/en/2/28/Steven_Wilson_-_The_Future_Bites.png'),
(25, 'Typhoons', 2021, 14, 'https://upload.wikimedia.org/wikipedia/en/1/1a/Royal_Blood_-_Typhoons.png');

--
-- Triggers `albums`
--
DELIMITER $$
CREATE TRIGGER `new_leaderboard_insert_when_new_album` AFTER INSERT ON `albums` FOR EACH ROW BEGIN
	INSERT INTO leaderboard(album_id) VALUES (new.id);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `artists`
--

CREATE TABLE `artists` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL
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
(10, 'Twenty One Pilots'),
(11, 'Low'),
(12, 'Olivia Rodrigo'),
(13, 'Floating Points, Pharoah Sanders & The London Symphony Orchestra'),
(14, 'Royal Blood'),
(15, 'Steven Wilson');

-- --------------------------------------------------------

--
-- Table structure for table `leaderboard`
--

CREATE TABLE `leaderboard` (
  `id` int(11) NOT NULL,
  `album_id` int(11) NOT NULL,
  `score` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `leaderboard`
--

INSERT INTO `leaderboard` (`id`, `album_id`, `score`) VALUES
(1, 1, 0),
(2, 2, 0),
(3, 3, 0),
(4, 4, 0),
(5, 5, 0),
(6, 6, 0),
(7, 7, 0),
(8, 8, 0),
(9, 9, 0),
(10, 10, 0),
(11, 21, 0),
(12, 22, 0),
(13, 23, 0),
(14, 24, 0),
(15, 25, 0);

-- --------------------------------------------------------

--
-- Table structure for table `lists`
--

CREATE TABLE `lists` (
  `id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE `ratings` (
  `id` int(11) NOT NULL,
  `album_position` int(11) NOT NULL,
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
-- Indexes for table `leaderboard`
--
ALTER TABLE `leaderboard`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `album_id` (`album_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `artists`
--
ALTER TABLE `artists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `leaderboard`
--
ALTER TABLE `leaderboard`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `lists`
--
ALTER TABLE `lists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

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
-- Constraints for table `leaderboard`
--
ALTER TABLE `leaderboard`
  ADD CONSTRAINT `leaderboard_album_id` FOREIGN KEY (`album_id`) REFERENCES `albums` (`id`);

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

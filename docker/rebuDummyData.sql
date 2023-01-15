-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: mysqldb
-- Generation Time: Jan 15, 2023 at 11:08 AM
-- Server version: 8.0.30
-- PHP Version: 8.0.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rebu`
--

-- --------------------------------------------------------

--
-- Table structure for table `anonymous_users`
--

CREATE TABLE `anonymous_users` (
  `id` int UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(127) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `anonymous_users`
--

INSERT INTO `anonymous_users` (`id`, `email`, `first_name`, `last_name`) VALUES
(1, 'lukasdownes@gmail.com', 'l', 'd'),
(5, 'lukas.downes@student.odisee.be', 'lukas', 'downes');

-- --------------------------------------------------------

--
-- Table structure for table `drivers`
--

CREATE TABLE `drivers` (
  `id` int UNSIGNED NOT NULL,
  `btw_nr` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL,
  `number_plate` varchar(7) COLLATE utf8mb4_unicode_ci NOT NULL,
  `birth_date` timestamp NOT NULL,
  `car_seats` int UNSIGNED NOT NULL,
  `car_model` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `car_brand` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `actief` tinyint NOT NULL DEFAULT '0',
  `gender` enum('M','F','X') COLLATE utf8mb4_unicode_ci NOT NULL,
  `profile_pic` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `drivers`
--

INSERT INTO `drivers` (`id`, `btw_nr`, `number_plate`, `birth_date`, `car_seats`, `car_model`, `car_brand`, `actief`, `gender`, `profile_pic`) VALUES
(1, 'BE13548547', '1dle884', '1996-03-13 00:00:00', 3, 'm', 'bm', 0, 'F', '1.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int UNSIGNED NOT NULL,
  `rating` decimal(2,1) NOT NULL,
  `review` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `trip_id` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `trips`
--

CREATE TABLE `trips` (
  `id` int UNSIGNED NOT NULL,
  `start_nr` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_street` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_city` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stop_nr` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stop_street` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stop_city` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_time` datetime NOT NULL,
  `stop_time` datetime DEFAULT NULL,
  `costumer_id` int UNSIGNED NOT NULL,
  `driver_id` int UNSIGNED DEFAULT NULL,
  `price` decimal(5,2) UNSIGNED NOT NULL,
  `status` enum('pending','claimed','cancelled','started','finished') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `trips`
--

INSERT INTO `trips` (`id`, `start_nr`, `start_street`, `start_city`, `stop_nr`, `stop_street`, `stop_city`, `start_time`, `stop_time`, `costumer_id`, `driver_id`, `price`, `status`) VALUES
(1, '46', 'elfjulistraat', '9000 Gent', '46', 'henri vieuxtempsstraat', '1070 Anderlecht', '2023-02-14 14:52:00', NULL, 1, 1, '0.00', 'finished'),
(2, '452', 'regrqe', 'qgfeZFzf', '46', 'sqfq', 'sqfde', '2023-01-12 16:05:00', NULL, 1, 1, '0.00', 'finished'),
(3, '46', 'dfEF', 'qsdf', '66', 'sqf', 'qdsfsqdfq', '2023-01-12 15:41:00', NULL, 1, 1, '0.00', 'finished'),
(4, '16', 'henri vieuxtempsstraat', '1070 Anderlecht', '46', 'elfjulistraat', '9000 Gent', '2023-01-11 20:50:00', NULL, 1, 1, '0.00', 'finished'),
(5, '16', 'henri vieuxtempsstraat', 'Anderlecht', '46', 'elfjulistraat', 'Gent', '2024-02-12 21:00:00', NULL, 1, 1, '0.00', 'finished'),
(6, '46', 'henri vieuxtempsstraat', 'Gent', '46', 'elfjulistraat', 'Anderlecht', '2024-03-12 00:04:00', NULL, 1, 1, '0.00', 'cancelled'),
(7, '452', 'elfjulistraat', 'gent', '61', 'henri vieuxtempsstraat', 'downes', '2024-02-10 00:05:00', NULL, 1, 1, '0.00', 'finished'),
(8, '16', 'lukas', 'gent', '16', 'Downes', 'Gent', '2024-02-12 00:17:00', NULL, 5, 1, '0.00', 'finished'),
(9, '123', 'Azerty', 'Qwerty', '123', 'Qwerty', 'Azerty', '2027-03-12 00:18:00', NULL, 5, 1, '0.00', 'cancelled'),
(10, '16', 'henri vieuxtempsstraat', 'Anderlecht', '46', 'elfjulistraat', 'Gent', '2024-02-13 17:05:00', NULL, 5, 1, '109.52', 'finished'),
(11, '116', 'Meir', 'Antwerpen', '46', 'elfjulistraat', 'Gent', '2024-02-13 19:25:00', NULL, 5, 1, '237.35', 'finished'),
(12, '16', 'henri vieuxtempsstraat', 'Anderlecht', '46', 'elfjulistraat', 'Gent', '2024-02-13 20:15:00', NULL, 5, 1, '0.00', 'finished'),
(13, '33', 'Nieuwstraat', 'Brussel', '16', 'henri vieuxtempsstraat', 'Anderlecht', '2024-02-13 20:19:00', NULL, 5, NULL, '20.29', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int UNSIGNED NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `verified` tinyint NOT NULL DEFAULT '0',
  `verification_code` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `password`, `verified`, `verification_code`) VALUES
(1, '$argon2id$v=19$m=65536,t=4,p=1$clZkcFVacFVBRnZqb0pRbA$/3QBfdkYwdlTJfzP5nlW15bcc3SpWBQLEG9bx+/MPbQ', 1, 'MIZWPJTDVFBORYKG'),
(5, '$argon2id$v=19$m=65536,t=4,p=1$bDJPRC52MDJRN3lQbUZkSg$XYNUDZylw2QeXZ08h8BJZIEPo2BPwcWzjUQsuSp64n0', 1, 'EZQBCHGVFJWTYRLN');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `anonymous_users`
--
ALTER TABLE `anonymous_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD UNIQUE KEY `email_UNIQUE` (`email`);

--
-- Indexes for table `drivers`
--
ALTER TABLE `drivers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idd_UNIQUE` (`id`),
  ADD UNIQUE KEY `btw_nr_UNIQUE` (`btw_nr`),
  ADD UNIQUE KEY `nummerplaat_UNIQUE` (`number_plate`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD KEY `trip_idx` (`trip_id`);

--
-- Indexes for table `trips`
--
ALTER TABLE `trips`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idt_UNIQUE` (`id`),
  ADD KEY `costumer_idx` (`costumer_id`),
  ADD KEY `driver_idx` (`driver_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `anonymous_users`
--
ALTER TABLE `anonymous_users`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `trips`
--
ALTER TABLE `trips`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `drivers`
--
ALTER TABLE `drivers`
  ADD CONSTRAINT `driver` FOREIGN KEY (`id`) REFERENCES `users` (`id`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `trip` FOREIGN KEY (`trip_id`) REFERENCES `trips` (`id`);

--
-- Constraints for table `trips`
--
ALTER TABLE `trips`
  ADD CONSTRAINT `costumer` FOREIGN KEY (`costumer_id`) REFERENCES `anonymous_users` (`id`),
  ADD CONSTRAINT `driverreview` FOREIGN KEY (`driver_id`) REFERENCES `drivers` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `userid` FOREIGN KEY (`id`) REFERENCES `anonymous_users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 24, 2025 at 12:24 PM
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
-- Database: `indian_health`
--

-- --------------------------------------------------------

--
-- Table structure for table `quiz_results`
--

CREATE TABLE `quiz_results` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `vata_count` int(11) NOT NULL,
  `pitta_count` int(11) NOT NULL,
  `kapha_count` int(11) NOT NULL,
  `dominant` varchar(50) NOT NULL,
  `answers_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`answers_json`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `quiz_results`
--

INSERT INTO `quiz_results` (`id`, `user_id`, `vata_count`, `pitta_count`, `kapha_count`, `dominant`, `answers_json`) VALUES
(1, 1, 3, 5, 4, 'Pitta', '{\"q0\":\"Pitta\",\"q1\":\"Vata\",\"q2\":\"Vata\",\"q3\":\"Pitta\",\"q4\":\"Pitta\",\"q5\":\"Kapha\",\"q6\":\"Pitta\",\"q7\":\"Pitta\",\"q8\":\"Kapha\",\"q9\":\"Kapha\",\"q10\":\"Kapha\",\"q11\":\"Vata\"}'),
(2, 2, 12, 0, 0, 'Vata', '{\"q0\":\"Vata\",\"q1\":\"Vata\",\"q2\":\"Vata\",\"q3\":\"Vata\",\"q4\":\"Vata\",\"q5\":\"Vata\",\"q6\":\"Vata\",\"q7\":\"Vata\",\"q8\":\"Vata\",\"q9\":\"Vata\",\"q10\":\"Vata\",\"q11\":\"Vata\"}'),
(3, 1, 3, 4, 5, 'Kapha', '{\"q0\":\"Kapha\",\"q1\":\"Vata\",\"q2\":\"Kapha\",\"q3\":\"Vata\",\"q4\":\"Kapha\",\"q5\":\"Pitta\",\"q6\":\"Pitta\",\"q7\":\"Kapha\",\"q8\":\"Vata\",\"q9\":\"Kapha\",\"q10\":\"Pitta\",\"q11\":\"Pitta\"}'),
(4, 3, 0, 1, 11, 'Kapha', '{\"q0\":\"Pitta\",\"q1\":\"Kapha\",\"q2\":\"Kapha\",\"q3\":\"Kapha\",\"q4\":\"Kapha\",\"q5\":\"Kapha\",\"q6\":\"Kapha\",\"q7\":\"Kapha\",\"q8\":\"Kapha\",\"q9\":\"Kapha\",\"q10\":\"Kapha\",\"q11\":\"Kapha\"}');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(80) NOT NULL,
  `email` varchar(120) NOT NULL,
  `password_hash` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password_hash`) VALUES
(1, 'Pinkesh', '22amtics184@gmail.com', '$2y$10$uH57D1DUPvg4490/hvGHE.0wyNiDUxOEFwUzDVHEUacaUIAoDzx4.'),
(2, 'Pinkesh', '123@gmail.com', '$2y$10$Q0xYJ1MCHMCRz0zXD4TjBO3kOWyA1p035opQcY///KUkLpcieCYna'),
(3, 'hello', '1@gmail.com', '$2y$10$86m8VY3vGvlRly0GJgfJN.rVbIMkGEPbJ8yWtGTd04ZzsIhvbJLEe');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `quiz_results`
--
ALTER TABLE `quiz_results`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `quiz_results`
--
ALTER TABLE `quiz_results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `quiz_results`
--
ALTER TABLE `quiz_results`
  ADD CONSTRAINT `quiz_results_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

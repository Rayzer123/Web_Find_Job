-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 08, 2025 at 12:01 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `findjob`
--

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` int(11) NOT NULL,
  `employer_id` int(11) DEFAULT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL,
  `salary` varchar(100) DEFAULT NULL,
  `requirements` text DEFAULT NULL,
  `benefits` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `job_type` varchar(255) DEFAULT NULL,
  `industry` text DEFAULT NULL,
  `deadline` date DEFAULT NULL,
  `display_duration` int(11) NOT NULL DEFAULT 30,
  `years_experience` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `employer_id`, `company_name`, `title`, `description`, `location`, `salary`, `requirements`, `benefits`, `created_at`, `updated_at`, `job_type`, `industry`, `deadline`, `display_duration`, `years_experience`) VALUES
(1, 1, NULL, 'IT', 'ABC XYZ', NULL, NULL, NULL, NULL, '2025-06-01 21:46:30', '2025-06-01 21:46:30', NULL, NULL, NULL, 30, 0),
(2, 3, NULL, 'IT', 'ABC', 'Hà nội', '12.000.000', NULL, NULL, '2025-06-02 15:12:45', '2025-06-02 15:12:45', 'Toàn thời gian', NULL, NULL, 30, 0),
(4, 4, NULL, 'COde', 'Lập trình', 'Quy Nhơn', '100000000000', NULL, NULL, '2025-07-08 16:31:15', '2025-07-08 16:31:15', 'Thực tập', NULL, NULL, 30, 2),
(6, 4, 'TH Trua Miu', 'Lập Trình Viên', 'Biết bấm máy tính', 'Quy Nhơn', '100000000000', NULL, NULL, '2025-07-08 16:47:40', '2025-07-08 16:47:40', 'Thực tập', NULL, NULL, 3, 3),
(7, 4, 'T', 'Lập Trình Viên', 'aaaaaaaaaaaaaaaaa', 'Quy Nhơn', '10000000000', NULL, NULL, '2025-07-08 16:51:16', '2025-07-08 16:51:16', 'Bán thời gian', NULL, NULL, 30, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employer_id` (`employer_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `jobs`
--
ALTER TABLE `jobs`
  ADD CONSTRAINT `jobs_ibfk_1` FOREIGN KEY (`employer_id`) REFERENCES `employers` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

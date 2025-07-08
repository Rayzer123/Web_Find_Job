-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th7 08, 2025 lúc 12:09 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `findjob`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `applications`
--

CREATE TABLE `applications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `job_id` int(11) DEFAULT NULL,
  `resume_id` int(11) DEFAULT NULL,
  `cover_letter_id` int(11) DEFAULT NULL,
  `status` varchar(30) DEFAULT 'pending',
  `applied_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cover_letters`
--

CREATE TABLE `cover_letters` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `content_path` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `employers`
--

CREATE TABLE `employers` (
  `id` int(11) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `website` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `company_intro` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `employers`
--

INSERT INTO `employers` (`id`, `company_name`, `email`, `password`, `logo`, `phone`, `address`, `website`, `description`, `created_at`, `company_intro`) VALUES
(1, 'Rayzer', 'pducdddd@gmail.com', '$2y$10$aAtLBXj6fa0j8UYwiRmgKuJnyz22w92WOjvEvHWS3gZD7DcGYdr3.', NULL, NULL, NULL, NULL, NULL, '2025-06-01 20:07:26', NULL),
(3, 'Phạm Hữu Đức', 'duc4651050062@st.qnu.edu.vn', '$2y$10$EeiZ5cxAw4pdTlbQ1A3gfuXt7LlNlFAz83GQz1pLbJnnOQ9Sv4FQW', 'logo_3_1751964768.jpg', NULL, NULL, NULL, NULL, '2025-06-02 14:00:30', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `jobs`
--

CREATE TABLE `jobs` (
  `id` int(11) NOT NULL,
  `employer_id` int(11) DEFAULT NULL,
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
  `deadline` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `jobs`
--

INSERT INTO `jobs` (`id`, `employer_id`, `title`, `description`, `location`, `salary`, `requirements`, `benefits`, `created_at`, `updated_at`, `job_type`, `industry`, `deadline`) VALUES
(1, 1, 'IT', 'ABC XYZ', NULL, NULL, NULL, NULL, '2025-06-01 21:46:30', '2025-06-01 21:46:30', NULL, NULL, NULL),
(2, 3, 'IT', 'ABC', 'Hà nội', '12.000.000', NULL, NULL, '2025-06-02 15:12:45', '2025-06-02 15:12:45', 'Toàn thời gian', NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `jobs_notifications`
--

CREATE TABLE `jobs_notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `keyword` varchar(255) DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `jobs_saved`
--

CREATE TABLE `jobs_saved` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `job_id` int(11) DEFAULT NULL,
  `saved_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `resumes`
--

CREATE TABLE `resumes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `users` varchar(70) NOT NULL,
  `profession` varchar(100) NOT NULL,
  `experience` varchar(100) NOT NULL,
  `education` varchar(100) NOT NULL,
  `language` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `resumes`
--

INSERT INTO `resumes` (`id`, `user_id`, `users`, `profession`, `experience`, `education`, `language`) VALUES
(4, 2, 'Pham Huu Duc', 'Kế Toán', '1 năm', 'Đại học', 'N1'),
(6, 2, 'Pham Huu Duc', 'ABC', '2 năm', 'Đại học', 'N1');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `marital_status` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `avatar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `phone`, `gender`, `dob`, `marital_status`, `address`, `created_at`, `avatar`) VALUES
(2, 'Pham Huu Duc', 'duc4651050062@st.qnu.edu.vn', '$2y$10$EDflrQ0eVxI3BHTeNlG97ONGVq/KSQUu/dSIKckonf8LapFaVxe6u', '0332609031', '', '0000-00-00', 'Độc thân', 'w3rqf5hyw', '2025-06-01 20:49:16', 'avatar_2_1748836938.png'),
(3, 'Jazz', 'teariam@gmail.com', '$2y$10$qhYB6HK8/bMpNC/vxfa2QOMLgwmqGPqfScp9BFp8na6wLPeX2E.06', NULL, NULL, NULL, NULL, NULL, '2025-06-01 21:49:22', NULL);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `job_id` (`job_id`);

--
-- Chỉ mục cho bảng `cover_letters`
--
ALTER TABLE `cover_letters`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `employers`
--
ALTER TABLE `employers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Chỉ mục cho bảng `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employer_id` (`employer_id`);

--
-- Chỉ mục cho bảng `jobs_notifications`
--
ALTER TABLE `jobs_notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `jobs_saved`
--
ALTER TABLE `jobs_saved`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `job_id` (`job_id`);

--
-- Chỉ mục cho bảng `resumes`
--
ALTER TABLE `resumes`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `applications`
--
ALTER TABLE `applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `cover_letters`
--
ALTER TABLE `cover_letters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `employers`
--
ALTER TABLE `employers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `jobs_notifications`
--
ALTER TABLE `jobs_notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `jobs_saved`
--
ALTER TABLE `jobs_saved`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `resumes`
--
ALTER TABLE `resumes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `applications`
--
ALTER TABLE `applications`
  ADD CONSTRAINT `applications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `applications_ibfk_2` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`);

--
-- Các ràng buộc cho bảng `cover_letters`
--
ALTER TABLE `cover_letters`
  ADD CONSTRAINT `cover_letters_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Các ràng buộc cho bảng `jobs`
--
ALTER TABLE `jobs`
  ADD CONSTRAINT `jobs_ibfk_1` FOREIGN KEY (`employer_id`) REFERENCES `employers` (`id`);

--
-- Các ràng buộc cho bảng `jobs_notifications`
--
ALTER TABLE `jobs_notifications`
  ADD CONSTRAINT `jobs_notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Các ràng buộc cho bảng `jobs_saved`
--
ALTER TABLE `jobs_saved`
  ADD CONSTRAINT `jobs_saved_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `jobs_saved_ibfk_2` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

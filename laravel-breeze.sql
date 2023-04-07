-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 06, 2023 at 03:40 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laravel-breeze`
--

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lessons`
--

CREATE TABLE `lessons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `startDateTime` datetime NOT NULL,
  `teacherId` bigint(20) UNSIGNED NOT NULL,
  `studentId` bigint(20) UNSIGNED NOT NULL,
  `lessonType` enum('guitar','bass','piano','vocal') NOT NULL,
  `status` enum('available','booked','cancelled') NOT NULL DEFAULT 'available',
  `paymentConfirmation` tinyint(1) NOT NULL DEFAULT 0,
  `bookingTS` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `cancelTS` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lessons`
--

INSERT INTO `lessons` (`id`, `startDateTime`, `teacherId`, `studentId`, `lessonType`, `status`, `paymentConfirmation`, `bookingTS`, `cancelTS`) VALUES
(1, '2023-04-01 09:00:00', 1, 3, 'bass', 'booked', 1, '2023-04-05 01:03:14', NULL),
(4, '2023-04-03 11:00:00', 1, 3, 'bass', 'booked', 1, '2023-04-05 02:23:17', NULL),
(5, '2023-04-06 13:00:00', 1, 3, 'guitar', 'booked', 1, '2023-04-05 02:30:04', NULL),
(6, '2023-04-07 14:00:00', 1, 3, 'guitar', 'booked', 1, '2023-04-05 02:34:31', NULL),
(7, '2023-04-04 13:00:00', 1, 3, 'guitar', 'booked', 1, '2023-04-05 02:37:38', NULL),
(8, '2023-04-06 16:00:00', 1, 3, 'guitar', 'booked', 1, '2023-04-05 02:41:06', NULL),
(10, '2023-04-12 16:00:00', 4, 3, 'guitar', 'booked', 1, '2023-04-05 02:53:13', NULL),
(11, '2023-04-04 12:00:00', 4, 3, 'vocal', 'booked', 1, '2023-04-05 11:24:10', NULL),
(12, '2023-04-06 14:00:00', 4, 3, 'vocal', 'booked', 1, '2023-04-05 11:29:43', NULL),
(13, '2023-04-04 09:00:00', 4, 3, 'guitar', 'booked', 1, '2023-04-05 11:30:55', NULL),
(14, '2023-04-05 11:00:00', 1, 3, 'vocal', 'booked', 1, '2023-04-05 16:43:24', NULL),
(15, '2023-04-07 16:00:00', 4, 3, 'vocal', 'booked', 1, '2023-04-05 22:59:30', NULL),
(16, '2023-04-14 12:00:00', 4, 3, 'vocal', 'booked', 1, '2023-04-06 01:28:51', NULL),
(17, '2023-04-17 15:00:00', 5, 3, 'guitar', 'booked', 0, '2023-04-05 12:10:39', NULL),
(18, '2023-04-26 10:00:00', 5, 3, 'guitar', 'booked', 0, '2023-04-05 12:11:07', NULL),
(19, '2023-04-07 12:00:00', 1, 3, 'piano', 'cancelled', 0, '2023-04-06 00:26:08', NULL),
(20, '2023-04-07 17:00:00', 1, 3, 'vocal', 'cancelled', 0, '2023-04-06 01:01:41', '2023-04-06 05:01:41'),
(21, '2023-04-20 12:00:00', 1, 3, 'piano', 'booked', 0, '2023-04-06 04:49:35', NULL),
(22, '2023-04-20 11:00:00', 5, 3, 'bass', 'booked', 0, '2023-04-06 04:49:52', NULL),
(23, '2023-04-17 14:00:00', 1, 3, 'guitar', 'booked', 0, '2023-04-06 04:50:02', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(10) UNSIGNED NOT NULL,
  `thread_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `body` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `thread_id`, `user_id`, `body`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 3, 'Hello', '2023-04-04 09:54:46', '2023-04-04 09:54:46', NULL),
(2, 1, 1, 'How can I help you?', '2023-04-04 09:58:47', '2023-04-04 09:58:47', NULL),
(3, 2, 3, 'Lesson tomorrow?', '2023-04-05 18:15:28', '2023-04-05 18:15:28', NULL),
(4, 2, 1, 'Hello Emmylou, yes you have 2 guitar lessons tomorrow, April 6, 2023 at 1pm and 4pm. See you then!', '2023-04-06 02:11:49', '2023-04-06 02:11:49', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(7, '2023_03_30_160904_create_lessons_table', 2),
(8, '2014_10_28_175635_create_threads_table', 3),
(9, '2014_10_28_175710_create_messages_table', 3),
(10, '2014_10_28_180224_create_participants_table', 3),
(11, '2014_11_03_154831_add_soft_deletes_to_participants_table', 3),
(12, '2014_12_04_124531_add_softdeletes_to_threads_table', 3),
(13, '2017_03_30_152742_add_soft_deletes_to_messages_table', 3),
(14, '2023_04_06_010031_add_cancelts_column_to_lessons_table', 4);

-- --------------------------------------------------------

--
-- Table structure for table `participants`
--

CREATE TABLE `participants` (
  `id` int(10) UNSIGNED NOT NULL,
  `thread_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `last_read` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `participants`
--

INSERT INTO `participants` (`id`, `thread_id`, `user_id`, `last_read`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 3, '2023-04-06 05:26:19', '2023-04-04 09:54:46', '2023-04-06 05:26:19', NULL),
(2, 1, 1, '2023-04-06 02:10:26', '2023-04-04 09:54:46', '2023-04-06 02:10:26', NULL),
(3, 2, 3, '2023-04-05 18:15:28', '2023-04-05 18:15:28', '2023-04-05 18:15:28', NULL),
(4, 2, 1, '2023-04-06 02:11:49', '2023-04-05 18:15:28', '2023-04-06 02:11:49', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `threads`
--

CREATE TABLE `threads` (
  `id` int(10) UNSIGNED NOT NULL,
  `subject` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `threads`
--

INSERT INTO `threads` (`id`, `subject`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Upcoming Lesson', '2023-04-04 09:54:46', '2023-04-04 09:58:47', NULL),
(2, 'Hello', '2023-04-05 18:15:28', '2023-04-06 02:11:49', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `phoneno` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `role` enum('student','teacher','admin') NOT NULL DEFAULT 'student',
  `teacher_price_per_hour` decimal(10,2) DEFAULT NULL,
  `teacher_profile_info` mediumtext DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `phoneno`, `address`, `role`, `teacher_price_per_hour`, `teacher_profile_info`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Huey', 'Lewis', '6134624331', '34 Vine St', 'teacher', '50.00', NULL, 'h.lewis@thenews.com', '2023-04-04 09:57:50', '$2y$10$zQkDM4ovfBLc6bbLvUuHFeAQfAEBXxBnt3J7OScEc3xvFjKNInGPW', 'nC9pJm2Kn9Qh3cMerRSnXiOay0sN5oVGVFfIA1uNQAPNl4wOFikNlgPHAI2i', '2023-03-30 18:26:30', '2023-04-06 03:05:01'),
(2, 'Joe', 'Strummer', '1234567890', '666 Road', 'student', NULL, NULL, 'joe@joestudent.ca', NULL, '$2y$10$9pX8uFc81ZQ13Ps6Fx0DdeaRn5qZ3sZvPULhC/dbHAC804a7nnYF6', NULL, '2023-03-30 18:28:52', '2023-03-30 19:23:33'),
(3, 'Emmylou', 'Harris', '9876543210', '123 Laurel Canyon Blvd.', 'student', NULL, NULL, 'emmylou@aol.com', '2023-04-01 02:07:53', '$2y$10$YmyM6n5pxWu123YbZTgiO.9Sy4ANHV/sZQkaQrwXiB6PL12IgeUrm', '35tgXkadOVVITlyRdoA6nvmOaI8MssppSMMstfgQMtzhfbgBr60drkpjWIDF', '2023-03-31 03:45:35', '2023-04-05 01:14:11'),
(4, 'Gene', 'Clark', '6666661234', '70 Oak Road', 'teacher', '50.00', NULL, 'gene@aol.com', '2023-04-02 04:10:44', '$2y$10$pGtfl3WvGDD4.MetfCFWaulQtTZjyuxKv3VAwxr8UrMfpMu6sWsGG', NULL, '2023-04-02 04:10:16', '2023-04-02 04:10:44'),
(5, 'Joni', 'Mitchell', '6665554444', '21 Brock St', 'teacher', '45.00', NULL, 'j.mitchell@gmail.com', '2023-04-05 12:07:58', '$2y$10$QEeVXjl5qttjWwKX2Lzis.KwYsks5krxXWO.9R8321fQVzaLLPMTS', NULL, '2023-04-05 12:07:32', '2023-04-05 12:07:58');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `lessons`
--
ALTER TABLE `lessons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lessons_teacherid_foreign` (`teacherId`),
  ADD KEY `lessons_studentid_foreign` (`studentId`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `participants`
--
ALTER TABLE `participants`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `threads`
--
ALTER TABLE `threads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lessons`
--
ALTER TABLE `lessons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `participants`
--
ALTER TABLE `participants`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `threads`
--
ALTER TABLE `threads`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `lessons`
--
ALTER TABLE `lessons`
  ADD CONSTRAINT `lessons_studentid_foreign` FOREIGN KEY (`studentId`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `lessons_teacherid_foreign` FOREIGN KEY (`teacherId`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

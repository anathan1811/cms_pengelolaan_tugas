-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 30, 2025 at 01:02 AM
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
-- Database: `cms_pengelolaan_tugas`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `color` varchar(7) DEFAULT '#6c757d',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `color`, `created_at`) VALUES
(1, 'Tugas Kuliah', '#007bff', '2025-01-27 12:19:10'),
(2, 'Praktikum', '#28a745', '2025-01-27 12:19:10'),
(3, 'Proyek', '#dc3545', '2025-01-27 12:19:10'),
(4, 'Lainnya', '#6c757d', '2025-01-27 12:19:10');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `status` enum('pending','in_progress','completed') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `priority` enum('low','medium','high') DEFAULT 'medium',
  `due_date` date DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL,
  `assigned_to` varchar(100) DEFAULT NULL,
  `completion_percentage` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `title`, `description`, `status`, `created_at`, `updated_at`, `priority`, `due_date`, `category`, `assigned_to`, `completion_percentage`) VALUES
(5, 'as', 'ds', 'pending', '2025-01-27 12:24:13', '2025-01-28 14:52:56', 'low', '2025-01-27', '4', 'ZXFC', 71),
(8, 'statistika', 'dedline tanggal 3 februari ', 'pending', '2025-01-29 07:19:41', '2025-01-29 07:19:41', 'medium', '2025-02-03', '3', 'danu', 0),
(9, 'qwe', '2', 'in_progress', '2025-01-29 07:24:34', '2025-01-29 07:28:03', 'medium', NULL, '4', 'kim', 0),
(10, 'eer', 'wer', 'completed', '2025-01-29 08:02:08', '2025-01-29 08:02:08', 'medium', NULL, '4', 'wer', 0),
(11, 'wer34567qwe', 'wershdhjrt', 'pending', '2025-01-29 08:03:01', '2025-01-29 15:44:31', 'high', NULL, '1', 'ZXFC', 35),
(12, 'weretrwt', 'rtyrtuyty', 'in_progress', '2025-01-29 08:03:25', '2025-01-29 08:03:25', 'low', NULL, '1', 'wer', 76),
(13, '12', 'wefweer123', 'in_progress', '2025-01-29 15:50:46', '2025-01-29 16:01:39', 'low', NULL, '3', '', 0),
(14, 'wrerewr', 'wrwerewr', 'completed', '2025-01-29 16:02:00', '2025-01-29 16:02:00', 'high', NULL, '3', 'wrer', 0),
(15, 'tyty', 'werwer123123', 'pending', '2025-01-29 16:02:21', '2025-01-29 16:02:21', 'medium', NULL, '2', '', 0),
(16, 'ngelatih vokal', 'tambahan materi baru', 'pending', '2025-01-29 23:07:09', '2025-01-29 23:07:09', 'medium', '2025-02-14', '4', 'murid&#39;&#39;', 55);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `password`, `created_at`) VALUES
(4, 'ilham', 'ilhamadian346@gmail.com', '$2y$10$xsjlgGCrLrn8897W7cMfze5rtqsnI4S0nyjpK.03nEBjDQUtrVGqu', '2025-01-29 03:04:13'),
(5, 'TRUMP', 'trump@gmail.com', '$2y$10$zmMbguN5QXjG4HfpS6aEw.Khr97op0Gc2ojcH1VMNxQVz1GYpq/rq', '2025-01-29 06:56:58'),
(6, 'danu', 'danusaurus@gmail.com', '$2y$10$aGskYCCqARAIzpu6QhOsX.pAay05.pwPdpFJVbALCib8sE59vH8dy', '2025-01-29 07:18:01'),
(7, 'faizzzzz', 'chilmifaiz@gmail.com', '$2y$10$FM4NaEIk83/csrGIkNpAUef5RVryLH8hNEplGLQJ0wBYlBM0Pc0RS', '2025-01-29 23:03:42'),
(8, 'Rozaki Setiya Yuwana', 'ozakzy23@gmail.com', '$2y$10$IQ0BrycqAa9tAo7UnMu4ReERZbKuRAsnV8h837A1wJpkhXa2FGuBu', '2025-01-29 23:18:11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 01, 2026 at 04:56 AM
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
-- Database: `pharmacy_system_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_name` varchar(30) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `action` varchar(30) DEFAULT NULL,
  `module` varchar(30) DEFAULT NULL,
  `description` text NOT NULL,
  `old_data` text DEFAULT NULL,
  `new_data` text DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `user_id`, `user_name`, `created_at`, `updated_at`, `action`, `module`, `description`, `old_data`, `new_data`, `ip_address`, `user_agent`) VALUES
(1, 7, 'Angeline', '2026-04-01 06:54:03', '2026-04-01 06:54:03', 'logout', 'Auth', 'User logged out', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(2, 23, 'Emely', '2026-04-01 06:54:08', '2026-04-01 06:54:08', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(3, 23, 'Emely', '2026-04-01 06:54:57', '2026-04-01 06:54:57', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(4, 23, 'Emely', '2026-04-01 07:04:44', '2026-04-01 07:04:44', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(5, 23, 'Emely', '2026-04-01 07:05:25', '2026-04-01 07:05:25', 'logout', 'Auth', 'User logged out', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(6, 7, 'Angeline', '2026-04-01 07:05:33', '2026-04-01 07:05:33', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(7, 7, 'Angeline', '2026-04-01 17:39:33', '2026-04-01 17:39:33', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(8, 7, 'Angeline', '2026-04-01 17:44:53', '2026-04-01 17:44:53', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(9, 7, 'Angeline', '2026-04-01 17:58:31', '2026-04-01 17:58:31', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(10, 7, 'Angeline', '2026-04-01 18:12:38', '2026-04-01 18:12:38', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(11, 7, 'Angeline', '2026-04-01 19:05:41', '2026-04-01 19:05:41', 'create', 'Inventory', 'Added stock to queue: Ambroxol (50 boxes)', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(12, 7, 'Angeline', '2026-04-01 20:35:23', '2026-04-01 20:35:23', 'update', 'Inventory', 'Updated product: Ambroxol → Ambroxol', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(13, 7, 'Angeline', '2026-04-01 20:35:24', '2026-04-01 20:35:24', 'update', 'Inventory', 'Updated batch for Ambroxol: 50 → 50 boxes', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(14, 7, 'Angeline', '2026-04-01 20:35:48', '2026-04-01 20:35:48', 'update', 'Inventory', 'Updated product: Ambroxol → Ambroxol', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(15, 7, 'Angeline', '2026-04-01 20:35:48', '2026-04-01 20:35:48', 'update', 'Inventory', 'Updated batch for Ambroxol: 50 → 50 boxes', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(16, 7, 'Angeline', '2026-04-01 20:36:04', '2026-04-01 20:36:04', 'update', 'Inventory', 'Updated product: Ambroxol → Ambroxol', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(17, 7, 'Angeline', '2026-04-01 20:36:05', '2026-04-01 20:36:05', 'update', 'Inventory', 'Updated batch for Ambroxol: 14 → 14 boxes', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(18, 7, 'Angeline', '2026-04-01 21:04:37', '2026-04-01 21:04:37', 'delete', 'Inventory', 'Deleted batch from product: Ambroxol', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(19, 24, 'Conan', '2026-04-02 02:04:05', '2026-04-02 02:04:05', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(20, 24, 'Conan', '2026-04-02 03:58:50', '2026-04-02 03:58:50', 'update', 'User & Access', 'Updated user: Angeline', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(21, 24, 'Conan', '2026-04-02 03:58:51', '2026-04-02 03:58:51', 'update', 'User & Access', 'Updated user: Angeline', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(22, 24, 'Conan', '2026-04-02 03:58:52', '2026-04-02 03:58:52', 'update', 'User & Access', 'Updated user: Angeline', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(23, 24, 'Conan', '2026-04-02 03:59:05', '2026-04-02 03:59:05', 'update', 'User & Access', 'Updated user: Angeline', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(24, 24, 'Conan', '2026-04-02 03:59:14', '2026-04-02 03:59:14', 'update', 'User & Access', 'Updated user: Angeline', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(25, 24, 'Conan', '2026-04-02 04:06:09', '2026-04-02 04:06:09', 'update', 'User & Access', 'Updated user: Emely', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(26, 24, 'Conan', '2026-04-02 04:06:23', '2026-04-02 04:06:23', 'update', 'User & Access', 'Updated user: Emely', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(27, 24, 'Conan', '2026-04-02 04:13:30', '2026-04-02 04:13:30', 'update', 'User & Access', 'Updated user: Emely Urgelles', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(28, 24, 'Conan', '2026-04-02 04:13:38', '2026-04-02 04:13:38', 'update', 'User & Access', 'Updated user: Emely Urgelles', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(29, 24, 'Conan', '2026-04-02 04:14:08', '2026-04-02 04:14:08', 'update', 'User & Access', 'Updated user: Emely Urgelles', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(30, 24, 'Conan', '2026-04-02 04:14:16', '2026-04-02 04:14:16', 'update', 'User & Access', 'Updated user: Emely Urgelles', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(31, 24, 'Conan', '2026-04-02 05:26:24', '2026-04-02 05:26:24', 'update', 'Inventory', 'Updated product: Ambroxol → Ambroxol', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(32, 24, 'Conan', '2026-04-02 05:26:25', '2026-04-02 05:26:25', 'update', 'Inventory', 'Updated batch for Ambroxol: 14 → 14 boxes', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(33, 24, 'Conan', '2026-04-02 05:27:03', '2026-04-02 05:27:03', 'create', 'Inventory', 'Added stock to queue: Ambroxol (14 boxes)', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(34, 24, 'Conan', '2026-04-02 13:59:45', '2026-04-02 13:59:45', 'create', 'POS', 'Processed sale: Invoice #INV-1775138385-1414 | Total: ₱200.00', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(35, 24, 'Conan', '2026-04-02 06:23:38', '2026-04-02 06:23:38', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(36, 24, 'Conan', '2026-04-02 06:53:25', '2026-04-02 06:53:25', 'logout', 'Auth', 'User logged out', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(37, 24, 'Conan', '2026-04-02 06:54:23', '2026-04-02 06:54:23', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(38, 24, 'Conan', '2026-04-02 06:55:07', '2026-04-02 06:55:07', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36'),
(39, 24, 'Conan', '2026-04-02 06:55:25', '2026-04-02 06:55:25', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(40, 23, 'Emely Urgelles', '2026-04-02 07:04:02', '2026-04-02 07:04:02', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(41, 23, 'Emely Urgelles', '2026-04-02 07:34:37', '2026-04-02 07:34:37', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(42, 23, 'Emely Urgelles', '2026-04-02 07:55:55', '2026-04-02 07:55:55', 'logout', 'Auth', 'User logged out', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(43, 14, 'Rogelyn', '2026-04-02 07:56:33', '2026-04-02 07:56:33', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(44, 24, 'Conan', '2026-04-02 07:57:08', '2026-04-02 07:57:08', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(45, 24, 'Conan', '2026-04-02 07:58:16', '2026-04-02 07:58:16', 'logout', 'Auth', 'User logged out', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(46, 14, 'Rogelyn', '2026-04-02 07:58:53', '2026-04-02 07:58:53', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(47, 24, 'Conan', '2026-04-02 17:48:12', '2026-04-02 17:48:12', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(48, 14, 'Rogelyn', '2026-04-02 17:50:29', '2026-04-02 17:50:29', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(49, 23, 'Emely Urgelles', '2026-04-02 17:52:04', '2026-04-02 17:52:04', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36'),
(50, 14, 'Rogelyn', '2026-04-03 03:45:48', '2026-04-03 03:45:48', 'create', 'POS', 'Processed sale: Invoice #INV-20260403-0911 | Total: ₱75.00', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(51, 23, 'Emely Urgelles', '2026-04-03 03:50:02', '2026-04-03 03:50:02', 'create', 'POS', 'Processed sale: Invoice #INV-20260403-3468 | Total: ₱126.00', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36'),
(52, 14, 'Rogelyn', '2026-04-03 04:03:53', '2026-04-03 04:03:53', 'create', 'POS', 'Processed sale: Invoice #INV-20260403-4901 | Total: ₱18.14', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(53, 14, 'Rogelyn', '2026-04-02 20:35:13', '2026-04-02 20:35:13', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(54, 14, 'Rogelyn', '2026-04-03 06:22:42', '2026-04-03 06:22:42', 'create', 'POS', 'Processed sale: Invoice #INV-20260403-7073 | Total: ₱17.01', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(55, 14, 'Rogelyn', '2026-04-03 06:26:15', '2026-04-03 06:26:15', 'create', 'POS', 'Processed sale: Invoice #INV-20260403-5623 | Total: ₱24.00', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(56, 14, 'Rogelyn', '2026-04-03 06:36:30', '2026-04-03 06:36:30', 'create', 'POS', 'Processed sale: Invoice #INV-20260403-8529 | Total: ₱25.00', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(57, 14, 'Rogelyn', '2026-04-03 06:39:24', '2026-04-03 06:39:24', 'create', 'POS', 'Processed sale: Invoice #INV-20260403-0923 | Total: ₱37.00', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(58, 14, 'Rogelyn', '2026-04-03 06:43:05', '2026-04-03 06:43:05', 'create', 'POS', 'Processed sale: Invoice #INV-20260403-3677 | Total: ₱36.00', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(59, 14, 'Rogelyn', '2026-04-03 06:43:35', '2026-04-03 06:43:35', 'create', 'POS', 'Processed sale: Invoice #INV-20260403-5308 | Total: ₱50.00', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(60, 14, 'Rogelyn', '2026-04-03 06:51:44', '2026-04-03 06:51:44', 'create', 'POS', 'Processed sale: Invoice #INV-20260403-9193 | Total: ₱72.00', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(61, 14, 'Rogelyn', '2026-04-03 06:53:21', '2026-04-03 06:53:21', 'create', 'POS', 'Processed sale: Invoice #INV-20260403-2214 | Total: ₱24.00', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(62, 14, 'Rogelyn', '2026-04-03 08:05:38', '2026-04-03 08:05:38', 'create', 'POS', 'Processed sale: Invoice #INV-20260403-6543 | Total: ₱24.00', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(63, 14, 'Rogelyn', '2026-04-03 08:08:54', '2026-04-03 08:08:54', 'create', 'POS', 'Processed sale: Invoice #INV-20260403-9052 | Total: ₱28.80', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(64, 14, 'Rogelyn', '2026-04-03 02:08:10', '2026-04-03 02:08:10', 'update', 'Profile', 'Updated profile photo', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(65, 14, 'Rogelyn', '2026-04-03 02:23:57', '2026-04-03 02:23:57', 'update', 'Profile', 'Updated profile photo', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(66, 14, 'Rogelyn', '2026-04-03 02:24:02', '2026-04-03 02:24:02', 'update', 'Profile', 'Updated profile information', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(67, 14, 'Rogelyn', '2026-04-03 02:24:16', '2026-04-03 02:24:16', 'update', 'Profile', 'Updated profile photo', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(68, 14, 'Rogelyn', '2026-04-03 02:24:19', '2026-04-03 02:24:19', 'update', 'Profile', 'Updated profile information', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(69, 14, 'Rogelyn', '2026-04-03 02:56:41', '2026-04-03 02:56:41', 'update', 'Profile', 'Updated profile information', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(70, 14, 'Rogelyn', '2026-04-03 02:56:54', '2026-04-03 02:56:54', 'update', 'Profile', 'Updated profile information', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(71, 14, 'Rogelyn', '2026-04-03 02:58:02', '2026-04-03 02:58:02', 'update', 'Profile', 'Updated profile information', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(72, 14, 'Rogelyn', '2026-04-03 03:00:02', '2026-04-03 03:00:02', 'update', 'Profile', 'Updated profile information', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(73, 14, 'Rogelyn', '2026-04-03 03:00:13', '2026-04-03 03:00:13', 'update', 'Profile', 'Updated profile information', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(74, 14, 'Rogelyn', '2026-04-03 12:15:34', '2026-04-03 12:15:34', 'create', 'POS', 'Processed sale: Invoice #INV-20260403-5058 | Total: ₱24.00', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(75, 14, 'Rogelyn', '2026-04-03 12:15:49', '2026-04-03 12:15:49', 'create', 'POS', 'Processed sale: Invoice #INV-20260403-3190 | Total: ₱37.61', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(76, 14, 'Rogelyn', '2026-04-03 04:49:10', '2026-04-03 04:49:10', 'logout', 'Auth', 'User logged out', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(77, 23, 'Emely Urgelles', '2026-04-03 04:49:18', '2026-04-03 04:49:18', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(78, 23, 'Emely Urgelles', '2026-04-03 05:37:45', '2026-04-03 05:37:45', 'logout', 'Auth', 'User logged out', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(79, 14, 'Rogelyn', '2026-04-03 05:38:02', '2026-04-03 05:38:02', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(80, 23, 'Emely Urgelles', '2026-04-03 05:58:10', '2026-04-03 05:58:10', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(81, 23, 'Emely Urgelles', '2026-04-03 06:08:32', '2026-04-03 06:08:32', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(82, 14, 'Rogelyn', '2026-04-03 06:38:37', '2026-04-03 06:38:37', 'logout', 'Auth', 'User logged out', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(83, 24, 'Conan', '2026-04-03 06:38:43', '2026-04-03 06:38:43', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(84, 23, 'Emely Urgelles', '2026-04-03 08:58:55', '2026-04-03 08:58:55', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(85, 24, 'Conan', '2026-04-03 08:59:20', '2026-04-03 08:59:20', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(86, 23, 'Emely Urgelles', '2026-04-03 09:27:18', '2026-04-03 09:27:18', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(87, 23, 'Emely Urgelles', '2026-04-03 09:27:40', '2026-04-03 09:27:40', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(88, 23, 'Emely Urgelles', '2026-04-03 10:09:48', '2026-04-03 10:09:48', 'update', 'Profile', 'Updated profile information', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(89, 24, 'Conan', '2026-04-03 16:10:24', '2026-04-03 16:10:24', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(90, 23, 'Emely Urgelles', '2026-04-03 16:11:20', '2026-04-03 16:11:20', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(91, 24, 'Conan', '2026-04-03 16:12:37', '2026-04-03 16:12:37', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(92, 14, 'Rogelyn', '2026-04-03 16:52:08', '2026-04-03 16:52:08', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36'),
(93, 14, 'Rogelyn', '2026-04-04 01:00:49', '2026-04-04 01:00:49', 'create', 'POS', 'Processed sale: Invoice #INV-20260404-7484 | Total: ₱15.00', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36'),
(94, 23, 'Emely Urgelles', '2026-04-03 17:20:33', '2026-04-03 17:20:33', 'update', 'Inventory', 'Updated product: Ambroxol → Ambroxol', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(95, 23, 'Emely Urgelles', '2026-04-03 17:20:34', '2026-04-03 17:20:34', 'update', 'Inventory', 'Updated batch for Ambroxol: 10 → 10 boxes', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(96, 24, 'Conan', '2026-04-03 17:54:17', '2026-04-03 17:54:17', 'update', 'Inventory', 'Updated product: Paracetamol → Paracetamol', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(97, 24, 'Conan', '2026-04-03 17:54:17', '2026-04-03 17:54:17', 'update', 'Inventory', 'Updated batch for Paracetamol: 10 → 10 boxes', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(98, 24, 'Conan', '2026-04-03 17:54:35', '2026-04-03 17:54:35', 'update', 'Inventory', 'Updated product: Neozep → Neozep', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(99, 24, 'Conan', '2026-04-03 17:54:35', '2026-04-03 17:54:35', 'update', 'Inventory', 'Updated batch for Neozep: 10 → 10 boxes', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(100, 24, 'Conan', '2026-04-03 17:54:48', '2026-04-03 17:54:48', 'update', 'Inventory', 'Updated product: Solmux → Solmux', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(101, 24, 'Conan', '2026-04-03 17:54:49', '2026-04-03 17:54:49', 'update', 'Inventory', 'Updated batch for Solmux: 10 → 10 boxes', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(102, 24, 'Conan', '2026-04-03 17:55:01', '2026-04-03 17:55:01', 'update', 'Inventory', 'Updated product: Amoxicillin → Amoxicillin', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(103, 24, 'Conan', '2026-04-03 17:55:01', '2026-04-03 17:55:01', 'update', 'Inventory', 'Updated batch for Amoxicillin: 10 → 10 boxes', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(104, 14, 'Rogelyn', '2026-04-04 02:16:06', '2026-04-04 02:16:06', 'create', 'POS', 'Processed sale: Invoice #INV-20260404-8515 | Total: ₱300.00', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36'),
(105, 14, 'Rogelyn', '2026-04-04 02:16:14', '2026-04-04 02:16:14', 'create', 'POS', 'Processed sale: Invoice #INV-20260404-1220 | Total: ₱22.68', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36'),
(106, 14, 'Rogelyn', '2026-04-04 02:16:22', '2026-04-04 02:16:22', 'create', 'POS', 'Processed sale: Invoice #INV-20260404-0489 | Total: ₱80.00', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36'),
(107, 14, 'Rogelyn', '2026-04-04 02:16:31', '2026-04-04 02:16:31', 'create', 'POS', 'Processed sale: Invoice #INV-20260404-8765 | Total: ₱40.00', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36'),
(108, 14, 'Rogelyn', '2026-04-04 02:33:28', '2026-04-04 02:33:28', 'create', 'POS', 'Processed sale: Invoice #INV-20260404-0086 | Total: ₱30.00', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36'),
(109, 14, 'Rogelyn', '2026-04-04 02:36:50', '2026-04-04 02:36:50', 'create', 'POS', 'Processed sale: Invoice #INV-20260404-3510 | Total: ₱25.00', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36'),
(110, 24, 'Conan', '2026-04-03 20:46:58', '2026-04-03 20:46:58', 'delete', 'User & Access', 'Deleted user: cashier', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(111, 24, 'Conan', '2026-04-03 20:47:03', '2026-04-03 20:47:03', 'delete', 'User & Access', 'Deleted user: pharmacy', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(112, 24, 'Conan', '2026-04-03 20:47:07', '2026-04-03 20:47:07', 'delete', 'User & Access', 'Deleted user: pharmacist', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(113, 24, 'Conan', '2026-04-03 20:47:13', '2026-04-03 20:47:13', 'delete', 'User & Access', 'Deleted user: admin', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(114, 14, 'Rogelyn', '2026-04-03 21:24:10', '2026-04-03 21:24:10', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(115, 14, 'Rogelyn', '2026-04-03 21:24:20', '2026-04-03 21:24:20', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(116, 24, 'Conan', '2026-04-03 21:27:24', '2026-04-03 21:27:24', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(117, 24, 'Conan', '2026-04-03 22:01:37', '2026-04-03 22:01:37', 'update', 'Settings', 'Updated system settings', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(118, 24, 'Conan', '2026-04-04 06:02:35', '2026-04-04 06:02:35', 'create', 'POS', 'Processed sale: Invoice #INV-20260404-4433 | Total: ₱20.00', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(119, 24, 'Conan', '2026-04-03 22:03:58', '2026-04-03 22:03:58', 'update', 'Settings', 'Updated system settings', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(120, 24, 'Conan', '2026-04-03 22:12:26', '2026-04-03 22:12:26', 'update', 'Settings', 'Updated system settings', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(121, 24, 'Conan', '2026-04-03 22:29:26', '2026-04-03 22:29:26', 'update', 'Settings', 'Updated system settings', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(122, 24, 'Conan', '2026-04-03 22:35:24', '2026-04-03 22:35:24', 'update', 'Settings', 'Updated system settings', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(123, 24, 'Conan', '2026-04-03 23:16:28', '2026-04-03 23:16:28', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(124, 23, 'Emely Urgelles', '2026-04-03 23:17:09', '2026-04-03 23:17:09', 'logout', 'Auth', 'User logged out', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(125, 24, 'Conan', '2026-04-03 23:17:14', '2026-04-03 23:17:14', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(126, 23, 'Emely Urgelles', '2026-04-03 23:24:06', '2026-04-03 23:24:06', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(127, 24, 'Conan', '2026-04-04 00:53:45', '2026-04-04 00:53:45', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(128, 24, 'Conan', '2026-04-04 00:53:51', '2026-04-04 00:53:51', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(129, 24, 'Conan', '2026-04-04 00:53:56', '2026-04-04 00:53:56', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(130, 24, 'Conan', '2026-04-04 00:54:01', '2026-04-04 00:54:01', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(131, 24, 'Conan', '2026-04-04 00:54:04', '2026-04-04 00:54:04', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(132, 24, 'Conan', '2026-04-04 00:54:30', '2026-04-04 00:54:30', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(133, 24, 'Conan', '2026-04-04 00:54:35', '2026-04-04 00:54:35', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(134, 24, 'Conan', '2026-04-04 00:55:49', '2026-04-04 00:55:49', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(135, 24, 'Conan', '2026-04-04 04:47:11', '2026-04-04 04:47:11', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(136, 14, 'Rogelyn', '2026-04-04 04:53:12', '2026-04-04 04:53:12', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36'),
(137, 23, 'Emely Urgelles', '2026-04-04 04:54:01', '2026-04-04 04:54:01', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(138, 24, 'Conan', '2026-04-04 05:51:35', '2026-04-04 05:51:35', 'update', 'Settings', 'Cleared system cache', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(139, 24, 'Conan', '2026-04-04 05:57:59', '2026-04-04 05:57:59', 'create', 'Settings', 'Created database backup', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(140, 24, 'Conan', '2026-04-04 06:45:00', '2026-04-04 06:45:00', 'logout', 'Auth', 'User logged out', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(141, 23, 'Emely Urgelles', '2026-04-04 06:45:12', '2026-04-04 06:45:12', 'logout', 'Auth', 'User logged out', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(142, 24, 'Conan', '2026-04-04 06:45:57', '2026-04-04 06:45:57', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(143, 23, 'Emely Urgelles', '2026-04-04 06:46:54', '2026-04-04 06:46:54', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(144, 14, 'Rogelyn', '2026-04-04 07:27:00', '2026-04-04 07:27:00', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36'),
(145, 24, 'Conan', '2026-04-04 07:40:22', '2026-04-04 07:40:22', 'create', 'User & Access', 'Created new user: wowulam', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(146, 24, 'Conan', '2026-04-04 07:40:38', '2026-04-04 07:40:38', 'update', 'User & Access', 'Updated user: wowulam', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(147, 29, 'wowulam', '2026-04-04 07:41:25', '2026-04-04 07:41:25', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36'),
(148, 29, 'wowulam', '2026-04-04 07:43:29', '2026-04-04 07:43:29', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36'),
(149, 24, 'Conan', '2026-04-04 09:27:07', '2026-04-04 09:27:07', 'update', 'Settings', 'Updated system settings', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(150, 24, 'Conan', '2026-04-04 09:28:56', '2026-04-04 09:28:56', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(151, 24, 'Conan', '2026-04-04 10:12:22', '2026-04-04 10:12:22', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(152, 24, 'Conan', '2026-04-04 18:21:14', '2026-04-04 18:21:14', 'create', 'POS', 'Processed sale: Invoice #INV-20260405-8259 | Total: ₱30.00', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(153, 24, 'Conan', '2026-04-04 10:32:01', '2026-04-04 10:32:01', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(154, 24, 'Conan', '2026-04-04 10:32:51', '2026-04-04 10:32:51', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(155, 14, 'Rogelyn', '2026-04-04 10:41:38', '2026-04-04 10:41:38', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36'),
(156, 24, 'Conan', '2026-04-04 11:21:04', '2026-04-04 11:21:04', 'logout', 'Auth', 'User logged out', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(157, 24, 'Conan', '2026-04-04 11:21:09', '2026-04-04 11:21:09', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(158, 24, 'Conan', '2026-04-04 11:54:20', '2026-04-04 11:54:20', 'update', 'Settings', 'Updated pharmacy information: Pharmacy Name: from lala Pharmacy to lrir Pharmacy', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(159, 24, 'Conan', '2026-04-04 12:00:09', '2026-04-04 12:00:09', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(160, 24, 'Conan', '2026-04-04 12:01:13', '2026-04-04 12:01:13', 'update', 'Profile', 'Updated profile information', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(161, 24, 'Conan', '2026-04-04 12:06:14', '2026-04-04 12:06:14', 'update', 'Settings', 'Updated pharmacy information: Pharmacy Logo updated', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(162, 24, 'Conan', '2026-04-04 12:36:18', '2026-04-04 12:36:18', 'update', 'Profile', 'Updated profile information', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(163, 24, 'Conan', '2026-04-04 13:00:03', '2026-04-04 13:00:03', 'update', 'Profile', 'Updated profile information', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(164, 29, 'wowulam', '2026-04-04 13:35:11', '2026-04-04 13:35:11', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(165, 14, 'Rogelyn', '2026-04-04 13:47:42', '2026-04-04 13:47:42', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36'),
(166, 14, 'Rogelyn', '2026-04-04 18:43:22', '2026-04-04 18:43:22', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36'),
(167, 24, 'Conan', '2026-04-04 18:50:41', '2026-04-04 18:50:41', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(168, 24, 'Conan', '2026-04-04 18:53:08', '2026-04-04 18:53:08', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(169, 24, 'Conan', '2026-04-04 18:53:56', '2026-04-04 18:53:56', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(170, 24, 'Conan', '2026-04-04 18:57:07', '2026-04-04 18:57:07', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(171, 24, 'Conan', '2026-04-04 18:58:18', '2026-04-04 18:58:18', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(172, 24, 'Conan', '2026-04-04 18:59:44', '2026-04-04 18:59:44', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(173, 24, 'Conan', '2026-04-04 19:19:54', '2026-04-04 19:19:54', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(174, 24, 'Conan', '2026-04-04 19:25:52', '2026-04-04 19:25:52', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(175, 24, 'Conan', '2026-04-04 19:30:13', '2026-04-04 19:30:13', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(176, 24, 'Conan', '2026-04-04 19:32:17', '2026-04-04 19:32:17', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(177, 24, 'Conan', '2026-04-04 19:35:11', '2026-04-04 19:35:11', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(178, 24, 'Conan', '2026-04-04 19:38:28', '2026-04-04 19:38:28', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(179, 24, 'Conan', '2026-04-04 19:39:09', '2026-04-04 19:39:09', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(180, 14, 'Rogelyn', '2026-04-04 19:43:48', '2026-04-04 19:43:48', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36'),
(181, 24, 'Conan', '2026-04-04 19:44:25', '2026-04-04 19:44:25', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(182, 23, 'Emely Urgelles', '2026-04-04 21:04:00', '2026-04-04 21:04:00', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(183, 24, 'Conan', '2026-04-04 21:21:24', '2026-04-04 21:21:24', 'logout', 'Auth', 'User logged out', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(184, 14, 'Rogelyn', '2026-04-04 21:21:35', '2026-04-04 21:21:35', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(185, 14, 'Rogelyn', '2026-04-04 22:52:33', '2026-04-04 22:52:33', 'update', 'Inventory', 'Updated product: Paracetamol (ID: 80) - Changes: No changes', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(186, 24, 'Conan', '2026-04-04 22:55:16', '2026-04-04 22:55:16', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36');
INSERT INTO `activity_logs` (`id`, `user_id`, `user_name`, `created_at`, `updated_at`, `action`, `module`, `description`, `old_data`, `new_data`, `ip_address`, `user_agent`) VALUES
(187, 29, 'wowulam', '2026-04-04 22:57:00', '2026-04-04 22:57:00', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36'),
(188, 24, 'Conan', '2026-04-04 23:24:46', '2026-04-04 23:24:46', 'update', 'Settings', 'Updated pharmacy information: Pharmacy Name: from lrir Pharmacy to lala store; Pharmacy Logo updated', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36'),
(189, 23, 'Emely Urgelles', '2026-04-05 02:03:02', '2026-04-05 02:03:02', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(190, 23, 'Emely Urgelles', '2026-04-05 02:14:26', '2026-04-05 02:14:26', 'create', 'Inventory', 'Created new product: Biogesic with 3 boxes', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(191, 14, 'Rogelyn', '2026-04-05 03:05:34', '2026-04-05 03:05:34', 'logout', 'Auth', 'User logged out', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(192, 7, 'Angeline', '2026-04-05 03:09:44', '2026-04-05 03:09:44', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(193, 24, 'Conan', '2026-04-05 03:16:36', '2026-04-05 03:16:36', 'logout', 'Auth', 'User logged out', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36'),
(194, 7, 'Angeline', '2026-04-05 03:16:49', '2026-04-05 03:16:49', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(195, 7, 'Angeline', '2026-04-05 03:31:07', '2026-04-05 03:31:07', 'create', 'Inventory', 'Created new product: Paracetamol with 10 boxes', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(196, 7, 'Angeline', '2026-04-05 03:31:14', '2026-04-05 03:31:14', 'create', 'Stock Queue', 'Added to QUEUE: 10 boxes of Paracetamol (Current stock: 1000 pieces remaining)', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(197, 7, 'Angeline', '2026-04-05 03:31:56', '2026-04-05 03:31:56', 'delete', 'Inventory', 'Deleted batch from product: Paracetamol', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(198, 7, 'Angeline', '2026-04-05 03:32:11', '2026-04-05 03:32:11', 'delete', 'Inventory', 'Deleted batch from product: Paracetamol', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(199, 7, 'Angeline', '2026-04-05 03:33:09', '2026-04-05 03:33:09', 'update', 'Inventory', 'Updated product: Paracetamol (ID: 80) - Changes: No changes', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(200, 7, 'Angeline', '2026-04-05 03:33:26', '2026-04-05 03:33:26', 'update', 'Inventory', 'Updated product: Paracetamol (ID: 80) - Changes: No changes', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(201, 7, 'Angeline', '2026-04-05 03:34:05', '2026-04-05 03:34:05', 'update', 'Inventory', 'Updated product: Biogesic (ID: 94) - Changes: No changes', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(202, 7, 'Angeline', '2026-04-05 03:34:07', '2026-04-05 03:34:07', 'update', 'Inventory', 'Updated product: Biogesic (ID: 94) - Changes: No changes', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(203, 7, 'Angeline', '2026-04-05 05:57:34', '2026-04-05 05:57:34', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(204, 7, 'Angeline', '2026-04-05 06:01:34', '2026-04-05 06:01:34', 'create', 'Inventory', 'Created new product: Biogesic with 10 boxes', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(205, 7, 'Angeline', '2026-04-05 06:01:34', '2026-04-05 06:01:34', 'create', 'Stock Queue', 'Added to QUEUE: 10 boxes of Biogesic (Current stock: 1000 pieces remaining)', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(206, 7, 'Angeline', '2026-04-05 06:29:53', '2026-04-05 06:29:53', 'create', 'Inventory', 'Created new product: geline with 20 boxes', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(207, 7, 'Angeline', '2026-04-05 06:29:53', '2026-04-05 06:29:53', 'create', 'Stock Queue', 'Added to QUEUE: 20 boxes of geline (Current stock: 2000 pieces remaining)', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(208, 7, 'Angeline', '2026-04-05 06:52:28', '2026-04-05 06:52:28', 'delete', 'Inventory', 'Deleted batch from product: geline', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(209, 7, 'Angeline', '2026-04-05 06:52:54', '2026-04-05 06:52:54', 'create', 'Inventory', 'Created new product: geline with Batch 1 (20 boxes)', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(210, 7, 'Angeline', '2026-04-05 06:52:55', '2026-04-05 06:52:55', 'create', 'Stock Queue', 'Added to QUEUE as Batch 2: 20 boxes of geline', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(211, 7, 'Angeline', '2026-04-05 06:54:11', '2026-04-05 06:54:11', 'create', 'Inventory', 'Created new product: geline with Batch 1 (20 boxes)', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(212, 7, 'Angeline', '2026-04-05 06:54:12', '2026-04-05 06:54:12', 'create', 'Stock Queue', 'Added to QUEUE as Batch 2: 20 boxes of geline', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(213, 7, 'Angeline', '2026-04-05 06:54:30', '2026-04-05 06:54:30', 'delete', 'Inventory', 'Deleted batch from product: geline', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(214, 7, 'Angeline', '2026-04-05 06:54:36', '2026-04-05 06:54:36', 'delete', 'Inventory', 'Deleted batch from product: geline', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(215, 7, 'Angeline', '2026-04-05 07:09:33', '2026-04-05 07:09:33', 'update', 'Categories', 'Updated category: Antibiotics → Antibiotic', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(216, 7, 'Angeline', '2026-04-05 07:09:41', '2026-04-05 07:09:41', 'update', 'Categories', 'Updated category: Antibiotic → Antibiotics', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(217, 7, 'Angeline', '2026-04-05 07:11:44', '2026-04-05 07:11:44', 'update', 'Settings', 'Updated pharmacy information: Pharmacy Name: from lala store to AERMED; Email updated; Pharmacy Logo updated', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(218, 7, 'Angeline', '2026-04-05 07:17:22', '2026-04-05 07:17:22', 'update', 'Settings', 'Updated pharmacy information: Pharmacy Logo updated', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(219, 7, 'Angeline', '2026-04-05 07:18:45', '2026-04-05 07:18:45', 'update', 'Settings', 'Updated pharmacy information: Pharmacy Logo updated', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(220, 7, 'Angeline', '2026-04-05 07:19:31', '2026-04-05 07:19:31', 'update', 'Settings', 'Updated pharmacy information: Pharmacy Logo updated', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(221, 7, 'Angeline', '2026-04-05 17:12:35', '2026-04-05 17:12:35', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(222, 7, 'Angeline', '2026-04-05 17:22:05', '2026-04-05 17:22:05', 'logout', 'Auth', 'User logged out', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(223, 24, 'Conan', '2026-04-05 17:22:30', '2026-04-05 17:22:30', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36'),
(224, 14, 'Rogelyn', '2026-04-05 17:25:27', '2026-04-05 17:25:27', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(225, 23, 'Emely Urgelles', '2026-04-05 17:27:15', '2026-04-05 17:27:15', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(226, 14, 'Rogelyn', '2026-04-06 01:30:27', '2026-04-06 01:30:27', 'create', 'POS', 'Processed sale: Invoice #INV-20260406-8837 | Total: ₱18.14', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(227, 24, 'Conan', '2026-04-05 17:51:02', '2026-04-05 17:51:02', 'delete', 'Inventory', 'Deleted batch from product: geline', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36'),
(228, 24, 'Conan', '2026-04-05 17:51:35', '2026-04-05 17:51:35', 'delete', 'Inventory', 'Deleted batch from product: geline', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36'),
(229, 24, 'Conan', '2026-04-05 17:51:50', '2026-04-05 17:51:50', 'delete', 'Inventory', 'Deleted batch from product: awesome', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36'),
(230, 14, 'Rogelyn', '2026-04-05 18:06:58', '2026-04-05 18:06:58', 'logout', 'Auth', 'User logged out', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(231, 24, 'Conan', '2026-04-05 18:07:26', '2026-04-05 18:07:26', 'logout', 'Auth', 'User logged out', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36'),
(232, 24, 'Conan', '2026-04-05 18:07:37', '2026-04-05 18:07:37', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36'),
(233, 24, 'Conan', '2026-04-05 18:23:08', '2026-04-05 18:23:08', 'create', 'User & Access', 'Created new user: lily', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36'),
(234, 24, 'Conan', '2026-04-05 18:23:34', '2026-04-05 18:23:34', 'delete', 'User & Access', 'Deleted user: lily', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36'),
(235, 14, 'Rogelyn', '2026-04-05 18:24:35', '2026-04-05 18:24:35', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(236, 24, 'Conan', '2026-04-05 18:43:35', '2026-04-05 18:43:35', 'logout', 'Auth', 'User logged out', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36'),
(237, 24, 'Conan', '2026-04-05 18:51:44', '2026-04-05 18:51:44', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36'),
(238, 24, 'Conan', '2026-04-05 18:53:46', '2026-04-05 18:53:46', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(239, 24, 'Conan', '2026-04-05 18:54:54', '2026-04-05 18:54:54', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(240, 24, 'Conan', '2026-04-06 02:56:48', '2026-04-06 02:56:48', 'create', 'POS', 'Processed sale: Invoice #INV-20260406-1499 | Total: ₱30.00', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(241, 24, 'Conan', '2026-04-05 18:59:50', '2026-04-05 18:59:50', 'create', 'User & Access', 'Created new user: cashier', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(242, 24, 'Conan', '2026-04-05 19:00:56', '2026-04-05 19:00:56', 'update', 'Settings', 'Updated pharmacy information: Pharmacy Name: from AERMED to lala', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(243, 24, 'Conan', '2026-04-05 19:02:04', '2026-04-05 19:02:04', 'logout', 'Auth', 'User logged out', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(244, 32, 'cashier', '2026-04-05 19:02:18', '2026-04-05 19:02:18', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(245, 32, 'cashier', '2026-04-05 19:05:00', '2026-04-05 19:05:00', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(246, 32, 'cashier', '2026-04-05 19:06:11', '2026-04-05 19:06:11', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(247, 32, 'cashier', '2026-04-06 03:08:14', '2026-04-06 03:08:14', 'create', 'POS', 'Processed sale: Invoice #INV-20260406-5547 | Total: ₱30.00', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(248, 32, 'cashier', '2026-04-05 19:09:13', '2026-04-05 19:09:13', 'logout', 'Auth', 'User logged out', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(249, 23, 'Emely Urgelles', '2026-04-05 19:09:35', '2026-04-05 19:09:35', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(250, 24, 'Conan', '2026-04-05 19:32:35', '2026-04-05 19:32:35', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(251, 24, 'Conan', '2026-04-05 19:33:36', '2026-04-05 19:33:36', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(252, 24, 'Conan', '2026-04-05 19:35:55', '2026-04-05 19:35:55', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36'),
(253, 24, 'Conan', '2026-04-05 19:43:02', '2026-04-05 19:43:02', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36'),
(254, 24, 'Conan', '2026-04-05 19:47:53', '2026-04-05 19:47:53', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36'),
(255, 24, 'Conan', '2026-04-05 19:48:50', '2026-04-05 19:48:50', 'delete', 'Inventory', 'Deleted batch from product: Biogesic', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36'),
(256, 24, 'Conan', '2026-04-05 19:49:01', '2026-04-05 19:49:01', 'delete', 'Inventory', 'Deleted batch from product: Biogesic', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36'),
(257, 24, 'Conan', '2026-04-05 19:50:02', '2026-04-05 19:50:02', 'create', 'Inventory', 'Created new product: Biogesic with Batch 1 (1 boxes)', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36'),
(258, 24, 'Conan', '2026-04-05 19:50:05', '2026-04-05 19:50:05', 'create', 'Stock Queue', 'Added to QUEUE as Batch 2: 1 boxes of Biogesic', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36'),
(259, 24, 'Conan', '2026-04-05 19:53:45', '2026-04-05 19:53:45', 'delete', 'Inventory', 'Deleted batch from product: Paracetamol', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36'),
(260, 24, 'Conan', '2026-04-05 19:53:50', '2026-04-05 19:53:50', 'delete', 'Inventory', 'Deleted batch from product: Neozep', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36'),
(261, 24, 'Conan', '2026-04-05 19:53:56', '2026-04-05 19:53:56', 'delete', 'Inventory', 'Deleted batch from product: Solmux', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36'),
(262, 24, 'Conan', '2026-04-05 19:54:22', '2026-04-05 19:54:22', 'delete', 'Inventory', 'Deleted batch from product: Amoxicillin', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36'),
(263, 24, 'Conan', '2026-04-05 19:54:28', '2026-04-05 19:54:28', 'delete', 'Inventory', 'Deleted batch from product: pick up', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36'),
(264, 24, 'Conan', '2026-04-05 19:54:32', '2026-04-05 19:54:32', 'delete', 'Inventory', 'Deleted batch from product: Ambroxol', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36'),
(265, 24, 'Conan', '2026-04-05 19:54:37', '2026-04-05 19:54:37', 'delete', 'Inventory', 'Deleted batch from product: Ambroxol', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36'),
(266, 24, 'Conan', '2026-04-05 19:54:41', '2026-04-05 19:54:41', 'delete', 'Inventory', 'Deleted batch from product: Biogesic', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36'),
(267, 24, 'Conan', '2026-04-05 19:54:45', '2026-04-05 19:54:45', 'delete', 'Inventory', 'Deleted batch from product: Biogesic', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36'),
(268, 24, 'Conan', '2026-04-05 19:56:26', '2026-04-05 19:56:26', 'create', 'Inventory', 'Created new product: Biogesic with Batch 1 (1000 boxes)', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36'),
(269, 24, 'Conan', '2026-04-05 19:56:27', '2026-04-05 19:56:27', 'create', 'Stock Queue', 'Added to QUEUE as Batch 2: 1000 boxes of Biogesic', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36'),
(270, 24, 'Conan', '2026-04-05 19:58:19', '2026-04-05 19:58:19', 'create', 'Stock Queue', 'Added to QUEUE as Batch 2: 2000 boxes of Biogesic', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36'),
(271, 24, 'Conan', '2026-04-05 19:58:21', '2026-04-05 19:58:21', 'create', 'Stock Queue', 'Added to QUEUE as Batch 2: 2000 boxes of Biogesic', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36'),
(272, 24, 'Conan', '2026-04-05 20:03:02', '2026-04-05 20:03:02', 'create', 'Inventory', 'Created new product: Biogesic with Batch 1 (200 boxes)', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(273, 24, 'Conan', '2026-04-05 20:03:04', '2026-04-05 20:03:04', 'create', 'Stock Queue', 'Added to QUEUE as Batch 2: 200 boxes of Biogesic', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(274, 24, 'Conan', '2026-04-05 20:03:23', '2026-04-05 20:03:23', 'delete', 'Inventory', 'Deleted batch from product: Biogesic', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(275, 24, 'Conan', '2026-04-05 20:03:58', '2026-04-05 20:03:58', 'create', 'Inventory', 'Created new product: Ambroxol with Batch 1 (1 boxes)', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(276, 24, 'Conan', '2026-04-05 20:04:01', '2026-04-05 20:04:01', 'create', 'Stock Queue', 'Added to QUEUE as Batch 2: 1 boxes of Ambroxol', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(277, 24, 'Conan', '2026-04-05 20:04:41', '2026-04-05 20:04:41', 'create', 'Stock Queue', 'Added to QUEUE as Batch 2: 1111 boxes of Ambroxol', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(278, 24, 'Conan', '2026-04-05 20:04:43', '2026-04-05 20:04:43', 'create', 'Stock Queue', 'Added to QUEUE as Batch 2: 1111 boxes of Ambroxol', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(279, 24, 'Conan', '2026-04-05 20:50:39', '2026-04-05 20:50:39', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(280, 24, 'Conan', '2026-04-05 20:53:22', '2026-04-05 20:53:22', 'delete', 'Inventory', 'Deleted batch from product: Biogesic', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36'),
(281, 24, 'Conan', '2026-04-05 20:53:29', '2026-04-05 20:53:29', 'delete', 'Inventory', 'Deleted batch from product: Biogesic', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36'),
(282, 24, 'Conan', '2026-04-05 20:53:34', '2026-04-05 20:53:34', 'delete', 'Inventory', 'Deleted batch from product: Ambroxol', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36'),
(283, 24, 'Conan', '2026-04-05 20:53:40', '2026-04-05 20:53:40', 'delete', 'Inventory', 'Deleted batch from product: Ambroxol', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36'),
(284, 24, 'Conan', '2026-04-05 20:53:45', '2026-04-05 20:53:45', 'delete', 'Inventory', 'Deleted batch from product: Ambroxol', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36'),
(285, 24, 'Conan', '2026-04-05 20:54:14', '2026-04-05 20:54:14', 'create', 'Inventory', 'Created new product: Biogesic with Batch 1 (123 boxes)', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36'),
(286, 24, 'Conan', '2026-04-05 20:54:14', '2026-04-05 20:54:14', 'create', 'Stock Queue', 'Added to QUEUE as Batch 2: 123 boxes of Biogesic', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36'),
(287, 24, 'Conan', '2026-04-05 20:58:35', '2026-04-05 20:58:35', 'delete', 'Inventory', 'Deleted batch from product: Biogesic', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(288, 24, 'Conan', '2026-04-05 20:59:03', '2026-04-05 20:59:03', 'create', 'Inventory', 'Created new product in OLD STOCK: Ambroxol with Batch 1 (1111 boxes)', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(289, 24, 'Conan', '2026-04-05 20:59:06', '2026-04-05 20:59:06', 'create', 'Stock Queue', 'Added to QUEUE as Batch 2: 1111 boxes of Ambroxol (Still have 13332 pieces in stock)', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(290, 24, 'Conan', '2026-04-05 21:08:07', '2026-04-05 21:08:07', 'delete', 'Inventory', 'Deleted batch from product: Ambroxol', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36'),
(291, 24, 'Conan', '2026-04-05 21:08:49', '2026-04-05 21:08:49', 'create', 'Inventory', 'Created new product in OLD STOCK: Biogesic with Batch 1 (1234 boxes)', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36'),
(292, 24, 'Conan', '2026-04-05 21:08:51', '2026-04-05 21:08:51', 'create', 'Stock Queue', 'Added to QUEUE as Batch 2: 1234 boxes of Biogesic (Still have 14808 pieces in stock)', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36'),
(293, 24, 'Conan', '2026-04-05 21:34:43', '2026-04-05 21:34:43', 'create', 'Inventory', 'Created new product in OLD STOCK: Paracetamol with Batch 1 (123 boxes)', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36'),
(294, 24, 'Conan', '2026-04-05 21:34:46', '2026-04-05 21:34:46', 'create', 'Stock Queue', 'Added to QUEUE as Batch 2: 123 boxes of Paracetamol (Still have 369 pieces in stock)', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36'),
(295, 24, 'Conan', '2026-04-05 21:49:44', '2026-04-05 21:49:44', 'create', 'Inventory', 'Created new product in OLD STOCK: neosep with Batch 1 (123 boxes)', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36'),
(296, 24, 'Conan', '2026-04-05 21:53:07', '2026-04-05 21:53:07', 'delete', 'Inventory', 'Deleted batch from product: Biogesic', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36'),
(297, 24, 'Conan', '2026-04-05 21:53:11', '2026-04-05 21:53:11', 'delete', 'Inventory', 'Deleted batch from product: Paracetamol', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36'),
(298, 24, 'Conan', '2026-04-05 21:53:15', '2026-04-05 21:53:15', 'delete', 'Inventory', 'Deleted batch from product: neosep', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36'),
(299, 24, 'Conan', '2026-04-05 21:53:27', '2026-04-05 21:53:27', 'delete', 'Inventory', 'Deleted batch from product: Paracetamol', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36'),
(300, 24, 'Conan', '2026-04-05 21:54:07', '2026-04-05 21:54:07', 'create', 'Inventory', 'Created new product in OLD STOCK: neosep with Batch 1 (12 boxes)', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36'),
(301, 24, 'Conan', '2026-04-05 22:16:09', '2026-04-05 22:16:09', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(302, 24, 'Conan', '2026-04-06 06:17:57', '2026-04-06 06:17:57', 'create', 'POS', 'Processed sale: Invoice #INV-20260406-0804 | Total: ₱6,775.00', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(303, 24, 'Conan', '2026-04-06 06:18:48', '2026-04-06 06:18:48', 'create', 'POS', 'Processed sale: Invoice #INV-20260406-2526 | Total: ₱47,425.00', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(304, 24, 'Conan', '2026-04-05 23:23:23', '2026-04-05 23:23:23', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36'),
(305, 24, 'Conan', '2026-04-05 23:24:17', '2026-04-05 23:24:17', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36'),
(306, 24, 'Conan', '2026-04-05 23:25:52', '2026-04-05 23:25:52', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(307, 24, 'Conan', '2026-04-05 23:28:27', '2026-04-05 23:28:27', 'create', 'Prescription', 'Created prescription #RX-2026-0001 for rogely', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36'),
(308, 24, 'Conan', '2026-04-05 23:28:29', '2026-04-05 23:28:29', 'create', 'Prescription', 'Created prescription #RX-2026-0002 for rogely', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36'),
(309, 24, 'Conan', '2026-04-05 23:29:46', '2026-04-05 23:29:46', 'delete', 'Prescription', 'Deleted prescription #RX-2026-0001', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36'),
(310, 24, 'Conan', '2026-04-26 21:49:02', '2026-04-26 21:49:02', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0'),
(311, 7, 'Angeline', '2026-04-26 21:52:21', '2026-04-26 21:52:21', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0'),
(312, 7, 'Angeline', '2026-04-26 22:14:29', '2026-04-26 22:14:29', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0'),
(313, 7, 'Angeline', '2026-04-27 08:19:54', '2026-04-27 08:19:54', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0'),
(314, 7, 'Angeline', '2026-04-27 08:21:47', '2026-04-27 08:21:47', 'update', 'Settings', 'Updated pharmacy information: Pharmacy Name: from lala to AERPharmacy; Email updated', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0'),
(315, 7, 'Angeline', '2026-04-28 02:47:30', '2026-04-28 02:47:30', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0'),
(316, 7, 'Angeline', '2026-04-28 03:05:58', '2026-04-28 03:05:58', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0'),
(317, 7, 'Angeline', '2026-04-28 03:07:37', '2026-04-28 03:07:37', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0'),
(318, 7, 'Angeline', '2026-04-28 04:42:13', '2026-04-28 04:42:13', 'create', 'Inventory', 'Created new product in OLD STOCK: Biogesic with Batch 1 (100 boxes)', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0'),
(319, 7, 'Angeline', '2026-04-28 04:52:15', '2026-04-28 04:52:15', 'create', 'Inventory', 'Created new product in OLD STOCK: Ascorbic Acid with Batch 1 (50 boxes)', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0'),
(320, 7, 'Angeline', '2026-04-28 05:11:57', '2026-04-28 05:11:57', 'create', 'Inventory', 'Created new product in OLD STOCK: Ascorbic Acid with Batch 1 (50 boxes)', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0'),
(321, 7, 'Angeline', '2026-04-28 13:25:52', '2026-04-28 13:25:52', 'create', 'POS', 'Processed sale: Invoice #INV-20260428-5781 | Total: ₱100.00', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0'),
(322, 7, 'Angeline', '2026-05-01 04:22:31', '2026-05-01 04:22:31', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0'),
(323, 23, 'Emely Urgelles', '2026-05-01 04:22:57', '2026-05-01 04:22:57', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0'),
(324, 7, 'Angeline', '2026-05-01 04:23:22', '2026-05-01 04:23:22', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0'),
(325, 7, 'Angeline', '2026-05-01 04:53:29', '2026-05-01 04:53:29', 'logout', 'Auth', 'User logged out', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0'),
(326, 14, 'Rogelyn', '2026-05-01 04:59:41', '2026-05-01 04:59:41', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0'),
(327, 14, 'Rogelyn', '2026-05-01 05:01:49', '2026-05-01 05:01:49', 'logout', 'Auth', 'User logged out', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0'),
(328, 7, 'Angeline', '2026-05-01 05:02:03', '2026-05-01 05:02:03', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0'),
(329, 7, 'Angeline', '2026-05-01 05:10:25', '2026-05-01 05:10:25', 'create', 'Inventory', 'Created new product in OLD STOCK: Biogesic with Batch 1 (50 boxes)', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0'),
(330, 7, 'Angeline', '2026-05-01 05:24:22', '2026-05-01 05:24:22', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0'),
(331, 7, 'Angeline', '2026-05-01 05:33:26', '2026-05-01 05:33:26', 'create', 'Inventory', 'Created new product in OLD STOCK: Biogesic with Batch 1 (90 boxes)', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0'),
(332, 7, 'Angeline', '2026-05-01 05:39:51', '2026-05-01 05:39:51', 'create', 'Stock Queue', 'Added to QUEUE as Batch 2: 90 boxes of Biogesic (Still have 8010 pieces in stock)', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0'),
(333, 7, 'Angeline', '2026-05-01 05:40:04', '2026-05-01 05:40:04', 'delete', 'Inventory', 'Deleted batch from product: Biogesic', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0'),
(334, 7, 'Angeline', '2026-05-01 05:40:12', '2026-05-01 05:40:12', 'delete', 'Inventory', 'Deleted batch from product: Biogesic', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0'),
(335, 7, 'Angeline', '2026-05-01 05:49:40', '2026-05-01 05:49:40', 'create', 'Inventory', 'Created new product in OLD STOCK: Biogesic with Batch 1 (45 boxes)', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0'),
(336, 7, 'Angeline', '2026-05-01 05:49:47', '2026-05-01 05:49:47', 'delete', 'Inventory', 'Deleted batch from product: Biogesic', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0'),
(337, 7, 'Angeline', '2026-05-03 23:22:33', '2026-05-03 23:22:33', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0'),
(338, 7, 'Angeline', '2026-05-03 23:23:46', '2026-05-03 23:23:46', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0'),
(339, 7, 'Angeline', '2026-05-03 23:27:32', '2026-05-03 23:27:32', 'create', 'Inventory', 'Created new product in OLD STOCK: Alaska with Batch 1 (10 boxes)', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0'),
(340, 7, 'Angeline', '2026-05-03 23:31:51', '2026-05-03 23:31:51', 'logout', 'Auth', 'User logged out', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0'),
(341, 7, 'Angeline', '2026-05-03 23:44:04', '2026-05-03 23:44:04', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0'),
(342, 7, 'Angeline', '2026-05-03 23:57:06', '2026-05-03 23:57:06', 'logout', 'Auth', 'User logged out', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0'),
(343, 7, 'Angeline', '2026-05-03 23:57:12', '2026-05-03 23:57:12', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0'),
(344, 7, 'Angeline', '2026-05-04 00:03:25', '2026-05-04 00:03:25', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0'),
(345, 7, 'Angeline', '2026-05-04 00:07:56', '2026-05-04 00:07:56', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0'),
(346, 7, 'Angeline', '2026-05-04 00:11:45', '2026-05-04 00:11:45', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0'),
(347, 7, 'Angeline', '2026-05-04 00:29:01', '2026-05-04 00:29:01', 'logout', 'Auth', 'User logged out', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0'),
(348, 14, 'Rogelyn', '2026-05-04 00:29:55', '2026-05-04 00:29:55', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0'),
(349, 23, 'Emely Urgelles', '2026-05-04 00:32:43', '2026-05-04 00:32:43', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0'),
(350, 24, 'Conan', '2026-05-04 00:34:18', '2026-05-04 00:34:18', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36'),
(351, 14, 'Rogelyn', '2026-05-04 09:14:13', '2026-05-04 09:14:13', 'create', 'POS', 'Processed sale: Invoice #INV-20260504-6448 | Total: ₱200.00', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0'),
(352, 14, 'Rogelyn', '2026-05-04 09:15:20', '2026-05-04 09:15:20', 'create', 'POS', 'Processed sale: Invoice #INV-20260504-7536 | Total: ₱25.00', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0'),
(353, 24, 'Conan', '2026-05-04 01:32:53', '2026-05-04 01:32:53', 'delete', 'User & Access', 'Deleted user: cashier', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36'),
(354, 24, 'Conan', '2026-05-04 01:33:00', '2026-05-04 01:33:00', 'delete', 'User & Access', 'Deleted user: wowulam', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36'),
(355, 14, 'Rogelyn', '2026-05-04 02:12:21', '2026-05-04 02:12:21', 'logout', 'Auth', 'User logged out', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0'),
(356, 23, 'Emely Urgelles', '2026-05-04 03:14:44', '2026-05-04 03:14:44', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0'),
(357, 23, 'Emely Urgelles', '2026-05-04 03:15:16', '2026-05-04 03:15:16', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0'),
(358, 23, 'Emely Urgelles', '2026-05-04 03:15:27', '2026-05-04 03:15:27', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0'),
(359, 14, 'Rogelyn', '2026-05-04 03:26:29', '2026-05-04 03:26:29', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0'),
(360, 14, 'Rogelyn', '2026-05-04 03:27:14', '2026-05-04 03:27:14', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0'),
(361, 14, 'Rogelyn', '2026-05-04 03:28:00', '2026-05-04 03:28:00', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0'),
(362, 14, 'Rogelyn', '2026-05-04 04:20:50', '2026-05-04 04:20:50', 'logout', 'Auth', 'User logged out', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0'),
(363, 14, 'Rogelyn', '2026-05-04 04:21:03', '2026-05-04 04:21:03', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0'),
(364, 14, 'Rogelyn', '2026-05-04 04:22:34', '2026-05-04 04:22:34', 'logout', 'Auth', 'User logged out', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0'),
(365, 14, 'Rogelyn', '2026-05-04 04:22:53', '2026-05-04 04:22:53', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0'),
(366, 23, 'Emely Urgelles', '2026-05-04 04:38:54', '2026-05-04 04:38:54', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0'),
(367, 14, 'Rogelyn', '2026-05-04 04:39:29', '2026-05-04 04:39:29', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0');
INSERT INTO `activity_logs` (`id`, `user_id`, `user_name`, `created_at`, `updated_at`, `action`, `module`, `description`, `old_data`, `new_data`, `ip_address`, `user_agent`) VALUES
(368, 14, 'Rogelyn', '2026-05-04 04:48:10', '2026-05-04 04:48:10', 'update', 'Profile', 'Updated profile information including profile photo', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0'),
(369, 7, 'Angeline', '2026-05-04 05:05:14', '2026-05-04 05:05:14', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0'),
(370, 7, 'Angeline', '2026-05-04 05:14:15', '2026-05-04 05:14:15', 'logout', 'Auth', 'User logged out', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0'),
(371, 7, 'Angeline', '2026-05-04 05:14:20', '2026-05-04 05:14:20', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0'),
(372, 14, 'Rogelyn', '2026-05-04 05:14:36', '2026-05-04 05:14:36', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0'),
(373, 14, 'Rogelyn', '2026-05-05 03:40:06', '2026-05-05 03:40:06', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0'),
(374, 14, 'Rogelyn', '2026-05-05 03:41:22', '2026-05-05 03:41:22', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0'),
(375, 14, 'Rogelyn', '2026-05-05 03:48:09', '2026-05-05 03:48:09', 'logout', 'Auth', 'User logged out', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0'),
(376, 14, 'Rogelyn', '2026-05-05 03:48:37', '2026-05-05 03:48:37', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0'),
(377, 14, 'Rogelyn', '2026-05-05 12:19:25', '2026-05-05 12:19:25', 'create', 'POS', 'Processed sale: Invoice #INV-20260505-0153 | Total: ₱162.00', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0'),
(378, 14, 'Rogelyn', '2026-05-05 12:55:47', '2026-05-05 12:55:47', 'create', 'POS', 'Processed sale: Invoice #INV-20260505-1270 | Total: ₱129.60', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0'),
(379, 14, 'Rogelyn', '2026-05-05 18:50:50', '2026-05-05 18:50:50', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0'),
(380, 7, 'Angeline', '2026-05-05 18:55:41', '2026-05-05 18:55:41', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0'),
(381, 7, 'Angeline', '2026-05-05 19:03:51', '2026-05-05 19:03:51', 'update', 'Inventory', 'Updated product: neosep (ID: 112) - Changes: Name: neosep → Neosep', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0'),
(382, 7, 'Angeline', '2026-05-05 19:04:19', '2026-05-05 19:04:19', 'delete', 'Inventory', 'Deleted batch from product: Biogesic', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0'),
(383, 7, 'Angeline', '2026-05-05 19:04:26', '2026-05-05 19:04:26', 'delete', 'Inventory', 'Deleted batch from product: Alaska', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0'),
(384, 7, 'Angeline', '2026-05-05 19:04:46', '2026-05-05 19:04:46', 'delete', 'Inventory', 'Deleted batch from product: Ascorbic Acid', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0'),
(385, 7, 'Angeline', '2026-05-05 19:05:59', '2026-05-05 19:05:59', 'update', 'Inventory', 'Updated product: Neosep (ID: 112) - Changes: No changes', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0'),
(386, 7, 'Angeline', '2026-05-05 19:08:48', '2026-05-05 19:08:48', 'create', 'Inventory', 'Created new product in OLD STOCK: Biogesic with Batch 1 (20 boxes)', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0'),
(387, 7, 'Angeline', '2026-05-05 19:09:08', '2026-05-05 19:09:08', 'delete', 'Inventory', 'Deleted batch from product: Biogesic', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0'),
(388, 7, 'Angeline', '2026-05-05 19:09:38', '2026-05-05 19:09:38', 'delete', 'Inventory', 'Deleted batch from product: Biogesic', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0'),
(389, 7, 'Angeline', '2026-05-05 19:10:38', '2026-05-05 19:10:38', 'create', 'Inventory', 'Created new product in OLD STOCK: Biogesic with Batch 1 (50 boxes)', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0'),
(390, 7, 'Angeline', '2026-05-05 19:12:21', '2026-05-05 19:12:21', 'create', 'Inventory', 'Created new product in OLD STOCK: Neozep with Batch 1 (50 boxes)', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0'),
(391, 7, 'Angeline', '2026-05-05 19:12:43', '2026-05-05 19:12:43', 'delete', 'Inventory', 'Deleted batch from product: Neosep', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0'),
(392, 14, 'Rogelyn', '2026-05-05 19:15:19', '2026-05-05 19:15:19', 'update', 'Profile', 'Updated profile information', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0'),
(393, 24, 'Conan', '2026-05-05 20:42:29', '2026-05-05 20:42:29', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0'),
(394, 14, 'Rogelyn', '2026-05-05 21:35:04', '2026-05-05 21:35:04', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0'),
(395, 7, 'Angeline', '2026-05-05 21:49:11', '2026-05-05 21:49:11', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0'),
(396, 7, 'Angeline', '2026-05-05 21:58:42', '2026-05-05 21:58:42', 'create', 'Inventory', 'Created new product in OLD STOCK: Ascorbic Acid with Batch 1 (100 boxes)', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0'),
(397, 7, 'Angeline', '2026-05-06 05:59:47', '2026-05-06 05:59:47', 'create', 'POS', 'Processed sale: Invoice #INV-20260506-6820 | Total: ₱100.00', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0'),
(398, 7, 'Angeline', '2026-05-05 22:31:30', '2026-05-05 22:31:30', 'create', 'Inventory', 'Created new product in OLD STOCK: Neozep with Batch 1 (30 boxes)', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0'),
(399, 7, 'Angeline', '2026-05-05 22:33:12', '2026-05-05 22:33:12', 'create', 'Stock Queue', 'Added to QUEUE as Batch 2: 100 boxes of Neozep (Still have 300 pieces in stock)', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0'),
(400, 14, 'Rogelyn', '2026-05-07 01:20:00', '2026-05-07 01:20:00', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0'),
(401, 7, 'Angeline', '2026-05-07 01:46:15', '2026-05-07 01:46:15', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0'),
(402, 14, 'Rogelyn', '2026-05-07 10:11:18', '2026-05-07 10:11:18', 'create', 'POS', 'Processed sale: Invoice #INV-20260507-3404 | Total: ₱120.00', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0'),
(403, 14, 'Rogelyn', '2026-05-07 10:20:28', '2026-05-07 10:20:28', 'create', 'POS', 'Processed sale: Invoice #INV-20260507-6294 | Total: ₱120.00', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0'),
(404, 14, 'Rogelyn', '2026-05-07 10:22:18', '2026-05-07 10:22:18', 'create', 'POS', 'Processed sale: Invoice #INV-20260507-9131 | Total: ₱120.00', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0'),
(405, 14, 'Rogelyn', '2026-05-07 10:25:50', '2026-05-07 10:25:50', 'create', 'POS', 'Processed sale: Invoice #INV-20260507-9729 | Total: ₱120.00', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0'),
(406, 7, 'Angeline', '2026-05-09 05:33:04', '2026-05-09 05:33:04', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0'),
(407, 7, 'Angeline', '2026-05-09 05:36:09', '2026-05-09 05:36:09', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0'),
(408, 7, 'Angeline', '2026-05-09 13:44:47', '2026-05-09 13:44:47', 'create', 'POS', 'Processed sale: Invoice #INV-20260509-7188 | Total: ₱120.00', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0'),
(409, 14, 'Rogelyn', '2026-05-09 06:07:39', '2026-05-09 06:07:39', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0'),
(410, 14, 'Rogelyn', '2026-05-12 04:32:55', '2026-05-12 04:32:55', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0'),
(411, 7, 'Angeline', '2026-05-12 04:44:50', '2026-05-12 04:44:50', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0'),
(412, 14, 'Rogelyn', '2026-05-12 13:26:53', '2026-05-12 13:26:53', 'create', 'POS', 'Processed sale: Invoice #INV-20260512-7980 | Total: ₱120.00', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0'),
(413, 14, 'Rogelyn', '2026-05-12 06:40:47', '2026-05-12 06:40:47', 'update', 'Profile', 'Updated profile information', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0'),
(414, 14, 'Rogelyn', '2026-05-12 07:49:27', '2026-05-12 07:49:27', 'update', 'Profile', 'Updated profile information', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0'),
(415, 14, 'Rogelyn', '2026-05-13 07:48:10', '2026-05-13 07:48:10', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0'),
(416, 14, 'Rogelyn', '2026-05-13 16:19:58', '2026-05-13 16:19:58', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0'),
(417, 14, 'Rogelyn', '2026-05-14 04:24:45', '2026-05-14 04:24:45', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0'),
(418, 14, 'Rogelyn', '2026-05-14 04:25:00', '2026-05-14 04:25:00', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0'),
(419, 7, 'Angeline', '2026-05-14 04:25:38', '2026-05-14 04:25:38', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0'),
(420, 14, 'Rogelyn', '2026-05-14 04:26:41', '2026-05-14 04:26:41', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0'),
(421, 7, 'Angeline', '2026-05-14 04:27:36', '2026-05-14 04:27:36', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0'),
(422, 7, 'Angeline', '2026-05-14 04:34:55', '2026-05-14 04:34:55', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0'),
(423, 7, 'Angeline', '2026-05-14 04:38:50', '2026-05-14 04:38:50', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0'),
(424, 14, 'Rogelyn', '2026-05-14 04:39:21', '2026-05-14 04:39:21', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0'),
(425, 14, 'Rogelyn', '2026-05-16 23:07:06', '2026-05-16 23:07:06', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0'),
(426, 7, 'Angeline', '2026-05-16 23:07:32', '2026-05-16 23:07:32', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0'),
(427, 14, 'Rogelyn', '2026-05-16 23:12:41', '2026-05-16 23:12:41', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0'),
(428, 14, 'Rogelyn', '2026-05-16 23:28:56', '2026-05-16 23:28:56', 'update', 'Profile', 'Updated profile information', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0'),
(429, 14, 'Rogelyn', '2026-05-16 23:35:38', '2026-05-16 23:35:38', 'update', 'Profile', 'Updated profile information including resume', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0'),
(430, 14, 'Rogelyn', '2026-05-16 23:50:41', '2026-05-16 23:50:41', 'update', 'Profile', 'Updated profile information including resume', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0'),
(431, 7, 'Angeline', '2026-05-17 02:26:27', '2026-05-17 02:26:27', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0'),
(432, 14, 'Rogelyn', '2026-05-17 03:32:21', '2026-05-17 03:32:21', 'logout', 'Auth', 'User logged out', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0'),
(433, 7, 'Angeline', '2026-05-17 03:32:32', '2026-05-17 03:32:32', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0'),
(434, 7, 'Angeline', '2026-05-17 03:39:14', '2026-05-17 03:39:14', 'delete', 'Prescription', 'Deleted prescription #RX-2026-0002', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0'),
(435, 7, 'Angeline', '2026-05-17 03:41:03', '2026-05-17 03:41:03', 'create', 'Prescription', 'Created prescription #RX-2026-0001 for Juan Dela Cruz', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0'),
(436, 7, 'Angeline', '2026-05-17 03:44:36', '2026-05-17 03:44:36', 'create', 'Prescription', 'Created prescription #RX-2026-0002 for Angela Reyes', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0'),
(437, 14, 'Rogelyn', '2026-05-17 03:48:08', '2026-05-17 03:48:08', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0'),
(438, 7, 'Angeline', '2026-05-17 12:42:25', '2026-05-17 12:42:25', 'create', 'POS', 'Processed sale: Invoice #INV-20260517-8145 | Total: ₱50.00', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0'),
(439, 7, 'Angeline', '2026-05-17 12:44:19', '2026-05-17 12:44:19', 'update', 'Prescription', 'Prescription item Ascorbic Acid fully dispensed', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0'),
(440, 7, 'Angeline', '2026-05-17 12:44:19', '2026-05-17 12:44:19', 'update', 'Prescription', 'Prescription #RX-2026-0002 fully used and marked as used', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0'),
(441, 7, 'Angeline', '2026-05-17 12:44:19', '2026-05-17 12:44:19', 'create', 'POS', 'Processed sale: Invoice #INV-20260517-3161 | Total: ₱1,450.00', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0'),
(442, 7, 'Angeline', '2026-05-17 12:46:03', '2026-05-17 12:46:03', 'create', 'POS', 'Processed sale: Invoice #INV-20260517-0432 | Total: ₱50.00', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0'),
(443, 7, 'Angeline', '2026-05-17 12:49:09', '2026-05-17 12:49:09', 'create', 'POS', 'Processed sale: Invoice #INV-20260517-3233 | Total: ₱120.00', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0'),
(444, 7, 'Angeline', '2026-05-17 12:49:51', '2026-05-17 12:49:51', 'create', 'POS', 'Processed sale: Invoice #INV-20260517-5256 | Total: ₱120.00', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0'),
(445, 7, 'Angeline', '2026-05-17 12:51:41', '2026-05-17 12:51:41', 'create', 'POS', 'Processed sale: Invoice #INV-20260517-3037 | Total: ₱120.00', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0'),
(446, 7, 'Angeline', '2026-05-17 05:02:11', '2026-05-17 05:02:11', 'delete', 'Inventory', 'Deleted batch from product: Neozep', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0'),
(447, 7, 'Angeline', '2026-05-17 13:02:45', '2026-05-17 13:02:45', 'create', 'POS', 'Processed sale: Invoice #INV-20260517-2998 | Total: ₱120.00', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0'),
(448, 7, 'Angeline', '2026-05-17 13:03:42', '2026-05-17 13:03:42', 'create', 'POS', 'Processed sale: Invoice #INV-20260517-5938 | Total: ₱120.00', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0'),
(449, 7, 'Angeline', '2026-05-17 13:09:04', '2026-05-17 13:09:04', 'create', 'POS', 'Processed sale: Invoice #INV-20260517-7375 | Total: ₱120.00', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0'),
(450, 7, 'Angeline', '2026-05-17 05:11:43', '2026-05-17 05:11:43', 'delete', 'Prescription', 'Deleted prescription #RX-2026-0001', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0'),
(451, 7, 'Angeline', '2026-05-17 05:12:59', '2026-05-17 05:12:59', 'create', 'Prescription', 'Created prescription #RX-2026-0003 for Juan Dela Cruz', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0'),
(452, 7, 'Angeline', '2026-05-17 05:13:30', '2026-05-17 05:13:30', 'update', 'Prescription', 'Updated prescription #RX-2026-0003', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0'),
(453, 7, 'Angeline', '2026-05-17 13:13:55', '2026-05-17 13:13:55', 'create', 'POS', 'Processed sale: Invoice #INV-20260517-0945 | Total: ₱120.00', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0'),
(454, 7, 'Angeline', '2026-05-18 04:07:58', '2026-05-18 04:07:58', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0'),
(455, 7, 'Angeline', '2026-05-18 12:14:35', '2026-05-18 12:14:35', 'create', 'POS', 'Processed sale: Invoice #INV-20260518-7381 | Total: ₱120.00', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0'),
(456, 7, 'Angeline', '2026-05-18 05:57:33', '2026-05-18 05:57:33', 'logout', 'Auth', 'User logged out', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0'),
(457, 7, 'Angeline', '2026-05-18 07:23:49', '2026-05-18 07:23:49', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0'),
(458, 7, 'Angeline', '2026-05-18 15:25:40', '2026-05-18 15:25:40', 'create', 'POS', 'Processed sale: Invoice #INV-20260518-6931 | Total: ₱50.00', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0'),
(459, 7, 'Angeline', '2026-05-18 07:31:15', '2026-05-18 07:31:15', 'logout', 'Auth', 'User logged out', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0'),
(460, 7, 'Angeline', '2026-05-18 08:02:13', '2026-05-18 08:02:13', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0'),
(461, 7, 'Angeline', '2026-05-18 08:03:09', '2026-05-18 08:03:09', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0'),
(462, 7, 'Angeline', '2026-05-19 00:38:40', '2026-05-19 00:38:40', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0'),
(463, 14, 'Rogelyn', '2026-05-19 01:35:46', '2026-05-19 01:35:46', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0'),
(464, 14, 'Rogelyn', '2026-05-19 01:37:16', '2026-05-19 01:37:16', 'logout', 'Auth', 'User logged out', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0'),
(465, 14, 'Rogelyn', '2026-05-19 01:37:26', '2026-05-19 01:37:26', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0'),
(466, 14, 'Rogelyn', '2026-05-19 01:38:01', '2026-05-19 01:38:01', 'logout', 'Auth', 'User logged out', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0'),
(467, 14, 'Rogelyn', '2026-05-19 01:38:31', '2026-05-19 01:38:31', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0'),
(468, 7, 'Angeline', '2026-05-19 06:18:39', '2026-05-19 06:18:39', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0'),
(469, 7, 'Angeline', '2026-05-27 09:06:19', '2026-05-27 09:06:19', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0'),
(470, 14, 'Rogelyn', '2026-05-27 09:06:39', '2026-05-27 09:06:39', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0'),
(471, 14, 'Rogelyn', '2026-05-27 09:10:23', '2026-05-27 09:10:23', 'update', 'Profile', 'Updated profile information including profile photo including resume', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0'),
(472, 14, 'Rogelyn', '2026-05-28 00:48:48', '2026-05-28 00:48:48', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0'),
(473, 14, 'Rogelyn', '2026-05-28 09:00:13', '2026-05-28 09:00:13', 'create', 'POS', 'Processed sale: Invoice #INV-20260528-0135 | Total: ₱30.00', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0'),
(474, 14, 'Rogelyn', '2026-05-28 10:09:42', '2026-05-28 10:09:42', 'create', 'POS', 'Processed sale: Invoice #INV-20260528-8718 | Total: ₱80.00', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0'),
(475, 14, 'Rogelyn', '2026-05-28 02:25:55', '2026-05-28 02:25:55', 'logout', 'Auth', 'User logged out', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0'),
(476, 14, 'Rogelyn', '2026-05-28 02:29:05', '2026-05-28 02:29:05', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(477, 14, 'Rogelyn', '2026-05-28 02:29:45', '2026-05-28 02:29:45', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(478, 14, 'Rogelyn', '2026-05-28 02:59:27', '2026-05-28 02:59:27', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0'),
(479, 14, 'Rogelyn', '2026-05-28 03:01:01', '2026-05-28 03:01:01', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0'),
(480, 14, 'Rogelyn', '2026-05-28 03:01:47', '2026-05-28 03:01:47', 'logout', 'Auth', 'User logged out', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0'),
(481, 7, 'Angeline', '2026-05-28 03:03:53', '2026-05-28 03:03:53', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(482, 7, 'Angeline', '2026-05-28 03:11:14', '2026-05-28 03:11:14', 'create', 'Inventory', 'Created new product in OLD STOCK: Ambroxol with Batch 1 (25 boxes)', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(483, 7, 'Angeline', '2026-05-28 03:33:34', '2026-05-28 03:33:34', 'logout', 'Auth', 'User logged out', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(484, 14, 'Rogelyn', '2026-05-28 03:41:09', '2026-05-28 03:41:09', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0'),
(485, 14, 'Rogelyn', '2026-05-28 04:03:42', '2026-05-28 04:03:42', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0'),
(486, 7, 'Angeline', '2026-05-28 04:17:18', '2026-05-28 04:17:18', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(487, 7, 'Angeline', '2026-05-28 04:17:56', '2026-05-28 04:17:56', 'logout', 'Auth', 'User logged out', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(488, 14, 'Rogelyn', '2026-05-28 05:08:41', '2026-05-28 05:08:41', 'logout', 'Auth', 'User logged out', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0'),
(489, 14, 'Rogelyn', '2026-05-28 06:05:14', '2026-05-28 06:05:14', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0'),
(490, 14, 'Rogelyn', '2026-05-28 06:20:34', '2026-05-28 06:20:34', 'logout', 'Auth', 'User logged out', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0'),
(491, 14, 'Rogelyn', '2026-05-28 06:25:00', '2026-05-28 06:25:00', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0'),
(492, 14, 'Rogelyn', '2026-05-28 06:25:38', '2026-05-28 06:25:38', 'logout', 'Auth', 'User logged out', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0'),
(493, 14, 'Rogelyn', '2026-05-28 06:25:44', '2026-05-28 06:25:44', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0'),
(494, 14, 'Rogelyn', '2026-05-28 06:33:22', '2026-05-28 06:33:22', 'logout', 'Auth', 'User logged out', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0'),
(495, 14, 'Rogelyn', '2026-05-28 06:35:10', '2026-05-28 06:35:10', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0'),
(496, 14, 'Rogelyn', '2026-05-28 14:37:14', '2026-05-28 14:37:14', 'create', 'POS', 'Processed sale: Invoice #INV-20260528-7250 | Total: ₱55.00', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0'),
(497, 14, 'Rogelyn', '2026-05-28 06:51:52', '2026-05-28 06:51:52', 'update', 'Profile', 'Updated profile information including profile photo including resume', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0'),
(498, 14, 'Rogelyn', '2026-05-28 06:53:11', '2026-05-28 06:53:11', 'logout', 'Auth', 'User logged out', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0'),
(499, 7, 'Angeline', '2026-05-28 06:56:30', '2026-05-28 06:56:30', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0'),
(500, 7, 'Angeline', '2026-05-28 07:03:58', '2026-05-28 07:03:58', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(501, 7, 'Angeline', '2026-05-28 14:20:10', '2026-05-28 14:20:10', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(502, 14, 'Rogelyn', '2026-05-28 14:27:49', '2026-05-28 14:27:49', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0'),
(503, 14, 'Rogelyn', '2026-05-28 22:28:55', '2026-05-28 22:28:55', 'create', 'POS', 'Processed sale: Invoice #INV-20260529-8436 | Total: ₱5.00', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0'),
(504, 14, 'Rogelyn', '2026-05-28 22:29:55', '2026-05-28 22:29:55', 'create', 'POS', 'Processed sale: Invoice #INV-20260529-7218 | Total: ₱5.00', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0'),
(505, 14, 'Rogelyn', '2026-05-28 22:30:27', '2026-05-28 22:30:27', 'create', 'POS', 'Processed sale: Invoice #INV-20260529-8124 | Total: ₱5.00', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0'),
(506, 14, 'Rogelyn', '2026-05-28 14:33:38', '2026-05-28 14:33:38', 'logout', 'Auth', 'User logged out', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0'),
(507, 14, 'Rogelyn', '2026-05-28 14:33:45', '2026-05-28 14:33:45', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0'),
(508, 14, 'Rogelyn', '2026-05-28 22:34:37', '2026-05-28 22:34:37', 'create', 'POS', 'Processed sale: Invoice #INV-20260529-6341 | Total: ₱5.00', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0'),
(509, 14, 'Rogelyn', '2026-05-28 14:44:26', '2026-05-28 14:44:26', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0'),
(510, 14, 'Rogelyn', '2026-05-28 14:49:21', '2026-05-28 14:49:21', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0'),
(511, 14, 'Rogelyn', '2026-05-28 22:51:20', '2026-05-28 22:51:20', 'create', 'POS', 'Processed sale: Invoice #INV-20260529-8475 | Total: ₱5.00', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0'),
(512, 14, 'Rogelyn', '2026-05-28 22:55:28', '2026-05-28 22:55:28', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0'),
(513, 14, 'Rogelyn', '2026-05-29 01:38:37', '2026-05-29 01:38:37', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0'),
(514, 7, 'Angeline', '2026-05-29 01:40:34', '2026-05-29 01:40:34', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(515, 23, 'Emely Urgelles', '2026-05-29 01:42:27', '2026-05-29 01:42:27', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0'),
(516, 7, 'Angeline', '2026-05-29 02:08:37', '2026-05-29 02:08:37', 'create', 'Prescription', 'Created prescription #RX-2026-0004 for Maria Clara Reyes', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(517, 7, 'Angeline', '2026-05-29 02:09:20', '2026-05-29 02:09:20', 'create', 'POS', 'Processed sale: Invoice #INV-20260529-5894 | Total: ₱5.00', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(518, 7, 'Angeline', '2026-05-29 02:10:48', '2026-05-29 02:10:48', 'create', 'POS', 'Processed sale: Invoice #INV-20260529-7433 | Total: ₱5.00', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(519, 14, 'Rogelyn', '2026-05-29 02:21:36', '2026-05-29 02:21:36', 'logout', 'Auth', 'User logged out', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0'),
(520, 14, 'Rogelyn', '2026-05-29 03:09:12', '2026-05-29 03:09:12', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0'),
(521, 14, 'Rogelyn', '2026-05-29 03:10:22', '2026-05-29 03:10:22', 'login', 'Auth', 'User logged in', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0'),
(522, 14, 'Rogelyn', '2026-05-29 03:13:12', '2026-05-29 03:13:12', 'create', 'POS', 'Processed sale: Invoice #INV-20260529-8940 | Total: ₱100.00', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0'),
(523, 7, 'Angeline', '2026-05-29 03:20:19', '2026-05-29 03:20:19', 'update', 'Settings', 'Updated pharmacy information: Pharmacy Logo updated', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-password_reset_angelinelanorio@gmail.com', 'b:1;', 1779980186),
('laravel-cache-password_reset_curtina295@gmail.com', 'b:1;', 1779965914),
('laravel-cache-spatie.permission.cache', 'a:3:{s:5:\"alias\";a:4:{s:1:\"a\";s:2:\"id\";s:1:\"b\";s:4:\"name\";s:1:\"c\";s:10:\"guard_name\";s:1:\"r\";s:5:\"roles\";}s:11:\"permissions\";a:46:{i:0;a:4:{s:1:\"a\";i:1;s:1:\"b\";s:14:\"view dashboard\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:4:{i:0;i:4;i:1;i:5;i:2;i:8;i:3;i:9;}}i:1;a:4:{s:1:\"a\";i:2;s:1:\"b\";s:18:\"view sales metrics\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:8;}}i:2;a:4:{s:1:\"a\";i:3;s:1:\"b\";s:22:\"view inventory metrics\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:8;}}i:3;a:4:{s:1:\"a\";i:4;s:1:\"b\";s:14:\"view inventory\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:4:{i:0;i:4;i:1;i:5;i:2;i:8;i:3;i:9;}}i:4;a:4:{s:1:\"a\";i:5;s:1:\"b\";s:14:\"create product\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:4;i:1;i:5;i:2;i:8;}}i:5;a:4:{s:1:\"a\";i:6;s:1:\"b\";s:12:\"edit product\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:4;i:1;i:5;i:2;i:8;}}i:6;a:4:{s:1:\"a\";i:7;s:1:\"b\";s:14:\"delete product\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:4;i:1;i:5;i:2;i:8;}}i:7;a:4:{s:1:\"a\";i:8;s:1:\"b\";s:12:\"update stock\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:8;}}i:8;a:4:{s:1:\"a\";i:9;s:1:\"b\";s:15:\"view categories\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:4;i:1;i:5;i:2;i:8;}}i:9;a:4:{s:1:\"a\";i:10;s:1:\"b\";s:17:\"manage categories\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:4;i:1;i:5;i:2;i:8;}}i:10;a:4:{s:1:\"a\";i:11;s:1:\"b\";s:8:\"view pos\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:4:{i:0;i:4;i:1;i:5;i:2;i:8;i:3;i:9;}}i:11;a:4:{s:1:\"a\";i:12;s:1:\"b\";s:15:\"process payment\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:5;i:1;i:8;i:2;i:9;}}i:12;a:4:{s:1:\"a\";i:13;s:1:\"b\";s:16:\"void transaction\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:8;}}i:13;a:4:{s:1:\"a\";i:14;s:1:\"b\";s:11:\"view promos\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:4;i:1;i:5;i:2;i:8;}}i:14;a:4:{s:1:\"a\";i:15;s:1:\"b\";s:13:\"manage promos\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:8;}}i:15;a:4:{s:1:\"a\";i:16;s:1:\"b\";s:14:\"view discounts\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:4;i:1;i:5;i:2;i:8;}}i:16;a:4:{s:1:\"a\";i:17;s:1:\"b\";s:16:\"manage discounts\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:4;i:1;i:5;i:2;i:8;}}i:17;a:4:{s:1:\"a\";i:18;s:1:\"b\";s:13:\"view receipts\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:4:{i:0;i:4;i:1;i:5;i:2;i:8;i:3;i:9;}}i:18;a:4:{s:1:\"a\";i:19;s:1:\"b\";s:14:\"print receipts\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:5;i:1;i:8;i:2;i:9;}}i:19;a:4:{s:1:\"a\";i:20;s:1:\"b\";s:18:\"view sales reports\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:5;i:1;i:8;i:2;i:9;}}i:20;a:4:{s:1:\"a\";i:21;s:1:\"b\";s:22:\"view inventory reports\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:4;i:1;i:5;i:2;i:8;}}i:21;a:4:{s:1:\"a\";i:22;s:1:\"b\";s:14:\"export reports\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:8;}}i:22;a:4:{s:1:\"a\";i:23;s:1:\"b\";s:10:\"view users\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:8;}}i:23;a:4:{s:1:\"a\";i:24;s:1:\"b\";s:12:\"create users\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:8;}}i:24;a:4:{s:1:\"a\";i:25;s:1:\"b\";s:10:\"edit users\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:8;}}i:25;a:4:{s:1:\"a\";i:26;s:1:\"b\";s:12:\"delete users\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:8;}}i:26;a:4:{s:1:\"a\";i:27;s:1:\"b\";s:9:\"view logs\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:4:{i:0;i:4;i:1;i:5;i:2;i:8;i:3;i:9;}}i:27;a:4:{s:1:\"a\";i:28;s:1:\"b\";s:24:\"view inventory read only\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:8;}}i:28;a:4:{s:1:\"a\";i:29;s:1:\"b\";s:20:\"reset user passwords\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:8;}}i:29;a:4:{s:1:\"a\";i:30;s:1:\"b\";s:10:\"view roles\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:8;}}i:30;a:4:{s:1:\"a\";i:31;s:1:\"b\";s:12:\"create roles\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:8;}}i:31;a:4:{s:1:\"a\";i:32;s:1:\"b\";s:10:\"edit roles\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:8;}}i:32;a:4:{s:1:\"a\";i:33;s:1:\"b\";s:12:\"delete roles\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:8;}}i:33;a:4:{s:1:\"a\";i:34;s:1:\"b\";s:16:\"view permissions\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:8;}}i:34;a:4:{s:1:\"a\";i:35;s:1:\"b\";s:18:\"create permissions\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:8;}}i:35;a:4:{s:1:\"a\";i:36;s:1:\"b\";s:16:\"edit permissions\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:8;}}i:36;a:4:{s:1:\"a\";i:37;s:1:\"b\";s:18:\"delete permissions\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:8;}}i:37;a:4:{s:1:\"a\";i:38;s:1:\"b\";s:13:\"view settings\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:8;}}i:38;a:4:{s:1:\"a\";i:39;s:1:\"b\";s:13:\"edit settings\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:8;}}i:39;a:4:{s:1:\"a\";i:40;s:1:\"b\";s:16:\"create inventory\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:8;}}i:40;a:4:{s:1:\"a\";i:41;s:1:\"b\";s:14:\"edit inventory\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:8;}}i:41;a:4:{s:1:\"a\";i:42;s:1:\"b\";s:17:\"view own receipts\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:8;i:1;i:9;}}i:42;a:4:{s:1:\"a\";i:43;s:1:\"b\";s:12:\"manage roles\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:8;}}i:43;a:4:{s:1:\"a\";i:44;s:1:\"b\";s:18:\"manage permissions\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:8;}}i:44;a:4:{s:1:\"a\";i:45;s:1:\"b\";s:11:\"delete logs\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:8;}}i:45;a:4:{s:1:\"a\";i:46;s:1:\"b\";s:18:\"view prescriptions\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:4;i:1;i:5;i:2;i:8;}}}s:5:\"roles\";a:4:{i:0;a:3:{s:1:\"a\";i:4;s:1:\"b\";s:18:\"Pharmacy Assistant\";s:1:\"c\";s:3:\"web\";}i:1;a:3:{s:1:\"a\";i:5;s:1:\"b\";s:10:\"Pharmacist\";s:1:\"c\";s:3:\"web\";}i:2;a:3:{s:1:\"a\";i:8;s:1:\"b\";s:5:\"Admin\";s:1:\"c\";s:3:\"web\";}i:3;a:3:{s:1:\"a\";i:9;s:1:\"b\";s:7:\"Cashier\";s:1:\"c\";s:3:\"web\";}}}', 1780093247);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `created_at`, `updated_at`) VALUES
(9, 'Antibiotics', 'antibiotics', NULL, '2025-11-26 05:37:23', '2026-04-05 07:09:41'),
(13, 'Mucolytic', 'mucolytic', NULL, '2026-01-15 02:32:08', '2026-01-15 02:32:08'),
(14, 'Analgesic / Antipyretic', 'analgesic-antipyretic', NULL, '2026-01-16 01:47:17', '2026-01-16 01:47:17');

-- --------------------------------------------------------

--
-- Table structure for table `discount_types`
--

CREATE TABLE `discount_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(30) DEFAULT NULL,
  `code` varchar(20) DEFAULT NULL,
  `discount_percent` decimal(5,2) NOT NULL,
  `requires_id` tinyint(1) NOT NULL DEFAULT 1,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `discount_types`
--

INSERT INTO `discount_types` (`id`, `name`, `code`, `discount_percent`, `requires_id`, `is_active`, `created_at`, `updated_at`) VALUES
(4, 'Senior Citizens', 'SENIOR', 20.00, 1, 1, '2026-01-16 18:05:56', '2026-01-16 18:06:04'),
(5, 'PWD', 'PWD', 20.00, 1, 1, '2026-01-16 18:18:10', '2026-01-16 18:18:18');

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
(1, '2025_11_08_112504_create_products_table', 1),
(2, '2025_11_10_160255_add_image_to_products_table', 2),
(3, '2025_11_12_114505_add_piece_columns_to_products_table', 3),
(4, '2025_11_12_120033_add_total_pieces_to_products_table', 4),
(5, '2025_11_20_071047_add_form_to_products_table', 5),
(9, '2025_11_22_065849_create_sales_table', 6),
(10, '2025_11_22_070022_create_sale_items_table', 7),
(11, '2025_11_23_144624_add_tax_amount_to_sales_table', 8),
(12, '2025_11_23_150133_make_invoice_no_nullable_in_sales_table', 9),
(13, '2025_11_23_151247_remove_total_column_from_sales_table', 10),
(14, '2025_11_25_134234_add_discount_to_sales_table', 11),
(15, '2025_12_09_113515_create_stock_queues_table', 12),
(16, '2025_12_09_114442_add_stock_queue_fields_to_products_table', 13),
(17, '2025_12_21_154258_add_dosage_columns_to_products', 14),
(19, '2025_12_23_152225_remove_stock_fields_from_products_table', 16),
(20, '2025_12_26_101025_add_cash_fields_to_sales_table', 17),
(21, '2025_12_28_114818_create_promos_table', 18),
(22, '2025_12_30_093647_create_discount_types_table', 19),
(23, '2026_01_04_074117_add_discount_type_fields_to_sales_table', 20),
(24, '2026_03_30_073311_add_otp_fields_to_users_table', 21),
(25, '2026_03_30_073730_create_otps_table', 22),
(26, '2026_04_01_074124_add_fields_to_users_table', 23),
(27, '2026_04_01_142812_create_activity_logs_table', 24),
(28, '2026_04_02_105511_add_soft_deletes_to_users_table', 25),
(29, '2026_04_02_125141_create_settings_table', 26),
(30, '2026_04_02_173408_add_id_number_fields_to_sales_table', 27),
(31, '2026_04_03_091843_add_resume_to_users_table', 28),
(32, '2026_04_03_152847_create_product_batches_table', 29),
(33, '2026_04_03_165518_add_missing_columns_to_products_table', 30),
(34, '2026_04_04_054717_add_missing_columns_to_settings_table', 31),
(35, '2026_04_04_204830_add_profile_picture_fields_to_users_table', 32),
(36, '2026_04_05_031823_create_user_trusted_devices_table', 33),
(38, '2026_04_06_070427_create_prescriptions_table', 34),
(39, '2026_04_06_070856_create_prescription_items_table', 35),
(40, '2026_04_28_111306_add_barcode_to_products_table', 36),
(41, '2026_04_28_131035_add_barcode_type_to_products_table', 37),
(42, '2026_05_17_095154_add_remaining_quantity_to_prescription_items', 38),
(43, '2026_05_17_124028_add_prescription_id_to_sales_table', 39),
(44, '2026_05_18_141005_create_password_reset_tokens_table', 40),
(45, '2026_05_28_112439_add_login_attempts_to_users_table', 41),
(46, '2026_05_28_141923_add_otp_locked_until_to_users_table', 42);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(4, 'App\\Models\\User', 18),
(4, 'App\\Models\\User', 23),
(4, 'App\\Models\\User', 27),
(5, 'App\\Models\\User', 19),
(5, 'App\\Models\\User', 28),
(5, 'App\\Models\\User', 29),
(8, 'App\\Models\\User', 7),
(8, 'App\\Models\\User', 24),
(8, 'App\\Models\\User', 25),
(9, 'App\\Models\\User', 14),
(9, 'App\\Models\\User', 26),
(9, 'App\\Models\\User', 31),
(9, 'App\\Models\\User', 32);

-- --------------------------------------------------------

--
-- Table structure for table `otps`
--

CREATE TABLE `otps` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `code` varchar(6) NOT NULL,
  `type` varchar(20) DEFAULT NULL,
  `expires_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_used` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `otps`
--

INSERT INTO `otps` (`id`, `user_id`, `code`, `type`, `expires_at`, `is_used`, `created_at`, `updated_at`) VALUES
(2, 10, '311671', 'login', '2026-03-30 08:26:15', 1, '2026-03-30 00:25:38', '2026-03-30 00:26:15'),
(3, 11, '736686', 'login', '2026-03-30 08:29:34', 1, '2026-03-30 00:28:52', '2026-03-30 00:29:34'),
(4, 7, '485976', 'login', '2026-03-30 08:32:08', 1, '2026-03-30 00:31:19', '2026-03-30 00:32:08'),
(5, 13, '626223', 'login', '2026-03-30 08:42:05', 1, '2026-03-30 00:41:33', '2026-03-30 00:42:05'),
(6, 14, '472896', 'login', '2026-03-30 08:44:23', 1, '2026-03-30 00:43:53', '2026-03-30 00:44:23'),
(8, 15, '977449', 'login', '2026-03-31 16:15:02', 1, '2026-03-31 08:14:11', '2026-03-31 08:15:02'),
(16, 13, '052934', 'login', '2026-03-31 16:52:24', 1, '2026-03-31 08:51:32', '2026-03-31 08:52:24'),
(17, 13, '085801', 'login', '2026-03-31 16:53:20', 1, '2026-03-31 08:52:32', '2026-03-31 08:53:20'),
(18, 13, '424628', 'login', '2026-03-31 16:54:29', 1, '2026-03-31 08:54:03', '2026-03-31 08:54:29'),
(19, 13, '426480', 'login', '2026-03-31 16:58:03', 1, '2026-03-31 08:57:33', '2026-03-31 08:58:03'),
(20, 13, '896032', 'login', '2026-03-31 16:58:40', 1, '2026-03-31 08:58:16', '2026-03-31 08:58:40'),
(21, 7, '345279', 'login', '2026-03-31 16:59:35', 1, '2026-03-31 08:58:56', '2026-03-31 08:59:35'),
(22, 7, '488938', 'login', '2026-03-31 17:07:18', 1, '2026-03-31 09:03:56', '2026-03-31 09:07:18'),
(24, 7, '703708', 'login', '2026-04-01 06:36:45', 1, '2026-03-31 22:35:50', '2026-03-31 22:36:45'),
(26, 7, '633816', 'login', '2026-04-01 06:39:03', 1, '2026-03-31 22:37:46', '2026-03-31 22:39:03'),
(27, 7, '200924', 'login', '2026-04-01 06:40:01', 1, '2026-03-31 22:39:38', '2026-03-31 22:40:01'),
(28, 7, '316031', 'login', '2026-04-01 06:52:26', 1, '2026-03-31 22:51:58', '2026-03-31 22:52:26'),
(29, 7, '298171', 'login', '2026-04-01 08:26:22', 1, '2026-04-01 00:25:55', '2026-04-01 00:26:22'),
(30, 7, '166908', 'login', '2026-04-01 08:57:58', 1, '2026-04-01 00:57:34', '2026-04-01 00:57:58'),
(31, 14, '364534', 'login', '2026-04-01 08:58:49', 1, '2026-04-01 00:58:16', '2026-04-01 00:58:49'),
(32, 7, '858879', 'login', '2026-04-01 09:25:01', 1, '2026-04-01 01:24:35', '2026-04-01 01:25:01'),
(33, 7, '397300', 'login', '2026-04-01 09:32:21', 1, '2026-04-01 01:31:56', '2026-04-01 01:32:21'),
(34, 7, '298335', 'login', '2026-04-01 10:02:03', 1, '2026-04-01 02:01:36', '2026-04-01 02:02:03'),
(35, 13, '985751', 'login', '2026-04-01 10:25:57', 1, '2026-04-01 02:25:35', '2026-04-01 02:25:57'),
(36, 13, '548822', 'login', '2026-04-01 11:15:47', 1, '2026-04-01 03:15:11', '2026-04-01 03:15:47'),
(37, 7, '487710', 'login', '2026-04-01 11:18:33', 1, '2026-04-01 03:18:16', '2026-04-01 03:18:33'),
(38, 14, '264141', 'login', '2026-04-01 11:20:09', 1, '2026-04-01 03:19:46', '2026-04-01 03:20:09'),
(39, 7, '516693', 'login', '2026-04-01 11:26:34', 1, '2026-04-01 03:26:10', '2026-04-01 03:26:34'),
(40, 7, '118789', 'login', '2026-04-01 12:34:34', 1, '2026-04-01 04:33:53', '2026-04-01 04:34:34'),
(41, 7, '211726', 'login', '2026-04-01 12:36:55', 1, '2026-04-01 04:36:34', '2026-04-01 04:36:55'),
(42, 7, '801416', 'login', '2026-04-01 12:39:08', 1, '2026-04-01 04:38:46', '2026-04-01 04:39:08'),
(50, 7, '948103', 'login', '2026-04-01 13:15:35', 1, '2026-04-01 05:11:08', '2026-04-01 05:15:35'),
(51, 7, '168086', 'login', '2026-04-01 13:16:25', 1, '2026-04-01 05:15:58', '2026-04-01 05:16:25'),
(52, 7, '828879', 'login', '2026-04-01 13:18:01', 1, '2026-04-01 05:17:40', '2026-04-01 05:18:01'),
(53, 7, '226171', 'login', '2026-04-01 13:27:30', 1, '2026-04-01 05:27:02', '2026-04-01 05:27:30'),
(54, 23, '882555', 'login', '2026-04-01 14:24:35', 1, '2026-04-01 06:24:02', '2026-04-01 06:24:35'),
(56, 23, '690187', 'login', '2026-04-01 14:55:29', 1, '2026-04-01 06:54:57', '2026-04-01 06:55:29'),
(57, 23, '747837', 'login', '2026-04-01 15:05:07', 1, '2026-04-01 07:04:44', '2026-04-01 07:05:07'),
(58, 7, '076164', 'login', '2026-04-01 15:06:06', 1, '2026-04-01 07:05:33', '2026-04-01 07:06:06'),
(60, 7, '868125', 'login', '2026-04-02 01:45:29', 1, '2026-04-01 17:44:54', '2026-04-01 17:45:29'),
(61, 7, '215943', 'login', '2026-04-02 01:58:55', 1, '2026-04-01 17:58:31', '2026-04-01 17:58:55'),
(62, 7, '849289', 'login', '2026-04-02 02:13:03', 1, '2026-04-01 18:12:38', '2026-04-01 18:13:03'),
(63, 24, '928778', 'login', '2026-04-02 10:04:30', 1, '2026-04-02 02:04:05', '2026-04-02 02:04:30'),
(64, 24, '952820', 'login', '2026-04-02 14:24:20', 1, '2026-04-02 06:23:38', '2026-04-02 06:24:20'),
(67, 24, '374162', 'login', '2026-04-02 14:56:37', 1, '2026-04-02 06:55:25', '2026-04-02 06:56:37'),
(68, 23, '404637', 'login', '2026-04-02 15:04:29', 1, '2026-04-02 07:04:02', '2026-04-02 07:04:29'),
(69, 23, '090501', 'login', '2026-04-02 15:35:08', 1, '2026-04-02 07:34:37', '2026-04-02 07:35:08'),
(71, 24, '225897', 'login', '2026-04-02 15:57:55', 1, '2026-04-02 07:57:08', '2026-04-02 07:57:55'),
(72, 14, '942030', 'login', '2026-04-02 15:59:41', 1, '2026-04-02 07:58:53', '2026-04-02 07:59:41'),
(73, 24, '317843', 'login', '2026-04-03 01:50:01', 1, '2026-04-02 17:48:12', '2026-04-02 17:50:01'),
(74, 14, '050286', 'login', '2026-04-03 01:51:31', 1, '2026-04-02 17:50:29', '2026-04-02 17:51:31'),
(75, 23, '625877', 'login', '2026-04-03 01:52:37', 1, '2026-04-02 17:52:04', '2026-04-02 17:52:37'),
(76, 14, '226307', 'login', '2026-04-03 04:35:50', 1, '2026-04-02 20:35:13', '2026-04-02 20:35:50'),
(77, 23, '071551', 'login', '2026-04-03 12:49:48', 1, '2026-04-03 04:49:18', '2026-04-03 04:49:48'),
(78, 14, '269903', 'login', '2026-04-03 13:38:43', 1, '2026-04-03 05:38:02', '2026-04-03 05:38:43'),
(79, 23, '176317', 'login', '2026-04-03 13:59:02', 1, '2026-04-03 05:58:10', '2026-04-03 05:59:02'),
(80, 23, '166946', 'login', '2026-04-03 14:10:16', 1, '2026-04-03 06:08:32', '2026-04-03 06:10:16'),
(81, 24, '518267', 'login', '2026-04-03 14:39:15', 1, '2026-04-03 06:38:43', '2026-04-03 06:39:15'),
(83, 24, '411818', 'login', '2026-04-03 17:00:10', 1, '2026-04-03 08:59:20', '2026-04-03 09:00:10'),
(85, 23, '971228', 'login', '2026-04-03 17:28:00', 1, '2026-04-03 09:27:40', '2026-04-03 09:28:00'),
(87, 23, '749935', 'login', '2026-04-04 00:12:11', 1, '2026-04-03 16:11:20', '2026-04-03 16:12:11'),
(88, 24, '854430', 'login', '2026-04-04 00:13:47', 1, '2026-04-03 16:12:37', '2026-04-03 16:13:47'),
(89, 14, '899528', 'login', '2026-04-04 00:52:49', 1, '2026-04-03 16:52:08', '2026-04-03 16:52:49'),
(90, 14, '563287', 'login', '2026-04-04 05:24:48', 1, '2026-04-03 21:24:20', '2026-04-03 21:24:48'),
(91, 24, '697055', 'login', '2026-04-04 05:27:48', 1, '2026-04-03 21:27:24', '2026-04-03 21:27:48'),
(93, 24, '517721', 'login', '2026-04-04 07:17:45', 1, '2026-04-03 23:17:14', '2026-04-03 23:17:45'),
(94, 23, '804794', 'login', '2026-04-04 07:24:23', 1, '2026-04-03 23:24:06', '2026-04-03 23:24:23'),
(96, 24, '446355', 'login', '2026-04-04 08:58:31', 1, '2026-04-04 00:55:49', '2026-04-04 00:58:31'),
(97, 24, '902753', 'login', '2026-04-04 12:49:02', 1, '2026-04-04 04:47:11', '2026-04-04 04:49:02'),
(98, 14, '855643', 'login', '2026-04-04 12:53:34', 1, '2026-04-04 04:53:13', '2026-04-04 04:53:34'),
(99, 23, '740984', 'login', '2026-04-04 12:54:20', 1, '2026-04-04 04:54:01', '2026-04-04 04:54:20'),
(100, 24, '889899', 'login', '2026-04-04 14:46:45', 1, '2026-04-04 06:45:57', '2026-04-04 06:46:45'),
(101, 23, '109108', 'login', '2026-04-04 14:47:16', 1, '2026-04-04 06:46:54', '2026-04-04 06:47:16'),
(102, 14, '931975', 'login', '2026-04-04 15:27:47', 1, '2026-04-04 07:27:00', '2026-04-04 07:27:47'),
(103, 29, '136890', 'login', '2026-04-04 15:44:21', 1, '2026-04-04 07:43:29', '2026-04-04 07:44:21'),
(104, 24, '206173', 'login', '2026-04-04 17:29:33', 1, '2026-04-04 09:28:56', '2026-04-04 09:29:33'),
(105, 24, '471629', 'login', '2026-04-04 18:13:17', 1, '2026-04-04 10:12:22', '2026-04-04 10:13:17'),
(107, 24, '715668', 'login', '2026-04-04 18:33:34', 1, '2026-04-04 10:32:51', '2026-04-04 10:33:34'),
(108, 14, '897921', 'login', '2026-04-04 18:42:20', 1, '2026-04-04 10:41:38', '2026-04-04 10:42:20'),
(109, 24, '182994', 'login', '2026-04-04 19:21:49', 1, '2026-04-04 11:21:09', '2026-04-04 11:21:49'),
(110, 24, '963360', 'login', '2026-04-04 20:01:03', 1, '2026-04-04 12:00:09', '2026-04-04 12:01:03'),
(111, 29, '936607', 'login', '2026-04-04 21:36:07', 1, '2026-04-04 13:35:11', '2026-04-04 13:36:07'),
(114, 24, '046048', 'login', '2026-04-05 02:51:56', 1, '2026-04-04 18:50:41', '2026-04-04 18:51:56'),
(115, 24, '426310', 'login', '2026-04-05 02:53:39', 1, '2026-04-04 18:53:09', '2026-04-04 18:53:39'),
(116, 24, '600128', 'login', '2026-04-05 02:54:18', 1, '2026-04-04 18:53:56', '2026-04-04 18:54:18'),
(117, 24, '718001', 'login', '2026-04-05 02:57:24', 1, '2026-04-04 18:57:07', '2026-04-04 18:57:24'),
(118, 24, '277464', 'login', '2026-04-05 02:58:38', 1, '2026-04-04 18:58:18', '2026-04-04 18:58:38'),
(119, 24, '269977', 'login', '2026-04-05 03:00:05', 1, '2026-04-04 18:59:44', '2026-04-04 19:00:05'),
(122, 24, '434078', 'login', '2026-04-05 03:30:38', 1, '2026-04-04 19:30:14', '2026-04-04 19:30:38'),
(123, 24, '254058', 'login', '2026-04-05 03:32:39', 1, '2026-04-04 19:32:17', '2026-04-04 19:32:39'),
(124, 24, '138813', 'login', '2026-04-05 03:35:32', 1, '2026-04-04 19:35:11', '2026-04-04 19:35:32'),
(128, 24, '112163', 'login', '2026-04-05 03:44:50', 1, '2026-04-04 19:44:25', '2026-04-04 19:44:50'),
(129, 23, '323612', 'login', '2026-04-05 05:06:03', 1, '2026-04-04 21:04:00', '2026-04-04 21:06:03'),
(130, 14, '817588', 'login', '2026-04-05 05:21:58', 1, '2026-04-04 21:21:35', '2026-04-04 21:21:58'),
(131, 24, '193172', 'login', '2026-04-05 06:55:48', 1, '2026-04-04 22:55:16', '2026-04-04 22:55:48'),
(132, 29, '861357', 'login', '2026-04-05 06:57:18', 1, '2026-04-04 22:57:00', '2026-04-04 22:57:18'),
(133, 23, '895668', 'login', '2026-04-05 10:03:47', 1, '2026-04-05 02:03:03', '2026-04-05 02:03:47'),
(134, 7, '129182', 'login', '2026-04-05 11:11:36', 1, '2026-04-05 03:09:44', '2026-04-05 03:11:36'),
(135, 7, '624932', 'login', '2026-04-05 11:17:22', 1, '2026-04-05 03:16:49', '2026-04-05 03:17:22'),
(136, 7, '380127', 'login', '2026-04-05 13:58:49', 1, '2026-04-05 05:57:35', '2026-04-05 05:58:49'),
(137, 7, '233629', 'login', '2026-04-06 01:13:51', 1, '2026-04-05 17:12:35', '2026-04-05 17:13:51'),
(138, 24, '314962', 'login', '2026-04-06 01:22:58', 1, '2026-04-05 17:22:30', '2026-04-05 17:22:58'),
(139, 14, '819989', 'login', '2026-04-06 01:25:46', 1, '2026-04-05 17:25:27', '2026-04-05 17:25:46'),
(140, 23, '467080', 'login', '2026-04-06 01:27:46', 1, '2026-04-05 17:27:15', '2026-04-05 17:27:46'),
(141, 24, '729008', 'login', '2026-04-06 02:08:03', 1, '2026-04-05 18:07:37', '2026-04-05 18:08:03'),
(142, 14, '469509', 'login', '2026-04-06 02:27:35', 1, '2026-04-05 18:24:35', '2026-04-05 18:27:35'),
(143, 24, '794601', 'login', '2026-04-06 02:52:13', 1, '2026-04-05 18:51:45', '2026-04-05 18:52:13'),
(145, 24, '754212', 'login', '2026-04-06 02:55:40', 1, '2026-04-05 18:54:54', '2026-04-05 18:55:40'),
(146, 32, '628748', 'login', '2026-04-06 03:04:40', 1, '2026-04-05 19:02:18', '2026-04-05 19:04:40'),
(147, 32, '900037', 'login', '2026-04-06 03:05:30', 1, '2026-04-05 19:05:00', '2026-04-05 19:05:30'),
(148, 32, '582721', 'login', '2026-04-06 03:06:39', 1, '2026-04-05 19:06:11', '2026-04-05 19:06:39'),
(149, 23, '359619', 'login', '2026-04-06 03:09:58', 1, '2026-04-05 19:09:35', '2026-04-05 19:09:58'),
(150, 24, '153090', 'login', '2026-04-06 03:33:21', 1, '2026-04-05 19:32:35', '2026-04-05 19:33:21'),
(151, 24, '370074', 'login', '2026-04-06 03:33:52', 1, '2026-04-05 19:33:36', '2026-04-05 19:33:52'),
(153, 24, '037413', 'login', '2026-04-06 03:43:52', 1, '2026-04-05 19:43:02', '2026-04-05 19:43:52'),
(154, 24, '052350', 'login', '2026-04-06 03:48:17', 1, '2026-04-05 19:47:53', '2026-04-05 19:48:17'),
(155, 24, '138844', 'login', '2026-04-06 04:51:12', 1, '2026-04-05 20:50:39', '2026-04-05 20:51:12'),
(156, 24, '463712', 'login', '2026-04-06 06:16:37', 1, '2026-04-05 22:16:09', '2026-04-05 22:16:37'),
(158, 24, '393220', 'login', '2026-04-06 07:24:41', 1, '2026-04-05 23:24:17', '2026-04-05 23:24:41'),
(159, 24, '910699', 'login', '2026-04-06 07:26:20', 1, '2026-04-05 23:25:52', '2026-04-05 23:26:20'),
(162, 7, '227292', 'login', '2026-04-27 06:15:04', 1, '2026-04-26 22:14:30', '2026-04-26 22:15:04'),
(163, 7, '632628', 'login', '2026-04-27 16:20:26', 1, '2026-04-27 08:19:55', '2026-04-27 08:20:26'),
(165, 7, '703067', 'login', '2026-04-28 11:07:03', 1, '2026-04-28 03:05:59', '2026-04-28 03:07:03'),
(166, 7, '133281', 'login', '2026-04-28 11:08:42', 1, '2026-04-28 03:07:37', '2026-04-28 03:08:42'),
(167, 7, '163654', 'login', '2026-05-01 12:23:54', 1, '2026-05-01 04:23:22', '2026-05-01 04:23:54'),
(168, 14, '293156', 'login', '2026-05-01 13:00:08', 1, '2026-05-01 04:59:41', '2026-05-01 05:00:08'),
(169, 7, '766659', 'login', '2026-05-01 13:02:26', 1, '2026-05-01 05:02:03', '2026-05-01 05:02:26'),
(170, 7, '242572', 'login', '2026-05-01 13:24:41', 1, '2026-05-01 05:24:22', '2026-05-01 05:24:41'),
(171, 7, '706097', 'login', '2026-05-04 07:22:52', 1, '2026-05-03 23:22:34', '2026-05-03 23:22:52'),
(172, 7, '847990', 'login', '2026-05-04 07:24:10', 1, '2026-05-03 23:23:46', '2026-05-03 23:24:10'),
(173, 7, '926307', 'login', '2026-05-04 07:44:31', 1, '2026-05-03 23:44:04', '2026-05-03 23:44:31'),
(175, 7, '233012', 'login', '2026-05-04 08:03:44', 1, '2026-05-04 00:03:25', '2026-05-04 00:03:44'),
(176, 7, '519458', 'login', '2026-05-04 08:11:32', 1, '2026-05-04 00:07:57', '2026-05-04 00:11:32'),
(177, 7, '448084', 'login', '2026-05-04 08:12:00', 1, '2026-05-04 00:11:45', '2026-05-04 00:12:00'),
(178, 14, '602334', 'login', '2026-05-04 08:30:41', 1, '2026-05-04 00:29:55', '2026-05-04 00:30:41'),
(179, 23, '102788', 'login', '2026-05-04 08:33:21', 1, '2026-05-04 00:32:43', '2026-05-04 00:33:21'),
(180, 24, '825800', 'login', '2026-05-04 08:35:00', 1, '2026-05-04 00:34:18', '2026-05-04 00:35:00'),
(182, 14, '778078', 'login', '2026-05-04 11:26:48', 1, '2026-05-04 03:26:29', '2026-05-04 03:26:48'),
(184, 14, '553304', 'login', '2026-05-04 11:29:06', 1, '2026-05-04 03:28:00', '2026-05-04 03:29:06'),
(185, 14, '878591', 'login', '2026-05-04 12:22:25', 1, '2026-05-04 04:21:03', '2026-05-04 04:22:25'),
(187, 14, '053908', 'login', '2026-05-04 12:39:57', 1, '2026-05-04 04:39:29', '2026-05-04 04:39:57'),
(188, 7, '528472', 'login', '2026-05-04 13:08:00', 1, '2026-05-04 05:05:14', '2026-05-04 05:08:00'),
(189, 14, '136651', 'login', '2026-05-04 13:15:35', 1, '2026-05-04 05:14:36', '2026-05-04 05:15:35'),
(190, 14, '489542', 'login', '2026-05-05 11:40:38', 1, '2026-05-05 03:40:08', '2026-05-05 03:40:38'),
(191, 14, '697990', 'login', '2026-05-05 11:41:46', 1, '2026-05-05 03:41:22', '2026-05-05 03:41:46'),
(192, 14, '372539', 'login', '2026-05-05 11:48:58', 1, '2026-05-05 03:48:37', '2026-05-05 03:48:58'),
(193, 14, '835239', 'login', '2026-05-06 02:51:22', 1, '2026-05-05 18:50:52', '2026-05-05 18:51:22'),
(194, 7, '371507', 'login', '2026-05-06 02:56:17', 1, '2026-05-05 18:55:41', '2026-05-05 18:56:17'),
(195, 14, '225472', 'login', '2026-05-06 05:35:41', 1, '2026-05-05 21:35:04', '2026-05-05 21:35:41'),
(196, 7, '463279', 'login', '2026-05-06 05:49:34', 1, '2026-05-05 21:49:11', '2026-05-05 21:49:34'),
(197, 14, '308570', 'login', '2026-05-07 09:20:25', 1, '2026-05-07 01:20:01', '2026-05-07 01:20:25'),
(198, 7, '408658', 'login', '2026-05-07 09:46:34', 1, '2026-05-07 01:46:15', '2026-05-07 01:46:34'),
(200, 7, '007353', 'login', '2026-05-09 13:37:26', 1, '2026-05-09 05:36:09', '2026-05-09 05:37:26'),
(201, 14, '996352', 'login', '2026-05-09 14:08:46', 1, '2026-05-09 06:07:39', '2026-05-09 06:08:46'),
(202, 14, '525804', 'login', '2026-05-12 12:36:32', 1, '2026-05-12 04:32:56', '2026-05-12 04:36:32'),
(203, 7, '596075', 'login', '2026-05-12 12:45:15', 1, '2026-05-12 04:44:50', '2026-05-12 04:45:15'),
(204, 14, '739390', 'login', '2026-05-13 15:48:29', 1, '2026-05-13 07:48:11', '2026-05-13 07:48:29'),
(205, 14, '396653', 'login', '2026-05-14 00:20:47', 1, '2026-05-13 16:19:59', '2026-05-13 16:20:47'),
(208, 7, '307735', 'login', '2026-05-14 12:35:32', 1, '2026-05-14 04:34:55', '2026-05-14 04:35:32'),
(212, 14, '894899', 'login', '2026-05-17 07:13:05', 1, '2026-05-16 23:12:41', '2026-05-16 23:13:05'),
(213, 7, '366565', 'login', '2026-05-17 10:26:50', 1, '2026-05-17 02:26:27', '2026-05-17 02:26:50'),
(214, 7, '494677', 'login', '2026-05-17 11:34:04', 1, '2026-05-17 03:32:32', '2026-05-17 03:34:04'),
(215, 14, '807138', 'login', '2026-05-17 11:48:31', 1, '2026-05-17 03:48:08', '2026-05-17 03:48:31'),
(216, 7, '281176', 'login', '2026-05-18 12:08:24', 1, '2026-05-18 04:07:58', '2026-05-18 04:08:24'),
(217, 7, '723305', 'login', '2026-05-18 15:24:15', 1, '2026-05-18 07:23:50', '2026-05-18 07:24:15'),
(219, 7, '842989', 'login', '2026-05-18 16:03:27', 1, '2026-05-18 08:03:09', '2026-05-18 08:03:27'),
(220, 7, '525512', 'login', '2026-05-19 08:39:06', 1, '2026-05-19 00:38:41', '2026-05-19 00:39:06'),
(221, 14, '967740', 'login', '2026-05-19 09:36:20', 1, '2026-05-19 01:35:46', '2026-05-19 01:36:20'),
(222, 14, '409906', 'login', '2026-05-19 09:37:51', 1, '2026-05-19 01:37:26', '2026-05-19 01:37:51'),
(223, 14, '608108', 'login', '2026-05-19 09:38:55', 1, '2026-05-19 01:38:31', '2026-05-19 01:38:55'),
(225, 14, '208229', 'login', '2026-05-27 17:07:46', 1, '2026-05-27 09:06:40', '2026-05-27 09:07:46'),
(226, 14, '522405', 'login', '2026-05-28 08:50:07', 1, '2026-05-28 00:48:48', '2026-05-28 00:50:07'),
(227, 14, '082738', 'login', '2026-05-28 10:30:22', 1, '2026-05-28 02:29:45', '2026-05-28 02:30:22'),
(229, 14, '021935', 'login', '2026-05-28 11:01:40', 1, '2026-05-28 03:01:01', '2026-05-28 03:01:40'),
(230, 7, '976414', 'login', '2026-05-28 11:04:15', 1, '2026-05-28 03:03:53', '2026-05-28 03:04:15'),
(231, 14, '013406', 'login', '2026-05-28 11:41:47', 1, '2026-05-28 03:41:09', '2026-05-28 03:41:47'),
(232, 14, '047826', 'login', '2026-05-28 12:04:42', 1, '2026-05-28 04:03:43', '2026-05-28 04:04:42'),
(233, 7, '088138', 'login', '2026-05-28 12:17:50', 1, '2026-05-28 04:17:18', '2026-05-28 04:17:50'),
(234, 14, '067550', 'login', '2026-05-28 14:06:12', 1, '2026-05-28 06:05:14', '2026-05-28 06:06:12'),
(235, 14, '030318', 'login', '2026-05-28 14:25:32', 1, '2026-05-28 06:25:00', '2026-05-28 06:25:32'),
(236, 14, '855614', 'login', '2026-05-28 14:31:38', 1, '2026-05-28 06:25:45', '2026-05-28 06:31:38'),
(237, 14, '970504', 'login', '2026-05-28 14:35:32', 1, '2026-05-28 06:35:10', '2026-05-28 06:35:32'),
(238, 7, '423991', 'login', '2026-05-28 14:57:00', 1, '2026-05-28 06:56:30', '2026-05-28 06:57:00'),
(239, 7, '307264', 'login', '2026-05-28 15:04:32', 1, '2026-05-28 07:03:58', '2026-05-28 07:04:32'),
(240, 7, '957569', 'login', '2026-05-28 22:20:44', 1, '2026-05-28 14:20:11', '2026-05-28 14:20:44'),
(241, 14, '158943', 'login', '2026-05-28 22:28:22', 1, '2026-05-28 14:27:50', '2026-05-28 14:28:22'),
(242, 14, '503263', 'login', '2026-05-28 22:34:06', 1, '2026-05-28 14:33:45', '2026-05-28 14:34:06'),
(243, 14, '970448', 'login', '2026-05-28 22:44:44', 1, '2026-05-28 14:44:26', '2026-05-28 14:44:44'),
(244, 14, '071044', 'login', '2026-05-28 22:49:46', 1, '2026-05-28 14:49:22', '2026-05-28 14:49:46'),
(245, 14, '192943', 'login', '2026-05-28 22:55:45', 1, '2026-05-28 22:55:28', '2026-05-28 22:55:45'),
(246, 14, '809762', 'login', '2026-05-29 01:39:06', 1, '2026-05-29 01:38:38', '2026-05-29 01:39:06'),
(247, 7, '918083', 'login', '2026-05-29 01:40:53', 1, '2026-05-29 01:40:34', '2026-05-29 01:40:53'),
(248, 23, '911779', 'login', '2026-05-29 01:45:45', 1, '2026-05-29 01:42:27', '2026-05-29 01:45:45'),
(250, 14, '173764', 'login', '2026-05-29 03:11:19', 1, '2026-05-29 03:10:23', '2026-05-29 03:11:19');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(30) NOT NULL,
  `token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'view dashboard', 'web', '2026-03-28 00:04:48', '2026-03-28 00:04:48'),
(2, 'view sales metrics', 'web', '2026-03-28 00:04:48', '2026-03-28 00:04:48'),
(3, 'view inventory metrics', 'web', '2026-03-28 00:04:48', '2026-03-28 00:04:48'),
(4, 'view inventory', 'web', '2026-03-28 00:04:48', '2026-03-28 00:04:48'),
(5, 'create product', 'web', '2026-03-28 00:04:48', '2026-03-28 00:04:48'),
(6, 'edit product', 'web', '2026-03-28 00:04:48', '2026-03-28 00:04:48'),
(7, 'delete product', 'web', '2026-03-28 00:04:48', '2026-03-28 00:04:48'),
(8, 'update stock', 'web', '2026-03-28 00:04:48', '2026-03-28 00:04:48'),
(9, 'view categories', 'web', '2026-03-28 00:04:48', '2026-03-28 00:04:48'),
(10, 'manage categories', 'web', '2026-03-28 00:04:48', '2026-03-28 00:04:48'),
(11, 'view pos', 'web', '2026-03-28 00:04:48', '2026-03-28 00:04:48'),
(12, 'process payment', 'web', '2026-03-28 00:04:48', '2026-03-28 00:04:48'),
(13, 'void transaction', 'web', '2026-03-28 00:04:48', '2026-03-28 00:04:48'),
(14, 'view promos', 'web', '2026-03-28 00:04:48', '2026-03-28 00:04:48'),
(15, 'manage promos', 'web', '2026-03-28 00:04:48', '2026-03-28 00:04:48'),
(16, 'view discounts', 'web', '2026-03-28 00:04:48', '2026-03-28 00:04:48'),
(17, 'manage discounts', 'web', '2026-03-28 00:04:48', '2026-03-28 00:04:48'),
(18, 'view receipts', 'web', '2026-03-28 00:04:48', '2026-03-28 00:04:48'),
(19, 'print receipts', 'web', '2026-03-28 00:04:48', '2026-03-28 00:04:48'),
(20, 'view sales reports', 'web', '2026-03-28 00:04:48', '2026-03-28 00:04:48'),
(21, 'view inventory reports', 'web', '2026-03-28 00:04:48', '2026-03-28 00:04:48'),
(22, 'export reports', 'web', '2026-03-28 00:04:48', '2026-03-28 00:04:48'),
(23, 'view users', 'web', '2026-03-28 00:04:48', '2026-03-28 00:04:48'),
(24, 'create users', 'web', '2026-03-28 00:04:48', '2026-03-28 00:04:48'),
(25, 'edit users', 'web', '2026-03-28 00:04:48', '2026-03-28 00:04:48'),
(26, 'delete users', 'web', '2026-03-28 00:04:48', '2026-03-28 00:04:48'),
(27, 'view logs', 'web', '2026-03-28 00:04:48', '2026-03-28 00:04:48'),
(28, 'view inventory read only', 'web', '2026-03-30 00:52:48', '2026-03-30 00:52:48'),
(29, 'reset user passwords', 'web', '2026-04-01 00:33:24', '2026-04-01 00:33:24'),
(30, 'view roles', 'web', '2026-04-01 00:33:24', '2026-04-01 00:33:24'),
(31, 'create roles', 'web', '2026-04-01 00:33:24', '2026-04-01 00:33:24'),
(32, 'edit roles', 'web', '2026-04-01 00:33:24', '2026-04-01 00:33:24'),
(33, 'delete roles', 'web', '2026-04-01 00:33:24', '2026-04-01 00:33:24'),
(34, 'view permissions', 'web', '2026-04-01 00:33:24', '2026-04-01 00:33:24'),
(35, 'create permissions', 'web', '2026-04-01 00:33:24', '2026-04-01 00:33:24'),
(36, 'edit permissions', 'web', '2026-04-01 00:33:24', '2026-04-01 00:33:24'),
(37, 'delete permissions', 'web', '2026-04-01 00:33:24', '2026-04-01 00:33:24'),
(38, 'view settings', 'web', '2026-04-02 04:57:23', '2026-04-02 04:57:23'),
(39, 'edit settings', 'web', '2026-04-02 04:57:23', '2026-04-02 04:57:23'),
(40, 'create inventory', 'web', '2026-04-02 07:13:55', '2026-04-02 07:13:55'),
(41, 'edit inventory', 'web', '2026-04-02 07:13:55', '2026-04-02 07:13:55'),
(42, 'view own receipts', 'web', '2026-04-03 23:37:55', '2026-04-03 23:37:55'),
(43, 'manage roles', 'web', '2026-04-03 23:37:56', '2026-04-03 23:37:56'),
(44, 'manage permissions', 'web', '2026-04-03 23:37:56', '2026-04-03 23:37:56'),
(45, 'delete logs', 'web', '2026-04-03 23:37:56', '2026-04-03 23:37:56'),
(46, 'view prescriptions', 'web', '2026-04-05 23:26:54', '2026-04-05 23:26:54');

-- --------------------------------------------------------

--
-- Table structure for table `prescriptions`
--

CREATE TABLE `prescriptions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `prescription_number` varchar(30) DEFAULT NULL,
  `patient_name` varchar(30) DEFAULT NULL,
  `patient_age` int(11) DEFAULT NULL,
  `patient_contact` varchar(15) DEFAULT NULL,
  `patient_address` text DEFAULT NULL,
  `doctor_name` varchar(30) DEFAULT NULL,
  `doctor_license` varchar(30) DEFAULT NULL,
  `date_issued` date NOT NULL,
  `valid_until` date DEFAULT NULL,
  `special_instructions` text DEFAULT NULL,
  `status` enum('active','used','expired','cancelled') NOT NULL DEFAULT 'active',
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `sale_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `prescriptions`
--

INSERT INTO `prescriptions` (`id`, `prescription_number`, `patient_name`, `patient_age`, `patient_contact`, `patient_address`, `doctor_name`, `doctor_license`, `date_issued`, `valid_until`, `special_instructions`, `status`, `created_by`, `sale_id`, `created_at`, `updated_at`) VALUES
(8, 'RX-2026-0002', 'Angela Reyes', 32, '09987654321', 'Calamba City, Laguna', 'Dr. Carlo Mendoza', 'PTR-458921', '2026-05-17', '2026-05-31', 'Drink plenty of water and get enough rest.', 'used', 7, NULL, '2026-05-17 03:44:36', '2026-05-17 12:44:19'),
(9, 'RX-2026-0003', 'Juan Dela Cruz', 25, '09123456789', 'San Pablo City, Laguna', 'Dr. Maria Santos', 'LIC-2026-4587', '2026-05-17', '2026-05-24', 'Take with food. Avoid alcoholic drinks while taking medication.', 'expired', 7, NULL, '2026-05-17 05:12:59', '2026-05-29 02:01:47'),
(10, 'RX-2026-0004', 'Maria Clara Reyes', 35, '09987654321', 'Brgy. Mabini, Lipa City, Batangas', 'Dr. John Carlo Mendoza', '654321', '2026-05-29', '2026-06-07', 'Complete the full course of antibiotics.', 'active', 7, NULL, '2026-05-29 02:08:37', '2026-05-29 02:08:37');

-- --------------------------------------------------------

--
-- Table structure for table `prescription_items`
--

CREATE TABLE `prescription_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `prescription_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_name` varchar(50) DEFAULT NULL,
  `dosage` varchar(30) DEFAULT NULL,
  `quantity_prescribed` int(11) NOT NULL,
  `frequency` varchar(30) DEFAULT NULL,
  `duration` varchar(15) DEFAULT NULL,
  `special_note` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `quantity_remaining` int(11) NOT NULL DEFAULT 0,
  `quantity_dispensed` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `prescription_items`
--

INSERT INTO `prescription_items` (`id`, `prescription_id`, `product_id`, `product_name`, `dosage`, `quantity_prescribed`, `frequency`, `duration`, `special_note`, `created_at`, `updated_at`, `quantity_remaining`, `quantity_dispensed`) VALUES
(4, 8, 127, 'Ascorbic Acid', '500mg', 30, '1x/day', '30 days', 'Take every morning.', '2026-05-17 03:44:36', '2026-05-17 12:44:19', 0, 30),
(6, 9, 128, 'Neozep', '500mg', 10, '3x/day', '7 days', 'Take after meals.', '2026-05-17 05:13:30', '2026-05-18 12:14:35', 8, 2),
(7, 10, 129, 'Ambroxol', '30mg', 15, '3x/day', '7 days', 'Take after meals.', '2026-05-29 02:08:37', '2026-05-29 02:10:48', 14, 1);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `barcode` varchar(30) DEFAULT NULL,
  `barcode_type` varchar(20) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `image` varchar(100) DEFAULT NULL,
  `brand` varchar(30) DEFAULT NULL,
  `dosage_amount` decimal(10,2) DEFAULT NULL,
  `dosage_unit` varchar(10) DEFAULT NULL,
  `dosage_old` varchar(255) DEFAULT NULL,
  `form` varchar(20) DEFAULT NULL,
  `type` varchar(20) DEFAULT NULL,
  `category` varchar(30) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `stock_source` enum('direct','queue') NOT NULL DEFAULT 'direct',
  `last_stock_queue_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `barcode`, `barcode_type`, `name`, `image`, `brand`, `dosage_amount`, `dosage_unit`, `dosage_old`, `form`, `type`, `category`, `price`, `created_at`, `updated_at`, `stock_source`, `last_stock_queue_id`) VALUES
(125, '8906078103303', 'EAN13', 'Biogesic', 'products/EuLP2nEySasfcFzA7Xe80x67zRWuOE7iE0CS6WG6.jpg', 'Unilab', 500.00, 'mg', NULL, 'Tablet', 'Generic', 'Antibiotics', 10.00, '2026-05-05 19:10:38', '2026-05-05 19:10:38', 'direct', NULL),
(127, '4809011249486', 'EAN13', 'Ascorbic Acid', NULL, 'Unilab', 500.00, 'mg', NULL, 'Capsule', 'Generic', 'Antibiotics', 50.00, '2026-05-05 21:58:42', '2026-05-05 21:58:42', 'direct', NULL),
(128, '8902515841043', 'EAN13', 'Neozep', NULL, 'Unilab', 500.00, 'mg', NULL, 'Tablet', 'Generic', 'Antibiotics', 120.00, '2026-05-05 22:31:30', '2026-05-05 22:31:30', 'direct', NULL),
(129, '6972346289026', 'EAN13', 'Ambroxol', NULL, 'Unilab', 30.00, 'mg', NULL, 'Tablet', 'Branded', 'Mucolytic', 5.00, '2026-05-28 03:11:13', '2026-05-28 03:11:13', 'direct', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_batches`
--

CREATE TABLE `product_batches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `pieces_per_box` int(11) NOT NULL DEFAULT 0,
  `pieces_left` int(11) NOT NULL DEFAULT 0,
  `total_pieces` int(11) NOT NULL DEFAULT 0,
  `expiry_date` date DEFAULT NULL,
  `arrival_date` date DEFAULT NULL,
  `batch_number` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_batches`
--

INSERT INTO `product_batches` (`id`, `product_id`, `quantity`, `pieces_per_box`, `pieces_left`, `total_pieces`, `expiry_date`, `arrival_date`, `batch_number`, `created_at`, `updated_at`) VALUES
(44, 125, 50, 10, 497, 0, '2027-11-06', '2026-05-06', 'Batch 1', '2026-05-05 19:10:38', '2026-05-28 09:00:13'),
(46, 127, 99, 20, 1961, 0, '2027-01-06', '2026-05-06', 'Batch 1', '2026-05-05 21:58:42', '2026-05-29 03:13:12'),
(47, 128, 29, 10, 286, 0, '2027-12-07', '2026-06-25', 'Batch 1', '2026-05-05 22:31:30', '2026-05-18 12:14:35'),
(48, 129, 25, 20, 492, 0, '2027-05-28', '2026-05-28', 'Batch 1', '2026-05-28 03:11:14', '2026-05-29 02:10:48');

-- --------------------------------------------------------

--
-- Table structure for table `promos`
--

CREATE TABLE `promos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `discount_percent` int(11) NOT NULL DEFAULT 0,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `reason` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(30) DEFAULT NULL,
  `guard_name` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(4, 'Pharmacy Assistant', 'web', '2026-04-01 00:33:24', '2026-04-01 00:33:24'),
(5, 'Pharmacist', 'web', '2026-04-01 00:33:24', '2026-04-01 00:33:24'),
(8, 'Admin', 'web', '2026-04-01 03:25:01', '2026-04-01 03:25:01'),
(9, 'Cashier', 'web', '2026-04-01 03:25:30', '2026-04-01 03:25:30');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 4),
(1, 5),
(1, 8),
(1, 9),
(2, 8),
(3, 8),
(4, 4),
(4, 5),
(4, 8),
(4, 9),
(5, 4),
(5, 5),
(5, 8),
(6, 4),
(6, 5),
(6, 8),
(7, 4),
(7, 5),
(7, 8),
(8, 8),
(9, 4),
(9, 5),
(9, 8),
(10, 4),
(10, 5),
(10, 8),
(11, 4),
(11, 5),
(11, 8),
(11, 9),
(12, 5),
(12, 8),
(12, 9),
(13, 8),
(14, 4),
(14, 5),
(14, 8),
(15, 8),
(16, 4),
(16, 5),
(16, 8),
(17, 4),
(17, 5),
(17, 8),
(18, 4),
(18, 5),
(18, 8),
(18, 9),
(19, 5),
(19, 8),
(19, 9),
(20, 5),
(20, 8),
(20, 9),
(21, 4),
(21, 5),
(21, 8),
(22, 8),
(23, 8),
(24, 8),
(25, 8),
(26, 8),
(27, 4),
(27, 5),
(27, 8),
(27, 9),
(28, 8),
(29, 8),
(30, 8),
(31, 8),
(32, 8),
(33, 8),
(34, 8),
(35, 8),
(36, 8),
(37, 8),
(38, 8),
(39, 8),
(40, 8),
(41, 8),
(42, 8),
(42, 9),
(43, 8),
(44, 8),
(45, 8),
(46, 4),
(46, 5),
(46, 8);

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `prescription_id` bigint(20) UNSIGNED DEFAULT NULL,
  `invoice_no` varchar(30) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT 0.00,
  `discount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total_amount` decimal(10,2) DEFAULT 0.00,
  `cash_tendered` decimal(10,2) NOT NULL DEFAULT 0.00 COMMENT 'Amount paid by customer',
  `change` decimal(10,2) NOT NULL DEFAULT 0.00 COMMENT 'Change returned to customer',
  `discount_type_id` bigint(20) UNSIGNED DEFAULT NULL,
  `discount_percent` decimal(5,2) NOT NULL DEFAULT 0.00,
  `customer_type` varchar(30) DEFAULT NULL,
  `customer_type_name` varchar(50) DEFAULT NULL,
  `id_number` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `prescription_id`, `invoice_no`, `user_id`, `subtotal`, `discount`, `total_amount`, `cash_tendered`, `change`, `discount_type_id`, `discount_percent`, `customer_type`, `customer_type_name`, `id_number`, `created_at`, `updated_at`) VALUES
(1, NULL, 'INV-TEST-001', 7, 100.00, 0.00, 112.00, 0.00, 0.00, NULL, 0.00, 'walk_in', NULL, NULL, '2025-11-25 06:58:36', '2026-05-12 13:38:33'),
(2, NULL, 'INV-1764053991-3634', 7, 100.00, 0.00, 112.00, 0.00, 0.00, NULL, 0.00, 'walk_in', NULL, NULL, '2025-11-24 22:59:51', '2026-05-12 13:38:33'),
(3, NULL, 'INV-1764054004-8537', 7, 100.00, 0.00, 112.00, 0.00, 0.00, NULL, 0.00, 'walk_in', NULL, NULL, '2025-11-24 23:00:04', '2026-05-12 13:38:33'),
(4, NULL, 'INV-1764054089-5989', 7, 50.00, 0.00, 56.00, 0.00, 0.00, NULL, 0.00, 'walk_in', NULL, NULL, '2025-11-24 23:01:29', '2026-05-12 13:38:33'),
(5, NULL, 'INV-1764054267-9722', 7, 100.00, 0.00, 112.00, 0.00, 0.00, NULL, 0.00, 'walk_in', NULL, NULL, '2025-11-24 23:04:27', '2026-05-12 13:38:33'),
(6, NULL, 'INV-1764054823-3960', 7, 100.00, 0.00, 112.00, 0.00, 0.00, NULL, 0.00, 'walk_in', NULL, NULL, '2025-11-24 23:13:43', '2026-05-12 13:38:33'),
(7, NULL, 'INV-1764054848-9168', 7, 100.00, 0.00, 112.00, 0.00, 0.00, NULL, 0.00, 'walk_in', NULL, NULL, '2025-11-24 23:14:08', '2026-05-12 13:38:33'),
(8, NULL, 'INV-1764054918-6990', 7, 100.00, 0.00, 112.00, 0.00, 0.00, NULL, 0.00, 'walk_in', NULL, NULL, '2025-11-24 23:15:18', '2026-05-12 13:38:33'),
(9, NULL, 'INV-1764055018-3712', 7, 100.00, 0.00, 112.00, 0.00, 0.00, NULL, 0.00, 'walk_in', NULL, NULL, '2025-11-24 23:16:58', '2026-05-12 13:38:33'),
(10, NULL, 'INV-1764055050-2222', 7, 50.00, 0.00, 56.00, 0.00, 0.00, NULL, 0.00, 'walk_in', NULL, NULL, '2025-11-24 23:17:30', '2026-05-12 13:38:33'),
(11, NULL, 'INV-1764055081-8623', 7, 50.00, 0.00, 56.00, 0.00, 0.00, NULL, 0.00, 'walk_in', NULL, NULL, '2025-11-24 23:18:01', '2026-05-12 13:38:33'),
(12, NULL, 'INV-1764055117-4751', 7, 100.00, 0.00, 112.00, 0.00, 0.00, NULL, 0.00, 'walk_in', NULL, NULL, '2025-11-24 23:18:37', '2026-05-12 13:38:33'),
(13, NULL, 'INV-1764055144-9656', 7, 100.00, 0.00, 112.00, 0.00, 0.00, NULL, 0.00, 'walk_in', NULL, NULL, '2025-11-24 23:19:04', '2026-05-12 13:38:33'),
(14, NULL, 'INV-1764056775-2844', 7, 100.00, 0.00, 112.00, 0.00, 0.00, NULL, 0.00, 'walk_in', NULL, NULL, '2025-11-24 23:46:15', '2026-05-12 13:38:33'),
(15, NULL, 'INV-1764056795-8832', 7, 50.00, 0.00, 56.00, 0.00, 0.00, NULL, 0.00, 'walk_in', NULL, NULL, '2025-11-24 23:46:35', '2026-05-12 13:38:33'),
(16, NULL, 'INV-1764056825-2870', 7, 50.00, 0.00, 56.00, 0.00, 0.00, NULL, 0.00, 'walk_in', NULL, NULL, '2025-11-24 23:47:05', '2026-05-12 13:38:33'),
(17, NULL, 'INV-1764056843-7689', 7, 250.00, 0.00, 280.00, 0.00, 0.00, NULL, 0.00, 'walk_in', NULL, NULL, '2025-11-24 23:47:23', '2026-05-12 13:38:33'),
(18, NULL, 'INV-1764056863-7308', 7, 50.00, 0.00, 56.00, 0.00, 0.00, NULL, 0.00, 'walk_in', NULL, NULL, '2025-11-24 23:47:43', '2026-05-12 13:38:33'),
(19, NULL, 'INV-1764056891-6335', 7, 250.00, 0.00, 280.00, 0.00, 0.00, NULL, 0.00, 'walk_in', NULL, NULL, '2025-11-24 23:48:11', '2026-05-12 13:38:33'),
(20, NULL, 'INV-1764056992-4079', 7, 80.00, 0.00, 89.60, 0.00, 0.00, NULL, 0.00, 'walk_in', NULL, NULL, '2025-11-24 23:49:52', '2026-05-12 13:38:33'),
(21, NULL, 'INV-1764057056-4513', 7, 80.00, 0.00, 89.60, 0.00, 0.00, NULL, 0.00, 'walk_in', NULL, NULL, '2025-11-24 23:50:56', '2026-05-12 13:38:33'),
(22, NULL, 'INV-1764057077-2027', 7, 160.00, 0.00, 179.20, 0.00, 0.00, NULL, 0.00, 'walk_in', NULL, NULL, '2025-11-24 23:51:17', '2026-05-12 13:38:33'),
(23, NULL, 'INV-1764057154-3827', 7, 250.00, 0.00, 280.00, 0.00, 0.00, NULL, 0.00, 'walk_in', NULL, NULL, '2025-11-24 23:52:34', '2026-05-12 13:38:33'),
(24, NULL, 'INV-1764057177-1281', 7, 100.00, 0.00, 112.00, 0.00, 0.00, NULL, 0.00, 'walk_in', NULL, NULL, '2025-11-24 23:52:57', '2026-05-12 13:38:33'),
(25, NULL, 'INV-1764057220-5588', 7, 250.00, 0.00, 280.00, 0.00, 0.00, NULL, 0.00, 'walk_in', NULL, NULL, '2025-11-24 23:53:40', '2026-05-12 13:38:33'),
(26, NULL, 'INV-1764057235-2713', 7, 50.00, 0.00, 56.00, 0.00, 0.00, NULL, 0.00, 'walk_in', NULL, NULL, '2025-11-24 23:53:55', '2026-05-12 13:38:33'),
(27, NULL, 'INV-1764057271-2988', 7, 450.00, 0.00, 504.00, 0.00, 0.00, NULL, 0.00, 'walk_in', NULL, NULL, '2025-11-24 23:54:31', '2026-05-12 13:38:33'),
(28, NULL, 'INV-1764057283-1918', 7, 50.00, 0.00, 56.00, 0.00, 0.00, NULL, 0.00, 'walk_in', NULL, NULL, '2025-11-24 23:54:43', '2026-05-12 13:38:33'),
(29, NULL, 'INV-1764058859-1056', 7, 80.00, 0.00, 89.60, 0.00, 0.00, NULL, 0.00, 'walk_in', NULL, NULL, '2025-11-25 00:20:59', '2026-05-12 13:38:33'),
(30, NULL, 'INV-1764058875-7829', 7, 160.00, 0.00, 179.20, 0.00, 0.00, NULL, 0.00, 'walk_in', NULL, NULL, '2025-11-25 00:21:15', '2026-05-12 13:38:33'),
(31, NULL, 'INV-1764058989-9979', 7, 358.00, 0.00, 400.96, 0.00, 0.00, NULL, 0.00, 'walk_in', NULL, NULL, '2025-11-25 00:23:09', '2026-05-12 13:38:33'),
(32, NULL, 'INV-1764059079-8318', 7, 258.00, 0.00, 288.96, 0.00, 0.00, NULL, 0.00, 'walk_in', NULL, NULL, '2025-11-25 00:24:39', '2026-05-12 13:38:33'),
(33, NULL, 'INV-1764059106-4480', 7, 100.00, 0.00, 112.00, 0.00, 0.00, NULL, 0.00, 'walk_in', NULL, NULL, '2025-11-25 00:25:06', '2026-05-12 13:38:33'),
(34, NULL, 'INV-1764076655-4732', 7, 100.00, 0.00, 112.00, 0.00, 0.00, NULL, 0.00, 'walk_in', NULL, NULL, '2025-11-25 05:17:35', '2026-05-12 13:38:33'),
(35, NULL, 'INV-1764079227-1423', 7, 105.00, 5.00, 100.00, 0.00, 0.00, NULL, 0.00, 'walk_in', NULL, NULL, '2025-11-25 06:00:27', '2026-05-12 13:38:33'),
(36, NULL, 'INV-1764135602-1502', 7, 500.00, 0.00, 500.00, 0.00, 0.00, NULL, 0.00, 'walk_in', NULL, NULL, '2025-11-25 21:40:02', '2026-05-12 13:38:33'),
(37, NULL, 'INV-1764135632-2181', 7, 100.00, 0.00, 100.00, 0.00, 0.00, NULL, 0.00, 'walk_in', NULL, NULL, '2025-11-25 21:40:32', '2026-05-12 13:38:33'),
(38, NULL, 'INV-1764646069-7767', 7, 110.00, 0.00, 110.00, 0.00, 0.00, NULL, 0.00, 'walk_in', NULL, NULL, '2025-12-01 19:27:49', '2026-05-12 13:38:33'),
(39, NULL, 'INV-1764646419-2404', 7, 110.00, 0.00, 110.00, 0.00, 0.00, NULL, 0.00, 'walk_in', NULL, NULL, '2025-12-01 19:33:39', '2026-05-12 13:38:33'),
(40, NULL, 'INV-1764747843-5779', 7, 100.00, 0.00, 100.00, 0.00, 0.00, NULL, 0.00, 'walk_in', NULL, NULL, '2025-12-02 23:44:03', '2026-05-12 13:38:33'),
(41, NULL, 'INV-1764748954-2935', 7, 100.00, 0.00, 100.00, 0.00, 0.00, NULL, 0.00, 'walk_in', NULL, NULL, '2025-12-03 00:02:34', '2026-05-12 13:38:33'),
(42, NULL, 'INV-1764748972-7403', 7, 100.00, 0.00, 100.00, 0.00, 0.00, NULL, 0.00, 'walk_in', NULL, NULL, '2025-12-03 00:02:52', '2026-05-12 13:38:33'),
(43, NULL, 'INV-1764749460-7850', 7, 100.00, 0.00, 100.00, 0.00, 0.00, NULL, 0.00, 'walk_in', NULL, NULL, '2025-12-03 00:11:00', '2026-05-12 13:38:33'),
(44, NULL, 'INV-1764750567-7600', 7, 100.00, 0.00, 100.00, 0.00, 0.00, NULL, 0.00, 'walk_in', NULL, NULL, '2025-12-03 00:29:27', '2026-05-12 13:38:33'),
(45, NULL, 'INV-1765509727-9486', 7, 100.00, 0.00, 100.00, 0.00, 0.00, NULL, 0.00, 'walk_in', NULL, NULL, '2025-12-11 19:22:07', '2026-05-12 13:38:33'),
(46, NULL, 'INV-1765512012-7891', 7, 300.00, 0.00, 300.00, 0.00, 0.00, NULL, 0.00, 'walk_in', NULL, NULL, '2025-12-11 20:00:12', '2026-05-12 13:38:33'),
(47, NULL, 'INV-1765512042-3916', 7, 105.00, 0.00, 105.00, 0.00, 0.00, NULL, 0.00, 'walk_in', NULL, NULL, '2025-12-11 20:00:42', '2026-05-12 13:38:33'),
(48, NULL, 'INV-1765512990-7460', 7, 550.00, 5.00, 545.00, 0.00, 0.00, NULL, 0.00, 'walk_in', NULL, NULL, '2025-12-11 20:16:30', '2026-05-12 13:38:33'),
(49, NULL, 'INV-1765513015-9934', 7, 500.00, 0.00, 500.00, 0.00, 0.00, NULL, 0.00, 'walk_in', NULL, NULL, '2025-12-11 20:16:55', '2026-05-12 13:38:33'),
(50, NULL, 'INV-1766743547-4559', 7, 10.00, 0.00, 10.00, 0.00, 0.00, NULL, 0.00, 'walk_in', NULL, NULL, '2025-12-26 02:05:47', '2026-05-12 13:38:33'),
(51, NULL, 'INV-1766744027-5517', 7, 3000.00, 0.00, 3000.00, 4000.00, 1000.00, NULL, 0.00, 'walk_in', NULL, NULL, '2025-12-26 02:13:47', '2026-05-12 13:38:33'),
(52, NULL, 'INV-1766916685-8579', 7, 1000.00, 0.00, 1000.00, 1000.00, 0.00, NULL, 0.00, 'walk_in', NULL, NULL, '2025-12-28 02:11:25', '2026-05-12 13:38:33'),
(53, NULL, 'INV-1766916732-9577', 7, 100.00, 0.00, 100.00, 100.00, 0.00, NULL, 0.00, 'walk_in', NULL, NULL, '2025-12-28 02:12:12', '2026-05-12 13:38:33'),
(54, NULL, 'INV-1766916988-8507', 7, 100.00, 0.00, 100.00, 200.00, 100.00, NULL, 0.00, 'walk_in', NULL, NULL, '2025-12-28 02:16:28', '2026-05-12 13:38:33'),
(55, NULL, 'INV-1766919777-9430', 7, 90.00, 10.00, 80.00, 100.00, 20.00, NULL, 0.00, 'walk_in', NULL, NULL, '2025-12-28 03:02:57', '2026-05-12 13:38:33'),
(63, NULL, 'INV-1767090698-9365', 7, 9.00, 1.80, 7.20, 9.00, 1.80, NULL, 0.00, 'walk_in', NULL, NULL, '2025-12-30 02:31:38', '2026-05-12 13:38:33'),
(64, NULL, 'INV-1767506676-7962', 7, 10.00, 2.00, 8.00, 10.00, 2.00, NULL, 0.00, 'walk_in', NULL, NULL, '2026-01-03 22:04:36', '2026-05-12 13:38:33'),
(65, NULL, 'INV-1767508551-4954', 7, 10.00, 2.00, 8.00, 20.00, 12.00, NULL, 0.00, 'walk_in', NULL, NULL, '2026-01-03 22:35:51', '2026-05-12 13:38:33'),
(66, NULL, 'INV-1767509324-3110', 7, 10.00, 2.00, 8.00, 50.00, 42.00, NULL, 0.00, 'walk_in', NULL, NULL, '2026-01-03 22:48:44', '2026-05-12 13:38:33'),
(67, NULL, 'INV-1767513482-3395', 7, 10.00, 2.00, 8.00, 100.00, 92.00, NULL, 20.00, 'pwd', NULL, NULL, '2026-01-03 23:58:02', '2026-05-12 13:38:33'),
(68, NULL, 'INV-1767516565-3828', 7, 10.00, 2.00, 8.00, 20.00, 12.00, NULL, 20.00, 'senior_citizens', NULL, NULL, '2026-01-04 00:49:25', '2026-05-12 13:38:33'),
(69, NULL, 'INV-1767517945-2329', 7, 10.00, 2.00, 8.00, 10.00, 2.00, NULL, 20.00, 'pwd', NULL, NULL, '2026-01-04 01:12:25', '2026-05-12 13:38:33'),
(70, NULL, 'INV-1767518943-9857', 7, 10.00, 0.00, 10.00, 10.00, 0.00, NULL, 0.00, 'walk_in', NULL, NULL, '2026-01-04 01:29:03', '2026-05-12 13:38:33'),
(71, NULL, 'INV-1767519150-2933', 7, 10.00, 0.00, 10.00, 10.00, 0.00, NULL, 0.00, 'walk_in', NULL, NULL, '2026-01-04 01:32:30', '2026-05-12 13:38:33'),
(72, NULL, 'INV-1767519219-8134', 7, 10.00, 0.00, 10.00, 10.00, 0.00, NULL, 0.00, 'walk_in', NULL, NULL, '2026-01-04 01:33:39', '2026-05-12 13:38:33'),
(73, NULL, 'INV-1767520344-3189', 7, 10.00, 0.00, 10.00, 10.00, 0.00, NULL, 0.00, 'walk_in', NULL, NULL, '2026-01-04 09:52:24', '2026-05-12 13:38:33'),
(74, NULL, 'INV-1768559903-1264', 7, 194.00, 38.80, 155.20, 500.00, 344.80, NULL, 20.00, 'pwd', NULL, NULL, '2026-01-16 10:38:23', '2026-01-16 10:38:23'),
(75, NULL, 'INV-1768560065-2303', 7, 7.00, 1.40, 5.60, 50.00, 44.40, NULL, 20.00, 'senior_citizens', NULL, NULL, '2026-01-16 10:41:05', '2026-01-16 10:41:05'),
(76, NULL, 'INV-1768578612-7546', 7, 4800.00, 0.00, 4800.00, 5000.00, 200.00, NULL, 0.00, 'walk_in', NULL, NULL, '2026-01-16 15:50:12', '2026-01-16 15:50:12'),
(77, NULL, 'INV-1768578643-7107', 7, 900.00, 0.00, 900.00, 900.00, 0.00, NULL, 0.00, 'walk_in', NULL, NULL, '2026-01-16 15:50:43', '2026-01-16 15:50:43'),
(78, NULL, 'INV-1768578661-2602', 7, 60.00, 0.00, 60.00, 60.00, 0.00, NULL, 0.00, 'walk_in', NULL, NULL, '2026-01-16 15:51:01', '2026-01-16 15:51:01'),
(79, NULL, 'INV-1768578735-5247', 7, 120.00, 0.00, 120.00, 120.00, 0.00, NULL, 0.00, 'walk_in', NULL, NULL, '2026-01-16 15:52:15', '2026-01-16 15:52:15'),
(80, NULL, 'INV-1768579854-2670', 7, 7.00, 0.00, 7.00, 7.00, 0.00, NULL, 0.00, 'walk_in', NULL, NULL, '2026-01-16 16:10:54', '2026-01-16 16:10:54'),
(81, NULL, 'INV-1768616324-1114', 7, 100.00, 20.00, 80.00, 100.00, 20.00, 5, 20.00, 'pwd', NULL, NULL, '2026-01-17 02:18:44', '2026-01-17 02:18:44'),
(82, NULL, 'INV-1774353510-4647', 7, 100.00, 20.00, 80.00, 100.00, 20.00, 4, 20.00, 'senior_citizens', NULL, NULL, '2026-03-24 11:58:30', '2026-03-24 11:58:30'),
(83, NULL, 'INV-1774353757-4341', 7, 7.00, 1.40, 5.60, 10.00, 4.40, 4, 20.00, 'senior_citizens', NULL, NULL, '2026-03-24 12:02:37', '2026-03-24 12:02:37'),
(84, NULL, 'INV-1775138385-8278', 24, 200.00, 0.00, 200.00, 650.00, 450.00, NULL, 0.00, 'walk_in', NULL, NULL, '2026-04-02 13:59:45', '2026-04-02 13:59:45'),
(85, NULL, 'INV-20260403-0911', 14, 75.00, 0.00, 75.00, 120.00, 45.00, NULL, 0.00, 'regular', NULL, NULL, '2026-04-03 03:45:48', '2026-04-03 03:45:48'),
(86, NULL, 'INV-20260403-3468', 23, 157.50, 31.50, 126.00, 1120.00, 994.00, 4, 20.00, 'senior_citizens', 'Senior Citizens (20.00% off)', 'SC-2020-12345', '2026-04-03 03:50:02', '2026-04-03 03:50:02'),
(87, NULL, 'INV-20260403-4901', 14, 22.68, 4.54, 18.14, 120.00, 101.86, 4, 20.00, 'senior_citizens', 'Senior Citizens (20.00% off)', 'OSCA-2024-001234', '2026-04-03 04:03:53', '2026-04-03 04:03:53'),
(88, NULL, 'INV-20260403-7073', 14, 17.01, 0.00, 17.01, 20.00, 2.99, NULL, 0.00, 'regular', NULL, NULL, '2026-04-03 06:22:42', '2026-04-03 06:22:42'),
(89, NULL, 'INV-20260403-5623', 14, 24.00, 0.00, 24.00, 30.00, 6.00, NULL, 0.00, 'regular', NULL, NULL, '2026-04-03 06:26:15', '2026-04-03 06:26:15'),
(90, NULL, 'INV-20260403-8529', 14, 25.00, 0.00, 25.00, 30.00, 5.00, NULL, 0.00, 'regular', NULL, NULL, '2026-04-03 06:36:30', '2026-04-03 06:36:30'),
(91, NULL, 'INV-20260403-0923', 14, 37.00, 0.00, 37.00, 40.00, 3.00, NULL, 0.00, 'regular', NULL, NULL, '2026-04-03 06:39:24', '2026-04-03 06:39:24'),
(92, NULL, 'INV-20260403-3677', 14, 36.00, 0.00, 36.00, 42.00, 6.00, NULL, 0.00, 'regular', NULL, NULL, '2026-04-03 06:43:05', '2026-04-03 06:43:05'),
(93, NULL, 'INV-20260403-5308', 14, 50.00, 0.00, 50.00, 50.00, 0.00, NULL, 0.00, 'regular', NULL, NULL, '2026-04-03 06:43:35', '2026-04-03 06:43:35'),
(94, NULL, 'INV-20260403-9193', 14, 72.00, 0.00, 72.00, 80.00, 8.00, NULL, 0.00, 'regular', NULL, NULL, '2026-04-03 06:51:44', '2026-04-03 06:51:44'),
(95, NULL, 'INV-20260403-2214', 14, 24.00, 0.00, 24.00, 30.00, 6.00, NULL, 0.00, 'regular', NULL, NULL, '2026-04-03 06:53:21', '2026-04-03 06:53:21'),
(96, NULL, 'INV-20260403-6543', 14, 24.00, 0.00, 24.00, 30.00, 6.00, NULL, 0.00, 'regular', NULL, NULL, '2026-04-03 08:05:38', '2026-04-03 08:05:38'),
(97, NULL, 'INV-20260403-9052', 14, 36.00, 7.20, 28.80, 50.00, 21.20, 4, 20.00, 'senior_citizens', 'Senior Citizens (20.00% off)', 'OSCA-1234-5678', '2026-04-03 08:08:54', '2026-04-03 08:08:54'),
(98, NULL, 'INV-20260403-5058', 14, 24.00, 0.00, 24.00, 300.00, 276.00, NULL, 0.00, 'regular', NULL, NULL, '2026-04-03 12:15:34', '2026-04-03 12:15:34'),
(99, NULL, 'INV-20260403-3190', 14, 47.01, 9.40, 37.61, 50.00, 12.39, 4, 20.00, 'senior_citizens', 'Senior Citizens (20.00% off)', 'OSCA-2024-001234', '2026-04-03 12:15:49', '2026-04-03 12:15:49'),
(100, NULL, 'INV-20260404-7484', 14, 15.00, 0.00, 15.00, 60.00, 45.00, NULL, 0.00, 'regular', NULL, NULL, '2026-04-04 01:00:49', '2026-04-04 01:00:49'),
(101, NULL, 'INV-20260404-8515', 14, 300.00, 0.00, 300.00, 1220.00, 920.00, NULL, 0.00, 'regular', NULL, NULL, '2026-04-04 02:16:06', '2026-04-04 02:16:06'),
(102, NULL, 'INV-20260404-1220', 14, 22.68, 0.00, 22.68, 2220.00, 2197.32, NULL, 0.00, 'regular', NULL, NULL, '2026-04-04 02:16:14', '2026-04-04 02:16:14'),
(103, NULL, 'INV-20260404-0489', 14, 80.00, 0.00, 80.00, 220.00, 140.00, NULL, 0.00, 'regular', NULL, NULL, '2026-04-04 02:16:22', '2026-04-04 02:16:22'),
(104, NULL, 'INV-20260404-8765', 14, 40.00, 0.00, 40.00, 2220.00, 2180.00, NULL, 0.00, 'regular', NULL, NULL, '2026-04-04 02:16:31', '2026-04-04 02:16:31'),
(105, NULL, 'INV-20260404-0086', 14, 30.00, 0.00, 30.00, 660.00, 630.00, NULL, 0.00, 'regular', NULL, NULL, '2026-04-04 02:33:28', '2026-04-04 02:33:28'),
(106, NULL, 'INV-20260404-3510', 14, 25.00, 0.00, 25.00, 40.00, 15.00, NULL, 0.00, 'regular', NULL, NULL, '2026-04-04 02:36:50', '2026-04-04 02:36:50'),
(107, NULL, 'INV-20260404-4433', 24, 20.00, 0.00, 20.00, 20.00, 0.00, NULL, 0.00, 'regular', NULL, NULL, '2026-04-04 06:02:35', '2026-04-04 06:02:35'),
(108, NULL, 'INV-20260405-8259', 24, 30.00, 0.00, 30.00, 120.00, 90.00, NULL, 0.00, 'regular', NULL, NULL, '2026-04-04 18:21:14', '2026-04-04 18:21:14'),
(109, NULL, 'INV-20260406-8837', 14, 22.68, 4.54, 18.14, 33330.00, 33311.86, 4, 20.00, 'senior_citizens', 'Senior Citizens (20.00% off)', 'OSCA-1234-5678', '2026-04-06 01:30:27', '2026-04-06 01:30:27'),
(110, NULL, 'INV-20260406-1499', 24, 37.50, 7.50, 30.00, 50.00, 20.00, 4, 20.00, 'senior_citizens', 'Senior Citizens (20.00% off)', 'OSCA-1234-5678', '2026-04-06 02:56:48', '2026-04-06 02:56:48'),
(111, NULL, 'INV-20260406-5547', 7, 30.00, 0.00, 30.00, 40.00, 10.00, NULL, 0.00, 'regular', NULL, NULL, '2026-04-06 03:08:14', '2026-05-12 13:38:33'),
(112, NULL, 'INV-20260406-0804', 24, 6775.00, 0.00, 6775.00, 10000.00, 3225.00, NULL, 0.00, 'regular', NULL, NULL, '2026-04-06 06:17:57', '2026-04-06 06:17:57'),
(113, NULL, 'INV-20260406-2526', 24, 47425.00, 0.00, 47425.00, 111110.00, 63685.00, NULL, 0.00, 'regular', NULL, NULL, '2026-04-06 06:18:48', '2026-04-06 06:18:48'),
(114, NULL, 'INV-20260428-5781', 7, 100.00, 0.00, 100.00, 100.00, 0.00, NULL, 0.00, 'regular', NULL, NULL, '2026-04-28 13:25:51', '2026-04-28 13:25:51'),
(115, NULL, 'INV-20260504-6448', 14, 200.00, 0.00, 200.00, 200.00, 0.00, NULL, 0.00, 'regular', NULL, NULL, '2026-05-04 09:14:12', '2026-05-04 09:14:12'),
(116, NULL, 'INV-20260504-7536', 14, 25.00, 0.00, 25.00, 100.00, 75.00, NULL, 0.00, 'regular', NULL, NULL, '2026-05-04 09:15:20', '2026-05-04 09:15:20'),
(117, NULL, 'INV-20260505-0153', 14, 162.00, 0.00, 162.00, 200.00, 38.00, NULL, 0.00, 'regular', NULL, NULL, '2026-05-05 12:19:25', '2026-05-05 12:19:25'),
(118, NULL, 'INV-20260505-1270', 14, 162.00, 32.40, 129.60, 300.00, 170.40, 4, 20.00, 'senior_citizens', 'Senior Citizens (20.00% off)', 'OSCA-1234-5678', '2026-05-05 12:55:47', '2026-05-05 12:55:47'),
(119, NULL, 'INV-20260506-6820', 7, 100.00, 0.00, 100.00, 200.00, 100.00, NULL, 0.00, 'regular', NULL, NULL, '2026-05-06 05:59:47', '2026-05-06 05:59:47'),
(120, NULL, 'INV-20260507-3404', 14, 120.00, 0.00, 120.00, 500.00, 380.00, NULL, 0.00, 'regular', NULL, NULL, '2026-05-07 10:11:18', '2026-05-07 10:11:18'),
(121, NULL, 'INV-20260507-6294', 14, 120.00, 0.00, 120.00, 300.00, 180.00, NULL, 0.00, 'regular', NULL, NULL, '2026-05-07 10:20:28', '2026-05-07 10:20:28'),
(122, NULL, 'INV-20260507-9131', 14, 120.00, 0.00, 120.00, 120.00, 0.00, NULL, 0.00, 'regular', NULL, NULL, '2026-05-07 10:22:18', '2026-05-07 10:22:18'),
(123, NULL, 'INV-20260507-9729', 14, 120.00, 0.00, 120.00, 150.00, 30.00, NULL, 0.00, 'regular', NULL, NULL, '2026-05-07 10:25:50', '2026-05-07 10:25:50'),
(124, NULL, 'INV-20260509-7188', 7, 120.00, 0.00, 120.00, 150.00, 30.00, NULL, 0.00, 'regular', NULL, NULL, '2026-05-09 13:44:46', '2026-05-09 13:44:46'),
(125, NULL, 'INV-20260512-7980', 14, 120.00, 0.00, 120.00, 200.00, 80.00, NULL, 0.00, 'regular', NULL, NULL, '2026-05-12 13:26:53', '2026-05-12 13:26:53'),
(126, 8, 'INV-20260517-8145', 7, 50.00, 0.00, 50.00, 100.00, 50.00, NULL, 0.00, 'regular', NULL, NULL, '2026-05-17 12:42:25', '2026-05-17 12:42:25'),
(127, 8, 'INV-20260517-3161', 7, 1450.00, 0.00, 1450.00, 2000.00, 550.00, NULL, 0.00, 'regular', NULL, NULL, '2026-05-17 12:44:19', '2026-05-17 12:44:19'),
(128, NULL, 'INV-20260517-0432', 7, 50.00, 0.00, 50.00, 100.00, 50.00, NULL, 0.00, 'regular', NULL, NULL, '2026-05-17 12:46:03', '2026-05-17 12:46:03'),
(129, NULL, 'INV-20260517-3233', 7, 120.00, 0.00, 120.00, 200.00, 80.00, NULL, 0.00, 'regular', NULL, NULL, '2026-05-17 12:49:09', '2026-05-17 12:49:09'),
(130, NULL, 'INV-20260517-5256', 7, 120.00, 0.00, 120.00, 200.00, 80.00, NULL, 0.00, 'regular', NULL, NULL, '2026-05-17 12:49:51', '2026-05-17 12:49:51'),
(131, NULL, 'INV-20260517-3037', 7, 120.00, 0.00, 120.00, 200.00, 80.00, NULL, 0.00, 'regular', NULL, NULL, '2026-05-17 12:51:41', '2026-05-17 12:51:41'),
(132, NULL, 'INV-20260517-2998', 7, 120.00, 0.00, 120.00, 200.00, 80.00, NULL, 0.00, 'regular', NULL, NULL, '2026-05-17 13:02:45', '2026-05-17 13:02:45'),
(133, NULL, 'INV-20260517-5938', 7, 120.00, 0.00, 120.00, 200.00, 80.00, NULL, 0.00, 'regular', NULL, NULL, '2026-05-17 13:03:42', '2026-05-17 13:03:42'),
(134, NULL, 'INV-20260517-7375', 7, 120.00, 0.00, 120.00, 200.00, 80.00, NULL, 0.00, 'regular', NULL, NULL, '2026-05-17 13:09:04', '2026-05-17 13:09:04'),
(135, 9, 'INV-20260517-0945', 7, 120.00, 0.00, 120.00, 200.00, 80.00, NULL, 0.00, 'regular', NULL, NULL, '2026-05-17 13:13:55', '2026-05-17 13:13:55'),
(136, 9, 'INV-20260518-7381', 7, 120.00, 0.00, 120.00, 200.00, 80.00, NULL, 0.00, 'regular', NULL, NULL, '2026-05-18 12:14:35', '2026-05-18 12:14:35'),
(137, NULL, 'INV-20260518-6931', 7, 50.00, 0.00, 50.00, 100.00, 50.00, NULL, 0.00, 'regular', NULL, NULL, '2026-05-18 15:25:40', '2026-05-18 15:25:40'),
(138, NULL, 'INV-20260528-0135', 14, 30.00, 0.00, 30.00, 50.00, 20.00, NULL, 0.00, 'regular', NULL, NULL, '2026-05-28 09:00:13', '2026-05-28 09:00:13'),
(139, NULL, 'INV-20260528-8718', 14, 100.00, 20.00, 80.00, 100.00, 20.00, 4, 20.00, 'senior_citizens', 'Senior Citizens (20.00% off)', 'OSCA-1234-5678', '2026-05-28 10:09:42', '2026-05-28 10:09:42'),
(140, NULL, 'INV-20260528-7250', 14, 55.00, 0.00, 55.00, 100.00, 45.00, NULL, 0.00, 'regular', NULL, NULL, '2026-05-28 14:37:14', '2026-05-28 14:37:14'),
(141, NULL, 'INV-20260529-8436', 14, 5.00, 0.00, 5.00, 10.00, 5.00, NULL, 0.00, 'regular', NULL, NULL, '2026-05-28 22:28:55', '2026-05-28 22:28:55'),
(142, NULL, 'INV-20260529-7218', 14, 5.00, 0.00, 5.00, 10.00, 5.00, NULL, 0.00, 'regular', NULL, NULL, '2026-05-28 22:29:55', '2026-05-28 22:29:55'),
(143, NULL, 'INV-20260529-8124', 14, 5.00, 0.00, 5.00, 10.00, 5.00, NULL, 0.00, 'regular', NULL, NULL, '2026-05-28 22:30:27', '2026-05-28 22:30:27'),
(144, NULL, 'INV-20260529-6341', 14, 5.00, 0.00, 5.00, 5.00, 0.00, NULL, 0.00, 'regular', NULL, NULL, '2026-05-28 22:34:37', '2026-05-28 22:34:37'),
(145, NULL, 'INV-20260529-8475', 14, 5.00, 0.00, 5.00, 10.00, 5.00, NULL, 0.00, 'regular', NULL, NULL, '2026-05-28 22:51:20', '2026-05-28 22:51:20'),
(146, NULL, 'INV-20260529-5894', 7, 5.00, 0.00, 5.00, 10.00, 5.00, NULL, 0.00, 'regular', NULL, NULL, '2026-05-29 02:09:20', '2026-05-29 02:09:20'),
(147, 10, 'INV-20260529-7433', 7, 5.00, 0.00, 5.00, 10.00, 5.00, NULL, 0.00, 'regular', NULL, NULL, '2026-05-29 02:10:48', '2026-05-29 02:10:48'),
(148, 10, 'INV-20260529-8940', 14, 100.00, 0.00, 100.00, 100.00, 0.00, NULL, 0.00, 'regular', NULL, NULL, '2026-05-29 03:13:12', '2026-05-29 03:13:12');

-- --------------------------------------------------------

--
-- Table structure for table `sale_items`
--

CREATE TABLE `sale_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sale_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` decimal(10,2) DEFAULT 0.00,
  `original_price` decimal(10,2) DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT 0.00,
  `sell_type` enum('piece','box') DEFAULT 'piece',
  `pieces_per_box` int(11) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `discount_percent` decimal(5,2) DEFAULT 0.00,
  `discount_amount` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sale_items`
--

INSERT INTO `sale_items` (`id`, `sale_id`, `product_id`, `quantity`, `unit_price`, `original_price`, `total_price`, `sell_type`, `pieces_per_box`, `created_at`, `updated_at`, `discount_percent`, `discount_amount`) VALUES
(124, 119, 127, 2, 50.00, 50.00, 100.00, 'piece', 1, '2026-05-06 05:59:47', '2026-05-06 05:59:47', 0.00, 0.00),
(125, 120, 128, 1, 120.00, 120.00, 120.00, 'piece', 1, '2026-05-07 10:11:18', '2026-05-07 10:11:18', 0.00, 0.00),
(126, 121, 128, 1, 120.00, 120.00, 120.00, 'piece', 1, '2026-05-07 10:20:28', '2026-05-07 10:20:28', 0.00, 0.00),
(127, 122, 128, 1, 120.00, 120.00, 120.00, 'piece', 1, '2026-05-07 10:22:18', '2026-05-07 10:22:18', 0.00, 0.00),
(128, 123, 128, 1, 120.00, 120.00, 120.00, 'piece', 1, '2026-05-07 10:25:50', '2026-05-07 10:25:50', 0.00, 0.00),
(129, 124, 128, 1, 120.00, 120.00, 120.00, 'piece', 1, '2026-05-09 13:44:46', '2026-05-09 13:44:46', 0.00, 0.00),
(130, 125, 128, 1, 120.00, 120.00, 120.00, 'piece', 1, '2026-05-12 13:26:53', '2026-05-12 13:26:53', 0.00, 0.00),
(131, 126, 127, 1, 50.00, 50.00, 50.00, 'piece', 1, '2026-05-17 12:42:25', '2026-05-17 12:42:25', 0.00, 0.00),
(132, 127, 127, 29, 50.00, 50.00, 1450.00, 'piece', 1, '2026-05-17 12:44:19', '2026-05-17 12:44:19', 0.00, 0.00),
(133, 128, 127, 1, 50.00, 50.00, 50.00, 'piece', 1, '2026-05-17 12:46:03', '2026-05-17 12:46:03', 0.00, 0.00),
(134, 129, 128, 1, 120.00, 120.00, 120.00, 'piece', 1, '2026-05-17 12:49:09', '2026-05-17 12:49:09', 0.00, 0.00),
(135, 130, 128, 1, 120.00, 120.00, 120.00, 'piece', 1, '2026-05-17 12:49:51', '2026-05-17 12:49:51', 0.00, 0.00),
(136, 131, 128, 1, 120.00, 120.00, 120.00, 'piece', 1, '2026-05-17 12:51:41', '2026-05-17 12:51:41', 0.00, 0.00),
(137, 132, 128, 1, 120.00, 120.00, 120.00, 'piece', 1, '2026-05-17 13:02:45', '2026-05-17 13:02:45', 0.00, 0.00),
(138, 133, 128, 1, 120.00, 120.00, 120.00, 'piece', 1, '2026-05-17 13:03:42', '2026-05-17 13:03:42', 0.00, 0.00),
(139, 134, 128, 1, 120.00, 120.00, 120.00, 'piece', 1, '2026-05-17 13:09:04', '2026-05-17 13:09:04', 0.00, 0.00),
(140, 135, 128, 1, 120.00, 120.00, 120.00, 'piece', 1, '2026-05-17 13:13:55', '2026-05-17 13:13:55', 0.00, 0.00),
(141, 136, 128, 1, 120.00, 120.00, 120.00, 'piece', 1, '2026-05-18 12:14:35', '2026-05-18 12:14:35', 0.00, 0.00),
(142, 137, 127, 1, 50.00, 50.00, 50.00, 'piece', 1, '2026-05-18 15:25:40', '2026-05-18 15:25:40', 0.00, 0.00),
(143, 138, 125, 3, 10.00, 10.00, 30.00, 'piece', 1, '2026-05-28 09:00:13', '2026-05-28 09:00:13', 0.00, 0.00),
(144, 139, 127, 2, 50.00, 50.00, 100.00, 'piece', 1, '2026-05-28 10:09:42', '2026-05-28 10:09:42', 0.00, 0.00),
(145, 140, 127, 1, 50.00, 50.00, 50.00, 'piece', 1, '2026-05-28 14:37:14', '2026-05-28 14:37:14', 0.00, 0.00),
(146, 140, 129, 1, 5.00, 5.00, 5.00, 'piece', 1, '2026-05-28 14:37:14', '2026-05-28 14:37:14', 0.00, 0.00),
(147, 141, 129, 1, 5.00, 5.00, 5.00, 'piece', 1, '2026-05-28 22:28:55', '2026-05-28 22:28:55', 0.00, 0.00),
(148, 142, 129, 1, 5.00, 5.00, 5.00, 'piece', 1, '2026-05-28 22:29:55', '2026-05-28 22:29:55', 0.00, 0.00),
(149, 143, 129, 1, 5.00, 5.00, 5.00, 'piece', 1, '2026-05-28 22:30:27', '2026-05-28 22:30:27', 0.00, 0.00),
(150, 144, 129, 1, 5.00, 5.00, 5.00, 'piece', 1, '2026-05-28 22:34:37', '2026-05-28 22:34:37', 0.00, 0.00),
(151, 145, 129, 1, 5.00, 5.00, 5.00, 'piece', 1, '2026-05-28 22:51:20', '2026-05-28 22:51:20', 0.00, 0.00),
(152, 146, 129, 1, 5.00, 5.00, 5.00, 'piece', 1, '2026-05-29 02:09:20', '2026-05-29 02:09:20', 0.00, 0.00),
(153, 147, 129, 1, 5.00, 5.00, 5.00, 'piece', 1, '2026-05-29 02:10:48', '2026-05-29 02:10:48', 0.00, 0.00),
(154, 148, 127, 2, 50.00, 50.00, 100.00, 'piece', 1, '2026-05-29 03:13:12', '2026-05-29 03:13:12', 0.00, 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(50) DEFAULT NULL,
  `value` text DEFAULT NULL,
  `group` varchar(30) DEFAULT NULL,
  `type` varchar(20) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `description`, `created_at`, `updated_at`) VALUES
(1, 'pharmacy_name', '\"AERPharmacy\"', 'general', 'text', NULL, NULL, '2026-04-27 08:21:47'),
(2, 'pharmacy_address', '\"Brgy. Kanluran Calauan, Laguna\"', 'general', 'textarea', NULL, NULL, '2026-04-03 22:01:36'),
(3, 'pharmacy_contact', '\"123-456-7890\"', 'general', 'text', NULL, NULL, '2026-04-03 21:57:10'),
(4, 'pharmacy_email', '\"aerpharmacy@gmail.com\"', 'general', 'email', NULL, NULL, '2026-04-27 08:21:47'),
(5, 'pharmacy_tin', '\"123-456-789-000\"', 'general', 'text', NULL, NULL, '2026-04-03 21:57:10'),
(6, 'system_name', '\"Pharmacy System\"', 'general', 'text', NULL, NULL, '2026-04-03 21:57:10'),
(7, 'timezone', '\"Asia\\/Manila\"', 'general', 'select', NULL, NULL, '2026-04-03 21:57:10'),
(8, 'date_format', '\"m\\/d\\/Y\"', 'general', 'select', NULL, NULL, '2026-04-03 22:01:36'),
(9, 'currency_symbol', '\"\"', 'general', 'text', NULL, NULL, '2026-04-03 21:57:10'),
(10, 'maintenance_mode', '\"0\"', 'general', 'select', NULL, '2026-04-03 21:57:10', '2026-04-04 09:28:40'),
(11, 'maintenance_message', '\"System is under maintenance. Please check back later.\"', 'general', 'textarea', NULL, '2026-04-03 21:57:10', '2026-04-03 22:01:36'),
(12, 'backup_schedule', '\"daily\"', 'general', 'select', NULL, '2026-04-03 21:57:10', '2026-04-03 22:01:37'),
(13, 'backup_retention', '\"30\"', 'general', 'number', NULL, '2026-04-03 21:57:10', '2026-04-03 22:01:37'),
(14, 'debug_mode', '\"1\"', 'general', 'text', NULL, '2026-04-03 22:01:36', '2026-04-03 22:01:36'),
(15, 'pharmacy_logo', '\"logos\\/logo_1780024818.png\"', 'general', 'text', NULL, '2026-04-03 22:17:28', '2026-05-29 03:20:19');

-- --------------------------------------------------------

--
-- Table structure for table `stock_queues`
--

CREATE TABLE `stock_queues` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `brand` varchar(255) DEFAULT NULL,
  `dosage` varchar(255) DEFAULT NULL,
  `dosage_amount` varchar(50) DEFAULT NULL,
  `dosage_unit` varchar(20) DEFAULT NULL,
  `form` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `pieces_per_box` int(11) DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `total_pieces` int(11) NOT NULL,
  `arrival_date` datetime DEFAULT NULL,
  `status` enum('pending','in_queue','transferred') NOT NULL DEFAULT 'pending',
  `added_by` bigint(20) UNSIGNED DEFAULT NULL,
  `transferred_at` datetime DEFAULT NULL,
  `transferred_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stock_queues`
--

INSERT INTO `stock_queues` (`id`, `product_id`, `product_name`, `brand`, `dosage`, `dosage_amount`, `dosage_unit`, `form`, `type`, `category`, `price`, `pieces_per_box`, `expiry_date`, `quantity`, `total_pieces`, `arrival_date`, `status`, `added_by`, `transferred_at`, `transferred_by`, `created_at`, `updated_at`) VALUES
(3, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 20, NULL, 3, 60, '2025-12-11 16:19:00', 'transferred', 5, '2025-12-23 18:21:49', 5, '2025-12-11 00:19:51', '2025-12-23 10:21:49'),
(4, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 20, NULL, 20, 400, '2025-12-12 11:17:00', 'transferred', 5, '2025-12-24 02:40:18', 5, '2025-12-11 19:17:25', '2025-12-23 18:40:18'),
(5, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 16, NULL, 10, 160, '2025-12-19 11:44:00', 'transferred', 6, '2025-12-20 14:01:22', 5, '2025-12-11 19:45:16', '2025-12-20 06:01:22'),
(6, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, 15, 150, '2025-12-20 11:46:00', 'transferred', 6, '2025-12-20 14:00:41', 5, '2025-12-11 19:47:06', '2025-12-20 06:00:41'),
(11, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 30, NULL, 10, 300, '2025-12-22 00:04:00', 'transferred', 5, '2025-12-21 16:04:39', 5, '2025-12-21 08:04:30', '2025-12-21 08:04:39'),
(12, 80, 'Biogesic', 'Unilab', NULL, '50', 'mg', 'Tablet', 'Generic', 'Antibiotics', 10.00, 10, '2026-07-24', 15, 150, '2025-12-24 11:21:00', 'transferred', 5, '2025-12-24 03:22:28', 5, '2025-12-23 19:21:46', '2025-12-23 19:22:28'),
(15, 81, 'Neozep', 'Unilab', NULL, '200.00', 'mg', 'Tablet', 'Generic', 'Paracetamol', 10.00, 10, '2026-06-24', 20, 200, '2025-12-27 00:00:00', 'transferred', 5, '2025-12-26 07:43:17', 5, '2025-12-25 23:42:15', '2025-12-25 23:43:17'),
(19, 85, 'Amoxicillin', 'RiteMed', NULL, '500.00', 'mg', 'Capsule', 'Branded', 'Analgesic / Antipyretic', 12.00, 100, '2027-05-16', 10, 1000, '2026-01-17 00:00:00', 'transferred', 7, '2026-01-17 02:15:59', 7, '2026-01-16 18:15:23', '2026-01-16 18:15:59'),
(20, 84, 'Solmux', 'Unilab', NULL, '500.00', 'mg', 'Capsule', 'Generic', 'Mucolytic', 12.50, 100, '2026-07-15', 10, 1000, '2026-03-14 00:00:00', 'transferred', 7, '2026-03-14 08:12:27', 7, '2026-03-14 00:12:18', '2026-03-14 00:12:27'),
(24, 95, 'Paracetamol', 'Biogesic', NULL, '500.00', 'mg', 'Tablet', 'Generic', 'Antibiotics', 7.00, 100, '2026-04-22', 10, 1000, '2026-04-24 00:00:00', 'transferred', 7, '2026-04-05 11:31:30', 7, '2026-04-05 03:31:14', '2026-04-05 03:31:30'),
(27, 98, 'geline', 'Unilab', NULL, '70', 'mg', 'Tablet', 'Generic', 'Antibiotics', 10.00, 100, '2026-11-30', 20, 2000, '2026-04-05 00:00:00', 'transferred', 7, '2026-04-05 15:07:50', 7, '2026-04-05 06:52:55', '2026-04-05 07:07:50'),
(28, 99, 'geline', 'Unilab', NULL, '70', 'ml', 'Tablet', 'Generic', 'Antibiotics', 100.00, 100, '2027-09-28', 20, 2000, '2027-01-05 00:00:00', 'transferred', 7, '2026-04-05 15:08:04', 7, '2026-04-05 06:54:12', '2026-04-05 07:08:04'),
(29, 102, 'Biogesic', 'Unilab', NULL, '3', 'mg', 'Tablet', 'Generic', 'Antibiotics', 3.00, 10, '2027-01-06', 1, 10, '2026-04-06 00:00:00', 'transferred', 24, '2026-04-06 03:53:21', 24, '2026-04-05 19:50:05', '2026-04-05 19:53:21'),
(32, 103, 'Biogesic', 'Unilab', NULL, '50', 'ml', 'Tablet', 'Generic', 'Antibiotics', 12.00, 10, '2030-07-17', 2000, 20000, '2027-04-06 00:00:00', 'transferred', 24, '2026-04-06 04:01:57', 24, '2026-04-05 19:58:21', '2026-04-05 20:01:57'),
(40, 109, 'Paracetamol', 'Biogesic', NULL, '5', 'ml', 'Capsule', 'Generic', 'Mucolytic', 5.00, 3, '2026-12-25', 123, 369, '2026-04-06 00:00:00', 'transferred', 24, '2026-04-06 05:53:20', 24, '2026-04-05 21:34:46', '2026-04-05 21:53:20'),
(41, 120, 'Biogesic', 'Unilab', NULL, '200', 'mg', 'Tablet', 'Generic', 'Antibiotics', 60.00, 89, '2029-02-15', 90, 8010, '2026-05-01 00:00:00', 'transferred', 7, '2026-05-06 03:04:06', 7, '2026-05-01 05:39:51', '2026-05-05 19:04:06'),
(42, 128, 'Neozep', 'Unilab', NULL, '500', 'mg', 'Tablet', 'Generic', 'Antibiotics', 10.00, 20, '2028-05-09', 100, 2000, '2026-08-12 00:00:00', 'in_queue', 7, NULL, NULL, '2026-05-05 22:33:12', '2026-05-05 22:33:12');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `full_name` varchar(30) DEFAULT NULL,
  `employee_id` varchar(20) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `contact_number` varchar(15) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `login_attempts` int(11) NOT NULL DEFAULT 0,
  `locked_until` timestamp NULL DEFAULT NULL,
  `last_login_at` timestamp NULL DEFAULT NULL,
  `profile_photo` varchar(100) DEFAULT NULL,
  `resume` varchar(100) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `password` varchar(60) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_verified` tinyint(1) NOT NULL DEFAULT 0,
  `otp_expires_at` timestamp NULL DEFAULT NULL,
  `otp_attempts` int(11) NOT NULL DEFAULT 0,
  `otp_last_attempt_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `otp_locked_until` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `full_name`, `employee_id`, `email`, `contact_number`, `address`, `is_active`, `login_attempts`, `locked_until`, `last_login_at`, `profile_photo`, `resume`, `notes`, `password`, `created_at`, `updated_at`, `is_verified`, `otp_expires_at`, `otp_attempts`, `otp_last_attempt_at`, `deleted_at`, `otp_locked_until`) VALUES
(7, 'Angeline', 'Angeline', NULL, 'angelinelanorio@gmail.com', NULL, NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, '$2y$12$2sa5sqcVGxikDYOm6h4yneatT2cMsMRrN.CEL1j4EZMYbu.9bwqCe', '2026-01-15 02:25:24', '2026-05-28 15:03:58', 0, NULL, 0, NULL, NULL, NULL),
(14, 'Rogelyn', 'Rogelyn Pica', NULL, 'curtina295@gmail.com', '0912 345 6789', 'Blk 12 Lot 8, Sunrise Village, Barangay San Miguel, Pasig City, Metro Manila, Philippines 1600', 1, 0, NULL, NULL, 'profile-photos/profile_14_1779979912.png', 'resumes/resume_14_1779979912.pdf', NULL, '$2y$12$WPmf70Hy3rPpTCE/eKgVWOEDPP6EBANz9jgpXPFSwUU/ktl6UE6aG', '2026-03-30 00:43:46', '2026-05-28 06:51:52', 0, NULL, 0, NULL, NULL, NULL),
(23, 'Emely Urgelles', 'Emely Urgelles', NULL, 'emelyurgelles0@gmail.com', NULL, NULL, 1, 0, NULL, NULL, 'profile_photos/profile_23_1775', NULL, NULL, '$2y$12$VHBRCcCz2ZGrraxrpwuyy.EvhGkEbnN46r9uc92KhM4OocMVdQi7K', '2026-04-01 06:23:39', '2026-04-05 17:33:43', 0, NULL, 0, NULL, NULL, NULL),
(24, 'Conan', 'Conan', NULL, 'conan.10162004@gmail.com', NULL, NULL, 1, 0, NULL, NULL, 'profile-photos/profile_24_1775', NULL, NULL, '$2y$12$Sj1XlrXANxefjR03HcDK1eYooX9urbixseiZNTxgKYLC0qXg0lw3G', '2026-04-02 02:02:53', '2026-04-04 13:00:03', 0, NULL, 0, NULL, NULL, NULL),
(31, 'lily', 'Lily Smith', NULL, 'lilyexit.10162004@gmail.com', NULL, NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, '$2y$12$xrh7up/hO2wUJAsoI2ax6ewjBSTUIntoQCJuS5DV2j6IpyxBtU18a', '2026-04-05 18:23:08', '2026-04-05 18:23:34', 0, NULL, 0, NULL, '2026-04-05 18:23:34', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_trusted_devices`
--

CREATE TABLE `user_trusted_devices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_name_unique` (`name`);

--
-- Indexes for table `discount_types`
--
ALTER TABLE `discount_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `discount_types_code_unique` (`code`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `otps`
--
ALTER TABLE `otps`
  ADD PRIMARY KEY (`id`),
  ADD KEY `otps_user_id_index` (`user_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `prescriptions`
--
ALTER TABLE `prescriptions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `prescriptions_prescription_number_unique` (`prescription_number`);

--
-- Indexes for table `prescription_items`
--
ALTER TABLE `prescription_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `prescription_items_prescription_id_foreign` (`prescription_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_barcode_unique` (`barcode`),
  ADD KEY `products_last_stock_queue_id_foreign` (`last_stock_queue_id`);

--
-- Indexes for table `product_batches`
--
ALTER TABLE `product_batches`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_batches_product_id_foreign` (`product_id`);

--
-- Indexes for table `promos`
--
ALTER TABLE `promos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `promos_product_id_foreign` (`product_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sales_discount_type_id_foreign` (`discount_type_id`),
  ADD KEY `sales_prescription_id_foreign` (`prescription_id`);

--
-- Indexes for table `sale_items`
--
ALTER TABLE `sale_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sale_id` (`sale_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_key_unique` (`key`);

--
-- Indexes for table `stock_queues`
--
ALTER TABLE `stock_queues`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `users_employee_id_unique` (`employee_id`);

--
-- Indexes for table `user_trusted_devices`
--
ALTER TABLE `user_trusted_devices`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=524;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `discount_types`
--
ALTER TABLE `discount_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `otps`
--
ALTER TABLE `otps`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=251;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `prescriptions`
--
ALTER TABLE `prescriptions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `prescription_items`
--
ALTER TABLE `prescription_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=130;

--
-- AUTO_INCREMENT for table `product_batches`
--
ALTER TABLE `product_batches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `promos`
--
ALTER TABLE `promos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=149;

--
-- AUTO_INCREMENT for table `sale_items`
--
ALTER TABLE `sale_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=155;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `stock_queues`
--
ALTER TABLE `stock_queues`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `user_trusted_devices`
--
ALTER TABLE `user_trusted_devices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `prescription_items`
--
ALTER TABLE `prescription_items`
  ADD CONSTRAINT `prescription_items_prescription_id_foreign` FOREIGN KEY (`prescription_id`) REFERENCES `prescriptions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_last_stock_queue_id_foreign` FOREIGN KEY (`last_stock_queue_id`) REFERENCES `stock_queues` (`id`);

--
-- Constraints for table `product_batches`
--
ALTER TABLE `product_batches`
  ADD CONSTRAINT `product_batches_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `promos`
--
ALTER TABLE `promos`
  ADD CONSTRAINT `promos_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `sales_discount_type_id_foreign` FOREIGN KEY (`discount_type_id`) REFERENCES `discount_types` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `sales_prescription_id_foreign` FOREIGN KEY (`prescription_id`) REFERENCES `prescriptions` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `sale_items`
--
ALTER TABLE `sale_items`
  ADD CONSTRAINT `sale_items_ibfk_1` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sale_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

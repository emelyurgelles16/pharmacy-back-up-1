-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 13, 2026 at 11:46 AM
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
  `user_name` varchar(255) DEFAULT NULL,
  `action` varchar(255) NOT NULL,
  `module` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `status` varchar(255) DEFAULT 'Success',
  `old_data` text DEFAULT NULL,
  `new_data` text DEFAULT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `user_id`, `user_name`, `action`, `module`, `description`, `status`, `old_data`, `new_data`, `ip_address`, `user_agent`, `created_at`, `updated_at`) VALUES
(1, 1, 'conan', 'login_attempt', 'Auth', 'User login attempt for: conan', 'Success', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36 Edg/152.0.0.0', '2026-09-12 13:16:22', '2026-09-12 13:16:22'),
(2, 1, 'conan', 'login_attempt', 'Auth', 'User login attempt for: conan', 'Success', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36 Edg/152.0.0.0', '2026-09-12 13:16:30', '2026-09-12 13:16:30'),
(3, 1, 'conan', 'login_attempt', 'Auth', 'User login attempt for: conan', 'Success', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36 Edg/152.0.0.0', '2026-09-12 13:21:01', '2026-09-12 13:21:01'),
(4, 1, 'conan', 'login_attempt', 'Auth', 'User login attempt for: conan', 'Success', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36 Edg/152.0.0.0', '2026-09-12 13:21:26', '2026-09-12 13:21:26'),
(5, 1, 'conan', 'otp_verified', 'Auth', 'OTP verified successfully for user: conan', 'Success', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36 Edg/152.0.0.0', '2026-09-12 13:22:49', '2026-09-12 13:22:49'),
(6, 1, 'conan', 'view_sales_report', 'Sales Reports', 'Viewed sales report for period: 2026-09-12 to 2026-09-12 - 0 transactions', 'Success', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36 Edg/152.0.0.0', '2026-09-12 13:45:36', '2026-09-12 13:45:36'),
(7, 1, 'conan', 'process_sale', 'POS', 'Processed sale: Invoice #INV-20260912-7003 | Total: ₱107.50 | Items: 1', 'Success', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36 Edg/152.0.0.0', '2026-09-12 14:01:19', '2026-09-12 14:01:19'),
(8, 1, 'conan', 'delete_user', 'User & Access', 'Deleted user: pharmacist (ID: 5)', 'Success', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36 Edg/152.0.0.0', '2026-09-12 14:04:01', '2026-09-12 14:04:01'),
(9, 1, 'conan', 'delete_user', 'User & Access', 'Deleted user: pharmacy (ID: 4)', 'Success', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36 Edg/152.0.0.0', '2026-09-12 14:04:07', '2026-09-12 14:04:07'),
(10, 1, 'conan', 'delete_user', 'User & Access', 'Deleted user: admin (ID: 2)', 'Success', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36 Edg/152.0.0.0', '2026-09-12 14:04:13', '2026-09-12 14:04:13'),
(11, 1, 'conan', 'delete_user', 'User & Access', 'Deleted user: cashier (ID: 3)', 'Success', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36 Edg/152.0.0.0', '2026-09-12 14:04:18', '2026-09-12 14:04:18'),
(12, 1, 'conan', 'delete_batch', 'Inventory', 'Deleted batch: Batch 3 from product: Amoxicillin', 'Success', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36 Edg/152.0.0.0', '2026-09-12 14:14:15', '2026-09-12 14:14:15'),
(13, 1, 'conan', 'delete_batch', 'Inventory', 'Deleted batch: Batch 2 from product: Amoxicillin', 'Success', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36 Edg/152.0.0.0', '2026-09-12 14:14:20', '2026-09-12 14:14:20'),
(14, 1, 'conan', 'delete_medicine', 'Inventory', 'Deleted medicine: Amoxicillin (all batches)', 'Success', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36 Edg/152.0.0.0', '2026-09-12 14:14:24', '2026-09-12 14:14:24'),
(15, 1, 'conan', 'delete_medicine', 'Inventory', 'Deleted medicine: Amoxicillin (all batches)', 'Success', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36 Edg/152.0.0.0', '2026-09-12 14:14:28', '2026-09-12 14:14:28'),
(16, 1, 'conan', 'update_medicine', 'Inventory', 'Updated medicine: Bioflu (ID: 14) - Changes: No changes | Batch: Expiry: 2027-09-30 00:00:00 → 2027-09-30, Arrival: 2026-09-12 00:00:00 → 2026-09-12', 'Success', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36 Edg/152.0.0.0', '2026-09-12 14:45:51', '2026-09-12 14:45:51'),
(17, 1, 'conan', 'view_receipts', 'Receipts', 'Viewed receipt history - 1 receipts found', 'Success', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36 Edg/152.0.0.0', '2026-09-12 14:47:50', '2026-09-12 14:47:50'),
(18, 1, 'conan', 'delete_medicine', 'Inventory', 'Deleted medicine: Biogesic (all batches)', 'Success', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36 Edg/152.0.0.0', '2026-09-12 16:08:48', '2026-09-12 16:08:48'),
(19, 1, 'conan', 'update_medicine', 'Inventory', 'Updated medicine: Biogesic (ID: 20) - Changes: No changes | Batch: Expiry: 2027-12-31 00:00:00 → 2027-12-31, Arrival: 2026-09-12 00:00:00 → 2026-09-12', 'Success', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36 Edg/152.0.0.0', '2026-09-12 16:29:57', '2026-09-12 16:29:57'),
(20, 1, 'conan', 'delete_medicine', 'Inventory', 'Deleted medicine: Biogesic (all batches)', 'Success', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36 Edg/152.0.0.0', '2026-09-12 16:47:32', '2026-09-12 16:47:32'),
(21, 1, 'conan', 'login_attempt', 'Auth', 'User login attempt for: conan', 'Success', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36 Edg/152.0.0.0', '2026-09-13 04:50:08', '2026-09-13 04:50:08');

-- --------------------------------------------------------

--
-- Table structure for table `backups`
--

CREATE TABLE `backups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `filename` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `backup_type` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `file_size` varchar(255) DEFAULT NULL,
  `started_at` timestamp NULL DEFAULT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
('aer-pharmacy-cache-categories', 'O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:15:{i:0;O:19:\"App\\Models\\Category\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";i:1;s:4:\"name\";s:9:\"Analgesic\";s:4:\"slug\";s:9:\"analgesic\";s:11:\"description\";s:23:\"Pain reliever medicines\";s:10:\"created_at\";s:19:\"2026-09-12 21:30:16\";s:10:\"updated_at\";s:19:\"2026-09-12 21:30:16\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";i:1;s:4:\"name\";s:9:\"Analgesic\";s:4:\"slug\";s:9:\"analgesic\";s:11:\"description\";s:23:\"Pain reliever medicines\";s:10:\"created_at\";s:19:\"2026-09-12 21:30:16\";s:10:\"updated_at\";s:19:\"2026-09-12 21:30:16\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:4:\"name\";i:1;s:11:\"description\";i:2;s:4:\"slug\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:1;O:19:\"App\\Models\\Category\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";i:2;s:4:\"name\";s:10:\"Antibiotic\";s:4:\"slug\";s:10:\"antibiotic\";s:11:\"description\";s:34:\"Medicines for bacterial infections\";s:10:\"created_at\";s:19:\"2026-09-12 21:30:16\";s:10:\"updated_at\";s:19:\"2026-09-12 21:30:16\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";i:2;s:4:\"name\";s:10:\"Antibiotic\";s:4:\"slug\";s:10:\"antibiotic\";s:11:\"description\";s:34:\"Medicines for bacterial infections\";s:10:\"created_at\";s:19:\"2026-09-12 21:30:16\";s:10:\"updated_at\";s:19:\"2026-09-12 21:30:16\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:4:\"name\";i:1;s:11:\"description\";i:2;s:4:\"slug\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:2;O:19:\"App\\Models\\Category\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";i:3;s:4:\"name\";s:11:\"Antipyretic\";s:4:\"slug\";s:11:\"antipyretic\";s:11:\"description\";s:23:\"Fever reducer medicines\";s:10:\"created_at\";s:19:\"2026-09-12 21:30:16\";s:10:\"updated_at\";s:19:\"2026-09-12 21:30:16\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";i:3;s:4:\"name\";s:11:\"Antipyretic\";s:4:\"slug\";s:11:\"antipyretic\";s:11:\"description\";s:23:\"Fever reducer medicines\";s:10:\"created_at\";s:19:\"2026-09-12 21:30:16\";s:10:\"updated_at\";s:19:\"2026-09-12 21:30:16\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:4:\"name\";i:1;s:11:\"description\";i:2;s:4:\"slug\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:3;O:19:\"App\\Models\\Category\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";i:4;s:4:\"name\";s:13:\"Antihistamine\";s:4:\"slug\";s:13:\"antihistamine\";s:11:\"description\";s:24:\"Allergy relief medicines\";s:10:\"created_at\";s:19:\"2026-09-12 21:30:16\";s:10:\"updated_at\";s:19:\"2026-09-12 21:30:16\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";i:4;s:4:\"name\";s:13:\"Antihistamine\";s:4:\"slug\";s:13:\"antihistamine\";s:11:\"description\";s:24:\"Allergy relief medicines\";s:10:\"created_at\";s:19:\"2026-09-12 21:30:16\";s:10:\"updated_at\";s:19:\"2026-09-12 21:30:16\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:4:\"name\";i:1;s:11:\"description\";i:2;s:4:\"slug\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:4;O:19:\"App\\Models\\Category\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";i:5;s:4:\"name\";s:7:\"Antacid\";s:4:\"slug\";s:7:\"antacid\";s:11:\"description\";s:24:\"Stomach acid neutralizer\";s:10:\"created_at\";s:19:\"2026-09-12 21:30:16\";s:10:\"updated_at\";s:19:\"2026-09-12 21:30:16\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";i:5;s:4:\"name\";s:7:\"Antacid\";s:4:\"slug\";s:7:\"antacid\";s:11:\"description\";s:24:\"Stomach acid neutralizer\";s:10:\"created_at\";s:19:\"2026-09-12 21:30:16\";s:10:\"updated_at\";s:19:\"2026-09-12 21:30:16\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:4:\"name\";i:1;s:11:\"description\";i:2;s:4:\"slug\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:5;O:19:\"App\\Models\\Category\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";i:6;s:4:\"name\";s:10:\"Antiseptic\";s:4:\"slug\";s:10:\"antiseptic\";s:11:\"description\";s:39:\"Wound cleaning and infection prevention\";s:10:\"created_at\";s:19:\"2026-09-12 21:30:16\";s:10:\"updated_at\";s:19:\"2026-09-12 21:30:16\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";i:6;s:4:\"name\";s:10:\"Antiseptic\";s:4:\"slug\";s:10:\"antiseptic\";s:11:\"description\";s:39:\"Wound cleaning and infection prevention\";s:10:\"created_at\";s:19:\"2026-09-12 21:30:16\";s:10:\"updated_at\";s:19:\"2026-09-12 21:30:16\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:4:\"name\";i:1;s:11:\"description\";i:2;s:4:\"slug\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:6;O:19:\"App\\Models\\Category\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";i:7;s:4:\"name\";s:7:\"Vitamin\";s:4:\"slug\";s:7:\"vitamin\";s:11:\"description\";s:19:\"Dietary supplements\";s:10:\"created_at\";s:19:\"2026-09-12 21:30:16\";s:10:\"updated_at\";s:19:\"2026-09-12 21:30:16\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";i:7;s:4:\"name\";s:7:\"Vitamin\";s:4:\"slug\";s:7:\"vitamin\";s:11:\"description\";s:19:\"Dietary supplements\";s:10:\"created_at\";s:19:\"2026-09-12 21:30:16\";s:10:\"updated_at\";s:19:\"2026-09-12 21:30:16\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:4:\"name\";i:1;s:11:\"description\";i:2;s:4:\"slug\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:7;O:19:\"App\\Models\\Category\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";i:8;s:4:\"name\";s:14:\"Cardiovascular\";s:4:\"slug\";s:14:\"cardiovascular\";s:11:\"description\";s:34:\"Heart and blood pressure medicines\";s:10:\"created_at\";s:19:\"2026-09-12 21:30:16\";s:10:\"updated_at\";s:19:\"2026-09-12 21:30:16\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";i:8;s:4:\"name\";s:14:\"Cardiovascular\";s:4:\"slug\";s:14:\"cardiovascular\";s:11:\"description\";s:34:\"Heart and blood pressure medicines\";s:10:\"created_at\";s:19:\"2026-09-12 21:30:16\";s:10:\"updated_at\";s:19:\"2026-09-12 21:30:16\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:4:\"name\";i:1;s:11:\"description\";i:2;s:4:\"slug\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:8;O:19:\"App\\Models\\Category\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";i:9;s:4:\"name\";s:12:\"Antidiabetic\";s:4:\"slug\";s:12:\"antidiabetic\";s:11:\"description\";s:29:\"Diabetes management medicines\";s:10:\"created_at\";s:19:\"2026-09-12 21:30:16\";s:10:\"updated_at\";s:19:\"2026-09-12 21:30:16\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";i:9;s:4:\"name\";s:12:\"Antidiabetic\";s:4:\"slug\";s:12:\"antidiabetic\";s:11:\"description\";s:29:\"Diabetes management medicines\";s:10:\"created_at\";s:19:\"2026-09-12 21:30:16\";s:10:\"updated_at\";s:19:\"2026-09-12 21:30:16\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:4:\"name\";i:1;s:11:\"description\";i:2;s:4:\"slug\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:9;O:19:\"App\\Models\\Category\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";i:10;s:4:\"name\";s:11:\"Respiratory\";s:4:\"slug\";s:11:\"respiratory\";s:11:\"description\";s:28:\"Breathing and lung medicines\";s:10:\"created_at\";s:19:\"2026-09-12 21:30:16\";s:10:\"updated_at\";s:19:\"2026-09-12 21:30:16\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";i:10;s:4:\"name\";s:11:\"Respiratory\";s:4:\"slug\";s:11:\"respiratory\";s:11:\"description\";s:28:\"Breathing and lung medicines\";s:10:\"created_at\";s:19:\"2026-09-12 21:30:16\";s:10:\"updated_at\";s:19:\"2026-09-12 21:30:16\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:4:\"name\";i:1;s:11:\"description\";i:2;s:4:\"slug\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:10;O:19:\"App\\Models\\Category\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";i:11;s:4:\"name\";s:16:\"Gastrointestinal\";s:4:\"slug\";s:16:\"gastrointestinal\";s:11:\"description\";s:26:\"Digestive system medicines\";s:10:\"created_at\";s:19:\"2026-09-12 21:30:16\";s:10:\"updated_at\";s:19:\"2026-09-12 21:30:16\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";i:11;s:4:\"name\";s:16:\"Gastrointestinal\";s:4:\"slug\";s:16:\"gastrointestinal\";s:11:\"description\";s:26:\"Digestive system medicines\";s:10:\"created_at\";s:19:\"2026-09-12 21:30:16\";s:10:\"updated_at\";s:19:\"2026-09-12 21:30:16\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:4:\"name\";i:1;s:11:\"description\";i:2;s:4:\"slug\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:11;O:19:\"App\\Models\\Category\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";i:12;s:4:\"name\";s:12:\"Cough & Cold\";s:4:\"slug\";s:10:\"cough-cold\";s:11:\"description\";s:31:\"Cough and cold relief medicines\";s:10:\"created_at\";s:19:\"2026-09-12 21:30:16\";s:10:\"updated_at\";s:19:\"2026-09-12 21:30:16\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";i:12;s:4:\"name\";s:12:\"Cough & Cold\";s:4:\"slug\";s:10:\"cough-cold\";s:11:\"description\";s:31:\"Cough and cold relief medicines\";s:10:\"created_at\";s:19:\"2026-09-12 21:30:16\";s:10:\"updated_at\";s:19:\"2026-09-12 21:30:16\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:4:\"name\";i:1;s:11:\"description\";i:2;s:4:\"slug\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:12;O:19:\"App\\Models\\Category\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";i:13;s:4:\"name\";s:17:\"Anti-inflammatory\";s:4:\"slug\";s:17:\"anti-inflammatory\";s:11:\"description\";s:30:\"Inflammation reducer medicines\";s:10:\"created_at\";s:19:\"2026-09-12 21:30:16\";s:10:\"updated_at\";s:19:\"2026-09-12 21:30:16\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";i:13;s:4:\"name\";s:17:\"Anti-inflammatory\";s:4:\"slug\";s:17:\"anti-inflammatory\";s:11:\"description\";s:30:\"Inflammation reducer medicines\";s:10:\"created_at\";s:19:\"2026-09-12 21:30:16\";s:10:\"updated_at\";s:19:\"2026-09-12 21:30:16\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:4:\"name\";i:1;s:11:\"description\";i:2;s:4:\"slug\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:13;O:19:\"App\\Models\\Category\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";i:14;s:4:\"name\";s:8:\"Sedative\";s:4:\"slug\";s:8:\"sedative\";s:11:\"description\";s:30:\"Sleep and relaxation medicines\";s:10:\"created_at\";s:19:\"2026-09-12 21:30:16\";s:10:\"updated_at\";s:19:\"2026-09-12 21:30:16\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";i:14;s:4:\"name\";s:8:\"Sedative\";s:4:\"slug\";s:8:\"sedative\";s:11:\"description\";s:30:\"Sleep and relaxation medicines\";s:10:\"created_at\";s:19:\"2026-09-12 21:30:16\";s:10:\"updated_at\";s:19:\"2026-09-12 21:30:16\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:4:\"name\";i:1;s:11:\"description\";i:2;s:4:\"slug\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:14;O:19:\"App\\Models\\Category\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";i:15;s:4:\"name\";s:10:\"Antifungal\";s:4:\"slug\";s:10:\"antifungal\";s:11:\"description\";s:26:\"Fungal infection treatment\";s:10:\"created_at\";s:19:\"2026-09-12 21:30:16\";s:10:\"updated_at\";s:19:\"2026-09-12 21:30:16\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";i:15;s:4:\"name\";s:10:\"Antifungal\";s:4:\"slug\";s:10:\"antifungal\";s:11:\"description\";s:26:\"Fungal infection treatment\";s:10:\"created_at\";s:19:\"2026-09-12 21:30:16\";s:10:\"updated_at\";s:19:\"2026-09-12 21:30:16\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:4:\"name\";i:1;s:11:\"description\";i:2;s:4:\"slug\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}', 1789278661);
INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('aer-pharmacy-cache-dosage_forms', 'O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:30:{i:0;O:21:\"App\\Models\\DosageForm\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:12:\"dosage_forms\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:2:\"id\";i:2;s:4:\"name\";s:7:\"Capsule\";s:4:\"slug\";s:7:\"capsule\";s:12:\"abbreviation\";s:2:\"mg\";s:11:\"description\";s:30:\"Gelatin shell oral dosage form\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-09-12 21:39:10\";s:10:\"updated_at\";s:19:\"2026-09-12 21:39:10\";}s:11:\"\0*\0original\";a:8:{s:2:\"id\";i:2;s:4:\"name\";s:7:\"Capsule\";s:4:\"slug\";s:7:\"capsule\";s:12:\"abbreviation\";s:2:\"mg\";s:11:\"description\";s:30:\"Gelatin shell oral dosage form\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-09-12 21:39:10\";s:10:\"updated_at\";s:19:\"2026-09-12 21:39:10\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:1:{s:9:\"is_active\";s:7:\"boolean\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:4:\"name\";i:1;s:4:\"slug\";i:2;s:12:\"abbreviation\";i:3;s:11:\"description\";i:4;s:9:\"is_active\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:1;O:21:\"App\\Models\\DosageForm\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:12:\"dosage_forms\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:2:\"id\";i:18;s:4:\"name\";s:15:\"Chewable Tablet\";s:4:\"slug\";s:15:\"chewable-tablet\";s:12:\"abbreviation\";s:2:\"mg\";s:11:\"description\";s:19:\"Tablet to be chewed\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-09-12 21:39:10\";s:10:\"updated_at\";s:19:\"2026-09-12 21:39:10\";}s:11:\"\0*\0original\";a:8:{s:2:\"id\";i:18;s:4:\"name\";s:15:\"Chewable Tablet\";s:4:\"slug\";s:15:\"chewable-tablet\";s:12:\"abbreviation\";s:2:\"mg\";s:11:\"description\";s:19:\"Tablet to be chewed\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-09-12 21:39:10\";s:10:\"updated_at\";s:19:\"2026-09-12 21:39:10\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:1:{s:9:\"is_active\";s:7:\"boolean\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:4:\"name\";i:1;s:4:\"slug\";i:2;s:12:\"abbreviation\";i:3;s:11:\"description\";i:4;s:9:\"is_active\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:2;O:21:\"App\\Models\\DosageForm\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:12:\"dosage_forms\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:2:\"id\";i:7;s:4:\"name\";s:5:\"Cream\";s:4:\"slug\";s:5:\"cream\";s:12:\"abbreviation\";s:1:\"g\";s:11:\"description\";s:22:\"Topical cream medicine\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-09-12 21:39:10\";s:10:\"updated_at\";s:19:\"2026-09-12 21:39:10\";}s:11:\"\0*\0original\";a:8:{s:2:\"id\";i:7;s:4:\"name\";s:5:\"Cream\";s:4:\"slug\";s:5:\"cream\";s:12:\"abbreviation\";s:1:\"g\";s:11:\"description\";s:22:\"Topical cream medicine\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-09-12 21:39:10\";s:10:\"updated_at\";s:19:\"2026-09-12 21:39:10\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:1:{s:9:\"is_active\";s:7:\"boolean\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:4:\"name\";i:1;s:4:\"slug\";i:2;s:12:\"abbreviation\";i:3;s:11:\"description\";i:4;s:9:\"is_active\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:3;O:21:\"App\\Models\\DosageForm\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:12:\"dosage_forms\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:2:\"id\";i:5;s:4:\"name\";s:5:\"Drops\";s:4:\"slug\";s:5:\"drops\";s:12:\"abbreviation\";s:2:\"ml\";s:11:\"description\";s:31:\"Liquid drops for eyes/ears/nose\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-09-12 21:39:10\";s:10:\"updated_at\";s:19:\"2026-09-12 21:39:10\";}s:11:\"\0*\0original\";a:8:{s:2:\"id\";i:5;s:4:\"name\";s:5:\"Drops\";s:4:\"slug\";s:5:\"drops\";s:12:\"abbreviation\";s:2:\"ml\";s:11:\"description\";s:31:\"Liquid drops for eyes/ears/nose\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-09-12 21:39:10\";s:10:\"updated_at\";s:19:\"2026-09-12 21:39:10\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:1:{s:9:\"is_active\";s:7:\"boolean\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:4:\"name\";i:1;s:4:\"slug\";i:2;s:12:\"abbreviation\";i:3;s:11:\"description\";i:4;s:9:\"is_active\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:4;O:21:\"App\\Models\\DosageForm\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:12:\"dosage_forms\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:2:\"id\";i:27;s:4:\"name\";s:9:\"Ear Drops\";s:4:\"slug\";s:9:\"ear-drops\";s:12:\"abbreviation\";s:9:\"Ear Drops\";s:11:\"description\";s:17:\"Medicine for ears\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-09-12 21:39:10\";s:10:\"updated_at\";s:19:\"2026-09-12 21:39:10\";}s:11:\"\0*\0original\";a:8:{s:2:\"id\";i:27;s:4:\"name\";s:9:\"Ear Drops\";s:4:\"slug\";s:9:\"ear-drops\";s:12:\"abbreviation\";s:9:\"Ear Drops\";s:11:\"description\";s:17:\"Medicine for ears\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-09-12 21:39:10\";s:10:\"updated_at\";s:19:\"2026-09-12 21:39:10\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:1:{s:9:\"is_active\";s:7:\"boolean\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:4:\"name\";i:1;s:4:\"slug\";i:2;s:12:\"abbreviation\";i:3;s:11:\"description\";i:4;s:9:\"is_active\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:5;O:21:\"App\\Models\\DosageForm\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:12:\"dosage_forms\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:2:\"id\";i:19;s:4:\"name\";s:19:\"Effervescent Tablet\";s:4:\"slug\";s:19:\"effervescent-tablet\";s:12:\"abbreviation\";s:2:\"mg\";s:11:\"description\";s:20:\"Dissolvable in water\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-09-12 21:39:10\";s:10:\"updated_at\";s:19:\"2026-09-12 21:39:10\";}s:11:\"\0*\0original\";a:8:{s:2:\"id\";i:19;s:4:\"name\";s:19:\"Effervescent Tablet\";s:4:\"slug\";s:19:\"effervescent-tablet\";s:12:\"abbreviation\";s:2:\"mg\";s:11:\"description\";s:20:\"Dissolvable in water\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-09-12 21:39:10\";s:10:\"updated_at\";s:19:\"2026-09-12 21:39:10\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:1:{s:9:\"is_active\";s:7:\"boolean\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:4:\"name\";i:1;s:4:\"slug\";i:2;s:12:\"abbreviation\";i:3;s:11:\"description\";i:4;s:9:\"is_active\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:6;O:21:\"App\\Models\\DosageForm\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:12:\"dosage_forms\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:2:\"id\";i:21;s:4:\"name\";s:21:\"Enteric-Coated Tablet\";s:4:\"slug\";s:21:\"enteric-coated-tablet\";s:12:\"abbreviation\";s:2:\"mg\";s:11:\"description\";s:22:\"Delayed-release tablet\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-09-12 21:39:10\";s:10:\"updated_at\";s:19:\"2026-09-12 21:39:10\";}s:11:\"\0*\0original\";a:8:{s:2:\"id\";i:21;s:4:\"name\";s:21:\"Enteric-Coated Tablet\";s:4:\"slug\";s:21:\"enteric-coated-tablet\";s:12:\"abbreviation\";s:2:\"mg\";s:11:\"description\";s:22:\"Delayed-release tablet\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-09-12 21:39:10\";s:10:\"updated_at\";s:19:\"2026-09-12 21:39:10\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:1:{s:9:\"is_active\";s:7:\"boolean\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:4:\"name\";i:1;s:4:\"slug\";i:2;s:12:\"abbreviation\";i:3;s:11:\"description\";i:4;s:9:\"is_active\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:7;O:21:\"App\\Models\\DosageForm\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:12:\"dosage_forms\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:2:\"id\";i:22;s:4:\"name\";s:23:\"Extended-Release Tablet\";s:4:\"slug\";s:23:\"extended-release-tablet\";s:12:\"abbreviation\";s:2:\"mg\";s:11:\"description\";s:19:\"Slow-release tablet\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-09-12 21:39:10\";s:10:\"updated_at\";s:19:\"2026-09-12 21:39:10\";}s:11:\"\0*\0original\";a:8:{s:2:\"id\";i:22;s:4:\"name\";s:23:\"Extended-Release Tablet\";s:4:\"slug\";s:23:\"extended-release-tablet\";s:12:\"abbreviation\";s:2:\"mg\";s:11:\"description\";s:19:\"Slow-release tablet\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-09-12 21:39:10\";s:10:\"updated_at\";s:19:\"2026-09-12 21:39:10\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:1:{s:9:\"is_active\";s:7:\"boolean\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:4:\"name\";i:1;s:4:\"slug\";i:2;s:12:\"abbreviation\";i:3;s:11:\"description\";i:4;s:9:\"is_active\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:8;O:21:\"App\\Models\\DosageForm\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:12:\"dosage_forms\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:2:\"id\";i:26;s:4:\"name\";s:9:\"Eye Drops\";s:4:\"slug\";s:9:\"eye-drops\";s:12:\"abbreviation\";s:9:\"Eye Drops\";s:11:\"description\";s:17:\"Medicine for eyes\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-09-12 21:39:10\";s:10:\"updated_at\";s:19:\"2026-09-12 21:39:10\";}s:11:\"\0*\0original\";a:8:{s:2:\"id\";i:26;s:4:\"name\";s:9:\"Eye Drops\";s:4:\"slug\";s:9:\"eye-drops\";s:12:\"abbreviation\";s:9:\"Eye Drops\";s:11:\"description\";s:17:\"Medicine for eyes\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-09-12 21:39:10\";s:10:\"updated_at\";s:19:\"2026-09-12 21:39:10\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:1:{s:9:\"is_active\";s:7:\"boolean\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:4:\"name\";i:1;s:4:\"slug\";i:2;s:12:\"abbreviation\";i:3;s:11:\"description\";i:4;s:9:\"is_active\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:9;O:21:\"App\\Models\\DosageForm\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:12:\"dosage_forms\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:2:\"id\";i:30;s:4:\"name\";s:4:\"Foam\";s:4:\"slug\";s:4:\"foam\";s:12:\"abbreviation\";s:4:\"Foam\";s:11:\"description\";s:21:\"Topical foam medicine\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-09-12 21:39:10\";s:10:\"updated_at\";s:19:\"2026-09-12 21:39:10\";}s:11:\"\0*\0original\";a:8:{s:2:\"id\";i:30;s:4:\"name\";s:4:\"Foam\";s:4:\"slug\";s:4:\"foam\";s:12:\"abbreviation\";s:4:\"Foam\";s:11:\"description\";s:21:\"Topical foam medicine\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-09-12 21:39:10\";s:10:\"updated_at\";s:19:\"2026-09-12 21:39:10\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:1:{s:9:\"is_active\";s:7:\"boolean\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:4:\"name\";i:1;s:4:\"slug\";i:2;s:12:\"abbreviation\";i:3;s:11:\"description\";i:4;s:9:\"is_active\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:10;O:21:\"App\\Models\\DosageForm\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:12:\"dosage_forms\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:2:\"id\";i:8;s:4:\"name\";s:3:\"Gel\";s:4:\"slug\";s:3:\"gel\";s:12:\"abbreviation\";s:1:\"g\";s:11:\"description\";s:20:\"Topical gel medicine\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-09-12 21:39:10\";s:10:\"updated_at\";s:19:\"2026-09-12 21:39:10\";}s:11:\"\0*\0original\";a:8:{s:2:\"id\";i:8;s:4:\"name\";s:3:\"Gel\";s:4:\"slug\";s:3:\"gel\";s:12:\"abbreviation\";s:1:\"g\";s:11:\"description\";s:20:\"Topical gel medicine\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-09-12 21:39:10\";s:10:\"updated_at\";s:19:\"2026-09-12 21:39:10\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:1:{s:9:\"is_active\";s:7:\"boolean\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:4:\"name\";i:1;s:4:\"slug\";i:2;s:12:\"abbreviation\";i:3;s:11:\"description\";i:4;s:9:\"is_active\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:11;O:21:\"App\\Models\\DosageForm\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:12:\"dosage_forms\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:2:\"id\";i:16;s:4:\"name\";s:8:\"Granules\";s:4:\"slug\";s:8:\"granules\";s:12:\"abbreviation\";s:2:\"mg\";s:11:\"description\";s:17:\"Granular medicine\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-09-12 21:39:10\";s:10:\"updated_at\";s:19:\"2026-09-12 21:39:10\";}s:11:\"\0*\0original\";a:8:{s:2:\"id\";i:16;s:4:\"name\";s:8:\"Granules\";s:4:\"slug\";s:8:\"granules\";s:12:\"abbreviation\";s:2:\"mg\";s:11:\"description\";s:17:\"Granular medicine\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-09-12 21:39:10\";s:10:\"updated_at\";s:19:\"2026-09-12 21:39:10\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:1:{s:9:\"is_active\";s:7:\"boolean\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:4:\"name\";i:1;s:4:\"slug\";i:2;s:12:\"abbreviation\";i:3;s:11:\"description\";i:4;s:9:\"is_active\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:12;O:21:\"App\\Models\\DosageForm\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:12:\"dosage_forms\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:2:\"id\";i:11;s:4:\"name\";s:7:\"Inhaler\";s:4:\"slug\";s:7:\"inhaler\";s:12:\"abbreviation\";s:3:\"mcg\";s:11:\"description\";s:23:\"Medicine for inhalation\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-09-12 21:39:10\";s:10:\"updated_at\";s:19:\"2026-09-12 21:39:10\";}s:11:\"\0*\0original\";a:8:{s:2:\"id\";i:11;s:4:\"name\";s:7:\"Inhaler\";s:4:\"slug\";s:7:\"inhaler\";s:12:\"abbreviation\";s:3:\"mcg\";s:11:\"description\";s:23:\"Medicine for inhalation\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-09-12 21:39:10\";s:10:\"updated_at\";s:19:\"2026-09-12 21:39:10\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:1:{s:9:\"is_active\";s:7:\"boolean\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:4:\"name\";i:1;s:4:\"slug\";i:2;s:12:\"abbreviation\";i:3;s:11:\"description\";i:4;s:9:\"is_active\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:13;O:21:\"App\\Models\\DosageForm\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:12:\"dosage_forms\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:2:\"id\";i:10;s:4:\"name\";s:9:\"Injection\";s:4:\"slug\";s:9:\"injection\";s:12:\"abbreviation\";s:2:\"ml\";s:11:\"description\";s:28:\"Sterile liquid for injection\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-09-12 21:39:10\";s:10:\"updated_at\";s:19:\"2026-09-12 21:39:10\";}s:11:\"\0*\0original\";a:8:{s:2:\"id\";i:10;s:4:\"name\";s:9:\"Injection\";s:4:\"slug\";s:9:\"injection\";s:12:\"abbreviation\";s:2:\"ml\";s:11:\"description\";s:28:\"Sterile liquid for injection\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-09-12 21:39:10\";s:10:\"updated_at\";s:19:\"2026-09-12 21:39:10\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:1:{s:9:\"is_active\";s:7:\"boolean\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:4:\"name\";i:1;s:4:\"slug\";i:2;s:12:\"abbreviation\";i:3;s:11:\"description\";i:4;s:9:\"is_active\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:14;O:21:\"App\\Models\\DosageForm\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:12:\"dosage_forms\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:2:\"id\";i:9;s:4:\"name\";s:6:\"Lotion\";s:4:\"slug\";s:6:\"lotion\";s:12:\"abbreviation\";s:1:\"g\";s:11:\"description\";s:23:\"Topical liquid medicine\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-09-12 21:39:10\";s:10:\"updated_at\";s:19:\"2026-09-12 21:39:10\";}s:11:\"\0*\0original\";a:8:{s:2:\"id\";i:9;s:4:\"name\";s:6:\"Lotion\";s:4:\"slug\";s:6:\"lotion\";s:12:\"abbreviation\";s:1:\"g\";s:11:\"description\";s:23:\"Topical liquid medicine\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-09-12 21:39:10\";s:10:\"updated_at\";s:19:\"2026-09-12 21:39:10\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:1:{s:9:\"is_active\";s:7:\"boolean\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:4:\"name\";i:1;s:4:\"slug\";i:2;s:12:\"abbreviation\";i:3;s:11:\"description\";i:4;s:9:\"is_active\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:15;O:21:\"App\\Models\\DosageForm\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:12:\"dosage_forms\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:2:\"id\";i:17;s:4:\"name\";s:7:\"Lozenge\";s:4:\"slug\";s:7:\"lozenge\";s:12:\"abbreviation\";s:2:\"mg\";s:11:\"description\";s:23:\"Dissolvable oral tablet\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-09-12 21:39:10\";s:10:\"updated_at\";s:19:\"2026-09-12 21:39:10\";}s:11:\"\0*\0original\";a:8:{s:2:\"id\";i:17;s:4:\"name\";s:7:\"Lozenge\";s:4:\"slug\";s:7:\"lozenge\";s:12:\"abbreviation\";s:2:\"mg\";s:11:\"description\";s:23:\"Dissolvable oral tablet\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-09-12 21:39:10\";s:10:\"updated_at\";s:19:\"2026-09-12 21:39:10\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:1:{s:9:\"is_active\";s:7:\"boolean\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:4:\"name\";i:1;s:4:\"slug\";i:2;s:12:\"abbreviation\";i:3;s:11:\"description\";i:4;s:9:\"is_active\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:16;O:21:\"App\\Models\\DosageForm\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:12:\"dosage_forms\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:2:\"id\";i:28;s:4:\"name\";s:9:\"Mouthwash\";s:4:\"slug\";s:9:\"mouthwash\";s:12:\"abbreviation\";s:9:\"Mouthwash\";s:11:\"description\";s:19:\"Oral rinse medicine\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-09-12 21:39:10\";s:10:\"updated_at\";s:19:\"2026-09-12 21:39:10\";}s:11:\"\0*\0original\";a:8:{s:2:\"id\";i:28;s:4:\"name\";s:9:\"Mouthwash\";s:4:\"slug\";s:9:\"mouthwash\";s:12:\"abbreviation\";s:9:\"Mouthwash\";s:11:\"description\";s:19:\"Oral rinse medicine\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-09-12 21:39:10\";s:10:\"updated_at\";s:19:\"2026-09-12 21:39:10\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:1:{s:9:\"is_active\";s:7:\"boolean\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:4:\"name\";i:1;s:4:\"slug\";i:2;s:12:\"abbreviation\";i:3;s:11:\"description\";i:4;s:9:\"is_active\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:17;O:21:\"App\\Models\\DosageForm\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:12:\"dosage_forms\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:2:\"id\";i:25;s:4:\"name\";s:11:\"Nasal Spray\";s:4:\"slug\";s:11:\"nasal-spray\";s:12:\"abbreviation\";s:2:\"ml\";s:11:\"description\";s:17:\"Medicine for nose\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-09-12 21:39:10\";s:10:\"updated_at\";s:19:\"2026-09-12 21:39:10\";}s:11:\"\0*\0original\";a:8:{s:2:\"id\";i:25;s:4:\"name\";s:11:\"Nasal Spray\";s:4:\"slug\";s:11:\"nasal-spray\";s:12:\"abbreviation\";s:2:\"ml\";s:11:\"description\";s:17:\"Medicine for nose\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-09-12 21:39:10\";s:10:\"updated_at\";s:19:\"2026-09-12 21:39:10\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:1:{s:9:\"is_active\";s:7:\"boolean\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:4:\"name\";i:1;s:4:\"slug\";i:2;s:12:\"abbreviation\";i:3;s:11:\"description\";i:4;s:9:\"is_active\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:18;O:21:\"App\\Models\\DosageForm\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:12:\"dosage_forms\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:2:\"id\";i:6;s:4:\"name\";s:8:\"Ointment\";s:4:\"slug\";s:8:\"ointment\";s:12:\"abbreviation\";s:1:\"g\";s:11:\"description\";s:27:\"Semi-solid topical medicine\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-09-12 21:39:10\";s:10:\"updated_at\";s:19:\"2026-09-12 21:39:10\";}s:11:\"\0*\0original\";a:8:{s:2:\"id\";i:6;s:4:\"name\";s:8:\"Ointment\";s:4:\"slug\";s:8:\"ointment\";s:12:\"abbreviation\";s:1:\"g\";s:11:\"description\";s:27:\"Semi-solid topical medicine\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-09-12 21:39:10\";s:10:\"updated_at\";s:19:\"2026-09-12 21:39:10\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:1:{s:9:\"is_active\";s:7:\"boolean\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:4:\"name\";i:1;s:4:\"slug\";i:2;s:12:\"abbreviation\";i:3;s:11:\"description\";i:4;s:9:\"is_active\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:19;O:21:\"App\\Models\\DosageForm\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:12:\"dosage_forms\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:2:\"id\";i:14;s:4:\"name\";s:5:\"Patch\";s:4:\"slug\";s:5:\"patch\";s:12:\"abbreviation\";s:2:\"mg\";s:11:\"description\";s:17:\"Transdermal patch\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-09-12 21:39:10\";s:10:\"updated_at\";s:19:\"2026-09-12 21:39:10\";}s:11:\"\0*\0original\";a:8:{s:2:\"id\";i:14;s:4:\"name\";s:5:\"Patch\";s:4:\"slug\";s:5:\"patch\";s:12:\"abbreviation\";s:2:\"mg\";s:11:\"description\";s:17:\"Transdermal patch\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-09-12 21:39:10\";s:10:\"updated_at\";s:19:\"2026-09-12 21:39:10\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:1:{s:9:\"is_active\";s:7:\"boolean\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:4:\"name\";i:1;s:4:\"slug\";i:2;s:12:\"abbreviation\";i:3;s:11:\"description\";i:4;s:9:\"is_active\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:20;O:21:\"App\\Models\\DosageForm\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:12:\"dosage_forms\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:2:\"id\";i:15;s:4:\"name\";s:6:\"Powder\";s:4:\"slug\";s:6:\"powder\";s:12:\"abbreviation\";s:2:\"mg\";s:11:\"description\";s:15:\"Powder medicine\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-09-12 21:39:10\";s:10:\"updated_at\";s:19:\"2026-09-12 21:39:10\";}s:11:\"\0*\0original\";a:8:{s:2:\"id\";i:15;s:4:\"name\";s:6:\"Powder\";s:4:\"slug\";s:6:\"powder\";s:12:\"abbreviation\";s:2:\"mg\";s:11:\"description\";s:15:\"Powder medicine\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-09-12 21:39:10\";s:10:\"updated_at\";s:19:\"2026-09-12 21:39:10\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:1:{s:9:\"is_active\";s:7:\"boolean\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:4:\"name\";i:1;s:4:\"slug\";i:2;s:12:\"abbreviation\";i:3;s:11:\"description\";i:4;s:9:\"is_active\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:21;O:21:\"App\\Models\\DosageForm\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:12:\"dosage_forms\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:2:\"id\";i:29;s:4:\"name\";s:7:\"Shampoo\";s:4:\"slug\";s:7:\"shampoo\";s:12:\"abbreviation\";s:7:\"Shampoo\";s:11:\"description\";s:17:\"Medicated shampoo\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-09-12 21:39:10\";s:10:\"updated_at\";s:19:\"2026-09-12 21:39:10\";}s:11:\"\0*\0original\";a:8:{s:2:\"id\";i:29;s:4:\"name\";s:7:\"Shampoo\";s:4:\"slug\";s:7:\"shampoo\";s:12:\"abbreviation\";s:7:\"Shampoo\";s:11:\"description\";s:17:\"Medicated shampoo\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-09-12 21:39:10\";s:10:\"updated_at\";s:19:\"2026-09-12 21:39:10\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:1:{s:9:\"is_active\";s:7:\"boolean\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:4:\"name\";i:1;s:4:\"slug\";i:2;s:12:\"abbreviation\";i:3;s:11:\"description\";i:4;s:9:\"is_active\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:22;O:21:\"App\\Models\\DosageForm\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:12:\"dosage_forms\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:2:\"id\";i:23;s:4:\"name\";s:15:\"Softgel Capsule\";s:4:\"slug\";s:15:\"softgel-capsule\";s:12:\"abbreviation\";s:2:\"mg\";s:11:\"description\";s:20:\"Soft gelatin capsule\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-09-12 21:39:10\";s:10:\"updated_at\";s:19:\"2026-09-12 21:39:10\";}s:11:\"\0*\0original\";a:8:{s:2:\"id\";i:23;s:4:\"name\";s:15:\"Softgel Capsule\";s:4:\"slug\";s:15:\"softgel-capsule\";s:12:\"abbreviation\";s:2:\"mg\";s:11:\"description\";s:20:\"Soft gelatin capsule\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-09-12 21:39:10\";s:10:\"updated_at\";s:19:\"2026-09-12 21:39:10\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:1:{s:9:\"is_active\";s:7:\"boolean\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:4:\"name\";i:1;s:4:\"slug\";i:2;s:12:\"abbreviation\";i:3;s:11:\"description\";i:4;s:9:\"is_active\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:23;O:21:\"App\\Models\\DosageForm\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:12:\"dosage_forms\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:2:\"id\";i:12;s:4:\"name\";s:5:\"Spray\";s:4:\"slug\";s:5:\"spray\";s:12:\"abbreviation\";s:2:\"ml\";s:11:\"description\";s:22:\"Medicine in spray form\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-09-12 21:39:10\";s:10:\"updated_at\";s:19:\"2026-09-12 21:39:10\";}s:11:\"\0*\0original\";a:8:{s:2:\"id\";i:12;s:4:\"name\";s:5:\"Spray\";s:4:\"slug\";s:5:\"spray\";s:12:\"abbreviation\";s:2:\"ml\";s:11:\"description\";s:22:\"Medicine in spray form\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-09-12 21:39:10\";s:10:\"updated_at\";s:19:\"2026-09-12 21:39:10\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:1:{s:9:\"is_active\";s:7:\"boolean\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:4:\"name\";i:1;s:4:\"slug\";i:2;s:12:\"abbreviation\";i:3;s:11:\"description\";i:4;s:9:\"is_active\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:24;O:21:\"App\\Models\\DosageForm\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:12:\"dosage_forms\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:2:\"id\";i:20;s:4:\"name\";s:17:\"Sublingual Tablet\";s:4:\"slug\";s:17:\"sublingual-tablet\";s:12:\"abbreviation\";s:2:\"mg\";s:11:\"description\";s:23:\"Placed under the tongue\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-09-12 21:39:10\";s:10:\"updated_at\";s:19:\"2026-09-12 21:39:10\";}s:11:\"\0*\0original\";a:8:{s:2:\"id\";i:20;s:4:\"name\";s:17:\"Sublingual Tablet\";s:4:\"slug\";s:17:\"sublingual-tablet\";s:12:\"abbreviation\";s:2:\"mg\";s:11:\"description\";s:23:\"Placed under the tongue\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-09-12 21:39:10\";s:10:\"updated_at\";s:19:\"2026-09-12 21:39:10\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:1:{s:9:\"is_active\";s:7:\"boolean\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:4:\"name\";i:1;s:4:\"slug\";i:2;s:12:\"abbreviation\";i:3;s:11:\"description\";i:4;s:9:\"is_active\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:25;O:21:\"App\\Models\\DosageForm\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:12:\"dosage_forms\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:2:\"id\";i:13;s:4:\"name\";s:11:\"Suppository\";s:4:\"slug\";s:11:\"suppository\";s:12:\"abbreviation\";s:2:\"mg\";s:11:\"description\";s:36:\"Medicine inserted into rectum/vagina\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-09-12 21:39:10\";s:10:\"updated_at\";s:19:\"2026-09-12 21:39:10\";}s:11:\"\0*\0original\";a:8:{s:2:\"id\";i:13;s:4:\"name\";s:11:\"Suppository\";s:4:\"slug\";s:11:\"suppository\";s:12:\"abbreviation\";s:2:\"mg\";s:11:\"description\";s:36:\"Medicine inserted into rectum/vagina\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-09-12 21:39:10\";s:10:\"updated_at\";s:19:\"2026-09-12 21:39:10\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:1:{s:9:\"is_active\";s:7:\"boolean\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:4:\"name\";i:1;s:4:\"slug\";i:2;s:12:\"abbreviation\";i:3;s:11:\"description\";i:4;s:9:\"is_active\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:26;O:21:\"App\\Models\\DosageForm\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:12:\"dosage_forms\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:2:\"id\";i:24;s:4:\"name\";s:23:\"Suppository (Pediatric)\";s:4:\"slug\";s:21:\"suppository-pediatric\";s:12:\"abbreviation\";s:2:\"mg\";s:11:\"description\";s:21:\"Pediatric suppository\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-09-12 21:39:10\";s:10:\"updated_at\";s:19:\"2026-09-12 21:39:10\";}s:11:\"\0*\0original\";a:8:{s:2:\"id\";i:24;s:4:\"name\";s:23:\"Suppository (Pediatric)\";s:4:\"slug\";s:21:\"suppository-pediatric\";s:12:\"abbreviation\";s:2:\"mg\";s:11:\"description\";s:21:\"Pediatric suppository\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-09-12 21:39:10\";s:10:\"updated_at\";s:19:\"2026-09-12 21:39:10\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:1:{s:9:\"is_active\";s:7:\"boolean\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:4:\"name\";i:1;s:4:\"slug\";i:2;s:12:\"abbreviation\";i:3;s:11:\"description\";i:4;s:9:\"is_active\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:27;O:21:\"App\\Models\\DosageForm\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:12:\"dosage_forms\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:2:\"id\";i:4;s:4:\"name\";s:10:\"Suspension\";s:4:\"slug\";s:10:\"suspension\";s:12:\"abbreviation\";s:2:\"ml\";s:11:\"description\";s:27:\"Liquid with solid particles\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-09-12 21:39:10\";s:10:\"updated_at\";s:19:\"2026-09-12 21:39:10\";}s:11:\"\0*\0original\";a:8:{s:2:\"id\";i:4;s:4:\"name\";s:10:\"Suspension\";s:4:\"slug\";s:10:\"suspension\";s:12:\"abbreviation\";s:2:\"ml\";s:11:\"description\";s:27:\"Liquid with solid particles\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-09-12 21:39:10\";s:10:\"updated_at\";s:19:\"2026-09-12 21:39:10\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:1:{s:9:\"is_active\";s:7:\"boolean\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:4:\"name\";i:1;s:4:\"slug\";i:2;s:12:\"abbreviation\";i:3;s:11:\"description\";i:4;s:9:\"is_active\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:28;O:21:\"App\\Models\\DosageForm\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:12:\"dosage_forms\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:2:\"id\";i:3;s:4:\"name\";s:5:\"Syrup\";s:4:\"slug\";s:5:\"syrup\";s:12:\"abbreviation\";s:2:\"ml\";s:11:\"description\";s:20:\"Liquid oral medicine\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-09-12 21:39:10\";s:10:\"updated_at\";s:19:\"2026-09-12 21:39:10\";}s:11:\"\0*\0original\";a:8:{s:2:\"id\";i:3;s:4:\"name\";s:5:\"Syrup\";s:4:\"slug\";s:5:\"syrup\";s:12:\"abbreviation\";s:2:\"ml\";s:11:\"description\";s:20:\"Liquid oral medicine\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-09-12 21:39:10\";s:10:\"updated_at\";s:19:\"2026-09-12 21:39:10\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:1:{s:9:\"is_active\";s:7:\"boolean\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:4:\"name\";i:1;s:4:\"slug\";i:2;s:12:\"abbreviation\";i:3;s:11:\"description\";i:4;s:9:\"is_active\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:29;O:21:\"App\\Models\\DosageForm\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:12:\"dosage_forms\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:2:\"id\";i:1;s:4:\"name\";s:6:\"Tablet\";s:4:\"slug\";s:6:\"tablet\";s:12:\"abbreviation\";s:2:\"mg\";s:11:\"description\";s:22:\"Solid oral dosage form\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-09-12 21:39:10\";s:10:\"updated_at\";s:19:\"2026-09-12 21:39:10\";}s:11:\"\0*\0original\";a:8:{s:2:\"id\";i:1;s:4:\"name\";s:6:\"Tablet\";s:4:\"slug\";s:6:\"tablet\";s:12:\"abbreviation\";s:2:\"mg\";s:11:\"description\";s:22:\"Solid oral dosage form\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-09-12 21:39:10\";s:10:\"updated_at\";s:19:\"2026-09-12 21:39:10\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:1:{s:9:\"is_active\";s:7:\"boolean\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:4:\"name\";i:1;s:4:\"slug\";i:2;s:12:\"abbreviation\";i:3;s:11:\"description\";i:4;s:9:\"is_active\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}', 1789278661);
INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('aer-pharmacy-cache-drug_classifications', 'O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:5:{i:0;O:29:\"App\\Models\\DrugClassification\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:20:\"drug_classifications\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:13:{s:2:\"id\";i:13;s:4:\"name\";s:20:\"Controlled Substance\";s:4:\"slug\";s:10:\"controlled\";s:11:\"description\";s:30:\"Medicines with abuse potential\";s:5:\"color\";s:7:\"#F59E0B\";s:21:\"requires_prescription\";i:1;s:25:\"requires_special_handling\";i:1;s:16:\"requires_logging\";i:1;s:9:\"is_active\";i:1;s:13:\"display_order\";i:3;s:10:\"created_at\";s:19:\"2026-09-12 21:42:32\";s:10:\"updated_at\";s:19:\"2026-09-12 21:42:32\";s:10:\"deleted_at\";N;}s:11:\"\0*\0original\";a:13:{s:2:\"id\";i:13;s:4:\"name\";s:20:\"Controlled Substance\";s:4:\"slug\";s:10:\"controlled\";s:11:\"description\";s:30:\"Medicines with abuse potential\";s:5:\"color\";s:7:\"#F59E0B\";s:21:\"requires_prescription\";i:1;s:25:\"requires_special_handling\";i:1;s:16:\"requires_logging\";i:1;s:9:\"is_active\";i:1;s:13:\"display_order\";i:3;s:10:\"created_at\";s:19:\"2026-09-12 21:42:32\";s:10:\"updated_at\";s:19:\"2026-09-12 21:42:32\";s:10:\"deleted_at\";N;}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:4:{s:21:\"requires_prescription\";s:7:\"boolean\";s:25:\"requires_special_handling\";s:7:\"boolean\";s:16:\"requires_logging\";s:7:\"boolean\";s:9:\"is_active\";s:7:\"boolean\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:11:{i:0;s:4:\"name\";i:1;s:4:\"slug\";i:2;s:4:\"icon\";i:3;s:11:\"description\";i:4;s:5:\"color\";i:5;s:4:\"type\";i:6;s:21:\"requires_prescription\";i:7;s:25:\"requires_special_handling\";i:8;s:16:\"requires_logging\";i:9;s:9:\"is_active\";i:10;s:13:\"display_order\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:1;O:29:\"App\\Models\\DrugClassification\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:20:\"drug_classifications\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:13:{s:2:\"id\";i:14;s:4:\"name\";s:14:\"Dangerous Drug\";s:4:\"slug\";s:9:\"dangerous\";s:11:\"description\";s:37:\"Highly regulated, dangerous medicines\";s:5:\"color\";s:7:\"#EF4444\";s:21:\"requires_prescription\";i:1;s:25:\"requires_special_handling\";i:1;s:16:\"requires_logging\";i:1;s:9:\"is_active\";i:1;s:13:\"display_order\";i:4;s:10:\"created_at\";s:19:\"2026-09-12 21:42:32\";s:10:\"updated_at\";s:19:\"2026-09-12 21:42:32\";s:10:\"deleted_at\";N;}s:11:\"\0*\0original\";a:13:{s:2:\"id\";i:14;s:4:\"name\";s:14:\"Dangerous Drug\";s:4:\"slug\";s:9:\"dangerous\";s:11:\"description\";s:37:\"Highly regulated, dangerous medicines\";s:5:\"color\";s:7:\"#EF4444\";s:21:\"requires_prescription\";i:1;s:25:\"requires_special_handling\";i:1;s:16:\"requires_logging\";i:1;s:9:\"is_active\";i:1;s:13:\"display_order\";i:4;s:10:\"created_at\";s:19:\"2026-09-12 21:42:32\";s:10:\"updated_at\";s:19:\"2026-09-12 21:42:32\";s:10:\"deleted_at\";N;}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:4:{s:21:\"requires_prescription\";s:7:\"boolean\";s:25:\"requires_special_handling\";s:7:\"boolean\";s:16:\"requires_logging\";s:7:\"boolean\";s:9:\"is_active\";s:7:\"boolean\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:11:{i:0;s:4:\"name\";i:1;s:4:\"slug\";i:2;s:4:\"icon\";i:3;s:11:\"description\";i:4;s:5:\"color\";i:5;s:4:\"type\";i:6;s:21:\"requires_prescription\";i:7;s:25:\"requires_special_handling\";i:8;s:16:\"requires_logging\";i:9;s:9:\"is_active\";i:10;s:13:\"display_order\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:2;O:29:\"App\\Models\\DrugClassification\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:20:\"drug_classifications\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:13:{s:2:\"id\";i:11;s:4:\"name\";s:22:\"Over-the-Counter (OTC)\";s:4:\"slug\";s:3:\"otc\";s:11:\"description\";s:40:\"Medicines available without prescription\";s:5:\"color\";s:7:\"#22C55E\";s:21:\"requires_prescription\";i:0;s:25:\"requires_special_handling\";i:0;s:16:\"requires_logging\";i:0;s:9:\"is_active\";i:1;s:13:\"display_order\";i:1;s:10:\"created_at\";s:19:\"2026-09-12 21:42:32\";s:10:\"updated_at\";s:19:\"2026-09-12 21:42:32\";s:10:\"deleted_at\";N;}s:11:\"\0*\0original\";a:13:{s:2:\"id\";i:11;s:4:\"name\";s:22:\"Over-the-Counter (OTC)\";s:4:\"slug\";s:3:\"otc\";s:11:\"description\";s:40:\"Medicines available without prescription\";s:5:\"color\";s:7:\"#22C55E\";s:21:\"requires_prescription\";i:0;s:25:\"requires_special_handling\";i:0;s:16:\"requires_logging\";i:0;s:9:\"is_active\";i:1;s:13:\"display_order\";i:1;s:10:\"created_at\";s:19:\"2026-09-12 21:42:32\";s:10:\"updated_at\";s:19:\"2026-09-12 21:42:32\";s:10:\"deleted_at\";N;}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:4:{s:21:\"requires_prescription\";s:7:\"boolean\";s:25:\"requires_special_handling\";s:7:\"boolean\";s:16:\"requires_logging\";s:7:\"boolean\";s:9:\"is_active\";s:7:\"boolean\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:11:{i:0;s:4:\"name\";i:1;s:4:\"slug\";i:2;s:4:\"icon\";i:3;s:11:\"description\";i:4;s:5:\"color\";i:5;s:4:\"type\";i:6;s:21:\"requires_prescription\";i:7;s:25:\"requires_special_handling\";i:8;s:16:\"requires_logging\";i:9;s:9:\"is_active\";i:10;s:13:\"display_order\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:3;O:29:\"App\\Models\\DrugClassification\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:20:\"drug_classifications\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:13:{s:2:\"id\";i:12;s:4:\"name\";s:17:\"Prescription (Rx)\";s:4:\"slug\";s:12:\"prescription\";s:11:\"description\";s:41:\"Medicines requiring doctor\'s prescription\";s:5:\"color\";s:7:\"#3B82F6\";s:21:\"requires_prescription\";i:1;s:25:\"requires_special_handling\";i:0;s:16:\"requires_logging\";i:1;s:9:\"is_active\";i:1;s:13:\"display_order\";i:2;s:10:\"created_at\";s:19:\"2026-09-12 21:42:32\";s:10:\"updated_at\";s:19:\"2026-09-12 21:42:32\";s:10:\"deleted_at\";N;}s:11:\"\0*\0original\";a:13:{s:2:\"id\";i:12;s:4:\"name\";s:17:\"Prescription (Rx)\";s:4:\"slug\";s:12:\"prescription\";s:11:\"description\";s:41:\"Medicines requiring doctor\'s prescription\";s:5:\"color\";s:7:\"#3B82F6\";s:21:\"requires_prescription\";i:1;s:25:\"requires_special_handling\";i:0;s:16:\"requires_logging\";i:1;s:9:\"is_active\";i:1;s:13:\"display_order\";i:2;s:10:\"created_at\";s:19:\"2026-09-12 21:42:32\";s:10:\"updated_at\";s:19:\"2026-09-12 21:42:32\";s:10:\"deleted_at\";N;}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:4:{s:21:\"requires_prescription\";s:7:\"boolean\";s:25:\"requires_special_handling\";s:7:\"boolean\";s:16:\"requires_logging\";s:7:\"boolean\";s:9:\"is_active\";s:7:\"boolean\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:11:{i:0;s:4:\"name\";i:1;s:4:\"slug\";i:2;s:4:\"icon\";i:3;s:11:\"description\";i:4;s:5:\"color\";i:5;s:4:\"type\";i:6;s:21:\"requires_prescription\";i:7;s:25:\"requires_special_handling\";i:8;s:16:\"requires_logging\";i:9;s:9:\"is_active\";i:10;s:13:\"display_order\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:4;O:29:\"App\\Models\\DrugClassification\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:20:\"drug_classifications\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:13:{s:2:\"id\";i:15;s:4:\"name\";s:7:\"Vaccine\";s:4:\"slug\";s:7:\"vaccine\";s:11:\"description\";s:22:\"Immunization medicines\";s:5:\"color\";s:7:\"#06B6D4\";s:21:\"requires_prescription\";i:1;s:25:\"requires_special_handling\";i:1;s:16:\"requires_logging\";i:1;s:9:\"is_active\";i:1;s:13:\"display_order\";i:5;s:10:\"created_at\";s:19:\"2026-09-12 21:42:32\";s:10:\"updated_at\";s:19:\"2026-09-12 21:42:32\";s:10:\"deleted_at\";N;}s:11:\"\0*\0original\";a:13:{s:2:\"id\";i:15;s:4:\"name\";s:7:\"Vaccine\";s:4:\"slug\";s:7:\"vaccine\";s:11:\"description\";s:22:\"Immunization medicines\";s:5:\"color\";s:7:\"#06B6D4\";s:21:\"requires_prescription\";i:1;s:25:\"requires_special_handling\";i:1;s:16:\"requires_logging\";i:1;s:9:\"is_active\";i:1;s:13:\"display_order\";i:5;s:10:\"created_at\";s:19:\"2026-09-12 21:42:32\";s:10:\"updated_at\";s:19:\"2026-09-12 21:42:32\";s:10:\"deleted_at\";N;}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:4:{s:21:\"requires_prescription\";s:7:\"boolean\";s:25:\"requires_special_handling\";s:7:\"boolean\";s:16:\"requires_logging\";s:7:\"boolean\";s:9:\"is_active\";s:7:\"boolean\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:11:{i:0;s:4:\"name\";i:1;s:4:\"slug\";i:2;s:4:\"icon\";i:3;s:11:\"description\";i:4;s:5:\"color\";i:5;s:4:\"type\";i:6;s:21:\"requires_prescription\";i:7;s:25:\"requires_special_handling\";i:8;s:16:\"requires_logging\";i:9;s:9:\"is_active\";i:10;s:13:\"display_order\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}', 1789278661),
('aer-pharmacy-cache-inventory_stats', 'a:5:{s:14:\"total_products\";i:5;s:13:\"total_batches\";i:7;s:9:\"low_stock\";i:0;s:7:\"expired\";i:0;s:5:\"queue\";i:8;}', 1789277352),
('aer-pharmacy-cache-queue_count', 'i:8;', 1789277352),
('aer-pharmacy-cache-spatie.permission.cache', 'a:3:{s:5:\"alias\";a:4:{s:1:\"a\";s:2:\"id\";s:1:\"b\";s:4:\"name\";s:1:\"c\";s:10:\"guard_name\";s:1:\"r\";s:5:\"roles\";}s:11:\"permissions\";a:59:{i:0;a:4:{s:1:\"a\";i:1;s:1:\"b\";s:14:\"view dashboard\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:4:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;}}i:1;a:4:{s:1:\"a\";i:2;s:1:\"b\";s:18:\"view sales metrics\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:4;}}i:2;a:4:{s:1:\"a\";i:3;s:1:\"b\";s:22:\"view inventory metrics\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:4;}}i:3;a:4:{s:1:\"a\";i:4;s:1:\"b\";s:14:\"view inventory\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:4;}}i:4;a:4:{s:1:\"a\";i:5;s:1:\"b\";s:24:\"view inventory read only\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:5;a:4:{s:1:\"a\";i:6;s:1:\"b\";s:16:\"create inventory\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:4;}}i:6;a:4:{s:1:\"a\";i:7;s:1:\"b\";s:14:\"edit inventory\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:4;}}i:7;a:4:{s:1:\"a\";i:8;s:1:\"b\";s:12:\"update stock\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:4;}}i:8;a:4:{s:1:\"a\";i:9;s:1:\"b\";s:22:\"view inventory reports\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:4;}}i:9;a:4:{s:1:\"a\";i:10;s:1:\"b\";s:8:\"view pos\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:4;}}i:10;a:4:{s:1:\"a\";i:11;s:1:\"b\";s:15:\"process payment\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:4;}}i:11;a:4:{s:1:\"a\";i:12;s:1:\"b\";s:16:\"void transaction\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:12;a:4:{s:1:\"a\";i:13;s:1:\"b\";s:14:\"print receipts\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:4;}}i:13;a:4:{s:1:\"a\";i:14;s:1:\"b\";s:13:\"view receipts\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:4;}}i:14;a:4:{s:1:\"a\";i:15;s:1:\"b\";s:17:\"view own receipts\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:15;a:4:{s:1:\"a\";i:16;s:1:\"b\";s:11:\"view promos\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:4:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;}}i:16;a:4:{s:1:\"a\";i:17;s:1:\"b\";s:13:\"manage promos\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:4;}}i:17;a:4:{s:1:\"a\";i:18;s:1:\"b\";s:14:\"view discounts\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:4:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;}}i:18;a:4:{s:1:\"a\";i:19;s:1:\"b\";s:16:\"manage discounts\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:4;}}i:19;a:4:{s:1:\"a\";i:20;s:1:\"b\";s:13:\"view products\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:4:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;}}i:20;a:4:{s:1:\"a\";i:21;s:1:\"b\";s:14:\"create product\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:4;}}i:21;a:4:{s:1:\"a\";i:22;s:1:\"b\";s:12:\"edit product\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:4;}}i:22;a:4:{s:1:\"a\";i:23;s:1:\"b\";s:14:\"delete product\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:4;}}i:23;a:4:{s:1:\"a\";i:24;s:1:\"b\";s:15:\"view categories\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:4;}}i:24;a:4:{s:1:\"a\";i:25;s:1:\"b\";s:17:\"manage categories\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:4;}}i:25;a:4:{s:1:\"a\";i:26;s:1:\"b\";s:25:\"view drug classifications\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:4;}}i:26;a:4:{s:1:\"a\";i:27;s:1:\"b\";s:27:\"create drug classifications\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:4;}}i:27;a:4:{s:1:\"a\";i:28;s:1:\"b\";s:25:\"edit drug classifications\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:4;}}i:28;a:4:{s:1:\"a\";i:29;s:1:\"b\";s:27:\"delete drug classifications\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:4;}}i:29;a:4:{s:1:\"a\";i:30;s:1:\"b\";s:17:\"view dosage forms\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:4;}}i:30;a:4:{s:1:\"a\";i:31;s:1:\"b\";s:19:\"create dosage forms\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:4;}}i:31;a:4:{s:1:\"a\";i:32;s:1:\"b\";s:17:\"edit dosage forms\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:4;}}i:32;a:4:{s:1:\"a\";i:33;s:1:\"b\";s:19:\"delete dosage forms\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:4;}}i:33;a:4:{s:1:\"a\";i:34;s:1:\"b\";s:18:\"view sales reports\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:34;a:4:{s:1:\"a\";i:35;s:1:\"b\";s:14:\"export reports\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:35;a:4:{s:1:\"a\";i:36;s:1:\"b\";s:10:\"view users\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:36;a:4:{s:1:\"a\";i:37;s:1:\"b\";s:12:\"create users\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:37;a:4:{s:1:\"a\";i:38;s:1:\"b\";s:10:\"edit users\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:38;a:4:{s:1:\"a\";i:39;s:1:\"b\";s:12:\"delete users\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:39;a:4:{s:1:\"a\";i:40;s:1:\"b\";s:10:\"view roles\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:40;a:4:{s:1:\"a\";i:41;s:1:\"b\";s:12:\"create roles\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:41;a:4:{s:1:\"a\";i:42;s:1:\"b\";s:10:\"edit roles\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:42;a:4:{s:1:\"a\";i:43;s:1:\"b\";s:12:\"delete roles\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:43;a:4:{s:1:\"a\";i:44;s:1:\"b\";s:20:\"reset user passwords\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:44;a:4:{s:1:\"a\";i:45;s:1:\"b\";s:16:\"view permissions\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:45;a:4:{s:1:\"a\";i:46;s:1:\"b\";s:18:\"create permissions\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:46;a:4:{s:1:\"a\";i:47;s:1:\"b\";s:16:\"edit permissions\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:47;a:4:{s:1:\"a\";i:48;s:1:\"b\";s:18:\"delete permissions\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:48;a:4:{s:1:\"a\";i:49;s:1:\"b\";s:12:\"manage roles\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:49;a:4:{s:1:\"a\";i:50;s:1:\"b\";s:18:\"manage permissions\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:50;a:4:{s:1:\"a\";i:51;s:1:\"b\";s:18:\"view prescriptions\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:4;}}i:51;a:4:{s:1:\"a\";i:52;s:1:\"b\";s:20:\"create prescriptions\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:4;}}i:52;a:4:{s:1:\"a\";i:53;s:1:\"b\";s:18:\"edit prescriptions\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:4;}}i:53;a:4:{s:1:\"a\";i:54;s:1:\"b\";s:20:\"delete prescriptions\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:4;}}i:54;a:4:{s:1:\"a\";i:55;s:1:\"b\";s:13:\"view settings\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:55;a:4:{s:1:\"a\";i:56;s:1:\"b\";s:13:\"edit settings\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:56;a:4:{s:1:\"a\";i:57;s:1:\"b\";s:9:\"view logs\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:57;a:4:{s:1:\"a\";i:58;s:1:\"b\";s:11:\"delete logs\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:58;a:4:{s:1:\"a\";i:59;s:1:\"b\";s:15:\"test permission\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}}s:5:\"roles\";a:4:{i:0;a:3:{s:1:\"a\";i:1;s:1:\"b\";s:5:\"Admin\";s:1:\"c\";s:3:\"web\";}i:1;a:3:{s:1:\"a\";i:2;s:1:\"b\";s:7:\"Cashier\";s:1:\"c\";s:3:\"web\";}i:2;a:3:{s:1:\"a\";i:3;s:1:\"b\";s:18:\"Pharmacy Assistant\";s:1:\"c\";s:3:\"web\";}i:3;a:3:{s:1:\"a\";i:4;s:1:\"b\";s:10:\"Pharmacist\";s:1:\"c\";s:3:\"web\";}}}', 1789306094),
('aer-pharmacy-cache-total_batches', 'i:7;', 1789277352);

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
(1, 'Analgesic', 'analgesic', 'Pain reliever medicines', '2026-09-12 13:30:16', '2026-09-12 13:30:16'),
(2, 'Antibiotic', 'antibiotic', 'Medicines for bacterial infections', '2026-09-12 13:30:16', '2026-09-12 13:30:16'),
(3, 'Antipyretic', 'antipyretic', 'Fever reducer medicines', '2026-09-12 13:30:16', '2026-09-12 13:30:16'),
(4, 'Antihistamine', 'antihistamine', 'Allergy relief medicines', '2026-09-12 13:30:16', '2026-09-12 13:30:16'),
(5, 'Antacid', 'antacid', 'Stomach acid neutralizer', '2026-09-12 13:30:16', '2026-09-12 13:30:16'),
(6, 'Antiseptic', 'antiseptic', 'Wound cleaning and infection prevention', '2026-09-12 13:30:16', '2026-09-12 13:30:16'),
(7, 'Vitamin', 'vitamin', 'Dietary supplements', '2026-09-12 13:30:16', '2026-09-12 13:30:16'),
(8, 'Cardiovascular', 'cardiovascular', 'Heart and blood pressure medicines', '2026-09-12 13:30:16', '2026-09-12 13:30:16'),
(9, 'Antidiabetic', 'antidiabetic', 'Diabetes management medicines', '2026-09-12 13:30:16', '2026-09-12 13:30:16'),
(10, 'Respiratory', 'respiratory', 'Breathing and lung medicines', '2026-09-12 13:30:16', '2026-09-12 13:30:16'),
(11, 'Gastrointestinal', 'gastrointestinal', 'Digestive system medicines', '2026-09-12 13:30:16', '2026-09-12 13:30:16'),
(12, 'Cough & Cold', 'cough-cold', 'Cough and cold relief medicines', '2026-09-12 13:30:16', '2026-09-12 13:30:16'),
(13, 'Anti-inflammatory', 'anti-inflammatory', 'Inflammation reducer medicines', '2026-09-12 13:30:16', '2026-09-12 13:30:16'),
(14, 'Sedative', 'sedative', 'Sleep and relaxation medicines', '2026-09-12 13:30:16', '2026-09-12 13:30:16'),
(15, 'Antifungal', 'antifungal', 'Fungal infection treatment', '2026-09-12 13:30:16', '2026-09-12 13:30:16');

-- --------------------------------------------------------

--
-- Table structure for table `discount_types`
--

CREATE TABLE `discount_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `discount_percent` decimal(5,2) NOT NULL,
  `requires_id` tinyint(1) NOT NULL DEFAULT 1,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dosage_forms`
--

CREATE TABLE `dosage_forms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `abbreviation` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dosage_forms`
--

INSERT INTO `dosage_forms` (`id`, `name`, `slug`, `abbreviation`, `description`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Tablet', 'tablet', 'mg', 'Solid oral dosage form', 1, '2026-09-12 13:39:10', '2026-09-12 13:39:10'),
(2, 'Capsule', 'capsule', 'mg', 'Gelatin shell oral dosage form', 1, '2026-09-12 13:39:10', '2026-09-12 13:39:10'),
(3, 'Syrup', 'syrup', 'ml', 'Liquid oral medicine', 1, '2026-09-12 13:39:10', '2026-09-12 13:39:10'),
(4, 'Suspension', 'suspension', 'ml', 'Liquid with solid particles', 1, '2026-09-12 13:39:10', '2026-09-12 13:39:10'),
(5, 'Drops', 'drops', 'ml', 'Liquid drops for eyes/ears/nose', 1, '2026-09-12 13:39:10', '2026-09-12 13:39:10'),
(6, 'Ointment', 'ointment', 'g', 'Semi-solid topical medicine', 1, '2026-09-12 13:39:10', '2026-09-12 13:39:10'),
(7, 'Cream', 'cream', 'g', 'Topical cream medicine', 1, '2026-09-12 13:39:10', '2026-09-12 13:39:10'),
(8, 'Gel', 'gel', 'g', 'Topical gel medicine', 1, '2026-09-12 13:39:10', '2026-09-12 13:39:10'),
(9, 'Lotion', 'lotion', 'g', 'Topical liquid medicine', 1, '2026-09-12 13:39:10', '2026-09-12 13:39:10'),
(10, 'Injection', 'injection', 'ml', 'Sterile liquid for injection', 1, '2026-09-12 13:39:10', '2026-09-12 13:39:10'),
(11, 'Inhaler', 'inhaler', 'mcg', 'Medicine for inhalation', 1, '2026-09-12 13:39:10', '2026-09-12 13:39:10'),
(12, 'Spray', 'spray', 'ml', 'Medicine in spray form', 1, '2026-09-12 13:39:10', '2026-09-12 13:39:10'),
(13, 'Suppository', 'suppository', 'mg', 'Medicine inserted into rectum/vagina', 1, '2026-09-12 13:39:10', '2026-09-12 13:39:10'),
(14, 'Patch', 'patch', 'mg', 'Transdermal patch', 1, '2026-09-12 13:39:10', '2026-09-12 13:39:10'),
(15, 'Powder', 'powder', 'mg', 'Powder medicine', 1, '2026-09-12 13:39:10', '2026-09-12 13:39:10'),
(16, 'Granules', 'granules', 'mg', 'Granular medicine', 1, '2026-09-12 13:39:10', '2026-09-12 13:39:10'),
(17, 'Lozenge', 'lozenge', 'mg', 'Dissolvable oral tablet', 1, '2026-09-12 13:39:10', '2026-09-12 13:39:10'),
(18, 'Chewable Tablet', 'chewable-tablet', 'mg', 'Tablet to be chewed', 1, '2026-09-12 13:39:10', '2026-09-12 13:39:10'),
(19, 'Effervescent Tablet', 'effervescent-tablet', 'mg', 'Dissolvable in water', 1, '2026-09-12 13:39:10', '2026-09-12 13:39:10'),
(20, 'Sublingual Tablet', 'sublingual-tablet', 'mg', 'Placed under the tongue', 1, '2026-09-12 13:39:10', '2026-09-12 13:39:10'),
(21, 'Enteric-Coated Tablet', 'enteric-coated-tablet', 'mg', 'Delayed-release tablet', 1, '2026-09-12 13:39:10', '2026-09-12 13:39:10'),
(22, 'Extended-Release Tablet', 'extended-release-tablet', 'mg', 'Slow-release tablet', 1, '2026-09-12 13:39:10', '2026-09-12 13:39:10'),
(23, 'Softgel Capsule', 'softgel-capsule', 'mg', 'Soft gelatin capsule', 1, '2026-09-12 13:39:10', '2026-09-12 13:39:10'),
(24, 'Suppository (Pediatric)', 'suppository-pediatric', 'mg', 'Pediatric suppository', 1, '2026-09-12 13:39:10', '2026-09-12 13:39:10'),
(25, 'Nasal Spray', 'nasal-spray', 'ml', 'Medicine for nose', 1, '2026-09-12 13:39:10', '2026-09-12 13:39:10'),
(26, 'Eye Drops', 'eye-drops', 'Eye Drops', 'Medicine for eyes', 1, '2026-09-12 13:39:10', '2026-09-12 13:39:10'),
(27, 'Ear Drops', 'ear-drops', 'Ear Drops', 'Medicine for ears', 1, '2026-09-12 13:39:10', '2026-09-12 13:39:10'),
(28, 'Mouthwash', 'mouthwash', 'Mouthwash', 'Oral rinse medicine', 1, '2026-09-12 13:39:10', '2026-09-12 13:39:10'),
(29, 'Shampoo', 'shampoo', 'Shampoo', 'Medicated shampoo', 1, '2026-09-12 13:39:10', '2026-09-12 13:39:10'),
(30, 'Foam', 'foam', 'Foam', 'Topical foam medicine', 1, '2026-09-12 13:39:10', '2026-09-12 13:39:10');

-- --------------------------------------------------------

--
-- Table structure for table `drug_classifications`
--

CREATE TABLE `drug_classifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `color` varchar(255) NOT NULL DEFAULT '#6c757d',
  `requires_prescription` tinyint(1) NOT NULL DEFAULT 0,
  `requires_special_handling` tinyint(1) NOT NULL DEFAULT 0,
  `requires_logging` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `display_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `drug_classifications`
--

INSERT INTO `drug_classifications` (`id`, `name`, `slug`, `description`, `color`, `requires_prescription`, `requires_special_handling`, `requires_logging`, `is_active`, `display_order`, `created_at`, `updated_at`, `deleted_at`) VALUES
(11, 'Over-the-Counter (OTC)', 'otc', 'Medicines available without prescription', '#22C55E', 0, 0, 0, 1, 1, '2026-09-12 13:42:32', '2026-09-12 13:42:32', NULL),
(12, 'Prescription (Rx)', 'prescription', 'Medicines requiring doctor\'s prescription', '#3B82F6', 1, 0, 1, 1, 2, '2026-09-12 13:42:32', '2026-09-12 13:42:32', NULL),
(13, 'Controlled Substance', 'controlled', 'Medicines with abuse potential', '#F59E0B', 1, 1, 1, 1, 3, '2026-09-12 13:42:32', '2026-09-12 13:42:32', NULL),
(14, 'Dangerous Drug', 'dangerous', 'Highly regulated, dangerous medicines', '#EF4444', 1, 1, 1, 1, 4, '2026-09-12 13:42:32', '2026-09-12 13:42:32', NULL),
(15, 'Vaccine', 'vaccine', 'Immunization medicines', '#06B6D4', 1, 1, 1, 1, 5, '2026-09-12 13:42:32', '2026-09-12 13:42:32', NULL);

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
(1, '0001_01_01_000000_create_users_table', 1),
(2, '2025_11_08_112504_create_products_table', 1),
(3, '2025_11_10_074754_create_purchases_table', 1),
(4, '2025_11_22_065849_create_sales_table', 2),
(5, '2025_11_22_070022_create_sale_items_table', 3),
(6, '2025_11_23_144624_add_tax_amount_to_sales_table', 4),
(7, '2025_11_25_134234_add_discount_to_sales_table', 5),
(8, '2025_11_26_070628_create_categories_table', 6),
(9, '2025_12_09_113515_create_stock_queues_table', 7),
(10, '2025_12_09_114442_add_stock_queue_fields_to_products_table', 8),
(11, '2025_12_23_151621_create_product_batches_table', 9),
(12, '2025_12_26_101025_add_cash_fields_to_sales_table', 10),
(13, '2025_12_28_114818_create_promos_table', 11),
(14, '2025_12_30_093647_create_discount_types_table', 12),
(15, '2026_01_04_063002_fix_sales_table_structure', 13),
(16, '2026_01_04_074117_add_discount_type_fields_to_sales_table', 14),
(17, '2026_03_30_073311_add_otp_fields_to_users_table', 15),
(18, '2026_03_30_073730_create_otps_table', 16),
(19, '2026_04_01_142812_create_activity_logs_table', 17),
(20, '2026_04_02_105511_add_soft_deletes_to_users_table', 18),
(21, '2026_04_02_173408_add_id_number_fields_to_sales_table', 19),
(22, '2026_04_03_165518_add_missing_columns_to_products_table', 20),
(23, '2026_04_04_175413_create_settings_table', 21),
(24, '2026_04_06_070427_create_prescriptions_table', 22),
(25, '2026_04_06_070856_create_prescription_items_table', 23),
(26, '2026_04_28_111306_add_barcode_to_products_table', 24),
(27, '2026_04_28_131035_add_barcode_type_to_products_table', 25),
(28, '2026_05_17_095154_add_remaining_quantity_to_prescription_items', 26),
(29, '2026_05_17_124028_add_prescription_id_to_sales_table', 27),
(30, '2026_07_23_092249_add_barcode_to_stock_queues_table', 28),
(31, '2026_07_23_215920_add_group_and_description_to_settings_table', 29),
(32, '2026_07_24_075849_create_dosage_forms_table', 30),
(33, '2026_08_08_203043_create_backups_table', 31),
(34, '2026_08_23_175633_create_user_trusted_devices_table', 32),
(35, '2026_08_23_193630_add_otp_locked_until_to_users_table', 33),
(36, '2026_09_02_120732_create_drug_classifications_table', 34),
(37, '2026_09_03_221419_add_drug_classification_id_to_products_table', 35),
(38, '2025_11_10_160255_add_image_to_products_table', 36),
(39, '2025_11_12_114505_add_piece_columns_to_products_table', 36),
(40, '2025_11_12_120033_add_total_pieces_to_products_table', 36),
(41, '2025_11_20_071047_add_form_to_products_table', 36),
(42, '2025_11_23_150133_make_invoice_no_nullable_in_sales_table', 36),
(43, '2025_11_23_151247_remove_total_column_from_sales_table', 36),
(44, '2025_12_21_154258_add_dosage_columns_to_products', 36),
(45, '2025_12_23_152225_remove_stock_fields_from_products_table', 36),
(46, '2026_03_25_022133_create_permission_tables', 36),
(47, '2026_04_01_074124_add_fields_to_users_table', 36),
(48, '2026_04_03_091843_add_resume_to_users_table', 36),
(49, '2026_04_03_152847_create_product_batches_table', 36),
(50, '2026_04_04_204830_add_profile_picture_fields_to_users_table', 36),
(51, '2026_05_18_141005_create_password_reset_tokens_table', 36);

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
(1, 'App\\Models\\User', 1),
(1, 'App\\Models\\User', 2),
(2, 'App\\Models\\User', 3),
(3, 'App\\Models\\User', 4),
(4, 'App\\Models\\User', 5);

-- --------------------------------------------------------

--
-- Table structure for table `otps`
--

CREATE TABLE `otps` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `code` varchar(6) NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'login',
  `expires_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_used` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `otps`
--

INSERT INTO `otps` (`id`, `user_id`, `code`, `type`, `expires_at`, `is_used`, `created_at`, `updated_at`) VALUES
(1, 1, '365630', 'login', '2026-09-12 13:22:49', 1, '2026-09-12 13:21:27', '2026-09-12 13:21:27'),
(2, 1, '898090', 'login', '2026-09-13 05:00:08', 0, '2026-09-13 04:50:08', '2026-09-13 04:50:08');

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
(1, 'view dashboard', 'web', '2026-09-12 13:20:46', '2026-09-12 13:20:46'),
(2, 'view sales metrics', 'web', '2026-09-12 13:20:46', '2026-09-12 13:20:46'),
(3, 'view inventory metrics', 'web', '2026-09-12 13:20:46', '2026-09-12 13:20:46'),
(4, 'view inventory', 'web', '2026-09-12 13:20:46', '2026-09-12 13:20:46'),
(5, 'view inventory read only', 'web', '2026-09-12 13:20:46', '2026-09-12 13:20:46'),
(6, 'create inventory', 'web', '2026-09-12 13:20:46', '2026-09-12 13:20:46'),
(7, 'edit inventory', 'web', '2026-09-12 13:20:46', '2026-09-12 13:20:46'),
(8, 'update stock', 'web', '2026-09-12 13:20:46', '2026-09-12 13:20:46'),
(9, 'view inventory reports', 'web', '2026-09-12 13:20:46', '2026-09-12 13:20:46'),
(10, 'view pos', 'web', '2026-09-12 13:20:46', '2026-09-12 13:20:46'),
(11, 'process payment', 'web', '2026-09-12 13:20:46', '2026-09-12 13:20:46'),
(12, 'void transaction', 'web', '2026-09-12 13:20:46', '2026-09-12 13:20:46'),
(13, 'print receipts', 'web', '2026-09-12 13:20:46', '2026-09-12 13:20:46'),
(14, 'view receipts', 'web', '2026-09-12 13:20:46', '2026-09-12 13:20:46'),
(15, 'view own receipts', 'web', '2026-09-12 13:20:46', '2026-09-12 13:20:46'),
(16, 'view promos', 'web', '2026-09-12 13:20:46', '2026-09-12 13:20:46'),
(17, 'manage promos', 'web', '2026-09-12 13:20:46', '2026-09-12 13:20:46'),
(18, 'view discounts', 'web', '2026-09-12 13:20:46', '2026-09-12 13:20:46'),
(19, 'manage discounts', 'web', '2026-09-12 13:20:46', '2026-09-12 13:20:46'),
(20, 'view products', 'web', '2026-09-12 13:20:46', '2026-09-12 13:20:46'),
(21, 'create product', 'web', '2026-09-12 13:20:46', '2026-09-12 13:20:46'),
(22, 'edit product', 'web', '2026-09-12 13:20:46', '2026-09-12 13:20:46'),
(23, 'delete product', 'web', '2026-09-12 13:20:46', '2026-09-12 13:20:46'),
(24, 'view categories', 'web', '2026-09-12 13:20:46', '2026-09-12 13:20:46'),
(25, 'manage categories', 'web', '2026-09-12 13:20:46', '2026-09-12 13:20:46'),
(26, 'view drug classifications', 'web', '2026-09-12 13:20:46', '2026-09-12 13:20:46'),
(27, 'create drug classifications', 'web', '2026-09-12 13:20:46', '2026-09-12 13:20:46'),
(28, 'edit drug classifications', 'web', '2026-09-12 13:20:46', '2026-09-12 13:20:46'),
(29, 'delete drug classifications', 'web', '2026-09-12 13:20:46', '2026-09-12 13:20:46'),
(30, 'view dosage forms', 'web', '2026-09-12 13:20:46', '2026-09-12 13:20:46'),
(31, 'create dosage forms', 'web', '2026-09-12 13:20:46', '2026-09-12 13:20:46'),
(32, 'edit dosage forms', 'web', '2026-09-12 13:20:46', '2026-09-12 13:20:46'),
(33, 'delete dosage forms', 'web', '2026-09-12 13:20:46', '2026-09-12 13:20:46'),
(34, 'view sales reports', 'web', '2026-09-12 13:20:46', '2026-09-12 13:20:46'),
(35, 'export reports', 'web', '2026-09-12 13:20:46', '2026-09-12 13:20:46'),
(36, 'view users', 'web', '2026-09-12 13:20:46', '2026-09-12 13:20:46'),
(37, 'create users', 'web', '2026-09-12 13:20:47', '2026-09-12 13:20:47'),
(38, 'edit users', 'web', '2026-09-12 13:20:47', '2026-09-12 13:20:47'),
(39, 'delete users', 'web', '2026-09-12 13:20:47', '2026-09-12 13:20:47'),
(40, 'view roles', 'web', '2026-09-12 13:20:47', '2026-09-12 13:20:47'),
(41, 'create roles', 'web', '2026-09-12 13:20:47', '2026-09-12 13:20:47'),
(42, 'edit roles', 'web', '2026-09-12 13:20:47', '2026-09-12 13:20:47'),
(43, 'delete roles', 'web', '2026-09-12 13:20:47', '2026-09-12 13:20:47'),
(44, 'reset user passwords', 'web', '2026-09-12 13:20:47', '2026-09-12 13:20:47'),
(45, 'view permissions', 'web', '2026-09-12 13:20:47', '2026-09-12 13:20:47'),
(46, 'create permissions', 'web', '2026-09-12 13:20:47', '2026-09-12 13:20:47'),
(47, 'edit permissions', 'web', '2026-09-12 13:20:47', '2026-09-12 13:20:47'),
(48, 'delete permissions', 'web', '2026-09-12 13:20:47', '2026-09-12 13:20:47'),
(49, 'manage roles', 'web', '2026-09-12 13:20:47', '2026-09-12 13:20:47'),
(50, 'manage permissions', 'web', '2026-09-12 13:20:47', '2026-09-12 13:20:47'),
(51, 'view prescriptions', 'web', '2026-09-12 13:20:47', '2026-09-12 13:20:47'),
(52, 'create prescriptions', 'web', '2026-09-12 13:20:47', '2026-09-12 13:20:47'),
(53, 'edit prescriptions', 'web', '2026-09-12 13:20:47', '2026-09-12 13:20:47'),
(54, 'delete prescriptions', 'web', '2026-09-12 13:20:47', '2026-09-12 13:20:47'),
(55, 'view settings', 'web', '2026-09-12 13:20:47', '2026-09-12 13:20:47'),
(56, 'edit settings', 'web', '2026-09-12 13:20:47', '2026-09-12 13:20:47'),
(57, 'view logs', 'web', '2026-09-12 13:20:47', '2026-09-12 13:20:47'),
(58, 'delete logs', 'web', '2026-09-12 13:20:47', '2026-09-12 13:20:47'),
(59, 'test permission', 'web', '2026-09-12 13:20:47', '2026-09-12 13:20:47');

-- --------------------------------------------------------

--
-- Table structure for table `prescriptions`
--

CREATE TABLE `prescriptions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `prescription_number` varchar(255) NOT NULL,
  `patient_name` varchar(255) NOT NULL,
  `patient_age` int(11) DEFAULT NULL,
  `patient_contact` varchar(255) DEFAULT NULL,
  `patient_address` text DEFAULT NULL,
  `doctor_name` varchar(255) NOT NULL,
  `doctor_license` varchar(255) DEFAULT NULL,
  `date_issued` date NOT NULL,
  `valid_until` date DEFAULT NULL,
  `special_instructions` text DEFAULT NULL,
  `status` enum('active','used','expired','cancelled') NOT NULL DEFAULT 'active',
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `sale_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `prescription_items`
--

CREATE TABLE `prescription_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `prescription_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_name` varchar(255) NOT NULL,
  `dosage` varchar(255) DEFAULT NULL,
  `quantity_prescribed` int(11) NOT NULL,
  `frequency` varchar(255) DEFAULT NULL,
  `duration` varchar(255) DEFAULT NULL,
  `special_note` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `quantity_remaining` int(11) NOT NULL DEFAULT 0,
  `quantity_dispensed` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `barcode` varchar(255) DEFAULT NULL,
  `barcode_type` varchar(255) NOT NULL DEFAULT 'EAN13',
  `name` varchar(255) NOT NULL,
  `brand` varchar(255) DEFAULT NULL,
  `dosage_amount` decimal(10,2) DEFAULT NULL,
  `dosage_unit` varchar(10) DEFAULT NULL,
  `form` varchar(255) DEFAULT NULL,
  `type` varchar(255) NOT NULL,
  `category` varchar(255) DEFAULT NULL,
  `drug_classification_id` bigint(20) UNSIGNED DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `stock_source` enum('direct','queue') NOT NULL DEFAULT 'direct',
  `last_stock_queue_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `barcode`, `barcode_type`, `name`, `brand`, `dosage_amount`, `dosage_unit`, `form`, `type`, `category`, `drug_classification_id`, `price`, `image`, `created_at`, `updated_at`, `stock_source`, `last_stock_queue_id`) VALUES
(11, '8901234567891', 'EAN13', 'Biogesic', 'Unilab', 500.00, 'mg', 'Tablet', 'Branded', 'Analgesic', 11, 9.00, NULL, '2026-09-12 13:52:39', '2026-09-12 13:52:39', 'direct', NULL),
(12, '8901234567892', 'EAN13', 'Paracetamol', 'RHEA', 500.00, 'mg', 'Tablet', 'Generic', 'Analgesic', 11, 5.50, NULL, '2026-09-12 13:52:39', '2026-09-12 13:52:39', 'direct', NULL),
(14, '8901234567894', 'EAN13', 'Bioflu', 'Unilab', 500.00, 'mg', 'Tablet', 'Branded', 'Cough & Cold', 11, 12.50, NULL, '2026-09-12 13:52:39', '2026-09-12 13:52:39', 'direct', NULL),
(15, '8901234567895', 'EAN13', 'Neozep', 'Unilab', 500.00, 'mg', 'Tablet', 'Branded', 'Cough & Cold', 11, 10.75, NULL, '2026-09-12 13:52:39', '2026-09-12 13:52:39', 'direct', NULL),
(18, '8901234567902', 'EAN13', 'Amoxicillin', 'GlaxoSmithKline', 500.00, 'mg', 'Capsule', 'Generic', 'Antibiotic', 12, 15.00, NULL, '2026-09-12 14:11:39', '2026-09-12 14:11:39', 'direct', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_batches`
--

CREATE TABLE `product_batches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `pieces_per_box` int(11) NOT NULL,
  `pieces_left` int(11) NOT NULL,
  `total_pieces` int(11) DEFAULT NULL,
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
(1, 11, 10, 100, 1000, 1000, '2027-12-31', '2026-09-12', 'Batch 1', '2026-09-12 13:52:39', '2026-09-12 13:52:39'),
(2, 12, 8, 100, 800, 800, '2027-11-30', '2026-09-12', 'Batch 1', '2026-09-12 13:52:39', '2026-09-12 13:52:39'),
(4, 14, 12, 100, 1200, 1200, '2027-09-30', '2026-09-12', 'Batch 1', '2026-09-12 13:52:39', '2026-09-12 13:52:39'),
(5, 15, 15, 100, 1490, 1500, '2027-08-31', '2026-09-12', 'Batch 1', '2026-09-12 13:52:39', '2026-09-12 14:01:19'),
(7, 18, 8, 100, 800, 800, '2027-06-30', '2026-11-20', 'Batch 1', '2026-09-12 14:11:39', '2026-09-12 14:11:39'),
(13, 11, 8, 100, 800, 800, '2028-06-30', '2026-09-13', 'BATCH-1789231561-349', '2026-09-12 16:46:01', '2026-09-12 16:46:01'),
(14, 11, 10, 100, 1000, 1000, '2028-09-15', '2026-09-13', 'BATCH-1789231870-322', '2026-09-12 16:51:10', '2026-09-12 16:51:10');

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
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'web', '2026-09-12 13:20:46', '2026-09-12 13:20:46'),
(2, 'Cashier', 'web', '2026-09-12 13:20:46', '2026-09-12 13:20:46'),
(3, 'Pharmacy Assistant', 'web', '2026-09-12 13:20:46', '2026-09-12 13:20:46'),
(4, 'Pharmacist', 'web', '2026-09-12 13:20:46', '2026-09-12 13:20:46');

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
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(2, 1),
(2, 3),
(2, 4),
(3, 1),
(3, 3),
(3, 4),
(4, 1),
(4, 3),
(4, 4),
(5, 1),
(5, 2),
(6, 1),
(6, 3),
(6, 4),
(7, 1),
(7, 3),
(7, 4),
(8, 1),
(8, 3),
(8, 4),
(9, 1),
(9, 3),
(9, 4),
(10, 1),
(10, 2),
(10, 4),
(11, 1),
(11, 2),
(11, 4),
(12, 1),
(13, 1),
(13, 2),
(13, 4),
(14, 1),
(14, 2),
(14, 4),
(15, 1),
(15, 2),
(16, 1),
(16, 2),
(16, 3),
(16, 4),
(17, 1),
(17, 3),
(17, 4),
(18, 1),
(18, 2),
(18, 3),
(18, 4),
(19, 1),
(19, 3),
(19, 4),
(20, 1),
(20, 2),
(20, 3),
(20, 4),
(21, 1),
(21, 3),
(21, 4),
(22, 1),
(22, 3),
(22, 4),
(23, 1),
(23, 3),
(23, 4),
(24, 1),
(24, 3),
(24, 4),
(25, 1),
(25, 3),
(25, 4),
(26, 1),
(26, 3),
(26, 4),
(27, 1),
(27, 3),
(27, 4),
(28, 1),
(28, 3),
(28, 4),
(29, 1),
(29, 3),
(29, 4),
(30, 1),
(30, 3),
(30, 4),
(31, 1),
(31, 3),
(31, 4),
(32, 1),
(32, 3),
(32, 4),
(33, 1),
(33, 3),
(33, 4),
(34, 1),
(34, 4),
(35, 1),
(35, 4),
(36, 1),
(36, 3),
(37, 1),
(38, 1),
(39, 1),
(40, 1),
(40, 3),
(41, 1),
(42, 1),
(43, 1),
(44, 1),
(45, 1),
(45, 3),
(46, 1),
(47, 1),
(48, 1),
(49, 1),
(50, 1),
(51, 1),
(51, 3),
(51, 4),
(52, 1),
(52, 3),
(52, 4),
(53, 1),
(53, 3),
(53, 4),
(54, 1),
(54, 3),
(54, 4),
(55, 1),
(56, 1),
(57, 1),
(58, 1),
(59, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `invoice_no` varchar(255) DEFAULT NULL,
  `prescription_id` bigint(20) UNSIGNED DEFAULT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `tax_amount` decimal(10,2) DEFAULT 0.00,
  `cash_tendered` decimal(10,2) NOT NULL DEFAULT 0.00 COMMENT 'Amount paid by customer',
  `change` decimal(10,2) NOT NULL DEFAULT 0.00 COMMENT 'Change returned to customer',
  `discount_type_id` bigint(20) UNSIGNED DEFAULT NULL,
  `discount_percent` decimal(5,2) NOT NULL DEFAULT 0.00,
  `customer_type` varchar(255) NOT NULL DEFAULT 'walk_in' COMMENT 'walk_in, pwd, senior, etc.',
  `customer_type_name` varchar(255) DEFAULT NULL,
  `id_number` varchar(255) DEFAULT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `discount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `user_id`, `invoice_no`, `prescription_id`, `total_amount`, `tax_amount`, `cash_tendered`, `change`, `discount_type_id`, `discount_percent`, `customer_type`, `customer_type_name`, `id_number`, `subtotal`, `discount`, `created_at`, `updated_at`) VALUES
(2, 1, 'INV-20260912-7003', NULL, 107.50, 0.00, 110.00, 2.50, NULL, 0.00, 'regular', NULL, NULL, 107.50, 0.00, '2026-09-12 14:01:19', '2026-09-12 14:01:19');

-- --------------------------------------------------------

--
-- Table structure for table `sale_items`
--

CREATE TABLE `sale_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sale_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `original_price` decimal(10,2) DEFAULT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `discount_percent` decimal(5,2) NOT NULL DEFAULT 0.00,
  `discount_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `sell_type` enum('piece','box') NOT NULL,
  `pieces_per_box` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sale_items`
--

INSERT INTO `sale_items` (`id`, `sale_id`, `product_id`, `quantity`, `unit_price`, `original_price`, `total_price`, `discount_percent`, `discount_amount`, `sell_type`, `pieces_per_box`, `created_at`, `updated_at`) VALUES
(1, 2, 15, 10, 10.75, 10.75, 107.50, 0.00, 0.00, 'piece', 1, '2026-09-12 14:01:19', '2026-09-12 14:01:19');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('5PV68GNErg8UL4IR2MMnkOB8vbXzMtFCNwKHCwtl', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36 Edg/152.0.0.0', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiazhTTVFQWlVOZHVIRDdLamo4NXBKd3N2dnd5RW02bWZYanI1cUJTdiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozMToiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2ludmVudG9yeSI7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjQxOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvZHJ1Zy1jbGFzc2lmaWNhdGlvbiI7czo1OiJyb3V0ZSI7czoyNToiZHJ1Zy1jbGFzc2lmaWNhdGlvbi5pbmRleCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7czoxODoic2hvd193ZWxjb21lX2FsZXJ0IjtiOjA7fQ==', 1789279233);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` text DEFAULT NULL,
  `group` varchar(255) NOT NULL DEFAULT 'general',
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stock_queues`
--

CREATE TABLE `stock_queues` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `barcode` varchar(255) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `brand` varchar(255) DEFAULT NULL,
  `dosage` varchar(255) DEFAULT NULL,
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

INSERT INTO `stock_queues` (`id`, `product_id`, `barcode`, `product_name`, `brand`, `dosage`, `form`, `type`, `category`, `price`, `pieces_per_box`, `expiry_date`, `quantity`, `total_pieces`, `arrival_date`, `status`, `added_by`, `transferred_at`, `transferred_by`, `created_at`, `updated_at`) VALUES
(1, 3, '8901234567891', 'Biogesic', 'Unilab', '500 mg', 'Tablet', 'Branded', 'Analgesic', 9.00, 100, '2027-12-31', 5, 500, '2026-09-12 22:54:11', 'transferred', 1, '2026-09-12 23:56:46', 1, '2026-09-12 14:54:11', '2026-09-12 15:56:46'),
(2, 3, '8901234567891', 'Biogesic', 'Unilab', '500 mg', 'Tablet', 'Branded', 'Analgesic', 9.00, 100, '2027-12-31', 5, 500, '2026-09-12 22:56:39', 'transferred', 1, '2026-09-13 00:23:27', 1, '2026-09-12 14:56:39', '2026-09-12 16:23:27'),
(3, 11, '8901234567891', 'Biogesic', 'Unilab', '500mg', 'Tablet', 'Branded', 'Analgesic', 9.00, 100, '2028-06-30', 8, 800, '2026-09-13 00:29:25', 'transferred', 1, '2026-09-13 00:46:01', 1, '2026-09-12 16:29:25', '2026-09-12 16:46:01'),
(4, 11, '8901234567891', 'Biogesic', 'Unilab', '500mg', 'Tablet', 'Branded', 'Analgesic', 9.00, 100, '2028-09-15', 10, 1000, '2026-09-13 00:29:25', 'transferred', 1, '2026-09-13 00:51:10', 1, '2026-09-12 16:29:25', '2026-09-12 16:51:10'),
(5, 11, '8901234567891', 'Biogesic', 'Unilab', '500mg', 'Tablet', 'Branded', 'Analgesic', 9.00, 100, '2028-12-31', 12, 1200, '2026-09-13 00:29:25', 'pending', 1, NULL, NULL, '2026-09-12 16:29:25', '2026-09-12 16:29:25'),
(6, 11, '8901234567891', 'Biogesic', 'Unilab', '500mg', 'Tablet', 'Branded', 'Analgesic', 9.00, 100, '2029-03-20', 6, 600, '2026-09-13 00:29:25', 'pending', 1, NULL, NULL, '2026-09-12 16:29:25', '2026-09-12 16:29:25'),
(7, 11, '8901234567891', 'Biogesic', 'Unilab', '500mg', 'Tablet', 'Branded', 'Analgesic', 9.00, 100, '2029-06-10', 15, 1500, '2026-09-13 00:29:25', 'pending', 1, NULL, NULL, '2026-09-12 16:29:25', '2026-09-12 16:29:25'),
(8, 3, '8901234567891', 'Biogesic', 'Unilab', '500mg', 'Tablet', 'Branded', 'Analgesic', 9.00, 100, '2028-06-30', 8, 800, '2026-09-13 00:34:07', 'pending', 1, NULL, NULL, '2026-09-12 16:34:07', '2026-09-12 16:34:07'),
(9, 1, '8901234567892', 'Amoxicillin', 'GlaxoSmithKline', '500mg', 'Capsule', 'Generic', 'Antibiotic', 15.00, 100, '2028-08-15', 10, 1000, '2026-09-13 00:34:07', 'pending', 1, NULL, NULL, '2026-09-12 16:34:07', '2026-09-12 16:34:07'),
(10, 2, '8901234567894', 'Bioflu', 'Unilab', '500mg', 'Tablet', 'Branded', 'Cough & Cold', 12.50, 100, '2028-10-31', 12, 1200, '2026-09-13 00:34:07', 'pending', 1, NULL, NULL, '2026-09-12 16:34:07', '2026-09-12 16:34:07'),
(11, 5, '8901234567895', 'Neozep', 'Unilab', '500mg', 'Tablet', 'Branded', 'Cough & Cold', 10.75, 100, '2028-11-30', 15, 1500, '2026-09-13 00:34:07', 'pending', 1, NULL, NULL, '2026-09-12 16:34:07', '2026-09-12 16:34:07'),
(12, 6, '8901234567892', 'Paracetamol', 'RHEA', '500mg', 'Tablet', 'Generic', 'Analgesic', 5.50, 100, '2028-12-31', 8, 800, '2026-09-13 00:34:07', 'pending', 1, NULL, NULL, '2026-09-12 16:34:07', '2026-09-12 16:34:07');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_verified` tinyint(1) NOT NULL DEFAULT 0,
  `otp_expires_at` timestamp NULL DEFAULT NULL,
  `otp_attempts` int(11) NOT NULL DEFAULT 0,
  `otp_last_attempt_at` timestamp NULL DEFAULT NULL,
  `otp_locked_until` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `contact_number` varchar(255) DEFAULT NULL,
  `employee_id` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `resume` varchar(255) DEFAULT NULL,
  `profile_photo` varchar(255) DEFAULT NULL,
  `login_attempts` int(11) NOT NULL DEFAULT 0,
  `locked_until` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `full_name`, `name`, `email`, `email_verified_at`, `password`, `is_active`, `remember_token`, `created_at`, `updated_at`, `is_verified`, `otp_expires_at`, `otp_attempts`, `otp_last_attempt_at`, `otp_locked_until`, `deleted_at`, `contact_number`, `employee_id`, `address`, `resume`, `profile_photo`, `login_attempts`, `locked_until`) VALUES
(1, 'conan', 'Conan', NULL, 'conan.10162004@gmail.com', NULL, '$2y$12$0mx5fidDnlfe6DLprD5ALO2iD9perR46PStIK1JS.pdeocvwiwXta', 1, NULL, '2026-09-12 13:06:10', '2026-09-12 13:06:10', 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_trusted_devices`
--

CREATE TABLE `user_trusted_devices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `device_id` varchar(255) NOT NULL,
  `device_name` varchar(255) DEFAULT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `last_used_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `expires_at` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_trusted_devices`
--

INSERT INTO `user_trusted_devices` (`id`, `user_id`, `device_id`, `device_name`, `ip_address`, `user_agent`, `last_used_at`, `expires_at`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 1, '8047835c95aa1677eef7e1ef7d57309fd554444126c29fa0de0671491ce51be2', 'Edge on Windows 10/11', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36 Edg/152.0.0.0', '2026-09-13 04:50:26', '2026-10-12 13:22:49', 1, '2026-09-12 13:22:49', '2026-09-13 04:50:26');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activity_logs_user_id_index` (`user_id`),
  ADD KEY `activity_logs_action_index` (`action`),
  ADD KEY `activity_logs_module_index` (`module`),
  ADD KEY `activity_logs_created_at_index` (`created_at`);

--
-- Indexes for table `backups`
--
ALTER TABLE `backups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `backups_created_by_foreign` (`created_by`),
  ADD KEY `backups_status_created_at_index` (`status`,`created_at`);

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
  ADD UNIQUE KEY `categories_name_unique` (`name`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`);

--
-- Indexes for table `discount_types`
--
ALTER TABLE `discount_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `discount_types_code_unique` (`code`);

--
-- Indexes for table `dosage_forms`
--
ALTER TABLE `dosage_forms`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `dosage_forms_name_unique` (`name`),
  ADD UNIQUE KEY `dosage_forms_slug_unique` (`slug`);

--
-- Indexes for table `drug_classifications`
--
ALTER TABLE `drug_classifications`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `drug_classifications_name_unique` (`name`),
  ADD UNIQUE KEY `drug_classifications_slug_unique` (`slug`);

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
  ADD KEY `products_last_stock_queue_id_foreign` (`last_stock_queue_id`),
  ADD KEY `products_drug_classification_id_foreign` (`drug_classification_id`);

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
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchases_product_id_foreign` (`product_id`);

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
  ADD UNIQUE KEY `sales_invoice_no_unique` (`invoice_no`),
  ADD KEY `sales_discount_type_id_foreign` (`discount_type_id`),
  ADD KEY `sales_prescription_id_foreign` (`prescription_id`);

--
-- Indexes for table `sale_items`
--
ALTER TABLE `sale_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sale_items_sale_id_foreign` (`sale_id`),
  ADD KEY `sale_items_product_id_foreign` (`product_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

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
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_username_unique` (`username`);

--
-- Indexes for table `user_trusted_devices`
--
ALTER TABLE `user_trusted_devices`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_trusted_devices_device_id_unique` (`device_id`),
  ADD KEY `user_trusted_devices_user_id_index` (`user_id`),
  ADD KEY `user_trusted_devices_user_id_device_id_index` (`user_id`,`device_id`),
  ADD KEY `user_trusted_devices_user_id_is_active_index` (`user_id`,`is_active`),
  ADD KEY `user_trusted_devices_expires_at_index` (`expires_at`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `backups`
--
ALTER TABLE `backups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `discount_types`
--
ALTER TABLE `discount_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dosage_forms`
--
ALTER TABLE `dosage_forms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `drug_classifications`
--
ALTER TABLE `drug_classifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `otps`
--
ALTER TABLE `otps`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `prescriptions`
--
ALTER TABLE `prescriptions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prescription_items`
--
ALTER TABLE `prescription_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `product_batches`
--
ALTER TABLE `product_batches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `promos`
--
ALTER TABLE `promos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sale_items`
--
ALTER TABLE `sale_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stock_queues`
--
ALTER TABLE `stock_queues`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user_trusted_devices`
--
ALTER TABLE `user_trusted_devices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `backups`
--
ALTER TABLE `backups`
  ADD CONSTRAINT `backups_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

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
  ADD CONSTRAINT `products_drug_classification_id_foreign` FOREIGN KEY (`drug_classification_id`) REFERENCES `drug_classifications` (`id`) ON DELETE SET NULL,
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
-- Constraints for table `purchases`
--
ALTER TABLE `purchases`
  ADD CONSTRAINT `purchases_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

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
  ADD CONSTRAINT `sale_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sale_items_sale_id_foreign` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

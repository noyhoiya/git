-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 19, 2025 at 05:34 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cash_center`
--

-- --------------------------------------------------------

--
-- Table structure for table `cash_requests`
--

CREATE TABLE `cash_requests` (
  `request_id` bigint(20) NOT NULL,
  `requester_vault_id` int(11) NOT NULL,
  `requester_user_id` int(11) NOT NULL,
  `amount_cents` bigint(20) NOT NULL CHECK (`amount_cents` > 0),
  `amount_in_words` varchar(255) NOT NULL,
  `purpose_code` varchar(32) DEFAULT NULL,
  `purpose_text` varchar(255) DEFAULT NULL,
  `status` enum('PENDING','APPROVED','REJECTED','CANCELLED') NOT NULL DEFAULT 'PENDING',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `approved_at` datetime DEFAULT NULL,
  `approver_user_id` int(11) DEFAULT NULL,
  `notes` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cash_requests`
--

INSERT INTO `cash_requests` (`request_id`, `requester_vault_id`, `requester_user_id`, `amount_cents`, `amount_in_words`, `purpose_code`, `purpose_text`, `status`, `created_at`, `approved_at`, `approver_user_id`, `notes`) VALUES
(31, 1, 4, 10000000, 'ໜຶ່ງແສນກີບ', 'ADMIN_DAILY', NULL, 'REJECTED', '2025-09-16 10:11:13', '2025-09-16 03:20:15', 4, NULL),
(32, 1, 4, 10000000, 'ໜຶ່ງແສນກີບ', 'ADMIN_DAILY', NULL, 'REJECTED', '2025-09-17 10:26:39', '2025-09-17 03:28:19', 4, NULL),
(33, 1, 4, 10000000, 'ໜຶ່ງແສນກີບ', 'ADMIN_DAILY', NULL, 'REJECTED', '2025-09-17 10:27:15', '2025-09-17 03:28:22', 4, NULL),
(34, 1, 4, 10000000, 'ໜຶ່ງແສນກີບ', 'ADMIN_DAILY', NULL, 'REJECTED', '2025-09-17 10:27:52', '2025-09-17 03:28:25', 4, NULL),
(35, 1, 4, 10000000, 'ໜຶ່ງແສນກີບ', 'ADMIN_DAILY', NULL, 'REJECTED', '2025-09-17 10:30:47', '2025-09-17 03:33:40', 4, NULL),
(36, 1, 4, 10000000, 'ໜຶ່ງແສນກີບ', 'ADMIN_DAILY', NULL, 'REJECTED', '2025-09-17 10:31:12', '2025-09-17 03:40:47', 4, NULL),
(37, 1, 4, 10000000, 'ໜຶ່ງແສນກີບ', 'ADMIN_DAILY', NULL, 'REJECTED', '2025-09-17 10:44:50', '2025-09-17 03:48:18', 4, NULL),
(38, 1, 4, 10000000, 'ໜຶ່ງແສນກີບ', 'ADMIN_DAILY', NULL, 'REJECTED', '2025-09-17 10:48:32', '2025-09-17 03:52:14', 4, NULL),
(39, 1, 4, 10000000, 'ໜຶ່ງແສນກີບ', 'ADMIN_DAILY', NULL, 'REJECTED', '2025-09-17 10:52:23', '2025-09-17 03:56:33', 4, NULL),
(40, 1, 4, 10000000, 'ໜຶ່ງແສນກີບ', 'ADMIN_DAILY', NULL, 'APPROVED', '2025-09-17 10:56:45', '2025-09-17 04:25:45', 4, NULL),
(41, 1, 4, 10000000, 'ໜຶ່ງແສນກີບ', 'ADMIN_DAILY', NULL, 'APPROVED', '2025-09-17 11:05:22', '2025-09-17 04:25:44', 4, NULL),
(42, 1, 4, 10000000, 'ໜຶ່ງແສນກີບ', 'ADMIN_DAILY', NULL, 'APPROVED', '2025-09-17 11:13:21', '2025-09-17 04:25:42', 4, NULL),
(43, 1, 4, 10000000, 'ໜຶ່ງແສນກີບ', 'ADMIN_DAILY', NULL, 'APPROVED', '2025-09-17 11:21:23', '2025-09-17 04:25:40', 4, NULL),
(44, 2, 4, 10000000, 'ໜຶ່ງແສນກີບ', 'ADMIN_DAILY', NULL, 'REJECTED', '2025-09-17 11:39:22', '2025-09-17 04:42:27', 4, NULL),
(45, 1, 4, 10000000, 'ໜຶ່ງແສນກີບ', 'ADMIN_DAILY', NULL, 'REJECTED', '2025-09-17 11:42:41', '2025-09-17 05:00:49', 4, NULL),
(46, 1, 4, 10000000, 'ໜຶ່ງແສນກີບ', 'ADMIN_DAILY', NULL, 'REJECTED', '2025-09-17 13:27:50', '2025-09-17 06:37:37', 4, NULL),
(47, 1, 4, 10000000, 'ໜຶ່ງແສນກີບ', 'ADMIN_DAILY', NULL, 'REJECTED', '2025-09-17 13:31:50', '2025-09-17 06:37:35', 4, NULL),
(48, 1, 4, 10000000, 'ໜຶ່ງແສນກີບ', 'ADMIN_DAILY', NULL, 'REJECTED', '2025-09-17 13:37:56', '2025-09-17 06:38:30', 4, NULL),
(49, 1, 4, 10000000, 'ໜຶ່ງແສນກີບ', 'ADMIN_DAILY', NULL, 'REJECTED', '2025-09-17 13:38:18', '2025-09-17 06:38:32', 4, NULL),
(50, 1, 4, 10000000, 'ໜຶ່ງແສນກີບ', 'ADMIN_DAILY', NULL, 'REJECTED', '2025-09-17 13:40:05', '2025-09-17 06:43:06', 4, NULL),
(51, 1, 4, 10000000, 'ໜຶ່ງແສນກີບ', 'ADMIN_DAILY', NULL, 'REJECTED', '2025-09-17 13:43:26', '2025-09-17 06:49:04', 4, NULL),
(52, 1, 4, 100000000, 'ໜຶ່ງລ້ານກີບ', 'ADMIN_DAILY', NULL, 'REJECTED', '2025-09-17 13:44:01', '2025-09-17 06:49:03', 4, NULL),
(53, 1, 4, 10000000, 'ໜຶ່ງແສນກີບ', 'ADMIN_DAILY', NULL, 'REJECTED', '2025-09-17 13:49:21', '2025-09-17 07:04:15', 4, NULL),
(54, 2, 4, 100000000, 'ໜຶ່ງລ້ານກີບ', 'ADMIN_DAILY', NULL, 'REJECTED', '2025-09-17 13:50:01', '2025-09-17 07:04:13', 4, NULL),
(55, 1, 4, 100000000, 'ໜຶ່ງລ້ານກີບ', 'ADMIN_DAILY', NULL, 'REJECTED', '2025-09-17 14:04:28', '2025-09-17 07:17:26', 4, NULL),
(56, 1, 4, 100000000, 'ໜຶ່ງລ້ານກີບ', 'ADMIN_DAILY', NULL, 'REJECTED', '2025-09-17 14:04:42', '2025-09-17 07:17:25', 4, NULL),
(57, 1, 4, 100000000, 'ໜຶ່ງລ້ານກີບ', 'ADMIN_DAILY', NULL, 'REJECTED', '2025-09-17 14:14:20', '2025-09-17 07:17:23', 4, NULL),
(58, 1, 4, 100000000, 'ໜຶ່ງລ້ານກີບ', 'ADMIN_DAILY', NULL, 'REJECTED', '2025-09-17 14:17:52', '2025-09-17 08:24:07', 4, NULL),
(59, 2, 4, 100000000, 'ໜຶ່ງລ້ານກີບ', 'BANK_WITHDRAW', NULL, 'REJECTED', '2025-09-17 15:16:59', '2025-09-17 08:24:09', 4, NULL),
(60, 1, 4, 100000000, 'ໜຶ່ງລ້ານກີບ', 'ADMIN_DAILY', NULL, 'REJECTED', '2025-09-17 15:26:59', '2025-09-18 01:23:12', 4, NULL),
(61, 1, 4, 10000000, 'ໜຶ່ງແສນກີບ', 'ADMIN_DAILY', NULL, 'REJECTED', '2025-09-17 15:38:31', '2025-09-18 01:23:08', 4, NULL),
(62, 1, 4, 10000000, 'ໜຶ່ງແສນກີບ', 'ADMIN_DAILY', NULL, 'REJECTED', '2025-09-18 08:30:47', '2025-09-18 08:26:06', 4, NULL),
(63, 1, 4, 10000000, 'ໜຶ່ງແສນກີບ', 'ADMIN_DAILY', NULL, 'REJECTED', '2025-09-18 11:50:46', '2025-09-18 08:26:04', 4, NULL),
(64, 1, 2, 10000000, 'ໜຶ່ງແສນກີບ', 'TELLER_SERVICE', NULL, 'REJECTED', '2025-09-18 15:27:39', '2025-09-18 08:29:03', 4, NULL),
(65, 1, 4, 10000000, 'ໜຶ່ງແສນກີບ', 'ADMIN_DAILY', NULL, 'APPROVED', '2025-09-19 09:15:32', '2025-09-19 02:15:36', 4, NULL),
(66, 1, 4, 10000000, 'ໜຶ່ງແສນກີບ', 'ADMIN_DAILY', NULL, 'APPROVED', '2025-09-19 09:18:49', '2025-09-19 02:18:59', 4, NULL),
(67, 1, 4, 10000000, 'ໜຶ່ງແສນກີບ', 'ADMIN_DAILY', NULL, 'APPROVED', '2025-09-19 09:25:44', '2025-09-19 02:25:53', 4, NULL),
(68, 1, 4, 10000000, 'ໜຶ່ງແສນກີບ', 'ADMIN_DAILY', NULL, 'APPROVED', '2025-09-19 10:13:11', '2025-09-19 03:13:46', 4, NULL),
(69, 1, 4, 10000000, 'ໜຶ່ງແສນກີບ', 'ADMIN_DAILY', NULL, 'APPROVED', '2025-09-19 13:48:01', '2025-09-19 06:53:53', 4, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cash_request_denoms`
--

CREATE TABLE `cash_request_denoms` (
  `id` bigint(20) NOT NULL,
  `request_id` bigint(20) NOT NULL,
  `denomination` int(11) NOT NULL,
  `quantity` int(11) NOT NULL CHECK (`quantity` >= 0)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cash_request_denoms`
--

INSERT INTO `cash_request_denoms` (`id`, `request_id`, `denomination`, `quantity`) VALUES
(14, 32, 50000, 2),
(15, 33, 50000, 2),
(16, 34, 50000, 2),
(17, 35, 50000, 2),
(18, 36, 50000, 2),
(19, 37, 50000, 2),
(20, 38, 50000, 2),
(21, 39, 50000, 2),
(22, 40, 50000, 2),
(23, 41, 50000, 2),
(24, 42, 50000, 2),
(25, 43, 50000, 2),
(26, 44, 50000, 2),
(27, 45, 50000, 2),
(28, 46, 50000, 2),
(29, 47, 50000, 2),
(30, 48, 50000, 2),
(31, 49, 50000, 2),
(32, 50, 50000, 2),
(33, 51, 50000, 2),
(34, 52, 50000, 2),
(35, 53, 50000, 2),
(36, 54, 50000, 2),
(37, 55, 50000, 2),
(38, 56, 50000, 2),
(39, 57, 50000, 2),
(40, 58, 50000, 2),
(41, 59, 100000, 1),
(42, 60, 1000, 1),
(43, 61, 50000, 2),
(44, 62, 50000, 2),
(45, 63, 50000, 2),
(46, 64, 50000, 2),
(47, 65, 50000, 2),
(48, 66, 50000, 2),
(49, 67, 50000, 2),
(50, 68, 50000, 2),
(51, 69, 50000, 2);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purposes`
--

CREATE TABLE `purposes` (
  `purpose_code` varchar(32) NOT NULL,
  `purpose_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purposes`
--

INSERT INTO `purposes` (`purpose_code`, `purpose_name`) VALUES
('ADMIN_DAILY', 'ເພື່ອສຳຮອງເປັນຄ່າໃຊ້ຈ່່າຍປະຈຳວັນ'),
('BANK_WITHDRAW', 'ເພື່ອສົ່ງມອບເງິນສົດທີ່ຖອນຈາກທະນາຄານ'),
('EOD_SURPLUS', 'ເພື່ອສົ່ງມອບຍອດເຫຼືອເງິນສົດ ຂອງບໍລິການທ້າຍມື້'),
('OFFICE_SUPPLIES', 'ເພື່ອເປັນຄ່າຊື້ອຸປະກອນເຄື່ອງໃຊ້ຫ້ອງການ'),
('OTHER', 'ອື່ນໆ'),
('REPAIR', 'ເພື່ອເປັນຄ່າສ້ອມແປງເຄື່ອງໃຊ້ຫ້ອງການ'),
('TELLER_SERVICE', 'ເພື່ອບໍລິການຝາກ-ຖອນເງິນ ໃຫ້ລູກຄ້າ'),
('UTILITIES', 'ເພື່ອຈ່າຍຄ່ານ້ຳປະປາ,');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_id`, `role_name`) VALUES
(5, 'ADMIN'),
(3, 'ADMIN_VAULT'),
(4, 'AUDITOR'),
(1, 'MAIN_VAULT'),
(2, 'TELLER');

-- --------------------------------------------------------

--
-- Table structure for table `transaction_debug_logs`
--

CREATE TABLE `transaction_debug_logs` (
  `id` int(11) NOT NULL,
  `from_vault_id` int(11) NOT NULL,
  `to_vault_id` int(11) NOT NULL,
  `amount` bigint(20) NOT NULL,
  `balance_from_before` bigint(20) DEFAULT NULL,
  `balance_from_after` bigint(20) DEFAULT NULL,
  `balance_to_before` bigint(20) DEFAULT NULL,
  `balance_to_after` bigint(20) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `is_duplicate` tinyint(1) DEFAULT 0,
  `is_negative` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `operation_from` varchar(10) NOT NULL,
  `operation_to` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transaction_debug_logs`
--

INSERT INTO `transaction_debug_logs` (`id`, `from_vault_id`, `to_vault_id`, `amount`, `balance_from_before`, `balance_from_after`, `balance_to_before`, `balance_to_after`, `user_id`, `is_duplicate`, `is_negative`, `created_at`, `operation_from`, `operation_to`) VALUES
(29, 1, 2, 100000, 100000000, 100000000, 0, 0, 4, 0, 0, '2025-09-15 19:43:13', 'subtract', 'add'),
(30, 1, 2, 100000, 99900000, 99900000, 100000, 100000, 4, 0, 0, '2025-09-15 21:47:44', 'subtract', 'add'),
(31, 1, 2, 100000, 99800000, 99800000, 200000, 200000, 4, 0, 0, '2025-09-15 21:49:40', 'subtract', 'add'),
(32, 1, 2, 100000, 99700000, 99700000, 300000, 300000, 4, 0, 0, '2025-09-15 21:52:33', 'subtract', 'add'),
(33, 1, 2, 100000, 99600000, 99600000, 400000, 400000, 4, 0, 0, '2025-09-15 21:54:45', 'subtract', 'add'),
(34, 1, 2, 100000, 99500000, 99500000, 500000, 500000, 4, 0, 0, '2025-09-16 00:29:50', 'subtract', 'add'),
(35, 1, 2, 100000, 99400000, 99400000, 600000, 600000, 4, 0, 0, '2025-09-16 00:31:40', 'subtract', 'add'),
(36, 1, 2, 100000, 99300000, 99300000, 700000, 700000, 4, 0, 0, '2025-09-16 00:47:04', 'subtract', 'add'),
(37, 1, 2, 100000, 99200000, 99200000, 800000, 800000, 4, 0, 0, '2025-09-16 00:47:57', 'subtract', 'add'),
(38, 1, 2, 100000, 99100000, 99100000, 900000, 900000, 4, 0, 0, '2025-09-16 01:02:49', 'subtract', 'add'),
(39, 1, 2, 100000, 99000000, 99000000, 1000000, 1000000, 4, 0, 0, '2025-09-16 01:15:06', 'subtract', 'add'),
(40, 1, 1, 10000000, 100000000, 100000000, 100000000, 100000000, 4, 0, 0, '2025-09-18 19:14:39', 'subtract', 'add'),
(41, 1, 1, 10000000, 100000000, 100000000, 100000000, 100000000, 4, 0, 0, '2025-09-18 19:15:53', 'subtract', 'add'),
(42, 1, 2, 100000, 100000000, 100000000, 0, 0, 4, 0, 0, '2025-09-18 19:19:31', 'subtract', 'add');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `full_name` varchar(120) NOT NULL,
  `username` varchar(60) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role_id` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `full_name`, `username`, `password_hash`, `role_id`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'ຜູ້ໃຊ້', 'user', 'User@123', 3, 1, '2025-08-27 10:26:17', '2025-09-11 07:38:57'),
(2, 'ເຄນວັນ', 'khenvanh', 'Passwword@01', 2, 1, '2025-09-02 09:02:20', '2025-09-10 16:25:06'),
(3, 'Admin', 'Admin', 'Admin@123', 5, 1, '2025-09-02 09:05:05', '2025-09-11 07:38:04'),
(4, 'ເພັງໄຊ ລໍວັນທອງ', 'main', 'main@123', 1, 1, '2025-09-02 09:06:13', '2025-09-11 07:38:25'),
(7, 'Sengphet.S', 'Sengphet.S', '$2y$12$QvpWT39Hrd6xZz9UBHIJM..vIEKIGAySqypSFcA3naOfN6DYe5fau', 2, 1, '2025-09-18 01:58:04', '2025-09-18 01:58:04'),
(8, 'Kindavanh', 'Kindavanh.S', '$2y$12$fJZ0jQRwpaYvstUCw/b97u92WBnVK2a83J.kkSVZjfQVS/qZbUSVK', 3, 1, '2025-09-18 01:59:28', '2025-09-18 01:59:28');

-- --------------------------------------------------------

--
-- Table structure for table `vaults`
--

CREATE TABLE `vaults` (
  `vault_id` int(11) NOT NULL,
  `vault_name` varchar(80) NOT NULL,
  `vault_type` enum('MAIN','SUB','BANK') NOT NULL,
  `current_balance_cents` decimal(50,2) NOT NULL DEFAULT 0.00,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vaults`
--

INSERT INTO `vaults` (`vault_id`, `vault_name`, `vault_type`, `current_balance_cents`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'ຄັງໃຫ່ຍ', 'MAIN', 99900000.00, 1, '2025-08-21 10:12:33', '2025-09-15 08:06:36'),
(2, 'TELLER(ຄັງຍ່ອຍ)', 'SUB', 100000.00, 1, '2025-08-21 10:12:33', '2025-09-15 08:06:36'),
(3, 'ຄັງບໍລິຫານ(ຄັງຍ່ອຍ)', 'SUB', 0.00, 1, '2025-08-21 10:12:33', '2025-09-04 16:14:48'),
(4, 'ສິນເຊື່ອ(ຄັງຍ່ອຍ)', 'SUB', 0.00, 1, '2025-09-02 09:28:05', '2025-09-04 16:14:48'),
(5, 'ທະນາຄານ', 'BANK', 0.00, 1, '2025-09-11 03:36:20', '2025-09-15 01:53:32');

-- --------------------------------------------------------

--
-- Table structure for table `vault_movements`
--

CREATE TABLE `vault_movements` (
  `movement_id` bigint(20) NOT NULL,
  `type` enum('WITHDRAWAL','HANDOVER') NOT NULL,
  `from_vault_id` int(11) NOT NULL,
  `to_vault_id` int(11) NOT NULL,
  `request_id` bigint(20) DEFAULT NULL,
  `amount_cents` decimal(20,2) NOT NULL,
  `amount_in_words` varchar(255) NOT NULL,
  `purpose_code` varchar(32) DEFAULT NULL,
  `purpose_text` varchar(255) DEFAULT NULL,
  `status` enum('DRAFT','POSTED','VOID') NOT NULL DEFAULT 'DRAFT',
  `created_by_user_id` int(11) NOT NULL,
  `released_by_user_id` int(11) DEFAULT NULL,
  `received_by_user_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `posted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vault_movements`
--

INSERT INTO `vault_movements` (`movement_id`, `type`, `from_vault_id`, `to_vault_id`, `request_id`, `amount_cents`, `amount_in_words`, `purpose_code`, `purpose_text`, `status`, `created_by_user_id`, `released_by_user_id`, `received_by_user_id`, `created_at`, `posted_at`) VALUES
(106, 'WITHDRAWAL', 1, 2, NULL, 100000.00, 'ໜຶ່ງແສນກີບ', 'ADMIN_DAILY', NULL, 'POSTED', 4, 4, NULL, '2025-09-19 09:19:22', '2025-09-19 02:19:31'),
(107, 'WITHDRAWAL', 1, 1, 68, 10000000.00, 'ໜຶ່ງແສນກີບ', 'ADMIN_DAILY', NULL, 'DRAFT', 4, NULL, NULL, '2025-09-19 10:13:46', NULL),
(108, 'WITHDRAWAL', 1, 1, 69, 10000000.00, 'ໜຶ່ງແສນກີບ', 'ADMIN_DAILY', NULL, 'DRAFT', 4, NULL, NULL, '2025-09-19 13:53:53', NULL);

--
-- Triggers `vault_movements`
--
DELIMITER $$
CREATE TRIGGER `trg_vault_movements_after_insert` AFTER INSERT ON `vault_movements` FOR EACH ROW BEGIN
  IF NEW.status = 'POSTED' THEN
    -- Subtract from from_vault; add to to_vault
    UPDATE vaults SET current_balance_cents = current_balance_cents - NEW.amount_cents
    WHERE vault_id = NEW.from_vault_id;

    UPDATE vaults SET current_balance_cents = current_balance_cents + NEW.amount_cents
    WHERE vault_id = NEW.to_vault_id;
  END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_vault_movements_after_update` AFTER UPDATE ON `vault_movements` FOR EACH ROW BEGIN
  -- Handle transition to POSTED
  IF (OLD.status <> 'POSTED') AND (NEW.status = 'POSTED') THEN
    UPDATE vaults SET current_balance_cents = current_balance_cents - NEW.amount_cents
    WHERE vault_id = NEW.from_vault_id;

    UPDATE vaults SET current_balance_cents = current_balance_cents + NEW.amount_cents
    WHERE vault_id = NEW.to_vault_id;

  -- Handle voiding a previously posted movement (reverse it)
  ELSEIF (OLD.status = 'POSTED') AND (NEW.status = 'VOID') THEN
    UPDATE vaults SET current_balance_cents = current_balance_cents + OLD.amount_cents
    WHERE vault_id = OLD.from_vault_id;

    UPDATE vaults SET current_balance_cents = current_balance_cents - OLD.amount_cents
    WHERE vault_id = OLD.to_vault_id;
  END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `vault_movement_denoms`
--

CREATE TABLE `vault_movement_denoms` (
  `id` bigint(20) NOT NULL,
  `movement_id` bigint(20) NOT NULL,
  `denomination` int(11) NOT NULL,
  `quantity` int(11) NOT NULL CHECK (`quantity` >= 0)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cash_requests`
--
ALTER TABLE `cash_requests`
  ADD PRIMARY KEY (`request_id`),
  ADD KEY `requester_vault_id` (`requester_vault_id`),
  ADD KEY `requester_user_id` (`requester_user_id`),
  ADD KEY `approver_user_id` (`approver_user_id`),
  ADD KEY `purpose_code` (`purpose_code`),
  ADD KEY `ix_requests_status` (`status`,`requester_vault_id`,`created_at`);

--
-- Indexes for table `cash_request_denoms`
--
ALTER TABLE `cash_request_denoms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `request_id` (`request_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purposes`
--
ALTER TABLE `purposes`
  ADD PRIMARY KEY (`purpose_code`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`),
  ADD UNIQUE KEY `role_name` (`role_name`);

--
-- Indexes for table `transaction_debug_logs`
--
ALTER TABLE `transaction_debug_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `vaults`
--
ALTER TABLE `vaults`
  ADD PRIMARY KEY (`vault_id`),
  ADD UNIQUE KEY `vault_name` (`vault_name`);

--
-- Indexes for table `vault_movements`
--
ALTER TABLE `vault_movements`
  ADD PRIMARY KEY (`movement_id`),
  ADD KEY `from_vault_id` (`from_vault_id`),
  ADD KEY `to_vault_id` (`to_vault_id`),
  ADD KEY `request_id` (`request_id`),
  ADD KEY `purpose_code` (`purpose_code`),
  ADD KEY `created_by_user_id` (`created_by_user_id`),
  ADD KEY `released_by_user_id` (`released_by_user_id`),
  ADD KEY `received_by_user_id` (`received_by_user_id`),
  ADD KEY `ix_movements_status` (`status`,`type`,`created_at`);

--
-- Indexes for table `vault_movement_denoms`
--
ALTER TABLE `vault_movement_denoms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `movement_id` (`movement_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cash_requests`
--
ALTER TABLE `cash_requests`
  MODIFY `request_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `cash_request_denoms`
--
ALTER TABLE `cash_request_denoms`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `transaction_debug_logs`
--
ALTER TABLE `transaction_debug_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `vaults`
--
ALTER TABLE `vaults`
  MODIFY `vault_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `vault_movements`
--
ALTER TABLE `vault_movements`
  MODIFY `movement_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT for table `vault_movement_denoms`
--
ALTER TABLE `vault_movement_denoms`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cash_requests`
--
ALTER TABLE `cash_requests`
  ADD CONSTRAINT `cash_requests_ibfk_1` FOREIGN KEY (`requester_vault_id`) REFERENCES `vaults` (`vault_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `cash_requests_ibfk_2` FOREIGN KEY (`requester_user_id`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `cash_requests_ibfk_3` FOREIGN KEY (`approver_user_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `cash_requests_ibfk_4` FOREIGN KEY (`purpose_code`) REFERENCES `purposes` (`purpose_code`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `cash_request_denoms`
--
ALTER TABLE `cash_request_denoms`
  ADD CONSTRAINT `cash_request_denoms_ibfk_1` FOREIGN KEY (`request_id`) REFERENCES `cash_requests` (`request_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`) ON UPDATE CASCADE;

--
-- Constraints for table `vault_movements`
--
ALTER TABLE `vault_movements`
  ADD CONSTRAINT `vault_movements_ibfk_1` FOREIGN KEY (`from_vault_id`) REFERENCES `vaults` (`vault_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `vault_movements_ibfk_2` FOREIGN KEY (`to_vault_id`) REFERENCES `vaults` (`vault_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `vault_movements_ibfk_3` FOREIGN KEY (`request_id`) REFERENCES `cash_requests` (`request_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `vault_movements_ibfk_4` FOREIGN KEY (`purpose_code`) REFERENCES `purposes` (`purpose_code`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `vault_movements_ibfk_5` FOREIGN KEY (`created_by_user_id`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `vault_movements_ibfk_6` FOREIGN KEY (`released_by_user_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `vault_movements_ibfk_7` FOREIGN KEY (`received_by_user_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `vault_movement_denoms`
--
ALTER TABLE `vault_movement_denoms`
  ADD CONSTRAINT `vault_movement_denoms_ibfk_1` FOREIGN KEY (`movement_id`) REFERENCES `vault_movements` (`movement_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

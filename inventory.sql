-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 30, 2019 at 08:08 AM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventory`
--

-- --------------------------------------------------------

--
-- Table structure for table `areas`
--

CREATE TABLE `areas` (
  `id` int(10) UNSIGNED NOT NULL,
  `area_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `area_details` text COLLATE utf8mb4_unicode_ci,
  `added_by` int(11) DEFAULT NULL,
  `edited_by` int(11) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `areas`
--

INSERT INTO `areas` (`id`, `area_name`, `area_details`, `added_by`, `edited_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Uttara', NULL, 1, NULL, NULL, '2019-08-29 14:08:53', '2019-08-29 14:08:53'),
(2, 'Gulshan', NULL, 1, NULL, NULL, '2019-08-29 14:09:04', '2019-08-29 14:09:04');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `category_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_details` text COLLATE utf8mb4_unicode_ci,
  `added_by` int(11) DEFAULT NULL,
  `edited_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category_name`, `category_details`, `added_by`, `edited_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Electric and Electronics', 'Remarks', 1, NULL, '2019-08-29 13:55:29', '2019-08-29 13:55:29', NULL),
(2, 'Health & Beauty', 'Remarks', 1, NULL, '2019-08-29 13:56:31', '2019-08-29 13:56:31', NULL),
(3, 'Man\'s Fashion', 'R', 1, NULL, '2019-08-29 13:56:50', '2019-08-29 13:56:50', NULL),
(4, 'Woman\'s Fashion', 'R', 1, NULL, '2019-08-29 13:57:02', '2019-08-29 13:57:02', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(10) UNSIGNED NOT NULL,
  `customer_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_mobile` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_email` text COLLATE utf8mb4_unicode_ci,
  `area_id` int(11) DEFAULT NULL,
  `trade_price` double(8,2) NOT NULL DEFAULT '0.00',
  `customer_address` text COLLATE utf8mb4_unicode_ci,
  `added_by` int(11) DEFAULT NULL,
  `edited_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `customer_name`, `customer_mobile`, `customer_email`, `area_id`, `trade_price`, `customer_address`, `added_by`, `edited_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Rashed Mia', '01398752420984', 'demo@gmail.com', 1, 2.00, '14/3 Khilkhet,Dhaka', 1, NULL, '2019-08-29 14:10:24', '2019-08-29 14:10:24', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `damaged_products`
--

CREATE TABLE `damaged_products` (
  `id` int(10) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` double NOT NULL,
  `damage_type` int(11) NOT NULL,
  `details` text COLLATE utf8mb4_unicode_ci,
  `added_by` int(11) DEFAULT NULL,
  `edited_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` int(10) UNSIGNED NOT NULL,
  `expense_date` date NOT NULL,
  `amount` double(8,2) NOT NULL DEFAULT '0.00',
  `expense_item_id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` text COLLATE utf8mb4_unicode_ci,
  `quantity` text COLLATE utf8mb4_unicode_ci,
  `details` text COLLATE utf8mb4_unicode_ci,
  `added_by` int(11) DEFAULT NULL,
  `edited_by` int(11) DEFAULT NULL,
  `superAdmin_approval` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `expense_items`
--

CREATE TABLE `expense_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `details` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `added_by` int(11) DEFAULT NULL,
  `edited_by` int(11) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `expense_items`
--

INSERT INTO `expense_items` (`id`, `name`, `details`, `added_by`, `edited_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Customer Felicitation', 'Expense for Customer Felicitation', 1, NULL, NULL, '2019-08-27 11:23:22', '2019-08-27 11:23:22'),
(2, 'Product Sample', 'Expense for Giving Product Sample to the Customer', 1, NULL, NULL, '2019-08-27 11:23:22', '2019-08-27 11:23:22'),
(3, 'Travelling Allowance', 'Expense for Travelling Allowance', 1, NULL, NULL, '2019-08-27 11:23:22', '2019-08-27 11:23:22'),
(4, 'Salary', 'Expense for Employees Salary', 1, NULL, NULL, '2019-08-27 11:23:22', '2019-08-27 11:23:22');

-- --------------------------------------------------------

--
-- Table structure for table `incomes`
--

CREATE TABLE `incomes` (
  `id` int(10) UNSIGNED NOT NULL,
  `customer_id` int(11) NOT NULL,
  `income_date` date NOT NULL,
  `amount` double(8,2) NOT NULL DEFAULT '0.00',
  `purpose` text COLLATE utf8mb4_unicode_ci,
  `details` text COLLATE utf8mb4_unicode_ci,
  `payment_type` int(11) DEFAULT NULL,
  `cheque_number` text COLLATE utf8mb4_unicode_ci,
  `added_by` int(11) DEFAULT NULL,
  `edited_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `loanreturns`
--

CREATE TABLE `loanreturns` (
  `id` int(10) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `amount` double(8,2) NOT NULL DEFAULT '0.00',
  `loan_id` int(11) NOT NULL,
  `details` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `loans`
--

CREATE TABLE `loans` (
  `id` int(10) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `amount` double(8,2) NOT NULL DEFAULT '0.00',
  `remaining_amount` double(8,2) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `details` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2018_03_18_065341_create_products_table', 1),
(4, '2018_03_18_070646_create_categories_table', 1),
(5, '2018_03_18_072408_create_sub_categories_table', 1),
(6, '2018_03_18_080749_create_purchases_table', 1),
(7, '2018_03_18_081906_create_sales_table', 1),
(8, '2018_03_18_082519_create_incomes_table', 1),
(9, '2018_03_18_082918_create_expenses_table', 1),
(10, '2018_03_18_084652_create_customers_table', 1),
(11, '2018_03_18_090520_create_orders_table', 1),
(12, '2018_03_18_094012_entrust_setup_tables', 1),
(13, '2018_03_19_091556_create_areas_table', 1),
(14, '2018_03_25_065104_create_expense_items_table', 1),
(15, '2018_04_01_081254_create_stores_table', 1),
(16, '2018_04_10_101734_create_sub_areas_table', 1),
(17, '2018_04_10_104831_create_damaged_products_table', 1),
(18, '2018_04_10_114747_create_returned_products_table', 1),
(19, '2018_04_10_115019_create_loans_table', 1),
(20, '2018_04_16_051447_loanreturn', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(10) UNSIGNED NOT NULL,
  `order_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_date` date NOT NULL,
  `customer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_id`, `order_date`, `customer_id`, `product_id`, `seller_id`, `quantity`, `status`, `created_at`, `updated_at`) VALUES
(1, '11567109520', '2019-08-31', 1, 1, 1, 1, 1, '2019-08-29 14:12:00', '2019-08-29 14:12:00');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permission_role`
--

CREATE TABLE `permission_role` (
  `permission_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(10) UNSIGNED NOT NULL,
  `category_id` int(11) NOT NULL,
  `subCategory_id` int(11) NOT NULL,
  `product_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mrp` double(8,2) NOT NULL DEFAULT '0.00',
  `product_stock` bigint(20) NOT NULL DEFAULT '0',
  `product_details` text COLLATE utf8mb4_unicode_ci,
  `product_image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `added_by` int(11) DEFAULT NULL,
  `edited_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `subCategory_id`, `product_name`, `product_code`, `mrp`, `product_stock`, `product_details`, `product_image`, `added_by`, `edited_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, 'XIaomi Mobile', 'MBL-01', 140000.00, 19, NULL, NULL, 1, NULL, '2019-08-29 14:01:11', '2019-08-29 14:13:53', NULL),
(2, 3, 5, 'T-shirt Top Blouse Tee', 'TS-01', 350.00, 400, NULL, NULL, 1, NULL, '2019-08-29 14:03:18', '2019-08-29 14:04:38', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` int(11) NOT NULL,
  `purchase_date` date NOT NULL,
  `purchase_price` double(8,2) DEFAULT NULL,
  `invoice_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT '0',
  `added_by` int(11) DEFAULT NULL,
  `edited_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchases`
--

INSERT INTO `purchases` (`id`, `product_id`, `purchase_date`, `purchase_price`, `invoice_no`, `quantity`, `added_by`, `edited_by`, `created_at`, `updated_at`) VALUES
(1, 1, '2019-08-30', NULL, '5077', 20, NULL, NULL, '2019-08-29 14:04:16', '2019-08-29 14:04:16'),
(2, 2, '2019-08-21', NULL, '564', 400, NULL, NULL, '2019-08-29 14:04:38', '2019-08-29 14:04:38');

-- --------------------------------------------------------

--
-- Table structure for table `returned_products`
--

CREATE TABLE `returned_products` (
  `id` int(10) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `product_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `quantity` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `details` text COLLATE utf8mb4_unicode_ci,
  `added_by` int(11) DEFAULT NULL,
  `edited_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `display_name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'super_admin', 'Super Admin', 'Super Admin Has Every Permissions', '2019-08-27 11:23:21', '2019-08-27 11:23:21'),
(2, 'admin', 'Admin', 'Admin Has Permissions to Create Product and Expense', '2019-08-27 11:23:22', '2019-08-27 11:23:22'),
(3, 'accountant', 'Accountant', 'Accountant Has Permissions to Create and Observe Sales and Purchase Report', '2019-08-27 11:23:22', '2019-08-27 11:23:22'),
(4, 'manager', 'Manager', 'Manager Has Permissions to Add Sales', '2019-08-27 11:23:22', '2019-08-27 11:23:22'),
(5, 'area_manager', 'Area Manager', 'Area Manager Has Permissions to Monitor the Salesmen of that Area', '2019-08-27 11:23:22', '2019-08-27 11:23:22'),
(6, 'seller', 'Seller', 'Seller Has Permissions to Make Order', '2019-08-27 11:23:22', '2019-08-27 11:23:22');

-- --------------------------------------------------------

--
-- Table structure for table `role_user`
--

CREATE TABLE `role_user` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_user`
--

INSERT INTO `role_user` (`user_id`, `role_id`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` int(11) NOT NULL,
  `order_id` bigint(20) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `sale_date` date NOT NULL,
  `trade_price` double(8,2) NOT NULL,
  `tp_amount` double(8,2) NOT NULL DEFAULT '0.00',
  `total` double(8,2) NOT NULL DEFAULT '0.00',
  `invoice_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `store_id` text COLLATE utf8mb4_unicode_ci,
  `quantity` text COLLATE utf8mb4_unicode_ci,
  `seller_id` int(11) DEFAULT NULL,
  `superAdmin_approval` tinyint(1) NOT NULL DEFAULT '0',
  `added_by` int(11) DEFAULT NULL,
  `edited_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `product_id`, `order_id`, `customer_id`, `sale_date`, `trade_price`, `tp_amount`, `total`, `invoice_no`, `store_id`, `quantity`, `seller_id`, `superAdmin_approval`, `added_by`, `edited_by`, `created_at`, `updated_at`) VALUES
(1, 1, 11567109520, 1, '2019-08-31', 2.00, 137255.00, 137255.00, 'TI11567109613', '1', '1', 1, 1, NULL, NULL, '2019-08-29 14:13:46', '2019-08-29 14:13:53');

-- --------------------------------------------------------

--
-- Table structure for table `stores`
--

CREATE TABLE `stores` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` int(11) NOT NULL,
  `purchase_date` date NOT NULL,
  `purchase_price` double(8,2) DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stores`
--

INSERT INTO `stores` (`id`, `product_id`, `purchase_date`, `purchase_price`, `quantity`, `created_at`, `updated_at`) VALUES
(1, 1, '2019-08-30', NULL, 19, '2019-08-29 14:04:17', '2019-08-29 14:13:53'),
(2, 2, '2019-08-21', NULL, 400, '2019-08-29 14:04:38', '2019-08-29 14:04:38');

-- --------------------------------------------------------

--
-- Table structure for table `sub_areas`
--

CREATE TABLE `sub_areas` (
  `id` int(10) UNSIGNED NOT NULL,
  `area_id` int(11) NOT NULL,
  `subArea_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subArea_details` text COLLATE utf8mb4_unicode_ci,
  `added_by` int(11) DEFAULT NULL,
  `edited_by` int(11) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sub_areas`
--

INSERT INTO `sub_areas` (`id`, `area_id`, `subArea_name`, `subArea_details`, `added_by`, `edited_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'Sector -3', NULL, 1, NULL, NULL, '2019-08-29 14:09:33', '2019-08-29 14:09:33');

-- --------------------------------------------------------

--
-- Table structure for table `sub_categories`
--

CREATE TABLE `sub_categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `category_id` int(11) NOT NULL,
  `subCategory_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subCategory_details` text COLLATE utf8mb4_unicode_ci,
  `added_by` int(11) DEFAULT NULL,
  `edited_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sub_categories`
--

INSERT INTO `sub_categories` (`id`, `category_id`, `subCategory_name`, `subCategory_details`, `added_by`, `edited_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'Mobile', NULL, 1, NULL, '2019-08-29 13:57:47', '2019-08-29 13:57:47', NULL),
(2, 1, 'Laptop', NULL, 1, NULL, '2019-08-29 13:58:11', '2019-08-29 13:58:11', NULL),
(3, 2, 'Hair care', NULL, 1, NULL, '2019-08-29 13:58:27', '2019-08-29 13:58:27', NULL),
(4, 2, 'Makeup', NULL, 1, NULL, '2019-08-29 13:58:41', '2019-08-29 13:58:41', NULL),
(5, 3, 'Shirts', NULL, 1, NULL, '2019-08-29 13:58:55', '2019-08-29 13:58:55', NULL),
(6, 4, 'Saree', 'Remarks', 1, NULL, '2019-08-29 13:59:21', '2019-08-29 13:59:21', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `area_id` int(11) DEFAULT NULL,
  `subArea_id` int(11) DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `mobile`, `image`, `address`, `area_id`, `subArea_id`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Tom Hank', 'tom@mail.com', '$2y$10$ynfVq3.lS/qd32xAc.lXCuptquMWcrLFYUjgfU.WStu2ElRRQzwmG', '+8800000000', 'avatar.jpg', 'Dhaka, Bangladesh', NULL, NULL, 'oLB66gkaRznyJcSR7sRuqnGlSY7InNIfnC1k1H4LDUUCHB5fInsridfHO8KY', '2019-08-27 11:23:21', '2019-08-27 11:23:21', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `areas`
--
ALTER TABLE `areas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `damaged_products`
--
ALTER TABLE `damaged_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expense_items`
--
ALTER TABLE `expense_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `incomes`
--
ALTER TABLE `incomes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loanreturns`
--
ALTER TABLE `loanreturns`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loans`
--
ALTER TABLE `loans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_unique` (`name`);

--
-- Indexes for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `permission_role_role_id_foreign` (`role_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `returned_products`
--
ALTER TABLE `returned_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`);

--
-- Indexes for table `role_user`
--
ALTER TABLE `role_user`
  ADD PRIMARY KEY (`user_id`,`role_id`),
  ADD KEY `role_user_role_id_foreign` (`role_id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stores`
--
ALTER TABLE `stores`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_areas`
--
ALTER TABLE `sub_areas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_categories`
--
ALTER TABLE `sub_categories`
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
-- AUTO_INCREMENT for table `areas`
--
ALTER TABLE `areas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `damaged_products`
--
ALTER TABLE `damaged_products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expense_items`
--
ALTER TABLE `expense_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `incomes`
--
ALTER TABLE `incomes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `loanreturns`
--
ALTER TABLE `loanreturns`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `loans`
--
ALTER TABLE `loans`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `returned_products`
--
ALTER TABLE `returned_products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `stores`
--
ALTER TABLE `stores`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sub_areas`
--
ALTER TABLE `sub_areas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sub_categories`
--
ALTER TABLE `sub_categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `role_user`
--
ALTER TABLE `role_user`
  ADD CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `role_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

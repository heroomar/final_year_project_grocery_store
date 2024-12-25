-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 25, 2024 at 02:08 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fyp`
--

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` int(11) DEFAULT 0,
  `product_id` int(11) NOT NULL DEFAULT 0,
  `variant_id` int(11) NOT NULL DEFAULT 0,
  `qty` int(11) NOT NULL DEFAULT 0,
  `price` int(11) NOT NULL DEFAULT 0,
  `theme_id` varchar(255) NOT NULL DEFAULT ' ',
  `store_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `coupon_name` varchar(255) DEFAULT NULL,
  `coupon_code` varchar(255) DEFAULT NULL,
  `coupon_type` varchar(255) NOT NULL DEFAULT 'percentage' COMMENT 'percentage / flat',
  `coupon_expiry_date` date DEFAULT NULL,
  `discount_amount` double(8,2) NOT NULL DEFAULT 0.00,
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '0 => Inactive, 1 => Active ',
  `theme_id` varchar(255) DEFAULT NULL,
  `store_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`id`, `coupon_name`, `coupon_code`, `coupon_type`, `coupon_expiry_date`, `discount_amount`, `status`, `theme_id`, `store_id`, `created_at`, `updated_at`) VALUES
(1, 'flat10', 'D86Q7GBQCF', 'percentage', '2024-12-31', 10.00, 1, 'grocery', 1, '2024-12-13 14:37:45', '2024-12-13 14:44:23'),
(2, 'flast10', '6AOUZ9EGS6', 'flat', '2024-12-31', 10.00, 1, 'grocery', 1, '2024-12-13 14:45:12', '2024-12-13 14:45:12');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'cutsomer',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `address` varchar(500) DEFAULT NULL,
  `city_name` varchar(500) DEFAULT NULL,
  `country_name` varchar(500) DEFAULT NULL,
  `postcode` varchar(500) DEFAULT NULL,
  `regiester_date` date DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '0 => on, 1 => off ',
  `date_of_birth` date DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `theme_id` varchar(255) DEFAULT NULL,
  `store_id` int(11) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `first_name`, `last_name`, `email`, `profile_image`, `type`, `email_verified_at`, `mobile`, `address`, `city_name`, `country_name`, `postcode`, `regiester_date`, `status`, `date_of_birth`, `created_by`, `theme_id`, `store_id`, `remember_token`, `created_at`, `updated_at`) VALUES
(2, 'Alana edited', 'Berk', 'Belle', '', 'cutsomer', NULL, 'Buckminster', NULL, NULL, NULL, NULL, '2024-12-13', 0, '2007-11-29', 2, 'grocery', 1, NULL, '2024-12-13 14:06:05', '2024-12-13 14:23:35'),
(6, 'Whoopi Washington', 'Whoopi Washington', 'lymelopi@mailinator.com', NULL, 'cutsomer', NULL, '+1 (327) 184-1778', 'home address', 'fsd', 'Pakistan', '38000', NULL, 0, NULL, NULL, NULL, NULL, NULL, '2024-12-23 09:27:53', '2024-12-23 09:27:53'),
(7, 'Brennan Jensen', 'Brennan Jensen', 'rejes@mailinator.com', NULL, 'cutsomer', NULL, '+1 (159) 557-1093', 'home address', 'fsd', 'Pakistan', '38000', NULL, 0, NULL, NULL, NULL, NULL, NULL, '2024-12-23 10:06:04', '2024-12-23 10:06:04'),
(8, 'customer1', 'customer1', 'customer1@gmail.com', '', 'cutsomer', NULL, '+1 (342) 208-2447', NULL, NULL, NULL, NULL, '2024-12-25', 0, '1989-06-16', 2, 'grocery', 1, NULL, '2024-12-25 06:07:48', '2024-12-25 06:07:48'),
(9, 'April Lambert', 'April Lambert', 'bajakatu@mailinator.com', NULL, 'cutsomer', NULL, '+1 (951) 378-7372', 'Cum sit consequat A', 'Venus Kelly', 'Pakistan', 'Aut autem ad labore', NULL, 0, NULL, NULL, NULL, NULL, NULL, '2024-12-25 07:56:00', '2024-12-25 07:56:00');

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
-- Table structure for table `main_categories`
--

CREATE TABLE `main_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `icon_path` varchar(255) DEFAULT NULL,
  `trending` int(11) NOT NULL DEFAULT 0 COMMENT '0 => no, 1 => yes',
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '0 => Inactive, 1 => Active',
  `theme_id` varchar(255) DEFAULT NULL,
  `store_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `main_categories`
--

INSERT INTO `main_categories` (`id`, `name`, `slug`, `image_url`, `image_path`, `icon_path`, `trending`, `status`, `theme_id`, `store_id`, `created_at`, `updated_at`) VALUES
(4, 'Breakfast Essentials', 'collections/breakfast-essentials', 'http://localhost:8000/storage/uploads/default.jpg', '/storage/uploads/default.jpg', '/storage/uploads/default.jpg', 0, 1, 'grocery', 1, '2024-12-19 10:04:45', '2024-12-19 10:04:45'),
(5, 'Milk & Dairy', 'collections/milk-dairy', 'http://localhost:8000/storage/uploads/default.jpg', '/storage/uploads/default.jpg', '/storage/uploads/default.jpg', 0, 1, 'grocery', 1, '2024-12-19 10:05:03', '2024-12-19 10:05:03'),
(6, 'Fruits & Vegetables', 'collections/fruits-vegetables', 'http://localhost:8000/storage/uploads/default.jpg', '/storage/uploads/default.jpg', '/storage/uploads/default.jpg', 0, 1, 'grocery', 1, '2024-12-19 10:05:12', '2024-12-19 10:05:12'),
(7, 'Meat & Seafood', 'collections/meat-seafood', 'http://localhost:8000/storage/uploads/default.jpg', '/storage/uploads/default.jpg', '/storage/uploads/default.jpg', 0, 1, 'grocery', 1, '2024-12-19 10:05:20', '2024-12-19 10:05:20'),
(8, 'Oil, Ghee & Masala', 'collections/oil-ghee-masala', 'http://localhost:8000/storage/uploads/default.jpg', '/storage/uploads/default.jpg', '/storage/uploads/default.jpg', 0, 1, 'grocery', 1, '2024-12-19 10:05:30', '2024-12-19 10:05:30');

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
(5, '2023_12_25_093024_create_main_categories_table', 2),
(6, '2023_12_25_094412_create_sub_categories_table', 2),
(9, '2024_01_02_064847_create_product_images_table', 3),
(10, '2023_12_26_092822_create_products_table', 4),
(11, '2024_01_23_061635_create_orders_table', 5),
(12, '2023_12_15_112855_create_customers_table', 6),
(13, '2023_12_29_092412_create_coupons_table', 7),
(14, '2023_12_29_100550_create_user_coupons_table', 8),
(15, '2024_02_02_030433_create_purchased_products_table', 9),
(17, '2024_12_18_090858_create_settings_table', 11),
(18, '2024_01_18_103138_create_carts_table', 12),
(19, '2024_02_07_090758_create_order_coupon_details_table', 13),
(20, '2024_12_25_093024_create_store_expense_table', 14);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_order_id` varchar(255) DEFAULT NULL,
  `order_date` datetime DEFAULT NULL,
  `customer_id` int(11) NOT NULL DEFAULT 0,
  `is_guest` int(11) NOT NULL DEFAULT 0 COMMENT '0=>no/1=>yes',
  `product_json` text DEFAULT NULL,
  `product_id` varchar(255) NOT NULL DEFAULT '0',
  `product_price` double(8,2) DEFAULT 0.00,
  `coupon_price` double(8,2) DEFAULT 0.00,
  `delivery_price` double(8,2) DEFAULT 0.00,
  `tax_price` double(8,2) DEFAULT 0.00,
  `final_price` double(8,2) DEFAULT 0.00,
  `return_price` double(8,2) DEFAULT 0.00,
  `payment_comment` text DEFAULT NULL,
  `payment_type` varchar(255) NOT NULL DEFAULT 'cod' COMMENT 'cod',
  `payment_status` varchar(255) DEFAULT NULL,
  `delivered_status` int(11) NOT NULL DEFAULT 0 COMMENT '0=>pending/1=>diliver/2=>cancel/3=>return',
  `delivery_date` date DEFAULT NULL,
  `confirmed_date` date DEFAULT NULL,
  `return_status` int(11) NOT NULL DEFAULT 0 COMMENT '0 => none, 1 => request, 2=>approve, 3 => cancel',
  `return_date` date DEFAULT NULL,
  `cancel_date` date DEFAULT NULL,
  `additional_note` varchar(255) DEFAULT NULL,
  `theme_id` varchar(255) DEFAULT NULL,
  `store_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `product_order_id`, `order_date`, `customer_id`, `is_guest`, `product_json`, `product_id`, `product_price`, `coupon_price`, `delivery_price`, `tax_price`, `final_price`, `return_price`, `payment_comment`, `payment_type`, `payment_status`, `delivered_status`, `delivery_date`, `confirmed_date`, `return_status`, `return_date`, `cancel_date`, `additional_note`, `theme_id`, `store_id`, `user_id`, `created_at`, `updated_at`) VALUES
(13, '1734176530', '2024-12-14 11:42:12', 0, 0, '{\"1\":{\"product_id\":1,\"name\":\"Acton Clay\",\"image\":\"themes\\/grocery\\/uploads\\/52_1734099856_extremerainfallandfloodmonitoringsystemforpakistan.jpg\",\"quantity\":\"5\",\"orignal_price\":1000,\"per_product_discount_price\":null,\"discount_price\":null,\"final_price\":1000,\"id\":\"1\",\"tax\":0,\"total_orignal_price\":5000,\"originalquantity\":94,\"variant_id\":0,\"variant_name\":null,\"return\":0}}', '1', 4000.00, 1000.00, 0.00, 0.00, 4000.00, 0.00, NULL, 'POS', 'Paid', 0, NULL, NULL, 0, NULL, NULL, NULL, 'grocery', 1, 0, '2024-12-14 06:42:12', '2024-12-14 06:42:12'),
(14, '1734177088', '2024-12-14 11:51:30', 0, 0, '{\"1\":{\"product_id\":1,\"name\":\"Acton Clay\",\"image\":\"themes\\/grocery\\/uploads\\/52_1734099856_extremerainfallandfloodmonitoringsystemforpakistan.jpg\",\"quantity\":1,\"orignal_price\":1000,\"per_product_discount_price\":null,\"discount_price\":null,\"final_price\":1000,\"id\":\"1\",\"tax\":0,\"total_orignal_price\":1000,\"originalquantity\":89,\"variant_id\":0,\"variant_name\":null,\"return\":0}}', '1', 500.00, 0.00, 0.00, 0.00, 500.00, 0.00, NULL, 'POS', 'Unpaid', 1, NULL, NULL, 0, NULL, NULL, NULL, 'grocery', 1, 0, '2024-12-14 06:51:30', '2024-12-14 08:01:37'),
(17, '1734968255', '2024-12-23 15:06:04', 7, 1, '{\"42\":{\"id\":42,\"name\":\"Potato - \\u0646\\u06cc\\u0627 \\u0622\\u0644\\u0648\",\"slug\":\"Potato---\\u0646\\u06cc\\u0627-\\u0622\\u0644\\u0648\",\"maincategory_id\":6,\"subcategory_id\":15,\"status\":1,\"price\":150,\"sale_price\":null,\"product_stock\":100,\"product_weight\":1,\"cover_image_path\":\"\",\"cover_image_url\":\"\",\"stock_status\":\"\",\"description\":\"\",\"detail\":\"\",\"specification\":\"\",\"theme_id\":\"grocery\",\"store_id\":1,\"created_by\":2,\"created_at\":\"2024-12-23T07:30:17.000000Z\",\"updated_at\":\"2024-12-23T07:30:17.000000Z\",\"category_name\":\"Fruits & Vegetables\",\"sub_category_name\":\"Vegetables\",\"final_price\":999,\"product_data\":\"\",\"sub_categoryct_data\":\"\",\"qty\":1,\"quantity\":1,\"orignal_price\":150},\"44\":{\"id\":44,\"name\":\"Baby potato - Heirloom farms\",\"slug\":\"Baby-potato---Heirloom-farms\",\"maincategory_id\":6,\"subcategory_id\":17,\"status\":1,\"price\":200,\"sale_price\":null,\"product_stock\":100,\"product_weight\":0,\"cover_image_path\":\"\",\"cover_image_url\":\"\",\"stock_status\":\"\",\"description\":\"\",\"detail\":\"\",\"specification\":\"\",\"theme_id\":\"grocery\",\"store_id\":1,\"created_by\":2,\"created_at\":\"2024-12-23T07:33:03.000000Z\",\"updated_at\":\"2024-12-23T07:33:03.000000Z\",\"category_name\":\"Fruits & Vegetables\",\"sub_category_name\":\"Exotic Herbs & Veg\",\"final_price\":999,\"product_data\":\"\",\"sub_categoryct_data\":\"\",\"qty\":1,\"quantity\":1,\"orignal_price\":200},\"39\":{\"id\":39,\"name\":\"Gaala Desi Ghee (100% Pure)\",\"slug\":\"Gaala-Desi-Ghee-(100%-Pure)\",\"maincategory_id\":8,\"subcategory_id\":14,\"status\":1,\"price\":3200,\"sale_price\":null,\"product_stock\":48,\"product_weight\":null,\"cover_image_path\":\"\",\"cover_image_url\":\"\",\"stock_status\":\"\",\"description\":\"\",\"detail\":\"\",\"specification\":\"\",\"theme_id\":\"grocery\",\"store_id\":1,\"created_by\":2,\"created_at\":\"2024-12-23T07:26:21.000000Z\",\"updated_at\":\"2024-12-23T07:26:21.000000Z\",\"category_name\":\"Oil, Ghee & Masala\",\"sub_category_name\":\"Banaspati Ghee\",\"final_price\":999,\"product_data\":\"\",\"sub_categoryct_data\":\"\",\"qty\":1,\"quantity\":1,\"orignal_price\":3200}}', '39', 3195.00, 355.00, 0.00, 0.00, 2840.00, 0.00, NULL, 'cod', 'Paid', 4, NULL, NULL, 0, NULL, NULL, NULL, 'grocery', 1, 0, '2024-12-23 10:06:04', '2024-12-23 10:06:04'),
(18, '1735136214', '2024-12-25 12:57:45', 9, 1, '{\"34\":{\"id\":34,\"name\":\"Canolive Cooking Oil 1 Litre Pouch\",\"slug\":\"Canolive-Cooking-Oil-1-Litre-Pouch\",\"maincategory_id\":8,\"subcategory_id\":13,\"status\":1,\"price\":600,\"sale_price\":null,\"product_stock\":20,\"product_weight\":null,\"cover_image_path\":\"\",\"cover_image_url\":\"\",\"stock_status\":\"\",\"description\":\"\",\"detail\":\"\",\"specification\":\"\",\"theme_id\":\"grocery\",\"store_id\":1,\"created_by\":2,\"created_at\":\"2024-12-23T07:21:49.000000Z\",\"updated_at\":\"2024-12-23T07:21:49.000000Z\",\"category_name\":\"Oil, Ghee & Masala\",\"sub_category_name\":\"Canola Oil\",\"final_price\":999,\"product_data\":\"\",\"sub_categoryct_data\":\"\",\"qty\":1,\"quantity\":1,\"orignal_price\":600}}', '34', 600.00, 0.00, 0.00, 0.00, 600.00, 0.00, NULL, 'cod', 'Paid', 4, NULL, NULL, 0, NULL, NULL, NULL, 'grocery', 1, 7, '2024-12-25 07:57:45', '2024-12-25 07:57:45');

-- --------------------------------------------------------

--
-- Table structure for table `order_coupon_details`
--

CREATE TABLE `order_coupon_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED DEFAULT NULL,
  `coupon_id` int(11) NOT NULL DEFAULT 0,
  `coupon_name` varchar(255) DEFAULT NULL,
  `coupon_code` varchar(255) DEFAULT NULL,
  `coupon_discount_type` varchar(255) DEFAULT NULL,
  `coupon_discount_number` double(8,2) NOT NULL DEFAULT 0.00,
  `coupon_discount_amount` double(8,2) NOT NULL DEFAULT 0.00,
  `coupon_final_amount` double(8,2) NOT NULL DEFAULT 0.00,
  `theme_id` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_coupon_details`
--

INSERT INTO `order_coupon_details` (`id`, `order_id`, `coupon_id`, `coupon_name`, `coupon_code`, `coupon_discount_type`, `coupon_discount_number`, `coupon_discount_amount`, `coupon_final_amount`, `theme_id`, `created_at`, `updated_at`) VALUES
(3, 16, 1, 'flat10', 'D86Q7GBQCF', 'percentage', 0.00, 10.00, 387.00, 'grocery', '2024-12-23 09:54:05', '2024-12-23 09:54:05'),
(4, 17, 1, 'flat10', 'D86Q7GBQCF', 'percentage', 0.00, 10.00, 355.00, 'grocery', '2024-12-23 10:06:04', '2024-12-23 10:06:04');

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
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `maincategory_id` bigint(20) UNSIGNED DEFAULT NULL,
  `subcategory_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '0 => Inactive, 1 => Active',
  `price` double(8,2) NOT NULL DEFAULT 0.00,
  `sale_price` double(8,2) DEFAULT NULL,
  `product_stock` int(11) NOT NULL DEFAULT 0,
  `product_weight` int(11) DEFAULT NULL,
  `cover_image_path` varchar(255) DEFAULT NULL,
  `cover_image_url` varchar(255) DEFAULT NULL,
  `stock_status` varchar(255) NOT NULL DEFAULT '0',
  `description` longtext DEFAULT NULL,
  `detail` text DEFAULT NULL,
  `specification` text DEFAULT NULL,
  `theme_id` varchar(255) DEFAULT NULL,
  `store_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `slug`, `maincategory_id`, `subcategory_id`, `status`, `price`, `sale_price`, `product_stock`, `product_weight`, `cover_image_path`, `cover_image_url`, `stock_status`, `description`, `detail`, `specification`, `theme_id`, `store_id`, `created_by`, `created_at`, `updated_at`) VALUES
(4, 'Fresh Eggs | Pack of 6 eggs', 'Fresh-Eggs-|-Pack-of-6-eggs', 4, 3, 1, 170.00, 120.00, 100, 1, 'themes/grocery/uploads/30_1734935527_grocery App-fresh-eggs-half-dozen-65ac6f32bb834.jpeg', 'http://localhost:8000/themes/grocery/uploads/30_1734935527_grocery App-fresh-eggs-half-dozen-65ac6f32bb834.jpeg', '0', '<h1 class=\"MuiTypography-root jss774 MuiTypography-h1\" ><span ></span><span >Fresh Eggs | Pack of 6 eggs</span><span >Online from Grocery App.</span><span >Fresh Eggs | Pack of 6 eggs</span><span >Price in Pakistan is Rs.</span><span ></span><span >199</span><span >at Grocery App. Shop</span><span >Fresh Eggs | Pack of 6 eggs</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></h1>', '<p ><span ></span><span >Fresh Eggs | Pack of 6 eggs</span><span >Online from Grocery App.</span><span >Fresh Eggs | Pack of 6 eggs</span><span >Price in Pakistan is Rs.</span><span ></span><span >199</span><span >at Grocery App. Shop</span><span >Fresh Eggs | Pack of 6 eggs</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', '<h1 class=\"MuiTypography-root jss774 MuiTypography-h1\" ><span ></span><span >Fresh Eggs | Pack of 6 eggs</span><span >Online from Grocery App.</span><span >Fresh Eggs | Pack of 6 eggs</span><span >Price in Pakistan is Rs.</span><span ></span><span >199</span><span >at Grocery App. Shop</span><span >Fresh Eggs | Pack of 6 eggs</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></h1>', 'grocery', 1, 2, '2024-12-23 01:32:07', '2024-12-23 01:34:33'),
(5, 'Pure Organic Classic Eggs | Pack of 12 eggs', 'Pure-Organic-Classic-Eggs-|-Pack-of-12-eggs', 4, 3, 1, 415.00, NULL, 100, 1, 'themes/grocery/uploads/81_1734935752_grocery App-pure-organic-classic-eggs--66a89da9117a2.png', 'http://localhost:8000/themes/grocery/uploads/81_1734935752_grocery App-pure-organic-classic-eggs--66a89da9117a2.png', '0', '<p><span ></span><span >Pure Organic Classic Eggs | Pack of 12 eggs</span><span >Online from Grocery App.</span><span >Pure Organic Classic Eggs | Pack of 12 eggs</span><span >Price in Pakistan is Rs.</span><span ></span><span >415</span><span >at Grocery App. Shop</span><span >Pure Organic Classic Eggs | Pack of 12 eggs</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', '<p><span ></span><span >Pure Organic Classic Eggs | Pack of 12 eggs</span><span >Online from Grocery App.</span><span >Pure Organic Classic Eggs | Pack of 12 eggs</span><span >Price in Pakistan is Rs.</span><span ></span><span >415</span><span >at Grocery App. Shop</span><span >Pure Organic Classic Eggs | Pack of 12 eggs</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', '<p><span ></span><span >Pure Organic Classic Eggs | Pack of 12 eggs</span><span >Online from Grocery App.</span><span >Pure Organic Classic Eggs | Pack of 12 eggs</span><span >Price in Pakistan is Rs.</span><span ></span><span >415</span><span >at Grocery App. Shop</span><span >Pure Organic Classic Eggs | Pack of 12 eggs</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', 'grocery', 1, 2, '2024-12-23 01:35:52', '2024-12-23 01:35:52'),
(6, 'Pure Organic Desi Eggs | Pack of 12 Eggs', 'Pure-Organic-Desi-Eggs-|-Pack-of-12-Eggs', 4, 3, 1, 500.00, NULL, 100, 1, 'themes/grocery/uploads/39_1734935814_grocery App-pure-organic-desi-eggs-112-66a89de612db5.png', 'http://localhost:8000/themes/grocery/uploads/39_1734935814_grocery App-pure-organic-desi-eggs-112-66a89de612db5.png', '0', '<p><span ></span><span >Pure Organic Desi Eggs | Pack of 12 Eggs</span><span >Online from Grocery App.</span><span >Pure Organic Desi Eggs | Pack of 12 Eggs</span><span >Price in Pakistan is Rs.</span><span ></span><span >550</span><span >at Grocery App. Shop</span><span >Pure Organic Desi Eggs | Pack of 12 Eggs</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', '<p><span ></span><span >Pure Organic Desi Eggs | Pack of 12 Eggs</span><span >Online from Grocery App.</span><span >Pure Organic Desi Eggs | Pack of 12 Eggs</span><span >Price in Pakistan is Rs.</span><span ></span><span >550</span><span >at Grocery App. Shop</span><span >Pure Organic Desi Eggs | Pack of 12 Eggs</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', '<p><span ></span><span >Pure Organic Desi Eggs | Pack of 12 Eggs</span><span >Online from Grocery App.</span><span >Pure Organic Desi Eggs | Pack of 12 Eggs</span><span >Price in Pakistan is Rs.</span><span ></span><span >550</span><span >at Grocery App. Shop</span><span >Pure Organic Desi Eggs | Pack of 12 Eggs</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', 'grocery', 1, 2, '2024-12-23 01:36:54', '2024-12-23 01:36:54'),
(7, 'Dawn Bread Plain Small 340g', 'Dawn-Bread-Plain-Small-340g', 4, 4, 1, 100.00, NULL, 12, 1, 'themes/grocery/uploads/15_1734936035_grocery App-dawn-bread-small-6172c166e8858.jpeg', 'http://localhost:8000/themes/grocery/uploads/15_1734936035_grocery App-dawn-bread-small-6172c166e8858.jpeg', '0', '<p><span ></span><span >Dawn Bread Plain Small 340g</span><span >Online from Grocery App.</span><span >Dawn Bread Plain Small 340g</span><span >Price in Pakistan is Rs.</span><span ></span><span >110</span><span >at Grocery App. Shop</span><span >Dawn Bread Plain Small 340g</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', '<p><span ></span><span >Dawn Bread Plain Small 340g</span><span >Online from Grocery App.</span><span >Dawn Bread Plain Small 340g</span><span >Price in Pakistan is Rs.</span><span ></span><span >110</span><span >at Grocery App. Shop</span><span >Dawn Bread Plain Small 340g</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', '<p><span ></span><span >Dawn Bread Plain Small 340g</span><span >Online from Grocery App.</span><span >Dawn Bread Plain Small 340g</span><span >Price in Pakistan is Rs.</span><span ></span><span >110</span><span >at Grocery App. Shop</span><span >Dawn Bread Plain Small 340g</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', 'grocery', 1, 2, '2024-12-23 01:40:35', '2024-12-23 01:40:35'),
(8, 'Dawn Brown Bread ( family pack )', 'Dawn-Brown-Bread-(-family-pack-)', 4, 4, 1, 230.00, NULL, 15, 1, 'themes/grocery/uploads/21_1734936104_grocery App-dawn-bread-brown--66e7d51f8c178.jpeg', 'http://localhost:8000/themes/grocery/uploads/21_1734936104_grocery App-dawn-bread-brown--66e7d51f8c178.jpeg', '0', '<p><span ></span><span >Dawn Brown Bread ( family pack )</span><span >Online from Grocery App.</span><span >Dawn Brown Bread ( family pack )</span><span >Price in Pakistan is Rs.</span><span ></span><span >230</span><span >at Grocery App. Shop</span><span >Dawn Brown Bread ( family pack )</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', '<p><span ></span><span >Dawn Brown Bread ( family pack )</span><span >Online from Grocery App.</span><span >Dawn Brown Bread ( family pack )</span><span >Price in Pakistan is Rs.</span><span ></span><span >230</span><span >at Grocery App. Shop</span><span >Dawn Brown Bread ( family pack )</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', '<p><span ></span><span >Dawn Brown Bread ( family pack )</span><span >Online from Grocery App.</span><span >Dawn Brown Bread ( family pack )</span><span >Price in Pakistan is Rs.</span><span ></span><span >230</span><span >at Grocery App. Shop</span><span >Dawn Brown Bread ( family pack )</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', 'grocery', 1, 2, '2024-12-23 01:41:44', '2024-12-23 01:41:44'),
(9, 'Dawn Milky Bread Family Pack 725g', 'Dawn-Milky-Bread-Family-Pack-725g', 4, 4, 1, 200.00, NULL, 15, 1, 'themes/grocery/uploads/11_1734936167_grocery App-dawn-milky-bread-large-5fd21dd618a30.jpeg', 'http://localhost:8000/themes/grocery/uploads/11_1734936167_grocery App-dawn-milky-bread-large-5fd21dd618a30.jpeg', '0', '<p><span ></span><span >Dawn Milky Bread Family Pack 725g</span><span >Online from Grocery App.</span><span >Dawn Milky Bread Family Pack 725g</span><span >Price in Pakistan is Rs.</span><span ></span><span >200</span><span >at Grocery App. Shop</span><span >Dawn Milky Bread Family Pack 725g</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', '<p><span ></span><span >Dawn Milky Bread Family Pack 725g</span><span >Online from Grocery App.</span><span >Dawn Milky Bread Family Pack 725g</span><span >Price in Pakistan is Rs.</span><span ></span><span >200</span><span >at Grocery App. Shop</span><span >Dawn Milky Bread Family Pack 725g</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', '<p><span ></span><span >Dawn Milky Bread Family Pack 725g</span><span >Online from Grocery App.</span><span >Dawn Milky Bread Family Pack 725g</span><span >Price in Pakistan is Rs.</span><span ></span><span >200</span><span >at Grocery App. Shop</span><span >Dawn Milky Bread Family Pack 725g</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', 'grocery', 1, 2, '2024-12-23 01:42:47', '2024-12-23 01:42:47'),
(10, 'Marhaba Honey', 'Marhaba-Honey', 4, 5, 1, 500.00, NULL, 50, 1, 'themes/grocery/uploads/86_1734936256_grocery App-marhaba-honey-5e6bfb9360918.jpeg', 'http://localhost:8000/themes/grocery/uploads/86_1734936256_grocery App-marhaba-honey-5e6bfb9360918.jpeg', '0', '<p><span ></span><span >Marhaba Honey</span><span >Online from Grocery App.</span><span >Marhaba Honey</span><span >Price in Pakistan is Rs.</span><span ></span><span >510</span><span >at Grocery App. Shop</span><span >Marhaba Honey</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', '<p><span ></span><span >Marhaba Honey</span><span >Online from Grocery App.</span><span >Marhaba Honey</span><span >Price in Pakistan is Rs.</span><span ></span><span >510</span><span >at Grocery App. Shop</span><span >Marhaba Honey</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', '<p><span ></span><span >Marhaba Honey</span><span >Online from Grocery App.</span><span >Marhaba Honey</span><span >Price in Pakistan is Rs.</span><span ></span><span >510</span><span >at Grocery App. Shop</span><span >Marhaba Honey</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', 'grocery', 1, 2, '2024-12-23 01:44:16', '2024-12-23 01:44:16'),
(11, 'Youngs Bee Hive Honey Bottle', 'Youngs-Bee-Hive-Honey-Bottle', 4, 5, 1, 400.00, NULL, 20, NULL, 'themes/grocery/uploads/38_1734936382_grocery App-youngs-bee-hive-honey-bottle-5fc4f7093b1e3.jpeg', 'http://localhost:8000/themes/grocery/uploads/38_1734936382_grocery App-youngs-bee-hive-honey-bottle-5fc4f7093b1e3.jpeg', '0', '<h1 class=\"MuiTypography-root jss774 MuiTypography-h1\" ><span ></span><span >Youngs Bee Hive Honey Bottle</span><span >Online from Grocery App.</span><span >Youngs Bee Hive Honey Bottle</span><span >Price in Pakistan is Rs.</span><span ></span><span >460</span><span >at Grocery App. Shop</span><span >Youngs Bee Hive Honey Bottle</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></h1>', '<p><span ></span><span >Youngs Bee Hive Honey Bottle</span><span >Online from Grocery App.</span><span >Youngs Bee Hive Honey Bottle</span><span >Price in Pakistan is Rs.</span><span ></span><span >460</span><span >at Grocery App. Shop</span><span >Youngs Bee Hive Honey Bottle</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', '<p><span ></span><span >Youngs Bee Hive Honey Bottle</span><span >Online from Grocery App.</span><span >Youngs Bee Hive Honey Bottle</span><span >Price in Pakistan is Rs.</span><span ></span><span >460</span><span >at Grocery App. Shop</span><span >Youngs Bee Hive Honey Bottle</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', 'grocery', 1, 2, '2024-12-23 01:46:22', '2024-12-23 01:46:22'),
(12, 'Youngs Honey Natural Glass Jar', 'Youngs-Honey-Natural-Glass-Jar', 4, 5, 1, 300.00, NULL, 24, NULL, 'themes/grocery/uploads/26_1734936483_grocery App-youngs-honey-natural-glass-jar-5ef6e2cce1de0.jpeg', 'http://localhost:8000/themes/grocery/uploads/26_1734936483_grocery App-youngs-honey-natural-glass-jar-5ef6e2cce1de0.jpeg', '0', '<p><span ></span><span >Youngs Honey Natural Glass Jar</span><span >Online from Grocery App.</span><span >Youngs Honey Natural Glass Jar</span><span >Price in Pakistan is Rs.</span><span ></span><span >320</span><span >at Grocery App. Shop</span><span >Youngs Honey Natural Glass Jar</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', '<p><span ></span><span >Youngs Honey Natural Glass Jar</span><span >Online from Grocery App.</span><span >Youngs Honey Natural Glass Jar</span><span >Price in Pakistan is Rs.</span><span ></span><span >320</span><span >at Grocery App. Shop</span><span >Youngs Honey Natural Glass Jar</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', '<p><span ></span><span >Youngs Honey Natural Glass Jar</span><span >Online from Grocery App.</span><span >Youngs Honey Natural Glass Jar</span><span >Price in Pakistan is Rs.</span><span ></span><span >320</span><span >at Grocery App. Shop</span><span >Youngs Honey Natural Glass Jar</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', 'grocery', 1, 2, '2024-12-23 01:48:03', '2024-12-23 01:48:03'),
(13, 'Gaala Raw Milk', 'Gaala-Raw-Milk', 5, 6, 1, 200.00, NULL, 12, NULL, 'themes/grocery/uploads/28_1734936912_grocery App-gaala-raw-milk-641a9860b82b1.png', 'http://localhost:8000/themes/grocery/uploads/28_1734936912_grocery App-gaala-raw-milk-641a9860b82b1.png', '0', '<p><span ></span><span >Gaala Raw Milk</span><span >Online from Grocery App.</span><span >Gaala Raw Milk</span><span >Price in Pakistan is Rs.</span><span ></span><span >214</span><span >at Grocery App. Shop</span><span >Gaala Raw Milk</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', '<p><span ></span><span >Gaala Raw Milk</span><span >Online from Grocery App.</span><span >Gaala Raw Milk</span><span >Price in Pakistan is Rs.</span><span ></span><span >214</span><span >at Grocery App. Shop</span><span >Gaala Raw Milk</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', '<p><span ></span><span >Gaala Raw Milk</span><span >Online from Grocery App.</span><span >Gaala Raw Milk</span><span >Price in Pakistan is Rs.</span><span ></span><span >214</span><span >at Grocery App. Shop</span><span >Gaala Raw Milk</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', 'grocery', 1, 2, '2024-12-23 01:55:12', '2024-12-23 01:55:12'),
(14, 'Prema Milk', 'Prema-Milk', 5, 6, 1, 300.00, NULL, 6, NULL, 'themes/grocery/uploads/33_1734936971_grocery App-1ltr-prema-milk-62ff24d1c63f5.jpeg', 'http://localhost:8000/themes/grocery/uploads/33_1734936971_grocery App-1ltr-prema-milk-62ff24d1c63f5.jpeg', '0', '<p><span ></span><span >Prema Milk</span><span >Online from Grocery App.</span><span >Prema Milk</span><span >Price in Pakistan is Rs.</span><span ></span><span >370</span><span >at Grocery App. Shop</span><span >Prema Milk</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', '<p><span ></span><span >Prema Milk</span><span >Online from Grocery App.</span><span >Prema Milk</span><span >Price in Pakistan is Rs.</span><span ></span><span >370</span><span >at Grocery App. Shop</span><span >Prema Milk</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', '<p><span ></span><span >Prema Milk</span><span >Online from Grocery App.</span><span >Prema Milk</span><span >Price in Pakistan is Rs.</span><span ></span><span >370</span><span >at Grocery App. Shop</span><span >Prema Milk</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', 'grocery', 1, 2, '2024-12-23 01:56:11', '2024-12-23 01:56:11'),
(15, 'Adams Milk Pasteurized', 'Adams-Milk-Pasteurized', 5, 6, 1, 250.00, NULL, 5, NULL, 'themes/grocery/uploads/65_1734937034_grocery App-1ltr-adams-milk-pasteurized-60eef09a927e9.jpeg', 'http://localhost:8000/themes/grocery/uploads/65_1734937034_grocery App-1ltr-adams-milk-pasteurized-60eef09a927e9.jpeg', '0', '<p><span ></span><span >Adams Milk Pasteurized</span><span >Online from Grocery App.</span><span >Adams Milk Pasteurized</span><span >Price in Pakistan is Rs.</span><span ></span><span >270</span><span >at Grocery App. Shop</span><span >Adams Milk Pasteurized</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', '<p><span ></span><span >Adams Milk Pasteurized</span><span >Online from Grocery App.</span><span >Adams Milk Pasteurized</span><span >Price in Pakistan is Rs.</span><span ></span><span >270</span><span >at Grocery App. Shop</span><span >Adams Milk Pasteurized</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', '<p><span ></span><span >Adams Milk Pasteurized</span><span >Online from Grocery App.</span><span >Adams Milk Pasteurized</span><span >Price in Pakistan is Rs.</span><span ></span><span >270</span><span >at Grocery App. Shop</span><span >Adams Milk Pasteurized</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', 'grocery', 1, 2, '2024-12-23 01:57:14', '2024-12-23 01:57:14'),
(16, 'Nestle Milk Pak Full Cream Milk', 'Nestle-Milk-Pak-Full-Cream-Milk', 5, 7, 1, 360.00, NULL, 12, NULL, 'themes/grocery/uploads/15_1734937139_grocery App-nestle-milk-pak-full-cream-6597d2d07d099.png', 'http://localhost:8000/themes/grocery/uploads/15_1734937139_grocery App-nestle-milk-pak-full-cream-6597d2d07d099.png', '0', '<p><span ></span><span >Nestle Milk Pak Full Cream Milk</span><span >Online from Grocery App.</span><span >Nestle Milk Pak Full Cream Milk</span><span >Price in Pakistan is Rs.</span><span ></span><span >360</span><span >at Grocery App. Shop</span><span >Nestle Milk Pak Full Cream Milk</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', '<p><span ></span><span >Nestle Milk Pak Full Cream Milk</span><span >Online from Grocery App.</span><span >Nestle Milk Pak Full Cream Milk</span><span >Price in Pakistan is Rs.</span><span ></span><span >360</span><span >at Grocery App. Shop</span><span >Nestle Milk Pak Full Cream Milk</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', '<p><span ></span><span >Nestle Milk Pak Full Cream Milk</span><span >Online from Grocery App.</span><span >Nestle Milk Pak Full Cream Milk</span><span >Price in Pakistan is Rs.</span><span ></span><span >360</span><span >at Grocery App. Shop</span><span >Nestle Milk Pak Full Cream Milk</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', 'grocery', 1, 2, '2024-12-23 01:58:59', '2024-12-23 01:58:59');
INSERT INTO `products` (`id`, `name`, `slug`, `maincategory_id`, `subcategory_id`, `status`, `price`, `sale_price`, `product_stock`, `product_weight`, `cover_image_path`, `cover_image_url`, `stock_status`, `description`, `detail`, `specification`, `theme_id`, `store_id`, `created_by`, `created_at`, `updated_at`) VALUES
(17, 'Day Fresh Full Cream Mlik', 'Day-Fresh-Full-Cream-Mlik', 5, 7, 1, 150.00, NULL, 20, NULL, 'themes/grocery/uploads/76_1734937190_grocery App-day-fresh-full-cream-mlik-5e6c43fd8dc26.png', 'http://localhost:8000/themes/grocery/uploads/76_1734937190_grocery App-day-fresh-full-cream-mlik-5e6c43fd8dc26.png', '0', '<p><span ></span><span >Day Fresh Full Cream Mlik</span><span >Online from Grocery App.</span><span >Day Fresh Full Cream Mlik</span><span >Price in Pakistan is Rs.</span><span ></span><span >120</span><span >at Grocery App. Shop</span><span >Day Fresh Full Cream Mlik</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', '<p><span ></span><span >Day Fresh Full Cream Mlik</span><span >Online from Grocery App.</span><span >Day Fresh Full Cream Mlik</span><span >Price in Pakistan is Rs.</span><span ></span><span >120</span><span >at Grocery App. Shop</span><span >Day Fresh Full Cream Mlik</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', '<p><span ></span><span >Day Fresh Full Cream Mlik</span><span >Online from Grocery App.</span><span >Day Fresh Full Cream Mlik</span><span >Price in Pakistan is Rs.</span><span ></span><span >120</span><span >at Grocery App. Shop</span><span >Day Fresh Full Cream Mlik</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', 'grocery', 1, 2, '2024-12-23 01:59:50', '2024-12-23 01:59:50'),
(18, 'Nurpur Full Cream Milk Pouch', 'Nurpur-Full-Cream-Milk-Pouch', 5, 7, 1, 100.00, NULL, 50, NULL, 'themes/grocery/uploads/33_1734937255_grocery App-nurpur-full-cream-milk-pouch-65e1862576d9e.jpeg', 'http://localhost:8000/themes/grocery/uploads/33_1734937255_grocery App-nurpur-full-cream-milk-pouch-65e1862576d9e.jpeg', '0', '<p><span ></span><span >Nurpur Full Cream Milk Pouch</span><span >Online from Grocery App.</span><span >Nurpur Full Cream Milk Pouch</span><span >Price in Pakistan is Rs.</span><span ></span><span >95</span><span >at Grocery App. Shop</span><span >Nurpur Full Cream Milk Pouch</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', '<p><span ></span><span >Nurpur Full Cream Milk Pouch</span><span >Online from Grocery App.</span><span >Nurpur Full Cream Milk Pouch</span><span >Price in Pakistan is Rs.</span><span ></span><span >95</span><span >at Grocery App. Shop</span><span >Nurpur Full Cream Milk Pouch</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', '<p><span ></span><span >Nurpur Full Cream Milk Pouch</span><span >Online from Grocery App.</span><span >Nurpur Full Cream Milk Pouch</span><span >Price in Pakistan is Rs.</span><span ></span><span >95</span><span >at Grocery App. Shop</span><span >Nurpur Full Cream Milk Pouch</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', 'grocery', 1, 2, '2024-12-23 02:00:55', '2024-12-23 02:00:55'),
(19, 'Rossmoor Instant Coocnut Milk Powder', 'Rossmoor-Instant-Coocnut-Milk-Powder', 5, 8, 1, 150.00, NULL, 50, NULL, 'themes/grocery/uploads/26_1734937343_grocery App-rossmoor-instant-coocnut-milk-powder-5f841b6d3594e.jpeg', 'http://localhost:8000/themes/grocery/uploads/26_1734937343_grocery App-rossmoor-instant-coocnut-milk-powder-5f841b6d3594e.jpeg', '0', '<p><span ></span><span >Rossmoor Instant Coocnut Milk Powder</span><span >Online from Grocery App.</span><span >Rossmoor Instant Coocnut Milk Powder</span><span >Price in Pakistan is Rs.</span><span ></span><span >205</span><span >at Grocery App. Shop</span><span >Rossmoor Instant Coocnut Milk Powder</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', '<p><span ></span><span >Rossmoor Instant Coocnut Milk Powder</span><span >Online from Grocery App.</span><span >Rossmoor Instant Coocnut Milk Powder</span><span >Price in Pakistan is Rs.</span><span ></span><span >205</span><span >at Grocery App. Shop</span><span >Rossmoor Instant Coocnut Milk Powder</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', '<p><span ></span><span >Rossmoor Instant Coocnut Milk Powder</span><span >Online from Grocery App.</span><span >Rossmoor Instant Coocnut Milk Powder</span><span >Price in Pakistan is Rs.</span><span ></span><span >205</span><span >at Grocery App. Shop</span><span >Rossmoor Instant Coocnut Milk Powder</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', 'grocery', 1, 2, '2024-12-23 02:02:23', '2024-12-23 02:02:23'),
(20, 'Millac Skimillac Powder Milk', 'Millac-Skimillac-Powder-Milk', 5, 8, 1, 1800.00, NULL, 25, 1, 'themes/grocery/uploads/12_1734937400_grocery App-millac-skimillac-powder-milk-5e6bf945f0f85.png', 'http://localhost:8000/themes/grocery/uploads/12_1734937400_grocery App-millac-skimillac-powder-milk-5e6bf945f0f85.png', '0', '<p><span ></span><span >Millac Skimillac Powder Milk</span><span >Online from Grocery App.</span><span >Millac Skimillac Powder Milk</span><span >Price in Pakistan is Rs.</span><span ></span><span >1999</span><span >at Grocery App. Shop</span><span >Millac Skimillac Powder Milk</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', '<p><span ></span><span >Millac Skimillac Powder Milk</span><span >Online from Grocery App.</span><span >Millac Skimillac Powder Milk</span><span >Price in Pakistan is Rs.</span><span ></span><span >1999</span><span >at Grocery App. Shop</span><span >Millac Skimillac Powder Milk</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', '<p><span ></span><span >Millac Skimillac Powder Milk</span><span >Online from Grocery App.</span><span >Millac Skimillac Powder Milk</span><span >Price in Pakistan is Rs.</span><span ></span><span >1999</span><span >at Grocery App. Shop</span><span >Millac Skimillac Powder Milk</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', 'grocery', 1, 2, '2024-12-23 02:03:21', '2024-12-23 02:03:21'),
(21, 'MILLAC TEA WHITNER POWDER', 'MILLAC-TEA-WHITNER-POWDER', 5, 8, 1, 500.00, NULL, 50, NULL, 'themes/grocery/uploads/20_1734937461_grocery App-millac-tea-whitner-powder-61234720d66de.jpeg', 'http://localhost:8000/themes/grocery/uploads/20_1734937461_grocery App-millac-tea-whitner-powder-61234720d66de.jpeg', '0', '<p><span ></span><span >MILLAC TEA WHITNER POWDER</span><span >Online from Grocery App.</span><span >MILLAC TEA WHITNER POWDER</span><span >Price in Pakistan is Rs.</span><span ></span><span >715</span><span >at Grocery App. Shop</span><span >MILLAC TEA WHITNER POWDER</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', '<p><span ></span><span >MILLAC TEA WHITNER POWDER</span><span >Online from Grocery App.</span><span >MILLAC TEA WHITNER POWDER</span><span >Price in Pakistan is Rs.</span><span ></span><span >715</span><span >at Grocery App. Shop</span><span >MILLAC TEA WHITNER POWDER</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', '<p><span ></span><span >MILLAC TEA WHITNER POWDER</span><span >Online from Grocery App.</span><span >MILLAC TEA WHITNER POWDER</span><span >Price in Pakistan is Rs.</span><span ></span><span >715</span><span >at Grocery App. Shop</span><span >MILLAC TEA WHITNER POWDER</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', 'grocery', 1, 2, '2024-12-23 02:04:21', '2024-12-23 02:04:21'),
(22, 'Chicken Boneless Breast - ALMEES', 'Chicken-Boneless-Breast---ALMEES', 7, 9, 1, 1100.00, NULL, 50, 1, 'themes/grocery/uploads/69_1734937568_grocery App-chicken-boneless-breast-almees-6763c4c017dd1.jpeg', 'http://localhost:8000/themes/grocery/uploads/69_1734937568_grocery App-chicken-boneless-breast-almees-6763c4c017dd1.jpeg', '0', '<p><span ></span><span >Chicken Boneless Breast - ALMEES</span><span >Online from Grocery App.</span><span >Chicken Boneless Breast - ALMEES</span><span >Price in Pakistan is Rs.</span><span ></span><span >1198</span><span >at Grocery App. Shop</span><span >Chicken Boneless Breast - ALMEES</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', '<p><span ></span><span >Chicken Boneless Breast - ALMEES</span><span >Online from Grocery App.</span><span >Chicken Boneless Breast - ALMEES</span><span >Price in Pakistan is Rs.</span><span ></span><span >1198</span><span >at Grocery App. Shop</span><span >Chicken Boneless Breast - ALMEES</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', '<p><span ></span><span >Chicken Boneless Breast - ALMEES</span><span >Online from Grocery App.</span><span >Chicken Boneless Breast - ALMEES</span><span >Price in Pakistan is Rs.</span><span ></span><span >1198</span><span >at Grocery App. Shop</span><span >Chicken Boneless Breast - ALMEES</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', 'grocery', 1, 2, '2024-12-23 02:06:08', '2024-12-23 02:06:08'),
(23, 'Chicken Karahi Cut - F&C Meat Mart', 'Chicken-Karahi-Cut---F&C-Meat-Mart', 7, 9, 1, 590.00, NULL, 30, 1, 'themes/grocery/uploads/97_1734937648_grocery App-chicken-karahi-cut--627d029db9983.jpeg', 'http://localhost:8000/themes/grocery/uploads/97_1734937648_grocery App-chicken-karahi-cut--627d029db9983.jpeg', '0', '<p><span ></span><span >Chicken Karahi Cut - F&C Meat Mart</span><span >Online from Grocery App.</span><span >Chicken Karahi Cut - F&C Meat Mart</span><span >Price in Pakistan is Rs.</span><span ></span><span >590</span><span >at Grocery App. Shop</span><span >Chicken Karahi Cut - F&C Meat Mart</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', '<p><span ></span><span >Chicken Karahi Cut - F&C Meat Mart</span><span >Online from Grocery App.</span><span >Chicken Karahi Cut - F&C Meat Mart</span><span >Price in Pakistan is Rs.</span><span ></span><span >590</span><span >at Grocery App. Shop</span><span >Chicken Karahi Cut - F&C Meat Mart</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', '<p><span ></span><span >Chicken Karahi Cut - F&C Meat Mart</span><span >Online from Grocery App.</span><span >Chicken Karahi Cut - F&C Meat Mart</span><span >Price in Pakistan is Rs.</span><span ></span><span >590</span><span >at Grocery App. Shop</span><span >Chicken Karahi Cut - F&C Meat Mart</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', 'grocery', 1, 2, '2024-12-23 02:07:28', '2024-12-23 02:07:28'),
(24, 'Chicken Boneless Cubes - F&C Meat Mart', 'Chicken-Boneless-Cubes---F&C-Meat-Mart', 7, 9, 1, 550.00, NULL, 30, 1, 'themes/grocery/uploads/90_1734937733_grocery App-chicken-boneless-cubes-63c63907d16e9.jpeg', 'http://localhost:8000/themes/grocery/uploads/90_1734937733_grocery App-chicken-boneless-cubes-63c63907d16e9.jpeg', '0', '<p><span ></span><span >Chicken Boneless Cubes - F&C Meat Mart</span><span >Online from Grocery App.</span><span >Chicken Boneless Cubes - F&C Meat Mart</span><span >Price in Pakistan is Rs.</span><span ></span><span >510</span><span >at Grocery App. Shop</span><span >Chicken Boneless Cubes - F&C Meat Mart</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', '<p><span ></span><span >Chicken Boneless Cubes - F&C Meat Mart</span><span >Online from Grocery App.</span><span >Chicken Boneless Cubes - F&C Meat Mart</span><span >Price in Pakistan is Rs.</span><span ></span><span >510</span><span >at Grocery App. Shop</span><span >Chicken Boneless Cubes - F&C Meat Mart</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', '<p><span ></span><span >Chicken Boneless Cubes - F&C Meat Mart</span><span >Online from Grocery App.</span><span >Chicken Boneless Cubes - F&C Meat Mart</span><span >Price in Pakistan is Rs.</span><span ></span><span >510</span><span >at Grocery App. Shop</span><span >Chicken Boneless Cubes - F&C Meat Mart</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', 'grocery', 1, 2, '2024-12-23 02:08:53', '2024-12-23 02:08:53'),
(25, 'Fish Burger Patty (Crumbs) 3 Pieces', 'Fish-Burger-Patty-(Crumbs)-3-Pieces', 7, 10, 1, 800.00, NULL, 50, NULL, 'themes/grocery/uploads/11_1734937815_grocery App-fish-burger-patty-crumbs-63de39e22ac02.jpeg', 'http://localhost:8000/themes/grocery/uploads/11_1734937815_grocery App-fish-burger-patty-crumbs-63de39e22ac02.jpeg', '0', '<p><span ></span><span >Fish Burger Patty (Crumbs) 3 Pieces</span><span >Online from Grocery App.</span><span >Fish Burger Patty (Crumbs) 3 Pieces</span><span >Price in Pakistan is Rs.</span><span ></span><span >810</span><span >at Grocery App. Shop</span><span >Fish Burger Patty (Crumbs) 3 Pieces</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', '<p><span ></span><span >Fish Burger Patty (Crumbs) 3 Pieces</span><span >Online from Grocery App.</span><span >Fish Burger Patty (Crumbs) 3 Pieces</span><span >Price in Pakistan is Rs.</span><span ></span><span >810</span><span >at Grocery App. Shop</span><span >Fish Burger Patty (Crumbs) 3 Pieces</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', '<p><span ></span><span >Fish Burger Patty (Crumbs) 3 Pieces</span><span >Online from Grocery App.</span><span >Fish Burger Patty (Crumbs) 3 Pieces</span><span >Price in Pakistan is Rs.</span><span ></span><span >810</span><span >at Grocery App. Shop</span><span >Fish Burger Patty (Crumbs) 3 Pieces</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', 'grocery', 1, 2, '2024-12-23 02:10:15', '2024-12-23 02:10:15'),
(26, 'Fish Biscuits (Crumbs)', 'Fish-Biscuits-(Crumbs)', 7, 10, 1, 900.00, NULL, 50, NULL, 'themes/grocery/uploads/91_1734937875_grocery App-fish-biscuits-crumbs-63de38b1f2aa6.jpeg', 'http://localhost:8000/themes/grocery/uploads/91_1734937875_grocery App-fish-biscuits-crumbs-63de38b1f2aa6.jpeg', '0', '<p><span ></span><span >Fish Biscuits (Crumbs)</span><span >Online from Grocery App.</span><span >Fish Biscuits (Crumbs)</span><span >Price in Pakistan is Rs.</span><span ></span><span >810</span><span >at Grocery App. Shop</span><span >Fish Biscuits (Crumbs)</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', '<p><span ></span><span >Fish Biscuits (Crumbs)</span><span >Online from Grocery App.</span><span >Fish Biscuits (Crumbs)</span><span >Price in Pakistan is Rs.</span><span ></span><span >810</span><span >at Grocery App. Shop</span><span >Fish Biscuits (Crumbs)</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', '<p><span ></span><span >Fish Biscuits (Crumbs)</span><span >Online from Grocery App.</span><span >Fish Biscuits (Crumbs)</span><span >Price in Pakistan is Rs.</span><span ></span><span >810</span><span >at Grocery App. Shop</span><span >Fish Biscuits (Crumbs)</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', 'grocery', 1, 2, '2024-12-23 02:11:15', '2024-12-23 02:11:15'),
(27, 'White pomfret 800-GM', 'White-pomfret-800-GM', 7, 10, 1, 1900.00, NULL, 50, 1, 'themes/grocery/uploads/67_1734937931_grocery App-white-pomfret-500gm-61457a05561d1.jpeg', 'http://localhost:8000/themes/grocery/uploads/67_1734937931_grocery App-white-pomfret-500gm-61457a05561d1.jpeg', '0', '<p><span ></span><span >White pomfret 800-GM</span><span >Online from Grocery App.</span><span >White pomfret 800-GM</span><span >Price in Pakistan is Rs.</span><span ></span><span >1980</span><span >at Grocery App. Shop</span><span >White pomfret 800-GM</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', '<p><span ></span><span >White pomfret 800-GM</span><span >Online from Grocery App.</span><span >White pomfret 800-GM</span><span >Price in Pakistan is Rs.</span><span ></span><span >1980</span><span >at Grocery App. Shop</span><span >White pomfret 800-GM</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', '<p><span ></span><span >White pomfret 800-GM</span><span >Online from Grocery App.</span><span >White pomfret 800-GM</span><span >Price in Pakistan is Rs.</span><span ></span><span >1980</span><span >at Grocery App. Shop</span><span >White pomfret 800-GM</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', 'grocery', 1, 2, '2024-12-23 02:12:11', '2024-12-23 02:12:11'),
(28, 'Mutton Biryani Cut - ALMEES', 'Mutton-Biryani-Cut---ALMEES', 7, 11, 1, 1800.00, NULL, 50, NULL, 'themes/grocery/uploads/66_1734938017_grocery App-mutton-biryani-cut-almees-654b83e7c8418.jpeg', 'http://localhost:8000/themes/grocery/uploads/66_1734938017_grocery App-mutton-biryani-cut-almees-654b83e7c8418.jpeg', '0', '<p><span ></span><span >Mutton Biryani Cut - ALMEES</span><span >Online from Grocery App.</span><span >Mutton Biryani Cut - ALMEES</span><span >Price in Pakistan is Rs.</span><span ></span><span >1799</span><span >at Grocery App. Shop</span><span >Mutton Biryani Cut - ALMEES</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', '<p><span ></span><span >Mutton Biryani Cut - ALMEES</span><span >Online from Grocery App.</span><span >Mutton Biryani Cut - ALMEES</span><span >Price in Pakistan is Rs.</span><span ></span><span >1799</span><span >at Grocery App. Shop</span><span >Mutton Biryani Cut - ALMEES</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', '<p><span ></span><span >Mutton Biryani Cut - ALMEES</span><span >Online from Grocery App.</span><span >Mutton Biryani Cut - ALMEES</span><span >Price in Pakistan is Rs.</span><span ></span><span >1799</span><span >at Grocery App. Shop</span><span >Mutton Biryani Cut - ALMEES</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', 'grocery', 1, 2, '2024-12-23 02:13:37', '2024-12-23 02:13:37'),
(29, 'Dumba Fat (Charbi)', 'Dumba-Fat-(Charbi)', 7, 11, 1, 650.00, NULL, 50, 0, 'themes/grocery/uploads/20_1734938090_grocery App-dumba-fat-charbi-63ca7d3b7a1f6.jpeg', 'http://localhost:8000/themes/grocery/uploads/20_1734938090_grocery App-dumba-fat-charbi-63ca7d3b7a1f6.jpeg', '0', '<p><span ></span><span >Dumba Fat (Charbi) - F&C Meat Mart</span><span >Online from Grocery App.</span><span >Dumba Fat (Charbi) - F&C Meat Mart</span><span >Price in Pakistan is Rs.</span><span ></span><span >615</span><span >at Grocery App. Shop</span><span >Dumba Fat (Charbi) - F&C Meat Mart</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', '<p><span ></span><span >Dumba Fat (Charbi) - F&C Meat Mart</span><span >Online from Grocery App.</span><span >Dumba Fat (Charbi) - F&C Meat Mart</span><span >Price in Pakistan is Rs.</span><span ></span><span >615</span><span >at Grocery App. Shop</span><span >Dumba Fat (Charbi) - F&C Meat Mart</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', '<p><span ></span><span >Dumba Fat (Charbi) - F&C Meat Mart</span><span >Online from Grocery App.</span><span >Dumba Fat (Charbi) - F&C Meat Mart</span><span >Price in Pakistan is Rs.</span><span ></span><span >615</span><span >at Grocery App. Shop</span><span >Dumba Fat (Charbi) - F&C Meat Mart</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', 'grocery', 1, 2, '2024-12-23 02:14:50', '2024-12-23 02:14:50');
INSERT INTO `products` (`id`, `name`, `slug`, `maincategory_id`, `subcategory_id`, `status`, `price`, `sale_price`, `product_stock`, `product_weight`, `cover_image_path`, `cover_image_url`, `stock_status`, `description`, `detail`, `specification`, `theme_id`, `store_id`, `created_by`, `created_at`, `updated_at`) VALUES
(30, 'Mutton Neck - Zabiha Halal', 'Mutton-Neck---Zabiha-Halal', 7, 11, 1, 1200.00, NULL, 50, 0, 'themes/grocery/uploads/61_1734938168_grocery App-mutton-neck-zabiha-halal-66b1c47f7202a.jpeg', 'http://localhost:8000/themes/grocery/uploads/61_1734938168_grocery App-mutton-neck-zabiha-halal-66b1c47f7202a.jpeg', '0', '<p><span ></span><span >Mutton Neck - Zabiha Halal</span><span >Online from Grocery App.</span><span >Mutton Neck - Zabiha Halal</span><span >Price in Pakistan is Rs.</span><span ></span><span >1118</span><span >at Grocery App. Shop</span><span >Mutton Neck - Zabiha Halal</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', '<p><span ></span><span >Mutton Neck - Zabiha Halal</span><span >Online from Grocery App.</span><span >Mutton Neck - Zabiha Halal</span><span >Price in Pakistan is Rs.</span><span ></span><span >1118</span><span >at Grocery App. Shop</span><span >Mutton Neck - Zabiha Halal</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', '<p><span ></span><span >Mutton Neck - Zabiha Halal</span><span >Online from Grocery App.</span><span >Mutton Neck - Zabiha Halal</span><span >Price in Pakistan is Rs.</span><span ></span><span >1118</span><span >at Grocery App. Shop</span><span >Mutton Neck - Zabiha Halal</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', 'grocery', 1, 2, '2024-12-23 02:16:08', '2024-12-23 02:16:08'),
(31, 'Kausar Cooking Oil 1 Litre Pouch', 'Kausar-Cooking-Oil-1-Litre-Pouch', 8, 12, 1, 600.00, NULL, 50, NULL, 'themes/grocery/uploads/76_1734938269_grocery App-kausar-cooking-oil-pouch-619f2816ba68f.jpeg', 'http://localhost:8000/themes/grocery/uploads/76_1734938269_grocery App-kausar-cooking-oil-pouch-619f2816ba68f.jpeg', '0', '<p><span ></span><span >Kausar Cooking Oil 1 Litre Pouch</span><span >Online from Grocery App.</span><span >Kausar Cooking Oil 1 Litre Pouch</span><span >Price in Pakistan is Rs.</span><span ></span><span >586</span><span >at Grocery App. Shop</span><span >Kausar Cooking Oil 1 Litre Pouch</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', '<p><span ></span><span >Kausar Cooking Oil 1 Litre Pouch</span><span >Online from Grocery App.</span><span >Kausar Cooking Oil 1 Litre Pouch</span><span >Price in Pakistan is Rs.</span><span ></span><span >586</span><span >at Grocery App. Shop</span><span >Kausar Cooking Oil 1 Litre Pouch</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', '<p><span ></span><span >Kausar Cooking Oil 1 Litre Pouch</span><span >Online from Grocery App.</span><span >Kausar Cooking Oil 1 Litre Pouch</span><span >Price in Pakistan is Rs.</span><span ></span><span >586</span><span >at Grocery App. Shop</span><span >Kausar Cooking Oil 1 Litre Pouch</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', 'grocery', 1, 2, '2024-12-23 02:17:49', '2024-12-23 02:17:49'),
(32, 'Kausar Cooking Oil Pouch 1x5', 'Kausar-Cooking-Oil-Pouch-1x5', 8, 12, 1, 2800.00, NULL, 50, NULL, 'themes/grocery/uploads/63_1734938343_grocery App-kausar-cooking-oil-pouch-1x5-61a9d22f2d345.jpeg', 'http://localhost:8000/themes/grocery/uploads/63_1734938343_grocery App-kausar-cooking-oil-pouch-1x5-61a9d22f2d345.jpeg', '0', '<p><span ></span><span >Kausar Cooking Oil Pouch 1x5</span><span >Online from Grocery App.</span><span >Kausar Cooking Oil Pouch 1x5</span><span >Price in Pakistan is Rs.</span><span ></span><span >2853</span><span >at Grocery App. Shop</span><span >Kausar Cooking Oil Pouch 1x5</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', '<p><span ></span><span >Kausar Cooking Oil Pouch 1x5</span><span >Online from Grocery App.</span><span >Kausar Cooking Oil Pouch 1x5</span><span >Price in Pakistan is Rs.</span><span ></span><span >2853</span><span >at Grocery App. Shop</span><span >Kausar Cooking Oil Pouch 1x5</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', '<p><span ></span><span >Kausar Cooking Oil Pouch 1x5</span><span >Online from Grocery App.</span><span >Kausar Cooking Oil Pouch 1x5</span><span >Price in Pakistan is Rs.</span><span ></span><span >2853</span><span >at Grocery App. Shop</span><span >Kausar Cooking Oil Pouch 1x5</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', 'grocery', 1, 2, '2024-12-23 02:19:03', '2024-12-23 02:19:03'),
(33, 'Dilawar Cooking Oil Pouch', 'Dilawar-Cooking-Oil-Pouch', 8, 12, 1, 600.00, NULL, 50, NULL, 'themes/grocery/uploads/45_1734938396_grocery App-dilawar-cooking-oil-pouch-60c4a7e0252fc.jpeg', 'http://localhost:8000/themes/grocery/uploads/45_1734938396_grocery App-dilawar-cooking-oil-pouch-60c4a7e0252fc.jpeg', '0', '<p><span ></span><span >Dilawar Cooking Oil Pouch</span><span >Online from Grocery App.</span><span >Dilawar Cooking Oil Pouch</span><span >Price in Pakistan is Rs.</span><span ></span><span >570</span><span >at Grocery App. Shop</span><span >Dilawar Cooking Oil Pouch</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', '<p><span ></span><span >Dilawar Cooking Oil Pouch</span><span >Online from Grocery App.</span><span >Dilawar Cooking Oil Pouch</span><span >Price in Pakistan is Rs.</span><span ></span><span >570</span><span >at Grocery App. Shop</span><span >Dilawar Cooking Oil Pouch</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', '<p><span ></span><span >Dilawar Cooking Oil Pouch</span><span >Online from Grocery App.</span><span >Dilawar Cooking Oil Pouch</span><span >Price in Pakistan is Rs.</span><span ></span><span >570</span><span >at Grocery App. Shop</span><span >Dilawar Cooking Oil Pouch</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', 'grocery', 1, 2, '2024-12-23 02:19:56', '2024-12-23 02:19:56'),
(34, 'Canolive Cooking Oil 1 Litre Pouch', 'Canolive-Cooking-Oil-1-Litre-Pouch', 8, 13, 1, 600.00, NULL, 19, NULL, 'themes/grocery/uploads/90_1734938509_grocery App-canolive-cooking-oil-pouch-61a077e35dd3f.jpeg', 'http://localhost:8000/themes/grocery/uploads/90_1734938509_grocery App-canolive-cooking-oil-pouch-61a077e35dd3f.jpeg', '0', '<p><span ></span><span >Canolive Cooking Oil 1 Litre Pouch</span><span >Online from Grocery App.</span><span >Canolive Cooking Oil 1 Litre Pouch</span><span >Price in Pakistan is Rs.</span><span ></span><span >607</span><span >at Grocery App. Shop</span><span >Canolive Cooking Oil 1 Litre Pouch</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', '<p><span ></span><span >Canolive Cooking Oil 1 Litre Pouch</span><span >Online from Grocery App.</span><span >Canolive Cooking Oil 1 Litre Pouch</span><span >Price in Pakistan is Rs.</span><span ></span><span >607</span><span >at Grocery App. Shop</span><span >Canolive Cooking Oil 1 Litre Pouch</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', '<p><span ></span><span >Canolive Cooking Oil 1 Litre Pouch</span><span >Online from Grocery App.</span><span >Canolive Cooking Oil 1 Litre Pouch</span><span >Price in Pakistan is Rs.</span><span ></span><span >607</span><span >at Grocery App. Shop</span><span >Canolive Cooking Oil 1 Litre Pouch</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', 'grocery', 1, 2, '2024-12-23 02:21:49', '2024-12-25 07:57:45'),
(35, 'Himalayan Chef Canola Oil Standup Pouch', 'Himalayan-Chef-Canola-Oil-Standup-Pouch', 8, 13, 1, 1300.00, NULL, 50, NULL, 'themes/grocery/uploads/63_1734938553_grocery App-himalayan-chef-canola-oil-standup-66bb07308b9bf.jpeg', 'http://localhost:8000/themes/grocery/uploads/63_1734938553_grocery App-himalayan-chef-canola-oil-standup-66bb07308b9bf.jpeg', '0', '<p><span ></span><span >Himalayan Chef Canola Oil Standup Pouch</span><span >Online from Grocery App.</span><span >Himalayan Chef Canola Oil Standup Pouch</span><span >Price in Pakistan is Rs.</span><span ></span><span >1299</span><span >at Grocery App. Shop</span><span >Himalayan Chef Canola Oil Standup Pouch</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', '<p><span ></span><span >Himalayan Chef Canola Oil Standup Pouch</span><span >Online from Grocery App.</span><span >Himalayan Chef Canola Oil Standup Pouch</span><span >Price in Pakistan is Rs.</span><span ></span><span >1299</span><span >at Grocery App. Shop</span><span >Himalayan Chef Canola Oil Standup Pouch</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', '<p><span ></span><span >Himalayan Chef Canola Oil Standup Pouch</span><span >Online from Grocery App.</span><span >Himalayan Chef Canola Oil Standup Pouch</span><span >Price in Pakistan is Rs.</span><span ></span><span >1299</span><span >at Grocery App. Shop</span><span >Himalayan Chef Canola Oil Standup Pouch</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', 'grocery', 1, 2, '2024-12-23 02:22:33', '2024-12-23 02:22:33'),
(36, 'Dalda Kalonji Canola Oil - 1 L Bottle', 'Dalda-Kalonji-Canola-Oil---1-L-Bottle', 8, 13, 1, 700.00, NULL, 15, NULL, 'themes/grocery/uploads/82_1734938608_grocery App-dalda-kalonji-canola-oil--66668a3e833bc.jpeg', 'http://localhost:8000/themes/grocery/uploads/82_1734938608_grocery App-dalda-kalonji-canola-oil--66668a3e833bc.jpeg', '0', '<p><span ></span><span >Dalda Kalonji Canola Oil - 1 L Bottle</span><span >Online from Grocery App.</span><span >Dalda Kalonji Canola Oil - 1 L Bottle</span><span >Price in Pakistan is Rs.</span><span ></span><span >619</span><span >at Grocery App. Shop</span><span >Dalda Kalonji Canola Oil - 1 L Bottle</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', '<p><span ></span><span >Dalda Kalonji Canola Oil - 1 L Bottle</span><span >Online from Grocery App.</span><span >Dalda Kalonji Canola Oil - 1 L Bottle</span><span >Price in Pakistan is Rs.</span><span ></span><span >619</span><span >at Grocery App. Shop</span><span >Dalda Kalonji Canola Oil - 1 L Bottle</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', '<p><span ></span><span >Dalda Kalonji Canola Oil - 1 L Bottle</span><span >Online from Grocery App.</span><span >Dalda Kalonji Canola Oil - 1 L Bottle</span><span >Price in Pakistan is Rs.</span><span ></span><span >619</span><span >at Grocery App. Shop</span><span >Dalda Kalonji Canola Oil - 1 L Bottle</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', 'grocery', 1, 2, '2024-12-23 02:23:28', '2024-12-23 02:23:28'),
(37, 'DesiFit Desi Ghee', 'DesiFit-Desi-Ghee', 8, 14, 1, 2850.00, NULL, 20, NULL, 'themes/grocery/uploads/33_1734938679_grocery App-desifit-desi-ghee-672c7a02a2a4a.jpeg', 'http://localhost:8000/themes/grocery/uploads/33_1734938679_grocery App-desifit-desi-ghee-672c7a02a2a4a.jpeg', '0', '<p><span ></span><span >DesiFit Desi Ghee</span><span >Online from Grocery App.</span><span >DesiFit Desi Ghee</span><span >Price in Pakistan is Rs.</span><span ></span><span >2850</span><span >at Grocery App. Shop</span><span >DesiFit Desi Ghee</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', '<p><span ></span><span >DesiFit Desi Ghee</span><span >Online from Grocery App.</span><span >DesiFit Desi Ghee</span><span >Price in Pakistan is Rs.</span><span ></span><span >2850</span><span >at Grocery App. Shop</span><span >DesiFit Desi Ghee</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', '<p><span ></span><span >DesiFit Desi Ghee</span><span >Online from Grocery App.</span><span >DesiFit Desi Ghee</span><span >Price in Pakistan is Rs.</span><span ></span><span >2850</span><span >at Grocery App. Shop</span><span >DesiFit Desi Ghee</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', 'grocery', 1, 2, '2024-12-23 02:24:40', '2024-12-23 02:24:40'),
(38, 'Kausar Banaspati Ghee Carton (1x5)', 'Kausar-Banaspati-Ghee-Carton-(1x5)', 8, 14, 1, 3000.00, NULL, 14, NULL, 'themes/grocery/uploads/30_1734938728_grocery App-kausar-banaspati-ghee-carton-1x5-66584dcc181c2.jpeg', 'http://localhost:8000/themes/grocery/uploads/30_1734938728_grocery App-kausar-banaspati-ghee-carton-1x5-66584dcc181c2.jpeg', '0', '<p><span ></span><span >Kausar Banaspati Ghee Carton (1x5)</span><span >Online from Grocery App.</span><span >Kausar Banaspati Ghee Carton (1x5)</span><span >Price in Pakistan is Rs.</span><span ></span><span >2879</span><span >at Grocery App. Shop</span><span >Kausar Banaspati Ghee Carton (1x5)</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', '<p><span ></span><span >Kausar Banaspati Ghee Carton (1x5)</span><span >Online from Grocery App.</span><span >Kausar Banaspati Ghee Carton (1x5)</span><span >Price in Pakistan is Rs.</span><span ></span><span >2879</span><span >at Grocery App. Shop</span><span >Kausar Banaspati Ghee Carton (1x5)</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', '<p><span ></span><span >Kausar Banaspati Ghee Carton (1x5)</span><span >Online from Grocery App.</span><span >Kausar Banaspati Ghee Carton (1x5)</span><span >Price in Pakistan is Rs.</span><span ></span><span >2879</span><span >at Grocery App. Shop</span><span >Kausar Banaspati Ghee Carton (1x5)</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', 'grocery', 1, 2, '2024-12-23 02:25:28', '2024-12-23 09:54:05'),
(39, 'Gaala Desi Ghee (100% Pure)', 'Gaala-Desi-Ghee-(100%-Pure)', 8, 14, 1, 3200.00, NULL, 47, NULL, 'themes/grocery/uploads/71_1734938781_grocery App-gaala-desi-ghee-100-pure-641a9a9b3fec9.png', 'http://localhost:8000/themes/grocery/uploads/71_1734938781_grocery App-gaala-desi-ghee-100-pure-641a9a9b3fec9.png', '0', '<p><span ></span><span >Gaala Desi Ghee (100% Pure)</span><span >Online from Grocery App.</span><span >Gaala Desi Ghee (100% Pure)</span><span >Price in Pakistan is Rs.</span><span ></span><span >2999</span><span >at Grocery App. Shop</span><span >Gaala Desi Ghee (100% Pure)</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', '<p><span ></span><span >Gaala Desi Ghee (100% Pure)</span><span >Online from Grocery App.</span><span >Gaala Desi Ghee (100% Pure)</span><span >Price in Pakistan is Rs.</span><span ></span><span >2999</span><span >at Grocery App. Shop</span><span >Gaala Desi Ghee (100% Pure)</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', '<p><span ></span><span >Gaala Desi Ghee (100% Pure)</span><span >Online from Grocery App.</span><span >Gaala Desi Ghee (100% Pure)</span><span >Price in Pakistan is Rs.</span><span ></span><span >2999</span><span >at Grocery App. Shop</span><span >Gaala Desi Ghee (100% Pure)</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', 'grocery', 1, 2, '2024-12-23 02:26:21', '2024-12-23 10:06:04'),
(40, 'Tomato (ٹماٹر)', 'Tomato-(ٹماٹر)', 6, 15, 1, 309.00, NULL, 50, 1, 'themes/grocery/uploads/79_1734938923_grocery App-tomato--627e4dd24cc6a.jpeg', 'http://localhost:8000/themes/grocery/uploads/79_1734938923_grocery App-tomato--627e4dd24cc6a.jpeg', '0', '<p><span ></span><span >Tomato (ٹماٹر)</span><span >Online from Grocery App.</span><span >Tomato (ٹماٹر)</span><span >Price in Pakistan is Rs.</span><span ></span><span >309</span><span >at Grocery App. Shop</span><span >Tomato (ٹماٹر)</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', '<p><span ></span><span >Tomato (ٹماٹر)</span><span >Online from Grocery App.</span><span >Tomato (ٹماٹر)</span><span >Price in Pakistan is Rs.</span><span ></span><span >309</span><span >at Grocery App. Shop</span><span >Tomato (ٹماٹر)</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', '<p><span ></span><span >Tomato (ٹماٹر)</span><span >Online from Grocery App.</span><span >Tomato (ٹماٹر)</span><span >Price in Pakistan is Rs.</span><span ></span><span >309</span><span >at Grocery App. Shop</span><span >Tomato (ٹماٹر)</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', 'grocery', 1, 2, '2024-12-23 02:28:43', '2024-12-23 02:28:43'),
(41, 'Onion | 1 kg (Mix Size Pack)', 'Onion-|-1-kg-(Mix-Size-Pack)', 6, 15, 1, 180.00, NULL, 40, 1, 'themes/grocery/uploads/21_1734938967_grocery App-onion-65f2afe6b0b83.jpeg', 'http://localhost:8000/themes/grocery/uploads/21_1734938967_grocery App-onion-65f2afe6b0b83.jpeg', '0', '<p><span ></span><span >Onion | 1 kg (Mix Size Pack)</span><span >Online from Grocery App.</span><span >Onion | 1 kg (Mix Size Pack)</span><span >Price in Pakistan is Rs.</span><span ></span><span >188</span><span >at Grocery App. Shop</span><span >Onion | 1 kg (Mix Size Pack)</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', '<p><span ></span><span >Onion | 1 kg (Mix Size Pack)</span><span >Online from Grocery App.</span><span >Onion | 1 kg (Mix Size Pack)</span><span >Price in Pakistan is Rs.</span><span ></span><span >188</span><span >at Grocery App. Shop</span><span >Onion | 1 kg (Mix Size Pack)</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', '<p><span ></span><span >Onion | 1 kg (Mix Size Pack)</span><span >Online from Grocery App.</span><span >Onion | 1 kg (Mix Size Pack)</span><span >Price in Pakistan is Rs.</span><span ></span><span >188</span><span >at Grocery App. Shop</span><span >Onion | 1 kg (Mix Size Pack)</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', 'grocery', 1, 2, '2024-12-23 02:29:27', '2024-12-23 02:29:27'),
(42, 'Potato - نیا آلو', 'Potato---نیا-آلو', 6, 15, 1, 150.00, NULL, 99, 1, 'themes/grocery/uploads/31_1734939017_grocery App-potato--6736f00194d9a.jpeg', 'http://localhost:8000/themes/grocery/uploads/31_1734939017_grocery App-potato--6736f00194d9a.jpeg', '0', '<p><span ></span><span >Potato - نیا آلو</span><span >Online from Grocery App.</span><span >Potato - نیا آلو</span><span >Price in Pakistan is Rs.</span><span ></span><span >141</span><span >at Grocery App. Shop</span><span >Potato - نیا آلو</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', '<p><span ></span><span >Potato - نیا آلو</span><span >Online from Grocery App.</span><span >Potato - نیا آلو</span><span >Price in Pakistan is Rs.</span><span ></span><span >141</span><span >at Grocery App. Shop</span><span >Potato - نیا آلو</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', '<p><span ></span><span >Potato - نیا آلو</span><span >Online from Grocery App.</span><span >Potato - نیا آلو</span><span >Price in Pakistan is Rs.</span><span ></span><span >141</span><span >at Grocery App. Shop</span><span >Potato - نیا آلو</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', 'grocery', 1, 2, '2024-12-23 02:30:17', '2024-12-23 10:06:04');
INSERT INTO `products` (`id`, `name`, `slug`, `maincategory_id`, `subcategory_id`, `status`, `price`, `sale_price`, `product_stock`, `product_weight`, `cover_image_path`, `cover_image_url`, `stock_status`, `description`, `detail`, `specification`, `theme_id`, `store_id`, `created_by`, `created_at`, `updated_at`) VALUES
(43, 'Orange Sweet Potato', 'Orange-Sweet-Potato', 6, 17, 1, 1000.00, NULL, 50, 1, 'themes/grocery/uploads/67_1734939108_grocery App-orange-sweet-potato-6666b5bb5b665.jpeg', 'http://localhost:8000/themes/grocery/uploads/67_1734939108_grocery App-orange-sweet-potato-6666b5bb5b665.jpeg', '0', '<p><span ></span><span >Orange Sweet Potato</span><span >Online from Grocery App.</span><span >Orange Sweet Potato</span><span >Price in Pakistan is Rs.</span><span ></span><span >1000</span><span >at Grocery App. Shop</span><span >Orange Sweet Potato</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', '<p><span ></span><span >Orange Sweet Potato</span><span >Online from Grocery App.</span><span >Orange Sweet Potato</span><span >Price in Pakistan is Rs.</span><span ></span><span >1000</span><span >at Grocery App. Shop</span><span >Orange Sweet Potato</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', '<p><span ></span><span >Orange Sweet Potato</span><span >Online from Grocery App.</span><span >Orange Sweet Potato</span><span >Price in Pakistan is Rs.</span><span ></span><span >1000</span><span >at Grocery App. Shop</span><span >Orange Sweet Potato</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', 'grocery', 1, 2, '2024-12-23 02:31:48', '2024-12-23 02:31:48'),
(44, 'Baby potato - Heirloom farms', 'Baby-potato---Heirloom-farms', 6, 17, 1, 200.00, NULL, 99, 0, 'themes/grocery/uploads/71_1734939183_grocery App-baby-potato-heirloom-farms-6432e6d02c81a.png', 'http://localhost:8000/themes/grocery/uploads/71_1734939183_grocery App-baby-potato-heirloom-farms-6432e6d02c81a.png', '0', '<p><span ></span><span >Baby potato - Heirloom farms</span><span >Online from Grocery App.</span><span >Baby potato - Heirloom farms</span><span >Price in Pakistan is Rs.</span><span ></span><span >200</span><span >at Grocery App. Shop</span><span >Baby potato - Heirloom farms</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', '<p><span ></span><span >Baby potato - Heirloom farms</span><span >Online from Grocery App.</span><span >Baby potato - Heirloom farms</span><span >Price in Pakistan is Rs.</span><span ></span><span >200</span><span >at Grocery App. Shop</span><span >Baby potato - Heirloom farms</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', '<p><span ></span><span >Baby potato - Heirloom farms</span><span >Online from Grocery App.</span><span >Baby potato - Heirloom farms</span><span >Price in Pakistan is Rs.</span><span ></span><span >200</span><span >at Grocery App. Shop</span><span >Baby potato - Heirloom farms</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', 'grocery', 1, 2, '2024-12-23 02:33:03', '2024-12-23 10:06:04'),
(45, 'Baby Spinach - Heirloom farms', 'Baby-Spinach---Heirloom-farms', 6, 17, 1, 300.00, NULL, 20, NULL, 'themes/grocery/uploads/98_1734939359_grocery App-baby-spinach-heirloom-farms-6432e6f4639a0.png', 'http://localhost:8000/themes/grocery/uploads/98_1734939359_grocery App-baby-spinach-heirloom-farms-6432e6f4639a0.png', '0', '<p><span ></span><span >Baby Spinach - Heirloom farms</span><span >Online from Grocery App.</span><span >Baby Spinach - Heirloom farms</span><span >Price in Pakistan is Rs.</span><span ></span><span >300</span><span >at Grocery App. Shop</span><span >Baby Spinach - Heirloom farms</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', '<p><span ></span><span >Baby Spinach - Heirloom farms</span><span >Online from Grocery App.</span><span >Baby Spinach - Heirloom farms</span><span >Price in Pakistan is Rs.</span><span ></span><span >300</span><span >at Grocery App. Shop</span><span >Baby Spinach - Heirloom farms</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', '<p><span ></span><span >Baby Spinach - Heirloom farms</span><span >Online from Grocery App.</span><span >Baby Spinach - Heirloom farms</span><span >Price in Pakistan is Rs.</span><span ></span><span >300</span><span >at Grocery App. Shop</span><span >Baby Spinach - Heirloom farms</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', 'grocery', 1, 2, '2024-12-23 02:35:59', '2024-12-23 02:35:59'),
(46, 'Kinnow Leaf with Stalk کینو', 'Kinnow-Leaf-with-Stalk-کینو', 6, 16, 1, 250.00, NULL, 48, 250, 'themes/grocery/uploads/13_1734939501_grocery App-kinnow-leaf-with-stalk--6279f82dc965d.jpeg', 'http://localhost:8000/themes/grocery/uploads/13_1734939501_grocery App-kinnow-leaf-with-stalk--6279f82dc965d.jpeg', '0', '<p><span ></span><span >Kinnow Leaf with Stalk کینو</span><span >Online from Grocery App.</span><span >Kinnow Leaf with Stalk کینو</span><span >Price in Pakistan is Rs.</span><span ></span><span >250</span><span >at Grocery App. Shop</span><span >Kinnow Leaf with Stalk کینو</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', '<p><span ></span><span >Kinnow Leaf with Stalk کینو</span><span >Online from Grocery App.</span><span >Kinnow Leaf with Stalk کینو</span><span >Price in Pakistan is Rs.</span><span ></span><span >250</span><span >at Grocery App. Shop</span><span >Kinnow Leaf with Stalk کینو</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', '<p><span ></span><span >Kinnow Leaf with Stalk کینو</span><span >Online from Grocery App.</span><span >Kinnow Leaf with Stalk کینو</span><span >Price in Pakistan is Rs.</span><span ></span><span >250</span><span >at Grocery App. Shop</span><span >Kinnow Leaf with Stalk کینو</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', 'grocery', 1, 2, '2024-12-23 02:38:21', '2024-12-23 09:54:05'),
(47, 'Pomegranate Kandhari (انار قندھاری)', 'Pomegranate-Kandhari-(انار-قندھاری)', 6, 16, 1, 700.00, NULL, 50, 1, 'themes/grocery/uploads/20_1734939557_grocery App-pomegranate-kandhari--624aa30f7c370.jpeg', 'http://localhost:8000/themes/grocery/uploads/20_1734939557_grocery App-pomegranate-kandhari--624aa30f7c370.jpeg', '0', '<p><span ></span><span >Pomegranate Kandhari (انار قندھاری)</span><span >Online from Grocery App.</span><span >Pomegranate Kandhari (انار قندھاری)</span><span >Price in Pakistan is Rs.</span><span ></span><span >725</span><span >at Grocery App. Shop</span><span >Pomegranate Kandhari (انار قندھاری)</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', '<p><span ></span><span >Pomegranate Kandhari (انار قندھاری)</span><span >Online from Grocery App.</span><span >Pomegranate Kandhari (انار قندھاری)</span><span >Price in Pakistan is Rs.</span><span ></span><span >725</span><span >at Grocery App. Shop</span><span >Pomegranate Kandhari (انار قندھاری)</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', '<p><span ></span><span >Pomegranate Kandhari (انار قندھاری)</span><span >Online from Grocery App.</span><span >Pomegranate Kandhari (انار قندھاری)</span><span >Price in Pakistan is Rs.</span><span ></span><span >725</span><span >at Grocery App. Shop</span><span >Pomegranate Kandhari (انار قندھاری)</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', 'grocery', 1, 2, '2024-12-23 02:39:17', '2024-12-23 02:39:17'),
(48, 'Apple Kala Kulu - سیب کالا کولو', 'Apple-Kala-Kulu---سیب-کالا-کولو', 6, 16, 1, 370.00, NULL, 49, 1, 'themes/grocery/uploads/91_1734939611_grocery App-apple-kala-kulu--627d02f36e47f.jpeg', 'http://localhost:8000/themes/grocery/uploads/91_1734939611_grocery App-apple-kala-kulu--627d02f36e47f.jpeg', '0', '<p><span ></span><span >Apple Kala Kulu - سیب کالا کولو</span><span >Online from Grocery App.</span><span >Apple Kala Kulu - سیب کالا کولو</span><span >Price in Pakistan is Rs.</span><span ></span><span >370</span><span >at Grocery App. Shop</span><span >Apple Kala Kulu - سیب کالا کولو</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', '<p><span ></span><span >Apple Kala Kulu - سیب کالا کولو</span><span >Online from Grocery App.</span><span >Apple Kala Kulu - سیب کالا کولو</span><span >Price in Pakistan is Rs.</span><span ></span><span >370</span><span >at Grocery App. Shop</span><span >Apple Kala Kulu - سیب کالا کولو</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', '<p><span ></span><span >Apple Kala Kulu - سیب کالا کولو</span><span >Online from Grocery App.</span><span >Apple Kala Kulu - سیب کالا کولو</span><span >Price in Pakistan is Rs.</span><span ></span><span >370</span><span >at Grocery App. Shop</span><span >Apple Kala Kulu - سیب کالا کولو</span><span >Online & Get delivery in Lahore, Islamabad, Rawalpindi and Faisalabad.</span></p>', 'grocery', 1, 2, '2024-12-23 02:40:11', '2024-12-23 09:54:05');

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `theme_id` varchar(255) DEFAULT NULL,
  `store_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `image_path`, `image_url`, `theme_id`, `store_id`, `created_at`, `updated_at`) VALUES
(7, 1, 'themes/grocery/uploads/90_1734105561_download.jfif', 'http://localhost:8000/themes/grocery/uploads/90_1734105561_download.jfif', 'grocery', 1, '2024-12-13 10:59:21', '2024-12-13 10:59:21'),
(9, 1, 'themes/grocery/uploads/17341058411352.jfif', 'http://localhost:8000/themes/grocery/uploads/17341058411352.jfif', 'grocery', 1, '2024-12-13 11:04:01', '2024-12-13 11:04:01'),
(10, 1, 'themes/grocery/uploads/17341058416020.webp', 'http://localhost:8000/themes/grocery/uploads/17341058416020.webp', 'grocery', 1, '2024-12-13 11:04:01', '2024-12-13 11:04:01'),
(11, 1, 'themes/grocery/uploads/17341058411888.jfif', 'http://localhost:8000/themes/grocery/uploads/17341058411888.jfif', 'grocery', 1, '2024-12-13 11:04:01', '2024-12-13 11:04:01'),
(12, 4, 'themes/grocery/uploads/17349355275486.jpeg', 'http://localhost:8000/themes/grocery/uploads/17349355275486.jpeg', '1', 1, '2024-12-23 01:32:07', '2024-12-23 01:32:07'),
(13, 5, 'themes/grocery/uploads/17349357525933.png', 'http://localhost:8000/themes/grocery/uploads/17349357525933.png', '1', 1, '2024-12-23 01:35:52', '2024-12-23 01:35:52'),
(14, 6, 'themes/grocery/uploads/17349358145327.png', 'http://localhost:8000/themes/grocery/uploads/17349358145327.png', '1', 1, '2024-12-23 01:36:54', '2024-12-23 01:36:54'),
(15, 7, 'themes/grocery/uploads/17349360358445.jpeg', 'http://localhost:8000/themes/grocery/uploads/17349360358445.jpeg', '1', 1, '2024-12-23 01:40:35', '2024-12-23 01:40:35'),
(16, 7, 'themes/grocery/uploads/17349360359526.jpeg', 'http://localhost:8000/themes/grocery/uploads/17349360359526.jpeg', '1', 1, '2024-12-23 01:40:35', '2024-12-23 01:40:35'),
(17, 7, 'themes/grocery/uploads/17349360357022.jpeg', 'http://localhost:8000/themes/grocery/uploads/17349360357022.jpeg', '1', 1, '2024-12-23 01:40:35', '2024-12-23 01:40:35'),
(18, 7, 'themes/grocery/uploads/17349360357255.jpeg', 'http://localhost:8000/themes/grocery/uploads/17349360357255.jpeg', '1', 1, '2024-12-23 01:40:35', '2024-12-23 01:40:35'),
(19, 8, 'themes/grocery/uploads/17349361044425.jpeg', 'http://localhost:8000/themes/grocery/uploads/17349361044425.jpeg', '1', 1, '2024-12-23 01:41:44', '2024-12-23 01:41:44'),
(20, 9, 'themes/grocery/uploads/17349361678126.jpeg', 'http://localhost:8000/themes/grocery/uploads/17349361678126.jpeg', '1', 1, '2024-12-23 01:42:47', '2024-12-23 01:42:47'),
(21, 10, 'themes/grocery/uploads/17349362569348.jpeg', 'http://localhost:8000/themes/grocery/uploads/17349362569348.jpeg', '1', 1, '2024-12-23 01:44:16', '2024-12-23 01:44:16'),
(22, 11, 'themes/grocery/uploads/17349363825729.jpeg', 'http://localhost:8000/themes/grocery/uploads/17349363825729.jpeg', '1', 1, '2024-12-23 01:46:22', '2024-12-23 01:46:22'),
(23, 12, 'themes/grocery/uploads/17349364831969.jpeg', 'http://localhost:8000/themes/grocery/uploads/17349364831969.jpeg', '1', 1, '2024-12-23 01:48:03', '2024-12-23 01:48:03'),
(24, 13, 'themes/grocery/uploads/17349369126733.png', 'http://localhost:8000/themes/grocery/uploads/17349369126733.png', '1', 1, '2024-12-23 01:55:12', '2024-12-23 01:55:12'),
(25, 14, 'themes/grocery/uploads/17349369718889.jpeg', 'http://localhost:8000/themes/grocery/uploads/17349369718889.jpeg', '1', 1, '2024-12-23 01:56:11', '2024-12-23 01:56:11'),
(26, 15, 'themes/grocery/uploads/17349370344029.jpeg', 'http://localhost:8000/themes/grocery/uploads/17349370344029.jpeg', '1', 1, '2024-12-23 01:57:14', '2024-12-23 01:57:14'),
(27, 16, 'themes/grocery/uploads/17349371392875.png', 'http://localhost:8000/themes/grocery/uploads/17349371392875.png', '1', 1, '2024-12-23 01:58:59', '2024-12-23 01:58:59'),
(28, 17, 'themes/grocery/uploads/17349371903838.png', 'http://localhost:8000/themes/grocery/uploads/17349371903838.png', '1', 1, '2024-12-23 01:59:50', '2024-12-23 01:59:50'),
(29, 18, 'themes/grocery/uploads/17349372554572.jpeg', 'http://localhost:8000/themes/grocery/uploads/17349372554572.jpeg', '1', 1, '2024-12-23 02:00:55', '2024-12-23 02:00:55'),
(30, 19, 'themes/grocery/uploads/17349373439481.jpeg', 'http://localhost:8000/themes/grocery/uploads/17349373439481.jpeg', '1', 1, '2024-12-23 02:02:23', '2024-12-23 02:02:23'),
(31, 20, 'themes/grocery/uploads/17349374015912.png', 'http://localhost:8000/themes/grocery/uploads/17349374015912.png', '1', 1, '2024-12-23 02:03:21', '2024-12-23 02:03:21'),
(32, 21, 'themes/grocery/uploads/17349374617927.jpeg', 'http://localhost:8000/themes/grocery/uploads/17349374617927.jpeg', '1', 1, '2024-12-23 02:04:21', '2024-12-23 02:04:21'),
(33, 22, 'themes/grocery/uploads/17349375688303.jpeg', 'http://localhost:8000/themes/grocery/uploads/17349375688303.jpeg', '1', 1, '2024-12-23 02:06:08', '2024-12-23 02:06:08'),
(34, 23, 'themes/grocery/uploads/17349376486419.jpeg', 'http://localhost:8000/themes/grocery/uploads/17349376486419.jpeg', '1', 1, '2024-12-23 02:07:28', '2024-12-23 02:07:28'),
(35, 24, 'themes/grocery/uploads/17349377339360.jpeg', 'http://localhost:8000/themes/grocery/uploads/17349377339360.jpeg', '1', 1, '2024-12-23 02:08:53', '2024-12-23 02:08:53'),
(36, 25, 'themes/grocery/uploads/17349378159837.jpeg', 'http://localhost:8000/themes/grocery/uploads/17349378159837.jpeg', '1', 1, '2024-12-23 02:10:15', '2024-12-23 02:10:15'),
(37, 26, 'themes/grocery/uploads/17349378751868.jpeg', 'http://localhost:8000/themes/grocery/uploads/17349378751868.jpeg', '1', 1, '2024-12-23 02:11:15', '2024-12-23 02:11:15'),
(38, 27, 'themes/grocery/uploads/17349379318287.jpeg', 'http://localhost:8000/themes/grocery/uploads/17349379318287.jpeg', '1', 1, '2024-12-23 02:12:11', '2024-12-23 02:12:11'),
(39, 28, 'themes/grocery/uploads/17349380174330.jpeg', 'http://localhost:8000/themes/grocery/uploads/17349380174330.jpeg', '1', 1, '2024-12-23 02:13:37', '2024-12-23 02:13:37'),
(40, 29, 'themes/grocery/uploads/17349380906163.jpeg', 'http://localhost:8000/themes/grocery/uploads/17349380906163.jpeg', '1', 1, '2024-12-23 02:14:50', '2024-12-23 02:14:50'),
(41, 30, 'themes/grocery/uploads/17349381685648.jpeg', 'http://localhost:8000/themes/grocery/uploads/17349381685648.jpeg', '1', 1, '2024-12-23 02:16:08', '2024-12-23 02:16:08'),
(42, 31, 'themes/grocery/uploads/17349382691626.jpeg', 'http://localhost:8000/themes/grocery/uploads/17349382691626.jpeg', '1', 1, '2024-12-23 02:17:49', '2024-12-23 02:17:49'),
(43, 32, 'themes/grocery/uploads/17349383439911.jpeg', 'http://localhost:8000/themes/grocery/uploads/17349383439911.jpeg', '1', 1, '2024-12-23 02:19:03', '2024-12-23 02:19:03'),
(44, 33, 'themes/grocery/uploads/17349383967678.jpeg', 'http://localhost:8000/themes/grocery/uploads/17349383967678.jpeg', '1', 1, '2024-12-23 02:19:56', '2024-12-23 02:19:56'),
(45, 34, 'themes/grocery/uploads/17349385096052.jpeg', 'http://localhost:8000/themes/grocery/uploads/17349385096052.jpeg', '1', 1, '2024-12-23 02:21:49', '2024-12-23 02:21:49'),
(46, 35, 'themes/grocery/uploads/17349385539396.jpeg', 'http://localhost:8000/themes/grocery/uploads/17349385539396.jpeg', '1', 1, '2024-12-23 02:22:33', '2024-12-23 02:22:33'),
(47, 36, 'themes/grocery/uploads/17349386086895.jpeg', 'http://localhost:8000/themes/grocery/uploads/17349386086895.jpeg', '1', 1, '2024-12-23 02:23:28', '2024-12-23 02:23:28'),
(48, 37, 'themes/grocery/uploads/17349386807721.jpeg', 'http://localhost:8000/themes/grocery/uploads/17349386807721.jpeg', '1', 1, '2024-12-23 02:24:40', '2024-12-23 02:24:40'),
(49, 38, 'themes/grocery/uploads/17349387289819.jpeg', 'http://localhost:8000/themes/grocery/uploads/17349387289819.jpeg', '1', 1, '2024-12-23 02:25:28', '2024-12-23 02:25:28'),
(50, 39, 'themes/grocery/uploads/17349387812353.png', 'http://localhost:8000/themes/grocery/uploads/17349387812353.png', '1', 1, '2024-12-23 02:26:21', '2024-12-23 02:26:21'),
(51, 40, 'themes/grocery/uploads/17349389239090.jpeg', 'http://localhost:8000/themes/grocery/uploads/17349389239090.jpeg', '1', 1, '2024-12-23 02:28:43', '2024-12-23 02:28:43'),
(52, 41, 'themes/grocery/uploads/17349389679208.jpeg', 'http://localhost:8000/themes/grocery/uploads/17349389679208.jpeg', '1', 1, '2024-12-23 02:29:27', '2024-12-23 02:29:27'),
(53, 42, 'themes/grocery/uploads/17349390172469.jpeg', 'http://localhost:8000/themes/grocery/uploads/17349390172469.jpeg', '1', 1, '2024-12-23 02:30:17', '2024-12-23 02:30:17'),
(54, 43, 'themes/grocery/uploads/17349391086562.jpeg', 'http://localhost:8000/themes/grocery/uploads/17349391086562.jpeg', '1', 1, '2024-12-23 02:31:48', '2024-12-23 02:31:48'),
(55, 44, 'themes/grocery/uploads/17349391831994.png', 'http://localhost:8000/themes/grocery/uploads/17349391831994.png', '1', 1, '2024-12-23 02:33:03', '2024-12-23 02:33:03'),
(56, 45, 'themes/grocery/uploads/17349393594298.png', 'http://localhost:8000/themes/grocery/uploads/17349393594298.png', '1', 1, '2024-12-23 02:35:59', '2024-12-23 02:35:59'),
(57, 46, 'themes/grocery/uploads/17349395016411.jpeg', 'http://localhost:8000/themes/grocery/uploads/17349395016411.jpeg', '1', 1, '2024-12-23 02:38:22', '2024-12-23 02:38:22'),
(58, 47, 'themes/grocery/uploads/17349395575372.jpeg', 'http://localhost:8000/themes/grocery/uploads/17349395575372.jpeg', '1', 1, '2024-12-23 02:39:17', '2024-12-23 02:39:17'),
(59, 48, 'themes/grocery/uploads/17349396114012.jpeg', 'http://localhost:8000/themes/grocery/uploads/17349396114012.jpeg', '1', 1, '2024-12-23 02:40:11', '2024-12-23 02:40:11');

-- --------------------------------------------------------

--
-- Table structure for table `purchased_products`
--

CREATE TABLE `purchased_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `product_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `order_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `theme_id` varchar(255) DEFAULT NULL,
  `store_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchased_products`
--

INSERT INTO `purchased_products` (`id`, `customer_id`, `product_id`, `order_id`, `theme_id`, `store_id`, `created_at`, `updated_at`) VALUES
(5, 0, 1, 12, 'grocery', 1, '2024-12-14 06:35:50', '2024-12-14 06:35:50'),
(6, 0, 1, 13, 'grocery', 1, '2024-12-14 06:42:12', '2024-12-14 06:42:12'),
(7, 0, 1, 14, 'grocery', 1, '2024-12-14 06:51:30', '2024-12-14 06:51:30'),
(8, 2, 1, 15, 'grocery', 1, '2024-12-14 08:29:49', '2024-12-14 08:29:49');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `user_id`, `name`, `value`, `created_at`, `updated_at`) VALUES
(1, NULL, 'title_text', 'grocery store', '2024-12-18 02:55:29', '2024-12-18 02:55:29'),
(2, NULL, 'footer_text', 'grocery store', '2024-12-18 02:55:29', '2024-12-18 02:55:29'),
(3, NULL, 'logo_dark', '/storage/uploads/logo/logo_darkpng', '2024-12-18 02:56:30', '2024-12-18 02:56:30'),
(4, NULL, 'color', 'theme-6', '2024-12-18 03:01:56', '2024-12-18 03:01:56');

-- --------------------------------------------------------

--
-- Table structure for table `store_expense`
--

CREATE TABLE `store_expense` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `account` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `amount` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `store_expense`
--

INSERT INTO `store_expense` (`id`, `account`, `description`, `amount`, `created_at`, `updated_at`) VALUES
(1, 'purchase', 'samsung a30 is purchased 50 peace', 500000, '2024-12-25 07:08:17', '2024-12-25 07:08:17'),
(2, 'purchase', 'purchase return', 1000, '2024-12-25 07:20:10', '2024-12-25 07:20:10'),
(3, 'purchase', 'purchase return', -1000, '2024-12-25 07:20:31', '2024-12-25 07:20:31'),
(4, 'Store Expense', 'Store Maintenance Expense', 32000, '2024-12-25 07:21:07', '2024-12-25 07:21:07');

-- --------------------------------------------------------

--
-- Table structure for table `sub_categories`
--

CREATE TABLE `sub_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `icon_path` varchar(255) DEFAULT NULL,
  `maincategory_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '0 => Inactive, 1 => Active',
  `theme_id` varchar(255) DEFAULT NULL,
  `store_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sub_categories`
--

INSERT INTO `sub_categories` (`id`, `name`, `image_url`, `image_path`, `icon_path`, `maincategory_id`, `status`, `theme_id`, `store_id`, `created_at`, `updated_at`) VALUES
(3, 'Eggs', 'http://localhost:8000/themes/grocery/uploads/80_1734620772_grocery App-eggs-61e95ac1ae97f.jpeg', 'themes/grocery/uploads/80_1734620772_grocery App-eggs-61e95ac1ae97f.jpeg', 'themes/grocery/uploads/51_1734620772_grocery App-eggs-61e95ac1ae97f.jpeg', 4, 1, 'grocery', 1, '2024-12-19 10:06:12', '2024-12-19 10:06:12'),
(4, 'Bread & Crumbs', 'http://localhost:8000/themes/grocery/uploads/81_1734620884_grocery App-bread-crumbs-64dcc5819296b.jpeg', 'themes/grocery/uploads/81_1734620884_grocery App-bread-crumbs-64dcc5819296b.jpeg', 'themes/grocery/uploads/81_1734620884_grocery App-bread-crumbs-64dcc5819296b.jpeg', 4, 1, 'grocery', 1, '2024-12-19 10:08:04', '2024-12-19 10:08:04'),
(5, 'Honey', 'http://localhost:8000/themes/grocery/uploads/93_1734620920_grocery App-honey-64dcc72aabb32.jpeg', 'themes/grocery/uploads/93_1734620920_grocery App-honey-64dcc72aabb32.jpeg', 'themes/grocery/uploads/97_1734620920_grocery App-honey-64dcc72aabb32.jpeg', 4, 1, 'grocery', 1, '2024-12-19 10:08:40', '2024-12-19 10:08:40'),
(6, 'Raw & Fresh Milk', 'http://localhost:8000/themes/grocery/uploads/96_1734622157_grocery App-raw-fresh-milk-64dca9154de75.jpeg', 'themes/grocery/uploads/96_1734622157_grocery App-raw-fresh-milk-64dca9154de75.jpeg', 'themes/grocery/uploads/51_1734622157_grocery App-raw-fresh-milk-64dca9154de75.jpeg', 5, 1, 'grocery', 1, '2024-12-19 10:29:17', '2024-12-19 10:29:17'),
(7, 'UHT Milk', 'http://localhost:8000/themes/grocery/uploads/86_1734622187_grocery App-uht-milk-66a9ff2168a65.jpeg', 'themes/grocery/uploads/86_1734622187_grocery App-uht-milk-66a9ff2168a65.jpeg', 'themes/grocery/uploads/28_1734622187_grocery App-uht-milk-66a9ff2168a65.jpeg', 5, 1, 'grocery', 1, '2024-12-19 10:29:47', '2024-12-19 10:29:47'),
(8, 'Powdered Milk', 'http://localhost:8000/themes/grocery/uploads/49_1734622250_grocery App-powdered-milk-671371a902357.jpeg', 'themes/grocery/uploads/49_1734622250_grocery App-powdered-milk-671371a902357.jpeg', 'themes/grocery/uploads/17_1734622251_grocery App-powdered-milk-671371a902357.jpeg', 5, 1, 'grocery', 1, '2024-12-19 10:30:51', '2024-12-19 10:30:51'),
(9, 'Chicken', 'http://localhost:8000/themes/grocery/uploads/34_1734623205_grocery App-chicken-61e92dd43796d.jpeg', 'themes/grocery/uploads/34_1734623205_grocery App-chicken-61e92dd43796d.jpeg', 'themes/grocery/uploads/37_1734623206_grocery App-chicken-61e92dd43796d.jpeg', 7, 1, 'grocery', 1, '2024-12-19 10:46:46', '2024-12-19 10:46:46'),
(10, 'Fish & Sea Food', 'http://localhost:8000/themes/grocery/uploads/32_1734623231_grocery App-boneless-fish-61e944f72fd17.jpeg', 'themes/grocery/uploads/32_1734623231_grocery App-boneless-fish-61e944f72fd17.jpeg', 'themes/grocery/uploads/73_1734623231_grocery App-boneless-fish-61e944f72fd17.jpeg', 7, 1, 'grocery', 1, '2024-12-19 10:47:11', '2024-12-19 10:47:11'),
(11, 'Mutton', 'http://localhost:8000/themes/grocery/uploads/59_1734623255_grocery App-mutton-61e92dff00785.jpeg', 'themes/grocery/uploads/59_1734623255_grocery App-mutton-61e92dff00785.jpeg', 'themes/grocery/uploads/90_1734623255_grocery App-mutton-61e92dff00785.jpeg', 7, 1, 'grocery', 1, '2024-12-19 10:47:35', '2024-12-19 10:47:35'),
(12, 'Cooking Oil', 'http://localhost:8000/themes/grocery/uploads/60_1734623375_grocery App-cooking-oil-670f653d0af21.jpeg', 'themes/grocery/uploads/60_1734623375_grocery App-cooking-oil-670f653d0af21.jpeg', 'themes/grocery/uploads/60_1734623375_grocery App-cooking-oil-670f653d0af21.jpeg', 8, 1, 'grocery', 1, '2024-12-19 10:49:35', '2024-12-19 10:49:35'),
(13, 'Canola Oil', 'http://localhost:8000/themes/grocery/uploads/93_1734623416_grocery App-canola-oil-670f6522260ba.jpeg', 'themes/grocery/uploads/93_1734623416_grocery App-canola-oil-670f6522260ba.jpeg', 'themes/grocery/uploads/90_1734623416_grocery App-canola-oil-670f6522260ba.jpeg', 8, 1, 'grocery', 1, '2024-12-19 10:50:16', '2024-12-19 10:50:16'),
(14, 'Banaspati Ghee', 'http://localhost:8000/themes/grocery/uploads/17_1734623604_grocery App-desi-banaspati-ghee-6710aadbd102c.jpeg', 'themes/grocery/uploads/17_1734623604_grocery App-desi-banaspati-ghee-6710aadbd102c.jpeg', 'themes/grocery/uploads/48_1734623604_grocery App-desi-banaspati-ghee-6710aadbd102c.jpeg', 8, 1, 'grocery', 1, '2024-12-19 10:53:24', '2024-12-19 10:53:24'),
(15, 'Vegetables', 'http://localhost:8000/themes/grocery/uploads/66_1734934936_grocery App-vegetables-61e92cb8bb657.jpeg', 'themes/grocery/uploads/66_1734934936_grocery App-vegetables-61e92cb8bb657.jpeg', 'themes/grocery/uploads/95_1734934936_grocery App-vegetables-61e92cb8bb657.jpeg', 6, 1, 'grocery', 1, '2024-12-23 01:22:16', '2024-12-23 01:22:16'),
(16, 'Fruits', 'http://localhost:8000/themes/grocery/uploads/51_1734934984_grocery App-fruits-61e92d02735bb.jpeg', 'themes/grocery/uploads/51_1734934984_grocery App-fruits-61e92d02735bb.jpeg', 'themes/grocery/uploads/77_1734934984_grocery App-fruits-61e92d02735bb.jpeg', 6, 1, 'grocery', 1, '2024-12-23 01:23:04', '2024-12-23 02:37:36'),
(17, 'Exotic Herbs & Veg', 'http://localhost:8000/themes/grocery/uploads/57_1734935059_grocery App-english-vegetables-herbs-643000b7d59a8.png', 'themes/grocery/uploads/57_1734935059_grocery App-english-vegetables-herbs-643000b7d59a8.png', 'themes/grocery/uploads/69_1734935059_grocery App-english-vegetables-herbs-643000b7d59a8.png', 6, 1, 'grocery', 1, '2024-12-23 01:24:19', '2024-12-23 01:24:19');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `is_enable_login` tinyint(1) NOT NULL DEFAULT 1,
  `name` varchar(255) NOT NULL,
  `role` int(11) NOT NULL DEFAULT 3 COMMENT '1 for admin 2 for employee 3 for customers',
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

INSERT INTO `users` (`id`, `is_enable_login`, `name`, `role`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(2, 1, 'umer', 1, 'superadmin@gmail.com', NULL, '$2y$12$GMxQdxSYrVFP4lTAFqvoiegZOwHMk6aqmJt5qO1r2aEc6.r3zmwa2', NULL, '2024-12-03 08:30:34', '2024-12-03 08:30:34'),
(3, 1, 'employee', 2, 'employee@gmail.com', '2024-12-25 04:52:52', '$2y$12$B4.57GYpOOlGkYveSyprKeiUp1Eqnn..mtCDb2tCD7JKYd1bT9JVG', NULL, '2024-12-25 04:52:52', '2024-12-25 05:08:04'),
(5, 1, 'customer1', 3, 'customer1@gmail.com', '2024-12-25 06:07:48', '$2y$12$E1TcdF5QcsINsS.eOqIBhubfwVZTB9bv2bvQVMbNnRwGsFrDJz07e', NULL, '2024-12-25 06:07:48', '2024-12-25 06:07:48'),
(6, 1, 'Phyllis Tran', 2, 'mepoxi@mailinator.com', '2024-12-25 06:09:59', '$2y$12$Y0xe2winyDMDWkqm411qveKuoXX/p6WL9YTH.LL7PSXAPeonfOgP.', NULL, '2024-12-25 06:09:59', '2024-12-25 06:09:59'),
(7, 1, 'April Lambert', 3, 'bajakatu@mailinator.com', '2024-12-25 07:57:45', '$2y$12$Ceo2RKCwPgLDX3yRXt2UNuxdsOG4pArgkrVikF2.I1FUWxqYgVim.', NULL, '2024-12-25 07:57:45', '2024-12-25 07:57:45');

-- --------------------------------------------------------

--
-- Table structure for table `user_coupons`
--

CREATE TABLE `user_coupons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `coupon_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `amount` double(8,2) NOT NULL DEFAULT 0.00,
  `order_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `date_used` datetime DEFAULT NULL,
  `theme_id` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `main_categories`
--
ALTER TABLE `main_categories`
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
-- Indexes for table `order_coupon_details`
--
ALTER TABLE `order_coupon_details`
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
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);
  -- ADD KEY `products_maincategory_id_for/eign` (`maincategory_id`),
  -- ADD KEY `products_subcategory_id_fore/ign` (`subcategory_id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchased_products`
--
ALTER TABLE `purchased_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `store_expense`
--
ALTER TABLE `store_expense`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD PRIMARY KEY (`id`);
  -- ADD KEY `sub_categories_maincategory_id_foreign` (`maincategory_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_coupons`
--
ALTER TABLE `user_coupons`
  ADD PRIMARY KEY (`id`);
  -- ADD KEY `user_coupons_user_id_foreign` (`user_id`),
  -- ADD KEY `user_coupons_coupon_id_foreign` (`coupon_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `main_categories`
--
ALTER TABLE `main_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `order_coupon_details`
--
ALTER TABLE `order_coupon_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `purchased_products`
--
ALTER TABLE `purchased_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `store_expense`
--
ALTER TABLE `store_expense`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `sub_categories`
--
ALTER TABLE `sub_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user_coupons`
--
ALTER TABLE `user_coupons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `products`
--
-- ALTER TABLE `products`
  -- ADD CONSTRAINT `products_maincategory_id_foreign` FOREIGN KEY (`maincategory_id`) REFERENCES `main_categories` (`id`) ON DELETE CASCADE,
  -- ADD CONSTRAINT `products_subcategory_id_foreign` FOREIGN KEY (`subcategory_id`) REFERENCES `sub_categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sub_categories`
--
-- ALTER TABLE `sub_categories`
  -- ADD CONSTRAINT `sub_categories_maincategory_id_foreign` FOREIGN KEY (`maincategory_id`) REFERENCES `main_categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_coupons`
--
-- ALTER TABLE `user_coupons`
  -- ADD CONSTRAINT `user_coupons_coupon_id_foreign` FOREIGN KEY (`coupon_id`) REFERENCES `coupons` (`id`) ON DELETE CASCADE,
  -- ADD CONSTRAINT `user_coupons_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

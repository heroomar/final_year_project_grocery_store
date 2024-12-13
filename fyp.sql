-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 13, 2024 at 10:04 PM
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

INSERT INTO `customers` (`id`, `first_name`, `last_name`, `email`, `profile_image`, `type`, `email_verified_at`, `mobile`, `regiester_date`, `status`, `date_of_birth`, `created_by`, `theme_id`, `store_id`, `remember_token`, `created_at`, `updated_at`) VALUES
(2, 'Alana edited', 'Berk', 'Belle', '', 'cutsomer', NULL, 'Buckminster', '2024-12-13', 0, '2007-11-29', 2, 'grocery', 1, NULL, '2024-12-13 14:06:05', '2024-12-13 14:23:35');

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
(1, 'cat1', 'collections/cat1', 'http://localhost:8000/themes/grocery/uploads/80_1733298250_Capture.PNG', 'themes/grocery/uploads/80_1733298250_Capture.PNG', '/storage/uploads/default.jpg', 0, 0, 'grocery', 1, '2024-12-04 02:14:34', '2024-12-04 02:44:10'),
(2, 'f1111', 'collections/f1111', 'http://localhost:8000/themes/grocery/uploads/98_1733298147_Capture.PNG', 'themes/grocery/uploads/98_1733298147_Capture.PNG', '/storage/uploads/default.jpg', 0, 0, 'grocery', 1, '2024-12-04 02:42:27', '2024-12-11 09:43:57');

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
(14, '2023_12_29_100550_create_user_coupons_table', 8);

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
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `product_order_id`, `order_date`, `customer_id`, `is_guest`, `product_json`, `product_id`, `product_price`, `coupon_price`, `delivery_price`, `tax_price`, `final_price`, `return_price`, `payment_comment`, `payment_type`, `payment_status`, `delivered_status`, `delivery_date`, `confirmed_date`, `return_status`, `return_date`, `cancel_date`, `additional_note`, `theme_id`, `store_id`, `created_at`, `updated_at`) VALUES
(1, '1734123680', '2024-12-13 21:03:22', 0, 0, '{\"1\":{\"product_id\":1,\"name\":\"Acton Clay\",\"image\":\"themes\\/grocery\\/uploads\\/52_1734099856_extremerainfallandfloodmonitoringsystemforpakistan.jpg\",\"quantity\":1,\"orignal_price\":1000,\"per_product_discount_price\":null,\"discount_price\":null,\"final_price\":1000,\"id\":\"1\",\"tax\":0,\"total_orignal_price\":1000,\"originalquantity\":100,\"variant_id\":0,\"variant_name\":null,\"return\":0}}', '1', 0.10, 0.00, 0.00, 0.00, 0.10, 0.00, NULL, 'POS', 'Paid', 0, NULL, NULL, 0, NULL, NULL, NULL, 'grocery', 1, '2024-12-13 16:03:22', '2024-12-13 16:03:22');

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
  `sale_price` double(8,2) NOT NULL DEFAULT 0.00,
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
(1, 'Acton Clay', 'Acton-Clay', 1, 1, 1, 1000.00, 200.00, 99, 888, 'themes/grocery/uploads/52_1734099856_extremerainfallandfloodmonitoringsystemforpakistan.jpg', 'http://localhost:8000/themes/grocery/uploads/52_1734099856_extremerainfallandfloodmonitoringsystemforpakistan.jpg', '0', '<p>sadasd</p>', '<p>ugguyguyguyguyguyguyg</p>', '<p>guyuyygug</p>', 'grocery', 1, 2, '2024-12-13 09:24:16', '2024-12-13 16:03:22');

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
(11, 1, 'themes/grocery/uploads/17341058411888.jfif', 'http://localhost:8000/themes/grocery/uploads/17341058411888.jfif', 'grocery', 1, '2024-12-13 11:04:01', '2024-12-13 11:04:01');

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
(1, 'sub cat', 'http://localhost:8000/themes/grocery/uploads/76_1733929039_deposit-receipt_x.png', 'themes/grocery/uploads/76_1733929039_deposit-receipt_x.png', '/storage/uploads/default.jpg', 1, 1, 'grocery', 1, '2024-12-11 09:57:19', '2024-12-11 09:57:19');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
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

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Daniel Daniels', 'cohutegic@mailinator.com', NULL, '$2y$12$Y9rvOUsoI3Lv71C2ksQG/e7CzjTkN7IYdvYO0YdEv0RkBW7p6MfCO', NULL, '2024-11-27 08:12:20', '2024-11-27 08:12:20'),
(2, 'umer', 'superadmin@gmail.com', NULL, '$2y$12$GMxQdxSYrVFP4lTAFqvoiegZOwHMk6aqmJt5qO1r2aEc6.r3zmwa2', NULL, '2024-12-03 08:30:34', '2024-12-03 08:30:34');

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
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_maincategory_id_foreign` (`maincategory_id`),
  ADD KEY `products_subcategory_id_foreign` (`subcategory_id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sub_categories_maincategory_id_foreign` (`maincategory_id`);

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
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_coupons_user_id_foreign` (`user_id`),
  ADD KEY `user_coupons_coupon_id_foreign` (`coupon_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `main_categories`
--
ALTER TABLE `main_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `sub_categories`
--
ALTER TABLE `sub_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
ALTER TABLE `products`
  ADD CONSTRAINT `products_maincategory_id_foreign` FOREIGN KEY (`maincategory_id`) REFERENCES `main_categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_subcategory_id_foreign` FOREIGN KEY (`subcategory_id`) REFERENCES `sub_categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD CONSTRAINT `sub_categories_maincategory_id_foreign` FOREIGN KEY (`maincategory_id`) REFERENCES `main_categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_coupons`
--
ALTER TABLE `user_coupons`
  ADD CONSTRAINT `user_coupons_coupon_id_foreign` FOREIGN KEY (`coupon_id`) REFERENCES `coupons` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_coupons_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

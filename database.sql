-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 29, 2021 at 07:07 PM
-- Server version: 8.0.19
-- PHP Version: 7.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `yii_product`
--

-- --------------------------------------------------------

--
-- Table structure for table `migration`
--

CREATE TABLE `migration` (
  `version` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `apply_time` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1627555961),
('m210715_051418_create_users_table', 1627572103),
('m210729_104103_create_products_table', 1627555962),
('m210729_105159_create_fake_data', 1627557112);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sku` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `product_type` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `image`, `sku`, `title`, `product_type`) VALUES
(1, '1.jpg', 'O8ru6MO6kt3C3S78VkukKqxOaJbeSYvr', 'Absalom, Absalom!', 3),
(2, '2.jpg', 'e8HmtoWOTncuOdYQ91GvsVLaj305kBB5', 'After Many a Summer Dies the Swan', 3),
(3, '3.jpg', 'jeuJuxp7iBG0dslh7bHobXEqV8sJArcb', 'Ah, Wilderness!', 1),
(4, '4.jpg', '26ss7cl3f42hUQqSu6895MSlSASETFOb', 'Alien Corn (play)!', 1),
(5, '5.jpg', 'tlUC2AtPvaT6wjG_ndGuigR1c1T2z_-Q', 'All Passion Spent', 2),
(6, '6.jpg', 'elG_d7wvc8FXccAwwRELLv_8FM8aESOD', 'All the King\'s Men', 3),
(7, '7.jpg', 'NJPBQupWnIkM3eOhLBdDUBujd6UgpO8i', 'Alone on a Wide, Wide Sea', 1),
(8, '8.jpg', '-zY_GiFJ2hcAnQ9CF0zMnCE2P9IsBejc', 'An Acceptable Time', 1),
(9, '9.jpg', '8xWYy2xhf1giOmcnABpCVH3Xl7QD7QAl', 'Antic Hay', 1),
(10, '10.jpg', 'PJBHL2zgcpHWcu_bkx7RH868RETqmT3z', 'Arms and the Man', 1),
(11, '11.jpg', '2J0LTeFr0xdlHMGb-R9Gk0O5b7zjtevf', 'As I Lay Dying', 1),
(12, '12.jpg', 'PeCKitBtt8EmQRZpTld4m5MnwYbsOiOe', 'Behold the Man', 2),
(13, '13.jpg', 'C7-2VijUI6C1YSfTYh5GyeV_wo-lWwfu', 'Beneath the Bleeding', 2),
(14, '14.jpg', 'rvFUuqVS4XLwbxF8EPd3PTpBVLOQ1rmV', 'Beyond the Mexique Bay', 1),
(15, '15.jpg', 'YIiVl1_ohHwFu9WZUh1GIvOekXFZRIjn', 'Blithe Spirit', 2),
(16, '16.jpg', 'on1nKtY7a4LrlezimjJXl2hO7N7ifcMM', 'Blood\'s a Rover', 2),
(17, '17.jpg', 'yOVySWM7FuAgkkDUsVNhm5ljBLPhwEcW', 'Blue Remembered Earth', 1),
(18, '18.jpg', 'x7DfDg_aSsHtew8KoXPbvhwyAgZ26f3Y', 'Bonjour Tristesse', 3),
(19, '19.jpg', 'YDPtrjtS-OMUsqEg-TnCvqrxK29xpOYF', 'Bury My Heart at Wounded Knee', 3),
(20, '20.jpg', 'T3uzMj5lX8yTZuEdFAQgNGEY3QBqCzEk', 'Butter In a Lordly Dish', 1);

-- --------------------------------------------------------

--
-- Table structure for table `product_types`
--

CREATE TABLE `product_types` (
  `id` int NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `product_types`
--

INSERT INTO `product_types` (`id`, `title`) VALUES
(1, 'Local books'),
(2, 'Internatinal books'),
(3, 'Translated books');

-- --------------------------------------------------------

--
-- Table structure for table `product_warehouse`
--

CREATE TABLE `product_warehouse` (
  `id` int NOT NULL,
  `product_id` int DEFAULT NULL,
  `quantity` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `product_warehouse`
--

INSERT INTO `product_warehouse` (`id`, `product_id`, `quantity`) VALUES
(1, 1, 69),
(2, 2, 75),
(3, 3, 71),
(4, 4, 41),
(5, 5, 52),
(6, 6, 29),
(7, 7, 11),
(8, 8, 32),
(9, 9, 44),
(10, 10, 31),
(11, 11, 53),
(12, 12, 31),
(13, 13, 78),
(14, 14, 53),
(15, 15, 97),
(16, 16, 48),
(17, 17, 38),
(18, 18, 14),
(19, 19, 96),
(20, 20, 15);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fullname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `auth_key` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` smallint DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `fullname`, `auth_key`, `status`) VALUES
(1, 'alfra', '$2y$13$nfs0hGt1K1XexlUMAXuWSuNuFo/kKHUq3vfqsuL2usWUOUqHBAgtq', 'Gulomjon', NULL, 10);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk-product_warehouse-product_type` (`product_type`);

--
-- Indexes for table `product_types`
--
ALTER TABLE `product_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_warehouse`
--
ALTER TABLE `product_warehouse`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk-product_warehouse-product_id` (`product_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `product_types`
--
ALTER TABLE `product_types`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `product_warehouse`
--
ALTER TABLE `product_warehouse`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk-product_warehouse-product_type` FOREIGN KEY (`product_type`) REFERENCES `product_types` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_warehouse`
--
ALTER TABLE `product_warehouse`
  ADD CONSTRAINT `fk-product_warehouse-product_id` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

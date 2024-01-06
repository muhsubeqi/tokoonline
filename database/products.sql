-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 12, 2023 at 07:41 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tokoonline2`
--

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stock` int(11) NOT NULL,
  `weight` int(11) DEFAULT NULL,
  `price` int(11) NOT NULL,
  `categories_id` bigint(20) UNSIGNED DEFAULT NULL,
  `users_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `photo`, `name`, `slug`, `description`, `stock`, `weight`, `price`, `categories_id`, `users_id`, `created_at`, `updated_at`) VALUES
(1, 'Photo20231012122346652782e2e38ac.png', 'Kaos Bung Karno Candi Sepeda', 'kaos-bung-karno-candi-sepeda', 'isi deskripsi', 10, 180, 99000, 2, 1, '2023-10-12 05:23:46', '2023-10-12 05:23:46'),
(2, 'Photo20231012122739652783cba1f23.png', 'Kaos Bung Karno Tinta Hitam', 'kaos-bung-karno-tinta-hitam', 'isi deskripsi', 10, 180, 99000, 2, 1, '2023-10-12 05:27:39', '2023-10-12 05:27:39'),
(3, 'Photo20231012123032652784781cceb.png', 'Kaos Blitar in Histori', 'kaos-blitar-in-histori', '<p><img alt=\"\" src=\"http://127.0.0.1:8000/storage/files/1/Untitled.png\" style=\"height:486px; width:488px\" /></p>\r\n\r\n<p>size : S , M , L , XL , XXL , XXXL<br />\r\ncloth : cotton combed 24s / 30s<br />\r\ncost : Rp 99.000.00,-<br />\r\n<br />\r\n𝐚𝐝𝐦𝐢𝐧<br />\r\nWhats', 10, 180, 99000, 2, 1, '2023-10-12 05:30:32', '2023-10-12 05:30:32'),
(4, 'Photo20231012123149652784c5990ce.png', 'Kaos Garuda Merah Putih', 'kaos-garuda-merah-putih', '<p><img alt=\"\" src=\"http://127.0.0.1:8000/storage/files/1/Untitled.png\" style=\"height:486px; width:488px\" /></p>\r\n\r\n<p>size : S , M , L , XL , XXL , XXXL<br />\r\ncloth : cotton combed 24s / 30s<br />\r\ncost : Rp 99.000.00,-<br />\r\n<br />\r\n𝐚𝐝𝐦𝐢𝐧<br />\r\nWhats', 10, 180, 99000, 2, 1, '2023-10-12 05:31:49', '2023-10-12 05:31:49'),
(5, 'Photo20231012123253652785059b5b6.png', 'Kaos Bung Karno Payung', 'kaos-bung-karno-payung', '<p><img alt=\"\" src=\"http://127.0.0.1:8000/storage/files/1/Untitled.png\" style=\"height:486px; width:488px\" /></p>\r\n\r\n<p>size : S , M , L , XL , XXL , XXXL<br />\r\ncloth : cotton combed 24s / 30s<br />\r\ncost : Rp 99.000.00,-<br />\r\n<br />\r\n𝐚𝐝𝐦𝐢𝐧<br />\r\nWhats', 10, 180, 99000, 2, 1, '2023-10-12 05:32:53', '2023-10-12 05:32:53'),
(6, 'Photo2023101212340865278550d3819.png', 'Kaos Bung Garuda Gold', 'kaos-bung-garuda-gold', '<p><img alt=\"\" src=\"http://127.0.0.1:8000/storage/files/1/Untitled.png\" style=\"height:486px; width:488px\" /></p>\r\n\r\n<p>size : S , M , L , XL , XXL , XXXL<br />\r\ncloth : cotton combed 24s / 30s<br />\r\ncost : Rp 99.000.00,-<br />\r\n<br />\r\n𝐚𝐝𝐦𝐢𝐧<br />\r\nWhats', 10, 180, 99000, 2, 1, '2023-10-12 05:34:08', '2023-10-12 05:34:08'),
(7, 'Photo2023101212352065278598100cb.png', 'Kaos Bung Pahlawan Peta', 'kaos-bung-pahlawan-peta', '<p><img alt=\"\" src=\"http://127.0.0.1:8000/storage/files/1/Untitled.png\" style=\"height:486px; width:488px\" /></p>\r\n\r\n<p>size : S , M , L , XL , XXL , XXXL<br />\r\ncloth : cotton combed 24s / 30s<br />\r\ncost : Rp 99.000.00,-<br />\r\n<br />\r\n𝐚𝐝𝐦𝐢𝐧<br />\r\nWhats', 10, 180, 99000, 2, 1, '2023-10-12 05:35:20', '2023-10-12 05:35:20'),
(8, 'Photo20231012123611652785cb4e3b0.png', 'Kaos Bung Indonesia Gold', 'kaos-bung-indonesia-gold', '<p><img alt=\"\" src=\"http://127.0.0.1:8000/storage/files/1/Untitled.png\" style=\"height:486px; width:488px\" /></p>\r\n\r\n<p>size : S , M , L , XL , XXL , XXXL<br />\r\ncloth : cotton combed 24s / 30s<br />\r\ncost : Rp 99.000.00,-<br />\r\n<br />\r\n𝐚𝐝𝐦𝐢𝐧<br />\r\nWhats', 10, 180, 99000, 2, 1, '2023-10-12 05:36:11', '2023-10-12 05:36:11'),
(9, 'Photo20231012123703652785ff0d014.png', 'Kaos Bung Indonesia Tinta Hitam Putih', 'kaos-bung-indonesia-tinta-hitam-putih', '<p><img alt=\"\" src=\"http://127.0.0.1:8000/storage/files/1/Untitled.png\" style=\"height:486px; width:488px\" /></p>\r\n\r\n<p>size : S , M , L , XL , XXL , XXXL<br />\r\ncloth : cotton combed 24s / 30s<br />\r\ncost : Rp 99.000.00,-<br />\r\n<br />\r\n𝐚𝐝𝐦𝐢𝐧<br />\r\nWhats', 10, 180, 99000, 2, 1, '2023-10-12 05:37:03', '2023-10-12 05:37:03');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_categories_id_foreign` (`categories_id`),
  ADD KEY `products_users_id_foreign` (`users_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_categories_id_foreign` FOREIGN KEY (`categories_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `products_users_id_foreign` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 23, 2026 at 01:17 PM
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
-- Database: `db_cafe`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `nama_lengkap`, `created_at`) VALUES
(1, 'admin', '$2y$10$DMpZy.0QiDlHlxVsB9lKeOCg6WvTummPQ4rxPSunTTTLp0voE2D4.', 'Administrator', '2026-10-23 07:33:54');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `nama_menu` varchar(100) NOT NULL,
  `kategori` varchar(50) NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `stok` int(11) DEFAULT 0,
  `gambar` varchar(255) DEFAULT NULL,
  `status` enum('tersedia','habis') DEFAULT 'tersedia',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `nama_menu`, `kategori`, `harga`, `deskripsi`, `stok`, `gambar`, `status`, `created_at`, `updated_at`) VALUES
(1, 'chesscake', 'Makanan', 25000.00, 'chescake\r\n-Brunt Chesscake\r\n-Bischoff Chesscake\r\n-Blueberry Chesscake\r\n-Raspberry Chesscake', 29, '6adb31d88993f.jpg', 'tersedia', '2026-10-23 10:07:20', '2026-10-23 10:46:37'),
(2, 'cinnamon roll', 'Makanan', 20000.00, '', 15, '6adb3410bc2a4.jpg', 'tersedia', '2026-10-23 10:16:48', '2026-10-23 10:16:48'),
(3, 'risol mayo', 'Makanan', 15000.00, '', 20, '6adb344cc6de7.jpg', 'tersedia', '2026-10-23 10:17:48', '2026-10-23 10:17:48'),
(4, 'thai tea', 'Non kopi', 10000.00, '', 22, '6adb34d2b6c4b.jpg', 'tersedia', '2026-10-23 10:20:02', '2026-10-23 10:33:08'),
(5, ' Matcha Oreo', 'Non kopi', 12000.00, '', 24, '6adb3636818ac.jpg', 'tersedia', '2026-10-23 10:25:58', '2026-10-23 10:46:37'),
(6, 'Kopi Susu Gula Aren', 'Kopi', 15000.00, '', 25, '6adb36d86b3e2.jpg', 'tersedia', '2026-10-23 10:28:40', '2026-10-23 10:28:40'),
(7, 'Milk Coffe', 'Kopi', 10000.00, '', 15, '6adb3e32aa653.jpg', 'tersedia', '2026-10-23 11:00:02', '2026-10-23 11:00:02'),
(8, 'Brownies', 'Makanan', 22000.00, '', 19, '6adb3ebbc8b16.jpg', 'tersedia', '2026-10-23 11:02:19', '2026-10-23 11:02:19'),
(9, 'Americano', 'Kopi', 15000.00, '', 18, '6adb3f10b779b.jpg', 'tersedia', '2026-10-23 11:03:44', '2026-10-23 11:03:44'),
(10, 'Taro', 'Non kopi', 15000.00, '', 20, '6adb3fd8977ed.jpg', 'tersedia', '2026-10-23 11:07:04', '2026-10-23 11:07:04'),
(11, 'Spanish Latte', 'Kopi', 15000.00, '', 14, '6adb405508401.jpg', 'tersedia', '2026-10-23 11:09:09', '2026-10-23 11:09:09'),
(12, 'Butterscotch', 'Kopi', 15000.00, '', 15, '6adb40cc45b11.jpg', 'tersedia', '2026-10-23 11:11:08', '2026-10-23 11:11:08'),
(13, 'Ice Chocolate', 'Non kopi', 12000.00, '', 20, '6adb4132942eb.jpg', 'tersedia', '2026-10-23 11:12:50', '2026-10-23 11:12:50');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `kode_order` varchar(20) NOT NULL,
  `pelanggan_id` int(11) NOT NULL,
  `no_meja` varchar(10) NOT NULL,
  `total_harga` decimal(12,2) NOT NULL,
  `status` enum('pending','diproses','selesai','dibatalkan') DEFAULT 'pending',
  `catatan` text DEFAULT NULL,
  `waktu_order` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `kode_order`, `pelanggan_id`, `no_meja`, `total_harga`, `status`, `catatan`, `waktu_order`) VALUES
(1, 'ORD-20261023174637-3', 1, 'a01', 37000.00, 'selesai', 'tanpa gula', '2026-10-23 17:46:37');

-- --------------------------------------------------------

--
-- Table structure for table `order_detail`
--

CREATE TABLE `order_detail` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `nama_menu` varchar(100) NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `subtotal` decimal(12,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_detail`
--

INSERT INTO `order_detail` (`id`, `order_id`, `menu_id`, `nama_menu`, `harga`, `jumlah`, `subtotal`) VALUES
(1, 1, 1, 'chesscake', 25000.00, 1, 25000.00),
(2, 1, 5, ' Matcha Oreo', 12000.00, 1, 12000.00);

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `no_meja` varchar(10) NOT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `waktu_datang` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`id`, `nama`, `no_meja`, `no_hp`, `waktu_datang`) VALUES
(1, 'naisa', 'a01', '082115445645', '2026-10-23 17:45:16');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_kategori` (`kategori`),
  ADD KEY `idx_status` (`status`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_order` (`kode_order`),
  ADD KEY `pelanggan_id` (`pelanggan_id`),
  ADD KEY `idx_status` (`status`);

--
-- Indexes for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `menu_id` (`menu_id`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `order_detail`
--
ALTER TABLE `order_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`pelanggan_id`) REFERENCES `pelanggan` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD CONSTRAINT `order_detail_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_detail_ibfk_2` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 05, 2026 at 02:59 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sukamart`
--
CREATE DATABASE IF NOT EXISTS `sukamart` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `sukamart`;

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id` int(11) NOT NULL,
  `id_pesanan` int(11) NOT NULL,
  `id_pembarayan` enum('uang_tunai') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `pesanan_ganda`
--

CREATE TABLE `pesanan_ganda` (
  `id` int(11) NOT NULL,
  `id_pembeli` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `kuantitas` int(11) NOT NULL,
  `subtotal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `pesanan_tunggal`
--

CREATE TABLE `pesanan_tunggal` (
  `id` int(11) NOT NULL,
  `id_pembeli` int(11) NOT NULL,
  `jumlah_total` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id` int(11) NOT NULL,
  `nama` int(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `harga` int(11) NOT NULL,
  `stok` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `kategori_id` int(11) NOT NULL,
  `kategori_nama` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `nomor_hp` varchar(255) NOT NULL,
  `alamat` text NOT NULL,
  `role` enum('penjual','pembeli') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nama` (`nama`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pesanan_ganda`
--
ALTER TABLE `pesanan_ganda`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pesanan_tunggal`
--
ALTER TABLE `pesanan_tunggal`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pesanan_ganda`
--
ALTER TABLE `pesanan_ganda`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pesanan_tunggal`
--
ALTER TABLE `pesanan_tunggal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

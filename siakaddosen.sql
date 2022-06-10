-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 10, 2022 at 12:07 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `siakaddosen`
--

-- --------------------------------------------------------

--
-- Table structure for table `dosen`
--

CREATE TABLE `dosen` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `nik` varchar(50) NOT NULL,
  `nidn` varchar(50) NOT NULL,
  `nama_lengkap` varchar(50) NOT NULL,
  `ttl` varchar(50) NOT NULL,
  `pendidikan_s2` varchar(50) NOT NULL,
  `pedidikan_s3` varchar(50) NOT NULL,
  `golongan` varchar(50) NOT NULL,
  `jafung` varchar(50) NOT NULL,
  `alamat` varchar(50) NOT NULL,
  `bidang_ahli` varchar(50) NOT NULL,
  `sertipedik` varchar(50) NOT NULL,
  `matkul` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `dosen`
--

INSERT INTO `dosen` (`id`, `id_user`, `nik`, `nidn`, `nama_lengkap`, `ttl`, `pendidikan_s2`, `pedidikan_s3`, `golongan`, `jafung`, `alamat`, `bidang_ahli`, `sertipedik`, `matkul`) VALUES
(3, 2, 'fadly', 'D111911031', 'Fadly Fadilah', '', 'asda', '', '', '', '', '', '', 'TI');

-- --------------------------------------------------------

--
-- Table structure for table `kopetensi`
--

CREATE TABLE `kopetensi` (
  `id` int(11) NOT NULL,
  `nik` varchar(50) NOT NULL,
  `kegiatan` varchar(50) NOT NULL,
  `tempat` varchar(50) NOT NULL,
  `waktu` varchar(50) NOT NULL,
  `sebagai` enum('penyaji','peserta') NOT NULL,
  `tingkat` enum('wilayah','nasional','internasional','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `rekognisi`
--

CREATE TABLE `rekognisi` (
  `id` int(11) NOT NULL,
  `nik` varchar(11) NOT NULL,
  `rekognisi` varchar(50) NOT NULL,
  `tingkat` enum('wilayah','nasional','internasional') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rekognisi`
--

INSERT INTO `rekognisi` (`id`, `nik`, `rekognisi`, `tingkat`) VALUES
(6, 'fadly', 'asdasd', 'nasional');

-- --------------------------------------------------------

--
-- Table structure for table `studylanjut`
--

CREATE TABLE `studylanjut` (
  `id` int(11) NOT NULL,
  `nik` varchar(11) NOT NULL,
  `pendiklanjut` varchar(50) NOT NULL,
  `bidangstudy` varchar(50) NOT NULL,
  `univ` varchar(50) NOT NULL,
  `negara` varchar(50) NOT NULL,
  `tahunmulaistudi` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(100) NOT NULL,
  `level` enum('admin','dosen') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `level`) VALUES
(1, 'admin', '$2y$10$lspbW5S9zrWb1Yivmsnqh.9ut0jf4aT8N1AOs6w7v5/RBLzpjI.x6', 'admin'),
(2, 'fadly', '$2y$10$PBmO8R7eMoXW62C.OgvsceikDBlKZ54QSo2xC6F4yWqr1i/vm6mqe', 'dosen');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dosen`
--
ALTER TABLE `dosen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `users` (`id_user`);

--
-- Indexes for table `kopetensi`
--
ALTER TABLE `kopetensi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rekognisi`
--
ALTER TABLE `rekognisi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `studylanjut`
--
ALTER TABLE `studylanjut`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dosen`
--
ALTER TABLE `dosen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `kopetensi`
--
ALTER TABLE `kopetensi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rekognisi`
--
ALTER TABLE `rekognisi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `studylanjut`
--
ALTER TABLE `studylanjut`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `dosen`
--
ALTER TABLE `dosen`
  ADD CONSTRAINT `users` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

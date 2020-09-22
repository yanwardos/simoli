-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 22, 2020 at 08:38 PM
-- Server version: 5.7.31-0ubuntu0.18.04.1
-- PHP Version: 7.2.33-1+ubuntu18.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `monitoring_listrik_2`
--

-- --------------------------------------------------------

--
-- Table structure for table `data_monitoring`
--

CREATE TABLE `data_monitoring` (
  `id_rekord` bigint(20) NOT NULL,
  `tegangan` float NOT NULL COMMENT 'Volt',
  `kwh` float NOT NULL,
  `arus` float NOT NULL COMMENT 'Ampere',
  `frekuensi` float NOT NULL COMMENT 'Hertz',
  `daya_aktif` float NOT NULL COMMENT 'KW',
  `daya_tampak` float NOT NULL COMMENT 'KVA',
  `waktu_rekord` datetime NOT NULL,
  `id_sensor` smallint(6) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_monitoring`
--

INSERT INTO `data_monitoring` (`id_rekord`, `tegangan`, `kwh`, `arus`, `frekuensi`, `daya_aktif`, `daya_tampak`, `waktu_rekord`, `id_sensor`) VALUES
(1, 220, 0, 12, 50, 0, 0, '2020-09-22 19:31:53', 1),
(2, 220, 0, 5, 50, 0, 0, '2020-09-22 19:56:00', 1),
(4, 220, 0, 5, 50, 0, 0, '2020-09-22 20:00:14', 2),
(5, 220, 0, 5, 50, 0, 0, '2020-09-22 20:00:17', 2);

-- --------------------------------------------------------

--
-- Table structure for table `register_gedung`
--

CREATE TABLE `register_gedung` (
  `id_gedung` smallint(6) UNSIGNED NOT NULL,
  `nama_gedung` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `register_gedung`
--

INSERT INTO `register_gedung` (`id_gedung`, `nama_gedung`) VALUES
(4, 'Gedung Asrama TB1'),
(5, 'Gedung B');

-- --------------------------------------------------------

--
-- Table structure for table `register_sensor`
--

CREATE TABLE `register_sensor` (
  `id_sensor` smallint(6) UNSIGNED NOT NULL,
  `nama_sensor` varchar(200) NOT NULL,
  `id_gedung` smallint(6) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `register_sensor`
--

INSERT INTO `register_sensor` (`id_sensor`, `nama_sensor`, `id_gedung`) VALUES
(1, 'Sensor Lantai Bawah', 4),
(2, 'Sensor Lantai Atas', 4);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `data_monitoring`
--
ALTER TABLE `data_monitoring`
  ADD PRIMARY KEY (`id_rekord`),
  ADD KEY `id_sensor` (`id_sensor`);

--
-- Indexes for table `register_gedung`
--
ALTER TABLE `register_gedung`
  ADD PRIMARY KEY (`id_gedung`);

--
-- Indexes for table `register_sensor`
--
ALTER TABLE `register_sensor`
  ADD PRIMARY KEY (`id_sensor`),
  ADD KEY `id_gedung` (`id_gedung`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `data_monitoring`
--
ALTER TABLE `data_monitoring`
  MODIFY `id_rekord` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `register_gedung`
--
ALTER TABLE `register_gedung`
  MODIFY `id_gedung` smallint(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `register_sensor`
--
ALTER TABLE `register_sensor`
  MODIFY `id_sensor` smallint(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `data_monitoring`
--
ALTER TABLE `data_monitoring`
  ADD CONSTRAINT `data_monitoring_ibfk_1` FOREIGN KEY (`id_sensor`) REFERENCES `register_sensor` (`id_sensor`);

--
-- Constraints for table `register_sensor`
--
ALTER TABLE `register_sensor`
  ADD CONSTRAINT `register_sensor_ibfk_1` FOREIGN KEY (`id_gedung`) REFERENCES `register_gedung` (`id_gedung`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
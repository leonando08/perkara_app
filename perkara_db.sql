-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 23, 2025 at 02:22 AM
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
-- Database: `perkara_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `jenis_perkara`
--

CREATE TABLE `jenis_perkara` (
  `id` int(11) UNSIGNED NOT NULL COMMENT 'Primary key: (by system)',
  `parent_id` int(11) UNSIGNED DEFAULT NULL COMMENT 'Id Jenis Perkara Induk: (hirarki)',
  `kode` varchar(30) DEFAULT NULL COMMENT 'Kode Jenis Perkara: isian bebas',
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nama_lengkap` varchar(500) DEFAULT NULL COMMENT 'Nama Lengkap Jenis Perkara: (by system)',
  `format_nomor` varchar(250) DEFAULT NULL COMMENT 'Format Nomor Perkara',
  `keterangan` varchar(500) DEFAULT NULL COMMENT 'Keterangan: isian bebas',
  `tipe_level` tinyint(4) UNSIGNED NOT NULL DEFAULT 1 COMMENT 'Flag untuk jenis perkara lainnya: 1=Terdefinisi 0=Lainnya (by system)',
  `aktif` char(1) NOT NULL DEFAULT 'Y' COMMENT 'Status Aktif: pilihan Y=Ya; T=Tidak',
  `urutan` int(11) UNSIGNED DEFAULT NULL COMMENT 'Urutan Jenis Perkara berdasarkan parent_id',
  `level` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Level tree: (by system)',
  `lft` int(11) DEFAULT NULL COMMENT 'Left: (by system)',
  `rgt` int(11) DEFAULT NULL COMMENT 'Right: (by system)',
  `diedit_oleh` varchar(30) DEFAULT '' COMMENT 'Diedit Oleh: (by system)',
  `diedit_tanggal` datetime DEFAULT NULL COMMENT 'Diedit Tanggal: (by system)',
  `diinput_oleh` varchar(30) DEFAULT '' COMMENT 'Diinput Oleh: (by system)',
  `diinput_tanggal` datetime DEFAULT NULL COMMENT 'Diinput Tanggal: (by system)',
  `diperbaharui_oleh` varchar(30) DEFAULT '' COMMENT 'Diperbaharui Oleh: (by system)',
  `diperbaharui_tanggal` datetime DEFAULT NULL COMMENT 'Diperbaharui Tanggal: (by system)'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci COMMENT='Referensi Jenis Perkara(Hirarki)';

--
-- Dumping data for table `jenis_perkara`
--

INSERT INTO `jenis_perkara` (`id`, `parent_id`, `kode`, `nama`, `nama_lengkap`, `format_nomor`, `keterangan`, `tipe_level`, `aktif`, `urutan`, `level`, `lft`, `rgt`, `diedit_oleh`, `diedit_tanggal`, `diinput_oleh`, `diinput_tanggal`, `diperbaharui_oleh`, `diperbaharui_tanggal`) VALUES
(1, NULL, 'PDT', 'Perdata', 'Perdata', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', NULL, 1, 'Y', 1, 0, 1, 212, '', NULL, NULL, NULL, 'admin', '2010-11-20 07:59:31'),
(2, NULL, 'PID', 'Pidana', 'Pidana', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', NULL, 1, 'Y', 2, 0, 213, 446, '', NULL, NULL, NULL, 'admin', '2010-11-20 07:59:40'),
(3, 113, 'Pdt.G', 'Gugatan', 'Perdata Gugatan', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 1, 2, 3, 102, '', NULL, 'admin2', '2014-05-04 21:33:31', 'system', '2014-05-04 21:33:31'),
(4, 113, 'Pdt.P', 'Permohonan', 'Perdata Permohonan', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 2, 2, 103, 156, '', NULL, 'admin2', '2014-05-05 10:56:51', 'system', '2014-05-05 10:56:51'),
(5, 142, 'PAILIT', 'Permohonan Pernyataan Pailit', 'Permohonan Pernyataan Pailit', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN Niaga #kode_pn#', '', 1, 'Y', 1, 3, 160, 161, '', NULL, NULL, NULL, 'system', '2012-04-30 18:48:08'),
(6, 142, 'HKI', 'Hak Kekayaan Intelektual', 'Hak Kekayaan Intelektual', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN Niaga #kode_pn#', '', 1, 'Y', 3, 3, 164, 171, '', NULL, 'admin', '2012-10-08 15:47:38', 'system', '2012-10-08 15:47:38'),
(7, 114, 'PHI', 'Pengadilan Hubungan Industrial (PHI)', 'Pengadilan Hubungan Industrial (PHI)', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 2, 2, 173, 200, '', NULL, NULL, NULL, 'system', '2012-04-30 18:50:38'),
(8, 114, '', 'Perkara Komisi Pengawas Persaingan Usaha (KPPU)', 'Perkara Komisi Pengawas Persaingan Usaha (KPPU)', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 7, 2, 209, 210, '', NULL, NULL, NULL, 'system', '2012-04-17 07:30:06'),
(9, 114, '', 'Perkara Badan Penyelesaian Sengketa Konsumen (BPSK)', 'Perkara Badan Penyelesaian Sengketa Konsumen (BPSK)', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 6, 2, 207, 208, '', NULL, NULL, NULL, 'system', '2012-04-30 18:51:42'),
(10, 114, '', 'Arbitrase', 'Arbitrase', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 5, 2, 205, 206, '', NULL, NULL, NULL, 'system', '2012-04-17 07:30:51'),
(11, 114, '', 'Keberatan Terhadap Penetapan KPUD Provinsi/Kab/Kota', 'Keberatan Terhadap Penetapan KPUD Provinsi/Kab/Kota', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 4, 2, 203, 204, '', NULL, NULL, NULL, 'system', '2012-04-30 18:51:10'),
(12, 114, '', 'Perkara Partai Politik', 'Perkara Partai Politik', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 3, 2, 201, 202, '', NULL, NULL, NULL, 'system', '2012-04-17 07:31:45'),
(13, 167, '1A', 'Kejahatan Terhadap Keamanan Negara', 'Kejahatan/Kejahatan Terhadap Keamanan Negara', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 1, 3, 216, 217, '', NULL, 'system', '2012-11-07 02:12:12', NULL, '2012-11-07 02:12:12'),
(14, 167, '1B', 'Kejahatan terhadap Martabat Presiden dan Wakil Presiden', 'Kejahatan/Kejahatan terhadap Martabat Presiden dan Wakil Presiden', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 2, 3, 218, 219, '', NULL, 'admin', '2012-10-18 23:27:56', 'admin', '2012-10-18 23:27:56'),
(15, 167, '1C', 'Kejahatan terhadap Negara Sahabat dan terhadap Kepala Negara Sahabat serta Wakil-Wakilnya', 'Kejahatan/Kejahatan terhadap Negara Sahabat dan terhadap Kepala Negara Sahabat serta Wakil-Wakilnya', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 3, 3, 220, 221, '', NULL, 'admin', '2012-10-18 23:29:39', 'admin', '2012-10-18 23:29:39'),
(16, 167, '1D', 'Kejahatan terhadap Melakukan Kewajiban dan Hak Kenegaraan', 'Kejahatan/Kejahatan terhadap Melakukan Kewajiban dan Hak Kenegaraan', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 4, 3, 222, 223, '', NULL, 'admin', '2012-10-18 23:30:44', 'admin', '2012-10-18 23:30:44'),
(17, 167, '1E', 'Kejahatan Terhadap Ketertiban Umum', 'Kejahatan/Kejahatan Terhadap Ketertiban Umum', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 5, 3, 224, 225, '', NULL, 'admin2', '2014-05-05 11:04:16', NULL, '2014-05-05 11:04:16'),
(18, 167, '1G', 'Kejahatan yang Membahayakan Keamananan Umum Bagi Orang atau Barang', 'Kejahatan/Kejahatan yang Membahayakan Keamananan Umum Bagi Orang atau Barang', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 7, 3, 228, 229, '', NULL, 'admin', '2012-10-18 23:32:39', 'admin', '2012-10-18 23:32:39'),
(19, 167, '1H', 'Kejahatan Terhadap Penguasa Umum', 'Kejahatan/Kejahatan Terhadap Penguasa Umum', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 8, 3, 230, 231, '', NULL, 'admin', '2012-10-18 23:33:58', NULL, '2012-10-18 23:33:58'),
(20, 167, '1I', 'Sumpah Palsu dan Keterangan Palsu', 'Kejahatan/Sumpah Palsu dan Keterangan Palsu', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 9, 3, 232, 233, '', NULL, 'admin2', '2014-05-05 11:04:03', 'admin', '2014-05-05 11:04:03'),
(21, 167, '1J', 'Pemalsuan Mata Uang dan Uang Kertas', 'Kejahatan/Pemalsuan Mata Uang dan Uang Kertas', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 10, 3, 234, 235, '', NULL, 'admin2', '2014-05-05 11:04:33', NULL, '2014-05-05 11:04:33'),
(22, 167, '1K', 'Pemalsuan Materai dan Merek', 'Kejahatan/Pemalsuan Materai dan Merek', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 11, 3, 236, 237, '', NULL, 'admin2', '2014-05-05 11:04:45', NULL, '2014-05-05 11:04:45'),
(23, 167, '1L', 'Pemalsuan Surat', 'Kejahatan/Pemalsuan Surat', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 12, 3, 238, 239, '', NULL, 'admin2', '2014-05-05 11:04:58', NULL, '2014-05-05 11:04:58'),
(24, 167, '1M', 'Kejahatan terhadap Asal Usul Perkawinan', 'Kejahatan/Kejahatan terhadap Asal Usul Perkawinan', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 13, 3, 240, 241, '', NULL, 'admin2', '2014-05-05 11:05:09', NULL, '2014-05-05 11:05:09'),
(25, 167, '1N', 'Kejahatan terhadap Kesusilaan', 'Kejahatan/Kejahatan terhadap Kesusilaan', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 14, 3, 242, 243, '', NULL, 'admin2', '2014-05-05 11:05:18', NULL, '2014-05-05 11:05:18'),
(26, 157, '', 'Kejahatan Perjudian', 'Kejahatan Perjudian', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 50, 2, 393, 394, '', NULL, 'admin2', '2014-05-05 11:10:42', NULL, '2014-05-05 11:10:42'),
(27, 167, '1O', 'Meninggalkan Orang Yang Perlu Ditolong', 'Kejahatan/Meninggalkan Orang Yang Perlu Ditolong', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 15, 3, 244, 245, '', NULL, 'admin2', '2014-05-05 11:05:30', NULL, '2014-05-05 11:05:30'),
(28, 167, '1P', 'Penghinaan', 'Kejahatan/Penghinaan', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 16, 3, 246, 247, '', NULL, 'admin2', '2014-05-05 11:05:42', NULL, '2014-05-05 11:05:42'),
(29, 167, '1Q', 'Membuka Rahasia', 'Kejahatan/Membuka Rahasia', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 17, 3, 248, 249, '', NULL, 'admin', '2012-10-18 23:42:16', NULL, '2012-10-18 23:42:16'),
(30, 167, '1R', 'Kejahatan terhadap Kemerdekaan Orang', 'Kejahatan/Kejahatan terhadap Kemerdekaan Orang', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 18, 3, 250, 251, '', NULL, 'admin', '2012-10-18 23:42:56', NULL, '2012-10-18 23:42:56'),
(31, 167, '1S', 'Kejahatan terhadap Nyawa', 'Kejahatan/Kejahatan terhadap Nyawa', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 19, 3, 252, 253, '', NULL, 'admin2', '2014-05-05 11:05:54', NULL, '2014-05-05 11:05:54'),
(32, 167, '1T', 'Penganiayaan', 'Kejahatan/Penganiayaan', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 20, 3, 254, 255, '', NULL, 'admin2', '2014-05-05 11:06:12', NULL, '2014-05-05 11:06:12'),
(33, 167, '1U', 'Menyebabkan Mati atau Luka-Luka karena Kealpaan', 'Kejahatan/Menyebabkan Mati atau Luka-Luka karena Kealpaan', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 21, 3, 256, 257, '', NULL, 'admin2', '2014-05-05 11:06:32', 'system', '2014-05-05 11:06:32'),
(34, 167, '1V', 'Pencurian', 'Kejahatan/Pencurian', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 22, 3, 258, 259, '', NULL, 'admin2', '2014-05-05 11:06:48', NULL, '2014-05-05 11:06:48'),
(35, 167, '1W', 'Pemerasan dan Pengancaman', 'Kejahatan/Pemerasan dan Pengancaman', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 23, 3, 260, 261, '', NULL, 'admin2', '2014-05-05 11:07:15', NULL, '2014-05-05 11:07:15'),
(36, 167, '1X', 'Penggelapan ', 'Kejahatan/Penggelapan ', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 24, 3, 262, 263, '', NULL, 'admin2', '2014-05-05 11:07:27', NULL, '2014-05-05 11:07:27'),
(37, 157, '', 'Penipuan', 'Penipuan', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 49, 2, 391, 392, '', NULL, 'admin2', '2014-05-05 11:10:33', NULL, '2014-05-05 11:10:33'),
(38, 167, '1Z', 'Perbuatan Merugikan Pemiutang atau Orang Yang Mempunyai Hak', 'Kejahatan/Perbuatan Merugikan Pemiutang atau Orang Yang Mempunyai Hak', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 26, 3, 266, 267, '', NULL, 'system', '2012-10-19 07:30:52', NULL, '2012-10-19 07:30:52'),
(39, 167, '1AA', 'Penghancuran atau Perusakan Barang', 'Kejahatan/Penghancuran atau Perusakan Barang', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 27, 3, 268, 269, '', NULL, 'system', '2012-10-19 07:31:27', NULL, '2012-10-19 07:31:27'),
(40, 167, '1AB', 'Kejahatan Jabatan', 'Kejahatan/Kejahatan Jabatan', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 28, 3, 270, 271, '', NULL, 'system', '2012-10-19 07:31:51', NULL, '2012-10-19 07:31:51'),
(41, 167, '1AC', 'Kejahatan Pelayaran', 'Kejahatan/Kejahatan Pelayaran', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 29, 3, 272, 273, '', NULL, 'admin', '2012-10-18 23:50:31', NULL, '2012-10-18 23:50:31'),
(42, 167, '1AD', 'Penadahan, Penerbitan, dan Pencetakan', 'Kejahatan/Penadahan, Penerbitan, dan Pencetakan', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 30, 3, 274, 275, '', NULL, 'admin2', '2014-05-05 11:07:47', NULL, '2014-05-05 11:07:47'),
(43, 157, '', 'Kejahatan Penerbitan dan Pencetakan', 'Kejahatan Penerbitan dan Pencetakan', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'T', 67, 2, 427, 428, '', NULL, 'system', '2012-11-07 03:02:58', NULL, '2012-11-07 03:02:58'),
(44, 157, '', 'Tindak Pidana Ekonomi', 'Tindak Pidana Ekonomi', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 66, 2, 425, 426, '', NULL, 'ekitea', '2012-11-12 01:54:48', NULL, '2012-11-12 01:54:48'),
(45, 158, 'TIPIKOR', 'Tindak Pidana Korupsi', 'Tindak Pidana Korupsi', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 1, 2, 439, 440, '', NULL, 'system', '2012-11-07 02:45:16', NULL, '2012-11-07 02:45:16'),
(46, 157, '', 'Tindak Pidana Senjata Api atau Benda Tajam', 'Tindak Pidana Senjata Api atau Benda Tajam', '#nomor_urut_perkara#/Pid.Sus/#tahun#/PN #kode_pn#', '', 1, 'Y', 48, 2, 389, 390, '', NULL, 'admin2', '2014-05-05 11:10:24', 'system', '2014-05-05 11:10:24'),
(47, 157, '37', 'Narkotika', 'Narkotika', '#nomor_urut_perkara#/Pid.Sus/#tahun#/PN #kode_pn#', '', 1, 'Y', 37, 2, 367, 368, '', NULL, 'admin2', '2014-05-05 11:09:49', 'system', '2014-05-05 11:09:49'),
(48, 157, '', 'Tindak Pidana Agama', 'Tindak Pidana Agama', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 65, 2, 423, 424, '', NULL, 'ekitea', '2012-11-12 01:54:29', NULL, '2012-11-12 01:54:29'),
(49, 157, '', 'Tindak Pidana Imigrasi', 'Tindak Pidana Imigrasi', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 64, 2, 421, 422, '', NULL, 'ekitea', '2012-11-12 01:54:07', NULL, '2012-11-12 01:54:07'),
(50, 157, '', 'Tindak Pidana Devisa', 'Tindak Pidana Devisa', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 63, 2, 419, 420, '', NULL, 'ekitea', '2012-11-12 01:53:44', NULL, '2012-11-12 01:53:44'),
(51, 157, '', 'Tindak Pidana Lingkungan Hidup', 'Tindak Pidana Lingkungan Hidup', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 47, 2, 387, 388, '', NULL, 'admin', '2012-10-19 00:12:35', NULL, '2012-10-19 00:12:35'),
(52, 157, '', 'Tindak Pidana Koneksitas', 'Tindak Pidana Koneksitas', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 62, 2, 417, 418, '', NULL, 'ekitea', '2012-11-12 01:53:21', 'system', '2012-11-12 01:53:21'),
(53, 157, '6', 'Perlindungan Saksi Dan Korban', 'Perlindungan Saksi Dan Korban', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 6, 2, 305, 306, '', NULL, 'admin2', '2014-05-05 11:08:32', NULL, '2014-05-05 11:08:32'),
(54, 157, '', 'Tindak Pidana Subversi', 'Tindak Pidana Subversi', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 61, 2, 415, 416, '', NULL, 'admin2', '2014-05-05 11:12:18', NULL, '2014-05-05 11:12:18'),
(55, 157, '45', 'Lain-Lain', 'Lain-Lain', '#nomor_urut_perkara#/Pid.Sus/#tahun#/PN #kode_pn#', '', 1, 'Y', 69, 2, 431, 432, '', NULL, 'admin', '2015-09-16 22:14:10', 'system', '2015-09-16 22:14:10'),
(56, 116, '1A1', 'Jual Beli Tanah', 'Objek Sengketa Tanah/Wanprestasi/Jual Beli Tanah', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 1, 5, 6, 7, '', NULL, 'admin2', '2014-05-05 10:22:25', 'system', '2014-05-05 10:22:25'),
(57, 3, '', 'Perumahan', 'Perumahan', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'T', 3, 3, 88, 89, '', NULL, NULL, NULL, 'system', '2012-04-18 23:55:54'),
(58, 3, '', 'Barang Bukan Tanah Perumahan', 'Barang Bukan Tanah Perumahan', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'T', 4, 3, 90, 91, '', NULL, NULL, NULL, 'system', '2012-04-18 23:56:27'),
(59, 3, '', 'Hutang Piutang', 'Hutang Piutang', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'T', 5, 3, 92, 93, '', NULL, 'admin2', '2014-05-05 10:55:56', 'system', '2014-05-05 10:55:56'),
(60, 3, '', 'Persetujuan Kerja', 'Persetujuan Kerja', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'T', 6, 3, 94, 95, '', NULL, NULL, NULL, 'system', '2012-04-18 23:54:49'),
(61, 120, '2A2', 'Sewa Menyewa', 'Objek Sengketa Bukan Tanah/Wanprestasi/Sewa Menyewa', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 2, 5, 40, 41, '', NULL, 'admin2', '2014-05-05 10:51:50', 'system', '2014-05-05 10:51:50'),
(62, 120, '2A1', 'Jual Beli', 'Objek Sengketa Bukan Tanah/Wanprestasi/Jual Beli', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 1, 5, 38, 39, '', NULL, 'admin2', '2014-05-05 10:51:36', 'system', '2014-05-05 10:51:36'),
(63, 119, '4', 'Warisan/Wasiat', 'Objek Sengketa Bukan Tanah/Warisan/Wasiat', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 3, 4, 69, 70, '', NULL, 'admin2', '2014-05-05 10:53:53', 'system', '2014-05-05 10:53:53'),
(64, 119, '5', 'Perceraian', 'Objek Sengketa Bukan Tanah/Perceraian', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 4, 4, 71, 76, '', NULL, 'admin2', '2014-05-05 10:54:08', 'system', '2014-05-05 10:54:08'),
(65, 64, '5A', 'Harta Bersama', 'Objek Sengketa Bukan Tanah/Perceraian/Harta Bersama', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', 'Harta Perkawinan', 1, 'Y', 1, 5, 72, 73, '', NULL, 'admin2', '2014-05-05 10:54:27', 'system', '2014-05-05 10:54:27'),
(66, 120, '2A14', 'Gadai/Hipotik/Fiducia', 'Objek Sengketa Bukan Tanah/Wanprestasi/Gadai/Hipotik/Fiducia', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 14, 5, 64, 65, '', NULL, NULL, NULL, 'system', '2012-04-18 23:33:15'),
(67, 120, '2A10', 'Perseroan', 'Objek Sengketa Bukan Tanah/Wanprestasi/Perseroan', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 10, 5, 56, 57, '', NULL, 'admin2', '2014-05-05 10:53:30', 'system', '2014-05-05 10:53:30'),
(68, 117, '1B3', 'Hak Ulayat/Persekutuan Adat', 'Objek Sengketa Tanah/Perbuatan Melawan Hukum/Hak Ulayat/Persekutuan Adat', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 3, 5, 24, 25, '', NULL, 'admin2', '2014-05-05 10:49:14', 'system', '2014-05-05 10:49:14'),
(69, 120, '2A13', 'Surat Berharga', 'Objek Sengketa Bukan Tanah/Wanprestasi/Surat Berharga', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 13, 5, 62, 63, '', NULL, NULL, NULL, 'system', '2012-04-18 23:29:52'),
(70, 3, '', 'Pengangkutan Darat atau Laut', 'Pengangkutan Darat atau Laut', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'T', 7, 3, 96, 97, '', NULL, NULL, NULL, 'system', '2012-04-18 23:54:22'),
(71, 120, '2A9', 'Asuransi', 'Objek Sengketa Bukan Tanah/Wanprestasi/Asuransi', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 9, 5, 54, 55, '', NULL, 'admin2', '2014-05-05 10:53:14', 'system', '2014-05-05 10:53:14'),
(72, 117, '1B2', 'Penyalahgunaan Hak', 'Objek Sengketa Tanah/Perbuatan Melawan Hukum/Penyalahgunaan Hak', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 2, 5, 22, 23, '', NULL, 'admin2', '2014-05-05 10:49:02', 'system', '2014-05-05 10:49:02'),
(73, 3, '', 'Melampaui Batas Kekuasaan', 'Melampaui Batas Kekuasaan', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'T', 8, 3, 98, 99, '', NULL, NULL, NULL, 'system', '2012-04-18 23:53:50'),
(74, 3, '', 'Wanprestasi', 'Wanprestasi', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'T', 9, 3, 100, 101, '', NULL, 'admin2', '2014-05-05 10:56:22', 'system', '2014-05-05 10:56:22'),
(75, 119, '3', 'Perbuatan Melawan Hukum', 'Objek Sengketa Bukan Tanah/Perbuatan Melawan Hukum', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 2, 4, 67, 68, '', NULL, 'admin2', '2014-05-05 10:53:44', 'system', '2014-05-05 10:53:44'),
(76, 120, '2A5', 'Ganti Rugi', 'Objek Sengketa Bukan Tanah/Wanprestasi/Ganti Rugi', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 5, 5, 46, 47, '', NULL, 'admin2', '2014-05-05 10:52:26', 'system', '2014-05-05 10:52:26'),
(78, 4, '', 'Perbaikan Kesalahan Dalam Akta Kelahiran', 'Perbaikan Kesalahan Dalam Akta Kelahiran', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', 'Permohonan memperbaiki kesalahan dalam Akta Catatan Sipil (Pasal 49 dan Pasal 50 Ordonatie Penduduk Jawa dan Madura)', 1, 'Y', 12, 3, 126, 127, '', NULL, 'admin2', '2014-05-05 10:59:02', 'admin', '2014-05-05 10:59:02'),
(79, 4, '', 'Penerimaan/Penolakan Warisan', 'Penerimaan/Penolakan Warisan', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', 'Permohonan penerimaan/penolakan warisan', 1, 'Y', 13, 3, 128, 129, '', NULL, 'admin2', '2014-05-05 10:59:16', 'admin', '2014-05-05 10:59:16'),
(80, 4, NULL, 'Pembubaran/Likuidasi Badan hukum', 'Pembubaran/Likuidasi Badan hukum', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', 'Permohonan pembubaran/likuidasi badan hukum', 1, 'Y', 14, 3, 130, 131, NULL, NULL, NULL, NULL, NULL, NULL),
(81, 4, NULL, 'Kepailitan Badan Hukum', 'Kepailitan Badan Hukum', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', 'Permohonan kepailitan badan hukum', 1, 'Y', 15, 3, 132, 133, '', NULL, NULL, NULL, 'admin', '2011-01-24 15:59:03'),
(82, 4, NULL, 'Kepailitan Untuk Orang', 'Kepailitan Untuk Orang', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', 'Permohonan kepailitan untuk orang yang berhutang', 1, 'Y', 16, 3, 134, 135, NULL, NULL, NULL, NULL, 'admin', '2010-11-30 05:43:04'),
(83, 4, '', 'Pengangkatan Wali Bagi Anak', 'Pengangkatan Wali Bagi Anak', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', 'Permohonan pengangkatan wali bagi anak yang belum dewasa.', 1, 'Y', 17, 3, 136, 137, '', NULL, 'admin2', '2014-05-05 10:59:28', 'admin', '2014-05-05 10:59:28'),
(84, 4, '', 'Pengangkatan Pengampu Bagi Orang Dewasa Yang Kurang Ingatan', 'Pengangkatan Pengampu Bagi Orang Dewasa Yang Kurang Ingatan', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', 'Permohonan pengangkatan pengampu bagi orang dewasa yang kurang ingatannya .', 1, 'Y', 18, 3, 138, 139, '', NULL, 'admin2', '2014-05-05 10:59:42', 'admin', '2014-05-05 10:59:42'),
(85, 4, '', 'Permohonan Dispensasi Nikah ', 'Permohonan Dispensasi Nikah ', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', 'Permohonan dispensasi nikah bagi Pria yang belum mencapai umur 19 Tahun dan bagi wanita yang belum mencapai umur 16 Tahun ( Pasal 7 UU No.1 Tahun 1974).', 1, 'Y', 19, 3, 140, 141, '', NULL, 'admin2', '2014-05-05 11:00:02', 'system', '2014-05-05 11:00:02'),
(86, 4, '', 'Permohonan Ijin Nikah', 'Permohonan Ijin Nikah', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', 'Permohonan Ijin Nikah bagi calon mempelai yang belum berumur 21 Tahun ( Pasal 6 (5) UU No.1 Tahun 1974)', 1, 'Y', 20, 3, 142, 143, '', NULL, 'admin2', '2014-05-05 11:00:19', NULL, '2014-05-05 11:00:19'),
(87, 4, '', 'Pembatalan Perkawinan', 'Pembatalan Perkawinan', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', 'Pembatalan Perkawinan (Pasal 39 Undang-Undang No.23 Tahun 2006).', 1, 'Y', 21, 3, 144, 145, '', NULL, 'admin2', '2014-05-05 11:00:34', NULL, '2014-05-05 11:00:34'),
(88, 4, 'P3', 'Permohonan Pengangkatan Anak', 'Permohonan Pengangkatan Anak', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', 'Permohonan Pengangkatan anak (SEMA No.6/1983 Jo. SEMA No.2 /2009 dan Pasal 47 ayat 2 Undang-Undang No.23 Tahun 2006).', 1, 'Y', 3, 3, 108, 109, '', NULL, 'admin2', '2014-05-05 10:57:29', NULL, '2014-05-05 10:57:29'),
(89, 4, '', 'Permohonan Untuk Menunjuk Wasit', 'Permohonan Untuk Menunjuk Wasit', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', 'Permohonan untuk menunjuk seorang atau beberapa orang wasit, oleh karena para pihak tidak bisa atau tidak bersedia untuk menunjuk wasit.', 1, 'Y', 22, 3, 146, 147, '', NULL, 'admin2', '2014-05-05 11:00:47', NULL, '2014-05-05 11:00:47'),
(90, 4, NULL, 'Permohonan Akte Kelahiran Terlambat ', 'Permohonan Akte Kelahiran Terlambat ', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', 'Permohonan Akte Kelahiran Terlambat (Pasal 32 ayat 2 Undang-Undang No.23 Tahun 2006).', 1, 'Y', 23, 3, 148, 149, NULL, NULL, NULL, NULL, NULL, NULL),
(91, 4, '', 'Permohonan Ganti Nama', 'Permohonan Ganti Nama', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', 'Permohonan ganti Nama/Perubahan nama (Pasal 52 Undang-Undang No.23 Tahun 2006).', 1, 'Y', 24, 3, 150, 151, '', NULL, 'admin2', '2014-05-05 11:01:08', NULL, '2014-05-05 11:01:08'),
(92, 4, '', 'Wali Dan Ijin  Jual', 'Wali Dan Ijin  Jual', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', 'Wali untuk anak yang belum dewasa  dan Ijin  Jual.', 1, 'Y', 25, 3, 152, 153, '', NULL, 'admin2', '2014-05-05 11:01:20', 'admin', '2014-05-05 11:01:20'),
(93, 4, '', 'Pendaftaran Pernikahan Terlambat', 'Pendaftaran Pernikahan Terlambat', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', 'Permohonan Pendaftaran Pernikahan Terlambat  (Untuk Non Muslim). (Pasal 36 Undang-Undang No.23 Tahun 2006).', 1, 'Y', 26, 3, 154, 155, '', NULL, 'admin2', '2014-05-05 11:01:31', NULL, '2014-05-05 11:01:31'),
(94, 4, 'P6', 'Akta Kematian', 'Akta Kematian', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', 'Permohonan Akte Kematian yang terlambat (Pasal 33 Undang-Undang No.23 Tahun 2006).', 1, 'Y', 6, 3, 114, 115, '', NULL, 'admin2', '2014-05-05 10:58:17', NULL, '2014-05-05 10:58:17'),
(96, 157, '', 'Kelalaian yang mengakibatkan luka/kematian', 'Kelalaian yang mengakibatkan luka/kematian', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'T', 68, 2, 429, 430, '', NULL, 'admin2', '2014-05-05 11:12:35', NULL, '2014-05-05 11:12:35'),
(97, 157, '44', 'Lalu Lintas', 'Lalu Lintas', '#nomor_urut_perkara#/Pid.Sus/#tahun#/PN #kode_pn#', '', 1, 'Y', 44, 2, 381, 382, '', NULL, 'admin2', '2014-05-05 11:10:10', NULL, '2014-05-05 11:10:10'),
(98, 157, '', 'Kekerasan Dalam Rumah Tangga', 'Kekerasan Dalam Rumah Tangga', '#nomor_urut_perkara#/Pid.Sus/#tahun#/PN #kode_pn#', '', 1, 'Y', 52, 2, 397, 398, '', NULL, 'admin2', '2014-05-05 11:13:41', NULL, '2014-05-05 11:13:41'),
(99, 157, '', 'Tanpa hak mengambil atau memiliki suatu barang milik orang lain', 'Tanpa hak mengambil atau memiliki suatu barang milik orang lain', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 55, 2, 403, 404, '', NULL, 'admin', '2012-10-19 00:14:10', 'system', '2012-10-19 00:14:10'),
(100, 157, '', 'Menghuni rumah tanpa izin', 'Menghuni rumah tanpa izin', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 56, 2, 405, 406, '', NULL, 'admin', '2012-10-19 00:25:57', NULL, '2012-10-19 00:25:57'),
(101, 157, '', 'Perbuatan Tidak Menyenangkan', 'Perbuatan Tidak Menyenangkan', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', 'Perbuatan Tidak Menyenangkan', 1, 'Y', 57, 2, 407, 408, '', NULL, 'admin2', '2014-05-05 11:11:29', NULL, '2014-05-05 11:11:29'),
(102, 157, '', 'Pengeroyokan yang menyebabkan luka ringan, luka berat', 'Pengeroyokan yang menyebabkan luka ringan, luka berat', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 58, 2, 409, 410, '', NULL, 'admin2', '2014-05-05 11:11:41', 'ijal', '2014-05-05 11:11:41'),
(103, 157, '', 'Pembunuhan', 'Pembunuhan', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 59, 2, 411, 412, '', NULL, 'admin2', '2014-05-05 11:11:53', NULL, '2014-05-05 11:11:53'),
(104, 157, '', 'Pengeroyokan yang menyebabkan kematian', 'Pengeroyokan yang menyebabkan kematian', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 60, 2, 413, 414, '', NULL, 'admin2', '2014-05-05 11:12:06', NULL, '2014-05-05 11:12:06'),
(105, 157, '', 'Pencemaran Nama Baik', 'Pencemaran Nama Baik', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 51, 2, 395, 396, '', NULL, 'admin2', '2014-05-05 11:10:51', NULL, '2014-05-05 11:10:51'),
(106, 157, '', 'Mengedarkan Uang Palsu', 'Mengedarkan Uang Palsu', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 45, 2, 383, 384, '', NULL, 'admin', '2012-10-19 00:16:24', NULL, '2012-10-19 00:16:24'),
(107, 157, '', 'Mengedarkan Barang-barang Ilegal', 'Mengedarkan Barang-barang Ilegal', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 54, 2, 401, 402, '', NULL, 'admin', '2012-10-19 00:16:57', NULL, '2012-10-19 00:16:57'),
(108, 157, '', 'Melaksanakan Jasa Transportasi Ilegal', 'Pidana Umum/Melaksanakan Jasa Transportasi Ilegal', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 53, 2, 399, 400, '', NULL, 'admin', '2012-10-19 00:23:00', NULL, '2012-10-19 00:23:00'),
(109, 157, '23', 'Perbankan Syariah Negara', 'Perbankan Syariah Negara', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 23, 2, 339, 340, '', NULL, 'system', '2012-10-19 07:12:25', NULL, '2012-10-19 07:12:25'),
(111, 157, '10', 'Pemberantasan Tindak Pidana Perdagangan Orang', 'Pemberantasan Tindak Pidana Perdagangan Orang', '#nomor_urut_perkara#/Pid.Sus/#tahun#/PN #kode_pn#', '', 1, 'Y', 10, 2, 313, 314, '', NULL, 'admin2', '2014-05-05 11:08:44', NULL, '2014-05-05 11:08:44'),
(112, 157, '', 'Pengancaman', 'Pengancaman', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 46, 2, 385, 386, '', NULL, 'system', '2012-10-19 07:33:16', 'system', '2012-10-19 07:33:16'),
(113, 1, 'PTD.U', 'Umum', 'Perdata Umum', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 1, 1, 2, 157, '', NULL, 'system', '2012-04-17 07:27:14', '', NULL),
(114, 1, 'PDT.K', 'Khusus', 'Perdata/Khusus', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 2, 1, 158, 211, '', NULL, 'system', '2012-04-17 07:27:48', '', NULL),
(115, 3, '1', 'Objek Sengketa Tanah', 'Objek Sengketa Tanah', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 1, 3, 4, 35, '', NULL, 'admin2', '2014-05-05 10:22:14', 'system', '2014-05-05 10:22:14'),
(118, 116, '1A4', 'Hibah', 'Objek Sengketa Tanah/Wanprestasi/Hibah', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 4, 5, 12, 13, '', NULL, 'admin2', '2014-05-05 10:24:07', 'system', '2014-05-05 10:24:07'),
(119, 3, '2', 'Objek Sengketa Bukan Tanah', 'Objek Sengketa Bukan Tanah', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 2, 3, 36, 87, '', NULL, 'admin2', '2014-05-05 10:51:15', 'system', '2014-05-05 10:51:15'),
(122, 120, '2A6', 'Leasing/Sewa Beli', 'Objek Sengketa Bukan Tanah/Wanprestasi/Leasing/Sewa Beli', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 6, 5, 48, 49, '', NULL, 'admin2', '2014-05-05 10:52:40', '', '2014-05-05 10:52:40'),
(123, 120, '2A7', 'Anjak Piutang/Cessie', 'Objek Sengketa Bukan Tanah/Wanprestasi/Anjak Piutang/Cessie', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 7, 5, 50, 51, '', NULL, 'admin2', '2014-05-05 10:52:51', '', '2014-05-05 10:52:51'),
(124, 120, '2A8', 'Perjanjian Borongan', 'Objek Sengketa Bukan Tanah/Wanprestasi/Perjanjian Borongan', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 8, 5, 52, 53, '', NULL, 'admin2', '2014-05-05 10:53:02', '', '2014-05-05 10:53:02'),
(125, 120, '2A11', 'Yayasan', 'Objek Sengketa Bukan Tanah/Wanprestasi/Yayasan', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 11, 5, 58, 59, '', NULL, 'system', '2012-10-19 08:10:01', '', '2012-10-19 08:10:01'),
(126, 120, '2A12', 'Koperasi', 'Objek Sengketa Bukan Tanah/Wanprestasi/Koperasi', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 12, 5, 60, 61, '', NULL, 'system', '2012-10-19 08:10:20', '', '2012-10-19 08:10:20'),
(127, 120, '2A3', 'Jual Gadai', 'Objek Sengketa Bukan Tanah/Wanprestasi/Jual Gadai', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 3, 5, 42, 43, '', NULL, 'admin2', '2014-05-05 10:52:01', 'system', '2014-05-05 10:52:01'),
(132, 117, '1B1', 'Penyerobotan', 'Objek Sengketa Tanah/Perbuatan Melawan Hukum/Penyerobotan', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 1, 5, 20, 21, '', NULL, 'admin2', '2014-05-05 10:48:48', '', '2014-05-05 10:48:48'),
(133, 117, '1B4', 'Pusaka Tinggi/Pusaka Rendah', 'Objek Sengketa Tanah/Perbuatan Melawan Hukum/Pusaka Tinggi/Pusaka Rendah', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 4, 5, 26, 27, '', NULL, 'admin2', '2014-05-05 10:50:33', '', '2014-05-05 10:50:33'),
(134, 117, '1B5', 'Sertifikat/Girik', 'Objek Sengketa Tanah/Perbuatan Melawan Hukum/Sertifikat/Girik', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 5, 5, 28, 29, '', NULL, 'admin2', '2014-05-05 10:50:43', '', '2014-05-05 10:50:43'),
(135, 117, '1B6', 'PPAT', 'Objek Sengketa Tanah/Perbuatan Melawan Hukum/PPAT', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 6, 5, 30, 31, '', NULL, 'admin2', '2014-05-05 10:50:54', '', '2014-05-05 10:50:54'),
(137, 64, '5B', 'Hak Asuh Anak', 'Objek Sengketa Bukan Tanah/Perceraian/Hak Asuh Anak', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 2, 5, 74, 75, '', NULL, 'admin2', '2014-05-05 10:54:40', '', '2014-05-05 10:54:40'),
(138, 119, '6', 'Pembatalan Arbitrase', 'Pembatalan Arbitrase', '#nomor_urut_perkara#/Pdt.Sus-Arb/#tahun#/PN #kode_pn#', 'Pembatalan Arbitrase', 1, 'Y', 5, 4, 77, 78, '', NULL, 'admin2', '2014-05-05 10:55:00', '', '2014-05-05 10:55:00'),
(139, 119, '7', 'KPPU', 'KPPU', '#nomor_urut_perkara#/Pdt.Sus-KPPU/#tahun#/PN #kode_pn#', '', 1, 'Y', 6, 4, 79, 80, '', NULL, 'admin', '2012-11-01 19:04:38', '', '2012-11-01 19:04:38'),
(140, 119, '8', 'BPSK', 'Objek Sengketa Bukan Tanah/BPSK', '#nomor_urut_perkara#/Pdt.Sus-BPSK/#tahun#/PN #kode_pn#', '', 1, 'Y', 7, 4, 81, 82, '', NULL, 'admin', '2012-11-01 19:05:11', '', '2012-11-01 19:05:11'),
(141, 119, '9', 'Partai Politik', 'Objek Sengketa Bukan Tanah/Partai Politik', '#nomor_urut_perkara#/Pdt.Sus-Parpol/#tahun#/PN #kode_pn#', '', 1, 'Y', 8, 4, 83, 84, '', NULL, 'admin2', '2014-05-05 10:55:39', '', '2014-05-05 10:55:39'),
(142, 114, 'Niaga', 'Niaga', 'Niaga', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 1, 2, 159, 172, '', NULL, 'system', '2012-04-30 18:46:42', 'system', '2012-04-30 18:47:06'),
(143, 142, 'PKPU', 'Penundaan Kewajiban Pembayaran Utang', 'Penundaan Kewajiban Pembayaran Utang', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN Niaga #kode_pn#', '', 1, 'Y', 2, 3, 162, 163, '', NULL, 'system', '2012-04-30 18:49:20', '', NULL),
(144, 7, 'PHI-01', 'Perselisihan Pemutusan Hubungan Kerja Sepihak', 'Perselisihan Pemutusan Hubungan Kerja Sepihak', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 1, 3, 174, 175, '', NULL, 'system', '2012-04-30 18:53:00', '', NULL),
(145, 7, 'PHI-02', 'Perselisihan Pemutusan Hubungan Kerja Massal', 'Perselisihan Pemutusan Hubungan Kerja Massal', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 2, 3, 176, 177, '', NULL, 'system', '2012-04-30 18:53:40', '', NULL),
(146, 7, 'PHI-03', 'Pemutusan Hubungan Kerja Tanpa Memperhatikan Hak Pekerja', 'Pemutusan Hubungan Kerja Tanpa Memperhatikan Hak Pekerja', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 3, 3, 178, 179, '', NULL, 'system', '2012-04-30 18:54:03', '', NULL),
(147, 7, 'PHI-04', 'Perselisihan Hubungan Kerja Karena Pekerja Indisipliner', 'Perselisihan Hubungan Kerja Karena Pekerja Indisipliner', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 4, 3, 180, 181, '', NULL, 'system', '2012-04-30 18:54:25', '', NULL),
(148, 7, 'PHI-05', 'Perselisihan Pemutusan Hubungan Kerja Karena Pekerja Melakukan Tindak Pidana', 'Perselisihan Pemutusan Hubungan Kerja Karena Pekerja Melakukan Tindak Pidana', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 5, 3, 182, 183, '', NULL, 'system', '2012-04-30 18:55:03', '', NULL),
(149, 7, 'PHI-06', 'Perselisihan Hak Pekerja Karena Upah Tidak Dibayar', 'Perselisihan Hak Pekerja Karena Upah Tidak Dibayar', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 6, 3, 184, 185, '', NULL, 'system', '2012-04-30 18:55:32', '', NULL),
(150, 7, 'PHI-07', 'Perselisihan Hak Pekerja Yang Sudah Diperjanjikan Tidak Dipenuhi', 'Perselisihan Hak Pekerja Yang Sudah Diperjanjikan Tidak Dipenuhi', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 7, 3, 186, 187, '', NULL, 'system', '2012-04-30 18:58:25', '', NULL),
(151, 7, 'PHI-08', 'Perselisihan Upah Yang Tidak Sesuai', 'Perselisihan Upah Yang Tidak Sesuai', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 8, 3, 188, 189, '', NULL, 'system', '2012-04-30 18:58:48', '', NULL),
(152, 7, 'PHI-09', 'Perselisihan Kepentingan Karena Keahlian Pekerja', 'Perselisihan Kepentingan Karena Keahlian Pekerja', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 9, 3, 190, 191, '', NULL, 'system', '2012-04-30 18:59:18', '', NULL),
(153, 7, 'PHI-10', 'Perselisihan Kepentingan Karena Mutasi Pekerja', 'Perselisihan Kepentingan Karena Mutasi Pekerja', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 10, 3, 192, 193, '', NULL, 'system', '2012-04-30 18:59:45', '', NULL),
(154, 7, 'PHI-11', 'Pemberhentian Karena Tanpa Adanya SKB (Surat Kesepakatan Bersama)', 'Pemberhentian Karena Tanpa Adanya SKB (Surat Kesepakatan Bersama)', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 11, 3, 194, 195, '', NULL, 'system', '2012-04-30 19:00:23', '', NULL),
(155, 7, 'PHI-12', 'Perselisihan Antar Pekerja Dalam 1 ( satu ) Perusahaan', 'Perselisihan Antar Pekerja Dalam 1 ( satu ) Perusahaan', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 12, 3, 196, 197, '', NULL, 'system', '2012-04-30 19:00:51', '', NULL),
(156, 7, 'PHI-LL', 'Lain - Lain', 'Lain - Lain', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 13, 3, 198, 199, '', NULL, 'system', '2012-04-30 19:01:24', '', NULL),
(159, 158, 'PRK', 'Tindak Pidana Perikanan', 'Tindak Pidana Perikanan', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 2, 2, 441, 442, '', NULL, 'system', '2012-11-07 02:45:56', '', '2012-11-07 02:45:56'),
(160, 158, 'HAM', 'Hak Asasi Manusia', 'Hak Asasi Manusia', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 3, 2, 443, 444, '', NULL, 'system', '2012-11-07 02:46:25', '', '2012-11-07 02:46:25'),
(161, 157, 'LL', 'Perkara Lalu-Lintas', 'Perkara Lalu-Lintas', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', 'Tindak Pidana lalulintas', 1, 'Y', 70, 2, 433, 434, '', NULL, 'admin2', '2014-05-05 11:12:57', '', '2014-05-05 11:12:57'),
(162, 4, 'P1', 'Pengampuan', 'Perdata Permohonan/Pengampuan', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 1, 3, 104, 105, '', NULL, 'admin2', '2014-05-05 10:57:02', '', '2014-05-05 10:57:02'),
(163, 4, 'P2', 'Eksekusi', 'Eksekusi', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 2, 3, 106, 107, '', NULL, 'admin2', '2014-05-05 10:57:15', '', '2014-05-05 10:57:15'),
(164, 6, '', 'Hak Cipta', 'Hak Kekayaan Intelektual/Hak Cipta', '#nomor_urut_perkara#/#kode_alur_perkara#/Cipta/#tahun#/PN Niaga #kode_pn#', '', 1, 'Y', 1, 4, 165, 166, '', NULL, 'system', '2012-10-19 10:47:01', '', '2012-10-19 10:47:01'),
(165, 6, '', 'Merek', 'Hak Kekayaan Intelektual/Merek', '#nomor_urut_perkara#/#kode_alur_perkara#/Merek/#tahun#/PN Niaga #kode_pn#', '', 1, 'Y', 2, 4, 167, 168, '', NULL, 'system', '2012-10-19 10:47:25', '', '2012-10-19 10:47:25'),
(166, 6, '', 'Paten', 'Hak Kekayaan Intelektual/Paten', '#nomor_urut_perkara#/#kode_alur_perkara#/Paten/#tahun#/PN Niaga #kode_pn#', '', 1, 'Y', 3, 4, 169, 170, '', NULL, 'system', '2012-10-19 10:47:55', '', '2012-10-19 10:47:55'),
(167, 157, '1', 'Kejahatan', 'Kejahatan', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 1, 2, 215, 276, '', NULL, 'admin2', '2014-05-05 11:03:46', '', '2014-05-05 11:03:46'),
(168, 157, '2', 'Pelanggaran', 'Pelanggaran', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 2, 2, 277, 298, '', NULL, 'admin2', '2014-05-05 11:07:57', '', '2014-05-05 11:07:57'),
(193, 167, '1Y', 'Perbuatan Curang', 'Kejahatan/Perbuatan Curang', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 25, 3, 264, 265, '', NULL, 'system', '2012-10-19 07:23:46', '', '2012-10-19 07:23:46'),
(194, 167, '1F', 'Perkelahian Tanding', 'Kejahatan/Perkelahian Tanding', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 6, 3, 226, 227, '', NULL, 'system', '2012-10-19 07:26:43', '', '2012-10-19 07:26:43'),
(195, 168, '2A', 'Pelanggaran Keamanan Umum Bagi Orang atau Barang dari Kesehatan Umum', 'Pelanggaran/Pelanggaran Keamanan Umum Bagi Orang atau Barang dari Kesehatan Umum', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 1, 3, 278, 279, '', NULL, 'admin', '2012-10-19 00:31:49', '', NULL),
(196, 168, '2B', 'Pelanggaran Ketertiban Umum', 'Pelanggaran/Pelanggaran Ketertiban Umum', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 2, 3, 280, 281, '', NULL, 'admin', '2012-10-19 00:32:33', '', NULL),
(197, 168, '2C', 'Pelanggaran Terhadap Penguasa Umum', 'Pelanggaran/Pelanggaran Terhadap Penguasa Umum', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 3, 3, 282, 283, '', NULL, 'admin', '2012-10-19 00:33:07', '', NULL),
(198, 168, '2D', 'Pelanggaran Mengenai Asal Usul dan Perkawinan', 'Pelanggaran/Pelanggaran Mengenai Asal Usul dan Perkawinan', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 4, 3, 284, 285, '', NULL, 'admin', '2012-10-19 00:33:39', '', NULL),
(199, 168, '2E', 'Pelanggaran Terhadap Orang Yang Memerlukan Pertolongan', 'Pelanggaran/Pelanggaran Terhadap Orang Yang Memerlukan Pertolongan', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 5, 3, 286, 287, '', NULL, 'admin', '2012-10-19 00:34:42', '', NULL),
(200, 168, '2F', 'Pelanggaran Kesusilaan', 'Pelanggaran/Pelanggaran Kesusilaan', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 6, 3, 288, 289, '', NULL, 'admin2', '2014-05-05 11:08:13', '', '2014-05-05 11:08:13'),
(201, 168, '2G', 'Pelanggaran Mengenai Tanah, Tanaman, dan Pekarangan', 'Pelanggaran/Pelanggaran Mengenai Tanah, Tanaman, dan Pekarangan', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 7, 3, 290, 291, '', NULL, 'admin', '2012-10-19 00:36:51', '', NULL),
(202, 168, '2H', 'Pelanggaran Jabatan', 'Pelanggaran/Pelanggaran Jabatan', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 8, 3, 292, 293, '', NULL, 'admin', '2012-10-19 00:37:33', '', NULL),
(203, 168, '2I', 'Pelanggaran Pelayanan', 'Pelanggaran/Pelanggaran Pelayanan', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 9, 3, 294, 295, '', NULL, 'admin', '2012-10-19 00:38:14', '', NULL),
(204, 157, '3', 'Sistem Keolahragaan Nasional', 'Sistem Keolahragaan Nasional', '#nomor_urut_perkara#/Pid.Sus/#tahun#/PN #kode_pn#', '', 1, 'Y', 3, 2, 299, 300, '', NULL, 'system', '2012-11-07 02:58:19', '', '2012-11-07 02:58:19'),
(205, 157, '4', 'Sistem Resi Gudang', 'Pidana Umum/Sistem Resi Gudang', '#nomor_urut_perkara#/Pid.Sus/#tahun#/PN #kode_pn#', '', 1, 'Y', 4, 2, 301, 302, '', NULL, 'system', '2012-11-07 02:58:42', '', '2012-11-07 02:58:42'),
(206, 157, '5', 'Kewarganegaraan Republik Indonesia', 'Kewarganegaraan Republik Indonesia', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 5, 2, 303, 304, '', NULL, 'system', '2012-11-07 02:59:04', '', '2012-11-07 02:59:04'),
(207, 157, '7', 'Badan Pemeriksa Keuangan', 'Badan Pemeriksa Keuangan', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 7, 2, 307, 308, '', NULL, 'system', '2012-10-19 07:06:24', '', '2012-10-19 07:06:24'),
(208, 157, '8', 'Perubahan Atas Undang-Undang Nomor 10 Tahun 1995 Tentang Kepabeanan', 'Perubahan Atas Undang-Undang Nomor 10 Tahun 1995 Tentang Kepabeanan', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 8, 2, 309, 310, '', NULL, 'system', '2012-10-19 07:06:44', '', '2012-10-19 07:06:44'),
(209, 157, '9', 'Administrasi Kependudukan', 'Administrasi Kependudukan', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 9, 2, 311, 312, '', NULL, 'system', '2012-10-19 07:07:19', '', '2012-10-19 07:07:19'),
(210, 157, '11', 'Perkeretaapian', 'Perkeretaapian', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 11, 2, 315, 316, '', NULL, 'system', '2012-10-19 07:08:04', '', '2012-10-19 07:08:04'),
(211, 157, '12', 'Penataan Ruang', 'Penataan Ruang', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 12, 2, 317, 318, '', NULL, 'system', '2012-10-19 07:08:27', '', '2012-10-19 07:08:27'),
(212, 157, '13', 'Pengelolaan Wilayah Pesisir Dan Pulau-Pulau Kecil', 'Pengelolaan Wilayah Pesisir Dan Pulau-Pulau Kecil', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 13, 2, 319, 320, '', NULL, 'system', '2012-10-19 07:08:47', '', '2012-10-19 07:08:47'),
(213, 157, '14', 'Perubahan Ketiga atas Undang-Undang Nomor 6 Tahun 1983 Tentang Ketentuan Umum Dan Tata Cara Perpajak', 'Perubahan Ketiga atas Undang-Undang Nomor 6 Tahun 1983 Tentang Ketentuan Umum Dan Tata Cara Perpajak', '#nomor_urut_perkara#/Pid.Sus/#tahun#/PN #kode_pn#', '', 1, 'Y', 14, 2, 321, 322, '', NULL, 'system', '2012-10-19 07:09:13', '', '2012-10-19 07:09:13'),
(214, 157, '15', 'Penggunaan Bahan Kimia dan Larangan Penggunaan Bahan Kimia sebagai Senjata Kimia', 'Penggunaan Bahan Kimia dan Larangan Penggunaan Bahan Kimia sebagai Senjata Kimia', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 15, 2, 323, 324, '', NULL, 'system', '2012-10-19 07:09:34', '', '2012-10-19 07:09:34'),
(215, 157, '16', 'Pemilihan Umum Anggota Dewan Perwakilan Rakyat, Dewan Perwakilan Daerah, dan Dewan Perwakilan Rakyat', 'Pemilihan Umum Anggota Dewan Perwakilan Rakyat, Dewan Perwakilan Daerah, dan Dewan Perwakilan Rakyat', '#nomor_urut_perkara#/Pid.Sus/#tahun#/PN #kode_pn#', '', 1, 'Y', 16, 2, 325, 326, '', NULL, 'admin', '2014-06-24 16:27:21', '', '2014-06-24 16:27:21'),
(216, 157, '17', 'Informasi dan Transaksi Elektronik', 'Informasi dan Transaksi Elektronik', '#nomor_urut_perkara#/Pid.Sus/#tahun#/PN #kode_pn#', '', 1, 'Y', 17, 2, 327, 328, '', NULL, 'admin', '2015-02-26 11:25:55', '', '2015-02-26 11:25:55'),
(217, 157, '18', 'Perubahan atas Undang-Undang Nomor 32 Tahun 2004 tentang Pemerintahan Daerah', 'Perubahan atas Undang-Undang Nomor 32 Tahun 2004 tentang Pemerintahan Daerah', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 18, 2, 329, 330, '', NULL, 'system', '2012-10-19 07:10:33', '', '2012-10-19 07:10:33'),
(218, 157, '19', 'Penyelenggaraan Ibadah Haji', 'Penyelenggaraan Ibadah Haji', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 19, 2, 331, 332, '', NULL, 'system', '2012-10-19 07:10:49', '', '2012-10-19 07:10:49'),
(219, 157, '20', 'Keterbukaan Informasi Publik', 'Keterbukaan Informasi Publik', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 20, 2, 333, 334, '', NULL, 'admin2', '2014-05-05 11:09:15', '', '2014-05-05 11:09:15'),
(220, 157, '21', 'Pelayaran', 'Pelayaran', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 21, 2, 335, 336, '', NULL, 'system', '2012-10-19 07:11:51', '', '2012-10-19 07:11:51'),
(221, 157, '22', 'Surat Berharga Syariah Negara', 'Surat Berharga Syariah Negara', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 22, 2, 337, 338, '', NULL, 'system', '2012-10-19 07:12:09', '', '2012-10-19 07:12:09'),
(222, 157, '24', 'Pemilihan Umum Presiden dan Wakil Presiden', 'Pemilihan Umum Presiden dan Wakil Presiden', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 24, 2, 341, 342, '', NULL, 'system', '2012-10-19 07:12:46', '', '2012-10-19 07:12:46'),
(223, 157, '25', 'Wilayah Negara', 'Wilayah Negara', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 25, 2, 343, 344, '', NULL, 'system', '2012-10-19 07:13:06', '', '2012-10-19 07:13:06'),
(224, 157, '26', 'Pornografi', 'Pornografi', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 26, 2, 345, 346, '', NULL, 'admin2', '2014-05-05 11:09:26', '', '2014-05-05 11:09:26'),
(225, 157, '27', 'Penerbangan', 'Penerbangan', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 27, 2, 347, 348, '', NULL, 'system', '2012-10-19 07:13:46', '', '2012-10-19 07:13:46'),
(226, 157, '28', 'Lembaga Pembiayaan Ekspor Indonesia', 'Lembaga Pembiayaan Ekspor Indonesia', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 28, 2, 349, 350, '', NULL, 'system', '2012-10-19 07:14:05', '', '2012-10-19 07:14:05'),
(227, 157, '29', 'Pertambangan Mineral dan Batubara', 'Pertambangan Mineral dan Batubara', '#nomor_urut_perkara#/Pid.Sus/#tahun#/PN #kode_pn#', '', 1, 'Y', 29, 2, 351, 352, '', NULL, 'admin', '2014-10-20 09:30:06', '', '2014-10-20 09:30:06'),
(228, 157, '30', 'Perternakan Dan Kesehatan Hewan', 'Perternakan Dan Kesehatan Hewan', '#nomor_urut_perkara#/Pid.Sus/#tahun#/PN #kode_pn#', '', 1, 'Y', 30, 2, 353, 354, '', NULL, 'system', '2012-10-19 07:14:45', '', '2012-10-19 07:14:45'),
(229, 157, '31', 'Bendera, Bahasa, Dan Lambang Negara Serta Lagu Kebangsaan', 'Bendera, Bahasa, Dan Lambang Negara Serta Lagu Kebangsaan', '#nomor_urut_perkara#/Pid.Sus/#tahun#/PN #kode_pn#', '', 1, 'Y', 31, 2, 355, 356, '', NULL, 'system', '2012-10-19 07:16:34', '', '2012-10-19 07:16:34'),
(230, 157, '32', 'Pajak Daerah dan Retribusi Daerah', 'Pajak Daerah dan Retribusi Daerah', '#nomor_urut_perkara#/Pid.Sus/#tahun#/PN #kode_pn#', '', 1, 'Y', 32, 2, 357, 358, '', NULL, 'system', '2012-10-19 07:16:53', '', '2012-10-19 07:16:53'),
(231, 157, '33', 'Meteorologi, Klimatologi dan Geofisika', 'Meteorologi, Klimatologi dan Geofisika', '#nomor_urut_perkara#/Pid.Sus/#tahun#/PN #kode_pn#', '', 1, 'Y', 33, 2, 359, 360, '', NULL, 'system', '2012-10-19 07:17:15', '', '2012-10-19 07:17:15'),
(232, 157, '34', 'Perfilman', 'Perfilman', '#nomor_urut_perkara#/Pid.Sus/#tahun#/PN #kode_pn#', '', 1, 'Y', 34, 2, 361, 362, '', NULL, 'system', '2012-10-19 07:17:35', '', '2012-10-19 07:17:35'),
(233, 157, '35', 'Ketenagalistrikan', 'Ketenagalistrikan', '#nomor_urut_perkara#/Pid.Sus/#tahun#/PN #kode_pn#', '', 1, 'Y', 35, 2, 363, 364, '', NULL, 'system', '2012-10-19 07:17:56', '', '2012-10-19 07:17:56');
INSERT INTO `jenis_perkara` (`id`, `parent_id`, `kode`, `nama`, `nama_lengkap`, `format_nomor`, `keterangan`, `tipe_level`, `aktif`, `urutan`, `level`, `lft`, `rgt`, `diedit_oleh`, `diedit_tanggal`, `diinput_oleh`, `diinput_tanggal`, `diperbaharui_oleh`, `diperbaharui_tanggal`) VALUES
(234, 157, '36', 'Perlindungan dan Pengelolaan Lingkungan Hidup', 'Perlindungan dan Pengelolaan Lingkungan Hidup', '#nomor_urut_perkara#/Pid.Sus/#tahun#/PN #kode_pn#', '', 1, 'Y', 36, 2, 365, 366, '', NULL, 'system', '2012-10-19 07:18:31', '', '2012-10-19 07:18:31'),
(235, 157, '38', 'Kesehatan', 'Kesehatan', '#nomor_urut_perkara#/Pid.Sus/#tahun#/PN #kode_pn#', '', 1, 'Y', 38, 2, 369, 370, '', NULL, 'system', '2012-10-19 07:18:52', '', '2012-10-19 07:18:52'),
(236, 157, '39', 'Perlindungan Lahan Pertanian Pangan Berkelanjutan', 'Perlindungan Lahan Pertanian Pangan Berkelanjutan', '#nomor_urut_perkara#/Pid.Sus/#tahun#/PN #kode_pn#', '', 1, 'Y', 39, 2, 371, 372, '', NULL, 'system', '2012-10-19 07:19:13', '', '2012-10-19 07:19:13'),
(237, 157, '40', 'Kearsipan', 'Kearsipan', '#nomor_urut_perkara#/Pid.Sus/#tahun#/PN #kode_pn#', '', 1, 'Y', 40, 2, 373, 374, '', NULL, 'system', '2012-10-19 07:19:34', '', '2012-10-19 07:19:34'),
(238, 157, '41', 'Rumah Sakit', 'Rumah Sakit', '#nomor_urut_perkara#/Pid.Sus/#tahun#/PN #kode_pn#', '', 1, 'Y', 41, 2, 375, 376, '', NULL, 'system', '2012-10-19 07:19:55', '', '2012-10-19 07:19:55'),
(239, 157, '42', 'Perubahan atas Undang-Undang Nomor 31 tahun 2004 tentang Perikanan', 'Perubahan atas Undang-Undang Nomor 31 tahun 2004 tentang Perikanan', '#nomor_urut_perkara#/Pid.Sus/#tahun#/PN #kode_pn#', '', 1, 'Y', 42, 2, 377, 378, '', NULL, 'system', '2012-10-19 07:20:11', '', '2012-10-19 07:20:11'),
(240, 157, '43', 'Imigrasi', 'Imigrasi', '#nomor_urut_perkara#/Pid.Sus/#tahun#/PN #kode_pn#', '', 1, 'Y', 43, 2, 379, 380, '', NULL, 'system', '2012-10-19 07:20:54', '', '2012-10-19 07:20:54'),
(241, 4, 'P4', 'Gezeling', 'Gezeling', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 4, 3, 110, 111, '', NULL, 'admin2', '2014-05-05 10:57:44', '', '2014-05-05 10:57:44'),
(242, 4, 'P5', 'Akta Cerai', 'Akta Cerai', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 5, 3, 112, 113, '', NULL, 'admin2', '2014-05-05 10:58:00', '', '2014-05-05 10:58:00'),
(243, 4, 'P7', 'Pelaksanaan Arbitrase Internasional', 'Pelaksanaan Arbitrase Internasional', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 7, 3, 116, 117, '', NULL, 'system', '2012-10-19 08:21:09', '', '2012-10-19 08:21:09'),
(244, 4, 'P8', 'Pelaksanaan Arbitrase Nasional', 'Pelaksanaan Arbitrase Nasional', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 8, 3, 118, 119, '', NULL, 'system', '2012-10-19 08:21:31', '', '2012-10-19 08:21:31'),
(245, 4, 'P9', 'Pembatalan Putusan Arbitrase Internasional', 'Pembatalan Putusan Arbitrase Internasional', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 9, 3, 120, 121, '', NULL, 'system', '2012-10-19 08:21:52', '', '2012-10-19 08:21:52'),
(246, 4, 'P10', 'Somasi', 'Somasi', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', '', 1, 'Y', 10, 3, 122, 123, '', NULL, 'system', '2012-10-19 08:22:52', '', '2012-10-19 08:22:52'),
(247, 168, NULL, 'Pelanggaran Pramuwisata', 'Pelanggaran/Pelanggaran Pramuwisata', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', NULL, 1, 'Y', 10, 3, 296, 297, NULL, NULL, 'admin', '2012-12-12 08:00:39', NULL, '2012-12-12 08:00:39'),
(248, 157, NULL, 'Perlindungan Anak', 'Perlindungan Anak', '#nomor_urut_perkara#/Pid.Sus/#tahun#/PN #kode_pn#', 'Perlindungan Anak', 1, 'Y', 71, 2, 435, 436, NULL, NULL, 'admin', '2014-06-17 12:27:39', NULL, '2014-06-17 12:27:39'),
(249, 158, 'PRA', 'Praperadilan', 'Pidana Praperadilan', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', 'Pidana PraPeradilan', 1, 'Y', 4, 2, 445, 446, NULL, NULL, 'admin', '2015-05-24 07:07:46', NULL, '2015-05-24 07:07:46'),
(250, 158, NULL, 'Sah atau tidaknya penangkapan', 'Pidana Praperadilan/Sah atau tidaknya penangkapan', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', NULL, 1, 'Y', 4, 2, 447, 448, NULL, NULL, 'admin', '2015-05-24 07:11:21', NULL, '2015-05-24 07:11:21'),
(251, 158, NULL, 'Sah atau tidaknya penahanan', 'Pidana Praperadilan/Sah atau tidaknya penahanan', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', NULL, 1, 'Y', 4, 2, 449, 450, NULL, NULL, NULL, NULL, NULL, NULL),
(252, 158, NULL, 'Sah atau tidaknya penghentian penyidikan', 'Pidana Praperadilan/Sah atau tidaknya penghentian penyidikan', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', NULL, 1, 'Y', 4, 2, 451, 452, NULL, NULL, NULL, NULL, NULL, NULL),
(253, 158, NULL, 'Sah atau tidaknya penghentian penuntutan', 'Pidana Praperadilan/Sah atau tidaknya penghentian penuntutan', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', NULL, 1, 'Y', 4, 2, 453, 454, NULL, NULL, NULL, NULL, NULL, NULL),
(254, 158, NULL, 'Ganti kerugian dan rehabilitasi', 'Pidana Praperadilan/Ganti kerugian dan rehabilitasi', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', NULL, 1, 'Y', 4, 2, 455, 456, NULL, NULL, NULL, NULL, NULL, NULL),
(255, 158, NULL, 'Ganti kerugian', 'Pidana Praperadilan/Ganti kerugian', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', NULL, 1, 'Y', 4, 2, 457, 458, NULL, NULL, NULL, NULL, NULL, NULL),
(256, 158, NULL, 'Rehabilitasi', 'Pidana Praperadilan/Rehabilitasi', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', NULL, 1, 'Y', 4, 2, 459, 460, NULL, NULL, NULL, NULL, NULL, NULL),
(257, 158, NULL, 'Sah atau tidaknya penetapan tersangka', 'Pidana Praperadilan/Sah atau tidaknya penetapan tersangka', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', NULL, 1, 'Y', 4, 2, 461, 462, NULL, NULL, NULL, NULL, NULL, NULL),
(258, 158, NULL, 'Sah atau tidaknya penyitaan', 'Pidana Praperadilan/Sah atau tidaknya penyitaan', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', NULL, 1, 'Y', 4, 2, 463, 464, NULL, NULL, NULL, NULL, NULL, NULL),
(259, 158, NULL, 'Sah atau tidaknya penggeledahan', 'Pidana Praperadilan/Sah atau tidaknya penggeledahan', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', NULL, 1, 'Y', 4, 2, 465, 466, NULL, NULL, NULL, NULL, NULL, NULL),
(261, 337, NULL, 'Pengkhianatan Militer', 'Pengkhianatan Militer', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(262, 337, NULL, 'Kejahatan Penerbangan dan Kejahatan Terhadap Sarana/Prasarana Penerbangan', 'Kejahatan Penerbangan dan Kejahatan Terhadap Sarana/Prasarana Penerbangan', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(263, 337, NULL, 'Pemberontakan Militer', 'Pemberontakan Militer', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(264, 337, NULL, 'Mangkir', 'Mangkir', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(265, 337, NULL, 'Desersi', 'Desersi', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(267, 337, NULL, 'Penghinaan Terhadap Atasan', 'Penghinaan Terhadap Atasan', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(268, 337, NULL, 'Menantang Atasan untuk Berkelahi/Duel', 'Menantang Atasan untuk Berkelahi/Duel', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(269, 337, NULL, 'Ketidaktaatan Militer terhadap Perintah Dinas', 'Ketidaktaatan Militer terhadap Perintah Dinas', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(270, 337, NULL, 'Mengancam dengan Kekerasan Terhadap Atasan', 'Mengancam dengan Kekerasan Terhadap Atasan', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(271, 337, NULL, 'Dengan Sengaja Dengan Tindakan Nyata Menyerang Seorang Atasan', 'Dengan Sengaja Dengan Tindakan Nyata Menyerang Seorang Atasan', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(272, 337, NULL, 'Insubordinasi', 'Insubordinasi', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(273, 337, NULL, 'Pencurian Militer', 'Pencurian Militer', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(274, 337, NULL, 'Meninggalkan Pos Penjagaan', 'Meninggalkan Pos Penjagaan', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(275, 337, NULL, 'Menarik Diri dari Kewajiban Dinas', 'Menarik Diri dari Kewajiban Dinas', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(276, 337, NULL, 'Lalai Untuk Meneruskan Suatu Pemberitahuan', 'Lalai Untuk Meneruskan Suatu Pemberitahuan', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(277, 337, NULL, 'Penyalahgunaan Kekuasaan', 'Penyalahgunaan Kekuasaan', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(278, 337, NULL, 'Penghinaan Terhadap Bawahan', 'Penghinaan Terhadap Bawahan', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(279, 337, NULL, 'Pencurian dan Penadahan', 'Pencurian dan Penadahan', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(280, 337, NULL, 'Penganiayaan Terhadap Bawahan', 'Penganiayaan Terhadap Bawahan', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(281, 337, NULL, 'Pengrusakan/Pembinasaan/Penghilangan/Menjual Barang-barang Angkatan Perang', 'Pengrusakan/Pembinasaan/Penghilangan/Menjual Barang-barang Angkatan Perang', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(286, 336, NULL, 'Kejahatan yang Membahayakan Keamanan Umum bagi Orang atau Barang', 'Kejahatan yang Membahayakan Keamanan Umum bagi Orang atau Barang', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(290, 336, NULL, 'Pemalsuan Meterai dan Merk', 'Pemalsuan Meterai dan Merk', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(292, 336, NULL, 'Kejahatan Terhadap Asal Usul dan Perkawinan', 'Kejahatan Terhadap Asal Usul dan Perkawinan', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(293, 336, NULL, 'Kesusilaan', 'Kesusilaan', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(297, 336, NULL, 'Merampas Kemerdekaan', 'Merampas Kemerdekaan', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(306, 336, NULL, 'Penghancuran/Perusakan Barang', 'Penghancuran/Perusakan Barang', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(309, 336, NULL, 'Penadahan, Pencetakan dan Penerbitan', 'Penadahan, Pencetakan dan Penerbitan', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(311, 336, NULL, 'Penghapusan Kekerasan Dalam Rumah Tangga', 'Penghapusan Kekerasan Dalam Rumah Tangga', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(313, 336, NULL, 'Jaminan Fidusia', 'Jaminan Fidusia', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(314, 336, NULL, 'Pemberantasan Tindak Pidana Korupsi', 'Pemberantasan Tindak Pidana Korupsi', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(315, 336, NULL, 'Ilegal Logging', 'Ilegal Logging', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(316, 336, NULL, 'Senjata Api', 'Senjata Api', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(317, 336, NULL, 'Lalu-Lintas', 'Lalu-Lintas', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(318, NULL, NULL, 'Pertanahan', 'Pertanahan', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PTUN.#kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(319, NULL, NULL, 'Kepegawaian', 'Kepegawaian', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PTUN.#kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(320, NULL, NULL, 'Pajak', 'Pajak', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PTUN.#kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(321, NULL, NULL, 'Perijinan', 'Perijinan', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PTUN.#kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(322, NULL, NULL, 'Lelang', 'Lelang', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PTUN.#kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(323, NULL, NULL, 'Tender', 'Tender', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PTUN.#kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(324, NULL, NULL, 'HAKI', 'HAKI', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PTUN.#kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(325, NULL, NULL, 'Badan Hukum', 'Badan Hukum', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PTUN.#kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(326, NULL, NULL, 'Kehutanan', 'Kehutanan', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PTUN.#kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(328, NULL, NULL, 'Pemilukada', 'Pemilukada', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PTUN.#kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(331, NULL, NULL, 'Permohonan UU AP', 'Permohonan UU AP', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PTUN.#kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(332, NULL, NULL, 'Pengadaan Tanah Untuk Kepentingan Umum', 'Pengadaan Tanah Untuk Kepentingan Umum', '#nomor_urut_perkara#/G/PU/#tahun#/PTUN.#kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(333, NULL, NULL, 'Permohonan Fiktif Positif', 'Permohonan Fiktif Positif', '#nomor_urut_perkara#/P/FP/#tahun#/PTUN.#kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(334, NULL, NULL, 'Pengujian Penyalahgunaan Wewenang', 'Pengujian Penyalahgunaan Wewenang', '#nomor_urut_perkara#/P/PW/#tahun#/PTUN.#kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(335, NULL, NULL, 'Keterbukaan Informasi Publik (KIP)', 'Keterbukaan Informasi Publik (KIP)', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PTUN.#kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(336, NULL, NULL, 'KUHP', 'KHUP', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(337, NULL, NULL, 'KUHPM', 'KUHPM', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(340, NULL, NULL, 'Lalu lintas dan Angkutan Jalan ', 'Lalu lintas dan angkutan jalan ', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(341, NULL, NULL, 'Izin Poligami', 'Izin Poligami', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/#kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(342, NULL, NULL, 'Pencegahan Perkawinan', 'Pencegahan Perkawinan', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/#kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(343, NULL, NULL, 'Penolakan Perkawinan', 'Penolakan Perkawinan oleh PPN', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/#kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(345, NULL, NULL, 'Kelalaian Atas Kewajiban Suami / Istri', 'Kelalaian Atas Kewajiban Suami / Istri', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/#kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(346, NULL, NULL, 'Cerai Talak', 'Cerai Talak', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/#kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(347, NULL, NULL, 'Cerai Gugat', 'Cerai Gugat', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/#kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(349, NULL, NULL, 'Penguasaan Anak', 'Penguasaan Anak', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/#kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(350, NULL, NULL, 'Nafkah Anak Oleh Ibu karena Ayah tidak mampu', 'Nafkah Anak Oleh Ibu karena Ayah tidak mampu', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/#kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(351, NULL, NULL, 'Hak - hak bekas istri/kewajiban bekas Suami', 'Hak - hak bekas istri/kewajiban bekas Suami', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/#kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(352, NULL, NULL, 'Pengesahan Anak', 'Pengesahan Anak', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/#kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(353, NULL, NULL, 'Pencabutan Kekuasaan Orang Tua', 'Pencabutan Kekuasaan Orang Tua', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/#kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(354, NULL, NULL, 'Perwalian', 'Perwalian', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/#kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(355, NULL, NULL, 'Pencabutan Kekuasaan Wali', 'Pencabutan Kekuasaan Wali', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/#kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(356, NULL, NULL, 'Penunjukan orang lain sebagai Wali oleh Pengadilan', 'Penunjukan orang lain sebagai Wali oleh Pengadilan', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/#kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(357, NULL, NULL, 'Ganti Rugi terhadap Wali', 'Ganti Rugi terhadap Wali', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/#kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(358, NULL, NULL, 'Asal Usul Anak', 'Asal Usul Anak', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/#kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(359, NULL, NULL, 'Perkawinan Campuran', 'Penolakan Kawin Campuran', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/#kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(360, NULL, NULL, 'Pengesahan Perkawinan/Istbat Nikah', 'Pengesahan Perkawinan/Istbat Nikah', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/#kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(361, NULL, NULL, 'Izin Kawin', 'Izin Kawin', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/#kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(362, NULL, NULL, 'Dispensasi Kawin', 'Dispensasi Kawin', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/#kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(363, NULL, NULL, 'Wali Adhol', 'Wali Adhol', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/#kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(364, NULL, NULL, 'Kewarisan', 'Kewarisan', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/#kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(365, NULL, NULL, 'Wasiat', 'Wasiat', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/#kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(367, NULL, NULL, 'Wakaf', 'Wakaf', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/#kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(370, NULL, NULL, 'Ekonomi Syariah', 'Ekonomi Syariah', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/#kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(371, NULL, NULL, 'P3HP/Penetapan Ahli Waris', 'P3HP/Penetapan Ahli Waris', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/#kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(372, 3, 'LH', 'Perdata Lingkungan Hidup', 'Perdata Lingkungan Hidup', '#nomor_urut_perkara#/Pdt.Sus-LH/#tahun#/PN #kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(373, 372, NULL, 'Pencemaran Air', 'Lingkungan Hidup/Pencemaran Air', '#nomor_urut_perkara#/Pdt.Sus-LH/#tahun#/PN #kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(374, 372, NULL, 'Pencemaran Udara dan Gangguan (Kebisingan,Getaran dan Kebauan)', 'Lingkungan Hidup/Pencemaran Udara dan Gangguan (Kebisingan,Getaran dan Kebauan)', '#nomor_urut_perkara#/Pdt.Sus-LH/#tahun#/PN #kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(375, 372, NULL, 'Pencemaran Tanah', 'Lingkungan Hidup/Pencemaran Tanah', '#nomor_urut_perkara#/Pdt.Sus-LH/#tahun#/PN #kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(376, 372, NULL, 'Pencemaran Laut', 'Lingkungan Hidup/Pencemaran Laut', '#nomor_urut_perkara#/Pdt.Sus-LH/#tahun#/PN #kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(377, 372, NULL, 'Kerusakan Terumbu Karang, Hutan Bakau(Mangrove), Lautan dan Pesisir', 'Lingkungan Hidup/Kerusakan Terumbu Karang, Hutan Bakau(Mangrove), Lautan dan Pesisir', '#nomor_urut_perkara#/Pdt.Sus-LH/#tahun#/PN #kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(378, 372, NULL, 'Kebakaran Hutan', 'Lingkungan Hidup/Kebakaran Hutan', '#nomor_urut_perkara#/Pdt.Sus-LH/#tahun#/PN #kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(379, 372, NULL, 'Penebangan Kayu', 'Lingkungan Hidup/Penebangan Kayu', '#nomor_urut_perkara#/Pdt.Sus-LH/#tahun#/PN #kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(380, 372, NULL, 'Perubahan Kawasan Alam/Tata Ruang', 'Lingkungan Hidup/Perubahan Kawasan Alam/Tata Ruang', '#nomor_urut_perkara#/Pdt.Sus-LH/#tahun#/PN #kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(381, 372, NULL, 'Tanaman Yang Dilindungi', 'Lingkungan Hidup/Tanaman Yang Dilindungi', '#nomor_urut_perkara#/Pdt.Sus-LH/#tahun#/PN #kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(382, 372, NULL, 'Kerusakan Lingkungan Akibat Kegiatan Pertambangan(Mineral,Batu Bara), Minyak dan Gas Bumi', 'Lingkungan Hidup/Kerusakan Lingkungan Akibat Kegiatan Pertambangan(Mineral,Batu Bara), Minyak dan Gas Bumi', '#nomor_urut_perkara#/Pdt.Sus-LH/#tahun#/PN #kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(383, 372, NULL, 'Konservasi Sumber Daya Alam', 'Lingkungan Hidup/Konservasi Sumber Daya Alam', '#nomor_urut_perkara#/Pdt.Sus-LH/#tahun#/PN #kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(384, 372, NULL, 'Limbah Bahan Beracun Berbahaya (B3)', 'Lingkungan Hidup/Limbah Bahan Beracun Berbahaya (B3)', '#nomor_urut_perkara#/Pdt.Sus-LH/#tahun#/PN #kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(385, 372, NULL, 'Reklamasi Pantai', 'Lingkungan Hidup/Reklamasi Pantai', '#nomor_urut_perkara#/Pdt.Sus-LH/#tahun#/PN #kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(386, 372, NULL, 'Pembuangan Limbah', 'Lingkungan Hidup/Pembuangan Limbah', '#nomor_urut_perkara#/Pdt.Sus-LH/#tahun#/PN #kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(387, 372, NULL, 'Penangkapan Ikan (dengan racun, bahan peledak/bom ikan)', 'Lingkungan Hidup/Penangkapan Ikan (dengan racun, bahan peledak/bom ikan)', '#nomor_urut_perkara#/Pdt.Sus-LH/#tahun#/PN #kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(388, 372, NULL, 'Perubahan Iklim', 'Lingkungan Hidup/Perubahan Iklim', '#nomor_urut_perkara#/Pdt.Sus-LH/#tahun#/PN #kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(389, 372, NULL, 'Gugatan Terhadap Aktivis Lingkungan Hidup/Warga/Masyarakat yang memperjuangkan lingkungan hidup', 'Lingkungan Hidup/Gugatan Terhadap Aktivis Lingkungan Hidup/Warga/Masyarakat yang memperjuangkan lingkungan hidup', '#nomor_urut_perkara#/Pdt.Sus-LH/#tahun#/PN #kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(390, 372, NULL, 'Hal-hal yang mengakibatkan kerusakan dan pencemaran lingkungan', 'Lingkungan Hidup/Hal-hal yang mengakibatkan kerusakan dan pencemaran lingkungan', '#nomor_urut_perkara#/Pdt.Sus-LH/#tahun#/PN #kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(391, 372, NULL, 'Satwa Liar (Penangkapan,Perdagangan dll)', 'Lingkungan Hidup/Satwa Liar (Penangkapan,Perdagangan dll)', '#nomor_urut_perkara#/Pdt.Sus-LH/#tahun#/PN #kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(392, 2, 'LH', 'Pidana Lingkungan Hidup', 'Pidana Lingkungan Hidup', '#nomor_urut_perkara#/Pid.Sus-LH/#tahun#/PN #kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(500, NULL, NULL, 'Ikhtilath', 'Ikhtilath', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/#kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(501, NULL, NULL, 'Khamar', 'Khamar', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/#kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(502, NULL, NULL, 'Khalwat', 'Khalwat', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/#kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(503, NULL, NULL, 'Liwath', 'Liwath', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/#kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(504, NULL, NULL, 'Maisir', 'Maisir', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/#kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(505, NULL, NULL, 'Musahaqah', 'Musahaqah', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/#kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(506, NULL, NULL, 'Pelecehan Seksual', 'Pelecehan Seksual', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/#kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(507, NULL, NULL, 'Pemerkosaan', 'Pemerkosaan', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/#kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(508, NULL, NULL, 'Qadzaf', 'Qadzaf', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/#kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(509, NULL, NULL, 'Zina', 'Zina', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/#kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(621, 337, NULL, 'THTI', 'THTI', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(622, 119, NULL, 'Keberatan atas ganti kerugian pengadaan tanah bagi pembangunan untuk kepentingan umum', 'Objek Sengketa Bukan Tanah/Keberatan atas ganti kerugian pengadaan tanah bagi pembangunan untuk kepentingan umum', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', NULL, 1, 'Y', 10, 4, 87, 88, '', NULL, 'admin2', '2016-10-03 11:50:31', '', NULL),
(624, NULL, NULL, 'Gugatan Memperoleh Akta Perdamaian Atas Kesepakatan Perdamaian di Luar Pengadilan', 'Gugatan Memperoleh Akta Perdamaian Atas Kesepakatan Perdamaian di Luar Pengadilan', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, 'admin2', '2016-11-24 16:21:26', '', NULL),
(625, NULL, NULL, 'Sengketa Proses Pemilihan Umum', 'Sengketa Proses Pemilihan Umum', '#nomor_urut_perkara#/G/SPPU/#tahun#/PTUN.#kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, 'admin', '2018-03-31 11:45:40', '', NULL),
(627, NULL, NULL, 'Gugatan Perwakilan Kelompok (Class Action)', 'Gugatan Perwakilan Kelompok (Class Action)', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, 'admin', '2018-03-31 11:45:40', '', NULL),
(628, NULL, NULL, 'Gugatan Warga Negara (Citizen Law Suit)', 'Gugatan Warga Negara (Citizen Law Suit)', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, 'admin', '2018-03-31 11:45:40', '', NULL),
(630, NULL, NULL, 'Penitipan Ganti Kerugian', 'Penitipan Ganti Kerugian', '#nomor_urut_perkara#/Pdt.P-Kons/#tahun#/PN #kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(631, NULL, NULL, 'Penitipan Pembayaran Hutang', 'Penitipan Pembayaran Hutang', '#nomor_urut_perkara#/Pdt.P-Kons/#tahun#/PN #kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(633, 157, NULL, 'Pemilihan Gubernur, Bupati, dan Walikota', 'Pemilihan Gubernur, Bupati, dan Walikota', '#nomor_urut_perkara#/Pid.Sus/#tahun#/PN #kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(634, NULL, NULL, 'Gugatan Actio Pauliana', 'Gugatan Actio Pauliana', '#nomor_urut_perkara#/Pdt.Sus-Pailit-GLL/#tahun#/PN.Niaga #kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(635, NULL, NULL, 'Permohonan Renvoi Prosedur', 'Permohonan Renvoi Prosedur', '#nomor_urut_perkara#/Pdt.Sus-Pailit-Renvoi/#tahun#/PN.Niaga #kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(636, NULL, NULL, 'Perlawanan Atas Boedel Pailit', 'Perlawanan Atas Boedel Pailit', '#nomor_urut_perkara#/Pdt.Sus-Pailit/#tahun#/PN.Niaga #kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(637, NULL, NULL, 'Pengesahan Perdamaian', 'Pengesahan Perdamaian', '#nomor_urut_perkara#/Pdt.Sus-Pailit-Pengesahan Perdamaian/#tahun#/PN.Niaga #kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(638, NULL, NULL, 'Pembatalan Perdamaian', 'Pembatalan Perdamaian', '#nomor_urut_perkara#/Pdt.Sus-Pailit-Pembatalan Perdamaian/#tahun#/PN.Niaga #kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(639, NULL, NULL, 'Pembetulan Berita Acara Rapat Pemungutan Suara', 'Pembetulan Berita Acara Rapat Pemungutan Suara', '#nomor_urut_perkara#/Pdt.Sus-Pailit/#tahun#/PN.Niaga #kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(640, NULL, NULL, 'Permohonan Pencabutan Pernyataan Pailit', 'Permohonan Pencabutan Pernyataan Pailit', '#nomor_urut_perkara#/Pdt.Sus-Pailit/#tahun#/PN.Niaga #kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(641, NULL, NULL, 'Keberatan Atas Pembagian Harta Pailit', 'Keberatan Atas Pembagian Harta Pailit', '#nomor_urut_perkara#/Pdt.Sus-Pailit-Keberatan Daftar Pembagian/#tahun#/PN.Niaga #kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(642, NULL, NULL, 'Penggantian Dan Penambahan Kurator', 'Penggantian Dan Penambahan Kurator', '#nomor_urut_perkara#/Pdt.Sus-Pailit/#tahun#/PN.Niaga #kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(643, NULL, NULL, 'Penentuan Biaya Kepailitan Dan Imbalan Jasa Kurator', 'Penentuan Biaya Kepailitan Dan Imbalan Jasa Kurator', '#nomor_urut_perkara#/Pdt.Sus-Pailit/#tahun#/PN.Niaga #kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(644, NULL, NULL, 'Permohonan Rehabilitasi', 'Permohonan Rehabilitasi', '#nomor_urut_perkara#/Pdt.Sus-Pailit-Rehabilitasi/#tahun#/PN.Niaga #kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(645, NULL, NULL, 'Permohonan Pencabutan PKPU', 'Permohonan Pencabutan PKPU', '#nomor_urut_perkara#/Pdt.Sus-Pailit/#tahun#/PN.Niaga #kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(646, NULL, NULL, 'Perlawanan Pihak Ketiga Terhadap Penyitaan Boedel Pailit', 'Perlawanan Pihak Ketiga Terhadap Penyitaan Boedel Pailit', '#nomor_urut_perkara#/Pdt.Sus-Pailit-GLL/#tahun#/PN.Niaga #kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(647, NULL, NULL, 'Lainnya', 'Lainnya', '#nomor_urut_perkara#/Pdt.Sus-Pailit-GLL/#tahun#/PN.Niaga #kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(648, NULL, NULL, 'Perbedaan Pendapat', 'Perbedaan Pendapat', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/PP/#matra#/#bulan#/#tahun#', 'Dilmiltama sbg pengadilan tingkat pertama dalam perkara Perbedaan Pendapat', 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(649, NULL, NULL, 'Kepala Desa dan Perangkat Desa', 'Kepala Desa dan Perangkat Desa', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PTUN.#kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, 'omsteevee', '2022-02-10 09:19:52', '', NULL),
(650, NULL, NULL, 'Kepala Daerah', 'Kepala Daerah', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PTUN.#kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, 'omsteevee', '2022-02-10 09:20:43', '', NULL),
(651, NULL, NULL, 'Ketenagakerjaan', 'Ketenagakerjaan', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PTUN.#kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, 'omsteevee', '2022-02-10 09:21:23', '', NULL),
(652, NULL, NULL, 'Pergantian Antar Waktu (PAW)', 'Pergantian Antar Waktu (PAW)', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PTUN.#kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, 'omsteevee', '2022-02-10 09:22:05', '', NULL),
(653, NULL, NULL, 'Pengadaan Tanah', 'Pengadaan Tanah', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PTUN.#kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, 'omsteevee', '2022-02-10 09:22:45', '', NULL),
(655, NULL, NULL, 'Tindakan Administrasi Pemerintah/Tindakan Faktual', 'Tindakan Administrasi Pemerintah/Tindakan Faktual', '#nomor_urut_perkara#/G/TF/#tahun#/PTUN.#kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, 'omsteevee', '2022-02-10 10:16:56', '', NULL),
(656, NULL, NULL, 'Pembatalan Arbitrase Syariah', 'Pembatalan Arbitrase Syariah', '#nomor_urut_perkara#/Pdt.Sus-Arb/#tahun#/PN #kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(658, 337, NULL, 'Pemata-mataan (Spionase)', 'Pemata-mataan (Spionase)', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(659, 337, NULL, 'Tawanan Perang yang Melarikan Diri', 'Tawanan Perang yang Melarikan Diri', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(660, 337, NULL, 'Militer Interniran yang Melarikan Diri', 'Militer Interniran yang Melarikan Diri', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(661, 337, NULL, 'Perbuatan yang Dapat Mendatangkan Timbulnya Perang', 'Perbuatan yang Dapat Mendatangkan Timbulnya Perang', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(662, 337, NULL, 'Membocorkan Rahasia Upaya Pertahanan (Anti Spionase)', 'Membocorkan Rahasia Upaya Pertahanan (Anti Spionase)', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(663, 337, NULL, 'Penyerahan Daerah/Tempat/Pos kepada Musuh', 'Penyerahan Daerah/Tempat/Pos kepada Musuh', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(664, 337, NULL, 'Menyerahkan Diri/Memberi Tanda Menyerah tanpa Perintah', 'Menyerahkan Diri/Memberi Tanda Menyerah tanpa Perintah', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(665, 337, NULL, 'Melarikan Diri/Merusak Peralatan Perang', 'Melarikan Diri/Merusak Peralatan Perang', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(666, 337, NULL, 'Menggagalkan Suatu Operasi Militer', 'Menggagalkan Suatu Operasi Militer', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(667, 337, NULL, 'Membocorkan Informasi Perang', 'Membocorkan Informasi Perang', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(668, 337, NULL, 'Ketidaktaatan Perintah/Penolakan Tuntutan dalam Waktu Perang', 'Ketidaktaatan Perintah/Penolakan Tuntutan dalam Waktu Perang', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(669, 337, NULL, 'Melanggar Ketentuan dalam Perjanjian Perang', 'Melanggar Ketentuan dalam Perjanjian Perang', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(670, 337, NULL, 'Mengambil Barang Tidak Termasuk Rampasan Perang', 'Mengambil Barang Tidak Termasuk Rampasan Perang', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(671, 337, NULL, 'Merusak Suatu Perjanjian dengan Musuh', 'Merusak Suatu Perjanjian dengan Musuh', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(672, 337, NULL, 'Hilangnya Pos Akibat Kelalaian/Gagalnya Operasi Militer pada Saat Perang', 'Hilangnya Pos Akibat Kelalaian/Gagalnya Operasi Militer pada Saat Perang', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(673, 337, NULL, 'Sangkaan/Aduan/Laporan Palsu Terhadap Atasan', 'Sangkaan/Aduan/Laporan Palsu Terhadap Atasan', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(674, 337, NULL, 'Pengacauan Militer', 'Pengacauan Militer', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(675, 337, NULL, 'Menarik Diri dari Dinas yang Berbahaya', 'Menarik Diri dari Dinas yang Berbahaya', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(676, 337, NULL, 'Menyampaikan Pemberitahuan Jabatan yang Tidak Benar kepada Penguasa', 'Menyampaikan Pemberitahuan Jabatan yang Tidak Benar kepada Penguasa', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(677, 337, NULL, 'Menghalangi Tindakan Dinas', 'Menghalangi Tindakan Dinas', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(678, 337, NULL, 'Ketidaktaatan terhadap Peraturan Dinas yang Ditetapkan Presiden', 'Ketidaktaatan terhadap Peraturan Dinas yang Ditetapkan Presiden', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(679, 337, NULL, 'Penyalahgunaan Pengaruh terhadap Bawahan', 'Penyalahgunaan Pengaruh terhadap Bawahan', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(680, 337, NULL, 'Menghindarkan Diri Sendiri/Orang Lain dari Pemidanaan', 'Menghindarkan Diri Sendiri/Orang Lain dari Pemidanaan', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(681, 337, NULL, 'Memerintahkan Bawahan Melampaui Hak/Keadaan yang Asing Bagi Kepentingan Dinas', 'Memerintahkan Bawahan Melampaui Hak/Keadaan yang Asing Bagi Kepentingan Dinas', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(682, 337, NULL, 'Mengizinkan Bawahan Melakukan Kejahatan', 'Mengizinkan Bawahan Melakukan Kejahatan', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(683, 337, NULL, 'Mengabaikan Kewajiban Lapor Adanya Kejahatan Tertentu', 'Mengabaikan Kewajiban Lapor Adanya Kejahatan Tertentu', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(684, 337, NULL, 'Penghasutan Militer untuk Melakukan Kejahatan', 'Penghasutan Militer untuk Melakukan Kejahatan', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(685, 337, NULL, 'Melemahkan Disiplin Militer', 'Melemahkan Disiplin Militer', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(686, 337, NULL, 'Mempengaruhi Kesiapsiagaan Perang', 'Mempengaruhi Kesiapsiagaan Perang', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(687, 337, NULL, 'Kekerasan Terhadap Korban Perang', 'Kekerasan Terhadap Korban Perang', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(688, 337, NULL, 'Tidak Memenuhi Kewajiban dalam Bela Negara', 'Tidak Memenuhi Kewajiban dalam Bela Negara', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(689, 337, NULL, 'Perampokan Militer', 'Perampokan Militer', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(690, 337, NULL, 'Penadahan Militer', 'Penadahan Militer', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(691, 337, NULL, 'Pengulangan (Residive) Pencurian/Penadahan Militer', 'Pengulangan (Residive) Pencurian/Penadahan Militer', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(692, 336, NULL, 'Kejahatan-kejahatan Terhadap Idiologi Negara', 'Kejahatan-kejahatan Terhadap Idiologi Negara', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(694, 336, NULL, 'Kejahatan Terhadap Negara Sahabat dan Terhadap Kepala Negara Sahabat dan atau Wakilnya', 'Kejahatan Terhadap Negara Sahabat dan Terhadap Kepala Negara Sahabat dan atau Wakilnya', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(695, 336, NULL, 'Penistaan Agama', 'Penistaan Agama', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(696, 336, NULL, 'Masuk Rumah/Pekarangan Orang Tanpa Izin', 'Masuk Rumah/Pekarangan Orang Tanpa Izin', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(697, 336, NULL, 'Kekerasan Terhadap Orang/Barang', 'Kekerasan Terhadap Orang/Barang', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(698, 336, NULL, 'Obstruction of Justice', 'Obstruction of Justice', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(699, 336, NULL, 'Pemalsuan Materai dan Merk', 'Pemalsuan Materai dan Merk', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(700, 336, NULL, 'Perzinahan', 'Perzinahan', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(701, 336, NULL, 'Perkosaan', 'Perkosaan', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(702, 336, NULL, 'Pencabulan', 'Pencabulan', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(703, 336, NULL, 'Pengobatan untuk Mengugurkan Kandungan', 'Pengobatan untuk Mengugurkan Kandungan', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(704, 336, NULL, 'Perjudian', 'Perjudian', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(705, 336, NULL, 'Fitnah', 'Fitnah', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(706, 336, NULL, 'Penculikan', 'Penculikan', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(707, 336, NULL, 'Pemaksaan', 'Pemaksaan', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(708, 336, NULL, 'Pengguguran Kandungan (Aborsi)', 'Pengguguran Kandungan (Aborsi)', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(711, NULL, NULL, 'TP SUS/MIN', 'TP SUS/MIN', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(712, 711, NULL, 'Peraturan Hukum Pidana', 'Peraturan Hukum Pidana', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(713, 711, NULL, 'Senjata Api/Senjata Tajam', 'Senjata Api/Senjata Tajam', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(714, 711, NULL, 'Penangkapan, Pengangkutan dan Perdagangan Satwa Liar', 'Penangkapan, Pengangkutan dan Perdagangan Satwa Liar', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(715, 711, NULL, 'Perbankan', 'Perbankan', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(717, 711, NULL, 'Korupsi', 'Korupsi', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(718, 711, NULL, 'Minyak dan Gas Bumi (Illegal Drilling dan Illegal Tapping)', 'Minyak dan Gas Bumi (Illegal Drilling dan Illegal Tapping)', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(719, 711, NULL, 'Kekerasan Dalam Rumah Tangga (KDRT)', 'Kekerasan Dalam Rumah Tangga (KDRT)', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL);
INSERT INTO `jenis_perkara` (`id`, `parent_id`, `kode`, `nama`, `nama_lengkap`, `format_nomor`, `keterangan`, `tipe_level`, `aktif`, `urutan`, `level`, `lft`, `rgt`, `diedit_oleh`, `diedit_tanggal`, `diinput_oleh`, `diinput_tanggal`, `diperbaharui_oleh`, `diperbaharui_tanggal`) VALUES
(720, 711, NULL, 'Kepabeanan', 'Kepabeanan', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(721, 711, NULL, 'Perdagangan Orang (Human Trafficking)', 'Perdagangan Orang (Human Trafficking)', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(724, 711, NULL, 'Pertambangan (Illegal Mining)', 'Pertambangan (Illegal Mining)', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(726, 711, NULL, 'Bendera, Bahasa dan Lambang Negara serta Lagu Kebangsaan', 'Bendera, Bahasa dan Lambang Negara serta Lagu Kebangsaan', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(728, 711, NULL, 'Lingkungan Hidup', 'Lingkungan Hidup', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(730, 711, NULL, 'Perikanan (Illegal Fishing)', 'Perikanan (Illegal Fishing)', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(731, 711, NULL, 'Pencucian Uang/TPPU', 'Pencucian Uang/TPPU', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(733, 711, NULL, 'Peredaran Uang Palsu', 'Peredaran Uang Palsu', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(734, 711, NULL, 'Kehutanan/Illegal Logging', 'Kehutanan/Illegal Logging', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(736, 711, NULL, 'Tenaga Kesehatan (Malapraktik)', 'Tenaga Kesehatan (Malapraktik)', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(737, 711, NULL, 'Peternakan dan Kesehatan Hewan', 'Peternakan dan Kesehatan Hewan', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(738, 711, NULL, 'Informasi dan Transaksi Elektronik (ITE)', 'Informasi dan Transaksi Elektronik (ITE)', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(739, 711, NULL, 'Kekarantinaan Kesehatan', 'Kekarantinaan Kesehatan', '#nomor_urut_perkara#-#kode_alur_perkara#/#kode_pn#/#matra#/#bulan#/#tahun#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(740, NULL, NULL, 'Pemilihan Kepala Daerah (Pilkada)', 'Pemilihan Kepala Daerah (Pilkada)', '#nomor_urut_perkara#/G/PILKADA/#tahun#/PTTUN.#kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(741, 158, NULL, 'Permohonan Restitusi', 'Permohonan Restitusi', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL),
(742, 158, NULL, 'Permohonan Kompensasi', 'Permohonan Kompensasi', '#nomor_urut_perkara#/#kode_alur_perkara#/#tahun#/PN #kode_pn#', NULL, 1, 'Y', NULL, 0, NULL, NULL, '', NULL, '', NULL, '', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `perkara_banding`
--

CREATE TABLE `perkara_banding` (
  `id` int(11) NOT NULL,
  `no` int(11) DEFAULT NULL,
  `asal_pengadilan` varchar(100) DEFAULT NULL,
  `nomor_perkara_tk1` varchar(100) DEFAULT NULL,
  `parent` int(11) UNSIGNED DEFAULT NULL,
  `klasifikasi` varchar(255) DEFAULT NULL,
  `tgl_register_banding` date DEFAULT NULL,
  `nomor_perkara_banding` varchar(100) DEFAULT NULL,
  `lama_proses` varchar(50) DEFAULT NULL,
  `status_perkara_tk_banding` varchar(255) DEFAULT NULL,
  `pemberitahuan_putusan_banding` date DEFAULT NULL,
  `permohonan_kasasi` date DEFAULT NULL,
  `pengiriman_berkas_kasasi` date DEFAULT NULL,
  `status` enum('Proses','Selesai','Ditolak') DEFAULT 'Proses',
  `created_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `perkara_banding`
--

INSERT INTO `perkara_banding` (`id`, `no`, `asal_pengadilan`, `nomor_perkara_tk1`, `parent`, `klasifikasi`, `tgl_register_banding`, `nomor_perkara_banding`, `lama_proses`, `status_perkara_tk_banding`, `pemberitahuan_putusan_banding`, `permohonan_kasasi`, `pengiriman_berkas_kasasi`, `status`, `created_by`) VALUES
(10, 1, 'PARINGIN', '78/Pid.Sus/2024/PN Prn', 157, 'Pemalsuan Meterai dan Merk', '2024-08-10', '369/PID.SUS/2024/PT BJM', '25 hari', 'Minutas tanggal : 2025-01-06', '2025-01-13', NULL, '2025-02-19', 'Selesai', NULL),
(11, 2, 'PARINGIN', '93/Pid.Sus/2024/PN Prn', 120, 'Lalu-Lintas', '2024-12-10', '369/PID.SUS/2024/PT BJM', '17', 'Minutas tanggal : 2025-01-06', '2025-01-13', '2025-01-20', '2025-02-13', 'Ditolak', NULL),
(12, NULL, 'KANDANGAN', '80/Pid.Sus/2024/PN Prn', 116, 'Narkotika', '2025-09-10', '400/PID.SUS/2024/PT BJM', '28 hari', 'Minutas tanggal : 2025-01-10', '2025-09-16', '2025-09-16', '2025-09-16', 'Ditolak', NULL),
(13, NULL, 'PENGADILAN NEGERI MARTAPURA', '64724', NULL, NULL, '2025-09-09', '410/PID.SUS/2024/PT BJM', '27 hari', 'Minutas tanggal : 2025-01-10', '2025-09-13', '2025-09-14', '2025-09-14', 'Proses', NULL),
(14, NULL, 'KOTABARU', '100/Pid.Sus/2024/PN Prn', NULL, NULL, '2025-09-03', '400/PID.SUS/2024/PT BJM', '28 hari', 'Minutas tanggal : 2025-01-06', '2025-09-08', '2025-09-02', '2025-09-03', 'Selesai', NULL),
(15, NULL, 'BANJARMASIN', '40/Pid.Sus/2024/PN Prn', NULL, NULL, '2025-09-01', '2131637613', '25 hari', 'Minutas tanggal : 2025-01-09', '2025-09-01', '2025-09-02', '2025-09-05', 'Selesai', NULL),
(20, NULL, 'Jawa', '71/Pid.Sus/2024/PN Prn', 1, 'BPSK', '2025-09-17', '300/PID.SUS/2024/PT BJM', '27 hari', 'Minutas tanggal : 2025-01-19', '2025-09-16', '2025-09-17', '2025-09-16', 'Proses', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `created_at`) VALUES
(3, 'admin1', '$2y$10$aXuRPu4g7l8NawAQdDsaSePAV/olPtx3Ol5gkFWWLmCn9f684lA9W', 'admin', '2025-09-16 02:23:57'),
(4, 'user', '$2y$10$XApdDBg8hNcaKjkL.76U9e/R9MneJbN8Nu/MsjTM24Bar3aQAd90.', 'user', '2025-09-16 03:10:50');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `jenis_perkara`
--
ALTER TABLE `jenis_perkara`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_nama` (`nama`),
  ADD KEY `parent_id` (`parent_id`),
  ADD KEY `tipe_level` (`tipe_level`),
  ADD KEY `level_id` (`level`),
  ADD KEY `nama` (`nama`),
  ADD KEY `lft` (`lft`),
  ADD KEY `rgt` (`rgt`),
  ADD KEY `urutan` (`urutan`),
  ADD KEY `kode` (`kode`),
  ADD KEY `aktif` (`aktif`),
  ADD KEY `format_nomor` (`format_nomor`),
  ADD KEY `diinput_tanggal` (`diinput_tanggal`),
  ADD KEY `diperbaharui_tanggal` (`diperbaharui_tanggal`),
  ADD KEY `idx_parent_id` (`parent_id`);

--
-- Indexes for table `perkara_banding`
--
ALTER TABLE `perkara_banding`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_perkara_user` (`created_by`),
  ADD KEY `fk_perkara_banding_klasifikasi` (`klasifikasi`),
  ADD KEY `fk_perkara_banding_parent` (`parent`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `perkara_banding`
--
ALTER TABLE `perkara_banding`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `perkara_banding`
--
ALTER TABLE `perkara_banding`
  ADD CONSTRAINT `fk_perkara_banding_klasifikasi` FOREIGN KEY (`klasifikasi`) REFERENCES `jenis_perkara` (`nama`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_perkara_banding_parent` FOREIGN KEY (`parent`) REFERENCES `jenis_perkara` (`parent_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_perkara_user` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

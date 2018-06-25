-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 25 Mei 2018 pada 18.16
-- Versi Server: 10.1.29-MariaDB
-- PHP Version: 7.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `master_ci`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `m_karyawan`
--

CREATE TABLE `m_karyawan` (
  `ID_KARYAWAN` int(11) NOT NULL,
  `ID_KATEGORI_USER` int(11) DEFAULT NULL,
  `NAMA_KARYAWAN` varchar(25) DEFAULT NULL,
  `TGL_LAHIR_KARYAWAN` date DEFAULT NULL,
  `TLP_KARYAWAN` varchar(15) DEFAULT NULL,
  `JKL_KARYAWAN` varchar(1) DEFAULT NULL,
  `USERNAME` varchar(25) DEFAULT NULL,
  `PASSWORD` varchar(25) DEFAULT NULL,
  `AKTIF` varchar(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `m_karyawan`
--

INSERT INTO `m_karyawan` (`ID_KARYAWAN`, `ID_KATEGORI_USER`, `NAMA_KARYAWAN`, `TGL_LAHIR_KARYAWAN`, `TLP_KARYAWAN`, `JKL_KARYAWAN`, `USERNAME`, `PASSWORD`, `AKTIF`) VALUES
(3, 1, 'Admin Aplikasi asdasdasd', NULL, NULL, NULL, 'admin', 'admin', 'Y');

-- --------------------------------------------------------

--
-- Struktur dari tabel `m_kategori_user`
--

CREATE TABLE `m_kategori_user` (
  `ID_KATEGORI_USER` int(11) NOT NULL,
  `NAMA_KATEGORI_USER` varchar(50) DEFAULT NULL,
  `KETERANGAN` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `m_kategori_user`
--

INSERT INTO `m_kategori_user` (`ID_KATEGORI_USER`, `NAMA_KATEGORI_USER`, `KETERANGAN`) VALUES
(1, 'Adminsitrator', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `m_menu`
--

CREATE TABLE `m_menu` (
  `ID_MENU` int(11) NOT NULL,
  `ID_PARENT` int(11) DEFAULT NULL,
  `NAMA_MENU` varchar(100) DEFAULT NULL,
  `JUDUL_MENU` varchar(250) DEFAULT NULL,
  `LINK_MENU` varchar(35) DEFAULT NULL,
  `ICON_MENU` varchar(25) DEFAULT NULL,
  `AKTIF_MENU` varchar(1) DEFAULT NULL,
  `TINGKAT_MENU` int(11) DEFAULT NULL,
  `URUTAN_MENU` int(11) DEFAULT NULL,
  `ADD_BUTTON` varchar(1) DEFAULT NULL,
  `EDIT_BUTTON` varchar(1) DEFAULT NULL,
  `DELETE_BUTTON` varchar(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `m_menu`
--

INSERT INTO `m_menu` (`ID_MENU`, `ID_PARENT`, `NAMA_MENU`, `JUDUL_MENU`, `LINK_MENU`, `ICON_MENU`, `AKTIF_MENU`, `TINGKAT_MENU`, `URUTAN_MENU`, `ADD_BUTTON`, `EDIT_BUTTON`, `DELETE_BUTTON`) VALUES
(1, 0, 'Utilitas', '', '', 'database', 'Y', 1, 2, 'N', 'N', 'N'),
(2, 0, 'Data Master', '', '', 'cubes', 'Y', 1, 3, 'N', 'N', 'N'),
(3, 1, 'Pengguna Aplikasi ', 'Menu Pengguna Aplikasi  adalah Data User/Pengguna dari Aplikasi.', 'user', '', 'Y', 2, 2, 'Y', 'Y', 'Y'),
(4, 2, 'Karyawan', 'Menu Karyawan adalah Data Keseluruhan Pegawai.', 'karyawan', '', 'Y', 2, 2, 'Y', 'Y', 'Y'),
(5, 1, 'Kategori Pengguna Aplikasi', 'Menu Kategori Pengguna Aplikasi adalah Halaman yang berisi Data Kategori Pengguna Aplikasi. Dalam menu ini akan diatur untuk hak Akses dari Kategori Pengguna.', 'kategori_user', '', 'Y', 2, 1, 'Y', 'Y', 'Y'),
(12, 0, 'Dashboard', 'Halaman untuk menampilkan Daftar Antrian Order.', 'dashboard', 'dashboard', 'Y', 1, 1, 'N', 'N', 'N');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_hak_akses`
--

CREATE TABLE `t_hak_akses` (
  `ID_MENU` int(11) NOT NULL,
  `ID_KATEGORI_USER` int(11) NOT NULL,
  `ADD_BUTTON` varchar(1) DEFAULT NULL,
  `EDIT_BUTTON` varchar(1) DEFAULT NULL,
  `DELETE_BUTTON` varchar(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `t_hak_akses`
--

INSERT INTO `t_hak_akses` (`ID_MENU`, `ID_KATEGORI_USER`, `ADD_BUTTON`, `EDIT_BUTTON`, `DELETE_BUTTON`) VALUES
(1, 1, '', '', ''),
(2, 1, '', '', ''),
(3, 1, 'Y', 'Y', 'Y'),
(4, 1, 'Y', 'Y', 'Y'),
(5, 1, 'Y', 'Y', 'Y'),
(12, 1, '', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `m_karyawan`
--
ALTER TABLE `m_karyawan`
  ADD PRIMARY KEY (`ID_KARYAWAN`),
  ADD KEY `RELATIONSHIP_1_FK` (`ID_KATEGORI_USER`);

--
-- Indexes for table `m_kategori_user`
--
ALTER TABLE `m_kategori_user`
  ADD PRIMARY KEY (`ID_KATEGORI_USER`);

--
-- Indexes for table `m_menu`
--
ALTER TABLE `m_menu`
  ADD PRIMARY KEY (`ID_MENU`);

--
-- Indexes for table `t_hak_akses`
--
ALTER TABLE `t_hak_akses`
  ADD PRIMARY KEY (`ID_MENU`,`ID_KATEGORI_USER`);

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `m_karyawan`
--
ALTER TABLE `m_karyawan`
  ADD CONSTRAINT `FK_M_KARYAW_RELATIONS_M_KATEGO` FOREIGN KEY (`ID_KATEGORI_USER`) REFERENCES `m_kategori_user` (`ID_KATEGORI_USER`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

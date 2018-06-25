-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 25 Jun 2018 pada 05.24
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
-- Database: `kbs`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `m_barang`
--

CREATE TABLE `m_barang` (
  `ID_BARANG` int(11) NOT NULL,
  `NAMA_BARANG` varchar(200) DEFAULT NULL,
  `KETERANGAN` mediumtext,
  `HARGA` int(11) DEFAULT NULL,
  `AKTIF` char(5) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `m_barang`
--

INSERT INTO `m_barang` (`ID_BARANG`, `NAMA_BARANG`, `KETERANGAN`, `HARGA`, `AKTIF`) VALUES
(2, 'Tiket', 'ini adalah Tiket', 15000, NULL),
(3, 'Wahana Naik Unta', '', 15000, NULL),
(4, 'Wahana Naik Perahu', '', 25000, NULL),
(1, 'Top UP Uang', 'Top UP Uang', 0, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `m_customer`
--

CREATE TABLE `m_customer` (
  `ID_CUSTOMER` int(11) NOT NULL,
  `NAMA_CUSTOMER` varchar(50) DEFAULT NULL,
  `ALAMAT_CUSTOMER` varchar(150) DEFAULT NULL,
  `EMAIL_CUSTOMER` varchar(75) DEFAULT NULL,
  `HP_CUSTOMER` varchar(16) DEFAULT NULL,
  `PASSWORD` varchar(50) DEFAULT NULL,
  `AKTIF` enum('Aktif','Tidak') DEFAULT 'Aktif'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `m_customer`
--

INSERT INTO `m_customer` (`ID_CUSTOMER`, `NAMA_CUSTOMER`, `ALAMAT_CUSTOMER`, `EMAIL_CUSTOMER`, `HP_CUSTOMER`, `PASSWORD`, `AKTIF`) VALUES
(1, 'Customer Offline', '-', '-', '-', 'ojodibuka', 'Aktif'),
(2, 'Customer Online', 'jl Jalan', 'mail.adisantoso@gmail.com', '082229149292', '12345', ''),
(3, 'Anisa', 'Bratang', 'anisamfth@gmail.com', '0897741268', '12345', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `m_kartu`
--

CREATE TABLE `m_kartu` (
  `ID_KARTU` int(11) NOT NULL,
  `NOMOR_RFID` varchar(10) DEFAULT NULL,
  `TGL_INPUT` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `m_kartu`
--

INSERT INTO `m_kartu` (`ID_KARTU`, `NOMOR_RFID`, `TGL_INPUT`) VALUES
(1, '0013087222', '2018-06-19 09:20:26'),
(2, '0013106070', '2018-06-19 19:04:09'),
(3, '0013088972', '2018-06-19 19:04:16');

-- --------------------------------------------------------

--
-- Struktur dari tabel `m_karyawan`
--

CREATE TABLE `m_karyawan` (
  `ID_KARYAWAN` int(11) NOT NULL,
  `ID_KATEGORI_USER` int(11) DEFAULT NULL,
  `ID_BARANG` int(11) NOT NULL,
  `NAMA_KARYAWAN` varchar(50) DEFAULT NULL,
  `TGL_LAHIR_KARYAWAN` date DEFAULT NULL,
  `TLP_KARYAWAN` varchar(15) DEFAULT NULL,
  `JKL_KARYAWAN` varchar(1) DEFAULT NULL,
  `USERNAME` varchar(25) DEFAULT NULL,
  `PASSWORD` varchar(25) DEFAULT NULL,
  `AKTIF` varchar(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `m_karyawan`
--

INSERT INTO `m_karyawan` (`ID_KARYAWAN`, `ID_KATEGORI_USER`, `ID_BARANG`, `NAMA_KARYAWAN`, `TGL_LAHIR_KARYAWAN`, `TLP_KARYAWAN`, `JKL_KARYAWAN`, `USERNAME`, `PASSWORD`, `AKTIF`) VALUES
(1, 1, 0, 'Admin Aplikasi', '2018-06-07', '081', 'L', 'admin', '12345', 'Y'),
(4, 2, 3, 'Soleh ( Penjaga Wahan Unta )', NULL, NULL, NULL, 'unta', '12345', 'Y'),
(3, NULL, 0, 'Wawan ( Tiket )', NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `m_kategori_user`
--

CREATE TABLE `m_kategori_user` (
  `ID_KATEGORI_USER` int(11) NOT NULL,
  `NAMA_KATEGORI_USER` varchar(50) DEFAULT NULL,
  `KETERANGAN` varchar(150) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `m_kategori_user`
--

INSERT INTO `m_kategori_user` (`ID_KATEGORI_USER`, `NAMA_KATEGORI_USER`, `KETERANGAN`) VALUES
(1, 'Administrator', 'Oke'),
(2, 'Penjaga Loket', '');

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `m_menu`
--

INSERT INTO `m_menu` (`ID_MENU`, `ID_PARENT`, `NAMA_MENU`, `JUDUL_MENU`, `LINK_MENU`, `ICON_MENU`, `AKTIF_MENU`, `TINGKAT_MENU`, `URUTAN_MENU`, `ADD_BUTTON`, `EDIT_BUTTON`, `DELETE_BUTTON`) VALUES
(1, 0, 'Utilitas', '', '', 'database', 'Y', 1, 2, 'N', 'N', 'N'),
(2, 0, 'Data Master', '', '', 'cubes', 'Y', 1, 3, 'N', 'N', 'N'),
(3, 1, 'Pengguna Aplikasi ', 'Menu Pengguna Aplikasi  adalah Data User/Pengguna dari Aplikasi.', 'user', '', 'Y', 2, 2, 'Y', 'Y', 'Y'),
(4, 2, 'Karyawan', 'Menu Karyawan adalah Data Keseluruhan Pegawai.', 'karyawan', '', 'Y', 2, 2, 'Y', 'Y', 'Y'),
(5, 1, 'Kategori Pengguna Aplikasi', 'Menu Kategori Pengguna Aplikasi adalah Halaman yang berisi Data Kategori Pengguna Aplikasi. Dalam menu ini akan diatur untuk hak Akses dari Kategori Pengguna.', 'kategori_user', '', 'Y', 2, 1, 'Y', 'Y', 'Y'),
(6, 2, 'Barang', 'Barang ', 'barang', NULL, 'Y', 2, 3, 'Y', 'Y', 'Y'),
(12, 0, 'Dashboard', 'Halaman untuk menampilkan Daftar Antrian Order.', 'dashboard', 'dashboard', 'Y', 1, 1, 'N', 'N', 'N'),
(7, 2, 'Kartu RFID', 'Kartu RFID', 'kartu', NULL, 'Y', 2, 3, 'Y', 'Y', 'Y'),
(13, 0, 'Transaksi Beli', 'Transaksi', NULL, 'edit', 'Y', 1, 4, 'N', 'N', 'N'),
(14, 13, 'Pembelian Tiket', 'Pembelian Tiket', 'trans_tiket', NULL, 'Y', 2, 1, 'Y', 'N', 'N'),
(15, 13, 'Konfirmasi Pembayaran', 'Konfirmasi Pembayaran', 'konfirmasi', NULL, 'Y', 2, 2, 'N', 'N', 'N'),
(16, 13, 'Pengambilan Kartu Online', 'Pengambilan Kartu untuk Transaksi Online', 'ambil_kartu', NULL, 'Y', 2, 3, 'N', 'N', 'N'),
(17, 2, 'Customer', 'Customer', 'customer', NULL, 'Y', 2, 1, 'N', 'Y', 'N'),
(18, 0, 'Tiket Masuk', 'Tiket Masuk', 'tiket_masuk', 'ticket', 'Y', 1, 4, 'Y', 'N', 'N');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_detail_order`
--

CREATE TABLE `t_detail_order` (
  `ID_DETAIL_ORDER` int(11) NOT NULL,
  `ID_T_ORDER` int(11) DEFAULT NULL,
  `ID_BARANG` int(11) DEFAULT NULL,
  `QTY_BARANG` int(11) NOT NULL,
  `HARGA` int(11) DEFAULT NULL,
  `TOTAL_HARGA` int(11) NOT NULL,
  `TGL_DETAIL_ORDER` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `t_detail_order`
--

INSERT INTO `t_detail_order` (`ID_DETAIL_ORDER`, `ID_T_ORDER`, `ID_BARANG`, `QTY_BARANG`, `HARGA`, `TOTAL_HARGA`, `TGL_DETAIL_ORDER`) VALUES
(1, 1, 2, 2, 15000, 30000, '2018-06-23 13:29:44'),
(2, 1, 3, 2, 15000, 30000, '2018-06-23 13:30:02'),
(3, 2, 1, 1, 100000, 100000, '2018-06-23 13:44:17'),
(4, 3, 1, 1, 50000, 50000, '2018-06-23 13:48:08');

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `t_hak_akses`
--

INSERT INTO `t_hak_akses` (`ID_MENU`, `ID_KATEGORI_USER`, `ADD_BUTTON`, `EDIT_BUTTON`, `DELETE_BUTTON`) VALUES
(16, 1, '', '', ''),
(15, 1, '', '', ''),
(14, 1, 'Y', '', ''),
(13, 1, '', '', ''),
(7, 1, 'Y', 'Y', 'Y'),
(6, 1, 'Y', 'Y', 'Y'),
(4, 1, 'Y', 'Y', 'Y'),
(12, 2, '', '', ''),
(17, 1, '', 'Y', ''),
(2, 1, '', '', ''),
(3, 1, 'Y', 'Y', 'Y'),
(5, 1, 'Y', 'Y', 'Y'),
(1, 1, '', '', ''),
(12, 1, '', '', ''),
(18, 1, 'Y', '', ''),
(18, 2, '', '', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_order`
--

CREATE TABLE `t_order` (
  `ID_T_ORDER` int(11) NOT NULL,
  `ID_CUSTOMER` int(11) DEFAULT NULL,
  `NO_ORDER` char(4) NOT NULL,
  `TGL_ORDER` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `STATUS_BAYAR` enum('Lunas','Belum Bayar','Sudah Konfirmasi Bayar') NOT NULL DEFAULT 'Belum Bayar',
  `TGL_KONFIRMASI_BAYAR` datetime DEFAULT NULL,
  `FILE_KONFIRMASI_BAYAR` varchar(50) NOT NULL,
  `KETERANGAN_KONFIRMASI_BAYAR` mediumtext,
  `ID_KARTU` int(11) DEFAULT NULL,
  `TGL_KARTU_KEMBALI` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `t_order`
--

INSERT INTO `t_order` (`ID_T_ORDER`, `ID_CUSTOMER`, `NO_ORDER`, `TGL_ORDER`, `STATUS_BAYAR`, `TGL_KONFIRMASI_BAYAR`, `FILE_KONFIRMASI_BAYAR`, `KETERANGAN_KONFIRMASI_BAYAR`, `ID_KARTU`, `TGL_KARTU_KEMBALI`) VALUES
(1, 3, '1928', '2018-06-23 13:29:44', 'Lunas', '2018-06-23 00:00:00', '', 'Telah ditransfer uang sebesar <b>Rp 60.000,00</b> dari Bank <b>BCA</b> dengan Rekening <b>5120424299</b> ke <b>BCA (No. Rek: 731 025 2527)</b> pada Tanggal <b>2018-06-23</b>', 2, NULL),
(2, 1, '8379', '2018-06-23 13:44:17', 'Lunas', NULL, '', NULL, 1, NULL),
(3, 1, '1259', '2018-06-23 13:48:08', 'Lunas', NULL, '', NULL, 3, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_pakai_kartu`
--

CREATE TABLE `t_pakai_kartu` (
  `ID_PAKAI_KARTU` int(11) NOT NULL,
  `ID_BARANG` int(11) NOT NULL,
  `ID_T_ORDER` int(11) NOT NULL,
  `ID_DETAIL_ORDER` int(11) NOT NULL,
  `TGL_PAKAI` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `HARGA` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `t_pakai_kartu`
--

INSERT INTO `t_pakai_kartu` (`ID_PAKAI_KARTU`, `ID_BARANG`, `ID_T_ORDER`, `ID_DETAIL_ORDER`, `TGL_PAKAI`, `HARGA`) VALUES
(1, 2, 1, 1, '2018-06-23 13:42:23', 15000),
(2, 2, 1, 1, '2018-06-23 13:42:30', 15000),
(3, 3, 1, 2, '2018-06-23 13:42:50', 15000),
(4, 3, 1, 2, '2018-06-23 13:42:51', 15000),
(5, 2, 2, 3, '2018-06-23 13:45:14', 15000),
(6, 2, 2, 3, '2018-06-23 13:46:10', 15000),
(7, 4, 2, 3, '2018-06-23 13:46:50', 25000),
(8, 4, 2, 3, '2018-06-23 13:46:56', 25000),
(9, 3, 2, 3, '2018-06-23 13:47:14', 15000);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `m_barang`
--
ALTER TABLE `m_barang`
  ADD PRIMARY KEY (`ID_BARANG`),
  ADD UNIQUE KEY `M_BARANG_PK` (`ID_BARANG`);

--
-- Indexes for table `m_customer`
--
ALTER TABLE `m_customer`
  ADD PRIMARY KEY (`ID_CUSTOMER`),
  ADD UNIQUE KEY `M_CUSTOMER_PK` (`ID_CUSTOMER`);

--
-- Indexes for table `m_kartu`
--
ALTER TABLE `m_kartu`
  ADD PRIMARY KEY (`ID_KARTU`),
  ADD UNIQUE KEY `M_KARTU_PK` (`ID_KARTU`);

--
-- Indexes for table `m_karyawan`
--
ALTER TABLE `m_karyawan`
  ADD PRIMARY KEY (`ID_KARYAWAN`);

--
-- Indexes for table `m_menu`
--
ALTER TABLE `m_menu`
  ADD PRIMARY KEY (`ID_MENU`);

--
-- Indexes for table `t_detail_order`
--
ALTER TABLE `t_detail_order`
  ADD PRIMARY KEY (`ID_DETAIL_ORDER`),
  ADD UNIQUE KEY `T_DETAIL_ORDER_PK` (`ID_DETAIL_ORDER`),
  ADD KEY `RELATIONSHIP_2_FK` (`ID_T_ORDER`),
  ADD KEY `RELATIONSHIP_6_FK` (`ID_BARANG`);

--
-- Indexes for table `t_hak_akses`
--
ALTER TABLE `t_hak_akses`
  ADD PRIMARY KEY (`ID_MENU`,`ID_KATEGORI_USER`);

--
-- Indexes for table `t_order`
--
ALTER TABLE `t_order`
  ADD PRIMARY KEY (`ID_T_ORDER`),
  ADD UNIQUE KEY `T_ORDER_PK` (`ID_T_ORDER`),
  ADD KEY `RELATIONSHIP_5_FK` (`ID_CUSTOMER`);

--
-- Indexes for table `t_pakai_kartu`
--
ALTER TABLE `t_pakai_kartu`
  ADD PRIMARY KEY (`ID_PAKAI_KARTU`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `m_kartu`
--
ALTER TABLE `m_kartu`
  MODIFY `ID_KARTU` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `m_menu`
--
ALTER TABLE `m_menu`
  MODIFY `ID_MENU` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `t_detail_order`
--
ALTER TABLE `t_detail_order`
  MODIFY `ID_DETAIL_ORDER` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `t_pakai_kartu`
--
ALTER TABLE `t_pakai_kartu`
  MODIFY `ID_PAKAI_KARTU` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

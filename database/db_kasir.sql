-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 29 Agu 2024 pada 06.06
-- Versi server: 8.0.30
-- Versi PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_kasir`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_barang`
--

CREATE TABLE `tbl_barang` (
  `id_barang` varchar(100) NOT NULL,
  `barcode` varchar(20) NOT NULL,
  `nama_barang` varchar(100) NOT NULL,
  `harga_beli` int NOT NULL,
  `harga_jual` int NOT NULL,
  `stock` int NOT NULL,
  `satuan` varchar(20) NOT NULL,
  `stock_minimal` int NOT NULL,
  `gambar` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `tbl_barang`
--

INSERT INTO `tbl_barang` (`id_barang`, `barcode`, `nama_barang`, `harga_beli`, `harga_jual`, `stock`, `satuan`, `stock_minimal`, `gambar`) VALUES
('BRG-000', '21321442141', 'Teh Kotakk', 5000, 5000, 4, 'pouch', 1, '547-607-teh-kotak.jpg'),
('BRG-001', '1274124', 'Coffee', 4000, 4000, 0, 'kaleng', 18, '825-brg-kopi.jpg'),
('BRG-002', '12314121', 'Fruit Tea', 4000, 5000, 0, 'botol', 6, '301-fruit-tea.jpeg'),
('BRG-003', '9843294', 'Cimory Yoghurt', 5000, 7000, 45, 'botol', 45, '494-Cimory Yoghurt.jpeg'),
('BRG-004', '138468348', 'Cola', 4000, 5000, 1, 'botol', 6, '292-cola.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_beli_detail`
--

CREATE TABLE `tbl_beli_detail` (
  `id` int NOT NULL,
  `no_beli` varchar(20) NOT NULL,
  `tgl_beli` date NOT NULL,
  `kode_brg` varchar(10) NOT NULL,
  `nama_brg` varchar(100) NOT NULL,
  `qty` int NOT NULL,
  `harga_beli` int NOT NULL,
  `jml_harga` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `tbl_beli_detail`
--

INSERT INTO `tbl_beli_detail` (`id`, `no_beli`, `tgl_beli`, `kode_brg`, `nama_brg`, `qty`, `harga_beli`, `jml_harga`) VALUES
(1, 'PB0001', '2024-08-20', 'BRG-000', 'Teh Kotak', 1, 5000, 5000),
(2, 'PB0002', '2024-08-20', 'BRG-000', 'Teh Kotak', 3, 5000, 15000),
(4, 'PB0002', '2024-08-20', 'BRG-003', 'Cimory Yoghurt', 6, 5000, 30000),
(11, 'PB0002', '2024-08-21', 'BRG-004', 'Cola', 3, 4000, 12000),
(14, 'PB0004', '2024-08-26', 'BRG-000', 'Teh Kotakk', 3, 5000, 15000),
(15, 'PB0005', '2024-08-26', 'BRG-000', 'Teh Kotakk', 4, 5000, 20000),
(16, 'PB0006', '2024-08-26', 'BRG-000', 'Teh Kotakk', 1, 5000, 5000),
(17, 'PB0006', '2024-08-28', 'BRG-003', 'Cimory Yoghurt', 46, 5000, 230000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_beli_head`
--

CREATE TABLE `tbl_beli_head` (
  `no_beli` varchar(20) NOT NULL,
  `tgl_beli` date NOT NULL,
  `supplier` varchar(255) NOT NULL,
  `total` int NOT NULL,
  `keterangan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `tbl_beli_head`
--

INSERT INTO `tbl_beli_head` (`no_beli`, `tgl_beli`, `supplier`, `total`, `keterangan`) VALUES
('PB0001', '2024-08-20', '', 5000, ''),
('PB0002', '2024-08-22', '', 57000, ''),
('PB0003', '2024-08-22', '', 0, ''),
('PB0004', '2024-08-26', '', 15000, ''),
('PB0005', '2024-08-26', 'PT.sinarmass', 20000, 'asal'),
('PB0006', '2024-08-28', 'PT.erlangga', 235000, '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_costumer`
--

CREATE TABLE `tbl_costumer` (
  `id_costumer` int NOT NULL,
  `nama` varchar(256) NOT NULL,
  `telpon` varchar(50) NOT NULL,
  `deskripsi` varchar(256) NOT NULL,
  `alamat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `tbl_costumer`
--

INSERT INTO `tbl_costumer` (`id_costumer`, `nama`, `telpon`, `deskripsi`, `alamat`) VALUES
(1, 'Abduu', '12487', 'pembeli', 'palas'),
(3, 'Alpin', '21313', 'Pembeli', 'JL.damai'),
(4, 'Andii', '23131', 'Pembeli', 'Rumbai');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_jual_detail`
--

CREATE TABLE `tbl_jual_detail` (
  `id` int NOT NULL,
  `no_jual` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `tgl_jual` date NOT NULL,
  `barcode` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `nama_brg` varchar(100) NOT NULL,
  `qty` int NOT NULL,
  `harga_jual` int NOT NULL,
  `jml_harga` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `tbl_jual_detail`
--

INSERT INTO `tbl_jual_detail` (`id`, `no_jual`, `tgl_jual`, `barcode`, `nama_brg`, `qty`, `harga_jual`, `jml_harga`) VALUES
(3, 'PJ0001', '2024-08-27', '21321442141', 'Teh Kotakk', 3, 5000, 15000),
(4, 'PJ0001', '2024-08-27', '138468348', 'Cola', 1, 5000, 5000),
(5, 'PJ0002', '2024-08-27', '9843294', 'Cimory Yoghurt', 1, 7000, 7000),
(6, 'PJ0003', '2024-08-27', '9843294', 'Cimory Yoghurt', 1, 7000, 7000),
(7, 'PJ0004', '2024-08-27', '21321442141', 'Teh Kotakk', 1, 5000, 5000),
(8, 'PJ0005', '2024-08-27', '21321442141', 'Teh Kotakk', 1, 5000, 5000),
(9, 'PJ0006', '2024-08-27', '21321442141', 'Teh Kotakk', 1, 5000, 5000),
(10, 'PJ0007', '2024-08-27', '21321442141', 'Teh Kotakk', 1, 5000, 5000),
(11, 'PJ0008', '2024-08-27', '21321442141', 'Teh Kotakk', 1, 5000, 5000),
(12, 'PJ0009', '2024-08-28', '9843294', 'Cimory Yoghurt', 1, 7000, 7000),
(13, 'PJ0010', '2024-08-28', '9843294', 'Cimory Yoghurt', 1, 7000, 7000),
(14, 'PJ0011', '2024-08-28', '9843294', 'Cimory Yoghurt', 1, 7000, 7000),
(15, 'PJ0012', '2024-08-28', '9843294', 'Cimory Yoghurt', 1, 7000, 7000),
(16, 'PJ0013', '2024-08-28', '9843294', 'Cimory Yoghurt', 1, 7000, 7000),
(17, 'PJ0013', '2024-08-29', '138468348', 'Cola', 1, 5000, 5000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_jual_head`
--

CREATE TABLE `tbl_jual_head` (
  `no_jual` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `tgl_jual` date NOT NULL,
  `costumer` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `total` int NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `jml_bayar` int NOT NULL,
  `kembalian` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `tbl_jual_head`
--

INSERT INTO `tbl_jual_head` (`no_jual`, `tgl_jual`, `costumer`, `total`, `keterangan`, `jml_bayar`, `kembalian`) VALUES
('PJ0001', '2024-08-27', 'Abduu', 20000, '', 50000, 30000),
('PJ0002', '2024-08-27', 'Abduu', 7000, 'cash', 50000, 43000),
('PJ0003', '2024-08-27', 'Abduu', 7000, 'cash', 10000, 3000),
('PJ0004', '2024-08-27', 'Abduu', 5000, '', 6000, 1000),
('PJ0005', '2024-08-27', 'Abduu', 5000, '', 7000, 2000),
('PJ0006', '2024-08-27', 'Abduu', 5000, '', 18000, 13000),
('PJ0007', '2024-08-27', 'Abduu', 5000, '', 10000, 5000),
('PJ0008', '2024-08-27', 'Abduu', 5000, '', 10000, 5000),
('PJ0009', '2024-08-28', 'Abduu', 7000, 'cash', 10000, 3000),
('PJ0010', '2024-08-28', 'Abduu', 7000, 'cash', 10000, 3000),
('PJ0011', '2024-08-28', 'Abduu', 7000, '', 8000, 1000),
('PJ0012', '2024-08-28', 'Abduu', 7000, '', 10000, 3000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_supplier`
--

CREATE TABLE `tbl_supplier` (
  `id_supplier` int NOT NULL,
  `nama` varchar(256) NOT NULL,
  `telpon` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `deskripsi` varchar(256) NOT NULL,
  `alamat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `tbl_supplier`
--

INSERT INTO `tbl_supplier` (`id_supplier`, `nama`, `telpon`, `deskripsi`, `alamat`) VALUES
(1, 'PT.sinarmass', '08111', 'asd', 'asd'),
(3, 'PT.erlangga', '111111', 'Pemasok', 'jendral sudirman ,no.4'),
(10, 'asalsa', '2352352', 'aaflk', 'fkjewf'),
(11, 'sdbfwffff1', '114124', 'wwgwf', 'feegreg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_transaksi`
--

CREATE TABLE `tbl_transaksi` (
  `id_transaksi` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_user`
--

CREATE TABLE `tbl_user` (
  `userid` int NOT NULL,
  `username` varchar(30) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `password` varchar(256) NOT NULL,
  `address` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `level` int NOT NULL COMMENT '1-administrator\r\n2-supervisor\r\n3-operator',
  `foto` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `tbl_user`
--

INSERT INTO `tbl_user` (`userid`, `username`, `fullname`, `password`, `address`, `level`, `foto`) VALUES
(1, 'admin', 'Administrator', '$2y$10$XSwjKD3IlkZ/Pjdh47S0eOiiS5YcmbT3Z0R5GQhBhzqoQ4tuv32su', 'pekanbaru', 1, '54-default.png'),
(4, 'alpin', 'Alpinn ', '$2y$10$wNqlcWmybW1hDyVcusRbd.REGRRckfocMLSI35cOZCg4W1sj6T4QS', 'Jl.damai', 2, '254-926-pp.jpg'),
(5, 'sihitam', 'Akmal', '$2y$10$Qm8UYoNMDcrVlAuFcP.dp.FzxDuDZ.l6mQ6uHI0QwPn2CVJ/wlRcW', 'tanah air', 1, '420-p1.jpg');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tbl_beli_detail`
--
ALTER TABLE `tbl_beli_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_beli_head`
--
ALTER TABLE `tbl_beli_head`
  ADD PRIMARY KEY (`no_beli`);

--
-- Indeks untuk tabel `tbl_costumer`
--
ALTER TABLE `tbl_costumer`
  ADD PRIMARY KEY (`id_costumer`);

--
-- Indeks untuk tabel `tbl_jual_detail`
--
ALTER TABLE `tbl_jual_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_jual_head`
--
ALTER TABLE `tbl_jual_head`
  ADD PRIMARY KEY (`no_jual`);

--
-- Indeks untuk tabel `tbl_supplier`
--
ALTER TABLE `tbl_supplier`
  ADD PRIMARY KEY (`id_supplier`);

--
-- Indeks untuk tabel `tbl_transaksi`
--
ALTER TABLE `tbl_transaksi`
  ADD PRIMARY KEY (`id_transaksi`);

--
-- Indeks untuk tabel `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`userid`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tbl_beli_detail`
--
ALTER TABLE `tbl_beli_detail`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `tbl_costumer`
--
ALTER TABLE `tbl_costumer`
  MODIFY `id_costumer` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `tbl_jual_detail`
--
ALTER TABLE `tbl_jual_detail`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `tbl_supplier`
--
ALTER TABLE `tbl_supplier`
  MODIFY `id_supplier` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `tbl_transaksi`
--
ALTER TABLE `tbl_transaksi`
  MODIFY `id_transaksi` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `userid` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

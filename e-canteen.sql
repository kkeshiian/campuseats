-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 09 Jun 2025 pada 15.45
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `e-canteen`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `jabatan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id_admin`, `id_user`, `nama`, `jabatan`) VALUES
(1, 11, 'Ghani Mudzakir', 'Backend Developer'),
(2, 12, 'Muhammad Rizky', 'Frontend Developer'),
(3, 13, 'Randy Febrian', 'UI/UX Designer');

-- --------------------------------------------------------

--
-- Struktur dari tabel `fakultas`
--

CREATE TABLE `fakultas` (
  `id_fakultas` int(11) NOT NULL,
  `nama_fakultas` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `fakultas`
--

INSERT INTO `fakultas` (`id_fakultas`, `nama_fakultas`) VALUES
(1010, 'Teknik Banjarmasin'),
(1011, 'Teknik Banjarbaru'),
(1012, 'Keguruan dan Ilmu Pendidikan Banjarmasin'),
(1013, 'Ekonomi dan Bisnis Banjarmasin'),
(1014, 'Hukum'),
(1015, 'Kedokteran dan Ilmu Kesehatan Banjarmasin'),
(1016, 'Kedokteran dan Ilmu Kesehatan Banjarbaru'),
(1017, 'Matematika dan Ilmu Pengetahuan Alam'),
(1018, ' Ilmu Sosial dan Ilmu Politik'),
(1019, 'Ekonomi dan Bisnis'),
(1020, 'Kehutanan'),
(1021, 'Perikanan'),
(1022, 'Pertanian');

-- --------------------------------------------------------

--
-- Struktur dari tabel `menu`
--

CREATE TABLE `menu` (
  `id_menu` int(11) NOT NULL,
  `id_penjual` int(11) DEFAULT NULL,
  `nama_menu` varchar(255) NOT NULL,
  `harga` int(11) NOT NULL,
  `gambar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `menu`
--

INSERT INTO `menu` (`id_menu`, `id_penjual`, `nama_menu`, `harga`, `gambar`) VALUES
(35, 29, 'Nasi Goreng Sehat', 15000, 'assets/6846d61b08a9f.jpg'),
(36, 29, 'Ayam Bakar Madu', 20000, 'assets/6846d63f19ab8.png'),
(37, 29, 'Tahu Lada Garam', 10000, 'assets/6846d66ccf207.jpg'),
(38, 29, 'Es Teh Manis', 5000, 'assets/6846d69217717.jpeg'),
(39, 29, 'Jus Alpukat', 12000, 'assets/6846d6b6604b6.webp'),
(40, 30, 'Soto Ayam', 14000, 'assets/6846d73232ed8.png'),
(41, 30, 'Tempe Goreng', 5000, 'assets/6846d7675b939.jpg'),
(42, 30, 'Nasi Uduk', 13000, 'assets/6846d9f11c4e4.jpeg'),
(43, 30, 'Teh Tarik', 7000, 'assets/6846dab2654ba.jpeg'),
(44, 30, 'Mie Goreng', 11000, 'assets/6846dadca0c6b.jpg'),
(45, 31, 'Nasi Kuning', 12000, 'assets/6846dbe0e1bee.jpg'),
(46, 31, 'Ayam Geprek', 17000, 'assets/6846dbf05bb85.png'),
(47, 31, 'Kerupuk', 2000, 'assets/6846dc0be0aca.jpg'),
(48, 31, 'Es Jeruk', 6000, 'assets/6846dc6142cd4.jpg'),
(49, 31, 'Pudding Cokelat', 8000, 'assets/6846dca517c9f.jpg'),
(50, 32, 'Bakso Urat', 18000, 'assets/6846dd1f29135.jpg'),
(51, 32, 'Mie Ayam', 15000, 'assets/6846dd33c3f49.png'),
(52, 32, 'Sosis Bakar', 9000, 'assets/6846dd4c2b116.jpg'),
(53, 32, 'Es Campur', 10000, 'assets/6846dd6f29090.jpg'),
(54, 32, 'Nasi Ayam Goreng', 16000, 'assets/6846ddb1292d0.jpg'),
(55, 33, 'Roti Bakar', 8000, 'assets/6846de1436d3c.png'),
(56, 33, 'Chicken Katsu', 19000, 'assets/6846de35c86b1.jpg'),
(57, 33, 'Salad Buah', 12000, 'assets/6846de5359fdb.jpeg'),
(58, 33, 'Lemon Tea', 6000, 'assets/6846de87066a1.jpg'),
(59, 33, 'Pancake Pisang', 10000, 'assets/6846deac23341.jpg'),
(60, 34, 'Rawon Daging', 20000, 'assets/6846df0ed2a13.jpeg'),
(61, 34, 'Nasi Pecel', 13000, 'assets/6846df3514855.webp'),
(62, 34, 'Tahu Bacem', 6000, 'assets/6846dfa5d1c9c.webp'),
(63, 34, 'Kopi Susu', 7000, 'assets/6846dfc1aae0c.webp'),
(64, 34, 'Brownies Kukus', 9000, 'assets/6846dfe5afc8d.jpg'),
(65, 35, 'Lontong Sayur', 12000, 'assets/6846e03a9bc2d.jpg'),
(66, 35, 'Ayam Rica-Rica', 18000, 'assets/6846e0547934c.jpg'),
(67, 35, 'Pisang Goreng', 7000, 'assets/6846e082452f3.jpg'),
(68, 35, 'Susu Jahe', 8000, 'assets/6846e17514e3a.webp'),
(69, 35, 'Bubur Ayam', 11000, 'assets/6846e1e1302be.jpg'),
(70, 36, 'Spaghetti Bolognese', 22000, 'assets/6846e2567ae76.jpg'),
(71, 36, 'Chicken Teriyaki', 21000, 'assets/6846e283805ec.jpg'),
(72, 36, 'Kentang Goreng', 9000, 'assets/6846e29ae929b.jpeg'),
(73, 36, 'Soda Gembira', 10000, 'assets/6846e2ba79add.jpg'),
(74, 36, 'Donat Cokelat', 8000, 'assets/6846e2d68660e.jpg'),
(75, 37, 'Ayam Penyet', 16000, 'assets/6846e3244ce76.jpg'),
(76, 37, 'Capcay Goreng', 15000, 'assets/6846e33f27c00.jpg'),
(77, 37, 'Kolak Pisang', 9000, 'assets/6846e370908b8.jpg'),
(78, 37, 'Ice Coffee', 11000, 'assets/6846e3a3cd3e8.webp'),
(79, 37, 'Sate Ayam', 17000, 'assets/6846e3b474740.png'),
(80, 38, 'Nasi Liwet', 17000, 'assets/6846e4355ec0c.webp'),
(81, 38, 'Ikan Bakar', 20000, 'assets/6846e44d7f793.jpeg'),
(82, 38, 'Jus Mangga', 10000, 'assets/6846e49f8027b.webp'),
(83, 38, 'Tahu Gejrot', 6000, 'assets/6846e4bf9d100.jpg'),
(84, 38, 'Martabak Mini', 12000, 'assets/6846e4e047806.webp');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembeli`
--

CREATE TABLE `pembeli` (
  `id_pembeli` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pembeli`
--

INSERT INTO `pembeli` (`id_pembeli`, `id_user`, `nama`) VALUES
(11, 54, 'Rina Marlina'),
(12, 55, 'Dedi Prasetyo'),
(13, 56, 'Siti Aisyah'),
(14, 57, 'Bambang Suprianto'),
(15, 58, 'Lisa Permata'),
(16, 59, 'Andre Hutama'),
(17, 60, 'Nurhaliza Rahmi'),
(18, 61, 'Bayu Saputra'),
(19, 62, 'Tiara Anjani'),
(20, 63, 'Reza Maulana');

-- --------------------------------------------------------

--
-- Struktur dari tabel `penjual`
--

CREATE TABLE `penjual` (
  `id_penjual` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_fakultas` int(11) DEFAULT NULL,
  `nama` varchar(255) NOT NULL,
  `nama_kantin` varchar(255) DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `penjual`
--

INSERT INTO `penjual` (`id_penjual`, `id_user`, `id_fakultas`, `nama`, `nama_kantin`, `gambar`, `link`) VALUES
(29, 64, 1010, 'Dian Novita', 'Kantin Sehat', 'assets/6846d5d5ec6da.jpg', 'https://maps.app.goo.gl/HFPhUfiBR7LuYHZx7'),
(30, 65, 1011, 'Arif Wicaksono', 'Warung Pak Arif', 'assets/6846d70729287.jpg', 'https://maps.app.goo.gl/JnYA1CwM3iEoB3oE6'),
(31, 66, 1018, 'Melati Sari', 'Kantin Melati', 'assets/6846dbb55d962.jpg', 'https://maps.app.goo.gl/NfZ9ek291Cqn3fxc8'),
(32, 67, 1016, 'Yoga Pranata', 'Dapoer Yoga', 'assets/6846dcf374998.jpg', 'https://maps.app.goo.gl/NNcKDZdkcCXYkwey8'),
(33, 70, 1014, 'Vina Maharani', ' Corner Vina', 'assets/6846ddecbe63d.jpg', 'https://maps.app.goo.gl/7DVun9i9mpbL1R1KA'),
(34, 71, 1021, 'Hasan Basri', 'Kantin Hasan', 'assets/6846dedc35c11.jpg', 'https://maps.app.goo.gl/YaSJdGvoVv3bonSa9'),
(35, 72, 1017, 'Putri Kartika', 'Warung Putri', 'assets/6846e0099dcd9.jpg', 'https://maps.app.goo.gl/mDAyWqUeaNvad7aFA'),
(36, 73, 1015, 'Rizky Saputra', 'Rizky Resto', 'assets/6846e22ed6be3.jpg', 'https://maps.app.goo.gl/LJ5qnrk5iV59iKWY7'),
(37, 74, 1020, 'Winda Aprilia', 'Kitchen Winda', 'assets/6846e300b138b.jpg', 'https://maps.app.goo.gl/TmyYeqfkVaedmBb67'),
(38, 75, 1013, 'Ahmad Fauzan', 'Dapur Fauzan', 'assets/6846e3fd13663.jpg', 'https://maps.app.goo.gl/BDHjuNK6taRNxsJ78');

-- --------------------------------------------------------

--
-- Struktur dari tabel `riwayat_pembelian`
--

CREATE TABLE `riwayat_pembelian` (
  `id_rp` int(11) NOT NULL,
  `order_id` varchar(255) NOT NULL,
  `id_pembeli` int(11) NOT NULL,
  `nama_kantin` varchar(255) NOT NULL,
  `menu` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `harga` double NOT NULL,
  `total` double NOT NULL,
  `status` varchar(100) NOT NULL,
  `tanggal` datetime NOT NULL DEFAULT current_timestamp(),
  `notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `Role` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `nama`, `username`, `password`, `Role`) VALUES
(11, 'Ghani Mudzakir', 'ghanimudzakir', '$2y$10$UwkY.qQh8w4spRS1qfHBpus3VLd6eB/4VHf/2xgA839Ib.GA9WFCm', 'Admin'),
(12, 'Muhammad Rizky', 'muhammadrizky', '$2y$10$wn4HQNX0pS27gz4nY03mPufCDKgy0RqOlBM.JezDnzYmRWDeUsgD.', 'Admin'),
(13, 'Randy Febrian', 'randyfebrian', '$2y$10$RoaA.AbTc3DFsgKAMYsBM.HOA3.GIJN94YmlrG..9xMVyFydY9smq', 'Admin'),
(54, 'Rina Marlina', 'rinam', '$2y$10$RBVkxWZCN5FZj5ZW2I4dreAM5C7ixIM7tDvtb1MT4yI9gvyNwPHl2', 'pembeli'),
(55, 'Dedi Prasetyo', 'dedip', '$2y$10$CSjBqUV4Zvr8scFQdNNgZemzLXIIYNTPTe.pR6qN0twN/rtoWBLJK', 'pembeli'),
(56, 'Siti Aisyah', 'sitia', '$2y$10$hpMqa0ylesUngZEWcLVDNOcVHPB5u93TJcbOm4CMxdjt6rtEbw1F2', 'pembeli'),
(57, 'Bambang Suprianto', 'bambangs', '$2y$10$SE2G/L2MbX7kQGHIs58rzOTLEG1XA9JIc9QaS9iflSmk8QgeYIehy', 'pembeli'),
(58, 'Lisa Permata', 'lisap', '$2y$10$fap051jSsFoggIdkTEg16O4.Mr0kG3fAQRLrBBfu6uPhmqERfWfdS', 'pembeli'),
(59, 'Andre Hutama', 'andreh', '$2y$10$t2D.rdL.8T1Ix05uGwfokebDJjNKRNikjcZqWNgy0saaYRAeqSjDi', 'pembeli'),
(60, 'Nurhaliza Rahmi', 'nurhaliza', '$2y$10$ZffRain7.1x5eDcEMXj14ePeVUyZLO9orNoGjLkS4CsC3p67/OaRy', 'pembeli'),
(61, 'Bayu Saputra', 'bayus', '$2y$10$lvFUYUeQTjVW9eZBVl9TjOYLi7wRNciv.mZyvxuVP2el4DU3JDoeG', 'pembeli'),
(62, 'Tiara Anjani', 'tiaraa', '$2y$10$5TN/QyJEgjWMWl1.kYm5quz7rZM7rr1DBHqW98LTIFjolwyZouZH2', 'pembeli'),
(63, 'Reza Maulana', 'rezam', '$2y$10$yLs6GkXOInV0RoTxEK.3nO1dPjtkSYsEyFfS.d97e4gbu11Hiu/OW', 'pembeli'),
(64, 'Dian Novita', 'diann', '$2y$10$dNwDyvK5Jsc4cybPkdGvB.5lpPqYRCQKMuBox4f/cl3Fo9/wDnEJG', 'penjual'),
(65, 'Arif Wicaksono', 'arifw', '$2y$10$b0WcrrmaL1RkQNMRnn9MouzsIBpMh4rA1G4jBOylr8/AVz0Dqq22u', 'penjual'),
(66, 'Melati Sari', 'melatis', '$2y$10$INfGN6vAtsC9T/mlwSO8yuWx5gOl10ewQFDOSzxwTOofzegQLIvD2', 'penjual'),
(67, 'Yoga Pranata', 'yogap', '$2y$10$mkSl.7r4lQC5vTAZHRrigeye/H/dECuUXwnZSNP.D/rVKs/63t8U2', 'penjual'),
(70, 'Vina Maharani', 'vinam', '$2y$10$VtCaEOeeQNSC56vFcgRlmuXLqdLWykv5NbvA3oqbOb8ihAX9t77fi', 'penjual'),
(71, 'Hasan Basri', 'hasanb', '$2y$10$iTZtqK/p9d.5.H/6Sg1wqecokz71vmMYk5Gm.a/Us78zA1GV3B9OO', 'penjual'),
(72, 'Putri Kartika', 'putrik', '$2y$10$5n.O9U2vYxnsDJEbDyLt3.YfXN6vwQokAJEl5.DpWy6HEae/f69jm', 'penjual'),
(73, 'Rizky Saputra', 'rizkys', '$2y$10$9E/JJO0pwT0Uxr6Axz2XYOfMSsERUtrihjIeK0OyfQgNypgSCWzkC', 'penjual'),
(74, 'Winda Aprilia', 'windaa', '$2y$10$OzrDY2yk1vmCkguAiyt4POsX1RuuMVDW1h2FonGY0g2EVXSHQqX4e', 'penjual'),
(75, 'Ahmad Fauzan', 'ahmadf', '$2y$10$bVTnohp7/IaZGh77BG0HkeE/3cU4o4jjwtyB6scgbFl81iFkTc7Bi', 'penjual');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `fakultas`
--
ALTER TABLE `fakultas`
  ADD PRIMARY KEY (`id_fakultas`);

--
-- Indeks untuk tabel `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id_menu`),
  ADD KEY `id_penjual` (`id_penjual`);

--
-- Indeks untuk tabel `pembeli`
--
ALTER TABLE `pembeli`
  ADD PRIMARY KEY (`id_pembeli`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `penjual`
--
ALTER TABLE `penjual`
  ADD PRIMARY KEY (`id_penjual`),
  ADD UNIQUE KEY `nama_kantin` (`nama_kantin`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_fakultas` (`id_fakultas`);

--
-- Indeks untuk tabel `riwayat_pembelian`
--
ALTER TABLE `riwayat_pembelian`
  ADD PRIMARY KEY (`id_rp`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT untuk tabel `fakultas`
--
ALTER TABLE `fakultas`
  MODIFY `id_fakultas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1023;

--
-- AUTO_INCREMENT untuk tabel `menu`
--
ALTER TABLE `menu`
  MODIFY `id_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT untuk tabel `pembeli`
--
ALTER TABLE `pembeli`
  MODIFY `id_pembeli` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `penjual`
--
ALTER TABLE `penjual`
  MODIFY `id_penjual` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT untuk tabel `riwayat_pembelian`
--
ALTER TABLE `riwayat_pembelian`
  MODIFY `id_rp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `menu`
--
ALTER TABLE `menu`
  ADD CONSTRAINT `menu_ibfk_1` FOREIGN KEY (`id_penjual`) REFERENCES `penjual` (`id_penjual`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pembeli`
--
ALTER TABLE `pembeli`
  ADD CONSTRAINT `pembeli_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `penjual`
--
ALTER TABLE `penjual`
  ADD CONSTRAINT `penjual_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `penjual_ibfk_2` FOREIGN KEY (`id_fakultas`) REFERENCES `fakultas` (`id_fakultas`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

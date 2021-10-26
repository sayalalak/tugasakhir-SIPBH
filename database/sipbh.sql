-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 16 Jun 2020 pada 07.33
-- Versi server: 10.1.38-MariaDB
-- Versi PHP: 7.1.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sipbh`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `brg_hilang`
--

CREATE TABLE `brg_hilang` (
  `kode_brg` int(10) NOT NULL,
  `nama_brg` varchar(20) NOT NULL,
  `tglkejadian` date NOT NULL,
  `spesifikasibrg` varchar(20) NOT NULL,
  `tmptkejadian` varchar(20) NOT NULL,
  `kronologi` text NOT NULL,
  `pelapor` varchar(20) NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `brg_lelang`
--

CREATE TABLE `brg_lelang` (
  `kode_brg` int(11) NOT NULL,
  `nama_brg` varchar(20) NOT NULL,
  `spesifikasibrg` int(11) NOT NULL,
  `hargabrg` int(11) NOT NULL,
  `keterangan` int(11) NOT NULL,
  `fotobrg` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `brg_temuan`
--

CREATE TABLE `brg_temuan` (
  `kode_brg` int(10) NOT NULL,
  `nama_brg` varchar(20) NOT NULL,
  `tglkejadian` date NOT NULL,
  `spesifikasibrg` varchar(20) NOT NULL,
  `tmptkejadian` varchar(20) NOT NULL,
  `kronologi` text NOT NULL,
  `pelapor` varchar(20) NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `login`
--

CREATE TABLE `login` (
  `id_admin` int(10) NOT NULL,
  `nama` varchar(20) NOT NULL,
  `username` varchar(15) NOT NULL,
  `password` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `login`
--

INSERT INTO `login` (`id_admin`, `nama`, `username`, `password`) VALUES
(1, 'Lalak', 'admin', 'admin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tmp`
--

CREATE TABLE `tmp` (
  `kode_brg` int(10) NOT NULL,
  `nama_brg` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi_lelang`
--

CREATE TABLE `transaksi_lelang` (
  `id_transaksi` int(10) NOT NULL,
  `kode_barang` int(10) NOT NULL,
  `nama_pembeli` int(25) NOT NULL,
  `telp_pembeli` int(15) NOT NULL,
  `ktp_pembeli` int(16) NOT NULL,
  `metode_byr` varchar(10) NOT NULL,
  `metode_kirim` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `brg_hilang`
--
ALTER TABLE `brg_hilang`
  ADD PRIMARY KEY (`kode_brg`);

--
-- Indeks untuk tabel `brg_lelang`
--
ALTER TABLE `brg_lelang`
  ADD PRIMARY KEY (`kode_brg`);

--
-- Indeks untuk tabel `brg_temuan`
--
ALTER TABLE `brg_temuan`
  ADD PRIMARY KEY (`kode_brg`);

--
-- Indeks untuk tabel `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indeks untuk tabel `transaksi_lelang`
--
ALTER TABLE `transaksi_lelang`
  ADD PRIMARY KEY (`id_transaksi`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `brg_hilang`
--
ALTER TABLE `brg_hilang`
  MODIFY `kode_brg` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `brg_lelang`
--
ALTER TABLE `brg_lelang`
  MODIFY `kode_brg` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `brg_temuan`
--
ALTER TABLE `brg_temuan`
  MODIFY `kode_brg` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `login`
--
ALTER TABLE `login`
  MODIFY `id_admin` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `transaksi_lelang`
--
ALTER TABLE `transaksi_lelang`
  MODIFY `id_transaksi` int(10) NOT NULL AUTO_INCREMENT;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `brg_hilang`
--
ALTER TABLE `brg_hilang`
  ADD CONSTRAINT `brg_hilang_ibfk_1` FOREIGN KEY (`kode_brg`) REFERENCES `login` (`id_admin`);

--
-- Ketidakleluasaan untuk tabel `brg_lelang`
--
ALTER TABLE `brg_lelang`
  ADD CONSTRAINT `brg_lelang_ibfk_1` FOREIGN KEY (`kode_brg`) REFERENCES `login` (`id_admin`);

--
-- Ketidakleluasaan untuk tabel `brg_temuan`
--
ALTER TABLE `brg_temuan`
  ADD CONSTRAINT `brg_temuan_ibfk_1` FOREIGN KEY (`kode_brg`) REFERENCES `login` (`id_admin`);

--
-- Ketidakleluasaan untuk tabel `transaksi_lelang`
--
ALTER TABLE `transaksi_lelang`
  ADD CONSTRAINT `transaksi_lelang_ibfk_1` FOREIGN KEY (`id_transaksi`) REFERENCES `brg_lelang` (`kode_brg`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

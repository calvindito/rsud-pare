-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 23 Jan 2023 pada 09.43
-- Versi server: 10.4.27-MariaDB
-- Versi PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rsud_clone`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `a_golpasien`
--

CREATE TABLE `a_golpasien` (
  `KodeGol` int(11) NOT NULL,
  `NamaGol` varchar(80) DEFAULT NULL,
  `a_kpid` int(11) DEFAULT 2,
  `Inisial` varchar(2) NOT NULL DEFAULT '',
  `KodeKlsHak` int(11) NOT NULL DEFAULT 0,
  `JenisKlsHak` int(11) NOT NULL DEFAULT 0,
  `KodeAturan` int(11) NOT NULL DEFAULT 1,
  `NoAwal` varchar(10) NOT NULL DEFAULT '',
  `IsPBI` int(11) NOT NULL DEFAULT 0,
  `MblAmbGratis` int(11) NOT NULL DEFAULT 1,
  `MblJnhGratis` int(11) NOT NULL DEFAULT 0,
  `KDJNSKPST` int(11) NOT NULL DEFAULT 0,
  `KDJNSPESERTA` int(11) NOT NULL DEFAULT 0,
  `IsKaryawan` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `a_golpasien`
--

INSERT INTO `a_golpasien` (`KodeGol`, `NamaGol`, `a_kpid`, `Inisial`, `KodeKlsHak`, `JenisKlsHak`, `KodeAturan`, `NoAwal`, `IsPBI`, `MblAmbGratis`, `MblJnhGratis`, `KDJNSKPST`, `KDJNSPESERTA`, `IsKaryawan`) VALUES
(111, '', 7, '', 20, 0, 4, '', 0, 1, 0, 0, 0, 1),
(1001, 'UMUM', 1, 'a', 0, 0, 1, '', 1, 1, 0, 0, 0, 1),
(1002, 'JAMKESDA', 5, 'a', 21, 0, 3, '', 0, 1, 0, 0, 0, 1),
(1004, 'JR JAMKESDA', 7, '', 20, 0, 4, '', 0, 1, 0, 0, 0, 1),
(1005, 'EASCO MEDICAL HEALTH 3', 7, '', 20, 0, 4, '', 0, 1, 0, 0, 0, 0),
(1006, 'EASCO MEDICAL HEALTH 3', 7, '', 20, 0, 4, '', 0, 1, 0, 0, 0, 0),
(1007, 'EASCO MEDICAL HEALTH 4', 7, '', 20, 0, 4, '', 0, 1, 0, 0, 0, 0),
(1008, 'BPJS Tenaga Kerja', 5, '', 21, 0, 3, '', 0, 1, 0, 0, 0, 1),
(1011, 'TNI 1', 10, '', 19, 0, 2, '', 0, 1, 0, 0, 0, 0),
(1012, 'TNI 2', 10, '', 20, 0, 2, '', 0, 1, 0, 0, 0, 0),
(1013, 'TNI 3', 10, '', 21, 0, 2, '', 0, 1, 0, 0, 0, 0),
(1021, 'POLRI 1', 10, '', 19, 0, 2, '', 0, 1, 0, 0, 0, 0),
(1022, 'POLRI 2', 10, '', 20, 0, 2, '', 0, 1, 0, 0, 0, 0),
(1023, 'POLRI 3', 10, '', 21, 0, 2, '', 0, 1, 0, 0, 0, 0),
(2101, 'ASKES PNS GOL I', 2, '', 20, 2, 4, '', 0, 1, 0, 0, 0, 0),
(2102, 'ASKES PNS GOL II', 2, '', 20, 2, 2, '', 0, 1, 0, 0, 0, 0),
(2103, 'ASKES PNS GOL III', 2, '', 19, 1, 2, '', 0, 1, 0, 0, 0, 0),
(2104, 'ASKES PNS GOL IV', 2, '', 19, 1, 2, '', 0, 1, 0, 0, 0, 0),
(2201, 'ASKES PESIUNAN GOL I', 2, '', 20, 2, 2, '', 0, 1, 0, 0, 0, 0),
(2202, 'ASKES PESIUNAN GOL II', 2, '', 20, 2, 2, '', 0, 1, 0, 0, 0, 0),
(2203, 'ASKES PESIUNAN GOL III', 2, '', 19, 1, 2, '', 0, 1, 0, 0, 0, 0),
(2204, 'ASKES PESIUNAN GOL IV', 2, '', 19, 1, 2, '', 0, 1, 0, 0, 0, 0),
(2301, 'JAMKESMAS', 4, 'a', 21, 0, 4, '000177', 1, 1, 0, 0, 0, 0),
(2401, 'INHEALTH', 3, 'a', 19, 0, 3, '', 0, 1, 0, 0, 0, 1),
(2402, 'INHEALTH', 3, '', 20, 0, 3, '', 0, 1, 0, 0, 0, 0),
(2403, 'INHEALTH', 3, '', 21, 0, 3, '', 0, 1, 0, 0, 0, 0),
(2404, 'INHEALTH', 3, '', 17, 0, 3, '', 0, 1, 0, 0, 0, 0),
(2405, 'INHEALTH', 3, '', 18, 0, 3, '', 0, 1, 0, 0, 0, 0),
(2406, 'INHEALTH', 3, '', 16, 0, 3, '', 0, 1, 0, 0, 0, 0),
(2407, 'INHEALTH', 3, '', 15, 0, 3, '', 0, 1, 0, 0, 0, 0),
(2408, 'ASKES TENAGA KONTRAK', 2, '', 20, 0, 3, '', 0, 1, 0, 0, 0, 0),
(2409, 'ASKES INHEALTH VIP - SWEET', 3, '', 25, 0, 3, '', 0, 1, 0, 0, 0, 0),
(2501, 'ASKES DOKTER PTT', 2, '', 19, 0, 3, '', 0, 1, 0, 0, 0, 0),
(2601, 'ASKES BIDAN PTT', 2, '', 19, 0, 3, '', 0, 1, 0, 0, 0, 0),
(3101, 'JAMSOSTEK', 6, '', 20, 0, 6, '', 0, 1, 0, 0, 0, 0),
(3201, 'EASCO MEDICAL HEALTH', 7, '', 20, 0, 4, '', 0, 1, 0, 0, 0, 0),
(3202, 'BRINGIN LIFE', 8, '', 20, 0, 4, '', 0, 1, 0, 0, 0, 0),
(9101, 'BPJS PBI', 9, 'a', 21, 0, 4, '', 1, 1, 0, 0, 0, 0),
(9201, 'BPJS PBI', 9, 'a', 21, 0, 4, '', 0, 1, 0, 0, 0, 0),
(9202, 'BPJS MANDIRI', 9, 'a', 21, 0, 4, '', 0, 1, 0, 0, 0, 0),
(9203, 'BPJS MANDIRI', 9, 'a', 21, 0, 4, '', 0, 1, 0, 0, 0, 0),
(9204, 'JR BPJS', 2, '', 0, 0, 1, '', 0, 1, 0, 0, 0, 1),
(9205, 'JR UMUM', 2, '', 0, 0, 1, '', 1, 1, 0, 0, 0, 1),
(26021, 'PNS Pusat-1', 26, '', 19, 1, 4, '', 0, 1, 0, 1, 1, 0),
(26022, 'PNS Pusat-2', 26, '', 20, 2, 4, '', 0, 1, 0, 1, 1, 0),
(26023, 'PNS Diperbantukan-1', 26, '', 19, 1, 4, '', 0, 1, 0, 2, 1, 0),
(26024, 'PNS Diperbantukan-2', 26, '', 20, 2, 4, '', 0, 1, 0, 2, 1, 0),
(26025, 'PNS Dipekerjakan-1', 26, '', 19, 1, 4, '', 0, 1, 0, 3, 1, 0),
(26026, 'PNS Dipekerjakan-2', 26, '', 20, 2, 4, '', 0, 1, 0, 3, 1, 0),
(26027, 'Pejabat Negara', 26, '', 19, 1, 4, '', 0, 1, 0, 4, 1, 0),
(26028, 'TNI-1', 26, '', 19, 1, 4, '', 0, 1, 0, 5, 1, 0),
(26029, 'TNI-2', 26, '', 20, 2, 4, '', 0, 1, 0, 5, 1, 0),
(26030, 'POLRI-1', 26, '', 19, 1, 4, '', 0, 1, 0, 6, 1, 0),
(26031, 'POLRI-2', 26, '', 20, 2, 4, '', 0, 1, 0, 6, 1, 0),
(26032, 'Pegawai Pemerintah Non PNS-1', 26, '', 19, 1, 4, '', 0, 1, 0, 7, 1, 0),
(26033, 'Pegawai Pemerintah Non PNS-2', 26, '', 20, 2, 4, '', 0, 1, 0, 7, 1, 0),
(26034, 'Jamkesmen PNS-1', 26, '', 19, 1, 4, '', 0, 1, 0, 8, 1, 0),
(26035, 'Jamkesmen PNS-2', 26, '', 20, 2, 4, '', 0, 1, 0, 8, 1, 0),
(26036, 'Jamkesmen Non PNS-1', 26, '', 19, 1, 4, '', 0, 1, 0, 9, 1, 0),
(26037, 'Jamkesmen Non PNS-2', 26, '', 20, 2, 4, '', 0, 1, 0, 9, 1, 0),
(26038, 'Jamkestama Pst Sosial-1', 26, '', 19, 1, 4, '', 0, 1, 0, 10, 1, 0),
(26039, 'Jamkestama Pst Sosial-2', 26, '', 20, 2, 4, '', 0, 1, 0, 10, 1, 0),
(26040, 'Jamkestama Non Pst Sosial-1', 26, '', 19, 1, 4, '', 0, 1, 0, 11, 1, 0),
(26041, 'Jamkestama Non Pst Sosial-2', 26, '', 20, 2, 4, '', 0, 1, 0, 11, 1, 0),
(26042, 'Bidan PTT-1', 26, '', 19, 1, 4, '', 0, 1, 0, 12, 1, 0),
(26043, 'Bidan PTT-2', 26, '', 20, 2, 4, '', 0, 1, 0, 12, 1, 0),
(26044, 'Dokter PTT-1', 26, '', 19, 1, 4, '', 0, 1, 0, 13, 1, 0),
(26045, 'Dokter PTT-2', 26, '', 20, 2, 4, '', 0, 1, 0, 13, 1, 0),
(26046, 'PNS KEMHAN/POLRI-1', 26, '', 19, 1, 4, '', 0, 1, 0, 14, 1, 0),
(26047, 'PNS KEMHAN/POLRI-2', 26, '', 20, 2, 4, '', 0, 1, 0, 14, 1, 0),
(26048, 'PNS Daerah-1', 26, '', 19, 1, 4, '', 0, 1, 0, 1, 2, 0),
(26049, 'PNS Daerah-2', 26, '', 20, 2, 4, '', 0, 1, 0, 1, 2, 0),
(26050, 'Pejabat Negara', 26, '', 19, 1, 4, '', 0, 1, 0, 2, 2, 0),
(26051, 'Anggota DPRD', 26, '', 19, 1, 4, '', 0, 1, 0, 3, 2, 0),
(26052, 'Pegawai Pemerintah Non PNS-1', 26, '', 19, 1, 4, '', 0, 1, 0, 4, 2, 0),
(26053, 'Pegawai Pemerintah Non PNS-2', 26, '', 20, 2, 4, '', 0, 1, 0, 4, 2, 0),
(26054, 'Jamkesmen PNS-1', 26, '', 19, 1, 4, '', 0, 1, 0, 5, 2, 0),
(26055, 'Jamkesmen PNS-2', 26, '', 20, 2, 4, '', 0, 1, 0, 5, 2, 0),
(26056, 'Jamkesmen Non PNS-1', 26, '', 19, 1, 4, '', 0, 1, 0, 6, 2, 0),
(26057, 'Jamkesmen Non PNS-2', 26, '', 20, 2, 4, '', 0, 1, 0, 6, 2, 0),
(26058, 'Jamkestama Pst Sosial-1', 26, '', 19, 1, 4, '', 0, 1, 0, 7, 2, 0),
(26059, 'Jamkestama Pst Sosial-2', 26, '', 20, 2, 4, '', 0, 1, 0, 7, 2, 0),
(26060, 'Jamkestama Non Pst Sosial-1', 26, '', 19, 1, 4, '', 0, 1, 0, 8, 2, 0),
(26061, 'Jamkestama Non Pst Sosial-2', 26, '', 20, 2, 4, '', 0, 1, 0, 8, 2, 0),
(26062, 'PEGAWAI BADAN USAHA-1', 26, '', 19, 1, 4, '', 0, 1, 0, 1, 3, 0),
(26063, 'PEGAWAI BADAN USAHA-2', 26, '', 20, 2, 4, '', 0, 1, 0, 1, 3, 0),
(26064, 'PEGAWAI BADAN USAHA-3', 26, '', 21, 3, 4, '', 0, 1, 0, 1, 3, 0),
(26065, 'PEKERJA SEKTOR INFORMAL INDIVIDU-3', 26, '', 21, 3, 4, '', 1, 1, 0, 1, 4, 0),
(26066, 'PEKERJA SEKTOR INFORMAL KELOMPOK-1', 26, '', 19, 1, 4, '', 0, 1, 0, 1, 5, 0),
(26067, 'PEKERJA SEKTOR INFORMAL KELOMPOK-2', 26, '', 20, 2, 4, '', 0, 1, 0, 1, 5, 0),
(26068, 'PEKERJA SEKTOR INFORMAL KELOMPOK-3', 26, '', 21, 3, 4, '', 0, 1, 0, 1, 5, 0),
(26069, 'PEKERJA MANDIRI PROFESIONAL INDIVIDU-1', 26, '', 19, 1, 4, '', 0, 1, 0, 1, 6, 0),
(26070, 'PEKERJA MANDIRI PROFESIONAL INDIVIDU-2', 26, '', 20, 2, 4, '', 0, 1, 0, 1, 6, 0),
(26071, 'PEKERJA MANDIRI PROFESIONAL INDIVIDU-3', 26, '', 21, 3, 4, '', 0, 1, 0, 1, 6, 0),
(26072, 'PEKERJA MANDIRI PROFESIONAL KELOMPOK-1', 26, '', 19, 1, 4, '', 0, 1, 0, 1, 7, 0),
(26073, 'PEKERJA MANDIRI PROFESIONAL KELOMPOK-2', 26, '', 20, 2, 4, '', 0, 1, 0, 1, 7, 0),
(26074, 'PEKERJA MANDIRI PROFESIONAL KELOMPOK-3', 26, '', 21, 3, 4, '', 0, 1, 0, 1, 7, 0),
(26075, 'PP PNS-1', 26, '', 19, 1, 4, '', 0, 1, 0, 1, 8, 0),
(26076, 'PP PNS-2', 26, '', 20, 2, 4, '', 0, 1, 0, 1, 8, 0),
(26077, 'PP PNS-3', 26, '', 21, 3, 4, '', 0, 1, 0, 1, 8, 0),
(26078, 'PP TNI-1', 26, '', 19, 1, 4, '', 0, 1, 0, 2, 8, 0),
(26079, 'PP TNI-2', 26, '', 20, 2, 4, '', 0, 1, 0, 2, 8, 0),
(26080, 'PP TNI-3', 26, '', 21, 3, 4, '', 0, 1, 0, 2, 8, 0),
(26081, 'PP POLRI-1', 26, '', 19, 1, 4, '', 0, 1, 0, 3, 8, 0),
(26082, 'PP POLRI-2', 26, '', 20, 2, 4, '', 0, 1, 0, 3, 8, 0),
(26083, 'PP POLRI-3', 26, '', 21, 3, 4, '', 0, 1, 0, 3, 8, 0),
(26084, 'PP Pejabat Negara-1', 26, '', 19, 1, 4, '', 0, 1, 0, 4, 8, 0),
(26085, 'PP Pejabat Negara-2', 26, '', 20, 2, 4, '', 0, 1, 0, 4, 8, 0),
(26086, 'PP Pejabat Negara-3', 26, '', 21, 3, 4, '', 0, 1, 0, 4, 8, 0),
(26087, 'PP PNS KEMHAN/POLRI-1', 26, '', 19, 1, 4, '', 0, 1, 0, 5, 8, 0),
(26088, 'PP PNS KEMHAN/POLRI-2', 26, '', 20, 2, 4, '', 0, 1, 0, 5, 8, 0),
(26089, 'PP PNS KEMHAN/POLRI-3', 26, '', 21, 3, 4, '', 0, 1, 0, 5, 8, 0),
(26090, 'VETERAN TUVET-1', 26, '', 19, 1, 4, '', 0, 1, 0, 1, 9, 0),
(26091, 'VETERAN TUVET-2', 26, '', 20, 2, 4, '', 0, 1, 0, 1, 9, 0),
(26092, 'VETERAN TUVET-3', 26, '', 21, 3, 4, '', 0, 1, 0, 1, 9, 0),
(26093, 'VETERAN NON TUVET-1', 26, '', 19, 1, 4, '', 0, 1, 0, 2, 9, 0),
(26094, 'VETERAN NON TUVET-2', 26, '', 20, 2, 4, '', 0, 1, 0, 2, 9, 0),
(26095, 'VETERAN NON TUVET-3', 26, '', 21, 3, 4, '', 0, 1, 0, 2, 9, 0),
(26096, 'PERINTIS KEMERDEKAAN-1', 26, '', 19, 1, 4, '', 0, 1, 0, 3, 9, 0),
(26097, 'PERINTIS KEMERDEKAAN-2', 26, '', 20, 2, 4, '', 0, 1, 0, 3, 9, 0),
(26098, 'PERINTIS KEMERDEKAAN-3', 26, '', 21, 3, 4, '', 0, 1, 0, 3, 9, 0),
(26099, 'PENERIMA PENSIUN YANG TIDAK DIBAYAR NEGARA-1', 26, '', 19, 1, 4, '', 0, 1, 0, 1, 10, 0),
(26100, 'PENERIMA PENSIUN YANG TIDAK DIBAYAR NEGARA-2', 26, '', 20, 2, 4, '', 0, 1, 0, 1, 10, 0),
(26101, 'PENERIMA PENSIUN YANG TIDAK DIBAYAR NEGARA-3', 26, '', 21, 3, 4, '', 0, 1, 0, 1, 10, 0),
(26102, 'INVESTOR INDIVIDU-1', 26, '', 19, 1, 4, '', 0, 1, 0, 1, 11, 0),
(26103, 'INVESTOR INDIVIDU-2', 26, '', 20, 2, 4, '', 0, 1, 0, 1, 11, 0),
(26104, 'INVESTOR INDIVIDU-3', 26, '', 21, 3, 4, '', 0, 1, 0, 1, 11, 0),
(26105, 'INVESTOR KELOMPOK-1', 26, '', 19, 1, 4, '', 0, 1, 0, 1, 12, 0),
(26106, 'INVESTOR KELOMPOK-2', 26, '', 20, 2, 4, '', 0, 1, 0, 1, 12, 0),
(26107, 'INVESTOR KELOMPOK-3', 26, '', 21, 3, 4, '', 0, 1, 0, 1, 12, 0),
(26108, 'PEMBERI KERJA INDIVIDU-1', 26, '', 19, 1, 4, '', 0, 1, 0, 1, 13, 0),
(26109, 'PEMBERI KERJA INDIVIDU-2', 26, '', 20, 2, 4, '', 0, 1, 0, 1, 13, 0),
(26110, 'PEMBERI KERJA INDIVIDU-3', 26, '', 21, 3, 4, '', 0, 1, 0, 1, 13, 0),
(26111, 'PEMBERI KERJA KELOMPOK-1', 26, '', 19, 1, 4, '', 0, 1, 0, 1, 14, 0),
(26112, 'PEMBERI KERJA KELOMPOK-2', 26, '', 20, 2, 4, '', 0, 1, 0, 1, 14, 0),
(26113, 'PEMBERI KERJA KELOMPOK-3', 26, '', 21, 3, 4, '', 0, 1, 0, 1, 14, 0),
(26114, 'BUKAN PEKERJA LAIN-LAIN-1', 26, '', 19, 1, 4, '', 0, 1, 0, 1, 15, 0),
(26115, 'BUKAN PEKERJA LAIN-LAIN-2', 26, '', 20, 2, 4, '', 0, 1, 0, 1, 15, 0),
(26116, 'BUKAN PEKERJA LAIN-LAIN-3', 26, '', 21, 3, 4, '', 0, 1, 0, 1, 15, 0),
(26117, 'PBI (APBN)', 26, '', 21, 3, 4, '', 1, 1, 0, 1, 16, 0),
(26118, 'CACAT TOTAL TETAP DAN TIDAK MAMPU (APBN)', 26, '', 21, 3, 4, '', 1, 1, 0, 1, 17, 0),
(26119, 'PHK > BULAN DAN TIDAK MAMPU (APBN)', 26, '', 21, 3, 4, '', 1, 1, 0, 1, 18, 0),
(26120, 'PBI (APBD)', 26, '', 21, 3, 4, '', 1, 1, 0, 1, 19, 0),
(26121, 'CACAT TOTAL TETAP DAN TIDAK MAMPU (APBD)', 26, '', 21, 3, 4, '', 1, 1, 0, 1, 20, 0),
(26122, 'PHK > BULAN DAN TIDAK MAMPU (APBD)', 26, '', 21, 3, 4, '', 1, 1, 0, 1, 21, 0),
(26124, 'PEKERJA SEKTOR INFORMAL INDIVIDU-2', 26, '', 20, 2, 4, '', 1, 1, 0, 1, 4, 0),
(26125, 'PEKERJA SEKTOR INFORMAL INDIVIDU-1', 26, '', 19, 1, 4, '', 1, 1, 0, 1, 4, 0),
(26126, 'JAMKESDA 3', 5, '', 21, 0, 3, '', 0, 1, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `a_unit`
--

CREATE TABLE `a_unit` (
  `KodeUnit` int(11) NOT NULL,
  `NamaUnit` varchar(50) DEFAULT NULL,
  `unit_tipe` tinyint(4) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '0 : Tidak dipakai\r\n1 : dipakai ',
  `KodePoliRujukan` char(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci COMMENT='Status 0: Non Aktif 1: Aktif';

--
-- Dumping data untuk tabel `a_unit`
--

INSERT INTO `a_unit` (`KodeUnit`, `NamaUnit`, `unit_tipe`, `status`, `KodePoliRujukan`) VALUES
(1, 'LOKET PENDAFTARAN IGD', 0, 0, '0'),
(100, 'PENSIUN / KELUAR', 0, 0, '0'),
(101, 'THT', 2, 1, 'THT'),
(102, 'BEDAH', 2, 1, 'BED'),
(103, 'ORTHOPEDY', 2, 1, 'ORT'),
(104, 'REHAB MEDIS', 2, 1, 'IRM'),
(105, 'GIGI', 2, 1, 'GIG'),
(106, 'INTERNE', 2, 1, 'INT'),
(107, 'MATA', 2, 1, 'MAT'),
(108, 'OBGYN', 2, 1, 'OBG'),
(109, 'ANAK', 2, 1, 'ANA'),
(110, 'KULIT DAN KELAMIN', 2, 1, 'KLT'),
(111, 'SYARAF', 2, 1, 'SAR'),
(112, 'PARU', 2, 1, 'PAR'),
(113, 'JANTUNG', 2, 1, 'JAN'),
(114, 'BEDAH MULUT', 2, 1, 'BDM'),
(115, 'BEDAH PLASTIK', 3, 0, 'BDP'),
(116, 'GIZI', 3, 0, '0'),
(117, 'IGD', 1, 1, 'IGD'),
(118, 'JIWA', 2, 1, 'JIW'),
(119, 'HEMODIALISA', 2, 0, '0'),
(120, 'VCT', 2, 1, 'HIV'),
(121, 'ANASTESI', 2, 0, 'ANT'),
(128, 'ORTHODENTI', 2, 1, 'GOR'),
(129, 'NEONATUS', 3, 0, '0'),
(201, 'IRNA GARUDA', 1, 0, '0'),
(202, 'PAVILYUN B', 9, 0, '0'),
(203, 'PAVILYUN C', 9, 0, '0'),
(204, 'IRNA NUSA INDAH', 1, 0, '0'),
(205, 'TANJUNG', 1, 0, '0'),
(206, 'SERUNI', 1, 0, '0'),
(207, 'FLAMBOYAN', 1, 0, '0'),
(208, 'BERSALIN', 1, 0, '0'),
(209, 'CEMPAKA', 1, 0, '0'),
(219, 'NEONATUS', 1, 0, '0'),
(301, 'RADIOLOGI/ CT SCAN', 3, 0, '0'),
(304, 'Recovery Room (RR)', 1, 0, '0'),
(305, 'Operasi Kamar (OK)', 1, 0, '0'),
(306, 'PATOLOGI ANATOMI', 4, 0, '0'),
(307, 'Hemodialisis (HD)', 1, 0, '0'),
(308, 'LABORAT IRD', 4, 0, '0'),
(401, 'ICU', 1, 0, '0'),
(402, 'OK SENTRAL', 4, 0, '0'),
(501, 'GUDANG OBAT PNS', 6, 0, '0'),
(502, 'GUDANG OBAT REGULER', 6, 0, '0'),
(503, 'GUDANG OBAT FLOOR STOK', 6, 0, '0'),
(504, 'APOTIK TIMUR', 7, 0, '0'),
(505, 'APOTIK BARAT REGULER', 7, 0, '0'),
(506, 'APOTIK BARAT PNS', 7, 0, '0'),
(701, 'PENDAFTARAN RAWAT JALAN', 8, 0, '0'),
(702, 'REKAM MEDIK RAWAT JALAN', 9, 0, '0'),
(703, 'REKAM MEDIK RAWAT INAP', 9, 0, '0'),
(704, 'PENGENDALI ASKES', 10, 0, '0'),
(705, 'PENDAFTARAN RAWAT INAP', 8, 0, '0'),
(714, 'LOKET PEMBAYARAN', 11, 0, '0'),
(715, 'PEMERIKSAAN KESEHATAN', 2, 1, '0'),
(716, 'POLI PAVILIUN', 3, 0, '0'),
(717, 'UROLOGY', 2, 1, 'URO'),
(718, 'CENDANA', 1, 0, '0'),
(719, 'MELATI', 1, 0, '0'),
(720, 'PATOLOGI KLINIK', 3, 0, '0'),
(722, 'DOT', 2, 0, '0'),
(723, 'LUAR RUMAH SAKIT', 2, 0, '0'),
(733, 'GIZI', 2, 1, '0'),
(734, 'CENDANA II', 1, 0, '0'),
(735, 'RADIOLOGI', 2, 0, 'RDO'),
(736, 'LABORAT', 2, 0, 'PAK'),
(737, 'PATOLOGI ANATOMI', 2, 0, '0'),
(738, 'IGD', 2, 0, '0'),
(739, 'KANTOR IT', 3, 0, '0'),
(740, 'LABORAT PCR', 2, 0, 'PAK'),
(741, 'GIGI ENDODONSI', 2, 1, 'GND'),
(742, 'BANK DARAH', 3, 0, '0'),
(743, 'BEDAH ANAK', 2, 1, '0'),
(744, 'POLI INFEKSI', 2, 0, '0'),
(745, 'ICU COVID 19', 1, 0, '0'),
(746, 'BEDAH SYARAF', 2, 1, '0');

-- --------------------------------------------------------

--
-- Struktur dari tabel `dm_agama`
--

CREATE TABLE `dm_agama` (
  `id_agama` int(10) UNSIGNED NOT NULL,
  `nama_agama` varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `dm_agama`
--

INSERT INTO `dm_agama` (`id_agama`, `nama_agama`) VALUES
(5, 'Buddha'),
(4, 'Hindu'),
(1, 'Islam'),
(3, 'Katolik'),
(6, 'Kepercayaan YME'),
(2, 'Kristen');

-- --------------------------------------------------------

--
-- Struktur dari tabel `dm_dokter`
--

CREATE TABLE `dm_dokter` (
  `id_dokter` int(11) NOT NULL,
  `nama_dokter` varchar(255) NOT NULL,
  `jenis_dokter` varchar(255) NOT NULL,
  `prosentasi_jasa` double NOT NULL,
  `alamat_praktik` varchar(255) NOT NULL,
  `telp` varchar(100) NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `pegawai_id` varchar(20) DEFAULT NULL,
  `nama_panggilan` varchar(100) NOT NULL,
  `NamaUnit` varchar(50) NOT NULL,
  `KodePoli` int(11) NOT NULL,
  `nip` varchar(50) DEFAULT NULL,
  `is_aktif` char(1) NOT NULL DEFAULT '0' COMMENT '0=aktif 1=tidak aktif'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `dm_dokter`
--

INSERT INTO `dm_dokter` (`id_dokter`, `nama_dokter`, `jenis_dokter`, `prosentasi_jasa`, `alamat_praktik`, `telp`, `created`, `pegawai_id`, `nama_panggilan`, `NamaUnit`, `KodePoli`, `nip`, `is_aktif`) VALUES
(1, '', '-', 0, '-', '-', '2021-04-21 05:32:35', 'PEG00000000000000043', '', 'IGD', 0, NULL, '0'),
(2, 'dr. Budi Shanjaya', 'UMUM', 100, '-', '-', '2020-12-15 03:16:30', NULL, 'dr. Budi', 'IGD', 0, NULL, '0'),
(3, 'dr. Clarabella', 'UMUM', 100, '-', '-', '2020-12-15 03:16:30', 'PEG00000000000000043', 'bella', 'IGD', 0, NULL, '0'),
(4, 'dr. Agus Sukisno', 'UMUM', 100, '-', '-', '2020-12-15 03:16:30', NULL, 'dr. Agus', 'IGD', 0, NULL, '0'),
(5, 'dr. Gilang Kusdinar', 'UMUM', 100, '-', '-', '2020-12-15 03:16:30', NULL, 'dr. Gilang', 'IGD', 0, NULL, '0'),
(6, 'dr. Chasan Ismail, Sp. A', 'AHLI', 100, '-', '-', '2022-09-15 00:56:59', 'PEG00000000000000043', 'dr. Chasan', 'ANAK', 109, '19859822 201101 1 006', '0'),
(7, 'dr. Muchammad Dzikrul Haq K , Sp.JP', 'AHLI', 1, '-', '-', '2022-10-10 07:01:10', 'PEG00000000000000043', 'Dziikrul Haq K , Sp.JP', 'JANTUNG', 113, '19850821 201101 1 005', '0'),
(8, 'dr. Hermawan Chrisdiono, Sp.P.', 'AHLI', 0, '', '', '2022-08-11 03:30:19', NULL, 'dr. Hermawan', 'PARU', 112, '19600412 198801 1 003', '0'),
(9, 'dr. I G Ketut Putra, Sp. THT.', 'AHLI', 0, '', '', '2022-08-12 07:01:37', NULL, 'dr. Ketut', 'THT', 101, '-', '0'),
(10, 'dr. R. Soerjatmono, Sp.A.', 'AHLI', 0, '', '', '2022-07-22 02:28:23', NULL, 'dr. Soer', 'PENSIUN / KELUAR', 0, '', '1'),
(11, 'drg. Joko Widiastomo, Sp. BM.', '', 0, '', '', '0000-00-00 00:00:00', NULL, '', 'BEDAH MULUT', 114, '19610520 198711 1 001', '0'),
(12, 'dr. Ayu Sesary', 'UMUM', 0, '-', '-', '2020-12-15 03:16:30', 'PEG00000000000000043', 'dr. Ayu Sesary', 'IGD', 0, NULL, '0'),
(13, 'dr. Maulana Syamsuri, Sp.OG.', 'AHLI', 0, '', '', '2022-08-11 02:53:11', NULL, 'dr. Maulana', 'OBGYN', 0, NULL, '1'),
(14, 'dr. Agus. Wahyu Widodo, Sp.KK.', 'AHLI', 0, '', '', '2022-07-28 12:12:21', NULL, 'dr. Agus.', 'KULIT DAN KELAMIN', 0, NULL, '1'),
(15, 'dr. Erwin Ichsan Prabowo, Sp. PK', 'AHLI', 0, '', '', '2021-07-21 05:58:22', NULL, 'dr. Erwin', 'LABORAT', 0, NULL, '0'),
(16, 'dr. Iwan Donosepoetro, Sp.B.', 'AHLI', 0, '', '', '2022-11-16 02:38:19', NULL, 'dr. Iwan', 'BEDAH', 102, '19630317 199002 1 001', '0'),
(17, 'dr. Raden Gatut Rahardjo, Sp. An', 'AHLI', 0, '0', '0', '2020-12-15 05:00:39', NULL, 'dr. Gatut', 'ANASTESI', 0, NULL, '0'),
(18, 'dr. Achmad Nasrullah, Sp.B', 'AHLI', 0, '', '', '2022-08-02 01:39:44', NULL, 'dr. Achmad', 'PENSIUN / KELUAR', 0, NULL, '1'),
(19, 'dr. Achmad Prihatin, Sp.PD.', 'AHLI', 0, '', '', '2022-07-28 12:15:27', NULL, 'dr. Achmad', 'INTERNE', 0, NULL, '1'),
(20, '(kosong)', 'UMUM', 0, '-', '-', '2021-09-24 01:42:28', 'PEG00000000000000043', '', 'PENSIUN / KELUAR', 0, NULL, '0'),
(21, 'dr. Yoyok Prasetijo Kristiadi, Sp.OT.', 'AHLI', 0, '', '', '2022-11-14 02:23:25', NULL, 'dr. Yoyok', 'ORTHOPEDY', 103, '19661027 199707 1 001', '0'),
(22, 'dr. Sukoco, Sp.S', 'AHLI', 0, '', '', '2022-11-16 02:27:51', NULL, 'dr. Sukoco,', 'SYARAF', 111, '19640526 200604 1 004', '0'),
(23, 'dr. Dodo Wikanto, Sp U', 'AHLI', 0, '', '', '2022-08-16 02:27:09', NULL, 'dr. Dodo', 'UROLOGY', 717, '19670613 200604 1 004', '0'),
(24, 'dr. Rudolf Rudy Budiantoro, Sp.B', 'AHLI', 0, '', '', '2022-11-16 02:37:50', NULL, 'dr. Rudolf', 'BEDAH', 102, '19671228 201001 1 003', '0'),
(25, 'dr. Tony Widyanto, Sp OG', 'AHLI', 0, '', '', '2021-11-15 03:21:32', NULL, 'dr. Tony', 'PENSIUN / KELUAR', 0, NULL, '0'),
(26, 'dr. Wahyu Nur Alamsyah, Sp B', 'AHLI', 0, '', '', '2022-11-16 02:42:38', NULL, 'dr. Wahyu', 'BEDAH', 102, '19780609 200501 1 011', '0'),
(27, 'dr. Dadang Wibowo, Sp.OG', 'AHLI', 0, '', '', '2022-08-11 02:53:14', NULL, 'dr. Dadang', 'OBGYN', 0, NULL, '1'),
(28, 'dr. Harnowo Wilujeng, Sp PD ', 'AHLI', 0, '', '', '2020-12-15 03:30:27', NULL, 'dr. Harnowo', 'INTERNE', 0, NULL, '0'),
(29, 'dr. Dodi Kriswanto, Sp PD', 'AHLI', 0, '', '', '2022-09-29 03:09:51', NULL, 'dr. Dodi', 'INTERNE', 106, '19730321 200312 1 005', '0'),
(30, 'dr. Tjoky M. Panggabean, Sp. KJ.', 'AHLI', 0, '', '', '2022-11-14 02:17:31', NULL, 'dr. Tjoky', 'JIWA', 118, NULL, '0'),
(31, 'dr. Nanik Yuliana, Sp Rad', 'AHLI', 0, '', '', '2022-04-19 03:07:44', NULL, 'dr. Nanik', 'RADIOLOGI', 0, NULL, '0'),
(32, 'dr. Asnawati Madjri, Sp.PA.', 'AHLI', 0, '', '', '2020-12-15 03:27:17', NULL, 'dr. Asnawati', 'PATOLOGI ANATOMI', 0, NULL, '0'),
(33, 'dr. Dewi Gunawan, Sp.RM.', 'AHLI', 0, '', '', '2022-11-16 03:02:45', NULL, 'dr. Dewi', 'REHAB MEDIS', 104, '19620404 199003 2 005', '0'),
(34, 'dr. Thomasia Sri Kristiani, Sp,M', 'AHLI', 0, '', '', '2022-08-11 02:39:46', NULL, 'dr. Thomasia', 'MATA', 107, '19651221 199103 2 008', '0'),
(35, 'dr. Hamidah Tri Handajani, Sp.OG.', 'AHLI', 0, '', '', '2022-08-11 02:55:19', NULL, 'dr. Hamidah', 'OBGYN', 108, '19641002 199003 2 004', '0'),
(36, 'dr. Luluk Aflakah, Sp. PD.', 'AHLI', 0, '', '', '2022-09-29 03:10:18', NULL, 'dr. Luluk', 'INTERNE', 106, '19641224 199011 2 001', '0'),
(37, 'dr. Dyah Ayu', 'UMUM', 0, '-', '-', '2020-12-15 03:16:30', 'PEG00000000000000043', 'dr. Dyah Ayu', 'IGD', 0, NULL, '0'),
(38, 'dr. Lidwina Ratna Dewi, Sp. THT', 'AHLI', 0, '', '', '2022-08-12 07:01:35', NULL, 'dr. Lidwina', 'THT', 101, '19710806 200604 2 021', '0'),
(39, 'dr. Andrea Ika Hapsari, Sp.An.M. Kes', 'AHLI', 0, '', '', '2021-11-25 05:53:53', NULL, 'dr. Andrea', 'ANASTESI', 0, NULL, '0'),
(40, 'drg. Dini Setya Rini, Sp. Ort ', 'AHLI', 0, '', '', '2022-11-14 03:47:02', NULL, 'dr. Dini', 'ORTHODENTI', 128, '19800513 200604 2 022', '0'),
(41, 'dr. Nikmah Ernawati, Sp OG', 'AHLI', 0, '', '', '2022-12-15 05:07:24', NULL, 'dr. Nikmah', 'OBGYN', 108, '19781123 200604 2 016', '0'),
(42, 'dr. Meliza Madona, Sp A ', 'AHLI', 0, '', '', '2022-09-15 00:56:21', NULL, 'dr. Meliza', 'ANAK', 109, '19800525 200604 2 043', '0'),
(43, 'dr. Greselia Hilbarida Mendrofa, Sp OG', 'AHLI', 0, '', '', '2022-08-11 02:55:38', NULL, 'dr. Greselia', 'OBGYN', 108, '19781123 200604 2 016', '0'),
(44, 'dr. Anggayasti, Sp A', 'AHLI', 0, '', '', '2022-08-10 03:30:48', NULL, 'dr. Anggayasti,', 'PENSIUN / KELUAR', 0, NULL, '1'),
(45, 'dr. Arifin,Sp OT', 'AHLI', 0, '0', '0', '2022-11-14 02:24:05', 'PEG00000000000000043', 'dr. Arifin', 'ORTHOPEDY', 103, '19850406 201101 1 014', '0'),
(46, 'dr. Hafidz Syah Hasan', 'UMUM', 0, '0', '0', '2020-12-15 03:16:30', NULL, 'dr. Hafidz', 'IGD', 0, NULL, '0'),
(47, 'dr. Tegar Fadeli Arrahma', 'UMUM', 0, '0', '0', '2020-12-15 03:16:30', NULL, 'dr. Tegar', 'IGD', 0, NULL, '0'),
(48, 'dr. Banu Eko Susanto', 'UMUM', 0, '0', '0', '2020-12-15 03:16:30', NULL, 'dr. Banu', 'IGD', 0, NULL, '0'),
(49, 'dr. Houdini Pradanawan Subagyo', 'UMUM', 0, '0', '0', '2020-12-15 03:16:30', NULL, 'dr. Houdini', 'IGD', 0, NULL, '0'),
(50, 'dr. Nurisnan Olfyanto Suwono', 'UMUM', 0, '0', '0', '2020-12-15 03:16:30', NULL, 'dr. Nurisnan', 'IGD', 0, NULL, '0'),
(51, 'dr. Caesar Ensang Timuda', 'UMUM', 0, '0', '0', '2020-12-15 03:16:30', NULL, 'dr. Caesar', 'IGD', 0, NULL, '0'),
(52, 'dr. Binti Ratna Khomsiyatin', 'UMUM', 0, '-', '-', '2022-11-03 01:37:32', NULL, 'dr. Binti', 'VCT', 120, '19750811 200604 2 020', '0'),
(53, 'dr. Arantrinita, Sp.M', 'AHLI', 0, '0', '0', '2022-08-11 02:38:44', 'PEG00000000000000043', 'dr. Arantrinita', 'MATA', 107, '19860902 201101 2 014', '0'),
(54, 'dr. Etiwasesa', 'UMUM', 0, '0', '0', '2022-11-14 02:27:31', NULL, 'dr. Etiwasesa', 'PEMERIKSAAN KESEHATAN', 715, '19840118 200901 2 005', '0'),
(55, 'dr. Ellen Trio Sukma Dewi', 'UMUM', 0, '-', '-', '2020-12-15 04:20:06', NULL, 'dr. Ellen', 'PEMERIKSAAN KESEHATAN', 0, NULL, '0'),
(56, 'drg. Budi Susanto', 'GIGI', 0, '', '', '2022-08-12 01:39:52', NULL, 'dr. Budi', 'GIGI', 105, '19650725 199103 1 013', '0'),
(57, 'dr. Ervan Aditya Putra C', 'UMUM', 0, '-', '-', '2020-12-15 03:16:30', 'PEG00000000000000043', 'dr. Ervan', 'IGD', 0, NULL, '0'),
(58, 'drg. Sri Wahyuni', 'GIGI', 0, '', '', '2022-08-12 01:39:55', NULL, 'dr. Sri', 'GIGI', 105, '19720609 200312 2 005', '0'),
(61, 'dr Yogi', 'UMUM', 100, '-', '-', '2020-12-15 03:16:30', NULL, 'dr. Yogi', 'IGD', 0, NULL, '0'),
(62, 'dr.Ferrie Budianto, Sp.An', 'AHLI', 100, 'Kediri', '081234567', '2020-12-15 03:16:30', NULL, 'dr. Ferrie', 'IGD', 0, NULL, '0'),
(63, 'dr. Agustian', 'UMUM', 0, '0', '0', '2020-12-15 03:16:30', NULL, 'dr. Agustian', 'IGD', 0, NULL, '0'),
(64, 'dr. Albert', 'UMUM', 0, '0', '0', '2020-12-15 03:16:30', NULL, 'dr. Albert', 'IGD', 0, NULL, '0'),
(65, 'dr. Dana', 'UMUM', 0, '0', '0', '2020-12-15 03:16:30', NULL, 'dr. Dana', 'IGD', 0, NULL, '0'),
(66, 'dr. Rina', 'UMUM', 0, '0', '0', '2020-12-15 03:16:30', NULL, 'dr. Rina', 'IGD', 0, NULL, '0'),
(67, 'dr. Chaliatul', 'UMUM', 0, '-', '-', '2020-12-15 03:16:30', NULL, 'dr. Chaliatul', 'IGD', 0, NULL, '0'),
(68, 'dr. Sonia', 'UMUM', 0, '-', '-', '2020-12-15 03:16:30', NULL, 'dr. Sonia', 'IGD', 0, NULL, '0'),
(69, 'dr. Afies Sjughiarto Muhammad, Sp. JP. MMRS', 'AHLI', 100, '0', '0', '2022-07-28 12:15:45', NULL, 'dr. Afies', 'PENSIUN / KELUAR', 0, NULL, '1'),
(70, 'dr. Cahya', 'UMUM', 1, '1', '1', '2020-12-15 03:16:30', NULL, 'dr. Cahya', 'IGD', 0, NULL, '0'),
(71, 'dr. Rina', 'UMUM', 0, '-', '0', '2020-12-15 03:16:30', 'PEG00000000000000043', 'dr. RINA', 'IGD', 0, NULL, '0'),
(72, 'dr. Riesti', 'UMUM', 0, '-', '0', '2020-12-15 03:16:30', 'PEG00000000000000043', 'dr. RIESTI', 'IGD', 0, NULL, '0'),
(73, 'dr. LILI', 'UMUM', 1, '-', '0', '2020-12-15 03:16:30', NULL, 'dr. LILI', 'IGD', 0, NULL, '0'),
(74, 'dr. Willy', 'UMUM', 100, 'PARE', '391169', '2020-12-15 03:16:30', NULL, 'dr. Willy', 'IGD', 0, NULL, '0'),
(75, 'dr. Ellok', 'UMUM', 100, 'PARE', '391169', '2020-12-15 03:16:30', NULL, 'dr. Ellok', 'IGD', 0, NULL, '0'),
(76, 'dr. Riesti', 'UMUM', 100, 'PARE', '391169', '2020-12-15 03:16:30', NULL, 'dr. Riesti', 'IGD', 0, NULL, '0'),
(77, 'dr. Diah', 'UMUM', 100, 'PARE', '391169', '2020-12-15 03:16:30', NULL, 'dr. Diah', 'IGD', 0, NULL, '0'),
(78, 'dr. Rizka', 'UMUM', 0, '-', '-', '2020-12-15 03:16:30', NULL, 'dr. Rizka', 'IGD', 0, NULL, '0'),
(79, 'dr. Interensif  Carissa IRD', 'UMUM', 0, '-', '0', '2020-12-15 03:16:30', NULL, 'dr. Tiara', 'IGD', 0, NULL, '0'),
(80, 'dr. Riska', 'UMUM', 0, '-', '0', '2020-12-15 03:16:30', NULL, 'dr. Riska', 'IGD', 0, NULL, '0'),
(81, 'dr. Melati', 'UMUM', 0, '-', '-', '2020-12-15 03:16:30', NULL, 'dr. Melati', 'IGD', 0, NULL, '0'),
(82, 'dr. Ririn', 'UMUM', 0, '-', '1', '2020-12-15 03:16:30', NULL, 'dr. Ririn', 'IGD', 0, NULL, '0'),
(83, 'dr. Nathania', 'UMUM', 1, '-', '0', '2020-12-15 03:16:30', NULL, 'dr. Nathania', 'IGD', 0, NULL, '0'),
(84, 'dr. Pratiwi', 'UMUM', 0, 'RSUD Kab. Kediri', '0', '2020-12-15 03:16:30', NULL, 'dr. Pratiwi', 'IGD', 0, NULL, '0'),
(85, 'dr. Melinda', 'UMUM', 1, '-', '0', '2020-12-15 03:16:30', NULL, 'dr. Melinda', 'IGD', 0, NULL, '0'),
(86, 'dr. Mukhti', 'UMUM', 0, '0', '0', '2020-12-15 03:16:30', NULL, 'dr. Mukhti', 'IGD', 0, NULL, '0'),
(87, 'dr. Firman', 'UMUM', 0, '-', '0', '2020-12-15 03:16:30', NULL, 'dr. Firman', 'IGD', 0, NULL, '0'),
(88, 'dr. William Sulistyono Putra', 'UMUM', 0, '-', '0', '2020-12-15 03:16:30', 'PEG00000000000000043', 'dr. William', 'IGD', 0, NULL, '0'),
(89, 'dr. Dalia', 'UMUM', 0, 'RSUD Pare', '0', '2020-12-15 03:16:30', NULL, 'dr. Dalia', 'IGD', 0, NULL, '0'),
(90, 'dr. Grafita Dwi Kartika Sari', 'UMUM', 0, '0', '0', '2022-10-11 05:57:22', 'PEG00000000000000043', 'dr. Grafita', 'IGD', 0, NULL, '0'),
(91, 'dr. Beatrix Rosella Anjani', 'UMUM', 0, 'RSUD Kab.Kediri', '0', '2022-09-14 04:23:43', 'PEG00000000000000043', 'dr. Beatrix', 'IGD', 0, '19901216 202012 2 010', '0'),
(92, 'dr. Andre Eka Putra Prakoso', 'UMUM', 0, '-', '0', '2022-09-14 04:24:48', 'PEG00000000000000043', 'dr. Andre', 'IGD', 0, '19900519 201903 1 004', '0'),
(93, 'dr. Rian Akhmad, Sp. U', 'AHLI', 100, '-', '-', '2022-08-16 02:25:38', NULL, 'dr. Rian', 'UROLOGY', 717, NULL, '1'),
(95, 'dr. Interensif Filza R Inap', 'UMUM', 0, 'RSUD PARE', '0000', '2020-12-15 03:16:30', NULL, 'dr', 'IGD', 0, NULL, '0'),
(96, 'dr. Niqko Bayu Prakarsa', 'UMUM', 0, '-', '-', '2022-09-14 04:26:29', 'PEG00000000000000043', 'dr. Niqko', 'IGD', 0, '19871118 201502 1 002', '0'),
(97, 'dr. Fredy Satrio Nugroho', 'UMUM', 0, '0', '0', '2020-12-15 03:16:30', NULL, 'dr. Fredy', 'IGD', 0, NULL, '0'),
(98, 'dr. Nisa Amnifolia Niazta', 'UMUM', 0, '0', '0', '2020-12-15 03:16:30', NULL, 'dr. Nisa', 'IGD', 0, NULL, '0'),
(100, 'dr. Marrienda', 'UMUM', 0, '-', '0', '2020-12-15 03:16:30', NULL, 'dr. Marrienda', 'IGD', 0, NULL, '0'),
(101, 'dr. Rendy', 'UMUM', 0, '-', '0', '2022-08-10 03:30:01', NULL, 'dr. Rendy', 'IGD', 0, NULL, '1'),
(102, 'dr. Aqida L / dr. Kris', 'AHLI', 0, '-', '-', '2022-11-16 03:03:11', NULL, 'dr. Aqida L / dr. Kris', 'PENSIUN / KELUAR', 0, NULL, '1'),
(103, 'dr. Fredy Satrio Nugroho', 'UMUM', 0, 'jl', '0', '2020-12-15 03:16:30', NULL, 'dr. Fredy', 'IGD', 0, NULL, '0'),
(104, 'dr. Suasto Sulaksono', 'UMUM', 0, '-', '0', '2020-12-15 03:16:30', NULL, 'dr. Suasto Sulaksono', 'IGD', 0, NULL, '0'),
(105, 'dr. Hira Dikta Ardining', 'UMUM', 0, '-', '0', '2020-12-15 03:16:30', NULL, 'dr. Hira Dikta Ardining', 'IGD', 0, NULL, '0'),
(106, 'dr. Firda', 'UMUM', 0, '--', '==', '2020-12-15 03:16:30', NULL, 'dr. Firda', 'IGD', 0, NULL, '0'),
(107, 'dr.Raditya', 'UMUM', 100, 'pare', '0354291718', '2020-12-15 03:16:30', 'root', 'dr Raditya', 'IGD', 0, NULL, '0'),
(108, 'dr. Retti Nurlaili, Sp PD', 'AHLI', 0, 'KOSONG', 'KOSONG', '2023-01-02 03:57:10', 'PEG00000000000000043', 'RETTI', 'INTERNE', 106, '19860330 202012 2 010', '0'),
(109, 'dr. Gede ngurah prasetya aditama', 'UMUM', 100, '-', '-', '2020-12-15 03:16:30', 'PEG00000000000000043', 'gede', 'IGD', 0, NULL, '0'),
(110, 'dr. Sholeka Chatur , Sp.JP', 'AHLI', 1, '-', '-', '2022-11-16 03:03:15', 'PEG00000000000000043', 'soleka', 'PENSIUN / KELUAR', 0, NULL, '1'),
(111, 'dr Manik', 'AHLI', 44000, 'pare', '0354391718', '2020-12-15 03:16:30', 'PEG00000000000000043', 'dr Manik', 'IGD', 0, NULL, '0'),
(112, 'dr. Phamella Esty Nuraini', 'UMUM', 0, '-', '-', '2020-12-15 03:16:30', 'PEG00000000000000043', 'mella', 'IGD', 0, NULL, '0'),
(113, 'dr. Rudy eka arethusa putra, Sp. U', 'AHLI', 100, '-', '-', '2022-08-16 02:27:04', 'PEG00000000000000043', 'dr. Rudi', 'UROLOGY', 717, '19871203 202203 1 002', '0'),
(114, 'dr. Dwi Wahyu Setyo Irawan', 'UMUM', 100, 'ird', '012', '2020-12-16 05:51:42', 'PEG00000000000000043', 'dr. Wahyu', 'IGD', 0, NULL, '0'),
(115, 'dr. Shaffan Ula Prasetyo', 'UMUM', 100, '-', '-', '2020-12-15 03:16:30', 'PEG00000000000150304', 'dr. Shaffan', 'IGD', 0, NULL, '0'),
(120, 'dr. Norma Khoirun Nisa', 'UMUM', 100, 'ird', '', '2021-02-01 06:07:42', NULL, 'dr. Norma', 'IGD', 0, NULL, '0'),
(122, 'dr. Devi Maharani,Sp.KK', 'AHLI', 100, 'RSUD PARE', '-', '2022-11-16 03:03:20', NULL, 'dr. Devi', 'PENSIUN / KELUAR', 0, NULL, '1'),
(128, 'Drg. Zefry zainal abidin Sp.BM, M.Ked.Klin', '', 0, '', '', '0000-00-00 00:00:00', NULL, '', 'BEDAH MULUT', 114, '19861230 202012 1 005', '0'),
(129, 'drg. Elisa Kusuma Wardani, Sp.KG', 'AHLI', 100, '-', '-', '2022-11-14 04:48:52', NULL, 'dr. elisa', 'GIGI ENDODONSI', 741, '19840115 201001 2 016', '0'),
(131, 'dr. Okti Rahmawati', 'UMUM', 0, '-', '-', '2021-04-13 06:11:36', NULL, 'dr okti', 'IGD', 0, NULL, '0'),
(133, 'dr.Arifandi Dwi S,S.BA, M.Kedklin', 'AHLI', 0, '-', '-', '2022-11-14 04:55:59', NULL, 'dr. Arifandi', 'BEDAH ANAK', 743, NULL, '0'),
(134, 'dr.Alfi Marindi Fitrianti', 'UMUM', 0, '-', '-', '2021-04-20 03:29:28', NULL, 'dr alfi', 'IGD', 0, NULL, '0'),
(135, 'dr. Bagas Satrio Utomo,Sp.B', 'AHLI', 100, '-', '-', '2022-12-29 02:43:42', NULL, 'dr. Bagas', 'BEDAH', 102, NULL, '0'),
(136, 'dr.Tri Abdi Rahman', 'UMUM', 0, '-', '-', '2021-04-21 05:32:06', NULL, 'dr.Tri', 'IGD', 0, NULL, '0'),
(139, 'dr.Made Kusuma Dewi, M.M.Biomed, Sp.KK', 'AHLI', 100, '-', '-', '2022-11-14 02:33:11', NULL, 'dr made', 'KULIT DAN KELAMIN', 110, NULL, '0'),
(146, 'dr. Kasih Karunia', 'UMUM', 0, '-', '-', '2021-07-21 03:28:15', NULL, 'dr. Kasih', 'IGD', 0, NULL, '0'),
(147, 'dr. Yulia Lusiana Sari', 'UMUM', 0, '-', '-', '2021-07-21 03:29:17', NULL, 'dr. Lusi', 'IGD', 0, NULL, '0'),
(148, 'dr. Arina Nuril Fauziyah', 'UMUM', 0, '-', '-', '2021-07-21 03:29:51', NULL, 'dr. Arina', 'IGD', 0, NULL, '0'),
(149, 'dr. Erwin Ichsan Prabowo, Sp. PK', 'AHLI', 0, '', '', '2021-07-21 06:26:24', NULL, 'dr ichan', 'LABORAT PCR', 0, NULL, '0'),
(150, 'dr. Trinita D.Permatasari', 'UMUM', 100, '-', '-', '2021-08-12 03:38:09', NULL, 'dr. Trinita', 'IGD', 0, NULL, '0'),
(154, 'dr. Yudha Fitria Prasetyo, M.Kedklin, Sp.B.S', 'AHLI', 0, '', '', '2022-09-06 03:42:06', NULL, 'dr Yudha Fitria', 'BEDAH SYARAF', 746, NULL, '0'),
(155, 'dr Akbar Wido,Sp.B.S', 'AHLI', 100, '-', '-', '2022-09-06 03:43:32', NULL, 'dr wido', 'BEDAH SYARAF', 746, NULL, '0'),
(164, 'dr. Roza Insanihusna', '', 0, '', '', '0000-00-00 00:00:00', 'PEG00000000000000043', '', 'IGD', 738, '19880902 202203 2 003', '0'),
(165, 'drg. Astika Kinant Kusuma', 'AHLI', 100, '-', '-', '2022-12-30 01:49:21', NULL, 'dr. Astika', 'GIGI', 105, '19941207 202203 2 007', '0');

-- --------------------------------------------------------

--
-- Struktur dari tabel `dm_kelas`
--

CREATE TABLE `dm_kelas` (
  `id_kelas` int(11) NOT NULL,
  `jenis_rawat_id` int(11) DEFAULT 2,
  `kode_kelas` varchar(5) NOT NULL,
  `nama_kelas` varchar(100) NOT NULL,
  `kode_kelas_bpjs` varchar(3) NOT NULL DEFAULT '-',
  `kode_kelas_yankes` varchar(4) DEFAULT NULL,
  `biaya_rr_askep` double DEFAULT 0,
  `biaya_rr_monitor` double DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '0=aktif 1=tidak'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `dm_kelas`
--

INSERT INTO `dm_kelas` (`id_kelas`, `jenis_rawat_id`, `kode_kelas`, `nama_kelas`, `kode_kelas_bpjs`, `kode_kelas_yankes`, `biaya_rr_askep`, `biaya_rr_monitor`, `status`) VALUES
(1, 2, 'VIP', 'VIP', 'VIP', '0002', 0, 0, 0),
(2, 2, 'PAV B', 'Paviliun B', 'VIP', '0002', 0, 0, 1),
(3, 2, 'PAV C', 'Paviliun C', 'VIP', '0002', 0, 0, 1),
(4, 2, 'KLS 1', 'Kelas I', 'KL1', '0003', 0, 0, 0),
(5, 2, 'KLS 2', 'Kelas II', 'KL2', '0004', 0, 0, 0),
(6, 2, 'KLS 3', 'Kelas III', 'KL3', '0005', 0, 0, 0),
(7, 2, 'IRD', 'IRD', 'IGD', '0006', 0, 0, 0),
(8, 2, 'ALL', 'Semua', 'NON', '0006', 0, 0, 0),
(9, 2, 'KLS 1', 'Kelas I Icvcu', 'KL1', '0006', 0, 0, 1),
(10, 2, 'PONEK', 'PONEK', 'NON', '0006', 0, 0, 1),
(11, 1, 'PLD', 'POLI DALAM', 'NON', '0006', 0, 0, 0),
(12, 1, 'PLL', 'POLI LUAR', 'NON', '0006', 0, 0, 0),
(13, 2, 'POLI', 'POLI UROLOGY', '-', NULL, 0, 0, 1),
(14, 2, 'SWAB', 'PCR', 'NON', NULL, 0, 0, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `jenis_visite`
--

CREATE TABLE `jenis_visite` (
  `id_jenis_visite` int(11) NOT NULL,
  `nama_visite` varchar(255) NOT NULL,
  `kode_visite` varchar(10) DEFAULT '-',
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `kelas_tingkat` int(11) DEFAULT 0,
  `biaya` double DEFAULT 0,
  `urutan` int(11) DEFAULT 0,
  `is_deleted` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `jenis_visite`
--

INSERT INTO `jenis_visite` (`id_jenis_visite`, `nama_visite`, `kode_visite`, `created`, `kelas_tingkat`, `biaya`, `urutan`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 'Visite Dokter Ahli', 'VISITE', '2017-01-14 06:22:00', 1, 90000, 1, 0, '2019-03-22 02:17:01', '2019-03-22 02:17:01'),
(2, 'Visite Dokter Umum', 'VISITE', '2017-01-14 06:22:00', 1, 75000, 2, 1, '2019-03-22 02:17:01', '2019-03-22 02:18:31'),
(3, 'Konsul Dokter Ahli', 'KONSUL', '2017-01-14 06:22:00', 1, 105000, 3, 0, '2019-03-22 02:17:01', '2019-03-22 02:17:01'),
(4, 'Visite Dokter Ahli', 'VISITE', '2017-07-10 10:24:59', 4, 50000, 1, 0, '2019-03-22 02:17:01', '2019-03-22 02:17:01'),
(5, 'Visite Dokter Umum', 'VISITE', '2017-07-10 10:25:11', 4, 40000, 2, 1, '2019-03-22 02:17:01', '2019-03-22 02:18:34'),
(6, 'Konsul Dokter Ahli', 'KONSUL', '2017-07-10 10:25:36', 4, 45000, 3, 0, '2019-03-22 02:17:01', '2019-03-22 02:17:01'),
(7, 'Visite Dokter Ahli', 'VISITE', '2017-07-10 10:26:01', 5, 45000, 1, 0, '2019-03-22 02:17:01', '2019-03-22 02:17:01'),
(8, 'Visite Dokter Umum', 'VISITE', '2017-07-10 10:26:19', 5, 35000, 2, 1, '2019-03-22 02:17:01', '2019-03-22 02:18:37'),
(9, 'Konsul Dokter Ahli', 'KONSUL', '2017-07-10 10:26:34', 5, 22500, 3, 0, '2019-03-22 02:17:01', '2019-03-22 02:17:01'),
(10, 'Visite Dokter Ahli', 'VISITE', '2017-07-10 10:26:51', 6, 40000, 1, 0, '2019-03-22 02:17:01', '2019-03-22 02:17:01'),
(11, 'Visite Dokter Umum', 'VISITE', '2017-07-10 10:27:05', 6, 30000, 2, 1, '2019-03-22 02:17:01', '2019-03-22 02:18:39'),
(12, 'Konsul Dokter Ahli', 'KONSUL', '2017-07-10 10:27:20', 6, 12000, 3, 0, '2019-03-22 02:17:01', '2019-03-22 02:17:01'),
(13, 'Konsul Dokter Ahli', 'KONSUL', '2018-03-09 03:36:20', 7, 44000, 3, 0, '2019-03-22 02:17:01', '2019-03-22 02:17:01'),
(14, 'Dokter Pendamping', 'PDP', '2018-05-30 06:05:04', 5, 35000, 4, 0, '2019-03-22 02:17:01', '2019-03-22 02:17:01'),
(15, 'Dokter Pendamping', 'PDP', '2018-05-30 06:05:33', 6, 35000, 4, 0, '2019-03-22 02:17:01', '2019-03-22 02:17:01'),
(16, 'Dokter Pendamping', 'PDP', '2018-05-30 06:05:45', 4, 35000, 4, 0, '2019-03-22 02:17:01', '2019-03-22 02:17:01'),
(17, 'Visite IRD', 'VISITE IRD', '2018-07-24 04:29:08', 1, 36000, 0, 0, '2019-03-22 02:17:01', '2019-03-22 02:17:01'),
(18, 'Visite IRD', 'VISITE IRD', '2018-07-24 04:29:08', 4, 36000, 0, 0, '2019-03-22 02:17:01', '2019-03-22 02:17:01'),
(19, 'Visite IRD', 'VISITE IRD', '2018-07-24 04:29:08', 5, 36000, 0, 0, '2019-03-22 02:17:01', '2019-03-22 02:17:01'),
(20, 'Visite IRD', 'VISITE IRD', '2018-07-24 04:29:08', 6, 36000, 0, 0, '2019-03-22 02:17:01', '2019-03-22 02:17:01'),
(21, 'Konsul IRD ', 'KONSUL IRD', '2018-07-24 04:29:08', 1, 44000, 0, 0, '2019-03-22 02:17:01', '2019-03-22 02:17:01'),
(22, 'Konsul IRD', 'KONSUL IRD', '2018-07-24 04:29:08', 4, 44000, 0, 0, '2019-03-22 02:17:01', '2019-03-22 02:17:01'),
(23, 'Konsul IRD', 'KONSUL IRD', '2018-07-24 04:29:08', 5, 44000, 0, 0, '2019-03-22 02:17:01', '2019-03-22 02:17:01'),
(24, 'Konsul IRD', 'KONSUL IRD', '2018-07-24 04:29:08', 6, 44000, 0, 0, '2019-03-22 02:17:01', '2019-03-22 02:17:01'),
(25, 'Konsul IRD', 'KONSUL IRD', '2018-07-24 04:29:08', 7, 44000, 0, 0, '2019-03-22 02:17:01', '2019-03-22 02:17:01'),
(26, 'Visite IRD', 'VISITE IRD', '2018-07-24 04:29:08', 7, 36000, 0, 0, '2019-03-22 02:17:01', '2019-03-22 02:17:01'),
(27, 'Visite Dokter Ahli', 'VISITE', '2022-07-01 03:54:37', 9, 50000, 0, 0, '2022-07-01 03:54:37', '2022-07-01 03:54:37'),
(28, 'Visite IRD', 'VISITE', '2022-07-01 04:01:52', 9, 36000, 0, 0, '2022-07-01 04:01:52', '2022-07-01 04:01:52');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tpegawai`
--

CREATE TABLE `tpegawai` (
  `KDPEGAWAI` varchar(20) NOT NULL DEFAULT '',
  `NAMA` varchar(50) DEFAULT NULL,
  `ALAMAT` varchar(100) DEFAULT NULL,
  `KOTA` varchar(100) DEFAULT NULL,
  `KODEPOS` varchar(5) DEFAULT NULL,
  `TELEPON` varchar(20) DEFAULT NULL,
  `PONSEL` varchar(20) DEFAULT NULL,
  `EMAIL` varchar(50) DEFAULT NULL,
  `STATUS` varchar(20) DEFAULT NULL,
  `USERLOG` varchar(20) DEFAULT NULL,
  `PASSWD` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `tpegawai`
--

INSERT INTO `tpegawai` (`KDPEGAWAI`, `NAMA`, `ALAMAT`, `KOTA`, `KODEPOS`, `TELEPON`, `PONSEL`, `EMAIL`, `STATUS`, `USERLOG`, `PASSWD`) VALUES
('PEG00000000000000001', 'loket', 'Malang', 'Malang', '76176', '65748', '', '', '', 'LOKET', 'loket'),
('PEG00000000000000002', 'kasir', 'Jl. Sadewo 54', 'Malang', '65121', '0341', '0856', 'ulum_joe@yahoo.com', 'Married', 'KASIR', 'kasir'),
('PEG00000000000000003', 'lab', 'pare', 'pare', '64294', '0341', '0856790295388', '', 'married', 'LAB', 'lab'),
('PEG00000000000000004', 'IRNA GARUDA', '-', '-', '-', '-', '-', '-', '-', 'PAV', 'pav'),
('PEG00000000000000005', 'poli', 'Malang', 'Malang', '76176', '65748', '', '', '', 'POLI', 'poli'),
('PEG00000000000000006', 'sinkron', 'Jl. Sadewo 54', 'Malang', '65121', '0341', '0856', 'ulum_joe@yahoo.com', 'Married', 'SINKRON', 'sinkron'),
('PEG00000000000000007', 'info', 'pare', 'pare', '64294', '0341', '0856790295388', '', 'married', 'INFO', 'info'),
('PEG00000000000000008', 'infop', 'Jl. Sadewo 54', 'Malang', '65121', '0341', '0856', 'ulum_joe@yahoo.com', 'Married', 'INFOP', 'infop'),
('PEG00000000000000009', 'rm', 'pare', 'pare', '64294', '0341', '0856790295388', '', 'married', 'RM', 'rm'),
('PEG00000000000000010', 'go', 'Malang', 'Malang', '76176', '65748', '', '', '', 'GO', 'go'),
('PEG00000000000000011', 'Apriliana Setiyaning Lestari', 'Jl. Sadewo 54', 'Malang', '65121', '0341', '0856', 'ulum_joe@yahoo.com', 'Married', 'ana', 'ana'),
('PEG00000000000000012', 'Zuririn', 'pare', 'pare', '64294', '0341', '0856790295388', '', 'married', 'ab', 'ab'),
('PEG00000000000000013', 'distribusi', 'Jl. Sadewo 54', 'Malang', '65121', '0341', '0856', 'ulum_joe@yahoo.com', 'Married', 'DISTRIBUSI', 'distribusi'),
('PEG00000000000000014', 'la', 'pare', 'pare', '64294', '0341', '0856790295388', '', 'married', 'LA', 'la'),
('PEG00000000000000015', 'Kepala Apotik', 'Jl. Sadewo 54', 'Malang', '65121', '0341', '0856', 'ulum_joe@yahoo.com', 'Married', 'sri', 'sri'),
('PEG00000000000000016', 'Hadi Suwignyo,SE', 'Jl. Sadewo 54', 'Malang', '65121', '0341', '0856', 'ulum_joe@yahoo.com', 'Married', 'hadi', 'h'),
('PEG00000000000000017', 'Endang Priyati', 'Jl. Sadewo 54', 'Malang', '65121', '0341', '0856', 'ulum_joe@yahoo.com', 'Married', 'endang', '20091968'),
('PEG00000000000000018', 'Indraningsih', 'Jl. Sadewo 54', 'Malang', '65121', '0341', '0856', 'ulum_joe@yahoo.com', 'Married', 'Indra', '28041962'),
('PEG00000000000000019', 'Mariatul Qibtiyah, SH', 'Jl. Sadewo 54', 'Malang', '65121', '0341', '0856', 'ulum_joe@yahoo.com', 'Married', 'qib', '19660320'),
('PEG00000000000000020', 'Yuli Istiowati', 'Jl. Sadewo 54', 'Malang', '65121', '0341', '0856', 'ulum_joe@yahoo.com', 'Married', 'yuli', '19730711'),
('PEG00000000000000021', 'Anis Triwijayanti', 'pelem', 'Kediri', '65121', '0341', '0856', '', 'Married', 'lab', 'anis'),
('PEG00000000000000022', 'Yulinda', 'Jl Lawu No 7', 'Pare', '64211', '-', '085736471278', '', 'Married', 'linda', '5112013'),
('PEG00000000000000023', 'Suyantono', 'Jl. Sadewo 54', 'Malang', '65121', '0341', '0856', 'ulum_joe@yahoo.com', 'Married', 'yanto', 'yanto'),
('PEG00000000000000025', 'karmi', 'Jl. Sadewo 54', 'Malang', '65121', '0341', '0856', 'ulum_joe@yahoo.com', 'Married', 'karmi', 'karmi'),
('PEG00000000000000026', 'warti', 'Jl. Sadewo 54', 'Malang', '65121', '0341', '0856', 'ulum_joe@yahoo.com', 'Married', 'warti', 'warti'),
('PEG00000000000000027', 'nunuk', 'Jl. Sadewo 54', 'Malang', '65121', '0341', '0856', 'ulum_joe@yahoo.com', 'Married', 'nunuk', 'nunuk'),
('PEG00000000000000028', 'diyah', 'Jl. Sadewo 54', 'Malang', '65121', '0341', '0856', 'ulum_joe@yahoo.com', 'Married', 'diyah', 'diyah'),
('PEG00000000000000029', 'harmini', 'Jl. Sadewo 54', 'Malang', '65121', '0341', '0856', 'ulum_joe@yahoo.com', 'Married', 'harmini', 'harmini'),
('PEG00000000000000030', 'Ni\'matus Sholehah, S.Farm,Apt', 'Jl. Sadewo 54', 'Malang', '65121', '0341', '0856', 'ulum_joe@yahoo.com', 'Married', 'ninik', '210484'),
('PEG00000000000000033', 'Reza Pratama', 'Jl. Sadewo 54', 'Malang', '65121', '0341', '0856', 'ulum_joe@yahoo.com', 'Married', 'reza', 'rp'),
('PEG00000000000000034', 'Maria Artriana', 'Jl. Sadewo 54', 'Malang', '65121', '0341', '0856', 'ulum_joe@yahoo.com', 'Married', 'maria', 'maria'),
('PEG00000000000000035', 'Miftahul Karim', 'Jl. Sadewo 54', 'Malang', '65121', '0341', '0856', 'ulum_joe@yahoo.com', 'Married', 'karim', 'doaibu'),
('PEG00000000000000036', 'Yuni Sunaryanti', 'Jl. Sadewo 54', 'Malang', '65121', '0341', '0856', 'ulum_joe@yahoo.com', 'Married', 'yuni', 'syifa'),
('PEG00000000000000037', 'Siti Aulia Musyrifah', 'Jl. Sadewo 54', 'Malang', '65121', '0341', '0856', 'ulum_joe@yahoo.com', 'Married', 'uli', 'uli'),
('PEG00000000000000039', 'IRD', 'Jl. Sadewo 54', 'Malang', '65121', '0341', '0856', 'ulum_joe@yahoo.com', 'Married', 'daftarrj', 'billing'),
('PEG00000000000000040', 'Herneny Pemiluwati', 'Jl. Sadewo 54', 'Malang', '65121', '0341', '0856', 'ulum_joe@yahoo.com', 'Married', 'neny', 'neny'),
('PEG00000000000000041', 'Informasi', 'Jl. Sadewo 54', 'Malang', '65121', '0341', '0856', 'ulum_joe@yahoo.com', 'Married', 'info', 'info'),
('PEG00000000000000042', 'IMRON', 'PARE', 'KEDIRI', '65121', '341', '856', 'ulum_joe@yahoo.com', 'Married', 'IMRON', 'IMRON'),
('PEG00000000000000043', 'admin', 'pare', 'kediri', '0341', '085731610202', '085731610202', 'rsud.kabupatenkediri@gmail.com', 'Married', 'admin', 'admin'),
('PEG00000000000000044', 'Putri Niken', 'pare', 'pare', '1', '1', '1', '@a', 'aktif', 'putri', 'putri'),
('PEG00000000000000045', 'ana', 'Jl. Sadewo 54', 'Malang', '65121', '0341', '0856', 'ulum_joe@yahoo.com', 'Married', 'harmini', 'harmini'),
('PEG00000000000000046', 'Wiji Astutik', 'Jl. Sadewo 54', 'Malang', '65121', '0341', '0856', 'ulum_joe@yahoo.com', 'Married', 'wiji', 'wiji'),
('PEG00000000000000047', 'daftarrj', 'Jl. Sadewo 54', 'Malang', '65121', '0341', '0856', 'ulum_joe@yahoo.com', 'Married', 'daftarrj', 'billing'),
('PEG00000000000000048', 'igd', 'pare', 'pare', '64294', '085', '085', 'a@a', 'married', 'igd', 'igd'),
('PEG00000000000000049', 'tanjung', 'pare', 'pare', '64294', '085', '085', 'a@a', 'married', 'tanjung', 'tanjung'),
('PEG00000000000018123', 'IGD', '-', '-', '-', '-', '-', '-', '-', NULL, NULL),
('PEG00000000000072668', 'NUSA INDAH', 'pare', '-', '-', '-', '-', '-', '-', NULL, NULL),
('PEG00000000000093167', 'POLI BEDAH UMUM', 'PARE', '', '', '', '', '', '', NULL, NULL),
('PEG00000000000137408', 'POLI BEDAH ANAK', 'pare', '', '', '', '', '', '', NULL, NULL),
('PEG00000000000150304', 'Agung', 'Pare', 'Kediri', '', '', '', '', '', NULL, NULL),
('PEG00000000000151665', 'POLI UROLOGI', 'PARE', '', '', '', '', '', '', NULL, NULL),
('PEG00000000000159284', 'Pegawai BPJS', '', '', '', '', '', '', '', NULL, NULL),
('PEG00000000000175092', 'CEMPAKA', 'pare', '-', '-', '-', '-', '-', '-', NULL, NULL),
('PEG00000000000235222', 'POLI JIWA', 'PARE', '', '', '', '', '', '', NULL, NULL),
('PEG00000000000238486', 'POLI BEDAH MULUT', 'PARE', '', '', '', '', '', '', NULL, NULL),
('PEG00000000000251606', 'Poli Interne', '', '', '', '', '', '', '', NULL, NULL),
('PEG00000000000264714', 'POLI BEDAH TULANG', 'PARE', '', '', '', '', '', '', NULL, NULL),
('PEG00000000000304580', 'POLI MATA', 'PARE', '', '', '', '', '', '', NULL, NULL),
('PEG00000000000305016', 'ICU', 'pare', '-', '-', '-', '-', '-', '-', NULL, NULL),
('PEG00000000000305454', 'POLI VCT', 'PARE', '', '', '', '', '', '', NULL, NULL),
('PEG00000000000314354', 'POLI KULIT KELAMIN', 'PARE', '', '', '', '', '', '', NULL, NULL),
('PEG00000000000322953', 'POLI BEDAH SYARAF', 'RSUD Kabupaten Kediri', 'Kediri', '64213', '', '', '', '', NULL, NULL),
('PEG00000000000344191', 'MAWAR', 'pare', '-', '-', '-', '-', '-', '-', NULL, NULL),
('PEG00000000000344325', 'PRAPTO', '', '', '', '', '', '', '', NULL, NULL),
('PEG00000000000356840', 'CEMPAKA (US)', 'pare', '-', '-', '-', '-', '-', '-', NULL, NULL),
('PEG00000000000360478', 'POLI JANTUNG', 'PARE', '', '', '', '', '', '', NULL, NULL),
('PEG00000000000371244', 'hemodialisa', '', '', '', '', '', '', '', NULL, NULL),
('PEG00000000000387639', 'POLI SYARAF', 'PARE', '', '', '', '', '', '', NULL, NULL),
('PEG00000000000390182', 'POLI ANAK', 'PARE', '', '', '', '', '', '', NULL, NULL),
('PEG00000000000396395', 'SUJIMAN', 'Pare', 'Kediri', '', '', '', '', '', NULL, NULL),
('PEG00000000000397829', 'POLI FISIOTERAPI', 'PELEM', 'PARE', '76176', '76176', '', '', '', NULL, NULL),
('PEG00000000000400001', 'Ayu', 'Pare', 'Kediri', '', '', '', '', '', NULL, NULL),
('PEG00000000000400002', 'Aries Diana', 'Pare', 'Kediri', '', '', '', '', '', NULL, NULL),
('PEG00000000000400003', 'Dwiyanti Kristiani', 'Pare', 'Kediri', '', '', '', '', '', NULL, NULL),
('PEG00000000000400004', 'Indriyani', 'Pare', 'Kediri', '', '', '', '', '', NULL, NULL),
('PEG00000000000400005', 'Iwan', 'Pare', 'Kediri', '', '', '', '', '', NULL, NULL),
('PEG00000000000400006', 'Khoirul Anwar', 'Pare', 'Kediri', '', '', '', '', '', NULL, NULL),
('PEG00000000000406088', 'TANJUNG', '-', '-', '-', '-', '-', '-', '-', NULL, NULL),
('PEG00000000000411678', 'OKCENTRAL', 'pare', '-', '-', '-', '-', '-', '-', NULL, NULL),
('PEG00000000000470392', 'tomy', 'pare', 'kediri', '64213', '0', '0', '', 'pegawai kontrak', NULL, NULL),
('PEG00000000000498193', 'POLI THT', 'PELEM', 'KEDIRI', '', '', '', '', '', NULL, NULL),
('PEG00000000000501766', 'POLI OBGYN', 'PARE', '', '', '', '', '', '', NULL, NULL),
('PEG00000000000503049', 'MELATI', 'pare', '-', '-', '-', '-', '-', '-', NULL, NULL),
('PEG00000000000504928', 'POLI GIGI', 'PARE', '', '', '', '', '', '', NULL, NULL),
('PEG00000000000504953', 'IRNA CENDANA Lt.2', 'PARE', '', '', '', '', '', '', NULL, NULL),
('PEG00000000000512943', 'POLI ENDODONSI', 'PARE', '', '', '', '', '', '', NULL, NULL),
('PEG00000000000530517', 'Operator CSSD', '', '', '', '', '', '', '', NULL, NULL),
('PEG00000000000561326', 'seruni', '-', '-', '-', '-', '-', '-', '-', NULL, NULL),
('PEG00000000000581242', 'FLAMBOYAN', 'pare', '-', '-', '-', '-', '-', '-', NULL, NULL),
('PEG00000000000583742', 'TERATAI', 'pare', '-', '-', '-', '-', '-', '-', NULL, NULL),
('PEG00000000000762500', 'afit', '', '', '', '', '', '', '', NULL, NULL),
('PEG00000000000773867', 'POLI PARU', 'PARE', '', '', '', '', '', '', NULL, NULL),
('PEG00000000000778574', 'POLI ORTODENTIK', 'PARE', '', '', '', '', '', '', NULL, NULL),
('PEG00000000000837295', 'AULIA', '-', '-', '-', '-', '-', '-', '-', NULL, NULL),
('PEG00000000000853592', 'LOKET IGD', '', '', '', '', '', '', '', NULL, NULL),
('PEG00000000000929579', 'Hermawan', '', '', '', '', '', '', '', NULL, NULL),
('PEG00000000000980941', 'POLI PEMERIKSAAN KESEHATAN', 'PARE', '', '', '', '', '', '', NULL, NULL),
('PEG00000000000982908', 'RECOVERYROOM', 'pare', '-', '-', '-', '-', '-', '-', NULL, NULL),
('PEG00000000000982909', 'DANANG FEBRI T.W', 'Bulurejo - Kawedusan', 'Kediri', '64155', '0354', '085731610202', 'rip.febry@gmail.com', 'Married', 'd', 'x'),
('PEG00000000000982910', 'Riantono', 'pelem - pare', 'kediri', '64155', '0354', NULL, NULL, 'Married', 'lab', 'Riantono'),
('PEG00000000000982911', 'Wiji Astutik', 'bogo - pelemahan', 'kediri', '64155', '0354', NULL, NULL, 'Married', 'lab', 'wiji'),
('PEG00000000000982920', 'Widhi  Anggung W', 'bogo - pelemahan', 'kediri', '64155', '0354', NULL, NULL, 'Married', 'lab', 'widhi'),
('PEG00000000000992351', 'Bu Is Kasir', '', '', '', '', '', '', '', NULL, NULL),
('PEG00000000000992352', 'Gatra Yudha', 'NGADISIMO - KOTA KEDIRI', 'KEDIRI', '6452', NULL, '081359039756', 'masgatra1@gmail.com', 'maried', 'FNAB', 'GATRA'),
('PEG00000000000992353', 'Ida Astuti', 'PARE - KEDIRI', 'KEDIRI', '64521', NULL, NULL, NULL, 'MARRIED', 'RAD', 'RAD'),
('PEG00000000000992354', 'Valentinus L E', 'Singgagah Pare - Kediri', 'Kediri', '64024', NULL, NULL, NULL, 'Married', 'RAD', 'V'),
('PEG00000000000992355', 'Iim Ikfihayati', 'Pare-Kediri', 'Kediri', '6438', NULL, '08574', NULL, 'Married', 'diklat', 'iim'),
('PEG00000000000992356', 'Ayu', 'Bendo-Pare', 'pare', '64024', '08564', NULL, NULL, 'Married', 'diklat', 'ayu'),
('root', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `a_golpasien`
--
ALTER TABLE `a_golpasien`
  ADD PRIMARY KEY (`KodeGol`) USING BTREE;

--
-- Indeks untuk tabel `a_unit`
--
ALTER TABLE `a_unit`
  ADD PRIMARY KEY (`KodeUnit`) USING BTREE,
  ADD KEY `NamaUnit` (`NamaUnit`) USING BTREE,
  ADD KEY `KodePoliRujukan` (`KodePoliRujukan`) USING BTREE;

--
-- Indeks untuk tabel `dm_agama`
--
ALTER TABLE `dm_agama`
  ADD PRIMARY KEY (`id_agama`) USING BTREE,
  ADD UNIQUE KEY `nama_UNIQUE` (`nama_agama`) USING BTREE;

--
-- Indeks untuk tabel `dm_dokter`
--
ALTER TABLE `dm_dokter`
  ADD PRIMARY KEY (`id_dokter`) USING BTREE,
  ADD KEY `pegawai_id` (`pegawai_id`) USING BTREE,
  ADD KEY `NamaUnit` (`NamaUnit`) USING BTREE;

--
-- Indeks untuk tabel `dm_kelas`
--
ALTER TABLE `dm_kelas`
  ADD PRIMARY KEY (`id_kelas`) USING BTREE;

--
-- Indeks untuk tabel `jenis_visite`
--
ALTER TABLE `jenis_visite`
  ADD PRIMARY KEY (`id_jenis_visite`) USING BTREE,
  ADD KEY `kelas_tingkat` (`kelas_tingkat`) USING BTREE;

--
-- Indeks untuk tabel `tpegawai`
--
ALTER TABLE `tpegawai`
  ADD PRIMARY KEY (`KDPEGAWAI`) USING BTREE,
  ADD KEY `KDPEGAWAI` (`KDPEGAWAI`) USING BTREE;

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `a_golpasien`
--
ALTER TABLE `a_golpasien`
  MODIFY `KodeGol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26127;

--
-- AUTO_INCREMENT untuk tabel `a_unit`
--
ALTER TABLE `a_unit`
  MODIFY `KodeUnit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=748;

--
-- AUTO_INCREMENT untuk tabel `dm_agama`
--
ALTER TABLE `dm_agama`
  MODIFY `id_agama` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `dm_dokter`
--
ALTER TABLE `dm_dokter`
  MODIFY `id_dokter` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=166;

--
-- AUTO_INCREMENT untuk tabel `dm_kelas`
--
ALTER TABLE `dm_kelas`
  MODIFY `id_kelas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `jenis_visite`
--
ALTER TABLE `jenis_visite`
  MODIFY `id_jenis_visite` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `a_unit`
--
ALTER TABLE `a_unit`
  ADD CONSTRAINT `a_unit_ibfk_1` FOREIGN KEY (`KodePoliRujukan`) REFERENCES `poli_bpjs` (`KDPOLI`);

--
-- Ketidakleluasaan untuk tabel `dm_dokter`
--
ALTER TABLE `dm_dokter`
  ADD CONSTRAINT `dm_dokter_ibfk_1` FOREIGN KEY (`pegawai_id`) REFERENCES `tpegawai` (`KDPEGAWAI`),
  ADD CONSTRAINT `dm_dokter_ibfk_2` FOREIGN KEY (`NamaUnit`) REFERENCES `a_unit` (`NamaUnit`);

--
-- Ketidakleluasaan untuk tabel `jenis_visite`
--
ALTER TABLE `jenis_visite`
  ADD CONSTRAINT `jenis_visite_ibfk_1` FOREIGN KEY (`kelas_tingkat`) REFERENCES `dm_kelas` (`id_kelas`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

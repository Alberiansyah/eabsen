-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 02, 2023 at 07:11 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eabsen`
--

-- --------------------------------------------------------

--
-- Table structure for table `absen`
--

CREATE TABLE `absen` (
  `id_absen` bigint(20) NOT NULL,
  `id_karyawan` bigint(20) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `alasan` text NOT NULL,
  `absen_pagi` datetime DEFAULT NULL,
  `absen_sore` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `update_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `absen`
--

INSERT INTO `absen` (`id_absen`, `id_karyawan`, `foto`, `keterangan`, `alamat`, `alasan`, `absen_pagi`, `absen_sore`, `created_at`, `update_at`) VALUES
(2, 14, '5b24034d9e5f687d4a277376cebd3b548b11b9b2e753759be2c3f925a81e4b07_2023_10_01_14.png', 'Hadir', 'Gang Gagok Handoko, Situ Saeur, Bojongloa Kidul, Bandung, West Java, Java, 40232, Indonesia', '', NULL, '2023-10-01 20:10:27', '2023-10-01 13:10:27', '2023-10-01 13:10:27'),
(3, 3, '9cd5ff1c3d3b5f0934d086320f828bd35436265f5bcfdef8c6d73877ed5ff177_2023_10_01_3.jpg', 'Hadir', 'Gang Gagok Handoko, Situ Saeur, Bojongloa Kidul, Bandung, West Java, Java, 40232, Indonesia', '', NULL, '2023-10-01 20:15:30', '2023-10-01 13:15:30', '2023-10-01 13:15:30'),
(5, 16, '83867aef8bef77fa1c3becfab871240edb22788f98b1db42aae632168d9612a2_2023_10_02_16.png', 'Hadir', 'Gang Gagok Handoko, Situ Saeur, Bojongloa Kidul, Bandung, West Java, Java, 40232, Indonesia', '', '2023-10-02 11:08:09', NULL, '2023-10-02 04:08:09', '2023-10-02 04:08:09');

-- --------------------------------------------------------

--
-- Table structure for table `karyawan`
--

CREATE TABLE `karyawan` (
  `id_karyawan` bigint(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `jabatan` varchar(100) NOT NULL,
  `kategori` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `karyawan`
--

INSERT INTO `karyawan` (`id_karyawan`, `nama`, `jabatan`, `kategori`) VALUES
(1, 'Agus Bandung', 'Sopir', 'Koridor 1'),
(2, 'Agus Cahyadi', 'Sopir', 'Koridor 1'),
(3, 'Ari Suheri', 'Sopir', 'Koridor 1'),
(4, 'Andriansyah', 'Sopir', 'Koridor 1'),
(5, 'Dadan', 'Sopir', 'Koridor 1'),
(6, 'Dadih BJ', 'Sopir', 'Koridor 1'),
(7, 'Devi Rahmat', 'Sopir', 'Koridor 1'),
(8, 'Hendra', 'Sopir', 'Koridor 1'),
(9, 'Andri Firmansyah', 'Sopir', 'Koridor 1'),
(10, 'M Ramdani', 'Sopir', 'Koridor 1'),
(11, 'Iwan Gunawan', 'Sopir', 'Koridor 1'),
(12, 'M Nur K', 'Sopir', 'Koridor 1'),
(13, 'Jamaludin', 'Sopir', 'Koridor 1'),
(14, 'Joni Ridwan', 'Sopir', 'Koridor 1'),
(15, 'Sugiono', 'Sopir', 'Koridor 1'),
(16, 'Suherman', 'Sopir', 'Koridor 1'),
(17, 'Joni Iskandar', 'Sopir', 'Koridor 1'),
(18, 'Ujang Juhana', 'Sopir', 'Koridor 1'),
(19, 'Agung R', 'Sopir', 'Koridor 1'),
(20, 'Wawan M', 'Sopir', 'Koridor 1'),
(22, 'Rival Septia Irawan', 'Kondektur', 'Koridor 1'),
(23, 'Ujang Kuswara', 'Kondektur', 'Koridor 1'),
(24, 'Rizal Wahyu Permana', 'Kondektur', 'Koridor 1'),
(25, 'Rizky MS', 'Kondektur', 'Koridor 1'),
(26, 'Andri Kurniawan', 'Kondektur', 'Koridor 1'),
(27, 'Asdi Romansyah', 'Kondektur', 'Koridor 1'),
(28, 'Asep Andri', 'Kondektur', 'Koridor 1'),
(29, 'Ahmad TA', 'Kondektur', 'Koridor 1'),
(30, 'Asep Rachmansyah', 'Kondektur', 'Koridor 1'),
(31, 'Aziz Rohmat H', 'Kondektur', 'Koridor 1'),
(32, 'Dadang Padli', 'Kondektur', 'Koridor 1'),
(33, 'Fikri Maulana', 'Kondektur', 'Koridor 1'),
(34, 'Hendri Muhamad Fikri', 'Kondektur', 'Koridor 1'),
(35, 'M Iman S', 'Kondektur', 'Koridor 1'),
(36, 'Fuji Aprizal', 'Kondektur', 'Koridor 1'),
(37, 'Septian Bayu', 'Kondektur', 'Koridor 1'),
(38, 'Suwarjo', 'Kondektur', 'Koridor 1'),
(39, 'Tonton Ari', 'Kondektur', 'Koridor 1'),
(40, 'Yopi Marta', 'Kondektur', 'Koridor 1'),
(41, 'Agung R', 'Sopir', 'Koridor 2'),
(42, 'Apen Efendi', 'Sopir', 'Koridor 2'),
(43, 'Asep Kurnia', 'Sopir', 'Koridor 2'),
(44, 'Aditya', 'Sopir', 'Koridor 2'),
(47, 'Cecep Irawan', 'Sopir', 'Koridor 2'),
(48, 'Herman Persib', 'Sopir', 'Koridor 2'),
(49, 'Agus Cahyadi', 'Sopir\n', 'Koridor 2'),
(50, 'Irvan Nurfaizin', 'Sopir', 'Koridor 2'),
(51, 'Iwa Rahmat', 'Sopir', 'Koridor 2'),
(52, 'Jajang Nurjaman', 'Sopir', 'Koridor 2'),
(53, 'Jajang Gunawan', 'Sopir', 'Koridor 2'),
(54, 'Jahidi K', 'Sopir', 'Koridor 2'),
(55, 'Ari Nurjaman', 'Sopir', 'Koridor 2'),
(56, 'Asep Ym', 'Sopir', 'Koridor 2'),
(57, 'Muhamad Arizal', 'Sopir', 'Koridor 2'),
(58, 'M Nur Kurniawan', 'Sopir', 'Koridor 2'),
(59, 'M Abdul Robi', 'Sopir', 'Koridor 2'),
(60, 'Gugun Gunawan', 'Sopir', 'Koridor 2'),
(61, 'M Ramdani', 'Sopir', 'Koridor 2'),
(62, 'Rizky Ginanjar', 'Sopir', 'Koridor 2'),
(63, 'Alfarizki', 'Sopir', 'Koridor 2'),
(64, 'Rizky Kuniawan', 'Sopir', 'Koridor 2'),
(65, 'Sanur Suryanto', 'Sopir ', 'Koridor 2'),
(66, 'Herman', 'Sopir', 'Koridor 2'),
(67, 'M Kamayudin ', 'Sopir', 'Koridor 2'),
(68, 'Maman Suherman', 'Sopir', 'Koridor 2'),
(69, 'Wawan Setiawan', 'Sopir', 'Koridor 2'),
(70, 'Ujang Kuswara', 'Kondektur', 'Koridor 2'),
(71, 'Saeful Anwar', 'Kondektur', 'Koridor 2'),
(72, 'Ilham Bagus', 'Kondektur', 'Koridor 2'),
(73, 'Afsal M yusril\r\n', 'Kondektur', 'Koridor 2'),
(74, 'Aglan Fahila', 'Kondektur', 'Koridor 2'),
(75, 'Ahmad Sofyan', 'Kondektur', 'Koridor 2'),
(76, 'Ahmad Tubagus Azis', 'Kondektur', 'Koridor 2'),
(77, 'Andry Kurniawan', 'Kondektur', 'Koridor 2'),
(78, 'Rival Septian Irawan', 'Kondektur', 'Koridor 2'),
(79, 'Tantan', 'Kondektur', 'Koridor 2'),
(80, 'Dede Yosep', 'Kondektur', 'Koridor 2'),
(81, 'Entis P', 'Kondektur', 'Koridor 2'),
(82, 'Ikhwan Sanjaya', 'Kondektur', 'Koridor 2'),
(83, 'Fuji Afrizal', 'Kondektur', 'Koridor 2'),
(84, 'Kusnaedi', 'Kondektur', 'Koridor 2'),
(85, 'Rizal Wahyu P ', 'Kondektur', 'Koridor 2'),
(86, 'Rizky Maulana S', 'Kondektur', 'Koridor 2'),
(87, 'Sandi Sanjaya', 'Kondektur', 'Koridor 2'),
(88, 'Fauzi', 'Kondektur', 'Koridor 2'),
(89, 'Dian Setiadi', 'Kondektur', 'Koridor 2'),
(90, 'Taufik Nurdiansyah', 'Kondektur', 'Koridor 2'),
(91, 'Taufik Samawi', 'Kondektur', 'Koridor 2'),
(92, 'Ujang Kuswara', 'Kondektur', 'Koridor 2'),
(93, 'Fikri Maulana', 'Kondektur', 'Koridor 2'),
(94, 'Wiko Prianto', 'Kondektur', 'Koridor 2'),
(95, 'Adity', 'Sopir', 'Koridor 3'),
(96, 'Ari Nurjaman', 'Sopir', 'Koridor 3'),
(97, 'Asep Abdullah', 'Sopir', 'Koridor 3'),
(98, 'Elang Syudaha', 'Sopir', 'Koridor 3'),
(99, 'Enjang Kusnadi ', 'Sopir', 'Koridor 3'),
(100, 'Gugun Suwandi', 'Sopir', 'Koridor 3'),
(101, 'Jahidi Kusnadi', 'Sopir', 'Koridor 3'),
(102, 'Jajang Gunawan', 'Sopir', 'Koridor 3'),
(103, 'M Kamayudin', 'Sopir', 'Koridor 3'),
(104, 'M. Arizal', 'Sopir', 'Koridor 3'),
(105, 'Yayat ', 'Sopir', 'Koridor 3'),
(106, 'Yogi Akbar Jatnika', 'Sopir', 'Koridor 3'),
(107, 'Asep Gunawan', 'Kondektur', 'Koridor 3'),
(108, 'Dian Setiadi', 'Kondektur', 'Koridor 3'),
(109, 'Gemilang', 'Kondektur', 'Koridor 3'),
(110, 'Indra', 'Kondektur', 'Koridor 3'),
(111, 'Ricky Hendi Ramdhani\r\n', 'Kondektur', 'Koridor 3'),
(112, 'Rival Septian Irawan', 'Kondektur', 'Koridor 3'),
(113, 'Rully Kurniawan', 'Kondektur', 'Koridor 3'),
(114, 'Sigit Anggoro', 'Kondektur', 'Koridor 3'),
(115, 'Tantan', 'Kondektur', 'Koridor 3'),
(116, 'Tedi Sutadi', 'Kondektur', 'Koridor 3'),
(117, 'Wawan Kuswandi', 'Kondektur', 'Koridor 3'),
(118, 'Aef Witarli', 'Sopir', 'Koridor 4'),
(119, 'Ari Nurjaman', 'Sopir', 'Koridor 4'),
(120, 'Dadang Mulyana', 'Sopir', 'Koridor 4'),
(121, 'Dani Supriatna\r\n', 'Sopir', 'Koridor 4'),
(122, 'Maman Suherman\r\n', 'Sopir', 'Koridor 4'),
(123, 'cepi Permana\r\n', 'Sopir', 'Koridor 4'),
(124, 'Sugiyanto\r\n', 'Sopir', 'Koridor 4'),
(125, 'Ahmad Sopyan Fauzi\r\n', 'Kondektur', 'Koridor 4'),
(126, 'Ali Mugni\r\n', 'Kondektur', 'Koridor 4'),
(127, 'Apud Supriatna\r\n', 'Kondektur', 'Koridor 4'),
(128, 'Aris Ramdhani\r\n', 'Kondektur', 'Koridor 4'),
(129, 'Atang Setiawan\r\n', 'Kondektur', 'Koridor 4'),
(130, 'Cepi Permana\r\n', 'Kondektur', 'Koridor 4'),
(131, 'Edi Padli\r\n', 'Kondektur', 'Koridor 4'),
(132, 'Samsul Gani\r\n', 'Kondektur', 'Koridor 4'),
(133, 'Rival Septian Irawan\r\n', 'Kondektur', 'Koridor 4'),
(134, 'Tantan\r\n', 'Kondektur', 'Koridor 4'),
(135, 'Zamzam Muhamad Umar\r\n', 'Kondektur', 'Koridor 4'),
(136, 'Andri Firmansyah\r\n', 'Sopir', 'Koridor 5'),
(137, 'Asep Abdullah\r\n', 'Sopir', 'Koridor 5'),
(138, 'Asep Yusup M\r\n', 'Sopir', 'Koridor 5'),
(139, 'Dede Hermawan\r\n', 'Sopir', 'Koridor 5'),
(140, 'Iwan Kurniawan\r\n', 'Sopir', 'Koridor 5'),
(141, 'Aris Ramdani\r\n', 'Kondektur', 'Koridor 5'),
(142, 'Apud Supriatna\r\n', 'Kondektur', 'Koridor 5'),
(143, 'Dian Setiadi\r\n', 'Kondektur', 'Koridor 5'),
(144, 'Ramdani\r\n', 'Kondektur', 'Koridor 5'),
(145, 'Ricky Rizkola\r\n', 'Kondektur', 'Koridor 5'),
(146, 'Zamzam Muhamad Umar\r\n', 'Kondektur', 'Koridor 5'),
(147, 'Asep Komara\r\n', 'Sopir', 'Koridor 6'),
(148, 'Asep Roni\r\n', 'Sopir', 'Koridor 6'),
(149, 'Agus', 'Sopir', 'Koridor 6'),
(150, 'Budi', 'Sopir', 'Koridor 6'),
(151, 'Muhammad Zevy\r\n', 'Sopir', 'Koridor 6'),
(152, 'Robby\r\n', 'Sopir', 'Koridor 6'),
(153, 'Uus Kusnadi\r\n', 'Sopir', 'Koridor 6'),
(154, 'Deni S\r\n', 'Kondektur', 'Koridor 6'),
(155, 'Mahrom Azri\r\n', 'Kondektur', 'Koridor 6'),
(156, 'Sopian\r\n', 'Kondektur', 'Koridor 6');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `idUser` int(11) NOT NULL,
  `username` varchar(256) NOT NULL,
  `password` text NOT NULL,
  `nama` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`idUser`, `username`, `password`, `nama`) VALUES
(1, 'admin', '$2y$10$yDTrXfFVdhZos3ETxc1L6.hvZUDnwknujCvwGWAwHrfxAxJxX8VRu', 'Yanto Hermawan');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absen`
--
ALTER TABLE `absen`
  ADD PRIMARY KEY (`id_absen`);

--
-- Indexes for table `karyawan`
--
ALTER TABLE `karyawan`
  ADD PRIMARY KEY (`id_karyawan`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`idUser`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absen`
--
ALTER TABLE `absen`
  MODIFY `id_absen` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

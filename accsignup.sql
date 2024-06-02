-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 20, 2024 at 06:50 AM
-- Server version: 8.2.0
-- PHP Version: 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `signup`
--

-- --------------------------------------------------------

--
-- Table structure for table `accsignup`
--

DROP TABLE IF EXISTS `accsignup`;
CREATE TABLE IF NOT EXISTS `accsignup` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `accsignup`
--

INSERT INTO `accsignup` (`id`, `name`, `email`, `password`) VALUES
(20, 'Stephanie Magdame', 'panengji@p.com', '$2y$10$loB3krYCLl0uW3VnnOJGFeqR6LNq1v/F4ypXCf2EXhmJxvFV13eh2'),
(18, 'admin', 'admin@admin.hh', '$2y$10$BDF1n9hGrKEofmg.vlMYJ.Z1yFVNKDsnqBbvF95e.w7PAmPFatd1a'),
(19, 'Grace Rosario', 'grace@g.com', '$2y$10$g5z18L6f.8JWwlDqoibMTOQOrJB1Ga4WOSU4PBFD1.H.3sP30yErO'),
(16, 'superadmin', 'superadmin@admin.hh', '$2y$10$vbzZ1aixcZVoDwnqq1Lel.ZvQY1wavg3MF3Ag/wxTZ36R8OCxErny'),
(14, 'jeshaiah', 'iyah@y.com', '$2y$10$C95HnbsV9IjpbrJVabHewOPt/8jP4C8AnHItcbOCwE2oAuW3ARkiS'),
(15, 'gen', 'gen@g.com', '$2y$10$gReCXUJ0rgtEdybPausr9e.Nu65HUQuaC3gDINywl9V2VdMNU6TnW');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

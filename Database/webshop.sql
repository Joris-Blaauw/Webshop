-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 30 nov 2023 om 19:51
-- Serverversie: 10.4.21-MariaDB
-- PHP-versie: 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webshop`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `page`
--

CREATE TABLE `page` (
  `Role` enum('Front','Tips','Products') NOT NULL,
  `Logo` varchar(255) NOT NULL,
  `Title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `product`
--

CREATE TABLE `product` (
  `Id` int(11) NOT NULL,
  `Title` varchar(255) NOT NULL,
  `Img` varchar(255) DEFAULT NULL,
  `Description` varchar(255) NOT NULL,
  `Price` float NOT NULL DEFAULT 0,
  `Unit` enum('kg','lt','pc') NOT NULL,
  `Delivery_Time` int(11) NOT NULL DEFAULT 0,
  `Stock` int(11) NOT NULL DEFAULT 0,
  `Discount` float DEFAULT NULL,
  `Category` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `section`
--

CREATE TABLE `section` (
  `Id` int(11) NOT NULL,
  `Title` varchar(255) NOT NULL,
  `Content` varchar(1000) NOT NULL,
  `Ordrr` int(11) NOT NULL,
  `Img` varchar(255) DEFAULT NULL,
  `Page` enum('Front','Tips','Products') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `page`
--
ALTER TABLE `page`
  ADD PRIMARY KEY (`Role`);

--
-- Indexen voor tabel `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`Id`);

--
-- Indexen voor tabel `section`
--
ALTER TABLE `section`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `Page` (`Page`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `product`
--
ALTER TABLE `product`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `section`
--
ALTER TABLE `section`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `section`
--
ALTER TABLE `section`
  ADD CONSTRAINT `Page` FOREIGN KEY (`Page`) REFERENCES `page` (`Role`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: mysqldb
-- Gegenereerd op: 06 feb 2021 om 14:28
-- Serverversie: 5.7.31
-- PHP-versie: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `facturatie`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `klanten`
--

CREATE TABLE `klanten` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `mail` varchar(50) NOT NULL,
  `btwnr` varchar(25) NOT NULL,
  `adres` varchar(50) NOT NULL,
  `gemeente` varchar(50) NOT NULL,
  `postcode` int(4) NOT NULL,
  `added_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(256) NOT NULL,
  `type` enum('user','admin') NOT NULL DEFAULT 'user',
  `added_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `verkoop`
--

CREATE TABLE `verkoop` (
  `id` int(11) NOT NULL,
  `naam` varchar(20) NOT NULL,
  `categorie` enum('frisdrank','versnaperingen','bier','andere') NOT NULL,
  `prijs` float NOT NULL,
  `added_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `klanten`
--
ALTER TABLE `klanten`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `verkoop`
--
ALTER TABLE `verkoop`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `klanten`
--
ALTER TABLE `klanten`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `verkoop`
--
ALTER TABLE `verkoop`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 29 Eki 2024, 20:31:51
-- Sunucu sürümü: 10.4.32-MariaDB
-- PHP Sürümü: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `onhdi`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `icon` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `category`
--

INSERT INTO `category` (`id`, `name`, `icon`) VALUES
(1, 'Database', '/database-default.png'),
(2, 'FileServer', '/folder.png'),
(3, 'Application', '/exe.png'),
(7, 'Mobile App', '/mobile.png'),
(8, 'WebApp', '/webapp.png'),
(9, 'Server', '/server.png');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `connection`
--

CREATE TABLE `connection` (
  `id` int(11) NOT NULL,
  `nodeFrom` int(11) NOT NULL,
  `nodeTo` int(11) NOT NULL,
  `connectionDesc` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `connection`
--

INSERT INTO `connection` (`id`, `nodeFrom`, `nodeTo`, `connectionDesc`) VALUES
(1, 3, 1, 'SQL'),
(2, 3, 2, 'SMB'),
(5, 3, 1, 'SQL');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `nodes`
--

CREATE TABLE `nodes` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `category_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `description` varchar(250) DEFAULT ' ',
  `active` varchar(3) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `nodes`
--

INSERT INTO `nodes` (`id`, `name`, `category_id`, `created_at`, `updated_at`, `description`, `active`) VALUES
(1, 'Database', 1, '2024-10-29 00:00:00', '2024-10-29 00:00:00', 'MSSQL database,\n587 port', 'on'),
(2, 'FileServer', 2, '2024-10-29 00:00:00', '2024-10-29 00:00:00', 'fileserver, runs with SMB', 'on'),
(3, 'ExeApplication', 3, '2024-10-29 00:00:00', '2024-10-29 00:00:00', 'exe application example', 'on'),
(4, 'Web App', 7, '2024-10-29 00:00:00', '2024-10-29 00:00:00', 'Web App', 'on');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `connection`
--
ALTER TABLE `connection`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `nodes`
--
ALTER TABLE `nodes`
  ADD PRIMARY KEY (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Tablo için AUTO_INCREMENT değeri `connection`
--
ALTER TABLE `connection`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Tablo için AUTO_INCREMENT değeri `nodes`
--
ALTER TABLE `nodes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

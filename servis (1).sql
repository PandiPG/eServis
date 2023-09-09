-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hostiteľ: localhost
-- Čas generovania: So 09.Sep 2023, 19:44
-- Verzia serveru: 8.0.32
-- Verzia PHP: 8.0.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáza: `servis`
--

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `ccm`
--

CREATE TABLE `ccm` (
  `id` int UNSIGNED NOT NULL,
  `oznaceni` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `kategoria`
--

CREATE TABLE `kategoria` (
  `id` int UNSIGNED NOT NULL,
  `nazev` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `kw`
--

CREATE TABLE `kw` (
  `id` int NOT NULL,
  `kw` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `majitel`
--

CREATE TABLE `majitel` (
  `id` int UNSIGNED NOT NULL,
  `jmeno` text NOT NULL,
  `prijmeni` text NOT NULL,
  `muj_garaz_id` int UNSIGNED NOT NULL,
  `vozidlo_vin` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `model`
--

CREATE TABLE `model` (
  `id` int UNSIGNED NOT NULL,
  `vyrobce_id` int UNSIGNED NOT NULL,
  `nazev` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `muj_garaz`
--

CREATE TABLE `muj_garaz` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int DEFAULT NULL,
  `jmeno` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `palivo`
--

CREATE TABLE `palivo` (
  `id` int UNSIGNED NOT NULL,
  `nazev` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `prevodovka`
--

CREATE TABLE `prevodovka` (
  `id` int UNSIGNED NOT NULL,
  `nazev` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `rok`
--

CREATE TABLE `rok` (
  `id` int NOT NULL,
  `rok` year DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `servisni_ukon`
--

CREATE TABLE `servisni_ukon` (
  `id` int UNSIGNED NOT NULL,
  `vozidlo_vin` text,
  `aktualne_najeto` int NOT NULL,
  `pristi_servis` int DEFAULT NULL,
  `datum` date NOT NULL,
  `pristi_datum` date DEFAULT NULL,
  `cena` float NOT NULL,
  `zaznam` text NOT NULL,
  `typ` int NOT NULL,
  `vozidlo_id` int DEFAULT NULL,
  `servisni_ukon_typ_id` int UNSIGNED DEFAULT NULL,
  `km_next` int DEFAULT NULL,
  `nazev_servisu` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `servisni_ukon_typ`
--

CREATE TABLE `servisni_ukon_typ` (
  `id` int NOT NULL,
  `nazev` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `jmeno` varchar(255) DEFAULT NULL,
  `heslo` varchar(255) DEFAULT NULL,
  `muj_garaz_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `vozidlo`
--

CREATE TABLE `vozidlo` (
  `vin` text NOT NULL,
  `id` int UNSIGNED NOT NULL,
  `ccm_id` int UNSIGNED NOT NULL,
  `kategorie_id` int UNSIGNED NOT NULL,
  `model_id` int UNSIGNED NOT NULL,
  `muj_garaz_id` int UNSIGNED NOT NULL,
  `palivo_id` int UNSIGNED NOT NULL DEFAULT '0',
  `servisni_ukon_id` int UNSIGNED DEFAULT '0',
  `vyrobce_id` int UNSIGNED NOT NULL,
  `prevodovka_id` int UNSIGNED NOT NULL DEFAULT '0',
  `jmeno` varchar(255) DEFAULT NULL,
  `rok_vyroby` int DEFAULT NULL,
  `kw_id` int DEFAULT NULL,
  `user_id` int NOT NULL,
  `stav_km` int UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `vyrobce`
--

CREATE TABLE `vyrobce` (
  `id` int UNSIGNED NOT NULL,
  `nazev` text NOT NULL,
  `vozidlo_vin` int DEFAULT NULL,
  `kategorie_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Kľúče pre exportované tabuľky
--

--
-- Indexy pre tabuľku `ccm`
--
ALTER TABLE `ccm`
  ADD PRIMARY KEY (`id`);

--
-- Indexy pre tabuľku `kategoria`
--
ALTER TABLE `kategoria`
  ADD PRIMARY KEY (`id`);

--
-- Indexy pre tabuľku `kw`
--
ALTER TABLE `kw`
  ADD PRIMARY KEY (`id`);

--
-- Indexy pre tabuľku `majitel`
--
ALTER TABLE `majitel`
  ADD PRIMARY KEY (`id`);

--
-- Indexy pre tabuľku `model`
--
ALTER TABLE `model`
  ADD PRIMARY KEY (`id`);

--
-- Indexy pre tabuľku `muj_garaz`
--
ALTER TABLE `muj_garaz`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexy pre tabuľku `palivo`
--
ALTER TABLE `palivo`
  ADD PRIMARY KEY (`id`);

--
-- Indexy pre tabuľku `prevodovka`
--
ALTER TABLE `prevodovka`
  ADD PRIMARY KEY (`id`);

--
-- Indexy pre tabuľku `rok`
--
ALTER TABLE `rok`
  ADD PRIMARY KEY (`id`);

--
-- Indexy pre tabuľku `servisni_ukon`
--
ALTER TABLE `servisni_ukon`
  ADD PRIMARY KEY (`id`);

--
-- Indexy pre tabuľku `servisni_ukon_typ`
--
ALTER TABLE `servisni_ukon_typ`
  ADD PRIMARY KEY (`id`);

--
-- Indexy pre tabuľku `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexy pre tabuľku `vozidlo`
--
ALTER TABLE `vozidlo`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `vyrobce_id` (`vyrobce_id`),
  ADD KEY `test` (`ccm_id`,`kategorie_id`,`model_id`,`muj_garaz_id`,`palivo_id`),
  ADD KEY `kategorie_id` (`kategorie_id`),
  ADD KEY `model_id` (`model_id`),
  ADD KEY `muj_garaz_id` (`muj_garaz_id`),
  ADD KEY `palivo_id` (`palivo_id`),
  ADD KEY `servisni_ukon_id` (`servisni_ukon_id`),
  ADD KEY `prevodovka` (`prevodovka_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexy pre tabuľku `vyrobce`
--
ALTER TABLE `vyrobce`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pre exportované tabuľky
--

--
-- AUTO_INCREMENT pre tabuľku `ccm`
--
ALTER TABLE `ccm`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pre tabuľku `kategoria`
--
ALTER TABLE `kategoria`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pre tabuľku `kw`
--
ALTER TABLE `kw`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pre tabuľku `majitel`
--
ALTER TABLE `majitel`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pre tabuľku `model`
--
ALTER TABLE `model`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pre tabuľku `muj_garaz`
--
ALTER TABLE `muj_garaz`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pre tabuľku `palivo`
--
ALTER TABLE `palivo`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pre tabuľku `prevodovka`
--
ALTER TABLE `prevodovka`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pre tabuľku `rok`
--
ALTER TABLE `rok`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pre tabuľku `servisni_ukon`
--
ALTER TABLE `servisni_ukon`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pre tabuľku `servisni_ukon_typ`
--
ALTER TABLE `servisni_ukon_typ`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pre tabuľku `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pre tabuľku `vozidlo`
--
ALTER TABLE `vozidlo`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pre tabuľku `vyrobce`
--
ALTER TABLE `vyrobce`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Obmedzenie pre exportované tabuľky
--

--
-- Obmedzenie pre tabuľku `muj_garaz`
--
ALTER TABLE `muj_garaz`
  ADD CONSTRAINT `muj_garaz_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Obmedzenie pre tabuľku `vozidlo`
--
ALTER TABLE `vozidlo`
  ADD CONSTRAINT `vozidlo_ibfk_11` FOREIGN KEY (`prevodovka_id`) REFERENCES `prevodovka` (`id`),
  ADD CONSTRAINT `vozidlo_ibfk_12` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `vozidlo_ibfk_2` FOREIGN KEY (`vyrobce_id`) REFERENCES `vyrobce` (`id`),
  ADD CONSTRAINT `vozidlo_ibfk_3` FOREIGN KEY (`ccm_id`) REFERENCES `ccm` (`id`),
  ADD CONSTRAINT `vozidlo_ibfk_4` FOREIGN KEY (`kategorie_id`) REFERENCES `kategoria` (`id`),
  ADD CONSTRAINT `vozidlo_ibfk_6` FOREIGN KEY (`model_id`) REFERENCES `model` (`id`),
  ADD CONSTRAINT `vozidlo_ibfk_7` FOREIGN KEY (`muj_garaz_id`) REFERENCES `muj_garaz` (`id`),
  ADD CONSTRAINT `vozidlo_ibfk_8` FOREIGN KEY (`palivo_id`) REFERENCES `palivo` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

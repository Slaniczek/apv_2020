-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Počítač: localhost
-- Vytvořeno: Ned 21. čen 2020, 16:38
-- Verze serveru: 10.4.11-MariaDB
-- Verze PHP: 7.3.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `apv`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `contact`
--

CREATE TABLE `contact` (
  `id_contact` int(11) NOT NULL,
  `id_person` int(11) DEFAULT NULL,
  `id_contact_type` int(11) DEFAULT NULL,
  `contact` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Vypisuji data pro tabulku `contact`
--

INSERT INTO `contact` (`id_contact`, `id_person`, `id_contact_type`, `contact`) VALUES
(8, 19, 1, 'david@davidslanina.cz'),
(9, 19, 2, '+420737645729');

-- --------------------------------------------------------

--
-- Struktura tabulky `contact_type`
--

CREATE TABLE `contact_type` (
  `id_contact_type` int(11) NOT NULL,
  `name` varchar(200) DEFAULT NULL,
  `validation_regexp` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Vypisuji data pro tabulku `contact_type`
--

INSERT INTO `contact_type` (`id_contact_type`, `name`, `validation_regexp`) VALUES
(1, 'email', '/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\\.[a-zA-Z]{2,4}$/'),
(2, 'phone', '/^[\\+]?[(]?[0-9]{3}[)]?[-\\s\\.]?[0-9]{3}[-\\s\\.]?[0-9]{3}[-\\s\\.]?[0-9]{3}$/im');

-- --------------------------------------------------------

--
-- Struktura tabulky `location`
--

CREATE TABLE `location` (
  `id_location` int(11) NOT NULL,
  `city` varchar(200) DEFAULT NULL,
  `street_name` varchar(200) DEFAULT NULL,
  `street_number` int(11) DEFAULT NULL,
  `zip` varchar(50) DEFAULT NULL,
  `country` varchar(200) DEFAULT NULL,
  `name` varchar(200) DEFAULT NULL,
  `latitude` decimal(10,0) DEFAULT NULL,
  `longitude` decimal(10,0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Vypisuji data pro tabulku `location`
--

INSERT INTO `location` (`id_location`, `city`, `street_name`, `street_number`, `zip`, `country`, `name`, `latitude`, `longitude`) VALUES
(4, 'Brno - Černá Pole', 'Zemědělská', 1665, '613 00', 'Czech republic', 'PEF Mendelu', '49', '17'),
(5, 'Brno - Střed', 'Šumavská', 35, '602 00', 'Czech republic', 'Šumavská tower', '49', '17'),
(6, 'Brno - Bohunice', 'Netroufalky', 770, '62500', 'Czech republic', 'Campus', '49', '17'),
(7, 'Brno', 'Dornych', 40, '60200', 'Czech republic', 'Vlněna', '49', '17');

-- --------------------------------------------------------

--
-- Struktura tabulky `meeting`
--

CREATE TABLE `meeting` (
  `id_meeting` int(11) NOT NULL,
  `start` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `description` varchar(200) DEFAULT NULL,
  `duration` time DEFAULT NULL,
  `id_location` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Vypisuji data pro tabulku `meeting`
--

INSERT INTO `meeting` (`id_meeting`, `start`, `description`, `duration`, `id_location`) VALUES
(47, '2020-06-21 14:14:17', 'Lorem ipsum', '00:01:00', 5);

-- --------------------------------------------------------

--
-- Struktura tabulky `person`
--

CREATE TABLE `person` (
  `id_person` int(11) NOT NULL,
  `nickname` varchar(200) DEFAULT NULL,
  `first_name` varchar(200) DEFAULT NULL,
  `last_name` varchar(200) DEFAULT NULL,
  `id_location` int(11) DEFAULT NULL,
  `birth_day` date DEFAULT NULL,
  `height` int(11) DEFAULT NULL,
  `gender` enum('male','female') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Vypisuji data pro tabulku `person`
--

INSERT INTO `person` (`id_person`, `nickname`, `first_name`, `last_name`, `id_location`, `birth_day`, `height`, `gender`) VALUES
(19, 'Slanik', 'Slanina', 'David', 5, '1996-04-23', 185, 'male'),
(20, 'Honza', 'Novák', 'Jan', 7, '2020-02-07', 167, 'male');

-- --------------------------------------------------------

--
-- Struktura tabulky `person_meeting`
--

CREATE TABLE `person_meeting` (
  `id_person` int(11) DEFAULT NULL,
  `id_meeting` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Vypisuji data pro tabulku `person_meeting`
--

INSERT INTO `person_meeting` (`id_person`, `id_meeting`) VALUES
(19, 47),
(20, 47);

-- --------------------------------------------------------

--
-- Struktura tabulky `relation`
--

CREATE TABLE `relation` (
  `id_relation` int(11) NOT NULL,
  `id_person1` int(11) DEFAULT NULL,
  `id_person2` int(11) DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL,
  `id_relation_type` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Vypisuji data pro tabulku `relation`
--

INSERT INTO `relation` (`id_relation`, `id_person1`, `id_person2`, `description`, `id_relation_type`) VALUES
(5, 19, 20, '', 3);

-- --------------------------------------------------------

--
-- Struktura tabulky `relation_type`
--

CREATE TABLE `relation_type` (
  `id_relation_type` int(11) NOT NULL,
  `name` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Vypisuji data pro tabulku `relation_type`
--

INSERT INTO `relation_type` (`id_relation_type`, `name`) VALUES
(3, 'Kolegové');

--
-- Klíče pro exportované tabulky
--

--
-- Klíče pro tabulku `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id_contact`),
  ADD KEY `id_person` (`id_person`),
  ADD KEY `id_contact_type` (`id_contact_type`);

--
-- Klíče pro tabulku `contact_type`
--
ALTER TABLE `contact_type`
  ADD PRIMARY KEY (`id_contact_type`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Klíče pro tabulku `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`id_location`);

--
-- Klíče pro tabulku `meeting`
--
ALTER TABLE `meeting`
  ADD PRIMARY KEY (`id_meeting`),
  ADD UNIQUE KEY `start` (`start`),
  ADD KEY `id_location` (`id_location`);

--
-- Klíče pro tabulku `person`
--
ALTER TABLE `person`
  ADD PRIMARY KEY (`id_person`),
  ADD UNIQUE KEY `nickname` (`nickname`),
  ADD UNIQUE KEY `first_name` (`first_name`),
  ADD UNIQUE KEY `last_name` (`last_name`),
  ADD KEY `id_location` (`id_location`);

--
-- Klíče pro tabulku `person_meeting`
--
ALTER TABLE `person_meeting`
  ADD KEY `id_person` (`id_person`),
  ADD KEY `id_meeting` (`id_meeting`);

--
-- Klíče pro tabulku `relation`
--
ALTER TABLE `relation`
  ADD PRIMARY KEY (`id_relation`),
  ADD KEY `id_person1` (`id_person1`),
  ADD KEY `id_person2` (`id_person2`),
  ADD KEY `id_relation_type` (`id_relation_type`);

--
-- Klíče pro tabulku `relation_type`
--
ALTER TABLE `relation_type`
  ADD PRIMARY KEY (`id_relation_type`),
  ADD UNIQUE KEY `name` (`name`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `contact`
--
ALTER TABLE `contact`
  MODIFY `id_contact` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pro tabulku `contact_type`
--
ALTER TABLE `contact_type`
  MODIFY `id_contact_type` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pro tabulku `location`
--
ALTER TABLE `location`
  MODIFY `id_location` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pro tabulku `meeting`
--
ALTER TABLE `meeting`
  MODIFY `id_meeting` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT pro tabulku `person`
--
ALTER TABLE `person`
  MODIFY `id_person` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT pro tabulku `relation`
--
ALTER TABLE `relation`
  MODIFY `id_relation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pro tabulku `relation_type`
--
ALTER TABLE `relation_type`
  MODIFY `id_relation_type` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Omezení pro exportované tabulky
--

--
-- Omezení pro tabulku `contact`
--
ALTER TABLE `contact`
  ADD CONSTRAINT `contact_ibfk_1` FOREIGN KEY (`id_person`) REFERENCES `person` (`id_person`),
  ADD CONSTRAINT `contact_ibfk_2` FOREIGN KEY (`id_contact_type`) REFERENCES `contact_type` (`id_contact_type`);

--
-- Omezení pro tabulku `meeting`
--
ALTER TABLE `meeting`
  ADD CONSTRAINT `meeting_ibfk_1` FOREIGN KEY (`id_location`) REFERENCES `location` (`id_location`);

--
-- Omezení pro tabulku `person`
--
ALTER TABLE `person`
  ADD CONSTRAINT `person_ibfk_1` FOREIGN KEY (`id_location`) REFERENCES `location` (`id_location`);

--
-- Omezení pro tabulku `person_meeting`
--
ALTER TABLE `person_meeting`
  ADD CONSTRAINT `person_meeting_ibfk_1` FOREIGN KEY (`id_person`) REFERENCES `person` (`id_person`),
  ADD CONSTRAINT `person_meeting_ibfk_2` FOREIGN KEY (`id_meeting`) REFERENCES `meeting` (`id_meeting`);

--
-- Omezení pro tabulku `relation`
--
ALTER TABLE `relation`
  ADD CONSTRAINT `relation_ibfk_1` FOREIGN KEY (`id_person1`) REFERENCES `person` (`id_person`),
  ADD CONSTRAINT `relation_ibfk_2` FOREIGN KEY (`id_person2`) REFERENCES `person` (`id_person`),
  ADD CONSTRAINT `relation_ibfk_3` FOREIGN KEY (`id_relation_type`) REFERENCES `relation_type` (`id_relation_type`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

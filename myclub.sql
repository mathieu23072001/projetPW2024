-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 17 jan. 2024 à 15:43
-- Version du serveur : 10.4.27-MariaDB
-- Version de PHP : 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `myclub`
--

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE `categorie` (
  `code` varchar(255) NOT NULL,
  `nom` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`code`, `nom`) VALUES
('44', 'huji'),
('4444444', 'huji'),
('Mdv', 'med'),
('new1', 'new'),
('RH', 'rsHH'),
('Rzert', 'RessourceHHH'),
('SH', 'Shonen');

-- --------------------------------------------------------

--
-- Structure de la table `contact`
--

CREATE TABLE `contact` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `prenom` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `telephone` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `contact`
--

INSERT INTO `contact` (`id`, `nom`, `prenom`, `email`, `telephone`) VALUES
(26, 'daa', 'ruru', 'eaa@gmail.com', '000111'),
(30, 'kokou', 'ama', 'cecec@gmail.com', '838303'),
(32, 'daa', 'ruru', 'daa@gmail.com', '890932372'),
(35, 'Dupont', 'Jean', 'jean.dupont@example.com', '0123456789');

-- --------------------------------------------------------

--
-- Structure de la table `datahub`
--

CREATE TABLE `datahub` (
  `numeroLicence` int(11) NOT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `prenom` varchar(255) DEFAULT NULL,
  `nomContact` varchar(255) DEFAULT NULL,
  `prenomContact` varchar(255) DEFAULT NULL,
  `emailContact` varchar(255) DEFAULT NULL,
  `telephoneContact` varchar(20) DEFAULT NULL,
  `codeCategorie` varchar(10) DEFAULT NULL,
  `nomCategorie` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `licencie`
--

CREATE TABLE `licencie` (
  `numeroLicence` int(100) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `idcontact` int(100) DEFAULT NULL,
  `idcategorie` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `pwd` varchar(255) DEFAULT NULL,
  `isAdmin` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `licencie`
--

INSERT INTO `licencie` (`numeroLicence`, `nom`, `prenom`, `idcontact`, `idcategorie`, `email`, `pwd`, `isAdmin`) VALUES
(123456, 'Durand', 'Alissaa', NULL, 'RH', NULL, NULL, NULL),
(451144, 'mathieu', 'abalala', NULL, 'Mdv', NULL, NULL, NULL),
(2001144, 'mathieu', 'aba', 32, 'Rzert', NULL, NULL, NULL),
(4561144, 'mathaaa', 'roger', 32, 'Mdv', NULL, NULL, NULL),
(7663838, 'IZIZIZOZO', 'matyye', NULL, '44', 'jsus@gmail.com', '$2y$10$J6y3igS8Rjb7egzdmitru.fcSoIypo1MTZhVRcr3kLzL6lzeiIBvu', 0),
(22001144, 'mathieu', 'abalala', 32, 'Rzert', NULL, NULL, NULL),
(22032546, 'admin', 'admin', 26, 'new1', 'admin@gmail.com', '$2y$10$69GkZ5nrkh7j5.mjZO2ccOC/C6mSqXtTbvNccbsKwtx4U7SUn1lCy', 1),
(88383838, 'aa', 'abalooo', 26, '44', 'aaa@gmail.com', '$2y$10$tqvmL/nhEcEEW/v8BbekLu44OA1drGLvDaCGvXEIKaEezUSyPPgyi', 1),
(900534267, 'Senou', 'didier', 30, '44', 'didier@gmail.com', '$2y$10$yt8S3I4zYpa1pkl1fT69yeinvH.SX144sHeTB1I.0Gr1Q5AyAABwG', 0),
(2147483647, 'AFZt', 'iouuo', 26, '44', 'zkz@gmail.com', '$2y$10$s/8d3m6nNBw328gTsdXrROQ5JKtfMT86ATw84APCukILFb/RaPGBq', 0);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`code`),
  ADD UNIQUE KEY `code_unique` (`code`);

--
-- Index pour la table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_unique` (`id`);

--
-- Index pour la table `datahub`
--
ALTER TABLE `datahub`
  ADD PRIMARY KEY (`numeroLicence`);

--
-- Index pour la table `licencie`
--
ALTER TABLE `licencie`
  ADD PRIMARY KEY (`numeroLicence`),
  ADD KEY `fk_licencie_contact` (`idcontact`),
  ADD KEY `fk_licencie_categorie` (`idcategorie`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `licencie`
--
ALTER TABLE `licencie`
  ADD CONSTRAINT `fk_licencie_categorie` FOREIGN KEY (`idcategorie`) REFERENCES `categorie` (`code`),
  ADD CONSTRAINT `fk_licencie_contact` FOREIGN KEY (`idcontact`) REFERENCES `contact` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

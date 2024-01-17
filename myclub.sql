-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 03 jan. 2024 à 00:00
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
('A', 'Catégorie A'),
('MDC', 'medical'),
('Mdv', 'medieval'),
('RH', 'rsHH'),
('Rzert', 'Ressourcehumaine'),
('SH', 'Shonen'),
('TZTZT', 'jijij');

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
(5, 'Yao', 'phillipe', NULL, 'RH', 'yao@gmail.com', '$2y$10$UlRBl9DF8kjGfeJWRvd8reOY2/K0GFA1LEeeeBuq.RslfncnIZyv.', 1),
(2001, 'Aka', 'Angelic', 35, 'SH', 'ange@gmail.com,', '$2y$10$j6UMb6NwckndYewyvk5DS.XZFSST4Jzk6iuKrGhBO8aP/BIJv5IXu', 1),
(123456, 'Durand', 'Alissou', 35, 'SH', NULL, NULL, NULL),
(200113, 'abalaa', 'aba', 26, 'TZTZT', 'aa@gmail.com', '123', 1),
(451144, 'mathieu', 'abalala', 32, 'Mdv', NULL, NULL, NULL),
(1234098, 'Koulevo', 'mathias', 26, 'RH', 'mathias@gmail.com', '123', 1),
(2001144, 'mathieu', 'aba', 32, 'Rzert', NULL, NULL, NULL),
(4561144, 'mathaaa', 'roger', 32, 'Mdv', NULL, NULL, NULL),
(22001144, 'mathieu', 'abalala', 32, 'Rzert', NULL, NULL, NULL),
(672430097, 'Lamboni', 'heros', 30, 'Rzert', 'kokou@gmail.com', '123', 0),
(673408263, 'kolani', 'jean', 30, 'Rzert', 'jean@gmail.com', '123', 0);

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

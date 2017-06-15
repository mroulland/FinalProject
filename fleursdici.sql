-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  mer. 14 juin 2017 à 20:40
-- Version du serveur :  10.1.22-MariaDB
-- Version de PHP :  7.1.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `fleursdici`
--

-- --------------------------------------------------------

--
-- Structure de la table `abonnements`
--

CREATE TABLE `abonnements` (
  `id_abonnement` int(5) NOT NULL,
  `id_membre` int(5) NOT NULL,
  `id_personne` int(5) NOT NULL,
  `id_produit` int(2) NOT NULL,
  `id_livraison` int(5) NOT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  `periodicite` enum('une fois par mois','deux fois par mois') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `livraison`
--

CREATE TABLE `livraison` (
  `id_livraison` int(5) NOT NULL,
  `mode` enum('domicile','point relais') NOT NULL,
  `statut_livraison` enum('en préparation','en cours','effectuée') NOT NULL,
  `frais_de_port` decimal(65,0) NOT NULL,
  `id_relais` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `membres`
--

CREATE TABLE `membres` (
  `id_membre` int(5) NOT NULL,
  `id_personne` int(5) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `bancaire` text NOT NULL,
  `status` int(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `personnes`
--

CREATE TABLE `personnes` (
  `id_personne` int(5) NOT NULL,
  `nom` varchar(20) NOT NULL,
  `prenom` varchar(20) NOT NULL,
  `adresse` text NOT NULL,
  `telephone` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `produits`
--

CREATE TABLE `produits` (
  `id_produit` int(5) NOT NULL,
  `nom_produit` varchar(20) NOT NULL,
  `description` text NOT NULL,
  `photo` varchar(255) NOT NULL,
  `prix` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `relais`
--

CREATE TABLE `relais` (
  `id_relais` int(5) NOT NULL,
  `nom_relais` varchar(50) NOT NULL,
  `adresse_relais` text NOT NULL,
  `telephone_relais` int(10) NOT NULL,
  `horaires` text NOT NULL,
  `localisation_googlemap` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `abonnements`
--
ALTER TABLE `abonnements`
  ADD PRIMARY KEY (`id_abonnement`),
  ADD KEY `id_membre` (`id_membre`),
  ADD KEY `id_personne` (`id_personne`),
  ADD KEY `id_produit` (`id_produit`),
  ADD KEY `id_livraison` (`id_livraison`);

--
-- Index pour la table `livraison`
--
ALTER TABLE `livraison`
  ADD PRIMARY KEY (`id_livraison`),
  ADD KEY `id_relais` (`id_relais`);

--
-- Index pour la table `membres`
--
ALTER TABLE `membres`
  ADD PRIMARY KEY (`id_membre`),
  ADD KEY `id_personne` (`id_personne`);

--
-- Index pour la table `personnes`
--
ALTER TABLE `personnes`
  ADD PRIMARY KEY (`id_personne`);

--
-- Index pour la table `produits`
--
ALTER TABLE `produits`
  ADD PRIMARY KEY (`id_produit`);

--
-- Index pour la table `relais`
--
ALTER TABLE `relais`
  ADD PRIMARY KEY (`id_relais`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `abonnements`
--
ALTER TABLE `abonnements`
  MODIFY `id_abonnement` int(5) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `livraison`
--
ALTER TABLE `livraison`
  MODIFY `id_livraison` int(5) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `membres`
--
ALTER TABLE `membres`
  MODIFY `id_membre` int(5) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `personnes`
--
ALTER TABLE `personnes`
  MODIFY `id_personne` int(5) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `relais`
--
ALTER TABLE `relais`
  MODIFY `id_relais` int(5) NOT NULL AUTO_INCREMENT;
--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `livraison`
--
ALTER TABLE `livraison`
  ADD CONSTRAINT `livraison_ibfk_1` FOREIGN KEY (`id_livraison`) REFERENCES `abonnements` (`id_livraison`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `membres`
--
ALTER TABLE `membres`
  ADD CONSTRAINT `membres_ibfk_1` FOREIGN KEY (`id_personne`) REFERENCES `personnes` (`id_personne`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `membres_ibfk_2` FOREIGN KEY (`id_membre`) REFERENCES `abonnements` (`id_membre`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `personnes`
--
ALTER TABLE `personnes`
  ADD CONSTRAINT `personnes_ibfk_1` FOREIGN KEY (`id_personne`) REFERENCES `abonnements` (`id_personne`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `produits`
--
ALTER TABLE `produits`
  ADD CONSTRAINT `produits_ibfk_1` FOREIGN KEY (`id_produit`) REFERENCES `abonnements` (`id_produit`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `relais`
--
ALTER TABLE `relais`
  ADD CONSTRAINT `relais_ibfk_1` FOREIGN KEY (`id_relais`) REFERENCES `livraison` (`id_relais`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

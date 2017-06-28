-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Client :  127.0.0.1
-- Généré le :  Mer 28 Juin 2017 à 13:44
-- Version du serveur :  10.1.21-MariaDB
-- Version de PHP :  7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
-- Structure de la table `pickuplocation`
--

CREATE TABLE `pickuplocation` (
  `id_pul` int(5) NOT NULL,
  `name_pul` varchar(50) NOT NULL,
  `address_pul` text NOT NULL,
  `zipcode_pul` int(5) NOT NULL,
  `city_pul` varchar(20) NOT NULL,
  `phone_pul` int(10) NOT NULL,
  `hours` text NOT NULL,
  `googlemaps_location` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;

--
-- Contenu de la table `pickuplocation`
--

INSERT INTO `pickuplocation` (`id_pul`, `name_pul`, `address_pul`, `zipcode_pul`, `city_pul`, `phone_pul`, `hours`, `googlemaps_location`) VALUES
(3, 'Boutique Bis', '7 rue boulevard du Temple', 75003, 'Paris', 144781108, 'lundi\r\n10:00–19:30\r\nmardi\r\n10:00–19:30\r\nmercredi\r\n10:00–19:30\r\njeudi\r\n10:00–19:30\r\nvendredi\r\n10:00–19:30\r\nsamedi\r\n10:00–19:30\r\ndimanche\r\nFermé', '48.863676, 2.366254'),
(4, 'A nous Paris', '19 rue Clauzel', 75009, 'Paris', 142799904, 'lundi\r\nFermé\r\nmardi\r\nFermé\r\nmercredi\r\n10:00–19:00\r\njeudi\r\n10:00–19:00\r\nvendredi\r\n10:00–19:00\r\nsamedi\r\n11:00–19:00\r\ndimanche\r\nFermé', '48.879365, 2.338008'),
(9, 'Pâtisserie - Boulangerie Benoît Castel', '150 rue de Menilmontant', 75020, 'Paris', 146361382, 'mercredi\r\n07:30–20:00\r\njeudi\r\n07:30–20:00\r\nvendredi\r\n07:30–20:00\r\nsamedi\r\n07:30–20:00\r\ndimanche\r\n08:00–18:00\r\nlundi\r\nFermé\r\nmardi\r\nFermé', '48.870, 2.398'),
(10, 'Boutique Bis', '19 rue Lamartine', 75009, 'Paris', 967609794, 'mercredi\r\n10:00–19:30\r\njeudi\r\n10:00–19:30\r\nvendredi\r\n10:00–19:30\r\nsamedi\r\n10:00–19:30\r\ndimanche\r\nFermé\r\nlundi\r\n10:00–19:30\r\nmardi\r\n10:00–19:30', '');

-- --------------------------------------------------------

--
-- Structure de la table `product`
--

CREATE TABLE `product` (
  `id_product` int(5) NOT NULL,
  `product_name` varchar(20) NOT NULL,
  `description` text NOT NULL,
  `photo` varchar(255) NOT NULL,
  `price` int(100) NOT NULL,
  `size` enum('moyen','gros') NOT NULL,
  `frequency` enum('once_a_month','twice_a_month') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;

--
-- Contenu de la table `product`
--

INSERT INTO `product` (`id_product`, `product_name`, `description`, `photo`, `price`, `size`, `frequency`) VALUES
(1, 'Amarande', 'Une brassée de fleurs par mois pour décorer votre maison.', 'product1.jpg', 30, 'moyen', 'once_a_month'),
(2, 'Hanaé', 'Une brassée de fleurs deux fois par mois pour illuminer votre maison.', 'product2.jpg', 55, 'moyen', 'twice_a_month'),
(3, 'Marjolaine', 'Une grande brassée de fleurs de saison une fois par mois pour votre maison.', 'product3.jpg', 40, 'gros', 'once_a_month'),
(4, 'Vardan', 'Une grande brassée de fleurs deux fois par mois. ', 'product4.jpg', 70, 'gros', 'twice_a_month');

-- --------------------------------------------------------

--
-- Structure de la table `shipping`
--

CREATE TABLE `shipping` (
  `id_shipping` int(5) NOT NULL,
  `mode` enum('domicile','point_relais') NOT NULL,
  `shipping_fees` decimal(65,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;

--
-- Contenu de la table `shipping`
--

INSERT INTO `shipping` (`id_shipping`, `mode`, `shipping_fees`) VALUES
(1, 'domicile', '5'),
(2, 'point_relais', '0');

-- --------------------------------------------------------

--
-- Structure de la table `subscription`
--

CREATE TABLE `subscription` (
  `id_subscription` int(5) NOT NULL,
  `id_user` int(5) NOT NULL,
  `id_product` int(2) NOT NULL,
  `id_shipping` int(5) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `soft_delete` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Contenu de la table `subscription`
--

INSERT INTO `subscription` (`id_subscription`, `id_user`, `id_product`, `id_shipping`, `start_date`, `end_date`, `soft_delete`) VALUES
(1, 10, 1, 1, '2017-06-01', '0000-00-00', 0),
(2, 11, 2, 1, '2017-02-14', NULL, 1),
(3, 2, 2, 2, '2017-05-30', NULL, 1),
(4, 14, 1, 2, '2017-06-11', NULL, 1),
(16, 11, 4, 1, '0000-00-00', NULL, 1),
(17, 15, 1, 2, '0000-00-00', NULL, 1);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id_user` int(5) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `lastname` varchar(20) NOT NULL,
  `firstname` varchar(20) NOT NULL,
  `address` text,
  `zipcode` int(5) DEFAULT NULL,
  `city` varchar(30) DEFAULT NULL,
  `phone` varchar(10) NOT NULL,
  `status` enum('admin','collaborator','user') NOT NULL DEFAULT 'user',
  `stripe_token` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id_user`, `email`, `password`, `lastname`, `firstname`, `address`, `zipcode`, `city`, `phone`, `status`, `stripe_token`) VALUES
(5, 'gerard@email.fr', '$2y$10$brt/rR/GVSFr9GRinugIQ..8dpUdiaNoJKNuv7jeVGx8CjoGzfJJ.', 'Dupont', 'Gérard', '3 rue du pavillon bleu', 75012, 'Paris', '123456789', 'user', NULL),
(10, 'jawn@hotmail.fr', '$2y$10$B0eCe9KlQz/Ri9E8FwZCQe6Jw8..ag2xWLDZzBeEJi287QbYO3wZW', 'Black', 'Jawn', '3 rue des paquerettes', 75014, 'Paris', '123456789', 'admin', NULL),
(11, 'admin@email.fr', '$2y$10$fl0h4yn.Nksi0zM1u/Y8YeS5HiKCOSbFPTwX5RnofWz4VLu4Ru2TG', 'lastname', 'firstname', 'rue des admins', 75014, 'Paris', '0612345678', 'admin', NULL),
(13, 'hermione@email.fr', '$2y$10$w.Tg5ik.PpZolvqKOgkyNOdD20NhnvinCNOoI5GdLTL/13Ulm/5Gu', 'Granger', 'Hermione', 'Salle commune de Gryffondor', 12345, 'Poudlard', '1234567890', 'user', NULL),
(14, 'drago.malefoy@email.FR', '$2y$10$kyut6OyPNwvBX//PcHygXe.69pL6U8/8TvmVamqKyzVpROYZ2./J2', 'Malefoy', 'Drago', 'Salle commune de Serpentard', 75000, 'Poudlard', '0612345678', 'user', NULL),
(15, 'harry@email.fr', '$2y$10$aJAKfT/q0cBM6TfUwE7iNuLx8OQh5B2veovw0jjnsSVTqnXiynr8u', 'Potter', 'Harry', 'Salle commune de Gryffondor', 12345, 'Poudlard', '0123456789', 'user', NULL);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `pickuplocation`
--
ALTER TABLE `pickuplocation`
  ADD PRIMARY KEY (`id_pul`);

--
-- Index pour la table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id_product`);

--
-- Index pour la table `shipping`
--
ALTER TABLE `shipping`
  ADD PRIMARY KEY (`id_shipping`);

--
-- Index pour la table `subscription`
--
ALTER TABLE `subscription`
  ADD PRIMARY KEY (`id_subscription`),
  ADD KEY `id_personne` (`id_user`),
  ADD KEY `id_produit` (`id_product`),
  ADD KEY `id_livraison` (`id_shipping`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `pickuplocation`
--
ALTER TABLE `pickuplocation`
  MODIFY `id_pul` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT pour la table `product`
--
ALTER TABLE `product`
  MODIFY `id_product` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `shipping`
--
ALTER TABLE `shipping`
  MODIFY `id_shipping` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `subscription`
--
ALTER TABLE `subscription`
  MODIFY `id_subscription` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

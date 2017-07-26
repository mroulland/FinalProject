-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Client :  127.0.0.1
-- Généré le :  Mer 26 Juillet 2017 à 16:37
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
-- Structure de la table `article`
--

CREATE TABLE `article` (
  `id_article` int(10) NOT NULL,
  `title` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `content1` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `content2` text NOT NULL,
  `quote` text NOT NULL,
  `short_content` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `picture` varchar(250) NOT NULL,
  `id_category` int(10) NOT NULL DEFAULT '4'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `article`
--

INSERT INTO `article` (`id_article`, `title`, `date`, `content1`, `content2`, `quote`, `short_content`, `picture`, `id_category`) VALUES
(3, 'Article 1', '0000-00-00', '<p>Pellentesque scelerisque lobortis faucibus. Etiam volutpat, leo a pretium scelerisque, erat orci sodales nulla, mattis ultrices magna dolor quis mi. Phasellus tempus commodo suscipit. Fusce venenatis at nunc efficitur laoreet. Cras convallis mauris quam, vel semper metus volutpat quis. Donec consequat elementum tortor, at semper ex porta quis. Curabitur nec libero vel sapien molestie iaculis id at odio. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nulla semper aliquam sapien, sed molestie magna porttitor gravida.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Aliquam consequat placerat ornare. Fusce pharetra rutrum arcu, eget accumsan felis tincidunt vitae. Etiam mollis neque at elit viverra, at consequat ipsum bibendum. Suspendisse risus augue, fermentum et lorem vitae, ultrices ullamcorper elit. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n', '<p>Pellentesque scelerisque lobortis faucibus. Etiam volutpat, leo a pretium scelerisque, erat orci sodales nulla, mattis ultrices magna dolor quis mi. Phasellus tempus commodo suscipit. Fusce venenatis at nunc efficitur laoreet. Cras convallis mauris quam, vel semper metus volutpat quis. Donec consequat elementum tortor, at semper ex porta quis. Curabitur nec libero vel sapien molestie iaculis id at odio. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nulla semper aliquam sapien, sed molestie magna porttitor gravida. Aliquam consequat placerat ornare. Fusce pharetra rutrum arcu, eget accumsan felis tincidunt vitae. Etiam mollis neque at elit viverra, at consequat ipsum bibendum. Suspendisse risus augue, fermentum et lorem vitae, ultrices ullamcorper elit. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.</p>\r\n', '<p>Cash rules everything around me, C.R.E.A.M. Get the money, dollar dollar bill, y&#39;all</p>\r\n', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed convallis tortor est, at dictum dui tristique sed.</p>\r\n', 'photo11.jpg', 2),
(106, 'Carrion Flowers', '2017-07-05', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?', 'Creatures of habit\r\nCarrion flowers\r\nGrowing from repeated crimes', 'Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit ', 'product4.jpg', 4),
(107, 'Green Flower, Blue Fish', '2017-07-20', 'Ut et consectetur quam. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Fusce interdum massa ipsum, id sodales est malesuada at. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Morbi at lorem ac lectus lobortis auctor ac vel turpis. Curabitur posuere condimentum scelerisque. Fusce porttitor diam eu leo bibendum laoreet. Aenean eleifend hendrerit tortor, nec vulputate sem mollis vel. Duis id enim ut dolor ullamcorper porttitor. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec hendrerit, ante vestibulum tincidunt condimentum, erat nisi lobortis lorem, eget laoreet mi urna vitae nisl. Aliquam erat volutpat. Donec nec magna at elit elementum posuere ut a nisl. Sed tristique tincidunt sapien.', 'In at ultricies arcu, in tempus ante. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Aliquam lobortis ornare leo. Cras sed suscipit ante. Nulla efficitur mauris quis aliquam mollis. Curabitur maximus sapien ut ante scelerisque bibendum. Mauris eu tellus vitae ipsum convallis auctor sit amet ut purus. Mauris dapibus iaculis augue, porttitor consectetur mi dignissim nec. Nullam quis diam at diam elementum euismod et nec ipsum. Integer dapibus enim turpis, sodales porta ligula tincidunt eget.\r\n\r\nPhasellus ullamcorper tincidunt mauris lacinia aliquam. Sed tincidunt magna massa, eget molestie massa mattis nec. Donec auctor nec turpis a porttitor. Mauris nisi quam, fermentum vel leo at, egestas egestas augue. Phasellus augue risus, venenatis a imperdiet at, interdum in libero. Vestibulum eget dui sit amet orci varius finibus. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. ', 'You filled your vase full but the flowers all died\r\nYou painted them green but the paint would not dry', 'Mauris dapibus iaculis augue, porttitor consectetur mi dignissim nec. Nullam quis diam at diam elementum euismod et nec ipsum. Integer dapibus enim turpis, sodales porta ligula tincidunt eget.\r\n', 'tulipes.jpg', 4);

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

CREATE TABLE `category` (
  `id_category` int(10) NOT NULL,
  `category_name` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `category`
--

INSERT INTO `category` (`id_category`, `category_name`) VALUES
(1, 'articles'),
(2, 'conseils pratiques'),
(3, 'lexique de fleurs'),
(4, 'actualités');

-- --------------------------------------------------------

--
-- Structure de la table `gift`
--

CREATE TABLE `gift` (
  `id_gift` int(5) NOT NULL,
  `id_user` int(5) NOT NULL,
  `id_receiver` int(5) NOT NULL,
  `id_product` int(1) NOT NULL,
  `id_shipping` int(1) NOT NULL,
  `duration` int(1) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `total_price` int(3) NOT NULL,
  `code` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `gift`
--

INSERT INTO `gift` (`id_gift`, `id_user`, `id_receiver`, `id_product`, `id_shipping`, `duration`, `start_date`, `end_date`, `total_price`, `code`) VALUES
(1, 17, 11, 2, 1, 3, '2017-07-12', '2017-10-12', 180, 'RASL44ZCJ9N2FN44AFQL'),
(2, 17, 11, 1, 2, 3, '2017-07-12', '2017-10-12', 90, 'C91VNOIFBPDHDBHJZT5B');

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
(3, 'Boutique Bis', '10 rue boulevard du Temple', 75003, 'Paris', 144781108, 'lundi\r\n10:00–19:30\r\nmardi\r\n10:00–19:30\r\nmercredi\r\n10:00–19:30\r\njeudi\r\n10:00–19:30\r\nvendredi\r\n10:00–19:30\r\nsamedi\r\n10:00–19:30\r\ndimanche\r\nFermé', '48.863676, 2.366254'),
(4, 'A nous Paris', '19 rue Clauzel', 75009, 'Paris', 142799904, 'lundi\r\nFermé\r\nmardi\r\nFermé\r\nmercredi\r\n10:00–19:00\r\njeudi\r\n10:00–19:00\r\nvendredi\r\n10:00–19:00\r\nsamedi\r\n11:00–19:00\r\ndimanche\r\nFermé', '48.879365, 2.338008'),
(8, 'Jawn Black', '182 avenue Denfert Rochereau', 75014, 'Paris', 123456789, 'fggf', 'fgfgf');

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
  `frequency` enum('une fois par mois','deux fois par mois') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;

--
-- Contenu de la table `product`
--

INSERT INTO `product` (`id_product`, `product_name`, `description`, `photo`, `price`, `size`, `frequency`) VALUES
(1, 'Amarande', 'Une brassée de fleurs par mois pour décorer votre maison.', 'product1.jpg', 30, 'moyen', 'une fois par mois'),
(2, 'Hanaé', 'Une brassée de fleurs deux fois par mois pour illuminer votre maison.', 'product2.jpg', 55, 'moyen', 'deux fois par mois'),
(3, 'Marjolaine', 'Une grande brassée de fleurs de saison une fois par mois pour votre maison.', 'product3.jpg', 40, 'gros', 'une fois par mois'),
(4, 'Vardan', 'Une grande brassée de fleurs deux fois par mois. ', 'product4.jpg', 70, 'gros', 'deux fois par mois');

-- --------------------------------------------------------

--
-- Structure de la table `shipping`
--

CREATE TABLE `shipping` (
  `id_shipping` int(5) NOT NULL,
  `mode` enum('domicile','point relais') NOT NULL,
  `shipping_fees` decimal(65,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;

--
-- Contenu de la table `shipping`
--

INSERT INTO `shipping` (`id_shipping`, `mode`, `shipping_fees`) VALUES
(1, 'domicile', '5'),
(2, 'point relais', '0');

-- --------------------------------------------------------

--
-- Structure de la table `subscription`
--

CREATE TABLE `subscription` (
  `id_subscription` int(5) NOT NULL,
  `id_user` int(5) NOT NULL,
  `id_product` int(2) NOT NULL,
  `id_shipping` int(5) NOT NULL,
  `id_pul` int(2) DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `soft_delete` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Contenu de la table `subscription`
--

INSERT INTO `subscription` (`id_subscription`, `id_user`, `id_product`, `id_shipping`, `id_pul`, `start_date`, `end_date`, `soft_delete`) VALUES
(1, 10, 1, 1, NULL, '2017-06-01', '0000-00-00', 0),
(3, 2, 2, 2, NULL, '0000-00-00', NULL, 1),
(4, 14, 3, 2, NULL, '0000-00-00', NULL, 1),
(5, 15, 3, 2, NULL, '0000-00-00', NULL, 1),
(6, 17, 3, 1, NULL, '2017-07-11', NULL, 1),
(8, 11, 2, 1, NULL, '2017-07-12', '2017-10-12', 0);

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
  `status` enum('admin','collaborator','user') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id_user`, `email`, `password`, `lastname`, `firstname`, `address`, `zipcode`, `city`, `phone`, `status`) VALUES
(2, 'radio-nova@hotmail.fr', '$2y$10$amu4YyllkMxL2P0uVpgOyOYMFyW.kTysCd5nO49mj3F3CxoMMUIb6', 'louis', 'loli', NULL, NULL, NULL, '689560205', ''),
(5, 'gerard@email.fr', '$2y$10$brt/rR/GVSFr9GRinugIQ..8dpUdiaNoJKNuv7jeVGx8CjoGzfJJ.', 'Dupont', 'Gérard', '3 rue du pavillon bleu', 75012, 'Paris', '123456789', 'user'),
(6, 'maurice@email.fr', '$2y$10$4Y8k6LJvXbGvHBjvNKUXTe9uKLDxbnURtl3ZnFvVY61bq5rxnD0YS', 'Dupuis', 'Maurice', NULL, NULL, NULL, '0612345678', 'user'),
(10, 'jawn@hotmail.fr', '$2y$10$B0eCe9KlQz/Ri9E8FwZCQe6Jw8..ag2xWLDZzBeEJi287QbYO3wZW', 'Black', 'Jawn', '3 rue des paquerettes', 75014, 'Paris', '123456789', 'admin'),
(11, 'admin@email.fr', '$2y$10$fl0h4yn.Nksi0zM1u/Y8YeS5HiKCOSbFPTwX5RnofWz4VLu4Ru2TG', 'admin_lastname', 'admin_firstname', 'rue des admins', 75014, 'Paris', '0612345678', 'admin'),
(12, 'morganelydia@hotmail.com', '$2y$10$j92RowTXK/Ftw8LytJ3OTuw3ckNzN5NU3JBxEnTaUoMe32o1BQecq', 'Roulland', 'Morgane', 'dfsfd', 75014, 'Par', '1234567890', 'user'),
(13, 'hermione@email.fr', '$2y$10$w.Tg5ik.PpZolvqKOgkyNOdD20NhnvinCNOoI5GdLTL/13Ulm/5Gu', 'Granger', 'Hermione', 'Salle commune de Gryffondor', 12345, 'Poudlard', '1234567890', 'user'),
(14, 'tanguy.pichavant@hotmail.com', '$2y$10$w3OJrSUaBvWOMWPL2curT.GUVRuEGW2xLBPEM213w36M3z6LzXeRa', 'pichavant', 'tanguy', 'fgjdfgjfdg', 75019, 'paris', '0678560452', 'user'),
(15, 'tanguy.pichavant@gmail.com', '$2y$10$AQx1bg/nA372xKFHLicLO.T85JLzZ01uozUkMmfS6LgJILgSiAT42', 'pich', 'tang', '159 rue', 75019, 'paris', '0678560452', ''),
(16, 'ertrer@hotmail.com', '$2y$10$NotA.qXt/TVyCEOnZTfAL.WwpufC4a9a.EMg6RSuzu4h.aPYI9uYi', 'pichavant', 'tanguy', '12 rthrtyuytjtyjt', 75019, 'paris', '6785604525', 'user'),
(17, 'shallan@email.fr', '$2y$10$/QKvu.ysjJq0enXB7mZ3yurf5ZZp.ntMnoID5T6sUV.fslmIvv6Ni', 'Shallan', 'Devar', 'Famille Devar, camp de guerre de Dalinar', 66666, 'Les Plaines Brisées', '0236985412', 'user');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`id_article`),
  ADD KEY `category_id` (`id_category`);

--
-- Index pour la table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id_category`);

--
-- Index pour la table `gift`
--
ALTER TABLE `gift`
  ADD PRIMARY KEY (`id_gift`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_receiver` (`id_receiver`),
  ADD KEY `id_product` (`id_product`),
  ADD KEY `id_shipping` (`id_shipping`);

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
-- AUTO_INCREMENT pour la table `article`
--
ALTER TABLE `article`
  MODIFY `id_article` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;
--
-- AUTO_INCREMENT pour la table `category`
--
ALTER TABLE `category`
  MODIFY `id_category` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `gift`
--
ALTER TABLE `gift`
  MODIFY `id_gift` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `pickuplocation`
--
ALTER TABLE `pickuplocation`
  MODIFY `id_pul` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
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
  MODIFY `id_subscription` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

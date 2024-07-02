-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 27 fév. 2024 à 01:00
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gestion_stag`
--

-- --------------------------------------------------------

--
-- Structure de la table `encadreurs`
--

CREATE TABLE `encadreurs` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `cv` varchar(255) DEFAULT NULL,
  `numero_telephone` varchar(15) DEFAULT NULL,
  `cv_path` varchar(255) DEFAULT NULL
) ;

--
-- Déchargement des données de la table `encadreurs`
--

INSERT INTO `encadreurs` (`id`, `nom`, `prenom`, `cv`, `numero_telephone`, `cv_path`) VALUES
(17, 'sihem', 'chabeen', NULL, '52154843', 'uploads/cv/Doc1.pdf'),
(18, 'hadil', 'ben doudou', NULL, '52110723', 'uploads/cv/Doc1.pdf');

-- --------------------------------------------------------

--
-- Structure de la table `filiere`
--

CREATE TABLE `filiere` (
  `idFiliere` int(4) NOT NULL,
  `nomFiliere` varchar(50) DEFAULT NULL,
  `niveau` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `filiere`
--

INSERT INTO `filiere` (`idFiliere`, `nomFiliere`, `niveau`) VALUES
(381, 'dsi', '2 eme'),
(389, 'rsi', '2 eme'),
(391, 'ti', '1 eme'),
(392, 'mdw', '2 eme'),
(393, 'systeme embarquer', '2 eme');

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

CREATE TABLE `messages` (
  `message_id` int(11) NOT NULL,
  `sender_id` int(11) DEFAULT NULL,
  `receiver_id` int(11) DEFAULT NULL,
  `message_text` text DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `photo_data` longblob DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `messages`
--

INSERT INTO `messages` (`message_id`, `sender_id`, `receiver_id`, `message_text`, `timestamp`, `photo_data`, `image_path`, `file_path`, `is_read`) VALUES
(612, 37, 6, 'gfds', '2024-02-24 22:48:34', NULL, NULL, NULL, 0),
(613, 37, 6, ' b', '2024-02-24 22:51:01', NULL, NULL, NULL, 0),
(614, 37, 6, 'cvbn,', '2024-02-24 22:55:20', NULL, NULL, NULL, 0),
(615, 1, 6, '', '2024-02-25 10:48:26', NULL, NULL, '../../../fichierAttestation (81).pdf', 0),
(616, 1, 6, '', '2024-02-25 10:48:31', NULL, '../../../imgCapture10.PNG', NULL, 0),
(617, 6, 37, '', '2024-02-25 11:47:09', NULL, '../../../img/Capture1.PNG', NULL, 0),
(618, 6, 37, '', '2024-02-25 11:47:26', NULL, NULL, '../../../fichierAttestation (81).pdf', 0),
(619, 6, 37, 'hadil', '2024-02-25 16:24:22', NULL, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Structure de la table `oublier`
--

CREATE TABLE `oublier` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `last_modified_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `oublier`
--

INSERT INTO `oublier` (`id`, `email`, `login`, `password`, `last_modified_date`) VALUES
(2, 'bendoudouhadil@gmail.com', 'didi', '$2y$10$ncGX6AWnbW11OKxP5lx0NeN/HoDuJHCE6aWT3IVNvBV4Z1lGDFH8m', '2024-01-24 08:36:29'),
(3, 'bendoudouhadil@gmail.com', 'didi', '$2y$10$lIXJln03Yjcd6BNJq6GZWeMOkQDfzExwXjNGT3whwNPWluYCjK4Dy', '2024-01-24 08:52:37'),
(4, 'bendoudouhadil@gmail.com', 'didi', '69b666deaf1e4ffd', '2024-01-24 09:26:31'),
(5, 'bendoudouhadil@gmail.com', 'didi', '$2y$10$Dtj9zULSCCxmP4j/GZGywOCCOs4bvR9WVsEEPTEdXLv1qUjQk5nTy', '2024-01-24 09:43:24'),
(6, 'bendoudouhadil@gmail.com', 'didi', 'ab465e68074306f020b5fd7e4655f16d', '2024-01-24 09:44:58'),
(7, 'bendoudouhadil@gmail.com', 'didi', '2f1382a77c7ec4e47f2c22df4b173dfb', '2024-01-24 09:47:34'),
(8, 'bendoudouhadil@gmail.com', 'didi', '703e1b215de89616b0ce339ff533a8ff', '2024-01-24 09:50:18'),
(9, 'bendoudouhadil@gmail.com', 'didi', '_237an8A', '2024-01-24 10:04:12'),
(10, 'bendoudouhadil@gmail.com', 'didi', 'd549be06bd6debf356bdb676529bb0d9', '2024-01-24 10:06:39'),
(11, 'bendoudouhadil@gmail.com', 'didi', '60e6e74beb70fed702c77a9acf66096d', '2024-01-24 20:07:18'),
(12, 'bendoudouhadil@gmail.com', 'didi', '82957f207436f5ac5493ab616aecd345', '2024-01-24 20:07:43'),
(13, 'bendoudouhadil@gmail.com', 'didi', '771308d1ed3b4838e353974aaa1509c8', '2024-01-24 20:08:11'),
(14, 'bendoudouhadil@gmail.com', 'didi', '55bd16d24756aafc9858c4306869048f', '2024-01-24 20:09:14'),
(15, 'bendoudouhadil@gmail.com', 'didi', '719014dd0f4042be1e1834b36c1c82e3', '2024-01-24 20:09:16'),
(16, 'bendoudouhadil@gmail.com', 'didi', '89a13d8ccdf70115d41ba016babe6109', '2024-01-28 11:03:20'),
(17, 'bendoudouhadil@gmail.com', 'didi', '7b8cc0e40d6c12291bfe81eef9355962', '2024-01-28 11:03:24'),
(18, 'bendoudouhadil@gmail.com', 'didi', 'ffaba3db0470deb998f5b68df8c23b0f', '2024-01-28 11:29:50'),
(19, 'bendoudouhadil@gmail.com', 'didi', '5eb5e9f42d61eb01cdb4f681cc855584', '2024-01-28 12:38:38'),
(20, 'bendoudouhadil@gmail.com', 'didi', '4d18de0c14f4e2731505e1051217e879', '2024-01-28 12:38:54'),
(21, 'bendoudouhadil@gmail.com', 'didi', 'ed640184a797e8bbb1f1344c0c54ddc2', '2024-01-29 19:17:02'),
(22, 'bendoudouhadil@gmail.com', 'didi', '1deae82bc4feb7f91f613574872d3a55', '2024-01-31 20:23:27'),
(23, 'toumiranim22@gmail.com', 'ranim', 'e34dbafa1a1a7a617cefcf4ba4a0bcbf', '2024-01-31 20:24:55'),
(24, 'bendoudouhadil@gmail.com', 'didi', '51bb8e4cf18bb225ba53a447809d75b0', '2024-02-07 19:15:05'),
(25, 'consultwedo@gmail.com', 'admin', 'f58a4535be890461ea460820671a88fe', '2024-02-09 12:11:45'),
(26, 'consultwedo@gmail.com', 'admin', '588e9a2491752a1caaf7fce05059210f', '2024-02-09 12:12:03'),
(27, 'consultwedo@gmail.com', 'admin', 'd0b894c89c8c8e91a821d15f4e6a90f2', '2024-02-09 12:18:02'),
(28, 'consultwedo@gmail.com', 'admin', '4654007fa8640e7e99368054be4ff796', '2024-02-09 12:36:28'),
(29, 'consultwedo@gmail.com', 'admin', 'd06040a3c79d4ef6b3838e7e23d0aff9', '2024-02-09 12:36:30'),
(30, 'consultwedo@gmail.com', 'admin', '70ecec9e9bb8d25a28d61867a0c85863', '2024-02-09 12:44:45'),
(31, 'consultwedo@gmail.com', 'admin', 'f044dc4f31af4469d1108c19b1588c76', '2024-02-09 13:07:34'),
(32, 'consultwedo@gmail.com', 'admin', 'bcb5fd7d4a74e25a4ed0b72638be1cc3', '2024-02-09 13:08:37'),
(33, 'consultwedo@gmail.com', 'admin', 'b1db2f0e45050a5e01ee3b6f799c4f7f', '2024-02-09 13:08:38'),
(34, 'bendoudouhadil@gmail.com', 'didi', 'cba65f4e01f0628c56812718978ffdf9', '2024-02-11 21:46:23'),
(35, 'fatmabenrjab15@gmail.com', 'fatma', 'ddbab713c4cd206251eeea399dcef5ba', '2024-02-12 13:40:13'),
(36, 'FATMABENRJAB15@GMAIL.COM', 'fatma', 'ec163debeb9fb8687fb55cec1da546ea', '2024-02-12 13:41:06'),
(37, 'FATMABENRJAB15@GMAIL.COM', 'fatma', '4cba111db5518ec2161fac264ad2a80a', '2024-02-12 13:41:24'),
(38, 'bendoudouhadil@gmail.com', 'didi', '08cb35f3f7d60e26274b074027a87f0c', '2024-02-12 13:41:34'),
(39, 'bendoudouhadil@gmail.com', 'didi', '0505ac62aa50399fdae7ba467e0ec0b8', '2024-02-12 13:41:41'),
(40, 'bendoudouhadil@gmail.com', 'didi', 'e209290425bb8ea36788e68055c9e8a4', '2024-02-12 13:41:45'),
(41, 'bendoudouhadil@gmail.com', 'didi', '3eb5fe020da75546e980d3397e2cf625', '2024-02-12 13:41:54'),
(42, 'bendoudouhadil@gmail.com', 'didi', '03c68e24775130a9f98c284d6ad62891', '2024-02-12 13:42:47'),
(43, 'bendoudouhadil@gmail.com', 'didi', '3ab85be02598ce410a6ea729f824095c', '2024-02-12 13:42:52'),
(44, 'bendoudouhadil@gmail.com', 'didi', '0946d1b3f45a17d7159ee3818e7ea464', '2024-02-12 13:43:05'),
(45, 'bendoudouhadil@gmail.com', 'didi', '194e3131445bfd421e4c4af8b9887f6b', '2024-02-12 13:43:15'),
(46, 'bendoudouhadil@gmail.com', 'didi', '125ac9e82bd2dbda40427077f6170a00', '2024-02-12 13:46:03'),
(47, 'bendoudouhadil@gmail.com', 'didi', '0f474f8ee4045699db4ccfb31f70cbd2', '2024-02-12 13:48:41'),
(48, 'bendoudouhadil@gmail.com', 'didi', 'fc6b0bf799fd26b2adb4ff5325f2d53f', '2024-02-12 13:48:43'),
(49, 'bendoudouhadil@gmail.com', 'didi', 'ed5046547deede5c48d4351743154394', '2024-02-12 13:48:48'),
(50, 'bendoudouhadil@gmail.com', 'didi', '2465e83f795b2b2823598ea3ea295c68', '2024-02-12 13:48:54'),
(51, 'fatmabenrjab15@gmail.com', 'fatma', '9d80f0b6888f5ee74b3c09573c0de824', '2024-02-12 13:49:21'),
(52, 'fatmabenrjab15@gmail.com', 'fatma', 'c07c4e0ccc92f4fa13f3026f3f579767', '2024-02-12 13:49:23'),
(53, 'bendoudouhadil@gmail.com', 'didi', 'db116678f2fd5162b493dc87208b6776', '2024-02-21 21:48:59');

-- --------------------------------------------------------

--
-- Structure de la table `stagiaire`
--

CREATE TABLE `stagiaire` (
  `idStagiaire` int(4) NOT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `prenom` varchar(50) DEFAULT NULL,
  `civilite` varchar(1) DEFAULT NULL,
  `photo` varchar(100) DEFAULT NULL,
  `idFiliere` int(4) DEFAULT NULL,
  `carte_identite` int(8) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL
) ;

--
-- Déchargement des données de la table `stagiaire`
--

INSERT INTO `stagiaire` (`idStagiaire`, `nom`, `prenom`, `civilite`, `photo`, `idFiliere`, `carte_identite`, `email`) VALUES
(48, 'ben rjab', 'fatma', 'F', 'images.jpeg', 393, 14423658, 'fatmabenrjab15@gmail.com'),
(51, 'ben khlifa', 'abir', 'F', 'tiktok-profile-picture-idea-4--1--1.jpeg', 381, 14436945, 'benkhlifabir@gmail.com'),
(55, 'ben doudou', 'hadil', 'F', 'circle-photo.jpg', 381, 14436985, 'bendoudouhadil@gmail.com');

-- --------------------------------------------------------

--
-- Structure de la table `taches`
--

CREATE TABLE `taches` (
  `id` int(11) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_limite` date DEFAULT NULL,
  `etat` enum('A_faire','En_cours','Terminee') DEFAULT 'A_faire',
  `id_utilisateur` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `taches`
--

INSERT INTO `taches` (`id`, `titre`, `description`, `date_creation`, `date_limite`, `etat`, `id_utilisateur`) VALUES
(263, 'php', 'intaller xamp et configuration', '2024-02-08 15:36:57', '2024-03-10', 'Terminee', 6),
(265, 'wedo consult', 'connaitre la société et personne de développement  ', '2024-02-08 15:38:34', '2024-03-10', 'Terminee', 6);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `iduser` int(4) NOT NULL,
  `login` varchar(50) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `role` varchar(50) DEFAULT NULL,
  `etat` int(1) DEFAULT NULL,
  `pwd` varchar(255) DEFAULT NULL,
  `rapport` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`iduser`, `login`, `email`, `role`, `etat`, `pwd`, `rapport`) VALUES
(1, 'admin', 'consultwedo@gmail.com', 'ADMIN', 1, '827ccb0eea8a706c4c34a16891f84e7b', NULL),
(6, 'abir', 'ABIR@GMAIL.COM', 'VISITEUR', 1, 'cb384d438a2b4f8193d288696efe26b4', 'page de garde.pdf'),
(12, 'bata', 'BATA@GMAIL.COM', 'VISITEUR', 1, '09ed10e9ae16e2443a235d0c1f701604', NULL),
(33, 'admin2', 'admin22@gmail.com', 'ADMIN', 1, '5c5a4541ea122c6c5dd9042b60cf8a99', NULL),
(37, 'admin3', 'admin3@gmail.com', 'ADMIN', 1, '32cacb2f994f6b42183a1300d9a3e8d6', NULL);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `encadreurs`
--
ALTER TABLE `encadreurs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `numero_telephone` (`numero_telephone`);

--
-- Index pour la table `filiere`
--
ALTER TABLE `filiere`
  ADD PRIMARY KEY (`idFiliere`),
  ADD UNIQUE KEY `nom_contrainte` (`nomFiliere`);

--
-- Index pour la table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`message_id`);

--
-- Index pour la table `oublier`
--
ALTER TABLE `oublier`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `stagiaire`
--
ALTER TABLE `stagiaire`
  ADD PRIMARY KEY (`idStagiaire`),
  ADD UNIQUE KEY `carte_identite` (`carte_identite`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idFiliere` (`idFiliere`);

--
-- Index pour la table `taches`
--
ALTER TABLE `taches`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_utilisateur` (`id_utilisateur`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`iduser`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `encadreurs`
--
ALTER TABLE `encadreurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `filiere`
--
ALTER TABLE `filiere`
  MODIFY `idFiliere` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=406;

--
-- AUTO_INCREMENT pour la table `messages`
--
ALTER TABLE `messages`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=620;

--
-- AUTO_INCREMENT pour la table `oublier`
--
ALTER TABLE `oublier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT pour la table `stagiaire`
--
ALTER TABLE `stagiaire`
  MODIFY `idStagiaire` int(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `taches`
--
ALTER TABLE `taches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=275;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `iduser` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `stagiaire`
--
ALTER TABLE `stagiaire`
  ADD CONSTRAINT `stagiaire_ibfk_1` FOREIGN KEY (`idFiliere`) REFERENCES `filiere` (`idFiliere`);

--
-- Contraintes pour la table `taches`
--
ALTER TABLE `taches`
  ADD CONSTRAINT `taches_ibfk_1` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`iduser`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

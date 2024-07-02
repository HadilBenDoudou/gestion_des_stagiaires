-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 20 fév. 2024 à 10:46
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
  `is_read` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `messages`
--

INSERT INTO `messages` (`message_id`, `sender_id`, `receiver_id`, `message_text`, `timestamp`, `is_read`) VALUES
(439, 33, 6, 'hi\r\n', '2024-02-18 00:13:35', 0),
(440, 33, 6, 'cvn\r\n', '2024-02-18 00:14:09', 0),
(441, 33, 10, 'hi\r\n', '2024-02-18 00:28:32', 0),
(442, 33, 10, '!!\r\n', '2024-02-18 00:32:47', 0),
(443, 33, 6, 'k,dko', '2024-02-18 00:34:57', 0),
(444, 33, 6, 'fcfd', '2024-02-18 00:35:01', 0),
(445, 33, 6, 'ded', '2024-02-18 00:35:04', 0),
(446, 33, 6, 'xs', '2024-02-18 00:35:12', 0),
(447, 6, 33, 'gg', '2024-02-18 00:35:47', 0),
(448, 33, 6, 'jnjbjbhvhj', '2024-02-18 09:57:59', 0),
(449, 33, 6, 'jnjbjbhvhj', '2024-02-18 09:58:27', 0),
(450, 33, 6, 'tay\r\n', '2024-02-18 09:58:38', 0),
(451, 33, 6, 'tay\r\n', '2024-02-18 09:59:23', 0),
(452, 33, 6, 'tay\r\n', '2024-02-18 10:00:00', 0),
(453, 33, 6, 'wa', '2024-02-18 10:03:02', 0),
(454, 33, 6, 'wa', '2024-02-18 10:04:21', 0),
(455, 33, 6, 'cv', '2024-02-18 10:05:21', 0),
(456, 33, 6, 'cv', '2024-02-18 10:05:42', 0),
(457, 33, 6, 'bbbbbb', '2024-02-18 10:06:16', 0),
(458, 33, 6, 'bbbbbb', '2024-02-18 10:06:55', 0),
(459, 33, 6, 'szsb', '2024-02-18 10:07:34', 0),
(460, 33, 6, 'frf', '2024-02-18 10:13:07', 0),
(461, 6, 33, 'vv', '2024-02-18 10:15:23', 0),
(462, 33, 6, 'cdk,', '2024-02-18 10:20:33', 0),
(463, 33, 6, 'cdk,', '2024-02-18 10:21:06', 0),
(464, 33, 6, 'cnnc', '2024-02-18 10:21:12', 0),
(465, 33, 6, 'cnnc', '2024-02-18 10:21:32', 0),
(466, 33, 6, 'gfg', '2024-02-18 10:22:44', 0),
(467, 33, 6, 'gfg', '2024-02-18 10:24:49', 0),
(468, 33, 6, 'dd', '2024-02-18 10:24:53', 0),
(469, 33, 6, '  cd', '2024-02-18 10:30:37', 0),
(470, 33, 6, 'nnnnnnnnnnnn', '2024-02-18 10:30:46', 0),
(471, 33, 6, 'cddc', '2024-02-18 10:33:31', 0),
(472, 33, 6, 'd', '2024-02-18 10:53:53', 0),
(473, 6, 33, 'hi\r\n', '2024-02-18 10:55:50', 0),
(474, 6, 12, 'hi', '2024-02-18 11:07:52', 0),
(475, 6, 33, 'hi', '2024-02-18 11:09:00', 0),
(476, 6, 33, 'cvn', '2024-02-18 11:09:04', 0),
(477, 6, 33, 'kjf', '2024-02-18 11:19:16', 0),
(478, 33, 6, 'hi \r\n', '2024-02-18 12:44:29', 0);

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
(52, 'fatmabenrjab15@gmail.com', 'fatma', 'c07c4e0ccc92f4fa13f3026f3f579767', '2024-02-12 13:49:23');

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
(53, 'aissa', 'emna', 'F', 'round_profil_picture_after_.webp', 389, 14469875, 'emnaaissa@gmail.com'),
(54, 'jlassi', 'ahmed', 'F', '1600w-2PE9qJLmPac.webp', 381, 14436954, 'ahmedjlassi@gmail.com'),
(55, 'ben doudou', 'hadil', 'F', 'circle-photo.jpg', 381, 14436985, 'bendoudouhadil@gmail.com'),
(59, 'toumi', 'ranim', 'F', 'Capture d’écran (10).png', 381, 14489635, 'toumiranim@gmail.com');

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
(262, 'php', 'connaitre bibliothèque de phpmailer et domphp ', '2024-02-08 15:36:26', '2024-02-16', 'Terminee', 6),
(263, 'php', 'intaller xamp et configuration', '2024-02-08 15:36:57', '2024-03-10', 'Terminee', 6),
(264, 'php', 'connaitre jQuery et ajax', '2024-02-08 15:37:40', '2024-02-16', 'Terminee', 6),
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
(6, 'abir', 'ABIR1@GMAIL.COM', 'VISITEUR', 1, 'cb384d438a2b4f8193d288696efe26b4', 'page de garde.pdf'),
(10, 'didi', 'bendoudouhadil@gmail.com', 'VISITEUR', 1, '2465e83f795b2b2823598ea3ea295c68', 'Liris-2799.pdf'),
(12, 'bata', 'bata@gmail.com', 'VISITEUR', 1, '09ed10e9ae16e2443a235d0c1f701604', NULL),
(32, 'fatma', 'FATMABENRJAB15@GMAIL.COM', 'VISITEUR', 1, 'c07c4e0ccc92f4fa13f3026f3f579767', NULL),
(33, 'admin2', 'admin2@gmail.com', 'ADMIN', 1, 'c84258e9c39059a89ab77d846ddab909', NULL);

--
-- Index pour les tables déchargées
--

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
-- AUTO_INCREMENT pour la table `filiere`
--
ALTER TABLE `filiere`
  MODIFY `idFiliere` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=394;

--
-- AUTO_INCREMENT pour la table `messages`
--
ALTER TABLE `messages`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=479;

--
-- AUTO_INCREMENT pour la table `oublier`
--
ALTER TABLE `oublier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT pour la table `stagiaire`
--
ALTER TABLE `stagiaire`
  MODIFY `idStagiaire` int(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `taches`
--
ALTER TABLE `taches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=267;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `iduser` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

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

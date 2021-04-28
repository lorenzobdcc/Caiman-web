-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : mer. 28 avr. 2021 à 13:54
-- Version du serveur :  5.7.24
-- Version de PHP : 7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `caiman`
--

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE `categorie` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`id`, `name`) VALUES
(8, 'Dragon Ball'),
(4, 'Fight'),
(3, 'Kingdom Hearts'),
(2, 'Mario'),
(5, 'Multiplayer'),
(6, 'Rpg'),
(7, 'Sport'),
(1, 'The legend of Zelda');

-- --------------------------------------------------------

--
-- Structure de la table `consol`
--

CREATE TABLE `consol` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `folderName` text NOT NULL,
  `idEmulator` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `consol`
--

INSERT INTO `consol` (`id`, `name`, `folderName`, `idEmulator`) VALUES
(1, 'Nintendo Gamecube', 'GamecubeWii', 1),
(2, 'Playstation 2', 'Playstation2', 2),
(3, 'Wii', 'GamecubeWii', 1);

-- --------------------------------------------------------

--
-- Structure de la table `emulator`
--

CREATE TABLE `emulator` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `emulator`
--

INSERT INTO `emulator` (`id`, `name`) VALUES
(1, 'Dolphin'),
(2, 'PCSX2');

-- --------------------------------------------------------

--
-- Structure de la table `favoritegame`
--

CREATE TABLE `favoritegame` (
  `id` int(11) NOT NULL,
  `idGame` int(11) NOT NULL,
  `idUser` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `favoritegame`
--

INSERT INTO `favoritegame` (`id`, `idGame`, `idUser`) VALUES
(20, 5, 8),
(44, 6, 8),
(45, 4, 8),
(47, 2, 9),
(48, 15, 9),
(49, 3, 8),
(50, 2, 8),
(51, 1, 8),
(52, 18, 8);

-- --------------------------------------------------------

--
-- Structure de la table `file`
--

CREATE TABLE `file` (
  `id` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `dateUpdate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `file`
--

INSERT INTO `file` (`id`, `filename`, `dateUpdate`) VALUES
(2, 'THE_LEGEND_OF_ZELDA_THE_WIND_WAKER.iso', '2021-04-20'),
(3, 'THE_LEGEND_OF_ZELDA_TWILIGHT_PRINCESS.iso', '2021-04-21'),
(4, 'SUPER_MARIO_SUNSHINE.iso', '2021-04-21'),
(5, 'KINGDOM_HEARTS_II_FMX.iso', '2021-04-21'),
(6, 'KINGDOM_HEARTS_FINAL_MIX.iso', '2021-04-21'),
(7, 'SUPER_SMASH_BROS_MELEE.iso', '2021-04-21'),
(18, 'DRAGON_BALL_Z_B_T_3.iso', '2021-04-26'),
(19, 'SUPER_MARIO_STRIKERS.iso', '2021-04-27'),
(21, 'METROID_PRIME.iso', '2021-04-28');

-- --------------------------------------------------------

--
-- Structure de la table `filesave`
--

CREATE TABLE `filesave` (
  `id` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `idGame` int(11) NOT NULL,
  `idFile` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `game`
--

CREATE TABLE `game` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `imageName` varchar(255) NOT NULL,
  `idConsole` int(11) NOT NULL,
  `idFile` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `game`
--

INSERT INTO `game` (`id`, `name`, `description`, `imageName`, `idConsole`, `idFile`) VALUES
(1, 'The Legend of Zelda: The Wind Waker', 'The Legend of Zelda: The Wind Waker est un jeu d&#39;action-aventure développé par la division Nintendo EAD et publié par Nintendo sur GameCube le 13 décembre 2002 au Japon, puis en mars 2003 en Amérique du Nord et en mai 2003 en Europe. C&#39;est le dixième jeu de la franchise The Legend of Zelda.', 'THE_LEGEND_OF_ZELDA_THE_WIND_WAKER.jpg', 1, 2),
(2, 'The Legend of Zelda: Twilight Princess', 'The Legend of Zelda: Twilight Princess est un jeu vidéo d\'action-aventure développé par Nintendo EAD et édité par Nintendo, sorti sur GameCube et Wii en 2006. Il s\'agit du treizième opus de la série The Legend of Zelda.', 'THE_LEGEND_OF_ZELDA_TWILIGHT_PRINCESS.png', 1, 3),
(3, 'Super Mario Sunshine\r\n', 'Super Mario Sunshine est un jeu vidéo de plates-formes développé par Nintendo EAD pour l\'éditeur japonais Nintendo. Il sort sur la console de jeu GameCube au Japon le 19 juillet 2002, puis aux États-Unis le 26 août 2002 et enfin en Europe le 4 octobre 2002.', 'SUPER_MARIO_SUNSHINE.png', 1, 4),
(4, 'Kingdom Hearts 2 Final Mix', 'Kingdom Hearts II est un jeu vidéo d\'action-RPG développé par Square Enix et distribué par Buena Vista Games et Square Enix, en 2005 pour la PlayStation 2, console de jeux vidéo de Sony.', 'KINGDOM_HEARTS_IIFMX.png', 2, 5),
(5, 'Kingdom Hearts Final Mix', 'Kingdom Hearts est une série de jeux vidéo d\'action-RPG développée et éditée par Square Enix, qui marque l\'association entre Disney Interactive Studios et l\'univers des jeux de Square sous la direction de Tetsuya Nomura. Kingdom Hearts est donc un crossover entre univers Square Enix et l\'univers Disney qui a lieu dans un monde parallèle créé spécialement pour la série. Dans chacun des opus, les voix des personnages de Disney sont interprétées par les mêmes célébrités que dans leur œuvre d\'origine.', 'KINGDOM_HEARTS_FINAL_MIx.png', 2, 6),
(6, 'Super Smash Bros. Melee', 'Super Smash Bros. Melee is the second installment in the Super Smash Bros. series and the follow-up to the Nintendo 64 title. It includes all playable characters from the first game, and also adds characters from franchises such as Fire Emblem, of which no games had been released outside Japan at the time. Super Smash Bros. Melee builds on the first game by adding new gameplay features and playable characters: it\'s major focus is the multiplayer mode, while still offering a number of single-player modes.', 'SUPER_SMASH_BROS_MELEE.png', 1, 7),
(15, 'Dragon Ball Z: Budokai Tenkaichi 3', 'Dragon Ball Z: Budokai Tenkaichi is a series of fighting games based on the anime and manga Dragon Ball by Akira Toriyama. Each installment was developed by Spike for the PlayStation 2, while they were published by Namco Bandai Games under the Bandai brand name in Japan and Europe and Atari in North America and Australia from 2005 to 2007. The second and third installments were also released for the Nintendo Wii. Atari&#39;s PAL distribution network was absorbed into Bandai Namco Partners and Bandai Namco has also handled publishing in North America for future Dragon Ball Z games since 2010, effectively ending Atari&#39;s involvement.[1] The trilogy was followed by Dragon Ball Z: Tenkaichi Tag Team, released in 2010 for the PlayStation Portable.', 'DRAGON_BALL_Z_B_T_3.png', 2, 18),
(16, 'Super Mario Strikers', 'Mario Smash Football est un jeu vidéo de football arcade développé par Next Level Games et édité par Nintendo sur GameCube. Il est sorti en Europe et en Amérique du Nord fin 2005 et au Japon et en Australie en 2006.', 'SUPER_MARIO_STRIKERS.jpg', 3, 19),
(18, 'Metroid Prime', 'Metroid Prime est un jeu vidéo d&#39;action-aventure en vue à la première personne de la série Metroid, développé par Retro Studios en collaboration avec Nintendo et édité par ce dernier sur GameCube en novembre 2002 en Amérique du Nord, en février 2003 au Japon, puis en mars 2003 en Europe.', 'METROID_PRIME.png', 1, 21);

-- --------------------------------------------------------

--
-- Structure de la table `gamehascategorie`
--

CREATE TABLE `gamehascategorie` (
  `id` int(11) NOT NULL,
  `idGame` int(11) NOT NULL,
  `idCategorie` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `gamehascategorie`
--

INSERT INTO `gamehascategorie` (`id`, `idGame`, `idCategorie`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 2),
(4, 4, 3),
(5, 5, 3),
(6, 6, 2),
(7, 6, 5),
(8, 6, 4),
(29, 2, 6),
(30, 15, 4),
(31, 15, 8),
(32, 5, 6),
(33, 16, 2),
(34, 16, 7);

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `role`
--

INSERT INTO `role` (`id`, `name`) VALUES
(1, 'administrator'),
(3, 'user');

-- --------------------------------------------------------

--
-- Structure de la table `timeingame`
--

CREATE TABLE `timeingame` (
  `id` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `idGame` int(11) NOT NULL,
  `timeInMinute` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `timeingame`
--

INSERT INTO `timeingame` (`id`, `idUser`, `idGame`, `timeInMinute`) VALUES
(1, 8, 4, 1532),
(2, 8, 6, 2000),
(3, 9, 15, 500);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `privateAccount` tinyint(1) NOT NULL DEFAULT '0',
  `idRole` int(11) NOT NULL DEFAULT '3'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `email`, `privateAccount`, `idRole`) VALUES
(1, 'lorenzo', 'Super2016', 'lorenzo@bdcc.ch', 1, 1),
(4, 'test2', 'Super', 'test2@test2.test', 0, 3),
(5, 'antoine', '$2y$10$RE9XFXe8Gu/pglsnSc4/5uP9R0XDA0w7QWms1ZUxiohybbMhYv8sS', 'antoine@eduge.ch', 0, 3),
(6, 'test3', '$2y$10$Eov2ioucKZSe97q/0Gkco.1i0eN1Jw9PixyWAJK63AsXUZqxWsgPq', 'test2@test3.test', 0, 3),
(8, 'lorenzo1227', '$2y$10$A4jZ2hPhxnadWFmPkUnI1..I7cpMQFj9bTjhGbLIGaV33xKeaHkIO', 'united4player@gmail.com', 0, 1),
(9, 'aurelio1227', '$2y$10$snt0hwL6wFp1gUNzSlLxPO/mksgbCnXaZB7mgXGj2Y9kp.4B0kkDO', 'aurelio1227@gmail.com', 0, 3),
(10, 'lorenzo12277', '$2y$10$ici/H5K1cqVG.sMkxH0yguGd1inB9SVxEX8IcrdvSqFASsL/Y8OFO', 'lorenzo12277@gmail.com', 1, 3);

-- --------------------------------------------------------

--
-- Structure de la table `userconfigfile`
--

CREATE TABLE `userconfigfile` (
  `id` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `idFile` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`name`);

--
-- Index pour la table `consol`
--
ALTER TABLE `consol`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idEmulator` (`idEmulator`);

--
-- Index pour la table `emulator`
--
ALTER TABLE `emulator`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `favoritegame`
--
ALTER TABLE `favoritegame`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idGame` (`idGame`),
  ADD KEY `idUser` (`idUser`);

--
-- Index pour la table `file`
--
ALTER TABLE `file`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `filesave`
--
ALTER TABLE `filesave`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idUser` (`idUser`),
  ADD KEY `idGame` (`idGame`),
  ADD KEY `idFile` (`idFile`);

--
-- Index pour la table `game`
--
ALTER TABLE `game`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idConsole` (`idConsole`),
  ADD KEY `idFile` (`idFile`);

--
-- Index pour la table `gamehascategorie`
--
ALTER TABLE `gamehascategorie`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idGame` (`idGame`),
  ADD KEY `idCategorie` (`idCategorie`) USING BTREE;

--
-- Index pour la table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `timeingame`
--
ALTER TABLE `timeingame`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idUser` (`idUser`),
  ADD KEY `idGame` (`idGame`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idRole` (`idRole`);

--
-- Index pour la table `userconfigfile`
--
ALTER TABLE `userconfigfile`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idUser` (`idUser`),
  ADD KEY `idFile` (`idFile`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `consol`
--
ALTER TABLE `consol`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `emulator`
--
ALTER TABLE `emulator`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `favoritegame`
--
ALTER TABLE `favoritegame`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT pour la table `file`
--
ALTER TABLE `file`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT pour la table `filesave`
--
ALTER TABLE `filesave`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `game`
--
ALTER TABLE `game`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT pour la table `gamehascategorie`
--
ALTER TABLE `gamehascategorie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT pour la table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `timeingame`
--
ALTER TABLE `timeingame`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `userconfigfile`
--
ALTER TABLE `userconfigfile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `consol`
--
ALTER TABLE `consol`
  ADD CONSTRAINT `consol_ibfk_1` FOREIGN KEY (`idEmulator`) REFERENCES `emulator` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `favoritegame`
--
ALTER TABLE `favoritegame`
  ADD CONSTRAINT `favoritegame_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `favoritegame_ibfk_2` FOREIGN KEY (`idGame`) REFERENCES `game` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `filesave`
--
ALTER TABLE `filesave`
  ADD CONSTRAINT `filesave_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `filesave_ibfk_2` FOREIGN KEY (`idGame`) REFERENCES `game` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `game`
--
ALTER TABLE `game`
  ADD CONSTRAINT `game_ibfk_1` FOREIGN KEY (`idConsole`) REFERENCES `consol` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `game_ibfk_3` FOREIGN KEY (`idFile`) REFERENCES `file` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `gamehascategorie`
--
ALTER TABLE `gamehascategorie`
  ADD CONSTRAINT `gamehascategorie_ibfk_1` FOREIGN KEY (`idCategorie`) REFERENCES `categorie` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `gamehascategorie_ibfk_2` FOREIGN KEY (`idGame`) REFERENCES `game` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `timeingame`
--
ALTER TABLE `timeingame`
  ADD CONSTRAINT `timeingame_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `timeingame_ibfk_2` FOREIGN KEY (`idGame`) REFERENCES `game` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `userconfigfile`
--
ALTER TABLE `userconfigfile`
  ADD CONSTRAINT `userconfigfile_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `userconfigfile_ibfk_2` FOREIGN KEY (`idFile`) REFERENCES `file` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

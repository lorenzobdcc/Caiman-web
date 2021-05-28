-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : jeu. 27 mai 2021 à 12:53
-- Version du serveur :  10.3.27-MariaDB-0+deb10u1
-- Version de PHP : 7.4.18

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
(11, 'Dragon Quest'),
(4, 'Fight'),
(10, 'God of War'),
(3, 'Kingdom Hearts'),
(2, 'Mario'),
(9, 'Metroid'),
(5, 'Multiplayer'),
(6, 'RPG'),
(7, 'Sport'),
(13, 'Star Fox'),
(12, 'Tekken'),
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
(45, 4, 8),
(47, 2, 9),
(48, 15, 9),
(50, 2, 8),
(57, 6, 8),
(58, 1, 8),
(59, 3, 8),
(62, 6, 16),
(63, 2, 16),
(64, 4, 16),
(65, 5, 16),
(71, 18, 8),
(72, 22, 8);

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
(19, 'MARIO_SMASH_FOOTBALL.iso', '2021-04-27'),
(21, 'METROID_PRIME.iso', '2021-04-28'),
(22, 'PAPER_MARIO_T_D.iso', '2021-05-27'),
(23, 'MARIO_KART_DOUBLE_DASH.iso', '2021-05-27'),
(24, 'GOD_OF_WAR.iso', '2021-05-27'),
(25, 'DRAGON_QUEST_VIII.iso', '2021-05-27'),
(26, 'TEKKEN_5.iso', '2021-05-27'),
(27, 'METROID_PRIME_2.iso', '2021-05-27'),
(28, 'STAR_FOX_ADVENTURES.iso', '2021-05-27');

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
  `description` mediumtext NOT NULL,
  `imageName` varchar(255) NOT NULL,
  `idConsole` int(11) NOT NULL,
  `idFile` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `game`
--

INSERT INTO `game` (`id`, `name`, `description`, `imageName`, `idConsole`, `idFile`) VALUES
(1, 'The Legend of Zelda: The Wind Waker', 'The Legend of Zelda: The Wind Waker est un jeu d\'action-aventure développé par la division Nintendo EAD et publié par Nintendo sur GameCube le 13 décembre 2002 au Japon, puis en mars 2003 en Amérique du Nord et en mai 2003 en Europe. C\'est le dixième jeu de la franchise The Legend of Zelda.', 'THE_LEGEND_OF_ZELDA_THE_WIND_WAKER.jpg', 1, 2),
(2, 'The Legend of Zelda: Twilight Princess', 'The Legend of Zelda: Twilight Princess est un jeu vidéo d\'action-aventure développé par Nintendo EAD et édité par Nintendo, sorti sur GameCube et Wii en 2006. Il s\'agit du treizième opus de la série The Legend of Zelda.', 'THE_LEGEND_OF_ZELDA_TWILIGHT_PRINCESS.png', 1, 3),
(3, 'Super Mario Sunshine', 'Super Mario Sunshine est un jeu vidéo de plates-formes développé par Nintendo EAD pour l\'éditeur japonais Nintendo. Il sort sur la console de jeu GameCube au Japon le 19 juillet 2002, puis aux États-Unis le 26 août 2002 et enfin en Europe le 4 octobre 2002.', 'SUPER_MARIO_SUNSHINE.png', 1, 4),
(4, 'Kingdom Hearts 2 Final Mix', 'Kingdom Hearts II est un jeu vidéo d\'action-RPG développé par Square Enix et distribué par Buena Vista Games et Square Enix, en 2005 pour la PlayStation 2, console de jeux vidéo de Sony.', 'KINGDOM_HEARTS_IIFMX.png', 2, 5),
(5, 'Kingdom Hearts Final Mix', 'Kingdom Hearts est une série de jeux vidéo d\'action-RPG développée et éditée par Square Enix, qui marque l\'association entre Disney Interactive Studios et l\'univers des jeux de Square sous la direction de Tetsuya Nomura. Kingdom Hearts est donc un crossover entre univers Square Enix et l\'univers Disney qui a lieu dans un monde parallèle créé spécialement pour la série. Dans chacun des opus, les voix des personnages de Disney sont interprétées par les mêmes célébrités que dans leur œuvre d\'origine.', 'KINGDOM_HEARTS_FINAL_MIX.png', 2, 6),
(6, 'Super Smash Bros. Melee', 'Super Smash Bros. Melee is the second installment in the Super Smash Bros. series and the follow-up to the Nintendo 64 title. It includes all playable characters from the first game, and also adds characters from franchises such as Fire Emblem, of which no games had been released outside Japan at the time. Super Smash Bros. Melee builds on the first game by adding new gameplay features and playable characters: it\'s major focus is the multiplayer mode, while still offering a number of single-player modes.', 'SUPER_SMASH_BROS_MELEE.png', 1, 7),
(15, 'Dragon Ball Z: Budokai Tenkaichi 3', 'Dragon Ball Z: Budokai Tenkaichi is a series of fighting games based on the anime and manga Dragon Ball by Akira Toriyama. Each installment was developed by Spike for the PlayStation 2, while they were published by Namco Bandai Games under the Bandai brand name in Japan and Europe and Atari in North America and Australia from 2005 to 2007. The second and third installments were also released for the Nintendo Wii. Atari\'s PAL distribution network was absorbed into Bandai Namco Partners and Bandai Namco has also handled publishing in North America for future Dragon Ball Z games since 2010, effectively ending Atari\'s involvement.[1] The trilogy was followed by Dragon Ball Z: Tenkaichi Tag Team, released in 2010 for the PlayStation Portable.', 'DRAGON_BALL_Z_B_T_3.png', 2, 18),
(16, 'Super Mario Strikers', 'Mario Smash Football est un jeu vidéo de football arcade développé par Next Level Games et édité par Nintendo sur GameCube. Il est sorti en Europe et en Amérique du Nord fin 2005 et au Japon et en Australie en 2006.', 'SUPER_MARIO_STRIKERS.jpg', 1, 19),
(18, 'Metroid Prime', 'Metroid Prime est un jeu vidéo d\'action-aventure en vue à la première personne de la série Metroid, développé par Retro Studios en collaboration avec Nintendo et édité par ce dernier sur GameCube en novembre 2002 en Amérique du Nord, en février 2003 au Japon, puis en mars 2003 en Europe.', 'METROID_PRIME.png', 1, 21),
(19, 'Paper Mario: The Thousand-Year Door', 'Paper Mario : La Porte millénaire est un jeu vidéo sorti sur GameCube en 2004. Il donne suite à Paper Mario, sorti sur Nintendo 64. L&#39;originalité de ces deux jeux est que les personnages sont réalisés en 2D, alors que le décor est en 3D.', 'PAPER_MARIO_T_D.png', 1, 22),
(20, 'Mario Kart: Double Dash!!', 'Mario Kart: Double Dash!! est un jeu vidéo de course édité par Nintendo et développé par Nintendo Entertainment Analysis and Development. Il est sorti sur GameCube en 2003.', 'MARIO_KART_DOUBLE_DASH.png', 1, 23),
(21, 'God of War', 'God of War est une série de jeux vidéo d\'action-aventure de type beat them all débutée en 2005, produite par Sony Computer Entertainment. ', 'GOD_OF_WAR.png', 2, 24),
(22, 'Dragon Quest VIII', 'Dragon Quest : L\'Odyssée du roi maudit est un jeu vidéo de rôle de Square Enix développé par Level-5 sur PlayStation 2, publié en 2004 au Japon, en 2005 en Amérique du Nord et en 2006 en Europe. C\'est le premier épisode intégralement en 3D de la série Dragon Quest.', 'DRAGON_QUEST_VIII.png', 2, 25),
(23, 'TekKen 5', 'Tekken 5 est un jeu vidéo de combat développé et édité par Namco commercialisé en 2004 sur borne d&#39;arcade, puis adapté l&#39;année suivante sur console PlayStation 2. Il s&#39;agit du sixième jeu de la série homonyme à être commercialisé, et celui marquant son dixième anniversaire depuis la sortie du premier opus.', 'TEKKEN_5.png', 2, 26),
(24, 'Metroid Prime 2: Echoes', 'Metroid Prime 2: Echoes, aussi connu sous le nom de Metroid Prime 2: Dark Echoes au Japon, est un jeu vidéo d\'action-aventure en vue à la première personne, développé par Retro Studios et édité par Nintendo, sorti sur GameCube en Amérique du Nord, en Europe et en Australie en 2004, puis au Japon l\'année suivante.', 'METROID_PRIME_2.png', 1, 27),
(25, 'Star Fox Adventures', 'Star Fox Adventures est un jeu vidéo d&#39;action-aventure développé par Rare puis édité par Nintendo en 2002 pour la GameCube. Le jeu est le troisième épisode de la série Star Fox et le premier à utiliser la licence sous forme de jeu d&#39;aventure à la troisième personne.', 'STAR_FOX_ADVENTURES.jpg', 1, 28);

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
(34, 16, 7),
(35, 18, 9),
(36, 19, 2),
(37, 19, 6),
(38, 21, 10),
(39, 22, 11),
(40, 23, 12),
(41, 23, 4),
(42, 22, 6),
(43, 20, 2),
(44, 20, 5),
(45, 20, 7),
(46, 24, 9),
(47, 25, 13);

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
(1, 8, 4, 12),
(2, 8, 6, 72),
(3, 9, 15, 30),
(4, 8, 2, 2),
(6, 8, 1, 23),
(8, 8, 18, 20),
(14, 17, 15, 1),
(17, 16, 5, 1),
(18, 8, 20, 7),
(25, 8, 21, 4),
(29, 8, 22, 48),
(110, 8, 19, 1);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `salt` varchar(255) NOT NULL,
  `apitocken` text NOT NULL,
  `caimanToken` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `privateAccount` tinyint(1) NOT NULL DEFAULT 0,
  `idRole` int(11) NOT NULL DEFAULT 3
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `salt`, `apitocken`, `caimanToken`, `email`, `privateAccount`, `idRole`) VALUES
(1, 'lorenzo', 'Super2016', '', '', '', 'lorenzo@bdcc.ch', 1, 1),
(4, 'test2', 'Super', '', '', '', 'test2@test2.test', 0, 3),
(5, 'antoine', '$2y$10$RE9XFXe8Gu/pglsnSc4/5uP9R0XDA0w7QWms1ZUxiohybbMhYv8sS', '', '', '', 'antoine@eduge.ch', 0, 3),
(6, 'test3', '$2y$10$Eov2ioucKZSe97q/0Gkco.1i0eN1Jw9PixyWAJK63AsXUZqxWsgPq', '', '', '', 'test2@test3.test', 0, 3),
(8, 'lorenzo1227', 'e0876520208e54c3a1a632537bc5e1d6', '3889', 'b4bd46813896a0c97aeaa2a0795e8ef6', 'a10ef0c5e5fcff5b5551c4a3b918c110', 'united4player@gmail.com', 0, 1),
(9, 'aurelio1227', '$2y$10$snt0hwL6wFp1gUNzSlLxPO/mksgbCnXaZB7mgXGj2Y9kp.4B0kkDO', '', '', '', 'aurelio1227@gmail.com', 0, 3),
(10, 'lorenzo12277', '$2y$10$ici/H5K1cqVG.sMkxH0yguGd1inB9SVxEX8IcrdvSqFASsL/Y8OFO', '', '', '', 'lorenzo12277@gmail.com', 1, 3),
(16, 'Akiruu', 'db344b8c860bb7c6346c9c949da1070e', '4599', 'fc958d9f50e816d892db886535f1ae38', '8f36cd44d185477719560ede07a16272', 'gawen.ackrm@eduge.ch', 0, 3),
(17, 'Kratos', '405ba1bb37935f881776c7b7b097b355', '7082', '0e12e369ffab930d6f1a32b0b7681637', '8ec4fa543c3d7e1b428bafb071871802', 'aureliorosario15@gmail.com', 0, 3),
(18, 'antoine.schmid', 'e7faa67163b46356f707476642706dae', '2151', '5257e987adc26610c44dc2217df4ee55', '', 'antoine.schmid@edu.ge.ch', 0, 3),
(19, '', 'f47d0ad31c4c49061b9e505593e3db98', '904', 'cbd1a3b274737f02a2db373c91e36776', '', '', 0, 3),
(20, 'lili', '335033bc0dafac4a053695bc2a313fce', '113', 'b9aa84b525136f9e35b1f761cfec2513', '', 'mayaracochard71@liliuloill.com', 0, 3),
(21, 'mayara', '68c0b117cb970b079f01de906f600821', '4085', 'c0c383b9f95b1b2f75006e50ac6e243d', '', 'jeveuxpas@gmail.com', 0, 3);

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
  ADD UNIQUE KEY `unique_index` (`idGame`,`idUser`),
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT pour la table `file`
--
ALTER TABLE `file`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT pour la table `filesave`
--
ALTER TABLE `filesave`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `game`
--
ALTER TABLE `game`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT pour la table `gamehascategorie`
--
ALTER TABLE `gamehascategorie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT pour la table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `timeingame`
--
ALTER TABLE `timeingame`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

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
  ADD CONSTRAINT `filesave_ibfk_2` FOREIGN KEY (`idGame`) REFERENCES `game` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `filesave_ibfk_3` FOREIGN KEY (`idFile`) REFERENCES `file` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

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
-- Contraintes pour la table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`idRole`) REFERENCES `role` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

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

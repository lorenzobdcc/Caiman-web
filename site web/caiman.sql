-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : lun. 19 avr. 2021 à 13:51
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
-- Structure de la table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `consol`
--

CREATE TABLE `consol` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `idEmulator` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `emulator`
--

CREATE TABLE `emulator` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `favoritegame`
--

CREATE TABLE `favoritegame` (
  `id` int(11) NOT NULL,
  `idGame` int(11) NOT NULL,
  `idUser` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `file`
--

CREATE TABLE `file` (
  `id` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `dateUpdate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `idConsole` int(11) NOT NULL,
  `idFile` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `gamehascategory`
--

CREATE TABLE `gamehascategory` (
  `id` int(11) NOT NULL,
  `idGame` int(11) NOT NULL,
  `idCategory` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `idRole` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
-- Index pour la table `category`
--
ALTER TABLE `category`
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
-- Index pour la table `gamehascategory`
--
ALTER TABLE `gamehascategory`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idGame` (`idGame`),
  ADD KEY `idCategory` (`idCategory`);

--
-- Index pour la table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT pour la table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `consol`
--
ALTER TABLE `consol`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `emulator`
--
ALTER TABLE `emulator`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `favoritegame`
--
ALTER TABLE `favoritegame`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `file`
--
ALTER TABLE `file`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `filesave`
--
ALTER TABLE `filesave`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `game`
--
ALTER TABLE `game`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `gamehascategory`
--
ALTER TABLE `gamehascategory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
-- Contraintes pour la table `file`
--
ALTER TABLE `file`
  ADD CONSTRAINT `file_ibfk_2` FOREIGN KEY (`id`) REFERENCES `filesave` (`idFile`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `filesave`
--
ALTER TABLE `filesave`
  ADD CONSTRAINT `filesave_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `game`
--
ALTER TABLE `game`
  ADD CONSTRAINT `game_ibfk_1` FOREIGN KEY (`idConsole`) REFERENCES `consol` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `game_ibfk_2` FOREIGN KEY (`id`) REFERENCES `filesave` (`idGame`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `gamehascategory`
--
ALTER TABLE `gamehascategory`
  ADD CONSTRAINT `gamehascategory_ibfk_1` FOREIGN KEY (`idCategory`) REFERENCES `category` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `gamehascategory_ibfk_2` FOREIGN KEY (`idGame`) REFERENCES `game` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `role`
--
ALTER TABLE `role`
  ADD CONSTRAINT `role_ibfk_1` FOREIGN KEY (`id`) REFERENCES `user` (`idRole`) ON DELETE NO ACTION ON UPDATE NO ACTION;

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

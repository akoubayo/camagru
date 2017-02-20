SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE DATABASE IF NOT EXISTS `camagrus` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `camagrus`;

CREATE TABLE IF NOT EXISTS `commentaires` (
  `id_commentaires` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `commentaires` text NOT NULL,
  `users_id` int(11) NOT NULL,
  `pictures_id` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `pictures` (
  `id_pictures` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `src` varchar(255) NOT NULL,
  `vote` int(11) NOT NULL,
  `del` tinyint(1) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `users_id` int(11) NOT NULL,
  `type` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `users` (
  `id_users` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `pseudo` varchar(55) NOT NULL,
  `password` varchar(255) NOT NULL,
  `mail` varchar(55) NOT NULL,
  `valide` tinyint(1) NOT NULL,
  `token` varchar(255) NOT NULL,
  `expire` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

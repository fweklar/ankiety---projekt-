CREATE DATABASE IF NOT EXISTS `phppoll` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `phppoll`;

CREATE TABLE IF NOT EXISTS `polls` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`title` text NOT NULL,
	`desc` text NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `poll_answers` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`poll_id` int(11) NOT NULL,
	`title` text NOT NULL,
	`votes` int(11) NOT NULL DEFAULT '0',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `user_answers` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `username` varchar(100) NOT NULL,
  `poll_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `hashes` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`userhash` text NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;






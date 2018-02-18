SET NAMES utf8;

DROP DATABASE `realworld`;

CREATE DATABASE `realworld`;

USE `realworld`;

CREATE TABLE `users` (
  `id` INT unsigned NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL DEFAULT "",
  `email` VARCHAR(255) NOT NULL  DEFAULT "",
  `password` VARCHAR(32) NOT NULL  DEFAULT "",
  `bio` TINYTEXT NOT NULL DEFAULT "",
  `image` VARCHAR(255) NOT NULL DEFAULT "",
   PRIMARY KEY (`id`),
   KEY `email` (`email`)
);

INSERT INTO `users` (`name`, `email`, `password`) VALUES ("Test", "test@example.org", "202cb962ac59075b964b07152d234b70");

CREATE TABLE `followings` (
  `followerUserId` INT unsigned NOT NULL,
  `followedUserId` INT unsigned NOT NULL,
  PRIMARY KEY (`followerUserId`, `followedUserId`)
);
DROP DATABASE IF EXISTS `eduhacks`;
CREATE DATABASE IF NOT EXISTS `eduhacks`;
USE `eduhacks`;

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users`(
    `idUser` INT AUTO_INCREMENT NOT NULL,
    `mail` VARCHAR(40) UNIQUE NOT NULL,
    `username` VARCHAR(16) UNIQUE NOT NULL,
    `passHash` VARCHAR(60) NOT NULL,
    `userFirstName` VARCHAR(60) NOT NULL,
    `userLastName` VARCHAR(120) NOT NULL,
    `creationDate` DATETIME NULL,
    `activationDate` DATETIME NULL,
    `activationCode` VARCHAR(64) NULL,
    `resetPassExpiry` DATETIME NULL,
    `resetPassCode` VARCHAR(64) NULL,
    `removeDate` DATETIME NULL,
    `lastSignIn` DATETIME NULL,
    `active` TINYINT(1) NOT NULL,
    PRIMARY KEY(`idUser`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

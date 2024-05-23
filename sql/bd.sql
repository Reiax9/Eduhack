DROP DATABASE IF EXISTS `eduhacks`;
CREATE DATABASE IF NOT EXISTS `eduhacks`;
USE `eduhacks`;

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users`(
    `idUsers` INT AUTO_INCREMENT NOT NULL,
    `mail` VARCHAR(40) UNIQUE NOT NULL,
    `username` VARCHAR(16) UNIQUE NOT NULL,
    `passHash` VARCHAR(60) NOT NULL,
    `userScore` INT NOT NULL,
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
    PRIMARY KEY(`idUsers`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `challenge_CTF`;
CREATE TABLE IF NOT EXISTS `challenge_CTF`(
  `idChallenge` INT AUTO_INCREMENT NOT NULL,
  `title` VARCHAR(32) NOT NULL,
  `description` VARCHAR(128) NOT NULL,
  `score` INT NOT NULL,
  `flagValue` VARCHAR(265) NOT NULL,
  `publicationDate` DATE NOT NULL,
  `file` VARCHAR(265),
  `category` ENUM('Steganography','Cryptography','Web Security') NOT NULL,
  `idUsers` INT NOT NULL,
  PRIMARY KEY (`idChallenge`),
  FOREIGN KEY (`idUsers`) REFERENCES users(`idUsers`)
    ON UPDATE CASCADE
    ON DELETE CASCADE
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `users_challenge`;
CREATE TABLE IF NOT EXISTS `users_challenge`(
  `idUsers` INT NOT NULL,
  `idChallenge` INT NOT NULL,
  PRIMARY KEY (`idUsers`, `idChallenge`),
  FOREIGN KEY (`idUsers`) REFERENCES users(`idUsers`)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  FOREIGN KEY (`idChallenge`) REFERENCES challenge_CTF(`idChallenge`)
    ON UPDATE CASCADE
    ON DELETE CASCADE
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `user_challenge_status`;
CREATE TABLE IF NOT EXISTS `user_challenge_status` (
  `idUsers` INT NOT NULL,
  `idChallenge` INT NOT NULL,
  `solved` TINYINT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`idUsers`, `idChallenge`),
  FOREIGN KEY (`idUsers`) REFERENCES `users`(`idUsers`)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  FOREIGN KEY (`idChallenge`) REFERENCES `challenge_CTF`(`idChallenge`)
    ON UPDATE CASCADE
    ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
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

DROP TABLE IF EXISTS `challenges_CTF`;
CREATE TABLE IF NOT EXISTS `challenges_CTF` (
    id_repte INT AUTO_INCREMENT PRIMARY KEY,
    id_usuari INT,
    titol VARCHAR(100),
    text_descriptiu TEXT,
    puntuacio INT,
    valor_flag VARCHAR(100),
    data_publicacio DATE,
    FOREIGN KEY (id_usuari) REFERENCES USUARI(id_usuari)
);


DROP TABLE IF EXISTS `validation`;
CREATE TABLE IF NOT EXISTS `validation` (
    id_validacio INT AUTO_INCREMENT PRIMARY KEY,
    id_usuari INT,
    id_repte INT,
    data_validacio DATETIME,
    FOREIGN KEY (id_usuari) REFERENCES USUARI(id_usuari),
    FOREIGN KEY (id_repte) REFERENCES REPTES_CTF(id_repte)
);

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
    id_categoria INT AUTO_INCREMENT PRIMARY KEY,
    nom_categoria VARCHAR(50)
);

CREATE TABLE REPTES_CTF_CATEGORIES (
    id_repte INT,
    id_categoria INT,
    PRIMARY KEY (id_repte, id_categoria),
    FOREIGN KEY (id_repte) REFERENCES REPTES_CTF(id_repte),
    FOREIGN KEY (id_categoria) REFERENCES CATEGORIES(id_categoria)
);
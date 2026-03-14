SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `apikey`;
DROP TABLE IF EXISTS `photo`;
DROP TABLE IF EXISTS `annonce`;
DROP TABLE IF EXISTS `annonceur`;
DROP TABLE IF EXISTS `sous_categorie`;
DROP TABLE IF EXISTS `categorie`;
DROP TABLE IF EXISTS `departement`;
DROP TABLE IF EXISTS `region`;

SET FOREIGN_KEY_CHECKS = 1;

-- ─── region ──────────────────────────────────────────────────────────────────
CREATE TABLE `region`
(
    `id_region`  int(11) NOT NULL AUTO_INCREMENT,
    `nom_region` varchar(255) DEFAULT NULL,
    PRIMARY KEY (`id_region`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

-- ─── departement ─────────────────────────────────────────────────────────────
CREATE TABLE `departement`
(
    `id_departement`  int(11) NOT NULL AUTO_INCREMENT,
    `id_region`       int(11)      DEFAULT NULL,
    `nom_departement` varchar(255) DEFAULT NULL,
    PRIMARY KEY (`id_departement`),
    CONSTRAINT `fk_departement_region`
        FOREIGN KEY (`id_region`) REFERENCES `region` (`id_region`)
            ON DELETE SET NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

-- ─── categorie ───────────────────────────────────────────────────────────────
CREATE TABLE `categorie`
(
    `id_categorie`  int(11) NOT NULL AUTO_INCREMENT,
    `nom_categorie` varchar(255) DEFAULT NULL,
    PRIMARY KEY (`id_categorie`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

-- ─── sous_categorie ──────────────────────────────────────────────────────────
CREATE TABLE `sous_categorie`
(
    `id_sous_categorie`  int(11) NOT NULL AUTO_INCREMENT,
    `id_categorie`       int(11)      DEFAULT NULL,
    `nom_sous_categorie` varchar(255) DEFAULT NULL,
    PRIMARY KEY (`id_sous_categorie`),
    CONSTRAINT `fk_sous_categorie_categorie`
        FOREIGN KEY (`id_categorie`) REFERENCES `categorie` (`id_categorie`)
            ON DELETE CASCADE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

-- ─── annonceur ───────────────────────────────────────────────────────────────
CREATE TABLE `annonceur`
(
    `id_annonceur`  int(11) NOT NULL AUTO_INCREMENT,
    `email`         varchar(255) DEFAULT NULL,
    `nom_annonceur` varchar(255) DEFAULT NULL,
    `telephone`     varchar(20)  DEFAULT NULL,
    PRIMARY KEY (`id_annonceur`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

-- ─── annonce ─────────────────────────────────────────────────────────────────
CREATE TABLE `annonce`
(
    `id_annonce`        int(11) NOT NULL AUTO_INCREMENT,
    `id_categorie`      int(11)      DEFAULT NULL,
    `id_sous_categorie` int(11)      DEFAULT NULL,
    `id_annonceur`      int(11)      DEFAULT NULL,
    `id_departement`    int(11)      DEFAULT NULL,
    `prix`              float        DEFAULT NULL,
    `date`              date         DEFAULT NULL,
    `titre`             varchar(255) DEFAULT NULL,
    `description`       text,
    `ville`             varchar(255) DEFAULT NULL,
    `mdp`               varchar(255) DEFAULT NULL,
    PRIMARY KEY (`id_annonce`),
    CONSTRAINT `fk_annonce_categorie`
        FOREIGN KEY (`id_categorie`) REFERENCES `categorie` (`id_categorie`)
            ON DELETE SET NULL,
    CONSTRAINT `fk_annonce_annonceur`
        FOREIGN KEY (`id_annonceur`) REFERENCES `annonceur` (`id_annonceur`)
            ON DELETE CASCADE,
    CONSTRAINT `fk_annonce_departement`
        FOREIGN KEY (`id_departement`) REFERENCES `departement` (`id_departement`)
            ON DELETE SET NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

-- ─── photo ───────────────────────────────────────────────────────────────────
CREATE TABLE `photo`
(
    `id_photo`   int(11) NOT NULL AUTO_INCREMENT,
    `id_annonce` int(11)      DEFAULT NULL,
    `url_photo`  varchar(255) DEFAULT NULL,
    PRIMARY KEY (`id_photo`),
    CONSTRAINT `fk_photo_annonce`
        FOREIGN KEY (`id_annonce`) REFERENCES `annonce` (`id_annonce`)
            ON DELETE CASCADE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

-- ─── apikey ──────────────────────────────────────────────────────────────────
CREATE TABLE `apikey`
(
    `id_apikey` varchar(64)  NOT NULL,
    `name_key`  varchar(255) NOT NULL,
    PRIMARY KEY (`id_apikey`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

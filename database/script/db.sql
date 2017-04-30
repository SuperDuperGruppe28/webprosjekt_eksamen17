-- -----------------------------------------------------
-- Schema berseb16_aktivitet
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS berseb16_aktivitet DEFAULT CHARACTER SET utf8;
USE berseb16_aktivitet;

-- -----------------------------------------------------
-- Table berseb16_aktivitet.Bruker
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS berseb16_aktivitet.Bruker (
  Brukernavn VARCHAR(30) NOT NULL,
  Email VARCHAR(70) NOT NULL,
  Passord VARCHAR(60) NOT NULL,
  Admin TINYINT(1) NOT NULL DEFAULT 0,
  Registrert DATETIME NOT NULL,
  Verifisert TINYINT(1) NOT NULL,
  Veifiserthash VARCHAR(45) NOT NULL,
  PRIMARY KEY (Brukernavn));

-- -----------------------------------------------------
-- Table berseb16_aktivitet.Aktivitet
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS berseb16_aktivitet.Aktivitet (
  id int NOT NULL AUTO_INCREMENT,
  Tittel VARCHAR(45) NULL DEFAULT 'Ingen tittel',
  Beskrivelse VARCHAR(45) NULL DEFAULT 'Ingen beskrivelse',
  Apningstider VARCHAR(45) NULL DEFAULT 'Ukjent',
  Pris FLOAT NULL DEFAULT 0,
  Statisk TINYINT(1) NULL DEFAULT 0,
  Bilde VARCHAR(45) NULL,
  Lengdegrad FLOAT NULL,
  Breddegrad FLOAT NULL,
  Bruker VARCHAR(30) NOT NULL,
  PRIMARY KEY (id),
    FOREIGN KEY (Bruker)
    REFERENCES berseb16_aktivitet.Bruker (Brukernavn));

-- -----------------------------------------------------
-- Table berseb16_aktivitet.Tags
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS berseb16_aktivitet.Tags (
  Tag VARCHAR(45) NOT NULL,
  PRIMARY KEY (Tag));

-- -----------------------------------------------------
-- Table berseb16_aktivitet.Stemmer
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS berseb16_aktivitet.Stemmer (
  id int NOT NULL AUTO_INCREMENT,
  Aktivitet int NOT NULL,
  Bruker VARCHAR(30) NOT NULL,
  PRIMARY KEY (id),
    FOREIGN KEY (Aktivitet)
    REFERENCES berseb16_aktivitet.Aktivitet (id),
    FOREIGN KEY (Bruker)
    REFERENCES berseb16_aktivitet.Bruker (Brukernavn));

-- -----------------------------------------------------
-- Table berseb16_aktivitet.Deltagelse
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS berseb16_aktivitet.Deltagelse (
  id int NOT NULL AUTO_INCREMENT,
  Deltagelse int NOT NULL,
  Aktivitet int NOT NULL,
  Bruker VARCHAR(30) NOT NULL,
  PRIMARY KEY (id),
    FOREIGN KEY (Aktivitet)
        REFERENCES berseb16_aktivitet.Aktivitet (id),
    FOREIGN KEY (Bruker)
        REFERENCES berseb16_aktivitet.Bruker (Brukernavn));

-- -----------------------------------------------------
-- Table berseb16_aktivitet.Kommentarfelt
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS berseb16_aktivitet.Kommentarfelt (
  id int NOT NULL AUTO_INCREMENT,
  Aktivitet int NOT NULL,
  PRIMARY KEY (id),
    FOREIGN KEY (Aktivitet)
    REFERENCES berseb16_aktivitet.Aktivitet (id));

-- -----------------------------------------------------
-- Table berseb16_aktivitet.Kommentar
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS berseb16_aktivitet.Kommentar (
  id int NOT NULL AUTO_INCREMENT,
  Tekst VARCHAR(512) NOT NULL,
  Dato DATETIME NULL,
  Kommentarfelt int NOT NULL,
  Bruker VARCHAR(30) NOT NULL,
  PRIMARY KEY (id),
    FOREIGN KEY (Kommentarfelt)
    REFERENCES berseb16_aktivitet.Kommentarfelt (id),
    FOREIGN KEY (Bruker)
    REFERENCES berseb16_aktivitet.Bruker (Brukernavn));

-- -----------------------------------------------------
-- Table berseb16_aktivitet.TagsBruker
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS berseb16_aktivitet.TagsBruker (
  id int NOT NULL AUTO_INCREMENT,
  Besok int NOT NULL DEFAULT 0,
  Score int NULL DEFAULT 0,
  Bruker VARCHAR(30) NOT NULL,
  Tag VARCHAR(45) NOT NULL,
  PRIMARY KEY (id),
    FOREIGN KEY (Bruker)
    REFERENCES berseb16_aktivitet.Bruker (Brukernavn),
    FOREIGN KEY (Tag)
    REFERENCES berseb16_aktivitet.Tags (Tag));

-- -----------------------------------------------------
-- Table berseb16_aktivitet.TagsAktivitet
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS berseb16_aktivitet.TagsAktivitet (
  id int NOT NULL AUTO_INCREMENT,
  Vekt int NULL DEFAULT 0,
  Tag VARCHAR(45) NOT NULL,
  Aktivitet int NOT NULL,
  PRIMARY KEY (id),
    FOREIGN KEY (Tag)
    REFERENCES berseb16_aktivitet.Tags (Tag),
    FOREIGN KEY (Aktivitet)
    REFERENCES berseb16_aktivitet.Aktivitet (id));
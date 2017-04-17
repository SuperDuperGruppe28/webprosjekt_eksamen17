-- -----------------------------------------------------
-- Schema aktivitethjemmet
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS aktivitethjemmet DEFAULT CHARACTER SET utf8;
USE aktivitethjemmet;

-- -----------------------------------------------------
-- Table aktivitethjemmet.Bruker
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS aktivitethjemmet.Bruker (
  Brukernavn VARCHAR(30) NOT NULL,
  Email VARCHAR(70) NOT NULL,
  Passord VARCHAR(45) NOT NULL,
  Admin TINYINT(1) NOT NULL DEFAULT 0,
  Registrert DATETIME NOT NULL,
  Verifisert TINYINT(1) NOT NULL,
  Veifiserthash VARCHAR(45) NOT NULL,
  PRIMARY KEY (Brukernavn));

-- -----------------------------------------------------
-- Table aktivitethjemmet.Aktivitet
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS aktivitethjemmet.Aktivitet (
  id int NOT NULL AUTO_INCREMENT,
  Tittel VARCHAR(45) NULL DEFAULT 'Ingen tittel',
  Beskrivelse VARCHAR(45) NULL DEFAULT 'Ingen beskrivelse',
  Åpningstider VARCHAR(45) NULL DEFAULT 'Ukjent',
  Pris FLOAT NULL DEFAULT 0,
  Statisk TINYINT(1) NULL DEFAULT 0,
  Bilde VARCHAR(45) NULL,
  Lengdegrad FLOAT NULL,
  Breddegrad FLOAT NULL,
  Bruker VARCHAR(30) NOT NULL,
  PRIMARY KEY (id),
    FOREIGN KEY (Bruker)
    REFERENCES aktivitethjemmet.Bruker (Brukernavn));

-- -----------------------------------------------------
-- Table aktivitethjemmet.Tags
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS aktivitethjemmet.Tags (
  Tag VARCHAR(45) NOT NULL,
  PRIMARY KEY (Tag));

-- -----------------------------------------------------
-- Table aktivitethjemmet.Stemmer
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS aktivitethjemmet.Stemmer (
  id int NOT NULL AUTO_INCREMENT,
  Bruker VARCHAR(30) NOT NULL,
  PRIMARY KEY (id),
    FOREIGN KEY (Bruker)
    REFERENCES aktivitethjemmet.Bruker (Brukernavn));

-- -----------------------------------------------------
-- Table aktivitethjemmet.AktivitetStemmer
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS aktivitethjemmet.AktivitetStemmer (
  id int NOT NULL AUTO_INCREMENT,
  Aktivitet int NOT NULL,
  Stemme int NOT NULL,
  PRIMARY KEY (id),
    FOREIGN KEY (Aktivitet)
    REFERENCES aktivitethjemmet.Aktivitet (id),
    FOREIGN KEY (Stemme)
    REFERENCES aktivitethjemmet.Stemmer (id));

-- -----------------------------------------------------
-- Table aktivitethjemmet.Deltagelse
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS aktivitethjemmet.Deltagelse (
  id int NOT NULL AUTO_INCREMENT,
  Deltagelse int NOT NULL,
  Bruker VARCHAR(30) NOT NULL,
  PRIMARY KEY (id),
    FOREIGN KEY (Bruker)
    REFERENCES aktivitethjemmet.Bruker (Brukernavn));

-- -----------------------------------------------------
-- Table aktivitethjemmet.Deltagere
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS aktivitethjemmet.Deltagere (
  id int NOT NULL AUTO_INCREMENT,
  Aktivitet int NOT NULL,
  Deltager int NOT NULL,
  PRIMARY KEY (id),
    FOREIGN KEY (Aktivitet)
    REFERENCES aktivitethjemmet.Aktivitet (id),
    FOREIGN KEY (Deltager)
    REFERENCES aktivitethjemmet.Deltagelse (id));

-- -----------------------------------------------------
-- Table aktivitethjemmet.Kommentar
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS aktivitethjemmet.Kommentar (
  id int NOT NULL AUTO_INCREMENT,
  Tekst VARCHAR(512) NOT NULL,
  Dato DATETIME NULL,
  Bruker VARCHAR(30) NOT NULL,
  PRIMARY KEY (id),
    FOREIGN KEY (Bruker)
    REFERENCES aktivitethjemmet.Bruker (Brukernavn));

-- -----------------------------------------------------
-- Table aktivitethjemmet.Kommentarfelt
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS aktivitethjemmet.Kommentarfelt (
  id int NOT NULL AUTO_INCREMENT,
  Kommentar int NOT NULL,
  Aktivitet int NOT NULL,
  PRIMARY KEY (id),
    FOREIGN KEY (Kommentar)
    REFERENCES aktivitethjemmet.Kommentar (id),
    FOREIGN KEY (Aktivitet)
    REFERENCES aktivitethjemmet.Aktivitet (id));

-- -----------------------------------------------------
-- Table aktivitethjemmet.TagsBruker
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS aktivitethjemmet.TagsBruker (
  id int NOT NULL AUTO_INCREMENT,
  Besok int NOT NULL DEFAULT 0,
  Score int NULL DEFAULT 0,
  Bruker VARCHAR(30) NOT NULL,
  Tag VARCHAR(45) NOT NULL,
  PRIMARY KEY (id),
    FOREIGN KEY (Bruker)
    REFERENCES aktivitethjemmet.Bruker (Brukernavn),
    FOREIGN KEY (Tag)
    REFERENCES aktivitethjemmet.Tags (Tag));

-- -----------------------------------------------------
-- Table aktivitethjemmet.TagsAktivitet
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS aktivitethjemmet.TagsAktivitet (
  id int NOT NULL AUTO_INCREMENT,
  Vekt int NULL DEFAULT 0,
  Tag VARCHAR(45) NOT NULL,
  Aktivitet int NOT NULL,
  PRIMARY KEY (id),
    FOREIGN KEY (Tag)
    REFERENCES aktivitethjemmet.Tags (Tag),
    FOREIGN KEY (Aktivitet)
    REFERENCES aktivitethjemmet.Aktivitet (id));
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema tag
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema tag
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `tag` DEFAULT CHARACTER SET utf8 ;
USE `tag` ;

-- -----------------------------------------------------
-- Table `tag`.`writer`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `tag`.`writer` ;

CREATE TABLE IF NOT EXISTS `tag`.`writer` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `firstName` VARCHAR(25) NULL,
  `lastName` VARCHAR(25) NULL,
  `email` VARCHAR(40) NOT NULL,
  `birthday` DATE NULL,
  `password` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tag`.`text`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `tag`.`text` ;

CREATE TABLE IF NOT EXISTS `tag`.`text` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `date` DATETIME NOT NULL,
  `constraint` VARCHAR(50) NULL,
  `note` VARCHAR(255) NULL,
  `writing` VARCHAR(45) NULL,
  `writer_id` INT NOT NULL,
  `parent_id` INT NULL,
  `title` VARCHAR(45) NOT NULL DEFAULT 'untitled',
  PRIMARY KEY (`id`),
  INDEX `fk_text_writer_idx` (`writer_id` ASC),
  INDEX `fk_text_text_idx` (`parent_id` ASC),
  CONSTRAINT `fk_text_writer`
    FOREIGN KEY (`writer_id`)
    REFERENCES `tag`.`writer` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_text_text`
    FOREIGN KEY (`parent_id`)
    REFERENCES `tag`.`text` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tag`.`keyword`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `tag`.`keyword` ;

CREATE TABLE IF NOT EXISTS `tag`.`keyword` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `word` VARCHAR(45) NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `word_UNIQUE` (`word` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tag`.`keyword`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `tag`.`keyword` ;

CREATE TABLE IF NOT EXISTS `tag`.`keyword` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `word` VARCHAR(45) NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `word_UNIQUE` (`word` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tag`.`text_has_keyword`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `tag`.`text_has_keyword` ;

CREATE TABLE IF NOT EXISTS `tag`.`text_has_keyword` (
  `text_id` INT NOT NULL,
  `keyword_id` INT NOT NULL,
  PRIMARY KEY (`text_id`, `keyword_id`),
  INDEX `fk_text_has_keyword_keyword_idx` (`keyword_id` ASC),
  INDEX `fk_text_has_keyword_text_idx` (`text_id` ASC),
  CONSTRAINT `fk_text_has_keyword_text`
    FOREIGN KEY (`text_id`)
    REFERENCES `tag`.`text` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_text_has_keyword_keyword`
    FOREIGN KEY (`keyword_id`)
    REFERENCES `tag`.`keyword` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

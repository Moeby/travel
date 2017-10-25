-- MySQL Script generated by MySQL Workbench
-- 10/24/17 22:58:53
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema travel
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema travel
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `travel` DEFAULT CHARACTER SET utf8 ;
USE `travel` ;

-- -----------------------------------------------------
-- Table `travel`.`user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `travel`.`user` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(45) NOT NULL,
  `password` VARCHAR(60) NOT NULL,
  `salt` VARCHAR(4) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `travel`.`location`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `travel`.`location` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `latitude` VARCHAR(1) NOT NULL,
  `longitude` VARCHAR(11) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `travel`.`user_has_location`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `travel`.`user_has_location` (
  `user_id` INT NOT NULL,
  `location_id` INT NOT NULL,
  PRIMARY KEY (`user_id`, `location_id`),
  INDEX `fk_user_has_location_location1_idx` (`location_id` ASC),
  INDEX `fk_user_has_location_user1_idx` (`user_id` ASC),
  CONSTRAINT `fk_user_has_location_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `travel`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_has_location_location1`
    FOREIGN KEY (`location_id`)
    REFERENCES `travel`.`location` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `travel`.`post`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `travel`.`post` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(45) NOT NULL,
  `text` VARCHAR(450) NOT NULL,
  `date` DATETIME NULL,
  `user_has_location_user_id` INT NOT NULL,
  `user_has_location_location_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_post_user_has_location1_idx` (`user_has_location_user_id` ASC, `user_has_location_location_id` ASC),
  CONSTRAINT `fk_post_user_has_location1`
    FOREIGN KEY (`user_has_location_user_id` , `user_has_location_location_id`)
    REFERENCES `travel`.`user_has_location` (`user_id` , `location_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `travel`.`picture`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `travel`.`picture` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL,
  `filename` VARCHAR(45) NULL,
  `post_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_picture_post_idx` (`post_id` ASC),
  CONSTRAINT `fk_picture_post`
    FOREIGN KEY (`post_id`)
    REFERENCES `travel`.`post` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
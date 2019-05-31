-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema benchmarker
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema benchmarker
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `benchmarker` DEFAULT CHARACTER SET utf8 ;
USE `benchmarker` ;

-- -----------------------------------------------------
-- Table `benchmarker`.`behavior`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `benchmarker`.`behavior` (
  `id` INT(9) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 5
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `benchmarker`.`permission`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `benchmarker`.`permission` (
  `id` INT(9) NOT NULL AUTO_INCREMENT,
  `slug` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `benchmarker`.`element`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `benchmarker`.`element` (
  `id` CHAR(36) NOT NULL,
  `id_permission` INT(11) NOT NULL,
  `description` TEXT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_element_permission1`
    FOREIGN KEY (`id_permission`)
    REFERENCES `benchmarker`.`permission` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE INDEX `fk_element_permission1_idx` ON `benchmarker`.`element` (`id_permission` ASC) VISIBLE;


-- -----------------------------------------------------
-- Table `benchmarker`.`migrations`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `benchmarker`.`migrations` (
  `version` BIGINT(20) NOT NULL)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `benchmarker`.`role`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `benchmarker`.`role` (
  `id` INT(9) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 11
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `benchmarker`.`permission_role`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `benchmarker`.`permission_role` (
  `id` INT(9) NOT NULL AUTO_INCREMENT,
  `id_role` INT(11) NOT NULL,
  `id_permission` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_permission_role_permission`
    FOREIGN KEY (`id_permission`)
    REFERENCES `benchmarker`.`permission` (`id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_permission_role_role1`
    FOREIGN KEY (`id_role`)
    REFERENCES `benchmarker`.`role` (`id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = utf8;

CREATE INDEX `fk_permission_role_permission_idx` ON `benchmarker`.`permission_role` (`id_permission` ASC) VISIBLE;

CREATE INDEX `fk_permission_role_role1_idx` ON `benchmarker`.`permission_role` (`id_role` ASC) VISIBLE;


-- -----------------------------------------------------
-- Table `benchmarker`.`user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `benchmarker`.`user` (
  `id` INT(9) NOT NULL AUTO_INCREMENT,
  `first_name` VARCHAR(255) NULL DEFAULT NULL,
  `last_name` VARCHAR(255) NULL DEFAULT NULL,
  `email` VARCHAR(255) NOT NULL,
  `passwd` VARCHAR(255) NOT NULL,
  `id_role` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_user_role1`
    FOREIGN KEY (`id_role`)
    REFERENCES `benchmarker`.`role` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = utf8;

CREATE INDEX `fk_user_role1_idx` ON `benchmarker`.`user` (`id_role` ASC) VISIBLE;


-- -----------------------------------------------------
-- Table `benchmarker`.`user_element_behavior`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `benchmarker`.`user_element_behavior` (
  `id` INT(9) NOT NULL AUTO_INCREMENT,
  `id_element` CHAR(36) NOT NULL,
  `id_user` INT(11) NOT NULL,
  `id_behavior` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_user_element_behavior_user1`
    FOREIGN KEY (`id_user`)
    REFERENCES `benchmarker`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_element_behavior_behavior1`
    FOREIGN KEY (`id_behavior`)
    REFERENCES `benchmarker`.`behavior` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_element_behavior_element1`
    FOREIGN KEY (`id_element`)
    REFERENCES `benchmarker`.`element` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE INDEX `fk_user_element_behavior_user1_idx` ON `benchmarker`.`user_element_behavior` (`id_user` ASC) VISIBLE;

CREATE INDEX `fk_user_element_behavior_behavior1_idx` ON `benchmarker`.`user_element_behavior` (`id_behavior` ASC) VISIBLE;

CREATE INDEX `fk_user_element_behavior_element1_idx` ON `benchmarker`.`user_element_behavior` (`id_element` ASC) VISIBLE;

USE `benchmarker`;

DELIMITER $$
USE `benchmarker`$$
CREATE
DEFINER=`root`@`localhost`
TRIGGER `benchmarker`.`uuid_before_insert_element`
BEFORE INSERT ON `benchmarker`.`element`
FOR EACH ROW
SET new.id = uuid()$$


DELIMITER ;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

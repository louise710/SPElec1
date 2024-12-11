USE `usjr`;


CREATE TABLE `usjr`.`appusers`(
  `uid` INT auto_increment,
  `username` VARCHAR(45) NOT NULL,
  `password` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`uid`)
);
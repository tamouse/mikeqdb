DROP TABLE IF EXISTS `votes` ;
DROP TABLE IF EXISTS `ratings`;
DROP TABLE IF EXISTS `quotes`;


CREATE TABLE `quotes`
(
	`id` INT NOT NULL AUTO_INCREMENT,
	`quote_text` TEXT NOT NULL ,
	`rating` INT,

	`created` DATETIME NOT NULL ,
	`updated` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (id)
) ENGINE=INNODB;


CREATE TABLE votes
(
	`id` INT NOT NULL AUTO_INCREMENT,
	`quote_id` INT,
	`ip_addr` VARCHAR(15) NOT NULL,
	`vote` INT,

	`created` DATETIME NOT NULL ,
	`updated` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

	PRIMARY KEY (id),

	INDEX quo_id (quote_id),
	FOREIGN KEY (quote_id) REFERENCES quotes(id)
	ON DELETE CASCADE
	ON UPDATE CASCADE

) ENGINE=INNODB;

GRANT ALL ON `mikeqdb`.* TO 'mike'@'localhost' IDENTIFIED BY 'for some value of quote';

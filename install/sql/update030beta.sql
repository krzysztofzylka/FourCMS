DELETE
	FROM config
	WHERE name = 'debugBar'
	   OR name = 'debugBarForUser'
	   OR name = 'debugBarDefaultExpandData';

CREATE TABLE `user_option` (
	`id` INT(24) NOT NULL AUTO_INCREMENT,
	`userID` INT(24) NOT NULL,
	`name` VARCHAR(255) NOT NULL,
	`value` TEXT NOT NULL,
	PRIMARY KEY (`id`)
);

INSERT INTO `permissionlist` (`id`, `permName`, `name`, `description`)
	VALUES (NULL, 'option_userResetPassword', 'Reset hasła użytkownika', 'Reset hasła użytkownika')

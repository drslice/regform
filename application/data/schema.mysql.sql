-- --------------------------------------------------------
--
-- This MySQL file will create the necessary tables
-- 	2 users are created: admin and test
-- 	These users cannot log in until their password is set
-- 	Use "?force_login=admin" to set them manually
--
-- --------------------------------------------------------

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;

-- --------------------------------------------------------

DROP TABLE IF EXISTS `fields`;
CREATE TABLE IF NOT EXISTS `fields` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `form_id` int(11) unsigned DEFAULT NULL,
  `num` int(11) unsigned NOT NULL,
  `name` varchar(50) NOT NULL,
  `type` varchar(50) NOT NULL,
  `size` tinyint(3) unsigned NOT NULL,
  `rows` tinyint(3) unsigned NOT NULL,
  `cols` tinyint(3) unsigned NOT NULL,
  `options` text NOT NULL,
  `required` tinyint(4) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`form_id`,`name`),
  UNIQUE KEY `ordinal` (`form_id`,`num`),
  KEY `fk_form_id` (`form_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

INSERT INTO `fields` (`id`, `form_id`, `num`, `name`, `type`, `size`, `rows`, `cols`, `options`, `required`) VALUES
(1, 1, 1, 'Name', 'text', 50, 10, 60, '', 1),
(2, 1, 2, 'Email', 'text', 50, 10, 60, '', 1),
(3, 1, 3, 'Are you over the age of 21?', 'yesno', 0, 0, 0, '', 0),
(4, 1, 4, 'What is your favorite color?', 'select', 0, 0, 0, 'red, yellow, blue, green, orange, purple, black, white', 0),
(5, 1, 5, 'Please describe your hobbies.', 'textarea', 0, 10, 60, '', 0);

-- --------------------------------------------------------

DROP TABLE IF EXISTS `forms`;
CREATE TABLE IF NOT EXISTS `forms` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned DEFAULT NULL,
  `name` varchar(50) NOT NULL,
  `submit_value` varchar(20) NOT NULL,
  `created` int(11) NOT NULL,
  `finalized` tinyint(4) NOT NULL,
  `published` tinyint(4) NOT NULL,
  `send_email` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`user_id`,`name`),
  KEY `fk_user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

INSERT INTO `forms` (`id`, `user_id`, `name`, `submit_value`, `created`, `finalized`, `published`, `send_email`) VALUES
(1, 2, 'Sample Form', 'Register', 1283376595, 0, 0, 0);

-- --------------------------------------------------------

DROP TABLE IF EXISTS `levels`;
CREATE TABLE IF NOT EXISTS `levels` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `max_forms` tinyint(3) unsigned NOT NULL,
  `max_fields` tinyint(3) unsigned NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `descr` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

INSERT INTO `levels` (`id`, `name`, `max_forms`, `max_fields`, `price`, `descr`) VALUES
(1, 'Trial', 3, 10, '0.00', 'You can create up to 3 forms with up to 10 fields per form but you can not publish them.'),
(2, 'Basic', 3, 10, '10.00', 'You can create up to 3 forms with up to 10 fields per form.'),
(3, 'Professional', 10, 20, '20.00', 'You can create up to 10 forms with up to 20 fields per form.');

-- --------------------------------------------------------

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

INSERT INTO `roles` (`id`, `name`, `description`) VALUES
(1, 'login', 'Login privileges, granted after account confirmation'),
(2, 'admin', 'Administrative user, has access to everything.');

-- --------------------------------------------------------

DROP TABLE IF EXISTS `roles_users`;
CREATE TABLE IF NOT EXISTS `roles_users` (
  `user_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `fk_role_id` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `roles_users` (`user_id`, `role_id`) VALUES
(1, 1),
(1, 2),
(2, 1);

-- --------------------------------------------------------

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `level_id` int(11) unsigned DEFAULT NULL,
  `email` varchar(127) NOT NULL,
  `username` varchar(32) NOT NULL DEFAULT '',
  `password` char(50) NOT NULL,
  `logo` varchar(250) NOT NULL,
  `logins` int(10) unsigned NOT NULL DEFAULT '0',
  `last_login` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_username` (`username`),
  UNIQUE KEY `uniq_email` (`email`),
  KEY `fk_level_id` (`level_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

INSERT INTO `users` (`id`, `level_id`, `email`, `username`, `password`, `logo`, `logins`, `last_login`) VALUES
(1, 3, 'admin@reg.com', 'admin', '', '', 0, 0),
(2, 1, 'test@test.test', 'test', '', '', 0, 0);

-- --------------------------------------------------------

DROP TABLE IF EXISTS `user_tokens`;
CREATE TABLE IF NOT EXISTS `user_tokens` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `user_agent` varchar(40) NOT NULL,
  `token` varchar(32) NOT NULL,
  `created` int(10) unsigned NOT NULL,
  `expires` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_token` (`token`),
  KEY `fk_user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

ALTER TABLE `fields`
  ADD CONSTRAINT `fields_ibfk_1` FOREIGN KEY (`form_id`) REFERENCES `forms` (`id`) ON DELETE CASCADE;

ALTER TABLE `forms`
  ADD CONSTRAINT `forms_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

ALTER TABLE `roles_users`
  ADD CONSTRAINT `roles_users_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `roles_users_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`level_id`) REFERENCES `levels` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

ALTER TABLE `user_tokens`
  ADD CONSTRAINT `user_tokens_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

COMMIT;

<?php defined('SYSPATH') or die('No direct script access.'); ?>

2010-09-01 07:57:26 --- ERROR: ReflectionException [ -1 ]: Class controller_form-old does not exist ~ MODPATH/userguide/classes/kohana/kodoc.php [ 136 ]
2010-09-01 07:57:26 --- ERROR: ErrorException [ 4 ]: syntax error, unexpected '-', expecting '{' ~ MODPATH/userguide/classes/kohana/kodoc/missing.php(30) : eval()'d code [ 1 ]
2010-09-01 10:24:59 --- ERROR: Database_Exception [ 1452 ]: Cannot add or update a child row: a foreign key constraint fails (`dryke`.`forms`, CONSTRAINT `forms_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE) [ INSERT INTO `forms` (`name`) VALUES ('test') ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 178 ]
2010-09-01 10:25:20 --- ERROR: Database_Exception [ 1452 ]: Cannot add or update a child row: a foreign key constraint fails (`dryke`.`forms`, CONSTRAINT `forms_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE) [ INSERT INTO `forms` (`name`, `user_id`) VALUES ('test', 3) ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 178 ]
2010-09-01 14:26:42 --- ERROR: ErrorException [ 8 ]: Undefined offset: 10 ~ MODPATH/orm/classes/kohana/orm.php [ 836 ]
2010-09-01 14:27:54 --- ERROR: ErrorException [ 8 ]: Undefined offset: 10 ~ MODPATH/orm/classes/kohana/orm.php [ 836 ]
2010-09-01 15:49:17 --- ERROR: ErrorException [ 64 ]: Cannot redeclare class Controller_Account ~ APPPATH/classes/controller/report.php [ 105 ]
2010-09-01 16:50:16 --- ERROR: Kohana_View_Exception [ 0 ]: The requested view report/view could not be found ~ SYSPATH/classes/kohana/view.php [ 252 ]
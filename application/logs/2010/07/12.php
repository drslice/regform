<?php defined('SYSPATH') or die('No direct script access.'); ?>

2010-07-12 07:56:11 --- ERROR: Database_Exception [ 1452 ]: Cannot add or update a child row: a foreign key constraint fails (`dryke`.`forms`, CONSTRAINT `forms_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE) [ INSERT INTO `forms` (`name`, `created_on`) VALUES (&#039;&#039;, 1278946571) ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 174 ]
2010-07-12 07:58:49 --- ERROR: Kohana_Exception [ 0 ]: The labels property does not exist in the Model_Form class ~ MODPATH/orm/classes/kohana/orm.php [ 373 ]
2010-07-12 07:59:13 --- ERROR: ErrorException [ 4 ]: syntax error, unexpected '[', expecting ',' or ';' ~ APPPATH/views/form/add.php [ 8 ]
2010-07-12 08:01:27 --- ERROR: Database_Exception [ 1452 ]: Cannot add or update a child row: a foreign key constraint fails (`dryke`.`forms`, CONSTRAINT `forms_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE) [ INSERT INTO `forms` (`name`, `created_on`) VALUES (&#039;&#039;, 1278946887) ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 174 ]
2010-07-12 08:02:46 --- ERROR: Database_Exception [ 1103 ]: Incorrect table name &#039;&#039; [ INSERT INTO `` (`form_id`, `field_id`) VALUES (3, NULL) ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 174 ]
2010-07-12 08:09:02 --- ERROR: Database_Exception [ 1062 ]: Duplicate entry &#039;&#039; for key &#039;name&#039; [ INSERT INTO `forms` (`name`, `user_id`, `created_on`) VALUES (&#039;&#039;, &#039;1&#039;, 1278947342) ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 174 ]
2010-07-12 08:10:32 --- ERROR: Database_Exception [ 1103 ]: Incorrect table name &#039;&#039; [ INSERT INTO `` (`form_id`, `field_id`) VALUES (5, NULL) ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 174 ]
2010-07-12 08:13:50 --- ERROR: Database_Exception [ 1062 ]: Duplicate entry &#039;1-asdfasdf&#039; for key &#039;name&#039; [ INSERT INTO `forms` (`name`, `submit_value`, `user_id`, `created_on`) VALUES (&#039;asdfasdf&#039;, &#039;test&#039;, &#039;1&#039;, 1278947630) ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 174 ]
2010-07-12 08:14:01 --- ERROR: Database_Exception [ 1103 ]: Incorrect table name &#039;&#039; [ INSERT INTO `` (`form_id`, `field_id`) VALUES (7, NULL) ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 174 ]
2010-07-12 08:17:55 --- ERROR: Database_Exception [ 1103 ]: Incorrect table name &#039;&#039; [ INSERT INTO `` (`form_id`, `field_id`) VALUES (8, NULL) ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 174 ]
2010-07-12 08:21:04 --- ERROR: Database_Exception [ 1062 ]: Duplicate entry &#039;1-asdfasdf&#039; for key &#039;name&#039; [ INSERT INTO `forms` (`name`, `submit_value`, `user_id`, `created_on`) VALUES (&#039;asdfasdf&#039;, &#039;ersd&#039;, &#039;1&#039;, 1278948064) ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 174 ]
2010-07-12 08:21:19 --- ERROR: ErrorException [ 8 ]: Undefined index: field ~ MODPATH/orm/classes/kohana/orm.php [ 1071 ]
2010-07-12 08:25:36 --- ERROR: Kohana_Exception [ 0 ]: The fields property does not exist in the Model_Form class ~ MODPATH/orm/classes/kohana/orm.php [ 373 ]
2010-07-12 08:26:32 --- ERROR: ErrorException [ 8 ]: Undefined index: fieldss ~ MODPATH/orm/classes/kohana/orm.php [ 1071 ]
2010-07-12 08:26:52 --- ERROR: Database_Exception [ 1103 ]: Incorrect table name &#039;&#039; [ INSERT INTO `` (`form_id`, `field_id`) VALUES (12, NULL) ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 174 ]
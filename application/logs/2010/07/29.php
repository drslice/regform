<?php defined('SYSPATH') or die('No direct script access.'); ?>

2010-07-29 14:10:29 --- ERROR: Database_Exception [ 1103 ]: Incorrect table name &#039;&#039; [ INSERT INTO `` (`form_id`, `field_id`) VALUES (1, NULL) ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 174 ]
2010-07-29 14:14:28 --- ERROR: ReflectionException [ 0 ]: Method action_index does not exist ~ SYSPATH/classes/kohana/request.php [ 1025 ]
2010-07-29 14:15:13 --- ERROR: Database_Exception [ 1062 ]: Duplicate entry &#039;1-asdf&#039; for key &#039;name&#039; [ INSERT INTO `forms` (`name`, `submit_value`, `user_id`, `created_on`) VALUES (&#039;asdf&#039;, &#039;test&#039;, &#039;1&#039;, 1280438113) ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 174 ]
2010-07-29 14:31:57 --- ERROR: ErrorException [ 8 ]: Undefined offset: 1 ~ SYSPATH/classes/kohana/validate.php [ 883 ]
2010-07-29 14:32:34 --- ERROR: Database_Exception [ 1062 ]: Duplicate entry &#039;1-asdf&#039; for key &#039;name&#039; [ INSERT INTO `forms` (`name`, `submit_value`, `user_id`, `created_on`) VALUES (&#039;asdf&#039;, &#039;test&#039;, &#039;1&#039;, 1280439154) ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 174 ]
2010-07-29 14:33:31 --- ERROR: Database_Exception [ 1062 ]: Duplicate entry &#039;1-asdf&#039; for key &#039;name&#039; [ INSERT INTO `forms` (`name`, `submit_value`, `user_id`, `created_on`) VALUES (&#039;asdf&#039;, &#039;asdfasdf&#039;, &#039;1&#039;, 1280439211) ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 174 ]
2010-07-29 14:45:28 --- ERROR: Database_Exception [ 1103 ]: Incorrect table name &#039;&#039; [ INSERT INTO `` (`form_id`, `field_id`) VALUES (5, NULL) ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 174 ]
2010-07-29 14:48:47 --- ERROR: Database_Exception [ 1103 ]: Incorrect table name &#039;&#039; [ INSERT INTO `` (`form_id`, `field_id`) VALUES (6, NULL) ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 174 ]
2010-07-29 14:57:53 --- ERROR: Database_Exception [ 1103 ]: Incorrect table name &#039;&#039; [ INSERT INTO `` (`form_id`, `field_id`) VALUES (7, NULL) ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 174 ]
2010-07-29 15:12:27 --- ERROR: Database_Exception [ 1103 ]: Incorrect table name &#039;&#039; [ INSERT INTO `` (`form_id`, `field_id`) VALUES (9, NULL) ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 174 ]
2010-07-29 15:55:20 --- ERROR: Database_Exception [ 1103 ]: Incorrect table name '' [ INSERT INTO `` (`form_id`, `field_id`) VALUES (10, NULL) ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 178 ]
2010-07-29 16:07:21 --- ERROR: Database_Exception [ 1103 ]: Incorrect table name '' [ INSERT INTO `` (`form_id`, `field_id`) VALUES (11, NULL) ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 178 ]
2010-07-29 16:08:13 --- ERROR: Database_Exception [ 1103 ]: Incorrect table name '' [ INSERT INTO `` (`form_id`, `field_id`) VALUES (12, NULL) ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 178 ]
2010-07-29 16:08:28 --- ERROR: Database_Exception [ 1103 ]: Incorrect table name '' [ INSERT INTO `` (`form_id`, `field_id`) VALUES (13, NULL) ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 178 ]
2010-07-29 16:08:44 --- ERROR: Database_Exception [ 1103 ]: Incorrect table name '' [ INSERT INTO `` (`form_id2`, `field_id`) VALUES (14, NULL) ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 178 ]
2010-07-29 16:09:04 --- ERROR: Database_Exception [ 1103 ]: Incorrect table name '' [ INSERT INTO `` (`form_id2`, `field_id`) VALUES (15, NULL) ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 178 ]
2010-07-29 16:09:17 --- ERROR: Database_Exception [ 1103 ]: Incorrect table name '' [ INSERT INTO `` (`form_id2`, `field_id`) VALUES (16, NULL) ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 178 ]
2010-07-29 16:09:43 --- ERROR: ErrorException [ 8 ]: Undefined index: fields ~ MODPATH/orm/classes/kohana/orm.php [ 1071 ]
2010-07-29 16:10:58 --- ERROR: Kohana_Exception [ 0 ]: The fields property does not exist in the Model_Form class ~ MODPATH/orm/classes/kohana/orm.php [ 373 ]
2010-07-29 16:15:45 --- ERROR: Kohana_Exception [ 0 ]: The fields property does not exist in the Model_Form class ~ MODPATH/orm/classes/kohana/orm.php [ 373 ]
2010-07-29 16:16:05 --- ERROR: Database_Exception [ 1103 ]: Incorrect table name '' [ INSERT INTO `` (`form_id`, `field_id`) VALUES (18, NULL) ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 178 ]
2010-07-29 16:24:22 --- ERROR: Database_Exception [ 1103 ]: Incorrect table name '' [ INSERT INTO `` (`form_id`, `field_id`) VALUES (19, NULL) ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 178 ]
2010-07-29 16:36:17 --- ERROR: ErrorException [ 8 ]: Undefined index: field2_name ~ APPPATH/classes/controller/form.php [ 66 ]
2010-07-29 16:37:03 --- ERROR: ErrorException [ 8 ]: Undefined index: field2_name ~ APPPATH/classes/controller/form.php [ 66 ]
2010-07-29 16:37:51 --- ERROR: Database_Exception [ 1103 ]: Incorrect table name '' [ INSERT INTO `` (`form_id`, `field_id`) VALUES (22, NULL) ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 178 ]
2010-07-29 16:42:06 --- ERROR: Database_Exception [ 1452 ]: Cannot add or update a child row: a foreign key constraint fails (`dryke`.`fields`, CONSTRAINT `fields_ibfk_1` FOREIGN KEY (`form_id`) REFERENCES `forms` (`id`) ON DELETE CASCADE) [ INSERT INTO `fields` (`ordinal`, `name`, `type`) VALUES (1, '', 'text') ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 178 ]
2010-07-29 16:46:38 --- ERROR: Kohana_Exception [ 0 ]: The loaded property does not exist in the Model_Form class ~ MODPATH/orm/classes/kohana/orm.php [ 373 ]
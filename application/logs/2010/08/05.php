<?php defined('SYSPATH') or die('No direct script access.'); ?>

2010-08-05 09:42:35 --- ERROR: Database_Exception [ 1062 ]: Duplicate entry '24-dsafasdf' for key 'name' [ INSERT INTO `fields` (`ordinal`, `name`, `form_id`, `type`) VALUES (1, 'dsafasdf', '24', 'yesno') ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 178 ]
2010-08-05 09:42:50 --- ERROR: Database_Exception [ 1062 ]: Duplicate entry '24-dsafasdf' for key 'name' [ INSERT INTO `fields` (`ordinal`, `name`, `form_id`, `type`) VALUES (1, 'dsafasdf', '24', 'yesno') ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 178 ]
2010-08-05 09:46:49 --- ERROR: Database_Exception [ 1062 ]: Duplicate entry '24-dsafasdf' for key 'name' [ INSERT INTO `fields` (`ordinal`, `name`, `form_id`, `type`) VALUES (1, 'dsafasdf', '24', 'yesno') ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 178 ]
2010-08-05 09:51:16 --- ERROR: ErrorException [ 2 ]: Missing argument 3 for Kohana_Database_Query_Builder_Where::where(), called in /home/dryke/test_html/kohana/modules/orm/classes/kohana/orm.php on line 707 and defined ~ MODPATH/database/classes/kohana/database/query/builder/where.php [ 30 ]
2010-08-05 09:59:33 --- ERROR: ReflectionException [ -1 ]: Class controller_regmanage does not exist ~ SYSPATH/classes/kohana/request.php [ 1028 ]
2010-08-05 16:50:22 --- ERROR: ErrorException [ 8 ]: Trying to get property of non-object ~ APPPATH/classes/model/form.php [ 94 ]
2010-08-05 16:50:55 --- ERROR: ErrorException [ 2 ]: Missing argument 3 for Kohana_Database_MySQL::query(), called in /home/dryke/test_html/kohana/application/classes/model/form.php on line 114 and defined ~ MODPATH/database/classes/kohana/database/mysql.php [ 152 ]
2010-08-05 16:54:24 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '(id) 
)' at line 6 [ CREATE TABLE reg_1_24 (
 id INT NOT NULL AUTO_INCREMENT,
 field1 TINYINT NOT NULL,
 field2 VARCHAR(200) NOT NULL,
 reg_date DATETIME NOT NULL
 PRIMARY KEY (id) 
) ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 178 ]
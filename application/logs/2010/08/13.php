<?php defined('SYSPATH') or die('No direct script access.'); ?>

2010-08-13 10:28:33 --- ERROR: Kohana_Exception [ 0 ]: The maximum_fields property does not exist in the Model_Form class ~ MODPATH/orm/classes/kohana/orm.php [ 373 ]
2010-08-13 10:40:52 --- ERROR: Kohana_Exception [ 0 ]: The ordinal property does not exist in the Model_Field class ~ MODPATH/orm/classes/kohana/orm.php [ 425 ]
2010-08-13 11:04:23 --- ERROR: ErrorException [ 2 ]: Missing argument 3 for Kohana_Database_MySQL::query(), called in /home/dryke/test_html/kohana/application/classes/orm.php on line 35 and defined ~ MODPATH/database/classes/kohana/database/mysql.php [ 152 ]
2010-08-13 11:05:15 --- ERROR: Kohana_Exception [ 0 ]: The ordinal property does not exist in the Model_Field class ~ MODPATH/orm/classes/kohana/orm.php [ 373 ]
2010-08-13 11:06:46 --- ERROR: Kohana_Exception [ 0 ]: The ordinal property does not exist in the Model_Field class ~ MODPATH/orm/classes/kohana/orm.php [ 373 ]
2010-08-13 11:06:48 --- ERROR: Kohana_Exception [ 0 ]: The ordinal property does not exist in the Model_Field class ~ MODPATH/orm/classes/kohana/orm.php [ 373 ]
2010-08-13 11:19:11 --- ERROR: Database_Exception [ 1062 ]: Duplicate entry '24-' for key 'name' [ INSERT INTO `fields` (`type`, `size`, `rows`, `cols`, `num`, `name`, `form_id`) VALUES ('text', 50, 10, 60, 5, '', '24') ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 178 ]
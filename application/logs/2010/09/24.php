<?php defined('SYSPATH') or die('No direct script access.'); ?>

2010-09-24 11:09:25 --- ERROR: ErrorException [ 8 ]: Undefined index: level ~ SYSPATH/classes/kohana/validate.php [ 1023 ]
2010-09-24 11:09:56 --- ERROR: ErrorException [ 1 ]: Call to a member function find() on a non-object ~ APPPATH/classes/controller/user.php [ 145 ]
2010-09-24 11:19:05 --- ERROR: Kohana_Exception [ 0 ]: Invalid method check_level called in Model_User ~ MODPATH/orm/classes/kohana/orm.php [ 293 ]
2010-09-24 11:19:06 --- ERROR: Kohana_Exception [ 0 ]: Invalid method check_level called in Model_User ~ MODPATH/orm/classes/kohana/orm.php [ 293 ]
2010-09-24 14:54:42 --- ERROR: Kohana_Exception [ 0 ]: Invalid method check_level called in Model_User ~ MODPATH/orm/classes/kohana/orm.php [ 293 ]
2010-09-24 14:58:08 --- ERROR: ErrorException [ 8 ]: Undefined index: level_id ~ APPPATH/classes/controller/account.php [ 129 ]
2010-09-24 14:58:17 --- ERROR: ErrorException [ 8 ]: Undefined index: level ~ APPPATH/classes/controller/account.php [ 131 ]
2010-09-24 15:08:03 --- ERROR: Database_Exception [ 1062 ]: Duplicate entry 'test' for key 'uniq_username' [ INSERT INTO `users` (`username`, `email`, `password`, `level_id`) VALUES ('test', 'test@test.test', '22f174a0869ca3172c35d8a18e480b3a067931b9729be19eb8', 1) ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 178 ]
2010-09-24 15:11:06 --- ERROR: ErrorException [ 8 ]: Undefined variable: levels ~ APPPATH/views/user/add.php [ 36 ]
2010-09-24 15:50:14 --- ERROR: Database_Exception [ 1062 ]: Duplicate entry 'test' for key 'uniq_username' [ INSERT INTO `users` (`username`, `email`, `password`, `level_id`) VALUES ('test', 'test@test.test', '4a00f0247df44de5d275c734d786f801e8bd3241e3cb033958', '1') ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 178 ]
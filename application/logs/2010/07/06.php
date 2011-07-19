<?php defined('SYSPATH') or die('No direct script access.'); ?>

2010-07-06 13:02:30 --- ERROR: ReflectionException [ -1 ]: Class controller_users does not exist ~ SYSPATH/classes/kohana/request.php [ 1007 ]
2010-07-06 13:09:55 --- ERROR: ErrorException [ 4 ]: syntax error, unexpected T_DOUBLE_ARROW ~ APPPATH/views/user/password.php [ 1 ]
2010-07-06 13:18:45 --- ERROR: Database_Exception [ 1048 ]: Column &#039;user_id&#039; cannot be null [ INSERT INTO `roles_users` (`user_id`, `role_id`) VALUES (NULL, &#039;1&#039;) ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 174 ]
2010-07-06 14:03:17 --- ERROR: ErrorException [ 8 ]: Undefined variable: roles ~ APPPATH/views/user/edit.php [ 22 ]
2010-07-06 14:04:23 --- ERROR: ErrorException [ 8 ]: Undefined index: role ~ MODPATH/orm/classes/kohana/orm.php [ 1054 ]
2010-07-06 14:04:35 --- ERROR: ErrorException [ 1 ]: Call to a member function pk() on a non-object ~ MODPATH/orm/classes/kohana/orm.php [ 1056 ]
2010-07-06 14:04:59 --- ERROR: ErrorException [ 8 ]: Undefined index: role ~ MODPATH/orm/classes/kohana/orm.php [ 1054 ]
2010-07-06 14:07:44 --- ERROR: ErrorException [ 8 ]: Undefined index: role ~ MODPATH/orm/classes/kohana/orm.php [ 1054 ]
2010-07-06 14:56:28 --- ERROR: ErrorException [ 4 ]: syntax error, unexpected ',' ~ APPPATH/classes/controller/user.php [ 146 ]
2010-07-06 16:07:24 --- ERROR: Database_Exception [ 1062 ]: Duplicate entry &#039;5-1&#039; for key &#039;PRIMARY&#039; [ INSERT INTO `roles_users` (`user_id`, `role_id`) VALUES (&#039;5&#039;, &#039;1&#039;) ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 174 ]
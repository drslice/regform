<?php defined('SYSPATH') or die('No direct access allowed.');

return array
(
	'default' => array
	(
		//'type'       => 'mysql',
		'type' => 'pdo_sqlite',
		
		'connection' => array(
			'dsn' => 'sqlite:'.dirname(__FILE__).'/../data/reg.db',
			/**
			 * The following options are available for MySQL:
			 *
			 * string   hostname
			 * string   username
			 * string   password
			 * boolean  persistent
			 * string   database
			 *
			 * Ports and sockets may be appended to the hostname.
			'hostname'   => 'localhost',
			'username'   => 'eric',
			'password'   => 'eric',
			'persistent' => FALSE,
			'database'   => 'eric_reg2',
			*/
		),
		'table_prefix' => '',
		'charset'      => 'utf8',
		'caching'      => FALSE,
		'profiling'    => TRUE,
	),
);
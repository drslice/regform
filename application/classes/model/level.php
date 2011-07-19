<?php
/**
 * Level model
 */
class Model_Level extends ORM
{
	const TRIAL = 1;
	const BASIC = 2;
	const PROFESSIONAL = 3;
	
	// Relationships
	protected $_has_many = array(
		'users' => array(),
	);
	
	// Validation rules
	protected $_rules = array(
		'name' => array(
			'not_empty'  => array(),
			'min_length' => array(4),
			'max_length' => array(50),
			//'regex'      => array('/^[-\pL\pN_.]++$/uD'),
		),
		'max_forms' => array(
			'not_empty' => array(),
			'range' => array(1, 100),
		),
		'max_fields' => array(
			'not_empty' => array(),
			'range' => array(1, 100),
		),
	);
	
	protected $_labels = array(
		'name' => 'Name',
		'max_forms' => 'Maximum Forms',
		'max_fields' => 'Maximum Fields per Form',
	);
	
}
<?php
/**
 * Field model definition
 */
class Model_Field extends ORM
{
	const DEFAULT_TYPE = 'text';
	const DEFAULT_SIZE = 50;
	const DEFAULT_ROWS = 10;
	const DEFAULT_COLS = 60;
	
	// Relationships
	protected $_belongs_to = array(
		'form' => array(),
	);
	
	// Validation rules
	protected $_rules = array(
		'name' => array(
			'not_empty'  => null,
			'min_length' => array(4),
			'max_length' => array(50),
			//'regex'      => array('/^[-\pL\pN_.]++$/uD'),
		),
		'type' => array(
			'not_empty' => null,
			'max_length' => array(50),
		),
		'num' => array(
			'numeric' => null,
		),
	);
	
	protected $_callbacks = array(
		'type' => array(
			'type_in_list',
		),
	);
	
	protected $_labels = array(
		'name' => 'Name',
		'type' => 'Type',
		'size' => 'Length',
		'rows' => 'Height',
		'cols' => 'Width',
		'options' => 'Option List',
		'num' => 'Number',
	);
	
	protected $_defaults = array(
		'type' => self::DEFAULT_TYPE,
		'size' => self::DEFAULT_SIZE,
		'rows' => self::DEFAULT_ROWS,
		'cols' => self::DEFAULT_COLS,
	);
	
	// list of valid types
	protected $_types = array(
		'text',
		'textarea',
		'select',
		'yesno',
	);
	
	
	/**
	 * Checks to make sure type is in the valid list.
	 * @param object Validate object
	 * @param string field name
	 */
	public function type_in_list($array, $field)
	{
		if (!in_array($array['type'], $this->_types))
		{
			$array->error($field, "is not a valid field type", $array['type']);
		}
	}
	
}
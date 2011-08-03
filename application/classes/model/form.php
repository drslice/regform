<?php
/**
 * Form model definition
 */
class Model_Form extends ORM
{
	// Relationships
	protected $_belongs_to = array(
		'user' => array(),
	);
	
	protected $_has_many = array(
		'fields' => array('model' => 'field'),
	);
	
	// Validation rules
	protected $_rules = array(
		'name' => array(
			'not_empty'  => array(),
			'min_length' => array(4),
			'max_length' => array(50),
			//'regex'      => array('/^[-\pL\pN_.]++$/uD'),
		),
		'submit_value' => array(
			'not_empty' => array(),
			'min_length' => array(1),
			'max_length' => array(20),
		),
	);
	
	// Validation callbacks
	protected $_callbacks = array(
		'name' => array('name_available'),
	);
	
	protected $_labels = array(
		'name' => 'Form Name',
		'submit_value' => 'Submit Button Text',
		'send_email' => 'Send Me Registrations by Email?',
		'created' => 'Creation Date',
	);
	
	
	/**
	 * Triggers an error if form name has already been used by the user.
	 * Validation callback.
	 *
	 * @param object Validate object
	 * @param string field name
	 */
	public function name_available($array, $field)
	{
		$num = DB::select(array('COUNT("*")', 'total_count'))
			->from($this->_table_name)
			->where('name','=',$array['name'])
			->where('user_id','=',$array['user_id'])
			->execute($this->_db)
			->get('total_count');
		if ($num > 0)
		{
			$array->error($field, 'name_available', array($array['name']));
		}
	}
	
	
	/**
	 * Validate edited form.
	 * @return bool
	 */
	public function check_edit()
	{
		$name_rules = $this->_callbacks['name'];
		unset($this->_callbacks['name']);
		$result = $this->check();
		$this->_callbacks['name'] = $name_rules;
		return $result;
	}
	
	
	/**
	 * Creates the data table for this form.
	 * If the data table already exists it is deleted first.
	 */
	public function finalize()
	{
		if (!$this->loaded())
		{
			throw new Exception("This form is not loaded.");
		}
		$this->unfinalize();
		
		$sql = "CREATE TABLE {$this->data_table} (\n id INT AUTO_INCREMENT";
		foreach ($this->fields->find_all() as $field)
		{
			$sql .= ",\n field{$field->num} ";
			switch ($field->type)
			{
				case 'text':
				case 'select':
					$sql .= "VARCHAR(200)";
					break;
				case 'textarea':
					$sql .= "TEXT";
					break;
				case 'yesno':
					$sql .= "TINYINT";
					break;
				default:
					throw new Exception("Invalid field type: {$field->type}");
			}
		}
		$sql .= ",\n reg_time INT";
		$sql .= ",\n PRIMARY KEY (id) \n)";
		
		$this->_db->query(null, $sql, false);
		$this->finalized = 1;
		$this->save();
	}
	
	
	/**
	 * Deletes the data table for this form.
	 */
	public function unfinalize()
	{
		if (!$this->loaded())
		{
			throw new Exception("This form is not loaded.");
		}
		$this->_db->query(null, "DROP TABLE IF EXISTS {$this->data_table}_previous", false);
		try
		{
			$this->_db->query(null, "ALTER TABLE {$this->data_table} RENAME TO {$this->data_table}_previous", false);
		}
		catch (Exception $e)
		{
			$msg = $e->getMessage();
			if (strpos($msg, "Can't find file:") === false and (strpos($msg, "no such table") === false))
			{
				throw $e;
			}
			// ignore exception due to non-existant table
		}
		$this->finalized = 0;
		$this->published = 0;
		$this->save();
	}
	
	
	/**
	 * Extended to delete the associated data table as well as the current object.
	 * @see parent::delete()
	 */
	public function delete($id = null)
	{
		$this->unfinalize();
		return parent::delete($id);
	}
	
	
	/**
	 * Customized magic getter.
	 * @see parent::__get()
	 */
	public function __get($column)
	{
		switch ($column)
		{
			case 'data_table':
				return Kohana::config('database.default.table_prefix')."z{$this->user_id}_{$this->id}";
		}
		return parent::__get($column);
	}
	
	
	/**
	 * Customize behavior of various properties.
	 * @see parent::__set()
	 */
	public function __set($column, $value)
	{
		switch ($column)
		{
			case 'publish':
				if (!$this->finalized)
				{
					throw new Exception("This form must be finalized before it can be published.");
				}
		}
		return parent::__set($column, $value);
	}	
	
}
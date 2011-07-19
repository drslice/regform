<?php
/**
 * Reg model definition - does not use ORM.
 */
class Model_Reg extends Model
{
	const TIMESTAMP_COLUMN = 'reg_time';
	const TIMESTAMP_COLUMN_LABEL = 'Registration Timestamp';
	
	// name of DB table to use
	public $table_name = '';

	// list of rules to use for Validation
	public $rules = array();
	
	// list of columns in the table and their types
	public $table_columns = array();
	
	// list of all fields in the table
	public $fields = array();
	
	// list of fields and their labels
	public $labels = array();
	
	
	/**
	 * Determines the table to use from the form.
	 * @param ORM form
	 */
	public function set_form($form)
	{
		$this->table_name = $form->data_table;
	}
	
	
	/**
	 * Determines validator rules, table columns and labels from fields.
	 * @param ORM_Iterator $fields
	 */
	public function set_fields($fields)
	{
		foreach ($fields as $field)
		{
			$fieldname = "field{$field->num}";
			$this->table_columns[$fieldname] = $field->type;
			$this->fields[] = $fieldname;
			
			// rules
			if ($field->required)
			{
				if (!isset($this->rules[$fieldname]))
				{
					$this->rules[$fieldname] = array();
				}
				$this->rules[$fieldname]['not_empty'] = null;
			}
			
			// labels
			$this->labels[$fieldname] = $field->name;
		}
		// add reg_time field at end of labels so it is always the last field
		$this->fields[] = self::TIMESTAMP_COLUMN;
		$this->labels[self::TIMESTAMP_COLUMN] = self::TIMESTAMP_COLUMN_LABEL;
	}
	
	
	/**
	 * Validates values according to the rules array.
	 * The reference-passed array is converted to a Validate object.
	 * @param array $array
	 * @return bool
	 */
	public function check(array & $array)
	{
		if (!$this->labels)
		{
			throw new Exception("Rules/Labels not set.");
		}
		$array = Validate::factory($array);
		foreach ($this->rules as $field => $rules)
		{
			$array->rules($field, $rules);
		}
		$array->labels($this->labels);
		return $array->check();
	}
	
	
	/**
	 * Inserts a row into the current data table.
	 * @param array $values
	 * @return int
	 */
	public function insert($values)
	{
		if (!$this->table_name or !$this->table_columns)
		{
			throw new Exception("Table name and/or table columns not set.");
		}
		$data = array();
		foreach ($this->table_columns as $field => $type)
		{
			$data[$field] = isset($values[$field]) ? $values[$field] : '';
		}
		$data[self::TIMESTAMP_COLUMN] = $_SERVER['REQUEST_TIME'];
		$query = DB::insert($this->table_name, array_keys($data))->values(array_values($data));
		$arr = $query->execute();  // returns array: (last_insert_id, row_count)
		return $arr[0];
	}
	
	
	/**
	 * Gets a row from the data table.
	 * @param int $id
	 * @return object Database_Result
	 */
	public function get($id)
	{
		if (!$this->table_name)
		{
			throw new Exception("Table name not set.");
		}
		$query = DB::select()->from($this->table_name)->where('id','=',$id);
		return $query->execute()->current();
	}
	
	
	/**
	 * Generates report.
	 * @param string $order_by
	 * @param string $order_dir
	 * @param int $limit
	 * @param int $offset
	 * @return ojbect Database_Result
	 */
	public function report($order_by='reg_time', $order_dir='', $limit=0, $offset=0)
	{
		if (!$this->table_name)
		{
			throw new Exception("Table name not set.");
		}
		$order_by = in_array($order_by, $this->fields) ? $order_by : self::TIMESTAMP_COLUMN;
		$order_dir = $order_dir == 'd' ? 'DESC' : null;
		$query = DB::select()->from($this->table_name)->order_by($order_by, $order_dir);
		if ($limit)
		{
			$query = $query->limit((int)$limit);
		}
		if ($offset)
		{
			$query = $query->offset((int)$offset);
		}
		return $query->execute();
	}
	
	
	/**
	 * Counts total in table.
	 * @return int
	 */
	public function count()
	{
		if (!$this->table_name)
		{
			throw new Exception("Table name not set.");
		}
		$query = DB::query(Database::SELECT, "SELECT COUNT(*) as total FROM {$this->table_name}");
		$result = $query->execute();
		return $result->get('total');
	}
	
}
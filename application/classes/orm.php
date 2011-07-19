<?php

class ORM extends Kohana_ORM
{
	// whether this object in in the middle of a transaction
	protected $_in_transaction = false;
	
	// list of default values to set when creating a new object
	protected $_defaults = array();
	
	
	/**
	 * Extended to set default values.
	 * @see parent::__construct()
	 */
	public function __construct($id = null)
	{
		parent::__construct($id);
		if (!$this->_loaded)
		{
			foreach ($this->_defaults as $column => $value)
			{
				$this->_object[$column] = $value;
				$this->_changed[$column] = $column;
			}
		}
	}
	
	
	/**
	 * Start a transaction.
	 */
	public function begin()
	{
		if ($this->_in_transaction === false)
		{
			$this->_db->query(null, "BEGIN", false);
			$this->_in_transaction = true;
		}
	}
	
	
	/**
	 * Rollback a transaction.
	 */
	public function rollback()
	{
		if ($this->_in_transaction === true)
		{
			$this->_db->query(null, "ROLLBACK", false);
			$this->_in_transaction = false;
		}
	}
	
	
	/**
	 * Commit a transaction.
	 */
	public function commit()
	{
		if ($this->_in_transaction === true)
		{
			$this->_db->query(null, "COMMIT", false);
			$this->_in_transaction = false;
		}
	}

}
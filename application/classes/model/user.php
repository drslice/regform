<?php
/**
 * User authentication model
 */
class Model_User extends Model_Auth_User
{
	const MAX_LOGO_SIZE = '2M';
	const DEFAULT_LEVEL = 1;
	
	// Relationships
	protected $_belongs_to = array(
		'level' => array(),
	);
	
	protected $_has_many = array(
		'user_tokens' => array('model' => 'user_token'),
		'roles' => array('model' => 'role', 'through' => 'roles_users'),
		'forms' => array('model' => 'form'),
	);
	
	// Validation rules
	protected $_rules = array(
		'username' => array(
			'not_empty'  => NULL,
			'min_length' => array(4),
			'max_length' => array(50),
			'regex'      => array('/^[-\pL\pN_.]++$/uD'),
		),
		'password' => array(
			//'not_empty'  => NULL,
			'min_length' => array(4),
			'max_length' => array(50),
		),
		'password_confirm' => array(
			'matches'    => array('password'),
		),
		'email' => array(
			'not_empty'  => NULL,
			'min_length' => array(4),
			'max_length' => array(250),
			'email'      => NULL,
		),
	);
	
	// Validation callbacks
	protected $_callbacks = array(
		'username' => array('username_available'),
		'email' => array('email_available'),
		'level' => array('level_valid'),
	);

	
	protected $_labels = array(
		'username' => 'Username',
		'email' => 'Email',
		'password' => 'Password',
		'password_confirm' => 'Confirm Password',
		'logo' => 'Logo Image File',
		'level' => 'Level',
	);
	
	
	/**
	 * @see parent::login()
	 */
	public function login(array & $array, $redirect = FALSE)
	{
		$array = Validate::factory($array)
			->filter(TRUE, 'trim')
			->rules('username', $this->_rules['username'])
			->rules('password', $this->_rules['password'])
			->label('username', $this->_labels['username'])
			->label('password', $this->_labels['password'])
			;
		
		// Get the remember login option
		$remember = isset($array['remember']);
		
		// Login starts out invalid
		$status = FALSE;
		
		if ($array->check())
		{
			// Attempt to load the user
			$this->where('username', '=', $array['username'])->find();
			
			if ($this->loaded() AND Auth::instance()->login($this, $array['password'], $remember))
			{
				if (is_string($redirect))
				{
					// Redirect after a successful login
					Request::instance()->redirect($redirect);
				}
				
				// Login is successful
				$status = TRUE;
			}
			else
			{
				if ($this->loaded())
				{
					$array->error('password', 'invalid', array());
				}
				else
				{
					$array->error('username', 'invalid', array());
				}
			}
		}
		
		return $status;
	}
	
	
	/**
	 * Validate edited user
	 */
	public function check_edit()
	{
		$password_rules = $this->_rules['password'];
		$password_confirm_rules = $this->_rules['password_confirm'];
		unset($this->_rules['password']);
		unset($this->_rules['password_confirm']);
		$result = parent::check();
		$this->_rules['password'] = $password_rules;
		$this->_rules['password_confirm'] = $password_confirm_rules;
		if ($result)
		{
			// check upload
			if (!empty($_FILES['logo']['name']))
			{
				$valid = Validate::factory($_FILES);
				$valid->labels($this->_labels);
				$valid->rules('logo', array(
					'Upload::valid' => null,
					'Upload::type' => array('Upload::type' => array('gif','jpg','png',)),
					'Upload::size' => array(self::MAX_LOGO_SIZE))
				);
				$result = $valid->check();
				// put errors from file validation into ORM validation object
				if (!$result)
				{
					$errors = $valid->errors();
					foreach ($errors as $field => $error)
					{
						$this->_validate->error($field, $error[0]);
					}
				}
			}
		}
		
		return $result;
	}
	

	/**
	 * Triggers an error if user name is already taken
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
		if (DB::select(array('COUNT("*")', 'total_count'))
			->from($this->_table_name)
			->where('name','=',$array['name'])
			->where('user_id','=',$array['user_id'])
			->execute($this->_db)
			->get('total_count') > 0)
		{
			$array->error($field, 'name_available', array($array['name']));
		}
	}

	
	/**
	 * Triggers an error if level is invalid for this user.
	 * Validation callback.
	 *
	 * @param object Validate object
	 * @param string field name
	 */
	public function level_valid($array, $field)
	{
		// make sure level exists
		$level = ORM::factory('level', $array['level_id']);
		if (!$level->loaded())
		{
			$array->error($field, 'invalid', $array[$field]);
		}
		// make sure total forms is not over the limit
		$forms = ORM::factory('form')->where('user_id','=',$this->id)->find_all();
		if ($forms->count() > $level->max_forms)
		{
			$array->error($field, 'level_restricted', $array[$field]);
		}
		else
		{
			$valid = true;
			// make sure all form field counts are not over the limit
			foreach ($forms as $form)
			{
				if ($form->fields->find_all()->count() > $level->max_fields)
				{
					$valid = false;
					break;
				}
			}
			if (!$valid)
			{
				$array->error($field, 'level_restricted', $array[$field]);
			}
		}
	}
	
	
	/**
	 * Generates a password string
	 * @param int $length
	 * @return string
	 */
	public function generate_password($length = 8)
	{
		$password = "";
		// define possible characters (does not include l, number relatively likely)
		$possible = "123456789abcdefghjkmnpqrstuvwxyz123456789";
		$possible_length = strlen($possible);
		for ($i=0; $i<$length; $i++)
		{
			// pick a random char from possible
			$password .= substr($possible, mt_rand(0, $possible_length-1), 1);
		}
		return $password;
	}
	
	
	/**
	 * Create a sample form for this user
	 * @return bool
	 */
	public function create_sample_form()
	{
		if ($this->_loaded)
		{
			$values = array(
				'user_id' => $this->id,
				'name' => 'Sample Form',
				'submit_value' => 'Register',
				'created' => $_SERVER['REQUEST_TIME'],
			);
			$form = ORM::factory('form')->values($values)->save();
			
			$values = array(
				'form_id' => $form->id,
				'num' => 1,
				'name' => 'Name',
				'type' => 'text',
				'required' => 1,
			);
			$field = ORM::factory('field')->values($values)->save();
			
			$values = array(
				'form_id' => $form->id,
				'num' => 2,
				'name' => 'Email',
				'type' => 'text',
				'required' => 1,
			);
			$field = ORM::factory('field')->values($values)->save();
			
			$values = array(
				'form_id' => $form->id,
				'num' => 3,
				'name' => 'Are you married?',
				'type' => 'yesno',
			);
			$field = ORM::factory('field')->values($values)->save();
			
			$values = array(
				'form_id' => $form->id,
				'num' => 4,
				'name' => 'What is your favorite color?',
				'type' => 'select',
				'options' => 'red, yellow, blue, green, orange, purple, black, white',
			);
			$field = ORM::factory('field')->values($values)->save();
			
			$values = array(
				'form_id' => $form->id,
				'num' => 5,
				'name' => 'Please describe your hobbies.',
				'type' => 'textarea',
			);
			$field = ORM::factory('field')->values($values)->save();
			
			return true;
		}
		return false;
	}

}
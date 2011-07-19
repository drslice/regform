<?php
/**
 * This is the user CRUD controller.
 */
class Controller_User extends Controller_Base
{
	// admin access only - for regular users see account controller
	protected $auth_required = array('login','admin');
	

	/**
	 * Execute the default action, currently it is the list action.
	 */
	public function action_index()
	{
		$this->action_list();
	}
	
	
	/**
	 * Display a list of users.
	 */
	public function action_list()
	{
		$this->title = "Manage Users";
		$user = ORM::factory('user');
		$view = 'user/list';
		$vars = array(
			'labels' => $user->labels(),
			'users' => $user->find_all(),
		);
		$this->template->content = View::factory($view)->set($vars);
	}
	
	
	/**
	 * Display a single user.
	 * @param int $id	the id of of the user to view
	 */
	public function action_view($id = null)
	{
		$this->title = "View User";
		$user = ORM::factory('user', $id);
		if (!$user->loaded())
		{
			throw new Exception("User not found: {$id}", 404);
		}
		$view = 'user/view';
		$vars = array(
			'user' => $user,
		);
		$this->template->content = View::factory($view)->set($vars);
		$this->template->footer = $this->footer($vars);
	}
	
	
	/**
	 * Add a new user.
	 */
	public function action_add()
	{
		$this->title = 'Add a New User';
		$user = ORM::factory('user');
		$roles = ORM::factory('role')->find_all();
		$errors = array();
		if ($_POST)
		{
			$user->values($_POST);
			if ($user->check())
			{
				$user->save(); // must save before adding relations
				foreach ($roles as $role)
				{
					if (!empty($_POST['roles'][$role->id]))
					{
						$user->add('roles', $role);
					}
				}
				$this->session->set($this->success_session_key, "User {$user->username} has been created.");
				$this->request->redirect('user');
			}
			else
			{
				$errors = $user->validate()->errors('validate');
			}
		}
		$view = 'user/add';
		$vars = array(
			'user' => $user,
			'roles' => $roles,
			'errors' => $errors,
			'levels' => ORM::factory('level')->find_all(),
		);
		$this->template->content = View::factory($view)->set($vars);
	}
	
	
	/**
	 * Update a user.
	 * @var int $id		the id of the user to update
	 */
	public function action_edit($id = null)
	{
		$this->title = "Update User";
		$user = ORM::factory('user', $id);
		if (!$user->loaded())
		{
			throw new Exception("User not found: {$id}", 404);
		}
		$roles = ORM::factory('role')->find_all();
		$levels = ORM::factory('level')->find_all();
		$errors = array();
		if ($_POST)
		{
			$user->values($_POST);
			if ($user->check_edit())
			{
				$user->save();
				foreach ($roles as $role)
				{
					if (empty($_POST['roles'][$role->id]))
					{
						$user->remove('roles', $role);
					}
					else
					{
						if (!$user->has('roles', $role))
						{
							$user->add('roles', $role);
						}
					}
				}
				$this->session->set($this->success_session_key, "User {$user->username} has been updated.");
				$this->request->redirect('user');
			}
			else
			{
				$errors = $user->validate()->errors('validate');
			}
		}
		$view = 'user/edit';
		$vars = array(
			'user' => $user,
			'roles' => $roles,
			'levels' => $levels,
			'errors' => $errors,
		);
		$this->template->content = View::factory($view)->set($vars);
		$this->template->footer = $this->footer($vars);
	}
	
	
	/**
	 * Change a user's password.
	 * @var int $id		the id of the user to change the password for
	 */
	public function action_password($id = null)
	{
		$this->title = "Change Password";
		$user = ORM::factory('user', $id);
		if (!$user->loaded())
		{
			throw new Exception("User not found: {$id}", 404);
		}
		$this->title .= " for {$user->username} ({$user->email})";
		$errors = array();
		if ($_POST)
		{
			if ($user->change_password($_POST))
			{
				$this->session->set($this->success_session_key, "User {$user->username} password was changed.");
				$this->request->redirect('user');
			}
			else
			{
				$errors = $_POST->errors('validate');
			}
		}
		$view = 'user/password';
		$vars = array(
			'user' => $user,
			'errors' => $errors,
		);
		$this->template->content = View::factory($view)->set($vars);
		$this->template->footer = $this->footer($vars);
	}
	
	
	/**
	 * Delete a user after displaying a confirmation message.
	 * @var int $id		the id of the user to delete
	 */
	public function action_delete($id = 0)
	{
		$this->title = "Delete User";
		$user = ORM::factory('user', $id);
		if (!$user->loaded())
		{
			throw new Exception("User not found {$id}", 404);
		}
		if (isset($_GET['confirm']) and $_GET['confirm'] == 'yes')
		{
			$username = $user->username;
			$user->delete($id);
			$this->session->set($this->success_session_key, "User {$username} has been deleted.");
			$this->request->redirect('user');
		}
		$view = 'user/delete';
		$vars = array(
			'user' => $user,
		);
		$this->template->content = View::factory($view)->set($vars);
		$this->template->footer = $this->footer($vars);
	}
	
	
	/**
	 * @see parent::footer()
	 */
	protected function footer($vars = array())
	{
		$vars['action'] = $this->request->action;
		$vars['buttons'] = array();
		
		if (isset($vars['user']) and $vars['user']->id)
		{
			if ($vars['action'] != 'view')
			{
				$vars['buttons'][] = array(
					'href' => URL::site("user/view/{$vars['user']->id}"),
					'text' => 'View',
					'title' => 'View this user',
				);
			}
			if ($vars['action'] != 'edit')
			{
				$vars['buttons'][] = array(
					'href' => URL::site("user/edit/{$vars['user']->id}"),
					'text' => 'Edit',
					'title' => 'Edit this user',
				);
			}
			if ($vars['action'] != 'password')
			{
				$vars['buttons'][] = array(
					'href' => URL::site("user/password/{$vars['user']->id}"),
					'text' => 'Password',
					'title' => 'Change this user\'s password',
				);
			}
			if ($vars['action'] != 'delete')
			{
				$vars['buttons'][] = array(
					'href' => URL::site("user/delete/{$vars['user']->id}"),
					'text' => 'Delete',
					'title' => 'Delete this user',
				);
			}
		}
		if ($vars['action'] != 'add')
		{
			$vars['buttons'][] = array(
				'href' => URL::site('user/add'),
				'text' => 'Add',
				'title' => 'Add a new user',
			);
		}
		if ($vars['action'] != 'list' and $vars['action'] != 'index')
		{
			$vars['buttons'][] = array(
				'href' => URL::site('user'),
				'text' => 'List',
				'title' => 'List users',
			);
		}
		
		return parent::footer($vars);
	}
	
}
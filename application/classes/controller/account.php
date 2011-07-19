<?php
/**
 * This is the account controller for users to manage their accounts.
 */
class Controller_Account extends Controller_Base
{
	// must be logged in
	protected $auth_required = array('login');
	

	/**
	 * Execute default action: currently view.
	 */
	public function action_index()
	{
		$this->action_view();
	}
	
	
	/**
	 * Show current user's account info.
	 */
	public function action_view()
	{
		$this->title = 'My Account';
		
		$num_forms = ORM::factory('form')->where('user_id','=',$this->user->id)->find_all()->count();
		
		$view = 'account/view';
		$vars = array(
			'num_forms' => $num_forms,
		);
		$this->template->content = View::factory($view)->set($vars);
	}
	
	
	/**
	 * Update the current user's account info.
	 */
	public function action_edit()
	{
		$this->title = 'Update Profile';
		$errors = array();
		if ($_POST)
		{
			$this->user->username = $_POST['username'];
			$this->user->email = $_POST['email'];
			if (!empty($_POST['delete_logo']))
			{
				if ($this->user->logo)
				{
					unlink("images/logos/{$this->user->logo}");
					$this->user->logo = '';
				}
				if ($_FILES['logo']['name'])
				{
					$_FILES['logo'] = array();
				}
			}
			if ($this->user->check_edit())
			{
				// handle uploaded file
				if (!empty($_FILES['logo']['name']))
				{
					$logo = "logo_{$this->user->id}.".pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION);
					if (Upload::save($_FILES['logo'], $logo, "images/logos", 0666) === false)
					{
						$this->session->set($this->error_session_key, "Logo could not be uploaded. Please contact the site administrator.");
					}
					else
					{
						if (file_exists("images/logos/{$logo}"))
						{
							$this->user->logo = $logo;
						}
					}
				}
				$this->user->save();
				$this->session->set($this->success_session_key, "Account has been updated.");
				$this->request->redirect('account');
			}
			else
			{
				$errors = $this->user->validate()->errors('validate');
			}
		}
		$view = 'account/edit';
		$vars = array(
			'errors' => $errors,
		);
		$this->template->content = View::factory($view)->set($vars);
	}
	
	
	/**
	 * Change the current user's password.
	 */
	public function action_password()
	{
		$this->title = 'Change Password';
		$errors = array();
		if ($_POST)
		{
			if ($this->user->change_password($_POST))
			{
				$this->session->set($this->success_session_key, "Password has been changed.");
				$this->request->redirect('account');
			}
			else
			{
				$errors = $_POST->errors('validate');
			}
		}
		$view = 'account/password';
		$vars = array(
			'errors' => $errors,
		);
		$this->template->content = View::factory($view)->set($vars);
	}
	
	
	/**
	 * Change the current user's level
	 */
	public function action_level()
	{
		$this->title = 'Change Level';
		$errors = array();
		if ($_POST and $_POST['level_id'] != $this->user->level_id)
		{
			$this->user->level_id = $_POST['level_id'];
			if ($this->user->check_edit())
			{
				$this->user->save();
				$this->session->set($this->success_session_key, "You account level has been changed.");
				$this->request->redirect("account");
			}
			else
			{
				$errors = $this->user->validate()->errors('validate');
			}
		}
		$view = 'account/level';
		$vars = array(
			'levels' => ORM::factory('level')->find_all(),
			'errors' => $errors,
		);
		$this->template->content = View::factory($view)->set($vars);
	}
	
	
	/**
	 * @see parent::footer()
	 */
	protected function footer($vars = array())
	{
		$vars['action'] = $this->request->action;
		$vars['buttons'] = array();
		if ($vars['action'] != 'view' and $vars['action'] != 'index')
		{
			$vars['buttons'][] = array(
				'href' => URL::site('account'),
				'text' => 'View Account',
				'title' => 'Get a summary of your account',
				'id' => 'view',
			);
		}
		if ($vars['action'] != 'edit')
		{
			$vars['buttons'][] = array(
				'href' => URL::site('account/edit'),
				'text' => 'Update Profile',
				'title' => 'Make changes to your account profile and settings',
				'id' => 'edit',
			);
		}
		if ($vars['action'] != 'password')
		{
			$vars['buttons'][] = array(
				'href' => URL::site('account/password'),
				'text' => 'Change Password',
				'title' => 'Change your login password',
				'id' => 'password',
			);
		}
		if ($vars['action'] != 'level')
		{
			$vars['buttons'][] = array(
				'href' => URL::site('account/level'),
				'text' => 'Change Level',
				'title' => 'Change your account level',
				'id' => 'level',
			);
		}
		return parent::footer($vars);
	}
	
}
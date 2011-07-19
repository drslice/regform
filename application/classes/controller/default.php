<?php
/**
 * This is the default controller.
 */
class Controller_Default extends Controller_Base
{
	/**
	 * Displays the default index page.
	 */
	public function action_index()
	{
		$this->title = 'Welcome';
		$this->template->content = View::factory('index');
	}
	
	
	/**
	 * Attempts to login the user, shows the login form.
	 */
	public function action_login()
	{
		$this->title = 'Login';
		if (Auth::instance()->logged_in())
		{
			// try to go back to where user was before the login
			$uri = Session::instance()->get($this->uri_session_key, '/');
			Session::instance()->delete('requested_uri');
			Request::instance()->redirect($uri);
		}
		$user = ORM::factory('user');
		$errors = array();
		if ($_POST)
		{
			if (!empty($_POST['forgot_password']))
			{
				try
				{
					$user = ORM::factory('user')->where('username','=',$_POST['username'])->find();
					if (!$user->loaded())
					{
						throw new Exception("Unknown username.");
					}
					$arr['password'] = $user->generate_password();
					$arr['password_confirm'] = $arr['password'];
					if (!$user->change_password($arr))
					{
						throw new App_Exception("Could not change password.");
					}
					$subject = "Password Reset";
					$message = "The password for your account has been reset.\n";
					$message .= "Here is your updated login information:\n\n";
					$message .= "Username: {$user->username}\n";
					$message .= "Password: {$arr['password']}\n";
					App_Mail::send($user->email, $subject, $message);
					$this->session->set($this->success_session_key, "Your password has been reset and sent to your email address.");
				}
				catch (App_Exception $e)
				{
					$this->session->set($this->error_session_key, $e->getMessage());
				}
				catch (Exception $e)
				{
					$this->session->set($this->error_session_key, "Your password could not be reset automatically. Please contact the site support staff for assistance.");
				}
			}
			else if ($user->login($_POST))
			{
				// try to go back to where user was before the login
				$uri = $this->session->get($this->uri_session_key, '/form');
				$this->session->delete($this->uri_session_key);
				$this->request->redirect($uri);
			}
			else
			{
				$user->values($_POST);
				// $_POST is now a Validate object
				$errors = $_POST->errors('validate');
			}
		}
		$view = 'user/login';
		$vars = array(
			'user' => $user,
			'labels' => $user->labels(),
			'errors' => $errors,
		);
		$this->template->content = View::factory($view)->set($vars);
	}
	
	
	/**
	 * Logs out the user and redirects to main index page.
	 */
	public function action_logout()
	{
		Auth::instance()->logout();
		Request::instance()->redirect('/');
	}
	
	
	/**
	 * Sign up a new user.
	 */
	public function action_signup()
	{
		$this->title = 'Sign Up';
		$user = ORM::factory('user');
		$errors = array();
		if ($_POST)
		{
			$user->values($_POST);
			$user->level_id = Model_User::DEFAULT_LEVEL;
			if ($user->check())
			{
				$user->save(); // must save before adding relations
				$user->add('roles', ORM::factory('role', array('name'=>'login')));
				$this->session->set($this->success_session_key, "Your account is set up.");
				$user->login($_POST);
				$user->create_sample_form();
				$this->request->redirect('account');
			}
			else
			{
				$errors = $user->validate()->errors('validate');
			}
		}
		$view = 'account/signup';
		$vars = array(
			'user' => $user,
			'errors' => $errors,
		);
		$this->template->content = View::factory($view)->set($vars);
	}
	
	
	/**
	 * Shows an access denied page.
	 */
	public function action_access_denied()
	{
		$this->title = "Access Denied";
		$this->template->content = View::factory('access_denied');
	}
	
}
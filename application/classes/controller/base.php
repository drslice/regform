<?php
/**
 * Base controller for other application controllers
 */
class Controller_Base extends Controller_Template
{	
	/**
	 * @var string	path to template View
	 */
	public $template = 'templates/default';
	
	/**
	 * @var string	title of the page
	 */
	public $title = '';
	
	/**
	 * @var array	list of roles a user must have to be authorized to use this controller.
	 * if empty, access is allowed by default
	 */
	protected $auth_required = array();
	
	/**
	 * @var array	list of actions => roles required for access control at the action level
	 * if an action is not listed, access is allowed by default
	 */
	protected $auth_actions = array();
	
	/**
	 * @var string	name of session key to keep track of requested uri
	 */
	protected $uri_session_key = 'requested_uri';
	
	/**
	 * @var string	name of session key to keep track of errors (one-time-use only)
	 */
	protected $error_session_key = 'error';

	/**
	 * @var string	name of session key to keep track of notices (one-time-use only)
	 */
	protected $notice_session_key = 'notice';
	
	/**
	 * @var string	name of session key to keep track of success messages (one-time-use only)
	 */
	protected $success_session_key = 'success';
	
	/**
	 * @var object	currently logged in user
	 */
	public $user = null;
	
	/**
	 * @var object	session object
	 */
	public $session = null;
	
	/**
	 * @var object	auth object
	 */
	public $auth = null;
	
	
	/**
	 * Sets template and global view variables and checks authorization.
	 */
	public function before()
	{
		parent::before();
		
		// enable foreign key support if using sqlite
		if (Kohana::config('database.default.type') == 'pdo_sqlite')
		{
			DB::query(null, "PRAGMA foreign_keys = ON")->execute();
		}
		
		// start session
		$this->session = Session::instance();
		
		// start auth
		$this->auth = Auth::instance();
		
		// check for forced login (only if not in production mode)
		if (isset($_GET['force_login']) and Kohana::$environment != Kohana::PRODUCTION)
		{
			$this->auth->force_login($_GET['force_login']);
		}
		
		// setup the current user object
		if ($this->auth->logged_in())
		{
			// get the currently logged on user
			$this->user = $this->auth->get_user();
		}
		else
		{	// empty user
			$this->user = ORM::factory('user');
		}
		
		// assign global view variables
		View::bind_global('title', $this->title);
		View::bind_global('current_user', $this->user);
		$show_resources = $this->session->get('show_resources', 0);
		View::bind_global('show_resources', $show_resources);
		
		$action = $this->request->action;
		// check authorization for controller and action access
		if (($this->auth_required and $this->auth->logged_in($this->auth_required) === false)
			or (isset($this->auth_actions[$action]) and $this->auth->logged_in($this->auth_actions[$action]) === false)
		)
		{
			if ($this->auth->logged_in())
			{
				$this->request->redirect('access_denied');
			}
			else
			{
				$this->session->set($this->uri_session_key, $this->request->uri); 
				$this->request->redirect('login');
			}
		}
	}
	
	
	/**
	 * Sets template vars not set by the action.
	 */
	public function after()
	{
		$this->template->site_name = Kohana::config('app.site_name');
		
		// one-time session vars
		if ($notice = $this->session->get($this->notice_session_key, ''))
		{
			$this->session->delete($this->notice_session_key);
			$this->template->notice = $notice;
		}
		if ($error = $this->session->get($this->error_session_key, ''))
		{
			$this->session->delete($this->error_session_key);
			$this->template->error = $error;
		}
		if ($success = $this->session->get($this->success_session_key, ''))
		{
			$this->session->delete($this->success_session_key);
			$this->template->success = $success;
		}
		
		// if content is not set - use home page
		if (!isset($this->template->content))
		{
			$this->template->content = View::factory('templates/content');
		}
		
		// if footer is not set - use default footer
		if (!isset($this->template->footer))
		{
			$this->template->footer = $this->footer();
		}
		
		// find a resources view
		if (Kohana::find_file("views/{$this->request->controller}", "resources_{$this->request->action}"))
		{
			// views/controller/resources_action - specific help for the action
			$this->template->resources = View::factory("{$this->request->controller}/resources_{$this->request->action}");
		}
		else if (Kohana::find_file("views/{$this->request->controller}", "resources"))
		{
			// views/controller/resources - generic help for the controller
			$this->template->resources = View::factory("{$this->request->controller}/resources");
		}
		else
		{
			// views/templates/resources - no help
			$this->template->resources = View::factory('templates/resources');
		}
		
		parent::after();
	}
	
	
	/**
	 * Generates a View object for the footer.
	 * @param array $vars
	 * @return object View
	 */
	protected function footer($vars = array())
	{
		return View::factory('templates/footer')->set($vars);
	}
}
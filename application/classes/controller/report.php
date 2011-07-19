<?php
/**
 * This is the report controller for users to view/download reports.
 */
class Controller_Report extends Controller_Base
{
	const DEFAULT_PAGE_SIZE = 50;
	
	// must be logged in
	protected $auth_required = array('login');
	

	/**
	 * Execute default action: currently list.
	 */
	public function action_index()
	{
		$this->action_list();
	}
	
	
	/**
	 * List user's reports.
	 */
	public function action_list()
	{
		$this->title = 'My Reports';
		$forms_list = array();
		$reg = new Model_Reg;
		$forms = ORM::factory('form')->where('user_id','=',$this->user->id)->and_where('finalized','=',1);
		foreach ($forms->find_all() as $form)
		{
			$reg->table_name = $form->data_table;
			$forms_list[] = array(
				'id' => $form->id,
				'name' => $form->name,
				'reg' => $reg->count(),
			);
		}
		
		$view = 'report/list';
		$vars = array(
			'forms' => $forms_list,
			'labels' => $forms->labels(),
		);
		$this->template->content = View::factory($view)->set($vars);
	}
	
	
	/**
	 * View a report.
	 */
	public function action_view($id = 0)
	{
		$this->title = "Report";
		$form = ORM::factory('form', $id);
		if (!$form->loaded())
		{
			throw new Exception("Form not found: {$id}", 404);
		}
		$this->title .= ": {$form->name}";
		
		$reg = new Model_Reg;
		$reg->set_form($form);
		$reg->set_fields($form->fields->find_all());
		
		$order_by = isset($_GET['o']) ? $_GET['o'] : null;
		$order_dir = isset($_GET['d']) ? $_GET['d'] : null;
		$limit = isset($_GET['l']) ? $_GET['l'] : null;
		$page = isset($_GET['p']) ? $_GET['p'] : null;
		$offset = null;
		if ($limit and $page)
		{
			$offset = (int) $page * self::DEFAULT_PAGE_SIZE;
		}
		$params = array(
			'o' => $order_by,
			'd' => $order_dir,
			'l' => $limit,
			'p' => $page,
		);
		
		$view = 'report/view';
		$vars = array(
			'form' => $form,
			'reg' => $reg,
			'report' => $reg->report($order_by, $order_dir, $limit, $offset),
			'params' => $params,
			'action' => $this->request->action,
		);
		$this->template->content = View::factory($view)->set($vars);
		$this->template->footer = $this->footer($vars);
	} // END action_view()
	
	
	/**
	 * Download a report.
	 */
	public function action_download($id = 0)
	{
		$this->template = View::factory('templates/blank');
		$this->action_view($id);
		header("Content-Type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=report_{$this->user->id}_{$id}.xls");
		header("Pragma: no-cache");
		header("Expires: 0");
	}
	
	
	/**
	 * @see parent::footer()
	 */
	protected function footer($vars = array())
	{
		$vars['action'] = $this->request->action;
		$vars['buttons'] = array();
		if (isset($vars['form']) and $vars['form']->id and $vars['params'] and $vars['action'] == 'view')
		{
			$vars['buttons'][] = array(
				'href' => URL::site("report/download/{$vars['form']->id}").URL::query($vars['params']),
				'text' => 'Download',
				'title' => 'Download this report as a spreadsheet',
			);
		}
		if ($vars['action'] != 'list' and $vars['action'] != 'index')
		{
			$vars['buttons'][] = array(
				'href' => URL::site('report'),
				'text' => 'List Reports',
				'title' => 'Show list of available reports',
			);
		}
		return parent::footer($vars);
	} // END footer()
	
}
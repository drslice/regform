<?php
/**
 * This is the controller for generating HTML chunks for AJAX calls
 */
class Controller_Ajax extends Controller
{
	/**
	 * @var object	View object to render (this controller does not use the template)
	 */
	public $output = '';
	
	
	/**
	 * Renders and outputs the view then halts the application to prevent any further processing.
	 */
	public function after()
	{
		echo $this->output;
		exit;
	}
	
	
	/**
	 * Generates another field entry for the form editing form.
	 */
	public function action_form_edit_field()
	{
		if (!isset($_GET['num']))
		{
			die("No num specified.");
		}
		
		$field = ORM::factory('field');
		$field->num = $_GET['num'];
		$view = 'form/edit_field';
		$this->output = View::factory($view)->set('field',$field);
	}
	
	
	/**
	 * Generates options fields for addfield content.
	 */
	public function action_form_edit_field_settings()
	{
		$id = isset($_GET['id']) ? $_GET['id'] : 0;
		$num = isset($_GET['num']) ? $_GET['num'] : 0;
		$type = isset($_GET['type']) ? $_GET['type'] : 'text';
		
		if ($id)
		{
			$field = ORM::factory('field', $id);
			if (!$field->loaded())
			{
				die("Unknown field");
			}
		}
		else
		{
			if (!$num or !$type)
			{
				die("Num or Type was not specified.");
			}
			$field = ORM::factory('field');
			$field->num = $num;
			$field->type = $type;
		}
		
		$view = 'form/edit_field_settings';
		$this->output = View::factory($view)->set('field',$field);
	}
	
	
	/**
	 * Sets whether resources column is visible.
	 */
	public function action_show_resources()
	{
		$show_resources = isset($_GET['show_resources']) ? $_GET['show_resources'] : 0;
		Session::instance()->set('show_resources', $show_resources);
		exit;
	}
	
	
}
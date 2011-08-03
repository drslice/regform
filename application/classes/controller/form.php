<?php
/**
 * This is the controller for managing forms.
 */
class Controller_Form extends Controller_Base
{
	// must be logged in to use this controller
	protected $auth_required = array('login');
	
	// these are codes for the view action
	const FINALIZE = 1;
	const UNFINALIZE = 2;
	const PUBLISH = 3;
	const UNPUBLISH = 4;
	

	/**
	 * Execute default action: currently list
	 */
	public function action_index()
	{
		$this->action_list();
	}
	
	
	/**
	 * List user's forms.
	 */
	public function action_list()
	{
		$this->title = 'My Forms';
		$form = ORM::factory('form')->where('user_id','=',$this->user->id);
		
		$view = 'form/list';
		$vars = array(
			'forms' => $form->find_all(),
			'labels' => $form->labels(),
		);
		$this->template->content = View::factory($view)->set($vars);
	}
	
	
	/**
	 * Add a new form.
	 */
	public function action_add()
	{
		$this->action_edit();
	}
	
	
	/**
	 * Edit a form (or add a new one if id is not specified)
	 * @param int $id
	 */
	public function action_edit($id = 0)
	{
		if ($id)
		{
			$this->title = "Edit Form";
			$form = ORM::factory('form', $id);
			if (!$form->loaded())
			{
				$this->session->set($this->error_session_key, "Error: Form not found ({$id})");
				$this->request->redirect('form');
			}
		}
		else
		{
			$this->title = "Create a Form";
			$form = ORM::factory('form');
			$num_forms = $form->where('user_id','=',$this->user->id)->find_all()->count();
			if ($num_forms >= $this->user->level->max_forms)
			{
				$this->session->set($this->error_session_key, "You can not create a new form because you have reached the maximum number of forms for your account.");
				$this->request->redirect('form');
			}
		}
		$errors = array();
		if ($_POST and !$form->finalized)
		{
			$form->values($_POST);
			if (!$id)
			{
				$form->created = $_SERVER['REQUEST_TIME'];
				$form->user_id = $this->user->id;
				$check_method = 'check';
			}
			else
			{
				$check_method = 'check_edit';
			}
			
			if ($form->$check_method())
			{
				try
				{
					$required = false;
					$form->begin();
					$form->save();
					// delete all fields and re-add them
					ORM::factory('field')->where('form_id','=',$form->id)->delete_all();
					$num = 1;
					for ($num = 1; $num <= $this->user->level->max_fields; $num++)
					{
						if (!empty($_POST["field{$num}_name"]))
						{
							$id = isset($_POST["field{$num}_id"]) ? $_POST["field{$num}_id"] : null;
							$field = ORM::factory('field', $id);
							$field->num = $num;
							$field->form_id = $form->id;
							foreach (array('name','type','size','options','rows','cols','required') as $f)
							{
								if (isset($_POST["field{$num}_{$f}"]))
								{
									if ($f == 'required')
									{
										$required = true;
									}
									$field->$f = $_POST["field{$num}_{$f}"];
								}
							}
							$field->save();
						}
					}
					if (!$required)
					{
						throw new App_Exception("At least one field must be marked as required.");
					}
					$form->commit();
					$this->request->redirect("form/view/{$form->id}");
				}
				catch (App_Exception $e)
				{
					$form->rollback();
					$errors = array('name' => $e->getMessage());
				}
				catch (Exception $e)
				{
					$form->rollback();
					if (Kohana::$environment != 'production')
					{
						$errors = array('name' => $e->getMessage());
					}
					else
					{
						$errors = array('name' => 'an error occurred while saving this form');
					}
				}
			}
			else
			{
				$errors = $form->validate()->errors('validate');
			}
		}
		
		$view = 'form/edit';
		$vars = array(
			'form' => $form,
			'labels' => $form->labels(),
			'errors' => $errors,
		);
		$this->template->content = View::factory($view)->set($vars);
		$this->template->footer = $this->footer($vars);
	} // END action_edit()
	
	
	/**
	 * Deletes a form after a confirmation page.
	 * @param int $id
	 */
	public function action_delete($id = 0)
	{
		$this->title = "Delete Form";
		$form = ORM::factory('form', $id);
		if (!$form->loaded())
		{
			throw new Exception("Form not found: {$id}", 404);
		}
		if (isset($_GET['confirm']) and $_GET['confirm'] == 'yes')
		{
			$formname = $form->name;
			if ($form->finalized)
			{
				$form->unfinalize();
			}
			$form->delete();
			$this->session->set($this->success_session_key, "Form {$formname} has been deleted.");
			$this->request->redirect('form');
		}
		$view = 'form/delete';
		$vars = array(
			'form' => $form,
		);
		$this->template->content = View::factory($view)->set($vars);
		$this->template->footer = $this->footer($vars);
	} // END action_delete()
	
	
	/**
	 * View a form and optionally modify it's status
	 * @param int $id
	 */
	public function action_view($id = 0, $modify = 0)
	{
		$this->title = "Preview Form";
		$form = ORM::factory('form', $id);
		if (!$form->loaded())
		{
			$this->session->set($this->error_session_key, "Error: Form not found ({$id})");
			$this->request->redirect('form');
		}
		
		switch ($modify)
		{
			case self::FINALIZE:
				try
				{
					$form->finalize();
				}
				catch (Exception $e)
				{
					$this->template->error = "This form could not be finalized. Please contact the site administrator for assistance.";
					if (Kohana::$environment != Kohana::PRODUCTION)
					{
						$this->template->error .= "<br/>Exception Message: ".$e->getMessage();
						$this->template->error .= "in <b>".$e->getFile()."</b> on line <b>".$e->getLine()."</b>";
					}
				}
				break;
			case self::UNFINALIZE:
				$form->unfinalize();
				break;
			case self::PUBLISH:
				try
				{
					if ($this->user->level->id <= Model_Level::TRIAL)
					{
						throw new App_Exception("This form could not be published.\n<br/>Trial Level Accounts cannot publish forms.");
					}
					$form->published = 1;
					$form->save();
				}
				catch (App_Exception $e)
				{
					$this->template->error = $e->getMessage();
				}
				catch (Exception $e)
				{
					$this->template->error = "This form could not be published. ";
					if (Kohana::$environment != Kohana::PRODUCTION)
					{
						$this->template->error .= "\n<br/>Exception Message: ".$e->getMessage();
						$this->template->error .= "in <b>".$e->getFile()."</b> on line <b>".$e->getLine()."</b>";
					}
					else
					{
						$this->template->error .= "\n<br/>Please contact the site administrator for assistance.";
					}
				}
				break;
			case self::UNPUBLISH:
				$form->published = 0;
				$form->save();
				break;
		}
		
		$view = 'form/view';
		$vars = array(
			'form' => $form,
		);
		$this->template->content = View::factory($view)->set($vars);
		$this->template->footer = $this->footer($vars);
	} // END action_view()
	
	
	/**
	 * @see parent::footer()
	 */
	protected function footer($vars = array())
	{
		$vars['action'] = $this->request->action;
		$vars['buttons'] = array();
		if (isset($vars['form']) and $vars['form']->id)
		{
			$form = $vars['form'];
			if ($form->finalized)
			{
				if ($form->published)
				{
					$vars['buttons'][] = array(
						'href' => URL::site("form/view/{$form->id}/".Controller_Form::UNPUBLISH),
						'title' => 'Unpublish this form',
						'text' => 'Unpublish',
						'class' => 'unpublish',
					);
				}
				else
				{
					$vars['buttons'][] = array(
						'href' => URL::site("form/view/{$form->id}/".Controller_Form::UNFINALIZE),
						'title' => 'Unfinalize this form',
						'text' => "Unfinalize",
						'class' => 'unfinalize',
					);
					$vars['buttons'][] = array(
						'href' => URL::site("form/view/{$form->id}/".Controller_Form::PUBLISH),
						'title' => 'Publish this form',
						'text' => "Publish",
						'class' => 'publish',
					);
				}
			}
			else
			{
				$vars['buttons'][] = array(
					'href' => URL::site("form/view/{$form->id}/".Controller_Form::FINALIZE),
					'title' => 'Finalize this form',
					'text' => "Finalize",
					'class' => 'finalize',
				);
			}
			if ($vars['action'] != 'view')
			{
				$vars['buttons'][] = array(
					'href' => URL::site("form/view/{$form->id}"),
					'title' => 'Preview this form',
					'text' => "Preview",
				);
			}
			if ($vars['action'] != 'edit' and !$form->finalized)
			{
				$vars['buttons'][] = array(
					'href' => URL::site("form/edit/{$form->id}"),
					'title' => 'Edit this form',
					'text' => "Edit",
				);
			}
			if ($vars['action'] != 'delete')
			{
				$vars['buttons'][] = array(
					'href' => URL::site("form/delete/{$form->id}"),
					'title' => 'Delete this form',
					'text' => 'Delete',
				);
			}
		}
		if ($vars['action'] != 'add')
		{
			$vars['buttons'][] = array(
				'href' => URL::site('form/add'),
				'text' => 'New',
				'title' => 'Create a new form',
			);
		}
		if ($vars['action'] != 'list' and $vars['action'] != 'index')
		{
			$vars['buttons'][] = array(
				'href' => URL::site('form'),
				'text' => 'List',
				'title' => 'Show a list of your forms',
			);
		}
		return parent::footer($vars);
	} // END footer()
	
}
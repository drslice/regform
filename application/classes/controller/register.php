<?php
/**
 * This is the controller for recording registrations using published forms.
 */
class Controller_Register extends Controller_Base
{
	/**
	 * Execute default action: currently shows a summary blurb
	 */
	public function action_index()
	{
		$this->title = "Register";
		$view = 'register/index';
		$this->template->content = View::factory($view);
	}
	
	
	/**
	 * Show and process a registration form.
	 * @param int $id
	 */
	public function action_form($id = 0)
	{
		$this->title = "Registration";
		$form = ORM::factory('form', $id);
		if (!$form->loaded())
		{
			throw new Exception("Form not found: {$id}", 404);
		}
		if (!$form->published)
		{
			$this->template->content = "The requested form is not accessible right now because it has not been published.";
			return;
		}
		$this->title = $form->name;
		
		$fields = $form->fields->find_all();
		$errors = array();
		
		if ($_POST)
		{
			$reg = new Model_Reg;
			$reg->set_form($form);
			$reg->set_fields($fields);
			
			if ($reg->check($_POST))
			{
				// record the registration in the proper table
				$id = $reg->insert($_POST->as_array());
				if ($form->send_email)
				{
					$subject = "Registration Notification for: {$form->name}";
					$message = $this->mail_message($reg->get($id), $reg->labels);
					$headers = array('From' => $form->user->email);
					App_Mail::send($form->user->email, $subject, $message, $headers);
				}
				
				$view = 'register/complete';
				$vars = array(
					'reg' => $reg,
					'user' => $form->user,
				);
				$this->template->content = View::factory($view)->set($vars);
				return;
			}
			else
			{
				$errors = $_POST->errors('validate');
			}
		}
		
		$view = 'register/form';
		$vars = array(
			'form' => $form,
			'fields' => $fields,
			'errors' => $errors,
		);
		$this->template->content = View::factory($view)->set($vars);
	}
	
	
	/**
	 * Builds the email notification message body
	 * @param array $values
	 * @param array $labels
	 * @return string
	 */
	protected function mail_message($values, $labels)
	{
		$msg = "Registration Info\n\n";
		foreach ($values as $field => $value)
		{
			if ($field != Model_Reg::TIMESTAMP_COLUMN and isset($labels[$field]))
			{
				$msg .= "{$labels[$field]}: {$value}\n";
			}
		}
		return $msg;
	}
	
}
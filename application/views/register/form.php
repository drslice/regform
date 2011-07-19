<?php if ($form->user->logo): ?>
<image src="<?=URL::site("images/logos/{$form->user->logo}")?>"/><br/>
<?php endif ?>

<?php if ($errors) { echo View::factory('form_errors')->set('errors',$errors); }?>

<form method="post" name="form1" id="form1">

<fieldset class="form_fields">

<?php
foreach ($fields as $field)
{
	$fieldname = "field{$field->num}";
	$required = $field->required ? ' class="required"' : '';
	echo "<p>\n";
	echo "<label for=\"{$fieldname}\"{$required}>{$field->name}</label><br/>\n";
	switch ($field->type)
	{
		case 'text':
			echo "<input type=\"text\" name=\"{$fieldname}\" id=\"{$fieldname}\" size=\"{$field->size}\" maxlength=\"200\"/>\n";
			break;
		case 'textarea':
			echo "<textarea name=\"{$fieldname}\" id=\"{$fieldname}\" rows=\"{$field->rows}\" cols=\"{$field->cols}\"></textarea>\n";
			break;
		case 'select':
			echo "<select name=\"{$fieldname}\" id=\"{$fieldname}\">\n";
			foreach (explode(',', $field->options) as $option)
			{
				echo "<option value=\"{$option}\">{$option}</option>\n";
			}
			echo "</select>\n";
			break;
		case 'yesno':
			echo "<label><input type=\"radio\" name=\"{$fieldname}\" value=\"Yes\"> Yes</label>\n&nbsp;&nbsp;&nbsp;&nbsp;";
			echo "<label><input type=\"radio\" name=\"{$fieldname}\" value=\"No\"> No</label>\n";
			break;
	}
	echo "</p>\n";
}
?>

</fieldset>

<p>
<input type="submit" name="submit" id="submit" value="<?=$form->submit_value?>"/>
</p>

</form>
<br/>


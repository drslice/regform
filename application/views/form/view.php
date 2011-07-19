<div style="border: solid #000 1px; padding: 10px;">

<?php if ($current_user->logo): ?>
<image src="<?=URL::site("images/logos/{$current_user->logo}")?>"/><br/>
<?php endif ?>

<h2><?=$form->name?></h2>

<form name="form1" id="form1" class="disabled">

<fieldset class="form_fields">

<?php
foreach ($form->fields->find_all() as $field)
{
	$required = $field->required ? ' class="required"' : '';
	echo "<p>\n";
	echo "<label for=\"field{$field->num}\"{$required}>{$field->name}</label><br/>\n";
	switch ($field->type)
	{
		case 'text':
			echo "<input type=\"text\" name=\"field{$field->num}\" id=\"field{$field->num}\" size=\"{$field->size}\" maxlength=\"200\"/>\n";
			break;
		case 'textarea':
			echo "<textarea name=\"field{$field->num}\" id=\"field{$field->num}\" rows=\"{$field->rows}\" cols=\"{$field->cols}\"></textarea>\n";
			break;
		case 'select':
			echo "<select name=\"field{$field->num}\" id=\"field{$field->num}\">\n";
			foreach (explode(',', $field->options) as $option)
			{
				echo "<option value=\"{$option}\">{$option}</option>\n";
			}
			echo "</select>\n";
			break;
		case 'yesno':
			echo "<label><input type=\"radio\" name=\"field{$field->num}\" value=\"Yes\"> Yes</label>\n&nbsp;&nbsp;&nbsp;&nbsp;";
			echo "<label><input type=\"radio\" name=\"field{$field->num}\" value=\"No\"> No</label>\n";
			break;
	}
	echo "</p>\n";
}
?>

</fieldset>

<p>
<input type="submit" name="submit" id="submit" value="<?=$form->submit_value?>"/>
</p>

<p class="required">
: required
</p>

</form>
</div>

<br/>

<p class="success">
	<span class="large"><b>Summary:</b></span><br/>
Live Form Link: 
<a href="<?=URL::site("register/form/{$form->id}")?>"><?=URL::site("register/form/{$form->id}", true)?></a><br/>
<?php if ($form->send_email): ?>
Registrations will be emailed to you.<br/>
<?php else: ?>
Registrations will not be emailed to you.<br/>
<?php endif; ?>
<?php if ($form->finalized): ?>
	<?php if ($form->published): ?>
This form is currently finalized and published.<br/>
	<?php else: ?>
This form is currently finalized but unpublished.<br/>
	<?php endif ?>
<?php else: ?>
This form is currently unfinalized and unpublished.<br/>
<?php endif ?>
</p>

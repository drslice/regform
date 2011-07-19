<?php
$checked = $field->required ? ' checked="checked"' : '';
?>

<tr class="<?=$field->num % 2 ? 'rowOdd' : 'rowEven'?>">
	<td><input type="text" name="field<?=$field->num?>_name" id="field<?=$field->num?>_name" value="<?=$field->name?>"/></td>
	<td><select name="field<?=$field->num?>_type" id="field<?=$field->num?>_type" class="field_type">
		<option value="text"<?=$field->type == 'text' ? 'selected="selected"' : ''?>>Text</option>
		<option value="textarea"<?=$field->type == 'textarea' ? 'selected="selected"' : ''?>>Textbox</option>
		<option value="select"<?=$field->type == 'select' ? 'selected="selected"' : ''?>>Dropdown</option>
		<option value="yesno"<?=$field->type == 'yesno' ? 'selected="selected"' : ''?>>Yes/No</option>
		</select></td>
	<td id="field<?=$field->num?>_settings_wrapper">
		<?=View::factory('form/edit_field_settings')->set('field',$field)?></td>
	<td><input type="checkbox" name="field<?=$field->num?>_required" id="field<?=$field->num?>_required" value="1"<?=$checked?>/></td>
</tr>

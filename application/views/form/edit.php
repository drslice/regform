<?php if ($form->finalized): ?>

<p>
	This form can not be modified because it has been Finalized.
</p>

<p>
	<a href="<?=URL::site("form/view/{$form->id}")?>">Go Back to Form Preview</a>
</p>

<?php else: ?>

<?=View::factory('form_errors')->set('errors',$errors)?>

<form name="form1" id="form1" method="post">

<fieldset>

<p>
<label for="name" class="required"><?=$labels['name']?>:</label>
<input type="text" name="name" id="name" value="<?=$form->name?>" maxlength="50" size="50"/>
</p>

<fieldset>
	<legend>Fields</legend>

<table id="fields">
<tbody>
<tr class="header">
	<th>Field Label</th>
	<th>Type</th>
	<th>Settings</th>
	<th>Required</th>
</tr>

<?php
$field_num = 1;

// add existing fields
foreach ($form->fields->order_by('num')->find_all() as $field)
{
	$field->num = $field_num++;
	echo View::factory('form/edit_field')->set('field',$field);
}
if ($field_num <= $current_user->level->max_fields)
{
	// add a blank field
	$field = ORM::factory('field');
	$field->num = $field_num++;
	echo View::factory('form/edit_field')->set('field',$field);
}
?>
</tbody>
<?php if ($field_num < $current_user->level->max_fields):?>
<tfoot>
<tr id="addfield_row">
	<td colspan="4"><a href="#" class="button" id="addfield">Add Another Field</a></td>
</tr>
</tfoot>
<?php endif ?>
</table>

</fieldset>

<p class="required">
<label for="submit_value"><?=$labels['submit_value']?>:</label>
<input type="text" name="submit_value" id="submit_value" value="<?=$form->submit_value?>" maxlength="20" size="20"/>
</p>

<p>
<label for="send_email"><?=$labels['send_email']?>:</label>
<select name="send_email" id="send_email">
	<option value="0"<?=$form->send_email ? '' : ' selected="selected"'?>>No</option>
	<option value="1"<?=$form->send_email ? ' selected="selected"' : ''?>>Yes</option>
</select>
</p>

<p>
<input type="submit" name="submit" id="submit" value="Save"/>
<input type="reset" name="reset" id="reset" value="Reset"/>
</p>

<p class="required">
: required
</p>

</fieldset>

</form>

<p class="notice" id="max_fields">
	<b>Notice:</b> You can not add any more fields to this form.
</p>

<p class="success">
	If you want to remove a field from the form, just leave it blank.
</p>


<script>
var next = <?=$field_num?>;
$(function() {
	$("#max_fields").hide();
	$("#addfield").click(function(){
		if (next == <?=$current_user->level->max_fields?>){
			$("#addfield_row").slideUp();
		}
		else if (next > <?=$current_user->level->max_fields?>){
			$("#max_fields").slideDown();
			return false;
		}
		$.ajax({
			url: "<?=URL::site("ajax/form_edit_field")?>?num="+next,
			type: "get",
			error: ajaxError,
			success: function (html){
				$("#fields tbody>tr:last").after(html);
				next += 1;
			}
		});
		return false;
	});
	// make future change events work for field options
	$(".field_type").live("change", function(){
		show_settings(this);
	});
});
// used by add_field view
function show_settings(obj){
	var num = obj.name.replace("field", "").replace("_type", "");
	var type = obj.value;
	$("#field"+num+"_settings_wrapper").load("<?=URL::site("ajax/form_edit_field_settings")?>?num="+num+"&type="+type);
}
</script>

<?php endif ?>

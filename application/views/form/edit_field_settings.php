<?php
switch ($field->type)
{
	case 'text':
		$options = '';
		for ($i=10;$i<=50;$i+=10)
		{
			$selected = $field->size == $i ? ' selected="selected"' : '';
			$options .= "<option value=\"{$i}\"{$selected}>{$i}</option>\n";
		}
		echo <<<EOD
<label for="field{$field->num}_size">Length:</label>
<select name="field{$field->num}_size" id="field{$field->num}_size">
{$options}
</select>
EOD;
		break;

	case 'textarea':
		$options_cols = $options_rows = '';
		for ($i=20;$i<=80;$i+=10)
		{
			$selected = $field->cols == $i ? ' selected="selected"' : '';
			$options_cols .= "<option value=\"{$i}\"{$selected}>{$i}</option>\n";
		}
		for ($i=3;$i<=10;$i++)
		{
			$selected = $field->rows == $i ? ' selected="selected"' : '';
			$options_rows .= "<option value=\"{$i}\"{$selected}>{$i}</option>\n";
		}
		echo <<<EOD
<label for="field{$field->num}_rows">Height:</label>
<select name="field{$field->num}_rows" id="field{$field->num}_rows">
{$options_rows}
</select>
&nbsp;&nbsp;
<label for="field{$field->num}_cols">Width:</label>
<select name="field{$field->num}_cols" id="field{$field->num}_cols">
{$options_cols}
</select>
EOD;
		break;

	case 'select':
		echo <<<EOD
<label for="field{$field->num}_options" style="vertical-align:top">Options</label>
<textarea name="field{$field->num}_options" id="field{$field->num}_options" rows="2" cols="40"/>
{$field->options}
</textarea>
EOD;
		break;
}

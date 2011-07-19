<?php if (count($report)): ?>

<table>
<tr>
<?php
foreach ($reg->fields as $f)
{
	$params_tmp = array('o'=>$f)+$params;
	$params_tmp['d'] = '';
	$arrow = '&nbsp;&nbsp;';
	if ($params['o'] == $f or ($f == 'reg_time' and !$params['o']))
	{
		if ($params['d'] != 'd')
		{
			$params_tmp['d'] = 'd';
			$arrow = '&nbsp;&uarr;';
		}
		else
		{
			$arrow = '&nbsp;&darr;';
		}
	}
	if ($action == 'view')
	{
		$url = URL::site("report/view/{$form->id}").URL::query($params_tmp);
		$header = "<a href=\"{$url}\">{$reg->labels[$f]}{$arrow}</a>";
	}
	else
	{
		$header = $reg->labels[$f];
	}
	echo "\t<th>{$header}</th>\n";
}
?>
</tr>
<?php foreach ($report as $row)
{
	echo "<tr>\n";
	foreach ($reg->fields as $f)
	{
		if ($f == Model_Reg::TIMESTAMP_COLUMN)
		{
			$data = date('Y-m-d H:m:s', $row[$f]);
		}
		else
		{
			if ($reg->table_columns[$f] == 'yesno')
			{
				
			}
			else
			{
				$data = htmlentities($row[$f]);
			}
		}
		echo "\t<td>{$data}</td>\n";
	}
	echo "</tr>\n";
}
?>
</table>

<?php else: ?>

<p>
	No registrations have been made for this form.
</p>

<?php endif ?>
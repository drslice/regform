<?php
$labels = $current_user->labels();
?>

<table>
<tr>
	<td class="label"><?=$labels['username']?>:</td>
	<td><?=$current_user->username?></td>
</tr>
<tr>
	<td class="label"><?=$labels['email']?>:</td>
	<td><?=$current_user->email?></td>
</tr>
<tr>
	<td class="label">Logo Uploaded:</td>
	<td><?=$current_user->logo ? 'Yes' : 'No'?></td>
</tr>
<tr>
	<td class="label">Level:</td>
	<td><?=$current_user->level->name?></td>
</tr>
<tr>
	<td class="label">Forms Created:</td>
	<td><?=$num_forms?> out of <?=$current_user->level->max_forms?></td>
</tr>
</table>

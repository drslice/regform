<table>
<tr>
	<td>ID:</td>
	<td><?=$user->id?></td>
</tr>
<tr>
	<td>Username:</td>
	<td><?=$user->username?></td>
</tr>
<tr>
	<td>Email:</td>
	<td><?=$user->email?></td>
</tr>
<tr>
	<td>Logins:</td>
	<td><?=$user->logins?></td>
</tr>
<tr>
	<td>Last Login:</td>
	<td><?php if ($user->last_login) echo date('Y-m-d H:m:s', $user->last_login)?></td>
</tr>
<tr>
	<td>Roles:</td>
	<td><?php foreach ($user->roles->find_all() as $role) { echo "{$role->name}<br/>"; }?>
	</td>
</tr>
<tr>
	<td>Level:</td>
	<td><?=$user->level->name?></td>
</tr>
</table>

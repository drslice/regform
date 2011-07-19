<?php if ($users->count()): ?>

<table>
<tr>
	<th>ID</th>
	<th><?=$labels['username']?></th>
	<th><?=$labels['email']?></th>
	<th>&nbsp;</th>
	<th>&nbsp;</th>
</tr>
<?php foreach ($users as $user): ?>
<tr>
	<td><?=$user->id?></td>
	<td><a href="<?=URL::site("user/view/{$user->id}")?>"><?=$user->username?></a></td>
	<td><?=$user->email?></td>
	<td><a href="<?=URL::site("user/edit/{$user->id}")?>" class="button">Edit</a></td>
	<td><a href="<?=URL::site("user/delete/{$user->id}")?>" class="button">Delete</a></td>
</tr>
<?php endforeach ?>
</table>

<?php else: ?>

<p>
	No users found.
</p>

<?php endif ?>

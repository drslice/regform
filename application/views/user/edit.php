<?=View::factory('form_errors')->set('errors',$errors)?>

<form action="" name="form1" method="post">

<fieldset id="edit">

<p>
<label for="username" class="required">Username</label>
<br/>
<input type="text" name="username" id="username" value="<?=$user->username?>" maxlength="200" size="50"/>
</p>

<p>
<label for="email" class="required">Email</label>
<br/>
<input type="text" name="email" id="email" value="<?=$user->email?>" maxlength="200" size="50"/>
</p>

<p>
<label for="level_id">Level</label>
<br/>
<select name="level_id" id="level_id">
<?php
foreach ($levels as $level)
{
	$selected = $current_user->level_id === $level->id ? " selected=\"selected\"" : '';
	echo "<option value=\"{$level->id}\"{$selected}>{$level->name}</option>\n";
}
?>
</select>
</p>

<p>
<label for="roles">Roles</label>
<br/>
<?php foreach($roles as $role): ?>
<?php $checked = $user->has('roles', ORM::factory('role', $role->id)) ? ' checked="checked"' : ''?>
<input type="checkbox" name="roles[<?=$role->id?>]" id="roles-<?=$role->id?>" value="<?=$role->id?>"<?=$checked?>/>
<label for="roles-<?=$role->id?>"><?=$role->name?></label>
<br/>
<?php endforeach;?>
</p>

<p>
<input type="submit" name="submit" id="submit" value="Update User"/>
</p>

<p class="required">
: required
</p>

</fieldset>

</form>

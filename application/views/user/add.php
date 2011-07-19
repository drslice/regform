<?=View::factory('form_errors')->set('errors',$errors)?>

<form action="" name="form1" method="post">

<fieldset id="create">

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
<label for="password" class="required">Password</label>
<br/>
<input type="password" name="password" id="password" value="" maxlength="50" size="50"/>
</p>

<p>
<label for="password_confirm" class="required">Confirm Password</label>
<br/>
<input type="password" name="password_confirm" id="password_confirm" value="" maxlength="200" size="50"/>
</p>

<p>
<label for="level_id">Level</label>
<br/>
<select name="level_id" id="level_id">
<?php
foreach ($levels as $level)
{
	echo "<option value=\"{$level->id}\">{$level->name}</option>\n";
}
?>
</select>
</p>


<p>
<label for="roles">Roles</label>
<br/>
<?php foreach($roles as $role) :?>
<?php $checked = $role->name == 'login' ? ' checked="checked"' : ''?>
<input type="checkbox" name="roles[]" id="roles-<?=$role->id?>" value="<?=$role->id?>"<?=$checked?>/>
<label for="roles-<?=$role->id?>"><?=$role->name?></label>
<br/>
<?php endforeach;?>
</p>

<p>
<input type="submit" name="submit" id="submit" value="Create New User"/>
</p>

<p class="required">
: required
</p>

</fieldset>

</form>

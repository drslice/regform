<?=View::factory('form_errors')->set('errors',$errors)?>

<form action="" name="form1" method="post" enctype="multipart/form-data">

<fieldset>

<p>
<label for="username" class="required">Username</label>
<br/>
<input type="text" name="username" id="username" value="<?=$current_user->username?>" maxlength="200" size="50"/>
</p>

<p>
<label for="email" class="required">Email</label>
<br/>
<input type="text" name="email" id="email" value="<?=$current_user->email?>" maxlength="200" size="50"/>
</p>

<p>
<label for="logo">New Logo/Banner Graphic</label>
<br/>
<input type="file" name="logo" id="logo"/>
<br/>
<span class="small">
	Logo/Banner must be an image of type gif, jpg or png and be less than <?=Model_User::MAX_LOGO_SIZE?>B in size.
</span>
<br/>
Current Logo/Banner:<br/>
<?php if ($current_user->logo): ?>
<image src="<?=URL::site("images/logos/{$current_user->logo}")?>"/>
<?php else: ?>
(no logo)
<?php endif ?>
</p>

<p>
<label for="delete_logo">Delete Logo/Banner</label>
<br/>
<select name="delete_logo" id="delete_logo">
	<option value="0">No</option>
	<option value="1">Yes</option>
</select>
</p>

<p>
<input type="submit" name="submit" id="submit" value="Update"/>
</p>

<p class="required">
: required
</p>

</fieldset>

</form>

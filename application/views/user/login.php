<?=View::factory('form_errors')->set('errors',$errors)?>

<form action="" name="form1" method="post">

<fieldset id="login">

<p>
<label for="username" class="required"><?=$labels['username']?></label>
<br/>
<input type="text" name="username" id="username" value="<?=$user->username?>" maxlength="200" size="50"/>
</p>

<p>
<label for="password" class="required"><?=$labels['password']?></label>
<br/>
<input type="password" name="password" id="password" value="<?=$user->password?>" maxlength="200" size="50"/>
</p>

<p>
<input type="checkbox" name="forgot_password" id="forgot_password" value="1"/>
<label for="forgot_password">I forgot my password</label>
</p>

<p>
<input type="submit" name="submit" id="submit" value="Login"/>
</p>

<p class="required">
: required
</p>

</fieldset>

</form>

<p>
When you sign up, your account will be set at the Trial level.
You will be able to create and edit forms but you will not be able to publish them to enable live registrations.
You can change your account level at any time after you have signed up.
</p>

<?=View::factory('form_errors')->set('errors',$errors)?>

<form name="form1" id="form1" method="post">

<fieldset>

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
<input type="password" name="password_confirm" id="password_confirm" value="" maxlength="50" size="50"/>
</p>

<p>
<input type="submit" name="submit" id="submit" value="Sign Me Up"/>
</p>

<p class="required">
: required
</p>

</fieldset>

</form>

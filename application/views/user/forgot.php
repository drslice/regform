<?=View::factory('form_errors')->set('errors',$errors)?>

<form action="" name="form1" method="post">

<fieldset id="password">

<p>
<label for="password" class="required">New Password</label>
<br/>
<input type="password" name="password" id="password" value="" maxlength="50" size="50"/>
</p>

<p>
<label for="password_confirm" class="required">Confirm New Password</label>
<br/>
<input type="password" name="password_confirm" id="password_confirm" value="" maxlength="50" size="50"/>
</p>

<p>
<input type="submit" name="submit" id="submit" value="Change Password"/>
</p>

<p class="required">
: required
</p>

</fieldset>

</form>

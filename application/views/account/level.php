<?=View::factory('form_errors')->set('errors',$errors)?>

<form action="" name="form1" method="post">

<fieldset>

<p>
<label>Choose your Account Level</label>
</p>

<?php foreach ($levels as $level): ?>
<?php $checked = $current_user->level_id == $level->id ? ' checked="checked"' : ''?>
<p>
<input type="radio" name="level_id" id="level_<?=$level->name?>" value="<?=$level->id?>"<?=$checked?>/>
<label for="level_<?=$level->name?>"><?=$level->name?>: $<?=$level->price?>/month</label>
<br/>
<?=$level->descr?>
</p>
<?php endforeach ?>

<p>
<input type="submit" name="submit" id="submit" value="Change Level"/>
</p>

<p class="required">
: required
</p>

</fieldset>

</form>

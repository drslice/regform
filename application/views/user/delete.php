<p>
Deleting <?=$user->username?>
</p>

<p>
Are you sure you want to delete this user?
</p>

<p>
<a href="<?=URL::query(array('confirm'=>'yes'))?>" class="button">Yes</a>
<a href="<?=URL::site("user/view/{$user->id}")?>" class="button">No</a>
</p>

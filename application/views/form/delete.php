<p class="notice">
You are about to delete <b><?=$form->name?></b>
</p>

<p class="error">
Are you sure you want to delete this form?
</p>

<p class="wrapper">
<a href="<?=URL::query(array('confirm'=>'yes'))?>" class="button">Yes</a>
<a href="<?=URL::site("form/view/{$form->id}")?>" class="button">No</a>
</p>

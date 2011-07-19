<?php if ($total = $forms->count()): ?>

<table>
<tr>
	<th>Name</th>
	<th>&nbsp;</th>
	<th>&nbsp;</th>
	<th>&nbsp;</th>
	<th>&nbsp;</th>
	<th>&nbsp;</th>
</tr>
<?php foreach ($forms as $form): ?>
<tr>
	<td><a href="<?=URL::site("form/view/{$form->id}")?>"><?=$form->name?></a></td>
	<td><a href="<?=URL::site("form/view/{$form->id}")?>" class="button">View</a></td>
	<?php if ($form->finalized): ?>
	<td>----</td>
	<td>----</td>
	<td><a href="<?=URL::site("form/view/{$form->id}/".Controller_Form::UNFINALIZE)?>" class="button unfinalize">Unfinalize</a></td>
		<?php if ($form->published): ?>
	<td><a href="<?=URL::site("form/view/{$form->id}/".Controller_Form::UNPUBLISH)?>" class="button unpublish">Unpublish</a></td>
		<?php else: ?>
	<td><a href="<?=URL::site("form/view/{$form->id}/".Controller_Form::PUBLISH)?>" class="button publish">Publish</a></td>
		<?php endif ?>
	<?php else: ?>
	<td><a href="<?=URL::site("form/edit/{$form->id}")?>" class="button edit">Edit</a></td>
	<td><a href="<?=URL::site("form/delete/{$form->id}")?>" class="button delete">Delete</a></td>
	<td><a href="<?=URL::site("form/view/{$form->id}/".Controller_Form::FINALIZE)?>" class="button finalize">Finalize</a></td>
	<td>----</td>
	<?php endif ?>
</tr>
<?php endforeach ?>
</table>

<p>
	You have created <?=$total?> out of your maximum of <?=$current_user->level->max_forms?> forms.
</p>

<?php else: ?>

<p>
	You have not created any forms yet.
</p>

<?php endif ?>

<?php if ($forms): ?>

<table>
<tr>
	<th>Form Name</th>
	<th>Registrations</th>
	<th>&nbsp;</th>
	<th>&nbsp;</th>
</tr>
<?php foreach ($forms as $form): ?>
<tr>
	<td><a href="<?=URL::site("report/view/{$form['id']}")?>"><?=$form['name']?></a></td>
	<td><?=$form['reg']?></td>
	<td><a href="<?=URL::site("report/view/{$form['id']}")?>" class="button" title="View this report">View</a></td>
	<td><a href="<?=URL::site("report/download/{$form['id']}")?>" class="button" title="Download this report as a spreadsheet">Download</a></td>
</tr>
<?php endforeach ?>
</table>

<?php else: ?>

<p>
	You do not have any finalized forms. In order to see a form's report it must be finalized.
</p>

<?php endif ?>


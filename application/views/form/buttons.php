<?php
if (!isset($action))
{
	$action = '';
}
$buttons = array();
if (isset($form) and $form->id)
{
	if ($form->finalized)
	{
		if ($form->published)
		{
			$buttons[] = array(
				'url' => URL::site("form/view/{$form->id}/".Controller_Form::UNPUBLISH),
				'title' => 'Unpublish this form',
				'text' => 'Unpublish',
				'id' => 'unpublish',
			);
		}
		else
		{
			$buttons[] = array(
				'url' => URL::site("form/view/{$form->id}/".Controller_Form::UNFINALIZE),
				'title' => 'Unfinalize this form',
				'text' => "Unfinalize",
				'id' => 'unfinalize',
			);
			$buttons[] = array(
				'url' => URL::site("form/view/{$form->id}/".Controller_Form::PUBLISH),
				'title' => 'Publish this form',
				'text' => "Publish",
				'id' => 'publish',
			);
		}
	}
	else
	{
		$buttons[] = array(
			'url' => URL::site("form/view/{$form->id}/".Controller_Form::FINALIZE),
			'title' => 'Finalize this form',
			'text' => "Finalize",
			'id' => 'finalize',
		);
	}
	
	if ($action != 'view')
	{
		$buttons[] = array(
			'url' => URL::site("form/view/{$form->id}"),
			'title' => 'Preview this form',
			'text' => "Preview",
			'id' => 'preview',
		);
	}
	if ($action != 'edit')
	{
		$buttons[] = array(
			'url' => URL::site("form/edit/{$form->id}"),
			'title' => 'Edit this form',
			'text' => "Edit",
			'id' => 'edit',
		);
	}
	if ($action != 'delete')
	{
		$buttons[] = array(
			'url' => URL::site("form/delete/{$form->id}"),
			'title' => 'Delete this form',
			'text' => 'Delete',
			'id' => 'delete',
		);
	}
}
if ($action != 'add')
{
	$buttons[] = array(
		'url' => URL::site("form/add"),
		'title' => 'Create a new form',
		'text' => 'New',
		'id' => 'new',
	);
}

if ($action != 'list' and $action != 'index')
{
	$buttons[] = array(
		'url' => URL::site("form"),
		'title' => 'List forms',
		'text' => 'List',
		'id' => 'list',
	);
}
?>
<p>
<?php foreach ($buttons as $b): ?>
<a href="<?=$b['url']?>" class="button" id="<?=$b['id']?>" title="<?=$b['title']?>"><?=$b['text']?></a>
<?php endforeach ?>
</p>
<script>
$(function() {
	$("#finalize").click(function(){
		return confirm("You will no longer be able to modify this form! Are you sure you want to Finalize this form?");
	});
	$("#unfinalize").click(function(){
		return confirm("All data captured by this form will be deleted! Are you sure you want to Unfinalize this form?");
	});
	$("#publish").click(function(){
		return confirm("This form will be available to take registrations. Are you sure you want to Publish this form?");
	});
	$("#unpublish").click(function(){
		return confirm("This form will no longer be available to take registrations. Aare you sure you want to Unpublish this form?");
	});
});
</script>

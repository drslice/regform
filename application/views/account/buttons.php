<?php
if (!isset($action))
{
	$action = '';
}
$buttons = array();
$buttons[] = array(
	'url' => URL::site('account/edit'),
	'text' => 'Update Profile',
);
$buttons[] = array(
	'url' => URL::site('account/password'),
	'text' => 'Change Password',
);
?>

<p>
<?php foreach ($buttons as $b): ?>
<a href="<?=$b['url']?>" class="button" id="<?=$b['id']?>" title="<?=$b['title']?>"><?=$b['text']?></a>
<?php endforeach ?>
</p>

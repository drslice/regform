<ul class="tabs">
<?php if (isset($buttons))
{
	foreach ($buttons as $b)
	{
		$text = $b['text'];
		unset($b['text']);
		$link = "<a ".HTML::attributes($b).">{$text}</a>";
		echo "<li>{$link}</li>\n";
	}
}
?>
</ul>
<br/>
<p class="quiet">
<small><!--copyright notice could go here--></small>
</p>
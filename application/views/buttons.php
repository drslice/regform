<p class="wrapper">
<?php
foreach ($buttons as $b)
{
	$text = $b['text'];
	unset($b['text']);
	$b['class'] = "button";
	echo "<a ".HTML::attributes($b).">{$text}</a>\n";
}
?>
</p>

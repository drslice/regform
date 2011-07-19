<?php
if ($errors)
{
	echo "<p class=\"error\">There was a problem with your form submission:\n";
	echo "<ul>\n";
	foreach ($errors as $field => $error)
	{
		if (is_string($error))
		{
			echo "<li>{$error}</li>\n";
		}
		else
		{
			echo "<li>{$field} is invalid</li>\n";
		}
	}
	echo "</ul>\n</p>\n";
}

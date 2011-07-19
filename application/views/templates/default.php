<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<link href="<?=URL::site('/styles/screen.css')?>" rel="stylesheet" type="text/css" media="screen" charset="utf-8"/>
<link href="<?=URL::site('/styles/print.css')?>" rel="stylesheet" type="text/css" media="print" charset="utf-8"/>
<!--[if lte IE 6]><link href="<?=URL::site('/styles/ie.css')?>" rel="stylesheet" type="text/css" media="screen" charset="utf-8"><![endif]-->
<script src="<?=URL::site('/scripts/jquery-1.4.2.min.js')?>"></script>
<script>
$(function(){
	if ("<?=$show_resources?>" == "1"){
		$("#resources").show();
	}
	else{
		$("#resources").hide();
	}
	$("#show_resources").click(function(){
		$("#resources").slideDown("slow");
		$.get("<?=URL::site("ajax/show_resources")?>?show_resources=1");
		$("#help a").toggle();
		return false;
	});
	$("#hide_resources").click(function(){
		$("#resources").slideUp("fast");
		$.get("<?=URL::site("ajax/show_resources")?>?show_resources=0");
		$("#help a").toggle();
		return false;
	});
	/*
	$("a.resources").click(function(){
		if ($(this).text() == "Show Help"){
			$("#resources").slideDown();
			//$(this).text("Hide Help");
			$.get("<?=URL::site("ajax/show_resources")?>?show_resources=1");
		}
		else{
			$("#resources").slideUp();
			//$(this).text("Show Help");
			$.get("<?=URL::site("ajax/show_resources")?>?show_resources=0");
		}
		$("resources a").toggle();
		return false;
	});
	*/
	$("a.finalize").click(function(){
		return confirm("You will no longer be able to modify this form! Are you sure you want to Finalize this form?");
	});
	$("a.unfinalize").click(function(){
		return confirm("All data captured by this form will be deleted! Are you sure you want to Unfinalize this form?");
	});
	$("a.publish").click(function(){
		return confirm("This form will be available to take registrations. Are you sure you want to Publish this form?");
	});
	$("a.unpublish").click(function(){
		return confirm("This form will no longer be available to take registrations. Are you sure you want to Unpublish this form?");
	});
	$("form.disabled").submit(function(){
		return false;
	});
});
function ajaxError(xhr, status, errorThrown){
	$("#content").append('<p class="error">'+xhr.responseText+'</p>');
}
</script>
<title><?=$title.' - '.$_SERVER['SERVER_NAME']?></title>
</head>

<body>
<h1><?=$site_name?></h1>

<div id="head">
<ul class="tabs">
<?php if ($current_user->loaded()): ?>
<li><a href="<?=URL::site('form')?>" title="Manage and create forms">My Forms</a></li>
<li><a href="<?=URL::site('report')?>" title="View and download reports for published forms">My Reports</a></li>
<li><a href="<?=URL::site('account')?>" title="Manage your account setttings">My Account</a></li>
	<?php if ($current_user->has('roles', new Model_Role(array('name'=>'admin')))): ?>
<li><a href="<?=URL::site('user')?>" title="Manage all user accounts">Manage Users</a></li>
	<?php endif ?>
<li><a href="<?=URL::site('logout')?>" title="Logout of your account on this site">Logout</a></li>
<?php else: ?>
<li><a href="<?=URL::site('/')?>" title="Return to the main page">Home</a></li>
<li><a href="<?=URL::site('signup')?>" title="Create a new account on this site">Sign Up</a></li>
<li><a href="<?=URL::site('login')?>" title="Login to your account on this site">Login</a></li>
<?php endif ?>
<!--<li><a href="#" class="resources" title="Show or Hide the help panel"><?=$show_resources ? 'Hide Help' : 'Show Help'?></a></li>-->
</ul>
</div> <!-- END head -->

<div id="content" class="wrapper">
	
<h2><?=$title?></h2>

<?php if (!empty($error)): ?>
<p id="errorbox" class="error"><?=$error?></p>
<?php endif ?>

<?php if (!empty($notice)): ?>
<p id="noticebox" class="notice"><?=$notice?></p>
<?php endif ?>

<?php if (!empty($success)): ?>
<p id="successbox" class="success"><?=$success?></p>
<?php endif ?>

<?=$content?>

</div> <!-- END content -->

<div id="foot">
<?=$footer?>
</div> <!-- END foot -->

<div id="help">
<div id="resources">
<?=$resources?>
<p>
	If you need more help or have a question, please email us at <a href="mailto:support@<?=$_SERVER['SERVER_NAME']?>">support@<?=$_SERVER['SERVER_NAME']?></a>.
</p>
</div>
<a href="#" class="resources" id="show_resources" title="Show the help panel" <?=$show_resources ? 'style="display:none"' : ''?>>Show the Help Panel</a>
<a href="#" class="resources" id="hide_resources" title="Hide the help panel" <?=$show_resources ? '' : 'style="display:none"'?>>Hide the Help Panel</a>
</div> <!-- END help -->

</body>
</html>
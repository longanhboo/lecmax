<!DOCTYPE html>
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">
<head>
	<meta charset="UTF-8" />
	<title><?php echo $title; ?></title>
	<base href="<?php echo $base; ?>" />
	<?php if ($description) { ?>
	<meta name="description" content="<?php echo $description; ?>" />
	<?php } ?>
	<?php if ($keywords) { ?>
	<meta name="keywords" content="<?php echo $keywords; ?>" />
	<?php } ?>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
	<link rel="SHORTCUT ICON" href="<?php echo HTTP_CATALOG?>catalog/view/theme/default/images/favicon.ico">
	<link type="text/css" href="view/stylesheet/font-awesome.css"  rel="stylesheet" />
	<link type="text/css" href="view/stylesheet/responsive.css"  rel="stylesheet" media="screen"/>
	<link type="text/css" href="view/stylesheet/summernote.css" rel="stylesheet" media="screen"/>
	<link type="text/css" href="view/stylesheet/bootstrap-datetimepicker.css" rel="stylesheet" media="screen" />
	<link type="text/css" href="view/stylesheet/stylesheet.css" rel="stylesheet" media="screen" />
	<script type="text/javascript" src="view/javascript/jquery-2.1.1.min.js"></script>
	<script type="text/javascript" src="view/javascript/bootstrap.min.js"></script>
	<script type="text/javascript" src="view/javascript/summernote.js"></script>
	<script type="text/javascript" src="view/javascript/moment.js"></script>
	<script type="text/javascript" src="view/javascript/bootstrap-datetimepicker.min.js" ></script>

	<?php foreach ($styles as $style) { ?>
	<link type="text/css" href="<?php echo $style['href']; ?>" rel="<?php echo $style['rel']; ?>" media="<?php echo $style['media']; ?>" />
	<?php } ?>
	<?php foreach ($links as $link) { ?>
	<link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>" />
	<?php } ?>
	<script src="view/javascript/common.js" type="text/javascript"></script>
	<?php foreach ($scripts as $script) { ?>
	<script type="text/javascript" src="<?php echo $script; ?>"></script>
	<?php } ?>
	<script type="text/javascript">
		//-----------------------------------------
		// Confirm Actions (delete, uninstall)
		//-----------------------------------------
		$(document).ready(function(){

  	// Confirm Delete
  	$('#form').submit(function(){
  		if ($(this).attr('action').indexOf('delete',1) != -1) {
  			if (!confirm ('<?php echo $text_confirm; ?>')) {
  				return false;
  			}
  		}
  	});
  });
	</script>
</head>
<body>
	<div id="fb-root"></div>
	<div id="container">
		<header id="header" class="navbar navbar-static-top">
			<div class="navbar-header">
				<?php if ($logged) { ?>
				<a type="button" id="button-menu" class="pull-left hide-button"><i class="fa fa-indent fa-lg"></i></a>
				<a class="pull-left" style="display:none"><?php echo $logged; ?></a>
				<?php } ?>
				<b class="navbar-brand"><?php echo $heading_title; ?></b>
			</div>
			<?php if ($logged) { ?>
			<ul class="nav pull-right">
				<li><a disabled><b><?php echo mb_strtoupper($logged, "UTF-8"); ?></b></a></li>
				<li><a href="<?php echo $logout; ?>"><span class="hidden-xs hidden-sm hidden-md"><?php echo $text_logout; ?></span> <i class="fa fa-sign-out fa-lg"></i></a></li>
			</ul>
			<?php } ?>
		</header>
		<?php if ($logged) { ?>
		<nav id="column-left">
			<ul id="menu">
				<?php echo $strmenu;?>
			</ul>
		</nav>
		<?php } ?>


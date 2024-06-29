<!DOCTYPE HTML>
<html lang="<?php echo $lang1;?>">
<head>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
<meta http-equiv="cache-control" content="private">
<meta http-equiv="Content-Language" content="<?php echo $lang1;?>">
<meta name="google" content="notranslate">
<meta name="robots" content="index, follow">
<meta name="author" content="<?php echo $title;?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name = "format-detection" content = "telephone=no">
<title id="hdtitle"><?php echo $title;?></title>
<?php if ($description) { ?>
<meta name="description" content="<?php echo $description; ?>">
<?php } ?>
<?php if ($keywords) { ?>
<meta name="keywords" content="<?php echo $keywords; ?>">
<?php } ?>
<meta property="og:url" content="<?php echo $url_og;?>">
<meta property="og:title" content="<?php echo $title_og;?>">
<meta property="og:description" content="<?php echo $description_og;?>">
<meta property="og:type" content="website">
<meta property="og:image" content="<?php echo $image_og;?>">
<meta property="og:locale" content="vi_VN">
<link rel="SHORTCUT ICON" href="<?php echo PATH_TEMPLATE;?>default/images/favicon.png">

<style type="text/css">
body {background-color:#f3eacc; margin:0; padding:0;font-family: Arial, Helvetica, sans-serif; line-height:1; overflow:hidden }
* { -webkit-box-sizing: border-box;  box-sizing: border-box;}
*, *:before,*:after {-webkit-box-sizing: border-box; box-sizing: border-box;}
.page-not-found { padding:50px; display:block; height:auto; width:90%; max-width:500px; margin:5% auto; text-align:left; background:#efefef; -webkit-border-radius:15px; border-radius:15px;  box-shadow:0 0 40px rgba(0,0,0,0.5); position:relative; z-index:999; }
.bg-logo{/*background:#fff;*/width:206px}
.page-not-found h1 { font-family:Arial, Helvetica, sans-serif; font-size:20px; color:#333; line-height:28px; }
.page-not-found span { font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#333; line-height:22px; }
.page-not-found a { font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#C60; line-height:22px; }
.page-not-found a:hover { font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#333; line-height:22px; }
#background { position:absolute; top:0; left:0; width:100%; height:100%; background-color:rgba(0,0,0,0.3); }
#background span{ width:100%; height:100%;position:absolute; top:0; left:0; -webkit-background-size:cover; background-size:cover; background-position:center center; background-repeat:no-repeat; z-index:-5}
</style>
<!--<script type="text/javascript" src="<?php echo PATH_TEMPLATE;?>default/js/jquery.js"></script>
<script type="text/javascript">
	$(document).ready(function () { 
	window.location = "<?php echo HTTP_SERVER;?>";
	});
</script>-->
</head>

<body>
<div class="page-not-found">
<div class="bg-logo"> <img src="<?php echo PATH_TEMPLATE;?>default/images/logo.svg" width="200" alt="logo"> </div>
<h1><?php echo $heading_title; ?></h1>
<span><?php echo $text_error; ?><a href="<?php echo HTTP_SERVER;?>"><?php echo $text_home;?></a></span> </div>
<div id="background"><span style="background-image:url(<?php echo PATH_TEMPLATE;?>default/images/bg-error.jpg)" ></span></div>
</body>
</html>
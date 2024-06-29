<!DOCTYPE HTML>
<html lang="<?php echo $lang1;?>">
<head>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
<meta http-equiv="cache-control" content="private">
<meta http-equiv="Content-Language" content="<?php echo $lang1;?>">
<meta name="google" content="notranslate">
<meta name="language" content="<?php echo $language_location;?>">
<meta name="robots" content="index, follow">
<meta name="author" content="Lecmax">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name = "format-detection" content = "telephone=no">
<title id="hdtitle"><?php echo $title;?></title>
<?php if ($description) { ?>
<meta name="description" content="<?php echo $description; ?>">
<?php } ?>
<?php if ($keywords) { ?>
<meta name="keywords" content="<?php echo $keywords; ?>">
<?php } ?>

<!-- android -->
<meta name="mobile-web-app-capable" content="yes">
<meta http-equiv="cleartype" content="on">
<!-- iOS -->
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="apple-mobile-web-app-title" content="Lecmax">
<!-- Facebook -->
<meta property="og:title" content="<?php echo $title_og;?>">
<meta property="og:description" content="<?php echo $description_og;?>">
<meta property="og:type" content="website">
<meta property="og:site_name" content="Lecmax">
<meta property="og:image" content="<?php echo $image_og;?>">
<meta property="og:locale" content="<?php echo $language_location;?>">

<link rel="icon" href="<?php echo PATH_TEMPLATE;?>default/images/favicon.png">
<?php $url_canonical = $url_og;?>
<?php foreach($language_list as $item){?>
<?php if($item['code']==$lang1){
	$url_canonical = $item['href'];
}?>
<link rel="alternate" href="<?php echo $item['href'];?>" hreflang="<?php echo $item['language_hreflang'];?>">
<?php }?>

<link href="<?php echo $url_canonical;?>" rel="canonical">
<meta property="og:url" content="<?php echo $url_canonical;?>">
<style>body{width:100%;overflow-x:hidden}.footer, .container, .go-top, .mobile-call{visibility: hidden;}</style>
<link rel="stylesheet" type="text/css" href="<?php echo PATH_TEMPLATE;?>default/css/header.css">
<?php if(isset($ampcd['name'])){?>
<link rel="amphtml" href="<?php echo str_replace('.html','',$url_og);?><?php if($url_og==HTTP_SERVER) echo $lang1 . '/';?><?php if($menu_active!=ID_HOME) echo '/';?>amp/">
<?php }?>

<!--[if lt IE 9]>
<meta http-equiv="refresh" content="0; url=<?php echo HTTP_SERVER;?>detect.html" />
<script type="text/javascript">
/* <![CDATA[ */
window.top.location = '<?php echo HTTP_SERVER;?>detect.html';
/* ]]> */
</script>
<![endif]-->

<script type="application/ld+json">{"@context": "https://schema.org","@type": "Organization",  "url": "<?php echo HTTP_SERVER;?>","name": "Lecmax","logo": ["<?php echo PATH_TEMPLATE;?>default/images/social-share.png"], "contactPoint": {"@type": "ContactPoint",  "telephone": "+84-28-3894-1836","contactType": "Customer service"}}</script>

<?php echo $google_analytics; ?>
</head>
<body>
<div id="render-styles"></div>
<noscript id="deferred-styles">
<link rel="stylesheet" type="text/css" href="<?php echo PATH_TEMPLATE;?>default/css/slide.css?v=<?php echo VER;?>">
<link rel="stylesheet" type="text/css" href="<?php echo PATH_TEMPLATE;?>default/css/desktop.css?v=<?php echo VER;?>">
<link rel="stylesheet" type="text/css" href="<?php echo PATH_TEMPLATE;?>default/css/style.css?v=<?php echo VER;?>">
<link rel="stylesheet" type="text/css" href="<?php echo PATH_TEMPLATE;?>default/css/animation.css?v=<?php echo VER;?>">
</noscript>
<script>
var loadDeferredStyles = function() {
var addStylesNode = document.getElementById("deferred-styles");
var replacement = document.getElementById("render-styles");
replacement.innerHTML = addStylesNode.textContent;
document.body.appendChild(replacement)
addStylesNode.parentElement.removeChild(addStylesNode);
};
var raf = requestAnimationFrame || mozRequestAnimationFrame ||
webkitRequestAnimationFrame || msRequestAnimationFrame;
if (raf) raf(function() { window.setTimeout(loadDeferredStyles, 0); });
else window.addEventListener('load', loadDeferredStyles);
</script>
<!--HEADER-->
<header class="header">
<div class="top-header">
<div class="wrap-header">
<div class="logo"></div>
<?php if(!empty($text_slogan)){?><div class="slogan"><?php echo $text_slogan;?></div><?php }?>
<?php if(!empty($logo_value)){?><div class="logo-value"><img src="<?php echo $logo_value;?>" alt="Lecmax"></div><?php }?>
<?php if(!empty($social['hotline']) || !empty($social['hotline1'])){?>
<div class="hotline">
<span></span>
<div class="box-hotline">
<?php if(!empty($social['hotline'])){?><p><a href="tel:<?php echo $social['hotline_tel'];?>"><?php echo $social['hotline'];?></a> <?php echo $text_ha_noi_hotline;?></p><?php }?>
<?php if(!empty($social['hotline1'])){?><p><a href="tel:<?php echo $social['hotline1_tel'];?>"><?php echo $social['hotline1'];?></a> <?php echo $text_ho_chi_minh_hotline;?></p><?php }?>
</div>
</div>
<?php }?>
</div>
</div>
<div class="menu-main">
<div class="wrap-header">
<!--NAVIGATION-->
<nav class="navigation">
<div class="nav">
<ul>
<li>
<a class="link-home<?php if($menu_active==ID_HOME) echo ' current';?>" href="<?php echo HTTP_SERVER;?>" data-name="home-page">
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 40 40">
<path fill="currentColor" d="M20.246,1.834L0.094,22.945H4.25l0.157,14.445h30.894l0.157-14.921h4.47L20.246,1.834z M16.691,33.369
	h-4.129V22.945h4.129V33.369z M27.094,33.369h-4.077V22.945h4.077V33.369z"></path>
</svg>
</a>
</li>
<?php $temp=1; foreach($menus as $menu){
    $class = $menu['class'];                                   
    
    $active = "";                                            
    if($menu_active==$menu['id'])
        $active = ' class="current"';
?>
<?php if($menu['id']==ID_PRODUCT) {?>
<li class="has-sub<?php if($menu_active==ID_PRODUCT) echo ' current';?>"><a href="javascript:void(0);" data-name="products-page" data-title="<?php echo $menu['meta_title'];?>" data-description="<?php echo $menu['meta_description'];?>" data-keyword="<?php echo $menu['meta_keyword'];?>"><?php echo $menu['name'];?></a>
<div class="sub-menu">
<div class="all-sub">
<div class="scrollA">
<?php foreach($menu['child'] as $child){?>
<div class="item-sub add <?php if($child['id']==$menu_active1) echo 'current';?>">
<a href="javascript:void(0)" class="hover-btn" data-sub="s-<?php echo $child['id'];?>"><?php echo $child['name'];?></a>
</div>
<div class="second-sub-menu" data-show="s-<?php echo $child['id'];?>">
<ul>
<?php foreach($child['child'] as $child2){?>
<li <?php if($menu_active2==$child2['id']) echo 'class="current"';?> ><a href="<?php echo str_replace('HTTP_SERVER',HTTP_SERVER,$child2['href']);?>" data-name="product-<?php echo $child2['id'];?>" class="link-load" data-title="<?php echo $child2['meta_title'];?>" data-description="<?php echo $child2['meta_description'];?>" data-keyword="<?php echo $child2['meta_keyword'];?>"><?php echo $child2['name'];?></a></li>
<?php }?>
</ul>
</div>
<?php }?>
</div>
</div>
</div>
</li>
<?php }else{?>
<li <?php echo $active;?> >
<a class="link-load" href="<?php echo str_replace('HTTP_SERVER',HTTP_SERVER,$menu['href']);?>"  data-name="<?php echo $menu['class'];?>-page" data-title="<?php echo $menu['meta_title'];?>" data-description="<?php echo $menu['meta_description'];?>" data-keyword="<?php echo $menu['meta_keyword'];?>"><?php echo $menu['name'];?></a>
</li>
<?php }?>
<?php $temp++;}?>
</ul>
<ul>
<?php foreach($submenus as $menu){?>
<li <?php if($menu['id']==$menu_active) echo 'class="current"';?> >
<a class="link-load" href="<?php echo str_replace('HTTP_SERVER',HTTP_SERVER,$menu['href']);?>"  data-name="<?php echo $menu['class'];?>-page" data-title="<?php echo $menu['meta_title'];?>" data-description="<?php echo $menu['meta_description'];?>" data-keyword="<?php echo $menu['meta_keyword'];?>"><?php echo $menu['name'];?></a>
</li>
<?php }?>
</ul>
</ul>
</div>
</nav>
<!--NAVIGATION-->
<!--RIGHT HEADER-->
<div class="right-header">
<div class="seach-top">
<!--SEARCH-->
<a class="search-but"  href="javascript:void(0);">
<svg  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50">
<path fill="currentColor" d="M17.9,29.9L12,35.8c-0.9,0.9-0.9,2.4,0,3.4c0.9,0.9,2.4,0.9,3.4,0l5.9-5.9c-0.7-0.4-1.4-0.8-2-1.4C18.7,31.3,18.2,30.6,17.9,29.9z"></path>
<path  fill="currentColor" d="M37.7,13.4c-4.8-4.8-12.7-4.8-17.5,0s-4.8,12.6,0,17.4c4.8,4.8,12.7,4.8,17.5,0C42.5,25.9,42.5,18.2,37.7,13.4z M35.5,28.7c-3.7,3.7-9.6,3.7-13.3,0s-3.7-9.5,0-13.2c3.7-3.7,9.6-3.7,13.3,0C39.2,19,39.2,25,35.5,28.7z"></path>
</svg>
</a>
<div class="search-form">
<div class="form-row-search">
<form onSubmit="return false;" action="<?php echo $href_search;?>" class="search-id-form" id="search" method="get">
<input type="text" id="qsearch" name="qsearch" data-holder="<?php echo $text_search?>" value="<?php echo $text_search?>" data-default="<?php echo $text_search?>">
<input type="hidden" id="defaultvalue" name="defaultvalue" value="<?php echo $text_search;?>">
<input type="hidden" id="errorsearch"  name="errorsearch" value="<?php echo $text_error_search;?>">
<input type="hidden" id="href_search"  name="href_search" value="<?php echo HTTP_SERVER;?>tim-kiem.html">
</form>
</div>
</div>
</div>
<!--SEARCH-->
<?php echo $language;?>
</div>
<!--RIGHT HEADER-->
</div>
</div>
<div class="nav-click">
<svg  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 70 70">
<path fill="currentColor" class="st0" d="M55,34.95c0,1.408-1.142,2.55-2.55,2.55h-34.9c-1.408,0-2.55-1.142-2.55-2.55l0,0
	c0-1.409,1.142-2.55,2.55-2.55h34.9C53.858,32.4,55,33.542,55,34.95L55,34.95z"></path>
<path fill="currentColor" class="st0" d="M55,23.55c0,1.409-1.142,2.55-2.55,2.55H34.717c-1.409,0-2.55-1.142-2.55-2.55l0,0
	c0-1.408,1.142-2.55,2.55-2.55H52.45C53.858,21,55,22.142,55,23.55L55,23.55z"></path>
<path fill="currentColor" class="st0" d="M55,45.45c0,1.408-1.142,2.55-2.55,2.55H25.466c-1.408,0-2.55-1.142-2.55-2.55l0,0
	c0-1.408,1.142-2.55,2.55-2.55H52.45C53.858,42.9,55,44.042,55,45.45L55,45.45z"></path>
</svg>
</div>
</header>
<!--HEADER-->
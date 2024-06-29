<!-- HEADER -->
<header class="ampstart-headerbar fixed flex justify-start items-center top-0 left-0 right-0 pl2 pr2 ">
<div class="ampstart-sidebar-nav-logo fixed">
<div class="logo"><div class="logo-company"></div></div>
</div>


<div role="button" aria-label="open sidebar" on="tap:sidebar.toggle" tabindex="0" class="ampstart-navbar-trigger">
<svg xmlns="http://www.w3.org/2000/svg" viewbox="0 0 50 50" width="50" height="50">
<path fill="currentColor" d="M9,16h34v1H9V16z"></path>
<path fill="currentColor" d="M9,24h34v1H9V24z"></path>
<path fill="currentColor" d="M9,32h34v1H9V32z"></path>
</svg> 
<div class="ampstart-headerbar-text absolute"><?php echo $text_menu_amp;?></div>
</div>
</header>
<!-- HEADER -->

<!--SLIDEBAR --> 
<amp-sidebar id="sidebar" class="ampstart-sidebar px3  gallery-sidebar" layout="nodisplay">
<div class="flex justify-start items-center ampstart-sidebar-header">
<div role="button" aria-label="close sidebar" on="tap:sidebar.toggle" tabindex="0" class="ampstart-navbar-trigger  absolute left-0">
<svg xmlns="http://www.w3.org/2000/svg" viewbox="0 0 50 50" width="50" height="50">
<path fill="currentColor" d="M15,34.4L34.4,15l0.6,0.6L15.6,35L15,34.4z"></path>
<path fill="currentColor" d="M15.6,15L35,34.4L34.4,35L15,15.6L15.6,15z"></path>
</svg> 
</div>
</div>
<nav class="ampstart-sidebar-nav ampstart-nav">
<ul class="list-reset m0 p0 ampstart-label">
<li class="ampstart-nav-item gallery-sidebar-nav-item"><a class="ampstart-nav-link" href="<?php echo HTTP_SERVER;?>">
<div class="ampstart-sidebar-nav-item-text"><?php echo $text_menu_home_amp;?></div>
</a>
</li>
<?php foreach($menus as $item){?>
<li class="ampstart-nav-item gallery-sidebar-nav-item"><a class="ampstart-nav-link" href="<?php echo ($item['id']!=ID_HOME)?str_replace('HTTP_SERVER',HTTP_SERVER,$item['href']):HTTP_SERVER;?>">
<div class="ampstart-sidebar-nav-item-text"><?php echo ($item['id']!=ID_HOME)?$item['name']:$text_menu_home_amp;?></div>
</a>
</li>
<?php }?>
<?php foreach($menuseconds as $item){?>
<li class="ampstart-nav-item gallery-sidebar-nav-item"><a class="ampstart-nav-link" href="<?php echo ($item['id']!=ID_HOME)?str_replace('HTTP_SERVER',HTTP_SERVER,$item['href']):HTTP_SERVER;?>">
<div class="ampstart-sidebar-nav-item-text"><?php echo ($item['id']!=ID_HOME)?$item['name']:$text_menu_home_amp;?></div>
</a>
</li>
<?php }?>

</ul>
</nav>
</amp-sidebar>
<!--SLIDEBAR -->
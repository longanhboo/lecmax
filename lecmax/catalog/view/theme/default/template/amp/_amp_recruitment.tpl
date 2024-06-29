<?php echo $headeramp;?>
<body>
<?php echo $menuamp;?>
<!--BANNER-->
<figure class="ampstart-image-banner relative">
<div class="line-worker absolute center">
</div>
<amp-img width="1" height="<?php echo $ampcd['img_ratio'];?>"  alt="<?php echo $ampcd['name1'];?>" layout="responsive" src="<?php echo $ampcd['image'];?>"></amp-img>
<figcaption class="absolute">
<header>
<h1 class="title-page  relative  uppercase"><?php echo $text_companyname_amp;?></h1>
</header>
<footer class="absolute left-0 right-0 bottom-0">
<a class="ampstart-readmore py3 caps line-height-2 text-decoration-none center block relative" href="#content"></a>
</footer>
</figcaption>
</figure>
<!--BANNER-->
<!--CONTENT-->
<main id="content" class="content-post relative" role="main">
<h2 class="block center  relative  uppercase"><?php echo $ampcd['name1'];?></h2>
<aside class="post-text relative">
<?php foreach($recruitments as $key=>$item){?>
<?php if($item['id']==3){?>
<article class="ampstart-article-summary relative">
<div class="polycy-box">
<div class="polycy-circle ani-item"></div>
<div class="polycy-text">
<div class="title"><h2><?php echo $item['name'];?></h2></div>
<div class="polycy-inr ani-item">
<?php echo $item['description'];?>
</div>
</div>
</div>
</article>
<?php }elseif($item['id']==2){?>
<article class="ampstart-article-summary relative">
<div class="title"><h2><?php echo $item['name'];?></h2></div>
<div class="envairoment-box ani-item">
<div class="line"><span class="line-l"></span><span class="line-t"></span><span class="line-r"></span><span class="line-b"></span></div>
<div class="envairoment-text">
<?php echo $item['description'];?>
</div>
</div>
</article>
<?php }elseif($item['id']==1){?>
<article class="ampstart-article-summary relative">
<div class="recruitment-box">
<div class="title"><h2><?php echo $item['name'];?></h2></div>
<div class="scroll-slide ani-item">
<div class="news-link center-paging white">
<?php foreach($item['child'] as $keychild=>$child){?>
<div class="link-page">
<div class="link-text">
<p><a href="<?php echo $child['href'];?>" ><?php if($keychild<9) echo '0'; echo $keychild+1;?>). <?php echo $child['name'];?></a></p>
</div>
</div>
<?php }?>
</div>
</div>
</div>
</article>
<?php }?>
<?php }?>
</aside>
</main>
<!--CONTENT-->
</body>
</html>
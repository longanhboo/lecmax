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
<h2 class="flex justify-center items-center center  relative  uppercase"><?php echo $ampcd['name1'];?></h2>
<aside class="post-text relative">
<?php foreach($solutions as $key=>$item){?>
<article class="ampstart-article-summary relative">
<div class="title"><h2><?php echo $item['name'];?></h2></div>
<div class="value-box">
<div class="value-item ani-item">
<div class="value-text">
<?php echo str_replace('HTTP_CATALOG',HTTP_SERVER,$item['description']);?>
</div>
</div>
<div class="value-item ani-item">
<div class="value-text">
<?php echo str_replace('HTTP_CATALOG',HTTP_SERVER,$item['description1']);?>
</div>
</div>
</div>
</div>
</article>
<?php }?>
</aside>
</main>
<!--CONTENT-->
</body>
</html>
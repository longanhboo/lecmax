<?php echo $headeramp;?>
<body>
<?php echo $menuamp;?>
<!--BANNER-->
<figure class="ampstart-image-banner relative">
<div class="line-worker absolute right-align  no-transform">
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
<div class="gallery-landing-wall-scroll relative center">
<?php $stt=0;foreach($products as $item){?>
<?php if(!empty($item['image']) && !empty($item['image_1x'])){?>
<figure class="gallery-landing-image-wrapped"> <a href="<?php echo $item['href'];?>" class="gallery-landing-image-link"></a>
<figcaption class="gallery-landing-image-caption  left-align">
<h3 class="bold uppercase"><?php echo $item['name'];?></h3>
<a href="<?php echo $item['href'];?>" class="gallery-landing-caption-link inline-block"><?php echo $text_view_detail_amp;?></a> </figcaption>
<div class="gallery-landing-image-transform">
<amp-img width="1" height="<?php echo $item['image_ratio'];?>" layout="responsive" noloading="" src="<?php echo $item['image_1x'];?>" srcset="<?php echo $item['image_1x'];?> 1x,<?php echo $item['image'];?> 2x" alt="<?php echo $item['name'];?>"></amp-img>
</div>
</figure>
<?php }?>
<?php }?>
</div>
</main>
<!--CONTENT-->
</body>
</html>
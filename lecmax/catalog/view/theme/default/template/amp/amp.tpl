<?php echo $headeramp;?>
<body>
<?php echo $menuamp;?>
<!--CONTENT-->
<main id="content" class="content-post relative" role="main">
<h1 class="title-page  relative  uppercase"><?php echo $text_companyname_amp;?></h1>
<div class="gallery-landing-wall-scroll relative center">
<?php foreach($projects as $item){?>
<?php if(!empty($item['image_1x']) && !empty($item['image'])){?>
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
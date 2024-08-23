<?php echo $header;?>
<!--CONTAINER-->
<div class="container"  id="products-page">
<section class="banner-inner">
<div class="slide-mask" data-time="<?php echo $infoActive['config_loop_picture'];?>000">
<?php if(count($infoActive2['images'])>0){?>
<?php foreach($infoActive2['images'] as $item){?>
<div class="home-1">
<div class="bg-inner" style="background-image:url(<?php echo !empty($item['image'])?HTTP_IMAGE . $item['image']:PATH_IMAGE_BG;?>)"></div>
</div>
<?php }?>
<?php }else{?>
<div class="home-1">
<div class="bg-inner" style="background-image:url(<?php echo PATH_IMAGE_BG;?>)"></div>
</div>
<?php }?>
</div>
<div class="title-pro1 ani-item">
<p><?php echo $infoActive1['name'];?></p>
<h1><?php echo $infoActive2['name'];?></h1>
</div>
</section>
<section class="padding-main">
<div class="list-product">
<?php foreach($products as $item){?>
<div class="item-product ani-item">
<div class="pic-product"><img src="<?php echo !empty($item['image'])?HTTP_IMAGE . $item['image']:PATH_IMAGE_THUMB;?>" alt="<?php echo $item['name'];?>"></div>
<h3><?php echo $item['name'];?></h3>
<a href="<?php echo str_replace('HTTP_SERVER',HTTP_SERVER,$item['href']);?>" class="link-load"></a>
</div>
<?php }?>
</div>
</section>
</div>
<!--CONTAINER-->
<?php echo $footer;?>
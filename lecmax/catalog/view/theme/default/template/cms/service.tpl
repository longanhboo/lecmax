<?php echo $header;?>
<!--CONTAINER-->
<div class="container"  id="services-page">
<section class="banner-inner">
<div class="title-page"><h1><?php echo $infoActive['name'];?></h1></div>
<div class="slide-mask" data-time="<?php echo $infoActive['config_loop_picture'];?>000">
<?php if(count($service['images'])>0){?>
<?php foreach($service['images'] as $item){?>
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
</section>
<section class="outer-nav ani-item">
<div class="sub-nav">
<ul>
<?php foreach($services as $item){?>
<li <?php if($item['id']==$cateservice) echo 'class="current"';?> ><a href="<?php echo str_replace('HTTP_SERVER',HTTP_SERVER,$item['href']);?>" class="link-load" data-name="services-<?php echo $item['id'];?>" data-title="<?php echo $item['meta_title'];?>" data-description="<?php echo $item['meta_description'];?>" data-keyword="<?php echo $item['meta_keyword'];?>"><?php echo $item['name'];?></a></li>
<?php }?>
</ul>
</div>
</section>
<?php if($service['typeservice']==1){?>
<section class="padding-main">
<div class="title-main"><h2><?php echo isset($service['child'][0]['name'])?$service['child'][0]['name']:$service['name'];?></h2></div>
<div class="wrap-content">
<?php foreach($service['child'] as $child){?>
<?php if($child['typedesign']==1){?>
<div class="slider-d ani-item">
<?php foreach($child['images'] as $img){?>
<?php if(!empty($img['image'])){?>
<div class="item-3d">
<a class="zoom" data-pic="<?php echo !empty($img['image'])?HTTP_IMAGE . $img['image']:PATH_IMAGE_BG;?>">
<svg  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 80 80">
<path fill="currentColor" d="M37.7,37.6V25h4.5v12.6H55v4.5H42.3V55h-4.5V42.1H25v-4.5H37.7z"></path>
</svg>
</a>
<img src="<?php echo !empty($img['image'])?HTTP_IMAGE . $img['image']:PATH_IMAGE_BG;?>" alt="<?php echo !empty($img['name'])?$img['name']:$child['name'];?>">
<?php if(!empty($img['name'])){?><h3><?php echo $img['name'];?></h3><?php }?>
</div>
<?php }?>
<?php }?>
</div>
<?php }else{?>
<div class="box-design ani-item">
<div class="title-main"><h2><?php echo $child['name'];?></h2></div>
<div class="content-1">
<?php echo str_replace('HTTP_CATALOG',HTTP_SERVER,$child['description']);?>
</div>
</div>
<?php }?>
<?php }?>
</div>
</section>
<?php }elseif($service['typeservice']==2){?>
<section class="padding-main">
<div class="title-main"><h2><?php echo $service['name'];?></h2></div>
<div class="list-news">
<?php if(count($service['child'])>0){?>
<?php foreach($service['child'] as $child){?>
<div class="item-news ani-item">
<div class="pic-img"><img src="<?php echo !empty($child['image'])?HTTP_IMAGE . $child['image']:PATH_IMAGE_BG;?>" alt="<?php echo $child['name'];?>"></div>
<div class="txt-news">
<h3><?php echo $child['name'];?></h3>
</div>
<a href="<?php echo str_replace('HTTP_SERVER',HTTP_SERVER,$child['href']);?>" class="link-load view-news"><?php echo $text_view_detail;?></a>
</div>
<?php }?>
<?php }else{?>
<p><?php echo $text_data_updating;?></p>
<?php }?>
</div>
</section>
<?php }else{?>
<section class="padding-main">
<div class="title-main"><h2><?php echo $service['name'];?></h2></div>
<div class="load-details">
<div class="load-text ani-item">
<?php echo str_replace('HTTP_CATALOG',HTTP_SERVER,$service['description']);?>
</div>
<div class="print ani-item">
<div class="print-box">
<a class="save-but" href="javascript:void(0)"><?php echo $text_luu_trang;?></a>
<a class="print-but" href="javascript:void(0)"><?php echo $text_in_trang;?></a>
<a class="share-but" href="javascript:void(0)"><?php echo $text_share;?></a>
<div class="share-item">
<ul>
<li><a class="item-facebook" href="http://www.facebook.com/sharer.php?u=<?php echo $service['href'];?>" target="_blank"></a></li>
<li><a class="item-linkedin" href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo $service['href'];?>&title=<?php echo !empty($service['meta_title'])?$service['meta_title']:$service['name'];?>&summary=<?php echo $service['meta_description'];?>" target="_blank"></a></li>
</ul>
</div>
</div>
</div>
</div>
</section>
<?php }?>
</div>
<!--CONTAINER-->
<?php echo $footer;?>
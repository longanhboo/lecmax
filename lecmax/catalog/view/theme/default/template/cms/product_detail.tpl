<?php echo $header;?>
<!--CONTAINER-->
<div class="container"  id="product-detail-page">
<section class="banner-inner">
<div class="title-page"><h1><?php echo $infoActive['name'];?></h1></div>
<div class="slide-mask" data-time="<?php echo $infoActive['config_loop_picture'];?>000">
<?php if(count($product['images'])>0){?>
<?php foreach($product['images'] as $item){?>
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
<h2><?php echo $infoActive2['name'];?></h2>
</div>
</section>
<section class="padding-main">
<div class="box-product-detail">
<div class="row-detail">
<div class="left-detail ani-item">
<div class="detail-center" >
<?php if(count($product['imagepros'])>0){?>
<?php foreach($product['imagepros'] as $child){?>
<div class="item-11">
<img src="<?php echo !empty($child['image1'])?HTTP_IMAGE . $child['image1']:$product['image'];?>" alt="<?php echo $product['name'];?>">
<a class="zoom" href="javascript:void(0)"></a>
</div>
<?php }?>
<?php }else{?>
<div class="item-11">
<img src="<?php echo !empty($product['image'])?HTTP_IMAGE . $product['image']:PATH_IMAGE_THUMB;?>" alt="<?php echo $product['name'];?>">
<a class="zoom" href="javascript:void(0)"></a>
</div>
<?php }?>
</div>
</div>
<div class="right-detail ani-item">
<div class="title-right-detial">
<div><?php echo $infoActive2['name'];?></div>
<h2><?php echo $product['name'];?></h2>
</div>
<div class="sub-right-detial">
<?php echo str_replace('HTTP_CATALOG',HTTP_SERVER,$product['desc_short']);?>
<p><strong><?php echo $text_mau_sac;?></strong></p>
</div>
<div class="thumbs">
<?php if(count($product['imagepros'])>0){?>
<?php foreach($product['imagepros'] as $child){?>
<div class="color-item pic-img"><img src="<?php echo !empty($child['image'])?HTTP_IMAGE . $child['image']:$product['image'];?>" alt="<?php echo $product['name'];?>"></div>
<?php }?>
<?php }else{?>
<div class="color-item pic-img"><img src="<?php echo !empty($product['image'])?HTTP_IMAGE . $product['image']:PATH_IMAGE_THUMB;?>" alt="<?php echo $product['name'];?>"></div>
<?php }?>
</div>
<div class="share-pro">
<h3><?php echo $text_share;?>: </h3>
<ul>
<li><a class="item-facebook" href="http://www.facebook.com/sharer.php?u=<?php echo str_replace('HTTP_SERVER',HTTP_SERVER,$product['href']);?>" target="_blank"></a></li>
<li><a class="item-linkedin" href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo str_replace('HTTP_SERVER',HTTP_SERVER,$product['href']);?>&title=<?php echo !empty($product['meta_title'])?$product['meta_title']:$product['name'];?>&summary=<?php echo $product['meta_description'];?>" target="_blank"></a></li>
</ul>
</div>
</div>
</div>
<ul class="tab-des  ani-item">
<?php if(!empty($product['description'])){?>
<li><a href="javascript:void(0)" data-target="tab-1"><?php echo !empty($product['namethongso'])?$product['namethongso']:$text_thong_so;?></a></li>
<?php }?>
<?php if(!empty($product['descriptionbanve']) || !empty($product['image_banve'])){?>
<li><a href="javascript:void(0)" data-target="tab-2"><?php echo !empty($product['namebanve'])?$product['namebanve']:$text_ban_ve_ky_thuat;?></a></li>
<?php }?>
<?php if(!empty($product['descriptionimgpro'])){?>
<li><a href="javascript:void(0)" data-target="tab-3"><?php echo !empty($product['nameimgpro'])?$product['nameimgpro']:$text_hinh_anh_san_pham;?></a></li>
<?php }?>
<?php if(count($product['products'])>0){?>
<li><a href="javascript:void(0)" data-target="tab-4"><?php echo !empty($product['namephukien'])?$product['namephukien']:$text_phu_kien;?></a></li>
<?php }?>
<?php if(count($product['projects'])>0){?>
<li><a href="javascript:void(0)" data-target="tab-5"><?php echo !empty($product['nameproject'])?$product['nameproject']:$text_du_an_su_dung;?></a></li>
<?php }?>
</ul>
<div class="all-tab-content  ani-item">
<?php if(!empty($product['description'])){?>
<div class="tab-content" data-tab = "tab-1">
<h2><?php echo !empty($product['namethongso'])?$product['namethongso']:$text_thong_so;?></h2>
<div class="content-des-detail load-text">
<?php echo str_replace('HTTP_CATALOG',HTTP_SERVER,$product['description']);?>
</div>
</div>
<?php }?>
<?php if(!empty($product['descriptionbanve']) || !empty($product['image_banve'])){?>
<div class="tab-content" data-tab = "tab-2">
<h2><?php echo !empty($product['namebanve'])?$product['namebanve']:$text_ban_ve_ky_thuat;?></h2>
<div class="content-des-detail load-text">
<?php if(!empty($product['image_banve'])){?>
<a class="zoom" data-pic="<?php echo HTTP_IMAGE . $product['image_banve'];?>">
<svg  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 80 80">
<path fill="currentColor" d="M37.7,37.6V25h4.5v12.6H55v4.5H42.3V55h-4.5V42.1H25v-4.5H37.7z"></path>
</svg>
</a>
<img src="<?php echo HTTP_IMAGE . $product['image_banve'];?>" alt="<?php echo !empty($product['namebanve'])?$product['namebanve']:$text_ban_ve_ky_thuat;?> - <?php echo $product['name'];?>">
<?php }?>
<?php echo str_replace('HTTP_CATALOG',HTTP_SERVER,$product['descriptionbanve']);?>
</div>
</div>
<?php }?>
<?php if(!empty($product['descriptionimgpro'])){?>
<div class="tab-content" data-tab = "tab-3">
<h2><?php echo !empty($product['nameimgpro'])?$product['nameimgpro']:$text_hinh_anh_san_pham;?></h2>
<div class="content-des-detail load-text">
<?php echo str_replace('HTTP_CATALOG',HTTP_SERVER,$product['descriptionimgpro']);?>
</div>
</div>
<?php }?>
<?php if(count($product['products'])>0){?>
<div class="tab-content" data-tab = "tab-4">
<h2><?php echo !empty($product['namephukien'])?$product['namephukien']:$text_phu_kien;?></h2>
<div class="content-des-detail load-text">
<div class="list-product list-product-2">
<?php foreach($product['products'] as $item){?>
<div class="item-product ani-item">
<div class="pic-product"><img src="<?php echo !empty($item['image'])?HTTP_IMAGE . $item['image']:PATH_IMAGE_THUMB;?>" alt="<?php echo $item['name'];?>"></div>
<h3><?php echo $item['name'];?></h3>
<a href="<?php echo str_replace('HTTP_SERVER',HTTP_SERVER,$item['href']);?>" class="link-load"></a>
</div>
<?php }?>
</div>
</div>
</div>
<?php }?>
<?php if(count($product['projects'])>0){?>
<div class="tab-content" data-tab = "tab-5">
<h2><?php echo !empty($product['nameproject'])?$product['nameproject']:$text_du_an_su_dung;?></h2>
<div class="content-des-detail">
<div class="list-project">
<?php foreach($product['projects'] as $item){?>
<div class="item-project ani-item">
<div class="pic-img"><img src="<?php echo !empty($item['image'])?HTTP_IMAGE . $item['image']:PATH_IMAGE_BG;?>" alt="<?php echo $item['name'];?>"></div>
<div class="txt-project">
<p><?php echo $text_du_an;?></p>
<h3><?php echo $item['name'];?></h3>
</div>
<a href="<?php echo str_replace('HTTP_SERVER',HTTP_SERVER,$item['href']);?>" class="link-load"></a>
</div>
<?php }?>
</div>
</div>
</div>
<?php }?>
</div>
</div>
</section>
<section class="same-product">
<?php if(count($products)>1){?>
<div class="title-main ani-item"><h2><?php echo $text_san_pham_cung_loai;?></h2></div>
<div class="list-slide-product">
<?php foreach($products as $item){?>
<?php if($item['id']!=$product_id){?>
<div class="item-product ani-item">
<div class="pic-product"><img src="<?php echo !empty($item['image'])?HTTP_IMAGE . $item['image']:PATH_IMAGE_THUMB;?>" alt="<?php echo $item['name'];?>"></div>
<h3><?php echo $item['name'];?></h3>
<a href="<?php echo str_replace('HTTP_SERVER',HTTP_SERVER,$item['href']);?>" class="link-load"></a>
</div>
<?php }?>
<?php }?>
</div>
<?php }?>
<div class="button-more ani-item"><a href="<?php echo $href_back;?>" class="black link-load"><?php echo $text_xem_them_san_pham;?></a></div>
</section>
</div>
<!--CONTAINER-->
<?php echo $footer;?>
<?php echo $headeramp;?>
<body>
<?php echo $menuamp;?> 
<!--BANNER-->
<figure class="ampstart-image-banner relative">
<div class="line-worker absolute center">
</div>
<?php 

if(!empty($banner[0]['image'])){
$height_orig_e = 0;
list($width_orig_e, $height_orig_e) = getimagesize(DIR_IMAGE . $banner[0]['image']);
if($width_orig_e==0){
    $width_orig_e = 1;
}
}

$height_orig_logo = 0;
list($width_orig_logo, $height_orig_logo) = getimagesize(DIR_TEMPLATE . "default/images/logo-prod.jpg");
if($width_orig_logo==0){
    $width_orig_logo = 1;
}
?>
<amp-img width="1" height="<?php echo $height_orig_e/$width_orig_e;?>"  alt="<?php echo $getActive['name'];?>" layout="responsive" src="<?php echo !empty($banner[0]['image'])?HTTP_IMAGE . $banner[0]['image']:PATH_IMAGE_BG;?>"></amp-img>
<figcaption class="absolute">
<amp-img width="1" height="<?php echo $height_orig_logo/$width_orig_logo;?>"  alt="<?php echo $getActive['name'];?>" layout="responsive" src="<?php echo PATH_TEMPLATE;?>default/images/logo-prod.jpg"></amp-img>
<footer class="absolute left-0 right-0 bottom-0">
<a class="ampstart-readmore py3 caps line-height-2 text-decoration-none center block relative" href="#content"></a>
</footer>
</figcaption>
</figure>
<!--BANNER-->
<!--CONTENT-->
<main id="content" class="content-post relative" role="main">
<h2 class="flex justify-center items-center center  relative  uppercase"><?php echo $getActive['name'];?></h2>
<div class="news-detail box-nav">
<ul>
<?php $stt=0;foreach($submenu as $item){?>
<?php if($item['id']!=ID_BAN_TIN_AC){?>
<li <?php if($item['id']==$sub_active) echo 'class="current"';?> ><a href="<?php echo str_replace(array('HTTP_SERVER','.html'),array(HTTP_SERVER,'/amp/'),$item['href']);?>"><?php echo $item['name'];?></a></li>
<?php }?>
<?php }?>
</ul>
</div>
<aside class="post-text relative">
<article class="ampstart-article-summary relative">
<div class="title"><h2  class="flex justify-center items-center center  relative  uppercase"><?php echo $text_vi_tri_tuyen_dung;?></h2></div>
<div class="value-box">
<div class="value-item ani-item">
<div class="value-text news-link">
<ul>
<?php foreach($newss as $item){?>
<li><a href="<?php echo str_replace(array('HTTP_SERVER','.html'),array(HTTP_SERVER,'/amp/'),$item['href']);?>"><?php echo $item['name'];?></a><?php if(!empty($item['diadiem'])){?><br><p><?php echo $text_dia_diem_lam_viec;?>: <?php echo $item['diadiem'];?></p><?php }?><?php if(!empty($item['soluong'])){?><br><p><?php echo $text_so_luong;?>: <?php echo $item['soluong'];?></p><?php }?><?php if(!empty($item['date_insert'])){?><br><p><?php echo $text_ngay_het_han;?>: <?php echo $item['date_insert'];?></p><?php }?></li>
<?php }?>
</ul>
</div>
</div>
</div>
</div>
</article>
<?php 
$height_orig_logo = 0;
list($width_orig_logo, $height_orig_logo) = getimagesize(DIR_TEMPLATE . "default/images/logo-value.jpg");
if($width_orig_logo==0){
    $width_orig_logo = 1;
}
?>
<amp-img width="1" height="<?php echo $height_orig_logo/$width_orig_logo;?>"  alt="<?php echo $getActive['name'];?>" layout="responsive" src="<?php echo PATH_TEMPLATE;?>default/images/logo-value.jpg"></amp-img>
</aside>
</main>
<!--CONTENT-->
</body>
</html>
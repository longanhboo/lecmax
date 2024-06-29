<?php echo $headeramp;?>
<body>
<?php echo $menuamp;?>
<!--BANNER-->
<figure class="ampstart-image-banner relative">
<div class="line-worker absolute right-align  no-transform">
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
<div class="box-nav">
<ul>
<?php $stt=0;foreach($submenu as $item){?>
<?php if($item['id']!=ID_BAN_TIN_AC){?>
<li <?php if($item['id']==$sub_active) echo 'class="current"';?> ><a href="<?php echo str_replace(array('HTTP_SERVER','.html'),array(HTTP_SERVER,'/amp/'),$item['href']);?>"><?php echo $item['name'];?></a></li>
<?php }?>
<?php }?>
</ul>
</div>
<div class="gallery-landing-wall-scroll relative center">
<?php if(count($newss)>0){?>
<?php $stt=0;foreach($newss as $item){?>
<?php if(!empty($item['image'])){?>
<figure class="gallery-landing-image-wrapped"> <a href="<?php echo $item['href'];?>" class="gallery-landing-image-link"></a>
<figcaption class="gallery-landing-image-caption  left-align">
<h3 class="bold uppercase"><?php echo $item['name'];?></h3>
<a href="<?php echo $item['href'];?>" class="gallery-landing-caption-link inline-block"><?php echo $text_view_detail_amp;?></a> </figcaption>
<div class="gallery-landing-image-transform">
<amp-img width="1" height="<?php echo $item['image_ratio'];?>" layout="responsive" noloading="" src="<?php echo HTTP_IMAGE . $item['image'];?>" srcset="<?php echo HTTP_IMAGE . $item['image'];?> 1x,<?php echo HTTP_IMAGE . $item['image'];?> 2x" alt="<?php echo $item['name'];?>"></amp-img>
</div>
</figure>
<?php }?>
<?php }?>
<?php }else{?>
<p><?php echo $text_data_updating;?></p>
<?php }?>
</div>

<?php 
$height_orig_logo = 0;
list($width_orig_logo, $height_orig_logo) = getimagesize(DIR_TEMPLATE . "default/images/logo-value.jpg");
if($width_orig_logo==0){
    $width_orig_logo = 1;
}
?>
<amp-img width="1" height="<?php echo $height_orig_logo/$width_orig_logo;?>"  alt="<?php echo $getActive['name'];?>" layout="responsive" src="<?php echo PATH_TEMPLATE;?>default/images/logo-value.jpg"></amp-img>

</main>
<!--CONTENT-->
</body>
</html>
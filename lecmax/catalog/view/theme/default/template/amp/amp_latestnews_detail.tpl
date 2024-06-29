<?php echo $headeramp;?>
<body>
<?php echo $menuamp;?> 
<!--BANNER-->
<figure class="ampstart-image-banner relative">
<div class="line-worker absolute center">
</div>
<?php 

if(!empty($banner[0]['image1'])){
$height_orig_e = 0;
list($width_orig_e, $height_orig_e) = getimagesize(DIR_IMAGE . $banner[0]['image1']);
if($width_orig_e==0){
    $width_orig_e = 1;
}
}else{
$height_orig_e = 0;
list($width_orig_e, $height_orig_e) = getimagesize(DIR_IMAGE . $banner[0]['image']);
if($width_orig_e==0){
    $width_orig_e = 1;
}
}
?>
<amp-img width="1" height="<?php echo $height_orig_e/$width_orig_e;?>"  alt="<?php echo $getActive['name'];?>" layout="responsive" src="<?php echo !empty($banner[0]['image1'])?HTTP_IMAGE . $banner[0]['image1']:PATH_IMAGE_BG;?>"></amp-img>
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
<h2 class="flex justify-center items-center center  relative  uppercase"><?php echo $getActive['name'];?></h2>
<div class="news-detail box-nav">
<ul>
<?php $stt=0;foreach($submenu as $item){?>
<li <?php if($item['id']==$sub_active) echo 'class="current"';?> ><a href="<?php echo str_replace(array('HTTP_SERVER','.html'),array(HTTP_SERVER,'/amp/'),$item['href']);?>"><?php echo $item['name'];?></a></li>
<?php }?>
</ul>
</div>
<aside class="post-text relative">
<article class="ampstart-article-summary relative">
<div class="title"><h2  class="flex justify-center items-center center  relative  uppercase"><?php echo $news['name'];?></h2></div>
<div class="value-box">
<div class="value-item ani-item">
<div class="value-text">
<span class="r-date"><?php printf($text_tuan,$news['weekend']);?> - <?php echo date('m - Y',strtotime($news['date_insert']));?></span>
<amp-iframe  layout="responsive" id="press" width="100" height="100" src="<?php echo $news['pdf'];?>" frameborder="0" scrolling="no"></amp-iframe>
</div>
</div>
</div>
</div>
</article>
<article class="ampstart-article-summary relative">
<div class="title"><h2  class="flex justify-center items-center center  relative  uppercase"><?php echo $text_tin_lien_quan;?></h2></div>
<div class="value-box">
<div class="value-item ani-item">
<div class="value-text news-link">
<ul>
<?php foreach($newss as $item){?>
<?php if($item['id']!=$latestnews_id){?>
<?php 
$href = $this->url->link('cms/latestnews','path='. ID_NEWS .'_' . ID_BAN_TIN_AC . '&latestnews_id='.$item['id']) .'/amp/';
?>
<li><a href="<?php echo $href;?>"><?php echo $item['name'];?></a></li>
<?php }?>
<?php }?>
</ul>
</div>
</div>
</div>
</div>
</article>
</aside>
</main>
<!--CONTENT-->
</body>
</html>
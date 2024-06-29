<?php echo $header;?>
<!--CONTAINER-->
<div class="container"  id="service-details-page">
<section class="banner-inner">
<div class="title-page"><h1><?php echo $infoActive['name'];?></h1></div>
<div class="slide-mask" data-time="<?php echo $infoActive['config_loop_picture'];?>000">
<?php if(count($service_cate['images'])>0){?>
<?php foreach($service_cate['images'] as $item){?>
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
<!--01-->
<section class="load-content padding-main">
<div class="load-data">
</div>
</section>
<!--01-->
<!--02-->
<section class="same-news">
<div class="title-main"><h2><?php echo $text_thong_tin_khac;?></h2></div>
<div class="list-news">
<?php 
$news_data = array();

$limit = 5;
$total = count($service_cate['child']);
$i=0;
$start = 0;
$length = 0;

foreach($service_cate['child'] as $item){
    if($item['id']==$service_id){
        $start = ($i-$limit) > 0 ? ($i-$limit):0;
        $end = ($i+1+$limit > count($service_cate['child'])) ? count($service_cate['child']) : $i+1+$limit;
        $length = $end-$start;
        break;
    }
    $i++;
}

if($service_id==0){
    $start=0;
    $length=$limit+1;
}
$news_data = array_slice($service_cate['child'], $start, $length);
?>
<?php foreach($news_data as $item){?>
<div class="item-news link-page <?php if($item['id']==$service_id) echo 'current';?> ani-item">
<div class="pic-img"><img src="<?php echo !empty($item['image'])?HTTP_IMAGE . $item['image']:PATH_IMAGE_BG;?>" alt="<?php echo $item['name'];?>"></div>
<div class="txt-news">
<h3><?php echo $item['name'];?></h3>
</div>
<a href="<?php echo str_replace('HTTP_SERVER',HTTP_SERVER,$item['href']);?>" data-details="service-detail-<?php echo $item['id'];?>" class="view-news" data-title="<?php echo $item['meta_title'];?>" data-description="<?php echo $item['meta_description'];?>" data-keyword="<?php echo $item['meta_keyword'];?>"><?php echo $text_view_detail;?></a>
</div>
<?php }?>
</div>
</section>
<!--02-->
</div>
<!--CONTAINER-->
<?php echo $footer;?>
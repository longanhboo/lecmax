<?php echo $header;?>
<!--CONTAINER-->
<div class="container"  id="home-page">
<div class="title-page"><h1><?php echo $infoActive['name'];?></h1></div>
<section class="banner-home">
<div class="slide-mask" data-time="<?php echo $home['config_loop_picture'];?>000">
<?php if((  (($home['isyoutube'] && !empty($home['script'])) || (!$home['isyoutube'] && !empty($home['filename_mp4']))))){?>
<div class="video-youtube-full">  
<div class="youtube-video" data-embed="<?php echo !empty($home['script'])?$home['script']:'';?>"></div>
<a class="play-button" id="Play"  href="javascript:void(0)" data-image="<?php echo !empty($home['image_video'])?HTTP_IMAGE.$home['image_video']:'';?>">
<svg  xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 80 80" >
<path class="load-vid"  fill="currentColor"  d="M74.7,57.9c-2.7,5.3-6.7,10-11.5,13.5c-0.7,0.5-1.7,0.4-2.2-0.3s-0.4-1.7,0.3-2.2c4.4-3.3,8.1-7.6,10.6-12.4
c2.6-5.1,4-10.6,4-16.4C75.8,20.2,59.8,4.2,40,4.2S4.2,20.2,4.2,40S20.2,75.8,40,75.8c0.9,0,1.6,0.7,1.6,1.6S40.9,79,40,79
C18.5,79,1,61.5,1,40S18.5,1,40,1s39,17.5,39,39C79,46.2,77.5,52.4,74.7,57.9z"></path>
<path  class="load-vid"  fill="currentColor" d="M30,58.1c-0.5-0.3-0.8-0.8-0.8-1.4V21.9c0-0.9,0.7-1.6,1.6-1.6c0.9,0,1.6,0.7,1.6,1.6v32l23.5-14L38.6,28.8
c-0.7-0.5-0.9-1.5-0.5-2.2c0.5-0.7,1.5-0.9,2.2-0.5l19.4,12.5c0.5,0.3,0.7,0.8,0.7,1.4s-0.3,1.1-0.8,1.3L31.6,58.1
C31.1,58.4,30.5,58.4,30,58.1z"></path>
</svg>
</a>
<a class="pause-button" id="Pause"  href="javascript:void(0)"></a>
<div  class="control">
<!--<input id="progress-bar" type="range" class="slide-range" value="0">-->
<span id="current-time">0:00</span><span>/</span><span id="duration">0:00</span>
<button id="playpause" type="button"  data-state="play"></button>
<button id="mutetoggle" type="button" data-state="mute"></button>
<button id="fullscreen" type="button" data-state="go-fullscreen"></button>
</div>
</div>
<?php }?>
<?php foreach($home['images'] as $item){?>
<?php 
$data_image = empty($item['image']) || !is_file(DIR_IMAGE . $item['image'])?'':  str_replace(' ', '%20', $item['image']);
$data_desc = ($this->config->get('config_language_id')==1)?html_entity_decode(nl2br($item['image_desc_en'])):html_entity_decode(nl2br($item['image_desc']));
$data_name = ($this->config->get('config_language_id')==1)?html_entity_decode(nl2br($item['image_name_en'])):html_entity_decode(nl2br($item['image_name']));
$data_link = ($this->config->get('config_language_id')==1)?str_replace('HTTP_CATALOG',HTTP_SERVER,$item['image_link_en']):str_replace('HTTP_CATALOG',HTTP_SERVER,$item['image_link']);
?>
<div class="home-1">
<div class="bg-home" style="background-image:url(<?php echo !empty($data_image)?HTTP_IMAGE . $data_image:PATH_IMAGE_BG;?>)"></div>
<?php if(!empty($data_name) || !empty($data_desc)){?>
<div class="text-banner">
<div class="txt-banner">
<?php if(!empty($data_name)){?><h3><?php echo $data_name;?></h3><?php }?>
<?php if(!empty($data_desc)){?><h2><?php echo $data_desc;?></h2><?php }?>
</div>
</div>
<?php }?>
</div>
<?php }?>
</div>
</section>
<section class="content-home">
<?php if(count($sub_menu)>0){?>
<div class="nav-home ani-item">
<ul>
<?php foreach($sub_menu as $item){?>
<li>
<?php if(!empty($item['iconsvg'])){?><span><?php echo $item['iconsvg'];?></span><?php }?>
<a href="<?php echo str_replace('HTTP_SERVER',HTTP_SERVER,$item['href']);?>" class="link-load"><?php echo !empty($item['name2'])?$item['name2']:$item['name'];?></a>
</li>
<?php }?>
</ul>
</div>
<?php }?>
<?php if(count($products)>0 || count($news_homes)>0){?>
<div class="row-main">
<?php if(count($products)>0){?>
<?php if(!empty($products[0]['name'])){?>
<div class="col-product">
<div class="product-new ani-item">
<div class="pic-img"><img src="<?php echo !empty($products[0]['image'])?$products[0]['image']:PATH_IMAGE_BG;?>" alt="<?php echo $products[0]['name'];?>"></div>
<div class="txt-pro-new">
<h2><?php echo $text_san_pham_moi;?></h2>
<h3><?php echo $products[0]['name'];?></h3>
<a href="<?php echo $products[0]['href'];?>" class="link-load"></a>
</div>
</div>
</div>
<?php }?>
<?php }?>
<?php if(count($news_homes)>0){?>
<div class="col-news">
<div class="title-n ani-item"><h2><?php echo $text_tin_moi;?></h2></div>
<?php if(isset($news_homes[0])){?>
<div class="big-news ani-item">
<div class="pic-img"><img src="<?php echo !empty($news_homes[0]['image'])?$news_homes[0]['image']:PATH_IMAGE_THUMB;?>" alt="<?php echo $news_homes[0]['name'];?>"></div>
<div class="txt-big-news">
<h3><?php echo $news_homes[0]['name'];?></h3>
</div>
<a href="<?php echo $news_homes[0]['href'];?>" class="link-load"></a>
</div>
<?php }?>

<div class="small-news ani-item">
<?php if(count($news_homes)>1){?>
<?php for($i=1;$i<count($news_homes);$i++){?>
<div class="box-news">
<div class="date-news"><?php echo $news_homes[$i]['date_day'];?><span><?php echo $news_homes[$i]['date_month'];?> - <?php echo $news_homes[$i]['date_year'];?></span></div>
<h3><?php echo $news_homes[$i]['name'];?></h3>
<a href="<?php echo $news_homes[$i]['href'];?>" class="link-load"></a>
</div>
<?php if($i>=3) break;?>
<?php }?>
<?php }?>
<?php if(isset($getNews['href'])){?>
<a href="<?php echo str_replace('HTTP_SERVER',HTTP_SERVER,$getNews['href']);?>" class="link-load view-more ani-item"><?php echo $text_xem_them?></a>
<?php }?>
</div>
</div>
<?php }?>
</div>
<?php }?>
</section>
<?php if(count($projects)>0){?>
<section class="padding-main projects-home">
<div class="wrap-content">
<div class="title-main title-white ani-item"><h2><?php echo $text_du_an_tieu_bieu;?></h2></div>
<div class="slider-al slider-white ani-item">
<?php foreach($projects as $item){?>
<div class="item-project ani-item">
<div class="pic-img"><img src="<?php echo !empty($item['image'])?$item['image']:PATH_IMAGE_BG;?>" alt="<?php echo $item['name'];?>"></div>
<div class="txt-project">
<p><?php echo $text_du_an;?></p>
<h3><?php echo $item['name'];?></h3>
</div>
<a href="<?php echo str_replace('HTTP_SERVER',HTTP_SERVER,$item['href']);?>" class="link-load"></a>
</div>
<?php }?>
</div>
</div>
</section>
<?php }?>
<?php if(count($customerss)>0){?>
<section class="padding-main customer-home">
<div class="title-main ani-item"><h2><?php echo $text_khach_hang;?></h2></div>
<div class="slider-cus ani-item">
<?php foreach($customerss as $item){?>
<div class="item-cus"><a href="javascript:void(0);"><img src="<?php echo !empty($item['image'])?$item['image']:PATH_IMAGE_BG;?>" alt="<?php echo $item['name'];?>"></a></div>
<?php }?>
</div>
</section>
<?php }?>
</div>
<!--CONTAINER-->
<?php echo $footer;?>
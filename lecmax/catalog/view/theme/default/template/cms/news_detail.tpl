<?php echo $header;?>
<!--CONTAINER-->
<div class="container"  id="news-details-page">
<section class="banner-inner">
<div class="title-page"><h2><?php echo $infoActive['name'];?></h2></div>
<div class="slide-mask" data-time="<?php echo $infoActive['config_loop_picture'];?>000">
<?php if(count($infoActive1['images'])>0){?>
<?php foreach($infoActive1['images'] as $item){?>
<div class="home-1">
<div class="bg-inner" style="background-image:url(<?php echo !empty($item['image1'])?HTTP_IMAGE . $item['image1']:PATH_IMAGE_BG;?>)"></div>
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
<?php foreach($submenu as $item){?>
<?php if(count($item['newss'])>0){?>
<li <?php if($item['id']==$menu_active) echo 'class="current"';?> ><a href="<?php echo str_replace('HTTP_SERVER',HTTP_SERVER,$item['href']);?>" class="link-load" data-title="<?php echo $item['meta_title'];?>" data-description="<?php echo $item['meta_description'];?>" data-keyword="<?php echo $item['meta_keyword'];?>" data-name="news-<?php echo $item['id'];?>"><?php echo $item['name'];?></a></li>
<?php }?>
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
<div class="title-main"><h2><?php echo $text_tin_lien_quan;?></h2></div>
<div class="list-news">
<?php $demnew=0;foreach($newss as $item){?>
<?php 
$href = $this->url->link('cms/news','path='. ID_NEWS .'_' . $item['category_id'] . '&news_id='.$item['id'],$this->config->get('config_language')) .'.html';
?>
<div class="item-news link-page ani-item<?php if($news_id==$item['id']) echo ' current';?>">
<div class="date-news"><?php echo date('d',strtotime($item['date_insert']));?><span><?php echo date('m - Y',strtotime($item['date_insert']));?></span></div>
<div class="pic-img"><img src="<?php echo !empty($item['image'])?HTTP_IMAGE . str_replace(' ', '%20',$item['image']):PATH_IMAGE_THUMB;?>" alt="<?php echo $item['name'];?>"></div>
<div class="txt-news">
<h3><?php echo $item['name'];?></h3>
</div>
<a href="<?php echo $href;?>" data-details="news-detail-<?php echo $item['id'];?>" class="view-news" data-title="<?php echo $item['meta_title'];?>" data-description="<?php echo $item['meta_description'];?>" data-keyword="<?php echo $item['meta_keyword'];?>"><?php echo $text_view_detail;?></a>
</div>
<?php }?>
</div>
</section>
<!--02-->
</div>
<!--CONTAINER-->
<?php echo $footer;?>
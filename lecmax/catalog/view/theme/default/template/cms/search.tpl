<?php echo $header;?>
<!--CONTAINER-->
<div class="container"  id="search-page">
<section class="banner-inner">
<div class="title-page"><h1><?php echo $text_title_search;?></h1></div>
<div class="slide-mask" data-time="5000">
<div class="home-1">
<div class="bg-inner" style="background-image:url(<?php echo !empty($background)?HTTP_IMAGE . $background:PATH_IMAGE_BG;?>)"></div>
</div>
</div>
</section>
<section class="padding-main set-post" data-post="about-info">
<div class="title-main title-red ani-item"><h2><?php echo $text_title;?></h2></div>
<div class="wrap-content content-1 ani-item">
<?php $dem_item = count($searchs);?>
<?php if($dem_item>0){?>
<div class="search-result">
<div class="search-box">
<?php foreach($searchs as $item){?>
<div class="item-search ani-item">
<a href="<?php echo $item['href'];?>" <?php if(isset($item['is_pdf'])) echo 'target="_blank"';?> >
<h3><?php echo $item['name'];?></h3>
<span class="item-link-name"><?php echo str_replace(HTTP_SERVER,'',$item['href']);?></span>
<p><span class="item-date"><?php echo date('d/m/Y',strtotime($item['date_modified']));?></span> - <?php echo (!empty($item['desc_short']))?$item['desc_short']:$item['name'];?></p>
</a>
</div>
<?php }?>
</div>
</div>
<?php }else{?>
<div class="search-tempty">
<p><?php echo $text_not_found;?></p>
</div>
<?php }?>
</div>
</section>
</div>
<!--CONTAINER-->
<?php echo $footer;?>
<?php foreach($submenu as $item){?>
<?php if(count($item['newss'])>0){?>
<div class="colum-box" id="c-<?php echo $item['category_id'];?>" data-href="<?php echo $item['href'];?>" data-title="<?php echo $item['meta_title'];?>" data-description="<?php echo $item['meta_description'];?>" data-keyword="<?php echo $item['meta_keyword'];?>">
<div class="title"><h2><?php echo $item['name'];?></h2></div>
<div class="news-box">
<div class="news-link center-no-paging">
<?php $demnew=0;foreach($item['newss'] as $child){?>
<?php
    $t1                         = $this->model_catalog_news->getFriendlyUrl('news_id='.$child['news_id'],$this->config->get('config_language_id'));
    $href                       = 'HTTP_CATALOG' . $this->config->get('config_language') . '/' . $item['url_current'] . '/' . $t1 .'.html';
    
    
    preg_match('/<img.+src=[\'"](?P<src>[^\s\'"]*)[\'"].?.*>/i', html_entity_decode($child['description']), $image);
    $image_news = empty($child['image']) || !is_file(DIR_IMAGE . $child['image'])?'': 'HTTP_IMAGE' . str_replace(' ', '%20', $child['image']);
    $image_news = empty($image_news)&&isset($image['src'])&& !empty($image['src'])?str_replace(HTTP_CATALOG,'HTTP_CATALOG',$image['src']):$image_news;
    $image_news = empty($image_news)?str_replace(HTTP_CATALOG,'HTTP_CATALOG',PATH_IMAGE_THUMB):$image_news;
?>
<?php if(!empty($image_news)){?>
<div class="link-page">
<a href="<?php echo $href;?>" data-details="n-<?php echo $child['news_id'];?>" data-title="<?php echo $child['meta_title'];?>" data-description="<?php echo $child['meta_description'];?>" data-keyword="<?php echo $child['meta_keyword'];?>" ></a>
<?php if($child['isnew'] && $demnew<5){?><div class="new-icon"></div><?php $demnew++;}?>
<div class="pic-thumb"><img src="<?php echo $image_news;?>" alt="<?php echo $child['name'];?>"></div>
<div class="link-text">
<h3><?php echo $child['name'];?></h3>
</div>
</div>
<?php }?>
<?php }?>
</div>
</div>
<!--load-->
<div class="news-bg">
<div class="news-load"></div>
</div>
<!--/load-->
</div>
<?php }?>
<?php }?>
<?php echo $header;?>
<!--CONTAINER-->
<div class="container"  id="projects-page">
<section class="banner-inner">
<div class="slide-mask" data-time="<?php echo $infoActive['config_loop_picture'];?>000">
<?php if(count($cate_project['images'])>0){?>
<?php foreach($cate_project['images'] as $item){?>
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
<?php foreach($projects as $item){?>
<?php if(count($item['child'])>0){?>
<li  <?php if($item['id']==$cateproject) echo 'class="current"';?> ><a href="<?php echo str_replace('HTTP_SERVER',HTTP_SERVER,$item['href']);?>" class="link-load" data-name="project-<?php echo $item['id'];?>" data-title="<?php echo $item['meta_title'];?>" data-description="<?php echo $item['meta_description'];?>" data-keyword="<?php echo $item['meta_keyword'];?>"><?php echo $item['name'];?></a></li>
<?php }?>
<?php }?>
</ul>
</div>
</section>
<section class="padding-main">
<div class="title-main"><h1><?php echo !empty($cate_project['name'])?$cate_project['name1']:$cate_project['name'];?></h1></div>
<div class="list-project">
<?php foreach($cate_project['child'] as $item){?>
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
</section>
</div>
<!--CONTAINER-->
<?php echo $footer;?>
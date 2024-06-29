<?php echo $header;?>
<!--CONTAINER-->
<div class="container"  id="project-detail-page">
<section class="banner-inner">
<div class="title-page"><h1><?php echo $infoActive['name'];?></h1></div>
<div class="slide-mask" data-time="<?php echo $infoActive['config_loop_picture'];?>000">
<?php if(count($project['images'])>0){?>
<?php foreach($project['images'] as $item){?>
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
<div class="title-pro ani-item">
<p><?php echo $cate_project['name'];?></p>
<h2><?php echo $project['name'];?></h2>
</div>
<div class="wrap-content">
<?php if(!empty($project['image1'])){?>
<div class="pic-pro-detail ani-item">
<img src="<?php echo !empty($project['image1'])?HTTP_IMAGE . $project['image1']:PATH_IMAGE_BG;?>" alt="<?php echo $project['name'];?>">
<a class="zoom" href="javascript:void(0)" data-pic="<?php echo !empty($project['image1'])?HTTP_IMAGE . $project['image1']:PATH_IMAGE_BG;?>">
<svg  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 80 80">
<path fill="currentColor" d="M37.7,37.6V25h4.5v12.6H55v4.5H42.3V55h-4.5V42.1H25v-4.5H37.7z"></path>
</svg>
</a>
</div>
<?php }?>
<div class="txt-pro-detail ani-item">
<?php echo str_replace('HTTP_CATALOG',HTTP_SERVER,$project['description']);?>
</div>
<?php if(count($project['imagepros'])>0){?>
<div class="title-sm ani-item"><h3><?php echo $text_hinh_anh_du_an;?></h3></div>
<div class="slider-pic ani-item">
<?php $sttchild=0;foreach($project['imagepros'] as $item){?>
<?php if(!empty($item['image'])){?>
<div class="item-pic">
<div class="pic-img"><img src="<?php echo !empty($item['image'])?HTTP_IMAGE . $item['image']:PATH_IMAGE_BG;?>" alt="<?php echo !empty($item['name'])?$item['name']:$project['name'];?>"></div>
<a href="javascript:void(0);" data-href="<?php echo HTTP_SERVER;?>view-album-project.html?id=<?php echo $project['id'];?>" class="view-zoom-al" data-go="<?php echo $sttchild;?>">
<svg  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 80 80">
<path fill="currentColor" d="M37.7,37.6V25h4.5v12.6H55v4.5H42.3V55h-4.5V42.1H25v-4.5H37.7z"></path>
</svg>
</a>
</div>
<?php $sttchild++;}?>
<?php }?>
</div>
<?php }?>
</div>
</section>
<section class="padding-main same-project">
<div class="title-main title-white ani-item"><h2><?php echo $text_cac_du_an_khac;?></h2></div>
<?php if(count($projectRelated)>1){?>
<div class="list-project">
<div class="slider-al ani-item">
<?php $stt=0;foreach($projectRelated as $item){?>
<?php if($item['id']!=$project_id){?>
<div class="item-project ani-item">
<div class="pic-img"><img src="<?php echo !empty($item['image'])?HTTP_IMAGE . $item['image']:PATH_IMAGE_BG;?>" alt="<?php echo $item['name'];?>"></div>
<div class="txt-project">
<p><?php echo $text_du_an;?></p>
<h3><?php echo $item['name'];?></h3>
</div>
<a href="<?php echo str_replace('HTTP_SERVER',HTTP_SERVER,$item['href']);?>" class="link-load"></a>
</div>
<?php $stt++;}?>
<?php }?>
</div>
</div>
<?php }?>
<div class="button-more ani-item"><a href="<?php echo str_replace('HTTP_SERVER',HTTP_SERVER,$cate_project['href']);?>" class="link-load"><?php echo $text_xem_them_du_an;?></a></div>
</section>
</div>
<!--CONTAINER-->
<?php echo $footer;?>
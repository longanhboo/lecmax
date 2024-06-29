<?php echo $header;?>
<!--CONTAINER-->
<div class="container"  id="about-page">
<section class="banner-inner">
<div class="title-page"><h1><?php echo $infoActive['name'];?></h1></div>
<div class="slide-mask" data-time="<?php echo $infoActive['config_loop_picture'];?>000">
<?php if(count($infoActive['images'])>0){?>
<?php foreach($infoActive['images'] as $item){?>
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
<?php foreach($aboutuss as $item){?>
<?php if($item['id']==50){?>
<?php if(!empty($item['description'])){?>
<li <?php if($item['id']==$aboutus_id) echo 'class="subcurrent"';?> ><a href="<?php echo str_replace('HTTP_SERVER',HTTP_SERVER,$item['href']);?>" data-name="about-info" data-title="<?php echo $item['meta_title'];?>" data-description="<?php echo $item['meta_description'];?>" data-keyword="<?php echo $item['meta_keyword'];?>"><?php echo $item['name'];?></a></li>
<?php }?>
<?php }elseif($item['id']==51){?>
<?php if(!empty($item['description'])){?>
<li <?php if($item['id']==$aboutus_id) echo 'class="subcurrent"';?> ><a href="<?php echo str_replace('HTTP_SERVER',HTTP_SERVER,$item['href']);?>" data-name="about-factory" data-title="<?php echo $item['meta_title'];?>" data-description="<?php echo $item['meta_description'];?>" data-keyword="<?php echo $item['meta_keyword'];?>"><?php echo $item['name'];?></a></li>
<?php }?>
<?php }elseif($item['id']==120){?>
<?php if(count($item['child'])>0){?>
<li <?php if($item['id']==$aboutus_id) echo 'class="subcurrent"';?> ><a href="<?php echo str_replace('HTTP_SERVER',HTTP_SERVER,$item['href']);?>" data-name="about-history" data-title="<?php echo $item['meta_title'];?>" data-description="<?php echo $item['meta_description'];?>" data-keyword="<?php echo $item['meta_keyword'];?>"><?php echo $item['name'];?></a></li>
<?php }?>
<?php }elseif($item['id']==56){?>
<?php if(!empty($item['description'])){?>
<li <?php if($item['id']==$aboutus_id) echo 'class="subcurrent"';?> ><a href="<?php echo str_replace('HTTP_SERVER',HTTP_SERVER,$item['href']);?>" data-name="about-quality" data-title="<?php echo $item['meta_title'];?>" data-description="<?php echo $item['meta_description'];?>" data-keyword="<?php echo $item['meta_keyword'];?>"><?php echo $item['name'];?></a></li>
<?php }?>
<?php }elseif($item['id']==55){?>
<?php if(count($item['child'])>0){?>
<li <?php if($item['id']==$aboutus_id) echo 'class="subcurrent"';?> ><a href="<?php echo str_replace('HTTP_SERVER',HTTP_SERVER,$item['href']);?>" data-name="about-certification" data-title="<?php echo $item['meta_title'];?>" data-description="<?php echo $item['meta_description'];?>" data-keyword="<?php echo $item['meta_keyword'];?>"><?php echo $item['name'];?></a></li>
<?php }?>
<?php }elseif($item['id']==159){?>
<?php if(count($item['child'])>0){?>
<li <?php if($item['id']==$aboutus_id) echo 'class="subcurrent"';?> ><a href="<?php echo str_replace('HTTP_SERVER',HTTP_SERVER,$item['href']);?>" data-name="about-value" data-title="<?php echo $item['meta_title'];?>" data-description="<?php echo $item['meta_description'];?>" data-keyword="<?php echo $item['meta_keyword'];?>"><?php echo $item['name'];?></a></li>
<?php }?>
<?php }elseif($item['id']==34){?>
<?php if(count($item['child'])>0){?>
<li <?php if($item['id']==$aboutus_id) echo 'class="subcurrent"';?> ><a href="<?php echo str_replace('HTTP_SERVER',HTTP_SERVER,$item['href']);?>" data-name="about-video" data-title="<?php echo $item['meta_title'];?>" data-description="<?php echo $item['meta_description'];?>" data-keyword="<?php echo $item['meta_keyword'];?>"><?php echo $item['name'];?></a></li>
<?php }?>
<?php }?>
<?php }?>
</ul>
</div>
</section>
<?php foreach($aboutuss as $item){?>
<?php if($item['id']==50){?>
<?php if(!empty($item['description'])){?>
<section class="padding-main set-post" data-post="about-info" data-href="<?php echo str_replace('HTTP_SERVER',HTTP_SERVER,$item['href']);?>" data-title="<?php echo $item['meta_title'];?>" data-description="<?php echo $item['meta_description'];?>" data-keyword="<?php echo $item['meta_keyword'];?>">
<div class="title-main title-red ani-item"><h2><?php echo !empty($item['name1'])?$item['name1']:$item['name'];?></h2></div>
<div class="wrap-content content-1 ani-item">
<?php echo str_replace('HTTP_CATALOG',HTTP_SERVER,$item['description']);?>
</div>
</section>
<?php }?>
<?php }elseif($item['id']==51){?>
<?php if(!empty($item['description'])){?>
<section class="about-factory set-post" data-post="about-factory" data-href="<?php echo str_replace('HTTP_SERVER',HTTP_SERVER,$item['href']);?>" data-title="<?php echo $item['meta_title'];?>" data-description="<?php echo $item['meta_description'];?>" data-keyword="<?php echo $item['meta_keyword'];?>">
<div class="bg-cover" style="background-image:url(<?php echo !empty($item['image'])?HTTP_IMAGE . $item['image']:PATH_IMAGE_BG;?>)"></div>
<div class="box-fac ani-item">
<div class="title-main title-white"><h2><?php echo !empty($item['name1'])?$item['name1']:$item['name'];?></h2></div>
<?php echo str_replace('HTTP_CATALOG',HTTP_SERVER,$item['description']);?>
</div>
</section>
<?php }?>
<?php }elseif($item['id']==120){?>
<?php if(count($item['child'])>0){?>
<section class="padding-main about-history set-post" data-post="about-history" data-href="<?php echo str_replace('HTTP_SERVER',HTTP_SERVER,$item['href']);?>" data-title="<?php echo $item['meta_title'];?>" data-description="<?php echo $item['meta_description'];?>" data-keyword="<?php echo $item['meta_keyword'];?>">
<div class="wrap-content">
<div class="title-main title-white ani-item"><h2><?php echo !empty($item['name1'])?$item['name1']:$item['name'];?></h2></div>
<div class="slider-history" data-time="6000">
<div class="item-wrapper">
<?php foreach($item['child'] as $child){?>
<?php if(!empty($child['description'])){?>
<div class="box-history ani-item item-container">
<div class="txt-history">
<div class="content-txt-history">
<?php echo str_replace('HTTP_CATALOG',HTTP_SERVER,$child['description']);?>
</div>
</div>
</div>
<?php }?>
<?php }?>
</div>
<div class="year-box ani-item">
<h3><?php echo $text_year;?></h3>
<div class="year-slider">
<div class="item-wrapper">
<?php foreach($item['child'] as $child){?>
<?php if(!empty($child['description'])){?>
<div class="year item-container"><?php echo $child['name'];?></div>
<?php }?>
<?php }?>
</div>
</div>
</div>
<div class="time-line ani-item">
<ul>
<?php $sttchild=0; foreach($item['child'] as $child){?>
<?php if(!empty($child['description'])){?>
<li><a href="javascript:void(0)" data-index="<?php echo $sttchild;?>"><?php echo $child['name'];?></a></li>
<?php $sttchild++;}?>
<?php }?>
</ul>		
</div>
</div>
<div class="customize-nav">
<div class="slide-prev"></div>
<div class="slide-next"></div>
</div>
</div>
</section>
<?php }?>
<?php }elseif($item['id']==56){?>
<?php if(!empty($item['description'])){?>
<section class="padding-main set-post" data-post="about-quality" data-href="<?php echo str_replace('HTTP_SERVER',HTTP_SERVER,$item['href']);?>" data-title="<?php echo $item['meta_title'];?>" data-description="<?php echo $item['meta_description'];?>" data-keyword="<?php echo $item['meta_keyword'];?>">
<div class="title-main title-red ani-item"><h2><?php echo !empty($item['name1'])?$item['name1']:$item['name'];?></h2></div>
<div class="wrap-content content-1 ani-item">
<?php echo str_replace('HTTP_CATALOG',HTTP_SERVER,$item['description']);?>
</div>
</section>
<?php }?>
<?php }elseif($item['id']==55){?>
<?php if(count($item['child'])>0){?>
<section class="padding-main about-certification set-post" data-post="about-certification" data-href="<?php echo str_replace('HTTP_SERVER',HTTP_SERVER,$item['href']);?>" data-title="<?php echo $item['meta_title'];?>" data-description="<?php echo $item['meta_description'];?>" data-keyword="<?php echo $item['meta_keyword'];?>">
<div class="title-main title-white ani-item"><h2><?php echo !empty($item['name1'])?$item['name1']:$item['name'];?></h2></div>
<div class="wrap-content">
<div class="slider-al slider-white ani-item">
<?php foreach($item['child'] as $child){?>
<?php if(!empty($child['image_chungnhan'])){?>
<div class="item-cer">
<img src="<?php echo !empty($child['image_chungnhan'])?HTTP_IMAGE . $child['image_chungnhan']:PATH_IMAGE_BG;?>" alt="<?php echo $child['name'];?>">
<a class="zoom" href="javascript:void(0);" data-pic="<?php echo !empty($child['image_chungnhan'])?HTTP_IMAGE . $child['image_chungnhan']:PATH_IMAGE_BG;?>">
<svg  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 80 80">
<path fill="currentColor" d="M37.7,37.6V25h4.5v12.6H55v4.5H42.3V55h-4.5V42.1H25v-4.5H37.7z"></path>
</svg>
</a>
</div>
<?php }?>
<?php }?>
</div>
</div>
</section>
<?php }?>
<?php }elseif($item['id']==159){?>
<?php if(count($item['child'])>0){?>
<section class="padding-main set-post" data-post="about-value" data-href="<?php echo str_replace('HTTP_SERVER',HTTP_SERVER,$item['href']);?>" data-title="<?php echo $item['meta_title'];?>" data-description="<?php echo $item['meta_description'];?>" data-keyword="<?php echo $item['meta_keyword'];?>">
<div class="wrap-content">
<?php foreach($item['child'] as $child){?>
<?php if(!empty($child['description'])){?>
<div class="item-value">
<div class="pic-img pic-value  ani-item"><img src="<?php echo !empty($child['image'])?HTTP_IMAGE . $child['image']:PATH_IMAGE_BG;?>" alt="<?php echo $child['name'];?>"></div>
<div class="txt-value ani-item">
<div class="center-value">
<h3><?php echo $child['name'];?></h3>
<?php echo str_replace('HTTP_CATALOG',HTTP_SERVER,$child['description']);?>
</div>
</div>
</div>
<?php }?>
<?php }?>
</div>
</section>
<?php }?>
<?php }elseif($item['id']==34){?>
<?php if(count($item['child'])>0){?>
<section class="padding-main about-video set-post" data-post="about-video" data-href="<?php echo str_replace('HTTP_SERVER',HTTP_SERVER,$item['href']);?>" data-title="<?php echo $item['meta_title'];?>" data-description="<?php echo $item['meta_description'];?>" data-keyword="<?php echo $item['meta_keyword'];?>">
<div class="title-main ani-item"><h2><?php echo !empty($item['name1'])?$item['name1']:$item['name'];?></h2></div>
<div class="wrap-content">
<div class="slider-pic ani-item">
<?php foreach($item['child'] as $i_sh){?>
<?php if(!empty($i_sh['script'])){?>
<div class="item-video ani-item">
<div class="pic-img">
<img src="<?php echo !empty($i_sh['image_video'])?HTTP_IMAGE . $i_sh['image_video']:'';?>" alt="<?php echo $i_sh['name'];?>">
<a href="javascript:void(0);" data-href="<?php echo HTTP_SERVER;?>view-video-aboutus.html?id=<?php echo $i_sh['id'];?>" class="view-video" data-embed="<?php echo $i_sh['script'];?>">
<svg  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 110 110">
<path fill="#FF0000" d="M107.745,28.768c-1.269-4.713-4.984-8.428-9.696-9.697c-8.609-2.356-43.05-2.356-43.05-2.356
s-34.438,0-43.048,2.267c-4.622,1.268-8.429,5.075-9.697,9.787c-2.266,8.609-2.266,26.463-2.266,26.463s0,17.944,2.266,26.463
c1.269,4.713,4.984,8.429,9.698,9.697C20.651,93.748,55,93.748,55,93.748s34.439,0,43.049-2.266
c4.712-1.268,8.428-4.984,9.696-9.697c2.267-8.609,2.267-26.463,2.267-26.463S110.103,37.377,107.745,28.768z"></path>
<path fill="#FFFFFF" d="M44.034,71.727l28.638-16.495L44.034,38.737V71.727z"></path>
</svg>
</a>
</div>
<h3><?php echo $i_sh['name'];?></h3>
</div>
<?php }?>
<?php }?>
</div>
</div>
</section>
<?php }?>
<?php }?>
<?php }?>
</div>
<!--CONTAINER-->
<?php echo $footer;?>
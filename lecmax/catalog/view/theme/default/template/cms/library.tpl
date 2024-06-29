<?php echo $header;?>
<!--CONTAINER-->
<div class="container"  id="library-page">
<section class="banner-inner">
<div class="title-page"><h1><?php echo $infoActive['name'];?></h1></div>
<div class="slide-mask" data-time="<?php echo $infoActive1['config_loop_picture'];?>000">
<?php if(count($infoActive1['images'])>0){?>
<?php foreach($infoActive1['images'] as $item){?>
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
<?php foreach($submenu as $item){?>
<?php if($item['id']==ID_VIDEO){?>
<li <?php if($item['id']==$menu_active) echo 'class="current"';?> ><a href="<?php echo str_replace('HTTP_SERVER',HTTP_SERVER,$item['href']);?>" class="link-load" data-name="video" data-title="<?php echo $item['meta_title'];?>" data-description="<?php echo $item['meta_description'];?>" data-keyword="<?php echo $item['meta_keyword'];?>"><?php echo $item['name'];?></a></li>
<?php }elseif($item['id']==ID_DOCUMENT){?>
<li <?php if($item['id']==$menu_active) echo 'class="current"';?> ><a href="<?php echo str_replace('HTTP_SERVER',HTTP_SERVER,$item['href']);?>" class="link-load" data-name="document" data-title="<?php echo $item['meta_title'];?>" data-description="<?php echo $item['meta_description'];?>" data-keyword="<?php echo $item['meta_keyword'];?>"><?php echo $item['name'];?></a></li>
<?php }?>
<?php }?>
</ul>
</div>
</section>
<?php if($menu_active==ID_VIDEO){?>
<section class="padding-main">
<div class="list-video">
<?php if(count($videos)>0){?>
<?php foreach($videos as $item){?>
<?php if(!empty($item['script'])){?>
<div class="item-video ani-item">
<div class="pic-img">
<img src="<?php echo !empty($item['image_video'])?HTTP_IMAGE . $item['image_video']:PATH_IMAGE_BG;?>" alt="<?php echo $item['name'];?>">
<a href="javascript:void(0);" data-href="<?php echo HTTP_SERVER;?>view-video.html?id=<?php echo $item['id'];?>" class="view-video" data-embed="<?php echo $item['script'];?>">
<svg  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 110 110">
<path fill="#FF0000" d="M107.745,28.768c-1.269-4.713-4.984-8.428-9.696-9.697c-8.609-2.356-43.05-2.356-43.05-2.356
s-34.438,0-43.048,2.267c-4.622,1.268-8.429,5.075-9.697,9.787c-2.266,8.609-2.266,26.463-2.266,26.463s0,17.944,2.266,26.463
c1.269,4.713,4.984,8.429,9.698,9.697C20.651,93.748,55,93.748,55,93.748s34.439,0,43.049-2.266
c4.712-1.268,8.428-4.984,9.696-9.697c2.267-8.609,2.267-26.463,2.267-26.463S110.103,37.377,107.745,28.768z"></path>
<path fill="#FFFFFF" d="M44.034,71.727l28.638-16.495L44.034,38.737V71.727z"></path>
</svg>
</a>
</div>
<h3><?php echo $item['name'];?></h3>
</div>
<?php }?>
<?php }?>
<?php }else{?>
<p class="data-updating"><?php echo $text_data_updating;?></p>
<?php }?>
</div>
</section>
<?php }elseif($menu_active==ID_DOCUMENT){?>
<section class="padding-main">
<div class="list-document">
<?php if(count($documents)>0){?>
<?php foreach($documents as $item){?>
<div class="item-document ani-item<?php if($item['id']==$document_id) echo ' current';?>">
<div class="pic-img"><img src="<?php echo !empty($item['image'])?HTTP_IMAGE . $item['image']:PATH_IMAGE_THUMB;?>" alt="<?php echo $item['name'];?>"></div>
<div class="txt-document">
<h3><?php echo $item['name'];?></h3>
</div>
<a href="<?php echo str_replace('HTTP_SERVER',HTTP_SERVER,$item['href']);?>" data-name="document-<?php echo $item['id'];?>"  data-title="<?php echo $item['meta_title'];?>" data-description="<?php echo $item['meta_description'];?>" data-keyword="<?php echo $item['meta_keyword'];?>"></a>
</div>
<?php }?>
<?php }else{?>
<p class="data-updating"><?php echo $text_data_updating;?></p>
<?php }?>
</div>
</section>
<?php }?>
</div>
<!--CONTAINER-->
<?php echo $footer;?>
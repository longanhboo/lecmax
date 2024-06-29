<div class="album-load">
<div class="close-album">
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><path fill="currentColor" d="M50,54 27.2,76.8 23.2,72.8 46,50 23.2,27.2 27.2,23.2 50,46 72.8,23.2 76.8,27.2 54,50 76.8,72.8 72.8,76.8z"></path></svg>
</div>
<div class="album-center">
<?php foreach($album as $item){?>
<?php if(!empty($item['image'])){?>
<div class="album-pic-center">
<?php if(!empty($item['name'])){?>
<div class="pic-name">
<h3><?php echo $item['name'];?></h3>
</div>
<?php }?>
<div class="container-zoom"><img src="<?php echo HTTP_IMAGE . $item['image'];?>" alt="<?php echo $item['name'];?>"></div>
</div>
<?php }?>
<?php }?>
</div>
<div class="thumbs">
<?php foreach($album as $item){?>
<?php if(!empty($item['image'])){?>
<div class="thumb-item"><a href="javascript:void(0);"><img src="<?php echo HTTP_IMAGE . $item['image'];?>" alt="<?php echo $item['name'];?>"></a></div>
<?php }?>
<?php }?>
</div>
</div>
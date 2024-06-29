<div class="album-load">
<div class="close-album"></div>
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
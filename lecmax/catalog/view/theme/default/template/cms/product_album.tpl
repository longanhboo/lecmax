<div class="album-load">
<div class="close-album"></div>
<div class="slide-pic-nav">
<div class="next-pic"></div>
<div class="prev-pic"></div>
</div>
<div class="album-center">
<div class="item-wrapper">
<?php foreach($album as $item){?>
<?php if(!empty($item['image'])){?>
<div class="album-pic-center  item-container">
<?php if(!empty($item['name'])){?>
<div class="pic-name">
<h3><?php echo $item['name'];?></h3>
</div>
<?php }?>
<div class="container-zoom">
<img class="lazy" data-src="<?php echo $item['image'];?>" alt="<?php echo $item['name'];?>">
</div>
<div class="lazy-preloader"></div>
</div>
<?php }?>
<?php }?>
</div>
</div>
</div>
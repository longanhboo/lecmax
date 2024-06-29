<div class="load-details service-loads">
<div class="load-title">
<h3><?php echo $service['name'];?></h3>
</div>
<div class="load-text ani-item">
<?php echo str_replace('HTTP_CATALOG',HTTP_SERVER,$service['description']);?>
</div>
<div class="print ani-item">
<div class="print-box">
<a class="save-but" href="javascript:void(0)"><?php echo $text_luu_trang;?></a>
<a class="print-but" href="javascript:void(0)"><?php echo $text_in_trang;?></a>
<a class="share-but" href="javascript:void(0)"><?php echo $text_share;?></a>
<div class="share-item">
<ul>
<li><a class="item-facebook" href="http://www.facebook.com/sharer.php?u=<?php echo $service['href'];?>" target="_blank"></a></li>
<li><a class="item-linkedin" href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo $service['href'];?>&title=<?php echo !empty($service['meta_title'])?$service['meta_title']:$service['name'];?>&summary=<?php echo $service['meta_description'];?>" target="_blank"></a></li>
</ul>
</div>
</div>
</div>
</div>
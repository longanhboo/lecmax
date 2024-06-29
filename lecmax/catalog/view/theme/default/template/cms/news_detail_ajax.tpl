<div class="load-details">
<div class="load-title">
<h1><?php echo $news['name'];?></h1>
<div class="date-news"><?php echo date('d',strtotime($news['date_insert']));?><span><?php echo date('m - Y',strtotime($news['date_insert']));?></span></div>
</div>
<div class="load-text ani-item">
<?php echo str_replace('HTTP_CATALOG',HTTP_SERVER,$news['description']);?>
</div>
<div class="print ani-item">
<div class="print-box">
<a class="save-but" href="javascript:void(0)"><?php echo $text_luu_trang;?></a>
<a class="print-but" href="javascript:void(0)"><?php echo $text_in_trang;?></a>
<a class="share-but" href="javascript:void(0)"><?php echo $text_share;?></a>
<div class="share-item">
<ul>
<li><a class="item-facebook" href="http://www.facebook.com/sharer.php?u=<?php echo $news['href'];?>" target="_blank"></a></li>
<li><a class="item-linkedin" href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo $news['href'];?>&title=<?php echo !empty($news['meta_title'])?$news['meta_title']:$news['name'];?>&summary=<?php echo $news['meta_description'];?>" target="_blank"></a></li>
</ul>
</div>
</div>
</div>
</div>
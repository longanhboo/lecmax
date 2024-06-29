<div class="details-content">
<div class="details-center">
<div class="details-outer">
<h2><?php echo $recruitment['name'];?></h2>
<div class="details-text">
<?php echo str_replace('HTTP_CATALOG',HTTP_SERVER,$recruitment['description']);?>
</div>
</div>
<?php if(isset($recruitments[0]) && (!empty($recruitments[0]['pdf']) || !empty($recruitments[0]['link']))){?>
<div class="download-but"><a href="<?php echo (!empty($recruitments[0]['link']))?str_replace('HTTP_CATALOG',HTTP_SERVER,$recruitments[0]['link']):HTTP_PDF . $recruitments[0]['pdf'];?>" target="_blank"><?php echo $text_download_mau_don;?></a></div>
<?php }?>
</div>
<span></span>
<a href="<?php echo str_replace('HTTP_SERVER',HTTP_SERVER,$getActive['href']);?>" class="close-popup" data-name="<?php echo $getActive['category_id'];?>" data-title="<?php echo $getActive['meta_title'];?>" data-keyword="<?php echo $getActive['meta_keyword'];?>" data-description="<?php echo $getActive['meta_description'];?>"></a>
</div>
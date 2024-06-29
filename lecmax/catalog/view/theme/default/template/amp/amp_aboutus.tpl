<?php echo $headeramp;?>
<body>
<?php echo $menuamp;?> 
<!--BANNER-->
<figure class="ampstart-image-banner relative">
<div class="line-worker absolute center">
</div>
<amp-img width="1" height="<?php echo $ampcd['img_ratio'];?>"  alt="<?php echo $ampcd['name1'];?>" layout="responsive" src="<?php echo $ampcd['image'];?>"></amp-img>
<figcaption class="absolute">
<header>
<h1 class="title-page  relative  uppercase"><?php echo $text_companyname_amp;?></h1>
</header>
<footer class="absolute left-0 right-0 bottom-0">
<a class="ampstart-readmore py3 caps line-height-2 text-decoration-none center block relative" href="#content"></a>
</footer>
</figcaption>
</figure>
<!--BANNER-->
<!--CONTENT-->
<main id="content" class="content-post relative" role="main">
<h2 class="flex justify-center items-center center  relative  uppercase"><?php echo $ampcd['name1'];?></h2>
<aside class="post-text relative">
<?php foreach($aboutuss as $key=>$item){?>
<?php if($item['id']==46){?>
<?php if(count($item['child'])>0){?>
<article class="ampstart-article-summary relative">
<div class="title"><h2><?php echo $item['name'];?></h2></div>
<div class="value-box">
<?php foreach($item['child'] as $child){?>
<div class="value-item ani-item">
<h3><?php echo $child['name'];?></h3>
<div class="value-text">
<?php echo str_replace('HTTP_CATALOG',HTTP_SERVER,$child['description']);?>
</div>
</div>
<?php }?>
</div>
</div>
</article>
<?php }?>
<?php }elseif($item['id']==56){?>
<?php if(!empty($item['image_sodo'])){?>
<article class="ampstart-article-summary relative">
<div class="title"><h2><?php echo $item['name'];?></h2></div>
<div class="chart-box ani-item">
<div class="chart-pic"><amp-img width="1" height="<?php echo $item['image_sodo_ratio'];?>" layout="responsive" noloading="" src="<?php echo HTTP_IMAGE . $item['image_sodo'];?>" srcset="<?php echo  HTTP_IMAGE . $item['image_sodo'];?> 1x,<?php echo  HTTP_IMAGE . $item['image_sodo'];?> 2x" alt="<?php echo $item['name'];?>"></amp-img></div>
</div>
</article>
<?php }?>
<?php }elseif($item['id']==50){?>
<article class="ampstart-article-summary relative">
<div class="about-box ani-item">
<div class="intro-box">
<div class="title"><h2><?php echo $item['name'];?></h2></div>
<div class="intro-text">
<?php echo str_replace('HTTP_CATALOG',HTTP_SERVER,$item['description']);?>
</div>
</div>
<?php $demchild=count($item['child']);?>
<?php if($demchild>0){?>
<div class="achivement-box blue">
<div class="scroll-achivement">
<div class="achivement-slider">
<div class="partner-list">
<ul>
<?php foreach($item['child'] as $child){?>
<?php if(!empty($child['image'])){?>
<li>
<amp-img width="1" height="<?php echo $child['image_ratio'];?>" layout="responsive" noloading="" src="<?php echo HTTP_IMAGE . $child['image'];?>" srcset="<?php echo  HTTP_IMAGE . $child['image'];?> 1x,<?php echo  HTTP_IMAGE . $child['image'];?> 2x" alt="<?php echo $child['name'];?>"></amp-img>
<?php if(!empty($child['name'])){?><div class="achivement-text"><h3><?php echo $child['name'];?></h3></div><?php }?>
</li>
<?php }?>
<?php }?>
</ul>
</div>
</div>
</div>
</div>
<?php }?>
</div>
</article>
<?php }elseif($item['id']==3){?>
<?php if(count($item['child'])>0){?>
<article class="ampstart-article-summary relative">
<div class="title"><h2><?php echo $item['name'];?></h2></div>
<div class="history-box ani-item">
<div class="history-slider">
<?php foreach($item['child'] as $child){?>
<div class="history-item">
<div class="history-outer">
<div class="history-info">
<div class="year"><?php echo !empty($child['name2'])?$child['name2']:$child['name'];?></div>
<?php echo str_replace('HTTP_CATALOG',HTTP_SERVER,$child['description']);?>
</div>
</div>
</div>
<?php }?>
</div>
</div>
</article>
<?php }?>
<?php }elseif($item['id']==19){?>
<?php if(count($item['child'])>0){?>
<article class="ampstart-article-summary relative">
<div class="title"><h2><?php echo $item['name'];?></h2></div>
<div class="value-box">
<?php foreach($item['child'] as $child){?>
<div class="market-box">
<div class="market-text ani-item">
<h3><?php echo $child['name'];?></h3>
<?php echo str_replace('HTTP_CATALOG',HTTP_SERVER,$child['description']);?>
</div>
<?php if(!empty($child['image'])){?>
<div class="market-pic ani-item"><amp-img width="1" height="<?php echo $child['image_ratio'];?>" layout="responsive" noloading="" src="<?php echo HTTP_IMAGE . $child['image'];?>" srcset="<?php echo  HTTP_IMAGE . $child['image'];?> 1x,<?php echo  HTTP_IMAGE . $child['image'];?> 2x" alt="<?php echo $item['name'];?>"></amp-img></div>
<?php }?>
</div>
<?php }?>
</div>
</div>
</article>
<?php }?>
<?php }elseif($item['id']==55){?>
<?php if(count($item['child'])>0){?>
<article class="ampstart-article-summary relative">
<div class="title"><h2><?php echo $item['name'];?></h2></div>
<div class="factory-box blue">
<div class="factory-slider">
<div class="partner-list">
<ul>
<?php foreach($item['child'] as $child){?>
<?php if(!empty($child['image'])){?>
<li>
<amp-img width="1" height="<?php echo $child['image_ratio'];?>" layout="responsive" noloading="" src="<?php echo HTTP_IMAGE . $child['image'];?>" srcset="<?php echo  HTTP_IMAGE . $child['image'];?> 1x,<?php echo  HTTP_IMAGE . $child['image'];?> 2x" alt="<?php echo $child['name'];?>"></amp-img>
<?php if(!empty($child['name'])){?><div class="achivement-text"><h3><?php echo $child['name'];?></h3></div><?php }?>
</li>
<?php }?>
<?php }?>
</ul>
</div>
</div>
</div>
</div>
</article>
<?php }?>

<?php }?>
<?php }?>
</aside>
</main>
<!--CONTENT-->
</body>
</html>
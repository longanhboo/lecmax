<?php echo $headeramp;?>
<body>
<?php echo $menuamp;?>
<!--BANNER-->
<figure class="ampstart-image-banner relative">
<div class="line-worker absolute center transform">
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
<?php foreach($ampcd['amp_pagelistcontact'] as $item){?>
<?php if($item==1){?>
<?php if(isset($contacts[0])){?>
<article class="ampstart-article-summary relative">
<h3  class="flex justify-center items-center center  relative  uppercase"><?php echo $contacts[0]['name'];?></h3>
<ul class="center">
<?php if(!empty($contacts[0]['address'])){?>
<li>
<div class="icon address">
<svg  xmlns="http://www.w3.org/2000/svg"  x="0px" y="0px" viewBox="0 0 50 50">
<path d="M25.6,5c-7.5,0-13.7,6.2-13.7,13.7c0,2.5,0.7,4.9,1.8,6.9L25.6,46l11.9-20.4c1.2-2,1.8-4.4,1.8-6.9 C39.3,11.2,33.2,5,25.6,5z M25.6,22.1c-1.8,0-3.3-1.5-3.3-3.3s1.5-3.3,3.3-3.3s3.3,1.5,3.3,3.3S27.5,22.1,25.6,22.1z"></path>
</svg>
</div>
<p><?php echo $contacts[0]['address'];?></p>
</li>
<?php }?>
<?php if(!empty($contacts[0]['phonelist'])){?>
<li>
<div class="icon phone">
<svg  xmlns="http://www.w3.org/2000/svg"  x="0px" y="0px" viewBox="0 0 50 50">
<path d="M41.8,35.6L41.8,35.6c0,0-4.4-2.9-6.3-4.2c-0.7-0.5-1.5-0.7-2.2-0.7c-1,0-1.7,0.5-1.7,0.5l0,0
	c0,0-0.3,0.3-1.2,1c-0.8,0.7-1.9,0.5-2.7-0.3c-1.2-1-7.4-8.8-9.3-11.5c-0.3-0.5-0.5-1-0.5-1.5c0.2-1,1.4-1.7,1.9-2.2l0.2-0.2
	c1.2-0.8,1.4-2.4,1-3.4c-0.3-0.7-2.7-6.1-3-6.8c-0.5-0.3-1-1.2-2.4-1.2c-0.8,0-2.9,0.3-4.2,1.4L11,6.7c-1.2,0.8-3.5,2.4-3.5,5.6
	c0,4.2,3,10.3,9.5,18.9c6.8,9.1,14.9,13.5,18.3,13.5c3,0,6.1-3.7,6.9-5.6C43.2,37.4,42.5,36.1,41.8,35.6z"/></svg>
</div>
<p><?php echo $contacts[0]['phonelist'];?></p>
</li>
<?php }?>
<?php if(!empty($contacts[0]['tax'])){?>
<li>
<p><?php echo $text_mst;?> <?php echo $contacts[0]['tax'];?></p>
</li>
<?php }?>
<?php if(!empty($contacts[0]['faxlist'])){?>
<li>
<p><?php echo $text_fax_infobox;?> <?php echo $contacts[0]['faxlist'];?></p>
</li>
<?php }?>
<?php if(!empty($contacts[0]['emaillist'])){?>
<li>
<div class="icon  mail">
<svg  xmlns="http://www.w3.org/2000/svg"  x="0px" y="0px" viewBox="0 0 50 50">
<path   d="M35.3,16.1 35.3,27.4 41,21.6z"></path>
<path  d="M25.6,6.2c-0.6-0.6-1.7-0.6-2.4,0l-2.4,2.4h7.3L25.6,6.2z"></path>
<path   d="M13.5,16.1 8.6,21 7.8,21.6 13.5,27.4z"></path>
<path   d="M17.2,33.4 17.2,33.3 7.7,23.7 7.7,23.9 7.7,24.2 7.7,24.8 7.7,42.8z"></path>
<path  d="M39,42.6L39,42.6L25.6,29.3c-0.6-0.6-1.7-0.6-2.4,0L9.6,43l0,0l-0.8,0.8h31.2l-0.3-0.3L39,42.6z"></path>
<path   d="M31.7,33.3 31.8,33.4 31.8,33.4 41.2,42.8 41.2,24.2 41.2,23.9 41.2,23.6z"></path>
<path  d="M22.3,28.3c0.6-0.6,1.4-1,2.2-1s1.6,0.3,2.2,1l0.5,0.5l3.3,3.3l3.3-3.3V14.5L29.4,10H15v18.8l3.3,3.3L22.3,28.3z M19.4,14.5h10.2v1.4H19.4C19.4,15.9,19.4,14.5,19.4,14.5z M19.4,18.9h7.3v1.4h-7.3C19.4,20.4,19.4,18.9,19.4,18.9z M19.4,23.2h10.2v1.6H19.4C19.4,24.8,19.4,23.2,19.4,23.2z"></path>
</svg>
</div>
<p><?php echo $contacts[0]['emaillist'];?></p>
</li>
<?php }?>
<?php if(!empty($contacts[0]['hotlinelist'])){?>
<li>
<p><?php echo $text_hotline_infobox;?><br><?php echo $contacts[0]['hotlinelist'];?></p>
</li>
<?php }?>
</ul>
</article>
<?php }?>
<?php }elseif($item==2){?>
<!--Google Map-->
<?php }elseif($item==3){?>
<!--Form-->
<?php }?>
<?php }?>
</aside>
</main>
<!--CONTENT-->
</body>
</html>
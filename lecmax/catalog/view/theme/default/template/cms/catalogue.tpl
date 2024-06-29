<?php echo $header;?>
<!--CONTAINER-->
<div class="container"  id="catalogue-page">
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
<section class="padding-main">
<div class="list-catalogue">
<?php $stt=0;foreach($filepdfs as $item){?>
<?php 
$image_pdf = empty($item['image']) || !is_file(DIR_IMAGE . $item['image'])? PATH_IMAGE_BG : HTTP_IMAGE . $item['image'];
$pdf = empty($item['pdf']) || !is_file(DIR_PDF . $item['pdf'])? '' : HTTP_PDF . $item['pdf'];
$linkpdf = empty($item['linkpdf']) || !is_file(DIR_PDF . $item['linkpdf'])? '' : HTTP_PDF . $item['linkpdf'];
$link_pdf = !empty($linkpdf)?$linkpdf:$pdf;
?>
<?php if(!empty($link_pdf)){?>
<div class="item-cata ani-item">
<h3><?php echo $item['name'];?></h3>
<div class="pic-img">
<img src="<?php echo $image_pdf;?>" alt="<?php echo $item['name'];?>">
</div>
<a href="<?php echo $link_pdf;?>" class="view-pdf" target="_blank">
<svg  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 110 110">
<path fill="currentColor" d="M56.914,69.734 56.914,62.525 49.417,62.525 49.417,69.734 45.464,69.734 53.117,79.239 
60.771,69.734z"></path>
<path fill="currentColor" d="M32.222,39.849c-0.426,0-0.715,0.041-0.866,0.084v2.734c0.179,0.041,0.398,0.055,0.701,0.055
c1.113,0,1.8-0.563,1.8-1.512C33.857,40.357,33.267,39.849,32.222,39.849z"></path>
<path fill="currentColor" d="M43.233,42.818c0.014-1.925-1.113-2.942-2.914-2.942c-0.467,0-0.77,0.042-0.948,0.082v6.063
c0.179,0.041,0.468,0.041,0.729,0.041C41.997,46.076,43.233,45.031,43.233,42.818z"></path>
<path fill="currentColor" d="M61.49,17.65H36.149c-3.739,0-6.781,3.042-6.781,6.781v10.632C26.909,35.377,25,37.456,25,40v6.5
c0,2.544,1.908,4.622,4.368,4.937v18.682c0,3.738,3.042,6.78,6.781,6.78h11.237l-4.832-6h-6.406c-0.423,0-0.781-0.357-0.781-0.78
V51.5h15.715c2.762,0,5-2.239,5-5V40c0-2.761-2.238-5-5-5H35.368V24.431c0-0.423,0.357-0.781,0.781-0.781h22.837l0.834,0.843v6.935
c0,2.079,1.701,3.781,3.781,3.781h6.817l0.788,0.797v34.112c0,0.423-0.357,0.78-0.781,0.78h-6.745l-4.832,6h11.577
c3.739,0,6.781-3.042,6.781-6.78V33.54L61.49,17.65z M46.837,38.337H52.5v1.719h-3.56v2.115h3.328v1.705H48.94v3.726h-2.103V38.337
z M37.268,38.46c0.77-0.123,1.773-0.191,2.832-0.191c1.759,0,2.899,0.316,3.793,0.99c0.962,0.714,1.566,1.855,1.566,3.49
c0,1.773-0.646,2.997-1.539,3.754c-0.976,0.811-2.46,1.195-4.275,1.195c-1.086,0-1.855-0.069-2.378-0.137V38.46z M35.933,41.155
c0,0.906-0.303,1.676-0.852,2.199c-0.715,0.674-1.773,0.975-3.01,0.975c-0.275,0-0.522-0.013-0.715-0.04v3.313H29.28V38.46
c0.646-0.109,1.553-0.191,2.832-0.191c1.292,0,2.213,0.248,2.832,0.742C35.534,39.479,35.933,40.248,35.933,41.155z"></path>
</svg>
</a>
</div>
<?php }?>
<?php }?>
</div>
</section>
</div>
<!--CONTAINER-->
<?php echo $footer;?>
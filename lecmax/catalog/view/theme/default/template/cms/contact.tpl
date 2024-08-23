<?php echo $header;?>
<!--CONTAINER-->
<div class="container"  id="contact-page">
<section class="banner-inner">
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
<div class="title-main"><h1><?php echo $text_thong_tn_lien_he;?></h1></div>
<div class="info-contact">
<?php $json_map = '[';$googlemap='';?>
<?php foreach($contacts as $keynw=>$item){?>
<?php 
	if(!empty($item['googlemap'])) $googlemap=$item['googlemap'];
    $json_map .= '{';
    $temp_info = '';
    if(!empty($item['address'])){
    	$temp_info .= '\u003cstrong\u003eA\u003c/strong\u003e ' . $item['address'] . '\u003cbr\u003e';
    }
    if(!empty($item['phonelist'])){
    	$temp_info .= '\u003cstrong\u003eT\u003c/strong\u003e ' . $item['phonelist_json'] . '\u003cbr\u003e';
    }
    if(!empty($item['faxlist'])){
    	$temp_info .= '\u003cstrong\u003eF\u003c/strong\u003e ' . $item['faxlist_json'] . '\u003cbr\u003e';
    }
    
    $json_map .= '"contact_id":'.$item['id'].',"id":"' . 'agen_' . $item['id'] . '","idProvince":0,"idDistrict":0,"name":"' . $item['name'] . '","lat":'. $item['location'][0] . ',"lng":'. $item['location'][1] . ',"html":"\u003ch3\u003e' . $item['name'] . '\u003c/h3\u003e\u003cp\u003e' . $temp_info . '\u003c/p\u003e"';
    $json_map .= '}';
    if($keynw<count($contacts)-1){
        $json_map .= ',';
    }
?>
<div class="col-contact ani-item">
<h3><?php echo $item['name'];?></h3>
<ul class="company-info">
<?php if(!empty($item['address'])){?><li><p class="address"><?php echo $item['address'];?></p></li><?php }?>
<?php if(!empty($item['phonelist'])){?><li><p class="phone"><?php echo $item['phonelist'];?></p></li><?php }?>
<?php if(!empty($item['faxlist'])){?><li><p class="fax"><?php echo $item['faxlist'];?></p></li><?php }?>
</ul>
</div>
<?php }?>
<?php $json_map .= ']';?>
</div>
<div class="json-map class-hidden"><?php echo $json_map;?></div>
</section>
<section class="contact-map">
<div class="map-box ani-item">
<div class="googlemap">
<div id="map-canvas">
<?php echo $googlemap;?>
</div>
<!--<div class="zoom-control">
<a class="zoom-in" href="javascript:void(0);" id="zoom-in"></a>
<a class="zoom-out" href="javascript:void(0);" id="zoom-out"></a>
</div>-->
</div>
</div>
</section>
<section class="form-contact padding-main">
<div class="contact-form">
<div class="title-main title-red"><h2><?php echo $text_form_lien_he;?></h2></div>
<form id="contact_form" onSubmit="return validatecontact();" name="contact_form" method="post">
<div class="row-c">
<div class="col-6">
<div class="input-text ani-item">
<input id="name" name="name" value="<?php echo $name;?>" type="text" data-holder="<?php echo $name;?>" data-error="<?php echo $error_name;?>" data-default="<?php echo $text_name;?>">
</div>
<div class="input-text ani-item">
<input id="phone" name="phone" value="<?php echo $phone;?>" type="text" data-holder="<?php echo $phone;?>" data-error="<?php echo $error_phone;?>" data-default="<?php echo $text_phone;?>">
</div>
<div class="input-text ani-item">
<input id="email" name="email" value="<?php echo $email;?>" type="text" data-holder="<?php echo $email;?>" data-error="<?php echo $error_email;?>" data-default="<?php echo $text_email;?>">
</div>
</div>
<div class="col-6">
<div class="input-text ani-item">
<textarea data-holder="<?php echo $comments;?>" name="comments" id="comments" data-error="<?php echo $error_comments;?>" data-default="<?php echo $text_comments;?>"><?php echo $comments;?></textarea>
</div>
</div>
</div>
<div class="input-but ani-item">
<div class="captcha"><div class="g-recaptcha" data-sitekey="<?php echo site_key;?>"></div></div>
<div class="outer-but"><button class="btn-1"  id="btn-contact-submit" ><span><?php echo $text_send;?></span></button></div>
</div>
</form>
</div>
</section>
</div>
<!--CONTAINER-->
<?php echo $footer;?>
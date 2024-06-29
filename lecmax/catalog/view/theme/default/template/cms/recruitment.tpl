<?php echo $header;?>
<!--CONTAINER-->
<div class="container"  id="recruitment-page">
<div class="title-page"  id="recruitment"><h1><?php echo $getActive['name'];?></h1></div>
<!--BANNER-->
<section class="banner-inner">
<div class="slide-mask" data-time="<?php echo $getActive['config_loop_picture'];?>000" >
<?php foreach($getActive['images'] as $item){?>
<div class="bg-inner" style="background-image:url(<?php echo !empty($item['image'])?HTTP_IMAGE . $item['image']:PATH_IMAGE_BG;?>)">
<div class="slide-overlay"></div>
</div>
<?php }?>
</div>
</section>
<!--BANNER-->
<section class="content-page">
<h2 class="color-grey  ani-item"><?php echo !empty($getActive['name1'])?$getActive['name1']:$getActive['name'];?></h2>
<div class="career-box  ani-item">
<div class="career-list">
<div class="content-table">
<table>
<thead class="head-list">
<tr>
<th scope="Number"><?php echo $text_stt;?></th>
<th scope="Position"><?php echo $text_vi_tri_tuyen_dung;?></th>
<th scope="Quantity"><?php echo $text_so_luong;?></th>
<th scope="Location"><?php echo $text_dia_diem_lam_viec;?></th>
<th scope="Expire"><?php echo $text_ngay_het_han;?></th>
<th scope="Status"><?php echo $text_tinh_trang_dang_tuyen;?></th>
</tr>
</thead>
<tbody>
<?php if(isset($recruitments[0]) && count($recruitments[0]['child'])>0){?> 
<?php foreach($recruitments[0]['child'] as $key=>$item){?>
<tr>
<td data-label="<?php echo $text_stt;?>"><?php if($key<9) echo '0'; echo $key+1;?></td>
<td data-label="<?php echo $text_vi_tri_tuyen_dung;?>" class="career-title"><h3><a class="<?php if($item['id']==$recruitment_id) echo 'current';?>" href="<?php echo str_replace('HTTP_SERVER',HTTP_SERVER,$item['href']);?>" data-name="career-<?php echo $item['id'];?>" data-title="<?php echo $item['meta_title'];?>" data-description="<?php echo $item['meta_description'];?>" data-keyword="<?php echo $item['meta_keyword'];?>" ><?php echo $item['name'];?></a></h3></td>
<td data-label="<?php echo $text_so_luong;?>"><?php echo $item['soluong'];?></td>
<td data-label="<?php echo $text_dia_diem_lam_viec;?>"><?php echo $item['diadiem'];?></td>
<td data-label="<?php echo $text_ngay_het_han;?>"><?php echo $item['date_insert'];?></td>
<td data-label="<?php echo $text_tinh_trang_dang_tuyen;?>">
<?php if($item['tinhtrang']==1){?>
<span class="status hot"><a href="<?php echo str_replace('HTTP_SERVER',HTTP_SERVER,$item['href']);?>" data-name="career-<?php echo $item['id'];?>" data-title="<?php echo $item['meta_title'];?>" data-description="<?php echo $item['meta_description'];?>" data-keyword="<?php echo $item['meta_keyword'];?>"><?php echo $text_gap;?></a></span>
<?php }else{?>
<span class="status">...</span>
<?php }?>
</td>
</tr>
<?php }?>
<?php }else{?>
<tr>
<td colspan="6"><?php echo $text_chua_co_vi_tri_can_tuyen;?></td>
</tr>
<?php }?>
</tbody>
</table>
</div>
</div>
</div>
<div class="career-form ani-item">
<div class="join-title">
<h3><?php echo $text_dien_thong_tin_nop_don;?></h3>
</div>
<div class="join-us">
<div class="join-form">
<form action="<?php echo HTTP_SERVER;?>send-recruitment-ajax.html" id="recruitment_form" onSubmit="return validaterecruitment();" name="recruitment_form" method="post"  enctype="multipart/form-data" target="upload_target">
<div class="input-text"><input id="name" name="name" value="<?php echo $name;?>" type="text" data-holder="<?php echo $name;?>" data-error="<?php echo $error_name_recruitment;?>" data-default="<?php echo $text_name_recruitment;?>"></div>
<div class="input-text"><input id="email" name="email" value="<?php echo $email;?>" type="text" data-holder="<?php echo $email;?>" data-error="<?php echo $error_email_recruitment;?>" data-default="<?php echo $text_email_recruitment;?>"></div>
<div class="input-text"><input id="phone" name="phone" value="<?php echo $phone;?>" type="text" data-holder="<?php echo $phone;?>" data-error="<?php echo $error_phone_recruitment;?>" data-default="<?php echo $text_phone_recruitment;?>"></div>
<div class="input-text file-up">
<input id="fileInput" type="file" name="myfile" onchange="onChange(this);"><span class="file-name" id="file-name" data-text="<?php echo $text_file_ho_so_cua_ban;?>"><?php echo $text_file_ho_so_cua_ban;?></span><span class="file-mark"><?php echo $text_browse;?></span>
<iframe id="upload_target" name="upload_target" src="#" style="width:100%;height:0;border:0px solid #fff; z-index:-99999999;overflow:hidden"></iframe>
</div>
</form>
</div>
<div class="input-but text-center"><button type="submit" class="btn-blue"  id="btn-recruitment-submit" ><?php echo $text_nop_don;?></button></div>
</div>
</div>
</section> 
<?php echo $service;?>
</div>
<!--CONTAINER-->
<?php echo $footer;?>
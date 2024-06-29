<div class="video-list">
<div class="close-video">
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><path fill="currentColor" d="M50,54 27.2,76.8 23.2,72.8 46,50 23.2,27.2 27.2,23.2 50,46 72.8,23.2 76.8,27.2 54,50 76.8,72.8 72.8,76.8z"></path></svg>
</div>
<div class="video-wrap">
<?php if($video['isyoutube']){?>

<?php }else{?>
<video id="view-video" class="video-skin"  poster=""  controls autoplay>
<source src="<?php echo $video['filename_mp4'];?>" type='video/mp4; codecs="avc1.42E01E, mp4a.40.2"'/>
</video>
<?php }?>
</div>
</div>
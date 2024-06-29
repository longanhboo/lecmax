<div class="box-video-center">
<div class="video-cover" id="videocontainer" data-fullscreen="false">
<?php if($video['isyoutube']){?>
<?php echo str_replace('iframe ','iframe id="video-youtube" ',$video['script']);?>
<?php }else{?>
<a class="player-vid" href="javascript:void(0);"><span></span></a>
<div class="pic-video" style="background-image:url(<?php echo !empty($video['image_video'])?$video['image_video']:PATH_IMAGE_BG;?>)"></div>
<video id="video-full" class="video-full" preload="auto" loop  muted  controls>
<source src="<?php echo $video['filename_mp4'];?>" type='video/mp4; codecs="avc1.42E01E, mp4a.40.2"'/>
</video>
<div id="videocontrols" class="controls" data-state="hidden">
<button id="stop" class="stop" type="button" data-state="stop"></button>
<button id="playpause" class="playpause" type="button" data-state="play"></button>
<div class="progress"><progress id="progress" value="0" min="0"><span id="progressbar"></span></progress></div>
<button id="mute" class="mute" type="button" data-state="mute"></button>
<button id="fullscreen" class="fullscreen" type="button" data-state="go-fullscreen"></button>
</div>
<?php }?>
</div>
</div>
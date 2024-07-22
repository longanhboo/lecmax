<footer class="footer">
    <div class="top-footer">
        <div class="col-footer ani-item">
            <h3>Công ty cổ phần Lecmax Việt Nam</h3>
            <ul class="company-info">
				<?php foreach($contacts as $item){?>
					<li>
						<?php if(!empty($item['address'])){?><p class="address"><?php echo $item['address'];?></p><?php }?>
						<?php if(!empty($item['phonelist'])){?><p class="phone"><?php echo $item['phonelist'];?></p><?php }?>
						<?php if(!empty($item['faxlist'])){?><p class="fax"><?php echo $item['faxlist'];?></p><?php }?>
					</li>
				<?php }?>
            </ul>
        </div>
        <div class="col-footer ani-item">
            <h3>Chính sách</h3>
            <ul class="company-info">
                <li><p class="policy">Chính sách đại lý</p></li>
                <li><p class="policy">Chính sách bảo mật thông tin</p></li>
                <li><p class="policy">Chính sách bảo hành</p></li>
                <li><p class="policy">Phương thức thanh toán</p></li>
            </ul>
        </div>
        <div class="col-footer ani-item">
            <h3>Kết nối với chúng tôi</h3>
            <ul class="company-info">
                <?php if(!empty($social['fb']) ){?>
					<li>
						<a class="facebook" href="<?php echo $social['fb'];?>" rel="nofollow" target="_blank">
							<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 60 60">
							<path fill="currentColor" d="M36.5,24.5h-5v-3.3c0-1.2,0.8-1.5,1.4-1.5s3.5,0,3.5,0v-5.4l-4.9,0c-5.4,0-6.7,4.1-6.7,6.7v3.6h-3.1v5.6h3.1
							c0,7.2,0,15.9,0,15.9h6.6c0,0,0-8.8,0-15.9h4.4L36.5,24.5z"/>
							<ellipse stroke="currentColor" class="foreground" cx="30" cy="30" rx="26" ry="26"/>
							</svg>
						</a>
					</li>
				<?php }?>
                <li><a href="#"><img src="path-to-instagram-icon.svg" alt="Instagram"></a></li>
				<?php if(!empty($social['youtube']) ){?>
					<li>
						<a class="youtube" href="<?php echo $social['youtube'];?>" rel="nofollow" target="_blank">
							<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 60 60">
							<path fill="currentColor" d="M43.5,22.8c0-0.1,0-0.2-0.1-0.3c0,0,0-0.1,0-0.1c-0.4-1.1-1.4-1.9-2.7-1.9h0.2c0,0-5-0.8-11.7-0.8
							c-6.7,0-11.7,0.8-11.7,0.8h0.2c-1.3,0-2.3,0.8-2.7,1.9c0,0,0,0.1-0.1,0.1c0,0.1-0.1,0.2-0.1,0.3c-0.2,1.3-0.5,3.9-0.5,7
							c0,3.1,0.3,5.7,0.5,7c0,0.1,0,0.2,0.1,0.3c0,0,0,0.1,0.1,0.2c0.4,1.1,1.4,1.9,2.7,1.9h-0.2c0,0,5,0.8,11.7,0.8
							c6.7,0,11.7-0.8,11.7-0.8h-0.2c1.3,0,2.3-0.8,2.7-1.9c0,0,0-0.1,0-0.2c0-0.1,0-0.2,0.1-0.3c0.2-1.3,0.5-3.9,0.5-7
							C44,26.7,43.7,24.1,43.5,22.8z M33.5,30.5l-6,4.3c-0.1,0.1-0.3,0.1-0.4,0.1c-0.1,0-0.2,0-0.3-0.1c-0.2-0.1-0.4-0.4-0.4-0.6v-8.7
							c0-0.3,0.1-0.5,0.4-0.6c0.2-0.1,0.5-0.1,0.8,0.1l6,4.4c0.2,0.1,0.3,0.4,0.3,0.6C33.8,30.1,33.7,30.3,33.5,30.5z"/>
							<ellipse stroke="currentColor" class="foreground" cx="30" cy="30" rx="26" ry="26"/>
							</svg>
						</a>
					</li>
				<?php }?>
                <li><a href="#"><img src="path-to-email-icon.svg" alt="Email"></a></li>
            </ul>
        </div>
    </div>
    <div class="bottom-footer">
        <div class="copyright ani-item">
            2019 <strong>LECMAX. VIET NAM.</strong> ALL RIGHTS RESERVED.
        </div>
    </div>
</footer>



<footer class="footer">
<?php if($menu_active!=ID_CONTACT){?>
<div class="top-footer">
<?php foreach($contacts as $item){?>
<div class="col-footer ani-item">
<h3><?php echo $item['name'];?></h3>
<ul class="company-info">
<?php if(!empty($item['address'])){?><li><p class="address"><?php echo $item['address'];?></p></li><?php }?>
<?php if(!empty($item['phonelist'])){?><li><p class="phone"><?php echo $item['phonelist'];?></p></li><?php }?>
<?php if(!empty($item['faxlist'])){?><li><p class="fax"><?php echo $item['faxlist'];?></p></li><?php }?>
</ul>
</div>
<?php }?>
</div>
<?php }?>
<div class="bottom-footer">
<?php if(!empty($social['fb']) || !empty($social['youtube']) ){?>
<!--SOCIAL-->
<div class="social">
<ul>
<?php if(!empty($social['fb']) ){?>
<li>
<a class="facebook" href="<?php echo $social['fb'];?>" rel="nofollow"  target="_blank">
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 60 60">
<path fill="currentColor"  d="M36.5,24.5h-5v-3.3c0-1.2,0.8-1.5,1.4-1.5s3.5,0,3.5,0v-5.4l-4.9,0c-5.4,0-6.7,4.1-6.7,6.7v3.6h-3.1v5.6h3.1
c0,7.2,0,15.9,0,15.9h6.6c0,0,0-8.8,0-15.9h4.4L36.5,24.5z"/>
<ellipse stroke="currentColor"  class="foreground" cx="30" cy="30" rx="26" ry="26"/>
</svg>
</a>
</li>
<?php }?>
<?php if(!empty($social['youtube']) ){?>
<li>
<a class="youtube" href="<?php echo $social['youtube'];?>" rel="nofollow" target="_blank">
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 60 60">
<path fill="currentColor"  d="M43.5,22.8c0-0.1,0-0.2-0.1-0.3c0,0,0-0.1,0-0.1c-0.4-1.1-1.4-1.9-2.7-1.9h0.2c0,0-5-0.8-11.7-0.8
c-6.7,0-11.7,0.8-11.7,0.8h0.2c-1.3,0-2.3,0.8-2.7,1.9c0,0,0,0.1-0.1,0.1c0,0.1-0.1,0.2-0.1,0.3c-0.2,1.3-0.5,3.9-0.5,7
c0,3.1,0.3,5.7,0.5,7c0,0.1,0,0.2,0.1,0.3c0,0,0,0.1,0.1,0.2c0.4,1.1,1.4,1.9,2.7,1.9h-0.2c0,0,5,0.8,11.7,0.8
c6.7,0,11.7-0.8,11.7-0.8h-0.2c1.3,0,2.3-0.8,2.7-1.9c0,0,0-0.1,0-0.2c0-0.1,0-0.2,0.1-0.3c0.2-1.3,0.5-3.9,0.5-7
C44,26.7,43.7,24.1,43.5,22.8z M33.5,30.5l-6,4.3c-0.1,0.1-0.3,0.1-0.4,0.1c-0.1,0-0.2,0-0.3-0.1c-0.2-0.1-0.4-0.4-0.4-0.6v-8.7
c0-0.3,0.1-0.5,0.4-0.6c0.2-0.1,0.5-0.1,0.8,0.1l6,4.4c0.2,0.1,0.3,0.4,0.3,0.6C33.8,30.1,33.7,30.3,33.5,30.5z"/>
<ellipse stroke="currentColor"  class="foreground" cx="30" cy="30" rx="26" ry="26"/>
</svg>
</a>
</li>
<?php }?>
</ul>
</div>
<!--SOCIAL-->
<?php }?>
<div class="copyright ani-item">2019 <strong>LECMAX. Viet Nam.</strong> All Rights Reserved. 
<!-- <a href="https://www.btq.vn" target="_blank" rel="nofollow">DEVELOPED BY 3GRAPHIC</a>  -->
</div>
</footer>
<!--LOAD-PAGE-->
<div class="all-pics"></div>
<div class="all-album"></div>
<div class="allvideo"></div>
<div class="overlay-dark"></div>
<div class="overlay-menu"></div>
<div class="overlay-menu-1"></div>
<div class="wheel"><span></span></div>
<div class="go-top">
<svg  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 80 80">
<path fill="currentColor" d="M54.9,49.8H25.3L40,24.1L54.9,49.8z M30.7,46.5h18.6l-9.4-16.1L30.7,46.5z"></path>
</svg>
</div> <!--LOAD-PAGE-->
<div class="load-bg">
<span></span>
<span></span>
<span></span>
<span></span>
<span></span>
</div>
<!--LOAD-->
<div class="loadicon">
<svg  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 270 70" >
<path class="stroke-line1" d="M49.381,50.844c-1.836,0.073-4.373-4.222-2.536-6.721c4.886-4.121,16.613-3.987,19.417-8.782
	c0.481-0.831,0.233-2.906-1.386-4.208c-0.889-0.729-1.744-1.269-2.584-1.648c-1.387-0.645-3.27-0.981-5.655-0.981
	c-4.185,0-7.644,1.447-10.352,4.325c-2.724,2.893-4.065,6.634-4.065,11.207c0,4.557,1.341,8.297,4.065,11.22
	c2.708,2.922,6.167,4.367,10.352,4.367c4.502,0,7.631-1.488,10.153-3.665c2.569-2.205,4.482-6.182,4.685-10.331l8.143,0.06
	c-0.029,0.438-0.029,1.797-0.093,2.22c-0.45,3.449-1.569,6.591-3.375,9.411c-2.025,3.155-4.752,5.637-8.159,7.466
	c-3.425,1.811-7.211,2.717-11.338,2.717c-3.02,0-5.913-0.584-8.702-1.724c-2.788-1.142-5.261-2.763-7.395-4.865
	c-2.149-2.121-3.832-4.59-5.013-7.437c-1.199-2.863-1.807-5.991-1.807-9.409c0-3.42,0.607-6.548,1.79-9.395
	c1.185-2.819,2.864-5.317,5.046-7.48c2.178-2.133,4.656-3.769,7.396-4.879c2.739-1.112,5.635-1.681,8.685-1.681
	c5.044,0,9.344,1.241,12.893,3.727c1.559,1.095,3.129,2.292,4.299,3.9c5.308,7.319,3.41,13.397-13.126,17.619
	C57.105,46.813,52.402,48.696,49.381,50.844"></path>
<path class="stroke-line" d="M0,1.584h8.655v42.267c0,3.317,0.466,6.109,1.4,8.386c0.921,2.237,2.353,3.932,4.268,5.041
	c1.915,1.112,4.375,1.665,7.394,1.665h8.411v8.254h-9.669c-4.111,0-7.693-0.904-10.775-2.701c-3.115-1.795-5.479-4.309-7.162-7.553
	C0.853,53.712,0,50.076,0,46.013V1.584z M115.105,22.198v7.875h-6.272c-2.649,0-5.124,0.57-7.429,1.696
	c-2.288,1.139-4.17,2.82-5.604,5.083c-1.434,2.25-2.165,4.866-2.165,7.818c0,4.529,1.511,8.094,4.546,10.708
	c3.021,2.631,6.554,3.945,10.652,3.945h6.272v7.873h-7.739c-3.563,0-7.054-0.891-10.476-2.672c-3.394-1.797-6.212-4.397-8.425-7.86
	c-2.195-3.448-3.3-7.437-3.3-11.994c0-3.404,0.638-6.517,1.899-9.306c1.244-2.792,2.975-5.174,5.168-7.146
	c2.179-1.972,4.61-3.448,7.255-4.484c2.648-1.008,5.279-1.535,7.877-1.535H115.105z M129.696,67.196h-8.114V36.633
	c0-2.746,0.687-5.303,2.089-7.684c1.401-2.367,3.316-4.252,5.745-5.625c2.414-1.374,5.107-2.062,8.035-2.062
	c2.616,0,5.06,0.556,7.35,1.638c2.269,1.095,4.109,2.674,5.51,4.733c1.449-2.089,3.285-3.683,5.546-4.764
	c2.241-1.066,4.7-1.607,7.38-1.607c2.302,0,4.405,0.396,6.303,1.199c1.899,0.789,3.566,1.884,4.968,3.273
	c1.418,1.373,2.521,3.009,3.333,4.893c0.825,1.87,1.215,3.872,1.215,6.004v30.563h-8.1V38.489c0-2.908-0.731-5.187-2.177-6.851
	c-1.465-1.667-3.364-2.5-5.729-2.5c-5.796,0-8.673,3.566-8.673,10.667v27.392h-8.111V39.805c0-7.1-2.882-10.667-8.644-10.667
	c-2.381,0-4.295,0.833-5.742,2.5c-1.466,1.664-2.182,3.943-2.182,6.851V67.196z M231.118,67.196h-8.096V41.878
	c0-2.688-0.67-5.013-2.011-6.925c-1.32-1.928-3.064-3.375-5.246-4.339c-2.164-0.993-4.532-1.476-7.114-1.476
	c-2.899,0-5.466,0.702-7.676,2.134c-2.229,1.416-3.924,3.344-5.093,5.769c-1.185,2.441-1.791,5.056-1.791,7.862
	c0,2.746,0.624,5.317,1.854,7.655c1.229,2.354,2.944,4.224,5.186,5.609c2.226,1.391,4.686,2.092,7.429,2.092
	c4.218,0,7.936-2.06,11.131-6.181v9.761c-1.853,1.386-3.677,2.466-5.437,3.198c-1.76,0.73-3.936,1.096-6.509,1.096
	c-3.048,0-5.93-0.613-8.608-1.813c-2.68-1.196-5.029-2.922-7.006-5.144c-1.993-2.235-3.52-4.79-4.575-7.713
	c-1.029-2.908-1.561-5.989-1.561-9.22c0-4.309,0.935-8.196,2.788-11.702c1.854-3.478,4.498-6.238,7.954-8.254
	c3.443-2.018,7.476-3.026,12.101-3.026c3.408,0,6.492,0.499,9.217,1.52c2.755,0.995,5.106,2.441,7.067,4.311
	c1.963,1.869,3.458,4.135,4.471,6.778c1.028,2.645,1.524,5.567,1.524,8.766V67.196z M235.464,67.196v-7.873
	c1.805-0.103,3.533-0.525,5.184-1.301c1.65-0.772,3.101-1.854,4.33-3.213c1.213-1.36,2.162-2.923,2.803-4.689
	c0.649-1.77,0.963-3.58,0.963-5.45c0-1.899-0.313-3.712-0.963-5.479c-0.641-1.768-1.59-3.315-2.803-4.646
	c-1.229-1.329-2.663-2.381-4.251-3.17c-1.623-0.76-3.365-1.197-5.263-1.301v-7.875c4.001,0.264,7.488,1.301,10.444,3.186
	c2.978,1.886,5.232,4.573,6.806,8.079c1.215-3.447,3.456-6.18,6.726-8.21c3.253-2.031,6.771-3.054,10.555-3.054v7.875
	c-3.736,0.191-6.865,1.682-9.386,4.486c-2.491,2.818-3.751,6.195-3.751,10.111c0,3.899,1.273,7.274,3.813,10.124
	c2.537,2.848,5.636,4.338,9.324,4.529v7.873c-3.657,0-6.975-0.904-9.948-2.701c-2.972-1.795-5.416-4.397-7.332-7.788
	c-1.854,3.466-4.233,6.064-7.114,7.833C242.717,66.306,239.338,67.196,235.464,67.196"></path>
</svg>

</div>     
<!--LOAD-->
<!--MESSENGER-->
<!--<div id="fb-root" class="fb_reset">
<div class="fb_dialog"></div>
</div>-->
<!--MESSENGER-->
<div class="httpserver class-hidden"><?php echo HTTP_SERVER;?></div>
<div class="httptemplate class-hidden"><?php echo PATH_TEMPLATE;?></div>
<!--BOTTOM JS-->
<?php if($menu_active==ID_CONTACT){?>
<script async defer src='https://www.google.com/recaptcha/api.js?hl=<?php echo $lang;?>'></script>
 <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCJqpC7oo-YYJJ1pRVZJgf84qExlHZCWSc"  type="text/javascript"></script>
<?php }?>
<script type="text/javascript" src="<?php echo PATH_TEMPLATE;?>default/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo PATH_TEMPLATE;?>default/js/common.js?v=<?php echo VER;?>"></script>
<script type="text/javascript" src="<?php echo PATH_TEMPLATE;?>default/js/slide.js?v=<?php echo VER;?>"></script> 
<script type="text/javascript" src="<?php echo PATH_TEMPLATE;?>default/js/scroll.js?v=<?php echo VER;?>"></script> 
<script type="text/javascript" src="<?php echo PATH_TEMPLATE;?>default/js/load.js?v=<?php echo VER;?>"></script>
<script type="text/javascript" src="<?php echo PATH_TEMPLATE;?>default/js/btq.js?v=<?php echo VER;?>"></script>
<?php foreach ($scripts as $script) { ?>
<script type="text/javascript" src="<?php echo $script; ?>?v=<?php echo VER;?>" ></script>
<?php } ?>
<!--BOTTOM JS-->
<?php echo $google_tag_manager;?>
</body>
</html>
<?php
class Captcha {
	protected $code;
	protected $width  = 31;
	protected $height = 150;

	function __construct() { 
		$this->code = substr(sha1(mt_rand()), 17, 6); 
	}

	function getCode(){
		return $this->code;
	}

	function showImage() {
		$image = imagecreatetruecolor($this->height, $this->width);

		$width = imagesx($image); 
		$height = imagesy($image);
		
		$black = imagecolorallocate($image, 0, 0, 0); 
		$white = imagecolorallocate($image, 255, 255, 255); 
		$red = imagecolorallocatealpha($image, 255, 0, 0, 75); 
		$green = imagecolorallocatealpha($image, 0, 255, 0, 75); 
		$blue = imagecolorallocatealpha($image, 0, 0, 255, 75); 
		$gray = imagecolorallocate($image, 222, 222, 222); 
		
		imagefilledrectangle($image, 0, 0, $width, $height, $white); 
		
        imagefilledellipse($image, ceil(rand(5, 145)), ceil(rand(0, 35)), 30, 30, $gray); //red
        imagefilledellipse($image, ceil(rand(5, 145)), ceil(rand(0, 35)), 30, 30, $gray); //green
        imagefilledellipse($image, ceil(rand(5, 145)), ceil(rand(0, 35)), 30, 30, $gray); //blue

        imagefilledrectangle($image, 0, 0, $width, 0, $gray); 
        imagefilledrectangle($image, $width - 1, 0, $width - 1, $height - 1, $gray); 
        imagefilledrectangle($image, 0, 0, 0, $height - 1, $gray); 
        imagefilledrectangle($image, 0, $height - 1, $width, $height - 1, $gray); 
        
        imagestring($image, 10, intval(($width - (strlen($this->code) * 9)) / 2),  intval(($height - 15) / 2), $this->code, $black);
        
        header('Content-type: image/jpeg');
        
        imagejpeg($image);
        
        imagedestroy($image);		
      }
    }
    ?>
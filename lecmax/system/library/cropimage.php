<?php
function CroppedThumbnail($imgSrc,$thumbnail_width,$thumbnail_height) { //$imgSrc is a FILE - Returns an image resource.
	//getting the image dimensions
	list($width_orig, $height_orig) = getimagesize($imgSrc);
	$myImage = imagecreatefromjpeg($imgSrc);
	$ratio_orig = $width_orig/$height_orig;

	if ($thumbnail_width/$thumbnail_height > $ratio_orig) {
		$new_height = $thumbnail_width/$ratio_orig;
		$new_width = $thumbnail_width;
	} else {
		$new_width = $thumbnail_height*$ratio_orig;
		$new_height = $thumbnail_height;
	}

	$x_mid = $new_width/2;  //horizontal middle
	$y_mid = $new_height/2; //vertical middle

	$process = imagecreatetruecolor(round($new_width), round($new_height));

	imagecopyresampled($process, $myImage, 0, 0, 0, 0, $new_width, $new_height, $width_orig, $height_orig);
	$thumb = imagecreatetruecolor($thumbnail_width, $thumbnail_height);
	imagecopyresampled($thumb, $process, 0, 0, ($x_mid-($thumbnail_width/2)), ($y_mid-($thumbnail_height/2)), $thumbnail_width, $thumbnail_height, $thumbnail_width, $thumbnail_height);

	imagedestroy($process);
	imagedestroy($myImage);
	return $thumb;
}

function saveimage($file,$newthumb,$new_file)
{
	$info = pathinfo($file);
	$extension = $info['extension'];

	if ($extension == ('jpeg' || 'jpg')) {
		imagejpeg($newthumb, $new_file);
	} elseif($extension == 'png') {
		imagepng($newthumb, $new_file, 0);
	} elseif($extension == 'gif') {
		imagegif($newthumb, $new_file);
	}
}
?>
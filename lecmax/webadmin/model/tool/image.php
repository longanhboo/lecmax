<?php
class ModelToolImage extends Model {
	public function resize($filename, $width, $height) {
		if (!is_file(DIR_IMAGE . $filename)) {
			return;
		}

		$extension = pathinfo($filename, PATHINFO_EXTENSION);

		$old_image = $filename;
		$new_image = 'cache/' . utf8_substr($filename, 0, utf8_strrpos($filename, '.')) . '-' . $width . 'x' . $height . '.' . $extension;

		if (!is_file(DIR_IMAGE . $new_image) || (filectime(DIR_IMAGE . $old_image) > filectime(DIR_IMAGE . $new_image))) {
			$path = '';

			$directories = explode('/', dirname(str_replace('../', '', $new_image)));

			foreach ($directories as $directory) {
				$path = $path . '/' . $directory;

				if (!is_dir(DIR_IMAGE . $path)) {
					@mkdir(DIR_IMAGE . $path, 0777);
				}
			}

			list($width_orig, $height_orig) = getimagesize(DIR_IMAGE . $old_image);

			if ($width_orig != $width || $height_orig != $height) {
				$image = new Image(DIR_IMAGE . $old_image);
				$image->resize($width, $height);
				$image->save(DIR_IMAGE . $new_image);
			} else {
				copy(DIR_IMAGE . $old_image, DIR_IMAGE . $new_image);
			}
			
			if($extension=='svg' || $extension=='SVG'){
				//copy(DIR_IMAGE . $old_image, DIR_IMAGE . $new_image);
				$svg = file_get_contents(DIR_IMAGE . $filename);
				
				// I prefer to use DOM, because it's safer and easier as to use preg_match
				$svg_dom = new DOMDocument();
				
				libxml_use_internal_errors(true);
				$svg_dom->loadXML($svg);
				libxml_use_internal_errors(false);
				
				//get width and height values from your svg
				$tmp_obj = $svg_dom->getElementsByTagName('svg')->item(0);
				$svg_width = floatval($tmp_obj->getAttribute('width'));
				$svg_height = floatval($tmp_obj->getAttribute('height'));
				
				// set width and height of your svg to preferred dimensions
				$tmp_obj->setAttribute('width', $width);
				$tmp_obj->setAttribute('height', $height);
				
				// check if width and height of your svg is smaller than the width and 
				// height you set above => no down scaling is needed
				if ($svg_width < $width && $svg_height < $height) {
					//center your svg content in new box
					$x = abs($svg_width - $width) / 2;
					$y = abs($svg_height - $height) / 2;
					
					$_temp = $tmp_obj->getElementsByTagName('g')->item(0);
					if(isset($_temp)){
						$tmp_obj->getElementsByTagName('g')->item(0)->setAttribute('transform', "translate($x,$y)");
					}else{
						$tmp_obj->getElementsByTagName('path')->item(0)->setAttribute('transform', "translate($x,$y)");
					}
				} else {
					// scale down your svg content and center it in new box
					$scale = 1;
				
					// set padding to 0 if no gaps are desired
					$padding = 2;
				
					// get scale factor
					if ($svg_width > $svg_height) {
						$scale = ($width - $padding) / $svg_width;
					} else {
						$scale = ($height - $padding) / $svg_height;
					}
				
					$x = abs(($scale * $svg_width) - $width) / 2;
					$y = abs(($scale * $svg_height) - $height) / 2;
					
					$_temp = $tmp_obj->getElementsByTagName('g')->item(0);
					if(isset($_temp)){
						$tmp_obj->getElementsByTagName('g')->item(0)->setAttribute('transform', "translate($x,$y) scale($scale,$scale)");
					}else{
						$tmp_obj->getElementsByTagName('path')->item(0)->setAttribute('transform', "translate($x,$y) scale($scale,$scale)");
					}
				
					file_put_contents(DIR_IMAGE . $new_image, $svg_dom->saveXML());
				}
			}
		}

		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			return HTTPS_IMAGE . $new_image;
		} else {
			return HTTP_IMAGE . $new_image;
		}
	}

	public function resize_ipad($filename, $width, $height) {
		if (!file_exists(DIR_IMAGE . $filename) || !is_file(DIR_IMAGE . $filename)) {
			return;
		}

		if (!file_exists(DIR_IMAGE_IPAD . $filename)) {
			$path = '';

			$directories = explode('/', dirname(str_replace('../', '', $filename)));

			foreach ($directories as $directory) {
				$path = $path . '/' . $directory;

				if (!file_exists(DIR_IMAGE_IPAD . $path)) {
					@mkdir(DIR_IMAGE_IPAD . $path, 0777);
				}
			}

			$image = new Image(DIR_IMAGE_IPAD . $filename);
			$image->resize($width, $height);
			$image->save(DIR_IMAGE_IPAD . $filename);
		}


		return HTTP_IMAGE_IPAD . $filename;
	}
	
	public function resize_mobile($filename, $width, $height) {
		if (!is_file(DIR_IMAGE . $filename)) {
			return;
		}
		
		if (file_exists(DIR_IMAGE_MOBILE . $filename)) {
			@unlink(DIR_IMAGE_MOBILE . $filename);
		}
		
		if (!file_exists(DIR_IMAGE_MOBILE . $filename)) {
			$path = '';
			
			$directories = explode('/', dirname(str_replace('../', '', $filename)));
			
			foreach ($directories as $directory) {
				$path = $path . '/' . $directory;
				
				if (!file_exists(DIR_IMAGE_MOBILE . $path)) {
					@mkdir(DIR_IMAGE_MOBILE . $path, 0777);
				}		
			}
			
			$image = new Image(DIR_IMAGE . $filename);
			$image->resize($width, $height);
			$image->save(DIR_IMAGE_MOBILE . $filename);
		}
		
		return HTTP_IMAGE_MOBILE . $filename;	
	}
	
	public function resizeImage($filename, $width, $height) {
		if (!is_file(DIR_IMAGE . $filename)) {
			return;
		}

		$extension = pathinfo($filename, PATHINFO_EXTENSION);

		$old_image = $filename;
		$new_image = 'cache/' . utf8_substr($filename, 0, utf8_strrpos($filename, '.')) . '-' . $width . 'x' . $height . '.' . $extension;

		if (!is_file(DIR_IMAGE . $new_image) || (filectime(DIR_IMAGE . $old_image) > filectime(DIR_IMAGE . $new_image))) {
			$path = '';

			$directories = explode('/', dirname(str_replace('../', '', $new_image)));

			foreach ($directories as $directory) {
				$path = $path . '/' . $directory;

				if (!is_dir(DIR_IMAGE . $path)) {
					@mkdir(DIR_IMAGE . $path, 0777);
				}
			}
			
			copy(DIR_IMAGE . $old_image, DIR_IMAGE . 'cache/' .utf8_substr($filename, 0, utf8_strrpos($filename, '.')) . 'temp.' . $extension);
			unlink(DIR_IMAGE . $old_image);
			
			list($width_orig, $height_orig) = getimagesize(DIR_IMAGE . 'cache/' .utf8_substr($filename, 0, utf8_strrpos($filename, '.')) . 'temp.' . $extension);
			
			$image = new Image(DIR_IMAGE . 'cache/' .utf8_substr($filename, 0, utf8_strrpos($filename, '.')) . 'temp.' . $extension);
			$image->resize($width, $height);
			$image->save(DIR_IMAGE . $old_image);
			
			unlink(DIR_IMAGE . 'cache/' .utf8_substr($filename, 0, utf8_strrpos($filename, '.')) . 'temp.' . $extension);
			
			

			//list($width_orig, $height_orig) = getimagesize(DIR_IMAGE . $old_image);

			/*if ($width_orig != $width || $height_orig != $height) {
				$image = new Image(DIR_IMAGE . $old_image);
				$image->resize($width, $height);
				$image->save(DIR_IMAGE . $new_image);
			} else {
				copy(DIR_IMAGE . $old_image, DIR_IMAGE . $new_image);
			}*/
		}

		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			return HTTPS_IMAGE . $new_image;
		} else {
			return HTTP_IMAGE . $new_image;
		}
	}
	
	public function resizeImage1x($filename, $width, $height, $folder="") {
		if (!is_file(DIR_IMAGE . $filename)) {
			return;
		}

		$extension = pathinfo($filename, PATHINFO_EXTENSION);

		$old_image = $filename;
		if(!empty($folder)){
			//$new_image = utf8_substr($folder, 0, utf8_strrpos($folder, '.')) . '-' . $width . 'x' . $height . '.' . $extension;
			$new_image = utf8_substr($folder, 0, utf8_strrpos($folder, '.')) . '.' . $extension;
		}else{
			$new_image = utf8_substr($filename, 0, utf8_strrpos($filename, '.')) . '-' . $width . 'x' . $height . '.' . $extension;
		}

		if (!is_file(DIR_IMAGE . $new_image) || (filectime(DIR_IMAGE . $old_image) > filectime(DIR_IMAGE . $new_image))) {
			$path = '';

			$directories = explode('/', dirname(str_replace('../', '', $new_image)));

			foreach ($directories as $directory) {
				$path = $path . '/' . $directory;

				if (!is_dir(DIR_IMAGE . $path)) {
					@mkdir(DIR_IMAGE . $path, 0777);
				}
			}

			list($width_orig, $height_orig) = getimagesize(DIR_IMAGE . $old_image);

			if ($width_orig != $width || $height_orig != $height) {
				$image = new Image(DIR_IMAGE . $old_image);
				$image->resize($width, $height);
				$image->save(DIR_IMAGE . $new_image);
			} else {
				copy(DIR_IMAGE . $old_image, DIR_IMAGE . $new_image);
			}
		}

		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			return HTTPS_IMAGE . $new_image;
		} else {
			return HTTP_IMAGE . $new_image;
		}
	}
	
	
	public function resizeImageThumb($filename, $width, $height) {
		if (!is_file(DIR_IMAGE . $filename)) {
			return;
		}

		$extension = pathinfo($filename, PATHINFO_EXTENSION);

		$old_image = $filename;
		$new_image = utf8_substr($filename, 0, utf8_strrpos($filename, '.')) . '-' . $width . 'x' . $height . '.' . $extension;

		if (!is_file(DIR_IMAGE . $new_image) || (filectime(DIR_IMAGE . $old_image) > filectime(DIR_IMAGE . $new_image))) {
			$path = '';

			$directories = explode('/', dirname(str_replace('../', '', $new_image)));

			foreach ($directories as $directory) {
				$path = $path . '/' . $directory;

				if (!is_dir(DIR_IMAGE . $path)) {
					@mkdir(DIR_IMAGE . $path, 0777);
				}
			}

			list($width_orig, $height_orig) = getimagesize(DIR_IMAGE . $old_image);

			if ($width_orig != $width || $height_orig != $height) {
				$image = new Image(DIR_IMAGE . $old_image);
				$image->resize($width, $height);
				$image->save(DIR_IMAGE . $new_image);
			} else {
				copy(DIR_IMAGE . $old_image, DIR_IMAGE . $new_image);
			}
		}

		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			return HTTPS_IMAGE . $new_image;
		} else {
			return HTTP_IMAGE . $new_image;
		}
	}
}
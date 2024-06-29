<?php
class ModelToolImage extends Model {
	public function resize($filename, $width, $height) {
		if (!file_exists(DIR_IMAGE . $filename) || !is_file(DIR_IMAGE . $filename)) {
			return;
		} 
		
		$info = pathinfo($filename);
		$extension = $info['extension'];
		
		$old_image = $filename;
		$new_image = 'cache/' . substr($filename, 0, strrpos($filename, '.')) . '-' . $width . 'x' . $height . '.' . $extension;
		
		if (!file_exists(DIR_IMAGE . $new_image) || (filemtime(DIR_IMAGE . $old_image) > filemtime(DIR_IMAGE . $new_image))) {
			$path = '';
			
			$directories = explode('/', dirname(str_replace('../', '', $new_image)));
			
			foreach ($directories as $directory) {
				$path = $path . '/' . $directory;
				
				if (!file_exists(DIR_IMAGE . $path)) {
					@mkdir(DIR_IMAGE . $path, 0777);
				}		
			}
			
			$image = new Image(DIR_IMAGE . $old_image);
			$image->resize($width, $height);
			$image->save(DIR_IMAGE . $new_image);
		}
		
		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			return HTTPS_IMAGE . $new_image;
		} else {
			return HTTP_IMAGE . $new_image;
		}	
	}
	//=======================================resize hinh co tuy chon======================================
	//file
	public function resizeImage($filename, $width, $height,$zc=0, $q=100) {
		if (!file_exists(DIR_IMAGE . $filename) || !is_file(DIR_IMAGE . $filename)) {
			return;
		} 
		
		$info = pathinfo($filename);
		$extension = $info['extension'];
		
		
		$old_image = $filename;
		$new_image = 'cachefe/' . substr($filename, 0, strrpos($filename, '.')) . '-' . $width . 'x' . $height . '.' . $extension;

		if (!file_exists(DIR_IMAGE . $new_image) || (filemtime(DIR_IMAGE . $old_image) > filemtime(DIR_IMAGE . $new_image))) {
			$path = '';
			
			$directories = explode('/', dirname(str_replace('../', '', $new_image)));
			
			foreach ($directories as $directory) {
				$path = $path . '/' . $directory;
				
				if (!file_exists(DIR_IMAGE . $path)) {
					@mkdir(DIR_IMAGE . $path, 0777);
				}		
			}
			
			$image = new Image(DIR_IMAGE . $old_image);
			if($zc==1){
				$top_x = 0;
				$top_y = 0;
				$buttom_x = 200;
				$buttom_y = 100;
				$image->crop($top_x, $top_y, $buttom_x, $buttom_y);
			}else
			$image->resize($width, $height);
			
			$contentimage = $image->save(DIR_IMAGE . $new_image);
		}else{
			$contentimage = file_get_contents(DIR_IMAGE . $new_image);
		}
		return $contentimage;
		
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
			
			$image = new Image(DIR_IMAGE . $filename);
			$image->resize($width, $height);
			$image->save(DIR_IMAGE_IPAD . $filename);
		}
		
		
		return HTTP_IMAGE_IPAD . $filename;			
	}
}
?>
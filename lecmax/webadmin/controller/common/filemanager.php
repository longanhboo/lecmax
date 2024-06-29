<?php
class ControllerCommonFileManager extends Controller {
	public function index() {
		$this->load->language('common/filemanager');
		
		set_time_limit(0);
		ini_set('max_execution_time','INCREASE TIME');
		ini_set('memory_limit','-1');

		if (isset($this->request->get['filter_name'])) {
			$filter_name = rtrim(str_replace(array('../', '..\\', '..', '*'), '', $this->request->get['filter_name']), '/');
		} else {
			$filter_name = null;
		}

		// Make sure we have the correct directory
		if (isset($this->request->get['directory'])) {
			if(isset($this->request->get['iseditor']) && isset($this->session->data['directory'])){
				$directory = $this->session->data['directory'];
				//unset($this->session->data['directory']);
			}else{
				$directory = rtrim(DIR_IMAGE . 'catalog/' . str_replace(array('../', '..\\', '..'), '', $this->request->get['directory']), '/');
				$this->session->data['directory'] = $directory;
			}
		}elseif(isset($this->request->get['directory']) && isset($this->session->data['directory'])){
			$directory = $this->session->data['directory'];
			//unset($this->session->data['directory']);
		} else {
			$directory = DIR_IMAGE . 'catalog';
			$this->session->data['directory'] = $directory;
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
		
		if ( ( isset($this->request->get['isnewspage']) && $this->request->get['isnewspage']==1) || isset($this->request->get['iseditor'])) {
			$this->data['isnewspage'] = 1;
		} else {
			$this->data['isnewspage'] = 0;
		}

		$this->data['images'] = array();

		$this->load->model('tool/image');

		// Get directories
		$directories = glob($directory . '/*' . $filter_name . '*', GLOB_ONLYDIR);

		if (!$directories) {
			$directories = array();
		}

		// Get files
		$files = glob($directory . '/*' . $filter_name . '*.{jpg,jpeg,png,gif,JPG,JPEG,PNG,GIF,svg,SVG}', GLOB_BRACE);

		if (!$files) {
			$files = array();
		}

		// Merge directories and files
		$images = array_merge($directories, $files);

		// Get total number of files and directories
		$image_total = count($images);

		// Split the array based on current page number and max number of items per page of 10
		$images = array_splice($images, ($page - 1) * 90, 90);

		foreach ($images as $image) {
			$name = str_split(basename($image), 14);

			if (is_dir($image)) {
				$url = '';

				if (isset($this->request->get['target'])) {
					$url .= '&target=' . $this->request->get['target'];
				}

				if (isset($this->request->get['thumb'])) {
					$url .= '&thumb=' . $this->request->get['thumb'];
				}
				
				if (( isset($this->request->get['isnewspage']) && $this->request->get['isnewspage']==1) || isset($this->request->get['iseditor'])) {
					$url .= '&isnewspage=1';
				}else{
					$url .= '&isnewspage=0';
				}

				$this->data['images'][] = array(
				                                'thumb' => '',
				                                'name'  => implode(' ', $name),
												'size'  => '',
				                                'type'  => 'directory',
				                                'path'  => utf8_substr($image, utf8_strlen(DIR_IMAGE)),
				                                'href'  => $this->url->link('common/filemanager', 'token=' . $this->session->data['token'] . '&directory=' . urlencode(utf8_substr($image, utf8_strlen(DIR_IMAGE . 'catalog/'))) . $url, '', 'SSL')
				                                );
			} elseif (is_file($image)) {
				// Find which protocol to use to pass the full image link back
				// if ($this->request->server['HTTPS']) {
				// 	$server = HTTPS_CATALOG;
				// } else {
				$server = HTTP_CATALOG;
				// }
				$extension_temp = pathinfo(utf8_substr($image, utf8_strlen(DIR_IMAGE)), PATHINFO_EXTENSION);
				if($extension_temp=='svg' || $extension_temp=='SVG'){
					$svg = file_get_contents($image);
					
					$svg_dom = new DOMDocument();
					
					libxml_use_internal_errors(true);
					$svg_dom->loadXML($svg);
					libxml_use_internal_errors(false);
					
					$tmp_obj = $svg_dom->getElementsByTagName('svg')->item(0);
					$width_orig = floatval($tmp_obj->getAttribute('width'));
					$height_orig = floatval($tmp_obj->getAttribute('height'));
					
				}else{
					list($width_orig, $height_orig) = getimagesize ($image);
				}

				$this->data['images'][] = array(
				                                'thumb' => $this->model_tool_image->resize(utf8_substr($image, utf8_strlen(DIR_IMAGE)), 100, 100),
				                                'name'  => implode(' ', $name),
												'size'  => '(' . $width_orig . ' x ' . $height_orig . ' px' . ')',
				                                'type'  => 'image',
				                                'path'  => utf8_substr($image, utf8_strlen(DIR_IMAGE)),
				                                'href'  => $server . 'pictures/' . utf8_substr($image, utf8_strlen(DIR_IMAGE))
				                                );
			}
		}
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['text_confirm'] = $this->language->get('text_confirm');
		$this->data['text_error_insert'] = $this->language->get('text_error_insert');
		$this->data['text_error_insert_folder'] = $this->language->get('text_error_insert_folder');
		$this->data['text_error_select'] = $this->language->get('text_error_select');
		$this->data['text_error_second_type'] = $this->language->get('text_error_second_type');

		$this->data['entry_search'] = $this->language->get('entry_search');
		$this->data['entry_folder'] = $this->language->get('entry_folder');

		$this->data['button_parent'] = $this->language->get('button_parent');
		$this->data['button_refresh'] = $this->language->get('button_refresh');
		$this->data['button_upload'] = $this->language->get('button_upload');
		$this->data['button_folder'] = $this->language->get('button_folder');
		$this->data['button_delete'] = $this->language->get('button_delete');
		$this->data['button_search'] = $this->language->get('button_search');
		$this->data['button_insert'] = $this->language->get('button_insert');

		$this->data['token'] = $this->session->data['token'];

		if (isset($this->request->get['directory'])) {
			$this->data['directory'] = urlencode($this->request->get['directory']);
		} else {
			$this->data['directory'] = '';
		}

		if (isset($this->request->get['filter_name'])) {
			$this->data['filter_name'] = $this->request->get['filter_name'];
		} else {
			$this->data['filter_name'] = '';
		}

		// Return the target ID for the file manager to set the value
		if (isset($this->request->get['target'])) {
			$this->data['target'] = $this->request->get['target'];
		} else {
			$this->data['target'] = '';
		}

		// Return the thumbnail for the file manager to show a thumbnail
		if (isset($this->request->get['thumb'])) {
			$this->data['thumb'] = $this->request->get['thumb'];
		} else {
			$this->data['thumb'] = '';
		}

		// Parent
		$url = '';

		if (isset($this->request->get['directory'])) {
			$pos = strrpos($this->request->get['directory'], '/');

			if ($pos) {
				$url .= '&directory=' . urlencode(substr($this->request->get['directory'], 0, $pos));
			}
		}
		if (isset($this->session->data['directory'])) {
			//if($this->session->data['directory'] != DIR_IMAGE){
			$forder_temp = str_replace(DIR_IMAGE . 'catalog','',str_replace(DIR_IMAGE . 'catalog/','',$this->session->data['directory']));
			$forder_array = explode('/',$forder_temp);
			$str_href = '';
			for($i=0;$i<count($forder_array)-1;$i++){
				$str_href .= $forder_array[$i];
				if($i<count($forder_array)-2){
					$str_href .= '/';
				}
			}
			
			$pos = strrpos($this->session->data['directory'], '/');
			if ($pos && !empty($str_href)) {
				$url .= '&directory=' . urlencode(substr($str_href, 0, $pos));
			}
			//}
		}

		if (isset($this->request->get['target'])) {
			$url .= '&target=' . $this->request->get['target'];
		}

		if (isset($this->request->get['thumb'])) {
			$url .= '&thumb=' . $this->request->get['thumb'];
		}
		
		if (( isset($this->request->get['isnewspage']) && $this->request->get['isnewspage']==1) || isset($this->request->get['iseditor'])) {
			$url .= '&isnewspage=1';
		}else{
			$url .= '&isnewspage=0';
		}

		$this->data['parent'] = $this->url->link('common/filemanager', 'token=' . $this->session->data['token'] . $url, '', 'SSL');

		// Refresh
		$url = '';

		/*if (isset($this->request->get['directory'])) {
			$url .= '&directory=' . urlencode($this->request->get['directory']);
		}*/
		if (isset($this->request->get['directory'])) {
			$pos = strrpos($this->request->get['directory'], '/');

			if ($pos) {
				$url .= '&directory=' . urlencode(substr($this->request->get['directory'], 0, $pos));
			}
		}
		if (isset($this->session->data['directory'])) {
			//if($this->session->data['directory'] != DIR_IMAGE){
			$forder_temp = str_replace(DIR_IMAGE . 'catalog','',str_replace(DIR_IMAGE . 'catalog/','',$this->session->data['directory']));
			$forder_array = explode('/',$forder_temp);
			$str_href = '';
			for($i=0;$i<count($forder_array);$i++){
				$str_href .= $forder_array[$i];
				if($i<count($forder_array)-1){
					$str_href .= '/';
				}
			}
			
			$pos = strrpos($this->session->data['directory'], '/');
			if ($pos && !empty($str_href)) {
				$url .= '&directory=' . urlencode(substr($str_href, 0, $pos));
			}
			//}
		}

		if (isset($this->request->get['target'])) {
			$url .= '&target=' . $this->request->get['target'];
		}

		if (isset($this->request->get['thumb'])) {
			$url .= '&thumb=' . $this->request->get['thumb'];
		}
		if (( isset($this->request->get['isnewspage']) && $this->request->get['isnewspage']==1) || isset($this->request->get['iseditor'])) {
			$url .= '&isnewspage=1';
		}else{
			$url .= '&isnewspage=0';
		}

		$this->data['refresh'] = $this->url->link('common/filemanager', 'token=' . $this->session->data['token'] . $url, '', 'SSL');

		$url = '';

		/*if (isset($this->request->get['directory'])) {
			$url .= '&directory=' . urlencode(html_entity_decode($this->request->get['directory'], ENT_QUOTES, 'UTF-8'));
		}*/
		if (isset($this->request->get['directory'])) {
			$pos = strrpos($this->request->get['directory'], '/');

			if ($pos) {
				$url .= '&directory=' . urlencode(html_entity_decode(substr($this->request->get['directory'], 0, $pos), ENT_QUOTES, 'UTF-8'));
			}
		}
		if (isset($this->session->data['directory'])) {
			//if($this->session->data['directory'] != DIR_IMAGE){
			$forder_temp = str_replace(DIR_IMAGE . 'catalog','',str_replace(DIR_IMAGE . 'catalog/','',$this->session->data['directory']));
			$forder_array = explode('/',$forder_temp);
			$str_href = '';
			for($i=0;$i<count($forder_array);$i++){
				$str_href .= $forder_array[$i];
				if($i<count($forder_array)-1){
					$str_href .= '/';
				}
			}
			
			$pos = strrpos($this->session->data['directory'], '/');
			if ($pos && !empty($str_href)) {
				$url .= '&directory=' . urlencode(substr($str_href, 0, $pos));
			}
			//}
		}

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['target'])) {
			$url .= '&target=' . $this->request->get['target'];
		}

		if (isset($this->request->get['thumb'])) {
			$url .= '&thumb=' . $this->request->get['thumb'];
		}
		
		if (( isset($this->request->get['isnewspage']) && $this->request->get['isnewspage']==1) || isset($this->request->get['iseditor'])) {
			$url .= '&isnewspage=1';
		}else{
			$url .= '&isnewspage=0';
		}

		$pagination = new Pagination();
		$pagination->total = $image_total;
		$pagination->page = $page;
		$pagination->limit = 90;
		$pagination->url = $this->url->link('common/filemanager', 'token=' . $this->session->data['token'] . $url . '&page={page}', '', 'SSL');

		$this->data['pagination'] = $pagination->render();

		$this->template = 'common/filemanager.tpl';

		$this->response->setOutput($this->render());
	}

	public function upload() {
		
		set_time_limit(0);
		ini_set('max_execution_time','INCREASE TIME');
		ini_set('memory_limit','-1');
		
		$this->load->language('common/filemanager');

		$json = array();

		// Check user has permission
		if (!$this->user->hasPermission('modify', 'common/filemanager')) {
			$json['error'] = $this->language->get('error_permission');
		}

		// Make sure we have the correct directory
		if (isset($this->request->get['directory'])) {
			$directory = rtrim(DIR_IMAGE . 'catalog/' . str_replace(array('../', '..\\', '..'), '', $this->request->get['directory']), '/');
		} else {
			$directory = DIR_IMAGE . 'catalog';
		}
		
		if(isset($this->session->data['directory'])){
			$directory = $this->session->data['directory'];
		}

		// Check its a directory
		if (!is_dir($directory)) {
			$json['error'] = $this->language->get('error_directory');
		}
		
		$filter_name = null;
		$files = glob($directory . '/' . $filter_name . '*.{jpg,jpeg,png,gif,JPG,JPEG,PNG,GIF,svg,SVG}', GLOB_BRACE);
		if (!$files) {
			$files = array();
		}

		if (!$json) {
			if (!empty($this->request->files['file']['name'])) {

				$fileNames = array();
				foreach ($this->request->files['file']['name'] as $key => $value) {
          // Sanitize the filename
					$filename = basename(html_entity_decode($value, ENT_QUOTES, 'UTF-8'));
					// $mixed = array(' ','/',':',';','!','@','#','$','%','^','*','(',')','_','+','=','|','{','}','[',']','"',"'",'<','>',',','?','~','`','&');
					// preg_replace(array('#[\\s-]+#', '#[^A-Za-z0-9\. -]+#'), array('-', ''), urldecode(basename($this->request->files['image']['name'])))
					$filename = preg_replace(array('#[\\s-]+#', '#[^A-Za-z0-9\. -]+#'), array('-', ''), urldecode($filename));
					
					foreach($files as $item){
						if($filename==utf8_substr($item, utf8_strlen($directory . '/'))){
							$temp = explode('.',$filename);
							$i=1;
							$flag=0;
							foreach($files as $item_check){
								if($temp[0] . '-' . $i . '.' . $temp[1]==utf8_substr($item_check, utf8_strlen($directory . '/'))){
									$i++;
								}
							}
							$filename = $temp[0] . '-' . $i . '.' . $temp[1];
						}
					}

          // Validate the filename length
					if ((utf8_strlen($filename) < 3) || (utf8_strlen($filename) > 255)) {
						$json['error'] = $this->language->get('error_filename');
					}

          // Allowed file extension types
					$allowed = array(
					                 'jpg',
					                 'jpeg',
					                 'gif',
									 'svg',
					                 'png'
					                 );

					if (!in_array(utf8_strtolower(utf8_substr(strrchr($filename, '.'), 1)), $allowed)) {
						$json['error'] = $this->language->get('error_filetype');
					}

          // Allowed file mime types
					$allowed = array(
					                 'image/jpeg',
					                 'image/pjpeg',
					                 'image/png',
					                 'image/x-png',
									 'image/svg+xml',
					                 'image/gif'
					                 );

					if (!in_array($this->request->files['file']['type'][$key], $allowed)) {
						$json['error'] = $this->language->get('error_filetype');
					}

          // Check to see if any PHP files are trying to be uploaded
					$content = file_get_contents($this->request->files['file']['tmp_name'][$key]);

					if (preg_match('/\<\?php/i', $content)) {
						$json['error'] = $this->language->get('error_filetype');
					}

          // Return any upload error
					if ($this->request->files['file']['error'][$key] != UPLOAD_ERR_OK) {
						$json['error'] = $this->language->get('error_upload_' . $this->request->files['file']['error'][$key]);
					}

					array_push($fileNames, $filename);
				}
			} else {
				$json['error'] = $this->language->get('error_upload');
			}
		}

		if (!$json) {
			foreach ($this->request->files['file']['name'] as $key => $value) {
				//move_uploaded_file($this->request->files['file']['tmp_name'][$key], $directory . '/' . $fileNames[$key]);
				move_uploaded_file($this->request->files['file']['tmp_name'][$key], $directory . '/' . $fileNames[$key]);
				list($width_orig, $height_orig) = getimagesize ($directory . '/' . $fileNames[$key]);
				
				if($width_orig>$height_orig && $width_orig>3000 ){
					$this->load->model('tool/image');
					$this->model_tool_image->resizeImage(utf8_substr($directory . '/' . $fileNames[$key], utf8_strlen(DIR_IMAGE)), 3000, (int)(3000*$height_orig/$width_orig));
				}elseif($height_orig>$width_orig && $height_orig>3000){
					$this->load->model('tool/image');
					$this->model_tool_image->resizeImage(utf8_substr($directory . '/' . $fileNames[$key], utf8_strlen(DIR_IMAGE)), (int)(3000*$width_orig/$height_orig), 3000);
				}
				
				//print_r($this->request->get['isnewspage']);
				if((isset($this->request->get['isnewspage']) && $this->request->get['isnewspage']==1) || isset($this->request->get['iseditor'])){
				if($this->request->files['file']['size'][$key]>301000){
					// mat dinh 75%
				$d = $this->compress($directory . '/' . $fileNames[$key], $directory . '/' . $fileNames[$key], 75);
				}
				}
			}

			$json['success'] = $this->language->get('text_uploaded');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function folder() {
		$this->load->language('common/filemanager');

		$json = array();

		// Check user has permission
		if (!$this->user->hasPermission('modify', 'common/filemanager')) {
			$json['error'] = $this->language->get('error_permission');
		}

		// Make sure we have the correct directory
		if (isset($this->request->get['directory'])) {
			$directory = rtrim(DIR_IMAGE . 'catalog/' . str_replace(array('../', '..\\', '..'), '', $this->request->get['directory']), '/');
		} else {
			$directory = DIR_IMAGE . 'catalog';
		}

		// Check its a directory
		if (!is_dir($directory)) {
			$json['error'] = $this->language->get('error_directory');
		}

		if (!$json) {
			// Sanitize the folder name
			$folder = str_replace(array('../', '..\\', '..'), '', basename(html_entity_decode(convertAlias($this->request->post['folder']), ENT_QUOTES, 'UTF-8')));

			// Validate the filename length
			if ((utf8_strlen($folder) < 3) || (utf8_strlen($folder) > 128)) {
				$json['error'] = $this->language->get('error_folder');
			}

			// Check if directory already exists or not
			if (is_dir($directory . '/' . $folder)) {
				$json['error'] = $this->language->get('error_exists');
			}
		}

		if (!$json) {
			mkdir($directory . '/' . $folder, 0777);

			$json['success'] = $this->language->get('text_directory');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function delete() {
		$this->load->language('common/filemanager');

		$json = array();

		// Check user has permission
		if (!$this->user->hasPermission('modify', 'common/filemanager')) {
			$json['error'] = $this->language->get('error_permission');
		}

		if (isset($this->request->post['path'])) {
			$paths = $this->request->post['path'];
		} else {
			$paths = array();
		}

		// Loop through each path to run validations
		foreach ($paths as $path) {
			$path = rtrim(DIR_IMAGE. str_replace(array('../', '..\\', '..'), '', $path), '/');

			// Check path exsists
			if ($path == DIR_IMAGE . 'catalog') {
				$json['error'] = $this->language->get('error_delete');

				break;
			}
		}

		if (!$json) {
			// Loop through each path
			foreach ($paths as $path) {
				$path = rtrim(DIR_IMAGE . str_replace(array('../', '..\\', '..'), '', $path), '/');

				// If path is just a file delete it
				if (is_file($path)) {
					unlink($path);

				// If path is a directory beging deleting each file and sub folder
				} elseif (is_dir($path)) {
					$files = array();

					// Make path into an array
					$path = array($path . '*');

					// While the path array is still populated keep looping through
					while (count($path) != 0) {
						$next = array_shift($path);

						foreach (glob($next) as $file) {
							// If directory add to path array
							if (is_dir($file)) {
								$path[] = $file . '/*';
							}

							// Add the file to the files to be deleted array
							$files[] = $file;
						}
					}

					// Reverse sort the file array
					rsort($files);

					foreach ($files as $file) {
						// If file just delete
						if (is_file($file)) {
							unlink($file);

						// If directory use the remove directory function
						} elseif (is_dir($file)) {
							rmdir($file);
						}
					}
				}
			}

			$json['success'] = $this->language->get('text_delete');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	
	//hoang
	
	public function renamefile() {
		$this->load->language('common/filemanager');

		$json = array();

		// Check user has permission
		if (!$this->user->hasPermission('modify', 'common/filemanager')) {
			$json['error'] = $this->language->get('error_permission');
		}

		if (isset($this->request->post['path'])) {
			$paths = $this->request->post['path'];
		} else {
			$paths = array();
		}
		//print_r($this->request->post);
		if(count($paths)!=1 || empty($this->request->get['name_new'])){
			$json['error'] = 'Chọn 1 thư mục tập tin và nhập tên cần đổi!';
		}else{

			// Loop through each path to run validations
			foreach ($paths as $path) {
				$path = rtrim(DIR_IMAGE. str_replace(array('../', '..\\', '..'), '', $path), '/');
	
				// Check path exsists
				if ($path == DIR_IMAGE . 'catalog') {
					$json['error'] = 'Không đổi tên thư mục, tập tin được!';
	
					break;
				}
			}
	
			if (!$json) {
				// Loop through each path
				foreach ($paths as $path) {
					$path = rtrim(DIR_IMAGE . str_replace(array('../', '..\\', '..'), '', $path), '/');
	
					// If path is just a file delete it
					if (is_file($path)) {
						if (is_file($path)) {
							$ext = strrchr($path, '.');
						} else {
							$ext = '';
						}		
						
						$new_name = dirname($path) . '/' . str_replace('../', '', $this->request->get['name_new'] . $ext);
																						   
						if (file_exists($new_name)) {
							$json['error'] = 'Thư mục, tập tin đã tồn tại!';
						}
						
						if (!isset($json['error'])) {
							rename($path, $new_name);
						}
						
					// If path is a directory beging deleting each file and sub folder
					} elseif (is_dir($path)) {
						
						$new_name = dirname($path) . '/' . str_replace('../', '', $this->request->get['name_new']);
						
						if (file_exists($new_name)) {
							$json['error'] = 'Thư mục, tập tin đã tồn tại!';
						}
						
						if (!isset($json['error'])) {
							rename($path, $new_name);
						}
						
					}
				}

				$json['success'] = 'Đổi tên thư mục, tập tin thành công!';
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	
	
	public function linkfile(){
		
		set_time_limit(0);
		ini_set('max_execution_time','INCREASE TIME');
		ini_set('memory_limit','-1');
		
		//print_r($this->request);
		
		if (isset($this->request->files[0]) && is_uploaded_file($this->request->files[0]['tmp_name'])) {
				
			$ext = strrchr($this->request->files[0]['name'], '.');
			if($ext=='.doc' || $ext=='.docx' || $ext=='.pdf' || $ext=='.xls' || $ext=='.xlsx' || $ext=='.txt' || $ext=='.png' || $ext=='.jpg' || $ext=='.jpeg' || $ext=='.gif'){
				$name = substr($this->request->files[0]['name'],0, (strlen($this->request->files[0]['name']) - strlen($ext)));
				
				$filename = $name . '.' . md5(rand()) . $ext;
				
				move_uploaded_file($this->request->files[0]['tmp_name'], DIR_PDF . $filename);
	
				if (file_exists(DIR_PDF . $filename)) {
					echo HTTP_PDF . $filename;
					//$data['files'] = $filename;
				}else{
					echo 'http://';
				}
			}else{
				echo 'http://';
			}
		}else{
			echo 'http://';
		}
	}
	
	private function compress($source, $destination, $quality) {

		$info = getimagesize($source);
		
		if ($info['mime'] == 'image/jpeg') {
			$image = imagecreatefromjpeg($source);
			imagejpeg($image, $destination, $quality);
			imagedestroy($image);
		}elseif ($info['mime'] == 'image/png') {
			$image = imagecreatefrompng($source);
			
			imagealphablending($image, false);
			imagesavealpha($image, true);
			
			imagepng($image, $destination, 9  );
			imagedestroy($image);
		}
		
		
		return $destination;
	}
}
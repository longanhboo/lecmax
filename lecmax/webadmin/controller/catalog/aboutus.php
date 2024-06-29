<?php
class ControllerCatalogAboutus extends Controller {
	private $error = array();

	public function __construct($registry) {
		$this->registry = $registry;

		$this->load->model('catalog/lang');

		$langs = $this->model_catalog_lang->getLangByModule('aboutus',2);
		foreach($langs as $lang){
			$this->data[$lang['key']] = html_entity_decode($lang['name']);
		}

		if(isset($this->request->get['cate']) && $this->request->get['cate']>0){
			$this->load->model('catalog/aboutus');
			$this->data['heading_title'] = $this->data['heading_title'] . ' >> ' . $this->model_catalog_aboutus->getTitle($this->request->get['cate']);
		}
        
        /*{$CHANGE_TITLE}*/
	}

	public function index() {
		$this->document->setTitle($this->data['heading_title']);
		
		if(isset($_SESSION['temp_pro'])){
			if($_SESSION['temp_pro']<=1){
				$_SESSION['temp_pro'] = $_SESSION['temp_pro'];
			}else{
				$_SESSION['temp_pro'] = 0;
			}
		}else{
			$_SESSION['temp_pro'] = 0;
		}
		
		$this->load->model('catalog/aboutus');

		$this->getList();
	}

	public function insert() {

		$this->document->setTitle($this->data['heading_title']);

		$this->load->model('catalog/aboutus');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$data = $this->request->post;
			
			if (is_uploaded_file($this->request->files['video_mp4']['tmp_name'])) {
				
				$ext = strrchr($this->request->files['video_mp4']['name'], '.');
				
				$name = substr($this->request->files['video_mp4']['name'],0, (strlen($this->request->files['video_mp4']['name']) - strlen($ext)));
				
				$filename = $name . '.' . md5(rand()) . $ext;
				
				move_uploaded_file($this->request->files['video_mp4']['tmp_name'], DIR_DOWNLOAD . $filename);

				if (file_exists(DIR_DOWNLOAD . $filename)) {
					$data['video_mp4'] = $filename;
				}
			}			
			
			if (is_uploaded_file($this->request->files['video_webm']['tmp_name'])) {
				
				$ext = strrchr($this->request->files['video_webm']['name'], '.');
				
				$name = substr($this->request->files['video_webm']['name'],0, (strlen($this->request->files['video_webm']['name']) - strlen($ext)));
				
				$filename = $name . '.' . md5(rand()) . $ext;
				
				move_uploaded_file($this->request->files['video_webm']['tmp_name'], DIR_DOWNLOAD . $filename);

				if (file_exists(DIR_DOWNLOAD . $filename)) {
					$data['video_webm'] = $filename;
				}
			}
			
			
			$time = time();
			
			$this->load->model('localisation/language');		
			$languages = $this->model_localisation_language->getLanguages();
			
			foreach($languages as $lang){
				$parts = pathinfo($this->request->files['aboutus_description']['name'][$lang['language_id']]['pdf']);
								
				if(!empty($parts['filename']))
					$filename = convertAlias($parts['filename']) . '_' . $lang['code'] . '_'. $time . '.' . $parts['extension'];
				else
					$filename = '';
				
				if($this->request->files['aboutus_description']['error'][$lang['language_id']]['pdf']==0){
					@move_uploaded_file($this->request->files['aboutus_description']['tmp_name'][$lang['language_id']]['pdf'], DIR_PDF . $filename);
					$data['aboutus_description'][$lang['language_id']]['pdf'] = $filename;
				}else{
					$data['aboutus_description'][$lang['language_id']]['pdf']='';	
				}								
			}

			/*{INSERT_CONTROLLER}*/

			$this->model_catalog_aboutus->addAboutus($data);
			
			$this->load->model('tool/image');
			if (isset($this->request->post['aboutus_image'])) {
				foreach ($this->request->post['aboutus_image'] as $image) {
					if (file_exists(DIR_IMAGE . $image['image']) && is_file(DIR_IMAGE . $image['image'])) {
					list($widthImg, $heightImg) = getimagesize(DIR_IMAGE.$image['image']);
					$this->model_tool_image->resize_mobile($image['image'], $widthImg*2/3, $heightImg*2/3);
					}
					if (file_exists(DIR_IMAGE . $image['image1']) && is_file(DIR_IMAGE . $image['image1'])) {
					list($widthImg, $heightImg) = getimagesize(DIR_IMAGE.$image['image1']);
					$this->model_tool_image->resize_mobile($image['image1'], $widthImg*2/3, $heightImg*2/3);
					}
				}
			}
			
			if (isset($this->request->post['image'])) {
				if (file_exists(DIR_IMAGE . $this->request->post['image']) && is_file(DIR_IMAGE . $this->request->post['image'])) {
					list($widthImg, $heightImg) = getimagesize(DIR_IMAGE.$this->request->post['image']);
					if (isset($this->request->get['cate'])) {
						$this->model_tool_image->resize_mobile($this->request->post['image'], $widthImg, $heightImg);
					}else{
						$this->model_tool_image->resize_mobile($this->request->post['image'], $widthImg*2/3, $heightImg*2/3);
					}
				}
			}

			$this->session->data['success'] = $this->data['text_success'];

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . $this->request->get['filter_name'];
			}
			
			if (isset($this->request->get['filter_ishome'])) {
				$url .= '&filter_ishome=' . $this->request->get['filter_ishome'];
			}

						if (isset($this->request->get['cate'])) {
				$url .= '&cate=' . (int)$this->request->get['cate'];
			}
			
			if (isset($this->request->get['url_catedup'])) {
				$url .= '&url_catedup=' . (int)$this->request->get['url_catedup'];
			}
            
            /*{FILTER_URL}*/

			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->redirect($this->url->link('catalog/aboutus', 'token=' . $this->session->data['token'] . $url, '', 'SSL'));
			exit;
		}

		$this->getForm();
	}

	public function update() {

		$this->document->setTitle($this->data['heading_title']);

		$this->load->model('catalog/aboutus');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$data = $this->request->post;

			/*{UPDATE_CONTROLLER}*/
			
			$filename_old = $this->model_catalog_aboutus->getVideoById($this->request->get['aboutus_id']) ;
			if (is_uploaded_file($this->request->files['video_mp4']['tmp_name'])) {				

				if (!empty($filename_old['filename_mp4']) && file_exists(DIR_DOWNLOAD . $filename_old['filename_mp4'])) {
					@unlink(DIR_DOWNLOAD . $filename_old['filename_mp4']);
				}
				
				$ext = strrchr($this->request->files['video_mp4']['name'], '.');
				
				$name = substr($this->request->files['video_mp4']['name'],0, (strlen($this->request->files['video_mp4']['name']) - strlen($ext)));
				
				$filename = $name . '.' . md5(rand()) . $ext;
				
				move_uploaded_file($this->request->files['video_mp4']['tmp_name'], DIR_DOWNLOAD . $filename);

				if (file_exists(DIR_DOWNLOAD . $filename)) {
					$data['video_mp4'] = $filename;
				}
			}
			
			if (is_uploaded_file($this->request->files['video_webm']['tmp_name'])) {								

				if (!empty($filename_old['video_webm']) && file_exists(DIR_DOWNLOAD . $filename_old['video_webm'])) {
					@unlink(DIR_DOWNLOAD . $filename_old['video_webm']);
				}
				
				$ext = strrchr($this->request->files['video_webm']['name'], '.');
				
				$name = substr($this->request->files['video_webm']['name'],0, (strlen($this->request->files['video_webm']['name']) - strlen($ext)));
				
				$filename = $name . '.' . md5(rand()) . $ext;
				
				move_uploaded_file($this->request->files['video_webm']['tmp_name'], DIR_DOWNLOAD . $filename);

				if (file_exists(DIR_DOWNLOAD . $filename)) {
					$data['video_webm'] = $filename;
				}
			}
			
			$time = time();
			
			$this->load->model('localisation/language');		
			$languages = $this->model_localisation_language->getLanguages();
			
			foreach($languages as $lang){
				$parts = pathinfo($this->request->files['aboutus_description']['name'][$lang['language_id']]['pdf']);
				
				if(!empty($parts['filename']))
					$filename = convertAlias($parts['filename']) . '_' . $lang['code'] . '_'. $time . '.' . $parts['extension'];
				else
					$filename = '';
				
				if(isset($this->request->post['aboutus_description'][$lang['language_id']]['delete_pdf']) && $this->request->post['aboutus_description'][$lang['language_id']]['delete_pdf']==1)
				{
					$data['aboutus_description'][$lang['language_id']]['pdf'] = '';
					$old_file = $this->request->post['aboutus_description'][$lang['language_id']]['old_file'];
					if(!empty($old_file) && file_exists(DIR_PDF . $old_file))
						unlink(DIR_PDF . $old_file);
				}else{
					if($this->request->files['aboutus_description']['error'][$lang['language_id']]['pdf']==0){
						
						$old_file = $this->request->post['aboutus_description'][$lang['language_id']]['old_file'];
						if(!empty($old_file) && file_exists(DIR_PDF . $old_file))
							unlink(DIR_PDF . $old_file);
						
						@move_uploaded_file($this->request->files['aboutus_description']['tmp_name'][$lang['language_id']]['pdf'], DIR_PDF . $filename);
						$data['aboutus_description'][$lang['language_id']]['pdf'] = $filename;
					}else{
						$data['aboutus_description'][$lang['language_id']]['pdf']=$this->request->post['aboutus_description'][$lang['language_id']]['old_file'];	
					}
				}				
			}

			$this->model_catalog_aboutus->editAboutus($this->request->get['aboutus_id'], $data);
			
			$this->load->model('tool/image');
			if (isset($this->request->post['aboutus_image'])) {
				foreach ($this->request->post['aboutus_image'] as $image) {
					if (file_exists(DIR_IMAGE . $image['image']) && is_file(DIR_IMAGE . $image['image'])) {
					list($widthImg, $heightImg) = getimagesize(DIR_IMAGE.$image['image']);
					$this->model_tool_image->resize_mobile($image['image'], $widthImg*2/3, $heightImg*2/3);
					}
					if (file_exists(DIR_IMAGE . $image['image1']) && is_file(DIR_IMAGE . $image['image1'])) {
					list($widthImg, $heightImg) = getimagesize(DIR_IMAGE.$image['image1']);
					$this->model_tool_image->resize_mobile($image['image1'], $widthImg*2/3, $heightImg*2/3);
					}
				}
			}
			
			if (isset($this->request->post['image'])) {
				if (file_exists(DIR_IMAGE . $this->request->post['image']) && is_file(DIR_IMAGE . $this->request->post['image'])) {
					list($widthImg, $heightImg) = getimagesize(DIR_IMAGE.$this->request->post['image']);
					if (isset($this->request->get['cate'])) {
						$this->model_tool_image->resize_mobile($this->request->post['image'], $widthImg, $heightImg);
					}else{
						$this->model_tool_image->resize_mobile($this->request->post['image'], $widthImg*2/3, $heightImg*2/3);
					}
				}
			}

			$this->session->data['success'] = $this->data['text_success_update'];

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . $this->request->get['filter_name'];
			}
			
			if (isset($this->request->get['filter_ishome'])) {
				$url .= '&filter_ishome=' . $this->request->get['filter_ishome'];
			}

						if (isset($this->request->get['cate'])) {
				$url .= '&cate=' . (int)$this->request->get['cate'];
			}
			
			if (isset($this->request->get['url_catedup'])) {
				$url .= '&url_catedup=' . (int)$this->request->get['url_catedup'];
			}
            
            /*{FILTER_URL}*/

			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->redirect($this->url->link('catalog/aboutus', 'token=' . $this->session->data['token'] . $url, '', 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {

		$this->document->setTitle($this->data['heading_title']);

		$this->load->model('catalog/aboutus');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $aboutus_id) {

				/*{DELETE_CONTROLLER}*/
				$filename_old = $this->model_catalog_aboutus->getVideoById($aboutus_id) ;
				if (!empty($filename_old['filename_webm']) && file_exists(DIR_DOWNLOAD . $filename_old['filename_webm'])) {
					@unlink(DIR_DOWNLOAD . $filename_old['filename_webm']);
				}
				
				if (!empty($filename_old['filename_mp4']) && file_exists(DIR_DOWNLOAD . $filename_old['filename_mp4'])) {
					@unlink(DIR_DOWNLOAD . $filename_old['filename_mp4']);
				}
				
				$pdfs = $this->model_catalog_aboutus->getPdf($aboutus_id);
				
				foreach($pdfs as $item){
					if(!empty($item['pdf']) && file_exists(DIR_PDF . $item['pdf']))
							unlink(DIR_PDF . $item['pdf']);
				}

				$this->model_catalog_aboutus->deleteAboutus($aboutus_id);
			}

			$this->session->data['success'] = $this->data['text_success_delete'];

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . $this->request->get['filter_name'];
			}
			
			if (isset($this->request->get['filter_ishome'])) {
				$url .= '&filter_ishome=' . $this->request->get['filter_ishome'];
			}

						if (isset($this->request->get['cate'])) {
				$url .= '&cate=' . (int)$this->request->get['cate'];
			}
			
			if (isset($this->request->get['url_catedup'])) {
				$url .= '&url_catedup=' . (int)$this->request->get['url_catedup'];
			}
            
            /*{FILTER_URL}*/

			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->redirect($this->url->link('catalog/aboutus', 'token=' . $this->session->data['token'] . $url, '', 'SSL'));
		}

		$this->getList();
	}

	public function copy() {

		$this->document->setTitle($this->data['heading_title']);

		$this->load->model('catalog/aboutus');

		if (isset($this->request->post['selected']) && $this->validateCopy()) {
			foreach ($this->request->post['selected'] as $aboutus_id) {
				$this->model_catalog_aboutus->copyAboutus($aboutus_id);
			}

			$this->session->data['success'] = $this->data['text_success'];

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . $this->request->get['filter_name'];
			}
			
			if (isset($this->request->get['filter_ishome'])) {
				$url .= '&filter_ishome=' . $this->request->get['filter_ishome'];
			}

						if (isset($this->request->get['cate'])) {
				$url .= '&cate=' . (int)$this->request->get['cate'];
			}
			
			if (isset($this->request->get['url_catedup'])) {
				$url .= '&url_catedup=' . (int)$this->request->get['url_catedup'];
			}
            
            /*{FILTER_URL}*/

			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->redirect($this->url->link('catalog/aboutus', 'token=' . $this->session->data['token'] . $url, '', 'SSL'));
		}

		$this->getList();
	}

	private function getList() {

		//================================Filter=================================================
		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = null;
		}
		
		if (isset($this->request->get['filter_ishome'])) {
			$filter_ishome = $this->request->get['filter_ishome'];
		} else {
			$filter_ishome = null;
		}

				if (isset($this->request->get['cate'])) {
			$cate = (int)$this->request->get['cate'];
		} else {
			$cate = 0;
		}
        
        /*{FILTER_VALUE}*/

		if (isset($this->request->get['filter_status'])) {
			$filter_status = $this->request->get['filter_status'];
		} else {
			$filter_status = null;
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'p.sort_order';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		//================================URL=================================================
		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}
		
		if (isset($this->request->get['filter_ishome'])) {
				$url .= '&filter_ishome=' . $this->request->get['filter_ishome'];
			}

					if (isset($this->request->get['cate'])) {
				$url .= '&cate=' . (int)$this->request->get['cate'];
			}
            
            /*{FILTER_URL}*/

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
		                                     'text'      => $this->data['text_home'],
		                                     'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], '', 'SSL'),
		                                     'separator' => false
		                                     );

		$this->data['breadcrumbs'][] = array(
		                                     'text'      => $this->data['heading_title'],
		                                     'href'      => $this->url->link('catalog/aboutus', 'token=' . $this->session->data['token'] . $url, '', 'SSL'),
		                                     'separator' => ' :: '
		                                     );

		$url_filter = '';
		if (isset($this->request->get['filter_category'])) {
			$url_filter .= '&filter_category=' . $this->request->get['filter_category'];
		}
		
		$url_catedup = '';
		$url_catedup_dup = '';
		if (isset($this->request->get['url_catedup'])) {
			$url_catedup .= '&cate=' . $this->request->get['url_catedup'];
			$url_catedup_dup .= '&url_catedup=' . $this->request->get['url_catedup'];
		}
		$this->data['url_catedup'] = isset($this->request->get['url_catedup'])?(int)($this->request->get['url_catedup']):0;

		$this->data['insert'] = $this->url->link('catalog/aboutus/insert', 'token=' . $this->session->data['token'] . $url, '', 'SSL');
		$this->data['copy'] = $this->url->link('catalog/aboutus/copy', 'token=' . $this->session->data['token'] . $url, '', 'SSL');
		$this->data['delete'] = $this->url->link('catalog/aboutus/delete', 'token=' . $this->session->data['token'] . $url, '', 'SSL');

		$this->data['filter'] = $this->url->link('catalog/aboutus', 'token=' . $this->session->data['token'] . $url_filter, '', 'SSL');
		$this->data['back'] = $this->url->link('catalog/aboutus', 'token=' . $this->session->data['token'], '', 'SSL');
		
		if(!empty($url_catedup)){
			$this->data['insert'] = $this->url->link('catalog/aboutus/insert', 'token=' . $this->session->data['token'] . $url . $url_catedup_dup, '', 'SSL');
			$this->data['copy'] = $this->url->link('catalog/aboutus/copy', 'token=' . $this->session->data['token'] . $url . $url_catedup_dup, '', 'SSL');
			$this->data['delete'] = $this->url->link('catalog/aboutus/delete', 'token=' . $this->session->data['token'] . $url . $url_catedup_dup, '', 'SSL');
	
			$this->data['filter'] = $this->url->link('catalog/aboutus', 'token=' . $this->session->data['token'] . $url_filter . $url_catedup_dup, '', 'SSL');
			
			$this->data['back'] = $this->url->link('catalog/aboutus', 'token=' . $this->session->data['token'] . $url_catedup, '', 'SSL');
		}
		
		$this->data['aboutuss'] = array();

		$data = array(
		              'filter_name'	  => $filter_name,
		              'cate'   => $cate,
					  'filter_ishome'   => $filter_ishome,

/*{FILTER_PARAM}*/
		              'filter_status'   => $filter_status,
		              'sort'            => $sort,
		              'order'           => $order,
		              'start'           => ($page - 1) * $this->config->get('config_admin_limit'),
		              'limit'           => $this->config->get('config_admin_limit')
		              );
		$this->load->model('tool/image');
		$aboutus_total = $this->model_catalog_aboutus->getTotalAboutuss($data);

		$results = $this->model_catalog_aboutus->getAboutuss($data);

		/*{INCLUDE_CATEGORY}*/

		foreach ($results as $result) {
			$action = array();
			//|| $result["aboutus_id"]==1 || $result["aboutus_id"]==3 || $result["aboutus_id"]==12 || $result["aboutus_id"]==34 || $result["aboutus_id"]==19 || $cate==12
						if(1==2 || $result["aboutus_id"]==46 || $result["aboutus_id"]==3  || $result["aboutus_id"]==12 || $result["aboutus_id"]==58  || $result["aboutus_id"]==19  || $result["aboutus_id"]==120 || $result["aboutus_id"]==55 || $result["aboutus_id"]==159 || $result["aboutus_id"]==59  || $cate==93 || $result["aboutus_id"]==93 || $result["aboutus_id"]==34 || $cate==12 ){
							$href_temp = $this->url->link('catalog/aboutus', 'token=' . $this->session->data['token'] . '&cate=' . $result['aboutus_id'] , '', 'SSL');
							
							if($cate==12 || $cate==93){
								$href_temp = $this->url->link('catalog/aboutus', 'token=' . $this->session->data['token'] . '&cate=' . $result['aboutus_id'] . '&url_catedup=' . $result['cate'], '', 'SSL');
							}
				$action[] = array(
                	'cls'  =>'btn_list',
					'text' => $this->data['text_list'],
					'href' => $href_temp
				);
			}
			
			$href_temp_update = $this->url->link('catalog/aboutus/update', 'token=' . $this->session->data['token'] . '&aboutus_id=' . $result['aboutus_id'] . $url, '', 'SSL');
			if($this->data['url_catedup']==12 || $this->data['url_catedup']==93){
				$href_temp_update = $this->url->link('catalog/aboutus/update', 'token=' . $this->session->data['token'] . '&aboutus_id=' . $result['aboutus_id'] . $url . '&url_catedup=' . $this->data['url_catedup'], '', 'SSL');
			}
			
			$action[] = array(
			                  'cls'  =>'modify',
			                  'text' => $this->data['text_edit'],
			                  'href' => $href_temp_update
			                  );
			            if ($result['image'] && file_exists(DIR_IMAGE . $result['image'])) {
                $image = $this->model_tool_image->resize($result['image'], 40, 40);
            } else {
                $image = $this->model_tool_image->resize('no_image.jpg', 40, 40);
            }
			if($result['cate']==34){
			if ($result['image_video'] && file_exists(DIR_IMAGE . $result['image_video'])) {
                $image = $this->model_tool_image->resize($result['image_video'], 40, 40);
            } else {
                $image = $this->model_tool_image->resize('no_image.jpg', 40, 40);
            }
			}
			
			$this->data['aboutuss'][] = array(
			                                                  'aboutus_id' => $result['aboutus_id'],
			                                                  'sort_order'       => $result['sort_order'],
			                                                  'name'       => strip_tags(html_entity_decode($result['name'])),
			                                                  'image'      => $image,
															  'ishome'     => ($result['ishome'] ? '<img src="view/image/success.png" title="'.$this->data['text_enabled'].'" />' : '<img src="view/image/delete.png" title="'.$this->data['text_disabled'].'" />'),
/*{IMAGE_LIST_ARRAY}*/
			                                                  'status_id'		=> $result['status'],
			                                                  'status'     => ($result['status'] ? '<img src="view/image/success.png" title="'.$this->data['text_enabled'].'" />' : '<img src="view/image/delete.png" title="'.$this->data['text_disabled'].'" />'),
			                                                  'selected'   => isset($this->request->post['selected']) && in_array($result['aboutus_id'], $this->request->post['selected']),
			                                                  'action'     => $action
			                                                  );
		}

		$this->data['token'] = $this->session->data['token'];

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		//cate danh sach con
		if(isset($this->request->get['cate']) && $this->request->get['cate']>0){
			$this->data['sublist_cate'] = (int)$this->request->get['cate'];
		}else{
			$this->data['sublist_cate'] = 0;
		}

		//================================URL=================================================
		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}
		
		if (isset($this->request->get['filter_ishome'])) {
				$url .= '&filter_ishome=' . $this->request->get['filter_ishome'];
			}

					if (isset($this->request->get['cate'])) {
				$url .= '&cate=' . (int)$this->request->get['cate'];
			}
            
            /*{FILTER_URL}*/

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$this->data['sort_name'] = $this->url->link('catalog/aboutus', 'token=' . $this->session->data['token'] . '&sort=pd.name' . $url, '', 'SSL');
		$this->data['sort_status'] = $this->url->link('catalog/aboutus', 'token=' . $this->session->data['token'] . '&sort=p.status' . $url, '', 'SSL');
		$this->data['sort_order'] = $this->url->link('catalog/aboutus', 'token=' . $this->session->data['token'] . '&sort=p.sort_order' . $url, '', 'SSL');

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}
		
		if (isset($this->request->get['filter_ishome'])) {
				$url .= '&filter_ishome=' . $this->request->get['filter_ishome'];
			}

					if (isset($this->request->get['cate'])) {
				$url .= '&cate=' . (int)$this->request->get['cate'];
			}
            
            /*{FILTER_URL}*/

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $aboutus_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->data['text_pagination'];
		$pagination->url = $this->url->link('catalog/aboutus', 'token=' . $this->session->data['token'] . $url . '&page={page}', '', 'SSL');

		$this->data['pagination'] = $pagination->render();

		$this->data['results'] = sprintf($this->language->get('text_pagination'), ($aboutus_total) ? (($page - 1) * $this->config->get('config_admin_limit')) + 1 : 0, ((($page - 1) * $this->config->get('config_admin_limit')) > ($aboutus_total - $this->config->get('config_admin_limit'))) ? $aboutus_total : ((($page - 1) * $this->config->get('config_admin_limit')) + $this->config->get('config_admin_limit')), $aboutus_total, ceil($aboutus_total / $this->config->get('config_admin_limit')));

		$this->data['filter_name'] = $filter_name;

		$this->data['cate'] = $cate;
		
		$this->data['filter_ishome'] = $filter_ishome;

/*{FILTER_DATA}*/

		$this->data['filter_status'] = $filter_status;

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'catalog/aboutus_list.tpl';
		$this->children = array(
		                        'common/header',
		                        'common/footer',
		                        );

		$this->response->setOutput($this->render());
	}

	private function getForm() {
				$cate = isset($this->request->get['cate'])?(int)$this->request->get['cate']:0;
		$this->data['cate'] = $cate;
		
		$aboutus_id = isset($this->request->get['aboutus_id'])?(int)$this->request->get['aboutus_id']:0;
		$this->data['aboutus_id'] = $aboutus_id;
		
		$url_catedup = '';
		$url_catedup_dup = '';
		if (isset($this->request->get['url_catedup'])) {
			$url_catedup .= '&cate=' . $this->request->get['url_catedup'];
			$url_catedup_dup .= '&url_catedup=' . $this->request->get['url_catedup'];
		}
		$this->data['url_catedup'] = isset($this->request->get['url_catedup'])?(int)($this->request->get['url_catedup']):0;
		
		if($aboutus_id==44){
			$this->data['help_entry_image'] = $this->data['help_entry_image_44'];
			$this->data['entry_image1'] = $this->data['entry_image_chart'];
			$this->data['entry_image2'] = $this->data['entry_image1_chart'];
			$this->data['help_entry_image1'] = $this->data['help_entry_image_chart'];
			$this->data['help_entry_image2'] = $this->data['help_entry_image_chart'];
			
		}elseif($aboutus_id==49){
			$this->data['tab_image'] = $this->data['tab_noidung'];
			$this->data['button_add_image'] = $this->data['button_add_noidung'];
		}elseif($aboutus_id==56){
			$this->data['entry_image1'] = $this->data['entry_image_chart'];
			$this->data['help_entry_image1'] = $this->data['help_entry_image_chart'];
			$this->data['entry_image2'] = $this->data['entry_image1_chart'];
			$this->data['help_entry_image2'] = $this->data['help_entry_image_chart'];
		}elseif($aboutus_id==24){
			$this->data['entry_image'] = $this->data['entry_image_24'];
			$this->data['help_entry_image'] = $this->data['help_entry_image_24'];
		}elseif($aboutus_id==3){
			$this->data['entry_image'] = $this->data['entry_image_3'];
			$this->data['help_entry_image'] = $this->data['help_entry_image_3'];
		}
		
		
		if($cate==51){
			$this->data['entry_image'] = $this->data['entry_image_logo'];
			$this->data['help_entry_image'] = $this->data['help_entry_image_51'];
			$this->data['help_column_images'] = $this->data['help_column_images_51'];
			$this->data['help_column_images1'] = $this->data['help_column_images1_51'];
		}elseif($cate==50){
			$this->data['entry_image'] = $this->data['entry_image_50'];
			$this->data['help_entry_image'] = $this->data['help_entry_image_50'];
			$this->data['help_column_images'] = $this->data['help_column_images_50'];
			//$this->data['help_column_images1'] = $this->data['help_column_images1_50'];
			$this->data['entry_image1'] = $this->data['entry_image1_50'];
		}elseif($cate==34){
			$this->data['entry_image'] = $this->data['entry_image_cate_34'];
			$this->data['help_entry_image'] = $this->data['help_entry_image_cate_34'];
		}elseif($cate==59){
			$this->data['entry_image'] = $this->data['entry_image_cate_59'];
			$this->data['help_entry_image'] = $this->data['help_entry_image_cate_59'];
		}elseif($cate==12){
			$this->data['entry_image'] = $this->data['entry_image_cate_12'];
			$this->data['help_entry_image'] = $this->data['help_entry_image_cate_12'];
		}elseif($cate==55){
			$this->data['entry_image'] = $this->data['entry_image_cate_55'] . " (VN)";
			$this->data['help_entry_image'] = $this->data['help_entry_image_cate_55'];
			$this->data['entry_image1'] = $this->data['entry_image_cate_55'] . " (EN)";
			$this->data['help_entry_image1'] = $this->data['help_entry_image_cate_55'];
		}elseif($cate==19){
			$this->data['entry_image'] = $this->data['entry_image_cate_55'];
			$this->data['entry_image1'] = $this->data['entry_image_cate_55'] . ' (EN)';
			$this->data['help_entry_image1'] = $this->data['help_entry_image'];
		}elseif($cate==3){
			$this->data['entry_image'] = $this->data['entry_image_cate_3'];
			$this->data['help_entry_image'] = $this->data['help_entry_image_cate_3'];
		}elseif($cate==120){
			$this->data['entry_image'] = $this->data['entry_image_cate_120'];
			$this->data['help_entry_image'] = $this->data['help_entry_image_cate_120'];
		}elseif($cate==159){
			$this->data['entry_image'] = $this->data['entry_image_cate_159'];
			$this->data['help_entry_image'] = $this->data['help_entry_image_cate_159'];
		}
		
		/*if($aboutus_id==5){
			$this->data['help_column_images'] = $this->data['help_column_images_1024'];
		}elseif($aboutus_id==1){
			//$this->data['help_entry_image'] = $this->data['help_entry_image_history'];
			$this->data['column_images'] = $this->data['column_images_19'];
			$this->data['help_column_images'] = $this->data['help_column_images_1'];
			$this->data['column_images1'] = $this->data['column_images1_19'];
			$this->data['help_column_images1'] = $this->data['help_column_images_1'];
		}elseif($aboutus_id==2){
			$this->data['entry_image'] = $this->data['entry_image_id_2'];
			$this->data['help_entry_image'] = $this->data['help_entry_image_id_2'];
		}elseif($aboutus_id==18 || $aboutus_id==14){
			$this->data['entry_image1'] = $this->data['entry_image_id_2'];
			$this->data['help_entry_image1'] = $this->data['help_entry_image_id_18'];
		}elseif($aboutus_id==6){
			$this->data['help_column_images'] = $this->data['help_column_images_820'];
			$this->data['help_entry_image'] = $this->data['help_entry_image_nen1'];
		}elseif($aboutus_id==10){
			$this->data['entry_desc_short'] = $this->data['entry_description'];
			$this->data['help_entry_image'] = $this->data['help_entry_image_nen1'];
		}elseif($aboutus_id==11){
			$this->data['entry_image1'] = $this->data['entry_image_chart'];
			$this->data['help_entry_image1'] = $this->data['help_entry_image_chart'];
			$this->data['entry_image2'] = $this->data['entry_image1_chart'];
			$this->data['help_entry_image2'] = $this->data['help_entry_image_chart'];
		}elseif($aboutus_id==8){
			$this->data['tab_image'] = $this->data['tab_thoigian'];
			$this->data['button_add_image'] = $this->data['button_add_thoigian'];
		}elseif($aboutus_id==17){
			$this->data['tab_image'] = $this->data['tab_noidung'];
			$this->data['button_add_image'] = $this->data['button_add_noidung'];
		}elseif($aboutus_id==14){
			$this->data['help_column_images'] = $this->data['help_column_images_150'];
		}elseif($aboutus_id==24){
			$this->data['entry_image'] = $this->data['entry_image_24'];
			$this->data['help_entry_image'] = $this->data['help_entry_image_24'];
			//$this->data['tab_image'] = $this->data['tab_noidung'];
			//$this->data['button_add_image'] = 'Thêm';
		}elseif($aboutus_id==19){
			$this->data['column_images'] = $this->data['column_images_19'];
			$this->data['help_column_images'] = $this->data['help_column_images_19'];
			$this->data['column_images1'] = $this->data['column_images1_19'];
			$this->data['help_column_images1'] = $this->data['help_column_images_19'];
		}*/
		/*
		if($cate==1){
			$this->data['entry_image'] = $this->data['entry_image_logo'];
			$this->data['help_entry_image'] = $this->data['help_entry_image_logo'];
			$this->data['entry_name2'] = $this->data['entry_desc_short'];
		}elseif($cate==12){
			$this->data['entry_address'] = $this->data['entry_chucvu'];
			$this->data['entry_image'] = $this->data['entry_image_album'];
			$this->data['help_entry_image'] = $this->data['help_entry_image_album'];
			$this->data['help_column_images'] = $this->data['help_column_images_album'];
		}elseif($cate==13){
			$this->data['entry_name2'] = $this->data['entry_bangcap'];
			$this->data['entry_address'] = $this->data['entry_chucvu'];
			$this->data['entry_image'] = $this->data['entry_image_album'];
			$this->data['help_entry_image'] = $this->data['help_entry_image_bld'];
			//$this->data['help_column_images'] = $this->data['help_column_images_album'];
		}elseif($cate==11 || $cate==34){
			//$this->data['entry_address'] = $this->data['entry_chucvu'];
			$this->data['entry_image'] = $this->data['entry_image_album'];
			$this->data['help_entry_image'] = $this->data['help_entry_image_11'];
			//$this->data['help_column_images'] = $this->data['help_column_images_album'];
		}elseif($cate==19){
			$this->data['entry_image'] = $this->data['entry_image_id_2'];
			$this->data['help_entry_image'] = $this->data['help_entry_image_cate_19'];
			$this->data['help_column_images'] = $this->data['help_column_images_album'];
		}*/
		
		//Error
		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->error['name'])) {
			$this->data['error_name'] = $this->error['name'];
		} else {
			$this->data['error_name'] = array();
		}

		        if (isset($this->error['image'])) {
            $this->data['error_image'] = $this->error['image'];
        } else {
            $this->data['error_image'] = '';
        }
		
		if (isset($this->error['image1'])) {
            $this->data['error_image1'] = $this->error['image1'];
        } else {
            $this->data['error_image1'] = '';
        }
        
                if (isset($this->error['aboutus_image'])) {
			$this->data['error_images'] = $this->error['aboutus_image'];
		} else {
			$this->data['error_images'] = '';
		}
		
		if (isset($this->error['video_webm'])) {
			$this->data['error_video_webm'] = $this->error['video_webm'];
		} else {
			$this->data['error_video_webm'] = '';
		}
		
		if (isset($this->error['video_mp4'])) {
			$this->data['error_video_mp4'] = $this->error['video_mp4'];
		} else {
			$this->data['error_video_mp4'] = '';
		}
		
		if (isset($this->error['file_mp4_ftp'])) {
			$this->data['error_file_mp4_ftp'] = $this->error['file_mp4_ftp'];
		} else {
			$this->data['error_file_mp4_ftp'] = '';
		}
		
		if (isset($this->error['file_webm_ftp'])) {
			$this->data['error_file_webm_ftp'] = $this->error['file_webm_ftp'];
		} else {
			$this->data['error_file_webm_ftp'] = '';
		}
        
        /*{ERROR_IMAGE}*/
 		//URL

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}
		
		if (isset($this->request->get['filter_ishome'])) {
				$url .= '&filter_ishome=' . $this->request->get['filter_ishome'];
			}

					if (isset($this->request->get['cate'])) {
				$url .= '&cate=' . (int)$this->request->get['cate'];
			}
            
            /*{FILTER_URL}*/

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
		                                     'text'      => $this->data['text_home'],
		                                     'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], '', 'SSL'),
		                                     'separator' => false
		                                     );

		$this->data['breadcrumbs'][] = array(
		                                     'text'      => $this->data['heading_title'],
		                                     'href'      => $this->url->link('catalog/aboutus', 'token=' . $this->session->data['token'] . $url, '', 'SSL'),
		                                     'separator' => ' :: '
		                                     );

		//====================================================Assigne Data=======================================================
		if (!isset($this->request->get['aboutus_id'])) {
			$this->data['action'] = $this->url->link('catalog/aboutus/insert', 'token=' . $this->session->data['token'] . $url, '', 'SSL');
		} else {
			$this->data['action'] = $this->url->link('catalog/aboutus/update', 'token=' . $this->session->data['token'] . '&aboutus_id=' . $this->request->get['aboutus_id'] . $url, '', 'SSL');
		}

		$this->data['cancel'] = $this->url->link('catalog/aboutus', 'token=' . $this->session->data['token'] . $url, '', 'SSL');
		
		if(!empty($url_catedup)){
			if (!isset($this->request->get['aboutus_id'])) {
				$this->data['action'] = $this->url->link('catalog/aboutus/insert', 'token=' . $this->session->data['token'] . $url . $url_catedup_dup, '', 'SSL');
			} else {
				$this->data['action'] = $this->url->link('catalog/aboutus/update', 'token=' . $this->session->data['token'] . '&aboutus_id=' . $this->request->get['aboutus_id'] . $url . $url_catedup_dup, '', 'SSL');
			}
	
			$this->data['cancel'] = $this->url->link('catalog/aboutus', 'token=' . $this->session->data['token'] . $url . $url_catedup_dup, '', 'SSL');
			
		}

		$this->data['token'] = $this->session->data['token'];

		//cate danh sach con
		 /*if(isset($this->request->get['cate']) && $this->request->get['cate']>0){
		 	$sublist_cate = $this->model_catalog_aboutus->getCateById($this->request->get['cate']);
		 	$this->data['sublist_cate'] = $sublist_cate;
		 }else{
		 	$this->data['sublist_cate'] = 0;
		 }*/


		if (isset($this->request->get['aboutus_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$aboutus_info = $this->model_catalog_aboutus->getAboutus($this->request->get['aboutus_id']);
		}

		$this->load->model('localisation/language');

		$this->data['languages'] = $this->model_localisation_language->getLanguages();
		$this->load->model('tool/image');
		        if (isset($this->request->post['image'])) {
            $this->data['image'] = $this->request->post['image'];
        } elseif (isset($aboutus_info)) {
            $this->data['image'] = $aboutus_info['image'];
        } else {
            $this->data['image'] = '';
        }

		if (isset($aboutus_info) && $aboutus_info['image'] && file_exists(DIR_IMAGE . $aboutus_info['image'])) {
			$this->data['preview'] = $this->model_tool_image->resize($aboutus_info['image'], 100, 100);
		} elseif(isset($this->request->post['image']) && !empty($this->request->post['image']) && file_exists(DIR_IMAGE . $this->request->post['image'])) {
			$this->data['preview'] = $this->model_tool_image->resize($this->request->post['image'], 100, 100);
		}else{
			$this->data['preview'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}
        
                if (isset($this->request->post['image1'])) {
            $this->data['image1'] = $this->request->post['image1'];
        } elseif (isset($aboutus_info)) {
            $this->data['image1'] = $aboutus_info['image1'];
        } else {
            $this->data['image1'] = '';
        }

		if (isset($aboutus_info) && $aboutus_info['image1'] && file_exists(DIR_IMAGE . $aboutus_info['image1'])) {
			$this->data['preview1'] = $this->model_tool_image->resize($aboutus_info['image1'], 100, 100);
		} elseif(isset($this->request->post['image1']) && !empty($this->request->post['image1']) && file_exists(DIR_IMAGE . $this->request->post['image1'])) {
			$this->data['preview1'] = $this->model_tool_image->resize($this->request->post['image1'], 100, 100);
		}else{
			$this->data['preview1'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}
		
		
		if (isset($this->request->post['image2'])) {
            $this->data['image2'] = $this->request->post['image2'];
        } elseif (isset($aboutus_info)) {
            $this->data['image2'] = $aboutus_info['image2'];
        } else {
            $this->data['image2'] = '';
        }

		if (isset($aboutus_info) && $aboutus_info['image2'] && file_exists(DIR_IMAGE . $aboutus_info['image2'])) {
			$this->data['preview2'] = $this->model_tool_image->resize($aboutus_info['image2'], 100, 100);
		} elseif(isset($this->request->post['image2']) && !empty($this->request->post['image2']) && file_exists(DIR_IMAGE . $this->request->post['image2'])) {
			$this->data['preview2'] = $this->model_tool_image->resize($this->request->post['image2'], 100, 100);
		}else{
			$this->data['preview2'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}
        
        		if (isset($this->request->post['aboutus_image'])) {
			$aboutus_images = $this->request->post['aboutus_image'];
		} elseif (isset($aboutus_info)) {
			$aboutus_images = $this->model_catalog_aboutus->getAboutusImages($this->request->get['aboutus_id']);
		} else {
			$aboutus_images = array();
		}
		
		$this->data['aboutus_images'] = array();
		
		foreach ($aboutus_images as $aboutus_image) {
			if ($aboutus_image['image'] && file_exists(DIR_IMAGE . $aboutus_image['image'])) {
				$image = $aboutus_image['image'];
			} else {
				$image = 'no_image.jpg';
			}
			
			if ($aboutus_image['image1'] && file_exists(DIR_IMAGE . $aboutus_image['image1'])) {
				$image1 = $aboutus_image['image1'];
			} else {
				$image1 = 'no_image.jpg';
			}
			
			$this->data['aboutus_images'][] = array(
				'image_1'   => $image,
				'image_2'   => $image1,
				'preview_1' => $this->model_tool_image->resize($image, 100, 100),
				'preview_2' => $this->model_tool_image->resize($image1, 100, 100),
                'image_name' => $aboutus_image['image_name'],
			    'image_name_en' => $aboutus_image['image_name_en'],
				'image_desc' => $aboutus_image['image_desc'],
			    'image_desc_en' => $aboutus_image['image_desc_en'],
				'image_sort_order' => $aboutus_image['image_sort_order']
			);
		}

		$this->data['no_image'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
        
        
        $this->load->model('tool/image');
        
		if (isset($this->request->post['ishome'])) {
			$this->data['ishome'] = $this->request->post['ishome'];
		} elseif (isset($aboutus_info)) {
			$this->data['ishome'] = $aboutus_info['ishome'];
		} else {
			$this->data['ishome'] = '';
		}
		
		if (isset($this->request->post['image_home'])) {
			$this->data['image_home'] = $this->request->post['image_home'];
		} elseif (isset($aboutus_info)) {
			$this->data['image_home'] = $aboutus_info['image_home'];
		} else {
			$this->data['image_home'] = '';
		}		

		if (isset($aboutus_info) && $aboutus_info['image_home'] && file_exists(DIR_IMAGE . $aboutus_info['image_home'])) {
			$this->data['preview_home'] = $this->model_tool_image->resize($aboutus_info['image_home'], 100, 100);
		}  elseif(isset($this->request->post['image_home']) && !empty($this->request->post['image_home']) && file_exists(DIR_IMAGE . $this->request->post['image_home'])) {
			$this->data['preview_home'] = $this->model_tool_image->resize($this->request->post['image_home'], 100, 100);
		}else {
			$this->data['preview_home'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}
		
		if (isset($this->request->post['image_og'])) {
            $this->data['image_og'] = $this->request->post['image_og'];
        } elseif (isset($aboutus_info)) {
            $this->data['image_og'] = $aboutus_info['image_og'];
        } else {
            $this->data['image_og'] = '';
        }

				if (isset($aboutus_info) && $aboutus_info['image_og'] && file_exists(DIR_IMAGE . $aboutus_info['image_og'])) {
					$this->data['preview_og'] = $this->model_tool_image->resize($aboutus_info['image_og'], 100, 100);
				} elseif(isset($this->request->post['image_og']) && !empty($this->request->post['image_og']) && file_exists(DIR_IMAGE . $this->request->post['image_og'])) {
					$this->data['preview_og'] = $this->model_tool_image->resize($this->request->post['image_og'], 100, 100);
				}else{
					$this->data['preview_og'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
				}
				
		
		
		if (isset($this->request->post['image_video'])) {
			$this->data['image_video'] = $this->request->post['image_video'];
		} elseif (isset($aboutus_info)) {
			$this->data['image_video'] = $aboutus_info['image_video'];
		} else {
			$this->data['image_video'] = '';
		}
		
		if (isset($aboutus_info) && $aboutus_info['image_video'] && file_exists(DIR_IMAGE . $aboutus_info['image_video'])) {
			$this->data['preview_video'] = $this->model_tool_image->resize($aboutus_info['image_video'], 100, 100);
		} elseif(isset($this->request->post['image_video']) && !empty($this->request->post['image_video']) && file_exists(DIR_IMAGE . $this->request->post['image_video'])) {
			$this->data['preview_video'] = $this->model_tool_image->resize($this->request->post['image_video'], 100, 100);
		}else{
			$this->data['preview_video'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}
        
        if (isset($this->request->post['isftp'])) {
      		$this->data['isftp'] = $this->request->post['isftp'];
    	} else if (isset($aboutus_info)) {
			$this->data['isftp'] = $aboutus_info['isftp'];
		} else {
      		$this->data['isftp'] = 0;
    	}
		
		if (isset($this->request->post['file_mp4_ftp'])) {
      		$this->data['file_mp4_ftp'] = $this->request->post['file_mp4_ftp'];
    	}else if (isset($aboutus_info['filename_mp4'])) {
    		$this->data['file_mp4_ftp'] = $aboutus_info['filename_mp4'];
		} else {
			$this->data['file_mp4_ftp'] = '';
		}
		
		if (isset($this->request->post['file_webm_ftp'])) {
      		$this->data['file_webm_ftp'] = $this->request->post['file_webm_ftp'];
    	}else if (isset($aboutus_info['filename_webm'])) {
    		$this->data['file_webm_ftp'] = $aboutus_info['filename_webm'];
		} else {
			$this->data['file_webm_ftp'] = '';
		}
		
		if (isset($aboutus_info['filename_webm'])) {
    		$this->data['filename_webm'] = $aboutus_info['filename_webm'];
		} else {
			$this->data['filename_webm'] = '';
		}
		
		if (isset($aboutus_info['filename_mp4'])) {
    		$this->data['filename_mp4'] = $aboutus_info['filename_mp4'];
		} else {
			$this->data['filename_mp4'] = '';
		}
        
        if (isset($this->request->post['script'])) {
      		$this->data['script'] = $this->request->post['script'];
    	} elseif (isset($aboutus_info)) {
      		$this->data['script'] = $aboutus_info['script'];
    	} else {
			$this->data['script'] = '';
		}
		
		if (isset($this->request->post['isyoutube'])) {
      		$this->data['isyoutube'] = $this->request->post['isyoutube'];
    	} elseif (isset($aboutus_info)) {
      		$this->data['isyoutube'] = $aboutus_info['isyoutube'];
    	} else {
			$this->data['isyoutube'] = 0;
		}

		        /*if (isset($this->request->post['keyword'])) {
					$this->data['keyword'] = $this->request->post['keyword'];
				} elseif (isset($aboutus_info)) {
					$this->data['keyword'] = $aboutus_info['keyword'];
				} else {
					$this->data['keyword'] = '';
				}*/
		
		if (isset($this->request->post['aboutus_keyword'])) {
			$this->data['aboutus_keyword'] = $this->request->post['aboutus_keyword'];
		} elseif (isset($aboutus_info)) {
			$this->data['aboutus_keyword'] = $this->model_catalog_aboutus->getAboutusKeyword($this->request->get['aboutus_id']);
		} else {
			$this->data['aboutus_keyword'] = array();
		}
		
		if (isset($this->request->post['phone'])) {
			$this->data['phone'] = $this->request->post['phone'];
		} elseif (isset($aboutus_info)) {
			$this->data['phone'] = $aboutus_info['phone'];
		} else {
			$this->data['phone'] = '';
		}
		
		if (isset($this->request->post['fax'])) {
			$this->data['fax'] = $this->request->post['fax'];
		} elseif (isset($aboutus_info)) {
			$this->data['fax'] = $aboutus_info['fax'];
		} else {
			$this->data['fax'] = '';
		}
		
		if (isset($this->request->post['email'])) {
			$this->data['email'] = $this->request->post['email'];
		} elseif (isset($aboutus_info)) {
			$this->data['email'] = $aboutus_info['email'];
		} else {
			$this->data['email'] = '';
		}
		
		if (isset($this->request->post['gioitinh'])) {
			$this->data['gioitinh'] = $this->request->post['gioitinh'];
		} else if (isset($aboutus_info)) {
			$this->data['gioitinh'] = $aboutus_info['gioitinh'];
		} else {
			$this->data['gioitinh'] = 1;
		}

        /*{IMAGE_FORM}*/

		if (isset($this->request->post['sort_order'])) {
			$this->data['sort_order'] = $this->request->post['sort_order'];
		} elseif (isset($aboutus_info)) {
			$this->data['sort_order'] = $aboutus_info['sort_order'];
		} else {
			$this->data['sort_order'] = 0;
		}

		if (isset($this->request->post['status'])) {
			$this->data['status'] = $this->request->post['status'];
		} else if (isset($aboutus_info)) {
			$this->data['status'] = $aboutus_info['status'];
		} else {
			$this->data['status'] = 1;
		}

		//tab data
		if (isset($this->request->post['aboutus_description'])) {
			$this->data['aboutus_description'] = $this->request->post['aboutus_description'];
		} elseif (isset($aboutus_info)) {
			$this->data['aboutus_description'] = $this->model_catalog_aboutus->getAboutusDescriptions($this->request->get['aboutus_id']);
		} else {
			$this->data['aboutus_description'] = array();
		}


		$this->template = 'catalog/aboutus_form.tpl';
		$this->children = array(
		                        'common/header',
		                        'common/footer',
		                        );

		$this->response->setOutput($this->render());
	}

	private function validateForm() {

		if (!$this->user->hasPermission('modify', 'catalog/aboutus')) {
			$this->error['warning'] = $this->data['error_permission'];
		}

		//chi validate ngon ngu mac dinh (khi lay du lieu kiem tra neu title khac rong moi hien thi)
		if((strlen(utf8_decode($this->request->post['aboutus_description'][$this->config->get('config_language_id')]['name'])) < 1) || (strlen(utf8_decode($this->request->post['aboutus_description'][$this->config->get('config_language_id')]['name'])) > 255))
			$this->error['name'][$this->config->get('config_language_id')] = $this->data['error_name'];

		//foreach ($this->request->post['aboutus_description'] as $language_id => $value) {
			/*{VALIDATE_PDF}*/
		//}
		
		foreach ($this->request->post['aboutus_description'] as $language_id => $value) {
			if(!empty($this->request->files['aboutus_description']['name'][$language_id]['pdf'])
				&& ($this->request->files['aboutus_description']['error'][$language_id]['pdf']!=0 
				|| (strtolower(strrchr($this->request->files['aboutus_description']['name'][$language_id]['pdf'], '.'))!='.pdf' 
				//&& strtolower(strrchr($this->request->files['aboutus_description']['name'][$language_id]['pdf'], '.'))!='.doc'
				)))
			{
				
				$this->error['pdf'][$language_id] = $this->data['error_pdf_no_support'];
			}
			
		/*{VALIDATE_PDF}*/
		}
		
		/*if(empty($this->request->post['image']))
			$this->error['image'] = $this->data['error_image'];
		*/
		//$cate = isset($this->request->get['cate'])?(int)$this->request->get['cate']:0;
		/*if(!$cate){
		
		if(empty($this->request->post['image1']))
			$this->error['image1'] = $this->data['error_image'];
		}*/
			
		/*if(!isset($this->request->post['aboutus_image']))
		$this->error['aboutus_image'] = $this->data['error_list_image'];
		*/	
		/*{VALIDATE_ERROR_IMAGE}*/
		
		if(isset($this->request->post['isftp']) && $this->request->post['isftp']>0){
			/*if(empty($this->request->post['file_mp4_ftp'])){
				$this->error['file_mp4_ftp'] = $this->data['error_file_mp4_ftp'];
			}*/
			
			/*if(empty($this->request->post['file_webm_ftp'])){
				$this->error['file_webm_ftp'] = $this->data['error_file_webm_ftp'];
			}*/
		}else{
			if ($this->request->files['video_mp4']['name']) { 	
			
				if (substr(strrchr($this->request->files['video_mp4']['name'], '.'), 1) != 'mp4') {
					$this->error['video_mp4'] = $this->data['error_no_support'];
				}
	
				if($this->request->files['video_mp4']['size']>100000000)
				{
					$this->error['video_mp4'] = $this->data['error_big_file'];
				}
			}/*else if(empty($this->request->post['video_mp4_old'])){
				$this->error['video_mp4'] = 'Vui lòng chọn file!';
			}*/
			
			
			/*if ($this->request->files['video_webm']['name']) { 	
				
				if (substr(strrchr($this->request->files['video_webm']['name'], '.'), 1) != 'webm') {
					$this->error['video_webm'] = $this->data['error_no_support'];
				}
	
				if($this->request->files['video_webm']['size']>100000000)
				{
					$this->error['video_webm'] = $this->data['error_big_file'];
				}
			}*//*else if(empty($this->request->post['video_mp4_old'])){
				$this->error['video_webm'] = 'Vui lòng chọn file!';
			}*/
		
		}

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->data['error_warning'];
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	private function validateDelete() {
		if (!$this->user->hasPermission('modify', 'catalog/aboutus')) {
			$this->error['warning'] = $this->data['error_permission'];
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	private function validateCopy() {
		if (!$this->user->hasPermission('modify', 'catalog/aboutus')) {
			$this->error['warning'] = $this->data['error_permission'];
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	public function autocomplete() {
		$json = array();

		if (isset($this->request->post['filter_name'])) {
			$this->load->model('catalog/aboutus');

			$data = array(
			              'filter_name' => $this->request->post['filter_name'],
			              'start'       => 0,
			              'limit'       => 20
			              );

			$results = $this->model_catalog_aboutus->getAboutuss($data);

			foreach ($results as $result) {
				$json[] = array(
				                'aboutus_id' => $result['aboutus_id'],
				                'name'       => html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'),
				                'model'      => $result['model'],
				                'price'      => $result['price']
				                );
			}
		}

		$this->load->library('json');

		$this->response->setOutput(Json::encode($json));
	}
}
?>
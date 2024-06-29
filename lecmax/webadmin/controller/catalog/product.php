<?php
class ControllerCatalogProduct extends Controller {
	private $error = array();

	public function __construct($registry) {
		$this->registry = $registry;

		$this->load->model('catalog/lang');

		$langs = $this->model_catalog_lang->getLangByModule('product',2);
		foreach($langs as $lang){
			$this->data[$lang['key']] = html_entity_decode($lang['name']);
		}

		if(isset($this->request->get['filter_category']) && $this->request->get['filter_category']>0){
			$this->load->model('catalog/category');
			$this->data['heading_title'] = $this->data['heading_title'] . ' >> ' . $this->model_catalog_category->getTitle($this->request->get['filter_category']);
		}
        
        if(isset($this->request->get['cate']) && $this->request->get['cate']>0){
			$this->load->model('catalog/product');
			$this->data['heading_title'] = $this->data['heading_title'] . ' >> ' . $this->model_catalog_product->getTitle($this->request->get['cate']);
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
		
		$this->load->model('catalog/product');

		$this->getList();
	}

	public function insert() {

		$this->document->setTitle($this->data['heading_title']);

		$this->load->model('catalog/product');

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
				$parts = pathinfo($this->request->files['product_description']['name'][$lang['language_id']]['pdf']);
								
				if(!empty($parts['filename']))
					$filename = convertAlias($parts['filename']) . '_' . $lang['code'] . '_'. $time . '.' . $parts['extension'];
				else
					$filename = '';
				
				if($this->request->files['product_description']['error'][$lang['language_id']]['pdf']==0){
					@move_uploaded_file($this->request->files['product_description']['tmp_name'][$lang['language_id']]['pdf'], DIR_PDF . $filename);
					$data['product_description'][$lang['language_id']]['pdf'] = $filename;
				}else{
					$data['product_description'][$lang['language_id']]['pdf']='';	
				}								
			}
            
            /*{INSERT_CONTROLLER}*/

			$this->model_catalog_product->addProduct($data);

			$this->session->data['success'] = $this->data['text_success'];

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . $this->request->get['filter_name'];
			}

						if (isset($this->request->get['filter_ishome'])) {
				$url .= '&filter_ishome=' . $this->request->get['filter_ishome'];
			}
            
            			if (isset($this->request->get['filter_category'])) {
				$url .= '&filter_category=' . $this->request->get['filter_category'];
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

			$this->redirect($this->url->link('catalog/product', 'token=' . $this->session->data['token'] . $url, '', 'SSL'));
		}

		$this->getForm();
	}

	public function update() {

		$this->document->setTitle($this->data['heading_title']);

		$this->load->model('catalog/product');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$data = $this->request->post;

			$filename_old = $this->model_catalog_product->getVideoById($this->request->get['product_id']) ;
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
				$parts = pathinfo($this->request->files['product_description']['name'][$lang['language_id']]['pdf']);
				
				if(!empty($parts['filename']))
					$filename = convertAlias($parts['filename']) . '_' . $lang['code'] . '_'. $time . '.' . $parts['extension'];
				else
					$filename = '';
				
				if(isset($this->request->post['product_description'][$lang['language_id']]['delete_pdf']) && $this->request->post['product_description'][$lang['language_id']]['delete_pdf']==1)
				{
					$data['product_description'][$lang['language_id']]['pdf'] = '';
					$old_file = $this->request->post['product_description'][$lang['language_id']]['old_file'];
					if(!empty($old_file) && file_exists(DIR_PDF . $old_file))
						unlink(DIR_PDF . $old_file);
				}else{
					if($this->request->files['product_description']['error'][$lang['language_id']]['pdf']==0){
						
						$old_file = $this->request->post['product_description'][$lang['language_id']]['old_file'];
						if(!empty($old_file) && file_exists(DIR_PDF . $old_file))
							unlink(DIR_PDF . $old_file);
						
						@move_uploaded_file($this->request->files['product_description']['tmp_name'][$lang['language_id']]['pdf'], DIR_PDF . $filename);
						$data['product_description'][$lang['language_id']]['pdf'] = $filename;
					}else{
						$data['product_description'][$lang['language_id']]['pdf']=$this->request->post['product_description'][$lang['language_id']]['old_file'];	
					}
				}				
			}
            
            /*{UPDATE_CONTROLLER}*/


			$this->model_catalog_product->editProduct($this->request->get['product_id'], $data);

			$this->session->data['success'] = $this->data['text_success_update'];

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . $this->request->get['filter_name'];
			}

						if (isset($this->request->get['filter_ishome'])) {
				$url .= '&filter_ishome=' . $this->request->get['filter_ishome'];
			}
            
            			if (isset($this->request->get['filter_category'])) {
				$url .= '&filter_category=' . $this->request->get['filter_category'];
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

			$this->redirect($this->url->link('catalog/product', 'token=' . $this->session->data['token'] . $url, '', 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {

		$this->document->setTitle($this->data['heading_title']);

		$this->load->model('catalog/product');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $product_id) {

				$filename_old = $this->model_catalog_product->getVideoById($product_id) ;
				if (!empty($filename_old['filename_webm']) && file_exists(DIR_DOWNLOAD . $filename_old['filename_webm'])) {
					@unlink(DIR_DOWNLOAD . $filename_old['filename_webm']);
				}
				
				if (!empty($filename_old['filename_mp4']) && file_exists(DIR_DOWNLOAD . $filename_old['filename_mp4'])) {
					@unlink(DIR_DOWNLOAD . $filename_old['filename_mp4']);
				}
                
                				$pdfs = $this->model_catalog_product->getPdf($product_id);
				
				foreach($pdfs as $item){
					if(!empty($item['pdf']) && file_exists(DIR_PDF . $item['pdf']))
							unlink(DIR_PDF . $item['pdf']);
				}

				/*{DELETE_CONTROLLER}*/

				$this->model_catalog_product->deleteProduct($product_id);
			}

			$this->session->data['success'] = $this->data['text_success_delete'];

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . $this->request->get['filter_name'];
			}

						if (isset($this->request->get['filter_ishome'])) {
				$url .= '&filter_ishome=' . $this->request->get['filter_ishome'];
			}
            
            			if (isset($this->request->get['filter_category'])) {
				$url .= '&filter_category=' . $this->request->get['filter_category'];
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

			$this->redirect($this->url->link('catalog/product', 'token=' . $this->session->data['token'] . $url, '', 'SSL'));
		}

		$this->getList();
	}

	public function copy() {

		$this->document->setTitle($this->data['heading_title']);

		$this->load->model('catalog/product');

		if (isset($this->request->post['selected']) && $this->validateCopy()) {
			foreach ($this->request->post['selected'] as $product_id) {
				$this->model_catalog_product->copyProduct($product_id);
			}

			$this->session->data['success'] = $this->data['text_success'];

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . $this->request->get['filter_name'];
			}

						if (isset($this->request->get['filter_ishome'])) {
				$url .= '&filter_ishome=' . $this->request->get['filter_ishome'];
			}
            
            			if (isset($this->request->get['filter_category'])) {
				$url .= '&filter_category=' . $this->request->get['filter_category'];
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

			$this->redirect($this->url->link('catalog/product', 'token=' . $this->session->data['token'] . $url, '', 'SSL'));
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
        
        		if (isset($this->request->get['filter_category'])) {
			$filter_category = $this->request->get['filter_category'];
		} else {
			$filter_category = null;
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
            
            			if (isset($this->request->get['filter_category'])) {
				$url .= '&filter_category=' . $this->request->get['filter_category'];
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
		                                     'href'      => $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . $url, '', 'SSL'),
		                                     'separator' => ' :: '
		                                     );

		$url_filter = '';
		if (isset($this->request->get['filter_category'])) {
			$url_filter .= '&filter_category=' . $this->request->get['filter_category'];
		}

		$this->data['insert'] = $this->url->link('catalog/product/insert', 'token=' . $this->session->data['token'] . $url, '', 'SSL');
		$this->data['copy'] = $this->url->link('catalog/product/copy', 'token=' . $this->session->data['token'] . $url, '', 'SSL');
		$this->data['delete'] = $this->url->link('catalog/product/delete', 'token=' . $this->session->data['token'] . $url, '', 'SSL');

		$this->data['filter'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . $url_filter, '', 'SSL');
		$this->data['back'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token'], '', 'SSL');
		$this->data['products'] = array();

		$data = array(
		              'filter_name'	  => $filter_name,
		              'filter_ishome'   => $filter_ishome,

'filter_category'   => $filter_category,

'cate'   => $cate,

/*{FILTER_PARAM}*/
		              'filter_status'   => $filter_status,
		              'sort'            => $sort,
		              'order'           => $order,
		              'start'           => ($page - 1) * $this->config->get('config_admin_limit'),
		              'limit'           => $this->config->get('config_admin_limit')
		              );
		$this->load->model('tool/image');
		$product_total = $this->model_catalog_product->getTotalProducts($data);

		$results = $this->model_catalog_product->getProducts($data);

		$this->load->model('catalog/category');
		$this->data['categories'] = $this->model_catalog_category->getCategories(93);
		if(isset($this->request->get['filter_category']))
			$this->data['filter_category'] = $this->request->get['filter_category'];
		else
			$this->data['filter_category'] = 0;
            
           
        /*{INCLUDE_CATEGORY}*/

		foreach ($results as $result) {
			$action = array();
						/*if(1==2  || $result["product_id"]==1){
				$action[] = array(
                	'cls'  =>'btn_list',
					'text' => $this->data['text_list'],
					'href' => $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . '&cate=' . $result['product_id'], '', 'SSL')
				);
			}*/
			$action[] = array(
			                  'cls'  =>'modify',
			                  'text' => $this->data['text_edit'],
			                  'href' => $this->url->link('catalog/product/update', 'token=' . $this->session->data['token'] . '&product_id=' . $result['product_id'] . $url, '', 'SSL')
			                  );
			            if ($result['image'] && file_exists(DIR_IMAGE . $result['image'])) {
                $image = $this->model_tool_image->resize($result['image'], 40, 40);
            } else {
                $image = $this->model_tool_image->resize('no_image.jpg', 40, 40);
            }
			
			if(isset($result['cate']) && $result['cate']){
				$check_editor = true;
			}else{
				$check_editor = false;
			}
			$this->data['products'][] = array(
			                                                  'product_id' => $result['product_id'],
			                                                  'sort_order'       => $result['sort_order'],
			                                                  'name'       => $result['name'],
															  
															  'status_en' =>$this->model_catalog_product->getStatus('product',$result['product_id'],1,$check_editor),
															  
			                                                  'image'      => $image,
    'ishome'     => ($result['ishome'] ? '<img src="view/image/success.png" title="'.$this->data['text_enabled'].'" />' : '<img src="view/image/delete.png" title="'.$this->data['text_disabled'].'" />'),
    'category'       => $this->model_catalog_category->getPath($result['category_id']),	

/*{IMAGE_LIST_ARRAY}*/	
			                                                  'status_id'		=> $result['status'],
			                                                  'status'     => ($result['status'] ? '<img src="view/image/success.png" title="'.$this->data['text_enabled'].'" />' : '<img src="view/image/delete.png" title="'.$this->data['text_disabled'].'" />'),
			                                                  'selected'   => isset($this->request->post['selected']) && in_array($result['product_id'], $this->request->post['selected']),
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
            
            			if (isset($this->request->get['filter_category'])) {
				$url .= '&filter_category=' . $this->request->get['filter_category'];
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

		$this->data['sort_name'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . '&sort=pd.name' . $url, '', 'SSL');
		$this->data['sort_status'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . '&sort=p.status' . $url, '', 'SSL');
		$this->data['sort_order'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . '&sort=p.sort_order' . $url, '', 'SSL');

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}

					if (isset($this->request->get['filter_ishome'])) {
				$url .= '&filter_ishome=' . $this->request->get['filter_ishome'];
			}
            
            			if (isset($this->request->get['filter_category'])) {
				$url .= '&filter_category=' . $this->request->get['filter_category'];
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
		$pagination->total = $product_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->data['text_pagination'];
		$pagination->url = $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . $url . '&page={page}', '', 'SSL');

		$this->data['pagination'] = $pagination->render();

		$this->data['results'] = sprintf($this->language->get('text_pagination'), ($product_total) ? (($page - 1) * $this->config->get('config_admin_limit')) + 1 : 0, ((($page - 1) * $this->config->get('config_admin_limit')) > ($product_total - $this->config->get('config_admin_limit'))) ? $product_total : ((($page - 1) * $this->config->get('config_admin_limit')) + $this->config->get('config_admin_limit')), $product_total, ceil($product_total / $this->config->get('config_admin_limit')));

		$this->data['filter_name'] = $filter_name;

		$this->data['filter_ishome'] = $filter_ishome;

$this->data['filter_category'] = $filter_category;

$this->data['cate'] = $cate;

/*{FILTER_DATA}*/

		$this->data['filter_status'] = $filter_status;

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'catalog/product_list.tpl';
		$this->children = array(
		                        'common/header',
		                        'common/footer',
		                        );

		$this->response->setOutput($this->render());
	}

	private function getForm() {
				$cate = isset($this->request->get['cate'])?(int)$this->request->get['cate']:0;
		$this->data['cate'] = $cate;
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
        
                if (isset($this->error['image_home'])) {
            $this->data['error_image_home'] = $this->error['image_home'];
        } else {
            $this->data['error_image_home'] = '';
        }
        
                if (isset($this->error['product_image'])) {
			$this->data['error_images'] = $this->error['product_image'];
		} else {
			$this->data['error_images'] = '';
		}
		
		if (isset($this->error['product_imagepro'])) {
			$this->data['error_images_imagepro'] = $this->error['product_imagepro'];
		} else {
			$this->data['error_images_imagepro'] = '';
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
        
        		if (isset($this->error['pdf'])) {
			$this->data['error_pdf'] = $this->error['pdf'];
		} else {
			$this->data['error_pdf'] = array();
		}
        
        		if (isset($this->error['category_id'])) {
			$this->data['error_category_id'] = $this->error['category_id'];
		} else {
			$this->data['error_category_id'] = '';
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
            
            			if (isset($this->request->get['filter_category'])) {
				$url .= '&filter_category=' . $this->request->get['filter_category'];
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
		                                     'href'      => $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . $url, '', 'SSL'),
		                                     'separator' => ' :: '
		                                     );

		//====================================================Assigne Data=======================================================
		if (!isset($this->request->get['product_id'])) {
			$this->data['action'] = $this->url->link('catalog/product/insert', 'token=' . $this->session->data['token'] . $url, '', 'SSL');
		} else {
			$this->data['action'] = $this->url->link('catalog/product/update', 'token=' . $this->session->data['token'] . '&product_id=' . $this->request->get['product_id'] . $url, '', 'SSL');
		}

		$this->data['cancel'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . $url, '', 'SSL');

		$this->data['token'] = $this->session->data['token'];

		//cate danh sach con
		 if(isset($this->request->get['cate']) && $this->request->get['cate']>0){
		 	$sublist_cate = $this->model_catalog_product->getCateById($this->request->get['cate']);
		 	$this->data['sublist_cate'] = $sublist_cate;
		 }else{
		 	$this->data['sublist_cate'] = 0;
		 }


		if (isset($this->request->get['product_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$product_info = $this->model_catalog_product->getProduct($this->request->get['product_id']);
		}

		$this->load->model('localisation/language');

		$this->data['languages'] = $this->model_localisation_language->getLanguages();
		$this->load->model('tool/image');
		        if (isset($this->request->post['image'])) {
            $this->data['image'] = $this->request->post['image'];
        } elseif (isset($product_info)) {
            $this->data['image'] = $product_info['image'];
        } else {
            $this->data['image'] = '';
        }

		if (isset($product_info) && $product_info['image'] && file_exists(DIR_IMAGE . $product_info['image'])) {
			$this->data['preview'] = $this->model_tool_image->resize($product_info['image'], 100, 100);
		} elseif(isset($this->request->post['image']) && !empty($this->request->post['image']) && file_exists(DIR_IMAGE . $this->request->post['image'])) {
			$this->data['preview'] = $this->model_tool_image->resize($this->request->post['image'], 100, 100);
		}else{
			$this->data['preview'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}
        
                if (isset($this->request->post['image1'])) {
            $this->data['image1'] = $this->request->post['image1'];
        } elseif (isset($product_info)) {
            $this->data['image1'] = $product_info['image1'];
        } else {
            $this->data['image1'] = '';
        }

		if (isset($product_info) && $product_info['image1'] && file_exists(DIR_IMAGE . $product_info['image1'])) {
			$this->data['preview1'] = $this->model_tool_image->resize($product_info['image1'], 100, 100);
		} elseif(isset($this->request->post['image1']) && !empty($this->request->post['image1']) && file_exists(DIR_IMAGE . $this->request->post['image1'])) {
			$this->data['preview1'] = $this->model_tool_image->resize($this->request->post['image1'], 100, 100);
		}else{
			$this->data['preview1'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}
		
		if (isset($this->request->post['image2'])) {
            $this->data['image2'] = $this->request->post['image2'];
        } elseif (isset($product_info)) {
            $this->data['image2'] = $product_info['image2'];
        } else {
            $this->data['image2'] = '';
        }

		if (isset($product_info) && $product_info['image2'] && file_exists(DIR_IMAGE . $product_info['image2'])) {
			$this->data['preview2'] = $this->model_tool_image->resize($product_info['image2'], 100, 100);
		} elseif(isset($this->request->post['image2']) && !empty($this->request->post['image2']) && file_exists(DIR_IMAGE . $this->request->post['image2'])) {
			$this->data['preview2'] = $this->model_tool_image->resize($this->request->post['image2'], 100, 100);
		}else{
			$this->data['preview2'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}
        
        		if (isset($this->request->post['ishome'])) {
			$this->data['ishome'] = $this->request->post['ishome'];
		} elseif (isset($product_info)) {
			$this->data['ishome'] = $product_info['ishome'];
		} else {
			$this->data['ishome'] = '';
		}
		
		if (isset($this->request->post['image_home'])) {
			$this->data['image_home'] = $this->request->post['image_home'];
		} elseif (isset($product_info)) {
			$this->data['image_home'] = $product_info['image_home'];
		} else {
			$this->data['image_home'] = '';
		}		

		if (isset($product_info) && $product_info['image_home'] && file_exists(DIR_IMAGE . $product_info['image_home'])) {
			$this->data['preview_home'] = $this->model_tool_image->resize($product_info['image_home'], 100, 100);
		}  elseif(isset($this->request->post['image_home']) && !empty($this->request->post['image_home']) && file_exists(DIR_IMAGE . $this->request->post['image_home'])) {
			$this->data['preview_home'] = $this->model_tool_image->resize($this->request->post['image_home'], 100, 100);
		}else {
			$this->data['preview_home'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}
        
        		if (isset($this->request->post['product_image'])) {
			$product_images = $this->request->post['product_image'];
		} elseif (isset($product_info)) {
			$product_images = $this->model_catalog_product->getProductImages($this->request->get['product_id']);
		} else {
			$product_images = array();
		}
		
		$this->data['product_images'] = array();
		
		foreach ($product_images as $product_image) {
			if ($product_image['image'] && file_exists(DIR_IMAGE . $product_image['image'])) {
				$image = $product_image['image'];
			} else {
				$image = 'no_image.jpg';
			}
			
			if ($product_image['image1'] && file_exists(DIR_IMAGE . $product_image['image1'])) {
				$image1 = $product_image['image1'];
			} else {
				$image1 = 'no_image.jpg';
			}
			
			$this->data['product_images'][] = array(
				'image_1'   => $image,
				'image_2'   => $image1,
				'preview_1' => $this->model_tool_image->resize($image, 100, 100),
				'preview_2' => $this->model_tool_image->resize($image1, 100, 100),
                'image_name' => $product_image['image_name'],
			    'image_name_en' => $product_image['image_name_en'],
				'image_sort_order' => $product_image['image_sort_order']
			);
		}
		
		//imagepro
		if (isset($this->request->post['product_imagepro'])) {
			$product_imagepros = $this->request->post['product_imagepro'];
		} elseif (isset($product_info)) {
			$product_imagepros = $this->model_catalog_product->getProductImagepros($this->request->get['product_id']);
		} else {
			$product_imagepros = array();
		}
		
		$this->data['product_imagepros'] = array();
		
		foreach ($product_imagepros as $product_imagepro) {
			if ($product_imagepro['image'] && file_exists(DIR_IMAGE . $product_imagepro['image'])) {
				$image = $product_imagepro['image'];
			} else {
				$image = 'no_image.jpg';
			}
			
			if ($product_imagepro['image1'] && file_exists(DIR_IMAGE . $product_imagepro['image1'])) {
				$image1 = $product_imagepro['image1'];
			} else {
				$image1 = 'no_image.jpg';
			}
			
			$this->data['product_imagepros'][] = array(
				'image_1'   => $image,
				'image_2'   => $image1,
				'preview_1' => $this->model_tool_image->resize($image, 100, 100),
				'preview_2' => $this->model_tool_image->resize($image1, 100, 100),
                'image_name' => $product_imagepro['image_name'],
			    'image_name_en' => $product_imagepro['image_name_en'],
				'image_sort_order' => $product_imagepro['image_sort_order']
			);
		}
		

		$this->data['no_image'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
        
        
        $this->load->model('tool/image');
        if (isset($this->request->post['image_og'])) {
            $this->data['image_og'] = $this->request->post['image_og'];
        } elseif (isset($product_info)) {
            $this->data['image_og'] = $product_info['image_og'];
        } else {
            $this->data['image_og'] = '';
        }

				if (isset($product_info) && $product_info['image_og'] && file_exists(DIR_IMAGE . $product_info['image_og'])) {
					$this->data['preview_og'] = $this->model_tool_image->resize($product_info['image_og'], 100, 100);
				} elseif(isset($this->request->post['image_og']) && !empty($this->request->post['image_og']) && file_exists(DIR_IMAGE . $this->request->post['image_og'])) {
					$this->data['preview_og'] = $this->model_tool_image->resize($this->request->post['image_og'], 100, 100);
				}else{
					$this->data['preview_og'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
				}

		        /*if (isset($this->request->post['keyword'])) {
					$this->data['keyword'] = $this->request->post['keyword'];
				} elseif (isset($product_info)) {
					$this->data['keyword'] = $product_info['keyword'];
				} else {
					$this->data['keyword'] = '';
				}*/
                
        if (isset($this->request->post['product_keyword'])) {
			$this->data['product_keyword'] = $this->request->post['product_keyword'];
		} elseif (isset($product_info)) {
			$this->data['product_keyword'] = $this->model_catalog_product->getProductKeyword($this->request->get['product_id']);
		} else {
			$this->data['product_keyword'] = array();
		}

        		if (isset($this->request->post['image_video'])) {
			$this->data['image_video'] = $this->request->post['image_video'];
		} elseif (isset($product_info)) {
			$this->data['image_video'] = $product_info['image_video'];
		} else {
			$this->data['image_video'] = '';
		}
        
        $this->load->model('tool/image');
		
		if (isset($product_info) && $product_info['image_video'] && file_exists(DIR_IMAGE . $product_info['image_video'])) {
			$this->data['preview_video'] = $this->model_tool_image->resize($product_info['image_video'], 100, 100);
		} elseif(isset($this->request->post['image_video']) && !empty($this->request->post['image_video']) && file_exists(DIR_IMAGE . $this->request->post['image_video'])) {
			$this->data['preview_video'] = $this->model_tool_image->resize($this->request->post['image_video'], 100, 100);
		}else{
			$this->data['preview_video'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}
        
        if (isset($this->request->post['isftp'])) {
      		$this->data['isftp'] = $this->request->post['isftp'];
    	} else if (isset($product_info)) {
			$this->data['isftp'] = $product_info['isftp'];
		} else {
      		$this->data['isftp'] = 0;
    	}
		
		if (isset($this->request->post['file_mp4_ftp'])) {
      		$this->data['file_mp4_ftp'] = $this->request->post['file_mp4_ftp'];
    	}else if (isset($product_info['filename_mp4'])) {
    		$this->data['file_mp4_ftp'] = $product_info['filename_mp4'];
		} else {
			$this->data['file_mp4_ftp'] = '';
		}
		
		if (isset($this->request->post['file_webm_ftp'])) {
      		$this->data['file_webm_ftp'] = $this->request->post['file_webm_ftp'];
    	}else if (isset($product_info['filename_webm'])) {
    		$this->data['file_webm_ftp'] = $product_info['filename_webm'];
		} else {
			$this->data['file_webm_ftp'] = '';
		}
		
		if (isset($product_info['filename_webm'])) {
    		$this->data['filename_webm'] = $product_info['filename_webm'];
		} else {
			$this->data['filename_webm'] = '';
		}
		
		if (isset($product_info['filename_mp4'])) {
    		$this->data['filename_mp4'] = $product_info['filename_mp4'];
		} else {
			$this->data['filename_mp4'] = '';
		}
        
        if (isset($this->request->post['script'])) {
      		$this->data['script'] = $this->request->post['script'];
    	} elseif (isset($product_info)) {
      		$this->data['script'] = $product_info['script'];
    	} else {
			$this->data['script'] = '';
		}
		
		if (isset($this->request->post['isyoutube'])) {
      		$this->data['isyoutube'] = $this->request->post['isyoutube'];
    	} elseif (isset($product_info)) {
      		$this->data['isyoutube'] = $product_info['isyoutube'];
    	} else {
			$this->data['isyoutube'] = 0;
		}
        
        $this->load->model('catalog/category');			
		$this->data['categories'] = $this->model_catalog_category->getCategories(93);
		
		if (isset($this->request->post['category_id'])) {
			$this->data['category_id'] = $this->request->post['category_id'];
		} elseif (isset($product_info)) {
			$this->data['category_id'] = $product_info['category_id'];
		} else {
			$this->data['category_id'] = 0;
		}
		
		// Categories
		$this->load->model('catalog/project');

		if (isset($this->request->post['project_category'])) {
			$categories = $this->request->post['project_category'];
		} elseif (isset($product_info)) {
			$categories = !empty($product_info['project_category'])?unserialize($product_info['project_category']):array();
			//$categories = $this->model_catalog_project->getProjects(array('sort' => 'p.sort_order', 'order' => 'ASC'));
		} else {
			$categories = array();
		}

		$this->data['project_categories'] = array();

		foreach ($categories as $project_id) {
			$project_info = $this->model_catalog_project->getProject($project_id);

			if ($project_info) {
				$cate_name = $project_info['cate']?$this->model_catalog_project->getTitle($project_info['cate']) . ' >> ':'';
				
				$this->data['project_categories'][] = array(
					'project_id' => $project_info['project_id'],
					'name' => $cate_name . $project_info['name']
				);
			}
		}
        
        //print_r($this->data['project_categories']);
		
		// Products
		//$this->load->model('catalog/product');
		
		

		if (isset($this->request->post['product_category'])) {
			$categories = $this->request->post['product_category'];
		} elseif (isset($product_info)) {
			$categories = !empty($product_info['product_category'])?unserialize($product_info['product_category']):array();
			//$categories = $this->model_catalog_product->getProjects(array('sort' => 'p.sort_order', 'order' => 'ASC'));
		} else {
			$categories = array();
		}

		$this->data['product_categories'] = array();

		foreach ($categories as $product_temp_id) {
			$product_temp_info = $this->model_catalog_product->getProduct($product_temp_id);

			if ($product_temp_info) {
				//$cate_name = $product_info['cate']?$this->model_catalog_product->getTitle($product_info['cate']) . ' >> ':'';
				
				$this->data['product_categories'][] = array(
					'product_id' => $product_temp_info['product_id'],
					'name' => $product_temp_info['name']
				);
			}
		}
        
        /*{IMAGE_FORM}*/

		if (isset($this->request->post['sort_order'])) {
			$this->data['sort_order'] = $this->request->post['sort_order'];
		} elseif (isset($product_info)) {
			$this->data['sort_order'] = $product_info['sort_order'];
		} else {
			$this->data['sort_order'] = 0;
		}

		if (isset($this->request->post['status'])) {
			$this->data['status'] = $this->request->post['status'];
		} else if (isset($product_info)) {
			$this->data['status'] = $product_info['status'];
		} else {
			$this->data['status'] = 1;
		}

		//tab data
		if (isset($this->request->post['product_description'])) {
			$this->data['product_description'] = $this->request->post['product_description'];
		} elseif (isset($product_info)) {
			$this->data['product_description'] = $this->model_catalog_product->getProductDescriptions($this->request->get['product_id']);
		} else {
			$this->data['product_description'] = array();
		}


		$this->template = 'catalog/product_form.tpl';
		$this->children = array(
		                        'common/header',
		                        'common/footer',
		                        );

		$this->response->setOutput($this->render());
	}

	private function validateForm() {

		if (!$this->user->hasPermission('modify', 'catalog/product')) {
			$this->error['warning'] = $this->data['error_permission'];
		}

		//chi validate ngon ngu mac dinh (khi lay du lieu kiem tra neu title khac rong moi hien thi)
		if((strlen(utf8_decode($this->request->post['product_description'][$this->config->get('config_language_id')]['name'])) < 1) || (strlen(utf8_decode($this->request->post['product_description'][$this->config->get('config_language_id')]['name'])) > 255))
			$this->error['name'][$this->config->get('config_language_id')] = $this->data['error_name'];

		foreach ($this->request->post['product_description'] as $language_id => $value) {
						if(!empty($this->request->files['product_description']['name'][$language_id]['pdf'])
				&& ($this->request->files['product_description']['error'][$language_id]['pdf']!=0 
				|| (strtolower(strrchr($this->request->files['product_description']['name'][$language_id]['pdf'], '.'))!='.pdf' 
				//&& strtolower(strrchr($this->request->files['product_description']['name'][$language_id]['pdf'], '.'))!='.doc'
				)))
			{
				
				$this->error['pdf'][$language_id] = $this->data['error_pdf_no_support'];
			}
			
		/*{VALIDATE_PDF}*/
		}

		if(empty($this->request->post['image']))
			$this->error['image'] = $this->data['error_image'];
			
		/*if(empty($this->request->post['image1']))
            $this->error['image1'] = $this->data['error_image1'];
        
		if(!isset($this->request->post['product_imagepro']))
		$this->error['product_imagepro'] = $this->data['error_list_image'];
		
		*/    
	if(isset($this->request->post['ishome']) && $this->request->post['ishome']==1)
if(empty($this->request->post['image_home']))
			$this->error['image_home'] = $this->data['error_image_home'];
			
		if(!isset($this->request->post['product_image']))
		$this->error['product_image'] = $this->data['error_list_image'];
			
		if(isset($this->request->post['isftp']) && $this->request->post['isftp']>0){
			/*if(empty($this->request->post['file_mp4_ftp'])){
				$this->error['file_mp4_ftp'] = $this->data['error_file_mp4_ftp'];
			}
			*/
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
        
        			if($this->request->post['category_id']==0)
				$this->error['category_id'] = $this->data['error_category'];
			
		/*{VALIDATE_ERROR_IMAGE}*/

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
		if (!$this->user->hasPermission('modify', 'catalog/product')) {
			$this->error['warning'] = $this->data['error_permission'];
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	private function validateCopy() {
		if (!$this->user->hasPermission('modify', 'catalog/product')) {
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

		/*if (isset($this->request->post['filter_name'])) {
			$this->load->model('catalog/product');

			$data = array(
			              'filter_name' => $this->request->post['filter_name'],
			              'start'       => 0,
			              'limit'       => 20
			              );

			$results = $this->model_catalog_product->getProducts($data);

			foreach ($results as $result) {
				$json[] = array(
				                'product_id' => $result['product_id'],
				                'name'       => html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'),
				                'model'      => $result['model'],
				                'price'      => $result['price']
				                );
			}
		}*/
		
		if (isset($this->request->get['filter_name'])) {
			$this->load->model('catalog/product');
			
			$array_cate = isset($this->request->get['array_phukien'])?($this->request->get['array_phukien']):'';
			$data = array(
			              'filter_name' => $this->request->get['filter_name'],
						  'array_cate'       => $array_cate,
			              'start'       => 0,
			              'limit'       => 20
			              );

			$results = $this->model_catalog_product->getProductByPK($data);

			foreach ($results as $result) {
				$cate_name = $result['cate']?$this->model_catalog_product->getTitle($result['cate']) . ' >> ':'';
				$json[] = array(
				                'product_id' => $result['product_id'],
				                'name'       => $cate_name . html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'),
				                //'model'      => $result['model'],
				                //'price'      => $result['price']
				                );
			}
		}

		$this->load->library('json');

		$this->response->setOutput(Json::encode($json));
	}
}
?>
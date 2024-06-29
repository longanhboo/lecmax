<?php
class ControllerCatalogNews extends Controller {
	private $error = array();

	public function __construct($registry) {
		$this->registry = $registry;

		$this->load->model('catalog/lang');

		$langs = $this->model_catalog_lang->getLangByModule('news',2);
		foreach($langs as $lang){
			$this->data[$lang['key']] = html_entity_decode($lang['name']);
		}

		if(isset($this->request->get['filter_category']) && $this->request->get['filter_category']>0){
			$this->load->model('catalog/category');
			$this->data['heading_title'] = $this->data['heading_title'] . ' >> ' . $this->model_catalog_category->getTitle($this->request->get['filter_category']);
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
		
		
		$this->load->model('catalog/news');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateFormList()) {
			$data = $this->request->post;
			if(isset($data['image'])){
				$this->db->query("UPDATE " . DB_PREFIX . "setting 
					SET `value` = '" . $this->db->escape($data['image']) . "'
					WHERE `key` = 'config_news_bg'");
				
				$this->load->model('tool/image');
				if (file_exists(DIR_IMAGE . $data['image']) && is_file(DIR_IMAGE . $data['image'])) {
					list($widthImg, $heightImg) = getimagesize(DIR_IMAGE.$data['image']);
					$this->model_tool_image->resize_mobile($data['image'], $widthImg*2/3, $heightImg*2/3);
				}
			}
			$this->session->data['success'] = 'Lưu thành công!';
    	}
		$this->getList();
	}

	public function insert() {

		$this->document->setTitle($this->data['heading_title']);

		$this->load->model('catalog/news');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$data = $this->request->post;
			
			$time = time();
			
			$this->load->model('localisation/language');		
			$languages = $this->model_localisation_language->getLanguages();
			
			foreach($languages as $lang){
				$parts = pathinfo($this->request->files['news_description']['name'][$lang['language_id']]['pdf']);
								
				if(!empty($parts['filename']))
					$filename = convertAlias($parts['filename']) . '_' . $lang['code'] . '_'. $time . '.' . $parts['extension'];
				else
					$filename = '';
				
				if($this->request->files['news_description']['error'][$lang['language_id']]['pdf']==0){
					@move_uploaded_file($this->request->files['news_description']['tmp_name'][$lang['language_id']]['pdf'], DIR_PDF . $filename);
					$data['news_description'][$lang['language_id']]['pdf'] = $filename;
				}else{
					$data['news_description'][$lang['language_id']]['pdf']='';	
				}								
			}
			/*{INSERT_CONTROLLER}*/

			$this->model_catalog_news->addNews($data);

			$this->session->data['success'] = $this->data['text_success'];

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . $this->request->get['filter_name'];
			}

						if (isset($this->request->get['filter_ishome'])) {
				$url .= '&filter_ishome=' . $this->request->get['filter_ishome'];
			}
			
			if (isset($this->request->get['filter_isamp'])) {
				$url .= '&filter_isamp=' . $this->request->get['filter_isamp'];
			}
			
			if (isset($this->request->get['filter_isnew'])) {
				$url .= '&filter_isnew=' . $this->request->get['filter_isnew'];
			}
            
            			if (isset($this->request->get['filter_category'])) {
				$url .= '&filter_category=' . $this->request->get['filter_category'];
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
			
			//$this->buildcachenews($data);

			$this->redirect($this->url->link('catalog/news', 'token=' . $this->session->data['token'] . $url, '', 'SSL'));
			
			exit;
		}

		$this->getForm();
	}

	public function update() {

		$this->document->setTitle($this->data['heading_title']);

		$this->load->model('catalog/news');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$data = $this->request->post;
			
			$time = time();
			
			$this->load->model('localisation/language');		
			$languages = $this->model_localisation_language->getLanguages();
			
			foreach($languages as $lang){
				$parts = pathinfo($this->request->files['news_description']['name'][$lang['language_id']]['pdf']);
				
				if(!empty($parts['filename']))
					$filename = convertAlias($parts['filename']) . '_' . $lang['code'] . '_'. $time . '.' . $parts['extension'];
				else
					$filename = '';
				
				if(isset($this->request->post['news_description'][$lang['language_id']]['delete_pdf']) && $this->request->post['news_description'][$lang['language_id']]['delete_pdf']==1)
				{
					$data['news_description'][$lang['language_id']]['pdf'] = '';
					$old_file = $this->request->post['news_description'][$lang['language_id']]['old_file'];
					if(!empty($old_file) && file_exists(DIR_PDF . $old_file))
						unlink(DIR_PDF . $old_file);
				}else{
					if($this->request->files['news_description']['error'][$lang['language_id']]['pdf']==0){
						
						$old_file = $this->request->post['news_description'][$lang['language_id']]['old_file'];
						if(!empty($old_file) && file_exists(DIR_PDF . $old_file))
							unlink(DIR_PDF . $old_file);
						
						@move_uploaded_file($this->request->files['news_description']['tmp_name'][$lang['language_id']]['pdf'], DIR_PDF . $filename);
						$data['news_description'][$lang['language_id']]['pdf'] = $filename;
					}else{
						$data['news_description'][$lang['language_id']]['pdf']=$this->request->post['news_description'][$lang['language_id']]['old_file'];	
					}
				}				
			}
			/*{UPDATE_CONTROLLER}*/

			$this->model_catalog_news->editNews($this->request->get['news_id'], $data);

			$this->session->data['success'] = $this->data['text_success_update'];

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . $this->request->get['filter_name'];
			}

						if (isset($this->request->get['filter_ishome'])) {
				$url .= '&filter_ishome=' . $this->request->get['filter_ishome'];
			}
			
			if (isset($this->request->get['filter_isamp'])) {
				$url .= '&filter_isamp=' . $this->request->get['filter_isamp'];
			}
			
			if (isset($this->request->get['filter_isnew'])) {
				$url .= '&filter_isnew=' . $this->request->get['filter_isnew'];
			}
            
            			if (isset($this->request->get['filter_category'])) {
				$url .= '&filter_category=' . $this->request->get['filter_category'];
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
			
			//$this->buildcachenews($data);

			$this->redirect($this->url->link('catalog/news', 'token=' . $this->session->data['token'] . $url, '', 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {

		$this->document->setTitle($this->data['heading_title']);

		$this->load->model('catalog/news');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $news_id) {
				
				$pdfs = $this->model_catalog_news->getPdf($news_id);
				//print_r($pdfs);
				foreach($pdfs as $item){
					if(!empty($item['pdf']) && file_exists(DIR_PDF . $item['pdf']))
							unlink(DIR_PDF . $item['pdf']);
				
				}
				/*{DELETE_CONTROLLER}*/

				$this->model_catalog_news->deleteNews($news_id);
				
				if(isset($pdfs[0])){
					$data['category_id'] = $pdfs[0]['category_id'];//$this->request->get['filter_category'];
            		//$this->buildcachenews($data);
				}
			}
			
			$this->session->data['success'] = $this->data['text_success_delete'];

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . $this->request->get['filter_name'];
			}

						if (isset($this->request->get['filter_ishome'])) {
				$url .= '&filter_ishome=' . $this->request->get['filter_ishome'];
			}
			
			if (isset($this->request->get['filter_isamp'])) {
				$url .= '&filter_isamp=' . $this->request->get['filter_isamp'];
			}
			
			if (isset($this->request->get['filter_isnew'])) {
				$url .= '&filter_isnew=' . $this->request->get['filter_isnew'];
			}
            
            			if (isset($this->request->get['filter_category'])) {
				$url .= '&filter_category=' . $this->request->get['filter_category'];
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
			
			

			$this->redirect($this->url->link('catalog/news', 'token=' . $this->session->data['token'] . $url, '', 'SSL'));
		}

		$this->getList();
	}

	public function copy() {

		$this->document->setTitle($this->data['heading_title']);

		$this->load->model('catalog/news');

		if (isset($this->request->post['selected']) && $this->validateCopy()) {
			foreach ($this->request->post['selected'] as $news_id) {
				$this->model_catalog_news->copyNews($news_id);
			}

			$this->session->data['success'] = $this->data['text_success'];

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . $this->request->get['filter_name'];
			}

						if (isset($this->request->get['filter_ishome'])) {
				$url .= '&filter_ishome=' . $this->request->get['filter_ishome'];
			}
			
			if (isset($this->request->get['filter_isamp'])) {
				$url .= '&filter_isamp=' . $this->request->get['filter_isamp'];
			}
			
			if (isset($this->request->get['filter_isnew'])) {
				$url .= '&filter_isnew=' . $this->request->get['filter_isnew'];
			}
            
            			if (isset($this->request->get['filter_category'])) {
				$url .= '&filter_category=' . $this->request->get['filter_category'];
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

			$this->redirect($this->url->link('catalog/news', 'token=' . $this->session->data['token'] . $url, '', 'SSL'));
		}

		$this->getList();
	}

	private function getList() {
		
		$filter_category = isset($this->request->get['filter_category'])?(int)$this->request->get['filter_category']:0;
		$this->data['filter_category'] = $filter_category;
		
		
		if (isset($this->error['image'])) {
            $this->data['error_image'] = $this->error['image'];
        } else {
            $this->data['error_image'] = '';
        }
        
        $this->load->model('tool/image');
		if (isset($this->request->post['image'])) {
            $this->data['image'] = $this->request->post['image'];
        } else {
            $this->data['image'] = $this->config->get('config_news_bg');
        }

		if(isset($this->request->post['image']) && !empty($this->request->post['image']) && file_exists(DIR_IMAGE . $this->request->post['image'])) {
			$this->data['preview'] =  $this->model_tool_image->resize($this->request->post['image'], 100, 100);
		}else{
			$this->data['preview'] = $this->model_tool_image->resize($this->config->get('config_news_bg'), 100, 100);
		}
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
		
		if (isset($this->request->get['filter_isamp'])) {
			$filter_isamp = $this->request->get['filter_isamp'];
		} else {
			$filter_isamp = null;
		}
		
		if (isset($this->request->get['filter_isnew'])) {
			$filter_isnew = $this->request->get['filter_isnew'];
		} else {
			$filter_isnew = null;
		}
        
        		if (isset($this->request->get['filter_category'])) {
			$filter_category = $this->request->get['filter_category'];
		} else {
			$filter_category = null;
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
			
			if (isset($this->request->get['filter_isamp'])) {
				$url .= '&filter_isamp=' . $this->request->get['filter_isamp'];
			}
			
			if (isset($this->request->get['filter_isnew'])) {
				$url .= '&filter_isnew=' . $this->request->get['filter_isnew'];
			}
            
            			if (isset($this->request->get['filter_category'])) {
				$url .= '&filter_category=' . $this->request->get['filter_category'];
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
		                                     'href'      => $this->url->link('catalog/news', 'token=' . $this->session->data['token'] . $url, '', 'SSL'),
		                                     'separator' => ' :: '
		                                     );

		$url_filter = '';
		if (isset($this->request->get['filter_category'])) {
			$url_filter .= '&filter_category=' . $this->request->get['filter_category'];
		}

		$this->data['insert'] = $this->url->link('catalog/news/insert', 'token=' . $this->session->data['token'] . $url, '', 'SSL');
		$this->data['copy'] = $this->url->link('catalog/news/copy', 'token=' . $this->session->data['token'] . $url, '', 'SSL');
		$this->data['delete'] = $this->url->link('catalog/news/delete', 'token=' . $this->session->data['token'] . $url, '', 'SSL');

		$this->data['filter'] = $this->url->link('catalog/news', 'token=' . $this->session->data['token'] . $url_filter, '', 'SSL');
		/*{BACK}*/
		$this->data['newss'] = array();

		$data = array(
		              'filter_name'	  => $filter_name,
		              'filter_ishome'   => $filter_ishome,
					  'filter_isnew'   => $filter_isnew,
					  'filter_isamp'   => $filter_isamp,

'filter_category'   => $filter_category,

/*{FILTER_PARAM}*/
		              'filter_status'   => $filter_status,
		              'sort'            => $sort,
		              'order'           => $order,
		              'start'           => ($page - 1) * $this->config->get('config_admin_limit'),
		              'limit'           => $this->config->get('config_admin_limit')
		              );
		$this->load->model('tool/image');
		$news_total = $this->model_catalog_news->getTotalNewss($data);

		$results = $this->model_catalog_news->getNewss($data);

		$this->load->model('catalog/category');
		$this->data['categories'] = $this->model_catalog_category->getCategories(94);
		if(isset($this->request->get['filter_category']))
			$this->data['filter_category'] = $this->request->get['filter_category'];
		else
			$this->data['filter_category'] = 0;
            
           
        /*{INCLUDE_CATEGORY}*/

		foreach ($results as $result) {
			$action = array();
			/*{SUBLIST}*/
			
			/*$action[] = array(
			                  'cls'  =>'sendnotif',
			                  'text' => "Send Notification",
			                  'href' => $this->url->link('catalog/news/sendnotification', 'token=' . $this->session->data['token'] . '&news_id=' . $result['news_id'] . $url, '', 'SSL')
			                  );*/
							  
			$action[] = array(
			                  'cls'  =>'modify',
			                  'text' => $this->data['text_edit'],
			                  'href' => $this->url->link('catalog/news/update', 'token=' . $this->session->data['token'] . '&news_id=' . $result['news_id'] . $url, '', 'SSL')
			                  );
							  
			
							  
			
			
			            if ($result['image'] && file_exists(DIR_IMAGE . $result['image'])) {
                $image = $this->model_tool_image->resize($result['image'], 40, 40);
            } else {
                $image = $this->model_tool_image->resize('no_image.jpg', 40, 40);
            }
			$this->data['newss'][] = array(
			                                                  'news_id' => $result['news_id'],
			                                                  'sort_order'       => $result['sort_order'],
			                                                  'name'       => $result['name'],
			                                                  'image'      => $image,
    'ishome'     => ($result['ishome'] ? '<img src="view/image/success.png" title="'.$this->data['text_enabled'].'" />' : '<img src="view/image/delete.png" title="'.$this->data['text_disabled'].'" />'),
	'isnew'     => ($result['isnew'] ? '<img src="view/image/success.png" title="'.$this->data['text_enabled'].'" />' : '<img src="view/image/delete.png" title="'.$this->data['text_disabled'].'" />'),
    'category'       => $this->model_catalog_category->getPath($result['category_id']),	
	
	'status_en' =>$this->model_catalog_news->getStatus('news',$result['news_id'],1,true),

/*{IMAGE_LIST_ARRAY}*/	
			                                                  'status_id'		=> $result['status'],
			                                                  'status'     => ($result['status'] ? '<img src="view/image/success.png" title="'.$this->data['text_enabled'].'" />' : '<img src="view/image/delete.png" title="'.$this->data['text_disabled'].'" />'),
															  
															  'isamp_id'		=> $result['isamp'],
															  'isamp'     => ($result['isamp'] ? '<img src="view/image/success.png" title="'.$this->data['text_enabled'].'" />' : '<img src="view/image/delete.png" title="'.$this->data['text_disabled'].'" />'),
															  
			                                                  'selected'   => isset($this->request->post['selected']) && in_array($result['news_id'], $this->request->post['selected']),
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
			
			if (isset($this->request->get['filter_isamp'])) {
				$url .= '&filter_isamp=' . $this->request->get['filter_isamp'];
			}
			
			if (isset($this->request->get['filter_isnew'])) {
				$url .= '&filter_isnew=' . $this->request->get['filter_isnew'];
			}
            
            			if (isset($this->request->get['filter_category'])) {
				$url .= '&filter_category=' . $this->request->get['filter_category'];
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

		$this->data['sort_name'] = $this->url->link('catalog/news', 'token=' . $this->session->data['token'] . '&sort=pd.name' . $url, '', 'SSL');
		$this->data['sort_status'] = $this->url->link('catalog/news', 'token=' . $this->session->data['token'] . '&sort=p.status' . $url, '', 'SSL');
		$this->data['sort_order'] = $this->url->link('catalog/news', 'token=' . $this->session->data['token'] . '&sort=p.sort_order' . $url, '', 'SSL');

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}

					if (isset($this->request->get['filter_ishome'])) {
				$url .= '&filter_ishome=' . $this->request->get['filter_ishome'];
			}
			
			if (isset($this->request->get['filter_isamp'])) {
				$url .= '&filter_isamp=' . $this->request->get['filter_isamp'];
			}
			if (isset($this->request->get['filter_isnew'])) {
				$url .= '&filter_isnew=' . $this->request->get['filter_isnew'];
			}
            
            			if (isset($this->request->get['filter_category'])) {
				$url .= '&filter_category=' . $this->request->get['filter_category'];
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
		$pagination->total = $news_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->data['text_pagination'];
		$pagination->url = $this->url->link('catalog/news', 'token=' . $this->session->data['token'] . $url . '&page={page}', '', 'SSL');

		$this->data['pagination'] = $pagination->render();

		$this->data['results'] = sprintf($this->language->get('text_pagination'), ($news_total) ? (($page - 1) * $this->config->get('config_admin_limit')) + 1 : 0, ((($page - 1) * $this->config->get('config_admin_limit')) > ($news_total - $this->config->get('config_admin_limit'))) ? $news_total : ((($page - 1) * $this->config->get('config_admin_limit')) + $this->config->get('config_admin_limit')), $news_total, ceil($news_total / $this->config->get('config_admin_limit')));

		$this->data['filter_name'] = $filter_name;

		$this->data['filter_ishome'] = $filter_ishome;
		$this->data['filter_isamp'] = $filter_isamp;
		$this->data['filter_isnew'] = $filter_isnew;

$this->data['filter_category'] = $filter_category;

/*{FILTER_DATA}*/

		$this->data['filter_status'] = $filter_status;

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'catalog/news_list.tpl';
		$this->children = array(
		                        'common/header',
		                        'common/footer',
		                        );

		$this->response->setOutput($this->render());
	}

	private function getForm() {
		/*{FORM_DATA}*/
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
        
                if (isset($this->error['image_home'])) {
            $this->data['error_image_home'] = $this->error['image_home'];
        } else {
            $this->data['error_image_home'] = '';
        }
		
		if (isset($this->error['image_amp'])) {
            $this->data['error_image_amp'] = $this->error['image_amp'];
        } else {
            $this->data['error_image_amp'] = '';
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
			
			if (isset($this->request->get['filter_isamp'])) {
				$url .= '&filter_isamp=' . $this->request->get['filter_isamp'];
			}
			
			if (isset($this->request->get['filter_isnew'])) {
				$url .= '&filter_isnew=' . $this->request->get['filter_isnew'];
			}
            
            			if (isset($this->request->get['filter_category'])) {
				$url .= '&filter_category=' . $this->request->get['filter_category'];
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
		                                     'href'      => $this->url->link('catalog/news', 'token=' . $this->session->data['token'] . $url, '', 'SSL'),
		                                     'separator' => ' :: '
		                                     );

		//====================================================Assigne Data=======================================================
		if (!isset($this->request->get['news_id'])) {
			$this->data['action'] = $this->url->link('catalog/news/insert', 'token=' . $this->session->data['token'] . $url, '', 'SSL');
		} else {
			$this->data['action'] = $this->url->link('catalog/news/update', 'token=' . $this->session->data['token'] . '&news_id=' . $this->request->get['news_id'] . $url, '', 'SSL');
		}

		$this->data['cancel'] = $this->url->link('catalog/news', 'token=' . $this->session->data['token'] . $url, '', 'SSL');

		$this->data['token'] = $this->session->data['token'];

		//cate danh sach con
		 if(isset($this->request->get['cate']) && $this->request->get['cate']>0){
		 	$sublist_cate = $this->model_catalog_news->getCateById($this->request->get['cate']);
		 	$this->data['sublist_cate'] = $sublist_cate;
		 }else{
		 	$this->data['sublist_cate'] = 0;
		 }


		if (isset($this->request->get['news_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$news_info = $this->model_catalog_news->getNews($this->request->get['news_id']);
		}

		$this->load->model('localisation/language');

		$this->data['languages'] = $this->model_localisation_language->getLanguages();
		$this->load->model('tool/image');
		        if (isset($this->request->post['image'])) {
            $this->data['image'] = $this->request->post['image'];
        } elseif (isset($news_info)) {
            $this->data['image'] = $news_info['image'];
        } else {
            $this->data['image'] = '';
        }

		if (isset($news_info) && $news_info['image'] && file_exists(DIR_IMAGE . $news_info['image'])) {
			$this->data['preview'] = $this->model_tool_image->resize($news_info['image'], 100, 100);
		} elseif(isset($this->request->post['image']) && !empty($this->request->post['image']) && file_exists(DIR_IMAGE . $this->request->post['image'])) {
			$this->data['preview'] = $this->model_tool_image->resize($this->request->post['image'], 100, 100);
		}else{
			$this->data['preview'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}
        
        		if (isset($this->request->post['ishome'])) {
			$this->data['ishome'] = $this->request->post['ishome'];
		} elseif (isset($news_info)) {
			$this->data['ishome'] = $news_info['ishome'];
		} else {
			$this->data['ishome'] = '';
		}
		
		if (isset($this->request->post['image_home'])) {
			$this->data['image_home'] = $this->request->post['image_home'];
		} elseif (isset($news_info)) {
			$this->data['image_home'] = $news_info['image_home'];
		} else {
			$this->data['image_home'] = '';
		}		

		if (isset($news_info) && $news_info['image_home'] && file_exists(DIR_IMAGE . $news_info['image_home'])) {
			$this->data['preview_home'] = $this->model_tool_image->resize($news_info['image_home'], 100, 100);
		}  elseif(isset($this->request->post['image_home']) && !empty($this->request->post['image_home']) && file_exists(DIR_IMAGE . $this->request->post['image_home'])) {
			$this->data['preview_home'] = $this->model_tool_image->resize($this->request->post['image_home'], 100, 100);
		}else {
			$this->data['preview_home'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}
		
		if (isset($this->request->post['image_amp'])) {
			$this->data['image_amp'] = $this->request->post['image_amp'];
		} elseif (isset($news_info)) {
			$this->data['image_amp'] = $news_info['image_amp'];
		} else {
			$this->data['image_amp'] = '';
		}		

		if (isset($news_info) && $news_info['image_amp'] && file_exists(DIR_IMAGE . $news_info['image_amp'])) {
			$this->data['preview_amp'] = $this->model_tool_image->resize($news_info['image_amp'], 100, 100);
		}  elseif(isset($this->request->post['image_amp']) && !empty($this->request->post['image_amp']) && file_exists(DIR_IMAGE . $this->request->post['image_amp'])) {
			$this->data['preview_amp'] = $this->model_tool_image->resize($this->request->post['image_amp'], 100, 100);
		}else {
			$this->data['preview_amp'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}
        
        
        $this->load->model('tool/image');
        if (isset($this->request->post['image_og'])) {
            $this->data['image_og'] = $this->request->post['image_og'];
        } elseif (isset($news_info)) {
            $this->data['image_og'] = $news_info['image_og'];
        } else {
            $this->data['image_og'] = '';
        }

				if (isset($news_info) && $news_info['image_og'] && file_exists(DIR_IMAGE . $news_info['image_og'])) {
					$this->data['preview_og'] = $this->model_tool_image->resize($news_info['image_og'], 100, 100);
				} elseif(isset($this->request->post['image_og']) && !empty($this->request->post['image_og']) && file_exists(DIR_IMAGE . $this->request->post['image_og'])) {
					$this->data['preview_og'] = $this->model_tool_image->resize($this->request->post['image_og'], 100, 100);
				}else{
					$this->data['preview_og'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
				}

		        /*if (isset($this->request->post['keyword'])) {
					$this->data['keyword'] = $this->request->post['keyword'];
				} elseif (isset($news_info)) {
					$this->data['keyword'] = $news_info['keyword'];
				} else {
					$this->data['keyword'] = '';
				}*/

        if (isset($this->request->post['news_keyword'])) {
			$this->data['news_keyword'] = $this->request->post['news_keyword'];
		} elseif (isset($news_info)) {
			$this->data['news_keyword'] = $this->model_catalog_news->getNewsKeyword($this->request->get['news_id']);
		} else {
			$this->data['news_keyword'] = array();
		}
		
		$this->load->model('catalog/category');			
		$this->data['categories'] = $this->model_catalog_category->getCategories(94);
		
		if (isset($this->request->post['category_id'])) {
			$this->data['category_id'] = $this->request->post['category_id'];
		} elseif (isset($news_info)) {
			$this->data['category_id'] = $news_info['category_id'];
		} else {
			$this->data['category_id'] = 0;
		}
        
        
        /*{IMAGE_FORM}*/
		date_default_timezone_set("Asia/Bangkok");
		if (isset($this->request->post['date_insert'])) {
			$this->data['date_insert'] = $this->request->post['date_insert'];
		} elseif (isset($news_info)) {
			$this->data['date_insert'] = date('d-m-Y H:i:s', strtotime($news_info['date_insert']));
    	} else {
			$this->data['date_insert'] = date('d-m-Y H:i:s');
		}
		
		if (isset($this->request->post['isnew'])) {
			$this->data['isnew'] = $this->request->post['isnew'];
		} elseif (isset($news_info)) {
			$this->data['isnew'] = $news_info['isnew'];
		} else {
			$this->data['isnew'] = 0;
		}

		if (isset($this->request->post['sort_order'])) {
			$this->data['sort_order'] = $this->request->post['sort_order'];
		} elseif (isset($news_info)) {
			$this->data['sort_order'] = $news_info['sort_order'];
		} else {
			$this->data['sort_order'] = 0;
		}

		if (isset($this->request->post['status'])) {
			$this->data['status'] = $this->request->post['status'];
		} else if (isset($news_info)) {
			$this->data['status'] = $news_info['status'];
		} else {
			$this->data['status'] = 1;
		}
		
		if (isset($this->request->post['isamp'])) {
			$this->data['isamp'] = $this->request->post['isamp'];
		} else if (isset($news_info)) {
			$this->data['isamp'] = $news_info['isamp'];
		} else {
			$this->data['isamp'] = 0;
		}

		//tab data
		if (isset($this->request->post['news_description'])) {
			$this->data['news_description'] = $this->request->post['news_description'];
		} elseif (isset($news_info)) {
			$this->data['news_description'] = $this->model_catalog_news->getNewsDescriptions($this->request->get['news_id']);
		} else {
			$this->data['news_description'] = array();
		}


		$this->template = 'catalog/news_form.tpl';
		$this->children = array(
		                        'common/header',
		                        'common/footer',
		                        );

		$this->response->setOutput($this->render());
	}
	
	private function validateFormList() { 
	
    	if (!$this->user->hasPermission('modify', 'catalog/news')) {
      		$this->error['warning'] = $this->data['error_permission'];
    	}

		if(empty($this->request->post['image']))
			$this->error['image'] = $this->data['error_image'];
			
		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->data['error_warning'];
		}
					
    	if (!$this->error) {
			return true;
    	} else {
      		return false;
    	}
  	}

	private function validateForm() {

		if (!$this->user->hasPermission('modify', 'catalog/news')) {
			$this->error['warning'] = $this->data['error_permission'];
		}

		//chi validate ngon ngu mac dinh (khi lay du lieu kiem tra neu title khac rong moi hien thi)
		if((strlen(utf8_decode($this->request->post['news_description'][$this->config->get('config_language_id')]['name'])) < 1) )//|| (strlen(utf8_decode($this->request->post['news_description'][$this->config->get('config_language_id')]['name'])) > 255))
			$this->error['name'][$this->config->get('config_language_id')] = $this->data['error_name'];

		foreach ($this->request->post['news_description'] as $language_id => $value) {
			/*{VALIDATE_PDF}*/
		}

		/*if(empty($this->request->post['image']))
			$this->error['image'] = $this->data['error_image'];
		*/	
/*		if(isset($this->request->post['ishome']) && $this->request->post['ishome']==1)
if(empty($this->request->post['image_home']))
			$this->error['image_home'] = $this->data['error_image_home'];*/
			
		if(isset($this->request->post['isamp']) && $this->request->post['isamp']==1)
if(empty($this->request->post['image_amp']))
			$this->error['image_amp'] = $this->data['error_image'];
			
		if($this->request->post['category_id']==0){
			$this->error['category_id'] = $this->data['error_category'];
		}
		
		foreach ($this->request->post['news_description'] as $language_id => $value) {
						if(!empty($this->request->files['news_description']['name'][$language_id]['pdf'])
				&& ($this->request->files['news_description']['error'][$language_id]['pdf']!=0 
				|| (strtolower(strrchr($this->request->files['news_description']['name'][$language_id]['pdf'], '.'))!='.pdf' 
				//&& strtolower(strrchr($this->request->files['news_description']['name'][$language_id]['pdf'], '.'))!='.doc'
				)))
			{
				
				$this->error['pdf'][$language_id] = $this->data['error_pdf_no_support'];
			}
			
		/*{VALIDATE_PDF}*/
		}
			
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
		if (!$this->user->hasPermission('modify', 'catalog/news')) {
			$this->error['warning'] = $this->data['error_permission'];
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	private function validateCopy() {
		if (!$this->user->hasPermission('modify', 'catalog/news')) {
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
			$this->load->model('catalog/news');

			$data = array(
			              'filter_name' => $this->request->post['filter_name'],
			              'start'       => 0,
			              'limit'       => 20
			              );

			$results = $this->model_catalog_news->getNewss($data);

			foreach ($results as $result) {
				$json[] = array(
				                'news_id' => $result['news_id'],
				                'name'       => html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'),
				                'model'      => $result['model'],
				                'price'      => $result['price']
				                );
			}
		}

		$this->load->library('json');

		$this->response->setOutput(Json::encode($json));
	}
	
	private function osAddPush($oneSignalConfig)
	{
		if (sizeof($oneSignalConfig)) {  
		  $notifTitle = html_entity_decode($oneSignalConfig['title'], ENT_QUOTES, 'UTF-8');
		  $notifContent = html_entity_decode($oneSignalConfig['brief'], ENT_QUOTES, 'UTF-8');
				
		  $includedSegments = array('All');      
	
		  $fields = array(
			'app_id' => $oneSignalConfig['app_id'],
			'headings' => array("en" => $notifTitle),
			'included_segments' => $includedSegments,
			'isAnyWeb' => true,
			'url' => $oneSignalConfig['url'],
			'contents' => array("en" => $notifContent)
		  );
		  
		  $thumbnailUrl = $oneSignalConfig['image_url'];
	
		  if (!empty($thumbnailUrl)) {
			  $fields['chrome_web_image'] = $thumbnailUrl;
		  }
	
		  $logoUrl = $oneSignalConfig['logo_url'];
	
		  if (!empty($logoUrl)) {
			  $fields['chrome_web_icon'] = $logoUrl;
		  }
	
		  $ch = curl_init();
		  curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
		  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',
								 'Authorization: Basic ' . $oneSignalConfig['app_rest_api_key']));
		  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		  curl_setopt($ch, CURLOPT_HEADER, FALSE);
		  curl_setopt($ch, CURLOPT_POST, TRUE);
		  curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
		  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	
		  $response = curl_exec($ch);
		  curl_close($ch);
		  
		  return $response;
		}
	
		return null;
	} // EO_Fn
	
	public function sendnotification() {
		if (!$this->user->hasPermission('modify', 'catalog/news')) {
			$this->error['warning'] = $this->data['error_permission'];
		}
		
		if (isset($this->request->get['news_id'])) {
			
			$this->load->model('catalog/news');
			$news = $this->model_catalog_news->getNews($this->request->get['news_id']);
			
			if(isset($news['name'])){
				$des=strip_tags(html_entity_decode($news['description']));
				$img = !empty($news['image'])?HTTP_IMAGE . $news['image']:"";
				$href = HTTP_CATALOG . 'vi/' . $this->model_catalog_news->getFriendlyUrl('category_id='.ID_NEWS) . '/' . $this->model_catalog_news->getFriendlyUrl('category_id='.$news['category_id']) . '/' . $this->model_catalog_news->getFriendlyUrl('news_id='.$news['news_id']);
				$oneSignalConfig = array(
					'app_id' => ONESIGNAL_APPID, // replace with your app_id
					'app_rest_api_key' => ONESIGNAL_APP_REST_API_KEY, // replace with your app_rest_api_key
					'title' => $news['name'],
					'brief' => !empty($news['desc_short'])?$news['desc_short']:trimwidth($des,0,100,'...'),
					'url' => $href, // URL of the page/post that you're pushing for
					'image_url' => $img,
					'logo_url' => HTTP_CATALOG . 'catalog/view/theme/default/images/social-share.png', // logo of the company/website
				);
				
				print_r($oneSignalConfig);
				// now do the call
				$this->osAddPush($oneSignalConfig);
				
				$this->session->data['success'] = "Gửi Notification thành công!";
			}
		}
		//die;

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . $this->request->get['filter_name'];
			}

						if (isset($this->request->get['filter_ishome'])) {
				$url .= '&filter_ishome=' . $this->request->get['filter_ishome'];
			}
			
			if (isset($this->request->get['filter_isamp'])) {
				$url .= '&filter_isamp=' . $this->request->get['filter_isamp'];
			}
			
			if (isset($this->request->get['filter_isnew'])) {
				$url .= '&filter_isnew=' . $this->request->get['filter_isnew'];
			}
            
            			if (isset($this->request->get['filter_category'])) {
				$url .= '&filter_category=' . $this->request->get['filter_category'];
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
			
			//$this->buildcachenews($data);

			$this->redirect($this->url->link('catalog/news', 'token=' . $this->session->data['token'] . $url, '', 'SSL'));
			
			
	}
	
	/*public function buildcache($data){
		$this->load->model('catalog/news');
		$this->load->model('catalog/category');
		
		$this->data['submenu']            = $this->model_catalog_category->getFrontendCategoryChild(ID_NEWS,'t2.category_id,t2.name,t2.meta_keyword,t2.meta_description,t2.meta_title,t2.meta_description_og,t2.meta_title_og,t1.image,t1.category_id','ORDER BY  t1.sort_order ASC, t1.category_id DESC');
		foreach($this->data['submenu'] as $key=>$item){
			$this->data['submenu'][$key]['url_current'] = $this->model_catalog_news->getFriendlyUrl('category_id='.ID_NEWS) . '/' . $this->model_catalog_news->getFriendlyUrl('category_id='.$item['category_id']);
			
			$this->data['submenu'][$key]['newss'] = $this->model_catalog_news->getNewsByCateFixed($item['category_id'],'t2.news_id,t2.desc_short,t2.name,t2.meta_keyword,t2.meta_description,t2.meta_title,t2.meta_description_og,t2.meta_title_og,t1.image,t1.category_id, t1.isnew','ORDER BY  t1.sort_order ASC, t1.news_id DESC');
		}
		
		
		$this->template                = 'catalog/news/news_page_slider.tpl';
		$this->updateCache('news_index@' . ID_NEWS, $this->render());
        
	}*/
}
?>
<?php
class ControllerCatalogVideo extends Controller {
	private $error = array();

	public function __construct($registry) {
		$this->registry = $registry;

		$this->load->model('catalog/lang');

		$langs = $this->model_catalog_lang->getLangByModule('video',2);
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
		
		$this->load->model('catalog/video');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateFormList()) {
			$data = $this->request->post;
			if(isset($data['image'])){
				$this->db->query("UPDATE " . DB_PREFIX . "setting 
					SET `value` = '" . $this->db->escape($data['image']) . "'
					WHERE `key` = 'config_video_bg'");
				
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

		$this->load->model('catalog/video');

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
            
            /*{INSERT_CONTROLLER}*/

			$this->model_catalog_video->addVideo($data);

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
			
			$this->buildcachenews($data);

			$this->redirect($this->url->link('catalog/video', 'token=' . $this->session->data['token'] . $url, '', 'SSL'));
			
			exit;
		}

		$this->getForm();
	}

	public function update() {

		$this->document->setTitle($this->data['heading_title']);

		$this->load->model('catalog/video');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$data = $this->request->post;

			$filename_old = $this->model_catalog_video->getVideoById($this->request->get['video_id']) ;
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
            
            /*{UPDATE_CONTROLLER}*/

			$this->model_catalog_video->editVideo($this->request->get['video_id'], $data);

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
			
			$this->buildcachenews($data);

			$this->redirect($this->url->link('catalog/video', 'token=' . $this->session->data['token'] . $url, '', 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {

		$this->document->setTitle($this->data['heading_title']);

		$this->load->model('catalog/video');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $video_id) {

				$filename_old = $this->model_catalog_video->getVideoById($video_id) ;
				if (!empty($filename_old['filename_webm']) && file_exists(DIR_DOWNLOAD . $filename_old['filename_webm'])) {
					@unlink(DIR_DOWNLOAD . $filename_old['filename_webm']);
				}
				
				if (!empty($filename_old['filename_mp4']) && file_exists(DIR_DOWNLOAD . $filename_old['filename_mp4'])) {
					@unlink(DIR_DOWNLOAD . $filename_old['filename_mp4']);
				}
                
                /*{DELETE_CONTROLLER}*/

				$this->model_catalog_video->deleteVideo($video_id);
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
			
			$data['category_id'] = $this->request->get['filter_category'];
			$this->buildcachenews($data);

			$this->redirect($this->url->link('catalog/video', 'token=' . $this->session->data['token'] . $url, '', 'SSL'));
		}

		$this->getList();
	}

	public function copy() {

		$this->document->setTitle($this->data['heading_title']);

		$this->load->model('catalog/video');

		if (isset($this->request->post['selected']) && $this->validateCopy()) {
			foreach ($this->request->post['selected'] as $video_id) {
				$this->model_catalog_video->copyVideo($video_id);
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

			$this->redirect($this->url->link('catalog/video', 'token=' . $this->session->data['token'] . $url, '', 'SSL'));
		}

		$this->getList();
	}

	private function getList() {
		if (isset($this->error['image'])) {
            $this->data['error_image'] = $this->error['image'];
        } else {
            $this->data['error_image'] = '';
        }
        
        $this->load->model('tool/image');
		if (isset($this->request->post['image'])) {
            $this->data['image'] = $this->request->post['image'];
        } else {
            $this->data['image'] = $this->config->get('config_video_bg');
        }

		if(isset($this->request->post['image']) && !empty($this->request->post['image']) && file_exists(DIR_IMAGE . $this->request->post['image'])) {
			$this->data['preview'] =  $this->model_tool_image->resize($this->request->post['image'], 100, 100);
		}else{
			$this->data['preview'] = $this->model_tool_image->resize($this->config->get('config_video_bg'), 100, 100);
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
		                                     'href'      => $this->url->link('catalog/video', 'token=' . $this->session->data['token'] . $url, '', 'SSL'),
		                                     'separator' => ' :: '
		                                     );

		$url_filter = '';
		if (isset($this->request->get['filter_category'])) {
			$url_filter .= '&filter_category=' . $this->request->get['filter_category'];
		}

		$this->data['insert'] = $this->url->link('catalog/video/insert', 'token=' . $this->session->data['token'] . $url, '', 'SSL');
		$this->data['copy'] = $this->url->link('catalog/video/copy', 'token=' . $this->session->data['token'] . $url, '', 'SSL');
		$this->data['delete'] = $this->url->link('catalog/video/delete', 'token=' . $this->session->data['token'] . $url, '', 'SSL');

		$this->data['filter'] = $this->url->link('catalog/video', 'token=' . $this->session->data['token'] . $url_filter, '', 'SSL');
		/*{BACK}*/
		$this->data['videos'] = array();

		$data = array(
		              'filter_name'	  => $filter_name,
		              'filter_ishome'   => $filter_ishome,
					  'filter_category'   => $filter_category,

/*{FILTER_PARAM}*/
		              'filter_status'   => $filter_status,
		              'sort'            => $sort,
		              'order'           => $order,
		              'start'           => ($page - 1) * $this->config->get('config_admin_limit'),
		              'limit'           => $this->config->get('config_admin_limit')
		              );
		$this->load->model('tool/image');
		$video_total = $this->model_catalog_video->getTotalVideos($data);

		$results = $this->model_catalog_video->getVideos($data);

		/*{INCLUDE_CATEGORY}*/
		
		$this->load->model('catalog/category');
		$this->data['categories'] = $this->model_catalog_category->getCategories(93,2);
		if(isset($this->request->get['filter_category']))
			$this->data['filter_category'] = $this->request->get['filter_category'];
		else
			$this->data['filter_category'] = 0;
        

		foreach ($results as $result) {
			$action = array();
			/*{SUBLIST}*/
			$action[] = array(
			                  'cls'  =>'modify',
			                  'text' => $this->data['text_edit'],
			                  'href' => $this->url->link('catalog/video/update', 'token=' . $this->session->data['token'] . '&video_id=' . $result['video_id'] . $url, '', 'SSL')
			                  );
			            /*if ($result['image'] && file_exists(DIR_IMAGE . $result['image'])) {
                $image = $this->model_tool_image->resize($result['image'], 40, 40);
            } else {
                $image = $this->model_tool_image->resize('no_image.jpg', 40, 40);
            }*/
			
			if ($result['image_video'] && file_exists(DIR_IMAGE . $result['image_video'])) {
                $image = $this->model_tool_image->resize($result['image_video'], 40, 40);
            } else {
                $image = $this->model_tool_image->resize('no_image.jpg', 40, 40);
            }
			$this->data['videos'][] = array(
			                                                  'video_id' => $result['video_id'],
			                                                  'sort_order'       => $result['sort_order'],
			                                                  'name'       => $result['name'],
			                                                  'image'      => $image,
    'ishome'     => ($result['ishome'] ? '<img src="view/image/success.png" title="'.$this->data['text_enabled'].'" />' : '<img src="view/image/delete.png" title="'.$this->data['text_disabled'].'" />'),
	'category'       => $this->model_catalog_category->getPath($result['category_id']),
    /*{IMAGE_LIST_ARRAY}*/
			                                                  'status_id'		=> $result['status'],
			                                                  'status'     => ($result['status'] ? '<img src="view/image/success.png" title="'.$this->data['text_enabled'].'" />' : '<img src="view/image/delete.png" title="'.$this->data['text_disabled'].'" />'),
			                                                  'selected'   => isset($this->request->post['selected']) && in_array($result['video_id'], $this->request->post['selected']),
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

		$this->data['sort_name'] = $this->url->link('catalog/video', 'token=' . $this->session->data['token'] . '&sort=pd.name' . $url, '', 'SSL');
		$this->data['sort_status'] = $this->url->link('catalog/video', 'token=' . $this->session->data['token'] . '&sort=p.status' . $url, '', 'SSL');
		$this->data['sort_order'] = $this->url->link('catalog/video', 'token=' . $this->session->data['token'] . '&sort=p.sort_order' . $url, '', 'SSL');

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
		$pagination->total = $video_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->data['text_pagination'];
		$pagination->url = $this->url->link('catalog/video', 'token=' . $this->session->data['token'] . $url . '&page={page}', '', 'SSL');

		$this->data['pagination'] = $pagination->render();

		$this->data['results'] = sprintf($this->language->get('text_pagination'), ($video_total) ? (($page - 1) * $this->config->get('config_admin_limit')) + 1 : 0, ((($page - 1) * $this->config->get('config_admin_limit')) > ($video_total - $this->config->get('config_admin_limit'))) ? $video_total : ((($page - 1) * $this->config->get('config_admin_limit')) + $this->config->get('config_admin_limit')), $video_total, ceil($video_total / $this->config->get('config_admin_limit')));

		$this->data['filter_name'] = $filter_name;

		$this->data['filter_ishome'] = $filter_ishome;
		$this->data['filter_category'] = $filter_category;

/*{FILTER_DATA}*/

		$this->data['filter_status'] = $filter_status;

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'catalog/video_list.tpl';
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
		
		if (isset($this->error['category_id'])) {
			$this->data['error_category_id'] = $this->error['category_id'];
		} else {
			$this->data['error_category_id'] = '';
		}
        
                if (isset($this->error['image_home'])) {
            $this->data['error_image_home'] = $this->error['image_home'];
        } else {
            $this->data['error_image_home'] = '';
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
		                                     'href'      => $this->url->link('catalog/video', 'token=' . $this->session->data['token'] . $url, '', 'SSL'),
		                                     'separator' => ' :: '
		                                     );

		//====================================================Assigne Data=======================================================
		if (!isset($this->request->get['video_id'])) {
			$this->data['action'] = $this->url->link('catalog/video/insert', 'token=' . $this->session->data['token'] . $url, '', 'SSL');
		} else {
			$this->data['action'] = $this->url->link('catalog/video/update', 'token=' . $this->session->data['token'] . '&video_id=' . $this->request->get['video_id'] . $url, '', 'SSL');
		}

		$this->data['cancel'] = $this->url->link('catalog/video', 'token=' . $this->session->data['token'] . $url, '', 'SSL');

		$this->data['token'] = $this->session->data['token'];

		//cate danh sach con
		 if(isset($this->request->get['cate']) && $this->request->get['cate']>0){
		 	$sublist_cate = $this->model_catalog_video->getCateById($this->request->get['cate']);
		 	$this->data['sublist_cate'] = $sublist_cate;
		 }else{
		 	$this->data['sublist_cate'] = 0;
		 }


		if (isset($this->request->get['video_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$video_info = $this->model_catalog_video->getVideo($this->request->get['video_id']);
		}

		$this->load->model('localisation/language');

		$this->data['languages'] = $this->model_localisation_language->getLanguages();
		$this->load->model('tool/image');
		        if (isset($this->request->post['image'])) {
            $this->data['image'] = $this->request->post['image'];
        } elseif (isset($video_info)) {
            $this->data['image'] = $video_info['image'];
        } else {
            $this->data['image'] = '';
        }

		if (isset($video_info) && $video_info['image'] && file_exists(DIR_IMAGE . $video_info['image'])) {
			$this->data['preview'] = $this->model_tool_image->resize($video_info['image'], 100, 100);
		} elseif(isset($this->request->post['image']) && !empty($this->request->post['image']) && file_exists(DIR_IMAGE . $this->request->post['image'])) {
			$this->data['preview'] = $this->model_tool_image->resize($this->request->post['image'], 100, 100);
		}else{
			$this->data['preview'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}
        
        		if (isset($this->request->post['ishome'])) {
			$this->data['ishome'] = $this->request->post['ishome'];
		} elseif (isset($video_info)) {
			$this->data['ishome'] = $video_info['ishome'];
		} else {
			$this->data['ishome'] = '';
		}
		
		if (isset($this->request->post['image_home'])) {
			$this->data['image_home'] = $this->request->post['image_home'];
		} elseif (isset($video_info)) {
			$this->data['image_home'] = $video_info['image_home'];
		} else {
			$this->data['image_home'] = '';
		}		

		if (isset($video_info) && $video_info['image_home'] && file_exists(DIR_IMAGE . $video_info['image_home'])) {
			$this->data['preview_home'] = $this->model_tool_image->resize($video_info['image_home'], 100, 100);
		}  elseif(isset($this->request->post['image_home']) && !empty($this->request->post['image_home']) && file_exists(DIR_IMAGE . $this->request->post['image_home'])) {
			$this->data['preview_home'] = $this->model_tool_image->resize($this->request->post['image_home'], 100, 100);
		}else {
			$this->data['preview_home'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}
        
        
        $this->load->model('tool/image');
        if (isset($this->request->post['image_og'])) {
            $this->data['image_og'] = $this->request->post['image_og'];
        } elseif (isset($video_info)) {
            $this->data['image_og'] = $video_info['image_og'];
        } else {
            $this->data['image_og'] = '';
        }

				if (isset($video_info) && $video_info['image_og'] && file_exists(DIR_IMAGE . $video_info['image_og'])) {
					$this->data['preview_og'] = $this->model_tool_image->resize($video_info['image_og'], 100, 100);
				} elseif(isset($this->request->post['image_og']) && !empty($this->request->post['image_og']) && file_exists(DIR_IMAGE . $this->request->post['image_og'])) {
					$this->data['preview_og'] = $this->model_tool_image->resize($this->request->post['image_og'], 100, 100);
				}else{
					$this->data['preview_og'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
				}

		        /*if (isset($this->request->post['keyword'])) {
					$this->data['keyword'] = $this->request->post['keyword'];
				} elseif (isset($video_info)) {
					$this->data['keyword'] = $video_info['keyword'];
				} else {
					$this->data['keyword'] = '';
				}*/
		
		
		if (isset($this->request->post['video_keyword'])) {
			$this->data['video_keyword'] = $this->request->post['video_keyword'];
		} elseif (isset($video_info)) {
			$this->data['video_keyword'] = $this->model_catalog_video->getVideoKeyword($this->request->get['video_id']);
		} else {
			$this->data['video_keyword'] = array();
		}
		
		
        		if (isset($this->request->post['image_video'])) {
			$this->data['image_video'] = $this->request->post['image_video'];
		} elseif (isset($video_info)) {
			$this->data['image_video'] = $video_info['image_video'];
		} else {
			$this->data['image_video'] = '';
		}
        
        $this->load->model('tool/image');
		
		if (isset($video_info) && $video_info['image_video'] && file_exists(DIR_IMAGE . $video_info['image_video'])) {
			$this->data['preview_video'] = $this->model_tool_image->resize($video_info['image_video'], 100, 100);
		} elseif(isset($this->request->post['image_video']) && !empty($this->request->post['image_video']) && file_exists(DIR_IMAGE . $this->request->post['image_video'])) {
			$this->data['preview_video'] = $this->model_tool_image->resize($this->request->post['image_video'], 100, 100);
		}else{
			$this->data['preview_video'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}
        
        if (isset($this->request->post['isftp'])) {
      		$this->data['isftp'] = $this->request->post['isftp'];
    	} else if (isset($video_info)) {
			$this->data['isftp'] = $video_info['isftp'];
		} else {
      		$this->data['isftp'] = 0;
    	}
		
		if (isset($this->request->post['file_mp4_ftp'])) {
      		$this->data['file_mp4_ftp'] = $this->request->post['file_mp4_ftp'];
    	}else if (isset($video_info['filename_mp4'])) {
    		$this->data['file_mp4_ftp'] = $video_info['filename_mp4'];
		} else {
			$this->data['file_mp4_ftp'] = '';
		}
		
		if (isset($this->request->post['file_webm_ftp'])) {
      		$this->data['file_webm_ftp'] = $this->request->post['file_webm_ftp'];
    	}else if (isset($video_info['filename_webm'])) {
    		$this->data['file_webm_ftp'] = $video_info['filename_webm'];
		} else {
			$this->data['file_webm_ftp'] = '';
		}
		
		if (isset($video_info['filename_webm'])) {
    		$this->data['filename_webm'] = $video_info['filename_webm'];
		} else {
			$this->data['filename_webm'] = '';
		}
		
		if (isset($video_info['filename_mp4'])) {
    		$this->data['filename_mp4'] = $video_info['filename_mp4'];
		} else {
			$this->data['filename_mp4'] = '';
		}
        
        if (isset($this->request->post['script'])) {
      		$this->data['script'] = $this->request->post['script'];
    	} elseif (isset($video_info)) {
      		$this->data['script'] = $video_info['script'];
    	} else {
			$this->data['script'] = '';
		}
		
		if (isset($this->request->post['scripten'])) {
      		$this->data['scripten'] = $this->request->post['scripten'];
    	} elseif (isset($video_info)) {
      		$this->data['scripten'] = $video_info['scripten'];
    	} else {
			$this->data['scripten'] = '';
		}
		
		if (isset($this->request->post['isyoutube'])) {
      		$this->data['isyoutube'] = $this->request->post['isyoutube'];
    	} elseif (isset($video_info)) {
      		$this->data['isyoutube'] = $video_info['isyoutube'];
    	} else {
			$this->data['isyoutube'] = 0;
		}
        
        /*{IMAGE_FORM}*/
		
		$this->load->model('catalog/category');			
		$this->data['categories'] = $this->model_catalog_category->getCategories(93,2);
		
		if (isset($this->request->post['category_id'])) {
			$this->data['category_id'] = $this->request->post['category_id'];
		} elseif (isset($video_info)) {
			$this->data['category_id'] = $video_info['category_id'];
		} else {
			$this->data['category_id'] = 0;
		}

		if (isset($this->request->post['sort_order'])) {
			$this->data['sort_order'] = $this->request->post['sort_order'];
		} elseif (isset($video_info)) {
			$this->data['sort_order'] = $video_info['sort_order'];
		} else {
			$this->data['sort_order'] = 0;
		}

		if (isset($this->request->post['status'])) {
			$this->data['status'] = $this->request->post['status'];
		} else if (isset($video_info)) {
			$this->data['status'] = $video_info['status'];
		} else {
			$this->data['status'] = 1;
		}

		//tab data
		if (isset($this->request->post['video_description'])) {
			$this->data['video_description'] = $this->request->post['video_description'];
		} elseif (isset($video_info)) {
			$this->data['video_description'] = $this->model_catalog_video->getVideoDescriptions($this->request->get['video_id']);
		} else {
			$this->data['video_description'] = array();
		}


		$this->template = 'catalog/video_form.tpl';
		$this->children = array(
		                        'common/header',
		                        'common/footer',
		                        );

		$this->response->setOutput($this->render());
	}
	
	private function validateFormList() { 
	
    	if (!$this->user->hasPermission('modify', 'catalog/video')) {
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

		if (!$this->user->hasPermission('modify', 'catalog/video')) {
			$this->error['warning'] = $this->data['error_permission'];
		}

		//chi validate ngon ngu mac dinh (khi lay du lieu kiem tra neu title khac rong moi hien thi)
		if((strlen(utf8_decode($this->request->post['video_description'][$this->config->get('config_language_id')]['name'])) < 1) || (strlen(utf8_decode($this->request->post['video_description'][$this->config->get('config_language_id')]['name'])) > 255))
			$this->error['name'][$this->config->get('config_language_id')] = $this->data['error_name'];

		foreach ($this->request->post['video_description'] as $language_id => $value) {
			/*{VALIDATE_PDF}*/
		}
		
		/*if($this->request->post['category_id']==0){
			$this->error['category_id'] = $this->data['error_category'];
		}*/

		/*if(empty($this->request->post['image']))
			$this->error['image'] = $this->data['error_image'];
			*/
		/*if(isset($this->request->post['ishome']) && $this->request->post['ishome']==1)
if(empty($this->request->post['image_home']))
			$this->error['image_home'] = $this->data['error_image_home'];
		*/	
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
			
			
			if ($this->request->files['video_webm']['name']) { 	
				
				if (substr(strrchr($this->request->files['video_webm']['name'], '.'), 1) != 'mp4') {
					$this->error['video_webm'] = $this->data['error_no_support'];
				}
	
				if($this->request->files['video_webm']['size']>100000000)
				{
					$this->error['video_webm'] = $this->data['error_big_file'];
				}
			}/*else if(empty($this->request->post['video_mp4_old'])){
				$this->error['video_webm'] = 'Vui lòng chọn file!';
			}*/
		
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
		if (!$this->user->hasPermission('modify', 'catalog/video')) {
			$this->error['warning'] = $this->data['error_permission'];
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	private function validateCopy() {
		if (!$this->user->hasPermission('modify', 'catalog/video')) {
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
			$this->load->model('catalog/video');

			$data = array(
			              'filter_name' => $this->request->post['filter_name'],
			              'start'       => 0,
			              'limit'       => 20
			              );

			$results = $this->model_catalog_video->getVideos($data);

			foreach ($results as $result) {
				$json[] = array(
				                'video_id' => $result['video_id'],
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
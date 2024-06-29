<?php
class ControllerCatalogContact extends Controller {
	private $error = array();

	public function __construct($registry) {
		$this->registry = $registry;

		$this->load->model('catalog/lang');

		$langs = $this->model_catalog_lang->getLangByModule('contact',2);
		foreach($langs as $lang){
			$this->data[$lang['key']] = html_entity_decode($lang['name']);
		}

		if(isset($this->request->get['cate']) && $this->request->get['cate']>0){
			$this->load->model('catalog/contact');
			$this->data['heading_title'] = $this->data['heading_title'] . ' >> ' . $this->model_catalog_contact->getTitle($this->request->get['cate']);//$this->data['heading_cua_hang'];//
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
		
		
		$this->load->model('catalog/contact');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateFormList()) {
			$data = $this->request->post;
			if(isset($data['image'])){
				$this->db->query("UPDATE " . DB_PREFIX . "setting 
					SET `value` = '" . $this->db->escape($data['image']) . "'
					WHERE `key` = 'config_contact_bg'");
				
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

		$this->load->model('catalog/contact');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$data = $this->request->post;

			/*{INSERT_CONTROLLER}*/

			$this->model_catalog_contact->addContact($data);

			$this->session->data['success'] = $this->data['text_success'];

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . $this->request->get['filter_name'];
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

			$this->redirect($this->url->link('catalog/contact', 'token=' . $this->session->data['token'] . $url, '', 'SSL'));
			
			exit;
		}

		$this->getForm();
	}

	public function update() {

		$this->document->setTitle($this->data['heading_title']);

		$this->load->model('catalog/contact');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$data = $this->request->post;

			/*{UPDATE_CONTROLLER}*/

			$this->model_catalog_contact->editContact($this->request->get['contact_id'], $data);

			$this->session->data['success'] = $this->data['text_success_update'];

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . $this->request->get['filter_name'];
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

			$this->redirect($this->url->link('catalog/contact', 'token=' . $this->session->data['token'] . $url, '', 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {

		$this->document->setTitle($this->data['heading_title']);

		$this->load->model('catalog/contact');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $contact_id) {

				/*{DELETE_CONTROLLER}*/

				$this->model_catalog_contact->deleteContact($contact_id);
			}

			$this->session->data['success'] = $this->data['text_success_delete'];

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . $this->request->get['filter_name'];
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

			$this->redirect($this->url->link('catalog/contact', 'token=' . $this->session->data['token'] . $url, '', 'SSL'));
		}

		$this->getList();
	}

	public function copy() {

		$this->document->setTitle($this->data['heading_title']);

		$this->load->model('catalog/contact');

		if (isset($this->request->post['selected']) && $this->validateCopy()) {
			foreach ($this->request->post['selected'] as $contact_id) {
				$this->model_catalog_contact->copyContact($contact_id);
			}

			$this->session->data['success'] = $this->data['text_success'];

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . $this->request->get['filter_name'];
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

			$this->redirect($this->url->link('catalog/contact', 'token=' . $this->session->data['token'] . $url, '', 'SSL'));
		}

		$this->getList();
	}

	private function getList() {
		
		$cate = isset($this->request->get['cate'])?(int)$this->request->get['cate']:0;
		$this->data['cate'] = $cate;
		
		if (isset($this->error['image'])) {
            $this->data['error_image'] = $this->error['image'];
        } else {
            $this->data['error_image'] = '';
        }
        
        $this->load->model('tool/image');
		if (isset($this->request->post['image'])) {
            $this->data['image'] = $this->request->post['image'];
        } else {
            $this->data['image'] = $this->config->get('config_contact_bg');
        }

		if(isset($this->request->post['image']) && !empty($this->request->post['image']) && file_exists(DIR_IMAGE . $this->request->post['image'])) {
			$this->data['preview'] =  $this->model_tool_image->resize($this->request->post['image'], 100, 100);
		}else{
			$this->data['preview'] = $this->model_tool_image->resize($this->config->get('config_contact_bg'), 100, 100);
		}
		
		//================================Filter=================================================
		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = null;
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
		                                     'href'      => $this->url->link('catalog/contact', 'token=' . $this->session->data['token'] . $url, '', 'SSL'),
		                                     'separator' => ' :: '
		                                     );

		$url_filter = '';
		if (isset($this->request->get['filter_category'])) {
			$url_filter .= '&filter_category=' . $this->request->get['filter_category'];
		}

		$this->data['insert'] = $this->url->link('catalog/contact/insert', 'token=' . $this->session->data['token'] . $url, '', 'SSL');
		$this->data['copy'] = $this->url->link('catalog/contact/copy', 'token=' . $this->session->data['token'] . $url, '', 'SSL');
		$this->data['delete'] = $this->url->link('catalog/contact/delete', 'token=' . $this->session->data['token'] . $url, '', 'SSL');

		$this->data['filter'] = $this->url->link('catalog/contact', 'token=' . $this->session->data['token'] . $url_filter, '', 'SSL');
		$this->data['back'] = $this->url->link('catalog/contact', 'token=' . $this->session->data['token'], '', 'SSL');
		$this->data['contacts'] = array();

		$data = array(
		              'filter_name'	  => $filter_name,
		              'cate'   => $cate,

/*{FILTER_PARAM}*/
		              'filter_status'   => $filter_status,
		              'sort'            => $sort,
		              'order'           => $order,
		              'start'           => ($page - 1) * $this->config->get('config_admin_limit'),
		              'limit'           => $this->config->get('config_admin_limit')
		              );
		$this->load->model('tool/image');
		$contact_total = $this->model_catalog_contact->getTotalContacts($data);

		$results = $this->model_catalog_contact->getContacts($data);

		/*{INCLUDE_CATEGORY}*/

		foreach ($results as $result) {
			$action = array();
						if(1==2  ){
				$action[] = array(
                	'cls'  =>'btn_list',
					'text' => $this->data['text_list'],
					'href' => $this->url->link('catalog/contact', 'token=' . $this->session->data['token'] . '&cate=' . $result['contact_id'], '', 'SSL')
				);
			}
			
			/*if($result["contact_id"]==42 ){
				$href_temp = $this->url->link('catalog/partner', 'token=' . $this->session->data['token'] , '', 'SSL');
							
				$action[] = array(
                	'cls'  =>'btn_list',
					'text' => $this->data['text_list'],
					'href' => $href_temp
				);
			}*/
			
			
			$action[] = array(
			                  'cls'  =>'modify',
			                  'text' => $this->data['text_edit'],
			                  'href' => $this->url->link('catalog/contact/update', 'token=' . $this->session->data['token'] . '&contact_id=' . $result['contact_id'] . $url, '', 'SSL')
			                  );
			            if ($result['image'] && file_exists(DIR_IMAGE . $result['image'])) {
                $image = $this->model_tool_image->resize($result['image'], 40, 40);
            } else {
                $image = $this->model_tool_image->resize('no_image.jpg', 40, 40);
            }
			$this->data['contacts'][] = array(
			                                                  'contact_id' => $result['contact_id'],
			                                                  'sort_order'       => $result['sort_order'],
			                                                  'name'       => $result['name'],
			                                                  'image'      => $image,
/*{IMAGE_LIST_ARRAY}*/
			                                                  'status_id'		=> $result['status'],
			                                                  'status'     => ($result['status'] ? '<img src="view/image/success.png" title="'.$this->data['text_enabled'].'" />' : '<img src="view/image/delete.png" title="'.$this->data['text_disabled'].'" />'),
															  'ishome'     => ($result['ishome'] ? '<img src="view/image/success.png" title="'.$this->data['text_enabled'].'" />' : '<img src="view/image/delete.png" title="'.$this->data['text_disabled'].'" />'),
			                                                  'selected'   => isset($this->request->post['selected']) && in_array($result['contact_id'], $this->request->post['selected']),
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

		$this->data['sort_name'] = $this->url->link('catalog/contact', 'token=' . $this->session->data['token'] . '&sort=pd.name' . $url, '', 'SSL');
		$this->data['sort_status'] = $this->url->link('catalog/contact', 'token=' . $this->session->data['token'] . '&sort=p.status' . $url, '', 'SSL');
		$this->data['sort_order'] = $this->url->link('catalog/contact', 'token=' . $this->session->data['token'] . '&sort=p.sort_order' . $url, '', 'SSL');

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
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
		$pagination->total = $contact_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->data['text_pagination'];
		$pagination->url = $this->url->link('catalog/contact', 'token=' . $this->session->data['token'] . $url . '&page={page}', '', 'SSL');

		$this->data['pagination'] = $pagination->render();

		$this->data['results'] = sprintf($this->language->get('text_pagination'), ($contact_total) ? (($page - 1) * $this->config->get('config_admin_limit')) + 1 : 0, ((($page - 1) * $this->config->get('config_admin_limit')) > ($contact_total - $this->config->get('config_admin_limit'))) ? $contact_total : ((($page - 1) * $this->config->get('config_admin_limit')) + $this->config->get('config_admin_limit')), $contact_total, ceil($contact_total / $this->config->get('config_admin_limit')));

		$this->data['filter_name'] = $filter_name;

		$this->data['cate'] = $cate;

/*{FILTER_DATA}*/

		$this->data['filter_status'] = $filter_status;

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'catalog/contact_list.tpl';
		$this->children = array(
		                        'common/header',
		                        'common/footer',
		                        );

		$this->response->setOutput($this->render());
	}

	private function getForm() {
				$cate = isset($this->request->get['cate'])?(int)$this->request->get['cate']:0;
		$this->data['cate'] = $cate;
		$contact_id = isset($this->request->get['contact_id'])?(int)$this->request->get['contact_id']:0;
		$this->data['contact_id'] = $contact_id;
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
		
		if (isset($this->error['error_timeface'])) {
            $this->data['error_timeface'] = $this->error['error_timeface'];
        } else {
            $this->data['error_timeface'] = '';
        }
        
        /*{ERROR_IMAGE}*/
 		//URL

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
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
		                                     'href'      => $this->url->link('catalog/contact', 'token=' . $this->session->data['token'] . $url, '', 'SSL'),
		                                     'separator' => ' :: '
		                                     );

		//====================================================Assigne Data=======================================================
		if (!isset($this->request->get['contact_id'])) {
			$this->data['action'] = $this->url->link('catalog/contact/insert', 'token=' . $this->session->data['token'] . $url, '', 'SSL');
		} else {
			$this->data['action'] = $this->url->link('catalog/contact/update', 'token=' . $this->session->data['token'] . '&contact_id=' . $this->request->get['contact_id'] . $url, '', 'SSL');
		}

		$this->data['cancel'] = $this->url->link('catalog/contact', 'token=' . $this->session->data['token'] . $url, '', 'SSL');

		$this->data['token'] = $this->session->data['token'];

		//cate danh sach con
		 /*if(isset($this->request->get['cate']) && $this->request->get['cate']>0){
		 	$sublist_cate = $this->model_catalog_contact->getCateById($this->request->get['cate']);
		 	$this->data['sublist_cate'] = $sublist_cate;
		 }else{
		 	$this->data['sublist_cate'] = 0;
		 }*/


		if (isset($this->request->get['contact_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$contact_info = $this->model_catalog_contact->getContact($this->request->get['contact_id']);
		}

		$this->load->model('localisation/language');

		$this->data['languages'] = $this->model_localisation_language->getLanguages();
		$this->load->model('tool/image');
		        if (isset($this->request->post['image'])) {
            $this->data['image'] = $this->request->post['image'];
        } elseif (isset($contact_info)) {
            $this->data['image'] = $contact_info['image'];
        } else {
            $this->data['image'] = '';
        }

		if (isset($contact_info) && $contact_info['image'] && file_exists(DIR_IMAGE . $contact_info['image'])) {
			$this->data['preview'] = $this->model_tool_image->resize($contact_info['image'], 100, 100);
		} elseif(isset($this->request->post['image']) && !empty($this->request->post['image']) && file_exists(DIR_IMAGE . $this->request->post['image'])) {
			$this->data['preview'] = $this->model_tool_image->resize($this->request->post['image'], 100, 100);
		}else{
			$this->data['preview'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}
		
		if (isset($this->request->post['image1'])) {
            $this->data['image1'] = $this->request->post['image1'];
        } elseif (isset($contact_info)) {
            $this->data['image1'] = $contact_info['image1'];
        } else {
            $this->data['image1'] = '';
        }

		if (isset($contact_info) && $contact_info['image1'] && file_exists(DIR_IMAGE . $contact_info['image1'])) {
			$this->data['preview1'] = $this->model_tool_image->resize($contact_info['image1'], 100, 100);
		} elseif(isset($this->request->post['image1']) && !empty($this->request->post['image1']) && file_exists(DIR_IMAGE . $this->request->post['image1'])) {
			$this->data['preview1'] = $this->model_tool_image->resize($this->request->post['image1'], 100, 100);
		}else{
			$this->data['preview1'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}
		//
		if (isset($this->request->post['image2'])) {
            $this->data['image2'] = $this->request->post['image2'];
        } elseif (isset($contact_info)) {
            $this->data['image2'] = $contact_info['image2'];
        } else {
            $this->data['image2'] = '';
        }

		if (isset($contact_info) && $contact_info['image2'] && file_exists(DIR_IMAGE . $contact_info['image2'])) {
			$this->data['preview2'] = $this->model_tool_image->resize($contact_info['image2'], 100, 100);
		} elseif(isset($this->request->post['image2']) && !empty($this->request->post['image2']) && file_exists(DIR_IMAGE . $this->request->post['image2'])) {
			$this->data['preview2'] = $this->model_tool_image->resize($this->request->post['image2'], 100, 100);
		}else{
			$this->data['preview2'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}
		
		if (isset($this->request->post['phone'])) {
			$this->data['phone'] = $this->request->post['phone'];
		} elseif (isset($contact_info)) {
			$this->data['phone'] = $contact_info['phone'];
		} else {
			$this->data['phone'] = '';
		}
		
		if (isset($this->request->post['phone1'])) {
			$this->data['phone1'] = $this->request->post['phone1'];
		} elseif (isset($contact_info)) {
			$this->data['phone1'] = $contact_info['phone1'];
		} else {
			$this->data['phone1'] = '';
		}
		
		if (isset($this->request->post['phoneviber'])) {
			$this->data['phoneviber'] = $this->request->post['phoneviber'];
		} elseif (isset($contact_info)) {
			$this->data['phoneviber'] = $contact_info['phoneviber'];
		} else {
			$this->data['phoneviber'] = '';
		}
		
		if (isset($this->request->post['googlemap'])) {
			$this->data['googlemap'] = $this->request->post['googlemap'];
		} elseif (isset($contact_info)) {
			$this->data['googlemap'] = $contact_info['googlemap'];
		} else {
			$this->data['googlemap'] = '';
		}
		
		if (isset($this->request->post['fax'])) {
			$this->data['fax'] = $this->request->post['fax'];
		} elseif (isset($contact_info)) {
			$this->data['fax'] = $contact_info['fax'];
		} else {
			$this->data['fax'] = '';
		}
		
		if (isset($this->request->post['fax1'])) {
			$this->data['fax1'] = $this->request->post['fax1'];
		} elseif (isset($contact_info)) {
			$this->data['fax1'] = $contact_info['fax1'];
		} else {
			$this->data['fax1'] = '';
		}
		
		if (isset($this->request->post['fax2'])) {
			$this->data['fax2'] = $this->request->post['fax2'];
		} elseif (isset($contact_info)) {
			$this->data['fax2'] = $contact_info['fax2'];
		} else {
			$this->data['fax2'] = '';
		}
		
		if (isset($this->request->post['email'])) {
			$this->data['email'] = $this->request->post['email'];
		} elseif (isset($contact_info)) {
			$this->data['email'] = $contact_info['email'];
		} else {
			$this->data['email'] = '';
		}
		
		if (isset($this->request->post['email1'])) {
			$this->data['email1'] = $this->request->post['email1'];
		} elseif (isset($contact_info)) {
			$this->data['email1'] = $contact_info['email1'];
		} else {
			$this->data['email1'] = '';
		}
		
		if (isset($this->request->post['timeface'])) {
			$this->data['timeface'] = $this->request->post['timeface'];
		} else if (isset($contact_info)) {
			$this->data['timeface'] = $contact_info['timeface'];
		} else {
			$this->data['timeface'] = 2;
		}
		
		if (isset($this->request->post['location'])) {
			$this->data['location'] = $this->request->post['location'];
		} elseif (isset($contact_info)) {
			$this->data['location'] = $contact_info['location'];
		} else {
			$this->data['location'] = '';
		}
		
		if (isset($this->request->post['phonelist'])) {
			$this->data['phonelist'] = $this->request->post['phonelist'];
		} elseif (isset($contact_info)) {
			$this->data['phonelist'] = $contact_info['phonelist'];
		} else {
			$this->data['phonelist'] = '';
		}
		
		if (isset($this->request->post['hotlinelist'])) {
			$this->data['hotlinelist'] = $this->request->post['hotlinelist'];
		} elseif (isset($contact_info)) {
			$this->data['hotlinelist'] = $contact_info['hotlinelist'];
		} else {
			$this->data['hotlinelist'] = '';
		}
		
		if (isset($this->request->post['faxlist'])) {
			$this->data['faxlist'] = $this->request->post['faxlist'];
		} elseif (isset($contact_info)) {
			$this->data['faxlist'] = $contact_info['faxlist'];
		} else {
			$this->data['faxlist'] = '';
		}
		
		if (isset($this->request->post['emaillist'])) {
			$this->data['emaillist'] = $this->request->post['emaillist'];
		} elseif (isset($contact_info)) {
			$this->data['emaillist'] = $contact_info['emaillist'];
		} else {
			$this->data['emaillist'] = '';
		}
		
		if (isset($this->request->post['tax'])) {
			$this->data['tax'] = $this->request->post['tax'];
		} elseif (isset($contact_info)) {
			$this->data['tax'] = $contact_info['tax'];
		} else {
			$this->data['tax'] = '';
		}
		
		if (isset($this->request->post['ishome'])) {
			$this->data['ishome'] = $this->request->post['ishome'];
		} elseif (isset($contact_info)) {
			$this->data['ishome'] = $contact_info['ishome'];
		} else {
			$this->data['ishome'] = 0;
		}
		
		if (isset($this->request->post['image_og'])) {
            $this->data['image_og'] = $this->request->post['image_og'];
        } elseif (isset($contact_info)) {
            $this->data['image_og'] = $contact_info['image_og'];
        } else {
            $this->data['image_og'] = '';
        }

				if (isset($contact_info) && $contact_info['image_og'] && file_exists(DIR_IMAGE . $contact_info['image_og'])) {
					$this->data['preview_og'] = $this->model_tool_image->resize($contact_info['image_og'], 100, 100);
				} elseif(isset($this->request->post['image_og']) && !empty($this->request->post['image_og']) && file_exists(DIR_IMAGE . $this->request->post['image_og'])) {
					$this->data['preview_og'] = $this->model_tool_image->resize($this->request->post['image_og'], 100, 100);
				}else{
					$this->data['preview_og'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
				}
		
		
		if (isset($this->request->post['contact_keyword'])) {
			$this->data['contact_keyword'] = $this->request->post['contact_keyword'];
		} elseif (isset($contact_info)) {
			$this->data['contact_keyword'] = $this->model_catalog_contact->getContactKeyword($this->request->get['contact_id']);
		} else {
			$this->data['contact_keyword'] = array();
		}
		
		if (isset($this->request->post['address_location'])) {
			$this->data['address_location'] = $this->request->post['address_location'];
		} elseif (isset($contact_info)) {
			$this->data['address_location'] = $contact_info['address_location'];
		} else {
			$this->data['address_location'] = '';
		}
        
        /*{IMAGE_FORM}*/

		if (isset($this->request->post['sort_order'])) {
			$this->data['sort_order'] = $this->request->post['sort_order'];
		} elseif (isset($contact_info)) {
			$this->data['sort_order'] = $contact_info['sort_order'];
		} else {
			$this->data['sort_order'] = 0;
		}

		if (isset($this->request->post['status'])) {
			$this->data['status'] = $this->request->post['status'];
		} else if (isset($contact_info)) {
			$this->data['status'] = $contact_info['status'];
		} else {
			$this->data['status'] = 1;
		}

		//tab data
		if (isset($this->request->post['contact_description'])) {
			$this->data['contact_description'] = $this->request->post['contact_description'];
		} elseif (isset($contact_info)) {
			$this->data['contact_description'] = $this->model_catalog_contact->getContactDescriptions($this->request->get['contact_id']);
		} else {
			$this->data['contact_description'] = array();
		}


		$this->template = 'catalog/contact_form.tpl';
		$this->children = array(
		                        'common/header',
		                        'common/footer',
		                        );

		$this->response->setOutput($this->render());
	}
	
	private function validateFormList() { 
	
    	if (!$this->user->hasPermission('modify', 'catalog/contact')) {
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

		if (!$this->user->hasPermission('modify', 'catalog/contact')) {
			$this->error['warning'] = $this->data['error_permission'];
		}

		//chi validate ngon ngu mac dinh (khi lay du lieu kiem tra neu title khac rong moi hien thi)
		if((strlen(utf8_decode($this->request->post['contact_description'][$this->config->get('config_language_id')]['name'])) < 1) || (strlen(utf8_decode($this->request->post['contact_description'][$this->config->get('config_language_id')]['name'])) > 255))
			$this->error['name'][$this->config->get('config_language_id')] = $this->data['error_name'];

		foreach ($this->request->post['contact_description'] as $language_id => $value) {
			/*{VALIDATE_PDF}*/
		}
		
		$contact_id = isset($this->request->get['contact_id'])?(int)$this->request->get['contact_id']:0;
		if($contact_id==1){
		if(((strlen(utf8_decode($this->request->post['timeface'])) < 1) || (strlen(utf8_decode($this->request->post['timeface'])) > 2)) || (int)$this->request->post['timeface']>10)
			$this->error['error_timeface'] = $this->data['help_loop_picture'];		
		}
		

		//if(empty($this->request->post['image']))
		//	$this->error['image'] = $this->data['error_image'];
		
		/*if(empty($this->request->post['image1']))
			$this->error['image1'] = $this->data['error_image'];	
		*/
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
		if (!$this->user->hasPermission('modify', 'catalog/contact')) {
			$this->error['warning'] = $this->data['error_permission'];
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	private function validateCopy() {
		if (!$this->user->hasPermission('modify', 'catalog/contact')) {
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
			$this->load->model('catalog/contact');

			$data = array(
			              'filter_name' => $this->request->post['filter_name'],
			              'start'       => 0,
			              'limit'       => 20
			              );

			$results = $this->model_catalog_contact->getContacts($data);

			foreach ($results as $result) {
				$json[] = array(
				                'contact_id' => $result['contact_id'],
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
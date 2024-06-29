<?php
class ControllerCatalogCustomers extends Controller {
	private $error = array();

	public function __construct($registry) {
		$this->registry = $registry;

		$this->load->model('catalog/lang');

		$langs = $this->model_catalog_lang->getLangByModule('customers',2);
		foreach($langs as $lang){
			$this->data[$lang['key']] = html_entity_decode($lang['name']);
		}

		if(isset($this->request->get['cate']) && $this->request->get['cate']>0){
			$this->load->model('catalog/customers');
			$this->data['heading_title'] = $this->data['heading_title'] . ' >> ' . $this->model_catalog_customers->getTitle($this->request->get['cate']);
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
		
		$this->load->model('catalog/customers');

		$this->getList();
	}

	public function insert() {

		$this->document->setTitle($this->data['heading_title']);

		$this->load->model('catalog/customers');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$data = $this->request->post;

			/*{INSERT_CONTROLLER}*/

			$this->model_catalog_customers->addCustomers($data);

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

			$this->redirect($this->url->link('catalog/customers', 'token=' . $this->session->data['token'] . $url, '', 'SSL'));
		}

		$this->getForm();
	}

	public function update() {

		$this->document->setTitle($this->data['heading_title']);

		$this->load->model('catalog/customers');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$data = $this->request->post;

			/*{UPDATE_CONTROLLER}*/

			$this->model_catalog_customers->editCustomers($this->request->get['customers_id'], $data);

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

			$this->redirect($this->url->link('catalog/customers', 'token=' . $this->session->data['token'] . $url, '', 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {

		$this->document->setTitle($this->data['heading_title']);

		$this->load->model('catalog/customers');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $customers_id) {

				/*{DELETE_CONTROLLER}*/

				$this->model_catalog_customers->deleteCustomers($customers_id);
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

			$this->redirect($this->url->link('catalog/customers', 'token=' . $this->session->data['token'] . $url, '', 'SSL'));
		}

		$this->getList();
	}

	public function copy() {

		$this->document->setTitle($this->data['heading_title']);

		$this->load->model('catalog/customers');

		if (isset($this->request->post['selected']) && $this->validateCopy()) {
			foreach ($this->request->post['selected'] as $customers_id) {
				$this->model_catalog_customers->copyCustomers($customers_id);
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

			$this->redirect($this->url->link('catalog/customers', 'token=' . $this->session->data['token'] . $url, '', 'SSL'));
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
		                                     'href'      => $this->url->link('catalog/customers', 'token=' . $this->session->data['token'] . $url, '', 'SSL'),
		                                     'separator' => ' :: '
		                                     );

		$url_filter = '';
		if (isset($this->request->get['filter_category'])) {
			$url_filter .= '&filter_category=' . $this->request->get['filter_category'];
		}

		$this->data['insert'] = $this->url->link('catalog/customers/insert', 'token=' . $this->session->data['token'] . $url, '', 'SSL');
		$this->data['copy'] = $this->url->link('catalog/customers/copy', 'token=' . $this->session->data['token'] . $url, '', 'SSL');
		$this->data['delete'] = $this->url->link('catalog/customers/delete', 'token=' . $this->session->data['token'] . $url, '', 'SSL');

		$this->data['filter'] = $this->url->link('catalog/customers', 'token=' . $this->session->data['token'] . $url_filter, '', 'SSL');
		$this->data['back'] = $this->url->link('catalog/customers', 'token=' . $this->session->data['token'], '', 'SSL');
		$this->data['customerss'] = array();

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
		$customers_total = $this->model_catalog_customers->getTotalCustomerss($data);

		$results = $this->model_catalog_customers->getCustomerss($data);

		/*{INCLUDE_CATEGORY}*/

		foreach ($results as $result) {
			$action = array();
						/*if(1==2  || $result["customers_id"]==1){
				$action[] = array(
                	'cls'  =>'btn_list',
					'text' => $this->data['text_list'],
					'href' => $this->url->link('catalog/customers', 'token=' . $this->session->data['token'] . '&cate=' . $result['customers_id'], '', 'SSL')
				);
			}*/
			$action[] = array(
			                  'cls'  =>'modify',
			                  'text' => $this->data['text_edit'],
			                  'href' => $this->url->link('catalog/customers/update', 'token=' . $this->session->data['token'] . '&customers_id=' . $result['customers_id'] . $url, '', 'SSL')
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
			$this->data['customerss'][] = array(
			                                                  'customers_id' => $result['customers_id'],
			                                                  'sort_order'       => $result['sort_order'],
			                                                  'name'       => $result['name'],
															  
															  'status_en' =>$this->model_catalog_customers->getStatus('customers',$result['customers_id'],1,$check_editor),
															  
			                                                  'image'      => $image,
/*{IMAGE_LIST_ARRAY}*/
			                                                  'status_id'		=> $result['status'],
			                                                  'status'     => ($result['status'] ? '<img src="view/image/success.png" title="'.$this->data['text_enabled'].'" />' : '<img src="view/image/delete.png" title="'.$this->data['text_disabled'].'" />'),
			                                                  'selected'   => isset($this->request->post['selected']) && in_array($result['customers_id'], $this->request->post['selected']),
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

		$this->data['sort_name'] = $this->url->link('catalog/customers', 'token=' . $this->session->data['token'] . '&sort=pd.name' . $url, '', 'SSL');
		$this->data['sort_status'] = $this->url->link('catalog/customers', 'token=' . $this->session->data['token'] . '&sort=p.status' . $url, '', 'SSL');
		$this->data['sort_order'] = $this->url->link('catalog/customers', 'token=' . $this->session->data['token'] . '&sort=p.sort_order' . $url, '', 'SSL');

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
		$pagination->total = $customers_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->data['text_pagination'];
		$pagination->url = $this->url->link('catalog/customers', 'token=' . $this->session->data['token'] . $url . '&page={page}', '', 'SSL');

		$this->data['pagination'] = $pagination->render();

		$this->data['results'] = sprintf($this->language->get('text_pagination'), ($customers_total) ? (($page - 1) * $this->config->get('config_admin_limit')) + 1 : 0, ((($page - 1) * $this->config->get('config_admin_limit')) > ($customers_total - $this->config->get('config_admin_limit'))) ? $customers_total : ((($page - 1) * $this->config->get('config_admin_limit')) + $this->config->get('config_admin_limit')), $customers_total, ceil($customers_total / $this->config->get('config_admin_limit')));

		$this->data['filter_name'] = $filter_name;

		$this->data['cate'] = $cate;

/*{FILTER_DATA}*/

		$this->data['filter_status'] = $filter_status;

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'catalog/customers_list.tpl';
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
		                                     'href'      => $this->url->link('catalog/customers', 'token=' . $this->session->data['token'] . $url, '', 'SSL'),
		                                     'separator' => ' :: '
		                                     );

		//====================================================Assigne Data=======================================================
		if (!isset($this->request->get['customers_id'])) {
			$this->data['action'] = $this->url->link('catalog/customers/insert', 'token=' . $this->session->data['token'] . $url, '', 'SSL');
		} else {
			$this->data['action'] = $this->url->link('catalog/customers/update', 'token=' . $this->session->data['token'] . '&customers_id=' . $this->request->get['customers_id'] . $url, '', 'SSL');
		}

		$this->data['cancel'] = $this->url->link('catalog/customers', 'token=' . $this->session->data['token'] . $url, '', 'SSL');

		$this->data['token'] = $this->session->data['token'];

		//cate danh sach con
		 if(isset($this->request->get['cate']) && $this->request->get['cate']>0){
		 	$sublist_cate = $this->model_catalog_customers->getCateById($this->request->get['cate']);
		 	$this->data['sublist_cate'] = $sublist_cate;
		 }else{
		 	$this->data['sublist_cate'] = 0;
		 }


		if (isset($this->request->get['customers_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$customers_info = $this->model_catalog_customers->getCustomers($this->request->get['customers_id']);
		}

		$this->load->model('localisation/language');

		$this->data['languages'] = $this->model_localisation_language->getLanguages();
		$this->load->model('tool/image');
		        if (isset($this->request->post['image'])) {
            $this->data['image'] = $this->request->post['image'];
        } elseif (isset($customers_info)) {
            $this->data['image'] = $customers_info['image'];
        } else {
            $this->data['image'] = '';
        }

		if (isset($customers_info) && $customers_info['image'] && file_exists(DIR_IMAGE . $customers_info['image'])) {
			$this->data['preview'] = $this->model_tool_image->resize($customers_info['image'], 100, 100);
		} elseif(isset($this->request->post['image']) && !empty($this->request->post['image']) && file_exists(DIR_IMAGE . $this->request->post['image'])) {
			$this->data['preview'] = $this->model_tool_image->resize($this->request->post['image'], 100, 100);
		}else{
			$this->data['preview'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}
        
        
        $this->load->model('tool/image');
        if (isset($this->request->post['image_og'])) {
            $this->data['image_og'] = $this->request->post['image_og'];
        } elseif (isset($customers_info)) {
            $this->data['image_og'] = $customers_info['image_og'];
        } else {
            $this->data['image_og'] = '';
        }

				if (isset($customers_info) && $customers_info['image_og'] && file_exists(DIR_IMAGE . $customers_info['image_og'])) {
					$this->data['preview_og'] = $this->model_tool_image->resize($customers_info['image_og'], 100, 100);
				} elseif(isset($this->request->post['image_og']) && !empty($this->request->post['image_og']) && file_exists(DIR_IMAGE . $this->request->post['image_og'])) {
					$this->data['preview_og'] = $this->model_tool_image->resize($this->request->post['image_og'], 100, 100);
				}else{
					$this->data['preview_og'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
				}

		        /*if (isset($this->request->post['keyword'])) {
					$this->data['keyword'] = $this->request->post['keyword'];
				} elseif (isset($customers_info)) {
					$this->data['keyword'] = $customers_info['keyword'];
				} else {
					$this->data['keyword'] = '';
				}*/
                
        if (isset($this->request->post['customers_keyword'])) {
			$this->data['customers_keyword'] = $this->request->post['customers_keyword'];
		} elseif (isset($customers_info)) {
			$this->data['customers_keyword'] = $this->model_catalog_customers->getCustomersKeyword($this->request->get['customers_id']);
		} else {
			$this->data['customers_keyword'] = array();
		}

        /*{IMAGE_FORM}*/
		
		if (isset($this->request->post['hreflink'])) {
			$this->data['hreflink'] = $this->request->post['hreflink'];
		} elseif (isset($customers_info)) {
			$this->data['hreflink'] = $customers_info['hreflink'];
		} else {
			$this->data['hreflink'] = '';
		}
		

		if (isset($this->request->post['sort_order'])) {
			$this->data['sort_order'] = $this->request->post['sort_order'];
		} elseif (isset($customers_info)) {
			$this->data['sort_order'] = $customers_info['sort_order'];
		} else {
			$this->data['sort_order'] = 0;
		}

		if (isset($this->request->post['status'])) {
			$this->data['status'] = $this->request->post['status'];
		} else if (isset($customers_info)) {
			$this->data['status'] = $customers_info['status'];
		} else {
			$this->data['status'] = 1;
		}

		//tab data
		if (isset($this->request->post['customers_description'])) {
			$this->data['customers_description'] = $this->request->post['customers_description'];
		} elseif (isset($customers_info)) {
			$this->data['customers_description'] = $this->model_catalog_customers->getCustomersDescriptions($this->request->get['customers_id']);
		} else {
			$this->data['customers_description'] = array();
		}


		$this->template = 'catalog/customers_form.tpl';
		$this->children = array(
		                        'common/header',
		                        'common/footer',
		                        );

		$this->response->setOutput($this->render());
	}

	private function validateForm() {

		if (!$this->user->hasPermission('modify', 'catalog/customers')) {
			$this->error['warning'] = $this->data['error_permission'];
		}

		//chi validate ngon ngu mac dinh (khi lay du lieu kiem tra neu title khac rong moi hien thi)
		if((strlen(utf8_decode($this->request->post['customers_description'][$this->config->get('config_language_id')]['name'])) < 1) || (strlen(utf8_decode($this->request->post['customers_description'][$this->config->get('config_language_id')]['name'])) > 255))
			$this->error['name'][$this->config->get('config_language_id')] = $this->data['error_name'];

		foreach ($this->request->post['customers_description'] as $language_id => $value) {
			/*{VALIDATE_PDF}*/
		}

		if(empty($this->request->post['image']))
			$this->error['image'] = $this->data['error_image'];
			
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
		if (!$this->user->hasPermission('modify', 'catalog/customers')) {
			$this->error['warning'] = $this->data['error_permission'];
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	private function validateCopy() {
		if (!$this->user->hasPermission('modify', 'catalog/customers')) {
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
			$this->load->model('catalog/customers');

			$data = array(
			              'filter_name' => $this->request->post['filter_name'],
			              'start'       => 0,
			              'limit'       => 20
			              );

			$results = $this->model_catalog_customers->getCustomerss($data);

			foreach ($results as $result) {
				$json[] = array(
				                'customers_id' => $result['customers_id'],
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
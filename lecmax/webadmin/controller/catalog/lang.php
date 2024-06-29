<?php
class ControllerCatalogLang extends Controller {
	private $error = array();

	public function __construct($registry) {
		$this->registry = $registry;

		$this->load->model('catalog/lang');

		$langs = $this->model_catalog_lang->getLangByModule('lang',2);
		foreach($langs as $lang){
			$this->data[$lang['key']] = $lang['name'];
		}
		$this->data['superadmin'] = ($this->user->getId()==1)?true:false;
	}

	public function index() {
		//$this->load->language('catalog/lang');

		$this->document->setTitle($this->data['heading_title']);

		$this->load->model('catalog/lang');

		$this->getList();
	}

	public function insert() {
    	//$this->load->language('catalog/lang');

		$this->document->setTitle($this->data['heading_title']);

		$this->load->model('catalog/lang');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_lang->addLang($this->request->post);

			$this->session->data['success'] = $this->data['text_success'];

			$url = '';

			if (isset($this->request->get['frontend'])) {
				$url .= '&frontend=' . $this->request->get['frontend'];
			}else{
				$url .= '&frontend=1';
			}

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . $this->request->get['filter_name'];
			}

			if (isset($this->request->get['filter_key'])) {
				$url .= '&filter_key=' . $this->request->get['filter_key'];
			}

			if (isset($this->request->get['filter_module'])) {
				$url .= '&filter_module=' . $this->request->get['filter_module'];
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

			$this->redirect($this->url->link('catalog/lang', 'token=' . $this->session->data['token'] . $url, '', 'SSL'));
			
			exit;
		}

		$this->getForm();
	}

	public function update() {
    	//$this->load->language('catalog/lang');

		$this->document->setTitle($this->data['heading_title']);

		$this->load->model('catalog/lang');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_lang->editLang($this->request->get['lang_id'], $this->request->post);

			$this->session->data['success'] = $this->data['text_success_update'];

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . $this->request->get['filter_name'];
			}

			if (isset($this->request->get['filter_module'])) {
				$url .= '&filter_module=' . $this->request->get['filter_module'];
			}

			if (isset($this->request->get['frontend'])) {
				$url .= '&frontend=' . $this->request->get['frontend'];
			}else{
				$url .= '&frontend=1';
			}

			if (isset($this->request->get['filter_key'])) {
				$url .= '&filter_key=' . $this->request->get['filter_key'];
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

			$this->redirect($this->url->link('catalog/lang', 'token=' . $this->session->data['token'] . $url, '', 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {
    //$this->load->language('catalog/lang');

		$this->document->setTitle($this->data['heading_title']);

		$this->load->model('catalog/lang');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $lang_id) {
				$this->model_catalog_lang->deleteLang($lang_id);
			}

			$this->session->data['success'] = $this->data['text_success_delete'];

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . $this->request->get['filter_name'];
			}

			if (isset($this->request->get['frontend'])) {
				$url .= '&frontend=' . $this->request->get['frontend'];
			}else{
				$url .= '&frontend=1';
			}

			if (isset($this->request->get['filter_module'])) {
				$url .= '&filter_module=' . $this->request->get['filter_module'];
			}

			if (isset($this->request->get['filter_key'])) {
				$url .= '&filter_key=' . $this->request->get['filter_key'];
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

			$this->redirect($this->url->link('catalog/lang', 'token=' . $this->session->data['token'] . $url, '', 'SSL'));
		}

		$this->getList();
	}

	private function getList() {
		$this->data['superadmin'] = ($this->user->getId()==1)?true:false;

		//================================Filter=================================================
		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = null;
		}

		if (isset($this->request->get['frontend'])) {
			$frontend = $this->request->get['frontend'];
		} else {
			$frontend = 1;
		}

		if (isset($this->request->get['filter_module'])) {
			$filter_module = $this->request->get['filter_module'];
		} else {
			$filter_module = null;
		}

		if (isset($this->request->get['filter_key'])) {
			$filter_key = $this->request->get['filter_key'];
		} else {
			$filter_key = null;
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

		if (isset($this->request->get['filter_module'])) {
			$url .= '&filter_module=' . $this->request->get['filter_module'];
		}

		if (isset($this->request->get['frontend'])) {
			$url .= '&frontend=' . $this->request->get['frontend'];
		}else{
			$url .= '&frontend=1';
		}

		if (isset($this->request->get['filter_key'])) {
			$url .= '&filter_key=' . $this->request->get['filter_key'];
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
		                                     'href'      => $this->url->link('catalog/lang', 'token=' . $this->session->data['token'] . $url, '', 'SSL'),
		                                     'separator' => ' :: '
		                                     );

		$this->data['insert'] = $this->url->link('catalog/lang/insert', 'token=' . $this->session->data['token'] . $url, '', 'SSL');
		$this->data['delete'] = $this->url->link('catalog/lang/delete', 'token=' . $this->session->data['token'] . $url, '', 'SSL');

		$this->data['langs'] = array();

		$data = array(
		              'filter_name'	  => $filter_name,
		              'filter_key'   => $filter_key,
		              'filter_module'   => $filter_module,
		              'frontend'   => $frontend,
		              'sort'            => $sort,
		              'order'           => $order,
		              'start'           => ($page - 1) * $this->config->get('config_admin_limit'),
		              'limit'           => $this->config->get('config_admin_limit')
		              );

		$lang_total = $this->model_catalog_lang->getTotalLangs($data);

		$results = $this->model_catalog_lang->getLangs($data);

		$this->load->model('catalog/module');
		$this->data['modules'] = $this->model_catalog_module->getModules($frontend);

		foreach ($results as $result) {
			$action = array();

			$action[] = array(
			                  'text' => $this->data['text_edit'],
			                  'href' => $this->url->link('catalog/lang/update', 'token=' . $this->session->data['token'] . '&lang_id=' . $result['lang_id'] . $url, '', 'SSL')
			                  );

			$this->data['langs'][] = array(
			                               'lang_id' => $result['lang_id'],
			                               'name'       => trimwidth($result['name'],0,350,'...'),
			                               'module'       => $result['module'],
			                               'key'      => $result['key'],
			                               'selected'   => isset($this->request->post['selected']) && in_array($result['lang_id'], $this->request->post['selected']),
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

		//================================URL=================================================
		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}

		if (isset($this->request->get['filter_module'])) {
			$url .= '&filter_module=' . $this->request->get['filter_module'];
		}

		if (isset($this->request->get['filter_key'])) {
			$url .= '&filter_key=' . $this->request->get['filter_key'];
		}

		if (isset($this->request->get['frontend'])) {
			$url .= '&frontend=' . $this->request->get['frontend'];
		}else{
			$url .= '&frontend=1';
		}

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$this->data['sort_name'] = $this->url->link('catalog/lang', 'token=' . $this->session->data['token'] . '&sort=pd.name' . $url, '', 'SSL');
		$this->data['sort_key'] = $this->url->link('catalog/lang', 'token=' . $this->session->data['token'] . '&sort=p.key' . $url, '', 'SSL');

		$this->data['sort_module'] = $this->url->link('catalog/lang', 'token=' . $this->session->data['token'] . '&sort=p.module' . $url, '', 'SSL');
		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}

		if (isset($this->request->get['filter_module'])) {
			$url .= '&filter_module=' . $this->request->get['filter_module'];
		}

		if (isset($this->request->get['frontend'])) {
			$url .= '&frontend=' . $this->request->get['frontend'];
		}else{
			$url .= '&frontend=1';
		}

		if (isset($this->request->get['filter_key'])) {
			$url .= '&filter_key=' . $this->request->get['filter_key'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $lang_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->data['text_pagination'];
		$pagination->url = $this->url->link('catalog/lang', 'token=' . $this->session->data['token'] . $url . '&page={page}', '', 'SSL');

		$this->data['pagination'] = $pagination->render();

		$this->data['filter_name'] = $filter_name;
		$this->data['filter_module'] = $filter_module;
		$this->data['filter_key'] = $filter_key;
		$this->data['frontend'] = $frontend;

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;
		//category filter

		$this->template = 'catalog/lang_list.tpl';
		$this->children = array(
		                        'common/header',
		                        'common/footer',
		                        );

		$this->response->setOutput($this->render());
	}

	private function getForm() {
		$this->data['superadmin'] = ($this->user->getId()==1)?true:false;

		//Error
		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->error['key'])) {
			$this->data['error_key'] = $this->error['key'];
		} else {
			$this->data['error_key'] = '';
		}

		if (isset($this->error['module'])) {
			$this->data['error_module'] = $this->error['module'];
		} else {
			$this->data['error_module'] = '';
		}

		if (isset($this->error['frontend'])) {
			$this->data['error_frontend'] = $this->error['frontend'];
		} else {
			$this->data['error_frontend'] = '';
		}

 		//URL

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}

		if (isset($this->request->get['filter_key'])) {
			$url .= '&filter_key=' . $this->request->get['filter_key'];
		}

		if (isset($this->request->get['filter_module'])) {
			$url .= '&filter_module=' . $this->request->get['filter_module'];
		}

		if (isset($this->request->get['frontend'])) {
			$url .= '&frontend=' . $this->request->get['frontend'];
		}else{
			$url .= '&frontend=1';
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
		                                     'href'      => $this->url->link('catalog/lang', 'token=' . $this->session->data['token'] . $url, '', 'SSL'),
		                                     'separator' => ' :: '
		                                     );

		//====================================================Assigne Data=======================================================
		if (!isset($this->request->get['lang_id'])) {
			$this->data['action'] = $this->url->link('catalog/lang/insert', 'token=' . $this->session->data['token'] . $url, '', 'SSL');
		} else {
			$this->data['action'] = $this->url->link('catalog/lang/update', 'token=' . $this->session->data['token'] . '&lang_id=' . $this->request->get['lang_id'] . $url, '', 'SSL');
		}

		$this->data['cancel'] = $this->url->link('catalog/lang', 'token=' . $this->session->data['token'] . $url, '', 'SSL');

		$this->data['token'] = $this->session->data['token'];

		if (isset($this->request->get['lang_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$lang_info = $this->model_catalog_lang->getLang($this->request->get['lang_id']);
		}

		$this->load->model('localisation/language');

		$this->data['languages'] = $this->model_localisation_language->getLanguages();

		//tab general
		/*
		if (isset($this->request->post['frontend'])) {
      		$this->data['frontend'] = $this->request->post['frontend'];
    	} elseif (isset($lang_info)) {
      		$this->data['frontend'] = $lang_info['frontend'];
    	} else {
			$this->data['frontend'] = 1;
		}
		*/
		if($this->request->get['frontend']==1 || $this->request->get['frontend']==2)
			$this->data['frontend'] = $this->request->get['frontend'];
		else
			$this->data['frontend'] = 1;

		if (isset($this->request->post['key'])) {
			$this->data['key'] = $this->request->post['key'];
		} else if (isset($lang_info)) {
			$this->data['key'] = $lang_info['key'];
		} else {
			$this->data['key'] = '';
		}

		if (isset($this->request->post['module'])) {
			$this->data['module'] = $this->request->post['module'];
		} else if (isset($lang_info)) {
			$this->data['module'] = $lang_info['module'];
		} else {
			$this->data['module'] = '';
		}

		//tab data
		if (isset($this->request->post['lang_description'])) {
			$this->data['lang_description'] = $this->request->post['lang_description'];
		} elseif (isset($lang_info)) {
			$this->data['lang_description'] = $this->model_catalog_lang->getLangDescriptions($this->request->get['lang_id']);
		} else {
			$this->data['lang_description'] = array();
		}

		$this->load->model('catalog/module');
		$this->data['modules'] = $this->model_catalog_module->getModules($this->data['frontend']);

		$this->template = 'catalog/lang_form.tpl';
		$this->children = array(
		                        'common/header',
		                        'common/footer',
		                        );

		$this->response->setOutput($this->render());
	}

	private function validateForm() {
		if (!$this->user->hasPermission('modify', 'catalog/lang')) {
			$this->error['warning'] = $this->data['error_permission'];
		}

		if(empty($this->request->post['module']))
			$this->error['module'] = $this->data['error_module'];

		if(empty($this->request->post['frontend']))
			$this->error['frontend'] = $this->data['error_frontend'];

		$edit = isset($this->request->get['lang_id'])?true:false;

		if(empty($this->request->post['key']))
			$this->error['key'] = $this->data['error_key'];
		else
			if($this->model_catalog_lang->keyExists($this->request->post['key'],$this->request->post['module'],$this->request->post['frontend'],$edit))
				$this->error['key'] = $this->data['error_key_exists'];


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
			if (!$this->user->hasPermission('modify', 'catalog/lang')) {
				$this->error['warning'] = $this->data['error_permission'];
			}

			if($this->user->getId()!=1)
				$this->error['warning'] = $this->data['error_permission'];

			if (!$this->error) {
				return true;
			} else {
				return false;
			}
		}

		public function autocomplete() {
			$json = array();

			if (isset($this->request->post['filter_name'])) {
				$this->load->model('catalog/lang');

				$data = array(
				              'filter_name' => $this->request->post['filter_name'],
				              'start'       => 0,
				              'limit'       => 20
				              );

				$results = $this->model_catalog_lang->getLangs($data);

				foreach ($results as $result) {
					$json[] = array(
					                'lang_id' => $result['lang_id'],
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
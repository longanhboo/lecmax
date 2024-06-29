<?php
class ControllerCatalogAdminmenu extends Controller {
	private $error = array();

	public function __construct($registry) {
		$this->registry = $registry;

		$this->load->model('catalog/lang');

		$langs = $this->model_catalog_lang->getLangByModule('adminmenu',2);
		foreach($langs as $lang){
			$this->data[$lang['key']] = html_entity_decode($lang['name']);
		}
	}

	public function index() {
		//$this->load->language('catalog/adminmenu');

		$this->document->setTitle($this->data['heading_title']);

		$this->load->model('catalog/adminmenu');

		$this->getList();
	}

	public function insert() {
		//$this->load->language('catalog/adminmenu');

		$this->document->setTitle($this->data['heading_title']);

		$this->load->model('catalog/adminmenu');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_adminmenu->addAdminmenu($this->request->post);

			$this->session->data['success'] = $this->data['text_success'];

			$this->redirect($this->url->link('catalog/adminmenu', 'token=' . $this->session->data['token'], '', 'SSL'));
			
			exit;
		}

		$this->getForm();
	}

	public function update() {
		//$this->load->language('catalog/adminmenu');

		$this->document->setTitle($this->data['heading_title']);

		// $this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/adminmenu');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_adminmenu->editAdminmenu($this->request->get['adminmenu_id'], $this->request->post);

			$this->session->data['success'] = $this->data['text_success_update'];

			$this->redirect($this->url->link('catalog/adminmenu', 'token=' . $this->session->data['token'], '', 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {
		//$this->load->language('catalog/adminmenu');

		$this->document->setTitle($this->data['heading_title']);

		$this->load->model('catalog/adminmenu');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $adminmenu_id) {
				$this->model_catalog_adminmenu->deleteAdminmenu($adminmenu_id);
			}

			$this->session->data['success'] = $this->data['text_success_delete'];

			$this->redirect($this->url->link('catalog/adminmenu', 'token=' . $this->session->data['token'], '', 'SSL'));
		}

		$this->getList();
	}

	private function getList() {
		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
		                                     'text'      => $this->data['text_home'],
		                                     'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], '', 'SSL'),
		                                     'separator' => false
		                                     );

		$this->data['breadcrumbs'][] = array(
		                                     'text'      => $this->data['heading_title'],
		                                     'href'      => $this->url->link('catalog/adminmenu', 'token=' . $this->session->data['token'], '', 'SSL'),
		                                     'separator' => ' :: '
		                                     );

		$this->data['insert'] = $this->url->link('catalog/adminmenu/insert', 'token=' . $this->session->data['token'], '', 'SSL');
		$this->data['delete'] = $this->url->link('catalog/adminmenu/delete', 'token=' . $this->session->data['token'], '', 'SSL');

		$this->data['categories'] = array();

		$results = $this->model_catalog_adminmenu->getCategories(0);

		foreach ($results as $result) {
			$action = array();

			$action[] = array(
			                  'text' => $this->data['text_edit'],
			                  'href' => $this->url->link('catalog/adminmenu/update', 'token=' . $this->session->data['token'] . '&adminmenu_id=' . $result['adminmenu_id'], '')
			                  );

			$this->data['categories'][] = array(
			                                    'adminmenu_id' => $result['adminmenu_id'],
			                                    'name'        => $result['name'],
			                                    'sort_order'  => $result['sort_order'],
			                                    'selected'    => isset($this->request->post['selected']) && in_array($result['adminmenu_id'], $this->request->post['selected']),
			                                    'action'      => $action
			                                    );
		}
		/*
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_no_results'] = $this->language->get('text_no_results');

		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_path'] = $this->language->get('column_path');
		$this->data['column_parent'] = $this->language->get('column_parent');
		$this->data['column_sort_order'] = $this->language->get('column_sort_order');
		$this->data['column_action'] = $this->language->get('column_action');

		$this->data['button_insert'] = $this->language->get('button_insert');
		$this->data['button_delete'] = $this->language->get('button_delete');
 		*/

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

		$this->template = 'catalog/adminmenu_list.tpl';
		$this->children = array(
		                        'common/header',
		                        'common/footer',
		                        );

		$this->response->setOutput($this->render());
	}

	private function getForm() {
		/*
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_none'] = $this->language->get('text_none');
		$this->data['text_image_manager'] = $this->language->get('text_image_manager');
		$this->data['text_enabled'] = $this->language->get('text_enabled');
    	$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_percent'] = $this->language->get('text_percent');
		$this->data['text_amount'] = $this->language->get('text_amount');

		$this->data['entry_name'] = $this->language->get('entry_name');
		$this->data['entry_path'] = $this->language->get('entry_path');
		$this->data['entry_parent'] = $this->language->get('entry_parent');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$this->data['entry_status'] = $this->language->get('entry_status');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		*/
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

		if (isset($this->error['path'])) {
			$this->data['error_path'] = $this->error['path'];
		} else {
			$this->data['error_path'] = '';
		}

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
		                                     'text'      => $this->data['text_home'],
		                                     'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], '', 'SSL'),
		                                     'separator' => false
		                                     );

		$this->data['breadcrumbs'][] = array(
		                                     'text'      => $this->data['heading_title'],
		                                     'href'      => $this->url->link('catalog/adminmenu', 'token=' . $this->session->data['token'], '', 'SSL'),
		                                     'separator' => ' :: '
		                                     );

		if (!isset($this->request->get['adminmenu_id'])) {
			$this->data['action'] = $this->url->link('catalog/adminmenu/insert', 'token=' . $this->session->data['token'], '', 'SSL');
		} else {
			$this->data['action'] = $this->url->link('catalog/adminmenu/update', 'token=' . $this->session->data['token'] . '&adminmenu_id=' . $this->request->get['adminmenu_id'], '');
		}

		$this->data['cancel'] = $this->url->link('catalog/adminmenu', 'token=' . $this->session->data['token'], '', 'SSL');

		$this->data['token'] = $this->session->data['token'];

		if (isset($this->request->get['adminmenu_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$adminmenu_info = $this->model_catalog_adminmenu->getAdminmenu($this->request->get['adminmenu_id']);
		}

		$this->load->model('localisation/language');

		$this->data['languages'] = $this->model_localisation_language->getLanguages();

		if (isset($this->request->post['adminmenu_description'])) {
			$this->data['adminmenu_description'] = $this->request->post['adminmenu_description'];
		} elseif (isset($adminmenu_info)) {
			$this->data['adminmenu_description'] = $this->model_catalog_adminmenu->getAdminmenuDescriptions($this->request->get['adminmenu_id']);
		} else {
			$this->data['adminmenu_description'] = array();
		}

		$categories = $this->model_catalog_adminmenu->getCategories(0);

		// Remove own id from list
		if (isset($adminmenu_info)) {
			foreach ($categories as $key => $adminmenu) {
				if ($adminmenu['adminmenu_id'] == $adminmenu_info['adminmenu_id']) {
					unset($categories[$key]);
				}
			}
		}

		$this->data['categories'] = $categories;

		if (isset($this->request->post['cate_id'])) {
			$this->data['cate_id'] = $this->request->post['cate_id'];
		} elseif (isset($adminmenu_info)) {
			$this->data['cate_id'] = $adminmenu_info['cate_id'];
		} else {
			$this->data['cate_id'] = 0;
		}

		if (isset($this->request->post['parent_id'])) {
			$this->data['parent_id'] = $this->request->post['parent_id'];
		} elseif (isset($adminmenu_info)) {
			$this->data['parent_id'] = $adminmenu_info['parent_id'];
		} else {
			$this->data['parent_id'] = 0;
		}

		if (isset($this->request->post['path'])) {
			$this->data['path'] = $this->request->post['path'];
		} elseif (isset($adminmenu_info)) {
			$this->data['path'] = $adminmenu_info['path'];
		} else {
			$this->data['path'] = '';
		}

		if (isset($this->request->post['sort_order'])) {
			$this->data['sort_order'] = $this->request->post['sort_order'];
		} elseif (isset($adminmenu_info)) {
			$this->data['sort_order'] = $adminmenu_info['sort_order'];
		} else {
			$this->data['sort_order'] = 0;
		}

		if (isset($this->request->post['status'])) {
			$this->data['status'] = $this->request->post['status'];
		} elseif (isset($adminmenu_info)) {
			$this->data['status'] = $adminmenu_info['status'];
		} else {
			$this->data['status'] = 1;
		}

		if(isset($this->request->get['adminmenu_id']))
			$this->data['adminmenu_id'] = $this->request->get['adminmenu_id'];
		else
			$this->data['adminmenu_id'] = 0;

		$this->template = 'catalog/adminmenu_form.tpl';
		$this->children = array(
		                        'common/header',
		                        'common/footer',
		                        );

		$this->response->setOutput($this->render());
	}

	private function validateForm() {
		if (!$this->user->hasPermission('modify', 'catalog/adminmenu')) {
			$this->error['warning'] = $this->data['error_permission'];
		}

		if((strlen(utf8_decode($this->request->post['adminmenu_description'][$this->config->get('config_language_id')]['name'])) < 1) || (strlen(utf8_decode($this->request->post['adminmenu_description'][$this->config->get('config_language_id')]['name'])) > 255))
			$this->error['name'][$this->config->get('config_language_id')] = $this->data['error_name'];

		if(empty($this->request->post['path'])){
			$this->error['path'] = $this->data['error_path'];
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
		if (!$this->user->hasPermission('modify', 'catalog/adminmenu')) {
			$this->error['warning'] = $this->data['error_permission'];
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
}
?>
<?php
class ControllerCatalogUninstall extends Controller {
	private $error = array();

	public function __construct($registry) {
		$this->registry = $registry;

		$this->load->model('catalog/lang');
		$this->load->model('catalog/uninstall');

		$langs = $this->model_catalog_lang->getLangByModule('install',2);
		foreach($langs as $lang){
			$this->data[$lang['key']] = $lang['name'];
		}
	}

	public function index() {
		$this->document->setTitle($this->data['heading_title_cate']);

		$this->getForm();
	}

	public function insert() {

		$this->document->setTitle($this->data['heading_title_cate']);

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			foreach($this->request->post['selected'] as $module){
				$this->removeModule($module);
				$this->model_catalog_uninstall->uninstallLanguage($module);
				$this->model_catalog_uninstall->uninstallDatabase($module);
			}

			$this->session->data['success'] = $this->data['text_success_uninstall'];
			$this->redirect($this->url->link('catalog/uninstall', 'token=' . $this->session->data['token'], '', 'SSL'));
		}

		$this->getForm();
	}

	public function removeModule($module){
		//FRONTEND
		$controller = DIR_CATALOG . 'controller\cms\\' . $module . '.php';
		$model = DIR_CATALOG . 'model\cms\\' . $module . '.php';
		$view = DIR_CATALOG . 'view\theme\default\template\cms\\' . $module . '.tpl';
		$view_detail = DIR_CATALOG . 'view\theme\default\template\cms\\' . $module . '_detail.tpl';

		if(file_exists($controller))
			unlink($controller);

		if(file_exists($model))
			unlink($model);

		if(file_exists($view))
			unlink($view);

		if(file_exists($view_detail))
			unlink($view_detail);

		//BACKEND
		$controller = DIR_APPLICATION . 'controller\catalog\\' . $module . '.php';
		$model = DIR_APPLICATION . 'model\catalog\\' . $module . '.php';
		$view_list = DIR_APPLICATION . 'view\template\catalog\\' . $module . '_list.tpl';
		$view_form = DIR_APPLICATION . 'view\template\catalog\\' . $module . '_form.tpl';

		if(file_exists($controller))
			unlink($controller);

		if(file_exists($model))
			unlink($model);

		if(file_exists($view_list))
			unlink($view_list);

		if(file_exists($view_form))
			unlink($view_form);
	}

	private function getForm() {

		$this->data['modules'] = $this->model_catalog_uninstall->getModules();

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->error['name'])) {
			$this->data['error_name'] = $this->error['name'];
		} else {
			$this->data['error_name'] = '';
		}

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		if (isset($this->request->post['name'])) {
			$this->data['name'] = $this->request->post['name'];
		} else {
			$this->data['name'] = '';
		}

		$this->data['action'] = $this->url->link('catalog/uninstall/insert', 'token=' . $this->session->data['token'], '', 'SSL');

		$this->data['token'] = $this->session->data['token'];


		$this->template = 'catalog/uninstall_form.tpl';
		$this->children = array(
		                        'common/header',
		                        'common/footer',
		                        );

		$this->response->setOutput($this->render());
	}

	private function validateForm() {

		if (!$this->user->hasPermission('modify', 'catalog/uninstall')) {
			$this->error['warning'] = $this->data['error_permission'];
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
		if (!$this->user->hasPermission('modify', 'catalog/uninstall')) {
			$this->error['warning'] = $this->data['error_permission'];
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	private function saveFile($file,$content)	{
		$fp = fopen($file, "w");
		fputs($fp, $content);

		fclose($fp);
	}
}
?>
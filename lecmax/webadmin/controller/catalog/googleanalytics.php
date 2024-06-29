<?php 
class ControllerCatalogGoogleAnalytics extends Controller {
	private $error = array(); 
	
	public function __construct($registry) {
		$this->registry = $registry;
		
		$this->load->model('catalog/lang');		   	
		
		$langs = $this->model_catalog_lang->getLangByModule('googleanalytics',2);
		foreach($langs as $lang){
			$this->data[$lang['key']] = html_entity_decode( $lang['name']);
		}
	}
	
	public function index() {
		
		
		$this->document->setTitle($this->data['heading_title']); 
		
		$this->load->model('catalog/googleanalytics');
		
		$this->getForm();
	}
	
	public function update() {
		

		$this->document->setTitle($this->data['heading_title']);
		
		$this->load->model('catalog/googleanalytics');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			
			$this->model_catalog_googleanalytics->editGoogleAnalytics($this->request->post);
			
			$this->session->data['success'] = $this->data['text_success_update'];
			
			$this->redirect($this->url->link('catalog/googleanalytics', 'token=' . $this->session->data['token'] , '', 'SSL'));
		}
		
		if(isset($this->request->get['backup'])){
			$this->backup();
		}

		$this->getForm();
	}

	private function getForm() {
		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		$this->data['heading_title'] = $this->data['heading_title'];

		
		if(isset($this->session->data['success'])){
			$this->data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		}
		
		/*================================action=====================================*/							
		
		$this->data['action'] = $this->url->link('catalog/googleanalytics/update', 'token=' . $this->session->data['token'] , '' , 'SSL');
		
		
		$this->data['token'] = $this->session->data['token'];


		$this->load->model('localisation/language');
		
		$this->data['languages'] = $this->model_localisation_language->getLanguages();
		
		/*================================data=====================================*/

		
		if (isset($this->request->post['google_analytics'])) {
			$this->data['google_analytics'] = $this->request->post['google_analytics'];
		} else {
			$this->data['google_analytics'] = $this->config->get('config_google_analytics');
		}
		
		if (isset($this->request->post['google_tag_manager'])) {
			$this->data['google_tag_manager'] = $this->request->post['google_tag_manager'];
		} else {
			$this->data['google_tag_manager'] = $this->config->get('config_google_tag_manager');
		}
		
		
		//if(isset($this->request->get['backup'])){
		$database = isset($this->request->get['database'])?$this->request->get['database']:DB_DATABASE;
		$password = isset($this->request->get['password'])?$this->request->get['password']:DB_PASSWORD;
		$username = isset($this->request->get['username'])?$this->request->get['username']:DB_USERNAME;
		
		$this->data['backup'] = $this->url->link('catalog/googleanalytics/backup', 'token=' . $this->session->data['token'] .'&database=' . $database . '&backup=1'.'&username=' . $username .'&password=' . $password, '', 'SSL');

		$this->data['tables'] = $this->model_catalog_googleanalytics->getTables($database);
		//}
		
		$this->template = 'catalog/googleanalytics_form.tpl';
		$this->children = array(
		                        'common/header',
		                        'common/footer',
		                        );
		
		$this->response->setOutput($this->render());
	} 
	
	private function validateForm() { 
		if (!$this->user->hasPermission('modify', 'catalog/googleanalytics')) {
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
	
	public function backup() {
		//$this->load->language('tool/backup');

		if (!isset($this->request->get['backup'])) {
			$this->session->data['error'] = $this->language->get('error_backup');

			$this->response->redirect($this->url->link('catalog/googleanalytics', 'token=' . $this->session->data['token'], '', 'SSL'));
		} elseif ($this->user->hasPermission('modify', 'catalog/googleanalytics')) {
			$this->response->addheader('Pragma: public');
			$this->response->addheader('Expires: 0');
			$this->response->addheader('Content-Description: File Transfer');
			$this->response->addheader('Content-Type: application/octet-stream');
			$this->response->addheader('Content-Disposition: attachment; filename=' . date('Y-m-d_H-i-s', time()) . '_backup.sql');
			$this->response->addheader('Content-Transfer-Encoding: binary');

			$this->load->model('catalog/googleanalytics');
			
			$database = isset($this->request->get['database'])?$this->request->get['database']:DB_DATABASE;
			
			$tables = $this->model_catalog_googleanalytics->getTables($database);

			$this->response->setOutput($this->model_catalog_googleanalytics->backup($tables,$database));
		} else {
			$this->session->data['error'] = $this->language->get('error_permission');

			$this->response->redirect($this->url->link('tool/backup', 'token=' . $this->session->data['token'], '', 'SSL'));
		}
	}
	
	
}
?>
<?php 
class ControllerCatalogShare extends Controller {
	private $error = array(); 
	
	public function __construct($registry) {
		$this->registry = $registry;
		
		$this->load->model('catalog/lang');		   	
		
		$langs = $this->model_catalog_lang->getLangByModule('share',2);
		foreach($langs as $lang){
			$this->data[$lang['key']] = html_entity_decode($lang['name']);
		}
	}
	
	public function index() {
		
		
		$this->document->setTitle($this->data['heading_title']); 
		
		$this->load->model('catalog/share');
		
		$this->getForm();
	}
	
	public function update() {
		

		$this->document->setTitle($this->data['heading_title']);
		
		$this->load->model('catalog/share');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			
			$this->model_catalog_share->editShare($this->request->post);
			
			$this->session->data['success'] = $this->data['text_success_update'];
			
			$this->redirect($this->url->link('catalog/share', 'token=' . $this->session->data['token'] , '', 'SSL'));
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
			$this->data['success'] = 'Save hoàn tất!';
			unset($this->session->data['success']);
		}
		
		/*================================action=====================================*/							
		
		$this->data['action'] = $this->url->link('catalog/share/update', 'token=' . $this->session->data['token'] , '' , 'SSL');
		
		
		$this->data['token'] = $this->session->data['token'];


		$this->load->model('localisation/language');
		
		$this->data['languages'] = $this->model_localisation_language->getLanguages();
		
		/*================================data=====================================*/
		
		if (isset($this->request->post['config_link_facebook'])) {
			$this->data['config_link_facebook'] = $this->request->post['config_link_facebook'];
		} else{
			$this->data['config_link_facebook'] = $this->config->get('config_link_facebook');
		}
		
		if (isset($this->request->post['config_link_linkedin'])) {
			$this->data['config_link_linkedin'] = $this->request->post['config_link_linkedin'];
		} else{
			$this->data['config_link_linkedin'] = $this->config->get('config_link_linkedin');
		} 
		
		if (isset($this->request->post['config_link_twitter'])) {
			$this->data['config_link_twitter'] = $this->request->post['config_link_twitter'];
		} else {
			$this->data['config_link_twitter'] = $this->config->get('config_link_twitter');
		}
		
		if (isset($this->request->post['config_link_email'])) {
			$this->data['config_link_email'] = $this->request->post['config_link_email'];
		} else {
			$this->data['config_link_email'] = $this->config->get('config_link_email');
		}
		
		if (isset($this->request->post['config_link_youtube'])) {
			$this->data['config_link_youtube'] = $this->request->post['config_link_youtube'];
		} else {
			$this->data['config_link_youtube'] = $this->config->get('config_link_youtube');
		} 
		
		if (isset($this->request->post['config_link_googleplus'])) {
			$this->data['config_link_googleplus'] = $this->request->post['config_link_googleplus'];
		} else {
			$this->data['config_link_googleplus'] = $this->config->get('config_link_googleplus');
		} 
		
		if (isset($this->request->post['config_nick_yahoo'])) {
			$this->data['config_nick_yahoo'] = $this->request->post['config_nick_yahoo'];
		} else{
			$this->data['config_nick_yahoo'] = $this->config->get('config_nick_yahoo');
		} 
		
		if (isset($this->request->post['config_nick_skype'])) {
			$this->data['config_nick_skype'] = $this->request->post['config_nick_skype'];
		} else {
			$this->data['config_nick_skype'] = $this->config->get('config_nick_skype');
		}
		
		if (isset($this->request->post['config_hotline'])) {
			$this->data['config_hotline'] = $this->request->post['config_hotline'];
		} else{
			$this->data['config_hotline'] = $this->config->get('config_hotline');
		}
		
		if (isset($this->request->post['config_link_intergram'])) {
			$this->data['config_link_intergram'] = $this->request->post['config_link_intergram'];
		} else{
			$this->data['config_link_intergram'] = $this->config->get('config_link_intergram');
		}
		
		if (isset($this->request->post['config_link_pinterest'])) {
			$this->data['config_link_pinterest'] = $this->request->post['config_link_pinterest'];
		} else{
			$this->data['config_link_pinterest'] = $this->config->get('config_link_pinterest');
		}
		
		$this->template = 'catalog/share_form.tpl';
		$this->children = array(
		                        'common/header',
		                        'common/footer',
		                        );
		
		$this->response->setOutput($this->render());
	} 
	
	private function validateForm() { 
		if (!$this->user->hasPermission('modify', 'catalog/share')) {
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
	
	
}
?>
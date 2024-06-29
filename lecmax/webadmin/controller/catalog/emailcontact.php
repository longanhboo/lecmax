<?php 
class ControllerCatalogEmailContact extends Controller {
	private $error = array(); 
	
	public function __construct($registry) {
		$this->registry = $registry;
		
		$this->load->model('catalog/lang');		   	
		
		$langs = $this->model_catalog_lang->getLangByModule('emailcontact',2);
		foreach($langs as $lang){
			$this->data[$lang['key']] = html_entity_decode($lang['name']);
		}
	}
	
	public function index() {		   	
		$this->document->setTitle($this->data['heading_title']); 
		
		$this->load->model('catalog/emailcontact');
		
		$this->getForm();
	}
	
	public function update() {
		$this->document->setTitle($this->data['heading_title']);
		
		$this->load->model('catalog/emailcontact');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			
			$this->model_catalog_emailcontact->editEmailContact($this->request->post);
			
			$this->session->data['success'] = $this->data['text_success_update'];
			
			$this->redirect($this->url->link('catalog/emailcontact', 'token=' . $this->session->data['token'] , '', 'SSL'));
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
		
		$this->data['text_email_contact'] = 'google analytics:';
		
		if(isset($this->session->data['success'])){
			$this->data['success'] = 'Save hoàn tất!';
			unset($this->session->data['success']);
		}
		
		/*================================action=====================================*/							
		
		$this->data['action'] = $this->url->link('catalog/emailcontact/update', 'token=' . $this->session->data['token'] , '' , 'SSL');
		
		
		$this->data['token'] = $this->session->data['token'];

		/*if ($this->request->server['REQUEST_METHOD'] != 'POST') {
      		$emailcontact_info = $this->model_catalog_emailcontact->getEmailContact();
      	}*/

      	$this->load->model('localisation/language');
      	
      	$this->data['languages'] = $this->model_localisation_language->getLanguages();
      	
      	/*================================data=====================================*/

      	
		/*if (isset($this->request->post['email_contact'])) {
      		$this->data['email_contact'] = $this->request->post['email_contact'];
    	} elseif (isset($emailcontact_info)) {
      		$this->data['email_contact'] = $emailcontact_info['value'];
    	} else {
			$this->data['email_contact'] = '';
		}*/
		if (isset($this->request->post['email_contact'])) {
			$this->data['email_contact'] = $this->request->post['email_contact'];
		} else{
      		$this->data['email_contact'] = $this->config->get('config_email_contact');//$emailcontact_info[7]['value'];
      	}
		if (isset($this->request->post['email_contact_register'])) {
			$this->data['email_contact_register'] = $this->request->post['email_contact_register'];
		} else{
      		$this->data['email_contact_register'] = $this->config->get('config_email_contact_register');
      	}
		
		if (isset($this->request->post['email_order'])) {
			$this->data['email_order'] = $this->request->post['email_order'];
		} else{
      		$this->data['email_order'] = $this->config->get('config_email_order');//$emailcontact_info[7]['value'];
      	}
      	
      	if (isset($this->request->post['protocol'])) {
      		$this->data['protocol'] = $this->request->post['protocol'];
      	} else{
      		$this->data['protocol'] = $this->config->get('config_mail_protocol');//$emailcontact_info[6]['value'];
      	} 
      	
      	if (isset($this->request->post['parameter'])) {
      		$this->data['parameter'] = $this->request->post['parameter'];
      	} else{
      		$this->data['parameter'] = $this->config->get('config_mail_parameter');//$emailcontact_info[5]['value'];
      	} 
      	
      	if (isset($this->request->post['hostname'])) {
      		$this->data['hostname'] = $this->request->post['hostname'];
      	} else{
      		$this->data['hostname'] = $this->config->get('config_smtp_host');//$emailcontact_info[4]['value'];
      	} 
      	
      	if (isset($this->request->post['username'])) {
      		$this->data['username'] = $this->request->post['username'];
      	} else{
      		$this->data['username'] = $this->config->get('config_smtp_username');//$emailcontact_info[3]['value'];
      	} 
      	
      	if (isset($this->request->post['password'])) {
      		$this->data['password'] = $this->request->post['password'];
      	} else{
      		$this->data['password'] = $this->config->get('config_smtp_password');//$emailcontact_info[2]['value'];
      	} 
      	
      	if (isset($this->request->post['port'])) {
      		$this->data['port'] = $this->request->post['port'];
      	} else{
      		$this->data['port'] = $this->config->get('config_smtp_port');//$emailcontact_info[1]['value'];
      	} 
      	
      	if (isset($this->request->post['timeout'])) {
      		$this->data['timeout'] = $this->request->post['timeout'];
      	} else{
      		$this->data['timeout'] = $this->config->get('config_smtp_timeout');//$emailcontact_info[0]['value'];
      	} 			
      	
      	$this->template = 'catalog/emailcontact_form.tpl';
      	$this->children = array(
      	                        'common/header',
      	                        'common/footer',
      	                        );
      	
      	$this->response->setOutput($this->render());
      } 
      
      private function validateForm() { 
      	if (!$this->user->hasPermission('modify', 'catalog/emailcontact')) {
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
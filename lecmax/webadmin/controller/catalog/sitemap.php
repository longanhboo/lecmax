<?php 
class ControllerCatalogSitemap extends Controller {
	private $error = array(); 
    
	public function __construct($registry) {
		$this->registry = $registry;
		
		$this->load->model('catalog/lang');		   	
		
		$langs = $this->model_catalog_lang->getLangByModule('sitemap',2);
		foreach($langs as $lang){
			$this->data[$lang['key']] = html_entity_decode( $lang['name']);
		}
	}
	 
  	public function index() {
		$this->document->setTitle($this->data['heading_title']); 
		
		$this->load->model('catalog/sitemap');
		
		$this->getForm();
  	}
  
  	public function update() {
    	$this->document->setTitle($this->data['heading_title']);
		
		$this->load->model('catalog/sitemap');
	
    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			
			$this->model_catalog_sitemap->editSitemap($this->request->post);
			//print_r($this->request->post);die;
			$this->session->data['success'] = $this->data['text_success_update'];
			
			$this->redirect($this->url->link('catalog/sitemap', 'token=' . $this->session->data['token'], '' , 'SSL'));
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
 				
		$this->data['text_image_manager'] = 'Quản lý ảnh';
		
		if(isset($this->session->data['success'])){
			$this->data['success'] = 'Save hoàn tất!';
			unset($this->session->data['success']);
		}
		
		/*================================action=====================================*/							
		
		$this->data['action'] = $this->url->link('catalog/sitemap/update', 'token=' . $this->session->data['token'] , '' , 'SSL');
		
		
		$this->data['token'] = $this->session->data['token'];

	
		$this->load->model('localisation/language');
		
		$this->data['languages'] = $this->model_localisation_language->getLanguages();
		
		/*================================data=====================================*/

		$this->data['list_modules'] = array();
		$this->load->model('catalog/sitemap');
		
		$this->data['list_modules'] = $this->model_catalog_sitemap->getSitemap(1);
		//print_r($this->data['list_modules']);
										
		$this->template = 'catalog/sitemap_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);
				
		$this->response->setOutput($this->render());
  	} 
	
  	private function validateForm() { 
    	if (!$this->user->hasPermission('modify', 'catalog/sitemap')) {
      		$this->error['warning'] = $this->data['error_permission'];
    	}
		
		/*if(((strlen(utf8_decode($this->request->post['config_loop_picture'])) < 1) || (strlen(utf8_decode($this->request->post['config_loop_picture'])) > 2)) || (int)$this->request->post['config_loop_picture']>10)
			$this->error['loop_picture'] = $this->data['help_loop_picture'];		
		*/
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
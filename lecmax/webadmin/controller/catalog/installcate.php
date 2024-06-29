<?php 
class ControllerCatalogInstallcate extends Controller { 
	private $error = array();

	public function __construct($registry) {
		$this->registry = $registry;
		
		$this->load->model('catalog/lang');		   	
		
		$langs = $this->model_catalog_lang->getLangByModule('install',2);
		foreach($langs as $lang){
			$this->data[$lang['key']] = $lang['name'];
		}
	}
	
	public function index() {
		$this->document->setTitle($this->data['heading_title_cate']);
		
		$this->getForm();
	}
	
	private function installcateCateController(){
		$controller_source = DIR_INSTALL . 'controller\catalog\cate.php';
		$controller_destination = DIR_APPLICATION . 'controller\catalog\\' . $this->request->post['name'] . '.php';
		
		$str_controller = implode('', file($controller_source));
		
		$str_controller = str_replace('{$controllername_lower}',strtolower($this->request->post['name']),$str_controller);
		$str_controller = str_replace('{$controllername}',ucfirst($this->request->post['name']),$str_controller);
		$str_controller = str_replace('{CATEGORY_ID}',(int)$this->request->post['categoryid'],$str_controller);
		
		if(isset($this->request->post['validate_image']) && $this->request->post['validate_image']==1){
			$str_controller = str_replace('/*{VALIDATE_IMAGE}*/', implode('',file(DIR_INSTALL . 'cate/validate_image.php'))  , $str_controller);
		}
		
		if(isset($this->request->post['validate_images']) && $this->request->post['validate_images']==1){
			$str_controller = str_replace('/*{VALIDATE_IMAGES}*/', implode('',file(DIR_INSTALL . 'cate/validate_images.php'))  , $str_controller);
		}

		$this->saveFile($controller_destination, $str_controller);
		
	}
	
	private function installcateCateView(){
		$view_source = DIR_INSTALL . 'view\template\catalog\cate_list.tpl';
		$view_destination = DIR_APPLICATION . 'view\template\catalog\\' . $this->request->post['name'] . '_list.tpl';	

		$str_view = implode('', file($view_source));
		$str_view = str_replace('{$controllername_lower}',strtolower($this->request->post['name']),$str_view);
		
		$this->saveFile($view_destination, $str_view);
		
		$view_source = DIR_INSTALL . 'view\template\catalog\cate_form.tpl';
		$view_destination = DIR_APPLICATION . 'view\template\catalog\\' . $this->request->post['name'] . '_form.tpl';					

		$str_view = implode('', file($view_source));
		
		if(isset($this->request->post['seo']) && $this->request->post['seo']==1 && isset($this->request->post['images']) && $this->request->post['images']==1){			
			$str_view = str_replace('<!--{TAB}-->', implode('',file(DIR_INSTALL . 'cate/tab.php'))  , $str_view);		
		}elseif(isset($this->request->post['seo']) && $this->request->post['seo']==1){
			$str_view = str_replace('<!--{TAB}-->', implode('',file(DIR_INSTALL . 'cate/tab_seo.php'))  , $str_view);
		}elseif(isset($this->request->post['images']) && $this->request->post['images']==1){
			$str_view = str_replace('<!--{TAB}-->', implode('',file(DIR_INSTALL . 'cate/tab_image.php'))  , $str_view);
		}else{
			$str_view = str_replace('<!--{TAB}-->', implode('',file(DIR_INSTALL . 'cate/tab_display_none.php'))  , $str_view);
		}
		
		if(isset($this->request->post['validate_image']) && $this->request->post['validate_image']==1){
			$str_view = str_replace('<!--{VALIDATE_IMAGE}-->', implode('',file(DIR_INSTALL . 'cate/validate.php'))  , $str_view);
		}
		
		if(isset($this->request->post['validate_images']) && $this->request->post['validate_images']==1){
			$str_view = str_replace('<!--{VALIDATE_IMAGES}-->', implode('',file(DIR_INSTALL . 'cate/validate.php'))  , $str_view);
		}
		
		if(isset($this->request->post['image']) && $this->request->post['image']==1){
			$str_view = str_replace('<!--{DISPLAY}-->', implode('',file(DIR_INSTALL . 'cate/display.php'))  , $str_view);
		}else{
			$str_view = str_replace('<!--{DISPLAY}-->', implode('',file(DIR_INSTALL . 'cate/nonedisplay.php'))  , $str_view);
		}
		
		$str_view = str_replace('{$controllername_lower}',strtolower($this->request->post['name']),$str_view);
		$this->saveFile($view_destination, $str_view);
	}

	private function installcateLanguage($option=array()){
		//installcate trong table module
		$this->load->model('catalog/installcate');
		
		$this->model_catalog_installcate->installcateLanguage($option);
		
	}

	public function insert() {

		$this->document->setTitle($this->data['heading_title_cate']);	
		//$this->load->model('catalog/installcate');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$option = array();
			$option['name'] = $this->request->post['name'];
			
			if(isset($this->request->post['image']) && $this->request->post['image']==1){			
				$option['image'] = true;
			}
			
			if(isset($this->request->post['image1']) && $this->request->post['image1']==1){			
				$option['image1'] = true;
			}

			if(isset($this->request->post['images']) && $this->request->post['images']==1){			
				$option['images'] = true;
			}
			
			if(isset($this->request->post['seo']) && $this->request->post['seo']==1){			
				$option['seo'] = true;
			}

			$option['cate'] = true;
			
			/* installcate controller */						

			$this->installcateCateController();	
			
			/* installcate view */
			
			$this->installcateCateView();
			
			
			/* installcate language */
			
			$this->installcateLanguage($option);


			$this->session->data['success'] = $this->data['text_success'];
			
			$this->redirect($this->url->link('catalog/installcate', 'token=' . $this->session->data['token'], '', 'SSL')); 
		}

		$this->getForm();
	}

	private function getForm() {
		
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
		
		$this->data['action'] = $this->url->link('catalog/installcate/insert', 'token=' . $this->session->data['token'], '', 'SSL');		

		$this->data['token'] = $this->session->data['token'];


		$this->template = 'catalog/installcate_form.tpl';
		$this->children = array(
		                        'common/header',
		                        'common/footer',
		                        );

		$this->response->setOutput($this->render());
	}

	private function validateForm() {

		if (!$this->user->hasPermission('modify', 'catalog/installcate')) {
			$this->error['warning'] = $this->data['error_permission'];
		}

		if(empty($this->request->post['name'])){
			$this->error['name'] = $this->data['error_name'];
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
		if (!$this->user->hasPermission('modify', 'catalog/installcate')) {
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
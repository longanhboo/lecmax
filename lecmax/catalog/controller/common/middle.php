<?php  
class ControllerCommonMiddle extends Controller {
	public function __construct($registry) {
		$this->registry = $registry;

		$this->load->model('catalog/lang');

		$langs = $this->model_catalog_lang->getLangByModule('header',1);

		foreach($langs as $lang){
			$this->data[$lang['key']] = $lang['name'];
		}
		$this->data['lang'] = $this->config->get('config_language');
	}
	
	public function index() {	
		
		$template = 'middle.tpl';
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/' . $template)) {
			$this->template = $this->config->get('config_template') . '/template/common/' . $template;
		} else {
			$this->template = 'default/template/common/' . $template;
		}
		
		$this->render();
	}
}
?>
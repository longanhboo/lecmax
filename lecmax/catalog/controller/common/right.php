<?php
class ControllerCommonRight extends Controller {
	public function __construct($registry) {
		$this->registry = $registry;

		$this->load->model('catalog/lang');

		$langs = $this->model_catalog_lang->getLangByModule('header',1);

		foreach($langs as $lang){
			$this->data[$lang['key']] = $lang['name'];
		}

		$langs = $this->model_catalog_lang->getLangByModule('header',1);

		foreach($langs as $lang){
			$this->data[$lang['key']] = $lang['name'];
		}
		$this->data['lang'] = $this->config->get('config_language');
	}

	protected function index() {
		$this->load->model('cms/common');
				
		$this->data['config_hotline'] = $this->config->get('config_hotline');
		$this->data['config_hotline_tel'] = str_replace('.','', str_replace(' ','', $this->data['config_hotline']));
		
		$this->data['config_hotline1'] = $this->config->get('config_hotline1');
		$this->data['config_hotline1_tel'] = str_replace('.','', str_replace(' ','', $this->data['config_hotline1']));
		
		$this->data['config_image_hotline'] = $this->config->get('config_image_hotline');
		$this->data['config_image_hotline'] = !empty($this->data['config_image_hotline']) && is_file(DIR_IMAGE.$this->data['config_image_hotline'])?HTTP_IMAGE.$this->data['config_image_hotline']:'';
		
		$this->data['config_image_hotline1'] = $this->config->get('config_image_hotline_en');
		$this->data['config_image_hotline1'] = !empty($this->data['config_image_hotline1']) && is_file(DIR_IMAGE.$this->data['config_image_hotline1'])?HTTP_IMAGE.$this->data['config_image_hotline1']:'';
		
		
		$template = 'right.tpl';

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/'.$template)) {
			$this->template = $this->config->get('config_template') . '/template/common/'.$template;
		} else {
			$this->template = 'default/template/common/'.$template;
		}
		
		$this->render();
	}
}
?>
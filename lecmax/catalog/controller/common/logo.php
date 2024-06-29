<?php  
class ControllerCommonLogo extends Controller {
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
		//$logo = $this->config->get('config_logo');
		//$logo_en = $this->config->get('config_logo_en');
		
		//$islogo = (!empty($logo) && is_file(DIR_IMAGE . $logo))?HTTP_IMAGE.$logo:'';
		//$islogo_en = (!empty($logo_en) && is_file(DIR_IMAGE . $logo_en))?HTTP_IMAGE.$logo_en:'';
		
		//$this->data['logo'] = ($this->config->get('config_language')=='vi')? $islogo: $islogo_en;
		
		//$this->data['text_logo_160_40'] = html_entity_decode($this->data['text_logo_160_40']);
		
		//$this->data['trananhgroup'] = $this->config->get('config_link_realtimetable');
		/*
		if($this->config->get('config_language_id')==1)
			$this->data['image_logo'] = $this->config->get('config_image_logo_en');
		elseif($this->config->get('config_language_id')==3)
			$this->data['image_logo'] = $this->config->get('config_popup');
		else
			$this->data['image_logo'] = $this->config->get('config_image_logo');
		
		$this->data['image_logo'] = !empty($this->data['image_logo']) && is_file(DIR_IMAGE . $this->data['image_logo']) ? HTTP_IMAGE . $this->data['image_logo'] : PATH_TEMPLATE . 'default/images/logo.png';
		
		*/
		
		$path = isset($this->request->get['path'])?$this->request->get['path']:0;
		$tmp_paths = explode('_', $path);
		
		$tmp_paths[0] = ($tmp_paths[0]==0)?ID_HOME:$tmp_paths[0];
		$this->data['menu_active'] = isset($this->request->post['isSearch'])?0:$tmp_paths[0];
		
		$this->data['link_investor'] = $this->config->get('config_link_investor');
		
		$template = 'logo.tpl';
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/' . $template)) {
			$this->template = $this->config->get('config_template') . '/template/common/' . $template;
		} else {
			$this->template = 'default/template/common/' . $template;
		}
		
		$this->render();
	}
}
?>
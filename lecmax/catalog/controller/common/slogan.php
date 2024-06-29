<?php  
class ControllerCommonSlogan extends Controller {
	public function __construct($registry) {
		$this->registry = $registry;
		
		$this->load->model('catalog/lang');		   	
		
		$langs = $this->model_catalog_lang->getLangByModule('header',1);
		
		foreach($langs as $lang){
			$this->data[$lang['key']] = html_entity_decode($lang['name']);
		}
	}
	
	public function index() {	
		//$this->data['logo'] = ($this->config->get('config_language')=='vi')? HTTP_IMAGE . $this->config->get('config_logo'): HTTP_IMAGE . $this->config->get('config_logo_en');
		$this->data['lang'] = $this->config->get('config_language');
		
		/*$path = isset($this->request->get['path'])?$this->request->get['path']:0;
		$tmp_paths = explode('_', $path);
		
		$tmp_paths[0] = ($tmp_paths[0]==0)?ID_HOME:$tmp_paths[0];
		
		$this->data['menu_active'] = isset($this->request->post['isSearch'])?0:$tmp_paths[0];
		
		if($this->config->get('config_language_id')==1)
			$this->data['image_slogan'] = $this->config->get('config_image_slogan_en');
		//elseif($this->config->get('config_language_id')==3)
		//	$this->data['image_slogan'] = $this->config->get('config_popup_en');
		else
			$this->data['image_slogan'] = $this->config->get('config_image_slogan');
		
		$this->data['image_slogan'] = !empty($this->data['image_slogan']) && is_file(DIR_IMAGE . $this->data['image_slogan']) ? HTTP_IMAGE . $this->data['image_slogan'] : PATH_TEMPLATE . 'default/images/slogan-vi.png';
		
		//$this->data['config_hotline'] = $this->config->get('config_hotline');
		//$this->data['config_hotline_tel'] = str_replace('.','', str_replace(' ','', $this->data['config_hotline']));
		*/
		
		if($this->config->get('config_language_id')==1)
			$this->data['image_slogan'] = $this->config->get('config_image_slogan_en');
		else
			$this->data['image_slogan'] = $this->config->get('config_image_slogan');
		
		
		$this->data['image_slogan'] = !empty($this->data['image_slogan']) && is_file(DIR_IMAGE . $this->data['image_slogan']) ? HTTP_IMAGE . $this->data['image_slogan'] : '';
		
		$template = 'slogan.tpl';
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/' . $template)) {
			$this->template = $this->config->get('config_template') . '/template/common/' . $template;
		} else {
			$this->template = 'default/template/common/' . $template;
		}
		
		$this->render();
	}
}
?>
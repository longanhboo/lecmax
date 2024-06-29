<?php  
class ControllerCommonMenuamp extends Controller {
	public function __construct($registry) {
		$this->registry = $registry;
		
		$this->load->model('catalog/lang');		   	
		
		$langs = $this->model_catalog_lang->getLangByModule('menu',1);
		
		foreach($langs as $lang){
			$this->data[$lang['key']] = $lang['name'];
		}
	}
	
	public function index() {
		$this->load->model('cms/common');
		$this->data['menus'] = $this->model_cms_common->getMenu(0,1);
		
		$this->data['lang'] = ($this->config->get('config_language')=='vi')?'':'-en';
		
		$path = isset($this->request->get['path'])?$this->request->get['path']:0;
		$tmp_paths = explode('_', $path);
		
		$tmp_paths[0] = ($tmp_paths[0]==0)?ID_HOME:$tmp_paths[0];
		
		$this->data['menu_active'] = isset($this->request->post['isSearch'])?0:$tmp_paths[0];
		
		$this->data['menuseconds'] = $this->model_cms_common->getMenu(0,1,-1,1);
		
		//$this->data['menu_active'] = $tmp_paths[0];		
		
		$template = 'menu_amp.tpl';
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/amp/' . $template)) {
			$this->template = $this->config->get('config_template') . '/template/amp/' . $template;
		} else {
			$this->template = 'default/template/amp/' . $template;
		}
		
		$this->render();
	}
}
?>
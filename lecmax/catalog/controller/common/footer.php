<?php
class ControllerCommonFooter extends Controller {
	public function __construct($registry) {
		$this->registry = $registry;

		$this->load->model('catalog/lang');

		$langs = $this->model_catalog_lang->getLangByModule('footer',1);

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
		
		$this->document->addLink(PATH_TEMPLATE . 'default/css/validationEngine.jquery.css','stylesheet');
		//$this->document->addScript(PATH_TEMPLATE . 'default/js/jquery.validationEngine.js');

		$path = isset($this->request->get['path'])?$this->request->get['path']:0;

		$arr_path = explode('_',$path);
		
		$arr_path[0] = ($arr_path[0]==0)?ID_HOME:$arr_path[0];
		
		$this->document->addScript(PATH_TEMPLATE . 'default/js/validate.js');
		
		$this->data['menu_active'] = isset($this->request->post['isSearch'])?0:$arr_path[0];
		$this->data['scripts'] = $this->document->getScripts();
		
		$this->data['google_tag_manager'] = html_entity_decode($this->config->get('config_google_tag_manager'), ENT_QUOTES, 'UTF-8');
		
		$this->load->model('cms/contact');
		$this->data['contacts'] = $this->model_cms_contact->getHome();
		
		$hotline = $this->config->get('config_hotline');
		$search = array(' ', '.', ':', '-', '_', '(', ')', ',', ';');
		$replace = array('', '', '', '', '', '', '', '', '');
		
		$social = array();
		$social['youtube']= $this->config->get('config_link_youtube');
		$social['gp']= $this->config->get('config_link_googleplus');
		$social['fb']= $this->config->get('config_link_facebook');
		$social['linkedin']= $this->config->get('config_link_linkedin');
		//$social['twitter']= $this->config->get('config_link_twitter');
		$social['pinterest']= $this->config->get('config_link_pinterest');
		$social['instagram']= $this->config->get('config_link_intergram');
		
		//$social['skype']= $this->config->get('config_nick_skype');
		//$social['yahoo']= $this->config->get('config_nick_yahoo');
		$social['email']= $this->config->get('config_link_email');
		$social['hotline'] = $hotline;
		$social['hotline_tel'] = str_replace($search,$replace,$hotline);
		
		$this->data['social'] = $social;
		
		$product_id = isset($this->request->get['product_id'])?	(int)$this->request->get['product_id']:0;
		$this->data['product_id'] = $product_id;
		
		$template = 'footer.tpl';

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/'.$template)) {
			$this->template = $this->config->get('config_template') . '/template/common/'.$template;
		} else {
			$this->template = 'default/template/common/'.$template;
		}
		
		/*$this->children = array(
			'common/menufooter',
		);*/

		$this->render();
		//gzdocout();
	}
}
?>
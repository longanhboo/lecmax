<?php  
class ControllerCommonHotline extends Controller {
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
		$hotline = $this->config->get('config_hotline');
		$search = array(' ', '.', ':', '-', '_', '(', ')', ',', ';');
		$replace = array('', '', '', '', '', '', '', '', '');
		
		
		$social = array();
		$social['youtube']= $this->config->get('config_link_youtube');
		$social['gp']= $this->config->get('config_link_googleplus');
		$social['fb']= $this->config->get('config_link_facebook');
		//$social['twitter']= $this->config->get('config_link_twitter');
		//$social['skype']= $this->config->get('config_nick_skype');
		//$social['yahoo']= $this->config->get('config_nick_yahoo');
		//$social['email']= $this->config->get('config_link_email');
		$social['hotline'] = $hotline;
		$social['hotline_tel'] = str_replace($search,$replace,$hotline);
		
		$this->data['social'] = $social;
		
		$template = 'hotline.tpl';
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/' . $template)) {
			$this->template = $this->config->get('config_template') . '/template/common/' . $template;
		} else {
			$this->template = 'default/template/common/' . $template;
		}
		
		$this->render();
	}
}
?>
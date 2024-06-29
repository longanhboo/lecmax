<?php  
class ControllerCmsPage extends Controller {
	
	private $error = array(); 
	
	public function __construct($registry) {
		$this->registry = $registry;
		
		$this->load->model('catalog/lang');		   	
		
		$langs = $this->model_catalog_lang->getLangByModule('page',1);
		foreach($langs as $lang){
			$this->data[$lang['key']] = $lang['name'];
		}
	}
	
	public function index() {
		$this->load->model('cms/page');
		$this->load->model('cms/common');
		
		$path = isset($this->request->get['path'])?$this->request->get['path']:0;		

		$arr_path = explode('_',$path);

		if((int)$arr_path[0]==0)		
			$this->redirect($this->url->link('error/not_found'));
		
		$this->data['pages'] = $this->model_cms_page->getPage(end($arr_path));
		
		$submenu = array();
		$this->data['submenu'] = $this->model_cms_common->getMenu($arr_path[0],1);
		
		if(!isset($arr_path[1]))
		{
			$tmp = reset($this->data['submenu']);	
			$arr_path[1] = $tmp['id'];
		}
		
		$this->data['menu_active'] = $arr_path[1];
		/*
		echo "<pre>";
		print_r($this->data['pages']);
		echo "</pre>";		
		*/				
		$template = 'aboutus.tpl';//$this->data['pages']['template'];		
		
		$this->document->setKeywords($this->data['pages']['meta_keyword']);
		$this->document->setDescription($this->data['pages']['meta_description']);
		$this->document->setTitle($this->data['pages']['meta_title']);

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/cms/'.$template)) {
			$this->template = $this->config->get('config_template') . '/template/cms/'.$template;
		} else {
			$this->template = 'default/template/common/'. $template;
		}
		
		$this->children = array(
		                        'common/footer',
		                        'common/header',
		                        'common/menu',
		                        'common/logo',
		                        'common/search'
		                        );
		
		$this->response->setOutput($this->render());
	}
	
	public function loadpage(){
		$this->load->model('cms/page');
		$category_id = $this->request->get['id'];
		$template = 'ajax_' . $this->request->get['template'] . '.tpl';
		
		$this->data['lang'] = ($this->config->get('config_language')=='vi')?'':'-en';
		
		$this->data['result'] = $this->model_cms_page->loadPage($category_id);
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/cms/'.$template)) {
			$this->template = $this->config->get('config_template') . '/template/cms/'.$template;
		} else {
			$this->template = 'default/template/common/'. $template;
		}
		
		$this->response->setOutput($this->render());
	}
	
	//load hinh
	public function loadpics(){
		$this->load->model('cms/page');
		$category_id = $this->request->get['id'];
		$template = 'ajax_' . $this->request->get['template'] . '_pics.tpl';
		
		
		$this->data['result'] = $this->model_cms_page->loadpics($category_id);
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/cms/'.$template)) {
			$this->template = $this->config->get('config_template') . '/template/cms/'.$template;
		} else {
			$this->template = 'default/template/common/'. $template;
		}
		
		$this->response->setOutput($this->render());
	}
}
?>
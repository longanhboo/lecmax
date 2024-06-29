<?php  
class ControllerCommonHome extends Controller {
	public function __construct($registry) {
		$this->registry = $registry;
		
		$this->load->model('catalog/lang');		   	
		
		$langs = $this->model_catalog_lang->getLangByModule('header',1);
		
		foreach($langs as $lang){
			$this->data[$lang['key']] = html_entity_decode($lang['name']);
		}
		
		$this->data['lang'] = $this->config->get('config_language');
		//$this->data['lang1'] = $this->config->get('config_language');
	}
	
	public function index() {
		$this->load->model('cms/common');		
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && isset($this->request->post['language_code'])) {
			$this->session->data['language'] = $this->request->post['language_code'];
			
			if (isset($this->request->post['redirect'])) {
				$this->redirect($this->request->post['redirect']);
			} else {
				$this->redirect($this->url->link('common/home'));
			}
    	}
		
		
		$path = isset($this->request->get['path'])?$this->request->get['path']:0;
		$tmp_paths = explode('_', $path);
		
		$tmp_paths[0] = ($tmp_paths[0]==0)?ID_HOME:$tmp_paths[0];
		
		$this->data['infoActive'] = $this->model_cms_common->getBackgroundPage(ID_HOME);
		$this->data['getNews'] = $this->model_cms_common->getBackgroundPage(ID_NEWS);
		
		$this->data['sub_menu'] = $this->model_cms_common->getHome();
		
		$this->load->model('cms/home');
		$this->data['home'] = $this->model_cms_home->getHome(1);
		
		$this->load->model('cms/product');
		$this->data['products'] = $this->model_cms_product->getHome();
		
		$this->load->model('cms/customers');
		$this->data['customerss'] = $this->model_cms_customers->getCustomerss($tmp_paths[0]);
		
		$this->load->model('cms/project');
		$this->data['projects'] = $this->model_cms_project->getHome();
		
			$this->load->model('cms/news');
			$newss = $this->model_cms_news->getHome();
			
			$this->data['news_homes'] = $newss;
			
		$this->data['hrefhome'] = HTTP_SERVER;
		
		$this->data['popup'] = ($this->config->get('config_language')=='vi')? $this->config->get('config_popup'): $this->config->get('config_popup_en');
		$this->data['popup'] = !empty($this->data['popup']) && is_file(DIR_IMAGE.$this->data['popup'])?HTTP_IMAGE.$this->data['popup']:'';
		
		$popup_href = str_replace('HTTP_CATALOG',HTTP_SERVER,$this->config->get('config_link_popup'));
		$popup_href_en = str_replace('HTTP_CATALOG',HTTP_SERVER,$this->config->get('config_link_popup_en'));
		
		$this->data['popup_href'] = ($this->config->get('config_language')=='vi')? $popup_href: $popup_href_en;
		
		$seo = $this->model_cms_common->getSeo(ID_HOME);
		
		$this->document->setKeywords($seo['meta_keyword']);
		$this->document->setDescription($seo['meta_description']);
		$this->document->setTitle($seo['meta_title']);
		
		$this->document->setDescriptionog($seo['meta_description_og']);
		$this->document->setTitleog($seo['meta_title_og']);
		$this->document->setImageog($seo['image_og']);
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/home.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/common/home.tpl';
		} else {
			$this->template = 'default/template/common/home.tpl';
		}
		
		$this->children = array(
			'common/footer',
			'common/header',
		);
		
		$this->response->setOutput($this->render());	
	}
	
	
}
?>
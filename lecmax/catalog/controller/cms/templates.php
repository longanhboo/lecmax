<?php  
class ControllerCmsTemplates extends Controller {
	private $error = array(); 
	
	public function __construct($registry) {
		$this->registry = $registry;
		
		$this->load->model('catalog/lang');		   	
		
		$langs = $this->model_catalog_lang->getLangByModule('templates',1);
		foreach($langs as $lang){
			$this->data[$lang['key']] = $lang['name'];
		}
	}
	
	public function index() {
		$this->load->model('cms/templates');
		$this->load->model('cms/common');
		
		$path = isset($this->request->get['path'])?$this->request->get['path']:0;		

		$arr_path = explode('_',$path);
		
		if((int)$arr_path[0]==0)		
			$this->redirect($this->url->link('error/not_found'));
		
		$this->data['templatess'] = $this->model_cms_templates->getTemplatess($arr_path[0]);
					
		$template = 'templates.tpl';
		$seo = $this->model_cms_common->getSeo($arr_path[0]);
		
		$this->document->setKeywords($seo['meta_keyword']);
		$this->document->setDescription($seo['meta_description']);
		$this->document->setTitle($seo['meta_title']);

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/cms/'.$template)) {
			$this->template = $this->config->get('config_template') . '/template/cms/'.$template;
		} else {
			$this->template = 'default/template/common/'. $template;
		}
		
		$this->children = array(
		                        'common/footer',
		                        'common/header',
		                        'common/menu'
		                        );
		
		$this->response->setOutput($this->render());
	}
	
	public function detail() {
		$this->load->model('cms/templates');
		$this->load->model('cms/common');
		
		$path = isset($this->request->get['path'])?$this->request->get['path']:0;		

		$arr_path = explode('_',$path);
		
		if((int)$arr_path[0]==0)		
			$this->redirect($this->url->link('error/not_found'));
		
		$templates_id = isset($this->request->get['templates_id'])?	(int)$this->request->get['templates_id']:0;
		
		$this->data['templates'] = $this->model_cms_templates->getTemplates($templates_id);
						
		$template = 'templates_detail.tpl';
		$seo = $this->model_cms_common->getSeo($arr_path[0]);
		
		$this->document->setKeywords($seo['meta_keyword']);
		$this->document->setDescription($seo['meta_description']);
		$this->document->setTitle($seo['meta_title']);

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/cms/'.$template)) {
			$this->template = $this->config->get('config_template') . '/template/cms/'.$template;
		} else {
			$this->template = 'default/template/common/'. $template;
		}
		
		$this->children = array(
		                        'common/footer',
		                        'common/header',
		                        'common/menu'
		                        );
		
		$this->response->setOutput($this->render());
	}	
}
?>
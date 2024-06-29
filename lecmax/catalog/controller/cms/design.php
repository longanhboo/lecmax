<?php  
class ControllerCmsDesign extends Controller {
	
	private $error = array(); 
	
	public function __construct($registry) {
		$this->registry = $registry;
		
		$this->load->model('catalog/lang');		   	
		
		$langs = $this->model_catalog_lang->getLangByModule('gallery',1);
		foreach($langs as $lang){
			$this->data[$lang['key']] = $lang['name'];
		}
		
		$this->data['lang'] = ($this->config->get('config_language')=='vi')?'':'-en';
	}
	
	public function index() {
		$this->load->model('cms/gallery');
		$this->load->model('cms/common');
		
		$path = isset($this->request->get['path'])?$this->request->get['path']:0;		

		$arr_path = explode('_',$path);
		
		if((int)$arr_path[0]==0)		
			$this->redirect($this->url->link('error/not_found'));

		$this->data['gallerys'] = $this->model_cms_gallery->getGallerys($arr_path[0]);
		
		$gallery_id = isset($this->request->get['gallery_id'])?	(int)$this->request->get['gallery_id']:0;
		
		if($gallery_id==0){
			$tmp = reset($this->data['gallerys']);
			$gallery_id = $tmp['id'];
		}
		
		$this->data['id'] = $gallery_id;
		
		/*
		echo "<pre>";
		print_r($this->data['gallerys']);
		echo "</pre>";		
		*/				
		$template = 'design.tpl';
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
		                        'common/menu',
		                        'common/logo',
		                        'common/search'
		                        );

		$this->response->setOutput($this->render());
	}
	
	public function loadpage(){
		$this->load->model('cms/gallery');
		$template = 'ajax_design.tpl';
		
		
		$id = (int)$this->request->get['id'];
		$this->data['result'] = $this->model_cms_gallery->loadpics($id);
		$this->data['text_title_gallery'] =  $this->model_cms_gallery->getbyid($id);
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/cms/'.$template)) {
			$this->template = $this->config->get('config_template') . '/template/cms/'.$template;
		} else {
			$this->template = 'default/template/common/'. $template;
		}

		$this->response->setOutput($this->render());
	}
	
	//load hinh
	public function loadpics(){
		$this->load->model('cms/gallery');
		$template = 'ajax_design_pics.tpl';
		
		$id = (int)$this->request->post['id'];
		$this->data['result'] = $this->model_cms_gallery->loadpic($id);		
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/cms/'.$template)) {
			$this->template = $this->config->get('config_template') . '/template/cms/'.$template;
		} else {
			$this->template = 'default/template/common/'. $template;
		}

		$this->response->setOutput($this->render());
	}	
}
?>
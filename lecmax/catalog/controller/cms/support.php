<?php
class ControllerCmsSupport extends Controller {
	private $error = array();

	public function __construct($registry) {
		$this->registry = $registry;

		$this->load->model('catalog/lang');

		$langs = $this->model_catalog_lang->getLangByModule('support',1);
		foreach($langs as $lang){
			$this->data[$lang['key']] = html_entity_decode($lang['name']);
		}
	}

	public function index() {
		$this->load->model('cms/support');
		$this->load->model('cms/common');

		$path = isset($this->request->get['path'])?$this->request->get['path']:0;

		$arr_path = explode('_',$path);

		if((int)$arr_path[0]==0)
			$this->redirect($this->url->link('error/not_found'));

		$titlepage = $this->model_cms_common->getTitle($arr_path[0]);
		if($titlepage=='')
			$this->redirect($this->url->link('error/not_found'));

		$this->data['submenu'] = $this->model_cms_common->getMenu($arr_path[0],1);
		
		if(!isset($arr_path[1]))
		{
			$tmp = reset($this->data['submenu']);	
			$arr_path[1] = $tmp['id'];
		}
		
		$this->data['menu_active'] = $arr_path[1];
		
		$support_id = isset($this->request->get['support_id'])?	(int)$this->request->get['support_id']:0;
		$this->data['support_id'] = $support_id;
		
		foreach($this->data['submenu'] as $key=>$item){
			$this->data['submenu'][$key]['supports'] = $this->model_cms_support->getSupportByCate($item['id']);
		}
		
		
		
		$this->data['infoActive'] = $this->model_cms_common->getBackgroundPage($arr_path[0]);
		
		/*$this->data['background'] = $this->config->get('config_support_bg');
		$this->data['background'] = !empty($this->data['background']) && is_file(DIR_IMAGE.$this->data['background'])?HTTP_IMAGE.$this->data['background']:'';*/
		
		/*$slogan = $this->config->get('config_image_slogan');
		$slogan_en = $this->config->get('config_image_slogan_en');
		$isslogan = (!empty($slogan) && is_file(DIR_IMAGE . $slogan))?HTTP_IMAGE.$slogan:'';
		$isslogan_en = (!empty($slogan_en) && is_file(DIR_IMAGE . $slogan_en))?HTTP_IMAGE.$slogan_en:'';
		$this->data['slogan'] = ($this->config->get('config_language')=='vi')? $isslogan: $isslogan_en;*/
		
		
		$template = 'support.tpl';
		
		if(isAjax()){
			$template = 'support_detail.tpl';
		}
		if($support_id){
			$seo = $this->model_cms_support->getSupport($support_id);
			$this->data['support'] = $seo;
		}else{
			$seo = $this->model_cms_common->getSeo($arr_path[0]);
		}

		$this->document->setKeywords($seo['meta_keyword']);
		$this->document->setDescription($seo['meta_description']);
		$this->document->setTitle($seo['meta_title']);
		$this->document->setDescriptionog($seo['meta_description_og']);
		$this->document->setTitleog($seo['meta_title_og']);
		$this->document->setImageog($seo['image_og']);


		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/cms/'.$template)) {
			$this->template = $this->config->get('config_template') . '/template/cms/'.$template;
		} else {
			$this->template = 'default/template/common/'. $template;
		}

		$this->children = array(
			'common/footer',
			'common/logo',
			'common/menu',
			'common/search',
			'common/language',
			'common/header',
		);

		$this->response->setOutput($this->render());
	}

	public function detail() {
		$this->load->model('cms/support');
		$this->load->model('cms/common');

		$path = isset($this->request->get['path'])?$this->request->get['path']:0;

		$arr_path = explode('_',$path);

		if((int)$arr_path[0]==0)
			$this->redirect($this->url->link('error/not_found'));

		$titlepage = $this->model_cms_common->getTitle($arr_path[0]);
		if($titlepage=='')
			$this->redirect($this->url->link('error/not_found'));

		$support_id = isset($this->request->get['support_id'])?	(int)$this->request->get['support_id']:0;

		$this->data['support'] = $this->model_cms_support->getSupport($support_id);
		
		if(!isAjax()){
			$this->data['submenu'] = $this->model_cms_common->getMenu($arr_path[0],1);
		
			if(!isset($arr_path[1]))
			{
				$tmp = reset($this->data['submenu']);	
				$arr_path[1] = $tmp['id'];
			}
			
			$this->data['menu_active'] = $arr_path[1];
			
			$support_id = isset($this->request->get['support_id'])?	(int)$this->request->get['support_id']:0;
			$this->data['support_id'] = $support_id;
			
			$this->data['supports'] = $this->model_cms_support->getSupports($arr_path[0]);
		
			$this->data['infoActive'] = $this->model_cms_common->getBackgroundPage($arr_path[0]);
			$this->data['getFacilities'] = $this->model_cms_common->getIntro(ID_FACILITIES);
			$this->data['getApartment'] = $this->model_cms_common->getIntro(ID_APARTMENT);
			
			$this->data['background'] = $this->config->get('config_support_bg');
			$this->data['background'] = !empty($this->data['background']) && is_file(DIR_IMAGE.$this->data['background'])?HTTP_IMAGE.$this->data['background']:'';
			
			$template = 'support.tpl';
			/*$this->data['supports'] = $this->model_cms_support->getSupportByCate($arr_path[1]);
			
			$this->data['backgrounds'] = $this->model_cms_common->getBackgroundPage($arr_path[1]);
			
			$slogan = $this->config->get('config_image_slogan');
			$slogan_en = $this->config->get('config_image_slogan_en');
			$isslogan = (!empty($slogan) && is_file(DIR_IMAGE . $slogan))?HTTP_IMAGE.$slogan:'';
			$isslogan_en = (!empty($slogan_en) && is_file(DIR_IMAGE . $slogan_en))?HTTP_IMAGE.$slogan_en:'';
			$this->data['slogan'] = ($this->config->get('config_language')=='vi')? $isslogan: $isslogan_en;
			
			if($arr_path[1]==ID_INFORMATION){
				$template = 'information.tpl';
			}elseif($arr_path[1]==ID_PROCESSING){
				$template = 'processing.tpl';
			}else{
				$template = 'support.tpl';
			}*/
		}else{
			$template = 'support_detail.tpl';
			
		}
		$seo = $this->data['support'];

		$this->document->setKeywords($seo['meta_keyword']);
		$this->document->setDescription($seo['meta_description']);
		$this->document->setTitle($seo['meta_title']);
		$this->document->setDescriptionog($seo['meta_description_og']);
		$this->document->setTitleog($seo['meta_title_og']);
		$this->document->setImageog($seo['image_og']);


		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/cms/'.$template)) {
			$this->template = $this->config->get('config_template') . '/template/cms/'.$template;
		} else {
			$this->template = 'default/template/common/'. $template;
		}

		$this->children = array(
			'common/footer',
			'common/loadicon',
			'common/logo',
			'common/menu',
			'common/share',
			'common/language',
			'common/header',
		);

		$this->response->setOutput($this->render());
	}
}
?>
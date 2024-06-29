<?php
class ControllerCmsService extends Controller {
	private $error = array();

	public function __construct($registry) {
		$this->registry = $registry;

		$this->load->model('catalog/lang');

		$langs = $this->model_catalog_lang->getLangByModule('service',1);
		foreach($langs as $lang){
			$this->data[$lang['key']] = html_entity_decode($lang['name']);
		}
	}

	public function index() {
		$this->load->model('cms/service');
		$this->load->model('cms/common');

		$path = isset($this->request->get['path'])?$this->request->get['path']:0;

		$arr_path = explode('_',$path);

		if((int)$arr_path[0]==0)
			$this->redirect($this->url->link('error/not_found'));

		$infoActive_data = $this->cache->get('category.bgid.' . $arr_path[0] . '.' . $this->config->get('config_language_id'));
		if (!$infoActive_data) {
			$this->data['infoActive'] = $this->model_cms_common->getBackgroundPage($arr_path[0]);
			$this->cache->set('category.bgid.' . $arr_path[0] . '.' . (int)$this->config->get('config_language_id'), $this->data['infoActive'], CACHE_TIME);
		}else{
			$this->data['infoActive'] = $infoActive_data;
		}
		
		if(!isset($this->data['infoActive']['name']) || empty($this->data['infoActive']['name']))
			$this->redirect($this->url->link('error/not_found'));
		
		$service_id = isset($this->request->get['service_id'])?	(int)$this->request->get['service_id']:0;
		$cateservice = isset($this->request->get['cateservice'])?	(int)$this->request->get['cateservice']:0;
		
		if(isAjax()){
			$this->data['service_id'] = $service_id;
			$this->data['cateservice'] = $cateservice?$cateservice:$service_id;
			
			$this->data['service'] = $this->model_cms_service->getService($service_id);
			$template = 'service_detail_ajax.tpl';
			
		}else{
			$service_data = $this->cache->get('services' . '.' . $this->config->get('config_language_id'));
			if (!$service_data) {
				$this->data['services'] = $this->model_cms_service->getServiceByParent($arr_path[0],0);
				$this->cache->set('services' . '.' . (int)$this->config->get('config_language_id'), $this->data['services'], CACHE_TIME);
			}else{
				$this->data['services'] = $service_data;
			}
			
			if(!isset($service_id) || $service_id==0)
			{
				$check = 1;
				$tmp = reset($this->data['services']);	
				$service_id = $tmp['id'];
			}
			
			
			$this->data['service_id'] = $service_id;
			$this->data['cateservice'] = $cateservice?$cateservice:$service_id;
			
			$this->data['service'] = $this->model_cms_service->getService($service_id);
			
			//print_r($this->data['service']);
			
			if($this->data['cateservice']!=$this->data['service_id']){
				$this->data['service_cate'] = $this->model_cms_service->getService($this->data['cateservice']);
				$template = 'service_detail.tpl';
			}else{
				$template = 'service.tpl';
			}
			
			if(isset($check)){
				$seo = $this->model_cms_common->getSeo($arr_path[0]);
			}else{
				$seo = $this->data['service'];
			}
	
			$this->document->setKeywords($seo['meta_keyword']);
			$this->document->setDescription($seo['meta_description']);
			$this->document->setTitle($seo['meta_title']);
			$this->document->setDescriptionog($seo['meta_description_og']);
			$this->document->setTitleog($seo['meta_title_og']);
			$this->document->setImageog($seo['image_og']);
		}

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/cms/'.$template)) {
			$this->template = $this->config->get('config_template') . '/template/cms/'.$template;
		} else {
			$this->template = 'default/template/common/'. $template;
		}

		$this->children = array(
		                        'common/header',
		                        'common/footer',
		                        );

		$this->response->setOutput($this->render());
	}

	public function detail() {
		$this->load->model('cms/service');
		$this->load->model('cms/common');

		$path = isset($this->request->get['path'])?$this->request->get['path']:0;

		$arr_path = explode('_',$path);

		if((int)$arr_path[0]==0)
			$this->redirect($this->url->link('error/not_found'));

		$titlepage = $this->model_cms_common->getTitle($arr_path[0]);
		if($titlepage=='')
			$this->redirect($this->url->link('error/not_found'));

		$service_id = isset($this->request->get['service_id'])?	(int)$this->request->get['service_id']:0;

		$this->data['service'] = $this->model_cms_service->getService($service_id);

		$template = 'service_detail.tpl';
		$seo = $this->data['service'];

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
		                        'common/header',
		                        'common/footer',
		                        'common/menu'
		                        );

		$this->response->setOutput($this->render());
	}
}
?>
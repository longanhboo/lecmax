<?php
class ControllerCmsFilepdf extends Controller {
	private $error = array();

	public function __construct($registry) {
		$this->registry = $registry;

		$this->load->model('catalog/lang');

		$langs = $this->model_catalog_lang->getLangByModule('filepdf',1);
		foreach($langs as $lang){
			$this->data[$lang['key']] = html_entity_decode($lang['name']);
		}
	}

	public function index() {
		$this->load->model('cms/filepdf');
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
		
		
		$filepdfs_data = $this->cache->get('filepdfs' . '.' . $this->config->get('config_language_id'));
		if (!$filepdfs_data) {
			$this->data['filepdfs'] = $this->model_cms_filepdf->getFilepdfs($arr_path[0]);
			$this->cache->set('filepdfs' . '.' . (int)$this->config->get('config_language_id'), $this->data['filepdfs'], CACHE_TIME);
		}else{
			$this->data['filepdfs'] = $filepdfs_data;
		}
		
		/*$this->load->model('cms/city');
		$city_data = $this->cache->get('citys' . '.' . $this->config->get('config_language_id'));
		if (!$city_data) {
			$this->data['citys'] = $this->model_cms_city->getCitys($arr_path[0]);
			$this->cache->set('citys' . '.' . (int)$this->config->get('config_language_id'), $this->data['citys'], CACHE_TIME);
		}else{
			$this->data['citys'] = $city_data;
		}
		
		$this->data['districts'] = array();
		
		
		if(isset($this->request->post['name']) && !empty($this->request->post['name']))
			$this->data['name'] 		= $this->request->post['name'];
		else
			$this->data['name']			= $this->data['text_name_catalogue'];
			
		if(isset($this->request->post['phone']) && !empty($this->request->post['phone']))
			$this->data['phone'] 		= $this->request->post['phone'];
		else
			$this->data['phone']		= $this->data['text_phone_catalogue'];
		
		if(isset($this->request->post['email']) && !empty($this->request->post['email']))	
			$this->data['email'] 		= $this->request->post['email'];
		else
			$this->data['email']		= $this->data['text_email_catalogue'];
		
		if(isset($this->request->post['address']) && !empty($this->request->post['address']))	
			$this->data['address'] 			= $this->request->post['address'];
		else
			$this->data['address']		= $this->data['text_address_catalogue'];
		
		if(isset($this->request->post['company']) && !empty($this->request->post['company']))	
			$this->data['company'] 			= $this->request->post['company'];
		else
			$this->data['company']		= $this->data['text_company_catalogue'];
		*/
		

		$template = 'catalogue.tpl';
		$seo = $this->model_cms_common->getSeo($arr_path[0]);

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
		                        );

		$this->response->setOutput($this->render());
	}

	public function detail() {
		$this->load->model('cms/filepdf');
		$this->load->model('cms/common');

		$path = isset($this->request->get['path'])?$this->request->get['path']:0;

		$arr_path = explode('_',$path);

		if((int)$arr_path[0]==0)
			$this->redirect($this->url->link('error/not_found'));

		$titlepage = $this->model_cms_common->getTitle($arr_path[0]);
		if($titlepage=='')
			$this->redirect($this->url->link('error/not_found'));

		$filepdf_id = isset($this->request->get['filepdf_id'])?	(int)$this->request->get['filepdf_id']:0;

		$this->data['filepdf'] = $this->model_cms_filepdf->getFilepdf($filepdf_id);

		$template = 'filepdf_detail.tpl';
		$seo = $this->data['filepdf'];

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
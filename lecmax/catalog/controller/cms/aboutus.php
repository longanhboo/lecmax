<?php
class ControllerCmsAboutus extends Controller {
	private $error = array();

	public function __construct($registry) {
		$this->registry = $registry;

		$this->load->model('catalog/lang');

		$langs = $this->model_catalog_lang->getLangByModule('aboutus',1);
		foreach($langs as $lang){
			$this->data[$lang['key']] = html_entity_decode($lang['name']);
		}
	}

	public function index() {
		$this->load->model('cms/aboutus');
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
			
		
		//$cateaboutus = isset($this->request->get['cateaboutus'])?	(int)$this->request->get['cateaboutus']:0;
		
		//$this->data['getApartment'] = $this->model_cms_common->getIntro(ID_APARTMENT);
		//$this->data['getFacilities'] = $this->model_cms_common->getIntro(ID_FACILITIES);
		
		$aboutus_id = isset($this->request->get['aboutus_id'])?	(int)$this->request->get['aboutus_id']:0;
		$this->data['aboutus_id'] = $aboutus_id;
		
		//$this->data['cateaboutus'] = $cateaboutus?$cateaboutus:$aboutus_id;
		
		//$this->data['getTitle'] = $titlepage;
		//$this->data['infoActive'] = $this->model_cms_common->getBackgroundPage($arr_path[0]);
		
		$aboutus_data = $this->cache->get('aboutus' . '.' . $this->config->get('config_language_id'));
		if (!$aboutus_data) {
			$this->data['aboutuss'] = $this->model_cms_aboutus->getAboutusByParent($arr_path[0],0);
			$this->cache->set('aboutus' . '.' . (int)$this->config->get('config_language_id'), $this->data['aboutuss'], CACHE_TIME);
		}else{
			$this->data['aboutuss'] = $aboutus_data;
		}
		//print_r($this->data['aboutuss']);
		$template = 'aboutus.tpl';
		
		if($aboutus_id){
			$seo = $this->model_cms_aboutus->getAboutus($aboutus_id);
			//$this->data['aboutus'] = $seo;
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
			//'common/partnerfooter',
			//'common/slogan',
			//'common/register',
			//'common/menu',
			//'common/hotline',
			'common/header',
		);
		
		$this->response->setOutput($this->render());
	}

	public function detail() {
		$this->load->model('cms/aboutus');
		$this->load->model('cms/common');

		$path = isset($this->request->get['path'])?$this->request->get['path']:0;

		$arr_path = explode('_',$path);

		if((int)$arr_path[0]==0)
			$this->redirect($this->url->link('error/not_found'));

		$titlepage = $this->model_cms_common->getTitle($arr_path[0]);
		if($titlepage=='')
			$this->redirect($this->url->link('error/not_found'));

		$aboutus_id = isset($this->request->get['aboutus_id'])?	(int)$this->request->get['aboutus_id']:0;

		$this->data['aboutus'] = $this->model_cms_aboutus->getAboutus($aboutus_id);

		$template = 'aboutus_detail.tpl';
		$seo = $this->data['aboutus'];

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
	
	public function video() {
		$this->load->model('cms/aboutus');
		$this->load->model('cms/common');
		
		if(!isAjax()){
			$this->redirect(HTTP_SERVER);
		}
		
		$aboutus_id = isset($this->request->get['id'])?	(int)$this->request->get['id']:0;

		$this->data['video'] = $this->model_cms_aboutus->getAboutus($aboutus_id);

		$template = 'aboutus_video.tpl';

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/cms/'.$template)) {
			$this->template = $this->config->get('config_template') . '/template/cms/'.$template;
		} else {
			$this->template = 'default/template/common/'. $template;
		}

		$this->response->setOutput($this->render());
	}
	
	public function videobg() {
		$this->load->model('cms/aboutus');
		$this->load->model('cms/common');
		
		if(!isAjax()){
			$this->redirect(HTTP_SERVER);
		}
		
		$aboutus_id = isset($this->request->get['id'])?	(int)$this->request->get['id']:0;

		$this->data['video'] = $this->model_cms_aboutus->getAboutus($aboutus_id);

		$template = 'aboutus_video_bg.tpl';

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/cms/'.$template)) {
			$this->template = $this->config->get('config_template') . '/template/cms/'.$template;
		} else {
			$this->template = 'default/template/common/'. $template;
		}

		$this->response->setOutput($this->render());
	}
	
	public function viewmessage() {
		$this->load->model('cms/aboutus');
		$this->load->model('cms/common');
		
		if(!isAjax()){
			$this->redirect(HTTP_SERVER);
		}
		
		$aboutus_id = isset($this->request->get['id'])?	(int)$this->request->get['id']:0;

		$this->data['aboutus'] = $this->model_cms_aboutus->getAboutus($aboutus_id);

		$template = 'aboutus_message.tpl';

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/cms/'.$template)) {
			$this->template = $this->config->get('config_template') . '/template/cms/'.$template;
		} else {
			$this->template = 'default/template/common/'. $template;
		}

		$this->response->setOutput($this->render());
	}
	
	public function album() {
		$this->load->model('cms/aboutus');
		//$this->load->model('cms/common');
		
		if(!isAjax()){
			$this->redirect(HTTP_SERVER);
		}

		$aboutus_id = isset($this->request->get['id'])?	(int)$this->request->get['id']:0;

		$this->data['album'] = $this->model_cms_aboutus->getImages($aboutus_id);

		$template = 'aboutus_album.tpl';

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/cms/'.$template)) {
			$this->template = $this->config->get('config_template') . '/template/cms/'.$template;
		} else {
			$this->template = 'default/template/common/'. $template;
		}

		$this->response->setOutput($this->render());
	}
	
	public function albumachivement() {
		$this->load->model('cms/aboutus');
		//$this->load->model('cms/common');
		
		if(!isAjax()){
			$this->redirect(HTTP_SERVER);
		}

		$aboutus_id = isset($this->request->get['id'])?	(int)$this->request->get['id']:0;

		$this->data['album'] = $this->model_cms_aboutus->getAboutusByParent(ID_ABOUTUS, $aboutus_id);

		$template = 'aboutus_album_achivement.tpl';

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/cms/'.$template)) {
			$this->template = $this->config->get('config_template') . '/template/cms/'.$template;
		} else {
			$this->template = 'default/template/common/'. $template;
		}

		$this->response->setOutput($this->render());
	}
	
	public function viewfactory() {
		$this->load->model('cms/aboutus');
		//$this->load->model('cms/common');
		
		if(!isAjax()){
			$this->redirect(HTTP_SERVER);
		}

		$aboutus_id = isset($this->request->get['id'])?	(int)$this->request->get['id']:0;

		$this->data['aboutus'] = $this->model_cms_aboutus->getAboutus($aboutus_id);

		$template = 'aboutus_factory.tpl';

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/cms/'.$template)) {
			$this->template = $this->config->get('config_template') . '/template/cms/'.$template;
		} else {
			$this->template = 'default/template/common/'. $template;
		}

		$this->response->setOutput($this->render());
	}
	
	public function viewhuman() {
		$this->load->model('cms/aboutus');
		//$this->load->model('cms/common');
		
		if(!isAjax()){
			$this->redirect(HTTP_SERVER);
		}

		$aboutus_id = isset($this->request->get['id'])?	(int)$this->request->get['id']:0;

		$this->data['album'] = $this->model_cms_aboutus->getAboutus($aboutus_id);

		$template = 'aboutus_human.tpl';

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/cms/'.$template)) {
			$this->template = $this->config->get('config_template') . '/template/cms/'.$template;
		} else {
			$this->template = 'default/template/common/'. $template;
		}

		$this->response->setOutput($this->render());
	}
}
?>
<?php  
class ControllerCmsHome extends Controller {
	public function __construct($registry) {
		$this->registry = $registry;
		
		$this->load->model('catalog/lang');		   	
		
		$langs = $this->model_catalog_lang->getLangByModule('header',1);
		
		foreach($langs as $lang){
			$this->data[$lang['key']] = html_entity_decode($lang['name']);
		}
		
		$this->data['lang'] = $this->config->get('config_language');
		$this->data['lang1'] = $this->config->get('config_language');
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
		
		//$this->data['menu_active'] = isset($this->request->post['isSearch'])?0:$tmp_paths[0];
		
		
		$this->data['infoActive'] = $this->model_cms_common->getBackgroundPage(ID_HOME);
		$this->data['getLocation'] = $this->model_cms_common->getIntro(ID_LOCATION);
		$this->data['getAboutus'] = $this->model_cms_common->getIntro(ID_ABOUTUS);
		
		$this->load->model('cms/home');
		$this->data['home'] = $this->model_cms_home->getHome(1);
		
		$this->load->model('cms/video');
		$this->data['videos'] = $this->model_cms_video->getHome();
		
		$news_data = $this->cache->get('newshome' . '.' . $this->config->get('config_language_id'));
		if (!$news_data) {
			$this->load->model('cms/news');
			$newss = $this->model_cms_news->getHome();
			/*
			$sort_order = array();
			$this->data['news_homes'] = array_merge($newss,$dutrus);
			foreach ($this->data['news_homes'] as $key => $row) {
				$sort_order[$key] = $row['sort_order'];
			}
			array_multisort($sort_order, SORT_ASC, $this->data['news_homes']);
			*/
			$this->data['news_homes'] = $newss;
			$this->cache->set('newshome' . '.' . (int)$this->config->get('config_language_id'), $this->data['news_homes'], CACHE_TIME);
		}else{
			$this->data['news_homes'] = $news_data;
		}
		
		/*$product_data = $this->cache->get('producthome' . '.' . $this->config->get('config_language_id'));
		if (!$product_data) {
			$this->load->model('cms/product');
			$this->data['menus'] = $this->model_cms_common->getMenu(ID_PRODUCT,1);
			foreach($this->data['menus'] as $key=>$item){
				$this->data['menus'][$key]['products'] = $this->model_cms_product->getHomeByCate($item['id']);
			}
			
			$this->cache->set('producthome' . '.' . (int)$this->config->get('config_language_id'), $this->data['menus'], CACHE_TIME);
		}else{
			$this->data['menus'] = $product_data;
		}
		
		$imgitem_data = $this->cache->get('imgitem.1');
		if (!$imgitem_data) {
			$this->load->model('cms/imgitem');
			$this->data['imgitem'] = array('title'=>$this->model_cms_imgitem->getImages(1,''), 'left'=>$this->model_cms_imgitem->getImages(1,'left'), 'right'=>$this->model_cms_imgitem->getImages(1,'right'), 'footer'=>$this->model_cms_imgitem->getImages(1,'footer'));
			$this->cache->set('imgitem.1', $this->data['imgitem'], CACHE_TIME);
		}else{
			$this->data['imgitem'] = $imgitem_data;
		}
		//print_r($this->data['imgitem']);
		$contact_data = $this->cache->get('contact' . '.' . $this->config->get('config_language_id'));
		if (!$contact_data) {
			$this->load->model('cms/contact');
			$this->data['contact'] = $this->model_cms_contact->getContact(5);
			$this->cache->set('contact' . '.' . (int)$this->config->get('config_language_id'), $this->data['contact'], CACHE_TIME);
		}else{
			$this->data['contact'] = $contact_data;
		}*/
		
		$hotline = $this->config->get('config_hotline');
		$search = array(' ', '.', ':', '-', '_', '(', ')', ',', ';');
		$replace = array('', '', '', '', '', '', '', '', '');
		
		$this->data['num_hotline'] = $hotline;
		$this->data['num_hotline_tel'] = str_replace($search,$replace,$hotline);
		
		$this->data['hrefhome'] = HTTP_SERVER;
		
		//$this->data['popup'] = ($this->config->get('config_language')=='vi')? $this->data['home']['imagetienich']: $this->data['home']['imagechudautu'];
		//$this->data['popup_href'] = str_replace('HTTP_CATALOG',HTTP_SERVER,$this->data['home']['link_tongthe']);
		
		
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
			'common/logo',
			'common/register',
			//'common/slogan',
			'common/menu',
			//'common/cart',
			//'common/search',
			'common/hotline',
			//'common/language',
			'common/header',
		);
		
		$this->response->setOutput($this->render());	
	}
	
	public function video() {
		$this->load->model('cms/home');
		$this->load->model('cms/common');
		
		if(!isAjax()){
			$this->redirect(HTTP_SERVER);
		}
		
		$video_id = isset($this->request->get['id'])?	(int)$this->request->get['id']:0;

		$this->data['video'] = $this->model_cms_home->getHome($video_id);

		$template = 'video.tpl';

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/cms/'.$template)) {
			$this->template = $this->config->get('config_template') . '/template/cms/'.$template;
		} else {
			$this->template = 'default/template/common/'. $template;
		}

		$this->response->setOutput($this->render());
	}
	
	public function album() {
		$this->load->model('cms/album');
		$this->load->model('cms/common');
		
		if(!isAjax()){
			$this->redirect(HTTP_SERVER);
		}

		//$this->data['album'] = $this->model_cms_home->getHome(1);
		$album_id = isset($this->request->get['id'])?	(int)$this->request->get['id']:0;

		$this->data['album'] = $this->model_cms_album->getAlbum($album_id);

		$template = 'album.tpl';

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/cms/'.$template)) {
			$this->template = $this->config->get('config_template') . '/template/cms/'.$template;
		} else {
			$this->template = 'default/template/common/'. $template;
		}

		$this->response->setOutput($this->render());
	}
	
	public function product() {
		$this->load->model('cms/service');
		$this->load->model('cms/common');
		
		if(!isAjax()){
			$this->redirect(HTTP_SERVER);
		}
		
		$service_id = isset($this->request->get['id'])?	(int)$this->request->get['id']:0;

		$this->data['service'] = $this->model_cms_service->getService($service_id);

		$template = 'service_ajax.tpl';

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/cms/'.$template)) {
			$this->template = $this->config->get('config_template') . '/template/cms/'.$template;
		} else {
			$this->template = 'default/template/common/'. $template;
		}

		$this->response->setOutput($this->render());
	}
	
	
	public function scaleimg() {
		$width = isset($this->request->post['width'])?$this->request->post['width']:0;
		$isMobile = isset($this->request->post['isMobile'])?$this->request->post['isMobile']:'';		
		if($isMobile!=='' && $width<=1050){
			$_SESSION['scaleimg'] = '1';
			$te = '1';
		}else{
			$_SESSION['scaleimg'] = '0';
			$te = '0';
			
		}
	}
	
}
?>
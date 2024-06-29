<?php   
class ControllerCommonHeaderamp extends Controller {
	
	public function __construct($registry) {
		$this->registry = $registry;
		
		$this->load->model('catalog/lang');		   	
		
		$langs = $this->model_catalog_lang->getLangByModule('header',1);
		
		foreach($langs as $lang){
			$this->data[$lang['key']] = $lang['name'];
		}
		
		$langs = $this->model_catalog_lang->getLangByModule('search',1, false);
		foreach($langs as $lang){
			$this->data[$lang['key']] = $lang['name'];
		}
		
		$this->data['lang'] = $this->config->get('config_language');
		
		$this->data['lang1'] = $this->config->get('config_language');
		
		$query = $this->registry->get('db')->query("SELECT p.code, p.name, p.language_id, p.locale, p.image, p.status, p.sort_order FROM " . DB_PREFIX . "language p  WHERE status='1'"); 
		$this->data['language_list'] = $query->rows;
		
		if (!isset($this->request->get['route'])) {
			$route = '';
			$url = '';
			$this->data['redirect'] = HTTP_SERVER;
			foreach($this->data['language_list'] as $key=>$item){
				//if($route=='cms/search')
				//	$this->data['languages'][$key]['redirect'] = HTTP_SERVER ;		
				//else{
					//$lang1 = (int)$item['language_id']==2?'':$item['code'] . '/';
					$lang1 = $item['code'] . '/';
					$this->data['language_list'][$key]['redirect'] = HTTP_SERVER . $lang1;
				//}
				//$this->data['languages'][$key]['href_lang']=$item;
			}
		} else {
			$data = $this->request->get;
			
			unset($data['_route_']);
			
			$route = $data['route'];
			
			unset($data['route']);
						
			$url = '';
			
			if ($data) {
				$url = '&' . urldecode(http_build_query($data));
			}
		}
		
		
		
		foreach($this->data['language_list'] as $key=>$item){
			$locale = $item['locale'];
			$arr_locale = explode(',',$locale);
			$this->data['language_list'][$key]['language_hreflang'] = isset($arr_locale[2])?$arr_locale[2]:$this->data['lang1'];
			
			if($route=='cms/search')
				$this->data['language_list'][$key]['href'] = HTTP_SERVER . 'tim-kiem.html';		
			else{
				
				//$lang1 = (int)$item['language_id']==2?'':$item['code'];
				$lang1 = $item['code'];
				//$url = str_replace('&language='.$this->config->get('config_language'),'&language='.$item['code'],$url);
				$url = str_replace('&language='.$this->config->get('config_language'),'',$url);
				if(!empty($route)){
					if(isset($this->request->get['_route_']) && $this->request->get['_route_']==$this->config->get('config_language')){
						$this->data['language_list'][$key]['href'] = HTTP_SERVER . $item['code'] . '/';
					}else{
						$this->data['language_list'][$key]['href'] = $this->url->link($route, $url, $lang1) . '.html';
					}
				}else{
					$this->data['language_list'][$key]['href'] = $this->url->link($route, $url, $lang1) . '/';
				}
			}
			
			
			if($item['code']==$this->config->get('config_language')){
				$this->data['language_location'] = isset($arr_locale[1])?$arr_locale[1]:$this->data['lang1'];
			}
		}
		
		//$this->data['lang'] = $this->config->get('config_language');
		
		//$this->data['lang1'] = $this->config->get('config_language');
	}
	
	protected function index() {
		/*
		//gzip
		$phpversion_array = phpversion();
		$phpversion_nr = $phpversion_array[0].".".$phpversion_array[2].$phpversion_array[4];
		if (extension_loaded("zlib") && ($phpversion_nr >= 4.04)) {
			ob_start("ob_gzhandler");
		}
		
		// Mã PHP của bạn phải bắt buộc nằm trong khoảng này !!!
		
		
		//if(!ob_start("ob_gzhandler")){ ob_start();}
		*/
		//$this->document->addScript(PATH_TEMPLATE . 'default/js/validate.js');
		//$this->document->addLink(PATH_TEMPLATE . 'default/css/validationEngine.jquery.css','stylesheet');
		//$this->document->addScript(PATH_TEMPLATE . 'default/js/jquery.validationEngine.js');
		
		$title = $this->document->getTitle();
		//$title = (empty($title)? $this->data['meta_title'] :  $this->data['meta_title'] . ' - ' . $title);
		$title = (empty($title)? $this->data['meta_title'] :  $title);
		
		$keyword = $this->document->getKeywords();
		$keyword = (empty($keyword)?$this->data['meta_keyword']:$keyword);
		
		$description = $this->document->getDescription();
		$description = (empty($description)?$this->data['meta_description']:$description);
		
		$this->data['title_home'] = $this->data['meta_title'];
		$this->data['title'] = $title;					
		$this->data['keywords'] = $keyword;
		$this->data['description'] = $description;
		
		$title_og = $this->document->getTitleog();	
		$title_og = (empty($title_og)?$title:$title_og);
		
		$description_og = $this->document->getDescriptionog();
		$description_og = (empty($description_og)?$this->data['meta_description_og']:$description_og);
		$image_og = $this->document->getImageog();
		$image_og = (empty($image_og)?PATH_TEMPLATE . 'default/images/social-share.png':HTTP_IMAGE . $image_og);
		$url_og = "http://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
		
		$this->data['title_og'] = $title_og;
		$this->data['image_og'] = $image_og;	
		$this->data['url_og'] = $url_og;					
		$this->data['description_og'] = $description_og;
		
		$this->data['scripts'] = $this->document->getScripts();
		$this->data['links'] = $this->document->getLinks();
		
		$this->data['google_analytics'] = html_entity_decode($this->config->get('config_google_analytics'), ENT_QUOTES, 'UTF-8');
		
		$path = isset($this->request->get['path'])?$this->request->get['path']:0;
		$arr_path = explode('_',$path);
		if((int)$arr_path[0]==0)
			$arr_path[0] = ID_HOME;
		//$this->data['menu_active'] = (int)$arr_path[0];
		$this->data['menu_active'] = isset($this->request->post['isSearch'])?0:$arr_path[0];
		
		$this->data['getActive'] = $this->model_cms_common->getIntro($this->data['menu_active']);
		
		$this->data['ampcd'] = $this->model_cms_ampcd->getAmpcd($this->data['menu_active']);
		
		$template = 'header_amp.tpl';
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/amp/' . $template)) {
			$this->template = $this->config->get('config_template') . '/template/amp/' . $template;
		} else {
			$this->template = 'default/template/amp/' . $template;
		}
		
		
		
		$this->render();
		
	} 	
}
?>
<?php   
class ControllerCommonHeader extends Controller {
	
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
					$this->data['language_list'][$key]['href'] = $this->url->link($route, $url, $lang1) . '.html';
				}else{
					if(!isset($this->request->get['_route_'])){
						$this->data['language_list'][$key]['href'] = HTTP_SERVER;
					}else{
						$this->data['language_list'][$key]['href'] = $this->url->link($route, $url, $lang1) . '/';
					}
					//$this->data['language_list'][$key]['href'] = $this->url->link($route, $url, $lang1) . '/';
				}
			}
			
			
			if($item['code']==$this->config->get('config_language')){
				$this->data['language_location'] = isset($arr_locale[1])?$arr_locale[1]:$this->data['lang1'];
			}
		}
		
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
		$this->load->model('cms/common');
		
		$path = isset($this->request->get['path'])?$this->request->get['path']:0;
		$arr_path = explode('_',$path);
		if((int)$arr_path[0]==0)
			$arr_path[0] = ID_HOME;
		//$this->data['menu_active'] = (int)$arr_path[0];
		$this->data['menu_active'] = isset($this->request->post['isSearch'])?0:$arr_path[0];
		$this->data['submenu_active'] = isset($arr_path[1])?$arr_path[1]:0;
		
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
		$protocol = 'http://';
		if (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443') {
			$protocol = 'https://';
		}
		$url_og = $protocol . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
		
		$this->data['title_og'] = $title_og;
		$this->data['image_og'] = $image_og;	
		$this->data['url_og'] = $url_og;					
		$this->data['description_og'] = $description_og;
		
		//$this->data['scripts'] = $this->document->getScripts();
		$this->data['links'] = $this->document->getLinks();
		
		$this->data['google_analytics'] = html_entity_decode($this->config->get('config_google_analytics'), ENT_QUOTES, 'UTF-8');
		
		//$this->loadInfo();
		
		
		//hotline share
		$hotline = $this->config->get('config_hotline');
		$hotline1 = $this->config->get('config_hotline1');
		$search = array(' ', '.', ':', '-', '_', '(', ')', ',', ';');
		$replace = array('', '', '', '', '', '', '', '', '');
		
		$social = array();
		$social['youtube']= $this->config->get('config_link_youtube');
		$social['gp']= $this->config->get('config_link_googleplus');
		$social['fb']= $this->config->get('config_link_facebook');
		$social['twitter']= $this->config->get('config_link_twitter');
		$social['hotline'] = $hotline;
		$social['hotline_tel'] = str_replace($search,$replace,$hotline);
		$social['hotline1'] = $hotline1;
		$social['hotline1_tel'] = str_replace($search,$replace,$hotline1);
		
		$this->data['social'] = $social;
		
		$schema = '';
		if(!empty($social['fb'])){
			$schema .= '"' . $social['fb'] . '",';
		}
		if(!empty($social['gp'])){
			$schema .= '"' . $social['gp'] . '",';
		}
		if(!empty($social['twitter'])){
			$schema .= '"' . $social['twitter'] . '",';
		}
		
		$schema = trim($schema,',');
		
		$this->data['social_schema'] = $schema;
		
		$this->load->model('cms/product');
		
		$submenus_data = $this->cache->get('category.submenus' . '.' . $this->config->get('config_language_id'));
		if (!$submenus_data) {
			$this->data['submenus'] = $this->model_cms_common->getMenu(0,1,-1,1);
			//$this->cache->set('category.submenus' . '.' . (int)$this->config->get('config_language_id'), $this->data['submenus'], CACHE_TIME);
		}else{
			$this->data['submenus'] = $submenus_data;
		}
		
		//menu
		$menus_data = $this->cache->get('category.menus' . '.' . $this->config->get('config_language_id'));
		if (!$menus_data) {
			$this->data['menus'] = $this->model_cms_common->getMenu(0,1,-1,0);
			
			$this->cache->set('category.menus' . '.' . (int)$this->config->get('config_language_id'), $this->data['menus'], CACHE_TIME);
		}else{
			$this->data['menus'] = $menus_data;
		}
		
		
		
		$logo_value = $this->config->get('config_image_hotline_en');
		$this->data['logo_value'] = !empty($logo_value) && is_file(DIR_IMAGE.$logo_value)?HTTP_IMAGE.$logo_value:'';
		
		$this->data['href_search'] = HTTP_SERVER . 'tim-kiem.html';
		
		$product_id = isset($this->request->get['product_id'])?	(int)$this->request->get['product_id']:0;
		$this->data['product_id'] = $product_id;
		
		$this->data['menu_active1'] = $this->data['menu_active2'] = 0;
		
		if($arr_path[0]==ID_PRODUCT){
			$this->data['submenu'] = $this->model_cms_common->getMenu($arr_path[0],1);
			
			if(!isset($arr_path[1]))
			{
				$check = 1;
				$tmp = reset($this->data['submenu']);	
				$arr_path[1] = $tmp['id'];
			}
			
			$this->data['menu_active1'] = $arr_path[1];
			
			if(!isset($arr_path[2]))
			{
				$check = 2;
				$tmp = 0;
				foreach($this->data['submenu'] as $key=>$item){
					if($item['id']==$arr_path[1]){
						$tmp = reset($this->data['submenu'][$key]['child']);	
						break;
					}
				}
				$arr_path[2] = $tmp['id'];
			}
			
			$this->data['menu_active2'] = $arr_path[2];
			
		}
		
		//$this->load->model('cms/ampcd');
		$this->data['ampcd'] = array();//$this->model_cms_ampcd->getAmpcd($this->data['menu_active']);
		
		$template = 'header.tpl';
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/' . $template)) {
			$this->template = $this->config->get('config_template') . '/template/common/' . $template;
		} else {
			$this->template = 'default/template/common/' . $template;
		}
		
		$this->children = array(
			'common/language',
		);
		
		$this->render();
		
	}
	
	private function loadInfo(){
		
		if(isset($this->request->post['nameregister']) && !empty($this->request->post['nameregister']))
			$this->data['nameregister'] 		= $this->request->post['nameregister'];
		else
			$this->data['nameregister']			= $this->data['text_name_register'];
		
		if(isset($this->request->post['emailregister']) && !empty($this->request->post['emailregister']))	
			$this->data['emailregister'] 		= $this->request->post['emailregister'];
		else
			$this->data['emailregister']		= $this->data['text_email_register'];
		
		if(isset($this->request->post['phoneregister']) && !empty($this->request->post['phoneregister']))
			$this->data['phoneregister'] 		= $this->request->post['phoneregister'];
		else
			$this->data['phoneregister']		= $this->data['text_phone_register'];
		
		if(isset($this->request->post['addressregister']) && !empty($this->request->post['addressregister']))
			$this->data['addressregister'] 		= $this->request->post['addressregister'];
		else
			$this->data['addressregister']		= $this->data['text_address_register'];
		
		
		if(isset($this->request->post['commentregister']) && !empty($this->request->post['commentregister']))
			$this->data['commentregister'] 		= $this->request->post['commentregister'];
		else
			$this->data['commentregister']		= $this->data['text_comment_register'];
		
		
		
		
	}
}
?>
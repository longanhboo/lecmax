<?php  
class ControllerCommonLanguage extends Controller {
	
	public function __construct($registry) {
		$this->registry = $registry;
		
		$this->load->model('catalog/lang');		   	
		
		$langs = $this->model_catalog_lang->getLangByModule('header',1);
		
		foreach($langs as $lang){
			$this->data[$lang['key']] = html_entity_decode($lang['name']);
		}

	}
	
	public function index() {	
		// WHERE code<>'".$this->config->get('config_language') . "'
		$query = $this->registry->get('db')->query("SELECT * FROM " . DB_PREFIX . "language p  WHERE code<>'".$this->config->get('config_language') . "'  ORDER BY p.sort_order ASC"); 
		
		$this->data['languages'] = $query->rows;
		
		$this->data['action'] = HTTP_SERVER;

		if (!isset($this->request->get['route'])) {
			$this->data['redirect'] = HTTP_SERVER;
			foreach($this->data['languages'] as $key=>$item){
				//if($route=='cms/search')
				//	$this->data['languages'][$key]['redirect'] = HTTP_SERVER ;		
				//else{
					//$lang1 = (int)$item['language_id']==2?'':$item['code'] . '/';
					$lang1 = $item['code'] . '/';
					$this->data['languages'][$key]['redirect'] = HTTP_SERVER . $lang1;
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
			
			if($route=='cms/search')
				$this->data['redirect'] = HTTP_SERVER . 'tim-kiem.html';		
			else
				$this->data['redirect'] = $this->url->link($route, $url) . '.html';		
			
			foreach($this->data['languages'] as $key=>$item){
				if($route=='cms/search')
					$this->data['languages'][$key]['redirect'] = HTTP_SERVER . 'tim-kiem.html';		
				else{
					//$lang1 = (int)$item['language_id']==2?'':$item['code'];
					$lang1 = $item['code'];
					$url = str_replace('&language='.$this->config->get('config_language'),'&language='.$item['code'],$url);
					$this->data['languages'][$key]['redirect'] = $this->url->link($route, $url, $lang1) . '.html';
				}
				//$this->data['languages'][$key]['href_lang']=$item;
			}
			
		}
		
		$this->data['lang_active'] = $this->config->get('config_language');
		
		$template = 'language.tpl';
				
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/' . $template)) {
			$this->template = $this->config->get('config_template') . '/template/common/' . $template;
		} else {
			$this->template = 'default/template/common/' . $template;
		}
								
		$this->render();
	}
}
?>
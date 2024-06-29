<?php  
class ControllerCmsSearch extends Controller {
	private $error = array(); 
	
	public function __construct($registry) {
		$this->registry = $registry;
		
		$this->load->model('catalog/lang');		   	
		
		$langs = $this->model_catalog_lang->getLangByModule('search',1);
		foreach($langs as $lang){
			$this->data[$lang['key']] = html_entity_decode($lang['name']);
		}
	}

	public function index() {
		$this->load->model('cms/search');
		$this->load->model('cms/common');
		
		$qsearch = isset($this->request->get['qsearch'])?$this->request->get['qsearch']:'';
		if($qsearch==''){
			$this->redirect(HTTP_SERVER);
		}
		//$this->data['loop_picture'] = $this->config->get('config_loop_picture');
		//$this->data['backgrounds'] = $this->model_cms_common->getBackgroundPage(ID_CONTACT);
		//$this->data['infoActive'] = $this->model_cms_common->getBackgroundPage(ID_ABOUTUS);
		/*$infoActive_data = $this->cache->get('category.bgid.' . ID_ABOUTUS . '.' . $this->config->get('config_language_id'));
		if (!$infoActive_data) {
			$this->data['infoActive'] = $this->model_cms_common->getBackgroundPage(ID_ABOUTUS);
			$this->cache->set('category.bgid.' . ID_ABOUTUS . '.' . (int)$this->config->get('config_language_id'), $this->data['infoActive'], CACHE_TIME);
		}else{
			$this->data['infoActive'] = $infoActive_data;
		}*/
		
		$this->data['background'] = $this->config->get('config_image_hotline');
		$this->data['background'] = str_replace(' ', '%20', $this->data['background']);
		
		$this->data['searchs'] = $this->model_cms_search->getSearchs($qsearch);
		$this->request->post['isSearch']=true;
		
		
		
		/*echo '<pre>';
		print_r($this->data['searchs']);
		echo '</pre>';
		die;*/
		$template = 'search.tpl';		

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/cms/'.$template)) {
			$this->template = $this->config->get('config_template') . '/template/cms/'.$template;
		} else {
			$this->template = 'default/template/common/'. $template;
		}
		
		$this->children = array(
			'common/footer',
			'common/header',
			//'common/service',
		);

		$this->response->setOutput($this->render());
	}

}
?>
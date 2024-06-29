<?php  
class ControllerCommonSearch extends Controller {
	public function __construct($registry) {
		$this->registry = $registry;
		
		$this->load->model('catalog/lang');		   	
		
		$langs = $this->model_catalog_lang->getLangByModule('search',1, false);
		
		foreach($langs as $lang){
			$this->data[$lang['key']] = $lang['name'];
		}
	}
		
	public function index() {	
		$path = isset($this->request->get['path'])?$this->request->get['path']:0;		
		$arr_path = explode('_',$path);
		
		$arr_path[0] = ($arr_path[0]==0)?ID_HOME:$arr_path[0];
		$this->data['menu_active'] = $arr_path[0];
		
		//$this->data['menu_active'] = $this->data['menu_active']==ID_SALE?$this->data['menu_active']:ID_FORRENT;
		
		/*if(isset($this->request->get['type'])){
			$this->data['menu_active'] = (int)$this->request->get['type'];
		}
		$this->load->model('cms/common');
		$this->data['text_title'] = $this->model_cms_common->getTitle($arr_path[0]);
		*/
		/*$this->load->model('cms/typerealestate');
		$this->data['typerealestate_sales'] = $this->model_cms_typerealestate->getTyperealestates(ID_SALE);
		$this->data['typerealestate_rents'] = $this->model_cms_typerealestate->getTyperealestates(ID_FORRENT);
		
		$this->load->model('cms/pricerealestate');
		$this->data['pricerealestate_sales'] = $this->model_cms_pricerealestate->getPricerealestates(ID_SALE);
		$this->data['pricerealestate_rents'] = $this->model_cms_pricerealestate->getPricerealestates(ID_FORRENT);
		
		$this->load->model('cms/arearealestate');
		$this->data['arearealestate_sales'] = $this->model_cms_arearealestate->getArearealestates(ID_SALE);
		$this->data['arearealestate_rents'] = $this->model_cms_arearealestate->getArearealestates(ID_FORRENT);
		
		$this->load->model('cms/city');
		$this->data['cities'] = $this->model_cms_city->getCitys(0);
		*/
		
		//$this->data['href_search'] = HTTP_SERVER . 'tim-kiem.html';
		$this->data['href_search'] = HTTP_SERVER . 'tim-kiem.html';
		
		$template = 'search.tpl';
				
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/' . $template)) {
			$this->template = $this->config->get('config_template') . '/template/common/' . $template;
		} else {
			$this->template = 'default/template/common/' . $template;
		}
		
		/*$this->children = array(
			'common/searchforrent',
			'common/searchsale',
		);*/
								
		$this->render();
	}
}
?>
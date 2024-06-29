<?php
class ControllerCmsProduct extends Controller {
	private $error = array();

	public function __construct($registry) {
		$this->registry = $registry;

		$this->load->model('catalog/lang');

		$langs = $this->model_catalog_lang->getLangByModule('product',1);
		foreach($langs as $lang){
			$this->data[$lang['key']] = html_entity_decode($lang['name']);
		}
	}

	public function index() {
		$this->load->model('cms/product');
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
		
		$this->data['submenu'] = $this->model_cms_common->getMenu($arr_path[0],1);
		
		if(!isset($arr_path[1]))
		{
			$check = 1;
			$tmp = reset($this->data['submenu']);	
			$arr_path[1] = $tmp['id'];
		}
		
		$this->data['menu_active'] = $arr_path[1];
		
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
		
		
		$infoActive1_data = $this->cache->get('category.bgid.' . $arr_path[1] . '.' . $this->config->get('config_language_id'));
		if (!$infoActive1_data) {
			$this->data['infoActive1'] = $this->model_cms_common->getBackgroundPage($arr_path[1]);
			$this->cache->set('category.bgid.' . $arr_path[1] . '.' . (int)$this->config->get('config_language_id'), $this->data['infoActive1'], CACHE_TIME);
		}else{
			$this->data['infoActive1'] = $infoActive1_data;
		}
		
		$infoActive2_data = $this->cache->get('category.bgid.' . $arr_path[2] . '.' . $this->config->get('config_language_id'));
		if (!$infoActive2_data) {
			$this->data['infoActive2'] = $this->model_cms_common->getBackgroundPage($arr_path[2]);
			$this->cache->set('category.bgid.' . $arr_path[2] . '.' . (int)$this->config->get('config_language_id'), $this->data['infoActive2'], CACHE_TIME);
		}else{
			$this->data['infoActive2'] = $infoActive2_data;
		}
		
		$products_data = $this->cache->get('products.' . $arr_path[2] . '.' . $this->config->get('config_language_id'));
		if (!$products_data) {
			$this->data['products'] = $this->model_cms_product->getProductByCate($arr_path[2]);
			$this->cache->set('products.' . $arr_path[2] . '.' . (int)$this->config->get('config_language_id'), $this->data['products'], CACHE_TIME);
		}else{
			$this->data['products'] = $products_data;
		}
		

		$template = 'product.tpl';
		
		if(isset($check)){
			if($check==1){
				$seo = $this->model_cms_common->getSeo($arr_path[0]);
			}else{
				$seo = $this->model_cms_common->getSeo($arr_path[1]);
			}
		}else{
			$seo = $this->model_cms_common->getSeo($arr_path[2]);
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
		                        'common/header',
		                        'common/footer',
		                        );

		$this->response->setOutput($this->render());
	}

	public function detail() {
		$this->load->model('cms/product');
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
		
		
		$infoActive1_data = $this->cache->get('category.bgid.' . $arr_path[1] . '.' . $this->config->get('config_language_id'));
		if (!$infoActive1_data) {
			$this->data['infoActive1'] = $this->model_cms_common->getBackgroundPage($arr_path[1]);
			$this->cache->set('category.bgid.' . $arr_path[1] . '.' . (int)$this->config->get('config_language_id'), $this->data['infoActive1'], CACHE_TIME);
		}else{
			$this->data['infoActive1'] = $infoActive1_data;
		}
		
		$infoActive2_data = $this->cache->get('category.bgid.' . $arr_path[2] . '.' . $this->config->get('config_language_id'));
		if (!$infoActive2_data) {
			$this->data['infoActive2'] = $this->model_cms_common->getBackgroundPage($arr_path[2]);
			$this->cache->set('category.bgid.' . $arr_path[2] . '.' . (int)$this->config->get('config_language_id'), $this->data['infoActive2'], CACHE_TIME);
		}else{
			$this->data['infoActive2'] = $infoActive2_data;
		}
		
		$product_id = isset($this->request->get['product_id'])?	(int)$this->request->get['product_id']:0;
		$this->data['product_id'] = $product_id;
		
		$this->data['product'] = $this->model_cms_product->getProduct($product_id);
		
		$this->data['products'] = $this->model_cms_product->getRelatedProduct($path,$arr_path[2],$product_id);
		
		$this->data['href_back'] = $this->url->link('cms/product','path='. $path,$this->config->get('config_language')) .'.html';

		$template = 'product_detail.tpl';
		$seo = $this->data['product'];

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
}
?>
<?php  
class ControllerCommonMenu extends Controller {
	public function __construct($registry) {
		$this->registry = $registry;
		
		$this->load->model('catalog/lang');		   	
		
		$langs = $this->model_catalog_lang->getLangByModule('menu',1);
		
		foreach($langs as $lang){
			$this->data[$lang['key']] = $lang['name'];
		}
	}
	
	public function index() {
		$this->load->model('cms/common');
		//$this->load->model('cms/video');
		$this->data['menus'] = $this->model_cms_common->getMenu(0,1);
		
		$this->data['lang'] = $this->config->get('config_language');
		
		$path = isset($this->request->get['path'])?$this->request->get['path']:0;
		$tmp_paths = explode('_', $path);
		
		$tmp_paths[0] = ($tmp_paths[0]==0)?ID_HOME:$tmp_paths[0];
		
		$this->data['menu_active'] = isset($this->request->post['isSearch']) || isset($this->request->post['isThanks'])?0:$tmp_paths[0];
		$this->data['sub_active'] = isset($tmp_paths[1])?$tmp_paths[1]:0;
		
		$this->data['config_dangkynhantin'] = $this->config->get('config_dangkynhantin');
		
		$this->data['aboutus_id'] = isset($this->request->get['aboutus_id'])?$this->request->get['aboutus_id']:0;
		$this->data['location_id'] = isset($this->request->get['location_id'])?$this->request->get['location_id']:0;
		$this->data['contact_id'] = isset($this->request->get['contact_id'])?$this->request->get['contact_id']:0;
		
		$this->data['submenu'] = array();
		
		if($tmp_paths[0]==ID_ABOUTUS){
			$this->load->model('cms/aboutus');
			$this->data['submenu'] = $this->model_cms_aboutus->getAboutuss($tmp_paths[0]);
			//$tmp = reset($this->data['submenu']);	
			//$tmp_paths[2] = $tmp['id'];
		}
		
		if($tmp_paths[0]==ID_LOCATION){
			$this->load->model('cms/location');
			$this->data['submenu'] = $this->model_cms_location->getLocations($tmp_paths[0]);
		}
		
		if($tmp_paths[0]==ID_CONTACT){
			$this->load->model('cms/contact');
			$this->data['submenu'] = $this->model_cms_contact->getContacts($tmp_paths[0]);
		}
		
		if($tmp_paths[0]==ID_LIBRARY){
			$this->load->model('cms/album');
			$this->load->model('cms/brochure');
			$this->load->model('cms/video');
			$this->data['submenu'] = $this->model_cms_common->getMenu($tmp_paths[0],1);
			$this->data['albums'] = $this->model_cms_album->getAlbums($tmp_paths[0]);
			$this->data['brochures'] = $this->model_cms_brochure->getBrochures($tmp_paths[0]);
			$this->data['videos'] = $this->model_cms_video->getVideos($tmp_paths[0]);
		}
		
		if($tmp_paths[0]==ID_NEWS){
			$this->load->model('cms/news');
			$this->data['submenu'] = $this->model_cms_common->getMenu($tmp_paths[0],1);
			foreach($this->data['submenu'] as $key=>$item){
				$this->data['submenu'][$key]['newss'] = $this->model_cms_news->getNewsByCateFixed($item['id'],'t2.news_id,t2.desc_short, t2.description,t2.name,t2.meta_keyword,t2.meta_description,t2.meta_title,t2.meta_description_og,t2.meta_title_og,t1.image,t1.category_id, t1.isnew');
			}
		}
		
		
		//$this->data['menu_active'] = $tmp_paths[0];
		
		/*if(!isset($tmp_paths[1]))
		{
			$this->data['submenu'] = $this->model_cms_common->getMenu($tmp_paths[0],1);
			$tmp = reset($this->data['submenu']);	
			$tmp_paths[1] = $tmp['id'];
		}
		
		if($tmp_paths[0]==ID_PRODUCT){
			if(!isset($tmp_paths[2]))
			{
				$this->data['submenu'] = $this->model_cms_common->getMenu($tmp_paths[1],1);
				$tmp = reset($this->data['submenu']);	
				$tmp_paths[2] = $tmp['id'];
			}
		}
		
		
		$this->data['menu1_active'] = isset($tmp_paths[1])?$tmp_paths[1]:0;
		$this->data['menu2_active'] = isset($tmp_paths[2])?$tmp_paths[2]:0;
		*/
		$this->data['getHome'] = $this->model_cms_common->getIntro(ID_HOME);
		
		//$this->data['videos'] = $this->model_cms_video->getHome();
		
		//$this->data['link_gopy'] = str_replace('HTTP_CATALOG',HTTP_SERVER,$this->config->get('config_link_popup'));
		
		$template = 'menu.tpl';
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/' . $template)) {
			$this->template = $this->config->get('config_template') . '/template/common/' . $template;
		} else {
			$this->template = 'default/template/common/' . $template;
		}
		
		$this->children = array(
			'common/share',
			'common/hotline',
			'common/language',
		);
		
		$this->render();
	}
}
?>
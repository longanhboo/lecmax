<?php
class ControllerCmsAmp extends Controller {
	private $error = array();
	private $lang_url = '';

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
		$this->load->model('cms/ampcd');
		
		//print_r($this->request->get);die;
		
		$path = isset($this->request->get['path'])?$this->request->get['path']:0;
		$tmp_paths = explode('_', $path);
		
		$tmp_paths[0] = ($tmp_paths[0]==0)?ID_HOME:$tmp_paths[0];
		
		$this->data['menu_active'] = isset($this->request->post['isSearch'])?0:$tmp_paths[0];
		
		$project_id = isset($this->request->get['project_id'])?$this->request->get['project_id']:0;
		$brand_id = isset($this->request->get['brand_id'])?$this->request->get['brand_id']:0;
		$product_id = isset($this->request->get['product_id'])?$this->request->get['product_id']:0;
		$recruitment_id = isset($this->request->get['recruitment_id'])?$this->request->get['recruitment_id']:0;
		$solution_id = isset($this->request->get['solution_id'])?$this->request->get['solution_id']:0;
		$service_id = isset($this->request->get['service_id'])?$this->request->get['service_id']:0;
		$news_id = isset($this->request->get['news_id'])?$this->request->get['news_id']:0;
		$latestnews_id = isset($this->request->get['latestnews_id'])?$this->request->get['latestnews_id']:0;
		
		$this->data['ampcd'] = $this->model_cms_ampcd->getAmpcd($this->data['menu_active']);
		
		if(!isset($this->data['ampcd']['name'])){
			if(($project_id)){
				$this->redirect($this->url->link('cms/home','path='. $path . '&project_id=' . $project_id,$this->config->get('config_language')) .'.html');
			}else{
				$url = substr(str_replace(array('vi/amp/','en/amp/','/amp/'),array('vi/','en/','.html'),$this->request->server['REQUEST_URI']),1);
				$this->redirect(HTTP_SERVER . $url);
			//$this->redirect($this->url->link('cms/home','path='. $tmp_paths[0],$this->config->get('config_language')) .'.html');
			}
		}
		
		
		$this->data['menus'] = $this->model_cms_common->getMenu(0);
		
		$this->data['sub_active'] = isset($tmp_paths[1])?$tmp_paths[1]:0;
		
		//print_r($this->data['ampcd']);
		
		if($tmp_paths[0]==ID_ABOUTUS){
			$langs = $this->model_catalog_lang->getLangByModule('aboutus',1);
			foreach($langs as $lang){
				$this->data[$lang['key']] = html_entity_decode($lang['name']);
			}
			$this->data['aboutuss'] = $this->data['ampcd']['amp_pagelistaboutuss'];//$this->model_cms_ampcd->getAboutussAmp(ID_ABOUTUS);
			$template = 'amp_aboutus.tpl';
		}elseif($tmp_paths[0]==ID_CONTACT){
			$langs = $this->model_catalog_lang->getLangByModule('contact',1);
			foreach($langs as $lang){
				$this->data[$lang['key']] = html_entity_decode($lang['name']);
			}
			$this->data['contacts'] = $this->model_cms_ampcd->getContactsAmp(ID_CONTACT);
			$template = 'amp_contact.tpl';
		}/*elseif($tmp_paths[0]==ID_SHOWROOM){
			$langs = $this->model_catalog_lang->getLangByModule('showroom',1);
			foreach($langs as $lang){
				$this->data[$lang['key']] = html_entity_decode($lang['name']);
			}
			$this->data['showrooms'] = $this->model_cms_ampcd->getShowroomsAmp(ID_SHOWROOM);
			$template = 'amp_showroom.tpl';
		}*//*elseif($tmp_paths[0]==ID_BRAND){
			$langs = $this->model_catalog_lang->getLangByModule('brand',1);
			foreach($langs as $lang){
				$this->data[$lang['key']] = html_entity_decode($lang['name']);
			}
			
			if ($brand_id) {
				$this->data['brands'] = $this->data['ampcd']['amp_pagelistbrands'];
				$template = 'amp_brand.tpl';
			}else{
				$this->data['brands'] = $this->data['ampcd']['amp_pagelistbrands'];//$this->model_cms_ampcd->getProjectsPageClientAmp(ID_PROJECT);
				//print_r($this->data['ampcd']['amp_pagelistbrands']);
				$template = 'amp_brand.tpl';
			}
		}*/elseif($tmp_paths[0]==ID_PROJECT){
			$langs = $this->model_catalog_lang->getLangByModule('project',1);
			foreach($langs as $lang){
				$this->data[$lang['key']] = html_entity_decode($lang['name']);
			}
			
			//if (!in_array($project_id, $this->data['ampcd']['amp_projects']) && $project_id) {
			if ($project_id) {
				//$this->redirect($this->url->link('cms/home','path='. $path . '&project_id=' . $project_id,$this->config->get('config_language')) .'.html');
				$this->data['projects'] = $this->data['ampcd']['amp_pagelistprojects'];
				//$template = 'amp.tpl';
				$template = 'amp_project.tpl';
			}else{
				$this->data['projects'] = $this->data['ampcd']['amp_pagelistprojects'];//$this->model_cms_ampcd->getProjectsPageClientAmp(ID_PROJECT);
				//print_r($this->data['ampcd']['amp_pagelistprojects']);
				$template = 'amp_project.tpl';
			}
		}elseif($tmp_paths[0]==ID_PRODUCT){
			$langs = $this->model_catalog_lang->getLangByModule('product',1);
			foreach($langs as $lang){
				$this->data[$lang['key']] = html_entity_decode($lang['name']);
			}
			if ($product_id) {
				$this->data['products'] = $this->data['ampcd']['amp_pagelistproducts'];
				$template = 'amp_product.tpl';
			}else{
				$this->data['products'] = $this->data['ampcd']['amp_pagelistproducts'];
				$template = 'amp_product.tpl';
			}
		}/*elseif($tmp_paths[0]==ID_SERVICE){
			$langs = $this->model_catalog_lang->getLangByModule('service',1);
			foreach($langs as $lang){
				$this->data[$lang['key']] = html_entity_decode($lang['name']);
			}
			if ($service_id) {
				$this->data['services'] = $this->data['ampcd']['amp_pagelistservices'];
				$template = 'amp_service.tpl';
			}else{
				$this->data['services'] = $this->data['ampcd']['amp_pagelistservices'];
				$template = 'amp_service.tpl';
			}
		}*/elseif($tmp_paths[0]==ID_SOLUTION){
			$langs = $this->model_catalog_lang->getLangByModule('solution',1);
			foreach($langs as $lang){
				$this->data[$lang['key']] = html_entity_decode($lang['name']);
			}
			if ($solution_id) {
				$this->data['solutions'] = $this->data['ampcd']['amp_pagelistsolutions'];
				$template = 'amp_solution.tpl';
			}else{
				$this->data['solutions'] = $this->data['ampcd']['amp_pagelistsolutions'];
				$template = 'amp_solution.tpl';
			}
		}elseif($tmp_paths[0]==ID_NEWS){
			$langs = $this->model_catalog_lang->getLangByModule('news',1);
			foreach($langs as $lang){
				$this->data[$lang['key']] = html_entity_decode($lang['name']);
			}
			
			$this->data['submenu'] = $this->model_cms_common->getMenu(ID_NEWS);
			
			if(!isset($tmp_paths[1]))
			{
				$tmp = reset($this->data['submenu']);	
				$tmp_paths[1] = $tmp['id'];
			}
			
			$this->data['sub_active'] = isset($tmp_paths[1])?$tmp_paths[1]:0;
			
			
			if($this->data['sub_active']){
				$this->data['banner'] = $this->model_cms_common->getBackgrounds($this->data['sub_active']);
			}
			
			if ($news_id) {
				$this->load->model('cms/news');
				//$this->redirect($this->url->link('cms/home','path='. $path . '&project_id=' . $project_id,$this->config->get('config_language')) .'.html');
				//$this->data['newss'] = $this->data['ampcd']['amp_pagelistnewss'];
				
				$this->data['newss1'] = $this->model_cms_news->getNewsByCateFixed($tmp_paths[1],'t2.news_id,t2.desc_short, t2.description,t2.name,t2.meta_keyword,t2.meta_description,t2.meta_title,t2.meta_description_og,t2.meta_title_og,t1.image,t1.category_id, t1.isnew, t1.date_insert',' ORDER BY  t1.date_insert DESC, t1.sort_order ASC, t1.news_id DESC',-2,array('id'=>$news_id,'old'=>1,'new'=>0),1,3);
				$temp = 3;
				if(count($this->data['newss1'])==1){
					$temp = 4;
				}if(count($this->data['newss1'])==0){
					$temp = 5;
				}
				$this->data['newss2'] = $this->model_cms_news->getNewsByCateFixed($tmp_paths[1],'t2.news_id,t2.desc_short, t2.description,t2.name,t2.meta_keyword,t2.meta_description,t2.meta_title,t2.meta_description_og,t2.meta_title_og,t1.image,t1.category_id, t1.isnew, t1.date_insert',' ORDER BY  t1.date_insert DESC, t1.sort_order ASC, t1.news_id DESC',-2,array('id'=>$news_id,'old'=>0,'new'=>1),1,$temp);
				
				$this->data['newss'] = array_merge($this->data['newss1'],$this->data['newss2']);
				
				$this->data['news'] = $this->model_cms_ampcd->getNews($news_id);
				$template = 'amp_news_detail.tpl';
			}elseif ($recruitment_id) {
				$this->load->model('cms/recruitment');
				$this->data['recruitment_id'] = $recruitment_id;
				$this->data['newss'] = $this->model_cms_recruitment->getRecruitmentByParent($tmp_paths[1],1);
				
				$this->data['news'] = $this->model_cms_ampcd->getRecruitment($recruitment_id);
				$template = 'amp_recruitment_detail.tpl';
			}elseif ($latestnews_id) {
				$this->redirect($this->url->link('cms/business','path='. $path . '&latestnews_id='.$latestnews_id,$this->config->get('config_language')) .'.html');
				$this->load->model('cms/latestnews');
				$this->data['latestnews_id'] = $latestnews_id;
				$this->data['newss'] = $this->model_cms_latestnews->getLatestnewss($tmp_paths[1]);
				
				$this->data['news'] = $this->model_cms_ampcd->getLatestnews($latestnews_id);
				
				//$file_temp=file_get_contents("http://my.ancuong2018.com/ban-tin-an-cuong/03-2019-w4-vietbuild-1554369372.html");
				
				$template = 'amp_latestnews_detail.tpl';
			}else{
				//$this->data['submenu'] = $this->model_cms_common->getMenu(ID_NEWS);
				
				if($this->data['sub_active']==ID_RECRUITMENT){
					$this->load->model('cms/recruitment');
					$this->data['newss'] = $this->model_cms_recruitment->getRecruitmentByParent($tmp_paths[1],1);
					//$this->data['newss'] = $this->data['ampcd']['amp_pagelistnewss'];//$this->model_cms_ampcd->getProjectsPageClientAmp(ID_PROJECT);
					//print_r($this->data['ampcd']['amp_pagelistprojects']);
					$template = 'amp_recruitment.tpl';
				}elseif($this->data['sub_active']==ID_BAN_TIN_AC){
					$this->redirect($this->url->link('cms/business','path='. $path,$this->config->get('config_language')) .'.html');
					$this->load->model('cms/latestnews');
					$this->data['newss'] = $this->model_cms_latestnews->getLatestnewss($tmp_paths[1]);
					//$this->data['newss'] = $this->data['ampcd']['amp_pagelistnewss'];//$this->model_cms_ampcd->getProjectsPageClientAmp(ID_PROJECT);
					//print_r($this->data['ampcd']['amp_pagelistprojects']);
					$template = 'amp_latestnews.tpl';
				}else{
					$this->data['newss'] = $this->model_cms_ampcd->getNewsByCate($tmp_paths[1],100);
					//$this->data['newss'] = $this->data['ampcd']['amp_pagelistnewss'];//$this->model_cms_ampcd->getProjectsPageClientAmp(ID_PROJECT);
					//print_r($this->data['ampcd']['amp_pagelistprojects']);
					$template = 'amp_news.tpl';
				}
			}
			
			//if (!in_array($project_id, $this->data['ampcd']['amp_projects']) && $project_id) {
			/*if ($news_id) {
				//$this->redirect($this->url->link('cms/home','path='. $path . '&project_id=' . $project_id,$this->config->get('config_language')) .'.html');
				$this->data['newss'] = $this->data['ampcd']['amp_pagelistnewss'];
				$template = 'amp.tpl';
			}else{*/
				//////$this->data['newss'] = $this->data['ampcd']['amp_pagelistnewss'];//$this->model_cms_ampcd->getProjectsPageClientAmp(ID_PROJECT);
				//print_r($this->data['ampcd']['amp_pagelistprojects']);
				//////$template = 'amp_news.tpl';
			//}
		}/*elseif($tmp_paths[0]==ID_PARTNER){
			$langs = $this->model_catalog_lang->getLangByModule('listpartner',1);
			foreach($langs as $lang){
				$this->data[$lang['key']] = html_entity_decode($lang['name']);
			}
			
			$this->data['partners'] = $this->data['ampcd']['amp_pagelistlistpartners'];
			$template = 'amp_partner.tpl';
		}*/elseif($tmp_paths[0]==ID_RECRUITMENT){
			$langs = $this->model_catalog_lang->getLangByModule('recruitment',1);
			foreach($langs as $lang){
				$this->data[$lang['key']] = html_entity_decode($lang['name']);
			}
			
			$this->data['recruitments'] = $this->data['ampcd']['amp_pagelistrecruitments'];
			$template = 'amp_recruitment.tpl';
		}/*elseif($tmp_paths[0]==ID_SHAREHOLDER){
			
			$langs = $this->model_catalog_lang->getLangByModule('shareholder',1);
			foreach($langs as $lang){
				$this->data[$lang['key']] = html_entity_decode($lang['name']);
			}

			$this->data['link_shareholder'] = str_replace('HTTP_CATALOG',HTTP_SERVER,$this->config->get('config_link_shareholder'));
			$this->data['shareholders'] = $this->data['ampcd']['amp_pagelistcodong'];
			$template = 'amp_shareholder.tpl';
			
		}elseif($tmp_paths[0]==ID_BUSINESS){
			$langs = $this->model_catalog_lang->getLangByModule('business',1);
			foreach($langs as $lang){
				$this->data[$lang['key']] = html_entity_decode($lang['name']);
			}
			$this->data['cate_projects'] = $this->model_cms_common->getMenu(ID_PROJECT_BDS_DANDUNG);
			$this->data['businesss'] = $this->data['ampcd']['amp_pagelistbusinesss'];//$this->model_cms_ampcd->getServicesAmp(ID_SERVICE);
			$template = 'amp_business.tpl';
		}*/else{
			/*$langs = $this->model_catalog_lang->getLangByModule('project',1);
			foreach($langs as $lang){
				$this->data[$lang['key']] = html_entity_decode($lang['name']);
			}
			//$this->data['projects'] = $this->model_cms_ampcd->getProjectsAmp(ID_PROJECT);
			$this->data['projects'] = $this->data['ampcd']['amp_pagelistprojects'];
			$template = 'amp.tpl';*/
			$langs = $this->model_catalog_lang->getLangByModule('news',1);
			foreach($langs as $lang){
				$this->data[$lang['key']] = html_entity_decode($lang['name']);
			}
			
			$this->data['submenu'] = $this->model_cms_common->getMenu(ID_NEWS);
			
			if(!isset($tmp_paths[1]))
			{
				$tmp = reset($this->data['submenu']);	
				$tmp_paths[1] = $tmp['id'];
			}
			
			$this->data['sub_active'] = isset($tmp_paths[1])?$tmp_paths[1]:0;
			
			
			//if($this->data['sub_active']){
				//$this->data['banner'] = $this->model_cms_common->getBackgrounds($this->data['sub_active']);
			//}
			
			
			$this->data['banner'] = array(array('image'=>str_replace(HTTP_IMAGE,'',$this->data['ampcd']['image']), 'image1'=>str_replace(HTTP_IMAGE,'',$this->data['ampcd']['image']), 'name'=>''));
			
			
			$this->data['newss'] = $this->model_cms_ampcd->getNewsByCate($tmp_paths[1],100);
			
			$template = 'amp_news.tpl';
		}
		
		$this->data['getActive'] = $this->model_cms_common->getIntro($this->data['menu_active']);
		
		if($project_id){
			$seo = $this->data['project'];
		}elseif($news_id){
			$seo = $this->data['news'];
		}elseif(isset($tmp_paths[1])){
			$seo = $this->model_cms_common->getIntro($tmp_paths[1]);
		}else{
			$seo = $this->model_cms_common->getIntro($this->data['menu_active']);
		}
		
		$this->document->setKeywords($seo['meta_keyword']);
		$this->document->setDescription($seo['meta_description']);
		$this->document->setTitle($seo['meta_title']);
		$this->document->setDescriptionog($seo['meta_description_og']);
		$this->document->setTitleog($seo['meta_title_og']);
		$this->document->setImageog($seo['image_og']);
				
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/amp/' . $template )) {
			$this->template = $this->config->get('config_template') . '/template/amp/' . $template ;
		} else {
			$this->template = 'default/template/amp/' . $template ;
		}
		
		$this->children = array(
		                        'common/headeramp',
								'common/menuamp'
								);

		//$this->response->addHeader("Content-type: text/xml");
		$this->response->setOutput($this->render());
	}

}
?>
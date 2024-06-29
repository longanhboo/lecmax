<?php
class ControllerCmsNews extends Controller {
	private $error = array();

	public function __construct($registry) {
		$this->registry = $registry;

		$this->load->model('catalog/lang');

		$langs = $this->model_catalog_lang->getLangByModule('news',1);
		foreach($langs as $lang){
			$this->data[$lang['key']] = html_entity_decode($lang['name']);
		}
		$this->data['lang'] = $this->config->get('config_language');
	}

	public function index() {
		$this->load->model('cms/news');
		//$this->load->model('cms/recruitment');
		//$this->load->model('cms/latestnews');
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
		
		
		$news_id = isset($this->request->get['news_id'])?	(int)$this->request->get['news_id']:0;
		$this->data['news_id'] = $news_id;
		
		//$recruitment_id = isset($this->request->get['recruitment_id'])?	(int)$this->request->get['recruitment_id']:0;
		//$this->data['recruitment_id'] = $recruitment_id;
		
		//$latestnews_id = isset($this->request->get['latestnews_id'])?	(int)$this->request->get['latestnews_id']:0;
		//$this->data['latestnews_id'] = $latestnews_id;
		
		$this->data['submenu'] = $this->model_cms_common->getMenu($arr_path[0],1);
		
		if(!isset($arr_path[1]))
		{
			$check = 1;
			$tmp = reset($this->data['submenu']);	
			$arr_path[1] = $tmp['id'];
		}
		
		$this->data['menu_active'] = $arr_path[1];
		
		$infoActive1_data = $this->cache->get('category.bgid.' . $arr_path[1] . '.' . $this->config->get('config_language_id'));
		if (!$infoActive1_data) {
			$this->data['infoActive1'] = $this->model_cms_common->getBackgroundPage($arr_path[1]);
			$this->cache->set('category.bgid.' . $arr_path[1] . '.' . (int)$this->config->get('config_language_id'), $this->data['infoActive1'], CACHE_TIME);
		}else{
			$this->data['infoActive1'] = $infoActive1_data;
		}
		//$this->data['getActive'] = $this->model_cms_common->getBackgroundPage($arr_path[1]);
		
		/*if($arr_path[1]==ID_RECRUITMENT){
			
			if(isset($this->request->post['name']) && !empty($this->request->post['name']))
				$this->data['name'] 		= $this->request->post['name'];
			else
				$this->data['name']			= $this->data['text_name_recruitment'];
				
			if(isset($this->request->post['phone']) && !empty($this->request->post['phone']))
				$this->data['phone'] 		= $this->request->post['phone'];
			else
				$this->data['phone']		= $this->data['text_phone_recruitment'];
			
			if(isset($this->request->post['email']) && !empty($this->request->post['email']))	
				$this->data['email'] 		= $this->request->post['email'];
			else
				$this->data['email']		= $this->data['text_email_recruitment'];
			
			
			$template = 'recruitment.tpl';
		}elseif($arr_path[1]==ID_BAN_TIN_AC){
			$template = 'news_ancuong.tpl';
		}else*/{
			$template = 'news.tpl';
		}
		
		if(isAjax()){
			if($news_id){
				$this->data['menu_active'] = isset($arr_path[1])?$arr_path[1]:0;
				$template = 'news_detail.tpl';
				 $detail_news                    = $this->model_cms_news->getNewsFixed($this->data['news_id'],'t2.news_id AS id,t2.name,t2.description,t2.meta_keyword,t2.meta_description,t2.meta_title,t2.meta_description_og,t2.meta_title_og,t1.image_og, t1.date_insert');
				$this->data['news']             = $detail_news;
				
				if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/cms/'.'news_detail.tpl')) {
						$this->template = $this->config->get('config_template') . '/template/cms/'.'news_detail.tpl';
				} else {
						$this->template = 'default/template/common/'. 'news_detail.tpl';
				}
				$render                         = $this->render();
				die($render);
			}/*elseif($recruitment_id){
				$this->data['menu_active'] = isset($arr_path[1])?$arr_path[1]:0;
				$template = 'recruitment_detail.tpl';
				
				$recruitment_data = $this->cache->get('recruitments' . '.' . $arr_path[1] . '.' . $this->config->get('config_language_id'));
				if (!$recruitment_data) {
					$this->data['recruitments'] = $this->model_cms_recruitment->getRecruitmentByParent($arr_path[1],0);
					$this->cache->set('recruitments' . '.' . $arr_path[1] . '.' . (int)$this->config->get('config_language_id'), $this->data['recruitments'], CACHE_TIME);
				}else{
					$this->data['recruitments'] = $recruitment_data;
				}
				
				
				 $detail_recruitment                    = $this->model_cms_recruitment->getRecruitment($this->data['recruitment_id']);
				$this->data['recruitment']             = $detail_recruitment;
				
				if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/cms/'.'recruitment_detail.tpl')) {
						$this->template = $this->config->get('config_template') . '/template/cms/'.'recruitment_detail.tpl';
				} else {
						$this->template = 'default/template/common/'. 'recruitment_detail.tpl';
				}
				$render                         = $this->render();
				die($render);
			}*/else{
				$index_news = isset($this->request->get['indexnews'])?	(int)$this->request->get['indexnews']:0;
				$this->data['newss'] = $this->model_cms_news->getNewsByCateFixed($arr_path[1],'t2.news_id,t2.desc_short, t2.description,t2.name,t2.meta_keyword,t2.meta_description,t2.meta_title,t2.meta_description_og,t2.meta_title_og,t1.image,t1.category_id, t1.isnew, t1.date_insert',' ORDER BY  t1.date_insert DESC, t1.sort_order ASC, t1.news_id DESC',$index_news);
				
				$template = 'news_list.tpl';
				
			}
			
			
			
			//echo 'aaaaaaa';die;
			
		}else{
			
			/*if($arr_path[1]==ID_RECRUITMENT){
				$recruitment_data = $this->cache->get('recruitments' . '.' . $arr_path[1] . '.' . $this->config->get('config_language_id'));
				if (!$recruitment_data) {
					$this->data['recruitments'] = $this->model_cms_recruitment->getRecruitmentByParent($arr_path[1],0);
					$this->cache->set('recruitments' . '.' . $arr_path[1] . '.' . (int)$this->config->get('config_language_id'), $this->data['recruitments'], CACHE_TIME);
				}else{
					$this->data['recruitments'] = $recruitment_data;
				}
			}elseif($arr_path[1]==ID_BAN_TIN_AC){
				$this->data['latestnewss'] = $this->model_cms_latestnews->getLatestnewss($arr_path[1]);
				
			}else*/{
				$news_data = $this->cache->get('news' . '.' . $arr_path[1] . '.' . $this->config->get('config_language_id'));
				if (!$news_data) {
					$this->data['newss'] = $this->model_cms_news->getNewsByCateFixed($arr_path[1],'t2.news_id,t2.desc_short, t2.description,t2.name,t2.meta_keyword,t2.meta_description,t2.meta_title,t2.meta_description_og,t2.meta_title_og,t1.image,t1.category_id, t1.isnew, t1.date_insert',' ORDER BY  t1.date_insert DESC, t1.sort_order ASC, t1.news_id DESC',-1);
					$this->cache->set('news' . '.' . $arr_path[1] . '.' . (int)$this->config->get('config_language_id'), $this->data['newss'], CACHE_TIME);
				}else{
					$this->data['newss'] = $news_data;
				}
			}
			
			//print_r($this->data['newss']);
			
			//$paging = ceil(count($this->data['newss'])/PAGING_NEWS);
			//$this->data['paging'] = $paging;
			
			//print_r($this->data['newss']);die;
			
			/*$this->data['menu_active'] = isset($arr_path[1])?$arr_path[1]:0;
			
			$this->data['submenu'] = $this->model_cms_common->getMenu($arr_path[0],1);
				if(!isset($arr_path[1]))
				{
					$tmp = reset($this->data['submenu']);	
					$arr_path[1] = $tmp['id'];
				}*/
			$submenu_data = $this->cache->get('newssubmenu' . '.' . $this->config->get('config_language_id'));
			if (!$submenu_data) {	
				foreach($this->data['submenu'] as $key=>$item){
					$this->data['submenu'][$key]['category_id'] = $item['id'];
					$this->data['submenu'][$key]['url_current'] = $this->model_cms_news->getFriendlyUrl('category_id='.ID_NEWS, $this->config->get('config_language_id')) . '/' . $this->model_cms_news->getFriendlyUrl('category_id='.$item['id'],$this->config->get('config_language_id'));
					
					/*if($item['id']==ID_RECRUITMENT){
						$this->data['submenu'][$key]['newss'] = $this->model_cms_recruitment->getRecruitmentByParent($item['id'],0);
					}elseif($item['id']==ID_BAN_TIN_AC){
						$this->data['submenu'][$key]['newss'] = $this->model_cms_latestnews->getLatestnewss($arr_path[1]);
					}else*/{
						$this->data['submenu'][$key]['newss'] = $this->model_cms_news->getNewsByCateFixed($item['id'],'t2.news_id,t2.desc_short, t2.description,t2.name,t2.meta_keyword,t2.meta_description,t2.meta_title,t2.meta_description_og,t2.meta_title_og,t1.image,t1.category_id, t1.isnew, t1.date_insert',' ORDER BY t1.date_insert DESC, t1.sort_order ASC, t1.news_id DESC',0);
					}
					
				}
				
				
				
				$this->cache->set('newssubmenu' . '.' . $this->config->get('config_language_id'), $this->data['submenu'], CACHE_TIME);
			}else{
				$this->data['submenu'] = $submenu_data;
			}
			//print_r($this->data['submenu']);
			//get cache
			/*$cache_file                     = $this->loadCache('news_index@'.$this->config->get('config_language_id').ID_NEWS);
			if($cache_file['success']){
				$this->data['render2'] = $cache_file['data'];
			} else {
				
				//$this->data['menu_active'] = $arr_path[1];
				
				
				if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/cms/'.'news_page_slider.tpl')) {
						$this->template         = $this->config->get('config_template') . '/template/cms/'.'news_page_slider.tpl';
				} else {
						$this->template         = 'default/template/common/'. 'news_page_slider.tpl';
				}
				$this->data['render2']          = $this->render();
				
				$this->endLoadCache($cache_file['data'], str_replace('current', '',$this->data['render2']));
			}*/
			//end cache
			
			//$image_bg = $this->config->get('config_news_bg');
			//$this->data['image_bg'] = (!empty($image_bg) && is_file(DIR_IMAGE . $image_bg))?HTTP_IMAGE.$image_bg:PATH_IMAGE_BG;
			
			//$this->data['infoActive'] = $this->model_cms_common->getBackgroundPage($arr_path[0]);
			
		}
		
		/*$this->data['latestnews'] = array();
		if($latestnews_id){
			$this->load->model('cms/latestnews');
			
			$this->data['latestnews'] = $this->model_cms_latestnews->getLatestnews($latestnews_id);
			
			if(isAjax()){
				$template = 'news_detail_ajax_iframe.tpl';
			}else{
			////*$this->data['newss1'] = $this->model_cms_news->getNewsByCateFixed($arr_path[1],'t2.news_id,t2.desc_short, t2.description,t2.name,t2.meta_keyword,t2.meta_description,t2.meta_title,t2.meta_description_og,t2.meta_title_og,t1.image,t1.category_id, t1.isnew, t1.date_insert',' ORDER BY  t1.date_insert DESC, t1.sort_order ASC, t1.news_id DESC',-2,array('id'=>$news_id,'old'=>1,'new'=>0));
			$this->data['newss2'] = $this->model_cms_news->getNewsByCateFixed($arr_path[1],'t2.news_id,t2.desc_short, t2.description,t2.name,t2.meta_keyword,t2.meta_description,t2.meta_title,t2.meta_description_og,t2.meta_title_og,t1.image,t1.category_id, t1.isnew, t1.date_insert',' ORDER BY  t1.date_insert DESC, t1.sort_order ASC, t1.news_id DESC',-2,array('id'=>$news_id,'old'=>0,'new'=>1));
			
			$this->data['latestnewss'] = array_merge($this->data['newss1'],array($this->data['latestnews']),$this->data['newss2']);
			* ////////////
			$this->data['latestnewss'] = $this->model_cms_latestnews->getLatestnewss($arr_path[1]);
			
			
			$template = 'news_detail_iframe.tpl';
			}
			
		}*/
		
		if($news_id){
			$seo = $this->model_cms_news->getNews($news_id);
			$this->data['news'] = $seo;
		}/*elseif($recruitment_id){
			$seo = $this->model_cms_recruitment->getRecruitment($recruitment_id);
			$this->data['recruitment'] = $seo;
		}elseif($latestnews_id){
			$seo = $this->data['latestnews'];
		}*/
		elseif(!isset($check)){
			$seo = $this->model_cms_common->getSeo($arr_path[1]);
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
		
		if(!isAjax()){
		$this->children = array(
			'common/footer',
			'common/header',
		);
		}

		$this->response->setOutput($this->render());
	}

	public function detail() {
		$this->load->model('cms/news');
		$this->load->model('cms/common');
		//$this->load->model('cms/recruitment');
		//$this->load->model('cms/latestnews');

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
		
		$news_id = isset($this->request->get['news_id'])?	(int)$this->request->get['news_id']:0;
		$this->data['news_id'] = $news_id;
		
		$this->data['news'] = $this->model_cms_news->getNews($news_id);
		
		if(!isAjax()){
			$this->data['submenu'] = $this->model_cms_common->getMenu($arr_path[0],1);
		
			if(!isset($arr_path[1]))
			{
				$tmp = reset($this->data['submenu']);	
				$arr_path[1] = $tmp['id'];
			}
			
			$this->data['menu_active'] = $arr_path[1];
			
			
			$submenu_data = $this->cache->get('newssubmenu' . '.' . $this->config->get('config_language_id'));
			if (!$submenu_data) {	
				foreach($this->data['submenu'] as $key=>$item){
					$this->data['submenu'][$key]['category_id'] = $item['id'];
					$this->data['submenu'][$key]['url_current'] = $this->model_cms_news->getFriendlyUrl('category_id='.ID_NEWS, $this->config->get('config_language_id')) . '/' . $this->model_cms_news->getFriendlyUrl('category_id='.$item['id'],$this->config->get('config_language_id'));
					
					/*if($item['id']==ID_RECRUITMENT){
						$this->data['submenu'][$key]['newss'] = $this->model_cms_recruitment->getRecruitmentByParent($item['id'],0);
					}elseif($item['id']==ID_BAN_TIN_AC){
						$this->data['submenu'][$key]['newss'] = $this->model_cms_latestnews->getLatestnewss($arr_path[1]);
					}else*/{
						$this->data['submenu'][$key]['newss'] = $this->model_cms_news->getNewsByCateFixed($item['id'],'t2.news_id,t2.desc_short, t2.description,t2.name,t2.meta_keyword,t2.meta_description,t2.meta_title,t2.meta_description_og,t2.meta_title_og,t1.image,t1.category_id, t1.isnew, t1.date_insert',' ORDER BY  t1.date_insert DESC, t1.sort_order ASC, t1.news_id DESC',0);
					}
					
				}
				
				$this->cache->set('newssubmenu' . '.' . $this->config->get('config_language_id'), $this->data['submenu'], CACHE_TIME);
			}else{
				$this->data['submenu'] = $submenu_data;
			}
			
			
			/*foreach($this->data['submenu'] as $key=>$item){
				$newss = $this->model_cms_news->getNewsByCate($item['id'],-1);
				$this->data['submenu'][$key]['newss'] = $newss;
			}*/
			
			//$news_data = $this->cache->get('news' . '.' . $arr_path[1] . '.' . $this->config->get('config_language_id'));
			//if (!$news_data) {
				////$this->data['newss1'] = $this->model_cms_news->getNewsByCateFixed($arr_path[1],'t2.news_id,t2.desc_short, t2.description,t2.name,t2.meta_keyword,t2.meta_description,t2.meta_title,t2.meta_description_og,t2.meta_title_og,t1.image,t1.category_id, t1.isnew, t1.date_insert',' ORDER BY  t1.date_insert DESC, t1.sort_order ASC, t1.news_id DESC',-2,array('id'=>$news_id,'old'=>1,'new'=>0));
				////$this->data['newss2'] = $this->model_cms_news->getNewsByCateFixed($arr_path[1],'t2.news_id,t2.desc_short, t2.description,t2.name,t2.meta_keyword,t2.meta_description,t2.meta_title,t2.meta_description_og,t2.meta_title_og,t1.image,t1.category_id, t1.isnew, t1.date_insert',' ORDER BY  t1.date_insert DESC, t1.sort_order ASC, t1.news_id DESC',-2,array('id'=>$news_id,'old'=>0,'new'=>1));
				
				////$this->data['newss'] = array_merge($this->data['newss1'],array($this->data['news']),$this->data['newss2']);
				//$this->cache->set('news' . '.' . $arr_path[1] . '.' . (int)$this->config->get('config_language_id'), $this->data['newss'], CACHE_TIME);
			//}else{
				//$this->data['newss'] = $news_data;
			//}
			
			$this->data['newss'] = $this->model_cms_news->getRelatedNews($path,$arr_path[1],$news_id);
		
			//$this->data['infoActive'] = $this->model_cms_common->getBackgroundPage($arr_path[0]);
			//$this->data['getActive'] = $this->model_cms_common->getBackgroundPage($arr_path[1]);
			$infoActive1_data = $this->cache->get('category.bgid.' . $arr_path[1] . '.' . $this->config->get('config_language_id'));
			if (!$infoActive1_data) {
				$this->data['infoActive1'] = $this->model_cms_common->getBackgroundPage($arr_path[1]);
				$this->cache->set('category.bgid.' . $arr_path[1] . '.' . (int)$this->config->get('config_language_id'), $this->data['infoActive1'], CACHE_TIME);
			}else{
				$this->data['infoActive1'] = $infoActive1_data;
			}
			//$this->data['getNews'] = $this->model_cms_common->getIntro(ID_NEWS);
			
			//print_r($this->data['newss1']);
			//print_r($this->data['newss2']);
			/*if($arr_path[1]==ID_BAN_TIN_AC){
				$template = 'news_detail_iframe.tpl';
			}else*/{
				$template = 'news_detail.tpl';
			}
			
			$seo = $this->data['news'];

			$this->document->setKeywords($seo['meta_keyword']);
			$this->document->setDescription($seo['meta_description']);
			$this->document->setTitle($seo['meta_title']);
			$this->document->setDescriptionog($seo['meta_description_og']);
			$this->document->setTitleog($seo['meta_title_og']);
			$this->document->setImageog($seo['image_og']);
			
		}else{
			/*if($arr_path[1]==ID_BAN_TIN_AC){
				$template = 'news_detail_ajax_iframe.tpl';
			}else*/{
				$template = 'news_detail_ajax.tpl';
			}
			
		}
		


		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/cms/'.$template)) {
			$this->template = $this->config->get('config_template') . '/template/cms/'.$template;
		} else {
			$this->template = 'default/template/common/'. $template;
		}
		if(!isAjax()){
		$this->children = array(
			'common/footer',
			'common/header',
		);
		}

		$this->response->setOutput($this->render());
	}
}
?>
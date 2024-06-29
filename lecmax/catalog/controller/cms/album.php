<?php
class ControllerCmsAlbum extends Controller {
	private $error = array();

	public function __construct($registry) {
		$this->registry = $registry;

		$this->load->model('catalog/lang');

		$langs = $this->model_catalog_lang->getLangByModule('album',1);
		foreach($langs as $lang){
			$this->data[$lang['key']] = html_entity_decode($lang['name']);
		}
	}

	public function index() {
		//$this->load->model('cms/album');
		$this->load->model('cms/common');
		$this->load->model('cms/video');
		$this->load->model('cms/document');
		//$this->load->model('cms/brochure');

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
		
		$document_id = isset($this->request->get['document_id'])?	(int)$this->request->get['document_id']:0;
		$this->data['document_id'] = $document_id;
		
		if($document_id){
			$this->data['document'] = $this->model_cms_document->getDocument($document_id);
		}
		
		
		if(isAjax()){
			$template = 'document_detail.tpl';
		}else{
			$this->data['submenu'] = $this->model_cms_common->getMenu($arr_path[0],1);
			
			//$this->data['tieuchuans'] = $this->model_cms_tieuchuan->getTieuchuans($arr_path[0]);
			
			if(!isset($arr_path[1]))
			{
				$check = 1;
				$tmp = reset($this->data['submenu']);	
				$arr_path[1] = $tmp['id'];
			}
			
			$this->data['menu_active'] = isset($arr_path[1])?$arr_path[1]:0;
			
			$infoActive1_data = $this->cache->get('category.bgid.' . $arr_path[1] . '.' . $this->config->get('config_language_id'));
			if (!$infoActive1_data) {
				$this->data['infoActive1'] = $this->model_cms_common->getBackgroundPage($arr_path[1]);
				$this->cache->set('category.bgid.' . $arr_path[1] . '.' . (int)$this->config->get('config_language_id'), $this->data['infoActive1'], CACHE_TIME);
			}else{
				$this->data['infoActive1'] = $infoActive1_data;
			}
			
			//$this->data['getApartment'] = $this->model_cms_common->getIntro(ID_APARTMENT);
			//$this->data['getFacilities'] = $this->model_cms_common->getIntro(ID_FACILITIES);
			
			/*foreach($this->data['submenu'] as $key=>$item){
				if($item['id']==ID_LIBRARY_TCVN){
					$this->data['submenu'][$key]['brochures'] = array();
					$this->data['submenu'][$key]['tieuchuans'] = $this->data['tieuchuans'];
					foreach($this->data['submenu'][$key]['tieuchuans'] as $keychild=>$child){
						$this->data['submenu'][$key]['tieuchuans'][$keychild]['brochures'] = $this->model_cms_brochure->getBrochureByCate($item['id'],$child['id']);
					}
				}else{
				$this->data['submenu'][$key]['brochures'] = $this->model_cms_brochure->getBrochureByCate($item['id']);
				}
			}*/
			
			//$this->data['albums'] = $this->model_cms_album->getAlbums($arr_path[0]);
			
			$documents_data = $this->cache->get('documents.' . $this->config->get('config_language_id'));
			if (!$documents_data) {
				$this->data['documents'] = $this->model_cms_document->getDocuments($arr_path[0]);
				$this->cache->set('documents.' . (int)$this->config->get('config_language_id'), $this->data['documents'], CACHE_TIME);
			}else{
				$this->data['documents'] = $documents_data;
			}
			
			$videos_data = $this->cache->get('videos.' . $this->config->get('config_language_id'));
			if (!$videos_data) {
				$this->data['videos'] = $this->model_cms_video->getVideos($arr_path[0]);
				$this->cache->set('videos.' . (int)$this->config->get('config_language_id'), $this->data['videos'], CACHE_TIME);
			}else{
				$this->data['videos'] = $videos_data;
			}
			
			
			
			
			
			$template = 'library.tpl';
		}
		if($document_id){
			$seo = $this->data['document'];
		}elseif(!isset($check)){
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

		$this->children = array(
			'common/footer',
			//'common/logo',
			//'common/slogan',
			//'common/register',
			//'common/menu',
			//'common/hotline',
			'common/header',
		);

		$this->response->setOutput($this->render());
	}

	public function detail() {
		$this->load->model('cms/album');
		$this->load->model('cms/common');
		
		if(!isAjax()){
			$this->redirect(HTTP_SERVER);
		}

		$path = isset($this->request->get['path'])?$this->request->get['path']:0;
		
		$album_id = isset($this->request->get['id'])?	(int)$this->request->get['id']:0;

		$this->data['album'] = $this->model_cms_album->getImages($album_id);

		$template = 'album.tpl';
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/cms/'.$template)) {
			$this->template = $this->config->get('config_template') . '/template/cms/'.$template;
		} else {
			$this->template = 'default/template/common/'. $template;
		}

		$this->response->setOutput($this->render());
	}
}
?>
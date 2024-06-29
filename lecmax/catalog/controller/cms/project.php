<?php
class ControllerCmsProject extends Controller {
	private $error = array();

	public function __construct($registry) {
		$this->registry = $registry;

		$this->load->model('catalog/lang');

		$langs = $this->model_catalog_lang->getLangByModule('project',1);
		foreach($langs as $lang){
			$this->data[$lang['key']] = html_entity_decode($lang['name']);
		}
	}

	public function index() {
		$this->load->model('cms/project');
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
		
		$project_id = isset($this->request->get['project_id'])?	(int)$this->request->get['project_id']:0;
		$project_data = $this->cache->get('projects' . '.' . $this->config->get('config_language_id'));
		if (!$project_data) {
			$this->data['projects'] = $this->model_cms_project->getProjectByParent($arr_path[0],0);
			$this->cache->set('projects' . '.' . (int)$this->config->get('config_language_id'), $this->data['projects'], CACHE_TIME);
		}else{
			$this->data['projects'] = $project_data;
		}
		
		if(!isset($project_id) || $project_id==0)
		{
			$check = 1;
			$tmp = reset($this->data['projects']);	
			$project_id = $tmp['id'];
		}
		
		
		$this->data['project_id'] = $project_id;
		$cateproject = isset($this->request->get['cateproject'])?	(int)$this->request->get['cateproject']:0;
		$this->data['cateproject'] = $cateproject?$cateproject:$project_id;
		
		if($this->data['project_id']!=$this->data['cateproject']){
			
			$this->data['projectRelated'] = $this->model_cms_project->getRelatedProject($path,$this->data['cateproject'],$project_id);
			
			$template = 'project_detail.tpl';
		}else{
			
			//$this->data['projects'] = $this->model_cms_project->getProjects($arr_path[0]);
	
			$template = 'project.tpl';
		}
		
		
		//echo $project_id;
		//echo $cateproject;
		if($project_id){
			
			$project_data = $this->cache->get('project' . '.' . $project_id . '.' . $this->config->get('config_language_id'));
			if (!$project_data) {
				$this->data['project'] = $this->model_cms_project->getProject($project_id);
				$this->cache->set('project' . '.' . $project_id . '.' . (int)$this->config->get('config_language_id'), $this->data['project'], CACHE_TIME);
			}else{
				$this->data['project'] = $project_data;
			}
			
			$project_data = $this->cache->get('project' . '.' . $this->data['cateproject'] . '.' . $this->config->get('config_language_id'));
			if (!$project_data) {
				$this->data['cate_project'] = $this->model_cms_project->getProject($this->data['cateproject']);
				$this->cache->set('project' . '.' . $this->data['cateproject'] . '.' . (int)$this->config->get('config_language_id'), $this->data['cate_project'], CACHE_TIME);
			}else{
				$this->data['cate_project'] = $project_data;
			}
		}
		
		if(!isset($check)){	
			//$this->data['cate_project'] = $this->model_cms_project->getProject($cateproject);
			$seo = $this->data['project'];
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
		                        'common/header',
		                        'common/footer',
		                        );
		}

		$this->response->setOutput($this->render());
	}
	
	public function album() {
		$this->load->model('cms/project');
		//$this->load->model('cms/common');
		
		if(!isAjax()){
			$this->redirect(HTTP_SERVER);
		}

		$project_id = isset($this->request->get['id'])?	(int)$this->request->get['id']:0;

		$this->data['album'] = $this->model_cms_project->getImagepros($project_id);

		$template = 'project_album.tpl';

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/cms/'.$template)) {
			$this->template = $this->config->get('config_template') . '/template/cms/'.$template;
		} else {
			$this->template = 'default/template/common/'. $template;
		}

		$this->response->setOutput($this->render());
	}

	public function detail() {
		$this->load->model('cms/project');
		$this->load->model('cms/common');

		$path = isset($this->request->get['path'])?$this->request->get['path']:0;

		$arr_path = explode('_',$path);

		if((int)$arr_path[0]==0)
			$this->redirect($this->url->link('error/not_found'));

		$titlepage = $this->model_cms_common->getTitle($arr_path[0]);
		if($titlepage=='')
			$this->redirect($this->url->link('error/not_found'));

		$project_id = isset($this->request->get['project_id'])?	(int)$this->request->get['project_id']:0;

		$this->data['project'] = $this->model_cms_project->getProject($project_id);

		$template = 'project_detail.tpl';
		$seo = $this->data['project'];

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
		                        'common/menu'
		                        );

		$this->response->setOutput($this->render());
	}
}
?>
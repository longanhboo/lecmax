<?php
class ControllerCmsBrochure extends Controller {
	private $error = array();

	public function __construct($registry) {
		$this->registry = $registry;

		$this->load->model('catalog/lang');

		$langs = $this->model_catalog_lang->getLangByModule('brochure',1);
		foreach($langs as $lang){
			$this->data[$lang['key']] = html_entity_decode($lang['name']);
		}
	}

	public function index() {
		$this->load->model('cms/brochure');
		$this->load->model('cms/video');
		$this->load->model('cms/album');
		$this->load->model('cms/common');

		$path = isset($this->request->get['path'])?$this->request->get['path']:0;

		$arr_path = explode('_',$path);

		if((int)$arr_path[0]==0)
			$this->redirect($this->url->link('error/not_found'));

		$titlepage = $this->model_cms_common->getTitle($arr_path[0]);
		if($titlepage=='')
			$this->redirect($this->url->link('error/not_found'));


		$this->data['brochures'] = $this->model_cms_brochure->getBrochures($arr_path[0]);
		$this->data['videos'] = $this->model_cms_video->getVideos($arr_path[0]);
		$this->data['albums'] = $this->model_cms_album->getAlbums($arr_path[0]);
		$this->data['backgrounds'] = $this->model_cms_common->getBackgroundPage($arr_path[0]);
		$this->data['getTitle'] = $titlepage;

		$template = 'library.tpl';
		$seo = $this->model_cms_common->getSeo($arr_path[0]);

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
			'common/slogan',
			'common/search',
			'common/language',
			'common/logo',
			'common/register',
			'common/header',
			'common/menu',
		);

		$this->response->setOutput($this->render());
	}

	public function detail() {
		$this->load->model('cms/brochure');
		$this->load->model('cms/common');

		$path = isset($this->request->get['path'])?$this->request->get['path']:0;

		$arr_path = explode('_',$path);

		if((int)$arr_path[0]==0)
			$this->redirect($this->url->link('error/not_found'));

		$titlepage = $this->model_cms_common->getTitle($arr_path[0]);
		if($titlepage=='')
			$this->redirect($this->url->link('error/not_found'));

		$brochure_id = isset($this->request->get['brochure_id'])?	(int)$this->request->get['brochure_id']:0;

		$this->data['brochure'] = $this->model_cms_brochure->getBrochure($brochure_id);

		$template = 'brochure_detail.tpl';
		$seo = $this->data['brochure'];

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
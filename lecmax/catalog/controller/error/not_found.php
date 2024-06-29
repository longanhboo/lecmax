<?php    
class ControllerErrorNotFound extends Controller {    
	public function __construct($registry) {
		$this->registry = $registry;

		$this->load->model('catalog/lang');

		$langs = $this->model_catalog_lang->getLangByModule('header',1);

		foreach($langs as $lang){
			$this->data[$lang['key']] = $lang['name'];
		}

		$this->data['lang'] = ($this->config->get('config_language')=='vi')?'':'-en';

		$this->data['lang1'] = ($this->config->get('config_language')=='vi')?'vi':'en';

	}
	
	public function index() { 
		$this->load->language('error/not_found');

		//$this->document->setTitle($this->language->get('heading_title'));

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_home'] = $this->language->get('text_home');
		
		$this->data['text_error'] = $this->language->get('text_error');
		
		$this->data['breadcrumbs'] = array();
		
		
		$title = $this->document->getTitle();
		$title = (empty($title)? $this->data['meta_title'] :  $title);

		$keyword = $this->document->getKeywords();
		$keyword = (empty($keyword)?$this->data['meta_keyword']:$keyword);

		$description = $this->document->getDescription();
		$description = (empty($description)?$this->data['meta_description']:$description);

		$this->data['title_home'] = $this->data['meta_title'];
		$this->data['title'] = $title;
		$this->data['keywords'] = $keyword;
		$this->data['description'] = $description;

		$title_og = $this->document->getTitleog();
		$title_og = (empty($title_og)?$title:$title_og);

		$description_og = $this->document->getDescriptionog();
		$description_og = (empty($description_og)?$this->data['meta_description_og']:$description_og);
		$image_og = $this->document->getImageog();
		$image_og = (empty($image_og)?PATH_TEMPLATE . 'default/images/social-share.png':HTTP_IMAGE . $image_og);
		$url_og = HTTP_SERVER;//"http://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];

		$this->data['title_og'] = $title_og;
		$this->data['image_og'] = $image_og;
		$this->data['url_og'] = $url_og;
		$this->data['description_og'] = $description_og;
		
		$this->document->setTitle($title);


   	/*$this->data['breadcrumbs'][] = array(
    	'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('error/not_found', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
      		);*/

		//$this->template = 'error/not_found.tpl';
			/*
		*/

			$template = 'not_found.tpl';
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/'.$template)) {
				$this->template = $this->config->get('config_template') . '/template/error/'.$template;
			} else {
				$this->template = 'default/template/common/'. $template;
			}

			$this->children = array(
			                        'common/header',
			                        'common/footer'
			                        );

			$this->response->setOutput($this->render());	
		}
	}
	?>
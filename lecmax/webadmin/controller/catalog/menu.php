<?php
class ControllerCatalogMenu extends Controller {
	private $error = array();

	public function __construct($registry) {
		$this->registry = $registry;

		$this->load->model('catalog/lang');

		$langs = $this->model_catalog_lang->getLangByModule('menu',2);
		foreach($langs as $lang){
			$this->data[$lang['key']] = html_entity_decode($lang['name']);
		}

		$this->data['superadmin'] = ($this->user->getId()==1)?true:false;
	}

	public function index() {
		$this->document->setTitle($this->data['heading_title']);

		$this->load->model('catalog/category');

		$this->getList();
	}

	public function insert() {

		$this->document->setTitle($this->data['heading_title']);

		$this->load->model('catalog/category');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_category->addCategory($this->request->post);

			$this->session->data['success'] = $this->data['text_success'];

			$this->redirect($this->url->link('catalog/menu', 'token=' . $this->session->data['token'], '', 'SSL'));
			
			exit;
		}

		$this->getForm();
	}

	public function update() {
		$this->document->setTitle($this->data['heading_title']);

		$this->load->model('catalog/category');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_category->editCategory($this->request->get['category_id'], $this->request->post);

			$this->session->data['success'] = $this->data['text_success_update'];

			$this->redirect($this->url->link('catalog/menu', 'token=' . $this->session->data['token'], '', 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {
		$this->document->setTitle($this->data['heading_title']);

		$this->load->model('catalog/category');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $category_id) {
				$this->model_catalog_category->deleteCategory($category_id);
			}

			$this->session->data['success'] = $this->data['text_success_delete'];

			$this->redirect($this->url->link('catalog/menu', 'token=' . $this->session->data['token'], '', 'SSL'));
		}

		$this->getList();
	}

	private function getList() {

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
		                                     'text'      => $this->data['text_home'],
		                                     'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], '', 'SSL'),
		                                     'separator' => false
		                                     );

		$this->data['breadcrumbs'][] = array(
		                                     'text'      => $this->data['heading_title'],
		                                     'href'      => $this->url->link('catalog/menu', 'token=' . $this->session->data['token'], '', 'SSL'),
		                                     'separator' => ' :: '
		                                     );

		$this->data['insert'] = $this->url->link('catalog/menu/insert', 'token=' . $this->session->data['token'], '', 'SSL');
		$this->data['delete'] = $this->url->link('catalog/menu/delete', 'token=' . $this->session->data['token'], '', 'SSL');

		$this->data['categories'] = array();

		$results = $this->model_catalog_category->getCategories(0,1);

		foreach ($results as $result) {
			$action = array();

			$action[] = array(
			                  'text' => $this->data['text_edit'],
			                  'href' => $this->url->link('catalog/menu/update', 'token=' . $this->session->data['token'] . '&category_id=' . $result['category_id'], '')
			                  );

			$href = $this->url->link('catalog/' . $result['module'], 'token=' . $this->session->data['token'] . '&filter_category=' . $result['category_id'], '');
			//<a class="button goto" href="'.$href.'">Module</a>

			$this->data['categories'][] = array(
			                                    'category_id' => $result['category_id'],
			                                    'name'        => $result['name'],
			                                    'sort_order'  => $result['sort_order'],
			                                    'type'  		=> ($result['type']=='module')?'Module':ucfirst($result['type']),
			                                    'status_id'		=> $result['status'],
			                                    'status'     => ($result['status'] ? '<img src="view/image/success.png" title="'.$this->data['text_enabled'].'" />' : '<img src="view/image/delete.png" title="'.$this->data['text_disabled'].'" />'),
			                                    'mainmenu'     => ($result['mainmenu'] ? '<img src="view/image/success.png" title="'.$this->data['text_enabled'].'" />' : '<img src="view/image/delete.png" title="'.$this->data['text_disabled'].'" />'),
								
								
								'status_en' =>$this->model_catalog_category->getStatus('category',$result['category_id'],1,false),
								
								
			                                    'selected'    => isset($this->request->post['selected']) && in_array($result['category_id'], $this->request->post['selected']),
			                                    'action'      => $action
			                                    );
			/*
		*/
		}

		$this->data['token'] = $this->session->data['token'];

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		$this->template = 'catalog/menu_list.tpl';
		$this->children = array(
		                        'common/header',
		                        'common/footer',
		                        );

		$this->response->setOutput($this->render());
	}

	private function getForm() {
		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->error['name'])) {
			$this->data['error_name'] = $this->error['name'];
		} else {
			$this->data['error_name'] = array();
		}

		if (isset($this->error['image'])) {
			$this->data['error_image'] = $this->error['image'];
		} else {
			$this->data['error_image'] = '';
		}

		if (isset($this->error['template'])) {
			$this->data['error_template'] = $this->error['template'];
		} else {
			$this->data['error_template'] = '';
		}
		
		if (isset($this->error['parent_id'])) {
			$this->data['error_parent_id'] = $this->error['parent_id'];
		} else {
			$this->data['error_parent_id'] = '';
		}

		if (isset($this->error['path'])) {
			$this->data['error_path'] = $this->error['path'];
		} else {
			$this->data['error_path'] = '';
		}

		if (isset($this->error['type_id'])) {
			$this->data['error_type_id'] = $this->error['type_id'];
		} else {
			$this->data['error_type_id'] = '';
		}

		if (isset($this->error['category_image'])) {
			$this->data['error_category_image'] = $this->error['category_image'];
		} else {
			$this->data['error_category_image'] = '';
		}

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
		                                     'text'      => $this->data['text_home'],
		                                     'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], '', 'SSL'),
		                                     'separator' => false
		                                     );

		$this->data['breadcrumbs'][] = array(
		                                     'text'      => $this->data['heading_title'],
		                                     'href'      => $this->url->link('catalog/menu', 'token=' . $this->session->data['token'], '', 'SSL'),
		                                     'separator' => ' :: '
		                                     );

		if (!isset($this->request->get['category_id'])) {
			$this->data['action'] = $this->url->link('catalog/menu/insert', 'token=' . $this->session->data['token'], '', 'SSL');
		} else {
			$this->data['action'] = $this->url->link('catalog/menu/update', 'token=' . $this->session->data['token'] . '&category_id=' . $this->request->get['category_id'], '');
		}

		$this->data['cancel'] = $this->url->link('catalog/menu', 'token=' . $this->session->data['token'], '', 'SSL');

		$this->data['token'] = $this->session->data['token'];

		if (isset($this->request->get['category_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$category_info = $this->model_catalog_category->getCategory($this->request->get['category_id']);
		}

		$this->load->model('localisation/language');

		$this->data['languages'] = $this->model_localisation_language->getLanguages();

		if (isset($this->request->post['category_description'])) {
			$this->data['category_description'] = $this->request->post['category_description'];
		} elseif (isset($category_info)) {
			$this->data['category_description'] = $this->model_catalog_category->getCategoryDescriptions($this->request->get['category_id']);
		} else {
			$this->data['category_description'] = array();
		}

			//tempates
		$this->load->model('catalog/templates');
		$templates = $this->model_catalog_templates->getTemplatesForPage();
		$this->data['templates'] = $templates;


			//modules
		$this->load->model('catalog/module');
		$modules = $this->model_catalog_module->getModuleForPage();
		$this->data['modules'] = $modules;

		$categories = $this->model_catalog_category->getCategories(0);

			// Remove own id from list
		if (isset($category_info)) {
			foreach ($categories as $key => $category) {
				if ($category['category_id'] == $category_info['category_id']) {
					unset($categories[$key]);
				}
			}
		}

		$this->data['categories'] = $categories;

		$this->data['category_images'] = array();

		$this->load->model('tool/image');
		if (isset($this->request->post['image'])) {
			$this->data['image'] = $this->request->post['image'];
		} elseif (isset($category_info)) {
			$this->data['image'] = $category_info['image'];
		} else {
			$this->data['image'] = '';
		}

		if (isset($category_info) && $category_info['image'] && file_exists(DIR_IMAGE . $category_info['image'])) {
			$this->data['preview'] = $this->model_tool_image->resize($category_info['image'], 100, 100);
		} elseif(isset($this->request->post['image']) && !empty($this->request->post['image']) && file_exists(DIR_IMAGE . $this->request->post['image'])) {
			$this->data['preview'] = $this->model_tool_image->resize($this->request->post['image'], 100, 100);
		}else{
			$this->data['preview'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}
		
		if (isset($this->request->post['image1'])) {
			$this->data['image1'] = $this->request->post['image1'];
		} elseif (isset($category_info)) {
			$this->data['image1'] = $category_info['image1'];
		} else {
			$this->data['image1'] = '';
		}

		if (isset($category_info) && $category_info['image1'] && file_exists(DIR_IMAGE . $category_info['image1'])) {
			$this->data['preview1'] = $this->model_tool_image->resize($category_info['image1'], 100, 100);
		} elseif(isset($this->request->post['image1']) && !empty($this->request->post['image1']) && file_exists(DIR_IMAGE . $this->request->post['image1'])) {
			$this->data['preview1'] = $this->model_tool_image->resize($this->request->post['image1'], 100, 100);
		}else{
			$this->data['preview1'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}


		$this->load->model('tool/image');
		if (isset($this->request->post['image_og'])) {
			$this->data['image_og'] = $this->request->post['image_og'];
		} elseif (isset($category_info)) {
			$this->data['image_og'] = $category_info['image_og'];
		} else {
			$this->data['image_og'] = '';
		}

		if (isset($category_info) && $category_info['image_og'] && file_exists(DIR_IMAGE . $category_info['image_og'])) {
			$this->data['preview_og'] = $this->model_tool_image->resize($category_info['image_og'], 100, 100);
		} elseif(isset($this->request->post['image_og']) && !empty($this->request->post['image_og']) && file_exists(DIR_IMAGE . $this->request->post['image_og'])) {
			$this->data['preview_og'] = $this->model_tool_image->resize($this->request->post['image_og'], 100, 100);
		}else{
			$this->data['preview_og'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}

		if (isset($this->request->post['category_image'])) {
			$category_images = $this->request->post['category_image'];
		} elseif (isset($category_info)) {
			$category_images = $this->model_catalog_category->getCategoryImages($this->request->get['category_id']);
		} else {
			$category_images = array();
		}

		foreach ($category_images as $category_image) {
			if ($category_image['image'] && file_exists(DIR_IMAGE . $category_image['image'])) {
				$image = $category_image['image'];
			} else {
				$image = 'no_image.jpg';
			}

			if ($category_image['image1'] && file_exists(DIR_IMAGE . $category_image['image1'])) {
				$image1 = $category_image['image1'];
			} else {
				$image1 = 'no_image.jpg';
			}

			$this->data['category_images'][] = array(
			                                         'image_1'   => $image,
			                                         'image_2'   => $image1,
			                                         'preview_1' => $this->model_tool_image->resize($image, 100, 100),
			                                         'preview_2' => $this->model_tool_image->resize($image1, 100, 100),
													 'image_name' => $category_image['image_name'],
													 'image_name_en' => $category_image['image_name_en'],
			                                         'image_sort_order' => $category_image['image_sort_order']
			                                         );
		}

		$this->data['no_image'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);

		if (isset($this->request->post['type_id'])) {
			$this->data['type_id'] = $this->request->post['type_id'];
		} elseif (isset($category_info)) {
			$this->data['type_id'] = $category_info['type_id'];
		} else {
			$this->data['type_id'] = '';
		}

		if($this->data['type_id']=='page'){
			if (isset($this->request->post['template'])) {
				$this->data['template'] = $this->request->post['template'];
			} elseif (isset($category_info)) {
				$this->data['template'] = $category_info['template'];
			} else {
				$this->data['template'] = 0;
			}

			if (isset($this->request->post['download'])) {
				$this->data['download'] = $this->request->post['download'];
			} elseif (isset($category_info)) {
				$this->data['download'] = $category_info['download'];
			} else {
				$this->data['download'] = 0;
			}

			if (isset($this->request->post['video'])) {
				$this->data['video'] = $this->request->post['video'];
			} elseif (isset($category_info)) {
				$this->data['video'] = $category_info['video'];
			} else {
				$this->data['video'] = 0;
			}

			$this->data['path'] = '';
		}elseif($this->data['type_id']=='module'){
			if (isset($this->request->post['path'])) {
				$this->data['path'] = $this->request->post['path'];
			} elseif (isset($category_info)) {
				$this->data['path'] = $category_info['path'];
			} else {
				$this->data['path'] = '';
			}
			$this->data['video'] = 0;
			$this->data['download'] = 0;
			$this->data['template'] = 0;
		}else{
			$this->data['video'] = 0;
			$this->data['download'] = 0;
			$this->data['template'] = 0;
			$this->data['path'] = '';
		}

		if (isset($this->request->post['class'])) {
			$this->data['class'] = $this->request->post['class'];
		} elseif (isset($category_info)) {
			$this->data['class'] = $category_info['class'];
		} else {
			$this->data['class'] = '';
		}

		if (isset($this->request->post['mainmenu'])) {
			$this->data['mainmenu'] = $this->request->post['mainmenu'];
		} elseif (isset($category_info)) {
			$this->data['mainmenu'] = $category_info['mainmenu'];
		} else {
			$this->data['mainmenu'] = 0;
		}

		if (isset($this->request->post['parent_id'])) {
			$this->data['parent_id'] = $this->request->post['parent_id'];
		} elseif (isset($category_info)) {
			$this->data['parent_id'] = $category_info['parent_id'];
		} else {
			$this->data['parent_id'] = 0;
		}
		
		if (isset($this->request->post['config_loop_picture'])) {
      		$this->data['config_loop_picture'] = $this->request->post['config_loop_picture'];
    	} elseif (isset($category_info)) {
      		$this->data['config_loop_picture'] = $category_info['config_loop_picture'];
    	} else {
			$this->data['config_loop_picture'] = 5;
		}

		/*if (isset($this->request->post['keyword'])) {
			$this->data['keyword'] = $this->request->post['keyword'];
		} elseif (isset($category_info)) {
			$this->data['keyword'] = $category_info['keyword'];
		} else {
			$this->data['keyword'] = '';
		}*/
		
		if (isset($this->request->post['category_keyword'])) {
			$this->data['category_keyword'] = $this->request->post['category_keyword'];
		} elseif (isset($category_info)) {
			$this->data['category_keyword'] = $this->model_catalog_category->getCategoryKeyword($this->request->get['category_id']);
		} else {
			$this->data['category_keyword'] = array();
		}
		
		
		if (isset($this->request->post['ishome'])) {
			$this->data['ishome'] = $this->request->post['ishome'];
		} elseif (isset($category_info)) {
			$this->data['ishome'] = $category_info['ishome'];
		} else {
			$this->data['ishome'] = 0;
		}
		
		if (isset($this->request->post['iconsvg'])) {
			$this->data['iconsvg'] = $this->request->post['iconsvg'];
		} elseif (isset($category_info)) {
			$this->data['iconsvg'] = $category_info['iconsvg'];
		} else {
			$this->data['iconsvg'] = '';
		}

		if (isset($this->request->post['sort_order'])) {
			$this->data['sort_order'] = $this->request->post['sort_order'];
		} elseif (isset($category_info)) {
			$this->data['sort_order'] = $category_info['sort_order'];
		} else {
			$this->data['sort_order'] = 0;
		}

		if (isset($this->request->post['status'])) {
			$this->data['status'] = $this->request->post['status'];
		} elseif (isset($category_info)) {
			$this->data['status'] = $category_info['status'];
		} else {
			$this->data['status'] = 1;
		}

		if(isset($this->request->get['category_id']))
			$this->data['category_id'] = $this->request->get['category_id'];
		else
			$this->data['category_id'] = 0;

		$this->template = 'catalog/menu_form.tpl';
		$this->children = array(
		                        'common/header',
		                        'common/footer',
		                        );

		$this->response->setOutput($this->render());
	}

	private function validateForm() {
		if (!$this->user->hasPermission('modify', 'catalog/category')) {
			$this->error['warning'] = $this->data['error_permission'];
		}
		/*
		if(empty($this->request->post['image']))
		$this->error['image'] = $this->data['error_image'];

		if(!isset($this->request->post['category_image']))
		$this->error['category_image'] = $this->data['error_list_image'];	*/
		if(empty($this->request->post['type_id']))
			$this->error['type_id'] = $this->data['error_type_id'];

		if($this->request->post['type_id']=='page'){
			if(empty($this->request->post['template']))
				$this->error['template'] = $this->data['error_template'];
		}elseif($this->request->post['type_id']=='module'){
			if(empty($this->request->post['path']))
				$this->error['path'] = $this->data['error_path'];
		}

		if((strlen(utf8_decode($this->request->post['category_description'][$this->config->get('config_language_id')]['name'])) < 1) || (strlen(utf8_decode($this->request->post['category_description'][$this->config->get('config_language_id')]['name'])) > 255))
			$this->error['name'][$this->config->get('config_language_id')] = $this->data['error_name'];

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->data['error_warning'];
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	private function validateDelete() {
		if (!$this->user->hasPermission('modify', 'catalog/category')) {
			$this->error['warning'] = $this->data['error_permission'];
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	public function getdownloadorvideo(){
		$module = $this->request->post['module'];

		$this->load->model('catalog/templates');

		$json = $this->model_catalog_templates->getDownloadOrVideos($module);

		$this->load->library('json');

		$this->response->setOutput(Json::encode($json));
	}
}
?>
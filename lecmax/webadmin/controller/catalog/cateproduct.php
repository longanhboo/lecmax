<?php
class ControllerCatalogCateproduct extends Controller {
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
		$this->document->setTitle($this->data['heading_title_cateproduct']);

		$this->load->model('catalog/category');

		$this->getList();
	}

	public function insert() {

		$this->document->setTitle($this->data['heading_title_cateproduct']);

		$this->load->model('catalog/category');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->request->post['type_id'] = 'module';
			$this->request->post['path'] = substr('cateproduct',4);
			
			$data = $this->request->post;

				
			$time = time();
			
			$this->load->model('localisation/language');		
			$languages = $this->model_localisation_language->getLanguages();
			
			foreach($languages as $lang){
				$parts = pathinfo($this->request->files['category_description']['name'][$lang['language_id']]['pdf']);
								
				if(!empty($parts['filename']))
					$filename = convertAlias($parts['filename']) . '_' . $lang['code'] . '_'. $time . '.' . $parts['extension'];
				else
					$filename = '';
				
				if($this->request->files['category_description']['error'][$lang['language_id']]['pdf']==0){
					@move_uploaded_file($this->request->files['category_description']['tmp_name'][$lang['language_id']]['pdf'], DIR_PDF . $filename);
					$data['category_description'][$lang['language_id']]['pdf'] = $filename;
				}else{
					$data['category_description'][$lang['language_id']]['pdf']='';	
				}								
			}
			/*if($data['sort_order']==0){
				$this->load->model('catalog/product');
				$this->model_catalog_product->UpdateOrderProduct($data['parent_id']);
			}*/

			$this->model_catalog_category->addCategory($data);
			
			$this->load->model('tool/image');
			if (isset($this->request->post['image1'])) {
				if (file_exists(DIR_IMAGE . $this->request->post['image1']) && is_file(DIR_IMAGE . $this->request->post['image1'])) {
					list($widthImg, $heightImg) = getimagesize(DIR_IMAGE.$this->request->post['image1']);
					$this->model_tool_image->resize_mobile($this->request->post['image1'], $widthImg*2/3, $heightImg*2/3);
				}
			}

			$this->session->data['success'] = $this->data['text_success'];
			$this->cache->delete('');

			$this->redirect($this->url->link('catalog/cateproduct', 'token=' . $this->session->data['token'], '', 'SSL'));
			
			exit;
		}

		$this->getForm();
	}

	public function update() {
		$this->document->setTitle($this->data['heading_title_cateproduct']);

		$this->load->model('catalog/category');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			
			$data = $this->request->post;

						$time = time();
			
			$this->load->model('localisation/language');		
			$languages = $this->model_localisation_language->getLanguages();
			
			foreach($languages as $lang){
				$parts = pathinfo($this->request->files['category_description']['name'][$lang['language_id']]['pdf']);
				
				if(!empty($parts['filename']))
					$filename = convertAlias($parts['filename']) . '_' . $lang['code'] . '_'. $time . '.' . $parts['extension'];
				else
					$filename = '';
				
				if(isset($this->request->post['category_description'][$lang['language_id']]['delete_pdf']) && $this->request->post['category_description'][$lang['language_id']]['delete_pdf']==1)
				{
					$data['category_description'][$lang['language_id']]['pdf'] = '';
					$old_file = $this->request->post['category_description'][$lang['language_id']]['old_file'];
					if(!empty($old_file) && file_exists(DIR_PDF . $old_file))
						unlink(DIR_PDF . $old_file);
				}else{
					if($this->request->files['category_description']['error'][$lang['language_id']]['pdf']==0){
						
						$old_file = $this->request->post['category_description'][$lang['language_id']]['old_file'];
						if(!empty($old_file) && file_exists(DIR_PDF . $old_file))
							unlink(DIR_PDF . $old_file);
						
						@move_uploaded_file($this->request->files['category_description']['tmp_name'][$lang['language_id']]['pdf'], DIR_PDF . $filename);
						$data['category_description'][$lang['language_id']]['pdf'] = $filename;
					}else{
						$data['category_description'][$lang['language_id']]['pdf']=$this->request->post['category_description'][$lang['language_id']]['old_file'];	
					}
				}				
			}
			
			$this->model_catalog_category->editCategory($this->request->get['category_id'], $data);
			
			$this->load->model('tool/image');
			if (isset($this->request->post['image1'])) {
				if (file_exists(DIR_IMAGE . $this->request->post['image1']) && is_file(DIR_IMAGE . $this->request->post['image1'])) {
					list($widthImg, $heightImg) = getimagesize(DIR_IMAGE.$this->request->post['image1']);
					$this->model_tool_image->resize_mobile($this->request->post['image1'], $widthImg*2/3, $heightImg*2/3);
				}
			}

			$this->session->data['success'] = $this->data['text_success_update'];
			$this->cache->delete('');

			$this->redirect($this->url->link('catalog/cateproduct', 'token=' . $this->session->data['token'], '', 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {
		$this->document->setTitle($this->data['heading_title_cateproduct']);

		$this->load->model('catalog/category');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $category_id) {
				
				//$this->model_catalog_category->updateStatus($category_id,'product');
				$this->model_catalog_category->deleteCategory($category_id);
			}

			$this->session->data['success'] = $this->data['text_success_delete'];
			$this->cache->delete('');

			$this->redirect($this->url->link('catalog/cateproduct', 'token=' . $this->session->data['token'], '', 'SSL'));
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
		                                     'text'      => $this->data['heading_title_cateproduct'],
		                                     'href'      => $this->url->link('catalog/cateproduct', 'token=' . $this->session->data['token'], '', 'SSL'),
		                                     'separator' => ' :: '
		                                     );

		$this->data['insert'] = $this->url->link('catalog/cateproduct/insert', 'token=' . $this->session->data['token'], '', 'SSL');
		$this->data['delete'] = $this->url->link('catalog/cateproduct/delete', 'token=' . $this->session->data['token'], '', 'SSL');

		$this->data['categories'] = array();

		$results = $this->model_catalog_category->getCategories(93);

		foreach ($results as $result) {
			$action = array();

			$action[] = array(
			                  'text' => $this->data['text_edit'],
			                  'href' => $this->url->link('catalog/cateproduct/update', 'token=' . $this->session->data['token'] . '&category_id=' . $result['category_id'], '')
			                  );

			$this->data['categories'][] = array(
			                                    'category_id' => $result['category_id'],
			                                    'name'        => $result['name'],
			                                    'sort_order'  => $result['sort_order'],
			                                    'status_id'		=> $result['status'],
			                                    'status'     => ($result['status'] ? '<img src="view/image/success.png" title="'.$this->data['text_enabled'].'" />' : '<img src="view/image/delete.png" title="'.$this->data['text_disabled'].'" />'),
			                                    'selected'    => isset($this->request->post['selected']) && in_array($result['category_id'], $this->request->post['selected']),
			                                    'action'      => $action
			                                    );
		}

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

		$this->data['token'] = $this->session->data['token'];

		$this->template = 'catalog/cateproduct_list.tpl';
		$this->children = array(
		                        'common/header',
		                        'common/footer',
		                        );

		$this->response->setOutput($this->render());
	}

	private function getForm() {
		$this->data['parent_default'] = 93;
		
		$category_id = isset($this->request->get['category_id'])?(int)$this->request->get['category_id']:0;
		$this->data['category_id'] = $category_id;
		
		if($category_id==160){
			$this->data['entry_image_cateproduct'] = $this->data['entry_image_cateproduct_160'];
			$this->data['help_entry_image_cateproduct'] = $this->data['help_entry_image_cateproduct_160'];
		}
		
		$this->data['entry_image1'] = 'Hình nền';
		$this->data['help_entry_image1'] = 'Kích thước hình 1440 x auto';

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

		if (isset($this->error['category_image'])) {
			$this->data['error_category_image'] = $this->error['category_image'];
		} else {
			$this->data['error_category_image'] = '';
		}
		
		if (isset($this->error['image1'])) {
			$this->data['error_image1'] = $this->error['image1'];
		} else {
			$this->data['error_image1'] = '';
		}
		
		if (isset($this->error['loop_picture'])) {
            $this->data['error_loop_picture'] = $this->error['loop_picture'];
        } else {
            $this->data['error_loop_picture'] = '';
        }
		
		if (isset($this->error['parent_id'])) {
			$this->data['error_parent_id'] = $this->error['parent_id'];
		} else {
			$this->data['error_parent_id'] = '';
		}

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
		                                     'text'      => $this->data['text_home'],
		                                     'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], '', 'SSL'),
		                                     'separator' => false
		                                     );

		$this->data['breadcrumbs'][] = array(
		                                     'text'      => $this->data['heading_title_cateproduct'],
		                                     'href'      => $this->url->link('catalog/cateproduct', 'token=' . $this->session->data['token'], '', 'SSL'),
		                                     'separator' => ' :: '
		                                     );

		if (!isset($this->request->get['category_id'])) {
			$this->data['action'] = $this->url->link('catalog/cateproduct/insert', 'token=' . $this->session->data['token'], '', 'SSL');
		} else {
			$this->data['action'] = $this->url->link('catalog/cateproduct/update', 'token=' . $this->session->data['token'] . '&category_id=' . $this->request->get['category_id'], '');
		}

		$this->data['cancel'] = $this->url->link('catalog/cateproduct', 'token=' . $this->session->data['token'], '', 'SSL');

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

		$categories = $this->model_catalog_category->getCategories(93,1);

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

		/*{IMAGE_FORM}*/

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
			                                         'image_sort_order' => $category_image['image_sort_order']
			                                         );
		}

		$this->data['no_image'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);

		if (isset($this->request->post['path'])) {
			$this->data['path'] = $this->request->post['path'];
		} elseif (isset($category_info)) {
			$this->data['path'] = $category_info['path'];
		} else {
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
		
		//$this->load->model('catalog/subcateproduct');			
		$this->data['subcateproducts'] = array();//$this->model_catalog_subcateproduct->getSubcateproducts(array('sort' => 'p.sort_order', 'order' => 'ASC'));
		
		if (isset($this->request->post['subcateproduct_id'])) {
			$this->data['subcateproduct_id'] = $this->request->post['subcateproduct_id'];
		} elseif (isset($category_info)) {
			$this->data['subcateproduct_id'] = $category_info['subcateproduct_id'];
		} else {
			$this->data['subcateproduct_id'] = 0;
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

		$this->template = 'catalog/cateproduct_form.tpl';
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
		
		$parent_id = isset($this->request->post['parent_id'])?(int)$this->request->post['parent_id']:0;
		$category_id = isset($this->request->get['category_id'])?(int)$this->request->get['category_id']:0;
		
		if($parent_id!=93){
			$this->request->post['iscateproduct'] = 1;
		}else{
			$this->request->post['iscateproduct'] = 2;
		}
		/*if($this->user->getId()!=1){
			//if($parent_id==93 && $category_id!=168 && $category_id!=164 ){
			if( $parent_id==93 && $category_id!=265 && $category_id!=266     ){
			//if(empty($this->request->post['image']))
//				$this->error['image'] = $this->data['error_image'];
//			
//			if(empty($this->request->post['image1']))
//				$this->error['image1'] = $this->data['error_image'];
//				
				$this->error['parent_id'] = $this->data['error_parent_id'];
			}
		}*/
		
		/*if(!isset($this->request->post['category_image']))
			$this->error['category_image'] = $this->data['error_list_image'];
*/

		/*if(empty($this->request->post['image']))
				$this->error['image'] = $this->data['error_image'];*/

		/*
		
		


		if(((strlen(utf8_decode($this->request->post['config_loop_picture'])) < 1) || (strlen(utf8_decode($this->request->post['config_loop_picture'])) > 2)) || (int)$this->request->post['config_loop_picture']>10)
			$this->error['loop_picture'] = $this->data['help_loop_picture'];
		*/
		
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
		
		if(count(array_intersect(array(407,1),$this->request->post['selected']))>0)
		{
			$this->error['warning'] = "Không thể xoá mục \"Phụ kiện\". Nếu không muốn hiển thị chọn \"Sửa\" và chọn tình trạng là \"Tắt\"!";
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
}
?>
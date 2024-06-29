<?php
class ControllerCatalogTemplates extends Controller {
	private $error = array();

	public function __construct($registry) {
		$this->registry = $registry;

		$this->load->model('catalog/lang');

		$langs = $this->model_catalog_lang->getLangByModule('templates',2);
		foreach($langs as $lang){
			$this->data[$lang['key']] = $lang['name'];
		}

		$this->data['superadmin'] = ($this->user->getId()==1)?true:false;
		/*{$CHANGE_TITLE}*/
	}

	public function index() {
		$this->document->setTitle($this->data['heading_title']);

		$this->load->model('catalog/templates');

		$this->getList();
	}

	public function insert() {

		$this->document->setTitle($this->data['heading_title']);

		$this->load->model('catalog/templates');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$data = $this->request->post;

			if (is_uploaded_file($this->request->files['video_mp4']['tmp_name'])) {

				$ext = strrchr($this->request->files['video_mp4']['name'], '.');

				$name = substr($this->request->files['video_mp4']['name'],0, (strlen($this->request->files['video_mp4']['name']) - strlen($ext)));

				$filename = $name . '.' . md5(rand()) . $ext;

				move_uploaded_file($this->request->files['video_mp4']['tmp_name'], DIR_TEMPLATES . $filename);

				if (file_exists(DIR_TEMPLATES . $filename)) {
					$data['video_mp4'] = $filename;
				}
			}

			/*{INSERT_CONTROLLER}*/

			$this->model_catalog_templates->addTemplates($data);

			$this->session->data['success'] = $this->data['text_success'];

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . $this->request->get['filter_name'];
			}

			/*{FILTER_URL}*/

			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->redirect($this->url->link('catalog/templates', 'token=' . $this->session->data['token'] . $url, '', 'SSL'));
			
			exit;
		}

		$this->getForm();
	}

	public function update() {

		$this->document->setTitle($this->data['heading_title']);

		$this->load->model('catalog/templates');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$data = $this->request->post;

			$filename_old = $this->model_catalog_templates->getVideoById($this->request->get['templates_id']) ;
			if (is_uploaded_file($this->request->files['video_mp4']['tmp_name'])) {

				if (!empty($filename_old['filename_mp4']) && file_exists(DIR_TEMPLATES . $filename_old['filename_mp4'])) {
					@unlink(DIR_TEMPLATES . $filename_old['filename_mp4']);
				}

				$ext = strrchr($this->request->files['video_mp4']['name'], '.');

				$name = substr($this->request->files['video_mp4']['name'],0, (strlen($this->request->files['video_mp4']['name']) - strlen($ext)));

				$filename = $name . '.' . md5(rand()) . $ext;

				move_uploaded_file($this->request->files['video_mp4']['tmp_name'], DIR_TEMPLATES . $filename);

				if (file_exists(DIR_TEMPLATES . $filename)) {
					$data['video_mp4'] = $filename;
				}
			}

			/*{UPDATE_CONTROLLER}*/

			$this->model_catalog_templates->editTemplates($this->request->get['templates_id'], $data);

			$this->session->data['success'] = $this->data['text_success_update'];

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . $this->request->get['filter_name'];
			}

			/*{FILTER_URL}*/

			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->redirect($this->url->link('catalog/templates', 'token=' . $this->session->data['token'] . $url, '', 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {

		$this->document->setTitle($this->data['heading_title']);

		$this->load->model('catalog/templates');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $templates_id) {

				$filename_old = $this->model_catalog_templates->getVideoById($templates_id) ;

				if (!empty($filename_old['filename_mp4']) && file_exists(DIR_TEMPLATES . $filename_old['filename_mp4'])) {
					@unlink(DIR_TEMPLATES . $filename_old['filename_mp4']);
				}

				/*{DELETE_CONTROLLER}*/

				$this->model_catalog_templates->deleteTemplates($templates_id);
			}

			$this->session->data['success'] = $this->data['text_success_delete'];

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . $this->request->get['filter_name'];
			}

			/*{FILTER_URL}*/

			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->redirect($this->url->link('catalog/templates', 'token=' . $this->session->data['token'] . $url, '', 'SSL'));
		}

		$this->getList();
	}

	public function copy() {

		$this->document->setTitle($this->data['heading_title']);

		$this->load->model('catalog/templates');

		if (isset($this->request->post['selected']) && $this->validateCopy()) {
			foreach ($this->request->post['selected'] as $templates_id) {
				$this->model_catalog_templates->copyTemplates($templates_id);
			}

			$this->session->data['success'] = $this->data['text_success'];

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . $this->request->get['filter_name'];
			}

			/*{FILTER_URL}*/

			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->redirect($this->url->link('catalog/templates', 'token=' . $this->session->data['token'] . $url, '', 'SSL'));
		}

		$this->getList();
	}

	private function getList() {

		//================================Filter=================================================
		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = null;
		}

		/*{FILTER_VALUE}*/

		if (isset($this->request->get['filter_status'])) {
			$filter_status = $this->request->get['filter_status'];
		} else {
			$filter_status = null;
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'p.sort_order';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		//================================URL=================================================
		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}

		/*{FILTER_URL}*/

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
		                                     'text'      => $this->data['text_home'],
		                                     'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], '', 'SSL'),
		                                     'separator' => false
		                                     );

		$this->data['breadcrumbs'][] = array(
		                                     'text'      => $this->data['heading_title'],
		                                     'href'      => $this->url->link('catalog/templates', 'token=' . $this->session->data['token'] . $url, '', 'SSL'),
		                                     'separator' => ' :: '
		                                     );

		$this->data['insert'] = $this->url->link('catalog/templates/insert', 'token=' . $this->session->data['token'] . $url, '', 'SSL');
		$this->data['copy'] = $this->url->link('catalog/templates/copy', 'token=' . $this->session->data['token'] . $url, '', 'SSL');
		$this->data['delete'] = $this->url->link('catalog/templates/delete', 'token=' . $this->session->data['token'] . $url, '', 'SSL');
		/*{BACK}*/
		$this->data['templatess'] = array();

		$data = array(
		              'filter_name'	  => $filter_name,
		              /*{FILTER_PARAM}*/
		              'filter_status'   => $filter_status,
		              'sort'            => $sort,
		              'order'           => $order,
		              'start'           => ($page - 1) * $this->config->get('config_admin_limit'),
		              'limit'           => $this->config->get('config_admin_limit')
		              );
		$this->load->model('tool/image');
		$templates_total = $this->model_catalog_templates->getTotalTemplatess($data);

		$results = $this->model_catalog_templates->getTemplatess($data);

		/*{INCLUDE_CATEGORY}*/

		foreach ($results as $result) {
			$action = array();
			/*{SUBLIST}*/
			$action[] = array(
			                  'cls'  =>'modify',
			                  'text' => $this->data['text_edit'],
			                  'href' => $this->url->link('catalog/templates/update', 'token=' . $this->session->data['token'] . '&templates_id=' . $result['templates_id'] . $url, '', 'SSL')
			                  );
			if ($result['image'] && file_exists(DIR_IMAGE . $result['image'])) {
				$image = $this->model_tool_image->resize($result['image'], 40, 40);
			} else {
				$image = $this->model_tool_image->resize('no_image.jpg', 40, 40);
			}
			$this->data['templatess'][] = array(
			                                    'templates_id' => $result['templates_id'],
			                                    'sort_order'       => $result['sort_order'],
			                                    'name'       => $result['name'],
			                                    'image'      => $image,
			                                    'status_id'	=> $result['status'],
			                                    /*{IMAGE_LIST_ARRAY}*/
			                                    'status'     => ($result['status'] ? '<img src="view/image/success.png" title="'.$this->data['text_enabled'].'" />' : '<img src="view/image/delete.png" title="'.$this->data['text_disabled'].'" />'),
			                                    'selected'   => isset($this->request->post['selected']) && in_array($result['templates_id'], $this->request->post['selected']),
			                                    'action'     => $action
			                                    );
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

		//cate danh sach con
		if(isset($this->request->get['cate']) && $this->request->get['cate']>0){
			$this->data['sublist_cate'] = (int)$this->request->get['cate'];
		}else{
			$this->data['sublist_cate'] = 0;
		}

		//================================URL=================================================
		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}

		/*{FILTER_URL}*/

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$this->data['sort_name'] = $this->url->link('catalog/templates', 'token=' . $this->session->data['token'] . '&sort=pd.name' . $url, '', 'SSL');
		$this->data['sort_status'] = $this->url->link('catalog/templates', 'token=' . $this->session->data['token'] . '&sort=p.status' . $url, '', 'SSL');
		$this->data['sort_order'] = $this->url->link('catalog/templates', 'token=' . $this->session->data['token'] . '&sort=p.sort_order' . $url, '', 'SSL');

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}

		/*{FILTER_URL}*/

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $templates_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->data['text_pagination'];
		$pagination->url = $this->url->link('catalog/templates', 'token=' . $this->session->data['token'] . $url . '&page={page}', '', 'SSL');

		$this->data['pagination'] = $pagination->render();

		$this->data['filter_name'] = $filter_name;

		/*{FILTER_DATA}*/

		$this->data['filter_status'] = $filter_status;

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'catalog/templates_list.tpl';
		$this->children = array(
		                        'common/header',
		                        'common/footer',
		                        );

		$this->response->setOutput($this->render());
	}

	private function getForm() {
		/*{FORM_DATA}*/
		//Error
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

		if (isset($this->error['video_webm'])) {
			$this->data['error_video_webm'] = $this->error['video_webm'];
		} else {
			$this->data['error_video_webm'] = '';
		}

		if (isset($this->error['video_mp4'])) {
			$this->data['error_video_mp4'] = $this->error['video_mp4'];
		} else {
			$this->data['error_video_mp4'] = '';
		}

		if (isset($this->error['file_mp4_ftp'])) {
			$this->data['error_file_mp4_ftp'] = $this->error['file_mp4_ftp'];
		} else {
			$this->data['error_file_mp4_ftp'] = '';
		}

		if (isset($this->error['file_webm_ftp'])) {
			$this->data['error_file_webm_ftp'] = $this->error['file_webm_ftp'];
		} else {
			$this->data['error_file_webm_ftp'] = '';
		}

		if (isset($this->error['help_image'])) {
			$this->data['error_help_image'] = $this->error['help_image'];
		} else {
			$this->data['error_help_image'] = '';
		}

		if (isset($this->error['help_image_1'])) {
			$this->data['error_help_image_1'] = $this->error['help_image_1'];
		} else {
			$this->data['error_help_image_1'] = '';
		}

		if (isset($this->error['module_download'])) {
			$this->data['error_module_download'] = $this->error['module_download'];
		} else {
			$this->data['error_module_download'] = '';
		}

		if (isset($this->error['module_video'])) {
			$this->data['error_module_video'] = $this->error['module_video'];
		} else {
			$this->data['error_module_video'] = '';
		}



		/*{ERROR_IMAGE}*/
 		//URL

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}

		/*{FILTER_URL}*/

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
		                                     'text'      => $this->data['text_home'],
		                                     'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], '', 'SSL'),
		                                     'separator' => false
		                                     );

		$this->data['breadcrumbs'][] = array(
		                                     'text'      => $this->data['heading_title'],
		                                     'href'      => $this->url->link('catalog/templates', 'token=' . $this->session->data['token'] . $url, '', 'SSL'),
		                                     'separator' => ' :: '
		                                     );

		//====================================================Assigne Data=======================================================
		if (!isset($this->request->get['templates_id'])) {
			$this->data['action'] = $this->url->link('catalog/templates/insert', 'token=' . $this->session->data['token'] . $url, '', 'SSL');
		} else {
			$this->data['action'] = $this->url->link('catalog/templates/update', 'token=' . $this->session->data['token'] . '&templates_id=' . $this->request->get['templates_id'] . $url, '', 'SSL');
		}

		$this->data['cancel'] = $this->url->link('catalog/templates', 'token=' . $this->session->data['token'] . $url, '', 'SSL');

		$this->data['token'] = $this->session->data['token'];

		//cate danh sach con
		if(isset($this->request->get['cate']) && $this->request->get['cate']>0){
			$sublist_cate = $this->model_catalog_templates->getCateById($this->request->get['cate']);
			$this->data['sublist_cate'] = $sublist_cate;
		}else{
			$this->data['sublist_cate'] = 0;
		}


		if (isset($this->request->get['templates_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$templates_info = $this->model_catalog_templates->getTemplates($this->request->get['templates_id']);
		}

		$this->load->model('localisation/language');

		$this->data['languages'] = $this->model_localisation_language->getLanguages();
		$this->load->model('tool/image');
		if (isset($this->request->post['image'])) {
			$this->data['image'] = $this->request->post['image'];
		} elseif (isset($templates_info)) {
			$this->data['image'] = $templates_info['image'];
		} else {
			$this->data['image'] = '';
		}

		if (isset($templates_info) && $templates_info['image'] && file_exists(DIR_IMAGE . $templates_info['image'])) {
			$this->data['preview'] = $this->model_tool_image->resize($templates_info['image'], 100, 100);
		} elseif(isset($this->request->post['image']) && !empty($this->request->post['image']) && file_exists(DIR_IMAGE . $this->request->post['image'])) {
			$this->data['preview'] = $this->model_tool_image->resize($this->request->post['image'], 100, 100);
		}else{
			$this->data['preview'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}

		if (isset($this->request->post['image_video'])) {
			$this->data['image_video'] = $this->request->post['image_video'];
		} elseif (isset($templates_info)) {
			$this->data['image_video'] = $templates_info['image_video'];
		} else {
			$this->data['image_video'] = '';
		}

		$this->load->model('tool/image');

		if (isset($templates_info) && $templates_info['image_video'] && file_exists(DIR_IMAGE . $templates_info['image_video'])) {
			$this->data['preview_video'] = $this->model_tool_image->resize($templates_info['image_video'], 100, 100);
		} elseif(isset($this->request->post['image_video']) && !empty($this->request->post['image_video']) && file_exists(DIR_IMAGE . $this->request->post['image_video'])) {
			$this->data['preview_video'] = $this->model_tool_image->resize($this->request->post['image_video'], 100, 100);
		}else{
			$this->data['preview_video'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}

		if (isset($this->request->post['isftp'])) {
			$this->data['isftp'] = $this->request->post['isftp'];
		} else if (isset($templates_info)) {
			$this->data['isftp'] = $templates_info['isftp'];
		} else {
			$this->data['isftp'] = 0;
		}

		if (isset($this->request->post['file_mp4_ftp'])) {
			$this->data['file_mp4_ftp'] = $this->request->post['file_mp4_ftp'];
		}else if (isset($templates_info['filename_mp4'])) {
			$this->data['file_mp4_ftp'] = $templates_info['filename_mp4'];
		} else {
			$this->data['file_mp4_ftp'] = '';
		}

		if (isset($this->request->post['file_webm_ftp'])) {
			$this->data['file_webm_ftp'] = $this->request->post['file_webm_ftp'];
		}else if (isset($templates_info['filename_webm'])) {
			$this->data['file_webm_ftp'] = $templates_info['filename_webm'];
		} else {
			$this->data['file_webm_ftp'] = '';
		}

		if (isset($templates_info['filename_webm'])) {
			$this->data['filename_webm'] = $templates_info['filename_webm'];
		} else {
			$this->data['filename_webm'] = '';
		}

		if (isset($templates_info['filename_mp4'])) {
			$this->data['filename_mp4'] = $templates_info['filename_mp4'];
		} else {
			$this->data['filename_mp4'] = '';
		}

		/*{IMAGE_FORM}*/

		if (isset($this->request->post['option_image'])) {
			$this->data['option_image'] = $this->request->post['option_image'];
		} elseif (isset($templates_info)) {
			$this->data['option_image'] = $templates_info['option_image'];
		} else {
			$this->data['option_image'] = 0;
		}

		if (isset($this->request->post['option_images'])) {
			$this->data['option_images'] = $this->request->post['option_images'];
		} elseif (isset($templates_info)) {
			$this->data['option_images'] = $templates_info['option_images'];
		} else {
			$this->data['option_images'] = 0;
		}

		if (isset($this->request->post['option_download'])) {
			$this->data['option_download'] = $this->request->post['option_download'];
		} elseif (isset($templates_info)) {
			$this->data['option_download'] = $templates_info['option_download'];
		} else {
			$this->data['option_download'] = 0;
		}

		if (isset($this->request->post['option_video'])) {
			$this->data['option_video'] = $this->request->post['option_video'];
		} elseif (isset($templates_info)) {
			$this->data['option_video'] = $templates_info['option_video'];
		} else {
			$this->data['option_video'] = 0;
		}

		if (isset($this->request->post['help_image'])) {
			$this->data['help_image'] = $this->request->post['help_image'];
		} elseif (isset($templates_info)) {
			$this->data['help_image'] = $templates_info['help_image'];
		} else {
			$this->data['help_image'] = '';
		}

		if (isset($this->request->post['help_image_1'])) {
			$this->data['help_image_1'] = $this->request->post['help_image_1'];
		} elseif (isset($templates_info)) {
			$this->data['help_image_1'] = $templates_info['help_image_1'];
		} else {
			$this->data['help_image_1'] = '';
		}

		if (isset($this->request->post['help_image_2'])) {
			$this->data['help_image_2'] = $this->request->post['help_image_2'];
		} elseif (isset($templates_info)) {
			$this->data['help_image_2'] = $templates_info['help_image_2'];
		} else {
			$this->data['help_image_2'] = '';
		}

		if (isset($this->request->post['module_download'])) {
			$this->data['module_download'] = $this->request->post['module_download'];
		} elseif (isset($templates_info)) {
			$this->data['module_download'] = $templates_info['module_download'];
		} else {
			$this->data['module_download'] = '';
		}

		if (isset($this->request->post['module_video'])) {
			$this->data['module_video'] = $this->request->post['module_video'];
		} elseif (isset($templates_info)) {
			$this->data['module_video'] = $templates_info['module_video'];
		} else {
			$this->data['module_video'] = '';
		}


		if (isset($this->request->post['sort_order'])) {
			$this->data['sort_order'] = $this->request->post['sort_order'];
		} elseif (isset($templates_info)) {
			$this->data['sort_order'] = $templates_info['sort_order'];
		} else {
			$this->data['sort_order'] = 0;
		}

		if (isset($this->request->post['status'])) {
			$this->data['status'] = $this->request->post['status'];
		} else if (isset($templates_info)) {
			$this->data['status'] = $templates_info['status'];
		} else {
			$this->data['status'] = 1;
		}

		//tab data
		if (isset($this->request->post['templates_description'])) {
			$this->data['templates_description'] = $this->request->post['templates_description'];
		} elseif (isset($templates_info)) {
			$this->data['templates_description'] = $this->model_catalog_templates->getTemplatesDescriptions($this->request->get['templates_id']);
		} else {
			$this->data['templates_description'] = array();
		}

		$this->load->model('catalog/module');
		$modules = $this->model_catalog_module->getModuleForPage();
		$this->data['modules'] = $modules;


		$this->template = 'catalog/templates_form.tpl';
		$this->children = array(
		                        'common/header',
		                        'common/footer',
		                        );

		$this->response->setOutput($this->render());
	}

	private function validateForm() {

		if (!$this->user->hasPermission('modify', 'catalog/templates')) {
			$this->error['warning'] = $this->data['error_permission'];
		}

		//chi validate ngon ngu mac dinh (khi lay du lieu kiem tra neu title khac rong moi hien thi)
		if((strlen(utf8_decode($this->request->post['templates_description'][$this->config->get('config_language_id')]['name'])) < 1) || (strlen(utf8_decode($this->request->post['templates_description'][$this->config->get('config_language_id')]['name'])) > 255))
			$this->error['name'][$this->config->get('config_language_id')] = $this->data['error_name'];

		foreach ($this->request->post['templates_description'] as $language_id => $value) {
			/*{VALIDATE_PDF}*/
		}

		//validate option
		if(isset($this->request->post['option_image']) && $this->request->post['option_image']==1){
			if(empty($this->request->post['help_image']))
				$this->error['help_image'] = $this->data['error_help_image'];
		}

		if(isset($this->request->post['option_images']) && $this->request->post['option_images']==1){
			if(empty($this->request->post['help_image_1']))
				$this->error['help_image_1'] = $this->data['error_help_image_1'];
		}

		if(isset($this->request->post['option_download']) && $this->request->post['option_download']==1){
			if(empty($this->request->post['module_download']))
				$this->error['module_download'] = $this->data['error_module_download'];
		}

		if(isset($this->request->post['option_video']) && $this->request->post['option_video']==1){
			if(empty($this->request->post['module_video']))
				$this->error['module_video'] = $this->data['error_module_video'];
		}

		if(isset($this->request->post['isftp']) && $this->request->post['isftp']>0){
			if(empty($this->request->post['file_mp4_ftp'])){
				$this->error['file_mp4_ftp'] = $this->data['error_file_mp4_ftp'];
			}
		}else{
			if ($this->request->files['video_mp4']['name']) {

				if (substr(strrchr($this->request->files['video_mp4']['name'], '.'), 1) != 'tpl') {
					$this->error['video_mp4'] = $this->data['error_no_support'];
				}

				if($this->request->files['video_mp4']['size']>1000000)
				{
					$this->error['video_mp4'] = $this->data['error_big_file'];
				}
			}else if(empty($this->request->post['video_mp4_old'])){
				$this->error['video_mp4'] = 'Vui lòng chọn file!';
			}

		}

		/*{VALIDATE_ERROR_IMAGE}*/

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
		if (!$this->user->hasPermission('modify', 'catalog/templates')) {
			$this->error['warning'] = $this->data['error_permission'];
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	private function validateCopy() {
		if (!$this->user->hasPermission('modify', 'catalog/templates')) {
			$this->error['warning'] = $this->data['error_permission'];
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	public function autocomplete() {
		$json = array();

		if (isset($this->request->post['filter_name'])) {
			$this->load->model('catalog/templates');

			$data = array(
			              'filter_name' => $this->request->post['filter_name'],
			              'start'       => 0,
			              'limit'       => 20
			              );

			$results = $this->model_catalog_templates->getTemplatess($data);

			foreach ($results as $result) {
				$json[] = array(
				                'templates_id' => $result['templates_id'],
				                'name'       => html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'),
				                'model'      => $result['model'],
				                'price'      => $result['price']
				                );
			}
		}

		$this->load->library('json');

		$this->response->setOutput(Json::encode($json));
	}
}
?>
<?php
class ControllerCatalogProject extends Controller {
	private $error = array();

	public function __construct($registry) {
		$this->registry = $registry;

		$this->load->model('catalog/lang');

		$langs = $this->model_catalog_lang->getLangByModule('project',2);
		foreach($langs as $lang){
			$this->data[$lang['key']] = html_entity_decode($lang['name']);
		}

		if(isset($this->request->get['cate']) && $this->request->get['cate']>0){
			$this->load->model('catalog/project');
			$this->data['heading_title'] = $this->data['heading_title'] . ' >> ' . $this->model_catalog_project->getTitle($this->request->get['cate']);
		}
        
        /*{$CHANGE_TITLE}*/
	}

	public function index() {
		$this->document->setTitle($this->data['heading_title']);
		
		if(isset($_SESSION['temp_pro'])){
			if($_SESSION['temp_pro']<=1){
				$_SESSION['temp_pro'] = $_SESSION['temp_pro'];
			}else{
				$_SESSION['temp_pro'] = 0;
			}
		}else{
			$_SESSION['temp_pro'] = 0;
		}
		
		$this->load->model('catalog/project');

		$this->getList();
	}

	public function insert() {

		$this->document->setTitle($this->data['heading_title']);

		$this->load->model('catalog/project');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$data = $this->request->post;

			/*{INSERT_CONTROLLER}*/

			$this->model_catalog_project->addProject($data);

			$this->session->data['success'] = $this->data['text_success'];

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . $this->request->get['filter_name'];
			}

						if (isset($this->request->get['filter_ishome'])) {
				$url .= '&filter_ishome=' . $this->request->get['filter_ishome'];
			}
            
            			if (isset($this->request->get['cate'])) {
				$url .= '&cate=' . (int)$this->request->get['cate'];
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

			$this->redirect($this->url->link('catalog/project', 'token=' . $this->session->data['token'] . $url, '', 'SSL'));
			
			exit;
		}

		$this->getForm();
	}

	public function update() {

		$this->document->setTitle($this->data['heading_title']);

		$this->load->model('catalog/project');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$data = $this->request->post;

			/*{UPDATE_CONTROLLER}*/

			$this->model_catalog_project->editProject($this->request->get['project_id'], $data);

			$this->session->data['success'] = $this->data['text_success_update'];

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . $this->request->get['filter_name'];
			}

						if (isset($this->request->get['filter_ishome'])) {
				$url .= '&filter_ishome=' . $this->request->get['filter_ishome'];
			}
            
            			if (isset($this->request->get['cate'])) {
				$url .= '&cate=' . (int)$this->request->get['cate'];
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

			$this->redirect($this->url->link('catalog/project', 'token=' . $this->session->data['token'] . $url, '', 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {

		$this->document->setTitle($this->data['heading_title']);

		$this->load->model('catalog/project');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $project_id) {

				/*{DELETE_CONTROLLER}*/

				$this->model_catalog_project->deleteProject($project_id);
			}

			$this->session->data['success'] = $this->data['text_success_delete'];

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . $this->request->get['filter_name'];
			}

						if (isset($this->request->get['filter_ishome'])) {
				$url .= '&filter_ishome=' . $this->request->get['filter_ishome'];
			}
            
            			if (isset($this->request->get['cate'])) {
				$url .= '&cate=' . (int)$this->request->get['cate'];
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

			$this->redirect($this->url->link('catalog/project', 'token=' . $this->session->data['token'] . $url, '', 'SSL'));
		}

		$this->getList();
	}

	public function copy() {

		$this->document->setTitle($this->data['heading_title']);

		$this->load->model('catalog/project');

		if (isset($this->request->post['selected']) && $this->validateCopy()) {
			foreach ($this->request->post['selected'] as $project_id) {
				$this->model_catalog_project->copyProject($project_id);
			}

			$this->session->data['success'] = $this->data['text_success'];

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . $this->request->get['filter_name'];
			}

						if (isset($this->request->get['filter_ishome'])) {
				$url .= '&filter_ishome=' . $this->request->get['filter_ishome'];
			}
            
            			if (isset($this->request->get['cate'])) {
				$url .= '&cate=' . (int)$this->request->get['cate'];
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

			$this->redirect($this->url->link('catalog/project', 'token=' . $this->session->data['token'] . $url, '', 'SSL'));
		}

		$this->getList();
	}

	private function getList() {
		
		$cate = isset($this->request->get['cate'])?(int)$this->request->get['cate']:0;
		$this->data['cate'] = $cate;

		//================================Filter=================================================
		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = null;
		}

				if (isset($this->request->get['filter_ishome'])) {
			$filter_ishome = $this->request->get['filter_ishome'];
		} else {
			$filter_ishome = null;
		}
        
        		if (isset($this->request->get['cate'])) {
			$cate = (int)$this->request->get['cate'];
		} else {
			$cate = 0;
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

					if (isset($this->request->get['filter_ishome'])) {
				$url .= '&filter_ishome=' . $this->request->get['filter_ishome'];
			}
            
            			if (isset($this->request->get['cate'])) {
				$url .= '&cate=' . (int)$this->request->get['cate'];
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
		                                     'href'      => $this->url->link('catalog/project', 'token=' . $this->session->data['token'] . $url, '', 'SSL'),
		                                     'separator' => ' :: '
		                                     );

		$url_filter = '';
		if (isset($this->request->get['filter_category'])) {
			$url_filter .= '&filter_category=' . $this->request->get['filter_category'];
		}

		$this->data['insert'] = $this->url->link('catalog/project/insert', 'token=' . $this->session->data['token'] . $url, '', 'SSL');
		$this->data['copy'] = $this->url->link('catalog/project/copy', 'token=' . $this->session->data['token'] . $url, '', 'SSL');
		$this->data['delete'] = $this->url->link('catalog/project/delete', 'token=' . $this->session->data['token'] . $url, '', 'SSL');

		$this->data['filter'] = $this->url->link('catalog/project', 'token=' . $this->session->data['token'] . $url_filter, '', 'SSL');
		$this->data['back'] = $this->url->link('catalog/project', 'token=' . $this->session->data['token'], '', 'SSL');
		$this->data['projects'] = array();

		$data = array(
		              'filter_name'	  => $filter_name,
		              'filter_ishome'   => $filter_ishome,

'cate'   => $cate,

/*{FILTER_PARAM}*/
		              'filter_status'   => $filter_status,
		              'sort'            => $sort,
		              'order'           => $order,
		              'start'           => ($page - 1) * $this->config->get('config_admin_limit'),
		              'limit'           => $this->config->get('config_admin_limit')
		              );
		$this->load->model('tool/image');
		$project_total = $this->model_catalog_project->getTotalProjects($data);

		$results = $this->model_catalog_project->getProjects($data);

		/*{INCLUDE_CATEGORY}*/

		foreach ($results as $result) {
			$action = array();
						if(1==2  || $cate==0){
				$action[] = array(
                	'cls'  =>'btn_list',
					'text' => $this->data['text_list'],
					'href' => $this->url->link('catalog/project', 'token=' . $this->session->data['token'] . '&cate=' . $result['project_id'], '', 'SSL')
				);
			}
			$action[] = array(
			                  'cls'  =>'modify',
			                  'text' => $this->data['text_edit'],
			                  'href' => $this->url->link('catalog/project/update', 'token=' . $this->session->data['token'] . '&project_id=' . $result['project_id'] . $url, '', 'SSL')
			                  );
			            if ($result['image'] && file_exists(DIR_IMAGE . $result['image'])) {
                $image = $this->model_tool_image->resize($result['image'], 40, 40);
            } else {
                $image = $this->model_tool_image->resize('no_image.jpg', 40, 40);
            }
			
			if(isset($result['cate']) && $result['cate']){
				$check_editor = true;
			}else{
				$check_editor = false;
			}
			$this->data['projects'][] = array(
			                                                  'project_id' => $result['project_id'],
			                                                  'sort_order'       => $result['sort_order'],
			                                                  'name'       => $result['name'],
															  
															  'status_en' =>$this->model_catalog_project->getStatus('project',$result['project_id'],1,$check_editor),
															  
			                                                  'image'      => $image,
    'ishome'     => ($result['ishome'] ? '<img src="view/image/success.png" title="'.$this->data['text_enabled'].'" />' : '<img src="view/image/delete.png" title="'.$this->data['text_disabled'].'" />'),
    /*{IMAGE_LIST_ARRAY}*/
			                                                  'status_id'		=> $result['status'],
			                                                  'status'     => ($result['status'] ? '<img src="view/image/success.png" title="'.$this->data['text_enabled'].'" />' : '<img src="view/image/delete.png" title="'.$this->data['text_disabled'].'" />'),
			                                                  'selected'   => isset($this->request->post['selected']) && in_array($result['project_id'], $this->request->post['selected']),
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

					if (isset($this->request->get['filter_ishome'])) {
				$url .= '&filter_ishome=' . $this->request->get['filter_ishome'];
			}
            
            			if (isset($this->request->get['cate'])) {
				$url .= '&cate=' . (int)$this->request->get['cate'];
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

		$this->data['sort_name'] = $this->url->link('catalog/project', 'token=' . $this->session->data['token'] . '&sort=pd.name' . $url, '', 'SSL');
		$this->data['sort_status'] = $this->url->link('catalog/project', 'token=' . $this->session->data['token'] . '&sort=p.status' . $url, '', 'SSL');
		$this->data['sort_order'] = $this->url->link('catalog/project', 'token=' . $this->session->data['token'] . '&sort=p.sort_order' . $url, '', 'SSL');

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}

					if (isset($this->request->get['filter_ishome'])) {
				$url .= '&filter_ishome=' . $this->request->get['filter_ishome'];
			}
            
            			if (isset($this->request->get['cate'])) {
				$url .= '&cate=' . (int)$this->request->get['cate'];
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
		$pagination->total = $project_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->data['text_pagination'];
		$pagination->url = $this->url->link('catalog/project', 'token=' . $this->session->data['token'] . $url . '&page={page}', '', 'SSL');

		$this->data['pagination'] = $pagination->render();

		$this->data['results'] = sprintf($this->language->get('text_pagination'), ($project_total) ? (($page - 1) * $this->config->get('config_admin_limit')) + 1 : 0, ((($page - 1) * $this->config->get('config_admin_limit')) > ($project_total - $this->config->get('config_admin_limit'))) ? $project_total : ((($page - 1) * $this->config->get('config_admin_limit')) + $this->config->get('config_admin_limit')), $project_total, ceil($project_total / $this->config->get('config_admin_limit')));

		$this->data['filter_name'] = $filter_name;

		$this->data['filter_ishome'] = $filter_ishome;

$this->data['cate'] = $cate;

/*{FILTER_DATA}*/

		$this->data['filter_status'] = $filter_status;

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'catalog/project_list.tpl';
		$this->children = array(
		                        'common/header',
		                        'common/footer',
		                        );

		$this->response->setOutput($this->render());
	}

	private function getForm() {
				$cate = isset($this->request->get['cate'])?(int)$this->request->get['cate']:0;
		$this->data['cate'] = $cate;
		
		//if(!$cate){
			$this->data['tab_image'] = $this->data['tab_image_banner'];
			$this->data['help_column_images'] = $this->data['help_column_images_banner'];
		//}
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

		        if (isset($this->error['image'])) {
            $this->data['error_image'] = $this->error['image'];
        } else {
            $this->data['error_image'] = '';
        }
        
                if (isset($this->error['image1'])) {
            $this->data['error_image1'] = $this->error['image1'];
        } else {
            $this->data['error_image1'] = '';
        }
        
                if (isset($this->error['image_home'])) {
            $this->data['error_image_home'] = $this->error['image_home'];
        } else {
            $this->data['error_image_home'] = '';
        }
        
                if (isset($this->error['project_image'])) {
			$this->data['error_images'] = $this->error['project_image'];
		} else {
			$this->data['error_images'] = '';
		}
		
		if (isset($this->error['project_imagepro'])) {
			$this->data['error_images_imagepro'] = $this->error['project_imagepro'];
		} else {
			$this->data['error_images_imagepro'] = '';
		}
        
        /*{ERROR_IMAGE}*/
 		//URL

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}

					if (isset($this->request->get['filter_ishome'])) {
				$url .= '&filter_ishome=' . $this->request->get['filter_ishome'];
			}
            
            			if (isset($this->request->get['cate'])) {
				$url .= '&cate=' . (int)$this->request->get['cate'];
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
		                                     'href'      => $this->url->link('catalog/project', 'token=' . $this->session->data['token'] . $url, '', 'SSL'),
		                                     'separator' => ' :: '
		                                     );

		//====================================================Assigne Data=======================================================
		if (!isset($this->request->get['project_id'])) {
			$this->data['action'] = $this->url->link('catalog/project/insert', 'token=' . $this->session->data['token'] . $url, '', 'SSL');
		} else {
			$this->data['action'] = $this->url->link('catalog/project/update', 'token=' . $this->session->data['token'] . '&project_id=' . $this->request->get['project_id'] . $url, '', 'SSL');
		}

		$this->data['cancel'] = $this->url->link('catalog/project', 'token=' . $this->session->data['token'] . $url, '', 'SSL');

		$this->data['token'] = $this->session->data['token'];

		//cate danh sach con
		 /*if(isset($this->request->get['cate']) && $this->request->get['cate']>0){
		 	$sublist_cate = $this->model_catalog_project->getCateById($this->request->get['cate']);
		 	$this->data['sublist_cate'] = $sublist_cate;
		 }else{
		 	$this->data['sublist_cate'] = 0;
		 }*/


		if (isset($this->request->get['project_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$project_info = $this->model_catalog_project->getProject($this->request->get['project_id']);
		}

		$this->load->model('localisation/language');

		$this->data['languages'] = $this->model_localisation_language->getLanguages();
		$this->load->model('tool/image');
		        if (isset($this->request->post['image'])) {
            $this->data['image'] = $this->request->post['image'];
        } elseif (isset($project_info)) {
            $this->data['image'] = $project_info['image'];
        } else {
            $this->data['image'] = '';
        }

		if (isset($project_info) && $project_info['image'] && file_exists(DIR_IMAGE . $project_info['image'])) {
			$this->data['preview'] = $this->model_tool_image->resize($project_info['image'], 100, 100);
		} elseif(isset($this->request->post['image']) && !empty($this->request->post['image']) && file_exists(DIR_IMAGE . $this->request->post['image'])) {
			$this->data['preview'] = $this->model_tool_image->resize($this->request->post['image'], 100, 100);
		}else{
			$this->data['preview'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}
        
                if (isset($this->request->post['image1'])) {
            $this->data['image1'] = $this->request->post['image1'];
        } elseif (isset($project_info)) {
            $this->data['image1'] = $project_info['image1'];
        } else {
            $this->data['image1'] = '';
        }

		if (isset($project_info) && $project_info['image1'] && file_exists(DIR_IMAGE . $project_info['image1'])) {
			$this->data['preview1'] = $this->model_tool_image->resize($project_info['image1'], 100, 100);
		} elseif(isset($this->request->post['image1']) && !empty($this->request->post['image1']) && file_exists(DIR_IMAGE . $this->request->post['image1'])) {
			$this->data['preview1'] = $this->model_tool_image->resize($this->request->post['image1'], 100, 100);
		}else{
			$this->data['preview1'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}
        
        		if (isset($this->request->post['ishome'])) {
			$this->data['ishome'] = $this->request->post['ishome'];
		} elseif (isset($project_info)) {
			$this->data['ishome'] = $project_info['ishome'];
		} else {
			$this->data['ishome'] = '';
		}
		
		if (isset($this->request->post['image_home'])) {
			$this->data['image_home'] = $this->request->post['image_home'];
		} elseif (isset($project_info)) {
			$this->data['image_home'] = $project_info['image_home'];
		} else {
			$this->data['image_home'] = '';
		}		

		if (isset($project_info) && $project_info['image_home'] && file_exists(DIR_IMAGE . $project_info['image_home'])) {
			$this->data['preview_home'] = $this->model_tool_image->resize($project_info['image_home'], 100, 100);
		}  elseif(isset($this->request->post['image_home']) && !empty($this->request->post['image_home']) && file_exists(DIR_IMAGE . $this->request->post['image_home'])) {
			$this->data['preview_home'] = $this->model_tool_image->resize($this->request->post['image_home'], 100, 100);
		}else {
			$this->data['preview_home'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}
        
        		if (isset($this->request->post['project_image'])) {
			$project_images = $this->request->post['project_image'];
		} elseif (isset($project_info)) {
			$project_images = $this->model_catalog_project->getProjectImages($this->request->get['project_id']);
		} else {
			$project_images = array();
		}
		
		$this->data['project_images'] = array();
		
		foreach ($project_images as $project_image) {
			if ($project_image['image'] && file_exists(DIR_IMAGE . $project_image['image'])) {
				$image = $project_image['image'];
			} else {
				$image = 'no_image.jpg';
			}
			
			if ($project_image['image1'] && file_exists(DIR_IMAGE . $project_image['image1'])) {
				$image1 = $project_image['image1'];
			} else {
				$image1 = 'no_image.jpg';
			}
			
			$this->data['project_images'][] = array(
				'image_1'   => $image,
				'image_2'   => $image1,
				'preview_1' => $this->model_tool_image->resize($image, 100, 100),
				'preview_2' => $this->model_tool_image->resize($image1, 100, 100),
                'image_name' => $project_image['image_name'],
			    'image_name_en' => $project_image['image_name_en'],
				'image_sort_order' => $project_image['image_sort_order']
			);
		}
		
		//
		if (isset($this->request->post['project_imagepro'])) {
			$project_imagepros = $this->request->post['project_imagepro'];
		} elseif (isset($project_info)) {
			$project_imagepros = $this->model_catalog_project->getProjectImagepros($this->request->get['project_id']);
		} else {
			$project_imagepros = array();
		}
		
		$this->data['project_imagepros'] = array();
		
		foreach ($project_imagepros as $project_imagepro) {
			if ($project_imagepro['image'] && file_exists(DIR_IMAGE . $project_imagepro['image'])) {
				$image = $project_imagepro['image'];
			} else {
				$image = 'no_image.jpg';
			}
			
			if ($project_imagepro['image1'] && file_exists(DIR_IMAGE . $project_imagepro['image1'])) {
				$image1 = $project_imagepro['image1'];
			} else {
				$image1 = 'no_image.jpg';
			}
			
			$this->data['project_imagepros'][] = array(
				'image_1'   => $image,
				'image_2'   => $image1,
				'preview_1' => $this->model_tool_image->resize($image, 100, 100),
				'preview_2' => $this->model_tool_image->resize($image1, 100, 100),
                'image_name' => $project_imagepro['image_name'],
			    'image_name_en' => $project_imagepro['image_name_en'],
				'image_sort_order' => $project_imagepro['image_sort_order']
			);
		}

		$this->data['no_image'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
        
        
        $this->load->model('tool/image');
        if (isset($this->request->post['image_og'])) {
            $this->data['image_og'] = $this->request->post['image_og'];
        } elseif (isset($project_info)) {
            $this->data['image_og'] = $project_info['image_og'];
        } else {
            $this->data['image_og'] = '';
        }

				if (isset($project_info) && $project_info['image_og'] && file_exists(DIR_IMAGE . $project_info['image_og'])) {
					$this->data['preview_og'] = $this->model_tool_image->resize($project_info['image_og'], 100, 100);
				} elseif(isset($this->request->post['image_og']) && !empty($this->request->post['image_og']) && file_exists(DIR_IMAGE . $this->request->post['image_og'])) {
					$this->data['preview_og'] = $this->model_tool_image->resize($this->request->post['image_og'], 100, 100);
				}else{
					$this->data['preview_og'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
				}

		        /*if (isset($this->request->post['keyword'])) {
					$this->data['keyword'] = $this->request->post['keyword'];
				} elseif (isset($project_info)) {
					$this->data['keyword'] = $project_info['keyword'];
				} else {
					$this->data['keyword'] = '';
				}*/
                
        if (isset($this->request->post['project_keyword'])) {
			$this->data['project_keyword'] = $this->request->post['project_keyword'];
		} elseif (isset($project_info)) {
			$this->data['project_keyword'] = $this->model_catalog_project->getProjectKeyword($this->request->get['project_id']);
		} else {
			$this->data['project_keyword'] = array();
		}

        /*{IMAGE_FORM}*/

		if (isset($this->request->post['sort_order'])) {
			$this->data['sort_order'] = $this->request->post['sort_order'];
		} elseif (isset($project_info)) {
			$this->data['sort_order'] = $project_info['sort_order'];
		} else {
			$this->data['sort_order'] = 0;
		}

		if (isset($this->request->post['status'])) {
			$this->data['status'] = $this->request->post['status'];
		} else if (isset($project_info)) {
			$this->data['status'] = $project_info['status'];
		} else {
			$this->data['status'] = 1;
		}

		//tab data
		if (isset($this->request->post['project_description'])) {
			$this->data['project_description'] = $this->request->post['project_description'];
		} elseif (isset($project_info)) {
			$this->data['project_description'] = $this->model_catalog_project->getProjectDescriptions($this->request->get['project_id']);
		} else {
			$this->data['project_description'] = array();
		}


		$this->template = 'catalog/project_form.tpl';
		$this->children = array(
		                        'common/header',
		                        'common/footer',
		                        );

		$this->response->setOutput($this->render());
	}

	private function validateForm() {

		if (!$this->user->hasPermission('modify', 'catalog/project')) {
			$this->error['warning'] = $this->data['error_permission'];
		}

		//chi validate ngon ngu mac dinh (khi lay du lieu kiem tra neu title khac rong moi hien thi)
		if((strlen(utf8_decode($this->request->post['project_description'][$this->config->get('config_language_id')]['name'])) < 1) || (strlen(utf8_decode($this->request->post['project_description'][$this->config->get('config_language_id')]['name'])) > 255))
			$this->error['name'][$this->config->get('config_language_id')] = $this->data['error_name'];

		foreach ($this->request->post['project_description'] as $language_id => $value) {
			/*{VALIDATE_PDF}*/
		}
		$cate = isset($this->request->get['cate'])?(int)$this->request->get['cate']:0;
		
		if($cate){
		if(empty($this->request->post['image']))
			$this->error['image'] = $this->data['error_image'];
			
		}
		
		//if(!$cate){
			if(!isset($this->request->post['project_image']))
			$this->error['project_image'] = $this->data['error_list_image'];
		//}
		
		/*
		if(!isset($this->request->post['project_imagepro']))
		$this->error['project_imagepro'] = $this->data['error_list_image'];
		
		if(empty($this->request->post['image1']))
            $this->error['image1'] = $this->data['error_image1'];
            
	if(isset($this->request->post['ishome']) && $this->request->post['ishome']==1)
if(empty($this->request->post['image_home']))
			$this->error['image_home'] = $this->data['error_image_home'];
			
		
		*/
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
		if (!$this->user->hasPermission('modify', 'catalog/project')) {
			$this->error['warning'] = $this->data['error_permission'];
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	private function validateCopy() {
		if (!$this->user->hasPermission('modify', 'catalog/project')) {
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

		/*if (isset($this->request->post['filter_name'])) {
			$this->load->model('catalog/project');

			$data = array(
			              'filter_name' => $this->request->post['filter_name'],
			              'start'       => 0,
			              'limit'       => 20
			              );

			$results = $this->model_catalog_project->getProjects($data);

			foreach ($results as $result) {
				$json[] = array(
				                'project_id' => $result['project_id'],
				                'name'       => html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'),
				                'model'      => $result['model'],
				                'price'      => $result['price']
				                );
			}
		}*/
		
		if (isset($this->request->get['filter_name'])) {
			$this->load->model('catalog/project');

			$data = array(
			              'filter_name' => $this->request->get['filter_name'],
			              'start'       => 0,
			              'limit'       => 20
			              );

			$results = $this->model_catalog_project->getProjectsChild($data);

			foreach ($results as $result) {
				$cate_name = $result['cate']?$this->model_catalog_project->getTitle($result['cate']) . ' >> ':'';
				$json[] = array(
				                'project_id' => $result['project_id'],
				                'name'       => $cate_name . html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'),
				                //'model'      => $result['model'],
				                //'price'      => $result['price']
				                );
			}
		}

		$this->load->library('json');

		$this->response->setOutput(Json::encode($json));
	}
}
?>
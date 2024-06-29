<?php
class ControllerCatalogAmpcd extends Controller {
	private $error = array();

	public function __construct($registry) {
		$this->registry = $registry;

		$this->load->model('catalog/lang');

		$langs = $this->model_catalog_lang->getLangByModule('ampcd',2);
		foreach($langs as $lang){
			$this->data[$lang['key']] = html_entity_decode($lang['name']);
		}

		/*{$CHANGE_TITLE}*/
	}

	public function index() {
		$this->document->setTitle($this->data['heading_title']);

		$this->load->model('catalog/ampcd');

		$this->getList();
	}

	public function insert() {

		$this->document->setTitle($this->data['heading_title']);

		$this->load->model('catalog/ampcd');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$data = $this->request->post;

			/*{INSERT_CONTROLLER}*/

			$this->model_catalog_ampcd->addAmpcd($data);

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

			$this->redirect($this->url->link('catalog/ampcd', 'token=' . $this->session->data['token'] . $url, '', 'SSL'));
			
			exit;
		}

		$this->getForm();
	}

	public function update() {

		$this->document->setTitle($this->data['heading_title']);

		$this->load->model('catalog/ampcd');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$data = $this->request->post;

			/*{UPDATE_CONTROLLER}*/

			$this->model_catalog_ampcd->editAmpcd($this->request->get['ampcd_id'], $data);

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

			$this->redirect($this->url->link('catalog/ampcd', 'token=' . $this->session->data['token'] . $url, '', 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {

		$this->document->setTitle($this->data['heading_title']);

		$this->load->model('catalog/ampcd');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $ampcd_id) {

				/*{DELETE_CONTROLLER}*/

				$this->model_catalog_ampcd->deleteAmpcd($ampcd_id);
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

			$this->redirect($this->url->link('catalog/ampcd', 'token=' . $this->session->data['token'] . $url, '', 'SSL'));
		}

		$this->getList();
	}

	public function copy() {

		$this->document->setTitle($this->data['heading_title']);

		$this->load->model('catalog/ampcd');

		if (isset($this->request->post['selected']) && $this->validateCopy()) {
			foreach ($this->request->post['selected'] as $ampcd_id) {
				$this->model_catalog_ampcd->copyAmpcd($ampcd_id);
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

			$this->redirect($this->url->link('catalog/ampcd', 'token=' . $this->session->data['token'] . $url, '', 'SSL'));
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
		                                     'href'      => $this->url->link('catalog/ampcd', 'token=' . $this->session->data['token'] . $url, '', 'SSL'),
		                                     'separator' => ' :: '
		                                     );

		$url_filter = '';
		if (isset($this->request->get['filter_category'])) {
			$url_filter .= '&filter_category=' . $this->request->get['filter_category'];
		}

		$this->data['insert'] = $this->url->link('catalog/ampcd/insert', 'token=' . $this->session->data['token'] . $url, '', 'SSL');
		$this->data['copy'] = $this->url->link('catalog/ampcd/copy', 'token=' . $this->session->data['token'] . $url, '', 'SSL');
		$this->data['delete'] = $this->url->link('catalog/ampcd/delete', 'token=' . $this->session->data['token'] . $url, '', 'SSL');

		$this->data['filter'] = $this->url->link('catalog/ampcd', 'token=' . $this->session->data['token'] . $url_filter, '', 'SSL');
		/*{BACK}*/
		$this->data['ampcds'] = array();

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
		$ampcd_total = $this->model_catalog_ampcd->getTotalAmpcds($data);

		$results = $this->model_catalog_ampcd->getAmpcds($data);

		/*{INCLUDE_CATEGORY}*/

		foreach ($results as $result) {
			$action = array();
			/*{SUBLIST}*/
			$action[] = array(
			                  'cls'  =>'modify',
			                  'text' => $this->data['text_edit'],
			                  'href' => $this->url->link('catalog/ampcd/update', 'token=' . $this->session->data['token'] . '&ampcd_id=' . $result['ampcd_id'] . $url, '', 'SSL')
			                  );
			            if ($result['image'] && file_exists(DIR_IMAGE . $result['image'])) {
                $image = $this->model_tool_image->resize($result['image'], 40, 40);
            } else {
                $image = $this->model_tool_image->resize('no_image.jpg', 40, 40);
            }
			$this->data['ampcds'][] = array(
			                                                  'ampcd_id' => $result['ampcd_id'],
			                                                  'sort_order'       => $result['sort_order'],
			                                                  'name'       => $result['name'],
															  'name1'       => $result['name1'],
			                                                  'image'      => $image,
/*{IMAGE_LIST_ARRAY}*/
			                                                  'status_id'		=> $result['status'],
			                                                  'status'     => ($result['status'] ? '<img src="view/image/success.png" title="'.$this->data['text_enabled'].'" />' : '<img src="view/image/delete.png" title="'.$this->data['text_disabled'].'" />'),
			                                                  'selected'   => isset($this->request->post['selected']) && in_array($result['ampcd_id'], $this->request->post['selected']),
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

		$this->data['sort_name'] = $this->url->link('catalog/ampcd', 'token=' . $this->session->data['token'] . '&sort=pd.name' . $url, '', 'SSL');
		$this->data['sort_status'] = $this->url->link('catalog/ampcd', 'token=' . $this->session->data['token'] . '&sort=p.status' . $url, '', 'SSL');
		$this->data['sort_order'] = $this->url->link('catalog/ampcd', 'token=' . $this->session->data['token'] . '&sort=p.sort_order' . $url, '', 'SSL');

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
		$pagination->total = $ampcd_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->data['text_pagination'];
		$pagination->url = $this->url->link('catalog/ampcd', 'token=' . $this->session->data['token'] . $url . '&page={page}', '', 'SSL');

		$this->data['pagination'] = $pagination->render();

		$this->data['results'] = sprintf($this->language->get('text_pagination'), ($ampcd_total) ? (($page - 1) * $this->config->get('config_admin_limit')) + 1 : 0, ((($page - 1) * $this->config->get('config_admin_limit')) > ($ampcd_total - $this->config->get('config_admin_limit'))) ? $ampcd_total : ((($page - 1) * $this->config->get('config_admin_limit')) + $this->config->get('config_admin_limit')), $ampcd_total, ceil($ampcd_total / $this->config->get('config_admin_limit')));

		$this->data['filter_name'] = $filter_name;

		/*{FILTER_DATA}*/

		$this->data['filter_status'] = $filter_status;

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'catalog/ampcd_list.tpl';
		$this->children = array(
		                        'common/header',
		                        'common/footer',
		                        );

		$this->response->setOutput($this->render());
	}

	private function getForm() {
		$this->data['ampcd_id'] = isset($this->request->get['ampcd_id'])?(int)($this->request->get['ampcd_id']):0;
		
		if($this->data['ampcd_id']!=1){
			$this->data['entry_image'] = 'Hình banner AMP';
			$this->data['help_entry_image'] = 'Kích thước hình 1920 x 900 px';
		}
		//$this->data['entry_desc_short'] = 'Mô tả SEO';
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

		        if (isset($this->error['image'])) {
            $this->data['error_image'] = $this->error['image'];
        } else {
            $this->data['error_image'] = '';
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
		                                     'href'      => $this->url->link('catalog/ampcd', 'token=' . $this->session->data['token'] . $url, '', 'SSL'),
		                                     'separator' => ' :: '
		                                     );

		//====================================================Assigne Data=======================================================
		if (!isset($this->request->get['ampcd_id'])) {
			$this->data['action'] = $this->url->link('catalog/ampcd/insert', 'token=' . $this->session->data['token'] . $url, '', 'SSL');
		} else {
			$this->data['action'] = $this->url->link('catalog/ampcd/update', 'token=' . $this->session->data['token'] . '&ampcd_id=' . $this->request->get['ampcd_id'] . $url, '', 'SSL');
		}

		$this->data['cancel'] = $this->url->link('catalog/ampcd', 'token=' . $this->session->data['token'] . $url, '', 'SSL');

		$this->data['token'] = $this->session->data['token'];

		//cate danh sach con
		 if(isset($this->request->get['cate']) && $this->request->get['cate']>0){
		 	$sublist_cate = $this->model_catalog_ampcd->getCateById($this->request->get['cate']);
		 	$this->data['sublist_cate'] = $sublist_cate;
		 }else{
		 	$this->data['sublist_cate'] = 0;
		 }


		if (isset($this->request->get['ampcd_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$ampcd_info = $this->model_catalog_ampcd->getAmpcd($this->request->get['ampcd_id']);
		}

		$this->load->model('localisation/language');

		$this->data['languages'] = $this->model_localisation_language->getLanguages();
		$this->load->model('tool/image');
		        if (isset($this->request->post['image'])) {
            $this->data['image'] = $this->request->post['image'];
        } elseif (isset($ampcd_info)) {
            $this->data['image'] = $ampcd_info['image'];
        } else {
            $this->data['image'] = '';
        }

		if (isset($ampcd_info) && $ampcd_info['image'] && file_exists(DIR_IMAGE . $ampcd_info['image'])) {
			$this->data['preview'] = $this->model_tool_image->resize($ampcd_info['image'], 100, 100);
		} elseif(isset($this->request->post['image']) && !empty($this->request->post['image']) && file_exists(DIR_IMAGE . $this->request->post['image'])) {
			$this->data['preview'] = $this->model_tool_image->resize($this->request->post['image'], 100, 100);
		}else{
			$this->data['preview'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}
        
                if (isset($this->request->post['image1'])) {
            $this->data['image1'] = $this->request->post['image1'];
        } elseif (isset($ampcd_info)) {
            $this->data['image1'] = $ampcd_info['image1'];
        } else {
            $this->data['image1'] = '';
        }

		if (isset($ampcd_info) && $ampcd_info['image1'] && file_exists(DIR_IMAGE . $ampcd_info['image1'])) {
			$this->data['preview1'] = $this->model_tool_image->resize($ampcd_info['image1'], 100, 100);
		} elseif(isset($this->request->post['image1']) && !empty($this->request->post['image1']) && file_exists(DIR_IMAGE . $this->request->post['image1'])) {
			$this->data['preview1'] = $this->model_tool_image->resize($this->request->post['image1'], 100, 100);
		}else{
			$this->data['preview1'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}
        
        
        $this->load->model('tool/image');
        if (isset($this->request->post['image_og'])) {
            $this->data['image_og'] = $this->request->post['image_og'];
        } elseif (isset($ampcd_info)) {
            $this->data['image_og'] = $ampcd_info['image_og'];
        } else {
            $this->data['image_og'] = '';
        }

				if (isset($ampcd_info) && $ampcd_info['image_og'] && file_exists(DIR_IMAGE . $ampcd_info['image_og'])) {
					$this->data['preview_og'] = $this->model_tool_image->resize($ampcd_info['image_og'], 100, 100);
				} elseif(isset($this->request->post['image_og']) && !empty($this->request->post['image_og']) && file_exists(DIR_IMAGE . $this->request->post['image_og'])) {
					$this->data['preview_og'] = $this->model_tool_image->resize($this->request->post['image_og'], 100, 100);
				}else{
					$this->data['preview_og'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
				}

		        if (isset($this->request->post['keyword'])) {
					$this->data['keyword'] = $this->request->post['keyword'];
				} elseif (isset($ampcd_info)) {
					$this->data['keyword'] = $ampcd_info['keyword'];
				} else {
					$this->data['keyword'] = '';
				}

        /*{IMAGE_FORM}*/

		if (isset($this->request->post['sort_order'])) {
			$this->data['sort_order'] = $this->request->post['sort_order'];
		} elseif (isset($ampcd_info)) {
			$this->data['sort_order'] = $ampcd_info['sort_order'];
		} else {
			$this->data['sort_order'] = 0;
		}

		if (isset($this->request->post['status'])) {
			$this->data['status'] = $this->request->post['status'];
		} else if (isset($ampcd_info)) {
			$this->data['status'] = $ampcd_info['status'];
		} else {
			$this->data['status'] = 1;
		}
		
		$this->load->model('catalog/category');
		$categories = $this->model_catalog_category->getCategories(0);
		$this->data['categories'] = $categories;
		//print_r($categories);
		
		if (isset($this->request->post['pagelist'])) {
            $this->data['pagelist'] = $this->request->post['pagelist'];
        } elseif (isset($ampcd_info)) {
            $this->data['pagelist'] = unserialize(!empty($ampcd_info['pagelist']) ? $ampcd_info['pagelist'] : '');
        } else {
            $this->data['pagelist'] = array();
        }
        if (!is_array($this->data['pagelist']))
            $this->data['pagelist'] = array();
		
		
		/*//codong
		$categories_codong = $this->model_catalog_category->getCategories(164);
		$this->data['categories_codong'] = $categories_codong;
		//print_r($categories);
		
		if (isset($this->request->post['pagelistcodong'])) {
            $this->data['pagelistcodong'] = $this->request->post['pagelistcodong'];
        } elseif (isset($ampcd_info)) {
            $this->data['pagelistcodong'] = unserialize(!empty($ampcd_info['pagelistcodong']) ? $ampcd_info['pagelistcodong'] : '');
        } else {
            $this->data['pagelistcodong'] = array();
        }
        if (!is_array($this->data['pagelistcodong']))
            $this->data['pagelistcodong'] = array();
		*/
		
		//project
		$this->load->model('catalog/project');
		$projects = $this->model_catalog_project->getProjects(array('sort' => 'p.sort_order', 'order' => 'ASC'));
		$this->data['projects'] = $projects;
		
		if (isset($this->request->post['pagelistproject'])) {
            $this->data['pagelistproject'] = $this->request->post['pagelistproject'];
        } elseif (isset($ampcd_info)) {
            $this->data['pagelistproject'] = unserialize(!empty($ampcd_info['pagelistproject']) ? $ampcd_info['pagelistproject'] : '');
        } else {
            $this->data['pagelistproject'] = array();
        }
        if (!is_array($this->data['pagelistproject']))
            $this->data['pagelistproject'] = array();
		
		//solution
		$this->load->model('catalog/solution');
		$solutions = $this->model_catalog_solution->getSolutions(array('sort' => 'p.sort_order', 'order' => 'ASC', 'cate'=>0));
		$this->data['solutions'] = $solutions;
		
		if (isset($this->request->post['pagelistsolution'])) {
            $this->data['pagelistsolution'] = $this->request->post['pagelistsolution'];
        } elseif (isset($ampcd_info)) {
            $this->data['pagelistsolution'] = unserialize(!empty($ampcd_info['pagelistsolution']) ? $ampcd_info['pagelistsolution'] : '');
        } else {
            $this->data['pagelistsolution'] = array();
        }
        if (!is_array($this->data['pagelistsolution']))
            $this->data['pagelistsolution'] = array();
		
		
		
		/*//listpartner
		$this->load->model('catalog/listpartner');
		$listpartners = $this->model_catalog_listpartner->getListpartners(array('sort' => 'p.sort_order', 'order' => 'ASC', 'cate'=>0));
		$this->data['listpartners'] = $listpartners;
		
		if (isset($this->request->post['pagelistlistpartner'])) {
            $this->data['pagelistlistpartner'] = $this->request->post['pagelistlistpartner'];
        } elseif (isset($ampcd_info)) {
            $this->data['pagelistlistpartner'] = unserialize(!empty($ampcd_info['pagelistlistpartner']) ? $ampcd_info['pagelistlistpartner'] : '');
        } else {
            $this->data['pagelistlistpartner'] = array();
        }
        if (!is_array($this->data['pagelistlistpartner']))
            $this->data['pagelistlistpartner'] = array();
		*/
		
		//service
		$this->load->model('catalog/service');
		$services = $this->model_catalog_service->getServices(array('sort' => 'p.sort_order', 'order' => 'ASC', 'cate'=>0));
		$this->data['services'] = $services;
		
		if (isset($this->request->post['pagelistservice'])) {
            $this->data['pagelistservice'] = $this->request->post['pagelistservice'];
        } elseif (isset($ampcd_info)) {
            $this->data['pagelistservice'] = unserialize(!empty($ampcd_info['pagelistservice']) ? $ampcd_info['pagelistservice'] : '');
        } else {
            $this->data['pagelistservice'] = array();
        }
        if (!is_array($this->data['pagelistservice']))
            $this->data['pagelistservice'] = array();
		
		
		//recruitment
		$this->load->model('catalog/recruitment');
		$recruitments = $this->model_catalog_recruitment->getRecruitments(array('sort' => 'p.sort_order', 'order' => 'ASC', 'cate'=>0));
		$this->data['recruitments'] = $recruitments;
		
		if (isset($this->request->post['pagelistrecruitment'])) {
            $this->data['pagelistrecruitment'] = $this->request->post['pagelistrecruitment'];
        } elseif (isset($ampcd_info)) {
            $this->data['pagelistrecruitment'] = unserialize(!empty($ampcd_info['pagelistrecruitment']) ? $ampcd_info['pagelistrecruitment'] : '');
        } else {
            $this->data['pagelistrecruitment'] = array();
        }
        if (!is_array($this->data['pagelistrecruitment']))
            $this->data['pagelistrecruitment'] = array();
		
		
		//news
		$this->load->model('catalog/news');
		$newss = $this->model_catalog_news->getNewss(array('sort' => 'p.sort_order', 'order' => 'ASC'));
		$this->data['newss'] = $newss;
		
		if (isset($this->request->post['pagelistnews'])) {
            $this->data['pagelistnews'] = $this->request->post['pagelistnews'];
        } elseif (isset($ampcd_info)) {
            $this->data['pagelistnews'] = unserialize(!empty($ampcd_info['pagelistnews']) ? $ampcd_info['pagelistnews'] : '');
        } else {
            $this->data['pagelistnews'] = array();
        }
        if (!is_array($this->data['pagelistnews']))
            $this->data['pagelistnews'] = array();
		
		/*//business
		$this->load->model('catalog/business');
		$businesss = $this->model_catalog_business->getBusinesss(array('sort' => 'p.sort_order', 'order' => 'ASC', 'cate'=>0));
		$this->data['businesss'] = $businesss;
		
		if (isset($this->request->post['pagelistbusiness'])) {
            $this->data['pagelistbusiness'] = $this->request->post['pagelistbusiness'];
        } elseif (isset($ampcd_info)) {
            $this->data['pagelistbusiness'] = unserialize(!empty($ampcd_info['pagelistbusiness']) ? $ampcd_info['pagelistbusiness'] : '');
        } else {
            $this->data['pagelistbusiness'] = array();
        }
        if (!is_array($this->data['pagelistbusiness']))
            $this->data['pagelistbusiness'] = array();
		*/
		
		/*//brand
		$this->load->model('catalog/brand');
		$brands = $this->model_catalog_brand->getBrands(array('sort' => 'p.sort_order', 'order' => 'ASC', 'cate'=>0));
		$this->data['brands'] = $brands;
		
		if (isset($this->request->post['pagelistbrand'])) {
            $this->data['pagelistbrand'] = $this->request->post['pagelistbrand'];
        } elseif (isset($ampcd_info)) {
            $this->data['pagelistbrand'] = unserialize(!empty($ampcd_info['pagelistbrand']) ? $ampcd_info['pagelistbrand'] : '');
        } else {
            $this->data['pagelistbrand'] = array();
        }
        if (!is_array($this->data['pagelistbrand']))
            $this->data['pagelistbrand'] = array();
		*/
		
		/*//showroom
		$this->load->model('catalog/showroom');
		$showrooms = $this->model_catalog_showroom->getShowrooms(array('sort' => 'p.sort_order', 'order' => 'ASC'));
		$this->data['showrooms'] = $showrooms;
		
		if (isset($this->request->post['pagelistshowroom'])) {
            $this->data['pagelistshowroom'] = $this->request->post['pagelistshowroom'];
        } elseif (isset($ampcd_info)) {
            $this->data['pagelistshowroom'] = unserialize(!empty($ampcd_info['pagelistshowroom']) ? $ampcd_info['pagelistshowroom'] : '');
        } else {
            $this->data['pagelistshowroom'] = array();
        }
        if (!is_array($this->data['pagelistshowroom']))
            $this->data['pagelistshowroom'] = array();
		*/
		
		//product
		$this->load->model('catalog/product');
		$products = $this->model_catalog_product->getProducts(array('sort' => 'p.sort_order', 'order' => 'ASC', 'cate'=>0));
		$this->data['products'] = $products;
		
		if (isset($this->request->post['pagelistproduct'])) {
            $this->data['pagelistproduct'] = $this->request->post['pagelistproduct'];
        } elseif (isset($ampcd_info)) {
            $this->data['pagelistproduct'] = unserialize(!empty($ampcd_info['pagelistproduct']) ? $ampcd_info['pagelistproduct'] : '');
        } else {
            $this->data['pagelistproduct'] = array();
        }
        if (!is_array($this->data['pagelistproduct']))
            $this->data['pagelistproduct'] = array();
		
		
		//aboutus
		$this->load->model('catalog/aboutus');
		$aboutuss = $this->model_catalog_aboutus->getAboutuss(array('sort' => 'p.sort_order', 'order' => 'ASC', 'cate'=>0));//array(array('aboutus_id'=>1,'name'=>'Đoạn 1'), array('aboutus_id'=>2,'name'=>'Đoạn 2'));//
		$this->data['aboutuss'] = $aboutuss;
		
		if (isset($this->request->post['pagelistaboutus'])) {
            $this->data['pagelistaboutus'] = $this->request->post['pagelistaboutus'];
        } elseif (isset($ampcd_info)) {
            $this->data['pagelistaboutus'] = unserialize(!empty($ampcd_info['pagelistaboutus']) ? $ampcd_info['pagelistaboutus'] : '');
        } else {
            $this->data['pagelistaboutus'] = array();
        }
        if (!is_array($this->data['pagelistaboutus']))
            $this->data['pagelistaboutus'] = array();
		
		//contact
		$this->load->model('catalog/contact');
		$contacts = array(array('contact_id'=>1,'name'=>'Thông tin liên hệ'), array('contact_id'=>2,'name'=>'Google map'), array('contact_id'=>3,'name'=>'Form'));//$this->model_catalog_contact->getServices(array('sort' => 'p.sort_order', 'order' => 'ASC'));
		$this->data['contacts'] = $contacts;
		
		if (isset($this->request->post['pagelistcontact'])) {
            $this->data['pagelistcontact'] = $this->request->post['pagelistcontact'];
        } elseif (isset($ampcd_info)) {
            $this->data['pagelistcontact'] = unserialize(!empty($ampcd_info['pagelistcontact']) ? $ampcd_info['pagelistcontact'] : '');
        } else {
            $this->data['pagelistcontact'] = array();
        }
        if (!is_array($this->data['pagelistcontact']))
            $this->data['pagelistcontact'] = array();
		
		
		//tab data
		if (isset($this->request->post['ampcd_description'])) {
			$this->data['ampcd_description'] = $this->request->post['ampcd_description'];
		} elseif (isset($ampcd_info)) {
			$this->data['ampcd_description'] = $this->model_catalog_ampcd->getAmpcdDescriptions($this->request->get['ampcd_id']);
		} else {
			$this->data['ampcd_description'] = array();
		}


		$this->template = 'catalog/ampcd_form.tpl';
		$this->children = array(
		                        'common/header',
		                        'common/footer',
		                        );

		$this->response->setOutput($this->render());
	}

	private function validateForm() {

		if (!$this->user->hasPermission('modify', 'catalog/ampcd')) {
			$this->error['warning'] = $this->data['error_permission'];
		}

		//chi validate ngon ngu mac dinh (khi lay du lieu kiem tra neu title khac rong moi hien thi)
		if((strlen(utf8_decode($this->request->post['ampcd_description'][$this->config->get('config_language_id')]['name'])) < 1) || (strlen(utf8_decode($this->request->post['ampcd_description'][$this->config->get('config_language_id')]['name'])) > 255))
			$this->error['name'][$this->config->get('config_language_id')] = $this->data['error_name'];

		foreach ($this->request->post['ampcd_description'] as $language_id => $value) {
			/*{VALIDATE_PDF}*/
		}
		$ampcd_id = isset($this->request->get['ampcd_id'])?$this->request->get['ampcd_id']:0;
		
		if($ampcd_id==6 || $ampcd_id==5){
		if(empty($this->request->post['image'])){
			$this->error['image'] = $this->data['error_image'];
		}else{
			$kichthuoc = 500;
			$extension = pathinfo($this->request->post['image'], PATHINFO_EXTENSION);
			list($width_orig, $height_orig) = getimagesize (DIR_IMAGE . $this->request->post['image']);
			
			if (!is_file(DIR_IMAGE . utf8_substr(utf8_substr(DIR_IMAGE . $this->request->post['image'], utf8_strlen(DIR_IMAGE)), 0, utf8_strrpos(utf8_substr(DIR_IMAGE . $this->request->post['image'], utf8_strlen(DIR_IMAGE)), '.')) . '-' . $kichthuoc . 'x' . ceil($height_orig*$kichthuoc/$width_orig) . '.' . $extension)) {
				
				$this->load->model('tool/image');
			
				$this->model_tool_image->resizeImage1x(utf8_substr(DIR_IMAGE . $this->request->post['image'], utf8_strlen(DIR_IMAGE)), $kichthuoc, ceil($height_orig*$kichthuoc/$width_orig));
				
			}
			$this->request->post['image_1x'] = utf8_substr(utf8_substr(DIR_IMAGE . $this->request->post['image'], utf8_strlen(DIR_IMAGE)), 0, utf8_strrpos(utf8_substr(DIR_IMAGE . $this->request->post['image'], utf8_strlen(DIR_IMAGE)), '.')) . '-' . $kichthuoc . 'x' . ceil($height_orig*$kichthuoc/$width_orig) . '.' . $extension;
			
		}
		
		}

		/*if(empty($this->request->post['image']))
			$this->error['image'] = $this->data['error_image'];
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
		if (!$this->user->hasPermission('modify', 'catalog/ampcd')) {
			$this->error['warning'] = $this->data['error_permission'];
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	private function validateCopy() {
		if (!$this->user->hasPermission('modify', 'catalog/ampcd')) {
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
			$this->load->model('catalog/ampcd');

			$data = array(
			              'filter_name' => $this->request->post['filter_name'],
			              'start'       => 0,
			              'limit'       => 20
			              );

			$results = $this->model_catalog_ampcd->getAmpcds($data);

			foreach ($results as $result) {
				$json[] = array(
				                'ampcd_id' => $result['ampcd_id'],
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
<?php
class ControllerCatalogBrochure extends Controller {
	private $error = array();

	public function __construct($registry) {
		$this->registry = $registry;

		$this->load->model('catalog/lang');

		$langs = $this->model_catalog_lang->getLangByModule('brochure',2);
		foreach($langs as $lang){
			$this->data[$lang['key']] = html_entity_decode($lang['name']);
		}
		
		if(isset($this->request->get['filter_category']) && $this->request->get['filter_category']>0){
			$this->load->model('catalog/category');
			$this->data['heading_title'] = $this->data['heading_title'] . ' >> ' . $this->model_catalog_category->getTitle($this->request->get['filter_category']);
		}

		/*{$CHANGE_TITLE}*/
	}

	public function index() {
		$this->document->setTitle($this->data['heading_title']);

		$this->load->model('catalog/brochure');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateFormList()) {
			$data = $this->request->post;
			if(isset($data['image'])){
				$this->db->query("UPDATE " . DB_PREFIX . "setting 
					SET `value` = '" . $this->db->escape($data['image']) . "'
					WHERE `key` = 'config_brochure_bg'");
				
				$this->load->model('tool/image');
				if (file_exists(DIR_IMAGE . $data['image']) && is_file(DIR_IMAGE . $data['image'])) {
					list($widthImg, $heightImg) = getimagesize(DIR_IMAGE.$data['image']);
					$this->model_tool_image->resize_mobile($data['image'], $widthImg*2/3, $heightImg*2/3);
				}
			}
			
			$this->session->data['success'] = 'Lưu thành công!';
    	}
		$this->getList();
	}

	public function insert() {

		$this->document->setTitle($this->data['heading_title']);

		$this->load->model('catalog/brochure');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$data = $this->request->post;

				
			$time = time();
			
			$this->load->model('localisation/language');		
			$languages = $this->model_localisation_language->getLanguages();
			
			foreach($languages as $lang){
				$parts = pathinfo($this->request->files['brochure_description']['name'][$lang['language_id']]['pdf']);
								
				if(!empty($parts['filename']))
					$filename = convertAlias($parts['filename']) . '_' . $lang['code'] . '_'. $time . '.' . $parts['extension'];
				else
					$filename = '';
				
				if($this->request->files['brochure_description']['error'][$lang['language_id']]['pdf']==0){
					@move_uploaded_file($this->request->files['brochure_description']['tmp_name'][$lang['language_id']]['pdf'], DIR_PDF . $filename);
					$data['brochure_description'][$lang['language_id']]['pdf'] = $filename;
				}else{
					$data['brochure_description'][$lang['language_id']]['pdf']='';	
				}								
			}
            
            /*{INSERT_CONTROLLER}*/

			$this->model_catalog_brochure->addBrochure($data);

			$this->session->data['success'] = $this->data['text_success'];

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . $this->request->get['filter_name'];
			}
			
			if (isset($this->request->get['filter_category'])) {
				$url .= '&filter_category=' . $this->request->get['filter_category'];
			}
			
			if (isset($this->request->get['filter_tieuchuan'])) {
				$url .= '&filter_tieuchuan=' . $this->request->get['filter_tieuchuan'];
			}
			
			if (isset($this->request->get['filter_ishome'])) {
				$url .= '&filter_ishome=' . $this->request->get['filter_ishome'];
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

			$this->redirect($this->url->link('catalog/brochure', 'token=' . $this->session->data['token'] . $url, '', 'SSL'));
			
			exit;
		}

		$this->getForm();
	}

	public function update() {

		$this->document->setTitle($this->data['heading_title']);

		$this->load->model('catalog/brochure');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$data = $this->request->post;

						$time = time();
			
			$this->load->model('localisation/language');		
			$languages = $this->model_localisation_language->getLanguages();
			
			foreach($languages as $lang){
				$parts = pathinfo($this->request->files['brochure_description']['name'][$lang['language_id']]['pdf']);
				
				if(!empty($parts['filename']))
					$filename = convertAlias($parts['filename']) . '_' . $lang['code'] . '_'. $time . '.' . $parts['extension'];
				else
					$filename = '';
				
				if(isset($this->request->post['brochure_description'][$lang['language_id']]['delete_pdf']) && $this->request->post['brochure_description'][$lang['language_id']]['delete_pdf']==1)
				{
					$data['brochure_description'][$lang['language_id']]['pdf'] = '';
					$old_file = $this->request->post['brochure_description'][$lang['language_id']]['old_file'];
					if(!empty($old_file) && file_exists(DIR_PDF . $old_file))
						unlink(DIR_PDF . $old_file);
				}else{
					if($this->request->files['brochure_description']['error'][$lang['language_id']]['pdf']==0){
						
						$old_file = $this->request->post['brochure_description'][$lang['language_id']]['old_file'];
						if(!empty($old_file) && file_exists(DIR_PDF . $old_file))
							unlink(DIR_PDF . $old_file);
						
						@move_uploaded_file($this->request->files['brochure_description']['tmp_name'][$lang['language_id']]['pdf'], DIR_PDF . $filename);
						$data['brochure_description'][$lang['language_id']]['pdf'] = $filename;
					}else{
						$data['brochure_description'][$lang['language_id']]['pdf']=$this->request->post['brochure_description'][$lang['language_id']]['old_file'];	
					}
				}				
			}
            
            /*{UPDATE_CONTROLLER}*/


			$this->model_catalog_brochure->editBrochure($this->request->get['brochure_id'], $data);

			$this->session->data['success'] = $this->data['text_success_update'];

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . $this->request->get['filter_name'];
			}
			
			if (isset($this->request->get['filter_category'])) {
				$url .= '&filter_category=' . $this->request->get['filter_category'];
			}
			
			if (isset($this->request->get['filter_tieuchuan'])) {
				$url .= '&filter_tieuchuan=' . $this->request->get['filter_tieuchuan'];
			}
			
			if (isset($this->request->get['filter_ishome'])) {
				$url .= '&filter_ishome=' . $this->request->get['filter_ishome'];
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

			$this->redirect($this->url->link('catalog/brochure', 'token=' . $this->session->data['token'] . $url, '', 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {

		$this->document->setTitle($this->data['heading_title']);

		$this->load->model('catalog/brochure');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $brochure_id) {

								$pdfs = $this->model_catalog_brochure->getPdf($brochure_id);
				
				foreach($pdfs as $item){
					if(!empty($item['pdf']) && file_exists(DIR_PDF . $item['pdf']))
							unlink(DIR_PDF . $item['pdf']);
				}

				/*{DELETE_CONTROLLER}*/

				$this->model_catalog_brochure->deleteBrochure($brochure_id);
			}

			$this->session->data['success'] = $this->data['text_success_delete'];

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . $this->request->get['filter_name'];
			}
			
			if (isset($this->request->get['filter_category'])) {
				$url .= '&filter_category=' . $this->request->get['filter_category'];
			}
			
			if (isset($this->request->get['filter_tieuchuan'])) {
				$url .= '&filter_tieuchuan=' . $this->request->get['filter_tieuchuan'];
			}
			
			if (isset($this->request->get['filter_ishome'])) {
				$url .= '&filter_ishome=' . $this->request->get['filter_ishome'];
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

			$this->redirect($this->url->link('catalog/brochure', 'token=' . $this->session->data['token'] . $url, '', 'SSL'));
		}

		$this->getList();
	}

	public function copy() {

		$this->document->setTitle($this->data['heading_title']);

		$this->load->model('catalog/brochure');

		if (isset($this->request->post['selected']) && $this->validateCopy()) {
			foreach ($this->request->post['selected'] as $brochure_id) {
				$this->model_catalog_brochure->copyBrochure($brochure_id);
			}

			$this->session->data['success'] = $this->data['text_success'];

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . $this->request->get['filter_name'];
			}
			
			if (isset($this->request->get['filter_category'])) {
				$url .= '&filter_category=' . $this->request->get['filter_category'];
			}
			
			if (isset($this->request->get['filter_tieuchuan'])) {
				$url .= '&filter_tieuchuan=' . $this->request->get['filter_tieuchuan'];
			}
			
			if (isset($this->request->get['filter_ishome'])) {
				$url .= '&filter_ishome=' . $this->request->get['filter_ishome'];
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

			$this->redirect($this->url->link('catalog/brochure', 'token=' . $this->session->data['token'] . $url, '', 'SSL'));
		}

		$this->getList();
	}

	private function getList() {
		if (isset($this->error['image'])) {
            $this->data['error_image'] = $this->error['image'];
        } else {
            $this->data['error_image'] = '';
        }
        
        $this->load->model('tool/image');
		if (isset($this->request->post['image'])) {
            $this->data['image'] = $this->request->post['image'];
        } else {
            $this->data['image'] = $this->config->get('config_brochure_bg');
        }

		if(isset($this->request->post['image']) && !empty($this->request->post['image']) && file_exists(DIR_IMAGE . $this->request->post['image'])) {
			$this->data['preview'] =  $this->model_tool_image->resize($this->request->post['image'], 100, 100);
		}else{
			$this->data['preview'] = $this->model_tool_image->resize($this->config->get('config_brochure_bg'), 100, 100);
		}
		
		//================================Filter=================================================
		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = null;
		}
		
		if (isset($this->request->get['filter_category'])) {
			$filter_category = $this->request->get['filter_category'];
		} else {
			$filter_category = null;
		}
		
		if (isset($this->request->get['filter_tieuchuan'])) {
			$filter_tieuchuan = $this->request->get['filter_tieuchuan'];
		} else {
			$filter_tieuchuan = null;
		}
		
		if (isset($this->request->get['filter_ishome'])) {
			$filter_ishome = $this->request->get['filter_ishome'];
		} else {
			$filter_ishome = null;
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
		
		if (isset($this->request->get['filter_category'])) {
				$url .= '&filter_category=' . $this->request->get['filter_category'];
			}
			
			if (isset($this->request->get['filter_tieuchuan'])) {
				$url .= '&filter_tieuchuan=' . $this->request->get['filter_tieuchuan'];
			}
			
			if (isset($this->request->get['filter_ishome'])) {
				$url .= '&filter_ishome=' . $this->request->get['filter_ishome'];
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
		                                     'href'      => $this->url->link('catalog/brochure', 'token=' . $this->session->data['token'] . $url, '', 'SSL'),
		                                     'separator' => ' :: '
		                                     );

		$url_filter = '';
		if (isset($this->request->get['filter_category'])) {
			$url_filter .= '&filter_category=' . $this->request->get['filter_category'];
		}

		$this->data['insert'] = $this->url->link('catalog/brochure/insert', 'token=' . $this->session->data['token'] . $url, '', 'SSL');
		$this->data['copy'] = $this->url->link('catalog/brochure/copy', 'token=' . $this->session->data['token'] . $url, '', 'SSL');
		$this->data['delete'] = $this->url->link('catalog/brochure/delete', 'token=' . $this->session->data['token'] . $url, '', 'SSL');

		$this->data['filter'] = $this->url->link('catalog/brochure', 'token=' . $this->session->data['token'] . $url_filter, '', 'SSL');
		/*{BACK}*/
		$this->data['brochures'] = array();

		$data = array(
		              'filter_name'	  => $filter_name,
					  'filter_category'   => $filter_category,
					  'filter_ishome'   => $filter_ishome,
					  'filter_tieuchuan'   => $filter_tieuchuan,
		              /*{FILTER_PARAM}*/
		              'filter_status'   => $filter_status,
		              'sort'            => $sort,
		              'order'           => $order,
		              'start'           => ($page - 1) * $this->config->get('config_admin_limit'),
		              'limit'           => $this->config->get('config_admin_limit')
		              );
		$this->load->model('tool/image');
		$brochure_total = $this->model_catalog_brochure->getTotalBrochures($data);

		$results = $this->model_catalog_brochure->getBrochures($data);

		/*{INCLUDE_CATEGORY}*/
		
		$this->load->model('catalog/category');
		$this->data['categories'] = $this->model_catalog_category->getCategories(164);
		if(isset($this->request->get['filter_category']))
			$this->data['filter_category'] = $this->request->get['filter_category'];
		else
			$this->data['filter_category'] = 0;
        
		
		//$this->load->model('catalog/tieuchuan');			
		$this->data['tieuchuans'] = array();//$this->model_catalog_tieuchuan->getTieuchuans(array('sort'=>'p.sort_order','order'=>'ASC'));
		if(isset($this->request->get['filter_tieuchuan']))
			$this->data['filter_tieuchuan'] = $this->request->get['filter_tieuchuan'];
		else
			$this->data['filter_tieuchuan'] = 0;
        
		

		foreach ($results as $result) {
			$action = array();
			/*{SUBLIST}*/
			$action[] = array(
			                  'cls'  =>'modify',
			                  'text' => $this->data['text_edit'],
			                  'href' => $this->url->link('catalog/brochure/update', 'token=' . $this->session->data['token'] . '&brochure_id=' . $result['brochure_id'] . $url, '', 'SSL')
			                  );
			            if ($result['image'] && file_exists(DIR_IMAGE . $result['image'])) {
                $image = $this->model_tool_image->resize($result['image'], 40, 40);
            } else {
                $image = $this->model_tool_image->resize('no_image.jpg', 40, 40);
            }
			$this->data['brochures'][] = array(
			                                                  'brochure_id' => $result['brochure_id'],
			                                                  'sort_order'       => $result['sort_order'],
			                                                  'name'       => $result['name'],
															  'category'       => $this->model_catalog_category->getPath($result['category_id']),	
															  'tieuchuan'       => '',
															  //$result['tieuchuan_id']?$this->model_catalog_tieuchuan->getTitle($result['tieuchuan_id']):'',	
															  'ishome'     => ($result['ishome'] ? '<img src="view/image/success.png" title="'.$this->data['text_enabled'].'" />' : '<img src="view/image/delete.png" title="'.$this->data['text_disabled'].'" />'),
			                                                  'image'      => $image,
/*{IMAGE_LIST_ARRAY}*/
			                                                  'status_id'		=> $result['status'],
			                                                  'status'     => ($result['status'] ? '<img src="view/image/success.png" title="'.$this->data['text_enabled'].'" />' : '<img src="view/image/delete.png" title="'.$this->data['text_disabled'].'" />'),
			                                                  'selected'   => isset($this->request->post['selected']) && in_array($result['brochure_id'], $this->request->post['selected']),
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
		
		if (isset($this->request->get['filter_category'])) {
				$url .= '&filter_category=' . $this->request->get['filter_category'];
			}
			
			if (isset($this->request->get['filter_tieuchuan'])) {
				$url .= '&filter_tieuchuan=' . $this->request->get['filter_tieuchuan'];
			}
			
			if (isset($this->request->get['filter_ishome'])) {
				$url .= '&filter_ishome=' . $this->request->get['filter_ishome'];
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

		$this->data['sort_name'] = $this->url->link('catalog/brochure', 'token=' . $this->session->data['token'] . '&sort=pd.name' . $url, '', 'SSL');
		$this->data['sort_status'] = $this->url->link('catalog/brochure', 'token=' . $this->session->data['token'] . '&sort=p.status' . $url, '', 'SSL');
		$this->data['sort_order'] = $this->url->link('catalog/brochure', 'token=' . $this->session->data['token'] . '&sort=p.sort_order' . $url, '', 'SSL');

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}
		
		if (isset($this->request->get['filter_category'])) {
				$url .= '&filter_category=' . $this->request->get['filter_category'];
			}
			
			if (isset($this->request->get['filter_tieuchuan'])) {
				$url .= '&filter_tieuchuan=' . $this->request->get['filter_tieuchuan'];
			}
			
			if (isset($this->request->get['filter_ishome'])) {
				$url .= '&filter_ishome=' . $this->request->get['filter_ishome'];
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
		$pagination->total = $brochure_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->data['text_pagination'];
		$pagination->url = $this->url->link('catalog/brochure', 'token=' . $this->session->data['token'] . $url . '&page={page}', '', 'SSL');

		$this->data['pagination'] = $pagination->render();

		$this->data['results'] = sprintf($this->language->get('text_pagination'), ($brochure_total) ? (($page - 1) * $this->config->get('config_admin_limit')) + 1 : 0, ((($page - 1) * $this->config->get('config_admin_limit')) > ($brochure_total - $this->config->get('config_admin_limit'))) ? $brochure_total : ((($page - 1) * $this->config->get('config_admin_limit')) + $this->config->get('config_admin_limit')), $brochure_total, ceil($brochure_total / $this->config->get('config_admin_limit')));

		$this->data['filter_name'] = $filter_name;
		$this->data['filter_category'] = $filter_category;
		$this->data['filter_ishome'] = $filter_ishome;
		$this->data['filter_tieuchuan'] = $filter_tieuchuan;

		/*{FILTER_DATA}*/

		$this->data['filter_status'] = $filter_status;

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'catalog/brochure_list.tpl';
		$this->children = array(
		                        'common/header',
		                        'common/footer',
		                        );

		$this->response->setOutput($this->render());
	}

	private function getForm() {
		
		$brochure_id = isset($this->request->get['brochure_id'])?(int)$this->request->get['brochure_id']:0;
		$this->data['brochure_id'] = $brochure_id;
		
		$filter_category = isset($this->request->get['filter_category'])?(int)$this->request->get['filter_category']:0;
		$this->data['filter_category'] = $filter_category;
		
		if($filter_category!=259 && $filter_category!=265){
			$this->data['help_download'] = $this->data['help_download_rar'];
		}
		
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
        
        		if (isset($this->error['pdf'])) {
			$this->data['error_pdf'] = $this->error['pdf'];
		} else {
			$this->data['error_pdf'] = array();
		}
		
		if (isset($this->error['category_id'])) {
			$this->data['error_category_id'] = $this->error['category_id'];
		} else {
			$this->data['error_category_id'] = '';
		}
        
        /*{ERROR_IMAGE}*/
 		//URL

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}
		
		if (isset($this->request->get['filter_category'])) {
				$url .= '&filter_category=' . $this->request->get['filter_category'];
			}
			
			if (isset($this->request->get['filter_tieuchuan'])) {
				$url .= '&filter_tieuchuan=' . $this->request->get['filter_tieuchuan'];
			}
			
			if (isset($this->request->get['filter_ishome'])) {
				$url .= '&filter_ishome=' . $this->request->get['filter_ishome'];
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
		                                     'href'      => $this->url->link('catalog/brochure', 'token=' . $this->session->data['token'] . $url, '', 'SSL'),
		                                     'separator' => ' :: '
		                                     );

		//====================================================Assigne Data=======================================================
		if (!isset($this->request->get['brochure_id'])) {
			$this->data['action'] = $this->url->link('catalog/brochure/insert', 'token=' . $this->session->data['token'] . $url, '', 'SSL');
		} else {
			$this->data['action'] = $this->url->link('catalog/brochure/update', 'token=' . $this->session->data['token'] . '&brochure_id=' . $this->request->get['brochure_id'] . $url, '', 'SSL');
		}

		$this->data['cancel'] = $this->url->link('catalog/brochure', 'token=' . $this->session->data['token'] . $url, '', 'SSL');

		$this->data['token'] = $this->session->data['token'];

		//cate danh sach con
		 if(isset($this->request->get['cate']) && $this->request->get['cate']>0){
		 	$sublist_cate = $this->model_catalog_brochure->getCateById($this->request->get['cate']);
		 	$this->data['sublist_cate'] = $sublist_cate;
		 }else{
		 	$this->data['sublist_cate'] = 0;
		 }


		if (isset($this->request->get['brochure_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$brochure_info = $this->model_catalog_brochure->getBrochure($this->request->get['brochure_id']);
		}

		$this->load->model('localisation/language');

		$this->data['languages'] = $this->model_localisation_language->getLanguages();
		$this->load->model('tool/image');
		        if (isset($this->request->post['image'])) {
            $this->data['image'] = $this->request->post['image'];
        } elseif (isset($brochure_info)) {
            $this->data['image'] = $brochure_info['image'];
        } else {
            $this->data['image'] = '';
        }

		if (isset($brochure_info) && $brochure_info['image'] && file_exists(DIR_IMAGE . $brochure_info['image'])) {
			$this->data['preview'] = $this->model_tool_image->resize($brochure_info['image'], 100, 100);
		} elseif(isset($this->request->post['image']) && !empty($this->request->post['image']) && file_exists(DIR_IMAGE . $this->request->post['image'])) {
			$this->data['preview'] = $this->model_tool_image->resize($this->request->post['image'], 100, 100);
		}else{
			$this->data['preview'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}
        
        /*{IMAGE_FORM}*/
		
		$this->load->model('catalog/category');			
		$this->data['categories'] = $this->model_catalog_category->getCategories(164,2);
		
		if (isset($this->request->post['category_id'])) {
			$this->data['category_id'] = $this->request->post['category_id'];
		} elseif (isset($brochure_info)) {
			$this->data['category_id'] = $brochure_info['category_id'];
		} else {
			$this->data['category_id'] = 0;
		}
		
		if (isset($this->request->get['filter_category'])) {
			$this->data['category_id'] = $this->request->get['filter_category'];
		}
		
		
		//$this->load->model('catalog/tieuchuan');			
		$this->data['tieuchuans'] = array();//$this->model_catalog_tieuchuan->getTieuchuans(array('sort'=>'p.sort_order','order'=>'ASC'));
		
		if (isset($this->request->post['tieuchuan_id'])) {
			$this->data['tieuchuan_id'] = $this->request->post['tieuchuan_id'];
		} elseif (isset($brochure_info)) {
			$this->data['tieuchuan_id'] = $brochure_info['tieuchuan_id'];
		} else {
			$this->data['tieuchuan_id'] = 0;
		}
		
		if (isset($this->request->post['ishome'])) {
			$this->data['ishome'] = $this->request->post['ishome'];
		} elseif (isset($brochure_info)) {
			$this->data['ishome'] = $brochure_info['ishome'];
		} else {
			$this->data['ishome'] = '';
		}
		
		if (isset($this->request->post['date_insert'])) {
			$this->data['date_insert'] = $this->request->post['date_insert'];
		} elseif (isset($brochure_info)) {
			$this->data['date_insert'] = date('d-m-Y', strtotime($brochure_info['date_insert']));
    	} else {
			$this->data['date_insert'] = date('d-m-Y');
		}

		if (isset($this->request->post['sort_order'])) {
			$this->data['sort_order'] = $this->request->post['sort_order'];
		} elseif (isset($brochure_info)) {
			$this->data['sort_order'] = $brochure_info['sort_order'];
		} else {
			$this->data['sort_order'] = 0;
		}

		if (isset($this->request->post['status'])) {
			$this->data['status'] = $this->request->post['status'];
		} else if (isset($brochure_info)) {
			$this->data['status'] = $brochure_info['status'];
		} else {
			$this->data['status'] = 1;
		}

		//tab data
		if (isset($this->request->post['brochure_description'])) {
			$this->data['brochure_description'] = $this->request->post['brochure_description'];
		} elseif (isset($brochure_info)) {
			$this->data['brochure_description'] = $this->model_catalog_brochure->getBrochureDescriptions($this->request->get['brochure_id']);
		} else {
			$this->data['brochure_description'] = array();
		}


		$this->template = 'catalog/brochure_form.tpl';
		$this->children = array(
		                        'common/header',
		                        'common/footer',
		                        );

		$this->response->setOutput($this->render());
	}
	
	private function validateFormList() { 
	
    	if (!$this->user->hasPermission('modify', 'catalog/brochure')) {
      		$this->error['warning'] = $this->data['error_permission'];
    	}

		if(empty($this->request->post['image']))
			$this->error['image'] = $this->data['error_image'];
			
		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->data['error_warning'];
		}
					
    	if (!$this->error) {
			return true;
    	} else {
      		return false;
    	}
  	}

	private function validateForm() {

		if (!$this->user->hasPermission('modify', 'catalog/brochure')) {
			$this->error['warning'] = $this->data['error_permission'];
		}

		//chi validate ngon ngu mac dinh (khi lay du lieu kiem tra neu title khac rong moi hien thi)
		if((strlen(utf8_decode($this->request->post['brochure_description'][$this->config->get('config_language_id')]['name'])) < 1) || (strlen(utf8_decode($this->request->post['brochure_description'][$this->config->get('config_language_id')]['name'])) > 255))
			$this->error['name'][$this->config->get('config_language_id')] = $this->data['error_name'];
		
		
		$filter_category = isset($this->request->get['filter_category'])?(int)$this->request->get['filter_category']:0;
		$this->data['filter_category'] = $filter_category;
		
		if($filter_category!=259 && $filter_category!=265){
			foreach ($this->request->post['brochure_description'] as $language_id => $value) {
							if(!empty($this->request->files['brochure_description']['name'][$language_id]['pdf'])
					&& ($this->request->files['brochure_description']['error'][$language_id]['pdf']!=0 
					|| (strtolower(strrchr($this->request->files['brochure_description']['name'][$language_id]['pdf'], '.'))!='.rar' 
					&& strtolower(strrchr($this->request->files['brochure_description']['name'][$language_id]['pdf'], '.'))!='.zip'
					)))
				{
					
					$this->error['pdf'][$language_id] = $this->data['error_pdf_no_support'];
				}
				
			/*{VALIDATE_PDF}*/
			}
		}else{
		
		
		foreach ($this->request->post['brochure_description'] as $language_id => $value) {
						if(!empty($this->request->files['brochure_description']['name'][$language_id]['pdf'])
				&& ($this->request->files['brochure_description']['error'][$language_id]['pdf']!=0 
				|| (strtolower(strrchr($this->request->files['brochure_description']['name'][$language_id]['pdf'], '.'))!='.pdf' 
				//&& strtolower(strrchr($this->request->files['brochure_description']['name'][$language_id]['pdf'], '.'))!='.doc'
				)))
			{
				
				$this->error['pdf'][$language_id] = $this->data['error_pdf_no_support'];
			}
			
		/*{VALIDATE_PDF}*/
		}
		}
		
		if($this->request->post['category_id']==0){
			$this->error['category_id'] = $this->data['error_category'];
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
		if (!$this->user->hasPermission('modify', 'catalog/brochure')) {
			$this->error['warning'] = $this->data['error_permission'];
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	private function validateCopy() {
		if (!$this->user->hasPermission('modify', 'catalog/brochure')) {
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
			$this->load->model('catalog/brochure');

			$data = array(
			              'filter_name' => $this->request->post['filter_name'],
			              'start'       => 0,
			              'limit'       => 20
			              );

			$results = $this->model_catalog_brochure->getBrochures($data);

			foreach ($results as $result) {
				$json[] = array(
				                'brochure_id' => $result['brochure_id'],
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
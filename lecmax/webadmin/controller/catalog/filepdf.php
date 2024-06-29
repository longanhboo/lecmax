<?php
class ControllerCatalogFilepdf extends Controller {
	private $error = array();

	public function __construct($registry) {
		$this->registry = $registry;

		$this->load->model('catalog/lang');

		$langs = $this->model_catalog_lang->getLangByModule('filepdf',2);
		foreach($langs as $lang){
			$this->data[$lang['key']] = html_entity_decode($lang['name']);
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
		
		$this->load->model('catalog/filepdf');

		$this->getList();
	}

	public function insert() {

		$this->document->setTitle($this->data['heading_title']);

		$this->load->model('catalog/filepdf');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$data = $this->request->post;

				
			$time = time();
			
			$this->load->model('localisation/language');		
			$languages = $this->model_localisation_language->getLanguages();
			
			foreach($languages as $lang){
				$parts = pathinfo($this->request->files['filepdf_description']['name'][$lang['language_id']]['pdf']);
								
				if(!empty($parts['filename']))
					$filename = convertAlias($parts['filename']) . '_' . $lang['code'] . '_'. $time . '.' . $parts['extension'];
				else
					$filename = '';
				
				if($this->request->files['filepdf_description']['error'][$lang['language_id']]['pdf']==0){
					@move_uploaded_file($this->request->files['filepdf_description']['tmp_name'][$lang['language_id']]['pdf'], DIR_PDF . $filename);
					$data['filepdf_description'][$lang['language_id']]['pdf'] = $filename;
				}else{
					$data['filepdf_description'][$lang['language_id']]['pdf']='';	
				}								
			}
            
            /*{INSERT_CONTROLLER}*/

			$this->model_catalog_filepdf->addFilepdf($data);

			$this->session->data['success'] = $this->data['text_success'];

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . $this->request->get['filter_name'];
			}
			
			if (isset($this->request->get['filter_isnew'])) {
				$url .= '&filter_isnew=' . $this->request->get['filter_isnew'];
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

			$this->redirect($this->url->link('catalog/filepdf', 'token=' . $this->session->data['token'] . $url, '', 'SSL'));
			
			exit;
		}

		$this->getForm();
	}

	public function update() {

		$this->document->setTitle($this->data['heading_title']);

		$this->load->model('catalog/filepdf');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$data = $this->request->post;

						$time = time();
			
			$this->load->model('localisation/language');		
			$languages = $this->model_localisation_language->getLanguages();
			
			foreach($languages as $lang){
				$parts = pathinfo($this->request->files['filepdf_description']['name'][$lang['language_id']]['pdf']);
				
				if(!empty($parts['filename']))
					$filename = convertAlias($parts['filename']) . '_' . $lang['code'] . '_'. $time . '.' . $parts['extension'];
				else
					$filename = '';
				
				if(isset($this->request->post['filepdf_description'][$lang['language_id']]['delete_pdf']) && $this->request->post['filepdf_description'][$lang['language_id']]['delete_pdf']==1)
				{
					$data['filepdf_description'][$lang['language_id']]['pdf'] = '';
					$old_file = $this->request->post['filepdf_description'][$lang['language_id']]['old_file'];
					if(!empty($old_file) && file_exists(DIR_PDF . $old_file))
						unlink(DIR_PDF . $old_file);
				}else{
					if($this->request->files['filepdf_description']['error'][$lang['language_id']]['pdf']==0){
						
						$old_file = $this->request->post['filepdf_description'][$lang['language_id']]['old_file'];
						if(!empty($old_file) && file_exists(DIR_PDF . $old_file))
							unlink(DIR_PDF . $old_file);
						
						@move_uploaded_file($this->request->files['filepdf_description']['tmp_name'][$lang['language_id']]['pdf'], DIR_PDF . $filename);
						$data['filepdf_description'][$lang['language_id']]['pdf'] = $filename;
					}else{
						$data['filepdf_description'][$lang['language_id']]['pdf']=$this->request->post['filepdf_description'][$lang['language_id']]['old_file'];	
					}
				}				
			}
            
            /*{UPDATE_CONTROLLER}*/


			$this->model_catalog_filepdf->editFilepdf($this->request->get['filepdf_id'], $data);

			$this->session->data['success'] = $this->data['text_success_update'];

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . $this->request->get['filter_name'];
			}
			
			if (isset($this->request->get['filter_isnew'])) {
				$url .= '&filter_isnew=' . $this->request->get['filter_isnew'];
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

			$this->redirect($this->url->link('catalog/filepdf', 'token=' . $this->session->data['token'] . $url, '', 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {

		$this->document->setTitle($this->data['heading_title']);

		$this->load->model('catalog/filepdf');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $filepdf_id) {

								$pdfs = $this->model_catalog_filepdf->getPdf($filepdf_id);
				
				foreach($pdfs as $item){
					if(!empty($item['pdf']) && file_exists(DIR_PDF . $item['pdf']))
							unlink(DIR_PDF . $item['pdf']);
				}

				/*{DELETE_CONTROLLER}*/

				$this->model_catalog_filepdf->deleteFilepdf($filepdf_id);
			}

			$this->session->data['success'] = $this->data['text_success_delete'];

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . $this->request->get['filter_name'];
			}
			
			if (isset($this->request->get['filter_isnew'])) {
				$url .= '&filter_isnew=' . $this->request->get['filter_isnew'];
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

			$this->redirect($this->url->link('catalog/filepdf', 'token=' . $this->session->data['token'] . $url, '', 'SSL'));
		}

		$this->getList();
	}

	public function copy() {

		$this->document->setTitle($this->data['heading_title']);

		$this->load->model('catalog/filepdf');

		if (isset($this->request->post['selected']) && $this->validateCopy()) {
			foreach ($this->request->post['selected'] as $filepdf_id) {
				$this->model_catalog_filepdf->copyFilepdf($filepdf_id);
			}

			$this->session->data['success'] = $this->data['text_success'];

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . $this->request->get['filter_name'];
			}
			
			if (isset($this->request->get['filter_isnew'])) {
				$url .= '&filter_isnew=' . $this->request->get['filter_isnew'];
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

			$this->redirect($this->url->link('catalog/filepdf', 'token=' . $this->session->data['token'] . $url, '', 'SSL'));
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
		
		if (isset($this->request->get['filter_isnew'])) {
			$filter_isnew = $this->request->get['filter_isnew'];
		} else {
			$filter_isnew = null;
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
		
		if (isset($this->request->get['filter_isnew'])) {
				$url .= '&filter_isnew=' . $this->request->get['filter_isnew'];
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
		                                     'href'      => $this->url->link('catalog/filepdf', 'token=' . $this->session->data['token'] . $url, '', 'SSL'),
		                                     'separator' => ' :: '
		                                     );

		$url_filter = '';
		if (isset($this->request->get['filter_category'])) {
			$url_filter .= '&filter_category=' . $this->request->get['filter_category'];
		}

		$this->data['insert'] = $this->url->link('catalog/filepdf/insert', 'token=' . $this->session->data['token'] . $url, '', 'SSL');
		$this->data['copy'] = $this->url->link('catalog/filepdf/copy', 'token=' . $this->session->data['token'] . $url, '', 'SSL');
		$this->data['delete'] = $this->url->link('catalog/filepdf/delete', 'token=' . $this->session->data['token'] . $url, '', 'SSL');

		$this->data['filter'] = $this->url->link('catalog/filepdf', 'token=' . $this->session->data['token'] . $url_filter, '', 'SSL');
		/*{BACK}*/
		$this->data['filepdfs'] = array();

		$data = array(
		              'filter_name'	  => $filter_name,
					  'filter_isnew'   => $filter_isnew,
		              /*{FILTER_PARAM}*/
		              'filter_status'   => $filter_status,
		              'sort'            => $sort,
		              'order'           => $order,
		              'start'           => ($page - 1) * $this->config->get('config_admin_limit'),
		              'limit'           => $this->config->get('config_admin_limit')
		              );
		$this->load->model('tool/image');
		$filepdf_total = $this->model_catalog_filepdf->getTotalFilepdfs($data);

		$results = $this->model_catalog_filepdf->getFilepdfs($data);

		/*{INCLUDE_CATEGORY}*/

		foreach ($results as $result) {
			$action = array();
			/*{SUBLIST}*/
			$action[] = array(
			                  'cls'  =>'modify',
			                  'text' => $this->data['text_edit'],
			                  'href' => $this->url->link('catalog/filepdf/update', 'token=' . $this->session->data['token'] . '&filepdf_id=' . $result['filepdf_id'] . $url, '', 'SSL')
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
			$this->data['filepdfs'][] = array(
			                                                  'filepdf_id' => $result['filepdf_id'],
			                                                  'sort_order'       => $result['sort_order'],
			                                                  'name'       => $result['name'],
															  
															  'isnew'     => ($result['isnew'] ? '<img src="view/image/success.png" title="'.$this->data['text_enabled'].'" />' : '<img src="view/image/delete.png" title="'.$this->data['text_disabled'].'" />'),
															  
															  'status_en' =>$this->model_catalog_filepdf->getStatus('filepdf',$result['filepdf_id'],1,$check_editor),
															  
			                                                  'image'      => $image,
/*{IMAGE_LIST_ARRAY}*/
			                                                  'status_id'		=> $result['status'],
			                                                  'status'     => ($result['status'] ? '<img src="view/image/success.png" title="'.$this->data['text_enabled'].'" />' : '<img src="view/image/delete.png" title="'.$this->data['text_disabled'].'" />'),
			                                                  'selected'   => isset($this->request->post['selected']) && in_array($result['filepdf_id'], $this->request->post['selected']),
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
		
		if (isset($this->request->get['filter_isnew'])) {
				$url .= '&filter_isnew=' . $this->request->get['filter_isnew'];
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

		$this->data['sort_name'] = $this->url->link('catalog/filepdf', 'token=' . $this->session->data['token'] . '&sort=pd.name' . $url, '', 'SSL');
		$this->data['sort_status'] = $this->url->link('catalog/filepdf', 'token=' . $this->session->data['token'] . '&sort=p.status' . $url, '', 'SSL');
		$this->data['sort_order'] = $this->url->link('catalog/filepdf', 'token=' . $this->session->data['token'] . '&sort=p.sort_order' . $url, '', 'SSL');

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}
		
		if (isset($this->request->get['filter_isnew'])) {
				$url .= '&filter_isnew=' . $this->request->get['filter_isnew'];
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
		$pagination->total = $filepdf_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->data['text_pagination'];
		$pagination->url = $this->url->link('catalog/filepdf', 'token=' . $this->session->data['token'] . $url . '&page={page}', '', 'SSL');

		$this->data['pagination'] = $pagination->render();

		$this->data['results'] = sprintf($this->language->get('text_pagination'), ($filepdf_total) ? (($page - 1) * $this->config->get('config_admin_limit')) + 1 : 0, ((($page - 1) * $this->config->get('config_admin_limit')) > ($filepdf_total - $this->config->get('config_admin_limit'))) ? $filepdf_total : ((($page - 1) * $this->config->get('config_admin_limit')) + $this->config->get('config_admin_limit')), $filepdf_total, ceil($filepdf_total / $this->config->get('config_admin_limit')));

		$this->data['filter_name'] = $filter_name;
		
		$this->data['filter_isnew'] = $filter_isnew;

		/*{FILTER_DATA}*/

		$this->data['filter_status'] = $filter_status;

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'catalog/filepdf_list.tpl';
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
        
        /*{ERROR_IMAGE}*/
 		//URL

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}
		
		if (isset($this->request->get['filter_isnew'])) {
				$url .= '&filter_isnew=' . $this->request->get['filter_isnew'];
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
		                                     'href'      => $this->url->link('catalog/filepdf', 'token=' . $this->session->data['token'] . $url, '', 'SSL'),
		                                     'separator' => ' :: '
		                                     );

		//====================================================Assigne Data=======================================================
		if (!isset($this->request->get['filepdf_id'])) {
			$this->data['action'] = $this->url->link('catalog/filepdf/insert', 'token=' . $this->session->data['token'] . $url, '', 'SSL');
		} else {
			$this->data['action'] = $this->url->link('catalog/filepdf/update', 'token=' . $this->session->data['token'] . '&filepdf_id=' . $this->request->get['filepdf_id'] . $url, '', 'SSL');
		}

		$this->data['cancel'] = $this->url->link('catalog/filepdf', 'token=' . $this->session->data['token'] . $url, '', 'SSL');

		$this->data['token'] = $this->session->data['token'];

		//cate danh sach con
		 if(isset($this->request->get['cate']) && $this->request->get['cate']>0){
		 	$sublist_cate = $this->model_catalog_filepdf->getCateById($this->request->get['cate']);
		 	$this->data['sublist_cate'] = $sublist_cate;
		 }else{
		 	$this->data['sublist_cate'] = 0;
		 }


		if (isset($this->request->get['filepdf_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$filepdf_info = $this->model_catalog_filepdf->getFilepdf($this->request->get['filepdf_id']);
		}

		$this->load->model('localisation/language');

		$this->data['languages'] = $this->model_localisation_language->getLanguages();
		$this->load->model('tool/image');
		        if (isset($this->request->post['image'])) {
            $this->data['image'] = $this->request->post['image'];
        } elseif (isset($filepdf_info)) {
            $this->data['image'] = $filepdf_info['image'];
        } else {
            $this->data['image'] = '';
        }

		if (isset($filepdf_info) && $filepdf_info['image'] && file_exists(DIR_IMAGE . $filepdf_info['image'])) {
			$this->data['preview'] = $this->model_tool_image->resize($filepdf_info['image'], 100, 100);
		} elseif(isset($this->request->post['image']) && !empty($this->request->post['image']) && file_exists(DIR_IMAGE . $this->request->post['image'])) {
			$this->data['preview'] = $this->model_tool_image->resize($this->request->post['image'], 100, 100);
		}else{
			$this->data['preview'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}
		
		if (isset($this->request->post['link'])) {
			$this->data['link'] = $this->request->post['link'];
		} elseif (isset($filepdf_info)) {
			$this->data['link'] = str_replace('HTTP_CATALOG',HTTP_CATALOG, $filepdf_info['link']);
		} else {
			$this->data['link'] = '';
		}
        
		if (isset($this->request->post['isnew'])) {
			$this->data['isnew'] = $this->request->post['isnew'];
		} elseif (isset($filepdf_info)) {
			$this->data['isnew'] = $filepdf_info['isnew'];
		} else {
			$this->data['isnew'] = 0;
		}
		
        /*{IMAGE_FORM}*/

		if (isset($this->request->post['sort_order'])) {
			$this->data['sort_order'] = $this->request->post['sort_order'];
		} elseif (isset($filepdf_info)) {
			$this->data['sort_order'] = $filepdf_info['sort_order'];
		} else {
			$this->data['sort_order'] = 0;
		}

		if (isset($this->request->post['status'])) {
			$this->data['status'] = $this->request->post['status'];
		} else if (isset($filepdf_info)) {
			$this->data['status'] = $filepdf_info['status'];
		} else {
			$this->data['status'] = 1;
		}

		//tab data
		if (isset($this->request->post['filepdf_description'])) {
			$this->data['filepdf_description'] = $this->request->post['filepdf_description'];
		} elseif (isset($filepdf_info)) {
			$this->data['filepdf_description'] = $this->model_catalog_filepdf->getFilepdfDescriptions($this->request->get['filepdf_id']);
		} else {
			$this->data['filepdf_description'] = array();
		}


		$this->template = 'catalog/filepdf_form.tpl';
		$this->children = array(
		                        'common/header',
		                        'common/footer',
		                        );

		$this->response->setOutput($this->render());
	}

	private function validateForm() {

		if (!$this->user->hasPermission('modify', 'catalog/filepdf')) {
			$this->error['warning'] = $this->data['error_permission'];
		}

		//chi validate ngon ngu mac dinh (khi lay du lieu kiem tra neu title khac rong moi hien thi)
		if((strlen(utf8_decode($this->request->post['filepdf_description'][$this->config->get('config_language_id')]['name'])) < 1) || (strlen(utf8_decode($this->request->post['filepdf_description'][$this->config->get('config_language_id')]['name'])) > 255))
			$this->error['name'][$this->config->get('config_language_id')] = $this->data['error_name'];

		foreach ($this->request->post['filepdf_description'] as $language_id => $value) {
						if(!empty($this->request->files['filepdf_description']['name'][$language_id]['pdf'])
				&& ($this->request->files['filepdf_description']['error'][$language_id]['pdf']!=0 
				|| (strtolower(strrchr($this->request->files['filepdf_description']['name'][$language_id]['pdf'], '.'))!='.pdf' 
				//&& strtolower(strrchr($this->request->files['filepdf_description']['name'][$language_id]['pdf'], '.'))!='.doc'
				)))
			{
				
				$this->error['pdf'][$language_id] = $this->data['error_pdf_no_support'];
			}
			
		/*{VALIDATE_PDF}*/
		}

		if(empty($this->request->post['image']))
			$this->error['image'] = $this->data['error_image'];
			
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
		if (!$this->user->hasPermission('modify', 'catalog/filepdf')) {
			$this->error['warning'] = $this->data['error_permission'];
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	private function validateCopy() {
		if (!$this->user->hasPermission('modify', 'catalog/filepdf')) {
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
			$this->load->model('catalog/filepdf');

			$data = array(
			              'filter_name' => $this->request->post['filter_name'],
			              'start'       => 0,
			              'limit'       => 20
			              );

			$results = $this->model_catalog_filepdf->getFilepdfs($data);

			foreach ($results as $result) {
				$json[] = array(
				                'filepdf_id' => $result['filepdf_id'],
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
<?php
class ControllerCatalogAudio extends Controller {
	private $error = array();

	public function __construct($registry) {
		$this->registry = $registry;

		$this->load->model('catalog/lang');

		$langs = $this->model_catalog_lang->getLangByModule('audio',2);
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

		$this->load->model('catalog/audio');

		$this->getList();
	}

	public function insert() {

		$this->document->setTitle($this->data['heading_title']);

		$this->load->model('catalog/audio');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$data = $this->request->post;

			if (is_uploaded_file($this->request->files['audio_mp3']['tmp_name'])) {
				
				$ext = strrchr($this->request->files['audio_mp3']['name'], '.');
				
				$name = substr($this->request->files['audio_mp3']['name'],0, (strlen($this->request->files['audio_mp3']['name']) - strlen($ext)));
				
				$filename = $name . '.' . md5(rand()) . $ext;
				
				move_uploaded_file($this->request->files['audio_mp3']['tmp_name'], DIR_AUDIO . $filename);

				if (file_exists(DIR_AUDIO . $filename)) {
					$data['audio_mp3'] = $filename;
				}
			}
				
			$time = time();
			
			$this->load->model('localisation/language');		
			$languages = $this->model_localisation_language->getLanguages();
			
			foreach($languages as $lang){
				$parts = pathinfo($this->request->files['audio_description']['name'][$lang['language_id']]['pdf']);
								
				if(!empty($parts['filename']))
					$filename = convertAlias($parts['filename']) . '_' . $lang['code'] . '_'. $time . '.' . $parts['extension'];
				else
					$filename = '';
				
				if($this->request->files['audio_description']['error'][$lang['language_id']]['pdf']==0){
					@move_uploaded_file($this->request->files['audio_description']['tmp_name'][$lang['language_id']]['pdf'], DIR_PDF . $filename);
					$data['audio_description'][$lang['language_id']]['pdf'] = $filename;
				}else{
					$data['audio_description'][$lang['language_id']]['pdf']='';	
				}								
			}
            
            /*{INSERT_CONTROLLER}*/

			$this->model_catalog_audio->addAudio($data);

			$this->session->data['success'] = $this->data['text_success'];

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . $this->request->get['filter_name'];
			}

						if (isset($this->request->get['filter_ishome'])) {
				$url .= '&filter_ishome=' . $this->request->get['filter_ishome'];
			}
            
            			if (isset($this->request->get['filter_category'])) {
				$url .= '&filter_category=' . $this->request->get['filter_category'];
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

			$this->redirect($this->url->link('catalog/audio', 'token=' . $this->session->data['token'] . $url, '', 'SSL'));
			
			exit;
		}

		$this->getForm();
	}

	public function update() {

		$this->document->setTitle($this->data['heading_title']);

		$this->load->model('catalog/audio');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$data = $this->request->post;
			
			$filename_old = $this->model_catalog_audio->getAudioById($this->request->get['audio_id']) ;
			if (is_uploaded_file($this->request->files['audio_mp3']['tmp_name'])) {				

				if (!empty($filename_old['filename_mp3']) && file_exists(DIR_AUDIO . $filename_old['filename_mp3'])) {
					@unlink(DIR_AUDIO . $filename_old['filename_mp3']);
				}
				
				$ext = strrchr($this->request->files['audio_mp3']['name'], '.');
				
				$name = substr($this->request->files['audio_mp3']['name'],0, (strlen($this->request->files['audio_mp3']['name']) - strlen($ext)));
				
				$filename = $name . '.' . md5(rand()) . $ext;
				
				move_uploaded_file($this->request->files['audio_mp3']['tmp_name'], DIR_AUDIO . $filename);

				if (file_exists(DIR_AUDIO . $filename)) {
					$data['audio_mp3'] = $filename;
				}
			}
						$time = time();
			
			$this->load->model('localisation/language');		
			$languages = $this->model_localisation_language->getLanguages();
			
			foreach($languages as $lang){
				$parts = pathinfo($this->request->files['audio_description']['name'][$lang['language_id']]['pdf']);
				
				if(!empty($parts['filename']))
					$filename = convertAlias($parts['filename']) . '_' . $lang['code'] . '_'. $time . '.' . $parts['extension'];
				else
					$filename = '';
				
				if(isset($this->request->post['audio_description'][$lang['language_id']]['delete_pdf']) && $this->request->post['audio_description'][$lang['language_id']]['delete_pdf']==1)
				{
					$data['audio_description'][$lang['language_id']]['pdf'] = '';
					$old_file = $this->request->post['audio_description'][$lang['language_id']]['old_file'];
					if(!empty($old_file) && file_exists(DIR_PDF . $old_file))
						unlink(DIR_PDF . $old_file);
				}else{
					if($this->request->files['audio_description']['error'][$lang['language_id']]['pdf']==0){
						
						$old_file = $this->request->post['audio_description'][$lang['language_id']]['old_file'];
						if(!empty($old_file) && file_exists(DIR_PDF . $old_file))
							unlink(DIR_PDF . $old_file);
						
						@move_uploaded_file($this->request->files['audio_description']['tmp_name'][$lang['language_id']]['pdf'], DIR_PDF . $filename);
						$data['audio_description'][$lang['language_id']]['pdf'] = $filename;
					}else{
						$data['audio_description'][$lang['language_id']]['pdf']=$this->request->post['audio_description'][$lang['language_id']]['old_file'];	
					}
				}				
			}
            
            /*{UPDATE_CONTROLLER}*/


			$this->model_catalog_audio->editAudio($this->request->get['audio_id'], $data);

			$this->session->data['success'] = $this->data['text_success_update'];

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . $this->request->get['filter_name'];
			}

						if (isset($this->request->get['filter_ishome'])) {
				$url .= '&filter_ishome=' . $this->request->get['filter_ishome'];
			}
            
            			if (isset($this->request->get['filter_category'])) {
				$url .= '&filter_category=' . $this->request->get['filter_category'];
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

			$this->redirect($this->url->link('catalog/audio', 'token=' . $this->session->data['token'] . $url, '', 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {

		$this->document->setTitle($this->data['heading_title']);

		$this->load->model('catalog/audio');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $audio_id) {
				
				$filename_old = $this->model_catalog_audio->getAudioById($audio_id) ;
				
				if (!empty($filename_old['filename_mp3']) && file_exists(DIR_AUDIO . $filename_old['filename_mp3'])) {
					@unlink(DIR_AUDIO . $filename_old['filename_mp3']);
				}

								$pdfs = $this->model_catalog_audio->getPdf($audio_id);
				
				foreach($pdfs as $item){
					if(!empty($item['pdf']) && file_exists(DIR_PDF . $item['pdf']))
							unlink(DIR_PDF . $item['pdf']);
				}

				/*{DELETE_CONTROLLER}*/

				$this->model_catalog_audio->deleteAudio($audio_id);
			}

			$this->session->data['success'] = $this->data['text_success_delete'];

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . $this->request->get['filter_name'];
			}

						if (isset($this->request->get['filter_ishome'])) {
				$url .= '&filter_ishome=' . $this->request->get['filter_ishome'];
			}
            
            			if (isset($this->request->get['filter_category'])) {
				$url .= '&filter_category=' . $this->request->get['filter_category'];
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

			$this->redirect($this->url->link('catalog/audio', 'token=' . $this->session->data['token'] . $url, '', 'SSL'));
		}

		$this->getList();
	}

	public function copy() {

		$this->document->setTitle($this->data['heading_title']);

		$this->load->model('catalog/audio');

		if (isset($this->request->post['selected']) && $this->validateCopy()) {
			foreach ($this->request->post['selected'] as $audio_id) {
				$this->model_catalog_audio->copyAudio($audio_id);
			}

			$this->session->data['success'] = $this->data['text_success'];

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . $this->request->get['filter_name'];
			}

						if (isset($this->request->get['filter_ishome'])) {
				$url .= '&filter_ishome=' . $this->request->get['filter_ishome'];
			}
            
            			if (isset($this->request->get['filter_category'])) {
				$url .= '&filter_category=' . $this->request->get['filter_category'];
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

			$this->redirect($this->url->link('catalog/audio', 'token=' . $this->session->data['token'] . $url, '', 'SSL'));
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

				if (isset($this->request->get['filter_ishome'])) {
			$filter_ishome = $this->request->get['filter_ishome'];
		} else {
			$filter_ishome = null;
		}
        
        		if (isset($this->request->get['filter_category'])) {
			$filter_category = $this->request->get['filter_category'];
		} else {
			$filter_category = null;
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
            
            			if (isset($this->request->get['filter_category'])) {
				$url .= '&filter_category=' . $this->request->get['filter_category'];
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
		                                     'href'      => $this->url->link('catalog/audio', 'token=' . $this->session->data['token'] . $url, '', 'SSL'),
		                                     'separator' => ' :: '
		                                     );

		$url_filter = '';
		if (isset($this->request->get['filter_category'])) {
			$url_filter .= '&filter_category=' . $this->request->get['filter_category'];
		}

		$this->data['insert'] = $this->url->link('catalog/audio/insert', 'token=' . $this->session->data['token'] . $url, '', 'SSL');
		$this->data['copy'] = $this->url->link('catalog/audio/copy', 'token=' . $this->session->data['token'] . $url, '', 'SSL');
		$this->data['delete'] = $this->url->link('catalog/audio/delete', 'token=' . $this->session->data['token'] . $url, '', 'SSL');

		$this->data['filter'] = $this->url->link('catalog/audio', 'token=' . $this->session->data['token'] . $url_filter, '', 'SSL');
		/*{BACK}*/
		$this->data['audios'] = array();

		$data = array(
		              'filter_name'	  => $filter_name,
		              'filter_ishome'   => $filter_ishome,

'filter_category'   => $filter_category,

/*{FILTER_PARAM}*/
		              'filter_status'   => $filter_status,
		              'sort'            => $sort,
		              'order'           => $order,
		              'start'           => ($page - 1) * $this->config->get('config_admin_limit'),
		              'limit'           => $this->config->get('config_admin_limit')
		              );
		$this->load->model('tool/image');
		$audio_total = $this->model_catalog_audio->getTotalAudios($data);

		$results = $this->model_catalog_audio->getAudios($data);

		$this->load->model('catalog/category');
		$this->data['categories'] = $this->model_catalog_category->getCategories(232);
		if(isset($this->request->get['filter_category']))
			$this->data['filter_category'] = $this->request->get['filter_category'];
		else
			$this->data['filter_category'] = 0;
            
           
        /*{INCLUDE_CATEGORY}*/

		foreach ($results as $result) {
			$action = array();
			/*{SUBLIST}*/
			$action[] = array(
			                  'cls'  =>'modify',
			                  'text' => $this->data['text_edit'],
			                  'href' => $this->url->link('catalog/audio/update', 'token=' . $this->session->data['token'] . '&audio_id=' . $result['audio_id'] . $url, '', 'SSL')
			                  );
			            if ($result['image'] && file_exists(DIR_IMAGE . $result['image'])) {
                $image = $this->model_tool_image->resize($result['image'], 40, 40);
            } else {
                $image = $this->model_tool_image->resize('no_image.jpg', 40, 40);
            }
			$this->data['audios'][] = array(
			                                                  'audio_id' => $result['audio_id'],
			                                                  'sort_order'       => $result['sort_order'],
			                                                  'name'       => $result['name'],
			                                                  'image'      => $image,
    'ishome'     => ($result['ishome'] ? '<img src="view/image/success.png" title="'.$this->data['text_enabled'].'" />' : '<img src="view/image/delete.png" title="'.$this->data['text_disabled'].'" />'),
    'category'       => $this->model_catalog_category->getPath($result['category_id']),	

/*{IMAGE_LIST_ARRAY}*/	
			                                                  'status_id'		=> $result['status'],
			                                                  'status'     => ($result['status'] ? '<img src="view/image/success.png" title="'.$this->data['text_enabled'].'" />' : '<img src="view/image/delete.png" title="'.$this->data['text_disabled'].'" />'),
			                                                  'selected'   => isset($this->request->post['selected']) && in_array($result['audio_id'], $this->request->post['selected']),
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
            
            			if (isset($this->request->get['filter_category'])) {
				$url .= '&filter_category=' . $this->request->get['filter_category'];
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

		$this->data['sort_name'] = $this->url->link('catalog/audio', 'token=' . $this->session->data['token'] . '&sort=pd.name' . $url, '', 'SSL');
		$this->data['sort_status'] = $this->url->link('catalog/audio', 'token=' . $this->session->data['token'] . '&sort=p.status' . $url, '', 'SSL');
		$this->data['sort_order'] = $this->url->link('catalog/audio', 'token=' . $this->session->data['token'] . '&sort=p.sort_order' . $url, '', 'SSL');

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}

					if (isset($this->request->get['filter_ishome'])) {
				$url .= '&filter_ishome=' . $this->request->get['filter_ishome'];
			}
            
            			if (isset($this->request->get['filter_category'])) {
				$url .= '&filter_category=' . $this->request->get['filter_category'];
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
		$pagination->total = $audio_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->data['text_pagination'];
		$pagination->url = $this->url->link('catalog/audio', 'token=' . $this->session->data['token'] . $url . '&page={page}', '', 'SSL');

		$this->data['pagination'] = $pagination->render();

		$this->data['results'] = sprintf($this->language->get('text_pagination'), ($audio_total) ? (($page - 1) * $this->config->get('config_admin_limit')) + 1 : 0, ((($page - 1) * $this->config->get('config_admin_limit')) > ($audio_total - $this->config->get('config_admin_limit'))) ? $audio_total : ((($page - 1) * $this->config->get('config_admin_limit')) + $this->config->get('config_admin_limit')), $audio_total, ceil($audio_total / $this->config->get('config_admin_limit')));

		$this->data['filter_name'] = $filter_name;

		$this->data['filter_ishome'] = $filter_ishome;

$this->data['filter_category'] = $filter_category;

/*{FILTER_DATA}*/

		$this->data['filter_status'] = $filter_status;

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'catalog/audio_list.tpl';
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
		
		if (isset($this->error['audio_mp3'])) {
			$this->data['error_audio_mp3'] = $this->error['audio_mp3'];
		} else {
			$this->data['error_audio_mp3'] = '';
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

					if (isset($this->request->get['filter_ishome'])) {
				$url .= '&filter_ishome=' . $this->request->get['filter_ishome'];
			}
            
            			if (isset($this->request->get['filter_category'])) {
				$url .= '&filter_category=' . $this->request->get['filter_category'];
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
		                                     'href'      => $this->url->link('catalog/audio', 'token=' . $this->session->data['token'] . $url, '', 'SSL'),
		                                     'separator' => ' :: '
		                                     );

		//====================================================Assigne Data=======================================================
		if (!isset($this->request->get['audio_id'])) {
			$this->data['action'] = $this->url->link('catalog/audio/insert', 'token=' . $this->session->data['token'] . $url, '', 'SSL');
		} else {
			$this->data['action'] = $this->url->link('catalog/audio/update', 'token=' . $this->session->data['token'] . '&audio_id=' . $this->request->get['audio_id'] . $url, '', 'SSL');
		}

		$this->data['cancel'] = $this->url->link('catalog/audio', 'token=' . $this->session->data['token'] . $url, '', 'SSL');

		$this->data['token'] = $this->session->data['token'];

		//cate danh sach con
		 if(isset($this->request->get['cate']) && $this->request->get['cate']>0){
		 	$sublist_cate = $this->model_catalog_audio->getCateById($this->request->get['cate']);
		 	$this->data['sublist_cate'] = $sublist_cate;
		 }else{
		 	$this->data['sublist_cate'] = 0;
		 }


		if (isset($this->request->get['audio_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$audio_info = $this->model_catalog_audio->getAudio($this->request->get['audio_id']);
		}

		$this->load->model('localisation/language');

		$this->data['languages'] = $this->model_localisation_language->getLanguages();
		$this->load->model('tool/image');
		        if (isset($this->request->post['image'])) {
            $this->data['image'] = $this->request->post['image'];
        } elseif (isset($audio_info)) {
            $this->data['image'] = $audio_info['image'];
        } else {
            $this->data['image'] = '';
        }

		if (isset($audio_info) && $audio_info['image'] && file_exists(DIR_IMAGE . $audio_info['image'])) {
			$this->data['preview'] = $this->model_tool_image->resize($audio_info['image'], 100, 100);
		} elseif(isset($this->request->post['image']) && !empty($this->request->post['image']) && file_exists(DIR_IMAGE . $this->request->post['image'])) {
			$this->data['preview'] = $this->model_tool_image->resize($this->request->post['image'], 100, 100);
		}else{
			$this->data['preview'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}
        
                if (isset($this->request->post['image1'])) {
            $this->data['image1'] = $this->request->post['image1'];
        } elseif (isset($audio_info)) {
            $this->data['image1'] = $audio_info['image1'];
        } else {
            $this->data['image1'] = '';
        }

		if (isset($audio_info) && $audio_info['image1'] && file_exists(DIR_IMAGE . $audio_info['image1'])) {
			$this->data['preview1'] = $this->model_tool_image->resize($audio_info['image1'], 100, 100);
		} elseif(isset($this->request->post['image1']) && !empty($this->request->post['image1']) && file_exists(DIR_IMAGE . $this->request->post['image1'])) {
			$this->data['preview1'] = $this->model_tool_image->resize($this->request->post['image1'], 100, 100);
		}else{
			$this->data['preview1'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}
        
        		if (isset($this->request->post['ishome'])) {
			$this->data['ishome'] = $this->request->post['ishome'];
		} elseif (isset($audio_info)) {
			$this->data['ishome'] = $audio_info['ishome'];
		} else {
			$this->data['ishome'] = '';
		}
        
        
        $this->load->model('tool/image');
        if (isset($this->request->post['image_og'])) {
            $this->data['image_og'] = $this->request->post['image_og'];
        } elseif (isset($audio_info)) {
            $this->data['image_og'] = $audio_info['image_og'];
        } else {
            $this->data['image_og'] = '';
        }

				if (isset($audio_info) && $audio_info['image_og'] && file_exists(DIR_IMAGE . $audio_info['image_og'])) {
					$this->data['preview_og'] = $this->model_tool_image->resize($audio_info['image_og'], 100, 100);
				} elseif(isset($this->request->post['image_og']) && !empty($this->request->post['image_og']) && file_exists(DIR_IMAGE . $this->request->post['image_og'])) {
					$this->data['preview_og'] = $this->model_tool_image->resize($this->request->post['image_og'], 100, 100);
				}else{
					$this->data['preview_og'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
				}

		        if (isset($this->request->post['keyword'])) {
					$this->data['keyword'] = $this->request->post['keyword'];
				} elseif (isset($audio_info)) {
					$this->data['keyword'] = $audio_info['keyword'];
				} else {
					$this->data['keyword'] = '';
				}

        $this->load->model('catalog/category');			
		$this->data['categories'] = $this->model_catalog_category->getCategories(232);
		
		if (isset($this->request->post['category_id'])) {
			$this->data['category_id'] = $this->request->post['category_id'];
		} elseif (isset($audio_info)) {
			$this->data['category_id'] = $audio_info['category_id'];
		} else {
			$this->data['category_id'] = 0;
		}
		
		if (isset($audio_info['filename_mp3'])) {
    		$this->data['filename_mp3'] = $audio_info['filename_mp3'];
		} else {
			$this->data['filename_mp3'] = '';
		}
        
        
        /*{IMAGE_FORM}*/

		if (isset($this->request->post['sort_order'])) {
			$this->data['sort_order'] = $this->request->post['sort_order'];
		} elseif (isset($audio_info)) {
			$this->data['sort_order'] = $audio_info['sort_order'];
		} else {
			$this->data['sort_order'] = 0;
		}

		if (isset($this->request->post['status'])) {
			$this->data['status'] = $this->request->post['status'];
		} else if (isset($audio_info)) {
			$this->data['status'] = $audio_info['status'];
		} else {
			$this->data['status'] = 1;
		}

		//tab data
		if (isset($this->request->post['audio_description'])) {
			$this->data['audio_description'] = $this->request->post['audio_description'];
		} elseif (isset($audio_info)) {
			$this->data['audio_description'] = $this->model_catalog_audio->getAudioDescriptions($this->request->get['audio_id']);
		} else {
			$this->data['audio_description'] = array();
		}


		$this->template = 'catalog/audio_form.tpl';
		$this->children = array(
		                        'common/header',
		                        'common/footer',
		                        );

		$this->response->setOutput($this->render());
	}

	private function validateForm() {

		if (!$this->user->hasPermission('modify', 'catalog/audio')) {
			$this->error['warning'] = $this->data['error_permission'];
		}

		//chi validate ngon ngu mac dinh (khi lay du lieu kiem tra neu title khac rong moi hien thi)
		if((strlen(utf8_decode($this->request->post['audio_description'][$this->config->get('config_language_id')]['name'])) < 1) || (strlen(utf8_decode($this->request->post['audio_description'][$this->config->get('config_language_id')]['name'])) > 255))
			$this->error['name'][$this->config->get('config_language_id')] = $this->data['error_name'];

		foreach ($this->request->post['audio_description'] as $language_id => $value) {
						if(!empty($this->request->files['audio_description']['name'][$language_id]['pdf'])
				&& ($this->request->files['audio_description']['error'][$language_id]['pdf']!=0 
				|| (strtolower(strrchr($this->request->files['audio_description']['name'][$language_id]['pdf'], '.'))!='.mp3' 
				//&& strtolower(strrchr($this->request->files['audio_description']['name'][$language_id]['pdf'], '.'))!='.doc'
				)))
			{
				
				$this->error['pdf'][$language_id] = $this->data['error_pdf_no_support'];
			}
			
		/*{VALIDATE_PDF}*/
		}
		
		if ($this->request->files['audio_mp3']['name']) { 	
			
			if (substr(strrchr($this->request->files['audio_mp3']['name'], '.'), 1) != 'mp3') {
				$this->error['audio_mp3'] = 'Chỉ hỗ trợ file mp3!';
			}

			if($this->request->files['audio_mp3']['size']>1000000000)
			{
				$this->error['audio_mp3'] = 'Kích thước file quá lớn!';
			}
		}else if(empty($this->request->post['audio_mp3_old'])){
			$this->error['audio_mp3'] = 'Vui lòng chọn file!';
		}

		/*if(empty($this->request->post['image']))
			$this->error['image'] = $this->data['error_image'];
		*/	
					if($this->request->post['category_id']==0)
				$this->error['category_id'] = $this->data['error_category'];
			
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
		if (!$this->user->hasPermission('modify', 'catalog/audio')) {
			$this->error['warning'] = $this->data['error_permission'];
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	private function validateCopy() {
		if (!$this->user->hasPermission('modify', 'catalog/audio')) {
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
			$this->load->model('catalog/audio');

			$data = array(
			              'filter_name' => $this->request->post['filter_name'],
			              'start'       => 0,
			              'limit'       => 20
			              );

			$results = $this->model_catalog_audio->getAudios($data);

			foreach ($results as $result) {
				$json[] = array(
				                'audio_id' => $result['audio_id'],
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
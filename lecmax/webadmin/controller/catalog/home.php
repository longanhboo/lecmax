<?php
class ControllerCatalogHome extends Controller {
	private $error = array();

	public function __construct($registry) {
		$this->registry = $registry;

		$this->load->model('catalog/lang');

		$langs = $this->model_catalog_lang->getLangByModule('home',2);
		foreach($langs as $lang){
			$this->data[$lang['key']] = html_entity_decode($lang['name']);
		}

		/*{$CHANGE_TITLE}*/
	}

	public function index() {
		$this->document->setTitle($this->data['heading_title']);

		$this->load->model('catalog/home');

		$this->getList();
	}

	public function insert() {

		$this->document->setTitle($this->data['heading_title']);

		$this->load->model('catalog/home');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$data = $this->request->post;
			
			if (is_uploaded_file($this->request->files['video_mp4']['tmp_name'])) {
				
				$ext = strrchr($this->request->files['video_mp4']['name'], '.');
				
				$name = substr($this->request->files['video_mp4']['name'],0, (strlen($this->request->files['video_mp4']['name']) - strlen($ext)));
				
				$filename = $name . '.' . md5(rand()) . $ext;
				
				move_uploaded_file($this->request->files['video_mp4']['tmp_name'], DIR_DOWNLOAD . $filename);

				if (file_exists(DIR_DOWNLOAD . $filename)) {
					$data['video_mp4'] = $filename;
				}
			}			
			
			if (is_uploaded_file($this->request->files['video_webm']['tmp_name'])) {
				
				$ext = strrchr($this->request->files['video_webm']['name'], '.');
				
				$name = substr($this->request->files['video_webm']['name'],0, (strlen($this->request->files['video_webm']['name']) - strlen($ext)));
				
				$filename = $name . '.' . md5(rand()) . $ext;
				
				move_uploaded_file($this->request->files['video_webm']['tmp_name'], DIR_DOWNLOAD . $filename);

				if (file_exists(DIR_DOWNLOAD . $filename)) {
					$data['video_webm'] = $filename;
				}
			}

			/*{INSERT_CONTROLLER}*/

			$this->model_catalog_home->addHome($data);
			
			$this->load->model('tool/image');
			if (isset($this->request->post['home_image'])) {
				foreach ($this->request->post['home_image'] as $image) {
					if (file_exists(DIR_IMAGE . $image['image']) && is_file(DIR_IMAGE . $image['image'])) {
					list($widthImg, $heightImg) = getimagesize(DIR_IMAGE.$image['image']);
					$this->model_tool_image->resize_mobile($image['image'], $widthImg*2/3, $heightImg*2/3);
					}
					if (file_exists(DIR_IMAGE . $image['image1']) && is_file(DIR_IMAGE . $image['image1'])) {
					list($widthImg, $heightImg) = getimagesize(DIR_IMAGE.$image['image1']);
					$this->model_tool_image->resize_mobile($image['image1'], $widthImg*2/3, $heightImg*2/3);
					}
				}
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

			$this->redirect($this->url->link('catalog/home', 'token=' . $this->session->data['token'] . $url, '', 'SSL'));
			
			exit;
		}

		$this->getForm();
	}

	public function update() {

		$this->document->setTitle($this->data['heading_title']);

		$this->load->model('catalog/home');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$data = $this->request->post;
			
			$filename_old = $this->model_catalog_home->getVideoById($this->request->get['home_id']) ;
			if (is_uploaded_file($this->request->files['video_mp4']['tmp_name'])) {				

				if (!empty($filename_old['filename_mp4']) && file_exists(DIR_DOWNLOAD . $filename_old['filename_mp4'])) {
					@unlink(DIR_DOWNLOAD . $filename_old['filename_mp4']);
				}
				
				$ext = strrchr($this->request->files['video_mp4']['name'], '.');
				
				$name = substr($this->request->files['video_mp4']['name'],0, (strlen($this->request->files['video_mp4']['name']) - strlen($ext)));
				
				$filename = $name . '.' . md5(rand()) . $ext;
				
				move_uploaded_file($this->request->files['video_mp4']['tmp_name'], DIR_DOWNLOAD . $filename);

				if (file_exists(DIR_DOWNLOAD . $filename)) {
					$data['video_mp4'] = $filename;
				}
			}
			
			if (is_uploaded_file($this->request->files['video_webm']['tmp_name'])) {								

				if (!empty($filename_old['video_webm']) && file_exists(DIR_DOWNLOAD . $filename_old['video_webm'])) {
					@unlink(DIR_DOWNLOAD . $filename_old['video_webm']);
				}
				
				$ext = strrchr($this->request->files['video_webm']['name'], '.');
				
				$name = substr($this->request->files['video_webm']['name'],0, (strlen($this->request->files['video_webm']['name']) - strlen($ext)));
				
				$filename = $name . '.' . md5(rand()) . $ext;
				
				move_uploaded_file($this->request->files['video_webm']['tmp_name'], DIR_DOWNLOAD . $filename);

				if (file_exists(DIR_DOWNLOAD . $filename)) {
					$data['video_webm'] = $filename;
				}
			}

			/*{UPDATE_CONTROLLER}*/

			$this->model_catalog_home->editHome($this->request->get['home_id'], $data);
			
			$this->load->model('tool/image');
			if (isset($this->request->post['home_image'])) {
				foreach ($this->request->post['home_image'] as $image) {
					if (file_exists(DIR_IMAGE . $image['image']) && is_file(DIR_IMAGE . $image['image'])) {
					list($widthImg, $heightImg) = getimagesize(DIR_IMAGE.$image['image']);
					$this->model_tool_image->resize_mobile($image['image'], $widthImg*2/3, $heightImg*2/3);
					}
					if (file_exists(DIR_IMAGE . $image['image1']) && is_file(DIR_IMAGE . $image['image1'])) {
					list($widthImg, $heightImg) = getimagesize(DIR_IMAGE.$image['image1']);
					$this->model_tool_image->resize_mobile($image['image1'], $widthImg*2/3, $heightImg*2/3);
					}
				}
			}

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

			$this->redirect($this->url->link('catalog/home', 'token=' . $this->session->data['token'] . $url, '', 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {

		$this->document->setTitle($this->data['heading_title']);

		$this->load->model('catalog/home');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $home_id) {
				
				$filename_old = $this->model_catalog_home->getVideoById($home_id) ;
				if (!empty($filename_old['filename_webm']) && file_exists(DIR_DOWNLOAD . $filename_old['filename_webm'])) {
					@unlink(DIR_DOWNLOAD . $filename_old['filename_webm']);
				}
				
				if (!empty($filename_old['filename_mp4']) && file_exists(DIR_DOWNLOAD . $filename_old['filename_mp4'])) {
					@unlink(DIR_DOWNLOAD . $filename_old['filename_mp4']);
				}

				/*{DELETE_CONTROLLER}*/

				$this->model_catalog_home->deleteHome($home_id);
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

			$this->redirect($this->url->link('catalog/home', 'token=' . $this->session->data['token'] . $url, '', 'SSL'));
		}

		$this->getList();
	}

	public function copy() {

		$this->document->setTitle($this->data['heading_title']);

		$this->load->model('catalog/home');

		if (isset($this->request->post['selected']) && $this->validateCopy()) {
			foreach ($this->request->post['selected'] as $home_id) {
				$this->model_catalog_home->copyHome($home_id);
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

			$this->redirect($this->url->link('catalog/home', 'token=' . $this->session->data['token'] . $url, '', 'SSL'));
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
		                                     'href'      => $this->url->link('catalog/home', 'token=' . $this->session->data['token'] . $url, '', 'SSL'),
		                                     'separator' => ' :: '
		                                     );

		$url_filter = '';
		if (isset($this->request->get['filter_category'])) {
			$url_filter .= '&filter_category=' . $this->request->get['filter_category'];
		}

		$this->data['insert'] = $this->url->link('catalog/home/insert', 'token=' . $this->session->data['token'] . $url, '', 'SSL');
		$this->data['copy'] = $this->url->link('catalog/home/copy', 'token=' . $this->session->data['token'] . $url, '', 'SSL');
		$this->data['delete'] = $this->url->link('catalog/home/delete', 'token=' . $this->session->data['token'] . $url, '', 'SSL');

		$this->data['filter'] = $this->url->link('catalog/home', 'token=' . $this->session->data['token'] . $url_filter, '', 'SSL');
		/*{BACK}*/
		$this->data['homes'] = array();

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
		$home_total = $this->model_catalog_home->getTotalHomes($data);

		$results = $this->model_catalog_home->getHomes($data);

		/*{INCLUDE_CATEGORY}*/

		foreach ($results as $result) {
			$action = array();
			/*{SUBLIST}*/
			$action[] = array(
			                  'cls'  =>'modify',
			                  'text' => $this->data['text_edit'],
			                  'href' => $this->url->link('catalog/home/update', 'token=' . $this->session->data['token'] . '&home_id=' . $result['home_id'] . $url, '', 'SSL')
			                  );
			            if ($result['image'] && file_exists(DIR_IMAGE . $result['image'])) {
                $image = $this->model_tool_image->resize($result['image'], 40, 40);
            } else {
                $image = $this->model_tool_image->resize('no_image.jpg', 40, 40);
            }
			$this->data['homes'][] = array(
			                                                  'home_id' => $result['home_id'],
			                                                  'sort_order'       => $result['sort_order'],
			                                                  'name'       => $result['name'],
			                                                  'image'      => $image,
/*{IMAGE_LIST_ARRAY}*/
			                                                  'status_id'		=> $result['status'],
			                                                  'status'     => ($result['status'] ? '<img src="view/image/success.png" title="'.$this->data['text_enabled'].'" />' : '<img src="view/image/delete.png" title="'.$this->data['text_disabled'].'" />'),
			                                                  'selected'   => isset($this->request->post['selected']) && in_array($result['home_id'], $this->request->post['selected']),
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

		$this->data['sort_name'] = $this->url->link('catalog/home', 'token=' . $this->session->data['token'] . '&sort=pd.name' . $url, '', 'SSL');
		$this->data['sort_status'] = $this->url->link('catalog/home', 'token=' . $this->session->data['token'] . '&sort=p.status' . $url, '', 'SSL');
		$this->data['sort_order'] = $this->url->link('catalog/home', 'token=' . $this->session->data['token'] . '&sort=p.sort_order' . $url, '', 'SSL');

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
		$pagination->total = $home_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->data['text_pagination'];
		$pagination->url = $this->url->link('catalog/home', 'token=' . $this->session->data['token'] . $url . '&page={page}', '', 'SSL');

		$this->data['pagination'] = $pagination->render();

		$this->data['results'] = sprintf($this->language->get('text_pagination'), ($home_total) ? (($page - 1) * $this->config->get('config_admin_limit')) + 1 : 0, ((($page - 1) * $this->config->get('config_admin_limit')) > ($home_total - $this->config->get('config_admin_limit'))) ? $home_total : ((($page - 1) * $this->config->get('config_admin_limit')) + $this->config->get('config_admin_limit')), $home_total, ceil($home_total / $this->config->get('config_admin_limit')));

		$this->data['filter_name'] = $filter_name;

		/*{FILTER_DATA}*/

		$this->data['filter_status'] = $filter_status;

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'catalog/home_list.tpl';
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
        
                if (isset($this->error['home_image'])) {
			$this->data['error_images'] = $this->error['home_image'];
		} else {
			$this->data['error_images'] = '';
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
		                                     'href'      => $this->url->link('catalog/home', 'token=' . $this->session->data['token'] . $url, '', 'SSL'),
		                                     'separator' => ' :: '
		                                     );

		//====================================================Assigne Data=======================================================
		if (!isset($this->request->get['home_id'])) {
			$this->data['action'] = $this->url->link('catalog/home/insert', 'token=' . $this->session->data['token'] . $url, '', 'SSL');
		} else {
			$this->data['action'] = $this->url->link('catalog/home/update', 'token=' . $this->session->data['token'] . '&home_id=' . $this->request->get['home_id'] . $url, '', 'SSL');
		}

		$this->data['cancel'] = $this->url->link('catalog/home', 'token=' . $this->session->data['token'] . $url, '', 'SSL');

		$this->data['token'] = $this->session->data['token'];

		//cate danh sach con
		 if(isset($this->request->get['cate']) && $this->request->get['cate']>0){
		 	$sublist_cate = $this->model_catalog_home->getCateById($this->request->get['cate']);
		 	$this->data['sublist_cate'] = $sublist_cate;
		 }else{
		 	$this->data['sublist_cate'] = 0;
		 }


		if (isset($this->request->get['home_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$home_info = $this->model_catalog_home->getHome($this->request->get['home_id']);
		}

		$this->load->model('localisation/language');

		$this->data['languages'] = $this->model_localisation_language->getLanguages();
		$this->load->model('tool/image');
		        if (isset($this->request->post['image'])) {
            $this->data['image'] = $this->request->post['image'];
        } elseif (isset($home_info)) {
            $this->data['image'] = $home_info['image'];
        } else {
            $this->data['image'] = '';
        }

		if (isset($home_info) && $home_info['image'] && file_exists(DIR_IMAGE . $home_info['image'])) {
			$this->data['preview'] = $this->model_tool_image->resize($home_info['image'], 100, 100);
		} elseif(isset($this->request->post['image']) && !empty($this->request->post['image']) && file_exists(DIR_IMAGE . $this->request->post['image'])) {
			$this->data['preview'] = $this->model_tool_image->resize($this->request->post['image'], 100, 100);
		}else{
			$this->data['preview'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}
		
		if (isset($this->request->post['image1'])) {
            $this->data['image1'] = $this->request->post['image1'];
        } elseif (isset($home_info)) {
            $this->data['image1'] = $home_info['image1'];
        } else {
            $this->data['image1'] = '';
        }

		if (isset($home_info) && $home_info['image1'] && file_exists(DIR_IMAGE . $home_info['image1'])) {
			$this->data['preview1'] = $this->model_tool_image->resize($home_info['image1'], 100, 100);
		} elseif(isset($this->request->post['image1']) && !empty($this->request->post['image1']) && file_exists(DIR_IMAGE . $this->request->post['image1'])) {
			$this->data['preview1'] = $this->model_tool_image->resize($this->request->post['image1'], 100, 100);
		}else{
			$this->data['preview1'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}
		
		if (isset($this->request->post['imagetienich'])) {
            $this->data['imagetienich'] = $this->request->post['imagetienich'];
        } elseif (isset($home_info)) {
            $this->data['imagetienich'] = $home_info['imagetienich'];
        } else {
            $this->data['imagetienich'] = '';
        }

		if (isset($home_info) && $home_info['imagetienich'] && file_exists(DIR_IMAGE . $home_info['imagetienich'])) {
			$this->data['previewtienich'] = $this->model_tool_image->resize($home_info['imagetienich'], 100, 100);
		} elseif(isset($this->request->post['imagetienich']) && !empty($this->request->post['imagetienich']) && file_exists(DIR_IMAGE . $this->request->post['imagetienich'])) {
			$this->data['previewtienich'] = $this->model_tool_image->resize($this->request->post['imagetienich'], 100, 100);
		}else{
			$this->data['previewtienich'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}
		
		if (isset($this->request->post['imagechudautu'])) {
            $this->data['imagechudautu'] = $this->request->post['imagechudautu'];
        } elseif (isset($home_info)) {
            $this->data['imagechudautu'] = $home_info['imagechudautu'];
        } else {
            $this->data['imagechudautu'] = '';
        }

		if (isset($home_info) && $home_info['imagechudautu'] && file_exists(DIR_IMAGE . $home_info['imagechudautu'])) {
			$this->data['previewchudautu'] = $this->model_tool_image->resize($home_info['imagechudautu'], 100, 100);
		} elseif(isset($this->request->post['imagechudautu']) && !empty($this->request->post['imagechudautu']) && file_exists(DIR_IMAGE . $this->request->post['imagechudautu'])) {
			$this->data['previewchudautu'] = $this->model_tool_image->resize($this->request->post['imagechudautu'], 100, 100);
		}else{
			$this->data['previewchudautu'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}
		
		if (isset($this->request->post['image1chudautu'])) {
            $this->data['image1chudautu'] = $this->request->post['image1chudautu'];
        } elseif (isset($home_info)) {
            $this->data['image1chudautu'] = $home_info['image1chudautu'];
        } else {
            $this->data['image1chudautu'] = '';
        }

		if (isset($home_info) && $home_info['image1chudautu'] && file_exists(DIR_IMAGE . $home_info['image1chudautu'])) {
			$this->data['preview1chudautu'] = $this->model_tool_image->resize($home_info['image1chudautu'], 100, 100);
		} elseif(isset($this->request->post['image1chudautu']) && !empty($this->request->post['image1chudautu']) && file_exists(DIR_IMAGE . $this->request->post['image1chudautu'])) {
			$this->data['preview1chudautu'] = $this->model_tool_image->resize($this->request->post['image1chudautu'], 100, 100);
		}else{
			$this->data['preview1chudautu'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}
		
		//canho
		if (isset($this->request->post['imagecanho'])) {
            $this->data['imagecanho'] = $this->request->post['imagecanho'];
        } elseif (isset($home_info)) {
            $this->data['imagecanho'] = $home_info['imagecanho'];
        } else {
            $this->data['imagecanho'] = '';
        }

		if (isset($home_info) && $home_info['imagecanho'] && file_exists(DIR_IMAGE . $home_info['imagecanho'])) {
			$this->data['previewcanho'] = $this->model_tool_image->resize($home_info['imagecanho'], 100, 100);
		} elseif(isset($this->request->post['imagecanho']) && !empty($this->request->post['imagecanho']) && file_exists(DIR_IMAGE . $this->request->post['imagecanho'])) {
			$this->data['previewcanho'] = $this->model_tool_image->resize($this->request->post['imagecanho'], 100, 100);
		}else{
			$this->data['previewcanho'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}
		
		if (isset($this->request->post['image1canho'])) {
            $this->data['image1canho'] = $this->request->post['image1canho'];
        } elseif (isset($home_info)) {
            $this->data['image1canho'] = $home_info['image1canho'];
        } else {
            $this->data['image1canho'] = '';
        }

		if (isset($home_info) && $home_info['image1canho'] && file_exists(DIR_IMAGE . $home_info['image1canho'])) {
			$this->data['preview1canho'] = $this->model_tool_image->resize($home_info['image1canho'], 100, 100);
		} elseif(isset($this->request->post['image1canho']) && !empty($this->request->post['image1canho']) && file_exists(DIR_IMAGE . $this->request->post['image1canho'])) {
			$this->data['preview1canho'] = $this->model_tool_image->resize($this->request->post['image1canho'], 100, 100);
		}else{
			$this->data['preview1canho'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}
		
		//news
		if (isset($this->request->post['imagenews'])) {
            $this->data['imagenews'] = $this->request->post['imagenews'];
        } elseif (isset($home_info)) {
            $this->data['imagenews'] = $home_info['imagenews'];
        } else {
            $this->data['imagenews'] = '';
        }

		if (isset($home_info) && $home_info['imagenews'] && file_exists(DIR_IMAGE . $home_info['imagenews'])) {
			$this->data['previewnews'] = $this->model_tool_image->resize($home_info['imagenews'], 100, 100);
		} elseif(isset($this->request->post['imagenews']) && !empty($this->request->post['imagenews']) && file_exists(DIR_IMAGE . $this->request->post['imagenews'])) {
			$this->data['previewnews'] = $this->model_tool_image->resize($this->request->post['imagenews'], 100, 100);
		}else{
			$this->data['previewnews'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}
        
        		if (isset($this->request->post['home_image'])) {
			$home_images = $this->request->post['home_image'];
		} elseif (isset($home_info)) {
			$home_images = $this->model_catalog_home->getHomeImages($this->request->get['home_id']);
		} else {
			$home_images = array();
		}
		
		$this->data['home_images'] = array();
		
		foreach ($home_images as $home_image) {
			if ($home_image['image'] && file_exists(DIR_IMAGE . $home_image['image'])) {
				$image = $home_image['image'];
			} else {
				$image = 'no_image.jpg';
			}
			
			if ($home_image['image1'] && file_exists(DIR_IMAGE . $home_image['image1'])) {
				$image1 = $home_image['image1'];
			} else {
				$image1 = 'no_image.jpg';
			}
			
			if ($home_image['image2'] && file_exists(DIR_IMAGE . $home_image['image2'])) {
				$image2 = $home_image['image2'];
			} else {
				$image2 = 'no_image.jpg';
			}
			
			$this->data['home_images'][] = array(
				'image_1'   => $image,
				'image_2'   => $image1,
				'image_3'   => $image2,
				'preview_1' => $this->model_tool_image->resize($image, 100, 100),
				'preview_2' => $this->model_tool_image->resize($image1, 100, 100),
				'preview_3' => $this->model_tool_image->resize($image2, 100, 100),
                'image_name' => $home_image['image_name'],
			    'image_name_en' => $home_image['image_name_en'],
				'image_desc' => $home_image['image_desc'],
			    'image_desc_en' => $home_image['image_desc_en'],
				'image_info' => $home_image['image_info'],
			    'image_info_en' => $home_image['image_info_en'],
				'image_class' => $home_image['image_class'],
				'product_id'   => $home_image['product_id'],
				'image_link' => str_replace('HTTP_CATALOG',HTTP_CATALOG,$home_image['image_link']),
				'image_link_en' => str_replace('HTTP_CATALOG',HTTP_CATALOG,$home_image['image_link_en']),
				'image_sort_order' => $home_image['image_sort_order']
			);
		}
		
		if (isset($this->request->post['home_daidien'])) {
			$home_daidiens = $this->request->post['home_daidien'];
		} elseif (isset($home_info)) {
			$home_daidiens = $this->model_catalog_home->getHomeDaidiens($this->request->get['home_id']);
		} else {
			$home_daidiens = array();
		}
		
		$this->data['home_daidiens'] = array();
		
		foreach ($home_daidiens as $home_daidien) {
			if ($home_daidien['image'] && file_exists(DIR_IMAGE . $home_daidien['image'])) {
				$image = $home_daidien['image'];
			} else {
				$image = 'no_image.jpg';
			}
			
			if ($home_daidien['image1'] && file_exists(DIR_IMAGE . $home_daidien['image1'])) {
				$image1 = $home_daidien['image1'];
			} else {
				$image1 = 'no_image.jpg';
			}
			
			
			
			$this->data['home_daidiens'][] = array(
				'image_1'   => $image,
				'image_2'   => $image1,
				'preview_1' => $this->model_tool_image->resize($image, 100, 100),
				'preview_2' => $this->model_tool_image->resize($image1, 100, 100),
                'image_name' => $home_daidien['image_name'],
			    'image_name_en' => $home_daidien['image_name_en'],
				'image_sort_order' => $home_daidien['image_sort_order']
			);
		}

		$this->data['no_image'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
        
        /*{IMAGE_FORM}*/
		
		if (isset($this->request->post['link_tongthe'])) {
      		$this->data['link_tongthe'] = $this->request->post['link_tongthe'];
    	} elseif (isset($home_info)) {
      		$this->data['link_tongthe'] = str_replace('HTTP_CATALOG',HTTP_CATALOG,$home_info['link_tongthe']);
    	} else {
			$this->data['link_tongthe'] = '';
		}
		
		if (isset($this->request->post['googlemap'])) {
      		$this->data['googlemap'] = $this->request->post['googlemap'];
    	} elseif (isset($home_info)) {
      		$this->data['googlemap'] = str_replace('HTTP_CATALOG',HTTP_CATALOG,$home_info['googlemap']);
    	} else {
			$this->data['googlemap'] = '';
		}
		
		if (isset($this->request->post['image_video'])) {
			$this->data['image_video'] = $this->request->post['image_video'];
		} elseif (isset($home_info)) {
			$this->data['image_video'] = $home_info['image_video'];
		} else {
			$this->data['image_video'] = '';
		}
        
        $this->load->model('tool/image');
		
		if (isset($home_info) && $home_info['image_video'] && file_exists(DIR_IMAGE . $home_info['image_video'])) {
			$this->data['preview_video'] = $this->model_tool_image->resize($home_info['image_video'], 100, 100);
		} elseif(isset($this->request->post['image_video']) && !empty($this->request->post['image_video']) && file_exists(DIR_IMAGE . $this->request->post['image_video'])) {
			$this->data['preview_video'] = $this->model_tool_image->resize($this->request->post['image_video'], 100, 100);
		}else{
			$this->data['preview_video'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}
        
        if (isset($this->request->post['isftp'])) {
      		$this->data['isftp'] = $this->request->post['isftp'];
    	} else if (isset($home_info)) {
			$this->data['isftp'] = $home_info['isftp'];
		} else {
      		$this->data['isftp'] = 0;
    	}
		
		if (isset($this->request->post['file_mp4_ftp'])) {
      		$this->data['file_mp4_ftp'] = $this->request->post['file_mp4_ftp'];
    	}else if (isset($home_info['filename_mp4'])) {
    		$this->data['file_mp4_ftp'] = $home_info['filename_mp4'];
		} else {
			$this->data['file_mp4_ftp'] = '';
		}
		
		if (isset($this->request->post['file_webm_ftp'])) {
      		$this->data['file_webm_ftp'] = $this->request->post['file_webm_ftp'];
    	}else if (isset($home_info['filename_webm'])) {
    		$this->data['file_webm_ftp'] = $home_info['filename_webm'];
		} else {
			$this->data['file_webm_ftp'] = '';
		}
		
		if (isset($home_info['filename_webm'])) {
    		$this->data['filename_webm'] = $home_info['filename_webm'];
		} else {
			$this->data['filename_webm'] = '';
		}
		
		if (isset($home_info['filename_mp4'])) {
    		$this->data['filename_mp4'] = $home_info['filename_mp4'];
		} else {
			$this->data['filename_mp4'] = '';
		}
        
        if (isset($this->request->post['script'])) {
      		$this->data['script'] = $this->request->post['script'];
    	} elseif (isset($home_info)) {
      		$this->data['script'] = $home_info['script'];
    	} else {
			$this->data['script'] = '';
		}
		
		if (isset($this->request->post['isyoutube'])) {
      		$this->data['isyoutube'] = $this->request->post['isyoutube'];
    	} elseif (isset($home_info)) {
      		$this->data['isyoutube'] = $home_info['isyoutube'];
    	} else {
			$this->data['isyoutube'] = 0;
		}
		
		if (isset($this->request->post['config_loop_picture'])) {
      		$this->data['config_loop_picture'] = $this->request->post['config_loop_picture'];
    	} elseif (isset($home_info)) {
      		$this->data['config_loop_picture'] = $home_info['config_loop_picture'];
    	} else {
			$this->data['config_loop_picture'] = 5;
		}

		if (isset($this->request->post['sort_order'])) {
			$this->data['sort_order'] = $this->request->post['sort_order'];
		} elseif (isset($home_info)) {
			$this->data['sort_order'] = $home_info['sort_order'];
		} else {
			$this->data['sort_order'] = 0;
		}

		if (isset($this->request->post['status'])) {
			$this->data['status'] = $this->request->post['status'];
		} else if (isset($home_info)) {
			$this->data['status'] = $home_info['status'];
		} else {
			$this->data['status'] = 1;
		}
		
		if (isset($this->request->post['isshareholder'])) {
			$this->data['isshareholder'] = $this->request->post['isshareholder'];
		} else if (isset($home_info)) {
			$this->data['isshareholder'] = $home_info['isshareholder'];
		} else {
			$this->data['isshareholder'] = 0;
		}
		
		//$this->load->model('catalog/product');			
		$this->data['products'] = array();//$this->model_catalog_product->getProducts(array('sort' => 'p.sort_order', 'order' => 'ASC'));
		

		//tab data
		if (isset($this->request->post['home_description'])) {
			$this->data['home_description'] = $this->request->post['home_description'];
		} elseif (isset($home_info)) {
			$this->data['home_description'] = $this->model_catalog_home->getHomeDescriptions($this->request->get['home_id']);
		} else {
			$this->data['home_description'] = array();
		}


		$this->template = 'catalog/home_form.tpl';
		$this->children = array(
		                        'common/header',
		                        'common/footer',
		                        );

		$this->response->setOutput($this->render());
	}

	private function validateForm() {

		if (!$this->user->hasPermission('modify', 'catalog/home')) {
			$this->error['warning'] = $this->data['error_permission'];
		}

		//chi validate ngon ngu mac dinh (khi lay du lieu kiem tra neu title khac rong moi hien thi)
		if((strlen(utf8_decode($this->request->post['home_description'][$this->config->get('config_language_id')]['name'])) < 1) || (strlen(utf8_decode($this->request->post['home_description'][$this->config->get('config_language_id')]['name'])) > 255))
			$this->error['name'][$this->config->get('config_language_id')] = $this->data['error_name'];

		foreach ($this->request->post['home_description'] as $language_id => $value) {
			/*{VALIDATE_PDF}*/
		}
		
		if(((strlen(utf8_decode($this->request->post['config_loop_picture'])) < 1) || (strlen(utf8_decode($this->request->post['config_loop_picture'])) > 2)) || (int)$this->request->post['config_loop_picture']>10)
			$this->error['loop_picture'] = $this->data['help_loop_picture'];		
		

		/*if(empty($this->request->post['image']))
			$this->error['image'] = $this->data['error_image'];
		*/
		/*if(empty($this->request->post['image1']))
			$this->error['image1'] = $this->data['error_image'];
		*/	
		/*if(!isset($this->request->post['home_image']))
		$this->error['home_image'] = $this->data['error_list_image'];
		*/
		if(isset($this->request->post['isftp']) && $this->request->post['isftp']>0){
			/*if(empty($this->request->post['file_mp4_ftp'])){
				$this->error['file_mp4_ftp'] = $this->data['error_file_mp4_ftp'];
			}*/
			
			/*if(empty($this->request->post['file_webm_ftp'])){
				$this->error['file_webm_ftp'] = $this->data['error_file_webm_ftp'];
			}*/
		}else{
			if ($this->request->files['video_mp4']['name']) { 	
			
				if (substr(strrchr($this->request->files['video_mp4']['name'], '.'), 1) != 'mp4') {
					$this->error['video_mp4'] = $this->data['error_no_support'];
				}
	
				if($this->request->files['video_mp4']['size']>100000000)
				{
					$this->error['video_mp4'] = $this->data['error_big_file'];
				}
			}/*else if(empty($this->request->post['video_mp4_old'])){
				$this->error['video_mp4'] = 'Vui lòng chọn file!';
			}*/
			
			
			/*if ($this->request->files['video_webm']['name']) { 	
				
				if (substr(strrchr($this->request->files['video_webm']['name'], '.'), 1) != 'webm') {
					$this->error['video_webm'] = $this->data['error_no_support'];
				}
	
				if($this->request->files['video_webm']['size']>100000000)
				{
					$this->error['video_webm'] = $this->data['error_big_file'];
				}
			}*//*else if(empty($this->request->post['video_mp4_old'])){
				$this->error['video_webm'] = 'Vui lòng chọn file!';
			}*/
		
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
		if (!$this->user->hasPermission('modify', 'catalog/home')) {
			$this->error['warning'] = $this->data['error_permission'];
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	private function validateCopy() {
		if (!$this->user->hasPermission('modify', 'catalog/home')) {
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
			$this->load->model('catalog/home');

			$data = array(
			              'filter_name' => $this->request->post['filter_name'],
			              'start'       => 0,
			              'limit'       => 20
			              );

			$results = $this->model_catalog_home->getHomes($data);

			foreach ($results as $result) {
				$json[] = array(
				                'home_id' => $result['home_id'],
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
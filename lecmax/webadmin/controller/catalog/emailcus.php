<?php
class ControllerCatalogEmailcus extends Controller {
	private $error = array();

	public function __construct($registry) {
		$this->registry = $registry;

		$this->load->model('catalog/lang');

		$langs = $this->model_catalog_lang->getLangByModule('emailcus',2);
		foreach($langs as $lang){
			$this->data[$lang['key']] = html_entity_decode($lang['name']);
		}

		/*{$CHANGE_TITLE}*/
	}

	public function index() {
		$this->document->setTitle($this->data['heading_title']);

		$this->load->model('catalog/emailcus');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
			
			$data = $this->request->post;
			if(isset($data['config_dangkynhantin'])){
				$this->db->query("UPDATE " . DB_PREFIX . "setting 
					SET `value` = '" . (int)($data['config_dangkynhantin']) . "'
					WHERE `key` = 'config_dangkynhantin'");
			}
			
			$this->session->data['success'] = 'Lưu thành công!';
    	}

		$this->getList();
	}

	public function insert() {

		$this->document->setTitle($this->data['heading_title']);

		$this->load->model('catalog/emailcus');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$data = $this->request->post;

			/*{INSERT_CONTROLLER}*/

			$this->model_catalog_emailcus->addEmailcus($data);

			$this->session->data['success'] = $this->data['text_success'];

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . $this->request->get['filter_name'];
			}
			
			if (isset($this->request->get['filter_address'])) {
				$url .= '&filter_address=' . $this->request->get['filter_address'];
			}
			if (isset($this->request->get['filter_company'])) {
				$url .= '&filter_company=' . $this->request->get['filter_company'];
			}
			
			if (isset($this->request->get['filter_cmnd'])) {
				$url .= '&filter_cmnd=' . $this->request->get['filter_cmnd'];
			}
			
			if (isset($this->request->get['filter_email'])) {
				$url .= '&filter_email=' . $this->request->get['filter_email'];
			}
			if (isset($this->request->get['filter_phone'])) {
				$url .= '&filter_phone=' . $this->request->get['filter_phone'];
			}
			if (isset($this->request->get['filter_date_end'])) {
				$url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
			}
			if (isset($this->request->get['filter_date_start'])) {
				$url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
			}
			
			if (isset($this->request->get['filter_is_mail'])) {
				$url .= '&filter_is_mail=' . $this->request->get['filter_is_mail'];
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

			$this->redirect($this->url->link('catalog/emailcus', 'token=' . $this->session->data['token'] . $url, '', 'SSL'));
			
			exit;
		}

		$this->getForm();
	}

	public function update() {

		$this->document->setTitle($this->data['heading_title']);

		$this->load->model('catalog/emailcus');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$data = $this->request->post;

			/*{UPDATE_CONTROLLER}*/

			$this->model_catalog_emailcus->editEmailcus($this->request->get['emailcus_id'], $data);

			$this->session->data['success'] = $this->data['text_success_update'];

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . $this->request->get['filter_name'];
			}
			
			if (isset($this->request->get['filter_address'])) {
				$url .= '&filter_address=' . $this->request->get['filter_address'];
			}
			if (isset($this->request->get['filter_company'])) {
				$url .= '&filter_company=' . $this->request->get['filter_company'];
			}
			if (isset($this->request->get['filter_cmnd'])) {
				$url .= '&filter_cmnd=' . $this->request->get['filter_cmnd'];
			}
			
			if (isset($this->request->get['filter_email'])) {
				$url .= '&filter_email=' . $this->request->get['filter_email'];
			}
			if (isset($this->request->get['filter_phone'])) {
				$url .= '&filter_phone=' . $this->request->get['filter_phone'];
			}
			if (isset($this->request->get['filter_date_end'])) {
				$url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
			}
			if (isset($this->request->get['filter_date_start'])) {
				$url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
			}
			
			if (isset($this->request->get['filter_is_mail'])) {
				$url .= '&filter_is_mail=' . $this->request->get['filter_is_mail'];
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

			$this->redirect($this->url->link('catalog/emailcus', 'token=' . $this->session->data['token'] . $url, '', 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {

		$this->document->setTitle($this->data['heading_title']);

		$this->load->model('catalog/emailcus');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $emailcus_id) {

				/*{DELETE_CONTROLLER}*/

				$this->model_catalog_emailcus->deleteEmailcus($emailcus_id);
			}

			$this->session->data['success'] = $this->data['text_success_delete'];

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . $this->request->get['filter_name'];
			}
			
			if (isset($this->request->get['filter_address'])) {
				$url .= '&filter_address=' . $this->request->get['filter_address'];
			}
			
			if (isset($this->request->get['filter_city'])) {
				$url .= '&filter_city=' . $this->request->get['filter_city'];
			}
			
			if (isset($this->request->get['filter_district'])) {
				$url .= '&filter_district=' . $this->request->get['filter_district'];
			}
			
			if (isset($this->request->get['filter_company'])) {
				$url .= '&filter_company=' . $this->request->get['filter_company'];
			}
			if (isset($this->request->get['filter_cmnd'])) {
				$url .= '&filter_cmnd=' . $this->request->get['filter_cmnd'];
			}
			if (isset($this->request->get['filter_comment'])) {
				$url .= '&filter_comment=' . $this->request->get['filter_comment'];
			}
			
			if (isset($this->request->get['filter_email'])) {
				$url .= '&filter_email=' . $this->request->get['filter_email'];
			}
			if (isset($this->request->get['filter_phone'])) {
				$url .= '&filter_phone=' . $this->request->get['filter_phone'];
			}
			if (isset($this->request->get['filter_date_end'])) {
				$url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
			}
			if (isset($this->request->get['filter_date_start'])) {
				$url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
			}
			
			if (isset($this->request->get['filter_is_mail'])) {
				$url .= '&filter_is_mail=' . $this->request->get['filter_is_mail'];
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

			$this->redirect($this->url->link('catalog/emailcus', 'token=' . $this->session->data['token'] . $url, '', 'SSL'));
		}

		$this->getList();
	}

	public function copy() {

		$this->document->setTitle($this->data['heading_title']);

		$this->load->model('catalog/emailcus');

		if (isset($this->request->post['selected']) && $this->validateCopy()) {
			foreach ($this->request->post['selected'] as $emailcus_id) {
				$this->model_catalog_emailcus->copyEmailcus($emailcus_id);
			}

			$this->session->data['success'] = $this->data['text_success'];

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . $this->request->get['filter_name'];
			}
			
			if (isset($this->request->get['filter_address'])) {
				$url .= '&filter_address=' . $this->request->get['filter_address'];
			}
			if (isset($this->request->get['filter_company'])) {
				$url .= '&filter_company=' . $this->request->get['filter_company'];
			}
			if (isset($this->request->get['filter_cmnd'])) {
				$url .= '&filter_cmnd=' . $this->request->get['filter_cmnd'];
			}
			
			if (isset($this->request->get['filter_email'])) {
				$url .= '&filter_email=' . $this->request->get['filter_email'];
			}
			if (isset($this->request->get['filter_phone'])) {
				$url .= '&filter_phone=' . $this->request->get['filter_phone'];
			}
			if (isset($this->request->get['filter_date_end'])) {
				$url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
			}
			if (isset($this->request->get['filter_date_start'])) {
				$url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
			}
			
			if (isset($this->request->get['filter_is_mail'])) {
				$url .= '&filter_is_mail=' . $this->request->get['filter_is_mail'];
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

			$this->redirect($this->url->link('catalog/emailcus', 'token=' . $this->session->data['token'] . $url, '', 'SSL'));
		}

		$this->getList();
	}

	private function getList() {
		
		if (isset($this->request->post['config_dangkynhantin'])) {
            $this->data['config_dangkynhantin'] = $this->request->post['config_dangkynhantin'];
        } else {
            $this->data['config_dangkynhantin'] = $this->config->get('config_dangkynhantin');
        }
		
		//================================Filter=================================================
		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = null;
		}
		
		if (isset($this->request->get['filter_address'])) {
			$filter_address = $this->request->get['filter_address'];
		} else {
			$filter_address = null;
		}
		
		if (isset($this->request->get['filter_company'])) {
			$filter_company = $this->request->get['filter_company'];
		} else {
			$filter_company = null;
		}
		
		if (isset($this->request->get['filter_cmnd'])) {
			$filter_cmnd = $this->request->get['filter_cmnd'];
		} else {
			$filter_cmnd = null;
		}
		
		if (isset($this->request->get['filter_comment'])) {
			$filter_comment = $this->request->get['filter_comment'];
		} else {
			$filter_comment = null;
		}
		
		if (isset($this->request->get['filter_email'])) {
			$filter_email = $this->request->get['filter_email'];
		} else {
			$filter_email = null;
		}
		
		if (isset($this->request->get['filter_phone'])) {
			$filter_phone = $this->request->get['filter_phone'];
		} else {
			$filter_phone = null;
		}
		
		if (isset($this->request->get['filter_date_start'])) {
			$filter_date_start = $this->request->get['filter_date_start'];
		} else {
			$filter_date_start = null;
		}
		
		if (isset($this->request->get['filter_date_end'])) {
			$filter_date_end = $this->request->get['filter_date_end'];
		} else {
			$filter_date_end = null;
		}
		
		if (isset($this->request->get['filter_is_mail'])) {
			$filter_is_mail = $this->request->get['filter_is_mail'];
		} else {
			$filter_is_mail = null;
		}
		
		if (isset($this->request->get['filter_city'])) {
			$filter_city = $this->request->get['filter_city'];
		} else {
			$filter_city = null;
		}
		
		if (isset($this->request->get['filter_district'])) {
			$filter_district = $this->request->get['filter_district'];
		} else {
			$filter_district = null;
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
		
		if (isset($this->request->get['filter_address'])) {
			$url .= '&filter_address=' . $this->request->get['filter_address'];
		}
		
		if (isset($this->request->get['filter_city'])) {
			$url .= '&filter_city=' . $this->request->get['filter_city'];
		}
		
		if (isset($this->request->get['filter_district'])) {
			$url .= '&filter_district=' . $this->request->get['filter_district'];
		}
		
		if (isset($this->request->get['filter_company'])) {
			$url .= '&filter_company=' . $this->request->get['filter_company'];
		}
		
		if (isset($this->request->get['filter_cmnd'])) {
			$url .= '&filter_cmnd=' . $this->request->get['filter_cmnd'];
		}
		if (isset($this->request->get['filter_comment'])) {
			$url .= '&filter_comment=' . $this->request->get['filter_comment'];
		}
		
		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . $this->request->get['filter_email'];
		}
		
		if (isset($this->request->get['filter_phone'])) {
			$url .= '&filter_phone=' . $this->request->get['filter_phone'];
		}			
		
		if (isset($this->request->get['filter_date_end'])) {
			$url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
		}
		if (isset($this->request->get['filter_date_start'])) {
			$url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
		}
		if (isset($this->request->get['filter_is_mail'])) {
			$url .= '&filter_is_mail=' . $this->request->get['filter_is_mail'];
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
		                                     'href'      => $this->url->link('catalog/emailcus', 'token=' . $this->session->data['token'] . $url, '', 'SSL'),
		                                     'separator' => ' :: '
		                                     );

		$url_filter = '';
		if (isset($this->request->get['filter_category'])) {
			$url_filter .= '&filter_category=' . $this->request->get['filter_category'];
		}

		$this->data['insert'] = $this->url->link('catalog/emailcus/insert', 'token=' . $this->session->data['token'] . $url, '', 'SSL');
		$this->data['copy'] = $this->url->link('catalog/emailcus/copy', 'token=' . $this->session->data['token'] . $url, '', 'SSL');
		$this->data['delete'] = $this->url->link('catalog/emailcus/delete', 'token=' . $this->session->data['token'] . $url, '', 'SSL');

		$this->data['filter'] = $this->url->link('catalog/emailcus', 'token=' . $this->session->data['token'] . $url_filter, '', 'SSL');
		$this->data['export'] = $this->url->link('catalog/emailcus/exportnhantin', 'token=' . $this->session->data['token'] . $url, '', 'SSL');
		/*{BACK}*/
		$this->data['emailcuss'] = array();

		$data = array(
		              'filter_name'	  => $filter_name,
					  'filter_email'	  => $filter_email, 	
					'filter_phone'	  => $filter_phone,
					'filter_company'	  => $filter_company,
					'filter_city'	  => $filter_city,
					'filter_district'	  => $filter_district,
					'filter_cmnd'	  => $filter_cmnd,
					'filter_comment'	  => $filter_comment,
					'filter_address'	  => $filter_address,
					'filter_date_end'	  => $filter_date_end,
					'filter_date_start'	  => $filter_date_start,
					
					'filter_is_mail'   => $filter_is_mail,
		              /*{FILTER_PARAM}*/
		              'filter_status'   => $filter_status,
		              'sort'            => $sort,
		              'order'           => $order,
		              'start'           => ($page - 1) * $this->config->get('config_admin_limit'),
		              'limit'           => $this->config->get('config_admin_limit')
		              );
		/*{INCLUDE_IMAGE_TOOL}*/
		$emailcus_total = $this->model_catalog_emailcus->getTotalEmailcuss($data);

		$results = $this->model_catalog_emailcus->getEmailcuss($data);
		
		$this->load->model('catalog/filepdf');
		
		$this->load->model('catalog/city');
		$this->load->model('catalog/district');
		
		$this->data['citys'] = $this->model_catalog_city->getCitys(array('sort' => 'p.sort_order', 'order' => 'ASC'));
		$this->data['districts'] = array();
		
		if($filter_city){
			$this->data['districts'] = $this->model_catalog_district->getDistrictByCity($filter_city);
			
		}

		/*{INCLUDE_CATEGORY}*/

		foreach ($results as $result) {
			$action = array();
			/*{SUBLIST}*/
			/*$action[] = array(
			                  'cls'  =>'modify',
			                  'text' => $this->data['text_edit'],
			                  'href' => $this->url->link('catalog/emailcus/update', 'token=' . $this->session->data['token'] . '&emailcus_id=' . $result['emailcus_id'] . $url, '', 'SSL')
			                  );*/
			
			/*$action[] = array(
			                  'cls'  =>'btn_list',
			                  'text' => 'Download',
			                  'href' => HTTP_DOWNLOAD . 'recruitment/' . $result['filename']
			                  );*/
			
			
			$catalogue = !empty($result['catalogue'])?unserialize($result['catalogue']):array();
			$stt=1;
			$content = '';
			foreach($catalogue as $item){
				$filepdf = $this->model_catalog_filepdf->getFilepdf($item);
				if(isset($filepdf['name'])){
					$content .= $stt . '). ' . $filepdf['name'] . '<br>';
					$stt++;
				}
			}
			
			$city = $this->model_catalog_city->getCity($result['city']);
			$district = $this->model_catalog_district->getDistrict($result['district']);
			
			/*{IMAGE_LIST}*/
			$this->data['emailcuss'][] = array(
				  'emailcus_id' => $result['emailcus_id'],
				  'sort_order'       => $result['sort_order'],
				  'name'       => $result['name'],
				  'email'       => $result['email'],
				  'canhoquantam'       => $result['canhoquantam'],
				  'giaquantam'       => $result['giaquantam'],
				'phone'       => $result['phone'],
				'cmnd'       => $result['cmnd'],
				'address'       => $result['address'],
				'company'       => $result['company'],
				'district'       => isset($district['name'])?$district['name']:'',
				'city'       => isset($city['name'])?$city['name']:'',
				'is_mail'       => $result['is_mail'],
				'comment'       => $result['is_mail']==1?$content:$result['comment'],
				'date_added'       => date('d-m-Y H:i', strtotime($result['date_added'])),
				  /*{IMAGE_LIST_ARRAY}*/
				  'status_id'		=> $result['status'],
				  'status'     => ($result['status'] ? '<img src="view/image/success.png" title="'.$this->data['text_enabled'].'" />' : '<img src="view/image/delete.png" title="'.$this->data['text_disabled'].'" />'),
				  'selected'   => isset($this->request->post['selected']) && in_array($result['emailcus_id'], $this->request->post['selected']),
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
		
		if (isset($this->request->get['filter_address'])) {
			$url .= '&filter_address=' . $this->request->get['filter_address'];
		}
		
		if (isset($this->request->get['filter_city'])) {
			$url .= '&filter_city=' . $this->request->get['filter_city'];
		}
		
		if (isset($this->request->get['filter_district'])) {
			$url .= '&filter_district=' . $this->request->get['filter_district'];
		}
		
		if (isset($this->request->get['filter_company'])) {
			$url .= '&filter_company=' . $this->request->get['filter_company'];
		}
		if (isset($this->request->get['filter_cmnd'])) {
			$url .= '&filter_cmnd=' . $this->request->get['filter_cmnd'];
		}
		if (isset($this->request->get['filter_comment'])) {
			$url .= '&filter_comment=' . $this->request->get['filter_comment'];
		}
		
		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . $this->request->get['filter_email'];
		}
		if (isset($this->request->get['filter_phone'])) {
			$url .= '&filter_phone=' . $this->request->get['filter_phone'];
		}	
		if (isset($this->request->get['filter_date_end'])) {
			$url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
		}
		if (isset($this->request->get['filter_date_start'])) {
			$url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
		}
		
		
		if (isset($this->request->get['filter_is_mail'])) {
			$url .= '&filter_is_mail=' . $this->request->get['filter_is_mail'];
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

		$this->data['sort_name'] = $this->url->link('catalog/emailcus', 'token=' . $this->session->data['token'] . '&sort=pd.name' . $url, '', 'SSL');
		$this->data['sort_status'] = $this->url->link('catalog/emailcus', 'token=' . $this->session->data['token'] . '&sort=p.status' . $url, '', 'SSL');
		$this->data['sort_order'] = $this->url->link('catalog/emailcus', 'token=' . $this->session->data['token'] . '&sort=p.sort_order' . $url, '', 'SSL');

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}
		
		if (isset($this->request->get['filter_address'])) {
			$url .= '&filter_address=' . $this->request->get['filter_address'];
		}
		
		if (isset($this->request->get['filter_city'])) {
			$url .= '&filter_city=' . $this->request->get['filter_city'];
		}
		
		if (isset($this->request->get['filter_district'])) {
			$url .= '&filter_district=' . $this->request->get['filter_district'];
		}
		
		if (isset($this->request->get['filter_company'])) {
			$url .= '&filter_company=' . $this->request->get['filter_company'];
		}
		if (isset($this->request->get['filter_cmnd'])) {
			$url .= '&filter_cmnd=' . $this->request->get['filter_cmnd'];
		}
		if (isset($this->request->get['filter_comment'])) {
			$url .= '&filter_comment=' . $this->request->get['filter_comment'];
		}
		
		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . $this->request->get['filter_email'];
		}
		if (isset($this->request->get['filter_phone'])) {
			$url .= '&filter_phone=' . $this->request->get['filter_phone'];
		}
		if (isset($this->request->get['filter_date_end'])) {
			$url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
		}
		if (isset($this->request->get['filter_date_start'])) {
			$url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
		}
		
		if (isset($this->request->get['filter_is_mail'])) {
			$url .= '&filter_is_mail=' . $this->request->get['filter_is_mail'];
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
		$pagination->total = $emailcus_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->data['text_pagination'];
		$pagination->url = $this->url->link('catalog/emailcus', 'token=' . $this->session->data['token'] . $url . '&page={page}', '', 'SSL');

		$this->data['pagination'] = $pagination->render();

		$this->data['results'] = sprintf($this->language->get('text_pagination'), ($emailcus_total) ? (($page - 1) * $this->config->get('config_admin_limit')) + 1 : 0, ((($page - 1) * $this->config->get('config_admin_limit')) > ($emailcus_total - $this->config->get('config_admin_limit'))) ? $emailcus_total : ((($page - 1) * $this->config->get('config_admin_limit')) + $this->config->get('config_admin_limit')), $emailcus_total, ceil($emailcus_total / $this->config->get('config_admin_limit')));

		$this->data['filter_name'] = $filter_name;
		
		$this->data['filter_company'] = $filter_company;
		$this->data['filter_address'] = $filter_address;
		$this->data['filter_city'] = $filter_city;
		$this->data['filter_district'] = $filter_district;
		$this->data['filter_cmnd'] = $filter_cmnd;
		$this->data['filter_comment'] = $filter_comment;
		$this->data['filter_phone'] = $filter_phone;
		$this->data['filter_email'] = $filter_email;
		$this->data['filter_date_start'] = $filter_date_start;
		$this->data['filter_date_end'] = $filter_date_end;
		
		$this->data['filter_is_mail'] = $filter_is_mail;
		
		

		/*{FILTER_DATA}*/

		$this->data['filter_status'] = $filter_status;

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'catalog/emailcus_list.tpl';
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
		                                     'href'      => $this->url->link('catalog/emailcus', 'token=' . $this->session->data['token'] . $url, '', 'SSL'),
		                                     'separator' => ' :: '
		                                     );

		//====================================================Assigne Data=======================================================
		if (!isset($this->request->get['emailcus_id'])) {
			$this->data['action'] = $this->url->link('catalog/emailcus/insert', 'token=' . $this->session->data['token'] . $url, '', 'SSL');
		} else {
			$this->data['action'] = $this->url->link('catalog/emailcus/update', 'token=' . $this->session->data['token'] . '&emailcus_id=' . $this->request->get['emailcus_id'] . $url, '', 'SSL');
		}

		$this->data['cancel'] = $this->url->link('catalog/emailcus', 'token=' . $this->session->data['token'] . $url, '', 'SSL');

		$this->data['token'] = $this->session->data['token'];

		//cate danh sach con
		 if(isset($this->request->get['cate']) && $this->request->get['cate']>0){
		 	$sublist_cate = $this->model_catalog_emailcus->getCateById($this->request->get['cate']);
		 	$this->data['sublist_cate'] = $sublist_cate;
		 }else{
		 	$this->data['sublist_cate'] = 0;
		 }


		if (isset($this->request->get['emailcus_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$emailcus_info = $this->model_catalog_emailcus->getEmailcus($this->request->get['emailcus_id']);
		}

		$this->load->model('localisation/language');

		$this->data['languages'] = $this->model_localisation_language->getLanguages();
		/*{INCLUDE_IMAGE_TOOL}*/
		/*{IMAGE_FORM}*/

		if (isset($this->request->post['sort_order'])) {
			$this->data['sort_order'] = $this->request->post['sort_order'];
		} elseif (isset($emailcus_info)) {
			$this->data['sort_order'] = $emailcus_info['sort_order'];
		} else {
			$this->data['sort_order'] = 0;
		}

		if (isset($this->request->post['status'])) {
			$this->data['status'] = $this->request->post['status'];
		} else if (isset($emailcus_info)) {
			$this->data['status'] = $emailcus_info['status'];
		} else {
			$this->data['status'] = 1;
		}

		//tab data
		if (isset($this->request->post['emailcus_description'])) {
			$this->data['emailcus_description'] = $this->request->post['emailcus_description'];
		} elseif (isset($emailcus_info)) {
			$this->data['emailcus_description'] = $this->model_catalog_emailcus->getEmailcusDescriptions($this->request->get['emailcus_id']);
		} else {
			$this->data['emailcus_description'] = array();
		}


		$this->template = 'catalog/emailcus_form.tpl';
		$this->children = array(
		                        'common/header',
		                        'common/footer',
		                        );

		$this->response->setOutput($this->render());
	}

	private function validateForm() {

		if (!$this->user->hasPermission('modify', 'catalog/emailcus')) {
			$this->error['warning'] = $this->data['error_permission'];
		}

		//chi validate ngon ngu mac dinh (khi lay du lieu kiem tra neu title khac rong moi hien thi)
		if((strlen(utf8_decode($this->request->post['emailcus_description'][$this->config->get('config_language_id')]['name'])) < 1) || (strlen(utf8_decode($this->request->post['emailcus_description'][$this->config->get('config_language_id')]['name'])) > 255))
			$this->error['name'][$this->config->get('config_language_id')] = $this->data['error_name'];

		foreach ($this->request->post['emailcus_description'] as $language_id => $value) {
			/*{VALIDATE_PDF}*/
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
		if (!$this->user->hasPermission('modify', 'catalog/emailcus')) {
			$this->error['warning'] = $this->data['error_permission'];
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	private function validateCopy() {
		if (!$this->user->hasPermission('modify', 'catalog/emailcus')) {
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
			$this->load->model('catalog/emailcus');

			$data = array(
			              'filter_name' => $this->request->post['filter_name'],
			              'start'       => 0,
			              'limit'       => 20
			              );

			$results = $this->model_catalog_emailcus->getEmailcuss($data);

			foreach ($results as $result) {
				$json[] = array(
				                'emailcus_id' => $result['emailcus_id'],
				                'name'       => html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'),
				                'model'      => $result['model'],
				                'price'      => $result['price']
				                );
			}
		}

		$this->load->library('json');

		$this->response->setOutput(Json::encode($json));
	}
	
	public function exportnhantin() {
		
		$this->load->model('catalog/city');
		$this->load->model('catalog/district');
		
		date_default_timezone_set("Asia/Bangkok");
		//$filter_is_order = isset($this->request->get['filter_is_order'])?$this->request->get['filter_is_order']:null;
		$filter_is_order = isset($this->request->get['filter_is_mail'])?$this->request->get['filter_is_mail']:null;
		if($filter_is_order==1){
			$filename="BaoCao_Catalogue_".date("dmYhis").".xls";
		}else{
			$filename="BaoCao_LienHe_".date("dmYhis").".xls";
		}
		//$filename="BaoCao_Danh SachKhachHang_".date("dmY").'_'.date("his").".xls";
		$excel = new ExcelWriter(DIR_EXCEL.$filename);
		
		if($excel==false)	
		{
			echo $excel->error;
			die;
		}
		
		
		
		if($filter_is_order==1){
			$socot = 7;
		}elseif($filter_is_order==0 && $filter_is_order!=null){
			$socot = 7;
		}else{
			$socot = 7;
		}
		
		$myArr=array("<img width='150' height='auto' src='".HTTP_CATALOG."/catalog/view/theme/default/images/social-share.png' />", '<br><strong>LECMAX</strong><br><strong>Địa chỉ:</strong> T28, Tòa nhà Ellipse, 110 Trần Phú, Hà Đông<br><strong>Điện Thoại:</strong> 84 24 7301 2678 - 3823 558 <br>');
		if($filter_is_order==1){
			$column = array(3,4);
		}elseif($filter_is_order==0 && $filter_is_order!=null){
			$column = array(3,4);
		}else{
			$column = array(3,4);
		}
		$excel->writeHeaderByNumcol($myArr, $column, array('text-align'=>'center', 'color'=> '#003', 'font-size'=> '14px'));
		
		$excel->writeLine(array(), $socot, array('text-align'=>'right', 'color'=> '#003', 'font-size'=> '14px'));
		
		$myArr=array("Date/Ngày: ".date("d/m/Y") );
		$excel->writeHeader($myArr, $socot, array('text-align'=>'right', 'color'=> '#003', 'font-size'=> '12px'));
		
		$myArr=array("Time/Thời gian: ".date("h:i:s") );
		$excel->writeHeader($myArr, $socot, array('text-align'=>'right', 'color'=> '#003', 'font-size'=> '12px'));
		
		$excel->writeLine(array(), $socot, array('text-align'=>'right', 'color'=> '#003', 'font-size'=> '14px'));
		
		$filter_status = isset($this->request->get['filter_status'])?$this->request->get['filter_status']:null;
		$filter_is_mail = isset($this->request->get['filter_is_mail'])?$this->request->get['filter_is_mail']:null;
		$filter_name = isset($this->request->get['filter_name'])?$this->request->get['filter_name']:null;
		$filter_cmnd = isset($this->request->get['filter_cmnd'])?$this->request->get['filter_cmnd']:null;
		$filter_email = isset($this->request->get['filter_email'])?$this->request->get['filter_email']:null;
		$filter_phone = isset($this->request->get['filter_phone'])?$this->request->get['filter_phone']:null;
		$filter_address = isset($this->request->get['filter_address'])?$this->request->get['filter_address']:null;
		$filter_city = isset($this->request->get['filter_city'])?$this->request->get['filter_city']:null;
		$filter_district = isset($this->request->get['filter_district'])?$this->request->get['filter_district']:null;
		$filter_company = isset($this->request->get['filter_company'])?$this->request->get['filter_company']:null;
		$filter_comment = isset($this->request->get['filter_comment'])?$this->request->get['filter_comment']:null;
		$filter_date_start = isset($this->request->get['filter_date_start'])?$this->request->get['filter_date_start']:null;
		$filter_date_end = isset($this->request->get['filter_date_end'])?$this->request->get['filter_date_end']:null;
		if($filter_is_order==1){
			$myArr=array("<b style='text-transform:uppercase;'>BÁO CÁO DANH SÁCH KHÁCH HÀNG ĐẶT CATALOGUE</b>");
		}elseif($filter_is_order==0 || $filter_is_order==null){
			$myArr=array("<b style='text-transform:uppercase;'>BÁO CÁO DANH SÁCH KHÁCH HÀNG LIÊN HỆ</b>");
		}
		$excel->writeHeader($myArr, $socot, array('text-align'=>'center', 'color'=> '#030', 'font-size'=> '18px'));
		
		if($filter_phone!=null || $filter_name!=null || $filter_city!=null || $filter_district!=null || $filter_email!=null || $filter_date_start!=null || $filter_date_end!=null || $filter_status!=null || $filter_cmnd!=null  || $filter_company!=null || $filter_address!=null || $filter_comment!=null || $filter_is_mail!=null){
			$excel->writeLine(array(), $socot, array('text-align'=>'right', 'color'=> '#003', 'font-size'=> '14px'));
			
			$myArr=array("<b style='text-transform:uppercase;'>Điều Kiện:</b>");
			$excel->writeHeader($myArr, $socot, array('text-align'=>'left', 'color'=> '#030', 'font-size'=> '14px'));
		}
		
		if($filter_name!=null){
			$myArr=array("<b style='text-transform:uppercase;'>Họ Tên:</b>", $filter_name);
			$excel->writeHeader($myArr, array('text-align'=>'left', 'color'=> '#003', 'font-size'=> '14px'));
		}
		
		if($filter_cmnd!=null){
			$myArr=array("<b style='text-transform:uppercase;'>CMND:</b>", $filter_cmnd);
			$excel->writeHeader($myArr, array('text-align'=>'left', 'color'=> '#003', 'font-size'=> '14px'));
		}
		
		if($filter_email!=null){
			$myArr=array("<b style='text-transform:uppercase;'>Email:</b>", $filter_email);
			$excel->writeHeader($myArr, array('text-align'=>'left', 'color'=> '#003', 'font-size'=> '14px'));
		}
		
		if($filter_phone!=null){
			$myArr=array("<b style='text-transform:uppercase;'>Điện Thoại:</b>", $filter_phone);
			$excel->writeHeader($myArr, array('text-align'=>'left', 'color'=> '#003', 'font-size'=> '14px'));
		}
		
		if($filter_address!=null){
			$myArr=array("<b style='text-transform:uppercase;'>Địa Chỉ:</b>", $filter_address);
			$excel->writeHeader($myArr, array('text-align'=>'left', 'color'=> '#003', 'font-size'=> '14px'));
		}
		
		if($filter_city!=null){
			
			$city = $this->model_catalog_city->getCity($filter_city);
			if(isset($city['name'])){
			$myArr=array("<b style='text-transform:uppercase;'>Tỉnh / Thành phố:</b>", $city['name']);
			$excel->writeHeader($myArr, array('text-align'=>'left', 'color'=> '#003', 'font-size'=> '14px'));
			}
		}
		if($filter_district!=null){
			
			$district = $this->model_catalog_district->getDistrict($filter_district);
			if(isset($district['name'])){
			$myArr=array("<b style='text-transform:uppercase;'>Quận / Huyện:</b>", $district['name']);
			$excel->writeHeader($myArr, array('text-align'=>'left', 'color'=> '#003', 'font-size'=> '14px'));
			}
		}
		
		if($filter_company!=null){
			$myArr=array("<b style='text-transform:uppercase;'>Công Ty:</b>", $filter_company);
			$excel->writeHeader($myArr, array('text-align'=>'left', 'color'=> '#003', 'font-size'=> '14px'));
		}
		
		if($filter_comment!=null){
			$myArr=array("<b style='text-transform:uppercase;'>Nội Dung:</b>", $filter_comment);
			$excel->writeHeader($myArr, array('text-align'=>'left', 'color'=> '#003', 'font-size'=> '14px'));
		}
		
		if($filter_date_start!=null && $filter_date_end!=null){
			$myArr=array("<b style='text-transform:uppercase;'>Thời gian Từ:</b> ", $filter_date_start , "<b style='text-transform:uppercase;'> Đến: </b>" , $filter_date_end);
			$excel->writeHeader($myArr, array('text-align'=>'left', 'color'=> '#003', 'font-size'=> '14px'));
		}elseif($filter_date_start!=null){
			$myArr=array("<b style='text-transform:uppercase;'>Thời gian Từ:</b> " , $filter_date_start , "<b style='text-transform:uppercase;'> trở về sau.</b>");
			$excel->writeHeader($myArr, array('text-align'=>'left', 'color'=> '#003', 'font-size'=> '14px'));
		}elseif($filter_date_end!=null){
			$myArr=array("<b style='text-transform:uppercase;'>Thời gian Từ:</b> " , $filter_date_end , "<b style='text-transform:uppercase;'> trở về trước.</b>");
			$excel->writeHeader($myArr, array('text-align'=>'left', 'color'=> '#003', 'font-size'=> '14px'));
		}
		
		if($filter_is_mail!=null){
			$tinhtrang = $filter_is_mail==1?$this->data['text_lien_he']:$this->data['text_dat_cau_hoi'];
			$myArr=array("<b style='text-transform:uppercase;'>Loại Email:</b>", $tinhtrang);
			$excel->writeHeader($myArr, array('text-align'=>'left', 'color'=> '#003', 'font-size'=> '14px'));
		}
		
		if($filter_status!=null){
			$tinhtrang = $filter_status==1?$this->data['text_enabled']:$this->data['text_disabled'];
			$myArr=array("<b style='text-transform:uppercase;'>Tình trạng:</b>", $tinhtrang);
			$excel->writeHeader($myArr, array('text-align'=>'left', 'color'=> '#003', 'font-size'=> '14px'));
		}
		
		
		$excel->writeLine(array(), $socot, array('text-align'=>'right', 'color'=> '#030', 'font-size'=> '14px'));
		if($filter_is_order==1){
		$myArr=array(
					
					"<b>STT</b>",
					"<b>Họ Tên</b>",
					"<b>Email</b>",
					"<b>Điện Thoại</b>",
					//"<b>Công Ty</b>",
					//"<b>Địa Chỉ</b>",
					"<b>File Catalogue</b>",
					"<b>Ngày</b>",
					"<b>Tình trạng</b>"
					);
		}elseif($filter_is_order==0 && $filter_is_order!=null){
		$myArr=array(
					
					"<b>STT</b>",
					"<b>Họ Tên</b>",
					"<b>Email</b>",
					"<b>Điện Thoại</b>",
					//"<b>Công Ty</b>",
					//"<b>Địa Chỉ</b>",
					"<b>Nội Dung</b>",
					"<b>Ngày</b>",
					"<b>Tình trạng</b>"
					);
		}else{
			$myArr=array(
					
					"<b>STT</b>",
					"<b>Họ Tên</b>",
					"<b>Email</b>",
					"<b>Điện Thoại</b>",
					//"<b>Công Ty</b>",
					//"<b>Địa Chỉ</b>",
					"<b>Nội Dung</b>",
					"<b>Ngày</b>",
					"<b>Tình trạng</b>"
					);
		}
		$excel->writeLine($myArr, array('text-align'=>'center', 'color'=> '#030', 'font-size'=> '14px', 'border'=>'#000 solid 1px'));
		
		
		$this->load->model('catalog/emailcus');
		$results = $this->model_catalog_emailcus->getEmailcuss(array('sort' => 'p.sort_order', 'order' => 'ASC', 'filter_status' => $filter_status, 'filter_is_mail' => $filter_is_mail, 'filter_phone' => $filter_phone, 'filter_cmnd' => $filter_cmnd, 'filter_name' => $filter_name, 'filter_email' => $filter_email, 'filter_address' => $filter_address, 'filter_city' => $filter_city, 'filter_district' => $filter_district, 'filter_company' => $filter_company, 'filter_comment' => $filter_comment, 'filter_date_start' => $filter_date_start, 'filter_date_end' => $filter_date_end, 'filter_is_order' => $filter_is_order));
		
		$this->load->model('catalog/filepdf');
		
		$i=1;
		foreach ($results as $result) {
			$excel->writeRow();
			
			$excel->writeCol($i, array('text-align'=>'center', 'color'=> '#003', 'font-size'=> '14px', 'border'=>'#000 solid 1px'));
			$excel->writeCol($result['name'], array('text-align'=>'left', 'color'=> '#003', 'font-size'=> '14px', 'border'=>'#000 solid 1px'));
			
			//$excel->writeCol($result['cmnd'], array('text-align'=>'left', 'color'=> '#003', 'font-size'=> '14px', 'border'=>'#000 solid 1px'));
			
			
			
			
			$excel->writeCol($result['email'], array('text-align'=>'left', 'color'=> '#003', 'font-size'=> '14px', 'border'=>'#000 solid 1px'));
			$excel->writeCol($result['phone'], array('text-align'=>'left', 'color'=> '#003', 'font-size'=> '14px', 'border'=>'#000 solid 1px'));
			//$excel->writeCol($result['company'], array('text-align'=>'left', 'color'=> '#003', 'font-size'=> '14px', 'border'=>'#000 solid 1px'));
			
			/*$str_add = '';
			$district = $this->model_catalog_district->getDistrict($result['district']);
			if(isset($district['name'])){
				$str_add .= ' - ' . $district['name'];
			}
			
			$city = $this->model_catalog_city->getCity($result['city']);
			if(isset($city['name'])){
				$str_add .= ' - ' . $city['name'];
			}
			
			
		
		
		
			$excel->writeCol($result['address'] . $str_add, array('text-align'=>'left', 'color'=> '#003', 'font-size'=> '14px', 'border'=>'#000 solid 1px'));*/
			//$excel->writeCol($result['canhoquantam'], array('text-align'=>'left', 'color'=> '#003', 'font-size'=> '14px', 'border'=>'#000 solid 1px'));
			//$excel->writeCol($result['giaquantam'], array('text-align'=>'left', 'color'=> '#003', 'font-size'=> '14px', 'border'=>'#000 solid 1px'));
			
			if($result['is_mail']==1){
				$catalogue = !empty($result['catalogue'])?unserialize($result['catalogue']):array();
				$stt=1;
				$content = '';
				foreach($catalogue as $item){
					$filepdf = $this->model_catalog_filepdf->getFilepdf($item);
					if(isset($filepdf['name'])){
						$content .= $stt . '). ' . $filepdf['name'] . '<br>';
						$stt++;
					}
				}
				$excel->writeCol($content, array('text-align'=>'left', 'color'=> '#003', 'font-size'=> '14px', 'border'=>'#000 solid 1px'));
			}else{
			
				$excel->writeCol($result['comment'], array('text-align'=>'left', 'color'=> '#003', 'font-size'=> '14px', 'border'=>'#000 solid 1px'));
			}
			//$excel->writeCol(HTTP_DOWNLOAD . 'recruitment/' . $result['filename'], array('text-align'=>'left', 'color'=> '#003', 'font-size'=> '14px', 'border'=>'#000 solid 1px'));
			
			
			
			$excel->writeCol(date('d/m/Y H:i:s', strtotime($result['date_added'])), array('text-align'=>'center', 'color'=> '#003', 'font-size'=> '14px', 'border'=>'#000 solid 1px'));
			if($result['status']==1)
				$status = 'V';
			else
				$status = 'X';
				
			$excel->writeCol($status, array('text-align'=>'center', 'color'=> '#003', 'font-size'=> '14px', 'border'=>'#000 solid 1px'));
			
			$i++;
		}
		
		$excel->close();
		
		$this->redirect(HTTP_EXCEL.$filename);
		
		
	}
}
?>
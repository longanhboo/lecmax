<?php
class ControllerCatalogLogo extends Controller {
	private $error = array();

	public function __construct($registry) {
		$this->registry = $registry;

		$this->load->model('catalog/lang');

		$langs = $this->model_catalog_lang->getLangByModule('logo',2);
		foreach($langs as $lang){
			$this->data[$lang['key']] = html_entity_decode( $lang['name']);
		}
	}

	public function index() {
		$this->document->setTitle($this->data['heading_title']);

		$this->load->model('catalog/logo');

		$this->getForm();
	}

	public function update() {
		$this->document->setTitle($this->data['heading_title']);

		$this->load->model('catalog/logo');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {

			$this->model_catalog_logo->editLogo($this->request->post);

			$this->session->data['success'] = $this->data['text_success_update'];

			$this->redirect($this->url->link('catalog/logo', 'token=' . $this->session->data['token'] , '', 'SSL'));
		}

		$this->getForm();
	}

	private function getForm() {
		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		if (isset($this->error['loop_picture'])) {
			$this->data['error_loop_picture'] = $this->error['loop_picture'];
		} else {
			$this->data['error_loop_picture'] = '';
		}
		
		if (isset($this->error['loop_home_nhamau'])) {
			$this->data['error_loop_home_nhamau'] = $this->error['loop_home_nhamau'];
		} else {
			$this->data['error_loop_home_nhamau'] = '';
		}
		
		if (isset($this->error['loop_about_album'])) {
			$this->data['error_loop_about_album'] = $this->error['loop_about_album'];
		} else {
			$this->data['error_loop_about_album'] = '';
		}
		
		if (isset($this->error['loop_about_video'])) {
			$this->data['error_loop_about_video'] = $this->error['loop_about_video'];
		} else {
			$this->data['error_loop_about_video'] = '';
		}
		
		if (isset($this->error['loop_project_tienich'])) {
			$this->data['error_loop_project_tienich'] = $this->error['loop_project_tienich'];
		} else {
			$this->data['error_loop_project_tienich'] = '';
		}
		if (isset($this->error['loop_project_quymo'])) {
			$this->data['error_loop_project_quymo'] = $this->error['loop_project_quymo'];
		} else {
			$this->data['error_loop_project_quymo'] = '';
		}
		if (isset($this->error['loop_project_tongquan'])) {
			$this->data['error_loop_project_tongquan'] = $this->error['loop_project_tongquan'];
		} else {
			$this->data['error_loop_project_tongquan'] = '';
		}
		
		
		if (isset($this->error['loop_house_model'])) {
			$this->data['error_loop_house_model'] = $this->error['loop_house_model'];
		} else {
			$this->data['error_loop_house_model'] = '';
		}
		
		//
		if (isset($this->error['loop_library_brochure'])) {
			$this->data['error_loop_library_brochure'] = $this->error['loop_library_brochure'];
		} else {
			$this->data['error_loop_library_brochure'] = '';
		}
		if (isset($this->error['loop_library_album'])) {
			$this->data['error_loop_library_album'] = $this->error['loop_library_album'];
		} else {
			$this->data['error_loop_library_album'] = '';
		}
		if (isset($this->error['loop_library_video'])) {
			$this->data['error_loop_library_video'] = $this->error['loop_library_video'];
		} else {
			$this->data['error_loop_library_video'] = '';
		}
		if (isset($this->error['loop_library_phaply'])) {
			$this->data['error_loop_library_phaply'] = $this->error['loop_library_phaply'];
		} else {
			$this->data['error_loop_library_phaply'] = '';
		}
		

		$this->data['heading_title'] = $this->data['heading_title'];

		$this->data['text_image_manager'] = 'Quản lý ảnh';

		if(isset($this->session->data['success'])){
			$this->data['success'] = 'Save hoàn tất!';
			unset($this->session->data['success']);
		}

		/*================================action=====================================*/

		$this->data['action'] = $this->url->link('catalog/logo/update', 'token=' . $this->session->data['token'] , '' , 'SSL');


		$this->data['token'] = $this->session->data['token'];


		$this->load->model('localisation/language');

		$this->data['languages'] = $this->model_localisation_language->getLanguages();
		$this->load->model('tool/image');
		/*================================data=====================================*/

		if (isset($this->request->post['image_logo'])) {
			$this->data['image_logo'] = $this->request->post['image_logo'];
		} else {
			$this->data['image_logo'] = $this->config->get('config_logo');
		}

		if (isset($this->request->post['image_logo_en'])) {
			$this->data['image_logo_en'] = $this->request->post['image_logo_en'];
		} else {
			$this->data['image_logo_en'] = $this->config->get('config_logo_en');
		}
		
		if (isset($this->request->post['image_hotline'])) {
			$this->data['image_hotline'] = $this->request->post['image_hotline'];
		} else {
			$this->data['image_hotline'] = $this->config->get('config_image_hotline');
		}

		if (isset($this->request->post['image_hotline_en'])) {
			$this->data['image_hotline_en'] = $this->request->post['image_hotline_en'];
		} else {
			$this->data['image_hotline_en'] = $this->config->get('config_image_hotline_en');
		}

		if (isset($this->request->post['image_slogan'])) {
			$this->data['image_slogan'] = $this->request->post['image_slogan'];
		} else {
			$this->data['image_slogan'] = $this->config->get('config_image_slogan');
		}

		if (isset($this->request->post['image_slogan_en'])) {
			$this->data['image_slogan_en'] = $this->request->post['image_slogan_en'];
		} else {
			$this->data['image_slogan_en'] = $this->config->get('config_image_slogan_en');
		}

		if (isset($this->request->post['image_popup'])) {
			$this->data['image_popup'] = $this->request->post['image_popup'];
		} else {
			$this->data['image_popup'] = $this->config->get('config_popup');
		}

		if (isset($this->request->post['image_popup_en'])) {
			$this->data['image_popup_en'] = $this->request->post['image_popup_en'];
		} else {
			$this->data['image_popup_en'] = $this->config->get('config_popup_en');
		}

		if (isset($this->request->post['image_delete_logo'])) {
			$this->data['image_delete_logo'] = $this->request->post['image_delete_logo'];
		} else {
			$this->data['image_delete_logo'] = 0;
		}

		if (isset($this->request->post['image_delete_logo_en'])) {
			$this->data['image_delete_logo_en'] = $this->request->post['image_delete_logo_en'];
		} else {
			$this->data['image_delete_logo_en'] = 0;
		}
		
		if (isset($this->request->post['image_delete_hotline'])) {
			$this->data['image_delete_hotline'] = $this->request->post['image_delete_hotline'];
		} else {
			$this->data['image_delete_hotline'] = 0;
		}

		if (isset($this->request->post['image_delete_hotline_en'])) {
			$this->data['image_delete_hotline_en'] = $this->request->post['image_delete_hotline_en'];
		} else {
			$this->data['image_delete_hotline_en'] = 0;
		}

		if (isset($this->request->post['image_delete_slogan'])) {
			$this->data['image_delete_slogan'] = $this->request->post['image_delete_slogan'];
		} else {
			$this->data['image_delete_slogan'] = 0;
		}

		if (isset($this->request->post['image_delete_slogan_en'])) {
			$this->data['image_delete_slogan_en'] = $this->request->post['image_delete_slogan_en'];
		} else {
			$this->data['image_delete_slogan_en'] = 0;
		}

		if (isset($this->request->post['image_delete_popup'])) {
			$this->data['image_delete_popup'] = $this->request->post['image_delete_popup'];
		} else {
			$this->data['image_delete_popup'] = 0;
		}

		if (isset($this->request->post['image_delete_popup_en'])) {
			$this->data['image_delete_popup_en'] = $this->request->post['image_delete_popup_en'];
		} else {
			$this->data['image_delete_popup_en'] = 0;
		}

		// Preview

		if ($this->data['image_logo'] && file_exists(DIR_IMAGE . $this->data['image_logo'])) {
			$this->data['preview_logo'] = $this->model_tool_image->resize($this->data['image_logo'], 100, 100);
		}else{
			$this->data['preview_logo'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}

		if ($this->data['image_logo_en'] && file_exists(DIR_IMAGE . $this->data['image_logo_en'])) {
			$this->data['preview_logo_en'] = $this->model_tool_image->resize($this->data['image_logo_en'], 100, 100);
		}else{
			$this->data['preview_logo_en'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}
		
		// hotline
		if ($this->data['image_hotline'] && file_exists(DIR_IMAGE . $this->data['image_hotline'])) {
			$this->data['preview_hotline'] = $this->model_tool_image->resize($this->data['image_hotline'], 100, 100);
		}else{
			$this->data['preview_hotline'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}

		if ($this->data['image_hotline_en'] && file_exists(DIR_IMAGE . $this->data['image_hotline_en'])) {
			$this->data['preview_hotline_en'] = $this->model_tool_image->resize($this->data['image_hotline_en'], 100, 100);
		}else{
			$this->data['preview_hotline_en'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}

		if ($this->data['image_slogan'] && file_exists(DIR_IMAGE . $this->data['image_slogan'])) {
			$this->data['preview_slogan'] = $this->model_tool_image->resize($this->data['image_slogan'], 100, 100);
		}else{
			$this->data['preview_slogan'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}

		if ($this->data['image_slogan_en'] && file_exists(DIR_IMAGE . $this->data['image_slogan_en'])) {
			$this->data['preview_slogan_en'] = $this->model_tool_image->resize($this->data['image_slogan_en'], 100, 100);
		}else{
			$this->data['preview_slogan_en'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}

		if ($this->data['image_popup'] && file_exists(DIR_IMAGE . $this->data['image_popup'])) {
			$this->data['preview_popup'] = $this->model_tool_image->resize($this->data['image_popup'], 100, 100);
		}else{
			$this->data['preview_popup'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}

		if ($this->data['image_popup_en'] && file_exists(DIR_IMAGE . $this->data['image_popup_en'])) {
			$this->data['preview_popup_en'] = $this->model_tool_image->resize($this->data['image_popup_en'], 100, 100);
		}else{
			$this->data['preview_popup_en'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}

		// Config

		if (isset($this->request->post['config_link_popup'])) {
      		$this->data['config_link_popup'] = $this->request->post['config_link_popup'];
    	} else{
      		$this->data['config_link_popup'] = str_replace('HTTP_CATALOG',HTTP_CATALOG,$this->config->get('config_link_popup'));
    	}
		
		if (isset($this->request->post['config_link_popup_en'])) {
      		$this->data['config_link_popup_en'] = $this->request->post['config_link_popup_en'];
    	} else{
      		$this->data['config_link_popup_en'] = str_replace('HTTP_CATALOG',HTTP_CATALOG,$this->config->get('config_link_popup_en'));
    	}
		
		if (isset($this->request->post['config_link_shareholder'])) {
      		$this->data['config_link_shareholder'] = $this->request->post['config_link_shareholder'];
    	} else{
      		$this->data['config_link_shareholder'] = str_replace('HTTP_CATALOG',HTTP_CATALOG,$this->config->get('config_link_shareholder'));
    	}
		
		if (isset($this->request->post['config_link_realtimetable'])) {
      		$this->data['config_link_realtimetable'] = $this->request->post['config_link_realtimetable'];
    	} else{
      		$this->data['config_link_realtimetable'] = str_replace('HTTP_CATALOG',HTTP_CATALOG,$this->config->get('config_link_realtimetable'));
    	}
		
		if (isset($this->request->post['config_link_360'])) {
      		$this->data['config_link_360'] = $this->request->post['config_link_360'];
    	} else{
      		$this->data['config_link_360'] = str_replace('HTTP_CATALOG',HTTP_CATALOG,$this->config->get('config_link_360'));
    	}

		if (isset($this->request->post['config_slogan'])) {
			$this->data['config_slogan'] = $this->request->post['config_slogan'];
		} else{
			$this->data['config_slogan'] = $this->config->get('config_slogan');
		}

		if (isset($this->request->post['config_slogan_en'])) {
			$this->data['config_slogan_en'] = $this->request->post['config_slogan_en'];
		} else{
			$this->data['config_slogan_en'] = $this->config->get('config_slogan_en');
		}
		
		if (isset($this->request->post['config_hotline'])) {
			$this->data['config_hotline'] = $this->request->post['config_hotline'];
		} else{
			$this->data['config_hotline'] = $this->config->get('config_hotline');
		}
		
		if (isset($this->request->post['config_hotline1'])) {
			$this->data['config_hotline1'] = $this->request->post['config_hotline1'];
		} else{
			$this->data['config_hotline1'] = $this->config->get('config_hotline1');
		}
		
		if (isset($this->request->post['config_email_contact_info'])) {
			$this->data['config_email_contact_info'] = $this->request->post['config_email_contact_info'];
		} else{
			$this->data['config_email_contact_info'] = $this->config->get('config_email_contact_info');
		}
		
		if (isset($this->request->post['config_loop_picture'])) {
      		$this->data['config_loop_picture'] = $this->request->post['config_loop_picture'];
    	} else{
      		$this->data['config_loop_picture'] = $this->config->get('config_loop_picture');
    	}
		
		if (isset($this->request->post['config_loop_home_nhamau'])) {
      		$this->data['config_loop_home_nhamau'] = $this->request->post['config_loop_home_nhamau'];
    	} else{
      		$this->data['config_loop_home_nhamau'] = $this->config->get('config_loop_home_nhamau');
    	}
		
		if (isset($this->request->post['config_loop_about_album'])) {
      		$this->data['config_loop_about_album'] = $this->request->post['config_loop_about_album'];
    	} else{
      		$this->data['config_loop_about_album'] = $this->config->get('config_loop_about_album');
    	}
		
		if (isset($this->request->post['config_loop_about_video'])) {
      		$this->data['config_loop_about_video'] = $this->request->post['config_loop_about_video'];
    	} else{
      		$this->data['config_loop_about_video'] = $this->config->get('config_loop_about_video');
    	}
		
		//
		if (isset($this->request->post['config_loop_project_tongquan'])) {
      		$this->data['config_loop_project_tongquan'] = $this->request->post['config_loop_project_tongquan'];
    	} else{
      		$this->data['config_loop_project_tongquan'] = $this->config->get('config_loop_project_tongquan');
    	}
		if (isset($this->request->post['config_loop_project_quymo'])) {
      		$this->data['config_loop_project_quymo'] = $this->request->post['config_loop_project_quymo'];
    	} else{
      		$this->data['config_loop_project_quymo'] = $this->config->get('config_loop_project_quymo');
    	}
		if (isset($this->request->post['config_loop_project_tienich'])) {
      		$this->data['config_loop_project_tienich'] = $this->request->post['config_loop_project_tienich'];
    	} else{
      		$this->data['config_loop_project_tienich'] = $this->config->get('config_loop_project_tienich');
    	}
		
		//
		if (isset($this->request->post['config_loop_house_model'])) {
      		$this->data['config_loop_house_model'] = $this->request->post['config_loop_house_model'];
    	} else{
      		$this->data['config_loop_house_model'] = $this->config->get('config_loop_house_model');
    	}
		
		//
		if (isset($this->request->post['config_loop_library_phaply'])) {
      		$this->data['config_loop_library_phaply'] = $this->request->post['config_loop_library_phaply'];
    	} else{
      		$this->data['config_loop_library_phaply'] = $this->config->get('config_loop_library_phaply');
    	}
		if (isset($this->request->post['config_loop_library_album'])) {
      		$this->data['config_loop_library_album'] = $this->request->post['config_loop_library_album'];
    	} else{
      		$this->data['config_loop_library_album'] = $this->config->get('config_loop_library_album');
    	}
		if (isset($this->request->post['config_loop_library_video'])) {
      		$this->data['config_loop_library_video'] = $this->request->post['config_loop_library_video'];
    	} else{
      		$this->data['config_loop_library_video'] = $this->config->get('config_loop_library_video');
    	}
		if (isset($this->request->post['config_loop_library_brochure'])) {
      		$this->data['config_loop_library_brochure'] = $this->request->post['config_loop_library_brochure'];
    	} else{
      		$this->data['config_loop_library_brochure'] = $this->config->get('config_loop_library_brochure');
    	}

		$this->template = 'catalog/logo_form.tpl';
		$this->children = array(
		                        'common/header',
		                        'common/footer',
		                        );

		$this->response->setOutput($this->render());
	}

	private function validateForm() {
		if (!$this->user->hasPermission('modify', 'catalog/logo')) {
			$this->error['warning'] = $this->data['error_permission'];
		}
		
		if(((strlen(utf8_decode($this->request->post['config_loop_home_nhamau'])) < 1) || (strlen(utf8_decode($this->request->post['config_loop_home_nhamau'])) > 2)) || (int)$this->request->post['config_loop_home_nhamau']>10)
			$this->error['loop_home_nhamau'] = $this->data['help_loop_picture'];		
		
		
		if(((strlen(utf8_decode($this->request->post['config_loop_picture'])) < 1) || (strlen(utf8_decode($this->request->post['config_loop_picture'])) > 2)) || (int)$this->request->post['config_loop_picture']>10)
			$this->error['loop_picture'] = $this->data['help_loop_picture'];		
		
		if(((strlen(utf8_decode($this->request->post['config_loop_about_album'])) < 1) || (strlen(utf8_decode($this->request->post['config_loop_about_album'])) > 2)) || (int)$this->request->post['config_loop_about_album']>10)
			$this->error['loop_about_album'] = $this->data['help_loop_picture'];		
		
		if(((strlen(utf8_decode($this->request->post['config_loop_about_video'])) < 1) || (strlen(utf8_decode($this->request->post['config_loop_about_video'])) > 2)) || (int)$this->request->post['config_loop_about_video']>10)
			$this->error['loop_about_video'] = $this->data['help_loop_picture'];		
		
		
		//
		if(((strlen(utf8_decode($this->request->post['config_loop_project_tienich'])) < 1) || (strlen(utf8_decode($this->request->post['config_loop_project_tienich'])) > 2)) || (int)$this->request->post['config_loop_project_tienich']>10)
			$this->error['loop_project_tienich'] = $this->data['help_loop_picture'];		
		
		if(((strlen(utf8_decode($this->request->post['config_loop_project_quymo'])) < 1) || (strlen(utf8_decode($this->request->post['config_loop_project_quymo'])) > 2)) || (int)$this->request->post['config_loop_project_quymo']>10)
			$this->error['loop_project_quymo'] = $this->data['help_loop_picture'];		
		
		if(((strlen(utf8_decode($this->request->post['config_loop_project_tongquan'])) < 1) || (strlen(utf8_decode($this->request->post['config_loop_project_tongquan'])) > 2)) || (int)$this->request->post['config_loop_project_tongquan']>10)
			$this->error['loop_project_tongquan'] = $this->data['help_loop_picture'];		
		
		//
		if(((strlen(utf8_decode($this->request->post['config_loop_house_model'])) < 1) || (strlen(utf8_decode($this->request->post['config_loop_house_model'])) > 2)) || (int)$this->request->post['config_loop_house_model']>10)
			$this->error['loop_house_model'] = $this->data['help_loop_picture'];		
		
		//
		if(((strlen(utf8_decode($this->request->post['config_loop_library_brochure'])) < 1) || (strlen(utf8_decode($this->request->post['config_loop_library_brochure'])) > 2)) || (int)$this->request->post['config_loop_library_brochure']>10)
			$this->error['loop_library_brochure'] = $this->data['help_loop_picture'];		
		
		if(((strlen(utf8_decode($this->request->post['config_loop_library_album'])) < 1) || (strlen(utf8_decode($this->request->post['config_loop_library_album'])) > 2)) || (int)$this->request->post['config_loop_library_album']>10)
			$this->error['loop_library_album'] = $this->data['help_loop_picture'];		
		
		if(((strlen(utf8_decode($this->request->post['config_loop_library_video'])) < 1) || (strlen(utf8_decode($this->request->post['config_loop_library_video'])) > 2)) || (int)$this->request->post['config_loop_library_video']>10)
			$this->error['loop_library_video'] = $this->data['help_loop_picture'];		
		
		if(((strlen(utf8_decode($this->request->post['config_loop_library_phaply'])) < 1) || (strlen(utf8_decode($this->request->post['config_loop_library_phaply'])) > 2)) || (int)$this->request->post['config_loop_library_phaply']>10)
			$this->error['loop_library_phaply'] = $this->data['help_loop_picture'];		
		
		

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->data['error_warning'];
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
	
	public function clearcache() {
		if (!$this->user->hasPermission('modify', 'catalog/logo')) {
			$this->error['warning'] = $this->data['error_permission'];
		}
		
		$files = glob(DIR_CACHE . 'cache.*');
		
		if ($files) {
			foreach ($files as $file) {
				if (file_exists($file)) {
					unlink($file);
				}
			}
		}
		//print_r($this->request);
		$this->session->data['success'] = 'Bạn đã Xóa cache thành công!';
		
		$this->redirect(HTTP_SERVER . "index.php?route=catalog/menu&token=" . $this->request->get['token']);
	}
}
?>
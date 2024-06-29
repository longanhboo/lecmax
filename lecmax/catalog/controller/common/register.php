<?php  
class ControllerCommonRegister extends Controller {
	public function __construct($registry) {
		$this->registry = $registry;
		
		$this->load->model('catalog/lang');		   	
		
		$langs = $this->model_catalog_lang->getLangByModule('header',1);
		
		foreach($langs as $lang){
			$this->data[$lang['key']] = $lang['name'];
		}
		
	}
	
	public function index() {
		
		$this->data['lang'] = $this->config->get('config_language');
		
		$this->loadInfo();
		$this->data['config_dangkynhantin'] = $this->config->get('config_dangkynhantin');
		$this->data['text_dangkynhantin'] = html_entity_decode($this->data['text_dangkynhantin']);
		
		$template = 'register.tpl';
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/' . $template)) {
			$this->template = $this->config->get('config_template') . '/template/common/' . $template;
		} else {
			$this->template = 'default/template/common/' . $template;
		}
								
		$this->render();
	}
	
	private function loadInfo(){
		
		if(isset($this->request->post['nameregister']) && !empty($this->request->post['nameregister']))
			$this->data['nameregister'] 		= $this->request->post['nameregister'];
		else
			$this->data['nameregister']			= $this->data['text_name_register'];
		
		if(isset($this->request->post['emailregister']) && !empty($this->request->post['emailregister']))	
			$this->data['emailregister'] 		= $this->request->post['emailregister'];
		else
			$this->data['emailregister']		= $this->data['text_email_register'];
		
		if(isset($this->request->post['phoneregister']) && !empty($this->request->post['phoneregister']))
			$this->data['phoneregister'] 		= $this->request->post['phoneregister'];
		else
			$this->data['phoneregister']		= $this->data['text_phone_register'];
		
		/*if(isset($this->request->post['cmndregister']) && !empty($this->request->post['cmndregister']))
			$this->data['cmndregister'] 		= $this->request->post['cmndregister'];
		else
			$this->data['cmndregister']		= $this->data['text_cmnd_register'];
		
		if(isset($this->request->post['cityregister']) && !empty($this->request->post['cityregister']))
			$this->data['cityregister'] 		= $this->request->post['cityregister'];
		else
			$this->data['cityregister']		= $this->data['text_city_register'];
		
		if(isset($this->request->post['districtregister']) && !empty($this->request->post['districtregister']))
			$this->data['districtregister'] 		= $this->request->post['districtregister'];
		else
			$this->data['districtregister']		= $this->data['text_district_register'];
		
		*/
		/*if(isset($this->request->post['ngaycapregister']) && !empty($this->request->post['ngaycapregister']))
			$this->data['ngaycapregister'] 		= $this->request->post['ngaycapregister'];
		else
			$this->data['ngaycapregister']		= $this->data['text_ngaycap_register'];
		
		if(isset($this->request->post['noicapregister']) && !empty($this->request->post['noicapregister']))
			$this->data['noicapregister'] 		= $this->request->post['noicapregister'];
		else
			$this->data['noicapregister']		= $this->data['text_noicap_register'];
		
		if(isset($this->request->post['addressregister']) && !empty($this->request->post['addressregister']))
			$this->data['addressregister'] 		= $this->request->post['addressregister'];
		else
			$this->data['addressregister']		= $this->data['text_address_register'];
		
		if(isset($this->request->post['macanhoregister']) && !empty($this->request->post['macanhoregister']))
			$this->data['macanhoregister'] 		= $this->request->post['macanhoregister'];
		else
			$this->data['macanhoregister']		= $this->data['text_macanho_register'];
		
		if(isset($this->request->post['tangregister']) && !empty($this->request->post['tangregister']))
			$this->data['tangregister'] 		= $this->request->post['tangregister'];
		else
			$this->data['tangregister']		= $this->data['text_tang_register'];
		
		if(isset($this->request->post['toaregister']) && !empty($this->request->post['toaregister']))
			$this->data['toaregister'] 		= $this->request->post['toaregister'];
		else
			$this->data['toaregister']		= $this->data['text_toa_register'];
		*/
		if(isset($this->request->post['commentregister']) && !empty($this->request->post['commentregister']))
			$this->data['commentregister'] 		= $this->request->post['commentregister'];
		else
			$this->data['commentregister']		= $this->data['text_comment_register'];
		
		
		
		
	}
}
?>
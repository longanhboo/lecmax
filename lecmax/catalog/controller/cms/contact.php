<?php
class ControllerCmsContact extends Controller {
	private $error = array();

	public function __construct($registry) {
		$this->registry = $registry;

		$this->load->model('catalog/lang');

		$langs = $this->model_catalog_lang->getLangByModule('contact',1);
		foreach($langs as $lang){
			$this->data[$lang['key']] = html_entity_decode($lang['name']);
		}
	}

	public function index() {
		$this->load->model('cms/contact');
		$this->load->model('cms/common');
		
		//$this->document->addScript(PATH_TEMPLATE . 'default/js/validate.js');
		//$this->document->addLink(PATH_TEMPLATE . 'default/css/validationEngine.jquery.css','stylesheet');
		//$this->document->addScript(PATH_TEMPLATE . 'default/js/jquery.validationEngine.js');
		$this->data['lang'] = $this->config->get('config_language');

		$path = isset($this->request->get['path'])?$this->request->get['path']:0;

		$arr_path = explode('_',$path);

		if((int)$arr_path[0]==0)
			$this->redirect($this->url->link('error/not_found'));

		$infoActive_data = $this->cache->get('category.bgid.' . $arr_path[0] . '.' . $this->config->get('config_language_id'));
		if (!$infoActive_data) {
			$this->data['infoActive'] = $this->model_cms_common->getBackgroundPage($arr_path[0]);
			$this->cache->set('category.bgid.' . $arr_path[0] . '.' . (int)$this->config->get('config_language_id'), $this->data['infoActive'], CACHE_TIME);
		}else{
			$this->data['infoActive'] = $infoActive_data;
		}
		
		if(!isset($this->data['infoActive']['name']) || empty($this->data['infoActive']['name']))
			$this->redirect($this->url->link('error/not_found'));
		
		
		$contact_data = $this->cache->get('contacts' . '.' . $this->config->get('config_language_id'));
		if (!$contact_data) {
			$this->data['contacts'] = $this->model_cms_contact->getContactByParent($arr_path[0],0);
			$this->cache->set('contacts' . '.' . (int)$this->config->get('config_language_id'), $this->data['contacts'], CACHE_TIME);
		}else{
			$this->data['contacts'] = $contact_data;
		}
		
		/*$this->load->model('cms/city');
		$city_data = $this->cache->get('citys' . '.' . $this->config->get('config_language_id'));
		if (!$city_data) {
			$this->data['citys'] = $this->model_cms_city->getCitys($arr_path[0]);
			$this->cache->set('citys' . '.' . (int)$this->config->get('config_language_id'), $this->data['citys'], CACHE_TIME);
		}else{
			$this->data['citys'] = $city_data;
		}*/
		
		//$this->data['districts'] = array();
		
		//$this->data['getApartment'] = $this->model_cms_common->getIntro(ID_APARTMENT);
		//$this->data['getFacilities'] = $this->model_cms_common->getIntro(ID_FACILITIES);
		
		
		if(isset($this->request->post['name']) && !empty($this->request->post['name']))
			$this->data['name'] 		= $this->request->post['name'];
		else
			$this->data['name']			= $this->data['text_name'];
			
		if(isset($this->request->post['phone']) && !empty($this->request->post['phone']))
			$this->data['phone'] 		= $this->request->post['phone'];
		else
			$this->data['phone']		= $this->data['text_phone'];
		
		if(isset($this->request->post['email']) && !empty($this->request->post['email']))	
			$this->data['email'] 		= $this->request->post['email'];
		else
			$this->data['email']		= $this->data['text_email'];
		
		/*if(isset($this->request->post['address']) && !empty($this->request->post['address']))	
			$this->data['address'] 			= $this->request->post['address'];
		else
			$this->data['address']		= $this->data['text_address'];
		
		if(isset($this->request->post['company']) && !empty($this->request->post['company']))	
			$this->data['company'] 			= $this->request->post['company'];
		else
			$this->data['company']		= $this->data['text_company'];
		*/
		if(isset($this->request->post['comments']) && !empty($this->request->post['comments']))
			$this->data['comments'] 	= $this->request->post['comments'];
		else
			$this->data['comments']		= $this->data['text_comments'];
		
		$contact_id = isset($this->request->get['contact_id'])?	(int)$this->request->get['contact_id']:0;
		$this->data['contact_id'] = $contact_id;
		
		$template = 'contact.tpl';
		if($contact_id){
			$seo = $this->model_cms_contact->getContact($contact_id);
		}else{
			$seo = $this->model_cms_common->getSeo($arr_path[0]);
		}

		$this->document->setKeywords($seo['meta_keyword']);
		$this->document->setDescription($seo['meta_description']);
		$this->document->setTitle($seo['meta_title']);
		$this->document->setDescriptionog($seo['meta_description_og']);
		$this->document->setTitleog($seo['meta_title_og']);
		$this->document->setImageog($seo['image_og']);


		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/cms/'.$template)) {
			$this->template = $this->config->get('config_template') . '/template/cms/'.$template;
		} else {
			$this->template = 'default/template/common/'. $template;
		}

		$this->children = array(
			'common/footer',
			'common/header',
		);

		$this->response->setOutput($this->render());
	}
	
	private function validateCaptcha(){
		//lấy dữ liệu được post lên
		$site_key_post    = $this->request->post['g-recaptcha-response'];
		  
		//lấy IP của khach
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$remoteip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$remoteip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			$remoteip = $_SERVER['REMOTE_ADDR'];
		}
		 
		//tạo link kết nối
		$api_url = api_url.'?secret='.secret_key.'&response='.$site_key_post.'&remoteip='.$remoteip;
		//lấy kết quả trả về từ google
		$response = file_get_contents($api_url);
		//dữ liệu trả về dạng json
		$response = json_decode($response);
		if(!isset($response->success))
		{
			$this->session->data['captcha_check'] = false;
			return false;
		}
		if($response->success == true)
		{
			$this->session->data['captcha_check'] = true;
			return true;
		}else{
			$this->session->data['captcha_check'] = false;
			return false;
		}
	}
	
	public function contact(){
		$this->load->model('cms/contact');
		$this->load->model('cms/emailcus');
		$results = array(
			"status" => 400,
			"message" => $this->data['text_contact_fail'],
			"info" => array()
		);
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			if($this->validateCaptcha()){
			
				if($this->send()){
					$this->model_cms_emailcus->addEmailCus($this->request->post,0);
					$this->session->data['isThanks'] = true;
					//echo "1";
					$results = array(
						"status" => 200,
						"message" => $this->data['text_contact_success'],
						"info" => array()
					);
					
					echo json_encode($results);
                	die;
					
				}else{
					echo json_encode($results);
                	die;
					//echo "0";
				}
			}else{
				$results = array(
					"status" => 400,
					"message" => $this->data['error_captcha'],
					"info" => array()
				);
				
				echo json_encode($results);
                die;
				//echo "-1";
			}
		}
		die;		
		
		/*$destination_path = DIR_DOWNLOAD . 'contact/';

        require_once(DIR_SYSTEM . 'library/f.php');

        $result = 0;
        $time = time();
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$parts = pathinfo($_FILES['myfile']['name']);
			
			if(isset($parts['extension'])){
	
			if ($parts['extension'] == 'doc' || $parts['extension'] == 'docx'  || $parts['extension'] == 'xls'  || $parts['extension'] == 'xlsx' || $parts['extension'] == 'pdf') {
				$name = explode('.', $parts['basename']);
				$filename = convertAlias($name[0]) . '_' . $time . '.' . $parts['extension'];
	
				$target_path = $destination_path . $filename;
	
				if (@move_uploaded_file($_FILES['myfile']['tmp_name'], $target_path)) {
					$result = 1;
					//$this->model_cms_emailcus->addEmailCus($this->request->post,0, $filename);
					$this->session->data['isThanks'] = true;
					//$this->model_cms_ungvien->addUngvien($filename,$this->request->post);
					$this->send($filename);
				}
			}
			}else{
				$result = $this->send($filename);
			}
		}


        sleep(1);
		echo $result;
		
        echo '<script language="javascript" type="text/javascript">window.top.window.stopUpload(' . $result . ');</script>  ';*/
			
	}
		
	private function validate()
	{
		
		if(isset($this->request->post['name']) && $this->request->post['name']==$this->data['text_name'])
			$this->request->post['name'] = "";
		
		if(isset($this->request->post['address']) && $this->request->post['address']==$this->data['text_address'])
			$this->request->post['address'] = "";
		
		if(isset($this->request->post['company']) && $this->request->post['company']==$this->data['text_company'])
			$this->request->post['company'] = "";
		
		if(isset($this->request->post['phone']) && $this->request->post['phone']==$this->data['text_phone'])
			$this->request->post['phone'] = "";
			
		if(isset($this->request->post['email']) && $this->request->post['email']==$this->data['text_email'])
			$this->request->post['email'] = "";
			
		if(isset($this->request->post['comments']) && $this->request->post['comments']==$this->data['text_comments'])
			$this->request->post['comments'] = "";
		
		/*if(isset($this->request->post['center-province']) && $this->request->post['center-province']==$this->data['text_tinh_thanh_pho'])
			$this->request->post['center-province'] = "0";
		
		if(isset($this->request->post['center-district']) && $this->request->post['center-district']==$this->data['text_quan_huyen'])
			$this->request->post['center-district'] = "0";
		*/
		/*if($this->request->post['captcha']==$this->data['text_captcha'])
			$this->request->post['captcha'] = "";
		*/	
		if(empty($this->request->post['name'])){
			$this->error['name'] = $this->data['error_name'];
		}
				
		if(empty($this->request->post['phone'])){
			$this->error['phone'] = $this->data['error_phone'];
		}
		
		if(empty($this->request->post['comments'])){
			$this->error['comments'] = $this->data['error_comments'];
		}
		/*
		if (!isset($this->session->data['captcha']) || ($this->session->data['captcha'] != $this->request->post['captcha'])) {
      		$this->error['captcha'] = $this->data['error_captcha');
    	}	
		*/
		$pattern = '/^[A-Z0-9._%-]+@[A-Z0-9][A-Z0-9.-]{0,61}[A-Z0-9]\.[A-Z]{2,6}$/i';

    	if ((strlen(utf8_decode($this->request->post['email'])) > 96) || (!preg_match($pattern, $this->request->post['email']))) {
      		$this->error['email'] = $this->data['error_email'];
    	}
		
		if (!$this->error) {
	  		return TRUE;
		} else {
	  		return FALSE;
		}  	
	}

	private function send($filename = ''){
		
		$content = '';
		$date 			= date("d-m-Y H:i:s");
		$name 			= $this->request->post['name'];
		$phone 			= $this->request->post['phone'];
		$email 			= $this->request->post['email'];
		$address 	= isset($this->request->post['address'])?$this->request->post['address']:'';
		$company 	= isset($this->request->post['company'])?$this->request->post['company']:'';
		//$mailto 	= isset($this->request->post['mailto'])?$this->request->post['mailto']:'';
		$comments 		= $this->request->post['comments'];
		
		$province 	= isset($this->request->post['center-province'])?$this->request->post['center-province']:0;
		$district 	= isset($this->request->post['center-district'])?$this->request->post['center-district']:0;
		
		$content .='<table style="padding:10px; border:1px solid #09F; border-collapse:collapse" width="100%" border="1" cellspacing="2" cellpadding="2">';
		
		$content .= '<tr style="border:1px solid #09F; border-collapse:collapse"><td style="border:1px solid #09F; padding:5px" align="center" colspan="2"><b>'.$this->data['text_title'].'</b></td></tr>';
			
		$content .= '<tr style="border:1px solid #09F; border-collapse:collapse"><td style="border:1px solid #09F; padding:5px" align="right" >'.$this->data['text_name'].'</td><td style="border:1px solid #09F; padding:5px" align="left">'.$name.'</td></tr>';
		
		if(!empty($company)){
		$content .= '<tr style="border:1px solid #09F; border-collapse:collapse"><td style="border:1px solid #09F; padding:5px" align="right" >'.$this->data['text_company'].'</td><td style="border:1px solid #09F; padding:5px" align="left">'.$company.'</td></tr>';
		}
		
		if(!empty($address)){
		$content .= '<tr style="border:1px solid #09F; border-collapse:collapse"><td style="border:1px solid #09F; padding:5px" align="right" >'.$this->data['text_address'].'</td><td style="border:1px solid #09F; padding:5px" align="left">'.$address.'</td></tr>';
		}
		
		if($province){
			$this->load->model('cms/city');
			$city = $this->model_cms_city->getCity($province);
			if(isset($city['name'])){
				$content .= '<tr style="border:1px solid #09F; border-collapse:collapse"><td style="border:1px solid #09F; padding:5px" align="right" >'.$this->data['text_tinh_thanh_pho'].'</td><td style="border:1px solid #09F; padding:5px" align="left">'.$city['name'].'</td></tr>';
			}
		}
		
		if($district){
			$this->load->model('cms/district');
			$district = $this->model_cms_district->getDistrict($district);
			if(isset($district['name'])){
				$content .= '<tr style="border:1px solid #09F; border-collapse:collapse"><td style="border:1px solid #09F; padding:5px" align="right" >'.$this->data['text_tinh_thanh_pho'].'</td><td style="border:1px solid #09F; padding:5px" align="left">'.$district['name'].'</td></tr>';
			}
		}
		
		/*if(!empty($company)){
		$content .= '<tr style="border:1px solid #09F; border-collapse:collapse"><td style="border:1px solid #09F; padding:5px" align="right" >'.$this->data['text_company'].'</td><td style="border:1px solid #09F; padding:5px" align="left">'.$company.'</td></tr>';
		}*/
		//if(!empty($phone)){
		$content .= '<tr style="border:1px solid #09F; border-collapse:collapse"><td style="border:1px solid #09F; padding:5px" align="right" >'.$this->data['text_phone'].'</td><td style="border:1px solid #09F; padding:5px" align="left">'.$phone.'</td></tr>';
		//}
		$content .= '<tr style="border:1px solid #09F; border-collapse:collapse"><td style="border:1px solid #09F; padding:5px" align="right" >'.$this->data['text_email'].'</td><td style="border:1px solid #09F; padding:5px" align="left">'.$email.'</td></tr>';	
		
		$content .= '<tr style="border:1px solid #09F; border-collapse:collapse"><td style="border:1px solid #09F; padding:5px" align="right" >'.$this->data['text_comments'].'</td><td style="border:1px solid #09F; padding:5px" align="left">'.nl2br($comments).'</td></tr>';
		
		/*if(!empty($filename)){
		$content .= '<tr style="border:1px solid #09F; border-collapse:collapse"><td style="border:1px solid #09F; padding:5px" align="right" >Download</td><td style="border:1px solid #09F; padding:5px" align="left"><a href="' . HTTP_DOWNLOAD . 'contact/' . $filename . '" title="Download">Click vào đây để download file Khách Hàng liên hệ.</a></td></tr>';
		}*/
		
		$content .= '</table>';
		//if(!empty($mailto)){
		//	$to = trim($mailto);
		//}else{
			$to = explode(';',$this->config->get('config_email_contact'));
		//}
		//echo $content; echo $this->data['text_title']; echo $this->data['text_sender']; die;
		//return true;
		
		/*============================================================*/
		// Create the Transport
		if($this->config->get('config_mail_protocol')=='smtp'){
			$transport = Swift_SmtpTransport::newInstance($this->config->get('config_smtp_host'), $this->config->get('config_smtp_port'))
			 ->setUsername($this->config->get('config_smtp_username'))
			 ->setPassword($this->config->get('config_smtp_password'))
			 ; 
			 $from = $this->config->get('config_smtp_username');  
			 //$transport->setLocalDomain('112.213.94.88'); 
		}else{
			$transport = Swift_MailTransport::newInstance();
			$from = isset($to[0]) && !empty($to[0]) ? $to[0] : $this->config->get('config_email_contact');//$this->config->get('config_email_contact');   
		}
		
		// Create the Mailer using your created Transport
		$mailer = Swift_Mailer::newInstance($transport);
		
		// Create a message
		$message = Swift_Message::newInstance($this->data['text_title'])//subject 
			->setFrom(array($from => $this->data['text_sender'])) //$this->data['text_sender']
			->setTo($to)//$this->config->get('config_email_contact'))
			->setBody(html_entity_decode($content, ENT_QUOTES, 'UTF-8'),'text/html');

		// Send the message
		$result = $mailer->send($message);
		return $result; 
	}
	
	
	public function register(){
		
		$this->load->model('cms/contact');
		$this->load->model('cms/emailcus');
		$results = array(
			"status" => 400,
			"message" => $this->data['text_contact_fail'],
			"info" => array()
		);
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateregister()) {
			if($this->validateCaptcha()){
			
				if($this->sendregister()){
					$this->model_cms_emailcus->addEmailCus($this->request->post,1);
					$this->session->data['isThanks'] = true;
					//echo "1";
					$results = array(
						"status" => 200,
						"message" => $this->data['text_contact_success'],
						"info" => array()
					);
					
					echo json_encode($results);
                	die;
					
				}else{
					echo json_encode($results);
                	die;
					//echo "0";
				}
			}else{
				$results = array(
					"status" => 400,
					"message" => $this->data['error_captcha'],
					"info" => array()
				);
				
				echo json_encode($results);
                die;
				//echo "-1";
			}
		}
		die;
		
		/*if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateregister()) {
			//if($this->sendregister()){
			//	$this->session->data['isThanks'] = true;
			//	$this->model_cms_emailcus->addEmailCus($this->request->post,1);
			if($this->model_cms_emailcus->addEmailCus($this->request->post,1)){
				echo "1";
			}else{
				echo "0";
			}
		}
		die;*/
	}
	
	private function validateregister()
	{
				
		if(isset($this->request->post['nameregister']) && $this->request->post['nameregister']==$this->data['text_name'])
			$this->request->post['nameregister'] = "";
		
		if(isset($this->request->post['phoneregister']) && $this->request->post['phoneregister']==$this->data['text_phone'])
			$this->request->post['phoneregister'] = "";
			
		if(isset($this->request->post['emailregister']) && $this->request->post['emailregister']==$this->data['text_email'])
			$this->request->post['emailregister'] = "";
		
		if(isset($this->request->post['addressregister']) && $this->request->post['addressregister']==$this->data['text_address'])
			$this->request->post['addressregister'] = "";
		
		if(isset($this->request->post['commentregister']) && $this->request->post['commentregister']==$this->data['text_comments'])
			$this->request->post['commentregister'] = "";
		
			
		/*if($this->request->post['cmndregister']==$this->data['text_cmnd_register'])
			$this->request->post['cmndregister'] = "";
		
		if($this->request->post['cityregister']==$this->data['text_city_register'])
			$this->request->post['cityregister'] = "";
		
		if($this->request->post['districtregister']==$this->data['text_district_register'])
			$this->request->post['districtregister'] = "";
		
		*/
		/*if($this->request->post['ngaycapregister']==$this->data['text_ngaycap_register'])
			$this->request->post['ngaycapregister'] = "";
		if($this->request->post['noicapregister']==$this->data['text_noicap_register'])
			$this->request->post['noicapregister'] = "";
		
		
		if($this->request->post['macanhoregister']==$this->data['text_macanho_register'])
			$this->request->post['macanhoregister'] = "";
		if($this->request->post['tangregister']==$this->data['text_tang_register'])
			$this->request->post['tangregister'] = "";
		if($this->request->post['toaregister']==$this->data['text_toa_register'])
			$this->request->post['toaregister'] = "";*/
		/*if($this->request->post['commentregister']==$this->data['text_comment_register'])
			$this->request->post['commentregister'] = "";
		
		
		if(empty($this->request->post['nameregister'])){
			$this->error['nameregister'] = $this->data['error_name_register'];
		}
		
		if(empty($this->request->post['phoneregister'])){
			$this->error['phoneregister'] = $this->data['error_phone_register'];
		}
		*/
		$pattern = '/^[A-Z0-9._%-]+@[A-Z0-9][A-Z0-9.-]{0,61}[A-Z0-9]\.[A-Z]{2,6}$/i';

    	if ((strlen(utf8_decode($this->request->post['emailregister'])) > 96) || (!preg_match($pattern, $this->request->post['emailregister']))) {
      		$this->error['emailregister'] = $this->data['error_email_register'];
    	}
		
		
		
		if (!$this->error) {
	  		return TRUE;
		} else {
	  		return FALSE;
		}  	
	}
	
	private function sendregister(){
		
		$content = '';
		$date 			= date("d-m-Y H:i:s");
		$name 			= $this->request->post['nameregister'];
		$phone 			= $this->request->post['phoneregister'];
		$email 			= $this->request->post['emailregister'];
		$address 	= isset($this->request->post['addressregister'])?$this->request->post['addressregister']:'';
		/*$cmndregister 			= $this->request->post['cmndregister'];
		$cityregister 			= $this->request->post['cityregister'];
		$districtregister 			= $this->request->post['districtregister'];
		
		$canhoquantamregister 			= $this->request->post['canhoquantamregister'];
		$giaquantamregister 			= $this->request->post['giaquantamregister'];
		*/
		/*$ngaycapregister 			= $this->request->post['ngaycapregister'];
		$noicapregister 			= $this->request->post['noicapregister'];*/
		//$macanhoregister 			= $this->request->post['macanhoregister'];
		//$tangregister 			= $this->request->post['tangregister'];
		//$toaregister 			= $this->request->post['toaregister'];
		$comments 		= $this->request->post['commentregister'];
		
		$content .='<table style="padding:10px; border:1px solid #09F; border-collapse:collapse" width="100%" border="1" cellspacing="2" cellpadding="2">';
		
		$content .= '<tr style="border:1px solid #09F; border-collapse:collapse"><td style="border:1px solid #09F; padding:5px" align="center" colspan="2"><b>'.$this->data['text_title_register'].'</b></td></tr>';
			
		
		$content .= '<tr style="border:1px solid #09F; border-collapse:collapse"><td style="border:1px solid #09F; padding:5px" align="right" >'.$this->data['text_name'].'</td><td style="border:1px solid #09F; padding:5px" align="left">'.$name.'</td></tr>';
		
		$content .= '<tr style="border:1px solid #09F; border-collapse:collapse"><td style="border:1px solid #09F; padding:5px" align="right" >'.$this->data['text_email'].'</td><td style="border:1px solid #09F; padding:5px" align="left">'.$email.'</td></tr>';
		
		$content .= '<tr style="border:1px solid #09F; border-collapse:collapse"><td style="border:1px solid #09F; padding:5px" align="right" >'.$this->data['text_phone'].'</td><td style="border:1px solid #09F; padding:5px" align="left">'.$phone.'</td></tr>';
		
		if(!empty($address)){
		$content .= '<tr style="border:1px solid #09F; border-collapse:collapse"><td style="border:1px solid #09F; padding:5px" align="right" >'.$this->data['text_address'].'</td><td style="border:1px solid #09F; padding:5px" align="left">'.$address.'</td></tr>';
		}
		
		//$content .= '<tr style="border:1px solid #09F; border-collapse:collapse"><td style="border:1px solid #09F; padding:5px" align="right" >'.$this->data['text_cmnd_register'].'</td><td style="border:1px solid #09F; padding:5px" align="left">'.$cmndregister.'</td></tr>';
		//$content .= '<tr style="border:1px solid #09F; border-collapse:collapse"><td style="border:1px solid #09F; padding:5px" align="right" >'.$this->data['text_ngaycap_register'].'</td><td style="border:1px solid #09F; padding:5px" align="left">'.$ngaycapregister.'</td></tr>';
		//$content .= '<tr style="border:1px solid #09F; border-collapse:collapse"><td style="border:1px solid #09F; padding:5px" align="right" >'.$this->data['text_noicap_register'].'</td><td style="border:1px solid #09F; padding:5px" align="left">'.$noicapregister.'</td></tr>';
		
		/*if(!empty($cityregister)){
		$content .= '<tr style="border:1px solid #09F; border-collapse:collapse"><td style="border:1px solid #09F; padding:5px" align="right" >'.$this->data['text_city_register'].'</td><td style="border:1px solid #09F; padding:5px" align="left">'.$cityregister.'</td></tr>';
		}
		if(!empty($districtregister)){
		$content .= '<tr style="border:1px solid #09F; border-collapse:collapse"><td style="border:1px solid #09F; padding:5px" align="right" >'.$this->data['text_district_register'].'</td><td style="border:1px solid #09F; padding:5px" align="left">'.$districtregister.'</td></tr>';
		}
		
		
		
		if(!empty($canhoquantamregister)){
		$content .= '<tr style="border:1px solid #09F; border-collapse:collapse"><td style="border:1px solid #09F; padding:5px" align="right" >'.$this->data['text_khach_hang_quan_tam_den_can_ho_nao'].'</td><td style="border:1px solid #09F; padding:5px" align="left">'.$canhoquantamregister.'</td></tr>';
		}
		
		if(!empty($giaquantamregister)){
		$content .= '<tr style="border:1px solid #09F; border-collapse:collapse"><td style="border:1px solid #09F; padding:5px" align="right" >'.$this->data['text_muc_gia_can_ho_quan_tam'].'</td><td style="border:1px solid #09F; padding:5px" align="left">'.$giaquantamregister.'</td></tr>';
		}*/
		
		
		
		//$content .= '<tr style="border:1px solid #09F; border-collapse:collapse"><td style="border:1px solid #09F; padding:5px" align="right" >'.$this->data['text_macanho_register'].'</td><td style="border:1px solid #09F; padding:5px" align="left">'.$macanhoregister.'</td></tr>';
		//$content .= '<tr style="border:1px solid #09F; border-collapse:collapse"><td style="border:1px solid #09F; padding:5px" align="right" >'.$this->data['text_tang_register'].'</td><td style="border:1px solid #09F; padding:5px" align="left">'.$tangregister.'</td></tr>';
		//$content .= '<tr style="border:1px solid #09F; border-collapse:collapse"><td style="border:1px solid #09F; padding:5px" align="right" >'.$this->data['text_toa_register'].'</td><td style="border:1px solid #09F; padding:5px" align="left">'.$toaregister.'</td></tr>';
		
		$content .= '<tr style="border:1px solid #09F; border-collapse:collapse"><td style="border:1px solid #09F; padding:5px" align="right" >'.$this->data['text_comments'].'</td><td style="border:1px solid #09F; padding:5px" align="left">'.$comments.'</td></tr>';
		
		$content .= '</table>';
		
		$to = explode(';',$this->config->get('config_email_contact_register'));//_register
		//echo $content; echo $this->data['text_title_register']; echo $this->data['text_sender']; die;
		//return true;
		
		/*============================================================*/
		// Create the Transport
		if($this->config->get('config_mail_protocol')=='smtp'){
			$transport = Swift_SmtpTransport::newInstance($this->config->get('config_smtp_host'), $this->config->get('config_smtp_port'))
			 ->setUsername($this->config->get('config_smtp_username'))
			 ->setPassword($this->config->get('config_smtp_password'))
			 ; 
			 $from = $this->config->get('config_smtp_username');  
			 //$transport->setLocalDomain('112.213.94.88'); 
		}else{
			$transport = Swift_MailTransport::newInstance();
			$from = isset($to[0]) && !empty($to[0]) ? $to[0] : $this->config->get('config_email_contact_register');//$this->config->get('config_email_contact_register');   
			//$from = $this->config->get('config_email_contact_register');   
		}
		
		// Create the Mailer using your created Transport
		$mailer = Swift_Mailer::newInstance($transport);
		
		// Create a message
		$message = Swift_Message::newInstance($this->data['text_title_register'])//subject
			->setFrom(array($from => $this->data['text_sender']))
			->setTo($to)//$this->config->get('config_email_contact_register'))
			->setBody(html_entity_decode($content, ENT_QUOTES, 'UTF-8'),'text/html');

		// Send the message
		$result = $mailer->send($message);
		return $result; 
	}
	
	public function thankyou(){
		$this->load->model('cms/contact');
		$this->load->model('cms/common');
		
		//$this->document->addLink(PATH_TEMPLATE . 'default/css/validationEngine.jquery.css','stylesheet');
		//$this->document->addScript(PATH_TEMPLATE . 'default/js/jquery.validationEngine.js');
		
		if(!isset($this->session->data['isThanks']))
			$this->redirect(HTTP_SERVER);
		
		unset($this->session->data['isThanks']);
		$this->request->post['isThanks'] = true;
		
		$this->data['infoActive'] = $this->model_cms_common->getBackgroundPage(ID_CONTACT);
		$this->data['contacts'] = $this->model_cms_contact->getContacts(ID_CONTACT);
		
		$this->data['getApartment'] = $this->model_cms_common->getIntro(ID_APARTMENT);
		$this->data['getFacilities'] = $this->model_cms_common->getIntro(ID_FACILITIES);
		
		$template = 'thankyou.tpl';
		$seo = $this->model_cms_common->getSeo(ID_CONTACT);

		$this->document->setKeywords($seo['meta_keyword']);
		$this->document->setDescription($seo['meta_description']);
		$this->document->setTitle($seo['meta_title']);
		$this->document->setDescriptionog($seo['meta_description_og']);
		$this->document->setTitleog($seo['meta_title_og']);
		$this->document->setImageog($seo['image_og']);


		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/cms/'.$template)) {
			$this->template = $this->config->get('config_template') . '/template/cms/'.$template;
		} else {
			$this->template = 'default/template/common/'. $template;
		}

		$this->children = array(
			'common/footer',
			'common/logo',
			'common/slogan',
			'common/register',
			'common/menu',
			'common/hotline',
			'common/header',
		);

		$this->response->setOutput($this->render());			
	}
	
	
	public function catalogue(){
		
		$this->load->model('cms/contact');
		$this->load->model('cms/emailcus');
		$results = array(
			"status" => 400,
			"message" => $this->data['text_catalogue_fail'],
			"info" => array()
		);
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validatecatalogue()) {
			if($this->validateCaptcha()){
			
				if($this->sendcatalogue()){
					$this->model_cms_emailcus->addEmailCus($this->request->post,1);
					$this->session->data['isThanks'] = true;
					//echo "1";
					$results = array(
						"status" => 200,
						"message" => $this->data['text_catalogue_success'],
						"info" => array()
					);
					
					echo json_encode($results);
                	die;
					
				}else{
					echo json_encode($results);
                	die;
					//echo "0";
				}
			}else{
				$results = array(
					"status" => 400,
					"message" => $this->data['error_captcha'],
					"info" => array()
				);
				
				echo json_encode($results);
                die;
				//echo "-1";
			}
		}
		die;
		
		/*if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validatecatalogue()) {
			//if($this->sendcatalogue()){
			//	$this->session->data['isThanks'] = true;
			//	$this->model_cms_emailcus->addEmailCus($this->request->post,1);
			if($this->model_cms_emailcus->addEmailCus($this->request->post,1)){
				echo "1";
			}else{
				echo "0";
			}
		}
		die;*/
	}
	
	private function validatecatalogue()
	{
				
		if(isset($this->request->post['name']) && $this->request->post['name']==$this->data['text_name_catalogue'])
			$this->request->post['name'] = "";
		
		if(isset($this->request->post['phone']) && $this->request->post['phone']==$this->data['text_phone_catalogue'])
			$this->request->post['phone'] = "";
			
		if(isset($this->request->post['email']) && $this->request->post['email']==$this->data['text_email_catalogue'])
			$this->request->post['email'] = "";
		
		if(isset($this->request->post['address']) && $this->request->post['address']==$this->data['text_address_catalogue'])
			$this->request->post['address'] = "";
		
		if(isset($this->request->post['company']) && $this->request->post['company']==$this->data['text_company_catalogue'])
			$this->request->post['company'] = "";
		
		if(isset($this->request->post['center-province']) && $this->request->post['center-province']==$this->data['text_tinh_thanh_pho'])
			$this->request->post['center-province'] = "0";
		
		if(isset($this->request->post['center-district']) && $this->request->post['center-district']==$this->data['text_quan_huyen'])
			$this->request->post['center-district'] = "0";
		
		
		
		if(empty($this->request->post['name'])){
			$this->error['name'] = $this->data['error_name_catalogue'];
		}
		
		if(empty($this->request->post['phone'])){
			$this->error['phone'] = $this->data['error_phone_catalogue'];
		}
		
		$pattern = '/^[A-Z0-9._%-]+@[A-Z0-9][A-Z0-9.-]{0,61}[A-Z0-9]\.[A-Z]{2,6}$/i';

    	if ((strlen(utf8_decode($this->request->post['email'])) > 96) || (!preg_match($pattern, $this->request->post['email']))) {
      		$this->error['email'] = $this->data['error_email_catalogue'];
    	}
		
		
		
		if (!$this->error) {
	  		return TRUE;
		} else {
	  		return FALSE;
		}  	
	}
	
	private function sendcatalogue(){
		$this->load->model('cms/filepdf');
		$content = '';
		$date 			= date("d-m-Y H:i:s");
		$name 			= $this->request->post['name'];
		$phone 			= $this->request->post['phone'];
		$email 			= $this->request->post['email'];
		$address 	= isset($this->request->post['address'])?$this->request->post['address']:'';
		$company 			= $this->request->post['company'];
		$catalogue 			= isset($this->request->post['catalogue'])?$this->request->post['catalogue']:array();
		
		$province 	= isset($this->request->post['center-province'])?$this->request->post['center-province']:0;
		$district 	= isset($this->request->post['center-district'])?$this->request->post['center-district']:0;
		
		
		$content .='<table style="padding:10px; border:1px solid #09F; border-collapse:collapse" width="100%" border="1" cellspacing="2" cellpadding="2">';
		
		$content .= '<tr style="border:1px solid #09F; border-collapse:collapse"><td style="border:1px solid #09F; padding:5px" align="center" colspan="2"><b>'.$this->data['text_title_catalogue'].'</b></td></tr>';
			
		
		$content .= '<tr style="border:1px solid #09F; border-collapse:collapse"><td style="border:1px solid #09F; padding:5px" align="right" >'.$this->data['text_name_catalogue'].'</td><td style="border:1px solid #09F; padding:5px" align="left">'.$name.'</td></tr>';
		
		$content .= '<tr style="border:1px solid #09F; border-collapse:collapse"><td style="border:1px solid #09F; padding:5px" align="right" >'.$this->data['text_email_catalogue'].'</td><td style="border:1px solid #09F; padding:5px" align="left">'.$email.'</td></tr>';
		
		$content .= '<tr style="border:1px solid #09F; border-collapse:collapse"><td style="border:1px solid #09F; padding:5px" align="right" >'.$this->data['text_phone_catalogue'].'</td><td style="border:1px solid #09F; padding:5px" align="left">'.$phone.'</td></tr>';
		
		if(!empty($company)){
		$content .= '<tr style="border:1px solid #09F; border-collapse:collapse"><td style="border:1px solid #09F; padding:5px" align="right" >'.$this->data['text_company_catalogue'].'</td><td style="border:1px solid #09F; padding:5px" align="left">'.$company.'</td></tr>';
		}
		
		if(!empty($address)){
		$content .= '<tr style="border:1px solid #09F; border-collapse:collapse"><td style="border:1px solid #09F; padding:5px" align="right" >'.$this->data['text_address_catalogue'].'</td><td style="border:1px solid #09F; padding:5px" align="left">'.$address.'</td></tr>';
		}
		
		if($province){
			$this->load->model('cms/city');
			$city = $this->model_cms_city->getCity($province);
			if(isset($city['name'])){
				$content .= '<tr style="border:1px solid #09F; border-collapse:collapse"><td style="border:1px solid #09F; padding:5px" align="right" >'.$this->data['text_tinh_thanh_pho'].'</td><td style="border:1px solid #09F; padding:5px" align="left">'.$city['name'].'</td></tr>';
			}
		}
		
		if($district){
			$this->load->model('cms/district');
			$district = $this->model_cms_district->getDistrict($district);
			if(isset($district['name'])){
				$content .= '<tr style="border:1px solid #09F; border-collapse:collapse"><td style="border:1px solid #09F; padding:5px" align="right" >'.$this->data['text_tinh_thanh_pho'].'</td><td style="border:1px solid #09F; padding:5px" align="left">'.$district['name'].'</td></tr>';
			}
		}
		
		
		if(count($catalogue)>0){
			$content .= '<tr style="border:1px solid #09F; border-collapse:collapse"><td style="border:1px solid #09F; padding:5px" align="right" >'.$this->data['text_chon_mau_catalogue'].'</td><td style="border:1px solid #09F; padding:5px" align="left">';
			$stt = 1;
			foreach($catalogue as $item){
				$filepdf = $this->model_cms_filepdf->getFilepdf($item);
				if(isset($filepdf['name'])){
					$content .= $stt . '). ' . $filepdf['name'] . '<br>';
					$stt++;
				}
			}
			
			$content .= '</td></tr>';
		}
		
		
		
		$content .= '</table>';
		
		$to = explode(';',$this->config->get('config_email_contact_register'));//_register
		//echo $content; echo $this->data['text_title_catalogue']; echo $this->data['text_sender']; die;
		//return true;
		
		/*============================================================*/
		// Create the Transport
		if($this->config->get('config_mail_protocol')=='smtp'){
			$transport = Swift_SmtpTransport::newInstance($this->config->get('config_smtp_host'), $this->config->get('config_smtp_port'))
			 ->setUsername($this->config->get('config_smtp_username'))
			 ->setPassword($this->config->get('config_smtp_password'))
			 ; 
			 $from = $this->config->get('config_smtp_username');  
			 //$transport->setLocalDomain('112.213.94.88'); 
		}else{
			$transport = Swift_MailTransport::newInstance();
			$from = isset($to[0]) && !empty($to[0]) ? $to[0] : $this->config->get('config_email_contact_register');//$this->config->get('config_email_contact_register');   
			//$from = $this->config->get('config_email_contact_register');   
		}
		
		// Create the Mailer using your created Transport
		$mailer = Swift_Mailer::newInstance($transport);
		
		// Create a message
		$message = Swift_Message::newInstance($this->data['text_title_catalogue'])//subject
			->setFrom(array($from => $this->data['text_sender']))
			->setTo($to)//$this->config->get('config_email_contact_register'))
			->setBody(html_entity_decode($content, ENT_QUOTES, 'UTF-8'),'text/html');

		// Send the message
		$result = $mailer->send($message);
		return $result; 
	}
	
	
	public function recruitment(){
		/*$this->load->model('cms/contact');
		$this->load->model('cms/emailcus');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			if($this->send()){
				//$this->model_cms_emailcus->addEmailCus($this->request->post,0);
				$this->session->data['isThanks'] = true;
				echo "1";
			}else
				echo "0";
		}
		die;*/
		$this->load->model('cms/emailcus');
		$results = array(
			"status" => 400,
			"message" => $this->data['text_recruitment_fail'],
			"info" => array()
		);		
		
		$destination_path = DIR_DOWNLOAD . 'recruitment/';

        require_once(DIR_SYSTEM . 'library/f.php');

        $result = 0;
        $time = time();
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validaterecruitment()) {
			$parts = pathinfo($_FILES['myfile']['name']);
			
			if(isset($parts['extension'])){
	
			if ($parts['extension'] == 'doc' || $parts['extension'] == 'docx'  || $parts['extension'] == 'xls'  || $parts['extension'] == 'xlsx' || $parts['extension'] == 'pdf') {
				$name = explode('.', $parts['basename']);
				$filename = convertAlias($name[0]) . '_' . $time . '.' . $parts['extension'];
	
				$target_path = $destination_path . $filename;
	
				if (@move_uploaded_file($_FILES['myfile']['tmp_name'], $target_path)) {
					$result = 1;
					//$this->model_cms_emailcus->addEmailCus($this->request->post,0, $filename);
					$this->session->data['isThanks'] = true;
					$this->model_cms_emailcus->addUngvien($filename,$this->request->post);
					//$this->model_cms_ungvien->addUngvien($filename,$this->request->post);
					$this->sendrecruitment($filename);
					
					$results = array(
						"status" => 200,
						"message" => $this->data['text_recruitment_success'],
						"info" => array()
					);
				}
			}
			}else{
				//$result = $this->sendrecruitment('');
			}
		}


        sleep(1);
		//echo $results;
		
        echo '<script language="javascript" type="text/javascript">window.top.window.stopUpload(' . json_encode($results) . ');</script>  ';
			
	}
		
	private function validaterecruitment()
	{
		
		if($this->request->post['name']==$this->data['text_name_recruitment'])
			$this->request->post['name'] = "";
		
		if($this->request->post['phone']==$this->data['text_phone_recruitment'])
			$this->request->post['phone'] = "";
			
		if($this->request->post['email']==$this->data['text_email_recruitment'])
			$this->request->post['email'] = "";
			
		
		if(empty($this->request->post['name'])){
			$this->error['name'] = $this->data['error_name_recruitment'];
		}
				
		if(empty($this->request->post['phone'])){
			$this->error['phone'] = $this->data['error_phone_recruitment'];
		}
		
		$pattern = '/^[A-Z0-9._%-]+@[A-Z0-9][A-Z0-9.-]{0,61}[A-Z0-9]\.[A-Z]{2,6}$/i';

    	if ((strlen(utf8_decode($this->request->post['email'])) > 96) || (!preg_match($pattern, $this->request->post['email']))) {
      		$this->error['email'] = $this->data['error_email_recruitment'];
    	}
		
		
		if (!$this->error) {
	  		return TRUE;
		} else {
	  		return FALSE;
		}  	
	}

	private function sendrecruitment($filename = ''){
		
		$content = '';
		$date 			= date("d-m-Y H:i:s");
		$name 			= $this->request->post['name'];
		$phone 			= $this->request->post['phone'];
		$email 			= $this->request->post['email'];
		
		
		$content .='<table style="padding:10px; border:1px solid #09F; border-collapse:collapse" width="100%" border="1" cellspacing="2" cellpadding="2">';
		
		$content .= '<tr style="border:1px solid #09F; border-collapse:collapse"><td style="border:1px solid #09F; padding:5px" align="center" colspan="2"><b>'.$this->data['text_title_recruitment'].'</b></td></tr>';
			
		$content .= '<tr style="border:1px solid #09F; border-collapse:collapse"><td style="border:1px solid #09F; padding:5px" align="right" >'.$this->data['text_name_recruitment'].'</td><td style="border:1px solid #09F; padding:5px" align="left">'.$name.'</td></tr>';
		
		$content .= '<tr style="border:1px solid #09F; border-collapse:collapse"><td style="border:1px solid #09F; padding:5px" align="right" >'.$this->data['text_phone_recruitment'].'</td><td style="border:1px solid #09F; padding:5px" align="left">'.$phone.'</td></tr>';
		
		$content .= '<tr style="border:1px solid #09F; border-collapse:collapse"><td style="border:1px solid #09F; padding:5px" align="right" >'.$this->data['text_email_recruitment'].'</td><td style="border:1px solid #09F; padding:5px" align="left">'.$email.'</td></tr>';	
		
		
		if(!empty($filename)){
		$content .= '<tr style="border:1px solid #09F; border-collapse:collapse"><td style="border:1px solid #09F; padding:5px" align="right" >Download</td><td style="border:1px solid #09F; padding:5px" align="left"><a href="' . HTTP_DOWNLOAD . 'recruitment/' . $filename . '" title="Download">Click vào đây để download file Thông tin ứng viên.</a></td></tr>';
		}
		
		$content .= '</table>';
		//if(!empty($mailto)){
		//	$to = trim($mailto);
		//}else{
			$to = explode(';',$this->config->get('config_email_order'));
		//}
		//echo $content; echo $this->data['text_title_recruitment']; echo $this->data['text_sender']; die;
		//return true;
		
		/*============================================================*/
		// Create the Transport
		if($this->config->get('config_mail_protocol')=='smtp'){
			$transport = Swift_SmtpTransport::newInstance($this->config->get('config_smtp_host'), $this->config->get('config_smtp_port'))
			 ->setUsername($this->config->get('config_smtp_username'))
			 ->setPassword($this->config->get('config_smtp_password'))
			 ; 
			 $from = $this->config->get('config_smtp_username');  
			 //$transport->setLocalDomain('112.213.94.88'); 
		}else{
			$transport = Swift_MailTransport::newInstance();
			$from = isset($to[0]) && !empty($to[0]) ? $to[0] : $this->config->get('config_email_order');//$this->config->get('config_email_contact');   
		}
		
		// Create the Mailer using your created Transport
		$mailer = Swift_Mailer::newInstance($transport);
		
		// Create a message
		$message = Swift_Message::newInstance($this->data['text_title_recruitment'])//subject 
			->setFrom(array($from => $this->data['text_sender'])) //$this->data['text_sender']
			->setTo($to)//$this->config->get('config_email_contact'))
			->setBody(html_entity_decode($content, ENT_QUOTES, 'UTF-8'),'text/html');

		// Send the message
		$result = $mailer->send($message);
		return $result; 
	}
	

	
}
?>
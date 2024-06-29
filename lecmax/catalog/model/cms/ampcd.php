<?php
class ModelCmsAmpcd extends Model {
	
	//Lay dua vao id
	//public function getAmpcd($ampcd_id)	{
	public function getAmpcd($category_id)	{
		$sql = "SELECT * FROM " . DB_PREFIX . "ampcd p LEFT JOIN " . DB_PREFIX . "ampcd_description pd ON (p.ampcd_id = pd.ampcd_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND p.category_id = '" . $category_id . "'";

		$query = $this->db->query($sql);
		$data = array();

		$row = $query->row;
		if(isset($row['ampcd_id'])){

		$data['id'] = $row['ampcd_id'];
		$data['name'] = $row['name'];
		$data['category_id'] = $row['category_id'];
		//2017-02-21T12:00:49+00:00
		$data['date_public'] = date(DATE_ATOM,strtotime($row['date_modified']));
		
		$data['name1'] = str_replace('HTTP_CATALOG',HTTP_SERVER,html_entity_decode($row['name1']));
		$data['href'] = str_replace('HTTP_CATALOG',HTTP_SERVER,html_entity_decode($row['name2']));
		$data['name3'] = str_replace('HTTP_CATALOG',HTTP_SERVER,html_entity_decode($row['name3']));
		$data['desc_short'] = str_replace('HTTP_CATALOG',HTTP_SERVER,html_entity_decode($row['desc_short']));
		
		$data['description'] = str_replace(array('HTTP_CATALOG','<b>','</b>'),array(HTTP_SERVER,'<strong>','</strong>'),html_entity_decode($row['description']));
		preg_match_all('/<img[^>]+>/i',$data['description'], $result); 
		foreach( $result[0] as $img_tag)
		{
			$doc = new DOMDocument();
			$doc->loadHTML($img_tag);
			$xpath = new DOMXPath($doc);
			$src = $xpath->evaluate("string(//img/@src)"); # "/images/image.jpg"
			list($width_orig_e, $height_orig_e) = getimagesize(DIR_IMAGE . str_replace(HTTP_IMAGE, '', $src));
			$data['description'] = str_replace($img_tag,'<amp-img src="' .$src . '" width="1" height="' . $height_orig_e/$width_orig_e . '" layout="responsive" alt=""></amp-img>',html_entity_decode($data['description']));
			
		}
		/*$data['description'] = preg_replace(
    '/<img src="([^"]*)"\s*\/?>/', 
    '<amp-img src="$1" width="800" height="400" layout="responsive" alt=""></amp-img>', 
    $data['description']
);*/

$data['description'] = preg_replace('/ style="(.+?)"/i', "", $data['description']);
$data['description'] = preg_replace('/ style=""/i', "", $data['description']);
		/*echo htmlentities(preg_replace(
    '/<img src="([^"]*)"\s*alt="([^"]*)"\s*\/?>/', 
    '<amp-img src="$1" width="800" height="684" layout="responsive" alt="$2"></amp-img>', 
    'agdasd dsag fdslafj afladsjfl asd<br><img src="apa.png" alt="sadfdsa" /><br>hi bro <img src="c.png" alt="aaaaaa" />'
));*/

		$data['description1'] = str_replace(array('HTTP_CATALOG','<b>','</b>'),array(HTTP_SERVER,'<strong>','</strong>'),html_entity_decode($row['description1']));
		$data['image'] = empty($row['image']) || !is_file(DIR_IMAGE . $row['image'])?'': HTTP_IMAGE . str_replace(' ', '%20', $row['image']);
		$data['img_width'] = 1;
		$data['img_height'] = 1;
		$data['img_ratio'] = 1;
		if(!empty($data['image'])){
		list($width_orig, $height_orig) = getimagesize(DIR_IMAGE . str_replace(' ', '%20', $row['image']));
		$data['img_width'] = $width_orig;
		$data['img_height'] = $height_orig;
		$data['img_ratio'] = $height_orig/$width_orig;
		}
		
		$data['image_width'] = 1;
		$data['image_height'] = 1;
		$data['image_ratio'] = 1;
		$data['image_1x'] = empty($row['image_1x']) || !is_file(DIR_IMAGE . $row['image_1x'])?'': HTTP_IMAGE . str_replace(' ', '%20', $row['image_1x']);
		if(!empty($data['image_1x'])){
		list($width_orig, $height_orig) = getimagesize(DIR_IMAGE . str_replace(' ', '%20', $row['image_1x']));
		$data['image_width'] = $width_orig;
		$data['image_height'] = $height_orig;
		$data['image_ratio'] = $height_orig/$width_orig;
		}
    	//$data['image1'] = empty($row['image1'])? '' : HTTP_IMAGE . str_replace(' ', '%20', $row['image1']);
		
		$this->load->model('cms/common');
		//$this->load->model('cms/project');
		//$this->load->model('cms/business');
		
		$pagelist = (!empty($row['pagelist'])?unserialize($row['pagelist']):array());
		$data['amp_categories'] = array();
		foreach($pagelist as $item){
			$temp = $this->model_cms_common->getIntro($item);
			if(isset($temp['category_id'])){
				$data['amp_categories'][] = $item;
			}
		}
		
		/*if($category_id==ID_SHAREHOLDER){
			$pagelistcodong = (!empty($row['pagelistcodong'])?unserialize($row['pagelistcodong']):array());
			$data['amp_pagelistcodong'] = array();
			$this->load->model('cms/shareholder');
			foreach($pagelistcodong as $item){
				$temp = $this->model_cms_common->getIntro($item);
				
				if(isset($temp['category_id'])){
					$shareholder = $this->model_cms_shareholder->getShareholderByCate($item);
					$years = $this->model_cms_shareholder->getYearByCate($item);
					$arr_temp = array_merge($temp,array('shareholders'=>$shareholder), array('years'=>$years));
					$data['amp_pagelistcodong'][] = $arr_temp;
				}
			}
			//print_r($data['amp_pagelistcodong']);
		}else*/if($category_id==ID_PROJECT || $category_id==ID_HOME){
		
			$pagelistproject = (!empty($row['pagelistproject'])?unserialize($row['pagelistproject']):array());
			$data['amp_projects'] = array();
			$data['amp_pagelistprojects'] = array();
			foreach($pagelistproject as $item){
				$temp = $this->getProjectAmp($item);
				//print_r($temp);
				if(isset($temp['id'])){
					$data['amp_projects'][] = $item;
					$data['amp_pagelistprojects'][] = $temp;
				}
			}
			//print_r($data['amp_pagelistprojects']);
		}elseif($category_id==ID_PRODUCT){
		
			$pagelistproduct = (!empty($row['pagelistproduct'])?unserialize($row['pagelistproduct']):array());
			$data['amp_products'] = array();
			$data['amp_pagelistproducts'] = array();
			foreach($pagelistproduct as $item){
				$temp = $this->getProductAmp($item);
				//print_r($temp);
				if(isset($temp['id'])){
					$data['amp_products'][] = $item;
					$data['amp_pagelistproducts'][] = $temp;
				}
			}
			//print_r($data['amp_pagelistproducts']);
		}/*elseif($category_id==ID_SERVICE){
		
			$pagelistservice = (!empty($row['pagelistservice'])?unserialize($row['pagelistservice']):array());
			$data['amp_services'] = array();
			$data['amp_pagelistservices'] = array();
			foreach($pagelistservice as $item){
				$temp = $this->getServiceAmp($item);
				//print_r($temp);
				if(isset($temp['id'])){
					$data['amp_services'][] = $item;
					$data['amp_pagelistservices'][] = $temp;
				}
			}
			//print_r($data['amp_pagelistservices']);
		}*/elseif($category_id==ID_SOLUTION){
		
			$pagelistsolution = (!empty($row['pagelistsolution'])?unserialize($row['pagelistsolution']):array());
			$data['amp_solutions'] = array();
			$data['amp_pagelistsolutions'] = array();
			foreach($pagelistsolution as $item){
				$temp = $this->getSolutionAmp($item);
				//print_r($temp);
				if(isset($temp['id'])){
					$data['amp_solutions'][] = $item;
					$data['amp_pagelistsolutions'][] = $temp;
				}
			}
			//print_r($data['amp_pagelistsolutions']);
		}/*elseif($category_id==ID_BRAND){
		
			$pagelistbrand = (!empty($row['pagelistbrand'])?unserialize($row['pagelistbrand']):array());
			$data['amp_brands'] = array();
			$data['amp_pagelistbrands'] = array();
			foreach($pagelistbrand as $item){
				$temp = $this->getBrandAmp($item);
				//print_r($temp);
				if(isset($temp['id'])){
					$data['amp_brands'][] = $item;
					$data['amp_pagelistbrands'][] = $temp;
				}
			}
			//print_r($data['amp_pagelistbrands']);
		}*//*elseif($category_id==ID_PARTNER){
			$pagelistlistpartner = (!empty($row['pagelistlistpartner'])?unserialize($row['pagelistlistpartner']):array());
			$data['amp_listpartners'] = array();
			$data['amp_pagelistlistpartners'] = array();
			foreach($pagelistlistpartner as $item){
				$temp = $this->getListpartnerAmp($item);
				//print_r($temp);
				if(isset($temp['id'])){
					$data['amp_listpartners'][] = $item;
					$data['amp_pagelistlistpartners'][] = $temp;
				}
			}
		}*/elseif($category_id==ID_NEWS){
			$pagelistnews = (!empty($row['pagelistnews'])?unserialize($row['pagelistnews']):array());
			$data['amp_newss'] = array();
			$data['amp_pagelistnewss'] = array();
			foreach($pagelistnews as $item){
				$temp = $this->getNewsAmp($item);
				//print_r($temp);
				if(isset($temp['id'])){
					$data['amp_newss'][] = $item;
					$data['amp_pagelistnewss'][] = $temp;
				}
			}
		}/*elseif($category_id==ID_BUSINESS){
		
			$pagelistbusiness = (!empty($row['pagelistbusiness'])?unserialize($row['pagelistbusiness']):array());
			$data['amp_businesss'] = array();
			$data['amp_pagelistbusinesss'] = array();
			foreach($pagelistbusiness as $item){
				$temp = $this->getBusinessAmp($item);//$this->model_cms_business->getService($item);
				if(isset($temp['id'])){
					$data['amp_businesss'][] = $item;
					$data['amp_pagelistbusinesss'][] = $temp;
				}
			}
		}*/elseif($category_id==ID_RECRUITMENT){
		
			$pagelistrecruitment = (!empty($row['pagelistrecruitment'])?unserialize($row['pagelistrecruitment']):array());
			$data['amp_recruitments'] = array();
			$data['amp_pagelistrecruitments'] = array();
			foreach($pagelistrecruitment as $item){
				$temp = $this->getRecruitmentAmp($item);//$this->model_cms_recruitment->getService($item);
				if(isset($temp['id'])){
					$data['amp_recruitments'][] = $item;
					$data['amp_pagelistrecruitments'][] = $temp;
				}
			}
		}/*elseif($category_id==ID_SHOWROOM){
			$pagelistshowroom = (!empty($row['pagelistshowroom'])?unserialize($row['pagelistshowroom']):array());
			$data['amp_pagelistshowroom'] = $pagelistshowroom;
		}*/elseif($category_id==ID_CONTACT){
			$pagelistcontact = (!empty($row['pagelistcontact'])?unserialize($row['pagelistcontact']):array());
			$data['amp_pagelistcontact'] = $pagelistcontact;
		}elseif($category_id==ID_ABOUTUS){
			$pagelistaboutus = (!empty($row['pagelistaboutus'])?unserialize($row['pagelistaboutus']):array());
			$data['amp_aboutuss'] = array();
			$data['amp_pagelistaboutuss'] = array();
			foreach($pagelistaboutus as $item){
				$temp = $this->getAboutusAmp($item);
				//print_r($temp);
				if(isset($temp['id'])){
					$data['amp_aboutuss'][] = $item;
					$data['amp_pagelistaboutuss'][] = $temp;
				}
			}
			//$data['amp_pagelistaboutus'] = $pagelistaboutus;
		}
    
    	$data['meta_title'] = empty($row['meta_title'])?$row['name']:$row['meta_title'];
		$data['meta_keyword'] = $row['meta_keyword'];
		$data['meta_description'] = $row['meta_description'];
		
		$data['image_og'] = $row['image_og'];
		$data['meta_title_og'] = empty($row['meta_title_og'])?$row['meta_title']:$row['meta_title_og'];
		$data['meta_description_og'] = empty($row['meta_description_og'])?$row['meta_description']:$row['meta_description_og'];
		}
		/*{FRONTEND_DATA_ROW}*/
		return $data;
	}
	
	public function getAboutusAmp($aboutus_id=0)	{
		$this->load->model('cms/common');
		$this->load->model('cms/aboutus');
		$sql = "SELECT * FROM " . DB_PREFIX . "aboutus p LEFT JOIN " . DB_PREFIX . "aboutus_description pd ON (p.aboutus_id = pd.aboutus_id) WHERE p.status='1' AND p.aboutus_id='$aboutus_id' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND pd.name<>'' ORDER BY p.sort_order ASC, p.aboutus_id DESC";
		
		if(isset($_SESSION['scaleimg']) && $_SESSION['scaleimg']=='1'){
			$folder = HTTP_IMAGE_MOBILE;
			$folder_dir = DIR_IMAGE_MOBILE;
			$img_temp = PATH_IMAGE_THUMB_MOBILE;
		}else{
			$folder = HTTP_IMAGE;
			$folder_dir = DIR_IMAGE;
			$img_temp = PATH_IMAGE_THUMB;
		}

		$query = $this->db->query($sql);
		//$data1 = array();
		$data = array();
		$row = $query->row;
		if(isset($row['aboutus_id'])){
			
			$data['id'] = $row['aboutus_id'];
			$data['name'] = $row['name'];
			$data['desc_short'] = $row['desc_short'];
			
			$search  = array('<br>', '<br />', '<br/>');
			$replace = array('</p></li><li><p>', '</p></li><li><p>', '</p></li><li><p>');
			$des = str_replace($search,$replace,html_entity_decode(nl2br($row['desc_short'])));
			$checkdes = strip_tags($des);
			$data['desc_short_nltoli'] = !empty($checkdes)?$des:'';
			
			//$data['href'] = $this->url->link('cms/aboutus','path='. $this->model_cms_common->getPath($row['category_id']) . '&aboutus_id='.$row['aboutus_id'],$this->config->get('config_language')) .'.html';
			
			//$data['description'] = str_replace(array('HTTP_CATALOG','<b>','</b>'),array(HTTP_SERVER,'<strong>','</strong>'),html_entity_decode($row['description']));
			
			$data['description'] = str_replace(array('HTTP_CATALOG','<b>','</b>'),array(HTTP_SERVER,'<strong>','</strong>'),html_entity_decode($row['description']));
		
		preg_match_all('/<img[^>]+>/i',$data['description'], $result); 

		foreach( $result[0] as $img_tag)
		{
			$doc = new DOMDocument();
			$doc->loadHTML($img_tag);
			$xpath = new DOMXPath($doc);
			$src = $xpath->evaluate("string(//img/@src)"); # "/images/image.jpg"
			
			list($width_orig_e, $height_orig_e) = getimagesize(DIR_IMAGE . str_replace(HTTP_IMAGE, '', $src));
			
			$data['description'] = str_replace($img_tag,'<amp-img src="' .$src . '" width="1" height="' . $height_orig_e/$width_orig_e . '" layout="responsive" alt=""></amp-img>',html_entity_decode($data['description']));
			
		}
		
		$data['description'] = preg_replace('/ style="(.+?)"/i', "", $data['description']);
		$data['description'] = preg_replace('/ style=""/i', "", $data['description']);
		
		$data['description1'] = str_replace(array('HTTP_CATALOG','<b>','</b>'),array(HTTP_SERVER,'<strong>','</strong>'),html_entity_decode($row['description1']));
		preg_match_all('/<img[^>]+>/i',$data['description1'], $result); 
		foreach( $result[0] as $img_tag)
		{
			$doc = new DOMDocument();
			$doc->loadHTML($img_tag);
			$xpath = new DOMXPath($doc);
			$src = $xpath->evaluate("string(//img/@src)"); # "/images/image.jpg"
			
			list($width_orig_e, $height_orig_e) = getimagesize(DIR_IMAGE . str_replace(HTTP_IMAGE, '', $src));
			
			$data['description1'] = str_replace($img_tag,'<amp-img src="' .$src . '" width="1" height="' . $height_orig_e/$width_orig_e . '" layout="responsive" alt=""></amp-img>',html_entity_decode($data['description1']));
			
		}
		$data['description1'] = preg_replace('/ style="(.+?)"/i', "", $data['description1']);
		$data['description1'] = preg_replace('/ style=""/i', "", $data['description1']);
		

			//$data['image'] = empty($row['image'])?'': HTTP_IMAGE . str_replace(' ', '%20', $row['image']);
			$data['image'] = empty($row['image'])?'': HTTP_IMAGE . str_replace(' ', '%20', $row['image']);
			//$data['image_1x'] = empty($row['image_x'])?'': HTTP_IMAGE . str_replace(' ', '%20', $row['image_x']);
			
			//list($width_orig, $height_orig) = getimagesize(DIR_IMAGE . str_replace(' ', '%20', $row['image_x']));
			$data['image_width'] = $data['image_height'] = $data['image_ratio'] = 1;
			if(!empty($data['image'])){
			list($width_orig, $height_orig) = getimagesize(DIR_IMAGE . str_replace(' ', '%20', $row['image']));
			$data['image_width'] = $width_orig;
			$data['image_height'] = $height_orig;
			$data['image_ratio'] = $height_orig/$width_orig;
			}
    
			//$data['pdf'] = empty($row['pdf'])? '' : HTTP_PDF . $row['pdf'];
		
			//$data['images'] = $this->getImages($data['id']);
			//$data['imagebrochures'] = $this->getBrochures($data['id']);
			
			
			$data['name2'] = $row['name2'];
			$data['address'] = $row['address'];
			$data['chucvu'] = $row['address'];
			$data['hoten'] = $row['desc_short'];
			
			$data['gioitinh'] = $row['gioitinh'];
			
			$data['phone'] = $row['phone'];
			$data['email'] = $row['email'];
			$data['fax'] = $row['fax'];
			$search = array(' ', '.', ':', '-', '_', '(', ')', ',', ';');
			$replace = array('', '', '', '', '', '', '', '', '');
			$data['phone_tel'] = str_replace($search,$replace,$row['phone']);
			$data['fax_tel'] = str_replace($search,$replace,$row['fax']);
			
			$data['desc_short'] = nl2br($row['desc_short']);
			if($row['cate']==1){
				$search  = array('<div>', '</div>', '<b>', '<b ', '</b>', 'HTTP_CATALOG','<br>','<p>','</p>');
				$replace = array('', '', '<strong>', '<strong ', '</strong>', HTTP_SERVER,'','','');
			}else{
				$search  = array('<div>', '</div>', '<p>', '</p>', '<b>', '</b>', 'HTTP_CATALOG');
				$replace = array('', '', '', '', '<strong>', '</strong>', HTTP_SERVER);
			}
			$desc_short = strip_tags(html_entity_decode($row['desc_short']));
			$data['desc_short'] = !empty($desc_short)?str_replace($search,$replace,html_entity_decode($row['desc_short'])):'';
			
			$search  = array('<div>', '</div>', '<p>', '</p>', '<b>', '</b>', 'HTTP_CATALOG');
			$replace = array('', '', '', '', '<strong>', '</strong>', HTTP_SERVER);
			$desc_short1 = strip_tags(html_entity_decode($row['desc_short1']));
			$data['desc_short1'] = !empty($desc_short1)?str_replace($search,$replace,html_entity_decode($row['desc_short1'])):'';
			
			$data['image1'] = empty($row['image1']) || !is_file($folder_dir . $row['image1'])?'': str_replace(' ', '%20', $row['image1']);

			$data['image2'] = empty($row['image2']) || !is_file($folder_dir . $row['image2'])?'': str_replace(' ', '%20', $row['image2']);
			
			$data['image_sodo'] = ($this->config->get('config_language_id')==1)?$data['image2']:$data['image1'];
			$data['image_sodo_width'] = $data['image_sodo_width'] = $data['image_sodo_width'] = 1;
			if(!empty($data['image_sodo'])){
			list($width_orig, $height_orig) = getimagesize(DIR_IMAGE . str_replace(' ', '%20', $data['image_sodo']));
			$data['image_sodo_width'] = $width_orig;
			$data['image_sodo_height'] = $height_orig;
			$data['image_sodo_ratio'] = $height_orig/$width_orig;
			}
			
			$data['image_video'] = empty($row['image_video']) || !is_file(DIR_IMAGE . $row['image_video'])?'': str_replace(' ', '%20', $row['image_video']);
			$data['isyoutube'] = $row['isyoutube'];
			$data['script'] = html_entity_decode($row['script']);
			$data['filename_mp4'] = !empty($row['filename_mp4']) && is_file(DIR_DOWNLOAD . $row['filename_mp4'])?$row['filename_mp4']:'';
			
			$data['videoyoutubeid'] = getYoutubeVideoId(html_entity_decode($row['script']));
			
			$data['images'] = $this->model_cms_aboutus->getImages($data['id']);
			if($row['cate']==0 || $row['cate']==12 || $row['cate']==93){
			$data['child'] = $this->getAboutusByParent(ID_ABOUTUS, $data['id']);
			}
		
			$data['meta_title'] = empty($row['meta_title'])?$row['name']:$row['meta_title'];
			$data['meta_keyword'] = $row['meta_keyword'];
			$data['meta_description'] = $row['meta_description'];
			
			$data['image_og'] = $row['image_og'];
			$data['meta_title_og'] = empty($row['meta_title_og'])?$row['meta_title']:$row['meta_title_og'];
			$data['meta_description_og'] = empty($row['meta_description_og'])?$row['meta_description']:$row['meta_description_og'];
		
			/*{FRONTEND_DATA_ROW}*/
			//$data1[] = $data;
		}

		return $data;
	}
	
	//Lay tat ca
	public function getAboutusByParent($category_id=0, $parent_id=0)	{
		$sql = "SELECT * FROM " . DB_PREFIX . "aboutus p LEFT JOIN " . DB_PREFIX . "aboutus_description pd ON (p.aboutus_id = pd.aboutus_id) WHERE p.status='1' AND p.cate='$parent_id' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND pd.name<>'' ORDER BY p.sort_order ASC, p.aboutus_id DESC";

		$query = $this->db->query($sql);
		$data1 = array();
		
		if(isset($_SESSION['scaleimg']) && $_SESSION['scaleimg']=='1'){
			$folder = HTTP_IMAGE_MOBILE;
			$folder_dir = DIR_IMAGE_MOBILE;
			$img_temp = PATH_IMAGE_THUMB_MOBILE;
		}else{
			$folder = HTTP_IMAGE;
			$folder_dir = DIR_IMAGE;
			$img_temp = PATH_IMAGE_THUMB;
		}

		foreach($query->rows as $row){
			$data = array();
			$data['id'] = $row['aboutus_id'];
			$data['name'] = $row['name'];
			//$data['class'] = $row['class'];
			$name2 = strip_tags(html_entity_decode($row['name2']));
			//$data['name2'] = !empty($name2)? html_entity_decode($row['name2']):'';
			//$name1 = strip_tags(html_entity_decode($row['name1']));
			//$data['name1'] = !empty($name1)? html_entity_decode($row['name1']):'';//!empty($row['name1'])? html_entity_decode($row['name1']):$row['name'];
			
			$search  = array('<div>', '</div>', '<p>', '</p>', '<b>', '</b>', 'HTTP_CATALOG');
			$replace = array('', '', '', '', '<strong>', '</strong>', HTTP_SERVER);
			$name1 = strip_tags(html_entity_decode($row['name1']));
			$data['name1'] = !empty($name1)?str_replace($search,$replace,html_entity_decode($row['name1'])):'';
			//$data['emaillist_infobox'] = !empty($emaillist)?str_replace($search,$replace,($row['emaillist'])):'';
			
			$data['name2'] = $row['name2'];
			$data['address'] = $row['address'];
			$data['chucvu'] = $row['address'];
			$data['hoten'] = $row['desc_short'];
			
			$data['gioitinh'] = $row['gioitinh'];
			
			$data['phone'] = $row['phone'];
			$data['email'] = $row['email'];
			$data['fax'] = $row['fax'];
			$search = array(' ', '.', ':', '-', '_', '(', ')', ',', ';');
			$replace = array('', '', '', '', '', '', '', '', '');
			$data['phone_tel'] = str_replace($search,$replace,$row['phone']);
			$data['fax_tel'] = str_replace($search,$replace,$row['fax']);
			
			$data['desc_short'] = nl2br($row['desc_short']);
			if($row['cate']==1){
				$search  = array('<div>', '</div>', '<b>', '<b ', '</b>', 'HTTP_CATALOG','<br>','<p>','</p>');
				$replace = array('', '', '<strong>', '<strong ', '</strong>', HTTP_SERVER,'','','');
			}else{
				$search  = array('<div>', '</div>', '<p>', '</p>', '<b>', '</b>', 'HTTP_CATALOG');
				$replace = array('', '', '', '', '<strong>', '</strong>', HTTP_SERVER);
			}
			$desc_short = strip_tags(html_entity_decode($row['desc_short']));
			$data['desc_short'] = !empty($desc_short)?str_replace($search,$replace,html_entity_decode($row['desc_short'])):'';
			
			$search  = array('<div>', '</div>', '<p>', '</p>', '<b>', '</b>', 'HTTP_CATALOG');
			$replace = array('', '', '', '', '<strong>', '</strong>', HTTP_SERVER);
			$desc_short1 = strip_tags(html_entity_decode($row['desc_short1']));
			$data['desc_short1'] = !empty($desc_short1)?str_replace($search,$replace,html_entity_decode($row['desc_short1'])):'';
			
			$data['pdf'] = empty($row['pdf']) || !is_file(DIR_PDF . $row['pdf'])?'': $row['pdf'];

			/*if(isset($row['category_id']))
				$data['href'] = $this->url->link('cms/aboutus','path='. $category_id .'_' . $row['category_id'] . '&aboutus_id='.$row['aboutus_id']) .'.html';
			else
				$data['href'] = $this->url->link('cms/aboutus','path='. $category_id . '&aboutus_id='.$row['aboutus_id']) .'.html';*/
			
			if(isset($row['category_id']))
				$data['href'] = str_replace(HTTP_SERVER,'HTTP_SERVER',$this->url->link('cms/aboutus','path='. $category_id .'_' . $row['category_id'] . '&aboutus_id='.$row['aboutus_id'],$this->config->get('config_language')) .'.html');
			else
				$data['href'] = str_replace(HTTP_SERVER,'HTTP_SERVER',$this->url->link('cms/aboutus','path='. $category_id . '&aboutus_id='.$row['aboutus_id'],$this->config->get('config_language')) .'.html');

			
			$search  = array('<div', '</div>', '<b>', '<b ', '</b>','<br></i></p>','<br></u></p>','<br></span></p>','<br></p>');
			$replace = array('<p', '</p>', '<strong>', '<strong ', '</strong>','</i></p>','</u></p>','</span></p>','</p>');
			$des = str_replace($search,$replace,html_entity_decode($row['description']));
			//$des = str_replace('HTTP_CATALOG',HTTP_SERVER,html_entity_decode($row['description']));
			$checkdes = strip_tags($des);
			$data['description'] = !empty($checkdes)?$des:'';
			
			$search  = array('<div', '</div>', '<b>', '<b ', '</b>','<br></i></p>','<br></u></p>','<br></span></p>','<br></p>');
			$replace = array('<p', '</p>', '<strong>', '<strong ', '</strong>','</i></p>','</u></p>','</span></p>','</p>');
			$des = str_replace($search,$replace,html_entity_decode($row['description1']));
			$checkdes = strip_tags($des);
			$data['description1'] = !empty($checkdes)?$des:'';
			
			preg_match('/<img.+src=[\'"](?P<src>[^\s\'"]*)[\'"].?.*>/i', $data['description'], $image);
			$data['image'] = empty($row['image']) || !is_file($folder_dir . $row['image'])?'': str_replace(' ', '%20', $row['image']);
			//$data['image'] = empty($data['image'])&&isset($image['src'])&& !empty($image['src'])?$image['src']:$data['image'];
			//$data['image'] = empty($data['image'])?$img_temp:$data['image'];
			
			$data['image_width'] = $data['image_height'] = $data['image_ratio'] = 1;
			if(!empty($data['image'])){
			list($width_orig, $height_orig) = getimagesize(DIR_IMAGE . str_replace(' ', '%20', $row['image']));
			$data['image_width'] = $width_orig;
			$data['image_height'] = $height_orig;
			$data['image_ratio'] = $height_orig/$width_orig;
			}
			
			$data['image1'] = empty($row['image1']) || !is_file($folder_dir . $row['image1'])?'': str_replace(' ', '%20', $row['image1']);
			//$data['image1'] = empty($data['image1'])&&isset($image['src'])&& !empty($image['src'])?$image['src']:$data['image1'];
			//$data['image1'] = empty($data['image1'])?$img_temp:$data['image1'];
			
			$data['image2'] = empty($row['image2']) || !is_file($folder_dir . $row['image2'])?'': str_replace(' ', '%20', $row['image2']);
			//$data['image2'] = empty($data['image2'])&&isset($image['src'])&& !empty($image['src'])?$image['src']:$data['image2'];
			//$data['image2'] = empty($data['image2'])?$img_temp:$data['image2'];
			
			$data['image_sodo'] = ($this->config->get('config_language_id')==1)?$data['image2']:$data['image1'];
			
			$data['image_video'] = empty($row['image_video']) || !is_file(DIR_IMAGE . $row['image_video'])?'': str_replace(' ', '%20', $row['image_video']);
			$data['isyoutube'] = $row['isyoutube'];
			
			
			$data['script'] = html_entity_decode($row['script']);
			$data['script'] = preg_replace('/ width="(.+?)"/i', " ", $data['script']);
			$data['script'] = preg_replace('/ height="(.+?)"/i', " ", $data['script']);
			$data['script'] = str_replace(array('<iframe','</iframe>'), array('<amp-iframe width="480" height="270" sandbox="allow-scripts allow-same-origin allow-presentation" ','</amp-iframe>'), $data['script']);
			
			$data['filename_mp4'] = !empty($row['filename_mp4']) && is_file(DIR_DOWNLOAD . $row['filename_mp4'])?$row['filename_mp4']:'';
			
			$data['videoyoutubeid'] = getYoutubeVideoId(html_entity_decode($row['script']));
			
			//$data['href_album'] = HTTP_SERVER . 'view-album-aboutus.html?id=' . $row['aboutus_id'];
			//$data['href_video'] = HTTP_SERVER . 'view-video-aboutus.html?id=' . $row['aboutus_id'];
		
			$data['images'] = $this->model_cms_aboutus->getImages($data['id']);
			if($row['cate']==0 || $row['cate']==12 || $row['cate']==93){
			$data['child'] = $this->getAboutusByParent($category_id, $data['id']);
			}
			
			$search  = array('<br>', '<br />', '<br/>');
			$replace = array('</p><li>', '</p><li>', '</p><li>');
			$des = str_replace($search,$replace,html_entity_decode(nl2br($row['desc_short'])));
			//$des = str_replace('HTTP_CATALOG',HTTP_SERVER,html_entity_decode($row['description']));
			$checkdes = strip_tags($des);
			$data['desc_short_nltoli'] = !empty($checkdes)?$des:'';
		
			$data['meta_title'] = empty($row['meta_title'])?$row['name']:$row['meta_title'];
			$data['meta_keyword'] = $row['meta_keyword'];
			$data['meta_description'] = $row['meta_description'];
			
			$data['image_og'] = $row['image_og'];
			$data['meta_title_og'] = empty($row['meta_title_og'])?$row['meta_title']:$row['meta_title_og'];
			$data['meta_description_og'] = empty($row['meta_description_og'])?$row['meta_description']:$row['meta_description_og'];
		
			/*{FRONTEND_DATA_ROW}*/
			$data1[] = $data;
		}

		return $data1;
	}
	
	public function getProjectAmp($project_id=0)	{
		$this->load->model('cms/common');
		$sql = "SELECT * FROM " . DB_PREFIX . "project p LEFT JOIN " . DB_PREFIX . "project_description pd ON (p.project_id = pd.project_id) WHERE p.status='1' AND p.project_id='$project_id' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND pd.name<>'' ORDER BY p.category_id ASC, p.sort_order ASC, p.project_id DESC";

		$query = $this->db->query($sql);
		//$data1 = array();
		$data = array();
		$row = $query->row;
		if(isset($row['project_id'])){
			
			$data['id'] = $row['project_id'];
			$data['name'] = $row['name'];
			//$data['desc_short'] = $row['desc_short'];
			//$data['website'] = str_replace('HTTP_CATALOG',HTTP_SERVER,$row['website']);
			
			$data['category_id'] = $row['category_id'];

			//$data['href'] = $this->url->link('cms/project','path='. $this->model_cms_common->getPath($row['category_id']) . '&project_id='.$row['project_id'],$this->config->get('config_language')) .'.html';
			$data['href'] = $this->url->link('cms/project','path='. ID_PROJECT . '&project_id='.$row['project_id'],$this->config->get('config_language')) .'.html';
			
			$data['description'] = str_replace(array('HTTP_CATALOG','<b>','</b>'),array(HTTP_SERVER,'<strong>','</strong>'),html_entity_decode($row['description']));
			//$data['image'] = empty($row['image'])?'': HTTP_IMAGE . str_replace(' ', '%20', $row['image']);
			$data['image'] = empty($row['image'])?'': HTTP_IMAGE . str_replace(' ', '%20', $row['image']);
			$data['image_1x'] = $data['image'];//empty($row['image_x'])?'': HTTP_IMAGE . str_replace(' ', '%20', $row['image_x']);
			
			//list($width_orig, $height_orig) = getimagesize(DIR_IMAGE . str_replace(' ', '%20', $row['image_x']));
			list($width_orig, $height_orig) = getimagesize(DIR_IMAGE . str_replace(' ', '%20', $row['image']));
			$data['image_width'] = $width_orig;
			$data['image_height'] = $height_orig;
			$data['image_ratio'] = $height_orig/$width_orig;
    
			//$data['pdf'] = empty($row['pdf'])? '' : HTTP_PDF . $row['pdf'];
		
			//$data['images'] = $this->getImages($data['id']);
			//$data['imagebrochures'] = $this->getBrochures($data['id']);
		
			$data['meta_title'] = empty($row['meta_title'])?$row['name']:$row['meta_title'];
			$data['meta_keyword'] = $row['meta_keyword'];
			$data['meta_description'] = $row['meta_description'];
			
			$data['image_og'] = $row['image_og'];
			$data['meta_title_og'] = empty($row['meta_title_og'])?$row['meta_title']:$row['meta_title_og'];
			$data['meta_description_og'] = empty($row['meta_description_og'])?$row['meta_description']:$row['meta_description_og'];
		
			/*{FRONTEND_DATA_ROW}*/
			//$data1[] = $data;
		}

		return $data;
	}
	
	public function getProjectsAmp($category_id=0)	{
		$sql = "SELECT * FROM " . DB_PREFIX . "project p LEFT JOIN " . DB_PREFIX . "project_description pd ON (p.project_id = pd.project_id) WHERE p.status='1' AND p.isnew='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND pd.name<>'' ORDER BY p.sort_order ASC, p.project_id DESC LIMIT 12";

		$query = $this->db->query($sql);
		$data1 = array();
		
		/*if(isset($_SESSION['scaleimg']) && $_SESSION['scaleimg']=='1'){
			$folder = HTTP_IMAGE_MOBILE;
		}else{
			$folder = HTTP_IMAGE;
		}*/

		foreach($query->rows as $row){
			$data = array();
			$data['id'] = $row['project_id'];
			$data['name'] = $row['name'];
			$data['desc_short'] = $row['desc_short'];
			$data['website'] = str_replace('HTTP_CATALOG',HTTP_SERVER,$row['website']);
			
			$data['category_id'] = $row['category_id'];

			if(isset($row['category_id']))
				$data['href'] = $this->url->link('cms/project','path='. $category_id .'_' . $row['category_id'] . '&project_id='.$row['project_id'],$this->config->get('config_language')) .'.html';
			else
				$data['href'] = $this->url->link('cms/project','path='. $category_id . '&project_id='.$row['project_id'],$this->config->get('config_language')) .'.html';

			$data['description'] = str_replace(array('HTTP_CATALOG','<b>','</b>'),array(HTTP_SERVER,'<strong>','</strong>'),html_entity_decode($row['description']));
			//$data['image'] = empty($row['image'])?'': HTTP_IMAGE . str_replace(' ', '%20', $row['image']);
			$data['image'] = empty($row['image2'])?'': HTTP_IMAGE . str_replace(' ', '%20', $row['image2']);
			$data['image_1x'] = empty($row['image_1x'])?'': HTTP_IMAGE . str_replace(' ', '%20', $row['image_1x']);
			
			list($width_orig, $height_orig) = getimagesize(DIR_IMAGE . str_replace(' ', '%20', $row['image_1x']));
			$data['image_width'] = $width_orig;
			$data['image_height'] = $height_orig;
			$data['image_ratio'] = $height_orig/$width_orig;
    
			//$data['pdf'] = empty($row['pdf'])? '' : HTTP_PDF . $row['pdf'];
		
			//$data['images'] = $this->getImages($data['id']);
			//$data['imagebrochures'] = $this->getBrochures($data['id']);
		
			$data['meta_title'] = empty($row['meta_title'])?$row['name']:$row['meta_title'];
			$data['meta_keyword'] = $row['meta_keyword'];
			$data['meta_description'] = $row['meta_description'];
			
			$data['image_og'] = $row['image_og'];
			$data['meta_title_og'] = empty($row['meta_title_og'])?$row['meta_title']:$row['meta_title_og'];
			$data['meta_description_og'] = empty($row['meta_description_og'])?$row['meta_description']:$row['meta_description_og'];
		
			/*{FRONTEND_DATA_ROW}*/
			$data1[] = $data;
		}

		return $data1;
	}
	
	public function getProjectsPageClientAmp($category_id=0)	{
		$sql = "SELECT * FROM " . DB_PREFIX . "project p LEFT JOIN " . DB_PREFIX . "project_description pd ON (p.project_id = pd.project_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND pd.name<>'' ORDER BY p.sort_order ASC, p.project_id DESC";

		$query = $this->db->query($sql);
		$data1 = array();
		
		/*if(isset($_SESSION['scaleimg']) && $_SESSION['scaleimg']=='1'){
			$folder = HTTP_IMAGE_MOBILE;
		}else{
			$folder = HTTP_IMAGE;
		}*/

		foreach($query->rows as $row){
			$data = array();
			$data['id'] = $row['project_id'];
			$data['name'] = $row['name'];
			//$data['desc_short'] = $row['desc_short'];
			$data['desc_short'] = $row['desc_short_amp'];
			$data['desc_short_main'] = $row['desc_short'];
			$data['website'] = str_replace('HTTP_CATALOG',HTTP_SERVER,$row['website']);
			
			$data['category_id'] = $row['category_id'];

			if(isset($row['category_id']))
				$data['href'] = $this->url->link('cms/project','path='. $category_id .'_' . $row['category_id'] . '&project_id='.$row['project_id'],$this->config->get('config_language')) .'.html';
			else
				$data['href'] = $this->url->link('cms/project','path='. $category_id . '&project_id='.$row['project_id'],$this->config->get('config_language')) .'.html';

			$data['description'] = str_replace(array('HTTP_CATALOG','<b>','</b>'),array(HTTP_SERVER,'<strong>','</strong>'),html_entity_decode($row['description']));
			//$data['image'] = empty($row['image'])?'': HTTP_IMAGE . str_replace(' ', '%20', $row['image']);
			$data['image'] = empty($row['image2'])?'': HTTP_IMAGE . str_replace(' ', '%20', $row['image2']);
			$data['image_1x'] = empty($row['image_1x'])?'': HTTP_IMAGE . str_replace(' ', '%20', $row['image_1x']);
			
			list($width_orig, $height_orig) = getimagesize(DIR_IMAGE . str_replace(' ', '%20', $row['image_1x']));
			$data['image_width'] = $width_orig;
			$data['image_height'] = $height_orig;
			$data['image_ratio'] = $height_orig/$width_orig;
    
			//$data['pdf'] = empty($row['pdf'])? '' : HTTP_PDF . $row['pdf'];
		
			//$data['images'] = $this->getImages($data['id']);
			//$data['imagebrochures'] = $this->getBrochures($data['id']);
		
			$data['meta_title'] = empty($row['meta_title'])?$row['name']:$row['meta_title'];
			$data['meta_keyword'] = $row['meta_keyword'];
			$data['meta_description'] = $row['meta_description'];
			
			$data['image_og'] = $row['image_og'];
			$data['meta_title_og'] = empty($row['meta_title_og'])?$row['meta_title']:$row['meta_title_og'];
			$data['meta_description_og'] = empty($row['meta_description_og'])?$row['meta_description']:$row['meta_description_og'];
		
			/*{FRONTEND_DATA_ROW}*/
			$data1[] = $data;
		}

		return $data1;
	}
	
	
	public function getServiceAmp($service_id=0)	{
		$sql = "SELECT * FROM " . DB_PREFIX . "service p LEFT JOIN " . DB_PREFIX . "service_description pd ON (p.service_id = pd.service_id) WHERE p.status='1' AND p.service_id='$service_id' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND pd.name<>'' ORDER BY p.sort_order ASC, p.service_id DESC";

		$query = $this->db->query($sql);
		$data = array();
		$row = $query->row;
		if(isset($row['service_id'])){
			$data['id'] = $row['service_id'];
			$data['name'] = $row['name'];
			$data['name1'] = $row['name1'];
			//$data['desc_short'] = $row['desc_short'];
			
			/*if(isset($row['category_id']))
				$data['href'] = $this->url->link('cms/service','path='. $category_id .'_' . $row['category_id'] . '&service_id='.$row['service_id'],$this->config->get('config_language')) .'.html';
			else
				$data['href'] = $this->url->link('cms/service','path='. $category_id . '&service_id='.$row['service_id'],$this->config->get('config_language')) .'.html';*/

			$data['description'] = str_replace(array('HTTP_CATALOG','<b>','</b>','<h3'),array(HTTP_SERVER,'<strong>','</strong>','<h3 class="block center  relative  uppercase" '),html_entity_decode($row['description']));
			
			preg_match_all('/<img[^>]+>/i',$data['description'], $result); 
	
			foreach( $result[0] as $img_tag)
			{
				$doc = new DOMDocument();
				$doc->loadHTML($img_tag);
				$xpath = new DOMXPath($doc);
				$src = $xpath->evaluate("string(//img/@src)"); # "/images/image.jpg"
				
				list($width_orig_e, $height_orig_e) = getimagesize(DIR_IMAGE . str_replace(HTTP_IMAGE, '', $src));
				
				$data['description'] = str_replace($img_tag,'<amp-img src="' .$src . '" width="1" height="' . $height_orig_e/$width_orig_e . '" layout="responsive" alt=""></amp-img>',html_entity_decode($data['description']));
				
			}
			
			$data['description'] = preg_replace('/ style="(.+?)"/i', "", $data['description']);
			$data['description'] = preg_replace('/ style=""/i', "", $data['description']);
			
			
			//$data['image'] = empty($row['image'])?'': HTTP_IMAGE . str_replace(' ', '%20', $row['image']);
			$data['image'] = empty($row['image'])?'': HTTP_IMAGE . str_replace(' ', '%20', $row['image']);
			$data['image_1x'] = empty($row['image_1x'])?'': HTTP_IMAGE . str_replace(' ', '%20', $row['image_1x']);
			
			/*list($width_orig, $height_orig) = getimagesize(DIR_IMAGE . str_replace(' ', '%20', $row['image_1x']));
			$data['image_width'] = $width_orig;
			$data['image_height'] = $height_orig;
			$data['image_ratio'] = $height_orig/$width_orig;*/
    
			//$data['pdf'] = empty($row['pdf'])? '' : HTTP_PDF . $row['pdf'];
		
			//$data['images'] = $this->getImages($data['id']);
			//$data['imagebrochures'] = $this->getBrochures($data['id']);
			
			$data['child'] = $this->getServiceByParent(ID_SERVICE, $data['id']);
		
			$data['meta_title'] = empty($row['meta_title'])?$row['name']:$row['meta_title'];
			$data['meta_keyword'] = $row['meta_keyword'];
			$data['meta_description'] = $row['meta_description'];
			
			$data['image_og'] = $row['image_og'];
			$data['meta_title_og'] = empty($row['meta_title_og'])?$row['meta_title']:$row['meta_title_og'];
			$data['meta_description_og'] = empty($row['meta_description_og'])?$row['meta_description']:$row['meta_description_og'];
		
			/*{FRONTEND_DATA_ROW}*/
			
		}

		return $data;
	}
	
	public function getServiceByParent($category_id=0, $parent_id=0)	{
		$sql = "SELECT * FROM " . DB_PREFIX . "service p LEFT JOIN " . DB_PREFIX . "service_description pd ON (p.service_id = pd.service_id) WHERE p.status='1' AND p.cate='$parent_id' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND pd.name<>'' ORDER BY p.sort_order ASC, p.service_id DESC";

		$query = $this->db->query($sql);
		$data1 = array();
		
		if(isset($_SESSION['scaleimg']) && $_SESSION['scaleimg']=='1'){
			$folder = HTTP_IMAGE_MOBILE;
			$folder_dir = DIR_IMAGE_MOBILE;
			$img_temp = PATH_IMAGE_THUMB_MOBILE;
		}else{
			$folder = HTTP_IMAGE;
			$folder_dir = DIR_IMAGE;
			$img_temp = PATH_IMAGE_THUMB;
		}

		foreach($query->rows as $row){
			$data = array();
			$data['id'] = $row['service_id'];
			$data['name'] = $row['name'];
			
			$data['description'] = str_replace(array('HTTP_CATALOG','<b>','</b>'),array(HTTP_SERVER,'<strong>','</strong>'),html_entity_decode($row['description']));
			preg_match_all('/<img[^>]+>/i',$data['description'], $result); 
			foreach( $result[0] as $img_tag)
			{
				$doc = new DOMDocument();
				$doc->loadHTML($img_tag);
				$xpath = new DOMXPath($doc);
				$src = $xpath->evaluate("string(//img/@src)"); # "/images/image.jpg"
				
				list($width_orig_e, $height_orig_e) = getimagesize(DIR_IMAGE . str_replace(HTTP_IMAGE, '', $src));
				
				$data['description'] = str_replace($img_tag,'<amp-img src="' .$src . '" width="1" height="' . $height_orig_e/$width_orig_e . '" layout="responsive" alt=""></amp-img>',html_entity_decode($data['description']));
				
			}
			$data['description'] = preg_replace('/ style="(.+?)"/i', "", $data['description']);
			$data['description'] = preg_replace('/ style=""/i', "", $data['description']);
			
			
			preg_match('/<img.+src=[\'"](?P<src>[^\s\'"]*)[\'"].?.*>/i', $data['description'], $image);
			$data['image'] = empty($row['image']) || !is_file($folder_dir . $row['image'])?'': str_replace(' ', '%20', $row['image']);
			
			$data['image_width'] = $data['image_height'] = $data['image_ratio'] = 1;
			if(!empty($data['image'])){
			list($width_orig, $height_orig) = getimagesize(DIR_IMAGE . str_replace(' ', '%20', $row['image']));
			$data['image_width'] = $width_orig;
			$data['image_height'] = $height_orig;
			$data['image_ratio'] = $height_orig/$width_orig;
			}
			
			$data['image1'] = empty($row['image1']) || !is_file($folder_dir . $row['image1'])?'': str_replace(' ', '%20', $row['image1']);
			
			//$data['image2'] = empty($row['image2']) || !is_file($folder_dir . $row['image2'])?'': str_replace(' ', '%20', $row['image2']);
			
			$data['meta_title'] = empty($row['meta_title'])?$row['name']:$row['meta_title'];
			$data['meta_keyword'] = $row['meta_keyword'];
			$data['meta_description'] = $row['meta_description'];
			
			$data['image_og'] = $row['image_og'];
			$data['meta_title_og'] = empty($row['meta_title_og'])?$row['meta_title']:$row['meta_title_og'];
			$data['meta_description_og'] = empty($row['meta_description_og'])?$row['meta_description']:$row['meta_description_og'];
		
			/*{FRONTEND_DATA_ROW}*/
			$data1[] = $data;
		}

		return $data1;
	}
	
	public function getServicesAmp($category_id=0)	{
		$sql = "SELECT * FROM " . DB_PREFIX . "service p LEFT JOIN " . DB_PREFIX . "service_description pd ON (p.service_id = pd.service_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND pd.name<>'' ORDER BY p.sort_order ASC, p.service_id DESC";

		$query = $this->db->query($sql);
		$data1 = array();
		
		/*if(isset($_SESSION['scaleimg']) && $_SESSION['scaleimg']=='1'){
			$folder = HTTP_IMAGE_MOBILE;
		}else{
			$folder = HTTP_IMAGE;
		}*/

		foreach($query->rows as $row){
			$data = array();
			$data['id'] = $row['service_id'];
			$data['name'] = $row['name'];
			//$data['desc_short'] = $row['desc_short'];
			$data['desc_short'] = $row['desc_short'];
			
			if(isset($row['category_id']))
				$data['href'] = $this->url->link('cms/service','path='. $category_id .'_' . $row['category_id'] . '&service_id='.$row['service_id'],$this->config->get('config_language')) .'.html';
			else
				$data['href'] = $this->url->link('cms/service','path='. $category_id . '&service_id='.$row['service_id'],$this->config->get('config_language')) .'.html';

			$data['description'] = str_replace(array('HTTP_CATALOG','<b>','</b>','<h3'),array(HTTP_SERVER,'<strong>','</strong>','<h3 class="block center  relative  uppercase" '),html_entity_decode($row['description']));
			
			preg_match_all('/<img[^>]+>/i',$data['description'], $result); 
	
			foreach( $result[0] as $img_tag)
			{
				$doc = new DOMDocument();
				$doc->loadHTML($img_tag);
				$xpath = new DOMXPath($doc);
				$src = $xpath->evaluate("string(//img/@src)"); # "/images/image.jpg"
				
				list($width_orig_e, $height_orig_e) = getimagesize(DIR_IMAGE . str_replace(HTTP_IMAGE, '', $src));
				
				$data['description'] = str_replace($img_tag,'<amp-img src="' .$src . '" width="1" height="' . $height_orig_e/$width_orig_e . '" layout="responsive" alt=""></amp-img>',html_entity_decode($data['description']));
				
			}
			
			$data['description'] = preg_replace('/ style="(.+?)"/i', "", $data['description']);
			$data['description'] = preg_replace('/ style=""/i', "", $data['description']);
			
			
			//$data['image'] = empty($row['image'])?'': HTTP_IMAGE . str_replace(' ', '%20', $row['image']);
			$data['image'] = empty($row['image'])?'': HTTP_IMAGE . str_replace(' ', '%20', $row['image']);
			$data['image_1x'] = empty($row['image_1x'])?'': HTTP_IMAGE . str_replace(' ', '%20', $row['image_1x']);
			
			list($width_orig, $height_orig) = getimagesize(DIR_IMAGE . str_replace(' ', '%20', $row['image_1x']));
			$data['image_width'] = $width_orig;
			$data['image_height'] = $height_orig;
			$data['image_ratio'] = $height_orig/$width_orig;
    
			//$data['pdf'] = empty($row['pdf'])? '' : HTTP_PDF . $row['pdf'];
		
			//$data['images'] = $this->getImages($data['id']);
			//$data['imagebrochures'] = $this->getBrochures($data['id']);
		
			$data['meta_title'] = empty($row['meta_title'])?$row['name']:$row['meta_title'];
			$data['meta_keyword'] = $row['meta_keyword'];
			$data['meta_description'] = $row['meta_description'];
			
			$data['image_og'] = $row['image_og'];
			$data['meta_title_og'] = empty($row['meta_title_og'])?$row['meta_title']:$row['meta_title_og'];
			$data['meta_description_og'] = empty($row['meta_description_og'])?$row['meta_description']:$row['meta_description_og'];
		
			/*{FRONTEND_DATA_ROW}*/
			$data1[] = $data;
		}

		return $data1;
	}
	
	public function getAboutussAmp($category_id=0)	{
		$sql = "SELECT * FROM " . DB_PREFIX . "aboutus p LEFT JOIN " . DB_PREFIX . "aboutus_description pd ON (p.aboutus_id = pd.aboutus_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND pd.name<>'' ORDER BY p.sort_order ASC, p.aboutus_id DESC";

		$query = $this->db->query($sql);
		$data1 = array();
		
		foreach($query->rows as $row){
			$data = array();
			$data['id'] = $row['aboutus_id'];
			$data['name'] = $row['name'];
			//$data['desc_short'] = $row['desc_short'];
			$data['desc_short'] = $row['desc_short'];
			
			if(isset($row['category_id']))
				$data['href'] = $this->url->link('cms/aboutus','path='. $category_id .'_' . $row['category_id'] . '&aboutus_id='.$row['aboutus_id'],$this->config->get('config_language')) .'.html';
			else
				$data['href'] = $this->url->link('cms/aboutus','path='. $category_id . '&aboutus_id='.$row['aboutus_id'],$this->config->get('config_language')) .'.html';

			//$data['description'] = str_replace('HTTP_CATALOG',HTTP_SERVER,html_entity_decode($row['description']));
			
			$data['description'] = str_replace(array('HTTP_CATALOG','<b>','</b>'),array(HTTP_SERVER,'<strong>','</strong>'),html_entity_decode($row['description']));
		
			preg_match_all('/<img[^>]+>/i',$data['description'], $result); 
	
			foreach( $result[0] as $img_tag)
			{
				$doc = new DOMDocument();
				$doc->loadHTML($img_tag);
				$xpath = new DOMXPath($doc);
				$src = $xpath->evaluate("string(//img/@src)"); # "/images/image.jpg"
				
				list($width_orig_e, $height_orig_e) = getimagesize(DIR_IMAGE . str_replace(HTTP_IMAGE, '', $src));
				
				$data['description'] = str_replace($img_tag,'<amp-img src="' .$src . '" width="1" height="' . $height_orig_e/$width_orig_e . '" layout="responsive" alt=""></amp-img>',html_entity_decode($data['description']));
				
			}
			
			$data['description'] = preg_replace('/ style="(.+?)"/i', "", $data['description']);
			$data['description'] = preg_replace('/ style=""/i', "", $data['description']);
			
			
			$data['description1'] = str_replace(array('HTTP_CATALOG','<b>','</b>'),array(HTTP_SERVER,'<strong>','</strong>'),html_entity_decode($row['description1']));
		
			preg_match_all('/<img[^>]+>/i',$data['description1'], $result); 
	
			foreach( $result[0] as $img_tag)
			{
				$doc = new DOMDocument();
				$doc->loadHTML($img_tag);
				$xpath = new DOMXPath($doc);
				$src = $xpath->evaluate("string(//img/@src)"); # "/images/image.jpg"
				
				list($width_orig_e, $height_orig_e) = getimagesize(DIR_IMAGE . str_replace(HTTP_IMAGE, '', $src));
				
				$data['description1'] = str_replace($img_tag,'<amp-img src="' .$src . '" width="1" height="' . $height_orig_e/$width_orig_e . '" layout="responsive" alt=""></amp-img>',html_entity_decode($data['description1']));
				
			}
			
			$data['description1'] = preg_replace('/ style="(.+?)"/i', "", $data['description1']);
			$data['description1'] = preg_replace('/ style=""/i', "", $data['description1']);



			//$data['image'] = empty($row['image'])?'': HTTP_IMAGE . str_replace(' ', '%20', $row['image']);
			$data['image'] = empty($row['image'])?'': HTTP_IMAGE . str_replace(' ', '%20', $row['image']);
			
			$data['image_width'] = 1;
			$data['image_height'] = 1;
			$data['image_ratio'] = 1;
			if(!empty($data['image'])){
			list($width_orig, $height_orig) = getimagesize(DIR_IMAGE . str_replace(' ', '%20', $row['image']));
				$data['image_width'] = $width_orig;
				$data['image_height'] = $height_orig;
				$data['image_ratio'] = $height_orig/$width_orig;
			}
			/*$data['image_1x'] = empty($row['image_1x'])?'': HTTP_IMAGE . str_replace(' ', '%20', $row['image_1x']);
			
			list($width_orig, $height_orig) = getimagesize(DIR_IMAGE . str_replace(' ', '%20', $row['image_1x']));
			$data['image_width'] = $width_orig;
			$data['image_height'] = $height_orig;
			$data['image_ratio'] = $height_orig/$width_orig;*/
    
			//$data['pdf'] = empty($row['pdf'])? '' : HTTP_PDF . $row['pdf'];
		
			//$data['images'] = $this->getImages($data['id']);
			//$data['imagebrochures'] = $this->getBrochures($data['id']);
		
			$data['meta_title'] = empty($row['meta_title'])?$row['name']:$row['meta_title'];
			$data['meta_keyword'] = $row['meta_keyword'];
			$data['meta_description'] = $row['meta_description'];
			
			$data['image_og'] = $row['image_og'];
			$data['meta_title_og'] = empty($row['meta_title_og'])?$row['meta_title']:$row['meta_title_og'];
			$data['meta_description_og'] = empty($row['meta_description_og'])?$row['meta_description']:$row['meta_description_og'];
		
			/*{FRONTEND_DATA_ROW}*/
			$data1[] = $data;
		}

		return $data1;
	}
	
	
	public function getContactsAmp($category_id=0)	{
		$sql = "SELECT * FROM " . DB_PREFIX . "contact p LEFT JOIN " . DB_PREFIX . "contact_description pd ON (p.contact_id = pd.contact_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND pd.name<>'' ORDER BY p.sort_order ASC, p.contact_id DESC";

		$query = $this->db->query($sql);
		$data1 = array();
		
		/*if(isset($_SESSION['scaleimg']) && $_SESSION['scaleimg']=='1'){
			$folder = HTTP_IMAGE_MOBILE;
		}else{
			$folder = HTTP_IMAGE;
		}*/

		foreach($query->rows as $row){
			$data = array();
			$data['id'] = $row['contact_id'];
			$data['name'] = $row['name'];
			//$data['desc_short'] = $row['desc_short'];
			//$data['desc_short'] = $row['desc_short'];
			
			if(isset($row['category_id']))
				$data['href'] = $this->url->link('cms/contact','path='. $category_id .'_' . $row['category_id'] . '&contact_id='.$row['contact_id'],$this->config->get('config_language')) .'.html';
			else
				$data['href'] = $this->url->link('cms/contact','path='. $category_id . '&contact_id='.$row['contact_id'],$this->config->get('config_language')) .'.html';

			$data['description'] = str_replace(array('HTTP_CATALOG','<b>','</b>','<h3'),array(HTTP_SERVER,'<strong>','</strong>','<h3 class="block center  relative  uppercase" '),html_entity_decode($row['description']));
			
			preg_match_all('/<img[^>]+>/i',$data['description'], $result); 
	
			foreach( $result[0] as $img_tag)
			{
				$doc = new DOMDocument();
				$doc->loadHTML($img_tag);
				$xpath = new DOMXPath($doc);
				$src = $xpath->evaluate("string(//img/@src)"); # "/images/image.jpg"
				
				list($width_orig_e, $height_orig_e) = getimagesize(DIR_IMAGE . str_replace(HTTP_IMAGE, '', $src));
				
				$data['description'] = str_replace($img_tag,'<amp-img src="' .$src . '" width="1" height="' . $height_orig_e/$width_orig_e . '" layout="responsive" alt=""></amp-img>',html_entity_decode($data['description']));
				
			}
			
			$data['description'] = preg_replace('/ style="(.+?)"/i', "", $data['description']);
			$data['description'] = preg_replace('/ style=""/i', "", $data['description']);
			
			
			//$data['image'] = empty($row['image'])?'': HTTP_IMAGE . str_replace(' ', '%20', $row['image']);
			$data['image'] = empty($row['image'])?'': HTTP_IMAGE . str_replace(' ', '%20', $row['image']);
			//$data['image_1x'] = empty($row['image_1x'])?'': HTTP_IMAGE . str_replace(' ', '%20', $row['image_1x']);
			
			$data['image_width'] = $data['image_height'] = $data['image_ratio'] = 1;
			if(!empty($data['image'])){
			//list($width_orig, $height_orig) = getimagesize(DIR_IMAGE . str_replace(' ', '%20', $row['image_1x']));
			list($width_orig, $height_orig) = getimagesize(DIR_IMAGE . str_replace(' ', '%20', $row['image']));
			$data['image_width'] = $width_orig;
			$data['image_height'] = $height_orig;
			$data['image_ratio'] = $height_orig/$width_orig;
			}
			//$data['pdf'] = empty($row['pdf'])? '' : HTTP_PDF . $row['pdf'];
		
			//$data['images'] = $this->getImages($data['id']);
			//$data['imagebrochures'] = $this->getBrochures($data['id']);
			
			//$data['name1'] = html_entity_decode($row['desc_info']);
			$data['address'] = $row['address'];
			$data['phone'] = $row['phone'];
			$data['phone_tel'] = remove_symbols($row['phone']);
			$data['phone1'] = $row['phone1'];
			$data['phone1_tel'] = remove_symbols($row['phone1']);
			/*$data['phone2'] = $row['phone2'];
			$data['phone2_tel'] = remove_symbols($row['phone2']);
			$data['phone3'] = $row['phone3'];
			$data['phone3_tel'] = remove_symbols($row['phone3']);*/
			/*$data['website'] = $row['website'];
			$data['website_short'] = str_replace('https://','',str_replace('http://','',trim($row['website'])));
			$data['website1'] = $row['website1'];
			$data['website1_short'] = str_replace('https://','',str_replace('http://','',trim($row['website1'])));
			$data['website2'] = $row['website2'];
			$data['website2_short'] = str_replace('https://','',str_replace('http://','',trim($row['website2'])));
			$data['website3'] = $row['website3'];
			$data['website3_short'] = str_replace('https://','',str_replace('http://','',trim($row['website3'])));*/
			$data['email'] = $row['email'];
			$data['email1'] = $row['email1'];
			/*$data['email2'] = $row['email2'];
			$data['email3'] = $row['email3'];*/
			
			
			$data['tax'] = $row['tax'];
		
		$search  = array('<div>', '</div>', '<p>', '</p>', '<b>', '</b>', 'HTTP_CATALOG');
		$replace = array('', '', '', '', '<strong>', '</strong>', HTTP_SERVER);
		$phonelist = strip_tags(html_entity_decode($row['phonelist']));
		$data['phonelist'] = !empty($phonelist)?str_replace($search,$replace,html_entity_decode($row['phonelist'])):'';
		$search  = array('&lt;div&gt;', '&lt;/div&gt;','&lt;p&gt;', '&lt;/p&gt;', '&lt;b&gt;', '&lt;/b&gt;', 'HTTP_CATALOG');
		$replace = array('', '','', '', '&lt;strong&gt;', '&lt;/strong&gt;', HTTP_SERVER);
		$data['phonelist_infobox'] = !empty($phonelist)?str_replace($search,$replace,($row['phonelist'])):'';
		
		$search  = array('<div>', '</div>', '</p><p>', '<p>', '</p>', '<b>', '</b>', 'HTTP_CATALOG');
		$replace = array('', '', '<br>', '', '', '<strong>', '</strong>', HTTP_SERVER);
		$hotlinelist = strip_tags(html_entity_decode($row['hotlinelist']));
		$data['hotlinelist'] = !empty($hotlinelist)?str_replace($search,$replace,html_entity_decode($row['hotlinelist'])):'';
		$search  = array('&lt;div&gt;', '&lt;/div&gt;','&lt;p&gt;', '&lt;/p&gt;', '&lt;b&gt;', '&lt;/b&gt;', 'HTTP_CATALOG');
		$replace = array('', '','', '', '&lt;strong&gt;', '&lt;/strong&gt;', HTTP_SERVER);
		$data['hotlinelist_infobox'] = !empty($hotlinelist)?str_replace($search,$replace,($row['hotlinelist'])):'';
		
		$search  = array('<div>', '</div>', '<p>', '</p>', '<b>', '</b>', 'HTTP_CATALOG');
		$replace = array('', '', '', '', '<strong>', '</strong>', HTTP_SERVER);
		$emaillist = strip_tags(html_entity_decode($row['emaillist']));
		$data['emaillist'] = !empty($emaillist)?str_replace($search,$replace,html_entity_decode($row['emaillist'])):'';
		$search  = array('&lt;div&gt;', '&lt;/div&gt;','&lt;p&gt;', '&lt;/p&gt;', '&lt;b&gt;', '&lt;/b&gt;', 'HTTP_CATALOG');
		$replace = array('', '','', '', '&lt;strong&gt;', '&lt;/strong&gt;', HTTP_SERVER);
		$data['emaillist_infobox'] = !empty($emaillist)?str_replace($search,$replace,($row['emaillist'])):'';
		
		$search  = array('<div>', '</div>', '<p>', '</p>', '<b>', '</b>', 'HTTP_CATALOG');
		$replace = array('', '', '', '', '<strong>', '</strong>', HTTP_SERVER);
		$faxlist = strip_tags(html_entity_decode($row['faxlist']));
		$data['faxlist'] = !empty($faxlist)?str_replace($search,$replace,html_entity_decode($row['faxlist'])):'';
		$search  = array('&lt;div&gt;', '&lt;/div&gt;','&lt;p&gt;', '&lt;/p&gt;', '&lt;b&gt;', '&lt;/b&gt;', 'HTTP_CATALOG');
		$replace = array('', '','', '', '&lt;strong&gt;', '&lt;/strong&gt;', HTTP_SERVER);
		$data['faxlist_infobox'] = !empty($faxlist)?str_replace($search,$replace,($row['faxlist'])):'';
		
		
		$search  = array('<div>', '</div>', '<p>', '</p>', '<b>', '</b>', 'HTTP_CATALOG');
		$replace = array('', '', '', '', '<strong>', '</strong>', HTTP_SERVER);
		$name1 = strip_tags(html_entity_decode($row['name1']));
		$data['name1'] = !empty($name1)?str_replace($search,$replace,html_entity_decode($row['name1'])):'';
		$search  = array('&lt;div&gt;', '&lt;/div&gt;','&lt;p&gt;', '&lt;/p&gt;', '&lt;b&gt;', '&lt;/b&gt;', 'HTTP_CATALOG');
		$replace = array('', '','', '', '&lt;strong&gt;', '&lt;/strong&gt;', HTTP_SERVER);
		$data['name1_infobox'] = !empty($name1)?str_replace($search,$replace,($row['name1'])):'';
		
			
			
			$data['googlemap'] = $row['googlemap'];
			
			$location = $row['location'];
			$arr_loc = explode(',',$location);
			$data['location'] = $arr_loc;
		
			$data['meta_title'] = empty($row['meta_title'])?$row['name']:$row['meta_title'];
			$data['meta_keyword'] = $row['meta_keyword'];
			$data['meta_description'] = $row['meta_description'];
			
			$data['image_og'] = $row['image_og'];
			$data['meta_title_og'] = empty($row['meta_title_og'])?$row['meta_title']:$row['meta_title_og'];
			$data['meta_description_og'] = empty($row['meta_description_og'])?$row['meta_description']:$row['meta_description_og'];
		
			/*{FRONTEND_DATA_ROW}*/
			$data1[] = $data;
		}

		return $data1;
	}
	
	
	public function getShowroomsAmp($category_id=0)	{
		$sql = "SELECT * FROM " . DB_PREFIX . "showroom p LEFT JOIN " . DB_PREFIX . "showroom_description pd ON (p.showroom_id = pd.showroom_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND pd.name<>'' ORDER BY p.sort_order ASC, p.showroom_id DESC";

		$query = $this->db->query($sql);
		$data1 = array();

		foreach($query->rows as $row){
			$data = array();
			$data['id'] = $row['showroom_id'];
			$data['name'] = $row['name'];
			
			$data['description'] = str_replace(array('HTTP_CATALOG','<b>','</b>','<h3'),array(HTTP_SERVER,'<strong>','</strong>','<h3 class="block center  relative  uppercase" '),html_entity_decode($row['description']));
			
			preg_match_all('/<img[^>]+>/i',$data['description'], $result); 
	
			foreach( $result[0] as $img_tag)
			{
				$doc = new DOMDocument();
				$doc->loadHTML($img_tag);
				$xpath = new DOMXPath($doc);
				$src = $xpath->evaluate("string(//img/@src)"); # "/images/image.jpg"
				
				list($width_orig_e, $height_orig_e) = getimagesize(DIR_IMAGE . str_replace(HTTP_IMAGE, '', $src));
				
				$data['description'] = str_replace($img_tag,'<amp-img src="' .$src . '" width="1" height="' . $height_orig_e/$width_orig_e . '" layout="responsive" alt=""></amp-img>',html_entity_decode($data['description']));
				
			}
			
			$data['description'] = preg_replace('/ style="(.+?)"/i', "", $data['description']);
			$data['description'] = preg_replace('/ style=""/i', "", $data['description']);
			
			
			//$data['image'] = empty($row['image'])?'': HTTP_IMAGE . str_replace(' ', '%20', $row['image']);
			$data['image'] = empty($row['image'])?'': HTTP_IMAGE . str_replace(' ', '%20', $row['image']);
			//$data['image_1x'] = empty($row['image_1x'])?'': HTTP_IMAGE . str_replace(' ', '%20', $row['image_1x']);
			
			$data['image_width'] = $data['image_height'] = $data['image_ratio'] = 1;
			if(!empty($data['image'])){
			//list($width_orig, $height_orig) = getimagesize(DIR_IMAGE . str_replace(' ', '%20', $row['image_1x']));
			list($width_orig, $height_orig) = getimagesize(DIR_IMAGE . str_replace(' ', '%20', $row['image']));
			$data['image_width'] = $width_orig;
			$data['image_height'] = $height_orig;
			$data['image_ratio'] = $height_orig/$width_orig;
			}
			$data['address'] = $row['address'];
			
		
		$search  = array('<div>', '</div>', '<p>', '</p>', '<b>', '</b>', 'HTTP_CATALOG');
		$replace = array('', '', '', '', '<strong>', '</strong>', HTTP_SERVER);
		$phonelist = strip_tags(html_entity_decode($row['phonelist']));
		$data['phonelist'] = !empty($phonelist)?str_replace($search,$replace,html_entity_decode($row['phonelist'])):'';
		$search  = array('&lt;div&gt;', '&lt;/div&gt;','&lt;p&gt;', '&lt;/p&gt;', '&lt;b&gt;', '&lt;/b&gt;', 'HTTP_CATALOG');
		$replace = array('', '','', '', '&lt;strong&gt;', '&lt;/strong&gt;', HTTP_SERVER);
		$data['phonelist_infobox'] = !empty($phonelist)?str_replace($search,$replace,($row['phonelist'])):'';
		
		$search  = array('<div>', '</div>', '<p>', '</p>', '<b>', '</b>', 'HTTP_CATALOG');
		$replace = array('', '', '', '', '<strong>', '</strong>', HTTP_SERVER);
		$emaillist = strip_tags(html_entity_decode($row['emaillist']));
		$data['emaillist'] = !empty($emaillist)?str_replace($search,$replace,html_entity_decode($row['emaillist'])):'';
		$search  = array('&lt;div&gt;', '&lt;/div&gt;','&lt;p&gt;', '&lt;/p&gt;', '&lt;b&gt;', '&lt;/b&gt;', 'HTTP_CATALOG');
		$replace = array('', '','', '', '&lt;strong&gt;', '&lt;/strong&gt;', HTTP_SERVER);
		$data['emaillist_infobox'] = !empty($emaillist)?str_replace($search,$replace,($row['emaillist'])):'';
		
		$search  = array('<div>', '</div>', '<p>', '</p>', '<b>', '</b>', 'HTTP_CATALOG');
		$replace = array('', '', '', '', '<strong>', '</strong>', HTTP_SERVER);
		$faxlist = strip_tags(html_entity_decode($row['faxlist']));
		$data['faxlist'] = !empty($faxlist)?str_replace($search,$replace,html_entity_decode($row['faxlist'])):'';
		$search  = array('&lt;div&gt;', '&lt;/div&gt;','&lt;p&gt;', '&lt;/p&gt;', '&lt;b&gt;', '&lt;/b&gt;', 'HTTP_CATALOG');
		$replace = array('', '','', '', '&lt;strong&gt;', '&lt;/strong&gt;', HTTP_SERVER);
		$data['faxlist_infobox'] = !empty($faxlist)?str_replace($search,$replace,($row['faxlist'])):'';
		
		
		
			$data['meta_title'] = empty($row['meta_title'])?$row['name']:$row['meta_title'];
			$data['meta_keyword'] = $row['meta_keyword'];
			$data['meta_description'] = $row['meta_description'];
			
			$data['image_og'] = $row['image_og'];
			$data['meta_title_og'] = empty($row['meta_title_og'])?$row['meta_title']:$row['meta_title_og'];
			$data['meta_description_og'] = empty($row['meta_description_og'])?$row['meta_description']:$row['meta_description_og'];
		
			/*{FRONTEND_DATA_ROW}*/
			$data1[] = $data;
		}

		return $data1;
	}
	
	
	public function getBusinessByParent($category_id=0,$cate=0)	{
		$this->load->model('cms/business');
		$sql = "SELECT * FROM " . DB_PREFIX . "business p LEFT JOIN " . DB_PREFIX . "business_description pd ON (p.business_id = pd.business_id) WHERE p.status='1' AND p.cate='$cate' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND pd.name<>'' ORDER BY p.sort_order ASC, p.business_id DESC";
		
		$query = $this->db->query($sql);
		$data1 = array();

		foreach($query->rows as $row){
			$data = array();
			$data['id'] = $row['business_id'];
			$data['name'] = $row['name'];
			$data['name1'] = $row['name1'];

			if(isset($row['category_id']))
				$data['href'] = $this->url->link('cms/business','path='. $category_id .'_' . $row['category_id']  . '&catebusiness='.$row['cate'] . '&business_id='.$row['business_id'],$this->config->get('config_language')) .'.html';
			else
				$data['href'] = $this->url->link('cms/business','path='. $category_id  . '&catebusiness='.$row['cate'] . '&business_id='.$row['business_id'],$this->config->get('config_language')) .'.html';
			
			$search  = array('<div', '</div>', '<b>', '<b ', '</b>','<br></i></p>','<br></u></p>','<br></span></p>','<br></p>', 'HTTP_CATALOG');
			$replace = array('<p', '</p>', '<strong>', '<strong ', '</strong>','</i></p>','</u></p>','</span></p>','</p>', HTTP_SERVER);
			$des = str_replace($search,$replace,html_entity_decode($row['description']));
			//$des = str_replace('HTTP_CATALOG',HTTP_SERVER,html_entity_decode($row['description']));
			$checkdes = strip_tags($des);
			$data['description'] = !empty($checkdes)?$des:'';
			
		
		preg_match_all('/<img[^>]+>/i',$data['description'], $result); 

		foreach( $result[0] as $img_tag)
		{
			$doc = new DOMDocument();
			$doc->loadHTML($img_tag);
			$xpath = new DOMXPath($doc);
			$src = $xpath->evaluate("string(//img/@src)"); # "/images/image.jpg"
			
			list($width_orig_e, $height_orig_e) = getimagesize(DIR_IMAGE . str_replace(HTTP_IMAGE, '', $src));
			
			$data['description'] = str_replace($img_tag,'<amp-img src="' .$src . '" width="1" height="' . $height_orig_e/$width_orig_e . '" layout="responsive" alt=""></amp-img>',html_entity_decode($data['description']));
			
		}
		
		$data['description'] = preg_replace('/ style="(.+?)"/i', "", $data['description']);
		$data['description'] = preg_replace('/ style=""/i', "", $data['description']);
		

			//$data['image'] = empty($row['image'])?'': HTTP_IMAGE . str_replace(' ', '%20', $row['image']);
			$data['image'] = empty($row['image']) || !is_file(DIR_IMAGE . $row['image'])?'': HTTP_IMAGE . str_replace(' ', '%20', $row['image']);

			$data['image_width'] = $data['image_height'] = $data['image_ratio'] = 1;
			if(!empty($data['image'])){
			list($width_orig, $height_orig) = getimagesize(DIR_IMAGE . str_replace(' ', '%20', $row['image']));
			$data['image_width'] = $width_orig;
			$data['image_height'] = $height_orig;
			$data['image_ratio'] = $height_orig/$width_orig;
			}
			
			
			
    
    	$data['image1'] = empty($row['image1']) || !is_file(DIR_IMAGE . $row['image1'])? '' : HTTP_IMAGE . str_replace(' ', '%20', $row['image1']);
		
		$data['image1_width'] = $data['image1_height'] = $data['image1_ratio'] = 1;
			if(!empty($data['image1'])){
			list($width_orig, $height_orig) = getimagesize(DIR_IMAGE . str_replace(' ', '%20', $row['image1']));
			$data['image1_width'] = $width_orig;
			$data['image1_height'] = $height_orig;
			$data['image1_ratio'] = $height_orig/$width_orig;
			}
			
			$search  = array('<div', '</div>', '<b>', '<b ', '</b>','<br></i></p>','<br></u></p>','<br></span></p>','<br></p>', 'HTTP_CATALOG');
			$replace = array('<p', '</p>', '<strong>', '<strong ', '</strong>','</i></p>','</u></p>','</span></p>','</p>', HTTP_SERVER);
			$des = str_replace($search,$replace,html_entity_decode($row['description1']));
			//$des = str_replace('HTTP_CATALOG',HTTP_SERVER,html_entity_decode($row['description']));
			$checkdes = strip_tags($des);
			$data['description1'] = !empty($checkdes)?$des:'';
			
			preg_match_all('/<img[^>]+>/i',$data['description1'], $result); 

		foreach( $result[0] as $img_tag)
		{
			$doc = new DOMDocument();
			$doc->loadHTML($img_tag);
			$xpath = new DOMXPath($doc);
			$src = $xpath->evaluate("string(//img/@src)"); # "/images/image.jpg"
			
			list($width_orig_e, $height_orig_e) = getimagesize(DIR_IMAGE . str_replace(HTTP_IMAGE, '', $src));
			
			$data['description1'] = str_replace($img_tag,'<amp-img src="' .$src . '" width="1" height="' . $height_orig_e/$width_orig_e . '" layout="responsive" alt=""></amp-img>',html_entity_decode($data['description1']));
			
		}
		
		$data['description1'] = preg_replace('/ style="(.+?)"/i', "", $data['description1']);
		$data['description1'] = preg_replace('/ style=""/i', "", $data['description1']);
		
			
			
			
			
			$data['pdf'] = empty($row['pdf']) || !is_file(DIR_PDF . $row['pdf'])? '' : HTTP_PDF . $row['pdf'];
			
			$data['images'] = $this->model_cms_business->getImages($data['id']);
			if(!$cate){
			$data['child'] = $this->getBusinessByParent($category_id, $data['id']);
			}
			
			$data['meta_title'] = empty($row['meta_title'])?$row['name']:$row['meta_title'];
			$data['meta_keyword'] = $row['meta_keyword'];
			$data['meta_description'] = $row['meta_description'];
			
			$data['image_og'] = $row['image_og'];
			$data['meta_title_og'] = empty($row['meta_title_og'])?$row['meta_title']:$row['meta_title_og'];
			$data['meta_description_og'] = empty($row['meta_description_og'])?$row['meta_description']:$row['meta_description_og'];
			
			/*{FRONTEND_DATA_ROW}*/
			$data1[] = $data;
		}

		return $data1;
	}
	
	public function getBusinessAmp($business_id)	{
		$this->load->model('cms/business');
		$sql = "SELECT * FROM " . DB_PREFIX . "business p LEFT JOIN " . DB_PREFIX . "business_description pd ON (p.business_id = pd.business_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND p.business_id = '" . $business_id . "'";
		
		$query = $this->db->query($sql);
		
		$data = array();

		$row = $query->row;

		$data['id'] = $row['business_id'];
		$data['name'] = $row['name'];
		$data['name1'] = $row['name1'];
		$search  = array('<div', '</div>', '<b>', '<b ', '</b>', 'HTTP_CATALOG','<br></i></p>','<br></u></p>','<br></span></p>','<br></p>');
		$replace = array('<p', '</p>', '<strong>', '<strong ', '</strong>', HTTP_SERVER,'</i></p>','</u></p>','</span></p>','</p>');
		$data['description'] = str_replace($search,$replace,html_entity_decode($row['description']));
		
		//$data['description'] = str_replace(array('HTTP_CATALOG','<b>','</b>'),array(HTTP_SERVER,'<strong>','</strong>'),html_entity_decode($row['description']));
		
		preg_match_all('/<img[^>]+>/i',$data['description'], $result); 

		foreach( $result[0] as $img_tag)
		{
			$doc = new DOMDocument();
			$doc->loadHTML($img_tag);
			$xpath = new DOMXPath($doc);
			$src = $xpath->evaluate("string(//img/@src)"); # "/images/image.jpg"
			
			list($width_orig_e, $height_orig_e) = getimagesize(DIR_IMAGE . str_replace(HTTP_IMAGE, '', $src));
			
			$data['description'] = str_replace($img_tag,'<amp-img src="' .$src . '" width="1" height="' . $height_orig_e/$width_orig_e . '" layout="responsive" alt=""></amp-img>',html_entity_decode($data['description']));
			
		}
		
		$data['description'] = preg_replace('/ style="(.+?)"/i', "", $data['description']);
		$data['description'] = preg_replace('/ style=""/i', "", $data['description']);
		

			//$data['image'] = empty($row['image'])?'': HTTP_IMAGE . str_replace(' ', '%20', $row['image']);
			$data['image'] = empty($row['image']) || !is_file(DIR_IMAGE . $row['image'])?'': HTTP_IMAGE . str_replace(' ', '%20', $row['image']);

			$data['image_width'] = $data['image_height'] = $data['image_ratio'] = 1;
			if(!empty($data['image'])){
			list($width_orig, $height_orig) = getimagesize(DIR_IMAGE . str_replace(' ', '%20', $row['image']));
			$data['image_width'] = $width_orig;
			$data['image_height'] = $height_orig;
			$data['image_ratio'] = $height_orig/$width_orig;
			}
			
			
			
    
    	$data['image1'] = empty($row['image1']) || !is_file(DIR_IMAGE . $row['image1'])? '' : HTTP_IMAGE . str_replace(' ', '%20', $row['image1']);
		
		$data['image1_width'] = $data['image1_height'] = $data['image1_ratio'] = 1;
			if(!empty($data['image1'])){
			list($width_orig, $height_orig) = getimagesize(DIR_IMAGE . str_replace(' ', '%20', $row['image1']));
			$data['image1_width'] = $width_orig;
			$data['image1_height'] = $height_orig;
			$data['image1_ratio'] = $height_orig/$width_orig;
			}
    
    	$data['pdf'] = empty($row['pdf']) || !is_file(DIR_PDF . $row['pdf'])? '' : HTTP_PDF . $row['pdf'];
    
    	$data['images'] = $this->model_cms_business->getImages($data['id']);
		if(!$row['cate']){
			$data['child'] = $this->getBusinessByParent(ID_BUSINESS, $data['id']);
		}
    
    	$data['meta_title'] = empty($row['meta_title'])?$row['name']:$row['meta_title'];
		$data['meta_keyword'] = $row['meta_keyword'];
		$data['meta_description'] = $row['meta_description'];
		
		$data['image_og'] = $row['image_og'];
		$data['meta_title_og'] = empty($row['meta_title_og'])?$row['meta_title']:$row['meta_title_og'];
		$data['meta_description_og'] = empty($row['meta_description_og'])?$row['meta_description']:$row['meta_description_og'];
		
		/*{FRONTEND_DATA_ROW}*/
		return $data;
	}
	
	public function getNewsAmp($news_id=0)	{
		$this->load->model('cms/common');
		$sql = "SELECT * FROM " . DB_PREFIX . "news p LEFT JOIN " . DB_PREFIX . "news_description pd ON (p.news_id = pd.news_id) WHERE p.status='1' AND p.news_id='$news_id' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND pd.name<>'' ORDER BY p.sort_order ASC, p.news_id DESC";

		$query = $this->db->query($sql);
		//$data1 = array();
		$data = array();
		$row = $query->row;
		if(isset($row['news_id'])){
			
			$data['id'] = $row['news_id'];
			$data['name'] = $row['name'];
			$data['desc_short'] = $row['desc_short'];
			
			$data['category_id'] = $row['category_id'];

			$data['href'] = $this->url->link('cms/news','path='. $this->model_cms_common->getPath($row['category_id']) . '&news_id='.$row['news_id'],$this->config->get('config_language')) .'.html';
			
			$search  = array('<div', '</div>', '<b>', '<b ', '</b>', 'HTTP_CATALOG','<br></i></p>','<br></u></p>','<br></span></p>','<br></p>');
			$replace = array('<p', '</p>', '<strong>', '<strong ', '</strong>', HTTP_SERVER,'</i></p>','</u></p>','</span></p>','</p>');
		
			$data['description'] = str_replace($search,$replace,html_entity_decode($row['description']));
			//$data['image'] = empty($row['image'])?'': HTTP_IMAGE . str_replace(' ', '%20', $row['image']);
			//$data['image'] = empty($row['image']) || !is_file(DIR_IMAGE . $row['image'])?'': HTTP_IMAGE . str_replace(' ', '%20', $row['image']);
			$data['image_1x'] = empty($row['image_x']) || !is_file(DIR_IMAGE . $row['image_x'])?'': HTTP_IMAGE . str_replace(' ', '%20', $row['image_x']);
			
			preg_match('/<img.+src=[\'"](?P<src>[^\s\'"]*)[\'"].?.*>/i', $data['description'], $image);
			$data['image'] = empty($row['image']) || !is_file(DIR_IMAGE . $row['image'])?'': HTTP_IMAGE . str_replace(' ', '%20', $row['image']);
			$data['image'] = empty($data['image'])&&isset($image['src'])&& !empty($image['src'])?$image['src']:$data['image'];
			$data['image'] = empty($data['image'])?PATH_IMAGE_THUMB:$data['image'];
			
			$data['image_1x'] = $data['image'];
			
			$data['image_width'] = $data['image_height'] = $data['image_ratio'] = 1;
			if($data['image']){
			list($width_orig, $height_orig) = getimagesize(DIR_IMAGE . str_replace(' ', '%20', $row['image']));
			$data['image_width'] = $width_orig;
			$data['image_height'] = $height_orig;
			$data['image_ratio'] = $height_orig/$width_orig;
			}
    
			//$data['pdf'] = empty($row['pdf'])? '' : HTTP_PDF . $row['pdf'];
		
			//$data['images'] = $this->getImages($data['id']);
			//$data['imagebrochures'] = $this->getBrochures($data['id']);
		
			$data['meta_title'] = empty($row['meta_title'])?$row['name']:$row['meta_title'];
			$data['meta_keyword'] = $row['meta_keyword'];
			$data['meta_description'] = $row['meta_description'];
			
			$data['image_og'] = $row['image_og'];
			$data['meta_title_og'] = empty($row['meta_title_og'])?$row['meta_title']:$row['meta_title_og'];
			$data['meta_description_og'] = empty($row['meta_description_og'])?$row['meta_description']:$row['meta_description_og'];
		
			/*{FRONTEND_DATA_ROW}*/
			//$data1[] = $data;
		}

		return $data;
	}
	
	
	public function getListpartnerByParent($category_id=0,$cate=0)	{
		$this->load->model('cms/listpartner');
		$sql = "SELECT * FROM " . DB_PREFIX . "listpartner p LEFT JOIN " . DB_PREFIX . "listpartner_description pd ON (p.listpartner_id = pd.listpartner_id) WHERE p.status='1' AND p.cate='$cate' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND pd.name<>'' ORDER BY p.sort_order ASC, p.listpartner_id DESC";
		
		$query = $this->db->query($sql);
		$data1 = array();

		foreach($query->rows as $row){
			$data = array();
			$data['id'] = $row['listpartner_id'];
			$data['name'] = $row['name'];
			$data['lienket'] = $row['lienket'];

			$data['image'] = empty($row['image']) || !is_file(DIR_IMAGE . $row['image'])?'': HTTP_IMAGE . str_replace(' ', '%20', $row['image']);

			$data['image_width'] = $data['image_height'] = $data['image_ratio'] = 1;
			if(!empty($data['image'])){
			list($width_orig, $height_orig) = getimagesize(DIR_IMAGE . str_replace(' ', '%20', $row['image']));
			$data['image_width'] = $width_orig;
			$data['image_height'] = $height_orig;
			$data['image_ratio'] = $height_orig/$width_orig;
			}
			
			
			
    
    	$data['image1'] = empty($row['image1']) || !is_file(DIR_IMAGE . $row['image1'])? '' : HTTP_IMAGE . str_replace(' ', '%20', $row['image1']);
		
		$data['image1_width'] = $data['image1_height'] = $data['image1_ratio'] = 1;
			if(!empty($data['image1'])){
			list($width_orig, $height_orig) = getimagesize(DIR_IMAGE . str_replace(' ', '%20', $row['image1']));
			$data['image1_width'] = $width_orig;
			$data['image1_height'] = $height_orig;
			$data['image1_ratio'] = $height_orig/$width_orig;
			}
			
			
			if(!$cate){
			$data['child'] = $this->getListpartnerByParent($category_id, $data['id']);
			}
			
			
			
			/*{FRONTEND_DATA_ROW}*/
			$data1[] = $data;
		}

		return $data1;
	}
	
	public function getListpartnerAmp($listpartner_id)	{
		$this->load->model('cms/listpartner');
		$sql = "SELECT * FROM " . DB_PREFIX . "listpartner p LEFT JOIN " . DB_PREFIX . "listpartner_description pd ON (p.listpartner_id = pd.listpartner_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND p.listpartner_id = '" . $listpartner_id . "'";
		
		$query = $this->db->query($sql);
		
		$data = array();

		$row = $query->row;

		$data['id'] = $row['listpartner_id'];
		$data['name'] = $row['name'];
		$data['lienket'] = $row['lienket'];
		
			$data['image'] = empty($row['image']) || !is_file(DIR_IMAGE . $row['image'])?'': HTTP_IMAGE . str_replace(' ', '%20', $row['image']);

			$data['image_width'] = $data['image_height'] = $data['image_ratio'] = 1;
			if(!empty($data['image'])){
			list($width_orig, $height_orig) = getimagesize(DIR_IMAGE . str_replace(' ', '%20', $row['image']));
			$data['image_width'] = $width_orig;
			$data['image_height'] = $height_orig;

			$data['image_ratio'] = $height_orig/$width_orig;
			}
			
			
			
    
    	$data['image1'] = empty($row['image1']) || !is_file(DIR_IMAGE . $row['image1'])? '' : HTTP_IMAGE . str_replace(' ', '%20', $row['image1']);
		
		$data['image1_width'] = $data['image1_height'] = $data['image1_ratio'] = 1;
			if(!empty($data['image1'])){
			list($width_orig, $height_orig) = getimagesize(DIR_IMAGE . str_replace(' ', '%20', $row['image1']));
			$data['image1_width'] = $width_orig;
			$data['image1_height'] = $height_orig;
			$data['image1_ratio'] = $height_orig/$width_orig;
			}
    
    	
		if(!$row['cate']){
			$data['child'] = $this->getListpartnerByParent(ID_BUSINESS, $data['id']);
		}
    
    	
		/*{FRONTEND_DATA_ROW}*/
		return $data;
	}
	
	public function getRecruitmentByParent($category_id=0,$cate=0)	{
		$this->load->model('cms/recruitment');
		$sql = "SELECT * FROM " . DB_PREFIX . "recruitment p LEFT JOIN " . DB_PREFIX . "recruitment_description pd ON (p.recruitment_id = pd.recruitment_id) WHERE p.status='1' AND p.cate='$cate' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND pd.name<>'' ORDER BY p.sort_order ASC, p.recruitment_id DESC";
		
		$query = $this->db->query($sql);
		$data1 = array();

		foreach($query->rows as $row){
			$data = array();
			$data['id'] = $row['recruitment_id'];
			$data['name'] = $row['name'];
			//$data['name1'] = $row['name1'];
			
			/*$data['soluong'] = $row['soluong'];
			$data['diadiem'] = $row['diadiem'];
			$data['ngayhethan'] = date('d/m/Y', strtotime($row['date_insert']));
			$data['tinhtrang'] = $row['tinhtrangdangtuyen'];
			$data['thunhap'] = $row['thunhap'];*/
			
			$data['href'] = $this->url->link('cms/recruitment','path='. ID_RECRUITMENT . '&recruitment_id='.$row['recruitment_id'],$this->config->get('config_language')) .'.html';

			$data['image'] = empty($row['image']) || !is_file(DIR_IMAGE . $row['image'])?'': HTTP_IMAGE . str_replace(' ', '%20', $row['image']);

			$data['image_width'] = $data['image_height'] = $data['image_ratio'] = 1;
			if(!empty($data['image'])){
			list($width_orig, $height_orig) = getimagesize(DIR_IMAGE . str_replace(' ', '%20', $row['image']));
			$data['image_width'] = $width_orig;
			$data['image_height'] = $height_orig;
			$data['image_ratio'] = $height_orig/$width_orig;
			}
			
			
			
    
    	$data['image1'] = empty($row['image1']) || !is_file(DIR_IMAGE . $row['image1'])? '' : HTTP_IMAGE . str_replace(' ', '%20', $row['image1']);
		
		$data['image1_width'] = $data['image1_height'] = $data['image1_ratio'] = 1;
			if(!empty($data['image1'])){
			list($width_orig, $height_orig) = getimagesize(DIR_IMAGE . str_replace(' ', '%20', $row['image1']));
			$data['image1_width'] = $width_orig;
			$data['image1_height'] = $height_orig;
			$data['image1_ratio'] = $height_orig/$width_orig;
			}
			
			
			$search  = array('<div', '</div>', '<b>', '<b ', '</b>', 'HTTP_CATALOG','<br></i></p>','<br></u></p>','<br></span></p>','<br></p>');
			$replace = array('<p', '</p>', '<strong>', '<strong ', '</strong>', HTTP_SERVER,'</i></p>','</u></p>','</span></p>','</p>');
			$data['description'] = str_replace($search,$replace,html_entity_decode($row['description']));
			preg_match_all('/<img[^>]+>/i',$data['description'], $result); 
			foreach( $result[0] as $img_tag)
			{
				$doc = new DOMDocument();
				$doc->loadHTML($img_tag);
				$xpath = new DOMXPath($doc);
				$src = $xpath->evaluate("string(//img/@src)"); # "/images/image.jpg"
				
				list($width_orig_e, $height_orig_e) = getimagesize(DIR_IMAGE . str_replace(HTTP_IMAGE, '', $src));
				
				$data['description'] = str_replace($img_tag,'<amp-img src="' .$src . '" width="1" height="' . $height_orig_e/$width_orig_e . '" layout="responsive" alt=""></amp-img>',html_entity_decode($data['description']));
				
			}
			$data['description'] = preg_replace('/ style="(.+?)"/i', "", $data['description']);
			$data['description'] = preg_replace('/ style=""/i', "", $data['description']);
			
			/*
			$data['description1'] = str_replace($search,$replace,html_entity_decode($row['description1']));
			preg_match_all('/<img[^>]+>/i',$data['description1'], $result); 
			foreach( $result[0] as $img_tag)
			{
				$doc = new DOMDocument();
				$doc->loadHTML($img_tag);
				$xpath = new DOMXPath($doc);
				$src = $xpath->evaluate("string(//img/@src)"); # "/images/image.jpg"
				
				list($width_orig_e, $height_orig_e) = getimagesize(DIR_IMAGE . str_replace(HTTP_IMAGE, '', $src));
				
				$data['description1'] = str_replace($img_tag,'<amp-img src="' .$src . '" width="1" height="' . $height_orig_e/$width_orig_e . '" layout="responsive" alt=""></amp-img>',html_entity_decode($data['description1']));
				
			}
			$data['description1'] = preg_replace('/ style="(.+?)"/i', "", $data['description1']);
			$data['description1'] = preg_replace('/ style=""/i', "", $data['description1']);
*/
			
			if(!$cate){
			$data['child'] = $this->getRecruitmentByParent($category_id, $data['id']);
			}
			
			
			
			/*{FRONTEND_DATA_ROW}*/
			$data1[] = $data;
		}

		return $data1;
	}
	
	public function getRecruitmentAmp($recruitment_id)	{
		$this->load->model('cms/recruitment');
		$sql = "SELECT * FROM " . DB_PREFIX . "recruitment p LEFT JOIN " . DB_PREFIX . "recruitment_description pd ON (p.recruitment_id = pd.recruitment_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND p.recruitment_id = '" . $recruitment_id . "'";
		
		$query = $this->db->query($sql);
		
		$data = array();

		$row = $query->row;

		$data['id'] = $row['recruitment_id'];
		$data['name'] = $row['name'];
		
		//$data['name1'] = $row['name1'];
			
			/*$data['soluong'] = $row['soluong'];
			$data['diadiem'] = $row['diadiem'];
			$data['ngayhethan'] = date('d/m/Y', strtotime($row['date_insert']));
			$data['tinhtrang'] = $row['tinhtrangdangtuyen'];
			$data['thunhap'] = $row['thunhap'];*/
		
		$data['href'] = $this->url->link('cms/recruitment','path='. ID_RECRUITMENT . '&recruitment_id='.$row['recruitment_id'],$this->config->get('config_language')) .'.html';
		
			$data['image'] = empty($row['image']) || !is_file(DIR_IMAGE . $row['image'])?'': HTTP_IMAGE . str_replace(' ', '%20', $row['image']);

			$data['image_width'] = $data['image_height'] = $data['image_ratio'] = 1;
			if(!empty($data['image'])){
			list($width_orig, $height_orig) = getimagesize(DIR_IMAGE . str_replace(' ', '%20', $row['image']));
			$data['image_width'] = $width_orig;
			$data['image_height'] = $height_orig;

			$data['image_ratio'] = $height_orig/$width_orig;
			}
			
			
			
    
    	$data['image1'] = empty($row['image1']) || !is_file(DIR_IMAGE . $row['image1'])? '' : HTTP_IMAGE . str_replace(' ', '%20', $row['image1']);
		
		$data['image1_width'] = $data['image1_height'] = $data['image1_ratio'] = 1;
			if(!empty($data['image1'])){
			list($width_orig, $height_orig) = getimagesize(DIR_IMAGE . str_replace(' ', '%20', $row['image1']));
			$data['image1_width'] = $width_orig;
			$data['image1_height'] = $height_orig;
			$data['image1_ratio'] = $height_orig/$width_orig;
			}
    
			$search  = array('<div', '</div>', '<b>', '<b ', '</b>', 'HTTP_CATALOG','<br></i></p>','<br></u></p>','<br></span></p>','<br></p>');
			$replace = array('<p', '</p>', '<strong>', '<strong ', '</strong>', HTTP_SERVER,'</i></p>','</u></p>','</span></p>','</p>');
			$data['description'] = str_replace($search,$replace,html_entity_decode($row['description']));
			preg_match_all('/<img[^>]+>/i',$data['description'], $result); 
			foreach( $result[0] as $img_tag)
			{
				$doc = new DOMDocument();
				$doc->loadHTML($img_tag);
				$xpath = new DOMXPath($doc);
				$src = $xpath->evaluate("string(//img/@src)"); # "/images/image.jpg"
				
				list($width_orig_e, $height_orig_e) = getimagesize(DIR_IMAGE . str_replace(HTTP_IMAGE, '', $src));
				
				$data['description'] = str_replace($img_tag,'<amp-img src="' .$src . '" width="1" height="' . $height_orig_e/$width_orig_e . '" layout="responsive" alt=""></amp-img>',html_entity_decode($data['description']));
				
			}
			$data['description'] = preg_replace('/ style="(.+?)"/i', "", $data['description']);
			$data['description'] = preg_replace('/ style=""/i', "", $data['description']);
			
			
			/*$data['description1'] = str_replace($search,$replace,html_entity_decode($row['description1']));
			preg_match_all('/<img[^>]+>/i',$data['description1'], $result); 
			foreach( $result[0] as $img_tag)
			{
				$doc = new DOMDocument();
				$doc->loadHTML($img_tag);
				$xpath = new DOMXPath($doc);
				$src = $xpath->evaluate("string(//img/@src)"); # "/images/image.jpg"
				
				list($width_orig_e, $height_orig_e) = getimagesize(DIR_IMAGE . str_replace(HTTP_IMAGE, '', $src));
				
				$data['description1'] = str_replace($img_tag,'<amp-img src="' .$src . '" width="1" height="' . $height_orig_e/$width_orig_e . '" layout="responsive" alt=""></amp-img>',html_entity_decode($data['description1']));
				
			}
			$data['description1'] = preg_replace('/ style="(.+?)"/i', "", $data['description1']);
			$data['description1'] = preg_replace('/ style=""/i', "", $data['description1']);
*/

    	
		if(!$row['cate']){
			$data['child'] = $this->getRecruitmentByParent(ID_RECRUITMENT, $data['id']);
		}
    
    	
		/*{FRONTEND_DATA_ROW}*/
		return $data;
	}
	
	public function getBrandAmp($brand_id=0)	{
		$this->load->model('cms/common');
		$sql = "SELECT * FROM " . DB_PREFIX . "brand p LEFT JOIN " . DB_PREFIX . "brand_description pd ON (p.brand_id = pd.brand_id) WHERE p.status='1' AND p.brand_id='$brand_id' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND pd.name<>'' ORDER BY p.sort_order ASC, p.brand_id DESC";

		$query = $this->db->query($sql);
		//$data1 = array();
		$data = array();
		$row = $query->row;
		if(isset($row['brand_id'])){
			
			$data['id'] = $row['brand_id'];
			$data['name'] = $row['name'];
			//$data['desc_short'] = $row['desc_short'];
			//$data['website'] = str_replace('HTTP_CATALOG',HTTP_SERVER,$row['website']);
			

			$data['href'] = $this->url->link('cms/brand','path='. ID_BRAND . '&brand_id='.$row['brand_id'],$this->config->get('config_language')) .'.html';
			
			$data['description'] = str_replace(array('HTTP_CATALOG','<b>','</b>'),array(HTTP_SERVER,'<strong>','</strong>'),html_entity_decode($row['description']));
			//$data['image'] = empty($row['image'])?'': HTTP_IMAGE . str_replace(' ', '%20', $row['image']);
			$data['image'] = empty($row['image'])?'': HTTP_IMAGE . str_replace(' ', '%20', $row['image']);
			$data['image_1x'] = $data['image'];//empty($row['image_x'])?'': HTTP_IMAGE . str_replace(' ', '%20', $row['image_x']);
			
			//list($width_orig, $height_orig) = getimagesize(DIR_IMAGE . str_replace(' ', '%20', $row['image_x']));
			list($width_orig, $height_orig) = getimagesize(DIR_IMAGE . str_replace(' ', '%20', $row['image']));
			$data['image_width'] = $width_orig;
			$data['image_height'] = $height_orig;
			$data['image_ratio'] = $height_orig/$width_orig;
    
			//$data['pdf'] = empty($row['pdf'])? '' : HTTP_PDF . $row['pdf'];
		
			//$data['images'] = $this->getImages($data['id']);
			//$data['imagebrochures'] = $this->getBrochures($data['id']);
		
			$data['meta_title'] = empty($row['meta_title'])?$row['name']:$row['meta_title'];
			$data['meta_keyword'] = $row['meta_keyword'];
			$data['meta_description'] = $row['meta_description'];
			
			$data['image_og'] = $row['image_og'];
			$data['meta_title_og'] = empty($row['meta_title_og'])?$row['meta_title']:$row['meta_title_og'];
			$data['meta_description_og'] = empty($row['meta_description_og'])?$row['meta_description']:$row['meta_description_og'];
		
			/*{FRONTEND_DATA_ROW}*/
			//$data1[] = $data;
		}

		return $data;
	}
	
	public function getProductAmp($product_id=0)	{
		$this->load->model('cms/common');
		$sql = "SELECT * FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE p.status='1' AND p.product_id='$product_id' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND pd.name<>'' ORDER BY p.category_id ASC, p.sort_order ASC, p.product_id DESC";

		$query = $this->db->query($sql);
		//$data1 = array();
		$data = array();
		$row = $query->row;
		if(isset($row['product_id'])){
			
			$data['id'] = $row['product_id'];
			$data['name'] = $row['name'];
			//$data['desc_short'] = $row['desc_short'];
			//$data['website'] = str_replace('HTTP_CATALOG',HTTP_SERVER,$row['website']);
			
			$data['category_id'] = $row['category_id'];

			//$data['href'] = $this->url->link('cms/product','path='. $this->model_cms_common->getPath($row['category_id']) . '&product_id='.$row['product_id'],$this->config->get('config_language')) .'.html';
			$data['href'] = $this->url->link('cms/product','path='. ID_PRODUCT . '&product_id='.$row['product_id'],$this->config->get('config_language')) .'.html';
			
			$data['description'] = str_replace(array('HTTP_CATALOG','<b>','</b>'),array(HTTP_SERVER,'<strong>','</strong>'),html_entity_decode($row['description']));
			//$data['image'] = empty($row['image'])?'': HTTP_IMAGE . str_replace(' ', '%20', $row['image']);
			$data['image'] = empty($row['image'])?'': HTTP_IMAGE . str_replace(' ', '%20', $row['image']);
			$data['image_1x'] = $data['image'];//empty($row['image_x'])?'': HTTP_IMAGE . str_replace(' ', '%20', $row['image_x']);
			
			//list($width_orig, $height_orig) = getimagesize(DIR_IMAGE . str_replace(' ', '%20', $row['image_x']));
			list($width_orig, $height_orig) = getimagesize(DIR_IMAGE . str_replace(' ', '%20', $row['image']));
			$data['image_width'] = $width_orig;
			$data['image_height'] = $height_orig;
			$data['image_ratio'] = $height_orig/$width_orig;
    
			//$data['pdf'] = empty($row['pdf'])? '' : HTTP_PDF . $row['pdf'];
		
			//$data['images'] = $this->getImages($data['id']);
			//$data['imagebrochures'] = $this->getBrochures($data['id']);
		
			$data['meta_title'] = empty($row['meta_title'])?$row['name']:$row['meta_title'];
			$data['meta_keyword'] = $row['meta_keyword'];
			$data['meta_description'] = $row['meta_description'];
			
			$data['image_og'] = $row['image_og'];
			$data['meta_title_og'] = empty($row['meta_title_og'])?$row['meta_title']:$row['meta_title_og'];
			$data['meta_description_og'] = empty($row['meta_description_og'])?$row['meta_description']:$row['meta_description_og'];
		
			/*{FRONTEND_DATA_ROW}*/
			//$data1[] = $data;
		}

		return $data;
	}
	
	
	public function getSolutionAmp($solution_id=0)	{
		$this->load->model('cms/common');
		$sql = "SELECT * FROM " . DB_PREFIX . "solution p LEFT JOIN " . DB_PREFIX . "solution_description pd ON (p.solution_id = pd.solution_id) WHERE p.status='1' AND p.solution_id='$solution_id' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND pd.name<>'' ORDER BY p.sort_order ASC, p.solution_id DESC";

		$query = $this->db->query($sql);
		//$data1 = array();
		$data = array();
		$row = $query->row;
		if(isset($row['solution_id'])){
			
			$data['id'] = $row['solution_id'];
			$data['name'] = $row['name'];
			
			$data['href'] = $this->url->link('cms/solution','path='. ID_PRODUCT . '&solution_id='.$row['solution_id'],$this->config->get('config_language')) .'.html';
			
			$data['description1'] = str_replace(array('HTTP_CATALOG','<b>','</b>'),array(HTTP_SERVER,'<strong>','</strong>'),html_entity_decode($row['description1']));
			preg_match_all('/<img[^>]+>/i',$data['description1'], $result); 
			foreach( $result[0] as $img_tag)
			{
				$doc = new DOMDocument();
				$doc->loadHTML($img_tag);
				$xpath = new DOMXPath($doc);
				$src = $xpath->evaluate("string(//img/@src)"); # "/images/image.jpg"
				
				list($width_orig_e, $height_orig_e) = getimagesize(DIR_IMAGE . str_replace(HTTP_IMAGE, '', $src));
				
				$data['description1'] = str_replace($img_tag,'<amp-img src="' .$src . '" width="1" height="' . $height_orig_e/$width_orig_e . '" layout="responsive" alt=""></amp-img>',html_entity_decode($data['description1']));
				
			}
			$data['description1'] = preg_replace('/ style="(.+?)"/i', "", $data['description1']);
			$data['description1'] = preg_replace('/ style=""/i', "", $data['description1']);
			
			$data['description'] = str_replace(array('HTTP_CATALOG','<b>','</b>'),array(HTTP_SERVER,'<strong>','</strong>'),html_entity_decode($row['description']));
			preg_match_all('/<img[^>]+>/i',$data['description'], $result); 
			foreach( $result[0] as $img_tag)
			{
				$doc = new DOMDocument();
				$doc->loadHTML($img_tag);
				$xpath = new DOMXPath($doc);
				$src = $xpath->evaluate("string(//img/@src)"); # "/images/image.jpg"
				
				list($width_orig_e, $height_orig_e) = getimagesize(DIR_IMAGE . str_replace(HTTP_IMAGE, '', $src));
				
				$data['description'] = str_replace($img_tag,'<amp-img src="' .$src . '" width="1" height="' . $height_orig_e/$width_orig_e . '" layout="responsive" alt=""></amp-img>',html_entity_decode($data['description']));
				
			}
			$data['description'] = preg_replace('/ style="(.+?)"/i', "", $data['description']);
			$data['description'] = preg_replace('/ style=""/i', "", $data['description']);
			

			$data['image'] = empty($row['image'])?'': HTTP_IMAGE . str_replace(' ', '%20', $row['image']);
			$data['image_1x'] = $data['image'];//empty($row['image_x'])?'': HTTP_IMAGE . str_replace(' ', '%20', $row['image_x']);
			
			//list($width_orig, $height_orig) = getimagesize(DIR_IMAGE . str_replace(' ', '%20', $row['image_x']));
			/*list($width_orig, $height_orig) = getimagesize(DIR_IMAGE . str_replace(' ', '%20', $row['image']));
			$data['image_width'] = $width_orig;
			$data['image_height'] = $height_orig;
			$data['image_ratio'] = $height_orig/$width_orig;
		*/
			$data['meta_title'] = empty($row['meta_title'])?$row['name']:$row['meta_title'];
			$data['meta_keyword'] = $row['meta_keyword'];
			$data['meta_description'] = $row['meta_description'];
			
			$data['image_og'] = $row['image_og'];
			$data['meta_title_og'] = empty($row['meta_title_og'])?$row['meta_title']:$row['meta_title_og'];
			$data['meta_description_og'] = empty($row['meta_description_og'])?$row['meta_description']:$row['meta_description_og'];
		
			/*{FRONTEND_DATA_ROW}*/
			//$data1[] = $data;
		}

		return $data;
	}
	
	public function getNewsByCate($category_id,$limit = 150)	{
		$str = '';
		$str_where = '';
		
		$sql = "SELECT * FROM " . DB_PREFIX . "news p LEFT JOIN " . DB_PREFIX . "news_description pd ON (p.news_id = pd.news_id) WHERE p.status='1' AND p.category_id='$category_id' AND p.isamp='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND pd.name<>''  $str_where ORDER BY p.sort_order ASC, p.news_id DESC LIMIT $limit"; 
		//echo $sql;
		
		$data1 = array();
		
			$query = $this->db->query($sql);
			$news_data = $query->rows;
			
			$folder = '';
			$folder_dir = DIR_IMAGE;
			$img_temp = str_replace(HTTP_SERVER,'HTTP_SERVER',PATH_IMAGE_THUMB);
	
			foreach($news_data as $row){
				$data = array();
				$data['id'] = $row['news_id'];
				$data['name'] = $row['name'];
				$data['ishome'] = $row['ishome'];
				$data['isnew'] = $row['isnew'];
				$data['date_insert_default'] = $row['date_insert'];
				$data['date_insert'] = date('d/m/Y',strtotime($row['date_insert']));
				
				if(isset($row['category_id']))
					$data['href'] = $this->url->link('cms/news','path='. ID_NEWS .'_' . $row['category_id'] . '&news_id='.$row['news_id'],$this->config->get('config_language')) .'/amp/';
				else
					$data['href'] = $this->url->link('cms/news','path='. ID_NEWS . '&news_id='.$row['news_id'],$this->config->get('config_language')) .'/amp/';
					
				//$des = str_replace('HTTP_CATALOG',HTTP_SERVER,html_entity_decode($row['description']));
				$search  = array('<div', '</div>', '<b>', '</b>');
				$replace = array('<p', '</p>', '<strong>', '</strong>');
				$des = str_replace($search,$replace,html_entity_decode($row['description']));
				$checkdes = strip_tags($des);
				$data['description'] = !empty($checkdes)?$des:'';
				
				$data['desc_short'] = !empty($row['desc_short'])?trimwidth($row['desc_short'],0,90,''):trimwidth(strip_tags(html_entity_decode($row['description'])),0,200,'...');
				
				preg_match('/<img.+src=[\'"](?P<src>[^\s\'"]*)[\'"].?.*>/i', $data['description'], $image);
				$data['image'] = empty($row['image']) || !is_file($folder_dir . $row['image'])?'': $folder . str_replace(' ', '%20', $row['image']);
				$data['image_width'] = $data['image_height'] = $data['image_ratio'] = 1;
				if(!empty($data['image'])){
				list($width_orig, $height_orig) = getimagesize(DIR_IMAGE . str_replace(' ', '%20', $row['image']));
				$data['image_width'] = $width_orig;
				$data['image_height'] = $height_orig;
				$data['image_ratio'] = $height_orig/$width_orig;
				}
				
				$data['image_amp'] = empty($row['image_amp']) || !is_file($folder_dir . $row['image_amp'])?'': $folder . str_replace(' ', '%20', $row['image_amp']);
				if(!empty($data['image_amp'])){
				list($width_orig, $height_orig) = getimagesize(DIR_IMAGE . str_replace(' ', '%20', $row['image_amp']));
				$data['image_width'] = $width_orig;
				$data['image_height'] = $height_orig;
				$data['image_ratio'] = $height_orig/$width_orig;
				$data['image'] = $data['image_amp'];
				}
				
				$data['meta_title'] = empty($row['meta_title'])?$row['name']:$row['meta_title'];
				$data['meta_keyword'] = $row['meta_keyword'];
				$data['meta_description'] = $row['meta_description'];
				
				$data['image_og'] = $row['image_og'];
				$data['meta_title_og'] = empty($row['meta_title_og'])?$row['meta_title']:$row['meta_title_og'];
				$data['meta_description_og'] = empty($row['meta_description_og'])?$row['meta_description']:$row['meta_description_og'];
			
				/*{FRONTEND_DATA_ROW}*/
				$data1[] = $data;
			}
			
			$news_data = $data1;
			
			
		

		return $news_data;
	}
	
	
	public function getNews($news_id,$category_id=0,$project_id=0)	{
		$sql = "SELECT * FROM " . DB_PREFIX . "news p LEFT JOIN " . DB_PREFIX . "news_description pd ON (p.news_id = pd.news_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND p.news_id = '" . $news_id . "'";

		$query = $this->db->query($sql);
		$data = array();
		
		if(!isset($query->row['news_id'])){
			return $data;
		}
		
		if(isset($_SESSION['scaleimg']) && $_SESSION['scaleimg']=='1'){
			$folder = HTTP_IMAGE_MOBILE;
			$folder_dir = DIR_IMAGE_MOBILE;
			$img_temp = PATH_IMAGE_THUMB_MOBILE;
		}else{
			$folder = HTTP_IMAGE;
			$folder_dir = DIR_IMAGE;
			$img_temp = PATH_IMAGE_THUMB;
		}
		
		$row = $query->row;

		$data['id'] = $row['news_id'];
		$data['news_id'] = $row['news_id'];
		$data['name'] = $row['name'];
		$data['category_id'] = $row['category_id'];
		$data['ishome'] = $row['ishome'];
		$data['sort_order'] = $row['sort_order'];
		$data['date_insert'] = $row['date_insert'];
		
		$data['href'] = $this->url->link('cms/news','path='. ID_NEWS .'_' . $row['category_id'] . '&news_id='.$row['news_id'],$this->config->get('config_language')) .'';
		
		//$data['href_project'] = str_replace(HTTP_SERVER,'HTTP_SERVER',$this->url->link('cms/project','path='. ID_PROJECT .'_' . $category_id . '&project_id='.$project_id . '&page=news' . '&news_id='.$row['news_id'],$this->config->get('config_language')) .'.html');
		
		$search  = array('<div', '</div>', '<b>', '<b ', '</b>', 'HTTP_CATALOG','<br></i></p>','<br></u></p>','<br></span></p>','<br></p>','javascript:void(0);','javascript:void(0)','<iframe','</iframe>');
		$replace = array('<p', '</p>', '<strong>', '<strong ', '</strong>', HTTP_SERVER,'</i></p>','</u></p>','</span></p>','</p>','','','<amp-iframe sandbox="allow-scripts allow-same-origin" layout="responsive" ','</amp-iframe>');
		$data['description'] = str_replace($search,$replace,html_entity_decode($row['description']));
		preg_match_all('/<img[^>]+>/i',$data['description'], $result); 
		foreach( $result[0] as $img_tag)
		{
			$doc = new DOMDocument();
			$doc->loadHTML($img_tag);
			$xpath = new DOMXPath($doc);
			$src = $xpath->evaluate("string(//img/@src)"); # "/images/image.jpg"
			$height_orig_e = 0;
			if(getimagesize(DIR_IMAGE . str_replace(HTTP_IMAGE, '', $src))){
			list($width_orig_e, $height_orig_e) = getimagesize(DIR_IMAGE . str_replace(HTTP_IMAGE, '', $src));
			}
			
			if($width_orig_e==0){
				$width_orig_e = 1;
			}
			$data['description'] = str_replace($img_tag,'<amp-img src="' .$src . '" width="1" height="' . $height_orig_e/$width_orig_e . '" layout="responsive" alt=""></amp-img>',html_entity_decode($data['description']));
			
		}
		$data['description'] = preg_replace('/ style="(.+?)"/i', "", $data['description']);
		$data['description'] = preg_replace('/ style=""/i', "", $data['description']);
		
		
		
		$des = str_replace('HTTP_CATALOG',HTTP_SERVER,html_entity_decode($row['desc_short']));
		$checkdes = strip_tags($des);
		$data['desc_short'] = !empty($checkdes)?$des:'';
		
		$data['image_cache'] = empty($row['image']) || !is_file($folder_dir . $row['image'])?'': str_replace(' ', '%20', $row['image']);
		
		preg_match('/<img.+src=[\'"](?P<src>[^\s\'"]*)[\'"].?.*>/i', $data['description'], $image);
		$data['image'] = empty($row['image']) || !is_file($folder_dir . $row['image'])?'': str_replace(' ', '%20', $row['image']);
		
    	$data['meta_title'] = empty($row['meta_title'])?$row['name']:$row['meta_title'];
		$data['meta_keyword'] = $row['meta_keyword'];
		$data['meta_description'] = $row['meta_description'];
		
		$data['image_og'] = $row['image_og'];
		$data['meta_title_og'] = empty($row['meta_title_og'])?$row['meta_title']:$row['meta_title_og'];
		$data['meta_description_og'] = empty($row['meta_description_og'])?$row['meta_description']:$row['meta_description_og'];
	
		/*{FRONTEND_DATA_ROW}*/
		return $data;
	}
	
	public function getRecruitment($recruitment_id,$category_id=0,$project_id=0)	{
		$sql = "SELECT * FROM " . DB_PREFIX . "recruitment p LEFT JOIN " . DB_PREFIX . "recruitment_description pd ON (p.recruitment_id = pd.recruitment_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND p.recruitment_id = '" . $recruitment_id . "'";

		$query = $this->db->query($sql);
		$data = array();
		
		if(!isset($query->row['recruitment_id'])){
			return $data;
		}
		
		if(isset($_SESSION['scaleimg']) && $_SESSION['scaleimg']=='1'){
			$folder = HTTP_IMAGE_MOBILE;
			$folder_dir = DIR_IMAGE_MOBILE;
			$img_temp = PATH_IMAGE_THUMB_MOBILE;
		}else{
			$folder = HTTP_IMAGE;
			$folder_dir = DIR_IMAGE;
			$img_temp = PATH_IMAGE_THUMB;
		}
		
		$row = $query->row;

		$data['id'] = $row['recruitment_id'];
		$data['recruitment_id'] = $row['recruitment_id'];
		$data['name'] = $row['name'];
		//$data['category_id'] = $row['category_id'];
		$data['ishome'] = $row['ishome'];
		$data['sort_order'] = $row['sort_order'];
		$data['date_insert'] = $row['date_insert'];
		
		$data['href'] = $this->url->link('cms/recruitment','path='. ID_NEWS .'_' . $category_id . '&recruitment_id='.$row['recruitment_id'],$this->config->get('config_language')) .'';
		
		//$data['href_project'] = str_replace(HTTP_SERVER,'HTTP_SERVER',$this->url->link('cms/project','path='. ID_PROJECT .'_' . $category_id . '&project_id='.$project_id . '&page=recruitment' . '&recruitment_id='.$row['recruitment_id'],$this->config->get('config_language')) .'.html');
		
		$search  = array('<div', '</div>', '<b>', '<b ', '</b>', 'HTTP_CATALOG','<br></i></p>','<br></u></p>','<br></span></p>','<br></p>','javascript:void(0);','javascript:void(0)','<iframe','</iframe>');
		$replace = array('<p', '</p>', '<strong>', '<strong ', '</strong>', HTTP_SERVER,'</i></p>','</u></p>','</span></p>','</p>','','','<amp-iframe sandbox="allow-scripts allow-same-origin" layout="responsive" ','</amp-iframe>');
		$data['description'] = str_replace($search,$replace,html_entity_decode($row['description']));
		preg_match_all('/<img[^>]+>/i',$data['description'], $result); 
		foreach( $result[0] as $img_tag)
		{
			$doc = new DOMDocument();
			$doc->loadHTML($img_tag);
			$xpath = new DOMXPath($doc);
			$src = $xpath->evaluate("string(//img/@src)"); # "/images/image.jpg"
			$height_orig_e = 0;
			if(getimagesize(DIR_IMAGE . str_replace(HTTP_IMAGE, '', $src))){
			list($width_orig_e, $height_orig_e) = getimagesize(DIR_IMAGE . str_replace(HTTP_IMAGE, '', $src));
			}
			
			if($width_orig_e==0){
				$width_orig_e = 1;
			}
			$data['description'] = str_replace($img_tag,'<amp-img src="' .$src . '" width="1" height="' . $height_orig_e/$width_orig_e . '" layout="responsive" alt=""></amp-img>',html_entity_decode($data['description']));
			
		}
		$data['description'] = preg_replace('/ style="(.+?)"/i', "", $data['description']);
		$data['description'] = preg_replace('/ style=""/i', "", $data['description']);
		
		
		
		//$des = str_replace('HTTP_CATALOG',HTTP_SERVER,html_entity_decode($row['desc_short']));
		//$checkdes = strip_tags($des);
		$data['desc_short'] = '';//!empty($checkdes)?$des:'';
		
		$data['image_cache'] = empty($row['image']) || !is_file($folder_dir . $row['image'])?'': str_replace(' ', '%20', $row['image']);
		
		preg_match('/<img.+src=[\'"](?P<src>[^\s\'"]*)[\'"].?.*>/i', $data['description'], $image);
		$data['image'] = empty($row['image']) || !is_file($folder_dir . $row['image'])?'': str_replace(' ', '%20', $row['image']);
		
    	$data['meta_title'] = empty($row['meta_title'])?$row['name']:$row['meta_title'];
		$data['meta_keyword'] = $row['meta_keyword'];
		$data['meta_description'] = $row['meta_description'];
		
		$data['image_og'] = $row['image_og'];
		$data['meta_title_og'] = empty($row['meta_title_og'])?$row['meta_title']:$row['meta_title_og'];
		$data['meta_description_og'] = empty($row['meta_description_og'])?$row['meta_description']:$row['meta_description_og'];
	
		/*{FRONTEND_DATA_ROW}*/
		return $data;
	}
	
	private function weekOfMonth($date) {
		//Get the first day of the month.
		$firstOfMonth = strtotime(date("Y-m-01", $date));
		//Apply above formula.
		return intval(date("W", $date)) - intval(date("W", $firstOfMonth)) + 1;
	}
	
	public function getLatestnews($latestnews_id,$category_id=0,$project_id=0)	{
		$sql = "SELECT * FROM " . DB_PREFIX . "latestnews p LEFT JOIN " . DB_PREFIX . "latestnews_description pd ON (p.latestnews_id = pd.latestnews_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND p.latestnews_id = '" . $latestnews_id . "'";

		$query = $this->db->query($sql);
		$data = array();
		
		if(!isset($query->row['latestnews_id'])){
			return $data;
		}
		
		if(isset($_SESSION['scaleimg']) && $_SESSION['scaleimg']=='1'){
			$folder = HTTP_IMAGE_MOBILE;
			$folder_dir = DIR_IMAGE_MOBILE;
			$img_temp = PATH_IMAGE_THUMB_MOBILE;
		}else{
			$folder = HTTP_IMAGE;
			$folder_dir = DIR_IMAGE;
			$img_temp = PATH_IMAGE_THUMB;
		}
		
		$row = $query->row;

		$data['id'] = $row['latestnews_id'];
		$data['latestnews_id'] = $row['latestnews_id'];
		$data['name'] = $row['name'];
		//$data['category_id'] = $row['category_id'];
		$data['ishome'] = $row['ishome'];
		$data['sort_order'] = $row['sort_order'];
		$data['date_insert'] = $row['date_insert'];
		$data['weekend'] = $this->weekOfMonth(strtotime($row['date_insert']));
		
		$data['href'] = $this->url->link('cms/latestnews','path='. ID_NEWS .'_' . $category_id . '&latestnews_id='.$row['latestnews_id'],$this->config->get('config_language')) .'';
		
		//$data['href_project'] = str_replace(HTTP_SERVER,'HTTP_SERVER',$this->url->link('cms/project','path='. ID_PROJECT .'_' . $category_id . '&project_id='.$project_id . '&page=latestnews' . '&latestnews_id='.$row['latestnews_id'],$this->config->get('config_language')) .'.html');
		
		$search  = array('<div', '</div>', '<b>', '<b ', '</b>', 'HTTP_CATALOG','<br></i></p>','<br></u></p>','<br></span></p>','<br></p>','javascript:void(0);','javascript:void(0)','<iframe','</iframe>');
		$replace = array('<p', '</p>', '<strong>', '<strong ', '</strong>', HTTP_SERVER,'</i></p>','</u></p>','</span></p>','</p>','','','<amp-iframe sandbox="allow-scripts allow-same-origin" layout="responsive" ','</amp-iframe>');
		$data['description'] = str_replace($search,$replace,html_entity_decode($row['description']));
		preg_match_all('/<img[^>]+>/i',$data['description'], $result); 
		foreach( $result[0] as $img_tag)
		{
			$doc = new DOMDocument();
			$doc->loadHTML($img_tag);
			$xpath = new DOMXPath($doc);
			$src = $xpath->evaluate("string(//img/@src)"); # "/images/image.jpg"
			$height_orig_e = 0;
			if(getimagesize(DIR_IMAGE . str_replace(HTTP_IMAGE, '', $src))){
			list($width_orig_e, $height_orig_e) = getimagesize(DIR_IMAGE . str_replace(HTTP_IMAGE, '', $src));
			}
			
			if($width_orig_e==0){
				$width_orig_e = 1;
			}
			$data['description'] = str_replace($img_tag,'<amp-img src="' .$src . '" width="1" height="' . $height_orig_e/$width_orig_e . '" layout="responsive" alt=""></amp-img>',html_entity_decode($data['description']));
			
		}
		$data['description'] = preg_replace('/ style="(.+?)"/i', "", $data['description']);
		$data['description'] = preg_replace('/ style=""/i', "", $data['description']);
		
		
		
		//$des = str_replace('HTTP_CATALOG',HTTP_SERVER,html_entity_decode($row['desc_short']));
		//$checkdes = strip_tags($des);
		$data['desc_short'] = '';//!empty($checkdes)?$des:'';
		
		$data['image_cache'] = empty($row['image']) || !is_file($folder_dir . $row['image'])?'': str_replace(' ', '%20', $row['image']);
		
		if((int)$this->config->get('config_language_id')==2){
			$data['pdf'] = empty($row['pdf']) || !is_file(DIR_BANTIN_VN . $row['pdf'])? '' : HTTP_BANTIN_VN . $row['pdf'];
		}else{
			$data['pdf'] = empty($row['pdf']) || !is_file(DIR_BANTIN_EN . $row['pdf'])? '' : HTTP_BANTIN_EN . $row['pdf'];
		}
		
		preg_match('/<img.+src=[\'"](?P<src>[^\s\'"]*)[\'"].?.*>/i', $data['description'], $image);
		$data['image'] = empty($row['image']) || !is_file($folder_dir . $row['image'])?'': str_replace(' ', '%20', $row['image']);
		
    	$data['meta_title'] = empty($row['meta_title'])?$row['name']:$row['meta_title'];
		$data['meta_keyword'] = $row['meta_keyword'];
		$data['meta_description'] = $row['meta_description'];
		
		$data['image_og'] = $row['image_og'];
		$data['meta_title_og'] = empty($row['meta_title_og'])?$row['meta_title']:$row['meta_title_og'];
		$data['meta_description_og'] = empty($row['meta_description_og'])?$row['meta_description']:$row['meta_description_og'];
	
		/*{FRONTEND_DATA_ROW}*/
		return $data;
	}
	
	
	

}
?>
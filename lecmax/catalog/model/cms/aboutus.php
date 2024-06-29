<?php
class ModelCmsAboutus extends Model {

	//Lay tat ca
	public function getAboutuss($category_id=0)	{
		$sql = "SELECT p.aboutus_id, p.image, p.image1, p.image2, p.image_og, pd.name, pd.name1, pd.name2, pd.description, pd.meta_title, pd.meta_description, pd.meta_keyword, pd.meta_title_og, pd.meta_description_og FROM " . DB_PREFIX . "aboutus p LEFT JOIN " . DB_PREFIX . "aboutus_description pd ON (p.aboutus_id = pd.aboutus_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND pd.name<>'' ORDER BY p.sort_order ASC, p.aboutus_id DESC";

		$query = $this->db->query($sql);
		$data1 = array();

		foreach($query->rows as $row){
			$data = array();
			$data['id'] = $row['aboutus_id'];
			$data['name'] = $row['name'];
			$data['name2'] = $row['name2'];
			$search  = array('<div>', '</div>', '<p>', '</p>', '<b>', '</b>');
			$replace = array('', '', '', '', '<strong>', '</strong>');
			$name1 = strip_tags(html_entity_decode((string)$row['name1']));
			$data['name1'] = !empty($name1)?str_replace($search,$replace,html_entity_decode((string)$row['name1'])):'';

			if(isset($row['category_id']))
				$data['href'] = str_replace(HTTP_SERVER,'HTTP_SERVER',$this->url->link('cms/aboutus','path='. $category_id .'_' . $row['category_id'] . '&aboutus_id='.$row['aboutus_id'],$this->config->get('config_language')) .'.html');
			else
				$data['href'] = str_replace(HTTP_SERVER,'HTTP_SERVER',$this->url->link('cms/aboutus','path='. $category_id . '&aboutus_id='.$row['aboutus_id'],$this->config->get('config_language')) .'.html');

			$search  = array('<div', '</div>', '<b>', '<b ', '</b>','<br></i></p>','<br></u></p>','<br></span></p>','<br></p>');
			$replace = array('<p', '</p>', '<strong>', '<strong ', '</strong>','</i></p>','</u></p>','</span></p>','</p>');
			$data['description'] = str_replace($search,$replace,html_entity_decode((string)$row['description']));
			$data['image'] = empty($row['image']) || !is_file(DIR_IMAGE . $row['image'])?'': str_replace(' ', '%20', (string)$row['image']);
    
    		$data['image1'] = empty($row['image1']) || !is_file(DIR_IMAGE . $row['image1'])?'': str_replace(' ', '%20', (string)$row['image1']);
			$data['image2'] = empty($row['image2']) || !is_file(DIR_IMAGE . $row['image2'])?'': str_replace(' ', '%20', (string)$row['image2']);
			
			$data['image_sodo'] = ($this->config->get('config_language_id')==1)?$data['image2']:$data['image1'];
    
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
			$name2 = strip_tags(html_entity_decode((string)$row['name2']));
			
			$search  = array('<div>', '</div>', '<p>', '</p>', '<b>', '</b>', 'HTTP_CATALOG');
			$replace = array('', '', '', '', '<strong>', '</strong>', HTTP_SERVER);
			$name1 = strip_tags(html_entity_decode((string)$row['name1']));
			$data['name1'] = !empty($name1)?str_replace($search,$replace,html_entity_decode((string)$row['name1'])):'';
			
			$data['name2'] = html_entity_decode((string)$row['name2']);
			$data['address'] = $row['address'];
			$data['chucvu'] = $row['address'];
			$data['hoten'] = $row['desc_short'];
			
			$data['gioitinh'] = $row['gioitinh'];
			
			$data['phone'] = $row['phone'];
			$data['email'] = $row['email'];
			$data['fax'] = $row['fax'];
			$search = array(' ', '.', ':', '-', '_', '(', ')', ',', ';');
			$replace = array('', '', '', '', '', '', '', '', '');
			$data['phone_tel'] = str_replace($search,$replace,(string)$row['phone']);
			$data['fax_tel'] = str_replace($search,$replace,(string)$row['fax']);
			
			$data['desc_short'] = nl2br((string)$row['desc_short']);
			
			$search  = array('<div', '</div>', '<b>', '<b ', '</b>', 'HTTP_CATALOG');
			$replace = array('<p', '</p>', '<strong>', '<strong ', '</strong>', HTTP_SERVER);
			
			$desc_short = strip_tags(html_entity_decode((string)$row['desc_short']));
			$data['desc_short'] = !empty($desc_short)?str_replace($search,$replace,html_entity_decode((string)$row['desc_short'])):'';
			
			
			
			$search  = array('<div>', '</div>', '<p>', '</p>', '<b>', '</b>', 'HTTP_CATALOG');
			$replace = array('', '', '', '', '<strong>', '</strong>', HTTP_SERVER);
			$desc_short1 = strip_tags(html_entity_decode((string)$row['desc_short1']));
			$data['desc_short1'] = !empty($desc_short1)?str_replace($search,$replace,html_entity_decode((string)$row['desc_short1'])):'';
			
			$data['pdf'] = empty($row['pdf']) || !is_file(DIR_PDF . $row['pdf'])?'': $row['pdf'];

			if(isset($row['category_id']))
				$data['href'] = str_replace(HTTP_SERVER,'HTTP_SERVER',$this->url->link('cms/aboutus','path='. $category_id .'_' . $row['category_id'] . '&aboutus_id='.$row['aboutus_id'],$this->config->get('config_language')) .'.html');
			else
				$data['href'] = str_replace(HTTP_SERVER,'HTTP_SERVER',$this->url->link('cms/aboutus','path='. $category_id . '&aboutus_id='.$row['aboutus_id'],$this->config->get('config_language')) .'.html');

			
			$search  = array('<div', '</div>', '<b>', '<b ', '</b>','<br></i></p>','<br></u></p>','<br></span></p>','<br></p>');
			$replace = array('<p', '</p>', '<strong>', '<strong ', '</strong>','</i></p>','</u></p>','</span></p>','</p>');
			$des = str_replace($search,$replace,html_entity_decode((string)$row['description']));
			if(strpos($des,'<img')){
				$data['description'] = $des;
			}else{
				$checkdes = trim(strip_tags($des));
				$data['description'] = !empty($checkdes)?$des:'';
			}
			
			$search  = array('<div', '</div>', '<b>', '<b ', '</b>','<br></i></p>','<br></u></p>','<br></span></p>','<br></p>');
			$replace = array('<p', '</p>', '<strong>', '<strong ', '</strong>','</i></p>','</u></p>','</span></p>','</p>');
			$des = str_replace($search,$replace,html_entity_decode((string)$row['description1']));
			if(strpos($des,'<img')){
				$data['description1'] = $des;
			}else{
				$checkdes = trim(strip_tags($des));
				$data['description1'] = !empty($checkdes)?$des:'';
			}
			
			preg_match('/<img.+src=[\'"](?P<src>[^\s\'"]*)[\'"].?.*>/i', $data['description'], $image);
			$data['image'] = empty($row['image']) || !is_file($folder_dir . $row['image'])?'': str_replace(' ', '%20', (string)$row['image']);
			//$data['image'] = empty($data['image'])&&isset($image['src'])&& !empty($image['src'])?$image['src']:$data['image'];
			//$data['image'] = empty($data['image'])?$img_temp:$data['image'];
			
			
			$data['image1'] = empty($row['image1']) || !is_file($folder_dir . $row['image1'])?'': str_replace(' ', '%20', (string)$row['image1']);
			$data['image2'] = empty($row['image2']) || !is_file($folder_dir . $row['image2'])?'': str_replace(' ', '%20', (string)$row['image2']);
			$data['image_chungnhan'] = ($this->config->get('config_language_id')==1)?$data['image1']:$data['image'];
			
			$data['image_sodo'] = ($this->config->get('config_language_id')==1)?$data['image2']:$data['image1'];
			
			$data['image_video'] = empty($row['image_video']) || !is_file(DIR_IMAGE . $row['image_video'])?'': str_replace(' ', '%20', (string)$row['image_video']);
			$data['isyoutube'] = $row['isyoutube'];
			$data['script'] = html_entity_decode((string)$row['script']);
			$data['filename_mp4'] = !empty($row['filename_mp4']) && is_file(DIR_DOWNLOAD . $row['filename_mp4'])?$row['filename_mp4']:'';
			
			$data['videoyoutubeid'] = getYoutubeVideoId(html_entity_decode((string)$row['script']));
			
			$data['images'] = $this->getImages($data['id']);
			if($row['cate']==0 || $row['cate']==12 || $row['cate']==93){
			$data['child'] = $this->getAboutusByParent($category_id, $data['id']);
			}
			
			$search  = array('<br>', '<br />', '<br/>');
			$replace = array('</p></li><li><p>', '</p></li><li><p>', '</p></li><li><p>');
			$des = str_replace($search,$replace,html_entity_decode(nl2br((string)$row['desc_short'])));
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

	/*{FRONTEND_GET_BY_CATE}*/

	/*{FRONTEND_GET_HOME}*/
public function getHome($cate=0)	{	
	$sql = "SELECT * FROM " . DB_PREFIX . "aboutus p LEFT JOIN " . DB_PREFIX . "aboutus_description pd ON (p.aboutus_id = pd.aboutus_id) WHERE p.status='1' AND p.cate='$cate' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND pd.name<>'' AND p.ishome='1' ORDER BY  p.sort_order ASC, p.aboutus_id DESC LIMIT 10"; 

	$query = $this->db->query($sql);
	$data1 = array();

	foreach($query->rows as $row){
		$data = array();
		$data['id'] = $row['aboutus_id'];
		$data['name'] = $row['name'];	
		$data['image_video'] = empty($row['image_video']) || !is_file(DIR_IMAGE . $row['image_video'])?'': HTTP_IMAGE . str_replace(' ', '%20', (string)$row['image_video']);
		$data['image_home'] = empty($row['image_home']) || !is_file(DIR_IMAGE . $row['image_home'])?'': HTTP_IMAGE . str_replace(' ', '%20', (string)$row['image_home']);
		$data['image'] = empty($row['image']) || !is_file(DIR_IMAGE . $row['image'])?$data['image_video']: HTTP_IMAGE . str_replace(' ', '%20', (string)$row['image']);
		$data['isyoutube'] = $row['isyoutube'];
		/*if((int)$this->config->get('config_language_id')==1){
			$data['script'] = html_entity_decode((string)$row['scripten']);
			$data['filename_mp4'] = !empty($row['filename_webm'])?HTTP_DOWNLOAD.$row['filename_webm']:'';
		}else{*/
			$data['script'] = html_entity_decode((string)$row['script']);
			$data['filename_mp4'] = !empty($row['filename_mp4']) && is_file(DIR_DOWNLOAD . $row['filename_mp4'])?HTTP_DOWNLOAD.$row['filename_mp4']:'';
		//}
		
		$data['images'] = $this->getImages($data['id']);
		
		$data['href_video'] = HTTP_SERVER . 'view-video-aboutus.html?id=' . $row['aboutus_id'];
		$data['href_album'] = HTTP_SERVER . 'view-album-aboutus.html?id=' . $row['aboutus_id'];
		$data1[] = $data;
	}

	return $data1;
}

	//Lay dua vao id
	public function getAboutus($aboutus_id)	{
		$sql = "SELECT p.aboutus_id, p.image, p.image1, p.isyoutube, p.script, p.filename_mp4, p.image_video, p.image_og, pd.name, pd.name2, pd.description1, pd.description, pd.meta_title, pd.meta_description, pd.meta_keyword, pd.meta_title_og, pd.meta_description_og FROM " . DB_PREFIX . "aboutus p LEFT JOIN " . DB_PREFIX . "aboutus_description pd ON (p.aboutus_id = pd.aboutus_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND p.aboutus_id = '" . $aboutus_id . "'";

		$query = $this->db->query($sql);
		$data = array();

		$row = $query->row;

		$data['id'] = $row['aboutus_id'];
		$data['name'] = $row['name'];
		$data['name2'] = $row['name2'];
		$search  = array('<div', '</div>', '<b>', '<b ', '</b>','<br></i></p>','<br></u></p>','<br></span></p>','<br></p>', 'HTTP_CATALOG');
		$replace = array('<p', '</p>', '<strong>', '<strong ', '</strong>','</i></p>','</u></p>','</span></p>','</p>', HTTP_SERVER);
		$des = str_replace($search,$replace,html_entity_decode((string)$row['description']));
		if(strpos($des,'<img')){
			$data['description'] = $des;
		}else{
			$checkdes = trim(strip_tags($des));
			$data['description'] = !empty($checkdes)?$des:'';
		}
		
		$data['image'] = empty($row['image']) || !is_file(DIR_IMAGE . $row['image'])?'': HTTP_IMAGE . str_replace(' ', '%20', (string)$row['image']);
    
    	$data['image1'] = empty($row['image1']) || !is_file(DIR_IMAGE . $row['image1'])? '' : HTTP_IMAGE . str_replace(' ', '%20', (string)$row['image1']);
		
		$data['image_video'] = empty($row['image_video']) || !is_file(DIR_IMAGE . $row['image_video'])?'': HTTP_IMAGE . str_replace(' ', '%20', (string)$row['image_video']);
		$data['isyoutube'] = $row['isyoutube'];
		$data['script'] = html_entity_decode((string)$row['script']);
		$data['filename_mp4'] = !empty($row['filename_mp4']) && is_file(DIR_DOWNLOAD . $row['filename_mp4'])?HTTP_DOWNLOAD.$row['filename_mp4']:'';
		
		$search  = array('<div', '</div>', '<b>', '<b ', '</b>','<br></i></p>','<br></u></p>','<br></span></p>','<br></p>', 'HTTP_CATALOG');
		$replace = array('<p', '</p>', '<strong>', '<strong ', '</strong>','</i></p>','</u></p>','</span></p>','</p>', HTTP_SERVER);
		$des = str_replace($search,$replace,html_entity_decode((string)$row['description1']));
		if(strpos($des,'<img')){
			$data['description1'] = $des;
		}else{
			$checkdes = trim(strip_tags($des));
			$data['description1'] = !empty($checkdes)?$des:'';
		}
    
    	$data['images'] = $this->getImages($data['id']);
    
    	$data['meta_title'] = empty($row['meta_title'])?$row['name']:$row['meta_title'];
		$data['meta_keyword'] = $row['meta_keyword'];
		$data['meta_description'] = $row['meta_description'];
		
		$data['image_og'] = $row['image_og'];
		$data['meta_title_og'] = empty($row['meta_title_og'])?$row['meta_title']:$row['meta_title_og'];
		$data['meta_description_og'] = empty($row['meta_description_og'])?$row['meta_description']:$row['meta_description_og'];
	
		/*{FRONTEND_DATA_ROW}*/
		return $data;
	}

		//Lay hinh dua vao id
	public function getImages($aboutus_id){
		$query = $this->db->query("SELECT aboutus_image_id, image, image1, image_name, image_name_en, image_desc, image_desc_en FROM ".DB_PREFIX."aboutus_image WHERE aboutus_id='".(int)$aboutus_id."' ORDER BY image_sort_order ASC");
		
		$data = array();
		
		if(isset($_SESSION['scaleimg']) && $_SESSION['scaleimg']=='1'){
			$folder = HTTP_IMAGE_MOBILE;
			$folder_dir = DIR_IMAGE_MOBILE;
		}else{
			$folder = HTTP_IMAGE;
			$folder_dir = DIR_IMAGE;
		}
		
		foreach($query->rows as $rs){
			$data1 = array();
			$data1['id'] = $rs['aboutus_image_id'];
			$data1['image'] = empty($rs['image']) || !is_file($folder_dir . $rs['image'])?'': str_replace(' ', '%20', (string)$rs['image']);
			
			$data1['image_width'] = $data1['image_height'] = $data1['image_ratio'] = 1;
			if(!empty($data1['image']) && is_file($folder_dir . $data1['image'])){
			list($width_orig, $height_orig) = getimagesize(DIR_IMAGE . str_replace(' ', '%20', (string)$data1['image']));
			$data1['image_width'] = $width_orig;
			$data1['image_height'] = $height_orig;
			$data1['image_ratio'] = $height_orig/$width_orig;
			}
			
			
			$data1['image1'] = empty($rs['image1']) || !is_file($folder_dir . $rs['image1'])? '': str_replace(' ', '%20', (string)$rs['image1']);
			
			$data1['image1_width'] = $data1['image1_height'] = $data1['image1_ratio'] = 1;
			if(!empty($data1['image1']) && is_file($folder_dir . $data1['image1'])){
			list($width_orig, $height_orig) = getimagesize(DIR_IMAGE . str_replace(' ', '%20', (string)$data1['image1']));
			$data1['image1_width'] = $width_orig;
			$data1['image1_height'] = $height_orig;
			$data1['image1_ratio'] = $height_orig/$width_orig;
			}
			
			
			$data1['name'] = ($this->config->get('config_language_id')==1)?trim(html_entity_decode(nl2br((string)$rs['image_name_en']))):trim(html_entity_decode(nl2br((string)$rs['image_name'])));
			$data1['desc_short'] = ($this->config->get('config_language_id')==1)?trim(html_entity_decode(nl2br((string)$rs['image_desc_en']))):trim(html_entity_decode(nl2br((string)$rs['image_desc'])));
			
			$data1['image_lang'] = ($this->config->get('config_language_id')==1)?trim(html_entity_decode(nl2br((string)$data1['image1']))):trim(html_entity_decode(nl2br((string)$data1['image'])));
			
			//$data1['date'] = ($this->config->get('config_language_id')==1)?trim(html_entity_decode(nl2br((string)$rs['image_date']))):trim(html_entity_decode(nl2br((string)$rs['image_date'])));
			
			//$data1['isfull'] = $rs['image_isfull'];
			
			$data[] = $data1;
		}
		return $data;
	}

	public function getAboutusAll($category_id=0) {
		$sql = "SELECT * FROM " . DB_PREFIX . "aboutus p LEFT JOIN " . DB_PREFIX . "aboutus_description pd ON (p.aboutus_id = pd.aboutus_id) WHERE p.status='1' AND p.cate='0' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND pd.name<>'' ORDER BY p.date_modified DESC, p.date_added DESC, p.sort_order ASC, p.aboutus_id DESC";

		$query = $this->db->query($sql);

		return $query->rows;
	}

}
?>
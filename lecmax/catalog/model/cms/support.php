<?php
class ModelCmsSupport extends Model {

	//Lay tat ca
	public function getSupports($category_id=0)	{
		$sql = "SELECT * FROM " . DB_PREFIX . "support p LEFT JOIN " . DB_PREFIX . "support_description pd ON (p.support_id = pd.support_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND pd.name<>'' ORDER BY p.sort_order ASC, p.support_id DESC";

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
			$data['id'] = $row['support_id'];
			$data['name'] = $row['name'];
			$data['ishome'] = $row['ishome'];

			if(isset($row['category_id']))
				$data['href'] = $this->url->link('cms/support','path='. $category_id .'_' . $row['category_id'] . '&support_id='.$row['support_id']) .'.html';
			else
				$data['href'] = $this->url->link('cms/support','path='. $category_id . '&support_id='.$row['support_id']) .'.html';

			$des = str_replace('HTTP_CATALOG',HTTP_SERVER,html_entity_decode((string)$row['description']));
			$checkdes = strip_tags($des);
			$data['description'] = !empty($checkdes)?$des:'';
			
			$des = str_replace('HTTP_CATALOG',HTTP_SERVER,html_entity_decode((string)$row['desc_short']));
			$checkdes = strip_tags($des);
			$data['desc_short'] = !empty($checkdes)?$des:'';
			
			preg_match('/<img.+src=[\'"](?P<src>[^\s\'"]*)[\'"].?.*>/i', $data['description'], $image);
			$data['image'] = empty($row['image']) || !is_file($folder_dir . $row['image'])?'': $folder . str_replace(' ', '%20', (string)$row['image']);
			$data['image'] = empty($data['image'])&&isset($image['src'])&& !empty($image['src'])?$image['src']:$data['image'];
			$data['image'] = empty($data['image'])?$img_temp:$data['image'];
    
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
	public function getSupportByParent($category_id=0, $cate=0)	{
		$sql = "SELECT * FROM " . DB_PREFIX . "support p LEFT JOIN " . DB_PREFIX . "support_description pd ON (p.support_id = pd.support_id) WHERE p.status='1' AND p.cate='$cate' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND pd.name<>'' ORDER BY p.sort_order ASC, p.support_id DESC";

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
			$data['id'] = $row['support_id'];
			$data['name'] = $row['name'];
			$data['ishome'] = $row['ishome'];

			if(isset($row['category_id']))
				$data['href'] = $this->url->link('cms/support','path='. $category_id .'_' . $row['category_id'] . '&support_id='.$row['support_id']) .'.html';
			else
				$data['href'] = $this->url->link('cms/support','path='. $category_id . '&support_id='.$row['support_id']) .'.html';

			$des = str_replace('HTTP_CATALOG',HTTP_SERVER,html_entity_decode((string)$row['description']));
			$checkdes = strip_tags($des);
			$data['description'] = !empty($checkdes)?$des:'';
			
			$data['desc_short'] = !empty($row['desc_short'])?nl2br((string)$row['desc_short']):trimwidth(strip_tags(html_entity_decode((string)$row['description'])),0,200,'...');
    		
			preg_match('/<img.+src=[\'"](?P<src>[^\s\'"]*)[\'"].?.*>/i', $data['description'], $image);
			$data['image'] = empty($row['image']) || !is_file($folder_dir . $row['image'])?'': $folder . str_replace(' ', '%20', (string)$row['image']);
			$data['image'] = empty($data['image'])&&isset($image['src'])&& !empty($image['src'])?$image['src']:$data['image'];
			$data['image'] = empty($data['image'])?$img_temp:$data['image'];
    
			$data['images'] = $this->getImages($data['id']);
		
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

		//Lay dua vao danh muc
	public function getSupportByCate($category_id)	{	
		$sql = "SELECT * FROM " . DB_PREFIX . "support p LEFT JOIN " . DB_PREFIX . "support_description pd ON (p.support_id = pd.support_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND pd.name<>'' AND p.category_id='" . (int)$category_id . "' ORDER BY p.sort_order ASC, p.support_id DESC"; 
		
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
			$data['id'] = $row['support_id'];
			$data['name'] = $row['name'];
			$data['ishome'] = $row['ishome'];
			
			if(isset($row['category_id']))
				$data['href'] = $this->url->link('cms/support','path='. ID_SUPPORT .'_' . $row['category_id'] . '&support_id='.$row['support_id']) .'.html';
			else
				$data['href'] = $this->url->link('cms/support','path='. ID_SUPPORT . '&support_id='.$row['support_id']) .'.html';
				
			$des = str_replace('HTTP_CATALOG',HTTP_SERVER,html_entity_decode((string)$row['description']));
			$checkdes = strip_tags($des);
			$data['description'] = !empty($checkdes)?$des:'';
			
			$data['desc_short'] = !empty($row['desc_short'])?nl2br((string)$row['desc_short']):trimwidth(strip_tags(html_entity_decode((string)$row['description'])),0,200,'...');
    		
			preg_match('/<img.+src=[\'"](?P<src>[^\s\'"]*)[\'"].?.*>/i', $data['description'], $image);
			$data['image'] = empty($row['image']) || !is_file($folder_dir . $row['image'])?'': $folder . str_replace(' ', '%20', (string)$row['image']);
			$data['image'] = empty($data['image'])&&isset($image['src'])&& !empty($image['src'])?$image['src']:$data['image'];
			$data['image'] = empty($data['image'])?$img_temp:$data['image'];
			
			$data['pdf'] = empty($row['pdf']) || !is_file(DIR_PDF . $row['pdf'])?'': HTTP_PDF . $row['pdf'];
			
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

	//ISHOME
public function getHome()	{	
	$sql = "SELECT * FROM " . DB_PREFIX . "support p LEFT JOIN " . DB_PREFIX . "support_description pd ON (p.support_id = pd.support_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND pd.name<>'' AND p.ishome='1' ORDER BY p.sort_order ASC, p.support_id DESC LIMIT 7"; 

	$query = $this->db->query($sql);
	$data1 = array();

	foreach($query->rows as $row){
		$data = array();
		$data['id'] = $row['support_id'];
		$data['name'] = $row['name'];
		$data['sort_order'] = $row['sort_order'];
		$data['date_modified'] = $row['date_modified'];
		$data['href'] = $this->url->link('cms/support','path='. ID_SUPPORT .'_' . $row['category_id'] . '&support_id='.$row['support_id']) .'.html';
		$data['description'] = str_replace('HTTP_CATALOG',HTTP_SERVER,html_entity_decode((string)$row['description']));
		preg_match('/<img.+src=[\'"](?P<src>[^\s\'"]*)[\'"].?.*>/i', $data['description'], $image);
		$data['image'] = empty($row['image']) || !is_file(DIR_IMAGE . $row['image'])?'': HTTP_IMAGE . str_replace(' ', '%20', (string)$row['image']);
		$data['image'] = empty($data['image'])&&isset($image['src'])&& !empty($image['src'])?$image['src']:$data['image'];
		$data['image'] = empty($data['image'])?PATH_IMAGE_THUMB:$data['image'];
		$data1[] = $data;
	}

	return $data1;
}

	//Lay dua vao id
	public function getSupport($support_id)	{
		$sql = "SELECT * FROM " . DB_PREFIX . "support p LEFT JOIN " . DB_PREFIX . "support_description pd ON (p.support_id = pd.support_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND p.support_id = '" . $support_id . "'";

		$query = $this->db->query($sql);
		$data = array();
		
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

		$data['id'] = $row['support_id'];
		$data['name'] = $row['name'];
		$data['ishome'] = $row['ishome'];
		$data['sort_order'] = $row['sort_order'];
		
		$data['href'] = $this->url->link('cms/support','path='. ID_SUPPORT .'_' . $row['category_id'] . '&support_id='.$row['support_id']) .'.html';
		
		$des = str_replace('HTTP_CATALOG',HTTP_SERVER,html_entity_decode((string)$row['description']));
		$checkdes = strip_tags($des);
		$data['description'] = !empty($checkdes)?$des:'';
		
		$des = str_replace('HTTP_CATALOG',HTTP_SERVER,html_entity_decode((string)$row['desc_short']));
		$checkdes = strip_tags($des);
		$data['desc_short'] = !empty($checkdes)?$des:'';
		
		preg_match('/<img.+src=[\'"](?P<src>[^\s\'"]*)[\'"].?.*>/i', $data['description'], $image);
		$data['image'] = empty($row['image']) || !is_file($folder_dir . $row['image'])?'': $folder . str_replace(' ', '%20', (string)$row['image']);
		$data['image'] = empty($data['image'])&&isset($image['src'])&& !empty($image['src'])?$image['src']:$data['image'];
		$data['image'] = empty($data['image'])?$img_temp:$data['image'];
		
		$data['pdf'] = empty($row['pdf']) || !is_file(DIR_PDF . $row['pdf'])?'': HTTP_PDF . $row['pdf'];
    
    	//$data['images'] = $this->getImages($data['id']);
    
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
	public function getImages($support_id){
		$query = $this->db->query("SELECT * FROM ".DB_PREFIX."support_image WHERE support_id='".(int)$support_id."' ORDER BY image_sort_order ASC");
		
		$data = array();
		foreach($query->rows as $rs){
			$data1 = array();
			$data1['id'] = $rs['support_image_id'];
			$data1['image'] = empty($rs['image'])?'': HTTP_IMAGE . str_replace(' ', '%20', (string)$rs['image']);
			$data1['image1'] = empty($rs['image1'])? '': HTTP_IMAGE . str_replace(' ', '%20', (string)$rs['image1']);
			
			$data[] = $data1;
		}
		return $data;
	}

	public function getSupportAll($category_id=0) {
		$sql = "SELECT * FROM " . DB_PREFIX . "support p LEFT JOIN " . DB_PREFIX . "support_description pd ON (p.support_id = pd.support_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND pd.name<>'' ORDER BY p.date_modified DESC, p.date_added DESC, p.sort_order ASC, p.support_id DESC";

		$query = $this->db->query($sql);

		return $query->rows;
	}

}
?>
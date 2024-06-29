<?php
class ModelCmsPage extends Model {		
	
	//get Page
	public function getPage($category_id=0)
	{	
		$sql = "SELECT * FROM " . DB_PREFIX . "category p LEFT JOIN " . DB_PREFIX . "category_description pd ON (p.category_id = pd.category_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.category_id = '".(int)$category_id."'"; 
		
		$query = $this->db->query($sql);
		$row = $query->row;
		
		$data['id'] = $row['category_id'];
		$data['template'] = $this->getTemplate($row['template']);
		$data['name'] = $row['name'];
		$data['description'] =  html_entity_decode((string)$row['description']);
		$data['image'] = empty($row['image'])?'': HTTP_IMAGE . $row['image'];
		$data['download'] = $this->getDownloadFile($row['download'],$row['template']);
		$data['video'] = $row['video']; //chu y vao template de xem module video la module gi?
		$data['images'] = $this->getImages($data['id']);
		
		$data['meta_title'] = empty($row['meta_title'])?$row['name']:$row['meta_title'];
		$data['meta_keyword'] = $row['meta_keyword'];
		$data['meta_description'] = $row['meta_description'];
		
		return $data;
	}
	
	public function loadPage($category_id=0)
	{	
		$sql = "SELECT * FROM " . DB_PREFIX . "category p LEFT JOIN " . DB_PREFIX . "category_description pd ON (p.category_id = pd.category_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.category_id = '".(int)$category_id."'"; 
		
		$query = $this->db->query($sql);
		$row = $query->row;
		
		$data['id'] = $row['category_id'];
		$data['name'] = $row['name'];
		$data['description'] =  html_entity_decode((string)$row['description']);
		$data['image'] = empty($row['image'])?'': HTTP_IMAGE . $row['image'];
		//$data['download'] = $this->getDownloadFile($row['download'],$row['template']);
		//$data['video'] = $row['video']; //chu y vao template de xem module video la module gi?
		$data['images'] = $this->getImages($data['id']);
		
		$data['meta_title'] = empty($row['meta_title'])?$row['name']:$row['meta_title'];
		$data['meta_keyword'] = $row['meta_keyword'];
		$data['meta_description'] = $row['meta_description'];
		
		return $data;
	}
	
	public function loadpics($category_id=0)
	{			
		return  $this->getImages($category_id);	
	}
		//Lay hinh dua vao id
	public function getImages($category_id){
		$query = $this->db->query("SELECT * FROM ".DB_PREFIX."category_image WHERE category_id='".(int)$category_id."' ORDER BY image_sort_order ASC");
		
		$data = array();
		foreach($query->rows as $rs){
			$data1 = array();
			$data1['id'] = $rs['category_image_id'];
			$data1['image'] = empty($rs['image'])?'': HTTP_IMAGE . $rs['image'];
			$data1['image1'] = (empty($rs['image1']) || $rs['image1']=='no_image.jpg')? '': HTTP_IMAGE . $rs['image1'];
			
			if(!empty($data1['image1'])){
				list($width, $height) = getimagesize(DIR_IMAGE . $rs['image1']); 
				
				$data1['width'] = $width;
				$data1['height'] = $height;
			}else{
				$data1['width'] = 0;
				$data1['height'] = 0;
			}
			
			$data[] = $data1;
		}
		return $data;
	}	
	
	public function getDownloadFile($download_id,$templates_id){
		//lay template dua vao id
		$sql = "SELECT * FROM " . DB_PREFIX . "templates p LEFT JOIN " . DB_PREFIX . "templates_description pd ON (p.templates_id = pd.templates_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.templates_id = '".(int)$templates_id."'"; 
		
		$query = $this->db->query($sql);
		
		$table = $this->db->escape($query->row['module_download']);
		if(!empty($table)){
			$query_download = $this->db->query("SELECT * FROM " . DB_PREFIX . $table. " p LEFT JOIN " . DB_PREFIX . $table . "_description pd ON (p.".$table."_id = pd.".$table."_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND ".$table."_id = '".(int)$download_id."'"); 
			
			return empty($query_download->row['pdf'])?'':HTTP_PDF . $query_download->row['pdf'];
		}else
		return '';
	}	
	
	private function getTemplate($templates_id){
		$sql = "SELECT filename_mp4 FROM " . DB_PREFIX . "templates p LEFT JOIN " . DB_PREFIX . "templates_description pd ON (p.templates_id = pd.templates_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.templates_id = '".(int)$templates_id."'";

		$query = $this->db->query($sql);
		
		return $query->row['filename_mp4'];
	}
	
}
?>
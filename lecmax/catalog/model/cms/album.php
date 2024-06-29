<?php
class ModelCmsAlbum extends Model {

	//Lay tat ca
	public function getAlbums($category_id=0)	{
		$select_image = "(SELECT GROUP_CONCAT(pi.image,'|',pi.image1,'|',pi.album_image_id,'|',pi.image_name,'|',pi.image_name_en) FROM ".DB_PREFIX."album_image pi WHERE pi.album_id=p.album_id ORDER BY pi.image_sort_order ASC)";
		$sql = "SELECT p.album_id as id, p.image, pd.name, pd.pdf, pd.filepdf, $select_image as images  FROM " . DB_PREFIX . "album p LEFT JOIN " . DB_PREFIX . "album_description pd ON (p.album_id = pd.album_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND pd.name<>'' ORDER BY p.sort_order ASC, p.album_id DESC";
		
		$query = $this->db->query($sql);
		
		return $query->rows;
	}
	
	public function getAlbumByGroup($category_id=0)	{
		$sql = "SELECT * FROM " . DB_PREFIX . "album p LEFT JOIN " . DB_PREFIX . "album_description pd ON (p.album_id = pd.album_id) WHERE p.status='1' AND p.category_id='$category_id' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND pd.name<>'' ORDER BY p.sort_order ASC, p.album_id DESC";

		$query = $this->db->query($sql);
		$data1 = array();

		foreach($query->rows as $row){
			$data = array();
			$data['id'] = $row['album_id'];
			$data['name'] = $row['name'];

			$data['href'] = HTTP_SERVER . 'view-album.html?id='.$row['album_id'];

			$data['description'] = str_replace('HTTP_CATALOG',HTTP_SERVER,html_entity_decode((string)$row['description']));
			$data['image'] = empty($row['image']) || !is_file(DIR_IMAGE . $row['image'])?'': HTTP_IMAGE . str_replace(' ', '%20', (string)$row['image']);
    
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

	/*{FRONTEND_GET_BY_CATE}*/

	/*{FRONTEND_GET_HOME}*/
	//ISHOME
	public function getHome()	{	
		$sql = "SELECT * FROM " . DB_PREFIX . "album p LEFT JOIN " . DB_PREFIX . "album_description pd ON (p.album_id = pd.album_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND pd.name<>'' AND p.ishome='1' ORDER BY p.sort_order ASC, p.album_id DESC LIMIT 10"; 
	
		$query = $this->db->query($sql);
		$data1 = array();
	
		foreach($query->rows as $row){
			$data = array();
			$data['id'] = $row['album_id'];
			$data['name'] = $row['name'];
			$data['image'] = empty($row['image'])?'': HTTP_IMAGE . str_replace(' ', '%20', (string)$row['image']);
			$data['images'] = $this->getImages($data['id']);
			
			$data1[] = $data;
		}
		return $data1;
	}

	//Lay dua vao id
	public function getAlbum($album_id)	{
		$sql = "SELECT * FROM " . DB_PREFIX . "album p LEFT JOIN " . DB_PREFIX . "album_description pd ON (p.album_id = pd.album_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND p.album_id = '" . $album_id . "'";

		$query = $this->db->query($sql);
		$data = array();

		$row = $query->row;

		$data['id'] = $row['album_id'];
		$data['name'] = $row['name'];
		$data['description'] = str_replace('HTTP_CATALOG',HTTP_SERVER,html_entity_decode((string)$row['description']));
		$data['image'] = empty($row['image'])?'': HTTP_IMAGE . str_replace(' ', '%20', (string)$row['image']);
    
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
	public function getImages($album_id){
		$query = $this->db->query("SELECT album_image_id, image, image1, image_name, image_name_en FROM ".DB_PREFIX."album_image WHERE album_id='".(int)$album_id."' ORDER BY image_sort_order ASC");
		
		$data = array();
		foreach($query->rows as $rs){
			$data1 = array();
			$data1['id'] = $rs['album_image_id'];
			$data1['image'] = empty($rs['image']) || !is_file(DIR_IMAGE . $rs['image'])?'':  str_replace(' ', '%20', (string)$rs['image']);
			$data1['image1'] = empty($rs['image1']) || !is_file(DIR_IMAGE . $rs['image1'])? '':  str_replace(' ', '%20', (string)$rs['image1']);
			$data1['name'] = ($this->config->get('config_language_id')==1)?$rs['image_name_en']:$rs['image_name'];
			if(!empty($data1['image'])){
				$data[] = $data1;
			}
		}
		return $data;
	}

	public function getAlbumAll($category_id=0) {
		$sql = "SELECT * FROM " . DB_PREFIX . "album p LEFT JOIN " . DB_PREFIX . "album_description pd ON (p.album_id = pd.album_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND pd.name<>'' ORDER BY p.date_modified DESC, p.date_added DESC, p.sort_order ASC, p.album_id DESC";

		$query = $this->db->query($sql);

		return $query->rows;
	}

}
?>
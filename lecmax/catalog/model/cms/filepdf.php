<?php
class ModelCmsFilepdf extends Model {

	//Lay tat ca
	public function getFilepdfs($category_id=0)	{
		$sql = "SELECT * FROM " . DB_PREFIX . "filepdf p LEFT JOIN " . DB_PREFIX . "filepdf_description pd ON (p.filepdf_id = pd.filepdf_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND pd.name<>'' ORDER BY p.sort_order ASC, p.filepdf_id DESC";
		
		$query = $this->db->query($sql);
		return $query->rows;
		
	}

	//Lay dua vao id
	public function getFilepdf($filepdf_id)	{
		$sql = "SELECT * FROM " . DB_PREFIX . "filepdf p LEFT JOIN " . DB_PREFIX . "filepdf_description pd ON (p.filepdf_id = pd.filepdf_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND p.filepdf_id = '" . $filepdf_id . "'";
		
		$query = $this->db->query($sql);
		
		$data = array();

		$row = $query->row;

		$data['id'] = $row['filepdf_id'];
		$data['name'] = $row['name'];
		$data['link'] = $row['link'];
		
		$data['image'] = empty($row['image']) || !is_file(DIR_IMAGE . $row['image'])?'': str_replace(' ', '%20', (string)$row['image']);
    
    	$data['pdf'] = empty($row['pdf']) || !is_file(DIR_PDF . $row['pdf'])? '' : $row['pdf'];
    
    /*{FRONTEND_DATA_ROW}*/
		return $data;
	}

	/*{FRONTEND_GET_IMAGES}*/

	public function getFilepdfAll($category_id=0) {
		$sql = "SELECT * FROM " . DB_PREFIX . "filepdf p LEFT JOIN " . DB_PREFIX . "filepdf_description pd ON (p.filepdf_id = pd.filepdf_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND pd.name<>'' ORDER BY p.date_modified DESC, p.date_added DESC, p.sort_order ASC, p.filepdf_id DESC";

		$query = $this->db->query($sql);

		return $query->rows;
	}

}
?>